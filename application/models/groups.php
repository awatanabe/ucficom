<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* * *
 * groups.php
 * UC FiCom - January 2013
 * Aaron Watanabe - awatanabe@college.harvard.edu
 * 
 * DESCRIPTION
 */

/**
 * Description of groups
 *
 * @author aaronwatanabe
 */
class groups extends CI_Model{
    
    public function __construct(){
        $this->load->database();
    }
    
    /**
     * Gets active groups from the database
     * 
     * @return Query Object
     */
    
    public function get_active(){
        
        // Do not display the user's password
        $results = $this->db->get_where(USERS_TABLE, 
                array(USERS_SECURITY_LEVEL." !=" => INACTIVE));
        
        return $results;
    }     
    
}

?>
