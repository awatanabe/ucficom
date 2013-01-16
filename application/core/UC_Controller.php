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
        $this->security_zone = $security_zone;
        
        // Load helpers
        $this->load->helper('url');
        $this->load->helper('html'); #Needed for template
        $this->load->helper("form"); #Needed for logout
        
        // Load libraries
        $this->load->library('session');
        $this->load->library('authentication');
        
        // Check if user is authorized to access controller
        if($this->authentication->check_authorization($this->security_zone) == FALSE){
            
            // If user is logged in, return to previous page and apologize
            if($this->authentication->is_logged_in() == TRUE){
                
                // Set apology messages
                $this->set_message("Unauthorized Access", 
                        "You are not authorized to access this page. Contact an administrator if you need access to this page.");
                
                redirect($this->get_last());
            }
            // Otherwise, redirect to login page
            else{
                
                // Set message
                $this->set_message("Unauthorized Access",
                        "You are not currently logged in. Log in to access this page.");
                // Set page to be redirected to after login
                $this->session->set_userdata(LOGIN_REDIRECT, current_url());
                
                // Redirect to login
                redirect(LOGIN);
            }
        }
    }
    
    /**
     * Returns the prior page within the site that the user visited. If the user
     * has not been on any pages on the site, return the external home page.
     */
    
    public function get_last(){
        $prior = $this->session->userdata(LAST_PAGE);
        if($prior == TRUE){
            return $prior;
        }
        else{
            // If user is new to site, return home page
            return EXTERNAL_HOME;
        }
    }
    
    /**
     * Shortcut for loading a view that returns the view as a string
     * 
     * @param type $view The path of the view to load
     * @param array $data Array containing dating to bind to view
     * @return string
     */
    
    public function get_view($view, array $data = NULL){
        return $this->load->view($view, $data, TRUE);
    }
    
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
    
    public function set_message($title, $message,  
            $message_type = MESSAGE_NORMAL){
        
        if($message != ''){
            
            $this->session->set_userdata(MESSAGE, array(
                "content" =>    $message,
                "type" =>       $message_type,
                "title" =>      $title));

            return TRUE;            
        }
        return FALSE;   
    }
    
    /**
     * Displays content within the default template frame. Allows for 
     * different layouts given the security zone.
     * @param type $content
     */
    
    public function display($content){
        
        // Store content for passing
        $template_data["content"] = $content;        
        
        /* Load the banner */
        $banner_data = array();

        // Determine the correct link for the home page depending on controller
        if($this->security_zone == EXTERNAL){
           $banner_data["home_url"] = site_url(EXTERNAL_HOME);
           $banner_data["action"]   = button(site_url(LOGIN), "Login");
        }
        else{
            $banner_data["home_url"] = site_url(INTERNAL_HOME);
            // This is log out rather than "logout" for a reason
            $banner_data["action"]   = $this->get_view("content/forms/logout");
        }
        
        // Load actual view
        $template_data["banner"] = 
            $this->get_view("universal/banner", $banner_data);
        
        /* Determine alerts to display */
        $template_data[MESSAGE] = ($this->session->userdata(MESSAGE) == TRUE) ?
            $this->get_view("universal/message", 
                    $this->session->userdata(MESSAGE)) :
            '';
        // Clear old alerts
        $this->session->unset_userdata(MESSAGE);
        
        $this->load->view("universal/template", $template_data);
        
        // Set the current URL as the last page visited
        $this->session->set_userdata(LAST_PAGE, current_url());
    }
    
    /**
     * Shortcut for displaying content where there is just one main view being
     * used. Note that display_view() or display() should only be called once.
     * 
     * @param type $view
     * @param type $data
     */
    
    public function display_view($view, $data = NULL){
        $this->display($this->get_view($view, $data));
    }
}

?>
