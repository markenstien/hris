<?php

	use Form\TimesheetForm;
	load(['TimesheetForm'], FORMS);

	class DashboardController extends Controller
	{
		public $userModel,$timesheetForm,$timesheetModel,$eeRequirementModel;
		public function __construct()
		{
			parent::__construct();
			$this->userModel = model('UserModel');
			$this->timesheetModel = model('TimesheetModel');
			$this->timesheetForm = new TimesheetForm();
			$this->eeRequirementModel = model('EmployeeRequirementModel');
		}

		public function index()
		{
			$lastLog = $this->timesheetModel->getLastLog($this->data['whoIs']->id);
			$this->data['form'] = $this->timesheetForm;
			$this->data['lastLog'] = $lastLog;

			if(!$lastLog) {
				$isLoggedIn = false;
			} else {
				$isLoggedIn = is_null($lastLog->time_out) ? true : false;
			}
			$this->data['isLoggedIn'] =  $isLoggedIn;

			$this->data['trainings'] = $this->eeRequirementModel->getAll();
			// return $this->view('calendar/index' , $data);
			return $this->view('dashboard/index', $this->data);
		}
	}