<?php
    function occupy($viewPath)
    {
        $data = $GLOBALS['data'];

        extract($data);

        $viewPath = convertDotToDS($viewPath);

        require_once VIEWS.DS.$viewPath.'.php';
    }


    function loadTo($viewPath = 'tmp/backend')
    {
        $data = $GLOBALS['data'] ?? null;

        if( !is_null($data) )
            extract($data);

        $viewPath = convertDotToDS($viewPath);

        require_once VIEWS.DS.$viewPath.'.php';
    }

    /*COMBINE
    *FILE REQUIRE
    */
    function combine($viewPath)
    {
        $viewPath = convertDotToDS($viewPath);

        $file = VIEWS.DS.$viewPath.'.php';
        if(file_exists($file)){
            require_once $file;
        }else{
            die(" NO FILE FOUND ");
        }
    }

    function pull_view($viewPath , $data = null)
    {
        $viewPath = convertDotToDS($viewPath);

        if(isset($_GLOBALS['data']))
        {
            $globalData = $GLOBALS['data'];
            extract($globalData);
        }

        if( !is_null($data) )
            extract($data);


        $viewPath = convertDotToDS($viewPath);

        return require_once VIEWS.DS.$viewPath.'.php';
    }
    

    function grab($viewPath , $data = null)
    {
        $viewPath = convertDotToDS($viewPath);



        if(isset($_GLOBALS['data']))
        {
            $globalData = $GLOBALS['data'];
            extract($globalData);
        }


        $viewPath = convertDotToDS($viewPath);

        require_once VIEWS.DS.$viewPath.'.php';

    }

    function grab_script($path)
    {

    }

    /*BUILD
    *This will build a html content
    * and will be stored on render builds
    */
    function build($buildName)
    {
        Material::$buildInstance++;
        Material::addBuild($buildName);

        ob_start();
    }

    /*ENDBUILD
    *This will get all html inside in between build and this function
    *
    */
    function endbuild()
    {
        Material::$buildInstance;
        Material::build(ob_get_contents());

        ob_end_clean();
    }

    /*ENDBUILD
    *This will produce a render build
    */

    function produce($varName)
    {
        echo Material::show($varName);
    }
