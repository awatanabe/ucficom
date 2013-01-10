<?
/* Extends heleprs for generating a variety of HTML tags
 * 
 * Includes HTML elements that generally have opening and closing tags, with
 * content of some kind in the middle. The content for such tags is passed to 
 * the function as the first argument.
 * 
 * NAME_AS_ID is a control value. If TRUE, then input fields will set the ID
 * attribute to the name by default.
 * 
 * @author Aaron Watanabe
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

if ( !defined('NAME_AS_ID')) exit ('Must define bool NAME_AS_ID in constants.');

/**
 * Generates string for an HTML tag attribute in the form $attribute = "$value".
 * There IS a space following the attribute. IF $value IS NULL, will return the
 * empty string ''.
 * 
 * @param type $attribute   Name of the attribute
 * @param type $value       Value of the attribute. Will print even if $value
 * is empty.
 * @return string
 */

function tag_attribute($attribute, $value){
    
    if($value){
        return ' '.$attribute.' = "'.$value.'"';
    }
    else{
        return '';
    }
}


/**
 * Creates a template opening tag of <$tag $attributes id="$id" class="$class">
 * 
 * @param string    $tag         Name of HTML tag
 * @param string    $id          Element id
 * @param string    $class       Element class
 * @param array     $attributes  Custom attributes 
 * @return string
 */

function open_tag($tag, $id = NULL, $class = NULL, array $attributes = NULL){
    
    // Name of tag
    $html_str = "<$tag";
    
    // Add attributes if passed
    if($attributes){
        foreach($attributes as $attribute => $value){
            $html_str .= tag_attribute($attribute, $value);
        }
    }
    
    // Add id if passed
    $html_str .= tag_attribute("id", $id);
    
    // Add class if passed
    $html_str .= tag_attribute("class", $class);
    // Add close and return
    return $html_str.'>';   
}
/**
 * Generates a closing HTMl tag in the form </$tag>
 * 
 * @param string $tag Name of closing tag to generate
 * @return string
 */
function close_tag($tag){
    
   return "</$tag>";   
}

/**
 * generic_element
 * 
 * Returns an HTML element that encloses a particular content. Has the form
 * <$tag $attributes>$content</$tag>
 * 
 * @param string $tag       Name of the tag
 * @param string $content   Content to go between opening and closign tags.
 * @param string $id        DOM ID of tag
 * @param string $class     DOM class of tag.
 * @param array  $attributes    Element attributes like class, id, etc.
 * @param bool   $closing_tag   Inclusion of closing tag </$tag> and the 
 * preceding content. If FALSE, generic_element will return only the opening 
 * tag.
 * @return string
 */

function generic_element($tag, $content, $id, $class, $attributes, 
        $closing_tag = TRUE){
    
    // Generate opening tag and append content
    $html_str = open_tag($tag, $id, $class, $attributes);
    
    // Add closing tag, if desired
    if($closing_tag){
        $html_str .= $content.close_tag($tag);
    }
    
    return $html_str;
}

/**
 * label
 *
 * Generates an HTML label tag.
 * 
 * @param string $for       Mandatory. Id of element lable identifies
 * @param string $content   HTML content that is the label
 * @param string $id        Id of the tag
 * @param string $class     Class of the tag
 * return string
 */
function label($for, $content, $id = NULL, $class = NULL){
    return generic_element('label',$content, $id, $class, array('for' => $for));
}

/**
 * Generates an HTML a tag used to create hyperlinks.
 * 
 * @param string $link      Href value. URL of page to link to or name of 
 * anchor to link to preceded by a '#' mark.
 * @param string $content   Content that serves as link
 * @param string $id        Id of the tag
 * @param string $class     Class of the tag
 * return string
 */

function hyperlink($link, $content, $id = NULL, $class = NULL){
    return generic_element('a', $content, $id, $class, array('href'=>$link));
}

/**
 * anchor
 *
 * Generates an HTML anchor tag. To create a hyperlink to another page or to
 * a specific location on this page, use the hyperlink() function
 * 
 * @param string $name      Mandatory. Name of the anchor
 * @param string $content   Content that will be the anchor
 * @param string $id        Id of the tag
 * @param string $class     Class of the tag
 * return string
 */

function anchor($name, $content, $id = NULL, $class = NULL){
    return generic_element('a', $content, $id, $class, array('name'=>$name));
}

/**
 * HTML span tag used to mark selection of text
 *  
 * @param   type    Text to go wi
 * @param type $id
 * @param type $class
 * @return string 
 */

function span($content, $id = NULL, $class = NULL){
    return generic_element("span", $content, $id, $class, NULL);
}

/**
 * Italicizes text
 * 
 * @param   string    $content    Text to italicize
 * @return  string
 */

function italics($content){
    return generic_element("span", $content, NULL, NULL, 
            array("style"=>"font-style:italic"));
}

/**
 * Bolds text
 * 
 * @param   string  $content    Text to bold
 * @return  string
 */

function bold($content){
    return generic_element("span", $content, NULL, NULL, 
            array("style"=>"font-weight:bold"));
    
}

/**
 * Underlines text
 * 
 * @param   string  $content    Text to underline
 * @return  string
 */

function underline($content){
    return generic_element("span", $content, NULL, NULL, 
            array("style"=>"text-decoration:underline"));  
}
