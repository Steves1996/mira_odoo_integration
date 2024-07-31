<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_matiere extends CI_Controller{
	
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
        $this->load->model('crud_model_matiere');
        $this->load->model('crud_model_matiere');
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


  public function getDescriptionOperation(){
        $this->crud_model_matiere->getDescriptionOperation();
    }
    public function getClientOperation(){
        $this->crud_model_matiere->getClientOperation();
    }
	public function getImmatriculation(){
        $this->crud_model_matiere->getImmatriculationCode();
    }
    public function getDestinationOperation(){
        $this->crud_model_matiere->getDestinationOperation();
    }
    public function getDestinationParCodeCamion(){
        $this->crud_model_matiere->getDestinationParCodeCamion();
    }
	
	 public function getAmortissementDestination(){
        $this->crud_model_matiere->getAmortissementDestination();
    }
	
	 public function getAllLivraison(){
        $this->crud_model_matiere->selectAllLivraison();
    }
	
	public function addLivraison(){
        $this->crud_model_matiere->addLivraison();
    }
	
	  public function deleteBonLivraison(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_matiere->deleteBonLivraison($table, $identifiant, $nom_id);
    }
	
    public function addFournisseurMatiere(){
        $this->crud_model_matiere->addFournisseurMatiere();
    }

    public function getAllFournisseurMatiere(){
        $this->crud_model_matiere->selectAllFournisseurMatiere();
    }
    public function addFactureMatiere(){
        $this->crud_model_matiere->addFactureVente();
    }
    public function getAllFactureMatiere(){
        $this->crud_model_matiere->selectAllFactureVente();
    }
	
		  public function deleteFactureMatiere(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_matiere->deleteFactureMatiere($table, $identifiant, $nom_id);
    }
	
	
    public function addReglement(){
        $this->crud_model_matiere->addReglement();
    }
	
	 public function addReglement1(){
        $this->crud_model_matiere->addReglement1();
    }
    public function getAllReglement(){
        $this->crud_model_matiere->selectAllReglement();
    }
	
	public function getAllReglement1(){
        $this->crud_model_matiere->selectAllReglement1();
    }
    public function getAllFacturePourBalanceMatiere(){
        $this->crud_model_matiere->selectAllFacturePourBalance();
    }
    public function getAllReglementPourBalanceMatiere(){
        $this->crud_model_matiere->selectAllReglementPourBalance();
    }

   public function selectAllTotalReglementPourBalanceFournisseur(){
       echo $this->crud_model_matiere->selectAllTotalReglementPourBalanceFournisseur();
    }

    public function soldeMatiereFournisseur(){
        $this->crud_model_matiere->soldeCaisseFournisseur();
    }

    public function selectAllTotalFacturePourBalanceFournisseur(){
       echo $this->crud_model_matiere->selectAllTotalFacturePourBalanceFournisseur();
    }
	
	public function verifiDateInitialClient(){
   echo $this->crud_model_matiere->verifiDateInitialClient();
}

	public function verifiDateInitialClient1(){
   echo $this->crud_model_matiere->verifiDateInitialClient1();
}

	public function getDateInitialClient(){
  echo  $this->crud_model_matiere->getDateInitialClient();
}

	public function getDateInitialClient1(){
  echo  $this->crud_model_matiere->getDateInitialClient1();
}

	public function getSoldeInitialClient(){
   echo $this->crud_model_matiere->getSoldeInitialClient();
}

	public function getSoldeInitialClient1(){
   echo $this->crud_model_matiere->getSoldeInitialClient1();
}

	public function getNomClient(){
        $id_client = $_POST['id_client'];
      echo $this->crud_model_matiere->getClient($id_client);
    }
	
	public function getNomClient1(){
        $id_client = $_POST['id_client'];
      echo $this->crud_model_matiere->getClient1($id_client);
    }

    public function getAdresseClient(){
        $id_client = $_POST['id_client'];
      echo $this->crud_model_matiere->getAdresseClient($id_client);
    }
	
	public function getAdresseClient1(){
        $id_client = $_POST['id_client'];
      echo $this->crud_model_matiere->getAdresseClient1($id_client);
    }

    public function getVilleClient(){
        $id_client = $_POST['id_client'];
      echo $this->crud_model_matiere->getVilleClient($id_client);
    }
	
	 public function getVilleClient1(){
        $id_client = $_POST['id_client'];
      echo $this->crud_model_matiere->getVilleClient1($id_client);
    }

    public function getTelephoneClient(){
        $id_client = $_POST['id_client'];
      echo $this->crud_model_matiere->getTelephoneClient($id_client);
    }
	
	  public function getTelephoneClient1(){
        $id_client = $_POST['id_client'];
      echo $this->crud_model_matiere->getTelephoneClient1($id_client);
    }
	
	 public function getFournisseur(){
        
      echo $this->crud_model_matiere->getFournisseur();
    }
	
	 public function getMontant(){
        
      echo $this->crud_model_matiere->getMontant();
    }
	
	 public function getMontantAchat(){
        
      echo $this->crud_model_matiere->getMontantAchat();
    }
	
	public function soldeCaisseClient2(){
        $this->crud_model_matiere->soldeCaisseClient2();
    }
	
		public function soldeCaisseClient2_1(){
        $this->crud_model_matiere->soldeCaisseClient2_1();
    }
	
	public function getBalanceImprimableClient(){

    $this->crud_model_matiere->getBalanceImprimableClient();

}

	public function getBalanceImprimableClient1(){

    $this->crud_model_matiere->getBalanceImprimableClient1();

}


	

public function repportNouveau(){
if (isset($_POST['id_client'])) {
    # code...
   echo $this->crud_model_matiere->repportNouveau($_POST['id_client']);
}else{
   echo $this->crud_model_matiere->repportNouveau("");
}
}

public function repportNouveau1(){
if (isset($_POST['id_client'])) {
    # code...
   echo $this->crud_model_matiere->repportNouveau1($_POST['id_client']);
}else{
   echo $this->crud_model_matiere->repportNouveau1("");
}
}

public function repportNouveauDebit(){
if (isset($_POST['id_client'])) {
    # code...
   echo $this->crud_model_matiere->repportNouveauDebit($_POST['id_client']);
}else{
   echo $this->crud_model_matiere->repportNouveauDebit("");
}
}

public function repportNouveauDebit1(){
if (isset($_POST['id_client'])) {
    # code...
   echo $this->crud_model_matiere->repportNouveauDebit1($_POST['id_client']);
}else{
   echo $this->crud_model_matiere->repportNouveauDebit1("");
}
}

public function repportNouveauCredit(){
if (isset($_POST['id_client'])) {
    # code...
   echo $this->crud_model_matiere->repportNouveauCredit($_POST['id_client']);
}else{
   echo $this->crud_model_matiere->repportNouveauCredit("");
}
}

public function repportNouveauCredit1(){
if (isset($_POST['id_client'])) {
    # code...
   echo $this->crud_model_matiere->repportNouveauCredit1($_POST['id_client']);
}else{
   echo $this->crud_model_matiere->repportNouveauCredit1("");
}
}

public function getAllCreditPourBalance(){
        $this->crud_model_matiere->selectAllCreditPourBalance();
    }
public function getAllTotalCreditPourBalance(){
       echo $this->crud_model_matiere->selectAllTotalCreditPourBalanceClient();
    }

public function getCreditPourBalanceImpCLient(){
    echo $this->crud_model_matiere->getCreditPourBalanceImpCLient();
}

public function getCreditPourBalanceImpCLient1(){
    echo $this->crud_model_matiere->getCreditPourBalanceImpCLient1();
}

public function getDebitPourBalanceImpCLient(){
    echo $this->crud_model_matiere->getDebitPourBalanceImpCLient();
}
public function getDebitPourBalanceImpCLient1(){
    echo $this->crud_model_matiere->getDebitPourBalanceImpCLient1();
}

public function getAllTotalAccuseRetraitPourBalance2(){
    echo $this->crud_model_matiere->selectAllTotalAccuseReglementPourBalanceClient();
       // echo $this->crud_model_commercial->selectAllTotalAccuseRetraitPourBalance();
    }
	
public function getAllTotalAccuseRetraitPourBalance2_1(){
    echo $this->crud_model_matiere->selectAllTotalAccuseReglementPourBalanceClient1();
       // echo $this->crud_model_commercial->selectAllTotalAccuseRetraitPourBalance();
    }
	
public function getAllTotalAccuseReglementPourBalance2(){
    echo $this->crud_model_matiere->totalFacturePourBalanceClient();
       // echo $this->crud_model_commercial->selectAllTotalAccuseReglementPourBalanceClient();
    }
	
	public function getAllTotalAccuseReglementPourBalance2_1(){
    echo $this->crud_model_matiere->totalFacturePourBalanceClient1();
       // echo $this->crud_model_commercial->selectAllTotalAccuseReglementPourBalanceClient();
    }


    public function deleteFournisseurMatiere(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_matiere->deleteFournisseurMatiere($table, $identifiant, $nom_id);
    }

    public function deleteFactureFournisseurMatiere(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_matiere->deleteFactureFournisseurMatiere($table, $identifiant, $nom_id);
    }

     public function deleteReglementFournisseurMatiere(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_matiere->deleteReglementFournisseurMatiere($table, $identifiant, $nom_id);
    }
	
	  public function deleteReglementClientMatiere(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_matiere->deleteReglementClientMatiere($table, $identifiant, $nom_id);
    }
	
	 public function addClient(){
        $this->crud_model_matiere->addClient();
    }
    public function getAllClient(){
        $this->crud_model_matiere->selectAllClient();
    }
	   public function deleteClient(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_matiere->deleteClient($table, $identifiant, $nom_id);
    }
}