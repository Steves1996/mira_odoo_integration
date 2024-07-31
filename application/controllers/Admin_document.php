<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_document extends CI_Controller{
	
	    function __construct() {
        parent::__construct();
        global $URI, $CFG, $IN;
 
        $config =& $CFG->config;
        $URI->uri_string = preg_replace("|^\/?|", '/', $URI->uri_string);
        // echo "<script type=\"text/javascript\">
        //     alert('la langue est :".$URI->uri_string."');
        // </script>";

        $this->load->model('crud_model_document');
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

    public function addDocument(){
        $type = $_POST["type"];
        $lieu = $_POST["lieu"];
        $numero = $_POST["numero"];
        $dateEffet = $_POST["dateEffet"];
        $etatRequete = $_POST["etatRequete"];
        if ($etatRequete == "insert") {
            # code...
            $this->crud_model_document->addDocument($type, $lieu, $numero, $dateEffet);
        }elseif ($etatRequete == "update") {
            # code...
            $table = $_POST["table"];
            $identifiant = $_POST["identifiant"];
            $id_table = $_POST["id_table"];
            $this->crud_model_document->updateDocument($table,$lieu,$numero,$dateEffet,$identifiant,$id_table);
        }else{

        }
        
    }

    public function deleteDocument(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_document->deleteDocument($table, $identifiant, $nom_id);
    }

    public function getAllCarteGrise(){
        $this->crud_model_document->selectAllCarteGrise();
    }
    public function getAllAssurance(){
        $this->crud_model_document->selectAllAssurance();
    }
    public function getAllCarteBleue(){
        $this->crud_model_document->selectAllCarteBleue();
    }
    public function getAllVisiteTechnique(){
        $this->crud_model_document->selectAllVisiteTechnique();
    }
    public function getAllTaxe(){
        $this->crud_model_document->selectAllTaxe();
    }
    public function getAllAccesPort(){
        $this->crud_model_document->selectAllAccesPort();
    }
    public function getAllLicence(){
        $this->crud_model_document->selectAllLicence();
    }
    public function getAllAttestation(){
        $this->crud_model_document->selectAllAttestation();
    }

    public function getExpirationCartegrise(){
        $this->crud_model_document->getExpirationCartegrise();
    }

}