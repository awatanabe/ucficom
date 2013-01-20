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
        
        // Query prep
        $this->db->join(GROUPS_TYPES_TABLE,
                GROUPS_TABLE.".".GROUPS_TYPE."=".
                GROUPS_TYPES_TABLE.".".GROUPS_TYPE_ID);
        
        $results = $this->db->get_where(GROUPS_TABLE, 
                array(GROUPS_TYPE." !=" => GROUP_INACTIVE));
        
        return $results;
    }     
    
}

?>
