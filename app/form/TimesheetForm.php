<?php
    namespace Form;

    use Core\Form;
use Module;

    load(['Form'],CORE);

    class TimesheetForm extends Form {

        public function __construct()
        {
            parent::__construct();
            
            $this->addStartDate();
            $this->addEndDate();
            $this->addStartTime();
            $this->addEndTime();
            $this->addSheetCategory();
            $this->addRemarks();
            $this->addUser();
            $this->customSubmit();
        }

        public function addStartDate() {
            return $this->add([
                'type' => 'date',
                'name' => 'start_date',
                'class' => 'form-control',
                'options' => [
                    'label' => 'Start Date'
                ]
            ]);
        }

        public function addEndDate() {
            return $this->add([
                'type' => 'date',
                'name' => 'end_date',
                'class' => 'form-control',
                'options' => [
                    'label' => 'End Date'
                ]
            ]);
        }

        public function addStartTime() {
            return $this->add([
                'type' => 'text',
                'name' => 'time_in',
                'class' => 'form-control',
                'options' => [
                    'label' => 'Time in'
                ],
                'attributes' => [
                    'placeholder' => 'hours:minutes'
                ]
            ]);
        }

        public function addEndTime() {
            return $this->add([
                'type' => 'text',
                'name' => 'time_out',
                'class' => 'form-control',
                'options' => [
                    'label' => 'Time out'
                ],
                'attributes' => [
                    'placeholder' => 'hours:minutes'
                ]
            ]);
        }

        public function addRemarks() {
            return $this->add([
                'type' => 'textarea',
                'name' => 'remarks',
                'class' => 'form-control',
                'options' => [
                    'label' => 'Remarks'
                ]
            ]);
        }

        public function addSheetCategory() {
            $this->add([
                'type' => 'select',
                'name' => 'sheet_category',
                'class' => 'form-control',
                'options' => [
                    'label' => 'Sheet Category',
                    'option_values' => Module::get('timesheet')['sheet_categories']
                ],
                'required' => true
            ]);
        }

        public function addUser() {
            return $this->add([
                'name' => 'user_id',
                'type' => 'hidden'
            ]);
        }
    }