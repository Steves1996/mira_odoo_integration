<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model_vehicule extends CI_Model {
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

   // public function selectAllEngin(){
   //      $query1 = $this->db->get_where('engin')->result_array();
   //      $compteur = 0;
   //      foreach ($query1 as $row) {
   //          # code...
   //          echo "<tr >
   //                  <td onclick=\"creerDatable();\">".$compteur."</td>
   //                  <td>".$row['code']."
   //                  </td>
   //                  <td>".$row['immatriculation']."</td>
   //                  <td> ".$row['chassis']."</td>
   //                  <td> ".$row['kilometrage']."</td>
   //                  <td> ".$row['puissance']."</td>";
   //                  $query2 = $this->db->query("select * from chauffeur where id_chauffeur=".$row['id_chauffeur']."")->result_array();
   //                  foreach ($query2 as $row2) {
   //                      # code...
   //                      echo "<td> ".$row2['nom']."</td>
   //                          <td> ".$row2['telephoneChauffeur']."</td>";
   //                  }
   //                 echo" <td>
   //                  <button type='button' onclick=\"formUpdateCamion('".$row['id_engin']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
   //                  <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='engin' identifiant='".$row['id_engin']."' onclick='demandeSuppressionCamionBenne($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_engin\");'><i class='far fa-trash-alt'></i></button>
   //                  </td>
   //                </tr>

   //                ";
   //                $compteur++;
   //      }

   //  }
    public function addCamionBenne($status){
        $type_camion = $_POST['type_camion'];
        $code = $_POST["code"];
        $kilometrage = $_POST["kilometrage"];
        $assurance = $_POST["assurance"];
        $chauffeur = $_POST["chauffeur"];
        $chassis = $_POST["chassis"];
        $puissance = $_POST["puissance"];
        $immatriculation = $_POST["immatriculation"];
        $carte_grise = $_POST["carte_grise"];
        $carte_bleue = $_POST["carte_bleue"];
        $visite_technique = $_POST["visite_technique"];
        $taxe = $_POST["taxe"];
        $acces_port = $_POST["acces_port"];
        $licence_transport = $_POST["licence_transport"];
        $attestation = $_POST["attestation"];
           $nbreRoue = $_POST["nbreRoue"];
        $nbreRoueSecours = $_POST['nbreRoueSecours'];
         $date_init = $_POST["date_init"];
        $montant_init = intval(preg_replace('/\s/','', $_POST['montant_init']));


        $nom_table = "camion_benne";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté un camion benne de code ".$codeCamion." et d'immatriculation ".$immatriculation." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié un camion benne de code ".$codeCamion." et d'immatriculation ".$immatriculation." le ".$date_notif." à ".$heure;


        // echo "ooooo".$type_vehicule;
        if (isset($_POST["id_camion"])) {
            # code...
            $id_camion = $_POST["id_camion"];
        }
        if ($status == "insert") {
            # code...
             $query = $this->db->query("select * from camion_benne where code='".$code."'")->result_array();
        if (count($query)>0) {
            echo "Ce code est déjà utilisé veuillez changer";

        }else{
             $query2 = $this->db->query("select * from tracteur where code='".$code."'")->result_array();
            if (count($query2)>0) {
                echo "Ce code est déjà utilisé veuillez changer";
            }else{
                 $query3 = $this->db->query("select * from tracteur where immatriculation='".$immatriculation."'")->result_array();
                if (count($query3)>0) {
                    echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                }else{
                     $query4 = $this->db->query("select * from camion_benne where immatriculation='".$immatriculation."'")->result_array();
                        if (count($query4)>0) {
                            echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                        }else{
                            $query5 = $this->db->query("select * from camion_benne where immatriculation='".$immatriculation."'")->result_array();
                                if (count($query5)>0) {
                                    echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                                }else{
                                        $query5 = $this->db->query("select * from camion_benne where chassis='".$chassis."'")->result_array();
                                    if (count($query5)>0) {
                                        echo "Ce numéro de chassis appartient déjà à un autre véhicule veuillez changer";
                                    }else{
                                        $query5 = $this->db->query("select * from remorque where chassis='".$chassis."'")->result_array();
                                        if (count($query5)>0) {
                                            echo "Ce numéro de chassis appartient déjà à un autre véhicule veuillez changer";
                                        }else{
                                            $query5 = $this->db->query("select * from tracteur where chassis='".$chassis."'")->result_array();
                                            if (count($query5)>0) {
                                                echo "Ce numéro de chassisappartient déjà à un autre véhicule veuillez changer";
                                            }else{
                                                $query1 = $this->db->query("insert into camion_benne value('','". $code. "','". $immatriculation."','".$chassis."',".$kilometrage.",".$puissance.",".$assurance.",".$carte_grise.",".$carte_bleue.",".$visite_technique.",".$chauffeur.",".$taxe.",".$acces_port.",".$licence_transport.",".$attestation.",".$nbreRoue.",".$nbreRoueSecours.",".$type_camion.",".$montant_init.",CAST('". $date_init."' AS DATE))");
                                        if($query1 == true){
                                            echo "Insertion parfaite du camion";
                                            $this->notificationAjout($nom_table,addslashes($message));
                                        }else{
                                            echo "Erreur durant l'insertion";
                                        } 
                                        $this->db->close();
                                            }
                                        }
                                    }

                                    
                                }
                        }
                }
            }
        }
        }elseif ($status == "update") {
            # code...
             $query = $this->db->query("select * from camion_benne where code='".$code."'")->result_array();
        if (count($query)>0) {
           
            foreach ($query as $row1) {
                # code...
                if ($row1["id_camion"] == $id_camion) {
                    # code...
                    $query2 = $this->db->query("select * from tracteur where code='".$code."'")->result_array();
            if (count($query2)>0) {
                echo "Ce code est déjà utilisé veuillez changer";
            }else{
                 $query3 = $this->db->query("select * from tracteur where immatriculation='".$immatriculation."'")->result_array();
                if (count($query3)>0) {
                    echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                }else{
                     $query4 = $this->db->query("select * from remorque where immatriculation='".$immatriculation."'")->result_array();
                        if (count($query4)>0) {
                            echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                        }else{
                            $query5 = $this->db->query("select * from camion_benne where immatriculation='".$immatriculation."'")->result_array();
                                if (count($query5)>0) {
                                    
                                    foreach ($query5 as $row5) {
                                        # code...
                                        if ($row5["id_camion"] == $id_camion) {
                                            # code...
                                            
                                        $query5 = $this->db->query("select * from camion_benne where chassis='".$chassis."'")->result_array();
                                    if (count($query5)>0) {
                                        
                                        foreach ($query5 as $row5) {
                                        # code...
                                            $query5 = $this->db->query("select * from remorque where chassis='".$chassis."'")->result_array();
                                        if (count($query5)>0) {
                                            echo "Ce numéro de chassis appartient déjà à un autre véhicule veuillez changer";
                                        }else{
                                            $query5 = $this->db->query("select * from tracteur where chassis='".$chassis."'")->result_array();
                                            if (count($query5)>0) {
                                                echo "Ce numéro de chassisappartient déjà à un autre véhicule veuillez changer";
                                            }else{
                                                // $query1 = $this->db->query("insert into camion_benne value('','". $code. "','". $immatriculation."','".$chassis."',".$kilometrage.",".$puissance.",".$assurance.",".$carte_grise.",".$carte_bleue.",".$visite_technique.",".$chauffeur.",".$taxe.",".$acces_port.",".$licence_transport.",".$attestation.")");
                                    //     $getIdChauffeurInTable = $this->db->query("select * from camion_benne where id_chauffeur=".$chauffeur."")->result_array();
                                    // if (count($getIdChauffeurInTable)>0) {
                                                            # code...
                                                            $query1 = $this->db->query("UPDATE camion_benne set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",id_chauffeur=".$chauffeur.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init." where id_camion=".$id_camion."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                                $this->notificationAjout($nom_table,addslashes($message2));
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                            $this->db->close();
                                                        // }else{
                                                        //     $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_chauffeur=".$chauffeur.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours." where id_camion=".$id_camion."");

                                                        //     if($query1 == true){
                                                        //         echo "Modification parfaite du camion";
                                                        //     }else{
                                                        //         echo "Erreur durant l'insertion";
                                                        //     }
                                                        // }
                                            }
                                        }
                                        if ($row5["id_camion"] == $id_camion) {
                                            # code...
                                        }else{
                                           echo "Ce numéro de chassis appartient déjà à un autre véhicule veuillez changer";
                                        }
                                    }
                                    }else{
                                        $query5 = $this->db->query("select * from remorque where chassis='".$chassis."'")->result_array();
                                        if (count($query5)>0) {
                                            echo "Ce numéro de chassis appartient déjà à un autre véhicule veuillez changer";
                                        }else{
                                            $query5 = $this->db->query("select * from tracteur where chassis='".$chassis."'")->result_array();
                                            if (count($query5)>0) {
                                                echo "Ce numéro de chassisappartient déjà à un autre véhicule veuillez changer";
                                            }else{
                                                // $query1 = $this->db->query("insert into camion_benne value('','". $code. "','". $immatriculation."','".$chassis."',".$kilometrage.",".$puissance.",".$assurance.",".$carte_grise.",".$ca