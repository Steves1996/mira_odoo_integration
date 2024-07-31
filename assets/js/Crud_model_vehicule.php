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
                                        }else{
                                            echo "Erreur durant l'insertion";
                                        } 
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
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
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
                                                // $query1 = $this->db->query("insert into camion_benne value('','". $code. "','". $immatriculation."','".$chassis."',".$kilometrage.",".$puissance.",".$assurance.",".$carte_grise.",".$carte_bleue.",".$visite_technique.",".$chauffeur.",".$taxe.",".$acces_port.",".$licence_transport.",".$attestation.")");
                                    //     $getIdChauffeurInTable = $this->db->query("select * from camion_benne where id_chauffeur=".$chauffeur."")->result_array();
                                    // if (count($getIdChauffeurInTable)>0) {
                                                            # code...
                                                            $query1 = $this->db->query("UPDATE camion_benne set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",id_chauffeur=".$chauffeur.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init." where id_camion=".$id_camion."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        // }else{
                                                        //     $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_chauffeur=".$chauffeur.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion." where id_camion=".$id_camion."");

                                                        //     if($query1 == true){
                                                        //         echo "Modification parfaite du camion";
                                                        //     }else{
                                                        //         echo "Erreur durant l'insertion";
                                                        //     }
                                                        // }
                                            }
                                        }
                                    }

                                   
                                        }else{
                                           echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                                        }
                                    }

                                }else{
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
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        // }else{
                                                        //     $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_chauffeur=".$chauffeur.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion." where id_camion=".$id_camion."");

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
                                                // $query1 = $this->db->query("insert into camion_benne value('','". $code. "','". $immatriculation."','".$chassis."',".$kilometrage.",".$puissance.",".$assurance.",".$carte_grise.",".$carte_bleue.",".$visite_technique.",".$chauffeur.",".$taxe.",".$acces_port.",".$licence_transport.",".$attestation.")");
                                    //     $getIdChauffeurInTable = $this->db->query("select * from camion_benne where id_chauffeur=".$chauffeur."")->result_array();
                                    // if (count($getIdChauffeurInTable)>0) {
                                                            # code...
                                                            $query1 = $this->db->query("UPDATE camion_benne set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",id_chauffeur=".$chauffeur.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init." where id_camion=".$id_camion."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        // }else{
                                                        //     $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_chauffeur=".$chauffeur.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion." where id_camion=".$id_camion."");

                                                        //     if($query1 == true){
                                                        //         echo "Modification parfaite du camion";
                                                        //     }else{
                                                        //         echo "Erreur durant l'insertion";
                                                        //     }
                                                        // }
                                            }
                                        }
                                    }

                                    
                                }
                        }
                }
            }

                }else{
                    echo "Ce code est déjà utilisé veuillez changer"; 
                }
            }
        }else{
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
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        // }else{
                                                        //     $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_chauffeur=".$chauffeur.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion." where id_camion=".$id_camion."");

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
                                                // $query1 = $this->db->query("insert into camion_benne value('','". $code. "','". $immatriculation."','".$chassis."',".$kilometrage.",".$puissance.",".$assurance.",".$carte_grise.",".$carte_bleue.",".$visite_technique.",".$chauffeur.",".$taxe.",".$acces_port.",".$licence_transport.",".$attestation.")");
                                    //     $getIdChauffeurInTable = $this->db->query("select * from camion_benne where id_chauffeur=".$chauffeur."")->result_array();
                                    // if (count($getIdChauffeurInTable)>0) {
                                                            # code...
                                                            $query1 = $this->db->query("UPDATE camion_benne set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",id_chauffeur=".$chauffeur.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init." where id_camion=".$id_camion."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        // }else{
                                                        //     $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_chauffeur=".$chauffeur.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion." where id_camion=".$id_camion."");

                                                        //     if($query1 == true){
                                                        //         echo "Modification parfaite du camion";
                                                        //     }else{
                                                        //         echo "Erreur durant l'insertion";
                                                        //     }
                                                        // }
                                            }
                                        }
                                    }

                                   
                                        }else{
                                           echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                                        }
                                    }

                                }else{
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
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        // }else{
                                                        //     $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_chauffeur=".$chauffeur.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion." where id_camion=".$id_camion."");

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
                                                // $query1 = $this->db->query("insert into camion_benne value('','". $code. "','". $immatriculation."','".$chassis."',".$kilometrage.",".$puissance.",".$assurance.",".$carte_grise.",".$carte_bleue.",".$visite_technique.",".$chauffeur.",".$taxe.",".$acces_port.",".$licence_transport.",".$attestation.")");
                                    //     $getIdChauffeurInTable = $this->db->query("select * from camion_benne where id_chauffeur=".$chauffeur."")->result_array();
                                    // if (count($getIdChauffeurInTable)>0) {
                                                            # code...
                                                            $query1 = $this->db->query("UPDATE camion_benne set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",id_chauffeur=".$chauffeur.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init." where id_camion=".$id_camion."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        // }else{
                                                        //     $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_chauffeur=".$chauffeur.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion." where id_camion=".$id_camion."");

                                                        //     if($query1 == true){
                                                        //         echo "Modification parfaite du camion";
                                                        //     }else{
                                                        //         echo "Erreur durant l'insertion";
                                                        //     }
                                                        // }
                                            }
                                        }
                                    }

                                    
                                }
                        }
                }
            }
        }
        }else{
            echo "Erreur contactez votre administrateur";
        }

        
    }


        public function addRemorque($status){
        $assurance = $_POST["assurance"];
        
        $chassis = $_POST["chassis"];
        $immatriculation = $_POST["immatriculation"];
        $carte_grise = $_POST["carte_grise"];
        $carte_bleue = $_POST["carte_bleue"];
        $visite_technique = $_POST["visite_technique"];
           $nbreRoue = $_POST["nbreRoue"];
        $nbreRoueSecours = $_POST['nbreRoueSecours'];
        if (isset($_POST["id_remorque"])) {
            # code...
            $id_remorque = $_POST["id_remorque"];
        }
        if ($status =="insert") {
            # code...
        $query5 = $this->db->query("select * from camion_benne where immatriculation='".$immatriculation."'")->result_array();
        if (count($query5)>0) {
            echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                 }else{
                    $query6 = $this->db->query("select * from tracteur where immatriculation='".$immatriculation."'")->result_array();
                                if (count($query6)>0) {
                                    echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                                }else{
                                    $query7 = $this->db->query("select * from remorque where immatriculation='".$immatriculation."'")->result_array();
                                if (count($query7)>0) {
                                    echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                                }else{
                                            $query1 = $this->db->query("insert into remorque value('','". $immatriculation."','".$chassis."',".$assurance.",".$carte_grise.",".$visite_technique.",".$carte_bleue.",".$nbreRoue.",".$nbreRoueSecours.")");
                                            if($query1 == true){
                                                echo "Insertion parfaite de la remorque";
                                            }else{
                                                echo "Erreur durant l'insertion";
                                            }
                                    
                      
                                }
                                }
                 }
        }elseif ($status == "update") {
            # code...
              $query5 = $this->db->query("select * from camion_benne where chassis='".$chassis."'")->result_array();
        if (count($query5)>0) {
            echo "Cette numéro de chassis appartient déjà à un autre véhicule veuillez changer";
                 }else{
                    $query6 = $this->db->query("select * from tracteur where chassis='".$chassis."'")->result_array();
                                if (count($query6)>0) {
                                    echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                                }else{
                                    $query8 = $this->db->query("select * from remorque where chassis='".$chassis."'")->result_array();
                                if (count($query8)>0) {
                                    // on verifie que le chassis existant appartien a la meme remorque 
                                    foreach ($query8 as $row3) {
                                        # code...
                                        if ($row3["id_remorque"] == $id_remorque) {
                                            # code...
$query5 = $this->db->query("select * from camion_benne where immatriculation='".$immatriculation."'")->result_array();
        if (count($query5)>0) {
            echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                 }else{
                    $query6 = $this->db->query("select * from tracteur where immatriculation='".$immatriculation."'")->result_array();
                                if (count($query6)>0) {
                                    echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                                }else{
                                    $query7 = $this->db->query("select * from remorque where immatriculation='".$immatriculation."'")->result_array();
                                if (count($query7)>0) {
                                    
                                    foreach ($query7 as $row2) {
                                        # code...
                                        if ($row2["id_remorque"] == $id_remorque) {
                                            # code...
                                             $query1 = $this->db->query("UPDATE remorque set immatriculation='". $immatriculation."',chassis='".$chassis."',id_assurance = ".$assurance.", id_carte_grise = ".$carte_grise.",id_visite =".$visite_technique.",id_carte_bleue=".$carte_bleue.",nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours." where id_remorque=".$id_remorque."");
                                        if($query1 == true){
                                                echo "modification parfaite de la remorque";
                                            }else{
                                                echo "Erreur durant la modification";
                                            }
                                        }else{
                                           echo "Cette immatriculation appartient déjà à une autre remorque veuillez changer"; 
                                        }
                                    }
                                }else{
                                     $query1 = $this->db->query("UPDATE remorque set immatriculation='". $immatriculation."',chassis='".$chassis."',id_assurance = ".$assurance.", id_carte_grise = ".$carte_grise.",id_visite =".$visite_technique.",id_carte_bleue=".$carte_bleue.",nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours." where id_remorque=".$id_remorque."");
                                        if($query1 == true){
                                                echo "modification parfaite de la remorque";
                                            }else{
                                                echo "Erreur durant la modification";
                                            }
                                }
                 }
        }
                                        }else{
                                            echo "Cette numéro de chassis appartient déjà à un autre véhicule veuillez changer";
                                        }
                                    }
                                }else{
                                    // au cas où il nya aucun chassis on avance epicetou
                                   $query5 = $this->db->query("select * from camion_benne where immatriculation='".$immatriculation."'")->result_array();
        if (count($query5)>0) {
            echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                 }else{
                    $query6 = $this->db->query("select * from tracteur where immatriculation='".$immatriculation."'")->result_array();
                                if (count($query6)>0) {
                                    echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                                }else{
                                    $query7 = $this->db->query("select * from remorque where immatriculation='".$immatriculation."'")->result_array();
                                if (count($query7)>0) {
                                    
                                    foreach ($query7 as $row2) {
                                        # code...
                                        if ($row2["id_remorque"] == $id_remorque) {
                                            # code...
                                             $query1 = $this->db->query("UPDATE remorque set immatriculation='". $immatriculation."',chassis='".$chassis."',id_assurance = ".$assurance.", id_carte_grise = ".$carte_grise.",id_visite =".$visite_technique.",id_carte_bleue=".$carte_bleue.",nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours." where id_remorque=".$id_remorque."");
                                        if($query1 == true){
                                                echo "modification parfaite de la remorque";
                                            }else{
                                                echo "Erreur durant la modification";
                                            }
                                        }else{
                                           echo "Cette immatriculation appartient déjà à une autre remorque veuillez changer"; 
                                        }
                                    }
                                }else{
                                     $query1 = $this->db->query("UPDATE remorque set immatriculation='". $immatriculation."',chassis='".$chassis."',id_assurance = ".$assurance.", id_carte_grise = ".$carte_grise.",id_visite =".$visite_technique.",id_carte_bleue=".$carte_bleue.",nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours." where id_remorque=".$id_remorque."");
                                        if($query1 == true){
                                                echo "modification parfaite de la remorque";
                                            }else{
                                                echo "Erreur durant la modification";
                                            }
                                }
                 }
        } 
                                }
                            }
                        }


            
        }else{
            echo "Erreur contactez l'administrateur";
        }
        
    }

    public function selectAllCamionBenne(){
        $query1 = $this->db->get_where('camion_benne')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['code']."
                    </td>
                    <td>".$row['immatriculation']."</td>
                    <td> ".$row['chassis']."</td>
                    <td> ".$row['kilometrage']."</td>
                    <td> ".$row['puissance']."</td>";
                    $query2 = $this->db->query("select * from chauffeur where id_chauffeur=".$row['id_chauffeur']."")->result_array();
                    foreach ($query2 as $row2) {
                        # code...
                        echo "<td> ".$row2['nom']."</td>
                            <td> ".$row2['telephoneChauffeur']."</td>";
                    }
                   echo" <td>
                    <button type='button' onclick=\"formUpdateCamion('".$row['id_camion']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='camion_benne' identifiant='".$row['id_camion']."' onclick='demandeSuppressionCamionBenne($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_camion\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                  $compteur++;
        }

    }
        public function selectAllEngin(){
        $query1 = $this->db->get_where('engin')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['code']."
                    </td>
                    <td>".$row['immatriculation']."</td>
                    <td> ".$row['chassis']."</td>
                    <td> ".$row['kilometrage']."</td>
                    <td> ".$row['puissance']."</td>";
                    $query2 = $this->db->query("select * from chauffeur where id_chauffeur=".$row['id_chauffeur']."")->result_array();
                    foreach ($query2 as $row2) {
                        # code...
                        echo "<td> ".$row2['nom']."</td>
                            <td> ".$row2['telephoneChauffeur']."</td>";
                    }
                   echo" <td>
                    <button type='button' onclick=\"formUpdateEngin('".$row['id_camion']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='engin' identifiant='".$row['id_camion']."' onclick='demandeSuppressionCamionBenne($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_camion\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                  $compteur++;
        }

    }
    public function selectAllRemorque(){
        $query1 = $this->db->query('SELECT * from remorque order by id_remorque desc')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    
                    <td>".$row['immatriculation']."</td>
                    <td> ".$row['chassis']."</td>
                    ";
                    $query2 = $this->db->query("select * from assurance where id_assurance=".$row['id_assurance']."")->result_array();
                    foreach ($query2 as $row2) {
                        # code...
                        echo "<td> ".$row2['numero']."</td>";
                    }
                    $query2 = $this->db->query("select * from carte_grise where id_carte_grise=".$row['id_carte_grise']."")->result_array();
                    foreach ($query2 as $row2) {
                        # code...
                        echo "<td> ".$row2['numero']."</td>";
                    }
                    $query2 = $this->db->query("select * from carte_bleue where id_carte_bleue=".$row['id_carte_bleue']."")->result_array();
                    foreach ($query2 as $row2) {
                        # code...
                        echo "<td> ".$row2['numero']."</td>";
                    }
                    $query2 = $this->db->query("select * from visite_technique where id_visite=".$row['id_visite']."")->result_array();
                    foreach ($query2 as $row2) {
                        # code...
                        echo "<td> ".$row2['numero']."</td>";
                    }
                   echo"
                    <td>
                    <button type='button' onclick=\"formUpdateRemorque('".$row['id_remorque']."');\" class=' btn-primary btn-sm' ><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal'  data-target='#modal-primary' table='remorque' identifiant='".$row['id_remorque']."' onclick='demandeSuppressionCamionBenne($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_remorque\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                  $compteur++;
        }

    }
        public function selectAllTracteur(){
        $query1 = $this->db->get_where('tracteur')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['code']."
                    </td>
                    <td>".$row['immatriculation']."</td>
                    <td> ".$row['chassis']."</td>
                    <td> ".$row['kilometrage']."</td>
                    <td> ".$row['puissance']."</td>";
                    $query2 = $this->db->query("select * from chauffeur where id_chauffeur=".$row['id_chauffeur']."")->result_array();
                    foreach ($query2 as $row2) {
                        # code...
                        echo "<td> ".$row2['nom']."</td>
                            <td> ".$row2['telephoneChauffeur']."</td>";
                    }
                    $query2 = $this->db->query("select * from remorque where id_remorque=".$row['id_remorque']."")->result_array();
                    foreach ($query2 as $row2) {
                        # code...
                        echo "<td> ".$row2['immatriculation']."</td>";
                    }
                   echo" <td>
                    <button type='button' onclick=\"formUpdateTracteur('".$row['id_tracteur']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='tracteur' identifiant='".$row['id_tracteur']."' onclick='demandeSuppressionCamionBenne($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_tracteur\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                  $compteur++;
        }

    }

    public function addTracteur($status){

        $type_camion = $_POST['type_camion'];
        $typeTracteur = $_POST["typeTracteur"];
        $code = $_POST["code"];
        $remorque = $_POST["remorque"];
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

        if (isset($_POST["id_tracteur"])) {
            # code...
            $id_tracteur = $_POST["id_tracteur"];
        }
        if ($status =="insert") {
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
                                        echo "Ce numéro de chassis appartient déjà à un autre véhicule veuillez le changer";
                                    }else{
                                        $query5 = $this->db->query("select * from remorque where chassis='".$chassis."'")->result_array();
                                        if (count($query5)>0) {
                                            echo "Ce numéro de chassis appartient déjà à un autre véhicule veuillez le changer";
                                        }else{
                                            $query5 = $this->db->query("select * from tracteur where chassis='".$chassis."'")->result_array();
                                            if (count($query5)>0) {
                                                echo "Ce numéro de chassis appartient déjà à un autre véhicule veuillez le changer";
                                            }else{

                                   $query1 = $this->db->query("insert into tracteur value('','". $code. "','". $immatriculation."','".$chassis."',".$kilometrage.",".$puissance.",".$assurance.",".$carte_grise.",".$carte_bleue.",".$visite_technique.",".$chauffeur.",".$taxe.",".$acces_port.",".$licence_transport.",".$attestation.",".$remorque.",'".$typeTracteur."',".$nbreRoue.",".$nbreRoueSecours.",".$type_camion.",".$montant_init.",CAST('". $date_init."' AS DATE))");

                                    if($query1 == true){
                                        echo "Insertion parfaite du camion";
                                    }else{
                                        echo "Erreur durant l'insertion";
                                    }
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
            echo "Ce code est déjà utilisé veuillez changer";

        }else{
             $query2 = $this->db->query("select * from tracteur where code='".$code."'")->result_array();
            if (count($query2)>0) {
               
                foreach ($query2 as $row12) {
                    # code... On va vérifier si le code existant est celui du tracteur
                    if ($id_tracteur == $row12["id_tracteur"]) {
                        # code...
                        
                 $query3 = $this->db->query("select * from tracteur where immatriculation='".$immatriculation."'")->result_array();
                if (count($query3)>0) {
                    foreach ($query3 as $row13) {
                        # code...
                        if ($id_tracteur == $row13["id_tracteur"]) {
                            # code...
                           
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
                                                        foreach ($query5 as $row14) {
                                                            # code...
                                                            if ($id_tracteur == $row14["id_tracteur"]) {
                                                                # code...


                                                        $getIdremorqueInTable = $this->db->query("select * from tracteur where id_remorque=".$remorque."")->result_array();
                                                        $getIdChauffeurInTable = $this->db->query("select * from tracteur where id_chauffeur=".$chauffeur."")->result_array();
                                                        if (count($getIdremorqueInTable)>0) {
                                                            # code...
                                                            $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_chauffeur=".$chauffeur.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.", type='".$typeTracteur."',nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init." where id_tracteur=".$id_tracteur."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        }elseif (count($getIdChauffeurInTable)>0) {
                                                            # code...
                                                            $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",id_remorque=".$remorque.",type='".$typeTracteur."',nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init." where id_tracteur=".$id_tracteur."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        }else{
                                                            $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_chauffeur=".$chauffeur.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",id_remorque=".$remorque.",type='".$typeTracteur."',nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init."  where id_tracteur=".$id_tracteur."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        }
                                                      
                                                            }else{
                                                                echo "Ce numéro de chassis appartient déjà à un autre véhicule veuillez changer";
                                                            }
                                                        }
                                                        
                                                    }else{

                                                        $getIdremorqueInTable = $this->db->query("select * from tracteur where id_remorque=".$remorque."")->result_array();
                                                        $getIdChauffeurInTable = $this->db->query("select * from tracteur where id_chauffeur=".$chauffeur."")->result_array();
                                                        if (count($getIdremorqueInTable)>0) {
                                                            # code...
                                                            $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_chauffeur=".$chauffeur.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",type='".$typeTracteur."',nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init." where id_tracteur=".$id_tracteur."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        }elseif (count($getIdChauffeurInTable)>0) {
                                                            # code...
                                                            $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",id_remorque=".$remorque.",type='".$typeTracteur."',nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init." where id_tracteur=".$id_tracteur."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        }else{
                                                            $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_chauffeur=".$chauffeur.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",id_remorque=".$remorque.",type='".$typeTracteur."',nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init."  where id_tracteur=".$id_tracteur."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        }
                                                      
                                                    }
                                            }
                                        }
                                   
                                }
                        }
                        }else{
                            echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                        }
                    }
                    
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
                                                        foreach ($query5 as $row14) {
                                                            # code...
                                                            if ($id_tracteur == $row14["id_tracteur"]) {
                                                                # code...


                                                        $getIdremorqueInTable = $this->db->query("select * from tracteur where id_remorque=".$remorque."")->result_array();
                                                        $getIdChauffeurInTable = $this->db->query("select * from tracteur where id_chauffeur=".$chauffeur."")->result_array();
                                                        if (count($getIdremorqueInTable)>0) {
                                                            # code...
                                                            $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_chauffeur=".$chauffeur.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",type='".$typeTracteur."',nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init." where id_tracteur=".$id_tracteur."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        }elseif (count($getIdChauffeurInTable)>0) {
                                                            # code...
                                                            $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",id_remorque=".$remorque.",type='".$typeTracteur."',nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init." where id_tracteur=".$id_tracteur."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        }else{
                                                            $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_chauffeur=".$chauffeur.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",id_remorque=".$remorque.",type='".$typeTracteur."',nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init."  where id_tracteur=".$id_tracteur."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        }
                                                      
                                                            }else{
                                                                echo "Ce numéro de chassis appartient déjà à un autre véhicule veuillez changer";
                                                            }
                                                        }
                                                        
                                                    }else{

                                                        $getIdremorqueInTable = $this->db->query("select * from tracteur where id_remorque=".$remorque."")->result_array();
                                                        $getIdChauffeurInTable = $this->db->query("select * from tracteur where id_chauffeur=".$chauffeur."")->result_array();
                                                        if (count($getIdremorqueInTable)>0) {
                                                            # code...
                                                            $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_chauffeur=".$chauffeur.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",type='".$typeTracteur."',nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init." where id_tracteur=".$id_tracteur."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        }elseif (count($getIdChauffeurInTable)>0) {
                                                            # code...
                                                            $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",id_remorque=".$remorque.",type='".$typeTracteur."',nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init." where id_tracteur=".$id_tracteur."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        }else{
                                                            $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_chauffeur=".$chauffeur.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",id_remorque=".$remorque.",type='".$typeTracteur."',nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init."  where id_tracteur=".$id_tracteur."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        }
                                                      
                                                    }
                                            }
                                        }
                                   
                                }
                        }
                }
                    }else{
                        echo "Ce code est déjà utilisé veuillez changer"; 
                    }
                }
            }else{
                 $query3 = $this->db->query("select * from tracteur where immatriculation='".$immatriculation."'")->result_array();
                if (count($query3)>0) {
                    foreach ($query3 as $row13) {
                        # code...
                        if ($id_tracteur == $row13["id_tracteur"]) {
                            # code...
                           
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
                                                        foreach ($query5 as $row14) {
                                                            # code...
                                                            if ($id_tracteur == $row14["id_tracteur"]) {
                                                                # code...


                                                        $getIdremorqueInTable = $this->db->query("select * from tracteur where id_remorque=".$remorque."")->result_array();
                                                        $getIdChauffeurInTable = $this->db->query("select * from tracteur where id_chauffeur=".$chauffeur."")->result_array();
                                                        if (count($getIdremorqueInTable)>0) {
                                                            # code...
                                                            $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_chauffeur=".$chauffeur.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",type='".$typeTracteur."',nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init." where id_tracteur=".$id_tracteur."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        }elseif (count($getIdChauffeurInTable)>0) {
                                                            # code...
                                                            $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",id_remorque=".$remorque.",type='".$typeTracteur."',nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init." where id_tracteur=".$id_tracteur."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        }else{
                                                            $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_chauffeur=".$chauffeur.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",id_remorque=".$remorque.",type='".$typeTracteur."',nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init."  where id_tracteur=".$id_tracteur."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        }
                                                      
                                                            }else{
                                                                echo "Ce numéro de chassis appartient déjà à un autre véhicule veuillez changer";
                                                            }
                                                        }
                                                        
                                                    }else{

                                                        $getIdremorqueInTable = $this->db->query("select * from tracteur where id_remorque=".$remorque."")->result_array();
                                                        $getIdChauffeurInTable = $this->db->query("select * from tracteur where id_chauffeur=".$chauffeur."")->result_array();
                                                        if (count($getIdremorqueInTable)>0) {
                                                            # code...
                                                            $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_chauffeur=".$chauffeur.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",type='".$typeTracteur."',nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init." where id_tracteur=".$id_tracteur."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        }elseif (count($getIdChauffeurInTable)>0) {
                                                            # code...
                                                            $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",id_remorque=".$remorque.",type='".$typeTracteur."',nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init." where id_tracteur=".$id_tracteur."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        }else{
                                                            $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_chauffeur=".$chauffeur.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",id_remorque=".$remorque.",type='".$typeTracteur."',nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init."  where id_tracteur=".$id_tracteur."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        }
                                                      
                                                    }
                                            }
                                        }
                                   
                                }
                        }
                        }else{
                            echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                        }
                    }
                    
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
                                                        foreach ($query5 as $row14) {
                                                            # code...
                                                            if ($id_tracteur == $row14["id_tracteur"]) {
                                                                # code...


                                                        $getIdremorqueInTable = $this->db->query("select * from tracteur where id_remorque=".$remorque."")->result_array();
                                                        $getIdChauffeurInTable = $this->db->query("select * from tracteur where id_chauffeur=".$chauffeur."")->result_array();
                                                        if (count($getIdremorqueInTable)>0) {
                                                            # code...
                                                            $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_chauffeur=".$chauffeur.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",type='".$typeTracteur."',nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init." where id_tracteur=".$id_tracteur."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        }elseif (count($getIdChauffeurInTable)>0) {
                                                            # code...
                                                            $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",id_remorque=".$remorque.",type='".$typeTracteur."',nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init." where id_tracteur=".$id_tracteur."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        }else{
                                                            $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_chauffeur=".$chauffeur.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",id_remorque=".$remorque.",type='".$typeTracteur."',nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init."  where id_tracteur=".$id_tracteur."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        }
                                                      
                                                            }else{
                                                                echo "Ce numéro de chassis appartient déjà à un autre véhicule veuillez changer";
                                                            }
                                                        }
                                                        
                                                    }else{

                                                        $getIdremorqueInTable = $this->db->query("select * from tracteur where id_remorque=".$remorque."")->result_array();
                                                        $getIdChauffeurInTable = $this->db->query("select * from tracteur where id_chauffeur=".$chauffeur."")->result_array();
                                                        if (count($getIdremorqueInTable)>0) {
                                                            # code...
                                                            $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_chauffeur=".$chauffeur.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",type='".$typeTracteur."',nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init." where id_tracteur=".$id_tracteur."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        }elseif (count($getIdChauffeurInTable)>0) {
                                                            # code...
                                                            $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",id_remorque=".$remorque.",type='".$typeTracteur."',nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init." where id_tracteur=".$id_tracteur."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        }else{
                                                            $query1 = $this->db->query("UPDATE tracteur set code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_carte_bleue=".$carte_bleue.",id_visite=".$visite_technique.",id_chauffeur=".$chauffeur.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",id_remorque=".$remorque.",type='".$typeTracteur."',nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours.",id_type_camion=".$type_camion.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init."  where id_tracteur=".$id_tracteur."");

                                                            if($query1 == true){
                                                                echo "Modification parfaite du camion";
                                                            }else{
                                                                echo "Erreur durant l'insertion";
                                                            }
                                                        }
                                                      
                                                    }
                                            }
                                        }
                                   
                                }
                        }
                }
            }
        }
         

        }else{
            echo "Erreur inconnu contactez l'administrateur";
        }
         
    }
    public function getNumeroCarteGrise($id_remorque){
        $query = $this->db->query("select * from carte_grise where id_carte_grise=".$id_remorque."")->result_array();
        if (count($query) > 0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_carte_grise"]."'>".$row['numero']."</option>";
            }
        }
    }
    public function getNumeroAssurance($id_remorque){
        $query = $this->db->query("select * from assurance where id_assurance=".$id_remorque."")->result_array();
        if (count($query) > 0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_assurance"]."'>".$row['numero']."</option>";
            }
        }
    }
    public function getNumeroCarteBleue($id_remorque){
        $query = $this->db->query("select * from carte_bleue where id_carte_bleue=".$id_remorque."")->result_array();
        if (count($query) > 0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_carte_bleue"]."'>".$row['numero']."</option>";
            }
        }
    }
    public function getNumeroVisiteTechnique($id_remorque){
        $query = $this->db->query("select * from visite_technique where id_visite=".$id_remorque."")->result_array();
        if (count($query) > 0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_visite"]."'>".$row['numero']."</option>";
            }
        }
    }
    public function getNumeroTaxe($id_remorque){
        $query = $this->db->query("select * from taxe_essieu where id_taxe_essieu=".$id_remorque."")->result_array();
        if (count($query) > 0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_taxe_essieu"]."'>".$row['numero']."</option>";
            }
        }
    }
    public function getNumeroAccesPort($id_remorque){
        $query = $this->db->query("select * from acces_port where id_acces_port=".$id_remorque."")->result_array();
        if (count($query) > 0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_acces_port"]."'>".$row['numero']."</option>";
            }
        }
    }
    public function getNumeroLicenceTransport($id_remorque){
        $query = $this->db->query("select * from licence_transport where id_licence_transport=".$id_remorque."")->result_array();
        if (count($query) > 0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_licence_transport"]."'>".$row['numero']."</option>";
            }
        }
    }
    public function getNumeroAttestationNonRedevance($id_remorque){
        $query = $this->db->query("select * from attestation_non_redevance where id_attestation=".$id_remorque."")->result_array();
        if (count($query) > 0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_attestation"]."'>".$row['numero']."</option>";
            }
        }
    }
    public function getTelephoneChauffeur($id_remorque){
        $query = $this->db->query("select * from chauffeur where id_chauffeur=".$id_remorque."")->result_array();
        if (count($query) > 0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_chauffeur"]."'>".$row['telephoneChauffeur']."</option>";
            }
        }
    }
    public function getCodeRemorque($id_remorque){
        $query = $this->db->query("select * from remorque where id_remorque=".$id_remorque."")->result_array();
        if (count($query) > 0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_remorque"]."'>".$row['immatriculation']."</option>";
            }
        }
    }
    public function afficheFormModifRemorque($id_remorque){
        $query1 = $this->db->query("select * from remorque where id_remorque=".$id_remorque."")->result_array();
        if (count($query1) == 1) {
            # code...
        foreach ($query1 as $row) {
        echo '<div class="row">
                  
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Immatriculation</label>
                        <input type="text" value="'.$row["immatriculation"].'" class="form-control immatriculation" placeholder="Enter ...">
                      </div>
                    </div><div class="col-sm-6">
                      <div class="form-group">
                        <label>N° chassis</label>
                        <input type="text" value="'.$row["chassis"].'" class="form-control chassis" placeholder="Enter ...">
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12"><h3 style="text-decoration: underline; text-align: center;">ROUES</h3>
                    <hr/></div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Chaussée</label>
                        <input type="text" class="form-control nbreRoue" value="'.$row["nbreRoue"].'" onkeypress="chiffres(event);" placeholder="Nombre de roues à chausser">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>secours</label>
                        <input type="text" class="form-control nbreRoueSecours" value="'.$row["nbreRoueSecours"].'" onkeypress="chiffres(event);" placeholder="Nombre de roues de secours">
                      </div>
                    </div>
                    </div>
                 </div>';
             }
        }

    }
    public function afficheFormModifRemorque2($id_remorque){
        
        $query1 = $this->db->query("select * from remorque where id_remorque=".$id_remorque."")->result_array();
        if (count($query1)==1) {
            # code...
        foreach ($query1 as $row) {
            # code...
            echo '<div class="row">
                   <div class="col-sm-6">
                      <div class="form-group">
                        <label>Assurance</label>
                        <select class="assurance form-control">
                        ';
                        $this->getNumeroAssurance($row["id_assurance"]);
                        $this->crud_model_document->leSelectAssurance("remorque");
                        echo'
                          
                            
                          </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Carte grise</label>
                        <select class="carte_grise form-control">
                        ';
                        $this->getNumeroCarteGrise($row["id_carte_grise"]);
                        $this->crud_model_document->leSelectCarteGrise("remorque");
                        echo '
                            
                          </select>
                      </div>
                    </div><div class="col-sm-6">
                      <div class="form-group">
                        <label>Carte bleue</label>
                        <select class="carte_bleue form-control">
                        '; 
                        $this->getNumeroCarteBleue($row["id_carte_bleue"]);
                        $this->crud_model_document->leSelecCarteBleue("remorque");
                        echo '
                          </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Visite technique</label>
                        <select class="visite_technique form-control">
                        '; 
                        $this->getNumeroVisiteTechnique($row["id_visite"]);
                        $this->crud_model_document->leSelecVisiteTechnique("remorque");
                        echo'
                          </select>
                      </div>
                    </div>
                    
                 </div>
                 <br>  <button type="button" class=" btn-primary btn-lg"  onclick="addRemorque(\'update\');">Modifier</button>';
        }
        
        }
    }


    public function afficheFormModifTracteur($id_tracteur){
        $query1 = $this->db->query("select * from tracteur where id_tracteur=".$id_tracteur."")->result_array();
        if (count($query1)==1) {
            # code...
        foreach ($query1 as $row) {
            # code...
        echo '
        <div class="row">
                   <div class="col-sm-6">
                      <div class="form-group">
                        <label>Code</label>
                        <input type="text" class="form-control code" value="'.$row["code"].'" placeholder="Enter ...">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Immatriculation</label>
                        <input type="text" class="form-control immatriculation" value="'.$row["immatriculation"].'" placeholder="Enter ...">
                      </div>
                    </div><div class="col-sm-6">
                      <div class="form-group">
                        <label>N° chassis</label>
                        <input type="text" class="form-control chassis" value="'.$row["chassis"].'" placeholder="Enter ...">
                      </div>
                    </div><div class="col-sm-6">
                      <div class="form-group">
                        <label>Kilometrage</label>
                        <input type="text" class="form-control kilometrage" value="'.$row["kilometrage"].'" onkeypress="chiffres(event);" placeholder="Enter ...">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Chauffeur</label>
                        <select class="chauffeur form-control">';
                        $this->getTelephoneChauffeur($row["id_chauffeur"]);
                         $this->crud_model_chauffeur->leSelectChauffeur("tracteur"); 
                        echo'    
                        </select>

                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Puissance</label>
                        <input type="text" class="form-control puissance" value="'.$row["puissance"].'" placeholder="Enter ..." onkeypress="chiffres(event);">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Remorque</label>
                        <select class="remorque form-control">';
                           $this->getCodeRemorque($row["id_remorque"]);
                           $this->crud_model_document->leSelectRemorque("tracteur");
                            
                        echo'</select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Type</label>
                        <select class="typeTracteur form-control">
                          <option>Ancien</option>
                          <option>Nouveau</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Montant initialisation</label>
                        <input type="text" class="form-control montantInitialisation" onkeypress="chiffres(event);" placeholder="Nombre de roues à chausser" onkeyup ="formatMillier(\'montantInitialisation\');" value="'.$row["montant_init"].'">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Date initialisation</label>
                        <div class="input-group " id="" data-target-input="nearest" >
                                <input type="date" class="form-control datetimepicker-input dateInitialisation" data-target="#reservationdate" placeholder="date effet" value="'.$row["date_init"].'"/>
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                            <div class="form-group">
                            <label>Type de Tracteur</label>
                            <select class="type_camion form-control">';
                                $this->leSelectTypeTracteur(); 
                                echo'</select>
                          
                             </div>
                            
                        
                          </div>
                    <div class="row">
                      <div class="col-sm-12"><h3 style="text-decoration: underline; text-align: center;">ROUES</h3>
                    <hr/></div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Chaussée</label>
                        <input type="text" class="form-control nbreRoue" value="'.$row["nbreRoue"].'" onkeypress="chiffres(event);" placeholder="Nombre de roues à chausser">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>secours</label>
                        <input type="text" class="form-control nbreRoueSecours" value="'.$row["nbreRoueSecours"].'" onkeypress="chiffres(event);" placeholder="Nombre de roues de secours">
                      </div>
                    </div>
                    </div>
                    
                 </div>';
    }
 }
}
 public function afficheFormModifTracteur2($id_tracteur){
        $query1 = $this->db->query("select * from tracteur where id_tracteur=".$id_tracteur."")->result_array();
        if (count($query1)==1) {
            # code...
        foreach ($query1 as $row) {
           echo'<div class="row">
                   <div class="col-sm-6">
                      <div class="form-group">
                        <label>Assurance</label>
                        <select class="assurance form-control">';
                          $this->getNumeroAssurance($row["id_assurance"]);
                          $this->crud_model_document->leSelectAssurance("tracteur");
                            
                        echo'</select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Carte grise</label>
                        <select class="carte_grise form-control">';
                        $this->getNumeroCarteGrise($row["id_carte_grise"]);
                         $this->crud_model_document->leSelectCarteGrise("tracteur");
                            
                          echo'</select>
                      </div>
                    </div><div class="col-sm-6">
                      <div class="form-group">
                        <label>Carte bleue</label>
                        <select class="carte_bleue form-control">
                        ';
                        $this->getNumeroCarteBleue($row["id_carte_bleue"]);
                        $this->crud_model_document->leSelecCarteBleue("tracteur"); 
                            
                         echo' </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Visite technique</label>
                        <select class="visite_technique form-control">';
                          $this->getNumeroVisiteTechnique($row["id_visite"]);
                          $this->crud_model_document->leSelecVisiteTechnique("tracteur"); 
                            
                          echo'</select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Taxe</label>
                        <select class="taxe form-control">';
                          $this->getNumeroTaxe($row["id_taxe_essieu"]);
                          $this->crud_model_document->leSelecTaxe("tracteur"); 
                            
                         echo' </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Acces port</label>
                       <select class="acces_port form-control">';
                          $this->crud_model_document->leSelectAccesPort(); 
                            
                        echo'</select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Licence_transport</label>
                        <select class="licence_transport form-control">';
                          
                           $this->crud_model_document->leSelectLicenceTransport();
                            
                       echo' </select>
                      </div>
                    </div><div class="col-sm-6">
                      <div class="form-group">
                        <label>Attestation non redevance</label>
                        <select class="attestation form-control">';
                          $this->getNumeroAttestationNonRedevance($row["id_attestation"]);
                          $this->crud_model_document->leSelectAttestation("tracteur");
                            
                        echo'</select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <br>  <button type="button" class=" btn-primary btn-lg"  onclick="addTracteur(\'update\');">Modifier</button>
                      </div>
                    </div>

                 </div>';
    }
 }
}

public function afficheFormModifCamionBenne($id_camion){
    $query1 = $this->db->query("select * from camion_benne where id_camion=".$id_camion."")->result_array();
        if (count($query1)==1) {
            # code...
        foreach ($query1 as $row) {
            echo '<div class="row">
                   <div class="col-sm-6">
                      <div class="form-group">
                        <label>Code</label>
                        <input type="text" class="form-control code" value="'.$row["code"].'" placeholder="Enter ...">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Immatriculation</label>
                        <input type="text" class="form-control immatriculation" value="'.$row["immatriculation"].'" placeholder="Enter ...">
                      </div>
                    </div><div class="col-sm-6">
                      <div class="form-group">
                        <label>N° chassis</label>
                        <input type="text" class="form-control chassis" value="'.$row["chassis"].'" placeholder="Enter ...">
                      </div>
                    </div><div class="col-sm-6">
                      <div class="form-group">
                        <label>Kilometrage</label>
                        <input type="text" class="form-control kilometrage" value="'.$row["kilometrage"].'" onkeypress="chiffres(event);" placeholder="Enter ...">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Chauffeur</label>
                        <select class="chauffeur form-control">';
                        $this->getTelephoneChauffeur($row["id_chauffeur"]);
                        $this->crud_model_chauffeur->leSelectChauffeur("camion_benne");
                            
                        echo'</select>

                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Puissance</label>
                        <input type="text" class="form-control puissance" value="'.$row["puissance"].'" placeholder="Enter ..." onkeypress="chiffres(event);">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Montant initialisation</label>
                        <input type="text" class="form-control montantInitialisation" onkeypress="chiffres(event);" placeholder="Nombre de roues à chausser" onkeyup ="formatMillier(\'montantInitialisation\');" value="'.$row["montant_init"].'">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Date initialisation</label>
                        <div class="input-group " id="" data-target-input="nearest" >
                                <input type="date" class="form-control datetimepicker-input dateInitialisation" data-target="#reservationdate" placeholder="date effet" value="'.$row["date_init"].'"/>
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                            <div class="form-group">
                            <label>Type de Camion</label>
                            <select class="type_camion form-control">';
                             $this->crud_model_vehicule->leSelectTypeBenne();
                            echo '</select>
                          
                             </div>
                            
                        
                          </div>
                 </div>
                 <div class="row">
                      <div class="col-sm-12"><h3 style="text-decoration: underline; text-align: center;">ROUES</h3>
                    <hr/></div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Chaussée</label>
                        <input type="text" class="form-control nbreRoue" value="'.$row["nbreRoue"].'" onkeypress="chiffres(event);" placeholder="Nombre de roues à chausser">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>secours</label>
                        <input type="text" class="form-control nbreRoueSecours" value="'.$row["nbreRoueSecours"].'" onkeypress="chiffres(event);" placeholder="Nombre de roues de secours">
                      </div>
                    </div>
                    </div>';
        }
    }
}
public function afficheFormModifEngin($id_camion){
    $query1 = $this->db->query("SELECT * from engin where id_camion=".$id_camion."")->result_array();
        if (count($query1)==1) {
            # code...
        foreach ($query1 as $row) {
            echo '<div class="row">
                   <div class="col-sm-6">
                      <div class="form-group">
                        <label>Code</label>
                        <input type="text" class="form-control code" value="'.$row["code"].'" placeholder="Enter ...">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Immatriculation</label>
                        <input type="text" class="form-control immatriculation" value="'.$row["immatriculation"].'" placeholder="Enter ...">
                      </div>
                    </div><div class="col-sm-6">
                      <div class="form-group">
                        <label>N° chassis</label>
                        <input type="text" class="form-control chassis" value="'.$row["chassis"].'" placeholder="Enter ...">
                      </div>
                    </div><div class="col-sm-6">
                      <div class="form-group">
                        <label>Kilometrage</label>
                        <input type="text" class="form-control kilometrage" value="'.$row["kilometrage"].'" onkeypress="chiffres(event);" placeholder="Enter ...">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Chauffeur</label>
                        <select class="chauffeur form-control">';
                        $this->getTelephoneChauffeur($row["id_chauffeur"]);
                        $this->crud_model_chauffeur->leSelectChauffeur("camion_benne");
                            
                        echo'</select>

                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Puissance</label>
                        <input type="text" class="form-control puissance" value="'.$row["puissance"].'" placeholder="Enter ..." onkeypress="chiffres(event);">
                      </div>
                    </div>
                    
                   <div class="col-sm-6">
                            <div class="form-group">
                            <label>Type de Camion</label>
                            <select class="type_camion form-control">
                                ';
                                $this->crud_model_vehicule->leSelectTypeEngin();
                                echo'
                                </select>
                          
                             </div>
                            
                        
                          </div>
                 </div>
                 <div class="row">
                      <div class="col-sm-12"><h3 style="text-decoration: underline; text-align: center;">ROUES</h3>
                    <hr/></div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Chaussée</label>
                        <input type="text" class="form-control nbreRoue" value="'.$row["nbreRoue"].'" onkeypress="chiffres(event);" placeholder="Nombre de roues à chausser">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>secours</label>
                        <input type="text" class="form-control nbreRoueSecours" value="'.$row["nbreRoueSecours"].'" onkeypress="chiffres(event);" placeholder="Nombre de roues de secours">
                      </div>
                    </div>
                    </div>';
        }
    }
}

public function afficheFormModifCamionBenne2($id_camion){
    $query1 = $this->db->query("select * from camion_benne where id_camion=".$id_camion."")->result_array();
        if (count($query1)==1) {
            # code...
        foreach ($query1 as $row) {
            echo'<div class="row">
                   <div class="col-sm-6">
                      <div class="form-group">
                        <label>Assurance</label>
                        <select class="assurance form-control">';
                          $this->getNumeroAssurance($row["id_assurance"]);
                          $this->crud_model_document->leSelectAssurance("camion_benne");
                            
                        echo'</select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Carte grise</label>
                        <select class="carte_grise form-control">';
                        $this->getNumeroCarteGrise($row["id_carte_grise"]);
                         $this->crud_model_document->leSelectCarteGrise("camion_benne");
                            
                          echo'</select>
                      </div>
                    </div><div class="col-sm-6">
                      <div class="form-group">
                        <label>Carte bleue</label>
                        <select class="carte_bleue form-control">
                        ';
                        $this->getNumeroCarteBleue($row["id_carte_bleue"]);
                        $this->crud_model_document->leSelecCarteBleue("camion_benne"); 
                            
                         echo' </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Visite technique</label>
                        <select class="visite_technique form-control">';
                          $this->getNumeroVisiteTechnique($row["id_visite"]);
                          $this->crud_model_document->leSelecVisiteTechnique("camion_benne"); 
                            
                          echo'</select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Taxe</label>
                        <select class="taxe form-control">';
                          $this->getNumeroTaxe($row["id_taxe_essieu"]);
                          $this->crud_model_document->leSelecTaxe("camion_benne"); 
                            
                         echo' </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Acces port</label>
                       <select class="acces_port form-control">';
                          $this->crud_model_document->leSelectAccesPort(); 
                            
                        echo'</select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Licence_transport</label>
                        <select class="licence_transport form-control">';
                           $this->crud_model_document->leSelectLicenceTransport();
                            
                       echo' </select>
                      </div>
                    </div><div class="col-sm-6">
                      <div class="form-group">
                        <label>Attestation non redevance</label>
                        <select class="attestation form-control">';
                          $this->getNumeroAttestationNonRedevance($row["id_attestation"]);
                          $this->crud_model_document->leSelectAttestation("camion_benne");
                            
                        echo'</select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <br>  <button type="button" class=" btn-primary btn-lg"  onclick="addCamionBenne(\'update\');">Modifer</button>
                      </div>
                    </div>

                 </div>';
                
        }
    }
}

public function afficheFormModifEngin2($id_camion){
    $query1 = $this->db->query("SELECT * from engin where id_camion=".$id_camion."")->result_array();
        if (count($query1)==1) {
            # code...
        foreach ($query1 as $row) {
            echo'<div class="row">
                   <div class="col-sm-6">
                      <div class="form-group">
                        <label>Assurance</label>
                        <select class="assurance form-control">';
                          $this->getNumeroAssurance($row["id_assurance"]);
                          $this->crud_model_document->leSelectAssurance("engin");
                            
                        echo'</select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Carte grise</label>
                        <select class="carte_grise form-control">';
                        $this->getNumeroCarteGrise($row["id_carte_grise"]);
                         $this->crud_model_document->leSelectCarteGrise("engin");
                            
                          echo'</select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Visite technique</label>
                        <select class="visite_technique form-control">';
                          $this->getNumeroVisiteTechnique($row["id_visite"]);
                          $this->crud_model_document->leSelecVisiteTechnique("engin"); 
                            
                          echo'</select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Taxe</label>
                        <select class="taxe form-control">';
                          $this->getNumeroTaxe($row["id_taxe_essieu"]);
                          $this->crud_model_document->leSelecTaxe("engin"); 
                            
                         echo' </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Acces port</label>
                       <select class="acces_port form-control">';
                          $this->crud_model_document->leSelectAccesPort(); 
                            
                        echo'</select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Licence_transport</label>
                        <select class="licence_transport form-control">';
                           $this->crud_model_document->leSelectLicenceTransport();
                            
                       echo' </select>
                      </div>
                    </div><div class="col-sm-6">
                      <div class="form-group">
                        <label>Attestation non redevance</label>
                        <select class="attestation form-control">';
                          $this->getNumeroAttestationNonRedevance($row["id_attestation"]);
                          $this->crud_model_document->leSelectAttestation("engin");
                            
                        echo'</select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <br>  <button type="button" class=" btn-primary btn-lg"  onclick="addEngin(\'update\');">Modifer</button>
                      </div>
                    </div>

                 </div>';
                
        }
    }
}

public function getCamionEtRoues(){
    $code_camion = $_POST["code_camion"];

    $getCamion = $this->db->query("SELECT * from camion_benne where code = '".$code_camion."'")->row();

    $getTracteur = $this->db->query("SELECT * from tracteur where code = '".$code_camion."'")->row();

    if (count($getCamion) > 0) {
        # code...
        echo "camion benne à ".$getCamion->nbreRoue." roues";
    }elseif (count($getTracteur) > 0) {
        # code...
        echo "Tracteur à ".$getTracteur->nbreRoue." roues";
    }else{
        echo "Aucun camion";
    }
}

  public function addDistance(){
        $amortissement = preg_replace('/\s/','', $_POST["amortissement"]);
        $code_camion = $_POST["code_camion"];
        $littrage = $_POST["littrage"];
        $distance = $_POST["distance"];
        $status = $_POST["status"];
        
        if ($status =="insert") {
            # code...
            // echo "INSERT into distance_littrage values ('','".$code_camion."',".$distance.",".$littrage.")";
            $requete = $this->db->query("INSERT into distance_littrage values ('',".$code_camion.",'".$distance."',".$littrage.",".$amortissement.")");
            if ($requete == true) {
                # code...
                echo "Insertion réussie";
            }else{
                echo "Erreur de connexion";
            }
        }elseif ($status == "update"){
            # code...
            $id_client =$_POST["id_client"];
             $update = $this->db->query("UPDATE distance_littrage set id_type_camion=".$code_camion.", distance='".$distance."', littrage = ".$littrage.",amortissement= ".$amortissement." where id_distance = ".$id_client."");
             if ($update == true) {
                 # code...
                echo "Modification réussie";
             }else{
                echo "Erreur lors de la modification";
             }
        }else{
            echo "Erreur contactez l'administrateur";
        }
        
    }

      public function addLocationEngin(){
        $commentaire =addslashes($_POST['commentaire']);
        $code_camion = $_POST["code_camion"];
        $montant = intval(preg_replace('/\s/','', $_POST["montant"]));
        $duree = $_POST["duree"];
        $id_operation = $_POST["id_operation"];
        $unite = $_POST["unite"];
        $date_location = $_POST["date_location"];
        $status = $_POST["status"];
        
        if ($status =="insert") {
            # code...
            // echo "INSERT into distance_littrage values ('','".$code_camion."',".$distance.",".$littrage.")";
            $requete = $this->db->query("INSERT into location_engin values ('',".$id_operation.",'".$code_camion."','".$duree."',".$montant.",'".$unite."',CAST('". $date_location."' AS DATE),'".$commentaire."')");
            if ($requete == true) {
                # code...
                echo "Insertion réussie";
            }else{
                echo "Erreur de connexion";
            }
        }elseif ($status == "update"){
            # code...
            $id_client =$_POST["id_client"];
             $update = $this->db->query("UPDATE location_engin set id_operation =".$id_operation.", code='".$code_camion."', montant='".$montant."', duree = '".$duree."', date_location =CAST('". $date_location."' AS DATE), unite ='".$unite."',commentaire='".$commentaire."' where id_location = ".$id_client."");
             if ($update == true) {
                 # code...
                echo "Modification réussie";
             }else{
                echo "Erreur lors de la modification";
             }
        }else{
            echo "Erreur contactez l'administrateur";
        }
        
    }

        public function selectAllLocationEngin(){
              $query1 = $this->db->get_where('location_engin')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
          $getOperation = $this->db->query("SELECT * from operation where id_operation = ".$row['id_operation']." limit 1")->row();
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['code']."</td>
                    <td>".$getOperation->nom_op."</td>
                    <td> ".$row['duree']." ".$row['unite']."(s)</td>
                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td>".number_format($row['montant']*$row['duree'],0,',',' ')."</td>
                    <td> ".$row['date_location']."</td>
                    <td>
                    <button type='button' onclick=\"infosLocationEngin('".$row['id_location']."','".$row['code']."','".$row['duree']."','".$row['montant']."','".$row['date_location']."','".$row['commentaire']."','".$row['id_operation']."','".$row['unite']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='location_engin' identifiant='".$row['id_location']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_location\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                  $compteur++;
        }
    }

    public function addTypeVehicule(){
        $montant = intval(preg_replace('/\s/','', $_POST["montant"]));
        $type_vehicule = $_POST["nom_type"];
        $commentaire = addslashes($_POST["commentaire"]);
        $status = $_POST["status"];
        
        if ($status =="insert") {
            # code...
            // echo "INSERT into distance_littrage values ('','".$code_camion."',".$distance.",".$littrage.")";
            $requete = $this->db->query("INSERT into type_vehicule values ('','".$type_vehicule."','".$commentaire."',".$montant.")");
            if ($requete == true) {
                # code...
                echo "Insertion du type de véhicule réussie";
            }else{
                echo "Erreur de connexion";
            }
        }elseif ($status == "update"){
            # code...
            $id_client =$_POST["id_client"];
             $update = $this->db->query("UPDATE type_vehicule set nom_type='".$type_vehicule."', commentaire='".$commentaire."',montant=".$montant." where id_type = ".$id_client."");
             if ($update == true) {
                 # code...
                echo "Modification du type de véhicule réussie";
             }else{
                echo "Erreur lors de la modification";
             }
        }else{
            echo "Erreur contactez l'administrateur";
        }
        
    }

    public function selectAllDistance(){
              $query1 = $this->db->get_where('distance_littrage')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            $getTypeVehicule = $this->db->query("SELECT * from type_vehicule where id_type=".$row['id_type_camion']." limit 1")->row();
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$getTypeVehicule->nom_type."
                    </td>
                    <td>".number_format($row['littrage'],0,',',' ')." L</td>
                    <td> ".$row['distance']."</td>
                    <td>".number_format($row['amortissement'],0,',',' ')." </td>
                    <td>
                    <button type='button' onclick=\"infosClient('".$row['id_distance']."','".$row['littrage']."','".$row['distance']."','".$row['id_type_camion']."','".number_format($row['amortissement'],0,',',' ')."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='distance_littrage' identifiant='".$row['id_distance']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_distance\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                  $compteur++;
        }
    }
 public function selectAllTypeVehicule(){
              $query1 = $this->db->get_where('type_vehicule')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['nom_type']."
                    </td>
                    <td>".number_format($row['montant'],0,',',' ')." </td>
                    <td>".$row['commentaire']."</td>
                    <td>
                    <button type='button' onclick=\"infosTypeVehicule('".$row['id_type']."','".$row['nom_type']."','".$row['commentaire']."','".number_format($row['montant'],0,',',' ')."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='type_vehicule' identifiant='".$row['id_type']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_type\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                  $compteur++;
        }
    }

     public function leSelectTypeVehicule(){
        $query = $this->db->query("select * from type_vehicule")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_type"]."'>".$row["nom_type"]."</option>";
            }
        }else{

        }
    }

    public function leSelectEngin(){
        $query = $this->db->query("SELECT * from engin")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["code"]."'>".$row["code"]."</option>";
            }
        }else{

        }
    }

public function leSelectTypeTracteur(){
        $query = $this->db->query("SELECT * from type_vehicule where nom_type like '%tract%'")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_type"]."'>".$row["nom_type"]."</option>";
            }
        }else{

        }
    }
 public function leSelectTypeEngin(){
        $query = $this->db->query("SELECT * from type_vehicule where nom_type like '%eng%'")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_type"]."'>".$row["nom_type"]."</option>";
            }
        }else{

        }
    }

    public function leSelectTypeBenne(){
        $query = $this->db->query("SELECT * from type_vehicule where nom_type like '%benn%'")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_type"]."'>".$row["nom_type"]."</option>";
            }
        }else{

        }
    }

public function getAllImmatriculation(){
    $tracteur = $this->db->query("select * from tracteur")->result_array();
    $remorque = $this->db->query("select * from remorque")->result_array();
    $camionBenne = $this->db->query("select * from camion_benne")->result_array();

    if (count($tracteur) >0) {
        # code...
        foreach ($tracteur as $row) {
            # code...
            echo "<option>".$row['immatriculation']."</option>";
        }
        
    }
    if (count($remorque)>0) {
        # code...
        foreach ($remorque as $row) {
            # code...
            echo "<option>".$row['immatriculation']."</option>";
        }
    }
    if (count($camionBenne)>0) {
        # code...
        foreach ($camionBenne as $row) {
            # code...
            echo "<option>".$row['immatriculation']."</option>";
        }
    }
}

  public function selectAllChargementOperationPourBalance(){
           $id_operation = $_POST["id_operation"];

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  code_camion="'.$id_operation.'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg<="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg<="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM chargement_retour')->result_array();
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
              <td>".number_format($row['montant'],0,',',' ')." Fcfa</td>
              <td>".$row['date_charg']."</td> </tr>";
          $compteur++;
      }
    }else{
      // echo "nada";
    }
    }
     public function selectAllFactureOperationPourBalance(){
           $id_operation = $_POST["id_fournisseur"];

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  code_camion="'.$id_operation.'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl<="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl<="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM bon_livraison')->result_array();
        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
$compteur = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...

        $total = $row['quantite']*$row['prix_unitaire'];
        echo "<tr><td>".$compteur."</td>
              <td>".$row['numero']."</td>
              <td>".$row['code_camion']."</td>
              <td>".number_format($row['prix_unitaire'],0,',',' ')." Fcfa</td>
              <td>".$row['quantite']."</td>
              <td>".number_format($total,0,',',' ')." Fcfa</td>
              <td>".$row['date_bl']."</td>
              <td>".$row['unite']."</td> </tr>";
          $compteur++;
      }
    }else{
      // echo "nada";
    }
    }




  public function selectAllPrimeOperationPourBalance(){
    $id_operation = $_POST["id_operation"];

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  code_camion="'.$id_operation.'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
$getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime<="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM prime')->result_array();
        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
$compteur = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...

        echo "<tr><td>".$compteur."</td>
              <td>".$row['code_camion']."</td>
              <td>".number_format($row['montant'],0,',',' ')." FCFA</td>
              <td>".$row['date_prime']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }
  }

    public function selectAllFraisRouteOperationPourBalance(){
        $id_operation = $_POST["id_operation"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  code_camion="'.$id_operation.'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM frais_route')->result_array();
        }
$compteur = 0;
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

  public function selectAllPneuPourBalance(){
       $id_operation = $_POST["id_operation"];
    $code_camion = $id_operation;
         $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
      
if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPneu = $this->db->query('SELECT * FROM depense_pneu WHERE  code_camion="'.$id_operation.'"')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPneu = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPneu = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPneu = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPneu = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPneu = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense <="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPneu = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPneu = $this->db->query('SELECT * FROM depense_pneu')->result_array();
        }

$compteur = 0;
        if (count($getPneu)>0) {
            # code...
                   foreach ($getPneu as $row) {
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
                    <td> ".number_format($row['prix_unitaire'],0,',',' ')." </td>
                    <td> ".$row['qtite']." </td>
                    <td> ".number_format($row['qtite']*$row['prix_unitaire'],0,',',' ')." </td>
                    
                    <td> ".$row['commentaire']." </td>
                    
                  </tr>

                  ";
                  $compteur++;
        }

        }
  }
     
//       public function selectAllPneuPourBalance(){
//         // 
//     $id_operation = $_POST["id_operation"];
//     $code_camion = $id_operation;
//          $date_debut = $_POST["date_debut"];
//         $date_fin = $_POST["date_fin"];
      

//         $getPneu = $this->db->query('SELECT * FROM pneu')->result_array();
// $compteur = 0 ;
//         foreach ($getPneu as $pneu) {
//             # code... on va chercher à savoir si le pneu appartient à un tracteur ou à une benne ou alors à une remorque

//             $getCodePneuParTracteur = $this->db->query("SELECT * from tracteur where immatriculation = '".$pneu['immatriculation']."'")->row();

           
//             $getCodePneuParBenne = $this->db->query("SELECT * from camion_benne where immatriculation = '".$pneu['immatriculation']."'")->row();
//             $getTypePneu = $this->db->query("SELECT * from type_pneu where id_type_pneu = ".$pneu['id_type_pneu']."")->row();

//             $getRemorque = $this->db->query("SELECT * from remorque where immatriculation ='".$pneu['immatriculation']."'")->row();

// // si  le pneu appartient à une remorque
//             if (count($getRemorque) > 0) {
//                 # code...
//                 $getRemorqueParCOde = $this->db->query("SELECT * from tracteur where id_remorque = ".$getRemorque->id_remorque." limit 1")->row();
//                 if (count($getRemorqueParCOde) >0) {
//                     # code...
                
//                 if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//                      if ($getRemorqueParCOde->code == $code_camion) {
//                    # code...
              
//                  echo "<tr><td>".$compteur." </td>
//                  <td>".$getTypePneu->nom_type." </td>
//               <td>".$getRemorqueParCOde->code." </td>
//               <td>".$pneu['immatriculation']." </td> 
//                <td>".$pneu['numero']." </td> 
//               <td>".number_format($pneu['montant'],0,',',' ')." </td>
//               <td>".$pneu['date_crea']."</td> </tr>
//              ";
//                   $compteur ++;  
//               }
//                  }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//                     if ($pneu['date_crea'] >= $date_debut ) {
//                         # code...
//                  echo "<tr><td>".$compteur."</td>
//                  <td>".$getTypePneu->nom_type."</td>
//               <td>".$getRemorqueParCOde->code."</td>
//                <td>".$pneu['immatriculation']."</td> 
//                <td>".$pneu['numero']."</td> 
//               <td>".number_format($pneu['montant'],0,',',' ')."</td>
//               <td>".$pneu['date_crea']."</td> </tr>
//              ";
//                   $compteur ++;  
//                     }
                    
//                 }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//                     if ($pneu['date_crea'] <= $date_fin) {
//                         # code...
//                  echo "<tr><td>".$compteur."</td>
//                  <td>".$getTypePneu->nom_type."</td>
//               <td>".$getRemorqueParCOde->code."</td>
//                <td>".$pneu['immatriculation']."</td> 
//                <td>".$pneu['numero']."</td> 
//               <td>".number_format($pneu['montant'],0,',',' ')."</td>
//               <td>".$pneu['date_crea']."</td> </tr>
//              ";
//                   $compteur ++;                  }
          
//                 }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){

//                  if ($pneu['date_crea'] <= $date_fin && $pneu['date_crea'] >= $date_debut) {
//                         # code...
//                 echo "<tr><td>".$compteur."</td>
//                  <td>".$getTypePneu->nom_type."</td>
//               <td>".$getRemorqueParCOde->code."</td>
//                <td>".$pneu['immatriculation']."</td> 
//                <td>".$pneu['numero']."</td> 
//               <td>".number_format($pneu['montant'],0,',',' ')."</td>
//               <td>".$pneu['date_crea']."</td> </tr>
//              ";
//                   $compteur ++;  
//                     }
          
//                }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
                
//                  if ($pneu['date_crea'] <= $date_fin && $pneu['date_crea'] >= $date_debut && $getRemorqueParCOde->code == $code_camion) {
//                         # code...
//                  echo "<tr><td>".$compteur."</td>
//                  <td>".$getTypePneu->nom_type."</td>
//               <td>".$getRemorqueParCOde->code."</td>
//                <td>".$pneu['immatriculation']."</td> 
//                <td>".$pneu['numero']."</td> 
//               <td>".number_format($pneu['montant'],0,',',' ')."</td>
//               <td>".$pneu['date_crea']."</td> </tr>
//              ";
//                   $compteur ++;  
//                     }

//                }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){

//                  if ($pneu['date_crea'] <= $date_fin && $getRemorqueParCOde->code == $code_camion) {
//                         # code...
//                echo "<tr><td>".$compteur."</td>
//                  <td>".$getTypePneu->nom_type."</td>
//               <td>".$getRemorqueParCOde->code."</td>
//                <td>".$pneu['immatriculation']."</td> 
//                <td>".$pneu['numero']."</td> 
//               <td>".number_format($pneu['montant'],0,',',' ')."</td>
//               <td>".$pneu['date_crea']."</td> </tr>
//              ";
//                   $compteur ++;  
//                     }
           

//                }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            
//             if ($pneu['date_crea'] >= $date_debut && $getRemorqueParCOde->code == $code_camion) {
//                         # code...
//                  echo "<tr><td>".$compteur."</td>
//                  <td>".$getTypePneu->nom_type."</td>
//               <td>".$getRemorqueParCOde->code."</td>
//                <td>".$pneu['immatriculation']."</td> 
//                <td>".$pneu['numero']."</td> 
//               <td>".number_format($pneu['montant'],0,',',' ')."</td>
//               <td>".$pneu['date_crea']."</td> </tr>
//              ";
//                   $compteur ++;  
//                     }

//              }
                
               
//             }
//         }
// // si le pneu appartient à un tracteur
//             if (count($getCodePneuParTracteur)>0) {
//                 # code...

//                  if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
          
//                if ($getCodePneuParTracteur->code == $code_camion) {
//                    # code...
              
//                  echo "<tr><td>".$compteur."</td>
//                  <td>".$getTypePneu->nom_type."</td>
//               <td>".$getCodePneuParTracteur->code."</td>
//               <td>".$pneu['immatriculation']."</td> 
//                <td>".$pneu['numero']."</td> 
//               <td>".number_format($pneu['montant'],0,',',' ')."</td>
//               <td>".$pneu['date_crea']."</td> </tr>
//              ";
//                   $compteur ++;  
//               }
//                  }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//                     if ($pneu['date_crea'] >= $date_debut ) {
//                         # code...
//                  echo "<tr><td>".$compteur."</td>
//                  <td>".$getTypePneu->nom_type."</td>
//               <td>".$getCodePneuParTracteur->code."</td>
//                <td>".$pneu['immatriculation']."</td> 
//                <td>".$pneu['numero']."</td> 
//               <td>".number_format($pneu['montant'],0,',',' ')."</td>
//               <td>".$pneu['date_crea']."</td> </tr>
//              ";
//                   $compteur ++;  
//                     }
                    
//                 }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//                     if ($pneu['date_crea'] <= $date_fin) {
//                         # code...
//                  echo "<tr><td>".$compteur."</td>
//                  <td>".$getTypePneu->nom_type."</td>
//               <td>".$getCodePneuParTracteur->code."</td>
//                <td>".$pneu['immatriculation']."</td> 
//                <td>".$pneu['numero']."</td> 
//               <td>".number_format($pneu['montant'],0,',',' ')."</td>
//               <td>".$pneu['date_crea']."</td> </tr>
//              ";
//                   $compteur ++;                  }
          
//                 }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){

//                  if ($pneu['date_crea'] <= $date_fin && $pneu['date_crea'] >= $date_debut) {
//                         # code...
//                 echo "<tr><td>".$compteur."</td>
//                  <td>".$getTypePneu->nom_type."</td>
//               <td>".$getCodePneuParTracteur->code."</td>
//                <td>".$pneu['immatriculation']."</td> 
//                <td>".$pneu['numero']."</td> 
//               <td>".number_format($pneu['montant'],0,',',' ')."</td>
//               <td>".$pneu['date_crea']."</td> </tr>
//              ";
//                   $compteur ++;  
//                     }
          
//                }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
                
//                  if ($pneu['date_crea'] <= $date_fin && $pneu['date_crea'] >= $date_debut && $getCodePneuParTracteur->code == $code_camion) {
//                         # code...
//                  echo "<tr><td>".$compteur."</td>
//                  <td>".$getTypePneu->nom_type."</td>
//               <td>".$getCodePneuParTracteur->code."</td>
//                <td>".$pneu['immatriculation']."</td> 
//                <td>".$pneu['numero']."</td> 
//               <td>".number_format($pneu['montant'],0,',',' ')."</td>
//               <td>".$pneu['date_crea']."</td> </tr>
//              ";
//                   $compteur ++;  
//                     }

//                }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){

//                  if ($pneu['date_crea'] <= $date_fin && $getCodePneuParTracteur->code == $code_camion) {
//                         # code...
//                echo "<tr><td>".$compteur."</td>
//                  <td>".$getTypePneu->nom_type."</td>
//               <td>".$getCodePneuParTracteur->code."</td>
//                <td>".$pneu['immatriculation']."</td> 
//                <td>".$pneu['numero']."</td> 
//               <td>".number_format($pneu['montant'],0,',',' ')."</td>
//               <td>".$pneu['date_crea']."</td> </tr>
//              ";
//                   $compteur ++;  
//                     }
           

//                }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            
//             if ($pneu['date_crea'] >= $date_debut && $getCodePneuParTracteur->code == $code_camion) {
//                         # code...
//                  echo "<tr><td>".$compteur."</td>
//                  <td>".$getTypePneu->nom_type."</td>
//               <td>".$getCodePneuParTracteur->code."</td>
//                <td>".$pneu['immatriculation']."</td> 
//                <td>".$pneu['numero']."</td> 
//               <td>".number_format($pneu['montant'],0,',',' ')."</td>
//               <td>".$pneu['date_crea']."</td> </tr>
//              ";
//                   $compteur ++;  
//                     }

//              }



//             }
// // sinon forcément ce oneu est sur une benne
//             if (count($getCodePneuParBenne)>0) {
//                 # code...
//                  if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
          
//                if ($getCodePneuParBenne->code == $code_camion) {
//                    # code...
               
//                 echo "<tr><td>".$compteur."</td>
//                  <td>".$getTypePneu->nom_type."</td>
//               <td>".$$getCodePneuParBenne->code." benne</td>
//                <td>".$pneu['immatriculation']."</td> 
//                <td>".$pneu['numero']."</td> 
//               <td>".number_format($pneu['montant'],0,',',' ')."</td>
//               <td>".$pneu['date_crea']."</td> </tr>
//              ";
//                   $compteur ++;  
//                     }
//                  }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//                     if ($pneu['date_crea'] >= $date_debut) {
//                         # code...
//                echo "<tr><td>".$compteur."</td>
//                  <td>".$getTypePneu->nom_type."</td>
//               <td>".$getCodePneuParBenne->code."</td>
//                <td>".$pneu['immatriculation']."</td> 
//                <td>".$pneu['numero']."</td> 
//               <td>".number_format($pneu['montant'],0,',',' ')."</td>
//               <td>".$pneu['date_crea']."</td> </tr>
//              ";
//                   $compteur ++;  
//                     }
                    
//                 }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//                     if ($pneu['date_crea'] <= $date_fin) {
//                         # code...
//                 echo "<tr><td>".$compteur."</td>
//                  <td>".$getTypePneu->nom_type."</td>
//               <td>".$getCodePneuParBenne->code."</td>
//                <td>".$pneu['immatriculation']."</td> 
//                <td>".$pneu['numero']."</td> 
//               <td>".number_format($pneu['montant'],0,',',' ')."</td>
//               <td>".$pneu['date_crea']."</td> </tr>
//              ";
//                   $compteur ++;                   
//                 }
          
//                 }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){

//                  if ($pneu['date_crea'] <= $date_fin && $pneu['date_crea'] >= $date_debut) {
//                         # code...
//                  echo "<tr><td>".$compteur." too</td>
//                  <td>".$getTypePneu->nom_type."</td>
//               <td>".$getCodePneuParBenne->code."</td>
//                <td>".$pneu['immatriculation']."</td> 
//                <td>".$pneu['numero']."</td> 
//               <td>".number_format($pneu['montant'],0,',',' ')."</td>
//               <td>".$pneu['date_crea']."</td> </tr>
//              ";
//                   $compteur ++;  
//                     }
          
//                }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
                
//                  if ($pneu['date_crea'] <= $date_fin && $pneu['date_crea'] >= $date_debut && $getCodePneuParBenne->code == $code_camion) {
//                         # code...
//                  echo "<tr><td>".$compteur."</td>
//                  <td>".$getTypePneu->nom_type."</td>
//               <td>".$getCodePneuParBenne->code."</td>
//                <td>".$pneu['immatriculation']."</td> 
//                <td>".$pneu['numero']."</td> 
//               <td>".number_format($pneu['montant'],0,',',' ')."</td>
//               <td>".$pneu['date_crea']."</td> </tr>
//              ";
//                   $compteur ++;  
//                     }

//                }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){

//                  if ($pneu['date_crea'] <= $date_fin && $getCodePneuParBenne->code == $code_camion) {
//                         # code...
//                  echo "<tr><td>".$compteur."</td>
//                  <td>".$getTypePneu->nom_type."</td>
//               <td>".$getCodePneuParBenne->code."</td>
//                <td>".$pneu['immatriculation']."</td> 
//                <td>".$pneu['numero']."</td> 
//               <td>".number_format($pneu['montant'],0,',',' ')."</td>
//               <td>".$pneu['date_crea']."</td> </tr>
//              ";
//                   $compteur ++;  
//                     }
           

//                }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            
//             if ($pneu['date_crea'] >= $date_debut && $getCodePneuParBenne->code == $code_camion) {
//                         # code...
//               echo "<tr><td>".$compteur."</td>
//                  <td>".$getTypePneu->nom_type."</td>
//               <td>".$getCodePneuParBenne->code."</td>
//                <td>".$pneu['immatriculation']."</td> 
//                <td>".$pneu['numero']."</td> 
//               <td>".number_format($pneu['montant'],0,',',' ')."</td>
//               <td>".$pneu['date_crea']."</td> </tr>
//              ";
//                   $compteur ++;  
//                     }

//              }



//             }

//             $compteur ++;

//         }


    
//   }    
  public function selectAllTotalPneuPourBalance(){
           $id_operation = $_POST["id_operation"];
    $code_camion = $id_operation;
         $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
      
if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPneu = $this->db->query('SELECT * FROM depense_pneu WHERE  code_camion="'.$id_operation.'"')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPneu = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPneu = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPneu = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPneu = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPneu = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense <="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPneu = $this->db->query('SELECT * FROM depense_pneu WHERE  date_depense <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPneu = $this->db->query('SELECT * FROM depense_pneu')->result_array();
        }

$compteur = 0;
$total1 = 0;
$total =0;
        if (count($getPneu)>0) {
            # code...
            foreach ($getPneu as $row) {
                $total1 = $row['qtite']*$row['prix_unitaire'];
                $total = $total1+$total;
            }
        }
        return $total;
  }
//    public function selectAllTotalPneuPourBalance(){
//     $id_operation = $_POST["id_operation"];
//     $code_camion = $id_operation;
//          $date_debut = $_POST["date_debut"];
//         $date_fin = $_POST["date_fin"];
      

//         $getPneu = $this->db->query('SELECT * FROM pneu')->result_array();
// $compteur = 0 ;
// $montant = 0;
// $montant2 = 0;
// $montant3 = 0;
//     foreach ($getPneu as $pneu) {
//             # code... on va chercher à savoir si le pneu appartient à un tracteur ou à une benne

//             $getCodePneuParTracteur = $this->db->query("SELECT * from tracteur where immatriculation = '".$pneu['immatriculation']."'")->row();
//             $getRemorque = 
           
//             $getCodePneuParBenne = $this->db->query("SELECT * from camion_benne where immatriculation = '".$pneu['immatriculation']."'")->row();
//             $getTypePneu = $this->db->query("SELECT * from type_pneu where id_type_pneu = ".$pneu['id_type_pneu']."")->row();

//                         $getRemorque = $this->db->query("SELECT * from remorque where immatriculation ='".$pneu['immatriculation']."'")->row();

// // si  le pneu appartient à une remorque
//             if (count($getRemorque) > 0) {
//                 # code...
//                 $getRemorqueParCOde = $this->db->query("SELECT * from tracteur where id_remorque = ".$getRemorque->id_remorque." limit 1")->row();
//                 if (count($getRemorqueParCOde) >0) {
//                     # code...
                
//                 if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//                      if ($getRemorqueParCOde->code == $code_camion) {
//                    # code...
              
//                   $montant2 = $montant2 + $pneu['montant'];
//               }
//                  }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//                     if ($pneu['date_crea'] >= $date_debut ) {
//                         # code...
//                  $montant2 = $montant2 + $pneu['montant']; 
//                     }
                    
//                 }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//                     if ($pneu['date_crea'] <= $date_fin) {
//                   $montant2 = $montant2 + $pneu['montant'];               }
          
//                 }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){

//                  if ($pneu['date_crea'] <= $date_fin && $pneu['date_crea'] >= $date_debut) {
//                         # code...
//                  $montant2 = $montant2 + $pneu['montant'];
//                     }
          
//                }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
                
//                  if ($pneu['date_crea'] <= $date_fin && $pneu['date_crea'] >= $date_debut && $getRemorqueParCOde->code == $code_camion) {
//                         # code...
//                   $montant2 = $montant2 + $pneu['montant'];
//                     }

//                }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){

//                  if ($pneu['date_crea'] <= $date_fin && $getRemorqueParCOde->code == $code_camion) {
//                         # code...
//                 $montant2 = $montant2 + $pneu['montant']; 
//                     }
           

//                }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            
//             if ($pneu['date_crea'] >= $date_debut && $getRemorqueParCOde->code == $code_camion) {
//                         # code...
//                   $montant2 = $montant2 + $pneu['montant'];
//                     }

//              }
                
               
//             }
//         }
//             if (count($getCodePneuParTracteur)>0) {
//                 # code...


//                  if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
//             if ($getCodePneuParTracteur->code == $code_camion) {
            
//                     $montant3 = $montant3 + $pneu['montant'];  
//                 }
//                  }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//                     if ($pneu['date_crea'] >= $date_debut ) {
//                          $montant3 = $montant3 + $pneu['montant'];  
//                     }
                    
//                 }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//                     if ($pneu['date_crea'] <= $date_fin) {
//                          $montant3 = $montant3 + $pneu['montant']; 
//                      }
          
//                 }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){

//                  if ($pneu['date_crea'] <= $date_fin && $pneu['date_crea'] >= $date_debut) {
//                  $montant3 = $montant3 + $pneu['montant'];   
//                     }
          
//                }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
                
//                  if ($pneu['date_crea'] <= $date_fin && $pneu['date_crea'] >= $date_debut && $getCodePneuParTracteur->code == $code_camion) {
//                       $montant3 = $montant3 + $pneu['montant'];  
//                     }

//                }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){

//                  if ($pneu['date_crea'] <= $date_fin && $getCodePneuParTracteur->code == $code_camion) {
//                       $montant3 = $montant3 + $pneu['montant'];  
//                     }
           

//                }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            
//             if ($pneu['date_crea'] >= $date_debut && $getCodePneuParTracteur->code == $code_camion) {
//                     $montant3 = $montant3 + $pneu['montant'];  
//                     }

//              }


//             }elseif (count($getCodePneuParBenne)>0) {
//                 # code...
//                  if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
          
//                 if ($getCodePneuParBenne->code == $code_camion) {
//                     # code...
                
//                  $montant = $montant + $pneu['montant'];   
//                    } 
//                  }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
//                     if ($pneu['date_crea'] >= $date_debut) {
//                         $montant = $montant + $pneu['montant']; 
//                     }
                    
//                 }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
//                     if ($pneu['date_crea'] <= $date_fin) {
//                         $montant = $montant + $pneu['montant'];                   
//                 }
          
//                 }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){

//                  if ($pneu['date_crea'] <= $date_fin && $pneu['date_crea'] >= $date_debut) {
//                        $montant = $montant + $pneu['montant']; 
//                     }
          
//                }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
                
//                  if ($pneu['date_crea'] <= $date_fin && $pneu['date_crea'] >= $date_debut && $getCodePneuParBenne->code == $code_camion) {
//                       $montant = $montant + $pneu['montant']; 
//                     }

//                }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){

//                  if ($pneu['date_crea'] <= $date_fin && $getCodePneuParBenne->code == $code_camion) {
//                         $montant = $montant + $pneu['montant'];  
//                     }
           

//                }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            
//             if ($pneu['date_crea'] >= $date_debut && $getCodePneuParBenne->code == $code_camion) {
//                      $montant = $montant + $pneu['montant'];  
//                     }

//              }



//             }

//             $compteur ++;

//         }

//         return $montant+$montant2+$montant3;
    
//   }



    public function selectAllLocationEnginOperationPourBalance(){
           $id_operation = $_POST["id_operation"];

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  code="'.$id_operation.'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...""
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location<="'.$date_fin.'" and code="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location>="'.$date_debut.'" and code="'.$id_operation.'"')->result_array();

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
                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td>".number_format($row['montant']*$row['duree'],0,',',' ')."</td>
                    <td> ".$row['date_location']."</td>
                    <td></tr>";
          $compteur++;
      }
    }else{
      // echo "nada";
    }
    }
    public function selectAllTotalLocationEnginOperationPourBalance(){
           $id_operation = $_POST["id_operation"];

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  code="'.$id_operation.'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location between "'.$date_debut.'" and "'.$date_fin.'" and code="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location<="'.$date_fin.'" and code="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM location_engin WHERE  date_location>="'.$date_debut.'" and code="'.$id_operation.'"')->result_array();

        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
$compteur = 0;
$montant10 = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...
        $getOperation = $this->db->query("SELECT * from operation where id_operation = ".$row['id_operation']." limit 1")->row();
         $prix = $row['montant']*$row['duree'];                  
         
         $montant10 = $montant10 + $prix;
      }

    }else{
      // echo "nada";
    }

    return $montant10;
    }



      public function selectAllFraisDiversOperationPourBalance(){
    $id_operation = $_POST["id_operation"];
         $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  code_camion="'.$id_operation.'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM frais_divers')->result_array();
        }
$compteur = 0;
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

public function selectAllPieceRechangeOperationPourBalance(){
    $id_operation = $_POST["id_operation"];
     $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  code_camion="'.$id_operation.'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

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
              echo "<td>".$getArticle->id_article."</td>";
             echo" <td>".number_format($getArticle->prix_unitaire,0,',',' ')." FCFA</td>
             <td>".$row['qtite']."</td>
             <td>".$row['qtite']*$getArticle->prix_unitaire."</td>
              <td>".$row['date_rech']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }
  }

public function selectAllVidangeOperationPourBalance(){
    $id_operation = $_POST["id_operation"];
    $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  code_camion="'.$id_operation.'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidange')->result_array();
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
              $prixTotal = $getArticle->PU *$row['qtite'];

             echo" <td>".number_format($row['qtite'],0,',',' ')."</td> 
             <td>".number_format($getArticle->PU,0,',',' ')." FCFA</td>
             <td>".number_format($prixTotal,0,',',' ')." FCFA</td>
              <td>".$row['date_vidange']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }
    if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  code_camion="'.$id_operation.'"')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique')->result_array();
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
              $prixTotal = $getArticle->PU *$row['qtite'];
             echo" <td>".number_format($row['qtite'],0,',',' ')."</td> 
             <td>".number_format($getArticle->PU,0,',',' ')." FCFA</td>
             <td>".number_format($prixTotal,0,',',' ')." FCFA</td>
              <td>".$row['date_vidange']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }
if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  code_camion="'.$id_operation.'"')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidangeBoite')->result_array();
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
              $prixTotal = $getArticle->PU *$row['qtite'];
             echo" <td>".number_format($row['qtite'],0,',',' ')."</td> 
             <td>".number_format($getArticle->PU,0,',',' ')." FCFA</td>
             <td>".number_format($prixTotal,0,',',' ')." FCFA</td>
              <td>".$row['date_vidange']."</td> </tr>";
        $compteur++;
      }
    }else{
      // echo "nada";
    }

  }
public function selectAllTotalVidangeOperationPourBalance(){
    $id_operation = $_POST["id_operation"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  code_camion="'.$id_operation.'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidange')->result_array();
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
              $montant =  $row["qtite"] * $tab1['PU'];
            }
          $total = $total + $montant;  
      }
    }else{
      // echo "nada";
    }
if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  code_camion="'.$id_operation.'"')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique')->result_array();
        }
      // $getPrime = $this->db->query("SELECT * FROM vidangeHydrolique where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...

              $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
              foreach ($getArticle as $tab1) {
              # code...
              $montant =  $row["qtite"] * $tab1['PU'];
            }
          $total = $total + $montant; 
      }
    }else{
      // echo "nada";
    }
if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  code_camion="'.$id_operation.'"')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidangeBoite')->result_array();
        }
      // $getPrime = $this->db->query("SELECT * FROM vidangeBoite where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # co
              $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
               foreach ($getArticle as $tab1) {
              # code...
              $montant =  $row["qtite"] * $tab1['PU'];
            }
          $total = $total + $montant; 
      }
    }else{
      // echo "nada";
    }
    echo $total;
  }

 public function selectAllTotalFactureOperationPourBalance(){
          $id_operation = $_POST["id_fournisseur"];

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  code_camion="'.$id_operation.'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl<="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM bon_livraison WHERE  date_bl<="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM bon_livraison')->result_array();
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
    }

     public function selectAllTotalChargementOperationPourBalance(){
          $id_operation = $_POST["id_operation"];

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  code_camion="'.$id_operation.'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg<="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM chargement_retour WHERE  date_charg<="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM chargement_retour')->result_array();
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
    }

    public function selectAllTotalPrimeOperationPourBalance(){
    $id_operation = $_POST["id_operation"];
    $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  code_camion="'.$id_operation.'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime <="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM prime')->result_array();
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
    echo $total;
  }

   public function selectAllTotalFraisRouteOperationPourBalance(){
    $id_operation = $_POST["id_operation"];
    $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  code_camion="'.$id_operation.'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM frais_route')->result_array();
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

    echo $total;
  }

     public function selectAllTotalFraisDiversOperationPourBalance(){
    $id_operation = $_POST["id_operation"];
    $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  code_camion="'.$id_operation.'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM frais_divers')->result_array();
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

    echo $total;
  }

 public function selectAllTotalPieceRechangeOperationPourBalance(){
    $id_operation = $_POST["id_operation"];
    $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  code_camion="'.$id_operation.'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM piece_rechange')->result_array();
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

    echo $total;
  }


 public function selectAllTotalGazoilOperationPourBalance(){
    $id_operation = $_POST["id_operation"];
    $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  code_camion="'.$id_operation.'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM gazoil')->result_array();
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

    echo $total;
  }

  public function selectAllGazoilOperationPourBalance(){
    $id_operation = $_POST["id_operation"];
    $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  code_camion="'.$id_operation.'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM gazoil')->result_array();
        }
    // $getPrime = $this->db->query("SELECT * FROM gazoil where id_operation =".$id_operation."")->result_array();
    $compteur = 0;
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
              }else{
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


public function totalDepenseParOperation(){
  $id_operation = $_POST["id_operation"];
    $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  code_camion="'.$id_operation.'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM gazoil WHERE  date_gazoil <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM gazoil')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  code_camion="'.$id_operation.'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM piece_rechange WHERE  date_rech <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM piece_rechange')->result_array();
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
          $montant1 = $tab["prix_unitaire"]* $row["qtite"];
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
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  code_camion="'.$id_operation.'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_divers WHERE  date_frais <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM frais_divers')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  code_camion="'.$id_operation.'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM frais_route WHERE  date_frais <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM frais_route')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  code_camion="'.$id_operation.'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime <="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM prime WHERE  date_prime <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM prime')->result_array();
        }
    // $getPrime = $this->db->query("SELECT * FROM prime where id_operation =".$id_operation."")->result_array();
$compteur = 0;
$total4 = 0;
    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
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
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  code_camion="'.$id_operation.'"')->result_array();
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
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidange WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidange')->result_array();
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
              $montant5 =  $row["qtite"] * $tab1['PU'];
            }
          $total5 = $total5 + $montant5;  
      }
    }else{
      // echo "nada";
    }
if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  code_camion="'.$id_operation.'"')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidangeHydrolique')->result_array();
        }
      // $getPrime = $this->db->query("SELECT * FROM vidangeHydrolique where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row) {
        # code...

              $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
              foreach ($getArticle as $tab1) {
              # code...
              $montant5 =  $row["qtite"] * $tab1['PU'];
            }
          $total5 = $total5 + $montant5; 
      }
    }else{
      // echo "nada";
    }
if (empty($date_debut) && empty($date_fin) && !empty($id_operation)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  code_camion="'.$id_operation.'"')->result_array();
        }elseif (empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange >="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange <="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange between "'.$date_debut.'" and "'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_operation) && empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange <="'.$date_fin.'" and code_camion="'.$id_operation.'"')->result_array();

        }elseif (empty($date_fin) && !empty($id_operation) && !empty($date_debut)){
            # code...
            $getPrime = $this->db->query('SELECT * FROM vidangeBoite WHERE  date_vidange <="'.$date_debut.'" and code_camion="'.$id_operation.'"')->result_array();

        }else{
            $getPrime = $this->db->query('SELECT * FROM vidangeBoite')->result_array();
        }
      // $getPrime = $this->db->query("SELECT * FROM vidangeBoite where id_operation =".$id_operation."")->result_array();

    if (count($getPrime) >0 ) {
      # code...
      foreach ($getPrime as $row){
        # co
              $getArticle = $this->db->query("SELECT * from type_huile where id_type =".$row['id_type_huile']."")->result_array();
               foreach ($getArticle as $tab1) {
              # code...
              $montant5 =  $row["qtite"] * $tab1['PU'];
            }
          $total5 = $total5 + $montant5; 
      }
    }else{
      // echo "nada";
    }
    // echo $total." FCFA";
 $somme = $total+$total1+$total2+$total3+$total4+$total5;

 return $somme;
 }


 public function getSolde(){
  echo $this->selectAllTotalChargementOperationPourBalance()+$this->selectAllTotalFactureOperationPourBalance()+$this->selectAllTotalLocationEnginOperationPourBalance()-$this->totalDepenseParOperation()-$this->selectAllTotalPneuPourBalance();

    // echo $this->totalDepenseParOperation()+$this->selectAllTotalPneuPourBalance();
 }



 public function addEngin($status){
        $type_camion = $_POST['type_camion'];
        $code = $_POST["code"];
        $kilometrage = $_POST["kilometrage"];
        $assurance = $_POST["assurance"];
        $chauffeur = $_POST["chauffeur"];
        $chassis = $_POST["chassis"];
        $puissance = $_POST["puissance"];
        $immatriculation = $_POST["immatriculation"];
        $carte_grise = $_POST["carte_grise"];
        $visite_technique = $_POST["visite_technique"];
        $taxe = $_POST["taxe"];
        $acces_port = $_POST["acces_port"];
        $licence_transport = $_POST["licence_transport"];
        $attestation = $_POST["attestation"];
        $nbreRoue = $_POST["nbreRoue"];
        $nbreRoueSecours = $_POST['nbreRoueSecours'];
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
                  $query = $this->db->query("select * from engin where code='".$code."'")->result_array();
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
                     $query4 = $this->db->query("select * from engin where immatriculation='".$immatriculation."'")->result_array();
                        if (count($query4)>0) {
                            echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                        }else{
                            $query5 = $this->db->query("select * from camion_benne where immatriculation='".$immatriculation."'")->result_array();
                                if (count($query5)>0) {
                                    echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                                }else{
                                        $query5 = $this->db->query("select * from engin where chassis='".$chassis."'")->result_array();
                                    if (count($query5)>0) {
                                        echo "Ce numéro de chassis appartient déjà à un autre véhicule veuillez changer";
                                    }else{
                                       
                                                $query1 = $this->db->query("insert into engin value('','". $code. "','". $immatriculation."',".$type_camion.",'".$chassis."',".$kilometrage.",".$puissance.",".$assurance.",".$carte_grise.",".$visite_technique.",".$chauffeur.",".$taxe.",".$acces_port.",".$licence_transport.",".$attestation.",".$nbreRoue.",".$nbreRoueSecours.")");
                                        if($query1 == true){
                                            echo "Insertion parfaite du camion";
                                        }else{
                                            echo "Erreur durant l'insertion";
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

              $query = $this->db->query("select * from camion_benne where code='".$code."' limit 1")->result_array();
        if (count($query)>0) {
            echo "Ce code est déjà utilisé veuillez changer";

        }else{
                  $query = $this->db->query("select * from engin where code='".$code."' limit 1")->row();
        if (count($query)>0) {
            

            if ($id_camion == $query->id_camion) {
                # code...

             $query2 = $this->db->query("select * from tracteur where code='".$code."' limit 1")->result_array();
            if (count($query2)>0) {
                echo "Ce code est déjà utilisé veuillez changer";
            }else{
                 $query3 = $this->db->query("select * from tracteur where immatriculation='".$immatriculation."' limit 1")->result_array();
                if (count($query3)>0) {
                    echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                }else{
                     $query4 = $this->db->query("select * from engin where immatriculation='".$immatriculation."' limit 1")->row();
                        if (count($query4)>0) {
                            
                            if ($id_camion == $query4->id_camion) {
                                # code...
                                $query5 = $this->db->query("select * from camion_benne where immatriculation='".$immatriculation."' limit 1")->result_array();
                                if (count($query5)>0) {
                                    echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                                }else{
                                        $query5 = $this->db->query("select * from engin where chassis='".$chassis."' limit 1")->row();
                                    if (count($query5)>0) {
                                       
                                        if ($id_camion == $query5->id_camion) {
                                            # code...
                                            $query1 = $this->db->query("UPDATE engin set id_type_camion = ".$type_camion.", code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_visite=".$visite_technique.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours." where id_camion=".$id_camion."");

                                        if($query1 == true){
                                             echo "Modification parfaite du camion";
                                              }else{
                                                echo "Erreur durant l'insertion";
                                                 }
                                                          
                                        }else{
                                             echo "Ce numéro de chassis appartient déjà à un autre véhicule veuillez changer";
                                        }
                                    }else{
                                       
                                        $query1 = $this->db->query("UPDATE engin set id_type_camion = ".$type_camion.",code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_visite=".$visite_technique.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours." where id_camion=".$id_camion."");

                        if($query1 == true){
                             echo "Modification parfaite du camion";
                              }else{
                                echo "Erreur durant l'insertion";
                                 }
                                            
                                        
                                    }

                                    
                                }
                            }else{
                                echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                            }
                        }else{
                            $query5 = $this->db->query("select * from camion_benne where immatriculation='".$immatriculation."' limit 1")->result_array();
                                if (count($query5)>0) {
                                    echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                                }else{
                                        $query5 = $this->db->query("select * from engin where chassis='".$chassis."' limit 1")->row();
                                    if (count($query5)>0) {
                                       
                                        if ($id_camion == $query5->id_camion) {
                                            # code...
                                            $query1 = $this->db->query("UPDATE engin set id_type_camion = ".$type_camion.",code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_visite=".$visite_technique.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours." where id_camion=".$id_camion."");

                                        if($query1 == true){
                                             echo "Modification parfaite du camion";
                                              }else{
                                                echo "Erreur durant l'insertion";
                                                 }
                                                          
                                        }else{
                                             echo "Ce numéro de chassis appartient déjà à un autre véhicule veuillez changer";
                                        }
                                    }else{
                                       
                                        $query1 = $this->db->query("UPDATE engin set id_type_camion = ".$type_camion.",code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_visite=".$visite_technique.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours." where id_camion=".$id_camion."");

                        if($query1 == true){
                             echo "Modification parfaite du camion";
                              }else{
                                echo "Erreur durant l'insertion";
                                 }
                                            
                                        
                                    }

                                    
                                }
                        }
                }
            }
            }else{
               echo "Ce code est déjà utilisé veuillez changer"; 
            }

        }else{
             $query2 = $this->db->query("select * from tracteur where code='".$code."' limit 1")->result_array();
            if (count($query2)>0) {
                echo "Ce code est déjà utilisé veuillez changer";
            }else{
                 $query3 = $this->db->query("select * from tracteur where immatriculation='".$immatriculation."' limit 1")->result_array();
                if (count($query3)>0) {
                    echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                }else{
                     $query4 = $this->db->query("select * from engin where immatriculation='".$immatriculation."' limit 1")->row();
                        if (count($query4)>0) {
                            
                            if ($id_camion == $query4->id_camion) {
                                # code...
                                $query5 = $this->db->query("select * from camion_benne where immatriculation='".$immatriculation."' limit 1")->result_array();
                                if (count($query5)>0) {
                                    echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                                }else{
                                        $query5 = $this->db->query("select * from engin where chassis='".$chassis."' limit 1")->row();
                                    if (count($query5)>0) {
                                       
                                        if ($id_camion == $query5->id_camion) {
                                            # code...
                                            $query1 = $this->db->query("UPDATE engin set id_type_camion = ".$type_camion.",code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_visite=".$visite_technique.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours." where id_camion=".$id_camion."");

                                        if($query1 == true){
                                             echo "Modification parfaite du camion";
                                              }else{
                                                echo "Erreur durant l'insertion";
                                                 }
                                                          
                                        }else{
                                             echo "Ce numéro de chassis appartient déjà à un autre véhicule veuillez changer";
                                        }
                                    }else{
                                       
                                        $query1 = $this->db->query("UPDATE engin set id_type_camion = ".$type_camion.",code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_visite=".$visite_technique.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours." where id_camion=".$id_camion."");

                        if($query1 == true){
                             echo "Modification parfaite du camion";
                              }else{
                                echo "Erreur durant l'insertion";
                                 }
                                            
                                        
                                    }

                                    
                                }
                            }else{
                                echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                            }
                        }else{
                            $query5 = $this->db->query("select * from camion_benne where immatriculation='".$immatriculation."' limit 1")->result_array();
                                if (count($query5)>0) {
                                    echo "Cette immatriculation appartient déjà à un autre véhicule veuillez changer";
                                }else{
                                        $query5 = $this->db->query("select * from engin where chassis='".$chassis."' limit 1")->row();
                                    if (count($query5)>0) {
                                       
                                        if ($id_camion == $query5->id_camion) {
                                            # code...
                                            $query1 = $this->db->query("UPDATE engin set id_type_camion = ".$type_camion.",code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_visite=".$visite_technique.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours." where id_camion=".$id_camion."");

                                        if($query1 == true){
                                             echo "Modification parfaite du camion";
                                              }else{
                                                echo "Erreur durant l'insertion";
                                                 }
                                                          
                                        }else{
                                             echo "Ce numéro de chassis appartient déjà à un autre véhicule veuillez changer";
                                        }
                                    }else{
                                       
                                        $query1 = $this->db->query("UPDATE engin set id_type_camion = ".$type_camion.",code='". $code. "',immatriculation='". $immatriculation."',chassis='".$chassis."',kilometrage =".$kilometrage.",puissance=".$puissance.",id_assurance=".$assurance.",id_carte_grise=".$carte_grise.",id_visite=".$visite_technique.",id_taxe_essieu=".$taxe.",id_acces_port=".$acces_port.",id_licence_transport=".$licence_transport.",id_attestation=".$attestation.",nbreRoue=".$nbreRoue.",nbreRoueSecours=".$nbreRoueSecours." where id_camion=".$id_camion."");

                        if($query1 == true){
                             echo "Modification parfaite du camion";
                              }else{
                                echo "Erreur durant l'insertion";
                                 }
                                            
                                        
                                    }

                                    
                                }
                        }
                }
            }
        }
        }
 }else{
            echo "Erreur contactez votre administrateur";
        }
 }
 
public function getImmatriculationParCode(){
    $code = $_POST['code_camion'];
    $getTracteur = $this->db->query("SELECT * from tracteur where code ='".$code."'")->row();
    $getCamion = $this->db->query("SELECT * from camion_benne where code ='".$code."'")->row();
    $getEngin = $this->db->query("SELECT * from camion_benne where code ='".$code."'")->row();

    if (count($getTracteur)>0) {
        # code...
        return $getTracteur->immatriculation;
    }elseif (count($getCamion)>0) {
        # code...
        return $getCamion->immatriculation;
    }elseif (count($getEngin)>0) {
        # code...
        return $getEngin->immatriculation;
    }
}

public function getModeleVehiculeParCode(){
    $code = $_POST['code_camion'];
    $getTracteur = $this->db->query("SELECT * from tracteur where code ='".$code."'")->row();
    $getCamion = $this->db->query("SELECT * from camion_benne where code ='".$code."'")->row();
    $getEngin = $this->db->query("SELECT * from camion_benne where code ='".$code."'")->row();

    if (count($getTracteur)>0) {
        # code...
        return "Tracteur";
    }elseif (count($getCamion)>0) {
        # code...
        return "Camion benne";
    }elseif (count($getEngin)>0) {
        # code...
        return "Engin";
    }
}
public function getMontantVehiculeParCode(){
    $code = $_POST['code_camion'];
    $getTracteur = $this->db->query("SELECT * from tracteur where code ='".$code."'")->row();
    $getCamion = $this->db->query("SELECT * from camion_benne where code ='".$code."'")->row();
    $getEngin = $this->db->query("SELECT * from engin where code ='".$code."'")->row();

    if (count($getTracteur)>0) {
        # code...
        $getMontantTypeVehicule = $this->db->query("SELECT * from type_vehicule where id_type ='".$getTracteur->id_type_camion."'")->row();

        return $getMontantTypeVehicule->montant;
    }elseif (count($getCamion)>0) {
        # code...
       $getMontantTypeVehicule = $this->db->query("SELECT * from type_vehicule where id_type ='".$getCamion->id_type_camion."'")->row();

        return $getMontantTypeVehicule->montant;
    }elseif (count($getEngin)>0) {
        # code...
        $getMontantTypeVehicule = $this->db->query("SELECT * from type_vehicule where id_type ='".$getEngin->id_type_camion."'")->row();

        return $getMontantTypeVehicule->montant;
    }
}

public function getMontantUnitaireVehiculeParCode($id_distance){

        $getDistance= $this->db->query("SELECT * from distance_littrage where id_distance ='".$id_distance."'")->row();
if (count($getDistance)>0) {
    # code...
    return $getDistance->amortissement;
}else{
    return 0;
}
        

}

 public function getAmortissementParCodeCamion(){
    $code_camion = $_POST['code_camion'];
$compteur = 0;
    $getBonLivraison = $this->db->query("SELECT * from bon_livraison where code_camion = '".$code_camion."'")->result_array();
    foreach ($getBonLivraison as $bon) {
        # code...
        echo "<tr>
        <td>".$compteur."</td>
        <td>".$code_camion."</td>
        <td>".$this->getImmatriculationParCode()."</td>
        <td>".$this->getModeleVehiculeParCode()."</td>
        <td>".$bon['numero']."</td>
        <td>".$bon['quantite']."</td>
        <td> ".number_format($this->getMontantUnitaireVehiculeParCode($bon['id_destination_litrage']),0,',',' ')."</td>
        <td> ".number_format($this->getMontantUnitaireVehiculeParCode($bon['id_destination_litrage'])*$bon['quantite'],0,',',' ')."</td>
        </tr>";
        $compteur++;
    }
 }

  public function cumulAmortissementParCamion(){
    $code_camion = $_POST['code_camion'];
$compteur = 0;
$montant = 0;
    $getBonLivraison = $this->db->query("SELECT * from bon_livraison where code_camion = '".$code_camion."'")->result_array();
    foreach ($getBonLivraison as $bon) {
        
       $prix = $this->getMontantUnitaireVehiculeParCode($bon['id_destination_litrage'])*$bon['quantite'];

       $montant = $montant+$prix;

        
    }
    return $montant;
 }

 // public function cumulAmortissementParCamion(){
 //    $code_camion = $_POST['code_camion'];
 //    $montant = 0;
 //     $getBonLivraison = $this->db->query("SELECT * from bon_livraison where code_camion = '".$code_camion."'")->result_array();
 //    foreach ($getBonLivraison as $bon) {
 //        # code...

 //       $montant = $this->getMontantVehiculeParCode()*$bon['quantite'];
     
 //    }
 //    return $montant;
 // }
public function getMontantInitialParCode(){
    $code = $_POST['code_camion'];
    $getTracteur = $this->db->query("SELECT * from tracteur where code ='".$code."' limit 1")->row();
    $getCamion = $this->db->query("SELECT * from camion_benne where code ='".$code."' limit 1")->row();

    if (count($getTracteur)>0) {
        # code...
        return $getTracteur->montant_init;
    }elseif (count($getCamion)>0) {
        # code...
       return $getCamion->montant_init;
    }else{
        return 0;
    }
}

public function getDateInitialParCode(){
    $code = $_POST['code_camion'];
    $getTracteur = $this->db->query("SELECT * from tracteur where code ='".$code."' limit 1")->row();
    $getCamion = $this->db->query("SELECT * from camion_benne where code ='".$code."' limit 1")->row();

    if (count($getTracteur)>0) {
        # code...
        return $getTracteur->date_init;
    }elseif (count($getCamion)>0){
        # code...
       return $getCamion->date_init;
    }else{
        return 0;
    }
}

 public function getSoldeAmortissement(){
    echo $this->getMontantVehiculeParCode()-$this->getMontantInitialParCode()-$this->cumulAmortissementParCamion();
 }
}