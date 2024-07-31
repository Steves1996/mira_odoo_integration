<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Admin_article extends CI_Controller {

    function __construct() {
        parent::__construct();
        global $URI, $CFG, $IN;

        $config = & $CFG->config;
        $URI->uri_string = preg_replace( '|^\/?|', '/', $URI->uri_string );
        // echo '<script type=\'text/javascript\">
        //     alert('la langue est :".$URI->uri_string."');
        // </script>";

        $this->load->model( 'crud_model_chauffeur' );
        $this->load->model( 'crud_model_vehicule' );
        $this->load->model( 'crud_model_document' );
        $this->load->model( 'crud_model_client' );
        $this->load->model( 'crud_model_article' );
        // $this->load->database( 'default' );
        $this->load->library( 'session' );
        $this->load->helper( 'app_gui_helper' );
        $this->load->helper( 'cookie' );
        $this->load->helper( 'url' );
        // $this->session->set_userdata( 'language_abbr', 'en' );

        if ( $this->session->userdata( 'language_abbr' ) !== null ) {
            # code...
            // $this->lang->load( 'car', $this->session->userdata( 'language' ) );

        } else {
            // $this->lang->load( 'car', 'french' );
            $this->session->set_userdata( 'language_abbr', $config[ 'language_abbr' ] );

        }
        // $this->lang->load( 'teste', 'french' );
        // $this->load->database( 'default' );
        /* cache control */
        $this->output->set_header( 'Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0' );
        $this->output->set_header( 'Pragma: no-cache' );
    }

    public function verifiDateInitialClient() {
        echo $this->crud_model_article->verifiDateInitialClient();
    }

    public function getDateInitialClient() {
        echo  $this->crud_model_article->getDateInitialClient();
    }

    public function getSoldeInitialClient() {
        echo $this->crud_model_article->getSoldeInitialClient();
    }

    public function getNomClient() {
        $id_client = $_POST[ 'id_client' ];
        echo $this->crud_model_article->getClient( $id_client );
    }

    public function getAdresseClient() {
        $id_client = $_POST[ 'id_client' ];
        echo $this->crud_model_article->getAdresseClient( $id_client );
    }

    public function getVilleClient() {
        $id_client = $_POST[ 'id_client' ];
        echo $this->crud_model_article->getVilleClient( $id_client );
    }

    public function getTelephoneClient() {
        $id_client = $_POST[ 'id_client' ];
        echo $this->crud_model_article->getTelephoneClient( $id_client );
    }

    public function soldeCaisseClient2() {
        $this->crud_model_article->soldeCaisseClient2();
    }

    public function getBalanceImprimableClient() {

        $this->crud_model_article->getBalanceImprimableClient();

    }

    public function getBalanceImprimableClient1() {

        $this->crud_model_matiere->getBalanceImprimableClient1();

    }

    public function repportNouveau() {
        if ( isset( $_POST[ 'id_client' ] ) ) {
            # code...
            echo $this->crud_model_article->repportNouveau( $_POST[ 'id_client' ] );
        } else {
            echo $this->crud_model_article->repportNouveau( '' );
        }
    }

    public function repportNouveauDebit() {
        if ( isset( $_POST[ 'id_client' ] ) ) {
            # code...
            echo $this->crud_model_article->repportNouveauDebit( $_POST[ 'id_client' ] );
        } else {
            echo $this->crud_model_article->repportNouveauDebit( '' );
        }
    }

    public function repportNouveauCredit() {
        if ( isset( $_POST[ 'id_client' ] ) ) {
            # code...
            echo $this->crud_model_article->repportNouveauCredit( $_POST[ 'id_client' ] );
        } else {
            echo $this->crud_model_article->repportNouveauCredit( '' );
        }
    }

    public function getAllCreditPourBalance() {
        $this->crud_model_article->selectAllCreditPourBalance();
    }

    public function getAllTotalCreditPourBalance() {
        echo $this->crud_model_article->selectAllTotalCreditPourBalanceClient();
    }

    public function getCreditPourBalanceImpCLient() {
        echo $this->crud_model_article->getCreditPourBalanceImpCLient();
    }

    public function getDebitPourBalanceImpCLient() {
        echo $this->crud_model_article->getDebitPourBalanceImpCLient();
    }

    public function getAllTotalAccuseRetraitPourBalance2() {
        echo $this->crud_model_article->selectAllTotalAccuseReglementPourBalanceClient();
        // echo $this->crud_model_commercial->selectAllTotalAccuseRetraitPourBalance();
    }

    public function getAllTotalAccuseReglementPourBalance2() {
        echo $this->crud_model_article->totalFacturePourBalanceClient();
        // echo $this->crud_model_commercial->selectAllTotalAccuseReglementPourBalanceClient();
    }

    public function addArticle() {
        $this->crud_model_article->addArticle();
    }

    public function getAllArticle() {
        $this->crud_model_article->selectAllArticle();
    }

    public function addTypeArticle() {
        $this->crud_model_article->addTypeArticle();
    }

    public function getAllTypeArticle() {
        $this->crud_model_article->selectAllTypeArticle();
    }

    public function addFournisseurArticle() {
        $this->crud_model_article->addFournisseurArticle();
    }

    public function getAllFournisseurArticle() {
        $this->crud_model_article->selectAllFournisseurArticle();
    }

    public function addFactureArticle() {
        $this->crud_model_article->addFacture();
    }

    public function getAllFactureArticle() {
        $this->crud_model_article->selectAllFacture();
    }

    public function getMontantBL() {
        $this->crud_model_article->selectMontFactureBL();
    }

    public function leSelectBLParFournisseur() {
        $this->crud_model_article->leSelectBLParFournisseur();
    }

    public function addReglement() {
        $this->crud_model_article->addReglement();
    }

    public function getAllReglement() {
        $this->crud_model_article->selectAllReglement();
    }

    public function getAllFacturePourBalanceArticle() {
        $this->crud_model_article->selectAllFacturePourBalance();
    }

    public function getAllReglementPourBalanceArticle() {
        $this->crud_model_article->selectAllReglementPourBalance();
    }

    public function selectAllTotalReglementPourBalanceFournisseur() {
        echo $this->crud_model_article->selectAllTotalReglementPourBalanceFournisseur();
    }

    public function soldeArticleFournisseur() {
        $this->crud_model_article->soldeCaisseFournisseur();
    }

    public function selectAllTotalFacturePourBalanceFournisseur() {
        echo $this->crud_model_article->selectAllTotalFacturePourBalanceFournisseur();
    }

    // pour cloture article

    public function getSoldeArticle() {
        $this->crud_model_article->getSoldeArticle();
    }

    public function getTotalFacture() {
        $this->crud_model_article->getTotalFacture();
    }

    public function getTotalReglement() {
        $this->crud_model_article->getTotalReglement();
    }

    public function addClotureArticle() {
        $this->crud_model_article->addClotureArticle();
    }

    public function getAllClotureArticle() {
        $this->crud_model_article->selectAllClotureArticle();
    }

    public function selectAllFactureParFournisseur() {
        $this->crud_model_article->selectAllFactureParFournisseur();
    }

    public function selectAllReglementParFournisseur() {
        $this->crud_model_article->selectAllReglementParFournisseur();
    }

    public function rapportFacture() {
        $this->crud_model_article->rapportFacture();
    }

    public function deleteFournisseurArticle() {
        $table = $_POST[ 'table' ];
        $identifiant = $_POST[ 'identifiant' ];
        $nom_id = $_POST[ 'nom_id' ];
        $this->crud_model_article->deleteFournisseurArticle( $table, $identifiant, $nom_id );
    }

    public function deleteFactureFournisseurArticle() {
        $table = $_POST[ 'table' ];
        $identifiant = $_POST[ 'identifiant' ];
        $nom_id = $_POST[ 'nom_id' ];
        $this->crud_model_article->deleteFactureFournisseurArticle( $table, $identifiant, $nom_id );
    }

    public function deleteReglementFournisseurArticle() {
        $table = $_POST[ 'table' ];
        $identifiant = $_POST[ 'identifiant' ];
        $nom_id = $_POST[ 'nom_id' ];
        $this->crud_model_article->deleteReglementFournisseurArticle( $table, $identifiant, $nom_id );
    }

    public function deleteCloturerArticle() {
        $table = $_POST[ 'table' ];
        $identifiant = $_POST[ 'identifiant' ];
        $nom_id = $_POST[ 'nom_id' ];
        $this->crud_model_article->deleteClotureArticle( $table, $identifiant, $nom_id );
    }

    public function deleteArticle() {
        $table = $_POST[ 'table' ];
        $identifiant = $_POST[ 'identifiant' ];
        $nom_id = $_POST[ 'nom_id' ];
        $this->crud_model_article->deleteArticle( $table, $identifiant, $nom_id );
    }
}