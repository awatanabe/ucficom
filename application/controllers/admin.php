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
    
    public $INTERNAL_SECURITY_ZONES;
    
    public function __construct(){
         
        // Get the estate from the parental unit
        parent::__construct(EXTERNAL);
        
        // Load user model - controller for managing user table
        $this->load->model("users");    
        
        // Load helpers
        $this->load->helper("form");
        
        // Load libraries
        $this->load->library("form_validation");
        $this->load->library("table");      
        
        // Unserialize internal security zones
        $this->INTERNAL_SECURITY_ZONES = unserialize(INTERNAL_SECURITY_ZONES);
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
                       
        // Try to create the new user if the form was submitted
        if($this->input->post('submit') == TRUE){
            
            // Set the form validation rules
            $this->form_validation->set_rules("email", "Email",
                    "required|valid_email|callback__unique_email");
            $this->form_validation->set_rules("first_name", "First Name", 
                    "required");
            $this->form_validation->set_rules("last_name", "Last Name", "required");
            $this->form_validation->set_rules("password", "Password", "required"); 
            // Set rules for security zones
            foreach($this->INTERNAL_SECURITY_ZONES as $name => $zone_value){
                $this->form_validation->set_rules(
                        $name, 
                        ucfirst($name),
                        "is_natural");
            }        
            
            // Try to validate the form
            if($this->form_validation->run() == TRUE){
                
                /* Create the security level - all users have basic access */
                $security_level = EXTERNAL | AUTHENTICATED;
                
                foreach($this->INTERNAL_SECURITY_ZONES as $name => $zone_value){
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
                $this->set_message("User added", $add_message, MESSAGE_SUCCESS);
                // On successful insertion, redirect to main admin page
                        redirect(site_url("admin/index"));
            }
            else{
                // Notify user of errors in the form
                $this->set_message("Error", validation_errors(), MESSAGE_ALERT);                
            }
        }
        
        // Load input form for new users
        $view_data["new_user_form"] = 
            $this->get_view("content/forms/new_user");
        
        // Load page view
        $this->display($this->get_view("content/admin/new_user", $view_data));
    }
    
    /**
     * Allows updating of a user in the database
     * 
     * @param type $user_id
     */
    
    public function edit_user($user_id){
        
        // Load validation helper
        $this->load->helper("validation");
        
        // Check that the user_id is valid
        if(is_user_id($user_id) == FALSE){
            // Alert user to bad ID and return to index
            $this->set_message( 
                    "Invalid User ID",
                    "Could not edit information for user because of bad user ID",
                    MESSAGE_ALERT);
            redirect("admin/index");
        }
        
        // Load the user's information from the database
        $user_data = $this->users->get_unique(USERS_USER_ID, $user_id);
        
        if($user_data == FALSE ||
           $user_data[USERS_SECURITY_LEVEL] == INACTIVE){
            $this->set_message(
                "Invalid User ID",
                "User does not exist",
                MESSAGE_ALERT);
            redirect("admin/index");
        }     
        
        // Remove the password field from the user's data - admin cannot view it
        unset($user_data[USERS_PASSWORD]); 
        
        /* Check whether updates submitted and address */
        if($this->input->post('submit')){
            
            // Set the form validation rules
            $this->form_validation->set_rules("email", "Email",
                    "required|valid_email|callback__unique_email");
            $this->form_validation->set_rules("first_name", "First Name", 
                    "required");
            $this->form_validation->set_rules("last_name", "Last Name", "required");
            
            // Set rules for security zones
            foreach($this->INTERNAL_SECURITY_ZONES as $name => $zone_value){
                $this->form_validation->set_rules(
                        $name, 
                        ucfirst($name),
                        "is_natural");
            }   
            
            // Validate input
            if($this->form_validation->run() == TRUE){
                
                // Build new security level
                $security_level = EXTERNAL | AUTHENTICATED;
                foreach($this->INTERNAL_SECURITY_ZONES as $name => $zone_value){
                    $security_level = $security_level | 
                        $this->input->post($name);
                }
                
                // Build array of fields that could be updated
                $update_fields = array(
                    USERS_FIRST_NAME =>     $this->input->post(USERS_FIRST_NAME),
                    USERS_LAST_NAME =>      $this->input->post(USERS_LAST_NAME),
                    USERS_EMAIL =>          $this->input->post(USERS_EMAIL),
                    USERS_SECURITY_LEVEL => $security_level);                
                
                // Attempt to update information in database
                if($this->users->update_user($user_data[USERS_USER_ID], $update_fields) == TRUE){
                    // Notify information successfully updated
                    $this->set_message(
                            "User Updated", 
                            "Information for ".html_escape($user_data["first_name"])." ".html_escape($user_data["last_name"]).
                                " successfully updated.",
                            MESSAGE_SUCCESS);
                    redirect("admin/index");
                }
                else{
                    // Notify user unsuccessful update
                    $this->set_message(
                            "Update Error", 
                            "Unable to update the information for ".
                                html_escape($user_data["first_name"])." ".
                                html_escape($user_data["last_name"]).".",
                            MESSAGE_ALERT);                    
                }
                
                
            }
            else{
                // Notify user of errors in the form
                $this->set_message("Error", validation_errors(), MESSAGE_ALERT);                
            }                
            
        }
        
        
        /* Prep the view */
        // Transform security level into array of values of each level
        foreach($this->INTERNAL_SECURITY_ZONES as $name => $value){
            // Set retain each zone's value if user is authorizes; else zero
            $internal_zones[$name] = 
                ($value & $user_data[USERS_SECURITY_LEVEL]) ?
                TRUE : FALSE;
        } 
             
        // Remove security zone from data array and replace with above array
        unset($user_data[USERS_SECURITY_LEVEL]);
        $form_data["default_values"] = array_merge($user_data, $internal_zones); 
        
        // Get form
        $template_data["edit_form"] = $this->get_view("content/forms/edit_user",
                $form_data);
        // Include user ID in the data
        $template_data["user_id"]   = $user_data[USERS_USER_ID];
                
        $this->display($this->get_view("content/admin/edit_user", 
                $template_data));
    }
    
    public function reset_password($user_id){
        $this->display("TODO");
    }
    
    public function deactive_user($user_id){
        $this->display("TODO");
    }
}

?>
