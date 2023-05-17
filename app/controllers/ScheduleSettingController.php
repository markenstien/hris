<?php 

	class ScheduleSettingController extends Controller
	{	

		public function __construct()
		{
			$this->model = model('ScheduleModel');
		}

		public function index()
		{
			return $this->update();
		}

		public function update()
		{
			if( isSubmitted() )
			{
				$post = request()->posts();

				$res = $this->model->updateBulk($post['sched']);

				if($res) {
					Flash::set("Scheduled setting updated!");
					return redirect( _route('schedule:update') );
				}else{
					Flash::set(" Something went wrong!");
				}
			}

			$data = [
				'title' => 'Set Schedule',
				'schedules' => $this->model->getSchedules()
			];


			return $this->view('schedule/update' , $data);
		}
	}