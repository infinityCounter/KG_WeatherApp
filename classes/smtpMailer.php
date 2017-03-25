<?php

/**
* SMTPMailer
*
* @author     EMILE KEITH <emilekeith3.0@gmail.com>
* 
* Manages SMTP connection and sending of emails
*/

class SMTPMailer {

    private $connection;

    /*
    * Class constructor, returns an instance of the object 
    */
    function __construct()
    {
        //Configure class properties
        $this->config();
    }

    /**
    * Configues class $connection property for SMTP connections based on CONFIG settings
    *
    * @param string $to
    * 
    * @return void
    */
    private function config(){
        //Instantiates class property $connection to new PHPMailer object from composer package
        $this->connection = new PHPMailer;
        //Set SMTP propert of $connection to true
        $this->connection->isSMTP();  
        $this->connection->SMTPAutoTLS = false;
        $this->connection->SMTPDebug = 2;
        $this->connection->Debugoutput = 'html'; 
        //Set SMTP host                       
        $this->connection->Host = EMAIL_HOST; 
        $this->connection->SMTPAuth = true;    
        //Set credentials of SMTP connection                           
        $this->connection->Username = EMAIL_USERNAME;                 
        $this->connection->Password = EMAIL_PASSWORD;
        //SET connection protocol, SSL or TLS
        $this->connection->SMTPSecure = EMAIL_SMTP_SECURE;
        //SET port according to connection protocol for host
        $this->connection->Port = EMAIL_PORT;
        $this->connection->setFrom(EMAIL_USERNAME, EMAIL_SENDER_NAME);
        $this->connection->isHTML(true);
        /*Options diable peer verficaion,
        * Should not be done in professional deployment
        * but done for sake of testing
        */ 
        $this->connection->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ),
            'tls' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
    }

    /**
    * Sends emails over SMTP protocol
    *
    * @param Email $email
    *
    * @return bool 
    */
    public function sendEmail($email){
        $this->connection->addAddress($email->getRecipient());
        //Set the subject line
        $this->connection->Subject = $email->getSubject();
        //convert HTML into a basic plain-text alternative body
        $this->connection->msgHTML($email->getBody());
        //Replace the plain text body with one created manually
        $this->connection->AltBody = $this->connection->html2text($email->getBody());
        $res = $this->connection->send();
        //Remove all recipeints from the mail list
        $this->connection->ClearAllRecipients();
        if (!$res) {
            echo "Mailer Error: " . $this->connection->ErrorInfo . "<br>";
            return false;
        } else {
            echo "Message sent!" . $this->connection->ErrorInfo . "<br>";
            return true;
        }
    }
}

?>
