<?php 

    namespace Form;
    use Core\Form;
use Module;

    load(['Form'], CORE);
    class LeaveForm extends Form {

        public function __construct()
        {
            parent::__construct();

            $this->addCategory();
            $this->addDateFiled();
            $this->addStartDate();
            $this->addEndDate();
            $this->addReason();

            $this->customSubmit('File Leave');
        }

        public function addDateFiled() {
            $this->add([
                'name' => 'date_filed',
                'type' => 'date',
                'class' => 'form-control',
                'options' => [
                    'label' => 'Reference Date'
                ],
                'required' => true
            ]);
        }


        public function addStartDate() {
            $this->add([
                'name' => 'start_date',
                'type' => 'date',
                'class' => 'form-control',
                'options' => [
                    'label' => 'Start Date'
                ],
                'required' => true
            ]);
        }


        public function addEndDate() {
            $this->add([
                'name' => 'end_date',
                'type' => 'date',
                'class' => 'form-control',
                'options' => [
                    'label' => 'End Date'
                ],
                'required' => true
            ]);
        }


        public function addReason() {
            $this->add([
                'name' => 'reason',
                'type' => 'textarea',
                'class' => 'form-control',
                'options' => [
                    'label' => 'Reason'
                ],
                'required' => true
            ]);
        }

        public function addCategory() {
            $this->add([
                'name' => 'leave_category',
                'type' => 'select',
                'class' => 'form-control',
                'options' => [
                    'label' => 'Reason',
                    'option_values' => Module::get('ee_leave')['categories']
                ],
                'required' => true
            ]);
        }
    }