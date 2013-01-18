<?php

/* * *
 * services.php
 * UC FiCom - January 2013
 * Aaron Watanabe - awatanabe@college.harvard.edu
 * 
 * This is a general library for handling user services - i.e. functions involving sesssions and
 * data that persists across pages. This is meant to provide abstraction from the sessions variable
 */

/**
 * Description of services
 *
 * @author aaronwatanabe
 */
class services {
    
    // Codeigniter superobject
    private $CI;
    
    public function __construct() {    
        // Get instance of CodeIgniter object
        $this->CI =& get_instance();
 
        // Load helpers
        #$this->CI->load->helpers("form");        
        #$this->CI->load->helpers("html");
        #$this->CI->load->helpers("url");
        
        // Load libraries
        #$this->CI->load->library("authentication");
        #$this->CI->load->library("form_validation");     
        $this->CI->load->library("session");        
        #$this->CI->load->library("table");     
        #$this->CI->load->library("table_form");    
    }
    
    /***********************************************************************************************
     * User Tracking
     **********************************************************************************************/
    
    /**
     * Returns the prior page within the site that the user visited. If the user
     * has not been on any pages on the site, return the external home page.
     */
    
    public function get_last(){
        $prior = $this->CI->session->userdata(LAST_PAGE);
        if($prior == TRUE){
            return $prior;
        }
        else{
            // If user is new to site, return home page
            return EXTERNAL_HOME;
        }
    }
    
    /***********************************************************************************************
     * User Notification
     **********************************************************************************************/    
    
    /**
     * Creates an message to display on the next time display is called. 
     * Message must contain content in order to be set.
     * 
     * Returns TRUE if message set; returns FALSE if no content in message and 
     * thus message not set.
     * 
     * @param string $message Text of the message to display
     * @param string $message_type Type of message to display. 
     */
    
    public function set_message($title, $message, $message_type = MESSAGE_NORMAL){
        
        if($message != ''){
            
            $this->CI->session->set_userdata(MESSAGE, array(
                "content" =>    $message,
                "type" =>       $message_type,
                "title" =>      $title));

            return TRUE;            
        }
        return FALSE;   
    }
}

?>
