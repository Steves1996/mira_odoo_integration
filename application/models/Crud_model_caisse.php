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


public function notificationAjout($nom_table,$message){
  $this->db->query("INSERT into notification value('','".php_uname('n')."',".$this->session->userdata('id_profil').",'".$nom_table."','".$message."',now(),now())");
}

public function notificationAjout2($nom_table,$message){
  $this->db->query("INSERT into notification2 value('','".php_uname('n')."',".$this->session->userdata('id_profil').",'".$nom_table."','".$message."',now(),now())");
  
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
    public function addCaisse(){
        $nom =addslashes($_POST["nom_type"]);
        $telephone = $_POST["commentaire"];
        $adresse = $_POST["type"];
        $status = $_POST["status"];

    $nom_table = "type_entreesortie";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté une caisse ".$nom.", de type ".$adresse." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié une caisse ".$nom.", de type ".$adresse." le ".$date_notif." à ".$heure;

        if ($status =="insert") {
            # code...
                $requete = $this->db->query("SELECT * from type_entreesortie where nom_type ='".$nom."' and type ='".$adresse."'")->result_array();
                if (count($requete)>0) {
                    # code...
                    echo "Un même nom de type existe déjà pour \"".$adresse."\"";
                }else{
                    $query1 = $this->db->query("insert into type_entreesortie value('','". $adresse. "','". $nom."','".$telephone."')");
                            if($query1 == true){
                                echo "Insertion parfaite du type";
                                $this->notificationAjout($nom_table,addslashes($message));
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                }
        }else if ($status == "update") {
            # code...
            $id_client =$_POST["id_client"];
                $requete = $this->db->query("SELECT * from type_entreesortie where nom_type ='".$nom."' and type ='".$adresse."'")->result_array();
                if (count($requete)>0) {
                    # code...
                   foreach ($requete as $row) {
                       # code...
                        if ($row["id_type"] == $id_client) {
                            # code...
                            $query1 = $this->db->query("UPDATE type_entreesortie set commentaire='".$telephone."', type='".$adresse."', nom_type='".$nom."' where id_type=".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du type";
                                $this->notificationAjout($nom_table,addslashes($message2));
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                        }else{
                            echo "Erreur ce type existe dejà";
                        }
                   }
                }else{
                   $query1 = $this->db->query("UPDATE type_entreesortie set commentaire='".$telephone."', type='".$adresse."', nom_type='".$nom."' where id_type=".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du type";
                                $this->notificationAjout($nom_table,addslashes($message2));
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                }
        }else{
            echo "Erreur contactez l'administrateur".$status ;
        }
        $this->db->close();
    }

    public function selectAllCaisse(){
              $query1 = $this->db->get_where('type_entreesortie')->result_array();
        $compteur = 0;
        foreach ($query1 as $row) {
            # code...
            echo "<tr >
                    <td onclick=\"creerDatable();\">".$compteur."</td>
                    <td>".$row['type']."
                    </td>
                    <td>".$row['nom_type']."</td>
                    <td> ".$row['commentaire']."</td>
                    <td>";
                if($this->session->userdata('caisse_modification')=='true'){
                    echo"
                    <button type='button' onclick=\"infosClient('".$row['id_type']."','".$row['nom_type']."','".$row['commentaire']."','')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }
                if($this->session->userdata('caisse_suppression')=='true'){
                    echo"
                    <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='type_entreesortie' identifiant='".$row['id_type']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_type\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
        }
        $this->db->close();
    }

        public function leSelectCaisseSortie(){
         $query1 = $this->db->query("select * from type_entreesortie where type='sortie' order by nom_type")->result_array();
             if (count($query1)>0) {
                 # code...
                foreach ($query1 as $row) {
                echo "<option value='".$row["id_type"]."'>".$row["nom_type"]."</option>";
            }
         }else{
            echo "<option value=''>aucun</option>";
         }
     $this->db->close();
}


		public function leSelectCaisseEntree(){
         $query1 = $this->db->query("select * from type_entreesortie where type='entree' order by nom_type")->result_array();
             if (count($query1)>0) {
                 # code...
                foreach ($query1 as $row) {
                echo "<option value='".$row["id_type"]."'>".$row["nom_type"]."</option>";
            }
         }else{
            echo "<option value=''>aucun</option>";
         }
     $this->db->close();
}



public function selectAllSortie1(){
	
	
	if (isset($_POST["date_debut"]) && isset($_POST["date_fin"]) && isset($_POST["validite1"])) {
        # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
		$validite1 = $_POST['validite1'];
		
		
		 
		
        if (!empty($date_fin) && !empty($date_debut) && isset($_POST["validite1"])) {
			
			
			
            # code...
           $query1 = $this->db->query('SELECT * from sortie where type_sortie = "'.$validite1.'" and date_sortie between "'.$date_debut.'" and "'.$date_fin.'" order by date_sortie asc')->result_array(); 
        if ($validite1 == 'TOUT') {
            # code...
          $query1 = $this->db->query('SELECT * from sortie where date_sortie between "'.$date_debut.'" and "'.$date_fin.'" order by date_sortie desc')->result_array();
        
		}
		}else{
            $query1 = $this->db->query('SELECT * from sortie order by date_sortie desc limit 200')->result_array();
        }
    }else{
			$query1 = $this->db->query('SELECT * from sortie order by date_sortie desc limit 200')->result_array();
    }

         
         $compteur = 0;
		 
		$fournisseur1 = $_POST["validite1"];
		 
      
		 
        foreach ($query1 as $row) {
            # code...
           
                echo "<tr >
                    
                    <td> ".$compteur."</td>
					<td>".$row['date_sortie']."</td>
					<td>".$row['numero']."</td>
					<td>".number_format($row['montant'],0,',',' ')."</td>
					<td>".$row['type_sortie']."</td>
					<td>".$row['vehicule']."</td>
					<td>".$this->getOperationCaisse($row['operation'])."</td>
					<td>".$this->getDestinationCaisse($row['destination'])."</td>";
					
					
					
					
					if ($validite1 == 'Reglement Fournisseur Caisse') {
						
				    $fournisseur = $this->getFournisseurCaisse($row['fournisseur']);	
						
					}
					
		if ($fournisseur1 == 'Reglement Fournisseur Article') {
						
					$fournisseur =$this->getFournisseurArticle($row['fournisseur']);	
						
					}
					
		if ($fournisseur1 == 'Reglement Fournisseur Gazoil') {
						
					$fournisseur =$this->getFournisseurGazoil($row['fournisseur']);	
						
					}
					
		if ($fournisseur1 == 'Reglement Fournisseur MIRA SA') {
						
					$fournisseur =$this->getFournisseurMatiere($row['fournisseur']);	
						
					}
					
		if ($fournisseur1 == 'Autre') {
						
					$fournisseur = $this->getFournisseurCaisse($row['fournisseur']);	
						
					}
		
					
					
				echo "	<td>".$fournisseur."</td>
					
					";
					
                    $getOperation = $this->db->query("SELECT * FROM type_entreesortie where id_type = ".$row['id_type']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_type']."</td>";
                        }
                    }
                    
                    echo"
                   
                    <td> ".$row['ordonnateur']."</td>
					
					<td>".$row['etat_dem']."</td>
					
					
                    <td>".$row['commentaire']." </td>
					
 				
                    <td>";
                 if($this->session->userdata('caisse_modification')=='true'){
                    echo"
                    <button type='button'  onclick=\"infoSortieCaisse(".$row['montant'].",'".$row['ordonnateur']."','".$row['date_sortie']."','".addslashes($row['commentaire'])."',".$row['id_type'].",".$row['id_sortie'].",'".$row['numero']."','".$row['type_sortie']."','".$row['vehicule']."','".$row['fournisseur']."','".$row['operation']."','".$row['destination']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }
                if($this->session->userdata('caisse_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='sortie' identifiant='".$row['id_sortie']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_sortie\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                
            
                  $compteur++;
       
    }
    $this->db->close();
}

public function selectAllSortie(){
	
	
	if (isset($_POST["date_debut"]) && isset($_POST["date_fin"]) && isset($_POST["validite1"])) {
        # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
		$validite1 = $_POST['validite1'];
		
		
		 
		
        if (!empty($date_fin) && !empty($date_debut) && isset($_POST["validite1"])) {
			
			
			
            # code...
           $query1 = $this->db->query('SELECT * from sortie where type_sortie = "'.$validite1.'" and date_sortie between "'.$date_debut.'" and "'.$date_fin.'" order by date_sortie asc')->result_array(); 
        if ($validite1 == 'TOUT') {
            # code...
          $query1 = $this->db->query('SELECT * from sortie where date_sortie between "'.$date_debut.'" and "'.$date_fin.'" order by date_sortie desc')->result_array();
        
		}
		}else{
            $query1 = $this->db->query('SELECT * from sortie order by date_sortie desc limit 200')->result_array();
        }
    }else{
			$query1 = $this->db->query('SELECT * from sortie order by date_sortie desc limit 200')->result_array();
    }

         
         $compteur = 0;
		  $compteur1 = 0;
		$fournisseur1 = $_POST["validite1"];
		 
      
		 
        foreach ($query1 as $row) {
        $compteur1 += $row['montant'];
           
                echo "<tr >
                    
                    <td> ".$compteur."</td>
					<td>".$row['date_sortie']."</td>
					<td>".$row['numero']."</td>
					<td>".number_format($row['montant'],0,',',' ')."</td>
					<td>".$row['type_sortie']."</td>
					<td>".$row['vehicule']."</td>
					<td>".$this->getOperationCaisse($row['operation'])."</td>
					<td>".$this->getDestinationCaisse($row['destination'])."</td>";
					
					
					
					
					if ($validite1 == 'Reglement Fournisseur Caisse') {
						
				    $fournisseur = $this->getFournisseurCaisse($row['fournisseur']);	
						
					}
					
					if ($validite1 == 'Reglement Fournisseur Article') {
						
					$fournisseur =$this->getFournisseurArticle($row['fournisseur']);	
						
					}
					
					if ($validite1 == 'Reglement Fournisseur Gazoil') {
						
					$fournisseur =$this->getFournisseurGazoil($row['fournisseur']);	
						
					}
					
					if ($validite1 == 'Reglement Fournisseur MIRA SA') {
						
					$fournisseur =$this->getFournisseurMatiere($row['fournisseur']);	
						
					}
					
					if ($validite1 == 'Autre') {
						
					$fournisseur = $this->getFournisseurCaisse($row['fournisseur']);	
						
					}
		
					
					
				echo "	<td>".$fournisseur."</td>
					
					";
					
                    $getOperation = $this->db->query("SELECT * FROM type_entreesortie where id_type = ".$row['id_type']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_type']."</td>";
                        }
                    }
                    
                    echo"
                   
                    <td> ".$row['ordonnateur']."</td>
					
					
					
					
                    <td>".$row['commentaire']." </td>
					
 				
                    <td>";
                 if($this->session->userdata('caisse_modification')=='true'){
                    echo"
                    <button type='button'  onclick=\"infoSortieCaisse(".$row['montant'].",'".$row['ordonnateur']."','".$row['date_sortie']."','".addslashes($row['commentaire'])."',".$row['id_type'].",".$row['id_sortie'].",'".$row['numero']."','".$row['type_sortie']."','".$row['vehicule']."','".$row['fournisseur']."','".$row['operation']."','".$row['destination']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }
                if($this->session->userdata('caisse_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='sortie' identifiant='".$row['id_sortie']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_sortie\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                
            
                  $compteur++;
       
    }
	
	  echo "<tr style='text-align:center; font-size: 12px; color:red;'>
             <td style='color:red;font-size: 20px;  font-weight: bold;'>TOTAUX</td>
           <td></td>
            <td></td>
             <td style='color:red;font-size: 20px;  font-weight: bold;'>".number_format($compteur1,0,',',' ')."</td>
           <td></td>
            <td></td>
           
           <td></td>
         
              <td></td>
               <td></td>
            <td></td>
           
           <td></td>
         
              <td></td>
			   <td></td>
              
           </tr>";
			
	
	
	
	
    $this->db->close();
}

public function selectAllSortie2(){
	
	
	if (isset($_POST["date_debut"]) && isset($_POST["date_fin"]) && isset($_POST["validite1"])) {
        # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
		$validite1 = $_POST['validite1'];
		
		
        if (!empty($date_fin) && !empty($date_debut) && isset($_POST["validite1"])) {
			
			

			
		$query = $this->db->query("SELECT * FROM sortie where type_sortie ='".$validite1."' and date_sortie between '".$date_debut."' and '".$date_fin."' group by numero,date_sortie,montant HAVING COUNT(*)> 1")->result_array();
         
		  if ($validite1 == 'TOUT') {
            # code...
          $query = $this->db->query("SELECT * FROM sortie where date_sortie between '".$date_debut."' and '".$date_fin."' group by numero,date_sortie,montant HAVING COUNT(*)> 1")->result_array();
       
		}
		 
		}else{
		$query = $this->db->query("SELECT * FROM sortie group by numero,date_sortie,montant HAVING COUNT(*)> 1")->result_array();
        }
        }else{
			
	    $query = $this->db->query("SELECT * FROM sortie group by numero,date_sortie,montant HAVING COUNT(*)> 1")->result_array();
         
		 }
 
      			
		if (count($query) > 0) {
		
        $compteur = 0;
		 
		$fournisseur1 = $_POST["validite1"];	

					# code...
		foreach ($query as $row) {
			
			
			
		$query1 = $this->db->query("SELECT * from sortie where numero = '".$row['numero']."' and date_sortie = '".$row['date_sortie']."' and montant = '".$row['montant']."' order by date_sortie desc ")->result_array();	 
			
		 $compteur1 = 0;	
           
		   foreach ($query1 as $row1) {
		   
                echo "<tr >
                    
                    
					<td>".$row1['date_sortie']."</td>
					<td>".$row1['numero']."</td>
					<td>".number_format($row1['montant'],0,',',' ')."</td>
					<td>".$row1['type_sortie']."</td>
					<td>".$row1['vehicule']."</td>
					<td>".$this->getOperationCaisse($row1['operation'])."</td>
					<td>".$this->getDestinationCaisse($row1['destination'])."</td>";
					
					
					
					
					if ($validite1 == 'Reglement Fournisseur Caisse') {
						
				    $fournisseur = $this->getFournisseurCaisse($row1['fournisseur']);	
						
					}
					
		if ($fournisseur1 == 'Reglement Fournisseur Article') {
						
					$fournisseur =$this->getFournisseurArticle($row1['fournisseur']);	
						
					}
					
		if ($fournisseur1 == 'Reglement Fournisseur Gazoil') {
						
					$fournisseur =$this->getFournisseurGazoil($row1['fournisseur']);	
						
					}
					
		if ($fournisseur1 == 'Reglement Fournisseur MIRA SA') {
						
					$fournisseur =$this->getFournisseurMatiere($row1['fournisseur']);	
						
					}
					
		if ($fournisseur1 == 'Autre') {
						
					$fournisseur = $this->getFournisseurCaisse($row1['fournisseur']);	
						
					}
		
					
					
				echo "	<td>".$fournisseur."</td>
					
					";
					
                    $getOperation = $this->db->query("SELECT * FROM type_entreesortie where id_type = ".$row1['id_type']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_type']."</td>";
                        }
                    }
                    
                    echo"
                   
                    <td> ".$row1['ordonnateur']."</td>
					
					
					
					
                    <td>".$row1['commentaire']." </td>
					
 				
                    <td>";
                 if($this->session->userdata('caisse_modification')=='true'){
                    echo"
                    <button type='button'  onclick=\"infoSortieCaisse(".$row1['montant'].",'".$row1['ordonnateur']."','".$row1['date_sortie']."','".addslashes($row1['commentaire'])."',".$row1['id_type'].",".$row1['id_sortie'].",'".$row1['numero']."','".$row1['type_sortie']."','".$row1['vehicule']."','".$row1['fournisseur']."','".$row1['operation']."','".$row1['destination']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }
                if($this->session->userdata('caisse_suppression')=='true'){
                    echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='sortie' identifiant='".$row1['id_sortie']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_sortie\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                
            
                  $compteur1++;
       
    }
	
	 $compteur++;
	
	}
	
	}
    $this->db->close();
}



    public function selectAllSortiePourBalance(){
         $query1 = $this->db->query(' SELECT * from sortie order by date_sortie asc')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                    $getOperation = $this->db->query("SELECT * FROM type_entreesortie where id_type = ".$row['id_type']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_type']."</td>";
                        }
                    }
                    
                    echo"

                    <td>".$row['montant']."</td>
                    <td> ".$row['ordonnateur']."</td>
                    
                    <td>".$row['date_sortie']."</td>
                    
                  </tr>

                  ";
                  $compteur++;
        }
        $this->db->close();
    }
public function getMontantSortieCaisse(){
    $query1 = $this->db->get_where('sortie')->result_array();
    $montant = 0;
    foreach ($query1 as $row) {
        # code...
        $montant = $montant + $row["montant"];
    }

    return $montant;
    $this->db->close();
}
public function getMontantEntreeCaisse(){
    $query1 = $this->db->get_where('entree')->result_array();
    $montant = 0;
    foreach ($query1 as $row) {
        # code...
        $montant = $montant + $row["montant"];
    }

    return $montant;
    $this->db->close();
}


public function getMontantSortieCaisseParJour(){
    $query1 = $this->db->query("SELECT * from sortie where date_sortie = '".date("Y/m/d")."'")->result_array();
    $montant = 0;
    foreach ($query1 as $row) {
        # code...
        $montant = $montant + $row["montant"];
    }

    return $montant;
    $this->db->close();
}

public function getMontantSortieCaisseParJourNew(){
    $query1 = $this->db->query("SELECT * from sortie where date_sortie = '".date("Y/m/d")."' and type_sortie <> 'Reglement Fournisseur Caisse'")->result_array();
    $montant = 0;
    foreach ($query1 as $row) {
        # code...
        $montant = $montant + $row["montant"];
    }

    return $montant;
    $this->db->close();
}

public function getMontantEntreeCaisseParJour(){
    $query1 = $this->db->query("SELECT * from entree where date_entree = '".date("Y/m/d")."'")->result_array();
    $montant = 0;
    foreach ($query1 as $row) {
        # code...
        $montant = $montant + $row["montant"];
    }

    return $montant;
    $this->db->close();
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
    $this->db->close();
}

public function getSoldeCaisseNew(){
 $query1 = $this->db->query("SELECT * from entree where date_entree = '".date("Y/m/d")."'")->result_array();
    $montant = 0;
	$montant1 = 0;
    foreach ($query1 as $row) {
        # code...
        $montant1 = $montant1 + $row["montant"];
    }

    $query2 = $this->db->query("SELECT * from sortie where date_sortie = '".date("Y/m/d")."' and type_sortie  <> 'Reglement Fournisseur Caisse'")->result_array();
    $montant2 = 0;
    foreach ($query2 as $row) {
        # code...
        $montant2 = $montant2 + $row["montant"];
    }
	
	$montant = $montant1 - $montant2;
	
	

    return $montant;
    $this->db->close();
}

public function addSortie(){
    $montant = preg_replace('/\s/','', $_POST["montant"]);
    $date = $_POST["date"];
    $type = $_POST["type"];
    $ordonateur =addslashes($_POST["ordonateur"]);
    $commentaire = addslashes($_POST["commentaire"]);
    $status = $_POST["status"];
	$validite =$_POST["validite"];
    $vehicule = $_POST["vehicule"];
    $fournisseur = $_POST["fournisseur"];
	$numero = $_POST["numero"];
	$operation = $_POST["operation"];
	$arrivee = $_POST["arrivee"];
	
    $id_prime = $_POST["id_prime"];
	
	

     $nom_table = "sortie";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté une sortie caisse d'un montant".$montant.", de ordonnée par  ".$ordonateur." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié une sortie caisse d'un montant".$montant.", de ordonnée par  ".$ordonateur." le ".$date_notif." à ".$heure;
   
	

   if ($status == 'insert') {
        # code...
        if ($this->getValiditeDate($date) == true) {
            # code...
            echo "Entrez une date supérieure à celle de la dernière cloture de la caisse";
        }else{
			
                   			   
				   $insertion = $this->db->query("INSERT INTO sortie value ('',".$type.",CAST('". $date."' AS DATE),".$montant.",'".$ordonateur."','".$commentaire."','".$validite."','".$vehicule."',".$fournisseur.",'".$numero."',".$operation.",".$arrivee.",'DEMANDEE','non','non',0,0)");
				   
					   				   
				   
            if ($insertion == true ) {
				
				
				    $query1 = $this->db->query("SELECT id_sortie from sortie order by id_sortie desc limit 1")->row();
				
				
				if ($validite == 'Frais Route')  {

				
				$insertionFR = $this->db->query("INSERT INTO frais_route value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".$montant.",0,'".$commentaire."',".$arrivee." ,".$query1->id_sortie." )");
	
			}
			
				if ($validite == 'Retour Frais Route')  {	

				$insertionFR = $this->db->query("INSERT INTO frais_route value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".-$montant.",0,'".$commentaire."',".$arrivee." ,".$query1->id_sortie.")");

			}
			
				if ($validite == 'Frais Divers')  {	

				$insertionFD = $this->db->query("INSERT INTO frais_divers value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."',".$query1->id_sortie.")");

			}
			
				if ($validite == 'Prime')  {	

				 $insertionPR = $this->db->query("INSERT INTO prime value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."',".$query1->id_sortie.")");

			}
			
			if ($validite == 'Commission')  {	

				 $insertionPR = $this->db->query("INSERT INTO commission value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."',".$query1->id_sortie.")");

			}
			
			
			if ($validite == 'Depannage')  {	

				 $insertionPR = $this->db->query("INSERT INTO depannage value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."',".$query1->id_sortie.")");

			}
			
			if ($validite == 'Prevision Navire')  {	

				 $insertionPR = $this->db->query("INSERT INTO prevision_navire value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."',".$query1->id_sortie.")");

			}
			
			if ($validite == 'Reglement Fournisseur Caisse')  {	
				
				$insertionRC  = $this->db->query("INSERT INTO reglement_caisse value('',".$fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."',".$query1->id_sortie.")");
               
			}
			
			if ($validite == 'Reglement Fournisseur Article')  {	
				
				$insertionRC  = $this->db->query("INSERT INTO reglement_article value('',".$fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."','RAS','RAS','RAS','RAS','RAS',".$query1->id_sortie.")");
               
			}
			
			if ($validite == 'Reglement Fournisseur Gazoil')  {	
				
				$insertionRC  = $this->db->query("INSERT INTO reglement_gazoil value('',".$fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",".$query1->id_sortie.")");
               
			}
			
			if ($validite == 'Reglement Fournisseur MIRA SA')  {	
				
				$insertionRC  = $this->db->query("INSERT INTO reglement_achat value('',".$fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."',".$query1->id_sortie.")");
               
			}
			
		         # code...
                echo "Enregistrement de la sortie réussie";
                $this->notificationAjout($nom_table,addslashes($message));
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
                   $update = $this->db->query("UPDATE sortie set  commentaire ='".$commentaire."',ordonnateur='".$ordonateur."',date_sortie = CAST('". $date."' AS DATE),montant = ".$montant.",id_type = '".$type."',type_sortie = '".$validite."',vehicule = '".$vehicule."', fournisseur = ".$fournisseur.",numero = '".$numero."',operation = ".$operation.",destination = ".$arrivee." where id_sortie=".$id_prime."");
					   
            if ($update == true ) {
     			
			if ($validite == 'Frais Route') {
				
				$query = $this->db->query("SELECT * from frais_route WHERE id_caisse = ".$id_prime." ")->row();

				 
			if (count($query) >0) {
				
				
		    $insertionFR = $this->db->query("UPDATE frais_route set id_operation =".$operation.",code_camion='".$vehicule."',date_frais = CAST('". $date."' AS DATE),montant = ".$montant.", commentaire='".$commentaire."' where id_caisse=".$id_prime."");
		
			}else {
				
			$insertionFR = $this->db->query("INSERT INTO frais_route value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".$montant.",0,'".$commentaire."',".$arrivee.",".$id_prime.")");

			}	
			
			}
			
			if ($validite == 'Frais Divers') {

			$query = $this->db->query("SELECT * from frais_divers WHERE id_caisse = ".$id_prime."")->row();;
				 
			if (count($query) >0) { 
			
            $insertionFD = $this->db->query("UPDATE frais_divers set id_operation =".$operation.",code_camion='".$vehicule."',date_frais = CAST('". $date."' AS DATE),montant = ".$montant.", commentaire='".$commentaire."' where id_caisse=".$id_prime."");
		
			}else {
				
			$insertionFD = $this->db->query("INSERT INTO frais_divers value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."',".$id_prime.")");

			}	
			
			}
			
			if ($validite == 'Prime') {

			$query = $this->db->query("SELECT * from prime WHERE id_caisse = ".$id_prime."")->row();;
				 
			if (count($query) >0) {
				
			$insertionPR = $this->db->query("UPDATE prime set  id_operation =".$operation.",code_camion='".$vehicule."',date_prime = CAST('". $date."' AS DATE),montant = ".$montant.",libelle = '".$commentaire."' where id_caisse =".$id_prime."");


			}else {
				
			 $insertionPR = $this->db->query("INSERT INTO prime value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."',".$id_prime.")");
			
			}	
			
			}
			
			if ($validite == 'Commission') {

			$query = $this->db->query("SELECT * from commission WHERE id_caisse = ".$id_prime."")->row();;
				 
			if (count($query) >0) {
				
			$insertionCOM = $this->db->query("UPDATE commission set  id_operation =".$operation.",code_camion='".$vehicule."',date_prime = CAST('". $date."' AS DATE),montant = ".$montant.",libelle = '".$commentaire."' where id_caisse =".$id_prime."");
	

			}else {
				
			 $insertionCOM = $this->db->query("INSERT INTO commission value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."', ".$id_prime.")");
			}	
			
			}
			
			if ($validite == 'Reglement Fournisseur Caisse') {

			$query = $this->db->query("SELECT * from reglement_caisse WHERE id_caisse = ".$id_prime."")->row();;
				 
			if (count($query) >0) {
				
			$insertionFC = $this->db->query("UPDATE reglement_caisse set  id_fournisseur =".$fournisseur.",numero='".$numero."',date_reg = CAST('". $date."' AS DATE),montant = ".$montant.",libelle = '".$commentaire."' where id_caisse=".$id_prime."");
	

			}else {
				
			 $insertionFC  = $this->db->query("INSERT INTO reglement_caisse value('',".$fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."',".$id_prime.")");
               
			
			}
            }
		
			if ($validite == 'Reglement Fournisseur Article') {

			$query = $this->db->query("SELECT * from reglement_article WHERE id_caisse = ".$id_prime."")->row();;
				 
			//  if ($query1 == true ) {
			
			 if (count($query) >0) {
				
			//	echo count($query);
				
			$insertionFA = $this->db->query("UPDATE reglement_article set  id_fournisseur =".$fournisseur.",numero='".$numero."',date_reg = CAST('". $date."' AS DATE),montant = ".$montant.",libelle = '".$commentaire."' where id_caisse=".$id_prime."");
		

			}else {
				
			$insertionFA  = $this->db->query("INSERT INTO reglement_article value('',".$fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."','RAS','RAS',0,0,'RAS',".$id_prime.")");
                 
			
			}
        }
		
		if ($validite == 'Reglement Fournisseur Gazoil') {

			$query = $this->db->query("SELECT * from reglement_gazoil WHERE id_caisse = ".$id_prime."")->row();;
				 
			if (count($query) >0) {
				
				$insertionFG = $this->db->query("UPDATE reglement_gazoil set  id_fournisseur =".$fournisseur.",numero='".$numero."',date_reg = CAST('". $date."' AS DATE),montant = ".$montant.",libelle = '".$commentaire."' where id_caisse=".$id_prime."");
		

			}else {
				
			$insertionFG  = $this->db->query("INSERT INTO reglement_gazoil value('',".$fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",".$id_prime." )");
                      
			
			}
        }
		
		if ($validite == 'Reglement Fournisseur Matiere Premiere') {

			$query = $this->db->query("SELECT * from reglement_achat WHERE id_caisse = ".$id_prime."")->row();;
				 
			if (count($query) >0) {
				
				$insertionFMP = $this->db->query("UPDATE reglement_achat set  id_client =".$fournisseur.",numero='".$numero."',date_reg = CAST('". $date."' AS DATE),montant = ".$montant.",libelle = '".$commentaire."' where id_caisse=".$id_prime."");
		

			}else {
				
				$insertionFMP  = $this->db->query("INSERT INTO reglement_achat value('',".$fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."')");
                       
			
			}
        }
				
				
                echo "Modification de la sortie réussie";
                $this->notificationAjout($nom_table,addslashes($message2));
				
				
				
				
				
				
            }else{
                echo "Erreur lors de la modification";
            }
			
			
		 }
    }else{
        echo "Erreur veuillez contacter l'administrateur";
    }
    $this->db->close();
}

public function addSortie1(){
    $montant = preg_replace('/\s/','', $_POST["montant"]);
    $date = $_POST["date"];
    $type = $_POST["type"];
    $ordonateur =addslashes($_POST["ordonateur"]);
    $commentaire = addslashes($_POST["commentaire"]);
    $status = $_POST["status"];
	$validite =$_POST["validite"];
    $vehicule = $_POST["vehicule"];
    $fournisseur = $_POST["fournisseur"];
	$numero = $_POST["numero"];
	$operation = $_POST["operation"];
	$arrivee = $_POST["arrivee"];
	$etat_demande = $_POST['etat_demande'];
    $id_prime = $_POST["id_prime"];
	
	$rj = $_POST['rj'];
	$rj1 = $_POST['rj1'];

     $nom_table = "sortie";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté une sortie caisse d'un montant".$montant.", de ordonnée par  ".$ordonateur." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié une sortie caisse d'un montant".$montant.", de ordonnée par  ".$ordonateur." le ".$date_notif." à ".$heure;
   
	if ($rj == 'oui') {
			  $etat_demande = 'VALIDEE';
			}elseif ($rj1 == 'oui'){
             $etat_demande = 'VALIDEE';
            }  else  {
           $etat_demande = 'DEMANDEE';
            }


   if ($status == 'insert') {
        # code...
        if ($this->getValiditeDate($date) == true) {
            # code...
            echo "Entrez une date supérieure à celle de la dernière cloture de la caisse";
        }else{
			
                   			   
				   $insertion = $this->db->query("INSERT INTO sortie value ('',".$type.",CAST('". $date."' AS DATE),".$montant.",'".$ordonateur."','".$commentaire."','".$validite."','".$vehicule."',".$fournisseur.",'".$numero."',".$operation.",".$arrivee.",'".$etat_demande."','".$rj."','".$rj1."')");
				   
					   				   
				   
            if ($insertion == true ) {
				
				
				    $query1 = $this->db->query("SELECT id_sortie from sortie order by id_sortie desc limit 1")->row();
				
				
				if ($validite == 'Frais Route')  {

				
				$insertionFR = $this->db->query("INSERT INTO frais_route value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".$montant.",0,'".$commentaire."',".$arrivee." ,".$query1->id_sortie." )");
	
			}
			
				if ($validite == 'Retour Frais Route')  {	

				$insertionFR = $this->db->query("INSERT INTO frais_route value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".-$montant.",0,'".$commentaire."',".$arrivee." ,".$query1->id_sortie.")");

			}
			
				if ($validite == 'Frais Divers')  {	

				$insertionFD = $this->db->query("INSERT INTO frais_divers value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."',".$query1->id_sortie.")");

			}
			
				if ($validite == 'Prime')  {	

				 $insertionPR = $this->db->query("INSERT INTO prime value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."',".$query1->id_sortie.")");

			}
			
			if ($validite == 'Commission')  {	

				 $insertionPR = $this->db->query("INSERT INTO commission value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."',".$query1->id_sortie.")");

			}
			
			
			if ($validite == 'Depannage')  {	

				 $insertionPR = $this->db->query("INSERT INTO depannage value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."',".$query1->id_sortie.")");

			}
			
			if ($validite == 'Prevision Navire')  {	

				 $insertionPR = $this->db->query("INSERT INTO prevision_navire value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."',".$query1->id_sortie.")");

			}
			
				if ($validite == 'Reglement Fournisseur Caisse')  {	
				
				$insertionRC  = $this->db->query("INSERT INTO reglement_caisse value('',".$fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."',".$query1->id_sortie.")");
               
			}
			
			if ($validite == 'Reglement Fournisseur Article')  {	
				
				$insertionRC  = $this->db->query("INSERT INTO reglement_article value('',".$fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."','RAS','RAS','RAS','RAS','RAS',".$query1->id_sortie.")");
               
			}
			
			if ($validite == 'Reglement Fournisseur Gazoil')  {	
				
				$insertionRC  = $this->db->query("INSERT INTO reglement_gazoil value('',".$fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",".$query1->id_sortie.")");
               
			}
			
			if ($validite == 'Reglement Fournisseur MIRA SA')  {	
				
				$insertionRC  = $this->db->query("INSERT INTO reglement_achat value('',".$fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."',".$query1->id_sortie.")");
               
			}
			
		         # code...
                echo "Enregistrement de la sortie réussie";
                $this->notificationAjout($nom_table,addslashes($message));
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
                   $update = $this->db->query("UPDATE sortie set  commentaire ='".$commentaire."',ordonnateur='".$ordonateur."',date_sortie = CAST('". $date."' AS DATE),montant = ".$montant.",id_type = '".$type."',type_sortie = '".$validite."',vehicule = '".$vehicule."', fournisseur = ".$fournisseur.",numero = '".$numero."',operation = ".$operation.",destination = ".$arrivee.", etat_dem = '".$etat_demande."',rj = '".$rj."',rj1 = '".$rj1."' where id_sortie=".$id_prime."");
					   
            if ($update == true ) {
     			
			if ($validite == 'Frais Route') {
				
				$query = $this->db->query("SELECT * from frais_route WHERE id_caisse = ".$id_prime." ")->row();

				 
			if (count($query) >0) {
				
				
		    $insertionFR = $this->db->query("UPDATE frais_route set id_operation =".$operation.",code_camion='".$vehicule."',date_frais = CAST('". $date."' AS DATE),montant = ".$montant.", commentaire='".$commentaire."' where id_caisse=".$id_prime."");
		
			}else {
				
			$insertionFR = $this->db->query("INSERT INTO frais_route value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".$montant.",0,'".$commentaire."',".$arrivee.",".$id_prime.")");

			}	
			
			}
			
			if ($validite == 'Frais Divers') {

			$query = $this->db->query("SELECT * from frais_divers WHERE id_caisse = ".$id_prime."")->row();;
				 
			if (count($query) >0) { 
			
            $insertionFD = $this->db->query("UPDATE frais_divers set id_operation =".$operation.",code_camion='".$vehicule."',date_frais = CAST('". $date."' AS DATE),montant = ".$montant.", commentaire='".$commentaire."' where id_caisse=".$id_prime."");
		
			}else {
				
			$insertionFD = $this->db->query("INSERT INTO frais_divers value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."',".$id_prime.")");

			}	
			
			}
			
			if ($validite == 'Prime') {

			$query = $this->db->query("SELECT * from prime WHERE id_caisse = ".$id_prime."")->row();;
				 
			if (count($query) >0) {
				
			$insertionPR = $this->db->query("UPDATE prime set  id_operation =".$operation.",code_camion='".$vehicule."',date_prime = CAST('". $date."' AS DATE),montant = ".$montant.",libelle = '".$commentaire."' where id_caisse=".$id_prime."");


			}else {
				
			 $insertionPR = $this->db->query("INSERT INTO prime value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."',".$id_prime.")");
			
			}	
			
			}
			
			if ($validite == 'Commission') {

			$query = $this->db->query("SELECT * from commission WHERE id_operation = ".$operation." and code_camion = '".$vehicule."' and date_prime = CAST('". $date."' AS DATE) and montant = ".$montant.", ".$id_prime."")->row();;
				 
			if (count($query) >0) {
				
			$insertionCOM = $this->db->query("UPDATE commission set  id_operation =".$id_operation.",code_camion='".$vehicule."',date_prime = CAST('". $date."' AS DATE),montant = ".$montant.",libelle = '".$commentaire."' where id_caisse=".$id_prime."");
	

			}else {
				
			 $insertionCOM = $this->db->query("INSERT INTO commission value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."', ".$id_prime.")");
			}	
			
			}
			
			if ($validite == 'Reglement Fournisseur Caisse') {

			$query = $this->db->query("SELECT * from reglement_caisse WHERE id_caisse = ".$id_prime."")->row();;
				 
			if (count($query) >0) {
				
			$insertionFC = $this->db->query("UPDATE reglement_caisse set  id_fournisseur =".$fournisseur.",numero='".$numero."',date_reg = CAST('". $date."' AS DATE),montant = ".$montant.",libelle = '".$commentaire."' where id_caisse=".$id_prime."");
	

			}else {
				
			 $insertionFC  = $this->db->query("INSERT INTO reglement_caisse value('',".$fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."',".$id_prime.")");
               
			
			}
            }
		
			if ($validite == 'Reglement Fournisseur Article') {

			$query = $this->db->query("SELECT * from reglement_article WHERE id_caisse = ".$id_prime."")->row();;
				 
			//  if ($query1 == true ) {
			
			 if (count($query) >0) {
				
			//	echo count($query);
				
			$insertionFA = $this->db->query("UPDATE reglement_article set  id_fournisseur =".$fournisseur.",numero='".$numero."',date_reg = CAST('". $date."' AS DATE),montant = ".$montant.",libelle = '".$commentaire."' where id_caisse=".$id_prime."");
		

			}else {
				
			$insertionFA  = $this->db->query("INSERT INTO reglement_article value('',".$fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."','RAS','RAS',0,0,'RAS',".$id_prime.")");
                 
			
			}
        }
		
		if ($validite == 'Reglement Fournisseur Gazoil') {

			$query = $this->db->query("SELECT * from reglement_gazoil WHERE id_caisse = ".$id_prime."")->row();;
				 
			if (count($query) >0) {
				
				$insertionFG = $this->db->query("UPDATE reglement_gazoil set  id_fournisseur =".$fournisseur.",numero='".$numero."',date_reg = CAST('". $date."' AS DATE),montant = ".$montant.",libelle = '".$commentaire."' where id_caisse=".$id_prime."");
		

			}else {
				
			$insertionFG  = $this->db->query("INSERT INTO reglement_gazoil value('',".$fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",".$id_prime." )");
                      
			
			}
        }
		
		if ($validite == 'Reglement Fournisseur Matiere Premiere') {

			$query = $this->db->query("SELECT * from reglement_achat WHERE id_caisse = ".$id_prime."")->row();;
				 
			if (count($query) >0) {
				
				$insertionFMP = $this->db->query("UPDATE reglement_achat set  id_client =".$fournisseur.",numero='".$numero."',date_reg = CAST('". $date."' AS DATE),montant = ".$montant.",libelle = '".$commentaire."' where id_caisse=".$id_prime."");
		

			}else {
				
				$insertionFMP  = $this->db->query("INSERT INTO reglement_achat value('',".$fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".$montant.",'".$commentaire."')");
                       
			
			}
        }
				
				
                echo "Modification de la sortie réussie";
                $this->notificationAjout($nom_table,addslashes($message2));
				
				
				
				
				
				
            }else{
                echo "Erreur lors de la modification";
            }
			
			
		 }
    }else{
        echo "Erreur veuillez contacter l'administrateur";
    }
    $this->db->close();
}

 public function leSelectEtatCodeCamion(){
	 

	 
        $query = $this->db->query("SELECT * from tracteur where rj = 'NON' order by code asc")->result_array();
		
        if (count($query) >0) {
			echo "<option value=''></option>";
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["code"]."' id_type = '".$row["id_type_camion"]."'>".$row["code"]."</option>";
            }
        }else{
            
        }
        $query1 = $this->db->query("SELECT * from camion_benne where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
			
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
         $query1 = $this->db->query("SELECT * from engin where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
			
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
        
         $query1 = $this->db->query("SELECT * from vraquier where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
			
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
        $query1 = $this->db->query("SELECT * from voitureservice where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
			
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }

        $this->db->close();
   // }
  
}

public function leSelectEtatCodeCamionCaisse(){
	 

	 
        $query = $this->db->query("SELECT * from tracteur where rj = 'NON' order by code asc")->result_array();
		
        if (count($query) >0) {
			
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["code"]."' id_type = '".$row["id_type_camion"]."'>".$row["code"]."</option>";
            }
        }else{
            
        }
        $query1 = $this->db->query("SELECT * from camion_benne where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
			
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
         $query1 = $this->db->query("SELECT * from engin where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
			
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
        
         $query1 = $this->db->query("SELECT * from vraquier where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
			
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
        $query1 = $this->db->query("SELECT * from voitureservice where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
			
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }

        $this->db->close();
   // }
  
}

	
	
	public function leSelectFournisseurCaisse1(){
  
	  $validite = $_POST["validite"];
	  
	 
	 
	 if (($validite=='Autre') or ($validite=='Frais Route')  or ($validite=='Frais Divers') or ($validite=='Prime') or ($validite=='Commission')or ($validite=='Prevision Navire') or ($validite=='Depannage')) { 
  
        $query = $this->db->query("select * from fournisseur_caisse order by nom")->result_array();
        if (count($query) >0) {
			
		
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_fournisseur"]."'>".$row["nom"]."</option>";
            }
        }else{

        }
		}
	  
	  if ($validite=='Reglement Fournisseur Caisse')  { 
  
        $query = $this->db->query("select * from fournisseur_caisse order by nom")->result_array();
        if (count($query) >0) {
			
		
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_fournisseur"]."'>".$row["nom"]."</option>";
            }
        }else{

        }
		}
		
		 if ($validite=='Reglement Fournisseur Article')  { 
  
        $query = $this->db->query("select * from fournisseur_article order by nom")->result_array();
        if (count($query) >0) {
			
		
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_fournisseur"]."'>".$row["nom"]."</option>";
            }
        }else{

        }
		}
		
		if ($validite=='Reglement Fournisseur Gazoil')  { 
  
        $query = $this->db->query("select * from fournisseur_gazoil order by nom")->result_array();
        if (count($query) >0) {
			
		
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_fournisseur"]."'>".$row["nom"]."</option>";
            }
        }else{

        }
		}
		
		
		
			if ($validite=='Reglement Fournisseur MIRA SA')  { 
  
        $query = $this->db->query("select * from fournisseur_matiere order by nom")->result_array();
        if (count($query) >0) {
			
		
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_fournisseur"]."'>".$row["nom"]."</option>";
            }
        }else{

        }
		}
		
        $this->db->close();
   // }

}


public function leSelectFournisseurCaisseDem(){
  
	  $validite = $_POST["validite"];
	  
	 
	 
	 if (($validite=='Autre') or ($validite=='Frais Route')  or ($validite=='Frais Divers') or ($validite=='Prime') or ($validite=='Commission')or ($validite=='Prevision Navire') or ($validite=='Depannage')) { 
  
        $query = $this->db->query("select * from fournisseur_caisse order by nom")->result_array();
        if (count($query) >0) {
			
		
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_fournisseur"]."'>".$row["nom"]."</option>";
            }
        }else{

        }
		}
	  
	  if (($validite=='Reglement Fournisseur Caisse') or ($validite=='Retour Fournisseur'))   { 
  
        $query = $this->db->query("select * from fournisseur_caisse order by nom")->result_array();
        if (count($query) >0) {
			
		
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_fournisseur"]."'>".$row["nom"]."</option>";
            }
        }else{

        }
		}
		
		 if ($validite=='Reglement Fournisseur Article')  { 
  
        $query = $this->db->query("select * from fournisseur_article order by nom")->result_array();
        if (count($query) >0) {
			
		
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_fournisseur"]."'>".$row["nom"]."</option>";
            }
        }else{

        }
		}
		
		if ($validite=='Reglement Fournisseur Gazoil')  { 
  
        $query = $this->db->query("select * from fournisseur_gazoil order by nom")->result_array();
        if (count($query) >0) {
			
		
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_fournisseur"]."'>".$row["nom"]."</option>";
            }
        }else{

        }
		}
		
		
		
			if ($validite=='Reglement Fournisseur MIRA SA')  { 
  
        $query = $this->db->query("select * from fournisseur_matiere order by nom")->result_array();
        if (count($query) >0) {
			
		
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_fournisseur"]."'>".$row["nom"]."</option>";
            }
        }else{

        }
		}
		
        $this->db->close();
   // }

}



public function leSelectOperationCaisseDem(){
  
	  $validite = $_POST["validite"];
	  
	 
	 
	 if (($validite=='Autre') || ($validite=='Frais Route')  || ($validite=='Frais Divers') || ($validite=='Prime') || ($validite=='Commission') || ($validite=='Prevision Navire') || ($validite=='Depannage')) { 
  
     $query = $this->db->query("SELECT * from operation WHERE id_operation = 1833")->result_array();
        if (count($query) >0) {
            # code...
			
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_operation"]."'>".$row["nom_op"]."</option>";
            }
        }else{

        }
	
       
   
	
        $query = $this->db->query("SELECT * from operation WHERE id_operation <> 1833 ORDER BY date_creation DESC")->result_array();
        if (count($query) >0) {
            # code...
			
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_operation"]."'>".$row["nom_op"]."</option>";
            }
        }else{

        }
		
		}
	  
	  if (($validite=='Reglement Fournisseur Caisse') || ($validite=='Retour Fournisseur') ){ 
  
        $query = $this->db->query("select * from operation order by nom_op")->result_array();
        if (count($query) >0) {
			
		
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_operation"]."'>".$row["nom_op"]."</option>";
            }
        }else{

        }
		}
		
		 if ($validite=='Reglement Fournisseur Article')  { 
  
        $query = $this->db->query("select * from operation order by nom_op")->result_array();
        if (count($query) >0) {
			
		
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_operation"]."'>".$row["nom_op"]."</option>";
            }
        }else{

        }
		}
		
		if ($validite=='Reglement Fournisseur Gazoil')  { 
  
        $query = $this->db->query("select * from operation order by nom_op")->result_array();
        if (count($query) >0) {
			
		
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_operation"]."'>".$row["nom_op"]."</option>";
            }
        }else{

        }
		}
		
		
		
			if ($validite=='Reglement Fournisseur MIRA SA')  { 
  
       $query = $this->db->query("select * from operation order by nom_op")->result_array();
        if (count($query) >0) {
			
		
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_operation"]."'>".$row["nom_op"]."</option>";
            }
        }else{

        }
		}

       
   
	
	
	   $this->db->close();

}
public function leSelectDestinationCaisseDem(){
  
	  $validite = $_POST["validite"];
	  
	 
	 
	 if (($validite=='Autre') or ($validite=='Frais Route')  or ($validite=='Frais Divers') or ($validite=='Prime') or ($validite=='Commission')or ($validite=='Prevision Navire') or ($validite=='Depannage')) { 
  
        $query = $this->db->query("select * from distance_littrage order by distance")->result_array();
        if (count($query) >0) {
			
		
            # code...
            foreach ($query as $row) {
                # code...
             echo "<option value='".$row["id_distance"]."'>".$row["distance"]."</option>";
            }
        }else{

        }
		}
	  
	  if (($validite=='Reglement Fournisseur Caisse') or ($validite=='Retour Fournisseur') )  { 
  
       $query = $this->db->query("select * from distance_littrage order by distance")->result_array();
        if (count($query) >0) {
			
		
            # code...
            foreach ($query as $row) {
                # code...
              echo "<option value='".$row["id_distance"]."'>".$row["distance"]."</option>";
            }
        }else{

        }
		}
		
		 if ($validite=='Reglement Fournisseur Article')  { 
  
       $query = $this->db->query("select * from distance_littrage order by distance")->result_array();
        if (count($query) >0) {
			
		
            # code...
            foreach ($query as $row) {
                # code...
               echo "<option value='".$row["id_distance"]."'>".$row["distance"]."</option>";
            }
        }else{

        }
		}
		
		if ($validite=='Reglement Fournisseur Gazoil')  { 
  
        $query = $this->db->query("select * from distance_littrage order by distance")->result_array();
        if (count($query) >0) {
			
		
            # code...
            foreach ($query as $row) {
                # code...
               echo "<option value='".$row["id_distance"]."'>".$row["distance"]."</option>";
            }
        }else{

        }
		}
		
		
		
			if ($validite=='Reglement Fournisseur MIRA SA')  { 
  
      $query = $this->db->query("select * from distance_littrage order by distance")->result_array();
        if (count($query) >0) {
			
		
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_distance"]."'>".$row["distance"]."</option>";
            }
        }else{

        }
		}
		
        $this->db->close();
   // }

}


public function leSelectVehiculeCaisseDem(){
  
	  $validite = $_POST["validite"];
	  
	 
	 
	 if (($validite=='Autre') or ($validite=='Frais Route')  or ($validite=='Frais Divers') or ($validite=='Prime') or ($validite=='Commission')or ($validite=='Prevision Navire') or ($validite=='Depannage')) { 
  
      $query = $this->db->query("SELECT * from tracteur where rj = 'NON' order by code asc")->result_array();
		
        if (count($query) >0) {
			echo "<option value=''></option>";
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["code"]."' id_type = '".$row["id_type_camion"]."'>".$row["code"]."</option>";
            }
        }else{
            
        }
        $query1 = $this->db->query("SELECT * from camion_benne where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
			
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
         $query1 = $this->db->query("SELECT * from engin where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
			
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
        
         $query1 = $this->db->query("SELECT * from vraquier where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
			
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
        $query1 = $this->db->query("SELECT * from voitureservice where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
			
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
		}
	  
	  if (($validite=='Reglement Fournisseur Caisse') or ($validite=='Retour Fournisseur') ) { 
  
     $query = $this->db->query("SELECT * from tracteur where rj = 'NON' order by code asc")->result_array();
		
        if (count($query) >0) {
			echo "<option value=''></option>";
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["code"]."' id_type = '".$row["id_type_camion"]."'>".$row["code"]."</option>";
            }
        }else{
            
        }
        $query1 = $this->db->query("SELECT * from camion_benne where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
			
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
         $query1 = $this->db->query("SELECT * from engin where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
			
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
        
         $query1 = $this->db->query("SELECT * from vraquier where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
			
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
        $query1 = $this->db->query("SELECT * from voitureservice where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
			
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
		}
		
		 if ($validite=='Reglement Fournisseur Article')  { 
  
     $query = $this->db->query("SELECT * from tracteur where rj = 'NON' order by code asc")->result_array();
		
        if (count($query) >0) {
			echo "<option value=''></option>";
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["code"]."' id_type = '".$row["id_type_camion"]."'>".$row["code"]."</option>";
            }
        }else{
            
        }
        $query1 = $this->db->query("SELECT * from camion_benne where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
			
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
         $query1 = $this->db->query("SELECT * from engin where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
			
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
        
         $query1 = $this->db->query("SELECT * from vraquier where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
			
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
        $query1 = $this->db->query("SELECT * from voitureservice where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
			
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
		}
		
		
		
			if ($validite=='Reglement Fournisseur MIRA SA')  { 
  
     $query = $this->db->query("SELECT * from tracteur where rj = 'NON' order by code asc")->result_array();
		
        if (count($query) >0) {
			echo "<option value=''></option>";
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["code"]."' id_type = '".$row["id_type_camion"]."'>".$row["code"]."</option>";
            }
        }else{
            
        }
        $query1 = $this->db->query("SELECT * from camion_benne where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
			
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
         $query1 = $this->db->query("SELECT * from engin where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
			
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
        
         $query1 = $this->db->query("SELECT * from vraquier where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
			
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
        $query1 = $this->db->query("SELECT * from voitureservice where rj = 'NON' order by code asc")->result_array();
        if (count($query1) >0) {
			
            # code...
            foreach ($query1 as $row1) {
                # code...
                echo "<option value='".$row1["code"]."' id_type = '".$row["id_type_camion"]."'>".$row1["code"]."</option>";
            }
        }else{
            
        }
		}
		
        $this->db->close();
   // }

}



public function leSelectFournisseurCaisse2(){
 	
  
        $query = $this->db->query("select * from fournisseur_caisse order by nom")->result_array();
        if (count($query) >0) {
			
		
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_fournisseur"]."'>".$row["nom"]."</option>";
            }
        }else{

        }
		
		
        $this->db->close();
   // }

}




public function leSelectOperation(){
	
	   $query = $this->db->query("SELECT * from operation WHERE id_operation = 1833")->result_array();
        if (count($query) >0) {
            # code...
			
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_operation"]."'>".$row["nom_op"]."</option>";
            }
        }else{

        }
	
       
   
	
        $query = $this->db->query("SELECT * from operation WHERE id_operation <> 1833 ORDER BY nom_op ASC")->result_array();
        if (count($query) >0) {
            # code...
			
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_operation"]."'>".$row["nom_op"]."</option>";
            }
        }else{

        }

        $this->db->close();
    }
	
	
	public function leSelectOperationSortieCaisse(){
	
	   $query = $this->db->query("SELECT * from operation WHERE id_operation = 1833")->result_array();
        if (count($query) >0) {
            # code...
			
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_operation"]."'>".$row["nom_op"]."</option>";
            }
        }else{

        }
	
       
   
	
        $query = $this->db->query("SELECT * from operation WHERE id_operation <> 1833 ORDER BY date_creation DESC")->result_array();
        if (count($query) >0) {
            # code...
			
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_operation"]."'>".$row["nom_op"]."</option>";
            }
        }else{

        }

        $this->db->close();
    }


public function getDestinationParCodeCamion2(){
       $id_type_camion = $_POST["id_type_camion"];
        $query = $this->db->query("SELECT distinct distance,id_distance from distance_littrage order by distance")->result_array();

        if (count($query) > 0) {
          # code...
		//  echo "<option value=''></option>";
          foreach ($query as $row) {
            # code...
            echo "<option id_distance='".$row['id_distance']."' value='".$row['id_distance']."'>".$row['distance']."</option>";
          }
        }else{
          echo "<option>Aucune</option>";
        }

        $this->db->close();
    }
	
	
public function getDestinationParCodeCamion2D(){
       
        $query = $this->db->query("SELECT distinct distance,id_distance from distance_littrage order by distance")->result_array();

        if (count($query) > 0) {
          # code...
		//  echo "<option value=''></option>";
          foreach ($query as $row) {
            # code...
            echo "<option id_distance='".$row['id_distance']."' value='".$row['id_distance']."'>".$row['distance']."</option>";
          }
        }else{
          echo "<option>Aucune</option>";
        }

        $this->db->close();
    }

public function selectAllEntree(){
	
	
	if (isset($_POST["date_debut"]) && isset($_POST["date_fin"]) && isset($_POST["validite1"])) {
        # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
		$validite1 = $_POST['validite1'];
		
		
        if (!empty($date_fin) && !empty($date_debut) && isset($_POST["validite1"])) {
            # code...
       //    $query1 = $this->db->query('SELECT * from entree where type_sortie = "'.$validite1.'" and date_entree between "'.$date_debut.'" and "'.$date_fin.'" order by date_entree asc')->result_array(); 
        if ($validite1 == 'TOUT') {
            # code...
          $query1 = $this->db->query('SELECT * from entree where date_entree between "'.$date_debut.'" and "'.$date_fin.'" order by date_entree desc')->result_array();
        
		}else{
			
			  $query1 = $this->db->query('SELECT * from entree where id_type = '.$validite1.' and date_entree between "'.$date_debut.'" and "'.$date_fin.'" order by date_entree asc')->result_array(); 
      
		}
		
		}else{
            $query1 = $this->db->query('SELECT * from entree order by date_entree desc limit 300')->result_array();
        }
    }else{
			$query1 = $this->db->query('SELECT * from entree order by date_entree desc limit 300')->result_array();
    }
	
         
         $compteur = 0;
 $compteur1 = 0;
         $getClotureCaisse = $this->db->query("SELECT * from cloture_caisse where cloture=1 order by date_cloture desc limit 1")->row();
        foreach ($query1 as $row) {
            $compteur1 = $compteur1 + $row['numero'];
            if (count($getClotureCaisse)>0) {
                # code...
                if ($getClotureCaisse->date_cloture >= $row['date_entree']) {
                    # code...
                }else{
                              echo "<tr>
                    
                    <td> ".$compteur."</td>";

                    $getOperation = $this->db->query("SELECT * FROM type_entreesortie where id_type = ".$row['id_type']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_type']."</td>";
                        }
                    }
                    
                    echo"
					<td> ".$row['numero']."</td>
                    <td>".number_format($row['montant'],0,',',' ')."</td>
                    <td> ".$row['ordonnateur']."</td>
                    <td>".$row['commentaire']." </td>
                    
                    <td>".$row['date_entree']."</td>
                    <td>";
                    if($this->session->userdata('caisse_modification')=='true'){
                        echo"
                    <button type='button'  onclick=\"infoSortieCaisse('".$row['montant']."','".$row['ordonnateur']."','".$row['date_entree']."','".$row['commentaire']."','".$row['id_type']."',".$row['id_entree'].",'".$row['numero']."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }
                if($this->session->userdata('caisse_suppression')=='true'){
                  echo" <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='entree' identifiant='".$row['id_entree']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_entree\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                }
            }
  
                  $compteur++;
        }
		
		
		  echo "<tr style='text-align:center; font-size: 12px; color:red;'>
             <td style='color:red;font-size: 20px;  font-weight: bold;'>TOTAUX</td>
           <td></td>
            <td></td>
             <td style='color:red;font-size: 20px;  font-weight: bold;'>".number_format($compteur1,0,',',' ')."</td>
           <td></td>
            <td></td>
           
           <td></td>
         
              <td></td>
         
              
           </tr>";
			
		
		
		
		

        $this->db->close();
    }
    public function selectAllEntreePourBalance(){
         $query1 = $this->db->query('SELECT * from entree order by date_entree asc')->result_array();
         $compteur = 0;
        foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    <td> ".$compteur."</td>";

                    $getOperation = $this->db->query("SELECT * FROM type_entreesortie where id_type = ".$row['id_type']."")->result_array();

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

        $this->db->close();
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

    $this->db->close();
}
public function addEntree(){
    $montant =preg_replace('/\s/','', $_POST["montant"]);
	$numero =preg_replace('/\s/','', $_POST["numero"]);
    $date = $_POST["date"];
    $type = $_POST["type"];
    $ordonateur =addslashes($_POST["ordonateur"]);
    $commentaire = addslashes($_POST["commentaire"]);
    $status = $_POST["status"];
    $id_prime = $_POST["id_prime"];
	
	$camion = $_POST["camion"];
	
	$validite = $_POST["validite"];
	
	$vehicule = $_POST["vehicule"];
  
	$operation = $_POST["operation"];
	
	$arrivee = $_POST["arrivee"];
	
	$fournisseur = $_POST["fournisseur"];

    $nom_table = "entree";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté une entrée caisse d'un montant".$montant.", de ordonnée par  ".$ordonateur." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié une entrée caisse d'un montant".$montant.", de ordonnée par  ".$ordonateur." le ".$date_notif." à ".$heure;
    if ($status == 'insert') {
        # code...
        if ($this->getValiditeDate($date) == true) {
            # code...
            echo "Entrez une date supérieure à celle de la dernière cloture de la caisse";
        }else{
           $insertion = $this->db->query("INSERT INTO entree value ('',".$type.",CAST('". $date."' AS DATE),".$montant.",'".$ordonateur."','".$commentaire."',".$numero.")");
            
		  // $insertionSR = $this->db->query("INSERT INTO sortie value ('',".$type.",CAST('". $date."' AS DATE),".$montant.",'".$ordonateur."','".$commentaire."','".$validite."','".$vehicule."',".$fournisseur.",'".$numero."',".$operation.",".$arrivee.")");
				 	
			
			if ($camion == 12)  {
				
			    $insertionSR = $this->db->query("INSERT INTO sortie value ('',".$type.",CAST('". $date."' AS DATE),".-$montant.",'".$ordonateur."','".$commentaire."','".$validite."','".$vehicule."',".$fournisseur.",'".$numero."',".$operation.",".$arrivee.",'DEMANDEE','non','non')");
		
		      $query1 = $this->db->query("SELECT id_sortie from sortie order by id_sortie desc limit 1")->row();
		
				
			  if ($validite == 'Frais Route')  {

				
				
				$insertionFR = $this->db->query("INSERT INTO frais_route value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".-$montant.",0,'".$commentaire."',".$arrivee." ,".$query1->id_sortie." )");
	
			  }
			
				
				if ($validite == 'Frais Divers')  {	

				$insertionFD = $this->db->query("INSERT INTO frais_divers value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".-$montant.",'".$commentaire."',".$query1->id_sortie.")");

			  }
			
				if ($validite == 'Prime')  {	

				 $insertionPR = $this->db->query("INSERT INTO prime value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".-$montant.",'".$commentaire."',".$query1->id_sortie.")");

			  }
			
			  if ($validite == 'Commission')  {	

				 $insertionPR = $this->db->query("INSERT INTO commission value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".-$montant.",'".$commentaire."',".$query1->id_sortie.")");

			  }
			
			
			  if ($validite == 'Depannage')  {	

				 $insertionPR = $this->db->query("INSERT INTO depannage value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".-$montant.",'".$commentaire."',".$query1->id_sortie.")");

			  }
			
			  if ($validite == 'Prevision Navire')  {	

				 $insertionPR = $this->db->query("INSERT INTO prevision_navire value ('',".$operation.",'".$vehicule."',CAST('". $date."' AS DATE),".-$montant.",'".$commentaire."',".$query1->id_sortie.")");

			  }
			
				if ($validite == 'Reglement Fournisseur Caisse')  {	
				
				$insertionRC  = $this->db->query("INSERT INTO reglement_caisse value('',".$fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".-$montant.",'".$commentaire."',".$query1->id_sortie.")");
               
			  }
			
			  if ($validite == 'Reglement Fournisseur Article')  {	
				
				$insertionRC  = $this->db->query("INSERT INTO reglement_article value('',".$fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".-$montant.",'".$commentaire."','RAS','RAS','RAS','RAS','RAS',".$query1->id_sortie.")");
               
			  }
			
			  if ($validite == 'Reglement Fournisseur Gazoil')  {	
				
				$insertionRC  = $this->db->query("INSERT INTO reglement_gazoil value('',".$fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".-$montant.",".$query1->id_sortie.")");
               
			  }
			
			  if ($validite == 'Reglement Fournisseur MIRA SA')  {	
				
				$insertionRC  = $this->db->query("INSERT INTO reglement_achat value('',".$fournisseur.",'".$numero."',CAST('". $date."' AS DATE),".-$montant.",'".$commentaire."',".$query1->id_sortie.")");
               
			 }

			}
			
			if ($insertion == true ) {
             # code...
                echo "Enregistrement de l'entrée réussie";
                $this->notificationAjout($nom_table,addslashes($message));
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
                   		   
				   $update = $this->db->query("UPDATE entree set  commentaire ='".$commentaire."',ordonnateur='".$ordonateur."',date_entree = CAST('". $date."' AS DATE),montant = ".$montant.",id_type = '".$type."',numero = ".$numero." where id_entree=".$id_prime."");
            if ($update == true ) {
				
			 $update = $this->db->query("UPDATE sortie set  commentaire ='".$commentaire."',ordonnateur='".$ordonateur."',date_entree = CAST('". $date."' AS DATE),montant = ".-$montant.",id_type = '".$type."' where numero=".$numero."");
     	
				
				
                # code...
                echo "Modification de l'entrée réussie";
                $this->notificationAjout($nom_table,addslashes($message2));
            }else{
                echo "Erreur lors de la modification";
            }
    }
    }else{
        echo "Erreur veuillez contacter l'administrateur";
    }
 $this->db->close();
}

// le code qui suit est pour la gestion des fournisseur

public function addFournisseurCaisse(){
        $commentaire = addslashes($_POST['commentaire']);
        $nom = $_POST["nom"];
        $telephone = $_POST["telephone"];
		$date_initial = $_POST["date_initial"];
		$solde_initial = preg_replace('/\s/','', $_POST["solde_initial"]);
        $adresse = $_POST["adresse"];
        $status = $_POST["status"];


        $nom_table = "fournisseur_caisse";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté le fournisseur caisse ".$nom.", de téléphone ".$telephone." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié le fournisseur caisse ".$nom.", de téléphone ".$telephone." le ".$date_notif." à ".$heure;
        if ($status =="insert") {
            # code...
            // echo $telephone;
                $requete = $this->db->query("SELECT * from fournisseur_caisse where telephone =".$telephone."")->result_array();
                if (count($requete)>0) {
                    # code...
                    echo "Ce numéro de téléphone est déjà utilisé veuillez changer";
                }else{
                    $query1 = $this->db->query("insert into fournisseur_caisse value('','". $nom. "','".$adresse."',". $telephone.",'".$commentaire."',". $solde_initial.",". $date_initial.")");
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
                $requete = $this->db->query("SELECT * from fournisseur_caisse where telephone =".$telephone."")->result_array();
                if (count($requete)>0) {
                    # code...
                   foreach ($requete as $row) {
                       # code...
                        if ($row["id_fournisseur"] == $id_client) {
                            # code...
                            $query1 = $this->db->query("UPDATE fournisseur_caisse set telephone=".$telephone.", adresse='".$adresse."', nom='".$nom."',commentaire = '".$commentaire."',montant_init = '".$solde_initial."', date_init = '".$date_initial."' where id_fournisseur =".$id_client."");
                            if($query1 == true){
                                echo "Modification parfaite du fournisseur";
                                $this->notificationAjout($nom_table,addslashes($message2));
                            }else{
                                echo "Erreur durant l'insertion";
                            }
                        }else{
                            echo "Erreur ce numero de téléphone est déjà utilisé";
                        }
                   }
                }else{
                    $query1 = $this->db->query("UPDATE fournisseur_caisse set telephone=".$telephone.", adresse='".$adresse."', nom='".$nom."',commentaire = '".$commentaire."',montant_init = '".$solde_initial."', date_init = '".$date_initial."' where id_fournisseur=".$id_client."");
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
					<td> ".$row['montant_init']."</td>
					<td> ".$row['date_init']."</td>
                    <td>";
                if($this->session->userdata('fournisseur_caisse_modification')=='true'){
                    echo"<button type='button' onclick=\"infosClient1('".$row['id_fournisseur']."','".$row['nom']."','".$row['adresse']."','".$row['telephone']."','".$row['montant_init']."','".$row['date_init']."','".addslashes($row['commentaire'])."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }
                if($this->session->userdata('fournisseur_caisse_suppression')=='true'){
                   echo" <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='fournisseur_caisse' identifiant='".$row['id_fournisseur']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_fournisseur\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
        }
        $this->db->close();
    }

        public function leSelectFournisseurCaisse(){
        $query = $this->db->query("select * from fournisseur_caisse order by nom")->result_array();
        if (count($query) >0) {
            # code...
            foreach ($query as $row) {
                # code...
                echo "<option value='".$row["id_fournisseur"]."'>".$row["nom"]."</option>";
            }
        }else{

        }
        $this->db->close();
    }

  
public function verifiDateInitialClient(){
  $id_client = $_POST["id_client"];
  $date_initial = $_POST["date_initial"];

  $query = $this->db->query("SELECT * from fournisseur_caisse where id_fournisseur=".$id_client."")->row();

if (count($query)>0) {
  # code...
  if ($date_initial < date("Y-m-d",strtotime($query->date_init))) {
    # code...
    return "La date de début doit etre supérieure ou égale à la date dinitialisation du client";
  }else{
    return 'ok';
  }
 }else{
  return "Erreur contactez l'administrateur";
 }
}

public function getDateInitialClient(){
  $id_client = $_POST["id_client"];

  $query = $this->db->query("SELECT * from fournisseur_caisse where id_fournisseur=".$id_client."")->row();

if (count($query)>0) {
  # code...
  return $query->date_init;
 }else{

 }
}    

public function getSoldeInitialClient(){
  $id_client = $_POST["id_client"];

  $query = $this->db->query("SELECT * from fournisseur_caisse where id_fournisseur=".$id_client."")->row();

if (count($query)>0) {
  # code...
  return $query->montant_init;
 }else{
  return 0;
 }
}

public function getClient($id_client){
  $query = $this->db->query("SELECT * from fournisseur_caisse where id_fournisseur =".$id_client."")->row();
  if (count($query)>0) {
    # code...
    return $query->nom;
  }
}

public function getAdresseClient($id_client){
  $query = $this->db->query("SELECT * from fournisseur_caisse where id_fournisseur =".$id_client."")->row();
  if (count($query)>0) {
    # code...
    return $query->adresse;
  }
}
public function getVilleClient($id_client){
  $query = $this->db->query("SELECT * from fournisseur_caisse where id_fournisseur =".$id_client."")->row();
  if (count($query)>0) {
    # code...
    return $query->ville;
  }
}

public function getTelephoneClient($id_client){
  $query = $this->db->query("SELECT * from fournisseur_caisse where id_fournisseur =".$id_client."")->row();
  if (count($query)>0) {
    # code...
    return $query->telephone;
  }
}

public function soldeCaisseClient2(){
    echo $this->repportNouveau3()-$this->selectAllTotalAccuseReglementPourBalanceClient()+$this->totalFacturePourBalanceClient();
}

public function soldeCaisseCaisse2(){
	
   // echo $this->selectAllTotalAccuseReglementPourBalanceCaisse()+$this->totalFacturePourBalanceCaisse();
 echo $this->getSoldeCaisseNew1();


}

public function getSoldeCaisseNew1(){
	
	   $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
		   $lieu = $_POST["lieu"];
		
    $montant = 0;

	
 $query1 = $this->db->query("SELECT * from entree where date_entree between '".$date_debut."' and '".$date_fin."' order by date_entree asc")->result_array();

	$montant1 = 0;
    foreach ($query1 as $row) {
        # code...
        $montant1 = $montant1 + $row["montant"];
    }
	
	
	 $query1 = $this->db->query("SELECT * from demande_bon_retour where date_dem between '".$date_debut."' and '".$date_fin."' order by date_dem asc")->result_array();

	$montant3 = 0;
    foreach ($query1 as $row) {
        # code...
        $montant3 = $montant3 + $row["montant"];
    }

    $query2 = $this->db->query("SELECT * from sortie where date_sortie between '".$date_debut."' and '".$date_fin."' and  lieu ='".$lieu."' and ((id_dem_bon IN (SELECT id_demande from demande_bon WHERE rj = 'oui' and PRT = 'oui')) or (id_dem_frais IN (SELECT id_demande from demande_frais WHERE rj = 'oui')))")->result_array();
    $montant2 = 0;
    foreach ($query2 as $row) {
        # code...
        $montant2 = $montant2 + $row["montant"];
    }
	
	$montant = $montant1+ $montant3 - $montant2;
	
	

    return $montant;
    $this->db->close();
}


public function getBalanceImprimableCaisse(){
  
  $date_debut = $_POST["date_debut"];
  $date_fin = $_POST["date_fin"];
  $lieu = $_POST["lieu"];
  // $date_fin =date("Y-m-d",strtotime($_POST["date_debut"].'- 1 day'));
       
$i=0;

   
  
   $totalAccuseReglement =0;
   $totalFactureCLient = 0;
   
   $totalSolde =0;

   $totalCredit =0;
   $solde = 0;
   
   $debit3=0;
   $credit3 = 0;
   
   $RN =0;
   $compteur =0;
   
   $compteur1 =0;
	
 while(date("Y-m-d",strtotime($_POST["date_debut"].'+ '.$i.' day')) <= $_POST["date_fin"]) { 
    # code...
    $date_debut = strval(date("Y-m-d",strtotime($_POST["date_debut"].'+ '.$i.' day')));
   


  // $getAllNumFactureClient = $this->db->query('SELECT * from facture_commercial where id_client = '.$id_client.' and date_fact ="'.$date_debut.'"')->result_array();
  $montant = 0;
  $total=0;
  
        $getFactureClient = $this->db->query("SELECT * from entree where  date_entree='".$date_debut."' group by numero")->result_array();
  if (count($getFactureClient)>0) {
    # code...
      foreach ($getFactureClient as $factureClient) {
      $totalFactureCLient =$factureClient['montant']+$totalFactureCLient;
	$debit = $factureClient['montant'];
	$debit3 = $debit + $debit3;

       
    $RN =$RN+$debit;
        
    $solde =$RN;
 
 echo "<tr style='border: 2px solid black;'>
        <td style='border: 2px solid black;'>".$date_debut."</td>
        <td style='border: 2px solid black;'>".$factureClient['numero']."</td>
        <td style='border: 2px solid black;'>".$factureClient['commentaire']."</td>
        <td style='border: 2px solid black;'>".number_format($debit,0,',',' ')."</td>
        <td style='border: 2px solid black;'>0</td>
        

        <td style='border: 2px solid black;'>".number_format($solde,0,',',' ')."</td>
        </tr>";
		
		$compteur1++;

  }


  }
  
   $getFactureClient = $this->db->query("SELECT * from demande_bon_retour where  date_dem='".$date_debut."' group by po_dem")->result_array();
  if (count($getFactureClient)>0) {
    # code...
      foreach ($getFactureClient as $factureClient) {
      $totalFactureCLient =$factureClient['montant']+$totalFactureCLient;
	$debit = $factureClient['montant'];
	$debit3 = $debit + $debit3;

       
    $RN =$RN+$debit;
        
    $solde =$RN;
 
 echo "<tr style='border: 2px solid black;'>
        <td style='border: 2px solid black;'>".$date_debut."</td>
        <td style='border: 2px solid black;'>".$factureClient['po_dem']."</td>
        <td style='border: 2px solid black;'>".$factureClient['commentaire']."</td>
        <td style='border: 2px solid black;'>".number_format($debit,0,',',' ')."</td>
        <td style='border: 2px solid black;'>0</td>
        

        <td style='border: 2px solid black;'>".number_format($solde,0,',',' ')."</td>
        </tr>";
		
		$compteur1++;

  }


  }
  
 // foreach ($getAllNumFactureClient as $num_facture) {
    $getAccuseReglement = $this->db->query("SELECT * from sortie where date_sortie ='".$date_debut."' and  lieu ='".$lieu."' and ((id_dem_bon IN (SELECT id_demande from demande_bon WHERE rj = 'oui' and PRT = 'oui')) or (id_dem_frais IN (SELECT id_demande from demande_frais WHERE rj = 'oui')))  ")->result_array();
  if (count($getAccuseReglement)>0) {
    # code...
      foreach ($getAccuseReglement as $reglement) {
    # code...
        $totalAccuseReglement = $reglement['montant'] + $totalAccuseReglement;
        $credit1 =$reglement['montant'];
        $credit3 = $credit3 + $credit1;

        
        $RN =$RN-$credit1;
        
		$solde =$RN;
		
        echo "<tr style='border: 2px solid black;'>
        <td style='border: 2px solid black;'>".$date_debut."</td>
        <td style='border: 2px solid black;'>".$reglement['numero']."</td>
        <td style='border: 2px solid black;'>".$reglement['commentaire']."</td>
        
        <td style='border: 2px solid black;'>0</td>
        <td style='border: 2px solid black;'>".number_format($credit1,0,',',' ')."</td>
        <td style='border: 2px solid black;'>".number_format($solde,0,',',' ')."</td>
    </tr>";

    $totalSolde = $totalSolde + $solde;
	$compteur1++;
  }
  }





$totalDebit = $debit3;
$totalCredit = $credit3;

// $totalSolde = $totalSolde + $solde;
   $i++;   
   $compteur++;
  }

  echo "<tr>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>TOTAUX</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteur1,0,',',' ')."</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($totalDebit,0,',',' ')."</td>
		<td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($totalCredit,0,',',' ')."</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($this->getSoldeBalanceImprimableCaisse(),0,',',' ')."</td>
    </tr>";
  }
  
  
  public function getSoldeBalanceImprimableCaisse(){

  $date_debut = $_POST["date_debut"];
  $date_fin = $_POST["date_fin"];
   $lieu = $_POST["lieu"];
  // $date_fin =date("Y-m-d",strtotime($_POST["date_debut"].'- 1 day'));
       
$i=0;

   
 
   $totalAccuseReglement =0;
   $totalFactureCLient = 0;
  
   $totalSolde =0;
   $totalDebit =0;
   $totalCredit =0;
   $solde = 0;
   
   $debit3=0;
   $credit3 = 0;
    $RN =0;
    $compteur = 0;
 

 while(date("Y-m-d",strtotime($_POST["date_debut"].'+ '.$i.' day')) <= $_POST["date_fin"]) { 
    # code...
    $date_debut = strval(date("Y-m-d",strtotime($_POST["date_debut"].'+ '.$i.' day')));
   

    $debit1 = 0;

$debit =0;
$credit = 0;



 // $getAllNumFactureClient = $this->db->query('SELECT * from facture_commercial where id_client = '.$id_client.' and date_fact ="'.$date_debut.'"')->result_array();
  $montant = 0;
  $total=0;

      $getFactureClient = $this->db->query("SELECT * from entree where date_entree ='".$date_debut."' group by numero")->result_array();
  if (count($getFactureClient)>0) {
    # code...
      foreach ($getFactureClient as $factureClient) {
    # code...
        // $solde =$this->getSoldeInitialClient()+$this->getTotalAccuseReglementParClientPourBalance($id_client,$date_debut,$date_fin)+$this->getTotalAvisCreditParClientPourBalance($id_client,$date_debut,$date_fin)-$this->getTotalAvisDebitParClientPourBalance($id_client,$date_debut,$date_fin)-$this->getTotalAccuseRetraitParClientPourBalance($id_client,$date_debut,$date_fin)-$this->getTotalFactureParClientPourBalance($id_client,$date_debut)-$this->getTotalFactureArticleParClientPourBalance($id_client,$date_debut);
        
		$totalFactureCLient =$factureClient['montant']+$totalFactureCLient;
  
$debit = $factureClient['montant'];

$debit3 = $debit+$debit3;

     
          $RN =$RN+$debit;
       
  $solde =$RN;

        $totalSolde = $totalSolde + $solde;
  }


  }
  
   $getFactureClient = $this->db->query("SELECT * from demande_bon_retour where  date_dem='".$date_debut."' group by po_dem")->result_array();
  if (count($getFactureClient)>0) {
    # code...
      foreach ($getFactureClient as $factureClient) {
      $totalFactureCLient =$factureClient['montant']+$totalFactureCLient;
	$debit = $factureClient['montant'];
	$debit3 = $debit + $debit3;

       
    $RN =$RN+$debit;
        
    $solde =$RN;
 

		
		

  }


  }


    $getAccuseReglement = $this->db->query("SELECT * from sortie where  date_sortie ='".$date_debut."'  and lieu ='".$lieu."' and  ((id_dem_bon IN (SELECT id_demande from demande_bon WHERE rj = 'oui' and PRT = 'oui')) or (id_dem_frais IN (SELECT id_demande from demande_frais WHERE rj = 'oui')))")->result_array();
  if (count($getAccuseReglement)>0) {
    # code...
      foreach ($getAccuseReglement as $reglement) {
    # code...
        $totalAccuseReglement =$reglement['montant']+$totalAccuseReglement;
        $credit1 =$reglement['montant'];
        $credit3 = $credit3 + $credit1;

    
          $RN =$RN-$credit1;
     
  $solde =$RN;

    $totalSolde = $totalSolde + $solde;
  }
  }




  
$totalDebit = $debit3;
$totalCredit = $credit3;
// $totalSolde = $totalSolde + $solde;
   $i++;   
   $compteur++;
  }
  return $solde;

  }



public function repportNouveau3(){

    $id_fournisseur = $_POST["id_fournisseur"];
    $id_client = $_POST["id_fournisseur"];

        
        $date_fin =date("Y-m-d",strtotime($_POST["date_debut"].'- 1 day'));
        $date_fin = strval($date_fin);
    $getDateInitialClient = $this->db->query("SELECT * from fournisseur_caisse where id_fournisseur=".$id_client."")->row();
    $soldeInitial=0;
if (count($getDateInitialClient)>0) {
  # code...
  $soldeInitial= $getDateInitialClient->montant_init;
  $date_debut = $getDateInitialClient->date_init;
 }else{
  $date_debut = "";
 }
 // echo $date_fin;
  return $soldeInitial-$this->selectAllTotalAccuseReglementPourRepport($id_fournisseur,$date_debut, $date_fin )+$this->totalFacturePourRepport($id_fournisseur,$date_debut, $date_fin );
}

public function selectAllTotalAccuseReglementPourRepport($id_fournisseur,$date_debut, $date_fin ){
      
        $montant = 0;
     

        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT  * FROM reglement_caisse WHERE id_fournisseur = '.$id_fournisseur.' order by date_reg asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_caisse WHERE  date_reg>="'.$date_debut.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_caisse WHERE date_reg<="'.$date_fin.'" order by date_reg asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_caisse WHERE date_reg between "'.$date_debut.'" and "'.$date_fin.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_caisse WHERE id_fournisseur = '.$id_fournisseur.' and date_reg between "'.$date_debut.'" and "'.$date_fin.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_caisse WHERE id_fournisseur = '.$id_fournisseur.' and date_reg<="'.$date_fin.'" order by date_reg asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_caisse WHERE id_fournisseur = '.$id_fournisseur.' and date_reg>="'.$date_debut.'" order by date_reg asc')->result_array();

        }
         $compteur = 0;
         
        foreach ($query1 as $tab) {
        $montant = $montant+$tab['montant'];
                         
        }
       
 return $montant;
}

public function totalFacturePourRepport($id_fournisseur,$date_debut, $date_fin ){
  $date = date('Y-m-d');

       if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT  * FROM facture_caisse WHERE id_fournisseur='.$id_fournisseur.' order by date_fact asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE  date_fact>="'.$date_debut.'" order by date_fact asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE date_fact<="'.$date_fin.'" order by date_fact asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE date_fact between "'.$date_debut.'" and "'.$date_fin.'" order by date_fact asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE id_fournisseur ='.$id_fournisseur.' and date_fact between "'.$date_debut.'" and "'.$date_fin.'" order by date_fact asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE id_client='.$id_fournisseur.' and date_fact<="'.$date_fin.'" order by date_fact asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE id_client ='.$id_fournisseur.' and date_fact>="'.$date_debut.'" order by date_fact asc')->result_array();

        }
         // $query1 = $this->db->query('SELECT * from commande group by num_com order by date_com asc')->result_array();
         $compteur = 0;
         $total = 0;
         $montant =0;
        foreach ($query1 as $row) {
            # code...
          
            # code...
          
             
              $montant = $row['montant']+$montant;
                  $compteur++;
         
        }

        return $montant;
    }

public function selectAllTotalAccuseReglementPourBalanceClient(){
        $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];

        $montant = 0;


      

        if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT  * FROM reglement_caisse WHERE id_fournisseur = '.$id_fournisseur.' order by date_reg asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_caisse WHERE  date_reg>="'.$date_debut.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_caisse WHERE date_reg<="'.$date_fin.'" order by date_reg asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_caisse WHERE date_reg between "'.$date_debut.'" and "'.$date_fin.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM reglement_caisse WHERE id_fournisseur = '.$id_fournisseur.' and date_reg between "'.$date_debut.'" and "'.$date_fin.'" order by date_reg asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_caisse WHERE id_fournisseur = '.$id_fournisseur.' and date_reg<="'.$date_fin.'" order by date_reg asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM reglement_caisse WHERE id_fournisseur = '.$id_fournisseur.' and date_reg>="'.$date_debut.'" order by date_reg asc')->result_array();

        }
         $compteur = 0;
         
        foreach ($query1 as $tab) {
        $montant = $montant+$tab['montant'];
                         
        }
       
    
 return $montant;
}

public function totalFacturePourBalanceClient(){
  $date = date('Y-m-d');
     $id_fournisseur = $_POST["id_fournisseur"];
        $date_debut = $_POST["date_debut"];
        $date_fin = $_POST["date_fin"];
       if (empty($date_debut) && empty($date_fin) && !empty($id_fournisseur)) {
            # code...
             $query1 = $this->db->query('SELECT  * FROM facture_caisse WHERE id_fournisseur='.$id_fournisseur.' order by date_fact asc')->result_array();
        }elseif (empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE  date_fact>="'.$date_debut.'" order by date_fact asc')->result_array();
        }elseif (!empty($date_fin) && empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE date_fact<="'.$date_fin.'" order by date_fact asc')->result_array();

        }elseif (!empty($date_fin) && empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE date_fact between "'.$date_debut.'" and "'.$date_fin.'" order by date_fact asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
            $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE id_fournisseur ='.$id_fournisseur.' and date_fact between "'.$date_debut.'" and "'.$date_fin.'" order by date_fact asc')->result_array();
        }elseif (!empty($date_fin) && !empty($id_fournisseur) && empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE id_fournisseur='.$id_fournisseur.' and date_fact<="'.$date_fin.'" order by date_fact asc')->result_array();

        }elseif (empty($date_fin) && !empty($id_fournisseur) && !empty($date_debut)) {
            # code...
             $query1 = $this->db->query('SELECT * FROM facture_caisse WHERE id_fournisseur ='.$id_fournisseur.' and date_fact>="'.$date_debut.'" order by date_fact asc')->result_array();

        }
         // $query1 = $this->db->query('SELECT * from commande group by num_com order by date_com asc')->result_array();
         $compteur = 0;
         $total = 0;
         $montant =0;
        foreach ($query1 as $row) {
            # code...
         
             
              $montant = $row['montant']+$montant;
                  $compteur++;
               // }
        }

        return $montant;
    }
	
public function repportNouveau($id_client){
  if (isset($id_client) || !empty($id_client)) {
    # code...
    $id_fournisseur = $id_client;
  }else{
    $id_fournisseur = $_POST["id_fournisseur"];
  }

        
        $date_fin =date("Y-m-d",strtotime($_POST["date_debut"].'- 1 day'));
        $date_fin = strval($date_fin);
    $getDateInitialClient = $this->db->query("SELECT * from fournisseur_caisse where id_fournisseur=".$id_client."")->row();
    $soldeInitial=0;
if (count($getDateInitialClient)>0) {
  # code...
  $soldeInitial= $getDateInitialClient->montant_init;
  $date_debut = $getDateInitialClient->date_init;
 }else{
  $date_debut = "";
 }
 // echo $date_fin;
  return $soldeInitial-$this->selectAllTotalAccuseReglementPourRepport($id_fournisseur,$date_debut, $date_fin )+$this->totalFacturePourRepport($id_fournisseur,$date_debut, $date_fin );
}

public function repportNouveauCredit($id_client){
  if (isset($id_client) || !empty($id_client)) {
    # code...
    $id_fournisseur = $id_client;
  }else{
    $id_fournisseur = $_POST["id_fournisseur"];
  }

        
        $date_fin =date("Y-m-d",strtotime($_POST["date_debut"].'- 1 day'));
        $date_fin = strval($date_fin);
    $getDateInitialClient = $this->db->query("SELECT * from fournisseur_caisse where id_fournisseur=".$id_client."")->row();
    $soldeInitial=0;
if (count($getDateInitialClient)>0) {
  # code...
  $soldeInitial= $getDateInitialClient->montant_init;
  $date_debut = $getDateInitialClient->date_init;
 }else{
  $date_debut = "";
 }
 // echo $date_fin;
  return $this->selectAllTotalAccuseReglementPourRepport($id_fournisseur,$date_debut, $date_fin );
}


public function repportNouveauDebit($id_client){
  if (isset($id_client) || !empty($id_client)) {
    # code...
    $id_fournisseur = $id_client;
  }else{
    $id_fournisseur = $_POST["id_fournisseur"];
  }

        
        $date_fin =date("Y-m-d",strtotime($_POST["date_debut"].'- 1 day'));
        $date_fin = strval($date_fin);
    $getDateInitialClient = $this->db->query("SELECT * from fournisseur_caisse where id_fournisseur=".$id_client."")->row();
    $soldeInitial=0;
if (count($getDateInitialClient)>0) {
  # code...
  $soldeInitial= $getDateInitialClient->montant_init;
  $date_debut = $getDateInitialClient->date_init;
 }else{
  $date_debut = "";
 }
 // echo $date_fin;
  return $this->totalFacturePourRepport($id_fournisseur,$date_debut, $date_fin );
}

public function getCreditPourBalanceImpCLient(){
  return $this->selectAllTotalAccuseReglementPourBalanceClient();
}

public function getDebitPourBalanceImpCLient(){
  return $this->totalFacturePourBalanceClient();
}

public function getSoldeBalanceImprimableClient(){
  $id_client = $_POST["id_fournisseur"];
  $date_debut = $_POST["date_debut"];
  $date_fin = $_POST["date_fin"];
  // $date_fin =date("Y-m-d",strtotime($_POST["date_debut"].'- 1 day'));
       
$i=0;

   
 
   $totalAccuseReglement =0;
   $totalFactureCLient = 0;
  
   $totalSolde =0;
   $totalDebit =0;
   $totalCredit =0;
   $solde = 0;
   
   $debit3=0;
   $credit3 = 0;
    $RN =$this->repportNouveau($id_client);
    $compteur = 0;
 

 while(date("Y-m-d",strtotime($_POST["date_debut"].'+ '.$i.' day')) <= $_POST["date_fin"]) { 
    # code...
    $date_debut = strval(date("Y-m-d",strtotime($_POST["date_debut"].'+ '.$i.' day')));
   

    $debit1 = 0;

$debit =0;
$credit = 0;



 // $getAllNumFactureClient = $this->db->query('SELECT * from facture_commercial where id_client = '.$id_client.' and date_fact ="'.$date_debut.'"')->result_array();
  $montant = 0;
  $total=0;

    $getAccuseReglement = $this->db->query('SELECT * from reglement_caisse where id_fournisseur = '.$id_client.' and date_reg ="'.$date_debut.'"')->result_array();
  if (count($getAccuseReglement)>0) {
    # code...
      foreach ($getAccuseReglement as $reglement) {
    # code...
        $totalAccuseReglement =$reglement['montant']+$totalAccuseReglement;
        $credit1 =$reglement['montant'];
        $credit3 = $credit3 + $credit1;

    
          $RN =$RN-$credit1;
     
  $solde =$RN;

    $totalSolde = $totalSolde + $solde;
  }
  }

      $getFactureClient = $this->db->query("SELECT * from facture_caisse where id_fournisseur=".$id_client." and date_fact='".$date_debut."' group by numero")->result_array();
  if (count($getFactureClient)>0) {
    # code...
      foreach ($getFactureClient as $factureClient) {
    # code...
        // $solde =$this->getSoldeInitialClient()+$this->getTotalAccuseReglementParClientPourBalance($id_client,$date_debut,$date_fin)+$this->getTotalAvisCreditParClientPourBalance($id_client,$date_debut,$date_fin)-$this->getTotalAvisDebitParClientPourBalance($id_client,$date_debut,$date_fin)-$this->getTotalAccuseRetraitParClientPourBalance($id_client,$date_debut,$date_fin)-$this->getTotalFactureParClientPourBalance($id_client,$date_debut)-$this->getTotalFactureArticleParClientPourBalance($id_client,$date_debut);
        
		$totalFactureCLient =$factureClient['montant']+$totalFactureCLient;
  
$debit = $factureClient['montant'];

$debit3 = $debit+$debit3;

     
          $RN =$RN+$debit;
       
  $solde =$RN;

        $totalSolde = $totalSolde + $solde;
  }


  }


  
$totalDebit = $debit3;
$totalCredit = $credit3;
// $totalSolde = $totalSolde + $solde;
   $i++;   
   $compteur++;
  }
  return $solde;

  }
//BALANCE IMPRIMABLE CLIENT


	
public function getBalanceImprimableClient(){
  $id_client = $_POST["id_fournisseur"];
  $date_debut = $_POST["date_debut"];
  $date_fin = $_POST["date_fin"];
  // $date_fin =date("Y-m-d",strtotime($_POST["date_debut"].'- 1 day'));
       
$i=0;

   
  
   $totalAccuseReglement =0;
   $totalFactureCLient = 0;
   
   $totalSolde =0;

   $totalCredit =0;
   $solde = 0;
   
   $debit3=0;
   $credit3 = 0;
   
   $RN =$this->repportNouveau($id_client);
   $compteur =0;
   
   $compteur1 =0;
	
 while(date("Y-m-d",strtotime($_POST["date_debut"].'+ '.$i.' day')) <= $_POST["date_fin"]) { 
    # code...
    $date_debut = strval(date("Y-m-d",strtotime($_POST["date_debut"].'+ '.$i.' day')));
   


  // $getAllNumFactureClient = $this->db->query('SELECT * from facture_commercial where id_client = '.$id_client.' and date_fact ="'.$date_debut.'"')->result_array();
  $montant = 0;
  $total=0;
 // foreach ($getAllNumFactureClient as $num_facture) {
    $getAccuseReglement = $this->db->query('SELECT * from reglement_caisse where id_fournisseur = '.$id_client.' and date_reg ="'.$date_debut.'"')->result_array();
  if (count($getAccuseReglement)>0) {
    # code...
      foreach ($getAccuseReglement as $reglement) {
    # code...
        $totalAccuseReglement = $reglement['montant'] + $totalAccuseReglement;
        $credit1 =$reglement['montant'];
        $credit3 = $credit3 + $credit1;

        
        $RN =$RN-$credit1;
        
		$solde =$RN;
		
        echo "<tr style='border: 2px solid black;'>
        <td style='border: 2px solid black;'>".$date_debut."</td>
        <td style='border: 2px solid black;'>".$reglement['numero']."</td>
        <td style='border: 2px solid black;'>".$reglement['libelle']."</td>
        <td style='border: 2px solid black;'>".number_format($credit1,0,',',' ')."</td>
        <td style='border: 2px solid black;'>0</td>
        
        <td style='border: 2px solid black;'>".number_format($solde,0,',',' ')."</td>
    </tr>";

    $totalSolde = $totalSolde + $solde;
	$compteur1++;
  }
  }

      $getFactureClient = $this->db->query("SELECT * from facture_caisse where id_fournisseur =".$id_client." and date_fact='".$date_debut."' group by numero")->result_array();
  if (count($getFactureClient)>0) {
    # code...
      foreach ($getFactureClient as $factureClient) {
      $totalFactureCLient =$factureClient['montant']+$totalFactureCLient;
	$debit = $factureClient['montant'];
	$debit3 = $debit + $debit3;

       
    $RN =$RN+$debit;
        
    $solde =$RN;
 
 echo "<tr style='border: 2px solid black;'>
        <td style='border: 2px solid black;'>".$date_debut."</td>
        <td style='border: 2px solid black;'>".$factureClient['numero']."</td>
        <td style='border: 2px solid black;'>".$factureClient['libelle']."</td>

        <td style='border: 2px solid black;'>0</td>
        <td style='border: 2px solid black;'>".number_format($debit,0,',',' ')."</td>

        <td style='border: 2px solid black;'>".number_format($solde,0,',',' ')."</td>
        </tr>";
		
		$compteur1++;

  }


  }



$totalDebit = $debit3;
$totalCredit = $credit3;

// $totalSolde = $totalSolde + $solde;
   $i++;   
   $compteur++;
  }

  echo "<tr>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>TOTAUX</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($compteur1,0,',',' ')."</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'></td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($totalCredit,0,',',' ')."</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($totalDebit,0,',',' ')."</td>
        <td style='color:red;font-size: 20px; border: 2px solid black; font-weight: bold;'>".number_format($this->getSoldeBalanceImprimableClient(),0,',',' ')."</td>
    </tr>";
  }



    public function addFacture(){
        $status = $_POST["status"];
        $numero = $_POST["numero"];

         // $montant = $_POST["montant"];
          $montant= preg_replace('/\s/','', $_POST["montant"]);
        $date = $_POST["date"];
        $libelle = addslashes($_POST['libelle']);
        $id_fournisseur = $_POST["id_fournisseur"];

        $nom_table = "facture_caisse";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté une facture caisse N°".$numero.", d'un montant".$montant.",  le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié une facture caisse N°".$numero.", d'un montant".$montant.",  le ".$date_notif." à ".$heure;

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
                    $this->notificationAjout($nom_table,addslashes($message));
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
                    $this->notificationAjout($nom_table,addslashes($message2));
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
                    $this->notificationAjout($nom_table,addslashes($message2));
                }else{
                    echo "Erreur lors de la modification";
                }
            }
        }else{
            echo "Erreur fatale";
        }

        $this->db->close();
    }



    public function selectAllFacture(){
		
	if (isset($_POST["date_debut"]) && isset($_POST["date_fin"]) && isset($_POST["id_fournisseur1"])) {
        # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
		$id_fournisseur1 = $_POST['id_fournisseur1'];
		
		
        if (!empty($date_fin) && !empty($date_debut) && !empty($id_fournisseur1)) {
            # code...
           $query1 = $this->db->query('SELECT * from facture_caisse  where id_fournisseur = '.$id_fournisseur1.' and date_fact between "'.$date_debut.'" and "'.$date_fin.'" order by date_fact desc')->result_array();
        }else{
             $query1 = $this->db->query('SELECT * from facture_caisse order by date_fact desc')->result_array();
        }
    }else{
			 $query1 = $this->db->query('SELECT * from facture_caisse order by date_fact desc')->result_array();
    }
	
   
		
   
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
                    <td>";
                if($this->session->userdata('fournisseur_caisse_modification')=='true'){
                    echo "<button type='button' onclick=\"infosFacture('".$row['id_facture']."','".$row['numero']."','".$row['id_fournisseur']."','".$row['date_fact']."','".$row['libelle']."','".number_format($row['montant'],0,',',' ')."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";}
                
                if($this->session->userdata('fournisseur_caisse_suppression')=='true'){

                   echo" <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='facture_caisse' identifiant='".$row['id_facture']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_facture\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
        }

        $this->db->close();
    }

// nous passsons donc au règlement


     public function selectAllReglement(){
		 
		 if (isset($_POST["date_debut"]) && isset($_POST["date_fin"]) && isset($_POST["id_fournisseur1"])) {
        # code...
        $date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
		$id_fournisseur1 = $_POST['id_fournisseur1'];
		
		
        if (!empty($date_fin) && !empty($date_debut) && !empty($id_fournisseur1)) {
            # code...
           $query1 = $this->db->query('SELECT * from reglement_caisse  where id_fournisseur = '.$id_fournisseur1.' and date_reg between "'.$date_debut.'" and "'.$date_fin.'" order by date_reg desc')->result_array();
        }else{
             $query1 = $this->db->query('SELECT * from reglement_caisse order by date_reg desc')->result_array();
        }
    }else{
			 $query1 = $this->db->query('SELECT * from reglement_caisse order by date_reg desc')->result_array();
    }
	
        
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
                    <td>";

                    if($this->session->userdata('caisse_modification')=='true'){
                    echo "<button type='button' onclick=\"infosFacture('".$row['id_reglement']."','".$row['id_fournisseur']."','".$row['numero']."','".$row['date_reg']."','".$row['libelle']."','".number_format($row['montant'],0,',',' ')."')\" class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                }
                if($this->session->userdata('caisse_suppression')=='true'){
                  echo"<button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='reglement_caisse' identifiant='".$row['id_reglement']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"id_reglement\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
        }

        $this->db->close();
    }


    public function addReglement(){
        $status = $_POST["status"];
        $numero = $_POST["numero"];
         $montant = preg_replace('/\s/','', $_POST["montant"]);
        $date = $_POST["date"];
        $libelle = addslashes($_POST["libelle"]);
        $id_fournisseur = $_POST["id_fournisseur"];

    $nom_table = "reglement_caisse";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté un règlement caisse N°".$numero.", d'un montant".$montant.",  le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié un règlement facture caisse N°".$numero.", d'un montant".$montant.",  le ".$date_notif." à ".$heure;
        if ($status == "insert"){
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
                    $this->notificationAjout($nom_table,addslashes($message));
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
                    $this->notificationAjout($nom_table,addslashes($message2));
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
                    $this->notificationAjout($nom_table,addslashes($message2));
                }else{
                    echo "Erreur lors de la modification";
                }
            }
        }else{
            echo "Erreur fatale";
        }

        $this->db->close();
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

        $this->db->close();
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
        $this->db->close();
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

        $this->db->close();
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
                    <td> ".number_format($row['total_sortie'],0,',',' ')."</td>
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

        $this->db->close();
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

    $this->db->close();
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

    $this->db->close();
}
    public function addClotureCaisse(){
        $date_cloture = $_POST["date_cloture"];
        
        $total_entree =  intval(preg_replace('/\s/','', $_POST["total_entree"]));
        $total_sortie = intval(preg_replace('/\s/','', $_POST["total_sortie"]));
        $solde = intval(preg_replace('/\s/','', $_POST["solde"]));
        $cloturer = $_POST["cloturer"];
        $ordonateur = $_POST['ordonateur'];
        $status = $_POST["status"];

    $nom_table = "cloture_caisse";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté une cloture caisse d'une entrée de ".$total_entree.",d'une sortie de ".$total_sortie.", pour un solde de ".$solde.",  le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié une cloture caisse d'une entrée de ".$total_entree.",d'une sortie de ".$total_sortie.", pour un solde de ".$solde.",  le ".$date_notif." à ".$heure;

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
                $this->notificationAjout($nom_table,addslashes($message));
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
                $this->notificationAjout($nom_table,addslashes($message2));
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
                $this->notificationAjout($nom_table,addslashes($message2));
            }else{

                echo "Erreur de modification";
            }

        }
     }
        }else{
            echo "Erreur fatale contactez l'administrateur";
        }

        $this->db->close();
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

        $this->db->close();
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

        $this->db->close();
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

                    $getOperation = $this->db->query("SELECT * FROM type_entreesortie where id_type = ".$row['id_type']."")->result_array();

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

        $this->db->close();
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

                    $getOperation = $this->db->query("SELECT * FROM type_entreesortie where id_type = ".$row['id_type']."")->result_array();

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

        $this->db->close();
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

    $this->db->close();
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

    $this->db->close();
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

    $this->db->close();
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
    $this->db->close();
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

    $this->db->close();
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
    $this->db->close();
}
 

 public function deleteEntreeSortie($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé le type caisse ".$getCamion->type.", de nom ".$getCamion->nom_type." le ".$date_notif." à ".$heure;


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

 public function deleteEntreeCaisse($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé l'entrée' caisse de la date du ".$getCamion->date_entree." d'ordonateur ".$getCamion->ordonnateur." d'un montant de ".$getCamion->montant." le ".$date_notif." à ".$heure;


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

 public function deleteSortieCaisse($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé la sortie caisse de la date du ".$getCamion->date_sortie." d'ordonateur ".$getCamion->ordonnateur." d'un montant de ".$getCamion->montant." le ".$date_notif." à ".$heure;


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

 public function deleteCLotureCaisse($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé la cloture caisse de la date du ".$getCamion->date_cloture.", d'ordonateur ".$getCamion->ordonnateur." dont le solde était ".$getCamion->solde." le ".$date_notif." à ".$heure;


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

// 

    public function deleteFournisseurCaisse($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé le fournisseur caisse ".$getCamion->nom." de téléphone ".$getCamion->telephone." le ".$date_notif." à ".$heure;


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

    public function getFournisseurCaisse($id_fournisseur){
      $query = $this->db->query("SELECT * from fournisseur_caisse where id_fournisseur = ".$id_fournisseur."")->row();

      if (count($query)>0) {
        # code...
        return $query->nom;
      }else{
	  return '';
    }
	}
	
	public function getFournisseurArticle($id_fournisseur){
      $query = $this->db->query("SELECT * from fournisseur_article where id_fournisseur = ".$id_fournisseur."")->row();

      if (count($query)>0) {
        # code...
        return $query->nom;
      }else{
	  return '';
    }
	}
	
	
	public function getFournisseurGazoil($id_fournisseur){
      $query = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur = ".$id_fournisseur."")->row();

      if (count($query)>0) {
        # code...
        return $query->nom;
      }else{
	  return '';
    }
	}
	
		public function getFournisseurMatiere($id_fournisseur){
      $query = $this->db->query("SELECT * from fournisseur_matiere where id_fournisseur = ".$id_fournisseur."")->row();

      if (count($query)>0) {
        # code...
        return $query->nom;
      }else{
	  return '';
    }
	}
	
	
	   public function getOperationCaisse($id_operation){
      $query = $this->db->query("SELECT * from operation where id_operation = ".$id_operation."")->row();

      if (count($query)>0) {
        # code...
        return $query->nom_op;
      }else{
	  return '';
    }
	} 
	
	   public function getDestinationCaisse($id_distance){
      $query = $this->db->query("SELECT * from distance_littrage where id_distance = ".$id_distance."")->row();

      if (count($query)>0) {
        # code...
        return $query->distance;
      }else{
	  return '';
    }
	}
	
    public function deleteFactureFournisseurCaisse($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé la facture fournisseur Caisse ".$this->getFournisseurCaisse($getCamion->id_fournisseur).", de N° ".$getCamion->numero." d'un montant d'un ".$getCamion->montant." le ".$date_notif." à ".$heure;


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


   public function deleteReglementFournisseurCaisse($table, $identifiant, $nom_id){

        $getCamion = $this->db->query("SELECT * from ".$table." where ".$nom_id."=".$identifiant."")->row();

        if (count($getCamion)>0) {
          # code...
          $nom_table = $table;
          $heure = date("H:i:s");
          $date_notif = date("d-m-Y");
          $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à supprimé le règlement fournisseur caisse de  ".$this->getFournisseurCaisse($getCamion->id_fournisseur).", de N° ".$getCamion->numero." d'un montant d'un ".$getCamion->montant." le ".$date_notif." à ".$heure;


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
	
	
	public function genererChaineAleatoireDemande(){ 

	$date = date('Y-m-d');
	$now = new Datetime();

    $getCodeBLClient = $this->db->query("SELECT * from demande_bon order by id_demande desc limit 1")->row();

 $code =0;
    if (count($getCodeBLClient)>0) {
      # code...
      $code = $getCodeBLClient->po_dem;

    }else{
     
      $code = 0;
    }
    $code++;
    // $code=intval($code);
    while (strlen($code)<10) {
      # code...
      $code = "0".$code;
    }

    return "DBIC".filter_var($code, FILTER_SANITIZE_NUMBER_INT);
}


public function selectAllDemmande(){
	
	
	
	
	
	
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
         $query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,etat_dem,etat_dem1,delegue,code_camion,bl,client,destination,marchandiseD,marchandiseR,immatriculation,litrage,frais_route,frais_retour,rj,rj1,rj2,ligne,pont,tour from demande_frais where date_dem between '".$date_debut."' and '".$date_fin."' order by date_dem DESC")->result_array();
        
		}else {
			
		  $query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,etat_dem,etat_dem1,etat_dem1,delegue,code_camion,bl,client,destination,marchandiseD,marchandiseR,immatriculation,litrage,frais_route,frais_retour,rj,rj1,rj2,ligne,pont,tour from demande_frais where delegue = '".$id_fournisseur1."' and date_dem between '".$date_debut."' and '".$date_fin."'  order by date_dem DESC ")->result_array();
			
		}	
		
		}else{
			
			$query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,etat_dem,etat_dem1,delegue,code_camion,bl,client,destination,marchandiseD,marchandiseR,immatriculation,litrage,frais_route,frais_retour,rj,rj1,rj2,ligne,pont,tour from demande_frais where date_dem = '".$date."' ORDER BY id_demande DESC")->result_array();    
        }		
		  
		}else{
			
			$query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,etat_dem,etat_dem1,delegue,code_camion,bl,client,destination,marchandiseD,marchandiseR,immatriculation,litrage,frais_route,frais_retour,rj,rj1,rj2,ligne,pont,tour from demande_frais where date_dem = '".$date."' ORDER BY id_demande DESC")->result_array();    
        }			
		
		if (count($query1) >0 ) {
            # code...
            $compteur = 0;
			foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    
                    
                    <td>".$row['po_dem']."</td>
					<td>".$row['delegue']."</td>
                    <td>".$row['date_dem']."</td>
					<td>".$row['bl']."</td>                
                    <td>".$row['code_camion']."</td>
					<td>".$row['immatriculation']."</td>";
					
					$getClient = $this->db->query("SELECT * from clientfrais where id_client = ".$row['client']."")->row();
                   
					
					$getDestination = $this->db->query("SELECT * from distance_littrage where id_distance = ".$row['destination']."")->row();
                    echo"
					<td> ".$getClient->nom." </td>
					<td> ".$getDestination->distance." </td>
					
					
					<td>".$row['marchandiseD']."</td>
					
					
					<td>".$row['frais_route']/$row['tour']."</td>
					<td>".$row['marchandiseR']."</td>
					<td>".$row['frais_retour']/$row['tour']."</td>
					<td>".$row['pont']."</td>
					<td>".$row['tour']."</td>
					
					<td>".$row['etat_dem']." </td>
					<td>".$row['etat_dem1']." </td>
                    <td>";
                if($this->session->userdata('demande_modification')=='true'){
                   echo" <button type='button' onclick='getDetailDemmandePourModification(\"".$row['date_dem']."\",\"".$row['po_dem']."\",\"".$row['etat_dem']."\",\"".$row['etat_dem1']."\",\"".$row['rj']."\",\"".$row['rj1']."\",\"".$row['rj2']."\",\"".$row['ligne']."\" )'  class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
                 }

         			 $query2 = $this->db->query("SELECT rj,rj1 from demande_bon where po_dem = '".$row['po_dem']."' and (rj= 'oui' or rj1 ='oui') limit 1")->row(); 
	  
	  
					if (count($query2) >0 ) {

		  
					  echo"  <button type='button'   class=' btn-primary btn-sm' onclick='detailDemande(\"".$row['po_dem']."\",\"".$row['delegue']."\",\"".$row['date_dem']."\",\"".$row['etat_dem']."\",\"".$row['etat_dem1']."\",\"".number_format($this->getMontantDemandeLitrage($row['po_dem']),0,',',' ')."\",\"".number_format($this->getMontantDemandeFraisRoute($row['po_dem']),0,',',' ')."\",\"".number_format($this->getMontantDemandeFraisRetour($row['po_dem']),0,',',' ')."\",\"".number_format($this->getMontantDemandePont($row['po_dem']),0,',',' ')."\",\"".number_format($this->getMontantTotal($row['po_dem']),0,',',' ')."\",\"".$this->getSignatureDAFB($row['po_dem'])."\",\"".$this->getSignatureDGTB($row['po_dem'])."\",\"".number_format($this->getCompteurTotal($row['po_dem']),0,',',' ')."\")'><i class='nav-icon '>+</i></button>";
					
					}
	

                if($this->session->userdata('demande_suppression')=='true'){
                  echo"  <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='demande_frais' identifiant='".$row['po_dem']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"po_dem\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
			}
		
		}

        $this->db->close();
    }
	
	
public function addDemandeCaisse(){
	
  
	$po = $this->genererChaineAleatoireDemande();
	$poUP = $_POST['poUP'];
	$date_demande = $_POST['date_demande'];
	$etat_demande = $_POST['etat_demande'];
	
	$ordonateur = $_POST['ordonateur'];
	
	$lieu = $_POST['lieu'];
    
    // detail de la commande
    $nbreLignes = $_POST["nbreLignes"];
	
	$rj = $_POST['rj'];
	$rj1 = $_POST['rj1'];
	
	   

    $validite = json_decode($_POST['validite']);
    $camion = json_decode($_POST['camion']);
    $montant = json_decode($_POST['montant']);
	$vehicule = json_decode($_POST['vehicule']);
    $operation = json_decode($_POST['operation']);
    $fournisseur = json_decode($_POST['fournisseur']);
	$arrivee = json_decode($_POST['arrivee']);
    $commentaire = json_decode($_POST['commentaire']);
    $rjFR = json_decode($_POST['rjFR']);
	
	$id_demande = json_decode($_POST['id_demande']);
    $status = $_POST["status"];

    $nom_table = "demande_bon";
    $heure = date("H:i:s");
    $date_notif = date("d-m-Y");
	
    $message = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à ajouté la demande de caisse N° ".$po." le ".$date_notif." à ".$heure;

    $message2 = $this->getIdentifiantUtilisateur($this->session->userdata('id_profil'))." à modifié la demande de caisse N° ".$po." le ".$date_notif." à ".$heure;



    if ($status == "insert") {
		
	 

	$etat_demande = 'DEMANDEE';
	
	


	$i = 1;
	
	
	$somme_frais = 0;
	$gazoil_ligne = 0;
	$route_ligne = 0;
	$retour_ligne = 0;


    while ($i<= $nbreLignes) {
		
  
     $query = $this->db->query("INSERT into demande_bon value('','".$po."',CAST('". $date_demande."' AS DATE),'".$etat_demande."','".$ordonateur."','".$validite[$i]."',".$camion[$i].",".$montant[$i].",'".$vehicule[$i]."',".$operation[$i].",".$fournisseur[$i].",".$arrivee[$i].",'".$commentaire[$i]."','".$rj."','".$rj1."','non',".$nbreLignes.",'".$rjFR[$i]."','non','".$lieu."')");
  
      $getclef= $this->db->query("SELECT MAX(id_demande) AS MAXIMUM FROM demande_bon")->row();
	 
	  $getPoC= $this->db->query("SELECT po_dem  FROM demande_bon ORDER BY id_demande DESC LIMIT 1")->row();

   
   
              if ($query == true ) {
				  
				  			   
				
				
				if ($validite[$i] == 'Frais Route')  {
					
					
					 $insertionCS = $this->db->query("INSERT INTO sortie value ('',".$camion[$i].",CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$ordonateur."','".$commentaire[$i]."','".$validite[$i]."','".$vehicule[$i]."',".$fournisseur[$i].",'".$getPoC->po_dem."',".$operation[$i].",".$arrivee[$i].",'".$etat_demande."','non','non',".$getclef->MAXIMUM.",0,'".$lieu."')");
		
				
				
				    $query1 = $this->db->query("SELECT id_sortie from sortie order by id_sortie desc limit 1")->row();

				
				$insertionFR = $this->db->query("INSERT INTO frais_route value ('',".$operation[$i].",'".$vehicule[$i]."',CAST('". $date_demande."' AS DATE),".$montant[$i].",0,'".$commentaire[$i]."',".$arrivee[$i]." ,".$query1->id_sortie." )");
	
			}
			
				if ($validite[$i] == 'Retour En Caisse')  {	
				
				
				$insertionRC  = $this->db->query("INSERT INTO reglement_caisse value('',".$fournisseur[$i].",'".$getPoC->po_dem."',CAST('". $date_demande."' AS DATE),".-$montant[$i].",'".$commentaire[$i]."',".$query1->id_sortie.")");
		
			

}

				if ($validite[$i] == 'Autre')  {	
				
				
				 $insertionCS = $this->db->query("INSERT INTO sortie value ('',".$camion[$i].",CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$ordonateur."','".$commentaire[$i]."','".$validite[$i]."','".$vehicule[$i]."',".$fournisseur[$i].",'".$getPoC->po_dem."',".$operation[$i].",".$arrivee[$i].",'".$etat_demande."','non','non',".$getclef->MAXIMUM.",0,'".$lieu."')");
		
			

}
			
			
			if ($validite[$i] == 'Retour Fournisseur')  {	
				
				
				 $insertionCS = $this->db->query("INSERT INTO sortie value ('',".$camion[$i].",CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$ordonateur."','".$commentaire[$i]."','".$validite[$i]."','".$vehicule[$i]."',".$fournisseur[$i].",'".$getPoC->po_dem."',".$operation[$i].",".$arrivee[$i].",'".$etat_demande."','non','non',".$getclef->MAXIMUM.",0,'".$lieu."')");
		
							
				$query1 = $this->db->query("SELECT id_sortie from sortie order by id_sortie desc limit 1")->row();

				$insertionFR = $this->db->query("INSERT INTO reglement_caisse value ('',".$operation[$i].",'".$vehicule[$i]."',CAST('". $date_demande."' AS DATE),".$montant[$i].",0,'".$commentaire[$i]."',".$arrivee[$i]." ,".$query1->id_sortie.")");

			}
			
				if ($validite[$i] == 'Frais Divers')  {	
				
				 $insertionCS = $this->db->query("INSERT INTO sortie value ('',".$camion[$i].",CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$ordonateur."','".$commentaire[$i]."','".$validite[$i]."','".$vehicule[$i]."',".$fournisseur[$i].",'".$getPoC->po_dem."',".$operation[$i].",".$arrivee[$i].",'".$etat_demande."','non','non',".$getclef->MAXIMUM.",0,'".$lieu."')");
		
				
				
				    $query1 = $this->db->query("SELECT id_sortie from sortie order by id_sortie desc limit 1")->row();

				$insertionFD = $this->db->query("INSERT INTO frais_divers value ('',".$operation[$i].",'".$vehicule[$i]."',CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$commentaire[$i]."',".$query1->id_sortie.")");

			}
			
				if ($validite[$i] == 'Prime')  {	
				
				 $insertionCS = $this->db->query("INSERT INTO sortie value ('',".$camion[$i].",CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$ordonateur."','".$commentaire[$i]."','".$validite[$i]."','".$vehicule[$i]."',".$fournisseur[$i].",'".$getPoC->po_dem."',".$operation[$i].",".$arrivee[$i].",'".$etat_demande."','non','non',".$getclef->MAXIMUM.",0,'".$lieu."')");
		
				
				
				    $query1 = $this->db->query("SELECT id_sortie from sortie order by id_sortie desc limit 1")->row();

				 $insertionPR = $this->db->query("INSERT INTO prime value ('',".$operation[$i].",'".$vehicule[$i]."',CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$commentaire[$i]."',".$query1->id_sortie.")");

			}
			
			if ($validite[$i] == 'Commission')  {	
			
			 $insertionCS = $this->db->query("INSERT INTO sortie value ('',".$camion[$i].",CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$ordonateur."','".$commentaire[$i]."','".$validite[$i]."','".$vehicule[$i]."',".$fournisseur[$i].",'".$getPoC->po_dem."',".$operation[$i].",".$arrivee[$i].",'".$etat_demande."','non','non',".$getclef->MAXIMUM.",0,'".$lieu."')");
		
				
				
				    $query1 = $this->db->query("SELECT id_sortie from sortie order by id_sortie desc limit 1")->row();

				 $insertionPR = $this->db->query("INSERT INTO commission value ('',".$operation[$i].",'".$vehicule[$i]."',CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$commentaire[$i]."',".$query1->id_sortie.")");

			}
			
			
			if ($validite[$i] == 'Depannage')  {	
			
			
			 $insertionCS = $this->db->query("INSERT INTO sortie value ('',".$camion[$i].",CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$ordonateur."','".$commentaire[$i]."','".$validite[$i]."','".$vehicule[$i]."',".$fournisseur[$i].",'".$getPoC->po_dem."',".$operation[$i].",".$arrivee[$i].",'".$etat_demande."','non','non',".$getclef->MAXIMUM.",0,'".$lieu."')");
		
				
				
				    $query1 = $this->db->query("SELECT id_sortie from sortie order by id_sortie desc limit 1")->row();

				 $insertionPR = $this->db->query("INSERT INTO depannage value ('',".$operation[$i].",'".$vehicule[$i]."',CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$commentaire[$i]."',".$query1->id_sortie.")");

			}
			
			if ($validite[$i] == 'Prevision Navire')  {	
			
			
			 $insertionCS = $this->db->query("INSERT INTO sortie value ('',".$camion[$i].",CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$ordonateur."','".$commentaire[$i]."','".$validite[$i]."','".$vehicule[$i]."',".$fournisseur[$i].",'".$getPoC->po_dem."',".$operation[$i].",".$arrivee[$i].",'".$etat_demande."','non','non',".$getclef->MAXIMUM.",0,'".$lieu."')");
		
				
				
				    $query1 = $this->db->query("SELECT id_sortie from sortie order by id_sortie desc limit 1")->row();

				 $insertionPR = $this->db->query("INSERT INTO prevision_navire value ('',".$operation[$i].",'".$vehicule[$i]."',CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$commentaire[$i]."',".$query1->id_sortie.")");

			}
			
			if ($validite[$i] == 'Reglement Fournisseur Caisse')  {	
			
			
			 $insertionCS = $this->db->query("INSERT INTO sortie value ('',".$camion[$i].",CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$ordonateur."','".$commentaire[$i]."','".$validite[$i]."','".$vehicule[$i]."',".$fournisseur[$i].",'".$getPoC->po_dem."',".$operation[$i].",".$arrivee[$i].",'".$etat_demande."','non','non',".$getclef->MAXIMUM.",0,'".$lieu."')");
		
				
				
				    $query1 = $this->db->query("SELECT id_sortie from sortie order by id_sortie desc limit 1")->row();
				
				$insertionRC  = $this->db->query("INSERT INTO reglement_caisse value('',".$fournisseur[$i].",'".$getPoC->po_dem."',CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$commentaire[$i]."',".$query1->id_sortie.")");
               
			}
			
			if ($validite[$i] == 'Reglement Fournisseur Article')  {	
			
			
			 $insertionCS = $this->db->query("INSERT INTO sortie value ('',".$camion[$i].",CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$ordonateur."','".$commentaire[$i]."','".$validite[$i]."','".$vehicule[$i]."',".$fournisseur[$i].",'".$getPoC->po_dem."',".$operation[$i].",".$arrivee[$i].",'".$etat_demande."','non','non',".$getclef->MAXIMUM.",0,'".$lieu."')");
		
				
				
				    $query1 = $this->db->query("SELECT id_sortie from sortie order by id_sortie desc limit 1")->row();
				
				$insertionRC  = $this->db->query("INSERT INTO reglement_article value('',".$fournisseur[$i].",'".$getPoC->po_dem."',CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$commentaire[$i]."','RAS','RAS','RAS','RAS','RAS',".$query1->id_sortie.")");
               
			}
			
			if ($validite[$i] == 'Reglement Fournisseur Gazoil')  {	
			
			
			 $insertionCS = $this->db->query("INSERT INTO sortie value ('',".$camion[$i].",CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$ordonateur."','".$commentaire[$i]."','".$validite[$i]."','".$vehicule[$i]."',".$fournisseur[$i].",'".$getPoC->po_dem."',".$operation[$i].",".$arrivee[$i].",'".$etat_demande."','non','non',".$getclef->MAXIMUM.",0,'".$lieu."')");
		
				
				
				    $query1 = $this->db->query("SELECT id_sortie from sortie order by id_sortie desc limit 1")->row();
				
				$insertionRC  = $this->db->query("INSERT INTO reglement_gazoil value('',".$fournisseur[$i].",'".$getPoC->po_dem."',CAST('". $date_demande."' AS DATE),".$montant[$i].",".$query1->id_sortie.")");
               
			}
			
			if ($validite[$i] == 'Reglement Fournisseur MIRA SA')  {	
			
			
			 $insertionCS = $this->db->query("INSERT INTO sortie value ('',".$camion[$i].",CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$ordonateur."','".$commentaire[$i]."','".$validite[$i]."','".$vehicule[$i]."',".$fournisseur[$i].",'".$getPoC->po_dem."',".$operation[$i].",".$arrivee[$i].",'".$etat_demande."','non','non',".$getclef->MAXIMUM.",0,'".$lieu."')");
		
				
				
				    $query1 = $this->db->query("SELECT id_sortie from sortie order by id_sortie desc limit 1")->row();
				
				$insertionRC  = $this->db->query("INSERT INTO reglement_achat value('',".$fournisseur[$i].",'".$getPoC->po_dem."',CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$commentaire[$i]."',".$query1->id_sortie.")");
               
			}
   
   
	  }
	  
	  $i++; 
    }

        if ($query == true) {
            # code...
            echo "Insertion parfaite de la demande de bon de caisse";
			
	       $this->notificationAjout2($nom_table,addslashes($message));
			
		   $this->notificationAjout($nom_table,addslashes($message));
            
        }else{
            echo "erreur lors de l'insertion";
        }
	

                         

    }elseif ($status == "update") {
        # code...
		
	
			if ($rj == 'oui') {
				
			  $etat_demande = 'VALIDEE DAF';
			  
			 
			}else{
				  
			   $etat_demande = 'DEMANDEE';
				
			  }
			
			if ($rj1 == 'oui'){
				
              $etat_demande1 = 'VALIDEE DGT';
			  
				 			  
			  
            }else{
				  
			   $etat_demande1 = 'DEMANDEE';
				
			  }  
		
         $i = 1;
		 
		 $po = $_POST['po'];
		 
		 
		 
			
        while ( $i<= $nbreLignes) {
			
		  
      $query = $this->db->query("UPDATE demande_bon set date_dem = CAST('". $date_demande."' AS DATE),  etat_dem ='".$etat_demande."',lieu ='".$lieu."', arrivee =".$arrivee[$i].", validite = '".$validite[$i]."', camion = ".$camion[$i].", montant = ".$montant[$i].", vehicule = '".$vehicule[$i]."', operation =".$operation[$i].", fournisseur = ".$fournisseur[$i].", commentaire ='".$commentaire[$i]."',rj1='".$rj1."',rj='".$rj."',ligne=".$nbreLignes.", AFR='".$rjFR[$i]."'  where id_demande =".$id_demande[$i]."");
    
	  $updateCS = $this->db->query("UPDATE sortie set  commentaire = '".$commentaire[$i]."', ordonnateur='".$ordonateur."', lieu='".$lieu."', date_sortie = CAST('". $date_demande."' AS DATE), montant = ".$montant[$i].", id_type = ".$camion[$i].", type_sortie = '".$validite[$i]."', vehicule = '".$vehicule[$i]."', fournisseur = ".$fournisseur[$i].",numero = '".$poUP."', operation  =".$operation[$i].",destination = ".$arrivee[$i]." where id_dem_bon = ".$id_demande[$i]."");
		

  
     if ($updateCS == true ) {
		 
		  $IDCS = $this->db->query("SELECT id_sortie FROM sortie  where id_dem_bon = ".$id_demande[$i]."")->row();
     			
		

			if ($validite[$i] == 'Frais Route') {
				
				
		
				$query1 = $this->db->query("SELECT * from frais_route WHERE id_caisse = ".$IDCS->id_sortie." ")->row();

				 
			if (count($query1) >0) {
				
				
		    $insertionFR = $this->db->query("UPDATE frais_route set id_operation =".$operation[$i].",code_camion='".$vehicule[$i]."',date_frais = CAST('". $date_demande."' AS DATE),montant = ".$montant[$i].", commentaire='".$commentaire[$i]."' where id_caisse=".$IDCS->id_sortie."");
		
			}else {
				
			$insertionFR = $this->db->query("INSERT INTO frais_route value ('',".$operation[$i].",'".$vehicule[$i]."',CAST('". $date_demande."' AS DATE),".$montant[$i].",0,'".$commentaire[$i]."',".$arrivee[$i].",".$IDCS->id_sortie.")");

			}	
			
			}
			
			if ($validite[$i] == 'Frais Divers') {

			$query1 = $this->db->query("SELECT * from frais_divers WHERE id_caisse = ".$IDCS->id_sortie."")->row();;
				 
			if (count($query1) >0) { 
			
            $insertionFD = $this->db->query("UPDATE frais_divers set id_operation =".$operation[$i].",code_camion='".$vehicule[$i]."',date_frais = CAST('". $date_demande."' AS DATE),montant = ".$montant[$i].", commentaire='".$commentaire[$i]."' where id_caisse=".$IDCS->id_sortie."");
		
			}else {
				
			$insertionFD = $this->db->query("INSERT INTO frais_divers value ('',".$operation[$i].",'".$vehicule[$i]."',CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$commentaire[$i]."',".$IDCS->id_sortie.")");

			}	
			
			}
			
			if ($validite[$i] == 'Prime') {

			$query1 = $this->db->query("SELECT * from prime WHERE id_caisse = ".$IDCS->id_sortie."")->row();;
				 
			if (count($query1) >0) {
				
			$insertionPR = $this->db->query("UPDATE prime set  id_operation =".$operation[$i].",code_camion='".$vehicule[$i]."',date_prime = CAST('". $date_demande."' AS DATE),montant = ".$montant[$i].",libelle = '".$commentaire[$i]."' where id_caisse =".$IDCS->id_sortie."");


			}else {
				
			 $insertionPR = $this->db->query("INSERT INTO prime value ('',".$operation[$i].",'".$vehicule[$i]."',CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$commentaire[$i]."',".$IDCS->id_sortie.")");
			
			}	
			
			}
			
			if ($validite[$i] == 'Commission') {

			$query1 = $this->db->query("SELECT * from commission WHERE id_caisse = ".$IDCS->id_sortie."")->row();;
				 
			if (count($query1) >0) {
				
			$insertionCOM = $this->db->query("UPDATE commission set  id_operation =".$operation[$i].",code_camion='".$vehicule[$i]."',date_prime = CAST('". $date_demande."' AS DATE),montant = ".$montant[$i].",libelle = '".$commentaire[$i]."' where id_caisse =".$IDCS->id_sortie."");
	

			}else {
				
			 $insertionCOM = $this->db->query("INSERT INTO commission value ('',".$operation[$i].",'".$vehicule[$i]."',CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$commentaire[$i]."', ".$IDCS->id_sortie.")");
			}	
			
			}
			
			if ($validite[$i] == 'Reglement Fournisseur Caisse') {

			$query1 = $this->db->query("SELECT * from reglement_caisse WHERE id_caisse = ".$IDCS->id_sortie."")->row();;
				 
			if (count($query1) >0) {
				
			$insertionFC = $this->db->query("UPDATE reglement_caisse set  id_fournisseur =".$fournisseur[$i].",numero='".$poUP."',date_reg = CAST('". $date_demande."' AS DATE),montant = ".$montant[$i].",libelle = '".$commentaire[$i]."' where id_caisse=".$IDCS->id_sortie."");
	

			}else {
				
			 $insertionFC  = $this->db->query("INSERT INTO reglement_caisse value('',".$fournisseur[$i].",'".$poUP."',CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$commentaire[$i]."',".$IDCS->id_sortie.")");
               
			
			}
            }
			
			
			if ($validite[$i] == 'Retour Fournisseur') {

			$query1 = $this->db->query("SELECT * from reglement_caisse WHERE id_caisse = ".$IDCS->id_sortie."")->row();;
				 
			if (count($query1) >0) {
				
			$insertionFC = $this->db->query("UPDATE reglement_caisse set  id_fournisseur =".$fournisseur[$i].",numero='".$poUP."',date_reg = CAST('". $date_demande."' AS DATE),montant = ".$montant[$i].",libelle = '".$commentaire[$i]."' where id_caisse=".$IDCS->id_sortie."");
	

			}else {
				
			 $insertionFC  = $this->db->query("INSERT INTO reglement_caisse value('',".$fournisseur[$i].",'".$poUP."',CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$commentaire[$i]."',".$IDCS->id_sortie.")");
               
			
			}
            }
			
	
		
			if ($validite[$i] == 'Reglement Fournisseur Article') {

			$query1 = $this->db->query("SELECT * from reglement_article WHERE id_caisse = ".$IDCS->id_sortie."")->row();;
				 
			
			
			 if (count($query1) >0) {
				
			
				
			$insertionFA = $this->db->query("UPDATE reglement_article set  id_fournisseur =".$fournisseur[$i].",numero='".$poUP."',date_reg = CAST('". $date_demande."' AS DATE),montant = ".$montant[$i].",libelle = '".$commentaire[$i]."' where id_caisse=".$IDCS->id_sortie."");
		

			}else {
				
			$insertionFA  = $this->db->query("INSERT INTO reglement_article value('',".$fournisseur[$i].",'".$poUP."',CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$commentaire[$i]."','RAS','RAS',0,0,'RAS',".$IDCS->id_sortie.")");
                 
			
			}
        }
		
		    if ($validite[$i] == 'Reglement Fournisseur Gazoil') {

			$query1 = $this->db->query("SELECT * from reglement_gazoil WHERE id_caisse = ".$IDCS->id_sortie."")->row();;
				 
			if (count($query1) >0) {
				
				$insertionFG = $this->db->query("UPDATE reglement_gazoil set  id_fournisseur =".$fournisseur[$i].",numero='".$poUP."',date_reg = CAST('". $date_demande."' AS DATE),montant = ".$montant[$i].",libelle = '".$commentaire[$i]."' where id_caisse=".$IDCS->id_sortie."");
		

			}else {
				
			$insertionFG  = $this->db->query("INSERT INTO reglement_gazoil value('',".$fournisseur[$i].",'".$poUP."',CAST('". $date_demande."' AS DATE),".$montant[$i].",".$IDCS->id_sortie." )");
                      
			
			}
        }
		
		    if ($validite[$i] == 'Reglement Fournisseur Matiere Premiere') {

			$query1 = $this->db->query("SELECT * from reglement_achat WHERE id_caisse = ".$IDCS->id_sortie."")->row();;
				 
			if (count($query1) >0) {
				
				$insertionFMP = $this->db->query("UPDATE reglement_achat set  id_client =".$fournisseur[$i].",numero='".$poUP."',date_reg = CAST('". $date_demande."' AS DATE),montant = ".$montant[$i].",libelle = '".$commentaire[$i]."' where id_caisse=".$IDCS->id_sortie."");
		

			}else {
				
				$insertionFMP  = $this->db->query("INSERT INTO reglement_achat value('',".$fournisseur[$i].",'".$poUP."',CAST('". $date_demande."' AS DATE),".$montant[$i].",'".$commentaire[$i]."')");
                       
			
			}
        }
				
				
              
				
            }
			
			
			
			 
	 if ($rjFR[$i] =='oui') {
		 
		 
	$queryD = $this->db->query("SELECT * FROM demande_bon_retour WHERE po_dem  = '". $po."' and vehicule = '".$camion1[$i]."' and fournisseur = ".$fournisseur[$i]." ")->row();	

	 if (count($queryD) >0 ) {
	   
	
	 }else{
		 
		 $query = $this->db->query("INSERT into demande_bon_retour value('','".$po."',CAST('". $date_demande."' AS DATE),'".$etat_demande."','LA DIRECTION','Frais Route',28,".$routeM[$i].",'".$camion1[$i]."',1833,50,".$destinationM[$i].",'RETOUR EN CAISSE FRAIS DIVERS','oui','".$rj1."','non',".$nbreLignes.",'".$rjFR[$i]."','non')");
 	  
	 }
		 
	  }
  
	  $i++; 
    }

        if ($query == true) {
            # code...
            echo "Modification parfaite de la demande de bon de caisse";
			
			  

            $this->notificationAjout($nom_table,addslashes($message2));

        }else{
            echo "erreur lors de l'insertion";
        }

    }else{
        echo "Erreur fatale contactez l'administrateur";
    }

$this->db->close();
}

public function selectAllDemandeCaisse(){
	
	
     $date = date('Y-m-d');
   
  
	if (isset($_POST["date_debut"]) && isset($_POST["date_fin"]) && isset($_POST["validite1"])) {
            # code...
        
		$date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $validite1 = $_POST['validite1'];
        


		if (!empty($date_fin) && !empty($date_debut) && isset($_POST["validite1"])) {

        
		if ($validite1 == 'TOUT') {
            # code...
         $query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,etat_dem,ordonateur,validite,camion,montant,vehicule,arrivee,operation,fournisseur,commentaire,rj,rj1,rj2,ligne, AFR, PRT,lieu from demande_bon where date_dem between '".$date_debut."' and '".$date_fin."' order by date_dem DESC")->result_array();
        
		}else {
			
		  $query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,etat_dem,ordonateur,validite,camion,montant,vehicule,arrivee,operation,fournisseur,commentaire,rj,rj1,rj2,ligne, AFR, PRT, lieu from demande_bon where validite = '".$validite1."' and date_dem between '".$date_debut."' and '".$date_fin."'  order by date_dem DESC ")->result_array();
			
		}	
		
		}else{
			
			$query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,etat_dem,ordonateur,validite,camion,montant,vehicule,arrivee,operation,fournisseur,commentaire,rj,rj1,rj2,ligne, AFR , PRT, lieu from demande_bon where date_dem = '".$date."' ORDER BY id_demande DESC")->result_array();    
        }		
		  
		}else{
			
			$query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,etat_dem,ordonateur,validite,camion,montant,vehicule,arrivee,operation,fournisseur,commentaire,rj,rj1,rj2,ligne, AFR, PRT, lieu from demande_bon where date_dem = '".$date."' ORDER BY id_demande DESC")->result_array();    
        }			
		
		if (count($query1) >0 ) {
            # code...
            $compteur = 0;
			 $compteur1 = 0;
			foreach ($query1 as $row) {
            $compteur1 = $compteur1 + $row['montant'] ;

            echo "<tr >
                    <td>".$compteur ."</td>
                    <td>".$row['date_dem']."</td>
                    <td>".$row['po_dem']."</td>
					<td>".$row['montant']."</td>
					<td>".$row['validite']."</td>            
                    <td>".$row['vehicule']."</td>
					<td>".$this->getOperationCaisse($row['operation'])."</td>";
					
					 $destination = $this->getDestinationCaisse($row['arrivee']);
					
				echo"	<td>".$destination."</td>";
					
					
					if ($row['validite'] == "Reglement Fournisseur Caisse") {
						
				    $fournisseur = $this->getFournisseurCaisse($row['fournisseur']);	
						
					}else if ($row['validite'] == "Reglement Fournisseur Article") {
						
					$fournisseur =$this->getFournisseurArticle($row['fournisseur']);	
						
					}else if ($row['validite'] == "Reglement Fournisseur Gazoil") { 				
					
					$fournisseur =$this->getFournisseurGazoil($row['fournisseur']);	
						
					}else if ($row['validite'] == "Reglement Fournisseur MIRA SA") {
										
					$fournisseur =$this->getFournisseurMatiere($row['fournisseur']);	
						
					}else if (($row['validite'] == "Autre") ||  ($row['validite'] == "Frais Route") ||  ($row['validite'] == "Frais Divers") ||  ($row['validite'] == "Prime") ||  ($row['validite'] == "Depannage") ||  ($row['validite'] == "Prevision Navire") ||  ($row['validite'] == "Retour Fournisseur") ||  ($row['validite'] == "Prevision Navire")) {
						
					$fournisseur = $this->getFournisseurCaisse($row['fournisseur']);	
						
					}
					
						echo "	<td>".$fournisseur."</td>";
					
					
					
                    $getOperation = $this->db->query("SELECT * FROM type_entreesortie where id_type = ".$row['camion']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_type']."</td>";
                        }
                    }
                    
                    echo"
                   
                  
					
					
                    <td>".$row['commentaire']." </td>
					
					<td>".$row['lieu']." </td>
					
					<td>".$row['PRT']." </td>
					
                    <td>";
                if($this->session->userdata('caisse_modification')=='true'){
					
						
						
						 $query = $this->db->query("SELECT rj,rj1 from demande_bon where po_dem = '".$row['po_dem']."' and rj= 'oui'  limit 1")->row(); 
						
						
						if (count($query) >0 ) {
							
						   if ($this->session->userdata('identifiant')=='SUPERVISEUR' || ($this->session->userdata('identifiant')=='nathan'))  {
						
                       echo" <button type='button' onclick='getDetailDemmandePourModification(\"".$row['date_dem']."\",\"".$row['po_dem']."\",\"".$row['etat_dem']."\",\"".$row['lieu']."\",\"".$row['rj']."\",\"".$row['rj1']."\",\"".$row['rj2']."\",\"".$row['ligne']."\" )'  class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
               
	                   echo"  <button type='button'   class=' btn-primary btn-sm' onclick='detailDemande(\"".$row['po_dem']."\",\"".$row['ordonateur']."\",\"".$row['date_dem']."\",\"".$row['etat_dem']."\",\"".number_format($row['montant'],0,',',' ')."\",\"".number_format($this->getMontantTotal($row['po_dem']),0,',',' ')."\",\"".$this->getSignatureDAFB($row['po_dem'])."\",\"".$this->getSignatureDGTB($row['po_dem'])."\",\"".number_format($this->getCompteurTotal($row['po_dem']),0,',',' ')."\",\"".$row['lieu']."\" )'><i class='nav-icon '>+</i></button>";
				                      

					  } 
					  
					 } else 	{

							if (($this->session->userdata('identifiant')=='SUPERVISEUR') || ($this->session->userdata('identifiant')=='CAISSE') || ($this->session->userdata('identifiant')=='nathan'))  {
				 
				 
				          echo" <button type='button' onclick='getDetailDemmandePourModification(\"".$row['date_dem']."\",\"".$row['po_dem']."\",\"".$row['etat_dem']."\",\"".$row['lieu']."\", \"".$row['rj']."\",\"".$row['rj1']."\",\"".$row['rj2']."\",\"".$row['ligne']."\" )'  class=' btn-primary btn-sm'><i class='nav-icon fas fa-edit'></i></button>";
               
                          
						  }   
							
						           }
						
					   
				 
				                                                            }


                if($this->session->userdata('demande_suppression')=='true'){
                  echo"  <button type='button' class=' btn-primary btn-sm' data-toggle='modal' data-target='#modal-primary' table='demande_bon' identifiant='".$row['po_dem']."' onclick='demandeSuppressionDocument($(this).attr(\"table\"),$(this).attr(\"identifiant\"),\"po_dem\");'><i class='far fa-trash-alt'></i></button>
                    </td>
                  </tr>

                  ";}
                  $compteur++;
			}
			
			  echo "<tr style='text-align:center; font-size: 12px; color:red;'>
             <td style='color:red;font-size: 20px;  font-weight: bold;'>TOTAUX</td>
           <td></td>
            <td></td>
             <td style='color:red;font-size: 20px;  font-weight: bold;'>".number_format($compteur1,0,',',' ')."</td>
           <td></td>
            <td></td>
           
           <td></td>
         
              <td></td>
          <td></td>
              <td></td>
			   <td></td>
            <td></td>
           
           <td></td>
        <td></td>
              
           </tr>";
			
			
		
		}

        $this->db->close();
    }
	
	public function selectAllDemandeCaisseRetour(){
	
	


   $date = date('Y-m-d');
   
  
	if (isset($_POST["date_debut"]) && isset($_POST["date_fin"]) && isset($_POST["validite1"])) {
            # code...
        
		$date_debut = $_POST['date_debut'];
        $date_fin = $_POST['date_fin'];
        $validite1 = $_POST['validite1'];
        


		if (!empty($date_fin) && !empty($date_debut) && isset($_POST["validite1"])) {

        
		if ($validite1 == 'TOUT') {
            # code...
         $query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,etat_dem,ordonateur,validite,camion,montant,vehicule,arrivee,operation,fournisseur,commentaire,rj,rj1,rj2,ligne, AFR, PRT from demande_bon_retour where date_dem between '".$date_debut."' and '".$date_fin."' order by date_dem DESC")->result_array();
        
		}else {
			
		  $query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,etat_dem,ordonateur,validite,camion,montant,vehicule,arrivee,operation,fournisseur,commentaire,rj,rj1,rj2,ligne, AFR, PRT from demande_bon_retour where validite = '".$validite1."' and date_dem between '".$date_debut."' and '".$date_fin."'  order by date_dem DESC ")->result_array();
			
		}	
		
		}else{
			
			$query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,etat_dem,ordonateur,validite,camion,montant,vehicule,arrivee,operation,fournisseur,commentaire,rj,rj1,rj2,ligne, AFR , PRT from demande_bon_retour where date_dem = '".$date."' ORDER BY id_demande DESC")->result_array();    
        }		
		  
		}else{
			
			$query1 = $this->db->query("SELECT  id_demande,po_dem,date_dem,etat_dem,ordonateur,validite,camion,montant,vehicule,arrivee,operation,fournisseur,commentaire,rj,rj1,rj2,ligne, AFR, PRT from demande_bon_retour where date_dem = '".$date."' ORDER BY id_demande DESC")->result_array();    
        }			
		
		if (count($query1) >0 ) {
            # code...
            $compteur = 0;
			foreach ($query1 as $row) {
            # code...

            echo "<tr >
                    <td>".$compteur ."</td>
                    <td>".$row['date_dem']."</td>
                    <td>".$row['po_dem']."</td>
					<td>".$row['montant']."</td>
					<td>".$row['validite']."</td>            
                    <td>".$row['vehicule']."</td>
					<td>".$this->getOperationCaisse($row['operation'])."</td>";
					
					 $destination = $this->getDestinationCaisse($row['arrivee']);
					
				echo"	<td>".$destination."</td>";
					
					
					if ($row['validite'] == "Reglement Fournisseur Caisse") {
						
				    $fournisseur = $this->getFournisseurCaisse($row['fournisseur']);	
						
					}else if ($row['validite'] == "Reglement Fournisseur Article") {
						
					$fournisseur =$this->getFournisseurArticle($row['fournisseur']);	
						
					}else if ($row['validite'] == "Reglement Fournisseur Gazoil") { 				
					
					$fournisseur =$this->getFournisseurGazoil($row['fournisseur']);	
						
					}else if ($row['validite'] == "Reglement Fournisseur MIRA SA") {
										
					$fournisseur =$this->getFournisseurMatiere($row['fournisseur']);	
						
					}else if (($row['validite'] == "Autre") ||  ($row['validite'] == "Frais Route") ||  ($row['validite'] == "Frais Divers") ||  ($row['validite'] == "Prime") ||  ($row['validite'] == "Depannage") ||  ($row['validite'] == "Prevision Navire") ||  ($row['validite'] == "Retour Fournisseur") ||  ($row['validite'] == "Prevision Navire")) {
						
					$fournisseur = $this->getFournisseurCaisse($row['fournisseur']);	
						
					}
					
						echo "	<td>".$fournisseur."</td>";
					
					
					
                    $getOperation = $this->db->query("SELECT * FROM type_entreesortie where id_type = ".$row['camion']."")->result_array();

                    if (count($getOperation)>0) {
                        # code...
                        foreach ($getOperation as $tab) {
                            # code...
                            echo"<td>".$tab['nom_type']."</td>";
                        }
                    }
                    
                    echo"
                   
                    <td> ".$row['ordonateur']."</td>
					
					<td>".$row['etat_dem']."</td>
					
					
                    <td>".$row['commentaire']." </td>
					
					
					<td>".$row['PRT']." </td>
					
                    <td>";
					
                if($this->session->userdata('caisse_modification')=='true'){
					
						
						
						 $query = $this->db->query("SELECT rj,rj1 from demande_bon_retour where po_dem = '".$row['po_dem']."' and rj= 'oui'  limit 1")->row(); 
						
						
						if (count($query) >0 ) {
							
						  
						
                     
	                   echo"  <button type='button'   class=' btn-primary btn-sm' onclick='detailDemandeRetour(\"".$row['po_dem']."\",\"".$row['ordonateur']."\",\"".$row['date_dem']."\",\"".$row['etat_dem']."\",\"".number_format($row['montant'],0,',',' ')."\",\"".number_format($this->getMontantTotalRetour($row['po_dem']),0,',',' ')."\",\"".$this->getSignatureDAFBR($row['po_dem'])."\",\"".$this->getSignatureDGTBR($row['po_dem'])."\",\"".number_format($this->getCompteurTotalR($row['po_dem']),0,',',' ')."\")'><i class='nav-icon '>+</i></button>";
						
						           }
						
					   
				 
				                                                            }

                  $compteur++;
			}
		
		}

        $this->db->close();
    }

	
	
	public function getMontantTotal($po){
    

    
	 $query1 = $this->db->query('SELECT * from demande_bon where po_dem = "'.$po.'"')->result_array();
    
	$totalFR = 0;

    foreach ($query1 as $row) {
        # code...
        $total1 = $row["montant"];
        $totalFR = $totalFR + $total1;
    }
	
	
    return $totalFR;

    $this->db->close();
}

	public function getMontantTotalRetour($po){
    

    
	 $query1 = $this->db->query('SELECT * from demande_bon_retour where po_dem = "'.$po.'"')->result_array();
    
	$totalFR = 0;

    foreach ($query1 as $row) {
        # code...
        $total1 = $row["montant"];
        $totalFR = $totalFR + $total1;
    }
	
	
    return $totalFR;

    $this->db->close();
}

public function getSignatureDAFB($po){
	
	
    $query1 = $this->db->query("SELECT * from demande_bon where rj = 'oui' and po_dem = '".$po."'")->result_array();
 
    $signature= "";
	
if (count($query1)>0) {
          
		  
	$signature = "<td><img src=http://192.168.1.5/miratransport/assets/image/signatureDAF.png></td>";	
          
        }

return $signature;

    $this->db->close();
}

public function getSignatureDAFBR($po){
	
	
    $query1 = $this->db->query("SELECT * from demande_bon_retour where rj = 'oui' and po_dem = '".$po."'")->result_array();
 
    $signature= "";
	
if (count($query1)>0) {
          
		  
	$signature = "<td><img src=http://192.168.1.5/miratransport/assets/image/signatureDAF.png></td>";	
          
        }

return $signature;

    $this->db->close();
}

public function getSignatureDGTB($po){
	
	
    $query1 = $this->db->query("SELECT * from demande_bon where  rj1 = 'oui' and po_dem = '".$po."'")->result_array();
 
    $signature= "";
	
if (count($query1)>0) {
          
		  
	$signature = "<td><img src=http://192.168.1.5/miratransport/assets/image/signatureDGT.png></td>";
          
        }

return $signature;

    $this->db->close();
}

public function getSignatureDGTBR($po){
	
	
    $query1 = $this->db->query("SELECT * from demande_bon_retour where  rj1 = 'oui' and po_dem = '".$po."'")->result_array();
 
    $signature= "";
	
if (count($query1)>0) {
          
		  
	$signature = "<td><img src=http://192.168.1.5/miratransport/assets/image/signatureDGT.png></td>";
          
        }

return $signature;

    $this->db->close();
}



public function getEtatPrint(){
	
	  $po = $_POST["po"];
	
	
    $query1 = $this->db->query("UPDATE demande_bon SET PRT = 'oui' where po_dem = '".$po."'");
 
  
  

    $this->db->close();
}

public function getEtatPrintR(){
	
	  $po = $_POST["po"];
	
	
    $query1 = $this->db->query("UPDATE demande_bon_retour SET PRT = 'oui' where po_dem = '".$po."'");
 
  
  

    $this->db->close();
}

public function getCompteurTotal($po){
    

    
	 $query1 = $this->db->query('SELECT count(*) as compteur from demande_bon where po_dem = "'.$po.'"')->row();
    
	$totalCP = 0;
	
	 if (count($query1)>0) {
                    # code...
					
					$totalCP = $query1->compteur;
	
                   
				 }
				 
    return $totalCP ;

    $this->db->close();
}


public function getCompteurTotalR($po){
    

    
	 $query1 = $this->db->query('SELECT count(*) as compteur from demande_bon_retour where po_dem = "'.$po.'"')->row();
    
	$totalCP = 0;
	
	 if (count($query1)>0) {
                    # code...
					
					$totalCP = $query1->compteur;
	
                   
				 }
				 
    return $totalCP ;

    $this->db->close();
}



public function getNbreLigne1(){
	
    $nbreLignes = $_POST["nbreLignes"];
    $i=1;
	
    while ( $i<= $nbreLignes) {
		
  echo '<div class="row">
  
  <div class="col-md-1">
  <div class="form-group">
  <label>N°</label>
                            <input type="text"class="form-control cpt'.$i.'" placeholder="" value = "'.$i.'" disabled="true" >

                 </div>
    </div>
	
	<div class="col-md-2">
                            <label>Type Sortie Caisse</label>
                           <select class="validite'.$i.' form-control" autocomplete="on" onchange ="getfournisseurDem($(\'.validite'.$i.'\').val(),\'fournisseur'.$i.'\',\'operation'.$i.'\',\'arrivee'.$i.'\',\'vehicule'.$i.'\');">
                            <option value=""></option>
							 <option value="Autre">Autre</option>
                             <option value="Frais Route">Frais Route</option>
							 <option value="Frais Divers">Frais Divers</option>
                             <option value="Prime">Prime</option>
							 <option value="Commission">Commission</option>
							 <option value="Depannage">Depannage</option>
							 <option value="Prevision Navire">Prevision Navire</option>
							 <option value="Reglement Fournisseur Caisse">Reglement Fournisseur Caisse</option>
							 <option value="Reglement Fournisseur Article">Reglement Fournisseur Article</option>
							 <option value="Reglement Fournisseur Gazoil">Reglement Fournisseur Gazoil</option>
							 <option value="Reglement Fournisseur MIRA SA">Reglement Fournisseur MIRA SA</option>
							 <option value="Retour Fournisseur">Retour Fournisseur</option>
							 ';
													
							echo ' </select>
						</div>


	<div class="col-md-2">
                          
                              <label>Type</label>
                              <select class="camion'.$i.' form-control">
							  <option value=""></option>';
                                $this->crud_model_caisse->leSelectCaisseSortie(); 
                              echo '</select>
                          
                    
                          </div>

    <div class="col-md-2">
                            <label>Montant</label>
                            <input type="text" class="form-control montant'.$i.'" placeholder=" en FCFA" onkeypress="chiffres(event);" onkeyup="totalCumLigne();">

                          </div>

	<div class="col-md-2">
                         
                              <label>Véhicule</label>
                              <select class="vehicule'.$i.' form-control" onchange="verifMatriculeInTabInput(\'vehicule'.$i.'\');" autocomplete="on" disabled="true">';
							   
                        		 $this->crud_model_caisse->leSelectEtatCodeCamionCaisse();  
								
                                echo ' </select>
                           
                    
                          </div>
						  
	<div class="col-md-3">
                             
                            <label>Opération</label>
                            <select class="operation'.$i.' form-control" autocomplete="on" disabled="true" onchange="">
                            ';
                              $this->crud_model_caisse->leSelectOperationSortieCaisse(); 
                                
                           echo '</select>
                         
                          </div>
						  
						  <div class="col-md-3">
                          
                              <label>Fournisseur</label>
                              <select class="fournisseur'.$i.' form-control" autocomplete="on" disabled="true">
							    <option value=""></option>'; 				
                        //       $this->crud_model_caisse->leSelectFournisseurCaisse2();
                             echo '  </select>
                         
                          </div>
						  
						  <div class="col-md-3">
						 
                            <label>Destination</label>
                            <select class="arrivee'.$i.' form-control" autocomplete="on" disabled="true" onchange="">
							 	';
                               $this->crud_model_caisse->getDestinationParCodeCamion2() ;
                             echo ' </select>
						
                          </div>

						  
						  <div class="col-md-5">
                          
							<label>Justification</label>
							 <input type="text" class=" commentaire'.$i.' form-control" placeholder="Pièces Justificatives" >
                          
                          
                          </div>	


						<div class="col-md-1">
                              <label>A. B.Caisse</label>
                              <input type="checkbox" class="form-control rjFR'.$i.'" disabled = "false" >
                          </div>
						  						  

					
						 <input type="hidden" class="form-control id_demande'.$i.'"  placeholder=" en FCFA" disabled="true" onkeypress="chiffres(event);">
                         <input type="hidden" class="form-control compteur'.$i.'"  placeholder=" en FCFA"  disabled="true" onkeypress="chiffres(event);">	  
                            						  
	</div>
 <hr>';
       $i++;
    
    }
	
	echo '<div class="row">
	
	
	<div class="col-md-3" >
                            <div class="form-group">
                            <label>TOTAL BON INTERNE</label>
                            <input type="text" class="totalLigne form-control" onkeypress="chiffres(event);" disabled = "true">
                             
                              
                             
                          </div>
    </div>
	
	

	<div class="col-md-1" >
	<br>
	
					    <button type="button"   class=" btn-primary btn-sm"  onclick="totalCumLigne();"><i class="fa fa-cog fa-fw" aria-hidden="true"></i></button>
                     
                             
                          </div>
    
	
	 </div>
  
  
 <hr>';

    $this->db->close();
}


public function getListeDemmandePourModif(){
    $po = $_POST["po"];
    $getAllCommande = $this->db->query("SELECT * from demande_bon where po_dem = '".$po."'")->result_array();
    $i=1;
    foreach ($getAllCommande as $com) {
        # code...
  
   
   echo '<div class="row">
   
    <div class="col-md-1">
  <div class="form-group">
  <label>Compteur</label>
                            <input type="text"class="form-control cpt'.$i.'" placeholder="" value = "'.$i.'" >

                 </div>
    </div> 
	
	<div class="col-md-2">
	<div class="form-group">
                            <label>Type Sortie Caisse</label>
                           <select class="validite'.$i.' form-control" autocomplete="on" onchange ="getfournisseurDem($(\'.validite'.$i.'\').val(),\'fournisseur'.$i.'\',\'operation'.$i.'\',\'arrivee'.$i.'\',\'vehicule'.$i.'\');">
                             ';
							echo "<option value='".$com['validite']."'>".$com['validite']."</option>";
							
							echo'<option value="Autre">Autre</option>
                             <option value="Frais Route">Frais Route</option>
							 <option value="Frais Divers">Frais Divers</option>
                             <option value="Prime">Prime</option>
							 <option value="Commission">Commission</option>
							 <option value="Depannage">Depannage</option>
							 <option value="Prevision Navire">Prevision Navire</option>
							 <option value="Reglement Fournisseur Caisse">Reglement Fournisseur Caisse</option>
							 <option value="Reglement Fournisseur Article">Reglement Fournisseur Article</option>
							 <option value="Reglement Fournisseur Gazoil">Reglement Fournisseur Gazoil</option>
							 <option value="Reglement Fournisseur MIRA SA">Reglement Fournisseur MIRA SA</option>
							 
							 <option value="Retour Caisse">Retour Caisse</option>
							 
							 <option value="Retour Fournisseur">Retour Fournisseur</option>';
													
							echo ' </select>
						</div>
						 </div>
	
  
   <div class="col-md-2">
                          
                              <label>Type</label>
                              <select class="camion'.$i.' form-control">';
						 $getTypeEntree = $this->db->query("SELECT * from type_entreesortie where id_type= ".$com["camion"]."")->row();
				
				if (count($getTypeEntree) > 0 ) {
					
					 echo "<option value='".$getTypeEntree->id_type."'>".$getTypeEntree->nom_type."</option>";
					 
				 } 	 
                                $this->crud_model_caisse->leSelectCaisseSortie(); 
                              echo '</select>
                          
                    
                          </div>

    <div class="col-md-2">
                            <label>Montant</label>
                            <input type="text" class="form-control montant'.$i.'" placeholder=" en FCFA" value= "'.$com["montant"].'" onkeypress="chiffres(event);" onkeyup="totalCumLigne();">

                          </div>

	<div class="col-md-2">
                         
                              <label>Véhicule</label>
                              <select class="vehicule'.$i.' form-control" autocomplete="on" disabled="true">';
							  
							 echo "<option value='".$com['vehicule']."'>".$com['vehicule']."</option>";
                        		 $this->crud_model_caisse->leSelectEtatCodeCamion();  
								
                                echo ' </select>
                           
                    
                          </div>
						  
	<div class="col-md-3">
                             
                            <label>Opération</label>
                            <select class="operation'.$i.' form-control" autocomplete="on" disabled="true" onchange="">';
							
							 $getOperation = $this->db->query("SELECT * from operation where id_operation= ".$com["operation"]."")->row();
				
				if (count($getOperation) > 0 ) {
					
					 echo "<option value='".$getOperation->id_operation."'>".$getOperation->nom_op."</option>";
					 
				 } 	 
                              $this->crud_model_caisse->leSelectOperationSortieCaisse(); 
                                
                           echo '</select>
                         
                          </div>
						  
						  <div class="col-md-3">
                          
                              <label>Fournisseur</label>
                              <select class="fournisseur'.$i.' form-control" autocomplete="on" disabled="true">';
							  
							    
								if ( ($com['validite']== "Reglement Fournisseur Caisse") or ($com['validite']== "Retour Fournisseur")){
								
								$getFournisseur = $this->db->query("SELECT * from fournisseur_caisse where id_fournisseur= ".$com["fournisseur"]."")->row();
				
				        if (count($getFournisseur) > 0 ) {
					
					 echo "<option value='".$getFournisseur->id_fournisseur."'>".$getFournisseur->nom."</option>";
					 
								} 	 

						}
						
						if ($com['validite']== "Reglement Fournisseur Article") {
								
								$getFournisseur = $this->db->query("SELECT * from fournisseur_article where id_fournisseur= ".$com["fournisseur"]."")->row();
				
				        if (count($getFournisseur) > 0 ) {
					
					 echo "<option value='".$getFournisseur->id_fournisseur."'>".$getFournisseur->nom."</option>";
					 
								} 	 

						}
						
						if ($com['validite']== "Reglement Fournisseur Gazoil") {
								
								$getFournisseur = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur= ".$com["fournisseur"]."")->row();
				
				        if (count($getFournisseur) > 0 ) {
					
					 echo "<option value='".$getFournisseur->id_fournisseur."'>".$getFournisseur->nom."</option>";
					 
								} 	 

						}
						
							if ($com['validite']== "Reglement Fournisseur MIRA SA") {
								
								$getFournisseur = $this->db->query("SELECT * from fournisseur_matiere where id_fournisseur= ".$com["fournisseur"]."")->row();
				
				        if (count($getFournisseur) > 0 ) {
					
					 echo "<option value='".$getFournisseur->id_fournisseur."'>".$getFournisseur->nom."</option>";
					 
								} 	 

						}
						
					if (($com['validite']== "Autre") || ($com['validite'] == "Frais Divers")  || ($com['validite'] == "Frais Route") || ($com['validite'] == "Prime") || ($com['validite'] == "Commission") || ($com['validite'] == "Depannage") || ($com['validite'] == "Prevision Navire")) {
								
								$getFournisseur = $this->db->query("SELECT * from fournisseur_caisse where id_fournisseur= ".$com["fournisseur"]."")->row();
				
				        if (count($getFournisseur) > 0 ) {
					
					 echo "<option value='".$getFournisseur->id_fournisseur."'>".$getFournisseur->nom."</option>";
					 
								} 	 

						}
						
						
						
                        
							   
                             echo ' </select>
                         
                          </div>
						  
						  <div class="col-md-3">
						 
                            <label>Destination</label>
                            <select class="arrivee'.$i.' form-control" autocomplete="on" disabled="true" onchange="">';
							
							 $getOperation = $this->db->query("SELECT * from distance_littrage where id_distance= ".$com["arrivee"]."")->row();
				
				if (count($getOperation) > 0 ) {
					
					 echo "<option value='".$getOperation->id_distance."'>".$getOperation->distance."</option>";
					 
				 } 	 
                               $this->crud_model_caisse->getDestinationParCodeCamion2(); 
                             echo ' </select>
						
                          </div>

						  
						  <div class="col-md-5">
                          
							<label>Justification</label>
                          <input type="text" class="form-control commentaire'.$i.'" placeholder=" en FCFA" value= "'.$com["commentaire"].'"  >
  
                          </div>';


                        		if ($com["AFR"] == "oui") {
						echo' <div class="col-md-1">
                              <label>A. B.Caisse</label>
                              <input type="checkbox" class="form-control rjFR'.$i.'" checked = "true">
                          </div> ';
						  
					}else {
						
						echo' <div class="col-md-1">
                              <label>A. B.Caisse</label>
                              <input type="checkbox" class="form-control rjFR'.$i.'" >
                          </div> ';
						
					}						  

					
					echo '	
						 <input type="hidden" class="form-control id_demande'.$i.'"  placeholder=" en FCFA" value="'.$com["id_demande"].'" disabled="true" onkeypress="chiffres(event);">
                         <input type="hidden" class="form-control compteur'.$i.'"  placeholder=" en FCFA"  disabled="true" onkeypress="chiffres(event);"> 
						 
						 
						

						 
                            	
	 </div>	
				
       <hr>';
       $i++;
      }
	  
      $i = $i-1;
	  
      echo '<input type="hidden" class="form-control compteur"  placeholder=" en FCFA" value="'.$i.'" disabled="true" onkeypress="chiffres(event);">';

      echo '<div class="row">
	
	
	<div class="col-md-3" >
                            <div class="form-group">
                            <label>TOTAL BON INTERNE DE CAISSE</label>
                            <input type="text" class="totalLigne form-control" onkeypress="chiffres(event);" disabled = "true">
                             
                              
                             
                          </div>
    </div>
	
	<div class="col-md-1" >
	<br>
	
					    <button type="button"   class=" btn-primary btn-sm"  onclick="totalCumLigne();"><i class="fa fa-cog fa-fw" aria-hidden="true"></i></button>
                     
                             
                          </div>
	
	
	
	
	
	 </div>
  
  
 <hr>';
	  
	  
	  $this->db->close();
}


public function getDetailDemande(){
    $po = $_POST["po"];
	
	
	  $query2 = $this->db->query("SELECT rj,rj1 from demande_bon where po_dem = '".$po."' and (rj= 'oui' or rj1 ='oui') limit 1")->row(); 
	  
	  
	  if (count($query2) >0 ) {
				 
				
					 
					$query1 = $this->db->query('SELECT * from demande_bon where po_dem ="'.$po.'" order by id_demande')->result_array();
          $compteur = 0;
		  $compteur1 = 0;
		  $compteur2 = 0;
        foreach ($query1 as $row) {
            # code...
		$compteur1 = 0;
		
				    
					
					$getOperation = $this->db->query("SELECT * FROM operation where id_operation = ".$row['operation']."")->row();
				
				
				   $getDestination = $this->db->query("SELECT * FROM distance_littrage where id_distance = ".$row['arrivee']."")->row();
				   
				   
				 
				 			 if (($row['validite']== "Reglement Fournisseur Caisse") or ($row['validite']== "Retour Fournisseur")) {
								
								$getFournisseur = $this->db->query("SELECT * from fournisseur_caisse where id_fournisseur= ".$row["fournisseur"]."")->row();
				
				      
						}
						
						if ($row['validite']== "Reglement Fournisseur Article") {
								
								$getFournisseur = $this->db->query("SELECT * from fournisseur_article where id_fournisseur= ".$row["fournisseur"]."")->row();
				
				     
						}
						
						if ($row['validite']== "Reglement Fournisseur Gazoil") {
								
								$getFournisseur = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur= ".$row["fournisseur"]."")->row();
				
				      

						}
						
							if ($row['validite']== "Reglement Fournisseur MIRA SA") {
								
								$getFournisseur = $this->db->query("SELECT * from fournisseur_matiere where id_fournisseur= ".$row["fournisseur"]."")->row();
				

						}
						
							if (($row['validite']== "Autre") || ($row['validite'] == "Frais Divers") || ($row['validite'] == "Frais Route") || ($row['validite'] == "Prime") || ($row['validite'] == "Commission") || ($row['validite'] == "Depannage") || ($row['validite'] == "Prevision Navire")) {
								
								$getFournisseur = $this->db->query("SELECT * from fournisseur_caisse where id_fournisseur= ".$row["fournisseur"]."")->row();
				
				     

						}
						
				 
		
            echo "<tr style='border:none; text-align:center;font-size: 13px;font-weight:10px;padding:0px;'>
                    

                  
					
					<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px ; text-align:center;padding:0px;font-weight:10px' >".$row['validite']."</td>
					
					<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px; text-align:center;padding:0px;font-weight:10px' >".$row['vehicule']."</td>
					
					 <td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px ; text-align:center;padding:0px;font-weight:10px'>".$getOperation->nom_op."</td>
					 	
						<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px; text-align:center;padding:0px;font-weight:10px'>".$getFournisseur->nom."</td>
					
					<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px ; text-align:center;padding:0px;font-weight:10px' >".$getDestination->distance."</td>

                           
							
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px  ; text-align:center;padding:0px;font-weight:10px'>".$row['montant']."</td>
							
							<td colspan = '4' style='border-bottom: 1px solid black;border-left: 1px solid black ;border-right: 1px solid black;  text-align:center;padding:0px;font-weight:10px'>".$row['commentaire']."</td>";

						
		       
                    
                  $compteur++;
        } 
					 
					}else{
						
						
        echo "Demande de Bon Interne de Caisse non confirmé par les administrateurs";
    }
	
         

        $this->db->close();
    }
	

 
 public function getDetailDemandeRetour(){
    $po = $_POST["po"];
	
	
	  $query2 = $this->db->query("SELECT rj,rj1 from demande_bon_retour where po_dem = '".$po."' and (rj= 'oui' or rj1 ='oui') limit 1")->row(); 
	  
	  
	  if (count($query2) >0 ) {
				 
				
					 
					$query1 = $this->db->query('SELECT * from demande_bon_retour where po_dem ="'.$po.'" order by id_demande')->result_array();
					
          $compteur = 0;
		  $compteur1 = 0;
		  $compteur2 = 0;
        foreach ($query1 as $row) {
            # code...
		$compteur1 = 0;
		
				    
					
					$getOperation = $this->db->query("SELECT * FROM operation where id_operation = ".$row['operation']."")->row();
				
				
				   $getDestination = $this->db->query("SELECT * FROM distance_littrage where id_distance = ".$row['arrivee']."")->row();
				   
				   
				 
				 			 if (($row['validite']== "Reglement Fournisseur Caisse") or ($row['validite']== "Retour Fournisseur")) {
								
								$getFournisseur = $this->db->query("SELECT * from fournisseur_caisse where id_fournisseur= ".$row["fournisseur"]."")->row();
				
				      
						}
						
						if ($row['validite']== "Reglement Fournisseur Article") {
								
								$getFournisseur = $this->db->query("SELECT * from fournisseur_article where id_fournisseur= ".$row["fournisseur"]."")->row();
				
				     
						}
						
						if ($row['validite']== "Reglement Fournisseur Gazoil") {
								
								$getFournisseur = $this->db->query("SELECT * from fournisseur_gazoil where id_fournisseur= ".$row["fournisseur"]."")->row();
				
				      

						}
						
							if ($row['validite']== "Reglement Fournisseur MIRA SA") {
								
								$getFournisseur = $this->db->query("SELECT * from fournisseur_matiere where id_fournisseur= ".$row["fournisseur"]."")->row();
				

						}
						
							if (($row['validite']== "Autre") || ($row['validite'] == "Frais Divers") || ($row['validite'] == "Frais Route") || ($row['validite'] == "Frais Retour") || ($row['validite'] == "Prime") || ($row['validite'] == "Commission") || ($row['validite'] == "Depannage") || ($row['validite'] == "Prevision Navire")) {
								
								$getFournisseur = $this->db->query("SELECT * from fournisseur_caisse where id_fournisseur= ".$row["fournisseur"]."")->row();
				
				     

						}
						
				 
		
            echo "<tr style='border:none; text-align:center;font-size: 13px;font-weight:10px;padding:0px;'>
                    

                    <td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px' >".$row['po_dem']."</td>
					
					<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px' >".$row['validite']."</td>
					
					<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px' >".$row['vehicule']."</td>
					
					 <td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;'>".$getOperation->nom_op."</td>
					 	
						<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;'>".$getFournisseur->nom."</td>
					
					<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px' >".$getDestination->distance."</td>

                           
							
							<td style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:16px'>".$row['montant']."</td>
							
							<td colspan = '3' style='border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black; text-align:center;padding:0px;font-weight:10px'>".$row['commentaire']."</td>";

						
		       
                    
                  $compteur++;
        } 
					 
					}else{
						
						
        echo "Demande de Bon Interne de Caisse non confirmé par les administrateurs";
    }
	
         

        $this->db->close();
    }
	
 }

