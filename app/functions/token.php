<?php

    function random_number($length = 12)
    {
      $result = '';

        for($i = 0; $i < $length; $i++) {
            $result .= mt_rand(1, 9);
        }

        return $result;
    }

	function number_series($string, $startFrom = null){
		return str_pad($string,10,000,STR_PAD_LEFT);
	}
	
    function random_letter($length = 12)
    {
    	$sets = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    	return substr(str_shuffle($sets), 0, $length);
    }
    function get_token_random_char($length = 12 , $params = false)
    {
        $bytes = random_bytes($length);

    		if($params)
    			return strtoupper(substr(bin2hex($bytes), 0 , $length));
    		return substr(bin2hex($bytes), 0 , $length);
    }

    function seal($data)
	{
		return base64_encode(serialize($data));
	}

	function unseal($data)
	{
		try{
			return unserialize(base64_decode($data));
		}catch(Exception $e) {
			Flash::set("Unsealing information failed" , 'danger');
			return false;
		}

	}

	function token_make()
	{

		if(!Session::check('token')) {
			$token = seal(get_token_random_char(12));
			Session::set('token' , $token);
		}
		return Session::get('token');
	}

	function token_get()
	{
		return Session::get('token');
	}

	function token_get_d()
	{
		$token = token_get();
		Session::remove('token');

		return $token;
	}

	function token_get_c($token)
	{
		$savedToken = token_get_d();
		if($token != $savedToken)
			return false;
		return true;
	}

	function token_make_slug($string)
	{
		$clean = filter_var($string , FILTER_SANITIZE_STRING);
		$slug  = preg_replace('/[-?. ]/', '_', $clean);

		return $slug;
	}


	function csrf($form = null)
	{
		$token = csrfReload();

		if(is_null($form)) {
			Form::hidden('csrfToken' , $token);
		}else{
			Form::hidden('csrfToken' , $token, [
				'form' => $form
			]);
		}
	}

	function csrfGet(){
		return Session::get('csrfToken');
	}
	function csrfReload(){
		return Session::set('csrfToken' , get_token_random_char(20));
	}
	
	function csrfValidate()
	{
		$csrfToken = request()->input('csrfToken');
		$csrf = Session::get('csrfToken');

		csrfReload();

		if(empty($csrfToken))
			return true;

		if(!isEqual($csrfToken , $csrf)){
			Flash::set("Your clicking too many times (!TOKEN WARNING! TOKEN NOT MATCHED)" , 'danger');
			return request()->return();
		}
		return true;
	}

	function referenceSeries($startAt = null, $length = 10, $prefix = null, $suffix = null) {
		if (is_numeric($startAt)) {
			$reference = str_pad(($startAt+1),$length,0,STR_PAD_LEFT);
		}else{
			$reference = str_pad(random_number(5),$length,0,STR_PAD_LEFT);
		}
		return $prefix.$reference.$suffix;
	}
	