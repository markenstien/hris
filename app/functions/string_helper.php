<?php
        
    /*check if tomatch is array*/
    function isEqual($subject , $toMatch)
    {
        $subject = strtolower(trim($subject));

        if(is_array($toMatch))
         return in_array($subject , array_map('strtolower', $toMatch));
        return $subject === strtolower(trim($toMatch));
    }
    
    function is_email($string)
    {
        if(! filter_var($string , FILTER_VALIDATE_EMAIL))
            return FALSE;
        return TRUE;
    }

    function str_to_mobile($string)
    {
        $mobile = preg_replace("/[^0-9]/", "", trim($string));

        if( substr($mobile , 0 ,2) == '63' || substr($mobile , 0 , 1) == '9' ) {
            $mobile = '09'.substr( $mobile , 0);
        }
        return $mobile;
    }


    function is_mobile_number($string)
    {
        $mobileNumber = trim($string);

        if(strlen($string) != 11)
            return false;
        
        if( substr($string , 0 ,2)  != '09')
            return false;
            
        return true;
    }

    function str_to_email($string)
    {
        $email = preg_replace("/[^0-9a-zA-Z@._]/", "", trim($string));
        return $email;
    }

    function str_escape($value)
    {
        $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
        $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");

        return str_replace($search, $replace, $value);
    }


    function stringWrap($string , $element)
    {
      $open = "<{$element}>";
      $close = "</{$element}>";


      return "{$open}{$string}{$close}";
    }


    function crop_string($string , $length = 20)
    {
        if(strlen($string) > $length)
        {
            return substr($string, 0 , $length) . ' ...';
        }return $string;
    }
    
    function crop_words($words, $limit, $append = ' &hellip;') {
       // Add 1 to the specified limit becuase arrays start at 0
       $limit = $limit+1;
       // Store each individual word as an array element
       // Up to the limit
       $words = explode(' ', $words, $limit);
       // Shorten the array by 1 because that final element will be the sum of all the words after the limit
       array_pop($words);
       // Implode the array for output, and append an ellipse
       $words = implode(' ', $words) . $append;
       // Return the result
       return $words;
    }

    function random_color_part() {
        return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }

    function random_color() {
        return random_color_part() . random_color_part() . random_color_part();
    }
