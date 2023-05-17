<?php 
    namespace Form;
    use Core\Form;
    load(['Form'],CORE);

    class FormCommon extends Form {

        public function __construct()
        {
            parent::__construct();
            $this->addStartDate();
            $this->addEndDate();
            $this->addUsers();
            $this->addSubmit();
        }

        public function addStartDate() {
            $this->add([
                'type' => 'date',
                'name' => 'start_date',
                'class' => 'form-control',
                'required' => true,
                'options' => [
                    'label' => 'Start Date'
                ]
            ]);
        }

        public function addEndDate() {
            $this->add([
                'type' => 'date',
                'name' => 'end_date',
                'class' => 'form-control',
                'required' => true,
                'options' => [
                    'label' => 'End Date'
                ]
            ]);
        }


        public function addUsers(){
            $userModel = model('UserModel');
            $users = $userModel->all();

            $users = arr_layout_keypair($users, ['id' ,'first_name@last_name']);
            $this->add([
                'type' => 'select',
                'name' => 'user_id',
                'class' => 'form-control',
                'options' => [
                    'label' => 'User',
                    'option_values' => $users
                ]
            ]);
        }

        public function addSubmit() {
            $this->add([
                'type' => 'submit',
                'name' => 'submit',
                'value' => 'Save',
                'class' => 'btn btn-primary btn-sm'
            ]);
        }
    }