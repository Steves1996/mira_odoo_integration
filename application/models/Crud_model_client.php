<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model_client extends CI_Model {
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
        $montant_init = preg_replace('/\s/','', $_POST["montant_init"]);

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
                    $query1 = $this->db->query("insert into client value('','". $nom. "',". $telephone.",'".$adresse."','".$nui."',".$montant_init.",CAST('". $date_init."' AS DATE))");
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
                            $query1 = $this->db->query("UPDATE client set telephone=".$telephone.", adresse='".$adresse."', nom='".$nom."',nui='".$nui."', date_init = CAST('". $date_init."' AS DATE),montant_init=".$montant_init." where id_client=".$id_client."");
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
                    $query1 = $this->db->query("UPDATE client set telephone=".$telephone.", adresse='".$adresse."', nom='".$nom."', nui='".$nui."', date_init = CAST('". $date_init."' AS DATE),montant_init=".$montant_init." where id_client=".$id_client."");
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
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='client' identifiant='".$row['id_client']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_client\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
        }
        $this->db->close();
    }

         public function selectAllReglement(){
         $query1 = $this->db->query('SELECT * from reglement_client order by date_reg desc')->result_array();
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

                if($this->session->userdata('client_modification')=='true'){
                    echo"<button type='button' onclick=\"infosReglement('".$row['id_reglement']."','".$row['numero']."','".$row['date_reg']."','".$row['libelle']."','".number_format($row['montant'],0,',',' ')."','".$row['id_client']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }
                if($this->session->userdata('client_suppression')=='true'){
                   echo" <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='reglement_client' identifiant='".$row['id_reglement']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_reglement\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                }
                  $compteur++;
        }

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
	
	 public function leSelectClientTransport(){
        $query = $this->db->query("select * from client where id_client IN (Select id_client From operation where filiale = 'MIRA TRANSPORT') order by nom")->result_array();
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

	

public function getDateInitialClient1(){
  $id_client = $_POST["id_client"];

  $query = $this->db->query("SELECT * from client where id_client=".$id_client."")->row();

if (count($query)>0) {
  # code...
  return $query->date_init;
 }else{

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


public function getClient1($id_client){
  $query = $this->db->query("SELECT * from client where id_client =".$id_client."")->row();
  if (count($query)>0) {
    # code...
    return $query->nom;
  }
}

public function getAdresseClient1($id_client){
  $query = $this->db->query("SELECT * from client where id_client=".$id_client."")->row();
  if (count($query)>0) {
    # code...
    return $query->adresse;
  }
}

public function getVilleClient1($id_client){
  $query = $this->db->query("SELECT * from client where id_client =".$id_client."")->row();
  if (count($query)>0) {
    # code...
    return $query->ville;
  }
}



public function getTelephoneClient1($id_client){
  $query = $this->db->query("SELECT * from client where id_client =".$id_client."")->row();
  if (count($query)>0) {
    # code...
    return $query->telephone;
  }
}

public function soldeCaisseClient2_1(){
    echo $this->repportNouveau3_1() - $this->selectAllTotalAccuseReglementPourBalanceClient1() + $this->totalFacturePourBalanceClient1();
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

public function selectAllTotalAccuseReglementPourRepport1($id_fournisseur,$date_debut, $date_fin ){
      
        $montant = 0;
     

        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT  * FROM reglement_client WHERE id_client = '.$id_fournisseur.' order by date_reg asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_client WHERE  date_reg>="'.$date_debut.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_client WHERE date_reg<="'.$date_fin.'" order by date_reg asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_client WHERE date_reg between "'.$date_debut.'" and "'.$date_fin.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_client WHERE id_client = '.$id_fournisseur.' and date_reg between "'.$date_debut.'" and "'.$date_fin.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_client WHERE id_client = '.$id_fournisseur.' and date_reg<="'.$date_fin.'" order by date_reg asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_client WHERE id_client = '.$id_fournisseur.' and date_reg>="'.$date_debut.'" order by date_reg asc')->result_array();

        }
         $compteur = 0;
         
        foreach ($query1 as $tab) {
        $montant = $montant+$tab['montant'];
                         
        }
       
 return $montant;
}



	public function totalFacturePourRepport1($id_fournisseur,$date_debut, $date_fin ){
  $date = date('Y-m-d');

       if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT  * FROM bon_livraison WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = '.$id_fournisseur.') order by date_bl asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM bon_livraison WHERE  date_fact>="'.$date_debut.'" order by date_bl asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM bon_livraison WHERE date_fact<="'.$date_fin.'" order by date_bl asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM bon_livraison WHERE date_fact between "'.$date_debut.'" and "'.$date_fin.'" order by date_bl asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM bon_livraison WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = '.$id_fournisseur.') and date_bl between "'.$date_debut.'" and "'.$date_fin.'" order by date_bl asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM bon_livraison WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = '.$id_fournisseur.') and date_bl<="'.$date_fin.'" order by date_bl asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM bon_livraison WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = '.$id_fournisseur.') and date_bl>="'.$date_debut.'" order by date_bl asc')->result_array();

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



public function selectAllTotalAccuseReglementPourBalanceClient1(){
        $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

        $montant = 0;


        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT  * FROM reglement_client WHERE id_client = '.$id_fournisseur.' order by date_reg asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_client WHERE  date_reg>="'.$date_debut.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_client WHERE date_reg<="'.$date_fin.'" order by date_reg asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_client WHERE date_reg between "'.$date_debut.'" and "'.$date_fin.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_client WHERE id_client = '.$id_fournisseur.' and date_reg between "'.$date_debut.'" and "'.$date_fin.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_client WHERE id_client = '.$id_fournisseur.' and date_reg<="'.$date_fin.'" order by date_reg asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_client WHERE id_client = '.$id_fournisseur.' and date_reg>="'.$date_debut.'" order by date_reg asc')->result_array();

        }
         $compteur = 0;
         
        foreach ($query1 as $tab) {
        $montant = $montant+$tab['montant'];
                         
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
             $query1 = $this->db->query('SELECT  * FROM bon_livraison WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = '.$id_fournisseur.') order by date_bl asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl>="'.$date_debut.'" order by date_bl asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM bon_livraison WHERE date_bl<="'.$date_fin.'" order by date_bl asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM bon_livraison WHERE date_bl between "'.$date_debut.'" and "'.$date_fin.'" order by date_bl asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM bon_livraison WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = '.$id_fournisseur.') and date_bl between "'.$date_debut.'" and "'.$date_fin.'" order by date_bl asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM bon_livraison WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = '.$id_fournisseur.') and date_bl<="'.$date_fin.'" order by date_bl asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM bon_livraison WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = '.$id_fournisseur.') and date_bl>="'.$date_debut.'" order by date_bl asc')->result_array();

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
				
		
		if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query2 = $this->db->query('SELECT  * FROM location_engin WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = '.$id_fournisseur.') order by date_location asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query2 = $this->db->query('SELECT * FROM location_engin WHERE  date_location>="'.$date_debut.'" order by date_location asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query2 = $this->db->query('SELECT * FROM location_engin WHERE date_location<="'.$date_fin.'" order by date_location asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query2 = $this->db->query('SELECT * FROM location_engin WHERE date_location between "'.$date_debut.'" and "'.$date_fin.'" order by date_location asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query2 = $this->db->query('SELECT * FROM location_engin WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = '.$id_fournisseur.') and date_location between "'.$date_debut.'" and "'.$date_fin.'" order by date_location asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query2 = $this->db->query('SELECT * FROM location_engin WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = '.$id_fournisseur.') and date_location<="'.$date_fin.'" order by date_location asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query2 = $this->db->query('SELECT * FROM location_engin WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = '.$id_fournisseur.') and date_location>="'.$date_debut.'" order by date_location asc')->result_array();

        }
         // $query1 = $this->db->query('SELECT * from commande group by num_com order by date_com asc')->result_array();
         $compteur = 0;
       //  $total = 0;
      //   $montant =0;
		 
        foreach ($query2 as $row) {
            # code...
         
             
              $montant = $row['montant']+$montant;
                  $compteur++;
               // }
        }
		
		

        return $montant;
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



public function getCreditPourBalanceImpCLient1(){
  return $this->selectAllTotalAccuseReglementPourBalanceClient1();
}


public function getDebitPourBalanceImpCLient1(){
  return $this->totalFacturePourBalanceClient1();
}


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

    $getAccuseReglement = $this->db->query('SELECT * FROM reglement_client where id_client = '.$id_client.' and date_reg ="'.$date_debut.'"')->result_array();
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

    
	$getFactureClient = $this->db->query("SELECT * from bon_livraison WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = ".$id_client.") and date_bl='".$date_debut."' group by numero")->result_array();
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
  
  	$getFactureClient1 = $this->db->query("SELECT * from location_engin WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = ".$id_client.") and date_location='".$date_debut."' group by code")->result_array();
  if (count($getFactureClient1)>0) {
    # code...
      foreach ($getFactureClient1 as $factureClient1) {
    # code...
        // $solde =$this->getSoldeInitialClient()+$this->getTotalAccuseReglementParClientPourBalance($id_client,$date_debut,$date_fin)+$this->getTotalAvisCreditParClientPourBalance($id_client,$date_debut,$date_fin)-$this->getTotalAvisDebitParClientPourBalance($id_client,$date_debut,$date_fin)-$this->getTotalAccuseRetraitParClientPourBalance($id_client,$date_debut,$date_fin)-$this->getTotalFactureParClientPourBalance($id_client,$date_debut)-$this->getTotalFactureArticleParClientPourBalance($id_client,$date_debut);
        
		$totalFactureCLient =$factureClient1['montant']+$totalFactureCLient;
  
$debit = $factureClient1['montant'];

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
    $getAccuseReglement = $this->db->query('SELECT * FROM reglement_client where id_client = '.$id_client.' and date_reg ="'.$date_debut.'"')->result_array();
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

      $getFactureClient = $this->db->query("SELECT * from bon_livraison WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = ".$id_client.") and date_bl='".$date_debut."' group by numero")->result_array();
      
	  $getFactureClient1 = $this->db->query("SELECT * from location_engin WHERE id_operation IN (SELECT id_operation FROM operation WHERE id_client = ".$id_client.") and date_location='".$date_debut."' group by code")->result_array();
 
  
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
  
  if (count($getFactureClient1)>0) {
    # code...
      foreach ($getFactureClient1 as $factureClient1) {
      $totalFactureCLient = $factureClient1['montant']+ $totalFactureCLient;
	  
	$debit = $factureClient1['montant'];
	
	$debit3 = $debit + $debit3;

       
    $RN =$RN+$debit;
        
    $solde =$RN;
 
 echo "<tr style='border: 2px solid black;'>
        <td style='border: 2px solid black;'>".$date_debut."</td>
        <td style='border: 2px solid black;'>".$factureClient1['code']."</td>
        <td style='border: 2px solid black;'>".$factureClient1['commentaire']."</td>

        
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




	
	

    public function addReglement(){
        $status = $_POST["status"];
        $numero = $_POST["numero"];
         $montant = preg_replace('/\s/','', $_POST["montant"]);
        $date = $_POST["date"];
        $libelle = addslashes($_POST["libelle"]);
        $id_fournisseur = $_POST["id_fournisseur"];

    $nom_table = "reglement_client";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté l'accusé de règlement N° ' ".$numero.", pour un montant de ".$montant.", le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié l'accusé de règlement N° ' ".$numero.", pour un montant de ".$montant.", le ".$date_notif." à ".$heure;

        if ($status == "insert") {
            # code...
            $verifNumero = $this->db->query("SELECT * FROM reglement_client WHERE numero = '".$numero."'")->row();
            if (count($verifNumero)>0) {
                # code...
                echo "Ce numéro de reglement est déjà utilisé veuillez changer";
            }else{
                $insertFacture = $this->db->query("INSERT INTO reglement_client value('',".$id_fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",'".$libelle."')");
                if ($insertFacture == true) {
                    # code...
                    echo "Règlement du client effectué";
                    $this->notificationAjout($nom_table,addslashes($message));
                }else{
                    echo "Erreur d'insertion";
                }
            }
        }elseif ($status == "update") {
            # code...
            $id_facture = $_POST["id_facture"];
            $verifNumero = $this->db->query("SELECT * FROM reglement_client WHERE numero = '".$numero."'")->result_array();
            if (count($verifNumero)>0) {
                # code...
                
                foreach ($verifNumero as $row) {
                  # code...
                  if ($id_facture == $row['id_reglement']) {
                    # code...
                    $update = $this->db->query("UPDATE reglement_client set  id_client =".$id_fournisseur.",date_reg = CAST('". $date."' AS DATE),numero = '".$numero."',montant = ".$montant.",libelle='".$libelle."' where id_reglement
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
                 $update = $this->db->query("UPDATE reglement_client set  id_client =".$id_fournisseur.",date_reg = CAST('". $date."' AS DATE),numero = '".$numero."',montant = ".$montant.",libelle='".$libelle."' where id_reglement=".$id_facture."");
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

 public function soldeInitialClient(){
        $id_fournisseur = $_POST['id_fournisseur'];
        $getGazoil = $this->db->query("SELECT * FROM client where id_client=".$id_fournisseur." ")->row();

        if (count($getGazoil) >0) {
            # code...
           return $getGazoil->montant_init;
        }else{
            return 0;
        }
        $this->db->close();
    }

public function dateInitialClient(){
        $id_fournisseur = $_POST['id_fournisseur'];
        $getGazoil = $this->db->query("SELECT * FROM client where id_client=".$id_fournisseur." ")->row();

        if (count($getGazoil) >0) {
            # code...
          echo  $getGazoil->date_init;
        }
        $this->db->close();
    }

 public function selectAllFacturePourBalance(){
        $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT distinct * FROM operation WHERE id_client='.$id_fournisseur.' order by date_creation asc')->result_array();
             $query2 = $this->db->query('SELECT distinct * FROM operation order by date_creation asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT distinct * FROM operation WHERE  date_creation>="'.$date_debut.'" order by date_creation asc')->result_array();
             $query2 = $this->db->query('SELECT distinct * FROM operation WHERE  date_creation>="'.$date_debut.'" order by date_creation asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT distinct * FROM operation WHERE date_creation<="'.$date_fin.'" order by date_creation asc')->result_array();
             $query2 = $this->db->query('SELECT distinct * FROM operation WHERE date_creation<="'.$date_fin.'" order by date_creation asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT distinct * FROM operation WHERE date_creation between "'.$date_debut.'" and "'.$date_fin.'" order by date_creation asc')->result_array();
            $query2 = $this->db->query('SELECT distinct * FROM operation WHERE date_creation between "'.$date_debut.'" and "'.$date_fin.'" order by date_creation asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT distinct * FROM operation WHERE id_client ='.$id_fournisseur.' and date_creation between "'.$date_debut.'" and "'.$date_fin.'" order by date_creation asc')->result_array();
            $query2 = $this->db->query('SELECT distinct * FROM operation WHERE date_creation between "'.$date_debut.'" and "'.$date_fin.'" order by date_creation asc')->result_array();
            
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT distinct * FROM operation WHERE id_client='.$id_fournisseur.' and date_creation<="'.$date_fin.'" order by date_creation asc')->result_array();
             $query2 = $this->db->query('SELECT distinct * FROM operation WHERE  date_creation<="'.$date_fin.'" order by date_creation asc')->result_array();
        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT distinct * FROM operation WHERE id_client ='.$id_fournisseur.' and date_creation>="'.$date_debut.'" order by date_creation asc')->result_array();
             $query2 = $this->db->query('SELECT distinct * FROM operation WHERE date_creation>="'.$date_debut.'" order by date_creation asc')->result_array();

        }
         // $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE id_gazoil = (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.' limit 1) ')->result_array();
         $compteur = 0;
         $montant = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>
                    <td> ".$row['nom_op']."</td>
                    <td> ".$row['date_creation']."</td>";
                    $getLocationEngin = $this->db->query("SELECT * FROM location_engin where id_operation = ".$row['id_operation']."")->result_array();
$montantLocation=0;
                    if (count($getLocationEngin)>0) {
                        # code...
                        
                        foreach ($getLocationEngin as $tab1) {
                            # code...
                            $montantLocation = $tab1["montant"] + $montantLivraison;
                            
                        }
                    }
                    echo"<td>".number_format($montantLocation,0,',',' ')." </td>";
 $montantLivraison =0;
                    $getLivraison = $this->db->query("SELECT * FROM bon_livraison where id_operation = ".$row['id_operation']."")->result_array();

                    if (count($getLivraison)>0) {
                        # code...
                       
                        foreach ($getLivraison as $tab) {
                            # code...
                            $montantLivraison = $tab["prix_unitaire"]*$tab["quantite"] + $montantLivraison;
                            
                        }
                    }
                    echo"<td>".number_format($montantLivraison ,0,',',' ')." </td>";

 $montantvente =0;
                    $getvente = $this->db->query("SELECT * FROM vente_pieces where id_operation = ".$row['id_operation']." and id_client='.$id_fournisseur.'")->result_array();

                    if (count($getvente)>0) {
                        # code...
                       
                        foreach ($getvente as $tab) {
                            # code...
                            $montantvente = $tab["montant"] + $montantvente;
                            
                        }
                    }
                    echo"<td>".number_format($montantvente ,0,',',' ')." </td>";
                                        
                    
                    echo "
                   
                    <td>".number_format($montantLivraison+$montantLocation+$montantvente,0,',',' ')."</td>
                   
                   
                  </tr>

                  ";
                
                  $compteur++;
                  
        }
       $this->db->close();
    }

public function selectAllTotalFacturePourBalance(){
        $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM operation WHERE id_client='.$id_fournisseur.' order by date_creation asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM operation WHERE  date_creation>="'.$date_debut.'" order by date_creation asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT  * FROM operation WHERE date_creation<="'.$date_fin.'" order by date_creation asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM operation WHERE date_creation between "'.$date_debut.'" and "'.$date_fin.'" order by date_creation asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM operation WHERE id_client ='.$id_fournisseur.' and date_creation between "'.$date_debut.'" and "'.$date_fin.'" order by date_creation asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM operation WHERE id_client='.$id_fournisseur.' and date_creation<="'.$date_fin.'" order by date_creation asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM operation WHERE id_client ='.$id_fournisseur.' and date_creation>="'.$date_debut.'" order by date_creation asc')->result_array();

        }
         // $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE id_gazoil = (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.' limit 1) ')->result_array();
         $compteur = 0;
         $montant = 0;
          $montantLivraison =0;
          $montantLocation=0;
          $montantVente=0;
        foreach ($query1 as $row) {
            # code...

                    $getLocationEngin = $this->db->query("SELECT * FROM location_engin where id_operation = ".$row['id_operation']."")->result_array();

                    if (count($getLocationEngin)>0) {
                        # code...
                        
                        foreach ($getLocationEngin as $tab1) {
                            # code...
                            $montantLocation = $tab1["montant"] + $montantLivraison;
               
                        }
                    }else{
                       
                    }

                    $getLivraison = $this->db->query("SELECT * FROM bon_livraison where id_operation = ".$row['id_operation']."")->result_array();

                    if (count($getLivraison)>0) {
                        # code...
                       
                        foreach ($getLivraison as $tab) {
                            # code...
                            $montantLivraison = $tab["prix_unitaire"]*$tab["quantite"] + $montantLivraison;
       
                        }
                    }else{
                       
                    }

                   
                 $getVente = $this->db->query("SELECT * FROM vente_pieces where id_operation = ".$row['id_operation']."")->result_array();

                    if (count($getVente)>0) {
                        # code...
                       
                        foreach ($getVente as $tab) {
                            # code...
                            $montantVente = $tab["montant"] + $montantVente;
       
                        }
                    }else{
                       
                    }
                
                  
        }
        return $montantLivraison+$montantLocation + $montantVente;
       $this->db->close();
    }

        public function selectAllReglementPourBalance(){
        $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
       if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_client  WHERE  id_client='.$id_fournisseur.' order by date_reg asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_client  WHERE  date_reg>="'.$date_debut.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_client WHERE  date_reg<="'.$date_fin.'" order by date_reg asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_client WHERE  date_reg between "'.$date_debut.'" and "'.$date_fin.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_client WHERE  date_reg between "'.$date_debut.'" and "'.$date_fin.'" and id_client='.$id_fournisseur.' order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_client WHERE  date_reg<="'.$date_fin.'" and id_client='.$id_fournisseur.' order by date_reg asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_client WHERE  date_reg<="'.$date_debut.'" and id_client='.$id_fournisseur.' order by date_reg asc')->result_array();

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


public function selectAllTotalReglementPourBalanceClient(){
        $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
       if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_client  WHERE  id_client='.$id_fournisseur.' order by date_reg asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_client  WHERE  date_reg>="'.$date_debut.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_client WHERE  date_reg<="'.$date_fin.'" order by date_reg asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_client WHERE  date_reg between "'.$date_debut.'" and "'.$date_fin.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_client WHERE  date_reg between "'.$date_debut.'" and "'.$date_fin.'" and id_client='.$id_fournisseur.' order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_client WHERE  date_reg<="'.$date_fin.'" and id_client='.$id_fournisseur.' order by date_reg asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_client WHERE  date_reg<="'.$date_debut.'" and id_client='.$id_fournisseur.' order by date_reg asc')->result_array();

        }
         $compteur = 0;
         $montant = 0;
        foreach ($query1 as $tab) {
        $montant = $montant+$tab['montant'];
                         
        }
        return $montant;

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



public function soldeCaisseClient(){
    echo $this->selectAllTotalFacturePourBalance()+$this->soldeInitialClient()-$this->selectAllTotalReglementPourBalanceClient();
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
    public function getNomClient($id_client){
        $query=$this->db->query("SELECT * from client where id_client=".$id_client."")->row();

        if (count($query)>0) {
            # code...
            $query->nom;
        }
    }
    public function deleteReglementClient($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé le reglement du client ".$this->getNomClient($getCamion->id_client).", de numéro ".$getCamion->numero." et de montant ".$getCamion->montant." le ".$date_notif." à ".$heure;


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
