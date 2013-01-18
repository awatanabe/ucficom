<?php

/***
 * UC_Controller.php
 * January 2013
 * Aaron Watanabe - awatanabe@college.harvard.edu
 * 
 * Basic controller class for FiCom portal 
 */

/**
 * Description of UC_Controller
 *
 * All child controllers must have a __construct method and include a security
 * zone for the 
 * @author aaronwatanabe
 */
class UC_Controller extends CI_Controller {
    
    // The security zone of the controller. Must be a power of two.
    protected $security_zone;
    
    public function __construct ($security_zone){
        
        // Wonderful inheritance from ma and pa
        parent::__construct();          
        
        // Save the security level of the controller
        $this->security_zone = (DEVELOPMENT == TRUE) ?
                EXTERNAL :
                $security_zone;
        
        // Load helpers
        $this->load->helper('url');
        $this->load->helper('html'); #Needed for template
        $this->load->helper("form"); #Needed for logout         
        
        // Load libraries
        $this->load->library("display");
        $this->load->library("service");
        $this->load->library('session');
        $this->load->library('authentication');
        
        // Check if user is authorized to access controller
        if($this->authentication->check_authorization($this->security_zone) == FALSE){
            
            // If user is logged in, return to previous page and apologize
            if($this->authentication->is_logged_in() == TRUE){
                
                // Set apology messages
                $this->service->set_message("Unauthorized Access", 
                        "You are not authorized to access this page. Contact an administrator if you need access to this page.");
                
                redirect($this->service->get_last());
            }
            // Otherwise, redirect to login page
            else{
                
                // Set message
                $this->service->set_message("Unauthorized Access",
                        "You are not currently logged in. Log in to access this page.");
                // Set page to be redirected to after login
                $this->service->login_redirect(current_url());
                
                // Redirect to login
                redirect(LOGIN);
            }
        }
    }
}

?>
