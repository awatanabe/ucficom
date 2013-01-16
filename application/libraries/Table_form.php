<?php

/* * *
 * Table_form.php
 * UC FiCom - January 2013
 * Aaron Watanabe - awatanabe@college.harvard.edu
 * 
 * Library for generating a two column table for forms. The left column contains
 * labels, the right column contains the inputs
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
     * Clears the current table
     */
    
    public function clear(){
        $this->CI->table->clear();
    }
    
    /** 
     * Adds a row to the table wtih two columns.
     * @param mixed $column_left The left column. May be either just content or an array with data for the cell just as in table->add_row
     * @param mixed $column_right The right column.
     */
    public function add_row($column_left, $column_right){
        $this->CI->table->add_row($column_left, $column_right);
    }
    
    /**
     * Adds a generic row to the table. Left column has a label and the right
     * column has some type of input specified by the html.
     * 
     * @param type $label_text
     * @param type $name
     * @param type $input_html
     */
    
    public function add_input_row($label_text, $name, $input_html){
        $this->add_row(
            array(
                "class" =>  "right_align",
                "data"  =>  form_label($label_text, $name)),
            array(
                "class" => "left_align",
                "data" =>   $input_html));

        return;
    }
    
    /**
     * Adds a single column line to table
     * 
     * @param type $label_text
     * @param type $name
     * @param type $input_html
     */
    
    public function add_line($content, $class = "center"){
        $this->CI->table->add_row(array(
            "colspan" => 2,
            "class" =>  $class,
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
        $this->add_input_row($label_text, $name, 
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
        $this->add_input_row($label_text, $name, 
             form_password(array(
                "name"  => $name,
                "id"    => $name,
                "value" => $default_value)));    
    }  
    
    public function checkbox_input($label_text, $name, $value, $checked = FALSE){
        $this->add_input_row($label_text, $name, 
            form_checkbox(
                    $name,
                    $value, 
                    $checked,
                    "id='$name'"));
    }
    
    /**
     * @param type $submit_label
     * @param type $extra Additional html to go in the cell
     * @param type $submit_name
     * @return type
     */
    
    public function submit($submit_label, $extra = '', $submit_name = SUBMIT_NAME){
        $this->add_line(form_submit($submit_name, $submit_label).$extra);
        return;
    }
            
    /**
     * Creates a line with a submit and cancel buttons.
     * @param type $submit_label
     * @param type $extra Additional html to go in the cell
     * @param type $submit_name
     * @return type
     */
    
    public function submit_cancel($submit_label, $cancel_uri, $cancel_label,
     $submit_name = SUBMIT_NAME){
        $this->add_row(
                array(
                    "class" => "right_align",
                    "data" =>  form_submit($submit_name, $submit_label)),
                array(
                    "class" => "left_align",
                    "data"  => button($cancel_uri, $cancel_label)));
        
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
