<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model_article extends CI_Model {
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

    public function selectAllArticle(){
        $query = $this->db->query("SELECT * from article order by article asc")->result_array();

        if (count($query) >0 ) {
            # code...
            $compteur = 0;
        foreach ($query as $row) {
            # code...
          $getCategorie = $this->db->query("select * from categorie_article where id_categorie=".$row['id_categorie']."")->row();
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                   
                    <td>".$row['article']."</td>
                    <td>".$getCategorie->categorie."</td>
                    <td> ".number_format($row['prix_unitaire'],0,',',' ')."</td>
                    <td> ".$row['code_a_barre']."</td>
                    <td> ".$row['fournisseur']."</td>
                    <td> ".$row['manufacturier']."</td>
                   
                     <td> ".$row['seuil_commande']." </td>
                    <td>";

                 if($this->session->userdata('article_modification')=='true'){
                    echo"
                    <button type='button' onclick='infosLivraison(\"annulé\",\"".$row['article']."\",\"".$row['prix_unitaire']."\",\"".$row['code_a_barre']."\",\"".$row['fournisseur']."\",\"".$row['manufacturier']."\",\"".$row['seuil_commande']."\",\"".$row['id_article']."\",\"".$row['commentaire']."\",\"".$row['reference']."\");' class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                  }

                  if($this->session->userdata('article_suppression') == 'true'){
                    echo"
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='article' identifiant='".$row['id_article']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_article\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
            }
        }
    }

    public function addArticle(){
      $reference = addslashes($_POST['reference']);
      $numero = $_POST["numero"];
      $article = $_POST["article"];
      $seuil_commande = $_POST["seuilCommande"];
      $fournisseur = $_POST["fournisseur"];
      $manufacturier = $_POST["manufacturier"];
      $codeBarre = $_POST["codeBarre"];
      $categorie = $_POST["categorie"];
      $PU = preg_replace('/\s/','', $_POST["PU"]);
      $status = $_POST["status"];
      $commentaire = addslashes($_POST["commentaire"]);





      if ($status == 'insert') {
        // $requeteNumero = $this->db->query("select * from article where numero ='".$numero."'")->result_array();
         $requeteArticle = $this->db->query("select * from article where article ='".$article."'")->result_array();
    if (count($requeteArticle)>0) {
        # code...
        echo "Un article de même nom existe déjà";
      }else{
            $requete = $this->db->query("INSERT into article value('',".$categorie.",'".$article."',".$PU.",'".$codeBarre."','".$fournisseur."','".$manufacturier."',".$seuil_commande.",'".$commentaire."','".$reference."')");
      if ($requete == true) {
        # code...
        echo "Création parfaite de l'article";
      }else{
        echo "Erreur d'insertion";
      }
      }
        # code...
      
      }elseif ($status == 'update') {
        # code...
          $id_BL = $_POST["id_BL"];
          // $requeteNumero = $this->db->query("select * from article where numero ='".$numero."'")->result_array();
          $requeteArticle = $this->db->query("select * from article where article ='".$article."'")->result_array();
 
          if (count($requeteArticle)>0) {
                  # code...
                  
                  foreach ($requeteArticle as $tab2) {
                    # code...
                    if ($id_BL == $tab2["id_article"]) {
                        $requete = $this->db->query("UPDATE article set  article='".$article."', prix_unitaire=".$PU.", code_a_barre = '".$codeBarre."', fournisseur='".$fournisseur."', manufacturier='".$manufacturier."',seuil_commande=".$seuil_commande.",id_categorie=".$categorie.",commentaire='".$commentaire."',reference='".$reference."' where id_article=".$id_BL."");
                        if ($requete == true) {
                          # code...
                          echo "Modification parfaite de l'article";
                        }else{
                          echo "Erreur d'insertion";
                        }
                    }else{
                      echo "Un article de même nom existe déjà";
                    }
                  }
               
      }else{

                        $requete = $this->db->query("UPDATE article set article='".$article."', prix_unitaire=".$PU.", code_a_barre = '".$codeBarre."', fournisseur='".$fournisseur."', manufacturier='".$manufacturier."',seuil_commande=".$seuil_commande.",commentaire='".$commentaire."',reference='".$reference."' where id_article=".$id_BL."");
                        if ($requete == true) {
                          # code...
                          echo "Modification parfaite de l'article";
                        }else{
                          echo "Erreur d'insertion";
                        }
                  
      }
         
      }else{
          echo "Erreur veuillez contacter l'administrateur";
      }
      
    }

    public function leSelectClient(){
        $query1 = $this->db->query("select * from client")->result_array();
        if (count($query1)>0) {
        foreach ($query1 as $row) {
            echo "<option value='".$row["id_client"]."'>".$row["telephone"]."</option>";
        }
        }else{
            echo "<option value=''>aucune</option>";
         }
    }

        public function leSelectCategorie(){
        $query1 = $this->db->query("select * from categorie_article")->result_array();
        if (count($query1)>0) {
        foreach ($query1 as $row) {
            echo "<option value='".$row["id_categorie"]."'>".$row["categorie"]."</option>";
        }
        }else{
            echo "<option value=''>aucune</option>";
         }
    }



  public function addTypeArticle(){
        $categorie = $_POST["categorie"];
        $commentaire = $_POST["commentaire"];

        $status = $_POST["status"];
        if ($status =="insert") {
            # code...

                $requete = $this->db->query("SELECT * from categorie_article where categorie ='".$categorie."'")->result_array();
                if (count($requete)>0) {
                    # code...
                    echo "Erreur cette catégorie existe déjà pour ce type veuiller changer";
                }else{
                    $query1 = $this->db->query("insert into categorie_article value('','". $categorie. "','".$commentaire."')");
                            if($query1 == true){
                                echo "Insertion parfaite de la catégorie d'article";
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                }
        }elseif ($status == "update") {
            # code...
            $id_client =$_POST["id_client"];
                $requete = $this->db->query("SELECT * from categorie_article where categorie ='".$categorie."'")->result_array();
                if (count($requete)>0) {
                    # code...
                   foreach ($requete as $row) {
                       # code...
                        if ($row["id_categorie"] == $id_client) {
                            # code...
                            $query1 = $this->db->query("UPDATE categorie_article set categorie='".$categorie."', commentaire='".$commentaire."' where id_categorie=".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du la catégorie";
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                        }else{
                            echo "Erreur cette huile existe déjà pour ce type veuiller changer";
                        }
                   }
                }else{
                    $query1 = $this->db->query("UPDATE categorie_article set categorie='".$categorie."', commentaire='".$commentaire."' where id_categorie=".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du la catégorie";
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                }
        }else{
            echo "Erreur contactez l'administrateur".$status ;
        }
        
    }

    public function selectAllTypeArticle(){
              $query1 = $this->db->get_where('categorie_article')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['categorie']."
                    </td>
                    <td>".$row['commentaire']."</td>
                  
                    <td>";
                    if($this->session->userdata('article_modification')=='true'){
                      echo"
                    <button type='button' onclick=\"infosTypeArticle('".$row['categorie']."','".$row['commentaire']."','".$row['id_categorie']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                  }
                  if($this->session->userdata('article_suppression')=='true'){
                  
                  echo"  <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='categorie_article' identifiant='".$row['id_categorie']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_categorie\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
        }
    }

// le code qui suit est celui des fournisseur d'articles

public function addFournisseurArticle(){
        $commentaire = addslashes($_POST["commentaire"]);
        $nom = $_POST["nom"];
        $telephone = $_POST["telephone"];
        $adresse = $_POST["adresse"];
        $status = $_POST["status"];
        if ($status =="insert") {
            # code...
            // echo $telephone;
                $requete = $this->db->query("SELECT * from fournisseur_article where telephone =".$telephone."")->result_array();
                if (count($requete)>0) {
                    # code...
                    echo "Ce numéro de téléphone est déjà utilisé veuillez changer";
                }else{
                    $query1 = $this->db->query("insert into fournisseur_article value('','". $nom. "','".$adresse."',". $telephone.",'".$commentaire."')");
                            if($query1 == true){
                                echo "Insertion parfaite du fournisseur";
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                }
        }elseif ($status == "update") {
            # code...
            $id_client =$_POST["id_client"];
                $requete = $this->db->query("SELECT * from fournisseur_article where telephone =".$telephone."")->result_array();
                if (count($requete)>0) {
                    # code...
                   foreach ($requete as $row) {
                       # code...
                        if ($row["id_fournisseur"] == $id_client) {
                            # code...
                            $query1 = $this->db->query("UPDATE fournisseur_article set telephone=".$telephone.", adresse='".$adresse."', nom='".$nom."',commentaire = '".$commentaire."' where id_fournisseur =".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du fournisseur";
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                        }else{
                            echo "Erreur ce numero de téléphone est déjà utilisé";
                        }
                   }
                }else{
                    $query1 = $this->db->query("UPDATE fournisseur_article set telephone=".$telephone.", adresse='".$adresse."', nom='".$nom."',commentaire = '".$commentaire."' where id_fournisseur=".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du fournisseur";
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                }
        }else{
            echo "Erreur contactez l'administrateur";
        }
        
    }

    public function selectAllFournisseurArticle(){
              $query1 = $this->db->query('SELECT * from fournisseur_article order by nom asc')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['nom']."
                    </td>
                    <td>".$row['adresse']."</td>
                    <td> ".$row['telephone']."</td>
                    <td>";
                    if($this->session->userdata('article_modification')=='true'){
                      echo"
                    <button type='button' onclick=\"infosClient1('".$row['id_fournisseur']."','".$row['nom']."','".$row['adresse']."','".$row['telephone']."','".addslashes($row['commentaire'])."');\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";

                  }
                  if($this->session->userdata('article_suppression')=='true'){
                    echo"
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='fournisseur_article' identifiant='".$row['id_fournisseur']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_fournisseur\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
        }
    }

        public function leSelectFournisseurArticle(){
        $query = $this->db->query("select * from fournisseur_article ")->result_array();
        if (count($query) >0) {
            # code...
          echo "<option value=''></option>";
            foreach ($query as $row) {
                # code...
              // if ($row['id_fournisseur'] == 22) {
              //   # code...
              //   echo "<option value='".$row["id_fournisseur"]."'>".$row["nom"]."</option>";
              // }
                echo "<option value='".$row["id_fournisseur"]."'>".$row["nom"]."</option>";
            }
        }else{

        }
    }
    public function  getFournisseurMira(){
      $id_fournisseur = $_POST['id_fournisseur'];
        $query = $this->db->query("select * from fournisseur_article where id_fournisseur = ".$id_fournisseur." ")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_fournisseur"]."'>".$row["nom"]."</option>";
            }
        }else{

        }
    }
   


    public function addFacture(){
        $status = $_POST["status"];
        $numero = $_POST["numero"];
         $montant = intval(preg_replace('/\s/','', $_POST["montant"]));
        $date = $_POST["date"];
        $libelle = addslashes($_POST['libelle']);
        $id_fournisseur = $_POST["id_fournisseur"];

        $getDerniereCLoture = $this->db->query("SELECT * FROM cloture_article where id_fournisseur_article=".$id_fournisseur." order by id_cloture desc limit 1")->row();
        if (date("Y-m",strtotime($getDerniereCLoture->date_cloture)) < date("Y-m",strtotime($date))){
          # code...

        if ($status == "insert") {
            # code...
            $verifNumero = $this->db->query("SELECT * FROM facture_article WHERE numero = '".$numero."'")->row();
            if (count($verifNumero)>0) {
                # code...
                echo "Ce numéro de facture est déjà utilisé veuillez changer";
            }else{
                $insertFacture = $this->db->query("INSERT INTO facture_article value('',".$id_fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",'".$libelle."')");
                if ($insertFacture == true) {
                    # code...
                    echo "Insertion parfaite de la facture";
                }else{
                    echo "Erreur d'insertion";
                }
            }
        }elseif ($status == "update") {
            # code...
            $id_facture = $_POST["id_facture"];
            $verifNumero = $this->db->query("SELECT * FROM facture_article WHERE numero = '".$numero."'")->result_array();
            if (count($verifNumero)>0) {
                # code...
                
                foreach ($verifNumero as $row) {
                  # code...
                  if ($id_facture == $row['id_facture']) {
                    # code...
                    $update = $this->db->query("UPDATE facture_article set  id_fournisseur =".$id_fournisseur.",date_fact = CAST('". $date."' AS DATE),numero = '".$numero."',montant = ".$montant.",libelle='".$libelle."' where id_facture=".$id_facture."");
                if ($update == true ) {
                    # code...
                    echo "Facture modifiée";
                }else{
                    echo "Erreur lors de la modification";
                }
                  }else{
                    echo "Ce numéro de facture est déjà utilisé veuillez changer";
                  }
                }
            }else{
                 $update = $this->db->query("UPDATE facture_article set  id_fournisseur =".$id_fournisseur.",date_fact = CAST('". $date."' AS DATE),numero = '".$numero."',montant = ".$montant.",libelle='".$libelle."' where id_facture=".$id_facture."");
                if ($update == true ) {
                    # code...
                    echo "Facture modifiée";
                }else{
                    echo "Erreur lors de la modification";
                }
            }
        }else{
            echo "Erreur fatale";
        }
        }else{
          echo "Entrez une date supérieure à celle de la dernière cloture de d'articles de ce fournisseur";
        }
    }
    public function selectAllFacture(){
         $query1 = $this->db->query('SELECT * from  facture_article order by date_fact desc')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                     
                     $getFournisseur = $this->db->query("select * from fournisseur_article where id_fournisseur = ".$row["id_fournisseur"]."")->row();

                    echo"
                    <td>".$row['numero']."</td>
                    <td> ";
                    if (count($getFournisseur )>0) {
                      # code...
                      echo $getFournisseur->nom;
                    }else{
                      echo "aucun";
                    }
                    echo" </td>
                    
                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td>".$row['libelle']."</td>
                    <td>".$row['date_fact']." </td>
                    <td>";

                    if($this->session->userdata('article_modification')=='true'){
                    echo"<button type='button' onclick=\"infosFacture('".$row['id_facture']."','".$row['numero']."','".$row['date_fact']."','".$row['libelle']."','".number_format($row['montant'],0,',',' ')."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                  }

                  if($this->session->userdata('article_suppression')=='true'){
                   echo" <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='facture_article' identifiant='".$row['id_facture']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_facture\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
        }
    }

        public function selectAllFactureParFournisseur(){
          $id_fournisseur = $_POST['id_fournisseur'];
         $query1 = $this->db->query('SELECT * from  facture_article where id_fournisseur ='.$id_fournisseur.' order by date_fact desc')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...
          $getCloture = $this->db->query("SELECT * from cloture_article where id_fournisseur_article = ".$id_fournisseur." order by id_cloture desc limit 1")->row();
          if (count($getCloture)>0) {
            # code...
            if ($row['date_fact'] > $getCloture->date_cloture) {
            # code...
             echo "<tr >
                    
                    <td> ".$compteur."</td>";

                     
                     $getFournisseur = $this->db->query("select * from fournisseur_article where id_fournisseur = ".$row["id_fournisseur"]."")->row();

                    echo"
                    <td>".$row['numero']."</td>
                    <td> ";
                    if (count($getFournisseur )>0) {
                      # code...
                      echo $getFournisseur->nom;
                    }else{
                      echo "aucun";
                    }
                    echo" </td>
                    
                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td>".$row['libelle']."</td>
                    <td>".$row['date_fact']." </td>
                    <td>";

                  if($this->session->userdata('article_modification')=='true'){
                    echo"<button type='button' onclick=\"infosFacture('".$row['id_facture']."','".$row['numero']."','".$row['date_fact']."','".$row['libelle']."','".number_format($row['montant'],0,',',' ')."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                  }
                  if($this->session->userdata('article_suppression')=='true'){
                    echo"
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='facture_article' identifiant='".$row['id_facture']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_facture\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
          }else{

           
          }
          }else{
            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                     
                     $getFournisseur = $this->db->query("select * from fournisseur_article where id_fournisseur = ".$row["id_fournisseur"]."")->row();

                    echo"
                    <td>".$row['numero']."</td>
                    <td> ";
                    if (count($getFournisseur )>0) {
                      # code...
                      echo $getFournisseur->nom;
                    }else{
                      echo "aucun";
                    }
                    echo" </td>
                    
                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td>".$row['libelle']."</td>
                    <td>".$row['date_fact']." </td>
                    <td>";
                    if($this->session->userdata('article_modification')=='true'){
                      echo"
                    <button type='button' onclick=\"infosFacture('".$row['id_facture']."','".$row['numero']."','".$row['date_fact']."','".$row['libelle']."','".number_format($row['montant'],0,',',' ')."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                  }
                  if($this->session->userdata('article_suppression')=='true'){
                    echo"
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='facture_article' identifiant='".$row['id_facture']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_facture\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;

          }
          
        }
    }

// nous passsons donc au règlement


     public function selectAllReglement(){
         $query1 = $this->db->query('SELECT * from reglement_article order by date_reg desc')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                    $getOperation = $this->db->query("SELECT * FROM fournisseur_article where id_fournisseur = ".$row['id_fournisseur']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom']."</td>";
                        }
                    }else {
                        # code...
                         echo"<td></td>";

                    }
                     


                    echo"
                    <td>".$row['numero']."</td>
                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td>".$row['libelle']."</td>
                    <td> ".$row['date_reg']." </td>
                    <td>";
                    if($this->session->userdata('article_modification')=='true'){
                      echo"
                    <button type='button' onclick=\"infosFacture('".$row['id_reglement']."','".$row['numero']."','".$row['date_reg']."','".addslashes($row['libelle'])."','".number_format($row['montant'],0,',',' ')."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                  }
                  if($this->session->userdata('article_suppression')=='true'){
                    echo"
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='reglement_article' identifiant='".$row['id_reglement']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_reglement\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
        }
    }
         public function selectAllReglementParFournisseur(){
         $id_fournisseur = $_POST['id_fournisseur'];
         $query1 = $this->db->query('SELECT * from  reglement_article where id_fournisseur ='.$id_fournisseur.' order by date_reg desc')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...
          $getCloture = $this->db->query("SELECT * from cloture_article where id_fournisseur_article = ".$id_fournisseur." order by id_cloture desc limit 1")->row();
          if (count($getCloture)>0) {
        // foreach ($query1 as $row) {
            # code...
          if (date("Y-m",strtotime($getCloture->date_cloture)) < date("Y-m",strtotime($row['date_reg']))) {
            # code...
              echo "<tr >
                    
                    <td> ".$compteur." 2</td>";

                    $getOperation = $this->db->query("SELECT * FROM fournisseur_article where id_fournisseur = ".$row['id_fournisseur']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom']."</td>";
                        }
                    }else {
                        # code...
                         echo"<td></td>";

                    }
                     


                    echo"
                    <td>".$row['numero']."</td>
                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td>".$row['libelle']."</td>
                    <td> ".$row['date_reg']." </td>
                    <td>";
                    if($this->session->userdata('article_modification')=='true'){
                    echo"
                    <button type='button' onclick=\"infosFacture('".$row['id_reglement']."','".$row['numero']."','".$row['date_reg']."','".$row['libelle']."','".number_format($row['montant'],0,',',' ')."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                  }
                  if($this->session->userdata('article_suppression')=='true'){
                    echo"
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='reglement_article' identifiant='".$row['id_reglement']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_reglement\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
          }
          
        // }
      }else{
          foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                    $getOperation = $this->db->query("SELECT * FROM fournisseur_article where id_fournisseur = ".$row['id_fournisseur']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom']."</td>";
                        }
                    }else {
                        # code...
                         echo"<td></td>";

                    }
                     


                    echo"
                    <td>".$row['numero']."</td>
                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td>".$row['libelle']."</td>
                    <td> ".$row['date_reg']." </td>
                    <td>";
                    if($this->session->userdata('article_modification')=='true'){
                    echo"
                    <button type='button' onclick=\"infosFacture('".$row['id_reglement']."','".$row['numero']."','".$row['date_reg']."','".$row['libelle']."','".number_format($row['montant'],0,',',' ')."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                  }
                  if($this->session->userdata('article_suppression')=='true'){
                  echo"
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='reglement_article' identifiant='".$row['id_reglement']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_reglement\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
        }
      }
    }
    }

    public function addReglement(){
        $status = $_POST["status"];
        $numero = $_POST["numero"];
         $montant = preg_replace('/\s/','', $_POST["montant"]);
        $date = $_POST["date"];
        $libelle = addslashes($_POST["libelle"]);
        $id_fournisseur = $_POST["id_fournisseur"];

        $getDerniereCLoture = $this->db->query("SELECT * FROM cloture_article where id_fournisseur_article=".$id_fournisseur." order by id_cloture desc limit 1")->row();
        if (count($getDerniereCLoture)>0) {
          # code...
        

        if ($status == "insert") {
            # code...
          if (date("Y-m",strtotime($getDerniereCLoture->date_cloture)) < date("Y-m",strtotime($date))){

            $verifNumero = $this->db->query("SELECT * FROM reglement_article WHERE numero = '".$numero."'")->row();
            if (count($verifNumero)>0) {
                # code...
                echo "Ce numéro de facture est déjà utilisé veuillez changer";
            }else{
                $insertFacture = $this->db->query("INSERT INTO reglement_article value('',".$id_fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",'".$libelle."')");
                if ($insertFacture == true) {
                    # code...
                    echo "Règlement de la facture effectué 2";
                }else{
                    echo "Erreur d'insertion";
                }
            }
            }else{
          echo "Entrez une date supérieure à celle de la dernière cloture de d'articles de ce fournisseur";
        }
        }elseif ($status == "update") {
            # code...
          if (date("Y-m",strtotime($getDerniereCLoture->date_cloture)) < date("Y-m",strtotime($date))){
              $id_facture = $_POST["id_facture"];
            $verifNumero = $this->db->query("SELECT * FROM reglement_article WHERE numero = '".$numero."'")->result_array();
            if (count($verifNumero)>0) {
                # code...
                foreach ($verifNumero as $row) {
                  # code...
                  if ($id_facture == $row['id_reglement']) {
                    # code...
                    $update = $this->db->query("UPDATE reglement_article set  id_fournisseur =".$id_fournisseur.",date_reg = CAST('". $date."' AS DATE),numero = '".$numero."',montant = ".$montant.",libelle='".$libelle."' where id_reglement
                      =".$id_facture."");
                if ($update == true ) {
                    # code...
                    echo "Règlement modifié";
                }else{
                    echo "Erreur lors de la modification";
                }
                  }else{
                    echo "Ce numéro de facture est déjà utilisé veuillez changer";
                  }
                }
            }else{
                 $update = $this->db->query("UPDATE reglement_article set  id_fournisseur =".$id_fournisseur.",date_reg = CAST('". $date."' AS DATE),numero = '".$numero."',montant = ".$montant.",libelle='".$libelle."' where id_reglement=".$id_facture."");
                if ($update == true ) {
                    # code...
                    echo "Règlement modifié";
                }else{
                    echo "Erreur lors de la modification";
                }
            }
             }else{
          echo "Ce mois a déjà été cloturé vous ne pouvez plus y apporter des modifications";
        }
        }else{
            echo "Erreur fatale";
        }
        
      }else{
        if ($status == "insert") {
            # code...
            $verifNumero = $this->db->query("SELECT * FROM reglement_article WHERE numero = '".$numero."'")->row();
            if (count($verifNumero)>0) {
                # code...
                echo "Ce numéro de facture est déjà utilisé veuillez changer";
            }else{
                $insertFacture = $this->db->query("INSERT INTO reglement_article value('',".$id_fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",'".$libelle."')");
                if ($insertFacture == true) {
                    # code...
                    echo "Règlement de la facture effectué";
                }else{
                    echo "Erreur d'insertion";
                }
            }
        }elseif ($status == "update") {
            # code...
              $id_facture = $_POST["id_facture"];
            $verifNumero = $this->db->query("SELECT * FROM reglement_article WHERE numero = '".$numero."'")->result_array();
            if (count($verifNumero)>0) {
                # code...
                
                foreach ($verifNumero as $row) {
                  # code...
                  if ($id_facture == $row['id_reglement']) {
                    # code...
                    $update = $this->db->query("UPDATE reglement_article set  id_fournisseur =".$id_fournisseur.",date_reg = CAST('". $date."' AS DATE),numero = '".$numero."',montant = ".$montant.",libelle='".$libelle."' where id_reglement
                      =".$id_facture."");
                if ($update == true ) {
                    # code...
                    echo "Règlement modifié";
                }else{
                    echo "Erreur lors de la modification";
                }
                  }else{
                    echo "Ce numéro de facture est déjà utilisé veuillez changer";
                  }
                }
            }else{
                 $update = $this->db->query("UPDATE reglement_article set  id_fournisseur =".$id_fournisseur.",date_reg = CAST('". $date."' AS DATE),numero = '".$numero."',montant = ".$montant.",libelle='".$libelle."' where id_reglement=".$id_facture."");
                if ($update == true ) {
                    # code...
                    echo "Règlement modifié";
                }else{
                    echo "Erreur lors de la modification";
                }
            }
        }else{
            echo "Erreur fatale";
        }
      }
    }

public function leSelectFacture(){
        $getGazoil = $this->db->query("SELECT * FROM facture_article ")->result_array();

        if (count($getGazoil) >0) {
            # code...
            foreach ($getGazoil as $row) {
                # code...
                echo "<option value='".$row['id_facture']."'> ".$row['numero']." </option>";
            }
        }
    }

    

public function selectAllFacturePourBalance(){
        $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_article WHERE  id_fournisseur='.$id_fournisseur.'')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact between "'.$date_debut.'" and "'.$date_fin.'" and id_fournisseur='.$id_fournisseur.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact<="'.$date_fin.'" and id_fournisseur='.$id_fournisseur.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact<="'.$date_debut.'" and id_fournisseur='.$id_fournisseur.'')->result_array();

        }
         $compteur = 0;
         $montant = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                    echo "
                    <td>".$row['numero']."</td>
                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td> ".$row['date_fact']." </td>
                   
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
             $query1 = $this->db->query('SELECT * FROM facture_article WHERE  id_fournisseur='.$id_fournisseur.'')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact between "'.$date_debut.'" and "'.$date_fin.'" and id_fournisseur='.$id_fournisseur.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact<="'.$date_fin.'" and id_fournisseur='.$id_fournisseur.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_article WHERE  date_fact<="'.$date_debut.'" and id_fournisseur='.$id_fournisseur.'')->result_array();

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
             $query1 = $this->db->query('SELECT * FROM reglement_article  WHERE  id_fournisseur='.$id_fournisseur.'')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_article  WHERE  date_reg>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_article WHERE  date_reg<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_article WHERE  date_reg between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_article WHERE  date_reg between "'.$date_debut.'" and "'.$date_fin.'" and id_fournisseur='.$id_fournisseur.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_article WHERE  date_reg<="'.$date_fin.'" and id_fournisseur='.$id_fournisseur.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_article WHERE  date_reg<="'.$date_debut.'" and id_fournisseur='.$id_fournisseur.'')->result_array();

        }
         $compteur = 0;
         $montant = 0;
        foreach ($query1 as $tab) {
            # code...
                              echo "<tr >
                    
                    <td> ".$compteur."</td>";
                   
                             echo"
                                <td>".$tab['numero']."</td>
                                <td>".number_format($tab['montant'],0,',',' ')."</td>
                                <td> ".$tab['date_reg']." </td>
                                
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
             $query1 = $this->db->query('SELECT * FROM reglement_article  WHERE  id_fournisseur='.$id_fournisseur.'')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_article  WHERE  date_reg>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_article WHERE  date_reg<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_article WHERE  date_reg between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_article WHERE  date_reg between "'.$date_debut.'" and "'.$date_fin.'" and id_fournisseur='.$id_fournisseur.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_article WHERE  date_reg<="'.$date_fin.'" and id_fournisseur='.$id_fournisseur.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_article WHERE  date_reg<="'.$date_debut.'" and id_fournisseur='.$id_fournisseur.'')->result_array();

        }
         $compteur = 0;
         $montant = 0;
        foreach ($query1 as $tab) {
           
             $montant = $montant+$tab['montant'];
                         
        }
        return $montant;
    }

    public function soldeCaisseFournisseur(){
    echo $this->selectAllTotalFacturePourBalanceFournisseur()-$this->selectAllTotalReglementPourBalanceFournisseur();
}

 public function getSoldeArticle(){
    $id_fournisseur = $_POST["id_fournisseur"];
    $date_article = date("Y-m",strtotime($_POST["date_article"]));

            $query1 = $this->db->query('SELECT * FROM facture_article where date_fact like "%'.$date_article.'%" and id_fournisseur='.$id_fournisseur.'')->result_array();
      

    $montant = 0;
    foreach ($query1 as $row) {
        # code...
        $montant = $montant + $row["montant"];
    }

   
            $query2 = $this->db->query('SELECT * FROM reglement_article where date_reg like "%'.$date_article.'%" and id_fournisseur='.$id_fournisseur.'')->result_array();
       

    $montant2 = 0;
    foreach ($query2 as $row) {
        # code...
        $montant2 = $montant2 + $row["montant"];
    }

    echo number_format($montant-$montant2,0,',',' ')." FCFA";
}


public function getTotalReglement(){
    $id_fournisseur = $_POST["id_fournisseur"];
    $date_article = date("Y-m",strtotime($_POST["date_article"]));

            $query1 = $this->db->query('SELECT * FROM reglement_article where date_reg like "%'.$date_article.'%" and id_fournisseur='.$id_fournisseur.'')->result_array();
        
    $montant = 0;
    foreach ($query1 as $row) {
        # code...
        $montant = $montant + $row["montant"];
    }

    echo number_format($montant,0,',',' ')." FCFA";
}


public function getTotalFacture(){
 $id_fournisseur = $_POST["id_fournisseur"];
  $date_article = date("Y-m",strtotime($_POST["date_article"]));
            $query2 = $this->db->query('SELECT * FROM facture_article where date_fact like "%'.$date_article.'%" and id_fournisseur='.$id_fournisseur.'')->result_array();
   
    $montant = 0;
    foreach ($query2 as $row) {
        # code...
        $montant = $montant + $row["montant"];
    }

    echo number_format($montant,0,',',' ')." FCFA";
}


 public function getValiditeDate2($date,$id_fournisseur){
    $getDelai = $this->db->query("SELECT * from cloture_article  where date_cloture like '%".$date."%' and id_fournisseur_article=".$id_fournisseur." and cloture =1 order by date_cloture desc limit 1")->row();

    if (count($getDelai)>0) {
        # code...
        return true;
        // if ($getDelai->date_cloture == $date) {
        //     # code...
        //     return true;
        // }else{
        //     return false;
        // }
    }else{
        // $getLastDateCloture = $this->db->query("SELECT * from cloture_caisse order by id_cloture desc ")->row();
        // return $getDelai->date_cloture;
        return false;
    }
}
public function demandeClotureMois($date_cloture){
    date_default_timezone_set('Africa/Lagos');
    $date_prec = date("Y-m",strtotime($date_cloture.'- 1 month'));

    // echo " la date est: ".$date_prec;

    $query = $this->db->query("SELECT * from cloture_article where date_cloture like '%".$date_prec."%' and cloture =1")->row();
    if (count($query)>0) {
        # code...
        return true;
    }else{

        return false;
    }
}
 public function addClotureArticle(){
        $date_cloture = $_POST["date_cloture"];
        
        $facture =  intval(preg_replace('/\s/','', $_POST["facture"]));
        $reglement = intval(preg_replace('/\s/','', $_POST["reglement"]));
        $solde = intval(preg_replace('/\s/','', $_POST["solde"]));
        $cloturer = $_POST["cloturer"];
        $ordonateur = $_POST['ordonateur'];
        $id_fournisseur = $_POST['id_fournisseur'];
        $status = $_POST["status"];

        if ($solde>0 || $solde < 0) {
          # code...
          echo "Le solde de ce fournisseur doit etre de 0 FCFA pour cloturer";
        }else{

        if ( $status == "insert") {
            # code...
            if ($this->getValiditeDate2(date("Y-m",strtotime($date_cloture)),$id_fournisseur) == true) {
            # code...
            echo "Entrez une date supérieure à celle de la dernière cloture pour ce fournisseur";
        }
        // elseif ($this->demandeClotureMois($date_cloture) == false) {
        //     # code...
        //     echo "Veuillez d'abord cloturer le mois précédent".date("Y-m",strtotime($date_cloture.'- 1 month'));
        // }
        else{
            $insertion = $this->db->query("INSERT INTO cloture_article value('',".$id_fournisseur.",CAST('". $date_cloture."' AS DATE),".$facture.",".$reglement.",".$solde.",'".$ordonateur."',".$cloturer.")");
            if ($insertion == true) {
                # code...
                echo "Cloture effectuée"; 
            }else{
                echo "Erreur de cloture contactez l'administrateur";
            }
         }
        }elseif ($status == "update") {
            # code...
            $ancienne_date = $_POST["ancienne_date"];
        if ($date_cloture == $ancienne_date) {
            # code...

             $id_cloture = $_POST["id_cloture"];

            $update = $this->db->query("UPDATE cloture_article set id_fournisseur=".$id_fournisseur.", date_cloture=CAST('". $date_cloture."' AS DATE),facture=".$facture.",reglement=".$reglement.",solde=".$solde.",ordonateur='".$ordonateur."' where id_cloture = ".$id_cloture."");
            if ($update == true) {
                # code...

                echo "Modification parfaite de la cloture";
            }else{

                echo "Erreur de modification";
            }


        }else{
            $getDelai = $this->db->query("SELECT * from cloture_article  where date_cloture='".$date_cloture."' and cloture =1 order by date_cloture desc limit 1")->row();
         if (count($getDelai)>0) {
            # code...
            echo "Une cloture a déjà été éffectuée à cette date veuillez changer";
            
        }else{

             $id_cloture = $_POST["id_cloture"];

            $update = $this->db->query("UPDATE cloture_article set id_fournisseur=".$id_fournisseur.", date_cloture=CAST('". $date_cloture."' AS DATE),facture=".$facture.",reglement=".$reglement.",solde=".$solde.",ordonateur='".$ordonateur."' where id_cloture = ".$id_cloture."");
            if ($update == true) {
                # code...

                echo "Modification parfaite de la cloture";
            }else{

                echo "Erreur de modification";
            }

        }
     }
        }else{
            echo "Erreur fatale contactez l'administrateur";
        }
    }
  }
  
   public function selectAllClotureArticle(){
     $query = $this->db->query("SELECT * from cloture_article order by date_cloture  desc")->result_array();

        if (count($query) >0 ) {
            # code...
            $compteur = 0;
        foreach ($query as $row) {
            # code...
          $getFournisseur = $this->db->query("select * from fournisseur_article where id_fournisseur=".$row['id_fournisseur_article']."")->row();
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                   
                    <td>".$getFournisseur->nom."</td>
                    <td>".$row['date_cloture']."</td>
                    <td> ".number_format($row['facture'],0,',',' ')."</td>
                    <td> ".number_format($row['reglement'],0,',',' ')."</td>
                    <td> ".number_format($row['solde'],0,',',' ')."</td>
                    <td>".$row['ordonateur']."</td>
                   
                  </tr>

                  ";
                   // <td>
                    // <button type='button' onclick='infosClotureCaisse(\"".$row['date_cloture']."\",\"".$row['date_cloture']."\",\"".number_format($row['total_entree'],0,',',' ')." FCFA\",\"".number_format($row['total_sortie'],0,',',' ')." FCFA\",\"".number_format($row['solde'],0,',',' ')." FCFA\",\"".$row['ordonateur']."\",\"".$row['id_cloture']."\");' class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
               
                    // </td>
                  $compteur++;
            }
        }
    }
}