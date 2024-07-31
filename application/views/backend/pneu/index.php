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
  $pneu="";
  $ouvertPneu = "";
  $insertPneu = "";
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
        <!-- Main row -->
        <h3 style="text-align: center;">ENREGISTREMENT</h3>
        <hr>
        <div class="row">
          <!-- Left col -->

               <div class="row ">

          <div class="col-12 col-sm-5">

           <div class="col-md-12">

            <div class="card card-primary">
              
              <div class="card-header">
                <h3 class="card-title">ENREGISTREMENT DU TYPE DE PNEU</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="overlay dark chargementTypePneu" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>
              <div class="card-body">

               <form class="formAddCamion">
                 <div class="row">
                   <div class="col-sm-6">
                      <div class="form-group">
                        Nom du type de pneu
                            <input type="text" class="form-control nom_type" placeholder="Nom du type de pneu">
                        
                      </div>
                    </div>
                       <div class="col-sm-4">
                      <div class="form-group">
                        <br>  <?php
                            if ($this->session->userdata('pneu_ajout')=="true") {
                          echo '<button type="button" class=" btn-primary btn-lg  btnAddTypePneu"  onclick="addTypePneu(\'insert\');">Valider</button>'; } ?>
                          
                      </div>
                      </div>
                      <div class="col-sm-4">
                      <div class="form-group">
                        <br>  
                          <button type="button" class=" btn-primary btn-lg  btnModifTypePneu"  onclick="addTypePneu('update');" style="display: none;" >Modifier</button>
                      </div>
                      </div>
                      <div class="col-sm-4">
                      <div class="form-group">
                        <br><button type="button" class=" btn-primary btn-lg  btnAnnulerTypePneu"  onclick="annulerTypePneu();" style="display: none;">Annuler</button>
                      </div>
                      </div>
                    </div>
               </form> 
              </div>
              <div class="row">
                <div class="col-md-6">
                   <button onclick="window.location='<?php echo base_url() ?>admin/commande'" style="height: 50px; width: 150px;" class="menu_boutton btn btn-white btn-primary btn-bold"><i class="fas fa-file"></i> COMMANDE TRANSPORT</button>

                </div>
                <div class="col-md-6">
                  <button onclick="window.location='<?php echo base_url() ?>admin/commandeCimenterie'" style="height: 50px; width: 150px;" class="menu_boutton btn btn-white btn-primary btn-bold"><i class="fas fa-file"></i> COMMANDE CIMENTERIE</button>
                </div>
              </div>
             
              
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
            </div>
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
              <button type="button" class="btn btn-outline-light" data-dismiss="modal" onclick="confirmSuppressionPneu();">Confirmer</button>
              <input type="hidden" class="table" name="">
              <input type="hidden" class="identifiant" name="">
              <input type="hidden" class="nom_id" name="">
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

      <div class="modal fade" id="modal-info">
        <div class="modal-dialog">
          <div class="modal-content bg-info">
            <div class="modal-header">
              <h4 class="modal-title">Pneu défectueux ?</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <p> Cette action est irreversible</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Annuler</button>
              <button type="button" class="btn btn-outline-light" data-dismiss="modal" onclick="declarePneuDefectueux();">Confirmer</button>
              <input type="hidden" class="table" name="">
              <input type="hidden" class="identifiant" name="">
              <input type="hidden" class="nom_id" name="">
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
            <div class="col-12 col-sm-7">
         <div class="col-md-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">LISTE DES TYPES DE PNEU</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="overlay dark chargementTypePneu" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>
              <div class="card-body">
                <form class="formAddCamion2">
                 <div class="row">
                   <input type="hidden" name="" class="id_type_pneu1">
                    <table id="example" class="table table-bordered table-striped">
                  <thead>
                  <tr >
                    <th onclick="">N°</th>
                    <th>type de pneu</th>
                    <th>action</th>
                    
                  
                  </tr>
                  </thead>
                  <tbody class="contentTypePneu">
                 <?php $this->crud_model->selectAllTypePneu(); ?>
                  </tbody></table>
                   
                    </div>

                 </div>
               </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
            </div>
          
          </div>
     <div class="row">
      <div class="col-12 col-sm-12">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-carte" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab ">
                    <div class="overlay-wrapper">
                      <div class="overlay dark chargementPneu1" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Loading...</div></div>
                     <h3 style="text-align: center;">ENREGISTREMENT DES PNEUS</h3>
                     <hr>
                     <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title">Renseigner tous les champs</h3>
                      </div>
                      
                      <div class="card-body">
                        <div class="row">
                          <div class="col-sm-3">
                      <div class="form-group">
                        <label>Type pneu</label>
                        <select class="id_type_pneu form-control ">
                          <?php $this->crud_model->selectAllTypePneuPourSelection(); ?>
                            
                          </select>
                      </div>
                    </div>

                          <div class="col-md-3">
                            <label>Numéro</label>
                            <input type="text" class="form-control numero" placeholder="Numéro" onkeypress="">

                          </div>
                      <div class="col-md-3">
                            <label>Date création : </label>
                          <div class="input-group " id="" data-target-input="nearest" >
                              
                                <input type="date" class="form-control datetimepicker-input dateCreation" data-target="#reservationdate" placeholder="date effet" onchange="getExpirationPneu();" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                          </div>
                      </div>
                        <div class="col-md-3">
                            <label>Date expiration : </label>
                          <div class="input-group " id="" data-target-input="nearest" >
                              
                                <input type="date" class="form-control datetimepicker-input dateExpiration" data-target="#reservationdate" placeholder="date effet" disabled="" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                          </div>
                        </div>
                        </div>
                        <div class="row">
                          <div class="col-md-3">
                            <label>Code véhicule</label>
                          <input type="text" class="form-control code_camion2" onkeyup="getImmatriculationParCode();" name="">
                            <input type="hidden" class="id_pneu" name="">
                              
                            </div>
                            <div class="col-md-3">
                            <label>Immatriculation véhicule</label>
                              <select class="immatriculation form-control" onchange="getTypeVehicule(); getKilometrageGasoilParImmatriculation();">
                              <?php $this->crud_model_vehicule->getAllImmatriculation(); ?>
                                
                              </select>
                              <input type="hidden" class="id_pneu" name="">
                                
                            </div>

                          <div class="col-md-3">
                            <label>Kilométrage debut </label>
                              <input type="text" class="form-control kilometrage_debut" placeholder="Kilométrage" onkeypress="chiffres(event);" >
                          </div>

                          <div class="col-md-3">
                          <label>Kilométrage fin</label>
                            <input type="text" class="form-control kilometrage_fin" placeholder="Kilométrage" onkeypress="chiffres(event);"  value="0">
                          </div>

                        <div class="col-md-3">
                            <label>Date retrait: </label>
                          <div class="input-group " id="" data-target-input="nearest" >
                              
                                <input type="date" class="form-control datetimepicker-input date_retrait" data-target="#reservationdate" placeholder="date effet"/>
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                          </div>
                         </div>

                            <div class="col-md-3">
                              <label>type</label>
                            <input type="text" class="form-control type_camion" name="" disabled="true">
                            <input type="hidden" class="id_pneu" name="">
                              
                            </div>
                             <div class="col-md-3">
                              <label>Montant</label>
                            <input type="text" class="form-control montant" onkeyup ="formatMillier('montant');" name="" onkeypress="chiffres(event);">
                            <input type="hidden" class="id_pneu" name=" " >
                              
                            </div>
                        </div>

                        <div class="row">

                          <!-- <div class="col-md-4">
                            <label>Immatriculation véhicule</label>
                          <select class="immatriculation form-control">
                          <?php $this->crud_model_vehicule->getAllImmatriculation(); ?>
                            
                          </select>
                          <input type="hidden" class="id_pneu" name="">
                            
                          </div> -->
                          <div class="col-md-4 alertSucces">
                          <button type="button" class=" btn-primary btn-lg btnModif" style="display: none;"  onclick="addPneu('update');">Modifier</button>
                        
                           </div>
                 
                          <div class="col-md-4"><br> <button type="button" class=" btn-primary btn-lg btnAnnuler" style="display: none;" onclick="annulerModif();">Annuler</button> <button type="button" class=" btn-primary btn-lg btnAdd"  onclick="addPneu('insert');">Valider</button></div>
                        </div>
                        
                      </div>
                      <!-- /.card-body -->
                    </div>
                  </div>
               <input type="hidden" class="id_client" name="">
			   <input type="hidden" class="compte" value="<?php echo $this->session->userdata('identifiant') ?>">
                  
                </div>
              
              <!-- /.card -->
            </div>
          </div>
            <div class="col-12 col-sm-12" style="overflow: auto;">
              <h3 style="text-align: center;">VISUALISATION</h3>
                     <hr>
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-carte" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab ">
                    <div class="overlay-wrapper">
                     
                     <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title" style="text-align: center;">Liste des pneus</h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                        </button>
                      </div>
                      </div>
                      <input type="hidden" class="id_chauffeur" name="">
                      <div class="card-body">
                     <div class="overlay-wrapper" style="">
                      <div class="overlay dark chargementPneu" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>
                      <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr >
                    <th onclick="">N°</th>
                    
                    <th>Numéro</th>
                    <th>Montant (FCFA)</th>
                    <th>Création</th>
                    <th>Expiration</th>
                    <th>Retrait</th>
                    <th>Code</th>
                    <th>Matricule</th>
                    <th>Kilometrage debut</th>
                    <th>Kilometrage fin</th>
                    <th>Kilometrage</th>
                    <th>Durée</th>
                    <th>Etat</th>
                    <th>SERVICE</th>
                    <th>Défectueux</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody class="contentPneu">
                 <?php
                 $this->crud_model->selectAllPneu();
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
            message: 'MIRA TRANSPORT :::: PNEUS'
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
      "searching": true,
      // "ordering": true,
      "info": true,
      "autoWidth": false,
      // "responsive": true,
      // "responsive": true,
      // "autoWidth": true,
      "autoPrint": true,
     
     
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