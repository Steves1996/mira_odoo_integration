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

function afficheAllFournisseurGazoil(idTable){
  $(".chargementClient").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_fournisseur_gazoil/getAllFournisseurGazoil",
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
function infosClient(id_client,nom,adresse,telephone,nui,solde,date){
  $(".solde").val(solde);
  $(".dateFournisseur").val(date);
  $(".nom").val(nom);
  $(".PU").val(nui);
  $(".adresse").val(adresse);
  $(".telephone").val(telephone);
  $(".id_client").val(id_client);
  $(".btnAnnulerModif").fadeIn();
  $(".btnModifClient").fadeIn();
  $(".btnAddClient").fadeOut();
}
function addClient(status){
	// alert(status)
  solde = $(".solde").val();
  date_fournisseur = $(".dateFournisseur").val();
  PU = $(".PU").val();
	nom = $(".nom").val();
	adresse = $(".adresse").val();
	telephone = $(".telephone").val();
	id_client = $(".id_client").val();
	if (nom == "") {
		$(".nom").css("border","red 2px solid");
		toastr.error("Veuillez remplir tous les Champs");
	}else if (adresse == "") {
		$(".adresse").css("border","red 2px solid");
		toastr.error("Veuillez remplir tous les Champs");
	}else if (date_fournisseur == "") {
    $(".dateFournisseur").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (solde == "") {
    $(".solde").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (telephone == "") {
		$(".telephone").css("border","red 2px solid");
		toastr.error("Veuillez remplir tous les Champs");
	}else{
    $(".dateFournisseur").css("border","1px solid #ced4da");
    $(".solde").css("border","1px solid #ced4da");
		$(".nom").css("border","1px solid #ced4da");
		$(".adresse").css("border","1px solid #ced4da");
		$(".telephone").css("border","1px solid #ced4da");
$(".chargementCarteGrise1").fadeIn();
		 $.ajax({
      type:"POST",
      url:base_url+"/admin_fournisseur_gazoil/addFournisseurGazoil",
      data:{"date_fournisseur":date_fournisseur,"solde":solde,"status":status,"PU":PU,"id_client":id_client,"nom":nom,"adresse":adresse,"telephone":telephone},
       success: function(data){
   if ($.trim(data) == "Insertion parfaite du fournisseur") {
   	$(".nom").val("");
	$(".adresse").val("");
	$(".telephone").val("");
		toastr.info(data);
      	$('#example1').DataTable().destroy();
        afficheAllFournisseurGazoil('#example1');
        $(".chargementCarteGrise1").fadeOut();
      }else if ($.trim(data) == "Modification parfaite du fournisseur") {
      	$(".nom").val("");
	$(".adresse").val("");
	$(".telephone").val("");
		toastr.info(data);
      	$('#example1').DataTable().destroy();
        afficheAllFournisseurGazoil('#example1');
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
function confirmSuppressionFournisseurGasoil(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_fournisseur_gazoil/deleteFournisseurGasoil",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllFournisseurGazoil('#example1');
        
          
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

// function infosClient(id_client,nom,adresse,telephone,PU){
// 	$(".nom").val(nom);
//   $(".PU").val(PU)
// 	$(".adresse").val(adresse);
// 	$(".telephone").val(telephone);
// 	$(".id_client").val(id_client);
// 	$(".btnAnnulerModif").fadeIn();
// 	$(".btnModifClient").fadeIn();
// 	$(".btnAddClient").fadeOut();
// }

function annulerModifClient(){
$(".btnAnnulerModif").fadeOut();
	$(".btnModifClient").fadeOut();
	$(".btnAddClient").fadeIn();
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