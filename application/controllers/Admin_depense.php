<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_depense extends CI_Controller{
	
	    function __construct() {
        parent::__construct();
        global $URI, $CFG, $IN;
 
        $config =& $CFG->config;
        $URI->uri_string = preg_replace("|^\/?|", '/', $URI->uri_string);
        // echo "<script type=\"text/javascript\">
        //     alert('la langue est :".$URI->uri_string."');
        // </script>";

        $this->load->model('crud_model_livraison');
        $this->load->model('crud_model_depense');
         $this->load->model('crud_model_article');
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
	
	 public function selectAllInventaireGazoil(){
        $this->crud_model_depense->selectAllInventaireGazoil();
    }
	
	 public function selectAllInventaireHuile(){
        $this->crud_model_depense->selectAllInventaireHuile();
    }
	
	 public function selectAllInventairePneu(){
        $this->crud_model_depense->selectAllInventairePneu();
    }

    public function addGazoil(){
        $this->crud_model_depense->addGazoil();
    }
	
	 public function addMarque(){
        $this->crud_model_depense->addMarque();
    }
	
	 public function addTypepneu(){
        $this->crud_model_depense->addTypePneu();
    }
	
	 public function addInventaireGazoil(){
        $this->crud_model_depense->addInventaireGazoil();
    }
	
	 public function addInventairePneu(){
        $this->crud_model_depense->addInventairePneu();
    }
	
	 public function addInventaireHuile(){
        $this->crud_model_depense->addInventaireHuile();
    }
	
	public function getDateDernierInventaireGazoil(){
       echo $this->crud_model_depense->getDateDernierInventaireGazoil();
    }
	
	public function getDateDernierInventaireHuile(){
       echo $this->crud_model_depense->getDateDernierInventaireHuile();
    }
	
	public function getDateDernierInventairePneu(){
       echo $this->crud_model_depense->getDateDernierInventairePneu();
    }
	
	public function getLeselectArticlePourInventaireGazoil(){
        $this->crud_model_depense->leSelectArticlePourInventaireGazoil();
    }
	
	public function getLeselectArticlePourInventairePneu(){
        $this->crud_model_depense->leSelectArticlePourInventairePneu();
    }
	
	public function getLeselectArticlePourInventaireHuile(){
        $this->crud_model_depense->leSelectArticlePourInventaireHuile();
    }
	
	public function deleteInventaireGazoil(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_depense->deleteInventaireGazoil($table, $identifiant, $nom_id);
    }
	
	public function deleteMarque(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_depense->deleteMarque($table, $identifiant, $nom_id);
    }
	
	public function deleteTypePneu(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_depense->deleteTypePneu($table, $identifiant, $nom_id);
    }
	
		public function deleteInventaireHuile(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_depense->deleteInventaireHuile($table, $identifiant, $nom_id);
    }
	
		public function deleteInventairePneu(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_depense->deleteInventairePneu($table, $identifiant, $nom_id);
    }
	
	 public function deleteApprovisionnementGazoil(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_depense->deleteApprovisionnementGazoil($table, $identifiant, $nom_id);
    }
	
	public function deleteApprovisionnementHuile(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_depense->deleteApprovisionnementHuile($table, $identifiant, $nom_id);
    }
	
	public function deleteApprovisionnementPneu(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_depense->deleteApprovisionnementPneu($table, $identifiant, $nom_id);
    }
	
	
	
	 public function selectAllApprovisionnementGazoil(){
        $this->crud_model_depense->selectAllApprovisionnementGazoil();
    }
	
	 public function selectAllApprovisionnementHuile(){
        $this->crud_model_depense->selectAllApprovisionnementHuile();
    }
	
	 public function selectAllApprovisionnementPneu(){
        $this->crud_model_depense->selectAllApprovisionnementPneu();
    }
	
	 public function selectAllStockGazoil(){
        $this->crud_model_depense->selectAllStockGazoil();
    }
	
	 public function selectAllStockHuile(){
        $this->crud_model_depense->selectAllStockHuile();
    }
	
	 public function getLeselectArticlePourApprovisionnementGazoil(){
        $this->crud_model_depense->leSelectArticlePourApprovisionnementGazoil();
    }
	
	 public function getLeselectArticlePourApprovisionnementHuile(){
        $this->crud_model_depense->leSelectArticlePourApprovisionnementHuile();
    }
	
	 public function getLeselectArticlePourApprovisionnementPneu(){
        $this->crud_model_depense->leSelectArticlePourApprovisionnementPneu();
    }
	
	 public function addApprovisionnementGazoil(){
        $this->crud_model_depense->addApprovisionnementGazoil();
    }
	
	 public function addApprovisionnementHuile(){
        $this->crud_model_depense->addApprovisionnementHuile();
    }
	
	 public function addApprovisionnementPneu(){
        $this->crud_model_depense->addApprovisionnementPneu();
    }
	
    public function getAllGazoil(){
        $this->crud_model_depense->selectAllGazoil();
    }
	
	  public function getAllMarque(){
        $this->crud_model_depense->selectAllMarque();
    }
	
	  public function getAllTypePneu(){
        $this->crud_model_depense->selectAllTypePneu();
    }

    public function addPrime(){
        $this->crud_model_depense->addPrime();
    }

    public function getAllPrime(){
        $this->crud_model_depense->selectAllPrime();
    }
    public function addFraisRoute(){
        $this->crud_model_depense->addFraisRoute();
    }

    public function getAllFraisRoute(){
        $this->crud_model_depense->selectAllFraisRoute();
    }
    public function addFraisDivers(){
        $this->crud_model_depense->addFraisDivers();
    }
	
	public function addFraisAchat(){
        $this->crud_model_depense->addFraisAchat();
    }
	
	public function getTotal(){
        $this->crud_model_depense->getTotal();
    }
	
	

    public function getAllFraisDivers(){
        $this->crud_model_depense->selectAllFraisDivers();
    }
	
	 public function getAllFraisAchat(){
        $this->crud_model_depense->selectAllFraisAchats();
    }
	
    public function addVidange(){
        $this->crud_model_depense->addVidange();
    }

    public function getAllVidange(){
        $this->crud_model_depense->selectAllVidange();
    }
    public function addPieceRechange(){
        $this->crud_model_depense->addPieceRechange();
    }

    public function getAllPieceRechange(){
        $this->crud_model_depense->selectAllPieceRechange();
    }
    public function addVidangeHydrolique(){
        $this->crud_model_depense->addVidangeHydrolique();
    }
	
	 public function addVidangeGraisse(){
        $this->crud_model_depense->addVidangeGraisse();
    }

    public function getAllVidangeHydrolique(){
        $this->crud_model_depense->selectAllVidangeHydrolique();
    }
	
	public function getAllVidangeGraisse(){
        $this->crud_model_depense->selectAllVidangeGraisse();
    }
	
    public function addVidangeBoite(){
        $this->crud_model_depense->addVidangeBoite();
    }

    public function getAllVidangeBoite(){
        $this->crud_model_depense->selectAllVidangeBoite();
    }
    public function addTypeHuile(){
        $this->crud_model_depense->addTypeHuile();
    }
    public function getAllTypeHuile(){
        $this->crud_model_depense->selectAllTypeHuile();
    }
     public function getPrixUnitaireArticle(){
        $this->crud_model_depense->getPrixUnitaireArticle();
    
    }
	
	public function getPrixUnitaireArticle1(){
        $this->crud_model_depense->getPrixUnitaireArticle();
    
    }
	
	public function getFournisseurArticle1(){
        $this->crud_model_depense->getFournisseurArticle1();
    
    }
	
	public function getFournisseurArticle1_1(){
        $this->crud_model_depense->getFournisseurArticle1_1();
    
    }
	
	public function getReferenceArticle1(){
        $this->crud_model_depense->getReferenceArticle1();
    
    }
	
	public function getStockArticle(){
        $this->crud_model_depense->getStockArticle();
    
    }
	
		public function getStockHuile(){
        $this->crud_model_depense->getStockHuile();
    
    }
	
		public function getStockHuileB(){
        $this->crud_model_depense->getStockHuileB();
    
    }
	
		public function getStockHuileH(){
        $this->crud_model_depense->getStockHuileH();
    
    }
	
	public function getStockGraisseV(){
        $this->crud_model_depense->getStockGraisseV();
    
    }
	
	public function getMatriculeVehicule1(){
        $this->crud_model_depense->getMatriculeVehicule1();
    
    }
	
	public function getMatriculeVehicule1_1(){
        $this->crud_model_depense->getMatriculeVehicule1_1();
    
    }
	
	public function getMatriculeVehicule3(){
        $this->crud_model_depense->getMatriculeVehicule3();
    
    }
	
	public function getTypeVehicule3(){
        $this->crud_model_depense->getTypeVehicule3();
    
    }
	
	public function getTypeVehicule3_1(){
        $this->crud_model_depense->getTypeVehicule3_1();
    
    }
	
	public function getNomTypeVehicule3_1(){
		
        $this->crud_model_depense->getNomTypeVehicule3_1();
    
    }
	
	
		public function getDistanceParCodeCamion1(){
        $this->crud_model_depense->getDistanceParCodeCamion1();
    
    }
	
		public function getLitrageCamion1(){
        $this->crud_model_depense->getLitrageCamion1();
    
    }
	
		public function getLitrageCamion2(){
        $this->crud_model_depense->getLitrageCamion2();
    
    }
	
			public function getBLDatabase(){
        $this->crud_model_depense->getBLDatabase();
    
    }
	
	public function getBLTDatabase(){
        $this->crud_model_depense->getBLTDatabase();
    
    }
	
		public function getFraisRoute1(){
        $this->crud_model_depense->getFraisRoute1();
    
    }
	
		public function getFraisRetour1(){
        $this->crud_model_depense->getFraisRetour1();
    
    }
	
		public function addDemande(){
        $this->crud_model_depense->addDemande();
    
    }
	
	public function addDemandeN(){
        $this->crud_model_depense->addDemandeN();
    
    }
	
	public function addDemandeE(){
        $this->crud_model_depense->addDemandeE();
    
    }
	
	public function addDemandeNA(){
        $this->crud_model_depense->addDemandeNA();
    
    }
	
	public function addDemandeST(){
        $this->crud_model_depense->addDemandeST();
    
    }
	
	public function addDemandeG(){
        $this->crud_model_depense->addDemandeG();
    
    }
	
	public function getNouveauCode(){
       echo $this->crud_model_depense->genererChaineAleatoireDemande();
    }
	
	public function getNouveauCodeN(){
       echo $this->crud_model_depense->genererChaineAleatoireDemandeN();
    }
	
	 public function getAllDemmande(){
        $this->crud_model_depense->selectAllDemmande();
    }
	
	public function getDetailDemmandePourModification(){
        $this->crud_model_depense->getDetailDemmandePourModification();
    }
	 public function getListeDemmandePourModifC(){
        $this->crud_model_depense->getListeDemmandePourModifC();
    }
	
	 public function getListeDemmandePourModif(){
        $this->crud_model_depense->getListeDemmandePourModif();
    }
	
	public function getListeDemmandePourModifN(){
        $this->crud_model_depense->getListeDemmandePourModifN();
    }
	
	public function getListeDemmandePourModifE(){
        $this->crud_model_depense->getListeDemmandePourModifE();
    }
	
		public function getListeDemmandePourModifNA(){
        $this->crud_model_depense->getListeDemmandePourModifNA();
    }
	
			public function getListeDemmandePourModifST(){
        $this->crud_model_depense->getListeDemmandePourModifST();
    }
	
	
	 public function getListeDemmandePourModifG(){
        $this->crud_model_depense->getListeDemmandePourModifG();
    }
	
	public function getCamionDelegue(){
        $this->crud_model_depense->leSelectCodeCamion1();
    
    }
	
	public function getCamionDelegue1(){
        $this->crud_model_depense->leSelectCodeCamion1();
    
    }
	
	public function getDetailDemande(){
        $this->crud_model_depense->getDetailDemande();
    }
	
	public function getDetailDemandeN(){
        $this->crud_model_depense->getDetailDemandeN();
    }
	
	public function getDetailDemandeE(){
        $this->crud_model_depense->getDetailDemandeE();
    }
	
		public function getDetailDemandeNA(){
        $this->crud_model_depense->getDetailDemandeNA();
    }
	
	
	public function getDetailDemandeG(){
        $this->crud_model_depense->getDetailDemandeG();
    }
	
	public function getMatriculeVehicule2(){
        $this->crud_model_depense->getMatriculeVehicule2();
    
    }
	
	 public function getKilometrageGasoilParImmatriculation(){

    
       echo $this->crud_model_depense->getKilometrageGasoilParImmatriculation();
    }
	
	public function getTypeArticle1(){
        $this->crud_model_depense->getTypeArticle1();
    
    }
	
	public function getMarqueArticle1(){
        $this->crud_model_depense->getMarqueArticle1();
    
    }
	
	public function getTailleArticle1(){
        $this->crud_model_depense->getTailleArticle1();
    
    }
	
	  public function getNbreLigne(){
        $this->crud_model_depense->getNbreLigne();
    }
	
	public function getNbreLigne1(){
        $this->crud_model_depense->getNbreLigne1();
    }
	
	public function getNbreLigne1N(){
        $this->crud_model_depense->getNbreLigne1N();
    }
	
	public function getNbreLigne1NA(){
        $this->crud_model_depense->getNbreLigne1NA();
    }
	
	public function getNbreLigne1ST(){
        $this->crud_model_depense->getNbreLigne1ST();
    }
	
	public function getNbreLigne1E(){
        $this->crud_model_depense->getNbreLigne1E();
    }
	
	    public function getPrixUnitaireArticleGazoil(){
        $this->crud_model_depense->getPrixUnitaireArticle();
    
    }
	
	    public function getPrixUnitaireArticleHuile(){
        $this->crud_model_depense->getPrixUnitaireArticleHuile();
    
    }
	
    public function getDistanceParCodeCamion(){
        $this->crud_model_depense->getDistanceParCodeCamion();
    
    } 
    public function getLittrage(){
        $this->crud_model_depense->getLittrage();
    
    }

   public function getPrixUnitaireParFournisseur(){
        $this->crud_model_depense->getPrixUnitaireParFournisseur();
    
   } 

   public function getFournisseurMira(){
        $this->crud_model_article->getFournisseurMira();
     }

    public function getAllFournisseurMira(){
        $this->crud_model_article->leSelectFournisseurArticle();
    
   }
   
     public function getAllFournisseurGazoil(){
        $this->crud_model_article->leSelectFournisseurGazoil();
    
   }

   public function getPrixUnitaireHuile(){
        $this->crud_model_depense->getPrixUnitaireHuile();
    
   }
   
    public function getPrixUnitaireGraisse(){
        $this->crud_model_depense->getPrixUnitaireGraisse();
    
   }

   public function addDepensePneu(){
        $this->crud_model_depense->addDepensePneu();
    
   }
   
    public function addDepensePneu1(){
        $this->crud_model_depense->addDepensePneu1();
    
   }

   public function getAllDepensePneu(){
        $this->crud_model_depense->selectAllDepensePneu();
    
   }
   public function getTypeCamion(){
        $this->crud_model_depense->getTypeCamion();
    
   }

   public function getFournisseurPourModifGazoil(){
    $this->crud_model_depense->getFournisseurPourModifGazoil();
   }

   public function getOperationPourModifGazoil(){
    $this->crud_model_depense->getOperationPourModifGazoil();
   }
   public function getCodePourModifGazoil(){
    $this->crud_model_depense->getCodePourModifGazoil();
   }

   public function getDestinationPourModifGazoil(){
    $this->crud_model_depense->getDestinationPourModifGazoil();
   }

   public function getFournisseurPourModifPiece(){
    $this->crud_model_depense->getFournisseurPourModifPiece();
   }

   public function getArticlePourModifPiece(){
    $this->crud_model_depense->getArticlePourModifPiece();
   }
   public function getReferenceArticle(){
    $this->crud_model_depense->getReferenceArticle();
   }
   
   public function getReferenceArticleGazoil(){
    $this->crud_model_depense->getReferenceArticleGazoil();
   }
   
    public function getReferenceArticleHuile(){
    $this->crud_model_depense->getReferenceArticleHuile();
   }

   public function getKilometrageVehicule(){
        $code = $_POST['code_camion'];
    echo $this->crud_model_depense->getKilometrageVehicule($code);
   }

   public function addDepenseSalaireChauffeur(){
    $this->crud_model_depense->addDepenseSalaireChauffeur();
   }
   public function getAllDepenseSalaireChauffeur(){
    $this->crud_model_depense->selectAllDepenseSalaireChauffeur();
   }

   public function getAssistantChauffeur(){
    $this->crud_model_depense->getAssistantChauffeur();
   }

   public function getSalaireAssistant(){
    $this->crud_model_depense->getSalaireAssistant();
   }
   
   public function getAllDemande(){
        $this->crud_model_depense->selectAllDemmande();
    }
	
	public function getAllDemandeN(){
        $this->crud_model_depense->selectAllDemmandeN();
    }
	
    public function getAllDemandeE(){
        $this->crud_model_depense->selectAllDemmandeE();
    }
	
	
    public function getAllDemandeNA(){
        $this->crud_model_depense->selectAllDemmandeNA();
    }
	
	public function getAllDemandeST(){
        $this->crud_model_depense->selectAllDemmandeST();
    }
	
	 public function getAllDemandeG(){
        $this->crud_model_depense->selectAllDemmandeG();
    }

    public function addClient(){
        $this->crud_model_depense->addClient();
    }
    public function getAllClient(){
        $this->crud_model_depense->selectAllClient();
		
    }
	
	 public function getNbreNewNotificationParTemps(){
      echo  $this->crud_model_depense->getNbreNewNotificationParTemps();

    }
	
	 public function getUniqueNotificationParTemps(){
        $this->crud_model_depense->getUniqueNotificationParTemps();

    }
	
	 public function deleteClient(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_depense->deleteClient($table, $identifiant, $nom_id);
    }

   public function deletePieceRechange(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_depense->deletePieceRechange($table, $identifiant, $nom_id);
    }

  public function deletePrime(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_depense->deletePrime($table, $identifiant, $nom_id);
    }
    
   public function deleteFraisRoute(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_depense->deleteFraisRoute($table, $identifiant, $nom_id);
    }

   public function deleteFraisDivers(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_depense->deleteFraisDivers($table, $identifiant, $nom_id);
    }
	
	  public function deleteFraisAchat(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_depense->deleteFraisAchat($table, $identifiant, $nom_id);
    }
	
  public function deleteGasoil(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_depense->deleteGasoil($table, $identifiant, $nom_id);
    }
  public function deleteVidange(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_depense->deleteVidange($table, $identifiant, $nom_id);
    }
  public function deleteVidangeHydrolique(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_depense->deleteVidangeHydrolique($table, $identifiant, $nom_id);
    }
	
	public function deleteVidangeGraisse(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_depense->deleteVidangeGraisse($table, $identifiant, $nom_id);
    }
  public function deleteVidangeBoite(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_depense->deleteVidangeBoite($table, $identifiant, $nom_id);
    }
  public function deleteTypeHuile(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_depense->deleteTypeHuile($table, $identifiant, $nom_id);
    }
  public function deleteDepensePneu(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_depense->deleteDepensePneu($table, $identifiant, $nom_id);
    }
	
	public function deleteDemande(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_depense->deleteDemande($table, $identifiant, $nom_id);
    }
	
		public function deleteDemandeN(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_depense->deleteDemandeN($table, $identifiant, $nom_id);
    }
	
		public function deleteDemandeNA(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_depense->deleteDemandeNA($table, $identifiant, $nom_id);
    }
	
		public function deleteDemandeST(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_depense->deleteDemandeST($table, $identifiant, $nom_id);
    }
	
	
}