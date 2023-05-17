<?php 
    use Form\EmploymentAttributeForm;
    load(['EmploymentAttributeForm'], FORMS);

    class EmploymentAttributeController extends Controller
    {
        private $eeAttrForm,$model;

        public function __construct()
        {
            parent::__construct();
            $this->model = model('EmploymentAttributeModel');
            $this->eeAttrForm = new EmploymentAttributeForm();
        }

        public function index() {
            $req = request()->inputs();
            switch($req['type']) 
            {
                case 'DEPARTMENT':
                    $this->data['departments'] = $this->model->getAll([
                        'where' => [
                            'ea.attr_key' => 'DEPARTMENT'
                        ]
                    ]);
                    return $this->view('employment_attr/index_department', $this->data);
                break;

                case 'POSITION':
                    $this->data['positions'] = $this->model->getAll([
                        'where' => [
                            'ea.attr_key' => 'POSITION'
                        ]
                    ]);
                    return $this->view('employment_attr/index_position', $this->data);
                break;
            }
            return $this->view('employment_attr/index', $this->data);
        }

        public function create() {
            $req = request()->inputs();

            if(isSubmitted()) {
                $post = request()->posts();

                if(isEqual($post['attr_key'],'DEPARTMENT')) {
                    $isOkay = $this->model->createDepartment($post);
                    if($isOkay) {
                        Flash::set("Department {$post['attr_name']} created");
                    }

                    $route = _route('emp-attr:department');
                } else if(isEqual($post['attr_key'], 'POSITION')) {
                    $isOkay = $this->model->createPosition($post);
                    if($isOkay) {
                        Flash::set("Position {$post['attr_name']}created");
                    }

                    $route = _route('emp-attr:position');
                }
                
                if(!$isOkay) {
                    Flash::set($this->model->getErrorString(),'danger');
                    return request()->return();
                }

                return redirect($route);
            }

            $this->data['eeAttrForm'] = $this->eeAttrForm;
            if(!isEqual($req['type'], ['POSITION','DEPARTMENT'])) {
                echo die("INVALID URL REQUEST");
            } else {
                switch($req['type']) 
                {
                    case 'DEPARTMENT':
                        $this->data['_global']['pageTitle'] = 'Create Department';
                        $this->eeAttrForm->setValue('attr_key', $req['type']);
                        return $this->view('employment_attr/create_department', $this->data);
                    break;

                    case 'POSITION':
                        $departments = $this->model->getAll([
                            'where' => [
                                'ea.attr_key' => 'DEPARTMENT'
                            ],
                            'order' => 'attr_name asc'
                        ]);

                        $departmentsArr = arr_layout_keypair($departments,['id','attr_name']);
                        $this->data['_global']['pageTitle'] = 'Create Position';
                        $this->eeAttrForm->setValue('attr_key', $req['type']);
                        $this->eeAttrForm->add([
                            'type' => 'select',
                            'name' => 'parent_id',
                            'options' => [
                                'label' => 'Position Department',
                                'option_values' => $departmentsArr
                            ],
                            'class' => 'form-control'
                        ]);
                        return $this->view('employment_attr/create_position', $this->data);
                    break;
                }
            }
        }

        public function edit($id) {
            $req = request()->inputs();

            if(isSubmitted()) {
                $post  = request()->posts();
                $this->model->update($post, $post['id']);

                Flash::set("Updated");
            }

            $eeAttrData = $this->model->get($id);
            $this->data['eeAttr'] = $eeAttrData;
            switch($req['type']) 
            {
                case 'DEPARTMENT':
                    $this->data['_global']['pageTitle'] = 'Edit Department';
                    $this->eeAttrForm->setValueObject($eeAttrData);
                    $this->data['eeAttrForm'] = $this->eeAttrForm;
                    return $this->view('employment_attr/edit_department', $this->data);
                break;

                case 'POSITION':
                    $departments = $this->model->getAll([
                        'where' => [
                            'ea.attr_key' => 'DEPARTMENT'
                        ],
                        'order' => 'attr_name asc'
                    ]);

                    $departmentsArr = arr_layout_keypair($departments,['id','attr_name']);
                    $this->data['_global']['pageTitle'] = 'Edit Position';
                    $this->eeAttrForm->setValue('attr_key', $req['type']);
                    $this->eeAttrForm->add([
                        'type' => 'select',
                        'name' => 'parent_id',
                        'options' => [
                            'label' => 'Position Department',
                            'option_values' => $departmentsArr
                        ],
                        'class' => 'form-control'
                    ]);
                    $this->eeAttrForm->setValueObject($eeAttrData);
                    $this->data['eeAttrForm'] = $this->eeAttrForm;
                    return $this->view('employment_attr/edit_position', $this->data);
                break;
            }
        }
    }