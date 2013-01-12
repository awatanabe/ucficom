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
class users extends CI_Model {
   
    public function __construct()
	{
		$this->load->database();
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
    
    /**
     * Selects a single user where column equals value. Will return false if 
     * the value is not unique
     * 
     * @param string    $column The column with the unique value to access
     * @param string    $value  The unique value
     * @return array
     */
    
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
    
}

?>
