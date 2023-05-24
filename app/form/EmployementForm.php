<?php 
    namespace Form;
    use Core\Form;
    load(['Form'],CORE);

    class EmployementForm extends Form
    {
        private $_eeAttrModel,$userModel;
        private $_positions = [];
        private $_departments = [];

        public function __construct()
        {
            parent::__construct();
            
            if(is_null($this->_eeAttrModel)) {
                $this->_eeAttrModel = model('EmploymentAttributeModel');
            }

            if(is_null($this->userModel)) {
                $this->userModel = model('UserModel');
            }
            $this->_positions = $this->_eeAttrModel->getAll([
                'where' => [
                    'ea.attr_key' => 'POSITION'
                ]
            ]);

            $this->_departments = $this->_eeAttrModel->getAll([
                'where' => [
                    'ea.attr_key' => 'DEPARTMENT'
                ]
            ]);

            $this->addPosition();
            $this->addDepartment();
            $this->addEmployementStatus();
            $this->addMonthlySalary();
            $this->addDailySalary();
            $this->addEmployementDate();
            $this->addManager();
        }
        public function addPosition() {

            $positions = arr_layout_keypair($this->_positions, ['id', 'attr_name']);

            return $this->add([
                'name' => 'position_id',
                'type' => 'select',
                'class' => 'form-control',
                'options' => [
                    'label' => 'Position',
                    'option_values' => $positions
                ],
                'required' => true
            ]);
        }

        public function addDepartment() {
            $deparments = arr_layout_keypair($this->_departments, ['id', 'attr_name']);

            return $this->add([
                'name' => 'department_id',
                'type' => 'select',
                'class' => 'form-control',
                'options' => [
                    'label' => 'Department',
                    'option_values' => $deparments
                ],
                'required' => true
            ]);
        }

        public function addEmployementStatus() {
            $employmentStatus = [
               'Contractor',
               'Probationary',
               'Regular'
            ];

            return $this->add([
                'name' => 'employment_status',
                'type' => 'select',
                'class' => 'form-control',
                'options' => [
                    'label' => 'Employement Status',
                    'option_values' => $employmentStatus
                ],
                'required' => true
            ]);
        }


        public function addMonthlySalary() {
            return $this->add([
                'name' => 'salary_per_month',
                'type' => 'text',
                'class' => 'form-control',
                'options' => [
                    'label' => 'Monthly Salary'
                ],
                'required' => true
            ]);
        }

        public function addDailySalary() {
            return $this->add([
                'name' => 'salary_per_day',
                'type' => 'text',
                'class' => 'form-control',
                'options' => [
                    'label' => 'Daily Pay Amount'
                ],
                'required' => true
            ]);
        }

        public function addEmployementDate() {
            return $this->add([
                'name' => 'employment_date',
                'type' => 'date',
                'class' => 'form-control',
                'options' => [
                    'label' => 'Employment Date'
                ],
                'required' => true
            ]);
        }

        public function addManager() {
            $users = $this->userModel->getAll(['order' => 'user.first_name asc']);
            $managers = arr_layout_keypair($users, ['id', 'first_name@last_name@position_name']);

            return $this->add([
                'name' => 'reports_to',
                'type' => 'select',
                'class' => 'form-control',
                'options' => [
                    'label' => 'Reports To',
                    'option_values' => $managers
                ]
            ]);
        }
    }