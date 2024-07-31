<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model extends CI_Model {
// 
    function __construct() {
        parent::__construct();
        // $this->load->database('default');
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


    public function login(){
        $password = $_POST["password"];
        $login = $_POST["login"];

        if(!filter_var($login,FILTER_VALIDATE_EMAIL)){
            // echo "Email invalide";
            $this->getConnexion(sha1($password),$login,"identifiant");
        }else{
            $this->getConnexion(sha1($password),$login,"email");
        }
        $this->db->close();
    }
    
    public function getConnexion($password,$login,$champ){
        $query1 = $this->db->query("select * from profil where password='".$password."' and ".$champ."='".$login."'")->result_array();

        $nom_table = "profil";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    
   
        if (count($query1) > 0) {
            # code...
            echo "Connexion réussie";
            foreach ($query1 as $row) {
                # code...
                $this->session->set_userdata("identifiant", $row["identifiant"]);
                $this->session->set_userdata("id_profil", $row["id_profil"]);
                $this->session->set_userdata("type_compte", $row["type"]);
                // $query2 = $this->db->query("insert into historique_connexion value('',".$row["id_profil"].",now(),now())");
                // if ($query2 ==true) {
                //     # code...
                // }else{
                    
                // }
                $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." s'est connecté le ".$date_notif." à ".$heure;

                $this->notificationAjout($nom_table,addslashes($message));
				
			$query1 = $this->db->query("select * from pv_mira_sa where id_profile=".$row["id_profil"]."")->row();

             if (count($query1)>0) {
                 # code...
                $this->session->set_userdata("mira_sa_modification", $query1->modification);
                $this->session->set_userdata("mira_sa_suppression", $query1->suppression);
                $this->session->set_userdata("mira_sa_ajout", $query1->ajout);
             }
			 
			 $query1 = $this->db->query("select * from pv_document where id_profile=".$row["id_profil"]."")->row();

             if (count($query1)>0) {
                 # code...
                $this->session->set_userdata("document_modification", $query1->modification);
                $this->session->set_userdata("document_suppression", $query1->suppression);
                $this->session->set_userdata("document_ajout", $query1->ajout);
             }
			 
			 
			 $query1 = $this->db->query("select * from pv_administration where id_profile=".$row["id_profil"]."")->row();

             if (count($query1)>0) {
                 # code...
                $this->session->set_userdata("demande_modification", $query1->modification);
                $this->session->set_userdata("demande_suppression", $query1->suppression);
                $this->session->set_userdata("demande_ajout", $query1->ajout);
             }
			 
			  $query1 = $this->db->query("select * from pv_parametres where id_profile=".$row["id_profil"]."")->row();

             if (count($query1)>0) {
                 # code...
                $this->session->set_userdata("parametres_modification", $query1->modification);
                $this->session->set_userdata("paratemetres_suppression", $query1->suppression);
                $this->session->set_userdata("parametres_ajout", $query1->ajout);
             }
			 
			  $query1 = $this->db->query("select * from pv_commande where id_profile=".$row["id_profil"]."")->row();

             if (count($query1)>0) {
                 # code...
                $this->session->set_userdata("commande_modification", $query1->modification);
                $this->session->set_userdata("commande_suppression", $query1->suppression);
                $this->session->set_userdata("commande_ajout", $query1->ajout);
             }
			 

             $query1 = $this->db->query("select * from pv_gestion_client where id_profile=".$row["id_profil"]."")->row();

             if (count($query1)>0) {
                 # code...
                $this->session->set_userdata("client_modification", $query1->modification);
                $this->session->set_userdata("client_suppression", $query1->suppression);
                $this->session->set_userdata("client_ajout", $query1->ajout);
             }

             $query2 = $this->db->query("select * from pv_depenses where id_profile=".$row["id_profil"]."")->row();

             if (count($query2)>0) {
                 # code...
                $this->session->set_userdata("depense_modification", $query2->modification);
                $this->session->set_userdata("depense_suppression", $query2->suppression);
                $this->session->set_userdata("depense_ajout", $query2->ajout);
             }

             $query2 = $this->db->query("select * from pv_fournisseur_caisse where id_profile=".$row["id_profil"]."")->row();

             if (count($query2)>0) {
                 # code...
                $this->session->set_userdata("fournisseur_caisse_modification", $query2->modification);
                $this->session->set_userdata("fournisseur_caisse_suppression", $query2->suppression);
                $this->session->set_userdata("fournisseur_caisse_ajout", $query2->ajout);
             }

             $query2 = $this->db->query("select * from pv_gestion_article where id_profile=".$row["id_profil"]."")->row();

             if (count($query2)>0) {
                 # code...
                $this->session->set_userdata("article_modification", $query2->modification);
                $this->session->set_userdata("article_suppression", $query2->suppression);
                $this->session->set_userdata("article_ajout", $query2->ajout);
             }

             $query2 = $this->db->query("select * from pv_gestion_caisse where id_profile=".$row["id_profil"]."")->row();

             if (count($query2)>0) {
                 # code...
                $this->session->set_userdata("caisse_modification", $query2->modification);
                $this->session->set_userdata("caisse_suppression", $query2->suppression);
                $this->session->set_userdata("caisse_ajout", $query2->ajout);
             }

             $query2 = $this->db->query("select * from pv_gestion_chauffeur where id_profile=".$row["id_profil"]."")->row();

             if (count($query2)>0) {
                 # code...
                $this->session->set_userdata("chauffeur_modification", $query2->modification);
                $this->session->set_userdata("chauffeur_suppression", $query2->suppression);
                $this->session->set_userdata("chauffeur_ajout", $query2->ajout);
             }

             $query2 = $this->db->query("select * from pv_gestion_gazoil where id_profile=".$row["id_profil"]."")->row();

             if (count($query2)>0) {
                 # code...
                $this->session->set_userdata("gazoil_modification", $query2->modification);
                $this->session->set_userdata("gazoil_suppression", $query2->suppression);
                $this->session->set_userdata("gazoil_ajout", $query2->ajout);
             }

             $query2 = $this->db->query("select * from pv_gestion_pneu where id_profile=".$row["id_profil"]."")->row();

             if (count($query2)>0) {
                 # code...
                $this->session->set_userdata("pneu_modification", $query2->modification);
                $this->session->set_userdata("pneu_suppression", $query2->suppression);
                $this->session->set_userdata("pneu_ajout", $query2->ajout);
             }

             $query2 = $this->db->query("select * from pv_gestion_stock where id_profile=".$row["id_profil"]."")->row();

             if (count($query2)>0) {
                 # code...
                $this->session->set_userdata("stock_modification", $query2->modification);
                $this->session->set_userdata("stock_suppression", $query2->suppression);
                $this->session->set_userdata("stock_ajout", $query2->ajout);
             }

             $query2 = $this->db->query("select * from pv_gestion_vehicule where id_profile=".$row["id_profil"]."")->row();

             if (count($query2)>0) {
                 # code...
                $this->session->set_userdata("vehicule_modification", $query2->modification);
                $this->session->set_userdata("vehicule_suppression", $query2->suppression);
                $this->session->set_userdata("vehicule_ajout", $query2->ajout);
             }

             $query2 = $this->db->query("select * from pv_operation where id_profile=".$row["id_profil"]."")->row();

             if (count($query2)>0) {
                 # code...
                $this->session->set_userdata("operation_modification", $query2->modification);
                $this->session->set_userdata("operation_suppression", $query2->suppression);
                $this->session->set_userdata("operation_ajout", $query2->ajout);
             }

           
             $query2 = $this->db->query("select * from pv_recette where id_profile=".$row["id_profil"]."")->row();

             if (count($query2)>0) {
                 # code...
                $this->session->set_userdata("recette_modification", $query2->modification);
                $this->session->set_userdata("recette_suppression", $query2->suppression);
                $this->session->set_userdata("recette_ajout", $query2->ajout);

             }

             $query2 = $this->db->query("select * from pv_vidange where id_profile=".$row["id_profil"]."")->row();

             if (count($query2)>0) {
                 # code...
                $this->session->set_userdata("vidange_modification", $query2->modification);
                $this->session->set_userdata("vidange_suppression", $query2->suppression);
                $this->session->set_userdata("vidange_ajout", $query2->ajout);
             }
             $query2 = $this->db->query("select * from pv_users where id_profile=".$row["id_profil"]."")->row();

             if (count($query2)>0) {
                 # code...
                $this->session->set_userdata("users_modification", $query2->modification);
                $this->session->set_userdata("users_suppression", $query2->suppression);
                $this->session->set_userdata("users_ajout", $query2->ajout);
             }

             $query2 = $this->db->query("select * from pv_rapport where id_profile=".$row["id_profil"]."")->row();

             if (count($query2)>0) {
                 # code...
                $this->session->set_userdata("rapport_modification", $query2->modification);
                $this->session->set_userdata("rapport_suppression", $query2->suppression);
                $this->session->set_userdata("rapport_ajout", $query2->ajout);
             }

             $query2 = $this->db->query("select * from pv_distance_parcourue where id_profile=".$row["id_profil"]."")->row();

             if (count($query2)>0) {
                 # code...
                $this->session->set_userdata("distance_modification", $query2->modification);
                $this->session->set_userdata("distance_suppression", $query2->suppression);
                $this->session->set_userdata("distance_ajout", $query2->ajout);
             }

             $query2 = $this->db->query("select * from pv_operation_gazoil where id_profile=".$row["id_profil"]."")->row();

             if (count($query2)>0) {
                 # code...
                $this->session->set_userdata("operation_gazoil_modification", $query2->modification);
                $this->session->set_userdata("operation_gazoil_suppression", $query2->suppression);
                $this->session->set_userdata("operation_gazoil_ajout", $query2->ajout);
             }

             

            }
            
        }else{
            echo "Echec de connexion";
        }

        $this->db->close();
    }

    public function addTypePneu(){
        $nomPneu = $_POST["nom_type"];
        $status = $_POST["status"];


        $nom_table = "type_pneu";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté un type de pneu appelé  ".$nomPneu." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié un type de pneu appelé ".$nomPneu." le ".$date_notif." à ".$heure;

        if ($status == "insert") {
            # code...
            

            $getPneu = $this->db->query("SELECT * from type_pneu where nom_type ='".$nomPneu."'")->result_array();
            if (count($getPneu)>0) {
                # code...
                echo "Ce type de pneu existe déjà veuillez insérer un autre";
            }else{
                $query = $this->db->query("insert into type_pneu value('','".$nomPneu."')");
                if ($query == true) {
                    # code...
                    echo "Insertion parfaite du type de Pneu";

                    $this->notificationAjout($nom_table,addslashes($message));

                }else{
                    echo "Erreur contactez l'administrateur";
                }
            }
            
        }elseif ($status == "update") {
            # code...
            $id_type_pneu = $_POST["id_type_pneu"];
            $getPneu = $this->db->query("SELECT * from type_pneu where nom_type ='".$nomPneu."'")->result_array();
            if (count($getPneu)>0) {
                # code...
                echo "Ce type de pneu existe déjà veuillez insérer un autre";
            }else{
                $query = $this->db->query("UPDATE type_pneu set nom_type='".$nomPneu."' where id_type_pneu=".$id_type_pneu."");
                if ($query == true) {
                    # code...
                    echo "Modification parfaite du type de Pneu";
                    $this->notificationAjout($nom_table,addslashes($message2));
                }else{
                    echo "Erreur contactez l'administrateur";
                }
            }
        }

        $this->db->close();
    }

    public function getTypePneu($id_type_pneu){
        $getTypePneu = $this->db->query("SELECT * FROM type_pneu WHERE id_type_pneu =".$d_type_pneu."")->result_array();
                      if (count($getTypePneu)>0) {
                          # code...
                        foreach ($getTypePneu as $row1) {
                            # code...
                           return $row1['nom_type'];
                        }
                }

            $this->db->close();
    }


    public function insertPneu($numero,$date_creation,$date_expiration,$immatriculation,$id_type_pneu,$status,$montant){
        $kilometrage_debut = $_POST["kilometrage_debut"];
        $kilometrage_fin = $_POST["kilometrage_fin"];
        $date_retrait = $_POST["date_retrait"];

         $nom_table = "pneu";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté un pneu de type ".$this->getTypePneu($id_type_pneu).", de numéro ".$numéro.", à un montant de ".$montant." FCFA pour le véhicule immatriculé ".$immatriculation." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié un pneu de type ".$this->getTypePneu($id_type_pneu).", de numéro ".$numéro.", à un montant de ".$montant." FCFA pour le véhicule immatriculé ".$immatriculation." le ".$date_notif." à ".$heure;

            $verifNumero = $this->db->query("SELECT * from pneu where numero ='".$numero."'")->result_array();
                if (count($verifNumero)>0) {
                    # code...
                    echo "Ce numéro est déja utilisé par un autre pneu veuillez le changer SVP";
                }else{
                    $insert = $this->db->query("INSERT into pneu value('',".$id_type_pneu.",'".$numero."',CAST('". $date_creation."' AS DATE),CAST('". $date_expiration."' AS DATE),'".$immatriculation."',".$kilometrage_debut.",".$kilometrage_fin.",CAST('". $date_retrait."' AS DATE),1,0,0,".$montant.")");
                if ($insert == true ) {
                    # code...
                    echo "Insertion parfaite du pneu";
                    $this->notificationAjout($nom_table,addslashes($message));
                }else{
                    echo "Erreur contactez l'administrateur";
                }
         }  

         $this->db->close();
    }

    public function requeteAddRoueSecour($secours,$id_pneu){
        $update = $this->db->query("UPDATE pneu set secours =".$secours." where id_pneu=".$id_pneu."");
        if ($update == true) {
            # code...
            echo "Requete éffectuée";
        }else{
            echo "Contactez l'administrateur";
        }
        $this->db->close();
    }

    public function addRoueSecours(){
        $id_pneu = $_POST["id_pneu"];
        $immatriculation = $_POST["immatriculation"];
        $secours = $_POST["secours"];
            $getTracteur = $this->db->query("SELECT * from tracteur WHERE immatriculation = '".$immatriculation."'")->result_array();
            $getRemorque = $this->db->query("SELECT * from remorque WHERE immatriculation = '".$immatriculation."'")->result_array();
            $getCamionBenne = $this->db->query("SELECT * from camion_benne WHERE immatriculation = '".$immatriculation."'")->result_array();        
       
        if ($secours == 1) {
            # code... ici on va enlever le 
            $verifSecours = $this->db->query("SELECT * from pneu where immatriculation='".$immatriculation."' and service = 1 and secours =1")->result_array();
            if (count($verifSecours) >0) {
                # code...
                if (count($getTracteur)>0) {
                    # code...
                    foreach ($getTracteur as $tab) {
                        # code...
                        if (count($verifSecours)>=$tab['nbreRoueSecours']) {
                            # code...
                            echo "Le nombre total de roue de secours est atteint pour ce tracteur";
                        }else{
                            $this->requeteAddRoueSecour($secours,$id_pneu);
                        }
                    }
                }elseif (count($getRemorque)>0) {
                    # code...
                    foreach ($getRemorque as $tab) {
                        # code...
                        if (count($verifSecours)>=$tab['nbreRoueSecours']) {
                            # code...
                            echo "Le nombre total de roue de secours est atteint pour cette remorque";
                        }else{
                            $this->requeteAddRoueSecour($secours,$id_pneu);
                        }
                    }
                }elseif (count($getCamionBenne)>0) {
                    # code...
                    foreach ($getCamionBenne as $tab) {
                        # code...
                        if (count($verifSecours)>=$tab['nbreRoueSecours']) {
                            # code...
                            echo "Le nombre total de roue de secours est atteint pour ce camion bennne";
                        }else{
                            $this->requeteAddRoueSecour($secours,$id_pneu);
                        }
                    }
                }
                
            }else{
                $this->requeteAddRoueSecour($secours,$id_pneu);
            }


        }else{
            $nbrePneuImmatriculation = $this->db->query("SELECT * from pneu WHERE immatriculation = '".$immatriculation."' and service=1 and secours=0")->result_array();
            if (count($nbrePneuImmatriculation)>0) {
             
                    # code...
                    if (count($getRemorque)>0) {
                        # code...
                        foreach ($getRemorque as $tab1) {
                            # code...
                            if (count($nbrePneuImmatriculation)>= $tab1['nbreRoue']) {
                                # code...
                                echo "Nombre de roue chaussée deja suffisant pour cette remorque ";
                            }else{
                                $this->requeteAddRoueSecour($secours,$id_pneu);
                            }
                        }
                    }elseif (count($getTracteur)>0) {
                        # code...
                        foreach ($getTracteur as $tab2) {
                            # code...
                            if (count($nbrePneuImmatriculation)>= $tab2['nbreRoue']) {
                                # code...
                                echo "Nombre de roue chaussée deja suffisant pour ce tracteur ";
                            }else{
                                $this->requeteAddRoueSecour($secours,$id_pneu);
                            }
                        }
                    }elseif (count($getCamionBenne)>0) {
                        # code...

                        foreach ($getCamionBenne as $tab3) {
                            # code...
                            if (count($nbrePneuImmatriculation)>= $tab3['nbreRoue']) {
                                # code...
                                echo "Nombre de roue chaussée deja suffisant pour ce camion benne ";
                            }else{
                                $this->requeteAddRoueSecour($secours,$id_pneu);
                            }

                        }
                    }else{
                     $this->requeteAddRoueSecour($secours,$id_pneu);
                         }
                

            }else{
                 $this->requeteAddRoueSecour($secours,$id_pneu);
                  }
           
        }
        
        $this->db->close();
    }

    public function getImmatriculationParCode(){
     $code_camion = $_POST["code_camion"];

     $query = $this->db->query("SELECT * from camion_benne where code like '%".$code_camion."%'")->result_array();

     $query1 = $this->db->query("SELECT * from tracteur where code like '%".$code_camion."%'")->result_array();

     $query3 = $this->db->query("SELECT * from engin where code like '%".$code_camion."%'")->result_array();
     echo "<option></option>";
     if (count($query) > 0) {
         # code...
        foreach ($query as $row) {
            # code...

            echo "<option>".$row["immatriculation"]."</option>";
           
        }
     }elseif (count($query1) > 0) {
         # code...
        foreach ($query1 as $row) {
            # code...

            echo "<option >".$row["immatriculation"]."</option>";
            $query2 = $this->db->query("SELECT * from remorque where id_remorque =".$row['id_remorque']."")->row();

            echo "<option >".$query2->immatriculation."</option>";
        }
     }elseif (count($query3) > 0) {
         # code...
        foreach ($query3 as $row1) {
            # code...

            echo "<option >".$row1["immatriculation"]."</option>";
          
        }
     }else{

     }

     $this->db->close();
    }

    public function getTypeVehicule(){
        $immatriculation = $_POST["immatriculation"];

        $query1 = $this->db->query("SELECT * from tracteur where immatriculation='".$immatriculation."'")->row();
        $query2 = $this->db->query("SELECT * from camion_benne where immatriculation='".$immatriculation."'")->row();
        $query3 = $this->db->query("SELECT * from remorque where immatriculation='".$immatriculation."'")->row();
        $query4 = $this->db->query("SELECT * from engin where immatriculation='".$immatriculation."'")->row();

        if (count($query1)>0) {
            # code...
            echo "Tracteur";
        }elseif (count($query2) > 0) {
            # code...
            echo "Camion benne";
        }elseif (count($query3) >0) {
        
           echo "Remorque"; 
        }elseif (count($query4) >0) {
        
           echo "Engin"; 
        }else{
            echo "Aucun";
        }

        $this->db->close();
    }


public function getKilometrageGasoilParCode($code){
    $query = $this->db->query("SELECT max(kilometrage) as kilometrage from gazoil where code_camion='".$code."'")->row();

    if (count($query)>0) {
        # code...
        return $query->kilometrage;
    }else{
        return "0";
    }
    $this->db->close();
}

public function getKilometrageGasoilParImmatriculation($immatriculation){

    $query1 = $this->db->query("SELECT * from tracteur where immatriculation='".$immatriculation."'")->row();
    $query2 = $this->db->query("SELECT * from camion_benne where immatriculation='".$immatriculation."'")->row();
    $query3 = $this->db->query("SELECT * from remorque where immatriculation='".$immatriculation."'")->row();
    $query4 = $this->db->query("SELECT * from engin where immatriculation='".$immatriculation."'")->row();

    if (count($query1)>0) {
            # code...
           return $this->getKilometrageGasoilParCode($query1->code);
        }elseif (count($query2) > 0) {
            # code...
           return $this->getKilometrageGasoilParCode($query2->code);
        }
        elseif (count($query3) >0) {
            $query5 = $this->db->query("SELECT * from tracteur where id_remorque='".$query3->id_remorque."'")->row();
            if (count($query5)>0) {
                # code...
                return $this->getKilometrageGasoilParCode($query5->code);
            }else{
                return "0";
            }
          
        }
        elseif (count($query4) >0) {
        
          return $this->getKilometrageGasoilParCode($query4->code);
        }else{
            return "Aucun";
        }

        $this->db->close();
}
    public function addPneu(){
        $numero = $_POST["numero"];
        $montant = intval(preg_replace('/\s/','', $_POST["montant"]));
        $date_creation = $_POST["dateCreation"];
        $date_expiration = $_POST["dateExpiration"];
        $immatriculation = $_POST["immatriculation"];
        $id_type_pneu = $_POST["id_type_pneu"];
        $status = $_POST["status"];

            $getTracteur = $this->db->query("SELECT * from tracteur WHERE immatriculation = '".$immatriculation."'")->result_array();
            $getRemorque = $this->db->query("SELECT * from remorque WHERE immatriculation = '".$immatriculation."'")->result_array();
            $getCamionBenne = $this->db->query("SELECT * from camion_benne WHERE immatriculation = '".$immatriculation."'")->result_array();
        
        if ($status == 'insert') {
                # code...
            $nbrePneuImmatriculation = $this->db->query("SELECT * from pneu WHERE immatriculation = '".$immatriculation."' and service=1 and secours=0")->result_array();
            if (count($nbrePneuImmatriculation)>0) {
                # code...
                
                    if (count($getRemorque)>0) {
                        # code...
                        foreach ($getRemorque as $tab1) {
                            # code...
                            if (count($nbrePneuImmatriculation)>= $tab1['nbreRoue']) {
                                # code...
                                echo "Nombre de roue chaussée deja suffisant pour cette remorque ";
                            }else{
                                $this->insertPneu($numero,$date_creation,$date_expiration,$immatriculation,$id_type_pneu,$status,$montant);
                            }
                        }
                    }elseif (count($getTracteur)>0) {
                        # code...
                        foreach ($getTracteur as $tab2) {
                            # code...
                            if (count($nbrePneuImmatriculation)>= $tab2['nbreRoue']) {
                                # code...
                                echo "Nombre de roue chaussée deja suffisant pour ce tracteur ";
                            }else{
                                $this->insertPneu($numero,$date_creation,$date_expiration,$immatriculation,$id_type_pneu,$status,$montant);
                            }
                        }
                    }elseif (count($getCamionBenne)>0) {
                        # code...

                        foreach ($getCamionBenne as $tab3) {
                            # code...
                            if (count($nbrePneuImmatriculation)>= $tab3['nbreRoue']) {
                                # code...
                                echo "Nombre de roue chaussée deja suffisant pour ce camion benne ";
                            }else{
                                $this->insertPneu($numero,$date_creation,$date_expiration,$immatriculation,$id_type_pneu,$status,$montant);
                            }

                        }
                    }else{
                     $this->insertPneu($numero,$date_creation,$date_expiration,$immatriculation,$id_type_pneu,$status,$montant);
                         }
                

            }else{
                 $this->insertPneu($numero,$date_creation,$date_expiration,$immatriculation,$id_type_pneu,$status,$montant);
                  }
           
              
                
            }elseif ($status == 'update') {
                # code...
        $kilometrage_debut = $_POST["kilometrage_debut"];
        $kilometrage_fin = $_POST["kilometrage_fin"];
        $date_retrait = $_POST["date_retrait"];
                $id_pneu = $_POST['id_pneu'];

                $nom_table = "pneu";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté un pneu de type ".$this->getTypePneu($id_type_pneu).", de numéro ".$numéro.", à un montant de ".$montant." FCFA pour le véhicule immatriculé ".$immatriculation." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié un pneu de type ".$this->getTypePneu($id_type_pneu).", de numéro ".$numéro.", à un montant de ".$montant." FCFA pour le véhicule immatriculé ".$immatriculation." le ".$date_notif." à ".$heure;

                        $verifNumero = $this->db->query("SELECT * from pneu where numero ='".$numero."'")->result_array();
                if (count($verifNumero)>0) {
                    # code...
                    foreach ($verifNumero as $tab) {
                        # code...
                        if ($tab['id_pneu'] == $id_pneu) {
                            # code...
                            $update = $this->db->query("UPDATE pneu set id_type_pneu =".$id_type_pneu.", numero ='".$numero."',date_crea =CAST('". $date_creation."' AS DATE),date_exp=CAST('". $date_expiration."' AS DATE),immatriculation='".$immatriculation."',montant=".$montant.",kilometrage_debut=".$kilometrage_debut.",kilometrage_fin=".$kilometrage_fin.",date_retrait=CAST('". $date_expiration."' AS DATE) where id_pneu=".$id_pneu."");
                            if ($update == true ) {
                                # code...
                                echo "Modification parfaite du pneu";
                                $this->notificationAjout($nom_table,addslashes($message2));
                            }else{
                                echo "Erreur contactez l'administrateur";
                            }
                        }else{
                            echo "Ce numéro est déja utilisé par un autre pneu veuillez le changer SVP";
                        }
                    }
                    
                }else{
                    $update = $this->db->query("UPDATE pneu set id_type_pneu =".$id_type_pneu.", numero ='".$numero."',date_crea =CAST('". $date_creation."' AS DATE),date_exp=CAST('". $date_expiration."' AS DATE),immatriculation='".$immatriculation."', montant=".$montant.",kilometrage_debut=".$kilometrage_debut.",kilometrage_fin=".$kilometrage_fin.",date_retrait=CAST('". $date_retrait."' AS DATE where id_pneu=".$id_pneu."");
                if ($update == true ) {
                    # code...
                    echo "Modification parfaite du pneu";

                    $this->notificationAjout($nom_table,addslashes($message2));
                }else{
                    echo "Erreur contactez l'administrateur";
                }
                
                }
                
            }else{
                echo "Erreur contactez l'administrateur SVP";
            }

            $this->db->close();
        
    }

    public function selectAllTypePneu(){
        $requete = $this->db->query("SELECT * from type_pneu order by id_type_pneu desc")->result_array();
        $compteur = 0;
        if (count($requete)>0) {
            # code...
            foreach ($requete as $row) {
                echo "<tr><td>".$compteur."</td>
                      <td>".$row['nom_type']."</td>";
                      echo "<td>
                    <button type='button' onclick=\"infoTypePneu('".$row['nom_type']."','".$row['id_type_pneu']."')\" onclick='' class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button'  class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='type_pneu' identifiant='".$row['id_type_pneu']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_type_pneu\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";

                $compteur = $compteur+1;
            }
        }
        $this->db->close();
    }

    public function selectAllPneu(){
        $requete = $this->db->query("SELECT * from pneu order by id_pneu desc")->result_array();
        $compteur = 0;
        if (count($requete)>0) {
            # code...
            foreach ($requete as $row) {
                echo " <tr><td>".$compteur."</td>";
                      $getTypePneu = $this->db->query("SELECT * FROM type_pneu WHERE id_type_pneu =".$row['id_type_pneu']." ")->result_array();
                      if (count($getTypePneu)>0) {
                          # code...
                        foreach ($getTypePneu as $row1) {
                            # code...
                          // echo "<td>".$row1['nom_type']."</td>";
                        }
                      }
                echo "<td>".$row['numero']."</td>";
                echo "<td>".number_format($row['montant'],0,',',' ')."</td>";
                echo "<td>".$row['date_crea']."</td>";
                echo "<td>".$row['date_exp']."</td>
                      <td>".$row['date_retrait']."</td>";

                $getTracteur = $this->db->query("SELECT * from tracteur WHERE immatriculation ='".$row['immatriculation']."' ")->result_array();
                $getCamionBenne = $this->db->query("SELECT * from camion_benne WHERE immatriculation = '".$row['immatriculation']."'")->result_array();
                $getRemorque = $this->db->query("SELECT * from remorque WHERE immatriculation ='".$row['immatriculation']."'")->result_array();
                if (count($getTracteur)>0 ) {
                    # code...
                    foreach ($getTracteur as $row2) {
                        # code...
                        echo "<td>".$row2['code']."</td>";
                        echo "<td> ".$row['immatriculation']."</td>";
                    }
                    
                }elseif (count($getCamionBenne)>0) {
                    # code...
                    foreach ($getCamionBenne as $row3) {
                        # code...
                        echo "<td>".$row3['code']."</td>";
                        echo "<td> ".$row['immatriculation']."</td>";
                    }
                }elseif (count($getRemorque)>0) {
                    # code...
                    foreach ($getRemorque as $row3) {
                        # code...

                        $getTracteurRemorque = $this->db->query("SELECT * from tracteur WHERE id_remorque = ".$row3['id_remorque']."")->result_array();
                        if (count($getTracteurRemorque) >0) {
                            # code...
                            foreach ($getTracteurRemorque as $row4) {
                                # code...
                                echo "<td>".$row4['code']."</td>";
                                echo "<td> ".$row['immatriculation']."</td>";
                            }
                        }else{
                            echo "<td style='color:red'>Aucun</td><td>".$row['immatriculation']."</td>";
                        }
                        
                    }
                }else{
                    echo "<td style='color:red'>Aucun</td><td>".$row['immatriculation']."</td>";
                }
                $duree = strtotime($row['date_retrait']) - strtotime($row['date_crea']);
                if ($duree < 0) {
                    # code...
                    $duree = 0;
                }else{
                    $duree = $duree/86400;
                }
                $kilometrage = $row['kilometrage_fin']-$row['kilometrage_debut'];
                 echo  "<td>".$row['kilometrage_debut']."</td>
                        <td>".$row['kilometrage_fin']."</td>
                        <td>".$kilometrage."</td>
                        <td>".$duree." Jours</td>";
                if ($row["secours"] == 1) {
                    # code...
                    echo "<td> <a class='btn btn-danger btn-sm' onclick=\"addRoueSecours('".$row["id_pneu"]."','".$row["immatriculation"]."','0')\">
                              <i class=' fas fa-times'></i>Secours</a></td>";
                }elseif ($row["secours"] == 0 && $row["defectueux"]!=1) {
                    # code...
                    echo "<td> <a class='btn btn-info btn-sm' onclick=\"addRoueSecours('".$row["id_pneu"]."','".$row["immatriculation"]."','1')\">
                              <i class=' fas fa-check-circle'></i>chaussée</a></td>";
                }else{
                    echo "<td>-</td>";
                }

                if ($row['service'] == 0 && $row["secours"] == 0 && $row["defectueux"]!=1) {
                    # code...
                    echo "<td> <a class='btn btn-danger btn-sm' onclick=\"updateServicePneu('".$row['id_pneu']."','1','".$row['immatriculation']."')\">
                              <i class=' fas fa-times''></i></a></td>";
                }elseif ($row["service"] == 1 && $row["secours"] == 0) {
                    # code...
            
                   echo "<td> <a class='btn btn-success btn-sm' onclick=\"updateServicePneu('".$row['id_pneu']."','0','".$row['immatriculation']."')\">
                              <i class='fas fa-check-circle'></i></a></td>";
                }
                else{
                    echo "<td>-</td>";
                }

                if ($row["defectueux"]==1) {
                    # code...
                    
                    echo "<td style='color:red;'>Défectueux</td>";
                }elseif ($row["defectueux"]==0) {
                    # code...
                    if($this->session->userdata('pneu_suppression')=='true'){
                   echo "<td> <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-info' table='pneu' identifiant='".$row['id_pneu']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_pneu\");'><i class='fas fa-cog'></i></button></td>";}
                    
                }
                if($this->session->userdata('pneu_suppression')=='true'){
                echo "<td><button type='button' onclick=\"getInfosPneu('".$row['numero']."','".$row['date_crea']."','".$row['date_exp']."','".$row['id_pneu']."','".$row['montant']."','".$row['kilometrage_debut']."','".$this->getKilometrageGasoilParImmatriculation($row['immatriculation'])."','".$row['date_retrait']."','".$row['immatriculation']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                    }

                if($this->session->userdata('pneu_suppression')=='true'){
                echo"
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='pneu' identifiant='".$row['id_pneu']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_pneu\");'><i class='far fa-trash-alt'></i></button>"; }
                    echo"
                    </td></tr>";
                $compteur++;
            }
        }

        $this->db->close();
    }

    public function requeteMiseEnServicePneu1(){
        $id_pneu = $_POST["id_pneu"];
        $etat = $_POST["etat"];

        $reqService = $this->db->query("UPDATE pneu set service=".$etat." where id_pneu = ".$id_pneu."");
        if ($reqService == true) {
            # code...
            echo "requete éffectuée";
        }else{
            echo "Erreur contactez l'administrateur";
        }

        $this->db->close();
    }

    public function declarePneuDefectueux(){
        $id_pneu = $_POST["id_pneu"];
        $updatePneu = $this->db->query("UPDATE pneu set service =0, secours=0, defectueux = 1 where id_pneu=".$id_pneu."");

        if ($updatePneu == true) {
            # code...
            echo "Vous venez de déclarer ce pneu \"Défectueux\" et vous l'avez mis définitivement hors service";
        }else{
            echo "Erreur veuillez contacter votre administrateur";
        }

        $this->db->close();
    }

        public function miseEnServicePneu(){
        $id_pneu = $_POST["id_pneu"];
        $immatriculation = $_POST["immatriculation"];
        $secours = $_POST["etat"];
            $getTracteur = $this->db->query("SELECT * from tracteur WHERE immatriculation = '".$immatriculation."'")->result_array();
            $getRemorque = $this->db->query("SELECT * from remorque WHERE immatriculation = '".$immatriculation."'")->result_array();
            $getCamionBenne = $this->db->query("SELECT * from camion_benne WHERE immatriculation = '".$immatriculation."'")->result_array();        
       
        if ($secours == 1) {
            # code... ici on va enlever le 
            $verifSecours = $this->db->query("SELECT * from pneu where immatriculation='".$immatriculation."' and service = 1 and secours =1")->result_array();
            if (count($verifSecours) >0) {
                # code...
                if (count($getTracteur)>0) {
                    # code...
                    foreach ($getTracteur as $tab) {
                        # code...
                        if (count($verifSecours)>=$tab['nbreRoueSecours']) {
                            # code...
                            echo "Le nombre total de roue de secours est atteint pour ce tracteur";
                        }else{
                            $this->requeteMiseEnServicePneu1();
                        }
                    }
                }elseif (count($getRemorque)>0) {
                    # code...
                    foreach ($getRemorque as $tab) {
                        # code...
                        if (count($verifSecours)>=$tab['nbreRoueSecours']) {
                            # code...
                            echo "Le nombre total de roue de secours est atteint pour cette remorque";
                        }else{
                            $this->requeteMiseEnServicePneu1();
                            echo "yeuch";
                        }
                    }
                }elseif (count($getCamionBenne)>0) {
                    # code...
                    foreach ($getCamionBenne as $tab) {
                        # code...
                        if (count($verifSecours)>=$tab['nbreRoueSecours']) {
                            # code...
                            echo "Le nombre total de roue de secours est atteint pour ce camion bennne";
                        }else{
                            $this->requeteMiseEnServicePneu1();
                        }
                    }
                }
                
            }else{
                $this->requeteMiseEnServicePneu1();
                // echo "secour";
            }


        }else{
            $this->requeteMiseEnServicePneu1();
            // $nbrePneuImmatriculation = $this->db->query("SELECT * from pneu WHERE immatriculation = '".$immatriculation."' and service=1 and secours=0")->result_array();
            // if (count($nbrePneuImmatriculation)>0) {
            //     # code...
        
            //         if (count($getRemorque)>0) {
            //             # code...
            //             foreach ($getRemorque as $tab1) {
            //                 # code...
            //                 if (count($nbrePneuImmatriculation)>= $tab1['nbreRoue']) {
            //                     # code...
            //                     echo "Nombre de roue chaussée deja suffisant pour cette remorque ";
            //                 }else{
            //                     $this->requeteMiseEnServicePneu1();
            //                 }
            //             }
            //         }elseif (count($getTracteur)>0) {
            //             # code...
            //             foreach ($getTracteur as $tab2) {
            //                 # code...
            //                 if (count($nbrePneuImmatriculation)>= $tab2['nbreRoue']) {
            //                     # code...
            //                     echo "Nombre de roue chaussée deja suffisant pour ce tracteur ";
            //                 }else{
            //                     $this->requeteMiseEnServicePneu1();
            //                 }
            //             }
            //         }elseif (count($getCamionBenne)>0) {
            //             # code...

            //             foreach ($getCamionBenne as $tab3) {
            //                 # code...
            //                 if (count($nbrePneuImmatriculation)>= $tab3['nbreRoue']) {
            //                     # code...
            //                     echo "Nombre de roue chaussée deja suffisant pour ce camion benne ";
            //                 }else{
            //                     $this->requeteMiseEnServicePneu1();
            //                 }

            //             }
            //         }else{
            //          $this->requeteMiseEnServicePneu1();
            //              }
                

            // }else{
            //      $this->requeteMiseEnServicePneu1();
            //       }
           
        }
        

    }
    public function selectAllTypePneuPourSelection(){
        $typePneu = $this->db->query("select * from type_pneu")->result_array();

        if (count($typePneu) >0) {
            # code...
            foreach ($typePneu as $row) {
                # code...
                echo "<option value='".$row['id_type_pneu']."'>".$row["nom_type"]."</option>";
            }
            
        }
        $this->db->close();
    }


    public function getExpirationPneu(){
         $aujourdhui = date("Y/m/d");
    // $dJour = explode("/", $aujourdhui);
echo " <h2 style='text-align:center; text-decoration: underline; background: linear-gradient(to right, #6c6c6c 20%, #c1c1c8 42%, #38393c 85%); padding: 5px'>PNEUS</h2><br><div class='row'>";
    $query = $this->db->query("select * from pneu")->result_array();

    if (count($query)>0) {
        # code...
        foreach ($query as $row) {
            # code...
            $delai2 = date("Y/m/d",strtotime($row["date_exp"].'- 1 month'));
            // $dFin = explode("/", $delai2);
            // echo "Le délai est le :".$delai2;
            if ( $aujourdhui >= $delai2 && $aujourdhui < date("Y/m/d",strtotime($row["date_exp"].'- 1 days'))) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  <hr>
                  Le pneu N° '.$row["numero"].' appartenant au véhicule immatriculé '.$row["immatriculation"].', crée le '.date("d/m/Y",strtotime($row["date_crea"])).' va expirer le '.date("d/m/Y",strtotime($row["date_exp"])).'
                </div>
                </div>';
            }elseif ($aujourdhui >= date("Y/m/d",strtotime($row["date_exp"]))) {
                # code...
                // echo'<div class="col-md-3">
                //  <div class="alert alert-danger alert-dismissible">
                //   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                //   <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                //   <hr>
                //   Le pneu N° '.$row["numero"].' appartenant au véhicule immatriculé '.$row["immatriculation"].', crée le '.date("d/m/Y",strtotime($row["date_crea"])).' a déjà expiré!!
                // </div>
                // </div>';
            }
            else{
                // echo "pas encore ";
            }
        }
    }
    

    $this->countPneuParCamion();
    $this->countCamionSansPneu();
    echo "</div>";

    $this->db->close();
    }

    public function countPneuParCamion(){
        $getNbrePneuRemorque = $this->db->query("SELECT * from remorque where immatriculation in (select immatriculation from pneu where service=1)")->result_array();
        foreach ($getNbrePneuRemorque as $pneu) {
            # code...
            $occurence = $this->db->query("SELECT * from pneu where immatriculation ='".$pneu['immatriculation']."'")->result_array();
            if (count($occurence)< $pneu["nbreRoue"]) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  <hr>
        La remorque immatriculée '.$pneu["immatriculation"].' possède un nombre de roue chaussée insuffisant : '.count($occurence).' au lieu '.$pneu["nbreRoue"].'
                </div>
                </div>';
            }
        }

        $getNbrePneuTracteur = $this->db->query("SELECT * from tracteur where immatriculation in (select immatriculation from pneu where service=1)")->result_array();
        foreach ($getNbrePneuTracteur as $pneu) {
            # code...
            $occurence = $this->db->query("SELECT * from pneu where immatriculation ='".$pneu['immatriculation']."'")->result_array();
            if (count($occurence)< $pneu["nbreRoue"]) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  <hr>
                 Le tracteur immatriculée '.$pneu["immatriculation"].' possède un nombre de roue chaussée insuffisant : '.count($occurence).' au lieu '.$pneu["nbreRoue"].'
                </div>
                </div>';
            }
        }

        $getNbrePneuBenne = $this->db->query("SELECT * from camion_benne where immatriculation in (select immatriculation from pneu where service=1)")->result_array();
        foreach ($getNbrePneuBenne as $pneu) {
            # code...
            $occurence = $this->db->query("SELECT * from pneu where immatriculation ='".$pneu['immatriculation']."'")->result_array();
            if (count($occurence)< $pneu["nbreRoue"]) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  <hr>
                 Le camion benne immatriculée '.$pneu["immatriculation"].' possède un nombre de roue chaussée insuffisant : '.count($occurence).' au lieu '.$pneu["nbreRoue"].'
                </div>
                </div>';
            }
        }

        $this->db->close();
    }

       public function countCamionSansPneu(){
        $getNbrePneuRemorque = $this->db->query("SELECT * from remorque where immatriculation not in (select immatriculation from pneu where service=1)")->result_array();
        foreach ($getNbrePneuRemorque as $pneu) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  <hr>
        La remorque immatriculée '.$pneu["immatriculation"].' ne possède pas de roues chaussées 
                </div>
                </div>';

                $this->getNbrePneuSecoursParCamion("remorque",$pneu["immatriculation"]);
            
        }

        $getNbrePneuTracteur = $this->db->query("SELECT * from tracteur where immatriculation not in (select immatriculation from pneu where service=1)")->result_array();
        foreach ($getNbrePneuTracteur as $pneu) {
            # code...
            
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  <hr>
                 Le tracteur immatriculée '.$pneu["immatriculation"].' ne possède pas de roues chaussées
                </div>
                </div>';
            $this->getNbrePneuSecoursParCamion("tracteur",$pneu["immatriculation"]);
        }

        $getNbrePneuBenne = $this->db->query("SELECT * from camion_benne where immatriculation not in (select immatriculation from pneu where service=1)")->result_array();
        foreach ($getNbrePneuBenne as $pneu) {
            
                echo'<div class="col-md-3">
                 <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  <hr>
                 Le camion benne immatriculée '.$pneu["immatriculation"].' ne possède pas de roues chaussées 
                </div>
                </div>';
            $this->getNbrePneuSecoursParCamion("camion_benne",$pneu["immatriculation"]);
        }
        $this->db->close();
    }

    public function getNbrePneuSecoursParCamion($vehicule,$immatriculation){
        $getNbreSecours = $this->db->query("SELECT * from pneu where secours=1 and immatriculation='".$immatriculation."'")->result_array();
        if ($vehicule == "remorque") {
            # code...
            $getPneu = $this->db->query("SELECT * from remorque where immatriculation ='".$immatriculation."'")->row();

            if (count($getNbreSecours)<$getPneu->nbreRoueSecours) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  <hr>
                 La remorque immatriculée '.$immatriculation.' possède un nombre de roues de secours insuffisant : '.count($getNbreSecours).' au lieu de'.$getPneu->nbreRoueSecours.'
                </div>
                </div>';
            }

        }elseif ($vehicule == "tracteur") {
            # code...
             $getPneu = $this->db->query("SELECT * from tracteur where immatriculation ='".$immatriculation."'")->row();

            if (count($getNbreSecours)<$getPneu->nbreRoueSecours) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  <hr>
                 Le tracteur immatriculée '.$immatriculation.' possède un nombre de roues de secours insuffisant : '.count($getNbreSecours).' au lieu de'.$getPneu->nbreRoueSecours.'
                </div>
                </div>';
            }

        }elseif ($vehicule == "camion_benne") {
            # code...
             $getPneu = $this->db->query("SELECT * from camion_benne where immatriculation ='".$immatriculation."'")->row();

            if (count($getNbreSecours)<$getPneu->nbreRoueSecours) {
                # code...
                echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  <hr>
                 Le camion_benne immatriculée '.$immatriculation.' possède un nombre de roues de secours insuffisant : '.count($getNbreSecours).' au lieu de'.$getPneu->nbreRoueSecours.'
                </div>
                </div>';
            }
        }

        $this->db->close();
    }
    public function getVidangeTracteur(){

        $getCodeCamion = $this->db->query("SELECT * FROM tracteur")->result_array();

        if (count($getCodeCamion)>0) {
            # code...
            echo " <h2 style='text-align:center; text-decoration: underline; background: linear-gradient(to right, #6c6c6c 20%, #c1c1c8 42%, #38393c 85%); padding: 5px'>VIDANGE TRACTEUR</h2><br><div class='row'>";
            foreach ($getCodeCamion as $camion) {
                # code...
                // echo $camion['code'];
                if ($camion['type'] == 'Nouveau') {
                    # code...
                     $getDateLastVidange = $this->db->query("select * from vidange where code_camion='".$camion["code"]."' order by id_vidange desc limit 1")->row();
                if (count($getDateLastVidange) > 0) {
                    # code...
                    // echo $getDateLastVidange->date_vidange." code ".$getDateLastVidange->code_camion;
                    $getKilometrage1 = $this->db->query("select * from vidange where date_vidange >= '".$getDateLastVidange->date_vidange."' and code_camion ='".$camion["code"]."' order by date_vidange desc limit 1")->row();
                    $getKilometrage2 = $this->db->query("select * from gazoil where date_gazoil >= '".$getDateLastVidange->date_vidange."' and code_camion ='".$camion["code"]."' order by id_gazoil desc limit 1")->row();

                    if (count($getKilometrage2) >0 && count($getKilometrage1)>0) {
                        # code...
                        $kilometrage = $getKilometrage2->kilometrage-$getKilometrage1->dernier_kilometrage;
// echo "  c'est moi =  ".$getKilometrage2->kilometrage." - ".$getKilometrage1->dernier_kilometrage;
                    // echo strlen($kilometrage);

                    if (strlen($kilometrage) == 4 && $kilometrage > 7999 && $kilometrage < 9000) {
                        # code...
                        echo'<div class="col-md-3">
                 <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  <hr>
                  Le tracteur de code '.$camion["code"].', immatriculé '.$camion["immatriculation"].', dont la dernière vidange était le '.date("d/m/Y",strtotime($getDateLastVidange->date_vidange)).' nécessite encore une vidange.
                </div>
                </div>';
                    }elseif ($kilometrage>=9000) {
                        # code...
            echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  <hr>
                  Le tracteur de code '.$camion["code"].', immatriculé '.$camion["immatriculation"].', dont la dernière vidange était le '.date("d/m/Y",strtotime($getDateLastVidange->date_vidange)).' doit être vidangé d\'urgence.
                </div>
                </div>';
                    }else{
                      
                    }
                      // echo "tout va bien";
                    }else{
                        // echo "merde";
                    }
                }else{
                    // echo "moooooovaaaaiii";
                }
                }else{

                     $getDateLastVidange = $this->db->query("select * from vidange where code_camion='".$camion["code"]."' order by id_vidange desc limit 1")->row();
                if (count($getDateLastVidange) > 0) {
                    # code...
                    // echo $getDateLastVidange->date_vidange." code ".$getDateLastVidange->code_camion;
                   $getKilometrage1 = $this->db->query("select * from vidange where date_vidange >= '".$getDateLastVidange->date_vidange."' and code_camion ='".$camion["code"]."' order by date_vidange desc limit 1")->row();
                    $getKilometrage2 = $this->db->query("select * from gazoil where date_gazoil >= '".$getDateLastVidange->date_vidange."' and code_camion ='".$camion["code"]."' order by id_gazoil desc limit 1")->row();

                    if (count($getKilometrage2) >0 && count($getKilometrage1)>0) {
                        # code...
                        $kilometrage = $getKilometrage2->kilometrage-$getKilometrage1->dernier_kilometrage;
// echo "  c'est moi =  ".$getKilometrage2->kilometrage." - ".$getKilometrage1->kilometrage;
                    // echo strlen($kilometrage);

                    if (strlen($kilometrage) == 4 && $kilometrage > 8999 && $kilometrage < 10000) {
                        # code...
                        echo'<div class="col-md-3">
                 <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  <hr>
                  Le tracteur de code '.$camion["code"].', immatriculé '.$camion["immatriculation"].', dont la dernière vidange était le '.date("d/m/Y",strtotime($getDateLastVidange->date_vidange)).' nécessite encore une vidange.
                </div>
                </div>';
                    }elseif ($kilometrage>=10000) {
                        # code...
            echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  <hr>
                  Le tracteur de code '.$camion["code"].', immatriculé '.$camion["immatriculation"].', dont la dernière vidange était le '.date("d/m/Y",strtotime($getDateLastVidange->date_vidange)).' doit être vidangé d\'urgence.
                </div>
                </div>';
                    }else{
                      
                    }
                      // echo "tout va bien";
                    }else{
                        // echo "merde";
                    }
                }else{
                    // echo "moooooovaaaaiii";
                }
                }
               
                   
                
            }
               echo "</div>";
        }
        $this->db->close();

    }


    public function getVidangeCamionBenne(){

        $getCodeCamion = $this->db->query("SELECT * FROM camion_benne")->result_array();

        if (count($getCodeCamion)>0) {
            # code...
            echo " <h2 style='text-align:center; text-decoration: underline; background: linear-gradient(to right, #6c6c6c 20%, #c1c1c8 42%, #38393c 85%); padding: 5px'>VIDANGE CAMION BENNE</h2><br><div class='row'>";
            foreach ($getCodeCamion as $camion) {
                # code...
                // echo $camion['code'];
                $getDateLastVidange = $this->db->query("select * from vidange where code_camion='".$camion["code"]."' order by id_vidange desc limit 1")->row();
                if (count($getDateLastVidange) > 0) {
                    # code...
                    // echo $getDateLastVidange->date_vidange." code ".$getDateLastVidange->code_camion;
                    $getKilometrage1 = $this->db->query("select * from vidange where date_vidange >= '".$getDateLastVidange->date_vidange."' and code_camion ='".$camion["code"]."' order by date_vidange desc limit 1")->row();
                    $getKilometrage2 = $this->db->query("select * from gazoil where date_gazoil >= '".$getDateLastVidange->date_vidange."' and code_camion ='".$camion["code"]."' order by id_gazoil desc limit 1")->row();

                    if (count($getKilometrage2) >0 && count($getKilometrage1)>0) {
                        # code...
                        $kilometrage = $getKilometrage2->kilometrage-$getKilometrage1->dernier_kilometrage;
// echo "  c'est moi =  ".$getKilometrage2->kilometrage." - ".$getKilometrage1->dernier_kilometrage;
//                     echo " __".$kilometrage." ".$camion['code'];

                    if (strlen($kilometrage) == 4 && $kilometrage > 8999 && $kilometrage < 10000) {
                        # code...
                        echo'<div class="col-md-3">
                 <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  <hr>
                  Le camion benne de code '.$camion["code"].', immatriculé '.$camion["immatriculation"].', dont la dernière vidange était le '.date("d/m/Y",strtotime($getDateLastVidange->date_vidange)).' nécessite encore une vidange.
                </div>
                </div>';
                    }elseif ($kilometrage>=10000) {
                        # code...
            echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  <hr>
                  Le camion benne de code '.$camion["code"].', immatriculé '.$camion["immatriculation"].', dont la dernière vidange était le '.date("d/m/Y",strtotime($getDateLastVidange->date_vidange)).' doit être vidangé d\'urgence.
                </div>
                </div>';
                    }else{
                      
                    }
                      // echo "tout va bien";
                    }else{
                        // echo "merde";
                    }
                }else{
                    // echo "moooooovaaaaiii";
                }
                   
                
            }
               echo "</div>";
        }

        $this->db->close();

    }

public function getBoite(){

        $getCodeCamion = $this->db->query("SELECT * FROM camion_benne")->result_array();
        $getTracteur = $this->db->query("SELECT * FROM tracteur")->result_array();
        $getEngin = $this->db->query("SELECT * FROM engin")->result_array();
        echo " <h2 style='text-align:center; text-decoration: underline; background: linear-gradient(to right, #6c6c6c 20%, #c1c1c8 42%, #38393c 85%); padding: 5px'>VIDANGE BOITE</h2><br><div class='row'>";
        if (count($getCodeCamion)>0) {
            # code...
            
            foreach ($getCodeCamion as $camion) {
                # code...
                // echo $camion['code'];
                $getDateLastVidange = $this->db->query("select * from vidangeboite where code_camion='".$camion["code"]."' order by id_vidange desc limit 1")->row();
                if (count($getDateLastVidange) > 0) {
                    # code...
                    // echo $getDateLastVidange->date_vidange." code ".$getDateLastVidange->code_camion;
                    $getKilometrage1 = $this->db->query("select max(kilometrage) as kilometrage from gazoil where date_gazoil <= '".$getDateLastVidange->date_vidange."' and code_camion ='".$camion["code"]."' order by date_gazoil desc limit 1")->row();
                    $getKilometrage2 = $this->db->query("select * from gazoil where date_gazoil >= '".$getDateLastVidange->date_vidange."' and code_camion ='".$camion["code"]."' order by id_gazoil desc limit 1")->row();

                    if (count($getKilometrage2) >0 && count($getKilometrage1)>0) {
                        # code...
                        $kilometrage = $getKilometrage2->kilometrage-$getKilometrage1->kilometrage;
// echo "  c'est moi =  ".$getKilometrage2->kilometrage." - ".$getKilometrage1->dernier_kilometrage;
//                     echo " __".$kilometrage." ".$camion['code'];

                    if (strlen($kilometrage) == 4 && $kilometrage > 48999 && $kilometrage < 50000) {
                        # code...
                        echo'<div class="col-md-3">
                 <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  <hr>
                  La boite de vitesse du camion benne de code '.$camion["code"].', immatriculé '.$camion["immatriculation"].', dont la dernière vidange était le '.date("d/m/Y",strtotime($getDateLastVidange->date_vidange)).' nécessite encore une vidange.
                </div>
                </div>';
                    }elseif ($kilometrage>=50000 && $kilometrage<60000) {
                        # code...
            echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  <hr>
                  La boite de vitesse du camion benne de code '.$camion["code"].', immatriculé '.$camion["immatriculation"].', dont la dernière vidange était le '.date("d/m/Y",strtotime($getDateLastVidange->date_vidange)).' doit être vidangé d\'urgence.
                </div>
                </div>';
                    }else{
                      
                    }
                      // echo "tout va bien";
                    }else{
                        // echo "merde";
                    }
                }else{
                    // echo "moooooovaaaaiii";
                }
                   
                
            }
               
        }

    if (count($getTracteur)>0) {
            # code...
            foreach ($getTracteur as $camion) {
                # code...
                // echo $camion['code'];
                $getDateLastVidange = $this->db->query("select * from vidangeboite where code_camion='".$camion["code"]."' order by id_vidange desc limit 1")->row();
                if (count($getDateLastVidange) > 0) {
                    # code...
                    // echo $getDateLastVidange->date_vidange." code ".$getDateLastVidange->code_camion;
                    $getKilometrage1 = $this->db->query("select max(kilometrage) as kilometrage  from gazoil where date_gazoil <= '".$getDateLastVidange->date_vidange."' and code_camion ='".$camion["code"]."' order by date_gazoil desc limit 1")->row();
                    $getKilometrage2 = $this->db->query("select * from gazoil where date_gazoil >= '".$getDateLastVidange->date_vidange."' and code_camion ='".$camion["code"]."' order by id_gazoil desc limit 1")->row();

                    if (count($getKilometrage2) >0 && count($getKilometrage1)>0) {
                        # code...
                        $kilometrage = $getKilometrage2->kilometrage-$getKilometrage1->kilometrage;
// echo "  c'est moi =  ".$getKilometrage2->kilometrage." - ".$getKilometrage1->dernier_kilometrage;
//                     echo " __".$kilometrage." ".$camion['code'];

                    if (strlen($kilometrage) == 4 && $kilometrage > 48999 && $kilometrage < 50000) {
                        # code...
                        echo'<div class="col-md-3">
                 <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  <hr>
                  La boite de vitesse du tracteur de code '.$camion["code"].', immatriculé '.$camion["immatriculation"].', dont la dernière vidange était le '.date("d/m/Y",strtotime($getDateLastVidange->date_vidange)).' nécessite encore une vidange.
                </div>
                </div>';
                    }elseif ($kilometrage>=50000 && $kilometrage<60000) {
                        # code...
            echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  <hr>
                  La boite de vitesse du tracteur de code '.$camion["code"].', immatriculé '.$camion["immatriculation"].', dont la dernière vidange était le '.date("d/m/Y",strtotime($getDateLastVidange->date_vidange)).' doit être vidangé d\'urgence.
                </div>
                </div>';
                    }else{
                      
                    }
                      // echo "tout va bien";
                    }else{
                        // echo "merde";
                    }
                }else{
                    // echo "moooooovaaaaiii";
                }
                   
                
            }
               
        }

        if (count($getEngin)>0) {
            # code...
            foreach ($getEngin as $camion) {
                # code...
                // echo $camion['code'];
                $getDateLastVidange = $this->db->query("select * from vidangeboite where code_camion='".$camion["code"]."' order by id_vidange desc limit 1")->row();
                if (count($getDateLastVidange) > 0) {
                    # code...
                    // echo $getDateLastVidange->date_vidange." code ".$getDateLastVidange->code_camion;
                    $getKilometrage1 = $this->db->query("select max(kilometrage) as kilometrage  from gazoil where date_gazoil <= '".$getDateLastVidange->date_vidange."' and code_camion ='".$camion["code"]."' order by date_gazoil desc limit 1")->row();
                    $getKilometrage2 = $this->db->query("select * from gazoil where date_gazoil >= '".$getDateLastVidange->date_vidange."' and code_camion ='".$camion["code"]."' order by id_gazoil desc limit 1")->row();

                    if (count($getKilometrage2) >0 && count($getKilometrage1)>0) {
                        # code...
                        $kilometrage = $getKilometrage2->kilometrage-$getKilometrage1->kilometrage;
// echo "  c'est moi =  ".$getKilometrage2->kilometrage." - ".$getKilometrage1->dernier_kilometrage;
//                     echo " __".$kilometrage." ".$camion['code'];

                    if (strlen($kilometrage) == 4 && $kilometrage > 48999 && $kilometrage < 50000) {
                        # code...
                        echo'<div class="col-md-3">
                 <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  <hr>
                  La boite de vitesse de l\'engin de code '.$camion["code"].', immatriculé '.$camion["immatriculation"].', dont la dernière vidange était le '.date("d/m/Y",strtotime($getDateLastVidange->date_vidange)).' nécessite encore une vidange.
                </div>
                </div>';
                    }elseif ($kilometrage>=50000 && $kilometrage<60000) {
                        # code...
            echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  <hr>
                  La boite de vitesse de l\'engin de code '.$camion["code"].', immatriculé '.$camion["immatriculation"].', dont la dernière vidange était le '.date("d/m/Y",strtotime($getDateLastVidange->date_vidange)).' doit être vidangé d\'urgence.
                </div>
                </div>';
                    }else{
                      
                    }
                      // echo "tout va bien";
                    }else{
                        // echo "merde";
                    }
                }else{
                    // echo "moooooovaaaaiii";
                }
                   
                
            }
               echo "</div>";
        }
        $this->db->close();
    }


public function getVidangeEngin(){
$date = date("Y/m/d");
        $getCodeCamion = $this->db->query("SELECT * FROM engin")->result_array();

        if (count($getCodeCamion)>0) {
            # code...
            echo " <h2 style='text-align:center; text-decoration: underline; background: linear-gradient(to right, #6c6c6c 20%, #c1c1c8 42%, #38393c 85%); padding: 5px'>VIDANGE ENGIN</h2><br><div class='row'>";
            foreach ($getCodeCamion as $camion) {
                # code...
                // echo $camion['code'];
                $getDateLastVidange = $this->db->query("select * from vidange where code_camion='".$camion["code"]."' order by id_vidange desc limit 1")->row();
                if (count($getDateLastVidange) > 0) {
                    # code...
                    // echo $getDateLastVidange->date_vidange." code ".$getDateLastVidange->code_camion;
                    $getKilometrage1 = $this->db->query("select * from vidange where date_vidange >= '".$getDateLastVidange->date_vidange."' and code_camion ='".$camion["code"]."' order by date_vidange desc limit 1")->row();
                    $getKilometrage2 = $this->db->query("select * from gazoil where date_gazoil >= '".$getDateLastVidange->date_vidange."' and code_camion ='".$camion["code"]."' order by id_gazoil desc limit 1")->row();

                    if (count($getKilometrage2) >0 && count($getKilometrage1)>0) {
                        # code...
                        $kilometrage = $getKilometrage2->kilometrage-$getKilometrage1->dernier_kilometrage;
// echo "  c'est moi =  ".$getKilometrage2->kilometrage." - ".$getKilometrage1->dernier_kilometrage;
//                     echo " __".$kilometrage." ".$camion['code'];
                        $delai2 = date("Y/m/d",strtotime($getKilometrage1->date_vidange.'+ 1 month'));

                        $delai1 = date("Y/m/d",strtotime($delai2.'- 20 days'));
                    if ($date >=$delai1 && $date<$delai2) {
                        # code...
                        echo'<div class="col-md-3">
                 <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Warning!</h5>
                  <hr>
                  L\'engin de code '.$camion["code"].', immatriculé '.$camion["immatriculation"].', dont la dernière vidange était le '.date("d/m/Y",strtotime($getDateLastVidange->date_vidange)).' nécessite encore une vidange.
                </div>
                </div>';
                    }elseif ($date >=$delai2) {
                        # code...
            echo'<div class="col-md-3">
                 <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                  <hr>
                  L\'engin de code '.$camion["code"].', immatriculé '.$camion["immatriculation"].', dont la dernière vidange était le '.date("d/m/Y",strtotime($getDateLastVidange->date_vidange)).' doit être vidangé d\'urgence.
                </div>
                </div>';
                    }else{
                      
                    }
                      // echo "tout va bien";
                    }else{
                        // echo "merde";
                    }
                }else{
                    // echo "moooooovaaaaiii";
                }
                   
                
            }
               echo "</div>";
        }
        $this->db->close();

    }

    public function countCamionBenne(){

    }
    public function countTracteur(){

    }

    public function countProfil(){
        
    }

    public function deleteTypePneu($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé le type de pneu ".$getCamion->nom_type." le ".$date_notif." à ".$heure;


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

    public function deletePenu($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé le pneu numéro ".$getCamion->numero.", pour le véhicule de code ".$getCamion->code_camion." et de montant ".$getCamion->montant." le ".$date_notif." à ".$heure;


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
	
	    public function getUniqueNotificationParTemps(){
  $id = $_POST['id'];
  $heure_debut = date("H:i:s",strtotime('now -12 Seconds'));
  $heure_fin = date("H:i:s");
  $query = $this->db->query("SELECT * from notification2 where ref=".$id." and heure_notif between '".$heure_debut."' and '".$heure_fin."'")->result_array();

  if (count($query) >0) {
    # code...
    $delai = 5750;
    foreach ($query as $row) {
      # code...
      if ($this->getVueNotification($row['ref']) == 0 || $this->getVueNotification($row['ref']) =='') {
        # code...
        echo addslashes($row['message'])." <br> <input type=\"button\" class=\"button\" value=\"Ne plus afficher\" aria-label=\"Close\" data-dismiss=\"toast\" onclick='nePlusAfficher(".$row['ref'].");' class=\" btn-primary btn-sm\">";
       
      }
    }
  }
}

public function getVueNotification($ref){
  $query = $this->db->query("SELECT * from vue_notification where ref_notif = ".$ref." and id_profil =".$this->session->userdata('id_profil')."")->row();
  $vue = 0;
  if (count($query)>0) {
    # code...
    $vue = $query->vue;
  }else {
    # code...
    $vue = 0;
  }

  return $vue;
}


public function getNbreNewNotification(){
  $query = $this->db->query("SELECT * from notification2")->result_array();
  $id = "";
  if (count($query) >0) {
    # code...

    foreach ($query as $row) {
      # code...
      if ($this->getVueNotification($row['ref']) == 0 || $this->getVueNotification($row['ref']) =='') {
        # code...
        if ($id == "") {
          # code...
          $id = $id.$row['ref'];
        }else{
          $id = $id.",".$row['ref'];
        }
        
      }
    }
  }


  return $id;
}

public function getUniqueNotification(){
  $id = $_POST['id'];

  if ($id !="" && $id !=" ") {
    # code...
  
  $query = $this->db->query("SELECT * from notification2 where ref=".$id."")->result_array();

  if (count($query) >0) {
    # code...
    $delai = 5750;
    foreach ($query as $row) {
      # code...
      if ($this->getVueNotification($row['ref']) == 0 || $this->getVueNotification($row['ref']) =='') {
        # code...
        echo addslashes($row['message'])." <br> <input type=\"button\" class=\"button\" value=\"Ne plus afficher\" aria-label=\"Close\" data-dismiss=\"toast\" onclick='nePlusAfficher(".$row['ref'].");' class=\" btn-primary btn-sm\">";
       
      }
    }
  }
}
}

// notification toute les 5s

public function getNbreNewNotificationParTemps(){
  $heure_debut = date("H:i:s",strtotime('now -3 Hours'));
  $heure_fin = date("H:i:s");
  $query = $this->db->query("SELECT * from notification2 where heure_notif between '".$heure_debut."' and '".$heure_fin."'")->result_array();
  $id = "1";
  if (count($query) >0) {
    # code...

    foreach ($query as $row) {
      # code...
      if ($this->getVueNotification($row['ref']) == 0 || $this->getVueNotification($row['ref']) =='') {
        # code...
        if ($id == "") {
          # code...
          $id = $id.$row['ref'];
        }else{
          $id = $id.",".$row['ref'];
        }
        
      }
    }
  }
  

  return $id;
}

public function nePlusAfficher(){
     
     $ref = $_POST['ref'];
     $req = $this->db->query("INSERT into vue_notification value ('',".$ref.",".$this->session->userdata('id_profil').",1,now())");

     if ($req == true) {
       # code...
      echo "ok";
     }else{
      echo "Erreur contactez l'administrateur";
     }
  }
  
}
?>