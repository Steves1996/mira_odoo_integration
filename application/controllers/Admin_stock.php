<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_stock extends CI_Controller{
	
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
        $this->load->model('crud_model_stock');
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

    public function addInventaire(){
        $this->crud_model_stock->addInventaire();
    }

    public function getLeselectArticlePourInventaire(){
        $this->crud_model_stock->leSelectArticlePourInventaire();
    }
	
	
    public function selectAllInventaire(){
        $this->crud_model_stock->selectAllInventaire();
    }
// Nous allons maintenant gérer les approvisionnements

    public function addApprovisionnement(){
        $this->crud_model_stock->addApprovisionnement();
    }

    public function getLeselectArticlePourApprovisionnement(){
        $this->crud_model_stock->leSelectArticlePourApprovisionnement();
    }
    
     public function selectAllApprovisionnement(){
        $this->crud_model_stock->selectAllApprovisionnement();
    }

    // NOus allons passer au pièces défectueuses
    public function addDefectueux(){
        $this->crud_model_stock->addDefectueux();
    }

    public function getLeselectArticlePourDefectueux(){
        $this->crud_model_stock->leSelectArticlePourDefectueux();
    }

    public function selectAllDefectueux(){
        $this->crud_model_stock->selectAllDefectueux();
    }

    public function selectAllStock(){
        $this->crud_model_stock->selectAllStock();
    }
	
	

    public function selectAllStockvaleur(){
        $this->crud_model_stock->selectAllStockvaleur();
    }
    public function getDateDernierInventaire(){
       echo $this->crud_model_stock->getDateDernierInventaire();
    }

    public function getArticleParCategorie(){
        $this->crud_model_stock->getArticleParCategorie();
    }

    public function deleteInventaire(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_stock->deleteInventaire($table, $identifiant, $nom_id);
    }
	
	

    public function deleteApprovisionnement(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_stock->deleteApprovisionnement($table, $identifiant, $nom_id);
    }

    public function deleteDefectueux(){
        $table = $_POST["table"];
        $identifiant = $_POST["identifiant"];
        $nom_id = $_POST["nom_id"];
        $this->crud_model_stock->deleteDefectueux($table, $identifiant, $nom_id);
    }

    public function getReferenceArticle(){
        $id_article = $_POST['id_article'];
    echo $this->crud_model_stock->getReferenceArticle($id_article);
   }
   
   public function getPrixUnitaireArticle(){
        $id_article = $_POST['id_article'];
    echo $this->crud_model_stock->getPrixUnitaireArticle($id_article);
   }
}