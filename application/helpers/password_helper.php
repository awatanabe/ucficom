<?php

/* Helpers for loging users in and out. Generic log in and out.
 * 
 * @author Aaron Watanabe
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

if ( ! defined('SALT_VALUE')) exit('SALT_VALUE (int) must be defined in constants.php'); 
        
if ( ! function_exists('salt_password')){
    
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
        return substr(sha1($password), 0, SALT_VALUE);
    }
    
}
        

if ( ! function_exists('hash_password')){
    
    
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
        return sha1(salt_password($hash).$hash);
    }
}

/* End of password.php */
/* application/helpers/password.php */
