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
function getListeCamion(){
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commande/getListeCamion",
      data:{},
      success: function(data){
        $("camion").append(data);
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
function afficheLigneCommande(){
	nbreLigne = $(".nbreLigne").val();
$(".contentLignes").empty();
i=1;
$(".chargementPrime1").fadeIn();
conteneur = "";
 $.ajax({
      type:"POST",
      url:base_url+"/admin_commande/getNbreLigne",
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

function getPrixUnitaireArticle(id_article,pu){
    
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getPrixUnitaireArticle",
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

function getReferenceArticle(id_article,reference){
    
   $.ajax({
      type:"POST",
      url:base_url+"/admin_commande/getReferenceArticle",
      data:{'id_article':id_article,"origine":""},
      success: function(data){
        // alert(pu);
        $("."+reference).val("");
        $("."+reference).val(data);
       
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


function nouveauCode(){
	   $.ajax({
      type:"POST",
      url:base_url+"/admin_commande/getNouveauCode",
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

function activePrix(classType,pu){
 type = $(classType).val();

 if (type == 'externe') {
 	$(pu).removeAttr("disabled","true");
 }else{
 	$(pu).attr("disabled","true");
 }
}
function addCommande(status){

	id_fournisseur = $(".id_fournisseur").val();
	date_creation = $(".date_creation").val();
	date_commande = $(".date_commande").val();
	po = $(".po").val();
	etat_reception = $(".etat_reception").val();
	etat_expedition = $(".etat_expedition").val();
	nbreLigne = $(".nbreLigne").val();
	compteur = $(".compteur").val();

	if (compteur>0) {
		nbreLigne = compteur;
	}

	article = [];
	quantite = [];
	pu = [];
	camion = [];
	description = [];
	id_commande = [];
	type = [];
	i=1;
if (id_fournisseur == "") {
		$('.id_fournisseur').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
	}else if (date_creation == ""){
		$('.date_creation').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
	}else if (date_commande == ""){
		$('.date_commande').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
	}else if (po == "") {
		$('.po').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
	}else if (etat_reception == "") {
		$('.etat_reception').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
	}else if (etat_expedition == "") {
		$('.etat_expedition').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
	}else {
		$('.etat_reception').css("border","1px solid #ced4da");
		$('.etat_expedition').css("border","1px solid #ced4da");
		$('.po').css("border","1px solid #ced4da");
		$('.date_commande').css("border","1px solid #ced4da");
		$('.date_creation').css("border","1px solid #ced4da");
		$('.id_fournisseur').css("border","1px solid #ced4da");

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
		}
  //   else if ($('.description'+i).val() == "") {
		// $('.description'+i).css("border","red 2px solid");
		// 	    toastr.error("Veuillez remplir tous les Champs");
		// }
    else{
		
		$('.article'+i).css("border","1px solid #ced4da");
		$('.qtite_com'+i).css("border","1px solid #ced4da");
		$('.pu'+i).css("border","1px solid #ced4da");
		$('.camion'+i).css("border","1px solid #ced4da");
		$('.description'+i).css("border","1px solid #ced4da");

		article[i] = $('.article'+i).val();
		quantite[i] = $('.qtite_com'+i).val();
		pu[i] = $('.pu'+i).val();
		camion[i] = $('.camion'+i).val();
		description[i] = $('.description'+i).val();
		id_commande[i] = $('.id_commande'+i).val();
		type[i] = $('.type'+i).val();
		}
		i++;
		}while(i<=nbreLigne)
	if (article.length >nbreLigne && quantite.length>nbreLigne && pu.length>nbreLigne && camion.length>nbreLigne && description.length>nbreLigne) {
$(".chargementPrime1").fadeIn();
// alert(status);
	   $.ajax({
      type:"POST",
      url:base_url+"/admin_commande/addCommande",
      data:{"status":status,"etat_expedition":etat_expedition,"etat_reception":etat_reception,"po":po,"date_commande":date_commande,"date_creation":date_creation,"id_fournisseur":id_fournisseur,"nbreLignes":nbreLigne,'id_commande':JSON.stringify(id_commande),'article':JSON.stringify(article),'type':JSON.stringify(type),'quantite':JSON.stringify(quantite),'pu':JSON.stringify(pu),'camion':JSON.stringify(camion),'description':JSON.stringify(description)},
      success: function(data){
      	if ($.trim(data) == "Insertion parfaite de la commande") {
		      		$(".chargementPrime1").fadeOut();
		      	 $(document).Toasts('create', {
		        class: 'bg-success', 
		        title: 'Success',
		        subtitle: 'Alert',
		        body: data
		      }) 
		      	 
		      $(".id_fournisseur").val("");
			  $(".date_creation").val("");
			  $(".date_commande").val("");
			  $(".po").val("");
			  // $(".etat_reception").val("");
			  // $(".etat_expedition").val("");
			  nouveauCode();
		      	 $('#example1').DataTable().destroy();
		      	 afficheAllCommande("#exemple1");
		      	}else if ($.trim(data) == "Modification parfaite de la commande") {
		      		$(".chargementPrime1").fadeOut();
		      	 $(document).Toasts('create', {
		        class: 'bg-success', 
		        title: 'Success',
		        subtitle: 'Alert',
		        body: data
		      }) 


				$('#example1').DataTable().destroy();
		      	 afficheAllCommande("#exemple1");

		      $(".id_fournisseur").val("");
			  $(".date_creation").val("");
			  $(".date_commande").val("");
			  $(".po").val("");
			  // $(".etat_reception").val("");
			  // $(".etat_expedition").val("");
			  nouveauCode();
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


function confirmSuppressionCommande(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_commande/deleteCommande",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllCommande('#example1');
        
          
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

function getAllCommande(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut !="" && date_fin !="") {
    $('#example1').DataTable().destroy();
  afficheAllCommande('#example1');
  }
  
}

function afficheAllCommande(idTable){
	 
	 id_fournisseur1 = $(".id_fournisseur1").val();
	date_debut = $(".date_debut").val();
	date_fin = $(".date_fin").val();
	
	
	
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commande/getAllCommande",
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

function detailCommandeCimenterie(po,fournisseur,date_com,date_crea,etat_exp,etat_recep,montant){
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
  window.location = base_url+"/admin/commandeCimenterie#contentDetailCommande2";
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commande/getDetailCommandeCimenterie",
      data:{"po":po},
      success: function(data){
// alert(data);
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

function getDetailCommandePourModification(id_fournisseur,date_creation,date_commande,po,etat_reception,etat_expedition){

		// $('.etat_reception').val(etat_reception);
		// $('.etat_expedition').val(etat_expedition);
		$('.po').val(po);
		$('.date_commande').val(date_commande);
		$('.date_creation').val(date_creation);

  $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Alert',
        subtitle: 'Alert',
        body: 'Avant de confirmer toute Modification veuillez vous rassurer le PO(commande) est celui de cette commande'
      })   	

window.location = base_url+"/admin/commande#details";
 $(".chargementPrime1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commande/getListeCommandePourModif",
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
    $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAdd").fadeOut();
}

// commande cimenterie

function addCommandeCimenterie(status){

  id_fournisseur = $(".id_fournisseur").val();
  date_creation = $(".date_creation").val();
  date_commande = $(".date_commande").val();
  po = $(".po").val();
  etat_reception = $(".etat_reception").val();
  etat_expedition = $(".etat_expedition").val();
  nbreLigne = $(".nbreLigne").val();
  compteur = $(".compteur").val();

  if (compteur>0) {
    nbreLigne = compteur;
  }

  article = [];
  quantite = [];
  pu = [];
  camion = [];
  description = [];
  id_commande = [];
  type = [];
  i=1;
if (id_fournisseur == "") {
    $('.id_fournisseur').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (date_creation == ""){
    $('.date_creation').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (date_commande == ""){
    $('.date_commande').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (po == "") {
    $('.po').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (etat_reception == "") {
    $('.etat_reception').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (etat_expedition == "") {
    $('.etat_expedition').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else {
    $('.etat_reception').css("border","1px solid #ced4da");
    $('.etat_expedition').css("border","1px solid #ced4da");
    $('.po').css("border","1px solid #ced4da");
    $('.date_commande').css("border","1px solid #ced4da");
    $('.date_creation').css("border","1px solid #ced4da");
    $('.id_fournisseur').css("border","1px solid #ced4da");

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
    }
  //   else if ($('.description'+i).val() == "") {
    // $('.description'+i).css("border","red 2px solid");
    //      toastr.error("Veuillez remplir tous les Champs");
    // }
    else{
    
    $('.article'+i).css("border","1px solid #ced4da");
    $('.qtite_com'+i).css("border","1px solid #ced4da");
    $('.pu'+i).css("border","1px solid #ced4da");
    $('.camion'+i).css("border","1px solid #ced4da");
    $('.description'+i).css("border","1px solid #ced4da");

    article[i] = $('.article'+i).val();
    quantite[i] = $('.qtite_com'+i).val();
    pu[i] = $('.pu'+i).val();
    camion[i] = $('.camion'+i).val();
    description[i] = $('.description'+i).val();
    id_commande[i] = $('.id_commande'+i).val();
    type[i] = $('.type'+i).val();
    }
    i++;
    }while(i<=nbreLigne)
  if (article.length >nbreLigne && quantite.length>nbreLigne && pu.length>nbreLigne && camion.length>nbreLigne && description.length>nbreLigne) {
$(".chargementPrime1").fadeIn();
// alert(status);
     $.ajax({
      type:"POST",
      url:base_url+"/admin_commande/addCommandeCimenterie",
      data:{"status":status,"etat_expedition":etat_expedition,"etat_reception":etat_reception,"po":po,"date_commande":date_commande,"date_creation":date_creation,"id_fournisseur":id_fournisseur,"nbreLignes":nbreLigne,'id_commande':JSON.stringify(id_commande),'article':JSON.stringify(article),'type':JSON.stringify(type),'quantite':JSON.stringify(quantite),'pu':JSON.stringify(pu),'camion':JSON.stringify(camion),'description':JSON.stringify(description)},
      success: function(data){
        if ($.trim(data) == "Insertion parfaite de la commande") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 
             
          $(".id_fournisseur").val("");
        $(".date_creation").val("");
        $(".date_commande").val("");
        $(".po").val("");
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
        nouveauCode();
             $('#example1').DataTable().destroy();
             afficheAllCommandeCimenterie("#exemple1");
            }else if ($.trim(data) == "Modification parfaite de la commande") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 


        $('#example1').DataTable().destroy();
             afficheAllCommande("#exemple1");

          $(".id_fournisseur").val("");
        $(".date_creation").val("");
        $(".date_commande").val("");
        $(".po").val("");
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
        nouveauCode();
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


function afficheAllCommandeCimenterie(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commande/getAllCommandeCimenterie",
      data:{},
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


function getDetailCommandeCimenteriePourModification(id_fournisseur,date_creation,date_commande,po,etat_reception,etat_expedition){

    // $('.etat_reception').val(etat_reception);
    // $('.etat_expedition').val(etat_expedition);
    $('.po').val(po);
    $('.date_commande').val(date_commande);
    $('.date_creation').val(date_creation);

  $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Alert',
        subtitle: 'Alert',
        body: 'Avant de confirmer toute Modification veuillez vous rassurer le PO(commande) est celui de cette commande'
      })    

window.location = base_url+"/admin/commandeCimenterie#details";
 $(".chargementPrime1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commande/getListeCommandeCimenteriePourModif",
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
    $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAdd").fadeOut();
}

function confirmSuppressionCommandeCimenterie(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_commande/deleteCommandeCimenterie",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllCommandeCimenterie('#example1');
        
          
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