<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model_operation extends CI_Model {
// 
    function __construct() {
        parent::__construct();
        date_default_timezone_set('Africa/Lagos');
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

public function genererChaineAleatoireOperation(){ 

	$date = date('Y-m-d');
	$now = new Datetime();

    $getCodeBLClient = $this->db->query("SELECT * from operation order by id_operation desc limit 1")->row();

 $code =0;
    if (count($getCodeBLClient)>0) {
      # code...
      $code = $getCodeBLClient->facture;

    }else{
     
      $code = 0;
    }
    $code++;
    // $code=intval($code);
    while (strlen($code)<5) {
      # code...
      $code = "0".$code;
    }

    return "".filter_var($code, FILTER_SANITIZE_NUMBER_INT)."/".date("m")."/".date("Y");
}


    public function selectAllChargement(){
              $query1 = $this->db->query(' SELECT * from chargement_retour order by date_charg desc')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['numero']."
                    </td>";
                    $getOperation = $this->db->query("SELECT * from operation where id_operation = ".$row['id_operation']." limit 1")->row();
                    echo"
                    <td>".$getOperation->nom_op."</td>
                    <td>".$row['code_camion']."</td>
                    <td>".$row['date_charg']."</td>
                    <td> ".number_format($row['montant'],0,',',' ')."</td>
                    <td>".$row['libelle']."</td>
                    <td>";

            if($this->session->userdata('operation_modification')=='true'){
                    echo"<button type='button' onclick=\"infosClient1('".$row['id_charg']."','".$row['numero']."','".$row['date_charg']."','".$row['montant']."','".$row['libelle']."','".$row['id_operation']."','".$row['code_camion']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>"; 
                }

            if($this->session->userdata('operation_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='chargement_retour' identifiant='".$row['id_charg']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_charg\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
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

// 
    public function addChargement(){
        $libelle =addslashes($_POST["libelle"]);
        $numero = $_POST["numero"];
        $operation = $_POST["operation"];
        $code_camion = $_POST["code_camion"];
        $date_charg = $_POST["date_charg"];
        $montant = preg_replace('/\s/','', $_POST["montant"]);
        $status = $_POST["status"];
        // echo $operation." et ".$code_camion;

        $nom_table = "chargement_retour";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté un chargement retour sur le camion de code ".$code_camion." d'un montant de ".$_POST["montant"]." FCFA, pour le compte de l'opération ".$this->getOperation($operation)." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié un chargement retour sur le camion de code ".$code_camion." d'un montant de ".$_POST["montant"]." FCFA, pour le compte de l'opération ".$this->getOperation($operation)." le ".$date_notif." à ".$heure;

        if ($status =="insert") {
            # code...
            // echo $telephone;
          // on verifie si la date est supérieure à celle du debut de l'operation choisie
        if ($this->getValideDateUseOperation($date_charg,$operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
                $requete = $this->db->query("SELECT * from chargement_retour where numero ='".$numero."'")->result_array();
                if (count($requete)>0) {
                    # code...
                    echo "Ce numéro est déjà utilisé veuillez changer";
                }else{
                    $query1 = $this->db->query("insert into chargement_retour value('',".$operation.",'".$code_camion."','". $numero. "',CAST('". $date_charg."' AS DATE),".$montant.",'".$libelle."')");
                            if($query1 == true){
                                echo "Insertion parfaite du chargement";
                                $this->notificationAjout($nom_table,addslashes($message));
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                }
              }
        }elseif ($status == "update") {
            # code...
            $id_client =$_POST["id_client"];
            // on verifie si la date est supérieure à celle du debut de l'operation choisie
        if ($this->getValideDateUseOperation($date_charg,$operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
                $requete = $this->db->query("SELECT * from chargement_retour where numero ='".$numero."'")->result_array();
                if (count($requete)>0) {
                    # code...
                   foreach ($requete as $row) {
                       # code...
                        if ($row["id_charg"] == $id_client) {
                            # code...
                            $query1 = $this->db->query("UPDATE chargement_retour set numero='".$numero."', date_charg=CAST('". $date_charg."' AS DATE), montant=".$montant.", code_camion='".$code_camion."',id_operation=".$operation.", libelle='".$libelle."' where id_charg =".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du chargement";
                                $this->notificationAjout($nom_table,addslashes($message2));
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                        }else{
                            echo "Erreur ce numero est déjà utilisé";
                        }
                   }
                }else{
                    $query1 = $this->db->query("UPDATE chargement_retour set numero='".$numero."', date_charg=CAST('". $date_charg."' AS DATE), montant=".$montant.", code_camion='".$code_camion."',id_operation=".$operation.", libelle='".$libelle."' where id_charg =".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du chargement";
                                $this->notificationAjout($nom_table,addslashes($message2));
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                }
              }
        }else{
            echo "Erreur contactez l'administrateur";
        }
        $this->db->close();
    }

    public function selectAllOperation(){
        $query = $this->db->query("SELECT * from operation order by date_creation desc")->result_array();

        if (count($query) >0 ) {
            # code...
            $compteur = 0;
        foreach ($query as $row) {
            # code...
            $getClient= $this->db->query("SELECT * from client where id_client = ".$row['id_client']."")->row();
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['nom_op']."
                    </td>
                    <td>".$row['type_operation']."</td>
                    <td> ".$row['date_creation']."</td>
                    
                    <td> ".$row['date_fin']."</td>
                    <td> ".$getClient->nom."</td>
                    <td> ".$row['produit']."</td>
                    <td> ".$row['commentaire']."</td>
                    <td> ".$row['destination']."</td>
					<td> ".$row['num_op']."</td>
					<td> ".$row['facture']."</td>
					<td> ".$row['filiale']."</td>
                    <td>";

            if($this->session->userdata('operation_modification')=='true'){
                    echo"<button type='button' onclick='infoOperation(\"".$row['date_debut']."\",\"".$row['date_fin']."\",\"".$row['date_creation']."\",\"".addslashes($row['nom_op'])."\",\"".addslashes($row['type_operation'])."\",\"".$row['id_client']."\",\"".addslashes($row['commentaire'])."\",\"".addslashes($row['produit'])."\",\"".$row['id_operation']."\",\"".addslashes($row['destination'])."\",\"".$row['num_op']."\",\"".$row['facture']."\",\"".$row['filiale']."\");' class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }

                echo"  <button type='button'   class=' btn-primary btn-sm' onclick='detailOperation(\"".$row['id_operation']."\",\"".$row['facture']."\",\"".$getClient->nom."\",\"".$getClient->nui."\",\"".$getClient->adresse."\",\"".$row['date_fin']."\",\"".$row['type_operation']."\")'><i class='nav-icon '>+</i></button>";

            if($this->session->userdata('operation_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='operation' identifiant='".$row['id_operation']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_operation\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
              }
                  $compteur++;
            }
        }

        $this->db->close();
    }

    public function addOperation(){
      $destination =addslashes( $_POST['destination']);
	 
      $typeOperation = $_POST["typeOperation"];
      $nomOperation = $_POST["nomOperation"];
      $dateDebut = $_POST["dateDebut"];
      $dateFin = $_POST["dateFin"];
      $dateCreation = $_POST["dateCreation"];
      $client = $_POST["id_client"];
      $commentaire = addslashes($_POST["commentaire"]);
      $produit = $_POST["produit"];
	  $num_client = $_POST["num_client"];
	  $filiale = $_POST["filiale"];
      $status = $_POST["status"];

      $nom_table = "operation";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté l'opération ".$nomOperation." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié l'opération ".$nomOperation." le ".$date_notif." à ".$heure;

        if ($status == 'insert') {
            # code...
          $getOperation = $this->db->query("SELECT * from operation where nom_op ='".$nomOperation."'")->row();
        if (count($getOperation)>0) {
          # code...
          echo "Cet opération existe déjà veuillez changer le nom";
        }else{
    $query = $this->db->query("INSERT into operation value('',".$client.",'".$typeOperation."','".$nomOperation."',CAST('". $dateCreation."' AS DATE),CAST('". $dateDebut."' AS DATE),CAST('". $dateFin."' AS DATE),'".$produit."','".$commentaire."','".$destination."','','".$num_client."','".$filiale."')");
      if ($query == true) {
          # code...
        echo "Création de l'opération réussie";
        $this->notificationAjout($nom_table,addslashes($message));
      }else{
        echo "Echec de création contactez l'administrateur";
      }
      }
        }elseif ($status == 'update') {
            # code...
           $id_operation = $_POST['id_operation'];
           $getOperation = $this->db->query("SELECT * from operation where nom_op ='".$nomOperation."' limit 1")->row();
        if (count($getOperation)>0) {
          # code...
            if ($getOperation->id_operation == $id_operation) {
              # code...
              $query = $this->db->query("UPDATE operation set id_client=".$client.", type_operation ='".$typeOperation."', nom_op='".$nomOperation."', date_creation=CAST('". $dateCreation."' AS DATE), date_debut=CAST('". $dateDebut."' AS DATE), date_fin=CAST('". $dateFin."' AS DATE), produit='".$produit."', commentaire='".$commentaire."',destination ='".$destination."',facture ='".$num_client."', filiale ='".$filiale."' where id_operation=".$id_operation."");
                    if ($query == true) {
                        # code...
                      echo "Mise à jour de l'opération réussie";
                      $this->notificationAjout($nom_table,addslashes($message2));
                    }else{
                      echo "Echec de création contactez l'administrateur";
                    }
					
			 $update = $this->db->query("UPDATE frais_achat set facture = '".$num_client."' where id_operation=".$id_operation."");
			 
			 $update = $this->db->query("UPDATE bon_livraison set facture = '".$num_client."' where id_operation=".$id_operation."");
   
            }else{

          echo "Cet opération existe déjà veuillez changer le nom";
            }
        }else{
    $query = $this->db->query("UPDATE operation set id_client=".$client.", type_operation ='".$typeOperation."', nom_op='".$nomOperation."', date_creation=CAST('". $dateCreation."' AS DATE), date_debut=CAST('". $dateDebut."' AS DATE), date_fin=CAST('". $dateFin."' AS DATE), produit='".$produit."', commentaire='".$commentaire."',destination ='".$destination."',facture ='".$num_client."', filiale ='".$filiale."' where id_operation=".$id_operation."");
      if ($query == true) {
          # code...
        echo "Mise à jour de l'opération réussie";
        $this->notificationAjout($nom_table,addslashes($message2));
		
		$update = $this->db->query("UPDATE frais_achat set facture = '".$num_client."' where id_operation=".$id_operation."");
		
      }else{
        echo "Echec de création contactez l'administrateur";
      }
       }
        }else{
            echo "Erreur de connexion veuillez contacter l'administrateur";
        }
     

$this->db->close();
    }

    public function leSelectClient(){
        $query1 = $this->db->query("select * from client order by nom")->result_array();
        if (count($query1)>0) {
        foreach ($query1 as $row) {
            echo "<option value='".$row["id_client"]."'>".$row["nom"]."</option>";
        }
        }else{
            echo "<option value=''>aucune</option>";
         }

         $this->db->close();
    }



    public function selectAllLocationEnginOperationPourBalance(){
           $id_operation = $_POST["id_operation"];

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location<="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location>="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
$compteur = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
$getOperation = $this->db->query("SELECT * from operation where id_operation = ".$row['id_operation']." limit 1")->row();
$getDistance = $this->db->query("SELECT * FROM distance_littrage where id_distance = ".$row['id_distance']."")->row();

                    if (count($getDistance)>0) {
                        # code...
                        $distance = $getDistance->distance;
                        $kilometrage = $getDistance->kilometrage;
                        $getClient = $this->db->query("SELECT * FROM client where id_client=".$getOperation->id_client." ")->row();
                        $client = $getClient->nom;
                    }else{
                        $distance = "";
                        $client = "";
                    }
        echo "<tr><td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['code']."</td>
                    <td>".$getOperation->nom_op."</td>
                    <td>".addslashes($client)."</td>
                    <td> ".$row['duree']." ".$row['unite']."(s)</td>
                    <td>".number_format($row['montant'],3,'.',' ')."</td>
                    <td>".number_format($row['montant']*$row['duree'],3,'.',' ')."</td>
                    <td>".addslashes($distance)."</td>
                    <td>".$kilometrage."</td>
                    <td> ".$row['date_location']."</td>
                    <td></tr>";
          $compteur++;
      }
    }else{
      // echo "nada";
    }

    $this->db->close();
    }

    public function selectAllTotalLocationEnginOperationPourBalance(){
           $id_operation = $_POST["id_operation"];

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location<="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location>="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
$compteur = 0;
$montant10 = 0;
$total10 = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $getOperation = $this->db->query("SELECT * from operation where id_operation = ".$row['id_operation']." limit 1")->row();
         $montant10 = $row['montant']*$row['duree'];                  
         $total10 = $total10 + $montant10;
      }

    }else{
      // echo "nada";
    }

    return $total10;

    $this->db->close();
    }

// vente des pieces

      public function selectAllVentePiecesOperationPourBalance(){
           $id_operation = $_POST["id_operation"];

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece<="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece>="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
$compteur = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {

 $getClient= $this->db->query("SELECT * from client where id_client = ".$row['id_client']."")->row();
        echo "<tr><td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['piece']."
                    </td>";
                    $getOperation = $this->db->query("SELECT * from operation where id_operation = ".$row['id_operation']." limit 1")->row();
                    echo"
                    <td>".$getOperation->nom_op."</td>
                    <td>".$row['code_camion']."</td>
                    <td>".$row['date_piece']."</td>
                    <td> ".number_format($row['montant'],0,',',' ')."</td>
                    <td> ".$getClient->nom."</td>
                    <td>".$row['libelle']."</td>
                    
                    </tr>";
          $compteur++;
      }
    }else{
      // echo "nada";
    }

    $this->db->close();
    }
    
    public function selectAllTotalVentePiecesOperationPourBalance(){
           $id_operation = $_POST["id_operation"];

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece<="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece>="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
$compteur = 0;
$montant10 = 0;
$total10 = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
         $montant10 = $row['montant'];                 
         $total10 = $total10 + $montant10;
      }

    }else{
      // echo "nada";
    }

    return $total10;

    $this->db->close();
    }

  public function selectAllChargementOperationPourBalance(){
           $id_operation = $_POST["id_operation"];

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg<="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg<="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
$compteur = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...

        echo "<tr><td>".$compteur."</td>
              <td>".$row['numero']."</td>
              <td>".$row['code_camion']."</td>
              <td>".number_format($row['montant'],0,',',' ')."</td>
              <td>".$row['date_charg']."</td> </tr>";
          $compteur++;
      }
    }else{
      // echo "nada";
    }

    $this->db->close();
    }


     public function selectAllFactureOperationPourBalance(){
           $id_operation = $_POST["id_fournisseur"];

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl<="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl<="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
$compteur = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $getDstination = $this->db->query("SELECT * from distance_littrage where id_distance = ".$row['id_destination_litrage']."")->row();
		
				$getTracteur = $this->db->query("SELECT * from tracteur WHERE code ='".$row['code_camion']."' ")->row();
				
                $getCamionBenne = $this->db->query("SELECT * from camion_benne WHERE code ='".$row['code_camion']."'")->row();
                
				$getEngin = $this->db->query("SELECT * from engin WHERE code ='".$row['code_camion']."'")->row();
				
                $getVraquier = $this->db->query("SELECT * from vraquier WHERE code ='".$row['code_camion']."'")->row();
		
		
        $total = $row['quantite']*$row['prix_unitaire'];
        echo "<tr><td>".$compteur."</td>
              <td>".$row['numero']."</td>
              <td>".$row['code_camion']."</td>";				
				    
        if (count($getTracteur) >0) {
			
			echo "<td>".$getTracteur->immatriculation."</td>";
			   
           }
		
		
        if (count($getCamionBenne) >0) {
			
          echo "<td>".$getCamionBenne->immatriculation."</td>";
			   
           }
         
        if (count($getEngin) >0) {
			
          echo "<td>".$getEngin->immatriculation."</td>";
			   
           }
        
       
        if (count($getVraquier) >0) {
			
		  echo "<td>".$getVraquier->immatriculation."</td>";
			   
           }
			  
             echo " <td>".number_format($row['prix_unitaire'],3,'.',' ')."</td>
             <td>".$row['quantite']."</td>
              <td>".number_format($total,3,'.',' ')."</td>
              <td>".$row['date_bl']."</td>
              <td>".$getDstination->distance."</td>
              <td>".$getDstination->kilometrage."</td>
              <td>".$row['unite']."</td> </tr>";
          $compteur++;
      }
    }else{
      // echo "PAS DE DONNEES DISPONIBLE";
    }

    $this->db->close();
    }




  public function selectAllPrimeOperationPourBalance(){
    $id_operation = $_POST["id_operation"];

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
$compteur = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...

        echo "<tr><td>".$compteur."</td>
              <td>".$row['code_camion']."</td>
              <td>".number_format($row['montant'],0,',',' ')."</td>
              <td>".$row['libelle']."</td>
              <td>".$row['date_prime']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }

    $this->db->close();
  }

    public function selectAllFraisRouteOperationPourBalance(){
        $id_operation = $_POST["id_operation"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
$compteur = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
$getDistance = $this->db->query("SELECT * FROM distance_littrage where id_distance = ".$row['id_distance']."")->row();
                    if (count($getDistance)>0) {
                        # code...
                        $distance = $getDistance->distance;
                        $kilometrage = $getDistance->kilometrage;

                    }else{
                        $distance = "";
                    }
        echo "<tr><td>".$compteur."</td>
              <td>".$row['code_camion']." </td>
              <td>".number_format($row['montant'],0,',',' ')."</td>
              <td>".addslashes($distance)."</td>
              <td>".$kilometrage."</td>
              <td>".$row['date_frais']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }

    $this->db->close();
  }

      public function selectAllFraisDiversOperationPourBalance(){
    $id_operation = $_POST["id_operation"];
         $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
$compteur = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...

        echo "<tr><td>".$compteur."</td>
              <td>".$row['code_camion']."</td>
              <td>".number_format($row['montant'],0,',',' ')."</td>
              <td>".$row['commentaire']."</td>
              <td>".$row['date_frais']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }

    $this->db->close();
  }

public function selectAllPieceRechangeOperationPourBalance(){
    $id_operation = $_POST["id_operation"];
     $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM piece_rechange where id_operation =".$id_operation."")->result_array();
$compteur = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...

        echo "<tr><td>".$compteur."</td>
              <td>".$row['code_camion']."</td>";
              $getArticle = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->row();
              echo "<td>".$getArticle->article."</td>";
              echo "<td>".$getArticle->code_a_barre."</td>";
             echo" <td>".number_format($row['prix_unitaire'],0,',',' ')."</td>
             <td>".$row['qtite']."</td>
             <td>".$row['qtite']*$row['prix_unitaire']."</td>
              <td>".$row['date_rech']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }

    $this->db->close();
  }

public function selectAllVidangeOperationPourBalance(){
    $id_operation = $_POST["id_operation"];
    $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }

    // $getPrime = $this->db->query("SELECT * FROM vidange where id_operation =".$id_operation."")->result_array();
    $compteur = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...

        echo "<tr><td>".$compteur."</td>
             
              <td>".$row['code_camion']."</td>";
              $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->row();
              echo "<td>".$getArticle->type_huile."</td>
              <td>".$getArticle->huile."</td>";
              $prixTotal = $row['pu'] *$row['qtite'];
             echo" <td>".$row['qtite']."</td>
             <td>".number_format($row['pu'],0,',',' ')."</td>
             <td>".number_format($prixTotal,0,',',' ')."</td>
              <td>".$row['date_vidange']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }
    if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange <="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange <="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
      // $getPrime = $this->db->query("SELECT * FROM vidangeHydrolique where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...

        echo "<tr><td>".$compteur."</td>
             
              <td>".$row['code_camion']."</td>";
              $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->row();
              echo "<td>".$getArticle->type_huile."</td>
              <td>".$getArticle->huile."</td>";
              $prixTotal = $row['pu'] *$row['qtite'];
             echo" <td>".number_format($row['pu'],0,',',' ')."</td>
             <td>".number_format($prixTotal,0,',',' ')."</td>
              <td>".$row['date_vidange']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }
if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange <="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange <="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
      // $getPrime = $this->db->query("SELECT * FROM vidangeBoite where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...

        echo "<tr><td>".$compteur."</td>
             
              <td>".$row['code_camion']."</td>";
              $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->row();
              echo "<td>".$getArticle->type_huile."</td>
              <td>".$getArticle->huile."</td>";
              $prixTotal = $row['pu'] *$row['qtite'];
             echo" <td>".number_format($row['pu'],0,',',' ')."</td>
             <td>".number_format($prixTotal,0,',',' ')."</td>
              <td>".$row['date_vidange']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }
    $this->db->close();
  }

public function selectAllTotalVidangeOperationPourBalance(){
    $id_operation = $_POST["id_operation"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM vidange where id_operation =".$id_operation."")->result_array();
    $compteur = 0;
    $montant = 0;
    $total = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
   
              $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
            foreach ($getArticle as $tab1) {
              # code...
              $montant =  $row["qtite"] * $row['pu'];
            }
          $total = $total + $montant;  
      }
    }else{
      // echo "nada";
    }
if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange <="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange <="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
      // $getPrime = $this->db->query("SELECT * FROM vidangeHydrolique where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...

              $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
              foreach ($getArticle as $tab1) {
              # code...
              $montant =  $row["qtite"] * $row['pu'];
            }
          $total = $total + $montant; 
      }
    }else{
      // echo "nada";
    }
if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange <="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange <="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
      // $getPrime = $this->db->query("SELECT * FROM vidangeBoite where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # co
              $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
               foreach ($getArticle as $tab1) {
              # code...
              $montant =  $row["qtite"] * $row['pu'];
            }
          $total = $total + $montant; 
      }
    }else{
      // echo "nada";
    }
    return $total;

    $this->db->close();
  }

 public function selectAllTotalFactureOperationPourBalance(){
          $id_operation = $_POST["id_fournisseur"];

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl<="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl<="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
$compteur = 0;
$total = 0;
$montant=0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {

        $total = $row['quantite']*$row['prix_unitaire'];
        $montant = $total+ $montant;
      }
    }else{
      // echo "nada";
    }

        return $montant;

        $this->db->close();
    }

     public function selectAllTotalChargementOperationPourBalance(){
          $id_operation = $_POST["id_operation"];

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg<="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg<="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
$compteur = 0;
$total = 0;
$montant=0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {

        $montant  = $montant + $row['montant'];
        
      }
    }else{
      // echo "nada";
    }

        return $montant;

        $this->db->close();
    }

    public function selectAllTotalPrimeOperationPourBalance(){
    $id_operation = $_POST["id_operation"];
    $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime <="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime <="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
$compteur = 0;
$total = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $total = $total+$row["montant"];
      
        $compteur++;
      }
      
    }else{
      // echo "nada";
    }
    return $total;

    $this->db->close();
  }

   public function selectAllTotalFraisRouteOperationPourBalance(){
    $id_operation = $_POST["id_operation"];
    $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM frais_route where id_operation =".$id_operation."")->result_array();
$compteur = 0;
$total = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $total = $total+$row["montant"];
        
        $compteur++;
      }
    }else{
      // echo "nada";
    }

    return $total;

    $this->db->close();
  }

     public function selectAllTotalFraisDiversOperationPourBalance(){
    $id_operation = $_POST["id_operation"];
    $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM frais_divers where id_operation =".$id_operation."")->result_array();
$compteur = 0;
$total = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $total = $total+$row["montant"];
        
        $compteur++;
      }
    }else{
      // echo "nada";
    }

    return $total;

    $this->db->close();
  }

 public function selectAllTotalPieceRechangeOperationPourBalance(){
    $id_operation = $_POST["id_operation"];
    $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM piece_rechange where id_operation =".$id_operation."")->result_array();
$compteur = 0;
$total = 0;
$montant = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $getPrixUnitaire = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->result_array();

        foreach ($getPrixUnitaire as $tab) {
          # code...
          $montant = $tab["prix_unitaire"]* $row["qtite"];
        }

        $total = $total+$montant;
        
        $compteur++;
      }
    }else{
      // echo "nada";
    }

    return $total;

    $this->db->close();
  }


 public function selectAllTotalGazoilOperationPourBalance(){
    $id_operation = $_POST["id_operation"];
    $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM gazoil where id_operation =".$id_operation."")->result_array();
$compteur = 0;
$total = 0;
$montant = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $montant = $row["litrage"]*$row["prix_unitaire"];
        $total = $total + $montant;
        $compteur++;
      }
    }else{
      // echo "nada";
    }

    return $total;

    $this->db->close();
  }

  public function selectAllGazoilOperationPourBalance(){
    $id_operation = $_POST["id_operation"];
    $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM gazoil where id_operation =".$id_operation."")->result_array();
    $compteur = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $getDistance = $this->db->query("SELECT * from distance_littrage where id_distance=".$row['id_distance']."")->row();
        echo "<tr><td>".$compteur."</td>
             
              <td>".$row['code_camion']."</td>
              <td>".$row['numero']."</td>
              <td>".$row['litrage']."</td>
              <td>".number_format($row['prix_unitaire'],0,',',' ')."</td>
              <td>".$getDistance->distance."</td>
              <td>".$getDistance->kilometrage."</td>
               <td>".number_format($row['prix_unitaire']*$row['litrage'],0,',',' ')."</td>
              <td>".$row['date_gazoil']."</td>";
             
        $compteur++;
      }
    }else{
      // echo "nada";
    }

    $this->db->close();
}


public function totalDepenseParOperation(){
  $id_operation = $_POST["id_operation"];
    $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM gazoil where id_operation =".$id_operation."")->result_array();
$compteur = 0;
$total = 0;
$montant = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $montant = $row["litrage"]*$row["prix_unitaire"];
        $total = $total + $montant;
        $compteur++;
      }
    }else{
      // echo "nada";
    }

// piece de rechange
            if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM piece_rechange where id_operation =".$id_operation."")->result_array();
$compteur = 0;
$total1 = 0;
$montant1 = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $getPrixUnitaire = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->result_array();

        foreach ($getPrixUnitaire as $tab) {
          # code...
          $montant1 = $row["prix_unitaire"]* $row["qtite"];
        }

        $total1 = $total1+$montant1;
        
        $compteur++;
      }
    }else{
      // echo "nada";
    }

  // frais divers
            if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM frais_divers where id_operation =".$id_operation."")->result_array();
$compteur = 0;
$total2 = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $total2 = $total2+$row["montant"];
        
        $compteur++;
      }
    }else{
      // echo "nada";
    }

    // echo $total." FCFA";
// frais de route

            if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM frais_route where id_operation =".$id_operation."")->result_array();
$compteur = 0;
$total3 = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $total3 = $total3+$row["montant"];
        
        $compteur++;
      }
    }else{
      // echo "nada";
    }
// total prime
            if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime1 = $this->db->query('SELECT * FROM prime WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime1 = $this->db->query('SELECT * FROM prime WHERE  date_prime >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime1 = $this->db->query('SELECT * FROM prime WHERE  date_prime <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime1 = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime1 = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime1 = $this->db->query('SELECT * FROM prime WHERE  date_prime <="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime1 = $this->db->query('SELECT * FROM prime WHERE  date_prime <="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
$compteur = 0;
$total4 = 0;
    if (count($getPrime1) >0 ) {
      # code...
      foreach ($getPrime1 as $row) {
        # code...
        $total4 = $total4+$row["montant"];
      
        $compteur++;
      }
      
    }else{
      // echo "nada";
    }


// total vidange
      if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM vidange where id_operation =".$id_operation."")->result_array();
    $compteur = 0;
    $montant5 = 0;
    $total5 = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
   
              $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
            foreach ($getArticle as $tab1) {
              # code...
              $montant5 =  $row["qtite"] * $row['pu'];
            }
          $total5 = $total5 + $montant5;  
      }
    }else{
      // echo "nada";
    }
if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange <="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange <="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
      // $getPrime = $this->db->query("SELECT * FROM vidangeHydrolique where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...

              $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
              foreach ($getArticle as $tab1) {
              # code...
              $montant5 =  $row["qtite"] * $row['pu'];
            }
          $total5 = $total5 + $montant5; 
      }
    }else{
      // echo "nada";
    }
if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  id_operation='.$id_operation.'')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange <="'.$date_fin.'" and id_operation='.$id_operation.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange <="'.$date_debut.'" and id_operation='.$id_operation.'')->result_array();

        }
      // $getPrime = $this->db->query("SELECT * FROM vidangeBoite where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row){
        # co
              $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
               foreach ($getArticle as $tab1) {
              # code...
              $montant5 =  $row["qtite"] * $row['pu'];
            }
          $total5 = $total5 + $montant5; 
      }
    }else{
      // echo "nada";
    }
    // echo $total." FCFA";
 $somme = $total+$total1+$total2+$total3+$total4+$total5;

 return $somme;

 $this->db->close();
 }


 public function getSolde(){
  echo $this->selectAllTotalChargementOperationPourBalance()+$this->selectAllTotalFactureOperationPourBalance()+$this->selectAllTotalLocationEnginOperationPourBalance()+$this->selectAllTotalVentePiecesOperationPourBalance()-$this->totalDepenseParOperation();

  $this->db->close();
 }

  public function getProduitOperation(){
        $id_operation=$_POST['id_operation'];
        $query = $this->db->query("SELECT * from operation where id_operation=".$id_operation."")->row();

        echo $query->produit;

        $this->db->close();
    }
public function getClientOperation(){
        $id_operation=$_POST['id_operation'];
        $query = $this->db->query("SELECT * from operation where id_operation=".$id_operation."")->row();
        $getClient = $this->db->query("SELECT * from client where id_client=".$query->id_client."")->row();
        echo $getClient->nom;

        $this->db->close();
    }

public function getDateCreationOperation(){
        $id_operation=$_POST['id_operation'];
        $query = $this->db->query("SELECT * from operation where id_operation=".$id_operation."")->row();

        echo $query->date_creation;

        $this->db->close();
    }

public function getFactureOperationParLocationEngin(){
         $id_operation=$_POST['id_operation'];
         $getAllEngin = $this->db->query("SELECT * from location_engin where id_operation = ".$id_operation."")->result_array();

         $montant = 0;

         if (count($getAllEngin)>0) {
             # code...
            echo '<table style="width:100%; " class="table table-bordered table-striped "><thead> <tr>
                  
                  </tr>
                  
                  <tr style="background: white; color: black; font-size: 18px; font-weight: bold; " >
                    
                    <td style="border-bottom: : 1px solid black; text-align: center;border-bottom: 3px solid black; ">Code engin</td>
					<td style="border-bottom: : 1px solid black; text-align: center;border-bottom: 3px solid black; ">Immat.</td>
                    <td style="border-left: 1px solid white;  text-align: center;border-bottom: 3px solid black; ">Durée</td>
                    <td style="border-left: 1px solid white; text-align: center;border-bottom: 3px solid black; ">PU</td>
                    <td style="border-left: 1px solid white; text-align: center;border-bottom: 3px solid black; ">Montant</td>
                    <td style="border-left: 1px solid white; text-align: center;border-bottom: 3px solid black; ">Date</td>
                    <td style="border-left: 1px solid white; text-align: center;border-bottom: 3px solid black; ">Destination</td>
                    
                    <br/>
                  </tr></thead><tbody>';
            foreach ($getAllEngin as $row) {
             # code...
                echo'<tr style="text-align: center; ">
                     <td>'.$row["code"].'</td>';
					 
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

                    echo'
					 
					 
                     <td>'.$row["duree"].' '.$row["unite"].'</td>
                     <td>'.number_format($row['montant'],0,',',' ').'</td>
                     <td>'.number_format($row['montant']*$row["duree"],0,',',' ').'</td>
                     <td>'.$row["date_location"].'</td>
                     <td>'.$row["date_location"].'</td>
                </tr>';

                $montant= $montant + $row['montant']*$row["duree"];
             }
             echo'
             <tr style="text-align: center; border:2px soli black;">
                     <td>MONTANT TOTAL</td>
                     <td colspan="3" style="color: red; border:2px soli black;">'.$montant.'</td>
                </tr>
             </tbody>
             </table>';
         }

         $this->db->close();
         
    }

public function getFactureOperationParChargementRetour(){
             $id_operation=$_POST['id_operation'];
         $getAllEngin = $this->db->query("SELECT * from bon_livraison where id_operation = ".$id_operation."")->result_array();

         $montant = 0;
		 $montant1 = 0;
		 $montant2 = 0;
         if (count($getAllEngin)>0) {
             # code...
            echo '<table style="width:100%; " class="table table-bordered table-striped "><thead> 
                  
                  <tr style="background: white; color: black; font-size: 18px; font-weight: bold; " >
                    <td style="border-left: 1px solid white; text-align: center;border-bottom: 3px solid black; ">Date</td>

                    <td style="border-bottom: : 1px solid black;width: 13%; text-align: center;border-bottom: 3px solid black; ">Code</td>
					
					<td style="border-bottom: : 1px solid black;width: 13%; text-align: center;border-bottom: 3px solid black; ">Immat.</td>

                    <td  style="  text-align: center;border-bottom: 3px solid black; ">N° BL<br/></td>

					<td style="border-left: 1px solid white; text-align: center;border-bottom: 3px solid black; ">Client</td>

                    <td style="border-left: 1px solid white; text-align: center;border-bottom: 3px solid black; ">Départ</td>

                    <td style="border-left: 1px solid white; text-align: center;border-bottom: 3px solid black; ">Arrivée</td>

                    <td style="border-left: 1px solid white; text-align: center;border-bottom: 3px solid black; ">Unite</td>

                    <td style="border-left: 1px solid white;  text-align: center;border-bottom: 3px solid black; ">Qté</td>

                    <td style="border-left: 1px solid white; text-align: center;border-bottom: 3px solid black; ">Prix.U</td>

                    <td style="border-left: 1px solid white; text-align: center;border-bottom: 3px solid black; ">Total</td>


                    

                    
                    <br/>
                  </tr></thead><tbody>';
            foreach ($getAllEngin as $row) {
             # code...
                $getDistance = $this->db->query("SELECT * FROM distance_littrage where id_distance = ".$row['id_destination_litrage']."")->row();
                echo'<tr style="text-align: center; ">
                <td>'.$row["date_bl"].'</td>
                     <td>'.$row["code_camion"].'</td>';
					 
					 
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

                    echo'
					 
					 
					 
                     <td>'.$row["numero"].'</td>
					 <td>'.$row["destinataire"].'</td>
                     <td>'.$row["depart"].'</td>
                     <td>'.$getDistance->distance.'</td>
                     
                     <td>'.$row["unite"].'</td>
                     <td>'.$row["quantite"].'</td>
                     <td>'.number_format($row['prix_unitaire'],0,',',' ').'</td>
                     <td>'.number_format($row['prix_unitaire']*$row["quantite"],0,',',' ').'</td>
                     
                     
                     
                </tr>';
                $montant= $montant + $row['prix_unitaire']*$row["quantite"];
				$montant1= $montant1+1;
				$montant2= $montant2+$row["quantite"];
             }
             echo '<tr style="text-align: center; ">
                     <td  style="font-size: 25px; color: red; border:2px soli black;"></td>
                     <td  style="text-align: center;font-size: 25px; color: red; border:2px soli black;"></td>
					 <td  style="font-size: 25px; color: red; border:2px soli black;"></td>
                     <td  style="text-align: center;font-size: 18px; color: red; border:2px soli black;">'.number_format($montant1,0,',',' ').'</td>
					 <td  style="font-size: 25px; color: red; border:2px soli black;"></td>
                     <td  style="text-align: center;font-size: 25px; color: red; border:2px soli black;"></td>
					 <td  style="font-size: 25px; color: red; border:2px soli black;"></td>
                     <td  style="text-align: center;font-size: 25px; color: red; border:2px soli black;"></td>
					 <td  style="font-size: 18px; color: red; border:2px soli black;">'.number_format($montant2,0,',',' ').'</td>
                     <td  style="text-align: center;font-size: 25px; color: red; border:2px soli black;"></td>
					  <td  style="text-align: center;font-size: 25px; color: red; border:2px soli black;"></td>
                </tr>
				
				<tr style="text-align: center; ">
                     <td colspan="6" style="font-size: 25px; color: red; border:2px soli black;">MONTANT TOTAL</td>
                     <td colspan="5" style="text-align: right;font-size: 25px; color: red; border:2px soli black;">'.number_format($montant,0,',',' ').'</td>
                </tr>
             </tbody>
             </table>';
         }

         $this->db->close();
}

public function netPayer(){
    $id_operation=$_POST['id_operation'];
         $getAllEngin = $this->db->query("SELECT * from bon_livraison where id_operation = ".$id_operation."")->result_array();
         $getAllEngin2 = $this->db->query("SELECT * from location_engin where id_operation = ".$id_operation."")->result_array();

         $montant = 0;
         $montant1 = 0;

    if (count($getAllEngin) > 0) {
        # code...
        foreach ($getAllEngin as $row) {
            # code...
            $montant = $montant + $row['quantite']*$row["prix_unitaire"];
        }
    }

    if (count($getAllEngin2)>0) {
        # code...

        foreach ($getAllEngin2 as $row) {
            # code...
            $montant1= $montant1 + $row['montant']*$row["duree"];
        }
    }

     echo '<table style="width:100%; " class="table table-bordered table-striped "><thead> 
                  
             <!--     <tr style="background: white; color: black; font-size: 18px; font-weight: bold; " >
                    <th colspan="2"  style="text-align: center;font-size: 25px;color: red; border:2px ;">PRIX TOTAL<br/></th>
                    
					<th colspan="2"  style="text-align: center;font-size: 25px;color: red; border:2px ;"">'.number_format($montant1+$montant,0,',',' ').'</th>
                    
                    
                    <br/>
                  </tr> -->
                  </thead>
                  <tr style="background: white; color: black; font-size: 18px; font-weight: bold; " >
                    <td  style="  text-align: right; " colspan="3"></td>
                    
                    <td  style="  text-align: right; font-size: 25px;"colspan="3">LA DIRECTION<br/></td>
                    <br/>
                  </tr>
                  <tbody>
                 
             </tbody>
             </table>';

             $this->db->close();
}


public function deleteOperation($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé l'opération ".$getCamion->nom_op." le ".$date_notif." à ".$heure;


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

  public function deleteChargementRetour($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé le chargement retour N° ".$getCamion->numero." et de code camion ".$getCamion->code_camion." de la date du ".$getCamion->date_charg." le ".$date_notif." à ".$heure;


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

 public function deleteLocationEngin($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé la location engin d'un montant de ".$getCamion->montant." et de code camion ".$getCamion->code." de la date du ".$getCamion->date_location." le ".$date_notif." à ".$heure;


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