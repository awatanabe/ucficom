<?php

/**
 * UC_html_helper.php
 * UC FiCom - January 2013
 * Aaron Watanabe - awatanabe@college.harvard.edu
 * 
 * Extension to natice CodeIgniter html helpter library containing helpers for
 * inuit.css grid system
 * 
 */

    if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
    
    /**
     * Generates an empty grid of specified size using a non-breaking space as
     * a place holder
     * 
     * @param int $grid_size Size of the grid
     */
    
    function empty_grid($grid_size){
        
        return "<div class='grid-$grid_size'>".nbs()."</div>";
    }
    
    /**
     * Creates a link styled as a button according the the css class button
     * 
     * @param string $uri
     * @param string $title
     * @param string $class Must include the class that styles the button
     * @param string $attributes
     * @return string
     */
    function button($uri, $title, $class = 'button', $attributes = ''){
        return anchor($uri, 
                $title,
                "class='$class' $attributes");
    }
    
?>