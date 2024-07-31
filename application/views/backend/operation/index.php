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
  $operation="";
  $activeOperation = "";
  $ouvert8 = "";
  ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" type="text/css" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">

  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/toastr/toastr.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.css">
  <!-- summernote -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/summernote/summernote-bs4.css">
  <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
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
          <div class="col-12 col-sm-12">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-carte" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab ">
                    <div class="overlay-wrapper">
                      <div class="overlay dark chargementOperation" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Loading...</div></div>
                     <h3 style="text-align: center;">ENREGISTREMENT</h3>
                     <hr>
                     <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title">Renseigner tous les champs</h3>
                      </div>
                      
                      <div class="card-body">
                        <div class="row">
                          
                          <div class="col-md-3">
                          <label>Nom</label>
                            <input type="text" class="form-control nomOperation" placeholder="Nom de l'opération" onkeyup ="getNom();">
                          </div>
                          <div class="col-md-3">
                            <label>Date Chargement : </label>
                          <div class="input-group " id="" data-target-input="nearest">
                              
                                <input type="date" class="form-control datetimepicker-input dateCreation" data-target="#reservationdate" placeholder="date effet" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                          </div>
                        </div>
                          <div class="col-md-3">
                            <label>Date debut : </label>
                          <div class="input-group " id="" data-target-input="nearest" >
                              
                                <input type="date" class="form-control datetimepicker-input dateDebut" data-target="#reservationdate" placeholder="date effet" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                          </div>
                        </div>

                          <div class="col-md-3">
                            <label>Date fin : </label>
                          <div class="input-group " id="" data-target-input="nearest" >
                              
                                <input type="date" class="form-control datetimepicker-input dateFin" data-target="#reservationdate" placeholder="date effet" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
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
              <p> Voulez vous confirmer la suppression de ce chaffeur de la liste ?</p>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-outline-light" data-dismiss="modal">Annuler</button>
              <button type="button" class="btn btn-outline-light" data-dismiss="modal" onclick="confirmSuppressionClient();">Confirmer</button>
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
                        <br>
                        <div class="row">
                          <div class="col-md-3">
                          <label>Produit</label>
                          <div class="input-group " id="" data-target-input="nearest">
                              <input type="text" class="form-control produit" placeholder="produit">
                          </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                            <label>Client</label>
                            <select class="client form-control">
                             
                              <?php $this->crud_model_operation->leSelectClient(); ?>
                                
                              </select>
                          </div>
                   
                          </div>
						  
                          <div class="col-md-3">
                          <div class="form-group">
                              <label value="">Type Opération</label>
                              <select class="typeOperation form-control">
                                <option></option>
                                <option value="interne">Interne</option>
                                <option value="externe">Externe</option>
                                </select>
                            </div>
                    
                          </div>
						  
						  <div class="col-md-3">
                          <div class="form-group">
                              <label value="">Filiale</label>
                              <select class="filiale form-control">
                                <option></option>
								<option value="MIRA ACCONAGE">MIRA ACCONAGE</option>
								<option value="MIRA BASE">MIRA BASE</option>
								<option value="MIRA CARRIERE">MIRA CARRIERE</option>
                                <option value="MIRA CIMENTERIE">MIRA CIMENTERIE</option>
								<option value="MIRA NEGOCE">MIRA NEGOCE</option>
								<option value="MIRA STEEL">MIRA STEEL</option>
                                <option value="MIRA TRANSPORT">MIRA TRANSPORT</option>
								
                              </select>
                            </div>
                    
                          </div>
						  
						  
						  
                          <div class="col-md-3">
						  <label>Description</label>
                          <div class="input-group " id="" data-target-input="nearest">
                            <textarea class="commentaire form-control" placeholder="Description"></textarea>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <label>Destination</label>
                          <div class="input-group ">
                            
                            <input type="text" class="destination form-control" placeholder="destination " name="">
                          </div>
                        </div>
						
											  
						  <div class="col-md-3" >
                            <!-- <label>Distance</label> -->
                            <input type="text" class="form-control distance" value="0" placeholder="Facture" onkeypress="chiffres(event);" style="display: none;">
                             <div class="form-group">
                            <label>N° Facture Client</label>
                           <input type="text" class="form-control num_client" name="" value="<?php echo $this->crud_model_operation->genererChaineAleatoireOperation();?>">
                          </div>
                          </div>

                          
                        </div>
                        <input type="hidden" class="id_operation" name="">
						<input type="hidden" class="compte" value="<?php echo $this->session->userdata('identifiant') ?>">
                        <div class="row">
                          <div class="col-md-4">
                            <button type="button" class=" btn-primary btn-lg btnModifier" style="display: none;"  onclick="addOperation('update');">Modifier</button>
                          </div>
                          <div class="col-md-4 alertSucces">
                            <button type="button" class=" btn-primary btn-lg btnAnnuler " style="display: none;" onclick="annulerSuppression();">Annuler</button>
                          </div>
                          <div class="col-md-4"><br>  
                            <?php
                            if ($this->session->userdata('operation_ajout')=="true") {
                          echo '<button type="button" class=" btn-primary btn-lg btnAdd"  onclick="addOperation(\'insert\');">Valider</button>'; } ?></div>
                          
                        </div>
                        
                      </div></div>
                      <!-- /.card-body -->
                    </div>
                  </div>
               
                  
                </div>
              
              <!-- /.card -->
            </div>

            <div class="col-12 col-sm-12" style="overflow: auto;">
              <h3 style="text-align: center;">VISUALISATION</h3>
                     <hr>
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-carte" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab ">
                    <div class="overlay-wrapper">
                     
                     <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title">Liste des opérations</h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                        </button>
                      </div>
                      </div>
                      
                      <div class="card-body">
                     <div class="overlay-wrapper" >
                      <div class="overlay dark chargementOperation1" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>
                      <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr >
                    <th onclick="">N°</th>
                    <th>Operation</th>
                    <th>Type</th>
                    <th>Création</th>
                    
                    <th>Fin</th>
                    <th>Client</th>
                    <th>Produit</th>
                    
                    <th>Description</th>
                    <th>Destination</th>
					<th>N° Facture</th>
					<th>Facture Client</th>
					<th>Filiale</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody class="contentOperation">
                 <?php
                 $this->crud_model_operation->selectAllOperation();
                  ?>
                  </tbody></table>
                    </div>
                        </div>

                        
                       </div> 
                      </div>
                      </div>

                    </div>
                  
                             <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-carte" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab ">
                    <div class="overlay-wrapper">
                     
                     <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title" style="text-align: center;">Détail de l'opération</h3>
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
                   
                      <table id="example7" class="table table-bordered table-striped " style="border: none;" cellpadding="0" cellspacing="0">
                  <thead>
                    <tr >
                       <th colspan="10" style="text-align: center; border: 5px solid #FFFFF; border-left: none; border-right: none;">
                          
                        <span style="color: blue; font-weight: bold; font-size: 55px; text-align: center; ">
                          <img src="<?php echo base_url(); ?>assets/image/MIRA_NEW.jpg" style="width: 800px; margin-left: -5px;"></span> 
                        <br>
                       
                      </th>
                        
                      <tr>
                        <td colspan="12"  style="border: none;"></td>
                      </tr>
                  <tr style=" margin: 0px;">
                    <td onclick="" colspan="2" style=" margin: 0px;border: none; border-bottom: 2px solid black; ">
                      <br/><br/><br/><br/>
                          <span style="font-size: 25px; border: none; font-weight: bold;">FACTURE : </span> <br/>
                           <!-- <span style="font-size: 16px;font-weight: bold;">Période: Tous</span> -->
                    
                    </td>
                    <td onclick="" colspan="1" style=" margin: 0px;border: none; border-bottom: 2px solid black; ">
                      <br/><br/><br/><br/>
                          <span style=" font-size: 25px; border: none; font-weight: bold;" class="nom_op"></span>
                     
                    </td>
                    <td colspan="2" style=" margin: 0px;border: none; border-bottom: 2px solid black; "></td>
                    
                    <td colspan="3" style=" text-align: left; margin: 0px;border: none; border-bottom: 2px solid black; font-weight: bold;">
                      <span style="font-size: 20px;" class="client">APM TERMINALS CAMEROUN S.A</span><br/>
                      <span style="font-size: 15px;" class="date_debut">B.P: 3479 RUE NJO-NJO BONAPRISO</span><br/>
                      <span style="font-size: 15px;"  class="date_creation">NIU: Mo11400048523k</span><br/>
                      <!-- <span style="font-size: 15px;">BC N° C42761</span><br/> -->
                          <!-- <span><?php echo date('d/m/H H:i:s'); ?></span> -->
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

                   <!--  <td colspan="8" style="margin: 0px; padding: 0px;"><br/><br/></td></tr> -->
                  <!-- <tr><td colspan="8" style="margin: 0px; padding: 0px;"></td></tr> -->
                 <!--  <tr style="margin: 0px; padding: 0px; text-align: center; font-weight: bold; ">
                    <td style="margin: 0px; padding: 0px;">Opération</td> 
                    <td class="date_creation2" style="margin: 0px; padding: 0px;">Création</td> 
                    <td class="date_creation2" style="margin: 0px; padding: 0px;">Début</td>
                    <td class="date_creation2" style="margin: 0px; padding: 0px;">Fin</td>
                    <td class="date_creation2" style="margin: 0px; padding: 0px;">Client</td> 
                    <td class="date_creation2" style="margin: 0px; padding: 0px;">Type</td> 
                   
                  </tr>
                  <tr style="margin: 0px; padding: 0px; text-align: center;">
                    <td style="margin: 0px; padding: 0px;" class="nom_op"></td> 
                    <td class="date_creation" style="margin: 0px; padding: 0px;"></td> 
                    <td class="date_debut" style="margin: 0px; padding: 0px;"></td>
                    <td class="date_fin" style="margin: 0px; padding: 0px;"></td>
                    <td class="client" style="margin: 0px; padding: 0px;"></td> 
                    <td class="type_operation" style="margin: 0px; padding: 0px;"></td>  
                  </tr> -->
 
                  <div >
                    
                  </div>

                  
                    

                  </thead>
                   <br/>

                  <!-- <thead class="chargementRetour">
                   <tr>
                    <td colspan="9" style="border: none; text-align: center; font-size: 25px; background: #bec7ea;">
                      CHARGEMENT RETOUR
                    </td>
                  </tr>
                  
                  <tr style="background: white; color: black; font-size: 18px; font-weight: bold; " >
                    
                    <td style="border-bottom: : 1px solid black;width: 13%; text-align: center;border-bottom: 3px solid black; ">Code engin</td>
                    <td colspan="2" style=" width: 10%; text-align: center;border-bottom: 3px solid black; ">Véhicule <br/></td>
                    <td style="border-left: 1px solid white;width: 17%;  text-align: center;border-bottom: 3px solid black; ">Durée</td>
                    <td style="border-left: 1px solid white;width: 10%; text-align: center;border-bottom: 3px solid black; ">PU</td>
                    <td style="border-left: 1px solid white; text-align: center;border-bottom: 3px solid black; ">Montant</td>
                    <td style="border-left: 1px solid white; text-align: center;width: 5%;border-bottom: 3px solid black; ">Date</td>
                    <td style="border-left: 1px solid white; text-align: center;width: 10%;border-bottom: 3px solid black; ">Destination</td>
                    
                    <br/>
                  </tr>

                  </thead> -->
                  

                </table>
                <a href="#contentDetailCommande2" id="contentDetailCommande2"></a>
                <div class="locationEngin"> 
                    
                  </div>

                <div class="chargementRetour"> 
                    
                  </div>

                <div class="netPayer"> 
                    
                  </div>

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
          
                      <!-- /.card-body -->
                    
               
                  
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
<script src="<?php echo base_url(); ?>assets/js/admin_operation.js"></script>
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
            message: 'MIRA TRANSPORT :::: OPERATION'
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
