<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_client extends CI_Controller{
	
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

    public function addClient(){
        $this->crud_model_client->addClient();
    }
    public function getAllClient(){
        $this->crud_model_client->selectAllClient();
    }
    public function addReglement(){
        $this->crud_model_client->addReglement();
    }
    public function getAllReglement(){
        $this->crud_model_client->selectAllReglement();
    }
     public function soldeInitialClient(){
      echo  $this->crud_model_client->soldeInitialClient();
    }
    public function dateInitialClient(){
        $this->crud_model_client->dateInitialClient();
    }
    public function getAllFacturePourBalance(){
        $this->crud_model_client->selectAllFacturePourBalance();
    }
    public function getAllTotalFacturePourBalance(){
       echo $this->crud_model_client->selectAllTotalFacturePourBalance();
    }
    public function getAllReglementPourBalance(){
        $this->crud_model_client->selectAllReglementPourBalance();
    }
     public function getAllTotalReglementPourBalance(){
       echo $this->crud_model_client->selectAllTotalReglementPourBalanceClient();
    }
    public function soldeCaisseClient(){
        $this->crud_model_client->soldeCaisseClient();
    }

    public function deleteClient(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_client->deleteClient($table, $identifiant, $nom_id);
    }

    public function deleteReglementClient(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_client->deleteReglementClient($table, $identifiant, $nom_id);
    }
	
	public function getImmatriculation(){
        $this->crud_model_client->getImmatriculationCode();
    }
	


	public function verifiDateInitialClient1(){
   echo $this->crud_model_client->verifiDateInitialClient1();
}



	public function getDateInitialClient1(){
  echo  $this->crud_model_client->getDateInitialClient1();
}



	public function getSoldeInitialClient1(){
   echo $this->crud_model_client->getSoldeInitialClient1();
}


	
	public function getNomClient1(){
        $id_client = $_POST['id_client'];
      echo $this->crud_model_client->getClient1($id_client);
    }

  
	
	public function getAdresseClient1(){
        $id_client = $_POST['id_client'];
      echo $this->crud_model_client->getAdresseClient1($id_client);
    }


	
	 public function getVilleClient1(){
        $id_client = $_POST['id_client'];
      echo $this->crud_model_client->getVilleClient1($id_client);
    }

  
	
	  public function getTelephoneClient1(){
        $id_client = $_POST['id_client'];
      echo $this->crud_model_client->getTelephoneClient1($id_client);
    }
	

	
		public function soldeCaisseClient2_1(){
        $this->crud_model_client->soldeCaisseClient2_1();
    }
	


	public function getBalanceImprimableClient1(){

    $this->crud_model_client->getBalanceImprimableClient1();

}


	


public function repportNouveau1(){
if (isset($_POST['id_client'])) {
    # code...
   echo $this->crud_model_client->repportNouveau1($_POST['id_client']);
}else{
   echo $this->crud_model_client->repportNouveau1("");
}
}



public function repportNouveauDebit1(){
if (isset($_POST['id_client'])) {
    # code...
   echo $this->crud_model_client->repportNouveauDebit1($_POST['id_client']);
}else{
   echo $this->crud_model_client->repportNouveauDebit1("");
}
}

public function repportNouveauCredit1(){
if (isset($_POST['id_client'])) {
    # code...
   echo $this->crud_model_client->repportNouveauCredit1($_POST['id_client']);
}else{
   echo $this->crud_model_client->repportNouveauCredit1("");
}
}

public function getCreditPourBalanceImpCLient1(){
    echo $this->crud_model_client->getCreditPourBalanceImpCLient1();
}


public function getDebitPourBalanceImpCLient1(){
    echo $this->crud_model_client->getDebitPourBalanceImpCLient1();
}


	
public function getAllTotalAccuseRetraitPourBalance2_1(){
    echo $this->crud_model_client->selectAllTotalAccuseReglementPourBalanceClient1();
       // echo $this->crud_model_commercial->selectAllTotalAccuseRetraitPourBalance();
    }
	

	
	public function getAllTotalAccuseReglementPourBalance2_1(){
    echo $this->crud_model_client->totalFacturePourBalanceClient1();
       // echo $this->crud_model_commercial->selectAllTotalAccuseReglementPourBalanceClient();
    }



}