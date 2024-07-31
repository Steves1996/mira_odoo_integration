<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model extends CI_Model {
// 
    function __construct() {
        parent::__construct();
        $this->load->database('default');
        $this->load->library('session');
        $this->load->helper('app_gui_helper');
        $this->load->helper('cookie');
        $this->load->helper('url');
        // $this->session->set_userdata('language_abbr', "en"); 
    }
	
    	public function frenchLang(){
    	 $language ="french";
         global $URI, $CFG, $IN;
 
        $config =& $CFG->config;
        $lang_browser = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        $URI->uri_string = preg_replace("|^\/?|", '/', $URI->uri_string);	
        $this->session->set_userdata('language_abbr', "fr");
        // $lien =$config['base_url']."fr".$URI->uri_string;
        // echo '<meta http-equiv="refresh" content="5"; url="'.$lien.'" />'
    	}
    	public function englishLang(){
    	 $language ="english";
         global $URI, $CFG, $IN;
 
        $config =& $CFG->config;
        $lang_browser = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        $URI->uri_string = preg_replace("|^\/?|", '/', $URI->uri_string);	
        $this->session->set_userdata('language_abbr', "en");
        // $lien =$config['base_url']."fr".$URI->uri_string;
        // echo '<meta http-equiv="refresh" content="5"; url="'.$lien.'" />'
    	}

    	public function get_current_page(){
    	global $URI, $CFG, $IN;
 
        $config =& $CFG->config;
        $lang_browser = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        $URI->uri_string = preg_replace("|^\/?|", '/', $URI->uri_string);
         echo $URI->uri_string;   	
    	}
	    public function selectLangue(){
            $language ="english";
         global $URI, $CFG, $IN;
 
        $config =& $CFG->config;
        $lang_browser = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        $URI->uri_string = preg_replace("|^\/?|", '/', $URI->uri_string);
             
          echo ' <div class="dropdown">';
                           
                          if ($this->session->userdata('language') == "french" || $this->session->userdata('language') == null) {
                            // $sendLanguage=$this->session->set_userdata('language', "french");
                            $trueLanguage = "Français";
                            $language = "Langue";
                            $choixLangue = '<li><a class="choisirLangue" >ENGLISH</a></li>';
                            $abreviation = "fr";
                            $lien =$config['base_url']."en".$URI->uri_string;
                            $debutLien = $config['base_url']."en";
                            $this->session->set_userdata('language_abbr', "fr");
                            $this->session->set_userdata('language', "french");
                          }elseif($this->session->userdata('language') == "english"){
                            
                            $trueLanguage ="English";
                            $language = "Language";
                            $choixLangue ='<li><a class="choisirLangue" >Français</a></li>';
                            $abreviation = "en";
                            $lien =$config['base_url']."fr".$URI->uri_string;
                            $debutLien = $config['base_url']."fr";
                            $this->session->set_userdata('language', "english");
                            $this->session->set_userdata('language_abbr', "en");
                          }
                          
                         echo ' <input type="hidden" name="" class="url" value="'.current_url().'">
                          <input type="hidden" name="" class="abreviationLangue" value="'.$abreviation.'">
                            <span><i class="fa fa-globe"></i> '.$language.' :</span><span class="dropdown-toggle" id="dropdownLang" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">'.$trueLanguage.'<span class="caret"></span></span>

                            <ul class="dropdown-menu" aria-labelledby="dropdownLang">
                             '.$choixLangue.'
                                
                                

                            </ul>
             </div>
             <script type="text/javascript">
             // var stopLecturePage;
             // function lecturePage(){
             //    window.location.href ="'.$lien.'";
             //    alert("ffsdf");
             //    stopLecturePage = setTimeout(lecturePage,70000);
             //    clearTimeout(stopLecturePage);
             // }
             $(".choisirLangue").click(function(){
               
                
                $.ajax({
                                
                                type:"POST",
                                url:"'.$debutLien.'/admin/language",

                                data:{"langue_abbr":"'.$abreviation.'"},
                                success: function(data2){
                            // alert(data2);
                                    window.location.href ="'.$lien.'";
                                }
                            });


                

                });
             </script>
             ';
  
    }
    public function validateCommentaire($com_lm = '0',$com_cv = '0',$com_coch = '0'){
	$mail = $_POST["mail"];
	$commentaire = $_POST["commentaire"];
	$nom = $_POST["nom"];

    $ajoutReccurence = array("com_cv" => $com_cv,"com_lm" => $com_lm,"com_coch" => $com_coch,"mail" => $mail,"nom" => $nom,"commentaire" => $commentaire,"date_com" => "now()");
    // $this->db->where('ip',$ip);
    // $this->db->query("insert into commentaires value('','".$com_cv."','".$com_lm."','".$com_coch."','".$nom."','".$mail."','".$commentaire."',now())");
    $query1 = $this->db->query("insert into commentaires value('','".$com_cv."','".$com_lm."','".$com_coch."','".$nom."','".$mail."','".$commentaire."',now())"); 
    if ($query1 == true) {
              echo "Votre commentaire a été publié avec succès";
        }else{
        	echo "Erreur lors de l'insertion";
        }

	}
 public function validateTemoignage(){
	$mail = $_POST["mail"];
	$commentaire = $_POST["commentaire"];
	$nom = $_POST["nom"];
    $query1 = $this->db->query("insert into temoignage value('','".$nom."','".$mail."','".$commentaire."',now())"); 
    if ($query1 == true) {
              echo "Votre témoignage a été publié avec succès";
        }else{
        	echo "Erreur lors de l'insertion";
        }

	}
		public function selectTemoignage(){
        
        $query1 = $this->db->get_where('temoignage')->result_array();
       
            foreach ($query1 as $row1) {
            	echo '<div class="media mt-sm-5 mt-3">
                                <a class="pr-3" href="#">
                                    <img src="'.base_url().'assets/images/m.png" alt="Generic placeholder image">
                                </a>
                                <div class="media-body comments-grid-right">
                                    <h4>'.$row1["nom"].'</h4>
                                    <ul class="my-2">
                                        <li class="font-weight-bold">'.$row1["date_tem"].'
                                            <i>|</i>
                                        </li>
                                        <li>
                                            <a href="#" class="font-weight-bold">Répondre</a>
                                        </li>
                                    </ul>
                                    <p>'.$row1["commentaire"].'</p>
                                </div>
                            </div>';
            }
            $this->db->close();

	

}
	public function selectCommentaire($where,$valeur){
		 // $telephone = $email;
        $lewhere = array($where => $valeur);
        
        $query1 = $this->db->get_where('commentaires', $lewhere)->result_array();
       
            foreach ($query1 as $row1) {
            	echo '<div class="media mt-sm-5 mt-3">
                                <a class="pr-3" href="#">
                                    <img src="'.base_url().'assets/images/m.png" alt="Generic placeholder image">
                                </a>
                                <div class="media-body comments-grid-right">
                                    <h4>'.$row1["nom"].'</h4>
                                    <ul class="my-2">
                                        <li class="font-weight-bold">'.$row1["date_com"].'
                                            <i>|</i>
                                        </li>
                                        <li>
                                            <a href="#" class="font-weight-bold">Répondre</a>
                                        </li>
                                    </ul>
                                    <p>'.$row1["commentaire"].'</p>
                                </div>
                            </div>';
            }
            $this->db->close();

	

}
	public function selectAllCommentaire($com_lm = '0',$com_cv = '0',$com_coch = '0'){
		if ($com_lm!='0') {
			# code...
			$this->selectCommentaire('com_lm',$com_lm);
		}elseif ($com_cv!='0') {
			# code...
			$this->selectCommentaire('com_cv',$com_cv);
		}else{
			$this->selectCommentaire('com_coch',$com_coch);
		}
	}

	public function cochingParMail(){
		$nom = $_POST["nom"];
		$expediteur = $_POST["email"];
		$telephone = $_POST["telephone"];
		$profession = $_POST["profession"];
		$pays = $_POST["pays"];
		$objet = $_POST["objet"];
			$message = addslashes($_POST['message']) ;
			$objet = $_POST['objet'];
			$destinataire = "urichtakuete@gmail.com";
			$entete = 'From: '.$expediteur;

			if(!filter_var($expediteur,FILTER_VALIDATE_EMAIL)){
				echo "Adresse mail non valide";

			}else{
			 if(mail($destinataire, $objet, $message,$entete)){
			 	echo "votre mail a été envoyé avec succès";
			 }else{
			 	echo "Erreur d'enavoit du mail";
			//Reply-to 
			 }
			}

	}

	public function addCV($file_image, $file_word,$hauteur,$largeur){
		$realname = pathinfo($_FILES['file_image']['name'],PATHINFO_FILENAME);
		        $file = $_FILES['file_image']['tmp_name']; 

        $sourceProperties = getimagesize($file);

        $fileNewName = time();

        $folderPath = "assets/images/cv/captures/";

        $ext = pathinfo($_FILES['file_image']['name'], PATHINFO_EXTENSION);

        $imageType = $sourceProperties[2];


        switch ($imageType) {


            case IMAGETYPE_PNG:

                $imageResourceId = imagecreatefrompng($file); 

                $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);

                imagepng($targetLayer,$folderPath. $realname. "_thump.". $ext);

                break;


            case IMAGETYPE_GIF:

                $imageResourceId = imagecreatefromgif($file); 

                $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);

                imagegif($targetLayer,$folderPath. $realname. "_thump.". $ext);

                break;


            case IMAGETYPE_JPEG:

                $imageResourceId = imagecreatefromjpeg($file); 

                $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);

                imagejpeg($targetLayer,$folderPath. $realname. "_thump.". $ext);

                break;


            default:

                echo "Invalid Image type.";

                exit;

                break;

        }


       $uploadImage = move_uploaded_file($file, $folderPath.$_FILES['file_image']['name']);

        // echo "Image Resize Successfully.";
		// $nom = $_POST["nom"];
		$montant = $_POST["montant"];
		    // $uploadImage = move_uploaded_file($file_image,'assets/images/cv/captures/'.$_FILES['file_image']['name']);
		    $uploadFileWord = move_uploaded_file($file_word,'assets/images/cv/word/'.$_FILES['file_word']['name']);
        if($uploadImage == true){
            // echo "Votre Logo a été envoyé avec succès";
        }else{
            echo "Désolé Erreur lors de l'envoit de l'image";
        }
        // $sizeImg  =getimagesize($_FILES["file_image"]['tmp_name']);
        // $largeur = $sizeImg[0];
        // $hauteur = $sizeImg[1];
          		// imagecopyresampled('assets/images/cv/captures/'.$_FILES['file_image']['name'], $file_image,0,0,0,0, 355, 504, $largeur, $hauteur);
        //on definieles extension autorisée
        $extensionsValides = array('jpg','png','gif','jpeg');
        //variable récupérer l’extension du fichier inséré
        $extensionsUpload=strtolower(substr(strrchr($_FILES['file_image']['name'], '.'),1));
        // echo $extensionsUpload;
            if(in_array($extensionsUpload, $extensionsValides)){
            	 $lewhere = array("nom_cv" =>  $realname. "_thump.". $ext);
            	$query2 = $this->db->get_where('modelecv', $lewhere)->result_array();

            	$lewhere1 = array("fichier_word" => $_FILES['file_word']['name']);
            	$query3 = $this->db->get_where('modelecv', $lewhere1)->result_array();
            	if (count($query2)>0) {
            		echo "un CV de meme nom existe déjà veuillez changer svp";
            	}elseif(count($query3)>0){
            		echo "Ce fichier word est déja attribué à un autre cv veuillez lz changer ou renommez";
            	}
            	else{
            		$query1 = $this->db->query("insert into modelecv value('','". $realname. "_thump.". $ext."','".$_FILES['file_word']['name']."','".$montant."','',now())");
	            	if($query1 == true){
	            		echo "Insertion parfaite du CV";
	            	}else{
	            		echo "Erreur durant l'insertion";
	            	}	
            	}
            	

             }else{

             echo "votre photo de profil doit etre au format jpg,jpeg,png ou gif";
            
         
            }
          $this->db->close();      
	}


// le code qui va suivre c'est celui de l'insertion des LM(lettre de motivation)

	public function addLM($file_image, $file_word){
		// $nom = $_POST["nom"];
		$realname = pathinfo($_FILES['file_image1']['name'],PATHINFO_FILENAME);
		// echo "le nom est: ".$realname;

		$montant = $_POST["montant1"];
	    $file = $_FILES['file_image1']['tmp_name']; 

        $sourceProperties = getimagesize($file);

        $fileNewName = time();

        $folderPath = "assets/images/motivation/captures/";

        $ext = pathinfo($_FILES['file_image1']['name'], PATHINFO_EXTENSION);

        $imageType = $sourceProperties[2];


        switch ($imageType) {


            case IMAGETYPE_PNG:

                $imageResourceId = imagecreatefrompng($file); 

                $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);

                imagepng($targetLayer,$folderPath. $realname. "_thump.". $ext);

                break;


            case IMAGETYPE_GIF:

                $imageResourceId = imagecreatefromgif($file); 

                $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);

                imagegif($targetLayer,$folderPath. $realname. "_thump.". $ext);

                break;


            case IMAGETYPE_JPEG:

                $imageResourceId = imagecreatefromjpeg($file); 

                $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);

                imagejpeg($targetLayer,$folderPath. $realname. "_thump.". $ext);

                break;


            default:

                echo "Invalid Image type.";

                exit;

                break;

        }


       $uploadImage = move_uploaded_file($file, $folderPath.$_FILES['file_image1']['name']);

		    // $uploadImage = move_uploaded_file($file_image,'assets/images/motivation/captures/'.$_FILES['file_image1']['name']);
		    $uploadFileWord = move_uploaded_file($file_word,'assets/images/motivation/word/'.$_FILES['file_word1']['name']);
        if($uploadImage == true){
            // echo "Votre Logo a été envoyé avec succès";
        }else{
            echo "Désolé Erreur lors de l'envoit du fichier";

        }
   
        //on definieles extension autorisée
        $extensionsValides = array('jpg','png','gif','jpeg');
        //variable récupérer l’extension du fichier inséré
        $extensionsUpload=strtolower(substr(strrchr($_FILES['file_image1']['name'], '.'),1));
        // echo $extensionsUpload;
            if(in_array($extensionsUpload, $extensionsValides)){
            	 $lewhere = array("nom_lm" => $realname. "_thump.". $ext);
            	$query2 = $this->db->get_where('modelelm', $lewhere)->result_array();

            	$lewhere1 = array("fichier_word" => $_FILES['file_word1']['name']);
            	$query3 = $this->db->get_where('modelelm', $lewhere1)->result_array();
            	if (count($query2)>0) {
            		echo "Une image de meme nom existe déjà veuillez changer ou renommer svp";
            	}elseif(count($query3)>0){
            		echo "Ce fichier word est déja attribué à une lettre de motivation veuillez le changer ou renommer";
            	}
            	else{
            		$query1 = $this->db->query("insert into modelelm value('','".$realname. "_thump.". $ext."','".$_FILES['file_word1']['name']."','".$montant."','',now())");
	            	if($query1 == true){
	            		echo "Insertion parfaite de la lettre de motivation";
	            	}else{
	            		echo "Erreur durant l'insertion";
	            	}	
            	}
            	

             }else{

             echo "votre image doit etre au format jpg,jpeg,png ou gif";
        
          
            }
          $this->db->close();      
	}


	public function selectAllCV(){
		// dans cette partie deu code nous allons sélectionner les cv et les vendre
		$query1 = $this->db->get_where('modelecv')->result_array();
		$compteur = 0;
        $rien = "_";
        echo "<form action='".base_url().$this->session->userdata('language_abbr')."/admin/panier' method='post'>
            <input type='submit' name='panier' value = '0' class='btnEnvoyer' style='color:red; font-size: 40px'> 
            <input type=\"hidden\" value=\"\" class=\"champPrix\" name=\"prix\">
            <input type=\"hidden\" value=\"\" class=\"compteur\" name=\"compteur\">
            <input type=\"hidden\" value=\"\" class=\"listeCV\" name=\"listeCV\">
            </form>";
		foreach ($query1 as $row1){
            	echo '<input type="hidden" value="'.$compteur.'" class="compteur" name="compteur"> 
            
            
            <input type="hidden" value="" class="nbreCV" name="nbreCV"><div class="col-md-3">
            	<div class="custom-control custom-checkbox image-checkbox">
		            <input type="checkbox" class="custom-control-input '.$row1["id_modeleCV"].'" id="ck'.$compteur.'" prix'.$compteur.'="'.$row1["prix"].'" selecteur'.$compteur.'="'.$row1["id_modeleCV"].'" value="'.$row1["id_modeleCV"].'" name="cv'.$compteur.'">
		            <label class="custom-control-label" for="ck'.$compteur.'">
		                <img src="'.base_url().'assets/images/cv/captures/'.$row1["nom_cv"].'" alt="#" class="img-fluid">
		                <div class="contentPrix" style="">
		                  <h3 class="title" style="color: white;">'.$row1["prix"].' €</h3>
		                </div>
		            </label>
		           <ul class="social" style="text-align: center;">
		                   
		            <li><a style="" class="jaime"><i class="fa fa-thumbs-o-up"></i></a></li>
		         </ul>
		        </div>
		        </div>
		        <script type="text/javascript">
                // $(".champPrix").val("");
                var listeId = [];
                if($("#ck'.$compteur.'").is(":checked")){


                       prix = $(".champPrix").val();
                       prix = '.$row1["prix"].' + Number(prix) ;
                       $(".champPrix").val(prix);
                       
                       nbreCV = $(".nbreCV").val();
                       nbreCV = Number(nbreCV) +1;
                       $(".nbreCV").val(nbreCV);
                       listeId['.$compteur.'] = '.$row1["id_modeleCV"].';
                       // alert(prix);
                       $(".champPrix").val(prix);
                        maListe = JSON.stringify(listeId);
                        $(".listeCV").val(maListe);
                    }
                   if($(".champPrix").val() == 0){
                     $(".btnEnvoyer").attr("disabled","true");
                                       }else{
                            
                        $(".btnEnvoyer").removeAttr("disabled","false");
                        }

		        $("#ck'.$compteur.'").click(function(){
		        	// alert("#ck'.$compteur.'")
                    if($("#ck'.$compteur.'").is(":checked")){
                        nbre = $(".btnEnvoyer").val();
                        nbre2 = Number(nbre)+1;
                        $(".btnEnvoyer").empty();
                        $(".btnEnvoyer").val(nbre2);

                       prix = $(".champPrix").val();
                       prix = '.$row1["prix"].' + Number(prix) ;
                       $(".champPrix").val(prix);

                       nbreCV = $(".nbreCV").val();
                       nbreCV = Number(nbreCV) +1;
                       $(".nbreCV").val(nbreCV);
                       listeId['.$compteur.'] = '.$row1["id_modeleCV"].';
                       // alert(listeId['.$compteur.']);
                    
                    }else{
                        nbre = $(".btnEnvoyer").val();
                        nbre2 = Number(nbre)-1;
                        $(".btnEnvoyer").empty();
                        $(".btnEnvoyer").val(nbre2);
                     // prix = $(".champPrix").val();
                       prix = Number(prix) - '.$row1["prix"].';
                       $(".champPrix").val(prix);

                       nbreCV = $(".nbreCV").val();
                       nbreCV = Number(nbreCV) -1;
                       $(".nbreCV").val(nbreCV);
                       listeId['.$compteur.'] = "";
                       // alert(listeId['.$compteur.']);
                    }
                    maListe = JSON.stringify(listeId);
                $(".listeCV").val(maListe);
                if($(".champPrix").val() == 0){
                        $(".btnEnvoyer").attr("disabled","true");
                      
                        }else{
                        $(".btnEnvoyer").removeAttr("disabled","false");
                        }
		        	});
		        </script>';
		        $compteur+=1; 
            }
            echo '
            
            <input type="hidden" value="" class="nbreCV" name="nbreCV">
            
            <script type="text/javascript">
                $(".compteur").val("'.$compteur.'");
                
                </script>;
            ';
            $this->db->close();
	}
// la function qui suit permet de récupérer les information venant de la function suivante qui 
    public function panierCV(){
        
        if(!isset($_POST['prix'],$_POST['listeCV'],$_POST['compteur'])){
            echo '<script>top.window.location = "'.base_url().$this->session->userdata('language_abbr').'/admin/modelesCV"</script>';
        }else{
           $prix = $_POST['prix'];
        $listeCV=json_decode($_POST['listeCV']);
        $this->session->set_userdata('tabCV',$listeCV);
        $nbreCV = $_POST['compteur'];
        $nombre= 0;
        $images = ""; 

        foreach ($listeCV as $key => $value) { 
            # code...
            $nombre+=1;
            // echo "hey ".$listeCV[$key];
           if ($listeCV[$key] =="") {
                    # code...
                    // ici on vérifie qu'on a pas récupéré un élément vide
                    // echo "rien rien";
                }else{
                    // echo "cv: ".$listeCV[$key];
                    $reference = array('id_modeleCV' => $listeCV[$key]);
                    $query = $this->db->get_where('modelecv', $reference);
                    $row = $query->row();
                    $nom_cv = $row->nom_cv;
                    $images.='<li class="splide__slide"><img src="'.base_url().'assets/images/cv/captures/'.$nom_cv.'"></li>';

                }
        }
        // echo " le nombre est: ".$nombre;
         echo '<section class="contact-wthree align-w3" id="contact">
        <div class="container">
            <div class="wthree_pvt_title text-center">
                <h4 class="w3pvt-title">Panier de CV
                </h4>
                <p class="sub-title">Bienvenue dans votre panier le nombre total de CV que vous avez sélectioné est de:'.$nombre.'
                pour un montant total de '.$prix.' € .</p>
            </div>
          
            <div class="row mt-4">
                <div class="col-lg-7">
                    <h5 class="cont-form">Veuillez remplir ce formulaire SVP</h5>
                    <div class="contact-form-wthreelayouts">
                        <form action="#" method="post" class="register-wthree">
                            <div class="form-group">
                                <label>
                                    Nom
                                </label>
                                <input class="form-control nom" type="text" placeholder="Johnson" name="email" required="">
                            </div>
                            <div class="form-group">
                                <label>
                                    Telephone
                                </label>
                                <input class="form-control telephone" type="text" placeholder="xxxx xxxxx" name="email" required="" onkeypress="chiffres(event);">
                            </div>
                            <div class="form-group">
                                <label>
                                    Email
                                </label>
                                <input class="form-control email" type="email" placeholder="example@email.com" name="email"
                                    required="">
                            </div>
                            <div class="form-group">
                                <label>
                                  Pays
                                </label>
                        <select name="pays" class="form-control pays">
                            <option value="France" selected="selected">France </option>

                            <option value="Afghanistan">Afghanistan </option>
                            <option value="Afrique_Centrale">Afrique_Centrale </option>
                            <option value="Afrique_du_sud">Afrique_du_Sud </option>
                            <option value="Albanie">Albanie </option>
                            <option value="Algerie">Algerie </option>
                            <option value="Allemagne">Allemagne </option>
                            <option value="Andorre">Andorre </option>
                            <option value="Angola">Angola </option>
                            <option value="Anguilla">Anguilla </option>
                            <option value="Arabie_Saoudite">Arabie_Saoudite </option>
                            <option value="Argentine">Argentine </option>
                            <option value="Armenie">Armenie </option>
                            <option value="Australie">Australie </option>
                            <option value="Autriche">Autriche </option>
                            <option value="Azerbaidjan">Azerbaidjan </option>

                            <option value="Bahamas">Bahamas </option>
                            <option value="Bangladesh">Bangladesh </option>
                            <option value="Barbade">Barbade </option>
                            <option value="Bahrein">Bahrein </option>
                            <option value="Belgique">Belgique </option>
                            <option value="Belize">Belize </option>
                            <option value="Benin">Benin </option>
                            <option value="Bermudes">Bermudes </option>
                            <option value="Bielorussie">Bielorussie </option>
                            <option value="Bolivie">Bolivie </option>
                            <option value="Botswana">Botswana </option>
                            <option value="Bhoutan">Bhoutan </option>
                            <option value="Boznie_Herzegovine">Boznie_Herzegovine </option>
                            <option value="Bresil">Bresil </option>
                            <option value="Brunei">Brunei </option>
                            <option value="Bulgarie">Bulgarie </option>
                            <option value="Burkina_Faso">Burkina_Faso </option>
                            <option value="Burundi">Burundi </option>

                            <option value="Caiman">Caiman </option>
                            <option value="Cambodge">Cambodge </option>
                            <option value="Cameroun">Cameroun </option>
                            <option value="Canada">Canada </option>
                            <option value="Canaries">Canaries </option>
                            <option value="Cap_vert">Cap_Vert </option>
                            <option value="Chili">Chili </option>
                            <option value="Chine">Chine </option>
                            <option value="Chypre">Chypre </option>
                            <option value="Colombie">Colombie </option>
                            <option value="Comores">Colombie </option>
                            <option value="Congo">Congo </option>
                            <option value="Congo_democratique">Congo_democratique </option>
                            <option value="Cook">Cook </option>
                            <option value="Coree_du_Nord">Coree_du_Nord </option>
                            <option value="Coree_du_Sud">Coree_du_Sud </option>
                            <option value="Costa_Rica">Costa_Rica </option>
                            <option value="Cote_d_Ivoire">Côte_d_Ivoire </option>
                            <option value="Croatie">Croatie </option>
                            <option value="Cuba">Cuba </option>

                            <option value="Danemark">Danemark </option>
                            <option value="Djibouti">Djibouti </option>
                            <option value="Dominique">Dominique </option>

                            <option value="Egypte">Egypte </option>
                            <option value="Emirats_Arabes_Unis">Emirats_Arabes_Unis </option>
                            <option value="Equateur">Equateur </option>
                            <option value="Erythree">Erythree </option>
                            <option value="Espagne">Espagne </option>
                            <option value="Estonie">Estonie </option>
                            <option value="Etats_Unis">Etats_Unis </option>
                            <option value="Ethiopie">Ethiopie </option>

                            <option value="Falkland">Falkland </option>
                            <option value="Feroe">Feroe </option>
                            <option value="Fidji">Fidji </option>
                            <option value="Finlande">Finlande </option>
                            <option value="France">France </option>

                            <option value="Gabon">Gabon </option>
                            <option value="Gambie">Gambie </option>
                            <option value="Georgie">Georgie </option>
                            <option value="Ghana">Ghana </option>
                            <option value="Gibraltar">Gibraltar </option>
                            <option value="Grece">Grece </option>
                            <option value="Grenade">Grenade </option>
                            <option value="Groenland">Groenland </option>
                            <option value="Guadeloupe">Guadeloupe </option>
                            <option value="Guam">Guam </option>
                            <option value="Guatemala">Guatemala</option>
                            <option value="Guernesey">Guernesey </option>
                            <option value="Guinee">Guinee </option>
                            <option value="Guinee_Bissau">Guinee_Bissau </option>
                            <option value="Guinee equatoriale">Guinee_Equatoriale </option>
                            <option value="Guyana">Guyana </option>
                            <option value="Guyane_Francaise ">Guyane_Francaise </option>

                            <option value="Haiti">Haiti </option>
                            <option value="Hawaii">Hawaii </option>
                            <option value="Honduras">Honduras </option>
                            <option value="Hong_Kong">Hong_Kong </option>
                            <option value="Hongrie">Hongrie </option>

                            <option value="Inde">Inde </option>
                            <option value="Indonesie">Indonesie </option>
                            <option value="Iran">Iran </option>
                            <option value="Iraq">Iraq </option>
                            <option value="Irlande">Irlande </option>
                            <option value="Islande">Islande </option>
                            <option value="Israel">Israel </option>
                            <option value="Italie">italie </option>

                            <option value="Jamaique">Jamaique </option>
                            <option value="Jan Mayen">Jan Mayen </option>
                            <option value="Japon">Japon </option>
                            <option value="Jersey">Jersey </option>
                            <option value="Jordanie">Jordanie </option>

                            <option value="Kazakhstan">Kazakhstan </option>
                            <option value="Kenya">Kenya </option>
                            <option value="Kirghizstan">Kirghizistan </option>
                            <option value="Kiribati">Kiribati </option>
                            <option value="Koweit">Koweit </option>

                            <option value="Laos">Laos </option>
                            <option value="Lesotho">Lesotho </option>
                            <option value="Lettonie">Lettonie </option>
                            <option value="Liban">Liban </option>
                            <option value="Liberia">Liberia </option>
                            <option value="Liechtenstein">Liechtenstein </option>
                            <option value="Lituanie">Lituanie </option>
                            <option value="Luxembourg">Luxembourg </option>
                            <option value="Lybie">Lybie </option>

                            <option value="Macao">Macao </option>
                            <option value="Macedoine">Macedoine </option>
                            <option value="Madagascar">Madagascar </option>
                            <option value="Madère">Madère </option>
                            <option value="Malaisie">Malaisie </option>
                            <option value="Malawi">Malawi </option>
                            <option value="Maldives">Maldives </option>
                            <option value="Mali">Mali </option>
                            <option value="Malte">Malte </option>
                            <option value="Man">Man </option>
                            <option value="Mariannes du Nord">Mariannes du Nord </option>
                            <option value="Maroc">Maroc </option>
                            <option value="Marshall">Marshall </option>
                            <option value="Martinique">Martinique </option>
                            <option value="Maurice">Maurice </option>
                            <option value="Mauritanie">Mauritanie </option>
                            <option value="Mayotte">Mayotte </option>
                            <option value="Mexique">Mexique </option>
                            <option value="Micronesie">Micronesie </option>
                            <option value="Midway">Midway </option>
                            <option value="Moldavie">Moldavie </option>
                            <option value="Monaco">Monaco </option>
                            <option value="Mongolie">Mongolie </option>
                            <option value="Montserrat">Montserrat </option>
                            <option value="Mozambique">Mozambique </option>

                            <option value="Namibie">Namibie </option>
                            <option value="Nauru">Nauru </option>
                            <option value="Nepal">Nepal </option>
                            <option value="Nicaragua">Nicaragua </option>
                            <option value="Niger">Niger </option>
                            <option value="Nigeria">Nigeria </option>
                            <option value="Niue">Niue </option>
                            <option value="Norfolk">Norfolk </option>
                            <option value="Norvege">Norvege </option>
                            <option value="Nouvelle_Caledonie">Nouvelle_Caledonie </option>
                            <option value="Nouvelle_Zelande">Nouvelle_Zelande </option>

                            <option value="Oman">Oman </option>
                            <option value="Ouganda">Ouganda </option>
                            <option value="Ouzbekistan">Ouzbekistan </option>

                            <option value="Pakistan">Pakistan </option>
                            <option value="Palau">Palau </option>
                            <option value="Palestine">Palestine </option>
                            <option value="Panama">Panama </option>
                            <option value="Papouasie_Nouvelle_Guinee">Papouasie_Nouvelle_Guinee </option>
                            <option value="Paraguay">Paraguay </option>
                            <option value="Pays_Bas">Pays_Bas </option>
                            <option value="Perou">Perou </option>
                            <option value="Philippines">Philippines </option>
                            <option value="Pologne">Pologne </option>
                            <option value="Polynesie">Polynesie </option>
                            <option value="Porto_Rico">Porto_Rico </option>
                            <option value="Portugal">Portugal </option>

                            <option value="Qatar">Qatar </option>

                            <option value="Republique_Dominicaine">Republique_Dominicaine </option>
                            <option value="Republique_Tcheque">Republique_Tcheque </option>
                            <option value="Reunion">Reunion </option>
                            <option value="Roumanie">Roumanie </option>
                            <option value="Royaume_Uni">Royaume_Uni </option>
                            <option value="Russie">Russie </option>
                            <option value="Rwanda">Rwanda </option>

                            <option value="Sahara Occidental">Sahara Occidental </option>
                            <option value="Sainte_Lucie">Sainte_Lucie </option>
                            <option value="Saint_Marin">Saint_Marin </option>
                            <option value="Salomon">Salomon </option>
                            <option value="Salvador">Salvador </option>
                            <option value="Samoa_Occidentales">Samoa_Occidentales</option>
                            <option value="Samoa_Americaine">Samoa_Americaine </option>
                            <option value="Sao_Tome_et_Principe">Sao_Tome_et_Principe </option>
                            <option value="Senegal">Senegal </option>
                            <option value="Seychelles">Seychelles </option>
                            <option value="Sierra Leone">Sierra Leone </option>
                            <option value="Singapour">Singapour </option>
                            <option value="Slovaquie">Slovaquie </option>
                            <option value="Slovenie">Slovenie</option>
                            <option value="Somalie">Somalie </option>
                            <option value="Soudan">Soudan </option>
                            <option value="Sri_Lanka">Sri_Lanka </option>
                            <option value="Suede">Suede </option>
                            <option value="Suisse">Suisse </option>
                            <option value="Surinam">Surinam </option>
                            <option value="Swaziland">Swaziland </option>
                            <option value="Syrie">Syrie </option>

                            <option value="Tadjikistan">Tadjikistan </option>
                            <option value="Taiwan">Taiwan </option>
                            <option value="Tonga">Tonga </option>
                            <option value="Tanzanie">Tanzanie </option>
                            <option value="Tchad">Tchad </option>
                            <option value="Thailande">Thailande </option>
                            <option value="Tibet">Tibet </option>
                            <option value="Timor_Oriental">Timor_Oriental </option>
                            <option value="Togo">Togo </option>
                            <option value="Trinite_et_Tobago">Trinite_et_Tobago </option>
                            <option value="Tristan da cunha">Tristan de cuncha </option>
                            <option value="Tunisie">Tunisie </option>
                            <option value="Turkmenistan">Turmenistan </option>
                            <option value="Turquie">Turquie </option>

                            <option value="Ukraine">Ukraine </option>
                            <option value="Uruguay">Uruguay </option>

                            <option value="Vanuatu">Vanuatu </option>
                            <option value="Vatican">Vatican </option>
                            <option value="Venezuela">Venezuela </option>
                            <option value="Vierges_Americaines">Vierges_Americaines </option>
                            <option value="Vierges_Britanniques">Vierges_Britanniques </option>
                            <option value="Vietnam">Vietnam </option>

                            <option value="Wake">Wake </option>
                            <option value="Wallis et Futuma">Wallis et Futuma </option>

                            <option value="Yemen">Yemen </option>
                            <option value="Yougoslavie">Yougoslavie </option>

                            <option value="Zambie">Zambie </option>
                            <option value="Zimbabwe">Zimbabwe </option>

                        </select>
                            </div>
                            <div class="form-group mb-0">
                                <button type="button" class="btn btn-w3layouts btn-block  bg-theme text-wh w-100 font-weight-bold text-uppercase sendClient" onclick="addClient();">Envoyer</button>
                            </div>
                        </form>
                    </div>
                     <div class="splide" >

      <div class="splide__track" >

        <ul class="splide__list" >

          '.$images.'

        </ul>

      </div>

    </div>
<!-- view source -->

<br/>
    <div class="splide__progress">

      <div class="splide__progress__bar">

      </div>

    </div>
                </div>
                <div class="col-lg-5 text-center">
                    <h5 class="cont-form">Payez en un clic</h5>
                    <div class="row flex-column">
                    <div class="contact-w3 my-4">
                            <span class="fa fa-pencil mb-3"></span>
                            <div class="d-flex flex-column">
                                <p> Assurez vous d\'avoir rempli le formulaire avant de valider votre achat</p>
                            </div>
                        </div>
                        <div class="contact-w3 my-4 formPaiement" style="display:none; background:#4d8186; ">
                            <span class="fa fa-money mb-3"></span>
                            <div class="d-flex flex-column">
                                <p style="color: white;">Payer avec wecashup par mobile money</p>
                                 <form action= "https://www.ejsmartjobs.com/fr/admin/Callback" method= "POST" id= "wecashup" style=""> 
                                 <script async src= "https://www.wecashup.com/library/MobileMoney.js" 
                                     class= "wecashup_button"
                                     data-demo data-sender-lang= "fr" 
                                     data-sender-phonenumber= "" 
                                     data-receiver-uid= "u6mrnQdqjNUh70BP2RQVDjiIFWB3" 
                                     data-receiver-public-key= "pk_test_sLNDV4ketC8vnAnn" 
                                     data-transaction-parent-uid= "" 
                                     data-transaction-receiver-total-amount= "'.$prix.'"
                                     data-transaction-receiver-reference= "XVT2VBF" 
                                     data-transaction-sender-reference= "XVT2VBF" 
                                     data-sender-firstname= "Test" 
                                     data-sender-lastname= "Test" 
                                     data-transaction-method= "pull" 
                                     data-image= "'.base_url().'assets/images/logo.png"
                                     data-name= "EJSMARTJOBS" 
                                     data-crypto= "true" 
                                     data-cash= "true" 
                                     data-telecom= "true" 
                                     data-m-wallet= "true" 
                                     data-split= "true" 
                                     configuration-id= "3" 
                                     data-marketplace-mode= "false" 
                                     data-product-1-name= "Billet ABJ PRS" 
                                     data-product-1-quantity= "1" 
                                     data-product-1-unit-price= "'.$prix.'" 
                                     data-product-1-reference= "XVT2VBF" 
                                     data-product-1-category= "Billeterie" d
                                     ata-product-1-description= "France is in the Air" > 
                                 </script> 
                                </form>
                            </div>
                        </div>
                        <br/>
                        <div class="contact-w3">
                            <span class="fa fa-envelope-open  mb-3"></span>
                            <div class="d-flex flex-column">
                                <a href="mailto:Marie.donfack@ejmartjobs.com" class="d-block">Marie.donfack@ejmartjobs.com</a>
                                <a href="mailto:example@email.com" class="my-2 d-block">info@example2.com</a>
                                <a href="donfack.marie@yahoo.fr">donfack.marie@yahoo.fr/a>
                            </div>
                        </div>
                        <div class="contact-w3 my-4">
                            <span class="fa fa-phone mb-3"></span>
                            <div class="d-flex flex-column">
                                <p>+33 783 91 34 55 7890</p>
                            </div>
                        </div>
                        
                       

                    </div>

                </div>
            </div>
        </div>
    </section>


    ';
    }
    }

		public function selectAllLM(){
		// dans cette partie deu code nous allons sélectionner les cv et les vendre
        $query1 = $this->db->get_where('modelelm')->result_array();
        $compteur = 0;
        $rien = "_";
        echo "<form action='".base_url().$this->session->userdata('language_abbr')."/admin/panierLM' method='post'>
            <input type='submit' name='panier' value = '0' class='btnEnvoyer' style='color:red;font-size: 40px' > 
            <input type=\"hidden\" value=\"\" class=\"champPrix\" name=\"prix\">
            <input type=\"hidden\" value=\"\" class=\"compteur\" name=\"compteur\">
            <input type=\"hidden\" value=\"\" class=\"listeCV\" name=\"listeCV\">
            </form>";
        foreach ($query1 as $row1){
                echo '<input type="hidden" value="'.$compteur.'" class="compteur" name="compteur"> 
            
            
            <input type="hidden" value="" class="nbreCV" name="nbreCV"><div class="col-md-3">
                <div class="custom-control custom-checkbox image-checkbox">
                    <input type="checkbox" class="custom-control-input '.$row1["id_modeleLM"].'" id="ck'.$compteur.'" prix'.$compteur.'="'.$row1["prix"].'" selecteur'.$compteur.'="'.$row1["id_modeleLM"].'" value="'.$row1["id_modeleLM"].'" name="cv'.$compteur.'">
                    <label class="custom-control-label" for="ck'.$compteur.'">
                        <img src="'.base_url().'assets/images/motivation/captures/'.$row1["nom_lm"].'" alt="#" class="img-fluid">
                        <div class="contentPrix" style="">
                          <h3 class="title" style="color: white;">'.$row1["prix"].' €</h3>
                        </div>
                    </label>
                   <ul class="social" style="text-align: center;">
                           
                    <li><a style="" class="jaime"><i class="fa fa-thumbs-o-up"></i></a></li>
                 </ul>
                </div>
                </div>
                <script type="text/javascript">
                // $(".champPrix").val("");
                var listeId = [];
                if($("#ck'.$compteur.'").is(":checked")){
                       prix = $(".champPrix").val();
                       prix = '.$row1["prix"].' + Number(prix) ;
                       $(".champPrix").val(prix);
                        
                       nbreCV = $(".nbreCV").val();
                       nbreCV = Number(nbreCV) +1;
                       $(".nbreCV").val(nbreCV);
                       listeId['.$compteur.'] = '.$row1["id_modeleLM"].';
                       // alert(prix);
                       $(".champPrix").val(prix);
                        maListe = JSON.stringify(listeId);
                        $(".listeCV").val(maListe);
                    }
                   if($(".champPrix").val() == 0){
                     $(".btnEnvoyer").attr("disabled","true");
                                       }else{
                            
                        $(".btnEnvoyer").removeAttr("disabled","false");
                        }

                $("#ck'.$compteur.'").click(function(){
                    // alert("#ck'.$compteur.'")
                    if($("#ck'.$compteur.'").is(":checked")){
                        nbre = $(".btnEnvoyer").val();
                        nbre2 = Number(nbre)+1;
                        $(".btnEnvoyer").empty();
                        $(".btnEnvoyer").val(nbre2);
                        
                       prix = $(".champPrix").val();
                       prix = '.$row1["prix"].' + Number(prix) ;
                       $(".champPrix").val(prix);

                       nbreCV = $(".nbreCV").val();
                       nbreCV = Number(nbreCV) +1;
                       $(".nbreCV").val(nbreCV);
                       listeId['.$compteur.'] = '.$row1["id_modeleLM"].';
                       // alert(listeId['.$compteur.']);
                    
                    }else{
                        nbre = $(".btnEnvoyer").val();
                        nbre2 = Number(nbre)-1;
                        $(".btnEnvoyer").empty();
                        $(".btnEnvoyer").val(nbre2);
                     // prix = $(".champPrix").val();
                       prix = Number(prix) - '.$row1["prix"].';
                       $(".champPrix").val(prix);

                       nbreCV = $(".nbreCV").val();
                       nbreCV = Number(nbreCV) -1;
                       $(".nbreCV").val(nbreCV);
                       listeId['.$compteur.'] = "";
                       // alert(listeId['.$compteur.']);
                    }
                    maListe = JSON.stringify(listeId);
                $(".listeCV").val(maListe);
                if($(".champPrix").val() == 0){
                        $(".btnEnvoyer").attr("disabled","true");
                      
                        }else{
                        $(".btnEnvoyer").removeAttr("disabled","false");
                        }
                    });
                </script>';
                $compteur+=1; 
            }
            echo '
            
            <input type="hidden" value="" class="nbreCV" name="nbreCV">
            
            <script type="text/javascript">
                $(".compteur").val("'.$compteur.'");
                
                </script>;
            ';
            $this->db->close();
	}

    public function panierLM(){
        
        if(!isset($_POST['prix'],$_POST['listeCV'],$_POST['compteur'])){
            echo '<script>top.window.location = "'.base_url().$this->session->userdata('language_abbr').'/admin/modelesLM"</script>';
        }else{
           $prix = $_POST['prix'];
        $listeCV=json_decode($_POST['listeCV']);
        $this->session->set_userdata('tabCV',$listeCV);
        $nbreCV = $_POST['compteur'];
        $nombre= 0;
        $images = ""; 

        foreach ($listeCV as $key => $value) { 
            # code...
            $nombre+=1;
            // echo "hey ".$listeCV[$key];
           if ($listeCV[$key] =="") {
                    # code...
                    // ici on vérifie qu'on a pas récupéré un élément vide
                    // echo "rien rien";
                }else{
                    // echo "cv: ".$listeCV[$key];
                    $reference = array('id_modeleLM' => $listeCV[$key]);
                    $query = $this->db->get_where('modelelm', $reference);
                    $row = $query->row();
                    $nom_cv = $row->nom_lm;
                    $images.='<li class="splide__slide"><img src="'.base_url().'assets/images/motivation/captures/'.$nom_cv.'"></li>';

                }
        }
        // echo " le nombre est: ".$nombre;
         echo '<section class="contact-wthree align-w3" id="contact">
        <div class="container">
            <div class="wthree_pvt_title text-center">
                <h4 class="w3pvt-title">Panier de LM
                </h4>
                <p class="sub-title">Bienvenue dans votre panier le nombre total de CV que vous avez sélectioné est de:'.$nombre.'
                pour un montant total de '.$prix.' € .</p>
            </div>
          
            <div class="row mt-4">
                <div class="col-lg-7">
                    <h5 class="cont-form">Veuillez remplir ce formulaire SVP</h5>
                    <div class="contact-form-wthreelayouts">
                        <form action="#" method="post" class="register-wthree">
                            <div class="form-group">
                                <label>
                                    Nom
                                </label>
                                <input class="form-control nom" type="text" placeholder="Johnson" name="email" required="">
                            </div>
                            <div class="form-group">
                                <label>
                                    Telephone
                                </label>
                                <input class="form-control telephone" type="text" placeholder="xxxx xxxxx" name="email" required="" onkeypress="chiffres(event);">
                            </div>
                            <div class="form-group">
                                <label>
                                    Email
                                </label>
                                <input class="form-control email" type="email" placeholder="example@email.com" name="email"
                                    required="">
                            </div>
                            <div class="form-group">
                                <label>
                                  Pays
                                </label>
                        <select name="pays" class="form-control pays">
                            <option value="France" selected="selected">France </option>

                            <option value="Afghanistan">Afghanistan </option>
                            <option value="Afrique_Centrale">Afrique_Centrale </option>
                            <option value="Afrique_du_sud">Afrique_du_Sud </option>
                            <option value="Albanie">Albanie </option>
                            <option value="Algerie">Algerie </option>
                            <option value="Allemagne">Allemagne </option>
                            <option value="Andorre">Andorre </option>
                            <option value="Angola">Angola </option>
                            <option value="Anguilla">Anguilla </option>
                            <option value="Arabie_Saoudite">Arabie_Saoudite </option>
                            <option value="Argentine">Argentine </option>
                            <option value="Armenie">Armenie </option>
                            <option value="Australie">Australie </option>
                            <option value="Autriche">Autriche </option>
                            <option value="Azerbaidjan">Azerbaidjan </option>

                            <option value="Bahamas">Bahamas </option>
                            <option value="Bangladesh">Bangladesh </option>
                            <option value="Barbade">Barbade </option>
                            <option value="Bahrein">Bahrein </option>
                            <option value="Belgique">Belgique </option>
                            <option value="Belize">Belize </option>
                            <option value="Benin">Benin </option>
                            <option value="Bermudes">Bermudes </option>
                            <option value="Bielorussie">Bielorussie </option>
                            <option value="Bolivie">Bolivie </option>
                            <option value="Botswana">Botswana </option>
                            <option value="Bhoutan">Bhoutan </option>
                            <option value="Boznie_Herzegovine">Boznie_Herzegovine </option>
                            <option value="Bresil">Bresil </option>
                            <option value="Brunei">Brunei </option>
                            <option value="Bulgarie">Bulgarie </option>
                            <option value="Burkina_Faso">Burkina_Faso </option>
                            <option value="Burundi">Burundi </option>

                            <option value="Caiman">Caiman </option>
                            <option value="Cambodge">Cambodge </option>
                            <option value="Cameroun">Cameroun </option>
                            <option value="Canada">Canada </option>
                            <option value="Canaries">Canaries </option>
                            <option value="Cap_vert">Cap_Vert </option>
                            <option value="Chili">Chili </option>
                            <option value="Chine">Chine </option>
                            <option value="Chypre">Chypre </option>
                            <option value="Colombie">Colombie </option>
                            <option value="Comores">Colombie </option>
                            <option value="Congo">Congo </option>
                            <option value="Congo_democratique">Congo_democratique </option>
                            <option value="Cook">Cook </option>
                            <option value="Coree_du_Nord">Coree_du_Nord </option>
                            <option value="Coree_du_Sud">Coree_du_Sud </option>
                            <option value="Costa_Rica">Costa_Rica </option>
                            <option value="Cote_d_Ivoire">Côte_d_Ivoire </option>
                            <option value="Croatie">Croatie </option>
                            <option value="Cuba">Cuba </option>

                            <option value="Danemark">Danemark </option>
                            <option value="Djibouti">Djibouti </option>
                            <option value="Dominique">Dominique </option>

                            <option value="Egypte">Egypte </option>
                            <option value="Emirats_Arabes_Unis">Emirats_Arabes_Unis </option>
                            <option value="Equateur">Equateur </option>
                            <option value="Erythree">Erythree </option>
                            <option value="Espagne">Espagne </option>
                            <option value="Estonie">Estonie </option>
                            <option value="Etats_Unis">Etats_Unis </option>
                            <option value="Ethiopie">Ethiopie </option>

                            <option value="Falkland">Falkland </option>
                            <option value="Feroe">Feroe </option>
                            <option value="Fidji">Fidji </option>
                            <option value="Finlande">Finlande </option>
                            <option value="France">France </option>

                            <option value="Gabon">Gabon </option>
                            <option value="Gambie">Gambie </option>
                            <option value="Georgie">Georgie </option>
                            <option value="Ghana">Ghana </option>
                            <option value="Gibraltar">Gibraltar </option>
                            <option value="Grece">Grece </option>
                            <option value="Grenade">Grenade </option>
                            <option value="Groenland">Groenland </option>
                            <option value="Guadeloupe">Guadeloupe </option>
                            <option value="Guam">Guam </option>
                            <option value="Guatemala">Guatemala</option>
                            <option value="Guernesey">Guernesey </option>
                            <option value="Guinee">Guinee </option>
                            <option value="Guinee_Bissau">Guinee_Bissau </option>
                            <option value="Guinee equatoriale">Guinee_Equatoriale </option>
                            <option value="Guyana">Guyana </option>
                            <option value="Guyane_Francaise ">Guyane_Francaise </option>

                            <option value="Haiti">Haiti </option>
                            <option value="Hawaii">Hawaii </option>
                            <option value="Honduras">Honduras </option>
                            <option value="Hong_Kong">Hong_Kong </option>
                            <option value="Hongrie">Hongrie </option>

                            <option value="Inde">Inde </option>
                            <option value="Indonesie">Indonesie </option>
                            <option value="Iran">Iran </option>
                            <option value="Iraq">Iraq </option>
                            <option value="Irlande">Irlande </option>
                            <option value="Islande">Islande </option>
                            <option value="Israel">Israel </option>
                            <option value="Italie">italie </option>

                            <option value="Jamaique">Jamaique </option>
                            <option value="Jan Mayen">Jan Mayen </option>
                            <option value="Japon">Japon </option>
                            <option value="Jersey">Jersey </option>
                            <option value="Jordanie">Jordanie </option>

                            <option value="Kazakhstan">Kazakhstan </option>
                            <option value="Kenya">Kenya </option>
                            <option value="Kirghizstan">Kirghizistan </option>
                            <option value="Kiribati">Kiribati </option>
                            <option value="Koweit">Koweit </option>

                            <option value="Laos">Laos </option>
                            <option value="Lesotho">Lesotho </option>
                            <option value="Lettonie">Lettonie </option>
                            <option value="Liban">Liban </option>
                            <option value="Liberia">Liberia </option>
                            <option value="Liechtenstein">Liechtenstein </option>
                            <option value="Lituanie">Lituanie </option>
                            <option value="Luxembourg">Luxembourg </option>
                            <option value="Lybie">Lybie </option>

                            <option value="Macao">Macao </option>
                            <option value="Macedoine">Macedoine </option>
                            <option value="Madagascar">Madagascar </option>
                            <option value="Madère">Madère </option>
                            <option value="Malaisie">Malaisie </option>
                            <option value="Malawi">Malawi </option>
                            <option value="Maldives">Maldives </option>
                            <option value="Mali">Mali </option>
                            <option value="Malte">Malte </option>
                            <option value="Man">Man </option>
                            <option value="Mariannes du Nord">Mariannes du Nord </option>
                            <option value="Maroc">Maroc </option>
                            <option value="Marshall">Marshall </option>
                            <option value="Martinique">Martinique </option>
                            <option value="Maurice">Maurice </option>
                            <option value="Mauritanie">Mauritanie </option>
                            <option value="Mayotte">Mayotte </option>
                            <option value="Mexique">Mexique </option>
                            <option value="Micronesie">Micronesie </option>
                            <option value="Midway">Midway </option>
                            <option value="Moldavie">Moldavie </option>
                            <option value="Monaco">Monaco </option>
                            <option value="Mongolie">Mongolie </option>
                            <option value="Montserrat">Montserrat </option>
                            <option value="Mozambique">Mozambique </option>

                            <option value="Namibie">Namibie </option>
                            <option value="Nauru">Nauru </option>
                            <option value="Nepal">Nepal </option>
                            <option value="Nicaragua">Nicaragua </option>
                            <option value="Niger">Niger </option>
                            <option value="Nigeria">Nigeria </option>
                            <option value="Niue">Niue </option>
                            <option value="Norfolk">Norfolk </option>
                            <option value="Norvege">Norvege </option>
                            <option value="Nouvelle_Caledonie">Nouvelle_Caledonie </option>
                            <option value="Nouvelle_Zelande">Nouvelle_Zelande </option>

                            <option value="Oman">Oman </option>
                            <option value="Ouganda">Ouganda </option>
                            <option value="Ouzbekistan">Ouzbekistan </option>

                            <option value="Pakistan">Pakistan </option>
                            <option value="Palau">Palau </option>
                            <option value="Palestine">Palestine </option>
                            <option value="Panama">Panama </option>
                            <option value="Papouasie_Nouvelle_Guinee">Papouasie_Nouvelle_Guinee </option>
                            <option value="Paraguay">Paraguay </option>
                            <option value="Pays_Bas">Pays_Bas </option>
                            <option value="Perou">Perou </option>
                            <option value="Philippines">Philippines </option>
                            <option value="Pologne">Pologne </option>
                            <option value="Polynesie">Polynesie </option>
                            <option value="Porto_Rico">Porto_Rico </option>
                            <option value="Portugal">Portugal </option>

                            <option value="Qatar">Qatar </option>

                            <option value="Republique_Dominicaine">Republique_Dominicaine </option>
                            <option value="Republique_Tcheque">Republique_Tcheque </option>
                            <option value="Reunion">Reunion </option>
                            <option value="Roumanie">Roumanie </option>
                            <option value="Royaume_Uni">Royaume_Uni </option>
                            <option value="Russie">Russie </option>
                            <option value="Rwanda">Rwanda </option>

                            <option value="Sahara Occidental">Sahara Occidental </option>
                            <option value="Sainte_Lucie">Sainte_Lucie </option>
                            <option value="Saint_Marin">Saint_Marin </option>
                            <option value="Salomon">Salomon </option>
                            <option value="Salvador">Salvador </option>
                            <option value="Samoa_Occidentales">Samoa_Occidentales</option>
                            <option value="Samoa_Americaine">Samoa_Americaine </option>
                            <option value="Sao_Tome_et_Principe">Sao_Tome_et_Principe </option>
                            <option value="Senegal">Senegal </option>
                            <option value="Seychelles">Seychelles </option>
                            <option value="Sierra Leone">Sierra Leone </option>
                            <option value="Singapour">Singapour </option>
                            <option value="Slovaquie">Slovaquie </option>
                            <option value="Slovenie">Slovenie</option>
                            <option value="Somalie">Somalie </option>
                            <option value="Soudan">Soudan </option>
                            <option value="Sri_Lanka">Sri_Lanka </option>
                            <option value="Suede">Suede </option>
                            <option value="Suisse">Suisse </option>
                            <option value="Surinam">Surinam </option>
                            <option value="Swaziland">Swaziland </option>
                            <option value="Syrie">Syrie </option>

                            <option value="Tadjikistan">Tadjikistan </option>
                            <option value="Taiwan">Taiwan </option>
                            <option value="Tonga">Tonga </option>
                            <option value="Tanzanie">Tanzanie </option>
                            <option value="Tchad">Tchad </option>
                            <option value="Thailande">Thailande </option>
                            <option value="Tibet">Tibet </option>
                            <option value="Timor_Oriental">Timor_Oriental </option>
                            <option value="Togo">Togo </option>
                            <option value="Trinite_et_Tobago">Trinite_et_Tobago </option>
                            <option value="Tristan da cunha">Tristan de cuncha </option>
                            <option value="Tunisie">Tunisie </option>
                            <option value="Turkmenistan">Turmenistan </option>
                            <option value="Turquie">Turquie </option>

                            <option value="Ukraine">Ukraine </option>
                            <option value="Uruguay">Uruguay </option>

                            <option value="Vanuatu">Vanuatu </option>
                            <option value="Vatican">Vatican </option>
                            <option value="Venezuela">Venezuela </option>
                            <option value="Vierges_Americaines">Vierges_Americaines </option>
                            <option value="Vierges_Britanniques">Vierges_Britanniques </option>
                            <option value="Vietnam">Vietnam </option>

                            <option value="Wake">Wake </option>
                            <option value="Wallis et Futuma">Wallis et Futuma </option>

                            <option value="Yemen">Yemen </option>
                            <option value="Yougoslavie">Yougoslavie </option>

                            <option value="Zambie">Zambie </option>
                            <option value="Zimbabwe">Zimbabwe </option>

                        </select>
                            </div>
                            <div class="form-group mb-0">
                                <button type="button" class="btn btn-w3layouts btn-block  bg-theme text-wh w-100 font-weight-bold text-uppercase sendClient" onclick="addClient();">Envoyer</button>
                            </div>
                        </form>
                    </div>
                     <div class="splide" >

      <div class="splide__track" >

        <ul class="splide__list" >

          '.$images.'

        </ul>

      </div>

    </div>
<!-- view source -->

<br/>
    <div class="splide__progress">

      <div class="splide__progress__bar">

      </div>

    </div>
                </div>
                <div class="col-lg-5 text-center">
                    <h5 class="cont-form">Payez en un clic</h5>
                    <div class="row flex-column">
                    <div class="contact-w3 my-4">
                            <span class="fa fa-pencil mb-3"></span>
                            <div class="d-flex flex-column">
                                <p> Assurez vous d\'avoir rempli le formulaire avant de valider votre achat</p>
                            </div>
                        </div>
                        <div class="contact-w3 my-4 formPaiement" style="display:none; background:#4d8186; ">
                            <span class="fa fa-money mb-3"></span>
                            <div class="d-flex flex-column">
                                <p style="color: white;">Payer avec wecashup par mobile money</p>
                                 <form action= "https://www.ejsmartjobs.com/fr/admin/Callback" method= "POST" id= "wecashup" style=""> 
                                 <script async src= "https://www.wecashup.com/library/MobileMoney.js" 
                                     class= "wecashup_button"
                                     data-demo data-sender-lang= "fr" 
                                     data-sender-phonenumber= "" 
                                     data-receiver-uid= "u6mrnQdqjNUh70BP2RQVDjiIFWB3" 
                                     data-receiver-public-key= "pk_live_duvyLQiGmYKBHNcu" 
                                     data-transaction-parent-uid= "" 
                                     data-transaction-receiver-total-amount= "'.$prix.'"
                                     data-transaction-receiver-reference= "XVT2VBF" 
                                     data-transaction-sender-reference= "XVT2VBF" 
                                     data-sender-firstname= "Test" 
                                     data-sender-lastname= "Test" 
                                     data-transaction-method= "pull" 
                                     data-image= "'.base_url().'assets/images/logo.png"
                                     data-name= "EJSMARTJOBS" 
                                     data-crypto= "true" 
                                     data-cash= "true" 
                                     data-telecom= "true" 
                                     data-m-wallet= "true" 
                                     data-split= "true" 
                                     configuration-id= "3" 
                                     data-marketplace-mode= "false" 
                                     data-product-1-name= "Billet ABJ PRS" 
                                     data-product-1-quantity= "1" 
                                     data-product-1-unit-price= "'.$prix.'" 
                                     data-product-1-reference= "XVT2VBF" 
                                     data-product-1-category= "Billeterie" d
                                     ata-product-1-description= "France is in the Air" > 
                                 </script> 
                                </form>
                            </div>
                        </div>
                        <br/>
                        <div class="contact-w3">
                            <span class="fa fa-envelope-open  mb-3"></span>
                            <div class="d-flex flex-column">
                                <a href="mailto:Marie.donfack@ejmartjobs.com" class="d-block">Marie.donfack@ejmartjobs.com</a>
                                <a href="mailto:example@email.com" class="my-2 d-block">info@example2.com</a>
                                <a href="donfack.marie@yahoo.fr">donfack.marie@yahoo.fr/a>
                            </div>
                        </div>
                        <div class="contact-w3 my-4">
                            <span class="fa fa-phone mb-3"></span>
                            <div class="d-flex flex-column">
                                <p>+33 783 91 34 55 7890</p>
                            </div>
                        </div>
                        
                       

                    </div>

                </div>
            </div>
        </div>
    </section>


    ';
    }
    }

	public function imageResize($imageResourceId,$width,$height) {


    $targetWidth =355;

    $targetHeight =504;


    $targetLayer=imagecreatetruecolor($targetWidth,$targetHeight);

    imagecopyresampled($targetLayer,$imageResourceId,0,0,0,0,$targetWidth,$targetHeight, $width,$height);


    return $targetLayer;

	}

	public function top20CV(){
	// $lewhere = array("nom_cv" => $realname. "_thump.". $ext);
	$this->db->order_by('Nbrelike', 'asc');
	$this->db->limit(20);
    $query2 = $this->db->get_where('modelecv')->result_array();
     
       if ($query2 == true) {
       	# code...
       	foreach ($query2 as $row2) {
       	echo '
       	<div class="item modelecv" ><img src="'.base_url().'assets/images/cv/captures/'.$row2["nom_cv"].'" alt="Mon image 1" /><h1>  <a href="'.base_url().$this->session->userdata('language_abbr').'/admin/modelesCV"> <img src="'.base_url().'assets/images/icones/telech1.png" alt="Mon image 1"  style="height: 90px; width: 90px;"/></h1><a> </div>';
       }
       }    
            
	}
    public function sendPaiementCV($transaction_uid,$transaction_token,$transaction_provider_name,$transaction_confirmation_code){
        $reference = array('email' => $this->session->userdata('emailClient'));
                    $query = $this->db->get_where('client', $reference);
                    $row = $query->row();
                   
$listeCV = $this->session->userdata('tabCV');
// echo "the hight est :".count($listeCV);

    for ($i = 0; $i <=  count($listeCV); $i++) {
        
         if (empty($listeCV[$i])) {
             # code...
         }else{
             // echo "le CV est :".$listeCV[$i];
              $query1 = $this->db->query("insert into paiement value('',".$row->id_client.",".$listeCV[$i].",'','".$transaction_uid."','".$transaction_token."','".$transaction_provider_name."','".$transaction_confirmation_code."',1,now())");
                if ($query1 == true) {
                    # code...
                    // echo "sauvegarde réussie";
                }
            }
         }
        // if ($listeCV[$i]==="") {
        //     # code...
        //     echo "rien";
        // }else{
        //     echo "oui";
        //         $query1 = $this->db->query("insert into paiement value('',".$row->id_client.",".$listeCV[$i].",'','".$transaction_uid."','".$transaction_token."','".$transaction_provider_name."','".$transaction_confirmation_code."',1,now())");
        //         if ($query1 == true) {
        //             # code...
        //             // echo "sauvegarde réussie";
        //         }
        //     }
             // echo "le cv est ".$listeCV[$key];

             // echo "le nom du client est : ".$this->session->userdata('nomClient')." et email: ".$this->session->userdata('emailClient')." pays : ".$this->session->userdata('pays')." telephone : ".$this->session->userdata('telephone');
           $this->sentCVParMail($listeCV,$this->session->userdata('emailClient'));
        }

     public function sendPaiementLM($transaction_uid,$transaction_token,$transaction_provider_name,$transaction_confirmation_code){
        $reference = array('email' => $this->session->userdata('emailClient'));
                    $query = $this->db->get_where('client', $reference);
                    $row = $query->row();
                   
$listeCV = $this->session->userdata('tabCV');
// echo "the hight est :".count($listeCV);

    for ($i = 0; $i <=  count($listeCV); $i++) {
        
         if (empty($listeCV[$i])) {
             # code...
         }else{
             // echo "le CV est :".$listeCV[$i];
              $query1 = $this->db->query("insert into paiement value('',".$row->id_client.",'',".$listeCV[$i].",'".$transaction_uid."','".$transaction_token."','".$transaction_provider_name."','".$transaction_confirmation_code."',1,now())");
                if ($query1 == true) {
                    # code...
                    // echo "sauvegarde réussie";
                }
            }
         }
        // if ($listeCV[$i]==="") {
        //     # code...
        //     echo "rien";
        // }else{
        //     echo "oui";
        //         $query1 = $this->db->query("insert into paiement value('',".$row->id_client.",".$listeCV[$i].",'','".$transaction_uid."','".$transaction_token."','".$transaction_provider_name."','".$transaction_confirmation_code."',1,now())");
        //         if ($query1 == true) {
        //             # code...
        //             // echo "sauvegarde réussie";
        //         }
        //     }
             // echo "le cv est ".$listeCV[$key];

             // echo "le nom du client est : ".$this->session->userdata('nomClient')." et email: ".$this->session->userdata('emailClient')." pays : ".$this->session->userdata('pays')." telephone : ".$this->session->userdata('telephone');
           $this->sentLMParMail($listeCV,$this->session->userdata('emailClient'));
        }   

    public function addClient(){
        $nom = $_POST["nom"];

        $telephone = $_POST["telephone"];

        $email = $_POST["email"];

        $pays = $_POST["pays"];

        $this->session->set_userdata('nomClient',$nom);

        $this->session->set_userdata('emailClient',$email);

        $this->session->set_userdata('pays',$pays  );

        $this->session->set_userdata('telephone',$telephone  );

        $query1 = $this->db->query("insert into client value('','".$nom."',".$telephone.",'".$email."','".$pays."',now())");
        if ($query1 == true) {
            # code...
            echo "sauvegarde réussie";
        }
            
        // echo "le nom du client est : ".$this->session->userdata('nomClient')." et email: ".$this->session->userdata('emailClient')." pays : ".$this->session->userdata('pays')." telephone : ".$this->session->userdata('telephone');






    }

    public function sentCVParMail($liste,$destinataire){
                        $rien = "";
        $destinataires = $destinataire; 

        // Objet. 
        $objet = "Liste des Fichiers reçu d'EJSMARTJOBS !"; 


        // Entêtes supplémentaires. 
        $entêtes  = ""; 
        // -> origine du message 
        $entêtes .= "From: < Marie.donfack@ejsmartjobs.com>\r\n"; 
        // -> message au format Multipart MIME 
        $entêtes .= "MIME-Version: 1.0\r\n"; 
        $entêtes .= "Content-Type: multipart/mixed; "; 
        $entêtes .= "boundary=\"=M=A=T=T=H=I=E=U=\"\r\n"; 


        // Message. 
        $message  = ""; 
        // -> première partie du message (texte proprement dit) 
        //    -> entête de la partie 
        $message .= "--=M=A=T=T=H=I=E=U=\r\n"; 
        $message .= "Content-Type: text/plain; "; 
        $message .= "charset=iso-8859-1\r\n "; 
        $message .= "Content-Transfer-Encoding: 8bit\r\n"; 
        $message .= "\r\n";   // ligne vide 

        //    -> données de la partie 
        // $message = "<html>\n"; 
        // $message .= "<head><title>EJSMARTJOBS</title></head>\n"; 
        // $message .= "<body>\n"; 
        // $message .= "<font color=\"green\">Merci d'avoir acheter votre CV sur notre plate-forme veuillez nous consulter régulièrement pour visualiser les dernières nouveautés .
        //             <a href='".base_url()."'>CLIQUEZ ICI </a>
        //     </font>\n"; 
        // $message .= "</body>\n"; 
        // $message .= "</html>\n";
        $message .= "\r\n";
        $message .= "Voir la pièce jointe.\r\n"; 
        $message .= "\r\n";   // ligne vide 
         $message .= ""; 
        // -> deuxième partie du message (pièce-jointe) 
        //    -> entête de la partie 
       
            foreach ($liste as $key => $value) {
                if ($liste[$key] =="") {
                    # code...
                    // ici on vérifie qu'on a pas récupéré un élément vide
                }else{
    
                    // echo "ma liste est :  ".$liste[$key] . "<br/>";
                    // maintenant on va sélectionner le nom des fichiers word ayant cet identifiant
                     $message .= "--=M=A=T=T=H=I=E=U=\r\n"; 
                    $reference = array('id_modeleCV' => $liste[$key]);
                    $query = $this->db->get_where('modelecv', $reference);
                    $row = $query->row();
                    $modele[$key] = $row->fichier_word;


                     $message .= "Content-Type: application/octet-stream; "; 
                    $message .= "name=\"".$modele[$key]."\"\r\n"; 
                    $message .= "Content-Transfer-Encoding: base64\r\n"; 
                    $message .= "Content-Disposition: attachment; "; 
                    $message .= "filename=\"".$modele[$key]."\"\r\n"; 
                    $message .= "\r\n";    
                    
                    $sFileAdd[$key] = chunk_split(base64_encode(file_get_contents(base_url()."assets/images/cv/word/".$modele[$key]))); 
                    $message .= "$sFileAdd[$key]\r\n "; 
                     $message .= "--=M=A=T=T=H=I=E=U=\r\n"; 
                    // if ($sFileAdd[$key] == true) {
                    //     # code...
                    //     // echo "fichier cool";
                    // }else{
                    //     echo "fichier pas cool";
                    // }
                    // $message .= "$sFileAdd[$key]\t "; 
                    // echo $modele[$key];
                    // echo "Le fichier word est :".$modele[$key];
                    
                }


                
             }
              $bEnvoie = mail($destinataires,$objet,$message,$entêtes); 

                    if ($bEnvoie == true) {
                        # code...
                        // echo "Transfers de fichiers vers la boite mail réussie";
                    }else{
                        // echo "Echec lors de l'envoit des fichiers veuillez réessayer ou nous contactez SVP";
                    }
                    $location = 'https://www.wecashup.cloud/cdn/tests/websites/PHP/responses_pages/success.html';
         
      
    }

        public function sentLMParMail($liste,$destinataire){
                        $rien = "";
        $destinataires = $destinataire; 

        // Objet. 
        $objet = "Liste des Fichiers reçu d'EJSMARTJOBS !"; 


        // Entêtes supplémentaires. 
        $entêtes  = ""; 
        // -> origine du message 
        $entêtes .= "From: < Marie.donfack@ejsmartjobs.com>\r\n"; 
        // -> message au format Multipart MIME 
        $entêtes .= "MIME-Version: 1.0\r\n"; 
        $entêtes .= "Content-Type: multipart/mixed; "; 
        $entêtes .= "boundary=\"=M=A=T=T=H=I=E=U=\"\r\n"; 


        // Message. 
        $message  = ""; 
        // -> première partie du message (texte proprement dit) 
        //    -> entête de la partie 
        $message .= "--=M=A=T=T=H=I=E=U=\r\n"; 
        $message .= "Content-Type: text/plain; "; 
        $message .= "charset=iso-8859-1\r\n "; 
        $message .= "Content-Transfer-Encoding: 8bit\r\n"; 
        $message .= "\r\n";   // ligne vide 

        //    -> données de la partie 
        // $message = "<html>\n"; 
        // $message .= "<head><title>EJSMARTJOBS</title></head>\n"; 
        // $message .= "<body>\n"; 
        // $message .= "<font color=\"green\">Merci d'avoir acheter votre CV sur notre plate-forme veuillez nous consulter régulièrement pour visualiser les dernières nouveautés .
        //             <a href='".base_url()."'>CLIQUEZ ICI </a>
        //     </font>\n"; 
        // $message .= "</body>\n"; 
        // $message .= "</html>\n";
        $message .= "\r\n";
        $message .= "Voir la pièce jointe.\r\n"; 
        $message .= "\r\n";   // ligne vide 
         $message .= ""; 
        // -> deuxième partie du message (pièce-jointe) 
        //    -> entête de la partie 
       
            foreach ($liste as $key => $value) {
                if ($liste[$key] =="") {
                    # code...
                    // ici on vérifie qu'on a pas récupéré un élément vide
                }else{
    
                    // echo "ma liste est :  ".$liste[$key] . "<br/>";
                    // maintenant on va sélectionner le nom des fichiers word ayant cet identifiant
                     $message .= "--=M=A=T=T=H=I=E=U=\r\n"; 
                    $reference = array('id_modeleLM' => $liste[$key]);
                    $query = $this->db->get_where('modelelm', $reference);
                    $row = $query->row();
                    $modele[$key] = $row->fichier_word;


                     $message .= "Content-Type: application/octet-stream; "; 
                    $message .= "name=\"".$modele[$key]."\"\r\n"; 
                    $message .= "Content-Transfer-Encoding: base64\r\n"; 
                    $message .= "Content-Disposition: attachment; "; 
                    $message .= "filename=\"".$modele[$key]."\"\r\n"; 
                    $message .= "\r\n";    
                    
                    $sFileAdd[$key] = chunk_split(base64_encode(file_get_contents(base_url()."assets/images/motivation/word/".$modele[$key]))); 
                    $message .= "$sFileAdd[$key]\r\n "; 
                     $message .= "--=M=A=T=T=H=I=E=U=\r\n"; 
                    // if ($sFileAdd[$key] == true) {
                    //     # code...
                    //     // echo "fichier cool";
                    // }else{
                    //     echo "fichier pas cool";
                    // }
                    // $message .= "$sFileAdd[$key]\t "; 
                    // echo $modele[$key];
                    // echo "Le fichier word est :".$modele[$key];
                    
                }


                
             }
              $bEnvoie = mail($destinataires,$objet,$message,$entêtes); 

                    if ($bEnvoie == true) {
                        # code...
                        // echo "Transfers de fichiers vers la boite mail réussie";
                    }else{
                        // echo "Echec lors de l'envoit des fichiers veuillez réessayer ou nous contactez SVP";
                    }
                    $location = 'https://www.wecashup.cloud/cdn/tests/websites/PHP/responses_pages/success.html';
         
      
    }

    public function listeCVPourModification(){
         $query = $this->db->get_where('modelecv')->result_array();
         $compteur = 0;
         foreach ($query as $row) {
             # code...
            echo'<li class="splide__slide"><input type="button" recuperateur="'.$row["id_modeleCV"].'" id="cv'.$row["id_modeleCV"].'"  class="btnEnvoyer2" name="" value=""><img src="'.base_url().'assets/images/cv/captures/'.$row["nom_cv"].'"><input type="button" recuperateur="'.$row["id_modeleCV"].'"  class=" btnEnvoyer1" name="" value="" recuperateur="'.$row["id_modeleCV"].'" id="supp'.$row["id_modeleCV"].'">
            <script type="text/javascript">
               $("#cv'.$row["id_modeleCV"].'").click(function(){
                // alert($("#cv'.$row["id_modeleCV"].'").attr("recuperateur"));
                $(".prix").val("'.$row["prix"].'");
                $(".contentID").val("'.$row["id_modeleCV"].'");
                $(".modifier").fadeIn();
                });
                $("#supp'.$row["id_modeleCV"].'").click(function(){
                    if(confirm("voulez-vous réellement supprimer ce CV ?")){
                        abreviationLangue = $(".abreviationLangue").val();
                        url = "'.base_url().'/"+abreviationLangue+"/Admin/deleteCV";
                        $.ajax({
                        type: "post",
                        url: url,
                        data: {"id_modeleCV":'.$row["id_modeleCV"].'},
                        success: function (response) {
                            toastr.info(response);
                            alert(response);
                        },
                        error: function (resquest,status,error) {
                            toastr.warning("la page n\'a pas abouti");
                            alert(resquest.responseText);
                        }
                    });
                    }
                })
            </script>
            </li>
            ';
            
         }
         echo '<input type="hidden" class="contentID" value/>';
    }
    public function listeLMPourModification(){
        $query = $this->db->get_where('modelelm')->result_array();
         $compteur = 0;
         foreach ($query as $row) {
             # code...
            echo'<li class="splide__slide"><input type="button" recuperateur="'.$row["id_modeleLM"].'" id="lm'.$row["id_modeleLM"].'"  class="btnEnvoyer2" name="" value=""><img src="'.base_url().'assets/images/motivation/captures/'.$row["nom_lm"].'"><input type="button" recuperateur="'.$row["id_modeleLM"].'"  class=" btnEnvoyer1" name="" value="" recuperateur="'.$row["id_modeleLM"].'" id="supp1'.$row["id_modeleLM"].'">
            <script type="text/javascript">
               $("#lm'.$row["id_modeleLM"].'").click(function(){
                $(".prix1").val("'.$row["prix"].'");
                $(".contentID").val("'.$row["id_modeleLM"].'");
                $(".modifier").fadeIn();
                });
                $("#supp1'.$row["id_modeleLM"].'").click(function(){
                    if(confirm("voulez-vous réellement supprimer ce lettre ?")){
                        abreviationLangue = $(".abreviationLangue").val();
                        url = "'.base_url().'/"+abreviationLangue+"/Admin/deleteLM";
                        $.ajax({
                        type: "post",
                        url: url,
                        data: {"id_modeleLM":'.$row["id_modeleLM"].'},
                        success: function (response) {
                            toastr.info(response);
                            alert(response);
                        },
                        error: function (resquest,status,error) {
                            toastr.warning("la page n\'a pas abouti");
                            alert(resquest.responseText);
                        }
                    });
                    }
                })
            </script>
            </li>

            ';
            
         }
    }

    public function deleteCV(){
        $serveur =$_SERVER['DOCUMENT_ROOT']."/assets/images/";
        $id_modeleCV = $_POST["id_modeleCV"];
        $query = $this->db->get_where('modelecv',array("id_modeleCV"=>$id_modeleCV));
         
         $row = $query->row();
         $suppImage = unlink($serveur.'cv/captures/'.$row->nom_cv);

         $suppWord = unlink($serveur."cv/word/".$row->fichier_word);

         $suppression = $this->db->query("delete from modelecv where id_modeleCV=".$id_modeleCV);

         if ($suppWord == true && $suppImage == true) {
             # code...
                    
         }else{
            echo "Une erreur de suppression des fichiers s'est produite contactez l'admin\n";
         }
         if($suppression == true){
                    echo 'suppression parfaite du cv';
                }else{
                    echo "Echec lors de la suppression\n";
                }
    }
    public function deleteLM(){
        $serveur = $_SERVER['DOCUMENT_ROOT']."/assets/images/";
        $id_modeleLM = $_POST["id_modeleLM"];
        $query = $this->db->get_where('modelelm',array("id_modeleLM"=>$id_modeleLM));
         
         $row = $query->row();
         $suppImage = unlink($serveur.'motivation/captures/'.$row->nom_lm);

         $suppWord = unlink($serveur."motivation/word/".$row->fichier_word);

         $suppression = $this->db->query("delete from modelelm where id_modeleLM=".$id_modeleLM);

         if ($suppWord == true && $suppImage == true) {
             # code...
              // echo "fichier supprimé!!";    
         }else{
            echo "Une erreur de suppression des fichiers s'est produite contactez l'admin\n";
         }
           if($suppression == true){
                    echo 'suppression parfaite de la lettre\n';
                }else{
                    echo "Echec lors de la suppression\n";
                }
        
    }

    public function editCV(){
// on va d'abord teste voir s'il ya les deux fichiers
        $serveur =$_SERVER['DOCUMENT_ROOT']."/assets/images/";
       if (isset($_FILES["file_image"]) && !isset($_FILES["file_word"])) {
        
        $montant = $_POST["montant"];
        $realname = pathinfo($_FILES['file_image']['name'],PATHINFO_FILENAME);
        $file = $_FILES['file_image']['tmp_name']; 

        $sourceProperties = getimagesize($file);

        $fileNewName = time();

        $folderPath = "assets/images/cv/captures/";

        $ext = pathinfo($_FILES['file_image']['name'], PATHINFO_EXTENSION);

        $imageType = $sourceProperties[2];


        switch ($imageType) {


            case IMAGETYPE_PNG:

                $imageResourceId = imagecreatefrompng($file); 

                $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);

                imagepng($targetLayer,$folderPath. $realname. "_thump.". $ext);

                break;


            case IMAGETYPE_GIF:

                $imageResourceId = imagecreatefromgif($file); 

                $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);

                imagegif($targetLayer,$folderPath. $realname. "_thump.". $ext);

                break;


            case IMAGETYPE_JPEG:

                $imageResourceId = imagecreatefromjpeg($file); 

                $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);

                imagejpeg($targetLayer,$folderPath. $realname. "_thump.". $ext);

                break;


            default:

                echo "Invalid Image type.\n";

                exit;

                break;

        }

         $id_modeleCV = $_POST["id_modeleCV"];
        $query5 = $this->db->get_where('modelecv',array("id_modeleCV"=>$id_modeleCV));
        
         $row = $query5->row();
         // /var/www/test/folder/images/image_name.jpeg
         if (file_exists($serveur.'cv/captures/'.$row->nom_cv)) {
             # code...
                $suppImage = unlink($serveur.'cv/captures/'.$row->nom_cv);
             if ($suppImage == true) {
                 # code...
             }else{

             }
         }else{
            echo "le Précédent fichier image n'existe pas mais la mise se poursuit\n";
         }
         

       $uploadImage = move_uploaded_file($file, $folderPath.$_FILES['file_image']['name']);

        // echo "Image Resize Successfully.";
        // $nom = $_POST["nom"];
        $montant = $_POST["montant"];
       
        //on definieles extension autorisée
        $extensionsValides = array('jpg','png','gif','jpeg');
        //variable récupérer l’extension du fichier inséré
        $extensionsUpload=strtolower(substr(strrchr($_FILES['file_image']['name'], '.'),1));
        // echo $extensionsUpload;
            if(in_array($extensionsUpload, $extensionsValides)){
                 $lewhere = array("nom_cv" =>  $realname. "_thump.". $ext);
                $query2 = $this->db->get_where('modelecv', $lewhere)->result_array();

            
                if (count($query2)>0) {
                    echo "un CV de meme nom existe déjà veuillez changer svp\n";
                }else{
                    $query1 = $this->db->query("UPDATE modelecv set nom_cv='". $realname. "_thump.". $ext."', prix='".$montant."' where id_modeleCV =".$id_modeleCV."");
                    if($query1 == true){
                        echo "Modification parfaite du CV\n";
                    }else{
                        echo "Erreur durant la modification\n";
                    }   
                }
                

             }else{

             echo "votre photo de profil doit etre au format jpg,jpeg,png ou gif\n";
            
         
            }
        
       }elseif (isset($_FILES["file_word"]) && !isset($_FILES["file_image"])) {
        $file_word = $_FILES["file_word"]['tmp_name'];
        $montant = $_POST["montant"];
            // $uploadImage = move_uploaded_file($file_image,'assets/images/cv/captures/'.$_FILES['file_image']['name']);
            $uploadFileWord = move_uploaded_file($file_word,'assets/images/cv/word/'.$_FILES['file_word']['name']);
            $id_modeleCV = $_POST["id_modeleCV"];
                $query = $this->db->get_where('modelecv',array("id_modeleCV"=>$id_modeleCV));
                 
                 $row = $query->row();

                          if (file_exists($serveur.'cv/word/'.$row->fichier_word)) {
                             # code...
                            // echo "Le fichier existe deja veuillez le image existe";
                            $suppWord = unlink($serveur."cv/word/".$row->fichier_word);

                             if ($suppWord == true) {
                                 # code...
                             }else{
                                
                             }
                         }else{
                            echo "le Précédent fichier word n'existe pas mais la mise se poursuit\n";
                         }
                
                
                $lewhere1 = array("fichier_word" => $_FILES['file_word']['name']);
                $query3 = $this->db->get_where('modelecv', $lewhere1)->result_array();
                if(count($query3)>0){
                    echo "Ce fichier word est déja attribué à un autre cv veuillez le changer ou renommez\n";
                }
                else{
                        if($uploadFileWord == true){
                        // echo "Votre Logo a été envoyé avec succès";
                        $query1 = $this->db->query("UPDATE modelecv set fichier_word='".$_FILES['file_word']['name']."', prix='".$montant."' where id_modeleCV =".$id_modeleCV."");
                                if($query1 == true){
                                    echo "Modification parfaite du CV\n";
                                }else{
                                    echo "Erreur durant la modification\n";
                                } 
                    }else{
                        echo "Désolé Erreur lors de l'envoit de l'image veuillez réessayer\n";
                    }  
                }
                

            
       }elseif(isset($_FILES['file_image'],$_FILES['file_word'])){

        $montant = $_POST["montant"];
        $realname = pathinfo($_FILES['file_image']['name'],PATHINFO_FILENAME);
        $file = $_FILES['file_image']['tmp_name']; 
        $file_word = $_FILES['file_word']['tmp_name']; 

        $sourceProperties = getimagesize($file);

        $fileNewName = time();

        $folderPath = "assets/images/cv/captures/";

        $ext = pathinfo($_FILES['file_image']['name'], PATHINFO_EXTENSION);

        $imageType = $sourceProperties[2];


        switch ($imageType) {


            case IMAGETYPE_PNG:

                $imageResourceId = imagecreatefrompng($file); 

                $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);

                imagepng($targetLayer,$folderPath. $realname. "_thump.". $ext);

                break;


            case IMAGETYPE_GIF:

                $imageResourceId = imagecreatefromgif($file); 

                $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);

                imagegif($targetLayer,$folderPath. $realname. "_thump.". $ext);

                break;


            case IMAGETYPE_JPEG:

                $imageResourceId = imagecreatefromjpeg($file); 

                $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);

                imagejpeg($targetLayer,$folderPath. $realname. "_thump.". $ext);

                break;


            default:

                echo "Invalid Image type.\n";

                exit;

                break;

        }


       $uploadImage = move_uploaded_file($file, $folderPath.$_FILES['file_image']['name']);

        // echo "Image Resize Successfully.";
        // $nom = $_POST["nom"];
             $id_modeleCV = $_POST["id_modeleCV"];
        
            // $uploadImage = move_uploaded_file($file_image,'assets/images/cv/captures/'.$_FILES['file_image']['name']);
        
       
        //on definieles extension autorisée
        $extensionsValides = array('jpg','png','gif','jpeg');
        //variable récupérer l’extension du fichier inséré
        $extensionsUpload=strtolower(substr(strrchr($_FILES['file_image']['name'], '.'),1));
        // echo $extensionsUpload;
            if(in_array($extensionsUpload, $extensionsValides)){
                 $lewhere = array("nom_cv" =>  $realname. "_thump.". $ext);
                $query2 = $this->db->get_where('modelecv', $lewhere)->result_array();

                $lewhere1 = array("fichier_word" => $_FILES['file_word']['name']);
                $query3 = $this->db->get_where('modelecv', $lewhere1)->result_array();
                if (count($query2)>0) {
                    echo "un CV de meme image existe déjà veuillez changer cette image svp\n";
                }elseif(count($query3)>0){
                    echo "Ce fichier word est déja attribué à un autre cv veuillez lz changer ou renommez\n";
                }
                else{
                        $uploadFileWord = move_uploaded_file($file_word,'assets/images/cv/word/'.$_FILES['file_word']['name']);
                    if($uploadImage == true){
                        // echo "Votre image a été envoyé avec succès\n";
                    }else{
                        echo "Désolé Erreur lors de l'envoit de l'image\n";
                    }
                    $query4 = $this->db->get_where('modelecv',array("id_modeleCV"=>$id_modeleCV));
                         
                         $row = $query4->row();
                         if (file_exists($serveur.'cv/captures/'.$row->nom_cv)) {
                             # code...
                            // echo "Le fichier existe deja veuillez le image existe";
                            $suppImage = unlink($serveur.'cv/captures/'.$row->nom_cv);
                         }else{
                            echo "le Précédent fichier image n'existe pas mais la mise se poursuit\n";
                         }
                          if (file_exists($serveur.'cv/captures/'.$row->fichier_word)) {
                             # code...
                            // echo "Le fichier existe deja veuillez le image existe";
                            $suppWord = unlink($serveur."cv/word/".$row->fichier_word);
                         }else{
                            echo "le Précédent fichier word n'existe pas mais la mise se poursuit\n";
                         }

                         

                    $query1 = $this->db->query("UPDATE modelecv set fichier_word='".$_FILES['file_word']['name']."', nom_cv='". $realname. "_thump.". $ext."', prix='".$montant."' where id_modeleCV =".$id_modeleCV."");
                    if($query1 == true){
                        echo "Modification parfaite du CV";

                         if ($suppWord == true && $suppImage == true) {
                             # code...
                               
                         }else{
                           
                         }
                    }else{
                        echo "Erreur durant la modification\n";
                    }   
                }
                

             }else{

             echo "Votre image doit etre au format jpg,jpeg,png ou gif\n";
            
         
            }
       }else{
        $id_modeleCV = $_POST["id_modeleCV"];
        $montant = $_POST["montant"];
         $query1 = $this->db->query("UPDATE modelecv set  prix='".$montant."' where id_modeleCV =".$id_modeleCV."");
                    if($query1 == true){
                        echo "Modification parfaite du CV\n";
                    }else{
                        echo "Erreur durant la modification\n";
                    } 
       }
        
    }
    
    public function editLM(){
// on va d'abord teste voir s'il ya les deux fichiers
        $serveur =$_SERVER['DOCUMENT_ROOT']."/assets/images/";
       if (isset($_FILES["file_image"]) && !isset($_FILES["file_word"])) {
        
        $montant = $_POST["montant"];
        $realname = pathinfo($_FILES['file_image']['name'],PATHINFO_FILENAME);
        $file = $_FILES['file_image']['tmp_name']; 

        $sourceProperties = getimagesize($file);

        $fileNewName = time();

        $folderPath = "assets/images/motivation/captures/";

        $ext = pathinfo($_FILES['file_image']['name'], PATHINFO_EXTENSION);

        $imageType = $sourceProperties[2];


        switch ($imageType) {


            case IMAGETYPE_PNG:

                $imageResourceId = imagecreatefrompng($file); 

                $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);

                imagepng($targetLayer,$folderPath. $realname. "_thump.". $ext);

                break;


            case IMAGETYPE_GIF:

                $imageResourceId = imagecreatefromgif($file); 

                $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);

                imagegif($targetLayer,$folderPath. $realname. "_thump.". $ext);

                break;


            case IMAGETYPE_JPEG:

                $imageResourceId = imagecreatefromjpeg($file); 

                $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);

                imagejpeg($targetLayer,$folderPath. $realname. "_thump.". $ext);

                break;


            default:

                echo "Invalid Image type.\n";

                exit;

                break;

        }

         $id_modeleLM = $_POST["id_modeleLM"];
        $query5 = $this->db->get_where('modelelm',array("id_modeleLM"=>$id_modeleLM));
        
         $row = $query5->row();
         // /var/www/test/folder/images/image_name.jpeg
         if (file_exists($serveur.'motivation/captures/'.$row->nom_lm)) {
             # code...
                $suppImage = unlink($serveur.'motivation/captures/'.$row->nom_lm);
             if ($suppImage == true) {
                 # code...
             }else{

             }
         }else{
            echo "le Précédent fichier image n'existe pas mais la mise se poursuit\n";
         }
         

       $uploadImage = move_uploaded_file($file, $folderPath.$_FILES['file_image']['name']);

        // echo "Image Resize Successfully.";
        // $nom = $_POST["nom"];
        $montant = $_POST["montant"];
       
        //on definieles extension autorisée
        $extensionsValides = array('jpg','png','gif','jpeg');
        //variable récupérer l’extension du fichier inséré
        $extensionsUpload=strtolower(substr(strrchr($_FILES['file_image']['name'], '.'),1));
        // echo $extensionsUpload;
            if(in_array($extensionsUpload, $extensionsValides)){
                 $lewhere = array("nom_lm" =>  $realname. "_thump.". $ext);
                $query2 = $this->db->get_where('modelelm', $lewhere)->result_array();

            
                if (count($query2)>0) {
                    echo "une lettre de meme nom existe déjà veuillez changer svp\n";
                }else{
                    $query1 = $this->db->query("UPDATE modelelm set nom_lm='". $realname. "_thump.". $ext."', prix='".$montant."' where id_modeleLM =".$id_modeleLM."");
                    if($query1 == true){
                        echo "Modification parfaite de la lettre\n";
                    }else{
                        echo "Erreur durant la modification\n";
                    }   
                }
                

             }else{

             echo "votre photo de profil doit etre au format jpg,jpeg,png ou gif\n";
            
         
            }
        
       }elseif (isset($_FILES["file_word"]) && !isset($_FILES["file_image"])) {
        $file_word = $_FILES["file_word"]['tmp_name'];
        $montant = $_POST["montant"];
            // $uploadImage = move_uploaded_file($file_image,'assets/images/cv/captures/'.$_FILES['file_image']['name']);
            $uploadFileWord = move_uploaded_file($file_word,'assets/images/motivation/word/'.$_FILES['file_word']['name']);
            $id_modeleLM = $_POST["id_modeleLM"];
                $query = $this->db->get_where('modelelm',array("id_modeleLM"=>$id_modeleLM));
                 
                 $row = $query->row();

                          if (file_exists($serveur.'motivation/word/'.$row->fichier_word)) {
                             # code...
                            // echo "Le fichier existe deja veuillez le image existe";
                            $suppWord = unlink($serveur."motivation/word/".$row->fichier_word);

                             if ($suppWord == true) {
                                 # code...
                             }else{
                                
                             }
                         }else{
                            echo "le Précédent fichier word n'existe pas mais la mise se poursuit\n";
                         }
                
                
                $lewhere1 = array("fichier_word" => $_FILES['file_word']['name']);
                $query3 = $this->db->get_where('modelelm', $lewhere1)->result_array();
                if(count($query3)>0){
                    echo "Ce fichier word est déja attribué à un autre cv veuillez le changer ou renommez";
                }
                else{
                        if($uploadFileWord == true){
                        // echo "Votre Logo a été envoyé avec succès";
                        $query1 = $this->db->query("UPDATE modelelm set fichier_word='".$_FILES['file_word']['name']."', prix='".$montant."' where id_modeleLM =".$id_modeleLM."");
                                if($query1 == true){
                                    echo "Modification parfaite de la lettre\n";
                                }else{
                                    echo "Erreur durant la modification\n";
                                } 
                    }else{
                        echo "Désolé Erreur lors de l'envoit de l'image veuillez réessayer\n";
                    }  
                }
                

            
       }elseif(isset($_FILES['file_image'],$_FILES['file_word'])){

        $montant = $_POST["montant"];
        $realname = pathinfo($_FILES['file_image']['name'],PATHINFO_FILENAME);
        $file = $_FILES['file_image']['tmp_name']; 
        $file_word = $_FILES['file_word']['tmp_name']; 

        $sourceProperties = getimagesize($file);

        $fileNewName = time();

        $folderPath = "assets/images/motivation/captures/";

        $ext = pathinfo($_FILES['file_image']['name'], PATHINFO_EXTENSION);

        $imageType = $sourceProperties[2];


        switch ($imageType) {


            case IMAGETYPE_PNG:

                $imageResourceId = imagecreatefrompng($file); 

                $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);

                imagepng($targetLayer,$folderPath. $realname. "_thump.". $ext);

                break;


            case IMAGETYPE_GIF:

                $imageResourceId = imagecreatefromgif($file); 

                $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);

                imagegif($targetLayer,$folderPath. $realname. "_thump.". $ext);

                break;


            case IMAGETYPE_JPEG:

                $imageResourceId = imagecreatefromjpeg($file); 

                $targetLayer = $this->imageResize($imageResourceId,$sourceProperties[0],$sourceProperties[1]);

                imagejpeg($targetLayer,$folderPath. $realname. "_thump.". $ext);

                break;


            default:

                echo "Invalid Image type.\n";

                exit;

                break;

        }


       $uploadImage = move_uploaded_file($file, $folderPath.$_FILES['file_image']['name']);

        // echo "Image Resize Successfully.";
        // $nom = $_POST["nom"];
             $id_modeleLM = $_POST["id_modeleLM"];
        
            // $uploadImage = move_uploaded_file($file_image,'assets/images/cv/captures/'.$_FILES['file_image']['name']);
        
       
        //on definieles extension autorisée
        $extensionsValides = array('jpg','png','gif','jpeg');
        //variable récupérer l’extension du fichier inséré
        $extensionsUpload=strtolower(substr(strrchr($_FILES['file_image']['name'], '.'),1));
        // echo $extensionsUpload;
            if(in_array($extensionsUpload, $extensionsValides)){
                 $lewhere = array("nom_lm" =>  $realname. "_thump.". $ext);
                $query2 = $this->db->get_where('modelelm', $lewhere)->result_array();

                $lewhere1 = array("fichier_word" => $_FILES['file_word']['name']);
                $query3 = $this->db->get_where('modelelm', $lewhere1)->result_array();
                if (count($query2)>0) {
                    echo "une lettre de meme image existe déjà veuillez changer cette image svp\n";
                }elseif(count($query3)>0){
                    echo "Ce fichier word est déja attribué à un autre cv veuillez le changer ou renommez\n";
                }
                else{
                        $uploadFileWord = move_uploaded_file($file_word,'assets/images/motivation/word/'.$_FILES['file_word']['name']);
                    if($uploadImage == true){
                        // echo "Votre image a été envoyé avec succès\n";
                    }else{
                        echo "Désolé Erreur lors de l'envoit de l'image\n";
                    }
                    $query4 = $this->db->get_where('modelelm',array("id_modeleLM"=>$id_modeleLM));
                         
                         $row = $query4->row();
                         if (file_exists($serveur.'motivation/captures/'.$row->nom_lm)) {
                             # code...
                            // echo "Le fichier existe deja veuillez le image existe";
                            $suppImage = unlink($serveur.'motivation/captures/'.$row->nom_lm);
                         }else{
                            echo "le Précédent fichier image n'existe pas mais la mise se poursuit\n";
                            $suppImage = false;
                         }
                          if (file_exists($serveur.'motivation/captures/'.$row->fichier_word)) {
                             # code...
                            // echo "Le fichier existe deja veuillez le image existe";
                            $suppWord = unlink($serveur."motivation/word/".$row->fichier_word);
                         }else{

                            echo "le Précédent fichier word n'existe pas mais la mise se poursuit\n";
                          $suppWord = false;
                         }

                         

                    $query1 = $this->db->query("UPDATE modelelm set fichier_word='".$_FILES['file_word']['name']."', nom_lm='". $realname. "_thump.". $ext."', prix='".$montant."' where id_modeleLM =".$id_modeleLM."");
                    if($query1 == true){
                        echo "Modification parfaite de la lettre \n";

                         if ($suppWord == true && $suppImage == true) {
                             # code...
                               
                         }else{
                           
                         }
                    }else{
                        echo "Erreur durant la modification";
                    }   
                }
                

             }else{

             echo "Votre image doit etre au format jpg,jpeg,png ou gif\n";
            
         
            }
       }else{
        $id_modeleLM = $_POST["id_modeleLM"];
        $montant = $_POST["montant"];
         $query1 = $this->db->query("UPDATE modelelm set  prix='".$montant."' where id_modeleLM =".$id_modeleLM."");
                    if($query1 == true){
                        echo "Modification parfaite de la lettre\n\n";
                    }else{
                        echo "Erreur durant la modification";
                    } 
       }
           
    }
}
?>