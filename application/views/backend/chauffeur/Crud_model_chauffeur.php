<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model_chauffeur extends CI_Model {
// 
    function __construct() {
        parent::__construct();
        date_default_timezone_set('Africa/Lagos');
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
        
        if (!empty($cniChauffeur)) {
            # code...
            $requete = $this->db->query("select * from chauffeur where cni_chauff ='".$cniChauffeur."'")->result_array();
            if (count($requete)>0) {
            # code...
            return true;
        }else{
            return false;
        }
        }else{
            return false;
        }
        
    }

    public function verifExistPermisChauffeur($permisChauffeur){
        if (!empty($permisChauffeur)) {
            # code...
            $requete = $this->db->query("select * from chauffeur where  num_permis ='".$permisChauffeur."'")->result_array();
        if (count($requete)>0) {
            # code...
            return true;
        }else{
            return false;
        }
        }else{
            return false;
        }
        
    }
    public function verifExistCniAssistant($cniChauffeur){
        if (!empty($cniChauffeur)) {
            # code...
                $requete = $this->db->query("select * from chauffeur where cni_ass ='".$cniChauffeur."'")->result_array();
            if (count($requete)>0) {
                # code...
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
        
    }

    public function boutDeCode(){
        echo "<button type='button' onclick='infosChauffeur(\"".$row['id_chauffeur']."\",\"".$row['num_permis']."\",\"".$row['telephoneChauffeur']."\",\"".$row['telephoneAssistant']."\",\"".$row['nom']."\",\"".$row['nom_ass']."\",\"".$row['cni_chauff']."\",\"".$row['cni_ass']."\",\"".$row['date_exp_cni_ass']."\",\"".$row['date_exp_cni_ch']."\",\"".$row['date_exp_permis_ch']."\");' class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
    }

    public function selectAllChauffeur(){
        $query1 = $this->db->query('SELECT * from chauffeur order by id_chauffeur desc')->result_array();
        $compteur =0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td >".$compteur."</td>";

            $getCodeTracteur = $this->db->query("SELECT * from tracteur where id_chauffeur = ".$row['id_chauffeur']."")->row();

            $getCodeCamion = $this->db->query("SELECT * from camion_benne where id_chauffeur = ".$row['id_chauffeur']."")->row();

            $getCodeEngin = $this->db->query("SELECT * from engin where id_chauffeur = ".$row['id_chauffeur']."")->row();

            $getCodeVoitureService = $this->db->query("SELECT * from voitureservice where id_chauffeur = ".$row['id_chauffeur']."")->row();

            if (count($getCodeTracteur)>0) {
                # code...
                echo "<td >".$getCodeTracteur->code."</td>
                        <td>Tracteur</td>";
            }elseif(count($getCodeCamion)>0){
                echo "<td >".$getCodeCamion->code."</td>
                        <td>Camion benne</td>";
            }elseif(count($getCodeVoitureService)>0){
                echo "<td >".$getCodeVoitureService->code."</td>
                        <td>Voiture service</td>";
            }elseif (count($getCodeEngin)>0) {
                # code...
                echo "<td >".$getCodeEngin->code."</td>
                        <td>Engin</td>";
            }else{

                echo "<td style='color:red;'>Aucun code</td>
                <td style='color:red;'>Aucun véhicule</td>";
            }
            
                  echo"  <td>".$row['nom']."
                    </td>
                    <td>".$row['cni_chauff']."</td>
                   
                    <td> ".$row['num_permis']."</td>
                    <td> ".$row['telephoneChauffeur']."</td>
                    <td> ".$row['nom_ass']."</td>
                    <td> ".$row['cni_ass']."</td>
                    
                    
                    <td> ".$row['telephoneAssistant']."</td>
                    <td>".number_format($row['retenueSalariale'],0,',',' ')."</td>
                    <td>";
                if($this->session->userdata('vehicule_modification')=='true'){
                    echo"
                    <button type='button' onclick='infosChauffeur(\"".$row['id_chauffeur']."\",\"".$row['num_permis']."\",\"".$row['telephoneChauffeur']."\",\"".$row['telephoneAssistant']."\",\"".$row['nom']."\",\"".$row['nom_ass']."\",\"".$row['cni_chauff']."\",\"".$row['cni_ass']."\",\"".$row['date_exp_cni_ass']."\",\"".$row['date_exp_cni_ch']."\",\"".$row['date_exp_permis_ch']."\",\"".$row['photoChauffeur']."\",\"".$row['photoAssistant']."\",\"".number_format($row['salaire'],0,',',' ')."\",\"".number_format($row['salaire_ass'],0,',',' ')."\",\"".$row['date_init']."\",\"".$row['montant_init']."\",\"".number_format($row['retenueSalariale'],0,',',' ')."\");' class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }

                if($this->session->userdata('vehicule_suppression')=='true'){
                    echo"
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='chauffeur' identifiant='".$row['id_chauffeur']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_chauffeur\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  "; }
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
    $salaire = intval(preg_replace('/\s/','', $_POST["salaire"]));
    $salaire_ass = intval(preg_replace('/\s/','', $_POST["salaire_ass"]));
    $expirationCNIAssistant = $_POST["expirationCNIAssistant"];
    $permisChauffeur = $_POST["permisChauffeur"];
    $retenueSalariale=$_POST['retenueSalariale'];
    $date_init = $_POST["date_init"];
        $montant_init = intval(preg_replace('/\s/','', $_POST['montant_init']));

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
         $this->addImageChauffeur($nomChauffeur,$cniChauffeur,$telephoneChauffeur,$expirationCNIChauffeur,$expirationPermisChauffeur,$nomAssistant,$cniAssistant,$expirationCNIAssistant,$telephoneAssistant,$permisChauffeur,$salaire,$salaire_ass,$date_init,$montant_init,$retenueSalariale);
    }
    }elseif ($status == "update") {
        # code...
        $id_chauffeur = $_POST["id_chauffeur"];
        $this->updateChauffeur($id_chauffeur);
    }else{
        echo "Erreur contactez l'administrateur";
    }
    
    
    }

    public function addImageChauffeur($nomChauffeur,$cniChauffeur,$telephoneChauffeur,$expirationCNIChauffeur,$expirationPermisChauffeur,$nomAssistant,$cniAssistant,$expirationCNIAssistant,$telephoneAssistant,$permisChauffeur,$salaire,$salaire_ass,$date_init,$montant_init,$retenueSalariale){
        $num_cni = $telephoneChauffeur;
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
                                 $query1 = $this->db->query("insert into chauffeur value('','". $nomChauffeur. "','". $cniChauffeur."',CAST('". $expirationCNIChauffeur."' AS DATE),CAST('".$expirationPermisChauffeur."' AS DATE),'".$nomAssistant."','".$cniAssistant."',CAST('".$expirationCNIAssistant."' AS DATE),".$telephoneChauffeur.",'".$telephoneAssistant."','".$permisChauffeur."','".$_FILES['file_chauffeur']['name']."','',".$salaire.",".$salaire_ass.",".$montant_init.",CAST('".$date_init."' AS DATE), ".$retenueSalariale.")");
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
                                 $query1 = $this->db->query("insert into chauffeur value('','". $nomChauffeur. "','". $cniChauffeur."',CAST('". $expirationCNIChauffeur."' AS DATE),CAST('".$expirationPermisChauffeur."' AS DATE),'".$nomAssistant."','".$cniAssistant."',CAST('".$expirationCNIAssistant."' AS DATE),".$telephoneChauffeur.",'".$telephoneAssistant."','".$permisChauffeur."','','".$_FILES['file_assistant']['name']."',".$salaire.",".$salaire_ass.",".$montant_init.",CAST('".$date_init."' AS DATE),".$retenueSalariale.")");
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
                                 $query1 = $this->db->query("insert into chauffeur value('','". $nomChauffeur. "','". $cniChauffeur."',CAST('". $expirationCNIChauffeur."' AS DATE),CAST('".$expirationPermisChauffeur."' AS DATE),'".$nomAssistant."','".$cniAssistant."',CAST('".$expirationCNIAssistant."' AS DATE),".$telephoneChauffeur.",'".$telephoneAssistant."','".$permisChauffeur."','".$_FILES['file_chauffeur']['name']."','".$_FILES['file_assistant']['name']."',".$salaire.",".$salaire_ass.",".$montant_init.",CAST('".$date_init."' AS DATE),".$retenueSalariale.")");
                                    if($query1 == true){
                                        echo "Insertion parfaite du Chauffeur";
                                    }else{
                                        echo "Erreur durant l'insertion";
                                    }
                            }else{
                                echo "Désolé Erreur lors de l'envoit de l'image";
                            }
                        }else{
                            echo "echec de creation du dossier";
                        }
                    }else{
                        echo "le dossier existe ".$num_cni;
                    }
                }
            else{
                 echo "La photo de l'assistant doit etre au format jpg,jpeg,png ou gif";
            }   
           }else{

             echo "La photo du chauffeur doit etre au format jpg,jpeg,png ou gif";
            
         
            }
        }else{
             $query1 = $this->db->query("insert into chauffeur value('','". $nomChauffeur. "','". $cniChauffeur."',CAST('". $expirationCNIChauffeur."' AS DATE),CAST('".$expirationPermisChauffeur."' AS DATE),'".$nomAssistant."','".$cniAssistant."',CAST('".$expirationCNIAssistant."' AS DATE),".$telephoneChauffeur.",'".$telephoneAssistant."','".$permisChauffeur."','','',".$salaire.",".$salaire_ass.",".$montant_init.",CAST('".$date_init."' AS DATE),".$retenueSalariale.")");
                    if($query1 == true){
                        echo "Insertion parfaite du Chauffeur";
                    }else{
                        echo "Erreur durant l'insertion";
                    } 
        }
        

          // $this->db->close();      
    }
    public function updateImageChauffeur($id_chauffeur,$nouveauTelephoneChauffeur){
        $requete = $this->db->query("select * from chauffeur where id_chauffeur ='".$id_chauffeur."'")->result_array();
        // $fileChauffeur = $_FILES['file_chauffeur']['tmp_name'];
        // $fileAssistant = $_FILES['file_assistant']['tmp_name'];
        // echo "01";
        $leServeur = $_SERVER['DOCUMENT_ROOT']."/";
        if (count($requete)>0) {
            # code...
            foreach ($requete as $row) {
                # code...
                if ($nouveauTelephoneChauffeur != $row["telephoneChauffeur"]) {
                        # code...
                    if (file_exists('assets/chauffeur/'.$nouveauTelephoneChauffeur)){
                        $renommer = rename($leServeur.'assets/chauffeur/'.$nouveauTelephoneChauffeur, $leServeur.'assets/chauffeur/'.$row["telephoneChauffeur"]);

                        if ($renommer == true) {
                            # code...
                            // echo "renommée";
                        }else{
                            // echo "pas renommée";
                        }
                    }else{
                        mkdir('assets/chauffeur/'.$nouveauTelephoneChauffeur, 0777, true);
                    }
                  }else{
                    if (!file_exists('assets/chauffeur/'.$nouveauTelephoneChauffeur)){
                        mkdir('assets/chauffeur/'.$nouveauTelephoneChauffeur, 0777, true);
                    }
                  }
                // on tester l'existance de l'enregistrement image et au cas ou c'est vide on va creer un fichier et le supprimer durant l'exécution du code juste pour éviter l'erreur due au vide causé par $row["photoChauffeur"] et $row["photoAssistant"]

                $image = imagecreate(200,50);

                if ($row["photoChauffeur"]==""  && $row["photoAssistant"]=="") {
                    # code...
                    if (imagejpeg($image,'assets/chauffeur/'.$row["telephoneChauffeur"].'/test.jpg') == true) {
                        $photoChauffeur = 'test.jpg';
                    }

                    if (imagejpeg($image,'assets/chauffeur/'.$row["telephoneChauffeur"].'/test2.jpg') == true) {
                        $photoAssistant = 'test2.jpg';
                    }
                }elseif ($row["photoAssistant"]=="" && $row["photoChauffeur"]!=="") {
                    # code...
                    if (imagejpeg($image,'assets/chauffeur/'.$row["cni_chauff"].'/test2.jpg') == true) {
                        $photoAssistant = 'test2.jpg';
                    }
                    $photoChauffeur = $row["photoChauffeur"];
                }elseif ($row["photoChauffeur"]=="" && $row["photoAssistant"]!=="") {
                    # code...
                    if (imagejpeg($image,'assets/chauffeur/'.$row["telephoneChauffeur"].'/test.jpg') == true) {
                        $photoChauffeur = 'test.jpg';
                    }
                    $photoAssistant = $row["photoAssistant"];
                }
                else{
                    $photoChauffeur = $row["photoChauffeur"];

                    $photoAssistant = $row["photoAssistant"];

                }

                $folderPath = "assets/chauffeur/".$row["telephoneChauffeur"];
                if (!empty($_FILES['file_assistant']['tmp_name']) && empty($_FILES['file_chauffeur']['tmp_name'])) {
                    # code...
                     $fileAssistant = $_FILES['file_assistant']['tmp_name'];
                    if (file_exists('assets/chauffeur/'.$row["telephoneChauffeur"].'/'.$photoChauffeur)) {
                        # code...
                        $serveur =$leServeur."assets/chauffeur/".$row["telephoneChauffeur"];
        
                        $suppImage = unlink($serveur.'/'.$photoAssistant);

                        if ($suppImage == true) {
                        $this->db->query("UPDATE chauffeur set photoAssistant = '".$_FILES['file_assistant']['name']."' where id_chauffeur=".$id_chauffeur."");
                        move_uploaded_file($fileAssistant, $folderPath."/".$_FILES['file_assistant']['name']);
                        }
                    }
                }elseif (!empty($_FILES['file_chauffeur']['tmp_name']) && empty($_FILES['file_assistant']['tmp_name'])) {
                    # code...
                    $fileChauffeur = $_FILES['file_chauffeur']['tmp_name'];
    
                    if (file_exists('assets/chauffeur/'.$row["telephoneChauffeur"].'/'.$photoChauffeur)) {
                        # code...
                        $serveur =$leServeur."assets/chauffeur/".$row["telephoneChauffeur"];
        
                        $suppImage = unlink($serveur.'/'.$photoChauffeur);

                        if ($suppImage == true) {
                        $this->db->query("UPDATE chauffeur set photoChauffeur = '".$_FILES['file_chauffeur']['name']."' where id_chauffeur=".$id_chauffeur."");
                        move_uploaded_file($fileChauffeur, $folderPath."/".$_FILES['file_chauffeur']['name']);
                        }
                    }
                }elseif (empty($_FILES['file_chauffeur']['tmp_name']) && empty($_FILES['file_assistant']['tmp_name'])) {
                    # code...

                }
                else{

                    $fileChauffeur = $_FILES['file_chauffeur']['tmp_name'];
                    $fileAssistant = $_FILES['file_assistant']['tmp_name'];

                    if (!file_exists('assets/chauffeur/'.$row["telephoneChauffeur"].'/'.$row["photoChauffeur"]) && !file_exists('assets/chauffeur/'.$row["telephoneChauffeur"].'/'.$row["photoAssistant"])) {
                      
                        $this->db->query("UPDATE chauffeur set photoChauffeur = '".$_FILES['file_chauffeur']['name']."',photoAssistant = '".$_FILES['file_assistant']['name']."' where id_chauffeur=".$id_chauffeur."");
                        move_uploaded_file($fileChauffeur, $folderPath."/".$_FILES['file_chauffeur']['name']);
                        move_uploaded_file($fileAssistant, $folderPath."/".$_FILES['file_assistant']['name']);
                    }elseif (!file_exists('assets/chauffeur/'.$row["telephoneChauffeur"].'/'.$photoChauffeur) && file_exists('assets/chauffeur/'.$row["telephoneChauffeur"].'/'.$photoAssistant)) {
                        # code...

                        $serveur = $leServeur."assets/chauffeur/".$row["telephoneChauffeur"];
                        unlink($serveur.'/'.$photoAssistant);
                        $this->db->query("UPDATE chauffeur set photoChauffeur = '".$_FILES['file_chauffeur']['name']."',photoAssistant = '".$_FILES['file_assistant']['name']."' where id_chauffeur=".$id_chauffeur."");
                        move_uploaded_file($fileChauffeur, $folderPath."/".$_FILES['file_chauffeur']['name']);
                        move_uploaded_file($fileAssistant, $folderPath."/".$_FILES['file_assistant']['name']);

                    }elseif (file_exists('assets/chauffeur/'.$row["telephoneChauffeur"].'/'.$row["photoChauffeur"]) && !file_exists('assets/chauffeur/'.$row["telephoneChauffeur"].'/'.$photoAssistant)) {
                        # code...

                        $serveur =$leServeur."assets/chauffeur/".$row["telephoneChauffeur"];
                        unlink($serveur.'/'.$photoChauffeur);
                        $this->db->query("UPDATE chauffeur set photoChauffeur = '".$_FILES['file_chauffeur']['name']."',photoAssistant = '".$_FILES['file_assistant']['name']."' where id_chauffeur=".$id_chauffeur."");
                        move_uploaded_file($fileChauffeur, $folderPath."/".$_FILES['file_chauffeur']['name']);
                        move_uploaded_file($fileAssistant, $folderPath."/".$_FILES['file_assistant']['name']);
                    }else{

                        $serveur = $leServeur."assets/chauffeur/".$row["telephoneChauffeur"];
                        unlink($serveur.'/'.$photoChauffeur);
                        unlink($serveur.'/'.$photoAssistant);

                        $this->db->query("UPDATE chauffeur set photoChauffeur = '".$_FILES['file_chauffeur']['name']."',photoAssistant = '".$_FILES['file_assistant']['name']."' where id_chauffeur=".$id_chauffeur."");
                        move_uploaded_file($fileChauffeur, $folderPath."/".$_FILES['file_chauffeur']['name']);
                        move_uploaded_file($fileAssistant, $folderPath."/".$_FILES['file_assistant']['name']);
                    }
                }
            }
        }

    }
    public function updateChauffeur($id_chauffeur){
    $id_chauffeur = $_POST["id_chauffeur"];
    $nomChauffeur = $_POST["nomChauffeur"];
    $nomAssistant = $_POST["nomAssistant"];
    $cniChauffeur = $_POST["cniChauffeur"];
    $cniAssistant = $_POST["cniAssistant"];
    $ancienTelephoneChauffeur = $_POST["ancienTelephone"];
    $expirationCNIChauffeur = $_POST["expirationCNIChauffeur"];
    $expirationPermisChauffeur = $_POST["expirationPermisChauffeur"];
    $permisChauffeur = $_POST["permisChauffeur"];
    $expirationCNIAssistant = $_POST["expirationCNIAssistant"];
    $telephoneChauffeur = $_POST["telephoneChauffeur"];
    $telephoneAssistant = $_POST["telephoneAssistant"];
    $retenueSalariale = intval(preg_replace('/\s/','', $_POST["retenueSalariale"]));
    $salaire = intval(preg_replace('/\s/','', $_POST["salaire"]));
    $salaire_ass = intval(preg_replace('/\s/','', $_POST["salaire_ass"]));
    // $expirationPermisAssistant = $_POST["expirationPermisAssistant"];
$date_init = $_POST["date_init"];
        $montant_init = intval(preg_replace('/\s/','', $_POST['montant_init']));
    
    if (!empty($cniChauffeur)) {
        # code...
        $requete = $this->db->query("select * from chauffeur where cni_chauff ='".$cniChauffeur."' and id_chauffeur!=".$id_chauffeur." limit 1")->result_array();
    }else{
        $requete = array();
    }
        if (count($requete)>0) {
            # code...
            foreach ($requete as $row) {
                # code...
                if ($row["id_chauffeur"] == $id_chauffeur) {
                    # code...
                     $requete = $this->db->query("select * from chauffeur where  num_permis ='".$permisChauffeur."' and id_chauffeur!=".$id_chauffeur." limit 1")->result_array();
            if (count($requete)>0) {
                # code...
                foreach ($requete as $row) {
                    # code...
                    if ($row["id_chauffeur"] == $id_chauffeur) {
                        # code...
                        
                $requete = $this->db->query("select * from chauffeur where telephoneChauffeur =".$telephoneChauffeur." and id_chauffeur!=".$id_chauffeur." limit 1")->result_array();
                if (count($requete)>0) {
                    # code...
                    foreach ($requete as $row) {
                        # code...
                        if ($row["id_chauffeur"] == $id_chauffeur) {
                            # code...
                            $query1 = $this->db->query("UPDATE chauffeur set nom='".$nomChauffeur."',cni_chauff='".$cniChauffeur."', date_exp_cni_ch=CAST('".$expirationCNIChauffeur."' AS DATE),date_exp_cni_ass=CAST('".$expirationCNIAssistant."' AS DATE), date_exp_permis_ch=CAST('".$expirationPermisChauffeur."' AS DATE), nom_ass='".$nomAssistant."', cni_ass='".$cniAssistant."', num_permis='".$permisChauffeur."', telephoneChauffeur=".$telephoneChauffeur.",telephoneAssistant=".$telephoneAssistant.",salaire=".$salaire.",salaire_ass=".$salaire_ass.",CAST('". $date_init."' AS DATE), montant_init = ".$montant_init.", retenueSalariale =".$retenueSalariale." where id_chauffeur=".$id_chauffeur."");
                    if($query1 == true){
                        echo "Modification parfaite du Chauffeur";
                        if(!file_exists('assets/chauffeur/'.$cniChauffeur)){
                            if (mkdir('assets/chauffeur/'.$cniChauffeur, 0777, true) == true) {
                                $this->updateImageChauffeur($id_chauffeur,$ancienTelephoneChauffeur);
                            }
                        }else{
                            $this->updateImageChauffeur($id_chauffeur,$ancienTelephoneChauffeur);
                        }
                        
                    }else{
                        echo "Erreur durant La modification";
                    } 
                        }else{
                            echo "Ce numéro de téléphone est déjà utilisé veuillez le changer SVP";
                        }
                    }
                }else{
                     $query1 = $this->db->query("UPDATE chauffeur set nom='".$nomChauffeur."',cni_chauff='".$cniChauffeur."', date_exp_cni_ch=CAST('".$expirationCNIChauffeur."' AS DATE),date_exp_cni_ass=CAST('".$expirationCNIAssistant."' AS DATE), date_exp_permis_ch=CAST('".$expirationPermisChauffeur."' AS DATE), nom_ass='".$nomAssistant."', cni_ass='".$cniAssistant."', num_permis='".$permisChauffeur."', telephoneChauffeur=".$telephoneChauffeur.",telephoneAssistant=".$telephoneAssistant.",salaire=".$salaire.",salaire_ass=".$salaire_ass.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init.", retenueSalariale =".$retenueSalariale." where id_chauffeur=".$id_chauffeur."");
                    if($query1 == true){
                        echo "Modification parfaite du Chauffeur";
                          
                          if(!file_exists('assets/chauffeur/'.$cniChauffeur)){
                            if (mkdir('assets/chauffeur/'.$cniChauffeur, 0777, true) == true) {
                                $this->updateImageChauffeur($id_chauffeur,$ancienTelephoneChauffeur);
                            }
                        }else{
                            $this->updateImageChauffeur($id_chauffeur,$ancienTelephoneChauffeur);
                        }
                    }else{
                        echo "Erreur durant La modification";
                    }   
                }
                    }else{
                        echo "Ce permis de conduire est déjà utilisé par un autre chauffeur veuillez changer SVP";
                    }
                }
            }else{
                $requete = $this->db->query("select * from chauffeur where telephoneChauffeur =".$telephoneChauffeur." and id_chauffeur!=".$id_chauffeur." limit 1")->result_array();
                if (count($requete)>0) {
                    # code...
                    foreach ($requete as $row) {
                        # code...
                        if ($row["id_chauffeur"] == $id_chauffeur) {
                            # code...
                            $query1 = $this->db->query("UPDATE chauffeur set nom='".$nomChauffeur."',cni_chauff='".$cniChauffeur."', date_exp_cni_ch=CAST('".$expirationCNIChauffeur."' AS DATE),date_exp_cni_ass=CAST('".$expirationCNIAssistant."' AS DATE), date_exp_permis_ch=CAST('".$expirationPermisChauffeur."' AS DATE), nom_ass='".$nomAssistant."', cni_ass='".$cniAssistant."', num_permis='".$permisChauffeur."', telephoneChauffeur=".$telephoneChauffeur.",telephoneAssistant=".$telephoneAssistant.",salaire=".$salaire.",salaire_ass=".$salaire_ass.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init.", retenueSalariale =".$retenueSalariale." where id_chauffeur=".$id_chauffeur."");
                    if($query1 == true){
                        echo "Modification parfaite du Chauffeur";

                          if(!file_exists('assets/chauffeur/'.$cniChauffeur)){
                            if (mkdir('assets/chauffeur/'.$cniChauffeur, 0777, true) == true) {
                                $this->updateImageChauffeur($id_chauffeur,$ancienTelephoneChauffeur);
                            }
                        }else{
                            $this->updateImageChauffeur($id_chauffeur,$ancienTelephoneChauffeur);
                        }

                    }else{
                        echo "Erreur durant La modification";
                    } 
                        }else{
                            echo "Ce numéro de téléphone est déjà utilisé veuillez le changer SVP";
                        }
                    }
                }else{
                     $query1 = $this->db->query("UPDATE chauffeur set nom='".$nomChauffeur."',cni_chauff='".$cniChauffeur."',  date_exp_cni_ch=CAST('".$expirationCNIChauffeur."' AS DATE),date_exp_cni_ass=CAST('".$expirationCNIAssistant."' AS DATE), date_exp_permis_ch=CAST('".$expirationPermisChauffeur."' AS DATE), nom_ass='".$nomAssistant."', cni_ass='".$cniAssistant."', num_permis='".$permisChauffeur."', telephoneChauffeur=".$telephoneChauffeur.",telephoneAssistant=".$telephoneAssistant.",salaire=".$salaire.",salaire_ass=".$salaire_ass.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init.", retenueSalariale =".$retenueSalariale." where id_chauffeur=".$id_chauffeur."");
                    if($query1 == true){
                        echo "Modification parfaite du Chauffeur";

                         if(!file_exists('assets/chauffeur/'.$cniChauffeur)){
                            if (mkdir('assets/chauffeur/'.$cniChauffeur, 0777, true) == true) {
                                $this->updateImageChauffeur($id_chauffeur,$ancienTelephoneChauffeur);
                            }
                        }else{
                            $this->updateImageChauffeur($id_chauffeur,$ancienTelephoneChauffeur);
                        }

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
            if (!empty($permisChauffeur)) {
                # code...
                $requete1 = $this->db->query("select * from chauffeur where  num_permis ='".$permisChauffeur."' and id_chauffeur!=".$id_chauffeur." limit 1")->result_array();
            }else{
                $requete1  = array();
            }
            // $requete1 = $this->db->query("select * from chauffeur where  num_permis ='".$permisChauffeur."'")->result_array();
            if (count($requete1)>0) {
                # code...
                foreach ($requete1 as $row) {
                    # code...
                    if ($row["id_chauffeur"] == $id_chauffeur) {
                        # code...
                        
                $requete = $this->db->query("select * from chauffeur where telephoneChauffeur =".$telephoneChauffeur." and id_chauffeur!=".$id_chauffeur." limit 1")->result_array();
                if (count($requete)>0) {
                    # code...
                    foreach ($requete as $row) {
                        # code...
                        if ($row["id_chauffeur"] == $id_chauffeur) {
                            # code...
                            $query1 = $this->db->query("UPDATE chauffeur set nom='".$nomChauffeur."',cni_chauff='".$cniChauffeur."',  date_exp_cni_ch=CAST('".$expirationCNIChauffeur."' AS DATE),date_exp_cni_ass=CAST('".$expirationCNIAssistant."' AS DATE), date_exp_permis_ch=CAST('".$expirationPermisChauffeur."' AS DATE), nom_ass='".$nomAssistant."', cni_ass='".$cniAssistant."', num_permis='".$permisChauffeur."', telephoneChauffeur=".$telephoneChauffeur.",telephoneAssistant=".$telephoneAssistant.",salaire=".$salaire.",salaire_ass=".$salaire_ass.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init.", retenueSalariale =".$retenueSalariale." where id_chauffeur=".$id_chauffeur."");
                    if($query1 == true){
                        echo "Modification parfaite du Chauffeur";

                          if(!file_exists('assets/chauffeur/'.$cniChauffeur)){
                            if (mkdir('assets/chauffeur/'.$cniChauffeur, 0777, true) == true) {
                                $this->updateImageChauffeur($id_chauffeur,$ancienTelephoneChauffeur);
                            }
                        }else{
                            $this->updateImageChauffeur($id_chauffeur,$ancienTelephoneChauffeur);
                        }

                    }else{
                        echo "Erreur durant La modification";
                    } 
                        }else{
                            echo "Ce numéro de téléphone est déjà utilisé veuillez le changer SVP";
                        }
                    }
                }else{
                     $query1 = $this->db->query("UPDATE chauffeur set nom='".$nomChauffeur."',cni_chauff='".$cniChauffeur."', date_exp_cni_ch=CAST('".$expirationCNIChauffeur."' AS DATE),date_exp_cni_ass=CAST('".$expirationCNIAssistant."' AS DATE), date_exp_permis_ch=CAST('".$expirationPermisChauffeur."' AS DATE), nom_ass='".$nomAssistant."', cni_ass='".$cniAssistant."', num_permis='".$permisChauffeur."', telephoneChauffeur=".$telephoneChauffeur.",telephoneAssistant=".$telephoneAssistant.",salaire=".$salaire.",salaire_ass=".$salaire_ass.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init.", retenueSalariale =".$retenueSalariale." where id_chauffeur=".$id_chauffeur."");
                    if($query1 == true){
                        echo "Modification parfaite du Chauffeur";

                          if(!file_exists('assets/chauffeur/'.$cniChauffeur)){
                            if (mkdir('assets/chauffeur/'.$cniChauffeur, 0777, true) == true) {
                                $this->updateImageChauffeur($id_chauffeur,$ancienTelephoneChauffeur);
                            }
                        }else{
                            $this->updateImageChauffeur($id_chauffeur,$ancienTelephoneChauffeur);
                        }

                    }else{
                        echo "Erreur durant La modification";
                    }   
                }
                    }else{
                        echo "Ce permis de conduire est déjà utilisé par un autre chauffeur veuillez changer SVP";
                    }
                }
            }else{
                $requete = $this->db->query("select * from chauffeur where telephoneChauffeur =".$telephoneChauffeur." and id_chauffeur!=".$id_chauffeur." limit 1")->result_array();
                if (count($requete)>0) {
                    # code...
                    foreach ($requete as $row) {
                        # code...
                        if ($row["id_chauffeur"] == $id_chauffeur) {
                            # code...
                            $query1 = $this->db->query("UPDATE chauffeur set nom='".$nomChauffeur."',cni_chauff='".$cniChauffeur."',  date_exp_cni_ch=CAST('".$expirationCNIChauffeur."' AS DATE),date_exp_cni_ass=CAST('".$expirationCNIAssistant."' AS DATE), date_exp_permis_ch=CAST('".$expirationPermisChauffeur."' AS DATE), nom_ass='".$nomAssistant."', cni_ass='".$cniAssistant."', num_permis='".$permisChauffeur."', telephoneChauffeur=".$telephoneChauffeur.",telephoneAssistant=".$telephoneAssistant.",salaire=".$salaire.",salaire_ass=".$salaire_ass.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init.", retenueSalariale =".$retenueSalariale." where id_chauffeur=".$id_chauffeur."");
                    if($query1 == true){
                        echo "Modification parfaite du Chauffeur";

                          if(!file_exists('assets/chauffeur/'.$cniChauffeur)){
                            if (mkdir('assets/chauffeur/'.$cniChauffeur, 0777, true) == true) {
                                $this->updateImageChauffeur($id_chauffeur,$ancienTelephoneChauffeur);
                            }
                        }else{
                            $this->updateImageChauffeur($id_chauffeur,$ancienTelephoneChauffeur);
                        }

                    }else{
                        echo "Erreur durant La modification";
                    } 
                        }else{
                            echo "Ce numéro de téléphone est déjà utilisé veuillez le changer SVP";
                        }
                    }
                }else{
                     $query1 = $this->db->query("UPDATE chauffeur set nom='".$nomChauffeur."',cni_chauff='".$cniChauffeur."', date_exp_cni_ch=CAST('".$expirationCNIChauffeur."' AS DATE),date_exp_cni_ass=CAST('".$expirationCNIAssistant."' AS DATE), date_exp_permis_ch=CAST('".$expirationPermisChauffeur."' AS DATE), nom_ass='".$nomAssistant."', cni_ass='".$cniAssistant."', num_permis='".$permisChauffeur."', telephoneChauffeur=".$telephoneChauffeur.",telephoneAssistant=".$telephoneAssistant.",salaire=".$salaire.",salaire_ass=".$salaire_ass.",date_init=CAST('". $date_init."' AS DATE), montant_init = ".$montant_init.", retenueSalariale =".$retenueSalariale." where id_chauffeur=".$id_chauffeur."");
                    if($query1 == true){
                        echo "Modification parfaite du Chauffeur";
                        $this->updateImageChauffeur($id_chauffeur,$ancienTelephoneChauffeur);
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
         $query1 = $this->db->query("select * from chauffeur where id_chauffeur not in (select id_chauffeur from camion_benne) and id_chauffeur not in(select id_chauffeur from tracteur) and id_chauffeur not in (select id_chauffeur from engin) and id_chauffeur not in (select id_chauffeur from voitureservice)")->result_array();
         if (count($query1)>0) {
             # code...
            foreach ($query1 as $row) {
            echo "<option value='".$row["id_chauffeur"]."'>".$row['telephoneChauffeur']."</option>";
        }
         }else{
            echo "<option value=''>aucun</option>";
         }
        
    }
public function leSelectChauffeur2(){
         $query1 = $this->db->query("select * from chauffeur")->result_array();
         if (count($query1)>0) {
             # code...
            foreach ($query1 as $row) {
            echo "<option value='".$row["id_chauffeur"]."'>".$row['telephoneChauffeur']."</option>";
        }
         }else{
            echo "<option value=''>aucun</option>";
         }
        
    }
 public function leSelectChauffeurPourBalance(){
         $query1 = $this->db->query("SELECT * from chauffeur ")->result_array();
         if (count($query1)>0) {
             # code...
            foreach ($query1 as $row) {
            echo "<option value='".$row["id_chauffeur"]."'>".$row['nom']."</option>";
        }
         }else{
            echo "<option value=''>aucun</option>";
         }
        
    }

    public function getNomChauffeur($id_chauffeur){

        $getChauffeur = $this->db->query("SELECT * from chauffeur where id_chauffeur =".$id_chauffeur."")->row();

        if (count($getChauffeur)>0) {
            # code...
            return $getChauffeur->nom;
        }else{
            return "Aucun";
        }
    }

    public function getChauffeurParCodeCamion(){
        $code_camion = $_POST["code_camion"];
        
        $getTracteur = $this->db->query("SELECT * from tracteur where code = '".$code_camion."'")->row();
        
        $getCamionBenne = $this->db->query("SELECT * from camion_benne where code ='".$code_camion."'")->row();

        $getEngin = $this->db->query("SELECT * from engin where code ='".$code_camion."'")->row();
         
         if (count($getTracteur) >0) {
             # code...
            echo "<option value='".$getTracteur->id_chauffeur."'>".$this->getNomChauffeur($getTracteur->id_chauffeur)."</option>";
         }elseif (count($getCamionBenne) > 0) {
             # code...
            echo "<option value='".$getCamionBenne->id_chauffeur."'>".$this->getNomChauffeur($getCamionBenne->id_chauffeur)."</option>";
         }elseif (count($getEngin) >0) {
             # code...
            echo "<option value='".$getEngin->id_chauffeur."'>".$this->getNomChauffeur($getEngin->id_chauffeur)."</option>";

         }else{
            echo "<option>Aucun</option>";
         }
    }

    public function getCamionParChauffeur($id_chauffeur){
        
        $getTracteur = $this->db->query("SELECT * from tracteur where id_chauffeur = ".$id_chauffeur."")->row();
        
        $getCamionBenne = $this->db->query("SELECT * from camion_benne where id_chauffeur = ".$id_chauffeur."")->row();

        $getEngin = $this->db->query("SELECT * from engin where id_chauffeur = ".$id_chauffeur."")->row();
         
         if (count($getTracteur) >0) {
             # code...
            echo "<td>".$getTracteur->code."</td>";
         }elseif (count($getCamionBenne) > 0) {
             # code...
            echo "<td>".$getCamionBenne->code."</td>";
         }elseif (count($getEngin) >0) {
             # code...
            echo "<td>".$getEngin->code."</td>";

         }else{
            echo "<td>Aucun</td>";
         }
    }

    public function getSalaireChauffeur1($id_chauffeur){
        $getChauffeur = $this->db->query("SELECT * from chauffeur where id_chauffeur =".$id_chauffeur."")->row();

        if (count($getChauffeur)>0) {
            # code...
            return $getChauffeur->salaire;
        }else{
            return "0";
        }
    }
    public function getSalaireChauffeur(){
        $code_camion = $_POST["code_camion"];
        
        $getTracteur = $this->db->query("SELECT * from tracteur where code = '".$code_camion."'")->row();
        
        $getCamionBenne = $this->db->query("SELECT * from camion_benne where code ='".$code_camion."'")->row();

        $getEngin = $this->db->query("SELECT * from engin where code ='".$code_camion."'")->row();
         
         if (count($getTracteur) >0) {
             # code...
            echo $this->getSalaireChauffeur1($getTracteur->id_chauffeur);
         }elseif (count($getCamionBenne) > 0) {
             # code...
            echo $this->getSalaireChauffeur1($getCamionBenne->id_chauffeur);
         }elseif (count($getEngin) >0) {
             # code...
            echo $this->getSalaireChauffeur1($getEngin->id_chauffeur);

         }else{
            echo "<option>Aucun</option>";
         }  

         }

        public function addImputationChauffeur(){
        $status = $_POST["status"];
        $raison = addslashes($_POST["raison"]);
         $montant = preg_replace('/\s/','', $_POST["montant"]);
        $cible = $_POST['cible'];
         $salaire = intval(preg_replace('/\s/','', $_POST["salaire"]));
        $date = $_POST["date"];
        // $retenurSalariale =  preg_replace('/\s/','', $_POST["retenurSalariale"]);
        $id_chauffeur = $_POST['id_chauffeur'];
       


        if ($status == "insert") {
            # code...
           
                $insertImputation = $this->db->query("INSERT INTO imputation_salaire value('',".$id_chauffeur.",".$salaire.",CAST('". $date."' AS DATE),".$montant.",'".$raison."','".$cible."')");
                if ($insertImputation == true) {
                    # code...
                    echo "Insertion parfaite de l'imputation";
                }else{
                    echo "Erreur d'insertion";
                }
            
        }elseif ($status == "update") {
            # code...
            $id_facture = $_POST["id_imputation"];
          
                 $update = $this->db->query("UPDATE imputation_salaire set  id_chauffeur =".$id_chauffeur.",date_imputation = CAST('". $date."' AS DATE),salaire = ".$salaire.",montant = ".$montant.",raison='".$raison."', cible='".$cible."' where id_imputation=".$id_facture."");
                if ($update == true ) {
                    # code...
                    echo "Imputation modifiée";
                }else{
                    echo "Erreur lors de la modification";
                }
            
        }else{
            echo "Erreur fatale";
        }
    }

     public function addReglementImputation(){
        $status = $_POST["status"];
        $raison = addslashes($_POST["raison"]);
         $montant = preg_replace('/\s/','', $_POST["montant"]);
         $cible = $_POST['cible'];
         $regulation = preg_replace('/\s/','', $_POST["regulation"]);
         $salaire = intval(preg_replace('/\s/','', $_POST["salaire"]));
        $date = $_POST["date"];
        $id_chauffeur = $_POST['id_chauffeur'];
       


        if ($status == "insert") {
            # code...
           
                $insertImputation = $this->db->query("INSERT INTO reglement_imputation value('',".$id_chauffeur.",".$salaire.",CAST('". $date."' AS DATE),".$montant.",'".$raison."',".$regulation.",'".$cible."')");
                if ($insertImputation == true) {
                    # code...
                    echo "Insertion parfaite du règlement";
                }else{
                    echo "Erreur d'insertion";
                }
            
        }elseif ($status == "update") {
            # code...
            $id_facture = $_POST["id_imputation"];
          
                 $update = $this->db->query("UPDATE reglement_imputation set  id_chauffeur =".$id_chauffeur.",date_imputation = CAST('". $date."' AS DATE),salaire = ".$salaire.",montant = ".$montant.",raison='".$raison."',regulation = ".$regulation.", cible='".$cible."' where id_reglement=".$id_facture."");
                if ($update == true ) {
                    # code...
                    echo "règlement modifiée";
                }else{
                    echo "Erreur lors de la modification";
                }
            
        }else{
            echo "Erreur fatale";
        }
    }

     public function getAllImputationSalaire(){
         $query1 = $this->db->query('SELECT * from  imputation_salaire order by date_imputation desc')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                     
                     $getFournisseur = $this->db->query("select * from chauffeur where id_chauffeur = ".$row["id_chauffeur"]."")->row();

                     if (count($getFournisseur)>0) {
                         # code...
                        echo"
                    <td> ".$getFournisseur->nom." </td>";
                     }else{
                         echo"
                    <td> </td>";
                     }

                    echo $this->getCamionParChauffeur($row['id_chauffeur'])."
                    <td>".number_format($row['salaire'],0,',',' ')."</td>
                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td>".$row['cible']."</td> 
                    <td>".$row['date_imputation']."</td>
                    <td>".addslashes($row['raison'])." </td>
                    <td>";

                 if($this->session->userdata('chauffeur_modification')=='true'){
                    echo"<button type='button' onclick=\"infosImputation('".$row['id_imputation']."','".addslashes($row['raison'])."','".$row['date_imputation']."','".number_format($row['salaire'],0,',',' ')."','".number_format($row['montant'],0,',',' ')."','<option value=".$row['id_chauffeur'].">".$this->getNomChauffeur($row['id_chauffeur'])."</option>','".$row['cible']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";}
                 if($this->session->userdata('chauffeur_suppression')=='true'){
                  echo"
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='imputation_salaire' identifiant='".$row['id_imputation']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_imputation\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
        }
    }

    public function getAllReglementImputation(){
         $query1 = $this->db->query('SELECT * from  reglement_imputation order by date_imputation desc')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                     
                     $getFournisseur = $this->db->query("select * from chauffeur where id_chauffeur = ".$row["id_chauffeur"]."")->row();

                    if (count($getFournisseur) > 0) {
                        # code...
                        echo"
                    <td> ".$getFournisseur->nom." </td>
                    ";
                    }else{
                        echo"
                    <td>  </td>
                    ";
                    }
                    
                    echo $this->getCamionParChauffeur($row['id_chauffeur'])."
                    <td>".number_format($row['salaire'],0,',',' ')."</td>
                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td>".number_format($row['regulation'],0,',',' ')."</td>
                    <td>".$row['cible']."</td>
                    <td>".$row['date_imputation']."</td>
                    <td>".addslashes($row['raison'])." </td>
                    <td>";

                if($this->session->userdata('chauffeur_modification')=='true'){

                  echo" <button type='button' onclick=\"infosImputation('".$row['id_reglement']."','".addslashes($row['raison'])."','".$row['date_imputation']."','".number_format($row['salaire'],0,',',' ')."','".number_format($row['montant'],0,',',' ')."','<option value=".$row['id_chauffeur'].">".$this->getNomChauffeur($row['id_chauffeur'])."</option>','".$row['cible']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";}
                if($this->session->userdata('chauffeur_suppression')=='true'){
                   
                   echo" <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='reglement_imputation' identifiant='".$row['id_reglement']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_reglement\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
              }
                  $compteur++;
        }
    }


// nous allons gérer la balance en fonction du modèle de celui des article

    public function selectAllFacturePourBalance(){
        $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM imputation_salaire WHERE  id_chauffeur='.$id_fournisseur.' order by date_imputation')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM imputation_salaire WHERE  date_imputation>="'.$date_debut.'" order by date_imputation')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM imputation_salaire WHERE  date_imputation<="'.$date_fin.'" order by date_imputation')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM imputation_salaire WHERE  date_imputation between "'.$date_debut.'" and "'.$date_fin.'" order by date_imputation')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM imputation_salaire WHERE  date_imputation between "'.$date_debut.'" and "'.$date_fin.'" and id_chauffeur='.$id_fournisseur.' order by date_imputation')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM imputation_salaire WHERE  date_imputation<="'.$date_fin.'" and id_chauffeur='.$id_fournisseur.' order by date_imputation')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM imputation_salaire WHERE  date_imputation="'.$date_debut.'" and id_chauffeur='.$id_fournisseur.' order by date_imputation')->result_array();

        }
         $compteur = 0;
         $montant = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";
                    $this->getCamionParChauffeur($row['id_chauffeur']);
                    echo "
                    <td>".$row['raison']."</td>
                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td> ".$row['date_imputation']." </td>
                   
                  </tr>

                  ";
                  $montant = $montant+$row['montant'];
        }
    }

            public function selectAllTotalFacturePourBalanceFournisseur(){
        $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM imputation_salaire WHERE  id_chauffeur='.$id_fournisseur.' order by date_imputation')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM imputation_salaire WHERE  date_imputation>="'.$date_debut.'" order by date_imputation')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM imputation_salaire WHERE  date_imputation<="'.$date_fin.'" order by date_imputation')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM imputation_salaire WHERE  date_imputation between "'.$date_debut.'" and "'.$date_fin.'" order by date_imputation')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM imputation_salaire WHERE  date_imputation between "'.$date_debut.'" and "'.$date_fin.'" and id_chauffeur='.$id_fournisseur.' order by date_imputation')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM imputation_salairee WHERE  date_imputation<="'.$date_fin.'" and id_chauffeur='.$id_fournisseur.' order by date_imputation')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM imputation_salaire WHERE  date_imputation="'.$date_debut.'" and id_chauffeur='.$id_fournisseur.' order by date_imputation')->result_array();

        }
         $compteur = 0;
         $montant = 0;
        foreach ($query1 as $row) {
            # code...
                  $montant = $montant+$row['montant'];
        }
    return $montant;
    }



    public function selectAllReglementPourBalance(){
         $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
       if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_imputation  WHERE  id_chauffeur='.$id_fournisseur.' order by date_imputation')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_imputation WHERE  date_imputation>="'.$date_debut.'" order by date_imputation')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code... 
             $query1 = $this->db->query('SELECT * FROM reglement_imputation WHERE  date_imputation<="'.$date_fin.'" order by date_imputation')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_imputation WHERE  date_imputation between "'.$date_debut.'" and "'.$date_fin.'" order by date_imputation')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_imputation WHERE  date_imputation between "'.$date_debut.'" and "'.$date_fin.'" and id_chauffeur='.$id_fournisseur.' order by date_imputation')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_imputation WHERE  date_imputation<="'.$date_fin.'" and id_chauffeur='.$id_fournisseur.' order by date_imputation')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_imputation WHERE  date_imputation="'.$date_debut.'" and id_chauffeur='.$id_fournisseur.' order by date_imputation')->result_array();

        }
         $compteur = 0;
         $montant = 0;
        foreach ($query1 as $tab) {
            # code...
                              echo "<tr >
                    
                    <td> ".$compteur."</td>";
                   $this->getCamionParChauffeur($tab['id_chauffeur']);
                             echo"
                               <td>".$tab['raison']."</td>
                    <td>".number_format($tab['montant'],0,',',' ')."</td>
                    <td> ".$tab['date_imputation']." </td>
                                
                              </tr>

                              ";

                               $compteur++;
                               $montant = $montant+$tab['montant'];
                         
        }

       
    }
     public function selectAllTotalReglementPourBalanceFournisseur(){
         $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
       if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_imputation  WHERE  id_chauffeur='.$id_fournisseur.' order by date_imputation')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_imputation  WHERE  date_imputation>="'.$date_debut.'" order by date_imputation')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_imputation WHERE  date_imputation<="'.$date_fin.'" order by date_imputation')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_imputation WHERE  date_imputation between "'.$date_debut.'" and "'.$date_fin.'" order by date_imputation')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_imputation WHERE  date_imputation between "'.$date_debut.'" and "'.$date_fin.'" and id_chauffeur='.$id_fournisseur.' order by date_imputation')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_imputation WHERE  date_imputation<="'.$date_fin.'" and id_chauffeur='.$id_fournisseur.' order by date_imputation')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_imputation WHERE  date_imputation="'.$date_debut.'" and id_chauffeur='.$id_fournisseur.' order by date_imputation')->result_array();

        }
         $compteur = 0;
         $montant = 0;
        foreach ($query1 as $tab) {
           
             $montant = $montant+$tab['montant'];
                         
        }
        return $montant;
    }

    public function getMontantInitialParChauffeur(){
   $code = $_POST["id_fournisseur"];
    $getTracteur = $this->db->query("SELECT * from chauffeur where id_chauffeur ='".$code."' limit 1")->row();

    if (count($getTracteur)>0) {
        # code...
        return $getTracteur->montant_init;
    }else{
        return 0;
    }
}

public function getDateInitialParChauffeur(){
    $code = $_POST["id_fournisseur"];
    $getTracteur = $this->db->query("SELECT * from chauffeur where id_chauffeur ='".$code."' limit 1")->row();

    if (count($getTracteur)>0) {
        # code...
        return $getTracteur->date_init;
    }else{
        return 0;
    }
}

    public function soldeCaisseFournisseur(){
    echo $this->selectAllTotalFacturePourBalanceFournisseur()+$this->getMontantInitialParChauffeur()-$this->selectAllTotalReglementPourBalanceFournisseur();
    }

   public function getImmatriculationVehiculeChauffeur($id_chauffeur){
        $query = $this->db->query("select * from tracteur where id_chauffeur=".$id_chauffeur." limit 1")->result_array();
        $query1 = $this->db->query("select * from camion_benne where id_chauffeur=".$id_chauffeur." limit 1")->result_array();
       
        if (count($query) > 0) {
            # code...
            foreach ($query as $row) {
                # code...
               return $row['immatriculation'];
            }
        }elseif (count($query1) > 0) {
            # code...
            foreach ($query1 as $row) {
                # code...
               return $row['immatriculation'];
            }
        }else{
            return false;
        }
        


        $this->db->close();
    }

       public function getTypeVehicule1($id_chauffeur){
        $query = $this->db->query("select * from tracteur where id_chauffeur=".$id_chauffeur." limit 1")->result_array();
        $query1 = $this->db->query("select * from camion_benne where id_chauffeur=".$id_chauffeur." limit 1")->result_array();
       
        if (count($query) > 0) {
            # code...
            foreach ($query as $row) {
                # code...
               $query2 = $this->db->query("SELECT * from type_vehicule where id_type = ".$row['id_type_camion']."")->row();
               if (count($query2)>0) {
                   # code...
                return $query2->nom_type;
               }
            }
        }elseif (count($query1) > 0) {
            # code...
            foreach ($query1 as $row) {
                # code...
               $query2 = $this->db->query("SELECT * from type_vehicule where id_type = ".$row['id_type_camion']."")->row();
               if (count($query2)>0) {
                   # code...
                return $query2->nom_type;
               }
            }
        }else{
            return false;
        }
        


        $this->db->close();
    }


    public function getCodeVehiculeChauffeur($id_chauffeur){
        $query = $this->db->query("SELECT * from tracteur where id_chauffeur=".$id_chauffeur." limit 1")->result_array();
        $query1 = $this->db->query("SELECT * from camion_benne where id_chauffeur=".$id_chauffeur." limit 1")->result_array();
        if (count($query) > 0) {
            # code...
            foreach ($query as $row) {
                # code...
               return $row['code'];
            }
        }elseif (count($query1) > 0) {
            # code...
            foreach ($query1 as $row) {
                # code...
               return $row['code'];
            }
        }else{
            return false;
        }


        $this->db->close();
    }

    public function getAllImputationSalaireChauffeur($id_chauffeur,$date_debut,$date_fin){
        $query = $this->db->query('SELECT montant from imputation_salaire WHERE  date_imputation between "'.$date_debut.'" and "'.$date_fin.'" and id_chauffeur='.$id_chauffeur.'')->result_array();

        if (count($query>0)) {
            # code...
            $montant = 0;
            foreach ($query as $row) {
                # code...
                $montant = $montant + $row['montant'];
            }

            return $montant;
        }
    }

    public function getAllRaisonImputationSalaireChauffeur($id_chauffeur,$date_debut,$date_fin){
        $query = $this->db->query('SELECT raison from imputation_salaire WHERE  date_imputation between "'.$date_debut.'" and "'.$date_fin.'" and id_chauffeur='.$id_chauffeur.'')->result_array();

        if (count($query>0)) {
            # code...
            $raison = ' ';
            foreach ($query as $row) {
                # code...
                $raison = $raison.$row['raison'].'; ';
            }

            return $raison;
        }
    }

    public function getTotalImputationSalaireChauffeur($id_chauffeur){
        $query = $this->db->query('SELECT montant,cible from imputation_salaire WHERE id_chauffeur='.$id_chauffeur.'')->result_array();

        if (count($query>0)) {
            # code...
            $montant = 0;
            foreach ($query as $row) {
                # code...
               if ($row['cible'] == "chauffeur") {
                    # code...
                    $montant =$montant + $row['montant'];
                }
            }

            return $montant;
        }
    }
public function getTotalImputationSalaireAssistant($id_chauffeur){
        $query = $this->db->query('SELECT montant,cible from imputation_salaire WHERE id_chauffeur='.$id_chauffeur.'')->result_array();

        if (count($query>0)) {
            # code...
            $montant = 0;
            foreach ($query as $row) {
                # code...
               if ($row['cible'] == "assistant") {
                    # code...
                    $montant =$montant + $row['montant'];
                }
            }

            return $montant;
        }
    }
    public function getAllReglementImputationSalaireAssistant($id_chauffeur,$date_debut,$date_fin){
        $query = $this->db->query('SELECT montant,cible from reglement_imputation WHERE  date_imputation between "'.$date_debut.'" and "'.$date_fin.'" and id_chauffeur='.$id_chauffeur.'')->result_array();

        if (count($query>0)) {
            # code...
            $montant = 0;
            foreach ($query as $row) {
                # code...
                if ($row['cible'] == "assistant") {
                    # code...
                    $montant =$montant + $row['montant'];
                }
                
            }

            return $montant;
        }
    }

    public function getAllReglementImputationSalaireChauffeur($id_chauffeur,$date_debut,$date_fin){
        $query = $this->db->query('SELECT montant,cible from reglement_imputation WHERE  date_imputation between "'.$date_debut.'" and "'.$date_fin.'" and id_chauffeur='.$id_chauffeur.'')->result_array();

        if (count($query>0)) {
            # code...
            $montant = 0;
            foreach ($query as $row) {
                # code...
                if ($row['cible'] == "chauffeur") {
                    # code...
                    $montant =$montant + $row['montant'];
                }
                
            }

            return $montant;
        }
    }
    public function getTotalReglementImputationSalaireChauffeur($id_chauffeur){
        $query = $this->db->query('SELECT montant,cible from reglement_imputation WHERE  id_chauffeur='.$id_chauffeur.'')->result_array();

        if (count($query>0)) {
            # code...
            $montant = 0;
            foreach ($query as $row) {
                # code...
                if ($row['cible'] == "chauffeur") {
                    # code...
                    $montant =$montant + $row['montant'];
                }
            }

            return $montant;
        }
    }

    public function getTotalReglementImputationSalaireAssistant($id_chauffeur){
        $query = $this->db->query('SELECT montant,cible from reglement_imputation WHERE  id_chauffeur='.$id_chauffeur.'')->result_array();

        if (count($query>0)) {
            # code...
            $montant = 0;
            foreach ($query as $row) {
                # code...
                if ($row['cible'] == "assistant") {
                    # code...
                    $montant =$montant + $row['montant'];
                }
            }

            return $montant;
        }
    }
    public function getAllRegulationImputationSalaireChauffeur($id_chauffeur,$date_debut,$date_fin){
        $query = $this->db->query('SELECT regulation,cible from reglement_imputation WHERE  date_imputation between "'.$date_debut.'" and "'.$date_fin.'" and id_chauffeur='.$id_chauffeur.'')->result_array();

        if (count($query>0)) {
            # code...
            $montant = 0;
            foreach ($query as $row) {
                # code...
                if ($row['cible'] == "chauffeur") {
                    # code...
                    $montant =$montant + $row['montant'];
                }
            }

            return $montant;
        }
    }

    public function getAllRegulationImputationSalaireAssistant($id_chauffeur,$date_debut,$date_fin){
        $query = $this->db->query('SELECT regulation,cible from reglement_imputation WHERE  date_imputation between "'.$date_debut.'" and "'.$date_fin.'" and id_chauffeur='.$id_chauffeur.'')->result_array();

        if (count($query>0)) {
            # code...
            $montant = 0;
            foreach ($query as $row) {
                # code...
                if ($row['cible'] == "assistant") {
                    # code...
                    $montant =$montant + $row['montant'];
                }
            }

            return $montant;
        }
    }

    public function getAllRegularisationSalaireChauffeur($id_chauffeur){
        $query = $this->db->query('SELECT regulation,cible from reglement_imputation WHERE id_chauffeur='.$id_chauffeur.'')->result_array();

        if (count($query>0)) {
            # code...
            $montant = 0;
            foreach ($query as $row) {
                # code...
               if ($row['cible'] == "chauffeur") {
                    # code...
                    $montant =$montant + $row['regulation'];
                }
            }

            return $montant;
        }
    }

 public function getAllRegularisationSalaireAssistant($id_chauffeur){
        $query = $this->db->query('SELECT regulation,cible from reglement_imputation WHERE id_chauffeur='.$id_chauffeur.'')->result_array();

        if (count($query>0)) {
            # code...
            $montant = 0;
            foreach ($query as $row) {
                # code...
                if ($row['cible'] == "assistant") {
                    # code...
                    $montant =$montant + $row['montant'];
                }
            }

            return $montant;
        }
    }

    public function getAllRetenueSalaireChauffeur($id_chauffeur,$date_debut,$date_fin){
        $query = $this->db->query('SELECT retenueSalariale from chauffeur WHERE id_chauffeur='.$id_chauffeur.'')->result_array();

        if (count($query>0)) {
            # code...
            $montant = 0;
            foreach ($query as $row) {
                # code...
                $montant = $montant + $row['retenueSalariale'];
            }

            return $montant;
        }
    }
     public function addEtatSalaireChauffeur(){
       
        $type = $_POST["type"];
        $valeur = $_POST['valeur'];
        $id_chauffeur = $_POST['id_chauffeur'];
        $status = $_POST["status"];

        if ($status == "insert") {
            # code...

            $this->db->query("DELETE from paiechauffeur where id_chauffeur=".$id_chauffeur."");
           if ($type == 'salaire') {
            # code...
            $insertImputation = $this->db->query("INSERT INTO paiechauffeur value('',".$id_chauffeur.",now(),".$valeur.",0,0)");
                if ($insertImputation == true) {
                    # code...
                    echo "Opération réussie";
                }else{
                    echo "Erreur d'insertion";
                }
        }elseif ($type == 'gps') {
            # code...
            $insertImputation = $this->db->query("INSERT INTO paiechauffeur value('',".$id_chauffeur.",now(),0,0,".$valeur.")");
                if ($insertImputation == true) {
                    # code...
                    echo "Opération réussie";
                }else{
                    echo "Erreur d'insertion";
                }
        }
        else{
            $insertImputation = $this->db->query("INSERT INTO paiechauffeur value('',".$id_chauffeur.",now(),0,".$valeur.",0)");
                if ($insertImputation == true) {
                    # code...
                    echo "Opération réussie";
                }else{
                    echo "Erreur d'insertion";
                }
        }
                
            
        }elseif ($status == "update") {
            # code...
            $ref = $_POST["ref"];
          
          if ($type == 'salaire') {
            # code...
            $update = $this->db->query("UPDATE paiechauffeur set  id_chauffeur =".$id_chauffeur.",salaire = ".$valeur."  where ref=".$ref."");
                if ($update == true ) {
                    # code...
                    echo "modification réussie";
                }else{
                    echo "Erreur lors de la modification";
                }
        }elseif ($type == 'gps') {
            # code...
            $update = $this->db->query("UPDATE paiechauffeur set  id_chauffeur =".$id_chauffeur.",gps = ".$valeur."  where ref=".$ref."");
                if ($update == true ) {
                    # code...
                    echo "modification réussie";
                }else{
                    echo "Erreur lors de la modification";
                }
        }
        else{
            $update = $this->db->query("UPDATE paiechauffeur set  id_chauffeur =".$id_chauffeur.",salaire_gps = ".$valeur." where ref=".$ref."");
                if ($update == true ) {
                    # code...
                    echo "modification réussie";

                }else{
                    echo "Erreur lors de la modification";
                }
        }
               
            
        }else{
            echo "Erreur fatale";
        }
    }

public function getChauffeurPourVerifPaie($ref){
    $query1 = $this->db->query('SELECT * from chauffeur where id_chauffeur ='.$ref.'')->result_array();
    if (count($query1) >0) {
        # code...
        return true;

    }else{
        return false;
    }
}
 public function selectAllChauffeurPourPaie(){
      $date = date('Y-m');
        $query1 = $this->db->query('SELECT * from chauffeur order by id_chauffeur desc')->result_array();
        $compteur =0;
        if (count($query1)>0) {
            # code...
            foreach ($query1 as $row) {
            # code...
                $query2 = $this->db->query('SELECT * from paiechauffeur where id_chauffeur = '.$row['id_chauffeur'].' order by datePaie desc limit 1')->row();


            $getCodeEngin = $this->db->query("SELECT * from tracteur where id_chauffeur = ".$row['id_chauffeur']."")->row();

            $getCodeService = $this->db->query("SELECT * from camion_benne where id_chauffeur = ".$row['id_chauffeur']."")->row();

               
            


            if(count($getCodeEngin)>0) {
                # code...

            echo "<tr >
                    ";
                echo "
                <td >".$compteur."</td>
                <td >".$getCodeEngin->code."</td>
                        <td>Tracteur</td>";

         if (count($query2) >0) {
                # code...
           
            // if ($date == date("Y-m",strtotime($query2->datePaie))) {
                    # code...
                 echo "<td>".$this->getNomChauffeur($row['id_chauffeur'])."</td>
                    <td ><input type=\"checkbox\" name=\"\" class=\"form-control gps".$compteur."\" id=".$query2->ref." onclick='addEtatSalaireChauffeur(\"".$query2->ref."\",\"".$row['id_chauffeur']."\",\"salaire_gps\",\"gps".$compteur."\",\"update\")'";
                    if ($query2->salaire_gps == 1 && $query2->salaire == 0 && $query2->gps == 0) {
                   # code...
                echo"checked=\"true\" ";
               }elseif ($query2->salaire_gps == 0 && $query2->salaire == 0 && $query2->gps == 0) {
                   # code...
               }
               else{
                echo "disabled = \"true\"";
               }
                    echo"></td>
                    <td ><input type=\"checkbox\" name=\"\" class=\"form-control sal".$compteur."\" id=".$query2->ref." onclick='addEtatSalaireChauffeur(\"".$query2->ref."\",\"".$row['id_chauffeur']."\",\"salaire\",\"sal".$compteur."\",\"update\")'"; 


            if ($query2->salaire == 1 &&  $query2->salaire_gps == 0 && $query2->gps == 0) {
                   # code...
                echo"checked=\"true\" ";
               }elseif ($query2->salaire_gps == 0 && $query2->salaire == 0 && $query2->gps == 0) {
                   # code...
               }else{
                echo "disabled = \"true\"";
               }
                    echo"></td>
                    <td ><input type=\"checkbox\" name=\"\" class=\"form-control gps2".$compteur."\" id=".$query2->ref." onclick='addEtatSalaireChauffeur(\"".$query2->ref."\",\"".$row['id_chauffeur']."\",\"gps\",\"gps2".$compteur."\",\"update\")'"; 


            if ($query2->salaire == 0 &&  $query2->salaire_gps == 0 && $query2->gps == 1) {
                   # code...
                echo"checked=\"true\" ";
               }elseif ($query2->salaire_gps == 0 && $query2->salaire == 0 && $query2->gps == 0) {
                   # code...
               }else{
                echo "disabled = \"true\"";
               }
                    echo"></td>
                    <td>
                    ";
               if ($query2->salaire == 1 || $query2->salaire_gps == 1 || $query2->gps == 1) {
                   # code...
                echo"Disqualifié";
               }else{
                echo "Salarié";
               }
                echo"

                    </td>
                  </tr>

                  "; 
            // }else{
            //      echo "<td>".$this->getNomChauffeur($row['id_chauffeur'])."</td>
            //         <td ><input type=\"checkbox\" name=\"\" class=\"form-control gps".$compteur."\" onclick='addEtatSalaireChauffeur(\"0\",\"".$row['id_chauffeur']."\",\"salaire_gps\",\"gps".$compteur."\",\"insert\")'></td>
            //         <td ><input type=\"checkbox\" name=\"\" class=\"form-control sal".$compteur."\" onclick='addEtatSalaireChauffeur(\"0\",\"".$row['id_chauffeur']."\",\"salaire\",\"sal".$compteur."\",\"insert\")'></td>
                    
            //         <td ><input type=\"checkbox\" name=\"\" class=\"form-control gps2".$compteur."\" onclick='addEtatSalaireChauffeur(\"0\",\"".$row['id_chauffeur']."\",\"gps\",\"gps2".$compteur."\",\"insert\")'></td>
            //         <td>
            //         ";
              
            //     echo"
            //             Salarié
            //         </td>
            //       </tr>

            //       "; 
            // }
               
                  
        }else{
                 echo "<td>".$this->getNomChauffeur($row['id_chauffeur'])."</td>
                    <td ><input type=\"checkbox\" name=\"\" class=\"form-control gps".$compteur."\" onclick='addEtatSalaireChauffeur(\"0\",\"".$row['id_chauffeur']."\",\"salaire_gps\",\"gps".$compteur."\",\"insert\")'></td>
                    <td ><input type=\"checkbox\" name=\"\" class=\"form-control sal".$compteur."\" onclick='addEtatSalaireChauffeur(\"0\",\"".$row['id_chauffeur']."\",\"salaire\",\"sal".$compteur."\",\"insert\")'></td>
                  
                    <td ><input type=\"checkbox\" name=\"\" class=\"form-control gps2".$compteur."\" onclick='addEtatSalaireChauffeur(\"0\",\"".$row['id_chauffeur']."\",\"gps\",\"gps2".$compteur."\",\"insert\")'></td>
                    <td>
                    ";
              
                echo"
                        Salarié
                    </td>
                  </tr>

                  "; 
            }
            }elseif (count($getCodeService)>0) {
                # code...
                
            echo "<tr >
                    ";
                echo "
                <td >".$compteur."</td>
                <td >".$getCodeService->code."</td>
                        <td>Benne</td>";
                           if (count($query2) >0) {
                # code...
           
                // if ($date == date("Y-m",strtotime($query2->datePaie))) {
                    # code...
                 echo "<td>".$this->getNomChauffeur($row['id_chauffeur'])."</td>
                    <td ><input type=\"checkbox\" name=\"\" class=\"form-control gps".$compteur."\" id=".$query2->ref." onclick='addEtatSalaireChauffeur(\"".$query2->ref."\",\"".$row['id_chauffeur']."\",\"salaire_gps\",\"gps".$compteur."\",\"update\")'";
                    if ($query2->salaire_gps == 1 && $query2->salaire == 0 && $query2->gps == 0) {
                   # code...
                echo"checked=\"true\" ";
               }elseif ($query2->salaire_gps == 0 && $query2->salaire == 0 && $query2->gps == 0) {
                   # code...
               }
               else{
                echo "disabled = \"true\"";
               }
                    echo"></td>
                    <td ><input type=\"checkbox\" name=\"\" class=\"form-control sal".$compteur."\" id=".$query2->ref." onclick='addEtatSalaireChauffeur(\"".$query2->ref."\",\"".$row['id_chauffeur']."\",\"salaire\",\"sal".$compteur."\",\"update\")'"; 


            if ($query2->salaire == 1 &&  $query2->salaire_gps == 0 && $query2->gps == 0) {
                   # code...
                echo"checked=\"true\" ";
               }elseif ($query2->salaire_gps == 0 && $query2->salaire == 0 && $query2->gps == 0) {
                   # code...
               }else{
                echo "disabled = \"true\"";
               }
                    echo"></td>
                    <td ><input type=\"checkbox\" name=\"\" class=\"form-control gps2".$compteur."\" id=".$query2->ref." onclick='addEtatSalaireChauffeur(\"".$query2->ref."\",\"".$row['id_chauffeur']."\",\"gps\",\"gps2".$compteur."\",\"update\")'"; 


            if ($query2->salaire == 0 &&  $query2->salaire_gps == 0 && $query2->gps == 1) {
                   # code...
                echo"checked=\"true\" ";
               }elseif ($query2->salaire_gps == 0 && $query2->salaire == 0 && $query2->gps == 0) {
                   # code...
               }else{
                echo "disabled = \"true\"";
               }
                    echo"></td>
                    <td>
                    ";
               if ($query2->salaire == 1 || $query2->salaire_gps == 1 || $query2->gps == 1) {
                   # code...
                echo"Disqualifié";
               }else{
                echo "Salarié";
               }
                echo"

                    </td>
                  </tr>

                  "; 
            // }else{
            //      echo "<td>".$this->getNomChauffeur($row['id_chauffeur'])."</td>
            //         <td ><input type=\"checkbox\" name=\"\" class=\"form-control gps".$compteur."\" onclick='addEtatSalaireChauffeur(\"0\",\"".$row['id_chauffeur']."\",\"salaire_gps\",\"gps".$compteur."\",\"insert\")'></td>
            //         <td ><input type=\"checkbox\" name=\"\" class=\"form-control sal".$compteur."\" onclick='addEtatSalaireChauffeur(\"0\",\"".$row['id_chauffeur']."\",\"salaire\",\"sal".$compteur."\",\"insert\")'></td>
                    
            //         <td ><input type=\"checkbox\" name=\"\" class=\"form-control gps2".$compteur."\" onclick='addEtatSalaireChauffeur(\"0\",\"".$row['id_chauffeur']."\",\"gps\",\"gps2".$compteur."\",\"insert\")'></td>
            //         <td>
            //         ";
              
            //     echo"
            //             Salarié
            //         </td>
            //       </tr>

            //       "; 
            // }
               
                  
        }else{
                 echo "<td>".$this->getNomChauffeur($row['id_chauffeur'])."</td>
                    <td ><input type=\"checkbox\" name=\"\" class=\"form-control gps".$compteur."\" onclick='addEtatSalaireChauffeur(\"0\",\"".$row['id_chauffeur']."\",\"salaire_gps\",\"gps".$compteur."\",\"insert\")'></td>
                    <td ><input type=\"checkbox\" name=\"\" class=\"form-control sal".$compteur."\" onclick='addEtatSalaireChauffeur(\"0\",\"".$row['id_chauffeur']."\",\"salaire\",\"sal".$compteur."\",\"insert\")'></td>
                  
                    <td ><input type=\"checkbox\" name=\"\" class=\"form-control gps2".$compteur."\" onclick='addEtatSalaireChauffeur(\"0\",\"".$row['id_chauffeur']."\",\"gps\",\"gps2".$compteur."\",\"insert\")'></td>
                    <td>
                    ";
              
                echo"
                        Salarié
                    </td>
                  </tr>

                  "; 
            }
            }else{

                // echo "<td style='color:red;'>Aucun code</td>
                // <td style='color:red;'>Aucun véhicule</td>";
            }

           
            

            $compteur++;
        }
         }

        echo "<input type='hidden' class='compteur' value=".$compteur." />"; 

    }

public function getValidePaieChauffeur($id_chauffeur,$date_debut,$date_fin){
    $query2 = $this->db->query('SELECT * from paiechauffeur where id_chauffeur = '.$id_chauffeur.' order by datePaie desc limit 1')->row();
    if (count($query2)>0) {
        # code...
        if ($query2->salaire==1) {
            # code...
            return false;
        }elseif ($query2->salaire_gps == 1) {
            # code...
            return false;
        }else{
            return true;
        }

    }else{
        return true;
    }
}

    public function getPaiePersonnel(){

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

         $getChauffeur = $this->db->query("SELECT * from chauffeur")->result_array();
         $compteur = 0;
         $compteur2 = 1;
         $totalRetenue = 0;
         $totalReglement = 0;
         $totalRegulation = 0;
         $totalNp = 0;
         $totalSalaire = 0;
         $totalCredit = 0;
         $totalCreditAss = 0;
         foreach ($getChauffeur as $row) {
             # code...
            // $solde = $row['salaire']+$this->getAllReglementImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)-$this->getAllRetenueSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)-$this->getAllImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin);
            $np = $row['salaire']-$this->getAllRetenueSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)-$this->getAllReglementImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)+$this->getAllRegulationImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin);

            $npAssistant = $row['salaire_ass']-$this->getAllReglementImputationSalaireAssistant($row['id_chauffeur'],$date_debut,$date_fin)+$this->getAllRegulationImputationSalaireAssistant($row['id_chauffeur'],$date_debut,$date_fin);
            // juste apres salaire brute on a :
            // retenue salariale
            // regulationn NS
            // retenuen abs
            // net à payer
            // credit
            
            //solde solde = credit+rtabs-regul
            $credit = $row['montant_init']+$this->getTotalImputationSalaireChauffeur($row['id_chauffeur'])+$this->getTotalImputationSalaireAssistant($row['id_chauffeur'])-$this->getTotalReglementImputationSalaireChauffeur($row['id_chauffeur'])-$this->getTotalReglementImputationSalaireAssistant($row['id_chauffeur']);

            $creditAss = $this->getTotalImputationSalaireAssistant($row['id_chauffeur'])-$this->getTotalReglementImputationSalaireAssistant($row['id_chauffeur']);

            $solde = $row['montant_init']+$this->getAllImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin) -$this->getAllRegularisationSalaireChauffeur($row['id_chauffeur']);
    if ($this->getImmatriculationVehiculeChauffeur($row['id_chauffeur']) == false) {
        # code...
    }elseif ($this->getValidePaieChauffeur($row['id_chauffeur'],$date_debut,$date_fin) == false) {
        # code...
    }
    else{
       echo "<tr style='text-align:center; font-size: 12px;'>
            <td>".$compteur."</td>
            <td>".$row['nom']."</td>
            <td>Chauffeur</td>
            <td >".$this->getImmatriculationVehiculeChauffeur($row['id_chauffeur'])."</td>
            <td >".$this->getCodeVehiculeChauffeur($row['id_chauffeur'])."</td>
            <td >".$this->getTypeVehicule1($row['id_chauffeur'])."</td>
            <td>".number_format($row['salaire'],0,',',' ')."</td>
            
            <td>".$this->getAllRetenueSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)."</td>
            
            <td>".number_format($this->getAllReglementImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin),0,',',' ')."</td>

            <td>".$this->getAllRegulationImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)."</td>

            
            
            <td>".number_format($np,0,',',' ')."</td>
            <td>".number_format($credit,0,',',' ')."</td>
            
            
            <td></td>
            </tr>";

            $compteur2 =$compteur+1;



        echo "<tr style='text-align:center; font-size: 12px;'>
            <td>".$compteur2."</td>
            <td>".$row['nom_ass']."</td>
            <td>Motoboy/Assistant</td>
            <td >".$this->getImmatriculationVehiculeChauffeur($row['id_chauffeur'])."</td>
            <td >".$this->getCodeVehiculeChauffeur($row['id_chauffeur'])."</td>
            <td >".$this->getTypeVehicule1($row['id_chauffeur'])."</td>
            <td>".number_format($row['salaire_ass'],0,',',' ')."</td>
            <td>0</td>
            <td>".number_format($this->getAllReglementImputationSalaireAssistant($row['id_chauffeur'],$date_debut,$date_fin),0,',',' ')."</td>
            <td>".$this->getAllRegulationImputationSalaireAssistant($row['id_chauffeur'],$date_debut,$date_fin)."</td>
            
            <td>".number_format($npAssistant,0,',',' ')."</td>
            <td>".number_format($creditAss,0,',',' ')."</td>
            <td></td>
            
            </tr>";
            $compteur =$compteur2+1;
            
         $totalRetenue = $totalRetenue + $this->getAllRetenueSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)+$this->getAllRetenueSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin);
         $totalReglement = $totalReglement + $this->getAllReglementImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)+$this->getAllReglementImputationSalaireAssistant($row['id_chauffeur'],$date_debut,$date_fin);
         $totalRegulation = $totalRegulation +$this->getAllRegulationImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)+$this->getAllRegulationImputationSalaireAssistant($row['id_chauffeur'],$date_debut,$date_fin);
         $totalNp = $totalNp + $np+ $row['salaire_ass'];
         $totalSalaire = $totalSalaire + $row['salaire_ass'] +$row['salaire'];
         $totalCredit = $totalCredit + $credit;
         $totalCreditAss = $totalCreditAss + $creditAss;
        $totalCredit + $totalCredit+$totalCreditAss;
         }
         }
    echo "<tr style='text-align:center; font-size: 12px; color:red;'>
            <th>TOTAUX</th>
            <th></th>
            <th></th>
            <th ></th>
            <th ></th>
            <th ></th>
            <th>".number_format($totalSalaire,0,',',' ')."</th>
            <th>".number_format($totalRetenue,0,',',' ')."</th>
            <th>".number_format($totalReglement,0,',',' ')."</th>
            <th>".number_format($totalRegulation,0,',',' ')."</th>
            
            <th>".number_format($totalNp,0,',',' ')."</th>
            <th>".number_format($totalCredit,0,',',' ')."</th>
            <th></th>
            
            </tr>";
    }


public function getSommeIputation(){

        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

         $getChauffeur = $this->db->query("SELECT * from chauffeur")->result_array();
         $compteur = 0;
         $compteur2 = 1;
         $totalRetenue = 0;
         $totalReglement = 0;
         $totalRegulation = 0;
         $totalNp = 0;
         $totalSalaire = 0;
         $totalCredit = 0;
         foreach ($getChauffeur as $row) {
             # code...
            // $solde = $row['salaire']+$this->getAllReglementImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)-$this->getAllRetenueSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)-$this->getAllImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin);
            $np = $row['salaire']-$this->getAllRetenueSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)-$this->getAllReglementImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)+$this->getAllRegulationImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin);
            // juste apres salaire brute on a :
            // retenue salariale
            // regulationn NS
            // retenuen abs
            // net à payer
            // credit
            
            //solde solde = credit+rtabs-regul
            $credit = $row['montant_init']+$this->getTotalImputationSalaireChauffeur($row['id_chauffeur'])-$this->getTotalReglementImputationSalaireChauffeur($row['id_chauffeur']);
            $solde = $row['montant_init']+$this->getAllImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin) -$this->getAllRegularisationSalaireChauffeur($row['id_chauffeur']);
    if ($this->getImmatriculationVehiculeChauffeur($row['id_chauffeur']) == false) {
        # code...
    }elseif ($this->getValidePaieChauffeur($row['id_chauffeur'],$date_debut,$date_fin) == false) {
        # code...
    }
    else{
       echo "<tr style='text-align:center; font-size: 12px;'>
            <td>".$compteur."</td>
            <td>".$row['nom']."</td>
            <td>Chauffeur</td>
            <td >".$this->getImmatriculationVehiculeChauffeur($row['id_chauffeur'])."</td>
            <td >".$this->getCodeVehiculeChauffeur($row['id_chauffeur'])."</td>
            <td >".$this->getTypeVehicule1($row['id_chauffeur'])."</td>
            <td>".$row['salaire']."</td>
            
            <td>".$this->getAllImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)."</td>
            
            <td>".$this->getAllRaisonImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin)."</td>
            </tr>";

            $compteur2 =$compteur+1;



        echo "<tr style='text-align:center; font-size: 12px;'>
            <td>".$compteur2."</td>
            <td>".$row['nom_ass']."</td>
            <td>Motoboy/Assistant</td>
            <td >".$this->getImmatriculationVehiculeChauffeur($row['id_chauffeur'])."</td>
            <td >".$this->getCodeVehiculeChauffeur($row['id_chauffeur'])."</td>
            <td >".$this->getTypeVehicule1($row['id_chauffeur'])."</td>
            <td>".number_format($row['salaire_ass'],0,',',' ')."</td>
            <td>0</td>
            <td></td>
            </tr>";
            $compteur =$compteur2+1;
            
         $totalRetenue = $totalRetenue + $this->getAllRetenueSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin);
         $totalReglement = $totalReglement + $this->getAllReglementImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin);
         $totalRegulation = $totalRegulation +$this->getAllRegulationImputationSalaireChauffeur($row['id_chauffeur'],$date_debut,$date_fin);
         $totalNp = $totalNp + $np+ $row['salaire_ass'];
         $totalSalaire = $totalSalaire + $row['salaire_ass'] +$row['salaire'];
         $totalCredit = $totalCredit + $credit;
            
         }
         }
    // echo "<tr style='text-align:center; font-size: 12px; color:red;'>
    //         <td>TOTAUX</td>
    //         <td></td>
    //         <td></td>
    //         <td ></td>
    //         <td ></td>
    //         <td ></td>
    //         <td>".$totalSalaire."</td>
    //         <td>".$totalRetenue."</td>
    //         <td>".$totalReglement."</td>
    //         <td>".$totalRegulation."</td>
            
    //         <td>".$totalNp."</td>
    //         <td>".$totalCredit."</td>
    //         <td></td>
            
    //         </tr>";
    }

public function getSalaireNetChauffeur(){
    $date = $_POST['date'];
    $id_chauffeur = $_POST['id_chauffeur'];
    $date_debut = date("Y/m/d",strtotime($_POST['date'].'- 1 month'));
   
    $query1 = $this->db->query('SELECT * from chauffeur where id_chauffeur='.$id_chauffeur.'')->row();

    if (count($query1)>0) {
        # code...
        $np = $query1->salaire-$this->getAllRetenueSalaireChauffeur($id_chauffeur,$date_debut,$date)-$this->getAllReglementImputationSalaireChauffeur($id_chauffeur,$date_debut,$date)+$this->getAllRegulationImputationSalaireChauffeur($id_chauffeur,$date_debut,$date);
        echo number_format($np,0,',',' ');
    }
    
}


public function getTotalSalaireNetChauffeurAssistant(){
    $date = $_POST['date'];
    $id_chauffeur = $_POST['id_chauffeur'];
    $date_debut = date("Y/m/d",strtotime($_POST['date'].'- 1 month'));
   
    $query1 = $this->db->query('SELECT * from chauffeur where id_chauffeur='.$id_chauffeur.'')->row();

    if (count($query1)>0) {
        # code...
        $np = $query1->salaire-$this->getAllRetenueSalaireChauffeur($id_chauffeur,$date_debut,$date)-$this->getAllReglementImputationSalaireChauffeur($id_chauffeur,$date_debut,$date)+$this->getAllRegulationImputationSalaireChauffeur($id_chauffeur,$date_debut,$date);
        echo number_format($np+$query1->salaire_ass,0,',',' ');
    }
    
}
}