<?php 
	load(['ServiceBundleForm'] , APPROOT.DS.'form');
	use Form\ServiceBundleForm;

	class ServiceBundleController extends Controller
	{

		public function __construct()
		{
			$this->_form = new ServiceBundleForm();
			$this->model = model('ServiceBundleModel');
		}

		public function index()
		{
			$service_bundles = $this->model->getAll();

			$data = [
				'service_bundles' => $service_bundles,
				'title' => 'Packages'
			];

			return $this->view('service_bundle/index' , $data);
		}


		public function create()
		{
			if( isSubmitted() )
			{
				$post = request()->posts();
				
				$res = $this->model->save($post);

				Flash::set( $this->model->getMessageString() );

				if(!$res) {
					Flash::set( $this->model->getErrorString() , 'danger');
					return request()->return();
				}

				return redirect( _route('service-bundle-item:add' , $res));
			}

			$this->_form->init([
				'url' => _route('service-bundle:create')
			]);

			$data = [
				'form' => $this->_form,
				'title' => 'Packages'
			];

			return $this->view('service_bundle/create' , $data);
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
				return redirect( _route('service-bundle:index'));
			}

			$service_bundle = $this->model->get($id);
			
			$service_bundle_items = [];

			if(!$service_bundle)
				echo ("NO SERVICE BUNDLE FOUND!");

			$form = $this->_form;

			$form->init([
				'url' => _route('service-bundle:edit' , $id)
			]);

			/*
			*Add price field after description
			*/
			$form->addAfter(
				'description' , 
				[
					'type' => 'text',
					'name' => 'price',
					'attributes' => [
						'readonly' => true
					],
					'options' => [
						'label' => 'Price'
					],
					'class' => 'form-control',
					'value' => $service_bundle->price
				]
			);

			$form->addId($id);
			$form->setValueObject($service_bundle);

			$data = [
				'form' => $form,
				'service_bundle' => $service_bundle,
				'service_bundle_items' => $service_bundle_items,
				'title' => $service_bundle->name . ' | Edit '
			];

			return $this->view('service_bundle/edit' , $data);
		}

		public function show($id)
		{
			$service_bundle = $this->model->getWithItems($id);


			$data = [
				'title' => $service_bundle->name,
				'service_bundle' => $service_bundle,
				'services'  => $service_bundle->items
			];

			return $this->view('service_bundle/show' , $data);
		}


		public function removeCustomPrice( $id )
		{
			$this->model->update([
				'price_custom' => 0
			] , $id );

			Flash::set( " Custom price removed !");
			return request()->return();
		}
	}