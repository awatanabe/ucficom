<?php

/* * *
 * display.php
 * UC FiCom - January 2013
 * Aaron Watanabe - awatanabe@college.harvard.edu
 * 
 * Library for loading views in any orderly fashion to achieve some degree of layout consistency.
 */

class Display {
    
    // Codeigniter superobject
    private $CI;
    
    public function __construct() {
        // Get instance of CodeIgniter object
        $this->CI =& get_instance();
 
        // Load helpers
        $this->CI->load->helpers("form");        
        $this->CI->load->helpers("html");
        $this->CI->load->helpers("url");
        
        // Load libraries
        $this->CI->load->library("authentication");
        $this->CI->load->library("form_validation");
        $this->CI->load->library("service");
        $this->CI->load->library("session");        
        $this->CI->load->library("table");     
        $this->CI->load->library("table_form");
    }
    
    /**
     * Shortcut for loading a view that returns the view as a string
     * 
     * @param type $view The path of the view to load
     * @param array $data Array containing dating to bind to view
     * @return string
     */
    
    public function get_view($view, array $data = NULL){
        return $this->CI->load->view($view, $data, TRUE);
    } 
    
    /**
     * Displays content within the default template frame. Allows for 
     * different layouts given the security zone.
     * @param type $content
     * @param string $title Page title to display is browser bar
     */
    
    public function display($content, $title = ''){
        
        // Store content for passing
        $template_data["content"] = $content;        
        
        // Store title - format with colon only if title text
        $template_data["title"] = ($title == '') ? '' : ": $title";
        
        /* Load the banner */
        $banner_data = array();

        // Determine the correct link for the home page depending on controller
        if($this->CI->authentication->is_logged_in() == TRUE){
            $banner_data["home_url"] = site_url(INTERNAL_HOME);
            // This is log out rather than "logout" for a reason
            $banner_data["action"]   = button(LOGOUT, "Log Out", "normal_button", TRUE);
        }
        else{
            // Display public side baner
            $banner_data["home_url"] = site_url(EXTERNAL_HOME);
            $banner_data["action"]   = button(site_url(LOGIN), "Login");
        }
        
        // Load actual view
        $template_data["banner"] = 
            $this->get_view("universal/banner", $banner_data);

        /* Load navigation bar */
        $template_data["navigation"] = $this->get_view("universal/navigation");
        
        /* Determine alerts to display */
        $template_data[MESSAGE] = $this->CI->service->message();

        $this->CI->load->view("universal/template", $template_data);
        
        /* Cleanup - state data to change only on successful load of the view */
        // Clear old message
        $this->CI->session->unset_userdata(MESSAGE);
        // Set the current URL as the last page visited
        $this->CI->session->set_userdata(LAST_PAGE, current_url());
    }
    
    /**
     * Shortcut for displaying content where there is just one main view being
     * used. Note that display_view() or display() should only be called once.
     * 
     * @param type $view
     * @param type $data
     */
    
    public function display_view($view, $title = '', array $data = NULL){
        $this->display($this->get_view($view, $data), $title);
    }    
    
}

?>
