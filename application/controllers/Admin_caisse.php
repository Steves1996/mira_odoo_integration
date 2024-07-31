<?php

defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Admin_caisse extends CI_Controller {

    function __construct() {
        parent::__construct();
        global $URI, $CFG, $IN;

        $config = & $CFG->config;
        $URI->uri_string = preg_replace( '|^\/?|', '/', $URI->uri_string );
        // echo '<script type=\'text/javascript\">
        //     alert('la langue est :".$URI->uri_string."');
        // </script>";

        $this->load->model( 'crud_model_caisse' );
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

    public function addCaisse() {
        $this->crud_model_caisse->addCaisse();
    }

    public function getAllCaisse() {
        $this->crud_model_caisse->selectAllCaisse();
    }

    public function addSortie() {
        $this->crud_model_caisse->addSortie();
    }

    public function addSortie1() {
        $this->crud_model_caisse->addSortie1();
    }

    public function verifiDateInitialClient() {
        echo $this->crud_model_caisse->verifiDateInitialClient();
    }

    public function getDateInitialClient() {
        echo  $this->crud_model_caisse->getDateInitialClient();
    }

    public function getSoldeInitialClient() {
        echo $this->crud_model_caisse->getSoldeInitialClient();
    }

    public function getNomClient() {
        $id_client = $_POST[ 'id_client' ];
        echo $this->crud_model_caisse->getClient( $id_client );
    }

    public function getAdresseClient() {
        $id_client = $_POST[ 'id_client' ];
        echo $this->crud_model_caisse->getAdresseClient( $id_client );
    }

    public function getVilleClient() {
        $id_client = $_POST[ 'id_client' ];
        echo $this->crud_model_caisse->getVilleClient( $id_client );
    }

    public function getTelephoneClient() {
        $id_client = $_POST[ 'id_client' ];
        echo $this->crud_model_caisse->getTelephoneClient( $id_client );
    }

    public function soldeCaisseClient2() {
        $this->crud_model_caisse->soldeCaisseClient2();
    }

    public function soldeCaisseCaisse2() {
        $this->crud_model_caisse->soldeCaisseCaisse2();
    }

    public function getBalanceImprimableClient() {

        $this->crud_model_caisse->getBalanceImprimableClient();

    }

    public function getBalanceImprimableCaisse() {

        $this->crud_model_caisse->getBalanceImprimableCaisse();

    }

    public function repportNouveau() {
        if ( isset( $_POST[ 'id_client' ] ) ) {
            # code...
            echo $this->crud_model_caisse->repportNouveau( $_POST[ 'id_client' ] );
        } else {
            echo $this->crud_model_caisse->repportNouveau( '' );
        }
    }

    public function repportNouveauDebit() {
        if ( isset( $_POST[ 'id_client' ] ) ) {
            # code...
            echo $this->crud_model_caisse->repportNouveauDebit( $_POST[ 'id_client' ] );
        } else {
            echo $this->crud_model_caisse->repportNouveauDebit( '' );
        }
    }

    public function repportNouveauCredit() {
        if ( isset( $_POST[ 'id_client' ] ) ) {
            # code...
            echo $this->crud_model_caisse->repportNouveauCredit( $_POST[ 'id_client' ] );
        } else {
            echo $this->crud_model_caisse->repportNouveauCredit( '' );
        }
    }

    public function getAllCreditPourBalance() {
        $this->crud_model_caisse->selectAllCreditPourBalance();
    }

    public function getAllTotalCreditPourBalance() {
        echo $this->crud_model_caisse->selectAllTotalCreditPourBalanceClient();
    }

    public function getCreditPourBalanceImpCLient() {
        echo $this->crud_model_caisse->getCreditPourBalanceImpCLient();
    }

    public function getDebitPourBalanceImpCLient() {
        echo $this->crud_model_caisse->getDebitPourBalanceImpCLient();
    }

    public function getAllTotalAccuseRetraitPourBalance2() {
        echo $this->crud_model_caisse->selectAllTotalAccuseReglementPourBalanceClient();
        // echo $this->crud_model_commercial->selectAllTotalAccuseRetraitPourBalance();
    }

    public function getAllTotalAccuseReglementPourBalance2() {
        echo $this->crud_model_caisse->totalFacturePourBalanceClient();
        // echo $this->crud_model_commercial->selectAllTotalAccuseReglementPourBalanceClient();
    }

    public function getCodeCamion() {
        $this->crud_model_caisse->leSelectCodeCamion();
    }

    public function getfournisseur() {
        $this->crud_model_caisse->leSelectFournisseurCaisse1();
    }

    public function getfournisseurdem() {
        $this->crud_model_caisse->leSelectFournisseurCaisseDem();
    }

    public function getOperationdem() {
        $this->crud_model_caisse->leSelectOperationCaisseDem();
    }

    public function getDestinationdem() {
        $this->crud_model_caisse->leSelectDestinationCaisseDem();
    }

    public function getVehiculedem() {
        $this->crud_model_caisse->leSelectVehiculeCaisseDem();
    }

    public function getAllSortie() {
        $this->crud_model_caisse->selectAllSortie();
    }

    public function getAllSortie2() {
        $this->crud_model_caisse->selectAllSortie2();
    }

    public function getAllSortie1() {
        $this->crud_model_caisse->selectAllSortie1();
    }

    public function addEntree() {
        $this->crud_model_caisse->addEntree();
    }

    public function getAllEntree() {
        $this->crud_model_caisse->selectAllEntree();
    }

    public function addFournisseurCaisse() {
        $this->crud_model_caisse->addFournisseurCaisse();
    }

    public function getAllFournisseurCaisse() {
        $this->crud_model_caisse->selectAllFournisseurCaisse();
    }

    public function addFactureCaisse() {
        $this->crud_model_caisse->addFacture();
    }

    public function getAllFactureCaisse() {
        $this->crud_model_caisse->selectAllFacture();
    }

    public function addReglement() {
        $this->crud_model_caisse->addReglement();
    }

    public function getAllReglement() {
        $this->crud_model_caisse->selectAllReglement();
    }

    public function selectAllTotalReglementPourBalanceFournisseur() {
        echo $this->crud_model_caisse->selectAllTotalReglementPourBalanceFournisseur();
    }

    public function soldeCaisseFournisseur() {
        $this->crud_model_caisse->soldeCaisseFournisseur();
    }

    public function selectAllTotalFacturePourBalanceFournisseur() {
        echo $this->crud_model_caisse->selectAllTotalFacturePourBalanceFournisseur();
    }

    public function getAllFacturePourBalanceCaisse() {
        $this->crud_model_caisse->selectAllFacturePourBalance();
    }

    public function getAllReglementPourBalanceCaisse() {
        $this->crud_model_caisse->selectAllReglementPourBalance();
    }

    public function getAllEntreePourBalanceCaisse() {
        $this->crud_model_caisse->selectAllEntreePourBalance2();
    }

    public function getAllSortiePourBalanceCaisse() {
        $this->crud_model_caisse->selectAllSortiePourBalance2();
    }

    public function getSoldeCaisse2() {
        $this->crud_model_caisse->getSoldeCaisse2();
    }

    public function getTotalEntree2() {
        $this->crud_model_caisse->getTotalEntree2();
    }

    public function getTotalSortie2() {
        $this->crud_model_caisse->getTotalSortie2();
    }

    public function facturePourBalanceClient() {
        $this->crud_model_caisse->facturePourBalanceClient();
    }

    public function totalFacturePourBalanceClient() {
        echo number_format( $this->crud_model_commercial->totalFacturePourBalanceClient(), 0, ',', ' ' );
    }

    // pour cloture caissse

    public function getSoldeCaisse3() {
        $this->crud_model_caisse->getSoldeCaisse3();
    }

    public function getTotalEntree3() {
        $this->crud_model_caisse->getTotalEntree3();
    }

    public function getTotalSortie3() {
        $this->crud_model_caisse->getTotalSortie3();
    }

    public function getAllClotureCaisse() {
        $this->crud_model_caisse->selectAllClotureCaisse();
    }

    public function addClotureCaisse() {
        $this->crud_model_caisse->addClotureCaisse();
    }

    public function getNbreLigne1() {
        $this->crud_model_caisse->getNbreLigne1();
    }

    public function addDemandeCaisse() {
        $this->crud_model_caisse->addDemandeCaisse();

    }

    public function getNouveauCode() {
        echo $this->crud_model_caisse->genererChaineAleatoireDemande();
    }

    public function getEtatPrint() {
        echo $this->crud_model_caisse->getEtatPrint();
    }

    public function getAllDemandeCaisse() {
        $this->crud_model_caisse->selectAllDemandeCaisse();
    }

    public function getAllDemandeCaisseRetour() {
        $this->crud_model_caisse->selectAllDemandeCaisseRetour();
    }

    public function getDetailDemmandePourModification() {
        $this->crud_model_depense->getDetailDemmandePourModification();
    }

    public function getListeDemmandePourModif () {
        $this->crud_model_caisse->getListeDemmandePourModif ();
    }

    public function getDetailDemande() {
        $this->crud_model_caisse->getDetailDemande();
    }

    public function getDetailDemandeRetour() {
        $this->crud_model_caisse->getDetailDemandeRetour();
    }

    public function deleteEntreeSortie() {
        $table = $_POST[ 'table' ];
        $identifiant = $_POST[ 'identifiant' ];
        $nom_id = $_POST[ 'nom_id' ];
        $this->crud_model_caisse->deleteEntreeSortie( $table, $identifiant, $nom_id );
    }

    public function deleteEntreeCaisse() {
        $table = $_POST[ 'table' ];
        $identifiant = $_POST[ 'identifiant' ];
        $nom_id = $_POST[ 'nom_id' ];
        $this->crud_model_caisse->deleteEntreeCaisse( $table, $identifiant, $nom_id );
    }

    public function deleteSortieCaisse() {
        $table = $_POST[ 'table' ];
        $identifiant = $_POST[ 'identifiant' ];
        $nom_id = $_POST[ 'nom_id' ];
        $this->crud_model_caisse->deleteSortieCaisse( $table, $identifiant, $nom_id );
    }

    public function deleteClotureCaisse() {
        $table = $_POST[ 'table' ];
        $identifiant = $_POST[ 'identifiant' ];
        $nom_id = $_POST[ 'nom_id' ];
        $this->crud_model_caisse->deleteClotureCaisse( $table, $identifiant, $nom_id );
    }

    public function deleteFournisseurCaisse() {
        $table = $_POST[ 'table' ];
        $identifiant = $_POST[ 'identifiant' ];
        $nom_id = $_POST[ 'nom_id' ];
        $this->crud_model_caisse->deleteFournisseurCaisse( $table, $identifiant, $nom_id );
    }

    public function deleteFactureFournisseurCaisse() {
        $table = $_POST[ 'table' ];
        $identifiant = $_POST[ 'identifiant' ];
        $nom_id = $_POST[ 'nom_id' ];
        $this->crud_model_caisse->deleteFactureFournisseurCaisse( $table, $identifiant, $nom_id );
    }

    public function deleteReglementFournisseurCaisse() {
        $table = $_POST[ 'table' ];
        $identifiant = $_POST[ 'identifiant' ];
        $nom_id = $_POST[ 'nom_id' ];
        $this->crud_model_caisse->deleteReglementFournisseurCaisse( $table, $identifiant, $nom_id );
    }
}