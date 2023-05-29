<?php 
    namespace Form;
    use Core\Form;
use Module;

    load(['Form'], CORE);
    
    class TrainingForm extends Form {

        public function __construct()
        {
            parent::__construct();

            $this->addTitle();
            $this->addImportance();
            $this->addStartDate();
            $this->addEndDate();
            $this->addDescription();
        }
        
        public function addTitle() {
            $this->add([
                'name' => 'req_title',
                'type' => 'text',
                'class' => 'form-control',
                'required' => true,
                'options' => [
                    'label' => 'Training Title'
                ]
            ]);
        }


        public function addDescription() {
            $this->add([
                'name' => 'description',
                'type' => 'textarea',
                'class' => 'form-control',
                'required' => true,
                'options' => [
                    'label' => 'Training Title'
                ],
                'attributes' => [
                    'rows' => 3
                ]
            ]);           
        }

        public function addStartDate() {
            $this->add([
                'name' => 'start_date',
                'type' => 'date',
                'class' => 'form-control',
                'required' => true,
                'options' => [
                    'label' => 'Training Release Date'
                ]
            ]);           
        }

        public function addEndDate() {
            $this->add([
                'name' => 'end_date',
                'type' => 'date',
                'class' => 'form-control',
                'required' => true,
                'options' => [
                    'label' => 'Submission Deadline'
                ]
            ]);           
        }

        public function addImportance() {
            $this->add([
                'name' => 'importance',
                'type' => 'select',
                'class' => 'form-control',
                'required' => true,
                'options' => [
                    'label' => 'Importance',
                    'option_values' => Module::get('common')['importance-status']
                ]
            ]);           
        }
    }