<?php

/*
* Base page and app.
*/

//Loads all the composer packages
require('vendor/autoload.php');
require_once('./config/config.php');
require_once('./classes/forecast.php');

//Cleans any left over buffers
while (@ob_end_flush());

//Loop runs in perpetuity, allowing messages to be sent everyday as long as script keeps running
while(true){

    foreach(unserialize(CITIES_TO_QUERY) as $key => $value){
        $city = $value['city'];
        $country = $value['country'];
        try{

            //Generate a five day forecast for the city
            $forecast = Forecast::getFiveDayForecast($city, $country);
            if($forecast !== false){
                //buildEmails() returns an EmailBuilder object
                $emails = $forecast->buildEmails();
                $emails->sendEmails();
            }else{
                echo ("Could not find any location data for: {$city}, {$country}.");
            }
        }catch(Exception $e){
            die($e);    
        }
    }
    //Calculates the amount of seconds until tomorrow
    $secondsTilTommorow = strtotime('tomorrow') - time();
    //Puts script to sleep until 4 hours after tomorrow begins (4 A.M.) the next day
    sleep($secondsTilTommorow + (3600 * 4));
}

?>