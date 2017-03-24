<?php

/**
* SMTPMailer
*
* @author     EMILE KEITH <emilekeith3.0@gmail.com>
* 
* Manages SMTP connection and sending of emails
*/

class SMTPMailer {

    private $mail;

    /*
    * Class constructor, returns an instance of the object 
    */
    function __construct()
    {
        //Configure class properties
        $this->config();
    }

    /**
    * Configues class $mail property for SMTP connections based on CONFIG settings
    *
    * @param string $to
    * 
    * @return void
    */
    private function config(){
        //Instantiates class property $mailer to new PHPMailer object from composer package
        $this->mail = new PHPMailer;
        //Set SMTP propert of $mail to true
        $this->mail->isSMTP();  
        $this->mail->SMTPAutoTLS = false;
        $this->mail->SMTPDebug = 2;
        $this->mail->Debugoutput = 'html'; 
        //Set SMTP host                       
        $this->mail->Host = EMAIL_HOST; 
        $this->mail->SMTPAuth = true;    
        //Set credentials of SMTP connection                           
        $this->mail->Username = EMAIL_USERNAME;                 
        $this->mail->Password = EMAIL_PASSWORD;
        //SET connection protocol, SSL or TLS
        $this->mail->SMTPSecure = EMAIL_SMTP_SECURE;
        //SET port according to connection protocol for host
        $this->mail->Port = EMAIL_PORT;
        $this->mail->setFrom(EMAIL_USERNAME, EMAIL_SENDER_NAME);
        $this->mail->isHTML(true);
        /*Options diable peer verficaion,
        * Should not be done in professional deployment
        * but done for sake of testing
        */ 
        $this->mail->SMTPOptions = array(
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
        $this->mail->addAddress($email->getRecipient());
        //Set the subject line
        $this->mail->Subject = $email->getSubject();
        //convert HTML into a basic plain-text alternative body
        $this->mail->msgHTML($email->getBody());
        //Replace the plain text body with one created manually
        $this->mail->AltBody = $this->mail->html2text($email->getBody());
        $res = $this->mail->send();
        //Remove all recipeints from the mail list
        $this->mail->ClearAllRecipients();
        if (!$res) {
            echo "Mailer Error: " . $this->mail->ErrorInfo . "<br>";
            return false;
        } else {
            echo "Message sent!" . $this->mail->ErrorInfo . "<br>";
            return true;
        }
    }
}

?>