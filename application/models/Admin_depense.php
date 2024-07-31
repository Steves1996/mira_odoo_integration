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

    public function addGazoil(){
        $this->crud_model_depense->addGazoil();
    }
    public function getAllGazoil(){
        $this->crud_model_depense->selectAllGazoil();
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

    public function getAllFraisDivers(){
        $this->crud_model_depense->selectAllFraisDivers();
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

    public function getAllVidangeHydrolique(){
        $this->crud_model_depense->selectAllVidangeHydrolique();
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

   public function getPrixUnitaireHuile(){
        $this->crud_model_depense->getPrixUnitaireHuile();
    
   }

   public function addDepensePneu(){
        $this->crud_model_depense->addDepensePneu();
    
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

   public function getKilometrageVehicule(){
        $code = $_POST['code_camion'];
    echo $this->crud_model_depense->getKilometrageVehicule($code);
   }
}