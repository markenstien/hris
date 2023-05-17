<?php 
	load(['DoctorSpecializationForm'] , APPROOT.DS.'form');
	use Form\DoctorSpecializationForm;

	class DoctorSpecializationController extends Controller
	{

		public function __construct()
		{
			$this->model = model('DoctorSpecializationModel');
		}

		public function create($doctor_id)
		{
			if( isSubmitted() )
			{
				$post = request()->posts();

				$res = $this->model->add($post);

				if($res) {
					Flash::set("Specialization Added");
					return redirect(_route('user:show' , $post['doctor_id']));
				}else
				{
					Flash::set( $this->model->getErrorString() , 'danger');
				}
			}

			$form = new DoctorSpecializationForm();
			
			$form->setValue('doctor_id' , $doctor_id);
			
			$data = [
				'title' => 'Doctor Specialization',
				'form'  => $form,
				'doctor_id' => $doctor_id
			];

			return $this->view('doc-special/create' , $data);
		}
	}