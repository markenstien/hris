<?php 	

	class Debugger
	{
		public static function log($log)
		{
			if(!isset($_SESSION['debugger'])) {

				$_SESSION['debugger'] = [];
			}

			$debugs = $_SESSION['debugger'];

			array_push($debugs, $log);
		}


		public static function show_logs()
		{	
			$logs = $_SESSION['debugger'] ?? '';

			if(!empty($logs)){
				dd($logs);
			}

			unset($_SESSION['debugger']);
		}
	}