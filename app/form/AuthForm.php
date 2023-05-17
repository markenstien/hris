<?php 
	
	namespace Form;

	load(['Form'] , CORE);

	use Core\Form;

	class AuthForm extends Form
	{


		public function __construct()
		{
			parent::__construct();
			$this->name = 'auth_form';
		}



		public function addUsername()
		{
			
		}
	}