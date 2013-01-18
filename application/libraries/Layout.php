<?php
/***************************************************************************************************
 * THIS LIBRARY IS DEPRACATED. DO NOT USE
 **************************************************************************************************/


/* * *
 * layout_helper.php
 * UC FiCom - January 2013
 * Aaron Watanabe - awatanabe@college.harvard.edu
 * 
 * Helper functions for HTML layout. Meant to provide some degree of abstraction for commonly used
 * layouts
 * 
 * This library relies on the files in the views/layout directory. 
 * 
 * Syntax
 * Span - Means that the layout is high level, wrapped in a "grids" class <div> and spanning the
 * whole page
 * Section - Means wrapped in a div with a "grids-#" class
 */

class Layout {
    


    /**
     * Unpacks element in an array of standard values. For example, an array containing
     * class, id, and content for a table cell or div. Incoming data may either be a string or 
     * an array. 
     * 
     * @param mixed $raw_layout Either a string or an array. If array, content must be in the "data"
     * key
     * @param string $attributes_key Name of the key to wrap all attributes into
     * @param string $data_key Name of the key in results to put the content data
     * @param array $extract fields For each element, looks for field $value in the $raw_layout and
     * places the extracted value into $key in the return array, unsetting the element from the array
     */
    
    public function unpack_layout($raw_layout, $attributes_key = "attributes",
            $data_key = "data", $extract_fields = NULL){
        // Container for results
        $results = array();
        
        // Check if input is an array or a string
        if(is_array($raw_layout)){
            
            // Extract "data"
            $results[$data_key] = $raw_layout["data"];
            unset($raw_layout["data"]);
            
            // Extract other fields, if they exist
            if(is_array($extract_fields)){
                foreach($extract_fields as $result_key => $raw_key){
                    if(key_exists($result_key, $raw_layout) == TRUE){
                        $results[$result_key] = $text_section[$raw_key]; 
                        unset($text_section[$raw_key]);
                    }  
                }
            }    

            // Fold all others into single attributes string
            foreach($raw_layout as $attribute => $value){
                $results[$attributes_key] .= " $attribute='$value'";
            }       
        }        
        
        return $results;
    }
    
    /**
     * Creates a form span for layout with text in the left column and the form in the right.
     * Layout looks like: 
     * 1 grid gutter
     * 4 grid SECONDARY text area
     * 1 grid gutter 
     * 10 grid PRIMARY form area
     * 
     * @param mixed $text_section Can either be pure content for the <div> or an array containing
     * styling information for the <div>. In that case, content should have the key "data"
     * @param mixed $form_section Content for the primary, form area. Ccan be either pure content
     * or an array.
     */
    
    public function form_span($text_section, $form_section){
    
        // Extract info from form section
        $primary_data = $this->unpack_layout($form_section, "primary_attributes", "primary_data",
                array("primary_class" => "class"));
        // Set default class for the primary <div> if nothing set
        if($primary_data["primary_class"] == ''){
            $primary_data["primary_class"] = "left_align";
        }
        
        // Extract info from text section
        $secondary_data = $this->unpack_layout($text_section, "secondary_attributes", "sedonary_data",
                array("secondary_class" => "class"));
        // Set default class for the primary <div> if nothing set
        if($secondary_data["secondary_class"] == ''){
            $secondary_data["secondary_class"] = "left_align";
        }     
        
    }    

}

?>
