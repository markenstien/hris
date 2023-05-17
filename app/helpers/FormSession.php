<?php 	
	class FormSession
	{
		private static $instance = null;

		public static function getInstance()
		{
			if(self::$instance == null){
				self::$instance = new FormSession;
			}

			return self::$instance;
		}

		public function __construct()
		{
			$fields = request()->inputs();

			$this->set($fields);
		}

		public static function get($name)
		{
			$fields = Session::get("formFields");

			return $fields[$name];
		}

		public static function all()
		{
			return Session::get("formFields");
		}


		public static function delete()
		{
			Session::remove('formFields');
		}
		private function set($fields)
		{
			Session::set("formFields" , $fields);
		}
	}