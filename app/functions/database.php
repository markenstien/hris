<?php 	

	function db_get_user($userId)
	{
		$db = Database::getInstance();

		$tableUser  = DB_PREFIX.'users';
		$tablePersonal  = DB_PREFIX.'personal';

		$db->query(
			"SELECT user.* , personal.* , user.id as id 
				FROM $tableUser as user 

				LEFT JOIN $tablePersonal as personal
				ON user.id = personal.user_id

				WHERE user.id = {$userId} "
		);

		return $db->single();
	}