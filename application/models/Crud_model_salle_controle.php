<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model_salle_controle extends CI_Model {
// 
    function __construct() {
        parent::__construct();
        // $this->load->database('default');
        $this->load->library('session');
        // $this->load->helper('app_gui_helper');
        $this->load->helper('cookie');
        $this->load->helper('url');
        // $this->session->set_userdata('language_abbr', "en"); 
        date_default_timezone_set('Africa/Lagos');
    }

    public function addPourcentage(){
        $date = $_POST["date"];
        $clinker = $_POST["clinker"];
        $gypse = $_POST["gypse"];
        $pouzolande = $_POST["pouzolande"];
        $status = $_POST["status"];
       
        if ($status =="insert") {
            # code...

                    $query1 = $this->db->query("INSERT into pourcentage value('',CAST('". $date."' AS DATE),now(),".$clinker.",".$gypse.",".$pouzolande.")");
                            if($query1 == true){
                                echo "Insertion parfaite des pourcentages";
                            }else{
                                echo "Erreur durant l'insertion";
                            }
        }elseif($status == "update"){
            # code...
            $id_client =$_POST["id_client"];
              
                            $query1 = $this->db->query("UPDATE pourcentage set date_p=CAST('". $date."' AS DATE), clinker=".$clinker.",gypse=".$gypse.",pouzolande=".$pouzolande." where ref=".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite des pourcentages";
                            }else{
                                echo "Erreur durant l'insertion";
                }
        }else{
            echo "Erreur contactez l'administrateur ".$status ;
        }
        
    }

    public function addPourcentageGypse(){
        $date = $_POST["date"];
        // $heure = $_POST["heure"];
        $gypse = $_POST["gypse"];
        $occurence = $_POST["occurence"];
        $status = $_POST["status"];
       
        if ($status =="insert") {
            # code...

         $query1 = $this->db->query("INSERT into pourcentage_gypse value('',CAST('". $date."' AS DATE),".$gypse.",".$occurence.")");
                            if($query1 == true){
                                echo "Insertion parfaite du pourcentage";
                            }else{
                                echo "Erreur durant l'insertion";
                            }
        }elseif($status == "update"){
            # code...
            $id_client =$_POST["id_client"];
              
            $query1 = $this->db->query("UPDATE pourcentage_gypse set date_p=CAST('". $date."' AS DATE),gypse=".$gypse.",occurence=".$occurence." where ref=".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du pourcentage";
                            }else{
                                echo "Erreur durant l'insertion";
                }
        }else{
            echo "Erreur contactez l'administrateur ".$status ;
        }
        
    }

    public function selectAllPourcentage(){
              $query1 = $this->db->query('SELECT * from pourcentage order by date_p desc')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['date_p']."</td>
                    <td>".$row['heure']."</td>
                    <td>".$row['clinker']."</td>
                    <td>".$row['gypse']."</td>
                    <td>".$row['pouzolande']."</td>
                    <td>";
                    
                    echo"<button type='button' onclick=\"infosPourcentage('".$row['ref']."','".$row['date_p']."','".$row['clinker']."','".$row['gypse']."','".$row['pouzolande']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
              
                    echo"
                        <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='pourcentage' identifiant='".$row['ref']."' onclick='demandeSuppressionTransporteur($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"ref\");'><i class='far fa-trash-alt'></i></button>
                        </td>
                      </tr>

                      ";

                  $compteur++;
        }
    }

public function selectAllPourcentageGypse(){
              $query1 = $this->db->query('SELECT * from pourcentage_gypse order by date_p desc')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['date_p']."</td>
                    
                    <td>".$row['gypse']."</td>
                    <td>".$row['occurence']."</td>
                    <td>";
                    
                    echo"<button type='button' onclick=\"infosPourcentageGypse('".$row['ref']."','".$row['date_p']."','".$row['gypse']."','".$row['occurence']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
              
                    echo"
                        <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='pourcentage_gypse' identifiant='".$row['ref']."' onclick='demandeSuppressionTransporteur($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"ref\");'><i class='far fa-trash-alt'></i></button>
                        </td>
                      </tr>

                      ";

                  $compteur++;
        }
    }


public function addPourcentageClinker(){
        $date = $_POST["date"];
        // $heure = $_POST["heure"];
        $gypse = $_POST["clinker"];
        $occurence = $_POST["occurence"];
        $status = $_POST["status"];
       
        if ($status =="insert") {
            # code...

         $query1 = $this->db->query("INSERT into pourcentage_clinker value('',CAST('". $date."' AS DATE),".$gypse.",".$occurence.")");
                            if($query1 == true){
                                echo "Insertion parfaite du pourcentage";
                            }else{
                                echo "Erreur durant l'insertion";
                            }
        }elseif($status == "update"){
            # code...
            $id_client =$_POST["id_client"];
              
            $query1 = $this->db->query("UPDATE pourcentage_clinker set date_p=CAST('". $date."' AS DATE),clinker=".$gypse.",occurence=".$occurence." where ref=".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du pourcentage";
                            }else{
                                echo "Erreur durant l'insertion";
                }
        }else{
            echo "Erreur contactez l'administrateur ".$status ;
        }
        
    }


public function selectAllPourcentageClinker(){
              $query1 = $this->db->query('SELECT * from pourcentage_clinker order by date_p desc')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['date_p']."</td>
                    <td>".$row['clinker']."</td>
                    <td>".$row['occurence']."</td>
                    <td>";
                    
                    echo"<button type='button' onclick=\"infosPourcentageGypse('".$row['ref']."','".$row['date_p']."','".$row['clinker']."','".$row['occurence']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
              
                    echo"
                        <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='pourcentage_clinker' identifiant='".$row['ref']."' onclick='demandeSuppressionTransporteur($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"ref\");'><i class='far fa-trash-alt'></i></button>
                        </td>
                      </tr>

                      ";

                  $compteur++;
        }
    }





public function addPourcentagePouzolande(){
        $date = $_POST["date"];
        // $heure = $_POST["heure"];
        $gypse = $_POST["clinker"];
        $occurence = $_POST["occurence"];
        $status = $_POST["status"];
       
        if ($status =="insert") {
            # code...

         $query1 = $this->db->query("INSERT into pourcentage_pouzolande value('',CAST('". $date."' AS DATE),".$gypse.",".$occurence.")");
                            if($query1 == true){
                                echo "Insertion parfaite du pourcentage";
                            }else{
                                echo "Erreur durant l'insertion";
                            }
        }elseif($status == "update"){
            # code...
            $id_client =$_POST["id_client"];
              
            $query1 = $this->db->query("UPDATE pourcentage_pouzolande set date_p=CAST('". $date."' AS DATE),pouzolande=".$gypse.",occurence=".$occurence." where ref=".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du pourcentage";
                            }else{
                                echo "Erreur durant l'insertion";
                }
        }else{
            echo "Erreur contactez l'administrateur ".$status ;
        }
        
    }


public function addTempsArret(){
        $date = $_POST["date"];
        $heure_debut = $_POST["heure_debut"];
        $heure_fin = $_POST["heure_fin"];
        $cause = addslashes($_POST["cause"]);
        // $libelle = $_POST["libelle"];
        $status = $_POST["status"];
       
        if ($status =="insert") {
            # code...

         $query1 = $this->db->query("INSERT into tempsArret value('',CAST('". $date."' AS DATE),CAST('". $heure_debut."' AS TIME),CAST('". $heure_fin."' AS TIME),'".$cause."')");
                            if($query1 == true){
                                echo "Insertion parfaite du temps d'arret";
                            }else{
                                echo "Erreur durant l'insertion";
                            }
        }elseif($status == "update"){
            # code...
            $id_client =$_POST["id_client"];
              
            $query1 = $this->db->query("UPDATE tempsArret set date_temps=CAST('". $date."' AS DATE), heure_debut=CAST('". $heure_debut."' AS TIME), heure_fin=CAST('". $heure_fin."' AS TIME), cause='".$cause."' where ref=".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du temps d'arret";
                            }else{
                                echo "Erreur durant l'insertion";
                }
        }else{
            echo "Erreur contactez l'administrateur ".$status ;
        }
        
    }


public function selectAllTempsArret(){
              $query1 = $this->db->query('SELECT * from tempsArret order by date_temps desc')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            $h1 = strtotime($row['heure_debut']);
            $h2 = strtotime($row['heure_fin']);
             $duree = gmdate("H:i:s",$h2-$h1);

            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['date_temps']."</td>
                    <td>".$row['heure_debut']."</td>
                    <td>".$row['heure_fin']."</td>
                    <td>".$duree."</td>
                    
                    <td>".$row['cause']."</td>
                    <td>";
                    
                    echo"<button type='button' onclick=\"infosTempsArret('".$row['ref']."','".$row['date_temps']."','".$row['heure_debut']."','".$row['heure_fin']."','".$row['cause']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
              
                    echo"
                        <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='tempsArret' identifiant='".$row['ref']."' onclick='demandeSuppressionTransporteur($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"ref\");'><i class='far fa-trash-alt'></i></button>
                        </td>
                      </tr>

                      ";

                  $compteur++;
        }
}


public function selectAllRapportTempsArret(){

    if (isset($_POST["date_debut"]) && isset($_POST["date_fin"])) {
        # code...
        $date_debut = $_POST["date_debut"];
         $date_fin = $_POST["date_fin"];

         $query1 = $this->db->query('SELECT * from tempsArret where date_temps between "'.$date_debut.'" and "'.$date_fin.'" order by date_temps asc')->result_array();
    }else{
        $query1 = $this->db->query('SELECT * from tempsArret order by date_temps asc')->result_array();
    }
         
        $compteur = 0;
        $totalDure =0;
        $totalMin =0;
        $totalSec =0;
        foreach ($query1 as $row) {
            # code...
           $debut = explode(":",$row['heure_debut']);
           $fin = explode(":",$row['heure_fin']); 

           // $texte = explode("-",$texte1[1]); 
          

            $h1 = strtotime($row['heure_debut']);
            $h2 = strtotime($row['heure_fin']);
            $duree = gmdate("H:i:s", $h2-$h1);

            $totalDure1 = explode(":",$duree);
            $totalDure = $totalDure1[0] + $totalDure;
            $totalMin = $totalDure1[1] + $totalMin;
            $totalsec = $totalDure1[2] + $totalSec;


             // $totalDure= gmdate("H:i:s", strtotime($totalDure)-$duree);
            
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['date_temps']."</td>
                    <td>".$row['heure_debut']."</td>
                    <td>".$row['heure_fin']."</td>
                    <td>".$duree."</td>
                   
                    <td>".$row['cause']."</td>
                      </tr>

                      ";

                  $compteur++;
        }
        if ($totalMin>59) {
        # code...
        $totalMin1=$totalMin;
        $totalHeure1 = $totalMin/60;
        $totalmin1 = $totalHeure1 - intval($totalHeure1);
        $totalDure = $totalDure + intval($totalHeure1);
        $totalmin1 = round($totalmin1*60);
        // $totalMin = $totalMin + $totalmin1;
      }else{
        $totalmin1=$totalMin;
        if ($totalmin1<10) {
            # code...
            $totalmin1 = "0".$totalmin1;
        }
      }

            if ($totalmin1<10) {
            # code...
            $totalmin1 = "0".$totalmin1;
        }
        if ($totalDure < 10) {
                # code...
                 $totalDure =  "0".$totalDure;
            }
        if ($totalsec<10) {
            # code...
            $totalsec = "0".$totalsec;
        }
        echo "<tr >
                    <td onclick=\"creerDatable();\"  style='color: red'>TOTAL DUREE</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style='color: red'>".$totalDure.":".$totalmin1.":".$totalsec."</td>
                    <td></td>
                    <td></td>
                      </tr>

                      ";
}

public function selectAllPourcentagePouzolande(){
              $query1 = $this->db->query('SELECT * from pourcentage_pouzolande order by date_p desc')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['date_p']."</td>
                   
                    <td>".$row['pouzolande']."</td>
                    <td>".$row['occurence']."</td>
                    <td>";
                    
                    echo"<button type='button' onclick=\"infosPourcentageGypse('".$row['ref']."','".$row['date_p']."','".$row['pouzolande']."','".$row['occurence']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
              
                    echo"
                        <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='pourcentage_pouzolande' identifiant='".$row['ref']."' onclick='demandeSuppressionTransporteur($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"ref\");'><i class='far fa-trash-alt'></i></button>
                        </td>
                      </tr>

                      ";

                  $compteur++;
        }
    }


public function selectMoyennePourcentage(){
    $date = $_POST["date"];

    $query = $this->db->query("SELECT * from pourcentage_gypse where date_p = '".$date."'")->result_array();

    $query1 = $this->db->query("SELECT * from pourcentage_clinker where date_p = '".$date."'")->result_array();

    $query2 = $this->db->query("SELECT * from pourcentage_pouzolande where date_p = '".$date."'")->result_array();

    if (count($query)>0 && count($query1)>0 && count($query2)>0) {
        # code...
        // $Pclinker = 0;
        // $Pgypse = 0;
        // $Ppouzolande = 0;
        // foreach ($query as $row) {
          
        //     $Pgypse = $row['gypse'] + $Pgypse;
        // }

        // foreach ($query1 as $row) {
        //     # code...
        //     $Pclinker = $row['clinker'] + $Pclinker;
        // }

        // foreach ($query2 as $row) {

        //     $Ppouzolande = $row['pouzolande'] + $Ppouzolande;
        // }


        // $Mclinker = $Pclinker/count($query);
        // $Mgypse = $Pgypse/count($query);
        // $Mpouzolande = $Ppouzolande/count($query);


        $Pclinker = 0;
        $Pgypse = 0;
        $Ppouzolande = 0;
        $occurence = 0;
        $occurence1 = 0;
        $occurence2 = 0;
        foreach ($query as $row) {
          
            $Pgypse = ($row['gypse']*$row['occurence']) + $Pgypse;
            $occurence = $row['occurence'] + $occurence;
        }

        foreach ($query1 as $row) {
            # code...
            $Pclinker = ($row['clinker']*$row['occurence']) + $Pclinker;
            $occurence1 = $row['occurence'] + $occurence1;
        }

        foreach ($query2 as $row) {

            $Ppouzolande = ($row['pouzolande']*$row['occurence']) + $Ppouzolande;
            $occurence2 = $row['occurence'] + $occurence2;
        }


        $Mclinker = $Pclinker/$occurence;
        $Mgypse = $Pgypse/$occurence1;
        $Mpouzolande = $Ppouzolande/$occurence2;

                      echo '<div class="col-md-3">
                                <label>%Clinker</label>
                                <input type="text" class="form-control Pclinker" value="'.number_format($Mclinker,5,'.','').'" placeholder="%Clinker"  onkeypress="chiffres(event);" disabled="true">
                                
                              </div>

                              <div class="col-md-3">
                                <label>%Gypse</label>
                                <input type="text" class="form-control Pgypse" value="'.number_format($Mgypse,5,'.','').'" placeholder="%Gypse" onkeypress="chiffres(event); " disabled="true">

                              </div>

                              <div class="col-md-3">
                                <label>%Pouzolande</label>
                                <input type="text" class="form-control Ppouzolande" value="'.number_format($Mpouzolande,5,'.','').'" placeholder="%Pouzolande" onkeypress="chiffres(event);" disabled="true">

                              </div>';

    }else{
        echo '<div class="col-md-3">
                                <label>%Clinker</label>
                                <input type="text" class="form-control Pclinker" value="0" placeholder="%Clinker"  onkeypress="chiffres(event);" disabled="true">
                                
                              </div>

                              <div class="col-md-3">
                                <label>%Gypse</label>
                                <input type="text" class="form-control Pgypse" value="0" placeholder="%Gypse" onkeypress="chiffres(event);" disabled="true">

                              </div>

                              <div class="col-md-3">
                                <label>%Pouzolande</label>
                                <input type="text" class="form-control Ppouzolande" value="0" placeholder="%Pouzolande" onkeypress="chiffres(event);" disabled="true">

                              </div>';
    }

 }


 public function selectQtiteMatiere(){
    $date = $_POST["date"];
    $qtiteCiment = $_POST["qtiteCiment"];
    $query = $this->db->query("SELECT * from pourcentage_gypse where date_p = '".$date."'")->result_array();

    $query1 = $this->db->query("SELECT * from pourcentage_clinker where date_p = '".$date."'")->result_array();

    $query2 = $this->db->query("SELECT * from pourcentage_pouzolande where date_p = '".$date."'")->result_array();

$occurence = 0;
        $occurence1 = 0;
        $occurence2 = 0;

    if (count($query)>0 && count($query1)>0 && count($query2)>0) {
        # code...
        $Pclinker = 0;
        $Pgypse = 0;
        $Ppouzolande = 0;

         foreach ($query as $row) {
          
            $Pgypse = ($row['gypse']*$row['occurence']) + $Pgypse;
            $occurence = $row['occurence'] + $occurence;
        }

        foreach ($query1 as $row) {
            # code...
            $Pclinker = ($row['clinker']*$row['occurence']) + $Pclinker;
            $occurence1 = $row['occurence'] + $occurence1;
        }

        foreach ($query2 as $row) {

            $Ppouzolande = ($row['pouzolande']*$row['occurence']) + $Ppouzolande;
            $occurence2 = $row['occurence'] + $occurence2;
        }

        $Mclinker = number_format($Pclinker/$occurence,5,'.','');
        $Mgypse = number_format($Pgypse/$occurence1,5,'.','');
        $Mpouzolande = number_format($Ppouzolande/$occurence2,5,'.','');

        $qtiteClinker = ($qtiteCiment*$Mclinker)/100;
        $qtiteGypse = ($qtiteCiment*$Mgypse)/100;
        $qtitePouzolande = ($qtiteCiment*$Mpouzolande)/100;

                      echo '<div class="col-md-3">
                                <label>Qtite Clinker</label>
                                <input type="text" class="form-control qtiteClinker" value="'.number_format($qtiteClinker,5,'.','').'" placeholder="%Clinker"  onkeypress="chiffres(event);" disabled="true">
                                
                              </div>

                              <div class="col-md-3">
                                <label>Qtite Gypse</label>
                                <input type="text" class="form-control qtiteGypse" value="'.number_format($qtiteGypse,5,'.','').'" placeholder="%Gypse" onkeypress="chiffres(event); " disabled="true">

                              </div>

                              <div class="col-md-3">
                                <label>Qtite Pouzolande</label>
                                <input type="text" class="form-control qtitePouzolande" value="'.number_format($qtitePouzolande,5,'.','').'" placeholder="%Pouzolande" onkeypress="chiffres(event);" disabled="true">

                              </div>';


             //                    echo "<script type=\"text/javascript\">
             //    Mclinker = ".$Pclinker."/".$occurence.";
             //    Mgypse = ".$Pgypse."/".$occurence1.";
             //    Mpouzolande = ".$Ppouzolande."/".$occurence2.";
             //    qtiteClinker = (".$qtiteCiment."*Mclinker)/100;
             //    qtiteGypse = (".$qtiteCiment."*Mgypse)/100;
             //    qtitePouzolande = (".$qtiteCiment."*Mpouzolande)/100;

             //    $('.qtiteClinker').val(89.16667*895);
             //    $('.qtiteGypse').val(qtiteGypse);
             //    $('.qtitePouzolande').val(qtitePouzolande);
             // </script>";
             //          echo '<div class="col-md-3">
             //                    <label>Qtite Clinker</label>
             //                    <input type="text" class="form-control qtiteClinker" value="" placeholder="%Clinker"  onkeypress="chiffres(event);" disabled="true">
                                
             //                  </div>

             //                  <div class="col-md-3">
             //                    <label>Qtite Gypse</label>
             //                    <input type="text" class="form-control qtiteGypse" value="" placeholder="%Gypse" onkeypress="chiffres(event); " disabled="true">

             //                  </div>

             //                  <div class="col-md-3">
             //                    <label>Qtite Pouzolande</label>
             //                    <input type="text" class="form-control qtitePouzolande" value="" placeholder="%Pouzolande" onkeypress="chiffres(event);" disabled="true">

             //                  </div>';

    }else{
        echo '<div class="col-md-3">
                                <label>Qtite Clinker</label>
                                <input type="text" class="form-control qtiteClinker" value="0" placeholder="%Clinker"  onkeypress="chiffres(event);" disabled="true">
                                
                              </div>

                              <div class="col-md-3">
                                <label>Qtite Gypse</label>
                                <input type="text" class="form-control qtiteGypse" value="0" placeholder="%Gypse" onkeypress="chiffres(event);" disabled="true">

                              </div>

                              <div class="col-md-3">
                                <label>Qtite Pouzolande</label>
                                <input type="text" class="form-control qtitePouzolande" value="0" placeholder="%Pouzolande" onkeypress="chiffres(event);" disabled="true">

                              </div>';
    }

 }


 public function addmputilise(){
        $date = $_POST["date"];

        $cimentCharge= $_POST["cimentCharge"];

        $flux = $_POST["flux"];
        $Pclinker = $_POST["Pclinker"];
        $Pgypse = $_POST["Pgypse"];
        $Ppouzolande = $_POST["Ppouzolande"];

        $qtiteClinker = $_POST["qtiteClinker"];
        $qtiteGypse = $_POST["qtiteGypse"];
        $qtitePouzolande = $_POST["qtitePouzolande"];

        $qtiteCiment = $_POST["qtiteCiment"];
        $status = $_POST["status"];
       
       // echo $qtiteClinker;
        if ($status =="insert") {
            # code...

         $query1 = $this->db->query("INSERT into mputilise value('',CAST('". $date."' AS DATE),".$qtiteCiment.",".$Pclinker.",".$Pgypse.",".$Ppouzolande.",".$qtiteClinker.",".$qtiteGypse.",".$qtitePouzolande.",".$cimentCharge.",'".$flux."')");
                            if($query1 == true){
                                echo "Insertion parfaite";
                            }else{
                                echo "Erreur durant l'insertion";
                            }
        }elseif($status == "update"){
            # code...
            $id_client =$_POST["id_client"];
              
                            $query1 = $this->db->query("UPDATE mputilise set date_m=CAST('". $date."' AS DATE), Mclinker=".$Pclinker.",Mgypse=".$Pgypse.",Mpouzolande=".$Ppouzolande.", qtiteClinker=".$qtiteClinker.",qtiteGypse=".$qtiteGypse.",qtitePouzolande=".$qtitePouzolande.",qtiteCiment=".$qtiteCiment.", cimentCharge = ".$cimentCharge.",flux='".$flux."' where ref=".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite";
                            }else{
                                echo "Erreur durant l'insertion";
                }
        }else{
            echo "Erreur contactez l'administrateur ".$status ;
        }
        
    }


public function selectAllmputilise(){
              $query1 = $this->db->query('SELECT * from mputilise order by date_m desc')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['date_m']."</td>
                    <td>".$row['qtiteCiment']."</td>
                    <td>".$row['Mclinker']."</td>
                    <td>".$row['Mgypse']."</td>
                    <td>".$row['Mpouzolande']."</td>
                    <td>".$row['qtiteClinker']."</td>
                    <td>".$row['qtiteGypse']."</td>
                    <td>".$row['qtitePouzolande']."</td>
                    <td>".$row['cimentCharge']."</td>
                    <td>".$row['flux']."</td>
                    <td>";
                    
                    echo"<button type='button' onclick=\"infosmputilise('".$row['ref']."','".$row['cimentCharge']."','".$row['flux']."','".$row['date_m']."','".$row['Mclinker']."','".$row['Mgypse']."','".$row['Mpouzolande']."','".$row['qtiteClinker']."','".$row['qtiteGypse']."','".$row['qtitePouzolande']."','".$row['qtiteCiment']."'); selectQtiteMatiere($('.date').val(),$('.qtiteCiment').val()); getMoyennePourcentage($('.date').val());\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
              
                    echo"
                        <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='mputilise' identifiant='".$row['ref']."' onclick='demandeSuppressionTransporteur($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"ref\");'><i class='far fa-trash-alt'></i></button>
                        </td>
                      </tr>

                      ";

                  $compteur++;
        }
    }


    public function selectAllRapportmputilise2(){
        $date_debut = $_POST["date_debut"];
    $date_fin = $_POST["date_fin"];

              $query1 = $this->db->query("SELECT * from mputilise where date_m between '". $date_debut."' and '". $date_fin."' order by date_m desc")->result_array();
        $compteur = 0;
        $totalCiment =0;
        $totalClinker = 0;
        $totalGypse = 0;
        $totalPouzzolande =0;

        $totalMCiment =0;
        $totalMClinker = 0;
        $totalMGypse = 0;
        $totalMPouzzolande =0;
        $totalCimentCharge = 0;
        $total1 = 0;
        $totalSacDechire =0;
        foreach ($query1 as $row) {
            # code...
            $total =$row['qtiteClinker']+$row['qtiteGypse']+$row['qtitePouzolande'];
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['date_m']."</td>
                    <td>".$row['qtiteCiment']."</td>
                    <td>".$row['Mclinker']."</td>
                    <td>".$row['Mgypse']."</td>
                    <td>".$row['Mpouzolande']."</td>
                    
                    <td>".$row['qtiteClinker']."</td>
                    <td>".$row['qtiteGypse']."</td>
                    <td>".$row['qtitePouzolande']."</td>
                    
                    <td>".$row['cimentCharge']."</td>
                    <td>".$row['flux']."</td>
                    <td>".$this->getNbreSacsDechire($row['date_m'])."</td>
                    <td>".$total."</td>
                      </tr>

                      ";
        $total1 = $total1 + $total;
        $totalCiment =$totalCiment + $row['qtiteCiment'];
        $totalClinker = $totalClinker + $row['qtiteClinker'];
        $totalGypse = $totalGypse + $row['qtiteGypse'];
        $totalPouzzolande = $totalPouzzolande + $row['qtitePouzolande'];

        $totalMClinker = $totalMClinker + $row['Mclinker'];
        $totalMGypse = $totalMGypse + $row['Mgypse'];
        $totalMPouzzolande = $totalMPouzzolande + $row['Mpouzolande'];

        $totalCimentCharge = $totalCimentCharge + $row['cimentCharge'];
                  $compteur++;
        $totalSacDechire = $totalSacDechire + $this->getNbreSacsDechire($row['date_m']);
        }


        echo "<tr >
                    <td style='color: red'>TOTAL</td>
                    <td> </td>
                    <td style='color: red'>".$totalCiment."</td>
                    <td style='color: red'>".$totalMClinker."</td>
                    <td style='color: red'>".$totalMGypse."</td>
                    <td style='color: red'>".$totalMPouzzolande."</td>

                    <td style='color: red'>".$totalClinker."</td>
                    <td style='color: red'>".$totalGypse."</td>
                    <td style='color: red'>".$totalPouzzolande."</td>
                    <td style='color: red'>".$totalCimentCharge."</td>
                    <td> </td>
                    <td style='color: red'>".$totalSacDechire."</td>
                    <td style='color: red'>".$total1."</td>
                      </tr>

                      ";
    }

    public function getNbreSacsDechire($date){
        $query = $this->db->query("SELECT * from suivi_jour where date_suivi='".$date."'")->result_array();
        $qtite = 0;
        if (count($query) > 0) {
            foreach ($query as $row) {
                # code...
                $qtite = $row['qtiteDech'] + $qtite;
            }
        }

        return $qtite;
    }
    public function selectAllRapportmputilise(){
              $query1 = $this->db->query('SELECT * from mputilise order by date_m asc')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            $total =$row['qtiteClinker']+$row['qtiteGypse']+$row['qtitePouzolande'];
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['date_m']."</td>
                    <td>".$row['qtiteCiment']."</td>
                    <td>".$row['Mclinker']."</td>
                    <td>".$row['Mgypse']."</td>
                    <td>".$row['Mpouzolande']."</td>
                    <td>".$row['qtiteClinker']."</td>
                    <td>".$row['qtiteGypse']."</td>
                    <td>".$row['qtitePouzolande']."</td>
                    <td>".$row['cimentCharge']."</td>
                    <td>".$row['flux']."</td>
                    <td>".$this->getNbreSacsDechire($row['date_m'])."</td>
                    <td>".$total."</td>
                   
                      </tr>

                      ";

                  $compteur++;
        }
    }
}