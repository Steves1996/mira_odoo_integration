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
    public function location_engin(){
      $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Location engin';
        $data['page'] = 'Document';
        $this->load->view('backend/livraison/location_engin',$data);
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
    public function fournisseur(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Fournisseur Gazoil';
        $data['page'] = 'Document';
        $this->load->view('backend/fournisseur/index',$data);
    }
    public function prime(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Primes';
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
    public function article(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Articles';
        $data['page'] = 'Document';
        $this->load->view('backend/article/index',$data);
    }public function type_huile(){
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
    public function reglementClient(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Règlement client';
        $data['page'] = 'Document';
        $this->load->view('backend/client/reglement',$data);
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
    public function factureGazoil(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Facture gazoil';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionGazoil/facture',$data);
    }
    public function reglementFactureGazoil(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Règlement de la facuture';
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
    public function stock(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Stock';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionStock/stock',$data);
    }
    public function entreeSortieCaisse(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Type d\'entrées ou de sorties';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionCaisse/entreSortie',$data);
    }
    public function entreeCaisse(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'gestion des entrée';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionCaisse/entree',$data);
    }
    public function SortieCaisse(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'gestion des sorties';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionCaisse/sortie',$data);
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
    public function balanceCaisse(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Balance Caisse';
        $data['page'] = 'Document';
        $this->load->view('backend/gestionCaisse/balance',$data);
    }

    public function fournisseurArticle(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Fournisseurs d\'article';
        $data['page'] = 'Document';
        $this->load->view('backend/article/fournisseurArticle',$data);
    }

    public function reglementFournisseurArticle(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Règlement des factures';
        $data['page'] = 'Document';
        $this->load->view('backend/article/reglementFournisseur',$data);
    }
    public function balanceFournisseurArticle(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Balance Fournisseurs article';
        $data['page'] = 'Document';
        $this->load->view('backend/article/balanceFournisseur',$data);
    }
    public function factureFournisseurArticle(){
        $data['page_name'] = 'Accueil';
        $data['page_title'] = 'Facture fournisseurs';
        $data['page'] = 'Document';
        $this->load->view('backend/article/factureFournisseur',$data);
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
}