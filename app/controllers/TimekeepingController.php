<?php

    use Form\TimesheetForm;
    load(['TimesheetForm'],FORMS);

    class TimekeepingController extends Controller
    {

        const DEFAULT_CREATE_VIEW = 'web_manual';
        public $model,$employmentModel;

        public $timesheetForm;

        public function __construct()
        {
            parent::__construct();
            $this->model = model('TimesheetModel');
            $this->employmentModel = model('EmploymentModel');
            $this->timesheetForm = new TimesheetForm();
        }
        /**
         * list of timesheets
         */
        public function index() {

            if(isEqual($this->data['whoIs']->user_type, 'employee')) {
                $underlings = $this->employmentModel->getUnderlings($this->data['whoIs']->id);
                $underlingsIds = getListObject($underlings, 'user_id');
                $underlingsIds[] = $this->data['whoIs']->id;


                $this->data['timesheets'] = $this->model->getAll([
                    'where' => [
                        'tklog.user_id' => [
                            'condition' => 'in',
                            'value' => $underlingsIds
                        ]
                    ],
                    'order' => 'tklog.id desc'
                ]);
            } else {
                $this->data['timesheets'] = $this->model->getAll([
                    'order' => 'tklog.id desc'
                ]);
            }
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
    }