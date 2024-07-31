function ceerDatatable(id){
  table = $(id).DataTable({
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
            // message: 'This print was produced using the Print button for DataTables'
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
}




function getDestinationParCodeCamion(){
 id_type_camion = $(".camion option:selected").attr("id_type");

 // alert(id_type_camion);

 $.ajax({
      type:"POST",
      url:base_url+"/admin_livraison/getDestinationParCodeCamion",
      data:{"id_type_camion":id_type_camion},
      success: function(data){  
        $(".arrivee").empty();
        $(".arrivee").append(data);
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

function addInventaireGazoil(){
	article = $(".article").val();
	qtite = $(".qtite").val();
	auteur = $(".auteur").val();
	date_inv = $(".date_inv").val();
	 id_fournisseur = $(".id_fournisseur").val();
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
      url:base_url+"/admin_depense/addInventaireGazoil",
      data:{"article":article,"id_fournisseur":id_fournisseur,"qtite":qtite,"auteur":auteur,"date_inv":date_inv},
      success: function(data){
      	if ($.trim(data) =="ok") {
      	toastr.success("Insertion Parfaite");

      	$(".contentAddInventaire").append("<tr><td>"+$(".article option:selected").text()+"</td><td>"+$(".reference").val()+"</td><td>"+qtite+"</td></tr>");

      	updateFormInventaireGazoil();
        getDateDernierInventaireGazoil();
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

function addInventairePneu(){
	article = $(".article").val();
	qtite = $(".qtite").val();
	auteur = $(".auteur").val();
	date_inv = $(".date_inv").val();
	 id_fournisseur = $(".id_fournisseur").val();
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
      url:base_url+"/admin_depense/addInventairePneu",
      data:{"article":article,"id_fournisseur":id_fournisseur,"qtite":qtite,"auteur":auteur,"date_inv":date_inv},
      success: function(data){
      	if ($.trim(data) =="ok") {
      	toastr.success("Insertion Parfaite");

      	$(".contentAddInventaire").append("<tr><td>"+$(".article option:selected").text()+"</td><td>"+$(".reference").val()+"</td><td>"+qtite+"</td></tr>");

      	updateFormInventairePneu();
        getDateDernierInventairePneu();
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


function addInventaireHuile(){
	article = $(".article").val();
	qtite = $(".qtite").val();
	auteur = $(".auteur").val();
	date_inv = $(".date_inv").val();
	 id_fournisseur = $(".id_fournisseur").val();
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
      url:base_url+"/admin_depense/addInventaireHuile",
      data:{"article":article,"id_fournisseur":id_fournisseur,"qtite":qtite,"auteur":auteur,"date_inv":date_inv},
      success: function(data){
      	if ($.trim(data) =="ok") {
      	toastr.success("Insertion Parfaite");

      	$(".contentAddInventaire").append("<tr><td>"+$(".article option:selected").text()+"</td><td>"+$(".reference").val()+"</td><td>"+qtite+"</td></tr>");

      	updateFormInventaireHuile();
        getDateDernierInventaireHuile();
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

function updateFormInventaireGazoil(){
  $(".chargementInventaire").fadeIn();
  $(".formAddInventaire").remove();
          $.ajax({
          type:"POST",
          url:base_url+"/admin_depense/getLeselectArticlePourInventaireGazoil",
          data:{},
          success: function(dat){
            $(".contentAddInventaire").append(dat);
           $('#example1').DataTable().destroy();
           selectAllInventaireGazoil('#example1');
           $(".chargementInventaire").fadeOut();
          },
          error: function(er){

          }
      })
}

function updateFormInventaireHuile(){
  $(".chargementInventaire").fadeIn();
  $(".formAddInventaire").remove();
          $.ajax({
          type:"POST",
          url:base_url+"/admin_depense/getLeselectArticlePourInventaireHuile",
          data:{},
          success: function(dat){
            $(".contentAddInventaire").append(dat);
           $('#example1').DataTable().destroy();
           selectAllInventaireHuile('#example1');
           $(".chargementInventaire").fadeOut();
          },
          error: function(er){

          }
      })
}

function updateFormInventairePneu(){
  $(".chargementInventaire").fadeIn();
  $(".formAddInventaire").remove();
          $.ajax({
          type:"POST",
          url:base_url+"/admin_depense/getLeselectArticlePourInventairePneu",
          data:{},
          success: function(dat){
            $(".contentAddInventaire").append(dat);
           $('#example1').DataTable().destroy();
           selectAllInventairePneu('#example1');
           $(".chargementInventaire").fadeOut();
          },
          error: function(er){

          }
      })
}

function getDateDernierInventaireGazoil(){
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getDateDernierInventaireGazoil",
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

function getDateDernierInventaireHuile(){
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getDateDernierInventaireHuile",
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

function getDateDernierInventairePneu(){
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getDateDernierInventairePneu",
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

function selectAllInventaireGazoil(idTable){

  date_debut = $('.date_debut').val();
    date_fin = $('.date_fin').val();
 	  $(".chargementClient").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/selectAllInventaireGazoil",
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
 
 function selectAllInventaireHuile(idTable){

	date_debut = $('.date_debut').val();
    date_fin = $('.date_fin').val();
 	  $(".chargementClient").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/selectAllInventaireHuile",
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
 
 function selectAllInventairePneu(idTable){

	date_debut = $('.date_debut').val();
    date_fin = $('.date_fin').val();
 	  $(".chargementClient").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/selectAllInventairePneu",
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
 
 
 function selectAllInventairePpneu(idTable){

	date_debut = $('.date_debut').val();
    date_fin = $('.date_fin').val();
 	  $(".chargementClient").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/selectAllInventairePneu",
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

 function confirmSuppressionInventaireGazoil(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deleteInventaireGazoil",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
		selectAllInventaireGazoil('#example1');
        updateFormInventaireGazoil();
          
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

 function confirmSuppressionInventaireHuile(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deleteInventaireHuile",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
		selectAllInventaireHuile('#example1');
        updateFormInventaireHuile();
          
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


 function confirmSuppressionInventairePneu(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deleteInventairePneu",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
		selectAllInventairePneu('#example1');
        updateFormInventairePneu();
          
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

function addApprovisionnementGazoil(){
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
      url:base_url+"/admin_depense/addApprovisionnementGazoil",
      data:{"article":article,"qtite":qtite,"auteur":auteur,
      "bl":bl,"montant":montant,"id_fournisseur":id_fournisseur,"reference":reference,"auteur":auteur
      ,"date_inv":date_inv},
      success: function(data){
      	
      		if ($.trim(data) =="ok") {
      	toastr.success("Insertion Parfaite");
        calculMontant(total,qtite,montant)
      	$(".contentAddInventaire").append("<tr><td>"+$(".article option:selected").text()+"</td><td>"+$(".reference").val()+"</td><td>"+$(".montant").val()+" FCFA</td><td>"+qtite+"</td></tr>");
      	updateForm();
        getDateDernierInventaireGazoil();
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

function addApprovisionnementHuile(){
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
      url:base_url+"/admin_depense/addApprovisionnementHuile",
      data:{"article":article,"qtite":qtite,"auteur":auteur,
      "bl":bl,"montant":montant,"id_fournisseur":id_fournisseur,"reference":reference,"auteur":auteur
      ,"date_inv":date_inv},
      success: function(data){
      	
      		if ($.trim(data) =="ok") {
      	toastr.success("Insertion Parfaite");
        calculMontant(total,qtite,montant)
      	$(".contentAddInventaire").append("<tr><td>"+$(".article option:selected").text()+"</td><td>"+$(".reference").val()+"</td><td>"+$(".montant").val()+" FCFA</td><td>"+qtite+"</td></tr>");
      	updateFormHuile();
        getDateDernierInventaireHuile();
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


function addApprovisionnementPneu(){
	
	article = $(".article").val();
	marque = $(".marque").val();
	type = $(".type").val();
	
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
      url:base_url+"/admin_depense/addApprovisionnementPneu",
      data:{"article":article,"marque":marque,"type":type,"qtite":qtite,"auteur":auteur,
      "bl":bl,"montant":montant,"id_fournisseur":id_fournisseur,"reference":reference,"auteur":auteur
      ,"date_inv":date_inv},
      success: function(data){
      	
      		if ($.trim(data) =="Insertion Parfaite de la Livraison PNEU") {
      	toastr.success("Insertion Parfaite de la Livraison PNEU");
        calculMontant(total,qtite,montant)
      	$(".contentAddInventaire").append("<tr><td>"+$(".type option:selected").text()+"</td><td>"+$(".marque option:selected").text()+"</td><td>"+$(".article option:selected").text()+"</td><td>"+$(".reference").val()+"</td><td>"+$(".montant").val()+" FCFA</td><td>"+qtite+"</td></tr>");
      	$('#example1').DataTable().destroy();
		selectAllApprovisionnementPneu('#example1');
		updateFormPneu();
        getDateDernierInventairePneu();
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

function updateForm(){
  $(".chargementInventaire").fadeIn();
  $(".formAddInventaire").remove();
          $.ajax({
          type:"POST",
          url:base_url+"/admin_depense/getLeselectArticlePourApprovisionnementGazoil",
          data:{},
          success: function(dat){
            $(".contentAddInventaire").append(dat);
            
            $('#example10').DataTable().destroy();
            selectAllApprovisionnementGazoil('#example10');
            $(".chargementInventaire").fadeOut();

            
          },
          error: function(er){

          }
      })
}

function updateFormHuile(){
  $(".chargementInventaire").fadeIn();
  $(".formAddInventaire").remove();
          $.ajax({
          type:"POST",
          url:base_url+"/admin_depense/getLeselectArticlePourApprovisionnementHuile",
          data:{},
          success: function(dat){
            $(".contentAddInventaire").append(dat);
            
            $('#example10').DataTable().destroy();
            selectAllApprovisionnementHuile('#example10');
            $(".chargementInventaire").fadeOut();

            
          },
          error: function(er){

          }
      })
}

function updateFormPneu(){
  $(".chargementInventaire").fadeIn();
  $(".formAddInventaire").remove();
          $.ajax({
          type:"POST",
          url:base_url+"/admin_depense/getLeselectArticlePourApprovisionnementPneu",
          data:{},
          success: function(dat){
            $(".contentAddInventaire").append(dat);
            
            $('#example10').DataTable().destroy();
            selectAllApprovisionnementPneu('#example10');
            $(".chargementInventaire").fadeOut();

            
          },
          error: function(er){

          }
      })
}




function selectAllApprovisionnementGazoil(idTable){
    date_debut = $('.date_debut').val();
    date_fin = $('.date_fin').val();
    bl1 = $('.bl1').val();
    id_fournisseur1 = $('.id_fournisseur1').val();

 	  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/selectAllApprovisionnementGazoil",
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
 
 function selectAllApprovisionnementHuile(idTable){
    date_debut = $('.date_debut').val();
    date_fin = $('.date_fin').val();
    bl1 = $('.bl1').val();
    id_fournisseur1 = $('.id_fournisseur1').val();

 	  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/selectAllApprovisionnementHuile",
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
 
  function selectAllApprovisionnementPneu(idTable){
    date_debut = $('.date_debut').val();
    date_fin = $('.date_fin').val();
    bl1 = $('.bl1').val();
    id_fournisseur1 = $('.id_fournisseur1').val();

 	  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/selectAllApprovisionnementPneu",
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


 function confirmSuppressionApprovisionnementGazoil(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deleteApprovisionnementGazoil",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
		selectAllApprovisionnementGazoil('#example1');
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

function confirmSuppressionApprovisionnementHuile(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deleteApprovisionnementHuile",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
		selectAllApprovisionnementHuile('#example1');
        updateFormHuile();
          
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


function confirmSuppressionApprovisionnementPneu(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deleteApprovisionnementPneu",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
		selectAllApprovisionnementPneu('#example1');
        updateFormPneu();
          
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





function addGazoil(status){
  commentaire = $(".commentaire").val();
	numero = $(".numero").val();
	dateDepense = $(".dateCreation").val();
	litrage = $(".litrage").val();
	destination = $(".destination").val();
  destination2 = $(".destination2").val();
	prixUnitaire = $(".prixUnitaire").val();
	fournisseur = $(".fournisseur").val();
	codeCamion = $(".camion").val();
	operation = $(".operation").val();
	kilometrage = $(".kilometrage").val();
	id_gazoil = $(".id_gazoil").val();

  // alert($(".litrage option:selected").text());
  // destination3 = $(".litrage:selected").text();
  // if ( destination3 == "SITE MIRA") {
  supplement = $(".supplement").val();

    // alert(supplement);
    // litrage = litrage +supplement;
  
 
    // }
	if (numero == "") {
$(".numero").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
	}else if (dateDepense == "") {
$(".dateCreation").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
	}else if (litrage == "") {
$(".litrage").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
	}else if (destination == "") {
$(".destination").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
	}else if (destination2 == "") {
$(".destination2").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
  }else if (prixUnitaire == "") {
$(".prixUnitaire").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
	}else if (codeCamion == "") {
$(".camion").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
  }else if (kilometrage == "") {
    $(".kilometrage").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
  }
  else{
$(".camion").css("border","1px solid #ced4da");
$(".numero").css("border","1px solid #ced4da");
$(".dateCreation").css("border","1px solid #ced4da");
$(".litrage").css("border","1px solid #ced4da");
$(".destination").css("border","1px solid #ced4da");
$(".destination2").css("border","1px solid #ced4da");
$(".prixUnitaire").css("border","1px solid #ced4da");
$(".kilometrage").css("border","1px solid #ced4da");
$(".chargementGazoil1").fadeIn();
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addGazoil",
      data:{"supplement":supplement,"commentaire":commentaire,"id_gazoil":id_gazoil,"status":status,"numero":numero,"dateDepense":dateDepense,"litrage":litrage,"destination":destination,"prixUnitaire":prixUnitaire,"id_fournisseur":fournisseur,"codeCamion":codeCamion,"kilometrage":kilometrage,"id_operation":operation},
      success: function(data){  

      	if ($.trim(data) == "Insertion parfaite de la dépense") {

      	$('#example1').DataTable().destroy();
        afficheAllGazoil('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementGazoil").fadeOut();
      	}else if ($.trim(data) == "Modification parfaite de la dépense") {

      	$('#example1').DataTable().destroy();
        afficheAllGazoil('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementGazoil1").fadeOut();
      	}else{
      	$(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      }) 
      	}
$(".chargementGazoil1").fadeOut();
      },
            error:function(data){
           $(".chargementGazoil1").fadeOut();
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })
                
       }
       });

	}
}

function afficheAllGazoil(idTable){
  $(".chargementGazoil").fadeIn();

   date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllGazoil",
      data:{"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){

        $(".contentGazoil").empty();
        $(".contentGazoil").append(data);
        ceerDatatable(idTable)
        $(".chargementGazoil").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementGazoil").fadeOut();
       }
       });
}

function getOperationPourModifGazoil(id_operation){

  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getOperationPourModifGazoil",
      data:{"id_operation":id_operation},
      success: function(data){
        $(".operation").empty();
        $(".operation").append(data);
        // alert(data);
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementGazoil").fadeOut();
       }
       });
}
function getFournisseurPourModifGazoil(id_fournisseur){
 
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getFournisseurPourModifGazoil",
      data:{"id_fournisseur":id_fournisseur},
      success: function(data){
        $(".fournisseur").empty();
        $(".fournisseur").append(data);
        // alert(data);
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementGazoil").fadeOut();
       }
       });
}

function getCodePourModifGazoil(id_fournisseur){
 
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getCodePourModifGazoil",
      data:{"code_camion":id_fournisseur},
      success: function(data){
        $(".camion").empty();
        $(".camion").append(data);
        // alert(data);
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementGazoil").fadeOut();
       }
       });
}

function rechercheStockParDate(){

	date_debut = $(".date_debut").val();
	date_fin = $(".date_fin").val();
	 id_fournisseur1 = $('.id_fournisseur1').val();

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
      url:base_url+"/admin_depense/selectAllStockGazoil",
      data:{"date_fin":date_fin,"date_debut":date_debut,"id_fournisseur1":id_fournisseur1},
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

function rechercheStockHuileParDate(){

	date_debut = $(".date_debut").val();
	date_fin = $(".date_fin").val();
	 id_fournisseur1 = $('.id_fournisseur1').val();

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
      url:base_url+"/admin_depense/selectAllStockHuile",
      data:{"date_fin":date_fin,"date_debut":date_debut,"id_fournisseur1":id_fournisseur1},
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




function getDestinationPourModifGazoil(code_camion,id_distance){
 
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getDestinationPourModifGazoil",
      data:{"code_camion":code_camion,"id_distance":id_distance},
      success: function(data){
        $(".destination").empty();
        $(".destination").append(data);
        // alert(data);
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementGazoil").fadeOut();
       }
       });
}

function infoGazoil(numero,dateDepense,litrage,destination,prixUnitaire,kilometrage,id_gazoil,commentaire,id_fournisseur,id_operation,code_camion,id_distance){
	$(".commentaire").val(commentaire);
  $(".numero").val(numero);
	$(".dateCreation").val(dateDepense);
	$(".litrage").val(litrage);
	$(".destination").val(destination);
	$(".prixUnitaire").val(prixUnitaire);
  // alert(prixUnitaire);
  total = prixUnitaire*litrage;
  formatMillierPourSelection(''+total+'',"PT");
	$(".kilometrage").val(kilometrage);
	$(".id_gazoil").val(id_gazoil);
  getCodePourModifGazoil(code_camion);
  getFournisseurPourModifGazoil(id_fournisseur);
  getOperationPourModifGazoil(id_operation);
  getDestinationPourModifGazoil(code_camion,id_distance);
  // $(".camion").append("<option value='"+code_camion+"'>"+code_camion+"</option>");
// getPrixUnitaireParFournisseur();
// getDistanceParCodeCamion();
getDescriptionOperation();
	$(".btnAdd").fadeOut();
	$(".btnModif").fadeIn();
	$(".btnAnnuler").fadeIn();
}

function annulerSuppressionGazoil(){
	$(".btnAdd").fadeIn();
	$(".btnModif").fadeOut();
	$(".btnAnnuler").fadeOut();
}

function confirmSuppressionGazoil(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deleteGasoil",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllGazoil('#example1');
        
          
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


function addPrime(status){
	montant = $(".montant").val();
	libelle = $(".libelle").val();
	date = $(".datePrime").val();
	codeCamion = $(".camion").val();
	id_operation = $(".operation").val();
	id_prime = $(".id_prime").val();

	if (montant == "") {
	$(".montant").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
	}else if (date == "") {
	$(".datePrime").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else if (libelle == "") {
	$(".libelle").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else{
	$(".montant").css("border","1px solid #ced4da");
	$(".libelle").css("border","1px solid #ced4da");
	$(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
	 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addPrime",
      data:{"id_prime":id_prime,"status":status,"montant":montant,"libelle":libelle,"date":date,"id_operation":id_operation,"codeCamion":codeCamion},
      success: function(data){  

      	if ($.trim(data) == "Enregistrement de la prime réussi") {

      	$('#example1').DataTable().destroy();
        afficheAllPrime('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
      	}else if ($.trim(data) == "Modification de la prime réussi") {

      	$('#example1').DataTable().destroy();
        afficheAllPrime('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
      	}else{
      	$(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      }) 
      	}
$(".chargementPrime1").fadeOut();
      },
            error:function(data){
           $(".chargementGazoil1").fadeOut();
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })
                
       }
       });
	}
}

function afficheAllPrime(idTable){

    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();

  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllPrime",
      data:{"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){

        $(".contentPrime").empty();
        $(".contentPrime").append(data);
        ceerDatatable(idTable)
        $(".chargementPrime").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime").fadeOut();
       }
       });
}

function confirmSuppressionPrime(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deletePrime",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllPrime('#example1');
        
          
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

function infoPrime(montant,libelle,date,codeCamion,id_operation,id_prime){
	$(".montant").val(montant);
	$(".libelle").val(libelle);
	$(".datePrime").val(date);
	$(".camion").val(codeCamion);
	$(".operation").val(id_operation);
	$(".id_prime").val(id_prime);
   getDescriptionOperation(id_operation);
	$(".btnAdd").fadeOut();
	$(".btnAnnuler").fadeIn();
	$(".btnModif").fadeIn();
}



function addFraisRoute(status){
	montant = $(".montant").val();
	distance = $(".distance").val();
	date = $(".datePrime").val();
	codeCamion = $(".camion").val();
	id_operation = $(".operation").val();
	id_frais_route = $(".id_prime").val();

	if (montant == "") {
	$(".montant").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
	}else if (date == "") {
	$(".datePrime").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else if (distance == "") {
	$(".libelle").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else{
	$(".montant").css("border","1px solid #ced4da");
	$(".libelle").css("border","1px solid #ced4da");
	$(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
	 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addFraisRoute",
      data:{"id_frais_route":id_frais_route,"status":status,"montant":montant,"distance":distance,"date":date,"id_operation":id_operation,"codeCamion":codeCamion},
      success: function(data){  

      	if ($.trim(data) == "Frais de route enregistré") {

      	$('#example1').DataTable().destroy();
        afficheAllFraisRoute('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
      	}else if ($.trim(data) == "Frais de route modifié") {

      	$('#example1').DataTable().destroy();
        afficheAllFraisRoute('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
      	}else{
      	$(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      }) 
      	}
$(".chargementPrime1").fadeOut();
      },
            error:function(data){
           $(".chargementGazoil1").fadeOut();
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })
                
       }
       });
	}
}

function afficheAllFraisRoute(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllFraisRoute",
      data:{},
      success: function(data){

        $(".contentPrime").empty();
        $(".contentPrime").append(data);
        ceerDatatable(idTable)
        $(".chargementPrime").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime").fadeOut();
       }
       });
}

function confirmSuppressionFraisRoute(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deleteFraisRoute",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllFraisRoute('#example1');
        
          
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

function infoFraisRoute(montant,libelle,date,codeCamion,id_operation,id_prime){
	$(".montant").val(montant);
	$(".distance").val(libelle);
	$(".datePrime").val(date);
	$(".camion").val(codeCamion);
	$(".operation").val(id_operation);
	$(".id_prime").val(id_prime);

	$(".btnAdd").fadeOut();
	$(".btnAnnuler").fadeIn();
	$(".btnModif").fadeIn();
}

function infosMarque(id_type_marque,marque,commentaire){
	
	$(".marque").val(marque);
	$(".commentaire").val(commentaire);
	$(".id_client").val(id_type_marque);

	$(".btnAdd").fadeOut();
	$(".btnAnnuler").fadeIn();
	$(".btnModif").fadeIn();
}

function infosTypePneu(id_type_pneu,nom_type,commentaire){
	
	$(".nom_type").val(nom_type);
	$(".commentaire").val(commentaire);
	$(".id_client").val(id_type_pneu);

	$(".btnAdd").fadeOut();
	$(".btnAnnuler").fadeIn();
	$(".btnModif").fadeIn();
}

function infoFraisAchat(montant,date,codeCamion,id_operation,id_prime,libelle,numero,fournisseur,facture,validite,montant1,quantite,voyage,){
	$(".montant").val(montant);
	$(".commentaire").val(libelle);
	$(".datePrime").val(date);
	$(".camion").val(codeCamion);
	$(".operation").val(id_operation);
	$(".id_prime").val(id_prime);
	$(".numero").val(numero);
	$(".fournisseur").val(fournisseur);
	$(".facture").val(facture);
	$(".validite").val(validite);
	$(".montant1").val(montant1);
	$(".quantite").val(quantite);
	$(".voyage").val(voyage);

	$(".btnAdd").fadeOut();
	$(".btnAnnuler").fadeIn();
	$(".btnModif").fadeIn();
}





function addFraisDivers(status){
  commentaire = $(".commentaire").val();
	montant = $(".montant").val();
	distance ="d";
	date = $(".datePrime").val();
	codeCamion = $(".camion").val();
	id_operation = $(".operation").val();
	id_frais_route = $(".id_prime").val();

	if (montant == "") {
	$(".montant").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
	}else if (date == "") {
	$(".datePrime").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else if (distance == "") {
	$(".libelle").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else{
	$(".montant").css("border","1px solid #ced4da");
	$(".libelle").css("border","1px solid #ced4da");
	$(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
	 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addFraisDivers",
      data:{"commentaire":commentaire,"id_frais_divers":id_frais_route,"status":status,"montant":montant,"distance":distance,"date":date,"id_operation":id_operation,"codeCamion":codeCamion},
      success: function(data){  

      	if ($.trim(data) == "Frais divers enregistré") {

      	$('#example1').DataTable().destroy();
        afficheAllFraisDivers('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
      	}else if ($.trim(data) == "Frais divers modifié") {

      	$('#example1').DataTable().destroy();
        afficheAllFraisDivers('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
      	}else{
      	$(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      }) 
      	}
$(".chargementPrime1").fadeOut();
      },
            error:function(data){
           $(".chargementGazoil1").fadeOut();
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })
                
       }
       });
	}
}

function addFraisAchat(status){
    commentaire = $(".commentaire").val();
	montant = $(".montant").val();
	date = $(".datePrime").val();
	codeCamion = $(".camion").val();
	id_operation = $(".operation").val();
	id_frais_route = $(".id_prime").val();
	numero = $(".numero").val();
	fournisseur = $(".fournisseur").val();
	facture = $(".facture").val();
	validite = $(".validite").val();
	quantite = $(".quantite").val();
	voyage = $(".voyage").val();
	montant1 = $(".montant1").val();

	if (montant == "") {
	$(".montant").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
	}else if (date == "") {
	$(".datePrime").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else{
	$(".montant").css("border","1px solid #ced4da");
	$(".libelle").css("border","1px solid #ced4da");
	$(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
	 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addFraisAchat",
      data:{"commentaire":commentaire,"id_frais_divers":id_frais_route,"status":status,"montant":montant,"date":date,"id_operation":id_operation,"codeCamion":codeCamion,"numero":numero,"fournisseur":fournisseur,"facture":facture,"validite":validite,"quantite":quantite,"voyage":voyage,"montant1":montant1},
      success: function(data){  

      	if ($.trim(data) == "Frais achat enregistré") {
		toastr.success(data);
      	$('#example1').DataTable().destroy();
        afficheAllFraisAchat('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
      	}else if ($.trim(data) == "Frais achat modifié") {
		toastr.success(data);
      	$('#example1').DataTable().destroy();
        afficheAllFraisAchat('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
      	}else{
      	$(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      }) 
      	}
$(".chargementPrime1").fadeOut();
      },
            error:function(data){
           $(".chargementGazoil").fadeOut();
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })
                
       }
       });
	}
}


function afficheAllFraisDivers(idTable){

   date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();

  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllFraisDivers",
      data:{"date_fin":date_fin,"date_debut":date_debut},
      success: function(data){

        $(".contentPrime").empty();
        $(".contentPrime").append(data);
        ceerDatatable(idTable)
        $(".chargementPrime").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime").fadeOut();
       }
       });
}

function afficheAllFraisAchat(idTable){

   date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();

  $(".chargementPrime1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllFraisAchat",
      data:{"date_fin":date_fin,"date_debut":date_debut},
      success: function(data){

        $(".contentPrime").empty();
        $(".contentPrime").append(data);
        ceerDatatable(idTable)
        $(".chargementPrime1").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime1").fadeOut();
       }
       });
}


function confirmSuppressionFraisDivers(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deleteFraisDivers",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllFraisDivers('#example1');
        
          
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

function confirmSuppressionFraisAchat(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deleteFraisAchat",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllFraisAchat('#example1');
        
          
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







function addFraisRoute(status){
  commentaire = $(".commentaire").val();
	montant = $(".montant").val();
	distance = $(".distance").val();
	date = $(".datePrime").val();
	codeCamion = $(".camion").val();
	id_operation = $(".operation").val();
	id_frais_route = $(".id_prime").val();
  destinationRoute = $(".destinationRoute").val();

	if (montant == "") {
	$(".montant").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
	}else if (date == "") {
	$(".datePrime").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else if (destinationRoute == "") {
  $(".destinationRoute").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (distance == "") {
	$(".libelle").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else{
  $(".destinationRoute").css("border","1px solid #ced4da");
	$(".montant").css("border","1px solid #ced4da");
	$(".libelle").css("border","1px solid #ced4da");
	$(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
	 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addFraisRoute",
      data:{"destination":destinationRoute,"commentaire":commentaire,"id_frais_route":id_frais_route,"status":status,"montant":montant,"distance":distance,"date":date,"id_operation":id_operation,"codeCamion":codeCamion},
      success: function(data){  

      	if ($.trim(data) == "Frais de route enregistré") {

      	$('#example1').DataTable().destroy();
        afficheAllFraisRoute('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
      	}else if ($.trim(data) == "Frais de route modifié") {

      	$('#example1').DataTable().destroy();
        afficheAllFraisRoute('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
      	}else{
      	$(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      }) 
      	}
$(".chargementPrime1").fadeOut();
      },
            error:function(data){
           $(".chargementGazoil1").fadeOut();
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })
                
       }
       });
	}
}

function afficheAllFraisRoute(idTable){

   date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();

  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllFraisRoute",
      data:{"date_fin":date_fin,"date_debut":date_debut},
      success: function(data){

        $(".contentPrime").empty();
        $(".contentPrime").append(data);
        ceerDatatable(idTable)
        $(".chargementPrime").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime").fadeOut();
       }
       });
}

function confirmSuppressionFraisRoute(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deleteFraisRoute",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllFraisRoute('#example1');
        
          
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

function infoFraisRoute(montant,libelle,date,codeCamion,id_operation,id_prime,commentaire,destination){
  $(".commentaire").val(commentaire);
	$(".montant").val(montant);
	$(".distance").val(libelle);
	$(".datePrime").val(date);
	$(".camion").val(codeCamion);
	$(".operation").val(id_operation);
	$(".id_prime").val(id_prime);
  $(".destinationRoute").val(destination);
     getDescriptionOperation(id_operation);
	$(".btnAdd").fadeOut();
	$(".btnAnnuler").fadeIn();
	$(".btnModif").fadeIn();
}





function addVidange(status){
  kilometrage = $(".kilometrage").val();
	huile = $(".huile").val();
  PU = $(".PU").val();
  qtite = $(".qtite").val();
	commentaire = $(".commentaire").val();
	date = $(".datePrime").val();
	codeCamion = $(".camion").val();
	id_operation = $(".operation").val();
	id_fournisseur = $(".id_fournisseur").val();
	id_frais_route = $(".id_prime").val();

	if (huile == "") {
	$(".huile").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
	}else if (date == "") {
	$(".datePrime").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else if (commentaire == "") {
	$(".commentaire").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else if (kilometrage == "") {
  $(".kilometrage").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (qtite == "") {
  $(".qtite").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (PU == "") {
  $(".PU").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else{
  $(".PU").css("border","1px solid #ced4da");
	$(".kilometrage").css("border","1px solid #ced4da");
  $(".huile").css("border","1px solid #ced4da");
  $(".qtite").css("border","1px solid #ced4da");
  $(".commentaire").css("border","1px solid #ced4da");
  $(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addVidange",
      data:{"PU":PU,"kilometrage":kilometrage,"id_frais_divers":id_frais_route,"qtite":qtite,"status":status,"huile":huile,"commentaire":commentaire,"date":date,"id_operation":id_operation,"codeCamion":codeCamion,"id_fournisseur":id_fournisseur},
      success: function(data){  

      	if ($.trim(data) == "Vidange enregistrée") {

      	$('#example1').DataTable().destroy();
        afficheAllVidange('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
      	}else if ($.trim(data) == "Vidange modifiée") {

      	$('#example1').DataTable().destroy();
        afficheAllVidange('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
      	}else{
      	$(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      }) 
      	}
$(".chargementPrime1").fadeOut();
      },
            error:function(data){
           $(".chargementGazoil1").fadeOut();
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })
                
       }
       });
	}
}

function afficheAllVidange(idTable){

  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();

  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllVidange",
      data:{"date_fin":date_fin,"date_debut":date_debut},
      success: function(data){

        $(".contentPrime").empty();
        $(".contentPrime").append(data);
        ceerDatatable(idTable)
        $(".chargementPrime").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime").fadeOut();
       }
       });
}

function confirmSuppressionVidange(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deleteVidange",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllVidange('#example1');
        
          
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

function infoVidange(montant,libelle,date,codeCamion,id_operation,id_prime,qtite,kilometrage,pu,id_fournisseur){
	$(".PU").val(pu);
  $(".huile").val(parseInt(montant));
  $(".qtite").val(qtite);
  $(".kilometrage").val(kilometrage);
  // alert(montant);
	$(".commentaire").val(libelle);
	$(".datePrime").val(date);
	$(".camion").val(codeCamion);
	$(".operation").val(id_operation);
	$(".id_fournisseur").val(id_fournisseur);
	$(".id_prime").val(id_prime);

	$(".btnAdd").fadeOut();
	$(".btnAnnuler").fadeIn();
	$(".btnModif").fadeIn();
  getPrixTotalVidange();
  getDescriptionOperation();
}

function infoVidangeBoite(montant,libelle,date,codeCamion,id_operation,id_prime,qtite,pu,id_fournisseur){
  $(".PU").val(pu);
  $(".huile").val(parseInt(montant));
  $(".qtite").val(qtite);
  // alert(montant);
  $(".commentaire").val(libelle);
  $(".datePrime").val(date);
  $(".camion").val(codeCamion);
  $(".operation").val(id_operation);
  $(".id_fournisseur").val(id_fournisseur);
  $(".id_prime").val(id_prime);

  $(".btnAdd").fadeOut();
  $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
  getPrixTotalVidange();
  getDescriptionOperation();
}

function infoVidangeHydrolique(montant,libelle,date,codeCamion,id_operation,id_prime,qtite,pu,id_fournisseur){
  $(".PU").val(pu);
  $(".huile").val(parseInt(montant));
  $(".qtite").val(qtite);
  // alert(montant);
  $(".commentaire").val(libelle);
  $(".datePrime").val(date);
  $(".camion").val(codeCamion);
  $(".operation").val(id_operation);
  $(".id_fournisseur").val(id_fournisseur);
  $(".id_prime").val(id_prime);

  $(".btnAdd").fadeOut();
  $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
  getPrixTotalVidange();
  getDescriptionOperation();
}

function infoVidangeGraisse(montant,libelle,date,codeCamion,id_operation,id_prime,qtite,pu,id_fournisseur){
  $(".PU").val(pu);
  $(".huile").val(parseInt(montant));
  $(".qtite").val(qtite);
  // alert(montant);
  $(".commentaire").val(libelle);
  $(".datePrime").val(date);
  $(".camion").val(codeCamion);
  $(".operation").val(id_operation);
  $(".id_fournisseur").val(id_fournisseur);
  $(".id_prime").val(id_prime);

  $(".btnAdd").fadeOut();
  $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
  getPrixTotalVidange();
  getDescriptionOperation();
}



// ce qui suit est la code des pieces de rechange

function getPrixTotalPourPieceRechange(){
  PU = $(".PU").val();
  qtite = $(".qtite").val();

  PU = PU.replace(/\s/g,'');

  PU = parseInt(PU);
 pt = PU*parseInt(qtite);
 formatMillierPourSelection(''+pt+'','PT');
}

function compareQte(){
  qtite = $(".qtite").val();
  stock = $(".stock").val();

  qtite = qtite.replace(/\s/g,'');

  qtite = parseInt(qtite);
  
  stock = stock.replace(/\s/g,'');

  stock = parseInt(stock);
  
  if (qtite > stock ) {
	  
	$(".qtite").val("");
	
	} else {
		
	$(".qtite").val(qtite);	
}	
  
 
}

function remiseZero(){
	
	
  qtite = $(".qtite").val();
  stock = $(".stock").val();

  qtite = qtite.replace(/\s/g,'');

  qtite = parseInt(qtite);
  
  stock = stock.replace(/\s/g,'');

  stock = parseInt(stock);
  
  if (qtite > stock ) {
	  
	$(".qtite").val("");
	
	} else {
		
	$(".qtite").val(qtite);	
}	
  
 
}







// pour pieces de rechange
function getMontantTotal(){
  pu = $(".PU1").val();
  quantite = $(".qtite").val();
  // var quantite = quantite.replace(".",",");
  if (quantite == 0 || quantite == "") {
$(".PT").val(0);
  }else if (pu == 0 || pu == "") {
    $(".PT").val(0);
  }else{ 
    // $(".PT").val(parseInt(pu)*parseInt(quantite)+" FCFA");
    pu = pu.replace(/\s+/g, '');
    // alert(pu);
    total = parseFloat(pu)*parseFloat(quantite);
    
    formatMillierPourSelection(''+total.toFixed(2)+'','PT');
  }
}

function getPrixAvecTVAPieceRechange(){

  tva = $(".tva").val();
  pu = $(".PU").val();
  pu = pu.replace(/\s+/g, '');
  if (tva == 'oui') {
    
    nouveauPU =Math.round(parseFloat(pu) * 1.1925);
    // $(".PU1").val( nouveauPU);
    formatMillierPourSelection(''+nouveauPU+'','PU1');
    // alert(parseFloat(pu));
    getMontantTotal();
  }else{
    $(".PU1").val($(".PU").val());
    getMontantTotal();
  }
  
}


function getDepenseGasoil(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut!="" && date_fin!="") {
    $('#example1').DataTable().destroy();
  afficheAllGazoil('#example1');
  }
  
}

function getPieceRechangeParDate(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut!="" && date_fin!="") {
    $('#example1').DataTable().destroy();
  afficheAllPieceRechange('#example1');
  }
  
}

function getPrimeParDate(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut!="" && date_fin!="") {
    $('#example1').DataTable().destroy();
  afficheAllPrime('#example1');
  }
  
}

function getFraisRouteParDate(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut!="" && date_fin!="") {
    $('#example1').DataTable().destroy();
  afficheAllFraisRoute('#example1');
  }
  
}


function getFraisDiversParDate(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut!="" && date_fin!="") {
    $('#example1').DataTable().destroy();
  afficheAllFraisDivers('#example1');
  }
  
}

function getFraisAchatParDate(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut!="" && date_fin!="") {
    $('#example1').DataTable().destroy();
  afficheAllFraisAchat('#example1');
  }
  
}

function getVidangeParDate(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut!="" && date_fin!="") {
    $('#example1').DataTable().destroy();
  afficheAllVidange('#example1');
  }
  
}

function getDepensePneuParDate(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut!="" && date_fin!="") {
    $('#example1').DataTable().destroy();
  afficheAllDepensePneu('#example1');
  }
  
}

function getVidangeHydroliqueParDate(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut!="" && date_fin!="") {
    $('#example1').DataTable().destroy();
  afficheAllVidangeHydrolique('#example1');
  }
  
}

function getVidangeBoiteParDate(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut!="" && date_fin!="") {
    $('#example1').DataTable().destroy();
  afficheAllVidangeBoite('#example1');
  }
  
}

function addPieceRechange(status){
  origine = $(".origine").val();
  pu = $(".PU1").val();
	article = $(".article").val();
	commentaire = $(".commentaire").val();
	date = $(".datePrime").val();
	bon_sortie = $(".bon_sortie").val();
	codeCamion = $(".camion").val();
  qtite = $(".qtite").val();
	id_operation = $(".operation").val();
	id_frais_route = $(".id_prime").val();
  id_fournisseur = $(".id_fournisseur").val();

  tva = $(".tva").val();

	if (article == "") {
	$(".article").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
	}else if (date == "") {
	$(".datePrime").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else if (qtite == "") {
  $(".qtite").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (commentaire == "") {
	$(".commentaire").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else if (id_operation == "") {
  $(".operation").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (id_fournisseur == "") {
  $(".id_fournisseur").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (pu== "") {
  $(".PU").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else{
    $(".PU").css("border","1px solid #ced4da");
    $(".id_fournisseur").css("border","1px solid #ced4da");
    $(".operation").css("border","1px solid #ced4da");
    $(".qtite").css("border","1px solid #ced4da");
	$(".article").css("border","1px solid #ced4da");
	$(".commentaire").css("border","1px solid #ced4da");
	$(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
	 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addPieceRechange",
      data:{"tva":tva,"origine":origine,"pu":pu,"id_fournisseur":id_fournisseur,"id_frais_divers":id_frais_route,"qtite":qtite,"status":status,"article":article,"commentaire":commentaire,"date":date,"id_operation":id_operation,"codeCamion":codeCamion,"bon_sortie":bon_sortie},
      success: function(data){  

      	if ($.trim(data) == "Pièce de rechange ajoutée") {

      	$('#example1').DataTable().destroy();
        afficheAllPieceRechange('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
      	}else if ($.trim(data) == "Pièce de rechange modifiée") {

      	$('#example1').DataTable().destroy();
        afficheAllPieceRechange('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
      	}else{
      	$(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      }) 
      	}
$(".chargementPrime1").fadeOut();
      },
            error:function(data){
           $(".chargementGazoil1").fadeOut();
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })
                
       }
       });
	}
}

function afficheAllDepensePneu(idTable){
	
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
	
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllDepensePneu",
      data:{"date_fin":date_fin,"date_debut":date_debut},
      success: function(data){

        $(".contentPrime").empty();
        $(".contentPrime").append(data);
        ceerDatatable(idTable)
        $(".chargementPrime").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime").fadeOut();
       }
       });
}

function addDepensePneu(status){

  pu = $(".PU").val();
  derniereDate = $(".derniereDate").val();
  
  article = $(".article").val();
  commentaire = $(".commentaire").val();
  date = $(".datePrime").val();
  codeCamion = $(".camion").val();
  qtite = $(".qtite").val();
  id_frais_route = $(".id_prime").val();
  id_fournisseur = $(".id_fournisseur1").val();

  if (article == "") {
  $(".article").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
  }else if (date == "") {
  $(".datePrime").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (qtite == "") {
  $(".qtite").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (commentaire == "") {
  $(".commentaire").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (codeCamion == "") {
  $(".codeCamion").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (pu== "") {
  $(".PU").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else{
    $(".PU").css("border","1px solid #ced4da");
    $(".derniereDate").css("border","1px solid #ced4da");
    $(".id_fournisseur").css("border","1px solid #ced4da");
    $(".operation").css("border","1px solid #ced4da");
    $(".qtite").css("border","1px solid #ced4da");
  $(".article").css("border","1px solid #ced4da");
  $(".commentaire").css("border","1px solid #ced4da");
  $(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addDepensePneu",
      data:{"derniereDate":derniereDate,"id_frais_route":id_frais_route,"pu":pu,"qtite":qtite,"status":status,"article":article,"commentaire":commentaire,"date":date,"codeCamion":codeCamion,"id_fournisseur":id_fournisseur},
      success: function(data){  

        if ($.trim(data) == "Pièce de rechange ajoutée") {

        $('#example1').DataTable().destroy();
        afficheAllDepensePneu('#example1');
          $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
        }else if ($.trim(data) == "Pièce de rechange modifiée") {

        $('#example1').DataTable().destroy();
        afficheAllDepensePneu('#example1');
          $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
        }else{
        $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      }) 

        $(".chargementPrime1").fadeOut();
        }
$(".chargementPrime1").fadeOut();
      },
            error:function(data){
           $(".chargementGazoil1").fadeOut();
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })
                
       }
       });
  }
}

function addDepensePneu1(status){

  
  datePrime1 = $(".datePrime1").val();
  
  
  nbreLigne = $(".nbreLigne").val();
 

  article = [];
  fournisseur = [];
  fournisseur1 = [];
  reference = [];
 
  immatriculation = [];
  immatriculation1 = [];
  kilometrage_debut = [];
  quantite = [];
  pu = [];
  camion = [];

  id_prime = [];

  i=1;
  
 if (datePrime1 == ""){
    $('.datePrime1').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else {
   
    $('.datePrime1').css("border","1px solid #ced4da");
    
    

    do{
    if ($('.article'+i).val() == "") {
    $('.article'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs"); 
    }else if ($('.qtite_com'+i).val() == "") {
    $('.qtite_com'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else if ($('.pu'+i).val() == "") {
    $('.pu'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else if ($('.camion'+i).val() == "") {
    $('.camion'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else if ($('.fournisseur'+i).val() == "") {
    $('.fournisseur'+i).css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
     }
    else{
    
    $('.article'+i).css("border","1px solid #ced4da");
    $('.qtite_com'+i).css("border","1px solid #ced4da");
    $('.pu'+i).css("border","1px solid #ced4da");
    $('.camion'+i).css("border","1px solid #ced4da");
    $('.fournisseur'+i).css("border","1px solid #ced4da");

    article[i] = $('.article'+i).val();
    quantite[i] = $('.qtite_com'+i).val();
    pu[i] = $('.pu'+i).val();
    camion[i] = $('.camion'+i).val();
    fournisseur[i] = $('.fournisseur'+i).val();
	fournisseur1[i] = $('.fournisseur1'+i).val();
	reference[i] = $('.reference'+i).val();
	
	immatriculation[i] = $('.immatriculation'+i).val();
	immatriculation1[i] = $('.immatriculation1'+i).val();
	kilometrage_debut[i] = $('.kilometrage_debut'+i).val();
    id_prime[i] = $('.id_prime'+i).val();
   
    }
    i++;
    }while(i<=nbreLigne)
  if (article.length >nbreLigne && quantite.length>nbreLigne && pu.length>nbreLigne && camion.length>nbreLigne && fournisseur.length>nbreLigne) {
$(".chargementPrime1").fadeIn();
// alert(status);
     $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addDepensePneu1",
      data:{"status":status,"datePrime1":datePrime1,"nbreLigne":nbreLigne,"id_prime":JSON.stringify(id_prime),"article":JSON.stringify(article),"reference":JSON.stringify(reference),"quantite":JSON.stringify(quantite),"pu":JSON.stringify(pu),"camion":JSON.stringify(camion),"fournisseur":JSON.stringify(fournisseur),"fournisseur1":JSON.stringify(fournisseur1),"immatriculation":JSON.stringify(immatriculation),"immatriculation1":JSON.stringify(immatriculation1),"kilometrage_debut":JSON.stringify(kilometrage_debut)},
      success: function(data){
        if ($.trim(data) == "Insertion parfaite de la depense Pneu") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 
             
         
        $(".datePrime1").val("");
   
             $('#example1').DataTable().destroy();
             afficheAllDepensePneu("#exemple1");
            }else if ($.trim(data) == "Modification parfaite de la commande") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 


        $('#example1').DataTable().destroy();
             afficheAllDepensePneu("#exemple1");

          
        $(".datePrime1").val("");
        
		
       // nouveauCode();
            } else{
              alert(data);
            $(".chargementPrime1").fadeOut();
              $(document).Toasts('create', {
            class: 'bg-danger', 
            title: 'Erreur de connexion',
            subtitle: 'Alert',
            body:data
          })  

            }
            
          },
           error:function(data){
            $(".chargementPrime1").fadeOut();
              $(document).Toasts('create', {
            class: 'bg-danger', 
            title: 'Erreur de connexion',
            subtitle: 'Alert',
            body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
          })   
              $(".chargementCarteGrise").fadeOut();
           }
       });
  }else{
    $(".chargementPrime1").fadeOut();
              $(document).Toasts('create', {
            class: 'bg-danger', 
            title: 'Erreur de connexion',
            subtitle: 'Alert',
            body: "Veuillez remplir votre commande"
          })   
  }
  }
}

function afficheAllPieceRechange(idTable){

  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  articles1 = $(".articles1").val();
  articles2 = $(".articles2").val();
  camion1 = $(".camion1").val();

  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllPieceRechange",
      data:{"date_debut":date_debut,"date_fin":date_fin,"articles1":articles1,"articles2":articles2,"camion1":camion1},
      success: function(data){

        $(".contentPrime").empty();
        $(".contentPrime").append(data);
        ceerDatatable(idTable)
        $(".chargementPrime").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime").fadeOut();
       }
       });
}

function confirmSuppressionPieceRechange(){
 // table = $(".table").val();
 // identifiant = $(".identifiant").val();
 // nom_id = $(".nom_id").val();
 // // creerDatable("exemple1");
 // $.ajax({
 //      type:"POST",
 //      url:base_url+"/admin_document/deleteDocument",
 //      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
 //      success: function(data){  

 //        toastr.success(data);
 //        $('#example1').DataTable().destroy();
 //        afficheAllPieceRechange('#example1');
        
          
 //      },
 //            error:function(data){
 //          $(document).Toasts('create', {
 //        class: 'bg-danger', 
 //        title: 'Erreur de connexion',
 //        subtitle: 'Alert',
 //        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
 //      })
                
 //       }
 //       });
 tabArticle = $(".tabArticle").val();
 if (tabArticle == "" || tabArticle == undefined) {
alert(tabArticle);
    $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Sélectionnez une piède de rechange'
      })
 }else{
   deletePieceRechange();
 }

}

function verifValeurDansTableau(tabValeur,valeur){
  i=0;
  j = 0;
  article = ""
  newTabValeur =[];
  do{
    if (tabValeur[i] == valeur || tabValeur[i] == undefined) {
      // newTabValeur[i] = null;
    }else{
      // newTabValeur[i] = tabValeur[i];
      article = article.substring(1);
      article = article+","+tabValeur[i];
    }
    i++;
    
  }while(i <= tabValeur.length)
  $(".tabArticle").val("");
    $(".tabArticle").val(article);
}
function selectionArticlePourSuppression(index,valeur){
  // valeur = this.attr("class");

  tabArticle = $(".tabArticle").val();
  article = [];
  // var texte = "lundi,mardi,mercredi,jeudi,vendredi,samedi,dimanche";
var myTab = tabArticle.split(',');
if ($('.'+index+'').is(':checked')){
  // alert(index);
  if (tabArticle == "") {
    tabArticle=valeur;
    $(".tabArticle").val(tabArticle);
  }else{
    tabArticle =tabArticle+","+valeur;
    $(".tabArticle").val(tabArticle);
  }
}else{
  verifValeurDansTableau(myTab,valeur)
}
  

  // alert(JSON.stringify(myTab));
}

function deletePieceRechange(){
  
  tabArticle = $(".tabArticle").val();
  var myTab = tabArticle.split(',');
   table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();

  compteur = myTab.length;
  i=0;

  article = [];
  donnee="";
  // alert(nom_id);
  do{

    // alert(myTab[i]);

    $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deletePieceRechange",
      data:{"identifiant":myTab[i],"compteur":compteur,"table":table,"nom_id":nom_id},
      success: function(data){  
if ($.trim(data) == "Suppression effectuée") {
  $(".identifiant").val("");
  toastr.success(data);

  // $('#example1').DataTable().destroy();
  //       afficheAllPieceRechange('#example1');
}else{
   $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur :'+data
      })
}
       
        
          
      },
            error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })
                
       }
       })
     
    

    i++;
  }while(i<=compteur-1);


        $('#example1').DataTable().destroy();
        afficheAllPieceRechange('#example1');
}


function confirmSuppressionDepensePneu(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deleteDepensePneu",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllDepensePneu('#example1');
        
          
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

function getFournisseurPourModifPiece(id_fournisseur){
 
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getFournisseurPourModifPiece",
      data:{"id_fournisseur":id_fournisseur},
      success: function(data){
        $(".id_fournisseur ").empty();
        $(".id_fournisseur ").append(data);
        // alert(data);
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementGazoil").fadeOut();
       }
       });
}

function getArticlePourModifPiece(id_article){
 
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getArticlePourModifPiece",
      data:{"id_article":id_article},
      success: function(data){
        $(".article").empty();
        $(".article").append(data);
        // alert(data);
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementGazoil").fadeOut();
       }
       });
}

function infoDepensePneu(codeCamion,id_article,qtite,pu1,type,derniereDate,date,id_depense,commentaire,fournisseur){
  
    formatMillierPourSelection(pu1,'PU');
  $(".qtite").val(qtite);
  $(".article").val(id_article);
  // alert(tva);
  $(".derniereDate").val(derniereDate);
  $(".commentaire").val(commentaire);
  $(".id_fournisseur").val(commentaire);
  $(".type").val(type);
  $(".comion").val(codeCamion);
  $(".datePrime").val(date);
  $(".id_prime").val(id_depense);
  total = pu1*qtite;

  // formatMillierPourSelection(total,'PT');
$(".PT").val(total);
  $(".btnAdd").fadeOut();
  $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
}


function infoPieceRechange(codeCamion,id_article,origine,qtite,id_operation,date,pu,commentaire,id_rechange,id_fournisseur,origine,tva,pu1,bon_sortie){
	
    formatMillierPourSelection(pu1,'PU');
  $(".qtite").val(qtite);
  $(".tva").val(tva);
  // alert(tva);
	$(".commentaire").val(commentaire);
	$(".datePrime").val(date);
	$(".bon_sortie").val(bon_sortie);
	$(".id_prime").val(id_rechange);
  getCodePourModifGazoil(codeCamion);
  getArticlePourModifPiece(id_article);
  getOperationPourModifGazoil(id_operation);

  

  if (origine == "interne") {
    $(".origine").empty();
    $(".origine").append("<option>interne</option> <option>externe</option>");
    // getPrixUnitaireArticle();
    // alert("saa");
  id_fournisseur = 65;
    
    getFournisseurMira(id_fournisseur);
  
  formatMillierPourSelection(pu,'PU1');
 
  // origine = $(".origine").val();
  //  $.ajax({
  //     type:"POST",
  //     url:base_url+"/admin_depense/getPrixUnitaireArticle",
  //     data:{'id_article':id_article,"origine":origine},
  //     success: function(data){
  //       $(".PU").val("");
  //       formatMillierPourSelection(data,'PU');
  //       // alert(id_article);
  //     },
  //      error:function(data){
  //         $(document).Toasts('create', {
  //       class: 'bg-danger', 
  //       title: 'Erreur de connexion',
  //       subtitle: 'Alert',
  //       body: 'Erreur vérifier votre connexion ou contactez l\'administrateur '+data.responseText
  //     })   
  //         $(".chargementClient").fadeOut();
  //      }
  //      });
  }else{
    $(".origine").empty();
    $(".origine").append(" <option>externe</option><option>interne</option>");
    formatMillierPourSelection(pu,'PU1');
  }
	$(".btnAdd").fadeOut();
	$(".btnAnnuler").fadeIn();
	$(".btnModif").fadeIn();
   getDescriptionOperation(id_operation);
   
   
  getFournisseurPourModifPiece(id_fournisseur);

    $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getReferenceArticle",
      data:{'id_article':id_article},
      success: function(data){
        $(".reference").val("");
        $(".reference").val(data);
        // alert(data);
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
      total = pu*qtite;
  formatMillierPourSelection(''+total+'',"PT");
}

function getMontantTotalGazoil(){
  pu = $(".prixUnitaire").val();
  quantite = $(".litrage").val();
  destination = $(".destination").val();
  destination2 = $(".destination option:selected").text();
  // alert(destination2)
   // on va vérifier si la destination c'est SITE MIRA à travers son identifiant
   code_camion = $(".code_camion").val();
   blocage ="";
$.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getTypeCamion",
      data:{"code_camion":code_camion},
      success: function(data){
     // if ($.trim(data) == "true" || destination2 == "SITE MIRA" || destination2 == "PORT") {
     //  blocage = "oui";
     //  $(".litrage").removeAttr("disabled","true");
     // }else{
     //  blocage = "non";
     //  $(".litrage").attr("disabled","true");
     // }
     
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
// if (destination2 == "SITE MIRA" || destination2 == "PORT" || blocage == "non") {
//   // $(".supplement").removeAttr('disabled','true');
//   // supplement = $(".supplement").val();
//   // if (supplement == "") {
//   //   supplement = 0;
//   // }
//   $(".litrage").removeAttr("disabled","true");
 
// }else{
//   // $(".supplement").attr('disabled','true');
//   // supplement = 1;
//   // $(".supplement").val("");
//   $(".litrage").attr("disabled","true");
// }
 // code_camion = $(".code_camion").val();
 // $(".supplement").attr('disabled','true');
 // getTypeCamion(code_camion);
  if (quantite == 0 || quantite == "") {
$(".PT").val(0);
  }else if (pu == 0 || pu == "") {
    $(".PT").val(0);
  }else{  
    // qtite = parseInt(quantite)+parseInt(supplement);
     // alert(qtite);
    // $(".PT").val(+" FCFA");'
        formatMillierPourSelection(''+parseInt(quantite)*pu+'','PT');
  }
}



function addVidangeHydrolique(status){
  qtite = $(".qtite").val();
  PU = $(".PU").val();
  huile = $(".huile").val();
  commentaire = $(".commentaire").val();
  date = $(".datePrime").val();
  codeCamion = $(".camion").val();
  id_fournisseur = $(".id_fournisseur").val();
  id_operation = $(".operation").val();
  id_frais_route = $(".id_prime").val();

  if (huile == "") {
  $(".huile").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
  }else if (date == "") {
  $(".datePrime").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (commentaire == "") {
  $(".commentaire").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (qtite == "") {
  $(".qtite").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (PU == "") {
  $(".PU").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else{
    $(".qtite").css("border","1px solid #ced4da");
    $(".PU").css("border","1px solid #ced4da");
  $(".huile").css("border","1px solid #ced4da");
  $(".commentaire").css("border","1px solid #ced4da");
  $(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addVidangeHydrolique",
      data:{"PU":PU,"id_frais_divers":id_frais_route,"qtite":qtite,"status":status,"huile":huile,"commentaire":commentaire,"date":date,"id_operation":id_operation,"codeCamion":codeCamion,"id_fournisseur":id_fournisseur},
      success: function(data){  

        if ($.trim(data) == "Vidange enregistrée") {

        $('#example1').DataTable().destroy();
        afficheAllVidangeHydrolique('#example1');
          $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
        }else if ($.trim(data) == "Vidange modifiée") {

        $('#example1').DataTable().destroy();
        afficheAllVidangeHydrolique('#example1');
          $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
        }else{
        $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      }) 
        }
$(".chargementPrime1").fadeOut();
      },
            error:function(data){
           $(".chargementGazoil1").fadeOut();
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })
                
       }
       });
  }
}

function addVidangeGraisse(status){
  qtite = $(".qtite").val();
  PU = $(".PU").val();
  huile = $(".huile").val();
  commentaire = $(".commentaire").val();
  date = $(".datePrime").val();
  codeCamion = $(".camion").val();
  id_fournisseur = $(".id_fournisseur").val();
  id_operation = $(".operation").val();
  id_frais_route = $(".id_prime").val();

  if (huile == "") {
  $(".huile").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
  }else if (date == "") {
  $(".datePrime").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (commentaire == "") {
  $(".commentaire").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (qtite == "") {
  $(".qtite").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (PU == "") {
  $(".PU").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else{
    $(".qtite").css("border","1px solid #ced4da");
    $(".PU").css("border","1px solid #ced4da");
  $(".huile").css("border","1px solid #ced4da");
  $(".commentaire").css("border","1px solid #ced4da");
  $(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addVidangeGraisse",
      data:{"PU":PU,"id_frais_divers":id_frais_route,"qtite":qtite,"status":status,"huile":huile,"commentaire":commentaire,"date":date,"id_operation":id_operation,"codeCamion":codeCamion,"id_fournisseur":id_fournisseur},
      success: function(data){  

        if ($.trim(data) == "Vidange enregistrée") {

        $('#example1').DataTable().destroy();
        afficheAllVidangeGraisse('#example1');
          $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
        }else if ($.trim(data) == "Vidange modifiée") {

        $('#example1').DataTable().destroy();
        afficheAllVidangeGraisse('#example1');
          $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
        }else{
        $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      }) 
        }
$(".chargementPrime1").fadeOut();
      },
            error:function(data){
           $(".chargementGazoil1").fadeOut();
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })
                
       }
       });
  }
}


function afficheAllVidangeGraisse(idTable){

  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();

  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllVidangeGraisse",
      data:{"date_fin":date_fin,"date_debut":date_debut},
      success: function(data){

        $(".contentPrime").empty();
        $(".contentPrime").append(data);
        ceerDatatable(idTable)
        $(".chargementPrime").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime").fadeOut();
       }
       });
}


function afficheAllVidangeHydrolique(idTable){

  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();

  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllVidangeHydrolique",
      data:{"date_fin":date_fin,"date_debut":date_debut},
      success: function(data){

        $(".contentPrime").empty();
        $(".contentPrime").append(data);
        ceerDatatable(idTable)
        $(".chargementPrime").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime").fadeOut();
       }
       });
}


function addVidangeBoite(status){
  qtite = $(".qtite").val();
  PU = $(".PU").val();
  huile = $(".huile").val();
  commentaire = $(".commentaire").val();
  date = $(".datePrime").val();
  codeCamion = $(".camion").val();
  id_operation = $(".operation").val();
  id_fournisseur = $(".id_fournisseur").val();
  id_frais_route = $(".id_prime").val();

  if (huile == "") {
  $(".huile").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
  }else if (date == "") {
  $(".datePrime").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (commentaire == "") {
  $(".commentaire").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (qtite == "") {
  $(".qtite").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (PU == "") {
  $(".PU").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else{
    $(".qtite").css("border","1px solid #ced4da");
    $(".PU").css("border","1px solid #ced4da");
  $(".huile").css("border","1px solid #ced4da");
  $(".commentaire").css("border","1px solid #ced4da");
  $(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addVidangeBoite",
      data:{"PU":PU,"id_frais_divers":id_frais_route,"qtite":qtite,"status":status,"huile":huile,"commentaire":commentaire,"date":date,"id_operation":id_operation,"codeCamion":codeCamion,"id_fournisseur":id_fournisseur},
      success: function(data){  

        if ($.trim(data) == "Vidange enregistrée") {

        $('#example1').DataTable().destroy();
        afficheAllVidangeBoite('#example1');
          $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
        }else if ($.trim(data) == "Vidange modifiée") {

        $('#example1').DataTable().destroy();
        afficheAllVidangeBoite('#example1');
          $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
        }else{
        $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      }) 
        }
$(".chargementPrime1").fadeOut();
      },
            error:function(data){
           $(".chargementGazoil1").fadeOut();
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })
                
       }
       });
  }
}

function afficheAllVidangeBoite(idTable){

  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();

  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllVidangeBoite",
      data:{"date_fin":date_fin,"date_debut":date_debut},
      success: function(data){

        $(".contentPrime").empty();
        $(".contentPrime").append(data);
        ceerDatatable(idTable)
        $(".chargementPrime").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime").fadeOut();
       }
       });
}
function confirmSuppressionVidangeBoite(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deleteVidangeBoite",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllVidangeBoite('#example1');
        
          
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

function confirmSuppressionVidangeHydrolique(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deleteVidangeHydrolique",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllVidangeHydrolique('#example1');
        
          
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

function confirmSuppressionVidangeGraisse(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deleteVidangeGraisse",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllVidangeGraisse('#example1');
        
          
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



// code du type d'huile

function afficheAllTypeHuile(idTable){
  $(".chargementClient").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllTypeHuile",
      data:{},
      success: function(data){

        $(".contentClient").empty();
        $(".contentClient").append(data);
        ceerDatatable(idTable)
        $(".chargementClient").fadeOut();
        // formAddRemorque();
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

function addTypeHuile(status){
  // alert(status);
  huile = $(".huile").val();
  PU = $(".PU").val();
  type_huile = $(".type_huile").val();
  id_client = $(".id_client").val();
  if (huile == "") {
    $(".huile").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (PU == "") {
    $(".PU").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else{
    $(".huile").css("border","1px solid #ced4da");
    $(".PU").css("border","1px solid #ced4da");
$(".chargementCarteGrise1").fadeIn();
     $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addTypeHuile",
      data:{"status":status,"id_client":id_client,"huile":huile,"PU":PU,"type_huile":type_huile},
       success: function(data){
   if ($.trim(data) == "Insertion parfaite de l'huile") {
    $(".huile").val("");
  $(".PU").val("");
    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllTypeHuile('#example1');
        $(".chargementCarteGrise1").fadeOut();
      }else if ($.trim(data) == "Modification parfaite du l'huile") {
        $(".huile").val("");
  $(".PU").val("");
    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllTypeHuile('#example1');
        $(".chargementCarteGrise1").fadeOut();
      }else{
         $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      }) 
         $(".chargementCarteGrise1").fadeOut();
      }
    
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementCarteGrise").fadeOut();
          $(".chargementCarteGrise1").fadeOut();
       }
       });
  }
}
function confirmSuppressionTypeHuile(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deleteTypeHuile",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllTypeHuile('#example1');
        
          
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
 function chiffres(event){
  if(!event && window.event){
    event = window.event;
  }
  var code = event.keyCode;
  var which = event.which;
  if((code < 48 || code > 57) && code!=46 && code!=8 && code!=9 && code!=16 && code!=13){
    event.returnValue = false;
    event.cancelBubble = true;
  }
  if((which < 48 || which > 57) && (code < 37 || code > 40) && code!=46 && code!=8 && code!=9 && code!=16 && code!=13 || event.ctrlkey){
    event.preventDefault();
    event.stopPropagation();
  }
}

function infosTypeHuile(id_client,nom,adresse,telephone){
  $(".huile").val(adresse);
  $(".type_huile").val(nom);
  $(".PU").val(telephone);
  $(".id_client").val(id_client);
  $(".btnAnnulerModif").fadeIn();
  $(".btnModifClient").fadeIn();
  $(".btnAddClient").fadeOut();
}

function annulerModifTypeHuile(){
$(".btnAnnulerModif").fadeOut();
  $(".btnModifClient").fadeOut();
  $(".btnAddClient").fadeIn();
}

function formatMillierPourSelection(data,classe){
   nombre = data;
          nombre = nombre.replace(/ /g,'');
       nombre +='';

      var sep = ' ';
      var reg = /(\d+)(\d{3})/;

      while( reg.test( nombre )){
        nombre = nombre.replace(reg,'$1'+sep+'$2');
      } 
    $("."+classe).val("");
     $("."+classe).val(nombre+" FCFA");
}

function getFournisseurMira(id_fournisseur){
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getFournisseurMira",
      data:{'id_fournisseur':id_fournisseur},
      success: function(data){
       $(".id_fournisseur").empty();
       $(".id_fournisseur").append(data);
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
function getAllFournisseurMira(){
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllFournisseurMira",
      data:{},
      success: function(data){
       $(".id_fournisseur").empty();
       $(".id_fournisseur").append(data);
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

function getAllFournisseurGazoil(){
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllFournisseurGazoil",
      data:{},
      success: function(data){
       $(".id_fournisseur").empty();
       $(".id_fournisseur").append(data);
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

function afficheLigneCommande(){
	nbreLigne = $(".nbreLigne").val();
$(".contentLignes").empty();
i=1;
$(".chargementPrime1").fadeIn();
conteneur = "";
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getNbreLigne",
      data:{"nbreLignes":nbreLigne,},
      success: function(data){
        $(".contentLignes").append(data);
        $(".chargementPrime1").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
    $(".chargementPrime1").fadeOut();
       }
       });
	// do {
// conteneur +='<div class="row"><div class="col-md-2"><div class="form-group"><label>Article</label><select class="article form-control" onchange="getPrixUnitaireArticle();"><option value=""></option><?php $this->crud_model_depense->leSelectArticle(); ?></select></div> </div><div class="col-md-2"><label>Quantite commandée</label><input type="text" class="form-control qtite_com'+i+'" placeholder=" en FCFA" onkeypress="chiffres(event);" ></div><div class="col-md-2"><label>Prix unitaire</label><input type="text" class="form-control pu'+i+'" placeholder=" en FCFA" onkeypress="chiffres(event);"></div><div class="col-md-2"><div class="form-group"><label>Camion</label><select class="camion'+i+' camion form-control"><?php $this->crud_model_depense->leSelectCodeCamion(); ?></select></div></div><div class="col-md-2"><div class="form-group "><label>Description</label><textarea class="form-control description'+i+'" ></textarea> </div></div></div><hr>';
// 	i++;
// 	}while(i<=nbreLigne)
// $(".contentLignes").append(conteneur);
// getListeCamion();
}

function afficheLigneDemande(){
	nbreLigne = $(".nbreLigne").val();
$(".contentLignes").empty();
i=1;
$(".chargementPrime1").fadeIn();
conteneur = "";
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getNbreLigne1",
      data:{"nbreLignes":nbreLigne,},
      success: function(data){
        $(".contentLignes").append(data);
        $(".chargementPrime1").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
    $(".chargementPrime1").fadeOut();
       }
       });

}

function afficheLigneDemandeNavette(){
	nbreLigne = $(".nbreLigne").val();
$(".contentLignes").empty();
i=1;
$(".chargementPrime1").fadeIn();
conteneur = "";
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getNbreLigne1N",
      data:{"nbreLignes":nbreLigne,},
      success: function(data){
        $(".contentLignes").append(data);
        $(".chargementPrime1").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
    $(".chargementPrime1").fadeOut();
       }
       });

}

function afficheLigneDemandeNavetteAutre(){
	nbreLigne = $(".nbreLigne").val();
$(".contentLignes").empty();
i=1;
$(".chargementPrime1").fadeIn();
conteneur = "";
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getNbreLigne1NA",
      data:{"nbreLignes":nbreLigne,},
      success: function(data){
        $(".contentLignes").append(data);
        $(".chargementPrime1").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
    $(".chargementPrime1").fadeOut();
       }
       });

}

function afficheLigneDemandeStockVehicule(){
	nbreLigne = $(".nbreLigne").val();
$(".contentLignes").empty();
i=1;
$(".chargementPrime1").fadeIn();
conteneur = "";
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getNbreLigne1ST",
      data:{"nbreLignes":nbreLigne,},
      success: function(data){
        $(".contentLignes").append(data);
        $(".chargementPrime1").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
    $(".chargementPrime1").fadeOut();
       }
       });

}



function afficheLigneDemandeEngin(){
	nbreLigne = $(".nbreLigne").val();
$(".contentLignes").empty();
i=1;
$(".chargementPrime1").fadeIn();
conteneur = "";
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getNbreLigne1E",
      data:{"nbreLignes":nbreLigne,},
      success: function(data){
        $(".contentLignes").append(data);
        $(".chargementPrime1").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
    $(".chargementPrime1").fadeOut();
       }
       });

}



function getPrixUnitaireArticle1(id_article,pu){
    
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getPrixUnitaireArticle1",
      data:{'id_article':id_article,"origine":""},
      success: function(data){
      	// alert(pu);
        $("."+pu).val("");
        formatMillierPourSelection(data,pu);
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

function getFournisseurArticle1(id_article,fournisseur){
    
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getFournisseurArticle1",
      data:{'id_article':id_article,"origine":""},
      success: function(data){
      	// alert(pu);
        $("."+fournisseur).val("");
		$("."+fournisseur).val(data);
       // formatMillierPourSelection(data,fournisseur);
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

function getFournisseurArticle1_1(id_article,fournisseur1){
    
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getFournisseurArticle1_1",
      data:{'id_article':id_article,"origine":""},
      success: function(data){
      	// alert(pu);
        $("."+fournisseur1).val("");
		$("."+fournisseur1).val(data);
       // formatMillierPourSelection(data,fournisseur);
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

function getReferenceArticle1(id_article,reference){
    
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getReferenceArticle1",
      data:{'id_article':id_article,"origine":""},
      success: function(data){
      	// alert(pu);
        $("."+reference).val("");
		$("."+reference).val(data);
       // formatMillierPourSelection(data,fournisseur);
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

function getMatriculeVehicule1(id_camion,immatriculation,immatriculation1,kilometrage_debut){
    
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getMatriculeVehicule1",
      data:{'id_camion':id_camion,"origine":""},
      success: function(data){
      	// alert(pu);
        $("."+immatriculation).empty();
		 $("."+immatriculation1).empty();
		  $("."+kilometrage_debut).empty();
		$("."+immatriculation).append(data);
       // formatMillierPourSelection(data,fournisseur);
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

function getMatriculeVehicule3(){
	
  camion1 = $(".camion1").val();
  
  immatriculation1 = $(".immatriculation1").val();
   
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getMatriculeVehicule3",
      data:{"camion1":camion1},
      success: function(data){
      	
        $(".immatriculation1").empty();		 
		$(".immatriculation1").append(data);
    
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


function getTypeVehicule3(){
	
  camion1 = $(".camion1").val();
  
  type1 = $(".type1").val();
   
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getTypeVehicule3",
      data:{"camion1":camion1},
      success: function(data){
      	
        $(".type1").empty();		 
		$(".type1").append(data);
    
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

function getTypeVehicule3_1(camion1,typeA){
	
 

   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getTypeVehicule3_1",
      data:{'camion1':camion1},
      success: function(data){
      	
        $("."+typeA).val("");
		 
		$("."+typeA).val(data);
			
		
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

function getNomTypeVehicule3_1(camion1,typeC){
	
 

   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getNomTypeVehicule3_1",
      data:{'camion1':camion1},
      success: function(data){
      	
        $("."+typeC).val("");
		 
		$("."+typeC).val(data);
			
		
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


function getDistanceParCodeCamion1(camion1,destinationM){
	

   
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getDistanceParCodeCamion1",
      data:{'camion1':camion1},
      success: function(data){
      	
		  $("."+destinationM).empty();
		  
		
		 
		$("."+destinationM).append(data);
		
	
		
      
    
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

function getLitrageCamion1(destinationM,typeA,litrage){
	

  
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getLitrageCamion1",
      data:{'typeA':typeA,'destinationM':destinationM},
      success: function(data){
      	
      $("."+litrage).val("");
		 
		$("."+litrage).val(data);
		
		
	
		
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

function getLitrageCamion2(destination1,typeA,gazoil1){
	
	
	
  
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getLitrageCamion2",
      data:{'typeA':typeA,'destination1':destination1},
      success: function(data){
      	
      $("."+gazoil1).val("");
		 
		$("."+gazoil1).val(data);
		
		
		
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


function getFraisRoute1(destinationM,typeA,route){
	

   
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getFraisRoute1",
      data:{"typeA":typeA,"destinationM":destinationM},
      success: function(data){
      	
       $("."+route).val("");
		 
		$("."+route).val(data);
    
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

function getFraisRetour1(destinationM,typeA,retour){
	
 
   
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getFraisRetour1",
      data:{"typeA":typeA,"destinationM":destinationM},
      success: function(data){
		  
      	$("."+retour).val("");
		 
		$("."+retour).val(data);
    
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

function addDemande(status){

	
	date_demande = $(".date_demande").val();
	
	po = $(".po").val();
	
	etat_demande = $(".etat_demande").val();
	
	etat_demande1 = $(".etat_demande1").val();
	
	nbreLigne = $(".nbreLigne").val();
	
	delegue = [];
	bl = [];
	date_demande1 = [];
	camion1 = [];
	immatriculation1 = [];
	client = [];
	destinationM = [];
	destination2 = [];
	
	route = [];
	routeM = [];
	retour = [];
	retourM = [];
	pont = [];
	pontM = [];
	marchandiseD = [];
	marchandiseR = [];
	
	kilometrage = [];
	
	tour = [];
	tonnage = [];
	
	rjFR = [];
	rjFT = [];
	rjP = [];
	typeA = [];
	gazoil = [];
	gazoilG = [];
	id_demande = [];
	
	if ($('.rj').prop('checked')) {



      rj='oui';



    }else{



      rj = 'non';



    }
	
	if ($('.rj1').prop('checked')) {



      rj1='oui';



    }else{



      rj1 = 'non';



    }
	
	
	if ($('.rj2').prop('checked')) {


      rj='oui';

      rj2='oui';


    }else{
		
	   rj2 = 'non';

    }
	
	
	
	i=1;
	
if  (date_demande == ""){
		$('.date_demande').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
	}else if (etat_demande == ""){
		$('.etat_demande').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
	}else if (etat_demande1 == ""){
		$('.etat_demande1').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
	}else if (po == "") {
		$('.po').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
	}else {
		$('.date_demande').css("border","1px solid #ced4da");
		$('.etat_demande').css("border","1px solid #ced4da");
		$('.po').css("border","1px solid #ced4da");
		
}
		do{
			
		if ($('.delegue'+i).val() == "") {
		$('.delegue'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
        return;				
		}else if ($('.bl'+i).val() == "") {
		$('.bl'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.date_demande1'+i).val() == "") {
		$('.date_demande1'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.camion1'+i).val() == "") {
		$('.camion1'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.immatriculation1'+i).val() == "") {
		$('.immatriculation1'+i).css("border","red 2px solid");
		     toastr.error("Veuillez remplir tous les Champs");
			  return;
		}else if ($('.client'+i).val() == "") {
		$('.client'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.destination1M'+i).val() == "") {
		$('.destinationM'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.destination2'+i).val() == "") {
		$('.destination2'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.route'+i).val() == "") {
		$('.route'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.retour'+i).val() == "") {
		$('.retour'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.pont'+i).val() == "") {
		$('.pont'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.kilometrage'+i).val() == "") {
		$('.kilometrage'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.tour'+i).val() == "") {
		$('.tour'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.tonnage'+i).val() == "") {
		$('.tonnage'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else{
		
		$('.delegue'+i).css("border","1px solid #ced4da");
		$('.bl'+i).css("border","1px solid #ced4da");
		$('.date_demande1'+i).css("border","1px solid #ced4da");
		$('.camion1'+i).css("border","1px solid #ced4da");
		$('.immatriculation1'+i).css("border","1px solid #ced4da");
		$('.client'+i).css("border","1px solid #ced4da");
		$('.destinationM'+i).css("border","1px solid #ced4da");
		$('.destination2'+i).css("border","1px solid #ced4da");
		$('.route'+i).css("border","1px solid #ced4da");
		$('.retour'+i).css("border","1px solid #ced4da");
		$('.marchandiseD'+i).css("border","1px solid #ced4da");
		$('.marchandiseR'+i).css("border","1px solid #ced4da");
		$('.pont'+i).css("border","1px solid #ced4da");
		$('.kilometrage'+i).css("border","1px solid #ced4da");
		$('.tour'+i).css("border","1px solid #ced4da");
		$('.tonnage'+i).css("border","1px solid #ced4da");
		
		delegue[i] = $('.delegue'+i).val();
		bl[i] = $('.bl'+i).val();
		date_demande1[i] = $('.date_demande1'+i).val();
		camion1[i] = $('.camion1'+i).val();
		immatriculation1[i] = $('.immatriculation1'+i).val();
		client[i] = $('.client'+i).val();
		destinationM[i] = $('.destinationM'+i).val();
		destination2[i] = $('.destination2'+i).val();
		
		route[i] = $('.route'+i).val();
		routeM[i] = $('.routeM'+i).val();
		
		retour[i] = $('.retour'+i).val();
		retourM[i] = $('.retour'+i).val();
		
		pont[i] = $('.pont'+i).val();
		pontM[i] = $('.pontM'+i).val();
		
		marchandiseD[i] = $('.marchandiseD'+i).val();
		marchandiseR[i] = $('.marchandiseR'+i).val();
		
		id_demande[i] = $('.id_demande'+i).val();
		typeA[i] = $('.typeA'+i).val();
		gazoil[i] = $('.gazoil'+i).val();
		gazoilG[i] = $('.gazoilG'+i).val();
		kilometrage[i] = $('.kilometrage'+i).val();
		tour[i] = $('.tour'+i).val();
		tonnage[i] = $('.tonnage'+i).val();
		
	
	
	
	if ($('.rjFR'+i).prop('checked')) {

      rjFR[i]='oui';
	  
	  route[i]='0';

    }else{

      rjFR[i] = 'non';

    }
	
	if ($('.rjFT'+i).prop('checked')) {

      rjFT[i]='oui';
	  
	  retour[i]='0';

    }else{

      rjFT[i] = 'non';

    }
	
	if ($('.rjP'+i).prop('checked')) {

      rjP[i]='oui';
	  
	  pont[i]='0';

    }else{

      rjP[i] = 'non';

    }
		
		}
		i++;
		}while(i<=nbreLigne)
			
		
//	if (delegue.length >nbreLigne && camion1.length>nbreLigne && client.length>nbreLigne && destination1.length>nbreLigne && marchandiseD.length>nbreLigne) {
$(".chargementPrime1").fadeIn();
// alert(status);
	   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addDemande",
      data:{"status":status,"etat_demande":etat_demande,"etat_demande1":etat_demande1,"po":po,"date_demande":date_demande,"nbreLignes":nbreLigne,"rj":rj,"rj1":rj1,"rj2":rj2,'id_demande':JSON.stringify(id_demande),'delegue':JSON.stringify(delegue),'bl':JSON.stringify(bl),'date_demande1':JSON.stringify(date_demande1),'camion1':JSON.stringify(camion1),'immatriculation1':JSON.stringify(immatriculation1),'client':JSON.stringify(client),'destinationM':JSON.stringify(destinationM),'destination2':JSON.stringify(destination2),'route':JSON.stringify(route),'routeM':JSON.stringify(routeM),'pont':JSON.stringify(pont),'pontM':JSON.stringify(pontM),'retour':JSON.stringify(retour),'retourM':JSON.stringify(retourM),'typeA':JSON.stringify(typeA),'gazoil':JSON.stringify(gazoil),'gazoilG':JSON.stringify(gazoilG),'marchandiseD':JSON.stringify(marchandiseD),'marchandiseR':JSON.stringify(marchandiseR),'kilometrage':JSON.stringify(kilometrage),'tour':JSON.stringify(tour),'tonnage':JSON.stringify(tonnage),'rjFR':JSON.stringify(rjFR),'rjFT':JSON.stringify(rjFT),'rjP':JSON.stringify(rjP)},
      success: function(data){
      	if ($.trim(data) == "Insertion parfaite de la demande") {
		      		$(".chargementPrime1").fadeOut();
		      	 $(document).Toasts('create', {
		        class: 'bg-success', 
		        title: 'Success',
		        subtitle: 'Alert',
		        body: data
		      }) 
			  
			  $(".contentLignes").empty();
			 
		      	 
		      $(".po").val("");
		//	  $(".nbreLigne").val("0");
			  
			 
			  
			     nouveauCode();
		      	 $('#example1').DataTable().destroy();
		      	 afficheAllDemande("#exemple1");
				 
				 
				 
		      	}else if ($.trim(data) == "Modification parfaite de la demande") {
		      		$(".chargementPrime1").fadeOut();
		      	 $(document).Toasts('create', {
		        class: 'bg-success', 
		        title: 'Success',
		        subtitle: 'Alert',
		        body: data
		      }) 


				$('#example1').DataTable().destroy();
		      	 afficheAllDemande("#exemple1");

			 $(".po").val("");
			  $(".nbreLigne").val("0");
			  
			  $(".contentLignes").empty();
			  
			  nouveauCode();
			  
			  $(".btnAnnulerModif").fadeIn();
			 $(".btnModif").fadeOut();
			 
			 if($(".compte").val()=='SUPERVISEUR' || $(".compte").val()=='nathan' )   {
					
		  
                        }
  
		      	} else{
		      		alert(data);
		      	$(".chargementPrime1").fadeOut();
		      	  $(document).Toasts('create', {
		        class: 'bg-danger', 
		        title: 'Erreur de connexion',
		        subtitle: 'Alert',
		        body:data
		      })	

		      	}
		      	
		      },
		       error:function(data){
		       	$(".chargementPrime1").fadeOut();
		          $(document).Toasts('create', {
		        class: 'bg-danger', 
		        title: 'Erreur de connexion',
		        subtitle: 'Alert',
		        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
		      })   
		          $(".chargementCarteGrise").fadeOut();
		       }
       });

	
}


function addDemandeN(status){

	
	date_demande = $(".date_demande").val();
	
	
	po = $(".po").val();
	
	operation = $(".operation").val();
	
	etat_demande = $(".etat_demande").val();
	
	etat_demande1 = $(".etat_demande1").val();
	
	nbreLigne = $(".nbreLigne").val();
	
	delegue = [];
	camion1 = [];
	immatriculation1 = [];
	client = [];
	destinationM = [];
	
	litrage = [];
		
	kilometrage = [];
	
	tour = [];
	
	date_demandeN = [];
	
	fournisseur = [];
	
	rjG = [];
	
	con = [];
	
	typeA = [];
	
	id_demande = [];
	
	if ($('.rj').prop('checked')) {



      rj='oui';



    }else{



      rj = 'non';



    }
	
	if ($('.rj1').prop('checked')) {



      rj1='oui';



    }else{



      rj1 = 'non';



    }
	
	
	if ($('.rj2').prop('checked')) {


      rj='oui';

      rj2='oui';


    }else{
		
	   rj2 = 'non';

    }
	
	
	
	i=1;
	
if  (date_demande == ""){
		$('.date_demande').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
			 return;
	}else if (etat_demande == ""){
		$('.etat_demande').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
			 return;
	}else if (etat_demande1 == ""){
		$('.etat_demande1').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
			 return;
	}else if (po == "") {
		$('.po').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
			 return;
	}else if (operation == "") {
		$('.operation').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
			 return;
	}else {
		$('.date_demande').css("border","1px solid #ced4da");
		$('.date_demande1').css("border","1px solid #ced4da");
		$('.etat_demande').css("border","1px solid #ced4da");
		$('.po').css("border","1px solid #ced4da");
		$('.operation').css("border","1px solid #ced4da");
		
}
		do{
			
		if ($('.delegue'+i).val() == "") {
		$('.delegue'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
        return;				
		}else if ($('.camion1'+i).val() == "") {
		$('.camion1'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.immatriculation1'+i).val() == "") {
		$('.immatriculation1'+i).css("border","red 2px solid");
		     toastr.error("Veuillez remplir tous les Champs");
			  return;
		}else if ($('.client'+i).val() == "") {
		$('.client'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.destinationM'+i).val() == "") {
		$('.destinationM'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.litrage'+i).val() == "") {
		$('.litrage'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.kilometrage'+i).val() == "") {
		$('.kilometrage'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.tour'+i).val() == "") {
		$('.tour'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else{
		
		$('.delegue'+i).css("border","1px solid #ced4da");
		
		$('.camion1'+i).css("border","1px solid #ced4da");
		$('.immatriculation1'+i).css("border","1px solid #ced4da");
		$('.client'+i).css("border","1px solid #ced4da");
		$('.destinationM'+i).css("border","1px solid #ced4da");
		$('.litrage'+i).css("border","1px solid #ced4da");
		$('.kilometrage'+i).css("border","1px solid #ced4da");
		$('.tour'+i).css("border","1px solid #ced4da");
		
		
		
		delegue[i] = $('.delegue'+i).val();
		
		camion1[i] = $('.camion1'+i).val();
		immatriculation1[i] = $('.immatriculation1'+i).val();
		kilometrage[i] = $('.kilometrage'+i).val();
		client[i] = $('.client'+i).val();
		destinationM[i] = $('.destinationM'+i).val();	
		litrage[i] = $('.litrage'+i).val();
		id_demande[i] = $('.id_demande'+i).val();
		typeA[i] = $('.typeA'+i).val();
		tour[i] = $('.tour'+i).val();
		fournisseur[i] = $('.fournisseur'+i).val();
		date_demandeN[i] = $('.date_demandeN'+i).val();

	
	
	
	
    if ($('.con'+i).prop('checked')) {

      con[i]='oui';
	  
	 

    }else{

     con[i]='non';

    }
	
	if ($('.rjG'+i).prop('checked')) {

      rjG[i]='oui';
	  
	  litrage[i]='0';
	  
	  con[i]='non';

    }else{

     rjG[i]='non';

    }
		
		
		}
		i++;
		}while(i<=nbreLigne)
			
		
//	if (delegue.length >nbreLigne && camion1.length>nbreLigne && client.length>nbreLigne && destination1.length>nbreLigne && marchandiseD.length>nbreLigne) {
$(".chargementPrime1").fadeIn();
// alert(status);
	   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addDemandeN",
      data:{"status":status,"etat_demande":etat_demande,"etat_demande1":etat_demande1,"po":po,"operation":operation,"date_demande":date_demande,"nbreLignes":nbreLigne,"rj":rj,"rj1":rj1,"rj2":rj2,'id_demande':JSON.stringify(id_demande),'delegue':JSON.stringify(delegue),'camion1':JSON.stringify(camion1),'immatriculation1':JSON.stringify(immatriculation1),'client':JSON.stringify(client),'destinationM':JSON.stringify(destinationM),'fournisseur':JSON.stringify(fournisseur),'date_demandeN':JSON.stringify(date_demandeN),'typeA':JSON.stringify(typeA),'litrage':JSON.stringify(litrage),'kilometrage':JSON.stringify(kilometrage),'tour':JSON.stringify(tour),'rjG':JSON.stringify(rjG),'con':JSON.stringify(con)},
      success: function(data){
      	if ($.trim(data) == "Insertion parfaite de la demande Navette") {
		      		$(".chargementPrime1").fadeOut();
		      	 $(document).Toasts('create', {
		        class: 'bg-success', 
		        title: 'Success',
		        subtitle: 'Alert',
		        body: data
		      }) 
			  
			  $(".contentLignes").empty();
			 
		      	 
		      $(".po").val("");
		//	  $(".nbreLigne").val("0");
			  
			 
			  
			     nouveauCodeN();
		      	 $('#example1').DataTable().destroy();
		      	 afficheAllDemandeN("#exemple1");
				 
				 
				 
		      	}else if ($.trim(data) == "Modification parfaite de la demande Navette") {
		      		$(".chargementPrime1").fadeOut();
		      	 $(document).Toasts('create', {
		        class: 'bg-success', 
		        title: 'Success',
		        subtitle: 'Alert',
		        body: data
		      }) 


				$('#example1').DataTable().destroy();
		      	 afficheAllDemandeN("#exemple1");

			 $(".po").val("");
			  $(".nbreLigne").val("0");
			  
			  $(".contentLignes").empty();
			  
			  nouveauCodeN();
			  
			  $(".btnAnnulerModif").fadeIn();
			 $(".btnModif").fadeOut();
			 
			 if($(".compte").val()=='SUPERVISEUR' || $(".compte").val()=='nathan' )   {
					
	  
                        }
  
		      	} else{
		      		alert(data);
		      	$(".chargementPrime1").fadeOut();
		      	  $(document).Toasts('create', {
		        class: 'bg-danger', 
		        title: 'Erreur de connexion',
		        subtitle: 'Alert',
		        body:data
		      })	

		      	}
		      	
		      },
		       error:function(data){
		       	$(".chargementPrime1").fadeOut();
		          $(document).Toasts('create', {
		        class: 'bg-danger', 
		        title: 'Erreur de connexion',
		        subtitle: 'Alert',
		        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
		      })   
		          $(".chargementCarteGrise").fadeOut();
		       }
       });

	
}


function addDemandeE(status){

	
	date_demande = $(".date_demande").val();
	
	
	po = $(".po").val();
	
	operation = $(".operation").val();
	
	etat_demande = $(".etat_demande").val();
	
	etat_demande1 = $(".etat_demande1").val();
	
	nbreLigne = $(".nbreLigne").val();
	
	
	
	
	if ($('.rj').prop('checked')) {



      rj='oui';



    }else{



      rj = 'non';



    }
	
	if ($('.rj1').prop('checked')) {



      rj1='oui';



    }else{



      rj1 = 'non';



    }
	
	
	if ($('.rj2').prop('checked')) {


      rj='oui';

      rj2='oui';


    }else{
		
	   rj2 = 'non';

    }
	
	camion1 = [];
	
	camion1 = [];
	immatriculation1 = [];
	
	
	litrage = [];
		
	kilometrage = [];
	
	
	
	date_demandeN = [];
	
	fournisseur = [];
	
	rjG = [];
	
	con = [];
	
	typeA = [];
	
	id_demande = [];
	
	
	
	i=1;
	
if  (date_demande == ""){
		$('.date_demande').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
			 return;
	}else if (etat_demande == ""){
		$('.etat_demande').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
			 return;
	}else if (etat_demande1 == ""){
		$('.etat_demande1').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
			 return;
	}else if (po == "") {
		$('.po').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
			 return;
	}else if (operation == "") {
		$('.operation').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
			 return;
	}else {
		$('.date_demande').css("border","1px solid #ced4da");
		$('.etat_demande1').css("border","1px solid #ced4da");
		$('.etat_demande').css("border","1px solid #ced4da");
		$('.po').css("border","1px solid #ced4da");
		$('.operation').css("border","1px solid #ced4da");
		
}
		do{
			
		 if ($('.camion1'+i).val() == "") {
		$('.camion1'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.immatriculation1'+i).val() == "") {
		$('.immatriculation1'+i).css("border","red 2px solid");
		     toastr.error("Veuillez remplir tous les Champs");
			  return;
		}else if ($('.litrage'+i).val() == "") {
		$('.litrage'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.kilometrage'+i).val() == "") {
		$('.kilometrage'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else{
		
		
		
		$('.camion1'+i).css("border","1px solid #ced4da");
		$('.immatriculation1'+i).css("border","1px solid #ced4da");
		
		$('.litrage'+i).css("border","1px solid #ced4da");
		$('.kilometrage'+i).css("border","1px solid #ced4da");
		
		
		
		
		
		camion1[i] = $('.camion1'+i).val();
		immatriculation1[i] = $('.immatriculation1'+i).val();
		kilometrage[i] = $('.kilometrage'+i).val();
		
		litrage[i] = $('.litrage'+i).val();
		id_demande[i] = $('.id_demande'+i).val();
		typeA[i] = $('.typeA'+i).val();
		
		fournisseur[i] = $('.fournisseur'+i).val();
		date_demandeN[i] = $('.date_demandeN'+i).val();

	
	
	
	
    if ($('.con'+i).prop('checked')) {

      con[i]='oui';
	  
	 

    }else{

     con[i]='non';

    }
	
	if ($('.rjG'+i).prop('checked')) {

      rjG[i]='oui';
	  
	  litrage[i]='0';
	  
	  con[i]='non';

    }else{

     rjG[i]='non';

    }
		
		
		}
		i++;
		}while(i<=nbreLigne)
			
		
//	if (delegue.length >nbreLigne && camion1.length>nbreLigne && client.length>nbreLigne && destination1.length>nbreLigne && marchandiseD.length>nbreLigne) {
$(".chargementPrime1").fadeIn();
// alert(status);
	   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addDemandeE",
      data:{"status":status,"etat_demande":etat_demande,"etat_demande1":etat_demande1,"po":po,"operation":operation,"date_demande":date_demande,"nbreLignes":nbreLigne,"rj":rj,"rj1":rj1,"rj2":rj2,'id_demande':JSON.stringify(id_demande),'camion1':JSON.stringify(camion1),'immatriculation1':JSON.stringify(immatriculation1),'fournisseur':JSON.stringify(fournisseur),'date_demandeN':JSON.stringify(date_demandeN),'typeA':JSON.stringify(typeA),'litrage':JSON.stringify(litrage),'kilometrage':JSON.stringify(kilometrage),'rjG':JSON.stringify(rjG),'con':JSON.stringify(con)},
      success: function(data){
      	if ($.trim(data) == "Insertion parfaite de la demande Navette") {
		      		$(".chargementPrime1").fadeOut();
		      	 $(document).Toasts('create', {
		        class: 'bg-success', 
		        title: 'Success',
		        subtitle: 'Alert',
		        body: data
		      }) 
			  
			  $(".contentLignes").empty();
			 
		      	 
		      $(".po").val("");
		//	  $(".nbreLigne").val("0");
			  
			 
			  
			     nouveauCodeE();
		      	 $('#example1').DataTable().destroy();
		      	 afficheAllDemandeE("#exemple1");
				 
				 
				 
		      	}else if ($.trim(data) == "Modification parfaite de la demande Navette") {
		      		$(".chargementPrime1").fadeOut();
		      	 $(document).Toasts('create', {
		        class: 'bg-success', 
		        title: 'Success',
		        subtitle: 'Alert',
		        body: data
		      }) 


				$('#example1').DataTable().destroy();
		      	 afficheAllDemandeE("#exemple1");

			 $(".po").val("");
			  $(".nbreLigne").val("0");
			  
			  $(".contentLignes").empty();
			  
			  nouveauCodeE();
			  
			  $(".btnAnnulerModif").fadeIn();
			 $(".btnModif").fadeOut();
			 
			
		      	} else{
		      		alert(data);
		      	$(".chargementPrime1").fadeOut();
		      	  $(document).Toasts('create', {
		        class: 'bg-danger', 
		        title: 'Erreur de connexion',
		        subtitle: 'Alert',
		        body:data
		      })	

		      	}
		      	
		      },
		       error:function(data){
		       	$(".chargementPrime1").fadeOut();
		          $(document).Toasts('create', {
		        class: 'bg-danger', 
		        title: 'Erreur de connexion',
		        subtitle: 'Alert',
		        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
		      })   
		          $(".chargementCarteGrise").fadeOut();
		       }
       });

	
}





function addDemandeNA(status){

	
	date_demande = $(".date_demande").val();
	
	
	po = $(".po").val();
	
	operation = $(".operation").val();
	
	etat_demande = $(".etat_demande").val();
	
	etat_demande1 = $(".etat_demande1").val();
	
	nbreLigne = $(".nbreLigne").val();
	
	delegue = [];
	camion1 = [];
	immatriculation1 = [];
	client = [];
	destinationM = [];
	
	litrage = [];
		
	kilometrage = [];
	
	tour = [];
	
	date_demandeN = [];
	
	fournisseur = [];
	
	rjG = [];
	
	con = [];
	
	typeA = [];
	
	id_demande = [];
	
	if ($('.rj').prop('checked')) {



      rj='oui';



    }else{



      rj = 'non';



    }
	
	if ($('.rj1').prop('checked')) {



      rj1='oui';



    }else{



      rj1 = 'non';



    }
	
	
	if ($('.rj2').prop('checked')) {


      rj='oui';

      rj2='oui';


    }else{
		
	   rj2 = 'non';

    }
	
	
	
	i=1;
	
if  (date_demande == ""){
		$('.date_demande').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
			 return;
	}else if (etat_demande == ""){
		$('.etat_demande').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
			 return;
	}else if (etat_demande1 == ""){
		$('.etat_demande1').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
			 return;
	}else if (po == "") {
		$('.po').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
			 return;
	}else if (operation == "") {
		$('.operation').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
			 return;
	}else {
		$('.date_demande').css("border","1px solid #ced4da");
		$('.date_demande1').css("border","1px solid #ced4da");
		$('.etat_demande').css("border","1px solid #ced4da");
		$('.po').css("border","1px solid #ced4da");
		$('.operation').css("border","1px solid #ced4da");
		
}
		do{
			
		if ($('.delegue'+i).val() == "") {
		$('.delegue'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
        return;				
		}else if ($('.camion1'+i).val() == "") {
		$('.camion1'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.immatriculation1'+i).val() == "") {
		$('.immatriculation1'+i).css("border","red 2px solid");
		     toastr.error("Veuillez remplir tous les Champs");
			  return;
		}else if ($('.client'+i).val() == "") {
		$('.client'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.destinationM'+i).val() == "") {
		$('.destinationM'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.litrage'+i).val() == "") {
		$('.litrage'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.kilometrage'+i).val() == "") {
		$('.kilometrage'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.tour'+i).val() == "") {
		$('.tour'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else{
		
		$('.delegue'+i).css("border","1px solid #ced4da");
		
		$('.camion1'+i).css("border","1px solid #ced4da");
		$('.immatriculation1'+i).css("border","1px solid #ced4da");
		$('.client'+i).css("border","1px solid #ced4da");
		$('.destinationM'+i).css("border","1px solid #ced4da");
		$('.litrage'+i).css("border","1px solid #ced4da");
		$('.kilometrage'+i).css("border","1px solid #ced4da");
		$('.tour'+i).css("border","1px solid #ced4da");
		
		
		
		delegue[i] = $('.delegue'+i).val();
		
		camion1[i] = $('.camion1'+i).val();
		immatriculation1[i] = $('.immatriculation1'+i).val();
		kilometrage[i] = $('.kilometrage'+i).val();
		client[i] = $('.client'+i).val();
		destinationM[i] = $('.destinationM'+i).val();	
		litrage[i] = $('.litrage'+i).val();
		id_demande[i] = $('.id_demande'+i).val();
		typeA[i] = $('.typeA'+i).val();
		tour[i] = $('.tour'+i).val();
		fournisseur[i] = $('.fournisseur'+i).val();
		date_demandeN[i] = $('.date_demandeN'+i).val();

	
	
	
	
    if ($('.con'+i).prop('checked')) {

      con[i]='oui';
	  
	 

    }else{

     con[i]='non';

    }
	
	if ($('.rjG'+i).prop('checked')) {

      rjG[i]='oui';
	  
	  litrage[i]='0';
	  
	  con[i]='non';

    }else{

     rjG[i]='non';

    }
		
		
		}
		i++;
		}while(i<=nbreLigne)
			
		
//	if (delegue.length >nbreLigne && camion1.length>nbreLigne && client.length>nbreLigne && destination1.length>nbreLigne && marchandiseD.length>nbreLigne) {
$(".chargementPrime1").fadeIn();
// alert(status);
	   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addDemandeNA",
      data:{"status":status,"etat_demande":etat_demande,"etat_demande1":etat_demande1,"po":po,"operation":operation,"date_demande":date_demande,"nbreLignes":nbreLigne,"rj":rj,"rj1":rj1,"rj2":rj2,'id_demande':JSON.stringify(id_demande),'delegue':JSON.stringify(delegue),'camion1':JSON.stringify(camion1),'immatriculation1':JSON.stringify(immatriculation1),'client':JSON.stringify(client),'destinationM':JSON.stringify(destinationM),'fournisseur':JSON.stringify(fournisseur),'date_demandeN':JSON.stringify(date_demandeN),'typeA':JSON.stringify(typeA),'litrage':JSON.stringify(litrage),'kilometrage':JSON.stringify(kilometrage),'tour':JSON.stringify(tour),'rjG':JSON.stringify(rjG),'con':JSON.stringify(con)},
      success: function(data){
      	if ($.trim(data) == "Insertion parfaite de la demande Navette") {
		      		$(".chargementPrime1").fadeOut();
		      	 $(document).Toasts('create', {
		        class: 'bg-success', 
		        title: 'Success',
		        subtitle: 'Alert',
		        body: data
		      }) 
			  
			  $(".contentLignes").empty();
			 
		      	 
		      $(".po").val("");
		//	  $(".nbreLigne").val("0");
			  
			 
			  
			     nouveauCodeN();
		      	 $('#example1').DataTable().destroy();
		      	 afficheAllDemandeNA("#exemple1");
				 
				 
				 
		      	}else if ($.trim(data) == "Modification parfaite de la demande Navette") {
		      		$(".chargementPrime1").fadeOut();
		      	 $(document).Toasts('create', {
		        class: 'bg-success', 
		        title: 'Success',
		        subtitle: 'Alert',
		        body: data
		      }) 


				$('#example1').DataTable().destroy();
		      	 afficheAllDemandeNA("#exemple1");

			 $(".po").val("");
			  $(".nbreLigne").val("0");
			  
			  $(".contentLignes").empty();
			  
			  nouveauCodeN();
			  
			  $(".btnAnnulerModif").fadeIn();
			 $(".btnModif").fadeOut();
			 
			 if($(".compte").val()=='SUPERVISEUR' || $(".compte").val()=='nathan' )   {
					
	  
                        }
  
		      	} else{
		      		alert(data);
		      	$(".chargementPrime1").fadeOut();
		      	  $(document).Toasts('create', {
		        class: 'bg-danger', 
		        title: 'Erreur de connexion',
		        subtitle: 'Alert',
		        body:data
		      })	

		      	}
		      	
		      },
		       error:function(data){
		       	$(".chargementPrime1").fadeOut();
		          $(document).Toasts('create', {
		        class: 'bg-danger', 
		        title: 'Erreur de connexion',
		        subtitle: 'Alert',
		        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
		      })   
		          $(".chargementCarteGrise").fadeOut();
		       }
       });

	
}

function addDemandeST(status){

	
	
	nbreLigne = $(".nbreLigne").val();
	
	delegue = [];
	camion1 = [];
	immatriculation1 = [];
	date_demande = [];
	kilometrage = [];
	commentaire = [];
	
	tour = [];
	
	
	rjG = [];
	
	con = [];
	
	typeA = [];
	
	id_demande = [];
	
	
	
	
	
	i=1;
	

		do{
			
		if ($('.delegue'+i).val() == "") {
		$('.delegue'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
        return;				
		}else if ($('.camion1'+i).val() == "") {
		$('.camion1'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.immatriculation1'+i).val() == "") {
		$('.immatriculation1'+i).css("border","red 2px solid");
		     toastr.error("Veuillez remplir tous les Champs");
			  return;
		}else if ($('.kilometrage'+i).val() == "") {
		$('.kilometrage'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.commentaire'+i).val() == "") {
		$('.commentaire'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.tour'+i).val() == "") {
		$('.tour'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else{
		
		$('.delegue'+i).css("border","1px solid #ced4da");
		
		$('.camion1'+i).css("border","1px solid #ced4da");
		$('.immatriculation1'+i).css("border","1px solid #ced4da");
		
		$('.kilometrage'+i).css("border","1px solid #ced4da");
		$('.commentaire'+i).css("border","1px solid #ced4da");
		$('.tour'+i).css("border","1px solid #ced4da");
		
		
		
		delegue[i] = $('.delegue'+i).val();
		date_demande[i] = $('.date_demande'+i).val();
		camion1[i] = $('.camion1'+i).val();
		immatriculation1[i] = $('.immatriculation1'+i).val();
		kilometrage[i] = $('.kilometrage'+i).val();
		commentaire[i] = $('.commentaire'+i).val();
		
		id_demande[i] = $('.id_demande'+i).val();
		typeA[i] = $('.typeA'+i).val();
		tour[i] = $('.tour'+i).val();
		
		}
		i++;
		}while(i<=nbreLigne)
			
		
//	if (delegue.length >nbreLigne && camion1.length>nbreLigne && client.length>nbreLigne && destination1.length>nbreLigne && marchandiseD.length>nbreLigne) {
$(".chargementPrime1").fadeIn();
// alert(status);
	   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addDemandeST",
      data:{"status":status,"nbreLignes":nbreLigne,'id_demande':JSON.stringify(id_demande),'delegue':JSON.stringify(delegue),'date_demande':JSON.stringify(date_demande),'camion1':JSON.stringify(camion1),'immatriculation1':JSON.stringify(immatriculation1),'typeA':JSON.stringify(typeA),'kilometrage':JSON.stringify(kilometrage), 'commentaire':JSON.stringify(commentaire), 'tour':JSON.stringify(tour)},
      success: function(data){
      	if ($.trim(data) == "Insertion parfaite du stock camion") {
		      		$(".chargementPrime1").fadeOut();
		      	 $(document).Toasts('create', {
		        class: 'bg-success', 
		        title: 'Success',
		        subtitle: 'Alert',
		        body: data
		      }) 
			  
			  $(".nbreLigne").val("0");
			  
			  $(".contentLignes").empty();
		      	 
		   
			  
			    
		      	 $('#example1').DataTable().destroy();
		      	 afficheAllDemandeST("#exemple1");
				 
				 
				 
		      	}else if ($.trim(data) == "Modification parfaite du stock vehicule") {
		      		$(".chargementPrime1").fadeOut();
		      	 $(document).Toasts('create', {
		        class: 'bg-success', 
		        title: 'Success',
		        subtitle: 'Alert',
		        body: data
		      }) 


				$('#example1').DataTable().destroy();
		      	 afficheAllDemandeST("#exemple1");

			
			  $(".nbreLigne").val("0");
			  
			  $(".contentLignes").empty();
			  
			
			  
			  $(".btnAnnulerModif").fadeIn();
			 $(".btnModif").fadeOut();
		
                       
  
		      	} else{
		      		alert(data);
		      	$(".chargementPrime1").fadeOut();
		      	  $(document).Toasts('create', {
		        class: 'bg-danger', 
		        title: 'Erreur de connexion',
		        subtitle: 'Alert',
		        body:data
		      })	

		      	}
		      	
		      },
		       error:function(data){
		       	$(".chargementPrime1").fadeOut();
		          $(document).Toasts('create', {
		        class: 'bg-danger', 
		        title: 'Erreur de connexion',
		        subtitle: 'Alert',
		        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
		      })   
		          $(".chargementCarteGrise").fadeOut();
		       }
       });

	
}





function totalCumLigne(){
	
	i=1;
	
	totalLigne1 = 0;
	
	nbreLigne = $(".nbreLigne").val();
	
	
do{
		
		totalLigne1 = totalLigne1 + parseInt($('.route'+i).val()*$('.tour'+i).val()) + parseInt($('.retour'+i).val()*$('.tour'+i).val()) + parseInt($('.pont'+i).val());
	
		i++;
		
}while(i<=nbreLigne)	
		
		$(".totalLigne").val(totalLigne1);

}	


function totalCumLigneN(){
	
	i=1;
	
	totalLigne1 = 0;
	
	nbreLigne = $(".nbreLigne").val();
	
	
do{
		
		totalLigne1 =  totalLigne1 + parseInt($('.tour'+i).val()*$('.litrage'+i).val());
	
		i++;
		
}while(i<=nbreLigne)	
		
		$(".totalLigne").val(totalLigne1);

}





function totalCumLigneNL(litrage,tour,totalParLigne){
	
	
	
	totalLigne1 = 0;
	
		
		totalLigne1 =  parseInt($('.litrage'+i).val()*$('.tour'+i).val());
	
		$("totalParLigne").val(totalLigne1)	
		
	

}

	


function totalLigne(route,retour,pont,tour,totalLigne){

totalLigne1=0;
 //totalLigne = parseInt($('.pont'+i).val())
 //totalLigne = parseInt(pont);
 
 totalLigne1= (parseInt(route) + parseInt(retour))* parseInt(tour) + parseInt(pont)
 
 $("."+totalLigne).val(totalLigne1);
 
}

function totalLigneGazoil(litrage,stock,complement,litrage1){

totalLigne1=0;
 
 totalLigne1= parseInt(litrage) - parseInt(stock) + parseInt(complement) 
 
 $("."+litrage1).val(totalLigne1);
 
}


function totalDifference(litrage1,stock,complement,litrage,difference){

totalLigne1=0;
 
 totalLigne1= parseInt(litrage1)-parseInt(litrage) + parseInt(stock) - parseInt(complement) 
 
 $("."+difference).val(totalLigne1);
 
}


function addDemandeG(status){

	
	date_demande = $(".date_demande").val();
	
	po = $(".po").val();
	
	etat_demande = $(".etat_demande").val();
	
	nbreLigne = $(".nbreLigne").val();
	
//	fournisseur = $(".fournisseur").val();
	
	if ($('.rj').prop('checked')) {

  rj='oui';

    }else{

      rj = 'non';

    }
	
	delegue = [];
	bl = [];
	camion1 = [];
	immatriculation1 = [];
	
	destinationM = [];
	litrageTH = [];
	litrageR = [];
	stock = [];
	difference = [];
	complement = [];
	detail = [];
	fournisseur = [];
	date_demande2 =[] ;
	rjG = [];
	
	con = [];
	
	type1 = [];
	id_demande = [];
	
			
		
		
	
	i=1;
	
if  (date_demande == ""){
		$('.date_demande').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
			 return;
	}else if (po == "") {
		$('.po').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
			 return;
	}else if (etat_demande == "") {
		$('.etat_demande').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
			 return;
	}else {
		$('.date_demande').css("border","1px solid #ced4da");
		
		$('.po').css("border","1px solid #ced4da");
		
//		$('.fournisseur').css("border","1px solid #ced4da");
		

		do{
			
		if ($('.delegue'+i).val() == "") {
		$('.delegue'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");	
				 return;
		}else if ($('.bl'+i).val() == "") {
		$('.bl'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.camion1'+i).val() == "") {
		$('.camion1'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.immatriculation1'+i).val() == "") {
		$('.immatriculation1'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.destination1'+i).val() == "") {
		$('.destinationM'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.fournisseur'+i).val() == "") {
		$('.fournisseur'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.litrageTH'+i).val() == "") {
		$('.litrageTH'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.litrageR'+i).val() == "") {
		$('.litrageR'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.stock'+i).val() == "") {
		$('.stock'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.complement'+i).val() == "") {
		$('.complement'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.difference'+i).val() == "") {
		$('.difference'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.detail'+i).val() == "") {
		$('.detail'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.date_demande2'+i).val() == "") {
		$('.date_demande2'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else{
		
		$('.delegue'+i).css("border","1px solid #ced4da");
		$('.bl'+i).css("border","1px solid #ced4da");
		$('.camion1'+i).css("border","1px solid #ced4da");
		$('.immatriculation1'+i).css("border","1px solid #ced4da");
		
		$('.destinationM'+i).css("border","1px solid #ced4da");
		$('.fournisseur'+i).css("border","1px solid #ced4da");
		
		$('.litrageTH'+i).css("border","1px solid #ced4da");
		$('.litrageR'+i).css("border","1px solid #ced4da");
		$('.stock'+i).css("border","1px solid #ced4da");
		
		$('.complement'+i).css("border","1px solid #ced4da");
		$('.detail'+i).css("border","1px solid #ced4da");
		$('.date_demande2'+i).css("border","1px solid #ced4da");
		
		delegue[i] = $('.delegue'+i).val();
		bl[i] = $('.bl'+i).val();
		
		camion1[i] = $('.camion1'+i).val();
		immatriculation1[i] = $('.immatriculation1'+i).val();
		
		destinationM[i] = $('.destinationM'+i).val();
		
		fournisseur[i] = $('.fournisseur'+i).val();
		
		litrageTH[i] = $('.litrageTH'+i).val();
		
		litrageR[i] = $('.litrageR'+i).val();
		
		stock[i] = $('.stock'+i).val();
		difference[i] = $('.difference'+i).val();
		
		id_demande[i] = $('.id_demande'+i).val();
		type1[i] = $('.type1'+i).val();
				
		complement[i] = $('.complement'+i).val();
		detail[i] = $('.detail'+i).val();
		
		date_demande2[i] = $('.date_demande2'+i).val();
	
	if ($('.rjG'+i).prop('checked')) {

      rjG[i]='oui';
	  
	  litrageTH[i]='0';
	  
	  litrageR[i] ='0';
	  
	  complement[i] = '0'

    }else{

      rjG[i] = 'non';

    }
	
	if ($('.con'+i).prop('checked')) {

      con[i]='oui';
	  
	 
    }else{

      con[i] = 'non';

    }
	
		
		}
		i++;
		}while(i<=nbreLigne)
	if (delegue.length >nbreLigne && camion1.length>nbreLigne && destinationM.length>nbreLigne && litrageTH.length>nbreLigne) {
$(".chargementPrime1").fadeIn();
// alert(status);
	   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addDemandeG",
      data:{"status":status,"po":po,"date_demande":date_demande,"etat_demande":date_demande,"nbreLignes":nbreLigne,"rj":rj,'id_demande':JSON.stringify(id_demande),'delegue':JSON.stringify(delegue),'bl':JSON.stringify(bl),'camion1':JSON.stringify(camion1),'immatriculation1':JSON.stringify(immatriculation1),'complement':JSON.stringify(complement),'destinationM':JSON.stringify(destinationM),'fournisseur':JSON.stringify(fournisseur),'litrageTH':JSON.stringify(litrageTH),'litrageR':JSON.stringify(litrageR),'stock':JSON.stringify(stock),'difference':JSON.stringify(difference),'detail':JSON.stringify(detail),'date_demande2':JSON.stringify(date_demande2),'type1':JSON.stringify(type1),'rjG':JSON.stringify(rjG),'con':JSON.stringify(con)},
      success: function(data){
      	if ($.trim(data) == "Insertion parfaite de la demande") {
		      		$(".chargementPrime1").fadeOut();
		      	 $(document).Toasts('create', {
		        class: 'bg-success', 
		        title: 'Success',
		        subtitle: 'Alert',
		        body: data
		      }) 
		      	 
		   $(".contentLignes").empty();
			 
		      	 
		      $(".po").val("");
			  $(".etat_demande").val("");
			  $(".nbreLigne").val("0");
		      	 $('#example1').DataTable().destroy();
		      	 afficheAllDemandeG("#exemple1");
		      	}else if ($.trim(data) == "Modification parfaite de la demande") {
		      		$(".chargementPrime1").fadeOut();
		      	 $(document).Toasts('create', {
		        class: 'bg-success', 
		        title: 'Success',
		        subtitle: 'Alert',
		        body: data
		      }) 


				$('#example1').DataTable().destroy();
		      	 afficheAllDemandeG("#exemple1");

		    
			 $(".contentLignes").empty();
			 
		      	 
		      $(".po").val("");
			    $(".etat_demande").val("");
			  $(".nbreLigne").val("0");
		      	} else{
		      		alert(data);
		      	$(".chargementPrime1").fadeOut();
		      	  $(document).Toasts('create', {
		        class: 'bg-danger', 
		        title: 'Erreur de connexion',
		        subtitle: 'Alert',
		        body:data
		      })	

		      	}
		      	
		      },
		       error:function(data){
		       	$(".chargementPrime1").fadeOut();
		          $(document).Toasts('create', {
		        class: 'bg-danger', 
		        title: 'Erreur de connexion',
		        subtitle: 'Alert',
		        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
		      })   
		          $(".chargementCarteGrise").fadeOut();
		       }
       });
	}else{
		$(".chargementPrime1").fadeOut();
		          $(document).Toasts('create', {
		        class: 'bg-danger', 
		        title: 'Erreur de connexion',
		        subtitle: 'Alert',
		        body: "Veuillez remplir votre commande"
		      })   
	}
	}
}


function nouveauCode(){
	   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getNouveauCode",
      data:{},
      success: function(data){
      	$(".po").val("");
      $(".po").val(data);
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

function nouveauCodeN(){
	   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getNouveauCodeN",
      data:{},
      success: function(data){
      	$(".po").val("");
      $(".po").val(data);
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

function nouveauCodeE(){
	   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getNouveauCodeE",
      data:{},
      success: function(data){
      	$(".po").val("");
      $(".po").val(data);
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

function getDetailDemmandePourModificationC(date_demande,po,etat_demande,etat_demande1,rj, rj1, rj2, ligne){

		
		$('.po').val(po);
		$('.date_demande').val(date_demande);
		$('.etat_demande').val(etat_demande);
		$('.etat_demande1').val(etat_demande1);
		$('.nbreLigne').val(ligne);
		
		
		if (rj == 'oui') {
      $('.rj').prop('checked',true);
    }else{
      $('.rj').prop('checked',false);
    }
	
	
	if (rj1 == 'oui') {
      $('.rj1').prop('checked',true);
    }else{
      $('.rj1').prop('checked',false);
    }
	
	
	if (rj2 == 'oui') {
      $('.rj2').prop('checked',true);
    }else{
      $('.rj2').prop('checked',false);
    }
		
		

  $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Alert',
        subtitle: 'Alert',
        body: 'Avant de confirmer toute Modification veuillez vous rassurer le N°(demande) est celui de cette demande'
      })   	

window.location = base_url+"/admin/controle_frais#details";
 $(".chargementPrime1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getListeDemmandePourModifC",
      data:{"po":po},
      success: function(data){
      	// alert(data);
        $(".contentLignes").empty();
        $(".contentLignes").append(data);
        $(".chargementPrime1").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          // alert(data.responseText);
          $(".chargementPrime1").fadeOut();
       }
       });
    $(".btnAnnulerModif").fadeIn();
  $(".btnModif").fadeIn();
 
}




function getDetailDemmandePourModification(date_demande,po,etat_demande,etat_demande1,rj, rj1, rj2, ligne){

		
		$('.po').val(po);
		$('.date_demande').val(date_demande);
		$('.etat_demande').val(etat_demande);
		$('.etat_demande1').val(etat_demande1);
		$('.nbreLigne').val(ligne);
		
		
		if (rj == 'oui') {
      $('.rj').prop('checked',true);
    }else{
      $('.rj').prop('checked',false);
    }
	
	
	if (rj1 == 'oui') {
      $('.rj1').prop('checked',true);
    }else{
      $('.rj1').prop('checked',false);
    }
	
	
	if (rj2 == 'oui') {
      $('.rj2').prop('checked',true);
    }else{
      $('.rj2').prop('checked',false);
    }
		
		

  $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Alert',
        subtitle: 'Alert',
        body: 'Avant de confirmer toute Modification veuillez vous rassurer le N°(demande) est celui de cette demande'
      })   	

window.location = base_url+"/admin/demande_frais#details";
 $(".chargementPrime1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getListeDemmandePourModif",
      data:{"po":po},
      success: function(data){
      	// alert(data);
        $(".contentLignes").empty();
        $(".contentLignes").append(data);
        $(".chargementPrime1").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          // alert(data.responseText);
          $(".chargementPrime1").fadeOut();
       }
       });
    $(".btnAnnulerModif").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAddClient").fadeOut();
}

function getDetailDemmandePourModificationN(date_demande,po,operation,etat_demande,etat_demande1,rj, rj1, rj2, ligne){

		
		$('.po').val(po);
		$('.operation').val(operation);
		$('.date_demande').val(date_demande);
		$('.etat_demande').val(etat_demande);
		$('.etat_demande1').val(etat_demande1);
		$('.nbreLigne').val(ligne);
		
		
		if (rj == 'oui') {
      $('.rj').prop('checked',true);
    }else{
      $('.rj').prop('checked',false);
    }
	
	
	if (rj1 == 'oui') {
      $('.rj1').prop('checked',true);
    }else{
      $('.rj1').prop('checked',false);
    }
	
	
	if (rj2 == 'oui') {
      $('.rj2').prop('checked',true);
    }else{
      $('.rj2').prop('checked',false);
    }
		
		

    	

window.location = base_url+"/admin/demande_navette#details";
 $(".chargementPrime1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getListeDemmandePourModifN",
      data:{"po":po},
      success: function(data){
      	// alert(data);
        $(".contentLignes").empty();
        $(".contentLignes").append(data);
        $(".chargementPrime1").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          // alert(data.responseText);
          $(".chargementPrime1").fadeOut();
       }
       });
    $(".btnAnnulerModif").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAddClient").fadeOut();
}

function getDetailDemmandePourModificationE(date_demande,po,operation,etat_demande,etat_demande1,rj, rj1, rj2, ligne){

		
		$('.po').val(po);
		$('.operation').val(operation);
		$('.date_demande').val(date_demande);
		$('.etat_demande').val(etat_demande);
		$('.etat_demande1').val(etat_demande1);
		$('.nbreLigne').val(ligne);
		
		
		if (rj == 'oui') {
      $('.rj').prop('checked',true);
    }else{
      $('.rj').prop('checked',false);
    }
	
	
	if (rj1 == 'oui') {
      $('.rj1').prop('checked',true);
    }else{
      $('.rj1').prop('checked',false);
    }
	
	
	if (rj2 == 'oui') {
      $('.rj2').prop('checked',true);
    }else{
      $('.rj2').prop('checked',false);
    }
		
		

    	

window.location = base_url+"/admin/demande_engin#details";
 $(".chargementPrime1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getListeDemmandePourModifE",
      data:{"po":po},
      success: function(data){
      	// alert(data);
        $(".contentLignes").empty();
        $(".contentLignes").append(data);
        $(".chargementPrime1").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          // alert(data.responseText);
          $(".chargementPrime1").fadeOut();
       }
       });
    $(".btnAnnulerModif").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAddClient").fadeOut();
}


function getDetailDemmandePourModificationNA(date_demande,po,operation,etat_demande,etat_demande1,rj, rj1, rj2, ligne){

		
		$('.po').val(po);
		$('.operation').val(operation);
		$('.date_demande').val(date_demande);
		$('.etat_demande').val(etat_demande);
		$('.etat_demande1').val(etat_demande1);
		$('.nbreLigne').val(ligne);
		
		
		if (rj == 'oui') {
      $('.rj').prop('checked',true);
    }else{
      $('.rj').prop('checked',false);
    }
	
	
	if (rj1 == 'oui') {
      $('.rj1').prop('checked',true);
    }else{
      $('.rj1').prop('checked',false);
    }
	
	
	if (rj2 == 'oui') {
      $('.rj2').prop('checked',true);
    }else{
      $('.rj2').prop('checked',false);
    }
		
		

    	

window.location = base_url+"/admin/demande_navette_pouzz#details";
 $(".chargementPrime1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getListeDemmandePourModifNA",
      data:{"po":po},
      success: function(data){
      	// alert(data);
        $(".contentLignes").empty();
        $(".contentLignes").append(data);
        $(".chargementPrime1").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          // alert(data.responseText);
          $(".chargementPrime1").fadeOut();
       }
       });
    $(".btnAnnulerModif").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAddClient").fadeOut();
}

function getDetailDemmandePourModificationST(id_demande, date_demande,vehicule, matricule, litrage,litrageP,commentaire,ligne){

		
		$('.po').val(po);
		$('.vehicule').val(vehicule);
		$('.date_demande').val(date_demande);
		$('.matricule').val(matricule);
		$('.litrage').val(litrage);
		$('.nbreLigne').val(ligne);
		$('.id_demande').val(id_demande);
		
		
		if (rj == 'oui') {
      $('.rj').prop('checked',true);
    }else{
      $('.rj').prop('checked',false);
    }
	
	
	if (rj1 == 'oui') {
      $('.rj1').prop('checked',true);
    }else{
      $('.rj1').prop('checked',false);
    }
	
	
	if (rj2 == 'oui') {
      $('.rj2').prop('checked',true);
    }else{
      $('.rj2').prop('checked',false);
    }
		
		

    	

window.location = base_url+"/admin/stock_vehicule#details";
 $(".chargementPrime1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getListeDemmandePourModifST",
      data:{"po":po},
      success: function(data){
      	// alert(data);
        $(".contentLignes").empty();
        $(".contentLignes").append(data);
        $(".chargementPrime1").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          // alert(data.responseText);
          $(".chargementPrime1").fadeOut();
       }
       });
    $(".btnAnnulerModif").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAddClient").fadeOut();
}




function getDetailDemmandePourModificationG(date_demande,etat_demande,rj,po,ligne, fournisseur){

		
		$('.po').val(po);
		$('.date_demande').val(date_demande);
		$('.etat_demande').val(etat_demande);
		
		$('.nbreLigne').val(ligne);
		
		$('.fournisseur').val(fournisseur);
		
	
		
		
		if (rj == 'oui') {
      $('.rj').prop('checked',true);
    }else{
      $('.rj').prop('checked',false);
    }
			

 	

window.location = base_url+"/admin/demande_gazoil#details";
 $(".chargementPrime1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getListeDemmandePourModifG",
      data:{"po":po,"fournisseur":fournisseur},
      success: function(data){
      	// alert(data);
        $(".contentLignes").empty();
        $(".contentLignes").append(data);
        $(".chargementPrime1").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          // alert(data.responseText);
          $(".chargementPrime1").fadeOut();
       }
       });
    $(".btnAnnulerModif").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAddClient").fadeOut();
}


function detailCommande(po,fournisseur,date_com,date_crea,etat_exp,etat_recep,montant){
	$(".po2").empty();
	$(".po2").append(po+'<br/><br/>');
	$(".fournisseur").empty();
	$(".fournisseur").append(fournisseur);
	$(".date_commande2").empty();
	$(".date_commande2").append(date_com);
	$(".date_creation2").empty();
	$(".date_creation2").append(date_crea);
	$(".etat_expedition2").empty();
	$(".etat_expedition2").append(etat_exp);
	$(".etat_reception2").empty();
	$(".etat_reception2").append(etat_recep);
	$(".montant2").empty();
	$(".montant2").append('<br/><br/><br/>'+montant);
	$(".chargementPrime2").fadeIn();
	window.location = base_url+"/admin/commande#contentDetailCommande2";
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commande/getDetailCommande",
      data:{"po":po},
      success: function(data){

        $(".contentDetailCommande2").empty();
        $(".contentDetailCommande2").append(data);
        $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="4" style="text-align : right; border:none; font-weight:12px; color:red; border-top:2px solid black;"></td><td colspan="2" style="text-align : right; border:none; font-weight:12px; color:red;border-top:2px solid black;">Total groupe: </td><td colspan="2" style="text-align : left; border:none; font-weight:12px; color:red;border-top:2px solid black;"> '+montant+'</td></tr>');
        $(".chargementPrime2").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime2").fadeOut();
       }
       });
}


function detailDemande(po,delegue,date_com,etat_exp,etat_exp1,montant,montant1,montant2,montant3,montant4,signatureDAF,signatureDGT,compteur){
	
//	var imagejavascript = document.createElement("img");
//	imagejavascript.src = "https://www.miratransport.net/assets/image/signatureDAF.png";

	
	
	
	$(".po2").empty();
	$(".po2").append(po+'<br/><br/>');
	
	$(".fournisseur").empty();
	$(".fournisseur").append(delegue);
	
	$(".date_commande2").empty();
	$(".date_commande2").append(date_com);
	
	$(".etat_expedition2").empty();
	$(".etat_expedition2").append(etat_exp);
	
	$(".etat_expedition3").empty();
	$(".etat_expedition3").append(etat_exp1);
	
	
	
	//$(".montant2").empty();
//	$(".montant2").append('<br/><br/><br/>'+montant);
	
	$(".chargementPrime2").fadeIn();
	window.location = base_url+"/admin/demande_frais#contentDetailCommande2";
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getDetailDemande",
      data:{"po":po},
      success: function(data){

        $(".contentDetailCommande2").empty();
        $(".contentDetailCommande2").append(data);
				
        $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td style="text-align : center; border:none; font-weight:16px;font-size: 30px; color:red;border-top:1px solid black;"> '+compteur+'</td><td colspan="3" style="text-align : right; border:none; font-weight:16px; color:red; border-top:1px solid black;"></td><td colspan="3" style="text-align : right; border:none; font-weight:16px; color:red;border-top:1px solid black;">Total : </td><td style="text-align : center; border:none; font-weight:16px;font-size: 18px; color:red;border-top:1px solid black;"> '+montant1+'</td><td style="text-align : center; border:none; font-weight:16px;font-size: 18px; color:red;border-top:1px solid black;"></td><td style="text-align : center; border:none; font-weight:16px;font-size: 18px; color:red;border-top:1px solid black;"> '+montant2+'</td><td style="text-align : right; border:none; font-weight:16px;font-size:30px; color:red; "></td><td style="text-align : center; border:none; font-weight:16px;font-size: 18px; color:red;border-top:1px solid black;"> '+montant3+'</td><td style="text-align : center; border:none; font-weight:16px;font-size: 18px; color:red;border-top:1px solid black;">'+montant4+'</td></tr>');
      
	    $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="5" style="text-align : right; border:none; font-weight:16px;font-size:30px; color:red; ">TOTAL GENERAL   : </td><td colspan="5" style="text-align : left; border:none; font-weight:16px; font-size:30px;color:red; "> '   +montant4+' </td></tr>');
        
		$(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="5" style="text-align : right; border:none; font-weight:16px;font-size:30px; color:red; "></td><td colspan="5" style="text-align : left; border:none; font-weight:16px; font-size:30px;color:red; "></td></tr>');
        
		
	   
   //     $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="3" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;">SIGNATURE DAF :</td><td style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;"></td>'+signatureDAF+'<td colspan="3" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;">SIGNATURE DGT :</td>'+signatureDGT+'</tr>');
   
        $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="3" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;">SIGNATURE DAF :</td><td style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;"></td>'+signatureDAF+'<td colspan="3" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;"></td></tr>');
   

	// $(".contentDetailCommande2").append(imagejavascript);
     
	
		$(".chargementPrime2").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime2").fadeOut();
       }
       });
}


function detailDemandeN(po,operation, delegue,date_com,etat_exp,etat_exp1,montant,signatureDAF,signatureDGT,compteur){
	
//	var imagejavascript = document.createElement("img");
//	imagejavascript.src = "https://www.miratransport.net/assets/image/signatureDAF.png";

	
	
	
	$(".po2").empty();
	$(".po2").append(po+'<br/><br/>');
	
	$(".fournisseur").empty();
	$(".fournisseur").append(delegue);
	
	$(".date_commande2").empty();
	$(".date_commande2").append(date_com);
	
	$(".operation").empty();
	$(".operation").append(operation);
	
	$(".etat_expedition2").empty();
	$(".etat_expedition2").append(etat_exp);
	
	$(".etat_expedition3").empty();
	$(".etat_expedition3").append(etat_exp1);
	
	
	
	//$(".montant2").empty();
//	$(".montant2").append('<br/><br/><br/>'+montant);
	
	$(".chargementPrime2").fadeIn();
	window.location = base_url+"/admin/demande_navette#contentDetailCommande2";
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getDetailDemandeN",
      data:{"po":po},
      success: function(data){

        $(".contentDetailCommande2").empty();
        $(".contentDetailCommande2").append(data);
				
        $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td style="text-align : center; border:none; font-weight:16px;font-size: 30px; color:red;border-top:1px solid black;"> '+compteur+'</td><td colspan="4" style="text-align : right; border:none; font-weight:16px; color:red; border-top:1px solid black;"></td></tr>');
      
	    $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="5" style="text-align : right; border:none; font-weight:16px;font-size:30px; color:red; ">TOTAL LITRAGE   : </td><td colspan="5" style="text-align : left; border:none; font-weight:16px; font-size:30px;color:red; "> '   +montant+' L </td></tr>');
        
		$(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="5" style="text-align : right; border:none; font-weight:16px;font-size:30px; color:red; "></td><td colspan="5" style="text-align : left; border:none; font-weight:16px; font-size:30px;color:red; "></td></tr>');
        
		
	   
   //     $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="3" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;">SIGNATURE DAF :</td><td style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;"></td>'+signatureDAF+'<td colspan="3" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;">SIGNATURE DGT :</td>'+signatureDGT+'</tr>');
   
        $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="2" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;">SIGNATURE DAF :</td><td style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;"></td>'+signatureDAF+'<td colspan="3" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;"></td></tr>');
   

	// $(".contentDetailCommande2").append(imagejavascript);
     
	
		$(".chargementPrime2").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime2").fadeOut();
       }
       });
}


function detailDemandeE(po,operation, delegue,date_com,etat_exp,etat_exp1,montant,signatureDAF,signatureDGT,compteur){
	
//	var imagejavascript = document.createElement("img");
//	imagejavascript.src = "https://www.miratransport.net/assets/image/signatureDAF.png";

	
	
	
	$(".po2").empty();
	$(".po2").append(po+'<br/><br/>');
	
	$(".fournisseur").empty();
	$(".fournisseur").append(delegue);
	
	$(".date_commande2").empty();
	$(".date_commande2").append(date_com);
	
	$(".operation").empty();
	$(".operation").append(operation);
	
	$(".etat_expedition2").empty();
	$(".etat_expedition2").append(etat_exp);
	
	$(".etat_expedition3").empty();
	$(".etat_expedition3").append(etat_exp1);
	
	
	
	//$(".montant2").empty();
//	$(".montant2").append('<br/><br/><br/>'+montant);
	
	$(".chargementPrime2").fadeIn();
	window.location = base_url+"/admin/demande_engin#contentDetailCommande2";
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getDetailDemandeE",
      data:{"po":po},
      success: function(data){

        $(".contentDetailCommande2").empty();
        $(".contentDetailCommande2").append(data);
				
        $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td style="text-align : center; border:none; font-weight:16px;font-size: 30px; color:red;border-top:1px solid black;"> '+compteur+'</td><td colspan="4" style="text-align : right; border:none; font-weight:16px; color:red; border-top:1px solid black;"></td></tr>');
      
	    $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="5" style="text-align : right; border:none; font-weight:16px;font-size:30px; color:red; ">TOTAL LITRAGE   : </td><td colspan="5" style="text-align : left; border:none; font-weight:16px; font-size:30px;color:red; "> '   +montant+' L </td></tr>');
        
		$(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="5" style="text-align : right; border:none; font-weight:16px;font-size:30px; color:red; "></td><td colspan="5" style="text-align : left; border:none; font-weight:16px; font-size:30px;color:red; "></td></tr>');
        
		
	   
   //     $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="3" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;">SIGNATURE DAF :</td><td style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;"></td>'+signatureDAF+'<td colspan="3" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;">SIGNATURE DGT :</td>'+signatureDGT+'</tr>');
   
        $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="2" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;">SIGNATURE DAF :</td><td style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;"></td>'+signatureDAF+'<td colspan="3" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;"></td></tr>');
   

	// $(".contentDetailCommande2").append(imagejavascript);
     
	
		$(".chargementPrime2").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime2").fadeOut();
       }
       });
}


function detailDemandeNA(po,operation, delegue,date_com,etat_exp,etat_exp1,montant,signatureDAF,signatureDGT,compteur){
	
//	var imagejavascript = document.createElement("img");
//	imagejavascript.src = "https://www.miratransport.net/assets/image/signatureDAF.png";

	
	
	
	$(".po2").empty();
	$(".po2").append(po+'<br/><br/>');
	
	$(".fournisseur").empty();
	$(".fournisseur").append(delegue);
	
	$(".date_commande2").empty();
	$(".date_commande2").append(date_com);
	
	$(".operation").empty();
	$(".operation").append(operation);
	
	$(".etat_expedition2").empty();
	$(".etat_expedition2").append(etat_exp);
	
	$(".etat_expedition3").empty();
	$(".etat_expedition3").append(etat_exp1);
	
	
	
	//$(".montant2").empty();
//	$(".montant2").append('<br/><br/><br/>'+montant);
	
	$(".chargementPrime2").fadeIn();
	window.location = base_url+"/admin/demande_navette_pouzz#contentDetailCommande2";
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getDetailDemandeNA",
      data:{"po":po},
      success: function(data){

        $(".contentDetailCommande2").empty();
        $(".contentDetailCommande2").append(data);
				
        $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td style="text-align : center; border:none; font-weight:16px;font-size: 30px; color:red;border-top:1px solid black;"> '+compteur+'</td><td colspan="4" style="text-align : right; border:none; font-weight:16px; color:red; border-top:1px solid black;"></td></tr>');
      
	    $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="5" style="text-align : right; border:none; font-weight:16px;font-size:30px; color:red; ">TOTAL LITRAGE   : </td><td colspan="5" style="text-align : left; border:none; font-weight:16px; font-size:30px;color:red; "> '   +montant+' L </td></tr>');
        
		$(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="5" style="text-align : right; border:none; font-weight:16px;font-size:30px; color:red; "></td><td colspan="5" style="text-align : left; border:none; font-weight:16px; font-size:30px;color:red; "></td></tr>');
        
		
	   
   //     $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="3" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;">SIGNATURE DAF :</td><td style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;"></td>'+signatureDAF+'<td colspan="3" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;">SIGNATURE DGT :</td>'+signatureDGT+'</tr>');
   
        $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="2" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;">SIGNATURE DAF :</td><td style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;"></td>'+signatureDAF+'<td colspan="3" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;"></td></tr>');
   

	// $(".contentDetailCommande2").append(imagejavascript);
     
	
		$(".chargementPrime2").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime2").fadeOut();
       }
       });
}


function detailDemandeG(po,delegue,date_com,etat_exp,etat_exp1,montant,montant1,montant2,montant3,montant4,signatureDAF,signatureDGT,compteur){
	$(".po2").empty();
	$(".po2").append(po+'<br/><br/>');
	
	$(".fournisseur").empty();
	$(".fournisseur").append(delegue);
	
	$(".date_commande2").empty();
	$(".date_commande2").append(date_com);
	
	$(".etat_expedition2").empty();
	$(".etat_expedition2").append(etat_exp);
	
	$(".etat_expedition3").empty();
	$(".etat_expedition3").append(etat_exp1);
	
	
	$(".chargementPrime2").fadeIn();
	window.location = base_url+"/admin/demande_gazoil#contentDetailCommande2";
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getDetailDemandeG",
      data:{"po":po},
      success: function(data){

        $(".contentDetailCommande2").empty();
        $(".contentDetailCommande2").append(data);
		
		
       $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td style="text-align : center; border:none; font-weight:16px; font-size: 20px;color:red; border-top:1px solid black;">'+compteur+'</td><td colspan="2" style="text-align : left; border:none; font-weight:16px; color:red; border-top:1px solid black;"></td><td colspan="2" style="text-align : right; border:none; font-weight:16px; font-size: 20px;color:red;border-top:1px solid black;">Total : </td><td style="text-align : center; border:none; font-weight:16px; font-size: 18px; font-size: 20px;color:red;border-top:1px solid black;"> '+montant+'</td><td style="text-align : center; border:none; font-weight:16px;font-size: 20px; color:red;border-top:1px solid black;"></td><td style="text-align : center; border:none; font-weight:16px;font-size: 18px; color:red;border-top:1px solid black;">'+montant1+'</td><td style="text-align : center; border:none; font-weight:16px;font-size: 18px; color:red;border-top:1px solid black;">'+montant3+'</td><td style="text-align : center; border:none; font-weight:16px;font-size: 18px; color:red;border-top:1px solid black;">'+montant2+'</td><td style="text-align : center; border:none; font-weight:16px;font-size: 18px; color:red;border-top:1px solid black;">'+montant4+'</td></tr>');
      

	   $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="5" style="text-align : right; border:none; font-weight:16px; font-size: 25px;color:red; ">Total Général: </td><td colspan="5" style="text-align : left; border:none; font-weight:16px;font-size: 25px; color:red; "> '+montant2+' L</td></tr>');
    
	
	   $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="5" style="text-align : right; border:none; font-weight:16px;font-size:30px; color:red; "></td><td colspan="5" style="text-align : left; border:none; font-weight:16px; font-size:30px;color:red; "></td></tr>');
       
	   
	 
     //   $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="2" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;">SIGNATURE DAF :</td><td style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;"></td>'+signatureDAF+'<td colspan="6" style="text-align : Center; border:none; font-weight:16px; color:red;border-top:none;">SIGNATURE DGT :</td>'+signatureDGT+'</tr>');
   
	   $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="2" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;">SIGNATURE DAF :</td><td style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;"></td>'+signatureDAF+'<td colspan="6" style="text-align : Center; border:none; font-weight:16px; color:red;border-top:none;"></td></tr>');
    
	 
		$(".chargementPrime2").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime2").fadeOut();
       }
       });
}



function getCamionDelegue(){
	
  delegue = $(".delegue").val();
  
  camion1 = $(".camion1").val();
   
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getCamionDelegue",
      data:{"delegue":delegue},
      success: function(data){
      	
    $(".camion1").empty();
	$(".type1").empty();
	$(".immatriculation1").empty();	
	$(".litrage1").empty();
	$(".route1").empty();	
	$(".retour1").empty();
	
	$(".camion1").append(data);
    
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

function getCamionDelegue1(delegue,camion1,immatriculation1,route1,retour1){
	

   
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getCamionDelegue1",
      data:{"delegue":delegue},
      success: function(data){
      	
    $("."+camion1).empty();
	
	$("."+immatriculation1).empty();	
	$("."+route1).empty();	
	$("."+retour1).empty();
	
	$("."+camion1).append(data);
    
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


function getCamionDelegue1G(delegue,camion1,immatriculation1,litrage1,route1,retour1){
	

   
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getCamionDelegue1G",
      data:{"delegue":delegue},
      success: function(data){
      	
    $("."+camion1).empty();
	
	$("."+immatriculation1).empty();	
	$("."+litrage1).empty();
	$("."+route1).empty();	
	$("."+retour1).empty();
	
	$("."+camion1).append(data);
    
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

function getMatriculeVehicule1_1(camion1,immatriculation1){
    
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getMatriculeVehicule1_1",
      data:{'camion1':camion1},
      success: function(data){
      	// alert(pu);
        $("."+immatriculation1).val("");
		 
		$("."+immatriculation1).val(data);
		
		
       // formatMillierPourSelection(data,fournisseur);
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



function getMatriculeVehicule2(immatriculation,immatriculation1){
    
  
        $("."+immatriculation1).val("");
		
		$("."+immatriculation1).val(immatriculation);
    
}

function getKilometrageGasoilParImmatriculation(immatriculation,kilometrage_debut){

    
   if (immatriculation == "") {
      
   }else{
          $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getKilometrageGasoilParImmatriculation",
      data:{'immatriculation':immatriculation},
      success: function(data){
        // alert(data);
      $("."+kilometrage_debut).val('');
      $("."+kilometrage_debut).val(data); 
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPneu").fadeOut();
          $(".chargementPneu1").fadeOut();
       }
       });
   }
    }




function getTypeArticle1(id_article,type){
    
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getTypeArticle1",
      data:{'id_article':id_article,"origine":""},
      success: function(data){
      	// alert(pu);
        $("."+type).val("");
		$("."+type).val(data);
       // formatMillierPourSelection(data,fournisseur);
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

function getMarqueArticle1(id_article,marque){
    
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getMarqueArticle1",
      data:{'id_article':id_article,"origine":""},
      success: function(data){
      	// alert(pu);
        $("."+marque).val("");
		$("."+marque).val(data);
       // formatMillierPourSelection(data,fournisseur);
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

function getTailleArticle1(id_article,taille){
    
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getTailleArticle1",
      data:{'id_article':id_article,"origine":""},
      success: function(data){
      	// alert(pu);
        $("."+taille).val("");
		$("."+taille).val(data);
       // formatMillierPourSelection(data,fournisseur);
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
// getFournisseurMira(22);

function getPrixUnitaireArticle(){
  id_article = $(".article").val();
  origine = $(".origine").val();
  if (origine == "externe") {
    // $(".PU").removeAttr("disabled","false");
    $(".PU").val("");
    $(".id_fournisseur").removeAttr("disabled","true");
    getAllFournisseurMira();
  }else{
    id_fournisseur = 65;
    $(".id_fournisseur").attr("disabled","true");
    getFournisseurMira(id_fournisseur)
    // $(".PU").attr("disabled","true");
    
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getPrixUnitaireArticle",
      data:{'id_article':id_article,"origine":origine},
      success: function(data){
        $(".PU").val("");
        formatMillierPourSelection(data,'PU');

       getPrixAvecTVAPieceRechange();
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
}

function getPrixUnitaireArticleGazoil(){
  id_article = $(".article").val();
  
  
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getPrixUnitaireArticleGazoil",
      data:{'id_article':id_article},
      success: function(data){
        $(".montant").val("");
		 $(".montant").val(data);
     //   formatMillierPourSelection(data,'montant');

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
  
  function getPrixUnitaireArticleHuile(){
  id_article = $(".article").val();
  
  
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getPrixUnitaireArticleHuile",
      data:{'id_article':id_article},
      success: function(data){
        $(".montant").val("");
		 $(".montant").val(data);
     //   formatMillierPourSelection(data,'montant');

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


function getReferenceArticle(){
  id_article = $(".article").val();
 
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getReferenceArticle",
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

function getStockArticle(){
  id_article = $(".article").val();
  
  date = $(".datePrime").val();
  
 
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getStockArticle",
      data:{'id_article':id_article,"date":date},
      success: function(data){
        $(".stock").val("");
        $(".stock").val(data);
        
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

function getStockHuile(){
  id_type = $(".id_type").val();
  
  date = $(".datePrime").val();
  
 
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getStockHuile",
      data:{'id_type':id_type,"date":date},
      success: function(data){
        $(".stock").val("");
        $(".stock").val(data);
        
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

function getStockHuileH(){
  id_type = $(".id_type").val();
  
  date = $(".datePrime").val();
  
 
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getStockHuileH",
      data:{'id_type':id_type,"date":date},
      success: function(data){
        $(".stock").val("");
        $(".stock").val(data);
        
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


function getStockGraisseV(){
  id_type = $(".id_type").val();
  
  date = $(".datePrime").val();
  
 
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getStockGraisseV",
      data:{'id_type':id_type,"date":date},
      success: function(data){
        $(".stock").val("");
        $(".stock").val(data);
        
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


function getStockHuileB(){
  id_type = $(".id_type").val();
  
  date = $(".datePrime").val();
  
 
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getStockHuileB",
      data:{'id_type':id_type,"date":date},
      success: function(data){
        $(".stock").val("");
        $(".stock").val(data);
        
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



function getReferenceArticleGazoil(){
  id_article = $(".article").val();
 
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getReferenceArticleGazoil",
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

function getReferenceArticlePneu(){
  id_article = $(".article").val();
 
  $(".reference").val(id_article);
   
  
}

function getReferenceArticleHuile(){
  id_article = $(".article").val();
 
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getReferenceArticleHuile",
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

function getPrixUnitaireArticlePourPneu(){

  id_article = $(".article").val();
  origine = "interne";
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getPrixUnitaireArticle",
      data:{'id_article':id_article,"origine":origine},
      success: function(data){
        $(".PU").val("");
        // alert(data);
        formatMillierPourSelection(data,'PU');
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


function formatMillier(classe){
  nombre = $("."+classe).val();
  nombre = nombre.replace(/ /g,'');
  nombre +='';

  var sep = ' ';
  var reg = /(\d+)(\d{3})/;

  while( reg.test( nombre )){
    nombre = nombre.replace(reg,'$1'+sep+'$2');
  } 
$("."+classe).val("");
 $("."+classe).val(nombre);
 // alert(nombre)
}
function getTypeCamion(code_camion){
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getTypeCamion",
      data:{"code_camion":code_camion},
      success: function(data){
     if ($.trim(data) == "true") {
      $(".litrage").removeAttr("disabled","true");
     }else{
      $(".litrage").attr("disabled","true");
     }
     
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
function getDistanceParCodeCamion(){
  code_camion = $(".code_camion").val();
 $(".supplement").attr('disabled','true');
 // getTypeCamion(code_camion);
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getDistanceParCodeCamion",
      data:{"code_camion":code_camion},
      success: function(data){
        $(".destination").empty();
        // alert(data);
        $(".destination").append(data);
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

function getPrixUnitaireParFournisseur(){
  id_fournisseur = $(".fournisseur").val();
 
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getPrixUnitaireParFournisseur",
      data:{"id_fournisseur":id_fournisseur},
      success: function(data){
        $(".prixUnitaire").val("");
        // alert(data);
        classe = 'prixUnitaire';
        nombre = data;
          nombre = nombre.replace(/ /g,'');
       nombre +='';

      var sep = ' ';
      var reg = /(\d+)(\d{3})/;

      while( reg.test( nombre )){
        nombre = nombre.replace(reg,'$1'+sep+'$2');
      } 
    $("."+classe).val("");
     $("."+classe).val(nombre);
     getMontantTotalGazoil();
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
function getLittrage(){
  destination = $(".destination").val();
 // alert($(".destination option:selected").text());

  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getLittrage",
      data:{"destination":destination},
      success: function(data){
        $(".litrage").val("");
        // alert(data);
        $(".litrage").val(data);

        getMontantTotalGazoil();
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

function getDescriptionOperation(id_operation=""){
  if (id_operation == "") {
     id_operation= $(".operation").val();
   }else{}


getDestinationOperation(id_operation);





 $.ajax({
      type:"POST",
      url:base_url+"/admin_livraison/getDescriptionOperation",
      data:{"id_operation":id_operation},
      success: function(data){  
        $(".description").empty();
        $(".description").append($.trim(data));
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
function getDestinationOperation(id_operation=""){

  if (id_operation == "" || id_operation == null || id_operation == undefined) {
     id_operation= $(".operation").val();
   }else{}

 $.ajax({
      type:"POST",
      url:base_url+"/admin_livraison/getDestinationOperation",
      data:{"id_operation":id_operation},
      success: function(data){  
        $(".destination3").val("");
        $(".destination3").val($.trim(data));
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
function getPrixUnitaireHuile(){
   id_type= $(".id_type").val();
if (id_type == "" || id_type == " " || id_type == undefined) {
 // alert(id_type);
}else{

 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getPrixUnitaireHuile",
      data:{"id_type":id_type},
      success: function(data){  
        $(".PU").val();
        formatMillierPourSelection(data,'PU');
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
}

function getPrixUnitaireGraisse(){
   id_type= $(".id_type").val();
if (id_type == "" || id_type == " " || id_type == undefined) {
 // alert(id_type);
}else{

 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getPrixUnitaireGraisse",
      data:{"id_type":id_type},
      success: function(data){  
        $(".PU").val();
        formatMillierPourSelection(data,'PU');
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
}



function getPrixTotalVidange(){
  qtite = $(".qtite").val();
  pu = $(".PU").val();
  pu = pu.replace(/ /g,'');
  pt = qtite*parseInt(pu);

  formatMillierPourSelection(''+pt+'','PT');

}

function getKilometrageVehicule(){

  code = $(".camion").val();

   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getKilometrageVehicule",
      data:{"code_camion":code},
      success: function(data){  
        $(".KilometrageGasoil").val("");
        $(".KilometrageGasoil").val(data);
        // alert(data);
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

function addDepenseSalaireChauffeur(status){
  montant = $(".montant").val();
  assistant = $(".assistant").val();
  date = $(".date").val();
  codeCamion = $(".camion").val();
  chauffeur = $(".chauffeur").val();
  montantNetChauffeur = $(".montantNetChauffeur").val();
  montantNetAssistant = $(".montantNetAssistant").val();
  totalMontantNet = $(".totalMontantNet").val();

  id_prime = $(".id_prime").val();

  if (date == "") {
  $(".date").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
  }else if (codeCamion == "") {
  $(".camion").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (chauffeur == "") {
  $(".chauffeur").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else{
  $(".date").css("border","1px solid #ced4da");
  $(".chauffeur").css("border","1px solid #ced4da");
  $(".camion").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addDepenseSalaireChauffeur",
      data:{"id_prime":id_prime,"status":status,"montantNetChauffeur":montantNetChauffeur,"montantNetAssistant":montantNetAssistant,"date":date,"montantNetChauffeur":montantNetChauffeur,"camion":codeCamion,"chauffeur":chauffeur,"assistant":assistant},
      success: function(data){  

        if ($.trim(data) == "Enregistrement de la depense salaire") {

        $('#example1').DataTable().destroy();
        afficheAllDepenseSalaireChauffeur('#example1');
          $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
        }else if ($.trim(data) == "Modification de la depense salaire") {

        $('#example1').DataTable().destroy();
        afficheAllDepenseSalaireChauffeur('#example1');
          $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
          $(".chargementPrime1").fadeOut();
$(".chargementPrime1").fadeOut();
        }else{
        $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      }) 
        }
$(".chargementPrime1").fadeOut();
      },
            error:function(data){
           $(".chargementGazoil1").fadeOut();
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })
                
       }
       });
  }
}

function afficheAllDepenseSalaireChauffeur(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllDepenseSalaireChauffeur",
      data:{},
      success: function(data){

        $(".contentPrime").empty();
        $(".contentPrime").append(data);
        ceerDatatable(idTable)
        $(".chargementPrime").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime").fadeOut();
       }
       });
}

function confirmSuppressionDepenseChauffeur(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_document/deleteDocument",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllDepenseSalaireChauffeur('#example1');
        
          
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

function infoDepenseChauffeur(id_chauffeur,assistant,code_camion,date,montantNetChauffeur,montantNetAssistant,id_prime){
  
  $(".assistant").val(assistant);
  $(".date").val(date);
  $(".camion").val(code_camion);
  $(".id_chauffeurs").val($.trim(id_chauffeur));
  // alert(id_chauffeur);
  $(".montantNetChauffeur").val(montantNetChauffeur);
  $(".montantNetAssistant").val(montantNetAssistant);
  $(".totalMontantNet").val(parseInt(montantNetAssistant)+parseInt(montantNetChauffeur));

  $(".id_prime").val(id_prime);
  $(".btnAdd").fadeOut();
  $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
}

function getAssistantChauffeur(){

  chauffeur = $(".chauffeur").val();

   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAssistantChauffeur",
      data:{"id_chauffeur":chauffeur},
      success: function(data){  
        $(".assistant").val("");
        $(".assistant").val(data);
        // alert(data);
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
getSalaireAssistant();
getSalaireNetChauffeur();
getTotalSalaireNetChauffeurAssistant();
}

function getSalaireAssistant(){

  chauffeur = $(".chauffeur").val();

   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getSalaireAssistant",
      data:{"id_chauffeur":chauffeur},
      success: function(data){  
        $(".montantNetAssistant").val("");
        $(".montantNetAssistant").val(data);
        // alert(data);
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

function getSalaireNetChauffeur(){

  chauffeur = $(".chauffeur").val();
  date = $(".date").val();
   $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/getSalaireNetChauffeur",
      data:{"id_chauffeur":chauffeur,"date":date},
      success: function(data){  
        $(".montantNetChauffeur").val("");
        $(".montantNetChauffeur").val(data);
        // alert(data);
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

function getTotalSalaireNetChauffeurAssistant(){

  chauffeur = $(".chauffeur").val();
  date = $(".date").val();
   $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/getTotalSalaireNetChauffeurAssistant",
      data:{"id_chauffeur":chauffeur,"date":date},
      success: function(data){  
        $(".totalMontantNet").val("");
        $(".totalMontantNet").val(data);
        // alert(data);
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

function addMarque(status){
	// alert(status);
	marque = $(".marque").val();
	commentaire = $(".commentaire").val();
	
	id_client = $(".id_client").val();
	
	if (marque == "") {
		$(".marque").css("border","red 2px solid");
		toastr.error("Veuillez remplir tous les Champs");
	}else if (commentaire == "") {
		$(".commentaire").css("border","red 2px solid");
		toastr.error("Veuillez remplir tous les Champs");
	}else{
		$(".marque").css("border","1px solid #ced4da");
		$(".commentaire").css("border","1px solid #ced4da");
		
    $(".chargementCarteGrise1").fadeIn();
		 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addMarque",
      data:{"status":status,"id_client":id_client,"marque":marque,"commentaire":commentaire},
       success: function(data){
   if ($.trim(data) == "Insertion parfaite de la marque") {
   	$(".marque").val("");
	$(".commentaire").val("");
	
		toastr.info(data);
      	$('#example1').DataTable().destroy();
        afficheAllMarque('#example1');
        $(".chargementCarteGrise1").fadeOut();
      }else if ($.trim(data) == "Modification parfaite de la marque") {
      	$(".marque").val("");
		$(".commentaire").val("");
	
		toastr.info(data);
      	$('#example1').DataTable().destroy();
        afficheAllMarque('#example1');
        $(".chargementCarteGrise1").fadeOut();
      }else{
      	 $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      }) 
      	 $(".chargementCarteGrise1").fadeOut();
      }
    
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementCarteGrise").fadeOut();
          $(".chargementCarteGrise1").fadeOut();
       }
       });
	}
}


function confirmSuppressionMarque(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deleteMarque",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllMarque('#example1');
        
          
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

function afficheAllMarque(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllMarque",
      data:{},
      success: function(data){

        $(".contentPrime").empty();
        $(".contentPrime").append(data);
        ceerDatatable(idTable)
        $(".chargementPrime").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime").fadeOut();
       }
       });
}

function addTypePneu(status){
	// alert(status);
	nom_type = $(".nom_type").val();
	commentaire = $(".commentaire").val();
	id_client = $(".id_client").val();
	
	if (nom_type == "") {
		$(".nom_type").css("border","red 2px solid");
		toastr.error("Veuillez remplir tous les Champs");
	}else if (commentaire == "") {
		$(".commentaire").css("border","red 2px solid");
		toastr.error("Veuillez remplir tous les Champs");
	}else{
		$(".nom_type").css("border","1px solid #ced4da");
		$(".commentaire").css("border","1px solid #ced4da");
		
    $(".chargementCarteGrise1").fadeIn();
		 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addtypePneu",
      data:{"status":status,"id_client":id_client,"nom_type":nom_type,"commentaire":commentaire},
       success: function(data){
   if ($.trim(data) == "Insertion parfaite du Type Pneu") {
   	$(".nom_type").val("");
	$(".commentaire").val("");
	
		toastr.info(data);
      	$('#example1').DataTable().destroy();
        afficheAllTypePneu('#example1');
        $(".chargementCarteGrise1").fadeOut();
      }else if ($.trim(data) == "Modification parfaite du Type Pneu") {
      		$(".nom_type").val("");
			$(".commentaire").val("");
	
		toastr.info(data);
      	$('#example1').DataTable().destroy();
        afficheAllTypePneu('#example1');
        $(".chargementCarteGrise1").fadeOut();
      }else{
      	 $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      }) 
      	 $(".chargementCarteGrise1").fadeOut();
      }
    
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementCarteGrise").fadeOut();
          $(".chargementCarteGrise1").fadeOut();
       }
       });
	}
}


function confirmSuppressionTypePneu(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deleteTypePneu",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllTypePneu('#example1');
        
          
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

function afficheAllTypePneu(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllTypePneu",
      data:{},
      success: function(data){

        $(".contentPrime").empty();
        $(".contentPrime").append(data);
        ceerDatatable(idTable)
        $(".chargementPrime").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime").fadeOut();
       }
       });
}



function getMontantAchat(){
	
	  validite = $(".validite").val();
	
  if ((validite == "Pouzolane Noire" )) {
		   
		 $(".montant").val("8500");  
    

  }else if (validite == "Pouzolane Rouge" ) {
    
	 $(".montant").val("7000"); 
	 
  }else if (validite == "Gravier" ) {
    
	 $(".montant").val("11000"); 
	 
  }else if (validite == "Sable" ) {
    
	 $(".montant").val("7600"); 
	 
  }else {
	  
	$(".montant").val("0");  
	
	}
	
	}
	
	function getMontantRetour1(rj3,retour){
	
	
	 if ($("."+rj3).prop('checked') == false) {
		 
     $("."+retour).val("0");
	 
    }

	}
	
	function getMontantRetour(rj3,retour){
	
	 validite = $("."+rj3).val();
	
	 if (validite == "NON") {
		 
     $("."+retour).val("0");
	 
    }

	}
	
function getTotal(){
	
  quantite = $(".quantite").val();
  montant = $(".montant").val();
  montant = montant.replace(/ /g,'');
  montant1 = quantite*parseInt(montant);

  formatMillierPourSelection(''+montant1+'','PT');
	
	}
	
	
	
function getAllDemande(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut !="" && date_fin !="") {
    $('#example1').DataTable().destroy();
  afficheAllDemande('#example1');
  }
  
}

function getAllDemandeN(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut !="" && date_fin !="") {
    $('#example1').DataTable().destroy();
  afficheAllDemandeN('#example1');
  }
  
}

function getAllDemandeNA(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut !="" && date_fin !="") {
    $('#example1').DataTable().destroy();
  afficheAllDemandeNA('#example1');
  }
  
}

function getAllDemandeST(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut !="" && date_fin !="") {
    $('#example1').DataTable().destroy();
  afficheAllDemandeST('#example1');
  }
  
}


function getAllDemandeG(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut !="" && date_fin !="") {
    $('#example1').DataTable().destroy();
  afficheAllDemandeG('#example1');
  }
  
}

function afficheAllDemande(idTable){
	 
	 id_fournisseur1 = $(".id_fournisseur1").val();
	date_debut = $(".date_debut").val();
	date_fin = $(".date_fin").val();
	
	
	
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllDemande",
      data:{"date_fin":date_fin,"date_debut":date_debut,"id_fournisseur1":id_fournisseur1},
      success: function(data){

        $(".contentCommande").empty();
        $(".contentCommande").append(data);
        ceerDatatable(idTable)
        $(".chargementPrime").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime").fadeOut();
       }
       });
}

function afficheAllDemandeN(idTable){
	 
	 id_fournisseur1 = $(".id_fournisseur1").val();
	date_debut = $(".date_debut").val();
	date_fin = $(".date_fin").val();
	
	
	
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllDemandeN",
      data:{"date_fin":date_fin,"date_debut":date_debut,"id_fournisseur1":id_fournisseur1},
      success: function(data){

        $(".contentCommande").empty();
        $(".contentCommande").append(data);
        ceerDatatable(idTable)
        $(".chargementPrime").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime").fadeOut();
       }
       });
}

function afficheAllDemandeE(idTable){
	 
	 id_fournisseur1 = $(".id_fournisseur1").val();
	date_debut = $(".date_debut").val();
	date_fin = $(".date_fin").val();
	
	
	
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllDemandeE",
      data:{"date_fin":date_fin,"date_debut":date_debut,"id_fournisseur1":id_fournisseur1},
      success: function(data){

        $(".contentCommande").empty();
        $(".contentCommande").append(data);
        ceerDatatable(idTable)
        $(".chargementPrime").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime").fadeOut();
       }
       });
}

function afficheAllDemandeNA(idTable){
	 
	 id_fournisseur1 = $(".id_fournisseur1").val();
	date_debut = $(".date_debut").val();
	date_fin = $(".date_fin").val();
	
	
	
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllDemandeNA",
      data:{"date_fin":date_fin,"date_debut":date_debut,"id_fournisseur1":id_fournisseur1},
      success: function(data){

        $(".contentCommande").empty();
        $(".contentCommande").append(data);
        ceerDatatable(idTable)
        $(".chargementPrime").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime").fadeOut();
       }
       });
}

function afficheAllDemandeST(idTable){
	 
	 id_fournisseur1 = $(".id_fournisseur1").val();
	date_debut = $(".date_debut").val();
	date_fin = $(".date_fin").val();
	
	
	
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllDemandeST",
      data:{"date_fin":date_fin,"date_debut":date_debut,"id_fournisseur1":id_fournisseur1},
      success: function(data){

        $(".contentCommande").empty();
        $(".contentCommande").append(data);
        ceerDatatable(idTable)
        $(".chargementPrime").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime").fadeOut();
       }
       });
}



function afficheAllDemandeG(idTable){
	 
	 id_fournisseur1 = $(".id_fournisseur1").val();
	date_debut = $(".date_debut").val();
	date_fin = $(".date_fin").val();
	
	
	
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllDemandeG",
      data:{"date_fin":date_fin,"date_debut":date_debut,"id_fournisseur1":id_fournisseur1},
      success: function(data){

        $(".contentCommande").empty();
        $(".contentCommande").append(data);
        ceerDatatable(idTable)
        $(".chargementPrime").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime").fadeOut();
       }
       });
}

function infosClient(id_client,nom,adresse,telephone,date_init,montant_init){
  $(".dateInitialisation").val(date_init);
  $(".montantInitialisation").val(montant_init);
	$(".nom").val(nom);
  $(".nui").val(nui);
	$(".adresse").val(adresse);
	$(".telephone").val(telephone);
	$(".id_client").val(id_client);
	$(".btnAnnulerModif").fadeIn();
	$(".btnModifClient").fadeIn();
	$(".btnAddClient").fadeOut();
}


function addClient(status){
	// alert(status);
	nom = $(".nom").val();
	adresse = $(".adresse").val();
	telephone = $(".telephone").val();
	id_client = $(".id_client").val();
  nui = $(".nui").val();
   date_init = $(".dateInitialisation").val();
  montant_init =$(".montantInitialisation").val();
	if (nom == "") {
		$(".nom").css("border","red 2px solid");
		toastr.error("Veuillez remplir tous les Champs");
	}else if (adresse == "") {
		$(".adresse").css("border","red 2px solid");
		toastr.error("Veuillez remplir tous les Champs");
	}else if (nui == "") {
    $(".nui").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (date_init == "") {
		$(".date_init").css("border","red 2px solid");
		toastr.error("Veuillez remplir tous les Champs");
	}else if (montant_init == "") {
    $(".montant_init").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (telephone == "") {
    $(".telephone").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else{
    $(".montant_init").css("border","1px solid #ced4da");
    $(".date_init").css("border","1px solid #ced4da");
    $(".nui").css("border","1px solid #ced4da");
		$(".nom").css("border","1px solid #ced4da");
		$(".adresse").css("border","1px solid #ced4da");
		$(".telephone").css("border","1px solid #ced4da");
$(".chargementCarteGrise1").fadeIn();
		 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addClient",
      data:{"montant_init":montant_init,"date_init":date_init,"status":status,"id_client":id_client,"nom":nom,"adresse":adresse,"telephone":telephone,"nui":nui},
       success: function(data){
   if ($.trim(data) == "Insertion parfaite du client") {
   	$(".nom").val("");
	$(".adresse").val("");
	$(".telephone").val("");
		toastr.info(data);
      	$('#example1').DataTable().destroy();
        afficheAllClient('#example1');
        $(".chargementCarteGrise1").fadeOut();
      }else if ($.trim(data) == "Modification parfaite du client") {
      	$(".nom").val("");
	$(".adresse").val("");
	$(".telephone").val("");
		toastr.info(data);
      	$('#example1').DataTable().destroy();
        afficheAllClient('#example1');
        $(".chargementCarteGrise1").fadeOut();
      }else{
      	 $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      }) 
      	 $(".chargementCarteGrise1").fadeOut();
      }
    
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementCarteGrise").fadeOut();
          $(".chargementCarteGrise1").fadeOut();
       }
       });
	}
}
function confirmSuppressionClient(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deleteClient",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllClient('#example1');
        
          
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

function confirmSuppressionDemande(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deleteDemande",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllDemande('#example1');
        
          
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

function confirmSuppressionDemandeN(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deleteDemandeN",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllDemandeN('#example1');
        
          
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

function confirmSuppressionDemandeNA(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deleteDemandeNA",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllDemandeNA('#example1');
        
          
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

function confirmSuppressionDemandeST(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/deleteDemandeST",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllDemandeST('#example1');
        
          
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


function afficheAllClient(idTable){
  $(".chargementClient").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllClient",
      data:{},
      success: function(data){

        $(".contentClient").empty();
        $(".contentClient").append(data);
        ceerDatatable(idTable)
        $(".chargementClient").fadeOut();
        // formAddRemorque();
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

function afficheAllFactureSansBL(event){
  // $(".chargementExeption").fadeIn();
  idTable = '#exampleExeption';
  event.preventDefault();
       // event.stopPropagation();
  $('.compteur1').val("0");
  popupFactureClient(idTable);
  
}

function popupFactureClient(idTable){
  i = $('.compteur1').val();
// setTimeout(popupFactureArticle,5000);
  stopProgression = setTimeout(popupFactureClient,2000);
  $(".ajoutChargeur").append('<div class="overlay d-flex justify-content-center align-items-center chargementExeption"><i class="fas fa-2x fa-sync fa-spin"></i></div>');
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getAllFactureSansBL",
      data:{},
      success: function(data){
        // alert(data);
        $(".content_exeption").empty();
        $(".content_exeption").append(data);
        $(idTable).DataTable().destroy();
        ceerDatatable(idTable);
        $(".chargementExeption").detach();
        
       
       
        // alert(i);
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementExeption").fadeOut();
       }
       });
   if (i== 1) {
    clearTimeout(stopProgression);
    alert(i);
    $(".compteur1").val(0);
      }
  
        i++;
         $(".compteur1").val(i);
   clearTimeout(stopProgression);
}




function imprimer(divName){
	// alert(divName)
	var printContents = document.getElementById(divName).innerHTML;
	var originalContents = document.body.innerHTML;
	document.body.innerHTML = printContents;
	window.print();
	document.body.innerHTML = originalContents;

}

function imprimer_bloc(titre, objet) {
// Définition de la zone à imprimer
var zone = document.getElementById(objet).innerHTML;
 
// Ouverture du popup
// var fen = window.open("", "", "height=1000, width=1200,toolbar=0, menubar=0, scrollbars=1, resizable=1,status=0, location=0, left=10, top=10");
 
// // style du popup
// fen.document.body.style.color = '#000000';
// fen.document.body.style.backgroundColor = '#FFFFFF';
// fen.document.body.style.padding = "20px";
// fen.document.wrhite('<html><head>  <link rel="stylesheet" type="text/css" media="all" href="http://localhost/mira/assets/dist/css/adminlte.min.css"></head>')
// Ajout des données a imprimer

// fen.document.title = titre;
// fen.document.body.innerHTML += " " + zone + " ";
 
// // Impression du popup
// fen.window.print();
 
// //Fermeture du popup
// fen.window.close();
// return true;
var win = window.open("", "", "height=1300, width=1600,toolbar=0, menubar=0, scrollbars=1, resizable=1,status=0, location=0, left=10, top=10");
win.document.write('<html><head><title>Print it!</title></head><body style="backgroundColor:red;">');
win.document.write(zone );
win.document.write('</body></html>');
win.print();
win.close();
}

function getNotificationParTemps(){
setTimeout(getNotificationParTemps,2500);
    $.getScript(base_url+"/admin_depense/getNbreNewNotificationParTemps"
  ,
  function(data){
    i=0;
    char = data.split(',');
     // char3 = char2.split('[');
     //  char = char3.split(']');
    // alert(char);
    do{

        // alert(i);
if (char[i]!= " ") {
delai = 8750;
             $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getUniqueNotificationParTemps",
      data:{"id":char[i]},
      success: function(dat){
         // alert(char[i]);
         $(document).Toasts('create', {
                  class: 'bg-warning',
                  title: 'Toast Title',
                  position: 'bottomLeft',
                  subtitle: 'Alert',
                  autohide: true,
                  delay: delai,
                  body: dat
                })
         delai = delai + 2000;
      },
       error:function(data){
        alert(i);
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime").fadeOut();
           clearTimeout(getNotificationParTemps);
       }
       });

}else{

}
        
      i++;
    }while(i<char.length);
    // alert(tab[1]);
  }
  )

}

function verifBLInTabInput(classe){

    bl = $("."+classe).val();

    nbreLignes = $(".nbreLigne").val();

    tabArt = [];
	
	tabArt2 = [];


	//alert(nbreLignes);
    i=0;

	 while(i<=nbreLignes){
			if ("bl"+i!= classe){
			tabArt2[i]= $(".bl"+i).val();
			}
				
			
		  i++;

	  }

		i=0;
     while(i<=nbreLignes){



       if(bl == tabArt2[i]){

            toastr.error('Ce Bon d livraison a déjà été sélectionné veuillez changer svp');

            $("."+classe).val("");

            return;

        }

      i++;

  }



}



function verifMatriculeInTabInput(classe){

    bl = $("."+classe).val();

    nbreLignes = $(".nbreLigne").val();

    tabArt = [];
	
	tabArt2 = [];


	//alert(nbreLignes);
    i=0;

	 while(i<=nbreLignes){
			if ("camion1"+i!= classe){
			tabArt2[i]= $(".camion1"+i).val();
			}
				
			
		  i++;

	  }

		i=0;
     while(i<=nbreLignes){



       if(bl == tabArt2[i]){

            toastr.error('Cet Immatriculation a déjà été sélectionné veuillez changer svp');

            $("."+classe).val("");
			
            return;

        }

      i++;

  }



}


function getBLDatabase(bl,bl2,blT){
	 
    $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getBLDatabase",
      data:{'bl':bl},
      success: function(data){  
	  
       $("."+blT).val("");
       $("."+blT).val(data);
	   
	   bl1 = $("."+blT).val();
	 	   
	   if($.trim(bl) == $.trim(bl1)){
		 
		   toastr.error('Ce Bon de livraison a déjà été enregistré veuillez changer svp');

            $("."+bl2).val("");
			

        }
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

function getBLTDatabase(camion1,camionG,blT){
	 
    $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getBLTDatabase",
      data:{'camion1':camion1},
      success: function(data){  
	  
       $("."+blT).val("");
       $("."+blT).val(data);
	   
	   camion2 = $("."+blT).val();
	 	   
	   if(Math.round($.trim(camion2)) == 0){
		 
		   toastr.error('Nombre de BL(s) pas atteint par ce camion, veuillez changer svp');

            $("."+camionG).val("");
			

        }
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