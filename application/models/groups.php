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
        $this->initialize(GROUPS_TABLE, GROUPS_GROUP_ID, GROUPS_TYPE_CODE, 
                array(GROUPS_TYPES_TABLE => GROUPS_TYPE_CODE),
                array(GROUPS_ALTNAMES_TABLE));
    }
    
 
    
}

?>
