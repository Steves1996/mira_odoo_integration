<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model_depense extends CI_Model {
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

// ceci est la fonction permet de vérifier si une action se déroule nien à partir de la date de debut de l'opération
public function getValideDateUseOperation($date_action,$id_operation){
    $getOperation = $this->db->query("SELECT * from operation where id_operation =".$id_operation." limit 1")->row();

    if ($date_action < $getOperation->date_debut) {
        # code...
        return true;
    }else{
        return false;
    }
}
public function updateKilometrage($code_camion,$kilometrage){
    $getTracteur = $this->db->query("SELECT * from tracteur where code='".$code_camion."'")->row();

    if (count($getTracteur)>0) {
        # code...
         $this->db->query("UPDATE tracteur set kilometrage=".$kilometrage." where code='".$code_camion."'");
    }else{
        $this->db->query("UPDATE camion_benne set kilometrage=".$kilometrage." where code='".$code_camion."'");
    }
}

public function getTypeCamion(){
    $code_camion = $_POST['code_camion'];
     $getCamion = $this->db->query("SELECT * from camion_benne where code = '".$code_camion."'")->row();
     if (count($getCamion)>0) {
         # code...
        echo "true";
     }else{
        echo "false";
     }
}

public function addGazoil(){
    $commentaire = addslashes($_POST["commentaire"]);
    $numero = $_POST["numero"];
    $date = $_POST["dateDepense"];
    $litrage = $_POST["litrage"];
    $destination = $_POST["destination"];
    $kilometrage = $_POST["kilometrage"];
    $prixUnitaire = preg_replace('/\s/','', $_POST["prixUnitaire"]);
    $id_fournisseur = $_POST["id_fournisseur"];
    $codeCamion = $_POST["codeCamion"];
    $id_operation = $_POST["id_operation"];
    // $supplement = $_POST['supplement'];
    $status = $_POST["status"];

    $verifKilometrage = $this->db->query("SELECT * from gazoil WHERE code_camion ='".$codeCamion."' order by id_gazoil desc limit 1")->row();
    // echo "nombre ".count($verifKilometrage);
 if ($status == "insert") {
     # code...
    if (count($verifKilometrage)<1){
        # code...
        // on verifie si la date est supérieure à celle du debut de l'operation choisie
        // if ($this->getValideDateUseOperation($date,$id_operation) == true) {
        //     # code...
        //     echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        // }else{
        $insertion = $this->db->query("INSERT into gazoil value ('',".$id_operation.",".$id_fournisseur.",'".$codeCamion."','".$numero."',".$destination.", CAST('". $date."' AS DATE) ,".$litrage.",".$kilometrage.",".$prixUnitaire.",'".$commentaire."')");

            if ($insertion == true) {
                # code...
                echo "Insertion parfaite de la dépense";
                $this->updateKilometrage($codeCamion,$kilometrage);
            }else{
                echo "Erreur d'insertion";
            }
        // }
    }else{
    if ($verifKilometrage->kilometrage>$kilometrage) {
        # code...
        if ($verifKilometrage->date_gazoil >$date) {
            # code...
             $verifNumero = $this->db->query("SELECT * FROM gazoil where numero = '".$numero."'")->result_array();
    if (count($verifNumero) >0) {
        # code...
        echo "Ce numéro est déjà utilisé veuillez saisir un autre";
    }else{
        // if ($this->getValideDateUseOperation($date,$id_operation) == true) {
        //     # code...
        //     echo "Entrez une date supérieure à celle du debut de cette operation";
        // }else{
         $insertion = $this->db->query("INSERT into gazoil value ('',".$id_operation.",".$id_fournisseur.",'".$codeCamion."','".$numero."',".$destination.", CAST('". $date."' AS DATE) ,".$litrage.",".$kilometrage.",".$prixUnitaire.",'".$commentaire."')");

    if ($insertion == true) {
        # code...
        echo "Insertion parfaite de la dépense";
        // $this->updateKilometrage($codeCamion,$kilometrage);
    }else{
        echo "Erreur d'insertion";
    }
    // }
    }
        }else{
echo "Le nouveau kilometrage doit être supérieure ou egale à celui de la consommation précédante";
        }
        
    }else{

    $verifNumero = $this->db->query("SELECT * FROM gazoil where numero = '".$numero."'")->result_array();
    if (count($verifNumero) >0) {
        # code...
        echo "Ce numéro est déjà utilisé veuillez saisir un autre";
    }else{
        // if ($this->getValideDateUseOperation($date,$id_operation) == true) {
        //     # code...
        //     echo "Entrez une date supérieure à celle du debut de cette operation";
        // }else{
         $insertion = $this->db->query("INSERT into gazoil value ('',".$id_operation.",".$id_fournisseur.",'".$codeCamion."','".$numero."',".$destination.", CAST('". $date."' AS DATE) ,".$litrage.",".$kilometrage.",".$prixUnitaire.",'".$commentaire."')");

    if ($insertion == true) {
        # code...
        echo "Insertion parfaite de la dépense";
        $this->updateKilometrage($codeCamion,$kilometrage);
    }else{
        echo "Erreur d'insertion";
    }
    // }
    }
 }
    }   
 }elseif ($status == "update") {
     # code...
    if (count($verifKilometrage)<1) {

   
    $id_gazoil = $_POST["id_gazoil"];
    // if ($this->getValideDateUseOperation($date,$id_operation) == true) {
    //         # code...
    //         echo "Entrez une date supérieure à celle du debut de cette operation";
    //     }else{
    $verifNumero = $this->db->query("SELECT * FROM gazoil where numero = '".$numero."'  limit 1")->result_array();
    if (count($verifNumero) >0) {
        # code...
        
        foreach ($verifNumero as $tab) {
            # code...
            if ($tab["id_gazoil"] == $id_gazoil) {
                # code...
                $id_gazoil = $_POST["id_gazoil"];
        $update = $this->db->query("UPDATE gazoil set id_operation=".$id_operation.",id_fournisseur=".$id_fournisseur.",code_camion='".$codeCamion."',numero = '".$numero."',date_gazoil = CAST('". $date."' AS DATE), litrage = ".$litrage.", id_distance = ".$destination.", kilometrage = ".$kilometrage.",prix_unitaire = ".$prixUnitaire.", commentaire ='".$commentaire."' where id_gazoil=".$id_gazoil."");

    if ($update == true) {
        # code...
        echo "Modification parfaite de la dépense";
        $this->updateKilometrage($codeCamion,$kilometrage);
    }else{
        echo "Erreur de la modification";
    }
            }else{
    echo "Ce numéro est déjà utilisé veuillez saisir un autre";
            }
        }
    }else{
     
        $update = $this->db->query("UPDATE gazoil set id_operation=".$id_operation.",id_fournisseur=".$id_fournisseur.",code_camion='".$codeCamion."',numero = '".$numero."',date_gazoil = CAST('". $date."' AS DATE), litrage = ".$litrage.",desid_distance = ".$destination.", kilometrage = ".$kilometrage.",prix_unitaire = ".$prixUnitaire.", commentaire ='".$commentaire."' where id_gazoil=".$id_gazoil."");

    if ($update == true) {
        # code...
        echo "Modification parfaite de la dépense";
        $this->updateKilometrage($codeCamion,$kilometrage);
    }else{
        echo "Erreur de la modification";
    }
    }
// }





    }else{
            if ($verifKilometrage->kilometrage<$kilometrage) {
        # code...
        echo "Ce kilometrage ne doit pas etre superieur à celui de la dernière insertion ";
    }else{
    $id_gazoil = $_POST["id_gazoil"];
    // if ($this->getValideDateUseOperation($date,$id_operation) == true) {
    //         # code...
    //         echo "Entrez une date supérieure à celle du debut de cette operation";
    //     }else{
    $verifNumero = $this->db->query("SELECT * FROM gazoil where numero = '".$numero."' limit 1")->result_array();
    if (count($verifNumero) >0) {
        # code...
        
        foreach ($verifNumero as $tab) {
            # code...
            if ($tab["id_gazoil"] == $id_gazoil) {
                # code...
                $id_gazoil = $_POST["id_gazoil"];
        $update = $this->db->query("UPDATE gazoil set id_operation=".$id_operation.",id_fournisseur=".$id_fournisseur.",code_camion='".$codeCamion."',numero = '".$numero."',date_gazoil = CAST('". $date."' AS DATE), litrage = ".$litrage.", id_distance = ".$destination.", kilometrage = ".$kilometrage.",prix_unitaire = ".$prixUnitaire.", commentaire ='".$commentaire."' where id_gazoil=".$id_gazoil."");

    if ($update == true) {
        # code...
        echo "Modification parfaite de la dépense";
        $this->updateKilometrage($codeCamion,$kilometrage);
    }else{
        echo "Erreur de la modification";
    }
            }else{
    echo "Ce numéro est déjà utilisé veuillez saisir un autre";
            }
        }
    }else{
     
        $update = $this->db->query("UPDATE gazoil set id_operation=".$id_operation.",id_fournisseur=".$id_fournisseur.",code_camion='".$codeCamion."',numero = '".$numero."',date_gazoil = CAST('". $date."' AS DATE), litrage = ".$litrage.",desid_distance = ".$destination.", kilometrage = ".$kilometrage.",prix_unitaire = ".$prixUnitaire.", commentaire ='".$commentaire."' where id_gazoil=".$id_gazoil."");

    if ($update == true) {
        # code...
        echo "Modification parfaite de la dépense";
        $this->updateKilometrage($codeCamion,$kilometrage);
    }else{
        echo "Erreur de la modification";
    }
    }
// }
}
    }


    
 }else{
    echo "Erreur veuillez contacter l'administrateur";
 }

}

    public function leSelectFournisseurGazoil(){
        $query = $this->db->query("select * from fournisseur_gazoil")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_fournisseur"]."'>".$row["nom"]."</option>";
            }
        }else{

        }
    }
    public function getLittrage(){
        $id_distance = $_POST["destination"];

        $query = $this->db->query("SELECT * from distance_littrage where id_distance =".$id_distance." limit 1")->row();

        if (count($query)>0) {
            # code...
            echo $query->littrage;
        }
    }

    public function getPrixUnitaireParFournisseur(){
         $id_distance = $_POST["id_fournisseur"];

        $query = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur =".$id_distance." limit 1")->row();

        if (count($query)>0) {
            # code...
            echo $query->PU;
        }
    }

    public function getDistanceParCodeCamion(){
        $code_camion = $_POST["code_camion"];
         $query = $this->db->query("SELECT * from tracteur where code='".$code_camion."'")->row();
echo "<option value=''></option>";
         $query1 = $this->db->query("SELECT * from camion_benne where code='".$code_camion."' limit 1")->row();
        if (count($query) >0) {
            # code... 
            $getDistance = $this->db->query("SELECT * from distance_littrage where id_type_camion=".$query->id_type_camion." order by distance asc")->result_array();
            if (count($getDistance)>0) {
                # code...
                foreach ($getDistance as $row) {
                    # code...
                    echo "<option value='".$row["id_distance"]."'>".$row["distance"]."</option>";
                }
            }else{
                    // echo "<option value='0'>Aucune</option>";
                }
        }elseif (count($query1)>0) {
            # code...
             # code...
            $getDistance = $this->db->query("SELECT * from distance_littrage where id_type_camion=".$query1->id_type_camion." order by distance asc")->result_array();
            if (count($getDistance)>0) {
                # code...
                foreach ($getDistance as $row) {
                    # code...
                    echo "<option value='".$row["id_distance"]."'>".$row["distance"]."</option>";
                }
            }else{
                    // echo "<option value='0'>Aucune</option>";
                }
        } else{
                    // echo "<option value='0'>Aucune</option>";
             $query2 = $this->db->query("SELECT * from engin where code='".$code_camion."' limit 1")->row();

            $getDistance = $this->db->query("SELECT * from distance_littrage where id_type_camion=".$query2->id_type_camion." order by distance asc")->result_array();
            if (count($getDistance)>0) {
                # code...
                foreach ($getDistance as $row) {
                    # code...
                    echo "<option value='".$row["id_distance"]."'>".$row["distance"]."</option>";
                }
            }else{
                    // echo "<option value='0'>Aucune</option>";
                }

        }
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
    }

    public function leSelectOperation(){
        $query = $this->db->query("SELECT * from operation ORDER BY date_creation desc")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_operation"]."'>".$row["nom_op"]."</option>";
            }
        }else{

        }
    }
	
	public function leSelectOperation1(){
		
		
        $query = $this->db->query("SELECT * from operation")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_operation"]."'>".$row["nom_op"]."</option>";
            }
        }else{

        }
    }

public function getFournisseurPourModifGazoil(){
    $id_fournisseur = $_POST['id_fournisseur'];

    $query1 = $this->db->query('SELECT * from fournisseur_gazoil ')->result_array();

    if (count($query1)>0) {
        # code...*
         $query2 = $this->db->query('SELECT * from fournisseur_gazoil where id_fournisseur ='.$id_fournisseur.'')->row();
        echo "<option value='".$query2->id_fournisseur."'>".$query2->nom."</option>";
        foreach ($query1 as $row) {
          
            echo "<option value='".$row["id_fournisseur"]."'>".$row["nom"]."</option>";
        }
    }
}

public function getOperationPourModifGazoil(){
    $id_fournisseur = $_POST['id_operation'];

    $query1 = $this->db->query('SELECT * from operation ')->result_array();
   
    if (count($query1)>0) {
        # code...
         $query2 = $this->db->query('SELECT * from operation where id_operation ='.$id_fournisseur.'')->row();
        echo "<option value='".$query2->id_operation."'>".$query2->nom_op."</option>";
        foreach ($query1 as $row) {
            # code...
        
              echo "<option value='".$row["id_operation"]."'>".$row["nom_op"]."</option>";   
            
           
        }
    }
}
public function getDestinationPourModifGazoil(){
    $id_distance = $_POST['id_distance'];

    $query2 = $this->db->query('SELECT * from distance_littrage where id_distance ='.$id_distance.'')->row();
        echo "<option value='".$query2->id_distance."'>".$query2->distance."</option>";
    $this->crud_model_depense->getDistanceParCodeCamion();
}


public function getCodePourModifGazoil(){
    $id_fournisseur = $_POST['code_camion'];

        echo "<option value='".$id_fournisseur."'>".$id_fournisseur."</option>";
    $this->crud_model_depense->leSelectCodeCamion();
}

    public function selectAllGazoil(){
         $query1 = $this->db->query('SELECT * from gazoil order by date_gazoil desc')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td >".$row['numero']."</td>";

                    $getOperation = $this->db->query("SELECT * FROM operation where id_operation = ".$row['id_operation']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_op']."</td>";
                        }
                    }
                    $getDistance = $this->db->query("SELECT * from distance_littrage where id_distance = ".$row['id_distance']."")->row();
                    echo"
                    <td>".$row['code_camion']."</td>
                    <td> ".$row['date_gazoil']."</td>
                    <td>".$row['litrage']." L</td>
                    <td>";
                    if (count($getDistance)>0) {
                        # code...
                        echo  $getDistance->distance;
                    }else{}
                   echo "</td>
                    <td>".$row['kilometrage']."</td>
                    <td>".number_format($row['prix_unitaire'],0,',',' ')."</td>
                    <td>".number_format($row['prix_unitaire'] * $row['litrage'],0,',',' ')." </td>
                    <td>
                    <button type='button'  onclick=\"infoGazoil('".$row['numero']."','".$row['date_gazoil']."','".$row['litrage']."','".$row['id_distance']."','".$row['prix_unitaire']."','".$row['kilometrage']."','".$row['id_gazoil']."','".addslashes($row['commentaire'])."','".$row['id_fournisseur']."','".$row['id_operation']."','".$row['code_camion']."','".$row['id_distance']."');\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='gazoil' identifiant='".$row['id_gazoil']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_gazoil\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                  $compteur++;
        }
    }


public function selectAllPrime(){
         $query1 = $this->db->query('SELECT * from prime order by date_prime desc')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                    $getOperation = $this->db->query("SELECT * FROM operation where id_operation = ".$row['id_operation']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_op']."</td>";
                        }
                    }
                    
                    echo"

                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td> ".$row['libelle']."</td>
                    <td>".$row['code_camion']."</td>
                    
                    <td>".$row['date_prime']."</td>
                    <td>
                    <button type='button'  onclick=\"infoPrime('".$row['montant']." ','".$row['libelle']."','".$row['date_prime']."','".$row['code_camion']."','".$row['id_operation']."',".$row['id_prime'].")\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='prime' identifiant='".$row['id_prime']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_prime\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                  $compteur++;
        }
    }

public function addPrime(){
    $montant = preg_replace('/\s/','', $_POST["montant"]);
    $date = $_POST["date"];
    $codeCamion = $_POST["codeCamion"];
    $libelle = $_POST["libelle"];
    $id_operation = $_POST["id_operation"];
    $status = $_POST["status"];
    $id_prime = $_POST["id_prime"];
    if ($status == 'insert') {
        # code...
        if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
           $insertion = $this->db->query("INSERT INTO prime value ('',".$id_operation.",'".$codeCamion."',CAST('". $date."' AS DATE),".$montant.",'".$libelle."')");
    if ($insertion == true ) {
        # code...
        echo "Enregistrement de la prime réussi";
    }else{
        echo "Erreur lors de l'insertion";
    }
    }
    }elseif ($status == 'update') {
        # code...
    if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
           $update = $this->db->query("UPDATE prime set  id_operation =".$id_operation.",code_camion='".$codeCamion."',date_prime = CAST('". $date."' AS DATE),montant = ".$montant.",libelle = '".$libelle."' where id_prime=".$id_prime."");
    if ($update == true ) {
        # code...
        echo "Modification de la prime réussi";
    }else{
        echo "Erreur lors de la modification";
    }
}
    }else{
        echo "Erreur veuillez contacter l'administrateur";
    }
 
}


public function selectAllFraisRoute(){
         $query1 = $this->db->query('SELECT * from frais_route order by date_frais desc')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                    $getOperation = $this->db->query("SELECT * FROM operation where id_operation = ".$row['id_operation']."")->result_array();
                    $getDistance = $this->db->query("SELECT * FROM distance_littrage where id_distance = ".$row['id_distance']."")->row();
                    if (count($getDistance)>0) {
                        # code...
                        $distance = $getDistance->distance;
                    }else{
                        $distance = "";
                    }
                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_op']."</td>";
                        }
                    }
                    
                    echo"

                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    
                    <td>".$row['code_camion']."</td>
                    <td>".$row['commentaire']."</td>
                     <td>".addslashes($distance)."</td>
                    <td>".$row['date_frais']."</td>
                    <td>
                    <button type='button'  onclick=\"infoFraisRoute('".$row['montant']." ','".$row['distance']."','".$row['date_frais']."','".$row['code_camion']."','".$row['id_operation']."',".$row['id_frais_route'].",'".$row['commentaire']."','".$row['id_distance']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='frais_route' identifiant='".$row['id_frais_route']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_frais_route\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                  $compteur++;
        }
    }

public function addFraisRoute(){
    $destination = addslashes( $_POST['destination']);
    $commentaire = addslashes($_POST['commentaire']);
    $montant = preg_replace('/\s/','', $_POST["montant"]);
    $date = $_POST["date"];
    $codeCamion = $_POST["codeCamion"];
    $distance = $_POST["distance"];
    $id_operation = $_POST["id_operation"];
    $status = $_POST["status"];
    $id_frais_route = $_POST["id_frais_route"];
    if ($status == 'insert') {
        # code...
        if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
           $insertion = $this->db->query("INSERT INTO frais_route value ('',".$id_operation.",'".$codeCamion."',CAST('". $date."' AS DATE),".$montant.",'".$distance."','".$commentaire."',".$destination.")");
    if ($insertion == true ) {
        # code...
        echo "Frais de route enregistré";
    }else{
        echo "Erreur lors de l'insertion";
    }
    }
    }elseif ($status == 'update') {
        # code...
    if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
           $update = $this->db->query("UPDATE frais_route set  id_operation =".$id_operation.",code_camion='".$codeCamion."',date_frais = CAST('". $date."' AS DATE),montant = ".$montant.",distance = ".$distance.", commentaire='".$commentaire."',id_distance = ".$destination." where id_frais_route=".$id_frais_route."");
    if ($update == true ) {
        # code...
        echo "Frais de route modifié";
    }else{
        echo "Erreur lors de la modification";
    }
    }
    }else{
        echo "Erreur veuillez contacter l'administrateur";
    }
 
}



public function selectAllFraisDivers(){
         $query1 = $this->db->query('SELECT * from frais_divers order by date_frais desc')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                    $getOperation = $this->db->query("SELECT * FROM operation where id_operation = ".$row['id_operation']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_op']."</td>";
                        }
                    }
                    
                    echo"

                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td>".$row['code_camion']."</td>
                    <td>".$row['commentaire']."</td>
                   
                    <td>".$row['date_frais']."</td>
                    <td>
                    <button type='button'  onclick=\"infoFraisRoute('".$row['montant']." ','','".$row['date_frais']."','".$row['code_camion']."','".$row['id_operation']."',".$row['id_frais_divers'].",'".addslashes($row['commentaire'])."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='frais_divers' identifiant='".$row['id_frais_divers']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_frais_divers\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                  $compteur++;
        }
    }

public function addFraisDivers(){
    $montant = preg_replace('/\s/','', $_POST["montant"]);
    $date = $_POST["date"];
    $codeCamion = $_POST["codeCamion"];
    $commentaire = addslashes($_POST["commentaire"]);
    $id_operation = $_POST["id_operation"];
    $status = $_POST["status"];
    $id_frais_divers = $_POST["id_frais_divers"];
    if ($status == 'insert') {
        # code...
    if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
           $insertion = $this->db->query("INSERT INTO frais_divers value ('',".$id_operation.",'".$codeCamion."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."')");
            if ($insertion == true ) {
                # code...
                echo "Frais divers enregistré";
            }else{
                echo "Erreur lors de l'insertion";
            }
     }
    }elseif ($status == 'update') {
        # code...
    if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
           $update = $this->db->query("UPDATE frais_divers set  id_operation =".$id_operation.",code_camion='".$codeCamion."',date_frais = CAST('". $date."' AS DATE),montant = ".$montant.", commentaire='".$commentaire."' where id_frais_divers=".$id_frais_divers."");
    if ($update == true ) {
        # code...
        echo "Frais divers modifié";
    }else{
        echo "Erreur lors de la modification";
    }
    }
    }else{
        echo "Erreur veuillez contacter l'administrateur";
    }
 
}

public function getPrixUnitaireArticle(){
    $id_article = $_POST["id_article"];
    $origine = $_POST['origine'];

    if (empty($id_article)) {
        # code...
        echo "0 ";
    }else{
    if ($origine == "externe") {
        # code...
    }else{
    $getArticle = $this->db->query("SELECT * from article where id_article = ".$id_article."")->row();

    echo $getArticle->prix_unitaire;
        }
    }
}

public function getReferenceArticle(){
    $id_article = $_POST["id_article"];

    if (empty($id_article)) {
        # code...
        echo "0 ";
    }else{
 
    $getArticle = $this->db->query("SELECT * from article where id_article = ".$id_article."")->row();

    echo $getArticle->code_a_barre;
        
    }
}
public function selectAllVidange(){
         $query1 = $this->db->query('SELECT * from vidange order by date_vidange desc')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                    $getOperation = $this->db->query("SELECT * FROM operation where id_operation = ".$row['id_operation']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_op']."</td>
                            <td>".$row['code_camion']."</td>
                    
                            ";
                        }
                    }

                    $getOperation = $this->db->query("SELECT * FROM type_huile where id_type = ".$row['id_type_huile']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            $prixTotal = $tab["PU"]*$row["qtite"];
                            echo"<td>".$tab['huile']."</td>
                            <td>".number_format($tab['PU'],0,',',' ')." </td>
                            <td>".$row['qtite']." L</td>
                            <td>".number_format($prixTotal,0,',',' ')." </td>";
                        }
                    }
                    
                    echo"

                    <td>".$row['date_vidange']."</td>
                    <td>
                    <button type='button'  onclick=\"infoVidange('".$row['id_type_huile']." ','".$row['commentaire']."','".$row['date_vidange']."','".$row['code_camion']."','".$row['id_operation']."',".$row['id_vidange'].")\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='vidange' identifiant='".$row['id_vidange']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_vidange\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                  $compteur++;
        }
    }

public function getKilometrageVehicule($code){

    $getTracteur = $this->db->query("SELECT * from tracteur where code ='".$code."'")->row();
    $getCamion = $this->db->query("SELECT * from camion_benne where code ='".$code."'")->row();
    $getEngin = $this->db->query("SELECT * from engin where code ='".$code."'")->row();

    if (count($getTracteur)>0) {

        return $getTracteur->kilometrage;
    }elseif (count($getCamion)>0) {

        return $getCamion->kilometrage;
    }elseif (count($getEngin)>0) {

       return $getEngin->kilometrage;
    }else{
        return 0;
    }
}
public function addVidange(){
    $commentaire = $_POST["commentaire"];
    $date = $_POST["date"];
    $codeCamion = $_POST["codeCamion"];
    $huile = $_POST["huile"];
    $id_operation = $_POST["id_operation"];
    $status = $_POST["status"];
    $id_frais_divers = $_POST["id_frais_divers"];
    $qtite = $_POST["qtite"];
    if ($status == 'insert') {
        # code...

    $verifHuile = $this->db->query("SELECT * FROM vidange where id_type_huile = '".$huile."'")->result_array();

   if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
            $insertion = $this->db->query("INSERT INTO vidange value ('',".$id_operation.",'".$codeCamion."',CAST('". $date."' AS DATE),".$huile.",'".$commentaire."',".$qtite.",".$this->getKilometrageVehicule($codeCamion).")");
        if ($insertion == true ) {
            # code...
            echo "Vidange enregistrée";
        }else{
            echo "Erreur lors de l'insertion";
        } 
    
      }
    }elseif ($status == 'update') {
        # code...

    $verifHuile = $this->db->query("SELECT * FROM vidange where id_type_huile = ".$huile."")->result_array();

   if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
                 $update = $this->db->query("UPDATE vidange set  id_operation =".$id_operation.",code_camion='".$codeCamion."',date_vidange = CAST('". $date."' AS DATE),id_type_huile = ".$huile.",commentaire = '".$commentaire."', qtite =".$qtite." where id_vidange=".$id_frais_divers."");
                if ($update == true ) {
                    # code...
                    echo "Vidange modifiée";
                }else{
                    echo "Erreur lors de la modification";
                }
       }   
    }else{
        echo "Erreur veuillez contacter l'administrateur";
    }
 
}




// pieces de rechange

public function getArticlePourModifPiece(){
    $id_fournisseur = $_POST['id_article'];

    $query1 = $this->db->query('SELECT * from article ')->result_array();
   
    if (count($query1)>0) {
        # code...
         $query2 = $this->db->query('SELECT * from article where id_article ='.$id_fournisseur.'')->row();
        echo "<option value='".$query2->id_article."'>".$query2->article."</option>";
        foreach ($query1 as $row) {
            # code...
        
              echo "<option value='".$row["id_article"]."'>".$row["article"]."</option>";   
            
           
        }
    }
}
public function getFournisseurPourModifPiece(){
    $id_fournisseur = $_POST['id_fournisseur'];

    $query1 = $this->db->query('SELECT * from fournisseur_article ')->result_array();

    if (count($query1)>0) {
        # code...*
         $query2 = $this->db->query('SELECT * from fournisseur_article where id_fournisseur ='.$id_fournisseur.'')->row();
        echo "<option value='".$query2->id_fournisseur."'>".$query2->nom."</option>";
        foreach ($query1 as $row) {
          
            echo "<option value='".$row["id_fournisseur"]."'>".$row["nom"]."</option>";
        }
    }
}

// public function getDestinationPourModifGazoil(){
//     $id_distance = $_POST['id_distance'];

//     $query2 = $this->db->query('SELECT * from distance_littrage where id_distance ='.$id_distance.'')->row();
//         echo "<option value='".$query2->id_distance."'>".$query2->distance."</option>";
//     $this->crud_model_depense->getDistanceParCodeCamion();
// }

public function addPieceRechange(){
    $pu = preg_replace('/\s/','', $_POST["pu"]);
    $origine = $_POST["origine"];
    $id_article = $_POST["article"];
    $date = $_POST["date"];
    $codeCamion = $_POST["codeCamion"];
    $distance = addslashes($_POST["commentaire"]);
    $id_operation = $_POST["id_operation"];
    $status = $_POST["status"];
    $id_frais_divers = $_POST["id_frais_divers"];
    $id_fournisseur = $_POST["id_fournisseur"];
    $qtite = $_POST["qtite"];
    if ($status == 'insert') {
        # code...
        if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
        if ($origine == "interne") {
            # code...
            // $id_fournisseur = "null";
            $insertion = $this->db->query("INSERT INTO piece_rechange value ('',".$id_operation.",".$id_article.",".$id_fournisseur.",'".$codeCamion."',CAST('". $date."' AS DATE),'".$distance."',".$qtite.",'".$origine."','')");
        }else{
            $insertion = $this->db->query("INSERT INTO piece_rechange value ('',".$id_operation.",".$id_article.",".$id_fournisseur.",'".$codeCamion."',CAST('". $date."' AS DATE),'".$distance."',".$qtite.",'".$origine."',".$pu.")");
        }
           
    if ($insertion == true ) {
        # code...
        echo "Pièce de rechange ajoutée";
    }else{
        echo "Erreur lors de l'insertion";
    }
    }
    }elseif ($status == 'update') {
        # code...
        if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
        if ($origine == "interne") {
            # code...
            // $id_fournisseur = "null";
            $update = $this->db->query("UPDATE piece_rechange set  id_operation =".$id_operation.",id_article=".$id_article.",code_camion='".$codeCamion."',date_rech = CAST('". $date."' AS DATE),commentaire = '".$distance."', qtite=".$qtite.", prix_unitaire=0,origine='".$origine."' where id_rechange=".$id_frais_divers."");
        }else{
           $update = $this->db->query("UPDATE piece_rechange set  id_operation =".$id_operation.",id_article=".$id_article.",code_camion='".$codeCamion."',date_rech = CAST('". $date."' AS DATE),commentaire = '".$distance."', qtite=".$qtite.", prix_unitaire=".$pu.",origine='".$origine."',id_fournisseur =".$id_fournisseur." where id_rechange=".$id_frais_divers."");
        }
    if ($update == true ) {
        # code...
        echo "Pièce de rechange modifiée";
    }else{
        echo "Erreur lors de la modification";
    }
    }
    }else{
        echo "Erreur veuillez contacter l'administrateur";
    }
 
}


public function addDepensePneu(){

    $pu = intval(preg_replace('/\s/','', $_POST["pu"]));


    $id_article = $_POST["article"];
    $derniereDate = $_POST["derniereDate"];
    $type= $_POST["type"];
    $date = $_POST["date"];
    $codeCamion = $_POST["codeCamion"];
    $commentaire = $_POST["commentaire"];
    $status = $_POST["status"];
    $id_frais_divers = $_POST["id_frais_route"];
 
    $qtite = $_POST["qtite"];

    if ($status == 'insert') {
       
            # code...
            // $id_fournisseur = "null";
            $insertion = $this->db->query("INSERT INTO depense_pneu value ('','".$codeCamion."',".$id_article.",CAST('". $date."' AS DATE),".$qtite.",".$pu.",'".$commentaire."',CAST('". $derniereDate."' AS DATE),'".$type."')");
       
            if ($insertion == true ) {
                # code...
                echo "Pièce de rechange ajoutée";
            }else{
                echo "Erreur lors de l'insertion";
            }
    
    }elseif ($status == 'update') {
        # code...
        
            // $id_fournisseur = "null";
            $update = $this->db->query("UPDATE depense_pneu set  id_article=".$id_article.",code_camion='".$codeCamion."',date_depense = CAST('". $date."' AS DATE),commentaire = '".$commentaire."', qtite=".$qtite.", prix_unitaire=".$pu.",derniereDate =CAST('". $derniereDate."' AS DATE),type='".$type."' where id_depense=".$id_frais_divers."");
        
        if ($update == true ) {
            # code...
            echo "Pièce de rechange modifiée";
        }else{
            echo "Erreur lors de la modification";
        }
    
    }else{
        echo "Erreur veuillez contacter l'administrateur";
    }
 
}


public function selectAllPieceRechange(){
         $query1 = $this->db->query('SELECT * from piece_rechange order by date_rech desc')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                    $getOperation = $this->db->query("SELECT * FROM operation where id_operation = ".$row['id_operation']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_op']."</td>";
                        }
                    }
                     $getArticle = $this->db->query("SELECT * FROM article where id_article = ".$row['id_article']."")->result_array();

                    if (count($getArticle)>0) {
                        # code...
                        foreach ($getArticle as $tab) {
                            # code...
                            $getCategorie = $this->db->query('SELECT * FROM categorie_article where id_categorie='.$tab['id_categorie'].'')->row();
                            if ($row["origine"] == "externe") {
                                # code...
                                $pu = $row["prix_unitaire"];
                            }else{
                                $pu = $tab["prix_unitaire"];
                            }
                        
                       
                            $pt = $pu*$row["qtite"];
                            echo"<td>".$tab['article']."</td>
                            <td>".$tab['code_a_barre']."</td>

                            <td>".$getCategorie->categorie."</td>";
                            
                            if ($row['id_fournisseur_article'] != null || $row['id_fournisseur_article'] != '') {
                            # code...
                             $getFournisseurArticle = $this->db->query("SELECT * from fournisseur_article where id_fournisseur = ".$row['id_fournisseur_article']." limit 1")->row();
                             if (count($getFournisseurArticle) >0) {
                                 # code...
                                 echo " <td>".$getFournisseurArticle->nom." </td>";
                             }else{
                                echo "<td></td>";
                             }
                           
                             }else{
                                echo "<td></td>";
                             }

                            echo "                            
                            <td>".$row['code_camion']." </td>
                            <td>".number_format($pt,0,',',' ')."</td>";
                        }
                    }
                    
                    echo"                  
                      
                    
                    <td>".$row['date_rech']."</td>
                    <td> ".$row['commentaire']." </td>
                    <td>
                    <button type='button'  onclick=\"infoPieceRechange('".$row['code_camion']."','".$row['id_article']."','".$row['origine']."','".$row['qtite']."','".$row['id_operation']."','".$row['date_rech']."','".$row['prix_unitaire']."','".$row['commentaire']."','".$row['id_rechange']."','".$row['id_fournisseur_article']."','".$row['origine']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='piece_rechange' identifiant='".$row['id_rechange']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_rechange\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                  $compteur++;
        }
    }


public function selectAllDepensePneu(){
    if (isset($_POST['date_debut']) && isset($_POST['date_fin'])) {
        # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];

    }elseif(isset($_POST['date_debut']) && !isset($_POST['date_fin'])) {
        # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = "";
    }elseif(!isset($_POST['date_debut']) && isset($_POST['date_fin'])) {
        # code...
        $date_debut = "";
        $date_fin = $_POST['date_fin'];
    }
    else{
        $date_debut = "";
        $date_fin="";
    }
        
        if (!empty($date_debut) && empty($date_fin)) {
            # code...
           
            $query1 = $this->db->query('SELECT * from depense_pneu where date_depense ="'.$date_debut.'" order by date_depense desc')->result_array();
        }elseif (!empty($date_fin) && empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * from depense_pneu where date_depense <"'.$date_fin.'" order by date_depense desc')->result_array();
        }elseif (!empty($date_debut) && !empty($date_fin)) {
            # code...

            $query1 = $this->db->query('SELECT * from depense_pneu where date_depense between "'.$date_debut.'" and "'.$date_fin.'"
              order by date_depense desc')->result_array();
             // echo "test1 ".$query1;
        }else{
            
            $query1 = $this->db->query('SELECT * from depense_pneu order by date_depense desc')->result_array();
        }
         
         $compteur = 0;
        foreach ($query1 as $row) {
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
                    <td>
                    <button type='button'  onclick=\"infoPieceRechange('".$row['code_camion']."','".$row['id_depense']."','','".$row['qtite']."','','".$row['date_depense']."','".$row['prix_unitaire']."','".$row['commentaire']."','".$row['id_depense']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='depense_pneu' identifiant='".$row['id_depense']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_depense\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                  $compteur++;
        }
    }


public function leSelectArticle(){
        $query = $this->db->query("SELECT  * from article order by article asc")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_article"]."'>".$row["article"]."</option>";
            }
        }else{

        }
    }
public function getHuileMoteur(){
    $getHuileMoteur = $this->db->query("select * from type_huile where type_huile = 'moteur'")->result_array();
    if (count($getHuileMoteur)  >0) {
        # code...
        foreach ($getHuileMoteur as $row1) {
            # code...
             echo "<option value=".$row1['id_type'].">".$row1['huile']."</option>";
        }
    }
}
public function getHuileHydrolique(){
   $getHuileMoteur = $this->db->query("select * from type_huile where type_huile = 'hydrolique'")->result_array();
    if (count($getHuileMoteur)  >0) {
        # code...
        foreach ($getHuileMoteur as $row1) {
            # code...
             echo "<option value=".$row1['id_type'].">".$row1['huile']."</option>";
        }
    }
}
public function getHuileBoite(){
     $getHuileMoteur = $this->db->query("select * from type_huile where type_huile = 'boite'")->result_array();
    if (count($getHuileMoteur)  >0) {
        # code...
        foreach ($getHuileMoteur as $row1) {
            # code...
             echo "<option value=".$row1['id_type'].">".$row1['huile']."</option>";
        }
    }
}
public function selectAllVidangeHydrolique(){
         $query1 = $this->db->query('SELECT * from vidangeHydrolique order by date_vidange desc')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                     $getOperation = $this->db->query("SELECT * FROM operation where id_operation = ".$row['id_operation']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_op']."</td>
                            <td>".$row['code_camion']."</td>
                    
                            ";
                        }
                    }

                    $getOperation = $this->db->query("SELECT * FROM type_huile where id_type = ".$row['id_type_huile']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            $prixTotal = $tab["PU"]*$row["qtite"];
                            echo"<td>".$tab['huile']."</td>
                            <td>".number_format($tab['PU'],0,',',' ')." </td>
                            <td>".$row['qtite']." L</td>
                            <td>".number_format($prixTotal,0,',',' ')." </td>";
                        }
                    }
                    
                    echo"
                     <td>".$row['date_vidange']."</td>
                    <td>
                    <button type='button'  onclick=\"infoVidange('".$row['id_type_huile']." ','".$row['commentaire']."','".$row['date_vidange']."','".$row['code_camion']."','".$row['id_operation']."',".$row['id_vidange'].")\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='vidangeHydrolique' identifiant='".$row['id_vidange']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_vidange\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                  $compteur++;
        }
    }

public function addVidangeHydrolique(){
    $commentaire = $_POST["commentaire"];
    $date = $_POST["date"];
    $codeCamion = $_POST["codeCamion"];
    $huile = $_POST["huile"];
    $id_operation = $_POST["id_operation"];
    $status = $_POST["status"];
    $id_frais_divers = $_POST["id_frais_divers"];
        $qtite = $_POST["qtite"];
    if ($status == 'insert') {
        # code...
    $verifHuile = $this->db->query("SELECT * FROM vidangeHydrolique where id_type_huile = ".$huile."")->result_array();

    if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
            $insertion = $this->db->query("INSERT INTO vidangeHydrolique value ('',".$id_operation.",'".$codeCamion."',CAST('". $date."' AS DATE),".$huile.",'".$commentaire."',".$qtite.")");
        if ($insertion == true ) {
            # code...
            echo "Vidange enregistrée";
        }else{
            echo "Erreur lors de l'insertion";
        } 
    
      }
    }elseif ($status == 'update') {
     
                # code...
        if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
                 $update = $this->db->query("UPDATE vidangeHydrolique set  id_operation =".$id_operation.",code_camion='".$codeCamion."',date_vidange = CAST('". $date."' AS DATE),id_type_huile = ".$huile.",commentaire = '".$commentaire."',qtite=".$qtite." where id_vidange=".$id_frais_divers."");
                if ($update == true ) {
                    # code...
                    echo "Vidange modifiée";
                }else{
                    echo "Erreur lors de la modification";
                }
            
      }
      
    }else{
        echo "Erreur veuillez contacter l'administrateur";
    }
 
}


public function selectAllVidangeBoite(){
         $query1 = $this->db->query('SELECT * from vidangeBoite order by date_vidange desc')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                     $getOperation = $this->db->query("SELECT * FROM operation where id_operation = ".$row['id_operation']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_op']."</td>
                            <td>".$row['code_camion']."</td>
                    
                            ";
                        }
                    }

                    $getOperation = $this->db->query("SELECT * FROM type_huile where id_type = ".$row['id_type_huile']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            $prixTotal = $tab["PU"]*$row["qtite"];
                            echo"<td>".$tab['huile']."</td>
                            <td>".number_format($tab['PU'],0,',',' ')." </td>
                            <td>".$row['qtite']." L</td>
                            <td>".number_format($prixTotal,0,',',' ')." </td>";
                        }
                    }
                    
                    echo"
                     <td>".$row['date_vidange']."</td>
                    <td>
                    <button type='button'  onclick=\"infoVidange('".$row['id_type_huile']." ','".$row['commentaire']."','".$row['date_vidange']."','".$row['code_camion']."','".$row['id_operation']."',".$row['id_vidange'].")\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='vidangeBoite' identifiant='".$row['id_vidange']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_vidange\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                  $compteur++;
        }
    }

public function addVidangeBoite(){
    $commentaire = $_POST["commentaire"];
    $date = $_POST["date"];
    $codeCamion = $_POST["codeCamion"];
    $huile = $_POST["huile"];
    $id_operation = $_POST["id_operation"];
    $status = $_POST["status"];
    $id_frais_divers = $_POST["id_frais_divers"];
    $qtite = $_POST["qtite"];
    if ($status == 'insert') {
        # code...
    $verifHuile = $this->db->query("SELECT * FROM vidangeBoite where id_type_huile = ".$huile."")->result_array();
    if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
            $insertion = $this->db->query("INSERT INTO vidangeBoite value ('',".$id_operation.",'".$codeCamion."',CAST('". $date."' AS DATE),'".$huile."','".$commentaire."',".$qtite.")");
    if ($insertion == true ) {
        # code...
        echo "Vidange enregistrée";
    }else{
        echo "Erreur lors de l'insertion";
    } 
    }
      
    }elseif ($status == 'update') {
        # code...

    $verifHuile = $this->db->query("SELECT * FROM vidangeBoite where id_type_huile = ".$huile."")->result_array();

  if ($this->getValideDateUseOperation($date,$id_operation) == true) {
            # code...
            echo "Entrez une date supérieure à celle du debut de l'opération choisie";
        }else{
        # code...
        foreach ($verifHuile as $tab) {
           
                # code...
                 $update = $this->db->query("UPDATE vidangeBoite set  id_operation =".$id_operation.",code_camion='".$codeCamion."',date_vidange = CAST('". $date."' AS DATE),id_type_huile = ".$huile.",commentaire = '".$commentaire."',qtite=".$qtite." where id_vidange=".$id_frais_divers."");
                if ($update == true ) {
                    # code...
                    echo "Vidange modifiée";
                }else{
                    echo "Erreur lors de la modification";
                }
           
        }
       
   }
          
    }else{
        echo "Erreur veuillez contacter l'administrateur";
    }
 
}


  public function addTypeHuile(){
        $huile = $_POST["huile"];
        $type_huile = $_POST["type_huile"];
        $PU = preg_replace('/\s/','', $_POST["PU"]);
        $status = $_POST["status"];
        if ($status =="insert") {
            # code...

                $requete = $this->db->query("SELECT * from type_huile where huile ='".$huile."' and type_huile ='".$type_huile."'")->result_array();
                if (count($requete)>0) {
                    # code...
                    echo "Erreur cette huile existe déjà pour ce type veuiller changer";
                }else{
                    $query1 = $this->db->query("insert into type_huile value('','". $type_huile. "','".$huile."',".$PU.")");
                            if($query1 == true){
                                echo "Insertion parfaite de l'huile";
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                }
        }elseif ($status == "update") {
            # code...
            $id_client =$_POST["id_client"];
                $requete = $this->db->query("SELECT * from type_huile where huile ='".$huile."' and type_huile ='".$type_huile."'")->result_array();
                if (count($requete)>0) {
                    # code...
                   foreach ($requete as $row) {
                       # code...
                        if ($row["id_client"] == $id_client) {
                            # code...
                            $query1 = $this->db->query("UPDATE type_huile set huile='".$huile."', type_huile='".$type_huile."', PU=".$PU." where id_type=".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du l'huile";
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                        }else{
                            echo "Erreur cette huile existe déjà pour ce type veuiller changer";
                        }
                   }
                }else{
                    $query1 = $this->db->query("UPDATE type_huile set huile='".$huile."', type_huile='".$type_huile."', PU=".$PU." where id_type=".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du l'huile";
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                }
        }else{
            echo "Erreur contactez l'administrateur".$status ;
        }
        
    }

    public function selectAllTypeHuile(){
              $query1 = $this->db->get_where('type_huile')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['type_huile']."
                    </td>
                    <td>".$row['huile']."</td>
                    <td> ".number_format($row['PU'],0,',',' ')." </td>
                    <td>
                    <button type='button' onclick=\"infosTypeHuile('".$row['id_type']."','".$row['type_huile']."','".$row['huile']."','".$row['PU']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='type_huile' identifiant='".$row['id_type']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_type\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                  $compteur++;
        }
    }


    public function getPrixUnitaireHuile(){
        $id_type = $_POST["id_type"];
        $query = $this->db->query("SELECT * from type_huile where id_type = ".$id_type." limit 1")->row();

        if (count($query) > 0) {
            # code...
            echo $query->PU;
        }else{
            echo "0";
        }
    
   }

}