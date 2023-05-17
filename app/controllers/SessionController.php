<?php 
	load(['SessionForm'] , APPROOT.DS.'form');
	use Form\SessionForm;

	class SessionController extends Controller
	{

		public function __construct()
		{

			parent::__construct();


			$this->model = model('SessionModel');
			$this->user_model = model('UserModel');

			$this->appointment = model('AppointmentModel');

			$this->data['title'] = 'Start Patient Session';

			$this->_form = new SessionForm();
		}

		public function index()
		{
			$auth = auth();

			$this->data['title'] = 'Sessions';

			if(isEqual($auth->user_type , 'patient'))
			{
				$this->data['sessions'] = $this->model->getAll([
						'order' => 'session.id desc',
						'where' => [
							'user_id' => $auth->id
						]
					]
				);
			}else
			{
				$this->data['sessions'] = $this->model->getAll([
						'order' => 'session.id desc'
					]
				);
			}
			

			return $this->view('session/index' , $this->data);
		}

		private function _createWithAppointment($appointment_id) 
		{
			$appointment = $this->appointment->get($appointment_id);

			if($appointment->user_id) {
				$user = $this->user_model->get($params['user_id']);
				return[
					'guest_name' => $user->first_name . ' '.$user->last_name,
					'guest_phone' => $user->phone_number,
					'guest_email' => $user->email,
					'user_id' => $user->id,
					'guest_address' => $user->address,
				];
			} else {
				return[
					'guest_name' => $appointment->guest_name,
					'guest_phone' => $appointment->guest_phone,
					'guest_email' => $appointment->guest_email,
					'guest_address' => '',
				];
			}
		}


		/**
		 * no appointment */
		private function _createWalkin($params) 
		{
			$user = $this->user_model->get($params['user_id']);
			
			/*
			*data needed to create a session
			*/
			return[
				'guest_name' => $user->first_name . ' '.$user->last_name,
				'guest_phone' => $user->phone_number,
				'guest_email' => $user->email,
				'user_id' => $user->id,
				'guest_address' => $user->address,
			];
		}

		public function create($appointment_id = null)
		{
			$req = request()->inputs();

			if(isSubmitted())
			{
				$post = request()->posts();

				$res = $this->model->create($post);

				if($res) {
					Flash::set("Session started");
					return redirect(_route('session:show' , $res));
				}else
				{
					Flash::set( $this->model->getErrorString() , 'danger');
					return request()->return();
				}
			}

			$form = $this->_form;

			if(is_null($appointment_id)) {
				$sesionData = $this->_createWalkin($req);
				$form->init([
					'url' => _route('session:create'),
					'method' => 'post'
				]);

			} else {
				$sesionData = $this->_createWithAppointment($appointment_id);
				$form->init([
					'url' => _route('session:create',$appointment_id),
					'method' => 'post'
				]);

				// $form->add([
				// 	'type' => 'hidden',
				// 	'name' => 'appointment_id',
				// 	'value' => $appointment_id
				// ]);
			}



			$form->setValue('doctor_id' , auth('id'));
			$form->setValue('guest_name' , $sesionData['guest_name']);
			$form->setValue('guest_phone' , $sesionData['guest_phone']);
			$form->setValue('guest_email' , $sesionData['guest_email']);
			$form->setValue('user_id' , $sesionData['user_id'] ?? '');

			$form->customSubmit('Create Session');



			$this->data['form'] = $form;
			
			// $this->data['appointment'] = $appointment;

			return $this->view('session/create' , $this->data);
		}

		public function edit( $id )
		{
			if( isSubmitted() )
			{
				$post = request()->posts();

				$res = $this->model->update( $this->model->getFillablesOnly($post) , $id);

				if($res) {
					Flash::set("Updated!");
				}else{
					Flash::set("Update failed");
				}

				return request()->return();
			}
		}

		public function show($id)
		{
			$session = $this->model->getComplete($id);

			
			if(!$session) 
				echo die('session not found!');

			$form = $this->_form;

			$form->init([
				'url' => _route('session:edit' , $id),
				'method' => 'post'
			]);

			$form->addDoctorRecommendation();
			//addremarks
			$form->addRemarks();

			$form->setValue('remarks' , $session->remarks);
			

			$this->data['title'] = 'Patient Session';
			$this->data['session'] = $session;
			$this->data['doctor']  = $session->doctor;
			$this->data['documents']  = $session->documents;

			$this->_attachmentForm->setValue('global_id' , $id);
			$this->_attachmentForm->setValue('global_key' , $this->model->attachment_key);

			$this->data['attachment_form'] = $this->_attachmentForm;


			$this->data['form'] = $form;	

			$this->data['has_control'] = isEqual( whoIs('user_type') , ['admin','doctor']);

			return $this->view('session/show' , $this->data);
		}
	}