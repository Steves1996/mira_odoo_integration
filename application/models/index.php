<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>EJSMARTJOBS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8" />
    <meta name="keywords" content="Intense Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
	SmartPhone Compatible web template, free WebDesigns for Nokia, Samsung, LG, Sony Ericsson, Motorola web design" />
    <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>

    <script>
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }

        // $(".collapse").collapse();
    </script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" >
 
 
 
<link rel="stylesheet" href="/resources/demos/style.css" >
 
 
 
<script src = "https://code.jquery.com/jquery-1.12.4.js" >  </script >
 
 
 
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js">  </script >
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.6/owl.carousel.min.js"></script>
 
<!--  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css" >
 
 
 
<link rel="stylesheet" href="/resources/demos/style.css" >
 
 
 
<script src = "<?php echo base_url(); ?>assets/js/jquery-1.12.4.js" >  </script >
 
 
 
<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js">  </script > -->
 
<script > 
 
 
$(function () {
 
 
 
$("#accordion" ).accordion({
    active: false,
    heightStyle: "content"
});
 
 
 
} );
 
 
 
</script >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.6/assets/owl.carousel.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.6/assets/owl.theme.default.min.css" /> 
 
    <!-- Custom Theme files -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
    <!-- <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" type="text/css" rel="stylesheet" media="all"> -->
    <link href="<?php echo base_url(); ?>assets/css/style.css" type="text/css" rel="stylesheet" media="all">
    <!-- <link href="<?php echo base_url(); ?>assets/css/styles.css" type="text/css" rel="stylesheet" media="all"> -->
    <!-- font-awesome icons -->
    <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/animate.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/neon-core.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/neon-forms.css" rel="stylesheet">
    
    <!-- //Custom Theme files -->
    <!-- online-fonts -->
    <link href="//fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
    <style type="text/css">
        html {
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    height: 100%;
    font-size: 90.5%
}

*,
::after,
::before {
    -moz-box-sizing: inherit;
    box-sizing: inherit
}


        .styleButton{
            width: 40px;
            background: #d70a0aa6;
            border: none;
            color: white;
            border-radius: 5px;
            box-shadow: 5px 5px 5px 5px black;
            transition: 1s;
        }
        .styleButton:hover{
            transition: 1s;
            width: 70px;
            /*height: 40px;*/
            
        }

        .fleche{
            height: 50px;
            width: 60px; 
            background-color: #ee5a52bf; 
            border-radius: 30px; 
            cursor: pointer;
            transition: 1s;
        }
        .fleche:hover{
            width: 80px;
            height: 70px;
            transition: 1s;
        }
        .flecheDroite{
            width: 100px; 
            height: 100px;
            position: relative;
           /* z-index: 5;*/
             animation: bounce 0.7s ease infinite;
        }
        

@keyframes bounce{
     from {left: 26px;}
     50%  {left: -26px;}
     to   {left: 26px;}
}
.flechebas{
    width: 120px; 
    height: 170px;
    position: relative;
     /* z-index: 5;*/
    animation: bouncebas 0.7s ease infinite;
}
@keyframes bouncebas{
     from {top: 26px;}
     50%  {top: -26px;}
     to   {top: 26px;}
}
p.premier {
    font-family:"nom de la fonte du corps de texte";
   /*text-align:justify;
   text-indent:0;*/
    margin-top:6%;
    /*-webkit-hyphens:none;*/
} 
span.lettrine {
    float:left;
    font-family:"nom de la fonte de lettrine";
    font-size:3em;
    text-indent:0;
    /*margin-right:0.1em;*/
}
.premier::first-letter {
  font-family:lobster;
  font-size:3.5em;
  /*padding-right:0.2em;*/
  float:left;
  /*color:red;*/
}
.btnEnvoyer{
    background:#60cead;
    color:white;
    box-sizing: 23px;
    box-shadow: 2px 0px 12px 0px #4819f2e6;
    border-radius: 9px;
    size: 20px;
    width: 140px;
    transition: 0.5s;
}
.btnEnvoyer:hover{
    background:#60cead;
    color:white;
    box-sizing: 23px;
    box-shadow: 2px 0px 12px 0px #4819f2e6;
    border-radius: 9px;
    size: 20px;
    width: 180px;
    transition: 0.5s;
}
.btnEnvoyer:active{
    background:#5de2f0;
    color:white;
    box-sizing: 23px;
    box-shadow: 2px 0px 12px 0px #4819f2e6;
    border-radius: 9px;
    size: 20px;
    width: 140px;
    transition: 0.5s;
}


.vignets {
    
    animation: fadein 2s;
    -moz-animation: fadein 2s; /* Firefox */
    -webkit-animation: fadein 2s; /* Safari et Chrome */
    -o-animation: fadein 2s; /* Opera */
}
@keyframes fadein {
    from {
        opacity:0;
    }
    to {
        opacity:1;
    }
}
@-moz-keyframes fadein { /* sur Firefox */
    from {
        opacity:0;
    }
    to {
        opacity:1;
    }
}
@-webkit-keyframes fadein { /* sur Safari et Chrome */
    from {
        opacity:0;
    }
    to {
        opacity:1;
    }
}
@-o-keyframes fadein { /* sur Opera */
    from {
        opacity:0;
    }
    to {
        opacity: 1;
    }
}

.vignets {
    opacity: 0;
   
    -webkit-transition: opacity 2s ease-in;
    -moz-transition: opacity 2s ease-in;
    -o-transition: opacity 2s ease-in;
    -ms-transition: opacity 2s ease-in;
    transition: opacity 2s ease-in;
}
.vignets.load {
    opacity: 1;
}
.bouge1{
    height: 200px;
    width: 250px;
}
}
.bouge1:hover{
    height: 400px;
    width: 500px;
}
.decoreCollapse{
   background-image: url(<?php echo base_url(); ?>assets/images/fond/fond8.jpg); 
   background-attachment: fixed; 
   background-size: cover; 
   background-repeat: none;
   color: white; 
}
.decoreCollapse1{
   background-image: url(<?php echo base_url(); ?>assets/images/fond/fond9.jpg); 
   background-attachment: fixed; 
   background-size: cover; 
   background-repeat: none;
   color: white; 
}
.decoreCollapse2{
   background-image: url(<?php echo base_url(); ?>assets/images/fond/fond23.jpg); 
   background-attachment: fixed; 
   background-size: cover; 
   background-repeat: none;
   color: white; 
}
.decoreCollapse3{
   background-image: url(<?php echo base_url(); ?>assets/images/fond/fond19.jpg); 
   background-attachment: fixed; 
   background-size: cover; 
   background-repeat: none;
   color: white; 
}
.decoreCollapse4{
   background-image: url(<?php echo base_url(); ?>assets/images/fond/fond18.jpg); 
   background-attachment: fixed; 
   background-size: cover; 
   background-repeat: none;
   color: white; 
}
    </style>
</head>

<body style="background-image: url(<?php echo base_url(); ?>assets/images/fond/fond7.jpg); background-attachment: fixed; background-size: cover; background-repeat: none;">
    <!-- header -->
    <header id="home">
        <div class="">
            <div class="header d-lg-flex justify-content-between align-items-center py-sm-3 py-2 px-sm-2 px-1" style="background: linear-gradient(to top, #0e1515 24%, #19a9b0 80%, #b4fcffe6 95%)">
                <!-- logo -->
                <div id="logo">
                    <h1><a href="<?php echo base_url(); ?>"><img style="height: 60px; width: 100px; box-shadow: 5px 5px 5px 5px black;" src="<?php echo base_url(); ?>assets/images/logo.png" alt=" " class="img-fluid" /></a></h1>
                </div>
                <!-- //logo -->
                <!-- nav -->
                <div class="nav_w3ls ml-lg-5">
                    <nav>
                        <label for="drop" class="toggle">Menu</label>
                        <input type="checkbox" id="drop" />
                        <ul class="menu">
                            <li><a href="<?php echo base_url(); echo $this->session->userdata('language_abbr'); ?>/admin/" class="active"><?php  echo t('accueil'); ?></a></li>

                            
                            <li>
                                <!-- First Tier Drop Down -->
                                <!-- <label for="drop-2" class="toggle toogle-2">Dropdown <span class="fa fa-angle-down"
                                        aria-hidden="true"></span>
                                </label> -->
                                <a href="<?php echo base_url(); echo $this->session->userdata('language_abbr'); ?>/admin/modelesCV">Curriculum vitae <span ></span></a>
                                <input type="checkbox" id="drop-2" />
                                <!-- <ul>
                                    <li><a href="<?php echo base_url();  $this->session->userdata('language_abbr'); ?>/admin/modelesCV" class="drop-text">Modèles de CV</a></li> -->
                                    <!-- <li><a href="single.html" class="drop-text">Blog Post</a></li>
                                    <li><a href="index.html" class="drop-text">More</a></li> -->
                                <!-- </ul> -->
                            </li>
                            <li>
                                <!-- First Tier Drop Down -->
                                <!-- <label for="drop-2" class="toggle toogle-2">Dropdown <span class="fa fa-angle-down"
                                        aria-hidden="true"></span>
                                </label> -->
                                <a href="<?php echo base_url(); echo $this->session->userdata('language_abbr'); ?>/admin/modelesLM"><?php  echo t('lettre_motivation'); ?><span  aria-hidden="true"></span></a>
                                <input type="checkbox" id="drop-2" />
                               <!--  <ul>
                                    <li><a href="portfolio.html" class="drop-text">Modèles de LM</a></li> -->
                                    <!-- <li><a href="single.html" class="drop-text">Blog Post</a></li>
                                    <li><a href="index.html" class="drop-text">More</a></li> -->
                                <!-- </ul> -->
                            </li>
                            <li><a href="<?php echo base_url(); echo $this->session->userdata('language_abbr'); ?>/admin/coaching" class="">Coaching</a></li>
                            <li><a href="index.html" class=""><?php  echo t('offre_emploi'); ?></a></li>
                            <li><a href="contact.html">Contact</a></li>
                            <li><a  href="<?php echo base_url(); echo $this->session->userdata('language_abbr'); ?>/admin/about"><?php  echo t('about'); ?></a></li>
                            <li class="nav-right-sty mt-lg-0 mt-sm-4 mt-3">
                                <a href="login.html" class="reqe-button text-uppercase">Login</a>
                                <a href="register.html" class="reqe-button text-uppercase">Register</a>
                            </li>
                            <input type="hidden" name="" class="current_page" value="<?php $this->crud_model->get_current_page(); ?>">
                            <input type="hidden" name="" class="abreviationLangue" value="<?php echo $this->session->userdata('language_abbr'); ?>">
                            <li class="nav-right-sty mt-lg-0 mt-sm-4 mt-3">
                                <button  class="styleButton french">FR</button>
                                <button  class="styleButton english">EN</button>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- //nav -->
            </div>
        </div>
    </header>
    <!-- //header -->

    <!-- banner -->
    <section class="banner">
        <!-- banner text -->

        <div class="container">
            <div class="banner_text_wthree_pvt vignets" style="background-color: #73f29052; width: 60%;">
                <h1 style="color: white;"><strong><?php  echo t('boost_carriere'); ?></strong></h1>

               <h3 style="color: white; font-weight: 20px;"> <?php  echo t('slogan'); ?></h3>  


            
                <div class="row">
                    <div class="col-lg-4">
                        <form action="#" method="post">
                            <div class="input-group">
                               <!--  <select class="custom-select" id="inputGroupSelect04" aria-label="Example select with button addon">
                                    <option selected>Choose...</option>
                                    <option value="1">lorem ipsum</option>
                                    <option value="2">tet clita kasd</option>
                                    <option value="3">Kasd gubergre</option>
                                </select> -->
                                <!-- <div class="input-group-append">
                                    <button class="btn bg-theme" type="button">More</button>
                                </div> -->
                               <!--  <button class="btn bg-theme" type="button" style="width: 100px; margin-left: 20%;">More</button> -->
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- //banner text -->
        <!-- banner-bottom -->
            <br/>
     <br/> 
        <div class="banner-bottom-w3ls hidden-xs">
            <div class="container">
                <br/>
     <br/> 
<br/>
     <br/> 

                <div class="row">
                    <!-- <div class="col-sm-3 col-6">
                        <div class="bb-img">
                            <img src="<?php echo base_url(); ?>assets/images/logo.png" class="img-fluid img-thumbnail" alt="" />
                            <h3>Nous consulter</h3>
                        </div>
                    </div> -->
                    
                    <div class="col-sm-4 col-6 mx-auto mt-sm-0 mt-4 wow bounceIn " data-wow-duration="1.4s" data-wow-delay="1s">
                        <div class="bb-img">
                            <img src="<?php echo base_url(); ?>assets/images/a3.jpg" class="img-fluid img-thumbnail bouge1" alt="" />
                            <h3><?php  echo t('rediger'); ?> </h3>
                        </div>
                    </div>
                    <div class="col-sm-4 col-6 wow bounceIn" data-wow-duration="1.6s" data-wow-delay="1.2s">
                        <div class="bb-img">
                            <img src="<?php echo base_url(); ?>assets/images/a1.jpg" class="img-fluid img-thumbnail" alt="" />
                            <h3><?php  echo t('postuler_ligne'); ?></h3>
                        </div>
                    </div>
                    <div class="col-sm-4 col-6 wow bounceIn" data-wow-duration="1.8s" data-wow-delay="1.4s">
                        <div class="bb-img">
                            <img src="<?php echo base_url(); ?>assets/images/travail.jpg" class="img-fluid img-thumbnail" alt="" />
                            <h3><?php  echo t('decrocher_job'); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- //banner-bottom -->
     <br/>
     <br/> 
    </section>
    <div class="container hidden-lg">
        <div class="row">
             <div class="col-sm-4 col-6 mx-auto mt-sm-0 mt-4 wow bounceIn" data-wow-duration="1.4s" data-wow-delay="1s">
                        <div class="bb-img">
                            <img src="<?php echo base_url(); ?>assets/images/a3.jpg" class="img-fluid img-thumbnail bouge1" alt="" />
                            <h3><?php  echo t('rediger'); ?></h3>
                        </div>
                    </div>
                    <div class="col-sm-4 col-6 wow bounceIn" data-wow-duration="1.6s" data-wow-delay="1.2s">
                        <div class="bb-img">
                            <img src="<?php echo base_url(); ?>assets/images/a1.jpg" class="img-fluid img-thumbnail" alt="" />
                            <h3><?php  echo t('postuler_ligne'); ?></h3>
                        </div>
                    </div>
                    <div class="col-sm-4 col-6 wow bounceIn" data-wow-duration="1.8s" data-wow-delay="1.4s">
                        <div class="bb-img">
                            <img src="<?php echo base_url(); ?>assets/images/travail.jpg" class="img-fluid img-thumbnail" alt="" />
                            <h3><?php  echo t('decrocher_job'); ?></h3>
                        </div>
                    </div>
        </div>
    </div>
    <!-- //banner -->
    <!-- about-->
    <br/>
     <br/> 
     <br/> 
    <section class="single_grid_w3_main" id="about"  >
        <div class="container" style="">
      <br/>
     <br/> 
     <br/>
     <br/> 
     <br/>
     <br/><br/>
     <br/>
     <br/>
     <br/>

            <div class="wthree_pvt_title text-center wow bounceIn" data-wow-offset="200" data-wow-delay="0.3s" style="background: white; border-radius: 5px; box-shadow: 9px 11px 19px 14px rgb(63, 68, 68);"><font></font>
                <h4 class="w3pvt-title"><u><font ><?php  echo t('pourquoi'); ?> </font><font style=""><?php  echo t('choisir'); ?></font> <font style="" face="calibri">EJ SMART JOB</font> ?</u></h4>
                <p class="sub-title"><font style="">EJ</font> <font style="">SMART</font> <font style="">JOBS</font> <?php  echo t('texte1'); ?>. 
<?php  echo t('avec'); ?> <font style="">EJ</font> <font style="">SMART</font> <font style="">JOBS</font>, <?php  echo t('vous_pourrez'); ?>  :
</p>
            </div>
            <hr>
            <div class="row" style="background: white;">
                 <div class="col-sm-3 col-6 wow bounceInRight bouge1"  data-wow-offset="200">
                        <div class="bb-img">
                            <img src="<?php echo base_url(); ?>assets/images/telecharger.png" class="img-fluid img-thumbnail" alt="" />
                            <h3><?php  echo t('telecharg_motiv'); ?></h3>
                        </div>
                    </div>
                    
                    <div class="col-sm-3 col-6 mx-auto mt-sm-0 mt-4 wow bounceInLeft"  data-wow-offset="200">
                        <div class="bb-img">
                            <img src="<?php echo base_url(); ?>assets/images/rencontre.png" class="img-fluid img-thumbnail" alt="" />
                            <h3><?php  echo t('beneficie_coching'); ?></h3>
                        </div>
                    </div>
                    <div class="col-sm-3 col-6 wow bounceInRight"  data-wow-offset="200">
                        <div class="bb-img">
                            <img src="<?php echo base_url(); ?>assets/images/personnaliser.png" class="img-fluid img-thumbnail" alt="" />
                            <h3><?php  echo t('nos_services'); ?></h3>
                        </div>
                    </div>
                    <div class="col-sm-3 col-6 wow bounceInLeft"  data-wow-offset="200">
                        <div class="bb-img">
                            <img src="<?php echo base_url(); ?>assets/images/postuler.png" class="img-fluid img-thumbnail" alt="" />
                            <h3><?php  echo t('postulez_emploi'); ?></h3>
                        </div>
                    </div>
            </div>
            <br/>
                <br>
     <br> 
         <br>
     <br> 
            <div class="wthree_pvt_title text-center" style="background: white;">
              <div class="row" style="box-shadow: 9px 11px 19px 14px rgb(63, 68, 68); border-radius: 10px;">
                <div class="col-sm-3 col-md-3" style=""> 
                    <img src="<?php echo base_url(); ?>assets/images/flechedroite.png"  class="flecheDroite hidden-xs">
                    <img src="<?php echo base_url(); ?>assets/images/flechebas.png" class="hidden-md hidden-lg hidden-sm flechebas">
                    <img src="<?php echo base_url(); ?>assets/images/idee.png" class="wow flîpOutY"  data-wow-offset="200">
                    
                    
                    <h3 class="wow bounceInUp"  data-wow-offset="200" data-wow-delay="0.2s"><?php  echo t('idee_lancer'); ?><font style="color:red">EJ</font> <font style="color:#88f;">SMART</font> <font style="color:#00f2aa;">JOBS</font> ?</h3>
                </div>
                <div class="col-sm-3 col-md-3 hidden-lg wow bounceInRight"  data-wow-offset="200" data-wow-delay="1s" style="overflow: hidden;">
                 <p><u> <b><?php  echo t('presentation'); ?> Diane</b></u></p>   
                   
                    <img src="<?php echo base_url(); ?>assets/images/diane/diane3.jpg" style="height: 340px; width: 260px; size: cover; border-radius: 5px;">
                </div>
                <div class="col-sm-6 col-md-6" style="text-align: justify;">
                <p class=""><!-- <span class="lettrine premier">J</span> -->
                    <h1 class="w3pvt-title" style="text-align: center; color:#88f; box-shadow: 0px 8px 8px 3px #0d6852; border-radius: 5px;"><?php  echo t('mon_histoire'); ?></h1>
                    <br/><br/>
                  <?php  echo t('texte2').t('texte2suite1'); ?><b><?php  echo t('texte2suite2'); ?></b>.
                  <?php  echo t('texte2suite3'); ?><a href="<?php echo base_url();  $this->session->userdata('language_abbr'); ?>/admin/about/#monHistoire"><?php  echo t('ici'); ?> </a> .
                    <?php  echo t('mon_histoire').t('texte2suite4').t('ou_vient'); ?><b><font style="color:red">EJ</font> <font style="color:#88f;">SMART</font> <font style="color:#00f2aa;">JOBS</font></b>.
                    <?php  echo t('texte2suite5').t("texte2suite6"); ?>
                    <br/>
                    <br/>

                    Faites comme eux <a href="<?php echo base_url(); ?>">contactez nous</a>  pour un suivi personnalisé.
                    </p>
                </div>
                <div class="col-sm-3 col-md-3 hidden-xs wow bounceInRight"  data-wow-offset="200" data-wow-delay="1s" style="overflow: hidden;">
                 <p><u> <b><?php  echo t('presentation'); ?> Diane</b></u></p>   
                   
                    <img src="<?php echo base_url(); ?>assets/images/diane/diane3.jpg" style="height: 340px; width: 260px; size: cover; border-radius: 5px;">
                </div>
              </div> 
            </div>
            
            <!-- <div class="d-flex justify-content-center">
                <a href="about.html" class="btn w3ls-btn">view more</a>
            </div> -->
        </div>
    </section>
    <!-- //about -->
    <!-- services -->
<!--     <section class="bg-services position-relative align-w3" id="services">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="services-bg-color">
                        <div class="wthree_pvt_title mb-3">
                            <h4 class="w3pvt-title">Postulez partout dans le monde
                            </h4>
                            <span class="sub-title">En Afrique, en europe, en Asie</span>
                        </div>
                        <div class="row">
                            <div class="col-md-6 service-title my-4">
                                <h4 class="home-title text-theme">Sub heading</h4>
                                <p class="sec-4">Itaque earum rerum hic tenetur a sapiente delectusum hic
                                    tenetur yua.
                                </p>
                            </div>
                            <div class="col-md-6 service-title my-md-4">
                                <h4 class="home-title text-theme">Sub heading</h4>
                                <p class="sec-4">Itaque earum rerum hic tenetur a sapiente delectusum hic
                                    tenetur ap.
                                </p>
                            </div>
                            <div class="col-md-6 service-title mt-4">
                                <h4 class="home-title text-theme">Sub heading</h4>
                                <p class="sec-4">Itaque earum rerum hic tenetur a sapiente delectusum hic
                                    tenetur ar.
                                </p>
                            </div>
                            <div class="col-md-6 service-title mt-4">
                                <h4 class="home-title text-theme">Sub heading</h4>
                                <p class="sec-4">Itaque earum rerum hic tenetur a sapiente delectusum hic
                                    tenetur as.
                                </p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-start">
                            <a href="about.html" class="btn w3ls-btn">view more</a>
                        </div>
                    </div>

                </div>
                <div class="offset-lg-2"></div>
            </div>
        </div>
    </section> -->
    <!-- //services -->

    <!-- Portfolio -->

     <section class="wthree-slie-btm py-lg-5" style="box-shadow: 9px 11px 19px 14px rgb(63, 68, 68); ">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="slide-banner pl-0">
                    </div>
                </div>
                <div class="col-lg-6 mt-lg-0 mt-4" style="background-image: url(<?php echo base_url(); ?>assets/images/fond/fond3.jpg); background-size: cover; background-repeat: none; border-radius: 10px; box-shadow: 9px 11px 19px 14px rgb(63, 68, 68); ">
                    <div class="container" style="">
                        <div class="wthree_pvt_title">
                            <input type="hidden" class="textCache" name="" value=" Le coaching une solutions pour vous">
                            <h4 class="w3pvt-title afficheTextCache wow bounceInTop" data-wow-duration="1s"  data-wow-offset="200">
                                <a href="<?php echo base_url(); echo $this->session->userdata('language_abbr'); ?>/admin/coaching"  style="color: #1400ff;">  <?php  echo t('cochingSolution'); ?></a>
                            </h4>
                            <span class="sub-title"><?php  echo t('titreCochingSolution'); ?></span>
                        </div>
                        <div class="row flex-column">
                            <div class="abt-grid wow bounceInleft" data-wow-duration="1s"  data-wow-offset="200">
                                <div class="row vignets">
                                    <div class="col-md-3">
                                        <div class="abt-icon">
                                            <span class="fa fa-user"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-9 ">
                                        <div class="abt-txt ml-0">
                                            <h4 style="color: #5000ff; font-weight: bold;"><?php  echo t('votreCarrure'); ?></h4>
                                            <p><?php  echo t('texteVotreCarrure'); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="abt-grid mt-4 pt-lg-2 wow bounceInleft" data-wow-duration="1s"  data-wow-offset="200">
                                <div class="row vignets" >
                                    <div class="col-md-3">
                                        <div class="abt-icon">
                                            <span class="fa fa-clock-o"></span>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="abt-txt ml-0">
                                            <h4 style="color: #5000ff; font-weight: bold;"><?php  echo t('sensTiming'); ?></h4>
                                            <p><?php  echo t('texteSensTiming'); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       <!--  <div class="d-flex justify-content-start">
                            <a href="about.html" class="btn w3ls-btn">view more</a>
                        </div> -->
                        
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <div class="container">
            <div class="row">
                <div class="col-md-4 wow bounceInleft" data-wow-duration="1s"  data-wow-offset="200" style="background-image: url(<?php echo base_url(); ?>assets/images/diane/diane2.jpg); background-size: cover;"></div>
                <div class="col-md-7">
                    <div id="accordion">

                        <h3> COACHING </h3>
                        <div class="decoreCollapse">
                        <p style="color: white;">
                            <?php  echo t('texteCoching'); ?>

                          </p>
                           <br/> <br/>
                         <label><?php  echo t('nomPrenom'); ?> : <input type="text" name="" class="form-control"></label>
                        
                         <label>Profession : <input type="text" name="" class="form-control"></label>
                         
                         <label><?php  echo t('pays'); ?> : <input type="text" name="" class="form-control"></label>
                       
                         <label>Message : <textarea class="form-control" style="height: 50px"></textarea> </label>
                          <br/>
                            <button class="btnEnvoyer"><?php  echo t('envoyer'); ?></button>
                         
                        </div>
                        <h3 class="wow bounceInleft" data-wow-duration="1s"  data-wow-offset="200"> <?php  echo t('amelioreCV'); ?></h3>
                         
                        <div style="" class="decoreCollapse1">
                        <p style="color: white;">
                       <?php  echo t('texteAmelioreCV'); ?>
                        </p>
                       
                        <label><?php  echo t('nom'); ?> : <input type="text" name="" class="form-control nom"></label>
                         <label><?php  echo t('pays'); ?>: <input type="text" name="" class="form-control pays"></label>
                         <label>Email : <input type="text" name="" class="form-control email" placeholder="www.exemple@gmail.com"></label>
                         <label><?php  echo t('numeroTelephone'); ?>: <input type="text" name="" class="form-control telephone"></label>
                         <label>Profession : <input type="text" name="" class="form-control profession"></label>
                          <br/>
                            <button class="btnEnvoyer envoyer0"><?php  echo t('envoyer'); ?></button>
                        <p style="color: red; background: white; border-radius: 10px; padding: 5px; max-width: 250px;"><?php  echo t('coutCoching'); ?> 49,90 euros / <?php  echo t('heure'); ?>.
                            <br/>
                            <?php  echo t('cochingEnLigne'); ?>.
                        </p>
                        </div>
                         <h3 class="wow bounceInleft" data-wow-duration="1s"  data-wow-offset="200"><?php  echo t('optimiseRechEmploi'); ?></h3>
                         
                        <div class="decoreCollapse2">
                         
                            <p style="color: white;">
                            <?php  echo t('texteOptimiseRechEmploi'); ?>
                             </p>
                        <label><?php  echo t('nom'); ?> : <input type="text" name="" class="form-control nom1"></label>
                         <label><?php  echo t('pays'); ?>: <input type="text" name="" class="form-control pays1"></label>
                         <label>Email : <input type="text" name="" class="form-control email1" placeholder="www.exemple@gmail.com"></label>
                         <label><?php  echo t('numeroTelephone'); ?>: <input type="text" name="" class="form-control telephone1"></label>
                         <label>Profession : <input type="text" name="" class="form-control profession1"></label>
                          <br/>
                            <button class="btnEnvoyer envoyer1"><?php  echo t('envoyer'); ?></button>
                        <p style="color: red; background: white; border-radius: 10px; padding: 5px; max-width: 250px;"><?php  echo t('coutCoching'); ?> 49,90 euros / <?php  echo t('heure'); ?>.
                            <br/>
                            <?php  echo t('cochingEnLigne'); ?>.
                        </p>
                            
                      <!--    <ul>
                             <li> List item one </li>
                             <li> List item two </li>
                             <li> List item three </li>
                         </ul> -->
                         </div>
                         <h3 class="wow bounceInleft" data-wow-duration="1s"  data-wow-offset="200">  <?php  echo t('optimiseEntretient'); ?></h3>
                         <div class="decoreCollapse3">
                             <p style="color: white;">
                             <?php  echo t('texteOptimiseEntretient'); ?>:

                             </p>
                        <label><?php  echo t('nom'); ?> : <input type="text" name="" class="form-control nom2"></label>
                         <label><?php  echo t('pays'); ?>: <input type="text" name="" class="form-control pays2"></label>
                         <label>Email : <input type="text" name="" class="form-control email2" placeholder="www.exemple@gmail.com"></label>
                         <label><?php  echo t('numeroTelephone'); ?>: <input type="text" name="" class="form-control telephone2"></label>
                         <label>Profession : <input type="text" name="" class="form-control profession2"></label>
                          <br/>
                            <button class="btnEnvoyer envoyer2"><?php  echo t('envoyer'); ?></button>
                        <p style="color: red; background: white; border-radius: 10px; padding: 5px; max-width: 250px;"><?php  echo t('coutCoching'); ?> 49,90 euros / <?php  echo t('heure'); ?>.
                            <br/>
                            <?php  echo t('cochingEnLigne'); ?>.
                        </p>
                         </div >
                         
                         <h3 class="wow bounceInleft" data-wow-duration="1s"  data-wow-offset="200"><?php  echo t('transitionPro'); ?></h3>
                         <div class="decoreCollapse4">
                             <p style="color: white;">
                            <?php  echo t('texteTransitionPro'); ?>
                             </p >
                        <label><?php  echo t('nom'); ?> : <input type="text" name="" class="form-control nom3"></label>
                         <label><?php  echo t('pays'); ?>: <input type="text" name="" class="form-control pays3"></label>
                         <label>Email : <input type="text" name="" class="form-control email3" placeholder="www.exemple@gmail.com"></label>
                         <label><?php  echo t('numeroTelephone'); ?>: <input type="text" name="" class="form-control telephone3"></label>
                         <label>Profession : <input type="text" name="" class="form-control profession3"></label>
                          <br/>
                            <button class="btnEnvoyer envoyer3"><?php  echo t('envoyer'); ?></button>
                        <p style="color: red; background: white; border-radius: 10px; padding: 5px; max-width: 250px;"><?php  echo t('coutCoching'); ?> 49,90 euros / <?php  echo t('heure'); ?>.
                            <br/>
                            <?php  echo t('cochingEnLigne'); ?>.
                        </p>
                         </div >
                         
                        </div >
 
 
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
        


    </section>

    <section class="blog_w3ls" id="posts">
        <div class="container" style="background: white; border-radius: 10px; box-shadow: 9px 11px 19px 14px rgb(63, 68, 68); ">
            <div class="wthree_pvt_title tex t-center">
                <h4 class="w3pvt-title"><?php  echo t('derniereCreation'); ?>
                </h4>
               
            </div>
            <div class="row space-sec">
                <!-- blog grid -->
                 <div class="col-lg-4 col-md-6 mt-md-0  mt-4 wow bounceInleft" data-wow-duration="1s"  data-wow-offset="200">
                    <div class="card">
                        <div class="card-header p-0 position-relative">
                            <a href="<?php echo base_url(); echo $this->session->userdata('language_abbr'); ?>/admin/modelesCV">
                                <img class="card-img-bottom" src="<?php echo base_url(); ?>assets/images/cv/cv.jpg" alt="Card image cap">
                                <span class="post-icon">CV</span>
                            </a>
                        </div>
                        <div class="card-body">
                            <h5 class="blog-title card-title font-weight-bold">
                                <!-- <a href="single.html">magna porta au blandita.</a> -->
                            </h5>
                            <p></p>
                            <a href="<?php echo base_url(); echo $this->session->userdata('language_abbr'); ?>/admin/modelesCV" class="blog_link">Détails</a>
                        </div>
                    </div>
                </div>
               
                <!-- //blog grid -->
                <!-- blog grid -->
                <div class="col-lg-4 col-md-6 mt-md-0  mt-4 wow bounceInleft" data-wow-duration="1s"  data-wow-offset="200">
                    <div class="card">
                        <div class="card-header p-0 position-relative">
                            <a href="<?php echo base_url(); echo $this->session->userdata('language_abbr'); ?>/admin/modelesLM">
                                <img class="card-img-bottom" src="<?php echo base_url(); ?>assets/images/cv/motivation1.jpg" alt="Card image cap">
                                <span class="post-icon"><?php  echo t('lettre_motivation'); ?></span>
                            </a>
                        </div>
                        <div class="card-body">
                            <h5 class="blog-title card-title font-weight-bold">
                                <!-- <a href="single.html">magna porta au blandita.</a> -->
                            </h5>
                            <p></p>
                            <a href="<?php echo base_url(); echo $this->session->userdata('language_abbr'); ?>/admin/modelesLM" class="blog_link">Détails</a>
                        </div>
                    </div>
                </div>
                <!-- //blog grid -->
                <!-- blog grid -->
                <div class="col-lg-4 col-md-6 mt-lg-0 mt-4 mx-auto blog-end wow bounceInRight" data-wow-duration="1s"  data-wow-offset="200">
                    <div class="card">
                        <div class="card-header p-0  position-relative">
                            <a href="<?php echo base_url();  $this->session->userdata('language_abbr'); ?>/admin/coaching">
                                <img class="card-img-bottom" src="<?php echo base_url(); ?>assets/images/cv/coching.jpg" alt="Card image cap">
                                <span class="post-icon"><?php  echo t('astuce&conseil'); ?></span>
                            </a>
                        </div>
                        <div class="card-body">
                            <h5 class="blog-title card-title font-weight-bold">
                                <!-- <a href="single.html">Cras ultricies ligula sed.</a> -->
                            </h5>
                            <p></p>
                            <a href="<?php echo base_url(); echo $this->session->userdata('language_abbr'); ?>/admin/coaching" class="blog_link">Détails</a>
                        </div>
                    </div>
                </div>
                <!-- //blog grid -->
            </div>
        </div>
    </section>
     <section class="blog_w3ls" id="posts">
        <!-- <div class="container"> -->
            

  
 <!--    <h5>Avec texte</h5>
    <div class="owl-carousel ">
      <div class="item"><h4>1</h4></div>
      <div class="item"><h4>2</h4></div>
      <div class="item"><h4>3</h4></div>
      <div class="item"><h4>4</h4></div>
      <div class="item"><h4>5</h4></div>
      <div class="item"><h4>6</h4></div>
      <div class="item"><h4>7</h4></div>
      <div class="item"><h4>8</h4></div>
      <div class="item"><h4>9</h4></div>
      <div class="item"><h4>10</h4></div>
      <div class="item"><h4>11</h4></div>
      <div class="item"><h4>12</h4></div>
    </div> -->
    <!-- //blog -->
    <!-- footer -->
  
        <!-- </div> -->
    </section>
    <br/>
    <br/>
    <div class="wthree_pvt_title tex t-center">
                <h4 class="w3pvt-title" style="text-align: center"><?php  echo t('cvApprecier'); ?>
                <!-- <embed src=<?php echo base_url(); ?>assets/images/cv/template1.pdf width=800 height=500 type='application/pdf'/> -->
                </h4>
    </div>
           <h5>TOP 20</h5>
    <div class="owl-carousel owl-theme owl-theme">
       <!--  <div class="item"><embed src=<?php echo base_url(); ?>assets/images/cv/template1.pdf width=800 height=500 type='application/pdf'/>
          <h1>  <a href=""> Télécharger</a> </h1>
        </div>
        <div class="item"><embed src=<?php echo base_url(); ?>assets/images/cv/template2.pdf width=800 height=500 type='application/pdf'/>
            <h1>  <a href=""> Télécharger</a> </h1>
        </div>
        <div class="item"><embed src=<?php echo base_url(); ?>assets/images/cv/template4.pdf width=800 height=500 type='application/pdf'/>
            <h1>  <a href=""> Télécharger</a> </h1>
        </div>
        <div class="item"><embed src=<?php echo base_url(); ?>assets/images/cv/template5.pdf width=800 height=500 type='application/pdf'/>
        <h1>  <a href=""> Télécharger</a> </h1></div>
        <div class="item"><embed src=<?php echo base_url(); ?>assets/images/cv/template6.pdf width=800 height=500 type='application/pdf'/>
            <h1>  <a href=""> Télécharger</a> </h1>
        </div>
        <div class="item"><embed src=<?php echo base_url(); ?>assets/images/cv/template7.pdf width=800 height=500 type='application/pdf'/>
            <h1>  <a href=""> Télécharger</a> </h1>
        </div>
        <div class="item"><embed src=<?php echo base_url(); ?>assets/images/cv/template8.pdf width=800 height=500 type='application/pdf'/>
            <h1>  <a href=""> Télécharger</a> </h1>
        </div> -->
   <!--  <div class="item">  <img src="<?php echo base_url(); ?>assets/images/cv/captures/template1.png" alt="Mon image 1" /><h1>  <a href=""> <img src="<?php echo base_url(); ?>assets/images/icones/telech1.png" alt="Mon image 1"  style="height: 90px; width: 90px;"/></a> </h1> </div>
     <div class="item"> <img src="<?php echo base_url(); ?>assets/images/cv/captures/template2.png" alt="Mon image 2" /><h1>  <a href=""> <img src="<?php echo base_url(); ?>assets/images/icones/telech1.png" alt="Mon image 1"  style="height: 90px; width: 90px;"/></a> </h1> </div>
     <div class="item"> <img src="<?php echo base_url(); ?>assets/images/cv/captures/template3.png" alt="Mon image 3" /><h1>  <a href=""> <img src="<?php echo base_url(); ?>assets/images/icones/telech1.png" alt="Mon image 1"  style="height: 90px; width: 90px;"/></a> </h1> </div>
     <div class="item"> <img src="<?php echo base_url(); ?>assets/images/cv/captures/template4.png" alt="Mon image 4" /><h1>  <a href=""> <img src="<?php echo base_url(); ?>assets/images/icones/telech1.png" alt="Mon image 1"  style="height: 90px; width: 90px;"/></a> </h1> </div>
    <div class="item">  <img src="<?php echo base_url(); ?>assets/images/cv/captures/template5.png" alt="Mon image 5" /><h1>  <a href=""> <img src="<?php echo base_url(); ?>assets/images/icones/telech1.png" alt="Mon image 1"  style="height: 90px; width: 90px;"/></a> </h1> </div> -->
    <?php
        $this->crud_model->top20CV();
      ?>
    </div>

    <div class="testimonials align-w3" id="testi">
        <div class="container" style="background:linear-gradient(to right, #36a0c1 0%, #fff 70%, #094355 90%);">
            <div class="wthree_pvt_title text-center" style="background: white; border-radius: 10px; box-shadow: 9px 11px 19px 14px rgb(63, 68, 68); ">
                <h4 class="w3pvt-title">Témoignage
                </h4>
                <p class="sub-title">Ils nous ont fait confiance et partage leur expérience et leur satisfaction.</p>
            </div>
                      <div class="comments my-5 wow bounceInUp"  data-wow-offset="200" style="background: white; padding: 10px; overflow: auto; height: 450px;">
                        <h3 class="courses-title ">Témoignages récents</h3>
                        <div class="comments-grids mt-4 contentCommentaires">
                            
                            
                        </div>
                    </div>
                    
                </div>
                <!-- //left side -->
            </div>
        </div>
    </section>
    <div class="container" style="background:linear-gradient(to right, #36a0c1 0%, #fff 70%, #094355 90%)">
        <div class="row">
            <div class="col-md-12">
                <div class="leave-coment-form wow bounceIn"  data-wow-offset="200"style="background: white; padding: 15px; border-radius: 15px;">
                        <h3 class="courses-title  mb-4">Ajouter un commentaire  <span style="text-align: center; background: #2bddc4ad; font-size: 22px; color: red" class="resultat2"></span></h3>
                        <form action="#" method="post">
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <input type="text" name="Name" class="form-control nom" placeholder="Name" required="">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <input type="email" name="Email" class="form-control mail" placeholder="Email" required="" onkeypress ="verifMail();">
                                </div>
                            </div>
                            <div class="form-group">
                                <textarea name="commentaire" class="form-control commentaire" placeholder="Your comment here..."
                                    required=""></textarea>
                            </div>
                            <div class="mm_single_submit">
                                <input type="button" class="btnCommentaire" value="Commenter" onclick="addTemoignage();">
                               <!--  <input type="button" name="" value="select commentaire" onclick="selectTemoignage();"> -->
                                <span style="text-align: center; background: #2bddc4ad; font-size: 22px;" class="resultat"></span>
                            </div>

                        </form>
                    </div>
            </div>
        </div>
    </div>
        </div>
    </div>
      <div class="cpy-right text-center">
        <p class="text-bl"><?php  echo t('abonnezVous'); ?>
           <label>  <input type="text" placeholder="Email" class="custom" id="inputGroupSelect04" aria-label="Example select with button addon">

              <button class="btn bg-theme" type="button">></button>
       
             </label>
        </p>
    </div>

    <footer class="footer py-md-5 pt-md-3 pb-sm-5">
    <div class="text-center" style="color: white;">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                
            </div>
            <div class="col-md-4" style="color: white; ">
              <h1>  Créez votre CV</h1>
                <span><img class="fleche" src="<?php echo base_url(); ?>assets/images/fleche_droite.png" alt="Card image cap" style="padding: 0px; margin: 0px;"></span> 
            </div>
            <div class="col-md-3">
                
                <!-- <div class="fleche" style=""><h1> ></h1></div> -->
            </div>
            <div class="col-md-2">
                
            </div>
        </div>
    </div>

    </div>
        <div class="container">
            <div class="row p-sm-4 px-3 py-3">
                <div class="col-lg-3 footer-top mt-md-0 mt-sm-5">
                    <h2>
                        <a class="navbar-brand" href="index.html">
                            <font style="color:red">EJ</font> <font style="color:#88f;">SMART</font> <font style="color:#00f2aa;">JOBS</font>
                        </a>
                    </h2>
                    <div class="fv3-contact mt-2">
                        <p>
                            <a href="mailto:example@email.com">Marie.donfack@ejmartjobs.com</a>
                        </p>
                    </div>
                    <div class="fv3-contact my-2">
                        <p>+33 783 91 34 55 7890</p>
                    </div>
                    <!-- <div class="fv3-contact">
                        <p>+90 nsequursu dsdesdc,
                            <br>xxx Street State 34789.</p>
                    </div> -->
                </div>
                <div class="col-lg-2  col-md-6 mt-lg-0 mt-4">
                    <div class="footerv2-w3ls">
                        <h3 class="mb-3 w3f_title">Recruteur</h3>
                        <hr>
                        <ul class="list-w3pvtits">
                            <li>
                                <a href="index.html">
                                   Créer un compte recruteur
                                </a>
                            </li>
                            <li class="my-2">
                                <a href="about.html">
                                    Visiter notre CVthèque
                                </a>
                            </li>
                            <li class="my-2">
                                <a href="portfolio.html">
                                   Publier une offre d'emploi
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="single.html">
                                    Ils ont recruté
                                </a>
                            </li>
                            <!-- <li>
                                <a href="contact.html">
                                    Contact Us
                                </a>
                            </li> -->
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3  col-md-6 mt-lg-0 mt-4">
                    <div class="footerv2-w3ls">
                        <h3 class="mb-3 w3f_title">Demandeur d'emploi</h3>
                        <hr>
                        <ul class="list-w3pvtits">
                            <li>
                                <a href="about.html">
                                    Créez votre CV
                                </a>
                            </li>
                            <li class="my-2">
                                <a href="single.html">
                                    Modèle de CV
                                </a>
                            </li>
                            <li class="my-2">
                                <a href="portfolio.html">
                                    Offre d'emploi
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="contact.html">
                                    Déposez votre CV dans notre CVthèque
                                </a>
                            </li>
                            <!-- <li>
                                <a href="index.html">
                                    Privacy Policy
                                </a>
                            </li> -->
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mt-lg-0 mt-4">
                    <div class="footerv2-w3ls">
                        <h3 class="mb-3 w3f_title">Notre entreprise</h3>
                        <hr>
                        <ul class="list-w3pvtits">
                            <li>
                                <a href="single.html">
                                   A propos de nous
                                </a>
                            </li>
                            <li class="my-2">
                                <a href="portfolio.html">
                                   Nos services
                                </a>
                            </li>
                            <li class="my-2">
                                <a href="about.html">
                                    Notre mission
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="contact.html">
                                    Nos partenaires
                                </a>
                            </li>
                            <li>
                                <a href="index.html">
                                    references
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2  col-md-6 mt-lg-0 mt-4">
                    <div class="footerv2-w3ls">
                        <h3 class="mb-3 w3f_title">Juridique</h3>
                        <hr>
                        <ul class="list-w3pvtits">
                            <li class="my-2">
                                <a href="portfolio.html">
                                    Explore
                                </a>
                            </li>
                            <li>
                                <a href="about.html">
                                    Our Mission
                                </a>
                            </li>
                            <li class="my-2">
                                <a href="single.html">
                                    Latest posts
                                </a>
                            </li>

                            <li class="mb-2">
                                <a href="contact.html">
                                    Find us
                                </a>
                            </li>
                            <li>
                                <a href="index.html">
                                    Privacy Policy
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
    <div class=" text-center">
        <p class="" style="color: white;">SOCIAL
          <hr/> 
          <ul class="list-w3pvtits">
                            <li class="my-2">
                               <a href="#"><img  alt="" src="<?php echo base_url(); ?>assets/img/icons/facebook.png">Facebook</a>
                            </li>
                            <li>
                                <a href="#"><img  alt="" src="<?php echo base_url(); ?>assets/img/icons/twitter.png">Twitter</a>
                            </li>
                            <li class="my-2">
                                <a href="#"><img  alt="" src="<?php echo base_url(); ?>assets/img/icons/linkedin.png">Linkedin</a>
                            </li>

                            
                        </ul>
                        <!-- <ul>    
                        <li></li>
                         <li></li>
                         <li><a href="#"><img  alt="" src="<?php echo base_url(); ?>assets/img/icons/youtube.png">Youtube</a></li>
                         <li></li>
                    </ul> -->
        </p>
    </div>
        </div>
        <!-- //footer bottom -->
    </footer>
    <!-- //footer -->
    <!-- copyright -->
    <div class="cpy-right text-center">
        <p class="text-bl">© 2019 ejsmartJobs. All rights reserved | Design by
            <a href="https://www.car237.com"> CAR237</a>
        </p>
    </div>
    <!-- //copyright -->
    <!-- move top icon -->
    <a href="#home" class="move-top text-center">
        <span class="fa fa-level-up" aria-hidden="true"></span>
    </a>
    <!-- //move top icon -->


</body>

</html>

 <script src="<?php echo base_url(); ?>assets/js/toastr.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-collapse.js"></script>
 <script src="<?php echo base_url(); ?>assets/js/style.js"></script>
 <script src="<?php echo base_url(); ?>assets/js/wow.js"></script>
 <script src="<?php echo base_url(); ?>assets/js/gestions.js"></script>


 <script>
    
     $(function() {
        $(".vignets").addClass("load");
         $(document).ready(function(){
            new WOW().init();
      });

selectTemoignage();
    });
     $(document).ready(function(){
      $('.owl-carousel').owlCarousel({
        autoplay:true,
        loop:true
      })
    });

</script>