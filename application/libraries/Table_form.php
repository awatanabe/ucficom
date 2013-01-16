<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/* * *
 * Table_form.php
 * UC FiCom - January 2013
 * Aaron Watanabe - awatanabe@college.harvard.edu
 * 
 * DESCRIPTION
 */

/**
 * Description of Table_form
 *
 * @author aaronwatanabe
 */
class Table_form {
    
    // Code Igniter super object
    private $CI;    
    
    private $header_set;
    
    // Holder for various data
    private $form_data;
    
    public function __construct(){
        
        /* Get instance of the CodeIgniter super object */
        $this->CI =& get_instance();
        
        // Load helpers
        $this->CI->load->helper('html');
        $this->CI->load->helper('form');
        
        // Load libraries
        $this->CI->load->library('table');
        
        // Clear the table
        $this->CI->table->clear();
        
        /* Initialize properties */
        
        // Keeps track of whether the header row has been set
        $this->header_set = FALSE;
        $this->form_data    = array(
            "attributes" => NULL,
            "hidden" =>     NULL);
    }
    
    /**
     * Adds a generic row to the table. Left column has a label and the right
     * column has some type of input specified by the html.
     * 
     * @param type $label_text
     * @param type $name
     * @param type $input_html
     */
    
    public function add_row($label_text, $name, $input_html){
        $this->CI->table->add_row(
            form_label($label_text, $name),
            $input_html);  
        return;
    }
    
    /**
     * Adds a single column line to table
     * 
     * @param type $label_text
     * @param type $name
     * @param type $input_html
     */
    
    public function add_line($content){
        $this->CI->table->add_row(array(
            "colspan" => 2,
            "data" => $content));
        return;
    }    
    
    /**
     * Basic text input.
     * 
     * @param type $label_text
     * @param type $name
     * @param type $default_value
     */
    
    public function text_input($label_text, $name, $default_value = NULL){
        $this->add_row($label_text, $name, 
             form_input(array(
                "name"  => $name,
                "id"    => $name,
                "value" => $default_value)));    
    }
 
    
    
    /**
     * Password input
     * 
     * @param type $label_text
     * @param type $name
     * @param type $default_value
     */
    
    public function password_input($label_text, $name, $default_value = NULL){
        $this->add_row($label_text, $name, 
             form_password(array(
                "name"  => $name,
                "id"    => $name,
                "value" => $default_value)));    
    }    
    
    public function submit($submit_label, $submit_name = SUBMIT_NAME){
        $this->add_line(form_submit($submit_name, $submit_label));
        return;
    }
            
    
    public function add_form_attribute($attribute, $value){
        $this->form_data["attributes"][$attribute] = $value;
        return;
    }
    
    public function add_hidden($field, $value){
        $this->form_data["hidden"][$field] = $value;
        return;
    }    
    
    public function generate($action, $pre_text = '', $post_text = ''){
        $return_string = form_open($action, 
                $this->form_data["attributes"],
                $this->form_data["hidden"]);
        
        // Add pretext
        $return_string .= $pre_text;
        
        // Add the table
        $return_string .= $this->CI->table->generate();
        
        // Add the posttext
        $return_string .= $post_text;
        
        // Close the form
        $return_string .= form_close();
        
        // Return the whole sheebang
        return $return_string;
    }
    
    
}

?>
