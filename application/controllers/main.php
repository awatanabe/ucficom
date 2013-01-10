<?php

/***
 * Authentication.php
 * UC FiCom - January 2013
 * Aaron Watanabe - awatanabe@college.harvard.edu
 * 
 * Landing control for secure areas
 */

/**
 * Description of main
 *
 * @author aaronwatanabe
 */

class main extends UC_Controller {
    
    public function __construct() {
        parent::__construct(AUTHENTICATED);
    }
    
    public function index(){
        $this->display($this->load->view("content/main/index"));
    }
    
}
