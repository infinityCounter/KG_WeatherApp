<?php

/*
*   DEFINES GLOBAL APPLICATION CONSTANTS
*/

define('APP_ID', 'KG_WE_001');

//API Key for open weather charts
define('API_KEY', '0f3ed33262eb6288c6ee86d4a717d905');

//Actual EMPLOYEES AND CITIES SHOULD NOT BE CONSTANT
define('CITIES', file_get_contents(dirname(__FILE__) . "/" . "cities.json"));

//Toggle comment to use test.json, remove one leading forward slash in the immediately succeeding line to toggle
//*
define('EMPLOYEES', file_get_contents(dirname(__FILE__) . "/../db/employees/" . "employees.json"));
/*/
define('EMPLOYEES', file_get_contents(dirname(__FILE__) . "/../db/employees/" . "test.json"));
//*/

//Cities that the forecast should be done for
define('CITIES_TO_QUERY', serialize(array(
    array(
        'city' => 'Kingston',
        'country' => 'JM'
    ),
    array(
        'city' => 'Montego Bay',
        'country' => 'JM'
    )
)));

/*
In a production environment, these should be stored in environmental variables
and retreived using gentenv(EMAIL_USERNAME) & getenv(EMAIL_PASSWORD) & getenv(EMAIL_SENDER_NAME)
*/
define('EMAIL_USERNAME', "ek_test_acc@yahoo.com");
define('EMAIL_PASSWORD', "thisisatestaccount");
define('EMAIL_SENDER_NAME', 'Emile Keith Test Server');
define('EMAIL_HOST', 'smtp.mail.yahoo.com');
define('EMAIL_PORT', 587);
define('EMAIL_SMTP_SECURE', 'tls');

?>