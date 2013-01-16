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
    
    // Code Igniter object
    private $CI;
    
    public function __construct() {
 
        // Get Instance of CodeIgniter object
        $this->CI =& get_instance();
        
        // Load libraries
        $this->CI->load->library('session');
     
    }
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
        
        // Get the user's authorization level. If new sessions, returns FALSE
        $user_authorization = $this->CI->session->userdata(SECURITY_LEVEL);

        // Checks if user already has sessions
        if($user_authorization){
            // Perform bitwise AND on user and controller security levels
            return $user_authorization & $security_zone;
        }
        else 
            // Start session and set user's access as public
            $this->CI->session->set_userdata(SECURITY_LEVEL, EXTERNAL);
            return FALSE;   
    }
    
    /**
     * Checks whether the current user is logged in. Does not check whether the
     * user is authorized to access the current page. Use check_authorizaiton 
     * for that purpose
     */
    
    public function is_logged_in(){
        return $this->CI->session->userdata(SECURITY_LEVEL) & AUTHENTICATED;
    }
    
    
    /**
     * Marks a user as logged inw ith the given security level
     * 
     * @param type $security_level The user's security level
     */
    
    public function log_in($security_level){
        
        // Set user's security level in sessions
        $this->CI->session->set_userdata(SECURITY_LEVEL, $security_level);
        
        return TRUE;
    }
    
    public function log_out(){
        
        // Hack to unset only the non-critical parts of the session
        // Source: http://stackoverflow.com/questions/10509022/codeigniter-unset-all-userdata-but-not-destroy-the-session
        $user_data = $this->CI->session->all_userdata();

        foreach ($user_data as $key => $value) {
            if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
                $this->CI->session->unset_userdata($key);
            }
        }
        
        return TRUE;
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
    
    /**
     * Returns an array of the security zones a given security level can access
     * 
     * @param   int $security_level The security level to analyze
     * @return  array
     */
    
    function security_to_string($security_level){
        
        $results = array();
        
        // Get all the security zones
        $SECURITY_ZONES = unserialize(SECURITY_ZONES);

        // Remove public
        unset($SECURITY_ZONES["External"]);
        
        foreach($SECURITY_ZONES as $zone_name => $security_zone){
            // Add to result array if there is a match
            if($security_level & $security_zone){
                $results[] = $zone_name;
            }
        }
        
        // Return results
        return $results;
    }
}

?>
