<?php
	class Request
	{
		private static $instance = null;

		public static function getInstance()
		{
			if(self::$instance == null) {
				self::$instance = new Request();
			}

			return self::$instance;
		}

		public function __construct()
		{
			$this->request = $_REQUEST;
			$this->method  = $_SERVER['REQUEST_METHOD'];

			$this->runTimeVars = [
				'url' , 'csrftoken' , 'phpsessid' , '_kdk_supa_cookie_dataprivacy'
			];
		}
		
		public function method()
		{
			return $this->method;
		}



		public function posts()
		{

			$this->is_post(); // for valdiation

			$fields = [];

			foreach($_POST as $key => $row) 
			{
				if( in_array(strtolower($key) , $this->runTimeVars ))
					continue;

				$fields[$key] = $row;
			}

			return $fields;
		}

		public function post($name)
		{
			$this->is_post(); // for valdiation

			$method = $this->method;

			if(isset($_POST[$name]))
				return $_POST[$name];
			return '';
		}

		public function get($name = null)
		{
			$request = $_GET;

			$fields = [];

			foreach($request as $key => $row) {
				if( isEqual($key , 'url')){
					continue;
				}elseif( isEqual($key , 'csrf') ){
					continue;
				}else{
					$fields[$key] = $row;
				}
			}

			if(is_null($name)){
				return $fields;
			}else{
				return $fields[$name];
			}
		}

		public function is_post()
		{
			$method = $this->method;

			if(strtolower($method) === 'post')
				return true;
			return false;
		}


		public function inputs()
		{
			$request = $this->request;

			$fields = [];

			foreach($request as $key => $row) 
			{
				if( in_array(strtolower($key) , $this->runTimeVars ))
					continue;
				$fields[$key] = $row;
			}

			return $fields;
		}

		public function input($name)
		{
			$method = $this->method;

			switch(strtolower($method))
			{
				case 'post':
					if(isset($_POST[$name]))
						return $_POST[$name];
				break;

				case 'get':
					if(isset($_GET[$name]))
						return $_GET[$name];
				break;
			}
		}

		public function url()
		{
			$url = $this->request['url'];

			return $url;
		}

		public function referrer()
		{
			return $_SERVER['HTTP_REFERER'] ?? '';
		}

		public function return(){
      FormSession::getInstance();
			header("Location:".$this->referrer());
    }

        public function returnWithVal($params)
        {
            $referer = $this->referrer();
            dd("$referer RETURN WITH DATA");
        }

        public function returnFresh()
        {
            header("Location:".$this->referrer());
        }
	}
