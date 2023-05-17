<?php


	class API_Payment extends Controller
	{

		public function __construct()
		{
			$this->payment = model('PaymentModel');
		}

		public function payResponse( )
		{
			if( isSubmitted() )
			{
				$post = request()->posts();

				$res = $this->payment->create([
					'amount' => $post['amount'],
					'method' => $post['method'],
					'external_reference' => $post['reference'],
					'acc_name' => $post['acc_name'],
					'org' => 'PAYPAL',
					'bill_id' => $post['bill_id']
				]);

				return json_encode($res);
			}
		}
	}