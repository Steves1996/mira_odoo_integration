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
        $insertion = $this->db->query("INSERT into gazoil value ('',".$id_operation.",".$id_fournisseur.",'".$codeCamion."','".$numero."',".$destination.", CAST('". $date."' AS DATE) ,".$litrage.",".$kilometrage.",".$prixUnitaire.",'".$commentaire."')");

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
         $insertion = $this->db->query("INSERT into gazoil value ('',".$id_operation.",".$id_fournisseur.",'".$codeCamion."','".$numero."',".$destination.", CAST('". $date."' AS DATE) ,".$litrage.",".$kilometrage.",".$prixUnitaire.",'".$commentaire."')");

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
         $insertion = $this->db->query("INSERT into gazoil value ('',".$id_operation.",".$id_fournisseur.",'".$codeCamion."','".$numero."',".$destination.", CAST('". $date."' AS DATE) ,".$litrage.",".$kilometrage.",".$prixUnitaire.",'".$commentaire."')");

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
        $update = $this->db->query("UPDATE gazoil set id_operation=".$id_operation.",id_fournisseur=".$id_fournisseur.",code_camion='".$codeCamion."',numero = '".$numero."',date_gazoil = CAST('". $date."' AS DATE), litrage = ".$litrage.", id_distance = ".$destination.", kilometrage = ".$kilometrage.",prix_unitaire = ".$prixUnitaire.", commentaire ='".$commentaire."' where id_gazoil=".$id_gazoil."");

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
     
        $update = $this->db->query("UPDATE gazoil set id_operation=".$id_operation.",id_fournisseur=".$id_fournisseur.",code_camion='".$codeCamion."',numero = '".$numero."',date_gazoil = CAST('". $date."' AS DATE), litrage = ".$litrage.", id_distance = ".$destination.", kilometrage = ".$kilometrage.",prix_unitaire = ".$prixUnitaire.", commentaire ='".$commentaire."' where id_gazoil=".$id_gazoil."");

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
        $update = $this->db->query("UPDATE gazoil set id_operation=".$id_operation.",id_fournisseur=".$id_fournisseur.",code_camion='".$codeCamion."',numero = '".$numero."',date_gazoil = CAST('". $date."' AS DATE), litrage = ".$litrage.", id_distance = ".$destination.", kilometrage = ".$kilometrage.",prix_unitaire = ".$prixUnitaire.", commentaire ='".$commentaire."' where id_gazoil=".$id_gazoil."");

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
     
        $update = $this->db->query("UPDATE gazoil set id_operation=".$id_operation.",id_fournisseur=".$id_fournisseur.",code_camion='".$codeCamion."',numero = '".$numero."',date_gazoil = CAST('". $date."' AS DATE), litrage = ".$litrage.",id_distance = ".$destination.", kilometrage = ".$kilometrage.",prix_unitaire = ".$prixUnitaire.", commentaire ='".$commentaire."' where id_gazoil=".$id_gazoil."");

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
        $query = $this->db->query("select * from fournisseur_gazoil where id_fournisseur = 19 or id_fournisseur = 22 OR id_fournisseur = 20 OR id_fournisseur = 21 ORDER BY nom")->result_array();
        if (count($query) >0) {
			
			echo "<option value=''></option>";
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
        $query = $this->db->query("select * from fournisseur_article where id_fournisseur = 22 or  id_fournisseur = 28 or  id_fournisseur = 31 or  id_fournisseur = 32 or id_fournisseur = 47 Order by nom")->result_array();
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
        $query = $this->db->query("select * from fournisseur_article where id_fournisseur = 48 or  id_fournisseur = 44 or  id_fournisseur = 28 or  id_fournisseur = 32 or id_fournisseur = 47 or id_fournisseur = 22 or id_fournisseur = 30 or id_fournisseur = 51 Order by nom")->result_array();
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
        $query = $this->db->query("select * from fournisseur_article where id_fournisseur = 22 or id_fournisseur = 32 or id_fournisseur = 28 or id_fournisseur = 31 ")->result_array();
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
	
	public function leSelectImmatCamion(){
        $query = $this->db->query("SELECT * from tracteur order by code asc")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["immatriculation"]."' id_type = '".$row["id_type_camion"]."'>".$row["immatriculation"]."</option>";
            }
        }else{
            
        }
        $query1 = $this->db->query("SELECT * from camion_benne order by code asc")->result_array();
        if (count($query1) >0) {
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["immatriculation"]."' id_type = '".$row["id_type_camion"]."'>".$row1["immatriculation"]."</option>";
            }
        }else{
            
        }
         $query1 = $this->db->query("SELECT * from engin order by code asc")->result_array();
        if (count($query1) >0) {
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["immatriculation"]."' id_type = '".$row["id_type_camion"]."'>".$row1["immatriculation"]."</option>";
            }
        }else{
            
        }
        
         $query1 = $this->db->query("SELECT * from vraquier order by code asc")->result_array();
        if (count($query1) >0) {
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["immatriculation"]."' id_type = '".$row["id_type_camion"]."'>".$row1["immatriculation"]."</option>";
            }
        }else{
            
        }
        $query1 = $this->db->query("SELECT * from voitureservice order by code asc")->result_array();
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
        echo ' <tr class="formAddInventaire">
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

                                  <td><input type="text" placeholder ="Reférence" disabled = "False" class="form-control reference" ></td>
                                  
                                  
                                  <td><input type="text" placeholder ="Montant" class="form-control montant" disabled = "False" onkeypress="chiffres(event);"></td>
                                  
                                  <td>
                                        <div class="input-group input-group-sm">
                                        <input type="text" class="form-control qtite" onkeypress="chiffres(event);">
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
	
	public function addApprovisionnementPneu(){
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
        

        $addInventaire = $this->db->query("INSERT into approvisionnementpneu value('',".$id_article.",".$id_fournisseur.",'".$reference."','".$auteur."',CAST('". $date."' AS DATE),".$qtite.",0,'".$bl."')");
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
                    <td>".$getNomArticle->prix_unitaire."</td>
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
                if($this->session->userdata('stock_suppression')=='true'){
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
                    <td>".$getNomArticle->PU."</td>
                    <td>".$row['auteur']."</td>
                    
                    <td>".$row['montant']."</td>
                    <td>".$row['bl']."</td>
                    <td>".$row['date_app']."</td>
                    
                    <td>".$row['qtite']."</td>
                    <td>$qtiteInventaire </td>
                    <td>";
                if($this->session->userdata('stock_suppression')=='true'){
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
                    $getNomArticle = $this->db->query("SELECT * from type_pneu where id_type_pneu =".$row['id_article']."")->row();
                    $four = $this->db->query("SELECT * from fournisseur_article where id_fournisseur=".$row['id_fournisseur']." ")->row();
                    if (count($four)>0) {
                        # code...
                        $four = $four->nom;
                    }else{
                        $four ="";
                    }
                    echo" 
                    
                    <td>".$getNomArticle->nom_type."</td>
                    <td>".$four."</td>
                   
                    <td>".$row['auteur']."</td>
                    
                    
                    <td>".$row['bl']."</td>
                    <td>".$row['date_app']."</td>
                    
                    <td>".$row['qtite']."</td>
                    <td>$qtiteInventaire </td>
                    <td>";
                if($this->session->userdata('stock_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='approvisionnementpneu' identifiant='".$row['id_app']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_app\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
            }
        }


        $this->db->close();
    }




    public function selectAllGazoil(){

        if (isset($_POST["date_debut"]) && isset($_POST["date_fin"])) {
        # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
		
		
		                     
							 
        if (!empty($date_fin) && !empty($date_debut)) {
            # code...
           $query1 = $this->db->query('SELECT * from gazoil where date_gazoil between "'.$date_debut.'" and "'.$date_fin.'" order by date_gazoil ')->result_array(); 
        }else{
            $query1 = $this->db->query('SELECT * from gazoil order by date_gazoil desc limit 1000')->result_array();
        }
    }else{
        $query1 = $this->db->query('SELECT * from gazoil order by date_gazoil desc limit 1000')->result_array();
    }


         // $query1 = $this->db->query('SELECT * from gazoil order by date_gazoil desc limit 2000')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

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
                    <td>";
                    if (count($getDistance)>0) {
                        # code...
                        echo  $getDistance->distance;
                    }else{

                    }
                   echo "</td>
                    <td>".$row['kilometrage']."</td>
                    <td>".number_format($row['prix_unitaire'],0,',',' ')."</td>
                    <td>".number_format($row['prix_unitaire'] * $row['litrage'],0,',',' ')." </td>
                    <td>";

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

        $this->db->close();
    }
	
	
	
	
	
public function stockGazoil(){
	
    $getFournisseur = $this->db->query("select * from fournisseur_gazoil where nom = 'TOTAL NEW' or nom = 'NEPTUNE NEW' or nom = 'TOTAL NEW EXTERNE' or nom = 'NEPTUNE NEW EXTERNE'")->result_array();
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
                     $getCategorie = $this->db->query('SELECT * FROM categorie_article where id_categorie='.$article->id_categorie.'')->row();
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
                echo"<td>".$stock."</td>
                    ";
                    $compteur++;
        }

        
    }

    $this->db->close();
}

public function stockPneu(){
	
    $getFournisseur = $this->db->query("select * from fournisseur_article where id_fournisseur = 48 or  id_fournisseur = 44 or  id_fournisseur = 28 or  id_fournisseur = 32 or id_fournisseur = 47 or id_fournisseur = 22 Order by nom ")->result_array();
    $compteur = 0;
    if (count($getFournisseur) > 0) {
        # code...
        foreach ($getFournisseur as $row) {
            # code...
            
                    $fournisseur = $this->db->query("SELECT * from fournisseur_article where id_fournisseur =".$row['id_fournisseur']."")->row();
                    
                
					$article = $this->db->query("SELECT * from type_pneu")->result_array();
					
					$compteur1 = 0;
					
					if (count($article) > 0) {
					# code...
					foreach ($article as $row1) {
						
						echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    ";
	                
                    echo"
					
					 <td>".$fournisseur->nom."</td>
                  	<td>".$row1['nom_type']."</td>					
                    
                    </td>";
					
					 $qtiteInventaire = 0;
                $getInventaire = $this->db->query("SELECT * from inventairepneu where id_article=".$row1['id_type_pneu']." and id_fournisseur=".$row['id_fournisseur']." order by date_inv desc")->result_array();
				
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
                $getApprovisionnement = $this->db->query("SELECT * from approvisionnementpneu where id_article=".$row1['id_type_pneu']." and  id_fournisseur=".$row['id_fournisseur']." and date_app >= '".$this->getDateDernierInventairePneu()."'")->result_array();
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
                $getPieceRechange = $this->db->query("SELECT * from depense_pneu where date_depense >= '".$this->getDateDernierInventairePneu()."' and type ='PNEU' and  id_fournisseur=".$row['id_fournisseur']."")->result_array();
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
                echo"<td>".$stock."</td>
                    ";
					
					
					$compteur1++;
					}
						}
                   
               
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
                   
				
                   
                    
             
                $stock = $qtiteInventaire + $qtiteApprovisionnement   - $qtitePieceRechange ;
				
                echo"<td>".$stock."</td>
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
                    <td>".$row['numero']."</td>";
				
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
					<td>".$row['date_frais']."</td>";
					
					 
					    $getOperation = $this->db->query("SELECT * FROM operation where id_operation = ".$row['id_operation']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['facture']."</td>";
                        }
                    }
                    
                    echo"
                    <td>".$row['commentaire']."</td>
                   
                    <td>";
                if($this->session->userdata('depense_modification')=='true'){
                    echo "<button type='button'  onclick=\"infoFraisAchat('".$row['montant']."','".$row['date_frais']."','".$row['code_camion']."','".$row['id_operation']."',".$row['id_frais_achat'].",'".addslashes($row['commentaire'])."','".$row['numero']."','".$row['id_fournisseur']."','".$row['facture']."','".$row['type']."','".$row['total']."','".$row['quantite']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }

                if($this->session->userdata('depense_modification')=='true'){
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
    $montant1 = $_POST["montant1"];
	

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
           $insertion = $this->db->query("INSERT INTO frais_achat value ('',".$id_operation.",'".$codeCamion."',".$fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."','".$facture."','".$validite."',".$montant1.",".$quantite.")");
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
           $update = $this->db->query("UPDATE frais_achat set  id_operation =".$id_operation.",code_camion='".$codeCamion."',id_fournisseur = ".$fournisseur.", numero = '".$numero."',date_frais = CAST('". $date."' AS DATE),montant = ".$montant.", commentaire='".$commentaire."',facture = '".$facture."' ,type = '".$validite."',total = ".$montant1.",quantite = ".$quantite." where id_frais_achat=".$id_frais_divers."");
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
                            # code...
                            $prixTotal = $row['pu']*$row["qtite"];
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
            $insertion = $this->db->query("INSERT INTO piece_rechange value ('',".$id_operation.",".$id_article.",".$id_fournisseur.",'".$codeCamion."',CAST('". $date."' AS DATE),'".$distance."',".$qtite.",'".$origine."',".$pu.",'".$tva."')");
        }else{
            $insertion = $this->db->query("INSERT INTO piece_rechange value ('',".$id_operation.",".$id_article.",".$id_fournisseur.",'".$codeCamion."',CAST('". $date."' AS DATE),'".$distance."',".$qtite.",'".$origine."',".$pu.",'".$tva."')");
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
            $update = $this->db->query("UPDATE piece_rechange set  id_operation =".$id_operation.",id_article=".$id_article.",code_camion='".$codeCamion."',date_rech = CAST('". $date."' AS DATE),commentaire = '".$distance."', qtite=".$qtite.", prix_unitaire=".$pu.",origine='".$origine."',tva='".$tva."' where id_rechange=".$id_frais_divers."");
        }else{
           $update = $this->db->query("UPDATE piece_rechange set  id_operation =".$id_operation.",id_article=".$id_article.",code_camion='".$codeCamion."',date_rech = CAST('". $date."' AS DATE),commentaire = '".$distance."', qtite=".$qtite.", prix_unitaire=".$pu.",origine='".$origine."',id_fournisseur_article =".$id_fournisseur.",tva='".$tva."' where id_rechange=".$id_frais_divers."");
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
    $derniereDate = $_POST["derniereDate"];
    $type= $_POST["type"];
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
            $insertion = $this->db->query("INSERT INTO depense_pneu value ('','".$codeCamion."',".$id_article.",CAST('". $date."' AS DATE),".$qtite.",".$pu.",'".$commentaire."',CAST('". $derniereDate."' AS DATE),'".$type."', ".$id_fournisseur.")");
       
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
            $update = $this->db->query("UPDATE depense_pneu set  id_article=".$id_article.",code_camion='".$codeCamion."',date_depense = CAST('". $date."' AS DATE),commentaire = '".$commentaire."', qtite=".$qtite.", prix_unitaire=".$pu.",derniereDate =CAST('". $derniereDate."' AS DATE),type='".$type."', id_fournisseur='".$id_fournisseur."'  where id_depense=".$id_frais_divers."");
        
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
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    <td><input type='checkbox' onclick='selectionArticlePourSuppression(\"index".$compteur."\",\"".$row['id_rechange']."\");' class='index".$compteur."' value='".$row['id_rechange']."'/></td>
                    <td> ".$compteur."</td>";

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

            if($this->session->userdata('vidange_modification')=='true'){
                   echo" <button type='button'  onclick=\"infoPieceRechange('".$row['code_camion']."','".$row['id_article']."','".$row['origine']."','".$row['qtite']."','".$row['id_operation']."','".$row['date_rech']."','".$row['prix_unitaire']."','".$row['commentaire']."','".$row['id_rechange']."','".$row['id_fournisseur_article']."','".$row['origine']."','".$row['tva']."','".$this->recupPUSansTVA($row['tva'],$row['prix_unitaire'])."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
               }
            if($this->session->userdata('vidange_suppression')=='true'){
                   echo" <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='piece_rechange' identifiant='".$row['id_rechange']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_rechange\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
              }
                  $compteur++;
        }

        echo "<input type='text' class='compteur1' value='".$compteur."' style='display:none;'/>";

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
                    <td> ".$row['derniereDate']." </td>
                    <td> ".$row['date_depense']." </td>
                    <td> ".number_format($row['prix_unitaire'],0,',',' ')." </td>
                    <td> ".$row['qtite']." </td>
                    <td> ".number_format($row['qtite']*$row['prix_unitaire'],0,',',' ')." </td>
                    
                    <td> ".$row['commentaire']." </td>
                    <td>";
            if($this->session->userdata('pneu_modification')=='true'){
                   echo" <button type='button'  onclick=\"infoDepensePneu('".$row['code_camion']."','".$row['id_article']."','".$row['qtite']."','".$row['prix_unitaire']."','".$row['type']."','".$row['derniereDate']."','".$row['date_depense']."','".$row['id_depense']."','".$row['commentaire']."','".$row['id_fournisseur']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
               }
            if($this->session->userdata('pneu_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='depense_pneu' identifiant='".$row['id_depense']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_depense\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
        }

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
        # code...
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
        # code...
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
        # code...
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
                            $prixTotal = $row["pu"]*$row["qtite"];
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
                            # code...
                            $prixTotal = $row["pu"]*$row["qtite"];
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

            if($this->session->userdata('administration_modification')=='true'){
                    echo"<button type='button' onclick=\"infosTypeHuile('".$row['id_type']."','".$row['type_huile']."','".$row['huile']."','".$row['PU']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }
            if($this->session->userdata('administration_suppression')=='true'){
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
}