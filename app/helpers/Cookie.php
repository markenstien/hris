<?php 	

	class Cookie
	{

		public static $prefix = '_KDK_SUPA_COOKIE_';

		public static function set($name , $value)
		{

			$cookieName = strtoupper(self::$prefix.$name);

			setcookie($cookieName, $value, time() + (86400 * 30), "/");

			return $_COOKIE[$cookieName];
		}


		public static function get($name)
		{
			$cookieName = strtoupper(self::$prefix.$name);

			if(!isset($_COOKIE[$cookieName]))
				return '';
			return $_COOKIE[$cookieName];
		}


		public static function remove($name)
		{
			$cookieName = strtoupper(self::$prefix.$name);
			setcookie($cookieName, "", time() - 3600);
			return true;
		}
	}