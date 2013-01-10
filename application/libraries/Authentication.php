<?php

/***
 * Authentication.php
 * UC FiCom - January 2013
 * Aaron Watanabe - awatanabe@college.harvard.edu
 * 
 * Helper function for user authentication and authorization such as password 
 * hashing.
 */

/**
 * Description of Authentication
 *
 * @author aaronwatanabe
 */
class Authentication {
    
    /**
     * Checks whether a user is authorized to access a given security level
     * 
     * @param type $security_zone
     */
    public function check_authorization ($security_zone){
        
        // If the zone is public, then clear immediately
        if($security_zone == EXTERNAL){
            return TRUE;
        }
        
        // Initialize sessions library
        $CI =& get_instance();
        $CI->load->library('session');
        
        // Get the user's authorization level from sessions
        $user_authorization = $CI->session->userdata(SECURITY_LEVEL);

        // Checks if user is logged in at all
        if($user_authorization){
            // Perform bitwise AND on user and controller security levels
            return $user_authorization & $security_zone;
        }
        else 
            return FALSE;   
    }
    
}

?>
