<?php 
  if($this->session->userdata('id_profil')==null){
    redirect(base_url()."admin/", 'refresh');
  }
 ?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $page_title; 
  $commandeCimenterie="";

   $gestionCommande="";
  $activeGestionCommande="";
  ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/toastr/toastr.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/summernote/summernote-bs4.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">



  <!-- Main Sidebar Container -->
<?php 
include 'assets/include_menu.php';
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><?php echo $page_title; ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?php echo $page_title; ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
         <?php 
        include 'assets/include_stat.php';
        ?>
        <!-- /.row -->
    
        <div class="row">
          <!-- Left col -->

               <div class="row ">

 
<div class="modal fade" id="modal-primary">
        <div class="modal-dialog">
          <div class="modal-content bg-primary">
            <div class="modal-header">
              <h4 class="modal-title">Suppression</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <p> Voulez vous confirmer la suppression de cet éléments de la liste ?</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Annuler</button>
              <button type="button" class="btn btn-outline-light" data-dismiss="modal" onclick="confirmSuppressionCommandeCimenterie();">Confirmer</button>
              <input type="hidden" class="table" name="">
              <input type="hidden" class="identifiant" name="">
              <input type="hidden" class="nom_id" name="">
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      </div>
     <div class="row">
      <div class="col-12 col-sm-12">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-carte" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab ">
                    <div class="overlay-wrapper">
                      <div class="overlay dark chargementPrime1" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Loading...</div></div>
                     <h3 style="text-align: center;" >ENREGISTREMENT DES COMMANDE</h3>
                     <hr>
                     <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title">Renseignez tous les champs</h3>
                      </div>
                      <a href="#details"></a>
                      <div class="card-body">
                        <h2 style="text-align: center" id="details">Entête de la commande</h2>
                        <div class="row">

                   <!--    <div class="col-md-3">
                          <div class="form-group">
                              <label>Camion</label>
                              <select class="camion form-control">
                                <?php $this->crud_model_depense->leSelectCodeCamion(); ?>
                                </select>
                            </div>
                        
                          </div> -->

                          <div class="col-md-3" >
                            <div class="form-group">
                            <label>Fournisseur</label>
                            <select class="id_fournisseur form-control" onchange="">
                             
                              <?php $this->crud_model_article->leSelectFournisseurArticle(); ?>
                                
                              </select>
                          </div>
                          </div>
                         
                          <div class="col-md-3">
                            <label>Date création: </label>
                          <div class="input-group " id="" data-target-input="nearest" >
                              
                                <input type="date" class="form-control datetimepicker-input date_creation" data-target="#reservationdate" placeholder="date effet" onchange="getExpirationPneu();" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                            <label>Date commande: </label>
                          <div class="input-group " id="" data-target-input="nearest" >
                              
                                <input type="date" class="form-control datetimepicker-input date_commande" data-target="#reservationdate" placeholder="date effet" onchange="getExpirationPneu();" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                          </div>
                        </div>

                        <div class="col-md-3" >
                            <!-- <label>Distance</label> -->
                            <input type="text" class="form-control distance" value="0" placeholder="En Kilometre" onkeypress="chiffres(event);" style="display: none;">
                             <div class="form-group">
                            <label>PO(commande)</label>
                           <input type="text" class="form-control po" disabled="true" name="" value="<?php echo $this->crud_model_commande->genererChaineAleatoire();?>">
                          </div>
                          </div>
                          <div class="col-md-3">
                             <div class="form-group">
                            <label>Etat réception</label>
                           <input type="text" class="form-control etat_reception" disabled="true" name="" value="COMMANDEE">
                          </div>
                          </div>
                          <div class="col-md-3">
                             <div class="form-group">
                            <label>Etat expédition</label>
                           <input type="text" class="form-control etat_expedition" disabled="true" name="" value="COMMANDEE">
                          </div>
                          </div>
                        </div>
                        <hr>
                        <h2 style="text-align: center">Détails de la commande</h2>
                         <hr>
                         <div class="col-md-2">
                            <label>Nobre de lignes</label>
                            <select class="form-control nbreLigne" onchange="afficheLigneCommande();">
                              
                              <option>1</option>
                              <option>2</option>
                              <option>3</option>
                              <option>4</option>
                              <option>5</option>
                              <option>6</option>
                              <option>7</option>
                              <option>8</option>
                              <option>9</option>
                              <option>10</option>
                              <option>11</option>
                              <option>12</option>
                              <option>13</option>
                              <option>14</option>
                              <option>15</option>
                              <option>16</option>
                              <option>17</option>

                              <option>18</option>
                              <option>19</option>
                              <option>20</option>
                              <option>21</option>
                              <option>22</option>
                              <option>23</option>
                              <option>24</option>
                              <option>25</option>
                              <option>26</option>
                              <option>27</option>
                              <option>28</option>
                              <option>29</option>
                              <option>30</option>
                              <option>31</option>
                              <option>32</option>
                              <option>33</option>
                              <option>34</option>
                              <option>35</option>
                              <option>36</option>
                              <option>37</option>
                              <option>38</option>
                              <option>39</option>
                              <option>40</option>

                              <option>41</option>
                              <option>42</option>
                              <option>43</option>
                              <option>44</option>
                              <option>45</option>
                              <option>46</option>
                              <option>47</option>
                              <option>48</option>
                              <option>49</option>
                              <option>50</option>
                            </select>
                            </div>
                       
                         <div class="contentLignes">
                          <div class="row">
                         <div class="col-md-2">
                       <div class="form-group">
                       <label>Article</label>
                        <select class="article1 form-control" autocomplete='on' onchange="getPrixUnitaireArticle($('.article1').val(),'pu1');getReferenceArticle($('.article1').val(),'description1');">
                         <option value=""></option>
                       <?php $this->crud_model_depense->leSelectArticle();?>
                       </select></div>
                          </div>
                          <div class="col-md-2">
                            <label>Quantite commandée</label>
                            <input type="text" class="form-control qtite_com1" placeholder=" " onkeypress="chiffres(event);" onkeyup ="formatMillier('montant');">

                          </div>

                          
                    <div class="col-md-2">
                            <label>Prix unitaire</label>
                            <input type="text" class="form-control pu1" placeholder=" en FCFA" disabled="true" onkeypress="chiffres(event);" onkeyup ="formatMillier('montant');">

                          </div>
                             <div class="col-md-2">
                          <div class="form-group">
                              <label>Camion</label>
                              <select class="camion1 form-control" autocomplete='on'>
                                <?php $this->crud_model_depense->leSelectEtatCodeCamion(); ?>
                                </select>
                            </div>
                        
                          </div>
                           <div class="col-md-2">
                             <div class="form-group">
                              <label>Référence</label>
                              <input type= "text" class="form-control description1"/ >
                            </div>
                          </div>
                          <div class="col-md-2">
                         <div class="form-group">
                         <label>Type</label>
                          <select class="type1 form-control" onchange="activePrix('.type1','.pu1');">
                           <option>interne</option>
                           <option>externe</option>
                           
                           </select></div>
                            </div>
                          <input type="hidden" class="form-control id_commande1"  placeholder=" en FCFA" disabled="true" onkeypress="chiffres(event);">
                          <input type="hidden" class="form-control compteur"  placeholder=" en FCFA"  disabled="true" onkeypress="chiffres(event);">
                         </div>
                         </div>
                        <div class="row">
                         <!--  <div class="col-md-3">
                            <label>Commantaire</label>
                           <textarea class="commentaire form-control"></textarea>
                          </div> -->
                          <div class="col-md-3">
                         <!--   <div class="form-group">
                              <label>Description</label>
                              <textarea class="form-control description" disabled="true">
                                
                              </textarea>
                            </div> -->
                          <!-- </div> -->
                          <div class="col-md-3 alertSucces">
                            <!-- <div class="form-group">
                              <label>Destination</label>
                              <textarea class="form-control destination3" disabled="true">
                                
                              </textarea> -->
                            </div>
                          
                          <button type="button" class=" btn-primary btn-lg btnModif" style="display: none;"  onclick="addCommandeCimenterie('update');">Modifier</button>
                        
                           </div>
						   
						   <div class="col-md-4"><br> <button type="button" class=" btn-primary btn-lg btnAnnulerModif" style="display: none;" onclick="annulerSuppressionGazoil();">Annuler</button> 
                            <?php
                            if ($this->session->userdata('commande_ajout')=="true") {
                          echo '<button type="button" class=" btn-primary btn-lg btnAddClient"  onclick="addCommandeCimenterie(\'insert\');">Valider</button>'; } ?></div>
                 
                 
                            </div>
                        
                      </div>
                      <!-- /.card-body -->
                    </div>
                  </div>
               <input type="hidden" class="id_prime" name="">
			   <input type="hidden" class="compte" value="<?php echo $this->session->userdata('identifiant') ?>">
                  
                </div>
              
              <!-- /.card -->
            </div>
          </div>
		  
		    <div class="col-md-12">
              <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title">CHOISISSEZ UNE PERIODE</h3>
                      </div>
                      
                      <div class="card-body">
                        <div class="row">
                          

                          <div class="col-md-3">
                            <div class="form-group">          
                            <label>Date debut: </label>
                          <div class="input-group " id="" data-target-input="nearest" >
                              
                                <input type="date" class="form-control datetimepicker-input date_debut" data-target="#reservationdate" placeholder="date effet"  onchange=" getAllCommande('#example1');"/>
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                          </div>

                          </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">          
                            <label>Date fin: </label>
                          <div class="input-group " id="" data-target-input="nearest" >
                              
                                <input type="date" class="form-control datetimepicker-input date_fin" data-target="#reservationdate" placeholder="date effet"  onchange="getAllCommande('#example1');" "/>
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                          </div>

                          </div>
                          </div>
						  
						   <div class="col-md-3">
                           <div class="form-group">
                            <label>Fournisseur :</label>
                            <select class="id_fournisseur1 form-control" onchange="getAllCommande('#example1');">
                             
							  <option value="TOUT">TOUT</option>
                              <?php $this->crud_model_article->leSelectFournisseurArticle1(); ?>
							  
							 
                                
                              </select>
                          </div>
                          </div>
                     
                        </div>
                        
                      </div>
                      <!-- /.card-body -->
                    </div>
            <div class="col-12 col-sm-12" style="overflow: auto;">
              <h3 style="text-align: center;">VISUALISATION</h3>
                     <hr>
              
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-carte" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab ">
                    <div class="overlay-wrapper">
                     
                     <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title" style="text-align: center;">Liste des commande</h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                        </button>
                      </div>
                      </div>
                      <input type="hidden" class="id_chauffeur" name="">
                      <div class="card-body">
                     <div class="overlay-wrapper" style="">
                      <div class="overlay dark chargementPrime" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>
                      <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr >
                    
                    <th>PO(commande)</th>
                    <th>Fournisseur</th>
                    <th onclick="">Référence</th>
                    <th>Article</th>
                    <!-- <th>Distance</th> -->
                    <th>Date commande</th>
                    <th>Date création</th>
                    <th>Véhicule</th>
                    
                    <th>Montant (FCFA)</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody class="contentCommande">
                 <?php
                 $this->crud_model_commande->selectAllCommandeCimenterie();
                  ?>
                  </tbody></table>
                    </div>

                        </div>
                        
                    
                      </div>
                      <!-- /.card-body -->
                    </div>
                  </div>
               
                  
                </div>


                  <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-carte" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab ">
                    <div class="overlay-wrapper">
                     
                     <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title" style="text-align: center;">Détail de la commande</h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                        </button>
                      </div>
                      </div>
                      <input type="hidden" class="id_chauffeur" name="">
                      <div class="card-body">
                     <div class="overlay-wrapper" style="">
                      <div class="overlay dark chargementPrime2" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>
                      

                       <button onclick="imprimer_bloc('titre','selectionAimprier')" class="btn btn-white btn-primary btn-bold"><i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span></button>
                  <div id="selectionAimprier" style="margin: 30px;"> 
                    <br/>
                   
                      <table id="example7" class="table table-bordered " style="border: none;" cellpadding="0" cellspacing="0">
                  <thead>
                  <tr style=" margin: 0px;">
                    <td onclick="" colspan="2" style=" margin: 0px;border: none; border-bottom: 2px solid black; ">
                      
                          <span style="font-size: 25px; border: none; font-weight: bold;">COMMANDES (Détails)</span><br/>
                           <span style="font-size: 16px;font-weight: bold;">Période: Tous</span>
                         
                       
                     
                    </td>
                    <td colspan="4" style=" margin: 0px;border: none; border-bottom: 2px solid black; "></td>
                    
                    <td colspan="2" style=" text-align: center; margin: 0px;border: none; border-bottom: 2px solid black; font-weight: bold;">
                      <span style="font-size: 20px;">MIRA CIMENTERIE</span><br/>
                          <span><?php echo date('d/m/H H:i:s'); ?></span>
                      </td>
                      
                      
                  </tr>
                <!--   <tr style="padding: 0; margin: 0px;">
                    <td onclick="" colspan="8">
                      
                          <span>Commandes (détails)</span><br/>
                           <span style="font-size: 10px;">Période: Tous</span>
                       
                        <span>MIRA TRANSPORT</span><br/>
                          <span><?php echo date('d/m/H H:i:s'); ?></span>
                      </div>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                  </tr> -->

                    <td colspan="8" style="margin: 0px; padding: 0px;border: none;"><br/><br/></td></tr>
                  <tr><td colspan="8" style="margin: 0px; padding: 0px;border: none;"></td></tr>
                  <tr style="margin: 0px; padding: 0px; border: none;">
                    <td style="margin: 0px; padding: 0px;border: none; ">Crée le :</td> 
                    <td class="date_creation2" style="margin: 0px; padding: 0px;border: none;">...</td> 
                    <td colspan="6" style="margin: 0px; padding: 0px;border: none;"></td>  
                  </tr>
                  <tr>
                    <td style="margin: 0px; padding: 0px;border: none;">Date commande :</td> 
                    <td   class="date_commande2" style="margin: 0px; padding: 0px;border: none;">...</td> 
                    <td colspan="4" style="margin: 0px; padding: 0px;border: none;"></td>
                    <td style="margin: 0px; padding: 0px;border: none;"></td> 
                    <td class="reference" style="margin: 0px; padding: 0px;border: none;"></td>

                  </tr>
                  <tr>
                    <td style="margin: 0px; padding: 0px;border: none;">Fournisseur :</td> 
                    <td class="fournisseur" style="margin: 0px; padding: 0px;border: none;">...</td> 
                    <td colspan="3" style="margin: 0px; padding: 0px;border: none;"></td>
                    <td style="margin: 0px; padding: 0px;border: none;width: 18%" colspan="2">Etat de réception:</td> 
                    <td class="etat_reception2" style="margin: 0px; padding: 0px;border: none;"></td>  

                  </tr>
                  <tr>
                    <td style="margin: 0px; padding: 0px;border: none; border-bottom: 2px solid black; ">PO(commande) :</td> 
                    <td class="po2" style="margin: 0px; padding: 0px;border: none; border-bottom: 2px solid black; width: 10% ">...</td> 
                    <td colspan="3" style="margin: 0px; padding: 0px;border: none;border-bottom: 2px solid black; width: 10%"></td> 
                    <td style="margin: 0px; padding: 0px;border: none; border-bottom: 2px solid black;width: 10%" colspan="2">Etat d'expédition:</td> 
                    <td  class="etat_expedition2" style="margin: 0px; padding: 0px;border: none; border-bottom: 2px solid black; width: 10%"></td> 
                  </tr>

                <!--   <tr>
                    <th colspan="8">
                      <div class="row">
                        <div class="col-md-2">
                      <span>Crée le: </span> <br/>
                      <span>Date commande: </span> <br/>
                      <span>Fournisseur: </span> <br/>
                      <span>PO(commande): </span> 
                       </div>
                       <div class="col-md-3" style="text-align: left">
                         <span class="date_creation2">...........</span><br/>
                         <span class="date_commande2">........</span><br/>
                         <span class="fournisseur">........</span><br/>
                         <span class="po2">........</span>
                       </div>
                        <div class="col-md-3"></div>
                        <div class="col-md-4">
                      <span>Reférence: </span> <span class="reference"></span><br/>
                      <span>Etat de réception: </span> <span class="etat_reception2">........</span><br/>
                      <span>Etat d'expédition: </span> <span class="etat_expedition2">........</span><br/>
                        </div>
                    </th>
                  </tr> -->
                  <tr>
                    <td colspan="9" style="border: none;">
                      
                    </td>
                  </tr>
                  
                  <tr style="background: white; color: black; font-size: 18px; font-weight: bold; " >
                    
                    <td style="border-bottom: : 1px solid black;width: 13%; text-align: center;border-bottom: 3px solid black; ">PO(item)</td>
                    <td style="border-left: 1px solid white;width: 17%;  text-align: center;border-bottom: 3px solid black; ">Article</td>
                   
                    <td style="border-left: 1px solid white; text-align: center;border-bottom: 3px solid black; ">Référence</td>
                    <td style="border-left: 1px solid white; text-align: center;width: 5%;border-bottom: 3px solid black; ">Quantité </td>
                    <td style="border-left: 1px solid white; text-align: center;width: 10%;border-bottom: 3px solid black; ">PU</td>
                    <td style="border-left: 1px solid white;width: 10%; text-align: center;border-bottom: 3px solid black; ">Coût Total</td>
                    <td colspan="2" style=" width: 10%; text-align: center;border-bottom: 3px solid black; ">Véhicule <br/></td>
                    <!-- <td style=" width: 10%; text-align: center;border-bottom: 3px solid black; ">Véhicule <br/></td> -->

                    <br/>
                  </tr>
                  </thead>
                   <br/>
                  <tbody class="contentDetailCommande2" id="contentDetailCommande2">
                 
                  </tbody>

                </table>
                <a href="#contentDetailCommande2"></a>
                  </div>
                    </div>

                        </div>
                        
                    
                      </div>
                      <!-- /.card-body -->
                    </div>
                  </div>
               
                  
                </div>
              <!-- /.card -->
            </div>
          </div>

          

        </div>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.0.4
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo base_url(); ?>assets/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url(); ?>assets/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?php echo base_url(); ?>assets/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url(); ?>assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url(); ?>assets/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?php echo base_url(); ?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url(); ?>assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo base_url(); ?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/dataTables.buttons.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.colVis.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.flash.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.html5.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.flash.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.print.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/pdfmake/pdfmake.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/pdfmake/pdfmake.min.js"></script>
<!-- <script src="../../plugins/pdfmake/pdfmake.js.map"></script> -->
<script src="<?php echo base_url(); ?>assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/jszip/jszip.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo base_url(); ?>assets/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url(); ?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.js"></script>
<script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>
<script src="<?php echo base_url(); ?>assets/js/admin_chauffeur.js"></script>
<script src="<?php echo base_url(); ?>assets/js/admin_pneu.js"></script>

<script src="<?php echo base_url(); ?>assets/js/admin_commande.js"></script>
<script>

  $(function () {
    // toastr.info("goooooo");
    $("#example1").DataTable({
      "lengthChange": false,
      "searching": true,
      // "ordering": true,
      "info": true,
      "autoWidth": false,
      // "responsive": true,
      // "responsive": true,
      // "autoWidth": true,
      "autoPrint": true,
       dom: 'Bfrtip',
        buttons: [
         {
            extend: "print",
            text: "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
            className: "btn btn-white btn-primary btn-bold",
            autoPrint: true,
            message: 'MIRA TRANSPORT :::: LISTE DES COMMANDES'
            },
            {
            extend: "pdf",
            text: "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
            className: "btn btn-white btn-primary btn-bold"
            },
            {
            extend: 'excelHtml5',
            autoFilter: true,
            sheetName: 'Exported data',
            text: "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
            className: "btn btn-white btn-primary btn-bold"
        }
        ],
           "language": {
    "sProcessing":     "Traitement en cours...",
    "sSearch":         "Rechercher&nbsp;:",
    "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
    "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
    "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
    "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
    "sInfoPostFix":    "",
    "sLoadingRecords": "Chargement en cours...",
    "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
    "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
    "oPaginate": {
        "sFirst":      "Premier",
        "sPrevious":   "Pr&eacute;c&eacute;dent",
        "sNext":       "Suivant",
        "sLast":       "Dernier"
    },
    "oAria": {
        "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
        "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
    },
    "select": {
            "rows": {
                _: "%d lignes sÃ©lÃ©ctionnÃ©es",
                0: "Aucune ligne sÃ©lÃ©ctionnÃ©e",
                1: "1 ligne sÃ©lÃ©ctionnÃ©e"
            } 
    }
}
      
    });


     $("#example").DataTable({
      "lengthChange": false,
      "searching": false,
      // "ordering": true,
      "info": true,
      "autoWidth": false,
      // "responsive": true,
      // "responsive": true,
      // "autoWidth": true,
      "autoPrint": true,
       dom: 'Bfrtip',
        buttons: [
         {
            extend: "print",
            text: "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
            className: "btn btn-white btn-primary btn-bold",
            autoPrint: true,
            message: 'MIRA TRANSPORT'
            },
            {
            extend: "pdf",
            text: "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
            className: "btn btn-white btn-primary btn-bold"
            },
            {
            extend: 'excelHtml5',
            autoFilter: true,
            sheetName: 'Exported data',
            text: "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
            className: "btn btn-white btn-primary btn-bold"
        }
        ],
           "language": {
    "sProcessing":     "Traitement en cours...",
    "sSearch":         "Rechercher&nbsp;:",
    "sLengthMenu":     "Afficher _MENU_ &eacute;l&eacute;ments",
    "sInfo":           "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
    "sInfoEmpty":      "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
    "sInfoFiltered":   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
    "sInfoPostFix":    "",
    "sLoadingRecords": "Chargement en cours...",
    "sZeroRecords":    "Aucun &eacute;l&eacute;ment &agrave; afficher",
    "sEmptyTable":     "Aucune donn&eacute;e disponible dans le tableau",
    "oPaginate": {
        "sFirst":      "Premier",
        "sPrevious":   "Pr&eacute;c&eacute;dent",
        "sNext":       "Suivant",
        "sLast":       "Dernier"
    },
    "oAria": {
        "sSortAscending":  ": activer pour trier la colonne par ordre croissant",
        "sSortDescending": ": activer pour trier la colonne par ordre d&eacute;croissant"
    },
    "select": {
            "rows": {
                _: "%d lignes sÃ©lÃ©ctionnÃ©es",
                0: "Aucune ligne sÃ©lÃ©ctionnÃ©e",
                1: "1 ligne sÃ©lÃ©ctionnÃ©e"
            } 
    }
}
      
    });
  
    $('#example10').DataTable({
      // "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
    //Initialize Select2 Elements
   
  })

</script>
</body>
</html>
