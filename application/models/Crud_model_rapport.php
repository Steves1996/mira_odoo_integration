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


    $getAllType = $this->db->query("SELECT * from type_vehicule where (nom_type like '%roue%' OR nom_type like '%calab%' OR nom_type like '%carro%' OR nom_type like '%ridelle%' ) ORDER BY nom_type")->result_array();


    foreach ($getAllType as $type) {

        # code...

        echo "<option value='".$type['id_type']."'>".$type['nom_type']."</option>";



    }


    $this->db->close();

}


 public function leSelectTypeVraquier(){

        $query = $this->db->query("SELECT * from type_vehicule where nom_type like '%vra%'")->result_array();

        if (count($query) >0) {

            # code...

            foreach ($query as $row) {

                # code...

                echo "<option value='".$row["id_type"]."'>".$row["nom_type"]."</option>";

            }

        }else{

        }

        $this->db->close();

    }




public function leSelectTypeVehicule2(){


    $getAllType = $this->db->query("SELECT * from type_vehicule where nom_type like '%calab%'")->result_array();


    foreach ($getAllType as $type) {



        # code...



        echo "<option value='".$type['id_type']."'>".$type['nom_type']."</option>";



    }



    $this->db->close();

}




public function leSelectTypeEngin(){

    $getAllType = $this->db->query("SELECT * from type_vehicule where nom_type like '%eng%'")->result_array();

    foreach ($getAllType as $type) {


        echo "<option value='".$type['id_type']."'>".$type['nom_type']."</option>";


    }

    $this->db->close();

}







public function leSelectTypeBenne(){


    $getAllType = $this->db->query("SELECT * from type_vehicule where nom_type like '%ben%'")->result_array();

    foreach ($getAllType as $type) {

        echo "<option value='".$type['id_type']."'>".$type['nom_type']."</option>";

    }

    $this->db->close();

}


public function leSelectTypeService(){

    $getAllType = $this->db->query("SELECT * from type_vehicule where nom_type like '%serv%'")->result_array();

    foreach ($getAllType as $type) {

        echo "<option value='".$type['id_type']."'>".$type['nom_type']."</option>";

    }

    $this->db->close();

}



public function selectAllLocationEnginOperationPourRapport(){

$id_type_vehicule = $_POST["id_type_vehicule"];

 $id_operation = $id_type_vehicule;

     $getEngin = $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule."")->result_array();

           if (count($getEngin)>0) {

           foreach ($getEngin as $engin) {


            
        $date_debut = $_POST["date_debut"];

        $date_fin = $_POST["date_fin"];

        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){

            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  code="'.$engin['code'].'"')->result_array();

        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){

            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location>="'.$date_debut.'"')->result_array();



        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){

            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){


            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){


            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin['code'].'"')->result_array();

        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){


            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location<="'.$date_fin.'" and code="'.$engin['code'].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){

            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location>="'.$date_debut.'" and code="'.$engin['code'].'"')->result_array();

        }


$compteur = 0;



    if (count($getPrime) >0 ) {


     foreach ($getPrime as $row) {

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


           foreach ($getEngin as $engin) {

             
              $date_debut = $_POST["date_debut"];

              $date_fin = $_POST["date_fin"];



        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){

            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  code="'.$engin['code'].'"')->result_array();

        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){

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


// pour rapport vraquier

public function selectAllLocationVraquierOperationPourRapport(){



           $id_type_vehicule = $_POST["id_type_vehicule"];



 $id_operation = $id_type_vehicule;



     $getEngin = $this->db->query("SELECT * from vraquier where id_type_camion=".$id_type_vehicule."")->result_array();



           if (count($getEngin)>0) {



               # code...



           foreach ($getEngin as $engin) {

        $date_debut = $_POST["date_debut"];

        $date_fin = $_POST["date_fin"];



        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){

         $getPrime = $this->db->query('SELECT * FROM location_vraquier WHERE  code="'.$engin['code'].'"')->result_array();



        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){

            $getPrime = $this->db->query('SELECT * FROM location_vraquier WHERE  date_location>="'.$date_debut.'"')->result_array();



        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM location_vraquier WHERE  date_location<="'.$date_fin.'"')->result_array();







        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM location_vraquier WHERE  date_location between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();



        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM location_vraquier WHERE  date_location between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin['code'].'"')->result_array();



        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM location_vraquier WHERE  date_location<="'.$date_fin.'" and code="'.$engin['code'].'"')->result_array();







        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM location_vraquier WHERE  date_location>="'.$date_debut.'" and code="'.$engin['code'].'"')->result_array();







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


  public function selectAllTotalLocationVraquierOperationPourRapport(){







              $id_type_vehicule = $_POST["id_type_vehicule"];



 $id_operation = $id_type_vehicule;



   $compteur = 0;



$montant10 = 0;



$montant9 = 0;



     $getEngin = $this->db->query("SELECT * from vraquier where id_type_camion=".$id_type_vehicule."")->result_array();



           if (count($getEngin)>0) {



               # code...



           foreach ($getEngin as $engin) {



               # code...







              $date_debut = $_POST["date_debut"];



        $date_fin = $_POST["date_fin"];



        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM location_vraquier WHERE  code="'.$engin['code'].'"')->result_array();



        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM location_vraquier WHERE  date_location>="'.$date_debut.'"')->result_array();



        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM location_vraquier WHERE  date_location<="'.$date_fin.'"')->result_array();







        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM location_vraquier WHERE  date_location between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();



        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM location_vraquier WHERE  date_location between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin['code'].'"')->result_array();



        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM location_vraquier WHERE  date_location<="'.$date_fin.'" and code="'.$engin['code'].'"')->result_array();







        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM location_vraquier WHERE  date_location>="'.$date_debut.'" and code="'.$engin['code'].'"')->result_array();







        }



    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();



 



    if (count($getPrime) >0 ) {



      # code...



      foreach ($getPrime as $row) {


        $getOperation = $this->db->query("SELECT * from operation where id_operation = ".$row['id_operation']." limit 1")->row();

         $montant10 = $row['montant']*$row['duree'];                  

         $montant9 = $montant9 + $montant10;

      }


    }else{


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

           foreach ($getTracteur as $tracteur) {


              $date_debut = $_POST["date_debut"];

        $date_fin = $_POST["date_fin"];



        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){

            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  code_camion="'.$tracteur['code'].'"')->result_array();

        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){

            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg>="'.$date_debut.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){

            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){

            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){

            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();

        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){

            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg<="'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){

            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg>="'.$date_debut.'" and code_camion="'.$tracteur['code'].'"')->result_array();

        }

    if (count($getPrime) >0 ) {

      foreach ($getPrime as $row) {

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



        // echo $id_type_vehicule;







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



     $getEngin2 = $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule."")->result_array();



 







     $getService= $this->db->query("SELECT * from voitureservice where id_type_camion=".$id_type_vehicule."")->result_array();


     $getVraquier= $this->db->query("SELECT * from vraquier where id_type_camion=".$id_type_vehicule."")->result_array();



      



       if (count($getEngin)>0) {



        $vehicule = $getEngin;



       }elseif (count($getEngin2)>0) {



         # code...



        $vehicule = $getEngin2;



       }elseif (count($getService)>0) {



         # code...



        $vehicule = $getService;



       }elseif (count($getVraquier)>0) {



         # code...



        $vehicule = $getVraquier;



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

     $getEngin2 = $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule."")->result_array();



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







   foreach ($getCamion as $engin) {



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







   foreach ($getCamion as $engin) {



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







   foreach ($getCamion as $engin) {



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

              <td>".$row['commentaire']."</td>

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







   foreach ($getCamion as $engin) {



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



           foreach ($getCamion as $engin) {



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



public function selectAllAccidentOperationPourRapport(){



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



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  code="'.$engin["code"].'"')->result_array();



        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc >="'.$date_debut.'"')->result_array();



        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc <="'.$date_fin.'"')->result_array();


        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();



        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin["code"].'"')->result_array();



        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc <="'.$date_fin.'" and code="'.$engin["code"].'"')->result_array();





        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc <="'.$date_debut.'" and code="'.$engin["code"].'"')->result_array();


        }else{



            $getPrime = $this->db->query('SELECT * FROM accident')->result_array();



        }



    // $getPrime = $this->db->query("SELECT * FROM piece_rechange where id_operation =".$id_operation."")->result_array();



$compteur = 0;



    if (count($getPrime) >0 ) {



      # code...



      foreach ($getPrime as $row) {



        # code...


        echo "<tr><td>".$compteur."</td>



              <td>".$row['code']."</td>


             <td>".$row['date_acc']."</td>
             
             
             
              <td>".$row['lieu']."</td>
              
              
              <td>".$row['date_ent']."</td>
              
              
              <td>".$row['date_sort']."</td>
              
              
              <td>".number_format($row['montant_dep'],0,',',' ')."</td>
              
              
              ";
             
             

              $getArticle = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->row();



              echo "<td>".$getArticle->article."</td>";



              echo "<td>".$getArticle->code_a_barre."</td>";



             echo" <td>".number_format($row['montant'],0,',',' ')."</td>



             <td>".$row['qtite']."</td>



             <td>".number_format($row['qtite']*$row['montant'],0,',',' ')."</td>



              </tr>
              
              ";



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



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  code="'.$engin["code"].'"')->result_array();



        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc >="'.$date_debut.'"')->result_array();



        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc <="'.$date_fin.'"')->result_array();







        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();



        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin["code"].'"')->result_array();



        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc <="'.$date_fin.'" and code="'.$engin["code"].'"')->result_array();







        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc <="'.$date_debut.'" and code="'.$engin["code"].'"')->result_array();







        }else{



            $getPrime = $this->db->query('SELECT * FROM accident')->result_array();



        }



    // $getPrime = $this->db->query("SELECT * FROM piece_rechange where id_operation =".$id_operation."")->result_array();



$compteur = 0;



    if (count($getPrime) >0 ) {



      # code...



      foreach ($getPrime as $row) {



        # code...


        echo "<tr><td>".$compteur."</td>



            <td>".$row['code']."</td>


             <td>".$row['date_acc']."</td>
             
             
             
              <td>".$row['lieu']."</td>
              
              
              <td>".$row['date_ent']."</td>
              
              
              <td>".$row['date_sort']."</td>
              
              
              <td>".number_format($row['montant_dep'],0,',',' ')."</td>
              
              
              ";
             
             

              $getArticle = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->row();



              echo "<td>".$getArticle->article."</td>";



              echo "<td>".$getArticle->code_a_barre."</td>";



             echo" <td>".number_format($row['montant'],0,',',' ')."</td>



             <td>".$row['qtite']."</td>



             <td>".number_format($row['qtite']*$row['montant'],0,',',' ')."</td>



              </tr>
              
              ";



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



               # code...



        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  code="'.$engin["code"].'"')->result_array();



        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc >="'.$date_debut.'"')->result_array();



        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc <="'.$date_fin.'"')->result_array();







;           }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();



        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin["code"].'"')->result_array();



        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc <="'.$date_fin.'" and code="'.$engin["code"].'"')->result_array();







        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc <="'.$date_debut.'" and code="'.$engin["code"].'"')->result_array();







        }else{



            $getPrime = $this->db->query('SELECT * FROM accident')->result_array();



        }



    // $getPrime = $this->db->query("SELECT * FROM piece_rechange where id_operation =".$id_operation."")->result_array();



    $compteur = 0;



    if (count($getPrime) >0 ) {



      # code...



      foreach ($getPrime as $row) {



        # code...



        echo "<tr><td>".$compteur."</td>



              <td>".$row['code']."</td>


             <td>".$row['date_acc']."</td>
             
             
             
              <td>".$row['lieu']."</td>
              
              
              <td>".$row['date_ent']."</td>
              
              
              <td>".$row['date_sort']."</td>
              
              
              <td>".number_format($row['montant_dep'],0,',',' ')."</td>
              
              
              ";
             
             

              $getArticle = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->row();



              echo "<td>".$getArticle->article."</td>";



              echo "<td>".$getArticle->code_a_barre."</td>";

      # code... 

             echo" <td>".number_format($row['montant'],0,',',' ')."</td>



             <td>".$row['qtite']."</td>



             <td>".number_format($row['qtite']*$row['montant'],0,',',' ')."</td>



              </tr>
              
              ";



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



            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech >="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();



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



            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech >="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();







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



           foreach ($getCamion as $engin) {



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



            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech >="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();







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







        $total1 = $total1+$montant1;



        



    $compteur++;     



      }



    }else{



      // echo "nada";



    }



  }



}







return $total1+$total;







$this->db->close();



  }


public function selectAllTotalAccidentOperationPourRapport(){



          $id_type_vehicule = $_POST["id_type_vehicule"];



          $id_operation = $id_type_vehicule;



        $compteur = 0;



       $montant1 =0;



       $total1 = 0;



       $montant =0;



       $total = 0;



      $depense = 0;



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



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  code="'.$engin["code"].'"')->result_array();
            
            
            $getMontDep = $this->db->query('SELECT SUM(montant_dep) AS DEPENSE FROM accident WHERE  code="'.$engin["code"].'"')->result_array();



        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc >="'.$date_debut.'"')->result_array();
            
             $getMontDep = $this->db->query('SELECT SUM(montant_dep) AS DEPENSE FROM accident WHERE  date_acc >="'.$date_debut.'"')->result_array();



        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc <="'.$date_fin.'"')->result_array();


            $getMontDep = $this->db->query('SELECT SUM(montant_dep) AS DEPENSE FROM accident WHERE  date_acc <="'.$date_fin.'"')->result_array();




        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();

            $getMontDep = $this->db->query('SELECT SUM(montant_dep) AS DEPENSE FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
 

        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin["code"].'"')->result_array();


            $getMontDep = $this->db->query('SELECT SUM(montant_dep) AS DEPENSE FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin["code"].'"')->result_array();


        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc <="'.$date_fin.'" and code="'.$engin["code"].'"')->result_array();
            
            $getMontDep = $this->db->query('SELECT SUM(montant_dep) AS DEPENSE FROM accident WHERE  date_acc <="'.$date_fin.'" and code="'.$engin["code"].'"')->result_array();




        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc >="'.$date_debut.'" and code="'.$engin["code"].'"')->result_array();

           $getMontDep = $this->db->query('SELECT SUM(montant_dep) AS DEPENSE FROM accident WHERE  date_acc >="'.$date_debut.'" and code="'.$engin["code"].'"')->result_array();


        }else{



            $getPrime = $this->db->query('SELECT * FROM accident')->result_array();

           $getMontDep = $this->db->query('SELECT SUM(montant_dep) AS DEPENSE FROM accident')->result_array();



        }



    // $getPrime = $this->db->query("SELECT * FROM piece_rechange where id_operation =".$id_operation."")->result_array();

    


     if (count($getPrime) >0 ) {



$montant_dep = 0;

if (count($getMontDep) >0 ) {
    
    foreach ($getMontDep as $row) {
    
    $montant_dep = $montant_dep + $row["DEPENSE"];
    
}
    
    
}


      # code...



      foreach ($getPrime as $row) {



        # code...



        $getPrixUnitaire = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->result_array();







        foreach ($getPrixUnitaire as $tab) {



          # code...



          $montant = $tab["prix_unitaire"] * $row["qtite"];



        }







        $total = $total+$montant;



        



        $compteur++;



      }
      
     $total = $total +$montant_dep;



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



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  code="'.$engin["code"].'"')->result_array();
            
            
            $getMontDep = $this->db->query('SELECT SUM(montant_dep) AS DEPENSE FROM accident WHERE  code="'.$engin["code"].'"')->result_array();



        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc >="'.$date_debut.'"')->result_array();
            
             $getMontDep = $this->db->query('SELECT SUM(montant_dep) AS DEPENSE FROM accident WHERE  date_acc >="'.$date_debut.'"')->result_array();



        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc <="'.$date_fin.'"')->result_array();


            $getMontDep = $this->db->query('SELECT SUM(montant_dep) AS DEPENSE FROM accident WHERE  date_acc <="'.$date_fin.'"')->result_array();




        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();

            $getMontDep = $this->db->query('SELECT SUM(montant_dep) AS DEPENSE FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
 

        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin["code"].'"')->result_array();


            $getMontDep = $this->db->query('SELECT SUM(montant_dep) AS DEPENSE FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin["code"].'"')->result_array();


        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc <="'.$date_fin.'" and code="'.$engin["code"].'"')->result_array();
            
            $getMontDep = $this->db->query('SELECT SUM(montant_dep) AS DEPENSE FROM accident WHERE  date_acc <="'.$date_fin.'" and code="'.$engin["code"].'"')->result_array();




        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc >="'.$date_debut.'" and code="'.$engin["code"].'"')->result_array();

           $getMontDep = $this->db->query('SELECT SUM(montant_dep) AS DEPENSE FROM accident WHERE  date_acc >="'.$date_debut.'" and code="'.$engin["code"].'"')->result_array();


        }else{



            $getPrime = $this->db->query('SELECT * FROM accident')->result_array();

           $getMontDep = $this->db->query('SELECT SUM(montant_dep) AS DEPENSE FROM accident')->result_array();



        }



    // $getPrime = $this->db->query("SELECT * FROM piece_rechange where id_operation =".$id_operation."")->result_array();



     if (count($getPrime) >0 ) {


$montant_dep = 0;

if (count($getMontDep) >0 ) {
    
    foreach ($getMontDep as $row) {
    
    $montant_dep = $montant_dep + $row["DEPENSE"];
    
}
    
    
}



      # code...



      foreach ($getPrime as $row) {



        # code...



        $getPrixUnitaire = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->result_array();







        foreach ($getPrixUnitaire as $tab) {



          # code...



          $montant = $tab["prix_unitaire"]* $row["qtite"];



        }







        $total = $total+$montant ;



        



        $compteur++;



      }
      
    $total = $total +$montant_dep;


    }else{



      // echo "nada";



    }



  }



}







$this->db->close();







    if (count($getCamion)>0) {



               # code...



           foreach ($getCamion as $engin) {



               # code...



        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){



            # code...



            
            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  code="'.$engin["code"].'"')->result_array();
            
            
            $getMontDep = $this->db->query('SELECT SUM(montant_dep) AS DEPENSE FROM accident WHERE  code="'.$engin["code"].'"')->result_array();



        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc >="'.$date_debut.'"')->result_array();
            
             $getMontDep = $this->db->query('SELECT SUM(montant_dep) AS DEPENSE FROM accident WHERE  date_acc >="'.$date_debut.'"')->result_array();



        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc <="'.$date_fin.'"')->result_array();


            $getMontDep = $this->db->query('SELECT SUM(montant_dep) AS DEPENSE FROM accident WHERE  date_acc <="'.$date_fin.'"')->result_array();




        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();

            $getMontDep = $this->db->query('SELECT SUM(montant_dep) AS DEPENSE FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
 

        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin["code"].'"')->result_array();


            $getMontDep = $this->db->query('SELECT SUM(montant_dep) AS DEPENSE FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin["code"].'"')->result_array();


        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc <="'.$date_fin.'" and code="'.$engin["code"].'"')->result_array();
            
            $getMontDep = $this->db->query('SELECT SUM(montant_dep) AS DEPENSE FROM accident WHERE  date_acc <="'.$date_fin.'" and code="'.$engin["code"].'"')->result_array();




        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc >="'.$date_debut.'" and code="'.$engin["code"].'"')->result_array();

           $getMontDep = $this->db->query('SELECT SUM(montant_dep) AS DEPENSE FROM accident WHERE  date_acc >="'.$date_debut.'" and code="'.$engin["code"].'"')->result_array();


        }else{



            $getPrime = $this->db->query('SELECT * FROM accident')->result_array();

           $getMontDep = $this->db->query('SELECT SUM(montant_dep) AS DEPENSE FROM accident')->result_array();



        }



    // $getPrime = $this->db->query("SELECT * FROM piece_rechange where id_operation =".$id_operation."")->result_array();




     if (count($getPrime) >0 ) {



$montant_dep = 0;

if (count($getMontDep) >0 ) {
    
    foreach ($getMontDep as $row) {
    
    $montant_dep = $montant_dep + $row["DEPENSE"];
    
}
    
    
}

      # code...



      foreach ($getPrime as $row) {



        # code...



        $getPrixUnitaire = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->result_array();







        foreach ($getPrixUnitaire as $tab) {



          # code...



          $montant = $tab["prix_unitaire"]* $row["qtite"];



        }







        $total1 = $total1+$montant ;



        $compteur++;


      }
      




       $total1 = $total1+$montant_dep;



    }else{



      // echo "nada";



    }



  }



}



return $total+$total1;







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


    $compteur = 0;



    $montant1 = 0;







    if (count($getPrime) >0 ) {



      # code...



      foreach ($getPrime as $row) {



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


    if (count($getPrime) >0 ) {



      # code...



      foreach ($getPrime as $row) {




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


    if (count($getPrime) >0 ) {



      # code...



      foreach ($getPrime as $row) {



        $montant1 =  $row["qtite"] * $row['pu'];



          $total1 = $total1 + $montant1; 



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



    $compteur = 0;



    $montant1 = 0;


    if (count($getPrime) >0 ) {



      # code...



      foreach ($getPrime as $row) {



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



    if (count($getPrime) >0 ) {



      # code...



      foreach ($getPrime as $row) {



    



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







            $total = $montant + $total;



   



      }



    }else{



      // echo "nada";



    }



     }



    }



    return $total+ $total1;







    $this->db->close();



  }



// vente des pieces

      public function selectAllVentePiecesOperationPourBalance(){

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

        $getEngin = $getEngin;

       }elseif (count($getEngin2)>0) {


       $getEngin = $getEngin2;

       }elseif (count($getService)>0) {

        $getEngin = $getService;



       }elseif (count($getCamion)>0) {

        $getEngin = $getCamion;

       }

           if (count($getEngin)>0) {

           foreach ($getEngin as $engin) {

        $date_debut = $_POST["date_debut"];

        $date_fin = $_POST["date_fin"];

        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){

            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){

            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece >="'.$date_debut.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){

            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){

            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){


            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){

            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece<="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece>="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();







        }



    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();







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



                    <td> ";



                    if (count($getClient)>0) {



                      # code...



                      echo $getClient->nom;



                    }



                    



                    echo"</td>



                    <td>".$row['libelle']."</td>



                    



                    </tr>";



          $compteur++;



      }



    }else{



      // echo "nada";



    }



}}



    $this->db->close();



    }



    



    public function selectAllTotalVentePiecesOperationPourBalance(){



                  $id_type_vehicule = $_POST["id_type_vehicule"];



           $id_operation = $id_type_vehicule;



           $compteur = 0;



           $compteur = 0;



$montant10 = 0;



$total10 = 0;



     $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule."")->result_array();



     $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."")->result_array();







     $getEngin2 = $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule."")->result_array();



     



        $date_debut = $_POST["date_debut"];



        $date_fin = $_POST["date_fin"];







    $getService= $this->db->query("SELECT * from voitureservice where id_type_camion=".$id_type_vehicule."")->result_array();



      



       if (count($getEngin)>0) {



        $getEngin = $getEngin;



       }elseif (count($getEngin2)>0) {



         # code...



       $getEngin = $getEngin2;



       }elseif (count($getService)>0) {



         # code...



        $getEngin = $getService;



       }elseif (count($getCamion)>0) {



         # code...



        $getEngin = $getCamion;



       }



            if (count($getEngin)>0) {



               # code...



           foreach ($getEngin as $engin) {



               # code...







              $date_debut = $_POST["date_debut"];



        $date_fin = $_POST["date_fin"];



        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  code_camion="'.$engin["code"].'"')->result_array();



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



            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();



        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece<="'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();







        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){



            # code...



            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece>="'.$date_debut.'" and code_camion="'.$engin["code"].'"')->result_array();







        }



    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();







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



   }



 }



    return $total10;







    $this->db->close();



    }











public function getAllRetenueSalaireChauffeur($id_chauffeur,$date_debut,$date_fin){



        $query = $this->db->query("SELECT retenueSalariale,retenueSalarialeass from chauffeur WHERE id_chauffeur='.$id_chauffeur.'")->result_array();







        if (count($query>0)) {



            # code...



            $montant = 0;



            foreach ($query as $row) {



                # code...



                $montant = $montant + $row['retenueSalariale']+ $row['retenueSalarialeass'];



            }







            return $montant;



        }



    }







public function getAllReglementImputationSalaireChauffeur($id_chauffeur,$date_debut,$date_fin){



        $query = $this->db->query('SELECT montant from reglement_imputation WHERE id_chauffeur='.$id_chauffeur.' and date_imputation between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();

        if (count($query>0)) {


            $montant = 0;



            foreach ($query as $row) {

                $montant = $montant + $row['montant'];

            }

            return $montant;

        }

    }


public function getAllRegulationImputationSalaireChauffeur($id_chauffeur,$date_debut,$date_fin){



        $query = $this->db->query('SELECT regulation from reglement_imputation WHERE  date_imputation between "'.$date_debut.'" and "'.$date_fin.'" and id_chauffeur='.$id_chauffeur.'')->result_array();


        if (count($query>0)) {

            $montant = 0;



            foreach ($query as $row) {



                # code...



                $montant = $montant + $row['regulation'];



            }

            return $montant;



        }



    }



// rappoort cumulé mensuel







public function getGSPParNbreMois($gps,$date_debut,$date_fin){

  

  $mois1 = date_create($date_debut)->format('m');

  

  $mois2 = date_create($date_fin)->format('m');



  if ($mois2 < $mois1) {

    # code...



     $mois2 = $mois2+12;



     $mois = $mois2-$mois1+1;

     $gps1 = $gps;



     for ($i=0; $i < $mois; $i++) { 

       # code...

        $gps1 = $gps1 + $gps;

     }



     return $gps1;



  }elseif ($mois2 > $mois1) {

    # code...

    $gps1 = $gps;

    $mois = $mois2-$mois1;



     for ($i=0; $i < $mois; $i++) { 

       # code...

        $gps1 = $gps1 + $gps;

     }



     return $gps1;



  }else{



      return $gps;

  }

  

}







    public function rapportCumuleMensuel(){




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

              $totalAccident = 0;
			  
			  $totalCommission = 0;

				$totalDepannage = 0;

				$totalPrevision = 0;

               $totalChargement = 0;



              $totalLocation = 0;



              $totalBL = 0;



              $totaldiff = 0;



              $totalVente2 = 0;



              $totalQtiteGasoil=0;



              



              $totalkm_th =0;



     $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule." order by code asc")->result_array();



     $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule."  order by code asc")->result_array();



     $getEngin2 = $this->db->query("SELECT * from engin where id_type_camion=".$id_type_vehicule."  order by code asc")->result_array();



 



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





$gps = $engin['gps'];

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

       $montantAccident= 0;
	   
	   
	 
	   
// Vidange

            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();


              if (count($getPrime) >0 ) {



                # code...



                foreach ($getPrime as $row) {




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



      



        $montant1 =  $row["qtite"] * $row['pu'];



          $total1 = $total1 + $montant1;



      }




    }else{



      // echo "nada";



    }





$this->db->close();







$totalVidange = $total1;



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



    //         $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

       $getPrime = $this->db->query("SELECT * FROM sortie WHERE  date_sortie between '".$date_debut."' and '".$date_fin."' and `type_sortie` = 'Frais Divers' and vehicule='".$engin["code"]."'")->result_array();


       



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




              $date_debut = $_POST["date_debut"];



        $date_fin = $_POST["date_fin"];


  //         $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

        
 $getPrime = $this->db->query("SELECT * FROM sortie WHERE  date_sortie between '".$date_debut."' and '".$date_fin."' and `type_sortie` = 'Frais Route' and vehicule='".$engin["code"]."'")->result_array();


    if (count($getPrime) >0 ) {



      # code...



      foreach ($getPrime as $row) {


    $total = $total + $row['montant'];



      }



    }else{



      // echo "nada";



    }



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



              $date_debut = $_POST["date_debut"];



        $date_fin = $_POST["date_fin"];



        



            $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();




        foreach ($getPrime as $row) {



                 $montant = $row['qtite']*$row['prix_unitaire'];

                 $total = $total + $montant;                 



        }


        $this->db->close();



   $depensePneu = $total;





              $date_debut = $_POST["date_debut"];



        $date_fin = $_POST["date_fin"];



            $getPrime = $this->db->query('SELECT * FROM chauffeur where id_chauffeur ='.$engin["id_chauffeur"].'')->result_array();



        foreach ($getPrime as $row) {

                 $montant = $row['salaire_ass']+$row['salaire'];




        }




$gps = $this->getGSPParNbreMois($gps,$date_debut,$date_fin);



// la ligne qui suis est le net à payer qu'on a copié sur la partie paie employé







$np = $montant-$this->getAllRetenueSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)-$this->getAllReglementImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)+$this->getAllRegulationImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin);







$getValidePourSalaire = $this->db->query("SELECT * from paiechauffeur where id_chauffeur=".$row['id_chauffeur']."")->row();



if (count($getValidePourSalaire)>0) {



  if ($getValidePourSalaire->salaire == 1) {



    $salaireChauffueurAss = $gps;



  }elseif ($getValidePourSalaire->salaire_gps == 1) {


    $salaireChauffueurAss =0;



  }elseif ($getValidePourSalaire->gps == 1) {



    $salaireChauffueurAss =$np;



  }else{



    $salaireChauffueurAss = $np + $gps;



  }



}else{



  $salaireChauffueurAss = $np + $gps;



}



     $montant1=0;



     $montant=0;



     $compteur = 0;



    $total1 = 0;



    $montant1=0;







    $montant2=0;



    $montantVente = 0;


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






$this->db->close();



    $totalVente=0;


    $montant2=0;

    $montantVente = 0;


 $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();



$nbreVoyage=0;



    if (count($getPrime) >0 ) {


      foreach ($getPrime as $row) {


        $totalVente = $row['montant'];



        $montantVente = $totalVente+ $montantVente;


      }



      $nbreVidange = $nbreVoyage;


    }else{


    }


    $vente_pieces = $montantVente;



$this->db->close();




            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();

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



$chargement_retour = $montant;



       $date_debut = $_POST["date_debut"];



        $date_fin = $_POST["date_fin"];
		
		
		
		$getPrime22 = $this->db->query("SELECT montant FROM sortie WHERE  date_sortie between '".$date_debut."' and '".$date_fin."' and `type_sortie` = 'Prime' and vehicule='".$engin["code"]."'")->result_array();



         //   $getPrime22 = $this->db->query('SELECT montant FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();


    if (count($getPrime22) >0 ) {



      # code...



      $prime3 = 0;



      foreach ($getPrime22 as $row3) {



        $prime3 = $row3['montant'] +$prime3;



        // $prime= $prime1+ $montant1;

        
        $nbreVoyage = $nbreVoyage+1; 
 

      }



    }else{



      // echo "nada";



      $prime3 = 0;



    }



$this->db->close();



   $totalComm=0;


    $montantCom=0;

    $montantComm = 0;


	
		$getPrime = $this->db->query("SELECT montant FROM sortie WHERE  date_sortie between '".$date_debut."' and '".$date_fin."' and `type_sortie` = 'Commission' and vehicule='".$engin["code"]."'")->result_array();


// $getPrime = $this->db->query('SELECT * FROM commission WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();



    if (count($getPrime) >0 ) {


      foreach ($getPrime as $row) {


        $totalComm = $row['montant'];



        $montantComm = $totalComm + $montantComm;


      }


    }else{


    }


    $vente_Comm = $montantComm;



$this->db->close();

$totalDep=0;


    $montantDep=0;

    $montantDep = 0;


	
		$getPrime = $this->db->query("SELECT montant FROM sortie WHERE  date_sortie between '".$date_debut."' and '".$date_fin."' and `type_sortie` = 'Depannage' and vehicule='".$engin["code"]."'")->result_array();


// $getPrime = $this->db->query('SELECT * FROM commission WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();



    if (count($getPrime) >0 ) {


      foreach ($getPrime as $row) {


        $totalDep = $row['montant'];



        $montantDep = $totalDep + $montantDep;


      }


    }else{


    }


    $vente_Dep = $montantDep;



$this->db->close();


 $totalPrev=0;


    $montantPrev=0;

    $montantPrev = 0;


	
		$getPrime = $this->db->query("SELECT montant FROM sortie WHERE  date_sortie between '".$date_debut."' and '".$date_fin."' and `type_sortie` = 'Prevision Navire' and vehicule='".$engin["code"]."'")->result_array();


// $getPrime = $this->db->query('SELECT * FROM commission WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();



    if (count($getPrime) >0 ) {


      foreach ($getPrime as $row) {


        $totalPrev = $row['montant'];



        $montantPrev = $totalPrev + $montantPrev;


      }


    }else{


    }


    $vente_Prev = $montantPrev;



$this->db->close();






              $date_debut = $_POST["date_debut"];



        $date_fin = $_POST["date_fin"];







        $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin['code'].'"')->result_array();



 
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


$chiffreAff = $montant9 + $montant+$montant2;



  $this->db->close();



              $date_debut = $_POST["date_debut"];



        $date_fin = $_POST["date_fin"];


            $getPrime = $this->db->query('SELECT * FROM distance_parcourue where date_distance between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();


        foreach ($getPrime as $row) {


              $montant = $row['kilometrage_fin']-$row['kilometrage_debut'];


                 $total = $montant;                 



        }

    $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin['code'].'"')->result_array();

    if (count($getPrime)>0) {
      # code...
      $i=0;
      foreach ($getPrime as $acc) {
        # code...

        if ($i ==0) {
          # code...
          $montant = $acc['montant_dep'];
        }
                $i++;

        $montantAccident1 = $acc['qtite']*$acc['montant'];

        $montantAccident = $montantAccident + $montantAccident1;
      }

      $montantAccident = $montantAccident + $montant;
    }

  
       $distance_parcourue = $total;



            if ($nbreVidange >0 || $fraisDIvers >0 || $fraisRoute >0 || $gazoil >0 || $pieceRechange >0 || $depensePneu >0 || $totalVidange>0 || $salaireChauffueurAss >0 || $chiffreAff >0 || $distance_parcourue >0) {




              $benefice = $bon_livraison+$chargement_retour+$vente_pieces+$location_engin-$prime3- $salaireChauffueurAss-$totalVidange-$depensePneu-$pieceRechange-$gazoil-$fraisRoute-$fraisDIvers-$montantAccident-$vente_Comm;



              $totalNbreVidange =$nbreVidange +  $totalNbreVidange ;



              $totalVidanges = $totalVidanges+$totalVidange;
			  
			  
			  $totalCommission = $totalCommission + $vente_Comm;
			  
			  
			  $totalDepannage = $totalDepannage + $vente_Dep;
			  
			  $totalPrevision = $totalPrevision + $vente_Prev;



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

              $totalAccident = $totalAccident + $montantAccident;

              $totaldiff = $totaldiff + $diff;



              $total_km_litrage = $total_km_litrage + $km_litrage;



              $totalVente2 = $totalVente2+$vente_pieces;


	     $getRemorque = $this->db->query("SELECT immatriculation FROM remorque where id_remorque = ".$engin['id_remorque']."")->row();

	   if (count($getRemorque) >0 ) {
		   
		   $getRemorque1 = $getRemorque->immatriculation;
	

                } else {
	   
    $getRemorque1 ="";
}

              echo "<tr style='text-align: center;'>



              <td style='size: 13px; border: 1px solid black;'>".$engin['code']."</td>
			  
			  
         <td style='size: 13px; border: 1px solid black;'>".$getRemorque1."</td>


              <td style='size: 13px; border: 1px solid black;'>".$nbreVidange."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($fraisDIvers,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($fraisRoute,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".$qtiteGasoil."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($gazoil,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($pieceRechange,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($depensePneu,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($totalVidange,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($salaireChauffueurAss,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($prime3,0,',',' ')."</td>
			  
			  <td style='size: 13px; border: 1px solid black;'>".number_format($vente_Comm,0,',',' ')."</td>
			  
			  <td style='size: 13px; border: 1px solid black;'>".number_format($vente_Dep,0,',',' ')."</td>
			  
			  <td style='size: 13px; border: 1px solid black;'>".number_format($vente_Prev,0,',',' ')."</td>

              <td style='size: 13px; border: 1px solid black;'>".number_format($montantAccident,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($bon_livraison,0,'.',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($chargement_retour,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($vente_pieces,0,',',' ')."</td>


              <td style='size: 13px; border: 1px solid black;'>".number_format($distance_parcourue,2,'.',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($km_th,2,'.',' ')."</td>";



              if ($diff<0) {



                # code



                echo"<td style='size: 13px; border: 1px solid black; color:red;'>".number_format($diff,2,'.',' ')."</td>"; 



              }else{



                echo"<td style='size: 13px; border: 1px solid black;'>".number_format($diff,2,'.',' ')."</td>";



              }



              



              if ($benefice<0) {



                # code...



                echo "<td style ='color: red; size: 13px; border: 1px solid black;'>".number_format($benefice,0,',',' ')."</td>







                </tr>";



              }else{



                echo "<td style='size: 13px; border: 1px solid black;'>".number_format($benefice,0,',',' ')."</td>







                </tr>";



              }



              



             }







    }







   







  }



   echo "<tr style='text-align: center;'>



              <td style ='color: red; size: 13px; border: 2px solid black;'> TOTAUX</td>

<td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'></td>

              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".$totalNbreVidange."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalFraisDivers,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalFraisRoute,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".$totalQtiteGasoil."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalGazoil,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalPieceRenchange,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalDepensePneu,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalVidanges,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalSalaire,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalPrime,0,',',' ')."</td>
			  
			  
			   <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalCommission,0,',',' ')."</td>
			   
			    <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalDepannage,0,',',' ')."</td>
				
				 <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalPrevision,0,',',' ')."</td>

              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalAccident,0,',',' ')."</td>



               <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalBL,0,'.',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalChargement,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalVente2,0,',',' ')."</td>



            



         



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalDistance,2,'.',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalkm_th,2,'.',' ')."</td>";



              if ($totaldiff < 0) {



                # code...



                echo"<td style ='color: red; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totaldiff,2,'.',' ')."</td>";



              }else{



               echo " <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totaldiff,2,'.',' ')."</td>";



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







// rapport cumulé mensuel par type de véhicule c'est à dire le type ancien ou nouveau







 public function rapportCumuleMensuelEN(){







// nous allons procéder aux vidanges



$prime3=0;



              $id_type_vehicule = $_POST["id_type_vehicule"];



              $type = $_POST["etat"];







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



              $totalVente2 = 0;

              $totalAccident =

              $totalQtiteGasoil=0;



              



              $totalkm_th =0;



     $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule." and  type='".$type."' order by code asc")->result_array();



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



        $vehicule = [];



       }











        $date_debut = $_POST["date_debut"];



        $date_fin = $_POST["date_fin"];







  if (count($vehicule)>0) {



               # code...



           foreach ($vehicule as $engin) {





$gps = $engin['gps'];



$nbreVidange=0;



   $compteur = 0;



$montant10 = 0;

$montantAccident = 0;



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


             $date_debut = $_POST["date_debut"];



        $date_fin = $_POST["date_fin"];



            $getPrime = $this->db->query('SELECT * FROM chauffeur where id_chauffeur ='.$engin["id_chauffeur"].'')->result_array();



        foreach ($getPrime as $row) {


                 $montant = $row['salaire_ass']+$row['salaire'];


        }



// $gps = 21465;



$gps = $this->getGSPParNbreMois($gps,$date_debut,$date_fin);



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


$this->db->close();


    $totalVente=0;


    $montant2=0;



    $montantVente = 0;







 $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();



       



$nbreVoyage=0;



    if (count($getPrime) >0 ) {



      # code...



      foreach ($getPrime as $row) {







        $totalVente = $row['montant'];



        $montantVente = $totalVente+ $montantVente;



        $nbreVoyage = $nbreVoyage+1; 



      }



      $nbreVidange = $nbreVoyage;







    }else{



      // echo "nada";



    }







    $vente_pieces = $montantVente;



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

$chiffreAff = $montant9 + $montant+$montant2;

  $this->db->close();

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

            $getPrime = $this->db->query('SELECT * FROM distance_parcourue where date_distance between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();

        foreach ($getPrime as $row) {


                 $montant = $row['kilometrage_fin']-$row['kilometrage_debut'];


                 $total = $montant;
        }


    $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin['code'].'"')->result_array();

    if (count($getPrime)>0) {
      # code...
      $i=0;
      foreach ($getPrime as $acc) {
        # code...

        if ($i ==0) {
          # code...
          $montant = $acc['montant_dep'];
        }
                $i++;

        $montantAccident1 = $acc['qtite']*$acc['montant'];

        $montantAccident = $montantAccident + $montantAccident1;
      }

      $montantAccident = $montantAccident + $montant;
    }
    



       // }



       $distance_parcourue = $total;







            if ($nbreVidange >0 || $fraisDIvers >0 || $fraisRoute >0 || $gazoil >0 || $pieceRechange >0 || $depensePneu >0 || $totalVidange>0 || $salaireChauffueurAss >0 || $chiffreAff >0 || $distance_parcourue >0) {



              # code...







              // $benefice = $bon_livraison+$chargement_retour+$location_engin-$chiffreAff-$prime- $salaireChauffueurAss-$totalVidange-$depensePneu-$pieceRechange-$gazoil-$fraisRoute-$fraisDIvers;







              $benefice = $bon_livraison+$chargement_retour+$location_engin-$prime3- $salaireChauffueurAss-$totalVidange-$depensePneu-$pieceRechange-$gazoil-$fraisRoute-$fraisDIvers-$montantAccident;



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



              $totalVente2= $totalVente2 + $vente_pieces;


              $totalAccident = $totalAccident + $montantAccident;






              echo "<tr style='text-align: center;'>



              <td style='size: 13px; border: 1px solid black;'>".$engin['code']."</td>
			  
			  
			  



              <td style='size: 13px; border: 1px solid black;'>".$nbreVidange."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($fraisDIvers,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($fraisRoute,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".$qtiteGasoil."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($gazoil,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($pieceRechange,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($depensePneu,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($totalVidange,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($salaireChauffueurAss,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($prime3,0,',',' ')."</td>

              <td style='size: 13px; border: 1px solid black;'>".number_format($montantAccident,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($bon_livraison,0,'.',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($chargement_retour,0,',',' ')."</td>



              



              <td style='size: 13px; border: 1px solid black;'>".number_format($vente_pieces,0,',',' ')."</td>



   



              <td style='size: 13px; border: 1px solid black;'>".number_format($distance_parcourue,2,'.',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($km_th,2,'.',' ')."</td>";



              if ($diff<0) {



                # code



                echo"<td style='size: 13px; border: 1px solid black; color:red;'>".number_format($diff,2,'.',' ')."</td>"; 



              }else{



                echo"<td style='size: 13px; border: 1px solid black;'>".number_format($diff,2,'.',' ')."</td>";



              }



              



              if ($benefice<0) {



                # code...



                echo "<td style ='color: red; size: 13px; border: 1px solid black;'>".number_format($benefice,0,',',' ')."</td>







                </tr>";



              }else{



                echo "<td style='size: 13px; border: 1px solid black;'>".number_format($benefice,0,',',' ')."</td>







                </tr>";



              }



              



             }







    }







   







  }



   echo "<tr style='text-align: center;'>



              <td style ='color: red;  border: 2px solid black;'> TOTAUX</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".$totalNbreVidange."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalFraisDivers,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalFraisRoute,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".$totalQtiteGasoil."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalGazoil,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalPieceRenchange,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalDepensePneu,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalVidanges,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalSalaire,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalPrime,0,',',' ')."</td>


              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalAccident,0,',',' ')."</td>



               <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalBL,0,'.',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalChargement,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalVente2,0,',',' ')."</td>



            



         



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalDistance,2,'.',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalkm_th,2,'.',' ')."</td>";



              if ($totaldiff < 0) {



                # code...



                echo"<td style ='color: red; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totaldiff,2,'.',' ')."</td>";



              }else{



               echo " <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totaldiff,2,'.',' ')."</td>";



              }



              



              if ($totalBenefice<0) {



                # code...



                echo "<td style ='color: red; size: 13px; border: 2px solid black;'>".number_format($totalBenefice,3,'.',' ')."</td>







                </tr>";



              }else{



                echo "<td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalBenefice,3,'.',' ')."</td>







                </tr>";



              }



              $this->db->close();



}







// rapport cumule des taracteurs et calabreses reunis 







 public function rapportCumuleAN(){







// nous allons procéder aux vidanges



$prime3=0;

$type = $_POST["etat"];



$id_type_vehicule='';



 $id_operation = $id_type_vehicule;



 $totalNbreVidange =0;



              $totalVidanges =0;



              $totalFraisDivers =0;



              $totalFraisRoute =0;



              $totalGazoil =0;



              $totalPieceRenchange =0;
              
              
              
              $totalaccident =0;


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


              $totalAccident = 0;



              $totalVente2 = 0;



              $totalQtiteGasoil=0;



              $totalkm_th =0;



     $getEngin = $this->db->query("SELECT * from tracteur where   type='".$type."' and id_type_camion!=8 order by code asc")->result_array();



     $getCamion = [];







     $getEngin2 = [];



 



 if (count($getEngin)>0) {



        $vehicule = $getEngin;



       }elseif (count($getEngin2)>0) {



         # code...



        $vehicule = $getEngin2;



       }elseif (count($getCamion)>0) {



         # code...



        $vehicule = $getCamion;



       }else{



        $vehicule = [];



       }











        $date_debut = $_POST["date_debut"];



        $date_fin = $_POST["date_fin"];







  if (count($vehicule)>0) {



               # code...



           foreach ($vehicule as $engin) {





$gps = $engin['gps'];



$nbreVidange=0;



   $compteur = 0;



$montant10 = 0;

$montantAccident = 0;

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







      // $id_type_vehicule = $_POST["id_type_vehicule"];



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











    // $id_type_vehicule = $_POST["id_type_vehicule"];



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











           // $id_type_vehicule = $_POST["id_type_vehicule"];



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



// $gps = 21465;



$gps = $this->getGSPParNbreMois($gps,$date_debut,$date_fin);



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











    $totalVente=0;







    $montant2=0;



    $montantVente = 0;







 $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();



       



$nbreVoyage=0;



    if (count($getPrime) >0 ) {



      # code...



      foreach ($getPrime as $row) {







        $totalVente = $row['montant'];



        $montantVente = $totalVente+ $montantVente;



        $nbreVoyage = $nbreVoyage+1; 



      }



      $nbreVidange = $nbreVoyage;







    }else{



      // echo "nada";



    }







    $vente_pieces = $montantVente;



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



       $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin['code'].'"')->result_array();

    if (count($getPrime)>0) {
      # code...
      $i=0;
      foreach ($getPrime as $acc) {
        # code...

        if ($i ==0) {
          # code...
          $montant = $acc['montant_dep'];
        }
                $i++;

        $montantAccident1 = $acc['qtite']*$acc['montant'];

        $montantAccident = $montantAccident + $montantAccident1;
      }

      $montantAccident = $montantAccident + $montant;
    }



       // }



       $distance_parcourue = $total;







            if ($nbreVidange >0 || $fraisDIvers >0 || $fraisRoute >0 || $gazoil >0 || $pieceRechange >0 || $depensePneu >0 || $totalVidange>0 || $salaireChauffueurAss >0 || $chiffreAff >0 || $distance_parcourue >0) {



              # code...







              // $benefice = $bon_livraison+$chargement_retour+$location_engin-$chiffreAff-$prime- $salaireChauffueurAss-$totalVidange-$depensePneu-$pieceRechange-$gazoil-$fraisRoute-$fraisDIvers;







              $benefice = $bon_livraison+$chargement_retour+$location_engin+$vente_pieces-$prime3- $salaireChauffueurAss-$totalVidange-$depensePneu-$pieceRechange-$gazoil-$fraisRoute-$fraisDIvers-$montantAccident;



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

              $totalAccident = $totalAccident + $montantAccident;

              $totaldiff = $totaldiff + $diff;



              $total_km_litrage = $total_km_litrage + $km_litrage;



              $totalVente2= $totalVente2 + $vente_pieces;







              echo "<tr style='text-align: center;'>



              <td style='size: 13px; border: 1px solid black;'>".$engin['code']."</td>



              <td style='size: 13px; border: 1px solid black;'>".$nbreVidange."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($fraisDIvers,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($fraisRoute,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".$qtiteGasoil."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($gazoil,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($pieceRechange,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($depensePneu,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($totalVidange,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($salaireChauffueurAss,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($prime3,0,',',' ')."</td>

              <td style='size: 13px; border: 1px solid black;'>".number_format($montantAccident,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($bon_livraison,0,'.',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($chargement_retour,0,',',' ')."</td>



              



              <td style='size: 13px; border: 1px solid black;'>".number_format($vente_pieces,0,',',' ')."</td>



   



              <td style='size: 13px; border: 1px solid black;'>".number_format($distance_parcourue,2,'.',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($km_th,2,'.',' ')."</td>";



              if ($diff<0) {



                # code



                echo"<td style='size: 13px; border: 1px solid black; color:red;'>".number_format($diff,2,'.',' ')."</td>"; 



              }else{



                echo"<td style='size: 13px; border: 1px solid black;'>".number_format($diff,2,'.',' ')."</td>";



              }



              



              if ($benefice<0) {



                # code...



                echo "<td style ='color: red; size: 13px; border: 1px solid black;'>".number_format($benefice,0,',',' ')."</td>







                </tr>";



              }else{



                echo "<td style='size: 13px; border: 1px solid black;'>".number_format($benefice,0,',',' ')."</td>







                </tr>";



              }



              



             }







    }







   







  }



   echo "<tr style='text-align: center;'>



              <td style ='color: red;  border: 2px solid black;'> TOTAUX</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".$totalNbreVidange."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalFraisDivers,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalFraisRoute,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".$totalQtiteGasoil."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalGazoil,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalPieceRenchange,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalDepensePneu,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalVidanges,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalSalaire,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalPrime,0,',',' ')."</td>


              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalAccident,0,',',' ')."</td>



               <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalBL,0,'.',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalChargement,0,',',' ')."</td>



             



             <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalVente2,0,',',' ')."</td>



         



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalDistance,2,'.',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalkm_th,2,'.',' ')."</td>";



              if ($totaldiff < 0) {



                # code...



                echo"<td style ='color: red; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totaldiff,2,'.',' ')."</td>";



              }else{



               echo " <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totaldiff,2,'.',' ')."</td>";



              }



              



              if ($totalBenefice<0) {



                # code...



                echo "<td style ='color: red; size: 13px; border: 2px solid black;'>".number_format($totalBenefice,3,'.',' ')."</td>







                </tr>";



              }else{



                echo "<td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalBenefice,3,'.',' ')."</td>







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

              $totalAccident = 0;

              $prime1=0;



              $prime=0;



              $totalPrime=0;



               $totalChargement = 0;



              $totalLocation = 0;



              $totalBL = 0;



              $totaldiff = 0;



              



              $totalQtiteGasoil=0;



              $totalVente2 = 0;



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





$gps = $engin['gps'];



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

       $montantAccident = 0;

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



// $gps = 21465;

$gps = $this->getGSPParNbreMois($gps,$date_debut,$date_fin);





// la ligne qui suis est le net à payer qu'on a copié sur la partie paie employé







$np = $montant-$this->getAllRetenueSalaireChauffeur($engin['id_chauffeur'],$date_debut,$date_fin)-$this->getAllReglementImputationSalaireChauffeur($engin['id_chauffeur'],$date_debut,$date_fin)+$this->getAllRegulationImputationSalaireChauffeur($engin['id_chauffeur'],$date_debut,$date_fin);



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







  $totalVente=0;







    $montant2=0;



    $montantVente = 0;







 $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();



       



$nbreVoyage=0;



    if (count($getPrime) >0 ) {



      # code...



      foreach ($getPrime as $row) {







        $totalVente = $row['montant'];



        $montantVente = $totalVente+ $montantVente;



        $nbreVoyage = $nbreVoyage+1; 



      }



      $nbreVidange = $nbreVoyage;







    }else{



      // echo "nada";



    }







    $vente_pieces = $montantVente;



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



           $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin['code'].'"')->result_array();

    if (count($getPrime)>0) {
      # code...
      $i=0;
      foreach ($getPrime as $acc) {
        # code...

        if ($i ==0) {
          # code...
          $montant = $acc['montant_dep'];
        }
                $i++;

        $montantAccident1 = $acc['qtite']*$acc['montant'];

        $montantAccident = $montantAccident + $montantAccident1;
      }

      $montantAccident = $montantAccident + $montant;
    }




       // }



       $distance_parcourue = $total;







            if ($nbreVidange >0 || $fraisDIvers >0 || $fraisRoute >0 || $gazoil >0 || $pieceRechange >0 || $depensePneu >0 || $totalVidange>0 || $salaireChauffueurAss >0 || $chiffreAff >0 || $distance_parcourue >0) {



              # code...







              // $benefice = $bon_livraison+$chargement_retour+$location_engin-$chiffreAff-$prime- $salaireChauffueurAss-$totalVidange-$depensePneu-$pieceRechange-$gazoil-$fraisRoute-$fraisDIvers;







              $benefice = -$depensePneu-$pieceRechange-$gazoil-$totalVidange-$fraisRoute-$fraisDIvers-$prime3-$montantAccident;



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

              $totalAccident = $totalAccident + $montantAccident;

              $total_km_litrage = $total_km_litrage + $km_litrage;



              $totalVente2 = $totalVente2 + $vente_pieces;



              echo "<tr style='text-align: center;'>



              <td style='size: 13px; border: 1px solid black;'>".$engin['code']."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($fraisDIvers,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($fraisRoute,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".$qtiteGasoil."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($gazoil,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($pieceRechange,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($depensePneu,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($totalVidange,0,',',' ')."</td>

              <td style='size: 13px; border: 1px solid black;'>".number_format($prime3,0,',',' ')."</td>

              <td style='size: 13px; border: 1px solid black;'>".number_format($montantAccident,0,',',' ')."</td>



              ";



              



              if ($benefice<0) {



                # code...



                echo "<td style ='color: red; size: 13px; border: 1px solid black;'>".number_format($benefice,0,',',' ')."</td>







                </tr>";



              }else{



                echo "<td style='size: 8px; size: 13px; border: 1px solid black;'>".number_format($benefice,0,',',' ')."</td>







                </tr>";



              }



              



             }







    }







   







  }



   echo "<tr style='text-align: center;'>



              <td style ='color: red;  border: 2px solid black;'> TOTAUX</td>



               <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalFraisDivers,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalFraisRoute,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".$totalQtiteGasoil."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalGazoil,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalPieceRenchange,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalDepensePneu,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalVidanges,0,',',' ')."</td>

              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalPrime,0,',',' ')."</td>

              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalAccident,0,',',' ')."</td>



             







             ";



              



              if ($totalBenefice<0) {



                # code...



                echo "<td style ='color: red; size: 13px; border: 2px solid black;'>".number_format($totalBenefice,3,'.',' ')."</td>







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

              $totalAccident = 0;

              



              $totalQtiteGasoil=0;



              $totalVente2 = 0;



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





$gps = $engin['gps'];



$nbreVidange=0;



   $compteur = 0;



$montant10 = 0;



$montant9 = 0;

$montantAccident = 0;

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



// $gps = 21465;

$gps = $this->getGSPParNbreMois($gps,$date_debut,$date_fin);





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







  $totalVente=0;







    $montant2=0;



    $montantVente = 0;







 $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();



       



$nbreVoyage=0;



    if (count($getPrime) >0 ) {



      # code...



      foreach ($getPrime as $row) {







        $totalVente = $row['montant'];



        $montantVente = $totalVente+ $montantVente;



        $nbreVoyage = $nbreVoyage+1; 



      }



      $nbreVidange = $nbreVoyage;







    }else{



      // echo "nada";



    }







    $vente_pieces = $montantVente;



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



  $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin['code'].'"')->result_array();

    if (count($getPrime)>0) {
      # code...
      $i=0;
      foreach ($getPrime as $acc) {
        # code...

        if ($i ==0) {
          # code...
          $montant = $acc['montant_dep'];
        }
                $i++;

        $montantAccident1 = $acc['qtite']*$acc['montant'];

        $montantAccident = $montantAccident + $montantAccident1;
      }

      $montantAccident = $montantAccident + $montant;
    }




       // }



       $distance_parcourue = $total;







            if ($nbreVidange >0 || $fraisDIvers >0 || $fraisRoute >0 || $gazoil >0 || $pieceRechange >0 || $depensePneu >0 || $totalVidange>0 || $salaireChauffueurAss >0 || $chiffreAff >0 || $distance_parcourue >0) {



              # code...







              // $benefice = $bon_livraison+$chargement_retour+$location_engin-$chiffreAff-$prime- $salaireChauffueurAss-$totalVidange-$depensePneu-$pieceRechange-$gazoil-$fraisRoute-$fraisDIvers;







              $benefice = $vente_pieces+$location_engin-$totalVidange-$depensePneu-$pieceRechange-$gazoil-$fraisRoute-$fraisDIvers-$prime3-$montantAccident;



              $totalNbreVidange =$nbreVidange +  $totalNbreVidange ;



              $totalVidanges = $totalVidanges+$totalVidange;



              $totalFraisDivers = $totalFraisDivers+$fraisDIvers;



              $totalFraisRoute = $totalFraisRoute+$fraisRoute;

              $totalAccident = $totalAccident + $montantAccident;

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



              $totalVente2 = $totalVente2 + $vente_pieces;







              echo "<tr>



              <td style='size: 13px; border: 1px solid black;'>".$engin['code']."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($fraisDIvers,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($fraisRoute,0,',',' ')."</td>



              



              <td style='size: 13px; border: 1px solid black;'>".$qtiteGasoil."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($gazoil,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($pieceRechange,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($depensePneu,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($totalVidange,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($prime3,0,',',' ')."</td>


              <td style='size: 13px; border: 1px solid black;'>".number_format($montantAccident,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($location_engin,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($vente_pieces,0,',',' ')."</td>



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



               <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalFraisDivers,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalFraisRoute,0,',',' ')."</td>



             



             



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".$totalQtiteGasoil."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalGazoil,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalPieceRenchange,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalDepensePneu,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalVidanges,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalPrime,0,',',' ')."</td>


              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalAccident,0,',',' ')."</td>



               <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalLocation,0,',',' ')."</td>



               <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalVente2,0,',',' ')."</td>



";



              if ($totalBenefice<0) {



                # code...



                echo "<td style ='color: red; size: 13px; border: 2px solid black;'>".number_format($totalBenefice,3,'.',' ')."</td>







                </tr>";



              }else{



                echo "<td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalBenefice,3,'.',' ')."</td>







                </tr>";



              }



              $this->db->close();



}



// pour les vraquiers


public function rapportCumuleMensuelVraquier(){


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

              $totalAccident =0;


              $prime1=0;



              $prime=0;



              $totalPrime=0;



               $totalChargement = 0;



              $totalLocation = 0;



              $totalBL = 0;



              $totaldiff = 0;



              



              $totalQtiteGasoil=0;



              $totalVente2 = 0;



              $totalkm_th =0;



     $getEngin = $this->db->query("SELECT * from tracteur where id_type_camion=".$id_type_vehicule." order by code asc")->result_array();



     $getCamion = $this->db->query("SELECT * from camion_benne where id_type_camion=".$id_type_vehicule." order by code asc")->result_array();


     $getEngin2 = $this->db->query("SELECT * from vraquier where id_type_camion=".$id_type_vehicule." order by code asc")->result_array();



 



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





$gps = $engin['gps'];



$nbreVidange=0;



   $compteur = 0;



$montant10 = 0;



$montant9 = 0;

$montantAccident = 0;

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



// $gps = 21465;

$gps = $this->getGSPParNbreMois($gps,$date_debut,$date_fin);





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







  $totalVente=0;







    $montant2=0;



    $montantVente = 0;







 $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();



       



$nbreVoyage=0;



    if (count($getPrime) >0 ) {



      # code...



      foreach ($getPrime as $row) {







        $totalVente = $row['montant'];



        $montantVente = $totalVente+ $montantVente;



        $nbreVoyage = $nbreVoyage+1; 



      }



      $nbreVidange = $nbreVoyage;







    }else{



      // echo "nada";



    }







    $vente_pieces = $montantVente;



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







        $getPrime = $this->db->query('SELECT * FROM location_vraquier WHERE  date_location between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin['code'].'"')->result_array();



        



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



    $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin['code'].'"')->result_array();

    if (count($getPrime)>0) {
      # code...
    $i= 0;
      foreach ($getPrime as $acc) {
        # code...
        if ($i ==0) {
          # code...
          $montant = $acc['montant_dep'];
        }
                $i++;

        $montantAccident1 = $acc['qtite']*$acc['montant'];

        $montantAccident = $montantAccident + $montantAccident1;
      }

      $montantAccident = $montantAccident + $montant;
    }



       // }



       $distance_parcourue = $total;







            if ($nbreVidange >0 || $fraisDIvers >0 || $fraisRoute >0 || $gazoil >0 || $pieceRechange >0 || $depensePneu >0 || $totalVidange>0 || $salaireChauffueurAss >0 || $chiffreAff >0 || $distance_parcourue >0) {



              # code...







              // $benefice = $bon_livraison+$chargement_retour+$location_engin-$chiffreAff-$prime- $salaireChauffueurAss-$totalVidange-$depensePneu-$pieceRechange-$gazoil-$fraisRoute-$fraisDIvers;







              $benefice = $vente_pieces+$location_engin-$totalVidange-$depensePneu-$pieceRechange-$gazoil-$fraisRoute-$fraisDIvers-$prime3-$montantAccident;



              $totalNbreVidange =$nbreVidange +  $totalNbreVidange ;



              $totalVidanges = $totalVidanges+$totalVidange;

              $totalAccident = $totalAccident + $montantAccident;

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



              $totalVente2 = $totalVente2 + $vente_pieces;







              echo "<tr>



              <td style='size: 13px; border: 1px solid black;'>".$engin['code']."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($fraisDIvers,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($fraisRoute,0,',',' ')."</td>



              



              <td style='size: 13px; border: 1px solid black;'>".$qtiteGasoil."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($gazoil,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($pieceRechange,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($depensePneu,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($totalVidange,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($prime3,0,',',' ')."</td>

              <td style='size: 13px; border: 1px solid black;'>".number_format($montantAccident,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($location_engin,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($vente_pieces,0,',',' ')."</td>



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



               <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalFraisDivers,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalFraisRoute,0,',',' ')."</td>



             



             



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".$totalQtiteGasoil."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalGazoil,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalPieceRenchange,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalDepensePneu,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalVidanges,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalPrime,0,',',' ')."</td>

              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalAccident,0,',',' ')."</td>

               <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalLocation,0,',',' ')."</td>



               <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalVente2,0,',',' ')."</td>



";



              if ($totalBenefice<0) {



                # code...



                echo "<td style ='color: red; size: 13px; border: 2px solid black;'>".number_format($totalBenefice,3,'.',' ')."</td>







                </tr>";



              }else{



                echo "<td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalBenefice,3,'.',' ')."</td>







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

              $totalAccident =0;
			  
			  $totalCommission =0;
			  
			  $totalDepannage =0;
			  
			  $totalPrevision =0;

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



              $totalVente2 = 0 ;



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

        $vehicule = $getCamion;


       }


        $date_debut = $_POST["date_debut"];



        $date_fin = $_POST["date_fin"];



  if (count($vehicule)>0) {



               # code...



           foreach ($vehicule as $engin) {



$gps = $engin['gps'];



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

       $montantAccident = 0;

       $total_km_litrage=0;



       $km_litrage = 0;



       $diff= 0;


            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();


              if (count($getPrime) >0 ) {



                # code...



                foreach ($getPrime as $row) {



                  $montant1 =  $row["qtite"] * $row['pu'];



                    $total1 = $total1 + $montant1;  



                }



              }else{



                // echo "nada";



              }



          $this->db->close();


  $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

    if (count($getPrime) >0 ) {


      foreach ($getPrime as $row) {

        $montant1 =  $row["qtite"] * $row['pu'];



          $total1 = $total1 + $montant1; 



      }

    }else{

    }



  $this->db->close();

  $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();



    if (count($getPrime) >0 ) {



      # code...



      foreach ($getPrime as $row) {


        $montant1 =  $row["qtite"] * $row['pu'];



          $total1 = $total1 + $montant1;


      }


    }else{

    }



$this->db->close();



$totalVidange = $total1;



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


        $getPrime = $this->db->query("SELECT * FROM sortie WHERE  date_sortie between '".$date_debut."' and '".$date_fin."' and `type_sortie` = 'Frais Divers' and vehicule='".$engin["code"]."'")->result_array();

    if (count($getPrime) >0 ) {



      # code...



      foreach ($getPrime as $row) {



       $total = $total + $row['montant'];



      }



    }else{



      // echo "nada";



    }






    $this->db->close();







$fraisDIvers = $total1 +$total+$total2;


$compteur = 0;



     $montant1 =0;



       $total1 = 0;



       $montant =0;



       $total = 0;



              $date_debut = $_POST["date_debut"];



        $date_fin = $_POST["date_fin"];



       
  $getPrime = $this->db->query("SELECT * FROM sortie WHERE  date_sortie between '".$date_debut."' and '".$date_fin."' and `type_sortie` = 'Frais Route' and vehicule='".$engin["code"]."'")->result_array();



  //          $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();


    if (count($getPrime) >0 ) {



      # code...



      foreach ($getPrime as $row) {



       $total = $total + $row['montant'];



      }



    }else{



    }




    $this->db->close();



$fraisRoute = $total1 +$total;



    $id_type_vehicule = $_POST["id_type_vehicule"];



              $id_operation = $id_type_vehicule;



              $compteur = 0;



              $total1 = 0;



              $total = 0;



 



        $date_debut = $_POST["date_debut"];



        $date_fin = $_POST["date_fin"];


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



      $qtiteGasoil  =0;



    }



   if (count($getCamion)>0) {


          $km_th = $qtiteGasoil /0.55;


       }


$this->db->close();


    $gazoil = $total+ $total1;


$compteur = 0;



     $montant1 =0;



       $total1 = 0;



       $montant =0;



       $total = 0;


       $montant2 =0;



       $total2 = 0;



            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();


     if (count($getPrime) >0 ) {



      # code...



      foreach ($getPrime as $row) {


        $getPrixUnitaire = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->result_array();

        foreach ($getPrixUnitaire as $tab) {

          $montant = $row["prix_unitaire"]* $row["qtite"];



        }


        $total = $total+$montant;



        



        $compteur++;



      }



    }else{



      // echo "nada";



    }








$this->db->close();



$pieceRechange = $total1+$total;





           $id_type_vehicule = $_POST["id_type_vehicule"];



$id_operation = $id_type_vehicule;



$compteur = 0;



$total = 0;



$montant = 0;



              $date_debut = $_POST["date_debut"];



        $date_fin = $_POST["date_fin"];



            $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();




        foreach ($getPrime as $row) {



                 $montant = $row['qtite']*$row['prix_unitaire'];







                 $total = $total + $montant;                 



        }


        $this->db->close();



$depensePneu = $total;



              $date_debut = $_POST["date_debut"];



        $date_fin = $_POST["date_fin"];




            $getPrime = $this->db->query('SELECT * FROM chauffeur where id_chauffeur ='.$engin["id_chauffeur"].'')->result_array();


        foreach ($getPrime as $row) {


                 $montant = $row['salaire_ass']+$row['salaire'];



        }


$gps = $this->getGSPParNbreMois($gps,$date_debut,$date_fin);


$np = $montant-$this->getAllRetenueSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)-$this->getAllReglementImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)+$this->getAllRegulationImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin);


$getValidePourSalaire = $this->db->query("SELECT * from paiechauffeur where id_chauffeur=".$row['id_chauffeur']."")->row();



if (count($getValidePourSalaire)>0) {



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



     $montant1=0;



     $montant=0;



     $compteur = 0;



    $total1 = 0;



    $montant1=0;







    $montant2=0;



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



$this->db->close();







 $totalVente=0;







    $montant2=0;



    $montantVente = 0;







 $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();



       



$nbreVoyage=0;



    if (count($getPrime) >0 ) {



      # code...



      foreach ($getPrime as $row) {







        $totalVente = $row['montant'];



        $montantVente = $totalVente+ $montantVente;



        $nbreVoyage = $nbreVoyage+1; 



      }



      $nbreVidange = $nbreVoyage;







    }else{



      // echo "nada";



    }







    $vente_pieces = $montantVente;




            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();



      



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



$chargement_retour = $montant;






              $date_debut = $_POST["date_debut"];



        $date_fin = $_POST["date_fin"];



       
    $getPrime22 = $this->db->query("SELECT * FROM sortie WHERE  date_sortie between '".$date_debut."' and '".$date_fin."' and `type_sortie` = 'Prime' and vehicule='".$engin["code"]."'")->result_array();



 //           $getPrime22 = $this->db->query('SELECT montant FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();


    if (count($getPrime22) >0 ) {



      # code...



      $prime3 = 0;



      foreach ($getPrime22 as $row3) {



        $prime3 = $row3['montant'] +$prime3;


      }



    }else{




      $prime3 = 0;



    }



$this->db->close();


  $totalComm=0;


    $montantCom=0;

    $montantComm = 0;


	
		$getPrime = $this->db->query("SELECT montant FROM sortie WHERE  date_sortie between '".$date_debut."' and '".$date_fin."' and `type_sortie` = 'Commission' and vehicule='".$engin["code"]."'")->result_array();


// $getPrime = $this->db->query('SELECT * FROM commission WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();



    if (count($getPrime) >0 ) {


      foreach ($getPrime as $row) {


        $totalComm = $row['montant'];



        $montantComm = $totalComm + $montantComm;


      }


    }else{


    }


    $vente_Comm = $montantComm;



$this->db->close();



 $totalDep=0;


    $montantDep=0;

    $montantDep = 0;


	
		$getPrime = $this->db->query("SELECT montant FROM sortie WHERE  date_sortie between '".$date_debut."' and '".$date_fin."' and `type_sortie` = 'Depannage' and vehicule='".$engin["code"]."'")->result_array();


// $getPrime = $this->db->query('SELECT * FROM commission WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();



    if (count($getPrime) >0 ) {


      foreach ($getPrime as $row) {


        $totalDep = $row['montant'];



        $montantDep = $totalDep + $montantDep;


      }


    }else{


    }


    $vente_Dep = $montantDep;



$this->db->close();


 $totalPrev=0;


    $montantPrev=0;

    $montantPrev = 0;


	
		$getPrime = $this->db->query("SELECT montant FROM sortie WHERE  date_sortie between '".$date_debut."' and '".$date_fin."' and `type_sortie` = 'Prevision Navire' and vehicule='".$engin["code"]."'")->result_array();


// $getPrime = $this->db->query('SELECT * FROM commission WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();



    if (count($getPrime) >0 ) {


      foreach ($getPrime as $row) {


        $totalPrev = $row['montant'];



        $montantPrev = $totalPrev + $montantPrev;


      }


    }else{


    }


    $vente_Prev = $montantPrev;



$this->db->close();





              $date_debut = $_POST["date_debut"];



        $date_fin = $_POST["date_fin"];







        $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin['code'].'"')->result_array();



          if (count($getPrime) >0 ) {



            # code...



            foreach ($getPrime as $row) {



              # code...



              $getOperation = $this->db->query("SELECT * from operation where id_operation = ".$row['id_operation']." limit 1")->row();



               $montant10 = $row['montant']*$row['duree'];                  



               $montant9 = $montant9 + $montant10;



            }


          }else{

          }



  $location_engin = $montant9;




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



        $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin['code'].'"')->result_array();

    if (count($getPrime)>0) {
      # code...
      $i=0;
      foreach ($getPrime as $acc) {
        # code...

       if ($i ==0) {
          # code...
          $montant = $acc['montant_dep'];
        }
                $i++;

        $montantAccident1 = $acc['qtite']*$acc['montant'];

        $montantAccident = $montantAccident + $montantAccident1;
      }

      $montantAccident = $montantAccident + $montant;
    }



       // }



       $distance_parcourue = $total;







            if ($nbreVidange >0 || $fraisDIvers >0 || $fraisRoute >0 || $gazoil >0 || $pieceRechange >0 || $depensePneu >0 || $totalVidange>0 || $salaireChauffueurAss >0 || $chiffreAff >0 || $distance_parcourue >0) {



              # code...







              // $benefice = $bon_livraison+$chargement_retour+$location_engin-$chiffreAff-$prime- $salaireChauffueurAss-$totalVidange-$depensePneu-$pieceRechange-$gazoil-$fraisRoute-$fraisDIvers;







              $benefice = $vente_pieces+$bon_livraison+$location_engin-$prime3-$montantAccident- $salaireChauffueurAss-$totalVidange-$depensePneu-$pieceRechange-$gazoil-$fraisRoute-$fraisDIvers;



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
			  
			  
			  $totalCommission = $totalCommission + $vente_Comm;
			  
			  $totalDepannage = $totalDepannage + $vente_Dep;
			  
			  $totalPrevision = $totalPrevision + $vente_Prev;

              $totalAccident = $totalAccident + $montantAccident;



              $totalChargement = $totalChargement + $chargement_retour;



              $totalLocation = $totalLocation + $location_engin;



              $totalBL = $totalBL + $bon_livraison;



              $totalQtiteGasoil = $totalQtiteGasoil + $qtiteGasoil;



              $totalkm_th = $totalkm_th + $km_th;



              $diff =$distance_parcourue -$km_th;



              $totaldiff = $totaldiff + $diff;



              $total_km_litrage = $total_km_litrage + $km_litrage;



              $totalVente2 = $totalVente2 + $vente_pieces;



$getRemorque = $this->db->query("SELECT immatriculation FROM camion_benne where code = '".$engin['code']."'")->row();

	   if (count($getRemorque) >0 ) {
		   
		   $getRemorque1 = $getRemorque->immatriculation;
	

                } else {
	   
    $getRemorque1 ="";
}



              echo "<tr style='text-align: center;'>



              <td style='size: 13px; border: 1px solid black; text-align: center;'>".$engin['code']."</td>

			<td style='size: 13px; border: 1px solid black; text-align: center;'>".$getRemorque1."</td>
  

              <td style='size: 13px; border: 1px solid black;text-align: center;'>".$nbreVidange."</td>



              <td style='size: 13px; border: 1px solid black;text-align: center;'>".number_format($fraisDIvers,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;text-align: center;'>".number_format($fraisRoute,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".$qtiteGasoil."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($gazoil,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($pieceRechange,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($depensePneu,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($totalVidange,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($salaireChauffueurAss,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($prime3,0,',',' ')."</td>
			  
			  <td style='size: 13px; border: 1px solid black;'>".number_format($vente_Comm,0,',',' ')."</td>
			  
			  <td style='size: 13px; border: 1px solid black;'>".number_format($vente_Dep,0,',',' ')."</td>
			  
			  <td style='size: 13px; border: 1px solid black;'>".number_format($vente_Prev,0,',',' ')."</td>
			  

              <td style='size: 13px; border: 1px solid black;'>".number_format($montantAccident,0,',',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($bon_livraison,0,'.',' ')."</td>



               <td style='size: 13px; border: 1px solid black;'>".number_format($vente_pieces,0,'.',' ')."</td>


              <td style='size: 13px; border: 1px solid black;'>".number_format($distance_parcourue,2,'.',' ')."</td>



              <td style='size: 13px; border: 1px solid black;'>".number_format($km_th,2,'.',' ')."</td>";



              if ($diff<0) {



                # code



                echo"<td style='size: 13px; border: 1px solid black; color:red;'>".number_format($diff,2,'.',' ')."</td>"; 



              }else{



                echo"<td style='size: 13px; border: 1px solid black;'>".number_format($diff,2,'.',' ')."</td>";



              }



              



              if ($benefice<0) {



                # code...



                echo "<td style ='color: red; size: 13px;  border: 1px solid black;'>".number_format($benefice,0,',',' ')."</td>







                </tr>";



              }else{



                echo "<td style='size: 13px; border: 1px solid black;'>".number_format($benefice,0,',',' ')."</td>


                </tr>";



              }


             }




    }





  }



   echo "<tr style='text-align: center;'>



              <td style ='color: red;  border: 2px solid black;'> TOTAUX</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".$totalNbreVidange."</td>


              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'></td>
			  

              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalFraisDivers,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalFraisRoute,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".$totalQtiteGasoil."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalGazoil,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalPieceRenchange,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalDepensePneu,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalVidanges,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalSalaire,0,',',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalPrime,0,',',' ')."</td>
			  
			  <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalCommission,0,',',' ')."</td>
			  
			   <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalDepannage,0,',',' ')."</td>
			   
			    <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalPrevision,0,',',' ')."</td>


              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalAccident,0,',',' ')."</td>



               <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalBL,0,'.',' ')."</td>



             <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalVente2,0,'.',' ')."</td>



             



             <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalDistance,2,'.',' ')."</td>



              <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalkm_th,2,'.',' ')."</td>";



              if ($totaldiff < 0) {



                # code...



                echo"<td style ='color: red; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totaldiff,2,'.',' ')."</td>";



              }else{



               echo " <td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totaldiff,2,'.',' ')."</td>";



              }



              



              if ($totalBenefice<0) {



                # code...



                echo "<td style ='color: red; size: 13px; border: 2px solid black;'>".number_format($totalBenefice,3,'.',' ')."</td>







                </tr>";



              }else{



                echo "<td style ='color: #20d02b; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalBenefice,3,'.',' ')."</td>







                </tr>";



              }



              $this->db->close();



}



public function rapportCumuleMensuelApprovisionnement(){
 
  $date_debut = $_POST['date_debut'];
  $date_fin = $_POST['date_fin'];

  if ($date_debut != '' && $date_fin == '') {
    # code...
     $query = $this->db->query("SELECT * from approvisionnement where date_app = '".$date_fin."' ")->result_array();
  }elseif ($date_debut == '' && $date_fin != '') {
    # code...
      $query = $this->db->query("SELECT * from approvisionnement where date_app = '".$date_debut."' ")->result_array();
  }else{

      $query = $this->db->query("SELECT * from approvisionnement where date_app between '".$date_debut."' and '".$date_fin."' ")->result_array();
  }

  if (count($query)>0) {
    # code...
    $totalQtite = 0;
    $totalMontant= 0;
    $total2 = 0;
    foreach ($query as $key => $row) {
      # code...

      $getArticle = $this->db->query("SELECT * from article where id_article=".$row['id_article']."")->row();
      echo "<tr>
              <td style =' size: 13px; font-weight: bold;  border: 2px solid black;'>".$row['reference']."</td>";

              if (count($getArticle)>0) {
                # code...
                echo "<td  style='size: 13px; font-weight: bold;  border: 2px solid black;'>".$getArticle->article."</td>";
              }
              $qtite = $row['qtite'];
              $montant = $row['montant'];

              $total =$qtite*$montant;

              $totalQtite = $totalQtite + $qtite;
              $totalMontant = $totalMontant + $montant;

              $total2 = $total2 + $total;
          echo"<td  style='size: 13px; font-weight: bold;  border: 2px solid black;'>".$row['date_app']."</td>
              <td  style='size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($qtite,0,'.',' ')."</td>
              <td  style='size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($montant,0,'.',' ')."</td>
              <td  style='size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($total,0,'.',' ')."</td>
            </tr>";
    }

    echo "<tr>
            <td style ='color: red; size: 15px; font-weight: bold;  border: 2px solid black;'>TOTAL</td>
            <td style ='color: red; size: 15px; font-weight: bold;  border: 2px solid black;'></td>
            <td style ='color: red; size: 15px; font-weight: bold;  border: 2px solid black;'></td>
            <td style ='color: red; size: 15px; font-weight: bold;  border: 2px solid black;'>".number_format($totalQtite,0,'.',' ')."</td>
            <td style ='color: red; size: 15px; font-weight: bold;  border: 2px solid black;'></td>
            <td style ='color: red; size: 15px; font-weight: bold;  border: 2px solid black;'>".number_format($total2,0,'.',' ')."</td>
         </tr>";
  }
}

        /*   
         <td style ='color: red; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalMontant,0,'.',' ')."</td> 
        */

public function vehicules(){



    $getTracteur = $this->db->query("SELECT * from tracteur ORDER BY code ASC ")->result_array();
    $getEngin = $this->db->query("SELECT * from engin ORDER BY code ASC ")->result_array();
    $getBenne = $this->db->query("SELECT * from camion_benne ORDER BY code ASC ")->result_array();
    $getService = $this->db->query("SELECT * from voitureservice ORDER BY code ASC ")->result_array();
    $getVraquier = $this->db->query("SELECT * from vraquier ORDER BY code ASC ")->result_array();

    if (count($getTracteur)>0) {
      # code...
      foreach ($getTracteur as $key => $row) {
        # code...
        echo "<option value='".$row['code']."'>".$row['code']."</option>";
      }
    }
    
    if (count($getEngin)>0) {
      # code...
      foreach ($getEngin as $key => $row) {
        # code...
        echo "<option value='".$row['code']."'>".$row['code']."</option>";
      }
    }
    if (count($getBenne)>0) {
      # code...
      foreach ($getBenne as $key => $row) {
        # code...
        echo "<option value='".$row['code']."'>".$row['code']."</option>";
      }
    }
    if (count($getService)>0) {
      # code...
      foreach ($getService as $key => $row) {
        # code...
        echo "<option value='".$row['code']."'>".$row['code']."</option>";
      }
    }

    if (count($getVraquier)>0) {
      # code...
      foreach ($getVraquier as $key => $row) {
        # code...
        echo "<option value='".$row['code']."'>".$row['code']."</option>";
      }
    }

    $this->db->close();



}

public function EnteteRapportAccident(){



    $code_camion = $_POST['code'];
    
     $date_debut = $_POST['date_debut'];
  $date_fin = $_POST['date_fin'];

    $code = $code_camion;

    $getTracteur = $this->db->query("SELECT * from tracteur where code ='".$code_camion."'")->result_array();
    $getEngin = $this->db->query("SELECT * from engin where code ='".$code_camion."'")->result_array();
    $getBenne = $this->db->query("SELECT * from camion_benne where code ='".$code_camion."'")->result_array();
    $getService = $this->db->query("SELECT * from voitureservice where code ='".$code_camion."'")->result_array();
    $getVraquier = $this->db->query("SELECT * from vraquier where code ='".$code_camion."'")->result_array();

    if (count($getTracteur)>0) {
      # code...

echo "<tr>";

      foreach ($getTracteur as $key => $row) {
        # code...
        echo "<td>Code: ".$code." </td>
              <td>Tracteur: ".$row['immatriculation']."</td>";
        $getRemorque = $this->db->query("SELECT * from remorque where id_remorque=".$row['id_remorque']."")->row();
          if (count($getRemorque)>0) {
            # code...
            
               echo"<td>Remorque: ".$getRemorque->immatriculation."</td>";
          }


      }
    }elseif (count($getEngin)>0) {
      # code...
      foreach ($getEngin as $key => $row) {
        # code...
       echo "<td>Code: ".$code." </td>
              <td>Immatriculation: ".$row['immatriculation']."</td>
              <td>Remorque: </td>
              ";
      }
    }elseif (count($getBenne)>0) {
      # code...
      foreach ($getBenne as $key => $row) {
        # code...
        echo "<td>Code: ".$code." </td>
              <td>Immatriculation: ".$row['immatriculation']."</td>
              <td>Remorque: </td>
              ";
      }
    }elseif (count($getService)>0) {
      # code...
      foreach ($getService as $key => $row) {
        # code...
        echo "<td>Code: ".$code." </td>
              <td>Immatriculation: ".$row['immatriculation']."</td>
              <td>Remorque: </td>
              ";
      }
    }

    if (count($getVraquier)>0) {
      # code...
      foreach ($getVraquier as $key => $row) {
        # code...
        echo "<td>Code: ".$code." </td>
              <td>Immatriculation: ".$row['immatriculation']."</td>
              <td>Remorque: </td>
              ";
      }
    }
    
    echo" <td>Date Accident</td>
          <td>Lieu Accident</td>
          <td>Date entree</td>
          <td>Date sortie</td>
          <td>Montant Dépensé</td>
     </tr>";

   if (empty($date_debut) && empty($date_fin) && !empty($code_camion)){

     $getDateAccident = $this->db->query("SELECT DISTINCT code, date_acc, lieu, date_ent, date_sort, montant_dep from accident where code ='".$code_camion."' and montant_dep > 0") -> result_array();

    
}elseif (empty($date_fin) && !empty($code_camion) && !empty($date_debut)){

$getDateAccident = $this->db->query("SELECT DISTINCT code, date_acc, lieu, date_ent, date_sort, montant_dep from accident where code ='".$code_camion."' and date_acc >= '".$date_debut."' and montant_dep > 0") -> result_array();

}elseif (!empty($date_fin) && !empty($code_camion) && empty($date_debut)){

$getDateAccident = $this->db->query("SELECT DISTINCT code, date_acc, lieu, date_ent, date_sort, montant_dep from accident where code ='".$code_camion."' and date_acc <= '".$date_fin."' and montant_dep > 0") -> result_array();

}elseif (!empty($date_fin) && !empty($code_camion) && !empty($date_debut)){

$getDateAccident = $this->db->query("SELECT DISTINCT code, date_acc, lieu, date_ent, date_sort, montant_dep from accident where code ='".$code_camion."' and montant_dep > 0 and date_acc between '".$date_debut."' and '".$date_fin."'") -> result_array();

}  
    if (count($getDateAccident)>0) {
      # code...
      
      foreach ($getDateAccident as $key => $row) {
        # code...
         echo "<tr><td></td>
                  <td></td>
                  <td></td>
                  <td>".$row["date_acc"]."</td>
                  <td>".$row["lieu"]."</td>
                  <td>".$row["date_ent"]."</td>
                  <td>".$row["date_sort"]."</td>
                  <td>".number_format($row["montant_dep"],0,'.',' ')."</td>
              </tr>";
      }
      
      
    }

    $this->db->close();



}

public function rapportCumuleMensuelAccident(){
      $date_debut = $_POST['date_debut'];
  $date_fin = $_POST['date_fin'];
  $code_camion = $_POST['code_camion'];

$query = $this->db->query("SELECT * from accident where date_acc between '".$date_debut."' and '".$date_fin."' and code ='".$code_camion."'")->result_array();


echo'<thead>
                      <tr  style="size: 10px; border: 2px solid black; text-align: center;">
                        
                        <th style="size: 10px; border: 2px solid black;">Pièces</th>

                        <th style="size: 10px; border: 2px solid black;">Quantité</th>
                        <th style="size: 10px; border: 2px solid black;">Montant</th>
                        <th style="size: 10px; border: 2px solid black;">Total</th>

                      </tr>
                    </thead>
                    <tbody class="">
                      ';
  if (count($query)>0) {
    # code...
    $totalQtite = 0;
    $totalMontant= 0;
    $total2 = 0;
    foreach ($query as $key => $row) {
      # code...

      $getArticle = $this->db->query("SELECT * from article where id_article=".$row['id_article']."")->row();
      echo "<tr>";

              if (count($getArticle)>0) {
                # code...
                echo "<td  style='size: 13px; font-weight: bold;  border: 2px solid black;'>".$getArticle->article."</td>";
              }
              $qtite = $row['qtite'];
              $montant = $row['montant'];

              $total =$qtite*$montant;

              $totalQtite = $totalQtite + $qtite;
              $totalMontant = $totalMontant + $montant;

              $total2 = $total2 + $total;
        echo"
              <td  style='size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($qtite,0,'.',' ')."</td>
              <td  style='size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($montant,0,'.',' ')."</td>
              <td  style='size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($total,0,'.',' ')."</td>
            </tr>";
    }

    echo "<tr>
            <td style ='color: red; size: 13px; font-weight: bold;  border: 2px solid black;'>TOTAL</td>
            <td style ='color: red; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalQtite,0,'.',' ')."</td>
            <td style ='color: red; size: 13px; font-weight: bold;  border: 2px solid black;'></td>
            <td style ='color: red; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($total2,0,'.',' ')."</td>
         </tr>";
  }

  echo '</body>';
}

// <td style ='color: red; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalMontant,0,'.',' ')."</td>


public function rapportCumuleMensuelAccident2(){
      $date_debut = $_POST['date_debut'];
      $date_fin = $_POST['date_fin'];



$query = $this->db->query("SELECT code, date_acc, lieu, date_ent, date_sort, montant_dep, SUM(qtite*montant) AS PRODUIT_ACC from accident where date_acc between '".$date_debut."' and '".$date_fin."' GROUP by code, date_acc,lieu")->result_array();
  echo'<thead>
                      <tr  style="size: 10px; border: 2px solid black; text-align: center;">
                        <th style="size: 10px; border: 2px solid black;">Code camion</th>

                        <th style="size: 10px; border: 2px solid black;">Lieu</th>
                        <th style="size: 10px; border: 2px solid black;">Date Accident</th>
                        <th style="size: 10px; border: 2px solid black;">Date entrée</th>
                        <th style="size: 10px; border: 2px solid black;">Date sortie</th>
                        <th style="size: 10px; border: 2px solid black;">ESPECES</th>

                        <th style="size: 10px; border: 2px solid black;">PIECES</th>

                      </tr>
                    </thead>
                    <tbody class="">
                      ';

  if (count($query)>0) {
    # code...
    $totalQtite = 0;
    $totalMontant= 0;
    $total2 = 0;
    foreach ($query as $key => $row) {
      # code...

      # code... $getArticle = $this->db->query("SELECT * from article where id_article=".$row['id_article']."")->row();
      
      echo "<tr><td  style='size: 13px; font-weight: bold;  border: 2px solid black;'>".$row["code"]."</td>
            <td  style='size: 13px; font-weight: bold;  border: 2px solid black;'>".$row["lieu"]."</td>
            <td  style='size: 13px; font-weight: bold;  border: 2px solid black;'>".$row["date_acc"]."</td>
            <td  style='size: 13px; font-weight: bold;  border: 2px solid black;'>".$row["date_ent"]."</td>
            <td  style='size: 13px; font-weight: bold;  border: 2px solid black;'>".$row["date_sort"]."</td>
            <td  style='size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($row["montant_dep"],0,'.',' ')."</td>
            <td  style='size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($row["PRODUIT_ACC"],0,'.',' ')."</td>";
            
                             $qtite =  $row["montant_dep"];
            
                             $montant = $row["PRODUIT_ACC"];

                             $totalQtite = $totalQtite + $qtite;
              
                            $totalMontant = $totalMontant + $montant;

          echo"  </tr>";
    }
    
    echo "<tr>

            <td style ='color: red; size: 13px; font-weight: bold;  border: 2px solid black;'>TOTAL</td>

            <td  style='size: 13px; font-weight: bold;  border: 2px solid black;'></td>

            <td  style='size: 13px; font-weight: bold;  border: 2px solid black;'></td>
            <td  style='size: 13px; font-weight: bold;  border: 2px solid black;'></td>
            <td  style='size: 13px; font-weight: bold;  border: 2px solid black;'></td>
            

            <td style ='color: red; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalQtite,0,'.',' ')."</td>
            <td style ='color: red; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($totalMontant,0,'.',' ')."</td>
            
         </tr>";
         
  }

    # code... <td style ='color: red; size: 13px; font-weight: bold;  border: 2px solid black;'>".number_format($total2,0,'.',' ')."</td>

  echo '</body>';
}



// rapportGeneral



public function selectAllBonLivraisonPourRapportGeneral($condition,$tabVehicule){



     $getEngin = $this->db->query("SELECT * from ".$tabVehicule." ".$condition."")->result_array();
  

     $montant1=0;
     $montant=0;
     $compteur = 0;
    $total1 = 0;
    $montant1=0;

    $montant2=0;

           if (count($getEngin)>0) {

           foreach ($getEngin as $engin) {

        $date_debut = $_POST["date_debut"];

        $date_fin = $_POST["date_fin"];

        
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();
        

                if (count($getPrime) >0 ) {

                          foreach ($getPrime as $row) {

                            $total1 = $row['quantite']*$row['prix_unitaire'];

                            $montant2 = $total1+ $montant2;

                          }

                }else{

                }

           }

        }

    return $montant2;

    $this->db->close();
}



public function selectAllChargementRetourRapportGeneral($condition,$tabVehicule){

 $montant = 0;

 $compteur = 0;


        $getTracteur = $this->db->query("SELECT * from ".$tabVehicule." ".$condition."")->result_array();
  

     
           if (count($getTracteur)>0) {

           foreach ($getTracteur as $tracteur) {


           $date_debut = $_POST["date_debut"];

           $date_fin = $_POST["date_fin"];
  
           $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$tracteur['code'].'"')->result_array();

           if (count($getPrime) >0 ) {

              foreach ($getPrime as $row) {

               $montant = $montant+$row['montant'];

                  $compteur++;

              }



            }else{


            }

         }
     
        
 }

 return $montant;
}



public function selectLocationEnginPourRapportGeneral($condition,$tabVehicule){


   $compteur = 0;

   $montant10 = 0;

   $montant9 = 0;

   $getEngin = $this->db->query("SELECT * from ".$tabVehicule." ".$condition."")->result_array();;

   if (count($getEngin)>0) {


           foreach ($getEngin as $engin) {

             
              $date_debut = $_POST["date_debut"];

              $date_fin = $_POST["date_fin"];

              $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin['code'].'"')->result_array();


    if (count($getPrime) >0 ) {

      foreach ($getPrime as $row) {

        $getOperation = $this->db->query("SELECT * from operation where id_operation = ".$row['id_operation']." limit 1")->row();

         $montant10 = $row['montant']*$row['duree'];                  

         $montant9 = $montant9 + $montant10;
             }
                }else{


                }

           }

           return $montant9;

        }

$this->db->close();

  }


public function selectVentePiecesPourRapportGeneral($condition,$tabVehicule){


            $montant10 = 0;
            $total10 = 0;

        $getEngin = $this->db->query("SELECT * from ".$tabVehicule." ".$condition."")->result_array();

        $date_debut = $_POST["date_debut"];

        $date_fin = $_POST["date_fin"];

        

            if (count($getEngin)>0) {

           foreach ($getEngin as $engin) {

            $getPrime = $this->db->query('SELECT * FROM vente_pieces WHERE  date_piece between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();
        
                if (count($getPrime) >0 ) {

                  foreach ($getPrime as $row) {

                     $montant10 = $row['montant'];                 

                     $total10 = $total10 + $montant10;

                  }


                }else{

                }

             }

            }

    return $total10;

    $this->db->close();
    }


  public function selectFraisRoutePourRapportGeneral($condition,$tabVehicule){


       $total = 0;

     $getEngin = $this->db->query("SELECT * from ".$tabVehicule." ".$condition."")->result_array();


        if (count($getEngin)>0) {

           foreach ($getEngin as $engin) {


              $date_debut = $_POST["date_debut"];

              $date_fin = $_POST["date_fin"];

              $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();


                    if (count($getPrime) >0 ) {

                      foreach ($getPrime as $row) {

                       $total = $total + $row['montant'];

                      }

                    }else{

                    }

             }
         }
 $this->db->close();

return $total;


}

  public function selectFraisDiversPourRapportGeneral($condition,$tabVehicule){


       $total = 0;

     $getEngin = $this->db->query("SELECT * from ".$tabVehicule." ".$condition."")->result_array();


        if (count($getEngin)>0) {

           foreach ($getEngin as $engin) {


              $date_debut = $_POST["date_debut"];

              $date_fin = $_POST["date_fin"];

              $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();


                    if (count($getPrime) >0 ) {

                      foreach ($getPrime as $row) {

                       $total = $total + $row['montant'];

                      }

                    }else{

                    }

             }
         }
 $this->db->close();

  return $total;
}


public function selectPrimePourRapportGeneral($condition,$tabVehicule){


                    $total = 0;

                    $montant1=0;

     $getEngin = $this->db->query("SELECT * from ".$tabVehicule." ".$condition."")->result_array();


       if (count($getEngin)>0) {

           foreach ($getEngin as $engin) {

           $date_debut = $_POST["date_debut"];
           $date_fin = $_POST["date_fin"];

           $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();

           if (count($getPrime) >0 ) {

              foreach ($getPrime as $row) {

                $total = $row['montant'];

                $montant1 = $total+ $montant1;

              }
            }else{

                }

           }

        }

       $this->db->close();
       return $montant1;
    }




public function selectPieceRechangePourRapportGeneral($condition,$tabVehicule){


     $compteur = 0;

     $montant =0;

     $total = 0;

    $getEngin = $this->db->query("SELECT * from ".$tabVehicule." ".$condition."")->result_array();

        $date_debut = $_POST["date_debut"];

        $date_fin = $_POST["date_fin"];

          if (count($getEngin)>0) {


           foreach ($getEngin as $engin) {

            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

              foreach ($getPrime as $row) {


                $getPrixUnitaire = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->result_array();

                foreach ($getPrixUnitaire as $tab) {

                  $montant = $row["prix_unitaire"]* $row["qtite"];

                }

                $total = $total+$montant;

                $compteur++;

              }

            }

  }



return $total;

$this->db->close();

  }


public function selectVidangePourRapportGeneral($condition,$tabVehicule){

    $total2=0;

    $total1=0;

     $getEngin = $this->db->query("SELECT * from ".$tabVehicule." ".$condition."")->result_array();


        $date_debut = $_POST["date_debut"];



        $date_fin = $_POST["date_fin"];



        if (count($getEngin)>0) {

           foreach ($getEngin as $engin) {



        $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

    $compteur = 0;

    $montant1 = 0;

    if (count($getPrime) >0 ) {


      foreach ($getPrime as $row) {

        $montant1 =  $row["qtite"] * $row['pu'];
          $total1 = $total1 + $montant1;  

      }

    }else{


    }

    $this->db->close();

     $getPrime = $this->db->query('SELECT * FROM vidangehydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

    if (count($getPrime) >0 ) {

      foreach ($getPrime as $row) {


        $montant1 =  $row["qtite"] * $row['pu'];

          $total1 = $total1 + $montant1; 

      }

    }else{


    }


      $getPrime = $this->db->query('SELECT * FROM vidangeboite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();


    if (count($getPrime) >0 ) {

      foreach ($getPrime as $row) {

        $montant1 =  $row["qtite"] * $row['pu'];



          $total1 = $total1 + $montant1; 

      }

    }else{

    }

  }


}

   $this->db->close();

   return $total1;

}




  public function selectGazoilPourRapportGeneral($condition,$tabVehicule){

              $compteur = 0;



              $total1 = 0;



              $total = 0;


        $getEngin = $this->db->query("SELECT * from ".$tabVehicule." ".$condition."")->result_array();


        $date_debut = $_POST["date_debut"];


        $date_fin = $_POST["date_fin"];
    if (count($getEngin)>0) {
        // code...
        foreach($getEngin as $engin){
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin["code"].'"')->result_array();

             if (count($getPrime) >0 ) {

      foreach ($getPrime as $row) {

        $getDestination = $this->db->query("SELECT * from distance_littrage where id_distance=".$row['id_distance']." limit 1")->row();

            $montant = $row['litrage']*$row['prix_unitaire'];


            $total = $montant + $total;

              }



            }else{


            }

        }
    }
         

    return $total;

    $this->db->close();

  }




public function selectDepensePneuPourRapportGeneral($condition,$tabVehicule){

            $compteur = 0;

            $total = 0;

            $montant = 0;


     $getEngin = $this->db->query("SELECT * from ".$tabVehicule." ".$condition."")->result_array();


           foreach ($getEngin as $engin) {

                $date_debut = $_POST["date_debut"];

                $date_fin = $_POST["date_fin"];

                $getPrime = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$engin['code'].'"')->result_array();

                foreach ($getPrime as $row) {

                         $montant = $row['qtite']*$row['prix_unitaire'];


                         $total = $total + $montant;                 

                }

            }

        return $total;

        $this->db->close();

}



public function selectAccidentPourRapportGeneral($condition,$tabVehicule){

        $compteur = 0;



       $montant1 =0;



       $total1 = 0;



       $montant =0;



       $total = 0;



      $depense = 0;



       $montant2 =0;



       $total2 = 0;



        $getEngin = $this->db->query("SELECT * from ".$tabVehicule." ".$condition."")->result_array();


        $date_debut = $_POST["date_debut"];

        $date_fin = $_POST["date_fin"];


          if (count($getEngin)>0) {

           foreach ($getEngin as $engin) {

            $getPrime = $this->db->query('SELECT * FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin["code"].'"')->result_array();


            $getMontDep = $this->db->query('SELECT SUM(montant_dep) AS DEPENSE FROM accident WHERE  date_acc between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$engin["code"].'"')->result_array();
        

     if (count($getPrime) >0 ) {

            $montant_dep = 0;

            if (count($getMontDep) >0 ) {
                
                foreach ($getMontDep as $row) {
                
                $montant_dep = $montant_dep + $row["DEPENSE"];
                
                }
                
                
            }

      foreach ($getPrime as $row) {


        $getPrixUnitaire = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->result_array();

        foreach ($getPrixUnitaire as $tab) {

          $montant = $tab["prix_unitaire"] * $row["qtite"];

        }

        $total = $total+$montant;

        $compteur++;

      }
      
     $total = $total +$montant_dep;



    }else{



    }



  }



}

return $total;

  }
public function salaireGps($condition,$tabVehicule){


     $date_debut = $_POST["date_debut"];

     $date_fin = $_POST["date_fin"];
     $getEngin = $this->db->query("SELECT * from ".$tabVehicule." ".$condition."")->result_array();;

     $montant = 0;
     $montant1 = 0;
     // $gps=0;
   if (count($getEngin)>0) {

           foreach ($getEngin as $engin) {
            
            

                $getPrime = $this->db->query('SELECT * FROM chauffeur where id_chauffeur ='.$engin["id_chauffeur"].'')->result_array();

                foreach ($getPrime as $row) {

                         $montant1 = $row['salaire_ass']+$row['salaire'];
                }

                $gps = $engin['gps'];
                $gps = $this->getGSPParNbreMois($gps,$date_debut,$date_fin);


                $np = $montant1-$this->getAllRetenueSalaireChauffeur($engin['id_chauffeur'],$date_debut,$date_fin)-$this->getAllReglementImputationSalaireChauffeur($engin['id_chauffeur'],$date_debut,$date_fin)+$this->getAllRegulationImputationSalaireChauffeur($engin['id_chauffeur'],$date_debut,$date_fin);


                $getValidePourSalaire = $this->db->query("SELECT * from paiechauffeur where id_chauffeur=".$engin['id_chauffeur']."")->row();
                if (count($getValidePourSalaire)>0) {

                  if ($getValidePourSalaire->salaire == 1) {

                    $salaireChauffueurAss = $gps;

                  }elseif ($getValidePourSalaire->salaire_gps == 1) {

                    $salaireChauffueurAss =0;

                  }elseif ($getValidePourSalaire->gps == 1) {

                    $salaireChauffueurAss =$np;

                  }else{

                    $salaireChauffueurAss = $np + $gps;

                  }

                }else{

                  $salaireChauffueurAss = $np + $gps;

                }

            $montant =$montant+$salaireChauffueurAss;
           }
    }

    return $montant;
    
}

public function rapportGeneral(){

    // pour les nouveaux plateaux
    $recetteTracteur10 = 
    $this->selectLocationEnginPourRapportGeneral("where  id_type_camion=2","tracteur")+
    $this->selectAllChargementRetourRapportGeneral("where  id_type_camion=2","tracteur")+
    $this->selectVentePiecesPourRapportGeneral("where id_type_camion=2","tracteur")+
    $this->selectAllBonLivraisonPourRapportGeneral("where  id_type_camion=2","tracteur");

    // +
    // $this->selectLocationEnginPourRapportGeneral("where type='nouveau' and id_type_camion=4","tracteur")+
    // $this->selectAllChargementRetourRapportGeneral("where type='nouveau' and id_type_camion=4","tracteur")+
    // $this->selectVentePiecesPourRapportGeneral("where type='nouveau' and id_type_camion=4","tracteur")+
    // $this->selectAllBonLivraisonPourRapportGeneral("where type='nouveau' and id_type_camion=4","tracteur");

    $recetteTracteur6 = 
    // $this->selectLocationEnginPourRapportGeneral("where type='ancien' and id_type_camion=2","tracteur")+
    // $this->selectAllChargementRetourRapportGeneral("where type='ancien' and id_type_camion=2","tracteur")+
    // $this->selectVentePiecesPourRapportGeneral("where type='ancien' and id_type_camion=2","tracteur")+
    // $this->selectAllBonLivraisonPourRapportGeneral("where type='ancien' and id_type_camion=2","tracteur");

    $this->selectLocationEnginPourRapportGeneral("where id_type_camion=4","tracteur")+
    $this->selectAllChargementRetourRapportGeneral("where id_type_camion=4","tracteur")+
    $this->selectVentePiecesPourRapportGeneral("where id_type_camion=4","tracteur")+
    $this->selectAllBonLivraisonPourRapportGeneral("where id_type_camion=4","tracteur");
// carosserie

    $recetteNouveauxCarosserie= 
    $this->selectLocationEnginPourRapportGeneral("where id_type_camion=11","tracteur")+
    $this->selectAllChargementRetourRapportGeneral("where id_type_camion=11","tracteur")+
    $this->selectVentePiecesPourRapportGeneral("where id_type_camion=11","tracteur")+
    $this->selectAllBonLivraisonPourRapportGeneral("where id_type_camion=11","tracteur");

    // +
    // $this->selectLocationEnginPourRapportGeneral("where type='nouveau' and id_type_camion=11","tracteur")+
    // $this->selectAllChargementRetourRapportGeneral("where type='nouveau' and id_type_camion=11","tracteur")+
    // $this->selectVentePiecesPourRapportGeneral("where type='nouveau' and id_type_camion=11","tracteur")+
    // $this->selectAllBonLivraisonPourRapportGeneral("where type='nouveau' and id_type_camion=11","tracteur");

    // $recetteAnciensCarosserie = 
    // $this->selectLocationEnginPourRapportGeneral("where type='ancien' and id_type_camion=11","tracteur")+
    // $this->selectAllChargementRetourRapportGeneral("where type='ancien' and id_type_camion=11","tracteur")+
    // $this->selectVentePiecesPourRapportGeneral("where type='ancien' and id_type_camion=11","tracteur")+
    // $this->selectAllBonLivraisonPourRapportGeneral("where type='ancien' and id_type_camion=11","tracteur")

    // +$this->selectLocationEnginPourRapportGeneral("where type='ancien' and id_type_camion=11","tracteur")+
    // $this->selectAllChargementRetourRapportGeneral("where type='ancien' and id_type_camion=11","tracteur")+
    // $this->selectVentePiecesPourRapportGeneral("where type='ancien' and id_type_camion=11","tracteur")+
    // $this->selectAllBonLivraisonPourRapportGeneral("where type='ancien' and id_type_camion=11","tracteur");


    $recetteBennes = 
    $this->selectLocationEnginPourRapportGeneral("","camion_benne")+
    $this->selectAllChargementRetourRapportGeneral("","camion_benne")+
    $this->selectVentePiecesPourRapportGeneral("","camion_benne")+
    $this->selectAllBonLivraisonPourRapportGeneral("","camion_benne");

    // $recetteAnciensCalabrese = 
    // $this->selectLocationEnginPourRapportGeneral("where type='ancien' and id_type_camion=8","tracteur")+
    // $this->selectAllChargementRetourRapportGeneral("where type='ancien' and id_type_camion=8","tracteur")+
    // $this->selectVentePiecesPourRapportGeneral("where type='ancien' and id_type_camion=8","tracteur")+
    // $this->selectAllBonLivraisonPourRapportGeneral("where type='ancien' and id_type_camion=8","tracteur");

    $recetteNouveauxCalabrese = 
    $this->selectLocationEnginPourRapportGeneral("where id_type_camion=8","tracteur")+
    $this->selectAllChargementRetourRapportGeneral("where id_type_camion=8","tracteur")+
    $this->selectVentePiecesPourRapportGeneral("where id_type_camion=8","tracteur")+
    $this->selectAllBonLivraisonPourRapportGeneral("where  id_type_camion=8","tracteur");
              
    $recetteVraquier = 
    $this->selectLocationEnginPourRapportGeneral("","vraquier")+
    $this->selectAllChargementRetourRapportGeneral("","vraquier")+
    $this->selectVentePiecesPourRapportGeneral("","vraquier")+
    $this->selectAllBonLivraisonPourRapportGeneral("","vraquier");

    $recetteVoitureService = 
    $this->selectLocationEnginPourRapportGeneral("","voitureservice")+
    $this->selectAllChargementRetourRapportGeneral("","voitureservice")+
    $this->selectVentePiecesPourRapportGeneral("","voitureservice")+
    $this->selectAllBonLivraisonPourRapportGeneral("","voitureservice");

    $recetteEngin = 
    $this->selectLocationEnginPourRapportGeneral("","engin")+
    $this->selectAllChargementRetourRapportGeneral("","engin")+
    $this->selectVentePiecesPourRapportGeneral("","engin")+
    $this->selectAllBonLivraisonPourRapportGeneral("","engin");


    // depenses

    $depensesTracteur10 = 
    $this->selectAccidentPourRapportGeneral("where id_type_camion=2","tracteur")+
    $this->selectDepensePneuPourRapportGeneral("where id_type_camion=2","tracteur")+
    $this->selectGazoilPourRapportGeneral("where id_type_camion=2","tracteur")+
    $this->selectVidangePourRapportGeneral("where id_type_camion=2","tracteur")+
    $this->selectPieceRechangePourRapportGeneral("where id_type_camion=2","tracteur")+
    $this->selectPrimePourRapportGeneral("where id_type_camion=2","tracteur")+
    $this->selectFraisRoutePourRapportGeneral("where id_type_camion=2","tracteur")+
    $this->selectFraisDiversPourRapportGeneral("where id_type_camion=2","tracteur")+
    $this->salaireGps("where id_type_camion=2","tracteur");

    // + 
    // $this->selectAccidentPourRapportGeneral("where type='nouveau' and id_type_camion=4","tracteur")+
    // $this->selectDepensePneuPourRapportGeneral("where type='nouveau' and id_type_camion=4","tracteur")+
    // $this->selectGazoilPourRapportGeneral("where type='nouveau' and id_type_camion=4","tracteur")+
    // $this->selectVidangePourRapportGeneral("where type='nouveau' and id_type_camion=4","tracteur")+
    // $this->selectPieceRechangePourRapportGeneral("where type='nouveau' and id_type_camion=4","tracteur")+
    // $this->selectPrimePourRapportGeneral("where type='nouveau' and id_type_camion=4","tracteur")+
    // $this->selectFraisRoutePourRapportGeneral("where type='nouveau' and id_type_camion=4","tracteur")+
    // $this->selectFraisDiversPourRapportGeneral("where type='nouveau' and id_type_camion=4","tracteur");

    $depensesTracteur6 =
    // $this->selectAccidentPourRapportGeneral("where type='ancien' and id_type_camion=2","tracteur")+
    // $this->selectDepensePneuPourRapportGeneral("where type='ancien' and id_type_camion=2","tracteur")+
    // $this->selectGazoilPourRapportGeneral("where type='ancien' and id_type_camion=2","tracteur")+
    // $this->selectVidangePourRapportGeneral("where type='ancien' and id_type_camion=2","tracteur")+
    // $this->selectPieceRechangePourRapportGeneral("where type='ancien' and id_type_camion=2","tracteur")+
    // $this->selectPrimePourRapportGeneral("where type='ancien' and id_type_camion=2","tracteur")+
    // $this->selectFraisRoutePourRapportGeneral("where type='ancien' and id_type_camion=2","tracteur")+
    // $this->selectFraisDiversPourRapportGeneral("where type='ancien' and id_type_camion=2","tracteur")
    // +
    $this->selectAccidentPourRapportGeneral("where id_type_camion=4","tracteur")+
    $this->selectDepensePneuPourRapportGeneral("where id_type_camion=4","tracteur")+
    $this->selectGazoilPourRapportGeneral("where id_type_camion=4","tracteur")+
    $this->selectVidangePourRapportGeneral("where id_type_camion=4","tracteur")+
    $this->selectPieceRechangePourRapportGeneral("where id_type_camion=4","tracteur")+
    $this->selectPrimePourRapportGeneral("where id_type_camion=4","tracteur")+
    $this->selectFraisRoutePourRapportGeneral("where id_type_camion=4","tracteur")+
    $this->selectFraisDiversPourRapportGeneral("where id_type_camion=4","tracteur")+
    $this->salaireGps("where id_type_camion=4","tracteur");
// carosserie

    $depensesNouveauxCarosserie = 
    $this->selectAccidentPourRapportGeneral("where id_type_camion=11","tracteur")+
    $this->selectDepensePneuPourRapportGeneral("where id_type_camion=11","tracteur")+
    $this->selectGazoilPourRapportGeneral("where id_type_camion=11","tracteur")+
    $this->selectVidangePourRapportGeneral("where id_type_camion=11","tracteur")+
    $this->selectPieceRechangePourRapportGeneral("where id_type_camion=11","tracteur")+

    $this->selectPrimePourRapportGeneral("where id_type_camion=11","tracteur")+
    $this->selectFraisRoutePourRapportGeneral("where id_type_camion=11","tracteur")+
    $this->selectFraisDiversPourRapportGeneral("where id_type_camion=11","tracteur")+
    $this->salaireGps("where id_type_camion=11","tracteur");

    // + 
    // $this->selectAccidentPourRapportGeneral("where type='nouveau' and id_type_camion=11","tracteur")+
    // $this->selectDepensePneuPourRapportGeneral("where type='nouveau' and id_type_camion=11","tracteur")+
    // $this->selectGazoilPourRapportGeneral("where type='nouveau' and id_type_camion=11","tracteur")+
    // $this->selectVidangePourRapportGeneral("where type='nouveau' and id_type_camion=11","tracteur")+
    // $this->selectPieceRechangePourRapportGeneral("where type='nouveau' and id_type_camion=11","tracteur")+

    // $this->selectPrimePourRapportGeneral("where type='nouveau' and id_type_camion=11","tracteur")+
    // $this->selectFraisRoutePourRapportGeneral("where type='nouveau' and id_type_camion=11","tracteur")+
    // $this->selectFraisDiversPourRapportGeneral("where type='nouveau' and id_type_camion=11","tracteur");

    // $depensesAnciensCarosserie = 

    // $this->selectAccidentPourRapportGeneral("where type='ancien' and id_type_camion=11","tracteur")+
    // $this->selectDepensePneuPourRapportGeneral("where type='ancien' and id_type_camion=11","tracteur")+
    // $this->selectGazoilPourRapportGeneral("where type='ancien' and id_type_camion=11","tracteur")+
    // $this->selectVidangePourRapportGeneral("where type='ancien' and id_type_camion=11","tracteur")+
    // $this->selectPieceRechangePourRapportGeneral("where type='ancien' and id_type_camion=11","tracteur")+

    // $this->selectPrimePourRapportGeneral("where type='ancien' and id_type_camion=11","tracteur")+
    // $this->selectFraisRoutePourRapportGeneral("where type='ancien' and id_type_camion=11","tracteur")+
    // $this->selectFraisDiversPourRapportGeneral("where type='ancien' and id_type_camion=11","tracteur");
    // +
    // $this->selectPrimePourRapportGeneral("where type='ancien' and id_type_camion=11","tracteur")+
    // $this->selectFraisRoutePourRapportGeneral("where type='ancien' and id_type_camion=11","tracteur")+
    // $this->selectFraisDiversPourRapportGeneral("where type='ancien' and id_type_camion=11","tracteur");


    $depensesBennes = 
    $this->selectAccidentPourRapportGeneral("","camion_benne")+
    $this->selectDepensePneuPourRapportGeneral("","camion_benne")+
    $this->selectGazoilPourRapportGeneral("","camion_benne")+
    $this->selectVidangePourRapportGeneral("","camion_benne")+
    $this->selectPieceRechangePourRapportGeneral("","camion_benne")+
    $this->selectPrimePourRapportGeneral("","camion_benne")+
    $this->selectFraisRoutePourRapportGeneral("","camion_benne")+
    $this->selectFraisDiversPourRapportGeneral("","camion_benne")+
    $this->salaireGps("","camion_benne");


    $depensesNouveauxCalabrese = 
    $this->selectAccidentPourRapportGeneral("where id_type_camion=8","tracteur")+
    $this->selectDepensePneuPourRapportGeneral("where id_type_camion=8","tracteur")+
    $this->selectGazoilPourRapportGeneral("where id_type_camion=8","tracteur")+
    $this->selectVidangePourRapportGeneral("where id_type_camion=8","tracteur")+
    $this->selectPieceRechangePourRapportGeneral("where id_type_camion=8","tracteur")+

    $this->selectPrimePourRapportGeneral("where id_type_camion=8","tracteur")+
    $this->selectFraisRoutePourRapportGeneral("where id_type_camion=8","tracteur")+
    $this->selectFraisDiversPourRapportGeneral("where id_type_camion=8","tracteur")+
    $this->salaireGps("where id_type_camion=8","tracteur");

    // $depensesAnciensCalabrese = 
    // $this->selectAccidentPourRapportGeneral("where type='ancien' and id_type_camion=8","tracteur")+
    // $this->selectDepensePneuPourRapportGeneral("where type='ancien' and id_type_camion=8","tracteur")+
    // $this->selectGazoilPourRapportGeneral("where type='ancien' and id_type_camion=8","tracteur")+
    // $this->selectVidangePourRapportGeneral("where type='ancien' and id_type_camion=8","tracteur")+
    // $this->selectPieceRechangePourRapportGeneral("where type='ancien' and id_type_camion=2","tracteur")+
    // $this->selectPrimePourRapportGeneral("where type='ancien' and id_type_camion=8","tracteur")+
    // $this->selectFraisRoutePourRapportGeneral("where type='ancien' and id_type_camion=8","tracteur")+
    // $this->selectFraisDiversPourRapportGeneral("where type='ancien' and id_type_camion=8","tracteur");
    
    $depensesVraquier = 
    $this->selectAccidentPourRapportGeneral("","vraquier")+
    $this->selectDepensePneuPourRapportGeneral("","vraquier")+
    $this->selectGazoilPourRapportGeneral("","vraquier")+
    $this->selectVidangePourRapportGeneral("","vraquier")+
    $this->selectPieceRechangePourRapportGeneral("","vraquier")+
    $this->selectPrimePourRapportGeneral("","vraquier")+
    $this->selectFraisRoutePourRapportGeneral("","vraquier")+
    $this->selectFraisDiversPourRapportGeneral("","vraquier")+
    $this->salaireGps("","vraquier");

    $depensesVoitureService = 

    $this->selectAccidentPourRapportGeneral("","voitureservice")+
    $this->selectDepensePneuPourRapportGeneral("","voitureservice")+
    $this->selectGazoilPourRapportGeneral("","voitureservice")+
    $this->selectVidangePourRapportGeneral("","voitureservice")+
    $this->selectPieceRechangePourRapportGeneral("","voitureservice")+
    $this->selectPrimePourRapportGeneral("","voitureservice")+
    $this->selectFraisRoutePourRapportGeneral("","voitureservice")+
    $this->selectFraisDiversPourRapportGeneral("","voitureservice")+
    $this->salaireGps("","voitureservice");

    $depensesEngin = 

    $this->selectAccidentPourRapportGeneral("","engin")+
    $this->selectDepensePneuPourRapportGeneral("","engin")+
    $this->selectGazoilPourRapportGeneral("","engin")+
    $this->selectVidangePourRapportGeneral("","engin")+
    $this->selectPieceRechangePourRapportGeneral("","engin")+
    $this->selectPrimePourRapportGeneral("","engin")+
    $this->selectFraisRoutePourRapportGeneral("","engin")+
    $this->selectFraisDiversPourRapportGeneral("","engin")+
    $this->salaireGps("","engin");
    
    $resultatTracteur10 = $recetteTracteur10- $depensesTracteur10;

    $resultatTracteur6 = $recetteTracteur6- $depensesTracteur6;

    // $resultatAnciensCarosserie = $recetteAnciensCarosserie- $depensesAnciensCarosserie;

    $resultatNouveauxCarosserie = $recetteNouveauxCarosserie- $depensesNouveauxCarosserie;

    // $resultatAnciensCalabrese = $recetteAnciensCalabrese - $depensesAnciensCalabrese;

    $resultatNouveauxCalabrese = $recetteNouveauxCalabrese - $depensesNouveauxCalabrese;

    $resultatBennes = $recetteBennes- $depensesBennes;

    $resultatVraquier = $recetteVraquier - $depensesVraquier;

    $resultatVoitureService = $recetteVoitureService - $depensesVoitureService;

    $resultatEngin = $recetteEngin - $depensesEngin ;

    $totalRecette =$recetteTracteur10+$recetteTracteur6+$recetteNouveauxCarosserie+$recetteNouveauxCalabrese+$recetteBennes+$recetteVraquier+$recetteVoitureService+$recetteEngin;

    $totalDepense = $depensesEngin+$depensesVoitureService+$depensesVraquier+$depensesBennes+$depensesNouveauxCalabrese+$depensesNouveauxCarosserie+$depensesTracteur6+$depensesTracteur10;

    $totalResultat =$resultatEngin+ $resultatVoitureService+$resultatVraquier+$resultatBennes+$resultatNouveauxCalabrese+$resultatNouveauxCarosserie+$resultatTracteur6+$resultatTracteur10;

              
    echo "<tr>
            <td style='border: 1px solid black; font-weight:bold; border: 1px solid black; '>Recettes</td>
            <td style='border: 1px solid black;'>".number_format($recetteTracteur10,3,'.',' ')."</td>
            <td style='border: 1px solid black;'>".number_format($recetteTracteur6,3,'.',' ')."</td>
            <td style='border: 1px solid black;'>". number_format($recetteNouveauxCarosserie,3,'.',' ')."</td>
            <td style='border: 1px solid black;'>". number_format($recetteNouveauxCalabrese,3,'.',' ')."</td>

            <td style='border: 1px solid black;'>".number_format($recetteBennes,3,'.',' ')."</td>
            <td style='border: 1px solid black;'>".number_format($recetteVraquier,3,'.',' ')."</td>
            <td style='border: 1px solid black;'>".number_format($recetteVoitureService,3,'.',' ')."</td>
            <td style='border: 1px solid black;'>".number_format($recetteEngin,3,'.',' ')."</td>
            <td style='color: red;border: 1px solid black;'>".number_format($totalRecette,3,'.',' ')."</td>
          </tr>
          <tr>
            <td style='color: red;font-weight:bold; border: 1px solid black; '>Dépenses</td>
            <td style='border: 1px solid black;'>".number_format($depensesTracteur10,3,'.',' ')."</td>
            <td style='border: 1px solid black;'>".number_format($depensesTracteur6,3,'.',' ')."</td>
            <td style='border: 1px solid black;'>".number_format($depensesNouveauxCarosserie,3,'.',' ')."</td>
            <td style='border: 1px solid black;'>".number_format($depensesNouveauxCalabrese,3,'.',' ')."</td>

            <td style='border: 1px solid black;'>".number_format($depensesBennes,3,'.',' ')."</td>
            <td style='border: 1px solid black;'>".number_format($depensesVraquier,3,'.',' ')."</td>
            <td style='border: 1px solid black;'>".number_format($depensesVoitureService,3,'.',' ')."</td>
            <td style='border: 1px solid black;'>".number_format($depensesEngin,3,'.',' ')."</td>
            <td style='color: red;border: 1px solid black;'>".number_format($totalDepense,3,'.',' ')."</td>
          </tr>
          <tr>
            <td style='color: red; border: 1px solid black;font-weight:bold;'>Résultat</td>
            <td style='color: red;border: 1px solid black;'>".number_format($resultatTracteur10,3,'.',' ')."</td>
            <td style='color: red;border: 1px solid black;'>".number_format($resultatTracteur6,3,'.',' ')."</td>
            <td style='color: red;border: 1px solid black;'>".number_format($resultatNouveauxCarosserie,3,'.',' ')."</td>
            <td style='color: red;border: 1px solid black;'>".number_format($resultatNouveauxCalabrese,3,'.',' ')."</td>

            <td style='color: red;border: 1px solid black;'>".number_format($resultatBennes,3,'.',' ')."</td>
            <td style='color: red;border: 1px solid black;'>".number_format($resultatVraquier,3,'.',' ')."</td>
            <td style='color: red;border: 1px solid black;'>".number_format($resultatVoitureService,3,'.',' ')."</td>
            <td style='color: red;border: 1px solid black;'>".number_format($resultatEngin,3,'.',' ')."</td>
            <td style='color: red;border: 1px solid black;'>".number_format($totalResultat,3,'.',' ')."</td>
          </tr>";

}

 }