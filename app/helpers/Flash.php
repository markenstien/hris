<?php 
    class Flash{

        const NAME = 'flash';

        /*
        *['message' , 'type' , 'name']
        */

        public static function setArray($name , $flashMessages = [])
        {
            Session::set('FLASH_ARRAY_'.$name, $flashMessages);
        }   

        public static function showArray($name)
        {
            $flashMessages = Session::get('FLASH_ARRAY_'.$name);
            Session::remove('FLASH_ARRAY_'.$name);

            $html = '';

            foreach($flashMessages as $row) 
            {
                $message = $row['message'];
                $type = isset($row['type']) ? $row['type'] : Flash::randomType();
                $type = empty($type) ? 'primary':$type;

                $html .= <<<EOF
                <div class="alert alert-{$type} mb-4" role="alert"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                        class="feather feather-x close" data-dismiss="alert">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button> 
                    {$message}
                </div>
                EOF;
            }

            print $html;
        }


        public static function randomType()
        {
            $type = ['primary' , 'success' , 'warning' , 'danger'];

            return $type[rand(0, 3)];
        }

        public static function set($message = '' , $type ='success' , $key = self::NAME){
            //set flash keyname
            if(Session::check($key)){
                Session::remove($key);
            }
            //set flash classname
            if(Session::check($key.'_class')){
                Session::remove($key.'_class');
            }
    
            Session::set($key ,$message);
            Session::set($key.'_class',$type);
            
        }

        public static function show($name = self::NAME){

            if(Session::check($name) && Session::check($name.'_class')){

                $className = Session::get($name.'_class');
                $message = Session::get($name);

                Session::remove($name); Session::remove($name.'_class');

                print <<< EOF
                <div class="flash-alert alert alert-{$className} mb-4" role="alert"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"> 
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                        class="feather feather-x close" data-dismiss="alert">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button> 
                    {$message}
                </div>
                EOF;
            }
        }


    }