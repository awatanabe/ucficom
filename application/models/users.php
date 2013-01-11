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
     * Gets active users from the database
     * 
     * @return Query Object
     */
    
    public function get_active(){
        
        $results = $this->db->get_where(USERS_TABLE, 
                array(USERS_SECURITY_LEVEL." !=" => INACTIVE));
        
        return $results;
    }   
    
    /**
     * Selects information for a given user by their email
     * 
     * @param type $email
     * @return boolean
     */
    
    public function get_by_email($email){
        
        $results = $this->db->get_where(USERS_TABLE,
                array(USERS_EMAIL => $email));
        
        // Check number of results, returning false if there were none
        if($this->db->count_all_results() == 0){
            return FALSE;
        }
        else{
            return $results->row_array();
        }
            
    }
    
}

?>
