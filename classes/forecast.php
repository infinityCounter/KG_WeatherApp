<?php

require_once('emailBuilder.php');

/**
* Forecast
*
* @author     EMILE KEITH <emilekeith3.0@gmail.com>
* 
* Manages requests to the Weather API and generation of emails
*/

class Forecast{

    private $forecast = null;

    /**
    * Class constructor, returns an instance of the object instancianted with passed arguments
    *
    * @param object $forecast
    *
    * @return void
    */
    function __construct($forecast){

        $this->forecast = $forecast;
    }

    /**
    * Returns EmailBuilder instance populated with appropriate emails based on $forecast property
    *
    * @return EmailBuilder
    */
    public function buildEmails(){

        $list = $this->forecast->list; //Get list of all conditions over the next 5 days from $forecast object
        $city = $this->forecast->city->name; //Gets city name for forecast
        $country = $this->forecast->city->country;//Gets city of forecast
        $willRain = [];
        $emails = [];
        foreach($list as $key => $value){
            $date = date('M/d/Y', $value->dt); //Convert datetimestamp to format M/d/Y
            if( !array_key_exists($date, $willRain)){
                //Push false to array, here it is assumed it will not rain
                $willRain[$date] = false;
            }
            $condition = strtolower($value->weather[0]->main);
            if($condition === 'rain'){ 
                //If it rains at any point in the day, set the value of the date key to true
                //Once set to true it will not be set back to false since it must rain at least once
                $willRain[$date] = true;
            }
        }
        $emailBuilder = new EmailBuilder($willRain, $city, $country); //Instantiate email builder
        return $emailBuilder;
    }

    /**
    * Gets five(5) day forecast for a particular city
    *
    * @param string $city
    * @param string $country
    *
    * @return object | bool
    *
    * @throws Exception
    */
    public static function getFiveDayForecast($city, $country){

        if(!isset($city) || !isset($country))
            throw new Exception('No City / Country Provided For Forecast Request'); //Throw exception if no city or country provided
        else{
            $appID = "APPID=" . API_KEY; //set query parameter to API key
            $callURL = 'api.openweathermap.org/data/2.5/forecast?'; //API endpoint to get 5 day forecast
            $cityID = null;
            foreach (json_decode(CITIES) as $key => $cityData) { //Iterate over all locations / cities
                if($cityData->name === $city && $cityData->country === $country)
                    $cityID = $cityData->_id; //Store matching city ID
            }
            if($cityID !== null){ 
                $callURL = $callURL . 'id=' . $cityID . '&' . $appID; //complete query parameters
            }else{ //If no cityID was found
                $callURL = $callURL . 'q=' . $city . ',' . $country;//request based on city name and country
            }

            $request = curl_init($callURL); //Create CURL resource
            curl_setopt($request, CURLOPT_RETURNTRANSFER, TRUE); //Set CURL resource option to return data
            if($requestData = curl_exec($request)){ //execute CURL request
                $foreCast = new static(json_decode($requestData)); //return new instace of class instantiated with forecast data
                curl_close($request); //close request
                return $foreCast; //return forecast instance
            }else{ //If request unsuccessful 
                curl_close($request);
                return false;
            }
        }

    }
}

?>