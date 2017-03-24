<?php

/**
* Photos
*
* @author     EMILE KEITH <emilekeith3.0@gmail.com>
* 
* Class that would extend pthreads from the PEAR package
*
* Note: PEAR was not installed in this project, however installing
*       the PEAR package would allow simulated multi-threading increasing
*       application efficiency
*/

class EmailThread extends Thread {
    
    private $email;

    /**
    * Class constructor, returns an instance of the object instancianted with passed arguments
    *
    * @param string $email
    *
    */
    public function __construct($email){
        $this->email = $email;
    }

    /**
    * Method overriding of parent run method. 
    * Operations executed after thread start() is executed
    *
    */
    public function run(){
        $email->send();
    }
}    
?>