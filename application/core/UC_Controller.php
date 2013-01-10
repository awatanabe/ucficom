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
     * Displays content within the default template frame. Allows for 
     * different layouts given the security zone.
     * @param type $content
     */
    
    public function display($content){
        
        $template_data["content"] = $content;
        
        $this->load->view("template", $template_data);
    }
}

?>
