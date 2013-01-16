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
     * @param string $uri Page to link to
     * @param string $title Text to display in button.
     * @param string $color Color scheme for the button. Include other classes here.
     * @param boolean $as_form If true, creates button using a form wrapper, rather than simply styling an anchor link as button() does. This will submit $title (also the button text) through post in the SUBMIT_NAME field. This should only be used when that verification method is needed - for example, logout. 
     * @param string $attributes
     * @return string
     */
    function button($uri, $title,
            $color_class = 'normal_button', $as_form = FALSE, $extra = ''){
        
        if($as_form == TRUE){
            // Return as a form
            return form_open($uri).
                   form_submit(SUBMIT_NAME, $title, "class='$color_class' $extra").
                   form_close(); 
        }else{
            return anchor($uri, $title, "class='button $color_class' $extra");
        }
    }
?>