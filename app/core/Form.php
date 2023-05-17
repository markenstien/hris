<?php 
	namespace Core;
	load(['FormBuilder'], CORE);

	class Form {

		protected $_type = 'crud';
		protected $_form = null;
		protected $_form_param = [];
		protected $_method = 'post';
		protected $_url = '';
		protected $_form_head = [];
		protected $_items = [];
		protected $name = 'CORE_FORM';

		public function __construct()
		{
			$this->_form = new FormBuilder();	
		}

		/**
		 * initiats form basic feature
		 */
		public function init($params = []) {
			$form_param = [];
			$form_param['method'] = strtoupper($params['method'] ?? $this->_method);
			$form_param['url'] = $params['url'] ?? $this->_url;
			$form_param['enctype'] = 'multipart/form-data';

			if(isset($params['attributes']) )
				$form_param = array_merge($form_param , $params['attributes']);

			$this->_form_param = $form_param;
		}

		public function add($params = []) {
			$type = strtolower(trim($params['type']));
			$name = $params['name'];
			$value = $params['value'] ?? '';
			$preserve = $params['preserve'] ?? false;
			/**ORIGNAL LABEL DO NOT TOUCH */
			$label_original  = $params['options']['label'] ?? '';
			/**APPEND LABEL DESIGN */
			$label   = $label_original;
			$attributes = $this->mergeInputAttributes($params);
			$option_values = $params['options']['option_values'] ?? [];

			$item = [
				'name' => $name,
				'type' => $type,
				'value' => $value,
				'attributes' => $attributes,
				'option_values' => $option_values,
				'preserve' => $preserve
			];

			if(isset($params['required']) && ($params['required'] == true)) {
				if(isset($params['options']['label'])){
					$label .= "<span style='color:red;'>*</span>";
				}
				$item['required'] = TRUE;
			}

			$item['label'] = $label;
			$item['label_original']  = $label_original;

			
			$item = $this->validateItemData($item);

			$this->_items[$name] = $item;
		} 

		public function getLabel($name) {
			if($this->checkExistKey($name)) {
				$item = $this->getItem($name);
				return $item['label_original'];
				return [
					$item['label'],
					$item['label_original'],
				];
			}
		}

		public function getValue($name) {
			if($this->checkExistKey($name)) {
				$item = $this->getItem($name);
				return $item['value'];
			}
		}

		public function label($name)
		{
			$item = $this->getRaw($name);
			$form_label = $this->_form->label($item['label'] , $item['attributes']['id'] ?? '#');
			return $form_label;
		}

		public function get($name, $inputOption = []) 
		{
			$rawItem = $this->getRaw($name, $inputOption);
			$this->rawItem = $rawItem;

			if(isset($rawItem['required']) && $rawItem['required'] === TRUE) {
				$rawItem['attributes']['required'] = true;
			}
			
			switch($rawItem['type'])
			{
				case 'text':
				case 'email':
				case 'hidden':
				case 'checkbox':
				case 'radio':
				case 'textarea':
				case 'submit':
				case 'number':
				case 'date':
				case 'time':
					return $this->_form->call($rawItem['type'] , $rawItem['name'], $rawItem['value'] , $rawItem['attributes'] );
				break;

				case 'password':
					return $this->_form->password($rawItem['name'], $rawItem['value'] , $rawItem['attributes'] , $rawItem['preserve']);
				break;

				case 'file':
					return $this->_form->file($rawItem['name'], $rawItem['attributes']);
				break;

				case 'select':
					return $this->_form->select($rawItem['name'] , $rawItem['option_values'] , $rawItem['value'] , $rawItem['attributes']);
				break;
			}
		}

		/**
		 * labelname and input row format*/
		public function getCol($name , $inputOption = [])
		{
			$form_input = $this->get($name, $inputOption);

			$item = $this->rawItem;
			if(!isEqual($item['type']  , ['hidden' , 'submit']) && !isset($item['label'])){
				echo die("Cannot create Column {$name} , No Label specified");
			}

			$labelText = $item['label'];
			if(!isset($item['required']) || ($item['required'] == false)) {
				$labelText = $item['label_original'];
			}
			$form_label = $this->_form->label($labelText , $item['attributes']['id'] ?? '#');

			return <<<EOF
				<div> 
					{$form_label}
					{$form_input}
				</div>
			EOF;
		}

		public function getRow($name , $inputOption = [])
		{
			$form_input = $this->get($name, $inputOption);
			$item = $this->rawItem;
			if(!isEqual($item['type']  , ['hidden' , 'submit']) && !isset($item['label'])){
				echo die("Cannot create Column {$name} , No Label specified");
			}

			$labelText = $item['label'];
			if(!isset($item['required']) || ($item['required'] == false)) {
				$labelText = $item['label_original'];
			}
			$form_label = $this->_form->label($labelText , $item['attributes']['id'] ?? '#');

			return <<<EOF
				<div class='row mb-2'>
					<div class='col-md-3'>{$form_label}</div>
					<div class='col-md-9'>{$form_input}</div>
				</div>
			EOF;
		}


		public function getRaw($name, $inputOption = []) {
			if($this->checkExistKey($name)) {
				return $this->overWriteInputOption($this->_items[$name], $inputOption);
			}
		}

		public function start($param = null)
		{
			return $this->_form->open($param ?? $this->_form_param);
		}

		public function end()
		{
			return $this->_form->close();
		}

		public function remove($name)
		{
			$items = $this->_items;
			foreach($items as $key => $item)
			{
				if( $item['name'] == $name ){
					unset($items[$key]);
				}
			}
			$this->_items = $items;
		}

		public function addCustom($name, $label, $htmlCustom) {
			$this->_customItems[$name] = [
				'label' => $label,
				'html'  => $htmlCustom
			];
		}

		public function getCustom($name, $displayType = 'row') {
			$field = $this->_customItems[$name];
			$form_label = $this->_form->label($field['label']);

			if ($displayType == 'row') {
				return <<<EOF
					<div class='row mb-2'>
						<div class='col-md-3'>{$form_label}</div>
						<div class='col-md-9'>{$field}</div>
					</div>
				EOF;
			} else {
				return <<<EOF
					<div> 
						{$form_label}
						{$field['html']}
					</div>
				EOF;
			}
		}

		public function addAfter($after_key , $item)
		{
			$this->add($item);

			$key_to_move = $item['name'];

			//get items
			$array = $this->_items;
			//get item keys
			$array_keys = array_keys($array);
			//key_to_move_position
			$key_to_move_position = array_search($key_to_move , $array_keys);
			//get after key position
			$key_after_position = array_search($after_key , $array_keys);
			//unset to move key to avoid duplication
			unset($array_keys[$key_to_move_position]);
			//key to move , put after the after key index
			array_splice($array_keys , ($key_after_position + 1) , 0 , [$key_to_move]);
			//reorder
			$new_order = [];

			foreach($array_keys as $pos => $key)
			{
				$new_order[$key] = $array[$key];
			}

			$this->_items = $new_order;
		}

		public function getFormRaw()
		{
			return [
				'form' => $this->_form_param,
				'inputs' => $this->_items
			];
		}

		public function addId($id)
		{
			$this->add([
				'type' => 'hidden',
				'value' => $id,
				'name'  => 'id'
			]);
		}

		public function getId()
		{
			$id = $this->getRaw('id');

			if(!$id){
				echo die("Form {$this->name} input Id field not found");
				return false;
			}
			return $this->get('id');
		}


		public function getFormItems( $inputType = 'row' )
		{
			$items = $this->_items;
			$html = '';

			foreach($items as $item) 
			{
				if( isEqual($item['type'] , ['submit' , 'hidden']) )
				{
					$btn = $this->get($item['name']);

					$html .= <<<EOF
						<div>
							{$btn}
						</div>
					EOF;

				}else
				{
					if( isEqual($inputType , 'row') ){
						$label_input_bundle = $this->getRow($item['name']);
					}else{
						$label_input_bundle = $this->getCol($item['name']);
					}

					$html .= <<<EOF
						<div class='form-group mb-2'>
							{$label_input_bundle}
						</div>
					EOF;
				}
			}

			return $html;
		}


		public function getForm($inputType = 'row')
		{
			$html = '';

			$html .= $this->start();

			$items = $this->_items;

			foreach($items as $item) 
			{
				if( isEqual($item['type'] , ['submit' , 'hidden']) )
				{
					$btn = $this->get($item['name']);

					$html .= <<<EOF
						<div>
							{$btn}
						</div>
					EOF;

				}else
				{
					$label_input_bundle = $this->getRow($item['name']);

					$html .= <<<EOF
						<div class='form-group mb-2'>
							{$label_input_bundle}
						</div>
					EOF;
				}
			}

			$html .= $this->end();

			return $html;
		}

		final public function customSubmit($value = null , $name = null, $attributes = null)
		{
			$class = 'btn btn-primary btn-sm';

			if(isset($attributes['class'])){
				$class = $attributes['class'];
				unset($attributes['class']);
			}

			$this->add([
				'type' => 'submit',
				'name' => $name ?? 'submit',
				'value' => $value ?? 'save',
				'attributes' => $attributes ?? [],
				'class' => $class
			]);
		}

		final public function formConvertType( $type )
		{
			switch( strtolower($type) )
			{
				case 'dropdown':
					return 'select';
				break;

				case 'short answer':
					return 'text';
				break;

				case 'long answer':
					return 'textarea';
				break;

				default:
					return $type;
				break;
			}
		}


		private function checkExistKey($name){
			if(!isset($this->_items[$name])) {
				echo die("Key does not exist");
			}
			return true;
		}

		private function getItem($name) {
			return $this->_items[$name];
		}

		private function overWriteInputOption($inputData, $inputOption) {
			$this->errorSource = "overWriteInputOption : {$inputData['name']}";
			$inputOption = $this->validateItemData($inputOption);
			return array_merge($inputData, $inputOption);
		}

		private function validateItemData($param) {

			if(isset($data['attributes'])) {
				foreach($data['attributes'] as $attrKey => $row) {
					if(isEqual($attrKey, 'required')) {
						echo die("You are not allowed to add required in input attributes");
					}
				}
			}
			return $param;
		}

		/**
		 * merge_all_valid_attributes
		 */
		private function mergeInputAttributes($params)
		{
			$valid_array_param = [];
			if(isset($params['attributes']))
				$valid_array_param = array_merge($valid_array_param, $params['attributes']);

			if(isset($params['class']))
				$valid_array_param['class'] = $params['class'];
			
			return $valid_array_param;
		}


		/**setters */
		public function setType( $type )
		{
			$this->_type = $type;
		}

		public function setValue($name , $value)
		{
			$this->_items[$name]['value'] = $value;
		}

		public function setOptionValues($name, $optionValues = []) {
			$this->_items[$name]['option_values'] = $optionValues;
		}

		public function setValueObject($object)
		{
			$items = $this->_items;
			foreach ($items as $key => $item) {
				$name = trim($item['name']);//column_name equivalent
				if(isset($object->$name))
					$items[$key]['value'] = $object->$name;
			}
			$this->_items = $items;
			return $items;
		}

		public function setUrl($url)
		{
			$this->_form_param['url'] = $url;
		}

		/**
		 * LAZY LOADING
		 */
		public function addDescription() {
			$this->add([
				'type' => 'textarea',
				'name' => 'description',
				'options' => [
					'label' => 'Description'
				],
				
				'attributes' => [
					'rows' => 10
				],

				'class' => 'form-control',
				'required' => true
			]);
        }

        public function addAddressText() {
			$this->add([
				'type' => 'textarea',
				'name' => 'address',
				'options' => [
					'label' => 'Address',
					'rows' => 3
				],
				'class' => 'form-control',
				'required' => true
			]);
        }
		public function addAndCall($params = [])
		{
			$this->add($params);
			return $this->get($params['name']);
		}
	}