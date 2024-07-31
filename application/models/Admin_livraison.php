<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_livraison extends CI_Controller{
	
	    function __construct() {
        parent::__construct();
        global $URI, $CFG, $IN;
 
        $config =& $CFG->config;
        $URI->uri_string = preg_replace("|^\/?|", '/', $URI->uri_string);
        // echo "<script type=\"text/javascript\">
        //     alert('la langue est :".$URI->uri_string."');
        // </script>";

        $this->load->model('crud_model_livraison');
        $this->load->model('crud_model_livraison');
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


    public function addLivraison(){
        $this->crud_model_livraison->addLivraison();
    }
    public function getAllLivraison(){
        $this->crud_model_livraison->selectAllLivraison();
    }
    public function updateChauffeur(){
        $this->crud_model_chauffeur->updateChauffeur();

    }

    public function getDescriptionOperation(){
        $this->crud_model_livraison->getDescriptionOperation();
    }
    public function getClientOperation(){
        $this->crud_model_livraison->getClientOperation();
    }
    public function getDestinationOperation(){
        $this->crud_model_livraison->getDestinationOperation();
    }
    public function getDestinationParCodeCamion(){
        $this->crud_model_livraison->getDestinationParCodeCamion();
    }
    public function getAmortissementDestination(){
        $this->crud_model_livraison->getAmortissementDestination();
    }
    public function getAllVentePiece(){
        $this->crud_model_livraison->selectAllVentePieces();
    }
    public function addVentePieces(){
        $this->crud_model_livraison->addVentePieces();

    }
}