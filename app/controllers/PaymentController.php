<?php 

	class PaymentController extends Controller
	{	
		public function __construct()
		{
			$this->payment = model('PaymentModel');
		}

		public function index()
		{	
			$auth = auth();


			$payments = $this->payment->getDesc('id');
			$data = [
				'title' => 'Payments',
				'payments' => $payments
			];

			return $this->view('payment/index' , $data);
		}

		public function show($id)
		{
			$payment = $this->payment->get( $id );

			$data = [
				'title' => 'Payment-Overview',
				'payment' => $payment
			];
			
			return $this->view('payment/show' , $data);
		}

		public function confirmation()
		{
			echo ' payment-confirmed ';
		}
	}