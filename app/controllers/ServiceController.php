<?php
	load(['ServiceForm'] , APPROOT.DS.'form');

	use Form\ServiceForm;

	class ServiceController extends Controller
	{

		public function __construct()
		{
			parent::__construct();

			$this->_form = new ServiceForm();
			$this->model = model('ServiceModel');
		}

		public function index()
		{
			$services = $this->model->getAll();

			$data = [
				'title' => 'Services',
				'services' => $services,
				'form' => $this->_form
			];
			return $this->view('service/index' , $data);
		}


		public function create()
		{
			if( isSubmitted() )
			{
				$post = request()->posts();

				$res = $this->model->save($post);

				Flash::set( $this->model->getMessageString() );

				if(!$res){
					Flash::set( $this->model->getErrorString() , 'danger');
					return request()->return();
				}

				if(!upload_empty('images')) {
					//upload images
					$this->_attachmentModel->upload_multiple([
						'global_key' => 'PRODUCT_IMAGES',
						'global_id'  => $this->model->_getRetval('id')
					], 'images');
				}

				return redirect( _route('service:index') );
			}

			$data = [
				'title' => 'Create Product',
				'form'  => $this->_form
			];

			return $this->view('service/create' , $data);
		}


		public function edit($id)
		{
			if( isSubmitted() )
			{
				$post = request()->posts();

				$res = $this->model->save($post , $post['id']);

				Flash::set( $this->model->getMessageString() );

				if(!$res){
					Flash::set( $this->model->getErrorString() , 'danger');
					return request()->return();
				}

				return redirect( _route('service:index') );
			}

			$service = $this->model->get($id);

			$this->_form->init([
				'url' => _route('service:edit' , $service->id)
			]);

			$this->_form->addId( $service->id );

			$this->_form->setValueObject( $service );

			$data = [
				'title' => 'Edit Product',
				'form'  => $this->_form
			];

			return $this->view('service/edit' , $data);
		}

		public function show($id) {
			$service = $this->model->get($id);
			$this->_form->setValueObject( $service );
			$this->data['service'] = $service;
			$this->data['_form'] = $this->_form;

			$this->data['images'] = $this->_attachmentModel->all([
				'global_key' => _asset_key('PRODUCT_IMAGES'),
				'global_id'  => $id
			]);

			$this->data['_attachmentForm']->setValue('global_id', $id);
			$this->data['_attachmentForm']->setValue('global_key', _asset_key('PRODUCT_IMAGES'));


			return $this->view('service/show' , $this->data);
		}
	}