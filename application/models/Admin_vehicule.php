<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_vehicule extends CI_Controller{
	
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

    public function addCamionBenne(){
        $status = $_POST["status"];
        $this->crud_model_vehicule->addCamionBenne($status );
    }
    public function addRemorque(){
        $status = $_POST["status"];
        $this->crud_model_vehicule->addRemorque($status);
    }
    public function addTracteur(){
        $status = $_POST["status"];
        $this->crud_model_vehicule->addTracteur($status);
    }
    public function addEngin(){
        $status = $_POST["status"];
        $this->crud_model_vehicule->addEngin($status);
    }

    public function getAllCamionBenne(){
        $this->crud_model_vehicule->selectAllCamionBenne();
    }
    public function getAllRemorque(){
        $this->crud_model_vehicule->selectAllRemorque();
    }
    public function getAllTracteur(){
        $this->crud_model_vehicule->selectAllTracteur();
    }
    public function getAllEngin(){
        $this->crud_model_vehicule->selectAllEngin();
    }
    public function formAddCamion(){
        $this->load->view('backend/vehicule/formAddCamion');
    }
    public function formAddCamion2(){
        $this->load->view('backend/vehicule/formAddCamion2');
    }

    public function formAddEngin(){
        $this->load->view('backend/vehicule/formAddEngin');
    }
    public function formAddEngin2(){
        $this->load->view('backend/vehicule/formAddEngin2');
    }

    public function formAddRemorque(){
        $this->load->view('backend/vehicule/formAddRemorque');
    }
    public function formAddRemorque2(){
        $this->load->view('backend/vehicule/formAddRemorque2');
    }
    public function formAddTracteur(){
        $this->load->view('backend/vehicule/formAddTracteur');
    }
    public function formAddTracteur2(){
        $this->load->view('backend/vehicule/formAddTracteur2');
    }

    public function afficheFormModifRemorque(){
        $id_remorque = $_POST["id_remorque"];
        $this->crud_model_vehicule->afficheFormModifRemorque($id_remorque);
    }
    public function afficheFormModifRemorque2(){
        $id_remorque = $_POST["id_remorque"];
        $this->crud_model_vehicule->afficheFormModifRemorque2($id_remorque);
    }
    public function afficheFormModifTracteur(){
        $id_tracteur = $_POST["id_tracteur"];
        $this->crud_model_vehicule->afficheFormModifTracteur($id_tracteur);
    }
    public function afficheFormModifTracteur2(){
        $id_tracteur = $_POST["id_tracteur"];
        $this->crud_model_vehicule->afficheFormModifTracteur2($id_tracteur);
    }
    public function afficheFormModifCamionBenne(){
        $id_camion = $_POST["id_camion"];
        $this->crud_model_vehicule->afficheFormModifCamionBenne($id_camion);
    }
    public function afficheFormModifCamionBenne2(){
        $id_camion = $_POST["id_camion"];
        $this->crud_model_vehicule->afficheFormModifCamionBenne2($id_camion);
    }
    public function afficheFormModifEngin(){
        $id_camion = $_POST["id_camion"];
        $this->crud_model_vehicule->afficheFormModifEngin($id_camion);
    }
    public function afficheFormModifEngin2(){
        $id_camion = $_POST["id_camion"];
        $this->crud_model_vehicule->afficheFormModifEngin2($id_camion);
    }

    // le code qui qui suis est pour recette/depense


    public function selectAllFactureOperationPourBalance(){
        $this->crud_model_vehicule->selectAllFactureOperationPourBalance();
    }

    public function selectAllPrimeOperationPourBalance(){
        $this->crud_model_vehicule->selectAllPrimeOperationPourBalance();
    }
    public function selectAllFraisRouteOperationPourBalance(){
        $this->crud_model_vehicule->selectAllFraisRouteOperationPourBalance();
    }

    public function selectAllFraisDiversOperationPourBalance(){
        $this->crud_model_vehicule->selectAllFraisDiversOperationPourBalance();
    }
    public function selectAllPieceRechangeOperationPourBalance(){
        $this->crud_model_vehicule->selectAllPieceRechangeOperationPourBalance();
    }

    public function selectAllVidangeOperationPourBalance(){
        $this->crud_model_vehicule->selectAllVidangeOperationPourBalance();
    }
    public function selectAllTotalFactureOperationPourBalance(){
       echo $this->crud_model_vehicule->selectAllTotalFactureOperationPourBalance();
    }
    public function selectAllTotalPrimeOperationPourBalance(){
        $this->crud_model_vehicule->selectAllTotalPrimeOperationPourBalance();
    }
    public function selectAllTotalFraisRouteOperationPourBalance(){
        $this->crud_model_vehicule->selectAllTotalFraisRouteOperationPourBalance();
    }

    public function selectAllTotalFraisDiversOperationPourBalance(){
        $this->crud_model_vehicule->selectAllTotalFraisDiversOperationPourBalance();
    }

    public function selectAllTotalPieceRechangeOperationPourBalance(){
        $this->crud_model_vehicule->selectAllTotalPieceRechangeOperationPourBalance();
    }
    public function selectAllTotalVidangeOperationPourBalance(){
        $this->crud_model_vehicule->selectAllTotalVidangeOperationPourBalance();
    }

    public function selectAllTotalGazoilOperationPourBalance(){
        $this->crud_model_vehicule->selectAllTotalGazoilOperationPourBalance();
    }

    public function selectAllGazoilOperationPourBalance(){
        $this->crud_model_vehicule->selectAllGazoilOperationPourBalance();
    }

    public function getAllChargement(){
        $this->crud_model_vehicule->selectAllChargement();
    }
    public function addChargement(){
        $this->crud_model_vehicule->addChargement();
    }
    public function totalDepenseParOperation(){
      echo  $this->crud_model_vehicule->totalDepenseParOperation()+$this->crud_model_vehicule->selectAllTotalPneuPourBalance();
    }
    public function getSolde(){
      echo  $this->crud_model_vehicule->getSolde();
    }
    public function selectAllChargementOperationPourBalance(){
        $this->crud_model_vehicule->selectAllChargementOperationPourBalance();
    }

    public function selectAllPneuPourBalance(){
        $this->crud_model_vehicule->selectAllPneuPourBalance();
    }
    public function selectAllTotalPneuPourBalance(){
      echo  $this->crud_model_vehicule->selectAllTotalPneuPourBalance();
    }

    public function selectAllTotalChargementOperationPourBalance(){
       echo $this->crud_model_vehicule->selectAllTotalChargementOperationPourBalance();
    }

    public function selectTotalRecette(){
       echo $this->crud_model_vehicule->selectAllTotalFactureOperationPourBalance()+$this->crud_model_vehicule->selectAllTotalChargementOperationPourBalance()+$this->crud_model_vehicule->selectAllTotalLocationEnginOperationPourBalance();
    }

    public function getCamionEtRoues(){
        $this->crud_model_vehicule->getCamionEtRoues();
    }

    public function getAllDistance(){
        $this->crud_model_vehicule->selectAllDistance();
    }

    public function addDistance(){
        $this->crud_model_vehicule->addDistance();
    }

    public function getAllLocationEngin(){
        $this->crud_model_vehicule->selectAllLocationEngin();
    }

    public function addLocationEngin(){
        $this->crud_model_vehicule->addLocationEngin();
    }

    public function addTypeVehicule(){
        $this->crud_model_vehicule->addTypeVehicule();
    }

    public function getAllTypeVehicule(){
        $this->crud_model_vehicule->selectAllTypeVehicule();
    }

     public function selectAllLocationEnginOperationPourBalance(){
        $this->crud_model_vehicule->selectAllLocationEnginOperationPourBalance();
    }

     public function selectAllTotalLocationEnginOperationPourBalance(){
       echo $this->crud_model_vehicule->selectAllTotalLocationEnginOperationPourBalance();
    }
    // public function getLittrage(){
    //     $this->crud_model_vehicule->getLittrage();
    // }
    public function getAmortissementParCodeCamion(){
        $this->crud_model_vehicule->getAmortissementParCodeCamion();
    }

    public function cumulAmortissementParCamion(){
       echo $this->crud_model_vehicule->cumulAmortissementParCamion();
    }

    public function getSoldeAmortissement(){
        $this->crud_model_vehicule->getSoldeAmortissement();
    }
    public function getMontantInitialParCode(){
      echo  $this->crud_model_vehicule->getMontantInitialParCode();
    }
    public function getDateInitialParCode(){
      echo  $this->crud_model_vehicule->getDateInitialParCode();
    }
    public function getMontantVehiculeParCode(){
       echo $this->crud_model_vehicule->getMontantVehiculeParCode();
    }
    public function getImmatriculationParCode(){
       echo $this->crud_model_vehicule->getImmatriculationParCode();
    }

    public function getChauffeur(){
        $this->crud_model_vehicule->getChauffeur();
    }
    public function getImmatriculation(){
        $this->crud_model_vehicule->getImmatriculation();
    }

    public function addDistanceParcourue(){
        $this->crud_model_vehicule->addDistanceParcourue();
    }

    public function selectAllDistanceParcourue(){
        $this->crud_model_vehicule->selectAllDistanceParcourue();
    }
}