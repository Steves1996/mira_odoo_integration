<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model_livraison extends CI_Model {
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
  $query = $this->db->query("SELECT * from profil where id_profil=".$id_profil."")->row();
  if (count($query)>0) {
    # code...
    return $query->identifiant;
  }
  $this->db->close();
}

// ceci est la fonction permet de vérifier si une action se déroule nien à partir de la date de debut de l'opération
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

public function recupPUSansTVA($tva,$pu){
  if ($tva=="oui") {
                      # code...
    return $pu/1.1925;
 }else{
  return $pu;
 }

 $this->db->close();
}
    public function selectAllLivraison(){

      if (isset($_POST["date_debut"]) && isset($_POST["date_fin"]) && isset($_POST["decharge1"])) {
        # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
		 $decharge1 = $_POST['decharge1'];
        if (!empty($date_fin) && !empty($date_debut) && !empty($decharge1)) {
            # code...
           $query = $this->db->query('SELECT * from bon_livraison where decharge = "'.$decharge1.'" and date_bl between "'.$date_debut.'" and "'.$date_fin.'" order by date_bl desc')->result_array(); 
        
		if ($decharge1 == 'TOUT') {
            # code...
          $query = $this->db->query('SELECT * from bon_livraison where date_bl between "'.$date_debut.'" and "'.$date_fin.'" order by date_bl desc')->result_array();
        
		}
		
		}else{
            $query = $this->db->query('SELECT * from bon_livraison order by date_bl desc limit 1500')->result_array();
        }
    }else{
        $query = $this->db->query('SELECT * from bon_livraison order by date_bl desc limit 1500')->result_array();
    }

        // $query = $this->db->query("SELECT * from bon_livraison order by date_bl desc")->result_array();

        if (count($query) >0 ) {
            # code...
            $compteur = 0;
        foreach ($query as $row) {
            # code...
            echo "<tr>
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['numero']."
					<td>".$row['destinataire']."</td>
                    </td>";
                    $getOperation = $this->db->query("SELECT * from operation where id_operation=".$row["id_operation"]."")->row();
					$getClient = $this->db->query("SELECT * from client where id_client=".$getOperation->id_client."")->row();
                    $getDestinationLitrage = $this->db->query("SELECT * from distance_littrage where id_distance=".$row["id_destination_litrage"]."")->row();
                    echo"<td>";
                    if (count($getOperation)>0) {
                      # code...
                     echo $getOperation->nom_op;
                    }else{
                      echo "Aucune";
                    }
                    echo" </td>";

                    echo"
					<td> ".$getClient->nom."</td> 
					<td> ".$getOperation->produit."</td>
					
                    <td> ".$row['code_camion']."</td>";
					
					$query1 = $this->db->query("SELECT * from tracteur where code ='".$row["code_camion"]."' limit 1")->row();
					$query2 = $this->db->query("SELECT * from camion_benne where code='".$row["code_camion"]."' limit 1")->row();
					$query3 = $this->db->query("SELECT * from engin where code='".$row["code_camion"]."' limit 1")->row();
					$query4 = $this->db->query("SELECT * from vraquier where code='".$row["code_camion"]."' limit 1")->row();
					 
					echo"<td>";
                    if (count($query1)>0) {
                      # code...
                     echo $query1->immatriculation;
                    }
					if (count($query2)>0) {
                      # code...
                     echo $query2->immatriculation;
                    }
					if (count($query3)>0) {
                      # code...
                     echo $query3->immatriculation;
                    }
					if (count($query4)>0) {
                      # code...
                     echo $query4->immatriculation;
                    }
                    echo" </td>";

                    echo"
					
                    <td>".$row['date_bl']."</td>
                    <td>"; if (count($getDestinationLitrage)>0) {
                      # code...
                     echo $getDestinationLitrage->distance;
                    }else{
                      echo "Aucune";
                    }
                    echo "</td>
                     <td> ".$row['quantite']."</td>
                    <td> ".number_format($row['prix_unitaire'],3,'.',' ')."</td>
                     <td> ".number_format($row['prix_unitaire']*$row['quantite'],3,'.',' ')."</td>
                     <td>".$row['tva']."</td>
					 <td>".$row['decharge']."</td>
					 <td>".$row['facture']."</td>
                    <td>";

              if($this->session->userdata('recette_modification')=='true'){
                    echo"<button type='button' onclick='infosLivraison(\"".$row['numero']."\",\"".$row['date_bl']."\",\"".$row['depart']."\",\"".$row['quantite']."\",\"".number_format($row['prix_unitaire'],0,',',' ')."\",\"".$row['id_BL']."\",\"".$row['commentaire']."\",\"".$row['code_camion']."\",\"".$row['id_destination_litrage']."\",\"".$row['unite']."\",\"".$row['id_operation']."\",\"".$row['tva']."\",\"".$this->recupPUSansTVA($row['tva'],$row['prix_unitaire'])."\",\"".$row['decharge']."\",\"".$row['destinataire']."\");' class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                  }

              if($this->session->userdata('recette_modification')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='bon_livraison' identifiant='".$row['id_BL']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_BL\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                }
                  $compteur++;
            }
        }

        $this->db->close();
    }
	
	public function getImmatriculation(){
      $camion = $_POST["camion"];
	  
        $query = $this->db->query("SELECT * from tracteur where code ='".$camion."' limit 1")->row();
		$query1 = $this->db->query("SELECT * from camion_benne where code='".$camion."' limit 1")->row();
         $query2 = $this->db->query("SELECT * from engin where code='".$camion."' limit 1")->row();
         $query3 = $this->db->query("SELECT * from vraquier where code='".$camion."' limit 1")->row();
		 
        if (count($query) > 0) {
          # code...
        
          echo $query->immatriculation;
		  
        }else if (count($query1)>0){
			
          echo $query1->immatriculation;
		  
		}else if (count($query2)>0){
		
			  echo $query2->immatriculation;
			  
		}else if (count($query3)>0){
			
		
			  echo $query3->immatriculation;
		
		
		}else{
          echo "Aucune";
        }				
        $this->db->close();
    }
	
	public function getImmatriculationCode(){
      $immat = $_POST["immat"];
	  
        $query = $this->db->query("SELECT * from tracteur where immatriculation ='".$immat."' limit 1")->row();
		$query1 = $this->db->query("SELECT * from camion_benne where immatriculation='".$immat."' limit 1")->row();
         $query2 = $this->db->query("SELECT * from engin where immatriculation='".$immat."' limit 1")->row();
         $query3 = $this->db->query("SELECT * from vraquier where immatriculation='".$immat."' limit 1")->row();
		 
        if (count($query) > 0) {
          # code...
        
          echo $query->code;
		  
        }else if (count($query1)>0){
			
          echo $query1->code;
		  
		}else if (count($query2)>0){
		
			  echo $query2->code;
			  
		}else if (count($query3)>0){
			
		
			  echo $query3->code;
		
		
		}else{
          echo "Aucune";
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

  public function addLivraison(){
      $numero = $_POST["numero"];
      $destinataire = addslashes($_POST["commentaire"]);
      $dateLivraison = $_POST["dateLivraison"];
      $depart = $_POST["depart"];
      $arrivee = $_POST["arrivee"];
      $quantite = $_POST["quantite"];
      $PU =intval( preg_replace('/\s/','', $_POST["PU"]));
      $status = $_POST["status"];
      $unite = $_POST["unite"];
      $operation = $_POST["operation"];
      $code_camion = $_POST['code_camion'];
      $tva = $_POST['tva'];
	  $decharge = $_POST['decharge'];

      $nom_table = " bon_livraison";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté un bon de livraison N°".$numero.", sur le camion de code ".$code_camion.", pour le compte de l'opération ".$this->getOperation($operation)." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié un bon de livraison N°".$numero.", sur le camion de code ".$code_camion.", pour le compte de l'opération ".$this->getOperation($operation)." le ".$date_notif." à ".$heure;

      if ($status == 'insert') {
        $requeteNumero = $this->db->query("select * from bon_livraison where numero ='".$numero."'")->result_array();
if ($this->getValideDateUseOperation($dateLivraison ,$operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
      if (count($requeteNumero) >0) {
        # code...
        echo "Ce numero a déjà été utilisé veuillez le changer";
      }else{
            $requete = $this->db->query("INSERT into bon_livraison value('','".$numero."',".$operation.",'".$code_camion."',CAST('". $dateLivraison."' AS DATE),'".$depart."',".$arrivee.",".$quantite.",".$PU.",'".$unite."','".$tva."','','".$decharge."','".$destinataire."','AUCUNE')");
      if ($requete == true) {
        # code...
        echo "Création parfaite du bon de livraison";
        $this->notificationAjout($nom_table,addslashes($message));
      }else{
        echo "Erreur d'insertion";
      }
      }
        # code...
      }
      }elseif ($status == 'update') {
        # code...
          $id_BL = $_POST["id_BL"];
          $requeteNumero = $this->db->query("select * from bon_livraison where numero ='".$numero."'")->result_array();
if ($this->getValideDateUseOperation($dateLivraison ,$operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
      if (count($requeteNumero) >0) {
        # code...
       
        foreach ($requeteNumero as $tab) {
          # code...
          if ($id_BL == $tab["id_BL"]) {
            # code...
             $requete = $this->db->query("UPDATE bon_livraison set id_operation=".$operation.",numero='".$numero."', date_bl=CAST('". $dateLivraison."' AS DATE), depart='".$depart."', id_destination_litrage = ".$arrivee.", quantite=".$quantite.", prix_unitaire=".$PU.", unite ='".$unite."',code_camion='".$code_camion."',destinataire='".$destinataire."', tva='".$tva."',decharge='".$decharge."' where id_BL=".$id_BL."");
      if ($requete == true) {
        # code...
        echo "Modification parfaite du bon de livraison";
        $this->notificationAjout($nom_table,addslashes($message2));
      }else{
        echo "Erreur d'insertion";
      }
          }else{
             echo "Ce numero a déjà été utilisé veuillez le changer";
          }
        }
      }else{
         $requete = $this->db->query("UPDATE bon_livraison set id_operation=".$operation.",numero='".$numero."', date_bl=CAST('". $dateLivraison."' AS DATE), depart='".$depart."', id_destination_litrage = ".$arrivee.", quantite=".$quantite.", prix_unitaire=".$PU.", unite ='".$unite."',code_camion='".$code_camion."',destinataire='".$destinataire."',tva='".$tva."',decharge='".$decharge."' where id_BL=".$id_BL." ");
      if ($requete == true) {
        # code...
        echo "Modification parfaite du bon de livraison";
        $this->notificationAjout($nom_table,addslashes($message2));
      }else{
        echo "Erreur d'insertion";
      }
      }
        } 
      }else{
          echo "Erreur veuillez contacter l'administrateur";
      }

      $this->db->close();
      
    }

    public function leSelectClient(){
        $query1 = $this->db->query("select * from client")->result_array();
        if (count($query1)>0) {
        foreach ($query1 as $row) {
            echo "<option value='".$row["id_client"]."'>".$row["telephone"]."</option>";
        }
        }else{
            echo "<option value=''>aucune</option>";
         }

        $this->db->close();
    }

    public function getDescriptionOperation(){
      $id_operation = $_POST["id_operation"];
        $query = $this->db->query("SELECT * from operation where id_operation =".$id_operation."")->row();

        if (count($query) > 0) {
          # code...
          echo $query->commentaire;
        }else{
          echo "Aucune";
        }

        $this->db->close();
    }
	
	 public function getTotalBL(){
      $id_operation = $_POST["id_operation"];
        $query = $this->db->query("SELECT SUM(quantite) AS SOMME from bon_livraison where id_operation =".$id_operation."")->row();

        if (count($query) > 0) {
          # code...
          echo $query->SOMME;
        }else{
          echo "0";
        }

        $this->db->close();
    }

   public function getClientOperation(){
      $id_operation = $_POST["id_operation"];
        $query = $this->db->query("SELECT * from operation where id_operation =".$id_operation."")->row();

        if (count($query) > 0) {
          # code...
          $getClient = $this->db->query("SELECT * from client where id_client = ".$query->id_client."")->row();
          echo $getClient->nom;
        }else{
          echo "Aucune";
        }

        $this->db->close();
    }

    public function getDestinationOperation(){
      $id_operation = $_POST["id_operation"];
        $query = $this->db->query("SELECT * from operation where id_operation =".$id_operation."")->row();

        if (count($query) > 0) {
          # code...
          echo $query->destination;
        }else{
          echo "Aucune";
        }

        $this->db->close();
    }

  public function getDestinationParCodeCamion(){
       $id_type_camion = $_POST["id_type_camion"];
        $query = $this->db->query("SELECT * from distance_littrage order by distance")->result_array();

        if (count($query) > 0) {
          # code...
          foreach ($query as $row) {
            # code...
            echo "<option id_distance='".$row['id_distance']."' value='".$row['id_distance']."'>".$row['distance']."</option>";
          }
        }else{
          echo "<option>Aucune</option>";
        }

        $this->db->close();
    }

    public function getDestinationParCodeCamion2(){
       $id_type_camion = $_POST["id_type_camion"];
        $query = $this->db->query("SELECT distinct distance,id_distance from distance_littrage order by distance")->result_array();

        if (count($query) > 0) {
          # code...
          foreach ($query as $row) {
            # code...
            echo "<option id_distance='".$row['id_distance']."' value='".$row['id_distance']."'>".$row['distance']."</option>";
          }
        }else{
          echo "<option>Aucune</option>";
        }

        $this->db->close();
    }

    public function getAmortissementDestination(){
      $id_distance = $_POST["id_distance"];
        $query = $this->db->query("SELECT * from distance_littrage where id_distance =".$id_distance." limit 1")->row();

        if (count($query) > 0) {
          # code...
          echo $query->amortissement;
        }else{
          echo "Aucune";
        }

        $this->db->close();
    }

public function getDestinationParTypeVehicule(){
    $code = $_POST['code_camion'];

        $getTracteur = $this->db->query("SELECT * from tracteur where code ='".$code."'")->row();
    $getCamion = $this->db->query("SELECT * from camion_benne where code ='".$code."'")->row();
    $getEngin = $this->db->query("SELECT * from engin where code ='".$code."'")->row();

    if (count($getTracteur)>0) {
        # code...
        $getMontantTypeVehicule = $this->db->query("SELECT * from distance_littrage where id_type_camion ='".$getTracteur->id_type_camion."'")->result_array();

        foreach ($getMontantTypeVehicule as $distance) {
          # code...
           echo "<option id_distance='".$row['id_distance']."'>".$row['distance']."</option>";
        }
    }elseif (count($getCamion)>0) {
        # code...
       $getMontantTypeVehicule = $this->db->query("SELECT * from distance_littrage where id_type_camion ='".$getCamion->id_type_camion."'")->result_array();

        foreach ($getMontantTypeVehicule as $distance) {
          # code...
           echo "<option id_distance='".$row['id_distance']."'>".$row['distance']."</option>";
        }
    }elseif (count($getEngin)>0) {
        # code...
        $getMontantTypeVehicule = $this->db->query("SELECT * from distance_littrage where id_type_camion ='".$getEngin->id_type_camion."'")->result_array();

        foreach ($getMontantTypeVehicule as $distance) {
          # code...
           echo "<option id_distance='".$row['id_distance']."'>".$row['distance']."</option>";
        }
        
    }

    $this->db->close();
}



 public function addVentePieces(){
        $libelle =addslashes($_POST["libelle"]);
        $piece = addslashes($_POST["piece"]);
        $operation = $_POST["operation"];
        $leClient = $_POST["leClient"];
        $code_camion = $_POST["code_camion"];
        $date_piece = $_POST["date_piece"];
        $montant = preg_replace('/\s/','', $_POST["montant"]);
        $status = $_POST["status"];
        // echo $operation." et ".$code_camion;

        $nom_table = "vente_pieces";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à éffectué une vente de pièce au montant de ".$montant.", sur le camion de code ".$code_camion.", pour le compte de l'opération ".$this->getOperation($operation)." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié une vente de pièce au montant de ".$montant.", sur le camion de code ".$code_camion.", pour le compte de l'opération ".$this->getOperation($operation)." le ".$date_notif." à ".$heure;

    

        if ($status =="insert") {
            # code...
            // echo $telephone;
          // on verifie si la date est supérieure à celle du debut de l'operation choisie
        if ($this->getValideDateUseOperation($date_piece,$operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
             
         $query1 = $this->db->query("INSERT into vente_pieces value('',".$operation.",'".$code_camion."',".$leClient.",'". $piece. "',CAST('". $date_piece."' AS DATE),".$montant.",'".$libelle."')");
                            if($query1 == true){
                                echo "Insertion parfaite de la vente";
                                $this->notificationAjout($nom_table,addslashes($message));
                            }else{
                                echo "Erreur durant l'insertion";
                            }
               
              }
        }elseif ($status == "update") {
            # code...
            $id_client =$_POST["id_client"];
            // on verifie si la date est supérieure à celle du debut de l'operation choisie
        if ($this->getValideDateUseOperation($date_piece,$operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
             $query1 = $this->db->query("UPDATE vente_pieces set piece='".$piece."', date_piece=CAST('". $date_piece."' AS DATE), montant=".$montant.", code_camion='".$code_camion."', id_client=".$id_client.", code_camion='".$code_camion."',id_operation=".$operation.", libelle='".$libelle."' where id_piece =".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite de la vente";
                                $this->notificationAjout($nom_table,addslashes($message2));
                            }else{
                                echo "Erreur durant l'insertion";
                            }
              
              }
        }else{
            echo "Erreur contactez l'administrateur";
        }

        $this->db->close();
        
    }

public function selectAllVentePieces(){
              $query1 = $this->db->query('SELECT * from vente_pieces order by date_piece desc')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
          $getClient= $this->db->query("SELECT * from client where id_client = ".$row['id_client']."")->row();
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['piece']."
                    </td>";
                    $getOperation = $this->db->query("SELECT * from operation where id_operation = ".$row['id_operation']." limit 1")->row();
                    echo"
                    <td>".$getOperation->nom_op."</td>
                    <td>".$row['code_camion']."</td>
                    <td>".$row['date_piece']."</td>
                    <td> ".number_format($row['montant'],0,',',' ')."</td>
                    <td> ";
                    if (count($getClient)>0) {
                      # code...
                      echo $getClient->nom;
                    }
                    echo"</td>
                    <td>".$row['libelle']."</td>
                    <td>";

            if($this->session->userdata('recette_modification')=='true'){
                    echo"<button type='button' onclick=\"infosClient1('".$row['id_piece']."','".$row['piece']."','".$row['date_piece']."','".$row['montant']."','".$row['libelle']."','".$row['id_operation']."','".$row['code_camion']."','".$row['id_client']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>"; 
                }

            if($this->session->userdata('recette_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='vente_pieces' identifiant='".$row['id_piece']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_piece\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                }
                  $compteur++;
        }

        $this->db->close();
    }


public function deleteBonLivraison($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé le bon de livraion N° ".$getCamion->numero.", en date du ".$getCamion->date_bl." pour le camion de code ".$getCamion->code_camion." le ".$date_notif." à ".$heure;


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

  public function deleteVentePiece($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé la vente de la pièce ".$getCamion->piece." d'un montant de ".$getCamion->montant." et de code camion ".$getCamion->code_camion." de la date du ".$getCamion->date_piece." le ".$date_notif." à ".$heure;


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