<?php

/* * *
 * UC_Model.php
 * UC FiCom - January 2013
 * Aaron Watanabe - awatanabe@college.harvard.edu
 * 
 * Template model for specific models to draw off. There should be one implementation of the model
 * per primary table. 
 */

/**
 * Description of UC_Model
 *
 * @author aaronwatanabe
 */
abstract class UC_Model extends CI_Model{
   
    // Name of the primary table
    protected $primary_table;
    
    public function __construct($primary_table){
        // Load database connects    
        $this->load->database();
        
        // Set the name of the primary table
        $this->primary_table = $primary_table;
    }    
    
    /**
     * This abstract function is for performing other joins on reference tables
     */
    abstract protected function prep_reference();
    
    /**
     * Prep dependent tables (i.e. tables that contain additional information for element in the
     * primary tables).
     */
    abstract protected function prep_secondary();
    
    /**
     * Creates a new entry in the primary table
     * 
     * @param array $entry_data The data to enter into the primary table. Keys are column names. 
     * Must respect column naming and unique elements in entry data - otherwise database entry will
     * fail. Any data for reference columns must use the reference id as opposed to the reference
     * value
     */
    
    public function new_entry($entry_data){

        // Insert information into database
        $this->db->insert($this->primary_table, $entry_data);

        return TRUE;
    }
    
    /**
     * Updates the user given by $user_id. Will replace each column specified in $fields with the new value
     * 
     * @param type $user_id
     * @param array $fields Array of fields to update where the key is the column and its value is the new value
     */
    /*
    public function update_user($user_id, array $fields){
        
        // Check that some fields are not being updated
        if(array_key_exists(USERS_USER_ID, $fields) == TRUE){
            return FALSE;
        }
        
        $this->db->where(USERS_USER_ID, $user_id);
        $this->db->update(USERS_TABLE, $fields);
        
        return TRUE;
    }
    
    public function deactivate_user($user_id){
        
        // Deactivate by setting the security level to inactive
        $this->db->where(USERS_USER_ID, $user_id);
        $this->db->update(USERS_TABLE, array(
            USERS_SECURITY_LEVEL => INACTIVE
        ));
        
        return TRUE;
    }
    
    /**
     * Gets active users from the database. Will return all columns except 
     * password
     * 
     * @return Query Object
     */
    /*
    public function get_active(){
        
        // Do not display the user's password
        $results = $this->db->get_where(USERS_TABLE, 
                array(USERS_SECURITY_LEVEL." !=" => INACTIVE));
        
        return $results;
    }   
    
    /**
     * Selects a single user where column equals value. Will return false if 
     * the value is not unique
     * 
     * @param string    $column The column with the unique value to access
     * @param string    $value  The unique value
     * @return array
     */
    /*
    public function get_unique($column, $value){
        
        $results = $this->db->get_where(USERS_TABLE,
                array($column => $value));
        
        // Check results, returning false if there is no unique match
        if($this->db->count_all_results() != 1){
            return FALSE;
        }
        else{
            return $results->row_array();
        }
            
    }
    */

}

?>
