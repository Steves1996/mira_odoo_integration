<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model_matiere extends CI_Model {
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

 public function addClient(){
        $nom = $_POST["nom"];
        $telephone = $_POST["telephone"];
        $adresse = $_POST["adresse"];
        $status = $_POST["status"];
        $nui = $_POST["nui"];
        $date_init = $_POST["date_init"];
        $montant_init =  preg_replace('/\s/','', $_POST["montant_init"]);


    $nom_table = "client";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté le client dénommé ".$nom.", de NIU ".$nui." et téléphone ".$telephone." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié le client dénommé ".$nom.", de NIU ".$nui." et téléphone ".$telephone." le ".$date_notif." à ".$heure;

        if ($status =="insert") {
            # code...

                $requete = $this->db->query("SELECT * from client where telephone =".$telephone."")->result_array();
                if (count($requete)>0) {
                    # code...
                    echo "Ce numéro de téléphone est déjà utilisé veuillez changer";
                }else{
                    $query1 = $this->db->query("insert into clientmp value('','". $nom. "',". $telephone.",'".$adresse."','".$nui."',".$montant_init.",CAST('". $date_init."' AS DATE))");
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
                $requete = $this->db->query("SELECT * from client where telephone =".$telephone."")->result_array();
                if (count($requete)>0) {
                    # code...
                   foreach ($requete as $row) {
                       # code...
                        if ($row["id_client"] == $id_client) {
                            # code...
                            $query1 = $this->db->query("UPDATE clientmp set telephone=".$telephone.", adresse='".$adresse."', nom='".$nom."',nui='".$nui."', date_init = CAST('". $date_init."' AS DATE),montant_init=".$montant_init." where id_client=".$id_client."");
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
                    $query1 = $this->db->query("UPDATE clientmp set telephone=".$telephone.", adresse='".$adresse."', nom='".$nom."', nui='".$nui."', date_init = CAST('". $date_init."' AS DATE),montant_init=".$montant_init." where id_client=".$id_client."");
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


public function selectAllClient(){
              $query1 = $this->db->query('SELECT * from client order by nom asc')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['nom']."
                    </td>
                    <td>".$row['adresse']."</td>
                    <td> ".$row['telephone']."</td>
                    <td> ".$row['nui']."</td>
					<td> ".$row['date_init']."</td>
					 <td> ".$row['montant_init']."</td>
                    
                    <td>";

                 if($this->session->userdata('client_modification')=='true'){
                    echo"<button type='button' onclick=\"infosClient('".$row['id_client']."','".$row['nom']."','".$row['adresse']."','".$row['telephone']."','".$row['nui']."','".$row['date_init']."','".$row['montant_init']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }

                if($this->session->userdata('client_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='clientmp' identifiant='".$row['id_client']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_client\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
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



public function addFournisseurMatiere(){
        $commentaire = addslashes($_POST['commentaire']);
        $nom = $_POST["nom"];
        $telephone = $_POST["telephone"];
        $adresse = $_POST["adresse"];
        $status = $_POST["status"];
		$date_initial = $_POST["date_initial"];
		$solde_initial = preg_replace('/\s/','', $_POST["solde_initial"]);


         $nom_table = "fournisseur_matiere";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté un fournisseur de matière première de nom ".$nom.", de téléphone ".$telephone.", le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié un fournisseur matière première de nom ".$nom.", de téléphone ".$telephone.", le ".$date_notif." à ".$heure;
    
        if ($status =="insert") {
            # code...
            // echo $telephone;
                $requete = $this->db->query("SELECT * from fournisseur_matiere where telephone =".$telephone."")->result_array();
                if (count($requete)>0) {
                    # code...
                    echo "Ce numéro de téléphone est déjà utilisé veuillez changer";
                }else{
                    $query1 = $this->db->query("insert into fournisseur_matiere value('','". $nom. "','".$adresse."',". $telephone.",'".$commentaire."',". $solde_initial.",CAST('". $date_initial."' AS DATE))");
                            if($query1 == true){
                                echo "Insertion parfaite du fournisseur";
                                $this->notificationAjout($nom_table,addslashes($message));
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                }
        }elseif ($status == "update") {
            # code...
            $id_client =$_POST["id_client"];
                $requete = $this->db->query("SELECT * from fournisseur_matiere where telephone =".$telephone."")->result_array();
                if (count($requete)>0) {
                    # code...
                   foreach ($requete as $row) {
                       # code...
                        if ($row["id_fournisseur"] == $id_client) {
                            # code...
                            $query1 = $this->db->query("UPDATE fournisseur_matiere set telephone=".$telephone.", adresse='".$adresse."', nom='".$nom."', commentaire = '".$commentaire."' ,montant_init = '".$solde_initial."', date_init = CAST('". $date_initial."' AS DATE) where id_fournisseur =".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du fournisseur";
                                $this->notificationAjout($nom_table,addslashes($message2));
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                        }else{
                            echo "Erreur ce numero de téléphone est déjà utilisé";
                        }
                   }
                }else{
                    $query1 = $this->db->query("UPDATE fournisseur_matiere set telephone=".$telephone.", adresse='".$adresse."', nom='".$nom."', commentaire = '".$commentaire."' ,montant_init = '".$solde_initial."', date_init = CAST('". $date_initial."' AS DATE) where id_fournisseur=".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du fournisseur";
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

    public function selectAllFournisseurMatiere(){
              $query1 = $this->db->query('SELECT * from fournisseur_matiere order by nom')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['nom']."
                    </td>
                    <td>".$row['adresse']."</td>
                    <td> ".$row['telephone']."</td>
					<td> ".$row['montant_init']."</td>
					<td> ".$row['date_init']."</td>
					<td> ".$row['commentaire']."</td>
                    <td>";

            if($this->session->userdata('mira_sa_modification')=='true'){
                    echo"<button type='button' onclick=\"infosClient1('".$row['id_fournisseur']."','".$row['nom']."','".$row['adresse']."','".$row['telephone']."','".$row['montant_init']."','".$row['date_init']."','".addslashes($row['commentaire'])."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }

            if($this->session->userdata('mira_sa_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='fournisseur_matiere' identifiant='".$row['id_fournisseur']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_fournisseur\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
              }
                  $compteur++;
        }

        $this->db->close();
    }

        public function leSelectFournisseurMatiere(){
        $query = $this->db->query("select * from fournisseur_matiere")->result_array();
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
	
	    public function leSelectClientMatiere(){
        $query = $this->db->query("select * from client where id_client IN (Select id_client From operation where filiale <> 'MIRA TRANSPORT')")->result_array();
        if (count($query) >0) {
           echo "<option value=''></option>";
		   
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_client"]."'>".$row["nom"]."</option>";
            }
        }else{

        }

        $this->db->close();
    }
	
	        public function leSelectNumeroFacture(){
        $query = $this->db->query("select DISTINCT (facture) AS numero from frais_achat GROUP BY facture")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["numero"]."'>".$row["numero"]."</option>";
            }
        }else{

        }

        $this->db->close();
    }
	
	public function verifiDateInitialClient(){
  $id_client = $_POST["id_client"];
  $date_initial = $_POST["date_initial"];

  $query = $this->db->query("SELECT * from fournisseur_matiere where id_fournisseur=".$id_client."")->row();

if (count($query)>0) {
  # code...
  if ($date_initial < date("Y-m-d",strtotime($query->date_init))) {
    # code...
    return "La date de début doit etre supérieure ou égale à la date dinitialisation du client";
  }else{
    return 'ok';
  }
 }else{
  return "Erreur contactez l'administrateur";
 }
}

	public function verifiDateInitialClient1(){
  $id_client = $_POST["id_client"];
  $date_initial = $_POST["date_initial"];

  $query = $this->db->query("SELECT * from client where id_client=".$id_client."")->row();

if (count($query)>0) {
  # code...
  if ($date_initial < date("Y-m-d",strtotime($query->date_init))) {
    # code...
    return "La date de début doit etre supérieure ou égale à la date dinitialisation du client";
  }else{
    return 'ok';
  }
 }else{
  return "Erreur contactez l'administrateur";
 }
}

	
	public function getDateInitialClient(){
  $id_client = $_POST["id_client"];

  $query = $this->db->query("SELECT * from fournisseur_matiere where id_fournisseur=".$id_client."")->row();

if (count($query)>0) {
  # code...
  return $query->date_init;
 }else{

 }
}

public function getDateInitialClient1(){
  $id_client = $_POST["id_client"];

  $query = $this->db->query("SELECT * from client where id_client=".$id_client."")->row();

if (count($query)>0) {
  # code...
  return $query->date_init;
 }else{

 }
}        

public function getSoldeInitialClient(){
  $id_client = $_POST["id_client"];

  $query = $this->db->query("SELECT * from fournisseur_matiere where id_fournisseur=".$id_client."")->row();

if (count($query)>0) {
  # code...
  return $query->montant_init;
 }else{
  return 0;
 }
}

public function getSoldeInitialClient1(){
  $id_client = $_POST["id_client"];

  $query = $this->db->query("SELECT * from client where id_client=".$id_client."")->row();

if (count($query)>0) {
  # code...
  return $query->montant_init;
 }else{
  return 0;
 }
}

public function getClient($id_client){
  $query = $this->db->query("SELECT * from fournisseur_matiere where id_fournisseur =".$id_client."")->row();
  if (count($query)>0) {
    # code...
    return $query->nom;
  }
}

public function getClient1($id_client){
  $query = $this->db->query("SELECT * from client where id_client =".$id_client."")->row();
  if (count($query)>0) {
    # code...
    return $query->nom;
  }
}

public function getAdresseClient($id_client){
  $query = $this->db->query("SELECT * from fournisseur_matiere where id_fournisseur =".$id_client."")->row();
  if (count($query)>0) {
    # code...
    return $query->adresse;
  }
}

public function getAdresseClient1($id_client){
  $query = $this->db->query("SELECT * from client where id_client=".$id_client."")->row();
  if (count($query)>0) {
    # code...
    return $query->adresse;
  }
}

public function getVilleClient($id_client){
  $query = $this->db->query("SELECT * from fournisseur_matiere where id_fournisseur =".$id_client."")->row();
  if (count($query)>0) {
    # code...
    return $query->ville;
  }
}

public function getVilleClient1($id_client){
  $query = $this->db->query("SELECT * from client where id_client =".$id_client."")->row();
  if (count($query)>0) {
    # code...
    return $query->ville;
  }
}

public function getTelephoneClient($id_client){
  $query = $this->db->query("SELECT * from fournisseur_matiere where id_fournisseur =".$id_client."")->row();
  if (count($query)>0) {
    # code...
    return $query->telephone;
  }
}

public function getTelephoneClient1($id_client){
  $query = $this->db->query("SELECT * from client where id_client =".$id_client."")->row();
  if (count($query)>0) {
    # code...
    return $query->telephone;
  }
}

public function getFournisseur(){

  $facture =$_POST["facture"];
  
  $query = $this->db->query("SELECT id_fournisseur from frais_achat where facture ='".$facture."'")->row();
  if (count($query)>0) {
    # code...
    $fournisseur = $query->id_fournisseur;
  }
  
   $query = $this->db->query("SELECT nom from fournisseur_matiere where id_fournisseur =".$fournisseur."")->row();
  if (count($query)>0) {
    # code...
 return $query->nom;
  }
  
  
}

public function getMontant(){

  $facture =$_POST["facture"];
  
  $query = $this->db->query("SELECT SUM(montant*quantite) AS somme from frais_achat where facture ='".$facture."'")->row();
  if (count($query)>0) {
    # code...
   return $query->somme;
   
   }   
  }
  

  


public function soldeCaisseClient2(){
    echo $this->repportNouveau3()-$this->selectAllTotalAccuseReglementPourBalanceClient()+$this->totalFacturePourBalanceClient();
}

public function soldeCaisseClient2_1(){
    echo $this->repportNouveau3_1()-$this->selectAllTotalAccuseReglementPourBalanceClient1()+$this->totalFacturePourBalanceClient1();
}

public function repportNouveau3(){

    $id_fournisseur = $_POST["id_fournisseur"];
    $id_client = $_POST["id_fournisseur"];

        
        $date_fin =date("Y-m-d",strtotime($_POST["date_debut"].'- 1 day'));
        $date_fin = strval($date_fin);
    $getDateInitialClient = $this->db->query("SELECT * from fournisseur_matiere where id_fournisseur=".$id_client."")->row();
    $soldeInitial=0;
if (count($getDateInitialClient)>0) {
  # code...
  $soldeInitial= $getDateInitialClient->montant_init;
  $date_debut = $getDateInitialClient->date_init;
 }else{
  $date_debut = "";
 }
 // echo $date_fin;
  return $soldeInitial-$this->selectAllTotalAccuseReglementPourRepport($id_fournisseur,$date_debut, $date_fin )+$this->totalFacturePourRepport($id_fournisseur,$date_debut, $date_fin );
}

public function repportNouveau3_1(){

    $id_fournisseur = $_POST["id_fournisseur"];
    $id_client = $_POST["id_fournisseur"];

        
        $date_fin =date("Y-m-d",strtotime($_POST["date_debut"].'- 1 day'));
        $date_fin = strval($date_fin);
    $getDateInitialClient = $this->db->query("SELECT * from client where id_client=".$id_client."")->row();
    $soldeInitial=0;
if (count($getDateInitialClient)>0) {
  # code...
  $soldeInitial= $getDateInitialClient->montant_init;
  $date_debut = $getDateInitialClient->date_init;
 }else{
  $date_debut = "";
 }
 // echo $date_fin;
  return $soldeInitial-$this->selectAllTotalAccuseReglementPourRepport1($id_fournisseur,$date_debut, $date_fin )+$this->totalFacturePourRepport1($id_fournisseur,$date_debut, $date_fin );
}

public function selectAllTotalAccuseReglementPourRepport($id_fournisseur,$date_debut, $date_fin ){
      
        $montant = 0;
     

        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT  * FROM reglement_achat WHERE id_fournisseur = '.$id_fournisseur.' order by date_reg asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_achat WHERE  date_reg>="'.$date_debut.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_achat WHERE date_reg<="'.$date_fin.'" order by date_reg asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_achat WHERE date_reg between "'.$date_debut.'" and "'.$date_fin.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_achat WHERE id_fournisseur = '.$id_fournisseur.' and date_reg between "'.$date_debut.'" and "'.$date_fin.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_achat WHERE id_fournisseur = '.$id_fournisseur.' and date_reg<="'.$date_fin.'" order by date_reg asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_achat WHERE id_fournisseur = '.$id_fournisseur.' and date_reg>="'.$date_debut.'" order by date_reg asc')->result_array();

        }
         $compteur = 0;
         
        foreach ($query1 as $tab) {
        $montant = $montant+$tab['montant'];
                         
        }
       
 return $montant;
}

public function selectAllTotalAccuseReglementPourRepport1($id_fournisseur,$date_debut, $date_fin ){
      
        $montant = 0;
     

        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT  * FROM reglement_matiere WHERE id_client = '.$id_fournisseur.' order by date_reg asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_matiere WHERE  date_reg>="'.$date_debut.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_matiere WHERE date_reg<="'.$date_fin.'" order by date_reg asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_matiere WHERE date_reg between "'.$date_debut.'" and "'.$date_fin.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_matiere WHERE id_client = '.$id_fournisseur.' and date_reg between "'.$date_debut.'" and "'.$date_fin.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_matiere WHERE id_client = '.$id_fournisseur.' and date_reg<="'.$date_fin.'" order by date_reg asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_matiere WHERE id_client = '.$id_fournisseur.' and date_reg>="'.$date_debut.'" order by date_reg asc')->result_array();

        }
         $compteur = 0;
         
        foreach ($query1 as $tab) {
        $montant = $montant+$tab['montant'];
                         
        }
       
 return $montant;
}


public function totalFacturePourRepport($id_fournisseur,$date_debut, $date_fin ){
  $date = date('Y-m-d');

       if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT  * FROM frais_achat WHERE id_fournisseur='.$id_fournisseur.' order by date_frais asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM frais_achat WHERE  date_frais>="'.$date_debut.'" order by date_frais asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM frais_achat WHERE date_frais<="'.$date_fin.'" order by date_frais asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM frais_achat WHERE date_frais between "'.$date_debut.'" and "'.$date_fin.'" order by date_frais asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM frais_achat WHERE id_fournisseur ='.$id_fournisseur.' and date_frais between "'.$date_debut.'" and "'.$date_fin.'" order by date_frais asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM frais_achat WHERE id_fournisseur='.$id_fournisseur.' and date_frais<="'.$date_fin.'" order by date_frais asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM frais_achat WHERE id_fournisseur ='.$id_fournisseur.' and date_frais>="'.$date_debut.'" order by date_frais asc')->result_array();

        }
         // $query1 = $this->db->query('SELECT * from commande group by num_com order by date_com asc')->result_array();
         $compteur = 0;
         $total = 0;
         $montant =0;
        foreach ($query1 as $row) {
            # code...
          
            # code...
          
             
              $montant = $row['total']+$montant;
                  $compteur++;
         
        }

        return $montant;
    }
	
	public function totalFacturePourRepport1($id_fournisseur,$date_debut, $date_fin ){
  $date = date('Y-m-d');

       if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT  * FROM bon_livraison1 WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = '.$id_fournisseur.') order by date_bl asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM bon_livraison1 WHERE  date_fact>="'.$date_debut.'" order by date_bl asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM bon_livraison1 WHERE date_fact<="'.$date_fin.'" order by date_bl asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM bon_livraison1 WHERE date_fact between "'.$date_debut.'" and "'.$date_fin.'" order by date_bl asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM bon_livraison1 WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = '.$id_fournisseur.') and date_bl between "'.$date_debut.'" and "'.$date_fin.'" order by date_bl asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM bon_livraison1 WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = '.$id_fournisseur.') and date_bl<="'.$date_fin.'" order by date_bl asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM bon_livraison1 WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = '.$id_fournisseur.') and date_bl>="'.$date_debut.'" order by date_bl asc')->result_array();

        }
         // $query1 = $this->db->query('SELECT * from commande group by num_com order by date_com asc')->result_array();
         $compteur = 0;
         $total = 0;
         $montant =0;
        foreach ($query1 as $row) {
            # code...
          
            # code...
          
             
              $montant = $row['quantite']*$row['prix_unitaire']+$montant;
                  $compteur++;
         
        }

        return $montant;
    }


public function selectAllTotalAccuseReglementPourBalanceClient(){
        $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

        $montant = 0;


      

        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT  * FROM reglement_achat WHERE id_fournisseur = '.$id_fournisseur.' order by date_reg asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_achat WHERE  date_reg>="'.$date_debut.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_achat WHERE date_reg<="'.$date_fin.'" order by date_reg asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_achat WHERE date_reg between "'.$date_debut.'" and "'.$date_fin.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_achat WHERE id_fournisseur = '.$id_fournisseur.' and date_reg between "'.$date_debut.'" and "'.$date_fin.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_achat WHERE id_fournisseur = '.$id_fournisseur.' and date_reg<="'.$date_fin.'" order by date_reg asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_achat WHERE id_fournisseur = '.$id_fournisseur.' and date_reg>="'.$date_debut.'" order by date_reg asc')->result_array();

        }
         $compteur = 0;
         
        foreach ($query1 as $tab) {
        $montant = $montant+$tab['montant'];
                         
        }
       
    
 return $montant;
}

public function selectAllTotalAccuseReglementPourBalanceClient1(){
        $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

        $montant = 0;


        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT  * FROM reglement_matiere WHERE id_client = '.$id_fournisseur.' order by date_reg asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_matiere WHERE  date_reg>="'.$date_debut.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_matiere WHERE date_reg<="'.$date_fin.'" order by date_reg asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_matiere WHERE date_reg between "'.$date_debut.'" and "'.$date_fin.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_matiere WHERE id_client = '.$id_fournisseur.' and date_reg between "'.$date_debut.'" and "'.$date_fin.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_matiere WHERE id_client = '.$id_fournisseur.' and date_reg<="'.$date_fin.'" order by date_reg asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_matiere WHERE id_client = '.$id_fournisseur.' and date_reg>="'.$date_debut.'" order by date_reg asc')->result_array();

        }
         $compteur = 0;
         
        foreach ($query1 as $tab) {
        $montant = $montant+$tab['montant'];
                         
        }
       
    
 return $montant;
}


public function totalFacturePourBalanceClient(){
  $date = date('Y-m-d');
     $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
       if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT  * FROM frais_achat WHERE id_fournisseur='.$id_fournisseur.' order by date_frais asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM frais_achat WHERE  date_frais>="'.$date_debut.'" order by date_frais asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM frais_achat WHERE date_frais<="'.$date_fin.'" order by date_frais asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM frais_achat WHERE date_frais between "'.$date_debut.'" and "'.$date_fin.'" order by date_frais asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM frais_achat WHERE id_fournisseur ='.$id_fournisseur.' and date_frais between "'.$date_debut.'" and "'.$date_fin.'" order by date_frais asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM frais_achat WHERE id_fournisseur='.$id_fournisseur.' and date_frais<="'.$date_fin.'" order by date_frais asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM frais_achat WHERE id_fournisseur ='.$id_fournisseur.' and date_frais>="'.$date_debut.'" order by date_frais asc')->result_array();

        }
         // $query1 = $this->db->query('SELECT * from commande group by num_com order by date_com asc')->result_array();
         $compteur = 0;
         $total = 0;
         $montant =0;
        foreach ($query1 as $row) {
            # code...
         
             
              $montant = $row['total']+$montant;
                  $compteur++;
               // }
        }

        return $montant;
    }

public function totalFacturePourBalanceClient1(){
  $date = date('Y-m-d');
     $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
       if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT  * FROM bon_livraison1 WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = '.$id_fournisseur.') order by date_bl asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM bon_livraison1 WHERE  date_bl>="'.$date_debut.'" order by date_bl asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM bon_livraison1 WHERE date_bl<="'.$date_fin.'" order by date_bl asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM bon_livraison1 WHERE date_bl between "'.$date_debut.'" and "'.$date_fin.'" order by date_bl asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM bon_livraison1 WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = '.$id_fournisseur.') and date_bl between "'.$date_debut.'" and "'.$date_fin.'" order by date_bl asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM bon_livraison1 WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = '.$id_fournisseur.') and date_bl<="'.$date_fin.'" order by date_bl asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM bon_livraison1 WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = '.$id_fournisseur.') and date_bl>="'.$date_debut.'" order by date_bl asc')->result_array();

        }
         // $query1 = $this->db->query('SELECT * from commande group by num_com order by date_com asc')->result_array();
         $compteur = 0;
         $total = 0;
         $montant =0;
        foreach ($query1 as $row) {
            # code...
         
             
              $montant = $row['quantite']*$row['prix_unitaire']+$montant;
                  $compteur++;
               // }
        }

        return $montant;
    }
	
public function repportNouveau($id_client){
  if (isset($id_client) || !empty($id_client)) {
    # code...
    $id_fournisseur = $id_client;
  }else{
    $id_fournisseur = $_POST["id_fournisseur"];
  }

        
        $date_fin =date("Y-m-d",strtotime($_POST["date_debut"].'- 1 day'));
        $date_fin = strval($date_fin);
    $getDateInitialClient = $this->db->query("SELECT * from fournisseur_matiere where id_fournisseur=".$id_client."")->row();
    $soldeInitial=0;
if (count($getDateInitialClient)>0) {
  # code...
  $soldeInitial= $getDateInitialClient->montant_init;
  $date_debut = $getDateInitialClient->date_init;
 }else{
  $date_debut = "";
 }
 // echo $date_fin;
  return $soldeInitial-$this->selectAllTotalAccuseReglementPourRepport($id_fournisseur,$date_debut, $date_fin )+$this->totalFacturePourRepport($id_fournisseur,$date_debut, $date_fin );
}

public function repportNouveau1($id_client){
  if (isset($id_client) || !empty($id_client)) {
    # code...
    $id_fournisseur = $id_client;
  }else{
    $id_fournisseur = $_POST["id_fournisseur"];
  }

        
        $date_fin =date("Y-m-d",strtotime($_POST["date_debut"].'- 1 day'));
        $date_fin = strval($date_fin);
    $getDateInitialClient = $this->db->query("SELECT * from client where id_client=".$id_client."")->row();
    $soldeInitial=0;
if (count($getDateInitialClient)>0) {
  # code...
  $soldeInitial= $getDateInitialClient->montant_init;
  $date_debut = $getDateInitialClient->date_init;
 }else{
  $date_debut = "";
 }
 // echo $date_fin;
  return $soldeInitial-$this->selectAllTotalAccuseReglementPourRepport1($id_fournisseur,$date_debut, $date_fin )+$this->totalFacturePourRepport1($id_fournisseur,$date_debut, $date_fin );
}

public function repportNouveauCredit($id_client){
  if (isset($id_client) || !empty($id_client)) {
    # code...
    $id_fournisseur = $id_client;
  }else{
    $id_fournisseur = $_POST["id_fournisseur"];
  }

        
        $date_fin =date("Y-m-d",strtotime($_POST["date_debut"].'- 1 day'));
        $date_fin = strval($date_fin);
    $getDateInitialClient = $this->db->query("SELECT * from fournisseur_matiere where id_fournisseur=".$id_client."")->row();
    $soldeInitial=0;
if (count($getDateInitialClient)>0) {
  # code...
  $soldeInitial= $getDateInitialClient->montant_init;
  $date_debut = $getDateInitialClient->date_init;
 }else{
  $date_debut = "";
 }
 // echo $date_fin;
  return $this->selectAllTotalAccuseReglementPourRepport($id_fournisseur,$date_debut, $date_fin );
}

public function repportNouveauCredit1($id_client){
  if (isset($id_client) || !empty($id_client)) {
    # code...
    $id_fournisseur = $id_client;
  }else{
    $id_fournisseur = $_POST["id_fournisseur"];
  }

        
        $date_fin =date("Y-m-d",strtotime($_POST["date_debut"].'- 1 day'));
        $date_fin = strval($date_fin);
    $getDateInitialClient = $this->db->query("SELECT * from client where id_client=".$id_client."")->row();
    $soldeInitial=0;
if (count($getDateInitialClient)>0) {
  # code...
  $soldeInitial= $getDateInitialClient->montant_init;
  $date_debut = $getDateInitialClient->date_init;
 }else{
  $date_debut = "";
 }
 // echo $date_fin;
  return $this->selectAllTotalAccuseReglementPourRepport1($id_fournisseur,$date_debut, $date_fin );
}



public function repportNouveauDebit($id_client){
  if (isset($id_client) || !empty($id_client)) {
    # code...
    $id_fournisseur = $id_client;
  }else{
    $id_fournisseur = $_POST["id_fournisseur"];
  }

        
        $date_fin =date("Y-m-d",strtotime($_POST["date_debut"].'- 1 day'));
        $date_fin = strval($date_fin);
    $getDateInitialClient = $this->db->query("SELECT * from fournisseur_matiere where id_fournisseur=".$id_client."")->row();
    $soldeInitial=0;
if (count($getDateInitialClient)>0) {
  # code...
  $soldeInitial= $getDateInitialClient->montant_init;
  $date_debut = $getDateInitialClient->date_init;
 }else{
  $date_debut = "";
 }
 // echo $date_fin;
  return $this->totalFacturePourRepport($id_fournisseur,$date_debut, $date_fin );
}


public function repportNouveauDebit1($id_client){
  if (isset($id_client) || !empty($id_client)) {
    # code...
    $id_fournisseur = $id_client;
  }else{
    $id_fournisseur = $_POST["id_fournisseur"];
  }

        
        $date_fin =date("Y-m-d",strtotime($_POST["date_debut"].'- 1 day'));
        $date_fin = strval($date_fin);
    $getDateInitialClient = $this->db->query("SELECT * from client where id_client=".$id_client."")->row();
    $soldeInitial=0;
if (count($getDateInitialClient)>0) {
  # code...
  $soldeInitial= $getDateInitialClient->montant_init;
  $date_debut = $getDateInitialClient->date_init;
 }else{
  $date_debut = "";
 }
 // echo $date_fin;
  return $this->totalFacturePourRepport1($id_fournisseur,$date_debut, $date_fin );
}

public function getCreditPourBalanceImpCLient(){
  return $this->selectAllTotalAccuseReglementPourBalanceClient();
}

public function getCreditPourBalanceImpCLient1(){
  return $this->selectAllTotalAccuseReglementPourBalanceClient1();
}

public function getDebitPourBalanceImpCLient(){
  return $this->totalFacturePourBalanceClient();
}
public function getDebitPourBalanceImpCLient1(){
  return $this->totalFacturePourBalanceClient1();
}

public function getSoldeBalanceImprimableClient(){
  $id_client = $_POST["id_fournisseur"];
  $date_debut = $_POST["date_debut"];
  $date_fin = $_POST["date_fin"];
  // $date_fin =date("Y-m-d",strtotime($_POST["date_debut"].'- 1 day'));
       
$i=0;

   
 
   $totalAccuseReglement =0;
   $totalFactureCLient = 0;
  
   $totalSolde =0;
   $totalDebit =0;
   $totalCredit =0;
   $solde = 0;
   
   $debit3=0;
   $credit3 = 0;
    $RN =$this->repportNouveau($id_client);
    $compteur = 0;
 

 while(date("Y-m-d",strtotime($_POST["date_debut"].'+ '.$i.' day')) <= $_POST["date_fin"]) { 
    # code...
    $date_debut = strval(date("Y-m-d",strtotime($_POST["date_debut"].'+ '.$i.' day')));
   

    $debit1 = 0;

$debit =0;
$credit = 0;



 // $getAllNumFactureClient = $this->db->query('SELECT * from facture_commercial where id_client = '.$id_client.' and date_frais ="'.$date_debut.'"')->result_array();
  $montant = 0;
  $total=0;

    $getAccuseReglement = $this->db->query('SELECT * from reglement_achat where id_fournisseur = '.$id_client.' and date_reg ="'.$date_debut.'"')->result_array();
  if (count($getAccuseReglement)>0) {
    # code...
      foreach ($getAccuseReglement as $reglement) {
    # code...
        $totalAccuseReglement =$reglement['montant']+$totalAccuseReglement;
        $credit1 =$reglement['montant'];
        $credit3 = $credit3 + $credit1;

    
          $RN =$RN-$credit1;
     
  $solde =$RN;

    $totalSolde = $totalSolde + $solde;
  }
  }

      $getFactureClient = $this->db->query("SELECT * from frais_achat where id_fournisseur=".$id_client." and date_frais='".$date_debut."' group by numero")->result_array();
  if (count($getFactureClient)>0) {
    # code...
      foreach ($getFactureClient as $factureClient) {
    # code...
        // $solde =$this->getSoldeInitialClient()+$this->getTotalAccuseReglementParClientPourBalance($id_client,$date_debut,$date_fin)+$this->getTotalAvisCreditParClientPourBalance($id_client,$date_debut,$date_fin)-$this->getTotalAvisDebitParClientPourBalance($id_client,$date_debut,$date_fin)-$this->getTotalAccuseRetraitParClientPourBalance($id_client,$date_debut,$date_fin)-$this->getTotalFactureParClientPourBalance($id_client,$date_debut)-$this->getTotalFactureArticleParClientPourBalance($id_client,$date_debut);
        
		$totalFactureCLient =$factureClient['total']+$totalFactureCLient;
  
$debit = $factureClient['total'];

$debit3 = $debit+$debit3;

     
          $RN =$RN+$debit;
       
  $solde =$RN;

        $totalSolde = $totalSolde + $solde;
  }


  }


  
$totalDebit = $debit3;
$totalCredit = $credit3;
// $totalSolde = $totalSolde + $solde;
   $i++;   
   $compteur++;
  }
  return $solde;

  }
//BALANCE IMPRIMABLE CLIENT

public function getSoldeBalanceImprimableClient1(){
  $id_client = $_POST["id_fournisseur"];
  $date_debut = $_POST["date_debut"];
  $date_fin = $_POST["date_fin"];
  // $date_fin =date("Y-m-d",strtotime($_POST["date_debut"].'- 1 day'));
       
$i=0;

   
 
   $totalAccuseReglement =0;
   $totalFactureCLient = 0;
  
   $totalSolde =0;
   $totalDebit =0;
   $totalCredit =0;
   $solde = 0;
   
   $debit3=0;
   $credit3 = 0;
    $RN =$this->repportNouveau1($id_client);
    $compteur = 0;
 

 while(date("Y-m-d",strtotime($_POST["date_debut"].'+ '.$i.' day')) <= $_POST["date_fin"]) { 
    # code...
    $date_debut = strval(date("Y-m-d",strtotime($_POST["date_debut"].'+ '.$i.' day')));
   

    $debit1 = 0;

$debit =0;
$credit = 0;



 // $getAllNumFactureClient = $this->db->query('SELECT * from facture_commercial where id_client = '.$id_client.' and date_frais ="'.$date_debut.'"')->result_array();
  $montant = 0;
  $total=0;

    $getAccuseReglement = $this->db->query('SELECT * from reglement_matiere where id_client = '.$id_client.' and date_reg ="'.$date_debut.'"')->result_array();
  if (count($getAccuseReglement)>0) {
    # code...
      foreach ($getAccuseReglement as $reglement) {
    # code...
        $totalAccuseReglement =$reglement['montant']+$totalAccuseReglement;
        $credit1 =$reglement['montant'];
        $credit3 = $credit3 + $credit1;

    
          $RN =$RN-$credit1;
     
  $solde =$RN;

    $totalSolde = $totalSolde + $solde;
  }
  }

      $getFactureClient = $this->db->query("SELECT * from bon_livraison1 WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = ".$id_client.") and date_bl='".$date_debut."' group by numero")->result_array();
  if (count($getFactureClient)>0) {
    # code...
      foreach ($getFactureClient as $factureClient) {
    # code...
        // $solde =$this->getSoldeInitialClient()+$this->getTotalAccuseReglementParClientPourBalance($id_client,$date_debut,$date_fin)+$this->getTotalAvisCreditParClientPourBalance($id_client,$date_debut,$date_fin)-$this->getTotalAvisDebitParClientPourBalance($id_client,$date_debut,$date_fin)-$this->getTotalAccuseRetraitParClientPourBalance($id_client,$date_debut,$date_fin)-$this->getTotalFactureParClientPourBalance($id_client,$date_debut)-$this->getTotalFactureArticleParClientPourBalance($id_client,$date_debut);
        
		$totalFactureCLient =$factureClient['quantite']*$factureClient['prix_unitaire']+$totalFactureCLient;
  
$debit = $factureClient['quantite']*$factureClient['prix_unitaire'];

$debit3 = $debit+$debit3;
  
    $RN =$RN+$debit;
       
  $solde =$RN;

        $totalSolde = $totalSolde + $solde;
  }


  }


  
$totalDebit = $debit3;
$totalCredit = $credit3;
// $totalSolde = $totalSolde + $solde;
   $i++;   
   $compteur++;
  }
  return $solde;

  }
//BALANCE IMPRIMABLE CLIENT

	
public function getBalanceImprimableClient(){
  $id_client = $_POST["id_fournisseur"];
  $date_debut = $_POST["date_debut"];
  $date_fin = $_POST["date_fin"];
  // $date_fin =date("Y-m-d",strtotime($_POST["date_debut"].'- 1 day'));
       
$i=0;

   
  
   $totalAccuseReglement =0;
   $totalFactureCLient = 0;
   
   $totalSolde =0;

   $totalCredit =0;
   $solde = 0;
   
   $debit3=0;
   $credit3 = 0;
   
   $RN =$this->repportNouveau($id_client);
   $compteur =0;
   
   $compteur1 =0;
	
 while(date("Y-m-d",strtotime($_POST["date_debut"].'+ '.$i.' day')) <= $_POST["date_fin"]) { 
    # code...
    $date_debut = strval(date("Y-m-d",strtotime($_POST["date_debut"].'+ '.$i.' day')));
   


  // $getAllNumFactureClient = $this->db->query('SELECT * from facture_commercial where id_client = '.$id_client.' and date_frais ="'.$date_debut.'"')->result_array();
  $montant = 0;
  $total=0;
 // foreach ($getAllNumFactureClient as $num_facture) {
    $getAccuseReglement = $this->db->query('SELECT * from reglement_achat where id_fournisseur = '.$id_client.' and date_reg ="'.$date_debut.'"')->result_array();
  if (count($getAccuseReglement)>0) {
    # code...
      foreach ($getAccuseReglement as $reglement) {
    # code...
        $totalAccuseReglement = $reglement['montant'] + $totalAccuseReglement;
        $credit1 =$reglement['montant'];
        $credit3 = $credit3 + $credit1;

        
        $RN =$RN-$credit1;
        
		$solde =$RN;
		
        echo "<tr style='border: 2px solid black;'>
        <td style='border: 2px solid black;'>".$date_debut."</td>
        <td style='border: 2px solid black;'>".$reglement['numero']."</td>
		<td style='border: 2px solid black;'></td>
        <td style='border: 2px solid black;'>".$reglement['libelle']."</td>
        <td style='border: 2px solid black;'>".number_format($credit1,0,',',' ')."</td>
        <td style='border: 2px solid black;'>0</td>
        
        <td style='border: 2px solid black;'>".number_format($solde,0,',',' ')."</td>
    </tr>";

    $totalSolde = $totalSolde + $solde;
	$compteur1++;
  }
  }

      $getFactureClient = $this->db->query("SELECT * from frais_achat where id_fournisseur =".$id_client." and date_frais='".$date_debut."' group by numero")->result_array();
  if (count($getFactureClient)>0) {
    # code...
      foreach ($getFactureClient as $factureClient) {
      $totalFactureCLient =$factureClient['total']+$totalFactureCLient;
	$debit = $factureClient['total'];
	$debit3 = $debit + $debit3;

       
    $RN =$RN+$debit;
        
    $solde =$RN;
 
 echo "<tr style='border: 2px solid black;'>
        <td style='border: 2px solid black;'>".$date_debut."</td>
        <td style='border: 2px solid black;'>".$factureClient['numero']."</td>
		<td style='border: 2px solid black;'>".$factureClient['facture']."</td>
		
        <td style='border: 2px solid black;'>".$factureClient['type']."</td>

        <td style='border: 2px solid black;'>0</td>
        <td style='border: 2px solid black;'>".number_format($debit,0,',',' ')."</td>

        <td style='border: 2px solid black;'>".number_format($solde,0,',',' ')."</td>
        </tr>";
		
		$compteur1++;

  }


  }



$totalDebit = $debit3;
$totalCredit = $credit3;

// $totalSolde = $totalSolde + $solde;
   $i++;   
   $compteur++;
  }

  echo "<tr>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>TOTAUX</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteur1,0,',',' ')."</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
		<td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($totalCredit,0,',',' ')."</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($totalDebit,0,',',' ')."</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($this->getSoldeBalanceImprimableClient(),0,',',' ')."</td>
    </tr>";
  }

 public function getBalanceImprimableClient1(){
  $id_client = $_POST["id_fournisseur"];
  $date_debut = $_POST["date_debut"];
  $date_fin = $_POST["date_fin"];
  // $date_fin =date("Y-m-d",strtotime($_POST["date_debut"].'- 1 day'));
       
$i=0;

   
  
   $totalAccuseReglement =0;
   $totalFactureCLient = 0;
   
   $totalSolde =0;

   $totalCredit =0;
   $solde = 0;
   
   $debit3=0;
   $credit3 = 0;
   
   $RN =$this->repportNouveau1($id_client);
   $compteur =0;
   
   $compteur1 =0;
	
 while(date("Y-m-d",strtotime($_POST["date_debut"].'+ '.$i.' day')) <= $_POST["date_fin"]) { 
    # code...
    $date_debut = strval(date("Y-m-d",strtotime($_POST["date_debut"].'+ '.$i.' day')));
   


  // $getAllNumFactureClient = $this->db->query('SELECT * from facture_commercial where id_client = '.$id_client.' and date_frais ="'.$date_debut.'"')->result_array();
  $montant = 0;
  $total=0;
 // foreach ($getAllNumFactureClient as $num_facture) {
    $getAccuseReglement = $this->db->query('SELECT * from reglement_matiere where id_client = '.$id_client.' and date_reg ="'.$date_debut.'"')->result_array();
  if (count($getAccuseReglement)>0) {
    # code...
      foreach ($getAccuseReglement as $reglement) {
    # code...
        $totalAccuseReglement = $reglement['montant'] + $totalAccuseReglement;
        $credit1 =$reglement['montant'];
        $credit3 = $credit3 + $credit1;

        
        $RN =$RN-$credit1;
        
		$solde =$RN;
		
        echo "<tr style='border: 2px solid black;'>
        <td style='border: 2px solid black;'>".$date_debut."</td>
        <td style='border: 2px solid black;'>".$reglement['numero']."</td>
        <td style='border: 2px solid black;'>".$reglement['libelle']."</td>
		<td style='border: 2px solid black;'>0</td>
        <td style='border: 2px solid black;'>".number_format($credit1,0,',',' ')."</td>
        
        
        <td style='border: 2px solid black;'>".number_format($solde,0,',',' ')."</td>
    </tr>";

    $totalSolde = $totalSolde + $solde;
	$compteur1++;
  }
  }

      $getFactureClient = $this->db->query("SELECT * from bon_livraison1 WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = ".$id_client.") and date_bl='".$date_debut."' group by numero")->result_array();
  if (count($getFactureClient)>0) {
    # code...
      foreach ($getFactureClient as $factureClient) {
      $totalFactureCLient =$factureClient['quantite']*$factureClient['prix_unitaire']+$totalFactureCLient;
	$debit = $factureClient['quantite']*$factureClient['prix_unitaire'];
	$debit3 = $debit + $debit3;

       
    $RN =$RN+$debit;
        
    $solde =$RN;
 
 echo "<tr style='border: 2px solid black;'>
        <td style='border: 2px solid black;'>".$date_debut."</td>
        <td style='border: 2px solid black;'>".$factureClient['numero']."</td>
        <td style='border: 2px solid black;'>".$factureClient['commentaire']."</td>

        
        <td style='border: 2px solid black;'>".number_format($debit,0,',',' ')."</td>
<td style='border: 2px solid black;'>0</td>
        <td style='border: 2px solid black;'>".number_format($solde,0,',',' ')."</td>
        </tr>";
		
		$compteur1++;

  }


  }



$totalDebit = $debit3;
$totalCredit = $credit3;

// $totalSolde = $totalSolde + $solde;
   $i++;   
   $compteur++;
  }

  echo "<tr>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>TOTAUX</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteur1,0,',',' ')."</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
		<td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($totalDebit,0,',',' ')."</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($totalCredit,0,',',' ')."</td>
        
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($this->getSoldeBalanceImprimableClient1(),0,',',' ')."</td>
    </tr>";
  }

	
	 public function addFactureVente(){
        $status = $_POST["status"];
        $facture = $_POST["facture"];
         $montant = preg_replace('/\s/','', $_POST["montant"]);
        $dateFacture = $_POST["dateFacture"];
        $libelle = addslashes($_POST['libelle']);
        $fournisseur = $_POST["fournisseur"];

        $nom_table = "frais_achat";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté une facture de matière première N°".$facture.", d'un montant".$montant.",  le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié une facture de matière première N°".$facture.", d'un montant".$montant.",  le ".$date_notif." à ".$heure;

        if ($status == "insert") {
            # code...
            $verifNumero = $this->db->query("SELECT * FROM bon_livraison1 WHERE numero = '".$facture."'")->row();
            if (count($verifNumero)>0) {
                # code...
                echo "Ce numéro de facture est déjà utilisé veuillez changer";
            }else{
                $insertFacture = $this->db->query("INSERT INTO bon_livraison1 value('','".$fournisseur."','".$facture."',CAST('". $dateFacture."' AS DATE),".$montant.",'".$libelle."')");
                if ($insertFacture == true) {
                    # code...
                    echo "Insertion parfaite de la facture";
                    $this->notificationAjout($nom_table,addslashes($message));
                }else{
                    echo "Erreur d'insertion";
                }
            }
        }elseif ($status == "update") {
            # code...
            $id_facture = $_POST["id_facture"];
            $verifNumero = $this->db->query("SELECT * FROM bon_livraison1 WHERE numero = '".$facture."'")->result_array();
            if (count($verifNumero)>0) {
                # code...
                
                foreach ($verifNumero as $row) {
                  # code...
                  if ($id_facture == $row['id_facture']) {
                    # code...
                    $update = $this->db->query("UPDATE bon_livraison1 set  id_client='".$fournisseur."',date_fact = CAST('". $dateFacture."' AS DATE),numero = '".$facture."',montant = ".$montant.",libelle='".$libelle."' where id_facture=".$id_facture."");
                if ($update == true ) {
                    # code...
                    echo "Facture modifiée";
                    $this->notificationAjout($nom_table,addslashes($message2));
                }else{
                    echo "Erreur lors de la modification";
                }
                  }else{
                    echo "Ce numéro de facture est déjà utilisé veuillez changer";
                  }
                }
            }else{
                 $update = $this->db->query("UPDATE bon_livraison1 set  id_client ='".$fournisseur."',date_fact = CAST('". $dateFacture."' AS DATE),numero = '".$facture."',montant = ".$montant.",libelle='".$libelle."' where id_facture=".$id_facture."");
                if ($update == true ) {
                    # code...
                    echo "Facture modifiée";
                    $this->notificationAjout($nom_table,addslashes($message2));
                }else{
                    echo "Erreur lors de la modification";
                }
            }
        }else{
            echo "Erreur fatale";
        }

        $this->db->close();
    }
    public function selectAllFactureVente(){
		
		  if (isset($_POST["date_debut"]) && isset($_POST["date_fin"])) {
        # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        if (!empty($date_fin) && !empty($date_debut)) {
            # code...
           $query1 = $this->db->query('SELECT * from bon_livraison1 where date_fact between "'.$date_debut.'" and "'.$date_fin.'" order by date_fact ')->result_array(); 
        }else{
            $query1 = $this->db->query('SELECT * from bon_livraison1 order by date_fact desc limit 900')->result_array();
        }
    }else{
        $query1 = $this->db->query('SELECT * from bon_livraison1 order by date_fact desc')->result_array();
    }

       
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                     
                   //  $getFournisseur = $this->db->query("select * from fournisseur_matiere where id_fournisseur = ".$row["id_fournisseur"]."")->row();

                   echo"
                    <td>".$row['numero']."</td>
					<td>".$row['date_fact']." </td>";
					
					 $client = $this->db->query("SELECT * from client where id_client =".$row['id_client']."")->row();
					echo "
					
					<td> ".$client->nom."</td>
                    
                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td>".$row['libelle']."</td>
                    
                    <td>";

            if($this->session->userdata('mira_sa_modification')=='true'){
                     echo"<button type='button' onclick=\"infosFacture('".$row['id_facture']."','".$row['numero']."','".$row['date_fact']."','".$row['libelle']."','".number_format($row['montant'],0,',',' ')."','".$row['id_client']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                 }

            if($this->session->userdata('mira_sa_suppression')=='true'){
                   echo" <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='bon_livraison1' identifiant='".$row['id_facture']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_facture\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
              }
                  $compteur++;
        }
        $this->db->close();
    }


// nous passsons donc au règlement


     public function selectAllReglement(){
         $query1 = $this->db->query('SELECT * from reglement_achat order by date_reg desc')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                    $getOperation = $this->db->query("SELECT * FROM fournisseur_matiere where id_fournisseur = ".$row['id_fournisseur']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom']."</td>";
                        }
                    }else {
                        # code...
                         echo"<td></td>";

                    }
                     


                    echo"
                    <td>".$row['numero']."</td>
                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td>".$row['libelle']."</td>
                    <td> ".$row['date_reg']." </td>
                    <td>";

            if($this->session->userdata('mira_sa_modification')=='true'){
                    echo"<button type='button' onclick=\"infosFacture('".$row['id_reglement']."','".$row['numero']."','".$row['date_reg']."','".$row['libelle']."','".number_format($row['montant'],0,',',' ')."','".$row['id_fournisseur']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }

            if($this->session->userdata('mira_sa_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='reglement_achat' identifiant='".$row['id_reglement']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_reglement\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
              }
                  $compteur++;
        }

        $this->db->close();
    }
	
	 public function selectAllReglement1(){
         $query1 = $this->db->query('SELECT * from reglement_matiere order by date_reg desc')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                    $getOperation = $this->db->query("SELECT * FROM client where id_client = ".$row['id_client']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom']."</td>";
                        }
                    }else {
                        # code...
                         echo"<td></td>";

                    }
                     


                    echo"
                    <td>".$row['numero']."</td>
                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td>".$row['libelle']."</td>
                    <td> ".$row['date_reg']." </td>
                    <td>";

            if($this->session->userdata('mira_sa_modification')=='true'){
                    echo"<button type='button' onclick=\"infosFacture('".$row['id_reglement']."','".$row['numero']."','".$row['date_reg']."','".$row['libelle']."','".number_format($row['montant'],0,',',' ')."','".$row['id_client']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }

            if($this->session->userdata('mira_sa_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='reglement_matiere' identifiant='".$row['id_reglement']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_reglement\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
              }
                  $compteur++;
        }

        $this->db->close();
    }

    public function addReglement(){
        $status = $_POST["status"];
        $numero = $_POST["numero"];
         $montant = preg_replace('/\s/','', $_POST["montant"]);
        $date = $_POST["date"];
        $libelle = addslashes($_POST["libelle"]);
        $id_fournisseur = $_POST["id_fournisseur"];

        $nom_table = "reglement_matiere";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté un règlement matière première N°".$numero.", d'un montant".$montant.",  le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié un règlement matière première N°".$numero.", d'un montant".$montant.",  le ".$date_notif." à ".$heure;

        if ($status == "insert") {
            # code...
            $verifNumero = $this->db->query("SELECT * FROM reglement_achat WHERE numero = '".$numero."'")->row();
            if (count($verifNumero)>0) {
                # code...
                echo "Ce numéro de facture est déjà utilisé veuillez changer";
            }else{
                $insertFacture = $this->db->query("INSERT INTO reglement_achat value('',".$id_fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",'".$libelle."',0)");
                if ($insertFacture == true) {
                    # code...
                    echo "Règlement de la facture effectué";
                    $this->notificationAjout($nom_table,addslashes($message));
                }else{
                    echo "Erreur d'insertion";
                }
            }
        }elseif ($status == "update") {
            # code...
            $id_facture = $_POST["id_facture"];
            $verifNumero = $this->db->query("SELECT * FROM reglement_achat WHERE numero = '".$numero."'")->result_array();
            if (count($verifNumero)>0) {
                # code...
                
                foreach ($verifNumero as $row) {
                  # code...
                  if ($id_facture == $row['id_reglement']) {
                    # code...
                    $update = $this->db->query("UPDATE reglement_achat set  id_fournisseur =".$id_fournisseur.",date_reg = CAST('". $date."' AS DATE),numero = '".$numero."',montant = ".$montant.",libelle='".$libelle."' where id_reglement
                      =".$id_facture."");
                if ($update == true ) {
                    # code...
                    echo "Règlement modifié";
                    $this->notificationAjout($nom_table,addslashes($message2));
                }else{
                    echo "Erreur lors de la modification";
                }
                  }else{
                    echo "Ce numéro de facture est déjà utilisé veuillez changer";
                  }
                }
            }else{
                 $update = $this->db->query("UPDATE reglement_achat set  id_fournisseur =".$id_fournisseur.",date_reg = CAST('". $date."' AS DATE),numero = '".$numero."',montant = ".$montant.",libelle='".$libelle."' where id_reglement=".$id_facture."");
                if ($update == true ) {
                    # code...
                    echo "Règlement modifié";
                    $this->notificationAjout($nom_table,addslashes($message2));
                }else{
                    echo "Erreur lors de la modification";
                }
            }
        }else{
            echo "Erreur fatale";
        }

        $this->db->close();
    }
	
	 public function addReglement1(){
        $status = $_POST["status"];
        $numero = $_POST["numero"];
         $montant = preg_replace('/\s/','', $_POST["montant"]);
        $date = $_POST["date"];
        $libelle = addslashes($_POST["libelle"]);
        $id_fournisseur = $_POST["id_fournisseur"];

        $nom_table = "reglement_matiere";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté un règlement matière première N°".$numero.", d'un montant".$montant.",  le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié un règlement matière première N°".$numero.", d'un montant".$montant.",  le ".$date_notif." à ".$heure;

        if ($status == "insert") {
            # code...
            $verifNumero = $this->db->query("SELECT * FROM reglement_matiere WHERE numero = '".$numero."'")->row();
            if (count($verifNumero)>0) {
                # code...
                echo "Ce numéro de facture est déjà utilisé veuillez changer";
            }else{
                $insertFacture = $this->db->query("INSERT INTO reglement_matiere value('',".$id_fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",'".$libelle."',0)");
                if ($insertFacture == true) {
                    # code...
                    echo "Règlement de la facture effectué";
                    $this->notificationAjout($nom_table,addslashes($message));
                }else{
                    echo "Erreur d'insertion";
                }
            }
        }elseif ($status == "update") {
            # code...
            $id_facture = $_POST["id_facture"];
            $verifNumero = $this->db->query("SELECT * FROM reglement_matiere WHERE numero = '".$numero."'")->result_array();
            if (count($verifNumero)>0) {
                # code...
                
                foreach ($verifNumero as $row) {
                  # code...
                  if ($id_facture == $row['id_reglement']) {
                    # code...
                    $update = $this->db->query("UPDATE reglement_matiere set  id_client =".$id_fournisseur.",date_reg = CAST('". $date."' AS DATE),numero = '".$numero."',montant = ".$montant.",libelle='".$libelle."' where id_reglement
                      =".$id_facture."");
                if ($update == true ) {
                    # code...
                    echo "Règlement modifié";
                    $this->notificationAjout($nom_table,addslashes($message2));
                }else{
                    echo "Erreur lors de la modification";
                }
                  }else{
                    echo "Ce numéro de facture est déjà utilisé veuillez changer";
                  }
                }
            }else{
                 $update = $this->db->query("UPDATE reglement_matiere set  id_client =".$id_fournisseur.",date_reg = CAST('". $date."' AS DATE),numero = '".$numero."',montant = ".$montant.",libelle='".$libelle."' where id_reglement=".$id_facture."");
                if ($update == true ) {
                    # code...
                    echo "Règlement modifié";
                    $this->notificationAjout($nom_table,addslashes($message2));
                }else{
                    echo "Erreur lors de la modification";
                }
            }
        }else{
            echo "Erreur fatale";
        }

        $this->db->close();
    }


public function leSelectFacture(){
        $getGazoil = $this->db->query("SELECT * FROM frais_achat ")->result_array();

        if (count($getGazoil) >0) {
            # code...
            foreach ($getGazoil as $row) {
                # code...
                echo "<option value='".$row['id_facture']."'> ".$row['numero']." </option>";
            }
        }

        $this->db->close();
    }

        public function selectAllFacturePourBalance(){
        $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM frais_achat WHERE  id_fournisseur='.$id_fournisseur.' order by date_frais asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM frais_achat WHERE  date_frais>="'.$date_debut.'" order by date_frais asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM frais_achat WHERE  date_frais<="'.$date_fin.'" order by date_frais asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM frais_achat WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" order by date_frais asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM frais_achat WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and id_fournisseur='.$id_fournisseur.' order by date_frais asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM frais_achat WHERE  date_frais<="'.$date_fin.'" and id_fournisseur='.$id_fournisseur.' order by date_frais asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM frais_achat WHERE  date_frais<="'.$date_debut.'" and id_fournisseur='.$id_fournisseur.' order by date_frais asc')->result_array();

        }
         $compteur = 0;
         $montant = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                    echo "
                    <td>".$row['numero']."</td>
                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td> ".$row['date_frais']." </td>
                   
                  </tr>

                  ";
                  $montant = $montant+$row['montant'];
                  $compteur++;
        }
     $this->db->close();
    }

 public function selectAllTotalFacturePourBalanceFournisseur(){
        $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM frais_achat WHERE  id_fournisseur='.$id_fournisseur.'')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM frais_achat WHERE  date_frais>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM frais_achat WHERE  date_frais<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM frais_achat WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM frais_achat WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and id_fournisseur='.$id_fournisseur.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM frais_achat WHERE  date_frais<="'.$date_fin.'" and id_fournisseur='.$id_fournisseur.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM frais_achat WHERE  date_frais<="'.$date_debut.'" and id_fournisseur='.$id_fournisseur.'')->result_array();

        }
         $compteur = 0;
         $montant = 0;
        foreach ($query1 as $row) {
        
                  $montant = $montant+$row['montant'];
        }
        return $montant;

        $this->db->close();
    }

    public function selectAllReglementPourBalance(){
        $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_matiere  WHERE  id_fournisseur='.$id_fournisseur.' order by date_reg asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_matiere  WHERE  date_reg>="'.$date_debut.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_matiere WHERE  date_reg<="'.$date_fin.'" order by date_reg asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_matiere WHERE  date_reg between "'.$date_debut.'" and "'.$date_fin.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_matiere WHERE  date_reg between "'.$date_debut.'" and "'.$date_fin.'" and id_fournisseur='.$id_fournisseur.' order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_matiere WHERE  date_reg<="'.$date_fin.'" and id_fournisseur='.$id_fournisseur.' order by date_reg asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_matiere WHERE  date_reg<="'.$date_debut.'" and id_fournisseur='.$id_fournisseur.' order by date_reg asc')->result_array();

        }
         $compteur = 0;
         $montant = 0;
        foreach ($query1 as $tab) {
            # code...

                              echo "<tr >
                    
                    <td> ".$compteur."</td>";
                            
                             echo"
                                <td>".$tab['numero']."</td>
                                <td>".number_format($tab['montant'],0,',',' ')."</td>
                                <td> ".$tab['date_reg']." </td>
                                
                              </tr>

                              ";

                               $compteur++;
                               $montant = $montant+$tab['montant'];
            
                 
        }

        $this->db->close();
    }

     public function selectAllTotalReglementPourBalanceFournisseur(){
        $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_matiere  WHERE  id_fournisseur='.$id_fournisseur.'')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_matiere  WHERE  date_reg>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_matiere WHERE  date_reg<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_matiere WHERE  date_reg between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_matiere WHERE  date_reg between "'.$date_debut.'" and "'.$date_fin.'" and id_fournisseur='.$id_fournisseur.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_matiere WHERE  date_reg<="'.$date_fin.'" and id_fournisseur='.$id_fournisseur.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_matiere WHERE  date_reg<="'.$date_debut.'" and id_fournisseur='.$id_fournisseur.'')->result_array();

        }
         $compteur = 0;
         $montant = 0;
        foreach ($query1 as $tab) {
            # code..
              $montant = $montant+$tab['montant'];
            
                 
        }
        return $montant;
        $this->db->close();
    }

    public function soldeCaisseFournisseur(){
    echo $this->selectAllTotalFacturePourBalanceFournisseur()-$this->selectAllTotalReglementPourBalanceFournisseur();

    $this->db->close();
    }

    public function deleteFournisseurMatiere($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé le fournisseur de produit de carrière ".$getCamion->nom." de téléphone ".$getCamion->telephone." le ".$date_notif." à ".$heure;


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
	

    public function getFournisseurMatiere($id_fournisseur){
      $query = $this->db->query("SELECT * from fournisseur_matiere where id_fournisseur = ".$id_fournisseur."")->row();

      if (count($query)>0) {
        # code...
        return $query->nom;
      }
    }
	
	  public function getClientMatiere($id_fournisseur){
      $query = $this->db->query("SELECT * from client where id_client = ".$id_fournisseur."")->row();

      if (count($query)>0) {
        # code...
        return $query->nom;
      }
    }
	
	
	
    public function deleteFactureFournisseurMatiere($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé la facture CLIENT de produit de carrière ".$this->getFournisseurMatiere1($getCamion->id_fournisseur).", de N° ".$getCamion->numero." d'un montant d'un ".$getCamion->montant." le ".$date_notif." à ".$heure;


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


   public function deleteReglementFournisseurMatiere($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé le règlement fournisseur de produit de carrière de ".$this->getFournisseurMatiere($getCamion->id_fournisseur).", de N° ".$getCamion->numero." d'un montant d'un ".$getCamion->montant." le ".$date_notif." à ".$heure;


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
	
	   public function deleteReglementClientMatiere($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé le règlement Client de produit de carrière de ".$this->getClientMatiere($getCamion->id_client).", de N° ".$getCamion->numero." d'un montant d'un ".$getCamion->montant." le ".$date_notif." à ".$heure;


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
	
	public function deleteFactureMatiere($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé la facture de vente d'un montant de ".$getCamion->montant."  le ".$date_notif." à ".$heure;


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
	
	
	
	public function getOperation($id_operation){
    $getOperation = $this->db->query("SELECT * FROM operation WHERE id_operation = ".$id_operation."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            return $tab['nom_op'];
                        }
                    }

                $this->db->close();
}


public function getValideDateUseOperation($date_action,$id_operation){
    $getOperation = $this->db->query("SELECT * from operation WHERE id_operation =".$id_operation." limit 1")->row();

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
           $query = $this->db->query('SELECT * from bon_livraison1 where decharge = "'.$decharge1.'" and date_bl between "'.$date_debut.'" and "'.$date_fin.'" order by date_bl desc')->result_array(); 
        
		 if ($decharge1 == 'TOUT') {
            # code...
          $query = $this->db->query('SELECT * from bon_livraison1 where date_bl between "'.$date_debut.'" and "'.$date_fin.'" order by date_bl desc')->result_array();
        
		}
		
		
		}else{
            $query = $this->db->query('SELECT * from bon_livraison1 order by date_bl desc limit 900')->result_array();
        }
    }else{
        $query = $this->db->query('SELECT * from bon_livraison1 order by date_bl desc limit 900')->result_array();
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
                    <td>";

              if($this->session->userdata('mira_sa_modification')=='true'){
                    echo"<button type='button' onclick='infosLivraison(\"".$row['numero']."\",\"".$row['date_bl']."\",\"".$row['depart']."\",\"".$row['quantite']."\",\"".number_format($row['prix_unitaire'],0,',',' ')."\",\"".$row['id_BL']."\",\"".$row['commentaire']."\",\"".$row['code_camion']."\",\"".$row['id_destination_litrage']."\",\"".$row['unite']."\",\"".$row['id_operation']."\",\"".$row['tva']."\",\"".$this->recupPUSansTVA($row['tva'],$row['prix_unitaire'])."\",\"".$row['decharge']."\",\"".$row['destinataire']."\");' class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                  }

              if($this->session->userdata('mira_sa_modification')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='bon_livraison1' identifiant='".$row['id_BL']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_BL\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                }
                  $compteur++;
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
        $requeteNumero = $this->db->query("select * from bon_livraison1 where numero ='".$numero."'")->result_array();
if ($this->getValideDateUseOperation($dateLivraison ,$operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
      if (count($requeteNumero) >0) {
        # code...
        echo "Ce numero a déjà été utilisé veuillez le changer";
      }else{
            $requete = $this->db->query("INSERT into bon_livraison1 value('','".$numero."',".$operation.",'".$code_camion."',CAST('". $dateLivraison."' AS DATE),'".$depart."',".$arrivee.",".$quantite.",".$PU.",'".$unite."','".$tva."','','".$decharge."','".$destinataire."')");
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
          $requeteNumero = $this->db->query("select * from bon_livraison1 where numero ='".$numero."'")->result_array();
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
             $requete = $this->db->query("UPDATE bon_livraison1 set id_operation=".$operation.",numero='".$numero."', date_bl=CAST('". $dateLivraison."' AS DATE), depart='".$depart."', id_destination_litrage = ".$arrivee.", quantite=".$quantite.", prix_unitaire=".$PU.", unite ='".$unite."',code_camion='".$code_camion."',destinataire='".$destinataire."', tva='".$tva."',decharge='".$decharge."' where id_BL=".$id_BL."");
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
         $requete = $this->db->query("UPDATE bon_livraison1 set id_operation=".$operation.",numero='".$numero."', date_bl=CAST('". $dateLivraison."' AS DATE), depart='".$depart."', id_destination_litrage = ".$arrivee.", quantite=".$quantite.", prix_unitaire=".$PU.", unite ='".$unite."',code_camion='".$code_camion."',destinataire='".$destinataire."',tva='".$tva."',decharge='".$decharge."' where id_BL=".$id_BL." ");
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
	
	 public function getDescriptionOperation(){
      $id_operation = $_POST["id_operation"];
        $query = $this->db->query("SELECT * from operation WHERE id_operation =".$id_operation."")->row();

        if (count($query) > 0) {
          # code...
          echo $query->commentaire;
        }else{
          echo "Aucune";
        }

        $this->db->close();
    }

   public function getClientOperation(){
      $id_operation = $_POST["id_operation"];
        $query = $this->db->query("SELECT * from operation WHERE id_operation =".$id_operation."")->row();

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
        $query = $this->db->query("SELECT * from operation WHERE id_operation =".$id_operation."")->row();

        if (count($query) > 0) {
          # code...
          echo $query->destination;
        }else{
          echo "Aucune";
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


	
	
	

}