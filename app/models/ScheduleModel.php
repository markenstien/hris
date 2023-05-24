<?php 	

	class ScheduleModel extends Model
	{
		public $table = 'schedules';


		public function newSchedule($values)
		{
			$sql = "INSERT INTO $this->table(user_id , day , time_in , time_out , is_off) VALUES ";

			$schedules = $values['schedules'];
			$userId = $values['user_id'];


			if($this->getByUser($userId)){
				$this->addError("User Already has schedule");
				return false;
			}

			foreach( $schedules as $row => $schedule)
			{
				if($row > 0)
					$sql .= ',';

				$sql .= " ('{$userId}','{$schedule['day']}' , '{$schedule['time_in']}' , '{$schedule['time_out']}' , '{$schedule['rd']}') ";
			}

			$this->db->query($sql);

			return $this->db->insert();
		}

		public function getByUser($userId)
		{
			$schedule = parent::all([
				'user_id' => $userId
			]);

			return $schedule;
		}

		/*
		*get user schedule today
		*/
		public function getToday($userId)
		{
			$todayDayName = date('l'); //today day name

			$schedule = parent::single([
				'day' => $todayDayName,
				'user_id' => $userId
			]);

			return $schedule;
		}
	}