<?php   
    class Session
    {   
        public static function set($name,$value)
        {
            $_SESSION[$name] = $value;

            return $_SESSION[$name];
        }
        public static function check($name)
        {
            return isset($_SESSION[$name]) ? true : false;
        }
        
        public static function reset($name){
            $_SESSION[$name] = [];
        }
        
        public static function remove($name){
            unset($_SESSION[$name]);
        }
        
        public static function get($name)
        {
            return $_SESSION[$name] ?? '';
        }
    }