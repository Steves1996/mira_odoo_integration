<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model_document extends CI_Model {
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

    public function addDocument($type, $lieu, $numero, $dateEffet){
        $query2 = $this->db->query("select * from ".$type." where numero='".$numero."'")->result_array();

        $nom_table = $type;
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté le document ".$type.", de numéro ".$numero."  le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié le document ".$type.", de numéro ".$numero."  le ".$date_notif." à ".$heure;

        if (count($query2) > 0 ) {
            # code...
            echo "Ce numero est déjà utilisé veuillez le changer";
        }else{
          $query1 = $this->db->query("insert into ".$type." value('','". $numero. "',CAST('". $dateEffet."' AS DATE),default,CAST('". $lieu."' AS DATE))");
                    if($query1 == true){
                        echo "Insertion parfaite du document";
                        $this->notificationAjout($nom_table,addslashes($message));
                    }else{
                        echo "Erreur durant l'insertion";
                    }    
        }

        $this->db->close();
        
    }

    public function updateDocument($table,$lieu,$numero,$dateEffet,$identifiant,$id_table){
        // echo "la table est : ".$table; 
        $nom_table = $table;
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté le document ".$table.", de numéro ".$numero."  le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié le document ".$table.", de numéro ".$numero."  le ".$date_notif." à ".$heure;

         $query2 = $this->db->query("select * from ".$table." where numero='".$numero."'")->result_array();
        if (count($query2) > 0 ) {
            # code...
            foreach ($query2 as $row) {
                # code...
                if ($row[$id_table] == $identifiant) {
                    # code...
                     $query1 = $this->db->query("UPDATE ".$table." set expiration =CAST('". $lieu."' AS DATE), numero = '".$numero."', date_effet =CAST('". $dateEffet."' AS DATE), duree=default where ".$id_table." =".$identifiant."");
                    if($query1 == true){
                        echo "Modification parfaite du document";
                        $this->notificationAjout($nom_table,addslashes($message2));
                    }else{
                        echo "Erreur de modification";
                    }
                }else{
                    echo "Ce numero est déjà utilisé veuillez le changer";
                }

            }
            
        }else{
          $query1 = $this->db->query("UPDATE ".$table." set expiration =CAST('". $lieu."' AS DATE), numero = '".$numero."', date_effet =CAST('". $dateEffet."' AS DATE), duree=default where ".$id_table." =".$identifiant."");
                    if($query1 == true){
                        echo "Modification parfaite du document";
                        $this->notificationAjout($nom_table,addslashes($message2));
                    }else{
                        echo "Erreur durant l'insertion";
                    }    
        }

        $this->db->close();
    }

    public function getCodeVehiculeUseDocument($champ_id,$value){
        $verifChamp = $this->db->query("SHOW COLUMNS FROM voitureservice LIKE '".$champ_id."'")->row();

        $requete1 =$this->db->query("select * from camion_benne where ".$champ_id."=".$value."")->result_array();
        $requete = $this->db->query("select * from tracteur where ".$champ_id."=".$value."")->result_array();
        $service =false;

        if (count($verifChamp)>0) {
            # code...
            $requete2 = $this->db->query("select * from voitureservice where ".$champ_id."=".$value."")->result_array();
            $service = true;
        }
        
        if (count($requete)>0) {
            # code...
            foreach ($requete as $tab) {
                # code...
                echo "<td>".$tab["code"]."</td>";
            }
        }elseif (count($requete1) >0) {
                # code...
                foreach ($requete1 as $tab) {
                    # code...
                    echo "<td>".$tab["code"]."</td>";
                }
            }
        elseif ($service == true) {
            # code...
                if (count($requete2)>0) {
                    # code...
                    foreach ($requete2 as $tab) {
                    # code...
                    echo "<td>".$tab["code"]."</td>";
                }
            }else{
                echo "<td></td>"; 
            }
            
        }else{
            
                echo "<td></td>"; 
            
        }
        $this->db->close();
    }
    public function selectAllCarteGrise(){
        $query1 = $this->db->get_where('carte_grise')->result_array();
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$row['numero']."</td>
                    <td>".$row['date_effet']."
                    </td>
                    <td>".$row['duree']."</td>
                    <td> ".$row['expiration']."</td>";
                    $query2 =$this->db->query("select id_carte_grise from remorque where id_carte_grise=".$row['id_carte_grise']."")->result_array();
                    if (count($query2) > 0) {
                        echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                    }else{
                            $query3 =$this->db->query("select id_carte_grise from camion_benne where id_carte_grise=".$row['id_carte_grise']."")->result_array();
                            $query0 =$this->db->query("select id_carte_grise from voitureservice where id_carte_grise=".$row['id_carte_grise']."")->result_array();
                            $query4 =$this->db->query("select id_carte_grise from engin where id_carte_grise=".$row['id_carte_grise']."")->result_array();
                        if (count($query3) > 0) {
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }elseif (count($query0)>0) {
                            # code...
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }elseif (count($query4)>0) {
                            # code...
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }
                        else{
                             $query4 =$this->db->query("select id_carte_grise from tracteur where id_carte_grise=".$row['id_carte_grise']."")->result_array();
                        if (count($query4) > 0) {
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }else{
                            echo "<td> <a class='btn btn-success btn-sm' href='#'>
                              <i class='fas fa-times'></i> Free</a></td>";
                        }
                        }
                    }
                    $this->getCodeVehiculeUseDocument("id_carte_grise",$row['id_carte_grise']);
                    echo "<td>";

            if($this->session->userdata('vehicule_modification')=='true'){
                    echo"<button type='button' onclick='infoDocument(\"".$row['date_effet']."\",\"".$row['expiration']."\",\"".$row['numero']."\",".$row['id_carte_grise'].",\"carte_grise\",\"id_carte_grise\");' class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }
            if($this->session->userdata('vehicule_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='carte_grise' identifiant='".$row['id_carte_grise']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_carte_grise\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
        }
        $this->db->close();
    }
    public function selectAllAssurance(){
        $query1 = $this->db->get_where('assurance')->result_array();
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$row['numero']."</td>
                    <td>".$row['date_effet']."
                    </td>
                    <td>".$row['duree']."</td>
                    <td> ".$row['expiration']."</td>";
                    $query2 =$this->db->query("select id_assurance from remorque where id_assurance=".$row['id_assurance']."")->result_array();
                    if (count($query2) > 0) {
                        echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                    }else{
                            $query3 =$this->db->query("select id_assurance from camion_benne where id_assurance=".$row['id_assurance']."")->result_array();
                            $query0 =$this->db->query("select id_assurance from voitureservice where id_assurance=".$row['id_assurance']."")->result_array();
                            $query4 =$this->db->query("select id_assurance from engin where id_assurance=".$row['id_assurance']."")->result_array();
                        if (count($query3) > 0) {
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }elseif (count($query0)>0) {
                            # code...
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }elseif (count($query4)>0) {
                            # code...
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }else{
                             $query4 =$this->db->query("select id_assurance from tracteur where id_assurance=".$row['id_assurance']."")->result_array();
                        if (count($query4) > 0) {
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }else{
                            echo "<td> <a class='btn btn-success btn-sm' href='#'>
                              <i class='fas fa-times'></i> Free</a></td>";
                        }
                        }
                    }
                    $this->getCodeVehiculeUseDocument("id_assurance",$row['id_assurance']);
                    echo "
                    <td>";
            if($this->session->userdata('vehicule_modification')=='true'){
                    echo"<button type='button' onclick='infoDocument(\"".$row['date_effet']."\",\"".$row['expiration']."\",\"".$row['numero']."\",".$row['id_assurance'].",\"assurance\",\"id_assurance\");' class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }
            if($this->session->userdata('vehicule_modification')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='assurance' identifiant='".$row['id_assurance']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_assurance\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
        }

        $this->db->close();

    }
     public function selectAllCarteBleue(){
        $query1 = $this->db->get_where('carte_bleue')->result_array();
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$row['numero']."</td>
                    <td>".$row['date_effet']."
                    </td>
                    <td>".$row['duree']."</td>
                    <td> ".$row['expiration']."</td>";
                    $query2 =$this->db->query("select id_carte_bleue from remorque where id_carte_bleue=".$row['id_carte_bleue']."")->result_array();
                    if (count($query2) > 0) {
                        echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                    }else{
                            $query3 =$this->db->query("select id_carte_bleue from camion_benne where id_carte_bleue=".$row['id_carte_bleue']."")->result_array();
                           
                        if (count($query3) > 0) {
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }else{
                             $query4 =$this->db->query("select id_carte_bleue from tracteur where id_carte_bleue=".$row['id_carte_bleue']."")->result_array();
                        if (count($query4) > 0) {
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }else{
                            echo "<td> <a class='btn btn-success btn-sm' href='#'>
                              <i class='fas fa-times'></i> Free</a></td>";
                        }
                        }
                    }
                    $this->getCodeVehiculeUseDocument("id_carte_bleue",$row['id_carte_bleue']);
                    echo "
                    <td>";

            if($this->session->userdata('vehicule_modification')=='true'){
                    echo"<button type='button' onclick='infoDocument(\"".$row['date_effet']."\",\"".$row['expiration']."\",\"".$row['numero']."\",".$row['id_carte_bleue'].",\"carte_bleue\",\"id_carte_bleue\");' class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }
            if($this->session->userdata('vehicule_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='carte_bleue' identifiant='".$row['id_carte_bleue']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_carte_bleue\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
        }

        $this->db->close();
    }
    public function selectAllVisiteTechnique(){
        $query1 = $this->db->get_where('visite_technique')->result_array();
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$row['numero']."</td>
                    <td>".$row['date_effet']."
                    </td>
                    <td>".$row['duree']."</td>
                    <td> ".$row['expiration']."</td>";
                    $query2 =$this->db->query("select id_visite from remorque where id_visite=".$row['id_visite']."")->result_array();
                    if (count($query2) > 0) {
                        echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                    }else{
                            $query3 =$this->db->query("select id_visite from camion_benne where id_visite=".$row['id_visite']."")->result_array();
                            $query0 =$this->db->query("select id_visite from voitureservice where id_visite=".$row['id_visite']."")->result_array();
                            $query4 =$this->db->query("select id_visite from engin where id_visite=".$row['id_visite']."")->result_array();
                        if (count($query3) > 0) {
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }elseif (count($query0)>0) {
                            # code...
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }elseif (count($query4)>0) {
                            # code...
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }else{
                             $query4 =$this->db->query("select id_visite from tracteur where id_visite=".$row['id_visite']."")->result_array();
                        if (count($query4) > 0) {
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }else{
                            echo "<td> <a class='btn btn-success btn-sm' href='#'>
                              <i class='fas fa-times'></i> Free</a></td>";
                        }
                        }
                    }
                    $this->getCodeVehiculeUseDocument("id_visite",$row['id_visite']);
                    echo "
                    <td>";
            if($this->session->userdata('vehicule_modification')=='true'){

                    echo"<button type='button' onclick='infoDocument(\"".$row['date_effet']."\",\"".$row['expiration']."\",\"".$row['numero']."\",".$row['id_visite'].",\"visite_technique\",\"id_visite\");'  class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }
            if($this->session->userdata('vehicule_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='visite_technique' identifiant='".$row['id_visite']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_visite\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
        }

        $this->db->close();
    }
    public function selectAllTaxe(){
        $query1 = $this->db->get_where('taxe_essieu')->result_array();
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$row['numero']."</td>
                    <td>".$row['date_effet']."
                    </td>
                    <td>".$row['duree']."</td>
                    <td> ".$row['expiration']."</td>";
                    $query3 =$this->db->query("select id_taxe_essieu from camion_benne where id_taxe_essieu=".$row['id_taxe_essieu']."")->result_array();
                    $query0 =$this->db->query("select id_taxe_essieu from voitureservice where id_taxe_essieu=".$row['id_taxe_essieu']."")->result_array();
                    $query4 =$this->db->query("select id_taxe_essieu from voitureservice where id_taxe_essieu=".$row['id_taxe_essieu']."")->result_array();
                        if (count($query3) > 0) {
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }elseif (count($query0)>0) {
                            # code...
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }elseif (count($query4)>0) {
                            # code...
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }else{
                            
                             $query4 =$this->db->query("select id_taxe_essieu from tracteur where id_taxe_essieu=".$row['id_taxe_essieu']."")->result_array();
                        if (count($query4) > 0) {
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }else{
                            echo "<td> <a class='btn btn-success btn-sm' href='#'>
                              <i class='fas fa-times'></i> Free</a></td>";
                        }
                        }
                        // $this->getCodeVehiculeUseDocument("id_taxe_essieu",$row['id_taxe_essieu']);
                    echo "
                    <td>";
            if($this->session->userdata('vehicule_modification')=='true'){
                    echo"<button type='button' onclick='infoDocument(\"".$row['date_effet']."\",\"".$row['expiration']."\",\"".$row['numero']."\",".$row['id_taxe_essieu'].",\"taxe_essieu\",\"id_taxe_essieu\");'  class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }
            if($this->session->userdata('vehicule_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='taxe_essieu' identifiant='".$row['id_taxe_essieu']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_taxe_essieu\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
              }
        }

        $this->db->close();
    }
    public function selectAllAccesPort(){
        $query1 = $this->db->get_where('acces_port')->result_array();
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$row['numero']."</td>
                    <td>".$row['date_effet']."
                    </td>
                    <td>".$row['duree']."</td>
                    <td> ".$row['expiration']."</td>";
                    $query3 =$this->db->query("select id_acces_port from camion_benne where id_acces_port=".$row['id_acces_port']."")->result_array();
                        if (count($query3) > 0) {
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }else{
                            
                             $query4 =$this->db->query("select id_acces_port from tracteur where id_acces_port=".$row['id_acces_port']."")->result_array();
                             $query2 =$this->db->query("select id_acces_port from engin where id_acces_port=".$row['id_acces_port']."")->result_array();
                             $query5 =$this->db->query("select id_acces_port from voitureservice where id_acces_port=".$row['id_acces_port']."")->result_array();
                        if (count($query4) > 0) {
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }elseif (count($query2) > 0) {
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }elseif (count($query5) > 0) {
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }else{
                            echo "<td> <a class='btn btn-success btn-sm' href='#'>
                              <i class='fas fa-times'></i> Free</a></td>";
                        }
                        }
                    // $this->getCodeVehiculeUseDocument("id_acces_port",$row['id_acces_port']);
                    echo "
                    <td>";
            if($this->session->userdata('vehicule_modification')=='true'){
                    echo"<button type='button' onclick='infoDocument(\"".$row['date_effet']."\",\"".$row['expiration']."\",\"".$row['numero']."\",".$row['id_acces_port'].",\"acces_port\",\"id_acces_port\");'  class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }

            if($this->session->userdata('vehicule_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='acces_port' identifiant='".$row['id_acces_port']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_acces_port\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
        }

        $this->db->close();
    }
    public function selectAllLicence(){
        $query1 = $this->db->get_where('licence_transport')->result_array();
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$row['numero']."</td>
                    <td>".$row['date_effet']."
                    </td>
                    <td>".$row['duree']."</td>
                    <td> ".$row['expiration']."</td>";
                    $query3 =$this->db->query("select id_licence_transport from camion_benne where id_licence_transport=".$row['id_licence_transport']."")->result_array();
                        if (count($query3) > 0) {
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }else{
                            
                             $query4 =$this->db->query("select id_licence_transport from tracteur where id_licence_transport=".$row['id_licence_transport']."")->result_array();
                             $query2 =$this->db->query("select id_licence_transport from voitureservice where id_licence_transport=".$row['id_licence_transport']."")->result_array();
                             $query5 =$this->db->query("select id_licence_transport from engin where id_licence_transport=".$row['id_licence_transport']."")->result_array();
                        if (count($query4) > 0) {
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }elseif (count($query2) > 0) {
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }elseif (count($query5) > 0) {
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }else{
                            echo "<td> <a class='btn btn-success btn-sm' href='#'>
                              <i class='fas fa-times'></i> Free</a></td>";
                        }
                        }
                    // $this->getCodeVehiculeUseDocument("id_licence_transport",$row['id_licence_transport']);
                    echo "
                    <td>";

            if($this->session->userdata('vehicule_modification')=='true'){
                    echo"<button type='button' onclick='infoDocument(\"".$row['date_effet']."\",\"".$row['expiration']."\",\"".$row['numero']."\",".$row['id_licence_transport'].",\"licence_transport\",\"id_licence_transport\");'  class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }
            if($this->session->userdata('vehicule_suppression')=='true'){
                echo"
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='licence_transport' identifiant='".$row['id_licence_transport']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_licence_transport\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
        }

        $this->db->close();
    }
    public function selectAllAttestation(){
        $query1 = $this->db->get_where('attestation_non_redevance')->result_array();
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$row['numero']."</td>
                    <td>".$row['date_effet']."
                    </td>
                    <td>".$row['duree']."</td>
                    <td> ".$row['expiration']."</td>";
                    $query3 =$this->db->query("select id_attestation from camion_benne where id_attestation=".$row['id_attestation']."")->result_array();
                        if (count($query3) > 0) {
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }else{
                            
                             $query4 =$this->db->query("select id_attestation from tracteur where id_attestation=".$row['id_attestation']."")->result_array();
                             $query2 =$this->db->query("select id_attestation from voitureservice where id_attestation=".$row['id_attestation']."")->result_array();
                             $query5 =$this->db->query("select id_attestation from engin where id_attestation=".$row['id_attestation']."")->result_array();
                        if (count($query4) > 0) {
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }elseif (count($query2) > 0) {
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }elseif (count($query5) > 0) {
                            echo "<td> <a class='btn btn-danger btn-sm' href='#'>
                              <i class='fas fa-check-circle'></i> Use</a></td>";
                        }else{
                            echo "<td> <a class='btn btn-success btn-sm' href='#'>
                              <i class='fas fa-times'></i> Free</a></td>";
                        }
                        }
                    // $this->getCodeVehiculeUseDocument("id_attestation",$row['id_attestation']);
                    echo "
                    <td>";
            if($this->session->userdata('vehicule_modification')=='true'){
                    echo"<button type='button' onclick='infoDocument(\"".$row['date_effet']."\",\"".$row['expiration']."\",\"".$row['numero']."\",".$row['id_attestation'].",\"attestation_non_redevance\",\"id_attestation\");'  class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }

            if($this->session->userdata('vehicule_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='attestation_non_redevance' identifiant='".$row['id_attestation']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_attestation\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}

        }
        $this->db->close();
    }
    // public function deleteDocument($table, $identifiant, $nom_id){
    //      $suppression = $this->db->query("delete from ".$table." where ".$nom_id."=".$identifiant."");
    //      if ($suppression == true) {
    //          # code...
    //         echo "Suppression effectuée";
    //      }else{
    //         echo "Erreur lors de la suppression";
    //      }

    //      $this->db->close();
    // }

public function deleteDocument($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé le document ".$table." et de numéro ".$getCamion->numero." le ".$date_notif." à ".$heure;

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
    public function leSelectAssurance($table){
        $query1 = $this->db->query("select * from assurance where id_assurance not in (select id_assurance from camion_benne) and id_assurance not in(select id_assurance from remorque) and id_assurance not in (select id_assurance from tracteur) and id_assurance not in (select id_assurance from engin) and id_assurance not in (select id_assurance from voitureservice) and id_assurance not in (select id_assurance from vraquier)")->result_array();
        if (count($query1)>0) {
        foreach ($query1 as $row) {
            echo "<option value='".$row["id_assurance"]."'>".$row["numero"]."</option>";
        }
        }else{
            echo "<option value=''>aucune</option>";
         }

         $this->db->close();
    }
    public function leSelectCarteGrise($table){
        $query1 = $this->db->query("select * from carte_grise where id_carte_grise not in (select id_carte_grise from camion_benne) and id_carte_grise not in(select id_carte_grise from remorque) and id_carte_grise not in (select id_carte_grise from tracteur)  and id_carte_grise not in (select id_carte_grise from engin) and id_carte_grise not in (select id_carte_grise from voitureservice) and id_carte_grise not in (select id_carte_grise from vraquier) ")->result_array();
        if (count($query1)>0) {
        foreach ($query1 as $row) {
            echo "<option value='".$row["id_carte_grise"]."'>".$row["numero"]."</option>";
        }
        }else{
            echo "<option value=''>aucune</option>";
         }

         $this->db->close();
    }
    public function leSelecCarteBleue($table){
        $query1 = $this->db->query("select * from carte_bleue where id_carte_bleue not in (select id_carte_bleue from camion_benne) and id_carte_bleue not in(select id_carte_bleue from remorque) and id_carte_bleue not in (select id_carte_bleue from tracteur) and id_carte_bleue not in (select id_carte_bleue from vraquier) ")->result_array();
        if (count($query1)>0) {
        foreach ($query1 as $row) {
            echo "<option value='".$row["id_carte_bleue"]."'>".$row["numero"]."</option>";
        }
        }else{
             echo "<option value=''>aucune</option>";
         }

         $this->db->close();
    }
    public function leSelecVisiteTechnique($table){
        $query1 = $this->db->query("select * from visite_technique where id_visite not in (select id_visite from camion_benne) and id_visite not in(select id_visite from remorque) and id_visite not in (select id_visite from tracteur) and id_visite not in (select id_visite from engin) and id_visite not in (select id_visite from voitureservice) and id_visite not in (select id_visite from vraquier)")->result_array();
        if (count($query1)>0) {
        foreach ($query1 as $row) {
            echo "<option value='".$row["id_visite"]."'>".$row["numero"]."</option>";
        }
        }else{
             echo "<option value=''>aucune</option>";
         }

         $this->db->close();
    }
    public function leSelecTaxe($table){
        $query1 = $this->db->query("select * from taxe_essieu")->result_array();
        if (count($query1)>0) {
        foreach ($query1 as $row) {
            echo "<option value='".$row["id_taxe_essieu"]."'>".$row["numero"]."</option>";
        }
        }else{
             echo "<option value=''>aucune</option>";
         }

         $this->db->close();
    }
    public function leSelectAccesPort(){
        $query1 = $this->db->query("select * from acces_port ")->result_array();
        if (count($query1)>0) {
        foreach ($query1 as $row) {
            echo "<option value='".$row["id_acces_port"]."'>".$row["numero"]."</option>";
        }
        }else{
             echo "<option value=''>aucune</option>";
         }

         $this->db->close();
    }
    

    public function leSelectLicenceTransport(){
        $query1 = $this->db->query("select * from licence_transport")->result_array();
        if (count($query1)>0) {
        foreach ($query1 as $row) {
            echo "<option value='".$row["id_licence_transport"]."'>".$row["numero"]."</option>";
        }
        }else{
             echo "<option value=''>aucune</option>";
         }

         $this->db->close();
    }

   
    public function leSelectAttestation($table){
        $query1 = $this->db->query("select * from attestation_non_redevance")->result_array();
        if (count($query1)>0) {
        foreach ($query1 as $row) {
            echo "<option value='".$row["id_attestation"]."'>".$row["numero"]."</option>";
        }
        }else{
             echo "<option value=''>aucune</option>";
         }

         $this->db->close();
    }
    public function leSelectRemorque($table){
        $query1 = $this->db->query("select * from remorque where rj ='NON' and id_remorque not in (select id_remorque from ".$table.")")->result_array();
        if (count($query1)>0) {
        foreach ($query1 as $row) {
            echo "<option value='".$row["id_remorque"]."'>".$row["immatriculation"]."</option>";
        }
        }else{
             echo "<option value=''>aucune</option>";
         }

         $this->db->close();
    }

    public function getExpirationCartegrise(){
    
    date_default_timezone_set('Africa/Lagos');
    $aujourdhui = date("Y");

    $aujourdhui2 = date("Y-m-d");
    // $dJour = explode("/", $aujourdhui);
echo " <h2 style='text-align:center; text-decoration: underline; background: linear-gradient(to right, #6c6c6c 20%, #c1c1c8 42%, #38393c 85%); padding: 5px'>CARTE GRISE</h2><br><div class='row'>";
    $query = $this->db->query("select * from carte_grise")->result_array();

    if (count($query)>0) {
        # code...
        foreach ($query as $row) {
            # code...
            $delai2 = date("Y",strtotime($row["expiration"].'- 1 year'));
            $delai3 = date("Y-m-d",strtotime($row["expiration"]));
            
            if ( $aujourdhui == $delai2) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  <hr>
                  La carte grise numéro '.$row["numero"].' crée le '.date("d/m/Y",strtotime($row["date_effet"])).' va expirer le '.date("d/m/Y",strtotime($row["expiration"])).'
                </div>
                </div>';
            }elseif (strtotime($aujourdhui2) >=strtotime($delai3)) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  <hr>
                  La carte grise numéro '.$row["numero"].' crée le '.date("d/m/Y",strtotime($row["date_effet"])).' a expiré le '.date("d/m/Y",strtotime($row["expiration"])).' 
                </div>
                </div>';
            }
            else{
                // echo "pas encore";
            }
        }
    }
    echo "</div>";

    $this->db->close();
    }


        public function getExpirationAssurance(){
    $aujourdhui = date("Y/m/d");
    // $dJour = explode("/", $aujourdhui);
echo " <h2 style='text-align:center; text-decoration: underline;background: linear-gradient(to right, #6c6c6c 20%, #c1c1c8 42%, #38393c 85%); padding: 5px'>ASSURANCE</h2><br><div class='row'>";
    $query = $this->db->query("select * from assurance")->result_array();

    if (count($query)>0) {
        # code...
        foreach ($query as $row) {
            # code...
            $delai2 = date("Y/m/d",strtotime($row["expiration"].'- 3 month'));
            // $dFin = explode("/", $delai2);
            // echo "Le délai est le :".$delai2." et ".$row["expiration"];
            if ( $aujourdhui >= $delai2 && $aujourdhui < date("Y/m/d",strtotime($row["expiration"].'- 1 days'))) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  L\'assurance N° '.$row["numero"].' crée le '.date("d/m/Y",strtotime($row["date_effet"])).' va expirer le '.date("d/m/Y",strtotime($row["expiration"])).'
                </div>
                </div>';
            }elseif ($aujourdhui >= date("Y/m/d",strtotime($row["expiration"]))) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  L\'assurance numéro '.$row["numero"].' crée le '.date("d/m/Y",strtotime($row["date_effet"])).' a expiré le '.date("d/m/Y",strtotime($row["expiration"])).' 
                </div>
                </div>';
            }
            else{
                // echo "pas encore";
            }
        }
    }
    echo "</div>";

    $this->db->close();
    }
    
    public function getExpirationFacture(){
    $aujourdhui = date("Y/m/d");
    // $dJour = explode("/", $aujourdhui);
echo " <h2 style='text-align:center; text-decoration: underline;background: linear-gradient(to right, #6c6c6c 20%, #c1c1c8 42%, #38393c 85%); padding: 5px'>FACTURE FOURNISSEURS PIECES</h2><br><div class='row'>";
    $query = $this->db->query("select * from facture_article WHERE cloture = 0 ORDER BY echeance ")->result_array();

    if (count($query)>0) {
        # code...
        foreach ($query as $row) {
            # code...
            $delai2 = date("Y/m/d",strtotime($row["echeance"].'- 7 days'));
            // $dFin = explode("/", $delai2);
            // echo "Le délai est le :".$delai2." et ".$row["expiration"];
            if ( $aujourdhui >= $delai2 && $aujourdhui < date("Y/m/d",strtotime($row["echeance"].'- 1 days'))) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  La Facture N° '.$row["numero"].' crée le '.date("d/m/Y",strtotime($row["date_fact"])).' va expirer le '.date("d/m/Y",strtotime($row["echeance"])).'
                </div>
                </div>';
            }elseif ($aujourdhui >= date("Y/m/d",strtotime($row["echeance"]))) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  La Facture N° '.$row["numero"].' crée le '.date("d/m/Y",strtotime($row["date_fact"])).' a expiré le '.date("d/m/Y",strtotime($row["echeance"])).' 
                </div>
                </div>';
            }
            else{
                // echo "pas encore";
            }
        }
    }
    echo "</div>";

    $this->db->close();
    }


      public function getExpirationAccesPort(){
    $aujourdhui = date("Y/m/d");
    // $dJour = explode("/", $aujourdhui);
echo " <h2 style='text-align:center; text-decoration: underline;background: linear-gradient(to right, #6c6c6c 20%, #c1c1c8 42%, #38393c 85%); padding: 5px'>ACCES PORT</h2><br><div class='row'>";
    $query = $this->db->query("select * from acces_port")->result_array();

    if (count($query)>0) {
        # code...
        foreach ($query as $row) {
            # code...
            $delai2 = date("Y/m/d",strtotime($row["expiration"].'- 3 month'));
            // $dFin = explode("/", $delai2);
            // echo "Le délai est le :".$delai2." et ".$row["expiration"];
            if ( $aujourdhui >= $delai2 && $aujourdhui < date("Y/m/d",strtotime($row["expiration"].'- 1 days'))) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  L\'accès port N° '.$row["numero"].' crée le '.date("d/m/Y",strtotime($row["date_effet"])).' va expirer le '.date("d/m/Y",strtotime($row["expiration"])).'
                </div>
                </div>';
            }elseif ($aujourdhui >= date("Y/m/d",strtotime($row["expiration"]))) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  L\'acces port '.$row["numero"].' crée le '.date("d/m/Y",strtotime($row["date_effet"])).' a expiré le '.date("d/m/Y",strtotime($row["expiration"])).' 
                </div>
                </div>';
            }
            else{
                // echo "pas encore";
            }
        }
    }
    echo "</div>";

    $this->db->close();
    }

            public function getExpirationCarteBleue(){
    $aujourdhui = date("Y/m/d");
    // $dJour = explode("/", $aujourdhui);
echo " <h2 style='text-align:center; text-decoration: underline; background: linear-gradient(to right, #6c6c6c 20%, #c1c1c8 42%, #38393c 85%); padding: 5px'>CARTE BLEUE</h2><br><div class='row'>";
    $query = $this->db->query("select * from carte_bleue")->result_array();

    if (count($query)>0) {
        # code...
        foreach ($query as $row) {
            # code...
            $delai2 = date("Y/m/d",strtotime($row["expiration"].'- 3 month'));
            // $dFin = explode("/", $delai2);
            // echo "Le délai est le :".$delai2." et ".$row["expiration"];
            if ( $aujourdhui >= $delai2 && $aujourdhui < date("Y/m/d",strtotime($row["expiration"].'- 1 days'))) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  La carte bleue N° '.$row["numero"].' crée le '.date("d/m/Y",strtotime($row["date_effet"])).' va expirer le '.date("d/m/Y",strtotime($row["expiration"])).'
                </div>
                </div>';
            }elseif ($aujourdhui >= date("Y/m/d",strtotime($row["expiration"]))) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  La carte bleue numéro '.$row["numero"].' crée le '.date("d/m/Y",strtotime($row["date_effet"])).' a expiré le '.date("d/m/Y",strtotime($row["expiration"])).' 
                </div>
                </div>';
            }
            else{
                // echo "pas encore";
            }
        }
    }
    echo "</div>";

    $this->db->close();
    }

    public function getExpirationVisiteTechnique(){
    $aujourdhui = date("Y/m/d");
    // $dJour = explode("/", $aujourdhui);
echo " <h2 style='text-align:center; text-decoration: underline; background: linear-gradient(to right, #6c6c6c 20%, #c1c1c8 42%, #38393c 85%); padding: 5px'>VISITE TECHNIQUE</h2><br><div class='row'>";
    $query = $this->db->query("select * from visite_technique")->result_array();

    if (count($query)>0) {
        # code...
        // echo " <h2> VISITE TECHNIQUE </h2> <hr>";
        foreach ($query as $row) {
            # code...
            $delai2 = date("Y/m/d",strtotime($row["expiration"].'- 1 month'));
            // $dFin = explode("/", $delai2);
            // echo "Le délai est le :".$delai2." et ".$row["expiration"];
            if ( $aujourdhui >= $delai2 && $aujourdhui < date("Y/m/d",strtotime($row["expiration"].'- 1 days'))) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  La visite technique N° '.$row["numero"].' crée le '.date("d/m/Y",strtotime($row["date_effet"])).' va expirer le '.date("d/m/Y",strtotime($row["expiration"])).'
                </div>
                </div>';
            }elseif ($aujourdhui >= date("Y/m/d",strtotime($row["expiration"]))) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  La visite technique numéro '.$row["numero"].' crée le '.date("d/m/Y",strtotime($row["date_effet"])).' a expiré le '.date("d/m/Y",strtotime($row["expiration"])).' 
                </div>
                </div>';
            }
            else{
                // echo "pas encore";
            }
        }
    }
    echo "</div>";
    $this->db->close();
 }

 public function getExpirationTaxeEssieu(){
    $aujourdhui = date("Y/m/d");
    // $dJour = explode("/", $aujourdhui);
echo " <h2 style='text-align:center; text-decoration: underline; background: linear-gradient(to right, #6c6c6c 20%, #c1c1c8 42%, #38393c 85%); padding: 5px'>TAXE ESSIEU</h2><br><div class='row'>";
    $query = $this->db->query("select * from taxe_essieu")->result_array();

    if (count($query)>0) {
        # code...
        foreach ($query as $row) {
            # code...
            $delai2 = date("Y/m/d",strtotime($row["expiration"].'- 1 month'));
            // $dFin = explode("/", $delai2);
            // echo "Le délai est le :".$delai2." et ".$row["expiration"];
            if ( $aujourdhui >= $delai2 && $aujourdhui < date("Y/m/d",strtotime($row["expiration"].'- 1 days'))) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  La taxe  à l\'essieu N° '.$row["numero"].' crée le '.date("d/m/Y",strtotime($row["date_effet"])).' va expirer le '.date("d/m/Y",strtotime($row["expiration"])).'
                </div>
                </div>';
            }elseif ($aujourdhui >= date("Y/m/d",strtotime($row["expiration"]))) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  La taxe  à l\'essieu numéro '.$row["numero"].' crée le '.date("d/m/Y",strtotime($row["date_effet"])).' a expiré le '.date("d/m/Y",strtotime($row["expiration"])).' 
                </div>
                </div>';
            }
            else{
                // echo "pas encore";
            }
        }
    }
    echo "</div>";

    $this->db->close();
 }

  public function getExpirationLicenceTransport(){
    $aujourdhui = date("Y/m/d");
    // $dJour = explode("/", $aujourdhui);
echo " <h2 style='text-align:center; text-decoration: underline; background: linear-gradient(to right, #6c6c6c 20%, #c1c1c8 42%, #38393c 85%); padding: 5px'>LICENCE DE TRANSPORT</h2><br><div class='row'>";
    $query = $this->db->query("select * from licence_transport")->result_array();

    if (count($query)>0) {
        # code...
        foreach ($query as $row) {
            # code...
            $delai2 = date("Y/m/d",strtotime($row["expiration"].'- 14 days'));
            // $dFin = explode("/", $delai2);
            // echo "Le délai est le :".$delai2." et ".$row["expiration"];
            if ( $aujourdhui >= $delai2 && $aujourdhui < date("Y/m/d",strtotime($row["expiration"].'- 1 days'))) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  La licence de transport  N° '.$row["numero"].' crée le '.date("d/m/Y",strtotime($row["date_effet"])).' va expirer le '.date("d/m/Y",strtotime($row["expiration"])).'
                </div>
                </div>';
            }elseif ($aujourdhui >= date("Y/m/d",strtotime($row["expiration"]))) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  La licence de transport '.$row["numero"].' crée le '.date("d/m/Y",strtotime($row["date_effet"])).' a expiré le '.date("d/m/Y",strtotime($row["expiration"])).' 
                </div>
                </div>';
            }
            else{
                // echo "pas encore";
            }
        }
    }
    echo "</div>";
    $this->db->close();
 }

   public function getExpirationAttestationRedevance(){
    $aujourdhui = date("Y/m/d");
    // $dJour = explode("/", $aujourdhui);
    echo " <h2 style='text-align:center; text-decoration: underline;background: linear-gradient(to right, #6c6c6c 20%, #c1c1c8 42%, #38393c 85%); padding: 5px'>ATTESTATION DE NON REDEVANCE</h2><br><div class='row'>";
    $query = $this->db->query("select * from licence_transport")->result_array();

    if (count($query)>0) {
        # code...
        foreach ($query as $row) {
            # code...
            $delai2 = date("Y/m/d",strtotime($row["expiration"].'- 14 days'));
            // $dFin = explode("/", $delai2);
            // echo "Le délai est le :".$delai2." et ".$row["expiration"];
            if ( $aujourdhui >= $delai2 && $aujourdhui < date("Y/m/d",strtotime($row["expiration"].'- 1 days'))) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  L\'attestation de non redevance N° '.$row["numero"].' crée le '.date("d/m/Y",strtotime($row["date_effet"])).' va expirer le '.date("d/m/Y",strtotime($row["expiration"])).'
                </div>
                </div>';
            }elseif ($aujourdhui >= date("Y/m/d",strtotime($row["expiration"]))) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  L\'attestation de non redevance '.$row["numero"].' crée le '.date("d/m/Y",strtotime($row["date_effet"])).' a expiré le '.date("d/m/Y",strtotime($row["expiration"])).' 
                </div>
                </div>';
            }
            else{
                // echo "pas encore";
            }
        }
    }
     echo "</div>";

     $this->db->close();
 }

public function getExpirationCniChauffeur(){
    $aujourdhui = date("Y/m/d");
     $cetannee = date("Y");
    // $dJour = explode("/", $aujourdhui);
echo " <h2 style='text-align:center; text-decoration: underline; background: linear-gradient(to right, #6c6c6c 20%, #c1c1c8 42%, #38393c 85%); padding: 5px'>CNI CHAUFFEURS & ASSISTANTS</h2><br><div class='row'>";
    $query = $this->db->query("select * from chauffeur")->result_array();

    if (count($query)>0) {
        # code...
        foreach ($query as $row) {
            # code...
            $delai2 = date("Y/m/d",strtotime($row["date_exp_cni_ch"].'- 1 year'));
           
            // $dFin = explode("/", $delai2);
            // echo "Le délai est le :".$delai2;
            if ( $cetannee == date("Y",strtotime($row["date_exp_cni_ch"].'- 1 year')) && $aujourdhui>=$delai2 && $aujourdhui<=date("Y/m/d",strtotime($row["date_exp_cni_ch"].'- 1 days'))) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  <hr>
                 La carte nationale d\'dentité N° '.$row["cni_chauff"].' du chauffeur dénommé '.$row["nom"].' et de numéro de téléphone '.$row["telephoneChauffeur"].' va expirer le '.date("d/m/Y",strtotime($row["date_exp_cni_ch"])).'
                </div>
                </div>';
            }elseif (strtotime($aujourdhui) > strtotime(date("Y/m/d",strtotime($row["date_exp_cni_ch"]))) && strtotime(date("d/m/Y",strtotime($row["date_exp_cni_ch"])))!= strtotime(' 01/01/1970')) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  <hr>
                  La carte nationale d\'dentité N° '.$row["cni_chauff"].' du chauffeur '.$row["nom"].' et de numéro de téléphone '.$row["telephoneChauffeur"].' a expiré le '.date("d/m/Y",strtotime($row["date_exp_cni_ch"])).'
                </div>
                </div>';
            }
            else{
                // echo "pas encore";
            }

            if ( $cetannee == date("Y",strtotime($row["date_exp_cni_ass"].'- 1 year')) && $aujourdhui>=date("Y/m/d",strtotime($row["date_exp_cni_ass"].'- 1 year')) && $aujourdhui<=date("Y/m/d",strtotime($row["date_exp_cni_ass"].'- 1 days'))) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  <hr>
                 La carte nationale d\'dentité N° '.$row["cni_ass"].' de l\'assistant dénommé '.$row["nom"].' et de numéro de téléphone '.$row["telephoneAssistant"].' va expirer le '.date("d/m/Y",strtotime($row["date_exp_cni_ass"])).'
                </div>
                </div>';
            }elseif (strtotime($aujourdhui) > strtotime(date("Y/m/d",strtotime($row["date_exp_cni_ass"]))) && strtotime(date("d/m/Y",strtotime($row["date_exp_cni_ass"])))!=strtotime(' 01/01/1970')) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  <hr>
                  La carte nationale d\'dentité N° '.$row["cni_chauff"].' de l\'assistant '.$row["nom"].' et de numéro de téléphone '.$row["telephoneAssistant"].' a expiré le '.date("d/m/Y",strtotime($row["date_exp_cni_ass"])).'
                </div>
                </div>';
            }
            else{
                // echo "pas encore";
            }

             if ($row["cni_chauff"] == "") {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  <hr>
                  Le chauffueur dénommé '.$row["nom"].' et de numéro de téléphone '.$row["telephoneChauffeur"].' ne possède pas de CNI !
                </div>
                </div>';
            }

            
            if ($row["cni_ass"] == "") {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  <hr>
                  L\'assistant dénommé '.$row["nom_ass"].' et de numéro de téléphone '.$row["telephoneAssistant"].' ne possède pas de CNI !
                </div>
                </div>';
            }
        }
    }
    echo "</div>";

    $this->db->close();
    }

    public function getExpirationPermis(){
    $aujourdhui = date("Y/m/d");
    // $dJour = explode("/", $aujourdhui);
echo " <h2 style='text-align:center; text-decoration: underline; background: linear-gradient(to right, #6c6c6c 20%, #c1c1c8 42%, #38393c 85%); padding: 5px'>PERMIS DE CONDUIRE</h2><br><div class='row'>";
    $query = $this->db->query("select * from chauffeur")->result_array();

    if (count($query)>0) {
        # code...
        foreach ($query as $row) {
            # code...
            $delai2 = date("Y/m/d",strtotime($row["date_exp_permis_ch"].'- 1 year'));
            // $dFin = explode("/", $delai2);
            // echo "Le délai est le :".$delai2;
           if ( $aujourdhui == $delai2) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  <hr>
                 La permis de conduire N° '.$row["num_permis"].' du chauffeur '.$row["nom"].' dont le numéro de téléphone est le '.$row["telephoneChauffeur"].' va expirer le '.date("d/m/Y",strtotime($row["date_exp_permis_ch"])).'
                </div>
                </div>';
            }elseif (strtotime($aujourdhui) > strtotime(date("Y/m/d",strtotime($row["date_exp_permis_ch"]))) && strtotime(date("d/m/Y",strtotime($row["date_exp_permis_ch"])))!=strtotime(' 01/01/1970')) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  <hr>
                  La permis de conduire N° '.$row["num_permis"].' du chauffeur '.$row["nom"].' dont le numéro de téléphone est le '.$row["telephoneChauffeur"].' a expiré le '.date("d/m/Y",strtotime($row["date_exp_permis_ch"])).'
                </div>
                </div>';
            }
            else{
                // echo "pas encore";
            }
            if ($row["num_permis"] == "") {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  <hr>
                  Le chauffueur dénommé '.$row["nom"].' et de numéro de téléphone '.$row["telephoneChauffeur"].' ne possède pas de permis de conduire !
                </div>
                </div>';
            }
           
        }
    }
    echo "</div>";

    $this->db->close();
    }
}