<?php 
	class FormInput
	{
		static $formSession = null;

		public static function get($name)
		{
			if(isset($_POST[$name])){
				return $_POST[$name];
			}

			if(isset($_GET[$name])){
				return $_GET[$name];
			}

			if(self::$formSession == null) {
				self::$formSession = FormSession::all();

				FormSession::delete();
			}

			return self::$formSession[$name] ?? null;	
		}

		public static function all()
		{
			return self::$formSession;
		}
	}