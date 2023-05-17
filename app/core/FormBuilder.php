<?php
	namespace Core;

	class FormBuilder
	{
		public function select($name , $values , $selected = null, $attributes = null)
		{
			$isAssoc = is_assoc($values);

			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);

			$options = '';

			$selected = is_null(\FormInput::get($name)) ? $selected : \FormInput::get($name);

			foreach($values as $key => $value)
			{
				$select = '';

				if($isAssoc)
				{
					if(! is_null($selected)) 
					{
						if( isEqual( $key , $selected ) )
							$select = 'selected';
					}

					if(!empty($value)){
						$options .= "<option value='{$key}' {$select}> {$value} </option>";
					}
					
				}else{
					if(! is_null($selected)) {

						if(strtolower($value) == strtolower($selected)){
							$select = 'selected';
						}
					}

					if(!empty($value)){
						$options .= "<option value='{$value}' {$select}> {$value}</option>";
					}
					
				}
			}

			return <<<EOF
				<select name = "{$name}" {$attributes}>
					<option value=''>--Select</option>
					{$options}
				</select>
			EOF;
		}


		public function label($html , $for = null, $attributes = null)
		{	
			$attributes['class'] = ' col-form-label ';

			if( isset($attributes['class']) )
			{
				$attributes['class'] .= ' col-form-label ';
			}else{
				$attributes['class'] = ' col-form-label ';
			}

			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);

			$html = ucwords($html);

			return <<<EOF
				<label {$attributes} for="{$for}">
					{$html}
				</label>
			EOF;
		}

		public function checkbox($name , $value = null, $attributes = null)
		{
			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);

			return <<<EOF
				<input type="checkbox" name="{$name}" value="{$value}" {$attributes} />
			EOF;
		}

		public function small($html , $attributes = NULL)
		{
			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);


			$html = ucwords($html);

			return <<<EOF
				<small {$attributes}>
					{$html}
				</small>
			EOF;
		}

		public function hidden($name , $value , $attributes = null)
		{
			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);

			return <<<EOF
				<input type="hidden" name="{$name}"
					value="$value" $attributes>
			EOF;
		}

		public function text($name , $inputValue = null , $attributes = null)
		{
			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);
			$value = is_null(\FormInput::get($name)) ? $inputValue : \FormInput::get($name);

			return <<<EOF
				<input type="text" name="{$name}"
					value="$value" $attributes>
			EOF;
		}


		public function email($name , $value = null , $attributes = null)
		{
			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);

			$value = is_null(\FormInput::get($name)) ? $value : \FormInput::get($name);
			return <<<EOF
				<input type="email" name="{$name}"
					value="$value" $attributes>
			EOF;
		}

		public function password($name , $value = null , $attributes = null , $preservePassword = false)
		{
			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);

			$value = is_null(\FormInput::get($name)) ? $value : \FormInput::get($name);


			if(!$preservePassword)
				$value = '';
			
			return <<<EOF
				<input type="password" name="{$name}"
					value="$value" $attributes>
			EOF;
		}

		public function number($name , $value = null , $attributes = null)
		{
			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);

			$value = is_null(\FormInput::get($name)) ? $value : \FormInput::get($name);


			return <<<EOF
				<input type="number" name="{$name}"
					value="$value" $attributes>
			EOF;
		}

		public function date($name , $value , $attributes = null)
		{
			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);

			$value = is_null(\FormInput::get($name)) ? $value : \FormInput::get($name);

			return <<<EOF
				<input type="date" name="{$name}"
					value="$value" $attributes>
			EOF;
		}

		public function time($name , $value , $attributes = null)
		{
			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);

			$value = is_null(\FormInput::get($name)) ? $value : \FormInput::get($name);

			return <<<EOF
				<input type="time" name="{$name}"
					value="$value" $attributes>
			EOF;
		}


		public function textarea($name , $value = null , $attributes = null)
		{
			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);

			$value = is_null(\FormInput::get($name)) ? $value : \FormInput::get($name);

			return <<<EOF
				<textarea name="{$name}" $attributes>$value</textarea>
			EOF;
		}


		public function file($name, $attributes = null)
		{
			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);

			return <<<EOF
				<input type="file" name="{$name}" $attributes>
			EOF;
		}

		public function submit($name , $value = null , $attributes = null)
		{
			if(is_null($attributes))
			{
				$attributes = [];
				$attributes['class'] = 'btn btn-primary btn-sm';
			}

			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);
			$value = is_null($value) ? "Submit" : $value;

			
			return <<<EOF
				<input type="submit" name="{$name}"
					value="$value" $attributes>
			EOF;
		}

		public function open(array $attributes)
		{
			if(!isset($attributes['method']))
				$attributes['method'] = 'post';

			if( isset($attributes['url']))
				$attributes['action'] = $attributes['url'];

			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);
			return <<<EOF
				<form $attributes>
			EOF;
		}


		public function close()
		{
			return <<<EOF
				</form>
			EOF;
		}

		public function call($type , $name , $value , $attributes)
		{
			return call_user_func([$this , $type], ...[$name , $value , $attributes]);

		}
	}