<?php

/* * *
 * manage_groups.php
 * UC FiCom - January 2013
 * Aaron Watanabe - awatanabe@college.harvard.edu
 * 
 * DESCRIPTION
 */

/**
 * Description of manage_groups
 *
 * @author aaronwatanabe
 */
class manage_groups extends UC_Controller{
    
    public function __construct(){
         
        // Get the estate from the parental unit
        parent::__construct(MANAGE); 
        
        // Load helpers
        $this->load->helper("validation");        
        
        // Load libraries
        $this->load->library("form_validation");
             
        // Load user model - controller for managing user table
        $this->load->model("groups");           
    }
    
    /**
     * Landing page for the manage_groups controller
     * 
     */
    public function index(){
        
        
        
        // Build table with all of the active users
        
        $this->display->display_view("content/manage_groups/index", "Manage Groups", 
                array("groups" => $this->groups->get_active()));
    }    
}

?>
