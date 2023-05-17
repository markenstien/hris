<?php 	

	class Render
	{
		public static function html($functionname , $data = null , $asprops = false)
		{
			if(function_exists($functionname)){

				if($asprops) {
					call_user_func(self::clean($functionname) , ...$data);
				}else{
					call_user_func(self::clean($functionname) , $data);
				}
				
			}else{
				die('TEMPLATE DOES NOT EXISTS');
			}
		}


		public static function clean($function)
		{
			return trim($function);
		}
	}