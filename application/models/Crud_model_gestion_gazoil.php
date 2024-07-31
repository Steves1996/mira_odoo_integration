<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model_gestion_gazoil extends CI_Model {
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
}

public function getIdentifiantUtilisateur($id_profil){
  $query = $this->db->query("SELECT * from profil where id_profil=".$id_profil."")->row();
  if (count($query)>0) {
    # code...
    return $query->identifiant;
  }
  $this->db->close();
}


    public function addFacture(){
        $status = $_POST["status"];
        $numero = $_POST["numero"];
		  $type = $_POST["type"];
        // $numero_facture = $_POST['numero_facture'];
         $montant = intval(preg_replace('/\s/','', $_POST["montant"]));
        $date = $_POST["date"];
        $id_fournisseur = $_POST["id_fournisseur"];
        
        // echo "fournisseur ".$id_fournisseur;

        $nom_table = "facture_gazoil";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté une facture gasoil N°".$numero.", d'un montant".$montant.",  le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié une facture gasoil N°".$numero.", d'un montant".$montant.",  le ".$date_notif." à ".$heure;

        $getDateFournisseur = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur=".$id_fournisseur." limit 1")->row();
        if ($status == "insert") {
           
            if ($getDateFournisseur->date_fournisseur > $date) {
                # code...
                echo "Entrez une date supérieure ou égale à la date d'initialisation de ce fournisseur";
            }
            else{
                $insertFacture = $this->db->query("INSERT INTO facture_gazoil value('',".$id_fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",'".$type."')");
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
  
               if ($getDateFournisseur->date_fournisseur > $date) {
                # code...
                echo "Entrez une date supérieure ou égale à la date d'initialisation de ce fournisseur";
                 }else{
                 $update = $this->db->query("UPDATE facture_gazoil set  id_fournisseur =".$id_fournisseur.",date_fact = CAST('". $date."' AS DATE),numero = '".$numero."',montant = ".$montant.",type = '".$type."' where id_facture=".$id_facture."");
                if ($update == true ) {
                    # code...
                    echo "Facture modifiée";
                    $this->notificationAjout($nom_table,addslashes($message2));
                }else{
                    echo "Erreur lors de la modification";
                }
                }
            // }
        }else{
            echo "Erreur fatale";
        }

        $this->db->close();
    }

    public function selectAllFacture(){
		
		
		if (isset($_POST["date_debut"]) && isset($_POST["date_fin"]) && isset($_POST["id_fournisseur1"])) {
        # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
		$id_fournisseur1 = $_POST['id_fournisseur1'];
		
		
		
		 if (!empty($date_fin) && !empty($date_debut) && !empty($id_fournisseur1)) {
            # code...
           $query1 = $this->db->query('SELECT * from facture_gazoil  where id_fournisseur = '.$id_fournisseur1.' and date_fact between "'.$date_debut.'" and "'.$date_fin.'" order by date_fact desc')->result_array();
        }else{
             $query1 = $this->db->query('SELECT * from facture_gazoil order by date_fact desc')->result_array();
        }
    }else{
			 $query1 = $this->db->query('SELECT * from facture_gazoil order by date_fact desc')->result_array();
    }
	
        
         $compteur = 0;
        foreach ($query1 as $row){
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>
					
					<td>".$row['type']."</td>";

            
                     $getFournisseur = $this->db->query("select * from fournisseur_gazoil where id_fournisseur = ".$row['id_fournisseur']." ")->row();


                    echo"
                    <td>".$row['numero']."</td>
                    <td> ".$getFournisseur->nom." </td>
                    <td>".number_format($row['montant'],0,',',' ')."</td>
				
                    <td> ".$row['date_fact']." </td>
                    <td>";

            if($this->session->userdata('gazoil_modification')=='true'){
                    echo"<button type='button' onclick=\"infosFacture('".$row['id_facture']."','".$row['id_fournisseur']."','".$row['numero']."','".$row['date_fact']."','".number_format($row['montant'],0,',',' ')."','".$row['type']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }

            if($this->session->userdata('gazoil_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='facture_gazoil' identifiant='".$row['id_facture']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_facture\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
        }

        $this->db->close();
    }

    public function leSelectGazoil(){
        $query = $this->db->query("select * from gazoil")->result_array();
        echo "<option value='0'>numero du bon</option>";
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_gazoil"]."'>".$row["numero"]."</option>";
            }
        }else{

        }

        $this->db->close();
    }

    public function selectMontFactureGazoil(){
        $id_gazoil = $_POST["id_gazoil"];

        $getMontant = $this->db->query("SELECT * FROM gazoil where id_gazoil = ".$id_gazoil."")->row();
        if (count($getMontant) == 1) {
            # code...
            echo $getMontant->litrage * $getMontant->prix_unitaire;
        }
        $this->db->close();
    }


    public function leSelectGazoilParFournisseur(){
        $id_fournisseur = $_POST["id_fournisseur"];

        $getGazoil = $this->db->query("SELECT * FROM gazoil WHERE id_fournisseur = ".$id_fournisseur." and id_gazoil not in (SELECT id_gazoil from facture_gazoil) order by numero")->result_array();

        if (count($getGazoil) >0) {
            # code...
            foreach ($getGazoil as $row) {
                # code...
                echo "<option value='".$row['id_gazoil']."'> ".$row['numero']." </option>";
            }
        }

        $this->db->close();
    }

    public function leSelectFacture(){
        $getGazoil = $this->db->query("SELECT * FROM facture_gazoil ")->result_array();

        if (count($getGazoil) >0) {
            # code...
            foreach ($getGazoil as $row) {
                # code...
                echo "<option value='".$row['id_facture']."'> ".$row['numero']." </option>";
            }
        }

        $this->db->close();
    }

    public function dateInitialFournisseur(){
        $id_fournisseur = $_POST['id_fournisseur'];
        $getGazoil = $this->db->query("SELECT * FROM fournisseur_gazoil where id_fournisseur=".$id_fournisseur." ")->row();

        if (count($getGazoil) >0) {
            # code...
          echo  $getGazoil->date_fournisseur;
        }

        $this->db->close();
    }
     public function soldeInitialFournisseur(){
        $id_fournisseur = $_POST['id_fournisseur'];
        $getGazoil = $this->db->query("SELECT * FROM fournisseur_gazoil where id_fournisseur=".$id_fournisseur." ")->row();

        if (count($getGazoil) >0) {
            # code...
           return $getGazoil->solde;
        }else{
            return 0;
        }

        $this->db->close();
    }

     public function selectAllReglement(){
         $query1 = $this->db->query('SELECT * from reglement_gazoil order by date_reg desc ')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>
					
					 <td>".$row['type']."</td>";

                    $getOperation = $this->db->query("SELECT * FROM fournisseur_gazoil where id_fournisseur = ".$row['id_fournisseur']."")->result_array();

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
                    <td> ".$row['date_reg']." </td>
                    <td>";

            if($this->session->userdata('gazoil_modification')=='true'){
                    echo"<button type='button' onclick=\"infosReglement('".$row['id_reglement']."','".$row['id_fournisseur']."','".$row['numero']."','".$row['date_reg']."','".number_format($row['montant'],0,',',' ')."','".$row['type']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }

            if($this->session->userdata('gazoil_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='reglement_gazoil' identifiant='".$row['id_reglement']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_reglement\");'><i class='far fa-trash-alt'></i></button>
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
		 $type = $_POST["type"];
         $montant = preg_replace('/\s/','', $_POST["montant"]);
        $date = $_POST["date"];
        $id_fournisseur = $_POST["id_fournisseur"];

        $nom_table = "reglement_gazoil";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté un règlement gasoil N°".$numero.", d'un montant".$montant.",  le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié un règlement gasoil N°".$numero.", d'un montant".$montant.",  le ".$date_notif." à ".$heure;

	$getDateFournisseur = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur=".$id_fournisseur." limit 1")->row();
        
        if ($status == "insert") {
            # code...
            $verifNumero = $this->db->query("SELECT * FROM reglement_gazoil WHERE numero = '".$numero."'")->row();
            if (count($verifNumero)>0) {
                # code...
                echo "Ce numéro de facture est déjà utilisé veuillez changer";
            }elseif ($getDateFournisseur->date_fournisseur > $date) {
                # code...
                echo "Entrez une date supérieure ou égale à la date d'initialisation de ce fournisseur";
            }else{
                $insertFacture = $this->db->query("INSERT INTO reglement_gazoil value('',".$id_fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",'".$type."',0 )");
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
            
            # code...
              $id_facture = $_POST["id_facture"];
            $verifNumero = $this->db->query("SELECT * FROM reglement_gazoil WHERE numero = '".$numero."'")->result_array();
            if (count($verifNumero)>0) {
                # code...
                
                foreach ($verifNumero as $row) {
                  # code...
                  if ($id_facture == $row['id_reglement']) {
                    # code...
               if ($getDateFournisseur->date_fournisseur > $date) {
                # code...
                echo "Entrez une date supérieure ou égale à la date d'initialisation de ce fournisseur";
                }else{
                    $update = $this->db->query("UPDATE reglement_gazoil set  id_fournisseur =".$id_fournisseur.",date_reg = CAST('". $date."' AS DATE),numero = '".$numero."',montant = ".$montant.",type = '".$type."' where id_reglement
                      =".$id_facture."");
                
                if ($update == true ) {
                    # code...
                    echo "Règlement modifié";
                    $this->notificationAjout($nom_table,addslashes($message2));
                }else{
                    echo "Erreur lors de la modification";
                }
            }
                  }else{
                    echo "Ce numéro de facture est déjà utilisé veuillez changer";
                  }
                }
            }else{
              if ($getDateFournisseur->date_fournisseur > $date) {
                # code...
                echo "Entrez une date supérieure ou égale à la date d'initialisation de ce fournisseur";
            }else{
                 $update = $this->db->query("UPDATE reglement_gazoil set  id_fournisseur =".$id_fournisseur.",date_reg = CAST('". $date."' AS DATE),numero = '".$numero."',montant = ".$montant." where id_reglement=".$id_facture."");
                if ($update == true ) {
                    # code...
                    echo "Règlement modifié";
                    $this->notificationAjout($nom_table,addslashes($message2));
                }else{
                    echo "Erreur lors de la modification";
                }
                }
            }
        }else{
            echo "Erreur fatale";
        }


        $this->db->close();
    }


        public function selectAllFacturePourBalance(){
        $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT distinct * FROM facture_gazoil WHERE id_gazoil in (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.') order by date_fact asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT distinct * FROM facture_gazoil WHERE  date_fact>="'.$date_debut.'" order by date_fact asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT distinct * FROM facture_gazoil WHERE date_fact<="'.$date_fin.'" order by date_fact asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT distinct * FROM facture_gazoil WHERE date_fact between "'.$date_debut.'" and "'.$date_fin.'" order by date_fact asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT distinct * FROM facture_gazoil WHERE id_gazoil in (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.') and date_fact between "'.$date_debut.'" and "'.$date_fin.'" order by date_fact asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT distinct * FROM facture_gazoil WHERE id_gazoil in (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.') and date_fact<="'.$date_fin.'" order by date_fact asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT distinct * FROM facture_gazoil WHERE id_gazoil in (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.') and date_fact>="'.$date_debut.'" order by date_fact asc')->result_array();

        }
         // $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE id_gazoil = (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.' limit 1) ')->result_array();
         $compteur = 0;
         $montant = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                    $getOperation = $this->db->query("SELECT * FROM gazoil where id_gazoil = ".$row['id_gazoil']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['numero']."</td>";
                        }
                    }

                    echo "
                    <td>".$row['numero']."</td>
                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td> ".$row['date_fact']." </td>
                   
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
             $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE id_gazoil in (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.')')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE  date_fact>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE date_fact<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE date_fact between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE id_gazoil in (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.') and date_fact between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE id_gazoil in (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.') and date_fact<="'.$date_fin.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE id_gazoil in (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.') and date_fact>="'.$date_debut.'"')->result_array();

        }
         // $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE id_gazoil = (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.' limit 1) ')->result_array();
         $compteur = 0;
         $montant = 0;
        foreach ($query1 as $row) {
            
                  $montant = $montant+$row['montant'];
        }
       return $montant;

       $this->db->close();
    }

    public function selectAllTotalFacturePourBalanceFacture(){
        $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE id_gazoil in (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.')')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE  date_fact>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE date_fact<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE date_fact between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE id_gazoil in (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.') and date_fact between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE id_gazoil in (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.') and date_fact<="'.$date_fin.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE id_gazoil in (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.') and date_fact>="'.$date_debut.'"')->result_array();

        }
         // $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE id_gazoil = (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.' limit 1) ')->result_array();
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
             $query1 = $this->db->query('SELECT * FROM reglement_gazoil  WHERE  id_fournisseur='.$id_fournisseur.' order by date_reg asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_gazoil  WHERE  date_reg>="'.$date_debut.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_gazoil WHERE  date_reg<="'.$date_fin.'" order by date_reg asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_gazoil WHERE  date_reg between "'.$date_debut.'" and "'.$date_fin.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_gazoil WHERE  date_reg between "'.$date_debut.'" and "'.$date_fin.'" and id_fournisseur='.$id_fournisseur.' order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_gazoil WHERE  date_reg<="'.$date_fin.'" and id_fournisseur='.$id_fournisseur.' order by date_reg asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_gazoil WHERE  date_reg<="'.$date_debut.'" and id_fournisseur='.$id_fournisseur.' order by date_reg asc')->result_array();

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
             $query1 = $this->db->query('SELECT * FROM reglement_gazoil  WHERE  id_fournisseur='.$id_fournisseur.'')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_gazoil  WHERE  date_reg>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_gazoil WHERE  date_reg<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_gazoil WHERE  date_reg between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_gazoil WHERE  date_reg between "'.$date_debut.'" and "'.$date_fin.'" and id_fournisseur='.$id_fournisseur.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_gazoil WHERE  date_reg<="'.$date_fin.'" and id_fournisseur='.$id_fournisseur.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_gazoil WHERE  date_reg<="'.$date_debut.'" and id_fournisseur='.$id_fournisseur.'')->result_array();

        }
         $compteur = 0;
         $montant = 0;
        foreach ($query1 as $tab) {
        $montant = $montant+$tab['montant'];
                         
        }
        return $montant;

        $this->db->close();
    }


    public function soldeCaisseFournisseur(){
    echo $this->selectAllTotalFacturePourBalanceFournisseur()+$this->soldeInitialFournisseur()-$this->selectAllTotalReglementPourBalanceFournisseur();
}

public function getMontantNumeroFacture($numero){
            $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT montant,date_fact  FROM facture_gazoil WHERE id_gazoil in (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.') and numero="'.$numero.'" order by date_fact asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT distinct(numero),montant,date_fact  FROM facture_gazoil WHERE  date_fact>="'.$date_debut.'" and numero="'.$numero.'" order by date_fact asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT distinct(numero),montant,date_fact  FROM facture_gazoil WHERE date_fact<="'.$date_fin.'" and numero="'.$numero.'" order by date_fact asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT distinct(numero),montant,date_fact  FROM facture_gazoil WHERE date_fact between "'.$date_debut.'" and "'.$date_fin.'" and numero="'.$numero.'" order by date_fact asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT distinct(numero),montant,date_fact  FROM facture_gazoil WHERE id_gazoil in (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.') and date_fact between "'.$date_debut.'" and "'.$date_fin.'" and numero="'.$numero.'" order by date_fact asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT distinct(numero),montant,date_fact FROM facture_gazoil WHERE id_gazoil in (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.') and date_fact<="'.$date_fin.'" and numero="'.$numero.'" order by date_fact asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT distinct(numero),montant,date_fact  FROM facture_gazoil WHERE id_gazoil in (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.') and date_fact>="'.$date_debut.'" and numero="'.$numero.'" order by date_fact asc')->result_array();

        }
$total = 0;
        foreach ($query1 as $row) {
            # code...
            $total = $total+$row['montant'];
        }
    return $total;

    $this->db->close();
}

public function selectAllFacturePourBalanceFacture(){
        $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT distinct(numero),montant,date_fact  FROM facture_gazoil WHERE id_gazoil in (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.') order by date_fact asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT distinct(numero),montant,date_fact  FROM facture_gazoil WHERE  date_fact>="'.$date_debut.'" order by date_fact asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT distinct(numero),montant,date_fact  FROM facture_gazoil WHERE date_fact<="'.$date_fin.'" order by date_fact asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT distinct(numero),montant,date_fact  FROM facture_gazoil WHERE date_fact between "'.$date_debut.'" and "'.$date_fin.'" order by date_fact asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT distinct(numero),montant,date_fact  FROM facture_gazoil WHERE id_gazoil in (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.') and date_fact between "'.$date_debut.'" and "'.$date_fin.'" order by date_fact asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT distinct(numero),montant,date_fact FROM facture_gazoil WHERE id_gazoil in (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.') and date_fact<="'.$date_fin.'" order by date_fact asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT distinct(numero),montant,date_fact  FROM facture_gazoil WHERE id_gazoil in (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.') and date_fact>="'.$date_debut.'" order by date_fact asc')->result_array();

        }
         // $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE id_gazoil = (SELECT id_gazoil from gazoil where id_fournisseur='.$id_fournisseur.' limit 1) ')->result_array();
         $compteur = 0;
         $montant = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                    // $getOperation = $this->db->query("SELECT * FROM gazoil where id_gazoil = ".$row['id_gazoil']."")->result_array();

                    // if (count($getOperation)>0) {
                    //     # code...
                    //     foreach ($getOperation as $tab) {
                    //         # code...
                    //         echo"<td>".$tab['numero']."</td>";
                    //     }
                    // }

                    echo "
                    <td>".$row['numero']."</td>
                    <td>".number_format($this->getMontantNumeroFacture($row['numero']),0,',',' ')."</td>
                    <td> ".$row['date_fact']." </td>
                   
                  </tr>

                  ";
                  $montant = $montant+$row['montant'];
                  $compteur++;
                  
        }

        $this->db->close();
       
    }

public function soldeCaisseFacture(){
    echo $this->selectAllTotalFacturePourBalanceFacture()+$this->soldeInitialFournisseur()-$this->selectAllTotalReglementPourBalanceFournisseur();

    $this->db->close();
    }


    // public function deleteFournisseurArticle($table, $identifiant, $nom_id){

    //     $getCamion = $this->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

    //     if (count($getCamion)>0) {
    //       # code...
    //       $nom_table = $table;
    //       $heure = date("H:i:s");
    //       $date_notif = date("d-m-Y");
    //       $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé le fournisseur article ".$getCamion->nom." de téléphone ".$getCamion->telephone." le ".$date_notif." à ".$heure;


    //           $suppression = $this->db->query("delete from ".$table." where ".$nom_id."=".$identifiant."");
    //        if ($suppression == true) {
    //            # code...
    //           echo "Suppression effectuée";
    //           $this->notificationAjout($nom_table,addslashes($message));
    //        }else{
    //           echo "Erreur lors de la suppression";
    //        }
    //     }
         

    //      $this->db->close();
    // }

    public function getFournisseurGasoil($id_fournisseur){
      $query = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur = ".$id_fournisseur."")->row();

      if (count($query)>0) {
        # code...
        return $query->nom;
      }
    }
    public function deleteFactureFournisseurGasoil($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé la facture gasoil du fournisseur ".$this->getFournisseurGasoil($getCamion->id_fournisseur).", de N° ".$getCamion->numero." d'un montant d'un ".$getCamion->montant." le ".$date_notif." à ".$heure;


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


   public function deleteReglementFournisseurGasoil($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé le règlement des facture gasoil du fournisseur ".$this->getFournisseurGasoil($getCamion->id_fournisseur).", de N° ".$getCamion->numero." d'un montant d'un ".$getCamion->montant." le ".$date_notif." à ".$heure;


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
	
	public function verifiDateInitialClient(){
  $id_client = $_POST["id_client"];
  $date_initial = $_POST["date_initial"];

  $query = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur=".$id_client."")->row();

if (count($query)>0) {
  # code...
  if ($date_initial < date("Y-m-d",strtotime($query->date_fournisseur))) {
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

  $query = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur=".$id_client."")->row();

if (count($query)>0) {
  # code...
  return $query->date_fournisseur;
 }else{

 }
}    

public function getSoldeInitialClient(){
  $id_client = $_POST["id_client"];

  $query = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur=".$id_client."")->row();

if (count($query)>0) {
  # code...
  return $query->solde;
 }else{
  return 0;
 }
}

public function getClient($id_client){
  $query = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur =".$id_client."")->row();
  if (count($query)>0) {
    # code...
    return $query->nom;
  }
}

public function getAdresseClient($id_client){
  $query = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur =".$id_client."")->row();
  if (count($query)>0) {
    # code...
    return $query->adresse;
  }
}
public function getVilleClient($id_client){
  $query = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur =".$id_client."")->row();
  if (count($query)>0) {
    # code...
    return $query->ville;
  }
}

public function getTelephoneClient($id_client){
  $query = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur =".$id_client."")->row();
  if (count($query)>0) {
    # code...
    return $query->telephone;
  }
}

public function soldeCaisseClient2(){
    echo $this->repportNouveau3()-$this->selectAllTotalAccuseReglementPourBalanceClient()+$this->totalFacturePourBalanceClient();
}

public function repportNouveau3(){

    $id_fournisseur = $_POST["id_fournisseur"];
    $id_client = $_POST["id_fournisseur"];

        
        $date_fin =date("Y-m-d",strtotime($_POST["date_debut"].'- 1 day'));
        $date_fin = strval($date_fin);
    $getDateInitialClient = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur=".$id_client."")->row();
    $soldeInitial=0;
if (count($getDateInitialClient)>0) {
  # code...
  $soldeInitial= $getDateInitialClient->solde;
  $date_debut = $getDateInitialClient->date_fournisseur;
 }else{
  $date_debut = "";
 }
 // echo $date_fin;
  return $soldeInitial-$this->selectAllTotalAccuseReglementPourRepport($id_fournisseur,$date_debut, $date_fin )+$this->totalFacturePourRepport($id_fournisseur,$date_debut, $date_fin );
}

public function selectAllTotalAccuseReglementPourRepport($id_fournisseur,$date_debut, $date_fin ){
      
        $montant = 0;
     

        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT  * FROM reglement_gazoil WHERE id_fournisseur = '.$id_fournisseur.' order by date_reg asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_gazoil WHERE  date_reg>="'.$date_debut.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_gazoil WHERE date_reg<="'.$date_fin.'" order by date_reg asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_gazoil WHERE date_reg between "'.$date_debut.'" and "'.$date_fin.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_gazoil WHERE id_fournisseur = '.$id_fournisseur.' and date_reg between "'.$date_debut.'" and "'.$date_fin.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_gazoil WHERE id_fournisseur = '.$id_fournisseur.' and date_reg<="'.$date_fin.'" order by date_reg asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_gazoil WHERE id_fournisseur = '.$id_fournisseur.' and date_reg>="'.$date_debut.'" order by date_reg asc')->result_array();

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
             $query1 = $this->db->query('SELECT  * FROM facture_gazoil WHERE id_fournisseur='.$id_fournisseur.' order by date_fact asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE  date_fact>="'.$date_debut.'" order by date_fact asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE date_fact<="'.$date_fin.'" order by date_fact asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE date_fact between "'.$date_debut.'" and "'.$date_fin.'" order by date_fact asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE id_fournisseur ='.$id_fournisseur.' and date_fact between "'.$date_debut.'" and "'.$date_fin.'" order by date_fact asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE id_client='.$id_fournisseur.' and date_fact<="'.$date_fin.'" order by date_fact asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE id_client ='.$id_fournisseur.' and date_fact>="'.$date_debut.'" order by date_fact asc')->result_array();

        }
         // $query1 = $this->db->query('SELECT * from commande group by num_com order by date_com asc')->result_array();
         $compteur = 0;
         $total = 0;
         $montant =0;
        foreach ($query1 as $row) {
            # code...
          
            # code...
          
             
              $montant = $row['montant']+$montant;
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
             $query1 = $this->db->query('SELECT  * FROM reglement_gazoil WHERE id_fournisseur = '.$id_fournisseur.' order by date_reg asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_gazoil WHERE  date_reg>="'.$date_debut.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_gazoil WHERE date_reg<="'.$date_fin.'" order by date_reg asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_gazoil WHERE date_reg between "'.$date_debut.'" and "'.$date_fin.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_gazoil WHERE id_fournisseur = '.$id_fournisseur.' and date_reg between "'.$date_debut.'" and "'.$date_fin.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_gazoil WHERE id_fournisseur = '.$id_fournisseur.' and date_reg<="'.$date_fin.'" order by date_reg asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_gazoil WHERE id_fournisseur = '.$id_fournisseur.' and date_reg>="'.$date_debut.'" order by date_reg asc')->result_array();

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
             $query1 = $this->db->query('SELECT  * FROM facture_gazoil WHERE id_fournisseur='.$id_fournisseur.' order by date_fact asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE  date_fact>="'.$date_debut.'" order by date_fact asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE date_fact<="'.$date_fin.'" order by date_fact asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE date_fact between "'.$date_debut.'" and "'.$date_fin.'" order by date_fact asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE id_fournisseur ='.$id_fournisseur.' and date_fact between "'.$date_debut.'" and "'.$date_fin.'" order by date_fact asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE id_fournisseur='.$id_fournisseur.' and date_fact<="'.$date_fin.'" order by date_fact asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_gazoil WHERE id_fournisseur ='.$id_fournisseur.' and date_fact>="'.$date_debut.'" order by date_fact asc')->result_array();

        }
         // $query1 = $this->db->query('SELECT * from commande group by num_com order by date_com asc')->result_array();
         $compteur = 0;
         $total = 0;
         $montant =0;
        foreach ($query1 as $row) {
            # code...
         
             
              $montant = $row['montant']+$montant;
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
    $getDateInitialClient = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur=".$id_client."")->row();
    $soldeInitial=0;
if (count($getDateInitialClient)>0) {
  # code...
  $soldeInitial= $getDateInitialClient->solde;
  $date_debut = $getDateInitialClient->date_fournisseur;
 }else{
  $date_debut = "";
 }
 // echo $date_fin;
  return $soldeInitial-$this->selectAllTotalAccuseReglementPourRepport($id_fournisseur,$date_debut, $date_fin )+$this->totalFacturePourRepport($id_fournisseur,$date_debut, $date_fin );
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
    $getDateInitialClient = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur=".$id_client."")->row();
    $soldeInitial=0;
if (count($getDateInitialClient)>0) {
  # code...
  $soldeInitial= $getDateInitialClient->solde;
  $date_debut = $getDateInitialClient->date_fournisseur;
 }else{
  $date_debut = "";
 }
 // echo $date_fin;
  return $this->selectAllTotalAccuseReglementPourRepport($id_fournisseur,$date_debut, $date_fin );
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
    $getDateInitialClient = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur=".$id_client."")->row();
    $soldeInitial=0;
if (count($getDateInitialClient)>0) {
  # code...
  $soldeInitial= $getDateInitialClient->solde;
  $date_debut = $getDateInitialClient->date_fournisseur;
 }else{
  $date_debut = "";
 }
 // echo $date_fin;
  return $this->totalFacturePourRepport($id_fournisseur,$date_debut, $date_fin );
}

public function getCreditPourBalanceImpCLient(){
  return $this->selectAllTotalAccuseReglementPourBalanceClient();
}

public function getDebitPourBalanceImpCLient(){
  return $this->totalFacturePourBalanceClient();
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



 // $getAllNumFactureClient = $this->db->query('SELECT * from facture_commercial where id_client = '.$id_client.' and date_fact ="'.$date_debut.'"')->result_array();
  $montant = 0;
  $total=0;

    $getAccuseReglement = $this->db->query('SELECT * from reglement_gazoil where id_fournisseur = '.$id_client.' and date_reg ="'.$date_debut.'"')->result_array();
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

      $getFactureClient = $this->db->query("SELECT * from facture_gazoil where id_fournisseur=".$id_client." and date_fact='".$date_debut."' group by numero")->result_array();
  if (count($getFactureClient)>0) {
    # code...
      foreach ($getFactureClient as $factureClient) {
    # code...
        // $solde =$this->getSoldeInitialClient()+$this->getTotalAccuseReglementParClientPourBalance($id_client,$date_debut,$date_fin)+$this->getTotalAvisCreditParClientPourBalance($id_client,$date_debut,$date_fin)-$this->getTotalAvisDebitParClientPourBalance($id_client,$date_debut,$date_fin)-$this->getTotalAccuseRetraitParClientPourBalance($id_client,$date_debut,$date_fin)-$this->getTotalFactureParClientPourBalance($id_client,$date_debut)-$this->getTotalFactureArticleParClientPourBalance($id_client,$date_debut);
        
		$totalFactureCLient =$factureClient['montant']+$totalFactureCLient;
  
$debit = $factureClient['montant'];

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
   


  // $getAllNumFactureClient = $this->db->query('SELECT * from facture_commercial where id_client = '.$id_client.' and date_fact ="'.$date_debut.'"')->result_array();
  $montant = 0;
  $total=0;
 // foreach ($getAllNumFactureClient as $num_facture) {
    $getAccuseReglement = $this->db->query('SELECT * from reglement_gazoil where id_fournisseur = '.$id_client.' and date_reg ="'.$date_debut.'"')->result_array();
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
        <td style='border: 2px solid black;'>".$reglement['type']."</td>
        <td style='border: 2px solid black;'>".number_format($credit1,0,',',' ')."</td>
        <td style='border: 2px solid black;'>0</td>
        
        <td style='border: 2px solid black;'>".number_format($solde,0,',',' ')."</td>
    </tr>";

    $totalSolde = $totalSolde + $solde;
	$compteur1++;
  }
  }

      $getFactureClient = $this->db->query("SELECT * from facture_gazoil where id_fournisseur =".$id_client." and date_fact='".$date_debut."' group by numero")->result_array();
  if (count($getFactureClient)>0) {
    # code...
      foreach ($getFactureClient as $factureClient) {
      $totalFactureCLient =$factureClient['montant']+$totalFactureCLient;
	$debit = $factureClient['montant'];
	$debit3 = $debit + $debit3;

       
    $RN =$RN+$debit;
        
    $solde =$RN;
 
 echo "<tr style='border: 2px solid black;'>
        <td style='border: 2px solid black;'>".$date_debut."</td>
        <td style='border: 2px solid black;'>".$factureClient['numero']."</td>
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
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($totalCredit,0,',',' ')."</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($totalDebit,0,',',' ')."</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($this->getSoldeBalanceImprimableClient(),0,',',' ')."</td>
    </tr>";
  }

	
	

}