<?php 

	class ScheduleModel extends Model
	{
		public $table = 'schedule_setting';

		public function create($schedule_data)
		{

		}

		public function getSchedules()
		{
			return parent::getAssoc('id');
		}

		public function updateBulk($schedules)
		{
			$res = false;

			foreach($schedules as $key_or_id => $sched) {
				$res = parent::update($sched , $key_or_id);
			}

			return $res;
		}

		public function getByAppointmentByDay($day)
		{
			return parent::single([
				'day' => $day
			]);
		}
	}