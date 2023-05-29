<?php
    namespace Form;
    use Core\Form;

    class TrainingRespondentForm extends Form {


        public function __construct()
        {
            parent::__construct();

            $this->addTitle();
            $this->addFile();
            $this->addDescription();

            $this->addCertId();
            $this->addUserId();
            
            $this->customSubmit('Save Training');
        }

        public function addTitle() {
            $this->add([
                'name' => 'eerr_title',
                'type' => 'text',
                'class' => 'form-control',
                'options' => [
                    'label' => 'Title'
                ],
                'required' => true,
                'attributes' => [
                    'placeholder' => 'Title'
                ]
            ]);
        }

        public function addDescription() {
            $this->add([
                'name' => 'eerr_description',
                'type' => 'textarea',
                'class' => 'form-control',
                'options' => [
                    'label' => 'Description'
                ],
                'required' => true,
                'attributes' => [
                    'rows' => 3
                ],
                'attributes' => [
                    'placeholder' => 'Description'
                ]
            ]);
        }

        public function addFile() {
            $this->add([
                'type' => 'file',
                'name' => 'files[]',
                'class' => 'form-control',
                'options' => [
                    'label' => 'Attach File'
                ],
                'required' => true,
                'attributes' => [
                    'multiple' => true
                ]
            ]);
        }

        public function addCertId() {
            $this->add([
                'type' => 'hidden',
                'name' => 'cert_id',
            ]);
        }

        public function addUserId() {
            $this->add([
                'type' => 'hidden',
                'name' => 'user_id',
            ]);
        }
    }