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
  $rapportMensuelVraquier="";
 $ouvertRapport="";
  $rapport="";
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
       
        <!-- /.row -->
    
        <div class="row">
          <!-- Left col -->

              

 
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
              <button type="button" class="btn btn-outline-light" data-dismiss="modal" onclick="confirmSuppressionReglement();">Confirmer</button>
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
      <div class="col-4 col-sm-4">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-carte" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab ">
                    <div class="overlay-wrapper">
                      <div class="overlay dark chargementPrime1" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Loading...</div></div>
                     <h3 style="text-align: center;"></h3>
                     <hr>
                     <div class="card card-danger">
                      <div class="card-header">
                        <h3 class="card-title">Sélectionnez une opération</h3>
                      </div>
                      
                      <div class="card-body">
                        <div class="row">
                          

                          <div class="col-md-12">
                            <div class="form-group">
                            <label>Type de véhicule</label>
                            <select class="id_fournisseur form-control" onchange="rapportMensuelVraquier();">
                          
                              <?php $this->crud_model_rapport->leSelectTypeVraquier(); ?>
                                
                              </select>
                          </div>
                          </div>
                          
                     
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
                    <div class="col-4 col-sm-4">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-carte" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab ">
                    <div class="overlay-wrapper">
                      <div class="overlay dark chargementPrime1" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Loading...</div></div>
                     <h3 style="text-align: center;"></h3>
                     <hr>
                     <div class="card card-warning">
                      <div class="card-header">
                        <h3 class="card-title">TOTAUX</h3>
                      </div>
                      
                      <div class="card-body">
                        <div class="row">
                          

                          <div class="col-md-12">
                            <div class="form-group">          
                            Recette : <input type="text" disabled="true" class="totalRecette form-control" name="">
                            Dépense : <input type="text" disabled="true"  class="totalReglement form-control" name="">

                          </div>
                          </div>
                          
                     
                        </div>
                        
                      </div>
                      <!-- /.card-body -->
                    </div>
                  </div>
               <input type="hidden" class="id_prime" name="">
                  
                </div>
              
              <!-- /.card -->
            </div>
          </div>
          <div class="col-4 col-sm-4">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-carte" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab ">
                    <div class="overlay-wrapper">
                      <div class="overlay dark chargementPrime1" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Loading...</div></div>
                     <h3 style="text-align: center;"></h3>
                     <hr>
                     <div class="card card-success">
                      <div class="card-header">
                        <h3 class="card-title">SOLDE</h3>
                      </div>
                      
                      <div class="card-body">
                        <div class="row">
                          

                          <div class="col-md-12">
                            <div class="form-group">
                           
                            <input type="text" disabled="true" name="" class="solde form-control">
                          </div>
                          </div>
                          
                     
                        </div>
                        
                      </div>
                      <!-- /.card-body -->
                    </div>
                  </div>
               <input type="hidden" class="id_prime" name="">
                  
                </div>
              
              <!-- /.card -->
            </div></div>
                  <div class="col-md-12">
              <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title">CHOISISSEZ UNE PERIODE</h3>
                      </div>
                      
                      <div class="card-body">
                        <div class="row">
                          

                          <div class="col-md-4">
                            <div class="form-group">          
                            <label>Date debut: </label>
                          <div class="input-group " id="" data-target-input="nearest" >
                              
                                <input type="date" class="form-control datetimepicker-input date_debut" data-target="#reservationdate" placeholder="date effet"  onchange="getBalancePourOperationVraquier();"/>
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                          </div>

                          </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">          
                            <label>Date fin: </label>
                          <div class="input-group " id="" data-target-input="nearest" >
                              
                                <input type="date" class="form-control datetimepicker-input date_fin" data-target="#reservationdate" placeholder="date effet"  onchange="getBalancePourOperationVraquier();"/>
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                          </div>

                          </div>
                          </div>
                          <div class="col-md-4">
                           <button class="btn-primary btn-lg">Rechercher</button> 
                          </div>


                          
                     
                        </div>
                        
                      </div>
                       <!-- /.card-body  -->
                    </div>
            </div>
          </div><div class="row">
            <div class="col-12 col-sm-12" >
              <h3 style="text-align: center;">RECETTES</h3>
                     <hr>
               

                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-carte" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab ">
                    <div class="overlay-wrapper">
                     <!-- <h1></h1> -->
                     <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title" style="text-align: center;">Location vraquier</h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                        </button>
                      </div>
                      </div>

                      <input type="hidden" class="id_chauffeur" name="">
                      <div class="card-body">
                     <div class="overlay-wrapper" style="">
                      <div class="overlay dark chargementPrime" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>
                      <table id="example9" class="table table-bordered table-striped">
                        <label>Total :</label>
                  <input type="text" name="" style="color:red" class=" totalEngin" disabled="true">
                  <thead>
                  <tr >
                    <th onclick="">N°</th>
                    <th>Code engin</th>
                    <th>Operation</th>
                    <th>Durée</th>
                    <th>Prix unitaire(FCFA)</th>
                    <th>Montant (FCFA)</th>
                    <th>Date</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody class="contentPrime9">
                 <!-- <?php
                 $this->crud_model_gestion_gazoil->selectAllReglement();
                  ?> -->
                  </tbody>
                 
                  </table>
                    </div>
                        </div>
                        
                        
                      </div>
                      <!-- /.card-body -->
                    </div>
                  </div>
               
                  
                </div>
              
              <!-- /.card -->
            </div>

           <div class="col-12 col-sm-12" >
              <h3 style="text-align: center;">VENTE DIVERSES</h3>
                     <hr>
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-carte" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab ">
                    <div class="overlay-wrapper">
                     
                     <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title" style="text-align: center;"></h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                        </button>
                      </div>
                      </div>

                      <input type="hidden" class="id_chauffeur" name="">
                      <div class="card-body">
                     <div class="overlay-wrapper" style="">
                      <div class="overlay dark chargementPrime" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>
                       <table id="example13" class="table table-bordered table-striped">
                        <label>Total :</label>
                  <input type="text" name="" value="" style="color:red" class="totalVente" disabled="true">
                  <thead>
                  <tr >
                    <th onclick="">N°</th>
                    <th>PIECES</th>
                    <th>OPERATION</th>
                    <th>Véhicule</th>
                    <th>DATE</th>
                    <th>MONTANT (FCFA)</th>
                    <th>CLIENT</th>
                    <th>LIBELLE</th>
                   
                  </tr>
                  </thead>
                  <tbody class="contentPrime13">
                 <?php
                 // $this->crud_model_depense->selectAllDepenseSalaireChauffeur();
                  ?>
                  </tbody></table>
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
          <h1 style="text-align: center;">DEPENSES</h1>
            <hr>
            <div class="row">
            <div class="col-12 col-sm-6" >
              <h3 style="text-align: center;">Primes</h3>
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-carte" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab ">
                    <div class="overlay-wrapper">
                     
                     <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title" style="text-align: center;"></h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                        </button>
                      </div>
                      </div>
                      <input type="hidden" class="id_chauffeur" name="">
                      <div class="card-body">
                     <div class="overlay-wrapper" style="">
                      <div class="overlay dark chargementPrime" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>
                      <table id="example2" class="table table-bordered table-striped">
                  <thead>
                  <tr >
                    <th onclick="">N°</th>
                    <th>Code</th>
                    <th>Montant (FCFA)</th>
                    <th>Libelle</th>
                    <th>Date</th>
                  </tr>
                  </thead>
                  <tbody class="contentPrime2">
                 <?php
                 // $this->crud_model_gestion_gazoil->selectAllReglement();
                  ?>
                  </tbody>
                  <label>Total :</label>
                  <input type="text" name="" value="" style="color:red" class="totalPrime" disabled="true">
                </table>
                    </div>
                        </div>
                        
                        
                      </div>
                      <!-- /.card-body -->
                    </div>
                  </div>
               
                  
                </div>
              
              <!-- /.card -->
            </div>
            <div class="col-12 col-sm-6" >
              <h3 style="text-align: center;">Frais de route</h3>
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-carte" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab ">
                    <div class="overlay-wrapper">
                     
                     <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title" style="text-align: center;"></h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                        </button>
                      </div>
                      </div>
                      <input type="hidden" class="id_chauffeur" name="">
                      <div class="card-body">
                     <div class="overlay-wrapper" style="">
                      <div class="overlay dark chargementPrime" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>
                      <table id="example3" class="table table-bordered table-striped">
                         <label>Total :</label>
                  <input type="text" name="" value="" style="color:red" class="totalFraisRoute" disabled="true">
                  <thead>
                  <tr >
                    <th onclick="">N°</th>
                   <th>Code</th>
                    <th>Montant (FCFA)</th>
                    <th>Destination</th>
                    <th>KM <i class="nav-icon fas fa-exchange-alt"></i></th>
                    <th>Date</th>
                  </tr>
                  </thead>
                  <tbody class="contentPrime3">
                 <?php
                 // $this->crud_model_gestion_gazoil->selectAllReglement();
                  ?>
                  </tbody></table>
                    </div>
                        </div>
                        
                        
                      </div>
                      <!-- /.card-body -->
                    </div>
                  </div>
               
                  
                </div>
              
              <!-- /.card -->
            </div>
            <div class="col-12 col-sm-6" >
              <h3 style="text-align: center;">Pieces de rechange</h3>
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-carte" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab ">
                    <div class="overlay-wrapper">
                     
                     <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title" style="text-align: center;"></h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                        </button>
                      </div>
                      </div>
                      <input type="hidden" class="id_chauffeur" name="">
                      <div class="card-body">
                     <div class="overlay-wrapper" style="">
                      <div class="overlay dark chargementPrime" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>
                      <table id="example4" class="table table-bordered table-striped">
                        <label>Total :</label>
                  <input type="text" name="" value="" style="color:red" class="totalPieceRechange" disabled="true">
                  <thead>
                  <tr >
                    <th onclick="">N°</th>
                   <th>Code</th>
                    <th>Article</th>
                    <th>Référence</th>
                    <th>PU (FCFA)</th>
                    <th>Qtité</th>
                    <th>PT (FCFA)</th>
                    <th>Date</th>
                  </tr>
                  </thead>
                  <tbody class="contentPrime4">
                 <?php
                 // $this->crud_model_gestion_gazoil->selectAllReglement();
                  ?>
                  </tbody></table>
                    </div>
                        </div>
                        
                        
                      </div>
                      <!-- /.card-body -->
                    </div>
                  </div>
               
                  
                </div>
              
              <!-- /.card -->
            </div>
            <div class="col-12 col-sm-6" >
              <h3 style="text-align: center;">Frais divers</h3>
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-carte" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab ">
                    <div class="overlay-wrapper">
                     
                     <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title" style="text-align: center;"></h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                        </button>
                      </div>
                      </div>
                      <input type="hidden" class="id_chauffeur" name="">
                      <div class="card-body">
                     <div class="overlay-wrapper" style="">
                      <div class="overlay dark chargementPrime" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>
                      <table id="example5" class="table table-bordered table-striped">
                        <label>Total :</label>
                  <input type="text" name="" value="" style="color:red" class="totalFraisDivers" disabled="true">
                  <thead>
                  <tr >
                    <th onclick="">N°</th>
                    <th>Code</th>
                    <th>Montant (FCFA)</th>
                    <th>Commentaire</th>
                    <th>Date</th>
                  </tr>
                  </thead>
                  <tbody class="contentPrime5">
                 <?php
                 // $this->crud_model_gestion_gazoil->selectAllReglement();
                  ?>
                  </tbody></table>
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
          <div class="row">
            <div class="col-12 col-sm-12" >
              <h3 style="text-align: center;">LISTE DES VIDANGES</h3>
                     <hr>
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-carte" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab ">
                    <div class="overlay-wrapper">
                     
                     <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title" style="text-align: center;"></h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                        </button>
                      </div>
                      </div>

                      <input type="hidden" class="id_chauffeur" name="">
                      <div class="card-body">
                     <div class="overlay-wrapper" style="">
                      <div class="overlay dark chargementPrime" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>
                      <table id="example6" class="table table-bordered table-striped">
                        <label>Total :</label>
                  <input type="text" name="" value="" style="color:red" class="totalVidange" disabled="true">
                  <thead>
                  <tr >
                    <th onclick="">N°</th>
                    <th>Code</th>
                    <th>Type huile</th>
                    <th>Huile</th>
                    <th>Quantité</th>
                    <th>Prix unitaire (FCFA)</th>
                    <th>Prix total (FCFA)</th>
                    <th>Date</th>
                  </tr>
                  </thead>
                  <tbody class="contentPrime6">
                 <!-- <?php
                 $this->crud_model_gestion_gazoil->selectAllReglement();
                  ?> -->
                  </tbody></table>
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
          <div class="row">
            <div class="col-12 col-sm-12" >
              <h3 style="text-align: center;">LISTE DES DEPENSES GAZOIL</h3>
                     <hr>
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-carte" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab ">
                    <div class="overlay-wrapper">
                     
                     <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title" style="text-align: center;"></h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                        </button>
                      </div>
                      </div>

                      <input type="hidden" class="id_chauffeur" name="">
                      <div class="card-body">
                     <div class="overlay-wrapper" style="">
                      <div class="overlay dark chargementPrime" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>
                      <table id="example7" class="table table-bordered table-striped">
                        <label>Total :</label>
                  <input type="text" name="" value="" style="color:red" class="totalGazoil" disabled="true">
                  <thead>
                  <tr >
                    <th onclick="">N°</th>
                    <th>Code</th>
                    <th>Numéro</th>
                    <th>Litrage</th>
                    <th>Prix unitaire (FCFA)</th>
                    <th>Destination</th>
                    <th>KM <i class="nav-icon fas fa-exchange-alt"></i></th>
                    <th>Prix total (FCFA)</th>
                    <th>Date</th>
                  </tr>
                  </thead>
                  <tbody class="contentPrime7">
                 <!-- <?php
                 $this->crud_model_gestion_gazoil->selectAllReglement();
                  ?> -->
                  </tbody></table>
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

                    <div class="row">
            <div class="col-12 col-sm-12" >
              <h3 style="text-align: center;">LISTE DES DEPENSES PNEU</h3>
                     <hr>
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-carte" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab ">
                    <div class="overlay-wrapper">
                     
                     <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title" style="text-align: center;"></h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                        </button>
                      </div>
                      </div>

                      <input type="hidden" class="id_chauffeur" name="">
                      <div class="card-body">
                     <div class="overlay-wrapper" style="">
                      <div class="overlay dark chargementPrime" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>
                      <table id="example11" class="table table-bordered table-striped">
                        <label>Total :</label>
                  <input type="text" name="" value="" style="color:red" class="totalPneu" disabled="true">
                  <thead>
                  <tr >
                    <th onclick="">N°</th>
                    <th>Véhicule</th>
                    <th>Article</th>
                    <th>Type</th>
                    <th>Derniere date</th>
                    <th>Date</th>
                    <th>PU(FCFA)</th>
                    <th>Qtité</th>
                    <th>PT(FCFA)</th>
                    <th>Commentaire</th>
                    
                 
                  </tr>
                  </thead>
                  <tbody class="contentPrime11">
                 <!-- <?php
                 $this->crud_model_gestion_gazoil->selectAllReglement();
                  ?> -->
                  </tbody></table>
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
          
          
          <div class="row">
            <div class="col-12 col-sm-12" >
              <h3 style="text-align: center;">LISTE DES ACCIDENTS </h3>
                     <hr>
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-carte" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab ">
                    <div class="overlay-wrapper">
                     
                     <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title" style="text-align: center;"></h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                        </button>
                      </div>
                      </div>

                      <input type="hidden" class="id_chauffeur" name="">
                      <div class="card-body">
                     <div class="overlay-wrapper" style="">
                      <div class="overlay dark chargementPrime" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>
                      <table id="example10" class="table table-bordered table-striped">
                        <label>Total :</label>
                  <input type="text" name="" value="" style="color:red" class="totalaccident" disabled="true">
                  <thead>
                  <tr >
                    <th onclick="">N°</th>
                    <th>CODE CAMION</th>
                    <th>DATE</th>
                    <th>LIEU</th>
                    <th>ENTREE</th>
                    <th>SORTIE</th>
                    <th>DEPENSE</th>
                    <th>PIECES UTILISEES</th>
                    <th>REFERENCE</th>
                    <th>PRIX</th>
                    <th>QUANTITE</th>
                    <th>TOTAL</th>
                    
                 
                  </tr>
                  </thead>
                  <tbody class="contentPrime10">
                 <!-- <?php
                 $this->crud_model_gestion_gazoil->selectAllReglement();
                  ?> -->
                  </tbody></table>
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

<script src="<?php echo base_url(); ?>assets/js/admin_depense.js"></script>
<script src="<?php echo base_url(); ?>assets/js/admin_gestion_gazoil.js"></script>
<script src="<?php echo base_url(); ?>assets/js/admin_rapport.js"></script>

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
            text: "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Imprimer</span>",
            className: "btn btn-white btn-primary btn-bold",
            autoPrint: true,
            message: 'MIRA TRANSPORT'
            },
            {
            extend: "pdf",
            text: "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Exporte en pdf</span>",
            className: "btn btn-white btn-primary btn-bold"
            },
            {
            extend: 'excelHtml5',
            autoFilter: true,
            sheetName: 'Exported data',
            text: "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Exporter en Excel</span>",
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


    $("#example2").DataTable({
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
            text: "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Imprimer</span>",
            className: "btn btn-white btn-primary btn-bold",
            autoPrint: true,
            message: 'MIRA TRANSPORT'
            },
            {
            extend: "pdf",
            text: "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Exporte en pdf</span>",
            className: "btn btn-white btn-primary btn-bold"
            },
            {
            extend: 'excelHtml5',
            autoFilter: true,
            sheetName: 'Exported data',
            text: "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Exporter en Excel</span>",
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
        $("#example6").DataTable({
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
            text: "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Imprimer</span>",
            className: "btn btn-white btn-primary btn-bold",
            autoPrint: true,
            message: 'MIRA TRANSPORT'
            },
            {
            extend: "pdf",
            text: "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Exporte en pdf</span>",
            className: "btn btn-white btn-primary btn-bold"
            },
            {
            extend: 'excelHtml5',
            autoFilter: true,
            sheetName: 'Exported data',
            text: "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Exporter en Excel</span>",
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
      $("#example3").DataTable({
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
            text: "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Imprimer</span>",
            className: "btn btn-white btn-primary btn-bold",
            autoPrint: true,
            message: 'MIRA TRANSPORT'
            },
            {
            extend: "pdf",
            text: "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Exporte en pdf</span>",
            className: "btn btn-white btn-primary btn-bold"
            },
            {
            extend: 'excelHtml5',
            autoFilter: true,
            sheetName: 'Exported data',
            text: "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Exporter en Excel</span>",
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
          $("#example4").DataTable({
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
            text: "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Imprimer</span>",
            className: "btn btn-white btn-primary btn-bold",
            autoPrint: true,
            message: 'MIRA TRANSPORT'
            },
            {
            extend: "pdf",
            text: "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Exporte en pdf</span>",
            className: "btn btn-white btn-primary btn-bold"
            },
            {
            extend: 'excelHtml5',
            autoFilter: true,
            sheetName: 'Exported data',
            text: "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Exporter en Excel</span>",
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
        $("#example5").DataTable({
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
            text: "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Imprimer</span>",
            className: "btn btn-white btn-primary btn-bold",
            autoPrint: true,
            message: 'MIRA TRANSPORT'
            },
            {
            extend: "pdf",
            text: "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Exporte en pdf</span>",
            className: "btn btn-white btn-primary btn-bold"
            },
            {
            extend: 'excelHtml5',
            autoFilter: true,
            sheetName: 'Exported data',
            text: "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Exporter en Excel</span>",
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

 $("#example7").DataTable({
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
            text: "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Imprimer</span>",
            className: "btn btn-white btn-primary btn-bold",
            autoPrint: true,
            message: 'MIRA TRANSPORT'
            },
            {
            extend: "pdf",
            text: "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Exporte en pdf</span>",
            className: "btn btn-white btn-primary btn-bold"
            },
            {
            extend: 'excelHtml5',
            autoFilter: true,
            sheetName: 'Exported data',
            text: "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Exporter en Excel</span>",
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

 $("#example8").DataTable({
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
            text: "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Imprimer</span>",
            className: "btn btn-white btn-primary btn-bold",
            autoPrint: true,
            message: 'MIRA TRANSPORT'
            },
            {
            extend: "pdf",
            text: "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Exporte en pdf</span>",
            className: "btn btn-white btn-primary btn-bold"
            },
            {
            extend: 'excelHtml5',
            autoFilter: true,
            sheetName: 'Exported data',
            text: "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Exporter en Excel</span>",
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

  $("#example9").DataTable({
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
            text: "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Imprimer</span>",
            className: "btn btn-white btn-primary btn-bold",
            autoPrint: true,
            message: 'MIRA TRANSPORT'
            },
            {
            extend: "pdf",
            text: "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Exporte en pdf</span>",
            className: "btn btn-white btn-primary btn-bold"
            },
            {
            extend: 'excelHtml5',
            autoFilter: true,
            sheetName: 'Exported data',
            text: "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Exporter en Excel</span>",
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

    $("#example11").DataTable({
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
            text: "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Imprimer</span>",
            className: "btn btn-white btn-primary btn-bold",
            autoPrint: true,
            message: 'MIRA TRANSPORT'
            },
            {
            extend: "pdf",
            text: "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Exporte en pdf</span>",
            className: "btn btn-white btn-primary btn-bold"
            },
            {
            extend: 'excelHtml5',
            autoFilter: true,
            sheetName: 'Exported data',
            text: "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Exporter en Excel</span>",
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