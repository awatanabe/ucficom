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
     * Adds a header row to the table
     * 
     * @param mixed $column_left Content for the left column. May either be a string of the content
     * for the header cell or an array containing content and styling information such as those used
     * for table->add_row()
     * @param mixed $column_right Content for the right column.
     */
    
    public function header_row($column_left, $column_right){
        $this->CI->table->set_heading($column_left, $column_right);
    }
    
    /**
     * Adds a header row to the table that contains only one column. Equivalent for header of
     * add_line().
     * 
     */
    
    public function header_line($content, $class = "center_align"){
        $this->CI->table->set_heading(array(
            "colspan" => 2,
            "class" => $class,
            "data" => $content));
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
    
    public function add_line($content, $class = "center_align"){
        $this->CI->table->add_row(array(
            "colspan" => 2,
            "class" =>  $class,
            "data" => $content));
        return;
    }    
    
    /**
     * Basic text input. Note that default values do not need to be escaped - CI does this 
     * automatically.
     * 
     * @param type $label_text
     * @param type $name
     * @param type $default_value
     * @param bool $set_value When TRUE, will attempt to fill the form with any previously submitted values.
     */
    
    public function text_input($label_text, $name,
            $default_value = NULL, $set_value = TRUE){
        
        if($set_value == TRUE){
            $default_value = set_value($name, $default_value);
        }
        
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
     * @param bool $set_value When TRUE, will attempt to fill the form with any previously submitted values.
     */
    
    public function password_input($label_text, $name,
            $default_value = NULL, $set_value = TRUE){
        
        if($set_value == TRUE){
            $default_value = set_value($name, $default_value);
        }
        
        $this->add_input_row($label_text, $name, 
             form_password(array(
                "name"  => $name,
                "id"    => $name,
                "value" => $default_value)));    
    }  
    
    /**
     * 
     * @param type $label_text
     * @param type $name
     * @param type $value
     * @param type $checked
     * @param bool $set_checkbox When TRUE, will see if box is checked from previously submission
     */
    
    public function checkbox_input($label_text, $name, $value,
            $checked = FALSE, $set_checkbox = TRUE){
        
        if($set_checkbox == TRUE){
            $checked = set_checkbox($name, $value, $checked);
        }
        
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
     * Creates a line with a submit and cancel buttons in the right column
     * @param type $submit_label
     * @param type $extra Additional html to go in the cell
     * @param type $submit_name
     * @return type
     */
    
    public function submit_cancel($submit_label, $cancel_uri,
            $submit_color = BUTTON_ACTION, $cancel_label = "Cancel", $submit_name = SUBMIT_NAME){
        $this->add_row(
                array(
                    "class" => "right_align",
                    "data" =>  "&nbsp"),
                array(
                    "class" => "left_align",
                    "data"  => (form_submit(
                                    array(
                                        "name" => $submit_name,
                                        "value" => $submit_label,
                                        "class" => $submit_color)).
                                button($cancel_uri, $cancel_label))));
        
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
