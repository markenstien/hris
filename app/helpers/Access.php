<?php   


    class Access
    {
        public static function authOnly($allowOnly = null)
        {
            $auth = Auth::get('user');

            if(is_null($allowOnly))
            {
                if(!$auth) 
                    return err_lost();
                return TRUE;
            }

            if(is_array($allowOnly)){

                if(in_array($auth->type , $allowOnly))
                    return TRUE;
                return err_lost();
            }
            return TRUE;
        }
    }