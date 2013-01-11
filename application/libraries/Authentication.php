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
        
        // Get the user's authorization level. If new sessions, returns FALSE
        $user_authorization = $CI->session->userdata(SECURITY_LEVEL);

        // Checks if user already has sessions
        if($user_authorization){
            // Perform bitwise AND on user and controller security levels
            return $user_authorization & $security_zone;
        }
        else 
            // Start session and set user's access as public
            $CI->session->set_userdata(SECURITY_LEVEL, EXTERNAL);
            return FALSE;   
    }
    
    /**
     * Salts a password.
     * 
     * Salts a password to make it more difficult to crack in case of a database
     * breach.
     * 
     * @author Aaron Watanabe
     * @param string    $password   Password to salt
     */
    function salt_password($password){
        
        // Ensure that the length of the salt string are set
        if (defined('SALT_VALUE') == FALSE){
            exit('SALT_VALUE (int) must be defined in constants.php');         
        }
        
        return substr(sha1($password), 0, SALT_VALUE);
    }
    
        
    /**
     * Hashes a password.
     * 
     * Hashes a password to increase database security. Includes salt. Uses 
     * sha1 hashing algorithm.
     * 
     * @author Aaron Watanabe
     * 
     * @param string $password The password to hash
     * @return string
     */
       
    function hash_password($password){
        
        // Hashes password
        $hash = sha1($password);
        
        // Return salted hash
        return sha1($this->salt_password($hash).$hash);
    }    
}

?>
