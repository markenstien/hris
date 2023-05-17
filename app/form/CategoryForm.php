<?php

	namespace Form;

	use Core\Form;
	load(['Form'] , CORE);

	class CategoryForm extends Form
	{
		public function __construct()
		{
			parent::__construct();

			$this->name = 'category_form';

			$this->init([
				'url' => _route('category:create')
			]);
			$this->addCategory();
			$this->addKey();
			$this->customSubmit('Save');
		}

		public function addCategory()
		{
			$this->add([
				'type' => 'text',
				'name' => 'category',
				'options' => [
					'label' => 'Category',
				],
				'attributes' => [
					'placeholder' => 'Enter Category'
				],
				'class' => 'form-control'
			]);
		}

		public function addKey()
		{
			$this->add([
				'type' => 'select',
				'name' => 'cat_key',
				'options' => [
					'label' => 'Category Key',
					'option_values' => [
						'PRODUCT'
					]
				],

				'value' => 'PRODUCT',
				'attributes' => [
					'readonly' => true
				],
				'class' => 'form-control'
			]);
		}
	}