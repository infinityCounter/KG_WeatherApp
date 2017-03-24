<?php

require_once('smtpMailer.php');

/**
* Email
*
* @author     EMILE KEITH <emilekeith3.0@gmail.com>
* 
* Encapsulates the data of an email and operators for said email
*/

class Email {


    private $to;
    private $from;
    private $body;
    private $subject;
    private $headers;

    /**
    * Class constructor, returns an instance of the object instancianted with passed arguments
    *
    * @param string $to
    * @param string $from
    * @param string $body
    * @param string $headers
    * @param string subject
    *
    */

    function __construct($to, $from, $body, $headers, $subject = "GraceKennedy Weather Status & Employee Work Schedule Update"){
        
        $this->setRecipient($to);
        $this->setSender($from);
        $this->setBody($body);
        $this->setSubject($subject);
        $this->setHeaders($headers);
    }

    /**
    * Class setter for property $to
    *
    * @param string $to
    * 
    * @return void
    */
    public function setRecipient($to){
        $this->to = $to;
    }

    /**
    * Class getter for property $to
    *
    * @return string
    */
    public function getRecipient(){
        return $this->to;
    }

    /**
    * Class setter for property $from
    *
    * @param string $from
    * 
    * @return void
    */
    public function setSender($from){
        $this->from = $from;
    }

    /**
    * Class getter for property $from
    *
    * @return string
    */
    public function getSender(){
        return $this->from;
    }

    /**
    * Class setter for property $body
    *
    * @param string $body
    * 
    * @return void
    */
    public function setBody($body){
        $this->body = $body;
    }

    /**
    * Class getter for property $body
    *
    * @return string
    */
    public function getBody(){
        return $this->body;
    }

    /**
    * Class setter for property $subject
    *
    * @param string $subject
    * 
    * @return void
    */
    public function setSubject($subject){
        $this->subject = $subject;
    }

    /**
    * Class getter for property $subject
    *
    * @return string
    */
    public function getSubject(){
        return $this->subject;
    }

    /**
    * Class setter for property $headers
    *
    * @param string $headers
    * 
    * @return void
    */
    public function setHeaders($headers){
        $this->headers = $headers;
    }

    /**
    * Class getter for property $headers
    *
    * @return string
    */
    public function getHeaders(){
        return $this->headers;
    }

    /**
    * Posts / Sends email to recipient  
    * 
    * @return void
    * 
    * Note: Method should only be used to send an individual instance of the email class
    *       Bulk emails should be sent with the emailBuilder
    **/
    public function send(){
        $mailer = new SMTPMailer();
        return $mailer->sendEmail($this);
    }
}

?>