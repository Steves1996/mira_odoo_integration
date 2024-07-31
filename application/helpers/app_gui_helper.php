<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function getSelectOptions($table, $selected=null){
        
    $CI =& get_instance();
    $CI->load->database();
    
    //$current_language	=	$CI->db->get_where('settings' , array('type' => 'language'))->row()->description;

    if( isset($table["fields"]) ) $this->db->select($table["fields"]); 
    else $CI->db->select("*");

    $CI->db->from($table["name"]);

    if( isset($table["where"]) ) $CI->db->where($table["where"]);

    if( isset($table["order"]) ) $CI->db->order_by($table["order"]);

    if( isset($table["limit"]) ) $CI->db->limit($table["limit"]);
    else $CI->db->limit(SELECT__MAX_DISPLAY.",0");
    
    $optionsDatas = $CI->db->get()->result_array();
    $n = count($optionsDatas);

    $options = "";
    
    for($i=0; $i<$n; $i++) {

        $options .= ( $selected != null && $optionsDatas[$i][$table["valuefield"]] == $selected ) 
                                ? "<option value='".$optionsDatas[$i][$table["valuefield"]]."'  selected >".$optionsDatas[$i][$table["textfield"]]."</option>" 
                                : "<option value='".$optionsDatas[$i][$table["valuefield"]]."'  >".$optionsDatas[$i][$table["textfield"]]."</option>";

    }

    return $options;

}