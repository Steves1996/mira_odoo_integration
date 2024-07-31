<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_operation extends CI_Controller{
	
	    function __construct() {
        parent::__construct();
        global $URI, $CFG, $IN;
 
        $config =& $CFG->config;
        $URI->uri_string = preg_replace("|^\/?|", '/', $URI->uri_string);
        // echo "<script type=\"text/javascript\">
        //     alert('la langue est :".$URI->uri_string."');
        // </script>";

        $this->load->model('crud_model_document');
        $this->load->model('crud_model_operation');
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

    public function addOperation(){
        $this->crud_model_operation->addOperation();
    }

    public function getAllOperation(){
        $this->crud_model_operation->selectAllOperation();
    }

    public function selectAllFactureOperationPourBalance(){
        $this->crud_model_operation->selectAllFactureOperationPourBalance();
    }

    public function selectAllPrimeOperationPourBalance(){
        $this->crud_model_operation->selectAllPrimeOperationPourBalance();
    }
    public function selectAllFraisRouteOperationPourBalance(){
        $this->crud_model_operation->selectAllFraisRouteOperationPourBalance();
    }

    public function selectAllFraisDiversOperationPourBalance(){
        $this->crud_model_operation->selectAllFraisDiversOperationPourBalance();
    }
    public function selectAllPieceRechangeOperationPourBalance(){
        $this->crud_model_operation->selectAllPieceRechangeOperationPourBalance();
    }

    public function selectAllVidangeOperationPourBalance(){
        $this->crud_model_operation->selectAllVidangeOperationPourBalance();
    }
    public function selectAllTotalFactureOperationPourBalance(){
       echo number_format($this->crud_model_operation->selectAllTotalFactureOperationPourBalance(),3,'.','');
    }
    public function selectAllTotalPrimeOperationPourBalance(){
       echo $this->crud_model_operation->selectAllTotalPrimeOperationPourBalance();
    }
    public function selectAllTotalFraisRouteOperationPourBalance(){
       echo $this->crud_model_operation->selectAllTotalFraisRouteOperationPourBalance();
    }

    public function selectAllTotalFraisDiversOperationPourBalance(){
       echo $this->crud_model_operation->selectAllTotalFraisDiversOperationPourBalance();
    }

    public function selectAllTotalPieceRechangeOperationPourBalance(){
       echo $this->crud_model_operation->selectAllTotalPieceRechangeOperationPourBalance();
    }
    public function selectAllTotalVidangeOperationPourBalance(){
       echo $this->crud_model_operation->selectAllTotalVidangeOperationPourBalance();
    }

    public function selectAllTotalGazoilOperationPourBalance(){
       echo $this->crud_model_operation->selectAllTotalGazoilOperationPourBalance();
    }

    public function selectAllGazoilOperationPourBalance(){
        $this->crud_model_operation->selectAllGazoilOperationPourBalance();
    }

     public function selectAllLocationEnginOperationPourBalance(){
        $this->crud_model_operation->selectAllLocationEnginOperationPourBalance();
    }

     public function selectAllTotalLocationEnginOperationPourBalance(){
       echo number_format($this->crud_model_operation->selectAllTotalLocationEnginOperationPourBalance(),3,'.','');
    }

    public function selectAllVentePiecesOperationPourBalance(){
        $this->crud_model_operation->selectAllVentePiecesOperationPourBalance();
    }

     public function selectAllTotalVentePiecesOperationPourBalance(){
       echo number_format($this->crud_model_operation->selectAllTotalVentePiecesOperationPourBalance(),3,'.','');
    }
    public function getAllChargement(){
        $this->crud_model_operation->selectAllChargement();
    }
    public function addChargement(){
        $this->crud_model_operation->addChargement();
    }
    public function totalDepenseParOperation(){
      echo  $this->crud_model_operation->totalDepenseParOperation();
    }
    public function getSolde(){
        echo  number_format($this->crud_model_operation->selectAllTotalFactureOperationPourBalance()+$this->crud_model_operation->selectAllTotalChargementOperationPourBalance()+$this->crud_model_operation->selectAllTotalLocationEnginOperationPourBalance()+$this->crud_model_operation->selectAllTotalVentePiecesOperationPourBalance()-$this->crud_model_operation->totalDepenseParOperation(),3,'.','');
      // echo  number_format($this->crud_model_operation->getSolde(),3,'.','');
    }
    public function selectAllChargementOperationPourBalance(){
        $this->crud_model_operation->selectAllChargementOperationPourBalance();
    }

    public function selectAllTotalChargementOperationPourBalance(){
       echo $this->crud_model_operation->selectAllTotalChargementOperationPourBalance();
    }

    public function selectTotalRecette(){
       echo number_format($this->crud_model_operation->selectAllTotalFactureOperationPourBalance()+$this->crud_model_operation->selectAllTotalChargementOperationPourBalance()+$this->crud_model_operation->selectAllTotalLocationEnginOperationPourBalance()+$this->crud_model_operation->selectAllTotalVentePiecesOperationPourBalance(),3,'.','');
    }
    public function getProduitOperation(){
        $this->crud_model_operation->getProduitOperation();
    }
    public function getClientOperation(){
        $this->crud_model_operation->getClientOperation();
    }
    public function getDateCreationOperation(){
        $this->crud_model_operation->getDateCreationOperation();
    }
    public function getFactureOperationParLocationEngin(){
        $this->crud_model_operation->getFactureOperationParLocationEngin();
    }

    public function getFactureOperationParChargementRetour(){
        $this->crud_model_operation->getFactureOperationParChargementRetour();
    }

    public function netPayer(){
        $this->crud_model_operation->netPayer();
    }

    public function deleteOperation(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_operation->deleteOperation($table, $identifiant, $nom_id);
    }

    public function deleteChargementRetour(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_operation->deleteChargementRetour($table, $identifiant, $nom_id);
    }
}