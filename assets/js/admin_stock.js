
function getReferenceArticle(){
  id_article = $(".article").val();
 
   $.ajax({
      type:"POST",
      url:base_url+"/admin_stock/getReferenceArticle",
      data:{'id_article':id_article},
      success: function(data){
        $(".reference").val("");
        $(".reference").val(data);
        
       
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur '+data.responseText
      })   
          $(".chargementClient").fadeOut();
       }
       });
  
}

function getPrixUnitaireArticle(){
  id_article = $(".article").val();
 
   $.ajax({
      type:"POST",
      url:base_url+"/admin_stock/getPrixUnitaireArticle",
      data:{'id_article':id_article},
      success: function(data){
        $(".montant").val("");
        $(".montant").val(data);
        
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur '+data.responseText
      })   
          $(".chargementClient").fadeOut();
       }
       });
  
}

function addInventaire(){
	article = $(".article").val();
	qtite = $(".qtite").val();
	auteur = $(".auteur").val();
	id_fournisseur = $(".id_fournisseur").val();
	date_inv = $(".date_inv").val();
	if (qtite == "") {
		$(".qtite").css("border","red 2px solid");
		toastr.error("Veuillez renseigner la quantité");
	}else if (auteur == "") {
		$(".auteur").css("border","red 2px solid");
		toastr.error("Vous devez entrer le nom de l'auteur");

	}else if (date_inv == "") {
		$(".date_inv").css("border","red 2px solid");
		toastr.error("Veuillez renseigner la date");

	}else if (id_fournisseur == "") {
		$(".date_inv").css("border","red 2px solid");
		toastr.error("Veuillez renseigner la date");

	}
	else{
		$(".chargementInventaire").fadeIn();
		$(".qtite").css("border","1px solid #ced4da");
		$(".auteur").css("border","1px solid #ced4da");
		$(".date_inv").css("border","1px solid #ced4da");
		$(".id_fournisseur").css("border","1px solid #ced4da");
		$.ajax({
      type:"POST",
      url:base_url+"/admin_stock/addInventaire",
      data:{"article":article,"qtite":qtite,"auteur":auteur,"date_inv":date_inv,"id_fournisseur":id_fournisseur},
      success: function(data){
      	if ($.trim(data) =="ok") {
      	toastr.success("Insertion Parfaite");

      	$(".contentAddInventaire").append("<tr><td>"+$(".article option:selected").text()+"</td><td>"+$(".reference").val()+"</td><td>"+qtite+"</td></tr>");

      	updateFormInventaire();
        getDateDernierInventaire();
      }else{
      	$(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      })   
          $(".chargementInventaire").fadeOut();
      }
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementInventaire").fadeOut();
       }
       });
	}
}
// function updateForm(){
// 	$(".chargementInventaire").fadeIn();
// 	$(".formAddInventaire").remove();
//       		$.ajax({
// 		      type:"POST",
// 		      url:base_url+"admin_stock/getLeselectArticlePourInventaire",
// 		      data:{},
// 		      success: function(dat){
// 		      	$(".contentAddInventaire").append(dat);
// 		      	$('#example1').DataTable().destroy();
// 		      	selectAllInventaire('#example1');
// 		      	$(".chargementInventaire").fadeOut();
// 		      },
// 		      error: function(er){

// 		      }
// 		  })
// }
 function selectAllInventaire(idTable){

  date_debut = $('.date_debut').val();
    date_fin = $('.date_fin').val();
	id_fournisseur1 = $('.id_fournisseur1').val();
 	  $(".chargementClient").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_stock/selectAllInventaire",
      data:{
        'date_fin':date_fin,
        'date_debut':date_debut,
		 'id_fournisseur1':id_fournisseur1
		
      },
      success: function(data){
        // alert(data);
        $(".contentClient").empty();
        $(".contentClient").append(data);
        ceerDatatable(idTable)
        $(".chargementClient").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementClient").fadeOut();
       }
       });


 }

 function confirmSuppressionInventaire(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_stock/deleteInventaire",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
		selectAllInventaire('#example1');
        updateFormInventaire();
          
      },
            error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })
                
       }
       });
}

// Nous allons maintenant gérer les approvisionnements
function calculMontant(depensetotal,qtite,montant){
  if (depensetotal == 0 || depensetotal == "0") {
      depensetotal = 0;
    }else{
      depensetotal = depensetotal.replace(/\s+/g, '');
    }

    total = qtite*montant;

    depensetotal =parseInt(depensetotal)+parseInt(total);

    $('.total').val(depensetotal);
}

function addApprovisionnement(){
	article = $(".article").val();
	qtite = $(".qtite").val();
	auteur = $(".auteur").val();
  reference = $(".reference").val();
  id_fournisseur = $(".id_fournisseur").val();
  montant = $(".montant").val();
  bl = $(".bl").val();
	date_inv = $(".date_inv").val();

  total = $('.total').val();
  
	if (qtite == "") {
		$(".qtite").css("border","red 2px solid");
		toastr.error("Veuillez renseigner la quantité");
	}else if (auteur == "") {
		$(".auteur").css("border","red 2px solid");
		toastr.error("Vous devez entrer le nom de l'auteur");

	}else if (bl == "") {
    $(".bl").css("border","red 2px solid");
    toastr.error("Vous devez entrer le BL");

  }else if (montant == "") {
    $(".montant").css("border","red 2px solid");
    toastr.error("Vous devez entrer le montant de l'article");

  }
  else if (date_inv == "") {
		$(".date_inv").css("border","red 2px solid");
		toastr.error("Veuillez renseigner la date");

	}
	else{
		$(".chargementInventaire").fadeIn();
    $(".montant").css("border","1px solid #ced4da");
    $(".bl").css("border","1px solid #ced4da");
		$(".qtite").css("border","1px solid #ced4da");
		$(".auteur").css("border","1px solid #ced4da");
		$(".date_inv").css("border","1px solid #ced4da");
		$.ajax({
      type:"POST",
      url:base_url+"/admin_stock/addApprovisionnement",
      data:{"article":article,"qtite":qtite,"auteur":auteur,
      "bl":bl,"montant":montant,"id_fournisseur":id_fournisseur,"reference":reference,"auteur":auteur
      ,"date_inv":date_inv},
      success: function(data){
      	
      		if ($.trim(data) =="ok") {
      	toastr.success("Insertion Parfaite");
        calculMontant(total,qtite,montant)
      	$(".contentAddInventaire").append("<tr><td>"+$(".article option:selected").text()+"</td><td>"+$(".reference").val()+"</td><td>"+$(".montant").val()+" FCFA</td><td>"+qtite+"</td></tr>");
      	updateForm();
        getDateDernierInventaire();
      }else{
      	$(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      })   
          $(".chargementInventaire").fadeOut();
      }
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementInventaire").fadeOut();
       }
       });
	}
}
function updateForm(){
  $(".chargementInventaire").fadeIn();
  $(".formAddInventaire").remove();
          $.ajax({
          type:"POST",
          url:base_url+"/admin_stock/getLeselectArticlePourApprovisionnement",
          data:{},
          success: function(dat){
            $(".contentAddInventaire").append(dat);
            
            $('#example10').DataTable().destroy();
            selectAllApprovisionnement('#example10');
            $(".chargementInventaire").fadeOut();

            
          },
          error: function(er){

          }
      })
}

function updateFormInventaire(){
  $(".chargementInventaire").fadeIn();
  $(".formAddInventaire").remove();
          $.ajax({
          type:"POST",
          url:base_url+"/admin_stock/getLeselectArticlePourInventaire",
          data:{},
          success: function(dat){
            $(".contentAddInventaire").append(dat);
           $('#example1').DataTable().destroy();
           selectAllInventaire('#example1');
           $(".chargementInventaire").fadeOut();
          },
          error: function(er){

          }
      })
}

function updateFormDefectueux(){
  $(".chargementInventaire").fadeIn();
  $(".formAddInventaire").remove();
          $.ajax({
          type:"POST",
          url:base_url+"/admin_stock/getLeselectArticlePourDefectueux",
          data:{},
          success: function(dat){
            $(".contentAddInventaire").append(dat);
           $('#example5').DataTable().destroy();
            selectAllDefectueux('#example5');
            $(".chargementInventaire").fadeOut();
          },
          error: function(er){

          }
      })
}

 function selectAllApprovisionnement(idTable){
    date_debut = $('.date_debut').val();
    date_fin = $('.date_fin').val();
    bl1 = $('.bl1').val();
    id_fournisseur1 = $('.id_fournisseur1').val();

 	  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_stock/selectAllApprovisionnement",
      data:{
        'date_fin':date_fin,
        'date_debut':date_debut,
        'bl1':bl1,
        'id_fournisseur1':id_fournisseur1
      },
      success: function(data){
        // alert(data);
        $(".contentClient1").empty();
        $(".contentClient1").append(data);
        ceerDatatable(idTable)
        $(".chargementClient1").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementClient1").fadeOut();
       }
       });


 }
 
  function selectAllInventaire(idTable){
    date_debut = $('.date_debut').val();
    date_fin = $('.date_fin').val();
   
    id_fournisseur1 = $('.id_fournisseur1').val();

 	  $(".chargementClient").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_stock/selectAllInventaire",
      data:{
        'date_fin':date_fin,
        'date_debut':date_debut,
       
        'id_fournisseur1':id_fournisseur1
      },
      success: function(data){
        // alert(data);
        $(".contentClient1").empty();
        $(".contentClient1").append(data);
        ceerDatatable(idTable)
        $(".chargementClient1").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementClient").fadeOut();
       }
       });


 }

 function confirmSuppressionApprovisionnement(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_stock/deleteApprovisionnement",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
		selectAllApprovisionnement('#example1');
        updateForm();
          
      },
            error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })
                
       }
       });
}

// nous allons passer aux pieces defectueuses
function addDefectueux(){
	article = $(".article").val();
	qtite = $(".qtite").val();
	auteur = $(".auteur").val();
	date_inv = $(".date_inv").val();
	if (qtite == "") {
		$(".qtite").css("border","red 2px solid");
		toastr.error("Veuillez renseigner la quantité");
	}else if (auteur == "") {
		$(".auteur").css("border","red 2px solid");
		toastr.error("Vous devez entrer le nom de l'auteur");

	}else if (date_inv == "") {
		$(".date_inv").css("border","red 2px solid");
		toastr.error("Veuillez renseigner la date");

	}
	else{
		$(".chargementInventaire").fadeIn();
		$(".qtite").css("border","1px solid #ced4da");
		$(".auteur").css("border","1px solid #ced4da");
		$(".date_inv").css("border","1px solid #ced4da");
		$.ajax({
      type:"POST",
      url:base_url+"/admin_stock/addDefectueux",
      data:{"article":article,"qtite":qtite,"auteur":auteur,"date_inv":date_inv},
      success: function(data){
      	
      		if ($.trim(data) =="ok") {
      	toastr.success("Insertion Parfaite");

      	$(".contentAddInventaire").append("<tr><td>"+$(".article option:selected").text()+"</td><td>"+$(".reference").val()+"</td><td>"+qtite+"</td></tr>");
      	updateFormDefectueux();
        getDateDernierInventaire();
      }else{
      	$(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      })   
          $(".chargementInventaire").fadeOut();
      }
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementInventaire").fadeOut();
       }
       });
	}
}

 function selectAllDefectueux(idTable){

   date_debut = $('.date_debut').val();
    date_fin = $('.date_fin').val();
 	  $(".chargementClient").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_stock/selectAllDefectueux",
      data:{
        'date_fin':date_fin,
        'date_debut':date_debut
      },
      success: function(data){
        // alert(data);
        $(".contentClient").empty();
        $(".contentClient").append(data);
        ceerDatatable(idTable)
        $(".chargementClient").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementClient").fadeOut();
       }
       });


 }

 function confirmSuppressionDefectueux(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_stock/deleteDefectueux",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
		selectAllInventaire('#example1');
        updateFormDefectueux();
          
      },
            error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })
                
       }
       });
}


function rechercheStockParDate(){

	date_debut = $(".date_debut").val();
	date_fin = $(".date_fin").val();

	if (date_debut == "") {
		$(".date_debut").css("border","red 2px solid");
		toastr.error("Veuillez renseigner la date_debut");
	}else if (date_fin == "") {
		$(".date_fin").css("border","red 2px solid");
		toastr.error("Veuillez renseigner la date de fin");
	}else if (date_debut > date_fin) {
	toastr.error("La date de début doit être supérieure à la date de fin");	
	}
	else{
		$(".date_fin").css("border","1px solid #ced4da");
		$(".date_debut").css("border","1px solid #ced4da");
		 	  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_stock/selectAllStock",
      data:{"date_fin":date_fin,"date_debut":date_debut},
      success: function(data){
      		$('#example1').DataTable().destroy();
        $(".contentClient").empty();
        $(".contentClient").append(data);
        ceerDatatable('#example1');
        $(".chargementClient1").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur '+data.responseText
      })   
          $(".chargementClient1").fadeOut();
       }
       });
	}

}

function rechercheStockvaleurParDate(){

	date_debut = $(".date_debut").val();
	date_fin = $(".date_fin").val();

	if (date_debut == "") {
		$(".date_debut").css("border","red 2px solid");
		toastr.error("Veuillez renseigner la date_debut");
	}else if (date_fin == "") {
		$(".date_fin").css("border","red 2px solid");
		toastr.error("Veuillez renseigner la date de fin");
	}else if (date_debut > date_fin) {
	toastr.error("La date de début doit être supérieure à la date de fin");	
	}
	else{
		$(".date_fin").css("border","1px solid #ced4da");
		$(".date_debut").css("border","1px solid #ced4da");
		 	  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_stock/selectAllStockvaleur",
      data:{"date_fin":date_fin,"date_debut":date_debut},
      success: function(data){
      		$('#example1').DataTable().destroy();
        $(".contentClient").empty();
        $(".contentClient").append(data);
        ceerDatatable('#example1');
        $(".chargementClient1").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur '+data.responseText
      })   
          $(".chargementClient1").fadeOut();
       }
       });
	}

}


function getDateDernierInventaire(){
  $.ajax({
      type:"POST",
      url:base_url+"/admin_stock/getDateDernierInventaire",
      data:{},
      success: function(data){
        $(".dernierInventaire").val("");
        $(".dernierInventaire").val(data);
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur '+data.responseText
      })   
          $(".chargementClient1").fadeOut();
       }
       });
}

function getArticleParCategorie(){
  categorie = $(".categorie").val();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_stock/getArticleParCategorie",
      data:{"categorie":categorie},
      success: function(data){
        $(".article").empty();
        $(".article").append(data);
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur '+data.responseText
      })   
          $(".chargementClient1").fadeOut();
       }
       });
}