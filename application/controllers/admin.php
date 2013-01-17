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
        parent::__construct(ADMIN);
        
        // Load user model - controller for managing user table
        $this->load->model("users");    
        
        // Load helpers
        $this->load->helper("form");
        $this->load->helper("validation");        
        
        // Load libraries
        $this->load->library("form_validation");
        $this->load->library("table");  
        $this->load->library("table_form");
        
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
    
    public function new_user(){
                       
        // Try to create the new user if the form was submitted
        if($this->input->post('submit') == TRUE){
            
            // Set the form validation rules
            $this->form_validation->set_rules("email", "Email",
                    "required|valid_email|callback__unique_email");
            $this->form_validation->set_message("_unique_email", "This email address already exists in the system and must be unique.");
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
                $security_level = $this->_build_security_level();
                
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
        
        // Check user ID and load data
        $user_data = $this->_process_user_id($user_id);
        
        /* Check whether updates submitted and address */
        if($this->input->post('submit')){
            
            // Check that form submitted for same user - potential hack
            if(current_url() != $this->get_last()){
                $this->set_message("Error", "User IDs did not match in submitted data. Please try again.",
                        MESSAGE_ALERT);
                
                // Redirect to this page
                redirect(current_url());
            }
            
            // Set the form validation rules
            $this->form_validation->set_rules("email", "Email",
                    "required|valid_email|callback__unique_email[$user_id]");
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
                
                // Build array of fields that could be updated
                $update_fields = array(
                    USERS_FIRST_NAME =>     $this->input->post(USERS_FIRST_NAME),
                    USERS_LAST_NAME =>      $this->input->post(USERS_LAST_NAME),
                    USERS_EMAIL =>          $this->input->post(USERS_EMAIL),
                    USERS_SECURITY_LEVEL => $this->_build_security_level());                
                
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
        
        // Verify user ID and load data
        $user_data = $this->_process_user_id($user_id);  
        
        if($this->input->post(SUBMIT_NAME)){
            
            // Set form rules
            $this->form_validation->set_rules(USERS_PASSWORD, "Password", "required");
            
            // Check if submissions passed rules
            if($this->form_validation->run() == TRUE){
                
                // Update password in database
                $this->users->update_user($user_id, array(
                    USERS_PASSWORD => 
                    $this->authentication->hash_password($this->input->post(USERS_PASSWORD))));
                
                // Notify of success and return to user edit page
                $this->set_message("Password Updated", 
                        "New password set in the database.",
                        MESSAGE_SUCCESS);
                redirect(site_url("admin/edit_user/$user_id"));
            }
            else{
                // Notify error
                $this->set_message("Error", validation_errors(), MESSAGE_ALERT);
            }
        }
        
        $this->display($this->get_view("content/admin/reset_password", 
                $user_data));
    }
    
    public function deactivate_user($user_id){

        // Verify user ID and load data
        $user_data = $this->_process_user_id($user_id);

        // Attempt to delete user if requested
        if($this->input->post("submit") == TRUE){

            // Deactivate the user, retaining all data except the security level
            $this->users->deactivate_user($user_id);
            
            // Notify admin of success and return to admin home
            $this->set_message(
                    "User Deactivated",
                    html_escape($user_data[USERS_FIRST_NAME])." ".html_escape($user_data[USERS_FIRST_NAME])."'s account was deactivated.",
                    MESSAGE_SUCCESS);
            redirect(site_url("admin/index"));
            
        }
        
        $this->display($this->get_view("content/admin/deactivate_user", 
                $user_data));
    }
    
    /**
     * Reactivate a currently deactivated user
     */
    
    public function reactivate_user(){
        $this->display("TODO - Contact SysAdmin to reactivate user.");
    }
    
    /* HELPER METHODS */

    /**
     * Checks if an emails address is already present in the user table
     * Returns TRUE if email is NOT present
     * 
     * @param type $email
     * @param int $user_id Used for updating users. If the email address exists
     * in the database and belons to that user, then return is TRUE.
     * @return boolean
     */
    public function _unique_email($email, $user_id = NULL){
        
        $results = $this->users->get_unique(USERS_EMAIL, $email);
        
        if($results == FALSE){
            return TRUE;
        }
        else{
            
            if(isset($user_id) && $results[USERS_USER_ID] == $user_id){
                return TRUE;
            }
            return FALSE;
        }
         
    }
    
    /**
     * Builds the security level from a submitted form where each zone has its 
     * standard name
     * 
     * @param bool $include_common Whether to include the common external and
     * authenticated security levels
     * @return int
     */
    
    public function _build_security_level($include_common = TRUE){
        // Build new security level
        if($include_common){
            $security_level = EXTERNAL | AUTHENTICATED;            
        }
        else{
            $security_level = 0;
        }
        
        // Check and add each zone from the form
        foreach($this->INTERNAL_SECURITY_ZONES as $name => $zone_value){
            $security_level = $security_level | 
                $this->input->post($name);
        }        
        
        return $security_level;
    }    
    
    /**
     * Verifies a user id passed through URL is valid and return the user's data
     * Strips the value of the password field
     * 
     * @param int $user_id
     * @return array
     */
    
    public function _process_user_id($user_id, $active_only = TRUE){
               
        // Check that the user_id is valid
        if(is_user_id($user_id) == FALSE){
            // Alert user to bad ID and return to index
            $this->set_message( 
                    "Invalid User ID",
                    "Could not load page because of bad user ID",
                    MESSAGE_ALERT);
            redirect("admin/index");
        }
        
        // Load the user's information from the database
        $user_data = $this->users->get_unique(USERS_USER_ID, $user_id);
        
        if($user_data == FALSE ||
                ($active_only == TRUE &&
                $user_data[USERS_SECURITY_LEVEL] == INACTIVE)){
            $this->set_message(
                "Invalid User ID",
                "User does not exist",
                MESSAGE_ALERT);
            redirect("admin/index");
        }     
     
        // Strip password
        unset($user_data[USERS_PASSWORD]);              
        
        return $user_data;
    }
    
}

?>
