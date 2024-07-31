<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model_stock extends CI_Model {
// 
    function __construct() {
        parent::__construct();
        $this->load->database('default');
        $this->load->library('session');
        // $this->load->helper('app_gui_helper');
        $this->load->helper('cookie');
        $this->load->helper('url');
        // $this->session->set_userdata('language_abbr', "en"); 
        date_default_timezone_set('Africa/Lagos');
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


    public function leSelectArticlePourInventaire(){
        $getArticle = $this->db->query("SELECT * from article order by article asc")->result_array();
        echo ' <tr class="formAddInventaire">
                                  <td>
                                    <select class="article form-control" onchange ="getReferenceArticle()">';
        if (count($getArticle)>0) {
            # code...

            foreach ($getArticle as $row) {
                # code...

                echo "<option value = '".$row['id_article']."' article='".$row['article']."'>".$row['article']."</option>";
            }
        }
        echo '  
                    </select>
                                  </td>
                                  <td><input type="text" placeholder ="Reférence" class="form-control reference" disabled = "False" onkeypress="chiffres(event);"></td>
                                  <td>
                                        <div class="input-group input-group-sm">
                                        <input type="text" class="form-control qtite" onkeypress="chiffres(event);">
                                        <span class="input-group-append">
                                          <button type="button" class="btn btn-info btn-flat" onclick="addInventaire();">
                                            <img src="'.base_url().'assets/image/envoi.jpg" style="height: 25px; width: 25px; border-radius: 20px;">
                                          </button>
                                        </span>
                                      </div>
                                  </td>
                                </tr>';

                            $this->db->close();
    }


    public function getArticle($id){
        $query= $this->db->query("SELECT * from article where id_article = ".$id."")->row();

        if (count($query)>0) {
            # code...
            return $query->article;
        }
        $this->db->close();
    }

    public function addInventaire(){
        $id_article = $_POST["article"];
        $qtite = $_POST["qtite"];
        $date = $_POST["date_inv"];
        $auteur = $_POST["auteur"];
		$id_fournisseur = $_POST["id_fournisseur"];
        
		$aujourdhui = date("Y/m/d");
        $dateLimit = date("Y/m/d");
        $dateEntree = date("Y/m/d");


        $nom_table = "inventaire";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." a fait un inventaire sur l'article: ".$this->getArticle($id_article)." d'une quantité de ".$qtite." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié un inventaire sur l'article: ".$this->getArticle($id_article)." d'une quantité de ".$qtite." le ".$date_notif." à ".$heure;


        // on va vérivier la si la date de la pécédente insertion est supérieure ou égale à celle d'aujourd'hui
        $getArticle = $this->db->query(" select * from inventaire order by id_inventaire desc limit 1")->row();
        if (count($getArticle)>0) {
            # code...
            $dateLimit = date("Y/m/d",strtotime($getArticle->date_inv));
       $dateEntree = date("Y/m/d",strtotime($date));
        }

       if ($dateEntree < $dateLimit) {
           # code...
            echo "La date d'insertion doit être supérieure ou égale à celle du dernier inventaire"; 
       }else{


        $addInventaire = $this->db->query("INSERT into inventaire value('',".$id_article.",'".$auteur."',CAST('". $date."' AS DATE),".$qtite.",".$id_fournisseur.")");
        if ($addInventaire == true) {
            # code...
            echo "ok";
            $this->notificationAjout($nom_table,addslashes($message));
        }else{
            echo "Erreur d'insertion contactez l'administrateur";
        }
    }

    $this->db->close();
    }

    public function getDateDernierInventaire(){
       $query = $this->db->query("SELECT * from inventaire order by date_inv desc limit 1")->row();
       
      
       if (count($query)>0) {
           # code...
         return $query->date_inv;
       }

       $this->db->close();
          }

    public function getPrixUnitaireArticle($id_article){
        $query = $this->db->query("SELECT * from article where id_article =".$id_article."")->result_array();

        if (count($query) >0 ) {
            # code...
            $compteur = 0;
        foreach ($query as $row) {
            return $row['prix_unitaire'];
        }
    }
}

    public function getReferenceArticle($id_article){
        $query = $this->db->query("SELECT * from article where id_article =".$id_article."")->result_array();

        if (count($query) >0 ) {
            # code...
            $compteur = 0;
        foreach ($query as $row) {
            return $row['code_a_barre'];
        }
    }
    

}

    public function selectAllInventaire(){
		
		
		if (isset($_POST['date_debut']) && isset($_POST['date_fin'])  && isset($_POST['id_fournisseur1'])) {
            # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
      
        $id_fournisseur1 = $_POST['id_fournisseur1'];
        }else{
        $date_debut = '';
        $date_fin = '';
   
        $id_fournisseur1 = "";
        }
		
      
       if (empty($date_fin) && !empty($date_debut)  && empty($id_fournisseur1) ){

            $query = $this->db->query("select * from inventaire where date_inv='".$date_debut."' order by date_inv desc")->result_array();

        }if (!empty($date_fin) && !empty($date_debut)  && empty($id_fournisseur1)){

            $query = $this->db->query("SELECT * from inventaire where  date_inv between '".$date_debut."' and '".$date_fin."'  order by date_inv desc")->result_array();


        }if (!empty($date_fin) && !empty($date_debut)  && !empty($id_fournisseur1)){

            $query = $this->db->query("SELECT * from inventaire where id_fournisseur = ".$id_fournisseur1." and date_inv between '".$date_debut."' and '".$date_fin."'  order by date_inv desc")->result_array();


        }elseif (!empty($date_fin) && empty($date_debut)  && empty($id_fournisseur1)){
            
             $query = $this->db->query("SELECT * from inventaire where date_inv ='".$date_fin."' order by date_inv desc")->result_array();

        }elseif (empty($date_fin) && empty($date_debut)  && !empty($id_fournisseur1)){
            
             $query = $this->db->query("SELECT * from inventaire where id_fournisseur = ".$id_fournisseur1." order by date_inv desc")->result_array();

        }else{
            $query = $this->db->query("SELECT * from inventaire order by date_inv desc")->result_array();
        }

        

        if (count($query) >0 ) {
            # code...
            $compteur = 0;
        foreach ($query as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    ";
                    $getNomArticle = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->row();
                    echo"
                    <td>".$getNomArticle->code_a_barre."</td>
                    <td>".$getNomArticle->article."</td>
                    <td>".$getNomArticle->prix_unitaire."</td>
                    </td>";
                    $getFournisseur = $this->db->query("SELECT * FROM fournisseur_article where id_fournisseur=".$row['id_fournisseur']."")->row();
                    echo"<td>".$getFournisseur->nom."</td> ";
                    
                    echo"
                    <td>".$row['auteur']."</td>
                    <td> ".$row['date_inv']."</td>
                    <td> ".$row['qtite']."</td>
					
                    <td>";
                 if($this->session->userdata('stock_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='inventaire' identifiant='".$row['id_inventaire']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_inventaire\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                }
                  $compteur++;
            }
        }

        $this->db->close();
    }


// Nous allons maintenant gérer les approvisionnements

     public function leSelectArticlePourApprovisionnement(){
        $getArticle = $this->db->query("SELECT * from article order by article asc")->result_array();
        echo ' <tr class="formAddInventaire">
                                  <td>
                                    <select class="article form-control" onchange ="getReferenceArticle(); getPrixUnitaireArticle();">';
        if (count($getArticle)>0) {
            # code...

            foreach ($getArticle as $row) {
                # code...

                echo "<option value = '".$row['id_article']."' article='".$row['article']."'>".$row['article']."</option>";
            }
        }
        echo '  </select>
                                  </td>

                                  <td><input type="text" placeholder ="Reférence" class="form-control reference" ></td>
                                  
                                  
                                  <td><input type="text" placeholder ="Montant" class="form-control montant" onkeypress="chiffres(event);"></td>
                                  
                                  <td>
                                        <div class="input-group input-group-sm">
                                        <input type="text" class="form-control qtite" onkeypress="chiffres(event);">
                                        <span class="input-group-append">
                                          <button type="button" class="btn btn-info btn-flat" onclick="addApprovisionnement();">
                                            <img src="'.base_url().'assets/image/envoi.jpg" style="height: 25px; width: 25px; border-radius: 20px;">
                                          </button>
                                        </span>
                                      </div>
                                  </td>
                                </tr>';


                        $this->db->close();
    }

    public function addApprovisionnement(){
        $id_article = $_POST["article"];
        $qtite = $_POST["qtite"];
        $date = $_POST["date_inv"];
        $auteur = $_POST["auteur"];
        $reference = $_POST["reference"];
        $montant = $_POST["montant"];
        $bl = $_POST["bl"];
        $id_fournisseur = $_POST["id_fournisseur"];

        $aujourdhui = date("Y/m/d");
        $dateLimit = date("Y/m/d");
        $dateEntree = date("Y/m/d");

        $nom_table = "approvisionnement";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." a fait un approvisionnement sur l'article: ".$this->getArticle($id_article)." d'une quantité de ".$qtite." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié un approvisionnement sur l'article: ".$this->getArticle($id_article)." d'une quantité de ".$qtite." le ".$date_notif." à ".$heure;
        // on va vérivier la si la date de la pécédente insertion est supérieure ou égale à celle d'aujourd'hui
        $getArticle = $this->db->query(" select * from inventaire order by id_inventaire desc limit 1")->row();
        if (count($getArticle)>0) {
            # code...
            $dateLimit = date("Y/m/d",strtotime($getArticle->date_inv));
       $dateEntree = date("Y/m/d",strtotime($date));
        }
       

       if ($dateEntree < $dateLimit) {
           # code...
            echo "La date d'insertion doit être supérieure ou égale à celle du dernier inventaire"; 
       }else{

              $requeteBL = $this->db->query("select * from facture_article where id_fournisseur ='".$id_fournisseur."' And libelle ='".$bl."'")->result_array();
              if (count($requeteBL)>0) {
        # code...
        echo "Ce Bon de Livraison a déjà été facturé sous ce fournisseur";
      }else{

        $addInventaire = $this->db->query("INSERT into approvisionnement value('',".$id_article.",".$id_fournisseur.",'".$reference."','".$auteur."',CAST('". $date."' AS DATE),".$qtite.",".$montant.",'".$bl."')");
        if ($addInventaire == true) {
            # code...
            echo "ok";
            $this->notificationAjout($nom_table,addslashes($message));
        }else{
            echo "Erreur d'insertion contactez l'administrateur";
        }
    }

        $this->db->close();
    }
    
    }
    public function selectAllApprovisionnement(){

        if (isset($_POST['date_debut']) && isset($_POST['date_fin']) && isset($_POST['bl1']) && isset($_POST['id_fournisseur1'])) {
            # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $bl1 = $_POST['bl1'];
        $id_fournisseur1 = $_POST['id_fournisseur1'];
        }else{
        $date_debut = '';
        $date_fin = '';
        $bl1 = '';
        $id_fournisseur1 = "";
        }
        

        if (!empty($bl)) {
            # code...
            $bl1 = $_POST['bl1'];
            }else{
            $bl = '';
            }
        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur1) && empty($bl1)){
            $query = $this->db->query("select * from approvisionnement where id_fournisseur = ".$id_fournisseur1." order by date_app desc")->result_array();

        }elseif (empty($date_fin) && empty($date_debut) && !empty($id_fournisseur1) && !empty($bl1)){

            $query = $this->db->query("select * from approvisionnement where id_fournisseur = ".$id_fournisseur1." and bl='".$bl1."' order by date_app desc")->result_array();

        }elseif (empty($date_fin) && !empty($date_debut) && !empty($id_fournisseur1) && empty($bl1)){

            $query = $this->db->query("select * from approvisionnement where id_fournisseur = ".$id_fournisseur1." and date_app='".$date_debut."' order by date_app desc")->result_array();

        }elseif (!empty($date_fin) && empty($date_debut) && !empty($id_fournisseur1) && empty($bl1)){

            $query = $this->db->query("select * from approvisionnement where id_fournisseur = ".$id_fournisseur1." and date_app='".$date_fin."' order by date_app desc")->result_array();

        }elseif (!empty($date_fin) && !empty($date_debut) && empty($id_fournisseur1) && empty($bl1)){

            $query = $this->db->query("SELECT * from approvisionnement where  date_app between '".$date_debut."' and '".$date_fin."' order by date_app desc")->result_array();


        }elseif (!empty($date_fin) && !empty($date_debut) && !empty($id_fournisseur1) && empty($bl1)){

            $query = $this->db->query("SELECT * from approvisionnement where id_fournisseur = ".$id_fournisseur1." and  date_app between '".$date_debut."' and '".$date_fin."' order by date_app desc")->result_array();


        }elseif (!empty($date_fin) && !empty($date_debut) && !empty($id_fournisseur1) && !empty($bl1)){

            $query = $this->db->query("SELECT * from approvisionnement where id_fournisseur = ".$id_fournisseur1." and bl='".$bl."' and  date_app between '".$date_debut."' and '".$date_fin."' order by date_app desc")->result_array();


        }elseif (!empty($date_fin) && empty($date_debut) && empty($id_fournisseur1) && empty($bl1)){
            
             $query = $this->db->query("SELECT * from approvisionnement where date_app ='".$date_fin."' order by date_app desc")->result_array();

        }elseif (empty($date_fin) && !empty($date_debut) && empty($id_fournisseur1) && empty($bl1)){
            $query = $this->db->query("SELECT * from approvisionnement where date_app ='".$date_debut."' order by date_app desc")->result_array();
        }else{
            $query = $this->db->query("select * from approvisionnement  order by id_app desc")->result_array();
        }

        

        if (count($query) >0 ) {
            # code...
            $compteur = 0;
           
             $qtiteInventaire= 0;
        foreach ($query as $row) {
            # code...
             $M = 0;
            $Q = 0;
            $Q =  $row['qtite'];
            $M = $row['montant'];
            $qtiteInventaire= $Q*$M;
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    ";
                    $getNomArticle = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->row();
                    $four = $this->db->query("SELECT * from fournisseur_article where id_fournisseur=".$row['id_fournisseur']." ")->row();
                    if (count($four)>0) {
                        # code...
                        $four = $four->nom;
                    }else{
                        $four ="";
                    }
                    echo" 
                    <td>".$getNomArticle->code_a_barre."</td>
                    <td>".$getNomArticle->article."</td>
                    <td>".$four."</td>
                   
                    </td>";
                    
                    $getCategorie = $this->db->query('SELECT * FROM categorie_article where id_categorie='.$getNomArticle->id_categorie.'')->row();
                    echo"<td>".$getCategorie->categorie."</td>
                    ";
                    echo"
                    <td>".$row['auteur']."</td>
                    
                    
                    <td>".$row['bl']."</td>
                    <td>".$row['date_app']."</td>
                    <td>".$row['montant']."</td>
                    <td>".$row['qtite']."</td>
                    <td>$qtiteInventaire </td>
                    <td>";
                if($this->session->userdata('stock_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='approvisionnement' identifiant='".$row['id_app']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_app\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
            }
        }


        $this->db->close();
    }


   //Nous allons passez à la gestion des pièces défectueuses

     public function leSelectArticlePourDefectueux(){
        $getArticle = $this->db->query("SELECT * from article where id_article IN (SELECT id_article from approvisionnement) order by article asc")->result_array();
        echo ' <tr class="formAddInventaire">
                                  <td>
                                    <select class="article form-control" onchange ="getReferenceArticle();">';
        if (count($getArticle)>0) {
            # code...

            foreach ($getArticle as $row) {
                # code...

                echo "<option value = '".$row['id_article']."' article='".$row['article']."'>".$row['article']."</option>";
            }
        }
        echo '  </select>
                                  </td>
                                  <td><input type="text" placeholder ="Reférence" disabled = "False" class="form-control reference" ></td>
                                  
                                  <td>
                                        <div class="input-group input-group-sm">
                                        <input type="text" class="form-control qtite" onkeypress="chiffres(event);">
                                        <span class="input-group-append">
                                          <button type="button" class="btn btn-info btn-flat" onclick="addDefectueux();">
                                            <img src="'.base_url().'assets/image/envoi.jpg" style="height: 25px; width: 25px; border-radius: 20px;">
                                          </button>
                                        </span>
                                      </div>
                                  </td>
                                </tr>';

                $this->db->close();
    }

    public function addDefectueux(){
        $id_article = $_POST["article"];
        $qtite = $_POST["qtite"];
        $date = $_POST["date_inv"];
        $auteur = $_POST["auteur"];

        $aujourdhui = date("Y/m/d");

         $dateLimit = date("Y/m/d");
        $dateEntree = date("Y/m/d");

        $nom_table = "defectueux";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." a ajouté l'article: ".$this->getArticle($id_article)." d'une quantité de ".$qtite." sur les pièces défectueuses le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié l'enregistrement sur l'article défectueux : ".$this->getArticle($id_article)." d'une quantité de ".$qtite." le ".$date_notif." à ".$heure;
        // on va vérivier la si la date de la pécédente insertion est supérieure ou égale à celle d'aujourd'hui
        $getArticle = $this->db->query(" select * from inventaire order by id_inventaire desc limit 1")->row();
        if (count($getArticle)>0) {
            # code...
            $dateLimit = date("Y/m/d",strtotime($getArticle->date_inv));
       $dateEntree = date("Y/m/d",strtotime($date));
        }
       
       if ($dateEntree < $dateLimit) {
           # code...
            echo "La date d'insertion doit être supérieure ou égale à celle du dernier inventaire"; 
       }else{


        $addInventaire = $this->db->query("INSERT into defectueux value('',".$id_article.",'".$auteur."',CAST('". $date."' AS DATE),".$qtite.")");
        if ($addInventaire == true) {
            # code...
            echo "ok";
            $this->notificationAjout($nom_table,addslashes($message));
        }else{
            echo "Erreur d'insertion contactez l'administrateur";
        }
    }

    $this->db->close();
    }

    public function selectAllDefectueux(){


         if (isset($_POST['date_debut']) && isset($_POST['date_fin'])) {
            # code...
            $date_debut = $_POST['date_debut'];
            $date_fin = $_POST['date_fin'];
        }else{
            $date_debut = '';
        $date_fin = '';
        }
       if (empty($date_fin) && !empty($date_debut) ){

            $query = $this->db->query("select * from defectueux where date_def='".$date_debut."' ".$bl." order by id_defectueux desc")->result_array();

        }if (!empty($date_fin) && !empty($date_debut)){

            $query = $this->db->query("SELECT * from defectueux where  date_def between '".$date_debut."' and '".$date_fin."'  order by id_defectueux desc")->result_array();


        }elseif (!empty($date_fin) && empty($date_debut)){
            
             $query = $this->db->query("SELECT * from defectueux where date_def ='".$date_fin."' order by id_defectueux desc")->result_array();

        }else{
            $query = $this->db->query("select * from defectueux order by id_defectueux desc")->result_array();
        }

        // $query = $this->db->query("SELECT * from defectueux order by id_defectueux desc")->result_array();

        if (count($query) >0 ) {
            # code...
            $compteur = 0;
        foreach ($query as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    ";
                    $getNomArticle = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->row();
                    

                    echo"
                    <td>".$getNomArticle->code_a_barre."</td>
                    <td>".$getNomArticle->article."</td>
                    <td>".$getNomArticle->prix_unitaire."</td>
                    </td>";
                    $getCategorie = $this->db->query('SELECT * FROM categorie_article where id_categorie='.$getNomArticle->id_categorie.'')->row();
                    echo"<td>".$getCategorie->categorie."</td>
                    ";
                    echo"
                    <td>".$row['auteur']."</td>
                    <td> ".$row['date_def']."</td>
                    <td> ".$row['qtite']."</td>
                    <td>
                    ";
                if($this->session->userdata('stock_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='defectueux' identifiant='".$row['id_defectueux']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_defectueux\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
            }
        }

        $this->db->close();
    }


public function stockArticle(){
    $getArticle = $this->db->query("SELECT  * from article where id_article IN (SELECT id_article from approvisionnement) order by article")->result_array();
    $compteur = 0;
    if (count($getArticle) > 0) {
        # code...
        foreach ($getArticle as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    ";
                    $article = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->row();
                    
                    echo"
                    <td>".$article->code_a_barre."</td>
                    <td>".$article->article."</td>
                    <td>".$article->prix_unitaire."</td>
                    </td>";
                     $getCategorie = $this->db->query('SELECT * FROM categorie_article where id_categorie='.$article->id_categorie.'')->row();
                    echo"<td>".$getCategorie->categorie."</td>
                    ";
                $qtiteInventaire = 0;
                $getInventaire = $this->db->query('SELECT * from inventaire where id_article='.$article->id_article.' order by date_inv desc')->result_array();
                if (count($getInventaire)>0) {
                    # code...
                    foreach ($getInventaire as $inventaire) {
                    # code...
                    $qtiteInventaire = $qtiteInventaire + $inventaire['qtite'];
                    }
                    echo"<td>".$qtiteInventaire."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }
                $qtiteApprovisionnement = 0;
                $getApprovisionnement = $this->db->query("SELECT * from approvisionnement where id_article='.$article->id_article.' and date_app >= '".$this->getDateDernierInventaire()."'")->result_array();
                if (count($getApprovisionnement)>0) {
                    # code...
                    foreach ($getApprovisionnement as $app) {
                    # code...
                    $qtiteApprovisionnement= $qtiteApprovisionnement + $app['qtite'];
                    }
                    echo"<td>".$qtiteApprovisionnement."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }

                $qtitePieceRechange = 0;
                $getPieceRechange = $this->db->query("SELECT * from piece_rechange where id_article='.$article->id_article.'
                    and date_rech >= '".$this->getDateDernierInventaire()."'")->result_array();
                if (count($getPieceRechange)>0) {
                    # code...
                    foreach ($getPieceRechange as $sortie) {
                    # code...
                    $qtitePieceRechange = $qtitePieceRechange + $sortie['qtite'];
                    }
                    echo"<td>".$qtitePieceRechange."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }

                $qtiteDefectueux = 0;
                $getDefectueux = $this->db->query("SELECT * from defectueux where id_article='.$article->id_article.' and date_def >= '".$this->getDateDernierInventaire()."'")->result_array();
                if (count($getDefectueux)>0) {
                    # code...
                    foreach ($getDefectueux as $defectueux) {
                    # code...
                    $qtiteDefectueux = $qtiteDefectueux + $defectueux['qtite'];
                    }
                    echo"<td>".$qtiteDefectueux."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }

                $stock = $qtiteInventaire + $qtiteApprovisionnement - $qtiteDefectueux - $qtitePieceRechange;
                echo"<td>".$stock."</td>
                    ";
					
		$getApprovisionnement1 = $this->db->query("SELECT SUM(qtite*montant) as qte_prix from approvisionnement where id_article='.$article->id_article.' and date_app >= '".$this->getDateDernierInventaire()."'")->row();	
		
		if (count($getApprovisionnement1)>0) {
			
			$som_prix1 = $getApprovisionnement1->qte_prix;
			
		 }else{
                    $som_prix1 =0;
                }	
			
					
		$getApprovisionnement2 = $this->db->query("SELECT SUM(qtite) as qte from approvisionnement where id_article='.$article->id_article.' and date_app >= '".$this->getDateDernierInventaire()."'")->row();	
					
				if (count($getApprovisionnement2)>0) {
			
			$som_prix2 = $getApprovisionnement2->qte;
			
		 }else{
                    $som_prix2 = 0;
                }
				
			if ($som_prix2  > 0) {

			echo"<td>".($stock*$som_prix1)/$som_prix2."</td>
                    ";
            }else{
                   echo"<td>ERREUR</td>
                    ";
                }
					

		


		
					
                    $compteur++;
        }

        
    }

    $this->db->close();
}

public function stockArticlevaleur(){
    $getArticle = $this->db->query("SELECT * from article order by id_article desc")->result_array();
    $compteur = 0;
     
    
    
    if (count($getArticle) > 0) {
        # code...
        foreach ($getArticle as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    ";
                    $article = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->row();
                    
                    $montant = 0;
                    $montant3 = 0;
                    echo"
                    <td>".$article->code_a_barre."</td>
                    <td>".$article->article."</td>
                    </td>";
                    
                    $montant = $montant+$article->prix_unitaire;
                    $montant3 = $montant3+$article->prix_unitaire;
                    
                     # code... $getCategorie = $this->db->query('SELECT * FROM categorie_article where id_categorie='.$article->id_categorie.'')->row();
                    # code... echo"<td>".$getCategorie->categorie."</td>
                    # code... ";
                    
                $qtiteInventaire = 0;
                $montant1 = 0;
                $montant2 = 0;
                
                $getInventaire = $this->db->query('SELECT * from inventaire where id_article='.$article->id_article.' order by date_inv desc')->result_array();
                if (count($getInventaire)>0) {
                    # code...
                    foreach ($getInventaire as $inventaire) {
                    # code...
                    $qtiteInventaire = $qtiteInventaire + $inventaire['qtite'];
                    }
                    echo"<td>".$qtiteInventaire."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }
                
                echo "
                <td>".$article->prix_unitaire."</td>";
                
                $montant1 = $montant1 + $qtiteInventaire;
                
                $montant2 = $montant1 * $montant;
                 
                echo "
                <td>$montant2</td>";
                
                
                $qtiteApprovisionnement = 0;
                $montant = 0;
                $montant2_1 = 0;
                $getApprovisionnement = $this->db->query("SELECT * from approvisionnement where id_article='.$article->id_article.' and date_app >= '".$this->getDateDernierInventaire()."'")->result_array();
                if (count($getApprovisionnement)>0) {
                    # code...
                    foreach ($getApprovisionnement as $app) {
                    # code...
                    $qtiteApprovisionnement= $qtiteApprovisionnement + $app['qtite'];
                    $montant = $montant + $app['montant'];
                    }
                    echo"<td>".$qtiteApprovisionnement."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }
                
                 
                 
                  echo "
                <td>$montant</td>";
                
                 $montant2_1 = $qtiteApprovisionnement * $montant;
                 
                echo "
                <td>$montant2_1</td>";

                $qtitePieceRechange = 0;
                 $montant = 0;
                $montant2_2 = 0;
                $getPieceRechange = $this->db->query("SELECT * from piece_rechange where id_article='.$article->id_article.'
                    and date_rech >= '".$this->getDateDernierInventaire()."'")->result_array();
                if (count($getPieceRechange)>0) {
                    # code...
                    foreach ($getPieceRechange as $sortie) {
                    # code...
                    $qtitePieceRechange = $qtitePieceRechange + $sortie['qtite'];
                    $montant = $montant + $sortie['prix_unitaire'];
                    }
                    echo"<td>".$qtitePieceRechange."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }
                
                echo "
                <td>$montant</td>";
                
                 $montant2_2 = $qtitePieceRechange * $montant;
                 
                echo "
                <td>$montant2_2</td>";

                $qtiteDefectueux = 0;
               
                $montant2_3 = 0;
                $getDefectueux = $this->db->query("SELECT * from defectueux where id_article='.$article->id_article.' and date_def >= '".$this->getDateDernierInventaire()."'")->result_array();
                if (count($getDefectueux)>0) {
                    # code...
                    foreach ($getDefectueux as $defectueux) {
                    # code...
                    $qtiteDefectueux = $qtiteDefectueux + $defectueux['qtite'];
                   
                    }
                    echo"<td>".$qtiteDefectueux."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }
                
                echo "
                <td>$montant3</td>";
                
                 $montant2_3 = $qtiteDefectueux * $montant3;
                 
                  echo "
                <td>$montant2_3</td>";

                $stock = $qtiteInventaire + $qtiteApprovisionnement - $qtiteDefectueux - $qtitePieceRechange;
                echo"<td>".$stock."</td>
                    ";
                $stockval = $montant2 + $montant2_1 - $montant2_2 - $montant2_3;
                echo"<td>".$stockval."</td>
                    ";
                    
                    $compteur++;
        }

        
    }

    $this->db->close();
}


public function stockInitial($id_article){

    $date_debut = $_POST["date_debut"];
    $date_fin = $_POST["date_fin"];
    // $date_fin = date("d/m/Y",strtotime($date_fin));   
    // $date_debut = date("d/m/Y",strtotime($date_debut));   
    if ($date_debut > $this->getDateDernierInventaire()) {
                    # code...
        $date_fin = date("Y-m-d",strtotime($date_debut.'- 1 days'));
        $date_debut = $this->getDateDernierInventaire();
        }elseif ($date_debut == $this->getDateDernierInventaire()) {
            # code...
            $date_fin = $this->getDateDernierInventaire();
        }
   
        # code...
      
            // echo "<tr >
            //         <td onclick=\"creerDatable();\">".$compteur."</td>
            //          ";
                    $article = $this->db->query("SELECT * from article where id_article =".$id_article."")->row();
                    
                    // echo"
                    // <td>".$article->code_a_barre."</td>
                    // <td>".$article->article."</td>
                    // <td>".$article->prix_unitaire."</td>
                    // </td>";
                   $getCategorie = $this->db->query('SELECT * FROM categorie_article where id_categorie='.$article->id_categorie.'')->row();
                    // echo"<td>".$getCategorie->categorie."</td>
                    // ";
                $qtiteInventaire = 0;

                $getInventaire = $this->db->query('SELECT * from inventaire where id_article='.$article->id_article.' order by date_inv desc')->result_array();
                if (count($getInventaire)>0) {
                    # code...
                    foreach ($getInventaire as $inventaire) {
                    # code...
                    $qtiteInventaire = $qtiteInventaire + $inventaire['qtite'];
                    }
                    // echo"<td>".$qtiteInventaire."</td>";
                }else{
                    // echo "<td>0</td>";
                }

                $qtiteApprovisionnement = 0;
                $getApprovisionnement = $this->db->query("SELECT * from approvisionnement where id_article='.$article->id_article.' and date_app between '".$date_debut."' and '".$date_fin."'")->result_array();
                if (count($getApprovisionnement)>0) {
                    # code...
                    foreach ($getApprovisionnement as $app) {
                    # code...
                    $qtiteApprovisionnement= $qtiteApprovisionnement + $app['qtite'];
                    }
                    // echo"<td>".$qtiteApprovisionnement."</td>";
                }else{
                    // echo "<td>0</td>";
                }

                $qtitePieceRechange = 0;
                 $getPieceRechange = $this->db->query("SELECT * from piece_rechange where id_article='.$article->id_article.'
                    and date_rech between '".$date_debut."' and '".$date_fin."'")->result_array();
                if (count($getPieceRechange)>0) {
                    # code...
                    foreach ($getPieceRechange as $sortie) {
                    # code...
                    $qtitePieceRechange = $qtitePieceRechange + $sortie['qtite'];
                    }
                    // echo"<td>".$qtitePieceRechange."</td> ";
                }else{
                    // echo "<td>0</td>";
                }

                $qtiteDefectueux = 0;
                $getDefectueux = $this->db->query("SELECT * from defectueux where id_article='.$article->id_article.' and date_def between '".$date_debut."' and '".$date_fin."'")->result_array();
                if (count($getDefectueux)>0) {
                    # code...
                    foreach ($getDefectueux as $defectueux) {
                    # code...
                    $qtiteDefectueux = $qtiteDefectueux + $defectueux['qtite'];
                    }
                    // echo"<td>".$qtiteDefectueux."</td>";
                }else{
                    // echo "<td>0</td>";
                }

                $stock = $qtiteInventaire+$qtiteApprovisionnement - $qtiteDefectueux - $qtitePieceRechange;
                // echo"<td>".$stock."</td> ";
                return $stock;
                    // $compteur++;
        

        
    

    $this->db->close();
}


public function selectAllStock(){

    $date_debut = $_POST["date_debut"];
    $date_fin = $_POST["date_fin"];
    // $date_fin = date("d/m/Y",strtotime($date_fin));   
    // $date_debut = date("d/m/Y",strtotime($date_debut));   

    $getArticle = $this->db->query("SELECT * from article order by id_article desc")->result_array();
    $compteur = 0;
    if (count($getArticle) > 0) {
        # code...
        foreach ($getArticle as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                     ";
                    $article = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->row();
                    
                    echo"
                    <td>".$article->code_a_barre."</td>
                    <td>".$article->article."</td>
                    <td>".$article->prix_unitaire."</td>
                    </td>";
                   $getCategorie = $this->db->query('SELECT * FROM categorie_article where id_categorie='.$article->id_categorie.'')->row();
                    echo"<td>".$getCategorie->categorie."</td>
                    ";
                $qtiteInventaire = 0;
                $getInventaire = $this->db->query('SELECT * from inventaire where id_article='.$article->id_article.' order by date_inv desc')->result_array();

                if (count($getInventaire)>0) {
                    # code...
                    foreach ($getInventaire as $inventaire) {
                    # code...
                    $qtiteInventaire = $qtiteInventaire + $inventaire['qtite'];
                    }
                    $qtiteInventaire = $this->stockInitial($article->id_article);
                    echo"<td>".$qtiteInventaire."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }
                $qtiteApprovisionnement = 0;
                $getApprovisionnement = $this->db->query("SELECT * from approvisionnement where id_article='.$article->id_article.' and date_app between '".$date_debut."' and '".$date_fin."'")->result_array();
                if (count($getApprovisionnement)>0) {
                    # code...
                    foreach ($getApprovisionnement as $app) {
                    # code...
                    $qtiteApprovisionnement= $qtiteApprovisionnement + $app['qtite'];
                    }
                    echo"<td>".$qtiteApprovisionnement."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }

                $qtitePieceRechange = 0;
                 $getPieceRechange = $this->db->query("SELECT * from piece_rechange where id_article='.$article->id_article.' and date_rech between '".$date_debut."' and '".$date_fin."'")->result_array();
                if (count($getPieceRechange)>0) {
                    # code...
                    foreach ($getPieceRechange as $sortie) {
                    # code...
                    $qtitePieceRechange = $qtitePieceRechange + $sortie['qtite'];
                    }
                    echo"<td>".$qtitePieceRechange."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }

                $qtiteDefectueux = 0;
                $getDefectueux = $this->db->query("SELECT * from defectueux where id_article='.$article->id_article.' and date_def between '".$date_debut."' and '".$date_fin."'")->result_array();
                if (count($getDefectueux)>0) {
                    # code...
                    foreach ($getDefectueux as $defectueux) {
                    # code...
                    $qtiteDefectueux = $qtiteDefectueux + $defectueux['qtite'];
                    }
                    echo"<td>".$qtiteDefectueux."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }

                $stock = $qtiteInventaire+$qtiteApprovisionnement - $qtiteDefectueux - $qtitePieceRechange;
                echo"<td>".$stock."</td>
                    ";
                    $compteur++;
        }

        
    }

    $this->db->close();
}

public function selectAllStockvaleur(){

    $date_debut = $_POST["date_debut"];
    $date_fin = $_POST["date_fin"];
    // $date_fin = date("d/m/Y",strtotime($date_fin));   
    // $date_debut = date("d/m/Y",strtotime($date_debut));   

    $getArticle = $this->db->query("SELECT * from article order by id_article desc")->result_array();
    $compteur = 0;
    if (count($getArticle) > 0) {
        # code...
        foreach ($getArticle as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                     ";
                    $article = $this->db->query("SELECT * from article where id_article =".$row['id_article']."")->row();
                    
                    $montant = 0;
                    
                    $montant3 = 0;
                    echo"
                    <td>".$article->code_a_barre."</td>
                    <td>".$article->article."</td>
                  
                    </td>";
                    $montant = $montant+$article->prix_unitaire;
                    $montant3 = $montant3+$article->prix_unitaire;
                    
                   # code... $getCategorie = $this->db->query('SELECT * FROM categorie_article where id_categorie='.$article->id_categorie.'')->row();
                    # code... echo"<td>".$getCategorie->categorie."</td>
                    # code... ";
                $qtiteInventaire = 0;
                $getInventaire = $this->db->query('SELECT * from inventaire where id_article='.$article->id_article.' order by date_inv desc')->result_array();

                if (count($getInventaire)>0) {
                    # code...
                    foreach ($getInventaire as $inventaire) {
                    # code...
                    $qtiteInventaire = $qtiteInventaire + $inventaire['qtite'];
                    }
                    $qtiteInventaire = $this->stockInitial($article->id_article);
                    echo"<td>".$qtiteInventaire."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }
                
                echo "
                <td>".$article->prix_unitaire."</td>";
                
                
                
                $montant2 = $qtiteInventaire * $montant;
                 
                echo "
                <td>$montant2</td>";
                
                $qtiteApprovisionnement = 0;
                $getApprovisionnement = $this->db->query("SELECT * from approvisionnement where id_article='.$article->id_article.' and date_app between '".$date_debut."' and '".$date_fin."'")->result_array();
                if (count($getApprovisionnement)>0) {
                    # code...
                    foreach ($getApprovisionnement as $app) {
                    # code...
                    $qtiteApprovisionnement= $qtiteApprovisionnement + $app['qtite'];
                    $montant = $montant + $app['montant'];
                    }
                    echo"<td>".$qtiteApprovisionnement."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }
                
                echo "
                <td>$montant</td>";
                
                 $montant2_1 = $qtiteApprovisionnement * $montant;
                 
                echo "
                <td>$montant2_1</td>";

                $qtitePieceRechange = 0;
                 $montant = 0;
                $montant2_2 = 0;
                
                 $getPieceRechange = $this->db->query("SELECT * from piece_rechange where id_article='.$article->id_article.' and date_rech between '".$date_debut."' and '".$date_fin."'")->result_array();
                if (count($getPieceRechange)>0) {
                    # code...
                    foreach ($getPieceRechange as $sortie) {
                    # code...
                    $qtitePieceRechange = $qtitePieceRechange + $sortie['qtite'];
                    $montant = $montant + $sortie['prix_unitaire'];
                    }
                    echo"<td>".$qtitePieceRechange."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }
                
                 echo "
                <td>$montant</td>";
                
                 $montant2_2 = $qtitePieceRechange * $montant;
                 
                echo "
                <td>$montant2_2</td>";

                $qtiteDefectueux = 0;
               
                $montant2_3 = 0;

                $getDefectueux = $this->db->query("SELECT * from defectueux where id_article='.$article->id_article.' and date_def between '".$date_debut."' and '".$date_fin."'")->result_array();
                if (count($getDefectueux)>0) {
                    # code...
                    foreach ($getDefectueux as $defectueux) {
                    # code...
                    $qtiteDefectueux = $qtiteDefectueux + $defectueux['qtite'];
                    }
                    echo"<td>".$qtiteDefectueux."</td>
                    ";
                }else{
                    echo "<td>0</td>";
                }
                
                echo "
                <td>$montant3</td>";
                
                 $montant2_3 = $qtiteDefectueux * $montant3;
                 
                  echo "
                <td>$montant2_3</td>";


                $stock = $qtiteInventaire+$qtiteApprovisionnement - $qtiteDefectueux - $qtitePieceRechange;
                echo"<td>".$stock."</td>
                    ";
                    
                $stockval = $montant2 + $montant2_1 - $montant2_2 - $montant2_3;
                echo"<td>".$stockval."</td>
                    ";
                    $compteur++;
        }

        
    }

    $this->db->close();
}

public function getArticleParCategorie(){
    $categorie = $_POST["categorie"];

    $getArticle = $this->db->query("SELECT * from article where id_categorie=".$categorie."")->result_array();

    foreach ($getArticle as $row) {
        # code...

        echo"<option value='".$row['id_article']."'>".$row['article']."</option>";
    }

    $this->db->close();
}

    public function deleteInventaire($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé l'inventaire de l'article ".$this->getArticle($getCamion->id_article)." de la date du ".$getCamion->date_inv." le ".$date_notif." à ".$heure;


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

    public function deleteApprovisionnement($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé l'approvisionnement de l'article ".$this->getArticle($getCamion->id_article)." de la date du ".$getCamion->date_inv." le ".$date_notif." à ".$heure;


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

        public function deleteDefectueux($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé un article défectueux appelé ".$this->getArticle($getCamion->id_article)." de la date du ".$getCamion->date_inv." le ".$date_notif." à ".$heure;


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