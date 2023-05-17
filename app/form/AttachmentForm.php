<?php 

	namespace Form;

	load(['Form'] , CORE);

	use Core\Form;

	class AttachmentForm extends Form
	{


		public function __construct()
		{
			parent::__construct();

			$this->name = 'attachment_form';

			$this->init([
				'url' => _route('attachment:create'),
				'method' => 'post',
				'enctype' => true
			]);

			// $this->addName();

			$this->addLabel();
			$this->addDescription();
			$this->addGlobalId();
			$this->addGlobalKey();
			$this->addFileUpload();
			
			$this->addSubmit();
		}



		

		public function addName()
		{
			$this->add([
				'type' => 'text',
				'name' => 'display_name',
				'options' => [
					'label' => 'Display Name',
				],
				'class' => 'form-control'
			]);
		}

		public function addLabel()
		{
			$this->add([
				'type' => 'text',
				'name' => 'label',
				'options' => [
					'label' => 'File Label',
				],
				'class' => 'form-control'
			]);
		}

		public function addSearchKey()
		{
			$this->add([
				'type' => 'text',
				'name' => 'searck_key',
				'options' => [
					'label' => 'Search Key',
				],
				'class' => 'form-control'
			]);
		}

		public function addDescription()
		{
			$this->add([
				'type' => 'textarea',
				'name' => 'description',
				'options' => [
					'label' => 'Description',
				],
				'class' => 'form-control',
				'rows'  => 2
			]);
		}

		public function addGlobalId()
		{
			$this->add([
				'type' => 'hidden',
				'name' => 'global_id',
			]);
		}

		public function addGlobalKey()
		{
			$this->add([
				'type' => 'hidden',
				'name' => 'global_key'
			]);
		}


		public function addSubmit()
		{
			$this->customSubmit('Save File');
		}

		public function addFileUpload()
		{
			$this->add([
				'type' => 'file',
				'name' => 'file',
				'options' => [
					'label' => 'Select File'
				],
				'class' => 'form-control'
			]);
		}

		public function addMultipleFileUpload()
		{

		}
	}