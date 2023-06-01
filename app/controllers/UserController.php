<?php
	load(['UserForm', 'EmployementForm'] , APPROOT.DS.'form');
	use Form\UserForm;
	use Form\EmployementForm;

	class UserController extends Controller
	{
		private $_form;
		private $_employmentForm;
		
		protected $employmentModel,$governmentIDModel,
		$model,$scheduleModel, $eeRRModel,$leavePointModel;


		public function __construct()
		{
			parent::__construct();
			$this->_form = new UserForm('form_user');
			$this->_employmentForm = new EmployementForm();
			$this->model = model('UserModel');
			$this->employmentModel = model('EmploymentModel');
			$this->governmentIDModel = model('GovernmentIDModel');
			$this->scheduleModel = model('ScheduleModel');
			$this->eeRRModel = model('EmployeeRequirementRespondentModel');
			$this->leavePointModel = model('LeavePointModel');
			
			$this->data['_form'] = $this->_form;
		}

		public function verification($user_id_sealed)
		{
			$user_id = unseal($user_id_sealed);

			$res = $this->model->verification($user_id);

			if($res) {
				Flash::set( $this->model->getMessageString() );
				return redirect( $this->model->redirect_to );
			}

			Flash::set( $this->model->getErrorString() , 'danger');
			return redirect( _route('user:register') );
		}

		public function register()
		{	

			$req = request()->inputs();

			//if who is logged in then logout
			if(whoIs()) {
				session_destroy();
			}

			if(isSubmitted())
			{
				$post = request()->posts();

				//check if backer_user_code is not empty

				if(!empty($post['backer_user_code'])) {

					$backer = $this->model->single(['user_code' => $post['backer_user_code']]);

					if(!$backer) {
						Flash::set("Invalid Referral Code");
						return request()->return();
					}

					$post['backer_id'] = $backer->id;
				}

				$res = $this->model->register($post , 'profile');

				Flash::set( $this->model->getMessageString().  " Please Check your email '{$post['email']}' and verify your account. ");

				if(!$res) {
					Flash::set( $this->model->getErrorString() , 'danger');
					return request()->return();
				}

				return redirect(_route('auth:login'));
			}

			$this->_form->init([
				'url' => _route('user:register')
			]);

			if(isset($req['backer_id'])) {
				$backerData = unseal($req['backer_id']);
				//check from user
				$user = $this->model->single([
					'id' => $backerData[1]
				]);

				if($user && isEqual($user->user_code, $backerData[0])) {
					$backerData = $user;

					//add to form
					$this->_form->add([
						'name' => 'backer_id',
						'type' => 'hidden',
						'value' => $user->id
					]);

					$this->_form->add([
						'name' => 'backer_name',
						'type' => 'text',
						'value' => $user->first_name . ' '.$user->last_name,
						'class' => 'form-control',
						'options' => [
							'label' => 'Referrer Name'
						],
						'attributes' => [
							'readonly' => true
						]
					]);
				}
			} else {
				$this->_form->add([
					'name' => 'backer_user_code',
					'type' => 'text',
						'value' => '',
						'class' => 'form-control',
						'options' => [
							'label' => 'Referrer Code (if any)'
						],
				]);
			}
			

			$this->_form->setValue('submit' , 'Register');
			$this->_form->remove('user_type');
			$this->_form->add([
				'type' => 'hidden',
				'value' => 'patient',
				'name'  => 'user_type'
			]);
			
			$data = [
				'title' => 'User Registration',
				'form'  => $this->_form,
				'backerData' => $backerData ?? false
			];

			return $this->view('user/register' , $data);
		}

		public function index()
		{
			$req = request()->inputs();
			$userType = $req['user_type'] ?? 'employee';

			if(isEqual($userType,'employee')) {
				$users = $this->model->getAll([
					'where' => [
						'user_type' => 'employee'
					]
				]);
			} else {
				$users = $this->model->getAll([
					'where' => [
						'user_type' => [
							'condition' => 'not equal',
							'value' => 'employee'
						]
					]
				]);
			}
			
			$data = [
				'users' => $users,
				'title' => 'Users',
				'userType' => $userType
			];

			$data = array_merge($data, $this->data);
			return $this->view('user/index' , $data);
		}

		public function create()
		{
			$req = request()->inputs();
			$userType = $req['user_type'] ?? 'employee';

			if(isSubmitted()) {
				$post = request()->posts();

				$post['is_verified'] = true;

				if(empty($post['password']) || strlen($post['password'] < 4)) {
					Flash::set("Password length must be alteast 4 characters long");
					return request()->return();
				}
				$res = $this->model->create($post , 'profile');

				//create user is an employee
				if($res && $post['employment_date']) {
					$this->employmentModel->create([
						'employment_date' => $post['employment_date'],
						'reports_to' => $post['reports_to'],
						'salary_per_month' => $post['salary_per_month'],
						'user_id' => $this->model->_getRetval('id')
					]);

					$this->governmentIDModel->_createRecord($this->model->_getRetval('id'));
				}
				Flash::set( $this->model->getMessageString());

				if(!$res) {
					Flash::set( $this->model->getErrorString() , 'danger');
					return request()->return();
				}

				return redirect(_route('user:index'));
			}
		
			$data = [
				'title' => 'Create User',
				'form'  => $this->_form,
				'employmentForm' => $this->_employmentForm
			];
			if(!isEqual($userType,'employee')) {
				return $this->view('user/create_staff_admin', $data);
			} else {
				return $this->view('user/create' , $data);
			}
		}


		public function edit($id)
		{

			if(isSubmitted())
			{
				$post = request()->posts();
				

				if(!upload_empty('profile')) {
					//apply change picture
					$response = $this->_attachmentModel->upload([
						'display_name',
						'label' => 'profile',
						'global_key' => 'USER_PROFILE_PICTURE',
						'global_id' => $id
					], 'profile');

					if($response) {
						$responseData = $this->_attachmentModel->_getRetval('file_data_array');
						$post['profile'] = $responseData['full_url'];
						
					}
				}

				$userUpdate = $this->model->save($post , $id);

				if(isset($post['profile']) && $userUpdate) {
					$this->model->startAuth($id);
				}

				$employementUpdate = $this->employmentModel->update([
					'department_id' => $post['department_id'],
					'position_id' => $post['position_id'],
					'employment_date' => $post['employment_date'],
					'reports_to' => $post['reports_to'],
					'salary_per_month' => $post['salary_per_month'],
					'salary_per_day' => $post['salary_per_day']
				], $post['employment_detail_id']);

				if($userUpdate && $employementUpdate) {
					Flash::set( "User updated!");
					return redirect( _route('user:show' , $id));
				}else{
					Flash::set( $this->model->getErrorString() );
				}
			}

			$user = $this->model->get($id);
			$this->_form->setUrl(_route('user:edit' , $id));
			$this->_form->addId($id);
			$this->_form->setValueObject($user);

			$employment = $this->employmentModel->getByUser($id);

			$this->_employmentForm->setValueObject($employment);
			
			$this->_employmentForm->add([
				'type' => 'hidden',
				'name' => 'employment_detail_id',
				'value' => $employment->id
			]);

			$data = [
				'title' => 'Create User',
				'form'  => $this->_form,
				'user'   => $user,
				'employmentForm' => $this->_employmentForm,
				'employment' => $employment
			];

			return $this->view('user/edit' , $data);
		}

		public function profile()
		{
			return $this->show( whoIs('id') );
		}

		public function show($id)
		{
			$req = request()->inputs();
			$user = $this->model->get($id);

			$employment = $this->employmentModel->getSingle([
				'where' => [
					'user_id' => $id
				]
			]);

			$governmentIDs = $this->governmentIDModel->all(['user_id' => $id]);

			$data = [
				'user' => $user,
				'employment' => $employment,
				'governmentIDs' => $governmentIDs,
				'employmentForm' => $this->_employmentForm
			];

			if(!isset($_GET['folder']))
			{
				$filesAndFolders = $this->model->getFilesAndFolders($id);
				$data['filesAndFolders'] = $filesAndFolders;
			}else
			{
				$folderModel = model('FolderModel');
				$folderFilesAndFolders = $folderModel->get($_GET['folder']);
				$data['folderFilesAndFolders'] = $folderFilesAndFolders;
			}
			
			$data['schedule'] = $this->scheduleModel->getByUser($id);
			$data['scheduleToday'] = $this->scheduleModel->getToday($id);
			$data['certificates'] = $this->eeRRModel->getAll([
				'where' => [
					'eerr.user_id' => $id
				]
			]);
			
			$this->data = array_merge($data, $this->data);

			if(isEqual($user->user_type, 'employee')) {
				$leavePoint = $this->leavePointModel->getTotalByUser($id);
				$leavePointArray = [];

				foreach($leavePoint as $lpKey => $lpRow) {
					$leavePointArray[$lpRow->leave_point_category] = $lpRow->total_point;
				}
				$this->data['leavePoint'] = $leavePoint;
				$this->data['leavePointArray'] = $leavePointArray;

				//temporary

				$this->data['underlings'] = $this->employmentModel->getUnderlings($id);
				return $this->view('user/show', $this->data);
			} else {
				return $this->view('user/show_staff_admin', $this->data);
			}
		}

		public function sendAuth()
		{
			if(isSubmitted())
			{
				$post = request()->posts();


				$user = $this->model->get( $post['user_id'] );

				$recipients = explode(',' , $post['recipients']);

				$content = pull_view('tmp/emails/user_auth_email_view_tmp' , [
					'user' => $user,
					'system_name' => COMPANY_NAME
				]);

				_mail($recipients , "User Auth" , $content);

				_notify_operations("Account details has been sent, recipients {$post['recipients']} ");

				Flash::set("Auth has been sent");

				return request()->return();
			}
		}

		public function referrral() {

			$req = request()->inputs();
			/*registration with backer*/
		}




			
	}