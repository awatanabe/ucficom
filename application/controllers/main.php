<?php

/***
 * Authentication.php
 * UC FiCom - January 2013
 * Aaron Watanabe - awatanabe@college.harvard.edu
 * 
 * Landing control for secure areas
 */

/**
 * Description of main
 *
 * @author aaronwatanabe
 */

class main extends UC_Controller {
    
    public function __construct() {
        parent::__construct(AUTHENTICATED);
    }
    
    public function index(){
        $this->display->display_view("content/main/index", "Interal Home");
    }
    
    /**
     * Logs out the user and redirects to the external home page
     */
    
    public function logout(){
        
        // Make this so that log out can't be done through direct access
        if($this->input->post(SUBMIT_NAME) == TRUE){
            
            // Set user as logged out
            $this->authentication->log_out();

            // Notify user they have logged out
            $this->service->message("Logout Successful", "Goodbye");
            
            // Redirects to external home page
            redirect(EXTERNAL_HOME);            
        }
            
        // Load logout form
        $template_data["logout_form"] = $this->display->get_view("content/forms/logout");
        
        $this->display->display_view("content/main/logout", "Logout", $template_data);        
    }
    
}
