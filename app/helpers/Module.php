<?php   

    class Module
    {

        private static $modules = null;
        private static $_asset_constant;

        public static function get($moduleName)
        {
            if(self::$modules == null) 
            {
                self::$modules = require_once APPROOT.DS.'modules'.DS.'all.php';
            }
            
            return self::$modules[$moduleName];
        }
        public static function all()
        {
            if(self::$modules == null) 
            {
                $modules = require_once APPROOT.DS.'modules'.DS.'all.php';
            }
            
            return $modules;
        }

        

        public static function getAsset($name) {
            if(self::$_asset_constant == null) 
            {
                self::$_asset_constant = require_once APPROOT.DS.'modules'.DS.'asset_constant.php';
            }
            
            return self::$_asset_constant[$name];
        }
    }