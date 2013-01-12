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
        
        // Load libraries
        $this->load->library('session');
        $this->load->library('authentication');
        
        // Check if user is authorized to access controller
        if(!$this->authentication->check_authorization($this->security_zone)){
            echo "Access not authorized";
            exit;
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
     * Creates an alert to display on the next time display is called
     * 
     * @param string $alert Text of the alert to display
     */
    
    public function set_alert($alert){
        $this->session->set_userdata(ALERT, $alert);
        
        return TRUE;
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
           $banner_data["home_url"] = site_url("external/index");
        }
        else{
            $banner_data["home_url"] = site_url("main/index");
        }
        
        // Load actual view
        $template_data["banner"] = 
            $this->get_view("universal/banner", $banner_data);
        
        /* Determine alerts to display */
        $template_data["alert"] = ($this->session->userdata(ALERT) == TRUE) ?
            $this->get_view("universal/alert", 
                    array("content" => $this->session->userdata(ALERT))) :
            '';
        // Clear old alerts
        $this->session->unset_userdata(ALERT);
        
        $this->load->view("universal/template", $template_data);
    }
}

?>
