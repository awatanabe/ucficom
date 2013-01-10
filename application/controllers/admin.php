<?php

/* * *
 * admin.php
 * UC FiCom - January 2013
 * Aaron Watanabe - awatanabe@college.harvard.edu
 * 
 * Controller for system admin pages such as adding users and checking the 
 * database backend
 */

/**
 * Description of admin
 *
 * @author aaronwatanabe
 */
class admin extends UC_Controller {
    
    public function __construct(){
        parent::__construct(EXTERNAL);
    }
    
    /**
     * Landing page for the admin.
     * 
     */
    public function index(){
        $this->display($this->get_view("content/admin/index"));
    }
    
    public function new_user(){
        
        // Load helpers
        $this->load->helper("form");
        
        // Load libraries
        $this->load->library("form_validation");
        $this->load->library("table");  
        
        echo "hai";
        
        // Load input form for new users
        $view_data["new_user_form"] = 
            $this->get_view("content/forms/new_user");
        
        // Load page view
        $this->display($this->get_view("content/admin/new_user", $view_data));
    }
}

?>
