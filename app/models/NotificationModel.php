<?php 

	class NotificationModel extends Model
	{

		public $table = 'system_notifications';


		public function getAll( $params = [])
		{	
			$where = null;
			$order = null;

			if( isset($params['where']) )
				$where = " WHERE ".$this->conditionConvert($params['where']);

			if( isset($params['order']) )
				$order = " ORDER BY{$params['order']}";

			$this->db->query(
				"SELECT sn.* , snr.recipient_id as recipient_id ,
					concat(user.first_name , ' ' , user.last_name) as recipient_name 
					FROM system_notification_recipients as snr
					
					LEFT JOIN {$this->table} as sn 
					ON snr.notification_id = sn.id

					LEFT JOIN users as user 
					ON user.id = snr.recipient_id 
					{$where} {$order}"
			);

			return $this->db->resultSet();
		}
	}