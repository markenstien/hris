<?php 

    class PageController extends Controller
    {
        private $userModel, $timesheetModel;

        public function __construct()
        {
            parent::__construct();

            $this->userModel = model('UserModel');
            $this->timesheetModel = model('TimesheetModel');
        }
        public function index() {
            $req = request()->inputs();
            $this->_guardPanelView();
        }


        private function _guardPanelView() {
            
            //get all users

            $users = $this->userModel->getAll([
                'where' => [
                    'user_type' => USER_EMP
                ],

                'order' => 'first_name asc'
            ]);
            
            foreach($users as $key => $row) {
                $row->last_in = $this->timesheetModel->single([
                    'user_id' => $row->user_id
                ], '*', 'id desc');
            }
            
            $this->data['users'] = $users;

            return $this->view('page/guard_panel', $this->data);
        }
    }