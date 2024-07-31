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
 $balanceImprimeFournisseurArticle=""; 
$ouvertFournisseurArticle="";
  $activeFournisseurArticle="";
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
 <style type="text/css">
   
 </style>

  <!-- Main Sidebar Container -->
<?php 
include 'assets/include_menu.php';
?>

   <div class="content-wrapper" >
    <!-- Content Header (Page header) -->
    <div class="content-header" style="background: #64c5ff8a;">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
           
            <h1 class="m-0 text-dark"><?php echo $page_title; ?></h1>
            
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-left">
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
       
          <!-- Left col -->
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
                        <h3 class="card-title">Sélectionnez un Fournisseur</h3>
                      </div>
                      
                      <div class="card-body">
                        <div class="row">
                          

                          <div class="col-md-12">
                            <div class="form-group">
                            <label>Fournisseur</label>
                            <select class="id_fournisseur form-control  articles" onchange="getBalanceImprimableClient();">
                             
                             <?php $this->crud_model_article->leSelectFournisseurArticle(); ?>
							 
                              </select>
                          </div>
                             <div class="col-md-12 initial">
                            <h3>Initialisation</h3>
							<hr>
                            <div class="form-group">
                            <label>Solde</label>
                            <input type="text" class="form-control solde_initial" disabled="true" name="">
                          </div>
                          <div class="form-group">
                            <label>Date</label>
                            <div class="input-group " id="" data-target-input="nearest" >
                              
                                <input type="text" class="form-control date_initial" data-target="#reservationdate" disabled="true" />
                               
                          </div>
                          </div>
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
                     <div class="card card-warning">
                      <div class="card-header">
                        <h3 class="card-title">TOTAUX</h3>
                      </div>
                      
                      <div class="card-body">
                        <div class="row">
                          

                          <div class="col-md-12">
                            <div class="form-group">          
                            Credit : <input type="text" disabled="true" class="totalRetrait5 form-control" name="">
                            Debit : <input type="text" disabled="true"  class="totalReglement form-control" name="">
                            Repport à nouveau : <input type="text" disabled="true"  class="repportNouveau form-control" name="">

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
                              
                                <input type="date" class="form-control datetimepicker-input date_debut" data-target="#reservationdate" placeholder="date effet"  onchange="getBalanceImprimableClient();" value="<?php echo date('Y-m-d'); ?>"/>
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
                              
                                <input type="date" class="form-control datetimepicker-input date_fin" data-target="#reservationdate" placeholder="date effet"  onchange="getBalanceImprimableClient();" value="<?php echo date('Y-m-d'); ?>"/>
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                          </div>

                          </div>
                          </div>
                          <div class="col-md-4">
                           <!-- <button class="btn-primary btn-lg">Rechercher</button> -->
                          </div>


                          
                     
                        </div>
                        
                      </div>
                      <!-- /.card-body -->
                    </div>
            </div>
          <div class="col-12 col-sm-12">
            <h3 style="text-align: center;">VISUALISATION</h3>
                     <hr>
            <div class="card card-primary card-tabs">
              
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
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-carte" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab ">
                    <div class="overlay-wrapper">
                     
                     <div class="card card-info">
                      <div class="card-header">
                        <h3 class="card-title">RELEVE COMPTE FOURNISSEUR</h3>
                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
                        </button>
                      </div>
                      </div>
                      
                      <div class="card-body">
                     <div class="overlay-wrapper" >
                      <div class="overlay dark chargementPrime" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>
                      <input type="hidden" class="id_BL" name="">
                <div id="zone2">
                <table id="example7" class="table tab2 table-bordered" style="border: none;" cellpadding="0" cellspacing="0">
                  <thead>
                      <tr><td colspan="5" style="text-align: center;"> <span style="font-size: 25px; border: none; font-weight: bold; text-align: center;">RELEVE COMPTE FOURNISSEUR :</span> <span style="font-size: 23px; border: none; font-weight: bold;" class="client"></span></td>
                   </tr>
                  <tr style=" margin: 0px;">
                         <td onclick=""  style=" margin: 0px;border: none;">
                      
                          <span style="font-size: 20px; border: none; font-weight: bold;">SOCIETE MIRA SA</span><br/>
                          <span style="font-size: 13px;">COMMERCE GENERALE</span><br/>
                          <span style="font-size: 13px;">N°RC: 07/B/644</span><br/>
                          <span style="font-size: 13px;">N° CONT: M 02070002237B</span><br/>
                          <span style="font-size: 13px;">B.P 12205 DOUALA</span><br/>
						  <span style="font-size: 13px;">Téléphone: 679 091 919</span><br/>
						  <span style="font-size: 13px;">Email: mira_sarl@yahoo.fr</span>
                    </td>
                    <td  style=" margin: 0px;border: none; ">
                      
                      <!-- <span style="font-size: 12px; border: none; font-weight: bold;" >CLIENT : </span><span style="font-size: 13px; border: none; font-weight: bold;" class="client"></span><br/>
 -->                      <span style="font-size: 13px; border: none; font-weight: bold;" >VILLE : DOUALA </span>
                      <span style="font-size: 13px; border: none; font-weight: bold;" class="villeClient"></span><br/>
                      <span style="font-size: 13px; border: none; font-weight: bold;" >ADRESSE : </span>
                      <span style="font-size: 13px; border: none; font-weight: bold;" class="adresseClient"></span><br/>
                      <span style="font-size: 13px; border: none; font-weight: bold;" >Téléphone : </span>
                      <span style="font-size: 13px; border: none; font-weight: bold;" class="telephoneClient"></span>

                    </td>
                    <td style=" margin: 0px;border: none; ">
                      <span style="font-size: 16px; border: none; ">Période : de</span>
                           <span style="font-size: 16px;" class="date_debut1">-------- </span> à <span style="font-size: 16px;" class="date_fin1">----------</span> <br/>
                      <span style="font-size: 16px; border: none;">Date initiale: </span><span style="font-size: 16px;" class="date_initial1">----------</span><br/>
                      <span style="font-size: 14px; border: none; font-weight: bold;">Solde initial : </span><span style="font-size: 16px;" class="solde_initial1">-------------</span><br/>
                      <span style="font-size: 13px; border: none; font-weight: bold;" >RAN Debit : </span>
                      <span style="font-size: 13px; border: none; font-weight: bold;" class="repportNouveauCredit1">-------------</span><br/>
                      <span style="font-size: 13px; border: none; font-weight: bold;" >RAN Credit : </span>
                      <span style="font-size: 13px; border: none; font-weight: bold;" class="repportNouveauDebit1">-----------</span><br/>
                      
                      <span style="font-size: 13px; border: none; font-weight: bold;" >Credit : </span>
                      <span style="font-size: 13px; border: none; font-weight: bold;" class="debit">-----------</span><br/>
                      <span style="font-size: 13px; border: none; font-weight: bold;" >Debit : </span>
                      <span style="font-size: 13px; border: none; font-weight: bold;" class="credit">-------------</span><br/>
                      <span style="font-size: 13px; border: none; font-weight: bold;" >Repport à nouveau : </span>
                      <span style="font-size: 13px; border: none; font-weight: bold;" class="repportNouveau1">-------------</span><br/><br/>
                      <span style="font-size: 20px; border: none; font-weight: bold;" >Solde : </span>
                      <span style="font-size: 20px; border: none; font-weight: bold;" class="solde1">-------------</span>

                    </td>
                    
                      
                      
                  </tr>
                </thead>
              </table>
              </div>
              <!-- <button onclick="imprimer_bloc_complet('titre','selectionAimprier','zone2');" class="btn btn-white btn-primary btn-bold"><i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span></button> -->
              <div id="selectionAimprier" style="margin: 30px;"> 
                      <table id="example1" class="table table-bordered table-striped tab1">
                  <thead>
                  <!-- <tr >
                    <th>N°</th>
                    <th>DATE</th>
                    <th>AVIS CREDIT</th>
                    <th>AVIS DEBIT</th>
                   
                    <th>FACTURE CLIENT</th>
                    <th>FACTURE ARTICLE</th>
                    <th>ACCUSE RETRAIT</th>
                    <th>ACCUSE REGLEMENT</th>
                    <th>REPPORT A NOUVEAU</th>
                    <th>SOLDE</th>
                  </tr> -->
                 <!--  <tr style=" margin: 0px;">
                    <th onclick=""  style=" margin: 0px;border: none;" colspan="3">
                      
                          <span style="font-size: 20px; border: none; font-weight: bold;">SOCIETE MIRA SA</span><br/>
                          <span style="font-size: 13px;">COMMERCE GENERALE</span><br/>
                          <span style="font-size: 13px;">N°RC: 07/B/644</span><br/>
                          <span style="font-size: 13px;">N° CONT: M 02070002237B</span><br/>
                          <span style="font-size: 13px;">B.P 12206 DOUALA</span>
                    </th>
                    <th  style=" margin: 0px;border: none; " colspan="2">
                      <span style="font-size: 16px; border: none; ">Téléphone: 677 117 446</span>
                           <span style="font-size: 16px;"> / 650 102 544</span> <br/>
                      <span style="font-size: 16px; border: none;">Email: mira_sarl@yahoo.fr</span><br/>
                      <span style="font-size: 20px; border: none; font-weight: bold;" class="client">NOM DU CLIENT</span><br/>
                      <span style="font-size: 13px; border: none; font-weight: bold;" >VILLE :</span>
                      <span style="font-size: 13px; border: none; font-weight: bold;" class="villeClient"></span><br/>
                      <span style="font-size: 13px; border: none; font-weight: bold;" >ADRESSE :</span>
                      <span style="font-size: 13px; border: none; font-weight: bold;" class="adresseClient"></span><br/>
                      <span style="font-size: 13px; border: none; font-weight: bold;" >Téléphone :</span>
                      <span style="font-size: 13px; border: none; font-weight: bold;" class="telephoneClient"></span>

                    </th>
                    <th style=" margin: 0px;border: none; " colspan="3">
                      <span style="font-size: 16px; border: none; ">Période : de</span>
                           <span style="font-size: 16px;" class="date_debut1">-------- </span> à<span style="font-size: 16px;" class="date_fin1">----------</span> <br/>
                      <span style="font-size: 16px; border: none;">Date initiale: </span><span style="font-size: 16px;" class="date_initial1">----------</span><br/>
                      <span style="font-size: 20px; border: none; font-weight: bold;">Solde initial</span><span style="font-size: 16px;" class="solde_initial1">-------------</span><br/>
                      <span style="font-size: 13px; border: none; font-weight: bold;" >Credit :</span>
                      <span style="font-size: 13px; border: none; font-weight: bold;" class="credit">-----------</span><br/>
                      <span style="font-size: 13px; border: none; font-weight: bold;" >Debit :</span>
                      <span style="font-size: 13px; border: none; font-weight: bold;" class="debit">-------------</span><br/>
                      <span style="font-size: 13px; border: none; font-weight: bold;" >Repport à nouveau :</span>
                      <span style="font-size: 13px; border: none; font-weight: bold;" class="repportNouveau1">-------------</span><br/>
                      <span style="font-size: 13px; border: none; font-weight: bold;" >Solde :</span>
                      <span style="font-size: 13px; border: none; font-weight: bold;" class="solde1">-------------</span>

                    </th>
                    
                      
                      
                  </tr> -->
                  <tr style="border: 2px solid black; color: red;">
                    
                    <th style="border: 2px solid black; color: red;">DATE</th>
                    <th style="border: 2px solid black; color: red;">N° piece</th>
                    <th style="border: 2px solid black; color: red;">Libellé écriture</th>
                    <th style="border: 2px solid black; color: red;">Debit</th>
                    <th style="border: 2px solid black; color: red;">Credit</th>
                    <th style="border: 2px solid black; color: red;">Solde</th>
                    <!-- <th>AVIS DEBIT && MOTIF</th> -->
                    <!-- <th>AVIS CREDIT && MOTIF</th> -->
                   
                   
                    <!-- <th>ACCUSE RETRAIT && MOTIF</th> -->
                    <!-- <th>ACCUSE REGLEMENT && MOTIF</th>
                    <th>FACTURE CLIENT && REFERENCE</th> -->
                   <!--  <th>FACTURE ARTICLE && REFERENCE</th>
                    <th>SOLDE</th> -->
                  </tr>
                  </thead>
                  <tbody class="contentClient">
                 <?php
                 // $this->crud_model_commercial->liste_compte();
                  ?>
                  </tbody>
                </table>
              </div>
                    </div>
                        </div>
                      </div>
                      <!-- /.card-body -->
                    </div>
                  </div>
               
                  
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
<script src="<?php echo base_url(); ?>assets/js/admin_document.js"></script>

<script src="<?php echo base_url(); ?>assets/js/nombre_en_lettre.js"></script>
<script src="<?php echo base_url(); ?>assets/js/admin_client.js"></script>
<script src="<?php echo base_url(); ?>assets/js/admin.js"></script>
<script src="<?php echo base_url(); ?>assets/js/admin_depense.js"></script>
<script src="<?php echo base_url(); ?>assets/js/admin_article.js"></script>
<script>

  $(function () {
    // toastr.info("goooooo");
    // getDestinationParCodeCamion();
    
    $("#example1").DataTable({
      "lengthChange": false,
      "searching": true,
      // "ordering": true,
      "info": true,
      "autoWidth": false,
      // "responsive": true,
      // "responsive": true,
      // "autoWidth": true,
      "columnDefs": [ {
            "visible": true,
            "targets": 1
        } ],
      "autoPrint": true,
       dom: 'Bfrtip',
        buttons: [
         {
            extend: "print",
            text: "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
            className: "btn btn-white btn-primary btn-bold",
            autoPrint: true,
            message: 'MIRA TRANSPORT :::: BONS DE LIVRAISON'
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
