<?php

	namespace Form;

	load(['Form'], CORE);

	use Core\Form;
use Model;
use Module;

	class UserForm extends Form
	{

		public function __construct( $name = null)
		{
			parent::__construct();

			$this->name = $name ?? 'form_user';

			$this->initCreate();

			$this->addAddress();
			$this->addPhoneNumber();
			$this->addEmail();
			$this->addUsername();
			$this->addPassword();
			$this->addUserType();
			$this->addProfile();
			$this->addFirstName();
			$this->addLastName();
			$this->addMiddleName();
			$this->addBirthDay();
			$this->addGender();

			$this->addSubmit('');
		}

		public function initCreate()
		{
			$this->init([
				'url' => _route('user:create'),
				'enctype' => true
			]);
		}
		
		public function addFirstName()
		{
			$this->add([
				'type' => 'text',
				'name' => 'first_name',
				'class' => 'form-control',
				'required' => true,
				'options' => [
					'label' => 'First Name'
				],

				'attributes' => [
					'id' => 'id_first_name',
					'placeholder' => 'Enter Last Name'
				]
			]);
		}


		public function addLastName()
		{
			$this->add([
				'type' => 'text',
				'name' => 'last_name',
				'class' => 'form-control',
				'required' => true,
				'options' => [
					'label' => 'Last Name'
				],

				'attributes' => [
					'id' => 'id_lastname',
					'placeholder' => 'Enter Last Name'
				]
			]);
		}

		public function addMiddleName()
		{
			$this->add([
				'type' => 'text',
				'name' => 'middle_name',
				'class' => 'form-control',
				'options' => [
					'label' => 'Middle Name'
				],

				'attributes' => [
					'id' => 'id_middle_name',
					'placeholder' => 'Enter Middle Name'
				]
			]);
		}

		public function addBirthDay()
		{
			$this->add([
				'type' => 'date',
				'name' => 'birthdate',
				'class' => 'form-control',
				'options' => [
					'label' => 'Birth Day'
				],

				'attributes' => [
					'id' => 'id_birthday',
				],
				'required' => true
			]);
		}

		public function addGender()
		{
			$this->add([
				'type' => 'select',
				'name' => 'gender',
				'class' => 'form-control',
				'options' => [
					'label' => 'Gender',
					'option_values' => [
						'Male' , 'Female'
					]
				],

				'attributes' => [
					'id' => 'id_gender',
				],
				'required' => true
			]);
		}

		public function addAddress()
		{
			$this->add([
				'type' => 'textarea',
				'name' => 'address',
				'class' => 'form-control',
				'options' => [
					'label' => 'Address',
				],

				'attributes' => [
					'id' => 'id_address',
					'rows' => 2
				],
				'required' => true
			]);
		}

		public function addPhoneNumber()
		{
			$this->add([
				'type' => 'text',
				'name' => 'phone_number',
				'class' => 'form-control',
				'options' => [
					'label' => 'Phone Number',
				],

				'attributes' => [
					'id' => 'id_phone_number',
					'placeholder' => 'Eg. 09xxxxxxxxx'
				],
				'required' => true
			]);
		}

		public function addEmail()
		{
			$this->add([
				'type' => 'email',
				'name' => 'email',
				'class' => 'form-control',
				'options' => [
					'label' => 'Email',
				],

				'attributes' => [
					'id' => 'id_email',
					'placeholder' => 'Enter Valid Email'
				],
				
				'required' => true
			]);
		}

		public function addUsername()
		{
			$this->add([
				'type' => 'text',
				'name' => 'username',
				'class' => 'form-control',
				'required' => true,
				'options' => [
					'label' => 'Username',
				],

				'attributes' => [
					'id' => 'id_username',
					'placeholder' => 'Username'
				]
			]);
		}

		public function addPassword()
		{
			$this->add([
				'type' => 'password',
				'name' => 'password',
				'class' => 'form-control',
				'options' => [
					'label' => 'Password',
				],

				'attributes' => [
					'id' => 'id_password',
					'placeholder' => 'Password'
				]
			]);
		}

		public function addUserType()
		{
			$userTypes = Module::get('user')['types'];
			$this->add([
				'type' => 'select',
				'name' => 'user_type',
				'class' => 'form-control',
				'required' => true,
				'options' => [
					'label' => 'User Type',
					'option_values' => $userTypes
				],

				'attributes' => [
					'id' => 'id_user_type',
					'data-target' => '#id_container_licensed_number'
				]
			]);
		}

		public function addProfile()
		{
			$this->add([
				'type' => 'file',
				'name' => 'profile',
				'class' => 'form-control',
				'options' => [
					'label' => 'Profile Picture',
				],

				'attributes' => [
					'id' => 'id_profile'
				]
			]);
		}

		public function addSubmit()
		{
			$this->add([
				'type' => 'submit',
				'name' => 'submit',
				'class' => 'btn btn-primary',
				'attributes' => [
					'id' => 'id_submit'
				],

				'value' => 'Save user'
			]);
		}
	}