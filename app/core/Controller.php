<?php
	use Form\AttachmentForm;
	use Form\FormCommon;
	load(['AttachmentForm', 'FormCommon'] , APPROOT.DS.'form');

	class Controller
	{	

		protected $_attachmentForm = null;
		protected $_attachmentModel = null;
		protected $_formCommon = null;

		public $data;

		public function __construct()
		{
			if(is_null($this->_attachmentForm)) {
				$this->_attachmentForm = new AttachmentForm();
				$this->_attachmentModel = model('AttachmentModel'); 
			}

			$this->_formCommon = new FormCommon();
			$this->data = [];
			$this->data['whoIs'] = whoIs();
			$this->data['_formCommon'] = $this->_formCommon;
			$this->data['_attachmentForm'] = $this->_attachmentForm;
			$this->data['_global'] = [
				'pageTitle' => isEqual(whoIs('user_type'), USER_HR) ? 'HR' : whoIs('user_type')
			];
			$user = whoIs(); 
			if($user && isEqual($user->user_type , 'admin'))
				$this->is_admin = true;
		}

		public function model($model)
		{
			$model = ucfirst($model);

			if(file_exists(MODELS.DS.$model.'.php')){

				require_once MODELS.DS.$model.'.php';

				return new $model;
			}
			else{

				die($model . 'MODEL NOT FOUND');
			}
		}

		public function loadModels($models)
		{
			foreach($models as $key => $row)
			{
				$model = ucfirst($row);

				if(file_exists(MODELS.DS.$model.'.php')){

					require_once MODELS.DS.$model.'.php';

					$this->$key = new $model;
				}
				else{

					die($model . 'MODEL NOT FOUND');
				}
			}
		}


		public function view($view , $data = [])
		{
			$GLOBALS['data'] = $data;

			$view = convertDotToDS($view);

			extract($data);

            if(file_exists(VIEWS.DS.$view.'.php'))
            {
                require_once VIEWS.DS.$view.'.php';
            }else{
                die("View {$view} does not exists");
            }
		}

		final protected function _loadModel($modelName , $modelInstance)
		{
			$this->$modelInstance = $this->model($modelName);
		}
		public function request()
		{
			if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
				return 'POST';
			return 'GET';
		}


		/**ACCESS */
		final private function access()
		{
			//get user
			if(!Session::check('USER'))
			{
				$allow_acces = [
					'User'=>'login'
				];

				$classes = array_keys($allow_acces);

				if(in_array($this->_class , $classes))
				{
					echo $this->_class;
					// redirect($this->_class[$this->class]);
					// return;
				}else{

				}
			}else{
				$access = $this->set_access();
				$user_type = Session::get('USER')['type'];

				$root = $access[$user_type];
				//check if first instance is *
				if($root[0] != '*')
				{
					if(!in_array(strtolower($this->_class) , $root))
					{
						err_404('UN AUTHORIZE ACCESS');
						return false;
					}
				}
				return true;
			}

		}

		final protected function set_access($user_type)
		{
			$return = FALSE;
			if(Session::check('USER'))
			{
				$auth = Session::get('USER');
				if(is_array($user_type))
				{
					if(in_array($auth['access'], $user_type))
					{
						$return = TRUE;
					}
				}else{
					if($auth['access'] == $user_type)
					{
						$return = TRUE;
					}
				}
			}else{
				$return = FALSE;
			}

			if(!$return)
			{
				err_restrict();
			}
		}

		public function destroy($id)
		{
			$route = $_GET['route'] ?? null;

			if( isset( $this->model ))
			{
				$res = $this->model->deleteByKey([
					'id' => $id
				]);

				if(!$res) {
					Flash::set("Delete failed!");
					return false;
				}

				Flash::set( "Deleted succesfully ");
				if( !is_null($route) )
					return redirect( unseal($route) ); 
				return request()->return();
			}else
			{
				echo die("PRIMARY MODEL not set , name your primary model as 'model'");
			}
		}
	}
