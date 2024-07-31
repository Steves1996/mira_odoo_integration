

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
  <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"></a>
        <button onclick="window.location='<?php echo base_url() ?>admin/administration'" style="height: 50px; width: 120px;" class="menu_boutton btn btn-white btn-primary btn-bold"><i class="fas fa-reply"></i> Accueil</button>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
     
      
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> 
      
    </ul>
  </nav>
  <!-- /.navbar -->





  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url(); ?>" class="brand-link">
      <img src="<?php echo base_url(); ?>assets/image/logo.jpg" alt="AdminLTE Logo" class="brand-image  elevation-3"
           style="opacity: .9; margin-left: -5px;">
      <!-- <span class="brand-text font-weight-light">Société MIRA</span> -->
    </a>
    <br>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo base_url(); ?>assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
          	<?php 
          	if($this->session->userdata('identifiant')!=null){
				   echo $this->session->userdata('identifiant');
				  }else{
				  	echo"pas connecté";
				  }
          	?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview ">
            <a href="<?php echo base_url(); ?>admin/administration" class="nav-link <?php
            if (isset($dashboard)){
            	echo 'active';
            }
            	 ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                DASHBOARD
              </p>
            </a> 
          </li>
          
        <?php
        
		if($this->session->userdata('mira_sa_modification')!=null){

          echo'<li class="nav-item has-treeview ';
            if (isset($ouvertFournisseurMatiere)){
              echo 'menu-open';
            }
               echo'">
            <a href="#" class="nav-link ';
            if (isset($activeFournisseurMatiere)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-users"></i>
              <p>
               MIRA S.A
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/fournisseurMatiere" class="nav-link ';
            if (isset($fournisseurMatiere)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-user"></i>
              <p>
                FOURNISSEUR
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
		
        <!--  <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/factureFournisseurMatiere" class="nav-link ';
            if (isset($factureMatiere)){
              echo 'active';
            }
               echo'">
             <i class="nav-icon fas fa-file"></i>
              <p>
                FACTURE
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> 
              </p>
            </a>
        </li> -->
		  <li class="nav-item">
                <a href="'.base_url().'admin/fraisAchat" class="nav-link ';
            if (isset($fraisAchat)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-dollar-sign"></i>
                  <p>FACTURE ACHAT</p>
                </a>
              </li>
        <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/reglementFournisseurMatiere" class="nav-link ';
            if (isset($reglementMatiere)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                REGLEMENT ACHAT
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
     <!--   <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/balanceFournisseurMatiere" class="nav-link ';
            if (isset($balanceFournisseurMatiere)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>
                Balance
               
              </p>
            </a>
        </li>  -->
		<li class="nav-item has-treeview">
            <a href="'.base_url().'admin/balanceImprimeFournisseurMatiere" class="nav-link ';
            if (isset($balanceImprimeFournisseurMatiere)){
              echo 'active';
            }
              echo'">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>
                RELEVE FOURNISSEUR
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
		
	<!--	<li class="nav-item has-treeview">
            <a href="'.base_url().'admin/clientMP" class="nav-link ';
            if (isset($clientMP)){
              echo 'active';
            }
              echo'">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>
                Client
              
              </p>
            </a>
        </li> -->
		
		<li class="nav-item has-treeview">
            <a href="'.base_url().'admin/fraisVente" class="nav-link ';
            if (isset($fraisVente)){
              echo 'active';
            }
              echo'">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>
                FACTURE CLIENT
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
		
		   <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/reglementClientMP" class="nav-link ';
            if (isset($reglementClientMP)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                REGLEMENT CLIENT
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
		
			<li class="nav-item has-treeview">
            <a href="'.base_url().'admin/balanceImprimeClientMatiere" class="nav-link ';
            if (isset($balanceImprimeClientMatiere)){
              echo 'active';
            }
              echo'">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>
                RELEVE CLIENT
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
			</li>
			
			<li class="nav-item">
                <a href="'.base_url().'admin/controle_frais" class="nav-link ';
            if (isset($controle_frais)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-dollar-sign"></i>
                  <p>CONTROLE FRAIS ROUTE</p>
                </a>
              </li>
		
		
            </ul>
          </li>';}
		

        
     
        if($this->session->userdata('chauffeur_modification')!=null){

        echo ' <li class="nav-item has-treeview ';
            if (isset($ouvertChauffeur)){
              echo 'menu-open';
            }
              echo'">
            <a href="#" class="nav-link ';
            if (isset($activeChauffeur)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-user"></i>
              <p>
               GESTION CHAUFFEURS
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
         
        <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/imputationChauffeur" class="nav-link ';
            if (isset($imputationChauffeur)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>
                IMPUTATION
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/cumulimputationChauffeur" class="nav-link ';
            if (isset($cumulimputationChauffeur)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>
                CUMUL IMPUTATION
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/reglementImputation" class="nav-link ';
            if (isset($reglementImputation)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>
               REGLEMENT
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview"> 
            <a href="'.base_url().'admin/paieChauffeur" class="nav-link ';
            if (isset($paieChauffeur)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>
                COUPURE SALAIRE & GPS
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview"> 
            <a href="'.base_url().'admin/paie" class="nav-link ';
            if (isset($paie)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>
                PAIE EMPLOYE
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>

       <li class="nav-item has-treeview"> 
            <a href="'.base_url().'admin/balanceChauffeur" class="nav-link ';
            if (isset($balanceChauffeur)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                BALANCE
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        
            </ul>
          </li>';}

  if($this->session->userdata('vehicule_modification')!=null){

       echo' <li class="nav-item has-treeview ';
            if (isset($ouvert)){
            	echo 'menu-open';
            }
            	 echo'">
            <a href="#" class="nav-link ';
            if (isset($activeCamion)){
            	echo 'active';
            }
            	 echo'">
              <i class="nav-icon fas fa-truck"></i>
              <p>
                GESTION VEHICULES
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/document" class="nav-link ';
            if (isset($document)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                DOCUMENTS
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
         <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/chauffeur" class="nav-link ';
            if (isset($chauffeur)){
              echo 'active';
            }
              echo'">
              <i class="nav-icon fas fa-user"></i>
              <p>
                CHAUFFEUR
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
              <li class="nav-item">
                <a href="'.base_url().'admin/type_vehicule" class="nav-link ';
            if (isset($type_vehicule)){
              echo 'active';
            }
               echo'">
                  <i class="far fa-circle nav-icon"></i>
                  <p>TYPE VEHICULE</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="'.base_url().'admin/remorque" class="nav-link ';
            if (isset($remorque)){
              echo 'active';
            }
               echo'">
                  <i class="far fa-circle nav-icon"></i>
                  <p>REMORQUE</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="'.base_url().'admin/tracteur" class="nav-link ';
            if (isset($tracteur)){
            	echo 'active';
            }
            	 echo'">
                  <i class="nav-icon fas fa-tractor"></i>
                  <p>TRACTEUR</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="'.base_url().'admin/camionBenne" class="nav-link ';
            if (isset($camionBenne)){
            	echo 'active';
            }
            	 echo'">
                  <i class="nav-icon fas fa-truck-monster"></i>
                  <p>CAMION BENNE</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="'.base_url().'admin/engin" class="nav-link ';
            if (isset($engin)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-tractor"></i>
                  <p>ENGIN</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="'.base_url().'admin/vraquier" class="nav-link ';
            if (isset($vraquier)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-tractor"></i>
                  <p>VRAQUIER</p>
                </a>
              </li>
			  
			    
              
              <li class="nav-item">
                <a href="'.base_url().'admin/accident" class="nav-link ';
            if (isset($accident)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-tractor"></i>
                  <p>ACCIDENT</p>
                </a>
              </li>
			  
			   <li class="nav-item">
                <a href="'.base_url().'admin/voitureService" class="nav-link ';
            if (isset($voitureService)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-tractor"></i>
                  <p>VOITURE DE SERVICE</p>
                </a>
              </li>
			  
			  <li class="nav-item">
                <a href="'.base_url().'admin/distance_parcourue" class="nav-link ';
            if (isset($distance_parcourue)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-road"></i>
                  <p>DISTANCE PARCOURUE</p>
                </a>
              </li>
              
            </ul>
          </li>';
        }

      // rapport
	  
	       if($this->session->userdata('parametres_modification')!=null){

        
			  echo'<li class="nav-item has-treeview ';
            if (isset($ourvertParametres)){
              echo 'menu-open';
            }
               echo'">
            <a href="#" class="nav-link ';
            if (isset($activeParametres)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-oil-can"></i>
              <p>
                PARAMETRES
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
			
			 
			   <li class="nav-item">
                <a href="'.base_url().'admin/distanceRecette" class="nav-link ';
            if (isset($distance)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fas fa-gas-pump"></i>
                  <p>KM - LITRE</p>
                </a>
              </li>
			  
			  <li class="nav-item">
                <a href="'.base_url().'admin/distanceRecetteUpdate" class="nav-link ';
            if (isset($distance1)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fas fa-gas-pump"></i>
                  <p>KM - LITRE - UPDATE</p>
                </a>
              </li>
			  
			  
			  </ul>
          </li>';} 
            

        if($this->session->userdata('demande_modification')!=null){

        
			  echo'<li class="nav-item has-treeview ';
            if (isset($ourvertFrais)){
              echo 'menu-open';
            }
               echo'">
            <a href="#" class="nav-link ';
            if (isset($activeDemandeFrais)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-oil-can"></i>
              <p>
                GESTION FRAIS ROUTE
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
			
			 <li class="nav-item ">
            <a href="'.base_url().'admin/clientFrais" class="nav-link ';
            if (isset($clientFrais)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>
                CLIENT
                
              </p>
            </a>
        </li>
         <!-- 
           <li class="nav-item">
                <a href="'.base_url().'admin/marchandiseFrais" class="nav-link ';
            if (isset($marchandiseFrais)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>MARCHANDISE</p>
                </a>
              </li>
			     -->  
			  
			  <li class="nav-item">
                <a href="'.base_url().'admin/demande_frais" class="nav-link ';
            if (isset($demande_frais)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>DEMANDE FRAIS</p>
                </a>
              </li>
			  
			  
			  </ul>
          </li>';} 
			  
			 
            
			
			   if($this->session->userdata('vidange_modification')!=null){

          echo'<li class="nav-item has-treeview ';
            if (isset($ouvert3)){
              echo 'menu-open';
            }
               echo'">
            <a href="#" class="nav-link ';
            if (isset($activeVidange)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-oil-can"></i>
              <p>
                STOCK HUILE
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
			
			 <li class="nav-item ">
            <a href="'.base_url().'admin/type_huile" class="nav-link ';
            if (isset($type_huile)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>
                TYPE HUILE
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
             
           <li class="nav-item">
                <a href="'.base_url().'admin/inventaireHuile" class="nav-link ';
            if (isset($inventaireHuile)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>STOCK INITIAL</p>
                </a>
              </li>
			  
			  
			     <li class="nav-item">
                <a href="'.base_url().'admin/approvisionnementHuile" class="nav-link ';
            if (isset($approvisionnementHuile)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>APPROVISIONEMENT</p>
                </a>
              </li>
              
              
            <li class="nav-item">
                <a href="'.base_url().'admin/Vidange" class="nav-link ';
            if (isset($vidange)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>SORTIE MOTEUR</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="'.base_url().'admin/boiteVitesse" class="nav-link ';
            if (isset($boite)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-cog"></i>
                  <p>SORTIE BOITE VITESSE</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="'.base_url().'admin/hydrolique" class="nav-link ';
            if (isset($hydrolique)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-oil-can"></i>
                  <p>SORTIE HYDROLIQUE</p>
                </a>
              </li>
			  
			  <li class="nav-item">
                <a href="'.base_url().'admin/graisse" class="nav-link ';
            if (isset($graisse)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-oil-can"></i>
                  <p>SORTIE GRAISSE</p>
                </a>
              </li>
			  
			     <li class="nav-item">
                <a href="'.base_url().'admin/stockHuile" class="nav-link ';
            if (isset($stocktHuile)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>INVENTAIRE</p>
                </a>
              </li>
			  
            </ul>
          </li>';} 
		  
		  
	           if($this->session->userdata('operation_gazoil_modification')!=null){

        echo'  <li class="nav-item has-treeview ';
            if (isset($ouvertOperationGazoil)){
              echo 'menu-open';
            
            }
               echo'">
            <a href="#" class="nav-link ';
            if (isset($activeOperationGazoil)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-gas-pump"></i>
              <p>
                STOCK GASOIL
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
            
			
			<li class="nav-item">
                <a href="'.base_url().'admin/demande_gazoil" class="nav-link ';
            if (isset($demande_gazoil)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>DEMANDE GAZOIL</p>
                </a>
              </li>
			  
			  
			  <li class="nav-item">
                <a href="'.base_url().'admin/demande_navette" class="nav-link ';
            if (isset($demande_navette)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>DEMANDE GAZOIL NV PZ</p>
                </a>
              </li>
			  
			  <li class="nav-item">
                <a href="'.base_url().'admin/demande_navette_pouzz" class="nav-link ';
            if (isset($demande_navette_pouzz)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>DEMANDE GAZOIL NV AT</p>
                </a>
              </li>
			  
			   <li class="nav-item">
                <a href="'.base_url().'admin/demande_engin" class="nav-link ';
            if (isset($demande_engin)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>DEMANDE GAZOIL ENGIN</p>
                </a>
              </li>
			  
			<li class="nav-item ">
                <a href="'.base_url().'admin/stock_vehicule" class="nav-link ';
            if (isset($stock_vehicule)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-gas-pump"></i>
                  <p>STOCK VEHICULE</p>
                </a>
            </li>
			
			
			<li class="nav-item ">
                <a href="'.base_url().'admin/inventaireGazoil" class="nav-link ';
            if (isset($inventaireGazoil)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-gas-pump"></i>
                  <p>STOCK INITIAL</p>
                </a>
            </li>
			
			  
			<li class="nav-item ">
                <a href="'.base_url().'admin/approvisionnementGazoil" class="nav-link ';
            if (isset($approvisionnementGazoil)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-gas-pump"></i>
                  <p>APPROVISIONEMENT</p>
                </a>
            </li>			
          
            <li class="nav-item ">
                <a href="'.base_url().'admin/gazoil" class="nav-link ';
            if (isset($gazoil)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-gas-pump"></i>
                  <p>SORTIE</p>
                </a>
              </li>
			  
			 	<li class="nav-item ">
                <a href="'.base_url().'admin/stockGazoil" class="nav-link ';
            if (isset($stockGazoil)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-gas-pump"></i>
                  <p>INVENTAIRE</p>
                </a>
            </li>

		   <!--	<li class="nav-item ">
                <a href="'.base_url().'admin/inventaireGazoil" class="nav-link ';
            if (isset($inventaireGazoil)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-gas-pump"></i>
                  <p>inventaire Gazoil Externe</p>
                </a>
            </li>

			<li class="nav-item ">
                <a href="'.base_url().'admin/approvisionnementGazoil" class="nav-link ';
            if (isset($approvisionnementGazoil)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-gas-pump"></i>
                  <p>Approvisionnement Gazoil Externe</p>
                </a>
            </li>

			<li class="nav-item ">
                <a href="'.base_url().'admin/stockGazoil" class="nav-link ';
            if (isset($stockGazoil)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-gas-pump"></i>
                  <p>Stock Gazoil Externe</p>
                </a>
            </li> -->
			
			  

              
        
            </ul>
          </li>
          
        <!--  -->';
      }		

  if($this->session->userdata('stock_modification')!=null){

       echo' <li class="nav-item has-treeview ';
            if (isset($ouvertStock)){
              echo 'menu-open';
            }
               echo'">
            <a href="#" class="nav-link ';
            if (isset($activeGestionStock)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-database"></i>
              <p>
                STOCK PIECES
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
			
			   <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/categorieArticle" class="nav-link ';
            if (isset($categorieArticle)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                CATEGORIE ARTICLE
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
           </li>
			
			 <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/article" class="nav-link ';
            if (isset($article)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                ARTICLES
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
          </li>
		  
		  
		
              <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/inventaire" class="nav-link ';
            if (isset($inventaire)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-file"></i>
              <p>
                STOCK INITIAL
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
         <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/approvisionnement" class="nav-link ';
            if (isset($approvisionnement)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-download"></i>
              <p>
                APPROVISIONEMENT
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
		
		  <li class="nav-item">
                <a href="'.base_url().'admin/pieceRechange" class="nav-link ';
            if (isset($pieceRechange)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-wrench"></i>
                  <p>SORTIE</p>
                </a>
              </li>
			  
        <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/defectueux" class="nav-link ';
            if (isset($defectueux)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                DEFECTUEUX
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/stock" class="nav-link ';
            if (isset($stock)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-database"></i>
              <p>
                INVENTAIRE
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        
     <!--   <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/stockvaleur" class="nav-link ';
            if (isset($stockvaleur)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-database"></i>
              <p>
                VALEUR STOCK
                 <i class="fas fas fa-dollar-sign"></i>
                <span class="badge badge-info right">6</span> 
              </p>
            </a>
        </li> -->
       
            </ul>
          </li>';}
		  
	  if($this->session->userdata('pneu_modification')!=null){

        echo'  <li class="nav-item has-treeview ';
            if (isset($ouvertPneu)){
              echo 'menu-open';
            }
               echo'">
            <a href="#" class="nav-link ';
            if (isset($pneu)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-dot-circle"></i>
              <p>
                STOCK PNEU
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
			 
			 <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/marquePneu" class="nav-link ';
            if (isset($marquePneu)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-dot-circle"></i>
              <p>
                MARQUE
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
           </li>
		   
		   <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/typePneu" class="nav-link ';
            if (isset($typePneu)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-dot-circle"></i>
              <p>
               TYPE
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
           </li>
			
			
              <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/pneu" class="nav-link ';
            if (isset($insertPneu)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-dot-circle"></i>
              <p>
                PNEU
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
		
		   <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/inventairePneu" class="nav-link ';
            if (isset($inventairePneu)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-file"></i>
              <p>
                STOCK INITIAL
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
		
			<li class="nav-item has-treeview">
            <a href="'.base_url().'admin/approvisionnementPneu" class="nav-link ';
            if (isset($approvisionnementPneu)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-download"></i>
              <p>
                APPROVISIONEMENT
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
		
         <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/depensePneu" class="nav-link ';
            if (isset($depensePneu)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-dot-circle"></i>
              <p>
                SORTIE PNEUMATIQUE
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
      
        <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/stockPneu" class="nav-link ';
            if (isset($stockPneu)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-database"></i>
              <p>
                INVENTAIRE
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
    	
            </ul>
          </li>
          
        <!--  -->';}


if($this->session->userdata('document_modification')!=null){

     echo' <li class="nav-item has-treeview ';
            if (isset($ouvertFournisseurDocument)){
              echo 'menu-open';
            }
               echo'">
            <a href="#" class="nav-link ';
            if (isset($activeFournisseurDocument)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-database"></i>
              <p>
                FOURNISSEUR DOCS ADM
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              
              <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/fournisseurDocument" class="nav-link ';
            if (isset($fournisseurDocument)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-user"></i>
              <p>
                FOURNISSEUR
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
         <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/factureFournisseurDocument" class="nav-link ';
            if (isset($factureDocument)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-file"></i>
              <p>
                FACTURE
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
         <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/reglementFournisseurDocument" class="nav-link ';
            if (isset($reglementDocument)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                REGLEMENT
                
              </p>
            </a>
        </li> 
       <!-- <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/balanceFournisseurDocument" class="nav-link ';
            if (isset($balanceFournisseurDocument)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>
                BALANCE
                 <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span>
              </p>
            </a>
        </li> -->
        
      

        <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/rapportFactureDocument" class="nav-link ';
            if (isset($rapportFactureDocument)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-file"></i>
              <p>
                RAPPORT FACTURE
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
		
		<li class="nav-item has-treeview">
            <a href="'.base_url().'admin/balanceImprimeFournisseurDocument" class="nav-link ';
            if (isset($balanceImprimeFournisseurDocument)){
              echo 'active';
            }
              echo'">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>
                RELEVE FOURNISSEUR
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
			</li>
        
            </ul>
          </li>';}
		


if($this->session->userdata('article_modification')!=null){

     echo' <li class="nav-item has-treeview ';
            if (isset($ouvertFournisseurArticle)){
              echo 'menu-open';
            }
               echo'">
            <a href="#" class="nav-link ';
            if (isset($activeFournisseurArticle)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-database"></i>
              <p>
                FOURNISSEUR PIECES
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              
              <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/fournisseurArticle" class="nav-link ';
            if (isset($fournisseurArticle)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-user"></i>
              <p>
                FOURNISSEUR
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
         <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/factureFournisseurArticle" class="nav-link ';
            if (isset($factureArticle)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-file"></i>
              <p>
                FACTURE
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
         <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/reglementFournisseurArticle" class="nav-link ';
            if (isset($reglementArticle)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                REGLEMENT
                
              </p>
            </a>
        </li> 
       <!-- <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/balanceFournisseurArticle" class="nav-link ';
            if (isset($balanceFournisseurArticle)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>
                BALANCE
                 <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span>
              </p>
            </a>
        </li> -->
        
       <!-- <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/clotureArticle" class="nav-link ';
            if (isset($clotureArticle)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-times"></i>
              <p>
               CLOTURE
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> 
              </p>
            </a>
        </li> -->

        <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/rapportFactureArticle" class="nav-link ';
            if (isset($rapportFactureArticle)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-file"></i>
              <p>
                RAPPORT FACTURE
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
		
		<li class="nav-item has-treeview">
            <a href="'.base_url().'admin/balanceImprimeFournisseurArticle" class="nav-link ';
            if (isset($balanceImprimeFournisseurArticle)){
              echo 'active';
            }
              echo'">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>
                RELEVE FOURNISSEUR
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
			</li>
        
            </ul>
          </li>';}





if($this->session->userdata('fournisseur_caisse_modification')!=null){

      echo' <li class="nav-item has-treeview ';
            if (isset($ouvertFournisseurCaisse)){
              echo 'menu-open';
            }
               echo'">
            <a href="#" class="nav-link ';
            if (isset($activeFournisseurCaisse)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-users"></i>
              <p>
                FOURNISSEUR CASH
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/fournisseurCaisse" class="nav-link ';
            if (isset($fournisseurCaisse)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-user"></i>
              <p>
                FOURNISSEUR
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
         <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/factureCaisse" class="nav-link ';
            if (isset($factureCaisse)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-file"></i>
              <p>
                FACTURE
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
   <!--     <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/reglementCaisse" class="nav-link ';
            if (isset($reglementCaisse)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                REGLEMENT
                 <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> 
              </p>
            </a>
        </li> -->
       <!-- <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/balanceFournisseur" class="nav-link ';
            if (isset($balanceFournisseur)){
              echo 'active';
            }
              echo'">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>
                Balance
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> 
              </p>
            </a>
        </li> -->
		
		<li class="nav-item has-treeview">
            <a href="'.base_url().'admin/balanceImprimeFournisseur" class="nav-link ';
            if (isset($balanceImprimeFournisseur)){
              echo 'active';
            }
              echo'">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>
                RELEVE FOURNISSEUR
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
            </ul>
          </li>';}




if($this->session->userdata('gazoil_modification')!=null){

       echo' <li class="nav-item has-treeview ';
            if (isset($ouvert6)){
              echo 'menu-open';
            }
               echo'">
            <a href="#" class="nav-link ';
            if (isset($activeGestionGazoil)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-gas-pump"></i>
              <p>
                FOURNISSEUR GAZOIL
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
			
			     <li class="nav-item">
            <a href="'.base_url().'admin/fournisseur" class="nav-link ';
            if (isset($fournisseur)){
              echo 'active';
            }
              echo'">
              <i class="nav-icon fas fa-users"></i>
              <p>
                FOURNISSEUR
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
           </li>
		   
                <li class="nav-item">
                <a href="'.base_url().'admin/factureGazoil" class="nav-link ';
            if (isset($factureGazoil)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-file"></i>
                  <p>FACTURE</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="'.base_url().'admin/reglementFactureGazoil" class="nav-link ';
            if (isset($reglementGazoil)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-cog"></i>
                  <p>REGLEMENT</p>
                </a>
              </li>
			  
			  <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/balanceImprimeFournisseurGazoil" class="nav-link ';
            if (isset($balanceImprimeFournisseurGazoil)){
              echo 'active';
            }
              echo'">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>
                RELEVE FOURNISSEUR
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
             </li>
		
             <!--  <li class="nav-item">
                <a href="'.base_url().'admin/balanceFactureGazoil" class="nav-link ';
            if (isset($balanceGazoil)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-balance-scale"></i>
                  <p>Balance détaillée</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="'.base_url().'admin/balanceFacture" class="nav-link ';
            if (isset($balanceFacture)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-balance-scale"></i>
                  <p>Balance Facture</p>
                </a>
              </li> -->
            </ul>
          </li>';}
		  
		  
		  		if($this->session->userdata('client_modification')!=null){

          echo ' <li class="nav-item has-treeview ';
            if (isset($ouvertClient)){
              echo 'menu-open';
            }
               echo'">
            <a href="#" class="nav-link ';
            if (isset($activeClient)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-user"></i>
              <p>
                GESTION CLIENT
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/client" class="nav-link ';
            if (isset($clientInsert)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-user"></i>
              <p>
               CLIENT
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
         <li class="nav-item has-treeview">
          <a href="'.base_url().'admin/reglementClient" class="nav-link ';
            if (isset($reglementClient)){
              echo 'active';
            }
              echo'">
              <i class="nav-icon fas fas fa-cogs"></i>
              <p>
                REGLEMENT
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
			 </li>
			 
			<!-- <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/balanceClient" class="nav-link ';
            if (isset($balanceClient)){
              echo 'active';
            }
              echo'">
            <i class="nav-icon fas fas fa-balance-scale"></i>
              <p>
                Balance
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span>
              </p>
            </a>
          </li>   -->
		  
		  <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/balanceImprimeClientTransport" class="nav-link ';
            if (isset($balanceImprimeClientTransport)){
              echo 'active';
            }
              echo'">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>
                RELEVE CLIENT
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
		</li>
       
        
            </ul>
          </li>';
        }  
         
      if($this->session->userdata('operation_modification')!=null){

       echo'  <li class="nav-item has-treeview ';
            if (isset($ouvert8)){
              echo 'menu-open';
            }
               echo'">
            <a href="#" class="nav-link ';
            if (isset($activeOperation)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-tasks"></i>
              <p>
                OPERATION
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/operation" class="nav-link ';
            if (isset($operation)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Opération
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item ">
            <a href="'.base_url().'admin/balanceOperation" class="nav-link ';
            if (isset($balanceOperation)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>
                Balance
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
       
        
            </ul>
          </li>';}

      if($this->session->userdata('recette_modification')!=null){

         echo'<li class="nav-item has-treeview ';
            if (isset($ouvertr)){
              echo 'menu-open';
            }
               echo'">
            <a href="#" class="nav-link ';
            if (isset($activeRecette)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p> RECETTES<i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
			
			      <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/infoChargement" class="nav-link ';
            if (isset($infoChargement)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-file"></i>
              <p>
                INFOS CHARGEMENT
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
			</li>
		
              <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/bonLivraison" class="nav-link ';
            if (isset($bonLivraison)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-file"></i>
              <p>
                BON DE LIVRAISON
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
         <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/chargement_retour" class="nav-link ';
            if (isset($chargement_retour)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-file"></i>
              <p>
                CHARGEMENT RETOUR
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/location_engin" class="nav-link ';
            if (isset($location_engin)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-file"></i>
              <p>
                LOCATION ENGIN
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/location_vraquier" class="nav-link ';
            if (isset($location_vraquier)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-file"></i>
              <p>
                LOCATION VRAQUIER
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/vente_pieces" class="nav-link ';
            if (isset($vente_pieces)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-file"></i>
              <p>
                VENTES DIVERSES
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
            </ul>
          </li>';}
		  
		  
	  if($this->session->userdata('caisse_modification')!=null){

         echo' <li class="nav-item has-treeview ';
            if (isset($openES)){
              echo 'menu-open';
            }
               echo'">
            <a href="#" class="nav-link ';
            if (isset($activeGestionCaisse)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>
                GESTION CAISSE
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
			
			<li class="nav-item has-treeview">
            <a href="'.base_url().'admin/demande_bon" class="nav-link ';
            if (isset($demande_bon)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-file"></i>
              <p>
                DEMANDE BON INTERNE
                
              </p>
            </a>
        </li>
		
		<li class="nav-item has-treeview">
            <a href="'.base_url().'admin/demande_bon_retour" class="nav-link ';
            if (isset($demande_bon_retour)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-file"></i>
              <p>
                DEMANDE BON RETOUR
                
              </p>
            </a>
        </li>
			
			
			
              <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/entreeSortieCaisse" class="nav-link ';
            if (isset($entreSortie)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-file"></i>
              <p>
                TYPE
                
              </p>
            </a>
        </li>
         <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/entreeCaisse" class="nav-link ';
            if (isset($entree)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-download"></i>
              <p>
                ENTREE
               
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/sortieCaisse" class="nav-link ';
            if (isset($sortie)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                SORTIE
                
              </p>
            </a>
        </li>
		
		 <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/sortieCaisseDoublon" class="nav-link ';
            if (isset($sortieDoublon)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                SORTIES DOUBLONS
                
              </p>
            </a>
        </li>
		
		
		
	<!--	<li class="nav-item has-treeview">
            <a href="'.base_url().'admin/fraisRoute" class="nav-link ';
            if (isset($fraisRoute)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Frais Route
            
              </p>
            </a>
        </li>
		
		
		<li class="nav-item has-treeview">
            <a href="'.base_url().'admin/fraisDivers" class="nav-link ';
            if (isset($fraisDivers)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Frais Divers
                
              </p>
            </a>
        </li>  -->
		
		
		
        <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/balanceImprimeCaisse" class="nav-link ';
            if (isset($balanceImprimeCaisse)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                BALANCE
               
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/clotureCaisse" class="nav-link ';
            if (isset($clotureCaisse)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-times"></i>
              <p>
                CLOTURE
                
              </p>
            </a>
        </li>
        
            </ul>
          </li>';}

  if($this->session->userdata('rapport_modification')!=null){

        echo'  <li class="nav-item has-treeview ';
            if (isset($ouvertRapport)){
              echo 'menu-open';
            
            }
               echo'">
            <a href="#" class="nav-link ';
            if (isset($rapport)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-dot-circle"></i>
              <p>
                RAPPORT
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              
          <li class="nav-item ">
            <a href="'.base_url().'admin/balanceClient" class="nav-link ';
            if (isset($balanceClient)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                RAPPORT DETAILLE CLIENT
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
            <li class="nav-item">
                <a href="'.base_url().'admin/recetteDepenseParVehicule" class="nav-link ';
            if (isset($recetteDepense)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-dollar-sign"></i>
                  <p>RECETTE/DEPENSE</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="'.base_url().'admin/amortissement" class="nav-link ';
            if (isset($amortissement)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-dollar-sign"></i>
                  <p>AMMORTISSEMENT</p>
                </a>
              </li>
         <li class="nav-item ">
            <a href="'.base_url().'admin/rapportMensuel" class="nav-link ';
            if (isset($rapportMensuel)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                RAPPORT DETAILLE PLATEAUX
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item ">
            <a href="'.base_url().'admin/rapportMensuelBenne" class="nav-link ';
            if (isset($rapportMensuelBenne)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                RAPPORT DETAILLE BENNES
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item ">
            <a href="'.base_url().'admin/rapportMensuelEngin" class="nav-link ';
            if (isset($rapportMensuelEngin)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                RAPPORT DETAILLE ENGINS
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item ">
            <a href="'.base_url().'admin/rapportMensuelVraquier" class="nav-link ';
            if (isset($rapportMensuelVraquier)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                RAPPORT DETAILLE VRAQUIERS
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item ">
            <a href="'.base_url().'admin/rapportMensuelService" class="nav-link ';
            if (isset($rapportMensuelService)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                RAPPORT DETAILLE SERVICES
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item ">
            <a href="'.base_url().'admin/rapportCumuleMensuel" class="nav-link ';
            if (isset($rapportCumuleMensuel)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                RAPPORT CM PLATEAUX
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item ">
            <a href="'.base_url().'admin/rapportCumuleAN" class="nav-link ';
            if (isset($rapportCumuleAN)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                RAPPORT CM
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item ">
            <a href="'.base_url().'admin/rapportCumuleMensuelEN" class="nav-link ';
            if (isset($rapportCumuleMensuelEN)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                RAPPORT CM CALABRESE
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        
        <li class="nav-item ">
            <a href="'.base_url().'admin/rapportCumuleMensuelService" class="nav-link ';
            if (isset($rapportCumuleMensuelService)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                RAPPORT CM SERVICES
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
       <li class="nav-item ">
            <a href="'.base_url().'admin/rapportCumuleMensuelEngin" class="nav-link ';
            if (isset($rapportCumuleMensuelEngin)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                RAPPORT CM ENGIN
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>

        <li class="nav-item ">
            <a href="'.base_url().'admin/rapportCumuleMensuelVraquier" class="nav-link ';
            if (isset($rapportCumuleMensuelVraquier)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                RAPPORT CM VRAQUIER
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item ">
            <a href="'.base_url().'admin/rapportCumuleMensuelBenne" class="nav-link ';
            if (isset($rapportCumuleMensuelBenne)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                RAPPORT CM BENNES
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item ">
            <a href="'.base_url().'admin/rapportCumuleMensuelApprovisionnement" class="nav-link ';
            if (isset($rapportCumuleMensuelApprovisionnement)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                RAPPORT APPROVMT
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
         <li class="nav-item ">
            <a href="'.base_url().'admin/rapportCumuleMensuelAccident" class="nav-link ';
            if (isset($rapportCumuleMensuelAccident)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                RAPPORT ACCIDENT
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>

        <li class="nav-item ">
            <a href="'.base_url().'admin/rapportGeneral" class="nav-link ';
            if (isset($rapportGeneral)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                RAPPORT GENERAL
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
            </ul>
          </li>
          
        <!--  -->';
      }	


if($this->session->userdata('commande_modification')!=null){

         echo' <li class="nav-item has-treeview ';
            if (isset($gestionCommande)){
              echo 'menu-open';
            }
               echo'">
            <a href="#" class="nav-link ';
            if (isset($activeGestionCommande)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>
                GESTION COMMANDE
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/commande" class="nav-link ';
            if (isset($commande)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-file"></i>
              <p>
                TRANSPORT
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
         <li class="nav-item has-treeview">
            <a href="'.base_url().'admin/commandeCimenterie" class="nav-link ';
            if (isset($commandeCimenterie)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-download"></i>
              <p>
                CIMENTERIE
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        
            </ul>
          </li>';}
	  
        
    if($this->session->userdata('depense_modification')!=null){

      echo'  <li class="nav-item has-treeview ';
            if (isset($ouvert1)){
              echo 'menu-open';
            }
               echo '">
           <!-- <a href="#" class="nav-link ';
            if (isset($activeDepense)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-money-bill"></i>
              <p>
                DEPENSES
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>  -->

            <ul class="nav nav-treeview">
             
          <!--     <li class="nav-item">
                <a href="'.base_url().'admin/prime" class="nav-link ';
            if (isset($prime)){
              echo 'active';
            }
               echo'">
                  <i class="fas fa-medal nav-icon"></i>
                  <p>Primes / Ration</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="'.base_url().'admin/fraisRoute" class="nav-link ';
            if (isset($fraisRoute)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-dollar-sign"></i>
                  <p>Frais de route</p>
                </a>
              </li>
              
              
              <li class="nav-item">
                <a href="'.base_url().'admin/fraisDivers" class="nav-link ';
            if (isset($fraisDivers)){
              echo 'active';
            }
               echo'">
                  <i class="nav-icon fas fa-dollar-sign"></i>
                  <p>Frais divers</p>
                </a>
              </li>  -->
              
            
			  
            </ul>
          </li>';}

          // operation gazoil
   	 
          echo'<li class="nav-item has-treeview ">
            <a href="'.base_url().'admin/profile" class="nav-link ';
            if (isset($profile)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-user text-success"></i>
              <p>
                PROFILE
              </p>
            </a> 
      </li>';

          if($this->session->userdata('users_modification')!=null){

          echo'<li class="nav-item has-treeview ">
            <a href="'.base_url().'admin/users" class="nav-link ';
            if (isset($users)){
              echo 'active';
            }
               echo'">
              <i class="nav-icon fas fa-users text-info"></i>
              <p>
                USERS
              </p>
            </a> 
          </li>';}?>
           
           
        

     
          <?php 

          if($this->session->userdata('identifiant')=='nathan' || $this->session->userdata('identifiant')=='superviseur' || $this->session->userdata('identifiant')=='SUPERVISEUR' ) {
          echo' <li class="nav-item has-treeview ">
            <a href="'.base_url().'admin/mouchard" class="nav-link ';
            if (isset($mouchard)){
              echo 'active';
            }
              echo'">
              <i class="nav-icon fas fa-file"></i>
              <p>
                MOUCHARD
              </p>
            </a> 
          </li>';
        }
          ?>
          <li class="nav-item">
            <a href="<?php echo base_url(); ?>admin/deconnexion" class="nav-link">
              <i class="nav-icon fas fa-power-off text-danger"></i>
              <p>Deconnexion</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>