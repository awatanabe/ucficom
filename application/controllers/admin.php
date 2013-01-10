<?php

/* * *
 * admin.php
 * UC FiCom - January 2013
 * Aaron Watanabe - awatanabe@college.harvard.edu
 * 
 * Controller for system admin pages such as adding users and checking the 
 * database backend
 */

/**
 * Description of admin
 *
 * @author aaronwatanabe
 */
class admin extends UC_Controller {
    
    public function __construct(){
        parent::__construct(EXTERNAL);
    }
    
    /**
     * Landing page for the admin.
     * 
     */
    public function index(){
        $this->display($this->load->view("content/admin/index"));
    }
}

?>
