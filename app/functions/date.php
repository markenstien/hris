<?php


    // function time_since($date) {
    //    $timestamp = strtotime($date);
    //
    //    $strTime = array("second", "minute", "hour", "day", "month", "year");
    //    $length = array("60","60","24","30","12","10");
    //
    //    $currentTime = time();
    //    if($currentTime >= $timestamp) {
    //     $diff     = time()- $timestamp;
    //     for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
    //     $diff = $diff / $length[$i];
    //     }
    //
    //     $diff = round($diff);
    //     return $diff . " " . $strTime[$i] . "(s) ago ";
    //    }
    // }
    
    function nowMilitary()
    {
        return date('Y-m-d H:i:s');
    }
    function now()
    {
        return date('Y-m-d h:i:s A');
    }


    function today()
    {
        return date('Y-m-d');
    }

    function timeNow()
    {
        return date('H:i:s');
    }
    function time_since($date) 
    {
         $timestamp = strtotime($date);
         $strTime = array("second", "minute", "hour", "day", "month", "year");
         $length = array("60","60","24","30","12","10");

         $currentTime = strtotime(now());
         
         if($currentTime >= $timestamp) {

            $diff     = time()- $timestamp;

            for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) 
            {
                $diff = $diff / $length[$i];
            }

            $diff = round($diff);
            return $diff . " " . $strTime[$i] . "(s) ago ";
         }

    }
  
    function date_long($date  , $format = null , $new = false)
    {
        if($date == "" || $date == '0000-00-00')
            return 'N/A';

        if(!is_null($format))
            return date($format , strtotime($date));
        return date('Y-m-d' , strtotime($date));
    }

    function date_today(){
      return date('Y-m-d');
    }
    function date_difference($date1 , $date2)
    {
        $date1 = date_create($date1);
        $date2 = date_create($date2);

        $diff = date_diff($date1,$date2);
        return $diff->format("%a days");
    }


    function timeInMinutesToHours($timeInMinutes , $isHTML = false)
    {
        if( !is_numeric($timeInMinutes) ){
            return '';
        }

        $retVal = '';

        if($isHTML) {
            $retVal = intdiv($timeInMinutes, 60).':'. ($timeInMinutes % 60);
        }else{
            $retVal = $timeInMinutes / 60;
        }

        return $retVal;
    }

    function timeDifference($date1 , $date2)
    {
        $starttimestamp = strtotime($date1);
        $endtimestamp   = strtotime($date2);
        $difference     = ($endtimestamp - $starttimestamp) /3600;

        return $difference;
    }


    function timeConvertMinutesAndHours($time)
    {
        $time = explode(':', $time);
        if( count($time) > 0 ){
            //convertable


            list($hour , $minutes) = $time;

            $hour = intval($hour);
            $minutes = intval($minutes);

            $hourToMinutes = $hour * 60;
            $totalMinutes = $hourToMinutes + $minutes;

            return $totalMinutes;
        }
        //not convertable
        return false;
    }

    function date_generate_year($years = 10)
    {
        $curYear = (int) Date('Y');

        $previous =(int)$curYear - 10;

        $next =(int)$curYear + 10;

        $years = array();

        //last 10 years
        for($i = $previous ; $i < $curYear ; $i++)
        {
            array_push($years, $i);
        }

        for($i = $curYear ; $i < $next ; $i++)
        {
            array_push($years, $i);
        }

        return $years;
    }

    function date_get_months($type = 'short')
    {
        switch(strtolower($type))
        {
            case 'short':
                return ['jan' , 'feb' , 'mar' , 'apr' , 'may' ,'jun' , 'jul' , 'aug' , 'sep' , 'oct' , 'nov','dec'];
            break;


            case 'long':
                return ['january' , 'february' , 'march' , 'april','may','june','july','august' ,'semptember' , 'october' , 'november' , 'december'];
            break;
            case 'numeric':
                $numeric = array();
                for($i = 1 ; $i <= 12; $i++)
                {
                    $numeric[$i] = $i;
                }
                return $numeric;
            break;

            default:
            return ['jan' , 'feb' , 'march' , 'apr' , 'may' ,'jun' , 'jul' , 'aug' , 'sept' , 'oct' , 'nov','dec'];
        }
    }
