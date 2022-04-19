<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('month_name_to_number'))
{
    function month_name_to_number($var)
    {
        $months = array(
            'January' => 1,
            'February' => 2,
            'March' => 3,
            'April' => 4,
            'May' => 5,
            'June' => 6,
            'July' => 7,
            'August' => 8,
            'September' => 9,
            'October' => 10,
            'November' => 11,
            'December' => 12
        );

        return $months[$var];
    }   
}

if ( ! function_exists('custom_date_format_parser'))
{
    function custom_date_format_parser($date)
    {
        $dates = explode(' ', $date);
        if(sizeof($dates) == 5){
            $day = $dates[0];
            $month = month_name_to_number($dates[1]);
            $year = $dates[2];
            $time = explode(":", $dates[3]);
            $hour = (int)$time[0];
            $minutes = $time[1];
            if(strtoupper($dates[4]) == "PM"){
                $hour = $hour + 12;
            }
            //return $year .'-'.$month.'-'.$day.' '.$hour.':'.$minutes.':00';
            $timestamp = mktime($hour, $minutes, 0, $month, $day, $year);
            return Date("Y-m-d H:i:s",$timestamp);
        }
        
    }
}