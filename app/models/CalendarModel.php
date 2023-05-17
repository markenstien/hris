<?php 

	class CalendarModel extends Model
	{

		public function __construct()
		{
			$this->session_model = model('SessionModel');
			$this->appointment_model = model('AppointmentModel');
		}


		public function fetchItems()
		{
			$items = [];

			// $sessions = $this->session_model->getAll([
			// 	'order' => 'date_created desc'
			// ]);

			$appointments = $this->appointment_model->getDesc('date' , $this->conditionConvert([
				'status' => [
					'condition' => 'in',
					'value' => ['pending' , 'scheduled']
				]
			]));


			// foreach($sessions as $session) {
			// 	array_push($items , [
			// 		'title' => $session->guest_name,
			// 		'type'  => 'session',
			// 		'date'  => $session->date_created
			// 	]);
			// }

			foreach($appointments as $appointment) {
				array_push($items , [
					'title' => $appointment->reference,
					'type'  => 'appointment',
					'date'  => $appointment->date,
					'id' => $appointment->id
				]);
			}

			return $items;
		}
	}