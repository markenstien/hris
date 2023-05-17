<?php 
    
   
    function arr_layout_keypair($array , $key , $value = null)
    {
        $keyPair = [];


        if( !is_array($array) ){
            return [];
        }
        
        if(! is_array($key)) 
        {
            foreach($array as $row => $val) {

                if(is_object($val)){
                    $keyPair[$val->$key] = $val->$value;
                }else{
                    $keyPair[$val[$key]] = $val[$value];
                }
            }
        }else{

            $value = $key[0];
            $text  = $key[1];

            foreach($array as $row => $val) 
            {
                if(is_object($val))
                {
                    /*
                    *check if search has @
                    *Means concatinate with the textContent
                    */
                    if(strpos($text, '@'))
                    {
                        $fields = explode('@' , $text);
                        $textContent = '';

                        foreach($fields as $fieldKey => $field) 
                        {
                            $addField = trim($val->$field);

                            if(!empty($addField)) {
                                $textContent .= trim($val->$field);
                                $textContent .= ' ';
                            }
                            
                        }
                        $keyPair[$val->$value] = $textContent;
                    }else{
                        $keyPair[$val->$value] = $val->$text;
                    }
                }else{
                    $keyPair[$val[$value]] = $val[$text];
                }
            }
        }
        

        return $keyPair;
    }
    
    function arr_to_str($array)
    {
        return implode(',', $array);
    }

    function str_to_arr($string) 
    {
        return explode(',' , $string);
    }

    function obj_to_array(array $listOfArrays)
    {
        $arrayList = [];
        foreach($listOfArrays as $key => $object)
        {
            $json  = json_encode($object);
            $convertedToArray = json_decode($json, true);

            array_push($arrayList, $convertedToArray);
        } 
        
        return $arrayList;
    }

        
    function is_assoc($arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }


    /*RESETS ARRAY KEYS */
    function rm_val($array , $val) 
    {
        if (($key = array_search($val, $array)) !== false) {
            unset($array[$key]);
        }

        return array_values($array);
    }

    function rm_index($array , $index)
    {
        unset($array[$index]);
        return array_values($array);
    }


    function rm_empty($array)
    {
        $isAssoc = is_assoc($array);

        foreach($array as $key => $val){
            if(empty($val))
                unset($array[$key]);
        }

        return array_values($array);
    }

    function rm_key(){

    }

    function array_rebuild_item($items , $array)
    {
        $newArray = [];

        try{
            foreach($items as $key => $row) 
            {
                if(array_key_exists($row , $array)) {
                    $newArray[$row] = $array[$row];
                }else{
                    throw new Exception("key '{$row}' not found");
                }
                
            }
        }catch(Excetion $e) 
        {
            $e->getMessage();
        }

        return $newArray;
    }

    /**
     * keys accept string and array
     */
    function array_remove_kitem($keys , $array)
    {
        if(is_array($keys)) {

            foreach($keys as $key => $row) 
            {
                $keyExists = array_key_exists($row , $array);

                if($keyExists !== FALSE) {
                    unset($array[$row]);
                }
            }
        }else{
            $keyExists = array_key_exists($keys , $array);
            
            if($keyExists !== FALSE) {
                unset($array[$keys]);
            }
        }
        return $array;
    }

    function keypair_to_str($arr)
    {
        $strArr = '';

        foreach($arr as $key => $value){
            $strArr .= " {$key} = '$value'";
        }
        
        return $strArr;
    }



    /*NNWWW REPLACE key_pair_to_str function*/
    function keypairtostr($arr , $separator = null , $rowSeparator = null , $valueWrapper = null)
    {
        $strArr = '';


        if( is_null($valueWrapper))
            $valueWrapper = "'";

        if( is_null($separator))
            $separator = '=';

        $arrCount = count($arr);

        foreach($arr as $key => $value)
        {
            $strArr .= " {$key} {$separator} {$valueWrapper}{$value}{$valueWrapper}";
                if(!is_null($rowSeparator))
                    $strArr .= "$rowSeparator";
        }
        return $strArr;
    }