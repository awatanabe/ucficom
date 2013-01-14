<?php

/**
 * validation_helper.php
 * UC FiCom - January 2013
 * Aaron Watanabe - awatanabe@college.harvard.edu
 * 
 * Helpers to validate incoming data
 * 
 */

    if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
    
    /**
     * Checks whether a given input fits the form of a user ID. Note: Does not
     * check whether the input is actually a user ID in the database
     * @param type $user_id
     */
    
    function is_user_id($user_id){
        // Checks whether the variable is a number. Inval returns 0 for non
        if(intval($user_id) > 0){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    
?>
