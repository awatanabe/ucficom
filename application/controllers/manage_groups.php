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
                array("table_data" => $this->groups->get_active()));
    }    
    
    /**
     * Display all information about a group
     * 
     * @param type $group_id
     */
    
    public function view($group_id){
        
        // Get information for the group
        $template_data["group_data"] = $this->groups->get_record(GROUPS_GROUP_ID, $group_id);
        
        $this->display->display_view("content/manage_groups/view", 
                $template_data["group_data"][GROUPS_NAME], $template_data);
    }
}

?>
