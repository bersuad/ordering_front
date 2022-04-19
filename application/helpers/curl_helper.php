<?php
    defined('BASEPATH') or exit('No direct script access allowed');

    function search_location($word){        
        
        $url = "http://197.156.65.169/map_server/api/map/location_name?key=@ay1\$df1hf0gs@01oxxp98l&term=$word";        

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);     
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT_MS, 1000); 
        curl_setopt($curl, CURLOPT_TIMEOUT_MS, 5000); //timeout in miliseconds    
        $output = curl_exec($curl);        
        curl_close($curl);  
        return $output;  
    }