<?php 
    use Form\LeavePointForm;
    load(['LeavePointForm'], FORMS);

    class LeavePointController extends Controller
    {
        public $formLeavePoint;
        public $model;

        public function __construct()
        {
            parent::__construct();
            $this->formLeavePoint = new LeavePointForm();
            $this->model = model('LeavePointModel');
        }

        public function index() {
            $this->data['leave_point_logs'] = $this->model->getAll();
            return $this->view('leave_point/index', $this->data);
        }
        public function create() {

            if(isSubmitted()) {
                $post = request()->posts();
                $this->model->addEntry($post);
                return redirect(_route('leave-point:index'));
            }
            $this->data['form'] = $this->formLeavePoint;
            return $this->view('leave_point/create', $this->data);
        }
    }