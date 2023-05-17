<?php 	

	class BillController extends Controller
	{

		public function __construct()
		{
			$this->model = model('BillModel');
		}

		public function index()
		{
			$bills = $this->model->getDesc('id');

			$data = [
				'bills' => $bills,
				'title' => 'Bills'
			];

			return $this->view('bill/index' , $data);
		}

		// public function edit()
		// {
			
		// }

		public function show($id)
		{
			$bill = $this->model->getComplete($id);

			if( !$bill ){
				echo 'error no bill found';
				return;
			}

			$data = [
				'title' => 'Bills Payment #'.$bill->reference,
				'bill'  => $bill
			];

			return $this->view('bill/show' , $data);
		}


		public function fetchFrame($id)
		{
			$bill = $this->model->getComplete($id);

			$type = $_GET['type'] ?? null;

			$data = [
				'title' => 'Bills Payment #'.$bill->reference,
				'bill'  => $bill
			];

			return $this->view('bill/frame' , $data);

			if( is_null($type) )
				return $this->view('bill/frame' , $data);

			return $this->view('bill/bill_only' , $data);
		}


		public function payInCash($id)
		{
			if( isSubmitted() )
			{
				$payment = $this->model->payInCash($id , $_POST['acc_name']);

				if(!$payment){
					Flash::set( $this->model->getErrorString() , 'danger');
				}else
				{
					Flash::set( "Payment saved , appointment is now scheduled" );
				}

				return request()->return();
			}
		}
		public function pay($id)
		{
			if( isSubmitted() )
			{
				//create payment

				$this->model->pay($id);
			}
		}
	}