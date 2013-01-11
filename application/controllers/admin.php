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
        
        // Get a table of all users
        $user_table = $this->table->generate($this->users->get_active());
        
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
        
        if($this->users->get_by_email($email) == FALSE){
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
        $this->load->library("authentication");
        
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
                
                // Create the security level
                $security_level = 
                    $this->input->post("admin")     |
                    $this->input->post("manage")    |
                    EXTERNAL                        |
                    AUTHENTICATED;
                
                // Hash the password
                $hashed_password = $this->authentication->hash_password(
                        $this->input->post("password"));


              
                
                // Put the user in the database
                $this->users->new_user(
                        $this->input->post("email"),
                        $hashed_password,
                        $this->input->post("first_name"),
                        $this->input->post("last_name"),
                        $security_level
                        );
                        
                        // On successful insertion, redirect to main admin page
                        redirect(site_url("admin/index"));
            }
            else{
                echo "hai";
            }
        }
        
        // Load input form for new users
        $view_data["new_user_form"] = 
            $this->get_view("content/forms/new_user");
        
        // Load page view
        $this->display($this->get_view("content/admin/new_user", $view_data));
    }
}

?>
