<?php
/* * *
 * users.php
 * UC FiCom - January 2013
 * Aaron Watanabe - awatanabe@college.harvard.edu
 * 
 * Model for managing user table
 */

/**
 * Access and update information in user table
 *
 * @author aaronwatanabe
 */
class Users extends UC_Model {
   
    public function __construct(){
        
        parent::__construct();
        
        // Must call initialize. Otherwise, this will break. Badly
        $this->initialize(USERS_TABLE, USERS_USER_ID);
    }    
    
    /* Implement abstract functions */
    
    protected function prep_reference() {
        return;
    }
    
    protected function prep_secondary() {
        return;
    }
        
        
    /**
     * Creates a new user for the site in the database
     * 
     * @param string $email Uesr's email
     * @param string $password User's password. Must be hashed!
     * @param string $first_name
     * @param string $last_name
     * @param int $security_level
     * @return boolean
     */
    /*
    public function new_user(
            $email,
            $password,
            $first_name,
            $last_name,
            $security_level
            ){
    
        // Put information into querry
        $this->db->set(USERS_EMAIL, $email);
        $this->db->set(USERS_PASSWORD, $password);
        $this->db->set(USERS_FIRST_NAME, $first_name);
        $this->db->set(USERS_LAST_NAME, $last_name);
        $this->db->set(USERS_SECURITY_LEVEL, $security_level);

        // Insert information into database
        $this->db->insert(USERS_TABLE);

        return TRUE;
    }
    */
    /**
     * Updates the user given by $user_id. Will replace each column specified in $fields with the new value
     * 
     * @param type $user_id
     * @param array $fields Array of fields to update where the key is the column and its value is the new value
     */
    
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
    
    public function get_active(){
        
        // Do not display the user's password
        $results = $this->db->get_where(USERS_TABLE, 
                array(USERS_SECURITY_LEVEL." !=" => INACTIVE));
        
        return $results;
    }   
}

?>
