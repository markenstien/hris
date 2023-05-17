<?php 
    namespace Form;
    use Core\Form;
    load(['Form'], CORE);

    class EmploymentAttributeForm extends Form
    {

        public function __construct()
        {
            parent::__construct();
            $this->addParentID();
            $this->addKey();
            $this->addName();
            $this->addAbbrName();
        }

        public function addParentID() {
            $this->add([
                'name' => 'parent_id',
                'type' => 'hidden',
            ]);
        }

        public function addKey() {
            $this->add([
                'name' => 'attr_key',
                'type' => 'hidden',
                'attributes' => [
                    'readonly' => true
                ],
                'required' => true,
                'class' => 'form-control'
            ]);
        }

        public function addName() {
            $this->add([
                'name' => 'attr_name',
                'type' => 'text',
                'required' => true,
                'class' => 'form-control'
            ]);
        }

        public function addAbbrName() {
            $this->add([
                'name' => 'attr_abbr_name',
                'type' => 'text',
                'required' => true,
                'class' => 'form-control'
            ]);
        }
    }