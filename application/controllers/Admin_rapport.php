<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_rapport extends CI_Controller{
	
	    function __construct() {
        parent::__construct();
        global $URI, $CFG, $IN;
 
        $config =& $CFG->config;
        $URI->uri_string = preg_replace("|^\/?|", '/', $URI->uri_string);
        // echo "<script type=\"text/javascript\">
        //     alert('la langue est :".$URI->uri_string."');
        // </script>";
        $this->load->model('crud_model_chauffeur');
        $this->load->model('crud_model_rapport');
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

    public function selectAllFactureOperationPourRapport(){
        $this->crud_model_rapport->selectAllFactureOperationPourRapport();
    }

    public function selectAllPrimeOperationPourRapport(){
        $this->crud_model_rapport->selectAllPrimeOperationPourRapport();
    }
    public function selectAllFraisRouteOperationPourRapport(){
        $this->crud_model_rapport->selectAllFraisRouteOperationPourRapport();
    }

    public function selectAllFraisDiversOperationPourRapport(){
        $this->crud_model_rapport->selectAllFraisDiversOperationPourRapport();
    }
    public function selectAllPieceRechangeOperationPourRapport(){
        $this->crud_model_rapport->selectAllPieceRechangeOperationPourRapport();
    }
    
    public function selectAllAccidentOperationPourRapport(){
        $this->crud_model_rapport->selectAllAccidentOperationPourRapport();
    }

    public function selectAllVidangeOperationPourRapport(){
        $this->crud_model_rapport->selectAllVidangeOperationPourRapport();
    }
    public function selectAllTotalFactureOperationPourRapport(){
       echo number_format($this->crud_model_rapport->selectAllTotalFactureOperationPourRapport(),3,'.','');
    }
    public function selectAllTotalPrimeOperationPourRapport(){
       echo $this->crud_model_rapport->selectAllTotalPrimeOperationPourRapport();
    }
    public function selectAllTotalFraisRouteOperationPourRapport(){
      echo  $this->crud_model_rapport->selectAllTotalFraisRouteOperationPourRapport();
    }

    public function selectAllTotalFraisDiversOperationPourRapport(){
      echo  $this->crud_model_rapport->selectAllTotalFraisDiversOperationPourRapport();
    }

    public function selectAllTotalPieceRechangeOperationPourRapport(){
       echo $this->crud_model_rapport->selectAllTotalPieceRechangeOperationPourRapport();
    }
    
    public function selectAllTotalAccidentOperationPourRapport(){
       echo $this->crud_model_rapport->selectAllTotalAccidentOperationPourRapport();
    }
    
  
    public function selectAllTotalVidangeOperationPourRapport(){
       echo $this->crud_model_rapport->selectAllTotalVidangeOperationPourRapport();
    }

    public function selectAllTotalGazoilOperationPourRapport(){
       echo $this->crud_model_rapport->selectAllTotalGazoilOperationPourRapport();
    }

    public function selectAllGazoilOperationPourRapport(){
        $this->crud_model_rapport->selectAllGazoilOperationPourRapport();
    }

     public function selectAllLocationEnginOperationPourRapport(){
        $this->crud_model_rapport->selectAllLocationEnginOperationPourRapport();
    }

    // public function selectAllLocationVraquierOperationPourRapport(){
    //     $this->crud_model_rapport->selectAllLocationVraquierOperationPourRapport();
    // }


    public function selectAllLocationVraquierOperationPourRapport(){
        $this->crud_model_rapport->selectAllLocationVraquierOperationPourRapport();
    }

     public function selectAllDepensePneuOperationPourRapport(){
        $this->crud_model_rapport->selectAllDepensePneuOperationPourRapport();
    }

    public function selectAllTotalDepensePneuOperationPourRapport(){
       echo $this->crud_model_rapport->selectAllTotalDepensePneuOperationPourRapport();
    }

     public function selectAllTotalLocationEnginOperationPourRapport(){
       echo number_format($this->crud_model_rapport->selectAllTotalLocationEnginOperationPourRapport(),3,'.','');
    }

    // public function selectAllTotalLocationVraquierOperationPourRapport(){
    //    echo number_format($this->crud_model_rapport->selectAllTotalLocationVraquierOperationPourRapport(),3,'.','');
    // }

    public function selectAllTotalLocationVraquierOperationPourRapport(){
       echo number_format($this->crud_model_rapport->selectAllTotalLocationVraquierOperationPourRapport(),3,'.','');
    }

    public function selectAllChargementOperationPourRapport(){
        $this->crud_model_rapport->selectAllChargementOperationPourRapport();
    }
    public function selectAllTotalChargementOperationPourRapport(){
       echo $this->crud_model_rapport->selectAllTotalChargementOperationPourRapport();
    }

    public function selectAllVentePiecesOperationPourBalance(){
        $this->crud_model_rapport->selectAllVentePiecesOperationPourBalance();
    }

     public function selectAllTotalVentePiecesOperationPourBalance(){
       echo number_format($this->crud_model_rapport->selectAllTotalVentePiecesOperationPourBalance(),3,'.','');
    }

    public function totalDepenseParRapport(){
     $total = $this->crud_model_rapport->selectAllTotalPrimeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalFraisRouteOperationPourRapport()+$this->crud_model_rapport->selectAllTotalPieceRechangeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalAccidentOperationPourRapport()+$this->crud_model_rapport->selectAllTotalFraisDiversOperationPourRapport()+$this->crud_model_rapport->selectAllTotalVidangeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalGazoilOperationPourRapport()+$this->crud_model_rapport->selectAllTotalDepensePneuOperationPourRapport();
     echo $total;
    }


    public function selectTotalRecette(){
     $total = $this->crud_model_rapport->selectAllTotalFactureOperationPourRapport()+$this->crud_model_rapport->selectAllTotalLocationEnginOperationPourRapport()+$this->crud_model_rapport->selectAllTotalChargementOperationPourRapport();
     echo number_format($total,3,'.','')+$this->crud_model_rapport->selectAllTotalVentePiecesOperationPourBalance();
    }

    public function getSolde(){
        $total1 = $this->crud_model_rapport->selectAllTotalPrimeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalFraisRouteOperationPourRapport()+$this->crud_model_rapport->selectAllTotalPieceRechangeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalAccidentOperationPourRapport()+$this->crud_model_rapport->selectAllTotalFraisDiversOperationPourRapport()+$this->crud_model_rapport->selectAllTotalVidangeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalGazoilOperationPourRapport()+$this->crud_model_rapport->selectAllTotalDepensePneuOperationPourRapport();
     $total = $this->crud_model_rapport->selectAllTotalFactureOperationPourRapport()+$this->crud_model_rapport->selectAllTotalLocationEnginOperationPourRapport()+$this->crud_model_rapport->selectAllTotalChargementOperationPourRapport()-$total1;
     echo number_format($total,3,'.','');
    }

// rapport mensuel benne

    public function totalDepenseParRapportBenne(){
     $total = $this->crud_model_rapport->selectAllTotalPrimeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalFraisRouteOperationPourRapport()+$this->crud_model_rapport->selectAllTotalPieceRechangeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalAccidentOperationPourRapport()+$this->crud_model_rapport->selectAllTotalFraisDiversOperationPourRapport()+$this->crud_model_rapport->selectAllTotalVidangeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalGazoilOperationPourRapport()+$this->crud_model_rapport->selectAllTotalDepensePneuOperationPourRapport();
     echo $total;
    }


    public function selectTotalRecetteBenne(){
     $total = $this->crud_model_rapport->selectAllTotalFactureOperationPourRapport();
     echo number_format($total,3,'.','')+$this->crud_model_rapport->selectAllTotalVentePiecesOperationPourBalance();
    }

    public function getSoldeBenne(){
        $total1 = $this->crud_model_rapport->selectAllTotalPrimeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalFraisRouteOperationPourRapport()+$this->crud_model_rapport->selectAllTotalPieceRechangeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalAccidentOperationPourRapport()+$this->crud_model_rapport->selectAllTotalFraisDiversOperationPourRapport()+$this->crud_model_rapport->selectAllTotalVidangeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalGazoilOperationPourRapport()+$this->crud_model_rapport->selectAllTotalDepensePneuOperationPourRapport();
     $total = $this->crud_model_rapport->selectAllTotalFactureOperationPourRapport()+$this->crud_model_rapport->selectAllTotalVentePiecesOperationPourBalance()-$total1;
     echo number_format($total,3,'.','');
    }

    // rapport mensuel engin
 public function totalDepenseParRapportEngin(){
     $total = $this->crud_model_rapport->selectAllTotalPrimeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalPieceRechangeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalAccidentOperationPourRapport()+$this->crud_model_rapport->selectAllTotalFraisDiversOperationPourRapport()+$this->crud_model_rapport->selectAllTotalVidangeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalGazoilOperationPourRapport()+$this->crud_model_rapport->selectAllTotalDepensePneuOperationPourRapport();
     echo $total;
    }


    public function selectTotalRecetteEngin(){
     $total = $this->crud_model_rapport->selectAllTotalLocationEnginOperationPourRapport()+$this->crud_model_rapport->selectAllTotalVentePiecesOperationPourBalance();
     echo number_format($total,3,'.','');
    }

    public function getSoldeEngin(){
        $total1 = $this->crud_model_rapport->selectAllTotalPrimeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalPieceRechangeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalFraisDiversOperationPourRapport()+$this->crud_model_rapport->selectAllTotalAccidentOperationPourRapport()+$this->crud_model_rapport->selectAllTotalVidangeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalGazoilOperationPourRapport()+$this->crud_model_rapport->selectAllTotalDepensePneuOperationPourRapport();
     $total = $this->crud_model_rapport->selectAllTotalLocationEnginOperationPourRapport()+$this->crud_model_rapport->selectAllTotalVentePiecesOperationPourBalance()-$total1;
     echo number_format($total,3,'.','');
    }


// rapport mensuel engin

    public function totalDepenseParRapportService(){
     $total = $this->crud_model_rapport->selectAllTotalPrimeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalFraisRouteOperationPourRapport()+$this->crud_model_rapport->selectAllTotalPieceRechangeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalAccidentOperationPourRapport()+$this->crud_model_rapport->selectAllTotalFraisDiversOperationPourRapport()+$this->crud_model_rapport->selectAllTotalVidangeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalGazoilOperationPourRapport()+$this->crud_model_rapport->selectAllTotalDepensePneuOperationPourRapport();
     echo $total;
    }

    
// rapport mensuel vraquier

     public function totalDepenseParRapportVraquier(){
     $total = $this->crud_model_rapport->selectAllTotalPrimeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalPieceRechangeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalAccidentOperationPourRapport()+$this->crud_model_rapport->selectAllTotalFraisDiversOperationPourRapport()+$this->crud_model_rapport->selectAllTotalVidangeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalGazoilOperationPourRapport()+$this->crud_model_rapport->selectAllTotalDepensePneuOperationPourRapport();
     echo $total;
    }


    public function selectTotalRecetteVraquier(){
     $total = $this->crud_model_rapport->selectAllTotalLocationVraquierOperationPourRapport()+$this->crud_model_rapport->selectAllTotalVentePiecesOperationPourBalance();
     echo number_format($total,3,'.','');
    }

    public function getSoldeVraquier(){
        $total1 = $this->crud_model_rapport->selectAllTotalPrimeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalPieceRechangeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalAccidentOperationPourRapport()+$this->crud_model_rapport->selectAllTotalFraisDiversOperationPourRapport()+$this->crud_model_rapport->selectAllTotalVidangeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalGazoilOperationPourRapport()+$this->crud_model_rapport->selectAllTotalDepensePneuOperationPourRapport();
     $total = $this->crud_model_rapport->selectAllTotalLocationVraquierOperationPourRapport()+$this->crud_model_rapport->selectAllTotalVentePiecesOperationPourBalance()-$total1;
     echo number_format($total,3,'.','');
    }


    // public function selectTotalRecette(){
    //  $total = $this->crud_model_rapport->selectAllTotalFactureOperationPourRapport()+$this->crud_model_rapport->selectAllTotalLocationEnginOperationPourRapport()+$this->crud_model_rapport->selectAllTotalChargementOperationPourRapport();
    //  echo number_format($total,3,'.','');
    // }

    // public function getSolde(){
    //     $total1 = $this->crud_model_rapport->selectAllTotalPrimeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalFraisRouteOperationPourRapport()+$this->crud_model_rapport->selectAllTotalPieceRechangeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalFraisDiversOperationPourRapport()+$this->crud_model_rapport->selectAllTotalVidangeOperationPourRapport()+$this->crud_model_rapport->selectAllTotalGazoilOperationPourRapport()+$this->crud_model_rapport->selectAllTotalDepensePneuOperationPourRapport();
    //  $total = $this->crud_model_rapport->selectAllTotalFactureOperationPourRapport()+$this->crud_model_rapport->selectAllTotalLocationEnginOperationPourRapport()+$this->crud_model_rapport->selectAllTotalChargementOperationPourRapport()-$total1;
    //  echo number_format($total,3,'.','');
    // }

    public function rapportCumuleMensuel(){
        $this->crud_model_rapport->rapportCumuleMensuel();
    }

    public function rapportCumuleMensuelEN(){
        $this->crud_model_rapport->rapportCumuleMensuelEN();
    }

    public function rapportCumuleAN(){
        $this->crud_model_rapport->rapportCumuleAN();
    }

    public function rapportCumuleMensuelService(){
        $this->crud_model_rapport->rapportCumuleMensuelService();
    }

    public function rapportCumuleMensuelEngin(){
        $this->crud_model_rapport->rapportCumuleMensuelEngin();
    }

    public function rapportCumuleMensuelVraquier(){
        $this->crud_model_rapport->rapportCumuleMensuelVraquier();
    }

    public function rapportCumuleMensuelBenne(){
        $this->crud_model_rapport->rapportCumuleMensuelBenne();
    }
    public function rapportCumuleMensuelApprovisionnement(){
        $this->crud_model_rapport->rapportCumuleMensuelApprovisionnement();
    }
    
    public function rapportCumuleMensuelAccident(){
        $this->crud_model_rapport->rapportCumuleMensuelAccident();
    }

    public function rapportCumuleMensuelAccident2(){
        $this->crud_model_rapport->rapportCumuleMensuelAccident2();
    }

    public function EnteteRapportAccident(){
        $this->crud_model_rapport->EnteteRapportAccident();
    }

    public function rapportGeneral(){
        $this->crud_model_rapport->rapportGeneral();
    }
   
}