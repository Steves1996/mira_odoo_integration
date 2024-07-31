<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Crud_model_caisse extends CI_Model {
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

    public function addCaisse(){
        $nom =addslashes($_POST["nom_type"]);
        $telephone = addslashes($_POST["commentaire"]);
        $adresse = addcslashes($_POST["type"]);
        $status = $_POST["status"];
        if ($status =="insert") {
            # code...

                $requete = $this->db->query("SELECT * from type_entreeSortie where nom_type ='".$nom."' and type ='".$adresse."'")->result_array();
                if (count($requete)>0) {
                    # code...
                    echo "Un même nom de type existe déjà pour \"".$adresse."\"";
                }else{
                    $query1 = $this->db->query("insert into type_entreeSortie value('','". $adresse. "','". $nom."','".$telephone."')");
                            if($query1 == true){
                                echo "Insertion parfaite du type";
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                }
        }elseif ($status == "update") {
            # code...
            $id_client =$_POST["id_client"];
                $requete = $this->db->query("SELECT * from type_entreeSortie where nom_type ='".$nom."' and type ='".$adresse."'")->result_array();
                if (count($requete)>0) {
                    # code...
                   foreach ($requete as $row) {
                       # code...
                        if ($row["id_type"] == $id_client) {
                            # code...
                            $query1 = $this->db->query("UPDATE type_entreeSortie set commentaire='".$telephone."', type='".$adresse."', nom_type='".$nom."' where id_type=".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du type";
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                        }else{
                            echo "Erreur ce type existe dejà";
                        }
                   }
                }else{
                   $query1 = $this->db->query("UPDATE type_entreeSortie set commentaire='".$telephone."', type='".$adresse."', nom_type='".$nom."' where id_type=".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du type";
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                }
        }else{
            echo "Erreur contactez l'administrateur".$status ;
        }
        
    }

    public function selectAllCaisse(){
              $query1 = $this->db->get_where('type_entreeSortie')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['type']."
                    </td>
                    <td>".$row['nom_type']."</td>
                    <td> ".$row['commentaire']."</td>
                    <td>
                    <button type='button' onclick=\"infosClient('".$row['id_type']."','".$row['nom_type']."','".$row['commentaire']."','')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='type_entreeSortie' identifiant='".$row['id_type']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_type\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                  $compteur++;
        }
    }

        public function leSelectCaisseSortie(){
         $query1 = $this->db->query("select * from type_entreeSortie where type='sortie'")->result_array();
             if (count($query1)>0) {
                 # code...
                foreach ($query1 as $row) {
                echo "<option value='".$row["id_type"]."'>".$row["nom_type"]."</option>";
            }
         }else{
            echo "<option value=''>aucun</option>";
         }
     
}
public function leSelectCaisseEntree(){
         $query1 = $this->db->query("select * from type_entreeSortie where type='entree'")->result_array();
             if (count($query1)>0) {
                 # code...
                foreach ($query1 as $row) {
                echo "<option value='".$row["id_type"]."'>".$row["nom_type"]."</option>";
            }
         }else{
            echo "<option value=''>aucun</option>";
         }
     
}



public function selectAllSortie(){
         $query1 = $this->db->query('SELECT * from sortie order by date_sortie desc')->result_array();
         $compteur = 0;

         $getClotureCaisse = $this->db->query("SELECT * from cloture_caisse where cloture=1 order by date_cloture desc limit 1")->row();
        foreach ($query1 as $row) {
            # code...
            if (count($getClotureCaisse)>0) {
                # code...
                if ($getClotureCaisse->date_cloture >= $row['date_sortie']) {
                    # code...
                }else{
                echo "<tr >
                    
                    <td> ".$compteur."</td>";

                    $getOperation = $this->db->query("SELECT * FROM type_entreeSortie where id_type = ".$row['id_type']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_type']."</td>";
                        }
                    }
                    
                    echo"

                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td> ".$row['ordonnateur']."</td>
                    <td>".$row['commentaire']." </td>
                    
                    <td>".$row['date_sortie']."</td>
                    <td>
                    <button type='button'  onclick=\"infoPrime('".$row['montant']." ','".$row['ordonnateur']."','".$row['date_sortie']."','".$row['commentaire']."','".$row['id_type']."',".$row['id_sortie'].")\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='sortie' identifiant='".$row['id_sortie']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_sortie\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                }
            
                  $compteur++;
        }
    }}

    public function selectAllSortiePourBalance(){
         $query1 = $this->db->query(' SELECT * from sortie order by date_sortie asc')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                    $getOperation = $this->db->query("SELECT * FROM type_entreeSortie where id_type = ".$row['id_type']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_type']."</td>";
                        }
                    }
                    
                    echo"

                    <td>".$row['montant']." FCFA</td>
                    <td> ".$row['ordonnateur']."</td>
                    
                    <td>".$row['date_sortie']."</td>
                    
                  </tr>

                  ";
                  $compteur++;
        }
    }
public function getMontantSortieCaisse(){
    $query1 = $this->db->get_where('sortie')->result_array();
    $montant = 0;
    foreach ($query1 as $row) {
        # code...
        $montant = $montant + $row["montant"];
    }

    return $montant;
}
public function getMontantEntreeCaisse(){
    $query1 = $this->db->get_where('entree')->result_array();
    $montant = 0;
    foreach ($query1 as $row) {
        # code...
        $montant = $montant + $row["montant"];
    }

    return $montant;
}


public function getMontantSortieCaisseParJour(){
    $query1 = $this->db->query("SELECT * from sortie where date_sortie = '".date("Y/m/d")."'")->result_array();
    $montant = 0;
    foreach ($query1 as $row) {
        # code...
        $montant = $montant + $row["montant"];
    }

    return $montant;
}
public function getMontantEntreeCaisseParJour(){
    $query1 = $this->db->query("SELECT * from entree where date_entree = '".date("Y/m/d")."'")->result_array();
    $montant = 0;
    foreach ($query1 as $row) {
        # code...
        $montant = $montant + $row["montant"];
    }

    return $montant;
}

public function getSoldeCaisse(){
    $query1 = $this->db->get_where('sortie')->result_array();
    $montant = 0;
    foreach ($query1 as $row) {
        # code...
        $montant = $montant + $row["montant"];
    }

      $query2 = $this->db->get_where('entree')->result_array();
    $montant2 = 0;
    foreach ($query2 as $row) {
        # code...
        $montant2 = $montant2 + $row["montant"];
    }

    echo $montant2-$montant." FCFA";
}
public function addSortie(){
    $montant = preg_replace('/\s/','', $_POST["montant"]);
    $date = $_POST["date"];
    $type = $_POST["type"];
    $ordonateur =addslashes($_POST["ordonateur"]);
    $commentaire = addslashes($_POST["commentaire"]);
    $status = $_POST["status"];
    $id_prime = $_POST["id_prime"];
    if ($status == 'insert') {
        # code...
        if ($this->getValiditeDate($date) == true) {
            # code...
            echo "Entrez une date supérieure à celle de la dernière cloture de la caisse";
        }else{
                   $insertion = $this->db->query("INSERT INTO sortie value ('',".$type.",CAST('". $date."' AS DATE),".$montant.",'".$ordonateur."','".$commentaire."')");
            if ($insertion == true ) {
                # code...
                echo "Enregistrement de la sortie réussie";
            }else{
                echo "Erreur lors de l'insertion";
            }
        }
    }elseif ($status == 'update') {
        # code...
    if ($this->getValiditeDate($date) == true) {
            # code...
            echo "Entrez une date supérieure à celle de la dernière cloture de la caisse";
        }else{
                   $update = $this->db->query("UPDATE sortie set  commentaire ='".$commentaire."',ordonnateur='".$ordonateur."',date_sortie = CAST('". $date."' AS DATE),montant = ".$montant.",id_type = '".$type."' where id_sortie=".$id_prime."");
            if ($update == true ) {
                # code...
                echo "Modification de la sortie réussie";
            }else{
                echo "Erreur lors de la modification";
            }
        }
    }else{
        echo "Erreur veuillez contacter l'administrateur";
    }
 
}

public function selectAllEntree(){
         $query1 = $this->db->query('SELECT * from entree order by date_entree desc')->result_array();
         $compteur = 0;

         $getClotureCaisse = $this->db->query("SELECT * from cloture_caisse where cloture=1 order by date_cloture desc limit 1")->row();
        foreach ($query1 as $row) {
            # code...
            if (count($getClotureCaisse)>0) {
                # code...
                if ($getClotureCaisse->date_cloture >= $row['date_entree']) {
                    # code...
                }else{
                              echo "<tr>
                    
                    <td> ".$compteur."</td>";

                    $getOperation = $this->db->query("SELECT * FROM type_entreeSortie where id_type = ".$row['id_type']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_type']."</td>";
                        }
                    }
                    
                    echo"

                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td> ".$row['ordonnateur']."</td>
                    <td>".$row['commentaire']." </td>
                    
                    <td>".$row['date_entree']."</td>
                    <td>
                    <button type='button'  onclick=\"infoPrime('".$row['montant']." ','".$row['ordonnateur']."','".$row['date_entree']."','".$row['commentaire']."','".$row['id_type']."',".$row['id_entree'].")\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='entree' identifiant='".$row['id_entree']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_entree\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                }
            }
  
                  $compteur++;
        }
    }
    public function selectAllEntreePourBalance(){
         $query1 = $this->db->query('SELECT * from entree order by date_entree asc')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                    $getOperation = $this->db->query("SELECT * FROM type_entreeSortie where id_type = ".$row['id_type']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_type']."</td>";
                        }
                    }
                    
                    echo"

                    <td>".number_format($row['montant'],0,',',' ')." FCFA</td>
                    <td> ".$row['ordonnateur']."</td>
                    
                    <td>".$row['date_entree']."</td>
                    
                  </tr>

                  ";
                  $compteur++;
        }
    }

public function getValiditeDate($date){
    $getDelai = $this->db->query("SELECT * from cloture_caisse  where date_cloture>='".$date."' and cloture =1 order by date_cloture desc limit 1")->row();

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
public function addEntree(){
    $montant =preg_replace('/\s/','', $_POST["montant"]);
    $date = $_POST["date"];
    $type = $_POST["type"];
    $ordonateur =addslashes($_POST["ordonateur"]);
    $commentaire = addslashes($_POST["commentaire"]);
    $status = $_POST["status"];
    $id_prime = $_POST["id_prime"];
    if ($status == 'insert') {
        # code...
        if ($this->getValiditeDate($date) == true) {
            # code...
            echo "Entrez une date supérieure à celle de la dernière cloture de la caisse";
        }else{
           $insertion = $this->db->query("INSERT INTO entree value ('',".$type.",CAST('". $date."' AS DATE),".$montant.",'".$ordonateur."','".$commentaire."')");
            if ($insertion == true ) {
             # code...
                echo "Enregistrement de l'entrée réussie";
            }else{
                echo "Erreur lors de l'insertion";
            }
        }
   
    }elseif ($status == 'update') {
        # code...
        if ($this->getValiditeDate($date) == true) {
            # code...
            echo "Entrez une date supérieure à celle de la dernière cloture de la caisse";
        }else{
                   $update = $this->db->query("UPDATE entree set  commentaire ='".$commentaire."',ordonnateur='".$ordonateur."',date_entree = CAST('". $date."' AS DATE),montant = ".$montant.",id_type = '".$type."' where id_entree=".$id_prime."");
            if ($update == true ) {
                # code...
                echo "Modification de l'entrée réussie";
            }else{
                echo "Erreur lors de la modification";
            }
    }
    }else{
        echo "Erreur veuillez contacter l'administrateur";
    }
 
}

// le code qui suit est pour la gestion des fournisseur

public function addFournisseurCaisse(){
        $commentaire = addslashes($_POST['commentaire']);
        $nom = $_POST["nom"];
        $telephone = $_POST["telephone"];
        $adresse = $_POST["adresse"];
        $status = $_POST["status"];
        if ($status =="insert") {
            # code...
            // echo $telephone;
                $requete = $this->db->query("SELECT * from fournisseur_caisse where telephone =".$telephone."")->result_array();
                if (count($requete)>0) {
                    # code...
                    echo "Ce numéro de téléphone est déjà utilisé veuillez changer";
                }else{
                    $query1 = $this->db->query("insert into fournisseur_caisse value('','". $nom. "','".$adresse."',". $telephone.",'".$commentaire."')");
                            if($query1 == true){
                                echo "Insertion parfaite du fournisseur";
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                }
        }elseif ($status == "update") {
            # code...
            $id_client =$_POST["id_client"];
                $requete = $this->db->query("SELECT * from fournisseur_caisse where telephone =".$telephone."")->result_array();
                if (count($requete)>0) {
                    # code...
                   foreach ($requete as $row) {
                       # code...
                        if ($row["id_fournisseur"] == $id_client) {
                            # code...
                            $query1 = $this->db->query("UPDATE fournisseur_caisse set telephone=".$telephone.", adresse='".$adresse."', nom='".$nom."',commentaire = '".$commentaire."' where id_fournisseur =".$id_client."");
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
                    $query1 = $this->db->query("UPDATE fournisseur_caisse set telephone=".$telephone.", adresse='".$adresse."', nom='".$nom."',commentaire = '".$commentaire."' where id_fournisseur=".$id_client."");
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

    public function selectAllFournisseurCaisse(){
              $query1 = $this->db->get_where('fournisseur_caisse')->result_array();
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
                    <button type='button' onclick=\"infosClient1('".$row['id_fournisseur']."','".$row['nom']."','".$row['adresse']."','".$row['telephone']."','".addslashes($row['commentaire'])."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='fournisseur_caisse' identifiant='".$row['id_fournisseur']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_fournisseur\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                  $compteur++;
        }
    }

        public function leSelectFournisseurCaisse(){
        $query = $this->db->query("select * from fournisseur_caisse")->result_array();
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

         // $montant = $_POST["montant"];
          $montant= preg_replace('/\s/','', $_POST["montant"]);
        $date = $_POST["date"];
        $libelle = addslashes($_POST['libelle']);
        $id_fournisseur = $_POST["id_fournisseur"];


        if ($status == "insert") {
            # code...
            $verifNumero = $this->db->query("SELECT * FROM facture_caisse WHERE numero = '".$numero."'")->row();
            if (count($verifNumero)>0) {
                # code...
                echo "Ce numéro de facture est déjà utilisé veuillez changer";
            }else{
                $insertFacture = $this->db->query("INSERT INTO facture_caisse value('',".$id_fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",'".$libelle."')");
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
            $verifNumero = $this->db->query("SELECT * FROM facture_caisse WHERE numero = '".$numero."'")->result_array();
            if (count($verifNumero)>0) {
                # code...
                
                foreach ($verifNumero as $row) {
                  # code...
                  if ($id_facture == $row['id_facture']) {
                    # code...
                    $update = $this->db->query("UPDATE facture_caisse set  id_fournisseur =".$id_fournisseur.",date_fact = CAST('". $date."' AS DATE),numero = '".$numero."',montant = ".$montant.",libelle='".$libelle."' where id_facture=".$id_facture."");
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
                 $update = $this->db->query("UPDATE facture_caisse set  id_fournisseur =".$id_fournisseur.",date_fact = CAST('". $date."' AS DATE),numero = '".$numero."',montant = ".$montant.",libelle='".$libelle."' where id_facture=".$id_facture."");
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
         $query1 = $this->db->query('SELECT * from facture_caisse order by date_fact desc')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                     
                     $getFournisseur = $this->db->query("select * from fournisseur_caisse where id_fournisseur = ".$row["id_fournisseur"]."")->row();

                    echo"
                    <td>".$row['numero']."</td>
                    <td> ".$getFournisseur->nom." </td>
                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td>".$row['libelle']."</td>
                    <td>".$row['date_fact']." </td>
                    <td>
                    <button type='button' onclick=\"infosFacture('".$row['id_facture']."','".$row['numero']."','".$row['date_fact']."','".$row['libelle']."','".number_format($row['montant'],0,',',' ')."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='facture_caisse' identifiant='".$row['id_facture']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_facture\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";
                  $compteur++;
        }
    }

// nous passsons donc au règlement


     public function selectAllReglement(){
         $query1 = $this->db->query('SELECT * from reglement_caisse order by date_reg desc')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                    $getOperation = $this->db->query("SELECT * FROM fournisseur_caisse where id_fournisseur = ".$row['id_fournisseur']."")->result_array();

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
                    <td>
                    <button type='button' onclick=\"infosFacture('".$row['id_reglement']."','".$row['numero']."','".$row['date_reg']."','".$row['libelle']."','".number_format($row['montant'],0,',',' ')."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='reglement_caisse' identifiant='".$row['id_reglement']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_reglement\");'><i class='far fa-trash-alt'></i></button>
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
            $verifNumero = $this->db->query("SELECT * FROM reglement_caisse WHERE numero = '".$numero."'")->row();
            if (count($verifNumero)>0) {
                # code...
                echo "Ce numéro de facture est déjà utilisé veuillez changer";
            }else{
                $insertFacture = $this->db->query("INSERT INTO reglement_caisse value('',".$id_fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",'".$libelle."')");
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
            $verifNumero = $this->db->query("SELECT * FROM reglement_caisse WHERE numero = '".$numero."'")->result_array();
            if (count($verifNumero)>0) {
                # code...
                
                foreach ($verifNumero as $row) {
                  # code...
                  if ($id_facture == $row['id_reglement']) {
                    # code...
                    $update = $this->db->query("UPDATE reglement_caisse set  id_fournisseur =".$id_fournisseur.",date_reg = CAST('". $date."' AS DATE),numero = '".$numero."',montant = ".$montant.",libelle='".$libelle."' where id_reglement
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
                 $update = $this->db->query("UPDATE reglement_caisse set  id_fournisseur =".$id_fournisseur.",date_reg = CAST('". $date."' AS DATE),numero = '".$numero."',montant = ".$montant.",libelle='".$libelle."' where id_reglement=".$id_facture."");
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
        $getGazoil = $this->db->query("SELECT * FROM facture_caisse ")->result_array();

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
             $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE  id_fournisseur='.$id_fournisseur.' order by date_fact asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE  date_fact>="'.$date_debut.'" order by date_fact asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE  date_fact<="'.$date_fin.'" order by date_fact asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE  date_fact between "'.$date_debut.'" and "'.$date_fin.'" order by date_fact asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE  date_fact between "'.$date_debut.'" and "'.$date_fin.'" and id_fournisseur='.$id_fournisseur.' order by date_fact asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE  date_fact<="'.$date_fin.'" and id_fournisseur='.$id_fournisseur.' order by date_fact asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE  date_fact<="'.$date_debut.'" and id_fournisseur='.$id_fournisseur.' order by date_fact asc')->result_array();

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
                  $compteur++;
                  // $this->session->set_userdata('totalFacture',$montant);
        }
        // echo "<script type=\"text/javascript\">
        // $('.solde').val(".$montant.");
        //         $('.totalFacture').val(".$montant.");
        //      </script>";
    }
     public function selectAllTotalFacturePourBalanceFournisseur(){
        $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE  id_fournisseur='.$id_fournisseur.'')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE  date_fact>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE  date_fact<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE  date_fact between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE  date_fact between "'.$date_debut.'" and "'.$date_fin.'" and id_fournisseur='.$id_fournisseur.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE  date_fact<="'.$date_fin.'" and id_fournisseur='.$id_fournisseur.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE  date_fact<="'.$date_debut.'" and id_fournisseur='.$id_fournisseur.'')->result_array();

        }
         $compteur = 0;
         $montant = 0;
        foreach ($query1 as $row) {
            # code...

            $montant = $montant+$row['montant'];
        }
        return $montant;
    }
public function soldeCaisseFournisseur(){
    echo $this->selectAllTotalFacturePourBalanceFournisseur()-$this->selectAllTotalReglementPourBalanceFournisseur();
}
    public function selectAllClotureCaisse(){
     $query = $this->db->query("SELECT * from cloture_caisse order by date_cloture  desc")->result_array();

        if (count($query) >0 ) {
            # code...
            $compteur = 0;
        foreach ($query as $row) {
            # code...
          // $getCategorie = $this->db->query("select * from categorie_article where id_categorie=".$row['id_categorie']."")->row();
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                   
                    <td>".$row['date_cloture']."</td>
                    <td> ".number_format($row['total_entree'],0,',',' ')."</td>
                    <td> ".number_format($row['total_sortie'],0,',',' ')."/td>
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
    public function getValiditeDate2($date){
    $getDelai = $this->db->query("SELECT * from cloture_caisse  where date_cloture>='".$date."' and cloture =1 order by date_cloture desc limit 1")->row();

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

public function demandeClotureJournee($date_cloture){
    date_default_timezone_set('Africa/Lagos');
    $date_prec = date("Y-m-d",strtotime($date_cloture.'- 1 days'));

    // echo " la date est: ".$date_prec;

    $query = $this->db->query("SELECT * from cloture_caisse where date_cloture ='".$date_prec."' and cloture =1")->row();
    if (count($query)>0) {
        # code...
        return true;
    }else{
        return false;
    }
}
    public function addClotureCaisse(){
        $date_cloture = $_POST["date_cloture"];
        
        $total_entree =  intval(preg_replace('/\s/','', $_POST["total_entree"]));
        $total_sortie = intval(preg_replace('/\s/','', $_POST["total_sortie"]));
        $solde = intval(preg_replace('/\s/','', $_POST["solde"]));
        $cloturer = $_POST["cloturer"];
        $ordonateur = $_POST['ordonateur'];
        $status = $_POST["status"];


        if ( $status == "insert") {
            # code...
            if ($this->getValiditeDate2($date_cloture) == true) {
            # code...
            echo "Entrez une date supérieure à celle de la dernière cloture de la caisse";
        }elseif ($this->demandeClotureJournee($date_cloture) == false) {
            # code...
            echo "Veuillez d'abord cloturer la journé d'hier";
        }
        else{
            $insertion = $this->db->query("INSERT INTO cloture_caisse value('',CAST('". $date_cloture."' AS DATE),".$total_entree.",".$total_sortie.",".$solde.",'".$ordonateur."',".$cloturer.")");
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

            $update = $this->db->query("UPDATE cloture_caisse set date_cloture=CAST('". $date_cloture."' AS DATE),total_entree=".$total_entree.",total_sortie=".$total_sortie.",solde=".$solde.",ordonateur='".$ordonateur."' where id_cloture = ".$id_cloture."");
            if ($update == true) {
                # code...

                echo "Modification parfaite de la cloture";
            }else{

                echo "Erreur de modification";
            }


        }else{
            $getDelai = $this->db->query("SELECT * from cloture_caisse  where date_cloture='".$date_cloture."' and cloture =1 order by date_cloture desc limit 1")->row();
         if (count($getDelai)>0) {
            # code...
            echo "Une cloture a déjà été éffectuée à cette date veuillez changer";
            
        }else{

             $id_cloture = $_POST["id_cloture"];

            $update = $this->db->query("UPDATE cloture_caisse set date_cloture=CAST('". $date_cloture."' AS DATE),total_entree=".$total_entree.",total_sortie=".$total_sortie.",solde=".$solde.",ordonateur='".$ordonateur."' where id_cloture = ".$id_cloture."");
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

    public function selectAllReglementPourBalance(){
       $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
       if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_caisse  WHERE  id_fournisseur='.$id_fournisseur.' order by date_reg asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_caisse  WHERE  date_reg>="'.$date_debut.'"  order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_caisse WHERE  date_reg<="'.$date_fin.'"  order by date_reg asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_caisse WHERE  date_reg between "'.$date_debut.'" and "'.$date_fin.'"  order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_caisse WHERE  date_reg between "'.$date_debut.'" and "'.$date_fin.'" and id_fournisseur='.$id_fournisseur.'  order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_caisse WHERE  date_reg<="'.$date_fin.'" and id_fournisseur='.$id_fournisseur.'  order by date_reg asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_caisse WHERE  date_reg<="'.$date_debut.'" and id_fournisseur='.$id_fournisseur.'  order by date_reg asc')->result_array();

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

        // $total = $this->session->userdata('totalFacture')+$montant;
        // echo "<script type=\"text/javascript\">
        //         $('.totalReglement').val(".$montant.");
        //            totalReglement = $(\".totalReglement\").val();
        //              totalFacture = $('.solde').val();
        //              total = parseInt(totalFacture)-parseInt(totalReglement);
        //              $('.solde').val(total);
        //              // alert(totalFacture);
        //      </script>";
    }

        public function selectAllTotalReglementPourBalanceFournisseur(){
       $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
       if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_caisse  WHERE  id_fournisseur='.$id_fournisseur.'')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_caisse  WHERE  date_reg>="'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_caisse WHERE  date_reg<="'.$date_fin.'"')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_caisse WHERE  date_reg between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_caisse WHERE  date_reg between "'.$date_debut.'" and "'.$date_fin.'" and id_fournisseur='.$id_fournisseur.'')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_caisse WHERE  date_reg<="'.$date_fin.'" and id_fournisseur='.$id_fournisseur.'')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_caisse WHERE  date_reg<="'.$date_debut.'" and id_fournisseur='.$id_fournisseur.'')->result_array();

        }
         $compteur = 0;
         $montant = 0;
        foreach ($query1 as $tab) {
             $montant = $montant+$tab['montant'];       
        }

        return $montant;

    }


     public function selectAllEntreePourBalance2(){
         
         $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

        if (!empty($date_debut) && empty($date_fin)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM entree where date_entree >= "'.$date_debut.'" order by date_entree asc')->result_array();
        }elseif (!empty($date_fin) && empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM entree where date_entree <= "'.$date_fin.'" order by date_entree asc')->result_array();
        }elseif (!empty($date_debut) && !empty($date_fin)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM entree where date_entree between "'.$date_debut.'" and "'.$date_fin.'" order by date_entree asc')->result_array();
        }else{
         $query1 = $this->db->query('SELECT * FROM entree  order by date_entree asc')->result_array();
        }
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                    $getOperation = $this->db->query("SELECT * FROM type_entreeSortie where id_type = ".$row['id_type']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_type']."</td>";
                        }
                    }
                    
                    echo"

                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td> ".$row['ordonnateur']."</td>
                    
                    <td>".$row['date_entree']."</td>
                    
                  </tr>

                  ";
                  $compteur++;
        }
    }


    public function selectAllSortiePourBalance2(){
         
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

        if (!empty($date_debut) && empty($date_fin)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM sortie where date_sortie >= "'.$date_debut.'"  order by date_sortie asc')->result_array();
        }elseif (!empty($date_fin) && empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM sortie where date_sortie <= "'.$date_fin.'" order by date_sortie asc')->result_array();
        }elseif (!empty($date_debut) && !empty($date_fin)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM sortie where date_sortie between "'.$date_debut.'" and "'.$date_fin.'" order by date_sortie asc')->result_array();
        }else{
         $query1 = $this->db->query('SELECT * FROM sortie  order by date_sortie asc')->result_array();
        }
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                    $getOperation = $this->db->query("SELECT * FROM type_entreeSortie where id_type = ".$row['id_type']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_type']."</td>";
                        }
                    }
                    
                    echo"

                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td> ".$row['ordonnateur']."</td>
                    
                    <td>".$row['date_sortie']."</td>
                    <td> ".$row['commentaire']." </td>
                    
                  </tr>

                  ";
                  $compteur++;
        }
    }

    public function getSoldeCaisse2(){
    $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

        if (!empty($date_debut) && empty($date_fin)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM sortie where date_sortie >= "'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM sortie where date_sortie <= "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_debut) && !empty($date_fin)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM sortie where date_sortie between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }else{
         $query1 = $this->db->query('SELECT * FROM sortie')->result_array();
        }

    $montant = 0;
    foreach ($query1 as $row) {
        # code...
        $montant = $montant + $row["montant"];
    }

   if (!empty($date_debut) && empty($date_fin)) {
            # code...
            $query2 = $this->db->query('SELECT * FROM entree where date_entree >= "'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($date_debut)) {
            # code...
            $query2 = $this->db->query('SELECT * FROM entree where date_entree <= "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_debut) && !empty($date_fin)) {
            # code...
            $query2 = $this->db->query('SELECT * FROM entree where date_entree between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }else{
         $query2 = $this->db->query('SELECT * FROM entree')->result_array();
        }

    $montant2 = 0;
    foreach ($query2 as $row) {
        # code...
        $montant2 = $montant2 + $row["montant"];
    }

    echo number_format($montant2-$montant,0,',',' ')." FCFA";
}


public function getTotalSortie2(){
     $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

        if (!empty($date_debut) && empty($date_fin)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM sortie where date_sortie >= "'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM sortie where date_sortie <= "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_debut) && !empty($date_fin)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM sortie where date_sortie between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }else{
         $query1 = $this->db->query('SELECT * FROM sortie')->result_array();
        }
    $montant = 0;
    foreach ($query1 as $row) {
        # code...
        $montant = $montant + $row["montant"];
    }

    echo number_format($montant,0,',',' ');
}
public function getTotalEntree2(){
    $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
   if (!empty($date_debut) && empty($date_fin)) {
            # code...
            $query2 = $this->db->query('SELECT * FROM entree where date_entree >= "'.$date_debut.'"')->result_array();
        }elseif (!empty($date_fin) && empty($date_debut)) {
            # code...
            $query2 = $this->db->query('SELECT * FROM entree where date_entree <= "'.$date_fin.'"')->result_array();
        }elseif (!empty($date_debut) && !empty($date_fin)) {
            # code...
            $query2 = $this->db->query('SELECT * FROM entree where date_entree between "'.$date_debut.'" and "'.$date_fin.'"')->result_array();
        }else{
         $query2 = $this->db->query('SELECT * FROM entree')->result_array();
        }

    $montant = 0;
    foreach ($query2 as $row) {
        # code...
        $montant = $montant + $row["montant"];
    }

    echo number_format($montant,0,',',' ');
}



// ce code c'est pour la cloture caisse

    public function getSoldeCaisse3(){
    $date_debut = $_POST["date_debut"];

            $query1 = $this->db->query('SELECT * FROM sortie where date_sortie = "'.$date_debut.'"')->result_array();
      

    $montant = 0;
    foreach ($query1 as $row) {
        # code...
        $montant = $montant + $row["montant"];
    }

   
            $query2 = $this->db->query('SELECT * FROM entree where date_entree = "'.$date_debut.'"')->result_array();
       

    $montant2 = 0;
    foreach ($query2 as $row) {
        # code...
        $montant2 = $montant2 + $row["montant"];
    }

    echo number_format($montant2-$montant,0,',',' ')." FCFA";
}


public function getTotalSortie3(){
     $date_debut = $_POST["date_debut"];

            $query1 = $this->db->query('SELECT * FROM sortie where date_sortie = "'.$date_debut.'"')->result_array();
        
    $montant = 0;
    foreach ($query1 as $row) {
        # code...
        $montant = $montant + $row["montant"];
    }

    echo number_format($montant,0,',',' ')." FCFA";
}
public function getTotalEntree3(){
    $date_debut = $_POST["date_debut"];
      
            $query2 = $this->db->query('SELECT * FROM entree where date_entree = "'.$date_debut.'"')->result_array();
   
    $montant = 0;
    foreach ($query2 as $row) {
        # code...
        $montant = $montant + $row["montant"];
    }

    echo number_format($montant,0,',',' ')." FCFA";
}

}
