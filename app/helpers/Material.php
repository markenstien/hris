<?php   

class Material
{
    static $buildInstance = 0;

    static $builds = [];
    static $variables = [];


    public static function addBuild($varName)
    {
        $buildInstance = self::$buildInstance;

        self::$variables[$buildInstance] = $varName;
    }

    public static function build($build)
    {
        /** GET BUILD NUMBER INSTANCE */
        $buildInstance = self::$buildInstance;
        /** GET BUILD NAME FOR THAT INSTANCE */
        $buildName = self::$variables[$buildInstance];
        /** STORE THE BUILD TO THE NAME */
        self::$builds[$buildName] = $build;
    }
    
    public static function show($buildName)
    {
        return self::$builds[$buildName] ?? '';
    }


    public static function isInit($buildName)
    {
        if( isset( self::$builds[$buildName]))
            return true;
        return false;
    }

    public static function all()
    {
        $params = [
            'buildinstance' => self::$buildInstance,
            'variables' => self::$variables,
            'builds'    => self::$builds['scripts']
        ];


        die(var_dump($params));

        dd($params);
    }
}