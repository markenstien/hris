<?php

	class Bootstrap{

		private $current_controller = BASECONTROLLER;
		private $current_method = BASEMETHOD;
		private $params = []; //parameters of the request to be passed on the functions

		public function __construct()
		{
			$this->url = $this->getURL();

			if(isset($this->url[0])) {
				$is_app = $this->isExtension($this->url[0]);

				if($is_app) {
					$this->loadExtension();
				}else{
					$this->loadApp();
				}
			}else{
				require_once(CNTLRS.DS.$this->current_controller.'.php');
							
				$this->current_controller = new $this->current_controller;

				$this->current_method = $this->current_method;

				call_user_func_array([$this->current_controller , $this->current_method] , $this->params);
			}
		}

		private function getURL(){

			if(isset($_GET['url'])){

				$url = $_GET['url']; $url = rtrim($url , '/');

	            $url = filter_var($url , FILTER_SANITIZE_URL); 
	            $url = explode('/',$url);

	            return $url;
			}

			else{
				return FALSE;
			}
		}

		private function isExtension($controller)
		{
			$apps = array_keys(APP_EXTENSIONS);


			if(in_array( $controller , $apps))
				return TRUE;
			return FALSE;
		}

		private function loadExtension()
		{
			$url = $this->url;
			$this->appExtension = strtolower($url[0]);

			unset($url[0]);
			$this->url = $url;

			$this->appExtensionController();

			$this->appExtensionMethod();
		}
		private function appExtensionController()
		{
			$url = $this->url;
			$appExtension = $this->appExtension;

			if(!isset($url[1])){
				$controller = ucfirst(APP_EXTENSIONS[$appExtension]['base_controller']);
				$this->current_controller = APP_EXTENSIONS_PATH.DS.$appExtension.DS.'controllers'.DS.$controller.'.php';
				unset($url[1]);
			}else{
				$controller = ucfirst($url[1]);
				$this->current_controller = APP_EXTENSIONS_PATH.DS.$appExtension.DS.'controllers'.DS.$controller.'.php';
				unset($url[1]);
			}

			$this->url = $url; //resetting url
			require_once $this->current_controller;

			$this->current_controller = new $controller;
		}

		private function appExtensionMethod()
		{
			$controller = $this->current_controller;

			$appExtension = $this->appExtension;
			
			$url          = $this->url;
			/*CHECK IF METHOD EXISTS*/
			if(!isset($url[2])) {
				$method = APP_EXTENSIONS[$appExtension]['base_method'];
			}
			else{
				$method = ucfirst($url[2]);
				unset($url[2]);
			}
			
			/*CHECK IF METHOD IS SET*/
			if (method_exists($this->current_controller, 
			$this->cleanMethod( strtolower($method) ) )){	
				$this->current_method = $this->cleanMethod($method);
			}else{
				err_lost("Action doesnt exists");
			}

			$this->params = $url ? array_values($url) : [];

			$this->init();
		}



		public function loadApi( $type = 'API')
		{
			$url = $this->url;

			$path = API;

			if( isEqual($type , 'cron')) 
				$path = APPROOT.DS.'cron';

			if(isset($url[1])){

				if(file_exists( $path.DS.ucfirst($url[1]).'.php' )){
					$this->current_controller = ucfirst($url[1]);
					unset($url[1]);
				}

				require_once($path.DS.$this->current_controller.'.php');

				$this->current_controller = new $this->current_controller;
			}

			if(isset($url[2])){

				if (method_exists($this->current_controller, $this->cleanMethod(strtolower($url[2]))))
				{	
					$this->current_method = $this->cleanMethod($url[2]);
					unset($url[2]);
				}
			}
			
			$this->params = $url ? array_values($url) : [];

			call_user_func_array([$this->current_controller , $this->current_method] , $this->params);
		}

		
		public function loadApp()
		{
			$url = $this->url;

			if( isEqual($url[0] , ['API' , 'CRON']))
				return $this->loadApi($url[0] );

			if(isset($url[0])){

				if(file_exists( CNTLRS.DS.ucfirst($url[0]).'.php' )){

					$this->current_controller = ucfirst($url[0]);
					unset($url[0]);
				}


				require_once(CNTLRS.DS.$this->current_controller.'.php');

				$this->current_controller = new $this->current_controller;
			}

			if(isset($url[1])){

				if (method_exists($this->current_controller, $this->cleanMethod(strtolower($url[1]))))
				{	
					$this->current_method = $this->cleanMethod($url[1]);
					unset($url[1]);
				}
			}
			
			$this->params = $url ? array_values($url) : [];

			call_user_func_array([$this->current_controller , $this->current_method] , $this->params);
		}


		private function init()
		{
			call_user_func_array([$this->current_controller , $this->current_method] , $this->params);
		}
		private function cleanMethod($method)
		{	
			$method = explode('-' , $method);
			
			$n_method = $method[0];
			
			for($i = 0 ; $i < count($method) ; $i++)
			{
				if($i == 0)
				{
					continue;
				}else
				{
					$n_method .= ucfirst($method[$i]);
				}
			}

			return $n_method;
		}
	}