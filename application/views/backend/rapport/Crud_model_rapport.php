<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model_rapport extends CI_Model {
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

public function leSelectTypeVehicule(){

    $getAllType = $this->db->query("SELECT * from type_vehicule where nom_type like '%tract%'")->result_array();

    foreach ($getAllType as $type) {
        # code...
        echo "<option value='".$type['id_type']."'>".$type['nom_type']."</option>";
    }

    $this->db->close();
}


public function leSelectTypeEngin(){

    $getAllType = $this->db->query("SELECT * from type_vehicule where nom_type like '%eng%'")->result_array();

    foreach ($getAllType as $type) {
        # code...
        echo "<option value='".$type['id_type']."'>".$type['nom_type']."</option>";
    }

    $this->db->close();
}

public function leSelectTypeBenne(){

    $getAllType = $this->db->query("SELECT * from type_vehicule where nom_type like '%ben%'")->result_array();

    foreach ($getAllType as $type) {
        # code...
        echo "<option value='".$type['id_type']."'>".$type['nom_type']."</option>";
    }

    $this->db->close();
}

public function leSelectTypeService(){

    $getAllType = $this->db->query("SELECT * from type_vehicule where nom_type like '%serv%'")->result_array();

    foreach ($getAllType as $type) {
        # code...
        echo "<option value='".$type['id_type']."'>".$type['nom_type']."</option>";
    }

    $this->db->close();
}


    public function selectAllLocationEnginOperationPourRapport(){
           $id_type_vehicule = $_POST["id_type_vehicule"];
 $id_operation = $id_type_vehicule;
     $getEngin = $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule."")->result_array();
           if (count($getEngin)>0) {
               # code...
           foreach ($getEngin as $engin) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  code="'.$engin['code'].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin['code'].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location<="'.$date_fin.'" and code="'.$engin['code'].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location>="'.$date_debut.'" and code="'.$engin['code'].'"')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
$compteur = 0;
    if (count($getPrime) >0 ) {
      # code...
     foreach ($getPrime as $row) {
        # code...
$getOperation = $this->db->query("SELECT * from operation where id_operation = ".$row['id_operation']." limit 1")->row();
        echo "<tr><td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['code']."</td>
                    <td>".$getOperation->nom_op."</td>
                    <td> ".$row['duree']." ".$row['unite']."(s)</td>
                    <td>".number_format($row['montant'],3,'.',' ')."</td>
                    <td>".number_format($row['montant']*$row['duree'],3,'.',' ')."</td>
                    <td> ".$row['date_location']."</td>
                    <td></tr>";
          $compteur++;
      }

    }else{
      // echo "nada";
    }
    $this->db->close();
           }
           
        }
    }


        public function selectAllTotalLocationEnginOperationPourRapport(){

              $id_type_vehicule = $_POST["id_type_vehicule"];
 $id_operation = $id_type_vehicule;
   $compteur = 0;
$montant10 = 0;
$montant9 = 0;
     $getEngin = $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule."")->result_array();
           if (count($getEngin)>0) {
               # code...
           foreach ($getEngin as $engin) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  code="'.$engin['code'].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin['code'].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location<="'.$date_fin.'" and code="'.$engin['code'].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location>="'.$date_debut.'" and code="'.$engin['code'].'"')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
 
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $getOperation = $this->db->query("SELECT * from operation where id_operation = ".$row['id_operation']." limit 1")->row();
         $montant10 = $row['montant']*$row['duree'];                  
         $montant9 = $montant9 + $montant10;
      }
      
    }else{
      // echo "nada";
    }

       

   
           }
           return $montant9;
        }
$this->db->close();
    }


public function selectAllChargementOperationPourRapport(){
           $id_type_vehicule = $_POST["id_type_vehicule"];
 $id_operation = $id_type_vehicule;
 $compteur = 0;
     $getTracteur = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
     $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();
           if (count($getTracteur)>0) {
               # code...
           foreach ($getTracteur as $tracteur) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  code_camion="'.$tracteur['code'].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg<="'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg>="'.$date_debut.'" and code_camion="'.$tracteur['code'].'"')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();

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

    }
  }
$this->db->close();

  if (count($getCamion)>0) {
    
    foreach ($getCamion as $tracteur) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  code_camion="'.$tracteur['code'].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg<="'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg>="'.$date_debut.'" and code_camion="'.$tracteur['code'].'"')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();

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

    }
  }
  $this->db->close();
 }



 public function selectAllTotalChargementOperationPourRapport(){
           $id_type_vehicule = $_POST["id_type_vehicule"];
 $id_operation = $id_type_vehicule;

 $compteur = 0;
$total1 = 0;
$montant1=0;

$total = 0;
$montant=0;
     $getTracteur = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
     $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();
           if (count($getTracteur)>0) {
               # code...
           foreach ($getTracteur as $tracteur) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  code_camion="'.$tracteur['code'].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg<="'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg>="'.$date_debut.'" and code_camion="'.$tracteur['code'].'"')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {

        $montant  = $montant + $row['montant'];
        
      }
    }else{
      // echo "nada";
    }
$this->db->close();
        // return $montant;
    }
  }

  if (count($getCamion)>0) {
    
    foreach ($getCamion as $tracteur) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  code_camion="'.$tracteur['code'].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg<="'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg>="'.$date_debut.'" and code_camion="'.$tracteur['code'].'"')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {

        $montant1  = $montant1 + $row['montant'];
        
      }
    }else{
      // echo "nada";
    }

    $this->db->close();

        // return $montant;
       }
    }
     return $montant+$montant1;
 }


     public function selectAllFactureOperationPourRapport(){
           $id_type_vehicule = $_POST["id_type_vehicule"];
           $id_operation = $id_type_vehicule;
           $compteur = 0;
     $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
     $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();
           if (count($getEngin)>0) {
               # code...
           foreach ($getEngin as $engin) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  code_camion="'.$engin['code'].'"')->result_array();
        }elseif (empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_type_vehicule) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_type_vehicule) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl<="'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl>="'.$date_debut.'" and code_camion="'.$engin['code'].'"')->result_array();

        }
        // else{
        //     $getPrime = $this->db->query("SELECT * FROM bon_livraison ")->result_array();
        // }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
        echo $id_type_vehicule;

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $getDstination = $this->db->query("SELECT * from distance_littrage where id_distance = ".$row['id_destination_litrage']."")->row();
        $total = $row['quantite']*$row['prix_unitaire'];
        echo "<tr><td>".$compteur."</td>
              <td>".$row['numero']."</td>
              <td>".$engin['code']."</td>
              <td>".number_format($row['prix_unitaire'],3,'.',' ')."</td>
             <td>".$row['quantite']."</td>
              <td>".number_format($total,3,'.',' ')."</td>
              <td>".$row['date_bl']."</td>
              <td>".$getDstination->distance."</td>
              <td>".$getDstination->kilometrage."</td>
              <td>".$row['unite']."</td> </tr>";
          $compteur++;
      }
    }else{
      // echo "nada";
    }

    $this->db->close();
           }
           
        }

     if (count($getCamion)>0) {
    
    foreach ($getCamion as $engin) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  code_camion="'.$engin['code'].'"')->result_array();
        }elseif (empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_type_vehicule) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_type_vehicule) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl<="'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl>="'.$date_debut.'" and code_camion="'.$engin['code'].'"')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
       foreach ($getPrime as $row) {
        # code...
        $getDstination = $this->db->query("SELECT * from distance_littrage where id_distance = ".$row['id_destination_litrage']."")->row();
        $total = $row['quantite']*$row['prix_unitaire'];
        echo "<tr><td>".$compteur."</td>
              <td>".$row['numero']."</td>
              <td>".$engin['code']."</td>
              <td>".number_format($row['prix_unitaire'],3,'.',' ')."</td>
             <td>".$row['quantite']."</td>
              <td>".number_format($total,3,'.',' ')."</td>
              <td>".$row['date_bl']."</td>
              <td>".$getDstination->distance."</td>
              <td>".$getDstination->kilometrage."</td>
              <td>".$row['unite']."</td> </tr>";
          $compteur++;
      }
    }else{
      // echo "nada";
    }

    }

    }
  $this->db->close(); 
}


public function selectAllDepensePneuOperationPourRapport(){

           $id_type_vehicule = $_POST["id_type_vehicule"];
$id_operation = $id_type_vehicule;
$compteur = 0;
     $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
     $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();
        

           $getEngin2= $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule."")->result_array();
      $getService= $this->db->query("SELECT * from voitureservice where id_type_camion=".$id_type_vehicule."")->result_array();
      
       if (count($getEngin)>0) {
        $vehicule = $getEngin;
       }elseif (count($getEngin2)>0) {
         # code...
        $vehicule = $getEngin2;
       }elseif (count($getService)>0) {
         # code...
        $vehicule = $getService;
       }elseif (count($getCamion)>0) {
         # code...
        $vehicule = $getCamion;
       }
               # code...
           foreach ($vehicule as $engin) {

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  code_camion="'.$engin['code'].'"')->result_array();
        }elseif (empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_type_vehicule) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_type_vehicule) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense<="'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense>="'.$date_debut.'" and code_camion="'.$engin['code'].'"')->result_array();

        }
         
         
        foreach ($getPrime as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>     
                    <td>".$row['code_camion']."</td>";
                    $getArticle = $this->db->query("SELECT * from article where id_article = ".$row['id_article']."")->row();

                    echo"
                    <td> ".$getArticle->article." </td>
                    <td> ".$row['type']." </td>
                    <td> ".$row['derniereDate']." </td>
                    <td> ".$row['date_depense']." </td>
                    <td> ".$row['prix_unitaire']." </td>
                    <td> ".$row['qtite']." </td>
                    <td> ".$row['qtite']*$row['prix_unitaire']." </td>
                    
                    <td> ".$row['commentaire']." </td>
                   
                  </tr>

                  ";
                  $compteur++;
        }
    
}

$this->db->close();
}

public function selectAllTotalDepensePneuOperationPourRapport(){

           $id_type_vehicule = $_POST["id_type_vehicule"];
$id_operation = $id_type_vehicule;
$compteur = 0;
$total = 0;
$montant = 0;
     $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
     $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();
        

     $getService= $this->db->query("SELECT * from voitureservice where id_type_camion=".$id_type_vehicule."")->result_array();
      
       if (count($getEngin)>0) {
        $vehicule = $getEngin;
       }elseif (count($getEngin2)>0) {
         # code...
        $vehicule = $getEngin2;
       }elseif (count($getService)>0) {
         # code...
        $vehicule = $getService;
       }elseif (count($getCamion)>0) {
         # code...
        $vehicule = $getCamion;
       }
               # code...
           foreach ($vehicule as $engin) {

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  code_camion="'.$engin['code'].'"')->result_array();
        }elseif (empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_type_vehicule) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_type_vehicule) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense<="'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense>="'.$date_debut.'" and code_camion="'.$engin['code'].'"')->result_array();

        }
         
         
        foreach ($getPrime as $row) {
            # code...

            
                 $montant = $row['qtite']*$row['prix_unitaire'];

                 $total = $total + $montant;                 
        }
    
}
return $total;
$this->db->close();
}




    public function selectAllTotalFactureOperationPourRapport(){
           $id_type_vehicule = $_POST["id_type_vehicule"];
$id_operation = $id_type_vehicule;
     $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
     $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();
     $montant1=0;
     $montant=0;
     $compteur = 0;
    $total1 = 0;
    $montant1=0;

    $montant2=0;
           if (count($getEngin)>0) {
               # code...
           foreach ($getEngin as $engin) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  code_camion="'.$engin['code'].'"')->result_array();
        }elseif (empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_type_vehicule) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_type_vehicule) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl<="'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl>="'.$date_debut.'" and code_camion="'.$engin['code'].'"')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();


    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {

        $total1 = $row['quantite']*$row['prix_unitaire'];
        $montant2 = $total1+ $montant2;
      }
    }else{
      // echo "nada";
    }
    // $montant1 = $montant1+$montant2;
        // return $montant;
           }
           
        }
        $this->db->close();
$total = 0;
$montant=0;
     if (count($getCamion)>0) {
    
    foreach ($getCamion as $engin) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  code_camion="'.$engin['code'].'"')->result_array();
        }elseif (empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_type_vehicule) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_type_vehicule) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl<="'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl>="'.$date_debut.'" and code_camion="'.$engin['code'].'"')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
$compteur = 0;

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {

 // $montant  = $montant + $row['montant'];
        $total = $row['quantite']*$row['prix_unitaire'];
        $montant = $total+ $montant;
      }
    }else{
      // echo "nada";
    }

        // return $montant;

    }

        
    }
    return $montant+$montant2;

    $this->db->close();
}


 public function selectAllPrimeOperationPourRapport(){
           $id_type_vehicule = $_POST["id_type_vehicule"];
           $id_operation = $id_type_vehicule;
$compteur = 0;
     $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
     $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();
     $getEngin2 = $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule."")->result_array();
          
    $getService= $this->db->query("SELECT * from voitureservice where id_type_camion=".$id_type_vehicule."")->result_array();
      
       if (count($getEngin)>0) {
        $vehicule = $getEngin;
       }elseif (count($getEngin2)>0) {
         # code...
        $vehicule = $getEngin2;
       }elseif (count($getService)>0) {
         # code...
        $getEngin = $getService;
       }elseif (count($getCamion)>0) {
         # code...
        $vehicule = $getCamion;
       }
           if (count($getEngin)>0) {
               # code...
           foreach ($getEngin as $engin) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  code_camion="'.$engin['code'].'"')->result_array();
        }elseif (empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_type_vehicule) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_type_vehicule) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime>="'.$date_debut.'" and code_camion="'.$engin['code'].'"')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();

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
        // return $montant;
           }
           }
           
              $this->db->close();

           if (count($getEngin2)>0) {
               # code...
           foreach ($getEngin2 as $engin) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  code_camion="'.$engin['code'].'"')->result_array();
        }elseif (empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_type_vehicule) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_type_vehicule) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime>="'.$date_debut.'" and code_camion="'.$engin['code'].'"')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();

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
        // return $montant;
           }
           }
$this->db->close();

     if (count($getCamion)>0) {
    
    foreach ($getCamion as $tracteur) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  code_camion="'.$tracteur['code'].'"')->result_array();
        }elseif (empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_type_vehicule) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_type_vehicule) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime>="'.$date_debut.'" and code_camion="'.$tracteur['code'].'"')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
       
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
        // return $montant;

        }

    }

    $this->db->close();
 }


     public function selectAllTotalPrimeOperationPourRapport(){
           $id_type_vehicule = $_POST["id_type_vehicule"];
           $id_operation = $id_type_vehicule;
$compteur = 0;
$total = 0;
$montant=0;

$total = 0;
$montant1=0;

$total2 = 0;
$montant2=0;
     $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
     $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();
     $getEngin2= $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule."")->result_array();
    
    $getService= $this->db->query("SELECT * from voitureservice where id_type_camion=".$id_type_vehicule."")->result_array();
      
       if (count($getEngin)>0) {
        $vehicule = $getEngin;
       }elseif (count($getEngin2)>0) {
         # code...
        $vehicule = $getEngin2;
       }elseif (count($getService)>0) {
         # code...
        $getEngin = $getService;
       }elseif (count($getCamion)>0) {
         # code...
        $vehicule = $getCamion;
       }


       if (count($getEngin)>0) {
               # code...
           foreach ($getEngin as $engin) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  code_camion="'.$engin['code'].'"')->result_array();
        }elseif (empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_type_vehicule) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_type_vehicule) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime>="'.$date_debut.'" and code_camion="'.$engin['code'].'"')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {

        $total = $row['montant'];
        $montant1 = $total+ $montant1;
      }
    }else{
      // echo "nada";
    }

        // return $montant;
           }
           
        }

$this->db->close();

   if (count($getEngin2)>0) {
               # code...
           foreach ($getEngin2 as $engin) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  code_camion="'.$engin['code'].'"')->result_array();
        }elseif (empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_type_vehicule) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_type_vehicule) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime>="'.$date_debut.'" and code_camion="'.$engin['code'].'"')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {

        $total = $row['montant'];
        $montant2 = $total+ $montant2;
      }
    }else{
      // echo "nada";
    }

        // return $montant;
           }
           
        }

$this->db->close();
     if (count($getCamion)>0) {
    
    foreach ($getCamion as $tracteur) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  code_camion="'.$tracteur['code'].'"')->result_array();
        }elseif (empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_type_vehicule) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_type_vehicule) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime>="'.$date_debut.'" and code_camion="'.$tracteur['code'].'"')->result_array();

        }else{
          // echo 'cetrs movè'.$id_type_vehicule;
        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {

        $total = $row['montant'];
        $montant = $total+ $montant;
      }
    }else{
      // echo "nada";
    }

        // return $montant;

    }

        
    }

    return $montant+$montant1+$montant2;

    $this->db->close();
}

    public function selectAllFraisRouteOperationPourRapport(){

      $id_type_vehicule = $_POST["id_type_vehicule"];
      $id_operation = $id_type_vehicule;
$compteur = 0;
     $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
     $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

$getService= $this->db->query("SELECT * from voitureservice where id_type_camion=".$id_type_vehicule."")->result_array();
      
       if (count($getEngin)>0) {
        $vehicule = $getEngin;
       }elseif (count($getEngin2)>0) {
         # code...
        $vehicule = $getEngin2;
       }elseif (count($getService)>0) {
         # code...
        $getEngin = $getService;
       }elseif (count($getCamion)>0) {
         # code...
        $vehicule = $getCamion;
       }
          if (count($getEngin)>0) {
               # code...
           foreach ($getEngin as $engin) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            // $getPrime = $this->db->query('SELECT * FROM frais_route')->result_array();
        }

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
                        $kilometrage ="";
                    }
        echo "<tr><td>".$compteur."</td>
              <td>".$row['code_camion']."</td>
              <td>".number_format($row['montant'],0,',',' ')." FCFA</td>
               <td>".addslashes($distance)."</td>
               <td>".$kilometrage."</td>
              <td>".$row['date_frais']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }
  }
  }

  if (count($getCamion)>0) {

   foreach ($getEngin as $engin) {
       $date_debut = $_POST["date_debut"];
       $date_fin = $_POST["date_fin"];

       if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            // $getPrime = $this->db->query('SELECT * FROM frais_route')->result_array();
        }

     
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
$getDistance = $this->db->query("SELECT * FROM distance_littrage where id_distance = ".$row['id_distance']."")->row();
                    if (count($getDistance)>0) {
                      $distance = $getDistance->distance;
                        $kilometrage = $getDistance->kilometrage;
                    }else{
                        $distance = "";
                        $kilometrage ="";
                    }
        echo "<tr><td>".$compteur."</td>
              <td>".$row['code_camion']."</td>
              <td>".number_format($row['montant'],0,',',' ')." FCFA</td>
               <td>".addslashes($distance)."</td>
               <td>".$kilometrage."</td>
              <td>".$row['date_frais']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }
  }
}

$this->db->close();
}


  public function selectAllTotalFraisRouteOperationPourRapport(){

      $id_type_vehicule = $_POST["id_type_vehicule"];
      $id_operation = $id_type_vehicule;
$compteur = 0;
     $montant1 =0;
       $total1 = 0;
       $montant =0;
       $total = 0;
     $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
     $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
    $getService= $this->db->query("SELECT * from voitureservice where id_type_camion=".$id_type_vehicule."")->result_array();
      
       if (count($getEngin)>0) {
        $vehicule = $getEngin;
       }elseif (count($getEngin2)>0) {
         # code...
        $vehicule = $getEngin2;
       }elseif (count($getService)>0) {
         # code...
        $getEngin = $getService;
       }elseif (count($getCamion)>0) {
         # code...
        $vehicule = $getCamion;
       }


          if (count($getEngin)>0) {
               # code...
           foreach ($getEngin as $engin) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            // $getPrime = $this->db->query('SELECT * FROM frais_route')->result_array();
        }

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {

       // $montant = $row['montant'];
       
       $total = $total + $row['montant'];
      }
    }else{
      // echo "nada";
    }
  }
  }

  if (count($getCamion)>0) {

   foreach ($getEngin as $engin) {
       $date_debut = $_POST["date_debut"];
       $date_fin = $_POST["date_fin"];

       if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            // $getPrime = $this->db->query('SELECT * FROM frais_route')->result_array();
        }

     
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
// $montant1 = $montant1 + $row['montant'];
       
       $total1 = $total1 + $row['montant'];
      }
    }else{
      // echo "nada";
    }
  }
}

return $total1 +$total;

$this->db->close();
}


    public function selectAllFraisDiversOperationPourRapport(){

      $id_type_vehicule = $_POST["id_type_vehicule"];
      $id_operation = $id_type_vehicule;
$compteur = 0;
     $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
     $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();

     $getEngin2= $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule."")->result_array();

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
      $getService= $this->db->query("SELECT * from voitureservice where id_type_camion=".$id_type_vehicule."")->result_array();
      
       if (count($getEngin)>0) {
        $vehicule = $getEngin;
       }elseif (count($getEngin2)>0) {
         # code...
        $vehicule = $getEngin2;
       }elseif (count($getService)>0) {
         # code...
        $getEngin = $getService;
       }elseif (count($getCamion)>0) {
         # code...
        $vehicule = $getCamion;
       }


          if (count($getEngin)>0) {
               # code...
           foreach ($getEngin as $engin) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            // $getPrime = $this->db->query('SELECT * FROM frais_route')->result_array();
        }

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...

        echo "<tr><td>".$compteur."</td>
              <td>".$row['code_camion']."</td>
              <td>".number_format($row['montant'],0,',',' ')." FCFA</td>
               <td>".$row['commentaire']."</td>
              <td>".$row['date_frais']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }
  }

  $this->db->close();
  }

            if (count($getEngin2)>0) {
               # code...
           foreach ($getEngin2 as $engin) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            // $getPrime = $this->db->query('SELECT * FROM frais_route')->result_array();
        }

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...

        echo "<tr><td>".$compteur."</td>
              <td>".$row['code_camion']."</td>
              <td>".number_format($row['montant'],0,',',' ')." FCFA</td>
              <td>".$row['date_frais']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }
  }
  }

  if (count($getCamion)>0) {

   foreach ($getEngin as $engin) {
       $date_debut = $_POST["date_debut"];
       $date_fin = $_POST["date_fin"];

       if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            // $getPrime = $this->db->query('SELECT * FROM frais_route')->result_array();
        }

     
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        echo "<tr><td>".$compteur."</td>
              <td>".$row['code_camion']."</td>
              <td>".number_format($row['montant'],0,',',' ')." FCFA</td>
              <td>".$row['date_frais']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }
  }
}

$this->db->close();
}


  public function selectAllTotalFraisDiversOperationPourRapport(){

      $id_type_vehicule = $_POST["id_type_vehicule"];
      $id_operation = $id_type_vehicule;
$compteur = 0;
     $montant1 =0;
       $total1 = 0;

       $montant2 =0;
       $total2 = 0;

       $montant =0;
       $total = 0;
     $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
     $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();
     $getEngin2 = $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule."")->result_array();

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

      $getService= $this->db->query("SELECT * from voitureservice where id_type_camion=".$id_type_vehicule."")->result_array();
      
       if (count($getEngin)>0) {
        $vehicule = $getEngin;
       }elseif (count($getEngin2)>0) {
         # code...
        $vehicule = $getEngin2;
       }elseif (count($getService)>0) {
         # code...
        $getEngin = $getService;
       }elseif (count($getCamion)>0) {
         # code...
        $vehicule = $getCamion;
       }

          if (count($getEngin)>0) {
               # code...
           foreach ($getEngin as $engin) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            // $getPrime = $this->db->query('SELECT * FROM frais_route')->result_array();
        }

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {

       // $montant = $row['montant'];
       
       $total = $total + $row['montant'];
      }
    }else{
      // echo "nada";
    }
  }
  }

    $this->db->close();

          if (count($getEngin2)>0) {
               # code...
           foreach ($getEngin2 as $engin) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            // $getPrime = $this->db->query('SELECT * FROM frais_route')->result_array();
        }

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {

       // $montant = $row['montant'];
       
       $total2 = $total2 + $row['montant'];
      }
    }else{
      // echo "nada";
    }
  }
  }

  $this->db->close();

  if (count($getCamion)>0) {

   foreach ($getEngin as $engin) {
       $date_debut = $_POST["date_debut"];
       $date_fin = $_POST["date_fin"];

       if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            // $getPrime = $this->db->query('SELECT * FROM frais_route')->result_array();
        }

     
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
// $montant1 = $montant1 + $row['montant'];
       
       $total1 = $total1 + $row['montant'];
      }
    }else{
      // echo "nada";
    }
  }
}

return $total1 +$total+$total2;

$this->db->close();
}


public function selectAllPieceRechangeOperationPourRapport(){
          $id_type_vehicule = $_POST["id_type_vehicule"];
          $id_operation = $id_type_vehicule;
$compteur = 0;
     $montant1 =0;
       $total1 = 0;
       $montant =0;
       $total = 0;
     $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
     $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();

     $getEngin2 = $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule."")->result_array();

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
     $getService= $this->db->query("SELECT * from voitureservice where id_type_camion=".$id_type_vehicule."")->result_array();
      
       if (count($getEngin)>0) {
        $vehicule = $getEngin;
       }elseif (count($getEngin2)>0) {
         # code...
        $vehicule = $getEngin2;
       }elseif (count($getService)>0) {
         # code...
        $getEngin = $getService;
       }elseif (count($getCamion)>0) {
         # code...
        $vehicule = $getCamion;
       }


          if (count($getEngin)>0) {
               # code...
           foreach ($getEngin as $engin) {
               # code...
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM piece_rechange')->result_array();
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
             <td>".number_format($row['qtite']*$row['prix_unitaire'],0,',',' ')."</td>
              <td>".$row['date_rech']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }
  }
}

  $this->db->close();

          if (count($getEngin2)>0) {
               # code...
           foreach ($getEngin2 as $engin) {
               # code...
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM piece_rechange')->result_array();
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
             <td>".number_format($row['qtite']*$row['prix_unitaire'],0,',',' ')."</td>
              <td>".$row['date_rech']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }
  }
}
  
  $this->db->close();

if (count($getCamion)>0) {
               # code...
           foreach ($getEngin as $engin) {
               # code...
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM piece_rechange')->result_array();
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
             <td>".number_format($row['qtite']*$row['prix_unitaire'],0,',',' ')."</td>
              <td>".$row['date_rech']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }
  }
}
$this->db->close();
  }


public function selectAllTotalPieceRechangeOperationPourRapport(){
          $id_type_vehicule = $_POST["id_type_vehicule"];
          $id_operation = $id_type_vehicule;
$compteur = 0;
     $montant1 =0;
       $total1 = 0;
       $montant =0;
       $total = 0;

       $montant2 =0;
       $total2 = 0;
     $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
     $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();

     $getEngin2 = $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule."")->result_array();

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

      $getService= $this->db->query("SELECT * from voitureservice where id_type_camion=".$id_type_vehicule."")->result_array();
      
       if (count($getEngin)>0) {
        $vehicule = $getEngin;
       }elseif (count($getEngin2)>0) {
         # code...
        $vehicule = $getEngin2;
       }elseif (count($getService)>0) {
         # code...
        $getEngin = $getService;
       }elseif (count($getCamion)>0) {
         # code...
        $vehicule = $getCamion;
       }
          if (count($getEngin)>0) {
               # code...
           foreach ($getEngin as $engin) {
               # code...
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM piece_rechange')->result_array();
        }
    // $getPrime = $this->db->query("SELECT * FROM piece_rechange where id_operation =".$id_operation."")->result_array();

     if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $getPrixUnitaire = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->result_array();

        foreach ($getPrixUnitaire as $tab) {
          # code...
          $montant = $row["prix_unitaire"]* $row["qtite"];
        }

        $total = $total+$montant;
        
        $compteur++;
      }
    }else{
      // echo "nada";
    }
  }
}
  
  $this->db->close();

          if (count($getEngin2)>0) {
               # code...
           foreach ($getEngin2 as $engin) {
               # code...
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM piece_rechange')->result_array();
        }
    // $getPrime = $this->db->query("SELECT * FROM piece_rechange where id_operation =".$id_operation."")->result_array();

     if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $getPrixUnitaire = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->result_array();

        foreach ($getPrixUnitaire as $tab) {
          # code...
          $montant = $row["prix_unitaire"]* $row["qtite"];
        }

        $total = $total+$montant;
        
        $compteur++;
      }
    }else{
      // echo "nada";
    }
  }
}

$this->db->close();

if (count($getCamion)>0) {
               # code...
           foreach ($getEngin as $engin) {
               # code...
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM piece_rechange')->result_array();
        }
    // $getPrime = $this->db->query("SELECT * FROM piece_rechange where id_operation =".$id_operation."")->result_array();

      if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $getPrixUnitaire = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->result_array();

        foreach ($getPrixUnitaire as $tab) {
          # code...
          $montant1 = $row["prix_unitaire"]* $row["qtite"];
        }

        $total = $total1+$montant1;
        
     
      }
    }else{
      // echo "nada";
    }
  }
}

return $total1+$total;

$this->db->close();
  }


public function selectAllVidangeOperationPourRapport(){

              $id_type_vehicule = $_POST["id_type_vehicule"];
              $id_operation = $id_type_vehicule;
$compteur = 0;

     $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
     $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();

     $getEngin2 = $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule."")->result_array();

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

      $getService= $this->db->query("SELECT * from voitureservice where id_type_camion=".$id_type_vehicule."")->result_array();
      
       if (count($getEngin)>0) {
        $vehicule = $getEngin;
       }elseif (count($getEngin2)>0) {
         # code...
        $vehicule = $getEngin2;
       }elseif (count($getService)>0) {
         # code...
        $getEngin = $getService;
       }elseif (count($getCamion)>0) {
         # code...
        $vehicule = $getCamion;
       }
          if (count($getEngin)>0) {
               # code...
           foreach ($getEngin as $engin) {

        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidange')->result_array();
        }

    // $getPrime = $this->db->query("SELECT * FROM vidange where id_operation =".$id_operation."")->result_array();
 
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

             echo" <td>".number_format($row['qtite'],0,',',' ')."</td> 
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
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique')->result_array();
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
             echo" <td>".number_format($row['qtite'],0,',',' ')."</td> 
             <td>".number_format($row['pu'],0,',',' ')."</td>
             <td>".number_format($prixTotal,0,',',' ')."</td>
              <td>".$row['date_vidange']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }

    $this->db->close();

if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidangeboite')->result_array();
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
             echo" <td>".number_format($row['qtite'],0,',',' ')."</td> 
             <td>".number_format($row['pu'],0,',',' ')."</td>
             <td>".number_format($prixTotal,0,',',' ')."</td>
              <td>".$row['date_vidange']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }

  }
 }

 $this->db->close();

          if (count($getEngin2)>0) {
               # code...
           foreach ($getEngin2 as $engin) {

        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidange')->result_array();
        }

    // $getPrime = $this->db->query("SELECT * FROM vidange where id_operation =".$id_operation."")->result_array();
 
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

             echo" <td>".number_format($row['qtite'],0,',',' ')."</td> 
             <td>".number_format($row['pu'],0,',',' ')." </td>
             <td>".number_format($prixTotal,0,',',' ')."</td>
              <td>".$row['date_vidange']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }

    $this->db->close();

    if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique')->result_array();
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
             echo" <td>".number_format($row['qtite'],0,',',' ')."</td> 
             <td>".number_format($row['pu'],0,',',' ')."</td>
             <td>".number_format($prixTotal,0,',',' ')."</td>
              <td>".$row['date_vidange']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }

    $this->db->close();

if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidangeboite')->result_array();
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
             echo" <td>".number_format($row['qtite'],0,',',' ')."</td> 
             <td>".number_format($row['pu'],0,',',' ')."</td>
             <td>".number_format($prixTotal,0,',',' ')."</td>
              <td>".$row['date_vidange']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }

  }
 }

    $this->db->close();

    if (count($getCamion)>0) {
               # code...
           foreach ($getCamion as $engin) {

        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidange')->result_array();
        }

    // $getPrime = $this->db->query("SELECT * FROM vidange where id_operation =".$id_operation."")->result_array();

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

             echo" <td>".number_format($row['qtite'],0,',',' ')."</td> 
             <td>".number_format($row['pu'],0,',',' ')."</td>
             <td>".number_format($prixTotal,0,',',' ')."</td>
              <td>".$row['date_vidange']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }

    $this->db->close();

    if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique')->result_array();
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
             echo" <td>".number_format($row['qtite'],0,',',' ')."</td> 
             <td>".number_format($row['pu'],0,',',' ')."</td>
             <td>".number_format($prixTotal,0,',',' ')."</td>
              <td>".$row['date_vidange']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }


    $this->db->close();


if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidangeboite')->result_array();
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
             echo" <td>".number_format($row['qtite'],0,',',' ')."</td> 
             <td>".number_format($row['pu'],0,',',' ')."</td>
             <td>".number_format($prixTotal,0,',',' ')."</td>
              <td>".$row['date_vidange']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }

  }
 }

 $this->db->close();
}

public function selectAllTotalVidangeOperationPourRapport(){
              $id_type_vehicule = $_POST["id_type_vehicule"];
              $id_operation = $id_type_vehicule;
// $compteur = 0;
//      $montant1 =0;
//        $total1 = 0;
//        $montant =0;
//        $total = 0;
              $total2=0;
               $total1=0;
     $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
     $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();

     $getEngin2 = $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule."")->result_array();

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

      $getService= $this->db->query("SELECT * from voitureservice where id_type_camion=".$id_type_vehicule."")->result_array();
      
       if (count($getEngin)>0) {
        $vehicule = $getEngin;
       }elseif (count($getEngin2)>0) {
         # code...
        $vehicule = $getEngin2;
       }elseif (count($getService)>0) {
         # code...
        $getEngin = $getService;
       }elseif (count($getCamion)>0) {
         # code...
        $vehicule = $getCamion;
       }

          if (count($getEngin)>0) {
               # code...
           foreach ($getEngin as $engin) {
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidange')->result_array();
        }
    // $getPrime = $this->db->query("SELECT * FROM vidange where id_operation =".$id_operation."")->result_array();
    $compteur = 0;
    $montant1 = 0;

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
   
            //   $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
            // foreach ($getArticle as $tab1) {
            //   # code...
            //   $montant1 =  $row["qtite"] * $tab1['PU'];
            // }
        $montant1 =  $row["qtite"] * $row['pu'];
          $total1 = $total1 + $montant1;  
      }
    }else{
      // echo "nada";
    }

    $this->db->close();

if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique')->result_array();
        }
      // $getPrime = $this->db->query("SELECT * FROM vidangeHydrolique where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...

            //   $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
            //   foreach ($getArticle as $tab1) {
            //   # code...
            //   $montant1 =  $row["qtite"] * $tab1['PU'];
            // }
        $montant1 =  $row["qtite"] * $row['pu'];
          $total1 = $total1 + $montant1; 
      }
    }else{
      // echo "nada";
    }
if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidangeboite')->result_array();
        }
      // $getPrime = $this->db->query("SELECT * FROM vidangeBoite where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # co
            //   $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
            //    foreach ($getArticle as $tab1) {
            //   # code...
            //   $montant1 =  $row["qtite"] * $tab1['PU'];
            // }
        $montant1 =  $row["qtite"] * $row['pu'];
          $total1 = $total1 + $montant1; 
      }
    }else{
      // echo "nada";
    }
    // echo $total;
  }

  $this->db->close();
}



          if (count($getEngin2)>0) {
               # code...
           foreach ($getEngin2 as $engin) {
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidange')->result_array();
        }
    // $getPrime = $this->db->query("SELECT * FROM vidange where id_operation =".$id_operation."")->result_array();
    $compteur = 0;
    $montant1 = 0;

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
   
            //   $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
            // foreach ($getArticle as $tab1) {
            //   # code...
            //   $montant1 =  $row["qtite"] * $tab1['PU'];
            // }
        $montant1 =  $row["qtite"] * $row['pu'];
          $total1 = $total1 + $montant1;  
      }
    }else{
      // echo "nada";
    }

    $this->db->close();

if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique')->result_array();
        }
      // $getPrime = $this->db->query("SELECT * FROM vidangeHydrolique where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...

            //   $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
            //   foreach ($getArticle as $tab1) {
            //   # code...
            //   $montant1 =  $row["qtite"] * $tab1['PU'];
            // }
        $montant1 =  $row["qtite"] * $row['pu'];
          $total1 = $total1 + $montant1; 
      }
    }else{
      // echo "nada";
    }
if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidangeboite')->result_array();
        }
      // $getPrime = $this->db->query("SELECT * FROM vidangeBoite where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # co
            //   $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
            //    foreach ($getArticle as $tab1) {
            //   # code...
            //   $montant1 =  $row["qtite"] * $tab1['PU'];
            // }
        $montant1 =  $row["qtite"] * $row['pu'];
          $total1 = $total1 + $montant1; 
      }
    }else{
      // echo "nada";
    }
    // echo $total;
  }
}
  
  $this->db->close();

    if (count($getCamion)>0) {
               # code...
           foreach ($getCamion as $engin) {
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidange')->result_array();
        }
    // $getPrime = $this->db->query("SELECT * FROM vidange where id_operation =".$id_operation."")->result_array();
    $compteur2 = 0;
    $montant2 = 0;
  
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
   
            //   $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
            // foreach ($getArticle as $tab1) {
            //   # code...
            //   $montant2 =  $row["qtite"] * $tab1['PU'];
            // }
        $montant2 =  $row["qtite"] * $row['pu'];
          $total2 = $total2 + $montant2;  
      }
    }else{
      // echo "nada";
    }


    $this->db->close();

if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidangehydrolique')->result_array();
        }
      // $getPrime = $this->db->query("SELECT * FROM vidangeHydrolique where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...

            //   $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
            //   foreach ($getArticle as $tab1) {
            //   # code...
            //   $montant2 =  $row["qtite"] * $tab1['PU'];
            // }
        $montant2 =  $row["qtite"] * $row['pu'];
          $total2 = $total2 + $montant2; 
      }
    }else{
      // echo "nada";
    }
if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidangeboite')->result_array();
        }
      // $getPrime = $this->db->query("SELECT * FROM vidangeBoite where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # co
            //   $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
            //    foreach ($getArticle as $tab1) {
            //   # code...
            //   $montant2 =  $row["qtite"] * $tab1['PU'];

            // }
        $montant2 =  $row["qtite"] * $row['pu'];
          $total2 = $total2 + $montant2; 
      }
    }else{
      // echo "nada";
    }
    
  }
}
return $total2 + $total1;

  $this->db->close();
}

public function selectAllGazoilOperationPourRapport(){
    $id_type_vehicule = $_POST["id_type_vehicule"];
              $id_operation = $id_type_vehicule;
                  $compteur = 0;
     $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
     $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();
     $getEngin2 = $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule."")->result_array();

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

      $getService= $this->db->query("SELECT * from voitureservice where id_type_camion=".$id_type_vehicule."")->result_array();
      
       if (count($getEngin)>0) {
        $vehicule = $getEngin;
       }elseif (count($getEngin2)>0) {
         # code...
        $vehicule = $getEngin2;
       }elseif (count($getService)>0) {
         # code...
        $getEngin = $getService;
       }elseif (count($getCamion)>0) {
         # code...
        $vehicule = $getCamion;
       }
          if (count($getEngin)>0) {
               # code...
           foreach ($getEngin as $engin) {
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM gazoil')->result_array();
        }
    // $getPrime = $this->db->query("SELECT * FROM gazoil where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $getDestination = $this->db->query("SELECT * from distance_littrage where id_distance=".$row['id_distance']." limit 1")->row();
        echo "<tr><td>".$compteur."</td>
             
              <td> ".$row['code_camion']."</td>
              <td>".$row['numero']."</td>
              <td>".number_format($row['litrage'],0,',',' ')."</td>
              <td>".number_format($row['prix_unitaire'],0,',',' ')."</td>";
              if (count($getDestination)>0) {
                  # code...
                echo "<td>".$getDestination->distance."</td>";
                echo "<td>".$getDestination->kilometrage."</td>";
              }else{
                echo "<td>Aucune</td>";
                echo "<td>Aucune</td>";
              }
              
               echo "<td>".number_format($row['prix_unitaire']*$row['litrage'],0,',',' ')."</td>
              <td>".$row['date_gazoil']."</td></tr>";
             
        $compteur++;
      }
    }else{
      // echo "nada";
    }
     }
    }

    $this->db->close();

              if (count($getEngin2)>0) {
               # code...
           foreach ($getEngin2 as $engin) {
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM gazoil')->result_array();
        }
    // $getPrime = $this->db->query("SELECT * FROM gazoil where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $getDestination = $this->db->query("SELECT * from distance_littrage where id_distance=".$row['id_distance']." limit 1")->row();
        echo "<tr><td>".$compteur."</td>
             
              <td> ".$row['code_camion']."</td>
              <td>".$row['numero']."</td>
              <td>".number_format($row['litrage'],0,',',' ')."</td>
              <td>".number_format($row['prix_unitaire'],0,',',' ')."</td>";
              if (count($getDestination)>0) {
                  # code...
               echo "<td>".$getDestination->distance."</td>";
                echo "<td>".$getDestination->kilometrage."</td>";
              }else{
                echo "<td>Aucune</td>";
                echo "<td>Aucune</td>";
              }
              
               echo "<td>".number_format($row['prix_unitaire']*$row['litrage'],0,',',' ')."</td>
              <td>".$row['date_gazoil']."</td></tr>";
             
        $compteur++;
      }
    }else{
      // echo "nada";
    }
     }
    }
      $this->db->close();

              if (count($getCamion)>0) {
               # code...
           foreach ($getCamion as $engin) {
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM gazoil')->result_array();
        }
    // $getPrime = $this->db->query("SELECT * FROM gazoil where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $getDestination = $this->db->query("SELECT * from distance_littrage where id_distance=".$row['id_distance']." limit 1")->row();
        echo "<tr><td>".$compteur."</td>
             
              <td> ".$row['code_camion']."</td>
              <td>".$row['numero']."</td>
              <td>".number_format($row['litrage'],0,',',' ')."</td>
              <td>".number_format($row['prix_unitaire'],0,',',' ')."</td>";
              if (count($getDestination)>0) {
                  # code...
               echo "<td>".$getDestination->distance."</td>";
                echo "<td>".$getDestination->kilometrage."</td>";
              }else{
                echo "<td>Aucune</td>";
                echo "<td>Aucune</td>";
              }
              
               echo "<td>".number_format($row['prix_unitaire']*$row['litrage'],0,',',' ')."</td>
              <td>".$row['date_gazoil']."</td></tr>";
             
        $compteur++;
      }
    }else{
      // echo "nada";
    }
     }
    }

    $this->db->close();
  }



  public function selectAllTotalGazoilOperationPourRapport(){
    $id_type_vehicule = $_POST["id_type_vehicule"];
              $id_operation = $id_type_vehicule;
              $compteur = 0;
              $total1 = 0;
              $total = 0;
     $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
     $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();

     $getEngin2 = $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule."")->result_array();
     
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

    $getService= $this->db->query("SELECT * from voitureservice where id_type_camion=".$id_type_vehicule."")->result_array();
      
       if (count($getEngin)>0) {
        $vehicule = $getEngin;
       }elseif (count($getEngin2)>0) {
         # code...
        $vehicule = $getEngin2;
       }elseif (count($getService)>0) {
         # code...
        $getEngin = $getService;
       }elseif (count($getCamion)>0) {
         # code...
        $vehicule = $getCamion;
       }

          if (count($getEngin)>0) {
               # code...
           foreach ($getEngin as $engin) {
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM gazoil')->result_array();
        }
    // $getPrime = $this->db->query("SELECT * FROM gazoil where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $getDestination = $this->db->query("SELECT * from distance_littrage where id_distance=".$row['id_distance']." limit 1")->row();
       
            $montant = $row['litrage']*$row['prix_unitaire'];

            $total = $montant + $total;
   
      }
    }else{
      // echo "nada";
    }
     }

     $this->db->close();
    }


    if (count($getEngin2)>0) {
               # code...
           foreach ($getEngin2 as $engin) {
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM gazoil')->result_array();
        }
    // $getPrime = $this->db->query("SELECT * FROM gazoil where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $getDestination = $this->db->query("SELECT * from distance_littrage where id_distance=".$row['id_distance']." limit 1")->row();
       
            $montant = $row['litrage']*$row['prix_unitaire'];

            $total = $montant + $total;
   
      }
    }else{
      // echo "nada";
    }
     }

     $this->db->close();
    }

              if (count($getCamion)>0) {
               # code...
           foreach ($getCamion as $engin) {
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  code_camion="'.$engin["code"].'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM gazoil')->result_array();
        }
    // $getPrime = $this->db->query("SELECT * FROM gazoil where id_operation =".$id_operation."")->result_array();

     if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $getDestination = $this->db->query("SELECT * from distance_littrage where id_distance=".$row['id_distance']." limit 1")->row();
       
            $montant = $row['litrage']*$row['prix_unitaire'];

            $total1 = $montant + $total;
   
      }
    }else{
      // echo "nada";
    }
     }
    }
    return $total+ $total1;

    $this->db->close();
  }





public function getAllRetenueSalaireChauffeur($id_chauffeur,$date_debut,$date_fin){
        $query = $this->db->query('SELECT retenueSalariale from chauffeur WHERE id_chauffeur='.$id_chauffeur.'')->result_array();

        if (count($query>0)) {
            # code...
            $montant = 0;
            foreach ($query as $row) {
                # code...
                $montant = $montant + $row['retenueSalariale'];
            }

            return $montant;
        }
    }

public function getAllReglementImputationSalaireChauffeur($id_chauffeur,$date_debut,$date_fin){
        $query = $this->db->query('SELECT montant from reglement_imputation WHERE  date_imputation between "'.$date_debut.'" and "'.$date_fin.'" and id_chauffeur='.$id_chauffeur.'')->result_array();

        if (count($query>0)) {
            # code...
            $montant = 0;
            foreach ($query as $row) {
                # code...
                $montant = $montant + $row['montant'];
            }

            return $montant;
        }
    }

public function getAllRegulationImputationSalaireChauffeur($id_chauffeur,$date_debut,$date_fin){
        $query = $this->db->query('SELECT regulation from reglement_imputation WHERE  date_imputation between "'.$date_debut.'" and "'.$date_fin.'" and id_chauffeur='.$id_chauffeur.'')->result_array();

        if (count($query>0)) {
            # code...
            $montant = 0;
            foreach ($query as $row) {
                # code...
                $montant = $montant + $row['regulation'];
            }

            return $montant;
        }
    }
// rappoort cumulé mensuel



    public function rapportCumuleMensuel(){

// nous allons procéder aux vidanges
$prime3=0;
              $id_type_vehicule = $_POST["id_type_vehicule"];
 $id_operation = $id_type_vehicule;
 $totalNbreVidange =0;
              $totalVidanges =0;
              $totalFraisDivers =0;
              $totalFraisRoute =0;
              $totalGazoil =0;
              $totalPieceRenchange =0;
              $totalDepensePneu =0;
              $totalSalaire =0;
              $totalchiffreAff =0;
              $totalDistance =0;
              $totalBenefice=0;
              $prime1=0;
              $prime=0;
              $totalPrime=0;
               $totalChargement = 0;
              $totalLocation = 0;
              $totalBL = 0;
              $totaldiff = 0;
              
              $totalQtiteGasoil=0;
              
              $totalkm_th =0;
     $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule." order by code asc")->result_array();
     $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule." order by code asc")->result_array();

     $getEngin2 = $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule." order by code asc")->result_array();
 
 if (count($getEngin)>0) {
        $vehicule = $getEngin;
       }elseif (count($getEngin2)>0) {
         # code...
        $vehicule = $getEngin2;
       }elseif (count($getCamion)>0) {
         # code...
        $vehicule = $getCamion;
       }


        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

  if (count($vehicule)>0) {
               # code...
           foreach ($vehicule as $engin) {

$nbreVidange=0;
   $compteur = 0;
$montant10 = 0;
$montant9 = 0;
$qtiteGasoil=0;
$km_th = 0;
     $montant1 =0;
       $total1 = 0;
       $montant =0;
       $total = 0;
       $total2=0;
       $total1=0;
       $total_km_litrage=0;
       $km_litrage = 0;
       $diff= 0;
       
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

             

              if (count($getPrime) >0 ) {
                # code...
                foreach ($getPrime as $row) {
             
                      //   $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
                      // foreach ($getArticle as $tab1) {
                      //   # code...
                      //   $montant1 =  $row["qtite"] * $tab1['PU'];
                      // }
                  $montant1 =  $row["qtite"] * $row['pu'];
                    $total1 = $total1 + $montant1;  
                    
                }
                
              }else{
                // echo "nada";
              }


          $this->db->close();

  $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
     
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...

            //   $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
            //   foreach ($getArticle as $tab1) {
            //   # code...
            //   $montant1 =  $row["qtite"] * $tab1['PU'];
            // }
        $montant1 =  $row["qtite"] * $row['pu'];
          $total1 = $total1 + $montant1; 
          // $nbreVidange = count($getPrime)+$nbreVidange;
      }
      // $nbreVidange = count($getPrime) +$nbreVidange;
    }else{
      // echo "nada";
    }

  $this->db->close();

  $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # co
            //   $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
            //    foreach ($getArticle as $tab1) {
            //   # code...
            //   $montant1 =  $row["qtite"] * $tab1['PU'];
            // }
        $montant1 =  $row["qtite"] * $row['pu'];
          $total1 = $total1 + $montant1;
          // $nbreVidange = count($getPrime)+$nbreVidange;
      }
      // $nbreVidange = count($getPrime) +$nbreVidange;
    }else{
      // echo "nada";
    }
    // echo $total;
//   }
// }

$this->db->close();

$totalVidange = $total1;
// return $total2 + $total1;

// frais divers

      $id_type_vehicule = $_POST["id_type_vehicule"];
      $id_operation = $id_type_vehicule;
$compteur = 0;
     $montant1 =0;
       $total1 = 0;

       $montant2 =0;
       $total2 = 0;

       $montant =0;
       $total = 0;
        
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

          // if (count($vehicule$vehicule)>0) {
          //      # code...
          //  foreach ($vehicule as $engin) {
            
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
       
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {

       // $montant = $row['montant'];
       
       $total = $total + $row['montant'];
      }
    }else{
      // echo "nada";
    }
  // }
  // }

    $this->db->close();

$fraisDIvers = $total1 +$total+$total2;


// les frais de routes doivent suivre ici



$compteur = 0;
     $montant1 =0;
       $total1 = 0;
       $montant =0;
       $total = 0;
   

          // if (count($vehicule)>0) {
          //      # code...
          //  foreach ($vehicule as $engin) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
       
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {

       // $montant = $row['montant'];
       
       $total = $total + $row['montant'];
      }
    }else{
      // echo "nada";
    }
  // }
  // }

    $this->db->close();

$fraisRoute = $total1 +$total;

// depense gazoil


    $id_type_vehicule = $_POST["id_type_vehicule"];
              $id_operation = $id_type_vehicule;
              $compteur = 0;
              $total1 = 0;
              $total = 0;
 
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

          // if (count($vehicule)>0) {
          //      # code...
          //  foreach ($vehicule as $engin) {
        
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $getDestination = $this->db->query("SELECT * from distance_littrage where id_distance=".$row['id_distance']." limit 1")->row();
       
            $montant = $row['litrage']*$row['prix_unitaire'];

            $km_litrage = $getDestination->kilometrage+$km_litrage;
            $total = $montant + $total;
            $qtiteGasoil  = $qtiteGasoil+$row['litrage'];
   
      }
    }else{
      // echo "nada";
    }
    //  }
// N L/0.45 || A 0.55
   if (count($getEngin)>0) {
        if ($engin['type'] == 'Ancien') {
          # code...
          $km_th = $qtiteGasoil /0.55;
        }else{
          $km_th = $qtiteGasoil /0.381;
        }
       }
    // }

$this->db->close();

    $gazoil = $total+ $total1;

// piece de rechange

$compteur = 0;
     $montant1 =0;
       $total1 = 0;
       $montant =0;
       $total = 0;

       $montant2 =0;
       $total2 = 0;

          // if (count($vehicule)>0) {
          //      # code...
          //  foreach ($vehicule as $engin) {
               # code...
       
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
       
     if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $getPrixUnitaire = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->result_array();

        foreach ($getPrixUnitaire as $tab) {
          # code...
          $montant = $row["prix_unitaire"]* $row["qtite"];
        }

        $total = $total+$montant;
        
        $compteur++;
      }
    }else{
      // echo "nada";
    }
//   }
// }

$this->db->close();

$pieceRechange = $total1+$total;

// Depense pneu


           $id_type_vehicule = $_POST["id_type_vehicule"];
$id_operation = $id_type_vehicule;
$compteur = 0;
$total = 0;
$montant = 0;
   
     # code...
           // foreach ($vehicule as $engin) {

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        
            $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
        
         
        foreach ($getPrime as $row) {
            # code...

            
                 $montant = $row['qtite']*$row['prix_unitaire'];

                 $total = $total + $montant;                 
        }
    
// }

        $this->db->close();

$depensePneu = $total;
// total vidange


// salaire employe et chauffeur

  
           // foreach ($vehicule as $engin) {

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        
            $getPrime = $this->db->query('SELECT * FROM chauffeur where id_chauffeur ='.$engin["id_chauffeur"].'')->result_array();
        
         
        foreach ($getPrime as $row) {
            # code...

            
                 $montant = $row['salaire_ass']+$row['salaire'];

                 // $total = $total + $montant;                 
        }
    
// }
$gps = 21465;

// la ligne qui suis est le net à payer qu'on a copié sur la partie paie employé

$np = $montant-$this->getAllRetenueSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)-$this->getAllReglementImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)+$this->getAllRegulationImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin);

$getValidePourSalaire = $this->db->query("SELECT * from paiechauffeur where id_chauffeur=".$row['id_chauffeur']."")->row();
if (count($getValidePourSalaire)>0) {
  # code...
  if ($getValidePourSalaire->salaire == 1) {
    # code...
    $salaireChauffueurAss = $gps;
  }elseif ($getValidePourSalaire->salaire_gps == 1) {
    # code...
    $salaireChauffueurAss =0;
  }elseif ($getValidePourSalaire->gps == 1) {
    # code...
    $salaireChauffueurAss =$np;
  }else{
    $salaireChauffueurAss = $np + $gps;
  }
}else{
  $salaireChauffueurAss = $np + $gps;
}

// bon de livraison


     $montant1=0;
     $montant=0;
     $compteur = 0;
    $total1 = 0;
    $montant1=0;

    $montant2=0;


           // if (count($vehicule)>0) {
           //     # code...
           // foreach ($vehicule as $engin) {
               # code...


       
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
       
$nbreVoyage=0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {

        $total1 = $row['quantite']*$row['prix_unitaire'];
        $montant2 = $total1+ $montant2;
        $nbreVoyage = $nbreVoyage+1; 
      }
      $nbreVidange = $nbreVoyage;

    }else{
      // echo "nada";
    }

    $bon_livraison = $montant2;

    // if ($nbreVoyage == 0) {
    //   # code...
    //   $salaireChauffueurAss = 0;
    // }
    // $montant1 = $montant1+$montant2;
        // return $montant;
        //    }
           
        // }
$this->db->close();
// chargement retour
    //  if (count($vehicule)>0) {
    
    // foreach ($vehicule as $tracteur) {
               # code...

            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
      
$compteur = 0;
$total = 0;
$montant=0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
         $montant  = $montant + $row['montant'];
        // $total = $row['quantite']*$row['prix_unitaire'];
        // $montant = $total+ $montant;
      }
    }else{
      // echo "nada";
    }
$chargement_retour = $montant;
        // return $montant;

    // }

        
    // }
    



              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
       
            $getPrime22 = $this->db->query('SELECT montant FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
       
    if (count($getPrime22) >0 ) {
      # code...
      $prime3 = 0;
      foreach ($getPrime22 as $row3) {

        $prime3 = $row3['montant'] +$prime3;
        // $prime= $prime1+ $montant1;
      }
    }else{
      // echo "nada";
      $prime3 = 0;
    }

        // return $montant;
           
           
        
$this->db->close();

// Location engin

           // if (count($vehicule)>0) {
           //     # code...
           // foreach ($vehicule as $engin) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

        $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin['code'].'"')->result_array();
        
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
 
          if (count($getPrime) >0 ) {
            # code...
            foreach ($getPrime as $row) {
              # code...
              $getOperation = $this->db->query("SELECT * from operation where id_operation = ".$row['id_operation']." limit 1")->row();
               $montant10 = $row['montant']*$row['duree'];                  
               $montant9 = $montant9 + $montant10;
            }
            
          }else{
            // echo "nada";
          }

  $location_engin = $montant9;
      // }
      //      // return $montant9;
      //   }

$chiffreAff = $montant9 + $montant+$montant2;
        // salaire employe et chauffeur

  $this->db->close();
           // foreach ($vehicule as $engin) {

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        
            $getPrime = $this->db->query('SELECT * FROM distance_parcourue where date_distance between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
        
         
        foreach ($getPrime as $row) {
            # code...

            
                 $montant = $row['kilometrage_fin']-$row['kilometrage_debut'];

                 $total = $montant;                 
        }
    
       // }
       $distance_parcourue = $total;

            if ($nbreVidange >0 || $fraisDIvers >0 || $fraisRoute >0 || $gazoil >0 || $pieceRechange >0 || $depensePneu >0 || $totalVidange>0 || $salaireChauffueurAss >0 || $chiffreAff >0 || $distance_parcourue >0) {
              # code...

              // $benefice = $bon_livraison+$chargement_retour+$location_engin-$chiffreAff-$prime- $salaireChauffueurAss-$totalVidange-$depensePneu-$pieceRechange-$gazoil-$fraisRoute-$fraisDIvers;

              $benefice = $bon_livraison+$chargement_retour+$location_engin-$prime3- $salaireChauffueurAss-$totalVidange-$depensePneu-$pieceRechange-$gazoil-$fraisRoute-$fraisDIvers;
              $totalNbreVidange =$nbreVidange +  $totalNbreVidange ;
              $totalVidanges = $totalVidanges+$totalVidange;
              $totalFraisDivers = $totalFraisDivers+$fraisDIvers;
              $totalFraisRoute = $totalFraisRoute+$fraisRoute;
              $totalGazoil = $totalGazoil+$gazoil;
              $totalPieceRenchange = $totalPieceRenchange+$pieceRechange;
              $totalDepensePneu = $totalDepensePneu+$depensePneu;
              $totalSalaire = $totalSalaire+ $salaireChauffueurAss;
              $totalchiffreAff = $totalchiffreAff+ $chiffreAff;
              $totalDistance = $totalDistance+ $distance_parcourue;
              $totalBenefice = $totalBenefice + $benefice;
              $totalPrime = $prime3 + $totalPrime;
              $totalChargement = $totalChargement + $chargement_retour;
              $totalLocation = $totalLocation + $location_engin;
              $totalBL = $totalBL + $bon_livraison;
              $totalQtiteGasoil = $totalQtiteGasoil + $qtiteGasoil;
              $totalkm_th = $totalkm_th + $km_th;
              $diff =$distance_parcourue -$km_th;
              $totaldiff = $totaldiff + $diff;
              $total_km_litrage = $total_km_litrage + $km_litrage;

              echo "<tr style='text-align: center;'>
              <td style='size: 8px; border: 1px solid black;'>".$engin['code']."</td>
              <td style='size: 8px; border: 1px solid black;'>".$nbreVidange."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($fraisDIvers,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($fraisRoute,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".$qtiteGasoil."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($gazoil,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($pieceRechange,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($depensePneu,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($totalVidange,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($salaireChauffueurAss,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($prime3,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($bon_livraison,0,'.',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($chargement_retour,0,',',' ')."</td>
              
              
   
              <td style='size: 8px; border: 1px solid black;'>".number_format($distance_parcourue,2,'.',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($km_th,2,'.',' ')."</td>";
              if ($diff<0) {
                # code
                echo"<td style='size: 8px; border: 1px solid black; color:red;'>".number_format($diff,2,'.',' ')."</td>"; 
              }else{
                echo"<td style='size: 8px; border: 1px solid black;'>".number_format($diff,2,'.',' ')."</td>";
              }
              
              if ($benefice<0) {
                # code...
                echo "<td style ='color: red;  border: 1px solid black;'>".number_format($benefice,0,',',' ')."</td>

                </tr>";
              }else{
                echo "<td style='size: 8px; border: 1px solid black;'>".number_format($benefice,0,',',' ')."</td>

                </tr>";
              }
              
             }

    }

   

  }
   echo "<tr style='text-align: center;'>
              <td style ='color: red;  border: 2px solid black;'> TOTAUX</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".$totalNbreVidange."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalFraisDivers,0,',',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalFraisRoute,0,',',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".$totalQtiteGasoil."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalGazoil,0,',',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalPieceRenchange,0,',',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalDepensePneu,0,',',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalVidanges,0,',',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalSalaire,0,',',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalPrime,0,',',' ')."</td>
               <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalBL,0,'.',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalChargement,0,',',' ')."</td>
             
            
         
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalDistance,2,'.',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalkm_th,2,'.',' ')."</td>";
              if ($totaldiff < 0) {
                # code...
                echo"<td style ='color: red; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totaldiff,2,'.',' ')."</td>";
              }else{
               echo " <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totaldiff,2,'.',' ')."</td>";
              }
              
              if ($totalBenefice<0) {
                # code...
                echo "<td style ='color: red;  border: 2px solid black;'>".number_format($totalBenefice,3,'.',' ')."</td>

                </tr>";
              }else{
                echo "<td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalBenefice,3,'.',' ')."</td>

                </tr>";
              }
              $this->db->close();
}

// le code qui suis est celui du rapport des véhicules de service


    public function rapportCumuleMensuelService(){

// nous allons procéder aux vidanges
$prime3=0;
              $id_type_vehicule = $_POST["id_type_vehicule"];
 $id_operation = $id_type_vehicule;
 $totalNbreVidange =0;
              $totalVidanges =0;
              $totalFraisDivers =0;
              $totalFraisRoute =0;
              $totalGazoil =0;
              $totalPieceRenchange =0;
              $totalDepensePneu =0;
              $totalSalaire =0;
              $totalchiffreAff =0;
              $totalDistance =0;
              $totalBenefice=0;
              $prime1=0;
              $prime=0;
              $totalPrime=0;
               $totalChargement = 0;
              $totalLocation = 0;
              $totalBL = 0;
              $totaldiff = 0;
              
              $totalQtiteGasoil=0;
              
              $totalkm_th =0;
     $getEngin = $this->db->query("SELECT * from voitureservice where id_type_camion=".$id_type_vehicule." order by code asc")->result_array();
     $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule." order by code asc")->result_array();

     $getEngin2 = $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule." order by code asc")->result_array();
 
 if (count($getEngin)>0) {
        $vehicule = $getEngin;
       }elseif (count($getEngin2)>0) {
         # code...
        $vehicule = $getEngin2;
       }elseif (count($getCamion)>0) {
         # code...
        $vehicule = $getCamion;
       }else{
        $vehicule = $getEngin;
       }


        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

  if (count($vehicule)>0) {
               # code...
           foreach ($vehicule as $engin) {

$nbreVidange=0;
   $compteur = 0;
$montant10 = 0;
$montant9 = 0;
$qtiteGasoil=0;
$km_th = 0;
     $montant1 =0;
       $total1 = 0;
       $montant =0;
       $total = 0;
       $total2=0;
       $total1=0;
       $total_km_litrage=0;
       $km_litrage = 0;
       $diff= 0;
       
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

             

              if (count($getPrime) >0 ) {
                # code...
                foreach ($getPrime as $row) {
             
                      //   $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
                      // foreach ($getArticle as $tab1) {
                      //   # code...
                      //   $montant1 =  $row["qtite"] * $tab1['PU'];
                      // }
                  $montant1 =  $row["qtite"] * $row['pu'];
                    $total1 = $total1 + $montant1;  
                    
                }
                
              }else{
                // echo "nada";
              }


          $this->db->close();

  $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
     
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...

            //   $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
            //   foreach ($getArticle as $tab1) {
            //   # code...
            //   $montant1 =  $row["qtite"] * $tab1['PU'];
            // }
        $montant1 =  $row["qtite"] * $row['pu'];
          $total1 = $total1 + $montant1; 
          // $nbreVidange = count($getPrime)+$nbreVidange;
      }
      // $nbreVidange = count($getPrime) +$nbreVidange;
    }else{
      // echo "nada";
    }

  $this->db->close();

  $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # co
            //   $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
            //    foreach ($getArticle as $tab1) {
            //   # code...
            //   $montant1 =  $row["qtite"] * $tab1['PU'];
            // }
        $montant1 =  $row["qtite"] * $row['pu'];
          $total1 = $total1 + $montant1;
          // $nbreVidange = count($getPrime)+$nbreVidange;
      }
      // $nbreVidange = count($getPrime) +$nbreVidange;
    }else{
      // echo "nada";
    }
    // echo $total;
//   }
// }

$this->db->close();

$totalVidange = $total1;
// return $total2 + $total1;

// frais divers

      $id_type_vehicule = $_POST["id_type_vehicule"];
      $id_operation = $id_type_vehicule;
$compteur = 0;
     $montant1 =0;
       $total1 = 0;

       $montant2 =0;
       $total2 = 0;

       $montant =0;
       $total = 0;
        
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

          // if (count($vehicule$vehicule)>0) {
          //      # code...
          //  foreach ($vehicule as $engin) {
            
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
       
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {

       // $montant = $row['montant'];
       
       $total = $total + $row['montant'];
      }
    }else{
      // echo "nada";
    }
  // }
  // }

    $this->db->close();

$fraisDIvers = $total1 +$total+$total2;


// les frais de routes doivent suivre ici



$compteur = 0;
     $montant1 =0;
       $total1 = 0;
       $montant =0;
       $total = 0;
   

          // if (count($vehicule)>0) {
          //      # code...
          //  foreach ($vehicule as $engin) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
       
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {

       // $montant = $row['montant'];
       
       $total = $total + $row['montant'];
      }
    }else{
      // echo "nada";
    }
  // }
  // }

    $this->db->close();

$fraisRoute = $total1 +$total;

// depense gazoil


    $id_type_vehicule = $_POST["id_type_vehicule"];
              $id_operation = $id_type_vehicule;
              $compteur = 0;
              $total1 = 0;
              $total = 0;
 
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

          // if (count($vehicule)>0) {
          //      # code...
          //  foreach ($vehicule as $engin) {
        
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $getDestination = $this->db->query("SELECT * from distance_littrage where id_distance=".$row['id_distance']." limit 1")->row();
       
            $montant = $row['litrage']*$row['prix_unitaire'];

            $km_litrage = $getDestination->kilometrage+$km_litrage;
            $total = $montant + $total;
            $qtiteGasoil  = $qtiteGasoil+$row['litrage'];
   
      }
    }else{
      // echo "nada";
    }
    //  }
// N L/0.45 || A 0.55
   // if (count($getEngin)>0) {
   //      if ($engin['type'] == 'Ancien') {
   //        # code...
   //        $km_th = $qtiteGasoil /0.55;
   //      }else{
   //        $km_th = $qtiteGasoil /0.381;
   //      }
   //     }
    // }

$this->db->close();

    $gazoil = $total+ $total1;

// piece de rechange

$compteur = 0;
     $montant1 =0;
       $total1 = 0;
       $montant =0;
       $total = 0;

       $montant2 =0;
       $total2 = 0;

          // if (count($vehicule)>0) {
          //      # code...
          //  foreach ($vehicule as $engin) {
               # code...
       
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
       
     if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $getPrixUnitaire = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->result_array();

        foreach ($getPrixUnitaire as $tab) {
          # code...
          $montant = $row["prix_unitaire"]* $row["qtite"];
        }

        $total = $total+$montant;
        
        $compteur++;
      }
    }else{
      // echo "nada";
    }
//   }
// }

$this->db->close();

$pieceRechange = $total1+$total;

// Depense pneu


           $id_type_vehicule = $_POST["id_type_vehicule"];
$id_operation = $id_type_vehicule;
$compteur = 0;
$total = 0;
$montant = 0;
   
     # code...
           // foreach ($vehicule as $engin) {

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        
            $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
        
         
        foreach ($getPrime as $row) {
            # code...

            
                 $montant = $row['qtite']*$row['prix_unitaire'];

                 $total = $total + $montant;                 
        }
    
// }

        $this->db->close();

$depensePneu = $total;
// total vidange


// salaire employe et chauffeur

  
           // foreach ($vehicule as $engin) {

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        
            $getPrime = $this->db->query('SELECT * FROM chauffeur where id_chauffeur ='.$engin["id_chauffeur"].'')->result_array();
        
         
        foreach ($getPrime as $row) {
            # code...

            
                 $montant = $row['salaire_ass']+$row['salaire'];

                 // $total = $total + $montant;                 
        }
    
// }
$gps = 21465;

// la ligne qui suis est le net à payer qu'on a copié sur la partie paie employé

$np = $montant-$this->getAllRetenueSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)-$this->getAllReglementImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)+$this->getAllRegulationImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin);
$salaireChauffueurAss = $np + $gps;
// bon de livraison


     $montant1=0;
     $montant=0;
     $compteur = 0;
    $total1 = 0;
    $montant1=0;

    $montant2=0;


           // if (count($vehicule)>0) {
           //     # code...
           // foreach ($vehicule as $engin) {
               # code...


       
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
       
$nbreVoyage=0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {

        $total1 = $row['quantite']*$row['prix_unitaire'];
        $montant2 = $total1+ $montant2;
        $nbreVoyage = $nbreVoyage+1; 
      }
      $nbreVidange = $nbreVoyage;

    }else{
      // echo "nada";
    }

    $bon_livraison = $montant2;

    // if ($nbreVoyage == 0) {
    //   # code...
    //   $salaireChauffueurAss = 0;
    // }
    // $montant1 = $montant1+$montant2;
        // return $montant;
        //    }
           
        // }
$this->db->close();
// chargement retour
    //  if (count($vehicule)>0) {
    
    // foreach ($vehicule as $tracteur) {
               # code...

            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
      
$compteur = 0;
$total = 0;
$montant=0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
         $montant  = $montant + $row['montant'];
        // $total = $row['quantite']*$row['prix_unitaire'];
        // $montant = $total+ $montant;
      }
    }else{
      // echo "nada";
    }
$chargement_retour = $montant;
        // return $montant;

    // }

        
    // }
    



              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
       
            $getPrime22 = $this->db->query('SELECT montant FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
       
    if (count($getPrime22) >0 ) {
      # code...
      $prime3 = 0;
      foreach ($getPrime22 as $row3) {

        $prime3 = $row3['montant'] +$prime3;
        // $prime= $prime1+ $montant1;
      }
    }else{
      // echo "nada";
      $prime3 = 0;
    }

        // return $montant;
           
           
        
$this->db->close();

// Location engin

           // if (count($vehicule)>0) {
           //     # code...
           // foreach ($vehicule as $engin) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

        $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin['code'].'"')->result_array();
        
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
 
          if (count($getPrime) >0 ) {
            # code...
            foreach ($getPrime as $row) {
              # code...
              $getOperation = $this->db->query("SELECT * from operation where id_operation = ".$row['id_operation']." limit 1")->row();
               $montant10 = $row['montant']*$row['duree'];                  
               $montant9 = $montant9 + $montant10;
            }
            
          }else{
            // echo "nada";
          }

  $location_engin = $montant9;
      // }
      //      // return $montant9;
      //   }

$chiffreAff = $montant9 + $montant+$montant2;
        // salaire employe et chauffeur

  $this->db->close();
           // foreach ($vehicule as $engin) {

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        
            $getPrime = $this->db->query('SELECT * FROM distance_parcourue where date_distance between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
        
         
        foreach ($getPrime as $row) {
            # code...

            
                 $montant = $row['kilometrage_fin']-$row['kilometrage_debut'];

                 $total = $montant;                 
        }
    
       // }
       $distance_parcourue = $total;

            if ($nbreVidange >0 || $fraisDIvers >0 || $fraisRoute >0 || $gazoil >0 || $pieceRechange >0 || $depensePneu >0 || $totalVidange>0 || $salaireChauffueurAss >0 || $chiffreAff >0 || $distance_parcourue >0) {
              # code...

              // $benefice = $bon_livraison+$chargement_retour+$location_engin-$chiffreAff-$prime- $salaireChauffueurAss-$totalVidange-$depensePneu-$pieceRechange-$gazoil-$fraisRoute-$fraisDIvers;

              $benefice = -$depensePneu-$pieceRechange-$gazoil-$totalVidange-$fraisRoute-$fraisDIvers;
              $totalNbreVidange =$nbreVidange +  $totalNbreVidange ;
              $totalVidanges = $totalVidanges+$totalVidange;
              $totalFraisDivers = $totalFraisDivers+$fraisDIvers;
              $totalFraisRoute = $totalFraisRoute+$fraisRoute;
              $totalGazoil = $totalGazoil+$gazoil;
              $totalPieceRenchange = $totalPieceRenchange+$pieceRechange;
              $totalDepensePneu = $totalDepensePneu+$depensePneu;
              $totalSalaire = $totalSalaire+ $salaireChauffueurAss;
              $totalchiffreAff = $totalchiffreAff+ $chiffreAff;
              $totalDistance = $totalDistance+ $distance_parcourue;
              $totalBenefice = $totalBenefice + $benefice;
              $totalPrime = $prime3 + $totalPrime;
              $totalChargement = $totalChargement + $chargement_retour;
              $totalLocation = $totalLocation + $location_engin;
              $totalBL = $totalBL + $bon_livraison;
              $totalQtiteGasoil = $totalQtiteGasoil + $qtiteGasoil;
              $totalkm_th = $totalkm_th + $km_th;
              $diff =$distance_parcourue -$km_th;
              $totaldiff = $totaldiff + $diff;
              $total_km_litrage = $total_km_litrage + $km_litrage;

              echo "<tr style='text-align: center;'>
              <td style='size: 8px; border: 1px solid black;'>".$engin['code']."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($fraisDIvers,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($fraisRoute,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".$qtiteGasoil."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($gazoil,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($pieceRechange,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($depensePneu,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($totalVidange,0,',',' ')."</td>

              ";
              
              if ($benefice<0) {
                # code...
                echo "<td style ='color: red;  border: 1px solid black;'>".number_format($benefice,0,',',' ')."</td>

                </tr>";
              }else{
                echo "<td style='size: 8px; border: 1px solid black;'>".number_format($benefice,0,',',' ')."</td>

                </tr>";
              }
              
             }

    }

   

  }
   echo "<tr style='text-align: center;'>
              <td style ='color: red;  border: 2px solid black;'> TOTAUX</td>
               <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalFraisDivers,0,',',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalFraisRoute,0,',',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".$totalQtiteGasoil."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalGazoil,0,',',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalPieceRenchange,0,',',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalDepensePneu,0,',',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalVidanges,0,',',' ')."</td>

             ";
              
              if ($totalBenefice<0) {
                # code...
                echo "<td style ='color: red;  border: 2px solid black;'>".number_format($totalBenefice,3,'.',' ')."</td>

                </tr>";
              }else{
                echo "<td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalBenefice,3,'.',' ')."</td>

                </tr>";
              }
              $this->db->close();
}


// ceci est le rapport cumulé des engins
    public function rapportCumuleMensuelEngin(){

// nous allons procéder aux vidanges
$prime3=0;
              $id_type_vehicule = $_POST["id_type_vehicule"];
 $id_operation = $id_type_vehicule;
 $totalNbreVidange =0;
              $totalVidanges =0;
              $totalFraisDivers =0;
              $totalFraisRoute =0;
              $totalGazoil =0;
              $totalPieceRenchange =0;
              $totalDepensePneu =0;
              $totalSalaire =0;
              $totalchiffreAff =0;
              $totalDistance =0;
              $totalBenefice=0;
              $prime1=0;
              $prime=0;
              $totalPrime=0;
               $totalChargement = 0;
              $totalLocation = 0;
              $totalBL = 0;
              $totaldiff = 0;
              
              $totalQtiteGasoil=0;
              
              $totalkm_th =0;
     $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule." order by code asc")->result_array();
     $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule." order by code asc")->result_array();

     $getEngin2 = $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule." order by code asc")->result_array();
 
 if (count($getEngin)>0) {
        $vehicule = $getEngin;
       }elseif (count($getEngin2)>0) {
         # code...
        $vehicule = $getEngin2;
       }elseif (count($getCamion)>0) {
         # code...
        $vehicule = $getCamion;
       }


        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

  if (count($vehicule)>0) {
               # code...
           foreach ($vehicule as $engin) {

$nbreVidange=0;
   $compteur = 0;
$montant10 = 0;
$montant9 = 0;
$qtiteGasoil=0;
$km_th = 0;
     $montant1 =0;
       $total1 = 0;
       $montant =0;
       $total = 0;
       $total2=0;
       $total1=0;
       $total_km_litrage=0;
       $km_litrage = 0;
       $diff= 0;
       
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

             

              if (count($getPrime) >0 ) {
                # code...
                foreach ($getPrime as $row) {
             
                      //   $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
                      // foreach ($getArticle as $tab1) {
                      //   # code...
                      //   $montant1 =  $row["qtite"] * $tab1['PU'];
                      // }
                  $montant1 =  $row["qtite"] * $row['pu'];
                    $total1 = $total1 + $montant1;  
                    
                }
                
              }else{
                // echo "nada";
              }


          $this->db->close();

  $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
     
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...

            //   $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
            //   foreach ($getArticle as $tab1) {
            //   # code...
            //   $montant1 =  $row["qtite"] * $tab1['PU'];
            // }
        $montant1 =  $row["qtite"] * $row['pu'];
          $total1 = $total1 + $montant1; 
          // $nbreVidange = count($getPrime)+$nbreVidange;
      }
      // $nbreVidange = count($getPrime) +$nbreVidange;
    }else{
      // echo "nada";
    }

  $this->db->close();

  $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # co
            //   $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
            //    foreach ($getArticle as $tab1) {
            //   # code...
            //   $montant1 =  $row["qtite"] * $tab1['PU'];
            // }
        $montant1 =  $row["qtite"] * $row['pu'];
          $total1 = $total1 + $montant1;
          // $nbreVidange = count($getPrime)+$nbreVidange;
      }
      // $nbreVidange = count($getPrime) +$nbreVidange;
    }else{
      // echo "nada";
    }
    // echo $total;
//   }
// }

$this->db->close();

$totalVidange = $total1;
// return $total2 + $total1;

// frais divers

      $id_type_vehicule = $_POST["id_type_vehicule"];
      $id_operation = $id_type_vehicule;
$compteur = 0;
     $montant1 =0;
       $total1 = 0;

       $montant2 =0;
       $total2 = 0;

       $montant =0;
       $total = 0;
        
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

          // if (count($vehicule$vehicule)>0) {
          //      # code...
          //  foreach ($vehicule as $engin) {
            
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
       
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {

       // $montant = $row['montant'];
       
       $total = $total + $row['montant'];
      }
    }else{
      // echo "nada";
    }
  // }
  // }

    $this->db->close();

$fraisDIvers = $total1 +$total+$total2;


// les frais de routes doivent suivre ici



$compteur = 0;
     $montant1 =0;
       $total1 = 0;
       $montant =0;
       $total = 0;
   

          // if (count($vehicule)>0) {
          //      # code...
          //  foreach ($vehicule as $engin) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
       
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {

       // $montant = $row['montant'];
       
       $total = $total + $row['montant'];
      }
    }else{
      // echo "nada";
    }
  // }
  // }

    $this->db->close();

$fraisRoute = $total1 +$total;

// depense gazoil


    $id_type_vehicule = $_POST["id_type_vehicule"];
              $id_operation = $id_type_vehicule;
              $compteur = 0;
              $total1 = 0;
              $total = 0;
 
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

          // if (count($vehicule)>0) {
          //      # code...
          //  foreach ($vehicule as $engin) {
        
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $getDestination = $this->db->query("SELECT * from distance_littrage where id_distance=".$row['id_distance']." limit 1")->row();
       
            $montant = $row['litrage']*$row['prix_unitaire'];

            $km_litrage = $getDestination->kilometrage+$km_litrage;
            $total = $montant + $total;
            $qtiteGasoil  = $qtiteGasoil+$row['litrage'];
   
      }
    }else{
      // echo "nada";
    }
    //  }
// N L/0.45 || A 0.55
   if (count($getEngin)>0) {
        if ($engin['type'] == 'Ancien') {
          # code...
          $km_th = $qtiteGasoil /0.55;
        }else{
          $km_th = $qtiteGasoil /0.381;
        }
       }
    // }

$this->db->close();

    $gazoil = $total+ $total1;

// piece de rechange

$compteur = 0;
     $montant1 =0;
       $total1 = 0;
       $montant =0;
       $total = 0;

       $montant2 =0;
       $total2 = 0;

          // if (count($vehicule)>0) {
          //      # code...
          //  foreach ($vehicule as $engin) {
               # code...
       
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
       
     if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $getPrixUnitaire = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->result_array();

        foreach ($getPrixUnitaire as $tab) {
          # code...
          $montant = $row["prix_unitaire"]* $row["qtite"];
        }

        $total = $total+$montant;
        
        $compteur++;
      }
    }else{
      // echo "nada";
    }
//   }
// }

$this->db->close();

$pieceRechange = $total1+$total;

// Depense pneu


           $id_type_vehicule = $_POST["id_type_vehicule"];
$id_operation = $id_type_vehicule;
$compteur = 0;
$total = 0;
$montant = 0;
   
     # code...
           // foreach ($vehicule as $engin) {

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        
            $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
        
         
        foreach ($getPrime as $row) {
            # code...

            
                 $montant = $row['qtite']*$row['prix_unitaire'];

                 $total = $total + $montant;                 
        }
    
// }

        $this->db->close();

$depensePneu = $total;
// total vidange


// salaire employe et chauffeur

  
           // foreach ($vehicule as $engin) {

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        
            $getPrime = $this->db->query('SELECT * FROM chauffeur where id_chauffeur ='.$engin["id_chauffeur"].'')->result_array();
        
         
        foreach ($getPrime as $row) {
            # code...

            
                 $montant = $row['salaire_ass']+$row['salaire'];

                 // $total = $total + $montant;                 
        }
    
// }
$gps = 21465;

// la ligne qui suis est le net à payer qu'on a copié sur la partie paie employé

$np = $montant-$this->getAllRetenueSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)-$this->getAllReglementImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)+$this->getAllRegulationImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin);
$salaireChauffueurAss = $np + $gps;
// bon de livraison


     $montant1=0;
     $montant=0;
     $compteur = 0;
    $total1 = 0;
    $montant1=0;

    $montant2=0;


           // if (count($vehicule)>0) {
           //     # code...
           // foreach ($vehicule as $engin) {
               # code...


       
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
       
$nbreVoyage=0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {

        $total1 = $row['quantite']*$row['prix_unitaire'];
        $montant2 = $total1+ $montant2;
        $nbreVoyage = $nbreVoyage+1; 
      }
      $nbreVidange = $nbreVoyage;

    }else{
      // echo "nada";
    }

    $bon_livraison = $montant2;

    // if ($nbreVoyage == 0) {
    //   # code...
    //   $salaireChauffueurAss = 0;
    // }
    // $montant1 = $montant1+$montant2;
        // return $montant;
        //    }
           
        // }
$this->db->close();
// chargement retour
    //  if (count($vehicule)>0) {
    
    // foreach ($vehicule as $tracteur) {
               # code...

            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
      
$compteur = 0;
$total = 0;
$montant=0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
         $montant  = $montant + $row['montant'];
        // $total = $row['quantite']*$row['prix_unitaire'];
        // $montant = $total+ $montant;
      }
    }else{
      // echo "nada";
    }
$chargement_retour = $montant;
        // return $montant;

    // }

        
    // }
    



              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
       
            $getPrime22 = $this->db->query('SELECT montant FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
       
    if (count($getPrime22) >0 ) {
      # code...
      $prime3 = 0;
      foreach ($getPrime22 as $row3) {

        $prime3 = $row3['montant'] +$prime3;
        // $prime= $prime1+ $montant1;
      }
    }else{
      // echo "nada";
      $prime3 = 0;
    }

        // return $montant;
           
           
        
$this->db->close();

// Location engin

           // if (count($vehicule)>0) {
           //     # code...
           // foreach ($vehicule as $engin) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

        $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin['code'].'"')->result_array();
        
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
 
          if (count($getPrime) >0 ) {
            # code...
            foreach ($getPrime as $row) {
              # code...
              $getOperation = $this->db->query("SELECT * from operation where id_operation = ".$row['id_operation']." limit 1")->row();
               $montant10 = $row['montant']*$row['duree'];                  
               $montant9 = $montant9 + $montant10;
            }
            
          }else{
            // echo "nada";
          }

  $location_engin = $montant9;
      // }
      //      // return $montant9;
      //   }

$chiffreAff = $montant9 + $montant+$montant2;
        // salaire employe et chauffeur

  $this->db->close();
           // foreach ($vehicule as $engin) {

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        
            $getPrime = $this->db->query('SELECT * FROM distance_parcourue where date_distance between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
        
         
        foreach ($getPrime as $row) {
            # code...

            
                 $montant = $row['kilometrage_fin']-$row['kilometrage_debut'];

                 $total = $montant;                 
        }
    
       // }
       $distance_parcourue = $total;

            if ($nbreVidange >0 || $fraisDIvers >0 || $fraisRoute >0 || $gazoil >0 || $pieceRechange >0 || $depensePneu >0 || $totalVidange>0 || $salaireChauffueurAss >0 || $chiffreAff >0 || $distance_parcourue >0) {
              # code...

              // $benefice = $bon_livraison+$chargement_retour+$location_engin-$chiffreAff-$prime- $salaireChauffueurAss-$totalVidange-$depensePneu-$pieceRechange-$gazoil-$fraisRoute-$fraisDIvers;

              $benefice = $location_engin-$totalVidange-$depensePneu-$pieceRechange-$gazoil-$fraisRoute-$fraisDIvers-$prime3;
              $totalNbreVidange =$nbreVidange +  $totalNbreVidange ;
              $totalVidanges = $totalVidanges+$totalVidange;
              $totalFraisDivers = $totalFraisDivers+$fraisDIvers;
              $totalFraisRoute = $totalFraisRoute+$fraisRoute;
              $totalGazoil = $totalGazoil+$gazoil;
              $totalPieceRenchange = $totalPieceRenchange+$pieceRechange;
              $totalDepensePneu = $totalDepensePneu+$depensePneu;
              $totalSalaire = $totalSalaire+ $salaireChauffueurAss;
              $totalchiffreAff = $totalchiffreAff+ $chiffreAff;
              $totalDistance = $totalDistance+ $distance_parcourue;
              $totalBenefice = $totalBenefice + $benefice;
              $totalPrime = $prime3 + $totalPrime;
              $totalChargement = $totalChargement + $chargement_retour;
              $totalLocation = $totalLocation + $location_engin;
              $totalBL = $totalBL + $bon_livraison;
              $totalQtiteGasoil = $totalQtiteGasoil + $qtiteGasoil;
              $totalkm_th = $totalkm_th + $km_th;
              $diff =$distance_parcourue -$km_th;
              $totaldiff = $totaldiff + $diff;
              $total_km_litrage = $total_km_litrage + $km_litrage;

              echo "<tr>
              <td style='size: 8px; border: 1px solid black;'>".$engin['code']."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($fraisDIvers,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($fraisRoute,0,',',' ')."</td>
              
              <td style='size: 8px; border: 1px solid black;'>".$qtiteGasoil."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($gazoil,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($pieceRechange,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($depensePneu,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($totalVidange,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($prime3,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($location_engin,0,',',' ')."</td>
";
              
              if ($benefice<0) {
                # code...
                echo "<td style ='color: red;  border: 1px solid black;'>".number_format($benefice,0,',',' ')."</td>

                </tr>";
              }else{
                echo "<td style='size: 8px; border: 1px solid black;'>".number_format($benefice,0,',',' ')."</td>

                </tr>";
              }
              
             }

    }

   

  }
   echo "<tr>
              <td style ='color: red;  border: 2px solid black;'> TOTAUX</td>
               <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalFraisDivers,0,',',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalFraisRoute,0,',',' ')."</td>
             
             
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".$totalQtiteGasoil."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalGazoil,0,',',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalPieceRenchange,0,',',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalDepensePneu,0,',',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalVidanges,0,',',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalPrime,0,',',' ')."</td>
               <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalLocation,0,',',' ')."</td>
";
              if ($totalBenefice<0) {
                # code...
                echo "<td style ='color: red;  border: 2px solid black;'>".number_format($totalBenefice,3,'.',' ')."</td>

                </tr>";
              }else{
                echo "<td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalBenefice,3,'.',' ')."</td>

                </tr>";
              }
              $this->db->close();
}


// ce code est pour le rapport des bennes

    public function rapportCumuleMensuelBenne(){

// nous allons procéder aux vidanges
$prime3=0;
              $id_type_vehicule = $_POST["id_type_vehicule"];
 $id_operation = $id_type_vehicule;
 $totalNbreVidange =0;
              $totalVidanges =0;
              $totalFraisDivers =0;
              $totalFraisRoute =0;
              $totalGazoil =0;
              $totalPieceRenchange =0;
              $totalDepensePneu =0;
              $totalSalaire =0;
              $totalchiffreAff =0;
              $totalDistance =0;
              $totalBenefice=0;
              $prime1=0;
              $prime=0;
              $totalPrime=0;
               $totalChargement = 0;
              $totalLocation = 0;
              $totalBL = 0;
              $totaldiff = 0;
              
              $totalQtiteGasoil=0;
              
              $totalkm_th =0;
     $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule." order by code asc")->result_array();
     $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule." order by code asc")->result_array();

     $getEngin2 = $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule." order by code asc")->result_array();
 
 if (count($getEngin)>0) {
        $vehicule = $getEngin;
       }elseif (count($getEngin2)>0) {
         # code...
        $vehicule = $getEngin2;
       }elseif (count($getCamion)>0) {
         # code...
        $vehicule = $getCamion;
       }


        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

  if (count($vehicule)>0) {
               # code...
           foreach ($vehicule as $engin) {

$nbreVidange=0;
   $compteur = 0;
$montant10 = 0;
$montant9 = 0;
$qtiteGasoil=0;
$km_th = 0;
     $montant1 =0;
       $total1 = 0;
       $montant =0;
       $total = 0;
       $total2=0;
       $total1=0;
       $total_km_litrage=0;
       $km_litrage = 0;
       $diff= 0;
       
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

             

              if (count($getPrime) >0 ) {
                # code...
                foreach ($getPrime as $row) {
             
                      //   $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
                      // foreach ($getArticle as $tab1) {
                      //   # code...
                      //   $montant1 =  $row["qtite"] * $tab1['PU'];
                      // }
                  $montant1 =  $row["qtite"] * $row['pu'];
                    $total1 = $total1 + $montant1;  
                    
                }
                
              }else{
                // echo "nada";
              }


          $this->db->close();

  $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
     
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...

            //   $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
            //   foreach ($getArticle as $tab1) {
            //   # code...
            //   $montant1 =  $row["qtite"] * $tab1['PU'];
            // }
        $montant1 =  $row["qtite"] * $row['pu'];
          $total1 = $total1 + $montant1; 
          // $nbreVidange = count($getPrime)+$nbreVidange;
      }
      // $nbreVidange = count($getPrime) +$nbreVidange;
    }else{
      // echo "nada";
    }

  $this->db->close();

  $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # co
            //   $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
            //    foreach ($getArticle as $tab1) {
            //   # code...
            //   $montant1 =  $row["qtite"] * $tab1['PU'];
            // }
        $montant1 =  $row["qtite"] * $row['pu'];
          $total1 = $total1 + $montant1;
          // $nbreVidange = count($getPrime)+$nbreVidange;
      }
      // $nbreVidange = count($getPrime) +$nbreVidange;
    }else{
      // echo "nada";
    }
    // echo $total;
//   }
// }

$this->db->close();

$totalVidange = $total1;
// return $total2 + $total1;

// frais divers

      $id_type_vehicule = $_POST["id_type_vehicule"];
      $id_operation = $id_type_vehicule;
$compteur = 0;
     $montant1 =0;
       $total1 = 0;

       $montant2 =0;
       $total2 = 0;

       $montant =0;
       $total = 0;
        
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

          // if (count($vehicule$vehicule)>0) {
          //      # code...
          //  foreach ($vehicule as $engin) {
            
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
       
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {

       // $montant = $row['montant'];
       
       $total = $total + $row['montant'];
      }
    }else{
      // echo "nada";
    }
  // }
  // }

    $this->db->close();

$fraisDIvers = $total1 +$total+$total2;


// les frais de routes doivent suivre ici



$compteur = 0;
     $montant1 =0;
       $total1 = 0;
       $montant =0;
       $total = 0;
   

          // if (count($vehicule)>0) {
          //      # code...
          //  foreach ($vehicule as $engin) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
       
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {

       // $montant = $row['montant'];
       
       $total = $total + $row['montant'];
      }
    }else{
      // echo "nada";
    }
  // }
  // }

    $this->db->close();

$fraisRoute = $total1 +$total;

// depense gazoil


    $id_type_vehicule = $_POST["id_type_vehicule"];
              $id_operation = $id_type_vehicule;
              $compteur = 0;
              $total1 = 0;
              $total = 0;
 
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

          // if (count($vehicule)>0) {
          //      # code...
          //  foreach ($vehicule as $engin) {
        
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $getDestination = $this->db->query("SELECT * from distance_littrage where id_distance=".$row['id_distance']."")->row();
       
            $montant = $row['litrage']*$row['prix_unitaire'];

            $km_litrage = $getDestination->kilometrage+$km_litrage;
            $total = $montant + $total;
            $qtiteGasoil  = $qtiteGasoil+$row['litrage'];
   
      }
    }else{
      // echo "nada";
      $qtiteGasoil  =2;
    }
    //  }
// N L/0.45 || A 0.55
   if (count($getCamion)>0) {
      
          $km_th = $qtiteGasoil /0.55;
      
       }
    // }

$this->db->close();

    $gazoil = $total+ $total1;

// piece de rechange

$compteur = 0;
     $montant1 =0;
       $total1 = 0;
       $montant =0;
       $total = 0;

       $montant2 =0;
       $total2 = 0;

          // if (count($vehicule)>0) {
          //      # code...
          //  foreach ($vehicule as $engin) {
               # code...
       
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
       
     if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $getPrixUnitaire = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->result_array();

        foreach ($getPrixUnitaire as $tab) {
          # code...
          $montant = $row["prix_unitaire"]* $row["qtite"];
        }

        $total = $total+$montant;
        
        $compteur++;
      }
    }else{
      // echo "nada";
    }
//   }
// }

$this->db->close();

$pieceRechange = $total1+$total;

// Depense pneu


           $id_type_vehicule = $_POST["id_type_vehicule"];
$id_operation = $id_type_vehicule;
$compteur = 0;
$total = 0;
$montant = 0;
   
     # code...
           // foreach ($vehicule as $engin) {

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        
            $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
        
         
        foreach ($getPrime as $row) {
            # code...

            
                 $montant = $row['qtite']*$row['prix_unitaire'];

                 $total = $total + $montant;                 
        }
    
// }

        $this->db->close();

$depensePneu = $total;
// total vidange


// salaire employe et chauffeur

  
           // foreach ($vehicule as $engin) {

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        
            $getPrime = $this->db->query('SELECT * FROM chauffeur where id_chauffeur ='.$engin["id_chauffeur"].'')->result_array();
        
         
        foreach ($getPrime as $row) {
            # code...

            
                 $montant = $row['salaire_ass']+$row['salaire'];

                 // $total = $total + $montant;                 
        }
    
// }
$gps = 21465;

// la ligne qui suis est le net à payer qu'on a copié sur la partie paie employé

$np = $montant-$this->getAllRetenueSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)-$this->getAllReglementImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)+$this->getAllRegulationImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin);


$getValidePourSalaire = $this->db->query("SELECT * from paiechauffeur where id_chauffeur=".$row['id_chauffeur']."")->row();
if (count($getValidePourSalaire)>0) {
  # code...
  if ($getValidePourSalaire->salaire == 1) {
    # code...
    $salaireChauffueurAss = $gps;
  }elseif ($getValidePourSalaire->salaire_gps == 1) {
    # code...
    $salaireChauffueurAss =0;
  }elseif ($getValidePourSalaire->gps == 1) {
    # code...
    $salaireChauffueurAss =$np;
  }else{
    $salaireChauffueurAss = $np + $gps;
  }
}else{
  $salaireChauffueurAss = $np + $gps;
}

// bon de livraison


     $montant1=0;
     $montant=0;
     $compteur = 0;
    $total1 = 0;
    $montant1=0;

    $montant2=0;


           // if (count($vehicule)>0) {
           //     # code...
           // foreach ($vehicule as $engin) {
               # code...


       
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
       
$nbreVoyage=0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {

        $total1 = $row['quantite']*$row['prix_unitaire'];
        $montant2 = $total1+ $montant2;
        $nbreVoyage = $nbreVoyage+1; 
      }
      $nbreVidange = $nbreVoyage;

    }else{
      // echo "nada";
    }

    $bon_livraison = $montant2;

    // if ($nbreVoyage == 0) {
    //   # code...
    //   $salaireChauffueurAss = 0;
    // }
    // $montant1 = $montant1+$montant2;
        // return $montant;
        //    }
           
        // }
$this->db->close();
// chargement retour
    //  if (count($vehicule)>0) {
    
    // foreach ($vehicule as $tracteur) {
               # code...

            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
      
$compteur = 0;
$total = 0;
$montant=0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
         $montant  = $montant + $row['montant'];
        // $total = $row['quantite']*$row['prix_unitaire'];
        // $montant = $total+ $montant;
      }
    }else{
      // echo "nada";
    }
$chargement_retour = $montant;
        // return $montant;

    // }

        
    // }
    



              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
       
            $getPrime22 = $this->db->query('SELECT montant FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
       
    if (count($getPrime22) >0 ) {
      # code...
      $prime3 = 0;
      foreach ($getPrime22 as $row3) {

        $prime3 = $row3['montant'] +$prime3;
        // $prime= $prime1+ $montant1;
      }
    }else{
      // echo "nada";
      $prime3 = 0;
    }

        // return $montant;
           
           
        
$this->db->close();

// Location engin

           // if (count($vehicule)>0) {
           //     # code...
           // foreach ($vehicule as $engin) {
               # code...

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

        $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin['code'].'"')->result_array();
        
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
 
          if (count($getPrime) >0 ) {
            # code...
            foreach ($getPrime as $row) {
              # code...
              $getOperation = $this->db->query("SELECT * from operation where id_operation = ".$row['id_operation']." limit 1")->row();
               $montant10 = $row['montant']*$row['duree'];                  
               $montant9 = $montant9 + $montant10;
            }
            
          }else{
            // echo "nada";
          }

  $location_engin = $montant9;
      // }
      //      // return $montant9;
      //   }

$chiffreAff = $montant9 + $montant+$montant2;
        // salaire employe et chauffeur

  $this->db->close();
           // foreach ($vehicule as $engin) {

              $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        
            $getPrime = $this->db->query('SELECT * FROM distance_parcourue where date_distance between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
        
         
        foreach ($getPrime as $row) {
            # code...

            
                 $montant = $row['kilometrage_fin']-$row['kilometrage_debut'];

                 $total = $montant;                 
        }
    
       // }
       $distance_parcourue = $total;

            if ($nbreVidange >0 || $fraisDIvers >0 || $fraisRoute >0 || $gazoil >0 || $pieceRechange >0 || $depensePneu >0 || $totalVidange>0 || $salaireChauffueurAss >0 || $chiffreAff >0 || $distance_parcourue >0) {
              # code...

              // $benefice = $bon_livraison+$chargement_retour+$location_engin-$chiffreAff-$prime- $salaireChauffueurAss-$totalVidange-$depensePneu-$pieceRechange-$gazoil-$fraisRoute-$fraisDIvers;

              $benefice = $bon_livraison+$location_engin-$prime3- $salaireChauffueurAss-$totalVidange-$depensePneu-$pieceRechange-$gazoil-$fraisRoute-$fraisDIvers;
              $totalNbreVidange =$nbreVidange +  $totalNbreVidange ;
              $totalVidanges = $totalVidanges+$totalVidange;
              $totalFraisDivers = $totalFraisDivers+$fraisDIvers;
              $totalFraisRoute = $totalFraisRoute+$fraisRoute;
              $totalGazoil = $totalGazoil+$gazoil;
              $totalPieceRenchange = $totalPieceRenchange+$pieceRechange;
              $totalDepensePneu = $totalDepensePneu+$depensePneu;
              $totalSalaire = $totalSalaire+ $salaireChauffueurAss;
              $totalchiffreAff = $totalchiffreAff+ $chiffreAff;
              $totalDistance = $totalDistance+ $distance_parcourue;
              $totalBenefice = $totalBenefice + $benefice;
              $totalPrime = $prime3 + $totalPrime;
              $totalChargement = $totalChargement + $chargement_retour;
              $totalLocation = $totalLocation + $location_engin;
              $totalBL = $totalBL + $bon_livraison;
              $totalQtiteGasoil = $totalQtiteGasoil + $qtiteGasoil;
              $totalkm_th = $totalkm_th + $km_th;
              $diff =$distance_parcourue -$km_th;
              $totaldiff = $totaldiff + $diff;
              $total_km_litrage = $total_km_litrage + $km_litrage;

              echo "<tr style='text-align: center;'>
              <td style='size: 8px; border: 1px solid black; text-align: center;'>".$engin['code']."</td>
              <td style='size: 8px; border: 1px solid black;text-align: center;'>".$nbreVidange."</td>
              <td style='size: 8px; border: 1px solid black;text-align: center;'>".number_format($fraisDIvers,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;text-align: center;'>".number_format($fraisRoute,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".$qtiteGasoil."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($gazoil,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($pieceRechange,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($depensePneu,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($totalVidange,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($salaireChauffueurAss,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($prime3,0,',',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($bon_livraison,0,'.',' ')."</td>
              
              
   
              <td style='size: 8px; border: 1px solid black;'>".number_format($distance_parcourue,2,'.',' ')."</td>
              <td style='size: 8px; border: 1px solid black;'>".number_format($km_th,2,'.',' ')."</td>";
              if ($diff<0) {
                # code
                echo"<td style='size: 8px; border: 1px solid black; color:red;'>".number_format($diff,2,'.',' ')."</td>"; 
              }else{
                echo"<td style='size: 8px; border: 1px solid black;'>".number_format($diff,2,'.',' ')."</td>";
              }
              
              if ($benefice<0) {
                # code...
                echo "<td style ='color: red;  border: 1px solid black;'>".number_format($benefice,0,',',' ')."</td>

                </tr>";
              }else{
                echo "<td style='size: 8px; border: 1px solid black;'>".number_format($benefice,0,',',' ')."</td>

                </tr>";
              }
              
             }

    }

   

  }
   echo "<tr style='text-align: center;'>
              <td style ='color: red;  border: 2px solid black;'> TOTAUX</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".$totalNbreVidange."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalFraisDivers,0,',',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalFraisRoute,0,',',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".$totalQtiteGasoil."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalGazoil,0,',',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalPieceRenchange,0,',',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalDepensePneu,0,',',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalVidanges,0,',',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalSalaire,0,',',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalPrime,0,',',' ')."</td>
               <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalBL,0,'.',' ')."</td>
             
             
            
         
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalDistance,2,'.',' ')."</td>
              <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalkm_th,2,'.',' ')."</td>";
              if ($totaldiff < 0) {
                # code...
                echo"<td style ='color: red; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totaldiff,2,'.',' ')."</td>";
              }else{
               echo " <td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totaldiff,2,'.',' ')."</td>";
              }
              
              if ($totalBenefice<0) {
                # code...
                echo "<td style ='color: red;  border: 2px solid black;'>".number_format($totalBenefice,3,'.',' ')."</td>

                </tr>";
              }else{
                echo "<td style ='color: #20d02b; size:10px; font-weight: bold;  border: 2px solid black;'>".number_format($totalBenefice,3,'.',' ')."</td>

                </tr>";
              }
              $this->db->close();
}

// public function selectAllChargementOperationPourRapport(){
//            $id_type_vehicule = $_POST["id_type_vehicule"];
//  $id_operation = $id_type_vehicule;
//  $compteur = 0;
//      $getTracteur = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
//      $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();
//            if (count($getTracteur)>0) {
//                # code...
//            foreach ($getTracteur as $tracteur) {
//                # code...

//               $date_debut = $_POST["date_debut"];
//         $date_fin = $_POST["date_fin"];
//         if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  code_camion="'.$tracteur['code'].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg>="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg<="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg<="'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg>="'.$date_debut.'" and code_camion="'.$tracteur['code'].'"')->result_array();

//         }
//     // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...

//         echo "<tr><td>".$compteur."</td>
//               <td>".$row['numero']."</td>
//               <td>".$row['code_camion']."</td>
//               <td>".number_format($row['montant'],0,',',' ')."</td>
//               <td>".$row['date_charg']."</td> </tr>";
//           $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }

//     }
//   }

//   if (count($getCamion)>0) {
    
//     foreach ($getCamion as $tracteur) {
//                # code...

//               $date_debut = $_POST["date_debut"];
//         $date_fin = $_POST["date_fin"];
//         if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  code_camion="'.$tracteur['code'].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg>="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg<="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg<="'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg>="'.$date_debut.'" and code_camion="'.$tracteur['code'].'"')->result_array();

//         }
//     // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...

//         echo "<tr><td>".$compteur."</td>
//               <td>".$row['numero']."</td>
//               <td>".$row['code_camion']."</td>
//               <td>".number_format($row['montant'],0,',',' ')."</td>
//               <td>".$row['date_charg']."</td> </tr>";
//           $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }

//     }
//   }
//  }



//  public function selectAllTotalChargementOperationPourRapport(){
//            $id_type_vehicule = $_POST["id_type_vehicule"];
//  $id_operation = $id_type_vehicule;

//  $compteur = 0;
// $total1 = 0;
// $montant1=0;

// $total = 0;
// $montant=0;
//      $getTracteur = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
//      $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();
//            if (count($getTracteur)>0) {
//                # code...
//            foreach ($getTracteur as $tracteur) {
//                # code...

//               $date_debut = $_POST["date_debut"];
//         $date_fin = $_POST["date_fin"];
//         if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  code_camion="'.$tracteur['code'].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg>="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg<="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg<="'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg>="'.$date_debut.'" and code_camion="'.$tracteur['code'].'"')->result_array();

//         }
//     // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {

//         $montant  = $montant + $row['montant'];
        
//       }
//     }else{
//       // echo "nada";
//     }

//         // return $montant;
//     }
//   }

//   if (count($getCamion)>0) {
    
//     foreach ($getCamion as $tracteur) {
//                # code...

//               $date_debut = $_POST["date_debut"];
//         $date_fin = $_POST["date_fin"];
//         if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  code_camion="'.$tracteur['code'].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg>="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg<="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg<="'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg>="'.$date_debut.'" and code_camion="'.$tracteur['code'].'"')->result_array();

//         }
//     // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {

//         $montant1  = $montant1 + $row['montant'];
        
//       }
//     }else{
//       // echo "nada";
//     }

//         // return $montant;
//        }
//     }
//      return $montant+$montant1;
//  }


//      public function selectAllFactureOperationPourRapport(){
//            $id_type_vehicule = $_POST["id_type_vehicule"];
//            $id_operation = $id_type_vehicule;
//            $compteur = 0;
//      $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
//      $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();
//            if (count($getEngin)>0) {
//                # code...
//            foreach ($getEngin as $engin) {
//                # code...

//               $date_debut = $_POST["date_debut"];
//         $date_fin = $_POST["date_fin"];
//         if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  code_camion="'.$engin['code'].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl>="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_type_vehicule) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl<="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_type_vehicule) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl<="'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl>="'.$date_debut.'" and code_camion="'.$engin['code'].'"')->result_array();

//         }
//         // else{
//         //     $getPrime = $this->db->query("SELECT * FROM bon_livraison ")->result_array();
//         // }
//     // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
//         echo $id_type_vehicule;

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...
//         $getDstination = $this->db->query("SELECT * from distance_littrage where id_distance = ".$row['id_destination_litrage']."")->row();
//         $total = $row['quantite']*$row['prix_unitaire'];
//         echo "<tr><td>".$compteur."</td>
//               <td>".$row['numero']."</td>
//               <td>".$engin['code']."</td>
//               <td>".number_format($row['prix_unitaire'],0,',',' ')."</td>
//              <td>".$row['quantite']."</td>
//               <td>".number_format($total,0,',',' ')."</td>
//               <td>".$row['date_bl']."</td>
//               <td>".$getDstination->distance."</td>
//               <td>".$row['unite']."</td> </tr>";
//           $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }
//            }
           
//         }

//      if (count($getCamion)>0) {
    
//     foreach ($getCamion as $engin) {
//                # code...

//               $date_debut = $_POST["date_debut"];
//         $date_fin = $_POST["date_fin"];
//         if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  code_camion="'.$engin['code'].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl>="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_type_vehicule) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl<="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_type_vehicule) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl<="'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl>="'.$date_debut.'" and code_camion="'.$engin['code'].'"')->result_array();

//         }
//     // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();

//     if (count($getPrime) >0 ) {
//       # code...
//        foreach ($getPrime as $row) {
//         # code...
//         $getDstination = $this->db->query("SELECT * from distance_littrage where id_distance = ".$row['id_destination_litrage']."")->row();
//         $total = $row['quantite']*$row['prix_unitaire'];
//         echo "<tr><td>".$compteur."</td>
//               <td>".$row['numero']."</td>
//               <td>".$engin['code']."</td>
//               <td>".number_format($row['prix_unitaire'],0,',',' ')."</td>
//              <td>".$row['quantite']."</td>
//               <td>".number_format($total,0,',',' ')."</td>
//               <td>".$row['date_bl']."</td>
//               <td>".$getDstination->distance."</td>
//               <td>".$row['unite']."</td> </tr>";
//           $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }

//     }

//     }
   
// }

// public function selectAllDepensePneuOperationPourRapport(){

//            $id_type_vehicule = $_POST["id_type_vehicule"];
// $id_operation = $id_type_vehicule;
// $compteur = 0;
//      $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
//      $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();
        

//            $getEngin2= $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule."")->result_array();
      
//        if (count($getEngin)>0) {
//         $vehicule = $getEngin;
//        }elseif (count($getEngin2)>0) {
//          # code...
//         $vehicule = $getEngin2;
//        }elseif (count($getCamion)>0) {
//          # code...
//         $vehicule = $getCamion;
//        }
//                # code...
//            foreach ($vehicule as $engin) {

//               $date_debut = $_POST["date_debut"];
//         $date_fin = $_POST["date_fin"];
//         if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  code_camion="'.$engin['code'].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense>="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_type_vehicule) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense<="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_type_vehicule) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense<="'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense>="'.$date_debut.'" and code_camion="'.$engin['code'].'"')->result_array();

//         }
         
         
//         foreach ($getPrime as $row) {
//             # code...

//             echo "<tr >
                    
//                     <td> ".$compteur."</td>     
//                     <td>".$row['code_camion']."</td>";
//                     $getArticle = $this->db->query("SELECT * from article where id_article = ".$row['id_article']."")->row();

//                     echo"
//                     <td> ".$getArticle->article." </td>
//                     <td> ".$row['type']." </td>
//                     <td> ".$row['derniereDate']." </td>
//                     <td> ".$row['date_depense']." </td>
//                     <td> ".$row['prix_unitaire']." </td>
//                     <td> ".$row['qtite']." </td>
//                     <td> ".$row['qtite']*$row['prix_unitaire']." </td>
                    
//                     <td> ".$row['commentaire']." </td>
                   
//                   </tr>

//                   ";
//                   $compteur++;
//         }
    
// }
// }





//  public function selectAllPrimeOperationPourRapport(){
//            $id_type_vehicule = $_POST["id_type_vehicule"];
//            $id_operation = $id_type_vehicule;
// $compteur = 0;
//      $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
//      $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();
//      $getEngin2 = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();
          
//            if (count($getEngin)>0) {
//                # code...
//            foreach ($getEngin as $engin) {
//                # code...

//               $date_debut = $_POST["date_debut"];
//         $date_fin = $_POST["date_fin"];
//         if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  code_camion="'.$engin['code'].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime>="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_type_vehicule) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_type_vehicule) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime>="'.$date_debut.'" and code_camion="'.$engin['code'].'"')->result_array();

//         }
//     // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...

//         echo "<tr><td>".$compteur."</td>
//               <td>".$row['code_camion']."</td>
//               <td>".number_format($row['montant'],0,',',' ')."</td>
//               <td>".$row['libelle']."</td>
//               <td>".$row['date_prime']."</td> </tr>";
//         $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }
//         // return $montant;
//            }
//            }
           
              
//            if (count($getEngin2)>0) {
//                # code...
//            foreach ($getEngin2 as $engin) {
//                # code...

//               $date_debut = $_POST["date_debut"];
//         $date_fin = $_POST["date_fin"];
//         if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  code_camion="'.$engin['code'].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime>="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_type_vehicule) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_type_vehicule) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime>="'.$date_debut.'" and code_camion="'.$engin['code'].'"')->result_array();

//         }
//     // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...

//         echo "<tr><td>".$compteur."</td>
//               <td>".$row['code_camion']."</td>
//               <td>".number_format($row['montant'],0,',',' ')."</td>
//               <td>".$row['libelle']."</td>
//               <td>".$row['date_prime']."</td> </tr>";
//         $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }
//         // return $montant;
//            }
//            }

//      if (count($getCamion)>0) {
    
//     foreach ($getCamion as $tracteur) {
//                # code...

//               $date_debut = $_POST["date_debut"];
//         $date_fin = $_POST["date_fin"];
//         if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  code_camion="'.$tracteur['code'].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime>="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_type_vehicule) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_type_vehicule) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime>="'.$date_debut.'" and code_camion="'.$tracteur['code'].'"')->result_array();

//         }
//     // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
       
//             if (count($getPrime) >0 ) {
//               # code...
//               foreach ($getPrime as $row) {
//                 # code...

//                 echo "<tr><td>".$compteur."</td>
//                       <td>".$row['code_camion']."</td>
//                       <td>".number_format($row['montant'],0,',',' ')."</td>
//                       <td>".$row['libelle']."</td>
//                       <td>".$row['date_prime']."</td> </tr>";
//                 $compteur++;
//               }
//             }else{
//               // echo "nada";
//             }
//         // return $montant;

//         }

//     }
//  }


//      public function selectAllTotalPrimeOperationPourRapport(){
//            $id_type_vehicule = $_POST["id_type_vehicule"];
//            $id_operation = $id_type_vehicule;
// $compteur = 0;
// $total = 0;
// $montant=0;

// $total = 0;
// $montant1=0;

// $total2 = 0;
// $montant2=0;
//      $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
//      $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();
//      $getEngin2= $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule."")->result_array();
      
//        if (count($getEngin)>0) {
//                # code...
//            foreach ($getEngin as $engin) {
//                # code...

//               $date_debut = $_POST["date_debut"];
//         $date_fin = $_POST["date_fin"];
//         if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  code_camion="'.$engin['code'].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime>="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_type_vehicule) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_type_vehicule) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime>="'.$date_debut.'" and code_camion="'.$engin['code'].'"')->result_array();

//         }
//     // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {

//         $total = $row['montant'];
//         $montant1 = $total+ $montant1;
//       }
//     }else{
//       // echo "nada";
//     }

//         // return $montant;
//            }
           
//         }

//    if (count($getEngin2)>0) {
//                # code...
//            foreach ($getEngin2 as $engin) {
//                # code...

//               $date_debut = $_POST["date_debut"];
//         $date_fin = $_POST["date_fin"];
//         if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  code_camion="'.$engin['code'].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime>="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_type_vehicule) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_type_vehicule) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime>="'.$date_debut.'" and code_camion="'.$engin['code'].'"')->result_array();

//         }
//     // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {

//         $total = $row['montant'];
//         $montant2 = $total+ $montant2;
//       }
//     }else{
//       // echo "nada";
//     }

//         // return $montant;
//            }
           
//         }

//      if (count($getCamion)>0) {
    
//     foreach ($getCamion as $tracteur) {
//                # code...

//               $date_debut = $_POST["date_debut"];
//         $date_fin = $_POST["date_fin"];
//         if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  code_camion="'.$tracteur['code'].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime>="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_type_vehicule) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_type_vehicule) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_type_vehicule) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime>="'.$date_debut.'" and code_camion="'.$tracteur['code'].'"')->result_array();

//         }else{
//           // echo 'cetrs movè'.$id_type_vehicule;
//         }
//     // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {

//         $total = $row['montant'];
//         $montant = $total+ $montant;
//       }
//     }else{
//       // echo "nada";
//     }

//         // return $montant;

//     }

        
//     }

//     return $montant+$montant1+$montant2;
// }

//     public function selectAllFraisRouteOperationPourRapport(){

//       $id_type_vehicule = $_POST["id_type_vehicule"];
//       $id_operation = $id_type_vehicule;
// $compteur = 0;
//      $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
//      $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();

//         $date_debut = $_POST["date_debut"];
//         $date_fin = $_POST["date_fin"];

//           if (count($getEngin)>0) {
//                # code...
//            foreach ($getEngin as $engin) {
//                # code...

//               $date_debut = $_POST["date_debut"];
//         $date_fin = $_POST["date_fin"];
//         if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais>="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais<="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

//         }else{
//             // $getPrime = $this->db->query('SELECT * FROM frais_route')->result_array();
//         }

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...
// $getDistance = $this->db->query("SELECT * FROM distance_littrage where id_distance = ".$row['id_distance']."")->row();
//                     if (count($getDistance)>0) {
//                         # code...
//                         $distance = $getDistance->distance;
//                     }else{
//                         $distance = "";
//                     }
//         echo "<tr><td>".$compteur."</td>
//               <td>".$row['code_camion']."</td>
//               <td>".number_format($row['montant'],0,',',' ')." FCFA</td>
//                <td>".addslashes($distance)."</td>
//               <td>".$row['date_frais']."</td> </tr>";
//         $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }
//   }
//   }

//   if (count($getCamion)>0) {

//    foreach ($getEngin as $engin) {
//        $date_debut = $_POST["date_debut"];
//        $date_fin = $_POST["date_fin"];

//        if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais>="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais<="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }else{
//             // $getPrime = $this->db->query('SELECT * FROM frais_route')->result_array();
//         }

     
//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...
// $getDistance = $this->db->query("SELECT * FROM distance_littrage where id_distance = ".$row['id_distance']."")->row();
//                     if (count($getDistance)>0) {
//                         # code...
//                         $distance = $getDistance->distance;
//                     }else{
//                         $distance = "";
//                     }
//         echo "<tr><td>".$compteur."</td>
//               <td>".$row['code_camion']."</td>
//               <td>".number_format($row['montant'],0,',',' ')." FCFA</td>
//                <td>".addslashes($distance)."</td>
//               <td>".$row['date_frais']."</td> </tr>";
//         $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }
//   }
// }
// }




//     public function selectAllFraisDiversOperationPourRapport(){

//       $id_type_vehicule = $_POST["id_type_vehicule"];
//       $id_operation = $id_type_vehicule;
// $compteur = 0;
//      $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
//      $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();

//      $getEngin2= $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule."")->result_array();

//         $date_debut = $_POST["date_debut"];
//         $date_fin = $_POST["date_fin"];

//           if (count($getEngin)>0) {
//                # code...
//            foreach ($getEngin as $engin) {
//                # code...

//               $date_debut = $_POST["date_debut"];
//         $date_fin = $_POST["date_fin"];
//         if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais>="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais<="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

//         }else{
//             // $getPrime = $this->db->query('SELECT * FROM frais_route')->result_array();
//         }

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...

//         echo "<tr><td>".$compteur."</td>
//               <td>".$row['code_camion']."</td>
//               <td>".number_format($row['montant'],0,',',' ')." FCFA</td>
//               <td>".$row['date_frais']."</td> </tr>";
//         $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }
//   }
//   }

//             if (count($getEngin2)>0) {
//                # code...
//            foreach ($getEngin2 as $engin) {
//                # code...

//               $date_debut = $_POST["date_debut"];
//         $date_fin = $_POST["date_fin"];
//         if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais>="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais<="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

//         }else{
//             // $getPrime = $this->db->query('SELECT * FROM frais_route')->result_array();
//         }

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...

//         echo "<tr><td>".$compteur."</td>
//               <td>".$row['code_camion']."</td>
//               <td>".number_format($row['montant'],0,',',' ')." FCFA</td>
//               <td>".$row['date_frais']."</td> </tr>";
//         $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }
//   }
//   }

//   if (count($getCamion)>0) {

//    foreach ($getEngin as $engin) {
//        $date_debut = $_POST["date_debut"];
//        $date_fin = $_POST["date_fin"];

//        if (empty($date_debut) && empty($date_fin) && !empty($id_type_vehicule)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais>="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais<="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }else{
//             // $getPrime = $this->db->query('SELECT * FROM frais_route')->result_array();
//         }

     
//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...
//         echo "<tr><td>".$compteur."</td>
//               <td>".$row['code_camion']."</td>
//               <td>".number_format($row['montant'],0,',',' ')." FCFA</td>
//               <td>".$row['date_frais']."</td> </tr>";
//         $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }
//   }
// }
// }



// public function selectAllPieceRechangeOperationPourRapport(){
//           $id_type_vehicule = $_POST["id_type_vehicule"];
//           $id_operation = $id_type_vehicule;
// $compteur = 0;
//      $montant1 =0;
//        $total1 = 0;
//        $montant =0;
//        $total = 0;
//      $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
//      $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();

//      $getEngin2 = $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule."")->result_array();

//         $date_debut = $_POST["date_debut"];
//         $date_fin = $_POST["date_fin"];

//           if (count($getEngin)>0) {
//                # code...
//            foreach ($getEngin as $engin) {
//                # code...
//         if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech >="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }else{
//             $getPrime = $this->db->query('SELECT * FROM piece_rechange')->result_array();
//         }
//     // $getPrime = $this->db->query("SELECT * FROM piece_rechange where id_operation =".$id_operation."")->result_array();
// $compteur = 0;
//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...

//         echo "<tr><td>".$compteur."</td>
//               <td>".$row['code_camion']."</td>";
//               $getArticle = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->row();
//               echo "<td>".$getArticle->article."</td>";
//               echo "<td>".$getArticle->code_a_barre."</td>";
//              echo" <td>".number_format($row['prix_unitaire'],0,',',' ')."</td>
//              <td>".$row['qtite']."</td>
//              <td>".number_format($row['qtite']*$row['prix_unitaire'],0,',',' ')."</td>
//               <td>".$row['date_rech']."</td> </tr>";
//         $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }
//   }
// }

//           if (count($getEngin2)>0) {
//                # code...
//            foreach ($getEngin2 as $engin) {
//                # code...
//         if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech >="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }else{
//             $getPrime = $this->db->query('SELECT * FROM piece_rechange')->result_array();
//         }
//     // $getPrime = $this->db->query("SELECT * FROM piece_rechange where id_operation =".$id_operation."")->result_array();
// $compteur = 0;
//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...

//         echo "<tr><td>".$compteur."</td>
//               <td>".$row['code_camion']."</td>";
//               $getArticle = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->row();
//               echo "<td>".$getArticle->article."</td>";
//               echo "<td>".$getArticle->code_a_barre."</td>";
//              echo" <td>".number_format($row['prix_unitaire'],0,',',' ')."</td>
//              <td>".$row['qtite']."</td>
//              <td>".number_format($row['qtite']*$row['prix_unitaire'],0,',',' ')."</td>
//               <td>".$row['date_rech']."</td> </tr>";
//         $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }
//   }
// }

// if (count($getCamion)>0) {
//                # code...
//            foreach ($getEngin as $engin) {
//                # code...
//         if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech >="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }else{
//             $getPrime = $this->db->query('SELECT * FROM piece_rechange')->result_array();
//         }
//     // $getPrime = $this->db->query("SELECT * FROM piece_rechange where id_operation =".$id_operation."")->result_array();
// $compteur = 0;
//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...

//         echo "<tr><td>".$compteur."</td>
//               <td>".$row['code_camion']."</td>";
//               $getArticle = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->row();
//               echo "<td>".$getArticle->article."</td>";
//               echo "<td>".$getArticle->code_a_barre."</td>";
//              echo" <td>".number_format($row['prix_unitaire'],0,',',' ')."</td>
//              <td>".$row['qtite']."</td>
//              <td>".number_format($row['qtite']*$row['prix_unitaire'],0,',',' ')."</td>
//               <td>".$row['date_rech']."</td> </tr>";
//         $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }
//   }
// }
//   }




// public function selectAllVidangeOperationPourRapport(){

//               $id_type_vehicule = $_POST["id_type_vehicule"];
//               $id_operation = $id_type_vehicule;
// $compteur = 0;

//      $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
//      $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();

//      $getEngin2 = $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule."")->result_array();

//         $date_debut = $_POST["date_debut"];
//         $date_fin = $_POST["date_fin"];

//           if (count($getEngin)>0) {
//                # code...
//            foreach ($getEngin as $engin) {

//         if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange >="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }else{
//             $getPrime = $this->db->query('SELECT * FROM vidange')->result_array();
//         }

//     // $getPrime = $this->db->query("SELECT * FROM vidange where id_operation =".$id_operation."")->result_array();
 
//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...

//         echo "<tr><td>".$compteur."</td>
             
//               <td>".$row['code_camion']."</td>";
//               $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->row();
//               echo "<td>".$getArticle->type_huile."</td>
//               <td>".$getArticle->huile."</td>";
//               $prixTotal = $getArticle->PU *$row['qtite'];

//              echo" <td>".number_format($row['qtite'],0,',',' ')."</td> 
//              <td>".number_format($getArticle->PU,0,',',' ')."</td>
//              <td>".number_format($prixTotal,0,',',' ')."</td>
//               <td>".$row['date_vidange']."</td> </tr>";
//         $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }
//     if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange >="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange <="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }else{
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique')->result_array();
//         }
//       // $getPrime = $this->db->query("SELECT * FROM vidangeHydrolique where id_operation =".$id_operation."")->result_array();

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...

//         echo "<tr><td>".$compteur."</td>
             
//               <td>".$row['code_camion']."</td>";
//               $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->row();
//               echo "<td>".$getArticle->type_huile."</td>
//               <td>".$getArticle->huile."</td>";
//               $prixTotal = $getArticle->PU *$row['qtite'];
//              echo" <td>".number_format($row['qtite'],0,',',' ')."</td> 
//              <td>".number_format($getArticle->PU,0,',',' ')."</td>
//              <td>".number_format($prixTotal,0,',',' ')."</td>
//               <td>".$row['date_vidange']."</td> </tr>";
//         $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }
// if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange >="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange <="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }else{
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite')->result_array();
//         }
//       // $getPrime = $this->db->query("SELECT * FROM vidangeBoite where id_operation =".$id_operation."")->result_array();

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...

//         echo "<tr><td>".$compteur."</td>
             
//               <td>".$row['code_camion']."</td>";
//               $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->row();
//               echo "<td>".$getArticle->type_huile."</td>
//               <td>".$getArticle->huile."</td>";
//               $prixTotal = $getArticle->PU *$row['qtite'];
//              echo" <td>".number_format($row['qtite'],0,',',' ')."</td> 
//              <td>".number_format($getArticle->PU,0,',',' ')."</td>
//              <td>".number_format($prixTotal,0,',',' ')."</td>
//               <td>".$row['date_vidange']."</td> </tr>";
//         $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }

//   }
//  }

//           if (count($getEngin2)>0) {
//                # code...
//            foreach ($getEngin2 as $engin) {

//         if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange >="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }else{
//             $getPrime = $this->db->query('SELECT * FROM vidange')->result_array();
//         }

//     // $getPrime = $this->db->query("SELECT * FROM vidange where id_operation =".$id_operation."")->result_array();
 
//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...

//         echo "<tr><td>".$compteur."</td>
             
//               <td>".$row['code_camion']."</td>";
//               $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->row();
//               echo "<td>".$getArticle->type_huile."</td>
//               <td>".$getArticle->huile."</td>";
//               $prixTotal = $getArticle->PU *$row['qtite'];

//              echo" <td>".number_format($row['qtite'],0,',',' ')."</td> 
//              <td>".number_format($getArticle->PU,0,',',' ')." </td>
//              <td>".number_format($prixTotal,0,',',' ')."</td>
//               <td>".$row['date_vidange']."</td> </tr>";
//         $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }
//     if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange >="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange <="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }else{
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique')->result_array();
//         }
//       // $getPrime = $this->db->query("SELECT * FROM vidangeHydrolique where id_operation =".$id_operation."")->result_array();

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...

//         echo "<tr><td>".$compteur."</td>
             
//               <td>".$row['code_camion']."</td>";
//               $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->row();
//               echo "<td>".$getArticle->type_huile."</td>
//               <td>".$getArticle->huile."</td>";
//               $prixTotal = $getArticle->PU *$row['qtite'];
//              echo" <td>".number_format($row['qtite'],0,',',' ')."</td> 
//              <td>".number_format($getArticle->PU,0,',',' ')."</td>
//              <td>".number_format($prixTotal,0,',',' ')."</td>
//               <td>".$row['date_vidange']."</td> </tr>";
//         $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }
// if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange >="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange <="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }else{
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite')->result_array();
//         }
//       // $getPrime = $this->db->query("SELECT * FROM vidangeBoite where id_operation =".$id_operation."")->result_array();

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...

//         echo "<tr><td>".$compteur."</td>
             
//               <td>".$row['code_camion']."</td>";
//               $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->row();
//               echo "<td>".$getArticle->type_huile."</td>
//               <td>".$getArticle->huile."</td>";
//               $prixTotal = $getArticle->PU *$row['qtite'];
//              echo" <td>".number_format($row['qtite'],0,',',' ')."</td> 
//              <td>".number_format($getArticle->PU,0,',',' ')."</td>
//              <td>".number_format($prixTotal,0,',',' ')."</td>
//               <td>".$row['date_vidange']."</td> </tr>";
//         $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }

//   }
//  }

//     if (count($getCamion)>0) {
//                # code...
//            foreach ($getCamion as $engin) {

//         if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange >="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }else{
//             $getPrime = $this->db->query('SELECT * FROM vidange')->result_array();
//         }

//     // $getPrime = $this->db->query("SELECT * FROM vidange where id_operation =".$id_operation."")->result_array();

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...

//         echo "<tr><td>".$compteur."</td>
             
//               <td>".$row['code_camion']."</td>";
//               $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->row();
//               echo "<td>".$getArticle->type_huile."</td>
//               <td>".$getArticle->huile."</td>";
//               $prixTotal = $getArticle->PU *$row['qtite'];

//              echo" <td>".number_format($row['qtite'],0,',',' ')."</td> 
//              <td>".number_format($getArticle->PU,0,',',' ')."</td>
//              <td>".number_format($prixTotal,0,',',' ')."</td>
//               <td>".$row['date_vidange']."</td> </tr>";
//         $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }
//     if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange >="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange <="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }else{
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique')->result_array();
//         }
//       // $getPrime = $this->db->query("SELECT * FROM vidangeHydrolique where id_operation =".$id_operation."")->result_array();

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...

//         echo "<tr><td>".$compteur."</td>
             
//               <td>".$row['code_camion']."</td>";
//               $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->row();
//               echo "<td>".$getArticle->type_huile."</td>
//               <td>".$getArticle->huile."</td>";
//               $prixTotal = $getArticle->PU *$row['qtite'];
//              echo" <td>".number_format($row['qtite'],0,',',' ')."</td> 
//              <td>".number_format($getArticle->PU,0,',',' ')."</td>
//              <td>".number_format($prixTotal,0,',',' ')."</td>
//               <td>".$row['date_vidange']."</td> </tr>";
//         $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }
// if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange >="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange <="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }else{
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite')->result_array();
//         }
//       // $getPrime = $this->db->query("SELECT * FROM vidangeBoite where id_operation =".$id_operation."")->result_array();

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...

//         echo "<tr><td>".$compteur."</td>
             
//               <td>".$row['code_camion']."</td>";
//               $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->row();
//               echo "<td>".$getArticle->type_huile."</td>
//               <td>".$getArticle->huile."</td>";
//               $prixTotal = $getArticle->PU *$row['qtite'];
//              echo" <td>".number_format($row['qtite'],0,',',' ')."</td> 
//              <td>".number_format($getArticle->PU,0,',',' ')."</td>
//              <td>".number_format($prixTotal,0,',',' ')."</td>
//               <td>".$row['date_vidange']."</td> </tr>";
//         $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }

//   }
//  }
// }





//           if (count($getEngin2)>0) {
//                # code...
//            foreach ($getEngin2 as $engin) {
//         if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange >="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }else{
//             $getPrime = $this->db->query('SELECT * FROM vidange')->result_array();
//         }
//     // $getPrime = $this->db->query("SELECT * FROM vidange where id_operation =".$id_operation."")->result_array();
//     $compteur = 0;
//     $montant1 = 0;

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
   
//               $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
//             foreach ($getArticle as $tab1) {
//               # code...
//               $montant1 =  $row["qtite"] * $tab1['PU'];
//             }
//           $total1 = $total1 + $montant1;  
//       }
//     }else{
//       // echo "nada";
//     }
// if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange >="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange <="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }else{
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique')->result_array();
//         }
//       // $getPrime = $this->db->query("SELECT * FROM vidangeHydrolique where id_operation =".$id_operation."")->result_array();

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...

//               $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
//               foreach ($getArticle as $tab1) {
//               # code...
//               $montant1 =  $row["qtite"] * $tab1['PU'];
//             }
//           $total1 = $total1 + $montant1; 
//       }
//     }else{
//       // echo "nada";
//     }
// if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange >="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange <="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }else{
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite')->result_array();
//         }
//       // $getPrime = $this->db->query("SELECT * FROM vidangeBoite where id_operation =".$id_operation."")->result_array();

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # co
//               $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
//                foreach ($getArticle as $tab1) {
//               # code...
//               $montant1 =  $row["qtite"] * $tab1['PU'];
//             }
//           $total1 = $total1 + $montant1; 
//       }
//     }else{
//       // echo "nada";
//     }
//     // echo $total;
//   }
// }

//     if (count($getCamion)>0) {
//                # code...
//            foreach ($getCamion as $engin) {
//         if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange >="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }else{
//             $getPrime = $this->db->query('SELECT * FROM vidange')->result_array();
//         }
//     // $getPrime = $this->db->query("SELECT * FROM vidange where id_operation =".$id_operation."")->result_array();
//     $compteur2 = 0;
//     $montant2 = 0;
  
//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
   
//               $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
//             foreach ($getArticle as $tab1) {
//               # code...
//               $montant2 =  $row["qtite"] * $tab1['PU'];
//             }
//           $total2 = $total2 + $montant2;  
//       }
//     }else{
//       // echo "nada";
//     }
// if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange >="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange <="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }else{
//             $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique')->result_array();
//         }
//       // $getPrime = $this->db->query("SELECT * FROM vidangeHydrolique where id_operation =".$id_operation."")->result_array();

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...

//               $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
//               foreach ($getArticle as $tab1) {
//               # code...
//               $montant2 =  $row["qtite"] * $tab1['PU'];
//             }
//           $total2 = $total2 + $montant2; 
//       }
//     }else{
//       // echo "nada";
//     }
// if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange >="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange <="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }else{
//             $getPrime = $this->db->query('SELECT * FROM vidangeBoite')->result_array();
//         }
//       // $getPrime = $this->db->query("SELECT * FROM vidangeBoite where id_operation =".$id_operation."")->result_array();

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # co
//               $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
//                foreach ($getArticle as $tab1) {
//               # code...
//               $montant2 =  $row["qtite"] * $tab1['PU'];
//             }
//           $total2 = $total2 + $montant2; 
//       }
//     }else{
//       // echo "nada";
//     }
    
//   }
// }
// return $total2 + $total1;
// }

// public function selectAllGazoilOperationPourRapport(){
//     $id_type_vehicule = $_POST["id_type_vehicule"];
//               $id_operation = $id_type_vehicule;
//                   $compteur = 0;
//      $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();
//      $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();
//      $getEngin2 = $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule."")->result_array();

//         $date_debut = $_POST["date_debut"];
//         $date_fin = $_POST["date_fin"];

//           if (count($getEngin)>0) {
//                # code...
//            foreach ($getEngin as $engin) {
//         if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil >="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }else{
//             $getPrime = $this->db->query('SELECT * FROM gazoil')->result_array();
//         }
//     // $getPrime = $this->db->query("SELECT * FROM gazoil where id_operation =".$id_operation."")->result_array();

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...
//         $getDestination = $this->db->query("SELECT * from distance_littrage where id_distance=".$row['id_distance']." limit 1")->row();
//         echo "<tr><td>".$compteur."</td>
             
//               <td> ".$row['code_camion']."</td>
//               <td>".$row['numero']."</td>
//               <td>".number_format($row['litrage'],0,',',' ')."</td>
//               <td>".number_format($row['prix_unitaire'],0,',',' ')."</td>";
//               if (count($getDestination)>0) {
//                   # code...
//                 echo "<td>".$getDestination->distance."</td>";
//               }else{
//                 echo "<td>Aucune</td>";
//               }
              
//                echo "<td>".number_format($row['prix_unitaire']*$row['litrage'],0,',',' ')."</td>
//               <td>".$row['date_gazoil']."</td></tr>";
             
//         $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }
//      }
//     }


//               if (count($getEngin2)>0) {
//                # code...
//            foreach ($getEngin2 as $engin) {
//         if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil >="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }else{
//             $getPrime = $this->db->query('SELECT * FROM gazoil')->result_array();
//         }
//     // $getPrime = $this->db->query("SELECT * FROM gazoil where id_operation =".$id_operation."")->result_array();

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...
//         $getDestination = $this->db->query("SELECT * from distance_littrage where id_distance=".$row['id_distance']." limit 1")->row();
//         echo "<tr><td>".$compteur."</td>
             
//               <td> ".$row['code_camion']."</td>
//               <td>".$row['numero']."</td>
//               <td>".number_format($row['litrage'],0,',',' ')."</td>
//               <td>".number_format($row['prix_unitaire'],0,',',' ')."</td>";
//               if (count($getDestination)>0) {
//                   # code...
//                 echo "<td>".$getDestination->distance."</td>";
//               }else{
//                 echo "<td>Aucune</td>";
//               }
              
//                echo "<td>".number_format($row['prix_unitaire']*$row['litrage'],0,',',' ')."</td>
//               <td>".$row['date_gazoil']."</td></tr>";
             
//         $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }
//      }
//     }

//               if (count($getCamion)>0) {
//                # code...
//            foreach ($getCamion as $engin) {
//         if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil >="'.$date_debut.'"')->result_array();
//         }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_fin.'"')->result_array();

//         }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
//         }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
//             # code...
//             $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();

//         }else{
//             $getPrime = $this->db->query('SELECT * FROM gazoil')->result_array();
//         }
//     // $getPrime = $this->db->query("SELECT * FROM gazoil where id_operation =".$id_operation."")->result_array();

//     if (count($getPrime) >0 ) {
//       # code...
//       foreach ($getPrime as $row) {
//         # code...
//         $getDestination = $this->db->query("SELECT * from distance_littrage where id_distance=".$row['id_distance']." limit 1")->row();
//         echo "<tr><td>".$compteur."</td>
             
//               <td> ".$row['code_camion']."</td>
//               <td>".$row['numero']."</td>
//               <td>".number_format($row['litrage'],0,',',' ')."</td>
//               <td>".number_format($row['prix_unitaire'],0,',',' ')."</td>";
//               if (count($getDestination)>0) {
//                   # code...
//                 echo "<td>".$getDestination->distance."</td>";
//               }else{
//                 echo "<td>Aucune</td>";
//               }
              
//                echo "<td>".number_format($row['prix_unitaire']*$row['litrage'],0,',',' ')."</td>
//               <td>".$row['date_gazoil']."</td></tr>";
             
//         $compteur++;
//       }
//     }else{
//       // echo "nada";
//     }
//      }
//     }
//   }




 }