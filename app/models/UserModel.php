<?php 

	class UserModel extends Model
	{

		public $table = 'users';

		protected $_fillables = [
			'id',
			'user_code' ,
			'first_name',
			'middle_name',
			'last_name',
			'birthdate',
			'gender',
			'address',
			'phone_number',
			'email',
			'username',
			'password',
			'created_at',
			'created_by',
			'user_type',
			'profile',
			'updated_at',
			'is_verified'
		];

		public function verification($id)
		{
			$user = parent::get($id);

			if($user->is_verified) {
				$this->addError("User is already verified");
				return false;
			}

			parent::update([
				'is_verified' => true
			] , $id);


			$authenticated = $this->authenticate($user->email , $user->password);

			if(!$authenticated){
				$this->addMessage("User Verified");
				$this->redirect_to = _route('auth:login');
			}

			$this->addMessage("User Verified , Welcome to your appointments!");
			$this->redirect_to = _route('appointment:index');
			return true;
		}

		public function save($user_data , $id = null)
		{
			$user_id = $id;

			$fillable_datas = $this->getFillablesOnly($user_data);
			$validated = $this->validate($fillable_datas , $id );

			if(!$validated) return false;

			if(!is_null($id))
			{
				//change password also
				if( empty($fillable_datas['password']) )
					unset($fillable_datas['password']);

				$res = parent::update($fillable_datas , $id);

				$user_id = $id;
				$this->_addRetval('id', $user_id);
			}else
			{
				$fillable_datas['user_code'] = $this->generateCode($user_data['user_type']);
				$fillable_datas['is_verified'] = true;
				$user_id = parent::store($fillable_datas);
				$this->_addRetval('id', $user_id);
			}
			
			return $user_id;
		}


		private function validate(&$user_data , $id = null)
		{	
			if(isset($user_data['email']))
			{
				$is_exist = $this->getByKey('email' , $user_data['email'])[0] ?? '';

				if( $is_exist && !isEqual($is_exist->id , $id) ){
					$this->addError("Email {$user_data['email']} already used");
					return false;
				}
			}

			if(isset($user_data['username']))
			{
				$is_exist = $this->getByKey('username' , $user_data['username'])[0] ?? '';

				if( $is_exist && !isEqual($is_exist->id , $id) ){
					$this->addError("Username {$user_data['email']} already used");
					return false;
				}
			}

			if(isset($user_data['phone_number']))
			{
				$user_data['phone_number'] = str_to_mobile($user_data['phone_number']);

				if( !is_mobile_number($user_data['phone_number']) ){
					$this->addError("Invalid Phone Number {$user_data['phone_number']}");
					return false;
				}

				$is_exist = $this->getByKey('phone_number' , $user_data['phone_number'])[0] ?? '';

				if( $is_exist && !isEqual($is_exist->id , $id) ){
					$this->addError("Phone Number {$user_data['phone_number']} already used");
					return false;
				}
			}

			return true;
		}

		public function create($user_data , $profile = '')
		{

			$res = $this->save($user_data);


			if(!$res) {
				$this->addError("Unable to create user");
				return false;
			}


			if(!empty($profile) )
				$this->uploadProfile($profile , $res);

			$this->addMessage("User {$user_data['first_name']} Created");
			return $res;
		}

		public function register($user_data , $profile = '')
		{
			$res = $this->create($user_data , $profile);

			if(!$res)
				return false;

			//create user-verification-link //send-to-email
			//seal user-id
			$_href = URL.DS._route('user:verification' , seal($res));
			$_anchor = "<a href='{$_href}'>clicking this link</a>";

			$email_content = <<<EOF
				<h3> User Verification </h3>
				<p> Thank you for registering on out platform , 
					Verify your Registration by <br/>{$_anchor}</p>
			EOF;

			$email_body = wEmailComplete($email_content);

			// _mail($user_data['email'] , "Verify Account" , $email_body);

			return $res;
		}

		public function uploadProfile($file_name , $id)
		{
			$is_empty = upload_empty($file_name);

			if($is_empty){
				$this->addError("No file attached upload profile failed!");
				return false;
			}

			$upload = upload_image($file_name, PATH_UPLOAD);
			
			if( !isEqual($upload['status'] , 'success') ){
				$this->addError(implode(',' , $upload['result']['err']));
				return false;
			}

			//save to profile

			$res = parent::update([
				'profile' => GET_PATH_UPLOAD.DS.$upload['result']['name']
			] , $id);

			if($res) {
				$this->addMessage("Profile uploaded!");
				return true;
			}
			$this->addError("UPLOAD PROFILE DATABASE ERROR");
			return false;
		}

		public function update($user_data , $id)
		{
			$res = $this->save($user_data , $id);

			//check muna if doctor


			if(!$res) {
				$this->addError("Unable to create user");
				return false;
			}

			$this->addMessage("User {$user_data['first_name']} has been updated!");

			return true;
		}

		public function get($id)
		{
			$user = $this->getAll([
				'where' => [
					'user.id' => $id
				]
			])[0] ?? false;

			if(!$user) {
				$this->addError("No User");
				return false;
			}
			return $user;
		}

		public function getByKey($column , $key , $order = null)
		{
			if( is_null($order) )
				$order = $column;

			return parent::getAssoc($column , [
				$column => "{$key}"
			]);
		}


		public function getAll($params = [])
		{
			$where = null;
			$order = null;

			if(!empty($params['where'])) {
				$where = " WHERE ".parent::conditionConvert($params['where']);
			}

			if(!empty($params['order'])) {
				$order = " ORDER BY {$params['order']}";
			}
			
			$this->db->query(
				"SELECT user.*,ed.*, user.id as id,
					position.attr_name as position_name,
					position.attr_abbr_name as position_abbr,
					department.attr_name as department_name,
					department.attr_abbr_name as department_abbr

					from {$this->table} as user
					LEFT JOIN employment_details as ed on 
					ed.user_id = user.id

					LEFT JOIN employment_attributes as position
					ON position.id = ed.position_id

					LEFT JOIN employment_attributes as department
					ON department.id = ed.department_id

					{$where} {$order}"
			);

			return $this->db->resultSet();
		}

		public function getFilesAndFolders( $id )
		{
			$folder = model('FolderModel');
			$file = model('FileModel');

			/*
			*Folders
			*/
			$folders = $folder->fetchWithFiles([
				'meta_id'   => $id,
				'meta_key'  => 'EMPLOYEE_FILE',
			]);

			$files = $file->fetchFiles([
				'meta_id' => $id,
				'meta_key' => 'EMPLOYEE_FILE',
				'folder_id' => 0
			]);

			return compact([
				'folders',
				'files'
			]);
		}

		public function generateCode($user_type)
		{
			$pfix = null;

			switch(strtolower($user_type))
			{
				case 'admin':
					$pfix = 'ADMN';
				break;

				case 'patient':
					$pfix = 'CX';
				break;

				case 'doctor':
					$pfix = 'DOC';
				break;
			}

			$last_id = $this->last()->id ?? 000;

			return strtoupper($pfix.get_token_random_char(4).$last_id);
		}


		public function authenticate($email , $password)
		{
			$errors = [];

			$user = parent::single(['email' => $email]);

			if(!$user) {
				$errors[] = " Email '{$email}' does not exists in any account";
			}

			if(!isEqual($user->password ?? '' , $password)){
				$errors[] = " Incorrect Password ";
			}

			if(!empty($errors)){
				$this->addError( implode(',', $errors));
				return false;
			}

			if( !$user->is_verified){
				$this->addError("Verify your account to access " . COMPANY_NAME . " Platform");
				return false;
			}

			return $this->startAuth($user->id);
		}

		/*
		*can be used to reset and start auth
		*/
		public function startAuth($id)
		{
			$user = $this->get($id);

			if(!$user){
				$this->addError("Auth cannot be started!");
				return false;
			}

			$auth = null;

			while(is_null($auth))
			{
				Session::set('auth' , $user);
				$auth = Session::get('auth');
			}

			return $auth;
		}

	}