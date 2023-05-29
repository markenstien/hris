<?php
    use Form\TrainingForm;
    use Form\TrainingRespondentForm;

    load(['TrainingForm','TrainingRespondentForm'], FORMS);

    class RequirementController extends Controller {

        public $trainingForm,$trainingSubmitForm;

        public $eeAttributeModel,$model, $eeRequirementRespondent;

        public function __construct()
        {
            parent::__construct();
            $this->trainingForm = new TrainingForm();
            $this->trainingSubmitForm = new TrainingRespondentForm();

            $this->eeAttributeModel = model('EmploymentAttributeModel');
            $this->eeRequirementRespondent = model('EmployeeRequirementRespondentModel');
            $this->model = model('EmployeeRequirementModel');
        }

        public function index() {
            $this->data['requirements'] = $this->model->getAll();
            return $this->view('requirement/index', $this->data);
        }

        public function create() {
            if(isSubmitted()) {
                $post = request()->posts();
                $this->model->create($post);
            }
            $this->data['trainingForm'] = $this->trainingForm;
            $this->data['departments'] = $this->eeAttributeModel->getDepartments();
            $this->data['positions'] = $this->eeAttributeModel->getPositions();

            return $this->view('requirement/create_training', $this->data);
        }

        public function show($id) {
            $training = $this->model->get($id);
            $this->data['training'] = $training;

            $this->trainingSubmitForm->init([
                'method' => 'post',
                'url' => _route('requirement:attachFile')
            ]);

            $this->trainingSubmitForm->setValue('cert_id', $id);
            $this->trainingSubmitForm->setValue('user_id', whoIs('id'));
            

            $this->data['respondents'] = $this->eeRequirementRespondent->getAll([
                'where' => [
                    'cert_id' => $id
                ]
            ]);

            $this->data['trainingSubmitForm'] = $this->trainingSubmitForm;
            return $this->view('requirement/show_traning', $this->data);
        }

        public function respondentView() {
            $req = request()->inputs();

            $respondent = $this->eeRequirementRespondent->get($req['respondent_id']);
            $training = $this->model->get($req['cert_id']);

            $this->data['respondent'] = $respondent;
            $this->data['training'] = $training;
            
            $this->data['attachments'] = $this->_attachmentModel->all([
                'global_key' => 'requirement_item',
                'global_id' => $respondent->id
            ]);

            return $this->view('requirement/respondent_view', $this->data);
        }

        public function approveRespond($respondentId) {
            $this->eeRequirementRespondent->approve($respondentId);
        }

        public function attachFile() {
            if(isSubmitted()) {
                $post = request()->posts();
                $id = $this->eeRequirementRespondent->create($post);
                
                $this->_attachmentModel->upload_multiple([
                    'global_key' => 'requirement_item',
                    'global_id' => $id
                ], 'files');
            }
        }
    }