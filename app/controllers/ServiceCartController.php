<?php 
	use Form\AppointmentForm;

	load(['AppointmentForm'], APPROOT.DS.'form');

	class ServiceCartController extends Controller
	{


		public function __construct()
		{
			$this->model = model('ServiceCartModel');
			$this->_form = new AppointmentForm();
		}

		public function destroyCart()
		{
			$this->model->destroyCart();

			Flash::set("Removed items");

			return request()->return();
		}

		public function add( )
		{
			/*
			*expected-inputs
			*user_id , type[bundle , service ]
			*/

			$post = request()->posts();

			$res = $this->model->add( $post );

			if(!$res) {
				Flash::set( $this->model->getErrorString() , 'danger');
				return request()->return();
			}

			Flash::set( $this->model->getMessageString() );

			return redirect( _route('appointment:create') );
		}

		public function show($session)
		{

			$discount = 0;

			$cart_token = $this->model->getAndCreateToken();

			$cart_items = $this->model->getCart();

			$cart_item_summary = $this->model->getCartSummary( $cart_items );

			$this->_form->add([
				'type' => 'hidden',
				'value' => $cart_token,
				'name'  => 'service_cart_id'
			]);
			
			$this->_form->add([
				'type' => 'hidden',
				'value' => $cart_token,
				'name'  => 'service_cart_id'
			]);


			foreach( $cart_items as $key => $cart)
			{
				if( isEqual($cart['type'] , 'bundle') )
					$discount += $cart['bundle']->discount;
			}

			$this->_form->add([
				'type' => 'hidden',
				'value' => $discount,
				'name' => 'discount'
			]);
			
			$data = [
				'title' => 'Services Selected',
				'cart_items' => $cart_items,
				'cart_item_summary' => $cart_item_summary,
				'form' => $this->_form,
				'auth' => auth()
			];

			return $this->view('service_cart/show' , $data);
		}
	}