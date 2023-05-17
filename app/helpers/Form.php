<?php
	class Form
	{	
		public static $instance = null;

		public static function getInstance()
		{
			if( is_null(self::$instance) )
				self::$instance = new Form();

			echo self::$instance;
		}

		public static function select($name , $values , $selected = null, $attributes = null)
		{
			$isAssoc = is_assoc($values);

			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);

			$options = '';

			$selected = is_null(FormInput::get($name)) ? $selected : FormInput::get($name);

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

			echo <<<EOF
				<select name = "{$name}" {$attributes}>
					<option value=''>--Select</option>
					{$options}
				</select>
			EOF;
		}


		public static function label($html , $for = null, $attributes = null)
		{
			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);

			$html = ucwords($html);

			echo <<<EOF
				<label {$attributes} for="{$for}">
					{$html}
				</label>
			EOF;
		}

		public static function checkbox($name , $value = null, $attributes = null)
		{
			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);

			echo <<<EOF
				<input type="checkbox" name="{$name}" value="{$value}" {$attributes} />
			EOF;
		}

		public static function small($html , $attributes = NULL)
		{
			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);


			$html = ucwords($html);

			echo <<<EOF
				<small {$attributes}>
					{$html}
				</small>
			EOF;
		}

		public static function hidden($name , $value , $attributes = null)
		{
			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);

			echo <<<EOF
				<input type="hidden" name="{$name}"
					value="$value" $attributes>
			EOF;
		}

		public static function text($name , $inputValue = null , $attributes = null)
		{
			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);
			$value = is_null(FormInput::get($name)) ? $inputValue : FormInput::get($name);

			echo <<<EOF
				<input type="text" name="{$name}"
					value="$value" $attributes>
			EOF;
		}


		public static function email($name , $value = null , $attributes = null)
		{
			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);

			$value = is_null(FormInput::get($name)) ? $value : FormInput::get($name);

			echo <<<EOF
				<input type="email" name="{$name}"
					value="$value" $attributes>
			EOF;
		}

		public static function password($name , $value = null , $attributes = null , $preservePassword = false)
		{
			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);

			$value = is_null(FormInput::get($name)) ? $value : FormInput::get($name);


			if(!$preservePassword)
				$value = '';
			
			echo <<<EOF
				<input type="password" name="{$name}"
					value="$value" $attributes>
			EOF;
		}

		public static function number($name , $value = null , $attributes = null)
		{
			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);

			$value = is_null(FormInput::get($name)) ? $value : FormInput::get($name);


			echo <<<EOF
				<input type="number" name="{$name}"
					value="$value" $attributes>
			EOF;
		}

		public static function date($name , $value , $attributes = null)
		{
			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);

			$value = is_null(FormInput::get($name)) ? $value : FormInput::get($name);

			echo <<<EOF
				<input type="date" name="{$name}"
					value="$value" $attributes>
			EOF;
		}

		public static function time($name , $value , $attributes = null)
		{
			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);

			$value = is_null(FormInput::get($name)) ? $value : FormInput::get($name);

			echo <<<EOF
				<input type="time" name="{$name}"
					value="$value" $attributes>
			EOF;
		}


		public static function textarea($name , $value = null , $attributes = null)
		{
			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);

			$value = is_null(FormInput::get($name)) ? $value : FormInput::get($name);

			echo <<<EOF
				<textarea name="{$name}" $attributes>$value</textarea>
			EOF;
		}


		public static function file($name, $attributes = null)
		{
			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);

			echo <<<EOF
				<input type="file" name="{$name}" $attributes>
			EOF;
		}

		public static function submit($name , $value = null , $attributes = null)
		{
			if(is_null($attributes))
			{
				$attributes = [];
				$attributes['class'] = 'btn btn-primary btn-sm';
			}

			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);
			$value = is_null($value) ? "Submit" : $value;

			
			echo <<<EOF
				<input type="submit" name="{$name}"
					value="$value" $attributes>
			EOF;
		}

		public static function open(array $attributes)
		{
			if(!isset($attributes['method']))
				$attributes['method'] = 'post';

			if( isset($attributes['url']))
				$attributes['action'] = $attributes['url'];

			$attributes = is_null($attributes) ? $attributes : keypairtostr($attributes);

			echo <<<EOF
				<form $attributes>
			EOF;
		}


		public static function close()
		{
			echo <<<EOF
				</form>
			EOF;
		}

		public static function create($attributes)
		{
			Form::open($attributes);
			Form::close();
		}


		/*Complete button*/

		public static function submitComplete($textAndName , $formArgs , $hiddenElements , $attributes)
		{
			Form::open($formArgs);

			foreach($hiddenElements as $key => $row){
				Form::hidden($key , $row);
			}

			if(is_array($textAndName)){
				Form::submit($textAndName[0] , $textAndName[1] , $attributes);
			}else{
				Form::submit('' , $textAndName , $attributes);
			}

			Form::close();
		}
	}
