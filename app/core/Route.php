<?php 	

	class Route
	{
		private static $routes = null;

		public static function fetchRoutes()
		{
			if( is_null(self::$routes) )
				self::$routes = require_once(APPROOT.DS.'routes/web.php');

			return self::$routes;
		}
	}