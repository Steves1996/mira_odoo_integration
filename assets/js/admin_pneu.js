function ceerDatatable1(id){
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
function getExpirationPneu(){
	dateEffet = $(".dateCreation").val();
	var newDate = new Date(dateEffet);
twoDigitMonth = ((newDate.getMonth().length+1)==1)? (newDate.getMonth()+1):"0"+(newDate.getMonth()+1);
  expiration = newDate.getDate()+"/"+twoDigitMonth+"/"+newDate.getFullYear();
duree = 1;
    if (newDate.getDate() <10) {
    if ((newDate.getMonth()+1).toString().length > 1) {
    twoDigitMonth = ((newDate.getMonth().length+1)==1)? (newDate.getMonth()+1):(newDate.getMonth()+1);

annees = parseInt(newDate.getFullYear())+duree;
  $(".dateExpiration").val(annees+"-"+twoDigitMonth+"-0"+newDate.getDate());

  }else{
    twoDigitMonth = ((newDate.getMonth().length+1)==1)? (newDate.getMonth()+1):"0"+(newDate.getMonth()+1);

    annees = parseInt(newDate.getFullYear())+duree;

  $(".dateExpiration").val(annees+"-"+twoDigitMonth+"-0"+newDate.getDate());
  }

  }else{
    if ((newDate.getMonth()+1).toString().length > 1) {
    twoDigitMonth = ((newDate.getMonth().length+1)==1)? (newDate.getMonth()+1):(newDate.getMonth()+1);

annees = parseInt(newDate.getFullYear())+duree;
  $(".dateExpiration").val(annees+"-"+twoDigitMonth+"-"+newDate.getDate());

  }else{
    twoDigitMonth = ((newDate.getMonth().length+1)==1)? (newDate.getMonth()+1):"0"+(newDate.getMonth()+1);

    annees = parseInt(newDate.getFullYear())+duree;

  $(".dateExpiration").val(annees+"-"+twoDigitMonth+"-"+newDate.getDate());
  }
  }
}

function addPneu(status){
  montant = $(".montant").val();
	id_type_pneu = $(".id_type_pneu").val();
	numero = $(".numero").val();
	dateCreation = $(".dateCreation").val();
	dateExpiration = $(".dateExpiration").val();
	immatriculation = $(".immatriculation").val();
	id_pneu = $(".id_pneu").val();
  kilometre_debut = $(".kilometrage_debut").val();
  kilometre_fin = $(".kilometrage_fin").val();
  date_retrait = $(".date_retrait").val();

	if (numero == "") {
		$(".numero").css("border","red 2px solid");
	}else if (montant == "") {
    $(".montant").css("border","red 2px solid");
  }
  else if (dateCreation == "") {
		$(".dateCreation").css("border","red 2px solid");
	}else if (dateCreation > date_retrait) {
    toastr.error("La date de retrait doit toujours être supérieure à la date de création");
  }else{
    $(".montant").css("border","1px solid #ced4da");
		$(".numero").css("border","1px solid #ced4da");
		$(".dateCreation").css("border","1px solid #ced4da");
		 $(".chargementPneu").fadeIn();
		 $(".chargementPneu1").fadeIn();
     // alert(date_retrait);
		  $.ajax({
      type:"POST",
      url:base_url+"/admin/addPneu",
      data:{"kilometrage_debut":kilometre_debut,"kilometrage_fin":kilometre_fin,"date_retrait":date_retrait,'id_pneu':id_pneu,"montant":montant,'status':status, 'id_type_pneu': id_type_pneu,'numero':numero,'dateCreation':dateCreation, 'dateExpiration':dateExpiration,'immatriculation':immatriculation},
      success: function(data){
if ($.trim(data) == "Insertion parfaite du pneu") {
	 $(document).Toasts('create', {
		        class: 'bg-success', 
		        title: 'Success',
		        subtitle: 'Alert',
		        body: data
		      }) 
      		$('#example1').DataTable().destroy();
        afficheAllPneu('#example1');
        $(".chargementPneu1").fadeOut();
        $(".chargementPneu").fadeOut();
    }else if ($.trim(data) == "Modification parfaite du pneu") {
    	 $(document).Toasts('create', {
		        class: 'bg-success', 
		        title: 'Success',
		        subtitle: 'Alert',
		        body: data
		      }) 

    	$('#example1').DataTable().destroy();
        afficheAllPneu('#example1');
        $(".chargementPneu1").fadeOut();
        $(".chargementPneu").fadeOut();
    }else{
    	 $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      })   
    	 $(".chargementPneu1").fadeOut();
          $(".chargementPneu").fadeOut();
    }
      
        
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
function afficheAllPneu(idTable){
  $(".chargementPneu").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin/getAllPneu",
      data:{},
      success: function(data){

        $(".contentPneu").empty();
        $(".contentPneu").append(data);
        ceerDatatable(idTable)
        $(".chargementPneu").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPneu").fadeOut();
       }
       });
}
function getInfosPneu(numero,dateCreation,dateExpiration,id_pneu,montant,kilometrage_debut,kilometre_fin,date_retrait,immatriculation){
  $(".montant").val(montant);
	$(".numero").val(numero);
  $(".immatriculation").val(immatriculation);

  // alert(kilometre_fin);
  $(".kilometrage_debut").val(kilometrage_debut);
  $(".kilometrage_fin").val(kilometre_fin);
  $(".date_retrait").val(date_retrait);
	$(".dateCreation").val(dateCreation);
	$(".dateExpiration").val(dateExpiration);
	$(".id_pneu").val(id_pneu);
	$(".btnAdd").fadeOut();
	$(".btnModif").fadeIn();
	$(".btnAnnuler").fadeIn();
}
function annulerModifPneu(){
    $(".btnAdd").fadeIn();
	$(".btnModif").fadeOut();
	$(".btnAnnuler").fadeOut();
}

function updateServicePneu(id_pneu,etat,immatriculation){
	$(".chargementPneu").fadeIn();
	$.ajax({
      type:"POST",
      url:base_url+"/admin/updateServicePneu",
      data:{"id_pneu":id_pneu,'etat':etat,"immatriculation":immatriculation},
      success: function(data){
      	if ($.trim(data) == "requete éffectuée" ) {
      	 $(document).Toasts('create', {
		        class: 'bg-success', 
		        title: 'Success',
		        subtitle: 'Alert',
		        body: data
		      }) 
        $(".contentPneu").empty();
        $('#example1').DataTable().destroy();
        afficheAllPneu('#example1');
        $(".chargementPneu").fadeOut();
    }else{
    	$(document).Toasts('create', {
		class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
		body: data
		      }) 
      $(".chargementPneu").fadeOut();0

    }
       
      },
       error:function(data){
          $(document).Toasts('create',{
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPneu").fadeOut();
       }
       });
}

function confirmSuppressionPneu(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin/deletePneu",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllPneu('#example1');
        $('#example').DataTable().destroy();
        afficheAllTypePneu('#example');
          
      },
            error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion, ou alors supprimez d\'abord les pneus de ce type sinon contactez l\'administrateur'
      })
                
       }
       });
}

function confirmSuppressionTypePneu(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin/deleteTypePneu",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example').DataTable().destroy();
        afficheAllTypePneu('#example');
        
          
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

function addTypePneu(status){

nom_type = $(".nom_type").val();
id_type_pneu = $(".id_type_pneu1").val();
if (nom_type == "") {
$(".nom_type").css("border","red 2px solid");
}else{
	// alert(nom_type);
$(".nom_type").css("border","1px solid #ced4da");
 $.ajax({
      type:"POST",
      url:base_url+"/admin/addTypePneu",
      data:{"nom_type":nom_type,"status":status,"id_type_pneu":id_type_pneu},
      success: function(data){  
      	if ($.trim(data) == "Insertion parfaite du type de Pneu") {
      		$(document).Toasts('create', {
		        class: 'bg-success', 
		        title: 'Success',
		        subtitle: 'Alert',
		        body: data
		      }) 
      		$('#example').DataTable().destroy();
        afficheAllTypePneu('#example');
        // $('#example1').DataTable().destroy();
        // afficheAllPneu('#example1');
      	}else if ($.trim(data) == "Modification parfaite du type de Pneu") {
      		$(document).Toasts('create', {
		        class: 'bg-success', 
		        title: 'Success',
		        subtitle: 'Alert',
		        body: data
		      }) 
      	$('#example').DataTable().destroy();
        afficheAllTypePneu('#example');
        // $('#example1').DataTable().destroy();
        // afficheAllPneu('#example1');
      	}else{
      	 $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
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
       });
}
}

function afficheAllTypePneu(idTable){
  $(".chargementTypePneu").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin/getAllTypePneu",
      data:{},
      success: function(data){

        $(".contentTypePneu").empty();
        $(".contentTypePneu").append(data);
        ceerDatatable1(idTable);
        $(".chargementTypePneu").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementTypePneu").fadeOut();
       }
       });
}

function infoTypePneu(nom_type,id_type_pneu){
	$(".nom_type").val(nom_type);
	$(".id_type_pneu1").val(id_type_pneu);
	$(".btnAddTypePneu").fadeOut();
	$(".btnAnnulerTypePneu").fadeIn();
	$(".btnModifTypePneu").fadeIn();

 }

 function annulerTypePneu(){
 	$(".btnAddTypePneu").fadeIn();
	$(".btnAnnulerTypePneu").fadeOut();
	$(".btnModifTypePneu").fadeOut();
 }


function addRoueSecours(id_pneu,immatriculation,secours){
      $.ajax({
      type:"POST",
      url:base_url+"/admin/addRoueSecours",
      data:{'id_pneu':id_pneu,'immatriculation':immatriculation,"secours":secours},
      success: function(data){
if ($.trim(data) == "Requete éffectuée") {
   $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 
          $('#example1').DataTable().destroy();
        afficheAllPneu('#example1');
        $(".chargementPneu1").fadeOut();
        $(".chargementPneu").fadeOut();
    }else{
       $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      })   
       $(".chargementPneu1").fadeOut();
          $(".chargementPneu").fadeOut();
    }
      
        
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
 function declarePneuDefectueux(){
   id_pneu = $(".identifiant").val();
      $.ajax({
      type:"POST",
      url:base_url+"/admin/declarePneuDefectueux",
      data:{'id_pneu':id_pneu},
      success: function(data){
if ($.trim(data) == "Vous venez de déclarer ce pneu \"Défectueux\" et vous l'avez mis définitivement hors service") {
   $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 
          $('#example1').DataTable().destroy();
        afficheAllPneu('#example1');
        $(".chargementPneu1").fadeOut();
        $(".chargementPneu").fadeOut();
    }else{
       $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      })   
       $(".chargementPneu1").fadeOut();
          $(".chargementPneu").fadeOut();
    }
      
        
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

  function getImmatriculationParCode(){
   code_camion = $(".code_camion2").val();
   if (code_camion == "") {
      $(".immatriculation").empty();
   }else{
          $.ajax({
      type:"POST",
      url:base_url+"/admin/getImmatriculationParCode",
      data:{'code_camion':code_camion},
      success: function(data){
      $(".immatriculation").empty();
      $(".immatriculation").append(data); 
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

function getKilometrageGasoilParImmatriculation(){

     immatriculation = $(".immatriculation").val();
   if (immatriculation == "") {
      $(".type_camion").empty();
   }else{
          $.ajax({
      type:"POST",
      url:base_url+"/admin/getKilometrageGasoilParImmatriculation",
      data:{'immatriculation':immatriculation},
      success: function(data){
        // alert(data);
      $(".kilometrage_debut").val('');
      $(".kilometrage_debut").val(data); 
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

 function getTypeVehicule(){
     immatriculation = $(".immatriculation").val();
   if (immatriculation == "") {
      $(".type_camion").empty();
   }else{
          $.ajax({
      type:"POST",
      url:base_url+"/admin/getTypeVehicule",
      data:{'immatriculation':immatriculation},
      success: function(data){
      $(".type_camion").val('');
      $(".type_camion").val(data); 
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


function getDepensePneu(){
  $(".chargementPrime").fadeIn();

     date_debut = $(".date_debut").val();
     date_fin = $(".date_fin").val();
     // alert(date_debut);
          $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllDepensePneu",
      data:{'date_debut':date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $('#example1').DataTable().destroy();
         $(".contentPrime").empty();
        $(".contentPrime").append(data);
        ceerDatatable('#example1');
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
          $(".chargementPrime").fadeOut();
       }
       });
   
    }