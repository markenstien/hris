<?php   

    class Auth
    {
        public static $PREFIX = 'AUTH';

        private $error = [];

        public function set($data)
        {
            Session::set('auth' , $data);
        }

        public static function get(){
            
            return Session::get('auth');
        }

        public function stop($name = 'auth')
        {
            Session::remove($name);

            if( Session::check($name) )
            {
                $error [] = "Logout failed!";
                return false;
            }else{
                return true;
            }
        }
    }