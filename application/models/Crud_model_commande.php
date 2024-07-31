<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model_commande extends CI_Model {
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

 public function leSelectCodeCamion(){
        $query = $this->db->query("SELECT * from tracteur order by code asc")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["code"]."' id_type = '".$row["id_type_camion"]."'>".$row["code"]."</option>";
            }
        }else{
            
        }
        $query1 = $this->db->query("SELECT * from camion_benne order by code asc")->result_array();
        if (count($query1) >0) {
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
         $query1 = $this->db->query("SELECT * from engin order by code asc")->result_array();
        if (count($query1) >0) {
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }

        $this->db->close();
    }


public function updateReferenceArticle(){
  $query  = $this->db->query("UPDATE article set reference = '".$reference."' where id_article=".$id_article."");

  $this->db->close();
}

public function getNbreLigne(){
    $nbreLignes = $_POST["nbreLignes"];
    $i=1;
    while ( $i<= $nbreLignes) {
  echo '<div class="row">
       <div class="col-md-2">
       <div class="form-group">
       <label>Article</label>
        <select class="article'.$i.' form-control" onchange="getPrixUnitaireArticle($(\'.article'.$i.'\').val(),\'pu'.$i.'\');getReferenceArticle($(\'.article'.$i.'\').val(),\'description'.$i.'\');">
         <option value=""></option>';
        $this->crud_model_depense->leSelectArticle();
        echo '</select></div>
          </div>
          <div class="col-md-2">
          <label>Quantité</label>
          <input type="text" class="form-control qtite_com'.$i.'" placeholder=" " onkeypress="chiffres(event);" >
         </div>
         <div class="col-md-2">
            <label>Prix unitaire</label>
            <input type="text" class="form-control pu'.$i.'" placeholder=" en FCFA" disabled="true" onkeypress="chiffres(event);">
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Camion</label>
                <select class="camion'.$i.' camion form-control">';
                     $this->crud_model_depense->leSelectEtatCodeCamion();
        echo'</select>
            </div></div>
            <div class="col-md-2">
                <div class="form-group ">
                    <label>Référence</label>
                    <input type="text" class="form-control description'.$i.'" />
                </div></div>
                <input type="hidden" class="form-control id_commande'.$i.'"  placeholder=" en FCFA" disabled="true" onkeypress="chiffres(event);">

                <div class="col-md-2">
       <div class="form-group">
       <label>Type</label>
        <select class="type'.$i.' form-control" onchange="activePrix(\'.type'.$i.'\',\'.pu'.$i.'\');">
        <option>interne</option>
        <option>externe</option>
         
         
         </select></div>
          </div>
            </div>
       <hr>';
       $i++;
    
    }

    $this->db->close();
}

public function getListeCommandePourModif(){
    $po = $_POST["po"];
    $getAllCommande = $this->db->query("SELECT * from commande where po_com = '".$po."'")->result_array();
    $i=1;
    foreach ($getAllCommande as $com) {
        # code...
  
   
  echo '<div class="row">
       <div class="col-md-2">
       <div class="form-group">
       <label>Article</label>
        <select class="article'.$i.' form-control" onchange="getPrixUnitaireArticle($(\'.article'.$i.'\').val(),\'pu'.$i.'\');getReferenceArticle($(\'.article'.$i.'\').val(),\'description'.$i.'\');">
        ';
         $getArticle = $this->db->query("SELECT * from article where id_article = ".$com['id_article']."")->row();
         echo "<option value='".$com['id_article']."'>".$getArticle->article."</option>";
        $this->crud_model_depense->leSelectArticle();
        echo '</select></div>
          </div>
          <div class="col-md-2">
          <label>Quantité</label>
          <input type="text" class="form-control qtite_com'.$i.'" placeholder=" " value="'.$com["qtite_com"].'" onkeypress="chiffres(event);" >
         </div>
         <div class="col-md-2">
            <label>Prix unitaire</label>
            <input type="text" class="form-control pu'.$i.'" placeholder=" en FCFA" value="'.$com["pu"].'" disabled="true" onkeypress="chiffres(event);">
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Camion</label>
                <select class="camion'.$i.' camion form-control">';
                echo "<option value=".$com["code_camion"].">".$com["code_camion"]."</option>";
                     $this->crud_model_depense->leSelectCodeCamion();
        echo'</select>
            </div></div>
            <div class="col-md-2">
                <div class="form-group ">
                    <label>Référence</label>
                    <input type="text" class="form-control description'.$i.'" value="'.addslashes($com["description"]).' ">
                </div></div>
                <input type="hidden" class="form-control id_commande'.$i.'"  placeholder=" en FCFA" value="'.$com["id_commande"].'" disabled="true" onkeypress="chiffres(event);">

                <div class="col-md-2">
       <div class="form-group">
       <label>Type</label>
        <select class="type'.$i.' form-control" onchange="activePrix(\'.type'.$i.'\',\'.pu'.$i.'\');">';
         if ($com['type'] == 'interne') {
           # code...
          echo '<option>interne</option>
         <option>externe</option>';
         }else{
          echo '
          <option>interne</option>
          <option>externe</option>
          
         ';
         }
         echo '
         </select></div>
          </div>
            </div>
       <hr>';
       $i++;
      }
      $i = $i-1;
      echo '<input type="hidden" class="form-control compteur"  placeholder=" en FCFA" value="'.$i.'" disabled="true" onkeypress="chiffres(event);">';

      $this->db->close();
}

function genererChaineAleatoire()
{
    $longueur = 6;
 $caracteres = '0123456789';
 $longueurMax = strlen($caracteres);
 $chaineAleatoire = 'OR';
 for ($i = 0; $i < $longueur; $i++)
 {
 $chaineAleatoire .= $caracteres[rand(0, $longueurMax - 1)];

 }
 return $chaineAleatoire;

 $this->db->close();
}

function codeAleatoire(){

}



public function addCommande(){
    //Entete de la commande
    $id_fournisseur = $_POST['id_fournisseur'];
    $date_creation = $_POST['date_creation'];
    $date_com = $_POST['date_commande'];
    $po = $_POST['po'];
    $etat_reception = $_POST['etat_reception'];
    $etat_expedition = $_POST['etat_expedition'];
    // detail de la commande
    $nbreLignes = $_POST["nbreLignes"];

    $article = json_decode($_POST['article']);
    $quantite = json_decode($_POST['quantite']);
    $pu = json_decode($_POST['pu']);
    $camion = json_decode($_POST['camion']);
    $description = json_decode($_POST['description']);
    $id_commande = json_decode($_POST['id_commande']);
    $type = json_decode($_POST['type']);
    $status = $_POST["status"];

    $nom_table = "commande";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté la commande N° ".$po." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié la commande N° ".$po." le ".$date_notif." à ".$heure;


    if ($status == "insert") {
        # code...
   
    $i = 1;

    while ( $i<= $nbreLignes) {
      // echo "test ".$i." ".$article[$i]." ".$quantite[$i]." ".$pu[$i]." ".$camion[$i]." ".$description[$i]; 

      $query = $this->db->query(" INSERT into commande value('','".$po."',".$id_fournisseur.",CAST('". $date_creation."' AS DATE),CAST('". $date_com."' AS DATE),'".$etat_reception."','".$etat_expedition."',".$article[$i].",".$quantite[$i].",".intval(preg_replace('/\s/','', $pu[$i])).",'".$camion[$i]."','".addslashes($description[$i])."','".$type[$i]."')");

     $query2 = $this->db->query("UPDATE article set code_a_barre = '".addslashes($description[$i])."' where id_article=".$article[$i]."");
      $i++; 
    }

        if ($query == true) {
            # code...
            echo "Insertion parfaite de la commande";
            $this->notificationAjout($nom_table,addslashes($message));
            
        }else{
            echo "erreur lors de l'insertion";
        }

    }elseif ($status == "update") {
        # code...
         $i = 1;
        while ( $i<= $nbreLignes) {
      // echo "test ".$i." ".$article[$i]." ".$quantite[$i]." ".$pu[$i]." ".$camion[$i]." ".$description[$i]; 

      $query = $this->db->query(" UPDATE commande set  date_crea = CAST('". $date_creation."' AS DATE),id_fournisseur_article=".$id_fournisseur.", date_com = CAST('". $date_com."' AS DATE), etat_recep ='".$etat_reception."', etat_exp ='".$etat_expedition."', id_article =".$article[$i].", qtite_com =".$quantite[$i].", pu =".intval(preg_replace('/\s/','', $pu[$i])).", code_camion ='".$camion[$i]."',description = '".addslashes($description[$i])."', type='".$type[$i]."' where id_commande =".$id_commande[$i]."");
      $query2 = $this->db->query("UPDATE article set code_a_barre = '".addslashes($description[$i])."' where id_article=".$article[$i]."");
      $i++; 
    }

        if ($query == true) {
            # code...
            echo "Modification parfaite de la commande";

            $this->notificationAjout($nom_table,addslashes($message2));

        }else{
            echo "erreur lors de l'insertion";
        }

    }else{
        echo "Erreur fatale contactez l'administrateur";
    }

$this->db->close();
}

public function getMontantCommande($po){
    $query1 = $this->db->query('SELECT * from commande where po_com = "'.$po.'"')->result_array();
    $total = 0;

    foreach ($query1 as $row) {
        # code...
        $total1 = $row["pu"]*$row["qtite_com"];
        $total = $total + $total1;
    }
    return $total;

    $this->db->close();
}

public function getMontantCommandeCimenterie($po){
    $query1 = $this->db->query('SELECT * from commandecimenterie where po_com = "'.$po.'"')->result_array();
    $total = 0;

    foreach ($query1 as $row) {
        # code...
        $total1 = $row["pu"]*$row["qtite_com"];
        $total = $total + $total1;
    }
    return $total;

    $this->db->close();
}

public function selectAllCommande(){
	
   $date = date('Y-m-d');
   
  
	if (isset($_POST["date_debut"]) && isset($_POST["date_fin"]) && isset($_POST["id_fournisseur1"])) {
            # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $id_fournisseur1 = $_POST['id_fournisseur1'];
        


		if (!empty($date_fin) && !empty($date_debut) && isset($_POST["id_fournisseur1"])) {

     //       $query1 = $this->db->query("SELECT distinct po_com,id_fournisseur_article,date_com,date_crea,etat_exp,etat_recep,id_commande,id_article,code_camion,description from commande where id_fournisseur_article = ".$id_fournisseur1." and date_com between '".$date_debut."' and '".$date_fin."'  group by po_com ORDER BY date_com DESC ")->result_array();
        
		if ($id_fournisseur1 == 'TOUT') {
            # code...
         $query1 = $this->db->query("SELECT  po_com,id_fournisseur_article,date_com,date_crea,etat_exp,etat_recep,id_commande,id_article,pu,qtite_com,code_camion,description from commande where date_com between '".$date_debut."' and '".$date_fin."' ORDER BY  po_com , date_com DESC")->result_array();
        
		}else {
			
		  $query1 = $this->db->query("SELECT  po_com,id_fournisseur_article,date_com,date_crea,etat_exp,etat_recep,id_commande,id_article,pu,qtite_com,code_camion,description from commande where id_fournisseur_article = ".$id_fournisseur1." and date_com between '".$date_debut."' and '".$date_fin."'  ORDER BY po_com , date_com DESC ")->result_array();
			
		}	
		
		}else{
			
			$query1 = $this->db->query("SELECT  po_com,id_fournisseur_article,date_com,date_crea,etat_exp,etat_recep,id_commande,id_article,pu,qtite_com,code_camion,description from commande where date_com = '".$date."' ORDER BY  po_com DESC")->result_array();    
        }		
		  
		}else{
			
			$query1 = $this->db->query("SELECT  po_com,id_fournisseur_article,date_com,date_crea,etat_exp,etat_recep,id_commande,id_article,pu,qtite_com,code_camion,description from commande where date_com = '".$date."' ORDER BY  po_com DESC")->result_array();    
        }			
		
		if (count($query1) >0 ) {
            # code...
            $compteur = 0;
			foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    
                    <td>".$row['po_com']."</td>";

                    $getfournisseur = $this->db->query("SELECT * FROM fournisseur_article where id_fournisseur = ".$row['id_fournisseur_article']."")->row();

                            echo"<td>".$getfournisseur->nom."</td>";
                    $getArticle = $this->db->query("SELECT * FROM article where id_article = ".$row['id_article']."")->row();

                            echo"<td>".$row['description']."</td>
							<td>".$getArticle->article."</td>"; 
                    
                    echo"

                    <td>".$row['date_com']."</td>
                    <td>".$row['date_crea']."</td>
                    <td>".$row['code_camion']."</td>
					<td>".$row['qtite_com']."</td>
                    <td>".$row['pu']."</td>
					<td>".number_format($row['qtite_com']*$row['pu'],0,',',' ')."</td>
                    <td>";
                if($this->session->userdata('commande_modification')=='true'){
                   echo" <button type='button' onclick='getDetailCommandePourModification(\"".$row['id_fournisseur_article']."\",\"".$row['date_crea']."\",\"".$row['date_com']."\",\"".$row['po_com']."\",\"".$row['etat_recep']."\",\"".$row['etat_exp']."\")'  class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                 }

                
                  echo"  <button type='button'   class=' btn-primary btn-sm' onclick='detailCommande(\"".$row['po_com']."\",\"".$getfournisseur->nom."\",\"".$row['date_com']."\",\"".$row['date_crea']."\",\"".$row['etat_exp']."\",\"".$row['etat_recep']."\",\"".number_format($this->getMontantCommande($row['po_com']),0,',',' ')." FCFA\")'><i class='nav-icon '>+</i></button>";

                if($this->session->userdata('commande_suppression')=='true'){
                  echo"  <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='commande' identifiant='".$row['po_com']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"po_com\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
			}
		
		}

        $this->db->close();
    }

public function getDetailCommande(){
    $po = $_POST["po"];
         $query1 = $this->db->query('SELECT * from commande where po_com ="'.$po.'" order by date_com desc')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr style='border:none; text-align:center;font-size: 16px;padding:0px;'>
                    

                    <td style='border:none; text-align:center;padding:0px;' >".$row['po_com']."</td>";

                    $getArticle = $this->db->query("SELECT * FROM article where id_article = ".$row['id_article']."")->row();

                            echo"<td style='border: none; text-align:center;padding:0px;'>".$getArticle->article."</td>";
                        
                      $getfournisseur = $this->db->query("SELECT * FROM fournisseur_article where id_fournisseur = ".$row['id_fournisseur_article']."")->row();

                            // echo"<td style='border: none; text-align:center;padding:0px;'>".$getfournisseur->nom."</td>";
                    
                    echo"
            
                    <td style='border:none; text-align:center;padding:0px;'>".$row['description']."</td>
                    <td style='border:none; text-align:center;padding:0px;'>".$row['qtite_com']."</td>
                    <td style='border: none; text-align:center;padding:0px;'>".number_format($row['pu'],0,',',' ')."</td>
                    <td style='border:none; text-align:center;padding:0px;'>".number_format($row['pu']*$row['qtite_com'],0,',',' ')." FCFA</td>
                     <td style='border:none; text-align:center;padding:0px;'>".$row['code_camion']."</td>"; 

                    // echo number_format($this->getMontantCommande($row['po_com']),0,',',' ');
                    
                  $compteur++;
        }

        $this->db->close();
    }

// public function deleteCommande($table, $identifiant, $nom_id){
//          $suppression = $this->db->query("delete from ".$table." where ".$nom_id."='".$identifiant."'");
//          if ($suppression == true) {
//              # code...
//             echo "Suppression effectuée";
//          }else{
//             echo "Erreur lors de la suppression";
//          }

//          $this->db->close();
//     }

    public function deleteCommande($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."='".$identifiant."'")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé la commande transport N° ".$nom_id." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."='".$identifiant."'");
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

  public function deleteCommandeCimenterie($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."='".$identifiant."'")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé la commande cimenterie N° ".$nom_id." le ".$date_notif." à ".$heure;


              $suppression = $this->db->query("delete from ".$table." where ".$nom_id."='".$identifiant."'");
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


public function getReferenceArticle(){
    $id_article = $_POST["id_article"];

    $getArticle = $this->db->query("SELECT * from article where id_article = ".$id_article."")->row();

    if(count($getArticle)>0){
      echo $getArticle->code_a_barre;
    }else{
      echo "Aucune";
    }
    
   $this->db->close();
}


// commande cimenterie

public function addCommandeCimenterie(){
    //Entete de la commande
    $id_fournisseur = $_POST['id_fournisseur'];
    $date_creation = $_POST['date_creation'];
    $date_com = $_POST['date_commande'];
    $po = $_POST['po'];
    $etat_reception = $_POST['etat_reception'];
    $etat_expedition = $_POST['etat_expedition'];
    // detail de la commande
    $nbreLignes = $_POST["nbreLignes"];

    $article = json_decode($_POST['article']);
    $quantite = json_decode($_POST['quantite']);
    $pu = json_decode($_POST['pu']);
    $camion = json_decode($_POST['camion']);
    $description = json_decode($_POST['description']);
    $id_commande = json_decode($_POST['id_commande']);
    $type = json_decode($_POST['type']);
    $status = $_POST["status"];

    $nom_table = "commandecimenterie";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté une commande cimenterie N° ".$po." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié une commande cimenterie N° ".$po." le ".$date_notif." à ".$heure;

    if ($status == "insert") {
        # code...
   
    $i = 1;

    while ( $i<= $nbreLignes) {
      // echo "test ".$i." ".$article[$i]." ".$quantite[$i]." ".$pu[$i]." ".$camion[$i]." ".$description[$i]; 

      $query = $this->db->query(" INSERT into commandecimenterie value('','".$po."',".$id_fournisseur.",CAST('". $date_creation."' AS DATE),CAST('". $date_com."' AS DATE),'".$etat_reception."','".$etat_expedition."',".$article[$i].",".$quantite[$i].",".intval(preg_replace('/\s/','', $pu[$i])).",'".$camion[$i]."','".addslashes($description[$i])."','".$type[$i]."')");

     $query2 = $this->db->query("UPDATE article set code_a_barre = '".addslashes($description[$i])."' where id_article=".$article[$i]."");
      $i++; 
    }

        if ($query == true) {
            # code...
            echo "Insertion parfaite de la commande";
            $this->notificationAjout($nom_table,addslashes($message));
            
        }else{
            echo "erreur lors de l'insertion";
        }

    }elseif ($status == "update") {
        # code...
         $i = 1;
        while ( $i<= $nbreLignes) {
      // echo "test ".$i." ".$article[$i]." ".$quantite[$i]." ".$pu[$i]." ".$camion[$i]." ".$description[$i]; 

      $query = $this->db->query(" UPDATE commandecimenterie set  date_crea = CAST('". $date_creation."' AS DATE),id_fournisseur_article=".$id_fournisseur.", date_com = CAST('". $date_com."' AS DATE), etat_recep ='".$etat_reception."', etat_exp ='".$etat_expedition."', id_article =".$article[$i].", qtite_com =".$quantite[$i].", pu =".intval(preg_replace('/\s/','', $pu[$i])).", code_camion ='".$camion[$i]."',description = '".addslashes($description[$i])."', type='".$type[$i]."' where id_commande =".$id_commande[$i]."");
      $query2 = $this->db->query("UPDATE article set code_a_barre = '".addslashes($description[$i])."' where id_article=".$article[$i]."");
      $i++; 
    }

        if ($query == true) {
            # code...
            echo "Modification parfaite de la commande";
            $this->notificationAjout($nom_table,addslashes($message2));

        }else{
            echo "erreur lors de l'insertion";
        }

    }else{
        echo "Erreur fatale contactez l'administrateur";
    }

    $this->db->close();
}

public function selectAllCommandeCimenterie(){
  $date = date('Y-m-d');
       //  $query1 = $this->db->query('SELECT distinct po_com,id_fournisseur_article,date_com,date_crea,etat_exp,etat_recep,id_commande,id_article,code_camion,description from commandecimenterie where date_com = "'.$date.'" group by po_com')->result_array();
         $query1 = $this->db->query('SELECT distinct po_com,id_fournisseur_article,date_com,date_crea,etat_exp,etat_recep,id_commande,id_article,code_camion,description from commandecimenterie group by po_com ORDER BY date_com DESC')->result_array();
         
		 
		 $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    
                    <td>".$row['po_com']."</td>";

                    $getfournisseur = $this->db->query("SELECT * FROM fournisseur_article where id_fournisseur = ".$row['id_fournisseur_article']."")->row();

                            echo"<td>".$getfournisseur->nom."</td>";
                    $getArticle = $this->db->query("SELECT * FROM article where id_article = ".$row['id_article']."")->row();

                            echo"<td>".$row['description']."</td><td>".$getArticle->article."</td>"; 
                    
                    echo"

                    <td>".$row['date_com']."</td>
                    <td>".$row['date_crea']."</td>
                    <td>".$row['code_camion']."</td>
                   
                    <td>"; 

                    echo number_format($this->getMontantCommandeCimenterie($row['po_com']),0,',',' ');
                    
                    echo "</td>

                    <td>";
                if($this->session->userdata('vidange_modification')=='true'){
                   echo" <button type='button' onclick='getDetailCommandeCimenteriePourModification(\"".$row['id_fournisseur_article']."\",\"".$row['date_crea']."\",\"".$row['date_com']."\",\"".$row['po_com']."\",\"".$row['etat_recep']."\",\"".$row['etat_exp']."\")'  class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                 }

                
                  echo"  <button type='button'   class=' btn-primary btn-sm' onclick='detailCommandeCimenterie(\"".$row['po_com']."\",\"".$getfournisseur->nom."\",\"".$row['date_com']."\",\"".$row['date_crea']."\",\"".$row['etat_exp']."\",\"".$row['etat_recep']."\",\"".number_format($this->getMontantCommandeCimenterie($row['po_com']),0,',',' ')." FCFA\")'><i class='nav-icon '>+</i></button>";

                if($this->session->userdata('vidange_suppression')=='true'){
                  echo"  <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='commandecimenterie' identifiant='".$row['po_com']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"po_com\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
        }

        $this->db->close();
    }


  public function getDetailCommandeCimenterie(){
    $po = $_POST["po"];
         $query1 = $this->db->query('SELECT * from commandecimenterie where po_com ="'.$po.'" order by date_com desc')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr style='border:none; text-align:center;font-size: 16px;padding:0px;'>
                    

                    <td style='border:none; text-align:center;padding:0px;' >".$row['po_com']."</td>";

                    $getArticle = $this->db->query("SELECT * FROM article where id_article = ".$row['id_article']."")->row();

                            echo"<td style='border: none; text-align:center;padding:0px;'>".$getArticle->article."</td>";
                        
                      $getfournisseur = $this->db->query("SELECT * FROM fournisseur_article where id_fournisseur = ".$row['id_fournisseur_article']."")->row();

                            // echo"<td style='border: none; text-align:center;padding:0px;'>".$getfournisseur->nom."</td>";
                    
                    echo"
            
                    <td style='border:none; text-align:center;padding:0px;'>".$row['description']."</td>
                    <td style='border:none; text-align:center;padding:0px;'>".$row['qtite_com']."</td>
                    <td style='border: none; text-align:center;padding:0px;'>".number_format($row['pu'],0,',',' ')."</td>
                    <td style='border:none; text-align:center;padding:0px;'>".number_format($row['pu']*$row['qtite_com'],0,',',' ')." FCFA</td>
                     <td style='border:none; text-align:center;padding:0px;'>".$row['code_camion']."</td>"; 

                    // echo number_format($this->getMontantCommande($row['po_com']),0,',',' ');
                    
                  $compteur++;
        }

        $this->db->close();
    }

  public function getListeCommandeCimenteriePourModif(){
    $po = $_POST["po"];
    $getAllCommande = $this->db->query("SELECT * from commandecimenterie where po_com = '".$po."'")->result_array();
    $i=1;
    foreach ($getAllCommande as $com) {
        # code...
  
   
  echo '<div class="row">
       <div class="col-md-2">
       <div class="form-group">
       <label>Article</label>
        <select class="article'.$i.' form-control" onchange="getPrixUnitaireArticle($(\'.article'.$i.'\').val(),\'pu'.$i.'\');getReferenceArticle($(\'.article'.$i.'\').val(),\'description'.$i.'\');">
        ';
         $getArticle = $this->db->query("SELECT * from article where id_article = ".$com['id_article']."")->row();
         echo "<option value='".$com['id_article']."'>".$getArticle->article."</option>";
        $this->crud_model_depense->leSelectArticle();
        echo '</select></div>
          </div>
          <div class="col-md-2">
          <label>Quantité</label>
          <input type="text" class="form-control qtite_com'.$i.'" placeholder=" " value="'.$com["qtite_com"].'" onkeypress="chiffres(event);" >
         </div>
         <div class="col-md-2">
            <label>Prix unitaire</label>
            <input type="text" class="form-control pu'.$i.'" placeholder=" en FCFA" value="'.$com["pu"].'" disabled="true" onkeypress="chiffres(event);">
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>Camion</label>
                <select class="camion'.$i.' camion form-control">';
                echo "<option value=".$com["code_camion"].">".$com["code_camion"]."</option>";
                     $this->crud_model_depense->leSelectCodeCamion();
        echo'</select>
            </div></div>
            <div class="col-md-2">
                <div class="form-group ">
                    <label>Référence</label>
                    <input type="text" class="form-control description'.$i.'" value="'.addslashes($com["description"]).' ">
                </div></div>
                <input type="hidden" class="form-control id_commande'.$i.'"  placeholder=" en FCFA" value="'.$com["id_commande"].'" disabled="true" onkeypress="chiffres(event);">

                <div class="col-md-2">
       <div class="form-group">
       <label>Type</label>
        <select class="type'.$i.' form-control" onchange="activePrix(\'.type'.$i.'\',\'.pu'.$i.'\');">';
         if ($com['type'] == 'interne') {
           # code...
          echo '<option>interne</option>
         <option>externe</option>';
         }else{
          echo '
          <option>interne</option>
          <option>externe</option>
          
         ';
         }
         echo '
         </select></div>
          </div>
            </div>
       <hr>';
       $i++;
      }
      $i = $i-1;
      echo '<input type="hidden" class="form-control compteur"  placeholder=" en FCFA" value="'.$i.'" disabled="true" onkeypress="chiffres(event);">';

      $this->db->close();
}


}