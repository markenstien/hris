<?php
	load(['SpecialtyForm'] , APPROOT.DS.'form');
	use Form\SpecialtyForm;

	class SpecialtyController extends Controller
	{
		public function __construct()
		{
			$this->_form = new SpecialtyForm();

			$this->model = model('SpecialtyModel');
		}

		public function index()
		{
			$specialties = $this->model->getAll([
				'order' => 'category'
			]);

			$data = [
				'title' => 'Specialties',
				'specialties' => $specialties
			];

			return $this->view('specialty/index' , $data);
		}

		public function create()
		{
			if( isSubmitted() )
			{
				$post = request()->posts();

				$res = $this->model->save($post);

				if(!$res) {
					Flash::set( $this->model->getErrorString() , 'danger');
					return request()->return();
				}

				Flash::set( $this->model->getMessageString() );
				return redirect( _route('specialty:index') );
			}
			$data = [
				'form' => $this->_form,
				'title' => 'Create Field Specialty'
			];

			return $this->view('specialty/create' , $data);
		}

		public function edit($id)
		{
			if( isSubmitted() )
			{
				$post = request()->posts();

				$res = $this->model->save($post , $post['id']);

				if(!$res) {
					Flash::set( $this->model->getErrorString() , 'danger');
					return request()->return();
				}

				Flash::set( $this->model->getMessageString() );
				return redirect( _route('specialty:index') );
			}

			$specialty = $this->model->get($id);

			$this->_form->init([
				'url' => _route('specialty:edit' , $id)
			]);

			$this->_form->addId( $id );

			$this->_form->setValueObject($specialty);

			$data = [
				'form' => $this->_form,
				'title' => $specialty->name . '| Edit',
				'specialty' => $specialty
			];

			return $this->view('specialty/edit' , $data);
		}
	}