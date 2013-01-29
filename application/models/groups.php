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
class groups extends UC_Model{
    
    public function __construct(){
        // Call parent
        parent::__construct();
        
        // Initialize
        $this->initialize(GROUPS_TABLE, GROUPS_GROUP_ID, GROUPS_TYPE_CODE);
    }
    
    /**
     * Override the prep_reference tables to load necessary reference tables for the primary
     */
    
    public function prep_reference(){
        // Connects to type table
        $this->reference_join(GROUPS_TYPES_TABLE, GROUPS_TYPE_CODE);
        return;
    }
    
    public function prep_secondary() {
        
        // Get potential alternate names
        $this->db->join(GROUPS_ALTNAMES_TABLE,
                GROUPS_TABLE.".".GROUPS_GROUP_ID."=".
                GROUPS_ALTNAMES_TABLE.".".GROUPS_GROUP_ID,
                "left outer");    
    }    
    
}

?>
