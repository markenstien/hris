<?php 
	/**
	 * model to calculate
	 * timelogs and save to timesheet
	 * */
	class TimesheetModel extends Model
	{
		public $table = 'hr_time_sheets';

		public $_fillables = [
			'user_id',
			'amount',
			'duration',
			'time_in',
			'time_out',
			'remarks',
			'status'
		];

		private static $WORK_HOURS_TOTAL_TODAY = 'WORK_HOURS_TOTAL_TODAY';
		public static $CLOCKED_IN = 'logged in';
		public static $CLOCKED_OUT = 'logged out';

		//fill n runtime
		private $action , $user , $workData;
        public $user_meta_model, $user_model, $timesheet;

		public function __construct()
		{
			parent::__construct();

			$this->user_meta_model = model('UserMetaModel');
			$this->user_model = model('UserModel');
		}

		/**
		 * log read user if 
		 * log-in or log-out
		 * */
		public function log($userId)
		{
			$this->userMeta = $this->user_meta_model->getByUserid($userId);
			$this->user = $this->user_model->get($userId);
			$this->userId = $userId;
			/*
			*check if user is currently clocked in
			*/
			$this->last = $this->getLastLog($userId);

			if (!empty($this->last) && is_null($this->last->time_out)) {
				/*
				*currently logged in then do log-out
				*/
				$this->action = self::$CLOCKED_OUT;
				return $this->clockOut($userId);
			} else {
				$this->action = self::$CLOCKED_IN;
				return $this->clockIn($userId);
			}
		}

		public function getLastLog($userId)
		{
			return parent::single([
				'user_id' => $userId
			] , '*' , 'id desc');
		}

		public function logType($log)
		{	
			if(!$log)
				return self::$CLOCKED_OUT;
			if(is_null($log->time_out))
				return self::$CLOCKED_IN;
			return self::$CLOCKED_OUT;
		}

		private function clockIn($userId, $clockInType = 'web_manual')
		{
			$dateTime = nowMilitary();
            $schedule = mGetSchedule($userId);
			
			//check if schedule is today
			if ($schedule) {
				if ($schedule->is_off) {
                    $this->addError(" Today is your day off");
                    return false;
                }
			}

			return parent::store([
				'user_id' => $userId,
				'time_in' => $dateTime,
				'type' => $clockInType,
				'status' => 'pending',
				'created_at' => whoIs('id')
			]);
		}

		private function clockOut($userId)
		{
			$remarks = [];
			// $this->last;
			$dateToday = nowMilitary();
			$lastTimeIn = $this->last->time_in;
			/**
			 * special logout
			 * for daily basis worker
			 */
			$userData = $this->user_model->get($userId);
			//compute work hours
			$totalWorkHoursInMinutes = timeDifferenceInMinutes($lastTimeIn, $dateToday);
			$amountTotal = ($userData->salary_per_day / 8) * ($totalWorkHoursInMinutes / 60);

			$timesheetData = [
				'time_out' => $dateToday,
				'duration' => $totalWorkHoursInMinutes,
				'amount'   => $amountTotal,
				'remarks'  => 'for-approval',
				'updated_at' => $dateToday,
			];

			return parent::update($timesheetData, $this->last->id);
		}

		/*
        *Workhours today is already in minutes
        *maxwork hours is in hour format
        *ALl datas are returned in minutes
        *workHoursRendered : in minutes
        */
        private function workTimeData($workHoursRendered, $maxWorkHours, $workHoursToday)
        {
            //in minutes
            $workHoursMax = hoursToMinutes($maxWorkHours);
            //in minutes
            $allowedWorkHours = $workHoursMax - $workHoursToday;
            //initialy set valid work hours
            $validWorkHours = $workHoursRendered;
            $flushedWorkHours = 0;

            $flushedMsg = '';

            if($workHoursRendered >= $allowedWorkHours)
            {
                //if the work hours surpass the valid work hours
                //then set the valid work hours
                $validWorkHours = $allowedWorkHours;
                //get the flushed workhours or the thank you! time rendered
                $flushedWorkHours = $workHoursRendered - $validWorkHours;
                if($flushedWorkHours != 0)
                    $flushedMsg = 'flushed work hours '.minutesToHours($flushedWorkHours).' due to your max work hours is only '.minutesToHours($maxWorkHours);
            }

            $returnData = [
                'maxWorkHours' => $workHoursMax,
                'workHoursToday' => $workHoursToday,
                'validWorkHours' => $validWorkHours,
                'flushed' => [
                    'hours' => $flushedWorkHours,
                    'msg'   => $flushedMsg
                ]
            ];
			$this->workData = $returnData;
            return $returnData;
        }


        public function getWorkHours($type = 'default' , $userId = null)
        {
        	$dateToday = nowMilitary();
        	$retVal = null;
        	//default query
        	$sql = "SELECT tlog.user_id as user_id , sum(duration) as work_hours,
        		user.username as username, concat(user.first_name , ' ' ,user.last_name) as fullname
        		FROM {$this->table} as tlog
        		LEFT JOIN users as user 
        		ON user.id = tlog.user_id";

        	switch($type)
        	{
        		case self::$WORK_HOURS_TOTAL_TODAY:
        			$sql .= " WHERE date(tlog.created_at) = date('{$dateToday}')";
        		break;
        	}

        	if (!isEqual($type,'default') && !is_null($userId)) 
        		$sql .= " AND tlog.user_id = '{$userId}' ";

        	$sql .= " GROUP BY tlog.user_id ORDER BY user.first_name asc";



        	$this->db->query($sql);
        	return $this->db->resultSet();
        }

        public function getWorkHoursByUser($userId , $type = 'default')
        {
        	$workHours = $this->getWorkHours($type , $userId);

        	if(!empty($workHours))
        		return $this->workHours[0]->work_hours ?? 0;

        	return false;
        }

		public function getClockedInUsers($params = [])
		{
			$where = null;
			if (isset($params['where']) && !empty($params['where']['branch_id'])) {
				$where = ' WHERE '. parent::convertWhere($params['where']);
				$where .= " AND ";
			} else {
				$where = " WHERE ";
			}
			
			$where .= " clock_out_time IS NULL
			AND user.is_deleted = false ";
			$dateNow = today();

			$this->db->query(
				"SELECT tklog.* , user.username as username , 
					concat(user.firstname , ' ' , user.lastname) as fullname,
					max_work_hours,work_hours,branch_id, branch.branch as branch_name,
					ifnull(total_work_hours.total_duration ,0) as total_duration

					FROM {$this->table} as tklog 
					
					LEFT JOIN users as user 
					ON user.id = tklog.user_id

					LEFT JOIN user_meta
					ON user.id = user_meta.user_id

					LEFT JOIN branches as branch
					ON branch.id = user.branch_id

					LEFT JOIN (
						SELECT sum(duration) as total_duration,
						user_id
						FROM hr_time_sheets
						WHERE date(time_in) = '{$dateNow}'
						GROUP BY user_id
					) as total_work_hours
					ON total_work_hours.user_id = user.id
					{$where}
					ORDER BY user.firstname asc"
			);

			return $this->db->resultSet();
		}

		public function getClockedOutUsers($params = [])
		{
			$users = $this->getClockedInUsers($params);

			$branch_id = null;
			if(isset($params['where'])) {
				if(isset($params['where']['branch_id']) && !empty($params['where']['branch_id'])) {
					$branch_id = " AND branch_id = '{$params['where']['branch_id']}'";
				}
			}

			if (empty($users))  {
				$this->db->query(
					"SELECT user.*,concat(firstname , ' ' ,lastname) as fullname,
						branch.branch as branch_name 
						FROM {$this->user_model->table} as user
						LEFT JOIN branches as branch
						ON branch.id = user.branch_id
						WHERE is_deleted = false
						{$branch_id}
						ORDER BY firstname asc"
				);
			} else {
				$logged_in_user_id = [];

				foreach($users as $key => $row) {
					$logged_in_user_id[] = $row->user_id;
				}

				$this->db->query(
					"SELECT user.*,concat(firstname , ' ' ,lastname) as fullname,
						branch.branch as branch_name
						FROM {$this->user_model->table} as user
						LEFT JOIN branches as branch
						ON branch.id = user.branch_id

						WHERE user.id not in('".implode("','" , $logged_in_user_id)."')
						{$branch_id}
						AND is_deleted = false
						ORDER BY firstname asc"
				);
			}

			return $this->db->resultSet();
		}

		//supporting functions
		public function getValidWorkHours()
		{
			if (isset($this->workData)) {
				return $this->workData['validWorkHours'];
			}else{
				return 0;
			}
		}

		public function getUser()
		{
			return $this->user;
		}

		public function getAction()
		{
			return $this->action;
		}
		/**
		 * if incomming workhour is not empty
		 * add it to current total work duration
		 */
		public function isMaxedWorkHours($userMeta, $incommingWorkHour = null) {
			//calculate current login (until max hours only).
			$today = today();
			//get duration of logins today.
			//logout then invalidate if max hours grace time 30mins
			$logs = $this->getAll([
				'where' => [
					'date(tklog.time_in)' => $today,
					'tklog.user_id' => $userMeta->user_id
				]
			]);

			$duration = 0;
			if($logs) {
				$duration = 0;
				foreach($logs as $key => $row) {
					$duration += $row->duration;
				}
			}

			if (!is_null($incommingWorkHour)) {
				//in minutes
				$duration += $incommingWorkHour;
			}

			//convert max hour from hour to minutes
			if ($duration >= ($userMeta->max_work_hours * 60)) {
				//if duration is already bigger than total max hour then is maxed = true
				return true;
			}

			return false;
		}

		/**
		 * get ongoing working hours
		 * calculate login time to logout time,
		 * calcualte only not save into db
		 */
		public function getOnGoingWorkHours($userId) {
			$lastLog = $this->getLastLog($userId);
			$dateToday = nowMilitary();
			$lastPunchTime = $lastLog->clock_in_time;

			return timeDifferenceInMinutes(strtotime($lastPunchTime), strtotime($dateToday));
		}
		/**
		 *get saved data from
		 *timesheets
		 *valid params from - to , userId
		 */
		public function getTotalWorkedHours($params = []) {
			$where = null;
			$dateToday = nowMilitary();
			
			if(!empty($params)) {
				$whereArray = [];
				if($params['from'] == 'today') {
					$whereArray['date(hr_time_sheets.time_in)'] = date('Y-m-d',strtotime($dateToday));
				}

				if(isset($params['userId'])) {
					$whereArray['user_id'] = $params['userId'];
				}
				$where = " WHERE ". parent::convertWhere($whereArray);
			}
			
			$this->db->query(
				"SELECT sum(duration) as duration FROM hr_time_sheets
					{$where}
					GROUP BY user_id"
			);
			
			return $this->db->single()->duration ?? 0;
		}

		public function getAll($params = []) {
			$where = null;

			if(isset($params['where'])) {
				$where = " WHERE ".parent::conditionConvert($params['where']);
			}

			$this->db->query(
				"SELECT tklog.*,
					concat(user.first_name , ' ',user.last_name) as full_name,
					ea.attr_name as position_name,
					ea.attr_abbr_name as position_abbr_name,
					ed.reports_to as reports_to

					FROM {$this->table} as tklog
					LEFT JOIN users as user 
					on user.id = tklog.user_id

					LEFT JOIN employment_details as ed
					on ed.user_id = user.id 
					
					LEFT JOIN employment_attributes as ea
					on ea.id = ed.position_id
					{$where}"
			);

			return $this->db->resultSet();
		}

		public function addFromForm($formData) {
			$dateDifferenceInMinutes = timeDifferenceInMinutes($formData['time_in'], $formData['time_out']);
			$workHourPay = $this->_computePayByTime($formData['user_id'], $dateDifferenceInMinutes);

			$formData['amount'] = $workHourPay;
			$formData['duration'] = $dateDifferenceInMinutes;
			$formData['remarks'] = 'for-approval';

			$formData = parent::getFillablesOnly($formData);

			return parent::store($formData);
		}

		public function approve($id) {
			$user = whoIs();

			return parent::update([
				'approved_by' => $user->id,
				'status' => 'approved',
				'remarks' => 'approved by '.$user->first_name . ' '. $user->last_name
			], $id);
		}
		private function _computePayByTime($userId, $workHoursInMinutes) {
			$user = $this->user_model->get($userId);
			if($user->salary_per_day <= 0)
				return 0;

			$amountTotal = ($user->salary_per_day / 8) * ($workHoursInMinutes / 60);
			return $amountTotal;
		}
	}