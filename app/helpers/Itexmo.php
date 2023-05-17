<?php   
    class Itexmo
    {
        public static function fire($message , $number)
        {
            //message , receipients
            if(is_array($number)){
                //do other thing
                return;
            }

            $ch = curl_init();

            $itexmo = array(
                '1' => $number,
                '2' => $message,
                '3' => ITEXMO['key'],
                'passwd' => ITEXMO['pwd']
            );

            curl_setopt($ch, CURLOPT_URL,"https://www.itexmo.com/php_api/api.php");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($itexmo));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            return curl_exec ($ch);

            curl_close ($ch);
        }
}