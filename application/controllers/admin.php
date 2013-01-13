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
         
        // Get the estate from the parental unit
        parent::__construct(EXTERNAL);
        
        // Load user model - controller for managing user table
        $this->load->model("users");           
    }
    
    /**
     * Landing page for the admin.
     * 
     */
    public function index(){
        
        // Load table library
        $this->load->library("table");
        
        // Build table with all of the active users
        $user_table = $this->get_view("content/admin/index_table",
                array("table_data" => $this->users->get_active()));
        
        $this->display($this->get_view("content/admin/index", 
                array("users" => $user_table)));
    }

    /**
     * Checks if an emails address is already present in the user table
     * Returns TRUE if email is NOT present
     * 
     * @param type $email
     * @return boolean
     */
    public function _unique_email($email){
        
        if($this->users->get_unique(USERS_EMAIL, $email) == FALSE){
            return TRUE;
        }
        else{
            FALSE;
        }
    }
    
    public function new_user(){
        
        // Load helpers
        $this->load->helper("form");
        
        // Load libraries
        $this->load->library("form_validation");
        $this->load->library("table"); 
        
        // Load model for database access
        $this->load->model("users");
        // Set the form validation rules
        $this->form_validation->set_rules("email", "Email",
                "required|valid_email|callback__unique_email");
        $this->form_validation->set_rules("first_name", "First Name", 
                "required");
        $this->form_validation->set_rules("last_name", "Last Name", "required");
        $this->form_validation->set_rules("password", "Password", "required");        
        $this->form_validation->set_rules("admin", "Admin", "is_natural");
        $this->form_validation->set_rules("manage", "Manage", "is_natural");        
        
        // Try to create the new user if the form was submitted
        if($this->input->post('submit') == TRUE){
            
            // Try to validate the form
            if($this->form_validation->run() == TRUE){
                
                /* Create the security level - all users have basic access */
                $security_level = EXTERNAL | AUTHENTICATED;
                // Get the internal security levels
                $INTERNAL_ZONES = unserialize(INTERNAL_SECURITY_ZONES);
                
                foreach($INTERNAL_ZONES as $name => $zone_value){
                    $security_level = $security_level |
                        $this->input->post($name);
                }
                
                // Hash the password
                $hashed_password = $this->authentication->hash_password(
                        $this->input->post("password"));
                
                // Put the user in the database
                $this->users->new_user(
                        $this->input->post("email"),
                        $hashed_password,
                        $this->input->post("first_name"),
                        $this->input->post("last_name"),
                        $security_level);
                
                // Message for successful addition
                $add_message = "User ".
                        html_escape($this->input->post("first_name"))." ".
                        html_escape($this->input->post("last_name"))." ".
                        "added to system.";
                
                // Set success message
                $this->set_message($add_message, MESSAGE_SUCCESS, "User added");
                // On successful insertion, redirect to main admin page
                        redirect(site_url("admin/index"));
            }
            else{
            }
        }
        
        // Set default values to empty
        $form_data["default_values"] = array_merge(array(
            USERS_FIRST_NAME    => '',
            USERS_LAST_NAME     => '',
            USERS_EMAIL         => '',
            USERS_PASSWORD      => ''),
            array_map(
                function ($value) { return FALSE; },
                unserialize(INTERNAL_SECURITY_ZONES)));
        
        // Get list of all security zone names
        unserialize(INTERNAL_SECURITY_ZONES);
        
        // Load input form for new users
        $view_data["new_user_form"] = 
            $this->get_view("content/forms/user_info", $form_data);
        
        // Put any errors in the form into the alert box
        $this->set_message(validation_errors(), MESSAGE_ALERT, "Error");
        
        // Load page view
        $this->display($this->get_view("content/admin/new_user", $view_data));
    }
    
    /**
     * Allows updating of a user in the database
     * 
     * @param type $user_id
     */
    
    public function edit_user($user_id){
        
        
        
    }
}

?>
