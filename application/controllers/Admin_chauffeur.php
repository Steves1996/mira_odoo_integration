<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_chauffeur extends CI_Controller{
	
	    function __construct() {
        parent::__construct();
        global $URI, $CFG, $IN;
 
        $config =& $CFG->config;
        $URI->uri_string = preg_replace("|^\/?|", '/', $URI->uri_string);
        // echo "<script type=\"text/javascript\">
        //     alert('la langue est :".$URI->uri_string."');
        // </script>";

        $this->load->model('crud_model_chauffeur');
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


    public function addChauffeur(){
        $this->crud_model_chauffeur->addChauffeur();
    }
    public function getAllChauffeur(){
        $this->crud_model_chauffeur->selectAllChauffeur();
    }
    public function updateChauffeur(){
        $this->crud_model_chauffeur->updateChauffeur();
    }
    public function getChauffeurParCodeCamion(){
        $this->crud_model_chauffeur->getChauffeurParCodeCamion();
    }
    
    public function addImputationChauffeur(){
        $this->crud_model_chauffeur->addImputationChauffeur();
    }
    public function getSalaireChauffeur(){
        $this->crud_model_chauffeur->getSalaireChauffeur();
    }
    public function getAllImputationSalaire(){
        $this->crud_model_chauffeur->getAllImputationSalaire();
    }

    public function addReglementImputation(){
        $this->crud_model_chauffeur->addReglementImputation();
    }
    public function getAllReglementImputation(){
        $this->crud_model_chauffeur->getAllReglementImputation();
    }

     public function getAllFacturePourBalanceArticle(){
        $this->crud_model_chauffeur->selectAllFacturePourBalance();
    }
    public function getAllReglementPourBalanceArticle(){
        $this->crud_model_chauffeur->selectAllReglementPourBalance();
    }

      public function selectAllTotalReglementPourBalanceFournisseur(){
       echo $this->crud_model_chauffeur->selectAllTotalReglementPourBalanceFournisseur();
    }

    public function soldeArticleFournisseur(){
        $this->crud_model_chauffeur->soldeCaisseFournisseur();
    }
     public function getDateInitialParChauffeur(){
      echo  $this->crud_model_chauffeur->getDateInitialParChauffeur();
    }
    public function getMontantInitialParChauffeur(){
       echo $this->crud_model_chauffeur->getMontantInitialParChauffeur();
    }

    public function selectAllTotalFacturePourBalanceFournisseur(){
       echo $this->crud_model_chauffeur->selectAllTotalFacturePourBalanceFournisseur();
    }

    public function getPaieChauffeur(){
        $this->crud_model_chauffeur->getPaiePersonnel();
    }
    
     public function getPaieChauffeurType(){
        $this->crud_model_chauffeur->getPaiePersonnelType();
    }

    public function getTotalPaieChauffeur(){
        $this->crud_model_chauffeur->getTotalPaiePersonnel();
    }
    
    public function getTotalPaieChauffeurType(){
        $this->crud_model_chauffeur->getTotalPaiePersonnelType();
    }

    public function getSommeIputation(){
        $this->crud_model_chauffeur->getSommeIputation();
    }
    public function getSalaireNetChauffeur(){
        $this->crud_model_chauffeur->getSalaireNetChauffeur();
    }

    public function getTotalSalaireNetChauffeurAssistant(){
        $this->crud_model_chauffeur->getTotalSalaireNetChauffeurAssistant();
    }


    public function addEtatSalaireChauffeur(){
        $this->crud_model_chauffeur->addEtatSalaireChauffeur();
    }
    public function afficheAllEtatChauffeur(){
        $this->crud_model_chauffeur->selectAllChauffeurPourPaie();
    }

    public function deleteChauffeur(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_chauffeur->deleteChauffeur($table, $identifiant, $nom_id);
    }

    public function deleteImputation(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_chauffeur->deleteImputation($table, $identifiant, $nom_id);
    }

    public function deleteReglementImputation(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_chauffeur->deleteReglementImputation($table, $identifiant, $nom_id);
    }
}