<?php
    
    function _download_wrap($file_name , $path)
    {
        $path = seal(urlencode($path));

        return _route('attachment:download' , null , [
            'filename' => $file_name,
            'path' => $path
        ]);
    }

    function _download_unwrap($path)
    {
        return urldecode(unseal($path));
    }
    
    function _download($fullPath , $downloadName)
	{
		$fPathExt = explode('.' , $fullPath);
		$dPath = explode('.' , $downloadName);

		if( !isEqual( end($dPath) , end($fPathExt) ) ){
			return _page_fatal_error("Download Name extension does not match the full path extension");
		}

		return _route('download:index' , [
			'param' => seal([
				'fullPath' => $fullPath,
				'downloadName' => $downloadName
			])
		]);
	}

    function _errorWithPage( $params = [])
    {
        return die("YOU HAVE SOMERRORS");
    }

    function _requireAuth()
    {
        if( ! whoIs() ){
            Flash::set("You must have an account to access this page." , 'warning');
            return redirect( _route('sec:login') );
        }
    }

    function _route($routeParam , $parameterId = '' , $parameter = [])
    {
        $routeParam = explode(':' , $routeParam);

        $routeKey = '';
        $method  = '';

        if( count($routeParam) > 1) {
            list( $routeKey , $method) = $routeParam;
        }

        $parameterString = '';

        if( !empty($parameterId) )
        {
            if(is_array($parameterId))
            {
                $parameterString .= "?";

                $counter = 0;
                foreach($parameterId as $key => $row) 
                {
                    if( $counter > 0)
                        $parameterString .= "&";

                    $parameterString .= "{$key}={$row}";
                    $counter++;
                }
            }else{
                //parameter is id
                $parameterString = '/'.$parameterId.'?';
            }
        }

        if( is_array($parameter) && !empty($parameter))
        {
            if( empty($parameterString) )
                $parameterString .= '?';
            $counter = 0;
            foreach($parameter as $key => $row) 
            {
                if( $counter > 0)
                    $parameterString .='&';
                $parameterString .= "{$key}={$row}";
                $counter++;
            }
        }

        $routesDeclared = Route::fetchRoutes();

        $routesDeclaredKeys = array_keys($routesDeclared);


        if( !in_array($routeKey , $routesDeclaredKeys)  ){
            echo die("Route {$routeKey} doest not exists");
        }

        $calledRoute = $routesDeclared[$routeKey];

        $calledRouteKeys = array_keys($calledRoute);

        if( !in_array($method, $calledRouteKeys)){
            echo die("Route {$routeKey} doest not have {$method} method does not exist!");
        }
        
        return $calledRoute[$method].$parameterString;
    }
    

    function _projectActivity($projectId , $message , $href , $createdBy)
    {
        $systemModel = model('SystemMetaModel');

        $system = $systemModel->getInstance();
        
        return $system->store([
            'meta_id' => $projectId,
            'meta_key' => 'PROJECT_NOTIFICATION',
            'value'    => $message,
            'href'     => $href,
            'created_by' => $createdBy
        ]);
    }

    function _asset_key($name) {
        return Module::getAsset($name);
    }
