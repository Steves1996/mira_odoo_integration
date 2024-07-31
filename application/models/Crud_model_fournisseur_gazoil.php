<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model_fournisseur_gazoil extends CI_Model {
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
    public function addFournisseurGazoil(){
        $PU = preg_replace('/\s/','', $_POST["PU"]);
        $solde = preg_replace('/\s/','', $_POST["solde"]);
        $nom = $_POST["nom"];
        $date = $_POST["date_fournisseur"];
        $telephone = $_POST["telephone"];
        $adresse = $_POST["adresse"];
        $status = $_POST["status"];


        $nom_table = "fournisseur_gazoil";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté un fournisseur gasoil de nom ".$nom.", de téléphone ".$telephone.", et de solde ".$solde." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié un fournisseur gasoil de nom ".$nom.", de téléphone ".$telephone.", et de solde ".$solde." le ".$date_notif." à ".$heure;
    
        if ($status =="insert") {
            # code...

                $requete = $this->db->query("SELECT * from fournisseur_gazoil where telephone =".$telephone."")->result_array();
                if (count($requete)>0) {
                    # code...
                    echo "Ce numéro de téléphone est déjà utilisé veuillez changer";
                }else{
                    $query1 = $this->db->query("insert into fournisseur_gazoil value('','". $nom. "','".$adresse."',". $telephone.",".$PU.",".$solde.",CAST('". $date."' AS DATE))");
                            if($query1 == true){
                                echo "Insertion parfaite du fournisseur";
                                $this->notificationAjout($nom_table,addslashes($message));
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                }
        }elseif ($status == "update") {
            # code...
            $id_client =$_POST["id_client"];
                $requete = $this->db->query("SELECT * from fournisseur_gazoil where telephone =".$telephone."")->result_array();
                if (count($requete)>0) {
                    # code...
                   foreach ($requete as $row) {
                       # code...
                        if ($row["id_fournisseur"] == $id_client) {
                            # code...
                            $query1 = $this->db->query("UPDATE fournisseur_gazoil set telephone=".$telephone.", adresse='".$adresse."', nom='".$nom."',PU=".$PU.",date_fournisseur=CAST('".$date."' AS DATE),solde = ".$solde." where id_fournisseur =".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du fournisseur";
                                $this->notificationAjout($nom_table,addslashes($message2));
                                $query2 = $this->db->query("SELECT * from gazoil where id_fournisseur =".$id_client." and date_fournisseur >= CAST('".$date."' AS DATE)  ")->row();
                                if (count($query2)>0) {
                                        # code...
                                    $this->db->query("UPDATE gazoil set prix_unitaire = ".$PU." where id_fournisseur =".$id_client." and date_gazoil >= CAST('".$date."' AS DATE)");
                                    }    
                                  }else{
                                echo "Erreur durant la Modification";
                            }
                        }else{
                            echo "Erreur ce numero de téléphone est déjà utilisé";
                        }
                   }
                }else{
                    $query1 = $this->db->query("UPDATE fournisseur_gazoil set telephone=".$telephone.", adresse='".$adresse."', nom='".$nom."',PU=".$PU.",date_fournisseur=CAST('".$date."' AS DATE),solde = ".$solde." where id_fournisseur=".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du fournisseur";
                                $this->notificationAjout($nom_table,addslashes($message2));
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                }
        }else{
            echo "Erreur contactez l'administrateur";
        }

        $this->db->close();
        
    }

    public function selectAllFournisseurGazoil(){
              $query1 = $this->db->get_where('fournisseur_gazoil')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['nom']."
                    </td>
                    <td>".$row['adresse']."</td>
                    <td> ".$row['telephone']."</td>
                    <td> ".$row['PU']."</td>
					<td> ".$row['date_fournisseur']."</td>
					 <td> ".$row['solde']."</td>
                    
                    <td>";

            if($this->session->userdata('gazoil_modification')=='true'){
                    echo"<button type='button' onclick=\"infosClient('".$row['id_fournisseur']."','".$row['nom']."','".$row['adresse']."','".$row['telephone']."','".$row['PU']."','".number_format($row['solde'],0,',',' ')."','".$row['date_fournisseur']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }

            if($this->session->userdata('gazoil_suppression')=='true'){
                echo"
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='fournisseur_gazoil' identifiant='".$row['id_fournisseur']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_fournisseur\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
        }
        $this->db->close();
    }

public function deleteFournisseurGasoil($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé le fournisseur de gasoil ".$getCamion->nom." de téléphone ".$getCamion->telephone." le ".$date_notif." à ".$heure;


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