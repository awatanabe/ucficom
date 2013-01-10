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
    
    public function create_new_user(
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
    
}

?>
