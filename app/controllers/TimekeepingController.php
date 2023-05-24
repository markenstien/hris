<?php

    use Form\TimesheetForm;
    load(['TimesheetForm'],FORMS);

    class TimekeepingController extends Controller
    {

        const DEFAULT_CREATE_VIEW = 'web_manual';
        private $model;

        public $timesheetForm;

        public function __construct()
        {
            parent::__construct();
            $this->model = model('TimesheetModel');
            $this->timesheetForm = new TimesheetForm();
        }
        /**
         * list of timesheets
         */
        public function index() {

            if(isEqual($this->data['whoIs']->user_type, 'employee')) {
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
            return $this->view('timesheet/index', $this->data);
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

        public function webClockLogAction() {
            $req = request()->inputs();
            $this->model->log(whoIs('id'));
            return redirect(unseal($req['returnTo']));
        }

        public function webFormAction() {
            $post = request()->posts();
            $dateTimeStart = date('Y-m-d H:i', strtotime($post['start_date'] . ' ' .$post['time_in']));
            $dateTimeEnd = date('Y-m-d H:i', strtotime($post['end_date'] . ' ' .$post['time_out']));

            $this->model->addFromForm([
                'time_in' => $dateTimeStart,
                'time_out'   => $dateTimeEnd,
                'user_id' => $post['user_id'],
                'remarks' => $post['remarks']
            ]);

            Flash::set("Timesheet Placed");
            return redirect(_route('tk:index'));
        }
    }