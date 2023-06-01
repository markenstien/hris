<?php

    use Form\TimesheetForm;
    use Services\TimesheetService;

    load(['TimesheetForm'],FORMS);
    load(['TimesheetService'],SERVICES);


    class TimekeepingController extends Controller
    {

        const DEFAULT_CREATE_VIEW = 'web_manual';
        public $model,$employmentModel,$eeAttributeModel,$userModel;
        public $timesheetForm, $serviceTimesheet;

        public function __construct()
        {
            parent::__construct();
            $this->model = model('TimesheetModel');
            $this->employmentModel = model('EmploymentModel');
            $this->eeAttributeModel = model('EmploymentAttributeModel');
            $this->userModel = model('UserModel');
            
            $this->timesheetForm = new TimesheetForm();
            $this->serviceTimesheet = new TimesheetService();
        }
        /**
         * list of timesheets
         */
        public function index() 
        {
            $req = request()->inputs();

            $users = $this->userModel->getAll([
                'where' => ['user_type' => USER_EMP]
            ]);

            $departments = $this->eeAttributeModel->getDepartments();
            
            $this->data['departmentArray'] = arr_layout_keypair($departments, ['id', 'attr_name@attr_abbr_name']);
            $this->data['userArray'] = arr_layout_keypair($users, ['user_id', 'first_name@last_name']);

            // $timesheets =  $this->model->getAll();
            // $this->data['timesheets'] = $timesheets;

            if(!empty($req['btn_filter'])) {

                $condition = [
                    'date(time_in)' => [
                        'condition' => 'between',
                        'value' => [$req['start_date'], $req['end_date']]
                    ]
                ];


                if(authType(USER_EMP)) {
                    $condition['tklog.user_id'] = whoIs('id');
                }

                if(!empty($req['user_id'])) {
                    $condition['tklog.user_id'] = $req['user_id'];
                }

                $this->data['timesheets'] = $this->model->getAll([
                    'where' => $condition,
                    'order' => 'tklog.id desc'
                ]);

                $this->data['usersTimesheets'] = $this->serviceTimesheet->formatPerUserTemplate($this->data['timesheets'], [
                    'start_date' => $req['start_date'],
                    'end_date' => $req['end_date']
                ]);
            } else {
                if(authType(USER_EMP)) {
                    $this->data['timesheets'] = $this->model->getAll([
                        'where' => [
                            'tklog.user_id' => $this->data['whoIs']->id
                        ],
                        'order' => 'tklog.id desc'
                    ]);
                } else {
                    $this->data['timesheets'] = $this->model->getAll([
                        'order' => 'tklog.id desc'
                    ]);
                }
            }
            

            $this->data['fullViewPath'] = empty($req['view_type']) ? 'timekeeping/views/view_type_free_list' : 'timekeeping/views/view_type_'.$req['view_type'];
            return $this->view('timekeeping/index', $this->data);
        }
        /**
         * manual timesheet 
         * qr timesheet
         * web timesheet
         */
        public function create() {
            $req = request()->inputs();
            $viewType = $req['type'] ?? self::DEFAULT_CREATE_VIEW;

            $this->timesheetForm->init([
                'url' => _route('tk:formlog'),
                'method' => 'post'
            ]);

            $userId = isset($req['user_id']) ? unseal($req['user_id']) : whoIs('id'); 

            $this->timesheetForm->setValue('user_id', $userId);

            $data = [
                'viewType' => $viewType,
                'timesheets' => $this->model->getAll([
                    'where' => [
                        'tklog.user_id' =>  $userId
                    ]
                ]),
                'form' => $this->timesheetForm
            ];

            switch($viewType) {
                case 'manual_form':
                    return $this->view('timekeeping/create_web_manual_form', $data);
                break;

                case 'web_manual':
                    return $this->view('timekeeping/create_web_timesheet', $data);
                break;

                case 'qr_timesheet':

                break;
            }
        }

        public function edit($id) {
            if(isSubmitted()) {
                $post = request()->posts();
                $timeInOut = $this->_formatTimeInOut($post['start_date'], $post['end_date'], $post['time_in'], $post['time_out']);
                
                $postData = array_merge($timeInOut, $post);
                $this->model->update($this->model->getFillablesOnly($postData), $post['id']);
                Flash::set("Sheet updated");
                return redirect(_route('tk:index'));
            }
            $timesheet = $this->model->get($id);
            $this->timesheetForm->setValueObject($timesheet);

            $this->timesheetForm->addId($id);
            
            $this->timesheetForm->setValue('start_date', today($timesheet->time_in));
            $this->timesheetForm->setValue('end_date', today($timesheet->time_out));
            
            $this->timesheetForm->setValue('time_in', timeNow($timesheet->time_in));
            $this->timesheetForm->setValue('time_out', timeNow($timesheet->time_out));

            
            $this->data['timesheet'] = $timesheet;
            $this->data['form'] = $this->timesheetForm;

            return $this->view('timekeeping/edit', $this->data);
        }

        public function show($id) {
            $timesheet = $this->model->get($id);
            $this->data['timesheet'] = $timesheet;
            return $this->view('timekeeping/show', $this->data);
        }

        public function webClockLogAction() {
            $req = request()->inputs();
            $this->model->log(whoIs('id'));
            return redirect(unseal($req['returnTo']));
        }

        public function webFormAction() {
            $post = request()->posts();
            
            $timeInOut = $this->_formatTimeInOut($post['start_date'], $post['end_date'], $post['time_in'], $post['time_out']);

            $paramData = array_merge($timeInOut, [
                'user_id' => $post['user_id'],
                'remarks' => $post['remarks']
            ]);

            $this->model->addFromForm($paramData);

            Flash::set("Timesheet Placed");
            return redirect(_route('tk:index'));
        }

        private function _formatTimeInOut($startDate, $endDate, $timeIn, $timeOut) {
            $dateTimeStart = date('Y-m-d H:i', strtotime($startDate . ' ' .$timeIn));
            $dateTimeEnd = date('Y-m-d H:i', strtotime($endDate . ' ' .$timeOut));

            return [
                'time_in' => $dateTimeStart,
                'time_out' => $dateTimeEnd
            ];
        }

        public function approve($id) {
            $this->model->approve($id);

            Flash::set("Timesheet approved");
            return redirect(_route('tk:index'));
        }

        public function log() {
            $req = request()->inputs();

            if(!empty($req['user_id']) && !empty($req['password'])) {
                $user = $this->userModel->get($req['user_id']);
                if(isEqual($user->password, $req['password'])) {
                    $this->model->log($req['user_id']);
                    Flash::set("{$this->model->getAction()} success");
                    return request()->return();
                }
            }
            Flash::set("Unable to process request",'danger');
            return request()->return();
        }
    }