<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model_depense extends CI_Model {
// 
    function __construct() {
        parent::__construct();
        $this->load->database('default');
        $this->load->library('session');
        // $this->load->helper('app_gui_helper');
        $this->load->helper('cookie');
        $this->load->helper('url');
        // $this->session->set_userdata('language_abbr', "en"); 
    }


public function notificationAjout($nom_table,$message){
  $this->db->query("INSERT into notification value('','".php_uname('n')."',".$this->session->userdata('id_profil').",'".$nom_table."','".$message."',now(),now())");
  
  $this->db->close();
}

public function notificationAjout2($nom_table,$message){
  $this->db->query("INSERT into notification2 value('','".php_uname('n')."',".$this->session->userdata('id_profil').",'".$nom_table."','".$message."',now(),now())");
  
  $this->db->close();
}

public function getIdentifiantUtilisateur($id_profil){
  $query = $this->db->query("SELECT * from profil where id_profil='".$id_profil."'")->row();
  if (count($query)>0) {
    # code...
    return $query->identifiant;
  }

  $this->db->close();
}

// ceci est la fonction permet de vérifier si une action se déroule bien à partir de la date de debut de l'opération
public function getValideDateUseOperation($date_action,$id_operation){
    $getOperation = $this->db->query("SELECT * from operation where id_operation =".$id_operation." limit 1")->row();

    if ($date_action < $getOperation->date_debut) {
        # code...
        return true;
    }else{
        return false;
    }

    $this->db->close();
}
public function updateKilometrage($code_camion,$kilometrage){
    $getTracteur = $this->db->query("SELECT * from tracteur where code='".$code_camion."'")->row();

    $getBenne = $this->db->query("SELECT * from camion_benne where code='".$code_camion."'")->row();

    $getEngin = $this->db->query("SELECT * from engin where code='".$code_camion."'")->row();
    if (count($getTracteur)>0) {
        # code...
         $this->db->query("UPDATE tracteur set kilometrage=".$kilometrage." where code='".$code_camion."'");
    }elseif (count($getBenne)>0) {
        # code...
        $this->db->query("UPDATE camion_benne set kilometrage=".$kilometrage." where code='".$code_camion."'");
    }elseif (count($getEngin)>0) {
        # code...
        $this->db->query("UPDATE engin set kilometrage=".$kilometrage." where code='".$code_camion."'");
    }
    $this->db->close();
}

public function getTypeCamion(){
    $code_camion = $_POST['code_camion'];
     $getCamion = $this->db->query("SELECT * from camion_benne where code = '".$code_camion."'")->row();
     if (count($getCamion)>0) {
         # code...
        echo "true";
     }else{
        echo "false";
     }

     $this->db->close();
}

public function addGazoil(){
    $commentaire = addslashes($_POST["commentaire"]);
    $numero = $_POST["numero"];
    $date = $_POST["dateDepense"];
    $litrage = $_POST["litrage"];
    $destination = $_POST["destination"];
    $kilometrage = $_POST["kilometrage"];
    $prixUnitaire = preg_replace('/\s/','', $_POST["prixUnitaire"]);
    $id_fournisseur = $_POST["id_fournisseur"];
    $codeCamion = $_POST["codeCamion"];
    $id_operation = $_POST["id_operation"];
    // $supplement = $_POST['supplement'];
    $status = $_POST["status"];

    $verifKilometrage = $this->db->query("SELECT * from gazoil WHERE code_camion ='".$codeCamion."' order by id_gazoil desc limit 1")->row();
    // echo "nombre ".count($verifKilometrage);
    $montant = $litrage*$prixUnitaire;
    $nom_table = "gazoil";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté une dépense gasoil N° ".$numero.", pour ".$litrage." au prix unitaire de ".$prixUnitaire." FCFA, pour un montant total de ".$montant." FCFA, le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié une dépense gasoil N° ".$numero.", pour ".$litrage." au prix unitaire de ".$prixUnitaire." FCFA, pour un montant total de ".$montant." FCFA, le ".$date_notif." à ".$heure;
 if ($status == "insert") {
     # code...
    if (count($verifKilometrage)<1){
        # code...
        // on verifie si la date est supérieure à celle du debut de l'operation choisie
        // if ($this->getValideDateUseOperation($date,$id_operation) == true) {
        //     # code...
        //     echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        // }else{
        $insertion = $this->db->query("INSERT into gazoil value ('',".$id_operation.",".$id_fournisseur.",'".$codeCamion."','".$numero."',".$destination.", CAST('". $date."' AS DATE) ,".$litrage.",".$kilometrage.",".$prixUnitaire.",'".$commentaire."','".$numero."','oui',0,0,0,0)");

            if ($insertion == true) {
                # code...
                echo "Insertion parfaite de la dépense";
                $this->updateKilometrage($codeCamion,$kilometrage);
                $this->notificationAjout($nom_table,addslashes($message));
            }else{
                echo "Erreur d'insertion";
            }
        // }
    }else{
    if ($verifKilometrage->kilometrage>$kilometrage) {
        # code...
        if ($verifKilometrage->date_gazoil >$date) {
            # code...
             $verifNumero = $this->db->query("SELECT * FROM gazoil where numero = '".$numero."'")->result_array();
    if (count($verifNumero) >0) {
        # code...
        echo "Ce numéro est déjà utilisé veuillez saisir un autre";
    }else{
        // if ($this->getValideDateUseOperation($date,$id_operation) == true) {
        //     # code...
        //     echo "Entrez une date supérieure à celle du debut de cette operation";
        // }else{
         $insertion = $this->db->query("INSERT into gazoil value ('',".$id_operation.",".$id_fournisseur.",'".$codeCamion."','".$numero."',".$destination.", CAST('". $date."' AS DATE) ,".$litrage.",".$kilometrage.",".$prixUnitaire.",'".$commentaire."','".$numero."','oui',0,0,0,0)");

    if ($insertion == true) {
        # code...
        echo "Insertion parfaite de la dépense";
        $this->updateKilometrage($codeCamion,$kilometrage);
        $this->notificationAjout($nom_table,addslashes($message));
    }else{
        echo "Erreur d'insertion";
    }
    // }
    }
        }else{
echo "Le nouveau kilometrage doit être supérieure ou egale à celui de la consommation précédante";
        }
        
    }else{

    $verifNumero = $this->db->query("SELECT * FROM gazoil where numero = '".$numero."'")->result_array();
    if (count($verifNumero) >0) {
        # code...
        echo "Ce numéro est déjà utilisé veuillez saisir un autre";
    }else{
        // if ($this->getValideDateUseOperation($date,$id_operation) == true) {
        //     # code...
        //     echo "Entrez une date supérieure à celle du debut de cette operation";
        // }else{
         $insertion = $this->db->query("INSERT into gazoil value ('',".$id_operation.",".$id_fournisseur.",'".$codeCamion."','".$numero."',".$destination.", CAST('". $date."' AS DATE) ,".$litrage.",".$kilometrage.",".$prixUnitaire.",'".$commentaire."','".$numero."','oui',0,0,0,0)");

    if ($insertion == true) {
        # code...
        echo "Insertion parfaite de la dépense";
        $this->updateKilometrage($codeCamion,$kilometrage);
        $this->notificationAjout($nom_table,addslashes($message));
    }else{
        echo "Erreur d'insertion";
    }
    // }
    }
 }
    }   
 }elseif ($status == "update") {
     # code...
    if (count($verifKilometrage)<1) {

   
    $id_gazoil = $_POST["id_gazoil"];
    // if ($this->getValideDateUseOperation($date,$id_operation) == true) {
    //         # code...
    //         echo "Entrez une date supérieure à celle du debut de cette operation";
    //     }else{
    $verifNumero = $this->db->query("SELECT * FROM gazoil where numero = '".$numero."'  limit 1")->result_array();
    if (count($verifNumero) >0) {
        # code...
        
        foreach ($verifNumero as $tab) {
            # code...
            if ($tab["id_gazoil"] == $id_gazoil) {
                # code...
                $id_gazoil = $_POST["id_gazoil"];
        $update = $this->db->query("UPDATE gazoil set id_operation=".$id_operation.",id_fournisseur=".$id_fournisseur.",code_camion='".$codeCamion."',numero = '".$numero."',date_gazoil = CAST('". $date."' AS DATE), litrage = ".$litrage.", id_distance = ".$destination.", kilometrage = ".$kilometrage.",prix_unitaire = ".$prixUnitaire.", commentaire ='".$commentaire."', bl = '".$numero."' where id_gazoil=".$id_gazoil."");

    if ($update == true) {
        # code...
        echo "Modification parfaite de la dépense";
        $this->updateKilometrage($codeCamion,$kilometrage);
        $this->notificationAjout($nom_table,addslashes($message2));
    }else{
        echo "Erreur de la modification";
    }
            }else{
    echo "Ce numéro est déjà utilisé veuillez saisir un autre";
            }
        }
    }else{
     
        $update = $this->db->query("UPDATE gazoil set id_operation=".$id_operation.",id_fournisseur=".$id_fournisseur.",code_camion='".$codeCamion."',numero = '".$numero."',date_gazoil = CAST('". $date."' AS DATE), litrage = ".$litrage.", id_distance = ".$destination.", kilometrage = ".$kilometrage.",prix_unitaire = ".$prixUnitaire.", commentaire ='".$commentaire."', bl = '".$numero."' where id_gazoil=".$id_gazoil."");

    if ($update == true) {
        # code...
        echo "Modification parfaite de la dépense";
        $this->updateKilometrage($codeCamion,$kilometrage);
        $this->notificationAjout($nom_table,addslashes($message2));
    }else{
        echo "Erreur de la modification";
    }
    }
// }





    }else{
    //         if ($verifKilometrage->kilometrage<$kilometrage) {
    //     # code...
    //     echo "Ce kilometrage ne doit pas etre superieur à celui de la dernière insertion ";
    // }else{
    $id_gazoil = $_POST["id_gazoil"];
    // if ($this->getValideDateUseOperation($date,$id_operation) == true) {
    //         # code...
    //         echo "Entrez une date supérieure à celle du debut de cette operation";
    //     }else{
    $verifNumero = $this->db->query("SELECT * FROM gazoil where numero = '".$numero."' limit 1")->result_array();
    if (count($verifNumero) >0) {
        # code...
        
        foreach ($verifNumero as $tab) {
            # code...
            if ($tab["id_gazoil"] == $id_gazoil) {
                # code...
                $id_gazoil = $_POST["id_gazoil"];
        $update = $this->db->query("UPDATE gazoil set id_operation=".$id_operation.",id_fournisseur=".$id_fournisseur.",code_camion='".$codeCamion."',numero = '".$numero."',date_gazoil = CAST('". $date."' AS DATE), litrage = ".$litrage.", id_distance = ".$destination.", kilometrage = ".$kilometrage.",prix_unitaire = ".$prixUnitaire.", commentaire ='".$commentaire."', bl = '".$numero."' where id_gazoil=".$id_gazoil."");

    if ($update == true) {
        # code...
        echo "Modification parfaite de la dépense";
        $this->updateKilometrage($codeCamion,$kilometrage);
        $this->notificationAjout($nom_table,addslashes($message2));
    }else{
        echo "Erreur de la modification";
    }
            }else{
    echo "Ce numéro est déjà utilisé veuillez saisir un autre";
            }
        }
    }else{
     
        $update = $this->db->query("UPDATE gazoil set id_operation=".$id_operation.",id_fournisseur=".$id_fournisseur.",code_camion='".$codeCamion."',numero = '".$numero."',date_gazoil = CAST('". $date."' AS DATE), litrage = ".$litrage.",id_distance = ".$destination.", kilometrage = ".$kilometrage.",prix_unitaire = ".$prixUnitaire.", commentaire ='".$commentaire."',bl = '".$numero."' where id_gazoil=".$id_gazoil."");

    if ($update == true) {
        # code...
        echo "Modification parfaite de la dépense";
        $this->updateKilometrage($codeCamion,$kilometrage);
        $this->notificationAjout($nom_table,addslashes($message2));
    }else{
        echo "Erreur de la modification";
    }
    }
// }
// }
    }


    
 }else{
    echo "Erreur veuillez contacter l'administrateur";
 }


 $this->db->close();
}

    public function leSelectFournisseurGazoil(){
        $query = $this->db->query("select * from fournisseur_gazoil where id_fournisseur = 19 or id_fournisseur = 22 OR id_fournisseur = 20 OR id_fournisseur = 21 OR id_fournisseur = 24 ORDER BY nom")->result_array();
        if (count($query) >0) {
			
	
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_fournisseur"]."'>".$row["nom"]."</option>";
            }
        }else{

        }

        $this->db->close();
    }
	

	
	      public function leSelectFournisseurArticle(){
        $query = $this->db->query("select * from fournisseur_article  Order by nom")->result_array();
        if (count($query) >0) {
            # code...
       
            foreach ($query as $row) {
                # code...
            
                echo "<option value='".$row["id_fournisseur"]."'>".$row["nom"]."</option>";
            }
        }else{

        }

        $this->db->close();
    }
	
	
	   public function leSelectFournisseurPneu(){
        $query = $this->db->query("select * from fournisseur_article Order by nom")->result_array();
        if (count($query) >0) {
            # code...
       
            foreach ($query as $row) {
                # code...
            
                echo "<option value='".$row["id_fournisseur"]."'>".$row["nom"]."</option>";
            }
        }else{

        }

        $this->db->close();
    }
	
	
	
	
	    public function leSelectFournisseurHuile(){
        $query = $this->db->query("select * from fournisseur_article where id_fournisseur = 22 or id_fournisseur = 32 or id_fournisseur = 28 or id_fournisseur = 31 or id_fournisseur = 34 or id_fournisseur = 52 or id_fournisseur = 65 order by nom")->result_array();
        if (count($query) >0) {
            # code...
       
            foreach ($query as $row) {
                # code...
            
                echo "<option value='".$row["id_fournisseur"]."'>".$row["nom"]."</option>";
            }
        }else{

        }

        $this->db->close();
    }

    public function getLittrage(){
        $id_distance = $_POST["destination"];

        $query = $this->db->query("SELECT * from distance_littrage where id_distance =".$id_distance." limit 1")->row();

        if (count($query)>0) {
            # code...
            echo $query->littrage;
        }

        $this->db->close();
    }

    public function getPrixUnitaireParFournisseur(){
         $id_distance = $_POST["id_fournisseur"];

        $query = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur =".$id_distance." limit 1")->row();

        if (count($query)>0) {
            # code...
            echo $query->PU;
        }

        $this->db->close();
    }

    public function getDistanceParCodeCamion(){
        $code_camion = $_POST["code_camion"];
         $query = $this->db->query("SELECT * from tracteur where code='".$code_camion."'")->row();
echo "<option value=''></option>";
         $query1 = $this->db->query("SELECT * from camion_benne where code='".$code_camion."' limit 1")->row();
         $query2 = $this->db->query("SELECT * from engin where code='".$code_camion."' limit 1")->row();
         $query4 = $this->db->query("SELECT * from vraquier where code='".$code_camion."' limit 1")->row();
        if (count($query) >0) {
            # code... 
            $getDistance = $this->db->query("SELECT * from distance_littrage where id_type_camion=".$query->id_type_camion." order by distance asc")->result_array();
            if (count($getDistance)>0) {
                # code...
                foreach ($getDistance as $row) {
                    # code...
                    echo "<option value='".$row["id_distance"]."'>".$row["distance"]."</option>";
                }
            }else{
                    // echo "<option value='0'>Aucune</option>";
                }
        }elseif (count($query1)>0) {
            # code...
             # code...
            $getDistance = $this->db->query("SELECT * from distance_littrage where id_type_camion=".$query1->id_type_camion." order by distance asc")->result_array();
            if (count($getDistance)>0) {
                # code...
                foreach ($getDistance as $row) {
                    # code...
                    echo "<option value='".$row["id_distance"]."'>".$row["distance"]."</option>";
                }
            }else{
                    // echo "<option value='0'>Aucune</option>";
                }
        }elseif (count($query2)>0) {
            # code...
             # code...
            $getDistance = $this->db->query("SELECT * from distance_littrage where id_type_camion=".$query2->id_type_camion." order by distance asc")->result_array();
            if (count($getDistance)>0) {
                # code...
                foreach ($getDistance as $row) {
                    # code...
                    echo "<option value='".$row["id_distance"]."'>".$row["distance"]."</option>";
                }
            }else{
                    // echo "<option value='0'>Aucune</option>";
                }
        }elseif (count($query4)>0) {
            # code...
             # code...
            $getDistance = $this->db->query("SELECT * from distance_littrage where id_type_camion=".$query4->id_type_camion." order by distance asc")->result_array();
            if (count($getDistance)>0) {
                # code...
                foreach ($getDistance as $row) {
                    # code...
                    echo "<option value='".$row["id_distance"]."'>".$row["distance"]."</option>";
                }
            }else{
                    // echo "<option value='0'>Aucune</option>";
                }
        } else{
                    // echo "<option value='0'>Aucune</option>";
             
            $query3 = $this->db->query("SELECT * from voitureservice where code='".$code_camion."' limit 1")->row();

            $getDistance = $this->db->query("SELECT * from distance_littrage where id_type_camion=".$query3->id_type_camion." order by distance asc")->result_array();
            if (count($getDistance)>0) {
                # code...
                foreach ($getDistance as $row) {
                    # code...
                    echo "<option value='".$row["id_distance"]."'>".$row["distance"]."</option>";
                }
            }else{
                    // echo "<option value='0'>Aucune</option>";
                }

        }

        $this->db->close();
    }
	
	public function getDistanceParCodeCamion1(){
        $camion1 = $_POST["camion1"];
         $query = $this->db->query("SELECT * from tracteur where code='".$camion1."'")->row();
        
         $query1 = $this->db->query("SELECT * from camion_benne where code='".$camion1."' limit 1")->row();
		 
        echo "<option value='4'>AUCUNE</option>";
		
        if (count($query) >0) {
            # code... 
            $getDistance = $this->db->query("SELECT * from distance_littrage where id_type_camion=".$query->id_type_camion." order by distance asc")->result_array();
            if (count($getDistance)>0) {
                # code...
                foreach ($getDistance as $row) {
                    # code...
                    echo "<option value='".$row["id_distance"]."'>".$row["distance"]."</option>";
                }
            }
        }elseif (count($query1)>0) {
            # code...
             # code...
            $getDistance = $this->db->query("SELECT * from distance_littrage where id_type_camion=".$query1->id_type_camion." order by distance asc")->result_array();
            if (count($getDistance)>0) {
                # code...
                foreach ($getDistance as $row) {
                    # code...
                    echo "<option value='".$row["id_distance"]."'>".$row["distance"]."</option>";
                }
            
        }
 
        }
		$this->db->close();

    }
	
	public function getLitrageCamion1(){
		
        $typeA = $_POST["typeA"];
		
		$destinationM = $_POST["destinationM"];
		
         $query = $this->db->query("SELECT * from distance_littrage where id_distance=".$destinationM." and id_type_camion=".$typeA."")->row();
        
		
        if (count($query) >0) {
            # code... 
            
                echo  $query->littrage ;
               
           
        }
		
		$this->db->close();

    }
	
	
		public function getLitrageCamion2(){
		
        $typeA = $_POST["typeA"];
		
		$destination1 = $_POST["destination1"];
		
         $query = $this->db->query("SELECT * from distance_littrage where id_distance=".$destination1." and id_type_camion=".$typeA."")->row();
        
		
        if (count($query) >0) {
            # code... 
            
                echo  $query->littrage ;
               
           
        }
		
		$this->db->close();

    }
	
		public function getBLDatabase(){
		
        $bl = $_POST["bl"];
		
		
		
         $query = $this->db->query("SELECT * from demande_frais where bl ='".$bl."'")->row();
        
		
        if (count($query) >0) {
            # code... 
            
                echo  $query->bl ;
          
        }
			
		
		$this->db->close();

    }
	
	public function getBLTDatabase(){
		
        $camion1 = $_POST["camion1"];
		
				
         $query = $this->db->query("SELECT SUM(tour) AS Tour from demande_navette where code_camion ='".$camion1."'")->row();
		 
		  $query2 = $this->db->query("SELECT MIN(date_dem) AS DATE_NAV from demande_navette where code_camion ='".$camion1."'")->row();
        
		// $query1 = $this->db->query("SELECT COUNT(*) AS Nbre from bon_livraison1 where code_camion ='".$camion1."' AND id_operation IN (SELECT operation FROM demande_navette)")->row();
         
		 $query1 = $this->db->query("SELECT COUNT(*) AS Nbre from bon_livraison1 where code_camion ='".$camion1."' AND date_bl >= '".$query2->DATE_NAV."'")->row();
         
        if ($query->Tour <= $query1->Nbre) {
			
		
                echo  1 ;
          
        }else {
			
			 echo  0 ;
			
		}
			
		
		$this->db->close();

    }
	
		public function getFraisRoute1(){
		
        $typeA = $_POST["typeA"];
		
		$destinationM = $_POST["destinationM"];
		
         $query = $this->db->query("SELECT * from distance_littrage where id_distance=".$destinationM." and id_type_camion=".$typeA."")->row();
        
		
        if (count($query) >0) {
            # code... 
            
                echo  $query->kilometrage ;
               
           
        }
		
		$this->db->close();

    }
	
		public function getFraisRetour1(){
		
        $typeA = $_POST["typeA"];
		
		$destinationM = $_POST["destinationM"];
		
         $query = $this->db->query("SELECT * from distance_littrage where id_distance=".$destinationM." and id_type_camion=".$typeA."")->row();
        
		
        if (count($query) >0) {
     
                echo  0 ;
           
        }
		
		$this->db->close();

    }



    public function leSelectCodeCamion(){
		
        $query = $this->db->query("SELECT * from tracteur order by code asc")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["code"]."' id_type = '".$row["id_type_camion"]."'>".$row["code"]."</option>";
            }
        }else{
            
        }
        $query1 = $this->db->query("SELECT * from camion_benne order by code asc")->result_array();
        if (count($query1) >0) {
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
         $query1 = $this->db->query("SELECT * from engin order by code asc")->result_array();
        if (count($query1) >0) {
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
        
         $query1 = $this->db->query("SELECT * from vraquier order by code asc")->result_array();
        if (count($query1) >0) {
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
        $query1 = $this->db->query("SELECT * from voitureservice order by code asc")->result_array();
        if (count($query1) >0) {
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }

        $this->db->close();
    }
	
	
	 public function leSelectEtatCodeCamion(){
		
        $query = $this->db->query("SELECT * from tracteur where rj = 'NON' order by code asc")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["code"]."' id_type = '".$row["id_type_camion"]."'>".$row["code"]."</option>";
            }
        }else{
            
        }
        $query1 = $this->db->query("SELECT * from camion_benne where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
         $query1 = $this->db->query("SELECT * from engin where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
        
         $query1 = $this->db->query("SELECT * from vraquier where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
        $query1 = $this->db->query("SELECT * from voitureservice where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }

        $this->db->close();
    }
	
	 public function leSelectEtatCodeEngin(){
		
       
         $query1 = $this->db->query("SELECT * from engin where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
       

        $this->db->close();
    }
	
	public function leSelectCodeCamion1(){
		
		 $delegue = $_POST["delegue"];
		 
		 echo "<option value=''></option>";
		
        $query = $this->db->query("SELECT * from tracteur where delegue = '".$delegue."' and rj= 'NON' order by code asc")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["code"]."' id_type = '".$row["id_type_camion"]."'>".$row["code"]."</option>";
            }
        }else{
            
        }
        $query1 = $this->db->query("SELECT * from camion_benne where delegue = '".$delegue."' and rj= 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row1["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
        
        $this->db->close();
    }
	
	
	   public function leSelectDelegueCamion(){
		
        $query = $this->db->query("SELECT Distinct delegue from tracteur group by delegue asc")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["delegue"]."'>".$row["delegue"]."</option>";
            }
        }
        $query1 = $this->db->query("SELECT Distinct delegue from camion_benne group by delegue asc")->result_array();
        if (count($query1) >0) {
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["delegue"]."'>".$row1["delegue"]."</option>";
            }
        }
      

        $this->db->close();
    }
	
	public function leSelectDelegueCamionN(){
		
		
		 $query = $this->db->query("SELECT Distinct delegue from tracteur group by delegue asc")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["delegue"]."'>".$row["delegue"]."</option>";
            }
        }
       
        $query1 = $this->db->query("SELECT Distinct delegue from camion_benne group by delegue asc")->result_array();
        if (count($query1) >0) {
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["delegue"]."'>".$row1["delegue"]."</option>";
            }
        }
      

        $this->db->close();
    }
	
	public function leSelectImmatCamion(){
        $query = $this->db->query("SELECT * from tracteur where rj = 'NON' order by code asc")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["immatriculation"]."' id_type = '".$row["id_type_camion"]."'>".$row["immatriculation"]."</option>";
            }
        }else{
            
        }
		
	
		
        $query1 = $this->db->query("SELECT * from camion_benne where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["immatriculation"]."' id_type = '".$row["id_type_camion"]."'>".$row1["immatriculation"]."</option>";
            }
        }else{
            
        }
         $query1 = $this->db->query("SELECT * from engin where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["immatriculation"]."' id_type = '".$row["id_type_camion"]."'>".$row1["immatriculation"]."</option>";
            }
        }else{
            
        }
        
         $query1 = $this->db->query("SELECT * from vraquier where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["immatriculation"]."' id_type = '".$row["id_type_camion"]."'>".$row1["immatriculation"]."</option>";
            }
        }else{
            
        }
        $query1 = $this->db->query("SELECT * from voitureservice where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["immatriculation"]."' id_type = '".$row["id_type_camion"]."'>".$row1["immatriculation"]."</option>";
            }
        }else{
            
        }

        $this->db->close();
    }
	
	public function leSelectImmatCamion1(){
        $query = $this->db->query("SELECT * from tracteur where rj = 'NON' order by code asc")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["immatriculation"]."' >".$row["immatriculation"]."</option>";
            }
        }else{
            
        }
		
		   $query = $this->db->query("SELECT * from remorque where rj = 'NON' order by immatriculation asc")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["immatriculation"]."' >".$row["immatriculation"]."</option>";
            }
        }else{
            
        }
		
        $query1 = $this->db->query("SELECT * from camion_benne where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["immatriculation"]."' >".$row1["immatriculation"]."</option>";
            }
        }else{
            
        }
         $query1 = $this->db->query("SELECT * from engin where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["immatriculation"]."' >".$row1["immatriculation"]."</option>";
            }
        }else{
            
        }
        
         $query1 = $this->db->query("SELECT * from vraquier where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["immatriculation"]."' >".$row1["immatriculation"]."</option>";
            }
        }else{
            
        }
        $query1 = $this->db->query("SELECT * from voitureservice where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["immatriculation"]."' >".$row1["immatriculation"]."</option>";
            }
        }else{
            
        }

        $this->db->close();
    }



    public function leSelectOperation(){
        $query = $this->db->query("SELECT * from operation ORDER BY date_creation desc")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_operation"]."'>".$row["nom_op"]."</option>";
            }
        }else{

        }

        $this->db->close();
    }
	
	    public function leSelectOperation1(){
        $query = $this->db->query("SELECT * from operation WHERE filiale = 'MIRA CIMENTERIE' ORDER BY date_creation desc")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_operation"]."'>".$row["nom_op"]."</option>";
            }
        }else{

        }

        $this->db->close();
    }
	
	    public function leSelectOperationNavette(){
        $query = $this->db->query("SELECT * from operation WHERE  nom_op LIKE '%NAVETTE%' OR  nom_op LIKE '%DEBARQUEMENT%' ORDER BY date_creation desc")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_operation"]."'>".$row["nom_op"]."</option>";
            }
        }else{

        }

        $this->db->close();
    }
	
	    public function leSelectOperationEngin(){
        $query = $this->db->query("SELECT * from operation WHERE id_operation = 91")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_operation"]."'>".$row["nom_op"]."</option>";
            }
        }else{

        }

        $this->db->close();
    }

public function getFournisseurPourModifGazoil(){
    $id_fournisseur = $_POST['id_fournisseur'];

    $query1 = $this->db->query('SELECT * from fournisseur_gazoil ')->result_array();

    if (count($query1)>0) {
        # code...*
         $query2 = $this->db->query('SELECT * from fournisseur_gazoil where id_fournisseur ='.$id_fournisseur.'')->row();
        echo "<option value='".$query2->id_fournisseur."'>".$query2->nom."</option>";
        foreach ($query1 as $row) {
          
            echo "<option value='".$row["id_fournisseur"]."'>".$row["nom"]."</option>";
        }
    }

    $this->db->close();
}

public function getOperationPourModifGazoil(){
    $id_fournisseur = $_POST['id_operation'];

    $query1 = $this->db->query('SELECT * from operation ')->result_array();
   
    if (count($query1)>0) {
        # code...
         $query2 = $this->db->query('SELECT * from operation where id_operation ='.$id_fournisseur.'')->row();
        echo "<option value='".$query2->id_operation."'>".$query2->nom_op."</option>";
        foreach ($query1 as $row) {
            # code...
        
              echo "<option value='".$row["id_operation"]."'>".$row["nom_op"]."</option>";   
            
           
        }
    }

    $this->db->close();
}
public function getDestinationPourModifGazoil(){
    $id_distance = $_POST['id_distance'];

    $query2 = $this->db->query('SELECT * from distance_littrage where id_distance ='.$id_distance.'')->row();
        echo "<option value='".$query2->id_distance."'>".$query2->distance."</option>";
    $this->crud_model_depense->getDistanceParCodeCamion();

    $this->db->close();
}


public function getCodePourModifGazoil(){
    $id_fournisseur = $_POST['code_camion'];

        echo "<option value='".$id_fournisseur."'>".$id_fournisseur."</option>";
    $this->crud_model_depense->leSelectCodeCamion();

    $this->db->close();
}

public function addMarque(){
        $marque =addslashes($_POST["marque"]);
        $commentaire = $_POST["commentaire"];
      
        $status = $_POST["status"];

    $nom_table = "marque_pneu";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté une marque pneu ".$marque." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié la marque ".$marque." le ".$date_notif." à ".$heure;

        if ($status =="insert") {
            # code...

                $requete = $this->db->query("SELECT * from marque_pneu where marque ='".$marque."'")->result_array();
                if (count($requete)>0) {
                    # code...
                    echo "Un même nom de marque existe déjà ";
                }else{
                    $query1 = $this->db->query("insert into marque_pneu value('','". $marque. "','". $commentaire."')");
                            if($query1 == true){
                                echo "Insertion parfaite de la marque";
                                $this->notificationAjout($nom_table,addslashes($message));
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                }
        }elseif ($status == "update") {
            # code...
			
            $id_client =$_POST["id_client"];
                $requete = $this->db->query("SELECT * from marque_pneu where marque ='".$marque."'")->result_array();
                if (count($requete)>0) {
                    # code...
                   foreach ($requete as $row) {
                       # code...
                        if ($row["id_type"] == $id_client) {
                            # code...
                            $query1 = $this->db->query("UPDATE marque_pneu set commentaire='".$commentaire."', marque='".$marque."' where id_marque_pneu=".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite de la marque";
                                $this->notificationAjout($nom_table,addslashes($message2));
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                        }else{
                            echo "Erreur cette marque existe dejà";
                        }
                   }
                }else{
                   $query1 = $this->db->query("UPDATE marque_pneu set commentaire='".$commentaire."', marque='".$marque."' where id_marque_pneu=".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite de la marque";
                                $this->notificationAjout($nom_table,addslashes($message2));
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                }
        }else{
            echo "Erreur contactez l'administrateur".$status ;
        }
        $this->db->close();
    }
	
	
	public function addTypePneu(){
        $nom_type =addslashes($_POST["nom_type"]);
        $commentaire = $_POST["commentaire"];
      
        $status = $_POST["status"];

    $nom_table = "type_pneu1";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté un type pneu ".$nom_type." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié le type ".$nom_type." le ".$date_notif." à ".$heure;

        if ($status =="insert") {
            # code...

                $requete = $this->db->query("SELECT * from type_pneu1 where nom_type ='".$nom_type."'")->result_array();
                if (count($requete)>0) {
                    # code...
                    echo "Un même nom de marque existe déjà ";
                }else{
                    $query1 = $this->db->query("insert into type_pneu1 value('','". $nom_type. "','". $commentaire."')");
                            if($query1 == true){
                                echo "Insertion parfaite de la marque";
                                $this->notificationAjout($nom_table,addslashes($message));
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                }
        }elseif ($status == "update") {
            # code...
             $id_client =$_POST["id_client"];
                $requete = $this->db->query("SELECT * from type_pneu1 where nom_type ='".$nom_type."'")->result_array();
                if (count($requete)>0) {
                    # code...
                   foreach ($requete as $row) {
                       # code...
                        if ($row["id_type_pneu"] == $id_client) {
                            # code...
                            $query1 = $this->db->query("UPDATE type_pneu1 set commentaire='".$commentaire."', nom_type='".$nom_type."' where id_type_pneu=".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du type";
                                $this->notificationAjout($nom_table,addslashes($message2));
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                        }else{
                            echo "Erreur ce type existe dejà";
                        }
                   }
                }else{
                   $query1 = $this->db->query("UPDATE type_pneu1 set commentaire='".$commentaire."', nom_type='".$nom_type."' where id_type_pneu=".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du type";
                                $this->notificationAjout($nom_table,addslashes($message2));
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                }
        }else{
            echo "Erreur contactez l'administrateur".$status ;
        }
        $this->db->close();
    }



    public function selectAllMarque(){
              $query1 = $this->db->query("SELECT * from marque_pneu")->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                   <td>".$row['marque']."</td>
                    <td> ".$row['commentaire']."</td>
                    <td>";
                if($this->session->userdata('pneu_modification')=='true'){
                    echo"
                    <button type='button' onclick=\"infosMarque('".$row['id_marque_pneu']."','".$row['marque']."','".$row['commentaire']."','')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }
                if($this->session->userdata('pneu_suppression')=='true'){
                    echo"
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='marque_pneu' identifiant='".$row['id_marque_pneu']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_marque_pneu\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
        }
        $this->db->close();
    }
	
	public function selectAllTypePneu(){
              $query1 = $this->db->query("SELECT * from type_pneu1")->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                   <td>".$row['nom_type']."</td>
                    <td> ".$row['commentaire']."</td>
                    <td>";
                if($this->session->userdata('pneu_modification')=='true'){
                    echo"
                    <button type='button' onclick=\"infosTypePneu('".$row['id_type_pneu']."','".$row['nom_type']."','".$row['commentaire']."','')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }
                if($this->session->userdata('pneu_suppression')=='true'){
                    echo"
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='type_pneu1' identifiant='".$row['id_type_pneu']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_type_pneu\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
        }
        $this->db->close();
    }

public function selectAllInventaireGazoil(){
	
        if (isset($_POST['date_debut']) && isset($_POST['date_fin'])) {
            # code...
            $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        }else{
            $date_debut = '';
        $date_fin = '';
        }
       if (empty($date_fin) && !empty($date_debut) ){

            $query = $this->db->query("select * from inventaireGazoil where date_inv='".$date_debut."' order by date_inv desc")->result_array();

        }if (!empty($date_fin) && !empty($date_debut)){

            $query = $this->db->query("SELECT * from inventaireGazoil where  date_inv between '".$date_debut."' and '".$date_fin."'  order by date_inv desc")->result_array();


        }elseif (!empty($date_fin) && empty($date_debut)){
            
             $query = $this->db->query("SELECT * from inventaireGazoil where date_inv ='".$date_fin."' order by date_inv desc")->result_array();

        }else{
            $query = $this->db->query("SELECT * from inventaireGazoil order by date_inv desc")->result_array();
        }

        

        if (count($query) >0 ) {
            # code...
            $compteur = 0;
        foreach ($query as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    ";
                    $getNomArticle = $this->db->query("SELECT * from article where article = 'GAZOIL'")->row();
					$four = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur=".$row['id_fournisseur']." ")->row();
                    if (count($four)>0) {
                        # code...
                        $four = $four->nom;
                    }else{
                        $four ="";
                    }
                    echo"
                    <td>".$getNomArticle->code_a_barre."</td>
                    <td>".$getNomArticle->article."</td>
                    <td>".$getNomArticle->prix_unitaire."</td>
                    </td>";
                    $getCategorie = $this->db->query('SELECT * FROM categorie_article where id_categorie='.$getNomArticle->id_categorie.'')->row();
                    echo"<td>".$getCategorie->categorie."</td> ";
                    
                    echo"
                    <td>".$row['auteur']."</td>
                    <td> ".$row['date_inv']."</td>
                    <td> ".$row['qtite']."</td>
					 <td> ".$four."</td>
                    <td>";
                 if($this->session->userdata('stock_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='inventaireGazoil' identifiant='".$row['id_inventaire']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_inventaire\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                }
                  $compteur++;
            }
        }

        $this->db->close();
    }

public function selectAllInventaireHuile(){
	
        if (isset($_POST['date_debut']) && isset($_POST['date_fin'])) {
            # code...
            $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        }else{
            $date_debut = '';
        $date_fin = '';
        }
       if (empty($date_fin) && !empty($date_debut) ){

            $query = $this->db->query("select * from inventaireHuile where date_inv='".$date_debut."' order by date_inv desc")->result_array();

        }if (!empty($date_fin) && !empty($date_debut)){

            $query = $this->db->query("SELECT * from inventaireHuile where  date_inv between '".$date_debut."' and '".$date_fin."'  order by date_inv desc")->result_array();


        }elseif (!empty($date_fin) && empty($date_debut)){
            
             $query = $this->db->query("SELECT * from inventaireHuile where date_inv ='".$date_fin."' order by date_inv desc")->result_array();

        }else{
            $query = $this->db->query("SELECT * from inventaireHuile order by date_inv desc")->result_array();
        }

        

        if (count($query) >0 ) {
            # code...
            $compteur = 0;
        foreach ($query as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    ";
                    $getNomArticle = $this->db->query("SELECT * from type_huile where id_type=".$row['id_article']." ")->row();
					$four = $this->db->query("SELECT * from fournisseur_article where id_fournisseur=".$row['id_fournisseur']." ")->row();
                    if (count($four)>0) {
                        # code...
                        $four = $four->nom;
                    }else{
                        $four ="";
                    }
                    echo"
                    <td>".$getNomArticle->type_huile."</td>
                    <td>".$getNomArticle->huile."</td>
                    <td>".$getNomArticle->PU."</td>         
                    <td>".$row['auteur']."</td>
                    <td> ".$row['date_inv']."</td>
                    <td> ".$row['qtite']."</td>
					 <td> ".$four."</td>
                    <td>";
                 if($this->session->userdata('stock_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='inventaireHuile' identifiant='".$row['id_inventaire']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_inventaire\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                }
                  $compteur++;
            }
        }

        $this->db->close();
    }


public function selectAllInventairePneu(){
	
        if (isset($_POST['date_debut']) && isset($_POST['date_fin'])) {
            # code...
            $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        }else{
            $date_debut = '';
        $date_fin = '';
        }
       if (empty($date_fin) && !empty($date_debut) ){

            $query = $this->db->query("select * from inventairepneu where date_inv='".$date_debut."' order by date_inv desc")->result_array();

        }if (!empty($date_fin) && !empty($date_debut)){

            $query = $this->db->query("SELECT * from inventairepneu where  date_inv between '".$date_debut."' and '".$date_fin."'  order by date_inv desc")->result_array();


        }elseif (!empty($date_fin) && empty($date_debut)){
            
             $query = $this->db->query("SELECT * from inventairepneu where date_inv ='".$date_fin."' order by date_inv desc")->result_array();

        }else{
            $query = $this->db->query("SELECT * from inventairepneu order by date_inv desc")->result_array();
        }

        

        if (count($query) >0 ) {
            # code...
            $compteur = 0;
        foreach ($query as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    ";
                    $getNomArticle = $this->db->query("SELECT * from type_pneu where id_type_pneu=".$row['id_article']." ")->row();
					$four = $this->db->query("SELECT * from fournisseur_article where id_fournisseur=".$row['id_fournisseur']." ")->row();
                    if (count($four)>0) {
                        # code...
                        $four = $four->nom;
                    }else{
                        $four ="";
                    }
                    echo"
                    <td>".$getNomArticle->nom_type."</td>
                    
                         
                    <td>".$row['auteur']."</td>
                    <td> ".$row['date_inv']."</td>
                    <td> ".$row['qtite']."</td>
					 <td> ".$four."</td>
                    <td>";
                 if($this->session->userdata('stock_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='inventairepneu' identifiant='".$row['id_inventaire']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_inventaire\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                }
                  $compteur++;
            }
        }

        $this->db->close();
    }


 public function leSelectArticlePourInventaireGazoil(){
        $getArticle = $this->db->query("SELECT * from article where article = 'GAZOIL'")->result_array();
        echo ' <tr class="formAddInventaire">
                                  <td>
                                    <select class="article form-control" onchange ="getReferenceArticleGazoil()">';
        if (count($getArticle)>0) {
            # code...
			echo "<option value=''></option>";
            foreach ($getArticle as $row) {
                # code...

                echo "<option value = '".$row['id_article']."' article='".$row['article']."'>".$row['article']."</option>";
            }
        }
        echo '  
                    </select>
                                  </td>
                                  <td><input type="text" placeholder ="Reférence" class="form-control reference" disabled = "False" onkeypress="chiffres(event);"></td>
                                  <td>
                                        <div class="input-group input-group-sm">
                                        <input type="text" class="form-control qtite" onkeypress="chiffres(event);">
                                        <span class="input-group-append">
                                          <button type="button" class="btn btn-info btn-flat" onclick="addInventaireGazoil();">
                                            <img src="'.base_url().'assets/image/envoi.jpg" style="height: 25px; width: 25px; border-radius: 20px;">
                                          </button>
                                        </span>
                                      </div>
                                  </td>
                                </tr>';

                            $this->db->close();
    }
	
	public function leSelectArticlePourInventairePneu(){
        $getArticle = $this->db->query("SELECT * from type_pneu order by nom_type")->result_array();
        echo ' <tr class="formAddInventaire">
                                  <td>
                                    <select class="article form-control" onchange ="">';
        if (count($getArticle)>0) {
            # code...
			echo "<option value=''></option>";
            foreach ($getArticle as $row) {
                # code...

                echo "<option value = '".$row['id_type_pneu']."' nom_type='".$row['nom_type']."'>".$row['nom_type']."</option>";
            }
        }
        echo '  
                    </select>
                                  </td>
                                  <td><input type="text" placeholder ="Reférence" class="form-control reference" disabled = "False" onkeypress="chiffres(event);"></td>
                                  <td>
                                        <div class="input-group input-group-sm">
                                        <input type="text" class="form-control qtite" onkeypress="chiffres(event);">
                                        <span class="input-group-append">
                                          <button type="button" class="btn btn-info btn-flat" onclick="A();">
                                            <img src="'.base_url().'assets/image/envoi.jpg" style="height: 25px; width: 25px; border-radius: 20px;">
                                          </button>
                                        </span>
                                      </div>
                                  </td>
                                </tr>';

                            $this->db->close();
    }
	
	public function leSelectArticlePourInventaireHuile(){
        $getArticle = $this->db->query("SELECT * from type_huile order by type_huile")->result_array();
        echo ' <tr class="formAddInventaire">
                                  <td>
                                    <select class="article form-control" onchange ="getReferenceArticleHuile()">';
        if (count($getArticle)>0) {
            # code...
			echo "<option value=''></option>";
            foreach ($getArticle as $row) {
                # code...

                echo "<option value = '".$row['id_type']."' article='".$row['huile']."'>".$row['huile']."</option>";
            }
        }
        echo '  
                    </select>
                                  </td>
                                  <td><input type="text" placeholder ="Reférence" class="form-control reference" disabled = "False" onkeypress="chiffres(event);"></td>
                                  <td>
                                        <div class="input-group input-group-sm">
                                        <input type="text" class="form-control qtite" onkeypress="chiffres(event);">
                                        <span class="input-group-append">
                                          <button type="button" class="btn btn-info btn-flat" onclick="addInventaireHuile();">
                                            <img src="'.base_url().'assets/image/envoi.jpg" style="height: 25px; width: 25px; border-radius: 20px;">
                                          </button>
                                        </span>
                                      </div>
                                  </td>
                                </tr>';

                            $this->db->close();
    }
	
	

 public function getDateDernierInventaireGazoil(){
       $query = $this->db->query("SELECT * from inventaireGazoil order by date_inv desc limit 1")->row();
       
      
       if (count($query)>0) {
           # code...
         return $query->date_inv;
       }

       $this->db->close();
          }	
		  
 public function getDateDernierInventaireHuile(){
       $query = $this->db->query("SELECT * from inventaireHuile order by date_inv desc limit 1")->row();
       
      
       if (count($query)>0) {
           # code...
         return $query->date_inv;
       }

       $this->db->close();
          }	
	
	public function getDateDernierInventairePneu(){
       $query = $this->db->query("SELECT * from inventairepneu order by date_inv desc limit 1")->row();
       
      
       if (count($query)>0) {
           # code...
         return $query->date_inv;
       }

       $this->db->close();
          }	
	
	public function addInventaireGazoil(){
        $id_article = $_POST["article"];
        $qtite = $_POST["qtite"];
        $date = $_POST["date_inv"];
        $auteur = $_POST["auteur"];
		$id_fournisseur = $_POST["id_fournisseur"];
        
$aujourdhui = date("Y/m/d");
        $dateLimit = date("Y/m/d");
        $dateEntree = date("Y/m/d");


        $nom_table = "inventairegazoil";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." a fait un inventaire sur l'article: ".$this->getArticle($id_article)." d'une quantité de ".$qtite." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié un inventaire sur l'article: ".$this->getArticle($id_article)." d'une quantité de ".$qtite." le ".$date_notif." à ".$heure;


        // on va vérivier la si la date de la pécédente insertion est supérieure ou égale à celle d'aujourd'hui
        $getArticle = $this->db->query(" select * from inventairegazoil order by id_inventaire desc limit 1")->row();
        if (count($getArticle)>0) {
            # code...
            $dateLimit = date("Y/m/d",strtotime($getArticle->date_inv));
       $dateEntree = date("Y/m/d",strtotime($date));
        }

       if ($dateEntree < $dateLimit) {
           # code...
            echo "La date d'insertion doit être supérieure ou égale à celle du dernier inventaire"; 
       }else{


        $addInventaire = $this->db->query("INSERT into inventairegazoil value('',".$id_article.",'".$auteur."',CAST('". $date."' AS DATE),".$qtite.",".$id_fournisseur.")");
        if ($addInventaire == true) {
            # code...
            echo "ok";
            $this->notificationAjout($nom_table,addslashes($message));
        }else{
            echo "Erreur d'insertion contactez l'administrateur";
        }
    }

    $this->db->close();
    }
	
	
	public function addInventaireHuile(){
        $id_article = $_POST["article"];
        $qtite = $_POST["qtite"];
        $date = $_POST["date_inv"];
        $auteur = $_POST["auteur"];
		$id_fournisseur = $_POST["id_fournisseur"];
        
$aujourdhui = date("Y/m/d");
        $dateLimit = date("Y/m/d");
        $dateEntree = date("Y/m/d");


        $nom_table = "inventairehuile";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." a fait un inventaire sur l'article: ".$this->getArticle($id_article)." d'une quantité de ".$qtite." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié un inventaire sur l'article: ".$this->getArticle($id_article)." d'une quantité de ".$qtite." le ".$date_notif." à ".$heure;


        // on va vérivier la si la date de la pécédente insertion est supérieure ou égale à celle d'aujourd'hui
        $getArticle = $this->db->query(" select * from inventairehuile order by id_inventaire desc limit 1")->row();
        if (count($getArticle)>0) {
            # code...
            $dateLimit = date("Y/m/d",strtotime($getArticle->date_inv));
       $dateEntree = date("Y/m/d",strtotime($date));
        }

       if ($dateEntree < $dateLimit) {
           # code...
            echo "La date d'insertion doit être supérieure ou égale à celle du dernier inventaire"; 
       }else{


        $addInventaire = $this->db->query("INSERT into inventairehuile value('',".$id_article.",'".$auteur."',CAST('". $date."' AS DATE),".$qtite.",".$id_fournisseur.")");
        if ($addInventaire == true) {
            # code...
            echo "ok";
            $this->notificationAjout($nom_table,addslashes($message));
        }else{
            echo "Erreur d'insertion contactez l'administrateur";
        }
    }

    $this->db->close();
    }

public function addInventairePneu(){
	
        $id_article = $_POST["article"];
        $qtite = $_POST["qtite"];
        $date = $_POST["date_inv"];
        $auteur = $_POST["auteur"];
		$id_fournisseur = $_POST["id_fournisseur"];
        
		$aujourdhui = date("Y/m/d");
        $dateLimit = date("Y/m/d");
        $dateEntree = date("Y/m/d");


        $nom_table = "inventairepneu";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." a fait un inventaire sur l'article: ".$this->getArticle($id_article)." d'une quantité de ".$qtite." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié un inventaire sur l'article: ".$this->getArticle($id_article)." d'une quantité de ".$qtite." le ".$date_notif." à ".$heure;


        // on va vérivier la si la date de la pécédente insertion est supérieure ou égale à celle d'aujourd'hui
        $getArticle = $this->db->query(" select * from inventairepneu order by id_inventaire desc limit 1")->row();
        if (count($getArticle)>0) {
            # code...
            $dateLimit = date("Y/m/d",strtotime($getArticle->date_inv));
       $dateEntree = date("Y/m/d",strtotime($date));
        }

       if ($dateEntree < $dateLimit) {
           # code...
            echo "La date d'insertion doit être supérieure ou égale à celle du dernier inventaire"; 
       }else{


        $addInventaire = $this->db->query("INSERT into inventairepneu value('',".$id_article.",'".$auteur."',CAST('". $date."' AS DATE),".$qtite.",".$id_fournisseur.")");
        if ($addInventaire == true) {
            # code...
            echo "ok";
            $this->notificationAjout($nom_table,addslashes($message));
        }else{
            echo "Erreur d'insertion contactez l'administrateur";
        }
    }

    $this->db->close();
    }

   
 public function leSelectArticlePourApprovisionnementGazoil(){
        $getArticle = $this->db->query("SELECT * from article where article = 'GAZOIL'")->result_array();
        echo ' <tr class="formAddInventaire">
                                  <td>
                                    <select class="article form-control" onchange ="getReferenceArticleGazoil(); getPrixUnitaireArticleGazoil();">';
        if (count($getArticle)>0) {
            # code...
		echo "<option value=''></option>";

            foreach ($getArticle as $row) {
                # code...

                echo "<option value = '".$row['id_article']."' article='".$row['article']."'>".$row['article']."</option>";
            }
        }
        echo '  </select>
                                  </td>

                                  <td><input type="text" placeholder ="Reférence" disabled = "False" class="form-control reference" ></td>
                                  
                                  
                                  <td><input type="text" placeholder ="Montant" class="form-control montant" onkeypress="chiffres(event);"></td>
                                  
                                  <td>
                                        <div class="input-group input-group-sm">
                                        <input type="text" class="form-control qtite" onkeypress="chiffres(event);">
                                        <span class="input-group-append">
                                          <button type="button" class="btn btn-info btn-flat" onclick="addApprovisionnementGazoil();">
                                            <img src="'.base_url().'assets/image/envoi.jpg" style="height: 25px; width: 25px; border-radius: 20px;">
                                          </button>
                                        </span>
                                      </div>
                                  </td>
                                </tr>';


                        $this->db->close();
    }
	
	public function leSelectArticlePourApprovisionnementHuile(){
		
        $getArticle = $this->db->query("SELECT * from type_huile Order BY huile")->result_array();
        echo ' <tr class="formAddInventaire">
                                  <td>
                                    <select class="article form-control" onchange ="getReferenceArticleHuile(); getPrixUnitaireArticleHuile();">';
        if (count($getArticle)>0) {
            # code...
		echo "<option value=''></option>";

            foreach ($getArticle as $row) {
                # code...

                echo "<option value = '".$row['id_type']."' article='".$row['huile']."'>".$row['huile']."</option>";
            }
        }
        echo '  </select>
                                  </td>

                                  <td><input type="text" placeholder ="Reférence" disabled = "False" class="form-control reference" ></td>
                                  
                                  
                                  <td><input type="text" placeholder ="Montant" class="form-control montant" onkeypress="chiffres(event);"></td>
                                  
                                  <td>
                                        <div class="input-group input-group-sm">
                                        <input type="text" class="form-control qtite" onkeypress="chiffres(event);">
                                        <span class="input-group-append">
                                          <button type="button" class="btn btn-info btn-flat" onclick="addApprovisionnementHuile();">
                                            <img src="'.base_url().'assets/image/envoi.jpg" style="height: 25px; width: 25px; border-radius: 20px;">
                                          </button>
                                        </span>
                                      </div>
                                  </td>
                                </tr>';


                        $this->db->close();
    }
	
	
	public function leSelectArticlePourApprovisionnementPneu(){
		
        $getArticle = $this->db->query("SELECT * from type_pneu Order BY nom_type")->result_array();
		$getType = $this->db->query("SELECT * from type_pneu1 Order BY nom_type")->result_array();
		$getMarque = $this->db->query("SELECT * from marque_pneu Order BY marque")->result_array();
		
        echo ' <tr class="formAddInventaire">
                                  
								   <td>
                                    <select class="type form-control" onchange ="">';
        if (count($getType)>0) {
            # code...
		echo "<option value=''></option>";

            foreach ($getType as $row) {
                # code...

                echo "<option value = '".$row['id_type_pneu']."' taille='".$row['nom_type']."'>".$row['nom_type']."</option>";
            }
        }
        echo '  </select>
                                  </td>
								  
								   <td>
                                    <select class="marque form-control" onchange ="">';
        if (count($getMarque)>0) {
            # code...
		echo "<option value=''></option>";

            foreach ($getMarque as $row) {
                # code...

                echo "<option value = '".$row['id_marque_pneu']."' marque='".$row['marque']."'>".$row['marque']."</option>";
            }
        }
        echo '  </select>
                                  </td>
								  
								  <td>
                                    <select class="article form-control" onchange ="">';
        if (count($getArticle)>0) {
            # code...
		echo "<option value=''></option>";

            foreach ($getArticle as $row) {
                # code...

                echo "<option value = '".$row['id_type_pneu']."' article='".$row['nom_type']."'>".$row['nom_type']."</option>";
            }
        }
        echo '  </select>
                                  </td>

                                  <td><input type="text" placeholder ="Reférence" class="form-control reference" ></td>
                                  
                                  
                                  <td><input type="text" placeholder ="Montant" class="form-control montant"  onkeypress="chiffres(event);" ></td>
                                  
                                  <td>
                                        <div class="input-group input-group-sm">
                                        <input type="text" class="form-control qtite" value = "1" disabled = "true" onkeypress="chiffres(event);">
                                        <span class="input-group-append">
                                          <button type="button" class="btn btn-info btn-flat" onclick="addApprovisionnementPneu();">
                                            <img src="'.base_url().'assets/image/envoi.jpg" style="height: 25px; width: 25px; border-radius: 20px;">
                                          </button>
                                        </span>
                                      </div>
                                  </td>
                                </tr>';


                        $this->db->close();
    }


    public function addApprovisionnementHuile(){
        $id_article = $_POST["article"];
        $qtite = $_POST["qtite"];
        $date = $_POST["date_inv"];
        $auteur = $_POST["auteur"];
        $reference = $_POST["reference"];
        $montant = $_POST["montant"];
        $bl = $_POST["bl"];
        $id_fournisseur = $_POST["id_fournisseur"];

        $aujourdhui = date("Y/m/d");
        $dateLimit = date("Y/m/d");
        $dateEntree = date("Y/m/d");

        $nom_table = "approvisionnementhuile";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." a fait un approvisionnement Huile sur l'article: ".$this->getArticle($id_article)." d'une quantité de ".$qtite." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié un approvisionnement Huile sur l'article: ".$this->getArticle($id_article)." d'une quantité de ".$qtite." le ".$date_notif." à ".$heure;
        // on va vérivier la si la date de la pécédente insertion est supérieure ou égale à celle d'aujourd'hui
        $getArticle = $this->db->query(" select * from inventairehuile order by id_inventaire desc limit 1")->row();
        if (count($getArticle)>0) {
            # code...
            $dateLimit = date("Y/m/d",strtotime($getArticle->date_inv));
       $dateEntree = date("Y/m/d",strtotime($date));
        }
       

       if ($dateEntree < $dateLimit) {
           # code...
            echo "La date d'insertion doit être supérieure ou égale à celle du dernier inventaire"; 
       }else{
  ////////////////A REMPLIR POUR FACTURE
        

        $addInventaire = $this->db->query("INSERT into approvisionnementhuile value('',".$id_article.",".$id_fournisseur.",'".$reference."','".$auteur."',CAST('". $date."' AS DATE),".$qtite.",".$montant.",'".$bl."')");
        if ($addInventaire == true) {
            # code...
            echo "ok";
            $this->notificationAjout($nom_table,addslashes($message));
        }else{
            echo "Erreur d'insertion contactez l'administrateur";
        }
    }

        $this->db->close();
    }
	
	 public function addApprovisionnementGazoil(){
        $id_article = $_POST["article"];
        $qtite = $_POST["qtite"];
        $date = $_POST["date_inv"];
        $auteur = $_POST["auteur"];
        $reference = $_POST["reference"];
        $montant = $_POST["montant"];
        $bl = $_POST["bl"];
        $id_fournisseur = $_POST["id_fournisseur"];

        $aujourdhui = date("Y/m/d");
        $dateLimit = date("Y/m/d");
        $dateEntree = date("Y/m/d");

        $nom_table = "approvisionnementhuile";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." a fait un approvisionnement Gazoil sur l'article: ".$this->getArticle($id_article)." d'une quantité de ".$qtite." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié un approvisionnement Gasoil sur l'article: ".$this->getArticle($id_article)." d'une quantité de ".$qtite." le ".$date_notif." à ".$heure;
        // on va vérivier la si la date de la pécédente insertion est supérieure ou égale à celle d'aujourd'hui
        $getArticle = $this->db->query(" select * from inventairegazoil order by id_inventaire desc limit 1")->row();
        if (count($getArticle)>0) {
            # code...
            $dateLimit = date("Y/m/d",strtotime($getArticle->date_inv));
       $dateEntree = date("Y/m/d",strtotime($date));
        }
       

       if ($dateEntree < $dateLimit) {
           # code...
            echo "La date d'insertion doit être supérieure ou égale à celle du dernier inventaire"; 
       }else{
  ////////////////A REMPLIR POUR FACTURE
        

        $addInventaire = $this->db->query("INSERT into approvisionnementgazoil value('',".$id_article.",".$id_fournisseur.",'".$reference."','".$auteur."',CAST('". $date."' AS DATE),".$qtite.",".$montant.",'".$bl."')");
        if ($addInventaire == true) {
            # code...
            echo "ok";
            $this->notificationAjout($nom_table,addslashes($message));
        }else{
            echo "Erreur d'insertion contactez l'administrateur";
        }
    }

        $this->db->close();
    }
	
	public function addApprovisionnementPneu(){
        $id_article = $_POST["article"];
        $qtite = $_POST["qtite"];
        $date = $_POST["date_inv"];
        $auteur = $_POST["auteur"];
        $reference = $_POST["reference"];
        $montant = $_POST["montant"];
        $bl = $_POST["bl"];
        $id_fournisseur = $_POST["id_fournisseur"];
		$marque = $_POST["marque"];
        $type = $_POST["type"];

        $aujourdhui = date("Y/m/d");
        $dateLimit = date("Y/m/d");
        $dateEntree = date("Y/m/d");

        $nom_table = "approvisionnementpneu";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." a fait un approvisionnement Pneu sur l'article: ".$this->getArticle($id_article)." d'une quantité de ".$qtite." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié un approvisionnement Pneu sur l'article: ".$this->getArticle($id_article)." d'une quantité de ".$qtite." le ".$date_notif." à ".$heure;
        // on va vérivier la si la date de la pécédente insertion est supérieure ou égale à celle d'aujourd'hui
        $getArticle = $this->db->query(" select * from inventairepneu order by id_inventaire desc limit 1")->row();
        if (count($getArticle)>0) {
            # code...
            $dateLimit = date("Y/m/d",strtotime($getArticle->date_inv));
       $dateEntree = date("Y/m/d",strtotime($date));
        }
       

       if ($dateEntree < $dateLimit) {
           # code...
            echo "La date d'insertion doit être supérieure ou égale à celle du dernier inventaire"; 
       }else{
  ////////////////A REMPLIR POUR FACTURE
        $query = $this->db->query("SELECT reference from approvisionnementpneu WHERE reference = '".$reference."'")->row();;
				 
			if (count($query) >0) { 
			
			 echo "Erreur d'insertion contactez l'administrateur";
         
			}else {
				
		$addInventaire = $this->db->query("INSERT into approvisionnementpneu value('',".$id_article.",".$id_fournisseur.",'".$reference."','".$auteur."',CAST('". $date."' AS DATE),".$qtite.",".$montant.",'".$bl."',".$marque.",".$type.")");
			
			}
			

        
        if ($addInventaire == true) {
			
            $addInventaire1 = $this->db->query("INSERT into article value('',2,'".$reference."',".$montant.",'".$reference."',".$id_fournisseur.",'N/D',1,'PNEU','".$reference."',".$type.")");
     
            echo "Insertion Parfaite de la Livraison PNEU";
            $this->notificationAjout($nom_table,addslashes($message));
        }else{
            echo "Erreur d'insertion contactez l'administrateur";
        }
    }

        $this->db->close();
    }
    
    
   
    public function selectAllApprovisionnementGazoil(){

        if (isset($_POST['date_debut']) && isset($_POST['date_fin']) && isset($_POST['bl1']) && isset($_POST['id_fournisseur1'])) {
            # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $bl1 = $_POST['bl1'];
        $id_fournisseur1 = $_POST['id_fournisseur1'];
        }else{
        $date_debut = '';
        $date_fin = '';
        $bl1 = '';
        $id_fournisseur1 = "";
        }
        

        if (!empty($bl)) {
            # code...
            $bl1 = $_POST['bl1'];
            }else{
            $bl = '';
            }
        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur1) && empty($bl1)){
            $query = $this->db->query("select * from approvisionnementGazoil where id_fournisseur = ".$id_fournisseur1." order by date_app desc")->result_array();

        }elseif (empty($date_fin) && empty($date_debut) && !empty($id_fournisseur1) && !empty($bl1)){

            $query = $this->db->query("select * from approvisionnementGazoil where id_fournisseur = ".$id_fournisseur1." and bl='".$bl1."' order by date_app desc")->result_array();

        }elseif (empty($date_fin) && !empty($date_debut) && !empty($id_fournisseur1) && empty($bl1)){

            $query = $this->db->query("select * from approvisionnementGazoil where id_fournisseur = ".$id_fournisseur1." and date_app='".$date_debut."' order by date_app desc")->result_array();

        }elseif (!empty($date_fin) && empty($date_debut) && !empty($id_fournisseur1) && empty($bl1)){

            $query = $this->db->query("select * from approvisionnementGazoil where id_fournisseur = ".$id_fournisseur1." and date_app='".$date_fin."' order by date_app desc")->result_array();

        }elseif (!empty($date_fin) && !empty($date_debut) && empty($id_fournisseur1) && empty($bl1)){

            $query = $this->db->query("SELECT * from approvisionnementGazoil where  date_app between '".$date_debut."' and '".$date_fin."' order by date_app desc")->result_array();


        }elseif (!empty($date_fin) && !empty($date_debut) && !empty($id_fournisseur1) && empty($bl1)){

            $query = $this->db->query("SELECT * from approvisionnementGazoil where id_fournisseur = ".$id_fournisseur1." and  date_app between '".$date_debut."' and '".$date_fin."' order by date_app desc")->result_array();


        }elseif (!empty($date_fin) && !empty($date_debut) && !empty($id_fournisseur1) && !empty($bl1)){

            $query = $this->db->query("SELECT * from approvisionnementGazoil where id_fournisseur = ".$id_fournisseur1." and bl='".$bl."' and  date_app between '".$date_debut."' and '".$date_fin."' order by date_app desc")->result_array();


        }elseif (!empty($date_fin) && empty($date_debut) && empty($id_fournisseur1) && empty($bl1)){
            
             $query = $this->db->query("SELECT * from approvisionnementGazoil where date_app ='".$date_fin."' order by date_app desc")->result_array();

        }elseif (empty($date_fin) && !empty($date_debut) && empty($id_fournisseur1) && empty($bl1)){
            $query = $this->db->query("SELECT * from approvisionnementGazoil where date_app ='".$date_debut."' order by date_app desc")->result_array();
        }else{
            $query = $this->db->query("select * from approvisionnementGazoil  order by id_app desc")->result_array();
        }

        

        if (count($query) >0 ) {
            # code...
            $compteur = 0;
           
             $qtiteInventaire= 0;
        foreach ($query as $row) {
            # code...
             $M = 0;
            $Q = 0;
            $Q =  $row['qtite'];
            $M = $row['montant'];
            $qtiteInventaire= $Q*$M;
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    ";
                    $getNomArticle = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->row();
                    $four = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur=".$row['id_fournisseur']." ")->row();
                    if (count($four)>0) {
                        # code...
                        $four = $four->nom;
                    }else{
                        $four ="";
                    }
                    echo" 
                    <td>".$getNomArticle->code_a_barre."</td>
                    <td>".$getNomArticle->article."</td>
                    <td>".$four."</td>
                    
                    </td>";
                    
                    $getCategorie = $this->db->query('SELECT * FROM categorie_article where id_categorie='.$getNomArticle->id_categorie.'')->row();
                    echo"<td>".$getCategorie->categorie."</td>
                    ";
                    echo"
                    <td>".$row['auteur']."</td>
                    
                    <td>".$row['montant']."</td>
                    <td>".$row['bl']."</td>
                    <td>".$row['date_app']."</td>
                    
                    <td>".$row['qtite']."</td>
                    <td>$qtiteInventaire </td>
                    <td>";
                if($this->session->userdata('operation_gazoil_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='approvisionnementgazoil' identifiant='".$row['id_app']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_app\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
            }
        }


        $this->db->close();
    }


public function selectAllApprovisionnementHuile(){

        if (isset($_POST['date_debut']) && isset($_POST['date_fin']) && isset($_POST['bl1']) && isset($_POST['id_fournisseur1'])) {
            # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $bl1 = $_POST['bl1'];
        $id_fournisseur1 = $_POST['id_fournisseur1'];
        }else{
        $date_debut = '';
        $date_fin = '';
        $bl1 = '';
        $id_fournisseur1 = "";
        }
        

        if (!empty($bl)) {
            # code...
            $bl1 = $_POST['bl1'];
            }else{
            $bl = '';
            }
        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur1) && empty($bl1)){
            $query = $this->db->query("select * from approvisionnementhuile where id_fournisseur = ".$id_fournisseur1." order by date_app desc")->result_array();

        }elseif (empty($date_fin) && empty($date_debut) && !empty($id_fournisseur1) && !empty($bl1)){

            $query = $this->db->query("select * from approvisionnementhuile where id_fournisseur = ".$id_fournisseur1." and bl='".$bl1."' order by date_app desc")->result_array();

        }elseif (empty($date_fin) && !empty($date_debut) && !empty($id_fournisseur1) && empty($bl1)){

            $query = $this->db->query("select * from approvisionnementhuile where id_fournisseur = ".$id_fournisseur1." and date_app='".$date_debut."' order by date_app desc")->result_array();

        }elseif (!empty($date_fin) && empty($date_debut) && !empty($id_fournisseur1) && empty($bl1)){

            $query = $this->db->query("select * from approvisionnementhuile where id_fournisseur = ".$id_fournisseur1." and date_app='".$date_fin."' order by date_app desc")->result_array();

        }elseif (!empty($date_fin) && !empty($date_debut) && empty($id_fournisseur1) && empty($bl1)){

            $query = $this->db->query("SELECT * from approvisionnementhuile where  date_app between '".$date_debut."' and '".$date_fin."' order by date_app desc")->result_array();


        }elseif (!empty($date_fin) && !empty($date_debut) && !empty($id_fournisseur1) && empty($bl1)){

            $query = $this->db->query("SELECT * from approvisionnementhuile where id_fournisseur = ".$id_fournisseur1." and  date_app between '".$date_debut."' and '".$date_fin."' order by date_app desc")->result_array();


        }elseif (!empty($date_fin) && !empty($date_debut) && !empty($id_fournisseur1) && !empty($bl1)){

            $query = $this->db->query("SELECT * from approvisionnementhuile where id_fournisseur = ".$id_fournisseur1." and bl='".$bl."' and  date_app between '".$date_debut."' and '".$date_fin."' order by date_app desc")->result_array();


        }elseif (!empty($date_fin) && empty($date_debut) && empty($id_fournisseur1) && empty($bl1)){
            
             $query = $this->db->query("SELECT * from approvisionnementhuile where date_app ='".$date_fin."' order by date_app desc")->result_array();

        }elseif (empty($date_fin) && !empty($date_debut) && empty($id_fournisseur1) && empty($bl1)){
            $query = $this->db->query("SELECT * from approvisionnementhuile where date_app ='".$date_debut."' order by date_app desc")->result_array();
        }else{
            $query = $this->db->query("select * from approvisionnementhuile  order by id_app desc")->result_array();
        }

        

        if (count($query) >0 ) {
            # code...
            $compteur = 0;
           
             $qtiteInventaire= 0;
        foreach ($query as $row) {
            # code...
             $M = 0;
            $Q = 0;
            $Q =  $row['qtite'];
            $M = $row['montant'];
            $qtiteInventaire= $Q*$M;
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    ";
                    $getNomArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_article']."")->row();
                    $four = $this->db->query("SELECT * from fournisseur_article where id_fournisseur=".$row['id_fournisseur']." ")->row();
                    if (count($four)>0) {
                        # code...
                        $four = $four->nom;
                    }else{
                        $four ="";
                    }
                    echo" 
                    <td>".$getNomArticle->type_huile."</td>
                    <td>".$getNomArticle->huile."</td>
                    <td>".$four."</td>
                   
                    <td>".$row['auteur']."</td>
                    
                    <td>".$row['montant']."</td>
                    <td>".$row['bl']."</td>
                    <td>".$row['date_app']."</td>
                    
                    <td>".$row['qtite']."</td>
                    <td>$qtiteInventaire </td>
                    <td>";
                if($this->session->userdata('vidange_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='approvisionnementhuile' identifiant='".$row['id_app']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_app\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
            }
        }


        $this->db->close();
    }
	
	
	public function selectAllApprovisionnementPneu(){

        if (isset($_POST['date_debut']) && isset($_POST['date_fin']) && isset($_POST['bl1']) && isset($_POST['id_fournisseur1'])) {
            # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $bl1 = $_POST['bl1'];
        $id_fournisseur1 = $_POST['id_fournisseur1'];
        }else{
        $date_debut = '';
        $date_fin = '';
        $bl1 = '';
        $id_fournisseur1 = "";
        }
        

        if (!empty($bl)) {
            # code...
            $bl1 = $_POST['bl1'];
            }else{
            $bl = '';
            }
        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur1) && empty($bl1)){
            $query = $this->db->query("select * from approvisionnementpneu where id_fournisseur = ".$id_fournisseur1." order by date_app desc")->result_array();

        }elseif (empty($date_fin) && empty($date_debut) && !empty($id_fournisseur1) && !empty($bl1)){

            $query = $this->db->query("select * from approvisionnementpneu where id_fournisseur = ".$id_fournisseur1." and bl='".$bl1."' order by date_app desc")->result_array();

        }elseif (empty($date_fin) && !empty($date_debut) && !empty($id_fournisseur1) && empty($bl1)){

            $query = $this->db->query("select * from approvisionnementpneu where id_fournisseur = ".$id_fournisseur1." and date_app='".$date_debut."' order by date_app desc")->result_array();

        }elseif (!empty($date_fin) && empty($date_debut) && !empty($id_fournisseur1) && empty($bl1)){

            $query = $this->db->query("select * from approvisionnementpneu where id_fournisseur = ".$id_fournisseur1." and date_app='".$date_fin."' order by date_app desc")->result_array();

        }elseif (!empty($date_fin) && !empty($date_debut) && empty($id_fournisseur1) && empty($bl1)){

            $query = $this->db->query("SELECT * from approvisionnementpneu where  date_app between '".$date_debut."' and '".$date_fin."' order by date_app desc")->result_array();


        }elseif (!empty($date_fin) && !empty($date_debut) && !empty($id_fournisseur1) && empty($bl1)){

            $query = $this->db->query("SELECT * from approvisionnementpneu where id_fournisseur = ".$id_fournisseur1." and  date_app between '".$date_debut."' and '".$date_fin."' order by date_app desc")->result_array();


        }elseif (!empty($date_fin) && !empty($date_debut) && !empty($id_fournisseur1) && !empty($bl1)){

            $query = $this->db->query("SELECT * from approvisionnementpneu where id_fournisseur = ".$id_fournisseur1." and bl='".$bl."' and  date_app between '".$date_debut."' and '".$date_fin."' order by date_app desc")->result_array();


        }elseif (!empty($date_fin) && empty($date_debut) && empty($id_fournisseur1) && empty($bl1)){
            
             $query = $this->db->query("SELECT * from approvisionnementpneu where date_app ='".$date_fin."' order by date_app desc")->result_array();

        }elseif (empty($date_fin) && !empty($date_debut) && empty($id_fournisseur1) && empty($bl1)){
            $query = $this->db->query("SELECT * from approvisionnementpneu where date_app ='".$date_debut."' order by date_app desc")->result_array();
        }else{
            $query = $this->db->query("select * from approvisionnementpneu  order by id_app desc")->result_array();
        }

        

        if (count($query) >0 ) {
            # code...
            $compteur = 0;
           $compteur1 = 0;
		   $compteur2 = 0;
		   $compteur3 = 0;
		   
             $qtiteInventaire= 0;
        foreach ($query as $row) {
            # code...
             $M = 0;
            $Q = 0;
            $Q =  $row['qtite'];
			 $compteur1 =  $compteur1 +  $Q;
            $M = $row['montant'];
			 $compteur2 =  $compteur2 +  $M;
			
            $qtiteInventaire= $Q*$M;
			
			$compteur3 =  $compteur3 +  $qtiteInventaire;
			
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    ";
                    $getTypeArticle = $this->db->query("SELECT * from type_pneu1 where id_type_pneu =".$row['id_type_pneu']."")->row();
					$getMarqueArticle = $this->db->query("SELECT * from marque_pneu where id_marque_pneu =".$row['id_marque_pneu']."")->row();
					$getTailleArticle = $this->db->query("SELECT * from type_pneu where id_type_pneu =".$row['id_article']."")->row();
					
                    $four = $this->db->query("SELECT * from fournisseur_article where id_fournisseur=".$row['id_fournisseur']." ")->row();
                    if (count($four)>0) {
                        # code...
                        $four = $four->nom;
                    }else{
                        $four ="";
                    }
                    echo" 
                    
                    <td>".$getTypeArticle->nom_type."</td>
					<td>".$getMarqueArticle->marque."</td>
					<td>".$getTailleArticle->nom_type."</td>
					<td>".$row['reference']."</td>
                    <td>".$four."</td>
                   
                    <td>".$row['auteur']."</td>
                    
                    
                    <td>".$row['bl']."</td>
                    <td>".$row['date_app']."</td>
                    
                    <td>".$row['qtite']."</td>
					<td>".$row['montant']."</td>
                    <td>$qtiteInventaire </td>
                    <td>";
                if($this->session->userdata('pneu_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='approvisionnementpneu' identifiant='".$row['id_app']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_app\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
            }
        }
		
				echo "<tr>
        <td style='color:red;font-size: 20px;text-align:center; border: 2px solid black; font-weight: bold;'>TOTAUX</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
		<td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
       <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
         <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteur1,0,',',' ')."</td>
         <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteur2,0,',',' ')."</td>
		  <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteur3,0,',',' ')."</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>

	</tr>";


        $this->db->close();
    }




    public function selectAllGazoil(){
		
	
		
		
		
        if (isset($_POST["date_debut"]) && isset($_POST["date_fin"])) {
        # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
		
		
		                     
							 
        if (!empty($date_fin) && !empty($date_debut)) {
            # code...
           $query1 = $this->db->query('SELECT * from gazoil where date_gazoil between "'.$date_debut.'" and "'.$date_fin.'" order by date_gazoil desc')->result_array(); 
        }else{
            $query1 = $this->db->query('SELECT * from gazoil order by date_gazoil desc  limit 1000 ')->result_array();
        }
    }else{
        $query1 = $this->db->query('SELECT * from gazoil order by date_gazoil desc limit 1000')->result_array();
    }


         // $query1 = $this->db->query('SELECT * from gazoil order by date_gazoil desc limit 2000')->result_array();
		 
		 
         $compteur = 0;
		 $compteur1 = 0;
		 $compteur2 = 0;
        foreach ($query1 as $row) {
            # code...
			
			 $compteur1 = $compteur1+ $row['litrage'];
			 $compteur2 = $compteur2+ $row['prix_unitaire'] * $row['litrage'];

            echo "<tr >
                    
                    <td >".$row['numero']."</td>";

                    $getOperation = $this->db->query("SELECT * FROM operation where id_operation = ".$row['id_operation']."")->result_array();
					
					$getFournisseurGazoil= $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur = ".$row['id_fournisseur']."")->row();
       

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_op']."</td>";
                        }
                    }
                    $getDistance = $this->db->query("SELECT * from distance_littrage where id_distance = ".$row['id_distance']."")->row();
                    echo"
                    <td>".$row['code_camion']."</td>
					
                    <td> ".$row['date_gazoil']."</td>";
					
					 if (count($getFournisseurGazoil)>0) {
                        # code...
                       echo"<td>".$getFournisseurGazoil->nom."</td>"; 
                    }else{

                    }
					echo" 
                    <td>".$row['litrage']." L</td>
					<td>".$row['CON']."</td>
                    <td>";
                    if (count($getDistance)>0) {
                        # code...
                        echo  $getDistance->distance;
                    }else{

                    }
					
                   echo "</td>
				    
                    <td>".$row['kilometrage']."</td>
                    <td>".number_format($row['prix_unitaire'],0,',',' ')."</td>
                    <td>".number_format($row['prix_unitaire'] * $row['litrage'],0,',',' ')." </td>";
					
					
				$getTracteur = $this->db->query("SELECT * from tracteur WHERE code ='".$row['code_camion']."'  ")->row();
				
                $getCamionBenne = $this->db->query("SELECT * from camion_benne WHERE code ='".$row['code_camion']."' ")->row();
                
				$getEngin = $this->db->query("SELECT * from engin WHERE code ='".$row['code_camion']."' ")->row();
				
				$getVraquier = $this->db->query("SELECT * from vraquier WHERE code ='".$row['code_camion']."'  ")->row();
				
				$getService = $this->db->query("SELECT * from voitureservice WHERE code ='".$row['code_camion']."' ")->row();
				    
        if (count($getTracteur) >0) {	
		
		
		$getTypeVehicule = $this->db->query("SELECT * from type_vehicule WHERE id_type =".$getTracteur->id_type_camion." ")->row();
		
		 echo"<td>".$getTypeVehicule->nom_type."</td>"; 
		      		
        }else if (count($getCamionBenne) >0) {
			
			$getTypeVehicule = $this->db->query("SELECT * from type_vehicule WHERE id_type =".$getCamionBenne->id_type_camion." ")->row();
			
			 echo"<td>".$getTypeVehicule->nom_type."</td>"; 
		    
        }else if (count($getEngin) >0) {
			
			$getTypeVehicule = $this->db->query("SELECT * from type_vehicule WHERE id_type =".$getEngin->id_type_camion." ")->row();
			
			 echo"<td>".$getTypeVehicule->nom_type."</td>"; 
		    
        }else if (count($getVraquier) >0) {
			
			$getTypeVehicule = $this->db->query("SELECT * from type_vehicule WHERE id_type =".$getVraquier->id_type_camion." ")->row();
			
			 echo"<td>".$getTypeVehicule->nom_type."</td>"; 
		    
        }else if (count($getService) >0) {
			
			$getTypeVehicule = $this->db->query("SELECT * from type_vehicule WHERE id_type =".$getService->id_type_camion." ")->row();
			
			 echo"<td>".$getTypeVehicule->nom_type."</td>"; 
		    
        }else{
			
		 echo"<td>AUCUN</td>";
            
        }
		
		
		
					
             echo"    <td>";

                 if($this->session->userdata('operation_gazoil_modification')=='true'){
                    echo"<button type='button'  onclick=\"infoGazoil('".$row['numero']."','".$row['date_gazoil']."','".$row['litrage']."','".$row['id_distance']."','".$row['prix_unitaire']."','".$row['kilometrage']."','".$row['id_gazoil']."','".addslashes($row['commentaire'])."','".$row['id_fournisseur']."','".$row['id_operation']."','".$row['code_camion']."','".$row['id_distance']."');\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }
                if($this->session->userdata('operation_gazoil_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='gazoil' identifiant='".$row['id_gazoil']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_gazoil\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
        }
		
		echo "<tr>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>TOTAUX</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteur1,0,',',' ')."</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteur2,0,',',' ')."</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
		<td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
		<td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
	</tr>";
		
		
		
		

        $this->db->close();
    }
	
	
	//<td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteur1,0,',',' ')."</td>
	
	
public function stockGazoil(){
	
    $getFournisseur = $this->db->query("select * from fournisseur_gazoil where nom = 'TOTAL ENERGIE' or nom = 'NEPTUNE'")->result_array();
    $compteur = 0;
    if (count($getFournisseur) > 0) {
        # code...
        foreach ($getFournisseur as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    ";
                    $fournisseur = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur =".$row['id_fournisseur']."")->row();
                    
                    echo"
                    <td>".$fournisseur->nom."</td>
					";
					$article = $this->db->query("SELECT * from article where article = 'GAZOIL'")->row();
                    
                    echo"
                  	<td>".$article->code_a_barre."</td>					
                    <td>".$article->article."</td>
                    <td>".$article->prix_unitaire."</td>
                    </td>";
                  
                $qtiteInventaire = 0;
                $getInventaire = $this->db->query("SELECT * from inventairegazoil where id_article=".$article->id_article." and id_fournisseur=".$row['id_fournisseur']." order by date_inv desc")->result_array();
				
                if (count($getInventaire)>0) {
                    # code...
                    foreach ($getInventaire as $inventaire) {
                    # code...
                    $qtiteInventaire = $qtiteInventaire + $inventaire['qtite'];
                    }
                    echo"
					<td>".$qtiteInventaire."</td>
					
                    ";
                }else{
                    echo "<td>0</td>";
                }
                $qtiteApprovisionnement = 0;
                $getApprovisionnement = $this->db->query("SELECT * from approvisionnementgazoil where id_article=".$article->id_article." and  id_fournisseur=".$row['id_fournisseur']." and date_app >= '".$this->getDateDernierInventaireGazoil()."'")->result_array();
                if (count($getApprovisionnement)>0) {
                    # code...
                    foreach ($getApprovisionnement as $app) {
                    # code...
                    $qtiteApprovisionnement= $qtiteApprovisionnement + $app['qtite'];
                    }
                    echo"<td>".$qtiteApprovisionnement."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }

                $qtitePieceRechange = 0;
                $getPieceRechange = $this->db->query("SELECT * from gazoil where date_gazoil >= '".$this->getDateDernierInventaireGazoil()."' and  id_fournisseur=".$row['id_fournisseur']."")->result_array();
                if (count($getPieceRechange)>0) {
                    # code...
                    foreach ($getPieceRechange as $sortie) {
                    # code...
                    $qtitePieceRechange = $qtitePieceRechange + $sortie['litrage'];
                    }
                    echo"<td>".$qtitePieceRechange."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }

                
                $stock = $qtiteInventaire + $qtiteApprovisionnement - $qtitePieceRechange;
                echo"
				    <td>".$stock."</td>
                    <td>".$stock * $article->prix_unitaire."</td>
					
					";
					
                    $compteur++;
        }

        
    }

    $this->db->close();
}

public function stockPneu(){
	
    $getArticle = $this->db->query("select distinct reference,id_article,id_fournisseur from approvisionnementpneu Order by reference,id_article ")->result_array();
    $compteur = 0;
    if (count($getArticle) > 0) {
        # code...
        foreach ($getArticle as $row) {
            # code...
            
                
					$article = $this->db->query("SELECT * from type_pneu where id_type_pneu = ".$row['id_article']." ")->row();
					
					$fournisseur = $this->db->query("SELECT * from fournisseur_article where id_fournisseur = ".$row['id_fournisseur']." ")->row();
					
					$reference = $this->db->query("SELECT * from article where code_a_barre = '".$row['reference']."' ")->row();
					
								
						echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    ";
	                
                    echo"
					
					<td>".$row['reference']."</td>	
					
					<td>".$article->nom_type."</td>
					
					 <td>".$fournisseur->nom."</td>
                  						
                    
                    </td>";
					
					 $qtiteInventaire = 0;
					 
            
                $qtiteApprovisionnement = 0;
                $getApprovisionnement = $this->db->query("SELECT * from approvisionnementpneu where id_article=".$row['id_article']." and  reference='".$row['reference']."' and date_app >= '".$this->getDateDernierInventairePneu()."'")->result_array();
                if (count($getApprovisionnement)>0) {
                    # code...
                    foreach ($getApprovisionnement as $app) {
                    # code...
                    $qtiteApprovisionnement= $qtiteApprovisionnement + $app['qtite'];
                    }
                    echo"
					<td>".$qtiteApprovisionnement."</td>
					
                    ";
                }else{
                    echo "<td>0</td>";
                }

                $qtitePieceRechange = 0;
                $getPieceRechange = $this->db->query("SELECT * from depense_pneu where date_depense >= '".$this->getDateDernierInventairePneu()."' and type ='PNEU' and  id_article=".$reference->id_article."")->result_array();
                if (count($getPieceRechange)>0) {
                    # code...
                    foreach ($getPieceRechange as $sortie) {
                    # code...
                    $qtitePieceRechange = $qtitePieceRechange + $sortie['qtite'];
                    }
                    echo"<td>".$qtitePieceRechange."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }

                
                $stock = $qtiteInventaire + $qtiteApprovisionnement - $qtitePieceRechange;
                echo"
				<td>".$stock."</td>
				<td>".$stock * $app['montant']."</td>
                    ";
					
					
					
                   
               
                    $compteur++;
        }

        
    }

    $this->db->close();
}


public function stockHuile(){
	
    $getArticle = $this->db->query("select * from type_huile order by huile")->result_array();
    $compteur = 0;
    if (count($getArticle) > 0) {
        # code...
        foreach ($getArticle as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    ";
                    $article = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type']."")->row();
                    
                    echo"
                    <td>". $article->type_huile."</td>
					<td>". $article->huile."</td>
					<td>". $article->PU."</td>
					";
					
                    
                $qtiteInventaire = 0;
                $getInventaire = $this->db->query("SELECT * from inventairehuile where  id_article = ".$row['id_type']." order by date_inv desc")->result_array();
				
                if (count($getInventaire)>0) {
                    # code...
                    foreach ($getInventaire as $inventaire) {
                    # code...
                    $qtiteInventaire = $qtiteInventaire + $inventaire['qtite'];
                    }
                    echo"
					<td>".$qtiteInventaire."</td>
					
                    ";
                }else{
                    echo "<td>0</td>";
                }
				
				
				
            
				 $qtiteApprovisionnement = 0;
                $getApprovisionnement = $this->db->query("SELECT * from approvisionnementhuile where id_article = ".$row['id_type']." and date_app >= '".$this->getDateDernierInventaireHuile()."'")->result_array();
                if (count($getApprovisionnement)>0) {
                    # code...
                    foreach ($getApprovisionnement as $app) {
                    # code...
                    $qtiteApprovisionnement= $qtiteApprovisionnement + $app['qtite'];
                    }
                    echo"<td>".$qtiteApprovisionnement."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }

				
                $qtitePieceRechange = 0;
				
				
                $getPieceRechange = $this->db->query("SELECT * from vidange where date_vidange >= '".$this->getDateDernierInventaireHuile()."' and  id_type_huile = ".$row['id_type']."")->result_array();
               
			   if (count($getPieceRechange)>0) {
                    # code...
                    foreach ($getPieceRechange as $sortie) {
                    # code...
                    $qtitePieceRechange = $qtitePieceRechange + $sortie['qtite'];
                    }
					
					 echo"<td>".$qtitePieceRechange."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }
                    
                 $getPieceRechange = $this->db->query("SELECT * from vidangeboite where date_vidange >= '".$this->getDateDernierInventaireHuile()."' and  id_type_huile = ".$row['id_type']."")->result_array();
               
			   if (count($getPieceRechange)>0) {
                    # code...
                    foreach ($getPieceRechange as $sortie) {
                    # code...
                    $qtitePieceRechange = $qtitePieceRechange + $sortie['qtite'];
                    }
					
					 echo"<td>".$qtitePieceRechange."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }
                   
				     $getPieceRechange = $this->db->query("SELECT * from vidangehydrolique where date_vidange >= '".$this->getDateDernierInventaireHuile()."' and  id_type_huile = ".$row['id_type']."")->result_array();
               
			   if (count($getPieceRechange)>0) {
                    # code...
                    foreach ($getPieceRechange as $sortie) {
                    # code...
                    $qtitePieceRechange = $qtitePieceRechange + $sortie['qtite'];
                    }
					
					 echo"<td>".$qtitePieceRechange."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }
				
				
				$getPieceRechange = $this->db->query("SELECT * from vidangegraisse where date_vidange >= '".$this->getDateDernierInventaireHuile()."' and  id_type_huile = ".$row['id_type']."")->result_array();
               
			   if (count($getPieceRechange)>0) {
                    # code...
                    foreach ($getPieceRechange as $sortie) {
                    # code...
                    $qtitePieceRechange = $qtitePieceRechange + $sortie['qtite'];
                    }
					
					 echo"<td>".$qtitePieceRechange."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }
                   
				
                   
                    
             
                $stock = $qtiteInventaire + $qtiteApprovisionnement   - $qtitePieceRechange ;
				
                echo"<td>".$stock."</td>
				     <td>".$stock*$article->PU."</td>
                    ";
                    $compteur++;
        }

        
    }

    $this->db->close();
}



public function selectAllStockGazoil(){

    $date_debut = $_POST["date_debut"];
    $date_fin = $_POST["date_fin"];
    // $date_fin = date("d/m/Y",strtotime($date_fin));   
    // $date_debut = date("d/m/Y",strtotime($date_debut));   

   $getFournisseur = $this->db->query("select * from fournisseur_gazoil where nom = 'TOTAL NEW' or nom = 'NEPTUNE NEW'")->result_array();
    $compteur = 0;
    if (count($getFournisseur) > 0) {
        # code...
        foreach ($getFournisseur as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    ";
                    $fournisseur = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur =".$row['id_fournisseur']."")->row();
                    
                    echo"
                    <td>".$fournisseur->nom."</td>
					";
					$article = $this->db->query("SELECT * from article where article = 'GAZOIL'")->row();
                    
                    echo"
                  	<td>".$article->code_a_barre."</td>					
                    <td>".$article->article."</td>
                    <td>".$article->prix_unitaire."</td>
                    </td>";
                     $getCategorie = $this->db->query("SELECT * FROM categorie_article where id_categorie=".$article->id_categorie."")->row();
                    echo"<td>".$getCategorie->categorie."</td>
                    ";
                 $qtiteInventaire = 0;
				 
                $getInventaire = $this->db->query("SELECT * from inventairegazoil where id_article=".$article->id_article." and id_fournisseur=".$row['id_fournisseur']." order by date_inv desc")->result_array();

                if (count($getInventaire)>0) {
                    # code...
                    foreach ($getInventaire as $inventaire) {
                    # code...
                    $qtiteInventaire = $qtiteInventaire + $inventaire['qtite'];
                    }
                    $qtiteInventaire = $this->stockInitial($article->id_article);
                    echo"<td>".$qtiteInventaire."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }
                $qtiteApprovisionnement = 0;
                $getApprovisionnement = $this->db->query("SELECT * from approvisionnementgazoil where id_article=".$article->id_article." and id_fournisseur=".$row['id_fournisseur']." and date_app between '".$date_debut."' and '".$date_fin."'")->result_array();
                if (count($getApprovisionnement)>0) {
                    # code...
                    foreach ($getApprovisionnement as $app) {
                    # code...
                    $qtiteApprovisionnement= $qtiteApprovisionnement + $app['qtite'];
                    }
                    echo"<td>".$qtiteApprovisionnement."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }

                $qtitePieceRechange = 0;
                 $getPieceRechange = $this->db->query("SELECT * from gazoil where id_fournisseur=".$row['id_fournisseur']." and date_gazoil between '".$date_debut."' and '".$date_fin."'")->result_array();
                if (count($getPieceRechange)>0) {
                    # code...
                    foreach ($getPieceRechange as $sortie) {
                    # code...
                    $qtitePieceRechange = $qtitePieceRechange + $sortie['litrage'];
                    }
                    echo"<td>".$qtitePieceRechange."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }

               
                $stock = $qtiteInventaire + $qtiteApprovisionnement - $qtitePieceRechange;
                echo"<td>".$stock."</td>
                    ";
                    $compteur++;
        }

        
    }

    $this->db->close();
	
	
}

public function selectAllStockHuile(){

    $date_debut = $_POST["date_debut"];
    $date_fin = $_POST["date_fin"];
    // $date_fin = date("d/m/Y",strtotime($date_fin));   
    // $date_debut = date("d/m/Y",strtotime($date_debut));   

   $getArticle = $this->db->query("select * from type_huile order by huile")->result_array();
    $compteur = 0;
    if (count($getArticle) > 0) {
        # code...
        foreach ($getArticle as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    ";
                    $article = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type']."")->row();
                    
                    echo"
                    <td>". $article->type_huile."</td>
					<td>". $article->huile."</td>
					";
					
                    
                $qtiteInventaire = 0;
                $getInventaire = $this->db->query("SELECT * from inventairehuile where  id_article = ".$row['id_type']."  order by date_inv desc")->result_array();
				
                if (count($getInventaire)>0) {
                    # code...
                    foreach ($getInventaire as $inventaire) {
                    # code...
                    $qtiteInventaire = $qtiteInventaire + $inventaire['qtite'];
                    }
					
					//$qtiteInventaire = $this->stockInitialHuile($article->id_type);
					
					
                    echo"<td>".$qtiteInventaire."</td>
					
                   
                    ";
                }else{
                    echo "<td>0</td>";
                }
				
							
                $qtiteApprovisionnement = 0;
                $getApprovisionnement = $this->db->query("SELECT * from approvisionnementhuile where id_article = ".$row['id_type']." and date_app between '".$date_debut."' and '".$date_fin."'")->result_array();
                if (count($getApprovisionnement)>0) {
                    # code...
                    foreach ($getApprovisionnement as $app) {
                    # code...
                    $qtiteApprovisionnement= $qtiteApprovisionnement + $app['qtite'];
                    }
                    echo"<td>".$qtiteApprovisionnement."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }
				
				
	          $qtitePieceRechange = 0;
                 $getPieceRechange = $this->db->query("SELECT * from vidange where id_type_huile = ".$row['id_type']." and date_vidange between '".$date_debut."' and '".$date_fin."'")->result_array();
                if (count($getPieceRechange)>0) {
                    # code...
                    foreach ($getPieceRechange as $sortie) {
                    # code...
                    $qtitePieceRechange = $qtitePieceRechange + $sortie['qtite'];
                    }
                    echo"<td>".$qtitePieceRechange."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }
				
				$qtitePieceRechange1 = 0;
                 $getPieceRechange = $this->db->query("SELECT * from vidangeboite where id_type_huile = ".$row['id_type']." and date_vidange between '".$date_debut."' and '".$date_fin."'")->result_array();
                if (count($getPieceRechange)>0) {
                    # code...
                    foreach ($getPieceRechange as $sortie) {
                    # code...
                    $qtitePieceRechange1 = $qtitePieceRechange1 + $sortie['qtite'];
                    }
                    echo"<td>".$qtitePieceRechange1."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }
				
				$qtitePieceRechange2 = 0;
                 $getPieceRechange = $this->db->query("SELECT * from vidangehydrolique where id_type_huile = ".$row['id_type']." and date_vidange between '".$date_debut."' and '".$date_fin."'")->result_array();
                if (count($getPieceRechange)>0) {
                    # code...
                    foreach ($getPieceRechange as $sortie) {
                    # code...
                    $qtitePieceRechange2 = $qtitePieceRechange2 + $sortie['qtite'];
                    }
                    echo"<td>".$qtitePieceRechange2."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }

               
                $stock = $qtiteInventaire  +$qtiteApprovisionnement  - $qtitePieceRechange - $qtitePieceRechange1 - $qtitePieceRechange2;
				
                echo"<td>".$stock."</td>
                    ";
                    $compteur++;
        }

        
    }

    $this->db->close();
	
	
}



public function stockInitial($id_article){

    $date_debut = $_POST["date_debut"];
    $date_fin = $_POST["date_fin"];
    // $date_fin = date("d/m/Y",strtotime($date_fin));   
    // $date_debut = date("d/m/Y",strtotime($date_debut));   
    if ($date_debut > $this->getDateDernierInventaireGazoil()) {
                    # code...
        $date_fin = date("Y-m-d",strtotime($date_debut.'- 1 days'));
        $date_debut = $this->getDateDernierInventaireGazoil();
        }elseif ($date_debut == $this->getDateDernierInventaireGazoil()) {
            # code...
            $date_fin = $this->getDateDernierInventaireGazoil();
        }
   $getFournisseur = $this->db->query("select * from fournisseur_gazoil where nom = 'TOTAL NEW' or nom = 'NEPTUNE NEW'")->result_array();
    $compteur = 0;
    if (count($getFournisseur) > 0) {
        # code...
        foreach ($getFournisseur as $row) {
            # code...
           // echo "<tr >
             //       <td onclick=\"creerDatable();\">".$compteur."</td>
              ///      ";
                    $fournisseur = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur =".$row['id_fournisseur']."")->row();
                    
        # code...
      
            // echo "<tr >
            //         <td onclick=\"creerDatable();\">".$compteur."</td>
            //          ";
                    $article = $this->db->query("SELECT * from article where id_article =".$id_article."")->row();
                    
                    // echo"
                    // <td>".$article->code_a_barre."</td>
                    // <td>".$article->article."</td>
                    // <td>".$article->prix_unitaire."</td>
                    // </td>";
                   $getCategorie = $this->db->query("SELECT * FROM categorie_article where id_categorie=".$article->id_categorie."")->row();
                    // echo"<td>".$getCategorie->categorie."</td>
                    // ";
                $qtiteInventaire = 0;

                $getInventaire = $this->db->query("SELECT * from inventairegazoil where id_article=".$article->id_article." and id_fournisseur=".$row['id_fournisseur']." order by date_inv desc")->result_array();
                if (count($getInventaire)>0) {
                    # code...
                    foreach ($getInventaire as $inventaire) {
                    # code...
                    $qtiteInventaire = $qtiteInventaire + $inventaire['qtite'];
                    }
                    // echo"<td>".$qtiteInventaire."</td>";
                }else{
                    // echo "<td>0</td>";
                }

                $qtiteApprovisionnement = 0;
                $getApprovisionnement = $this->db->query("SELECT * from approvisionnementgazoil where id_article=".$article->id_article." and id_fournisseur=".$row['id_fournisseur']." and date_app between '".$date_debut."' and '".$date_fin."'")->result_array();
                if (count($getApprovisionnement)>0) {
                    # code...
                    foreach ($getApprovisionnement as $app) {
                    # code...
                    $qtiteApprovisionnement= $qtiteApprovisionnement + $app['qtite'];
                    }
                    // echo"<td>".$qtiteApprovisionnement."</td>";
                }else{
                    // echo "<td>0</td>";
                }

                $qtitePieceRechange = 0;
                 $getPieceRechange = $this->db->query("SELECT * from gazoil where  id_fournisseur=".$row['id_fournisseur']." and date_gazoil between '".$date_debut."' and '".$date_fin."'")->result_array();
                if (count($getPieceRechange)>0) {
                    # code...
                    foreach ($getPieceRechange as $sortie) {
                    # code...
                    $qtitePieceRechange = $qtitePieceRechange + $sortie['litrage'];
                    }
                    // echo"<td>".$qtitePieceRechange."</td> ";
                }else{
                    // echo "<td>0</td>";
                }

              

                $stock = $qtiteInventaire+$qtiteApprovisionnement  - $qtitePieceRechange;
                // echo"<td>".$stock."</td> ";
                return $stock;
				
				
                    $compteur++;
        

        }
    
}

    $this->db->close();
	
	
}

public function stockInitialHuile($id_article){

    $date_debut = $_POST["date_debut"];
    $date_fin = $_POST["date_fin"];
    // $date_fin = date("d/m/Y",strtotime($date_fin));   
    // $date_debut = date("d/m/Y",strtotime($date_debut));   
    if ($date_debut > $this->getDateDernierInventaireHuile()) {
                    # code...
        $date_fin = date("Y-m-d",strtotime($date_debut.'- 1 days'));
        $date_debut = $this->getDateDernierInventaireHuile();
        }elseif ($date_debut == $this->getDateDernierInventaireHuile()) {
            # code...
            $date_fin = $this->getDateDernierInventaireHuile();
        }
  // $getArticle = $this->db->query("select * from type_huile order by huile")->result_array();
  //  $compteur = 0;
  //  if (count($getArticle) > 0) {
        # code...
  //      foreach ($getArticle as $row) {
            # code...
        //    echo "<tr >
         //           <td onclick=\"creerDatable();\">".$compteur."</td>
         //           ";
         //           $article = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type']."")->row();
                    
          //          echo"
           //         <td>". $article->type_huile."</td>
			//		<td>". $article->huile."</td>
			//		";
					
                    
                $qtiteInventaire = 0;
                $getInventaire = $this->db->query("SELECT * from inventairehuile where  id_article = ".$row['id_type']."  order by date_inv desc")->result_array();
				
                if (count($getInventaire)>0) {
                    # code...
                    foreach ($getInventaire as $inventaire) {
                    # code...
                    $qtiteInventaire = $qtiteInventaire + $inventaire['qtite'];
                    }
				 }
				     $qtiteApprovisionnement = 0;
                $getApprovisionnement = $this->db->query("SELECT * from approvisionnementhuile where iid_article = ".$row['id_type']." and date_app between '".$date_debut."' and '".$date_fin."'")->result_array();
                if (count($getApprovisionnement)>0) {
                    # code...
                    foreach ($getApprovisionnement as $app) {
                    # code...
                    $qtiteApprovisionnement= $qtiteApprovisionnement + $app['qtite'];
                    }
               
                }
				
				 $qtitePieceRechange = 0;
                 $getPieceRechange = $this->db->query("SELECT * from vidange where  id_article = ".$row['id_type']." and date_vidange between '".$date_debut."' and '".$date_fin."'")->result_array();
                if (count($getPieceRechange)>0) {
                    # code...
                    foreach ($getPieceRechange as $sortie) {
                    # code...
                    $qtitePieceRechange = $qtitePieceRechange + $sortie['qtite'];
                    }
             
                }
				
				 $qtitePieceRechange1 = 0;
                 $getPieceRechange = $this->db->query("SELECT * from vidangeboite where  id_article = ".$row['id_type']." and date_vidange between '".$date_debut."' and '".$date_fin."'")->result_array();
                if (count($getPieceRechange1)>0) {
                    # code...
                    foreach ($getPieceRechange as $sortie) {
                    # code...
                    $qtitePieceRechange1 = $qtitePieceRechange1 + $sortie['qtite'];
                    }
             
                }
				
				$qtitePieceRechange2 = 0;
                 $getPieceRechange = $this->db->query("SELECT * from vidangehydrolique where  id_article = ".$row['id_type']." and date_vidange between '".$date_debut."' and '".$date_fin."'")->result_array();
                if (count($getPieceRechange1)>0) {
                    # code...
                    foreach ($getPieceRechange as $sortie) {
                    # code...
                    $qtitePieceRechange2 = $qtitePieceRechange2 + $sortie['qtite'];
                    }
             
                }
				
				$stock = $qtiteInventaire + $qtiteApprovisionnement  - $qtitePieceRechange;
               
                return $stock;
				
				 $this->db->close();
            //    $compteur++;
				
   }

				
				
public function stockInitialHuile1(){

    $date_debut = $_POST["date_debut"];
    $date_fin = $_POST["date_fin"];
    // $date_fin = date("d/m/Y",strtotime($date_fin));   
    // $date_debut = date("d/m/Y",strtotime($date_debut));   
    if ($date_debut > $this->getDateDernierInventaireHuile()) {
                    # code...
        $date_fin = date("Y-m-d",strtotime($date_debut.'- 1 days'));
        $date_debut = $this->getDateDernierInventaireHuile();
        }elseif ($date_debut == $this->getDateDernierInventaireHuile()) {
            # code...
            $date_fin = $this->getDateDernierInventaireHuile();
        }
   $getFournisseur = $this->db->query("select * from fournisseur_article order by nom")->result_array();
    $compteur = 0;
    if (count($getFournisseur) > 0) {
        # code...
        foreach ($getFournisseur as $row) {
           
		   $fournisseur = $this->db->query("SELECT * from fournisseur_article where id_fournisseur =".$row['id_fournisseur']."")->row();
                    
      
               $qtiteInventaire = 0;
                $getInventaire = $this->db->query("SELECT * from inventairehuile where id_fournisseur=".$row['id_fournisseur']." and id_article = 4 order by date_inv desc")->result_array();
				
                if (count($getInventaire)>0) {
                    # code...
                    foreach ($getInventaire as $inventaire) {
                    # code...
                    $qtiteInventaire = $qtiteInventaire + $inventaire['qtite'];
                    }
					
					
					 
                 }
				 
				     $qtiteApprovisionnement = 0;
                $getApprovisionnement = $this->db->query("SELECT * from approvisionnementhuile where id_fournisseur=".$row['id_fournisseur']." and  id_article = 4 and date_app between '".$date_debut."' and '".$date_fin."'")->result_array();
                if (count($getApprovisionnement)>0) {
                    # code...
                    foreach ($getApprovisionnement as $app) {
                    # code...
                    $qtiteApprovisionnement= $qtiteApprovisionnement + $app['qtite'];
                    }
               
                }
				
				 $qtitePieceRechange = 0;
                 $getPieceRechange = $this->db->query("SELECT * from vidangeboite where  id_fournisseur=".$row['id_fournisseur']." and date_vidange between '".$date_debut."' and '".$date_fin."'")->result_array();
                if (count($getPieceRechange)>0) {
                    # code...
                    foreach ($getPieceRechange as $sortie) {
                    # code...
                    $qtitePieceRechange = $qtitePieceRechange + $sortie['qtite'];
                    }
             
                }
				
				$stock = $qtiteInventaire + $qtiteApprovisionnement  - $qtitePieceRechange;
               
                return $stock;
				
				
                $compteur++;
				
			}

		}
		
		  $this->db->close();
}	

public function stockInitialHuile2(){

    $date_debut = $_POST["date_debut"];
    $date_fin = $_POST["date_fin"];
    // $date_fin = date("d/m/Y",strtotime($date_fin));   
    // $date_debut = date("d/m/Y",strtotime($date_debut));   
    if ($date_debut > $this->getDateDernierInventaireHuile()) {
                    # code...
        $date_fin = date("Y-m-d",strtotime($date_debut.'- 1 days'));
        $date_debut = $this->getDateDernierInventaireHuile();
        }elseif ($date_debut == $this->getDateDernierInventaireHuile()) {
            # code...
            $date_fin = $this->getDateDernierInventaireHuile();
        }
   $getFournisseur = $this->db->query("select * from fournisseur_article order by nom")->result_array();
    $compteur = 0;
    if (count($getFournisseur) > 0) {
        # code...
        foreach ($getFournisseur as $row) {
           
		   $fournisseur = $this->db->query("SELECT * from fournisseur_article where id_fournisseur =".$row['id_fournisseur']."")->row();
                    
      
               $qtiteInventaire = 0;
                $getInventaire = $this->db->query("SELECT * from inventairehuile where id_fournisseur=".$row['id_fournisseur']." and id_article = 3 order by date_inv desc")->result_array();
				
                if (count($getInventaire)>0) {
                    # code...
                    foreach ($getInventaire as $inventaire) {
                    # code...
                    $qtiteInventaire = $qtiteInventaire + $inventaire['qtite'];
                    }
				 
                 }
				 
				     $qtiteApprovisionnement = 0;
                $getApprovisionnement = $this->db->query("SELECT * from approvisionnementhuile where id_fournisseur=".$row['id_fournisseur']." and  id_article = 3 and date_app between '".$date_debut."' and '".$date_fin."'")->result_array();
                if (count($getApprovisionnement)>0) {
                    # code...
                    foreach ($getApprovisionnement as $app) {
                    # code...
                    $qtiteApprovisionnement= $qtiteApprovisionnement + $app['qtite'];
                    }
               
                }
				
				 $qtitePieceRechange = 0;
                 $getPieceRechange = $this->db->query("SELECT * from vidangehydrolique where  id_fournisseur=".$row['id_fournisseur']." and date_vidange between '".$date_debut."' and '".$date_fin."'")->result_array();
                if (count($getPieceRechange)>0) {
                    # code...
                    foreach ($getPieceRechange as $sortie) {
                    # code...
                    $qtitePieceRechange = $qtitePieceRechange + $sortie['qtite'];
                    }
             
                }
				
				$stock = $qtiteInventaire + $qtiteApprovisionnement  - $qtitePieceRechange;
               
                return $stock;
				
				
                $compteur++;
				
			}

		}
		
		  $this->db->close();
}							


public function selectAllPrime(){

    if (isset($_POST["date_debut"]) && isset($_POST["date_fin"])) {
        # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        if (!empty($date_fin) && !empty($date_debut)) {
            # code...
           $query1 = $this->db->query('SELECT * from prime where date_prime between "'.$date_debut.'" and "'.$date_fin.'" order by date_prime ')->result_array(); 
        }else{
            $query1 = $this->db->query('SELECT * from prime order by date_prime desc limit 900')->result_array();
        }
    }else{
       $query1 = $this->db->query('SELECT * from prime order by date_prime desc limit 1000')->result_array();
    }
         
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                    $getOperation = $this->db->query("SELECT * FROM operation where id_operation = ".$row['id_operation']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_op']."</td>";
                        }
                    }
                    
                    echo"

                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td> ".$row['libelle']."</td>
                    <td>".$row['code_camion']."</td>
                    
                    <td>".$row['date_prime']."</td>
                    <td>";
                if($this->session->userdata('depense_modification')=='true'){
                    echo"<button type='button'  onclick=\"infoPrime('".$row['montant']." ','".$row['libelle']."','".$row['date_prime']."','".$row['code_camion']."','".$row['id_operation']."',".$row['id_prime'].")\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }

                if($this->session->userdata('depense_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='prime' identifiant='".$row['id_prime']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_prime\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
        }

        $this->db->close();
    }

public function addPrime(){
    $montant = preg_replace('/\s/','', $_POST["montant"]);
    $date = $_POST["date"];
    $codeCamion = $_POST["codeCamion"];
    $libelle = $_POST["libelle"];
    $id_operation = $_POST["id_operation"];
    $status = $_POST["status"];
    $id_prime = $_POST["id_prime"];

    $nom_table = "prime";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté une prime sur le camion de code ".$codeCamion." d'un montant de ".$_POST["montant"]." FCFA, le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié une prime sur le camion de code ".$codeCamion." d'un montant de ".$_POST["montant"]." FCFA, le ".$date_notif." à ".$heure;


    if ($status == 'insert') {
        # code...
        if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
           $insertion = $this->db->query("INSERT INTO prime value ('',".$id_operation.",'".$codeCamion."',CAST('". $date."' AS DATE),".$montant.",'".$libelle."')");
    if ($insertion == true ) {
        # code...
        echo "Enregistrement de la prime réussi";
        $this->notificationAjout($nom_table,addslashes($message));
    }else{
        echo "Erreur lors de l'insertion";
    }
    }
    }elseif ($status == 'update') {
        # code...
    if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
           $update = $this->db->query("UPDATE prime set  id_operation =".$id_operation.",code_camion='".$codeCamion."',date_prime = CAST('". $date."' AS DATE),montant = ".$montant.",libelle = '".$libelle."' where id_prime=".$id_prime."");
    if ($update == true ) {
        # code...
        echo "Modification de la prime réussi";
        $this->notificationAjout($nom_table,addslashes($message2));
    }else{
        echo "Erreur lors de la modification";
    }
}
    }else{
        echo "Erreur veuillez contacter l'administrateur";
    }
    
    $this->db->close();
}


public function selectAllFraisRoute(){

    if (isset($_POST["date_debut"]) && isset($_POST["date_fin"])) {
        # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        if (!empty($date_fin) && !empty($date_debut)) {
            # code...
           $query1 = $this->db->query('SELECT * from frais_route where date_frais between "'.$date_debut.'" and "'.$date_fin.'" order by date_frais ')->result_array(); 
        }else{
            $query1 = $this->db->query('SELECT * from frais_route order by date_frais desc limit 900')->result_array();
        }
    }else{
       $query1 = $this->db->query('SELECT * from frais_route order by date_frais desc limit 1000')->result_array();
    }

         
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                    $getOperation = $this->db->query("SELECT * FROM operation where id_operation = ".$row['id_operation']."")->result_array();
                    $getDistance = $this->db->query("SELECT * FROM distance_littrage where id_distance = ".$row['id_distance']."")->row();
                    if (count($getDistance)>0) {
                        # code...
                        $distance = $getDistance->distance;
                    }else{
                        $distance = "";
                    }
                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_op']."</td>";
                        }
                    }
                    
                    echo"

                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    
                    <td>".$row['code_camion']."</td>
                    <td>".$row['commentaire']."</td>
                     <td>".addslashes($distance)."</td>
                    <td>".$row['date_frais']."</td>
                    <td>";

            if($this->session->userdata('depense_modification')=='true'){
                   echo" <button type='button'  onclick=\"infoFraisRoute('".$row['montant']." ','".$row['distance']."','".$row['date_frais']."','".$row['code_camion']."','".$row['id_operation']."',".$row['id_frais_route'].",'".$row['commentaire']."','".$row['id_distance']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }

            if($this->session->userdata('depense_suppression')=='true'){
                  echo"  <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='frais_route' identifiant='".$row['id_frais_route']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_frais_route\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
              }
                  $compteur++;
        }

        $this->db->close();
    }

public function getOperation($id_operation){
    $getOperation = $this->db->query("SELECT * FROM operation where id_operation = ".$id_operation."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            return $tab['nom_op'];
                        }
                    }

                $this->db->close();
}
public function addFraisRoute(){
    $destination = addslashes( $_POST['destination']);
    $commentaire = addslashes($_POST['commentaire']);
    $montant = preg_replace('/\s/','', $_POST["montant"]);
    $date = $_POST["date"];
    $codeCamion = $_POST["codeCamion"];
    $distance = $_POST["distance"];
    $id_operation = $_POST["id_operation"];
    $status = $_POST["status"];
    $id_frais_route = $_POST["id_frais_route"];

    $nom_table = "frais_route";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté un frais de route sur le camion de code ".$codeCamion." d'un montant de ".$_POST["montant"]." FCFA, pour l'opération ".$this->getOperation($id_operation)." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié un frais de route  sur le camion de code ".$codeCamion." d'un montant de ".$_POST["montant"]." FCFA, pour l'opération ".$this->getOperation($id_operation)." le ".$date_notif." à ".$heure;

    if ($status == 'insert') {
        # code...
        if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
           $insertion = $this->db->query("INSERT INTO frais_route value ('',".$id_operation.",'".$codeCamion."',CAST('". $date."' AS DATE),".$montant.",'".$distance."','".$commentaire."',".$destination.")");
    if ($insertion == true ) {
        # code...
        echo "Frais de route enregistré";
        $this->notificationAjout($nom_table,addslashes($message));
    }else{
        echo "Erreur lors de l'insertion";
    }
    }
    }elseif ($status == 'update') {
        # code...
    if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
           $update = $this->db->query("UPDATE frais_route set  id_operation =".$id_operation.",code_camion='".$codeCamion."',date_frais = CAST('". $date."' AS DATE),montant = ".$montant.",distance = ".$distance.", commentaire='".$commentaire."',id_distance = ".$destination." where id_frais_route=".$id_frais_route."");
    if ($update == true ) {
        # code...
        echo "Frais de route modifié";
        $this->notificationAjout($nom_table,addslashes($message2));
    }else{
        echo "Erreur lors de la modification";
    }
    }
    }else{
        echo "Erreur veuillez contacter l'administrateur";
    }

    $this->db->close();
}



public function selectAllFraisDivers(){

        if (isset($_POST["date_debut"]) && isset($_POST["date_fin"])) {
        # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        if (!empty($date_fin) && !empty($date_debut)) {
            # code...
           $query1 = $this->db->query('SELECT * from frais_divers where date_frais between "'.$date_debut.'" and "'.$date_fin.'" order by date_frais ')->result_array(); 
        }else{
            $query1 = $this->db->query('SELECT * from frais_divers order by date_frais desc limit 900')->result_array();
        }
    }else{
       $query1 = $this->db->query('SELECT * from frais_divers order by date_frais desc limit 1000')->result_array();
    }

         
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                    $getOperation = $this->db->query("SELECT * FROM operation where id_operation = ".$row['id_operation']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_op']."</td>";
                        }
                    }
                    
                    echo"

                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td>".$row['code_camion']."</td>
                    <td>".$row['commentaire']."</td>
                   
                    <td>".$row['date_frais']."</td>
                    <td>";
                if($this->session->userdata('depense_modification')=='true'){
                    echo "<button type='button'  onclick=\"infoFraisRoute('".$row['montant']." ','','".$row['date_frais']."','".$row['code_camion']."','".$row['id_operation']."',".$row['id_frais_divers'].",'".addslashes($row['commentaire'])."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }

                if($this->session->userdata('depense_modification')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='frais_divers' identifiant='".$row['id_frais_divers']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_frais_divers\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
        }

        $this->db->close();
    }
	
	
	


public function selectAllFraisAchats(){

        if (isset($_POST["date_debut"]) && isset($_POST["date_fin"])) {
        # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        if (!empty($date_fin) && !empty($date_debut)) {
            # code...
           $query1 = $this->db->query('SELECT * from frais_achat where date_frais between "'.$date_debut.'" and "'.$date_fin.'" order by date_frais ')->result_array(); 
        }else{
            $query1 = $this->db->query('SELECT * from frais_achat order by date_frais desc limit 900')->result_array();
        }
    }else{
       $query1 = $this->db->query('SELECT * from frais_achat order by date_frais desc limit 1000')->result_array();
    }

         
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    <td> ".$compteur."</td>
                    <td>".$row['numero']."</td>
					<td>".$row['voyage']."</td>";
				
					 $getFournisseur = $this->db->query("SELECT * FROM fournisseur_matiere where id_fournisseur = ".$row['id_fournisseur']."")->result_array();

                    if (count($getFournisseur)>0) {
                        # code...
                        foreach ($getFournisseur as $tab) {
                            # code...
                            echo"<td>".$tab['nom']."</td>";
                        }
                    }
                    
                    $getOperation = $this->db->query("SELECT * FROM operation where id_operation = ".$row['id_operation']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_op']."</td>";
                        }
                    }
                    
                    echo"
					<td>".$row['code_camion']."</td>
					<td>".$row['type']."</td>
					<td>".$row['quantite']."</td>
                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td>".number_format($row['total'],0,',',' ')."</td>
					<td>".$row['date_frais']."</td>
					<td>".$row['facture']."</td>";
					 
					   
					
					$getOperation = $this->db->query("SELECT * FROM operation where id_operation = ".$row['id_operation']."")->result_array();

                    if (count($getOperation)>0) {
                       
                        foreach ($getOperation as $tab) {
                           
                        //     echo"<td>".$tab['facture']."</td>"; 
                        }
                    } 
					
					
                    
                    echo"
                    <td>".$row['commentaire']."</td>
                   
                    <td>";
                if($this->session->userdata('mira_sa_modification')=='true'){
                    echo "<button type='button'  onclick=\"infoFraisAchat('".$row['montant']."','".$row['date_frais']."','".$row['code_camion']."','".$row['id_operation']."',".$row['id_frais_achat'].",'".addslashes($row['commentaire'])."','".$row['numero']."','".$row['id_fournisseur']."','".$row['facture']."','".$row['type']."','".$row['total']."','".$row['quantite']."','".$row['voyage']."' )\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }

                if($this->session->userdata('mira_sa_modification')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='frais_achat' identifiant='".$row['id_frais_achat']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_frais_achat\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
        }

        $this->db->close();
    }

public function addFraisDivers(){
    $montant = preg_replace('/\s/','', $_POST["montant"]);
    $date = $_POST["date"];
    $codeCamion = $_POST["codeCamion"];
    $commentaire = addslashes($_POST["commentaire"]);
    $id_operation = $_POST["id_operation"];
    $status = $_POST["status"];
    $id_frais_divers = $_POST["id_frais_divers"];

    $nom_table = "frais_divers";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté un frais divers sur le camion de code ".$codeCamion." d'un montant de ".$_POST["montant"]." FCFA, pour l'opération ".$this->getOperation($id_operation)." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié un frais divers sur le camion de code ".$codeCamion." d'un montant de ".$_POST["montant"]." FCFA,pour l'opération ".$this->getOperation($id_operation)." le ".$date_notif." à ".$heure;

    if ($status == 'insert') {
        # code...
    if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
           $insertion = $this->db->query("INSERT INTO frais_divers value ('',".$id_operation.",'".$codeCamion."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."')");
            if ($insertion == true ) {
                # code...
                echo "Frais divers enregistré";
                $this->notificationAjout($nom_table,addslashes($message));
            }else{
                echo "Erreur lors de l'insertion";
            }
     }
    }elseif ($status == 'update') {
        # code...
    if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
           $update = $this->db->query("UPDATE frais_divers set  id_operation =".$id_operation.",code_camion='".$codeCamion."',date_frais = CAST('". $date."' AS DATE),montant = ".$montant.", commentaire='".$commentaire."' where id_frais_divers=".$id_frais_divers."");
    if ($update == true ) {
        # code...
        echo "Frais divers modifié";
        $this->notificationAjout($nom_table,addslashes($message2));
    }else{
        echo "Erreur lors de la modification";
    }
    }
    }else{
        echo "Erreur veuillez contacter l'administrateur";
    }

    $this->db->close();
}

public function addFraisAchat(){
    $montant = preg_replace('/\s/','', $_POST["montant"]);
    $date = $_POST["date"];
    $codeCamion = $_POST["codeCamion"];
    $commentaire = addslashes($_POST["commentaire"]);
    $id_operation = $_POST["id_operation"];
    $status = $_POST["status"];
    $id_frais_divers = $_POST["id_frais_divers"];
	$fournisseur= $_POST["fournisseur"];
    $numero = $_POST["numero"];
    $facture = $_POST["facture"];
	$validite= $_POST["validite"];
    $quantite = $_POST["quantite"];
	$voyage = $_POST["voyage"];
    $montant1 = $quantite * $montant;
	

    $nom_table = "frais_achat";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté un frais divers sur le camion de code ".$codeCamion." d'un montant de ".$_POST["montant"]." FCFA, pour l'opération ".$this->getOperation($id_operation)." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié un frais divers sur le camion de code ".$codeCamion." d'un montant de ".$_POST["montant"]." FCFA,pour l'opération ".$this->getOperation($id_operation)." le ".$date_notif." à ".$heure;

    if ($status == 'insert') {
        # code...
    if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
           $insertion = $this->db->query("INSERT INTO frais_achat value ('',".$id_operation.",'".$codeCamion."',".$fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."','".$facture."','".$validite."',".$montant1.",".$quantite.",'".$voyage."')");
            if ($insertion == true ) {
                # code...
                echo "Frais achat enregistré";
                $this->notificationAjout($nom_table,addslashes($message));
            }else{
                echo "Erreur lors de l'insertion";
            }
     }
    }elseif ($status == 'update') {
        # code...
    if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
           $update = $this->db->query("UPDATE frais_achat set  id_operation =".$id_operation.",code_camion='".$codeCamion."',id_fournisseur = ".$fournisseur.", numero = '".$numero."',date_frais = CAST('". $date."' AS DATE),montant = ".$montant.", commentaire='".$commentaire."',facture = '".$facture."' ,type = '".$validite."',total = ".$montant1.",quantite = ".$quantite.", voyage = '".$voyage."' where id_frais_achat=".$id_frais_divers."");
    if ($update == true ) {
        # code...
        echo "Frais achat modifié";
        $this->notificationAjout($nom_table,addslashes($message2));
    }else{
        echo "Erreur lors de la modification";
    }
    }
    }else{
        echo "Erreur veuillez contacter l'administrateur";
    }

    $this->db->close();
}



public function getTotal(){
	
    $quantite = $_POST["quantite"];
    
	$montant = $_POST["montant"];

   
    return $quantite*$montant;

   
}


public function getPrixUnitaireArticle(){
    
	$id_article = $_POST["id_article"];
    

    if (empty($id_article)) {
        # code...
        echo "0 ";
    }else{
    
    $getArticle = $this->db->query("SELECT * from article where id_article = ".$id_article."")->row();

    echo $getArticle->prix_unitaire;
        }
    

    $this->db->close();
}

public function getFournisseurArticle1(){
    
	$id_article = $_POST["id_article"];
    

    if (empty($id_article)) {
        # code...
        echo "0 ";
    }else{
    
    $getArticle = $this->db->query("SELECT * from fournisseur_article	where id_fournisseur = (SELECT fournisseur from article where id_article = ".$id_article.")")->row();

    echo $getArticle->nom;
        }
    

    $this->db->close();
}

public function getFournisseurArticle1_1(){
    
	$id_article = $_POST["id_article"];
    

    if (empty($id_article)) {
        # code...
        echo "0 ";
    }else{
    
    $getArticle = $this->db->query("SELECT * from fournisseur_article	where id_fournisseur = (SELECT fournisseur from article where id_article = ".$id_article.")")->row();

    echo $getArticle->id_fournisseur;
        }
    

    $this->db->close();
}


public function getTypeArticle1(){
    
	$id_article = $_POST["id_article"];
    

    if (empty($id_article)) {
        # code...
        echo "0 ";
    }else{
		
	$getArticle = $this->db->query("SELECT * from article 	where  id_article = ".$id_article."")->row();

	$getArticle1 = $this->db->query("SELECT * from approvisionnementpneu where reference = '".$getArticle->article."'")->row();
	
	$getArticle2 = $this->db->query("SELECT * from type_pneu1 where id_type_pneu = ".$getArticle1->id_type_pneu." ")->row();

   echo $getArticle2->nom_type;
   
   // echo $getArticle1->id_type_pneu;
        }
    

    $this->db->close();
}


public function getTailleArticle1(){
    
	$id_article = $_POST["id_article"];
    

    if (empty($id_article)) {
        # code...
        echo "0 ";
    }else{
		
	$getArticle = $this->db->query("SELECT * from article 	where  id_article = ".$id_article."")->row();

	$getArticle1 = $this->db->query("SELECT * from approvisionnementpneu where reference = '".$getArticle->article."'")->row();
	
	$getArticle2 = $this->db->query("SELECT * from type_pneu where id_type_pneu = ".$getArticle1->id_article." ")->row();

   echo $getArticle2->nom_type;
   
   // echo $getArticle1->id_type_pneu;
        }
    

    $this->db->close();
}

public function getMarqueArticle1(){
    
	$id_article = $_POST["id_article"];
    

    if (empty($id_article)) {
        # code...
        echo "0 ";
    }else{
		
	$getArticle = $this->db->query("SELECT * from article 	where  id_article = ".$id_article."")->row();

	$getArticle1 = $this->db->query("SELECT * from approvisionnementpneu where reference = '".$getArticle->article."'")->row();
	
	$getArticle2 = $this->db->query("SELECT * from marque_pneu where id_marque_pneu = ".$getArticle1->id_marque_pneu." ")->row();

   echo $getArticle2->marque;
   
   // echo $getArticle1->id_type_pneu;
        }
    

    $this->db->close();
}



public function getPrixUnitaireArticleHuile(){
    $id_article = $_POST["id_article"];
    

    if (empty($id_article)) {
        # code...
        echo "0 ";
    }else{
    
    $getArticle = $this->db->query("SELECT * from type_huile where id_type = ".$id_article."")->row();

    echo $getArticle->PU;
        }
    

    $this->db->close();
}

public function getReferenceArticle(){
    $id_article = $_POST["id_article"];

    if (empty($id_article)) {
        # code...
        echo "0 ";
    }else{
 
    $getArticle = $this->db->query("SELECT * from article where id_article = ".$id_article."")->row();

    echo $getArticle->code_a_barre;
        
    }

    $this->db->close();
}

public function getStockArticle(){
	
    $id_article = $_POST["id_article"];
	
	 $date = $_POST["date"];
	
	$app = 0;
	
	$def = 0;
	
	$sort = 0;
	

    if (empty($id_article)) {
        # code...
        echo "0 ";
    }else{
 
  
    $getApp = $this->db->query("SELECT sum(qtite) as sum_app from approvisionnement where id_article = ".$id_article." and date_app between '2023-11-13' and '".$date."' ")->row();

    if (count($getApp) >0) {
	$app =  $getApp->sum_app;	
	}else{	
	
	$app =  0;
	}
	
	$getSort = $this->db->query("SELECT sum(qtite) as sum_sort from piece_rechange where id_article = ".$id_article." and date_rech between '2023-11-13' and '".$date."' ")->row();

    if (count($getSort) >0) {
	$sort =  $getSort->sum_sort;	
	}else{	
	
	$sort =  0;	
	}
	
	$getDef = $this->db->query("SELECT sum(qtite) as sum_def from defectueux where id_article = ".$id_article." and  date_def between '2023-11-13' and '".$date."' ")->row();

    if (count($getDef) >0) {
	$def =  $getDef->sum_def;	
	}else{	
	
	$def =  0;	
	}

	echo $app - $sort - $def;
	
        
    }

    $this->db->close();
}

public function getStockHuile(){
	
    $id_type = $_POST["id_type"];
	
	 $date = $_POST["date"];
	
	$app = 0;
	
	$def = 0;
	
	$sort = 0;
	

    if (empty($id_type)) {
        # code...
        echo "0 ";
    }else{
 
  
    $getApp = $this->db->query("SELECT sum(qtite) as sum_app from approvisionnementhuile where id_article = ".$id_type." and date_app between '2023-11-01' and '".$date."' ")->row();

    if (count($getApp) >0) {
	$app =  $getApp->sum_app;	
	}else{	
	
	$app =  0;
	}
	
	$getSort = $this->db->query("SELECT sum(qtite) as sum_sort from vidange where id_type_huile = ".$id_type." and date_vidange between '2023-11-01' and '".$date."' ")->row();

    if (count($getSort) >0) {
	$sort =  $getSort->sum_sort;	
	}else{	
	
	$sort =  0;	
	}
	
	

	echo $app - $sort ;
	
        
    }

    $this->db->close();
}

public function getStockHuileB(){
	
    $id_type = $_POST["id_type"];
	
	 $date = $_POST["date"];
	
	$app = 0;
	
	$def = 0;
	
	$sort = 0;
	

    if (empty($id_type)) {
        # code...
        echo "0 ";
    }else{
 
  
    $getApp = $this->db->query("SELECT sum(qtite) as sum_app from approvisionnementhuile where id_article = ".$id_type." and date_app between '2023-11-01' and '".$date."' ")->row();

    if (count($getApp) >0) {
	$app =  $getApp->sum_app;	
	}else{	
	
	$app =  0;
	}
	
	$getSort = $this->db->query("SELECT sum(qtite) as sum_sort from vidangeboite where id_type_huile = ".$id_type." and date_vidange between '2023-11-01' and '".$date."' ")->row();

    if (count($getSort) >0) {
	$sort =  $getSort->sum_sort;	
	}else{	
	
	$sort =  0;	
	}
	
	

	echo $app - $sort ;
	
        
    }

    $this->db->close();
}

public function getStockHuileH(){
	
    $id_type = $_POST["id_type"];
	
	 $date = $_POST["date"];
	
	$app = 0;
	
	$def = 0;
	
	$sort = 0;
	

    if (empty($id_type)) {
        # code...
        echo "0 ";
    }else{
 
  
    $getApp = $this->db->query("SELECT sum(qtite) as sum_app from approvisionnementhuile where id_article = ".$id_type." and date_app between '2023-11-01' and '".$date."' ")->row();

    if (count($getApp) >0) {
	$app =  $getApp->sum_app;	
	}else{	
	
	$app =  0;
	}
	
	$getSort = $this->db->query("SELECT sum(qtite) as sum_sort from vidangehydrolique where id_type_huile = ".$id_type." and date_vidange between '2023-11-01' and '".$date."' ")->row();

    if (count($getSort) >0) {
	$sort =  $getSort->sum_sort;	
	}else{	
	
	$sort =  0;	
	}
	
	

	echo $app - $sort ;
	
        
    }

    $this->db->close();
}


public function getStockGraisseV(){
	
    $id_type = $_POST["id_type"];
	
	 $date = $_POST["date"];
	
	$app = 0;
	
	$def = 0;
	
	$sort = 0;
	

    if (empty($id_type)) {
        # code...
        echo "0 ";
    }else{
 
  
    $getApp = $this->db->query("SELECT sum(qtite) as sum_app from approvisionnementhuile where id_article = ".$id_type." and date_app between '2023-11-01' and '".$date."' ")->row();

    if (count($getApp) >0) {
	$app =  $getApp->sum_app;	
	}else{	
	
	$app =  0;
	}
	
	$getSort = $this->db->query("SELECT sum(qtite) as sum_sort from vidangegraisse where id_type_huile = ".$id_type." and date_vidange between '2023-11-01' and '".$date."' ")->row();

    if (count($getSort) >0) {
	$sort =  $getSort->sum_sort;	
	}else{	
	
	$sort =  0;	
	}
	
	

	echo $app - $sort ;
	
        
    }

    $this->db->close();
}



public function getReferenceArticle1(){
    $id_article = $_POST["id_article"];

    if (empty($id_article)) {
        # code...
        echo "0 ";
    }else{
 
    $getArticle = $this->db->query("SELECT * from article where id_article = ".$id_article."")->row();

    echo $getArticle->reference;
        
    }

    $this->db->close();
}

public function getMatriculeVehicule1(){
	
    $id_camion = $_POST["id_camion"];

    
		
		        $getTracteur = $this->db->query("SELECT * from tracteur WHERE code ='".$id_camion."' ")->row();
				
                $getCamionBenne = $this->db->query("SELECT * from camion_benne WHERE code ='".$id_camion."'")->row();
                
				$getEngin = $this->db->query("SELECT * from engin WHERE code ='".$id_camion."'")->row();
				
                $getVraquier = $this->db->query("SELECT * from vraquier WHERE code ='".$id_camion."'")->row();
				
				    
        if (count($getTracteur) >0) {
			
			
			
			echo "<option value=''></option>";
			
			
                # code...
                echo "<option value=".$getTracteur->immatriculation.">".$getTracteur->immatriculation."</option>";
            
           
           
        
		$query = $this->db->query("SELECT * from remorque WHERE id_remorque =".$getTracteur->id_remorque."")->row();
			
			 
              
			   
			   
                # code...
               echo "<option value=".$query->immatriculation.">".$query->immatriculation."</option>";
          
               
           
			
        }else{
            
        }
		
		
        if (count($getCamionBenne) >0) {
			
            # code...
           
               echo "<option value=''></option>";
			   
			   
                # code...
               echo "<option value=".$getCamionBenne->immatriculation.">".$getCamionBenne->immatriculation."</option>";
          
               
           
        }else{
            
        }
         
        if (count($getEngin) >0) {
			
            # code...
            
              echo "<option value=''></option>";
			  
			  
                # code...
             echo "<option value=".$getEngin->immatriculation.">".$getEngin->immatriculation."</option>";
            
               
           
          
        }else{
            
        }
        
       
        if (count($getVraquier) >0) {
			
			echo "<option value=''></option>";
			
			
                # code...
              echo "<option value=".$getVraquier->immatriculation.">".$getVraquier->immatriculation."</option>"; 
			  
           
	
              
			   
        }else{
            
        }
        
        
             
						
						 $this->db->close();
                        
                    }
					
	

public function getMatriculeVehicule1_1(){
	
    $camion1 = $_POST["camion1"];

    
		
		        $getTracteur = $this->db->query("SELECT * from tracteur WHERE code ='".$camion1."' ")->row();
				
                $getCamionBenne = $this->db->query("SELECT * from camion_benne WHERE code ='".$camion1."'")->row();
                
				$getEngin = $this->db->query("SELECT * from engin WHERE code ='".$camion1."'")->row();
				
                $getVraquier = $this->db->query("SELECT * from vraquier WHERE code ='".$camion1."'")->row();
				
				    
        if (count($getTracteur) >0) {
			
			
			
			
			  echo  $getTracteur->immatriculation ;
			
                # code...
             //   echo "<option value=".$getTracteur->immatriculation.">".$getTracteur->immatriculation."</option>";
            
           
           
        
		
           
			
        }else{
            
        }
		
		
        if (count($getCamionBenne) >0) {
			
            # code...
           
               echo  $getCamionBenne->immatriculation ;
			
               
           
        }else{
            
        }
         
        if (count($getEngin) >0) {
			
            # code...
           echo  $getEngin->immatriculation ;
			
               
           
               
           
          
        }else{
            
        }
        
       
        if (count($getVraquier) >0) {
			
			 # code...
           echo  $getVraquier->immatriculation ;
			
           
	
              
			   
        }else{
            
        }
        
        
             
						
						 $this->db->close();
                        
                    }	
					
	public function getMatriculeVehicule3(){
	
    $camion1 = $_POST["camion1"];

    
		
		        $getTracteur = $this->db->query("SELECT * from tracteur WHERE code ='".$camion1."' ")->row();
				
                $getCamionBenne = $this->db->query("SELECT * from camion_benne WHERE code ='".$camion1."'")->row();
                
				
				    
        if (count($getTracteur) >0) {	
			
                # code...
                echo "<option value=".$getTracteur->immatriculation.">".$getTracteur->immatriculation."</option>";
             
		
        }else{
            
        }
		
		
        if (count($getCamionBenne) >0) {
			
	   
                # code...
               echo "<option value=".$getCamionBenne->immatriculation.">".$getCamionBenne->immatriculation."</option>";
          
               
           
        }else{
            
        }
                   
						
						 $this->db->close();
                        
                    }
					

	
public function getTypeVehicule3(){
	
    $camion1 = $_POST["camion1"];

    $type_camion = '';
		
		        $getTracteur = $this->db->query("SELECT * from tracteur WHERE code ='".$camion1."' ")->row();
				
                $getCamionBenne = $this->db->query("SELECT * from camion_benne WHERE code ='".$camion1."'")->row();
                
				
				    
        if (count($getTracteur) >0) {	
		
		
		$getTypeVehicule = $this->db->query("SELECT * from type_vehicule WHERE id_type =".$getTracteur->id_type_camion." ")->row();
		
		
			echo "<option value='".$getTypeVehicule->id_type_camion."'>".$getTypeVehicule->nom_type."</option>";
		       
		
        }else{
            
        }
		
		
        if (count($getCamionBenne) >0) {
			
			$getTypeVehicule = $this->db->query("SELECT * from type_vehicule WHERE id_type =".$getCamionBenne->id_type_camion." ")->row();
			
			echo "<option value='".$getTypeVehicule->id_type."'>".$getTypeVehicule->nom_type."</option>";
		     
             
           
        }else{
            
        }
         	 
						
			$this->db->close();
                        
                    }
					

public function getTypeVehicule3_1(){
	
    $camion1 = $_POST["camion1"];

    $type_camion = '';
		
		        $getTracteur = $this->db->query("SELECT * from tracteur WHERE code ='".$camion1."' ")->row();
				
                $getCamionBenne = $this->db->query("SELECT * from camion_benne WHERE code ='".$camion1."'")->row();
                
				
				    
        if (count($getTracteur) >0) {	
		
		
		
		
		
			echo $getTracteur->id_type_camion;
		       
		
        }else{
            
        }
		
		
        if (count($getCamionBenne) >0) {
			
			
			
			echo $getCamionBenne->id_type_camion;
           
        }else{
            
        }
         	 
						
			$this->db->close();
                        
                    }
					
					

		public function getNomTypeVehicule3_1(){
			
	
        $camion1 = $_POST["camion1"];

  
		
		 $getTypeCamion = $this->db->query("SELECT * from type_vehicule WHERE id_type = (SELECT id_type_camion from tracteur where code ='".$camion1."')")->row();
				
       		    
        if (count($getTypeCamion) >0) {	
				
			echo $getTypeCamion->nom_type;
			
        }else{
            
        }
		
		
		 $getTypeCamion1 = $this->db->query("SELECT * from type_vehicule WHERE id_type = (SELECT id_type_camion from camion_benne where code ='".$camion1."')")->row();
				
       		    
        if (count($getTypeCamion1) >0) {	
				
			echo $getTypeCamion1->nom_type;
			
        }else{
            
        }
		
			 $getTypeCamion1 = $this->db->query("SELECT * from type_vehicule WHERE id_type = (SELECT id_type_camion from engin where code ='".$camion1."')")->row();
				
       		    
        if (count($getTypeCamion1) >0) {	
				
			echo $getTypeCamion1->nom_type;
			
        }else{
            
        }
		
						
		$this->db->close();
                        
    }
	
					
	public function getMatriculeVehicule2(){
	
    $immatriculation = str_replace(' ', '', $_POST["immatriculation"]);

    
		
		        $getTracteur = $this->db->query("SELECT * from tracteur WHERE immatriculation ='".$immatriculation."' ")->row();
				
				$getRemorque = $this->db->query("SELECT * from remorque WHERE immatriculation ='".$immatriculation."' ")->row();
				
                $getCamionBenne = $this->db->query("SELECT * from camion_benne WHERE immatriculation ='".$immatriculation."'")->row();
                
				$getEngin = $this->db->query("SELECT * from engin WHERE immatriculation ='".$immatriculation."'")->row();
				
                $getVraquier = $this->db->query("SELECT * from vraquier WHERE immatriculation ='".$immatriculation."'")->row();
				
				    
        if (count($getTracteur) >0) {
			
			
 
			
			echo $getTracteur->immatriculation;
           
        }else{
            
        }  
		 if (count($getRemorque) >0) {
			
	echo $getRemorque->immatriculation;
			
        }else{
            
        }
		
		
        if (count($getCamionBenne) >0) {
			
            # code...
           
echo $getCamionBenne->immatriculation;

        }else{
            
        }
         
        if (count($getEngin) >0) {
			
            # code...
            
     echo $getEngin->immatriculation;
          
        }else{
            
        }
        
       
        if (count($getVraquier) >0) {
	
	  echo $getVraquier->immatriculation;
	  
        }else{
            
        }
        
        
             
						
						 $this->db->close();
                        
                    }
  

public function getReferenceArticleGazoil(){
    $id_article = $_POST["id_article"];

    if (empty($id_article)) {
        # code...
        echo "0 ";
    }else{
 
    $getArticle = $this->db->query("SELECT * from article where id_article = ".$id_article."")->row();

    echo $getArticle->code_a_barre;
        
    }

    $this->db->close();
}

public function getReferenceArticleHuile(){
    $id_article = $_POST["id_article"];

    if (empty($id_article)) {
        # code...
        echo "0 ";
    }else{
 
    $getArticle = $this->db->query("SELECT * from type_huile where id_type = ".$id_article."")->row();

    echo $getArticle->huile;
        
    }

    $this->db->close();
}

public function selectAllVidange(){

    if (isset($_POST["date_debut"]) && isset($_POST["date_fin"])) {
        # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
		
        if (!empty($date_fin) && !empty($date_debut)) {
            # code...
           $query1 = $this->db->query('SELECT * from vidange where date_vidange between "'.$date_debut.'" and "'.$date_fin.'" order by date_vidange ')->result_array(); 
        }else{
            $query1 = $this->db->query('SELECT * from vidange order by date_vidange desc limit 900')->result_array();
        }
    }else{
      $query1 = $this->db->query('SELECT * from vidange order by date_vidange desc limit 1000')->result_array();
    }

         
         $compteur = 0;
		 $compteur1 = 0;
		 $compteur2 = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                    $getOperation = $this->db->query("SELECT * FROM operation where id_operation = ".$row['id_operation']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_op']."</td>
                            <td>".$row['code_camion']."</td>
                            <td>".$this->getKilometrageVehicule($row['code_camion'])."</td>";
							
							$getFournisseurArticle = $this->db->query("SELECT * from fournisseur_article where id_fournisseur = ".$row['id_fournisseur']." limit 1")->row();
                             if (count($getFournisseurArticle) >0) {
                                 # code...
                                 echo " <td>".$getFournisseurArticle->nom." </td>";
                             }else{
                                echo "<td></td>";
							 
							
                        }
                        }
                   }

                    $getOperation = $this->db->query("SELECT * FROM type_huile where id_type = ".$row['id_type_huile']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                           $compteur1 =$compteur1 + $row["qtite"];
							
                            $prixTotal = $row["pu"]*$row["qtite"];
							
							$compteur2=$compteur2+ $prixTotal;
                           // $prixTotal = $row['pu']*$row["qtite"];
                            echo"<td>".$tab['huile']."</td>
                            <td>".number_format($row['pu'],0,',',' ')." </td>
                            <td>".$row['qtite']." L</td>
                            <td>".number_format($prixTotal,0,',',' ')." </td>";
                        }
                    }
                    
                    echo"
                    <td>".number_format($row['dernier_kilometrage'],0,',',' ')." </td>
                    <td>".$row['date_vidange']."</td>
                    <td>";

             if($this->session->userdata('vidange_modification')=='true'){
                    echo"<button type='button'  onclick=\"infoVidange('".$row['id_type_huile']." ','".$row['commentaire']."','".$row['date_vidange']."','".$row['code_camion']."','".$row['id_operation']."',".$row['id_vidange'].",".$row['qtite'].",".$row['dernier_kilometrage'].",".$row['pu'].",".$row['id_fournisseur'].")\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }
            if($this->session->userdata('vidange_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='vidange' identifiant='".$row['id_vidange']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_vidange\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
              }
                  $compteur++;
        }
		
		
	echo "<tr>
        <td style='color:red;font-size: 20px;text-align:center; border: 2px solid black; font-weight: bold;'>TOTAUX</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
		<td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
       <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteur1,0,',',' ')."</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteur2,0,',',' ')."</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>

	</tr>";
		
		
	

        $this->db->close();
    }

public function getKilometrageVehicule($code){

    $getTracteur = $this->db->query("SELECT * from tracteur where code ='".$code."'")->row();
    $getCamion = $this->db->query("SELECT * from camion_benne where code ='".$code."'")->row();
    $getEngin = $this->db->query("SELECT * from engin where code ='".$code."'")->row();

    if (count($getTracteur)>0) {

        return $getTracteur->kilometrage;
    }elseif (count($getCamion)>0) {

        return $getCamion->kilometrage;
    }elseif (count($getEngin)>0) {

       return $getEngin->kilometrage;
    }else{
        return 0;
    }

    $this->db->close();
}


public function addVidange(){
    $pu = intval(preg_replace('/\s/','', $_POST["PU"])); 
    $kilometrage = $_POST["kilometrage"];
    $commentaire = $_POST["commentaire"];
    $date = $_POST["date"];
    $codeCamion = $_POST["codeCamion"];
    $huile = $_POST["huile"];
    $id_operation = $_POST["id_operation"];
	$id_fournisseur = $_POST["id_fournisseur"];
    $status = $_POST["status"];
    $id_frais_divers = $_POST["id_frais_divers"];
    $qtite = $_POST["qtite"];

    $montant = $qtite*$pu;
    $nom_table = "vidange";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté une vidange sur le camion de code ".$codeCamion." avec l'huile ".$huile." d'un montant de ".$montant." FCFA, pour l'opération ".$this->getOperation($id_operation)." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié une vidange sur le camion de code ".$codeCamion." avec l'huile ".$huile." d'un montant de ".$montant." FCFA, pour l'opération ".$this->getOperation($id_operation)." le ".$date_notif." à ".$heure;

    if ($status == 'insert') {
        # code...

    // $verifHuile = $this->db->query("SELECT * FROM vidange where id_type_huile = '".$huile."'")->result_array();

   if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
            // $insertion = $this->db->query("INSERT INTO vidange value ('',".$id_operation.",'".$codeCamion."',CAST('". $date."' AS DATE),".$huile.",'".$commentaire."',".$qtite.",".$this->getKilometrageVehicule($codeCamion).")");
            $insertion = $this->db->query("INSERT INTO vidange value ('',".$id_operation.",'".$codeCamion."',CAST('". $date."' AS DATE),".$huile.",'".$commentaire."',".$qtite.",".$kilometrage.",".$pu.",".$id_fournisseur.")");
        if ($insertion == true ) {
            # code...
            echo "Vidange enregistrée";
            $this->notificationAjout($nom_table,addslashes($message));
        }else{
            echo "Erreur lors de l'insertion";
        } 
    
      }
    }elseif ($status == 'update') {
        # code...

    // $verifHuile = $this->db->query("SELECT * FROM vidange where id_type_huile = ".$huile."")->result_array();

   if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
                 $update = $this->db->query("UPDATE vidange set  id_operation =".$id_operation.",code_camion='".$codeCamion."',date_vidange = CAST('". $date."' AS DATE),id_type_huile = ".$huile.",commentaire = '".$commentaire."', qtite =".$qtite.",dernier_kilometrage=".$kilometrage.",pu=".$pu.", id_fournisseur=".$id_fournisseur." where id_vidange=".$id_frais_divers."");
                if ($update == true ) {
                    # code...
                    echo "Vidange modifiée";
                    $this->notificationAjout($nom_table,addslashes($message2));
                }else{
                    echo "Erreur lors de la modification";
                }
       }   
    }else{
        echo "Erreur veuillez contacter l'administrateur";
    }

    $this->db->close();
}




// pieces de rechange

public function getArticlePourModifPiece(){
    $id_fournisseur = $_POST['id_article'];

    $query1 = $this->db->query('SELECT * from article ')->result_array();
   
    if (count($query1)>0) {
        # code...
         $query2 = $this->db->query('SELECT * from article where id_article ='.$id_fournisseur.'')->row();
        echo "<option value='".$query2->id_article."'>".$query2->article."</option>";
        foreach ($query1 as $row) {
            # code...
        
              echo "<option value='".$row["id_article"]."'>".$row["article"]."</option>";   
            
           
        }
    }

    $this->db->close();
}


public function getFournisseurPourModifPiece(){
    $id_fournisseur = $_POST['id_fournisseur'];

    $query1 = $this->db->query('SELECT * from fournisseur_article ')->result_array();

    if (count($query1)>0) {
        # code...*
         $query2 = $this->db->query('SELECT * from fournisseur_article where id_fournisseur ='.$id_fournisseur.'')->row();
        echo "<option value='".$query2->id_fournisseur."'>".$query2->nom."</option>";
        foreach ($query1 as $row) {
          
            echo "<option value='".$row["id_fournisseur"]."'>".$row["nom"]."</option>";
        }
    }

    $this->db->close();
}

// public function getDestinationPourModifGazoil(){
//     $id_distance = $_POST['id_distance'];

//     $query2 = $this->db->query('SELECT * from distance_littrage where id_distance ='.$id_distance.'')->row();
//         echo "<option value='".$query2->id_distance."'>".$query2->distance."</option>";
//     $this->crud_model_depense->getDistanceParCodeCamion();
// }
public function getArticle($id_article){
    $getArticle = $this->db->query("SELECT * from article where id_article = ".$id_article."")->row();
    if (count($getArticle)>0) {
        # code...
        return $getArticle->article;
    }
}
public function addPieceRechange(){
    $pu = intval(preg_replace('/\s/','', $_POST["pu"])); 
    $origine = $_POST["origine"];
    $tva = $_POST["tva"];
    $id_article = $_POST["article"];
    $date = $_POST["date"];
	$bon_sortie = $_POST["bon_sortie"];
    $codeCamion = $_POST["codeCamion"];
    $distance = addslashes($_POST["commentaire"]);
    $id_operation = $_POST["id_operation"];
    $status = $_POST["status"];
    $id_frais_divers = $_POST["id_frais_divers"];
    $id_fournisseur = $_POST["id_fournisseur"];
    $qtite = $_POST["qtite"];

    $montant = $qtite*$pu;
    $nom_table = "piece_rechange";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté une pièce de rechange ".$this->getArticle($id_fournisseur)." sur le camion de code ".$codeCamion." d'un montant de ".$montant." FCFA, pour l'opération ".$this->getOperation($id_operation)." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié une pièce de rechange ".$this->getArticle($id_fournisseur)." sur le camion de code ".$codeCamion." d'un montant de ".$montant." FCFA, pour l'opération ".$this->getOperation($id_operation)." le ".$date_notif." à ".$heure;

    if ($status == 'insert') {
        # code...
        if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
        if ($origine == "interne") {
            # code...
            // $id_fournisseur = "null";
            $insertion = $this->db->query("INSERT INTO piece_rechange value ('',".$id_operation.",".$id_article.",".$id_fournisseur.",'".$codeCamion."',CAST('". $date."' AS DATE),'".$distance."',".$qtite.",'".$origine."',".$pu.",'".$tva."','".$bon_sortie."')");
        }else{
            $insertion = $this->db->query("INSERT INTO piece_rechange value ('',".$id_operation.",".$id_article.",".$id_fournisseur.",'".$codeCamion."',CAST('". $date."' AS DATE),'".$distance."',".$qtite.",'".$origine."',".$pu.",'".$tva."','".$bon_sortie."')");
        }
           
    if ($insertion == true ) {
        # code...
        echo "Pièce de rechange ajoutée";
        $this->notificationAjout($nom_table,addslashes($message));
    }else{
        echo "Erreur lors de l'insertion";
    }
    }
    }elseif ($status == 'update') {
        # code...
        if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
        if ($origine == "interne") {
            # code...
            // $id_fournisseur = "null";
            $update = $this->db->query("UPDATE piece_rechange set  id_operation =".$id_operation.",id_article=".$id_article.",code_camion='".$codeCamion."',date_rech = CAST('". $date."' AS DATE),commentaire = '".$distance."', qtite=".$qtite.", prix_unitaire=".$pu.",origine='".$origine."',tva='".$tva."',bon_sortie='".$bon_sortie."' where id_rechange=".$id_frais_divers."");
        }else{
           $update = $this->db->query("UPDATE piece_rechange set  id_operation =".$id_operation.",id_article=".$id_article.",code_camion='".$codeCamion."',date_rech = CAST('". $date."' AS DATE),commentaire = '".$distance."', qtite=".$qtite.", prix_unitaire=".$pu.",origine='".$origine."',id_fournisseur_article =".$id_fournisseur.",tva='".$tva."',bon_sortie='".$bon_sortie."' where id_rechange=".$id_frais_divers."");
        }
    if ($update == true ) {
        # code...
        echo "Pièce de rechange modifiée";
        $this->notificationAjout($nom_table,addslashes($message2));
    }else{
        echo "Erreur lors de la modification";
    }
    }
    }else{
        echo "Erreur veuillez contacter l'administrateur";
    }

    $this->db->close();
 
}


public function addDepensePneu(){

    $pu = intval(preg_replace('/\s/','', $_POST["pu"]));


    $id_article = $_POST["article"];
    
    $date = $_POST["date"];
    $codeCamion = $_POST["codeCamion"];
    $commentaire = $_POST["commentaire"];
    $status = $_POST["status"];
    $id_frais_divers = $_POST["id_frais_route"];
 
    $qtite = $_POST["qtite"];
	
	$id_fournisseur = $_POST["id_fournisseur"];

    $montant = $qtite*$pu;
    $nom_table = "depense_pneu";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté une dépense pneu ".$this->getArticle($id_article)." sur le camion de code ".$codeCamion." d'un montant de ".$montant." FCFA, le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié une pièce dépense pneu ".$this->getArticle($id_article)." sur le camion de code ".$codeCamion." d'un montant de ".$montant." FCFA, le ".$date_notif." à ".$heure;
    if ($status == 'insert') {
       
            # code...
            // $id_fournisseur = "null";
            $insertion = $this->db->query("INSERT INTO depense_pneu value ('','".$codeCamion."',".$id_article.",CAST('". $date."' AS DATE),".$qtite.",".$pu.",'".$commentaire."',CAST('". $date."' AS DATE),'AUTRE', ".$id_fournisseur.")");
       
            if ($insertion == true ) {
                # code...
                echo "Pièce de rechange ajoutée";
                $this->notificationAjout($nom_table,addslashes($message));
            }else{
                echo "Erreur lors de l'insertion";
            }
    
    }elseif ($status == 'update') {
        # code...
        
            // $id_fournisseur = "null";
            $update = $this->db->query("UPDATE depense_pneu set  id_article=".$id_article.",code_camion='".$codeCamion."',date_depense = CAST('". $date."' AS DATE),commentaire = '".$commentaire."', qtite=".$qtite.", prix_unitaire=".$pu.",derniereDate =CAST('". $date."' AS DATE),type='".$type."', id_fournisseur='".$id_fournisseur."'  where id_depense=".$id_frais_divers."");
        
        if ($update == true ) {
            # code...
            echo "Pièce de rechange modifiée";
            $this->notificationAjout($nom_table,addslashes($message2));
        }else{
            echo "Erreur lors de la modification";
        }
    
    }else{
        echo "Erreur veuillez contacter l'administrateur";
    }
    $this->db->close();
}

public function addDepensePneu1(){
    //Entete de la commande
	
	$article = json_decode($_POST['article']);
    $quantite = json_decode($_POST['quantite']);
    $pu = json_decode($_POST['pu']);
    $camion = json_decode($_POST['camion']);
	$immatriculation = json_decode($_POST['immatriculation']);
	$immatriculation1 = json_decode($_POST['immatriculation1']);
	$kilometrage_debut = json_decode($_POST['kilometrage_debut']);
	
    $fournisseur = json_decode($_POST['fournisseur']);
	$fournisseur1 = json_decode($_POST['fournisseur1']);
	
    $reference = json_decode($_POST['reference']);
	

   
    $id_prime = json_decode($_POST['id_prime']);
  

 //   $commentaire = $_POST["commentaire"];
    $status = $_POST["status"];
	
	$nbreLigne = $_POST["nbreLigne"];
	
	$datePrime1 = $_POST["datePrime1"];
	
	
	//$month = date( $datePrime1, strtotime( '+6 month' ) );
	
	$month = strtotime($datePrime1);
	
	//date('d-m-Y', $datePrime1);

	$month = strtotime("+6 month", $month);

	$month =date('Y-m-d', $month);
	
// $month = strtotime("+6 month", $datePrime1);

   // $montant = $quantite*$pu;
    $nom_table = "depense_pneu";
	
    
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté un PNEU   le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié un PNEU   le ".$date_notif." à ".$heure;

    if ($status == "insert") {
        # code...
   
    $i = 1;
	
	


    while ( $i<= $nbreLigne) {
		
     
        $verifNumero = $this->db->query("SELECT * from pneu where numero ='".$reference[$i]."'")->result_array();
		
				
				
                if (count($verifNumero)>0) {
                    # code...
                    echo "Ce numéro est déja utilisé par un autre pneu veuillez le changer SVP";
                }else{
					
					$query = $this->db->query(" INSERT into depense_pneu value('','".$camion[$i]."',".$article[$i].",CAST('". $datePrime1."' AS DATE),".$quantite[$i].",".intval(preg_replace('/\s/','', $pu[$i])).",'PNEU CHAUSSE',CAST('". $datePrime1."' AS DATE),'PNEU',".$fournisseur1[$i].")");

		
                    $insert = $this->db->query("INSERT into pneu value('',53,'".$reference[$i]."',CAST('". $datePrime1."' AS DATE),CAST('". $month."' AS DATE),'".$immatriculation1[$i]."','".$kilometrage_debut[$i]."','".$kilometrage_debut[$i]."',NULL,1,0,0,".intval(preg_replace('/\s/','', $pu[$i])).",".$article[$i].")");
                
			
         }
 
      $i++; 
    }

        if ($query == true) {
            # code...
            echo "Insertion parfaite de la depense Pneu";
            $this->notificationAjout($nom_table,addslashes($message));
            
        }else{
            echo "erreur lors de l'insertion";
        }

    }elseif ($status == "update") {
        # code...
         $i = 1;
        while ( $i<= $nbreLignes) {
      // echo "test ".$i." ".$article[$i]." ".$quantite[$i]." ".$pu[$i]." ".$camion[$i]." ".$description[$i]; 

      $query = $this->db->query(" UPDATE depense_pneu set  date_depense= CAST('". $datePrime1."' AS DATE),id_fournisseur_article=".$fournisseur[$i].",  id_article =".$article[$i].", qtite =".$quantite[$i].", pu =".intval(preg_replace('/\s/','', $pu[$i])).", code_camion ='".$camion[$i]."' where id_depense =".$id_prime[$i]."");
     // $query2 = $this->db->query("UPDATE article set code_a_barre = '".addslashes($description[$i])."' where id_article=".$article[$i]."");
      $i++; 
    }

        if ($query == true) {
            # code...
            echo "Modification parfaite de la commande";
            $this->notificationAjout($nom_table,addslashes($message2));

        }else{
            echo "erreur lors de l'insertion";
        }

    }else{
        echo "Erreur fatale contactez l'administrateur";
    }

    $this->db->close();
}


public function recupPUSansTVA($tva,$pu){
  if ($tva=="oui") {
                      # code...
    return $pu/1.1925;
 }else{
  return $pu;
 }

 $this->db->close();
}

public function selectAllPieceRechange(){
   
       if (isset($_POST["date_debut"]) && isset($_POST["date_fin"])) {
        
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $articles1 = $_POST['articles1'];
        $articles2 = $_POST['articles2'];
        $camion1 = $_POST['camion1'];
      
       if (!empty($date_fin) && !empty($date_debut) && !empty($articles1) && !empty($articles2) && !empty($camion1)) {
            # code...
           $query1 = $this->db->query('SELECT * from piece_rechange WHERE id_article =  "'.$articles1.'" and id_operation = "'.$articles2.'" and code_camion = "'.$camion1.'" and date_rech between "'.$date_debut.'" and "'.$date_fin.'"  order by date_rech ')->result_array(); 
        }elseif (!empty($date_fin) && !empty($date_debut) && empty($articles1) && !empty($articles2) && empty($camion1)) {
            # code...
           $query1 = $this->db->query('SELECT * from piece_rechange WHERE id_operation = "'.$articles2.'" and  date_rech between "'.$date_debut.'" and "'.$date_fin.'"  order by date_rech ')->result_array(); 
        }elseif (!empty($date_fin) && !empty($date_debut) && !empty($articles1) && empty($articles2) && empty($camion1)) {
            # code...
           $query1 = $this->db->query('SELECT * from piece_rechange WHERE id_article = "'.$articles1.'" and date_rech between "'.$date_debut.'" and "'.$date_fin.'"  order by date_rech ')->result_array(); 
        }elseif (!empty($date_fin) && !empty($date_debut) && empty($articles1) && empty($articles2) && !empty($camion1)) {
            # code...
           $query1 = $this->db->query('SELECT * from piece_rechange WHERE code_camion = "'.$camion1.'" and date_rech between "'.$date_debut.'" and "'.$date_fin.'"  order by date_rech ')->result_array(); 
        }elseif (!empty($date_fin) && !empty($date_debut) && empty($articles1) && empty($articles2) && empty($camion1)){
           $query1 = $this->db->query('SELECT * from piece_rechange WHERE date_rech between "'.$date_debut.'" and "'.$date_fin.'" order by date_rech desc')->result_array();
        }elseif (!empty($date_fin) && !empty($date_debut) && empty($articles1) && !empty($articles2) && !empty($camion1)){
           $query1 = $this->db->query('SELECT * from piece_rechange WHERE id_operation = "'.$articles2.'" and code_camion ="'.$camion1.'" and date_rech between "'.$date_debut.'" and "'.$date_fin.'" order by date_rech desc')->result_array();
        }elseif (!empty($date_fin) && !empty($date_debut) && !empty($articles1) && !empty($articles2) && empty($camion1)){
           $query1 = $this->db->query('SELECT * from piece_rechange WHERE id_operation = "'.$articles2.'" and id_article ="'.$articles1.'" and date_rech between "'.$date_debut.'" and "'.$date_fin.'" order by date_rech desc')->result_array();
        }else if (!empty($date_fin) && !empty($date_debut) && !empty($articles1) && empty($articles2) && !empty($camion1)){
           $query1 = $this->db->query('SELECT * from piece_rechange WHERE id_article = "'.$articles1.'" and code_camion ="'.$camion1.'" and date_rech between "'.$date_debut.'" and "'.$date_fin.'" order by date_rech desc')->result_array();
        }else
           $query1 = $this->db->query('SELECT * from piece_rechange order by date_rech desc limit 900')->result_array();
       }else {
    $query1 = $this->db->query('SELECT * from piece_rechange order by date_rech desc limit 800')->result_array();
      }
    
         // $query1 = $this->db->query('SELECT * from piece_rechange order by date_rech desc limit 900')->result_array();
         $compteur = 0;
		 
		 $compteur1 = 0;
		 
		 $compteur2 = 0;
		 
        foreach ($query1 as $row) {
            # code...

			$compteur1 = $compteur1 + $row["qtite"];
			
			

            echo "<tr >
                    <td><input type='checkbox' onclick='selectionArticlePourSuppression(\"index".$compteur."\",\"".$row['id_rechange']."\");' class='index".$compteur."' value='".$row['id_rechange']."'/></td>
                    <td> ".$compteur."</td>
					<td>".$row['bon_sortie']."</td>";

                    $getOperation = $this->db->query("SELECT * FROM operation where id_operation = ".$row['id_operation']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_op']."</td>";
                        }
                    }
                     $getArticle = $this->db->query("SELECT * FROM article where id_article = ".$row['id_article']."")->result_array();

                    if (count($getArticle)>0) {
                        # code...
                        foreach ($getArticle as $tab) {
                            # code...
                            $getCategorie = $this->db->query('SELECT * FROM categorie_article where id_categorie='.$tab['id_categorie'].'')->row();
                            if ($row["origine"] == "externe") {
                                # code...
                                $pu = $row["prix_unitaire"];
                            }else{
                                $pu = $row["prix_unitaire"];
                            }
                        
                       
                            $pt = $pu*$row["qtite"];
							$compteur2 = $compteur2 + $pt;
							
                            echo"<td>".$tab['article']."</td>
                            <td>".$row['prix_unitaire']."</td>
                            <td>".$row['qtite']."</td>


                            <td>".$getCategorie->categorie."</td>
                            <td>".$tab['code_a_barre']."</td>";
                            
                            if ($row['id_fournisseur_article'] != null || $row['id_fournisseur_article'] != '') {
                            # code...
                             $getFournisseurArticle = $this->db->query("SELECT * from fournisseur_article where id_fournisseur = ".$row['id_fournisseur_article']." limit 1")->row();
                             if (count($getFournisseurArticle) >0) {
                                 # code...
                                 echo " <td>".$getFournisseurArticle->nom." </td>";
                             }else{
                                echo "<td></td>";
                             }
                           
                             }else{
                                echo "<td></td>";
                             }

                            echo "                            
                            <td>".$row['code_camion']." </td>
                            <td>".number_format($pt,0,',',' ')."</td>";
                        }
                    }
                    
                    echo"                  
                      
                    
                    <td>".$row['date_rech']."</td>
                    <td> ".$row['commentaire']." </td>
                    <td>";

            if($this->session->userdata('stock_modification')=='true'){
                   echo" <button type='button'  onclick=\"infoPieceRechange('".$row['code_camion']."','".$row['id_article']."','".$row['origine']."','".$row['qtite']."','".$row['id_operation']."','".$row['date_rech']."','".$row['prix_unitaire']."','".$row['commentaire']."','".$row['id_rechange']."','".$row['id_fournisseur_article']."','".$row['origine']."','".$row['tva']."','".$this->recupPUSansTVA($row['tva'],$row['prix_unitaire'])."','".$row['bon_sortie']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
               }
            if($this->session->userdata('stock_suppression')=='true'){
                   echo" <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='piece_rechange' identifiant='".$row['id_rechange']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_rechange\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
              }
                  $compteur++;
        }

        echo "<input type='text' class='compteur1' value='".$compteur."' style='display:none;'/>";
		
		echo "<tr>
        <td style='color:red;font-size: 20px;text-align:center; border: 2px solid black; font-weight: bold;'>TOTAUX</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
		<td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteur1,0,',',' ')."</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteur2,0,',',' ')."</td>
		 <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
       
	</tr>";

        $this->db->close();
    }

        public function deletePieceRechange($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé une pièce de rechange sur le vehicule ".$getCamion->code_camion." de la date du ".$getCamion->date_rech." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."=".$identifiant."");
           if ($suppression == true) {
               # code...
              echo "Suppression effectuée";
              $this->notificationAjout($nom_table,addslashes($message));
           }else{
              echo "Erreur lors de la suppression";
           }
        }
         

         $this->db->close();
    }
	
	 public function deleteApprovisionnementGazoil($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé l'approvisionnement de l'article ".$this->getArticle($getCamion->id_article)." de la date du ".$getCamion->date_app." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."=".$identifiant."");
           if ($suppression == true) {
               # code...
              echo "Suppression effectuée";
              $this->notificationAjout($nom_table,addslashes($message));
           }else{
              echo "Erreur lors de la suppression";
           }
        }
         

         $this->db->close();
    }
	
	
	 public function deleteApprovisionnementHuile($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé l'approvisionnement de l'article ".$this->getArticle($getCamion->id_article)." de la date du ".$getCamion->date_app." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."=".$identifiant."");
           if ($suppression == true) {
               # code...
              echo "Suppression effectuée";
              $this->notificationAjout($nom_table,addslashes($message));
           }else{
              echo "Erreur lors de la suppression";
           }
        }
         

         $this->db->close();
    }
	
	public function deleteApprovisionnementPneu($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé l'approvisionnement de l'article ".$this->getArticle($getCamion->id_article)." de la date du ".$getCamion->date_app." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."=".$identifiant."");
           if ($suppression == true) {
               # code...
              echo "Suppression effectuée";
              $this->notificationAjout($nom_table,addslashes($message));
           }else{
              echo "Erreur lors de la suppression";
           }
        }
         

         $this->db->close();
    }
	
	
// public function deletePieceRechange(){
//     $compteur = $_POST['compteur'];
//       $articles = $_POST['article'];
//     $i =0;
//                 # code...
//                 $query =$this->db->query("DELETE from piece_rechange where id_rechange=".$articles."");

//                 if ($query == true) {
//                     # code...
//                      echo "Suppression réussie ";
//                 }else{
//                     echo "ERREUR DE SUPPRESSION";
//                 }

//     // $articles = json_decode($_POST['article']);
//     // $i =0;
//     // if (count($articles)>0) {
//     //     # code...
//     //             while ( $i<= count($articles)-1) {
//     //             # code...
//     //             $query =$this->db->query("DELETE from piece_rechange where id_rechange=".$articles[$i]."");

//     //             if ($query == true) {
//     //                 # code...
//     //                 // echo "reussite";
//     //             }else{
//     //                 echo "ERREUR DE SUPPRESSION";
//     //             }
//     //             $i++;
//     //         }

//     //         echo "Suppression réussie ";
//     // }else{
//     //     echo "veuillez sélectionner un article ".count($articles);
//     // }

//     $this->db->close();
    
// }


public function selectAllDepensePneu(){
    if (isset($_POST['date_debut']) && isset($_POST['date_fin'])) {
        # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];

    }elseif(isset($_POST['date_debut']) && !isset($_POST['date_fin'])) {
        # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = "";
    }elseif(!isset($_POST['date_debut']) && isset($_POST['date_fin'])) {
        # code...
        $date_debut = "";
        $date_fin = $_POST['date_fin'];
    }
    else{
        $date_debut = "";
        $date_fin="";
    }
        
        if (!empty($date_debut) && empty($date_fin)) {
            # code...
           
            $query1 = $this->db->query('SELECT * from depense_pneu where date_depense ="'.$date_debut.'" order by date_depense desc')->result_array();
        }elseif (!empty($date_fin) && empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * from depense_pneu where date_depense <"'.$date_fin.'" order by date_depense desc')->result_array();
        }elseif (!empty($date_debut) && !empty($date_fin)) {
            # code...

            $query1 = $this->db->query('SELECT * from depense_pneu where date_depense between "'.$date_debut.'" and "'.$date_fin.'"  
              order by date_depense desc')->result_array();
             // echo "test1 ".$query1;
        }else{
            
            $query1 = $this->db->query('SELECT * from depense_pneu order by date_depense desc')->result_array();
        }
         
         $compteur = 0;
		 
		 $compteur1 = 0;
		  
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
			
			
					
                    <td> ".$compteur."</td>     
                    <td>".$row['code_camion']."</td>";
                    $getArticle = $this->db->query("SELECT * from article where id_article = ".$row['id_article']."")->row();
					$getArticle1 = $this->db->query("SELECT * from fournisseur_article where id_fournisseur = ".$row['id_fournisseur']."")->row();
                    echo"
					<td> ".$getArticle1->nom." </td>
                    <td> ".$getArticle->article." </td>
                    <td> ".$row['type']." </td>
                   
                    <td> ".$row['date_depense']." </td>
                    <td> ".number_format($row['prix_unitaire'],0,',',' ')." </td>
                    <td> ".$row['qtite']." </td>";
					
					$compteur1 =$compteur1 + $row["qtite"];
					
					echo "
					
                    <td> ".number_format($row['qtite']*$row['prix_unitaire'],0,',',' ')." </td>
                    
                    <td> ".$row['commentaire']." </td>
                    <td>";
            if($this->session->userdata('pneu_modification')=='true'){
                   echo" <button type='button'  onclick=\"infoDepensePneu('".$row['code_camion']."','".$row['id_article']."','".$row['qtite']."','".$row['prix_unitaire']."','".$row['type']."','".$row['date_depense']."','".$row['id_depense']."','".$row['commentaire']."','".$row['id_fournisseur']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
               }
            if($this->session->userdata('pneu_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='depense_pneu' identifiant='".$row['id_depense']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_depense\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
        }
		
		
		echo "<tr>
        <td style='color:red;font-size: 20px;text-align:center; border: 2px solid black; font-weight: bold;'>TOTAUX</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
		<td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
       <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteur1,0,',',' ')."</td>
        
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>

	</tr>";

        $this->db->close();
    }


public function leSelectArticle(){
        $query = $this->db->query("SELECT  * from article order by article asc")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_article"]."'>".$row["article"]."</option>";
            }
        }else{

        }

        $this->db->close();
    }
	
	public function leSelectArticleSortie(){
        $query = $this->db->query("SELECT  * from article where id_article IN (SELECT id_article from approvisionnement) order by article")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_article"]."'>".$row["article"]."</option>";
            }
        }else{

        }

        $this->db->close();
    }
	
public function leSelectArticle1(){
        $query = $this->db->query("SELECT  * from article where id_type_pneu <> 53 and id_article NOT IN (SELECT id_article from pneu) and id_article NOT IN (SELECT id_article from depense_pneu) order by article asc")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_article"]."'>".$row["article"]."</option>";
            }
        }else{

        }

        $this->db->close();
    }
	
	public function leSelectArticle2(){
        $query = $this->db->query("SELECT  * from article where id_type_pneu = 53 order by article asc")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_article"]."'>".$row["article"]."</option>";
            }
        }else{

        }

        $this->db->close();
    }
	
	public function getNbreLigne(){
    
	$nbreLignes = $_POST["nbreLignes"];
    $i=1;
	
    while ( $i<= $nbreLignes) {
  echo '<div class="row">
       <div class="col-md-2">
       <div class="form-group">
       <label>PNEU</label>
        <select class="article'.$i.' form-control" onchange="getPrixUnitaireArticle1($(\'.article'.$i.'\').val(),\'pu'.$i.'\');getFournisseurArticle1($(\'.article'.$i.'\').val(),\'fournisseur'.$i.'\');getFournisseurArticle1_1($(\'.article'.$i.'\').val(),\'fournisseur1'.$i.'\');getReferenceArticle1($(\'.article'.$i.'\').val(),\'reference'.$i.'\');getTypeArticle1($(\'.article'.$i.'\').val(),\'type'.$i.'\');getMarqueArticle1($(\'.article'.$i.'\').val(),\'marque'.$i.'\');getTailleArticle1($(\'.article'.$i.'\').val(),\'taille'.$i.'\');">
         <option value=""></option>';
        $this->crud_model_depense->leSelectArticle1();
        echo '</select></div>
          </div>
		  
		  <div class="form-group">
       <label>Type</label>
        <input type="text" class="form-control type'.$i.'" disabled ="True" />
       
         </div>
       
		  
		   <div class="col-md-2">
       <label>Marque</label>
        <input type="text" class="form-control marque'.$i.'" disabled ="True" />
       
         </div>
          
		  
		 <div class="col-md-2">
       <label>Taille</label>
        <input type="text" class="form-control taille'.$i.'" disabled ="True" />
       
         </div>
		 
		  <div class="col-md-2">
       <label>Fournisseur</label>
        <input type="text" class="form-control fournisseur'.$i.'" disabled ="True" />
       
         </div>
          
		  
          <div class="col-md-1">
          <label>Quantité</label>
          <input type="text" class="form-control qtite_com'.$i.'" placeholder=" " value = "1" disabled="true" onkeypress="chiffres(event);" >
         </div>
         <div class="col-md-2">
            <label>Prix unitaire</label>
            <input type="text" class="form-control pu'.$i.'" placeholder=" en FCFA"  value = "0" disabled="true" onkeypress="chiffres(event);">
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Camion</label>
                <select class="camion'.$i.' camion form-control" onchange="getMatriculeVehicule1($(\'.camion'.$i.'\').val(),\'immatriculation'.$i.'\',\'immatriculation1'.$i.'\',\'kilometrage_debut'.$i.'\')";>';
                     $this->crud_model_depense->leSelectEtatCodeCamion();
        echo'</select>
            </div></div>
			
			<div class="col-md-2">
            <div class="form-group">
                <label>Immatriculation</label>
                <select class="immatriculation'.$i.' immatriculation form-control" onchange="getMatriculeVehicule2($(\'.immatriculation'.$i.'\').val(),\'immatriculation1'.$i.'\'); getKilometrageGasoilParImmatriculation($(\'.immatriculation'.$i.'\').val(),\'kilometrage_debut'.$i.'\')";>';
              //    $this->crud_model_depense->leSelectImmatCamion1();
        echo'</select>
            </div></div>
			
		<div class="col-md-2">
          <label>Immatriculation</label>
          <input type="text" class="immatriculation1'.$i.' immatriculation1 form-control"   disabled="true">
         </div>
		 
		 <div class="col-md-2">
          <label>Kilometrage Début</label>
          <input type="text" class="kilometrage_debut'.$i.' kilometrage_debut form-control"   disabled="true">
         </div>
            
                <input type="hidden" class="form-control id_prime'.$i.'"  placeholder=" en FCFA" disabled="true" onkeypress="chiffres(event);">
				
				<input type="hidden" class="form-control fournisseur1'.$i.'"  placeholder=" en FCFA" disabled="true" onkeypress="chiffres(event);">

				<input type="hidden" class="form-control reference'.$i.'"  placeholder=" en FCFA" disabled="true" onkeypress="chiffres(event);">
				
				<input type="hidden" class="form-control immatriculation1'.$i.'"  placeholder=" en FCFA" disabled="true" onkeypress="chiffres(event);">
				
				<input type="hidden" class="form-control kilometrage_debut'.$i.'"  placeholder=" en FCFA" disabled="true" onkeypress="chiffres(event);">
				
				
				

              
       
            </div>
       <hr>';
       $i++;
    
    }

    $this->db->close();
}


public function getNbreLigne1(){
	
    $nbreLignes = $_POST["nbreLignes"];
    $i=1;
	
    while ( $i<= $nbreLignes) {
  echo '<div class="row">
  
  <div class="col-md-1">
  <div class="form-group">
  <label>N°</label>
                            <input type="text"class="form-control cpt'.$i.'" placeholder="" value = "'.$i.'" disabled="true" >

                 </div>
    </div>

    <div class="col-md-1" >
    <div class="form-group">
    <label>Délégué</label>
    <select class="delegue'.$i.' form-control" onchange="getCamionDelegue1($(\'.delegue'.$i.'\').val(),\'camion1'.$i.'\',\'immatriculation1'.$i.'\',\'litrage1'.$i.'\',\'route1'.$i.'\',\'retour1'.$i.'\');">
    
    <option value=""></option>';
    $this->crud_model_depense->leSelectDelegueCamion();
                                
    echo '</select>
    </div>
    </div>
	
	<div class="col-md-1">
                            <label>N°BL</label>
                            <input type="text" class="form-control bl'.$i.'" placeholder=""  onkeyup ="verifBLInTabInput(\'bl'.$i.'\'); getBLDatabase($(\'.bl'.$i.'\').val(),\'bl'.$i.'\',\'blT'.$i.'\');" >

                  </div>
				  
	
	        <div class="col-md-2">
                            <label>Date BL: </label>
                          <div class="input-group " id="" data-target-input="nearest" >
                              
                                <input type="date" class="form-control datetimepicker-input date_demande1'.$i.'" data-target="#reservationdate" placeholder="date effet" onchange="getExpirationPneu();" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                          </div>
                        </div>
				  
	  
	
    <div class="col-md-1">				  
		  <div class="form-group">
      <label>Véhicule</label> 
       <select class="camion1'.$i.' form-control" onchange="verifMatriculeInTabInput(\'camion1'.$i.'\'); getMatriculeVehicule1_1($(\'.camion1'.$i.'\').val(),\'immatriculation1'.$i.'\');getTypeVehicule3_1($(\'.camion1'.$i.'\').val(),\'typeA'.$i.'\');getDistanceParCodeCamion1($(\'.camion1'.$i.'\').val(),\'destinationM'.$i.'\');getNomTypeVehicule3_1($(\'.camion1'.$i.'\').val(),\'typeC'.$i.'\'); ">
      <option value=""></option>';
       echo ' </select></div>
          </div>
		  
	<div class="col-md-1">	
		    
       <label>Matricule</label>
	   
	   <input type="text" class="form-control immatriculation1'.$i.'" placeholder="Matricule" disabled = "true"   onchange ="">
      
          </div>
		  
		  	<div class="col-md-1">
                            <label>Kilometrage</label>
                            <input type="text" class="form-control kilometrage'.$i.'" placeholder="Kilométrage" onkeypress="chiffres(event);" value = "0">

                          </div> 
						 
	
  <div class="col-md-1">	
		    
       <label>Type Vehicule</label>
	   
	   <input type="text" class="form-control typeC'.$i.'" placeholder="" value= "'. $type_vehicule.'" disabled = "true" >
      
          </div>		
						  
		  
		     	 <div class="col-md-2">				  
		  <div class="form-group">
      <label>Client</label> 
       <select class="client'.$i.' form-control" onchange="">
	   <option value=""></option>';
      	$this->crud_model_depense->leSelectClientFrais();
        echo ' </select></div>
		</div>	

					<div class="col-md-2">
                            <label>M. Départ</label>
                           
                            <select class="marchandiseD'.$i.' form-control" onchange="">
							<option value=""></option>
							<option value="BOIS">BOIS</option>
							<option value="CIMENT_42.5">CIMENT_42.5</option>
							<option value="CIMENT_32.5">CIMENT_32.5</option>
							<option value="CIMENT_VRAC">CIMENT_VRAC</option>
							<option value="CONTENAIRE">CONTENAIRE</option>
							<option value="ENGRAIS">ENGRAIS</option>
							<option value="GRAVIER">GRAVIER</option>
							<option value="MAIS">MAIS</option>
							<option value="PALETTE">PALETTE</option>
							<option value="PNEU">PNEU</option>
							<option value="POUZZOLANE">POUZZOLANE</option>
							<option value="SABLE">SABLE</option>
							<option value="SOJA">SOJA</option>';
													
							echo ' </select>
						</div>			
		 
		  
		  

		   <div class="col-md-2">
               <div class="form-group">
                 <label>Destination</label>
                  <select class="destinationM'.$i.' form-control" onchange="getLitrageCamion1($(\'.destinationM'.$i.'\').val(),$(\'.typeA'.$i.'\').val(),\'gazoil'.$i.'\');getFraisRoute1($(\'.destinationM'.$i.'\').val(),$(\'.typeA'.$i.'\').val(),\'route'.$i.'\');getFraisRetour1($(\'.destinationM'.$i.'\').val(),$(\'.typeA'.$i.'\').val(),\'retour'.$i.'\');">
                 
                      
            </select></div>
             </div>
			 
			
						    <div class="col-md-1">
                             
                              <label>Frais Route</label>
                              <input type= "text" class="form-control route'.$i.' " placeholder="" disabled="true" onkeypress="chiffres(event);" value = "0" onkeyup="totalCumLigne();totalLigne($(\'.route'.$i.'\').val(),$(\'.retour'.$i.'\').val(),$(\'.pont'.$i.'\').val(),$(\'.tour'.$i.'\').val(),\'totalLigne'.$i.'\');"  >
                              </div>
                         
						<div class="col-md-2">
                            <label>M. Retour</label>
                            <select class="marchandiseR'.$i.' form-control" onchange="">
								<option value=""></option>
							<option value="BOIS">BOIS</option>
							<option value="CIMENT_42.5">CIMENT_42.5</option>
							<option value="CIMENT_32.5">CIMENT_32.5</option>
							<option value="CIMENT_VRAC">CIMENT_VRAC</option>
							<option value="CONTENAIRE">CONTENAIRE</option>
							<option value="ENGRAIS">ENGRAIS</option>
							<option value="GRAVIER">GRAVIER</option>
							<option value="MAIS">MAIS</option>
							<option value="PALETTE">PALETTE</option>
							<option value="PNEU">PNEU</option>
							<option value="POUZZOLANE">POUZZOLANE</option>
							<option value="SABLE">SABLE</option>
							<option value="SOJA">SOJA</option>';
							echo ' </select>
						</div>	  
						  
						    <div class="col-md-1">
                             
                              <label>Frais Retour</label>
                              <input type= "text" class="form-control retour'.$i.' " placeholder=""  onkeypress="chiffres(event);" value = "0" onkeyup="totalCumLigne();totalLigne($(\'.route'.$i.'\').val(),$(\'.retour'.$i.'\').val(),$(\'.pont'.$i.'\').val(),$(\'.tour'.$i.'\').val(),\'totalLigne'.$i.'\');" >
                            
                          </div>
						  
  
						<div class="col-md-1">
                            <label>Nbre Sacs</label>
                            <input type="text" class="form-control tonnage'.$i.'" placeholder="" onkeypress="chiffres(event);" value = "0.00" onkeyup="" >

                          </div> 
						
						  
						<div class="col-md-1">
                            <label>Surcharge</label>
                            <input type="text" class="form-control pont'.$i.'" placeholder="" onkeypress="chiffres(event);" value = "0" onkeyup="totalCumLigne();totalLigne($(\'.route'.$i.'\').val(),$(\'.retour'.$i.'\').val(),$(\'.pont'.$i.'\').val(),$(\'.tour'.$i.'\').val(),\'totalLigne'.$i.'\');" >

                          </div> 
						  
						<div class="col-md-1">
                            <label>Nbre Tour(s)</label>
                            <input type="text" class="form-control tour'.$i.'" placeholder="" onkeypress="chiffres(event);" value = "1" onkeyup="totalCumLigne();totalLigne($(\'.route'.$i.'\').val(),$(\'.retour'.$i.'\').val(),$(\'.pont'.$i.'\').val(),$(\'.tour'.$i.'\').val(),\'totalLigne'.$i.'\');" >

                          </div> 
						  
						  <div class="col-md-1">
                            <label>Total Ligne</label>
                            <input type="text" class="form-control totalLigne'.$i.'" placeholder="" onkeypress="chiffres(event);" value = "0" disabled = "true"; onkeyup="" >

                          </div> 
						  
						  
											  
						  <div class="col-md-1">
                              <label>A. F Route</label>
                              <input type="checkbox" class="form-control rjFR'.$i.'" disabled = "true" >
                          </div>
						  
						  <div class="col-md-1">
                              <label>A. F Retour</label>
                              <input type="checkbox" class="form-control rjFT'.$i.'" disabled = "true" >
                          </div>
						  
						  <div class="col-md-1">
                              <label>A. Pont</label>
                              <input type="checkbox" class="form-control rjP'.$i.'"  disabled = "true">
                          </div>
						  

					<input type="hidden" class="form-control typeA'.$i.'"  placeholder=" en FCFA" disabled="true" onkeypress="chiffres(event);">
					
					<input type="hidden" class="form-control gazoil'.$i.'"  placeholder=" en FCFA" disabled="true" onkeypress="chiffres(event);">
                          
						 <input type="hidden" class="form-control id_demande'.$i.'"  placeholder=" en FCFA" disabled="true" onkeypress="chiffres(event);">
                         <input type="hidden" class="form-control compteur'.$i.'"  placeholder=" en FCFA"  disabled="true" onkeypress="chiffres(event);">	  
                         <input type="hidden" class="form-control blT'.$i.'"  disabled="true"> 
						
											 
	</div>
 <hr>';
       $i++;
    
    }
	
	echo '<div class="row">
	
	
	<div class="col-md-3" >
                            <div class="form-group">
                            <label>TOTAL FRAIS ROUTE</label>
                            <input type="text" class="totalLigne form-control" onkeypress="chiffres(event);" disabled = "true">
                             
                              
                             
                          </div>
    </div>
	
	

	<div class="col-md-1" >
	<br>
	
					    <button type="button"   class=" btn-primary btn-sm"  onclick="totalCumLigne();"><i class="fa fa-cog fa-fw" aria-hidden="true"></i></button>
                     
                             
                          </div>
    
	
	
	
	 </div>
  
  
 <hr>';

    $this->db->close();
}



   //     <input type= "text" class="form-control litrage'.$i.' " placeholder=""  onkeypress="chiffres(event);" value = "0" onchange="totalCumLigne($(\'.litrage'.$i.'\').val(),$(\'.tour'.$i.'\').val(),\'totalLigne'.$i.'\');totalParLigneN($(\'.litrage'.$i.'\').val(),$(\'.tour'.$i.'\').val(),\'totalParLigne'.$i.'\');"  >
   //  totalCumLigneNL($(\'.litrage'.$i.'\').val(),$(\'.tour'.$i.'\').val(),\'totalParLigne'.$i.'\');                         

public function getNbreLigne1N(){
	
    $nbreLignes = $_POST["nbreLignes"];
    $i=1;
	
    while ( $i<= $nbreLignes) {
  echo '<div class="row">
  
  <div class="col-md-1">
  <div class="form-group">
  <label>N°</label>
                            <input type="text"class="form-control cpt'.$i.'" placeholder="" value = "'.$i.'" disabled="true" >

                 </div>
    </div>

   <div class="col-md-1" >
    <div class="form-group">
    <label>Délégué</label>
    <select class="delegue'.$i.' form-control" onchange="getCamionDelegue1($(\'.delegue'.$i.'\').val(),\'camion1'.$i.'\',\'immatriculation1'.$i.'\',\'litrage1'.$i.'\',\'route1'.$i.'\',\'retour1'.$i.'\');">
    
    <option value=""></option>';
    $this->crud_model_depense->leSelectDelegueCamionN();
                                
    echo '</select>
    </div>
    </div>

<div class="col-md-1">				  
		  <div class="form-group">
      <label>Véhicule</label> 
       <select class="camion1'.$i.' form-control" onchange="verifMatriculeInTabInput(\'camion1'.$i.'\'); getBLTDatabase($(\'.camion1'.$i.'\').val(),\'camion1'.$i.'\',\'blT'.$i.'\'); getMatriculeVehicule1_1($(\'.camion1'.$i.'\').val(),\'immatriculation1'.$i.'\');getTypeVehicule3_1($(\'.camion1'.$i.'\').val(),\'typeA'.$i.'\');getDistanceParCodeCamion1($(\'.camion1'.$i.'\').val(),\'destinationM'.$i.'\');getNomTypeVehicule3_1($(\'.camion1'.$i.'\').val(),\'typeC'.$i.'\'); ">
      <option value=""></option>';
       echo ' </select></div>
          </div>
		  
<div class="col-md-1">	
		    
       <label>Matricule</label>
	   
	   <input type="text" class="form-control immatriculation1'.$i.'" placeholder="Matricule" disabled = "true"   onchange ="">
      
          </div>
		  
		  	<div class="col-md-1">
                            <label>Kilometrage</label>
                            <input type="text" class="form-control kilometrage'.$i.'" placeholder="Kilométrage" onkeypress="chiffres(event);" value = "0">

            </div> 
			
<div class="col-md-1">	
		    
       <label>Type Vehicule</label>
	   
	   <input type="text" class="form-control typeC'.$i.'" placeholder="" value= "'. $type_vehicule.'" disabled = "true" >
      
          </div>		
						  
		  
	<div class="col-md-2">				  
		  <div class="form-group">
      <label>Client</label> 
       <select class="client'.$i.' form-control" onchange="">
	   <option value=""></option>';
      	$this->crud_model_depense->leSelectClientFraisNavette();
        echo ' </select></div>
		</div>


			<div class="col-md-2">
               <div class="form-group">
                 <label>Destination</label>
                  <select class="destinationM'.$i.' form-control" onchange="getLitrageCamion1($(\'.destinationM'.$i.'\').val(),$(\'.typeA'.$i.'\').val(),\'litrage'.$i.'\');">
                 
                      
            </select></div>
             </div>
			 
			
						    <div class="col-md-1">
                                     <label>Litrage</label>
									 
									 <input type= "text" class="form-control litrage'.$i.' " placeholder=""  onkeypress="chiffres(event);" onkeyup=""  >
                              
                              
                      </div>
							  
							  
						<div class="col-md-1">
                            <label>Nbre BL(s)</label>
                            <input type="text" class="form-control tour'.$i.'" placeholder="" onkeypress="chiffres(event);" value = "1" onkeyup="totalCumLigneN();" >

                          </div> 
						  
						    <div class="col-md-1">
                            <label>Total Ligne</label>
                            <input type="text" class="form-control totalParLigne'.$i.'" placeholder="" onkeypress="chiffres(event);" value = "0" disabled = "true"; onkeyup="" >

                          </div> 
							  	


						<div class="col-md-1">
                              <label>A. GAZOIL</label>
                              <input type="checkbox" class="form-control rjG'.$i.'" disabled =  "true" >
                          </div>				  

					<input type="hidden" class="form-control typeA'.$i.'"  placeholder=" en FCFA" disabled="true" onkeypress="chiffres(event);">
					
					<input type="hidden" class="form-control blT'.$i.'"  placeholder=" en FCFA" disabled="true" onkeypress="chiffres(event);">
					
					<input type="hidden" class="form-control bl1'.$i.'"  placeholder=" en FCFA" disabled="true" onkeypress="chiffres(event);">
		
					<input type="hidden" class="form-control id_demande'.$i.'"  placeholder=" en FCFA" disabled="true" onkeypress="chiffres(event);">
                         
					<input type="hidden" class="form-control compteur'.$i.'"  placeholder=" en FCFA"  disabled="true" onkeypress="chiffres(event);">	  
      
	</div>
 <hr>';
       $i++;
    
    }
	
	echo '<div class="row">
	
	
	<div class="col-md-3" >
                            <div class="form-group">
                            <label>TOTAL LITRAGE NAVETTE</label>
                            <input type="text" class="totalLigne form-control" onkeypress="chiffres(event);" disabled = "true">
                             
                              
                             
                          </div>
    </div>
	
	

	<div class="col-md-1" >
	<br>
	
					    <button type="button"   class=" btn-primary btn-sm"  onclick="totalCumLigneN();"><i class="fa fa-cog fa-fw" aria-hidden="true"></i></button>
                     
                             
                          </div>
    
	
	
	
	 </div>
  
  
 <hr>';

    $this->db->close();
}

public function getNbreLigne1NA(){
	
    $nbreLignes = $_POST["nbreLignes"];
    $i=1;
	
    while ( $i<= $nbreLignes) {
  echo '<div class="row">
  
  <div class="col-md-1">
  <div class="form-group">
  <label>N°</label>
                            <input type="text"class="form-control cpt'.$i.'" placeholder="" value = "'.$i.'" disabled="true" >

                 </div>
    </div>

   <div class="col-md-1" >
    <div class="form-group">
    <label>Délégué</label>
    <select class="delegue'.$i.' form-control" onchange="getCamionDelegue1($(\'.delegue'.$i.'\').val(),\'camion1'.$i.'\',\'immatriculation1'.$i.'\',\'litrage1'.$i.'\',\'route1'.$i.'\',\'retour1'.$i.'\');">
    
    <option value=""></option>';
    $this->crud_model_depense->leSelectDelegueCamionN();
                                
    echo '</select>
    </div>
    </div>

<div class="col-md-1">				  
		  <div class="form-group">
      <label>Véhicule</label> 
       <select class="camion1'.$i.' form-control" onchange="verifMatriculeInTabInput(\'camion1'.$i.'\');  getMatriculeVehicule1_1($(\'.camion1'.$i.'\').val(),\'immatriculation1'.$i.'\');getTypeVehicule3_1($(\'.camion1'.$i.'\').val(),\'typeA'.$i.'\');getDistanceParCodeCamion1($(\'.camion1'.$i.'\').val(),\'destinationM'.$i.'\');getNomTypeVehicule3_1($(\'.camion1'.$i.'\').val(),\'typeC'.$i.'\'); ">
      <option value=""></option>';
       echo ' </select></div>
          </div>
		  
<div class="col-md-1">	
		    
       <label>Matricule</label>
	   
	   <input type="text" class="form-control immatriculation1'.$i.'" placeholder="Matricule" disabled = "true"   onchange ="">
      
          </div>
		  
		  	<div class="col-md-1">
                            <label>Kilometrage</label>
                            <input type="text" class="form-control kilometrage'.$i.'" placeholder="Kilométrage" onkeypress="chiffres(event);" value = "0">

            </div> 
			
<div class="col-md-1">	
		    
       <label>Type Vehicule</label>
	   
	   <input type="text" class="form-control typeC'.$i.'" placeholder="" value= "'. $type_vehicule.'" disabled = "true" >
      
          </div>		
						  
		  
	<div class="col-md-2">				  
		  <div class="form-group">
      <label>Client</label> 
       <select class="client'.$i.' form-control" onchange="">
	   <option value=""></option>';
      	$this->crud_model_depense->leSelectClientFraisNavette();
        echo ' </select></div>
		</div>


			<div class="col-md-2">
               <div class="form-group">
                 <label>Destination</label>
                  <select class="destinationM'.$i.' form-control" onchange="getLitrageCamion1($(\'.destinationM'.$i.'\').val(),$(\'.typeA'.$i.'\').val(),\'litrage'.$i.'\');">
                 
                      
            </select></div>
             </div>
			 
			
						    <div class="col-md-1">
                                     <label>Litrage</label>
									 
									 <input type= "text" class="form-control litrage'.$i.' " placeholder=""  onkeypress="chiffres(event);" onkeyup=""  >
                              
                              
                      </div>
							  
							  
						<div class="col-md-1">
                            <label>Nbre BL(s)</label>
                            <input type="text" class="form-control tour'.$i.'" placeholder="" onkeypress="chiffres(event);" value = "1" onkeyup="totalCumLigneN();" >

                          </div> 
						  
						    <div class="col-md-1">
                            <label>Total Ligne</label>
                            <input type="text" class="form-control totalParLigne'.$i.'" placeholder="" onkeypress="chiffres(event);" value = "0" disabled = "true"; onkeyup="" >

                          </div> 
							  	


<div class="col-md-1">
                              <label>A. GAZOIL</label>
                              <input type="checkbox" class="form-control rjG'.$i.'" disabled =  "true" >
                          </div>				  

					<input type="hidden" class="form-control typeA'.$i.'"  placeholder=" en FCFA" disabled="true" onkeypress="chiffres(event);">
					
					
					
					
		
					<input type="hidden" class="form-control id_demande'.$i.'"  placeholder=" en FCFA" disabled="true" onkeypress="chiffres(event);">
                         
					<input type="hidden" class="form-control compteur'.$i.'"  placeholder=" en FCFA"  disabled="true" onkeypress="chiffres(event);">	  
      
	</div>
 <hr>';
       $i++;
    
    }
	
	echo '<div class="row">
	
	
	<div class="col-md-3" >
                            <div class="form-group">
                            <label>TOTAL LITRAGE NAVETTE</label>
                            <input type="text" class="totalLigne form-control" onkeypress="chiffres(event);" disabled = "true">
                             
                              
                             
                          </div>
    </div>
	
	

	<div class="col-md-1" >
	<br>
	
					    <button type="button"   class=" btn-primary btn-sm"  onclick="totalCumLigneN();"><i class="fa fa-cog fa-fw" aria-hidden="true"></i></button>
                     
                             
                          </div>
    
	
	
	
	 </div>
  
  
 <hr>';

    $this->db->close();
}

public function getNbreLigne1ST(){
	
    $nbreLignes = $_POST["nbreLignes"];
    $i=1;
	
    while ( $i<= $nbreLignes) {
  echo '<div class="row">
  
  <div class="col-md-1">
  <div class="form-group">
  <label>N°</label>
                            <input type="text"class="form-control cpt'.$i.'" placeholder="" value = "'.$i.'" disabled="true" >

                 </div>
    </div>
	
	<div class="col-md-3">
                            <label>Date STOCK: </label>
                          <div class="input-group " id="" data-target-input="nearest" >
                              
                                <input type="date" class="form-control datetimepicker-input date_demande'.$i.'" data-target="#reservationdate" placeholder="date effet" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                          </div>
                        </div>

   <div class="col-md-2" >
    <div class="form-group">
    <label>Délégué</label>
    <select class="delegue'.$i.' form-control" onchange="getCamionDelegue1($(\'.delegue'.$i.'\').val(),\'camion1'.$i.'\',\'immatriculation1'.$i.'\',\'litrage1'.$i.'\',\'route1'.$i.'\',\'retour1'.$i.'\');">
    
    <option value=""></option>';
    $this->crud_model_depense->leSelectDelegueCamionN();
                                
    echo '</select>
    </div>
    </div>
	
	
	   
				  

<div class="col-md-2">				  
		  <div class="form-group">
      <label>Véhicule</label> 
       <select class="camion1'.$i.' form-control" onchange="verifMatriculeInTabInput(\'camion1'.$i.'\');  getMatriculeVehicule1_1($(\'.camion1'.$i.'\').val(),\'immatriculation1'.$i.'\');getTypeVehicule3_1($(\'.camion1'.$i.'\').val(),\'typeA'.$i.'\');getNomTypeVehicule3_1($(\'.camion1'.$i.'\').val(),\'typeC'.$i.'\'); ">
      <option value=""></option>';
       echo ' </select></div>
          </div>
		  
<div class="col-md-2">	
		    
       <label>Matricule</label>
	   
	   <input type="text" class="form-control immatriculation1'.$i.'" placeholder="Matricule" disabled = "true"   onchange ="">
      
          </div>
		  
		  	<div class="col-md-1">
                            <label>Kilometrage</label>
                            <input type="text" class="form-control kilometrage'.$i.'" placeholder="Kilométrage" onkeypress="chiffres(event);" value = "0" disabled = "true">

            </div> 
			
<div class="col-md-2">	
		    
       <label>Type Vehicule</label>
	   
	   <input type="text" class="form-control typeC'.$i.'" placeholder="" value= "'. $type_vehicule.'" disabled = "true" >
      
          </div>		
							  
						<div class="col-md-1">
                            <label>Stock Gazoil</label>
                            <input type="text" class="form-control tour'.$i.'" placeholder="" onkeypress="chiffres(event);"   >

                          </div> 
					
					<div class="col-md-3">
                            
                              <label>Description</label>
                              <textarea class="form-control commentaire'.$i.'" placeholder="Justification">
                                
                              </textarea>
                            </div>	  
						   


					<input type="hidden" class="form-control typeA'.$i.'"  placeholder=" en FCFA" disabled="true" onkeypress="chiffres(event);">
					
					
					
					
		
					<input type="hidden" class="form-control id_demande'.$i.'"  placeholder=" en FCFA" disabled="true" onkeypress="chiffres(event);">
                         
					<input type="hidden" class="form-control compteur'.$i.'"  placeholder=" en FCFA"  disabled="true" onkeypress="chiffres(event);">	  
      
	</div>
 <hr>';
       $i++;
    
    }
	
	
	echo '<div class="row">
	
	
	<div class="col-md-3" >
                            <div class="form-group">
                            <label>TOTAL STOCK VEHICULE</label>
                            <input type="text" class="totalLigne form-control" onkeypress="chiffres(event);" disabled = "true">
                             
                              
                             
                          </div>
    </div>
	
	

	<div class="col-md-1" >
	<br>
	
					    <button type="button"   class=" btn-primary btn-sm"  onclick="totalCumLigneN();"><i class="fa fa-cog fa-fw" aria-hidden="true"></i></button>
                     
                             
                          </div>
    
	
	
	
	 </div>
  
  
 <hr>';

    $this->db->close();
}



public function getNbreLigne1E(){
	
    $nbreLignes = $_POST["nbreLignes"];
    $i=1;
	
    while ( $i<= $nbreLignes) {
  echo '<div class="row">
  
  <div class="col-md-1">
  <div class="form-group">
  <label>N°</label>
                            <input type="text"class="form-control cpt'.$i.'" placeholder="" value = "'.$i.'" disabled="true" >

                 </div>
    </div>

<div class="col-md-3">				  
		  <div class="form-group">
      <label>Engin</label> 
       <select class="camion1'.$i.' form-control" onchange="verifMatriculeInTabInput(\'camion1'.$i.'\'); getMatriculeVehicule1_1($(\'.camion1'.$i.'\').val(),\'immatriculation1'.$i.'\');getTypeVehicule3_1($(\'.camion1'.$i.'\').val(),\'typeA'.$i.'\');getNomTypeVehicule3_1($(\'.camion1'.$i.'\').val(),\'typeC'.$i.'\'); ">
      <option value=""></option>';
	   $this->crud_model_depense->leSelectEtatCodeEngin();
       echo ' </select></div>
          </div>
		  
<div class="col-md-2">	
		    
       <label>Matricule</label>
	   
	   <input type="text" class="form-control immatriculation1'.$i.'" placeholder="Matricule" disabled = "true"   onchange ="">
      
 </div>
		  
		  	<div class="col-md-1">
                            <label>Kilometrage</label>
                            <input type="text" class="form-control kilometrage'.$i.'" placeholder="Kilométrage" onkeypress="chiffres(event);" value = "0">

            </div> 
			
<div class="col-md-2">	
		    
       <label>Type Vehicule</label>
	   
	   <input type="text" class="form-control typeC'.$i.'" placeholder="" value= "'. $type_vehicule.'" disabled = "true" >
      
</div>		

                    <div class="col-md-1">
                                     <label>Litrage / Heure</label>
									 <input type= "text" class="form-control litrageH'.$i.' " placeholder=""  value = "0" disabled = "true" onkeypress="chiffres(event);" onkeyup=""  >
                              
                    </div>
						  
		  
					<div class="col-md-1">
                                     <label>Litrage Consommé</label>
									 <input type= "text" class="form-control litrage'.$i.' " placeholder=""  value = "0" onkeypress="chiffres(event);" onkeyup=""  >
                              
                    </div>
					
					
					
							  
				
											  

					<input type="hidden" class="form-control typeA'.$i.'"  placeholder=" en FCFA" disabled="true" onkeypress="chiffres(event);">
					
					
		
					<input type="hidden" class="form-control id_demande'.$i.'"  placeholder=" en FCFA" disabled="true" onkeypress="chiffres(event);">
                         
					<input type="hidden" class="form-control compteur'.$i.'"  placeholder=" en FCFA"  disabled="true" onkeypress="chiffres(event);">	  
      
	</div>
 <hr>';
       $i++;
    
    }
	
	echo '<div class="row">
	
	
	<div class="col-md-3" >
                            <div class="form-group">
                            <label>TOTAL LITRAGE ENGIN</label>
                            <input type="text" class="totalLigne form-control" onkeypress="chiffres(event);" disabled = "true">
                             
                              
                             
                          </div>
    </div>
	
	

	<div class="col-md-1" >
	<br>
	
					    <button type="button"   class=" btn-primary btn-sm"  onclick="totalCumLigneN();"><i class="fa fa-cog fa-fw" aria-hidden="true"></i></button>
                     
                             
                          </div>
    
	
	
	
	 </div>
  
  
 <hr>';

    $this->db->close();
}



public function genererChaineAleatoireDemande(){ 

	$date = date('Y-m-d');
	$now = new Datetime();

    $getCodeBLClient = $this->db->query("SELECT * from demande_frais order by id_demande desc limit 1")->row();

 $code =0;
    if (count($getCodeBLClient)>0) {
      # code...
      $code = $getCodeBLClient->po_dem;

    }else{
     
      $code = 0;
    }
    $code++;
    // $code=intval($code);
    while (strlen($code)<10) {
      # code...
      $code = "0".$code;
    }

    return "FRG".filter_var($code, FILTER_SANITIZE_NUMBER_INT);
}

public function genererChaineAleatoireDemandeE(){ 

	$date = date('Y-m-d');
	$now = new Datetime();

    $getCodeBLClient = $this->db->query("SELECT * from demande_engin order by id_demande desc limit 1")->row();

 $code =0;
    if (count($getCodeBLClient)>0) {
      # code...
      $code = $getCodeBLClient->po_dem;

    }else{
     
      $code = 0;
    }
    $code++;
    // $code=intval($code);
    while (strlen($code)<10) {
      # code...
      $code = "0".$code;
    }

    return "FGE".filter_var($code, FILTER_SANITIZE_NUMBER_INT);
}

public function genererChaineAleatoireDemandeN(){ 

	$date = date('Y-m-d');
	$now = new Datetime();

    $getCodeBLClient = $this->db->query("SELECT * from demande_navette order by id_demande desc limit 1")->row();

 $code =0;
    if (count($getCodeBLClient)>0) {
      # code...
      $code = $getCodeBLClient->po_dem;

    }else{
     
      $code = 0;
    }
    $code++;
    // $code=intval($code);
    while (strlen($code)<10) {
      # code...
      $code = "0".$code;
    }

    return "FGN".filter_var($code, FILTER_SANITIZE_NUMBER_INT);
}

public function genererChaineAleatoireDemandeNA(){ 

	$date = date('Y-m-d');
	$now = new Datetime();

    $getCodeBLClient = $this->db->query("SELECT * from demande_navette_autre order by id_demande desc limit 1")->row();

 $code =0;
    if (count($getCodeBLClient)>0) {
      # code...
      $code = $getCodeBLClient->po_dem;

    }else{
     
      $code = 0;
    }
    $code++;
    // $code=intval($code);
    while (strlen($code)<10) {
      # code...
      $code = "0".$code;
    }

    return "FGNA".filter_var($code, FILTER_SANITIZE_NUMBER_INT);
}


public function selectAllContoleDemmande(){
	
   $date = date('Y-m-d');
   
  
	if (isset($_POST["date_debut"]) && isset($_POST["date_fin"]) && isset($_POST["id_fournisseur1"])) {
            # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $id_fournisseur1 = $_POST['id_fournisseur1'];
        


		if (!empty($date_fin) && !empty($date_debut) && isset($_POST["id_fournisseur1"])) {

     //       $query1 = $this->db->query("SELECT distinct po_com,id_fournisseur_article,date_com,date_crea,etat_exp,etat_recep,id_commande,id_article,code_camion,description from commande where id_fournisseur_article = ".$id_fournisseur1." and date_com between '".$date_debut."' and '".$date_fin."'  group by po_com ORDER BY date_com DESC ")->result_array();
        
		if ($id_fournisseur1 == 'TOUT') {
            # code...
         $query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,etat_dem,etat_dem1,delegue,code_camion,bl,client,destination,marchandiseD,marchandiseR,immatriculation,litrage,frais_route,frais_retour,rj,rj1,rj2,ligne,pont,tour,date_dem1 from demande_frais where marchandiseD <> 'CIMENT_32.5' and marchandiseD <> 'CIMENT_42.5'  and marchandiseR <> 'CIMENT_32.5' and marchandiseR <> 'CIMENT_42.5' and date_dem between '".$date_debut."' and '".$date_fin."' order by date_dem DESC")->result_array();
        
		}else {
			
		  $query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,etat_dem,etat_dem1,etat_dem1,delegue,code_camion,bl,client,destination,marchandiseD,marchandiseR,immatriculation,litrage,frais_route,frais_retour,rj,rj1,rj2,ligne,pont,tour,date_dem1 from demande_frais where marchandiseD <> 'CIMENT_32.5' and marchandiseD <> 'CIMENT_42.5'  and marchandiseR <> 'CIMENT_32.5' and marchandiseR <> 'CIMENT_42.5' and  delegue = '".$id_fournisseur1."' and date_dem between '".$date_debut."' and '".$date_fin."'  order by date_dem DESC ")->result_array();
			
		}	
		
		}else{
			
			$query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,etat_dem,etat_dem1,delegue,code_camion,bl,client,destination,marchandiseD,marchandiseR,immatriculation,litrage,frais_route,frais_retour,rj,rj1,rj2,ligne,pont,tour,date_dem1 from demande_frais where marchandiseD <> 'CIMENT_32.5' and marchandiseD <> 'CIMENT_42.5'  and marchandiseR <> 'CIMENT_32.5' and marchandiseR <> 'CIMENT_42.5' and  date_dem = '".$date."' ORDER BY id_demande DESC")->result_array();    
        }		
		  
		}else{
			
			$query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,etat_dem,etat_dem1,delegue,code_camion,bl,client,destination,marchandiseD,marchandiseR,immatriculation,litrage,frais_route,frais_retour,rj,rj1,rj2,ligne,pont,tour,date_dem1 from demande_frais where marchandiseD <> 'CIMENT_32.5' and marchandiseD <> 'CIMENT_42.5'  and marchandiseR <> 'CIMENT_32.5' and marchandiseR <> 'CIMENT_42.5' and date_dem = '".$date."' ORDER BY id_demande DESC")->result_array();    
        }			
		
		if (count($query1) >0 ) {
            # code...
            $compteur = 0;
			foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td>".$row['po_dem']."</td>
					<td>".$row['delegue']."</td>
                    <td>".$row['date_dem']."</td>	
                    <td>".$row['code_camion']."</td>
					<td>".$row['immatriculation']."</td>";
					
					$getClient = $this->db->query("SELECT * from clientfrais where id_client = ".$row['client']."")->row();
  				
					$getDestination = $this->db->query("SELECT * from distance_littrage where id_distance = ".$row['destination']."")->row();
					
                    echo"
					<td> ".$getClient->nom." </td>
					
					<td> ".$getDestination->distance." </td>
					
					<td>".$row['marchandiseD']."</td>
					
					<td>".$row['marchandiseR']."</td>
					
					<td>".$row['tour']."</td>
					
					
                    <td>";
                if($this->session->userdata('demande_modification')=='true'){
                   echo" <button type='button' onclick='getDetailDemmandePourModificationC(\"".$row['date_dem']."\",\"".$row['po_dem']."\",\"".$row['etat_dem']."\",\"".$row['etat_dem1']."\",\"".$row['rj']."\",\"".$row['rj1']."\",\"".$row['rj2']."\",\"".$row['ligne']."\" )'  class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                 }

         			
                  $compteur++;
			}
		
		}

        $this->db->close();
    }



public function selectAllDemmande(){

   
   $date = date('Y-m-d');
   
  
	if (isset($_POST["date_debut"]) && isset($_POST["date_fin"]) && isset($_POST["id_fournisseur1"])) {
            # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $id_fournisseur1 = $_POST['id_fournisseur1'];
        


		if (!empty($date_fin) && !empty($date_debut) && isset($_POST["id_fournisseur1"])) {

     //       $query1 = $this->db->query("SELECT distinct po_com,id_fournisseur_article,date_com,date_crea,etat_exp,etat_recep,id_commande,id_article,code_camion,description from commande where id_fournisseur_article = ".$id_fournisseur1." and date_com between '".$date_debut."' and '".$date_fin."'  group by po_com ORDER BY date_com DESC ")->result_array();
        
		if ($id_fournisseur1 == 'TOUT') {
            # code...
         $query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,heure_dem,etat_dem,etat_dem1,delegue,code_camion,bl,client,destination,marchandiseD,marchandiseR,immatriculation,litrage,frais_route,frais_retour,rj,rj1,rj2,ligne,pont,tour,date_dem1 from demande_frais where date_dem between '".$date_debut."' and '".$date_fin."' order by date_dem DESC")->result_array();
        
		}else {
			
		  $query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,heure_dem,etat_dem,etat_dem1,etat_dem1,delegue,code_camion,bl,client,destination,marchandiseD,marchandiseR,immatriculation,litrage,frais_route,frais_retour,rj,rj1,rj2,ligne,pont,tour,date_dem1 from demande_frais where delegue = '".$id_fournisseur1."' and date_dem between '".$date_debut."' and '".$date_fin."'  order by date_dem DESC ")->result_array();
			
		}	
		
		}else{
			
			$query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,heure_dem,etat_dem,etat_dem1,delegue,code_camion,bl,client,destination,marchandiseD,marchandiseR,immatriculation,litrage,frais_route,frais_retour,rj,rj1,rj2,ligne,pont,tour,date_dem1 from demande_frais where date_dem = '".$date."' ORDER BY id_demande DESC")->result_array();    
        }		
		  
		}else{
			
			$query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,heure_dem,etat_dem,etat_dem1,delegue,code_camion,bl,client,destination,marchandiseD,marchandiseR,immatriculation,litrage,frais_route,frais_retour,rj,rj1,rj2,ligne,pont,tour,date_dem1 from demande_frais where date_dem = '".$date."' ORDER BY id_demande DESC")->result_array();    
        }			
		
		if (count($query1) >0 ) {
            # code...
            $compteur = 0;
			$type_vehicule="";
			foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    
                    <td>".$row['po_dem']."</td>
					<td>".$row['delegue']."</td>
                    <td>".$row['date_dem']."</td>
					<td>".$row['heure_dem']."</td>
					
					<td>".$row['bl']."</td>  
					<td>".$row['date_dem1']."</td>					
                    <td>".$row['code_camion']."</td>
					<td>".$row['immatriculation']."</td>";
					
					
  $getTypeCamion = $this->db->query("SELECT * from type_vehicule where id_type = (SELECT id_type_camion  from camion_benne where code = '".$row["code_camion"]."')")->row();  
 
   if (count($getTypeCamion) >0 ) {
  $type_vehicule = $getTypeCamion-> nom_type;
    }	


$getTypeCamion1 = $this->db->query("SELECT * from type_vehicule where id_type = (SELECT id_type_camion  from tracteur where code = '".$row["code_camion"]."')")->row();  
 
   if (count($getTypeCamion1) >0 ) {
  $type_vehicule = $getTypeCamion1-> nom_type;
    }	
					
					$getClient = $this->db->query("SELECT * from clientfrais where id_client = ".$row['client']."")->row();
                   
					
					$getDestination = $this->db->query("SELECT * from distance_littrage where id_distance = ".$row['destination']."")->row();
					
                    echo"
					<td> ".$type_vehicule." </td>
					<td> ".$getClient->nom." </td>
					<td> ".$getDestination->distance." </td>
					
					
					<td>".$row['marchandiseD']."</td>
					
					
					<td>".$row['frais_route']/$row['tour']."</td>
					<td>".$row['marchandiseR']."</td>
					<td>".$row['frais_retour']/$row['tour']."</td>
					<td>".$row['pont']."</td>
					<td>".$row['tour']."</td>
					
					<td>".$row['etat_dem']." </td>
					<td>".$row['etat_dem1']." </td>
                    <td>";
                if($this->session->userdata('demande_modification')=='true'){
                   echo" <button type='button' onclick='getDetailDemmandePourModification(\"".$row['date_dem']."\",\"".$row['po_dem']."\",\"".$row['etat_dem']."\",\"".$row['etat_dem1']."\",\"".$row['rj']."\",\"".$row['rj1']."\",\"".$row['rj2']."\",\"".$row['ligne']."\" )'  class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                 }

         			 $query2 = $this->db->query("SELECT rj,rj1 from demande_frais where po_dem = '".$row['po_dem']."' and (rj= 'oui' or rj1 ='oui') limit 1")->row(); 
	  
	  
					if (count($query2) >0 ) {

		  
					  echo"  <button type='button'   class=' btn-primary btn-sm' onclick='detailDemande(\"".$row['po_dem']."\",\"".$row['delegue']."\",\"".$row['date_dem']."\",\"".$row['etat_dem']."\",\"".$row['etat_dem1']."\",\"".number_format($this->getMontantDemandeLitrage($row['po_dem']),0,',',' ')."\",\"".number_format($this->getMontantDemandeFraisRoute($row['po_dem']),0,',',' ')."\",\"".number_format($this->getMontantDemandeFraisRetour($row['po_dem']),0,',',' ')."\",\"".number_format($this->getMontantDemandePont($row['po_dem']),0,',',' ')."\",\"".number_format($this->getMontantTotal($row['po_dem']),0,',',' ')."\",\"".$this->getSignatureDAF($row['po_dem'])."\",\"".$this->getSignatureDGT($row['po_dem'])."\",\"".number_format($this->getCompteurTotal($row['po_dem']),0,',',' ')."\")'><i class='nav-icon '>+</i></button>";
					
					}
	

                if($this->session->userdata('demande_suppression')=='true'){
                  echo"  <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='demande_frais' identifiant='".$row['po_dem']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"po_dem\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
			}
		
		}

        $this->db->close();
    }
	
public function selectAllDemmandeN(){
	
   $date = date('Y-m-d');
   
  
	if (isset($_POST["date_debut"]) && isset($_POST["date_fin"]) && isset($_POST["id_fournisseur1"])) {
            # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $id_fournisseur1 = $_POST['id_fournisseur1'];
        


		if (!empty($date_fin) && !empty($date_debut) && isset($_POST["id_fournisseur1"])) {

     //       $query1 = $this->db->query("SELECT distinct po_com,id_fournisseur_article,date_com,date_crea,etat_exp,etat_recep,id_commande,id_article,code_camion,description from commande where id_fournisseur_article = ".$id_fournisseur1." and date_com between '".$date_debut."' and '".$date_fin."'  group by po_com ORDER BY date_com DESC ")->result_array();
        
		if ($id_fournisseur1 == 'TOUT') {
            # code...
         $query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,heure_dem,etat_dem,etat_dem1,delegue,code_camion,client,destination,immatriculation,litrage,rj,rj1,rj2,ligne,operation,tour,fournisseur,date_dem1 from demande_navette where date_dem between '".$date_debut."' and '".$date_fin."' order by date_dem DESC")->result_array();
        
		}else {
			
		  $query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,heure_dem,etat_dem,etat_dem1,delegue,code_camion,client,destination,immatriculation,litrage,rj,rj1,rj2,ligne,operation,tour,fournisseur,date_dem1 from demande_navette where delegue = '".$id_fournisseur1."' and date_dem between '".$date_debut."' and '".$date_fin."'  order by date_dem DESC ")->result_array();
			
		}	
		
		}else{
			
			$query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,heure_dem,etat_dem,etat_dem1,delegue,code_camion,client,destination,immatriculation,litrage,rj,rj1,rj2,ligne,operation,tour,fournisseur,date_dem1 from demande_navette where date_dem = '".$date."' ORDER BY id_demande DESC")->result_array();    
        }		
		  
		}else{
			
			$query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,heure_dem,etat_dem,etat_dem1,delegue,code_camion,client,destination,immatriculation,litrage,rj,rj1,rj2,ligne,operation,tour,fournisseur,date_dem1 from demande_navette where date_dem = '".$date."' ORDER BY id_demande DESC")->result_array();    
        }			
		
		if (count($query1) >0 ) {
            # code...
            $compteur = 0;
			$type_vehicule="";
			foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
             					   
                    <td>".$row['po_dem']."</td>";
				$getOperation = $this->db->query("SELECT * from operation where id_operation = ".$row['operation']."")->row();    
				echo"
					<td>".$getOperation->nom_op."</td>
					<td>".$row['delegue']."</td>
                    <td>".$row['date_dem']."</td>
					<td>".$row['heure_dem']."</td>
					
					
					
                    <td>".$row['code_camion']."</td>
					<td>".$row['immatriculation']."</td>";
					
					
  $getTypeCamion = $this->db->query("SELECT * from type_vehicule where id_type = (SELECT id_type_camion  from camion_benne where code = '".$row["code_camion"]."')")->row();  
 
   if (count($getTypeCamion) >0 ) {
  $type_vehicule = $getTypeCamion-> nom_type;
    }	


$getTypeCamion1 = $this->db->query("SELECT * from type_vehicule where id_type = (SELECT id_type_camion  from tracteur where code = '".$row["code_camion"]."')")->row();  
 
   if (count($getTypeCamion1) >0 ) {
  $type_vehicule = $getTypeCamion1-> nom_type;
    }	
					
					$getClient = $this->db->query("SELECT * from clientfrais where id_client = ".$row['client']."")->row();
                   
					
					$getDestination = $this->db->query("SELECT * from distance_littrage where id_distance = ".$row['destination']."")->row();
					
					$getFournisseur = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur = ".$row['fournisseur']."")->row();
					
                    echo"
					<td> ".$type_vehicule." </td>
					<td> ".$getClient->nom." </td>
					<td> ".$getDestination->distance." </td>
				<td>".$row['litrage']."</td>
					<td>".$row['tour']."</td>
					<td>".$getFournisseur->nom."</td>
					<td>".$row['date_dem1']."</td>
					
					<td>".$row['etat_dem']." </td>
					
                    <td>";
                if($this->session->userdata('operation_gazoil_modification')=='true'){
                   echo" <button type='button' onclick='getDetailDemmandePourModificationN(\"".$row['date_dem']."\",\"".$row['po_dem']."\",\"".$row['operation']."\",\"".$row['etat_dem']."\",\"".$row['etat_dem1']."\",\"".$row['rj']."\",\"".$row['rj1']."\",\"".$row['rj2']."\",\"".$row['ligne']."\" )'  class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                 }

         			 $query2 = $this->db->query("SELECT rj,rj1 from demande_navette where po_dem = '".$row['po_dem']."' and (rj= 'oui' or rj1 ='oui') limit 1")->row(); 
	  
	  
					if (count($query2) >0 ) {

		  
					  echo"  <button type='button'   class=' btn-primary btn-sm' onclick='detailDemandeN(\"".$row['po_dem']."\",\"".$this->getNomOperation($row['operation'])."\",\"".$row['delegue']."\",\"".$row['date_dem']."\",\"".$row['etat_dem']."\",\"".$row['etat_dem1']."\",\"".number_format($this->getMontantDemandeLitrageNTotal($row['po_dem']),0,',',' ')."\",\"".$this->getSignatureDAFN($row['po_dem'])."\",\"".$this->getSignatureDGTN($row['po_dem'])."\",\"".number_format($this->getCompteurTotalN($row['po_dem']),0,',',' ')."\")'><i class='nav-icon '>+</i></button>";
					
					}
	

                if($this->session->userdata('demande_suppression')=='true'){
                  echo"  <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='demande_navette' identifiant='".$row['po_dem']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"po_dem\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
			}
		
		}

        $this->db->close();
    }
	
	
public function selectAllDemmandeE(){
	
   $date = date('Y-m-d');
   
  
	if (isset($_POST["date_debut"]) && isset($_POST["date_fin"]) && isset($_POST["id_fournisseur1"])) {
            # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $id_fournisseur1 = $_POST['id_fournisseur1'];
        


		if (!empty($date_fin) && !empty($date_debut) && isset($_POST["id_fournisseur1"])) {

     //       $query1 = $this->db->query("SELECT distinct po_com,id_fournisseur_article,date_com,date_crea,etat_exp,etat_recep,id_commande,id_article,code_camion,description from commande where id_fournisseur_article = ".$id_fournisseur1." and date_com between '".$date_debut."' and '".$date_fin."'  group by po_com ORDER BY date_com DESC ")->result_array();
        
		if ($id_fournisseur1 == 'TOUT') {
            # code...
         $query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,heure_dem,etat_dem,etat_dem1,delegue,code_camion,client,destination,immatriculation,litrage,rj,rj1,rj2,ligne,operation,tour,fournisseur,date_dem1 from demande_engin where date_dem between '".$date_debut."' and '".$date_fin."' order by date_dem DESC")->result_array();
        
		}else {
			
		  $query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,heure_dem,etat_dem,etat_dem1,delegue,code_camion,client,destination,immatriculation,litrage,rj,rj1,rj2,ligne,operation,tour,fournisseur,date_dem1 from demande_engin where delegue = '".$id_fournisseur1."' and date_dem between '".$date_debut."' and '".$date_fin."'  order by date_dem DESC ")->result_array();
			
		}	
		
		}else{
			
			$query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,heure_dem,etat_dem,etat_dem1,delegue,code_camion,client,destination,immatriculation,litrage,rj,rj1,rj2,ligne,operation,tour,fournisseur,date_dem1 from demande_engin where date_dem = '".$date."' ORDER BY id_demande DESC")->result_array();    
        }		
		  
		}else{
			
			$query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,heure_dem,etat_dem,etat_dem1,delegue,code_camion,client,destination,immatriculation,litrage,rj,rj1,rj2,ligne,operation,tour,fournisseur,date_dem1 from demande_engin where date_dem = '".$date."' ORDER BY id_demande DESC")->result_array();    
        }			
		
		if (count($query1) >0 ) {
            # code...
            $compteur = 0;
			$type_vehicule="";
			foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
             					   
                    <td>".$row['po_dem']."</td>";
				$getOperation = $this->db->query("SELECT * from operation where id_operation = ".$row['operation']."")->row();    
				echo"
					<td>".$getOperation->nom_op."</td>
					
                    <td>".$row['date_dem']."</td>
					<td>".$row['heure_dem']."</td>
					
					
					
                    <td>".$row['code_camion']."</td>
					<td>".$row['immatriculation']."</td>";
					
					
  $getTypeCamion = $this->db->query("SELECT * from type_vehicule where id_type = (SELECT id_type_camion  from engin where code = '".$row["code_camion"]."')")->row();  
 
   if (count($getTypeCamion) >0 ) {
  $type_vehicule = $getTypeCamion-> nom_type;
    }	


	
					
					$getClient = $this->db->query("SELECT * from clientfrais where id_client = ".$row['client']."")->row();
                   
					
					$getDestination = $this->db->query("SELECT * from distance_littrage where id_distance = ".$row['destination']."")->row();
					
					$getFournisseur = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur = ".$row['fournisseur']."")->row();
					
                    echo"
					<td> ".$type_vehicule." </td>
					<td> ".$getClient->nom." </td>
					<td> ".$getDestination->distance." </td>
				    <td>".$row['litrage']."</td>
					<td>".$row['tour']."</td>
					<td>".$getFournisseur->nom."</td>
					<td>".$row['date_dem1']."</td>
					
					<td>".$row['etat_dem']." </td>
					
                    <td>";
                if($this->session->userdata('operation_gazoil_modification')=='true'){
                   echo" <button type='button' onclick='getDetailDemmandePourModificationE(\"".$row['date_dem']."\",\"".$row['po_dem']."\",\"".$row['operation']."\",\"".$row['etat_dem']."\",\"".$row['etat_dem1']."\",\"".$row['rj']."\",\"".$row['rj1']."\",\"".$row['rj2']."\",\"".$row['ligne']."\" )'  class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                 }

         			 $query2 = $this->db->query("SELECT rj,rj1 from demande_engin where po_dem = '".$row['po_dem']."' and (rj= 'oui' or rj1 ='oui') limit 1")->row(); 
	  
	  
					if (count($query2) >0 ) {

		  
					  echo"  <button type='button'   class=' btn-primary btn-sm' onclick='detailDemandeE(\"".$row['po_dem']."\",\"".$this->getNomOperation($row['operation'])."\",\"".$row['delegue']."\",\"".$row['date_dem']."\",\"".$row['etat_dem']."\",\"".$row['etat_dem1']."\",\"".number_format($this->getMontantDemandeLitrageETotal($row['po_dem']),0,',',' ')."\",\"".$this->getSignatureDAFE($row['po_dem'])."\",\"".$this->getSignatureDGTN($row['po_dem'])."\",\"".number_format($this->getCompteurTotalN($row['po_dem']),0,',',' ')."\")'><i class='nav-icon '>+</i></button>";
					
					}
	

                if($this->session->userdata('demande_suppression')=='true'){
                  echo"  <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='demande_engin' identifiant='".$row['po_dem']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"po_dem\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
			}
		
		}

        $this->db->close();
    }

	
public function selectAllDemmandeNA(){
	
   $date = date('Y-m-d');
   
  
	if (isset($_POST["date_debut"]) && isset($_POST["date_fin"]) && isset($_POST["id_fournisseur1"])) {
            # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $id_fournisseur1 = $_POST['id_fournisseur1'];
        


		if (!empty($date_fin) && !empty($date_debut) && isset($_POST["id_fournisseur1"])) {

     //       $query1 = $this->db->query("SELECT distinct po_com,id_fournisseur_article,date_com,date_crea,etat_exp,etat_recep,id_commande,id_article,code_camion,description from commande where id_fournisseur_article = ".$id_fournisseur1." and date_com between '".$date_debut."' and '".$date_fin."'  group by po_com ORDER BY date_com DESC ")->result_array();
        
		if ($id_fournisseur1 == 'TOUT') {
            # code...
         $query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,heure_dem,etat_dem,etat_dem1,delegue,code_camion,client,destination,immatriculation,litrage,rj,rj1,rj2,ligne,operation,tour,fournisseur,date_dem1 from demande_navette_autre where date_dem between '".$date_debut."' and '".$date_fin."' order by date_dem DESC")->result_array();
        
		}else {
			
		  $query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,heure_dem,etat_dem,etat_dem1,delegue,code_camion,client,destination,immatriculation,litrage,rj,rj1,rj2,ligne,operation,tour,fournisseur,date_dem1 from demande_navette_autre where delegue = '".$id_fournisseur1."' and date_dem between '".$date_debut."' and '".$date_fin."'  order by date_dem DESC ")->result_array();
			
		}	
		
		}else{
			
			$query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,heure_dem,etat_dem,etat_dem1,delegue,code_camion,client,destination,immatriculation,litrage,rj,rj1,rj2,ligne,operation,tour,fournisseur,date_dem1 from demande_navette_autre where date_dem = '".$date."' ORDER BY id_demande DESC")->result_array();    
        }		
		  
		}else{
			
			$query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,heure_dem,etat_dem,etat_dem1,delegue,code_camion,client,destination,immatriculation,litrage,rj,rj1,rj2,ligne,operation,tour,fournisseur,date_dem1 from demande_navette_autre where date_dem = '".$date."' ORDER BY id_demande DESC")->result_array();    
        }			
		
		if (count($query1) >0 ) {
            # code...
            $compteur = 0;
			$type_vehicule="";
			foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
             					   
                    <td>".$row['po_dem']."</td>";
				$getOperation = $this->db->query("SELECT * from operation where id_operation = ".$row['operation']."")->row();    
				echo"
					<td>".$getOperation->nom_op."</td>
					<td>".$row['delegue']."</td>
                    <td>".$row['date_dem']."</td>
					<td>".$row['heure_dem']."</td>
					
					
					
                    <td>".$row['code_camion']."</td>
					<td>".$row['immatriculation']."</td>";
					
					
  $getTypeCamion = $this->db->query("SELECT * from type_vehicule where id_type = (SELECT id_type_camion  from camion_benne where code = '".$row["code_camion"]."')")->row();  
 
   if (count($getTypeCamion) >0 ) {
  $type_vehicule = $getTypeCamion-> nom_type;
    }	


$getTypeCamion1 = $this->db->query("SELECT * from type_vehicule where id_type = (SELECT id_type_camion  from tracteur where code = '".$row["code_camion"]."')")->row();  
 
   if (count($getTypeCamion1) >0 ) {
  $type_vehicule = $getTypeCamion1-> nom_type;
    }	
					
					$getClient = $this->db->query("SELECT * from clientfrais where id_client = ".$row['client']."")->row();
                   
					
					$getDestination = $this->db->query("SELECT * from distance_littrage where id_distance = ".$row['destination']."")->row();
					
					$getFournisseur = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur = ".$row['fournisseur']."")->row();
					
                    echo"
					<td> ".$type_vehicule." </td>
					<td> ".$getClient->nom." </td>
					<td> ".$getDestination->distance." </td>
				<td>".$row['litrage']."</td>
					<td>".$row['tour']."</td>
					<td>".$getFournisseur->nom."</td>
					<td>".$row['date_dem1']."</td>
					
					<td>".$row['etat_dem']." </td>
					
                    <td>";
                if($this->session->userdata('operation_gazoil_modification')=='true'){
                   echo" <button type='button' onclick='getDetailDemmandePourModificationNA(\"".$row['date_dem']."\",\"".$row['po_dem']."\",\"".$row['operation']."\",\"".$row['etat_dem']."\",\"".$row['etat_dem1']."\",\"".$row['rj']."\",\"".$row['rj1']."\",\"".$row['rj2']."\",\"".$row['ligne']."\" )'  class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                 }

         			 $query2 = $this->db->query("SELECT rj,rj1 from demande_navette_autre where po_dem = '".$row['po_dem']."' and (rj= 'oui' or rj1 ='oui') limit 1")->row(); 
	  
	  
					if (count($query2) >0 ) {

		  
					  echo"  <button type='button'   class=' btn-primary btn-sm' onclick='detailDemandeNA(\"".$row['po_dem']."\",\"".$this->getNomOperation($row['operation'])."\",\"".$row['delegue']."\",\"".$row['date_dem']."\",\"".$row['etat_dem']."\",\"".$row['etat_dem1']."\",\"".number_format($this->getMontantDemandeLitrageNATotal($row['po_dem']),0,',',' ')."\",\"".$this->getSignatureDAFNA($row['po_dem'])."\",\"".$this->getSignatureDGTNA($row['po_dem'])."\",\"".number_format($this->getCompteurTotalNA($row['po_dem']),0,',',' ')."\")'><i class='nav-icon '>+</i></button>";
					
					}
	

                if($this->session->userdata('demande_suppression')=='true'){
                  echo"  <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='demande_navette_autre' identifiant='".$row['po_dem']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"po_dem\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
			}
		
		}

        $this->db->close();
    }
	
	public function selectAllDemmandeST(){
	
   $date = date('Y-m-d');
   
  
	if (isset($_POST["date_debut"]) && isset($_POST["date_fin"]) && isset($_POST["id_fournisseur1"])) {
            # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $id_fournisseur1 = $_POST['id_fournisseur1'];
        


		if (!empty($date_fin) && !empty($date_debut) && isset($_POST["id_fournisseur1"])) {

         $query1 = $this->db->query("SELECT distinct po_com,id_fournisseur_article,date_com,date_crea,etat_exp,etat_recep,id_commande,id_article,v,description from commande where id_fournisseur_article = ".$id_fournisseur1." and date_com between '".$date_debut."' and '".$date_fin."'  group by po_com ORDER BY date_com DESC ")->result_array();
        
		if ($id_fournisseur1 == 'TOUT') {
            # code...
         $query1 = $this->db->query("SELECT  ref,vehicule,immatriculation,litrage,litrageP,date_stock,commentaire from demande_frais where stock > 0 and date_dem between '".$date_debut."' and '".$date_fin."'  order by date_dem DESC")->result_array();
        
		}else {
			
		  $query1 = $this->db->query("SELECT  ref,delegue,code_camion,immatriculation,tour,stock,litrage2,litrage1,date_dem,commentaire from demande_frais where delegue = '".$id_fournisseur1."' and stock > 0 and date_dem between '".$date_debut."' and '".$date_fin."' order by date_dem DESC ")->result_array();
			
		}	
		
		}else{
			
			$query1 = $this->db->query("SELECT  ref,date_stock,vehicule,matricule,litrageA,litrageC,litrageP, commentaire, ligne from stock_vehicule where litrageP > 0 and date_demande = '".$date."' ORDER BY ref DESC")->result_array();    
        }		
		  
		}else{
			
			$query1 = $this->db->query("SELECT  ref,date_stock,vehicule,matricule,litrageA,litrageC,litrageP, commentaire, ligne from stock_vehicule where litrageP > 0 ORDER BY ref DESC")->result_array();    
        }			
		
		if (count($query1) >0 ) {
            # code...
            $compteur = 0;
			$type_vehicule="";
			foreach ($query1 as $row) {
            # code...

            echo "<tr >
			
                    <td>".$row['date_stock']."</td>
             		
                    <td>".$row['vehicule']."</td>
					<td>".$row['matricule']."</td>";
					
					
  $getTypeCamion = $this->db->query("SELECT * from type_vehicule where id_type = (SELECT id_type_camion  from camion_benne where code = '".$row["vehicule"]."')")->row();  
 
   if (count($getTypeCamion) >0 ) {
  $type_vehicule = $getTypeCamion-> nom_type;
    }	


$getTypeCamion1 = $this->db->query("SELECT * from type_vehicule where id_type = (SELECT id_type_camion  from tracteur where code = '".$row["vehicule"]."')")->row();  
 
   if (count($getTypeCamion1) >0 ) {
  $type_vehicule = $getTypeCamion1-> nom_type;
    }	
		            echo"
					<td> ".$type_vehicule." </td>
					
				<td>".$row['litrageA']."</td>
				
				<td>".$row['litrageC']."</td>
				
				<td>".$row['litrageP']."</td>
				
				
					
				<td>".$row['commentaire']."</td>	
					
					
                    <td>";
                if($this->session->userdata('operation_gazoil_modification')=='true'){
          //       echo" <button type='button' onclick='getDetailDemmandePourModificationST(\"".$row['date_dem']."\",\"".$row['po_dem']."\",\"".$row['operation']."\",\"".$row['etat_dem']."\",\"".$row['etat_dem1']."\",\"".$row['rj']."\",\"".$row['rj1']."\",\"".$row['rj2']."\",\"".$row['ligne']."\" )'  class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                 }

         			 $query2 = $this->db->query("SELECT * from stock_vehicule where ref = '".$row['ref']."'  limit 1")->row(); 
	  
	  
					if (count($query2) >0 ) {

		  
		//			  echo"  <button type='button'   class=' btn-primary btn-sm' onclick='detailDemandeNA(\"".$row['po_dem']."\",\"".$this->getNomOperation($row['operation'])."\",\"".$row['delegue']."\",\"".$row['date_dem']."\",\"".$row['etat_dem']."\",\"".$row['etat_dem1']."\",\"".number_format($this->getMontantDemandeLitrageNATotal($row['po_dem']),0,',',' ')."\",\"".$this->getSignatureDAFNA($row['po_dem'])."\",\"".$this->getSignatureDGTNA($row['po_dem'])."\",\"".number_format($this->getCompteurTotalNA($row['po_dem']),0,',',' ')."\")'><i class='nav-icon '>+</i></button>";
					
					}
	

                if($this->session->userdata('demande_suppression')=='true'){
                 echo"  <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='stock_vehicule' identifiant='".$row['ref']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"ref\");'><i class='far fa-trash-alt'></i></button>
                  </td>
                  </tr>

                  ";}
                  $compteur++;
			}
		
		}

        $this->db->close();
    }
	
	
public function selectAllDemmandeSTOLD(){
	
   $date = date('Y-m-d');
   
  
	if (isset($_POST["date_debut"]) && isset($_POST["date_fin"]) && isset($_POST["id_fournisseur1"])) {
            # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $id_fournisseur1 = $_POST['id_fournisseur1'];
        


		if (!empty($date_fin) && !empty($date_debut) && isset($_POST["id_fournisseur1"])) {

     //       $query1 = $this->db->query("SELECT distinct po_com,id_fournisseur_article,date_com,date_crea,etat_exp,etat_recep,id_commande,id_article,code_camion,description from commande where id_fournisseur_article = ".$id_fournisseur1." and date_com between '".$date_debut."' and '".$date_fin."'  group by po_com ORDER BY date_com DESC ")->result_array();
        
		if ($id_fournisseur1 == 'TOUT') {
            # code...
         $query1 = $this->db->query("SELECT  ,delegue,code_camion,immatriculation,tour,stock,litrage2,litrage1,date_dem,commentaire from demande_frais where stock > 0 and date_dem between '".$date_debut."' and '".$date_fin."'  order by date_dem DESC")->result_array();
        
		}else {
			
		  $query1 = $this->db->query("SELECT  id_demande,delegue,code_camion,immatriculation,tour,stock,litrage2,litrage1,date_dem,commentaire from demande_frais where delegue = '".$id_fournisseur1."' and stock > 0 and date_dem between '".$date_debut."' and '".$date_fin."' order by date_dem DESC ")->result_array();
			
		}	
		
		}else{
			
			$query1 = $this->db->query("SELECT  id_demande,delegue,code_camion,immatriculation,tour,stock,litrage2,litrage1,date_dem,commentaire from demande_frais where stock > 0 and date_dem = '".$date."' ORDER BY id_demande DESC")->result_array();    
        }		
		  
		}else{
			
			$query1 = $this->db->query("SELECT  id_demande,delegue,code_camion,immatriculation,tour,stock,litrage2,litrage1,date_dem,commentaire from demande_frais where stock > 0 ORDER BY id_demande DESC")->result_array();    
        }			
		
		if (count($query1) >0 ) {
            # code...
            $compteur = 0;
			$type_vehicule="";
			foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
             					   
                    
					<td>".$row['delegue']."</td>
                    			
					
					
                    <td>".$row['code_camion']."</td>
					<td>".$row['immatriculation']."</td>";
					
					
  $getTypeCamion = $this->db->query("SELECT * from type_vehicule where id_type = (SELECT id_type_camion  from camion_benne where code = '".$row["code_camion"]."')")->row();  
 
   if (count($getTypeCamion) >0 ) {
  $type_vehicule = $getTypeCamion-> nom_type;
    }	


$getTypeCamion1 = $this->db->query("SELECT * from type_vehicule where id_type = (SELECT id_type_camion  from tracteur where code = '".$row["code_camion"]."')")->row();  
 
   if (count($getTypeCamion1) >0 ) {
  $type_vehicule = $getTypeCamion1-> nom_type;
    }	
		            echo"
					<td> ".$type_vehicule." </td>
					
				<td>".$row['stock']."</td>
				
				<td>".$row['date_dem']."</td>
					
				<td>".$row['commentaire']."</td>	
					
					
                    <td>";
                if($this->session->userdata('operation_gazoil_modification')=='true'){
        //         echo" <button type='button' onclick='getDetailDemmandePourModificationNA(\"".$row['date_dem']."\",\"".$row['po_dem']."\",\"".$row['operation']."\",\"".$row['etat_dem']."\",\"".$row['etat_dem1']."\",\"".$row['rj']."\",\"".$row['rj1']."\",\"".$row['rj2']."\",\"".$row['ligne']."\" )'  class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                 }

         			 $query2 = $this->db->query("SELECT rj,rj1 from demande_navette_autre where po_dem = '".$row['id_demande']."' and (rj= 'oui' or rj1 ='oui') limit 1")->row(); 
	  
	  
					if (count($query2) >0 ) {

		  
		//			  echo"  <button type='button'   class=' btn-primary btn-sm' onclick='detailDemandeNA(\"".$row['po_dem']."\",\"".$this->getNomOperation($row['operation'])."\",\"".$row['delegue']."\",\"".$row['date_dem']."\",\"".$row['etat_dem']."\",\"".$row['etat_dem1']."\",\"".number_format($this->getMontantDemandeLitrageNATotal($row['po_dem']),0,',',' ')."\",\"".$this->getSignatureDAFNA($row['po_dem'])."\",\"".$this->getSignatureDGTNA($row['po_dem'])."\",\"".number_format($this->getCompteurTotalNA($row['po_dem']),0,',',' ')."\")'><i class='nav-icon '>+</i></button>";
					
					}
	

                if($this->session->userdata('demande_suppression')=='true'){
           //       echo"  <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='demande_navette_autre' identifiant='".$row['id_demande']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"po_dem\");'><i class='far fa-trash-alt'></i></button>
                echo"    </td>
                  </tr>

                  ";}
                  $compteur++;
			}
		
		}

        $this->db->close();
    }



	
public function selectAllDemmandeG(){
	
   $date = date('Y-m-d');
   
           $compteur = 0;
			 $compteur1 = 0;
			$compteurC=0;	
			$compteurT=0;	
			$compteurL=0;	
			$compteurS=0;
			$compteurR=0;	
			$compteurTO=0;	
   
  
	if (isset($_POST["date_debut"]) && isset($_POST["date_fin"]) && isset($_POST["id_fournisseur1"])) {
            # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $id_fournisseur1 = $_POST['id_fournisseur1'];
        


		if (!empty($date_fin) && !empty($date_debut) && isset($_POST["id_fournisseur1"])) {

     //       $query1 = $this->db->query("SELECT distinct po_com,id_fournisseur_article,date_com,date_crea,etat_exp,etat_recep,id_commande,id_article,code_camion,description from commande where id_fournisseur_article = ".$id_fournisseur1." and date_com between '".$date_debut."' and '".$date_fin."'  group by po_com ORDER BY date_com DESC ")->result_array();
        
		if ($id_fournisseur1 == 'TOUT') {
            # code...
         $query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,etat_dem,etat_dem1,etat_dem2,delegue,code_camion,bl,client,destination,marchandiseD,marchandiseR,immatriculation,litrage,frais_route,frais_retour,rj,rj1,rj2,ligne,pont,fournisseur,complement,detail,tour,tonnage,AG,CON,date_dem1,litrage1,litrage2,stock from demande_frais where rj = 'oui'  and date_dem between '".$date_debut."' and '".$date_fin."'  order by date_dem DESC")->result_array();
        
		}else {
			
		  $query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,etat_dem,etat_dem1,etat_dem2,delegue,code_camion,bl,client,destination,marchandiseD,marchandiseR,immatriculation,litrage,frais_route,frais_retour,rj,rj1,rj2,ligne,pont,fournisseur,complement,detail,tour,tonnage,AG,CON,date_dem1,litrage1,litrage2,stock from demande_frais where rj = 'oui' and delegue = '".$id_fournisseur1."' and date_dem between '".$date_debut."' and '".$date_fin."'   order by date_dem DESC ")->result_array();
			
		}	
		
		}else{
			
			$query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,etat_dem,etat_dem1,etat_dem2,delegue,code_camion,bl,client,destination,marchandiseD,marchandiseR,immatriculation,litrage,frais_route,frais_retour,rj,rj1,rj2,ligne,pont,fournisseur,complement,detail,tour,tonnage,AG,CON,date_dem1,litrage1,litrage2,stock from demande_frais where rj = 'oui'  and date_dem = '".$date."'  ORDER BY id_demande DESC")->result_array();    
        }		
		  
		}else{
			
			$query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,etat_dem,etat_dem1,etat_dem2,delegue,code_camion,bl,client,destination,marchandiseD,marchandiseR,immatriculation,litrage,frais_route,frais_retour,rj,rj1,rj2,ligne,pont,fournisseur,complement,detail,tour,tonnage,AG,CON,date_dem1,litrage1,litrage2,stock from demande_frais where rj = 'oui'  and date_dem = '".$date."'  ORDER BY id_demande DESC")->result_array();    
        }	



		
		
		if (count($query1) >0 ) {
            # code...
    
			
			  $type_vehicule="";
			foreach ($query1 as $row) {
            # code...
            $compteur1 =$row['complement'] + ($row['litrage']*$row['tour']); 
			$compteurC =$row['complement'] + $compteurC;
			$compteurL =$row['litrage'] + $compteurL;	
			$compteurT =$row['tour'] + $compteurT;	
			$compteurS =$row['litrage2'] + $compteurS;	
			$compteurR =$row['litrage1'] + $compteurR;	
			$compteurTO =$row['tonnage'] + $compteurTO;		
			
            echo "<tr >
                    
                  
				   
                    <td>".$row['po_dem']."</td>
					<td>".$row['delegue']."</td>
                    <td>".$row['date_dem']."</td>
					<td>".$row['bl']."</td>                
                    <td>".$row['code_camion']."</td>
					<td>".$row['immatriculation']."</td>";
		

 $getTypeCamion = $this->db->query("SELECT * from type_vehicule where id_type = (SELECT id_type_camion  from camion_benne where code = '".$row["code_camion"]."')")->row();  
 		
					  if (count($getTypeCamion) >0 ) {
  $type_vehicule = $getTypeCamion-> nom_type;
    }	


$getTypeCamion1 = $this->db->query("SELECT * from type_vehicule where id_type = (SELECT id_type_camion  from tracteur where code = '".$row["code_camion"]."')")->row();  
 
   if (count($getTypeCamion1) >0 ) {
  $type_vehicule = $getTypeCamion1-> nom_type;
    }	
					
					$getClient = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur = ".$row['fournisseur']."")->row();
                   
					
					$getDestination = $this->db->query("SELECT * from distance_littrage where id_distance = ".$row['destination']."")->row();
                    echo"
					<td> ". $type_vehicule." </td>
					<td> ".$getDestination->distance." </td>
					<td> ".$getClient->nom." </td>
					
					<td>".$row['litrage']."</td>
					<td>".$row['tour']."</td>
					<td>".$row['complement']."</td>";
					
	 $getStockCamion1 = $this->db->query("SELECT * from stock_vehicule where vehicule = '".$row["code_camion"]."' and date_stock = '".$row["date_dem"]."'")->row();  
	 
if (count($getStockCamion1) >0) {
				
		            echo" 
		   
					<td>".$getStockCamion1->litrageP."</td>";
		
				
				}else{ 						
					
			       echo"	 <td>0</td>";
		
				
				}
				
				echo"	<td>".$row['litrage1']."</td>
					<td>".$row['tonnage']."</td>
					
					
					<td>".$row['detail']."</td>
					<td>".$row['CON']."</td>
					<td>".$row['AG']."</td>
                    <td>";
                if($this->session->userdata('operation_gazoil_modification')=='true'){
                   echo" <button type='button' onclick='getDetailDemmandePourModificationG(\"".$row['date_dem']."\",\"".$row['etat_dem2']."\",\"".$row['rj2']."\",\"".$row['po_dem']."\",\"".$row['ligne']."\",\"".$row['fournisseur']."\")'  class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                 }
					 
					 $query2 = $this->db->query("SELECT rj,rj1 from demande_frais where po_dem = '".$row['po_dem']."' and (rj= 'oui' or rj1 ='oui') limit 1")->row(); 
	  
         		//	 $query2 = $this->db->query("SELECT rj,rj1,rj2 from demande_frais where po_dem = '".$row['po_dem']."' and rj2= 'oui'  limit 1")->row(); 
	  
	  
					if (count($query2) >0 ) {

		  
					  echo"  <button type='button'   class=' btn-primary btn-sm' onclick='detailDemandeG(\"".$row['po_dem']."\",\"".$row['delegue']."\",\"".$row['date_dem']."\",\"".$row['etat_dem']."\",\"".$row['etat_dem1']."\",\"".number_format($this->getMontantDemandeLitrage($row['po_dem']),0,',',' ')."\",\"".number_format($this->getMontantDemandeComplement($row['po_dem']),0,',',' ')."\",\"".number_format($this->getMontantTotalComplement($row['po_dem']),0,',',' ')."\",\"".number_format($this->getMontantTotalStock($row['po_dem']),0,',',' ')."\",\"".number_format($this->getTotalSacsDemande($row['po_dem']),0,',',' ')."\",\"".$this->getSignatureDAF($row['po_dem'])."\",\"".$this->getSignatureDGT($row['po_dem'])."\",\"".number_format($this->getCompteurTotal($row['po_dem']),0,',',' ')."\")'><i class='nav-icon '>+</i></button>";
					
					}
	

          
                  $compteur++;
			}
		
		}
		
		echo "<tr>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>TOTAUX</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
		 <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteurL,0,',',' ')."</td>
		<td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteurT,0,',',' ')."</td>
		<td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteurC,0,',',' ')."</td>
		<td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteurS,0,',',' ')."</td>
		<td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteurR,0,',',' ')."</td>
		<td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteurTO,0,',',' ')."</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
		        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
       
	</tr>";

        $this->db->close();
    }

	
	
public function addDemande(){
	
    //Entete de la commande
	//$po = $_POST['po'];
	$po = $this->genererChaineAleatoireDemande();
	$date_demande = $_POST['date_demande'];
	$etat_demande = $_POST['etat_demande'];
	$etat_demande1 = $_POST['etat_demande1'];
    
    // detail de la commande
    $nbreLignes = $_POST["nbreLignes"];
	
	$rj = $_POST['rj'];
	$rj1 = $_POST['rj1'];
	$rj2 = $_POST['rj2'];
	
	   

    $delegue = json_decode($_POST['delegue']);
    $bl = json_decode($_POST['bl']);
	$date_demande1 = json_decode($_POST['date_demande1']);
    $camion1 = json_decode($_POST['camion1']);
	$immatriculation1 = json_decode($_POST['immatriculation1']);
    $client = json_decode($_POST['client']);
    $destinationM = json_decode($_POST['destinationM']);
	$destination2 = json_decode($_POST['destination2']);
	$route = json_decode($_POST['route']);
	$routeM = json_decode($_POST['routeM']);
    $retour = json_decode($_POST['retour']);
	$retourM = json_decode($_POST['retourM']);
    $marchandiseD = json_decode($_POST['marchandiseD']);
	$marchandiseR = json_decode($_POST['marchandiseR']);
	$pont = json_decode($_POST['pont']);
	$pontM = json_decode($_POST['pontM']);
    $typeA = json_decode($_POST['typeA']);
	$gazoil = json_decode($_POST['gazoil']);
	$gazoilG = json_decode($_POST['gazoilG']);
	$kilometrage = json_decode($_POST['kilometrage']);
	$tour = json_decode($_POST['tour']);
	$tonnage = json_decode($_POST['tonnage']);
	$rjFR = json_decode($_POST['rjFR']);
	$rjFT = json_decode($_POST['rjFT']);
	$rjP = json_decode($_POST['rjP']);
	
	$id_demande = json_decode($_POST['id_demande']);
    $status = $_POST["status"];

    $nom_table = "demande_frais";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
	
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté la demande N° ".$po." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié la demande N° ".$po." le ".$date_notif." à ".$heure;



    if ($status == "insert") {
		
	 

	$etat_demande = 'DEMANDEE';
	
	$etat_demande1 = 'DEMANDEE';


	$i = 1;
	$somme_frais = 0;
	$gazoil_ligne = 0;
	$route_ligne = 0;
	$retour_ligne = 0;


    while ( $i<= $nbreLignes) {
	
	$route_ligne = 0;
	$retour_ligne = 0;
	$gazoil_ligne = 0;
	$somme_frais = 0;
	
	$route_ligne =  $route[$i] * $tour[$i] ;
	$retour_ligne =  $retour[$i] * $tour[$i] ; 
	$gazoil_ligne =  $gazoil[$i] * $tour[$i] ; 
	$somme_frais =  $route_ligne + $retour_ligne + $pont[$i];
	
	
	  
     $query = $this->db->query("INSERT into demande_frais value('','".$po."',CAST('". $date_demande."' AS DATE),'".$etat_demande."',".$destinationM[$i].",".$gazoil[$i].",".$route_ligne.",".$retour_ligne.",'".$camion1[$i]."','".$immatriculation1[$i]."',".$client[$i].",'".$bl[$i]."','".$marchandiseD[$i]."','".$marchandiseR[$i]."','".$delegue[$i]."',".$typeA[$i].",'".$rj."','".$rj1."','non',".$nbreLignes.",".$pont[$i].",19,".$kilometrage[$i].",'non','".$rjFR[$i]."','".$rjFT[$i]."','".$rjP[$i]."',0,'RAS','".$etat_demande1."',".$tour[$i].",'non',".$tonnage[$i].",'non',0,0,CAST('".$date_demande1[$i]."' AS DATE),0,0,CAST('".$date_demande."' AS DATE),now(),'')");
  
     $query2 = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur =19 limit 1")->row();
	 
	 $getclef= $this->db->query("SELECT MAX(id_demande) AS MAXIMUM FROM demande_frais")->row();
	 
	 
   
     $insertionGZ = $this->db->query("INSERT into gazoil value ('',91,19,'".$camion1[$i]."','".$po."',".$destinationM[$i].", CAST('". $date_demande."' AS DATE) ,".$gazoil_ligne.",".$kilometrage[$i].",".$query2->PU.",'CONSOMMATION GAZOIL','".$bl[$i]."','non',".$getclef->MAXIMUM.",0,0,0)");
	
     $insertionCS = $this->db->query("INSERT INTO sortie value ('',28,CAST('". $date_demande."' AS DATE),".$somme_frais.",'LA DIRECTION','FRAIS DE ROUTE','Frais Route','".$camion1[$i]."',50,'".$po."',1833,777,'DEMANDEE','non','non',0,".$getclef->MAXIMUM.",'TRANSPORT')");
		

	  
	  $i++; 
    }
	
	    if ($query == true) {
            # code...
            echo "Insertion parfaite de la demande";
			
	     //  $this->notificationAjout2($nom_table,addslashes($message));
			
		//	 $insertion = $this->db->query("INSERT INTO sortie value ('',28,CAST('". $date_demande."' AS DATE),".$somme_frais.",'LA DIRECTION','FRAIS DE ROUTE','Frais Route','',50,'".$po."',1833,777,'DEMANDEE','non','non')");
		
	    //   $this->notificationAjout($nom_table,addslashes($message));
            
        }else{
            echo "erreur lors de l'insertion";
        }
	

                         

    }elseif ($status == "update") {
        # code...
		
	
			if ($rj == 'oui') {
				
			  $etat_demande = 'VALIDEE DAF';
			  
			 
			}else{
				  
			   $etat_demande = 'DEMANDEE';
				
			  }
			
			if ($rj1 == 'oui'){
				
              $etat_demande1 = 'VALIDEE DGT';
			  
				 			  
			  
            }else{
				  
			   $etat_demande1 = 'DEMANDEE';
				
			  }


          if ($rj2 == 'oui'){
				
              $etat_demande = 'VALIDEE DAF';
			  
				 			  
			  
            }else{
				  
			  // $etat_demande = 'DEMANDEE';
				
			  }

    $po = $_POST['po'];			  
		
    $i = 1;
		 
	$somme_frais = 0;
	$route_ligne = 0;
	$retour_ligne = 0;
	
	$retour_caisse = 0;
	
        while ($i <= $nbreLignes) {
			
	$route_ligne = 0;
	$retour_ligne = 0;
	$somme_frais = 0;
	
	$route_ligne =  $route[$i] * $tour[$i] ;
	$retour_ligne =  $retour[$i] * $tour[$i] ; 
	
	$somme_frais =  $route_ligne + $retour_ligne + $pont[$i];
	
	
     
    $query = $this->db->query("UPDATE demande_frais set  date_dem = CAST('". $date_demande."' AS DATE),  etat_dem ='".$etat_demande."', destination =".$destinationM[$i].",litrage =".$gazoil[$i].",  frais_route =".$route_ligne.",frais_retour =".$retour_ligne.", code_camion ='".$camion1[$i]."',immatriculation ='".$immatriculation1[$i]."',client =".$client[$i].",bl ='".$bl[$i]."',marchandiseD='".$marchandiseD[$i]."',marchandiseR='".$marchandiseR[$i]."',delegue='".$delegue[$i]."', type=".$typeA[$i].",rj='".$rj."',rj1='".$rj1."',rj2='non',ligne=".$nbreLignes.",pont=".$pont[$i].", kilometrage = ".$kilometrage[$i].", AFR='".$rjFR[$i]."',AFT='".$rjFT[$i]."',AP='".$rjP[$i]."',etat_dem1='".$etat_demande1."',tour=".$tour[$i].",tonnage=".$tonnage[$i].",date_dem2 = CAST('". $date_demande."' AS DATE) where id_demande =".$id_demande[$i]."");
	 
	$update = $this->db->query("UPDATE sortie set  date_sortie = CAST('". $date_demande."' AS DATE),montant = ".$somme_frais.",type_sortie = 'Frais Route', vehicule = '".$camion1[$i]."' where id_dem_frais = ".$id_demande[$i]."");

     

    $queryS = $this->db->query("SELECT * FROM demande_frais WHERE id_demande = ".$id_demande[$i]."")->row();
	

	 $diffRoute = $routeM[$i] - ($route[$i]*$tour[$i]);
	
	  
	 if ($rjFR[$i] =='oui' && $rjFT[$i] =='oui' && $rjP[$i] =='oui' ) {
		 
		 
	$queryD = $this->db->query("SELECT * FROM demande_bon_retour WHERE po_dem  = '". $po."' and vehicule = '".$camion1[$i]."'")->row();	

	 if (count($queryD) >0 ) {
	   
	
	 }else{
		 
		 $route_caisse =  ($route[$i] * $tour[$i]) +  $retourM[$i] +  $pontM[$i];
		 
		 $query = $this->db->query("INSERT into demande_bon_retour value('','".$po."',CAST('". $date_demande."' AS DATE),'".$etat_demande."','LA DIRECTION','Frais Retour',28,".$route_caisse.",'".$camion1[$i]."',1833,50,".$destinationM[$i].",'RETOUR EN CAISSE FRAIS RETOUR','oui','".$rj1."','non',".$nbreLignes.",'".$rjFR[$i]."','non')");
 	  
	 }
		 
	  }else if ($rjFR[$i] =='oui' && $rjFT[$i] =='non' && $rjP[$i] =='non') {
		 
		 
	$queryD = $this->db->query("SELECT * FROM demande_bon_retour WHERE po_dem  = '". $po."' and vehicule = '".$camion1[$i]."'")->row();	

	 if (count($queryD) >0 ) {
	   
	
	 }else{
		 
		 $query = $this->db->query("INSERT into demande_bon_retour value('','".$po."',CAST('". $date_demande."' AS DATE),'".$etat_demande."','LA DIRECTION','Frais Route',28,".$routeM[$i].",'".$camion1[$i]."',1833,50,".$destinationM[$i].",'RETOUR EN CAISSE FRAIS DE ROUTE','oui','".$rj1."','non',".$nbreLignes.",'".$rjFR[$i]."','non')");
 	  
	 }
		 
	  }else if ($rjFT[$i] =='oui' && $rjFR[$i] =='non' && $rjP[$i] =='non') {
		 
		 
	$queryD = $this->db->query("SELECT * FROM demande_bon_retour WHERE po_dem  = '". $po."' and vehicule = '".$camion1[$i]."'")->row();	

	 if (count($queryD) >0 ) {
	   
	
	 }else{
		 
		 $query = $this->db->query("INSERT into demande_bon_retour value('','".$po."',CAST('". $date_demande."' AS DATE),'".$etat_demande."','LA DIRECTION','Frais Retour',28,".$retourM[$i].",'".$camion1[$i]."',1833,50,".$destinationM[$i].",'RETOUR EN CAISSE FRAIS RETOUR','oui','".$rj1."','non',".$nbreLignes.",'".$rjFR[$i]."','non')");
 	  
	 }
		 
	  }else if ($rjP[$i] =='oui' && $rjFT[$i] =='oui' && $rjFR[$i] =='non') {
		 
		 
	$queryD = $this->db->query("SELECT * FROM demande_bon_retour WHERE po_dem  = '". $po."' and vehicule = '".$camion1[$i]."'")->row();	

	 if (count($queryD) >0 ) {
	   
	
	 }else{
		 
		 $query = $this->db->query("INSERT into demande_bon_retour value('','".$po."',CAST('". $date_demande."' AS DATE),'".$etat_demande."','LA DIRECTION','Frais Retour',28,".$pontM[$i].",'".$camion1[$i]."',1833,50,".$destinationM[$i].",'RETOUR EN CAISSE FRAIS RETOUR','oui','".$rj1."','non',".$nbreLignes.",'".$rjFR[$i]."','non')");
 	  
	 }
		 
	  }else if($rjFR[$i] =='oui' && $rjFT[$i] =='oui' && $rjP[$i] =='non' ) {
		  
		 
		 
	$queryD = $this->db->query("SELECT * FROM demande_bon_retour WHERE po_dem  = '". $po."' and vehicule = '".$camion1[$i]."'")->row();	

	 if (count($queryD) >0 ) {
	   
	
	 }else{
		 
		  $route_caisse =  ($route[$i] * $tour[$i]) +  $retourM[$i] ;
		 
		 $query = $this->db->query("INSERT into demande_bon_retour value('','".$po."',CAST('". $date_demande."' AS DATE),'".$etat_demande."','LA DIRECTION','Frais Retour',28,".$route_caisse.",'".$camion1[$i]."',1833,50,".$destinationM[$i].",'RETOUR EN CAISSE FRAIS RETOUR','oui','".$rj1."','non',".$nbreLignes.",'".$rjFR[$i]."','non')");
 	  
	 }
		 
	  }else if ($rjFR[$i] =='oui' && $rjP[$i] =='oui' && $rjT[$i] =='non' ) {
		 
		 
	$queryD = $this->db->query("SELECT * FROM demande_bon_retour WHERE po_dem  = '". $po."' and vehicule = '".$camion1[$i]."'")->row();	

	 if (count($queryD) >0 ) {
	   
	
	 }else{
		 
		  $route_caisse =  ($route[$i] * $tour[$i]) +   $pontM[$i];
		 
		 $query = $this->db->query("INSERT into demande_bon_retour value('','".$po."',CAST('". $date_demande."' AS DATE),'".$etat_demande."','LA DIRECTION','Frais Retour',28,".$route_caisse.",'".$camion1[$i]."',1833,50,".$destinationM[$i].",'RETOUR EN CAISSE FRAIS RETOUR','oui','".$rj1."','non',".$nbreLignes.",'".$rjFR[$i]."','non')");
 	  
	 }
		 
	  }else if ($rjFT[$i] =='oui' && $rjP[$i] =='oui' && $rjFR[$i] =='non' ) {
		 
		 
	$queryD = $this->db->query("SELECT * FROM demande_bon_retour WHERE po_dem  = '". $po."' and vehicule = '".$camion1[$i]."'")->row();	

	 if (count($queryD) >0 ) {
	   
	
	 }else{
		 
		  $route_caisse =  $retourM[$i] +  $pontM[$i];
		 
		 $query = $this->db->query("INSERT into demande_bon_retour value('','".$po."',CAST('". $date_demande."' AS DATE),'".$etat_demande."','LA DIRECTION','Frais Retour',28,".$route_caisse.",'".$camion1[$i]."',1833,50,".$destinationM[$i].",'RETOUR EN CAISSE FRAIS RETOUR','oui','".$rj1."','non',".$nbreLignes.",'".$rjFR[$i]."','non')");
 	  
	 }
		 
	  }
	  
	  
	   if ( $diffRoute > 0) {
		  
		  $queryD = $this->db->query("SELECT * FROM demande_bon_retour WHERE po_dem  = '". $po."' and vehicule = '".$camion1[$i]."'")->row();	

	 if (count($queryD) >0 ) {
	   
	
	 }else{
	   
	 $query = $this->db->query("INSERT into demande_bon_retour value('','".$po."',CAST('". $date_demande."' AS DATE),'".$etat_demande."','LA DIRECTION','Frais Route',28,".$diffRoute.",'".$camion1[$i]."',1833,50,".$destinationM[$i].",'RETOUR EN CAISSE FRAIS DE ROUTE','oui','".$rj1."','non',".$nbreLignes.",'".$rjFR[$i]."','non')");
 		 
	  } 
	  
	 }   
	  
	  $i++; 
    }

        if ($query == true) {
            # code...
            echo "Modification parfaite de la demande";
			
				  

     //       $this->notificationAjout($nom_table,addslashes($message2));

        }else{
            echo "erreur lors de l'insertion";
        }

    }else{
        echo "Erreur fatale contactez l'administrateur";
    }

$this->db->close();
}



public function addDemandeN(){
	
  
	$po = $this->genererChaineAleatoireDemandeN();
	$date_demande = $_POST['date_demande'];
	$operation = $_POST['operation'];
	$etat_demande = $_POST['etat_demande'];
	$etat_demande1 = $_POST['etat_demande1'];
    
  
    $nbreLignes = $_POST["nbreLignes"];
	
	$rj = $_POST['rj'];
	$rj1 = $_POST['rj1'];
	$rj2 = $_POST['rj2'];
	
	   

    $delegue = json_decode($_POST['delegue']);
	$date_demandeN = json_decode($_POST['date_demandeN']);
	
	$fournisseur = json_decode($_POST['fournisseur']);
   
    $camion1 = json_decode($_POST['camion1']);
	$immatriculation1 = json_decode($_POST['immatriculation1']);
    $client = json_decode($_POST['client']);
    $destinationM = json_decode($_POST['destinationM']);
	
	
	$litrage = json_decode($_POST['litrage']);
	
    $typeA = json_decode($_POST['typeA']);
	
	$kilometrage = json_decode($_POST['kilometrage']);
	$tour = json_decode($_POST['tour']);
	
	$rjG = json_decode($_POST['rjG']);
	
	$con = json_decode($_POST['con']);
	
	$id_demande = json_decode($_POST['id_demande']);
    $status = $_POST["status"];

    $nom_table = "demande_navette";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
	
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté la demande Navette N° ".$po." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié la demande Navette N° ".$po." le ".$date_notif." à ".$heure;



    if ($status == "insert") {
		
	 

	$etat_demande = 'DEMANDEE';
	
	$etat_demande1 = 'DEMANDEE';


	$i = 1;
	
	$gazoil_ligne = 0;
	

    while ( $i<= $nbreLignes) {
	
	
	$gazoil_ligne = 0;
	
	
	
	$gazoil_ligne =  $litrage[$i] * $tour[$i] ; 
	
		
	  
     $query = $this->db->query("INSERT into demande_navette value('','".$po."',CAST('". $date_demande."' AS DATE),'".$etat_demande."','".$etat_demande1."',".$destinationM[$i].",".$litrage[$i].",'".$camion1[$i]."','".$immatriculation1[$i]."',".$client[$i].",'".$delegue[$i]."',".$typeA[$i].",'".$rj."','".$rj1."','non',".$nbreLignes.",".$operation.",19,".$kilometrage[$i].",'non',".$tour[$i].",now(),CAST('". $date_demande."' AS DATE),'".$con[$i]."',0,0)");
  
     $query2 = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur =19 limit 1")->row();
	 
	 $getclef= $this->db->query("SELECT MAX(id_demande) AS MAXIMUM FROM demande_navette")->row();
   
     $insertionGZ = $this->db->query("INSERT into gazoil value ('',".$operation.",19,'".$camion1[$i]."','".$po."',".$destinationM[$i].", CAST('". $date_demande."' AS DATE) ,".$gazoil_ligne.",".$kilometrage[$i].",".$query2->PU.",'CONSOMMATION GAZOIL','','non',0,".$getclef->MAXIMUM.",0,0)");
		  
	  $i++; 
    }
	
	    if ($query == true) {
            # code...
            echo "Insertion parfaite de la demande Navette";
			
	//       $this->notificationAjout2($nom_table,addslashes($message));
			
		
	//       $this->notificationAjout($nom_table,addslashes($message));
            
        }else{
            echo "erreur lors de l'insertion";
        }
	

                         

    }elseif ($status == "update") {
        # code...
		
	
			if ($rj == 'oui') {
				
			  $etat_demande = 'VALIDEE DAF';
			  
			 
			}else{
				  
			   $etat_demande = 'DEMANDEE';
				
			  }
			
			if ($rj1 == 'oui'){
				
              $etat_demande1 = 'VALIDEE DGT';
			  
				 			  
			  
            }else{
				  
			   $etat_demande1 = 'DEMANDEE';
				
			  }


          if ($rj2 == 'oui'){
				
              $etat_demande = 'VALIDEE DAF';
			  
				 			  
			  
            }else{
				  
			  // $etat_demande = 'DEMANDEE';
				
			  }

      $po = $_POST['po'];;			  
		
         $i = 1;
		 
		$somme_frais = 0;
	$route_ligne = 0;
	$retour_ligne = 0;
	$litrageR = 0;
	
        while ($i <= $nbreLignes) {
	
	
	$litrageR = $tour[$i] * $litrage[$i];

    $queryS = $this->db->query("SELECT * FROM demande_navette WHERE id_demande = ".$id_demande[$i]."")->row();	
     
    $query = $this->db->query("UPDATE demande_navette set  operation =".$operation.", date_dem = CAST('". $date_demande."' AS DATE),fournisseur =".$fournisseur[$i].",date_dem1 = CAST('". $date_demandeN[$i]."' AS DATE),  etat_dem ='".$etat_demande."', destination =".$destinationM[$i].",litrage =".$litrage[$i].", code_camion ='".$camion1[$i]."',immatriculation ='".$immatriculation1[$i]."',client =".$client[$i].",delegue='".$delegue[$i]."', type=".$typeA[$i].",rj='".$rj."',rj1='".$rj1."',rj2='non',ligne=".$nbreLignes.", kilometrage = ".$kilometrage[$i].", AG='".$rjG[$i]."',CON='".$con[$i]."',etat_dem1='".$etat_demande1."',tour=".$tour[$i]." where id_demande =".$id_demande[$i]."");  
    $query2 = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur =".$fournisseur[$i]." limit 1")->row();
	$query1 = $this->db->query("UPDATE gazoil set id_operation=".$operation.",id_fournisseur=".$fournisseur[$i].",code_camion ='".$camion1[$i]."', litrage = ".$litrageR.", prix_unitaire = ".$query2->PU.", commentaire ='CONSOMMATION GAZOIL',bl='',id_distance = ".$destinationM[$i].",CON='".$con[$i]."',date_gazoil = CAST('". $date_demandeN[$i]."' AS DATE) where  id_dem_nav = ".$id_demande[$i]."");
	  
 //$insertionGZ = $this->db->query("INSERT into gazoil value ('',".$operation.",19,'".$camion1[$i]."','".$po."',".$destinationM[$i].", CAST('". $date_demande."' AS DATE) ,".$litrageR.",".$kilometrage[$i].",".$query2->PU.",'CONSOMMATION GAZOIL','','non')");


  
 
 
	  $i++; 
    }

        if ($query == true) {
            # code...
            echo "Modification parfaite de la demande Navette";
			
				  

       //     $this->notificationAjout($nom_table,addslashes($message2));

        }else{
            echo "erreur lors de l'insertion";
        }

    }else{
        echo "Erreur fatale contactez l'administrateur";
    }

    $this->db->close();
}


public function addDemandeE(){
	
  
	$po = $this->genererChaineAleatoireDemandeN();
	$date_demande = $_POST['date_demande'];
	$operation = $_POST['operation'];
	$etat_demande = $_POST['etat_demande'];
	$etat_demande1 = $_POST['etat_demande1'];
    
  
    $nbreLignes = $_POST["nbreLignes"];
	
	$rj = $_POST['rj'];
	$rj1 = $_POST['rj1'];
	$rj2 = $_POST['rj2'];
	
	   

   
	$date_demandeN = json_decode($_POST['date_demandeN']);
	
	$fournisseur = json_decode($_POST['fournisseur']);
   
    $camion1 = json_decode($_POST['camion1']);
	$immatriculation1 = json_decode($_POST['immatriculation1']);
    
	
	$litrage = json_decode($_POST['litrage']);
	
    $typeA = json_decode($_POST['typeA']);
	
	$kilometrage = json_decode($_POST['kilometrage']);
	
	$rjG = json_decode($_POST['rjG']);
	
	$con = json_decode($_POST['con']);
	
	$id_demande = json_decode($_POST['id_demande']);
    $status = $_POST["status"];

    $nom_table = "demande_navette";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
	
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté la demande Navette N° ".$po." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié la demande Navette N° ".$po." le ".$date_notif." à ".$heure;



    if ($status == "insert") {
		
	 

	$etat_demande = 'DEMANDEE';
	
	$etat_demande1 = 'DEMANDEE';


	$i = 1;
	
	$gazoil_ligne = 0;
	

    while ( $i<= $nbreLignes) {
	
	
	$gazoil_ligne = 0;
	
		
	  
     $query = $this->db->query("INSERT into demande_engin value('','".$po."',CAST('". $date_demande."' AS DATE),'".$etat_demande."','".$etat_demande1."',840,".$litrage[$i].",'".$camion1[$i]."','".$immatriculation1[$i]."',3710,'',".$typeA[$i].",'".$rj."','".$rj1."','non',".$nbreLignes.",".$operation.",19,".$kilometrage[$i].",'non',0,now(),CAST('". $date_demande."' AS DATE),'".$con[$i]."',0,0)");
  
     $query2 = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur =19 limit 1")->row();
	 
	 $getclef= $this->db->query("SELECT MAX(id_demande) AS MAXIMUM FROM demande_engin")->row();
   
     $insertionGZ = $this->db->query("INSERT into gazoil value ('',".$operation.",19,'".$camion1[$i]."','".$po."',840, CAST('". $date_demande."' AS DATE) ,".$litrage[$i].",".$kilometrage[$i].",".$query2->PU.",'CONSOMMATION GAZOIL','','non',0,0,0,".$getclef->MAXIMUM.")");
		  
	  $i++; 
    }
	
	    if ($query == true) {
            # code...
            echo "Insertion parfaite de la demande Navette";
			
//	       $this->notificationAjout2($nom_table,addslashes($message));
			
		
//	       $this->notificationAjout($nom_table,addslashes($message));
            
        }else{
            echo "erreur lors de l'insertion";
        }
	

                         

    }elseif ($status == "update") {
        # code...
		
	
			if ($rj == 'oui') {
				
			  $etat_demande = 'VALIDEE DAF';
			  
			 
			}else{
				  
			   $etat_demande = 'DEMANDEE';
				
			  }
			
			if ($rj1 == 'oui'){
				
              $etat_demande1 = 'VALIDEE DGT';
			  
				 			  
			  
            }else{
				  
			   $etat_demande1 = 'DEMANDEE';
				
			  }


          if ($rj2 == 'oui'){
				
              $etat_demande = 'VALIDEE DAF';
			  
				 			  
			  
            }else{
				  
			  // $etat_demande = 'DEMANDEE';
				
			  }

      $po = $_POST['po'];;			  
		
         $i = 1;
		 
	
	
        while ($i <= $nbreLignes) {
	
	

    $queryS = $this->db->query("SELECT * FROM demande_engin WHERE id_demande = ".$id_demande[$i]."")->row();	
     
    $query = $this->db->query("UPDATE demande_engin set  operation =".$operation.", date_dem = CAST('". $date_demande."' AS DATE),fournisseur =".$fournisseur[$i].",date_dem1 = CAST('". $date_demandeN[$i]."' AS DATE),  etat_dem ='".$etat_demande."', litrage =".$litrage[$i].", code_camion ='".$camion1[$i]."',immatriculation ='".$immatriculation1[$i]."', type=".$typeA[$i].",rj='".$rj."',rj1='".$rj1."',rj2='non',ligne=".$nbreLignes.", kilometrage = ".$kilometrage[$i].", AG='".$rjG[$i]."',CON='".$con[$i]."',etat_dem1='".$etat_demande1."' where id_demande =".$id_demande[$i]."");  
    $query2 = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur =".$fournisseur[$i]." limit 1")->row();
	$query1 = $this->db->query("UPDATE gazoil set id_operation=".$operation.",id_fournisseur=".$fournisseur[$i].",code_camion ='".$camion1[$i]."', litrage = ".$litrage[$i].", prix_unitaire = ".$query2->PU.", commentaire ='CONSOMMATION GAZOIL',bl='',id_distance = ".$destinationM[$i].",CON='".$con[$i]."',date_gazoil = CAST('". $date_demandeN[$i]."' AS DATE) where  id_dem_engin = ".$id_demande[$i]."");
	  
  
	  $i++; 
    }

        if ($query == true) {
            # code...
            echo "Modification parfaite de la demande Navette";
			
				  

 //           $this->notificationAjout($nom_table,addslashes($message2));

        }else{
            echo "erreur lors de l'insertion";
        }

    }else{
        echo "Erreur fatale contactez l'administrateur";
    }

    $this->db->close();
}


public function addDemandeNA(){
	
  
	$po = $this->genererChaineAleatoireDemandeNA();
	$date_demande = $_POST['date_demande'];
	$operation = $_POST['operation'];
	$etat_demande = $_POST['etat_demande'];
	$etat_demande1 = $_POST['etat_demande1'];
    
  
    $nbreLignes = $_POST["nbreLignes"];
	
	$rj = $_POST['rj'];
	$rj1 = $_POST['rj1'];
	$rj2 = $_POST['rj2'];
	
	   

    $delegue = json_decode($_POST['delegue']);
	$date_demandeN = json_decode($_POST['date_demandeN']);
	
	$fournisseur = json_decode($_POST['fournisseur']);
   
    $camion1 = json_decode($_POST['camion1']);
	$immatriculation1 = json_decode($_POST['immatriculation1']);
    $client = json_decode($_POST['client']);
    $destinationM = json_decode($_POST['destinationM']);
	
	
	$litrage = json_decode($_POST['litrage']);
	
    $typeA = json_decode($_POST['typeA']);
	
	$kilometrage = json_decode($_POST['kilometrage']);
	$tour = json_decode($_POST['tour']);
	
	$rjG = json_decode($_POST['rjG']);
	
	$con = json_decode($_POST['con']);
	
	$id_demande = json_decode($_POST['id_demande']);
    $status = $_POST["status"];

    $nom_table = "demande_navette_autre";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
	
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté la demande Navette N° ".$po." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié la demande Navette N° ".$po." le ".$date_notif." à ".$heure;



    if ($status == "insert") {
		
	 

	$etat_demande = 'DEMANDEE';
	
	$etat_demande1 = 'DEMANDEE';


	$i = 1;
	
	$gazoil_ligne = 0;
	

    while ( $i<= $nbreLignes) {
	
	
	$gazoil_ligne = 0;
	
	
	
	$gazoil_ligne =  $litrage[$i] * $tour[$i] ; 
	
		
	  
     $query = $this->db->query("INSERT into demande_navette_autre value('','".$po."',CAST('". $date_demande."' AS DATE),'".$etat_demande."','".$etat_demande1."',".$destinationM[$i].",".$litrage[$i].",'".$camion1[$i]."','".$immatriculation1[$i]."',".$client[$i].",'".$delegue[$i]."',".$typeA[$i].",'".$rj."','".$rj1."','non',".$nbreLignes.",".$operation.",19,".$kilometrage[$i].",'non',".$tour[$i].",now(),CAST('". $date_demande."' AS DATE),'".$con[$i]."',0,0)");
  
     $query2 = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur =19 limit 1")->row();
	 
	 $getclef= $this->db->query("SELECT MAX(id_demande) AS MAXIMUM FROM demande_navette_autre")->row();
   
     $insertionGZ = $this->db->query("INSERT into gazoil value ('',".$operation.",19,'".$camion1[$i]."','".$po."',".$destinationM[$i].", CAST('". $date_demande."' AS DATE) ,".$gazoil_ligne.",".$kilometrage[$i].",".$query2->PU.",'CONSOMMATION GAZOIL','','non',0,0,".$getclef->MAXIMUM.",0)");
		  
	  $i++; 
    }
	
	    if ($query == true) {
            # code...
            echo "Insertion parfaite de la demande Navette";
			
	//       $this->notificationAjout2($nom_table,addslashes($message));
			
		
	//       $this->notificationAjout($nom_table,addslashes($message));
            
        }else{
            echo "erreur lors de l'insertion";
        }
	

                         

    }elseif ($status == "update") {
        # code...
		
	
			if ($rj == 'oui') {
				
			  $etat_demande = 'VALIDEE DAF';
			  
			 
			}else{
				  
			   $etat_demande = 'DEMANDEE';
				
			  }
			
			if ($rj1 == 'oui'){
				
              $etat_demande1 = 'VALIDEE DGT';
			  
				 			  
			  
            }else{
				  
			   $etat_demande1 = 'DEMANDEE';
				
			  }


          if ($rj2 == 'oui'){
				
              $etat_demande = 'VALIDEE DAF';
			  
				 			  
			  
            }else{
				  
			  // $etat_demande = 'DEMANDEE';
				
			  }

      $po = $_POST['po'];;			  
		
         $i = 1;
		 
		$somme_frais = 0;
	$route_ligne = 0;
	$retour_ligne = 0;
	$litrageR = 0;
	
        while ($i <= $nbreLignes) {
	
	
	$litrageR = $tour[$i] * $litrage[$i];

    $queryS = $this->db->query("SELECT * FROM demande_navette_autre WHERE id_demande = ".$id_demande[$i]."")->row();	
     
    $query = $this->db->query("UPDATE demande_navette_autre set  operation =".$operation.", date_dem = CAST('". $date_demande."' AS DATE),fournisseur =".$fournisseur[$i].",date_dem1 = CAST('". $date_demandeN[$i]."' AS DATE),  etat_dem ='".$etat_demande."', destination =".$destinationM[$i].",litrage =".$litrage[$i].", code_camion ='".$camion1[$i]."',immatriculation ='".$immatriculation1[$i]."',client =".$client[$i].",delegue='".$delegue[$i]."', type=".$typeA[$i].",rj='".$rj."',rj1='".$rj1."',rj2='non',ligne=".$nbreLignes.", kilometrage = ".$kilometrage[$i].", AG='".$rjG[$i]."',CON='".$con[$i]."',etat_dem1='".$etat_demande1."',tour=".$tour[$i]." where id_demande =".$id_demande[$i]."");  
    $query2 = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur =".$fournisseur[$i]." limit 1")->row();
	$query1 = $this->db->query("UPDATE gazoil set id_operation=".$operation.",id_fournisseur=".$fournisseur[$i].",code_camion ='".$camion1[$i]."', litrage = ".$litrageR.", prix_unitaire = ".$query2->PU.", commentaire ='CONSOMMATION GAZOIL',bl='',id_distance = ".$destinationM[$i].",CON='".$con[$i]."',date_gazoil = CAST('". $date_demandeN[$i]."' AS DATE) where  id_dem_nav_autre = ".$id_demande[$i]."");
	  
 //$insertionGZ = $this->db->query("INSERT into gazoil value ('',".$operation.",19,'".$camion1[$i]."','".$po."',".$destinationM[$i].", CAST('". $date_demande."' AS DATE) ,".$litrageR.",".$kilometrage[$i].",".$query2->PU.",'CONSOMMATION GAZOIL','','non')");


  
   
	 
	$query3 = $this->db->query("SELECT * from gazoil where numero ='".$po."' and code_camion ='".$camion1[$i]."'")->row();
	   
	   
	   if    (count($query3) >0) {
	
	//  $query1 = $this->db->query("UPDATE gazoil set id_operation=91,id_fournisseur=".$fournisseur[$i].",code_camion ='".$camion1[$i]."', litrage = ".$litrageR[$i].",prix_unitaire = ".$query2->PU.", commentaire ='CONSOMMATION GAZOIL',bl='".$bl[$i]."',id_distance = ".$destinationM[$i].",CON='".$con[$i]."', date_gazoil = CAST('". $date_demandeN[$i]."' AS DATE) where id_dem_nav_autre = ".$id_demande[$i]." ");
	  
     }else {
	   
   $insertionGZ = $this->db->query("INSERT into gazoil value ('',".$operation.",".$fournisseur[$i].",'".$camion1[$i]."','".$po."',".$destinationM[$i].", CAST('". $date_demandeN[$i]."' AS DATE) ,".$litrage[$i].",0,".$query2->PU.",'CONSOMMATION GAZOIL','','non',0,0,0)");
	
	}

	 
 
	  $i++; 
    }

        if ($query == true) {
            # code...
            echo "Modification parfaite de la demande Navette";
			
				  

//            $this->notificationAjout($nom_table,addslashes($message2));

        }else{
            echo "erreur lors de l'insertion";
        }

    }else{
        echo "Erreur fatale contactez l'administrateur";
    }

    $this->db->close();
}


public function addDemandeSTOLD(){
	
  
    $nbreLignes = $_POST["nbreLignes"];
	
	
    $delegue = json_decode($_POST['delegue']);
	
    $camion1 = json_decode($_POST['camion1']);
	$immatriculation1 = json_decode($_POST['immatriculation1']);
   
    $typeA = json_decode($_POST['typeA']);
	
	$kilometrage = json_decode($_POST['kilometrage']);
	$tour = json_decode($_POST['tour']);
	$commentaire = json_decode($_POST['commentaire']);
	
	
	$id_demande = json_decode($_POST['id_demande']);
    $status = $_POST["status"];

    $nom_table = "demande_frais";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
	
 //   $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté la demande Navette N° ".$po." le ".$date_notif." à ".$heure;

//    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié la demande Navette N° ".$po." le ".$date_notif." à ".$heure;



    if  ($status == "update") {
  	
         $i = 1;
	
	
        while ($i <= $nbreLignes) {
			
	

    $queryS = $this->db->query("SELECT * FROM demande_frais WHERE code_camion = '".$camion1[$i]."' ORDER BY id_demande DESC LIMIT 1")->row();	
	
	if    (count($queryS) >0) {
	
	$id_dem = $queryS->id_demande;
	
	 $query = $this->db->query("UPDATE demande_frais set  stock=".$tour[$i].", commentaire = '".$commentaire[$i]."'  where id_demande =".$id_dem."");  
    
     }
	 
	   $queryS = $this->db->query("SELECT * FROM demande_navette WHERE code_camion = '".$camion1[$i]."' ORDER BY id_demande DESC LIMIT 1")->row();	
	
	if    (count($queryS) >0) {
	
	$id_dem = $queryS->id_demande;
	
	 $query = $this->db->query("UPDATE demande_navette set  stock=".$tour[$i]." where id_demande =".$id_dem."");  
    
     }
	 
	   $queryS = $this->db->query("SELECT * FROM demande_navette_autre WHERE code_camion = '".$camion1[$i]."' ORDER BY id_demande DESC LIMIT 1")->row();	
	
	if    (count($queryS) >0) {
	
	$id_dem = $queryS->id_demande;
	
	 $query = $this->db->query("UPDATE demande_navette_autre set  stock=".$tour[$i]." where id_demande =".$id_dem."");  
    
     }
	 
	    $queryS = $this->db->query("SELECT * FROM demande_engin WHERE code_camion = '".$camion1[$i]."' ORDER BY id_demande DESC LIMIT 1")->row();	
	
	if    (count($queryS) >0) {
	
	$id_dem = $queryS->id_demande;
	
	 $query = $this->db->query("UPDATE demande_engin set  stock=".$tour[$i]." where id_demande =".$id_dem."");  
    
     }
	 
    
	  $i++; 
    }

        if ($query == true) {
            # code...
            echo "Modification parfaite du stock vehicule";
			
				  

    //        $this->notificationAjout($nom_table,addslashes($message2));

        }else{
            echo "erreur lors de l'insertion";
        }

    }else{
        echo "Erreur fatale contactez l'administrateur";
    }

    $this->db->close();
}


public function addDemandeST(){
	
  
    $date_stock = date("d-m-Y");
  
  
  
    $nbreLignes = $_POST["nbreLignes"];
	
	$date_demande =  json_decode($_POST['date_demande']);
	
    $delegue = json_decode($_POST['delegue']);
	
    $camion1 = json_decode($_POST['camion1']);
	$immatriculation1 = json_decode($_POST['immatriculation1']);
   
    $typeA = json_decode($_POST['typeA']);
	
	$kilometrage = json_decode($_POST['kilometrage']);
	$tour = json_decode($_POST['tour']);
	$commentaire = json_decode($_POST['commentaire']);
	
	
	$id_demande = json_decode($_POST['id_demande']);
    $status = $_POST["status"];

    $nom_table = "demande_frais";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
	
 //   $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté la demande Navette N° ".$po." le ".$date_notif." à ".$heure;

//    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié la demande Navette N° ".$po." le ".$date_notif." à ".$heure;



     if ($status == "insert") {
		
	
	$i = 1;
	
	$gazoil_ligne = 0;
	

    while ( $i<= $nbreLignes) {
	
	

	
	    $query = $this->db->query("INSERT into stock_vehicule value('',CAST('". $date_demande[$i]."' AS DATE),'".$camion1[$i]."','".$immatriculation1[$i]."',".$tour[$i].",".$tour[$i].",".$tour[$i].",".$nbreLignes.",'".$commentaire[$i]."')");
  		  
	  $i++; 
    }
	
	    if ($query == true) {
            # code...
            echo "Insertion parfaite du stock camion";

            
        }else{
            echo "erreur lors de l'insertion";
        }
	

                         

    }elseif   ($status == "update") {
  	

			
	
    $queryS = $this->db->query("UPDATE stock_vehicule set  date_stock =CAST('". $date_demande."' AS DATE), litrageA=0,litrageC=".$tour[$i].",litrageP=".$tour[$i].", vehicule ='".$camion1[$i]."', commentaire ='".$commentaire[$i]."'  where ref =".$id_demande."");  

	

        if ($queryS == true) {
            # code...
            echo "Modification parfaite du stock vehicule";
			
				  

    //        $this->notificationAjout($nom_table,addslashes($message2));

        }else{
            echo "erreur lors de l'insertion";
        }

    }else{
        echo "Erreur fatale contactez l'administrateur";
    }

    $this->db->close();
}




public function addDemandeG(){
	
    //Entete de la commande
	$po = $_POST['po'];
	
	$date_demande = $_POST['date_demande'];
	$etat_demande = $_POST['etat_demande'];
    $fournisseur = $_POST['fournisseur'];
    // detail de la commanden
    $nbreLignes = $_POST["nbreLignes"];
	
	$rj = $_POST['rj'];
	
	

    $delegue = json_decode($_POST['delegue']);
    $bl = json_decode($_POST['bl']);
	
    $camion1 = json_decode($_POST['camion1']);
	$immatriculation1 = json_decode($_POST['immatriculation1']);
	
    $complement = json_decode($_POST['complement']);
    $destinationM = json_decode($_POST['destinationM']);
	$litrageTH = json_decode($_POST['litrageTH']);
	$litrageR = json_decode($_POST['litrageR']);
	$stock = json_decode($_POST['stock']);
	$difference = json_decode($_POST['difference']);
	
    $fournisseur = json_decode($_POST['fournisseur']);
	$type1 = json_decode($_POST['type1']);
	$detail = json_decode($_POST['detail']);
	
	$rjG = json_decode($_POST['rjG']);
	
	$con = json_decode($_POST['con']);
	
	$date_demande2 = json_decode($_POST['date_demande2']);
	
	$id_demande = json_decode($_POST['id_demande']);
	
    $status = $_POST["status"];

    $nom_table = "demande_frais";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
	
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté la demande N° ".$po." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié la demande N° ".$po." le ".$date_notif." à ".$heure;


	if ($status == "update") {
        # code...
		
		
			  
         $i = 1;
		 
		 $somme_frais = 0;
		 $somme_gazoil = 0;
	
        while ( $i<= $nbreLignes) {
     
      $query = $this->db->query("UPDATE demande_frais set  complement =".$complement[$i].",detail ='".$detail[$i]."',rj2 ='".$rj."',fournisseur =".$fournisseur[$i].", AG='".$rjG[$i]."', CON='".$con[$i]."', date_dem2 = CAST('". $date_demande2[$i]."' AS DATE),litrage1 = ".$litrageR[$i]."  where id_demande =".$id_demande[$i]."");
    
	
	
	 $getStockCamion1 = $this->db->query("SELECT * from stock_vehicule where vehicule = '".$camion1[$i]."' and litrageA = 0 ORDER BY ref DESC LIMIT 1")->row();  
	 
	 if    (count($getStockCamion1) >0) {
	
    			
	$query1 = $this->db->query("UPDATE stock_vehicule set  litrageA = 1 and date_stock = CAST('". $date_demande."' AS DATE) where vehicule  ='".$camion1[$i]."' ORDER BY ref DESC LIMIT 1 ");
		
	 }			
							

	  $query2 = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur =".$fournisseur[$i]." limit 1")->row();
	  
	  
	  $query1 = $this->db->query("UPDATE gazoil set id_operation=91,id_fournisseur=".$fournisseur[$i].",code_camion ='".$camion1[$i]."', litrage = ".$litrageR[$i].",prix_unitaire = ".$query2->PU.", commentaire ='CONSOMMATION GAZOIL',bl='".$bl[$i]."',id_distance = ".$destinationM[$i].",CON='".$con[$i]."', date_gazoil = CAST('". $date_demande2[$i]."' AS DATE) where id_dem_frais = ".$id_demande[$i]." ");
	
	  	
	
	  $i++; 
    }

        if ($query == true) {
            # code...
            echo "Modification parfaite de la demande";
			
	//		 $update = $this->db->query("UPDATE sortie set  commentaire ='FRAIS DE ROUTE',ordonnateur='LA DIRECTION',date_sortie = CAST('". $date_demande."' AS DATE),montant = ".$somme_frais.",id_type = 28,type_sortie = 'Frais Route',vehicule = '', fournisseur = 50,numero = '".$po."',operation = 1833,destination = 777 where numero = '".$po."'");
				  

            $this->notificationAjout($nom_table,addslashes($message2));

        }else{
            echo "erreur lors de l'insertion";
        }

    }else{
        echo "Erreur fatale contactez l'administrateur";
    }

$this->db->close();
}


public function getListeDemmandePourModifC(){
    $po = $_POST["po"];
    $getAllCommande = $this->db->query("SELECT * from demande_frais where po_dem = '".$po."'")->result_array();
    $i=1;
    foreach ($getAllCommande as $com) {
        # code...
  
   
   echo '<div class="row">
   
    <div class="col-md-1">
  <div class="form-group">
  <label>Compteur</label>
                            <input type="text"class="form-control cpt'.$i.'" placeholder="" value = "'.$i.'" >

                 </div>
    </div> 
  
    <div class="col-md-1" >
    <div class="form-group">
    <label>Délégué</label>
    <select class="delegue'.$i.' form-control" onchange="getCamionDelegue1($(\'.delegue'.$i.'\').val(),\'camion1'.$i.'\',\'immatriculation1'.$i.'\',\'route1'.$i.'\',\'retour1'.$i.'\');">
    ';
	echo "<option value='".$com['delegue']."'>".$com['delegue']."</option>";
    $this->crud_model_depense->leSelectDelegueCamion();
                                
    echo '</select>
    </div>
    </div>
	
				  
	
    <div class="col-md-1">				  
		  <div class="form-group">
      <label>Véhicule</label> 
       <select class="camion1'.$i.' form-control" onchange="getMatriculeVehicule1_1($(\'.camion1'.$i.'\').val(),\'immatriculation1'.$i.'\');getTypeVehicule3_1($(\'.camion1'.$i.'\').val(),\'typeA'.$i.'\');getDistanceParCodeCamion1($(\'.camion1'.$i.'\').val(),\'destination1'.$i.'\',\'destination2'.$i.'\');">
       ';
	   
	   echo "<option value=".$com["code_camion"].">".$com["code_camion"]."</option>";
                     $this->crud_model_depense->leSelectCodeCamion();
       echo ' </select></div>
          </div>
		  
		    
	    <div class="col-md-1">	
		    
       <label>Matricule</label>
	   
	   <input type="text" class="form-control immatriculation1'.$i.'" placeholder="" value= "'.$com["immatriculation"].'" disabled = "true" >
      
          </div>
		  
							  
						  
	 <div class="col-md-3">				  
		  <div class="form-group">
      <label>Client</label> 
       <select class="client'.$i.' form-control" onchange="">';
      
	  $getClient = $this->db->query("SELECT * from clientfrais where id_client= ".$com["client"]."")->row();
				
				if (count($getClient) > 0 ) {
					 echo "<option value='".$getClient->id_client."'>".$getClient->nom."</option>";
				 } 	 
	  
	$this->crud_model_depense->leSelectClientFrais();
       echo ' </select></div>
          </div>
		  
		
						  	  
		  
		     	<div class="col-md-1">
                            <label>M. Depart</label>
                            <select class="marchandiseD'.$i.' form-control" placeholder="" value = "" onchange="" >
							';
							
							echo '<option value='.addslashes($com["marchandiseD"]).'>'.addslashes($com["marchandiseD"]).'</option>
							<option value=""></option>
							<option value="BOIS">BOIS</option>
							<option value="CIMENT_42.5">CIMENT_42.5</option>
							<option value="CIMENT_32.5">CIMENT_32.5</option>
							<option value="CIMENT_VRAC">CIMENT_VRAC</option>
							<option value="CONTENAIRE">CONTENAIRE</option>
							<option value="GRAVIER">GRAVIER</option>
							<option value="POUZZOLANE">POUZZOLANE</option>
							<option value="SABLE">SABLE</option>';
													
							echo ' </select>
						</div>	

		   <div class="col-md-2">
               <div class="form-group">
                 <label>Destination</label>
                  <select class="destination1'.$i.' form-control" onchange="getLitrageCamion1($(\'.destination1'.$i.'\').val(),$(\'.type1'.$i.'\').val(),\'gazoil'.$i.'\'); getFraisRoute1($(\'.destination1'.$i.'\').val(),$(\'.type1'.$i.'\').val(),\'route'.$i.'\');getFraisRetour1($(\'.destination1'.$i.'\').val(),$(\'.type1'.$i.'\').val(),\'retour'.$i.'\');">
                			 
				 
				   ';
				 
				 
				 $getArticle = $this->db->query("SELECT * from distance_littrage where id_distance = ".$com["destination"]."")->row();
				
				if (count($getArticle) > 0 ) {
					 echo "<option value='".$getArticle->id_distance."'>".$getArticle->distance."</option>";
				 } 	 
				
				// echo "<option value='".$com['distance']."'>".$getArticle->distance."</option>";
				
				$this->crud_model_depense->getDistanceParCodeCamion1();
				 
				      
            echo ' </select></div>
             </div>
			 
			 
			 			 			  					  
						   
						<div class="col-md-1">
                            <label>M. Retour</label>
                            <select class="marchandiseR'.$i.' form-control" placeholder="" value = "" onchange="" >
							';
							echo '<option value='.addslashes($com["marchandiseR"]).'>'.addslashes($com["marchandiseR"]).'</option>
							<option value=""></option>
							<option value="BOIS">BOIS</option>
							<option value="CIMENT_42.5">CIMENT_42.5</option>
							<option value="CIMENT_32.5">CIMENT_32.5</option>
							<option value="CIMENT_VRAC">CIMENT_VRAC</option>
							<option value="CONTENAIRE">CONTENAIRE</option>
							<option value="GRAVIER">GRAVIER</option>
							<option value="POUZZOLANE">POUZZOLANE</option>
							<option value="SABLE">SABLE</option>';
													
							echo ' </select>
						</div>	
					  
						  <div class="col-md-1">
                            <label>Nbre Tour(s)</label>
                            <input type="text" class="form-control tour'.$i.'" placeholder="" onkeypress="chiffres(event);" value = "'.$com["tour"].'" onkeypress="chiffres(event);" onkeyup="totalCumLigne();totalCumLigne();totalLigne($(\'.route'.$i.'\').val(),$(\'.retour'.$i.'\').val(),$(\'.pont'.$i.'\').val(),$(\'.tour'.$i.'\').val(),\'totalLigne'.$i.'\');" >

                          </div> ';
					
					
		
		echo '
						 <input type="hidden" class="form-control type1'.$i.'"  placeholder=" en FCFA" value="'.$com["type"].'" disabled="true" onkeypress="chiffres(event);">                          
						 <input type="hidden" class="form-control id_demande'.$i.'"  placeholder=" en FCFA" value="'.$com["id_demande"].'" disabled="true" onkeypress="chiffres(event);">
                         <input type="hidden" class="form-control compteur'.$i.'"  placeholder=" en FCFA"  disabled="true" onkeypress="chiffres(event);">
					
				</div> 
            
       <hr>';
       $i++;
      }
	  
      $i = $i-1;
	  
      echo '<input type="hidden" class="form-control compteur"  placeholder=" en FCFA" value="'.$i.'" disabled="true" onkeypress="chiffres(event);">';

      echo '
  
  
 <hr>';
	  
	  
	  $this->db->close();
}


public function getListeDemmandePourModif(){
    $po = $_POST["po"];
    $getAllCommande = $this->db->query("SELECT * from demande_frais where po_dem = '".$po."'")->result_array();
    $i=1;
	$type_vehicule="";
    foreach ($getAllCommande as $com) {
        # code...
  
    $getTypeCamion = $this->db->query("SELECT * from type_vehicule where id_type = (SELECT id_type_camion  from camion_benne where code = '".$com["code_camion"]."')")->row();  
 
   if (count($getTypeCamion) >0 ) {
  $type_vehicule = $getTypeCamion-> nom_type;
    }	


$getTypeCamion1 = $this->db->query("SELECT * from type_vehicule where id_type = (SELECT id_type_camion  from tracteur where code = '".$com["code_camion"]."')")->row();  
 
   if (count($getTypeCamion1) >0 ) {
  $type_vehicule = $getTypeCamion1-> nom_type;
    }	
   
   echo '<div class="row">
   
    <div class="col-md-1">
  <div class="form-group">
  <label>Compteur</label>
                            <input type="text"class="form-control cpt'.$i.'" placeholder="" value = "'.$i.'" >

                 </div>
    </div> 
  
    <div class="col-md-1" >
    <div class="form-group">
    <label>Délégué</label>
    <select class="delegue'.$i.' form-control" onchange="getCamionDelegue1($(\'.delegue'.$i.'\').val(),\'camion1'.$i.'\',\'immatriculation1'.$i.'\',\'route1'.$i.'\',\'retour1'.$i.'\');">
    ';
	echo "<option value='".$com['delegue']."'>".$com['delegue']."</option>";
    $this->crud_model_depense->leSelectDelegueCamion();
                                
    echo '</select>
    </div>
    </div>
	
				  <div class="col-md-1">
                            <label>N°BL</label>
                            <input type="text" class="form-control bl'.$i.'" placeholder="" value="'.$com["bl"].'" >

                  </div>
				  
				    <div class="col-md-2">
                            <label>Date BL </label>
                          <div class="input-group " id="" data-target-input="nearest" >
                              
                                <input type="date" class="form-control datetimepicker-input date_demande1'.$i.'" data-target="#reservationdate" placeholder="date effet" value="'.$com["date_dem1"].'" onchange="getExpirationPneu();" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                          </div>
                        </div>
				
	
    <div class="col-md-1">				  
		  <div class="form-group">
      <label>Véhicule</label> 
       <select class="camion1'.$i.' form-control" onchange="getMatriculeVehicule1_1($(\'.camion1'.$i.'\').val(),\'immatriculation1'.$i.'\');getTypeVehicule3_1($(\'.camion1'.$i.'\').val(),\'typeA'.$i.'\');getDistanceParCodeCamion1($(\'.camion1'.$i.'\').val(),\'destinationM'.$i.'\');">
       ';
	   
	   echo "<option value=".$com["code_camion"].">".$com["code_camion"]."</option>";
                     $this->crud_model_depense->leSelectCodeCamion();
       echo ' </select></div>
          </div>
		  
		    
	    <div class="col-md-1">	
		    
       <label>Matricule</label>
	   
	   <input type="text" class="form-control immatriculation1'.$i.'" placeholder="" value= "'.$com["immatriculation"].'" disabled = "true" >
      
          </div>
		  
		  
		  <div class="col-md-1">	
		    
       <label>Type Vehicule</label>
	   
	   <input type="text" class="form-control typeC'.$i.'" placeholder="" value= "'. $type_vehicule.'" disabled = "true" >
      
          </div>
		  
		  <div class="col-md-1">
                            <label>Kilometrage</label>
                            <input type="text" class="form-control kilometrage'.$i.'" placeholder="Kilométrage" value = "'.$com["kilometrage"].'" onkeypress="chiffres(event);" value = "0">

                          </div> 
						  
						  
	 <div class="col-md-3">				  
		  <div class="form-group">
      <label>Client</label> 
       <select class="client'.$i.' form-control" onchange="">';
      
	  $getClient = $this->db->query("SELECT * from clientfrais where id_client= ".$com["client"]."")->row();
				
				if (count($getClient) > 0 ) {
					 echo "<option value='".$getClient->id_client."'>".$getClient->nom."</option>";
				 } 	 
	  
	$this->crud_model_depense->leSelectClientFrais();
       echo ' </select></div>
          </div>
		  
		
						  	  
		  
		     	<div class="col-md-1">
                            <label>M. Depart</label>
                            <select class="marchandiseD'.$i.' form-control" placeholder="" value = "" onchange="" >
							';
							
							echo '<option value='.addslashes($com["marchandiseD"]).'>'.addslashes($com["marchandiseD"]).'</option>
							<option value=""></option>
								<option value=""></option>
							<option value="BOIS">BOIS</option>
							<option value="CIMENT_42.5">CIMENT_42.5</option>
							<option value="CIMENT_32.5">CIMENT_32.5</option>
							<option value="CIMENT_VRAC">CIMENT_VRAC</option>
							<option value="CONTENAIRE">CONTENAIRE</option>
							<option value="ENGRAIS">ENGRAIS</option>
							<option value="GRAVIER">GRAVIER</option>
							<option value="MAIS">MAIS</option>
							<option value="PALETTE">PALETTE</option>
							<option value="PNEU">PNEU</option>
							<option value="POUZZOLANE">POUZZOLANE</option>
							<option value="SABLE">SABLE</option>
							<option value="SOJA">SOJA</option>';
													
							echo ' </select>
						</div>	

		   <div class="col-md-2">
               <div class="form-group">
                 <label>Destination</label>
                  <select class="destinationM'.$i.' form-control" onchange="getLitrageCamion1($(\'.destinationM'.$i.'\').val(),$(\'.typeA'.$i.'\').val(),\'gazoil'.$i.'\'); getFraisRoute1($(\'.destinationM'.$i.'\').val(),$(\'.typeA'.$i.'\').val(),\'route'.$i.'\');getFraisRetour1($(\'.destinationM'.$i.'\').val(),$(\'.typeA'.$i.'\').val(),\'retour'.$i.'\');">
                			 
				 
				   ';
				 
				 
				 $getArticle = $this->db->query("SELECT * from distance_littrage where id_distance = ".$com["destination"]."")->row();
				
				if (count($getArticle) > 0 ) {
					 echo "<option value='".$getArticle->id_distance."'>".$getArticle->distance."</option>";
				 } 	 
				
				// echo "<option value='".$com['distance']."'>".$getArticle->distance."</option>";
				
				$this->crud_model_depense->getDistanceParCodeCamion1();
				 
				      
            echo ' </select></div>
             </div>';
			 
			if ($com["tour"] == 0 ) {
				
				
					 echo ' <div class="col-md-1">
                             
                              <label>Frais Route</label>
                              <input type= "text" class="form-control route'.$i.' " placeholder="" value = "0" disabled="true" onkeypress="chiffres(event);" onkeyup="totalCumLigne();totalLigne($(\'.route'.$i.'\').val(),$(\'.retour'.$i.'\').val(),$(\'.pont'.$i.'\').val(),$(\'.tour'.$i.'\').val(),\'totalLigne'.$i.'\');" >
                              </div> ';
			}else{

			echo ' <div class="col-md-1">
                             
                              <label>Frais Route</label>
                              <input type= "text" class="form-control route'.$i.' " placeholder="" value = "'.$com["frais_route"]/$com["tour"].'" disabled="true" onkeypress="chiffres(event);" onkeyup="totalCumLigne();totalLigne($(\'.route'.$i.'\').val(),$(\'.retour'.$i.'\').val(),$(\'.pont'.$i.'\').val(),$(\'.tour'.$i.'\').val(),\'totalLigne'.$i.'\');" >
                              </div>';
			}				  
			 			 			  					  
						echo '      
                         
						<div class="col-md-1">
                            <label>M. Retour</label>
                            <select class="marchandiseR'.$i.' form-control" placeholder="" value = "" onchange="" >
							';
							echo '<option value='.addslashes($com["marchandiseR"]).'>'.addslashes($com["marchandiseR"]).'</option>
							<option value=""></option>
								<option value=""></option>
							<option value="BOIS">BOIS</option>
							<option value="CIMENT_42.5">CIMENT_42.5</option>
							<option value="CIMENT_32.5">CIMENT_32.5</option>
							<option value="CIMENT_VRAC">CIMENT_VRAC</option>
							<option value="CONTENAIRE">CONTENAIRE</option>
							<option value="ENGRAIS">ENGRAIS</option>
							<option value="GRAVIER">GRAVIER</option>
							<option value="MAIS">MAIS</option>
							<option value="PALETTE">PALETTE</option>
							<option value="PNEU">PNEU</option>
							<option value="POUZZOLANE">POUZZOLANE</option>
							<option value="SABLE">SABLE</option>
							<option value="SOJA">SOJA</option>';
													
							echo ' </select>
						</div>	';
						
						
			 
			if ($com["tour"] == 0 ) {
				
				
					 echo '				

			
						    <div class="col-md-1">
                             
                              <label>Frais Retour</label>
                              <input type= "text" class="form-control retour'.$i.' " placeholder="" value = "0"  onkeypress="chiffres(event);" onkeyup="totalCumLigne();totalCumLigne();totalLigne($(\'.route'.$i.'\').val(),$(\'.retour'.$i.'\').val(),$(\'.pont'.$i.'\').val(),$(\'.tour'.$i.'\').val(),\'totalLigne'.$i.'\');">
                            
                          </div>';
			}else{

			echo ' <div class="col-md-1">
                             
                              <label>Frais Retour</label>
                              <input type= "text" class="form-control retour'.$i.' " placeholder="" value = "'.$com["frais_retour"]/$com["tour"].'"  onkeypress="chiffres(event);" onkeyup="totalCumLigne();totalCumLigne();totalLigne($(\'.route'.$i.'\').val(),$(\'.retour'.$i.'\').val(),$(\'.pont'.$i.'\').val(),$(\'.tour'.$i.'\').val(),\'totalLigne'.$i.'\');">
                            
                          </div>';
			}				  
			 			 			  					  
						echo '      
						  
						 <div class="col-md-1">
                            <label>Nbre Sacs</label>
                            <input type="text" class="form-control tonnage'.$i.'" placeholder="" onkeypress="chiffres(event);" value = "'.$com["tonnage"].'" onkeypress="chiffres(event);" onkeyup="" >

                          </div>
						  
						  
						  
						  <div class="col-md-1">
                            <label>Pont Bascule</label>
                            <input type="text" class="form-control pont'.$i.'" placeholder="Pont Bascule" value = "'.$com["pont"].'" onkeypress="chiffres(event);" onkeyup="totalCumLigne();totalCumLigne();totalLigne($(\'.route'.$i.'\').val(),$(\'.retour'.$i.'\').val(),$(\'.pont'.$i.'\').val(),$(\'.tour'.$i.'\').val(),\'totalLigne'.$i.'\');">

                          </div> 
						  
						  <div class="col-md-1">
                            <label>Nbre Tour(s)</label>
                            <input type="text" class="form-control tour'.$i.'" placeholder="" onkeypress="chiffres(event);" value = "'.$com["tour"].'" onkeypress="chiffres(event);" onkeyup="totalCumLigne();totalCumLigne();totalLigne($(\'.route'.$i.'\').val(),$(\'.retour'.$i.'\').val(),$(\'.pont'.$i.'\').val(),$(\'.tour'.$i.'\').val(),\'totalLigne'.$i.'\');" >

                          </div>
						  
						  <div class="col-md-1">
                            <label>Total Ligne</label>
                            <input type="text" class="form-control totalLigne'.$i.'" placeholder="" onkeypress="chiffres(event);" value = "0" disabled = "true"; onkeyup="" >

                          </div> ';
		
				   

					
					if ($com["AFR"] == "oui") {
						echo' <div class="col-md-1">
                              <label>A. F.Route</label>
                              <input type="checkbox" class="form-control rjFR'.$i.'" checked = "true">
                          </div> ';
						  
					}else {
						
						echo' <div class="col-md-1">
                              <label>A. F.Route</label>
                              <input type="checkbox" class="form-control rjFR'.$i.'" >
                          </div> ';
						
					}
					
					
					if ($com["AFT"] == "oui") {

					echo'	<div class="col-md-1">
                              <label>A F.Retour</label>
                              <input type="checkbox" class="form-control rjFT'.$i.'" checked = "true">
                          </div> ';
						  
						  
					}else{
						
						echo' <div class="col-md-1">
                              <label>A F.Retour</label>
                              <input type="checkbox" class="form-control rjFT'.$i.'" >
                          </div> ';
						
					}
					
						if ($com["AP"] == "oui") {

					echo'	<div class="col-md-1">
                              <label>A. Pont</label>
                              <input type="checkbox" class="form-control rjP'.$i.'" checked = "true">
                          </div> ';
						  
						  
					}else{
						
						echo' <div class="col-md-1">
                              <label>A. Pont</label>
                              <input type="checkbox" class="form-control rjP'.$i.'">
                          </div> ';
						
					}
					
		
		echo '
						 <input type="hidden" class="form-control typeA'.$i.'"  placeholder=" en FCFA" value="'.$com["type"].'" disabled="true" onkeypress="chiffres(event);">                          
						 <input type="hidden" class="form-control id_demande'.$i.'"  placeholder=" en FCFA" value="'.$com["id_demande"].'" disabled="true" onkeypress="chiffres(event);">
                         <input type="hidden" class="form-control compteur'.$i.'"  placeholder=" en FCFA"  disabled="true" onkeypress="chiffres(event);">
						 <input type="hidden" class="form-control gazoil'.$i.'"  placeholder=" en FCFA" value="'.$com["litrage"].'" disabled="true" onkeypress="chiffres(event);">
						 <input type="hidden" class="form-control gazoilG'.$i.'"  placeholder=" en FCFA" value="'.$com["litrage1"].'" disabled="true" onkeypress="chiffres(event);">
						 
						  <input type="hidden" class="form-control routeM'.$i.'"  placeholder=" en FCFA" value = "'.$com["frais_route"].'" disabled="true" onkeypress="chiffres(event);">
						  <input type="hidden" class="form-control retourM'.$i.'"  placeholder=" en FCFA" value = "'.$com["frais_retour"].'" disabled="true" onkeypress="chiffres(event);">
						   <input type="hidden" class="form-control pontM'.$i.'"  placeholder=" en FCFA" value = "'.$com["pont"].'" disabled="true" onkeypress="chiffres(event);">
                   
				</div> 
            
       <hr>';
       $i++;
      }
	  
      $i = $i-1;
	  
      echo '<input type="hidden" class="form-control compteur"  placeholder=" en FCFA" value="'.$i.'" disabled="true" onkeypress="chiffres(event);">';

      echo '<div class="row">
	
	
	<div class="col-md-3" >
                            <div class="form-group">
                            <label>TOTAL FRAIS ROUTE</label>
                            <input type="text" class="totalLigne form-control" onkeypress="chiffres(event);" disabled = "true">
                              
                          </div>
    </div>
	
	<div class="col-md-1" >
	<br>
	
					    <button type="button"   class=" btn-primary btn-sm"  onclick="totalCumLigne();"><i class="fa fa-cog fa-fw" aria-hidden="true"></i></button>
                     
                             
                          </div>
	 </div>
  
  
 <hr>';
	  
	  
	  $this->db->close();
}

public function getListeDemmandePourModifN(){
    $po = $_POST["po"];
    $getAllCommande = $this->db->query("SELECT * from demande_navette where po_dem = '".$po."'")->result_array();
    $i=1;
	$type_vehicule="";
    foreach ($getAllCommande as $com) {
        # code...
  
    $getTypeCamion = $this->db->query("SELECT * from type_vehicule where id_type = (SELECT id_type_camion  from camion_benne where code = '".$com["code_camion"]."')")->row();  
 
   if (count($getTypeCamion) >0 ) {
  $type_vehicule = $getTypeCamion-> nom_type;
    }	


$getTypeCamion1 = $this->db->query("SELECT * from type_vehicule where id_type = (SELECT id_type_camion  from tracteur where code = '".$com["code_camion"]."')")->row();  
 
   if (count($getTypeCamion1) >0 ) {
  $type_vehicule = $getTypeCamion1-> nom_type;
    }	
   
   echo '<div class="row">
   
    <div class="col-md-1">
  <div class="form-group">
  <label>Compteur</label>
                            <input type="text"class="form-control cpt'.$i.'" placeholder="" value = "'.$i.'" >

                 </div>
    </div> 
  
    <div class="col-md-1" >
    <div class="form-group">
    <label>Délégué</label>
    <select class="delegue'.$i.' form-control" onchange="getCamionDelegue1($(\'.delegue'.$i.'\').val(),\'camion1'.$i.'\',\'immatriculation1'.$i.'\',\'route1'.$i.'\',\'retour1'.$i.'\');">
    ';
	echo "<option value='".$com['delegue']."'>".$com['delegue']."</option>";
    $this->crud_model_depense->leSelectDelegueCamionN();
                                
    echo '</select>
    </div>
    </div>
	
				  
				  
				    
				
	
    <div class="col-md-1">				  
		  <div class="form-group">
      <label>Véhicule</label> 
       <select class="camion1'.$i.' form-control" onchange="getMatriculeVehicule1_1($(\'.camion1'.$i.'\').val(),\'immatriculation1'.$i.'\');getTypeVehicule3_1($(\'.camion1'.$i.'\').val(),\'typeA'.$i.'\');getDistanceParCodeCamion1($(\'.camion1'.$i.'\').val(),\'destinationM'.$i.'\');">
       ';
	   
	   echo "<option value=".$com["code_camion"].">".$com["code_camion"]."</option>";
                     $this->crud_model_depense->leSelectCodeCamion();
       echo ' </select></div>
          </div>
		  
		    
	    <div class="col-md-1">	
		    
       <label>Matricule</label>
	   
	   <input type="text" class="form-control immatriculation1'.$i.'" placeholder="" value= "'.$com["immatriculation"].'" disabled = "true" >
      
          </div>
		  
		  
		  <div class="col-md-1">	
		    
       <label>Type Vehicule</label>
	   
	   <input type="text" class="form-control typeC'.$i.'" placeholder="" value= "'. $type_vehicule.'" disabled = "true" >
      
          </div>
		  
		  <div class="col-md-1">
                            <label>Kilometrage</label>
                            <input type="text" class="form-control kilometrage'.$i.'" placeholder="Kilométrage" value = "'.$com["kilometrage"].'" onkeypress="chiffres(event);" value = "0">

                          </div> 
						  
						  
	 <div class="col-md-3">				  
		  <div class="form-group">
      <label>Client</label> 
       <select class="client'.$i.' form-control" onchange="">';
      
	  $getClient = $this->db->query("SELECT * from clientfrais where id_client= ".$com["client"]."")->row();
				
				if (count($getClient) > 0 ) {
					 echo "<option value='".$getClient->id_client."'>".$getClient->nom."</option>";
				 } 	 
	  
	$this->crud_model_depense->leSelectClientFraisNavette();
       echo ' </select></div>
          </div>
		  
		
						  	  
		  
		     	

		   <div class="col-md-2">
               <div class="form-group">
                 <label>Destination</label>
                  <select class="destinationM'.$i.' form-control" onchange="getLitrageCamion1($(\'.destinationM'.$i.'\').val(),$(\'.typeA'.$i.'\').val(),\'gazoil'.$i.'\'); getFraisRoute1($(\'.destinationM'.$i.'\').val(),$(\'.typeA'.$i.'\').val(),\'route'.$i.'\');getFraisRetour1($(\'.destinationM'.$i.'\').val(),$(\'.typeA'.$i.'\').val(),\'retour'.$i.'\');">
                			 
				 
				   ';
				 
				 
				 $getArticle = $this->db->query("SELECT * from distance_littrage where id_distance = ".$com["destination"]."")->row();
				
				if (count($getArticle) > 0 ) {
					 echo "<option value='".$getArticle->id_distance."'>".$getArticle->distance."</option>";
				 } 	 
				
				// echo "<option value='".$com['distance']."'>".$getArticle->distance."</option>";
				
				$this->crud_model_depense->getDistanceParCodeCamion1();
				 
				      
            echo ' </select></div>
             </div>
			 
						  <div class="col-md-1">
                            <label>Litrage</label>
                            <input type="text" class="form-control litrage'.$i.'" placeholder="Litrage" value = "'.$com["litrage"].'" onkeypress="chiffres(event);" onkeyup="">

                          </div> 
						  
						  <div class="col-md-1">
                            <label>Nbre BL(s)</label>
                            <input type="text" class="form-control tour'.$i.'" placeholder="" onkeypress="chiffres(event);" value = "'.$com["tour"].'" onkeypress="chiffres(event);" onkeyup="totalCumLigneN();" >

                          </div>
						  
						  
			 <div class="col-md-2">				  
		  <div class="form-group">
      <label>Fournisseur</label> 
       <select class="fournisseur'.$i.' form-control" >';
      
//	  $getFournisseur = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur = ".$com["fournisseur"]."")->row();
		
	  $getFournisseur = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur = ".$com["fournisseur"]."")->row();
	  
			
				if (count($getFournisseur) > 0 ) {
					 echo "<option value='".$getFournisseur->id_fournisseur."'>".$getFournisseur->nom."</option>";
				 } 	 
	  
	$this->crud_model_depense->leSelectFournisseurGazoil();
       echo ' </select></div>
          </div> 
		  
		<div class="col-md-2">
                            <label>Date Consommation</label>
                          <div class="input-group " id="" data-target-input="nearest" >
                              
                                <input type="date" class="form-control datetimepicker-input date_demandeN'.$i.'" data-target="#reservationdate" placeholder="date effet" value="'.$com["date_dem1"].'" onchange="getExpirationPneu();" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                          </div>
         </div>  

						  
						  <div class="col-md-1">
                            <label>Total Ligne</label>
                            <input type="text" class="form-control totalParLigne'.$i.'" placeholder="" onkeypress="chiffres(event);" value = "0" disabled = "true"; onkeyup="" >

                          </div> ';
		
					
						if ($com["AG"] == "oui") {

					echo'	<div class="col-md-1">
                              <label>A. Gazoil</label>
                              <input type="checkbox" class="form-control rjG'.$i.'" checked = "true">
                          </div> ';
						  
						  
					}else{
						
						echo' <div class="col-md-1">
                              <label>A. Gazoil</label>
                              <input type="checkbox" class="form-control rjG'.$i.'">
                          </div> ';
						
					}
					
					if ($com["CON"] == "oui") {

						echo' <div class="col-md-1">
                              <label>CONS. ?</label>
                              <input type="checkbox" class="form-control con'.$i.'" checked = "true" >
                          </div> ';
						  
						  
					}else {
						
						echo' <div class="col-md-1">
                              <label>CONS. ?</label>
                              <input type="checkbox" class="form-control con'.$i.'"  >
                          </div> ';
						
					}
					
		
		echo '
						 <input type="hidden" class="form-control typeA'.$i.'"  placeholder=" en FCFA" value="'.$com["type"].'" disabled="true" onkeypress="chiffres(event);">                          
						 <input type="hidden" class="form-control id_demande'.$i.'"  placeholder=" en FCFA" value="'.$com["id_demande"].'" disabled="true" onkeypress="chiffres(event);">
                         <input type="hidden" class="form-control compteur'.$i.'"  placeholder=" en FCFA"  disabled="true" onkeypress="chiffres(event);">
						
				</div> 
            
       <hr>';
       $i++;
      }
	  
      $i = $i-1;
	  
      echo '<input type="hidden" class="form-control compteur"  placeholder=" en FCFA" value="'.$i.'" disabled="true" onkeypress="chiffres(event);">';

      echo '<div class="row">
	
	
	<div class="col-md-3" >
                            <div class="form-group">
                            <label>TOTAL GAZOIL NAVETTE</label>
                            <input type="text" class="totalLigne form-control" onkeypress="chiffres(event);" disabled = "true">
                              
                          </div>
    </div>
	
	<div class="col-md-1" >
	<br>
	
					    <button type="button"   class=" btn-primary btn-sm"  onclick="totalCumLigneN();"><i class="fa fa-cog fa-fw" aria-hidden="true"></i></button>
                     
                             
                          </div>
	 </div>
  
  
 <hr>';
	  
	  
	  $this->db->close();
}


public function getListeDemmandePourModifE(){
    $po = $_POST["po"];
    $getAllCommande = $this->db->query("SELECT * from demande_engin where po_dem = '".$po."'")->result_array();
    $i=1;
	$type_vehicule="";
    foreach ($getAllCommande as $com) {
        # code...
  
    $getTypeCamion = $this->db->query("SELECT * from type_vehicule where id_type = (SELECT id_type_camion  from engin where code = '".$com["code_camion"]."')")->row();  
 
   if (count($getTypeCamion) >0 ) {
  $type_vehicule = $getTypeCamion-> nom_type;
    }	



   
   echo '<div class="row">
   
    <div class="col-md-1">
  <div class="form-group">
  <label>Compteur</label>
                            <input type="text"class="form-control cpt'.$i.'" placeholder="" value = "'.$i.'" >

                 </div>
    </div> 
  
  			  
				  
				    
				
	
    <div class="col-md-1">				  
		  <div class="form-group">
      <label>Véhicule</label> 
       <select class="camion1'.$i.' form-control" onchange="getMatriculeVehicule1_1($(\'.camion1'.$i.'\').val(),\'immatriculation1'.$i.'\');getTypeVehicule3_1($(\'.camion1'.$i.'\').val(),\'typeA'.$i.'\');getDistanceParCodeCamion1($(\'.camion1'.$i.'\').val(),\'destinationM'.$i.'\');">
       ';
	   
	   echo "<option value=".$com["code_camion"].">".$com["code_camion"]."</option>";
                     $this->crud_model_depense->leSelectEtatCodeEngin();
       echo ' </select></div>
          </div>
		  
		    
	    <div class="col-md-1">	
		    
       <label>Matricule</label>
	   
	   <input type="text" class="form-control immatriculation1'.$i.'" placeholder="" value= "'.$com["immatriculation"].'" disabled = "true" >
      
          </div>
		  
		  
		  <div class="col-md-1">	
		    
       <label>Type Vehicule</label>
	   
	   <input type="text" class="form-control typeC'.$i.'" placeholder="" value= "'. $type_vehicule.'" disabled = "true" >
      
          </div>
		  
		  <div class="col-md-1">
                            <label>Kilometrage</label>
                            <input type="text" class="form-control kilometrage'.$i.'" placeholder="Kilométrage" value = "'.$com["kilometrage"].'" onkeypress="chiffres(event);" value = "0">

                          </div> 
						  
						  
	 <div class="col-md-3">				  
		  <div class="form-group">
      <label>Client</label> 
       <select class="client'.$i.' form-control" onchange="">';
      
	  $getClient = $this->db->query("SELECT * from clientfrais where id_client= ".$com["client"]."")->row();
				
				if (count($getClient) > 0 ) {
					 echo "<option value='".$getClient->id_client."'>".$getClient->nom."</option>";
				 } 	 
	  
	$this->crud_model_depense->leSelectClientFraisNavette();
       echo ' </select></div>
          </div>
						  <div class="col-md-1">
                            <label>Litrage</label>
                            <input type="text" class="form-control litrage'.$i.'" placeholder="Litrage" value = "'.$com["litrage"].'" onkeypress="chiffres(event);" onkeyup="">

                          </div> 
						  
						
						  
						  
			 <div class="col-md-2">				  
		  <div class="form-group">
      <label>Fournisseur</label> 
       <select class="fournisseur'.$i.' form-control" >';
      
//	  $getFournisseur = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur = ".$com["fournisseur"]."")->row();
		
	  $getFournisseur = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur = ".$com["fournisseur"]."")->row();
	  
			
				if (count($getFournisseur) > 0 ) {
					 echo "<option value='".$getFournisseur->id_fournisseur."'>".$getFournisseur->nom."</option>";
				 } 	 
	  
	$this->crud_model_depense->leSelectFournisseurGazoil();
       echo ' </select></div>
          </div> 
		  
		<div class="col-md-2">
                            <label>Date Consommation</label>
                          <div class="input-group " id="" data-target-input="nearest" >
                              
                                <input type="date" class="form-control datetimepicker-input date_demandeN'.$i.'" data-target="#reservationdate" placeholder="date effet" value="'.$com["date_dem1"].'" onchange="getExpirationPneu();" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                          </div>
         </div>  

						  
						  <div class="col-md-1">
                            <label>Total Ligne</label>
                            <input type="text" class="form-control totalParLigne'.$i.'" placeholder="" onkeypress="chiffres(event);" value = "0" disabled = "true"; onkeyup="" >

                          </div> ';
		
					
						if ($com["AG"] == "oui") {

					echo'	<div class="col-md-1">
                              <label>A. Gazoil</label>
                              <input type="checkbox" class="form-control rjG'.$i.'" checked = "true">
                          </div> ';
						  
						  
					}else{
						
						echo' <div class="col-md-1">
                              <label>A. Gazoil</label>
                              <input type="checkbox" class="form-control rjG'.$i.'">
                          </div> ';
						
					}
					
					if ($com["CON"] == "oui") {

						echo' <div class="col-md-1">
                              <label>CONS. ?</label>
                              <input type="checkbox" class="form-control con'.$i.'" checked = "true" >
                          </div> ';
						  
						  
					}else {
						
						echo' <div class="col-md-1">
                              <label>CONS. ?</label>
                              <input type="checkbox" class="form-control con'.$i.'"  >
                          </div> ';
						
					}
					
		
		echo '
						 <input type="hidden" class="form-control typeA'.$i.'"  placeholder=" en FCFA" value="'.$com["type"].'" disabled="true" onkeypress="chiffres(event);">                          
						 <input type="hidden" class="form-control id_demande'.$i.'"  placeholder=" en FCFA" value="'.$com["id_demande"].'" disabled="true" onkeypress="chiffres(event);">
                         <input type="hidden" class="form-control compteur'.$i.'"  placeholder=" en FCFA"  disabled="true" onkeypress="chiffres(event);">
						
				</div> 
            
       <hr>';
       $i++;
      }
	  
      $i = $i-1;
	  
      echo '<input type="hidden" class="form-control compteur"  placeholder=" en FCFA" value="'.$i.'" disabled="true" onkeypress="chiffres(event);">';

      echo '<div class="row">
	
	
	<div class="col-md-3" >
                            <div class="form-group">
                            <label>TOTAL GAZOIL ENGIN</label>
                            <input type="text" class="totalLigne form-control" onkeypress="chiffres(event);" disabled = "true">
                              
                          </div>
    </div>
	
	<div class="col-md-1" >
	<br>
	
					    <button type="button"   class=" btn-primary btn-sm"  onclick="totalCumLigneN();"><i class="fa fa-cog fa-fw" aria-hidden="true"></i></button>
                     
                             
                          </div>
	 </div>
  
  
 <hr>';
	  
	  
	  $this->db->close();
}


public function getListeDemmandePourModifNA(){
    $po = $_POST["po"];
    $getAllCommande = $this->db->query("SELECT * from demande_navette_autre where po_dem = '".$po."'")->result_array();
    $i=1;
	$type_vehicule="";
    foreach ($getAllCommande as $com) {
        # code...
  
    $getTypeCamion = $this->db->query("SELECT * from type_vehicule where id_type = (SELECT id_type_camion  from camion_benne where code = '".$com["code_camion"]."')")->row();  
 
   if (count($getTypeCamion) >0 ) {
  $type_vehicule = $getTypeCamion-> nom_type;
    }	


$getTypeCamion1 = $this->db->query("SELECT * from type_vehicule where id_type = (SELECT id_type_camion  from tracteur where code = '".$com["code_camion"]."')")->row();  
 
   if (count($getTypeCamion1) >0 ) {
  $type_vehicule = $getTypeCamion1-> nom_type;
    }	
   
   echo '<div class="row">
   
    <div class="col-md-1">
  <div class="form-group">
  <label>Compteur</label>
                            <input type="text"class="form-control cpt'.$i.'" placeholder="" value = "'.$i.'" >

                 </div>
    </div> 
  
    <div class="col-md-1" >
    <div class="form-group">
    <label>Délégué</label>
    <select class="delegue'.$i.' form-control" onchange="getCamionDelegue1($(\'.delegue'.$i.'\').val(),\'camion1'.$i.'\',\'immatriculation1'.$i.'\',\'route1'.$i.'\',\'retour1'.$i.'\');">
    ';
	echo "<option value='".$com['delegue']."'>".$com['delegue']."</option>";
    $this->crud_model_depense->leSelectDelegueCamionN();
                                
    echo '</select>
    </div>
    </div>
	
				  
				  
				    
				
	
    <div class="col-md-1">				  
		  <div class="form-group">
      <label>Véhicule</label> 
       <select class="camion1'.$i.' form-control" onchange="getMatriculeVehicule1_1($(\'.camion1'.$i.'\').val(),\'immatriculation1'.$i.'\');getTypeVehicule3_1($(\'.camion1'.$i.'\').val(),\'typeA'.$i.'\');getDistanceParCodeCamion1($(\'.camion1'.$i.'\').val(),\'destinationM'.$i.'\');">
       ';
	   
	   echo "<option value=".$com["code_camion"].">".$com["code_camion"]."</option>";
                     $this->crud_model_depense->leSelectCodeCamion();
       echo ' </select></div>
          </div>
		  
		    
	    <div class="col-md-1">	
		    
       <label>Matricule</label>
	   
	   <input type="text" class="form-control immatriculation1'.$i.'" placeholder="" value= "'.$com["immatriculation"].'" disabled = "true" >
      
          </div>
		  
		  
		  <div class="col-md-1">	
		    
       <label>Type Vehicule</label>
	   
	   <input type="text" class="form-control typeC'.$i.'" placeholder="" value= "'. $type_vehicule.'" disabled = "true" >
      
          </div>
		  
		  <div class="col-md-1">
                            <label>Kilometrage</label>
                            <input type="text" class="form-control kilometrage'.$i.'" placeholder="Kilométrage" value = "'.$com["kilometrage"].'" onkeypress="chiffres(event);" value = "0">

                          </div> 
						  
						  
	 <div class="col-md-3">				  
		  <div class="form-group">
      <label>Client</label> 
       <select class="client'.$i.' form-control" onchange="">';
      
	  $getClient = $this->db->query("SELECT * from clientfrais where id_client= ".$com["client"]."")->row();
				
				if (count($getClient) > 0 ) {
					 echo "<option value='".$getClient->id_client."'>".$getClient->nom."</option>";
				 } 	 
	  
	$this->crud_model_depense->leSelectClientFraisNavette();
       echo ' </select></div>
          </div>
		  
		
						  	  
		  
		     	

		   <div class="col-md-2">
               <div class="form-group">
                 <label>Destination</label>
                  <select class="destinationM'.$i.' form-control" onchange="getLitrageCamion1($(\'.destinationM'.$i.'\').val(),$(\'.typeA'.$i.'\').val(),\'litrage'.$i.'\');">
                			 
				 
				   ';
				 
				 
				 $getArticle = $this->db->query("SELECT * from distance_littrage where id_distance = ".$com["destination"]."")->row();
				
				if (count($getArticle) > 0 ) {
					 echo "<option value='".$getArticle->id_distance."'>".$getArticle->distance."</option>";
				 } 	 
				
				// echo "<option value='".$com['distance']."'>".$getArticle->distance."</option>";
				
				$this->crud_model_depense->getDistanceParCodeCamion1();
				 
				      
            echo ' </select></div>
             </div>
			 
						  <div class="col-md-1">
                            <label>Litrage</label>
                            <input type="text" class="form-control litrage'.$i.'" placeholder="Litrage" value = "'.$com["litrage"].'" onkeypress="chiffres(event);" onkeyup="">

                          </div> 
						  
						  <div class="col-md-1">
                            <label>Nbre BL(s)</label>
                            <input type="text" class="form-control tour'.$i.'" placeholder="" onkeypress="chiffres(event);" value = "'.$com["tour"].'" onkeypress="chiffres(event);" onkeyup="totalCumLigneN();" >

                          </div>
						  
						  
			 <div class="col-md-2">				  
		  <div class="form-group">
      <label>Fournisseur</label> 
       <select class="fournisseur'.$i.' form-control" >';
      
//	  $getFournisseur = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur = ".$com["fournisseur"]."")->row();
		
	  $getFournisseur = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur = ".$com["fournisseur"]."")->row();
	  
			
				if (count($getFournisseur) > 0 ) {
					 echo "<option value='".$getFournisseur->id_fournisseur."'>".$getFournisseur->nom."</option>";
				 } 	 
	  
	$this->crud_model_depense->leSelectFournisseurGazoil();
       echo ' </select></div>
          </div> 
		  
		<div class="col-md-2">
                            <label>Date Consommation</label>
                          <div class="input-group " id="" data-target-input="nearest" >
                              
                                <input type="date" class="form-control datetimepicker-input date_demandeN'.$i.'" data-target="#reservationdate" placeholder="date effet" value="'.$com["date_dem1"].'" onchange="getExpirationPneu();" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                          </div>
         </div>  

						  
						  <div class="col-md-1">
                            <label>Total Ligne</label>
                            <input type="text" class="form-control totalParLigne'.$i.'" placeholder="" onkeypress="chiffres(event);" value = "0" disabled = "true"; onkeyup="" >

                          </div> ';
		
					
						if ($com["AG"] == "oui") {

					echo'	<div class="col-md-1">
                              <label>A. Gazoil</label>
                              <input type="checkbox" class="form-control rjG'.$i.'" checked = "true">
                          </div> ';
						  
						  
					}else{
						
						echo' <div class="col-md-1">
                              <label>A. Gazoil</label>
                              <input type="checkbox" class="form-control rjG'.$i.'">
                          </div> ';
						
					}
					
					if ($com["CON"] == "oui") {

						echo' <div class="col-md-1">
                              <label>CONS. ?</label>
                              <input type="checkbox" class="form-control con'.$i.'" checked = "true" >
                          </div> ';
						  
						  
					}else {
						
						echo' <div class="col-md-1">
                              <label>CONS. ?</label>
                              <input type="checkbox" class="form-control con'.$i.'"  >
                          </div> ';
						
					}
					
		
		echo '
						 <input type="hidden" class="form-control typeA'.$i.'"  placeholder=" en FCFA" value="'.$com["type"].'" disabled="true" onkeypress="chiffres(event);">                          
						 <input type="hidden" class="form-control id_demande'.$i.'"  placeholder=" en FCFA" value="'.$com["id_demande"].'" disabled="true" onkeypress="chiffres(event);">
                         <input type="hidden" class="form-control compteur'.$i.'"  placeholder=" en FCFA"  disabled="true" onkeypress="chiffres(event);">
						
				</div> 
            
       <hr>';
       $i++;
      }
	  
      $i = $i-1;
	  
      echo '<input type="hidden" class="form-control compteur"  placeholder=" en FCFA" value="'.$i.'" disabled="true" onkeypress="chiffres(event);">';

      echo '<div class="row">
	
	
	<div class="col-md-3" >
                            <div class="form-group">
                            <label>TOTAL GAZOIL NAVETTE</label>
                            <input type="text" class="totalLigne form-control" onkeypress="chiffres(event);" disabled = "true">
                              
                          </div>
    </div>
	
	<div class="col-md-1" >
	<br>
	
					    <button type="button"   class=" btn-primary btn-sm"  onclick="totalCumLigneN();"><i class="fa fa-cog fa-fw" aria-hidden="true"></i></button>
                     
                             
                          </div>
	 </div>
  
  
 <hr>';
	  
	  
	  $this->db->close();
}


public function getListeDemmandePourModifST(){
    $po = $_POST["po"];
    $getAllCommande = $this->db->query("SELECT * from demande_navette_autre where po_dem = '".$po."'")->result_array();
    $i=1;
	$type_vehicule="";
    foreach ($getAllCommande as $com) {
        # code...
  
    $getTypeCamion = $this->db->query("SELECT * from type_vehicule where id_type = (SELECT id_type_camion  from camion_benne where code = '".$com["code_camion"]."')")->row();  
 
   if (count($getTypeCamion) >0 ) {
  $type_vehicule = $getTypeCamion-> nom_type;
    }	


$getTypeCamion1 = $this->db->query("SELECT * from type_vehicule where id_type = (SELECT id_type_camion  from tracteur where code = '".$com["code_camion"]."')")->row();  
 
   if (count($getTypeCamion1) >0 ) {
  $type_vehicule = $getTypeCamion1-> nom_type;
    }	
   
   echo '<div class="row">
   
    <div class="col-md-1">
  <div class="form-group">
  <label>Compteur</label>
                            <input type="text"class="form-control cpt'.$i.'" placeholder="" value = "'.$i.'" >

                 </div>
    </div> 
  
    <div class="col-md-1" >
    <div class="form-group">
    <label>Délégué</label>
    <select class="delegue'.$i.' form-control" onchange="getCamionDelegue1($(\'.delegue'.$i.'\').val(),\'camion1'.$i.'\',\'immatriculation1'.$i.'\',\'route1'.$i.'\',\'retour1'.$i.'\');">
    ';
	echo "<option value='".$com['delegue']."'>".$com['delegue']."</option>";
    $this->crud_model_depense->leSelectDelegueCamionN();
                                
    echo '</select>
    </div>
    </div>
	
				  
				  
				    
				
	
    <div class="col-md-1">				  
		  <div class="form-group">
      <label>Véhicule</label> 
       <select class="camion1'.$i.' form-control" onchange="getMatriculeVehicule1_1($(\'.camion1'.$i.'\').val(),\'immatriculation1'.$i.'\');getTypeVehicule3_1($(\'.camion1'.$i.'\').val(),\'typeA'.$i.'\');getDistanceParCodeCamion1($(\'.camion1'.$i.'\').val(),\'destinationM'.$i.'\');">
       ';
	   
	   echo "<option value=".$com["code_camion"].">".$com["code_camion"]."</option>";
                     $this->crud_model_depense->leSelectCodeCamion();
       echo ' </select></div>
          </div>
		  
		    
	    <div class="col-md-1">	
		    
       <label>Matricule</label>
	   
	   <input type="text" class="form-control immatriculation1'.$i.'" placeholder="" value= "'.$com["immatriculation"].'" disabled = "true" >
      
          </div>
		  
		  
		  <div class="col-md-1">	
		    
       <label>Type Vehicule</label>
	   
	   <input type="text" class="form-control typeC'.$i.'" placeholder="" value= "'. $type_vehicule.'" disabled = "true" >
      
          </div>
		  
		  <div class="col-md-1">
                            <label>Kilometrage</label>
                            <input type="text" class="form-control kilometrage'.$i.'" placeholder="Kilométrage" value = "'.$com["kilometrage"].'" onkeypress="chiffres(event);" value = "0">

                          </div> 
						  
						  
	 		  
						  <div class="col-md-1">
                            <label>Nbre BL(s)</label>
                            <input type="text" class="form-control tour'.$i.'" placeholder="" onkeypress="chiffres(event);" value = "'.$com["tour"].'" onkeypress="chiffres(event);" onkeyup="totalCumLigneN();" >

                          </div>
						  
						  
			
						  
						  <div class="col-md-1">
                            <label>Total Ligne</label>
                            <input type="text" class="form-control totalParLigne'.$i.'" placeholder="" onkeypress="chiffres(event);" value = "0" disabled = "true"; onkeyup="" >

                          </div> ';
		
					
					
		
		echo '
						 <input type="hidden" class="form-control typeA'.$i.'"  placeholder=" en FCFA" value="'.$com["type"].'" disabled="true" onkeypress="chiffres(event);">                          
						 <input type="hidden" class="form-control id_demande'.$i.'"  placeholder=" en FCFA" value="'.$com["id_demande"].'" disabled="true" onkeypress="chiffres(event);">
                         <input type="hidden" class="form-control compteur'.$i.'"  placeholder=" en FCFA"  disabled="true" onkeypress="chiffres(event);">
						
				</div> 
            
       <hr>';
       $i++;
      }
	  
      $i = $i-1;
	  
      echo '<input type="hidden" class="form-control compteur"  placeholder=" en FCFA" value="'.$i.'" disabled="true" onkeypress="chiffres(event);">';

      echo '<div class="row">
	
	
	<div class="col-md-3" >
                            <div class="form-group">
                            <label>TOTAL GAZOIL NAVETTE</label>
                            <input type="text" class="totalLigne form-control" onkeypress="chiffres(event);" disabled = "true">
                              
                          </div>
    </div>
	
	<div class="col-md-1" >
	<br>
	
					    <button type="button"   class=" btn-primary btn-sm"  onclick="totalCumLigneN();"><i class="fa fa-cog fa-fw" aria-hidden="true"></i></button>
                     
                             
                          </div>
	 </div>
  
  
 <hr>';
	  
	  
	  $this->db->close();
}




public function getListeDemmandePourModifG(){
    $po = $_POST["po"];
	
	$fournisseur = $_POST["fournisseur"];

	
	$litrageR =0;
	
    $getAllCommande = $this->db->query("SELECT * from demande_frais where po_dem = '".$po."'")->result_array();
	
    $i=1;
	
	 $type_vehicule="";
	 
    foreach ($getAllCommande as $com) {
		
		
		  $getTypeCamion = $this->db->query("SELECT * from type_vehicule where id_type = (SELECT id_type_camion  from camion_benne where code = '".$com["code_camion"]."')")->row();  
 
   if (count($getTypeCamion) >0 ) {
  $type_vehicule = $getTypeCamion-> nom_type;
    }	


  $getTypeCamion1 = $this->db->query("SELECT * from type_vehicule where id_type = (SELECT id_type_camion  from tracteur where code = '".$com["code_camion"]."')")->row();  
 
   if (count($getTypeCamion1) >0 ) {
  $type_vehicule = $getTypeCamion1-> nom_type;
    }	
   	
	$litrageTH = $com["litrage"]*$com["tour"];
		
    $getStockCamion1 = $this->db->query("SELECT * from stock_vehicule where vehicule = '".$com["code_camion"]."' and date_stock = '".$com["date_dem"]."' and litrageA = 1 ORDER BY ref DESC LIMIT 1")->row();  
    $getStockCamion2 = $this->db->query("SELECT * from stock_vehicule where vehicule = '".$com["code_camion"]."' and date_stock <> '".$com["date_dem"]."' and litrageA = 0 ORDER BY ref DESC LIMIT 1")->row();  

   echo '<div class="row">
  
    <div class="col-md-1">
  <div class="form-group">
  <label>Compteur</label>
                            <input type="text"class="form-control cpt'.$i.'" placeholder="" value = "'.$i.'" disabled = "true">

                 </div>
    </div> 
  
  
    <div class="col-md-1" >
    <div class="form-group">
    <label>Délégué</label>
    <select class="delegue'.$i.' form-control" onchange="getCamionDelegue1($(\'.delegue'.$i.'\').val(),\'camion1'.$i.'\',\'immatriculation1'.$i.'\',\'litrage1'.$i.'\',\'route1'.$i.'\',\'retour1'.$i.'\');" disabled = "true">
    ';
	echo "<option value='".$com['delegue']."'>".$com['delegue']."</option>";
    $this->crud_model_depense->leSelectDelegueCamion();
	
	
	
                                
    echo '</select>
    </div>
    </div>
	
				  <div class="col-md-1">
                            <label>N°BL</label>
                            <input type="text" class="form-control bl'.$i.'" placeholder="" value="'.$com["bl"].'" disabled = "true">

                  </div>
	
    <div class="col-md-1">				  
		  <div class="form-group">
      <label>Véhicule</label> 
       <select class="camion1'.$i.' form-control" onchange="getMatriculeVehicule1_1($(\'.camion1'.$i.'\').val(),\'immatriculation1'.$i.'\');getTypeVehicule3_1($(\'.camion1'.$i.'\').val(),\'typeA'.$i.'\');getDistanceParCodeCamion1($(\'.camion1'.$i.'\').val(),\'destinationM'.$i.'\');" disabled = "true">
       ';
	   
	   echo "<option value=".$com["code_camion"].">".$com["code_camion"]."</option>";
                     $this->crud_model_depense->leSelectCodeCamion();
					 
				 
					 
       echo ' </select></div>
          </div>		  
		  
		    
	    <div class="col-md-1">	
		    
       <label>Matricule</label>
	   
	   <input type="text" class="form-control immatriculation1'.$i.'" placeholder="" value= "'.$com["immatriculation"].'" disabled = "true" disabled = "true">
      
          </div>
		  
		 
 <div class="col-md-1">	
		    
       <label>Type Vehicule</label>
	   
	   <input type="text" class="form-control typeC'.$i.'" placeholder="" value= "'. $type_vehicule.'" disabled = "true" >
      
          </div>		 
		  
		    

		   <div class="col-md-2">
               <div class="form-group">
                 <label>Destination</label>
                  <select class="destinationM'.$i.' form-control" onchange="getLitrageCamion1($(\'.destinationM'.$i.'\').val(),$(\'.type1'.$i.'\').val(),\'litrage'.$i.'\');getFraisRoute1($(\'.destinationM'.$i.'\').val(),$(\'.typeA'.$i.'\').val(),\'route'.$i.'\');getFraisRetour1($(\'.destinationM'.$i.'\').val(),$(\'.typeA'.$i.'\').val(),\'retour'.$i.'\');" disabled = "true">
                 ';
				 
				 
				 $getArticle = $this->db->query("SELECT * from distance_littrage where id_distance = ".$com["destination"]."")->row();
				
				if (count($getArticle) > 0 ) {
					 echo "<option value='".$getArticle->id_distance."'>".$getArticle->distance."</option>";
				 } 	 
				
	
				$this->crud_model_depense->getDistanceParCodeCamion1();
				 
				      
            echo ' </select></div>
             </div>';
			 
			 if (count($getStockCamion1) >0) {
			 
			 echo '
			 
			 
			 <div class="col-md-1">
                            <label>stock Camion</label>
                            <input type="text" class="form-control stock'.$i.'" placeholder="" value = "'.$getStockCamion1->litrageP.'" onkeypress="chiffres(event);" onkeyup="" disabled = "true" >

             </div>'; 
			 
			 }else if (count($getStockCamion2) >0){
				 
				   
				
					 
				 echo '
			 
			 
			 <div class="col-md-1">
                            <label>stock Camion</label>
                            <input type="text" class="form-control stock'.$i.'" placeholder="" value = "'.$getStockCamion2->litrageP.'" onkeypress="chiffres(event);" onkeyup="" disabled = "true" >

             </div>'; 	 
					 
				
			 }else{
				 
				 
			 echo '
			 
			 
			 <div class="col-md-1">
                            <label>stock Camion</label>
                            <input type="text" class="form-control stock'.$i.'" placeholder="" value = "0" onkeypress="chiffres(event);" onkeyup="" disabled = "true" >

             </div>'; 	 
			 
			 }
			 
			 echo '
			 <div class="col-md-1">
                            <label>Litrage TH</label>
                            <input type="text" class="form-control litrageTH'.$i.' " placeholder="" value = "'.$com["litrage"]*$com["tour"].'" onkeypress="chiffres(event);" disabled = "true" >

                          </div>	

					<div class="col-md-1">
                            <label>Complément</label>
                            <input type="text" class="form-control complement'.$i.' " placeholder="" value = "'.$com["complement"].'" onkeypress="chiffres(event);" onkeyup=  "totalLigneGazoil($(\'.litrageTH'.$i.'\').val(),$(\'.stock'.$i.'\').val(),$(\'.complement'.$i.'\').val(),\'litrageR'.$i.'\'); totalDifference($(\'.litrageR'.$i.'\').val(),$(\'.stock'.$i.'\').val(),$(\'.complement'.$i.'\').val(),$(\'.litrageTH'.$i.'\').val(),\'difference'.$i.'\');" >

                          </div>
						  
			 ';
			 	  
			if ( $com["litrage1"] == 0 ) {
				
				if (count($getStockCamion1) >0) {
				
				$litrageR = $litrageTH + $com["complement"]- $getStockCamion1->litrageP;
				
				$litrageS = 0;

				}else{		

                $litrageR = $litrageTH + $com["complement"];
				
				$litrageS = 0;
				
				}				
				
				
				echo '	<div class="col-md-1">
                            <label>Litrage Réel</label>
                            <input type="text" class="form-control litrageR'.$i.' " placeholder="" value = "'.$litrageR.'" onkeypress="chiffres(event);"  disabled = "true" onkeyup=  "totalDifference($(\'.litrageR'.$i.'\').val(),$(\'.stock'.$i.'\').val(),$(\'.complement'.$i.'\').val(),$(\'.litrageTH'.$i.'\').val(),\'difference'.$i.'\');">

                          </div> ';
				
						  
			}else{
				
				if (count($getStockCamion1) >0) {
				
				$litrageR = $litrageTH + $com["complement"]- $getStockCamion1->litrageP;
				
				$litrageS = $litrageR - $litrageTH - $com["complement"] + $getStockCamion1->litrageP ;

				}else{		

                $litrageR = $litrageTH + $com["complement"];
				
				$litrageS = $litrageR - $litrageTH - $com["complement"];
				
				}				
				
						
				echo' <div class="col-md-1">
                            <label>Litrage Réel</label>
                            <input type="text" class="form-control litrageR'.$i.' " placeholder="" value = "'.$litrageR.'" onkeypress="chiffres(event);" disabled = "true" onkeyup=  "totalDifference($(\'.litrageR'.$i.'\').val(),$(\'.stock'.$i.'\').val(),$(\'.complement'.$i.'\').val(),$(\'.litrageTH'.$i.'\').val(),\'difference'.$i.'\');"  >

                          </div>	 ';		 	
			}
				 echo '
			 
						  
			 <div class="col-md-2">				  
		  <div class="form-group">
      <label>Fournisseur</label> 
       <select class="fournisseur'.$i.' form-control" >';
      
//	  $getFournisseur = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur = ".$com["fournisseur"]."")->row();
		
	  $getFournisseur = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur =".$com["fournisseur"]."")->row();
	  
			
				if (count($getFournisseur) > 0 ) {
					 echo "<option value='".$getFournisseur->id_fournisseur."'>".$getFournisseur->nom."</option>";
				 } 	 
	  
	$this->crud_model_depense->leSelectFournisseurGazoil();
       echo ' </select></div>
          </div> 
		  
		<div class="col-md-2">
                            <label>Date Consommation</label>
                          <div class="input-group " id="" data-target-input="nearest" >
                              
                                <input type="date" class="form-control datetimepicker-input date_demande2'.$i.'" data-target="#reservationdate" placeholder="date effet" value="'.$com["date_dem2"].'" onchange="getExpirationPneu();" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                          </div>
         </div>  

		 
		  
		 
						  
			  <div class="col-md-1">
                            <label>Nbre Sacs</label>
                            <input type="text" class="form-control tonnage'.$i.'" placeholder="" onkeypress="chiffres(event);" value = "'.$com["tonnage"].'" onkeypress="chiffres(event);" onkeyup="" disabled = "true" >

             </div> 
					  
						  
			 
						  
						  <div class="col-md-3">
                            <label>Justification</label>
                            <input type="text" class="form-control detail'.$i.' " placeholder="" value = "'.$com["detail"].'"   >

                          </div>
						  
						  
						  <div class="col-md-1">
                            <label>Nbre Tour(s)</label>
                            <input type="text" class="form-control tour'.$i.'" placeholder="" onkeypress="chiffres(event);" value = "'.$com["tour"].'" onkeypress="chiffres(event);" onkeyup="" disabled = "true" >

                          </div>
						  
						  
						  ';
						  
						  if(($this->session->userdata('identifiant')=='SUPERVISEUR' ) || ($this->session->userdata('identifiant')=='nathan' ))  {

						   if ($com["AG"] == "oui") {

						echo' <div class="col-md-1">
                              <label>A. GAZOIL</label>
                              <input type="checkbox" class="form-control rjG'.$i.'" checked = "true" >
                          </div> ';
						  
						  
					}else {
						
						echo' <div class="col-md-1">
                              <label>A. GAZOIL</label>
                              <input type="checkbox" class="form-control rjG'.$i.'"  >
                          </div> ';
						
					}
					
					
					
					
					
					 if ($com["CON"] == "oui") {

						echo' <div class="col-md-1">
                              <label>CONS. ?</label>
                              <input type="checkbox" class="form-control con'.$i.'" checked = "true" >
                          </div> ';
						  
						  
					}else {
						
						echo' <div class="col-md-1">
                              <label>CONS. ?</label>
                              <input type="checkbox" class="form-control con'.$i.'"  >
                          </div> ';
						
					}
					
					}else{
						
						
						
					 if ($com["CON"] == "oui") {

						echo' <div class="col-md-1">
                              <label>CONS. ?</label>
                              <input type="checkbox" class="form-control con'.$i.'" checked = "true"  >
                          </div> ';
						  
						  
					}else {
						
						echo' <div class="col-md-1">
                              <label>CONS. ?</label>
                              <input type="checkbox" class="form-control con'.$i.'" >
                          </div> ';
						
					}
					
											   if ($com["AG"] == "oui") {

						echo' <div class="col-md-1">
                              <label>A. GAZOIL</label>
                              <input type="checkbox" class="form-control rjG'.$i.'" checked = "true" >
                          </div> ';
						  
						  
					}else {
						
						echo' <div class="col-md-1">
                              <label>A. GAZOIL</label>
                              <input type="checkbox" class="form-control rjG'.$i.'"  >
                          </div> ';
						
					}
					
					}
		
		
		echo '
						 <input type="hidden" class="form-control type1'.$i.'"  placeholder=" en FCFA" value="'.$com["type"].'" disabled="true" onkeypress="chiffres(event);"> 
						 <input type="hidden" class="form-control id_demande'.$i.'"  placeholder=" en FCFA" value="'.$com["id_demande"].'" disabled="true" onkeypress="chiffres(event);">
						 <input type="hidden" class="form-control difference'.$i.'" placeholder=" en FCFA" value = "'.$litrageS.'" disabled="true" onkeypress="chiffres(event);">
                         <input type="hidden" class="form-control compteur'.$i.'"  placeholder=" en FCFA"  disabled="true" onkeypress="chiffres(event);">
						 
				</div> 
            
       <hr>';
       $i++;
      }
	  
      $i = $i-1;
	  
      echo '<input type="hidden" class="form-control compteur"  placeholder=" en FCFA" value="'.$i.'" disabled="true" onkeypress="chiffres(event);">';

      $this->db->close();
}



public function getDetailDemande(){
    $po = $_POST["po"];
	
	
	  $query2 = $this->db->query("SELECT rj,rj1 from demande_frais where po_dem = '".$po."' and (rj= 'oui' or rj1 ='oui') limit 1")->row(); 
	  
	  
	  if (count($query2) >0 ) {
				 
				
					 
					$query1 = $this->db->query('SELECT * from demande_frais where po_dem ="'.$po.'" order by id_demande')->result_array();
          $compteur = 0;
		  $compteur1 = 0;
		  $compteur2 = 0;
        foreach ($query1 as $row) {
            # code...
		$compteur1 = 0;
		$compteur1 =$compteur1+ $row['frais_route']+$row['frais_retour']+$row['pont'] ;
		$compteur2 =$compteur2+ $row['frais_route']+$row['frais_retour']+$row['pont'] ;
		
            echo "<tr style='border:none; text-align:center;font-size: 13px;font-weight:10px;padding:0px;'>
                    

                    <td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px' >".$row['bl']."</td>
					 <td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px' >".$row['date_dem1']."</td>
					
					<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px' >".$row['code_camion']."</td>
					
					<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px' >".$row['immatriculation']."</td>";  
					
					$getArticle = $this->db->query("SELECT * FROM distance_littrage where id_distance = ".$row['destination']."")->row();
					
                    $getClient= $this->db->query("SELECT * FROM clientfrais where id_client = ".$row['client']."")->row();
					
				   echo"  	<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px' >".$getClient->nom."</td>

                            <td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;'>".$getArticle->distance."</td>
							
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px'>".$row['marchandiseD']."</td>
							
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:10px'>".$row['frais_route']."</td>
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px'>".$row['marchandiseR']."</td>
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:10px'>".$row['frais_retour']."</td>
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:10px'>".$row['tour']."</td>
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:10px'>".$row['pont']."</td>
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:20px'>".$compteur1."</td>
							";
                        
                 
                    
                
                    
                  $compteur++;
        } 
					 
					}else{
						
						
        echo "Frais de route non confirmé par les administrateurs";
    }
	
         

        $this->db->close();
    }
	
	
public function getDetailDemandeN(){
    $po = $_POST["po"];
	
	
	  $query2 = $this->db->query("SELECT rj,rj1 from demande_navette where po_dem = '".$po."' and (rj= 'oui' or rj1 ='oui') limit 1")->row(); 
	  
	  
	  if (count($query2) >0 ) {
				 
					 
					$query1 = $this->db->query('SELECT * from demande_navette where po_dem ="'.$po.'" order by id_demande')->result_array();
					
					
					 
          $compteur = 0;
		
        foreach ($query1 as $row) {
            # code...
		$compteur1 = 0;
		
		$getOperation = $this->db->query("SELECT * from operation where id_operation = ".$row['operation']." limit 1")->row(); 
		$getFournisseur = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur= ".$row['fournisseur']." limit 1")->row(); 
		
		$compteur1 = $row['litrage']*$row['tour'];
		
            echo "<tr style='border:none; text-align:center;font-size: 13px;font-weight:10px;padding:0px;'>
                  
                   
					 <td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px' >".$getOperation->nom_op."</td>
					
					<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px' >".$row['code_camion']."</td>
					
					<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px' >".$row['immatriculation']."</td>";  
					
					$getArticle = $this->db->query("SELECT * FROM distance_littrage where id_distance = ".$row['destination']."")->row();
					
                    $getClient= $this->db->query("SELECT * FROM clientfrais where id_client = ".$row['client']."")->row();
					
				   echo"  	<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px' >".$getClient->nom."</td>

                            <td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;'>".$getArticle->distance."</td>
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:10px'>".$row['litrage']."</td>
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:10px'>".$row['tour']."</td>
							
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:20px'>".$compteur1."</td>
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:10px'>".$getFournisseur->nom."</td>
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:10px'></td>
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:10px'></td>
							";
                        
                 
                    
                
                    
                  $compteur++;
        } 
					 
					}else{
						
						
        echo "Demande Gazoil Navette non confirmé par les administrateurs";
    }
	
         

        $this->db->close();
    }
	
public function getDetailDemandeE(){
    $po = $_POST["po"];
	
	
	  $query2 = $this->db->query("SELECT rj,rj1 from demande_engin where po_dem = '".$po."' and (rj= 'oui' or rj1 ='oui') limit 1")->row(); 
	  
	  
	  if (count($query2) >0 ) {
				 
					 
					$query1 = $this->db->query('SELECT * from demande_engin where po_dem ="'.$po.'" order by id_demande')->result_array();
					
					
					 
          $compteur = 0;
		
        foreach ($query1 as $row) {
            # code...
		$compteur1 = 0;
		
		$getOperation = $this->db->query("SELECT * from operation where id_operation = ".$row['operation']." limit 1")->row(); 
		$getFournisseur = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur= ".$row['fournisseur']." limit 1")->row(); 
		
		$compteur1 = $row['litrage']*$row['tour'];
		
            echo "<tr style='border:none; text-align:center;font-size: 13px;font-weight:10px;padding:0px;'>
                  
                   
					 <td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px' >".$getOperation->nom_op."</td>
					
					<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px' >".$row['code_camion']."</td>
					
					<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px' >".$row['immatriculation']."</td>";  
					
					$getArticle = $this->db->query("SELECT * FROM distance_littrage where id_distance = ".$row['destination']."")->row();
					
                    $getClient= $this->db->query("SELECT * FROM clientfrais where id_client = ".$row['client']."")->row();
					
				   echo"  	<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px' >".$getClient->nom."</td>

                            <td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;'>".$getArticle->distance."</td>
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:10px'>".$row['litrage']."</td>
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:10px'>".$row['tour']."</td>
							
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:20px'>".$compteur1."</td>
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:10px'>".$getFournisseur->nom."</td>
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:10px'></td>
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:10px'></td>
							";
                        
                 
                    
                
                    
                  $compteur++;
        } 
					 
					}else{
						
						
        echo "Demande Gazoil Engin non confirmée par les administrateurs";
    }
	
         

        $this->db->close();
    }

	
public function getDetailDemandeNA(){
    $po = $_POST["po"];
	
	
	  $query2 = $this->db->query("SELECT rj,rj1 from demande_navette_autre where po_dem = '".$po."' and (rj= 'oui' or rj1 ='oui') limit 1")->row(); 
	  
	  
	  if (count($query2) >0 ) {
				 
					 
					$query1 = $this->db->query('SELECT * from demande_navette_autre where po_dem ="'.$po.'" order by id_demande')->result_array();
					
					
					 
          $compteur = 0;
		
        foreach ($query1 as $row) {
            # code...
		$compteur1 = 0;
		
		$getOperation = $this->db->query("SELECT * from operation where id_operation = ".$row['operation']." limit 1")->row(); 
		$getFournisseur = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur= ".$row['fournisseur']." limit 1")->row(); 
		
		$compteur1 = $row['litrage']*$row['tour'];
		
            echo "<tr style='border:none; text-align:center;font-size: 13px;font-weight:10px;padding:0px;'>
                  
                   
					 <td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px' >".$getOperation->nom_op."</td>
					
					<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px' >".$row['code_camion']."</td>
					
					<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px' >".$row['immatriculation']."</td>";  
					
					$getArticle = $this->db->query("SELECT * FROM distance_littrage where id_distance = ".$row['destination']."")->row();
					
                    $getClient= $this->db->query("SELECT * FROM clientfrais where id_client = ".$row['client']."")->row();
					
				   echo"  	<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px' >".$getClient->nom."</td>

                            <td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;'>".$getArticle->distance."</td>
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:10px'>".$row['litrage']."</td>
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:10px'>".$row['tour']."</td>
							
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:20px'>".$compteur1."</td>
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:10px'>".$getFournisseur->nom."</td>
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:10px'></td>
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:10px'></td>
							";
                        
                 
                    
                
                    
                  $compteur++;
        } 
					 
					}else{
						
						
        echo "Frais de route non confirmé par les administrateurs";
    }
	
         

        $this->db->close();
    }




public function getDetailDemandeG(){
    $po = $_POST["po"];
	
	
	  $query2 = $this->db->query("SELECT rj,rj1 from demande_frais where po_dem = '".$po."' and (rj= 'oui' or rj1 ='oui') limit 1")->row(); 
	  
	  
	  if (count($query2) >0 ) {
				 
				
					 
					$query1 = $this->db->query('SELECT * from demande_frais where po_dem ="'.$po.'" order by date_dem desc')->result_array();
				
         $compteur = 0;
		 $compteur1 = 0;
        foreach ($query1 as $row) {
            # code...
				
			$getStockCamion1 = $this->db->query("SELECT * from demande_frais where code_camion = '".$row["code_camion"]."' ORDER BY id_demande DESC LIMIT 1,1")->row();  

			$compteurA = $row['litrage']*$row['tour'];
			
			 if (count($getStockCamion1) >0) {
			
			$compteur1 = $row['complement'] + $compteurA - $getStockCamion1->stock;
			
			 } else {
				 
				 $compteur1 = $row['complement'] + $compteurA;
				 
			 }
			

            echo "<tr style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px'>
                    

                    <td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px' >".$row['bl']."</td>
					
					<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px' >".$row['code_camion']."</td>
					
					<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px' >".$row['immatriculation']."</td>";  
					
					$getArticle = $this->db->query("SELECT * FROM distance_littrage where id_distance = ".$row['destination']."")->row();
					
                    $getClient= $this->db->query("SELECT * FROM fournisseur_gazoil where id_fournisseur = ".$row['fournisseur']."")->row();
					
				   echo"  	

                            <td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px'>".$getArticle->distance."</td>
							
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px' >".$getClient->nom."</td>
							
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px'>".$row['litrage']."</td>
				
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px'>".$row['tour']."</td>
							
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px'>".$row['complement']."</td>";
							
							if (count($getStockCamion1) >0) {
			
								echo "<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px'>".$getStockCamion1->stock."</td>";
						
							} else {
				 
						       echo "<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px'>0</td>";
						
							}
			
							
							
							echo" <td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px'>".$compteur1."</td>
							
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px'>".$row['tonnage']."</td>
							
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px'>".$row['detail']."</td>
							
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px'></td>
							
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px'></td>
							";
                    
                    
                  $compteur++;
        } 
					 
					}else{
						
						
        echo "Frais demande gazoil non confirmé par les administrateurs";
    }
	
         

        $this->db->close();
    }




public function getKilometrageGasoilParImmatriculation(){
	
	$immatriculation = $_POST["immatriculation"];

    $query1 = $this->db->query("SELECT * from tracteur where immatriculation='".$immatriculation."'")->row();
    $query2 = $this->db->query("SELECT * from camion_benne where immatriculation='".$immatriculation."'")->row();
    $query3 = $this->db->query("SELECT * from remorque where immatriculation='".$immatriculation."'")->row();
    $query4 = $this->db->query("SELECT * from engin where immatriculation='".$immatriculation."'")->row();

    if (count($query1)>0) {
            # code...
           return $this->getKilometrageGasoilParCode($query1->code);
        }elseif (count($query2) > 0) {
            # code...
           return $this->getKilometrageGasoilParCode($query2->code);
        }
        elseif (count($query3) >0) {
            $query5 = $this->db->query("SELECT * from tracteur where id_remorque='".$query3->id_remorque."'")->row();
            if (count($query5)>0) {
                # code...
                return $this->getKilometrageGasoilParCode($query5->code);
            }else{
                return "0";
            }
          
        }
        elseif (count($query4) >0) {
        
          return $this->getKilometrageGasoilParCode($query4->code);
        }else{
            return "Aucun";
        }

        $this->db->close();
}

public function getKilometrageGasoilParCode($code){
    $query = $this->db->query("SELECT max(kilometrage) as kilometrage from gazoil where code_camion='".$code."'")->row();

    if (count($query)>0) {
        # code...
        return $query->kilometrage;
    }else{
        return "0";
    }
    $this->db->close();
}

	
public function leSelectTypepneu(){
        $query = $this->db->query("SELECT  * from type_pneu order by nom_type asc")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_type_pneu"]."'>".$row["nom_type"]."</option>";
            }
        }else{

        }

        $this->db->close();
    }


public function getHuileMoteur(){
    $getHuileMoteur = $this->db->query("select * from type_huile where type_huile = 'moteur'")->result_array();
    if (count($getHuileMoteur)  >0) {
         echo "<option></option> ";
        foreach ($getHuileMoteur as $row1) {
            # code...
             echo "<option value=".$row1['id_type'].">".$row1['huile']."</option>";
        }
    }
    $this->db->close();
}

public function getHuileHydrolique(){
   $getHuileMoteur = $this->db->query("select * from type_huile where type_huile = 'hydrolique'")->result_array();
    if (count($getHuileMoteur)  >0) {
       echo "<option></option> ";
        foreach ($getHuileMoteur as $row1) {
            # code...
             echo "<option value=".$row1['id_type'].">".$row1['huile']."</option>";
        }
    }

    $this->db->close();
}

public function getGraisseVidange(){
   $getHuileMoteur = $this->db->query("select * from type_huile where type_huile = 'Graissage'")->result_array();
    if (count($getHuileMoteur)  >0) {
       echo "<option></option> ";
        foreach ($getHuileMoteur as $row1) {
            # code...
             echo "<option value=".$row1['id_type'].">".$row1['huile']."</option>";
        }
    }

    $this->db->close();
}

public function getHuileBoite(){
     $getHuileMoteur = $this->db->query("select * from type_huile where type_huile = 'boite'")->result_array();
    if (count($getHuileMoteur)  >0) {
         echo "<option></option> ";
        foreach ($getHuileMoteur as $row1) {
            # code...
             echo "<option value=".$row1['id_type'].">".$row1['huile']."</option>";
        }
    }
    $this->db->close();
}

public function selectAllVidangeHydrolique(){
    if (isset($_POST["date_debut"]) && isset($_POST["date_fin"])) {
        # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        if (!empty($date_fin) && !empty($date_debut)) {
            # code...
           $query1 = $this->db->query('SELECT * from vidangehydrolique where date_vidange between "'.$date_debut.'" and "'.$date_fin.'" order by date_vidange ')->result_array(); 
        }else{
            $query1 = $this->db->query('SELECT * from vidangehydrolique order by date_vidange desc limit 900')->result_array();
        }
    }else{
      $query1 = $this->db->query('SELECT * from vidangehydrolique order by date_vidange desc limit 1000')->result_array();
    }
         $compteur = 0;
		 $compteur1 = 0;
		 $compteur2 = 0;
		 
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                     $getOperation = $this->db->query("SELECT * FROM operation where id_operation = ".$row['id_operation']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_op']."</td>
                            <td>".$row['code_camion']."</td>";
            				
							$getFournisseurArticle = $this->db->query("SELECT * from fournisseur_article where id_fournisseur = ".$row['id_fournisseur']." limit 1")->row();
                             if (count($getFournisseurArticle) >0) {
                                 # code...
                                 echo " <td>".$getFournisseurArticle->nom." </td>";
                             }else{
                                echo "<td></td>";
                             }
                        }
                    }

                    $getOperation = $this->db->query("SELECT * FROM type_huile where id_type = ".$row['id_type_huile']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
							$compteur1 =$compteur1 + $row["qtite"];
							
                            $prixTotal = $row["pu"]*$row["qtite"];
							
							$compteur2=$compteur2+ $prixTotal;
                            echo"<td>".$tab['huile']."</td>
							
							
                            <td>".number_format($row['pu'],0,',',' ')." </td>
                            <td>".$row['qtite']." L</td>
                            <td>".number_format($prixTotal,0,',',' ')." </td>";
                        }
                    }
                    
                    echo"
                     <td>".$row['date_vidange']."</td>
                    <td>";
            if($this->session->userdata('vidange_modification')=='true'){
                    echo"<button type='button'  onclick=\"infoVidangeHydrolique('".$row['id_type_huile']." ','".$row['commentaire']."','".$row['date_vidange']."','".$row['code_camion']."','".$row['id_operation']."',".$row['id_vidange'].",'".$row['qtite']."','".$row['pu']."','".$row['id_fournisseur']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }

            if($this->session->userdata('vidange_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='vidangehydrolique' identifiant='".$row['id_vidange']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_vidange\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
              }
                  $compteur++;
        }
		
		echo "<tr>
        <td style='color:red;font-size: 20px;text-align:center; border: 2px solid black; font-weight: bold;'>TOTAUX</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
		<td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        
       <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteur1,0,',',' ')."</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteur2,0,',',' ')."</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        

	</tr>";

        $this->db->close();
    }

public function addVidangeHydrolique(){
    $pu = intval(preg_replace('/\s/','', $_POST["PU"])); 
    $commentaire = $_POST["commentaire"];
    $date = $_POST["date"];
    $codeCamion = $_POST["codeCamion"];
    $huile = $_POST["huile"];
    $id_operation = $_POST["id_operation"];
	$id_fournisseur = $_POST["id_fournisseur"];
    $status = $_POST["status"];
    $id_frais_divers = $_POST["id_frais_divers"];
        $qtite = $_POST["qtite"];

    $montant = $qtite*$pu;
    $nom_table = "vidangehydrolique";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté une vidange hydrolique sur le camion de code ".$codeCamion." avec l'huile ".$huile." d'un montant de ".$montant." FCFA, pour l'opération ".$this->getOperation($id_operation)." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié une vidange hydrolique sur le camion de code ".$codeCamion." avec l'huile ".$huile." d'un montant de ".$montant." FCFA, pour l'opération ".$this->getOperation($id_operation)." le ".$date_notif." à ".$heure;

    if ($status == 'insert') {
        # code...
    $verifHuile = $this->db->query("SELECT * FROM vidangehydrolique where id_type_huile = ".$huile."")->result_array();

    if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
            $insertion = $this->db->query("INSERT INTO vidangehydrolique value ('',".$id_operation.",'".$codeCamion."',CAST('". $date."' AS DATE),".$huile.",'".$commentaire."',".$qtite.",".$pu.",".$id_fournisseur.")");
        if ($insertion == true ) {
            # code...
            echo "Vidange enregistrée";
            $this->notificationAjout($nom_table,addslashes($message));
        }else{
            echo "Erreur lors de l'insertion";
        } 
    
      }
    }elseif ($status == 'update') {
     
                # code...
        if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
                 $update = $this->db->query("UPDATE vidangehydrolique set  id_operation =".$id_operation.",code_camion='".$codeCamion."',date_vidange = CAST('". $date."' AS DATE),id_type_huile = ".$huile.",commentaire = '".$commentaire."',qtite=".$qtite.",pu=".$pu.",id_fournisseur=".$id_fournisseur." where id_vidange=".$id_frais_divers."");
                if ($update == true ) {
                    # code...
                    echo "Vidange modifiée";
                    $this->notificationAjout($nom_table,addslashes($message2));
                }else{
                    echo "Erreur lors de la modification";
                }
            
      }
      
    }else{
        echo "Erreur veuillez contacter l'administrateur";
    }
 
 $this->db->close();
}

public function addVidangeGraisse(){
    $pu = intval(preg_replace('/\s/','', $_POST["PU"])); 
    $commentaire = $_POST["commentaire"];
    $date = $_POST["date"];
    $codeCamion = $_POST["codeCamion"];
    $huile = $_POST["huile"];
    $id_operation = $_POST["id_operation"];
	$id_fournisseur = $_POST["id_fournisseur"];
    $status = $_POST["status"];
    $id_frais_divers = $_POST["id_frais_divers"];
        $qtite = $_POST["qtite"];

    $montant = $qtite*$pu;
    $nom_table = "vidangegraisse";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté une vidange graisse sur le camion de code ".$codeCamion." avec l'huile ".$huile." d'un montant de ".$montant." FCFA, pour l'opération ".$this->getOperation($id_operation)." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié une vidange graisse sur le camion de code ".$codeCamion." avec l'huile ".$huile." d'un montant de ".$montant." FCFA, pour l'opération ".$this->getOperation($id_operation)." le ".$date_notif." à ".$heure;

    if ($status == 'insert') {
        # code...
    $verifHuile = $this->db->query("SELECT * FROM vidangegraisse where id_type_huile = ".$huile."")->result_array();

    if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
            $insertion = $this->db->query("INSERT INTO vidangegraisse value ('',".$id_operation.",'".$codeCamion."',CAST('". $date."' AS DATE),".$huile.",'".$commentaire."',".$qtite.",".$pu.",".$id_fournisseur.")");
        if ($insertion == true ) {
            # code...
            echo "Vidange enregistrée";
            $this->notificationAjout($nom_table,addslashes($message));
        }else{
            echo "Erreur lors de l'insertion";
        } 
    
      }
    }elseif ($status == 'update') {
     
                # code...
        if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
                 $update = $this->db->query("UPDATE vidangegraisse set  id_operation =".$id_operation.",code_camion='".$codeCamion."',date_vidange = CAST('". $date."' AS DATE),id_type_huile = ".$huile.",commentaire = '".$commentaire."',qtite=".$qtite.",pu=".$pu.",id_fournisseur=".$id_fournisseur." where id_vidange=".$id_frais_divers."");
                if ($update == true ) {
                    # code...
                    echo "Vidange modifiée";
                    $this->notificationAjout($nom_table,addslashes($message2));
                }else{
                    echo "Erreur lors de la modification";
                }
            
      }
      
    }else{
        echo "Erreur veuillez contacter l'administrateur";
    }
 
 $this->db->close();
}



public function selectAllVidangeBoite(){
        if (isset($_POST["date_debut"]) && isset($_POST["date_fin"])) {
        # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        if (!empty($date_fin) && !empty($date_debut)) {
            # code...
           $query1 = $this->db->query('SELECT * from vidangeboite where date_vidange between "'.$date_debut.'" and "'.$date_fin.'" order by date_vidange ')->result_array(); 
        }else{
            $query1 = $this->db->query('SELECT * from vidangeboite order by date_vidange desc limit 900')->result_array();
        }
    }else{
      $query1 = $this->db->query('SELECT * from vidangeboite order by date_vidange desc limit 1000')->result_array();
    }

         $compteur = 0;
		     $compteur1 = 0;
			     $compteur2 = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                     $getOperation = $this->db->query("SELECT * FROM operation where id_operation = ".$row['id_operation']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_op']."</td>
                            <td>".$row['code_camion']."</td> ";
                  			
							$getFournisseurArticle = $this->db->query("SELECT * from fournisseur_article where id_fournisseur = ".$row['id_fournisseur']." limit 1")->row();
                             if (count($getFournisseurArticle) >0) {
                                 # code...
                                 echo " <td>".$getFournisseurArticle->nom." </td>";
                             }else{
                                echo "<td></td>";
                             }
                        }
                    }

                    $getOperation = $this->db->query("SELECT * FROM type_huile where id_type = ".$row['id_type_huile']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                           $compteur1 =$compteur1 + $row["qtite"];
							
                            $prixTotal = $row["pu"]*$row["qtite"];
							
							$compteur2=$compteur2+ $prixTotal;
                           // $prixTotal = $row["pu"]*$row["qtite"];
                            echo"<td>".$tab['huile']."</td>
                            <td>".number_format($row['pu'],0,',',' ')." </td>
                            <td>".$row['qtite']." L</td>
                            <td>".number_format($prixTotal,0,',',' ')." </td>";
                        }
                    }
                    
                    echo"
                     <td>".$row['date_vidange']."</td>
                    <td>";

            if($this->session->userdata('vidange_modification')=='true'){
                    echo"<button type='button' onclick=\"infoVidangeBoite('".$row['id_type_huile']." ','".$row['commentaire']."','".$row['date_vidange']."','".$row['code_camion']."','".$row['id_operation']."',".$row['id_vidange'].",'".$row['qtite']."','".$row['pu']."','".$row['id_fournisseur']."')\"class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }

            if($this->session->userdata('vidange_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='vidangeboite' identifiant='".$row['id_vidange']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_vidange\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
        }
		
		echo "<tr>
        <td style='color:red;font-size: 20px;text-align:center; border: 2px solid black; font-weight: bold;'>TOTAUX</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
		<td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        
       <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteur1,0,',',' ')."</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteur2,0,',',' ')."</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        

	</tr>";

        $this->db->close();
    }
	
	
	public function selectAllVidangeGraisse(){
    if (isset($_POST["date_debut"]) && isset($_POST["date_fin"])) {
        # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        if (!empty($date_fin) && !empty($date_debut)) {
            # code...
           $query1 = $this->db->query('SELECT * from vidangegraisse where date_vidange between "'.$date_debut.'" and "'.$date_fin.'" order by date_vidange ')->result_array(); 
        }else{
            $query1 = $this->db->query('SELECT * from vidangegraisse order by date_vidange desc limit 900')->result_array();
        }
    }else{
      $query1 = $this->db->query('SELECT * from vidangegraisse order by date_vidange desc limit 1000')->result_array();
    }
         $compteur = 0;
		 $compteur1 = 0;
		 $compteur2 = 0;
		 
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                     $getOperation = $this->db->query("SELECT * FROM operation where id_operation = ".$row['id_operation']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_op']."</td>
                            <td>".$row['code_camion']."</td>";
            				
							$getFournisseurArticle = $this->db->query("SELECT * from fournisseur_article where id_fournisseur = ".$row['id_fournisseur']." limit 1")->row();
                             if (count($getFournisseurArticle) >0) {
                                 # code...
                                 echo " <td>".$getFournisseurArticle->nom." </td>";
                             }else{
                                echo "<td></td>";
                             }
                        }
                    }

                    $getOperation = $this->db->query("SELECT * FROM type_huile where id_type = ".$row['id_type_huile']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
							$compteur1 =$compteur1 + $row["qtite"];
							
                            $prixTotal = $row["pu"]*$row["qtite"];
							
							$compteur2=$compteur2+ $prixTotal;
                            echo"<td>".$tab['huile']."</td>
							
							
                            <td>".number_format($row['pu'],0,',',' ')." </td>
                            <td>".$row['qtite']."</td>
                            <td>".number_format($prixTotal,0,',',' ')." </td>";
                        }
                    }
                    
                    echo"
                     <td>".$row['date_vidange']."</td>
                    <td>";
            if($this->session->userdata('vidange_modification')=='true'){
                    echo"<button type='button'  onclick=\"infoVidangeGraisse('".$row['id_type_huile']." ','".$row['commentaire']."','".$row['date_vidange']."','".$row['code_camion']."','".$row['id_operation']."',".$row['id_vidange'].",'".$row['qtite']."','".$row['pu']."','".$row['id_fournisseur']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }

            if($this->session->userdata('vidange_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='vidangegraisse' identifiant='".$row['id_vidange']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_vidange\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
              }
                  $compteur++;
        }
		
		echo "<tr>
        <td style='color:red;font-size: 20px;text-align:center; border: 2px solid black; font-weight: bold;'>TOTAUX</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
		<td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        
       <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteur1,0,',',' ')."</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteur2,0,',',' ')."</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        

	</tr>";

        $this->db->close();
    }


public function addVidangeBoite(){
    $pu = intval(preg_replace('/\s/','', $_POST["PU"])); 
    $commentaire = $_POST["commentaire"];
    $date = $_POST["date"];
    $codeCamion = $_POST["codeCamion"];
    $huile = $_POST["huile"];
    $id_operation = $_POST["id_operation"];
	$id_fournisseur = $_POST["id_fournisseur"];
    $status = $_POST["status"];
    $id_frais_divers = $_POST["id_frais_divers"];
    $qtite = $_POST["qtite"];

    $montant = $qtite*$pu;
    $nom_table = "vidangeboite";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté une vidange boite sur le camion de code ".$codeCamion." avec l'huile ".$huile." d'un montant de ".$montant." FCFA, pour l'opération ".$this->getOperation($id_operation)." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié une vidange boite sur le camion de code ".$codeCamion." avec l'huile ".$huile." d'un montant de ".$montant." FCFA, pour l'opération ".$this->getOperation($id_operation)." le ".$date_notif." à ".$heure;

    if ($status == 'insert') {
        # code...
    $verifHuile = $this->db->query("SELECT * FROM vidangeboite where id_type_huile = ".$huile."")->result_array();
    if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
            $insertion = $this->db->query("INSERT INTO vidangeboite value ('',".$id_operation.",'".$codeCamion."',CAST('". $date."' AS DATE),'".$huile."','".$commentaire."',".$qtite.",".$pu.",".$id_fournisseur.")");
    if ($insertion == true ) {
        # code...
        echo "Vidange enregistrée";
        $this->notificationAjout($nom_table,addslashes($message));
    }else{
        echo "Erreur lors de l'insertion";
    } 
    }
      
    }elseif ($status == 'update') {
        # code...

    // $verifHuile = $this->db->query("SELECT * FROM vidangeboite where id_type_huile = ".$huile."")->result_array();

  if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
            
        }else{

        # code...
        // foreach ($verifHuile as $tab) {
           
                # code...
                 $update = $this->db->query("UPDATE vidangeboite set  id_operation =".$id_operation.",code_camion='".$codeCamion."',date_vidange = CAST('". $date."' AS DATE),id_type_huile = ".$huile.",commentaire = '".$commentaire."',qtite=".$qtite.",pu=".$pu.", id_fournisseur=".$id_fournisseur." where id_vidange=".$id_frais_divers."");
                if ($update == true ){
                    # code...
                    echo "Vidange modifiée";
                    $this->notificationAjout($nom_table,addslashes($message2));
                }else{
                    echo "Erreur lors de la modification";
                }
           
        // }
       
   }
          
    }else{
        echo "Erreur veuillez contacter l'administrateur";
    }
    
    $this->db->close();
}


  public function addTypeHuile(){
        $huile = $_POST["huile"];
        $type_huile = $_POST["type_huile"];
        $PU = preg_replace('/\s/','', $_POST["PU"]);
        $status = $_POST["status"];

        $nom_table = "type_huile";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté une huile de type  ".$type_huile." dont le nom est ".$huile." avec pour prix unitaire ".$PU." FCFA, le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié une huile de type  ".$type_huile." dont le nom est ".$huile." avec pour prix unitaire ".$PU." FCFA, le ".$date_notif." à ".$heure;

        if ($status =="insert") {
            # code...

                $requete = $this->db->query("SELECT * from type_huile where huile ='".$huile."' and type_huile ='".$type_huile."'")->result_array();
                if (count($requete)>0) {
                    # code...
                    echo "Erreur cette huile existe déjà pour ce type veuiller changer";
                }else{
                    $query1 = $this->db->query("insert into type_huile value('','". $type_huile. "','".$huile."',".$PU.")");
                            if($query1 == true){
                                echo "Insertion parfaite de l'huile";
                                $this->notificationAjout($nom_table,addslashes($message));
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                }
        }elseif ($status == "update") {
            # code...
            $id_client =$_POST["id_client"];
                $requete = $this->db->query("SELECT * from type_huile where huile ='".$huile."' and type_huile ='".$type_huile."'")->result_array();
                if (count($requete)>0) {
                    # code...
                   foreach ($requete as $row) {
                       # code...
                        if ($row["id_type"] == $id_client) {
                            # code...
                            $query1 = $this->db->query("UPDATE type_huile set huile='".$huile."', type_huile='".$type_huile."', PU=".$PU." where id_type=".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du l'huile";
                                $this->notificationAjout($nom_table,addslashes($message2));
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                        }else{
                            echo "Erreur cette huile existe déjà pour ce type veuiller changer";
                        }
                   }
                }else{
                    $query1 = $this->db->query("UPDATE type_huile set huile='".$huile."', type_huile='".$type_huile."', PU=".$PU." where id_type=".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du l'huile";
                                $this->notificationAjout($nom_table,addslashes($message2));
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                }
        }else{
            echo "Erreur contactez l'administrateur".$status ;
        }
        $this->db->close();
    }

    public function selectAllTypeHuile(){
              $query1 = $this->db->get_where('type_huile')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['type_huile']."
                    </td>
                    <td>".$row['huile']."</td>
                    <td> ".number_format($row['PU'],0,',',' ')." </td>
                    <td>";

            if($this->session->userdata('vidange_modification')=='true'){
                    echo"<button type='button' onclick=\"infosTypeHuile('".$row['id_type']."','".$row['type_huile']."','".$row['huile']."','".$row['PU']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }
            if($this->session->userdata('vidange_suppression')=='true'){
                echo"
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='type_huile' identifiant='".$row['id_type']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_type\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
              }
                  $compteur++;
        }
		
		
		

        $this->db->close();
    }


    public function getPrixUnitaireHuile(){
        $id_type = $_POST["id_type"];
        $query = $this->db->query("SELECT * from type_huile where id_type = ".$id_type." limit 1")->row();

        if (count($query) > 0) {
            # code...
            echo $query->PU;
        }else{
            echo "0";
        }
    $this->db->close();
   }
   
   
       public function getPrixUnitaireGraisse(){
        $id_type = $_POST["id_type"];
        $query = $this->db->query("SELECT * from type_huile where id_type = ".$id_type." limit 1")->row();

        if (count($query) > 0) {
            # code...
            echo $query->PU;
        }else{
            echo "0";
        }
    $this->db->close();
   }




  public function addDepenseSalaireChauffeur(){
    $montantNetChauffeur = preg_replace('/\s/','', $_POST["montantNetChauffeur"]);
    $montantNetAssistant = preg_replace('/\s/','', $_POST["montantNetAssistant"]);

    $date = $_POST["date"];
    $codeCamion = $_POST["camion"];
    $chauffeur = $_POST["chauffeur"];
    $assistant = $_POST["assistant"];
    $status = $_POST["status"];

   
    $nom_table = "depenseSalaireChauffeur";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté une dépense salariale sur le camion de code ".$codeCamion." avec chauffeur ".$montantNetChauffeur." et assistant ".$montantNetAssistant." d'un montant de ".$montant." FCFA, pour le compte de l'opération ".$this->getOperation($id_operation)." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié une dépense salariale sur le camion de code ".$codeCamion." avec chauffeur ".$montantNetChauffeur." et assistant ".$montantNetAssistant." d'un montant de ".$montant." FCFA, pour le compte de l'opération ".$this->getOperation($id_operation)." le ".$date_notif." à ".$heure;


    $id_prime = $_POST["id_prime"];
    if ($status == 'insert') {
        # code...
        
           $insertion = $this->db->query("INSERT INTO depenseSalaireChauffeur value ('',".$chauffeur.",'".$codeCamion."',CAST('". $date."' AS DATE),".$montantNetChauffeur.",".$montantNetAssistant.",'".$assistant."')");
        if ($insertion == true ) {
            # code...
            echo "Enregistrement de la depense salaire";
            $this->notificationAjout($nom_table,addslashes($message));
        }else{
            echo "Erreur lors de l'insertion";
        }
    
    }elseif ($status == 'update') {
        # code...
   
           $update = $this->db->query("UPDATE depenseSalaireChauffeur set  id_chauffeur =".$chauffeur.",code_camion='".$codeCamion."',date_depense = CAST('". $date."' AS DATE),montantNetChauffeur = ".$montantNetChauffeur.",montantNetAssistant = ".$montantNetAssistant.",assistant = '".$assistant."' where id_depense=".$id_prime."");
        if ($update == true ) {
            # code...
            echo "Modification de la depense salaire";
            $this->notificationAjout($nom_table,addslashes($message2));
        }else{
            echo "Erreur lors de la modification";
        }

    }else{
        echo "Erreur veuillez contacter l'administrateur";
    }
    
    $this->db->close();
 }

public function getNomChauffeur($id_chauffeur){

        $getChauffeur = $this->db->query("SELECT * from chauffeur where id_chauffeur =".$id_chauffeur."")->row();

        if (count($getChauffeur)>0) {
            # code...
            return $getChauffeur->nom;
        }else{
            return "Aucun";
        }

        $this->db->close();
    }

 public function selectAllDepenseSalaireChauffeur(){
         $query1 = $this->db->query('SELECT * from depenseSalaireChauffeur order by date_depense desc')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>
                    <td> ".$this->getNomChauffeur($row['id_chauffeur'])."</td>
                    <td> ".$row['assistant']."</td>
                    <td> ".$row['code_camion']."</td>
                    <td> ".$row['date_depense']."</td>
                    <td>".number_format($row['montantNetChauffeur'],0,',',' ')."</td>
                    <td>".number_format($row['montantNetAssistant'],0,',',' ')."</td>
                    <td>".number_format($row['montantNetAssistant']+$row['montantNetChauffeur'],0,',',' ')."</td>
                    
                    <td>";
                if($this->session->userdata('depense_modification')=='true'){
                    echo"<button type='button'  onclick=\"infoDepenseChauffeur('".$row['id_chauffeur']."','".$row['assistant']."','".$row['code_camion']."','".$row['date_depense']."','".$row['montantNetChauffeur']."','".$row['montantNetAssistant']."',".$row['id_depense'].")\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }

                if($this->session->userdata('depense_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='depenseSalaireChauffeur' identifiant='".$row['id_depense']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_depense\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
        }

        $this->db->close();
    }

public function getAssistantChauffeur(){
    $id_chauffeur = $_POST['id_chauffeur'];
     $query1 = $this->db->query('SELECT * from chauffeur where id_chauffeur='.$id_chauffeur.'')->row();

     if (count($query1)>0) {
         # code...
        echo $query1->nom_ass;
     }else{
        echo "Aucun";
     }

    $this->db->close();
}

public function getSalaireAssistant(){
    $id_chauffeur = $_POST['id_chauffeur'];
     $query1 = $this->db->query('SELECT * from chauffeur where id_chauffeur='.$id_chauffeur.'')->row();

     if (count($query1)>0) {
         # code...
        echo number_format($query1->salaire_ass,0,',',' ');
     }else{
        echo "Aucun";
     }

    $this->db->close();
}


public function deletePrime($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé la prime d'un montant de ".$getCamion->montant." su le véhicule de code ".$getCamion->code_camion." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."=".$identifiant."");
           if ($suppression == true) {
               # code...
              echo "Suppression effectuée";
              $this->notificationAjout($nom_table,addslashes($message));
           }else{
              echo "Erreur lors de la suppression";
           }
        }else{
            echo "bf";
        }
         

         $this->db->close();
    }

public function deleteFraisRoute($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé le frais de route d'un montant de ".$getCamion->montant." su le véhicule de code ".$getCamion->code_camion." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."=".$identifiant."");
           if ($suppression == true) {
               # code...
              echo "Suppression effectuée";
              $this->notificationAjout($nom_table,addslashes($message));
           }else{
              echo "Erreur lors de la suppression";
           }
        }
         

         $this->db->close();
    }
	
	public function deleteMarque($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé la marque de nom ".$getCamion->marque." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."=".$identifiant."");
           if ($suppression == true) {
               # code...
              echo "Suppression effectuée";
              $this->notificationAjout($nom_table,addslashes($message));
           }else{
              echo "Erreur lors de la suppression";
           }
        }
         

         $this->db->close();
    }
	
	public function deleteTypePneu($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé la marque de nom ".$getCamion->nom_type." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."=".$identifiant."");
           if ($suppression == true) {
               # code...
              echo "Suppression effectuée";
              $this->notificationAjout($nom_table,addslashes($message));
           }else{
              echo "Erreur lors de la suppression";
           }
        }
         

         $this->db->close();
    }


public function deleteFraisDivers($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé le frais divers d'un montant de ".$getCamion->montant." su le véhicule de code ".$getCamion->code_camion." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."=".$identifiant."");
           if ($suppression == true) {
               # code...
              echo "Suppression effectuée";
              $this->notificationAjout($nom_table,addslashes($message));
           }else{
              echo "Erreur lors de la suppression";
           }
        }
         

         $this->db->close();
    }


public function deleteFraisAchat($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé le frais divers d'un montant de ".$getCamion->montant." su le véhicule de code ".$getCamion->code_camion." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."=".$identifiant."");
           if ($suppression == true) {
               # code...
              echo "Suppression effectuée";
              $this->notificationAjout($nom_table,addslashes($message));
           }else{
              echo "Erreur lors de la suppression";
           }
        }
         

         $this->db->close();
    }



public function deleteGasoil($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé la dépense gasoil N° ".$getCamion->numero." su le véhicule de code ".$getCamion->code_camion." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."=".$identifiant."");
           if ($suppression == true) {
               # code...
              echo "Suppression effectuée";
              $this->notificationAjout($nom_table,addslashes($message));
           }else{
              echo "Erreur lors de la suppression";
           }
        }
         

         $this->db->close();
    }
	
	 public function deleteInventaireGazoil($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé l'inventaire de l'article ".$this->getArticle($getCamion->id_article)." de la date du ".$getCamion->date_inv." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."=".$identifiant."");
           if ($suppression == true) {
               # code...
              echo "Suppression effectuée";
              $this->notificationAjout($nom_table,addslashes($message));
           }else{
              echo "Erreur lors de la suppression";
           }
        }
         

         $this->db->close();
    }
	
	
	public function deleteInventaireHuile($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé l'inventaire de l'article ".$this->getArticle($getCamion->id_article)." de la date du ".$getCamion->date_inv." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."=".$identifiant."");
           if ($suppression == true) {
               # code...
              echo "Suppression effectuée";
              $this->notificationAjout($nom_table,addslashes($message));
           }else{
              echo "Erreur lors de la suppression";
           }
        }
         

         $this->db->close();
    }
	
	public function deleteInventairePneu($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé l'inventaire de l'article ".$this->getArticle($getCamion->id_article)." de la date du ".$getCamion->date_inv." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."=".$identifiant."");
           if ($suppression == true) {
               # code...
              echo "Suppression effectuée";
              $this->notificationAjout($nom_table,addslashes($message));
           }else{
              echo "Erreur lors de la suppression";
           }
        }
         

         $this->db->close();
    }


public function deleteTypeHuile($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé le type d'huile ".$getCamion->huile." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."=".$identifiant."");
           if ($suppression == true) {
               # code...
              echo "Suppression effectuée";
              $this->notificationAjout($nom_table,addslashes($message));
           }else{
              echo "Erreur lors de la suppression";
           }
        }
         

         $this->db->close();
    }


public function deleteVidange($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé la vidange moteur  sur le véhicule de code ".$getCamion->code_camion." de la date du ".$getCamion->date_vidange." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."=".$identifiant."");
           if ($suppression == true) {
               # code...
              echo "Suppression effectuée";
              $this->notificationAjout($nom_table,addslashes($message));
           }else{
              echo "Erreur lors de la suppression";
           }
        }
         

         $this->db->close();
    }

public function deleteVidangeBoite($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé la vidange Boite sur le véhicule de code ".$getCamion->code_camion." de la date du ".$getCamion->date_vidange." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."=".$identifiant."");
           if ($suppression == true) {
               # code...
              echo "Suppression effectuée";
              $this->notificationAjout($nom_table,addslashes($message));
           }else{
              echo "Erreur lors de la suppression";
           }
        }
         

         $this->db->close();
    }

public function deleteVidangeHydrolique($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé la vidange Hydrolique  sur le véhicule de code ".$getCamion->code_camion." de la date du ".$getCamion->date_vidange." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."=".$identifiant."");
           if ($suppression == true) {
               # code...
              echo "Suppression effectuée";
              $this->notificationAjout($nom_table,addslashes($message));
           }else{
              echo "Erreur lors de la suppression";
           }
        }
         

         $this->db->close();
    }
	
	public function deleteVidangeGraisse($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé la vidange Hydrolique  sur le véhicule de code ".$getCamion->code_camion." de la date du ".$getCamion->date_vidange." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."=".$identifiant."");
           if ($suppression == true) {
               # code...
              echo "Suppression effectuée";
              $this->notificationAjout($nom_table,addslashes($message));
           }else{
              echo "Erreur lors de la suppression";
           }
        }
         

         $this->db->close();
    }


    public function deleteDepensePneu($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé la dépense pneu Hydrolique  sur le véhicule de code ".$getCamion->code_camion." de la date du ".$getCamion->date_depense." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."=".$identifiant."");
           if ($suppression == true) {
               # code...
              echo "Suppression effectuée";
              $this->notificationAjout($nom_table,addslashes($message));
           }else{
              echo "Erreur lors de la suppression";
           }
        }
         

         $this->db->close();
    }
	
	
	public function getMontantDemandeLitrage($po){
    $query1 = $this->db->query('SELECT * from demande_frais where po_dem = "'.$po.'"')->result_array();
    $total = 0;

    foreach ($query1 as $row) {
        # code...
        $total1 = $row["litrage"]*$row["tour"];
        $total = $total + $total1;
    }
    return $total;

    $this->db->close();
}



	public function getMontantDemandeLitrageNTotal($po){
		
    $query1 = $this->db->query('SELECT * from demande_navette where po_dem = "'.$po.'"')->result_array();
    $total = 0;

    foreach ($query1 as $row) {
        # code...
        $total1 = $row["litrage"]*$row["tour"];
        $total = $total + $total1;
    }
    return $total;

    $this->db->close();
}

	public function getMontantDemandeLitrageETotal($po){
		
    $query1 = $this->db->query('SELECT * from demande_engin where po_dem = "'.$po.'"')->result_array();
    $total = 0;

    foreach ($query1 as $row) {
        # code...
        $total1 = $row["litrage"]*$row["tour"];
        $total = $total + $total1;
    }
    return $total;

    $this->db->close();
}

public function getMontantDemandeLitrageNATotal($po){
		
    $query1 = $this->db->query('SELECT * from demande_navette_autre where po_dem = "'.$po.'"')->result_array();
    $total = 0;

    foreach ($query1 as $row) {
        # code...
        $total1 = $row["litrage"]*$row["tour"];
        $total = $total + $total1;
    }
    return $total;

    $this->db->close();
}

	public function getMontantDemandeComplement($po){
    $query1 = $this->db->query('SELECT * from demande_frais where po_dem = "'.$po.'"')->result_array();
    $total = 0;

    foreach ($query1 as $row) {
        # code...
        $total1 = $row["complement"];
        $total = $total + $total1;
    }
    return $total;

    $this->db->close();
}

	public function getTotalSacsDemande($po){
    $query1 = $this->db->query('SELECT * from demande_frais where po_dem = "'.$po.'"')->result_array();
    $total = 0;

    foreach ($query1 as $row) {
        # code...
        $total1 = $row["tonnage"];
        $total = $total + $total1;
    }
    return $total;

    $this->db->close();
}

public function getMontantDemandeFraisRoute($po){
    $query1 = $this->db->query('SELECT * from demande_frais where po_dem = "'.$po.'"')->result_array();
    $total = 0;

    foreach ($query1 as $row) {
        # code...
        $total1 = $row["frais_route"];
        $total = $total + $total1;
    }
    return $total;

    $this->db->close();
}

public function getMontantDemandeFraisRetour($po){
    $query1 = $this->db->query('SELECT * from demande_frais where po_dem = "'.$po.'"')->result_array();
    $total = 0;

    foreach ($query1 as $row) {
        # code...
        $total1 = $row["frais_retour"];
        $total = $total + $total1;
    }
    return $total;

    $this->db->close();
}

public function getMontantDemandePont($po){
    $query1 = $this->db->query('SELECT * from demande_frais where po_dem = "'.$po.'"')->result_array();
    $total = 0;

    foreach ($query1 as $row) {
        # code...
        $total1 = $row["pont"];
        $total = $total + $total1;
    }
    return $total;

    $this->db->close();
}

public function getSignatureDAF($po){
	
	
    $query1 = $this->db->query("SELECT * from demande_frais where rj = 'oui' and po_dem = '".$po."'")->result_array();
 
    $signature= "";
	
if (count($query1)>0) {
          
		  
	$signature = "<td><img src=http://192.168.1.5/miratransport/assets/image/signatureDAF.png></td>";	
          
        }

return $signature;

    $this->db->close();
}

public function getSignatureDAFN($po){
	
	
    $query1 = $this->db->query("SELECT * from demande_navette where rj = 'oui' and po_dem = '".$po."'")->result_array();
 
    $signature= "";
	
if (count($query1)>0) {
          
		  
	$signature = "<td><img src=http://192.168.1.5/miratransport/assets/image/signatureDAF.png></td>";	
          
        }

return $signature;

    $this->db->close();
}

public function getSignatureDAFE($po){
	
	
    $query1 = $this->db->query("SELECT * from demande_engin where rj = 'oui' and po_dem = '".$po."'")->result_array();
 
    $signature= "";
	
if (count($query1)>0) {
          
		  
	$signature = "<td><img src=http://192.168.1.5/miratransport/assets/image/signatureDAF.png></td>";	
          
        }

return $signature;

    $this->db->close();
}


public function getSignatureDAFNA($po){
	
	
    $query1 = $this->db->query("SELECT * from demande_navette_autre where rj = 'oui' and po_dem = '".$po."'")->result_array();
 
    $signature= "";
	
if (count($query1)>0) {
          
		  
	$signature = "<td><img src=http://192.168.1.5/miratransport/assets/image/signatureDAF.png></td>";	
          
        }

return $signature;

    $this->db->close();
}






public function getSignatureDGT($po){
	
	
    $query1 = $this->db->query("SELECT * from demande_frais where  rj1 = 'oui' and po_dem = '".$po."'")->result_array();
 
    $signature= "";
	
if (count($query1)>0) {
          
		  
	$signature = "<td><img src=http://192.168.1.5/miratransport/assets/image/signatureDGT.png></td>";
          
        }

return $signature;

    $this->db->close();
}


public function getSignatureDGTE($po){
	
	
    $query1 = $this->db->query("SELECT * from demande_engin where  rj1 = 'oui' and po_dem = '".$po."'")->result_array();
 
    $signature= "";
	
if (count($query1)>0) {
          
		  
	$signature = "<td><img src=http://192.168.1.5/miratransport/assets/image/signatureDGT.png></td>";
          
        }

return $signature;

    $this->db->close();
}


public function getSignatureDGTN($po){
	
	
    $query1 = $this->db->query("SELECT * from demande_navette where  rj1 = 'oui' and po_dem = '".$po."'")->result_array();
 
    $signature= "";
	
if (count($query1)>0) {
          
		  
	$signature = "<td><img src=http://192.168.1.5/miratransport/assets/image/signatureDGT.png></td>";
          
        }

return $signature;

    $this->db->close();
}


public function getSignatureDGTNA($po){
	
	
    $query1 = $this->db->query("SELECT * from demande_navette_autre where  rj1 = 'oui' and po_dem = '".$po."'")->result_array();
 
    $signature= "";
	
if (count($query1)>0) {
          
		  
	$signature = "<td><img src=http://192.168.1.5/miratransport/assets/image/signatureDGT.png></td>";
          
        }

return $signature;

    $this->db->close();
}





public function getNomOperation($po){
	
	
    $query1 = $this->db->query("SELECT * from operation where  id_operation = ".$po."")->row();
 
    $signature= "";
	
if (count($query1)>0) {
          
		  
	$operation = $query1->nom_op;
          
        }

return $operation;

    $this->db->close();
}


public function getMontantTotal($po){
    

    
	 $query1 = $this->db->query('SELECT * from demande_frais where po_dem = "'.$po.'"')->result_array();
    
	$totalFR = 0;

    foreach ($query1 as $row) {
        # code...
        $total1 = $row["frais_route"];
        $totalFR = $totalFR + $total1;
    }
	
	 $query1 = $this->db->query('SELECT * from demande_frais where po_dem = "'.$po.'"')->result_array();
    $totalRT = 0;

    foreach ($query1 as $row) {
        # code...
        $total1 = $row["frais_retour"];
        $totalRT = $totalRT + $total1;
    }
	
	
	
	$query1 = $this->db->query('SELECT * from demande_frais where po_dem = "'.$po.'"')->result_array();
    $totalP = 0;

    foreach ($query1 as $row) {
        # code...
        $total1 = $row["pont"];
        $totalP = $totalP + $total1;
    }
    return $totalP + $totalRT + $totalFR;

    $this->db->close();
}


public function getCompteurTotal($po){
    

    
	 $query1 = $this->db->query('SELECT count(*) as compteur from demande_frais where po_dem = "'.$po.'"')->row();
    
	$totalCP = 0;
	
	 if (count($query1)>0) {
                    # code...
					
					$totalCP = $query1->compteur;
	
                   
				 }
				 
    return $totalCP ;

    $this->db->close();
}

public function getCompteurTotalN($po){
    

    
	 $query1 = $this->db->query('SELECT count(*) as compteur from demande_navette where po_dem = "'.$po.'"')->row();
    
	$totalCP = 0;
	
	 if (count($query1)>0) {
                    # code...
					
					$totalCP = $query1->compteur;
	
                   
				 }
				 
    return $totalCP ;

    $this->db->close();
}

public function getCompteurTotalNA($po){
    

    
	 $query1 = $this->db->query('SELECT count(*) as compteur from demande_navette_autre where po_dem = "'.$po.'"')->row();
    
	$totalCP = 0;
	
	 if (count($query1)>0) {
                    # code...
					
					$totalCP = $query1->compteur;
	
                   
				 }
				 
    return $totalCP ;

    $this->db->close();
}



public function getMontantTotalComplement($po){
    
  
  
	$query = $this->db->query('SELECT * from demande_frais where po_dem = "'.$po.'"')->result_array();
    
	$totalLT = 0;

    foreach ($query as $row) {
        # code...
        $total1 = $row["litrage"]*$row["tour"];
        $totalLT = $totalLT + $total1;
    }
	
	$query1 = $this->db->query('SELECT * from demande_frais where po_dem = "'.$po.'"')->result_array();
    $totalCP = 0;

    foreach ($query1 as $row1) {
        # code...
        $total1 = $row1["complement"];
        $totalCP = $totalCP + $total1;
    }
	
	
    $totalST = 0;
	
	$query2 = $this->db->query('SELECT * from demande_frais where po_dem = "'.$po.'"')->result_array();
	
	foreach ($query2 as $row) {
	
	
	$getStockCamion1 = $this->db->query("SELECT * from demande_frais where code_camion = '".$row["code_camion"]."' ORDER BY id_demande DESC LIMIT 1,1")->row();  


			if (count($getStockCamion1) >0) {
			
					$total1 = $getStockCamion1->stock;
							
							} else {
				 
				    $total1 = 0;		
					
							}	
		
       
		
        $totalST = $totalST + $total1;
    }
	
	 return $totalLT + $totalCP - $totalST;

    $this->db->close();
}

public function getMontantTotalStock($po){
	
	 $totalST = 0;
	
	$query2 = $this->db->query('SELECT * from demande_frais where po_dem = "'.$po.'"')->result_array();
	
	foreach ($query2 as $row) {
	
	
	$getStockCamion1 = $this->db->query("SELECT * from demande_frais where code_camion = '".$row["code_camion"]."' ORDER BY id_demande DESC LIMIT 1,1")->row();  


			if (count($getStockCamion1) >0) {
			
					$total1 = $getStockCamion1->stock;
							
							} else {
				 
				    $total1 = 0;		
					
							}	
		
       
		
        $totalST = $totalST + $total1;
    }
	
		 return $totalST;

    $this->db->close();
}
	
	
	


public function leSelectClient(){
        $query = $this->db->query("SELECT * from client order by nom")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_client"]."'>".$row["nom"]."</option>";
            }
        }else{

        }
        $this->db->close();
    }
	
public function leSelectClientFrais(){
        $query = $this->db->query("SELECT * from clientfrais order by nom")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_client"]."'>".$row["nom"]."</option>";
            }
        }else{

        }
        $this->db->close();
    }

public function leSelectClientFraisNavette(){
        $query = $this->db->query("SELECT * from clientfrais order by nom")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_client"]."'>".$row["nom"]."</option>";
            }
        }else{

        }
        $this->db->close();
    }	
	
	
  public function selectAllClient(){
              $query1 = $this->db->query('SELECT * from clientfrais order by nom asc')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['nom']."
                    </td>
                    <td>".$row['adresse']."</td>
                    <td> ".$row['telephone']."</td>
                   
					 <td> ".$row['date_initial']."</td>
                    <td> ".$row['solde_initial']."</td>
                    <td>";

                 if($this->session->userdata('client_modification')=='true'){
                   echo"<button type='button' onclick=\"infosClient('".$row['id_client']."','".$row['nom']."','".$row['adresse']."','".$row['telephone']."','".$row['date_initial']."','".$row['solde_initial']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }

                if($this->session->userdata('client_suppression')=='true'){
              echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='clientfrais' identifiant='".$row['id_client']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_client\");'><i class='far fa-trash-alt'></i></button>
                 </td>";
              echo "    </tr>

                  ";}
                  $compteur++;
        }
        $this->db->close();
    }
	
	
	public function addClient(){
        $nom = $_POST["nom"];
        $telephone = $_POST["telephone"];
        $adresse = $_POST["adresse"];
        $status = $_POST["status"];
        $nui = $_POST["nui"];
        $date_init = $_POST["date_init"];
        $montant_init = $_POST["montant_init"];


    $nom_table = "client";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté le client dénommé ".$nom.", de NIU ".$nui." et téléphone ".$telephone." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié le client dénommé ".$nom.", de NIU ".$nui." et téléphone ".$telephone." le ".$date_notif." à ".$heure;

        if ($status =="insert") {
            # code...

                $requete = $this->db->query("SELECT * from clientfrais where telephone =".$telephone."")->result_array();
                if (count($requete)>0) {
                    # code...
                    echo "Ce numéro de téléphone est déjà utilisé veuillez changer";
                }else{
                    $query1 = $this->db->query("insert into clientfrais value('','". $nom. "',". $telephone.",'".$adresse."','".$nui."',".$montant_init.",CAST('". $date_init."' AS DATE))");
                            if($query1 == true){
                                echo "Insertion parfaite du client";
                                $this->notificationAjout($nom_table,addslashes($message));
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                }
        }elseif ($status == "update"){
            # code...
            $id_client =$_POST["id_client"];
                $requete = $this->db->query("SELECT * from clientfrais where telephone =".$telephone."")->result_array();
                if (count($requete)>0) {
                    # code...
                   foreach ($requete as $row) {
                       # code...
                        if ($row["id_client"] == $id_client) {
                            # code...
                            $query1 = $this->db->query("UPDATE clientfrais set telephone=".$telephone.", adresse='".$adresse."', nom='".$nom."',nui='".$nui."', date_init = CAST('". $date_init."' AS DATE),montant_init=".$montant_init." where id_client=".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du client";
                                $this->notificationAjout($nom_table,addslashes($message2));
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                        }else{
                            echo "Erreur ce numero de téléphone est déjà utilisé";
                        }
                   }
                }else{
                    $query1 = $this->db->query("UPDATE clientfrais set telephone=".$telephone.", adresse='".$adresse."', nom='".$nom."', nui='".$nui."', date_init = CAST('". $date_init."' AS DATE),montant_init=".$montant_init." where id_client=".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du client";
                                $this->notificationAjout($nom_table,addslashes($message2));
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                }
        }else{
            echo "Erreur contactez l'administrateur".$status ;
        }
        $this->db->close();
    }
	
	
	public function deleteClient($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé le client dénommé ".$getCamion->nom." et de telephone ".$getCamion->telephone." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."=".$identifiant."");
           if ($suppression == true) {
               # code...
              echo "Suppression effectuée";
              $this->notificationAjout($nom_table,addslashes($message));
           }else{
              echo "Erreur lors de la suppression";
           }
        }
         

         $this->db->close();
    }
	
	 public function deleteDemande($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."='".$identifiant."'")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé la Demande frais de route N° ".$nom_id." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."='".$identifiant."'");
           if ($suppression == true) {
               # code...
              echo "Suppression effectuée";
              $this->notificationAjout($nom_table,addslashes($message));
           }else{
              echo "Erreur lors de la suppression";
           }
        }
         

         $this->db->close();
    }
	
		 public function deleteDemandeN($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."='".$identifiant."'")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé la Demande frais de route N° ".$nom_id." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."='".$identifiant."'");
           if ($suppression == true) {
               # code...
              echo "Suppression effectuée";
              $this->notificationAjout($nom_table,addslashes($message));
           }else{
              echo "Erreur lors de la suppression";
           }
        }
         

         $this->db->close();
    }
	
	 public function deleteDemandeNA($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."='".$identifiant."'")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé la Demande frais de route N° ".$nom_id." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."='".$identifiant."'");
           if ($suppression == true) {
               # code...
              echo "Suppression effectuée";
              $this->notificationAjout($nom_table,addslashes($message));
           }else{
              echo "Erreur lors de la suppression";
           }
        }
         

         $this->db->close();
    }
	
	
		 public function deleteDemandeST($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé la STOCK VEHICULE de route N° ".$nom_id." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."='".$identifiant."'");
           if ($suppression == true) {
               # code...
              echo "Suppression effectuée";
              $this->notificationAjout($nom_table,addslashes($message));
           }else{
              echo "Erreur lors de la suppression";
           }
        }
         

         $this->db->close();
    }
	
	
	
	public function getNbreNewNotificationParTemps(){
  $heure_debut = date("H:i:s",strtotime('now -10 Seconds'));
  $heure_fin = date("H:i:s");
  $query = $this->db->query("SELECT * from notification2 where heure_notif between '".$heure_debut."' and '".$heure_fin."'")->result_array();
  $id = "";
  if (count($query) >0) {
    # code...

    foreach ($query as $row) {
      # code...
      if ($this->getVueNotification($row['ref']) == 0 || $this->getVueNotification($row['ref']) =='') {
        # code...
        if ($id == "") {
          # code...
          $id = $id.$row['ref'];
        }else{
          $id = $id.",".$row['ref'];
        }
        
      }
    }
  }
  

  return $id;
}

public function getUniqueNotificationParTemps(){
  $id = $_POST['id'];
  $heure_debut = date("H:i:s",strtotime('now -12 Seconds'));
  $heure_fin = date("H:i:s");
  $query = $this->db->query("SELECT * from notification where ref=".$id." and heure_notif between '".$heure_debut."' and '".$heure_fin."'")->result_array();

  if (count($query) >0) {
    # code...
    $delai = 5750;
    foreach ($query as $row) {
      # code...
      if ($this->getVueNotification($row['ref']) == 0 || $this->getVueNotification($row['ref']) =='') {
        # code...
        echo addslashes($row['message'])." <br> <input type=\"button\" class=\"button\" value=\"Ne plus afficher\" aria-label=\"Close\" data-dismiss=\"toast\" onclick='nePlusAfficher(".$row['ref'].");' class=\" btn-primary btn-sm\">";
       
      }
    }
  }
}

public function getVueNotification($ref){
  $query = $this->db->query("SELECT * from vue_notification where ref_notif = ".$ref." and id_profil =".$this->session->userdata('id_profil')."")->row();
  $vue = 0;
  if (count($query)>0) {
    # code...
    $vue = $query->vue;
  }

  return $vue;
}




}



	
