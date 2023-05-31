<?php

    use Form\LeaveForm;
    
    load(['LeaveForm'], FORMS);

    class LeaveController extends Controller
    {
        public $form;
        public $model,$userModel,$employmentModel,$leavePointModel;

        public function __construct()
        {
            parent::__construct();
            $this->form = new LeaveForm();
            $this->model = model('LeaveModel');
            $this->userModel = model('UserModel');
            $this->employmentModel = model('EmploymentModel');
            $this->leavePointModel = model('LeavePointModel');

            $this->data['form'] = $this->form;
            
        }

        public function index() {

            $req = request()->inputs();

            if(!empty($req['filter'])) {
                $validFilters = [
                    'user_id',
                    'leave_category',
                    'status'
                ];

                $condition = [];

                foreach($req as $reqKey => $reqRow) {
                    if(isEqual($reqKey, $validFilters) && $reqRow != '') {
                        $condition["el.{$reqKey}"] = $reqRow;
                    }
                    
                }

                $leaves = $this->model->getAll([
                    'where' => $condition
                ]);
            } else {
                //initial laoad
                if(!isManagement()) {
                    $leaves = $this->model->getAll([
                        'where' => [
                            'el.user_id' => whoIs('id')
                        ]
                    ]);
                } else {
                    $leaves = $this->model->getAll([
                        'limit' => '20'
                    ]);
                }
            }

            if(authType(USER_EMP)) {
                $this->form->add([
                    'name' => 'user_id',
                    'type' => 'hidden',
                    'value' => whoIs('id')
                ]);
            }
            
            $this->data['leaves'] = $leaves;
            $this->data['user'] = $this->userModel->get($this->data['whoIs']->id);
            return $this->view('leave/index', $this->data);
        }

        public function create() {
            
            if(isSubmitted()) {
                $post = request()->posts();
                $post['status'] = 'pending';
                $res = $this->model->add($post);

                if(!$res) {
                    Flash::set($this->model->getErrorString(), 'danger');
                    return request()->return();
                } else {
                    Flash::set("Leave Request filed");
                    return redirect(_route('leave:index'));
                }
            }

            $this->data['leavePoint'] = $this->leavePointModel->getTotalByUser($this->data['whoIs']->id);
            //iniot user

            $this->data['form']->add([
                'type' => 'hidden',
                'value' => $this->data['whoIs']->id,
                'name' => 'user_id'
            ]);
            return $this->view('leave/create', $this->data);
        }

        public function edit($id) {

            if(isSubmitted()) {
                $post = request()->posts();
                $this->model->update($post, $post['id']);

                Flash::set("Timesheet updated");
                return redirect(_route('leave:index'));
            }

            $leave = $this->model->get($id);

            $this->data['leave'] = $leave;
            $this->form->setValueObject($leave);
            $this->form->addId($leave->id);
            $this->form->setValue('submit', 'Save Changes');
            $this->data['form'] = $this->form;
            return $this->view('leave/edit', $this->data);
        }

        public function approve($id) {
            $this->model->approve($id);
            Flash::set("Leave Approved");
            return redirect(_route('leave:index'));
        }
    }