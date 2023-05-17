<?php
    function appLoad($path)
    {
        $app = app();

        require_once(APP_EXTENSIONS_PATH.DS.$app.DS.$path);
    }

    function app()
    {
        $url = explode('/',$_GET['url']);
        $app = strtolower($url[0]);
        return $app;
    }

    function appName()
    {
        $app = app();

        switch($app) {
            case 'cxbook':
                return 'Customers Book';
            break;
        }
    }
    
    function appRequest($to)
      {
        $app = app();

        return URL.DS.$app.DS.$to;
    }

    function appRedirect($location)
    {
        $app = app();
        header("Location:".URL.DS.$app.DS.$location);
    }

    function appGrab($viewPath , $data = null)
    {
        $viewPath = convertDotToDS($viewPath);

        $app = app();

        $data = $GLOBALS['data'] ?? [];

        extract($data);

        $viewPath = convertDotToDS($viewPath);

        require_once APP_EXTENSIONS_PATH.DS.$app.DS.'views'.DS.$viewPath.'.php';
    }


    function appModel($model , $app = null)
    {
        $model = ucfirst($model);


        if(is_null($app))
            $app = url(0);

        $pathModel = APP_EXTENSIONS_PATH.DS.$app.DS.'models'.DS.$model.'.php';

        if(file_exists($pathModel)){

            require_once $pathModel;

            return new $model;
        }
        else{

            die($model . 'MODEL NOT FOUND');
        }
    }
    /******************************* */
    function url($position = null)
    {

        if(isset($_GET['url'])){

            $url = $_GET['url'];
            $url = rtrim($url , '/');
            $url = filter_var($url , FILTER_SANITIZE_URL);
            $url = explode('/',$url);

            if(is_null($position)) return $url;
            return $url[$position];
        }

        else{
            return FALSE;
        }
    }
    function validationFailed()
    {
        FormSession::getInstance();

        return header("Location:".request()->referrer());
    }

    function request()
    {
        return Request::getInstance();
    }

    function redirect($location)
    {
        $firstCharBackSlash = substr($location, 0,1);

        if( $firstCharBackSlash == '/')
            $location = substr($location, 1);
        
        return header("Location:".URL.DS.$location);
    }

    function makeRequest($request)
    {
        $firstChar = substr($request,0,1);

        if($firstChar == '/') {
            $request = substr($request , 1);
        }
        return URL.DS.$request;
    }

    function matchRequest($request)
    {
        $requestURI = preg_replace('/[\W]/' , '' , $_SERVER['REQUEST_URI']);
        $request    = preg_replace('/[\W]/' , '' , $request);

        if(strtolower($request) === strtolower($requestURI))
            return true;
        return false;
    }


    function err_service($message = null)
    {
        Flash::set("SERVICE ERROR : {$message}" , 'danger');

        return redirect("SystemError?page=service");
    }

    function err_lost()
    {
        return redirect("SystemError?page=lost");
    }