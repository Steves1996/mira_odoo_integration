<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_gestion_gazoil extends CI_Controller{
	
	    function __construct() {
        parent::__construct();
        global $URI, $CFG, $IN;
 
        $config =& $CFG->config;
        $URI->uri_string = preg_replace("|^\/?|", '/', $URI->uri_string);
        // echo "<script type=\"text/javascript\">
        //     alert('la langue est :".$URI->uri_string."');
        // </script>";

        $this->load->model('crud_model_gestion_gazoil');
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

	public function getAllFactureGazoil(){
        $this->crud_model_gestion_gazoil->selectAllFacture();
    }
	
    public function addFactureGazoil(){
        $this->crud_model_gestion_gazoil->addFacture();
    }
    public function getAllFacture(){
        $this->crud_model_gestion_gazoil->selectAllFacture();
    }

    public function getMontantGazoil(){
        $this->crud_model_gestion_gazoil->selectMontFactureGazoil();
    }

    public function leSelectGazoilParFournisseur(){
        $this->crud_model_gestion_gazoil->leSelectGazoilParFournisseur();
    }
    
     public function addReglement(){
        $this->crud_model_gestion_gazoil->addReglement();
    }
    public function getAllReglement(){
        $this->crud_model_gestion_gazoil->selectAllReglement();
    }

    public function getAllFacturePourBalance(){
        $this->crud_model_gestion_gazoil->selectAllFacturePourBalance();
    }
    public function getAllReglementPourBalance(){
        $this->crud_model_gestion_gazoil->selectAllReglementPourBalance();
    }
   
    public function selectAllTotalReglementPourBalanceFournisseur(){
       echo $this->crud_model_gestion_gazoil->selectAllTotalReglementPourBalanceFournisseur();
    }

    public function soldeGazoilFournisseur(){
        $this->crud_model_gestion_gazoil->soldeCaisseFournisseur();
    }

    public function soldeInitialFournisseur(){
      echo  $this->crud_model_gestion_gazoil->soldeInitialFournisseur();
    }

    public function dateInitialFournisseur(){
        $this->crud_model_gestion_gazoil->dateInitialFournisseur();
    }
	
	  

    public function selectAllTotalFacturePourBalanceFournisseur(){
       echo $this->crud_model_gestion_gazoil->selectAllTotalFacturePourBalanceFournisseur();
    }

    // le code qui suit est celui de la balance facture

    public function getAllFacturePourBalanceFacture(){
        $this->crud_model_gestion_gazoil->selectAllFacturePourBalanceFacture();
    }
    
    public function selectAllTotalFacturePourBalanceFacture(){
       echo $this->crud_model_gestion_gazoil->selectAllTotalFacturePourBalanceFacture();
    }
    
    public function soldeGazoilFacture(){
        $this->crud_model_gestion_gazoil->soldeCaisseFacture();
    }

    public function deleteFactureFournisseurGasoil(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_gestion_gazoil->deleteFactureFournisseurGasoil($table, $identifiant, $nom_id);
    }

     public function deleteReglementFournisseurGasoil(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_gestion_gazoil->deleteReglementFournisseurGasoil($table, $identifiant, $nom_id);
    }
	
	public function verifiDateInitialClient(){
      echo $this->crud_model_gestion_gazoil->verifiDateInitialClient();
}

public function getDateInitialClient(){
  echo  $this->crud_model_gestion_gazoil->getDateInitialClient();
}

	public function getSoldeInitialClient(){
   echo $this->crud_model_gestion_gazoil->getSoldeInitialClient();
}

	public function getNomClient(){
        $id_client = $_POST['id_client'];
      echo $this->crud_model_gestion_gazoil->getClient($id_client);
    }

    public function getAdresseClient(){
        $id_client = $_POST['id_client'];
      echo $this->crud_model_gestion_gazoil->getAdresseClient($id_client);
    }

    public function getVilleClient(){
        $id_client = $_POST['id_client'];
      echo $this->crud_model_gestion_gazoil->getVilleClient($id_client);
    }

    public function getTelephoneClient(){
        $id_client = $_POST['id_client'];
      echo $this->crud_model_gestion_gazoil->getTelephoneClient($id_client);
    }
	
	public function soldeCaisseClient2(){
        $this->crud_model_gestion_gazoil->soldeCaisseClient2();
    }
	
	public function getBalanceImprimableClient(){

    $this->crud_model_gestion_gazoil->getBalanceImprimableClient();

}

public function repportNouveau(){
if (isset($_POST['id_client'])) {
    # code...
   echo $this->crud_model_gestion_gazoil->repportNouveau($_POST['id_client']);
}else{
   echo $this->crud_model_gestion_gazoil->repportNouveau("");
}
}

public function repportNouveauDebit(){
if (isset($_POST['id_client'])) {
    # code...
   echo $this->crud_model_gestion_gazoil->repportNouveauDebit($_POST['id_client']);
}else{
   echo $this->crud_model_gestion_gazoil->repportNouveauDebit("");
}
}

public function repportNouveauCredit(){
if (isset($_POST['id_client'])) {
    # code...
   echo $this->crud_model_gestion_gazoil->repportNouveauCredit($_POST['id_client']);
}else{
   echo $this->crud_model_gestion_gazoil->repportNouveauCredit("");
}
}

public function getAllCreditPourBalance(){
        $this->crud_model_gestion_gazoil->selectAllCreditPourBalance();
    }
public function getAllTotalCreditPourBalance(){
       echo $this->crud_model_gestion_gazoil->selectAllTotalCreditPourBalanceClient();
    }

public function getCreditPourBalanceImpCLient(){
    echo $this->crud_model_gestion_gazoil->getCreditPourBalanceImpCLient();
}

public function getDebitPourBalanceImpCLient(){
    echo $this->crud_model_gestion_gazoil->getDebitPourBalanceImpCLient();
}

public function getAllTotalAccuseRetraitPourBalance2(){
    echo $this->crud_model_gestion_gazoil->selectAllTotalAccuseReglementPourBalanceClient();
       // echo $this->crud_model_commercial->selectAllTotalAccuseRetraitPourBalance();
    }
	
public function getAllTotalAccuseReglementPourBalance2(){
    echo $this->crud_model_gestion_gazoil->totalFacturePourBalanceClient();
       // echo $this->crud_model_commercial->selectAllTotalAccuseReglementPourBalanceClient();
    }


    
}