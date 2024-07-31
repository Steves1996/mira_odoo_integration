
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
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
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
          
          <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/document" class="nav-link <?php
            if (isset($document)){
            	echo 'active';
            }
            	 ?>">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                DOCUMENTS
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
         <li class="nav-item has-treeview <?php
            if (isset($ouvertClient)){
              echo 'menu-open';
            }
               ?>">
            <a href="#" class="nav-link <?php
            if (isset($activeClient)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-user"></i>
              <p>
                GESTION CLIENT
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/client" class="nav-link <?php
            if (isset($clientInsert)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-user"></i>
              <p>
               CLIENT
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
         <li class="nav-item has-treeview">
          <a href="<?php echo base_url(); ?>admin/reglementClient" class="nav-link <?php
            if (isset($reglementClient)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fas fa-cogs"></i>
              <p>
                Règlement
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
            <a href="<?php echo base_url(); ?>admin/balanceClient" class="nav-link <?php
            if (isset($balanceClient)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fas fa-balance-scale"></i>
              <p>
                Balance
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
       
        
            </ul>
          </li>
       <!--  <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/chauffeur" class="nav-link <?php
            if (isset($chauffeur)){
            	echo 'active';
            }
            	 ?>">
              <i class="nav-icon fas fa-user"></i>
              <p>
                CHAUFFEURS
              </p>
            </a>
        </li> -->
         <li class="nav-item has-treeview <?php
            if (isset($ouvertChauffeur)){
              echo 'menu-open';
            }
               ?>">
            <a href="#" class="nav-link <?php
            if (isset($activeChauffeur)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-user"></i>
              <p>
               GESTION CHAUFFEURS
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
          <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/chauffeur" class="nav-link <?php
            if (isset($chauffeur)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Chauffeur
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/imputationChauffeur" class="nav-link <?php
            if (isset($imputationChauffeur)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>
                Imputation
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/reglementImputation" class="nav-link <?php
            if (isset($reglementImputation)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>
                Règlement
              </p>
            </a>
        </li>
       <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/balanceChauffeur" class="nav-link <?php
            if (isset($balanceChauffeur)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Balance
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        
            </ul>
          </li>
        <li class="nav-item has-treeview <?php
            if (isset($ouvert)){
            	echo 'menu-open';
            }
            	 ?>">
            <a href="#" class="nav-link <?php
            if (isset($activeCamion)){
            	echo 'active';
            }
            	 ?>">
              <i class="nav-icon fas fa-truck"></i>
              <p>
                GESTION VEHICULES
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>admin/type_vehicule" class="nav-link <?php
            if (isset($type_vehicule)){
              echo 'active';
            }
               ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Type vehicule</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>admin/remorque" class="nav-link <?php
            if (isset($remorque)){
              echo 'active';
            }
               ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Remorque</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="<?php echo base_url(); ?>admin/tracteur" class="nav-link <?php
            if (isset($tracteur)){
            	echo 'active';
            }
            	 ?>">
                  <i class="nav-icon fas fa-tractor"></i>
                  <p>Tracteur</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>admin/camionBenne" class="nav-link <?php
            if (isset($camionBenne)){
            	echo 'active';
            }
            	 ?>">
                  <i class="nav-icon fas fa-truck-monster"></i>
                  <p>Camion benne</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php echo base_url(); ?>admin/engin" class="nav-link <?php
            if (isset($engin)){
              echo 'active';
            }
               ?>">
                  <i class="nav-icon fas fa-tractor"></i>
                  <p>Engin</p>
                </a>
              </li>
              
               <li class="nav-item">
                <a href="<?php echo base_url(); ?>admin/accident" class="nav-link <?php
            if (isset($accident)){
              echo 'active';
            }
               ?>">
                  <i class="nav-icon fas fa-tractor"></i>
                  <p>ACCIDENT</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="<?php echo base_url(); ?>admin/recetteDepenseParVehicule" class="nav-link <?php
            if (isset($recetteDepense)){
              echo 'active';
            }
               ?>">
                  <i class="nav-icon fas fa-dollar-sign"></i>
                  <p>Recettes/Dépenses</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="<?php echo base_url(); ?>admin/distanceRecette" class="nav-link <?php
            if (isset($distance)){
              echo 'active';
            }
               ?>">
                  <i class="nav-icon fas fa-dollar-sign"></i>
                  <p>Destination/littrage</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>admin/amortissement" class="nav-link <?php
            if (isset($amortissement)){
              echo 'active';
            }
               ?>">
                  <i class="nav-icon fas fa-dollar-sign"></i>
                  <p>Amortissement</p>
                </a>
              </li>
              
            </ul>
          </li>
          <li class="nav-item has-treeview <?php
            if (isset($ouvertPneu)){
              echo 'menu-open';
            }
               ?>">
            <a href="#" class="nav-link <?php
            if (isset($pneu)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-dot-circle"></i>
              <p>
                GESTION PNEU
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/pneu" class="nav-link <?php
            if (isset($insertPneu)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-dot-circle"></i>
              <p>
                Pneu
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
         <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/depensePneu" class="nav-link <?php
            if (isset($depensePneu)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-dot-circle"></i>
              <p>
                Dépense pneu
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
       
        
            </ul>
          </li>
          
        <!--  -->
        <li class="nav-item has-treeview <?php
            if (isset($ouvertStock)){
              echo 'menu-open';
            }
               ?>">
            <a href="#" class="nav-link <?php
            if (isset($activeGestionStock)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-database"></i>
              <p>
                GESTION DE STOCK
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/inventaire" class="nav-link <?php
            if (isset($inventaire)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Inventaire
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
         <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/approvisionnement" class="nav-link <?php
            if (isset($approvisionnement)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-download"></i>
              <p>
                Approvisionnement
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/defectueux" class="nav-link <?php
            if (isset($defectueux)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Defectueux
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/stock" class="nav-link <?php
            if (isset($stock)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-database"></i>
              <p>
                Stock
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
            </ul>
          </li>



      <li class="nav-item has-treeview <?php
            if (isset($ouvertFournisseurArticle)){
              echo 'menu-open';
            }
               ?>">
            <a href="#" class="nav-link <?php
            if (isset($activeFournisseurArticle)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-database"></i>
              <p>
                GESTION ARTICLE
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/categorieArticle" class="nav-link <?php
            if (isset($categorieArticle)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                CATEGORIE ARTICLE
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/article" class="nav-link <?php
            if (isset($article)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                ARTICLES
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
              <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/fournisseurArticle" class="nav-link <?php
            if (isset($fournisseurArticle)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Fournisseur
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
         <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/factureFournisseurArticle" class="nav-link <?php
            if (isset($factureArticle)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Facture
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/reglementFournisseurArticle" class="nav-link <?php
            if (isset($reglementArticle)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Règlement
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/balanceFournisseurArticle" class="nav-link <?php
            if (isset($balanceFournisseurArticle)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>
                Balance
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/clotureArticle" class="nav-link <?php
            if (isset($clotureArticle)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-times"></i>
              <p>
                Cloture
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        
            </ul>
          </li>



          <li class="nav-item has-treeview <?php
            if (isset($openES)){
              echo 'menu-open';
            }
               ?>">
            <a href="#" class="nav-link <?php
            if (isset($activeGestionCaisse)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>
                GESTION CAISSE
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/entreeSortieCaisse" class="nav-link <?php
            if (isset($entreSortie)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Type Entrée/Sortie
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
         <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/entreeCaisse" class="nav-link <?php
            if (isset($entree)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-download"></i>
              <p>
                Entrée
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/sortieCaisse" class="nav-link <?php
            if (isset($sortie)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Sortie
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/balanceCaisse" class="nav-link <?php
            if (isset($balanceCaisse)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Balance
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/clotureCaisse" class="nav-link <?php
            if (isset($clotureCaisse)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-times"></i>
              <p>
                Cloture
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        
            </ul>
          </li>



       <li class="nav-item has-treeview <?php
            if (isset($ouvertFournisseurCaisse)){
              echo 'menu-open';
            }
               ?>">
            <a href="#" class="nav-link <?php
            if (isset($activeFournisseurCaisse)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                FOURNISSEUR CAISSSE
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/fournisseurCaisse" class="nav-link <?php
            if (isset($fournisseurCaisse)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Fournisseur
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
         <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/factureCaisse" class="nav-link <?php
            if (isset($factureCaisse)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Facture
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/reglementCaisse" class="nav-link <?php
            if (isset($reglementCaisse)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Règlement
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/balanceFournisseur" class="nav-link <?php
            if (isset($balanceFournisseur)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>
                Balance
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
            </ul>
          </li>



          <li class="nav-item has-treeview <?php
            if (isset($ouvertFournisseurMatiere)){
              echo 'menu-open';
            }
               ?>">
            <a href="#" class="nav-link <?php
            if (isset($activeFournisseurMatiere)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                PRODUIT DE CARRIERE
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/fournisseurMatiere" class="nav-link <?php
            if (isset($fournisseurMatiere)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Fournisseur
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
         <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/factureFournisseurMatiere" class="nav-link <?php
            if (isset($factureMatiere)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Facture
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/reglementFournisseurMatiere" class="nav-link <?php
            if (isset($reglementMatiere)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-cogs"></i>
              <p>
                Règlement
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/balanceFournisseurMatiere" class="nav-link <?php
            if (isset($balanceFournisseurMatiere)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>
                Balance
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
            </ul>
          </li>


                    <li class="nav-item has-treeview <?php
            if (isset($ouvert6)){
              echo 'menu-open';
            }
               ?>">
            <a href="#" class="nav-link <?php
            if (isset($activeGestionGazoil)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-gas-pump"></i>
              <p>
                GESTION GAZOIL
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
               <li class="nav-item">
            <a href="<?php echo base_url(); ?>admin/fournisseur" class="nav-link <?php
            if (isset($fournisseur)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                FOURNISSEUR GAZOIL
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
            <li class="nav-item">
                <a href="<?php echo base_url(); ?>admin/factureGazoil" class="nav-link <?php
            if (isset($factureGazoil)){
              echo 'active';
            }
               ?>">
                  <i class="nav-icon fas fa-file"></i>
                  <p>Facture gazoil</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>admin/reglementFactureGazoil" class="nav-link <?php
            if (isset($reglementGazoil)){
              echo 'active';
            }
               ?>">
                  <i class="nav-icon fas fa-cog"></i>
                  <p>Règlement gazoil</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>admin/balanceFactureGazoil" class="nav-link <?php
            if (isset($balanceGazoil)){
              echo 'active';
            }
               ?>">
                  <i class="nav-icon fas fa-balance-scale"></i>
                  <p>Balance détaillée</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>admin/balanceFacture" class="nav-link <?php
            if (isset($balanceFacture)){
              echo 'active';
            }
               ?>">
                  <i class="nav-icon fas fa-balance-scale"></i>
                  <p>Balance Facture</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/commande" class="nav-link <?php
            if (isset($commande)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                COMMANDE
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
         <li class="nav-item has-treeview <?php
            if (isset($ouvert8)){
              echo 'menu-open';
            }
               ?>">
            <a href="#" class="nav-link <?php
            if (isset($activeOperation)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-tasks"></i>
              <p>
                OPERATION
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/operation" class="nav-link <?php
            if (isset($operation)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Opération
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
       
        
            </ul>
          </li>

         <li class="nav-item has-treeview <?php
            if (isset($ouvert)){
              echo 'menu-open';
            }
               ?>">
            <a href="#" class="nav-link <?php
            if (isset($activeRecette)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>
                RECETTES
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/bonLivraison" class="nav-link <?php
            if (isset($bonLivraison)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-file"></i>
              <p>
                BON DE LIVRAISON
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
         <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/chargement_retour" class="nav-link <?php
            if (isset($chargement_retour)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Chargement retour
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
        <li class="nav-item has-treeview">
            <a href="<?php echo base_url(); ?>admin/location_engin" class="nav-link <?php
            if (isset($location_engin)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-file"></i>
              <p>
                Location engin
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
            </ul>
          </li>
        
        
        <li class="nav-item has-treeview <?php
            if (isset($ouvert1)){
              echo 'menu-open';
            }
               ?>">
            <a href="#" class="nav-link <?php
            if (isset($activeDepense)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-money-bill"></i>
              <p>
                DEPENSES
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item ">
                <a href="<?php echo base_url(); ?>admin/gazoil" class="nav-link <?php
            if (isset($gazoil)){
              echo 'active';
            }
               ?>">
                  <i class="nav-icon fas fa-gas-pump"></i>
                  <p>Gazoil</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>admin/prime" class="nav-link <?php
            if (isset($prime)){
              echo 'active';
            }
               ?>">
                  <i class="fas fa-medal nav-icon"></i>
                  <p>Primes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>admin/fraisRoute" class="nav-link <?php
            if (isset($fraisRoute)){
              echo 'active';
            }
               ?>">
                  <i class="nav-icon fas fa-dollar-sign"></i>
                  <p>Frais de route</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>admin/pieceRechange" class="nav-link <?php
            if (isset($pieceRechange)){
              echo 'active';
            }
               ?>">
                  <i class="nav-icon fas fa-wrench"></i>
                  <p>Pièces de rechange</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>admin/fraisDivers" class="nav-link <?php
            if (isset($fraisDivers)){
              echo 'active';
            }
               ?>">
                  <i class="nav-icon fas fa-dollar-sign"></i>
                  <p>Frais divers</p>
                </a>
              </li>
              
            </ul>
          </li>
          <li class="nav-item ">
            <a href="<?php echo base_url(); ?>admin/type_huile" class="nav-link <?php
            if (isset($type_huile)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>
                TYPE d'HUILE
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>
          <li class="nav-item has-treeview <?php
            if (isset($ouvert3)){
              echo 'menu-open';
            }
               ?>">
            <a href="#" class="nav-link <?php
            if (isset($activeVidange)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-oil-can"></i>
              <p>
                VIDANGE
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="<?php echo base_url(); ?>admin/Vidange" class="nav-link <?php
            if (isset($vidange)){
              echo 'active';
            }
               ?>">
                  <i class="nav-icon fas fa-cogs"></i>
                  <p>Moteur</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>admin/boiteVitesse" class="nav-link <?php
            if (isset($boite)){
              echo 'active';
            }
               ?>">
                  <i class="nav-icon fas fa-cog"></i>
                  <p>Boite de vitesse</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo base_url(); ?>admin/hydrolique" class="nav-link <?php
            if (isset($hydrolique)){
              echo 'active';
            }
               ?>">
                  <i class="nav-icon fas fa-oil-can"></i>
                  <p>Hydrolique</p>
                </a>
              </li>
            </ul>
          </li>
           <li class="nav-item ">
            <a href="<?php echo base_url(); ?>admin/balanceOperation" class="nav-link <?php
            if (isset($balanceOperation)){
              echo 'active';
            }
               ?>">
              <i class="nav-icon fas fa-balance-scale"></i>
              <p>
                Balance
                <!-- <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span> -->
              </p>
            </a>
        </li>

<!--           <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Layout Options
                <i class="fas fa-angle-left right"></i>
                <span class="badge badge-info right">6</span>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/layout/top-nav.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Top Navigation</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/layout/top-nav-sidebar.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Top Navigation + Sidebar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/layout/boxed.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Boxed</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/layout/fixed-sidebar.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fixed Sidebar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/layout/fixed-topnav.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fixed Navbar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/layout/fixed-footer.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Fixed Footer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/layout/collapsed-sidebar.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Collapsed Sidebar</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Charts
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/charts/chartjs.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>ChartJS</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/charts/flot.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Flot</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/charts/inline.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inline</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tree"></i>
              <p>
                UI Elements
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/UI/general.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/UI/icons.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Icons</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/UI/buttons.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Buttons</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/UI/sliders.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sliders</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/UI/modals.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Modals & Alerts</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/UI/navbar.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Navbar & Tabs</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/UI/timeline.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Timeline</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/UI/ribbons.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Ribbons</p>
                </a>
              </li>
            </ul>
          </li> -->
          <!-- 
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Tables
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/tables/simple.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Simple Tables</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/tables/data.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>DataTables</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/tables/jsgrid.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>jsGrid</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-header">EXAMPLES</li>
          <li class="nav-item">
            <a href="pages/calendar.html" class="nav-link">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Calendar
                <span class="badge badge-info right">2</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="pages/gallery.html" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
                Gallery
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-envelope"></i>
              <p>
                Mailbox
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/mailbox/mailbox.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inbox</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/mailbox/compose.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Compose</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/mailbox/read-mail.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Read</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Pages
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/examples/invoice.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Invoice</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/profile.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Profile</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/e-commerce.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>E-commerce</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/projects.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Projects</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/project-add.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Project Add</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/project-edit.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Project Edit</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/project-detail.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Project Detail</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/contacts.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Contacts</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-plus-square"></i>
              <p>
                Extras
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/examples/login.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Login</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/register.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Register</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/forgot-password.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Forgot Password</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/recover-password.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Recover Password</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/lockscreen.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lockscreen</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/legacy-user-menu.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Legacy User Menu</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/language-menu.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Language Menu</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/404.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Error 404</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/500.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Error 500</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/pace.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Pace</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/examples/blank.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Blank Page</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="starter.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Starter Page</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-header">MISCELLANEOUS</li>
          <li class="nav-item">
            <a href="https://adminlte.io/docs/3.0" class="nav-link">
              <i class="nav-icon fas fa-file"></i>
              <p>Documentation</p>
            </a>
          </li>
          <li class="nav-header">MULTI LEVEL EXAMPLE</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-circle nav-icon"></i>
              <p>Level 1</p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-circle"></i>
              <p>
                Level 1
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Level 2</p>
                </a>
              </li>
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Level 2
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Level 3</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Level 2</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="fas fa-circle nav-icon"></i>
              <p>Level 1</p>
            </a>
          </li>
          <li class="nav-header">LABELS</li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-circle text-danger"></i>
              <p class="text">Important</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-circle text-warning"></i>
              <p>Warning</p>
            </a>
          </li> -->
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