<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model_profile extends CI_Model {
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

    public function addPrivilege(){

        $modification = $_POST['modification'];
        $suppression = $_POST['suppression'];
        $table = $_POST['table'];

        $identifiant = $_POST['identifiant'];
        $password = $_POST['password'];
        $ajout = $_POST['ajout'];

        $query = $this->db->query("select * from profil where identifiant = '".$identifiant."' and password = '".sha1($password)."'")->row();

        $query1 = $this->db->query("INSERT into ".$table." value('',".$query->id_profil.",'".$ajout."','".$suppression."','".$modification."')");
        if ($query1==0) {
        // foreach ($query1 as $row) {
        //     echo "<option value='".$row["id_client"]."'>".$row["nom"]."</option>";
        // }
            echo "Privilege ok";
        }else{
            echo "aucune";
         }
    }

    public function addUser(){

        $type = $_POST['type'];
        $commentaire = $_POST['commentaire'];

        $identifiant = $_POST['identifiant'];
        $password = $_POST['password'];
        $status = $_POST['status'];

        if ($status == 'insert') {
            # code...
            $query = $this->db->query("select * from profil where identifiant = '".$identifiant."' and password = '".sha1($password)."'")->row();
            if (count($query)>0) {
                # code...
                echo "Cet utilisateur existe dejà veuillez changer svp";
            }else{
            $query1 = $this->db->query("INSERT into profil value('','".$type."','".$identifiant."','','".sha1($password)."','".$commentaire."')");
            if ($query1 == true) {
                    echo "Insertion parfaite de l'utilisateur";
            }else{
             }
            }
        }elseif ($status === 'update') {
            # code...
            $this->updatePrivilege();
        }else{
            echo "Erreur contactez l'administrateur";
        }
        
    }

    public function updatePrivilege(){
        
        $modification = $_POST['modification'];
        $suppression = $_POST['suppression'];
        $table = $_POST['table'];
        $id_profil = $_POST['id_profil'];
        $identifiant = $_POST['identifiant'];
        $password = $_POST['password'];
        $ajout = $_POST['ajout'];

        $query = $this->db->query("select * from ".$table." where id_profile = ".$id_profil."")->row();
        
        if (count($query)>0) {
            # code...
            $query1 = $this->db->query("UPDATE  ".$table." set ajout = '".$ajout."',suppression = '".$suppression."', modification ='".$modification."' where id_profile = ".$id_profil."");
        if ($query1 == true) {
       // echo "cool ".$id_profil;
          echo $table;
        }else{
            echo "movais";
         }
        }else{

            $this->db->query("INSERT into ".$table." value('',".$id_profil.",'".$ajout."','".$suppression."','".$modification."')");
        }
        
    }

    public function modifProfile(){
        $id_profil = $_POST['id_profil'];
        $identifiant = $_POST['identifiant'];
        $password = $_POST['password'];

        $query = $this->db->query("UPDATE profil set password ='".sha1($password)."', identifiant ='".$identifiant."' where id_profil=".$id_profil."");
        if ($query == true) {
            # code...
            echo "Mise à jour de vos paramètres réussie";
        }else{
            echo "Echec lors de la mise à jour";
        }
    }


    public function updateProfile(){
        
        $identifiant = $_POST['identifiant'];
        $password = $_POST['password'];

        $query = $this->db->query("UPDATE profil set password ='".sha1($password)."', identifiant ='".$identifiant."' where id_profil=".$this->session->userdata('id_profil')."");
        if ($query == true) {
            # code...
            echo "Mise à jour de vos paramètres réussie";
        }else{
            echo "Echec lors de la mise à jour";
        }
    }


        public function selectAllUsers(){
              $query1 = $this->db->query('SELECT * from profil order by id_profil desc')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['identifiant']."
                    </td>
                    <td>".$row['type']."</td>
                    <td> ".$row['commentaire']."</td>
               
                    <td>";

              if($this->session->userdata('users_modification')=='true'){
                   echo "<button type='button' onclick=\"infosProfil('".$row['id_profil']."','".$row['identifiant']."','".$row['password']."','".$row['type']."','".$row['commentaire']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>" ;
                 }

              if($this->session->userdata('users_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='profil' identifiant='".$row['id_profil']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_profil\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                }
                  $compteur++;
        }
    }

 public function formModifPrivilege(){
    $id_profil = $_POST['id_profil'];
	
	  $query1 = $this->db->query('SELECT * from pv_mira_sa where id_profile = '.$id_profil.'')->result_array();

    if (count($query1)>0) {
        # code...
            foreach ($query1 as $row) {
        # code...
        echo ' <div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">MIRA S.A</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion0" id="pv_mira_sa" checked="true">
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout0" type="checkbox" id="ajout0"
                                    ';
                                    if ($row["ajout"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["ajout"].'"';
                                    }
                                   echo '>
                                    <label for="ajout0" class="custom-control-label ">Ajout</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification0" type="checkbox" id="modification0"
                                    ';
                                    if ($row["modification"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["modification"].'"';
                                    }
                                   echo '>
                                    <label for="modification0" class="custom-control-label ">Modification</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression0" type="checkbox" id="suppression0"';
                                    if ($row["suppression"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["suppression"].'"';
                                    }
                                   echo '>
                                    <label for="suppression0" class="custom-control-label ">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>';
    }
    }else{
       echo ' <div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">MIRA S.A</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion0" id="pv_mira_sa" >
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout0" type="checkbox" id="ajout0" >
                                    <label for="ajout0" class="custom-control-label">Ajout</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification0" type="checkbox" id="modification0" >
                                    <label for="modification0" class="custom-control-label ">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression0" type="checkbox" id="suppression0">
                                    <label for="suppression0" class="custom-control-label ">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>'; 
    }

    

    $query2 = $this->db->query('SELECT * from pv_gestion_chauffeur where id_profile = '.$id_profil.'')->result_array();

    if (count($query2)>0) {
        # code...
            foreach ($query2 as $row) {
        # code...
        echo ' <div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">GESTION CHAUFFEUR</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion2" id="pv_gestion_chauffeur" checked="true">
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">

                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout2" type="checkbox" id="ajout2"
                                    ';
                                    if ($row["ajout"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["ajout"].'"';
                                    }
                                   echo '>
                                    <label for="ajout2" class="custom-control-label ">Ajout</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification2" type="checkbox" id="modification2" ';
                                    if ($row["modification"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["modification"].'"';
                                    }
                                   echo '>
                                    <label for="modification2" class="custom-control-label ">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression2" type="checkbox" id="suppression2"';
                                    if ($row["suppression"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["suppression"].'"';
                                    }
                                   echo '>
                                    <label for="suppression2" class="custom-control-label ">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>';
    }
    }else{
       echo ' <div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">GESTION CHAUFFEUR</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion2" id="pv_gestion_chauffeur">
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout2" type="checkbox" id="ajout2" >
                                    <label for="ajout2" class="custom-control-label">Ajout</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification2" type="checkbox" id="modification2" >
                                    <label for="modification2" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression2" type="checkbox" id="suppression2" >
                                    <label for="suppression2" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>'; 
    }

    $query2 = $this->db->query('SELECT * from pv_gestion_vehicule where id_profile = '.$id_profil.'')->result_array();

    if (count($query2)>0) {
        # code...
            foreach ($query2 as $row) {
        # code...
        echo ' <div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">GESTION VEHICULE</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion3" id="pv_gestion_vehicule" checked="true">
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout3" type="checkbox" id="ajout3"
                                    ';
                                    if ($row["ajout"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["ajout"].'"';
                                    }
                                   echo '>
                                    <label for="ajout3" class="custom-control-label ">Ajout</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification3" type="checkbox" id="modification3" ';
                                    if ($row["modification"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["modification"].'"';
                                    }
                                   echo '>
                                    <label for="modification3" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression3" type="checkbox" id="suppression3"';
                                    if ($row["suppression"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["suppression"].'"';
                                    }
                                   echo '>
                                    <label for="suppression3" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>';
    }
    }else{
       echo ' <div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">GESTION VEHICULE</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion3" id="pv_gestion_vehicule">
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout3" type="checkbox" id="ajout3" >
                                    <label for="ajout3" class="custom-control-label">Ajout</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification3" type="checkbox" id="modification3" >
                                    <label for="modification3" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression3" type="checkbox" id="suppression3" >
                                    <label for="suppression3" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>'; 
    }
	
	
	  $query2 = $this->db->query('SELECT * from pv_parametres where id_profile = '.$id_profil.'')->result_array();

    if (count($query2)>0) {
        # code...
            foreach ($query2 as $row) {
        # code...
        echo ' <div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">PARAMETRES</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion13" id="pv_parametres" checked="true">
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout13" type="checkbox" id="ajout13"
                                    ';
                                    if ($row["ajout"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["ajout"].'"';
                                    }
                                   echo '>
                                    <label for="ajout13" class="custom-control-label ">Ajout</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification13" type="checkbox" id="modification13" ';
                                    if ($row["modification"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["modification"].'"';
                                    }
                                   echo '>
                                    <label for="modification13" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression13" type="checkbox" id="suppression13"';
                                    if ($row["suppression"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["suppression"].'"';
                                    }
                                   echo '>
                                    <label for="suppression13" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>';
    }
    }else{
       echo ' <div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">PARAMETRES</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion13" id="pv_parametres">
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout13" type="checkbox" id="ajout13" >
                                    <label for="ajout13" class="custom-control-label">Ajout</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification13" type="checkbox" id="modification13" >
                                    <label for="modification13" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression13" type="checkbox" id="suppression13" >
                                    <label for="suppression13" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>'; 
    }
	
	
	 $query2 = $this->db->query('SELECT * from pv_administration where id_profile = '.$id_profil.'')->result_array();

    if (count($query2)>0) {
        # code...
            foreach ($query2 as $row) {
        # code...
        echo '<div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">DEMANDE F.ROUTE-GASOIL</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion19" id="pv_administration" checked="true">
                              </div>
                            </div>

                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout19" type="checkbox" id="ajout19"
                                    ';
                                    if ($row["ajout"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["ajout"].'"';
                                    }
                                   echo '>
                                    <label for="ajout19" class="custom-control-label ">Ajout</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification19" type="checkbox" id="modification19"';
                                    if ($row["modification"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["modification"].'"';
                                    }
                                   echo '>
                                        <label for="modification19" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression19" type="checkbox" id="suppression19"';
                                    if ($row["suppression"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["suppression"].'"';
                                    }
                                   echo '>
                                     <label for="suppression19" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>';
    }
    }else{
       echo '<div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">DEMANDE F.ROUTE-GASOIL</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion19" id="pv_administration">
                              </div>
                            </div>

                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout19" type="checkbox" id="ajout19" >
                                    <label for="ajout19" class="custom-control-label">Ajout</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification19" type="checkbox" id="modification19" >
                                    <label for="modification19" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression19" type="checkbox" id="suppression19" >
                                    <label for="suppression19" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>'; 
    }
	
	
	$query2 = $this->db->query('SELECT * from pv_vidange where id_profile = '.$id_profil.'')->result_array();

    if (count($query2)>0) {
        # code...
            foreach ($query2 as $row) {
        # code...
        echo '<div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">STOCK HUILE</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion14" id="pv_vidange" checked="true">
                              </div>
                            </div>

                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout14" type="checkbox" id="ajout14"
                                    ';
                                    if ($row["ajout"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["ajout"].'"';
                                    }
                                   echo '>
                                    <label for="ajout14" class="custom-control-label ">Ajout</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification14" type="checkbox" id="modification14"';
                                    if ($row["modification"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["modification"].'"';
                                    }
                                   echo '>
                                       <label for="modification14" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression14" type="checkbox" id="suppression14"';
                                    if ($row["suppression"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["suppression"].'"';
                                    }
                                   echo '>
                                      <label for="suppression14" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>';
    }
    }else{
       echo '<div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">STOCK HUILE</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion14" id="pv_vidange">
                              </div>
                            </div>

                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout14" type="checkbox" id="ajout14" >
                                    <label for="ajout14" class="custom-control-label">Ajout</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification14" type="checkbox" id="modification14" >
                                    <label for="modification14" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression14" type="checkbox" id="suppression14" >
                                    <label for="suppression14" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>'; 
    }
	
	$query2 = $this->db->query('SELECT * from pv_operation_gazoil where id_profile = '.$id_profil.'')->result_array();

    if (count($query2)>0) {
        # code...
            foreach ($query2 as $row) {
        # code...
        echo '<div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">STOCK GAZOIL</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion18" id="pv_operation_gazoil" checked="true">
                              </div>
                            </div>

                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout18" type="checkbox" id="ajout18"
                                    ';
                                    if ($row["ajout"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["ajout"].'"';
                                    }
                                   echo '>
                                    <label for="ajout18" class="custom-control-label ">Ajout</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification18" type="checkbox" id="modification18"';
                                    if ($row["modification"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["modification"].'"';
                                    }
                                   echo '>
                                        <label for="modification18" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression18" type="checkbox" id="suppression18"';
                                    if ($row["suppression"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["suppression"].'"';
                                    }
                                   echo '>
                                     <label for="suppression18" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>';
    }
    }else{
       echo '<div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">STOCK GAZOIL</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion18" id="pv_operation_gazoil">
                              </div>
                            </div>

                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout18" type="checkbox" id="ajout18" >
                                    <label for="ajout18" class="custom-control-label">Ajout</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification18" type="checkbox" id="modification18" >
                                    <label for="modification18" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression18" type="checkbox" id="suppression18" >
                                    <label for="suppression18" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>'; 
    }


 $query2 = $this->db->query('SELECT * from pv_gestion_stock where id_profile = '.$id_profil.'')->result_array();

    if (count($query2)>0) {
        # code...
            foreach ($query2 as $row) {
        # code...
        echo '<div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">STOCK PIECES</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion5" id="pv_gestion_stock" checked="true">
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout5" type="checkbox" id="ajout5"
                                    ';
                                    if ($row["ajout"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["ajout"].'"';
                                    }
                                   echo '>
                                    <label for="ajout5" class="custom-control-label ">Ajout</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification5" type="checkbox" id="modification5"';
                                    if ($row["modification"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["modification"].'"';
                                    }
                                   echo '>
                                     <label for="modification5" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression5" type="checkbox" id="suppression5"';
                                    if ($row["suppression"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["suppression"].'"';
                                    }
                                   echo '>
                                     <label for="suppression5" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>';
    }
    }else{
       echo ' <div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">STOCK PIECES</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion5" id="pv_gestion_stock">
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout5" type="checkbox" id="ajout5" >
                                    <label for="ajout5" class="custom-control-label">Ajout</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification5" type="checkbox" id="modification5" >
                                    <label for="modification5" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression5" type="checkbox" id="suppression5" >
                                    <label for="suppression5" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>'; 
    }


    $query2 = $this->db->query('SELECT * from pv_gestion_pneu where id_profile = '.$id_profil.'')->result_array();

    if (count($query2)>0) {
        # code...
            foreach ($query2 as $row) {
        # code...
        echo '<div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">STOCK PNEU</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion4" id="pv_gestion_pneu" checked="true">
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout4" type="checkbox" id="ajout4"
                                    ';
                                    if ($row["ajout"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["ajout"].'"';
                                    }
                                   echo '>
                                    <label for="ajout4" class="custom-control-label ">Ajout</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification4" type="checkbox" id="modification4"';
                                    if ($row["modification"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["modification"].'"';
                                    }
                                   echo '>
                                     <label for="modification4" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression4" type="checkbox" id="suppression4"';
                                    if ($row["suppression"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["suppression"].'"';
                                    }
                                   echo '>
                                    <label for="suppression4" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>';
    }
    }else{
       echo ' <div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">STOCK PNEU</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion4" id="pv_gestion_pneu">
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout4" type="checkbox" id="ajout4" >
                                    <label for="ajout4" class="custom-control-label">Ajout</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification4" type="checkbox" id="modification4" >
                                    <label for="modification4" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression4" type="checkbox" id="suppression4" >
                                    <label for="suppression4" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>'; 
    }
	
	 $query2 = $this->db->query('SELECT * from pv_gestion_article where id_profile = '.$id_profil.'')->result_array();

    if (count($query2)>0) {
        # code...
            foreach ($query2 as $row) {
        # code...
        echo ' <div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">FOURNISSEURS PIECES</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion6" id="pv_gestion_article" checked="true">
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout6" type="checkbox" id="ajout6"
                                    ';
                                    if ($row["ajout"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["ajout"].'"';
                                    }
                                   echo '>
                                    <label for="ajout6" class="custom-control-label ">Ajout</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification6" type="checkbox" id="modification6"';
                                    if ($row["modification"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["modification"].'"';
                                    }
                                   echo '>
                                      <label for="modification6" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression6" type="checkbox" id="suppression6"';
                                    if ($row["suppression"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["suppression"].'"';
                                    }
                                   echo '>
                                     <label for="suppression6" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>';
    }
    }else{
       echo ' <div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">FOURNISSEURS PIECES</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion6" id="pv_gestion_article">
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout6" type="checkbox" id="ajout6" >
                                    <label for="ajout6" class="custom-control-label">Ajout</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification6" type="checkbox" id="modification6" >
                                    <label for="modification6" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression6" type="checkbox" id="suppression6" >
                                    <label for="suppression6" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>'; 
    }
	
	
	$query1 = $this->db->query('SELECT * from pv_document where id_profile = '.$id_profil.'')->result_array();

    if (count($query1)>0) {
        # code...
            foreach ($query1 as $row) {
        # code...
        echo ' <div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">FOURNISSEUR DOCUMENT</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion2" id="pv_document" checked="true">
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout2" type="checkbox" id="ajout2"
                                    ';
                                    if ($row["ajout"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["ajout"].'"';
                                    }
                                   echo '>
                                    <label for="ajout2" class="custom-control-label ">Ajout</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification0" type="checkbox" id="modification0"
                                    ';
                                    if ($row["modification"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["modification"].'"';
                                    }
                                   echo '>
                                    <label for="modification2" class="custom-control-label ">Modification</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression2" type="checkbox" id="suppression0"';
                                    if ($row["suppression"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["suppression"].'"';
                                    }
                                   echo '>
                                    <label for="suppression2" class="custom-control-label ">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>';
    }
    }else{
       echo ' <div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">FOURNISSEUR DOCUMENT</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion2" id="pv_document" >
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout2" type="checkbox" id="ajout2" >
                                    <label for="ajout2" class="custom-control-label">Ajout</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification2" type="checkbox" id="modification2" >
                                    <label for="modification2" class="custom-control-label ">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression2" type="checkbox" id="suppression2">
                                    <label for="suppression2" class="custom-control-label ">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>'; 
    }
	
	$query2 = $this->db->query('SELECT * from pv_fournisseur_caisse where id_profile = '.$id_profil.'')->result_array();

    if (count($query2)>0) {
        # code...
            foreach ($query2 as $row) {
        # code...
        echo '<div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">FOURNISSEUR CASH</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion8" id="pv_fournisseur_caisse" checked="true">
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout8" type="checkbox" id="ajout8"
                                    ';
                                    if ($row["ajout"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["ajout"].'"';
                                    }
                                   echo '>
                                    <label for="ajout8" class="custom-control-label ">Ajout</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification8" type="checkbox" id="modification8"';
                                    if ($row["modification"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["modification"].'"';
                                    }
                                   echo '>
                                      <label for="modification8" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression8" type="checkbox" id="suppression8"';
                                    if ($row["suppression"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["suppression"].'"';
                                    }
                                   echo '>
                                     <label for="suppression8" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>';
    }
    }else{
       echo '<div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">FOURNISSEUR CASH</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion8" id="pv_fournisseur_caisse">
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout8" type="checkbox" id="ajout8" >
                                    <label for="ajout8" class="custom-control-label">Ajout</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification8" type="checkbox" id="modification8">
                                    <label for="modification8" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression8" type="checkbox" id="suppression8" >
                                    <label for="suppression8" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>'; 
    }
	
	  $query2 = $this->db->query('SELECT * from pv_gestion_gazoil where id_profile = '.$id_profil.'')->result_array();

    if (count($query2)>0) {
        # code...
            foreach ($query2 as $row) {
        # code...
        echo '<div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">FOURNISSEUR GAZOIL</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion10" id="pv_gestion_gazoil" checked="true">
                              </div>
                            </div>

                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout10" type="checkbox" id="ajout10"
                                    ';
                                    if ($row["ajout"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["ajout"].'"';
                                    }
                                   echo '>
                                    <label for="ajout10" class="custom-control-label ">Ajout</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification10" type="checkbox" id="modification10"';
                                    if ($row["modification"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["modification"].'"';
                                    }
                                   echo '>
                                       <label for="modification10" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression10" type="checkbox" id="suppression10"';
                                    if ($row["suppression"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["suppression"].'"';
                                    }
                                   echo '>
                                     <label for="suppression10" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>';
    }
    }else{
       echo '<div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">FOURNISSEUR GAZOIL</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion10" id="pv_gestion_gazoil">
                              </div>
                            </div>

                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout10" type="checkbox" id="ajout10" >
                                    <label for="ajout10" class="custom-control-label">Ajout</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification10" type="checkbox" id="modification10" >
                                    <label for="modification10" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression10" type="checkbox" id="suppression10" >
                                    <label for="suppression10" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>'; 
    }
	
	
	
	$query1 = $this->db->query('SELECT * from pv_gestion_client where id_profile = '.$id_profil.'')->result_array();

    if (count($query1)>0) {
        # code...
            foreach ($query1 as $row) {
        # code...
        echo ' <div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">GESTION CLIENT</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion1" id="pv_gestion_client" checked="true">
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout1" type="checkbox" id="ajout1"
                                    ';
                                    if ($row["ajout"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["ajout"].'"';
                                    }
                                   echo '>
                                    <label for="ajout1" class="custom-control-label ">Ajout</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification1" type="checkbox" id="modification1"
                                    ';
                                    if ($row["modification"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["modification"].'"';
                                    }
                                   echo '>
                                    <label for="modification1" class="custom-control-label ">Modification</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression1" type="checkbox" id="suppression1"';
                                    if ($row["suppression"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["suppression"].'"';
                                    }
                                   echo '>
                                    <label for="suppression1" class="custom-control-label ">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>';
    }
    }else{
       echo ' <div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">GESTION CLIENT</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion1" id="pv_gestion_client" >
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout1" type="checkbox" id="ajout1" >
                                    <label for="ajout1" class="custom-control-label">Ajout</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification1" type="checkbox" id="modification1" >
                                    <label for="modification1" class="custom-control-label ">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression1" type="checkbox" id="suppression1">
                                    <label for="suppression1" class="custom-control-label ">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>'; 
    }
	
	$query2 = $this->db->query('SELECT * from pv_operation where id_profile = '.$id_profil.'')->result_array();

    if (count($query2)>0) {
        # code...
            foreach ($query2 as $row) {
        # code...
        echo '<div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">OPERATION</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion11" id="pv_operation" checked="true">
                              </div>
                            </div>

                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout11" type="checkbox" id="ajout11"
                                    ';
                                    if ($row["ajout"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["ajout"].'"';
                                    }
                                   echo '>
                                    <label for="ajout11" class="custom-control-label ">Ajout</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification11" type="checkbox" id="modification11"';
                                    if ($row["modification"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["modification"].'"';
                                    }
                                   echo '>
                                       <label for="modification11" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression11" type="checkbox" id="suppression11"';
                                    if ($row["suppression"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["suppression"].'"';
                                    }
                                   echo '>
                                      <label for="suppression11" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>';
    }
    }else{
       echo '<div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">OPERATION</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion11" id="pv_operation">
                              </div>
                            </div>

                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout11" type="checkbox" id="ajout11" >
                                    <label for="ajout11" class="custom-control-label">Ajout</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification11" type="checkbox" id="modification11" >
                                    <label for="modification11" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression11" type="checkbox" id="suppression11" >
                                    <label for="suppression11" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>'; 
    }

         $query2 = $this->db->query('SELECT * from pv_recette where id_profile = '.$id_profil.'')->result_array();

    if (count($query2)>0) {
        # code...
            foreach ($query2 as $row) {
        # code...
        echo '<div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">RECETTE</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion12" id="pv_recette" checked="true">
                              </div>
                            </div>

                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout12" type="checkbox" id="ajout12"
                                    ';
                                    if ($row["ajout"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["ajout"].'"';
                                    }
                                   echo '>
                                    <label for="ajout12" class="custom-control-label ">Ajout</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification12" type="checkbox" id="modification12"';
                                    if ($row["modification"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["modification"].'"';
                                    }
                                   echo '>
                                       <label for="modification12" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression12" type="checkbox" id="suppression12"';
                                    if ($row["suppression"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["suppression"].'"';
                                    }
                                   echo '>
                                      <label for="suppression12" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>';
    }
    }else{
       echo '<div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">RECETTE</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion12" id="pv_recette">
                              </div>
                            </div>

                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout12" type="checkbox" id="ajout12" >
                                    <label for="ajout12" class="custom-control-label">Ajout</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification12" type="checkbox" id="modification12" >
                                    <label for="modification12" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression12" type="checkbox" id="suppression12" >
                                    <label for="suppression12" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>'; 
    }
	
	      $query2 = $this->db->query('SELECT * from pv_gestion_caisse where id_profile = '.$id_profil.'')->result_array();

    if (count($query2)>0) {
        # code...
            foreach ($query2 as $row) {
        # code...
        echo ' <div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">GESTION CAISSE</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion7" id="pv_gestion_caisse" checked="true">
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout7" type="checkbox" id="ajout7"
                                    ';
                                    if ($row["ajout"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["ajout"].'"';
                                    }
                                   echo '>
                                    <label for="ajout7" class="custom-control-label ">Ajout</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification7" type="checkbox" id="modification7"';
                                    if ($row["modification"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["modification"].'"';
                                    }
                                   echo '>
                                      <label for="modification7" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input caisse_suppression suppression7" type="checkbox" id="suppression7"';
                                    if ($row["suppression"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["suppression"].'"';
                                    }
                                   echo '>
                                     <label for="suppression7" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>';
    }
    }else{
       echo '<div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">GESTION CAISSE</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion7" id="pv_gestion_caisse">
                              </div>
                            </div>
                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout7" type="checkbox" id="ajout7" >
                                    <label for="ajout7" class="custom-control-label">Ajout</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification7" type="checkbox" id="modification7" >
                                    <label for="modification7" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input caisse_suppression" type="checkbox" id="suppression7" >
                                    <label for="suppression7" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>'; 
    }



	      $query2 = $this->db->query('SELECT * from pv_rapport where id_profile = '.$id_profil.'')->result_array();

    if (count($query2)>0) {
        # code...
            foreach ($query2 as $row) {
        # code...
        echo '<div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">RAPPORT</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion16" id="pv_rapport" checked="true">
                              </div>
                            </div>

                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout16" type="checkbox" id="ajout16"
                                    ';
                                    if ($row["ajout"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["ajout"].'"';
                                    }
                                   echo '>
                                    <label for="ajout16" class="custom-control-label ">Ajout</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification16" type="checkbox" id="modification16"';
                                    if ($row["modification"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["modification"].'"';
                                    }
                                   echo '>
                                        <label for="modification16" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression16" type="checkbox" id="suppression16"';
                                    if ($row["suppression"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["suppression"].'"';
                                    }
                                   echo '>
                                     <label for="suppression16" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>';
    }
    }else{
       echo '<div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">RAPPORT</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion16" id="pv_rapport">
                              </div>
                            </div>

                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout16" type="checkbox" id="ajout16" >
                                    <label for="ajout16" class="custom-control-label">Ajout</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification16" type="checkbox" id="modification16" >
                                    <label for="modification16" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression16" type="checkbox" id="suppression16" >
                                    <label for="suppression16" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>'; 
    }
	
	
	 $query2 = $this->db->query('SELECT * from pv_commande where id_profile = '.$id_profil.'')->result_array();

    if (count($query2)>0) {
        # code...
            foreach ($query2 as $row) {
        # code...
        echo '<div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">COMMANDE</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion9" id="pv_commande" checked="true">
                              </div>
                            </div>

                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout9" type="checkbox" id="ajout9"
                                    ';
                                    if ($row["ajout"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["ajout"].'"';
                                    }
                                   echo '>
                                    <label for="ajout9" class="custom-control-label ">Ajout</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification9" type="checkbox" id="modification9"';
                                    if ($row["modification"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["modification"].'"';
                                    }
                                   echo '>
                                        <label for="modification9" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression9" type="checkbox" id="suppression9"';
                                    if ($row["suppression"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["suppression"].'"';
                                    }
                                   echo '>
                                     <label for="suppression9" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>';
    }
    }else{
       echo '<div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">COMMANDE</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion9" id="pv_commande">
                              </div>
                            </div>

                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout9" type="checkbox" id="ajout9" >
                                    <label for="ajout9" class="custom-control-label">Ajout</label>
                                  </div>

                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification9" type="checkbox" id="modification9" >
                                    <label for="modification9" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression9" type="checkbox" id="suppression9" >
                                    <label for="suppression9" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>'; 
    }

	 
    
        $query2 = $this->db->query('SELECT * from pv_users where id_profile = '.$id_profil.'')->result_array();

    if (count($query2)>0) {
        # code...
            foreach ($query2 as $row) {
        # code...
        echo '<div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">USERS</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion15" id="pv_users" checked="true">
                              </div>
                            </div>

                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout15" type="checkbox" id="ajout15"
                                    ';
                                    if ($row["ajout"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["ajout"].'"';
                                    }
                                   echo '>
                                    <label for="ajout15" class="custom-control-label ">Ajout</label>
                                  </div>


                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification15" type="checkbox" id="modification15"';
                                    if ($row["modification"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["modification"].'"';
                                    }
                                   echo '>
                                       <label for="modification15" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression15" type="checkbox" id="suppression15"';
                                    if ($row["suppression"] == 'true') {
                                        # code...
                                        echo 'checked="'.$row["suppression"].'"';
                                    }
                                   echo '>
                                      <label for="suppression15" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>';
    }
    }else{
       echo '<div class="card card-success col-md-3">
                            <div class="card-header">
                              <h3 class="card-title">USERS</h3>
                              <div class="card-tools">
                                  <input type="checkbox" class="gestion15" id="pv_users">
                              </div>
                            </div>

                            <div class="card-body">
                              <div class="row">

                                <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input ajout15" type="checkbox" id="ajout15" >
                                    <label for="ajout15" class="custom-control-label">Ajout</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input modification15" type="checkbox" id="modification15" >
                                    <label for="modification15" class="custom-control-label">Modification</label>
                                  </div>
                                  <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input suppression15" type="checkbox" id="suppression15" >
                                    <label for="suppression15" class="custom-control-label">Suppression</label>
                                  </div>
                                
                                </div>
                              </div>
                            </div>
                            <!-- /.card-body -->
                          </div>'; 
    }

      

         
   


 } 


public function getAllNotification(){
  if (isset($_POST['date_debut']) && isset($_POST['date_fin'])) {
          # code...
          $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        }else{
          $date_debut = date("Y-m-d");
        $date_fin = date("Y-m-d");
        }
        $i =0;

      $query = $this->db->query("SELECT * from notification where date_notif between '".$date_debut."' and '".$date_fin."' order by date_notif desc")->result_array();

      if (count($query) >0) {
        # code...
        foreach ($query as $row) {
          # code...
          $query1 = $this->db->query("SELECT * from profil where id_profil = ".$row['id_profil']."")->row();
          echo "<tr>
                <td>".$i."</td>
                <td>".$row['poste']."</td>
              
                <td>".$row['date_notif']."</td>
                <td>".$row['heure_notif']."</td>
                <td>".$row['message']."</td>
               </tr>";
               $i++;
        }
      }
 }
}