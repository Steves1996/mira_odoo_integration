<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller{
	
	    function __construct() {
        parent::__construct();
        global $URI, $CFG, $IN;
 
        $config =& $CFG->config;
        $URI->uri_string = preg_replace("|^\/?|", '/', $URI->uri_string);
        // echo "<script type=\"text/javascript\">
        //     alert('la langue est :".$URI->uri_string."');
        // </script>";
        $this->load->model('crud_model_livraison');
        $this->load->model('crud_model_operation');
        $this->load->model('crud_model_document');
        $this->load->model('crud_model_chauffeur');
        $this->load->model('crud_model_vehicule');
        $this->load->model('crud_model_client');
        $this->load->model('crud_model_operation');
        $this->load->model('crud_model_fournisseur_gazoil');
        $this->load->model('crud_model');
        $this->load->model('crud_model_depense');
        $this->load->model('crud_model_commande');
        $this->load->model('crud_model_article');
        $this->load->model('crud_model_gestion_gazoil');
        $this->load->model('crud_model_stock');
        $this->load->model('crud_model_caisse');
        $this->load->model('crud_model_matiere');
        $this->load->model('crud_model_rapport');
        $this->load->model('crud_model_profile');
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
    
   
    public function addTypePneu(){
     $this->crud_model->addTypePneu();
    }

    public function addPneu(){
     $this->crud_model->addPneu();
    }
    public function deletePneu(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model->deletePneu($table, $identifiant, $nom_id);
    }

    public function deleteTypePneu(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model->deleteTypePneu($table, $identifiant, $nom_id);
    }
    public function getKilometrageGasoilParImmatriculation(){

    $immatriculation = $_POST['immatriculation'];
       echo $this->crud_model->getKilometrageGasoilParImmatriculation($immatriculation);
    }

    public function depensePneu(){
         $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Dépense Pneu';
        $data['page'] = 'Document';
        $this->load->view('backend/pneu/depensePneu',$data);
    }

    public function getAllPneu(){
     $this->crud_model->selectAllPneu();
    }

    public function getAllTypePneu(){
     $this->crud_model->selectAllTypePneu();
    }

    public function updateServicePneu(){
     $this->crud_model->miseEnServicePneu();
    }

    public function getImmatriculationParCode(){
     $this->crud_model->getImmatriculationParCode();
    }

    public function getTypeVehicule(){
     $this->crud_model->getTypeVehicule();
    }
    public function getDepensePneu(){
     $this->crud_model_depense->selectAllDepensePneu();
    }
    public function index()
    {

        // $data['nb_clinic'] = $this->crud_model->nbre_clinic();
        // $this->session->set_userdata('language', "french");
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Accueil';
        $this->load->view('backend/login', $data);
    }

    public function document(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Document';
        $data['page'] = 'Document';
        $this->load->view('backend/document/index',$data);
    }
    public function register(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Document';
        $data['page'] = 'Document';
        $this->load->view('backend/register',$data);
    }
    public function forgot_password(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Document';
        $data['page'] = 'Document';
        $this->load->view('backend/forgot_password',$data);
    }
    public function chauffeur(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Chauffeurs';
        $data['page'] = 'Document';
        $this->load->view('backend/chauffeur/index',$data);
    }
    public function imputationChauffeur(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Imputation Salaire Chauffeurs';
        $data['page'] = 'Document';
        $this->load->view('backend/chauffeur/imputation',$data);
    }

    public function reglementImputation(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Règlement imputation salaire';
        $data['page'] = 'Document';
        $this->load->view('backend/chauffeur/reglement',$data);
    }

    public function balanceChauffeur(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Balance Chauffeur';
        $data['page'] = 'Document';
        $this->load->view('backend/chauffeur/balance',$data);
    }
    public function remorque(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Remorques';
        $data['page'] = 'Document';
        $this->load->view('backend/vehicule/remorque',$data);
    }
    public function tracteur(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Tracteur';
        $data['page'] = 'Document';
        $this->load->view('backend/vehicule/tracteur',$data);
    }
    public function client(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Client';
        $data['page'] = 'Document';
        $this->load->view('backend/client/index',$data);
    }
	
	 public function clientMP(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Client';
        $data['page'] = 'Document';
        $this->load->view('backend/matiere_premiere/client',$data);
    }
	
	 public function clientFrais(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Client Cimenterie';
        $data['page'] = 'Document';
        $this->load->view('backend/depense/client',$data);
    }
	
	public function marchandiseFrais(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Marchandise';
        $data['page'] = 'Document';
        $this->load->view('backend/depense/marchandiseFrais',$data);
    }
	
    public function categorieArticle(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Catégorie d\'article';
        $data['page'] = 'Document';
        $this->load->view('backend/article/categorieArticle',$data);
    }
    public function login(){
      
        $this->crud_model->login();
    }
    public function deconnexion(){
        $this->session->sess_destroy();
        $this->session->set_flashdata('logout_notification', 'logged_out');
        redirect(base_url()."admin/", 'refresh');
    }

    public function administration(){
      
       $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Administration';
        $data['page'] = 'Document';
        $this->load->view('backend/index',$data);
    }
    public function camionBenne(){
      
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Camion benne';
        $data['page'] = 'Document';
        $this->load->view('backend/vehicule/camionBenne',$data);
    }
    public function distanceRecette(){
      
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Destination / littrage';
        $data['page'] = 'Document';
        $this->load->view('backend/vehicule/distance',$data);
    }
	
	  public function distanceRecetteUpdate(){
      
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Destination / littrage UPDATE';
        $data['page'] = 'Document';
        $this->load->view('backend/vehicule/distance1',$data);
    }
	
    public function operation(){
      
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Opération';
        $data['page'] = 'Document';
        $this->load->view('backend/operation/index',$data);
    }
    public function chargement_retour(){
      
        $data['page_name'] = 'chargement_retour';
        $data['page_title'] = 'chargement retour';
        $data['page'] = 'Document';
        $this->load->view('backend/operation/chargement_retour',$data);
    }
    public function balanceOperation(){
      
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Opération';
        $data['page'] = 'Document';
        $this->load->view('backend/operation/balance',$data);
    }
    public function bonLivraison(){
      $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Bon de livraison';
        $data['page'] = 'Document';
        $this->load->view('backend/livraison/bonLivraison',$data);
    }
	
	   public function infoChargement(){
      $data['page_name'] = 'Accueil';
        $data['page_title'] = 'INFOS CHARGEMENT CHAUFFEUR';
        $data['page'] = 'Document';
        $this->load->view('backend/livraison/infoChargement',$data);
    }
    public function location_engin(){
      $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Location engin';
        $data['page'] = 'Document';
        $this->load->view('backend/livraison/location_engin',$data);
    }

    public function location_vraquier(){
      $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Location vraquier';
        $data['page'] = 'Document';
        $this->load->view('backend/livraison/location_vraquier',$data);
    }
    public function vente_pieces(){
      $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Vente Diverses';
        $data['page'] = 'Document';
        $this->load->view('backend/livraison/vente_pieces',$data);
    }
     public function pneu(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'PNEUS';
        $data['page'] = 'Document';
        $this->load->view('backend/pneu/index',$data);
    }
    public function gazoil(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Gazoil';
        $data['page'] = 'Document';
        $this->load->view('backend/depense/gazoil',$data);
    }
	
	public function inventaireGazoil(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Inventaire Gazoil';
        $data['page'] = 'Document';
        $this->load->view('backend/depense/inventaireGazoil',$data);
    }
	
	public function inventairePneu(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Inventaire Pneu';
        $data['page'] = 'Document';
        $this->load->view('backend/pneu/inventairePneu',$data);
    }
	
	public function approvisionnementGazoil(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Approvisionnement Gazoil';
        $data['page'] = 'Document';
        $this->load->view('backend/depense/approvisionnementGazoil',$data);
    }
	
	public function approvisionnementPneu(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Approvisionnement Pneu';
        $data['page'] = 'Document';
        $this->load->view('backend/pneu/approvisionnementPneu',$data);
    }
	
	public function stockGazoil(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Stock Gazoil';
        $data['page'] = 'Document';
        $this->load->view('backend/depense/stockGazoil',$data);
    }
	
	public function inventaireHuile(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Inventaire Huile Vidange';
        $data['page'] = 'Document';
        $this->load->view('backend/depense/inventairehuile',$data);
    }
	
	public function approvisionnementHuile(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Approvisionnement Huile';
        $data['page'] = 'Document';
        $this->load->view('backend/depense/approvisionnementhuile',$data);
    }
	
	public function stockHuile(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Stock Huile';
        $data['page'] = 'Document';
        $this->load->view('backend/depense/stockHuile',$data);
    }
	
    public function fournisseur(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Fournisseur Gazoil';
        $data['page'] = 'Document';
        $this->load->view('backend/fournisseur/index',$data);
    }
    public function prime(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Primes / ration';
        $data['page'] = 'Document';
        $this->load->view('backend/depense/primes',$data);
    }
    public function fraisRoute(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Frais de route';
        $data['page'] = 'Document';
        $this->load->view('backend/depense/fraisRoute',$data);
    }
    public function fraisDivers(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Frais divers';
        $data['page'] = 'Document';
        $this->load->view('backend/depense/fraisDivers',$data);
    }
	  public function fraisAchat(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'FACTURE ACHAT';
        $data['page'] = 'Document';
        $this->load->view('backend/depense/fraisAchat',$data);
    }
	
	
	  public function fraisVente(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'FACTURE VENTE';
        $data['page'] = 'Document';
        $this->load->view('backend/matiere_premiere/bonLivraison1',$data);
    }
	
    public function article(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Articles';
        $data['page'] = 'Document';
        $this->load->view('backend/article/index',$data);
    }
	
	public function type_huile(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Type Huile';
        $data['page'] = 'Document';
        $this->load->view('backend/depense/type_huile',$data);
    }
    public function type_vehicule(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Type de véhicule';
        $data['page'] = 'Document';
        $this->load->view('backend/vehicule/type_vehicule',$data);
    }
    public function engin(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Engin';
        $data['page'] = 'Document';
        $this->load->view('backend/vehicule/engin',$data);
    }

    public function vraquier(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Vraquier';
        $data['page'] = 'Document';
        $this->load->view('backend/vehicule/vraquier',$data);
    }

    public function voitureService(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Véhicules de service';
        $data['page'] = 'Document';
        $this->load->view('backend/vehicule/voitureService',$data);
    }
    
    public function accident(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Accident';
        $data['page'] = 'Document';
        $this->load->view('backend/vehicule/accident',$data);
    }
    
    public function distance_parcourue(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Distance parcourue';
        $data['page'] = 'Document';
        $this->load->view('backend/vehicule/distance_parcourue',$data);
    }
	
	public function demande_frais(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Demande Frais Route';
        $data['page'] = 'Document';
        $this->load->view('backend/vehicule/demande_frais',$data);
    }
	
	public function demande_navette(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Demande Gazoil Navette Pouzzolane';
        $data['page'] = 'Document';
        $this->load->view('backend/vehicule/demande_navette',$data);
    }
	
	public function stock_vehicule(){
        $data['page_name'] = 'STOCK VEHICULE';
        $data['page_title'] = 'STOCK VEHICULE';
        $data['page'] = 'Document';
        $this->load->view('backend/vehicule/stock_vehicule',$data);
    }
	
		public function demande_navette_pouzz(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Demande Gazoil Navette Autre';
        $data['page'] = 'Document';
        $this->load->view('backend/vehicule/demande_navette_pouzz',$data);
    }
	
		public function demande_engin(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Demande Gazoil ENGIN';
        $data['page'] = 'Document';
        $this->load->view('backend/vehicule/demande_engin',$data);
    }
	
	public function controle_frais(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Controle frais Route';
        $data['page'] = 'Document';
        $this->load->view('backend/vehicule/controle_frais',$data);
    }
	
	public function demande_gazoil(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Demande Frais Gazoil';
        $data['page'] = 'Document';
        $this->load->view('backend/depense/demande_gazoil',$data);
    }
	
    public function reglementClient(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Règlement client';
        $data['page'] = 'Document';
        $this->load->view('backend/client/reglement',$data);
    }
	
	  public function reglementClientMP(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Règlement client';
        $data['page'] = 'Document';
        $this->load->view('backend/matiere_premiere/reglementClient',$data);
    }
	
    public function balanceClient(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Balance client';
        $data['page'] = 'Document';
        $this->load->view('backend/client/balance',$data);
    }
    public function vidange(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Vidange moteur';
        $data['page'] = 'Document';
        $this->load->view('backend/depense/vidange',$data);
    }
    public function pieceRechange(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Pièce de rechange';
        $data['page'] = 'Document';
        $this->load->view('backend/depense/pieceRechange',$data);
    }
    public function boiteVitesse(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Vidange Boite de vitesse';
        $data['page'] = 'Document';
        $this->load->view('backend/depense/boiteVitesse',$data);
    }
    public function hydrolique(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Vidange hydrolique';
        $data['page'] = 'Document';
        $this->load->view('backend/depense/hydrolique',$data);
    }
	
	  public function graisse(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Vidange Graisse';
        $data['page'] = 'Document';
        $this->load->view('backend/depense/graisse',$data);
    }
    public function factureGazoil(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Facture gazoil';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionGazoil/facture',$data);
    }
    public function reglementFactureGazoil(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Règlement de la facture';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionGazoil/reglement',$data);
    }
    public function balanceFactureGazoil(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Balance fournisseur gazoil';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionGazoil/balance',$data);
    }
    public function balanceFacture(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Balance facture gazoil';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionGazoil/balanceFacture',$data);
    }
    public function inventaire(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Inventaire';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionStock/inventaire',$data);
    }
    public function approvisionnement(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Approvisionnement';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionStock/approvisionnement',$data);
    }
    public function defectueux(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Defectueux';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionStock/defectueux',$data);
    }
	
	 public function defectueuxPneu(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Defectueux Pneu';
        $data['page'] = 'Document';
        $this->load->view('backend/pneu/defectueuxPneu',$data);
    }
	
    public function stock(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Stock';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionStock/stock',$data);
    }
	
	public function stockPneu(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Stock Pneu';
        $data['page'] = 'Document';
        $this->load->view('backend/pneu/stockPneu',$data);
    }
    
    
    public function stockvaleur(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Valeur Stock';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionStock/stockvaleur',$data);
    }
	
	
	  public function demande_bon(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Demande Bon Caisse';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionCaisse/demande_bon',$data);
    }
	
		  public function demande_bon_retour(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Demande Bon Retour';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionCaisse/demande_bon_retour',$data);
    }
    
    public function entreeSortieCaisse(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Type d\'entrées ou de sorties';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionCaisse/entreSortie',$data);
    }
	
	public function marquePneu(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Type de marque';
        $data['page'] = 'Document';
        $this->load->view('backend/pneu/marque',$data);
    }
	
	
	public function typePneu(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Type Pneu';
        $data['page'] = 'Document';
        $this->load->view('backend/pneu/type',$data);
    }
	
    public function entreeCaisse(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Gestion Des Entrées';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionCaisse/entree',$data);
    }
	
	  public function balanceImprimeFournisseur(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Balance Imprime Fournisseur';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionCaisse/balance_imprimable_fournisseur',$data);
    }
	
	  public function balanceImprimeFournisseurGazoil(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Balance Imprime Fournisseur';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionGazoil/balance_imprimable_fournisseur',$data);
    }
	
	public function balanceImprimeFournisseurMatiere(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Balance Imprime Fournisseur';
        $data['page'] = 'Document';
        $this->load->view('backend/matiere_premiere/balance_imprimable_fournisseur_matiere',$data);
    }
	
	public function balanceImprimeFournisseurArticle(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Balance Imprime Fournisseur Article';
        $data['page'] = 'Document';
        $this->load->view('backend/article/balance_imprimable_fournisseur',$data);
    }
	
	
	public function balanceImprimeFournisseurDocument(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Balance Imprime Fournisseur Document';
        $data['page'] = 'Document';
        $this->load->view('backend/documentADM/balance_imprimable_fournisseur',$data);
    }
	
	
	public function balanceImprimeClientMatiere(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Balance Imprime Client';
        $data['page'] = 'Document';
        $this->load->view('backend/matiere_premiere/balance_imprimable_client_matiere',$data);
    }
	
	public function balanceImprimeClientTransport(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Balance Imprime Client';
        $data['page'] = 'Document';
        $this->load->view('backend/client/balance_imprimable_client',$data);
    }
	
    public function SortieCaisse(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Gestion Des Sorties';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionCaisse/sortie',$data);
    }
	
	    public function SortieCaisseDoublon(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'gestion des sorties Doublons';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionCaisse/sortieDoublon',$data);
    }
    public function clotureCaisse(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Cloture de la caisse';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionCaisse/cloture',$data);
    }
    public function clotureArticle(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Cloture Article';
        $data['page'] = 'Document';
        $this->load->view('backend/article/cloture',$data);
    }

    public function fournisseurCaisse(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Fournisseurs de la caisse';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionCaisse/fournisseur',$data);
    }
    public function factureCaisse(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Facture de la caisse';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionCaisse/facture',$data);
    }
    public function reglementCaisse(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Règlement des factures';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionCaisse/reglement',$data);
    }
    public function balanceFournisseur(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Balance Fournisseurs caisse';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionCaisse/balance_fournisseur',$data);
    }
    public function balanceImprimeCaisse(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Balance Imprimable Caisse';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionCaisse/balance_imprimable_caisse',$data);
    }
	
	  

    public function fournisseurArticle(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Fournisseurs d\'article';
        $data['page'] = 'Document';
        $this->load->view('backend/article/fournisseurArticle',$data);
    }


    public function fournisseurDocument(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Fournisseurs Document';
        $data['page'] = 'Document';
        $this->load->view('backend/documentADM/fournisseurDocument',$data);
    }
    public function reglementFournisseurArticle(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Règlement des factures';
        $data['page'] = 'Document';
        $this->load->view('backend/article/reglementFournisseur',$data);
    }
	
	 public function reglementFournisseurDocument(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Règlement des factures';
        $data['page'] = 'Document';
        $this->load->view('backend/documentADM/reglementFournisseur',$data);
    }
    public function balanceFournisseurArticle(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Balance Fournisseurs article';
        $data['page'] = 'Document';
        $this->load->view('backend/article/balanceFournisseur',$data);
    }
	
	public function balanceFournisseurDocument(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Balance Fournisseurs Documents';
        $data['page'] = 'Document';
        $this->load->view('backend/documentADM/balanceFournisseur',$data);
    }
    public function factureFournisseurArticle(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Facture fournisseurs';
        $data['page'] = 'Document';
        $this->load->view('backend/article/factureFournisseur',$data);
    }
	
	   public function factureFournisseurDocument(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Facture fournisseurs';
        $data['page'] = 'Document';
        $this->load->view('backend/documentADM/factureFournisseur',$data);
    }

     public function rapportFactureArticle(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Rappport facture';
        $data['page'] = 'Document';
        $this->load->view('backend/article/rapportFacture',$data);
    }
	
	public function rapportFactureDocument(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Rappport facture';
        $data['page'] = 'Document';
        $this->load->view('backend/documentADM/rapportFacture',$data);
    }

    public function fournisseurMatiere(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Fournisseurs produits de carrière';
        $data['page'] = 'Document';
        $this->load->view('backend/matiere_premiere/fournisseur',$data);
    }

    public function reglementFournisseurMatiere(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Règlement des factures fournisseurs';
        $data['page'] = 'Document';
        $this->load->view('backend/matiere_premiere/reglement',$data);
    }

    public function balanceFournisseurMatiere(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Balance Fournisseurs produit de carrière';
        $data['page'] = 'Document';
        $this->load->view('backend/matiere_premiere/balance',$data);
    }

    public function recetteDepenseParVehicule(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Recette/Dépense';
        $data['page'] = 'Document';
        $this->load->view('backend/vehicule/balance',$data);
    }

    public function factureFournisseurMatiere(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Facture fournisseurs produit de carrière';
        $data['page'] = 'Document';
        $this->load->view('backend/matiere_premiere/facture',$data);
    }
    public function amortissement(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Amortissement d\'usage';
        $data['page'] = 'Document';
        $this->load->view('backend/vehicule/amortissement',$data);
    }
    public function commande(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Commande';
        $data['page'] = 'Document';
        $this->load->view('backend/commande/index',$data);
    }
    public function commandeCimenterie(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Commande CIMENTERIE';
        $data['page'] = 'Document';
        $this->load->view('backend/commande/commandeCimenterie',$data);
    }
    public function rapportMensuel(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Rapport Détaillé Mensuel';
        $data['page'] = 'Document';
        $this->load->view('backend/rapport/rapportMensuel',$data);
    }
    public function rapportMensuelBenne(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Rapport Détaillé Mensuel Benne';
        $data['page'] = 'Document';
        $this->load->view('backend/rapport/rapportMensuelBenne',$data);
    }
    public function rapportMensuelEngin(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Rapport Détaillé Mensuel Engin';
        $data['page'] = 'Document';
        $this->load->view('backend/rapport/rapportMensuelEngin',$data);
    }

    public function rapportMensuelVraquier(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Rapport Détaillé Mensuel vraquier';
        $data['page'] = 'Document';
        $this->load->view('backend/rapport/rapportMensuelVraquier',$data);
    }
    public function rapportMensuelService(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Rapport Détaillé Mensuel Service';
        $data['page'] = 'Document';
        $this->load->view('backend/rapport/rapportMensuelService',$data);
    }
    public function rapportCumuleMensuel(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Rapport Cumulé Mensuel';
        $data['page'] = 'Document';
        $this->load->view('backend/rapport/rapportCumuleMensuel',$data);
    }

    public function rapportCumuleMensuelEN(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Rapport Cumulé Mensuel';
        $data['page'] = 'Document';
        $this->load->view('backend/rapport/rapportCumuleMensuelEN',$data);
    }

    public function rapportCumuleAN(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Rapport Cumulé Mensuel';
        $data['page'] = 'Document';
        $this->load->view('backend/rapport/rapportCumuleAN',$data);
    }

    public function rapportCumuleMensuelService(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Rapport Cumulé Mensuel SERVICE';
        $data['page'] = 'Document';
        $this->load->view('backend/rapport/rcmservice',$data);
    }
    public function rapportCumuleMensuelEngin(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Rapport Cumulé Mensuel ENGIN';
        $data['page'] = 'Document';
        $this->load->view('backend/rapport/rcmengin',$data);
    }

    public function rapportCumuleMensuelVraquier(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Rapport Cumulé Mensuel VRAQUIER';
        $data['page'] = 'Document';
        $this->load->view('backend/rapport/rapportCumuleMensuelVraquier',$data);
    }
    public function rapportCumuleMensuelBenne(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Rapport Cumulé Mensuel BENNE';
        $data['page'] = 'Document';
        $this->load->view('backend/rapport/rcmbenne',$data);
    }

    public function rapportGeneral(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Rapport Général';
        $data['page'] = '';
        $this->load->view('backend/rapport/rapportGeneral',$data);
    }

    public function profile(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Profile';
        $data['page'] = 'Document';
        $this->load->view('backend/profile/profile',$data);
    }

    public function users(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'USERS';
        $data['page'] = 'Document';
        $this->load->view('backend/profile/users',$data);
    }

    public function paie(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'PAIE EMPLOYE';
        $data['page'] = 'Document';
        $this->load->view('backend/chauffeur/paie',$data);
    }
    public function paieChauffeur(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'CHAUFFEUR A PAYER';
        $data['page'] = 'Document';
        $this->load->view('backend/chauffeur/paieChauffeur',$data);
    }
    public function cumulimputationChauffeur(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'CUMUL IMPUTATION';
        $data['page'] = 'Document';
        $this->load->view('backend/chauffeur/cumulimputation',$data);
    }

    public function depenseSalaireChauffeur(){
        $data['page_name'] = 'PAIEMENT CHAUFFEUR';
        $data['page_title'] = 'PAIEMENT CHAUFFEUR';
        $data['page'] = 'Document';
        $this->load->view('backend/depense/depenseSalaireChauffeur',$data);
    }

    public function declarePneuDefectueux(){
        $this->crud_model->declarePneuDefectueux();
    }
    public function addRoueSecours(){
      
        $this->crud_model->addRoueSecours();
    }
    public function contact(){
      
        $this->load->view('backend/contact/index');
    }
    public function actualites(){
      
        $this->load->view('backend/actualites/index');
    }
    public function societe(){
      
        $this->load->view('backend/societe/index');
    }
         public function fournisseurs(){
      
        $this->load->view('backend/fournisseurs/index');
    }
        public function acheteurs(){
      
        $this->load->view('backend/acheteurs/index');
    }
    public function taxi(){
      
        $this->load->view('backend/taxi/index');
    }
    public function portfolio(){
      
        $this->load->view('backend/portfolio/index');
    }
    public function achat_vente(){
      
        $this->load->view('backend/achat_vente_voiture/index');
    }
    
 

    public function administrator_clinic(){

        $this->load->view('backend/administrator_clinic');
    }
    
    public function form_inscript_ecole(){

        $this->load->view('backend/auto_ecole/form_inscription');
    }

    public function connexion_auto_ecole(){
         $this->load->view('backend/auto_ecole/connexion.php');
    }

            public function frenchLang(){
         $language ="french";
         global $URI, $CFG, $IN;
 
        $config =& $CFG->config;
        $lang_browser = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        $URI->uri_string = preg_replace("|^\/?|", '/', $URI->uri_string);   
        $this->session->set_userdata('language_abbr', "fr");
        // $lien =$config['base_url']."fr".$URI->uri_string;
        // echo '<meta http-equiv="refresh" content="5"; url="'.$lien.'" />'
        }
        public function englishLang(){
         $language ="english";
         global $URI, $CFG, $IN;
 
        $config =& $CFG->config;
        $lang_browser = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        $URI->uri_string = preg_replace("|^\/?|", '/', $URI->uri_string);   
        $this->session->set_userdata('language_abbr', "en");
        // $lien =$config['base_url']."fr".$URI->uri_string;
        // echo '<meta http-equiv="refresh" content="5"; url="'.$lien.'" />'
        }

        public function ajoutCommentaire(){
            $com_lm = $_POST['com_lm'];
            $com_cv = $_POST['com_cv'];
            $com_coch = $_POST['com_coch'];
            if($com_lm!=0){
                $this->crud_model->validateCommentaire($com_lm,'0','0');
            }elseif ($com_coch!=0) {
                # code...
                $this->crud_model->validateCommentaire('0','0',$com_coch);
            }else{
                $this->crud_model->validateCommentaire('0',$com_cv,'0');
            }
            
        }
        public function verifMail(){
            $email = $_POST['email'];
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            echo "Email est invalide";

        }else{
            echo "ok";
        }
        }
        public function commentaire(){
            $com_lm = $_POST['com_lm'];
            $com_cv = $_POST['com_cv'];
            $com_coch = $_POST['com_coch'];
            if($com_lm!=0){
                $this->crud_model->selectAllCommentaire($com_lm,'0','0');
            }elseif ($com_coch!=0) {
                # code...
                $this->crud_model->selectAllCommentaire('0','0',$com_coch);
            }else{
                $this->crud_model->selectAllCommentaire('0',$com_cv,'0');
            }
        }
        public function selectAllTemoignage(){
            $this->crud_model->selectTemoignage();
        }
        public function addTemoignage(){
            $this->crud_model->validateTemoignage();
        }

        public function amelioreCV(){
            $this->crud_model->cochingParMail();
        }
        public function optimiseRechercheEmploi(){
            $this->crud_model->cochingParMail();
        }
        public function optimiseEntretient(){
            $this->crud_model->cochingParMail();
        }
        public function transitionProfessionnelle(){
            $this->crud_model->cochingParMail();
        }
        public function addCV(){
        $file_image =$_FILES["file_image"]['tmp_name'];
        $file_word =$_FILES["file_word"]['tmp_name'];
        $sizeImg  =getimagesize($_FILES["file_image"]['tmp_name']);
        $largeur = $sizeImg[0];
        $hauteur = $sizeImg[1];
        // $sizeImg[0] = 355;
        // $sizeImg[1] = 504;
        // echo "la largeur est : ".$largeur."et la hauteur : ".$hauteur; 
        $this->crud_model->addCV($file_image, $file_word,$hauteur,$largeur);
        }
        public function addLM(){
        $file_image =$_FILES["file_image1"]['tmp_name'];
        $file_word =$_FILES["file_word1"]['tmp_name'];
        // echo $file_image." ".$file_word." ".$_POST["montant1"];
        $this->crud_model->addLM($file_image, $file_word);
        }

        public function get_modeleCV(){
        $this->crud_model->sentCVParMail(); 
        }
        public function envoitFichier(){
            $this->load->view('backend/mail_mime_php');
        }
        public function afficheBtnPaiement(){
            $this->load->view('backend/formPaiement');
        }

        public function addClients(){
            $this->crud_model->addClient(); 
        }
         public function editCV(){
            $this->crud_model->editCV(); 
        }
        public function editLM(){
            $this->crud_model->editLM(); 
        }
        public function deleteCV(){
            $this->crud_model->deleteCV(); 
        }
        public function deleteLM(){
            $this->crud_model->deleteLM(); 
        }

        public function mouchard(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'MOUCHARD';
        $data['page'] = 'Document';
        $this->load->view('backend/profile/mouchard',$data);
    }
    
    public function rapportCumuleMensuelAccident(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Rapport Cumulé Mensuel Accident';
        $data['page'] = 'Document';
        $this->load->view('backend/rapport/rcmAccident',$data);
    }

    public function rapportCumuleMensuelApprovisionnement(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Rapport Cumulé Approvisionnement';
        $data['page'] = 'Document';
        $this->load->view('backend/rapport/rcmApprovisionnement',$data);
    }
	
	    public function getUniqueNotification(){
        $this->crud_model->getUniqueNotification();

    }

    public function getNbreNewNotification(){
      echo  $this->crud_model->getNbreNewNotification();

    }

    public function getUniqueNotificationParTemps(){
        $this->crud_model->getUniqueNotification();

    }

    public function getNbreNewNotificationParTemps(){
      echo  $this->crud_model->getNbreNewNotificationParTemps();

    }
	
	  public function nePlusAfficher(){
        $this->crud_model->nePlusAfficher();

    }

}