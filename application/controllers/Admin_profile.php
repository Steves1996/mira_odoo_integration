<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_profile extends CI_Controller{
	
	    function __construct() {
        parent::__construct();
        global $URI, $CFG, $IN;
 
        $config =& $CFG->config;
        $URI->uri_string = preg_replace("|^\/?|", '/', $URI->uri_string);
        // echo "<script type=\"text/javascript\">
        //     alert('la langue est :".$URI->uri_string."');
        // </script>";

        $this->load->model('crud_model_chauffeur');
        $this->load->model('crud_model_vehicule');
        $this->load->model('crud_model_document');
        $this->load->model('crud_model_profile');
        // $this->load->database('default');
        $this->load->library('session');
        $this->load->helper('app_gui_helper');
        $this->load->helper('cookie');
        $this->load->helper('url');
        // $this->session->set_userdata('language_abbr', "en"); 
        if ($this->session->userdata('language_abbr')!==null) {
            # code...
            // $this->lang->load('car',$this->session->userdata('language'));

        }else{
            // $this->lang->load('car','french');
            $this->session->set_userdata('language_abbr', $config['language_abbr']);

        }
        // $this->lang->load('teste','french');
         // $this->load->database('default');
        /* cache control */
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }

public function addUser(){
    $this->crud_model_profile->addUser();
}

public function addPrivilege(){

    $this->crud_model_profile->addPrivilege();
}

public function updatePrivilege(){

    $this->crud_model_profile->updatePrivilege();
}

public function getAllProfile(){

        $this->crud_model_profile->selectAllUsers();
}
public function formModifPrivilege(){

        $this->crud_model_profile->formModifPrivilege();
} 
public function modifProfile(){

    $this->crud_model_profile->modifProfile();
}
public function updateProfile(){

    $this->crud_model_profile->updateProfile();
}

public function getAllNotification(){
        $this->crud_model_profile->getAllNotification();
    }
}