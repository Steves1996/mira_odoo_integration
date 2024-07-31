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


function getBonLivraison(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  decharge1 = $(".decharge1").val();
  if (date_debut!="" && date_fin!="" && decharge1!="") {
    $('#example1').DataTable().destroy();
   afficheAllLivraison('#example1');
  }
  
}

function addLivraison(status){
	numero = $(".numero").val();
  commentaire = $(".commentaire").val();
  operation = $(".operation").val();
	dateLivraison = $(".dateLivraison").val();
	depart = $(".depart").val();
	arrivee = $(".arrivee option:selected").attr("id_distance");
	quantite = $(".quantite").val();
	PU = $(".PU").val();
	id_BL = $(".id_BL").val();
  unite = $(".unite").val();
  code_camion = $(".camion").val();
  tva = $(".tva").val();
  decharge = $(".decharge").val();
  // alert($(".arrivee").val());
	if (numero == "") {
		$(".numero").css("border","red 2px solid");
		toastr.error("Veuillez remplir tous les Champs");
	}else if (dateLivraison == "") {
		$(".dateLivraison").css("border","red 2px solid");
		toastr.error("Veuillez remplir tous les Champs");
	}else if (depart == "") {
		$(".depart").css("border","red 2px solid");
		toastr.error("Veuillez remplir tous les Champs");
	}else if ($(".arrivee").val() == "" || $(".arrivee").val() == null) {
		$(".arrivee").css("border","red 2px solid");
		toastr.error("Veuillez remplir tous les Champs");
	}else if (operation == "") {
    $(".operation").css("border","red 2px solid");
    toastr.error("Sélectionnez une operation");
  }else if (quantite == "") {
		toastr.error("Veuillez remplir tous les Champs");
		$(".quantite").css("border","red 2px solid");
	}else if (PU == "") {
		$(".PU").css("border","red 2px solid");
		toastr.error("Veuillez remplir tous les Champs");
	}else{
    $(".operation").css("border","1px solid #ced4da");
		$(".numero").css("border","1px solid #ced4da");
		$(".dateLivraison").css("border","1px solid #ced4da");
		$(".depart").css("border","1px solid #ced4da");
		$(".arrivee").css("border","1px solid #ced4da");
		$(".quantite").css("border","1px solid #ced4da");
		$(".PU").css("border","1px solid #ced4da");
			$(".chargementLivraison1").fadeIn();
	$.ajax({
		      type:"POST",
		      url:base_url+"/admin_livraison/addLivraison",
		      data:{"tva":tva,"commentaire":commentaire,"operation":operation,"code_camion":code_camion,"unite":unite,"status":status,"id_BL":id_BL,"numero":numero,"dateLivraison":dateLivraison,"depart":depart,"arrivee":arrivee,"quantite":quantite,"PU":PU,"decharge":decharge},
		      success: function(data){
		      	if ($.trim(data) == "Création parfaite du bon de livraison") {

		 $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
		      			$(".chargementLivraison1").fadeOut();
				      	$('#example1').DataTable().destroy();
				        afficheAllLivraison('#example1');
		      		}else if ($.trim(data) == "Modification parfaite du bon de livraison") {
		      			
		 $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
		 $(".chargementLivraison1").fadeOut();
				      	$('#example1').DataTable().destroy();
				        afficheAllLivraison('#example1');
		}else{
			$(".chargementLivraison1").fadeOut();
				$(document).Toasts('create', {
		        class: 'bg-danger', 
		        title: 'Erreur de connexion',
		        subtitle: 'Alert',
		        body: data
		      })
		      				
		      		}
		        
		      },
		        error:function(data){
		        	$(".chargementLivraison1").fadeOut();
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

function afficheAllLivraison(idTable){
	
  $(".chargementLivraison").fadeIn();
   date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  decharge1 = $(".decharge1").val();
  
  $.ajax({
      type:"POST",
      url:base_url+"/admin_livraison/getAllLivraison",
      data:{"date_debut":date_debut,"date_fin":date_fin,"decharge1":decharge1},
      success: function(data){

        $(".contentLivraison").empty();
        $(".contentLivraison").append(data);
        ceerDatatable(idTable)
        $(".chargementLivraison").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementLivraison").fadeOut();
       }
       });
}

function confirmSuppressionLivraison(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_livraison/deleteBonLivraison",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllLivraison('#example1');
        
          
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


function infosLivraison(numero,dateLivraison,depart,quantite,PU,id_BL,commentaire,code_camion,id_distance,unite,id_operation,tva,PU1,decharge,destinataire){
	$(".unite").val(unite);
  $(".tva").val(tva);
  $(".arrivee").val(id_distance);
  $(".camion").val(code_camion);
  $(".operation").val(id_operation);
 
   
id_type_camion = $(".camion option:selected").attr("id_type");

 // alert(id_type_camion);

 $.ajax({
      type:"POST",
      url:base_url+"/admin_livraison/getDestinationParCodeCamion",
      data:{"id_type_camion":id_type_camion},
      success: function(data){  
        $(".arrivee").empty();
        $(".arrivee").append(data);
           $(".arrivee").val(id_distance);
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
getDescriptionOperation();
getAmortissementDestination();
  $(".id_BL").val(id_BL);
  $(".commentaire").val(destinataire);
  
	$(".numero").val(numero);
	 $(".decharge").val(decharge);
	$(".dateLivraison").val(dateLivraison);
	$(".depart").val(depart);
	// $(".arrivee").val(arrivee);
	$(".quantite").val(quantite);
	$(".PU").val(PU);
  $(".PU1").val(Math.round(PU1));

// formatMillierPourSelection(''+PU1+'','PU1');
  
  formatMillierPourSelection(''+PU+'','PU');
  NewPU = PU.replace(/\s+/g, '');
  PT =NewPU*quantite;
  formatMillierPourSelection(''+PT+'','PT');

	$(".btnModif").fadeIn();
	$(".btnAnnuler").fadeIn();
	$(".btnAdd").fadeOut();
}

function annuleModifLivraison(){
	$(".btnModif").fadeOut();
	$(".btnAnnuler").fadeOut();
	$(".btnAdd").fadeIn();
}

function getMontantTotal(){
  pu = $(".PU").val();
  quantite = $(".quantite").val();
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
function formatMillierPourSelection(data,classe){
   nombre = data;
   // alert(nombre);
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

function getDescriptionOperation(){
 id_operation= $(".operation").val();
getDestinationOperation();
getClientOperation1();
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

function getTotalBL(){
 id_operation= $(".operation").val();
 $.ajax({
      type:"POST",
      url:base_url+"/admin_livraison/getTotalBL",
      data:{"id_operation":id_operation},
      success: function(data){  
        $(".totalLigne").empty();
        $(".totalLigne").val(data);
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

function getClientOperation(){
 id_operation= $(".operation").val();
getDestinationOperation();

 $.ajax({
      type:"POST",
      url:base_url+"/admin_livraison/getClientOperation",
      data:{"id_operation":id_operation},
      success: function(data){  
        $(".client").val("");
        $(".client").val($.trim(data));
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

function getClientOperation1(){
 id_operation= $(".operation").val();

 $.ajax({
      type:"POST",
      url:base_url+"/admin_livraison/getClientOperation",
      data:{"id_operation":id_operation},
      success: function(data){  
        $(".client").val("");
        $(".client").val($.trim(data));
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

function getImmatriculation(){
 immat= $(".immat").val();

 $.ajax({
      type:"POST",
      url:base_url+"/admin_livraison/getImmatriculation",
      data:{"immat":immat},
      success: function(data){  
        $(".camion").val("");
        $(".camion").val($.trim(data));
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

function getDestinationOperation(){
 id_operation= $(".operation").val();


 $.ajax({
      type:"POST",
      url:base_url+"/admin_livraison/getDestinationOperation",
      data:{"id_operation":id_operation},
      success: function(data){  
        $(".destination").empty();
        $(".destination").append($.trim(data));
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


function getAmortissementDestination(){
 id_distance = $(".arrivee option:selected").attr("id_distance");

 // alert(id_distance);

 $.ajax({
      type:"POST",
      url:base_url+"/admin_livraison/getAmortissementDestination",
      data:{"id_distance":id_distance},
      success: function(data){  
        $(".amortissement").val();
        formatMillierPourSelection(data,"amortissement");
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

function getPrixAvecTVA(){

  tva = $(".tva").val();
  pu = $(".PU1").val();
  if (tva == 'oui') {
    
    nouveauPU =Math.round(pu * 1.1925);
    $(".PU").val( nouveauPU);
    getMontantTotal();
  }else{
    $(".PU").val(pu);
    getMontantTotal();
  }
  
}

// vente des pieces

function addVentePieces(status){
  // alert(status);
  libelle = $(".libelle").val();
  operation = $(".operation").val();
  code_camion = $(".camion").val();
  piece = $(".piece").val();
  date = $(".date_piece").val();
  montant = $(".montant").val();
  leClient = $(".leClient").val();

  id_client = $(".id_client").val();

  // alert(operation+" et "+code_camion);
  if (piece == "") {
    $(".piece").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (montant == "") {
    $(".montant").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (date == "") {
    $(".date_piece").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (libelle == "") {
    $(".libelle").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else{
    $(".numero").css("border","1px solid #ced4da");
    $(".libelle").css("border","1px solid #ced4da");
    $(".montant").css("border","1px solid #ced4da");
    $(".date_piece").css("border","1px solid #ced4da");
$(".chargementCarteGrise1").fadeIn();
     $.ajax({
      type:"POST",
      url:base_url+"/admin_livraison/addVentePieces",
      data:{"libelle":libelle,"status":status,"code_camion":code_camion,"operation":operation,"id_client":id_client,"piece":piece,"date_piece":date,"montant":montant,"leClient":leClient},
       success: function(data){
   if ($.trim(data) == "Insertion parfaite de la vente") {
    $(".piece").val("");
  $(".montant").val("");
  $(".date_charg").val("");
    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllVentePiece('#example1');
        $(".chargementCarteGrise1").fadeOut();
      }else if ($.trim(data) == "Modification parfaite de la vente") {
        $(".nom").val("");
  $(".adresse").val("");
  $(".telephone").val("");
    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllVentePiece('#example1');
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
function confirmSuppressionVentePiece(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_livraison/deleteVentePiece",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllVentePiece('#example1');
        
          
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

function infosClient1(id_client,nom,adresse,telephone,libelle,id_operation,code_camion,leClient){
  $(".piece").val(nom);
  $(".leClient").val(leClient);
  $(".operation").val(id_operation);
  $(".camion").val(code_camion);
  $(".libelle").val(libelle);
  $(".date_piece").val(adresse);
  $(".montant").val(telephone);
  $(".id_client").val(id_client);
  $(".btnAnnulerModif").fadeIn();
  $(".btnModifClient").fadeIn();
  $(".btnAddClient").fadeOut();
  getDescriptionOperation();
}

function annulerModifClient1(){
$(".btnAnnulerModif").fadeOut();
  $(".btnModifClient").fadeOut();
  $(".btnAddClient").fadeIn();
}

function afficheAllVentePiece(idTable){
  $(".chargementClient").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_livraison/getAllVentePiece",
      data:{},
      success: function(data){

        $(".contentLivraison").empty();
        $(".contentLivraison").append(data);
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

