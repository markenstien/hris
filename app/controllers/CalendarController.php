<?php 

	class CalendarController extends Controller
	{


		public function __construct()
		{
			$this->calendar_model = model('CalendarModel');
		}

		public function index()
		{
			$data = [
				'appointments' => json_encode($this->calendar_model->fetchItems())
			];


			return $this->view('calendar/index' , $data);
		}
	}