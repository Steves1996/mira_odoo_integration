<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model_article extends CI_Model {
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
                    <td>
                    <button type='button' onclick='infosLivraison(\"annulé\",\"".$row['article']."\",\"".$row['prix_unitaire']."\",\"".$row['code_a_barre']."\",\"".$row['fournisseur']."\",\"".$row['manufacturier']."\",\"".$row['seuil_commande']."\",\"".$row['id_article']."\");' class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='article' identifiant='".$row['id_article']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_article\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                  $compteur++;
            }
        }
    }

    public function addArticle(){
      $numero = $_POST["numero"];
      $article = $_POST["article"];
      $seuil_commande = $_POST["seuilCommande"];
      $fournisseur = $_POST["fournisseur"];
      $manufacturier = $_POST["manufacturier"];
      $codeBarre = $_POST["codeBarre"];
      $categorie = $_POST["categorie"];
      $PU = preg_replace('/\s/','', $_POST["PU"]);
      $status = $_POST["status"];





      if ($status == 'insert') {
        // $requeteNumero = $this->db->query("select * from article where numero ='".$numero."'")->result_array();
         $requeteArticle = $this->db->query("select * from article where article ='".$article."'")->result_array();
    if (count($requeteArticle)>0) {
        # code...
        echo "Un article de même nom existe déjà";
      }else{
            $requete = $this->db->query("INSERT into article value('',".$categorie.",'".$article."',".$PU.",'".$codeBarre."','".$fournisseur."','".$manufacturier."',".$seuil_commande.")");
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
                        $requete = $this->db->query("UPDATE article set  article='".$article."', prix_unitaire=".$PU.", code_a_barre = '".$codeBarre."', fournisseur='".$fournisseur."', manufacturier='".$manufacturier."',seuil_commande=".$seuil_commande.",id_categorie=".$categorie." where id_article=".$id_BL."");
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

                        $requete = $this->db->query("UPDATE article set article='".$article."', prix_unitaire=".$PU.", code_a_barre = '".$codeBarre."', fournisseur='".$fournisseur."', manufacturier='".$manufacturier."',seuil_commande=".$seuil_commande." where id_article=".$id_BL."");
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
                  
                    <td>
                    <button type='button' onclick=\"infosTypeArticle('".$row['categorie']."','".$row['commentaire']."','".$row['id_categorie']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='categorie_article' identifiant='".$row['id_categorie']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_categorie\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                  $compteur++;
        }
    }

// le code qui suit est celui des fournisseur d'articles

public function addFournisseurArticle(){
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
                    $query1 = $this->db->query("insert into fournisseur_article value('','". $nom. "','".$adresse."',". $telephone.")");
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
                            $query1 = $this->db->query("UPDATE fournisseur_article set telephone=".$telephone.", adresse='".$adresse."', nom='".$nom."' where id_fournisseur =".$id_client."");
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
                    $query1 = $this->db->query("UPDATE fournisseur_article set telephone=".$telephone.", adresse='".$adresse."', nom='".$nom."' where id_fournisseur=".$id_client."");
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
                    <td>
                    <button type='button' onclick=\"infosClient1('".$row['id_fournisseur']."','".$row['nom']."','".$row['adresse']."','".$row['telephone']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='fournisseur_article' identifiant='".$row['id_fournisseur']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_fournisseur\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
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
         $montant = preg_replace('/\s/','', $_POST["montant"]);
        $date = $_POST["date"];
        $libelle = addslashes($_POST['libelle']);
        $id_fournisseur = $_POST["id_fournisseur"];


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
                    <td> ".$getFournisseur->nom." </td>
                    
                    <td>".number_format($row['montant'],0,',',' ')." FCFA</td>
                    <td>".$row['libelle']."</td>
                    <td>".$row['date_fact']." </td>
                    <td>
                    <button type='button' onclick=\"infosFacture('".$row['id_facture']."','".$row['numero']."','".$row['date_fact']."','".$row['libelle']."','".number_format($row['montant'],0,',',' ')."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='facture_article' identifiant='".$row['id_facture']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_facture\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                  $compteur++;
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
                    <td>".number_format($row['montant'],0,',',' ')." FCFA</td>
                    <td>".$row['libelle']."</td>
                    <td> ".$row['date_reg']." </td>
                    <td>
                    <button type='button' onclick=\"infosFacture('".$row['id_reglement']."','".$row['numero']."','".$row['date_reg']."','".$row['libelle']."','".number_format($row['montant'],0,',',' ')."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='reglement_article' identifiant='".$row['id_reglement']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_reglement\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                  $compteur++;
        }
    }

    public function addReglement(){
        $status = $_POST["status"];
        $numero = $_POST["numero"];
         $montant = preg_replace('/\s/','', $_POST["montant"]);
        $date = $_POST["date"];
        $libelle = addslashes($_POST["libelle"]);
        $id_fournisseur = $_POST["id_fournisseur"];


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
                    <td>".number_format($row['montant'],0,',',' ')." FCFA</td>
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
                                <td>".number_format($tab['montant'],0,',',' ')." FCFA</td>
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
}