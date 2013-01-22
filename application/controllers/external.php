<?php

/**
 * public.php
 * UC FiCom - January 2013
 * Aaron Watanabe - awatanabe@college.harvard.edu
 * 
 * Controller for publically accessable pages of FiCom Portal
 */

/**
 * Description of external
 *
 * @author aaronwatanabe
 */
class External extends UC_Controller {
    
    public function __construct() {
        parent::__construct(EXTERNAL);
                  
        // Load helpers
        $this->load->helper("validation");        
        
        // Load libraries
        $this->load->library("form_validation"); 
    }

    public function index(){
        $this->display->display_view("content/external/index", "Welcome");
    }
    
    public function login(){
        
        // Load user model
        $this->load->model("users");
        
        $this->load->library("table_form");
        
        // Check if the user is already logged in and return to previous if so
        if($this->authentication->is_logged_in() == TRUE){
            
            // Set message informing no re-log in
            $this->service->set_message("Already Logged In", 
                    "You are already logged in. If you need to log in as a different user, please log out first.");
            
            // Redirect to previous page
            redirect($this->service->get_last());
        }
        
         // Attempt to log user in if data entered
        if($this->input->post(SUBMIT_NAME) == TRUE){
            
            // Set rules
            $this->form_validation->set_rules(USERS_EMAIL, "Email", "required|valid_email");
            $this->form_validation->set_rules(USERS_PASSWORD, "Password", "required");
            
            // Validate form
            if($this->form_validation->run() == TRUE){
                // Get the data associated with the entered email address
                $user_data = $this->users->get_unique(USERS_EMAIL, 
                        $this->input->post(USERS_EMAIL));

                // If good credentials, log in and redirect to internal home
                if($user_data == TRUE && $user_data[USERS_PASSWORD] == 
                    $this->authentication->hash_password($this->input->post(USERS_PASSWORD))){

                    // Log user in
                    $this->authentication->log_in($user_data);

                    // Set message to notify user
                    $this->service->set_message("Login Successful", "Welcome back ".
                            $user_data[USERS_FIRST_NAME]);

                    // Get page to redirect user to
                    $redirect = $this->service->login_redirect();
                    
                    // Clear the redirect
                    $this->service->clear_redirect();
                    redirect($redirect);

                }
                else{
                    // Notify of login failure and allow user to try again
                    $this->service->set_message("Login Failed", "Invalid email address or password",
                            MESSAGE_ALERT);
                }
            }
            // Notify user of error in form
            else{
                $this->service->set_message("Error", validation_errors(), MESSAGE_ALERT);
            }            
        }
        
        // Clear redirect. If user navigates away, no longer direct to that internal page
        $this->service->clear_redirect();
        
        // Load login form
        $template_data["login_form"] = $this->display->get_view("content/forms/login");
               
        $this->display->display_view("content/external/login", "Login", $template_data);
    }
}
?>
