<?php

/**
 * public.php
 * UC FiCom - January 2013
 * Aaron Watanabe - awatanabe@college.harvard.edu
 * 
 * Controller for publically accessable pages of FiCom Portal
 */

/**
 * Description of public
 *
 * @author aaronwatanabe
 */
class External extends UC_Controller {
    
    public function __construct() {
        parent::__construct(EXTERNAL);
    }

    public function index(){
        echo "o hai world";
    }
}
?>
