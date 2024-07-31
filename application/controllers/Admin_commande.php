<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_commande extends CI_Controller{
	
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
        $this->load->model('crud_model_client');
        $this->load->model('crud_model_article');
        $this->load->model('crud_model_depense');
        $this->load->model('crud_model_commande');
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

    public function getListeCamion(){
        $this->crud_model_commande->leSelectCodeCamion();
    }

    public function getNbreLigne(){
        $this->crud_model_commande->getNbreLigne();
    }
    public function addCommande(){
        $this->crud_model_commande->addCommande();
    }
    public function getAllCommande(){
        $this->crud_model_commande->selectAllCommande();
    }
    public function deleteCommande(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_commande->deleteCommande($table, $identifiant, $nom_id);
    }
    public function getDetailCommande(){
        $this->crud_model_commande->getDetailCommande();
    }
    public function getNouveauCode(){
       echo $this->crud_model_commande->genererChaineAleatoire();
    }
    public function getListeCommandePourModif(){
        $this->crud_model_commande->getListeCommandePourModif();
    }
    public function getReferenceArticle(){
        $this->crud_model_commande->getReferenceArticle();
    }
    // cimenterie

    public function addCommandeCimenterie(){
        $this->crud_model_commande->addCommandeCimenterie();
    }
    public function getAllCommandeCimenterie(){
        $this->crud_model_commande->selectAllCommandeCimenterie();
    }
    public function getDetailCommandeCimenterie(){
        $this->crud_model_commande->getDetailCommandeCimenterie();
    }
    public function getListeCommandeCimenteriePourModif(){
        $this->crud_model_commande->getListeCommandeCimenteriePourModif();
    }
}