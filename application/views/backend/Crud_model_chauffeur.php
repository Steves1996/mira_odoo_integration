<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model_chauffeur extends CI_Model {
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
    public function verifExistTelephoneChauffeur($telephoneChauffeur){
        $requete = $this->db->query("select * from chauffeur where telephoneChauffeur =".$telephoneChauffeur."")->result_array();
        if (count($requete)>0) {
            # code...
            return true;
        }else{
            return false;
        }
    }

    public function verifExistCniChauffeur($cniChauffeur){
        $requete = $this->db->query("select * from chauffeur where cni_chauff ='".$cniChauffeur."'")->result_array();
        if (count($requete)>0) {
            # code...
            return true;
        }else{
            return false;
        }
    }

    public function verifExistPermisChauffeur($permisChauffeur){
        $requete = $this->db->query("select * from chauffeur where  num_permis ='".$permisChauffeur."'")->result_array();
        if (count($requete)>0) {
            # code...
            return true;
        }else{
            return false;
        }
    }
    public function verifExistCniAssistant($cniChauffeur){
        $requete = $this->db->query("select * from chauffeur where cni_ass ='".$cniChauffeur."'")->result_array();
        if (count($requete)>0) {
            # code...
            return true;
        }else{
            return false;
        }
    }

    public function selectAllChauffeur(){
        $query1 = $this->db->get_where('chauffeur')->result_array();
        $compteur =0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    <td >".$compteur."</td>
                    <td>".$row['nom']."
                    </td>
                    <td>".$row['cni_chauff']."</td>
                   
                    <td> ".$row['num_permis']."</td>
                    <td> ".$row['telephoneChauffeur']."</td>
                    <td> ".$row['nom_ass']."</td>
                    <td> ".$row['cni_ass']."</td>
                    
                    
                    <td> ".$row['telephoneAssistant']."</td>
                    <td>
                    <button type='button' onclick='infosChauffeur(\"".$row['id_chauffeur']."\",\"".$row['num_permis']."\",\"".$row['telephoneChauffeur']."\",\"".$row['telephoneAssistant']."\",\"".$row['nom']."\",\"".$row['nom_ass']."\",\"".$row['cni_chauff']."\",\"".$row['cni_ass']."\",\"".$row['date_exp_cni_ass']."\",\"".$row['date_exp_cni_ch']."\",\"".$row['date_exp_permis_ch']."\");' class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='chauffeur' identifiant='".$row['id_chauffeur']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_chauffeur\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                  $compteur++;
        }

    }

    public function addChauffeur(){
    $status = $_POST["status"];
    $nomChauffeur = $_POST["nomChauffeur"];
    $telephoneChauffeur = $_POST["telephoneChauffeur"];
    $telephoneAssistant = $_POST["telephoneAssistant"];
    $nomAssistant = $_POST["nomAssistant"];
    $cniChauffeur = $_POST["cniChauffeur"];
    $cniAssistant = $_POST["cniAssistant"];
    $expirationCNIChauffeur = $_POST["expirationCNIChauffeur"];
    $expirationPermisChauffeur = $_POST["expirationPermisChauffeur"];

    $expirationCNIAssistant = $_POST["expirationCNIAssistant"];
    $permisChauffeur = $_POST["permisChauffeur"];

    if ($status == "insert") {
        # code...
        if ($this->verifExistTelephoneChauffeur($telephoneChauffeur) == true) {
        # code...
        echo "Ce numéro de téléphone est déjà utilisé par un autre chauffeur veuillez le changer SVP";
    }elseif ($this->verifExistPermisChauffeur($permisChauffeur) == true) {
        # code...
        echo "Ce numéro de permis est déjà utilisé par un autre chauffeur";
    }elseif ($this->verifExistCniChauffeur($cniChauffeur) == true) {
        # code...
        echo "Un autre chauffeur possède déjà ce numéro de CNI veuillez changer";
    }elseif ($this->verifExistCniAssistant($cniAssistant )== true) {
        # code...
        echo "Un autre assistant utilise déja ce numéro de cni Veuillez changer";
    }
    else{
         $this->addImageChauffeur($nomChauffeur,$cniChauffeur,$expirationCNIChauffeur,$expirationPermisChauffeur,$nomAssistant,$cniAssistant,$expirationCNIAssistant,$telephoneChauffeur,$telephoneAssistant,$permisChauffeur);
    }
    }elseif ($status == "update") {
        # code...
        $id_chauffeur = $_POST["id_chauffeur"];
        $this->updateChauffeur($id_chauffeur);
    }else{
        echo "Erreur contactez l'administrateur";
    }
    
    
    }

    public function addImageChauffeur($nomChauffeur,$cniChauffeur,$expirationCNIChauffeur,$expirationPermisChauffeur,$nomAssistant,$cniAssistant,$expirationCNIAssistant,$telephoneChauffeur,$telephoneAssistant,$permisChauffeur){
        $num_cni = $_POST["cniChauffeur"];
        $folderPath = "assets/chauffeur/".$num_cni;
$extensionsValides = array('jpg','png','gif','jpeg');
        if (isset($_FILES['file_chauffeur']['tmp_name']) && !isset($_FILES['file_assistant']['tmp_name'])) {
            # code...
            $fileChauffeur = $_FILES['file_chauffeur']['tmp_name']; 
            $extensionsChauffeur=strtolower(substr(strrchr($_FILES['file_chauffeur']['name'], '.'),1));
            if(in_array($extensionsChauffeur, $extensionsValides)){
                   if(!file_exists('assets/chauffeur/'.$num_cni)){
                            if (mkdir('assets/chauffeur/'.$num_cni, 0777, true) == true) {

                             $uploadImageChauffeur = move_uploaded_file($fileChauffeur, $folderPath."/".$_FILES['file_chauffeur']['name']);

                            if($uploadImageChauffeur == true){
                                 $query1 = $this->db->query("insert into chauffeur value('','". $nomChauffeur. "','". $cniChauffeur."',CAST('". $expirationCNIChauffeur."' AS DATE),CAST('".$expirationPermisChauffeur."' AS DATE),'".$nomAssistant."','".$cniAssistant."',CAST('".$expirationCNIAssistant."' AS DATE),".$telephoneChauffeur.",".$telephoneAssistant.",'".$permisChauffeur."','".$_FILES['file_chauffeur']['name']."','')");
                                    if($query1 == true){
                                        echo "Insertion parfaite du Chauffeur";
                                    }else{
                                        echo "Erreur durant l'insertion";
                                    } 
                            }else{
                                echo "Désolé Erreur lors de l'envoit de l'image";
                            }
                        }
                    }
                }
           else{

             echo "La photo du chauffeur doit etre au format jpg,jpeg,png ou gif";
            
         
            }
        }elseif (isset($_FILES['file_assistant']['tmp_name']) && !isset($_FILES['file_chauffeur']['tmp_name'])) {
            # code...
            $fileAssistant = $_FILES['file_assistant']['tmp_name']; 
        $extensionsAssistant=strtolower(substr(strrchr($_FILES['file_assistant']['name'], '.'),1));
             if(in_array($extensionsAssistant, $extensionsValides)){
                   if(!file_exists('assets/chauffeur/'.$num_cni)){
                            if (mkdir('assets/chauffeur/'.$num_cni, 0777, true) == true) {

                             $uploadImageAssistant = move_uploaded_file($fileAssistant, $folderPath."/".$_FILES['file_assistant']['name']);

                            if($uploadImageAssistant == true){
                                 $query1 = $this->db->query("insert into chauffeur value('','". $nomChauffeur. "','". $cniChauffeur."',CAST('". $expirationCNIChauffeur."' AS DATE),CAST('".$expirationPermisChauffeur."' AS DATE),'".$nomAssistant."','".$cniAssistant."',CAST('".$expirationCNIAssistant."' AS DATE),".$telephoneChauffeur.",".$telephoneAssistant.",'".$permisChauffeur."','','".$_FILES['file_assistant']['name']."')");
                                if($query1 == true){
                                    echo "Insertion parfaite du Chauffeur3";
                                }else{
                                    echo "Erreur durant l'insertion";
                                } 
                            }else{
                                echo "Désolé Erreur lors de l'envoit de l'image";
                            }
                        }
                    }
                }
            else{
                 echo "La photo de l'assistant doit etre au format jpg,jpeg,png ou gif";
            } 
        }elseif (isset($_FILES['file_chauffeur']['tmp_name']) && isset($_FILES['file_assistant']['tmp_name'])) {
            # code...
            $fileChauffeur = $_FILES['file_chauffeur']['tmp_name']; 
            $fileAssistant = $_FILES['file_assistant']['tmp_name']; 
        $extensionsValides = array('jpg','png','gif','jpeg');
        //variable récupérer l’extension du fichier inséré
        $extensionsChauffeur=strtolower(substr(strrchr($_FILES['file_chauffeur']['name'], '.'),1));

        $extensionsAssistant=strtolower(substr(strrchr($_FILES['file_assistant']['name'], '.'),1));
        // echo $extensionsUpload;
            
         if(in_array($extensionsChauffeur, $extensionsValides)){
            if(in_array($extensionsAssistant, $extensionsValides)){
                   if(!file_exists('assets/chauffeur/'.$num_cni)){
                            if (mkdir('assets/chauffeur/'.$num_cni, 0777, true) == true) {

                             $uploadImageChauffeur = move_uploaded_file($fileChauffeur, $folderPath."/".$_FILES['file_chauffeur']['name']);
                             $uploadImageAssistant = move_uploaded_file($fileAssistant, $folderPath."/".$_FILES['file_assistant']['name']);

                            if($uploadImageChauffeur == true && $uploadImageAssistant == true){
                                 $query1 = $this->db->query("insert into chauffeur value('','". $nomChauffeur. "','". $cniChauffeur."',CAST('". $expirationCNIChauffeur."' AS DATE),CAST('".$expirationPermisChauffeur."' AS DATE),'".$nomAssistant."','".$cniAssistant."',CAST('".$expirationCNIAssistant."' AS DATE),".$telephoneChauffeur.",".$telephoneAssistant.",'".$permisChauffeur."','".$_FILES['file_chauffeur']['name']."','".$_FILES['file_assistant']['name']."')");
                                    if($query1 == true){
                                        echo "Insertion parfaite du Chauffeur";
                                    }else{
                                        echo "Erreur durant l'insertion";
                                    }
                            }else{
                                echo "Désolé Erreur lors de l'envoit de l'image";
                            }
                        }
                    }
                }
            else{
                 echo "La photo de l'assistant doit etre au format jpg,jpeg,png ou gif";
            }   
           }else{

             echo "La photo du chauffeur doit etre au format jpg,jpeg,png ou gif";
            
         
            }
        }else{
             $query1 = $this->db->query("insert into chauffeur value('','". $nomChauffeur. "','". $cniChauffeur."',CAST('". $expirationCNIChauffeur."' AS DATE),CAST('".$expirationPermisChauffeur."' AS DATE),'".$nomAssistant."','".$cniAssistant."',CAST('".$expirationCNIAssistant."' AS DATE),".$telephoneChauffeur.",".$telephoneAssistant.",'".$permisChauffeur."','','')");
                    if($query1 == true){
                        echo "Insertion parfaite du Chauffeur5";
                    }else{
                        echo "Erreur durant l'insertion";
                    } 
        }
        

          $this->db->close();      
    }

    public function updateChauffeur($id_chauffeur){
    $id_chauffeur = $_POST["id_chauffeur"];
    $nomChauffeur = $_POST["nomChauffeur"];
    $nomAssistant = $_POST["nomAssistant"];
    $cniChauffeur = $_POST["cniChauffeur"];
    $cniAssistant = $_POST["cniAssistant"];
    $expirationCNIChauffeur = $_POST["expirationCNIChauffeur"];
    $expirationPermisChauffeur = $_POST["expirationPermisChauffeur"];
    $permisChauffeur = $_POST["permisChauffeur"];
    $expirationCNIAssistant = $_POST["expirationCNIAssistant"];
    $telephoneChauffeur = $_POST["telephoneChauffeur"];
    $telephoneAssistant = $_POST["telephoneAssistant"];
    // $expirationPermisAssistant = $_POST["expirationPermisAssistant"];

    $requete = $this->db->query("select * from chauffeur where cni_chauff ='".$cniChauffeur."'")->result_array();
        if (count($requete)>0) {
            # code...
            foreach ($requete as $row) {
                # code...
                if ($row["id_chauffeur"] == $id_chauffeur) {
                    # code...
                    $requete =  $requete = $this->db->query("select * from chauffeur where  num_permis ='".$permisChauffeur."'")->result_array();
            if (count($requete)>0) {
                # code...
                foreach ($requete as $row) {
                    # code...
                    if ($row["num_permis"] == $permisChauffeur) {
                        # code...
                        
                $requete = $this->db->query("select * from chauffeur where telephoneChauffeur =".$telephoneChauffeur."")->result_array();
                if (count($requete)>0) {
                    # code...
                    foreach ($requete as $row) {
                        # code...
                        if ($row["telephoneChauffeur"] == $telephoneChauffeur) {
                            # code...
                            $query1 = $this->db->query("UPDATE chauffeur set nom='".$nomChauffeur."',cni_chauff='".$cniChauffeur."', date_exp_cni_ch=".$expirationCNIChauffeur.",date_exp_cni_ass=".$expirationCNIAssistant.", date_exp_permis_ch=".$expirationPermisChauffeur.", nom_ass='".$nomAssistant."', cni_ass='".$cniAssistant."', num_permis='".$permisChauffeur."', telephoneChauffeur=".$telephoneChauffeur.",telephoneAssistant=".$telephoneAssistant." where id_chauffeur=".$id_chauffeur."");
                    if($query1 == true){
                        echo "Modification parfaite du Chauffeur";
                    }else{
                        echo "Erreur durant La modification";
                    } 
                        }else{
                            echo "Ce numéro de téléphone est déjà utilisé veuillez le changer SVP";
                        }
                    }
                }else{
                     $query1 = $this->db->query("UPDATE chauffeur set nom='".$nomChauffeur."',cni_chauff='".$cniChauffeur."', date_exp_cni_ch=".$expirationCNIChauffeur.",date_exp_cni_ass=".$expirationCNIAssistant.", date_exp_permis_ch=".$expirationPermisChauffeur.", nom_ass='".$nomAssistant."', cni_ass='".$cniAssistant."', num_permis='".$permisChauffeur."', telephoneChauffeur=".$telephoneChauffeur.",telephoneAssistant=".$telephoneAssistant." where id_chauffeur=".$id_chauffeur."");
                    if($query1 == true){
                        echo "Modification parfaite du Chauffeur";
                    }else{
                        echo "Erreur durant La modification";
                    }   
                }
                    }else{
                        echo "Ce permis de conduire est déjà utilisé par un autre chauffeur veuillez changer SVP";
                    }
                }
            }else{
                $requete = $this->db->query("select * from chauffeur where telephoneChauffeur =".$telephoneChauffeur."")->result_array();
                if (count($requete)>0) {
                    # code...
                    foreach ($requete as $row) {
                        # code...
                        if ($row["telephoneChauffeur"] == $telephoneChauffeur) {
                            # code...
                            $query1 = $this->db->query("UPDATE chauffeur set nom='".$nomChauffeur."',cni_chauff='".$cniChauffeur."', date_exp_cni_ch=".$expirationCNIChauffeur.",date_exp_cni_ass=".$expirationCNIAssistant.", date_exp_permis_ch=".$expirationPermisChauffeur.", nom_ass='".$nomAssistant."', cni_ass='".$cniAssistant."', num_permis='".$permisChauffeur."', telephoneChauffeur=".$telephoneChauffeur.",telephoneAssistant=".$telephoneAssistant." where id_chauffeur=".$id_chauffeur."");
                    if($query1 == true){
                        echo "Modification parfaite du Chauffeur";
                    }else{
                        echo "Erreur durant La modification";
                    } 
                        }else{
                            echo "Ce numéro de téléphone est déjà utilisé veuillez le changer SVP";
                        }
                    }
                }else{
                     $query1 = $this->db->query("UPDATE chauffeur set nom='".$nomChauffeur."',cni_chauff='".$cniChauffeur."', date_exp_cni_ch=".$expirationCNIChauffeur.",date_exp_cni_ass=".$expirationCNIAssistant.", date_exp_permis_ch=".$expirationPermisChauffeur.", nom_ass='".$nomAssistant."', cni_ass='".$cniAssistant."', num_permis='".$permisChauffeur."', telephoneChauffeur=".$telephoneChauffeur.",telephoneAssistant=".$telephoneAssistant." where id_chauffeur=".$id_chauffeur."");
                    if($query1 == true){
                        echo "Modification parfaite du Chauffeur";
                    }else{
                        echo "Erreur durant La modification";
                    }   
                }
            }
                }else{
                    echo "Cette CNI est déjà utilisé veuillez changer SVP";
                }
            }
        }else{
            $requete =  $requete = $this->db->query("select * from chauffeur where  num_permis ='".$permisChauffeur."'")->result_array();
            if (count($requete)>0) {
                # code...
                foreach ($requete as $row) {
                    # code...
                    if ($row["num_permis"] == $permisChauffeur) {
                        # code...
                        
                $requete = $this->db->query("select * from chauffeur where telephoneChauffeur =".$telephoneChauffeur."")->result_array();
                if (count($requete)>0) {
                    # code...
                    foreach ($requete as $row) {
                        # code...
                        if ($row["telephoneChauffeur"] == $telephoneChauffeur) {
                            # code...
                            $query1 = $this->db->query("UPDATE chauffeur set nom='".$nomChauffeur."',cni_chauff='".$cniChauffeur."', date_exp_cni_ch=".$expirationCNIChauffeur.",date_exp_cni_ass=".$expirationCNIAssistant.", date_exp_permis_ch=".$expirationPermisChauffeur.", nom_ass='".$nomAssistant."', cni_ass='".$cniAssistant."', num_permis='".$permisChauffeur."', telephoneChauffeur=".$telephoneChauffeur.",telephoneAssistant=".$telephoneAssistant." where id_chauffeur=".$id_chauffeur."");
                    if($query1 == true){
                        echo "Modification parfaite du Chauffeur";
                    }else{
                        echo "Erreur durant La modification";
                    } 
                        }else{
                            echo "Ce numéro de téléphone est déjà utilisé veuillez le changer SVP";
                        }
                    }
                }else{
                     $query1 = $this->db->query("UPDATE chauffeur set nom='".$nomChauffeur."',cni_chauff='".$cniChauffeur."', date_exp_cni_ch=".$expirationCNIChauffeur.",date_exp_cni_ass=".$expirationCNIAssistant.", date_exp_permis_ch=".$expirationPermisChauffeur.", nom_ass='".$nomAssistant."', cni_ass='".$cniAssistant."', num_permis='".$permisChauffeur."', telephoneChauffeur=".$telephoneChauffeur.",telephoneAssistant=".$telephoneAssistant." where id_chauffeur=".$id_chauffeur."");
                    if($query1 == true){
                        echo "Modification parfaite du Chauffeur";
                    }else{
                        echo "Erreur durant La modification";
                    }   
                }
                    }else{
                        echo "Ce permis de conduire est déjà utilisé par un autre chauffeur veuillez changer SVP";
                    }
                }
            }else{
                $requete = $this->db->query("select * from chauffeur where telephoneChauffeur =".$telephoneChauffeur."")->result_array();
                if (count($requete)>0) {
                    # code...
                    foreach ($requete as $row) {
                        # code...
                        if ($row["telephoneChauffeur"] == $telephoneChauffeur) {
                            # code...
                            $query1 = $this->db->query("UPDATE chauffeur set nom='".$nomChauffeur."',cni_chauff='".$cniChauffeur."', date_exp_cni_ch=".$expirationCNIChauffeur.",date_exp_cni_ass=".$expirationCNIAssistant.", date_exp_permis_ch=".$expirationPermisChauffeur.", nom_ass='".$nomAssistant."', cni_ass='".$cniAssistant."', num_permis='".$permisChauffeur."', telephoneChauffeur=".$telephoneChauffeur.",telephoneAssistant=".$telephoneAssistant." where id_chauffeur=".$id_chauffeur."");
                    if($query1 == true){
                        echo "Modification parfaite du Chauffeur";
                    }else{
                        echo "Erreur durant La modification";
                    } 
                        }else{
                            echo "Ce numéro de téléphone est déjà utilisé veuillez le changer SVP";
                        }
                    }
                }else{
                     $query1 = $this->db->query("UPDATE chauffeur set nom='".$nomChauffeur."',cni_chauff='".$cniChauffeur."', date_exp_cni_ch=".$expirationCNIChauffeur.",date_exp_cni_ass=".$expirationCNIAssistant.", date_exp_permis_ch=".$expirationPermisChauffeur.", nom_ass='".$nomAssistant."', cni_ass='".$cniAssistant."', num_permis='".$permisChauffeur."', telephoneChauffeur=".$telephoneChauffeur.",telephoneAssistant=".$telephoneAssistant." where id_chauffeur=".$id_chauffeur."");
                    if($query1 == true){
                        echo "Modification parfaite du Chauffeur";
                    }else{
                        echo "Erreur durant La modification";
                    }   
                }
            }
        }
    

   
    }

public function imageResize($imageResourceId,$width,$height) {


    $targetWidth =355;

    $targetHeight =504;


    $targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);

    imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);


    return $targetLayer;

    }
    public function leSelectChauffeur($table){
         $query1 = $this->db->query("select * from chauffeur where id_chauffeur not in (select id_chauffeur from camion_benne) and id_chauffeur not in(select id_chauffeur from tracteur)")->result_array();
         if (count($query1)>0) {
             # code...
            foreach ($query1 as $row) {
            echo "<option value='".$row["id_chauffeur"]."'>".$row["telephoneChauffeur"]."</option>";
        }
         }else{
            echo "<option value=''>aucun</option>";
         }
        
    }
}