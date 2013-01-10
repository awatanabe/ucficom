<?php

/* Helpers for loging users in and out. Generic log in and out.
 * 
 * @author Aaron Watanabe
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
        
if ( ! function_exists('check_authorization')){
    
    /**
     * Checks to see if the current user is authorized for the given zone
     * 
     * Relies on the security zone constants. Uses bitwise operators to check
     * if the user is authorized.
     * 
     * @author Aaron Watanabe
     * @param string    $security_zone   The security zone.
     * @return boolean
     */
    function check_authorization ($security_zone){
        
        // Get the user's authorization level from sessions
        $user_authorization = $this->session->userdata(SECURITY_LEVEL);
        
        // Check to see if the user is authorized to access controller
        
        
        if($this->session->userdata(SECURITY_LEVEL)){
            
        }       
        
        // First checks whether the user is logged in, returning FALSE if not
        
    }
    
}

/* End of authentication_helper.php */

