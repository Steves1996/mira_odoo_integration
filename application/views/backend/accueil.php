<!DOCTYPE html>
<html>
<?php 
  if($this->session->userdata('id_profil')!=null){
    redirect(base_url()."admin/administration", 'refresh');
  }
 ?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Wood work</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/toastr/toastr.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<style type="text/css">
    .menu_boutton{
      
      border:none;
      border-radius: 5px;
      transition-duration: 0.7s;
    }
    .menu_boutton:hover{
      background: black;
      transition-duration: 0.7s;
      border:none;
      border-radius: 20px;
      color:white;
    }
  </style>
</head>
<!-- <body class="login-page" style="background: rgba(0, 0, 0, 0) linear-gradient(to right, rgb(49, 66, 106) 0%, rgb(240, 242, 253) 70%, rgba(84, 103, 128, 0.45) 90%) repeat scroll 0% 0%;"> -->

<body class="hold-transition login-page" style="background: rgb(2,2,8) url(<?php echo base_url(); ?>assets/image/cimenterie2.jpg) no-repeat; background-size: cover;">
  <div style="background: #372e2e63;">
<div class="login-box" style="width: 800px;" >
  <div class="login-logo">
<h1 style="font-size: 65px; border: 5px white; color: white;"> BIENVENUE A MIRA S.A</h1>
    <button class="menu_boutton" onclick="window.location='<?php echo base_url() ?>admin/login'">SE CONNECTER</button>
  </div>
  <!-- /.login-logo -->
 
</div>

<!-- <div class="container" >
  <br>
  <br>
  <br>
  <br>
  <br><br><br><br>

  <div class="row">
    <div class="col-md-4">
      
    </div>
    <div class="col-md-4">
   
<b><h1>BIENVENUE à </h1></b>  <h1>BIENVENUE à </h1>
    <button>SE CONNECTER</button>

    </div>
    <div class="col-md-4">
      
    </div>
  </div>
  
 
</div> -->
<!-- /.login-box -->

<!-- jQuery -->
</div>
<script src="<?php echo base_url(); ?>assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url(); ?>assets/dist/js/adminlte.min.js"></script>

<script src="<?php echo base_url(); ?>assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/toastr/toastr.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/admin.js"></script>


</body>
</html>
