<?php

/**
* EmailBuilder
*
* @author     EMILE KEITH <emilekeith3.0@gmail.com>
* 
* Creates and processes batch email operations according to weather forecast
*/

require_once('email.php');
/*
* install PEAR library and uncomment below line to enable multi-threading
* require_once('emailThread.php');
* 
* Comments in sendEmails should aslo be toggled
*/

class EmailBuilder {

    private $weatherStatus;
    private $city;
    private $country;
    private $emails = [];

    /**
    * Class constructor, returns an instance of the object instancianted with passed arguments
    *
    * @param array $weatherStatus
    * @param string $city
    * @param string $country
    *
    */

    function __construct($weatherStatus, $city, $country){
        $this->weatherStatus = $weatherStatus;
        $this->city = $city;
        $this->country = $country;
        $this->constructEmails();
    }

    /**
    * Constructs $emails including headers and bodies, readying them for sending
    *
    * @return void
    */
    public function constructEmails(){

        foreach (json_decode(EMPLOYEES) as $index => $employee) {
            if($employee->city === $this->city && $employee->country === $this->country){

                $headers =  'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= 'From: '. EMAIL_USERNAME . "\r\n";
                $body = $this->renderTemplate($employee, $this->city . ", " . $this->country);
                array_push($this->emails, new Email($employee->email, EMAIL_USERNAME , $body, $headers));
            }
        }
    }

    /**
    * Returns $emails property of instance
    *
    * @return array
    */
    public function getEmails(){

        return $this->emails;
    }

    /**
    * Performs batch sending of emails using SMTPSender class
    * toggle commented code to enable multi-threading after install
    * and enabling PEAR extension
    * 
    * @return void
    */
    public function sendEmails(){

        $mailer = new SMTPMailer(); //Instantiates object of the SMTP class
        foreach($this->emails as $key => $email){

            //To toggle comment simply add a forwardslash (/) to the beginning of the following line
            /*
            $emailThread = new EmailThread($email);
            $emailThread->start();
            /*/
            $mailer->sendEmail($email); //Sends email using SMTP
            //*/
        }
    }

    /**
    * Renders body template of email. 
    *
    * @param object $employee
    * @param string $location
    *
    * @return string
    */
    private function renderTemplate($employee, $location){

        $name = $employee->name;
        $role = $employee->role;
        $adviceList; //list of recommendations based on weather forecast per day
        $conditions = [];

        foreach($this->weatherStatus as $date => $status){
            $adviceList[$date] = []; //Create new empty array and assign it to new key property of list
            $conditions[$date] = $status;
            if($status === false){ //$status is only true if it will rain on the day

                array_push($adviceList[$date], "Please be advised that you will have a full 8 hour work day.");
            }else{
                //Add recommendations to array
                array_push($adviceList[$date], "Work will only be 4 hours instead of the usual 8.");
                if(strtolower($role) !== "non-it role"){ //It individuals should not head unto streets to work in case of rain
                    array_push($adviceList[$date], "Do not head out into the streets to work.");
                }
            }
        }
        
        ob_start(); //Creates an output buffer to which all output will be redirected

        require(dirname(__FILE__) . '/../templates/email.php'); //Load template

        $body = ob_get_clean(); //Return contents of buffer and destroy it
        while (@ob_end_flush()); //Just in case
        return $body;//return contents of buffer, which is the populate template
    }
}


?>