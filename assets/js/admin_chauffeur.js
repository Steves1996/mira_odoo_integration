base_url = "http://localhost/miratransport/";
function ceerDatatable(id){
  table = $(id).DataTable({
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      // "info": true,
      "autoWidth": false,
      // "responsive": true,
      // "responsive": true,
      // "autoWidth": true,
       "fixedHeader": {
            "header": true,
            "footer": true
        },
      "autoPrint": true,
       dom: 'Bfrtip',
        buttons: [
         { 
            extend: "print",
            text: "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Imprimer</span>",
            className: "btn btn-white btn-primary btn-bold",
            autoPrint: true,
            footer:true,
            title:"",
            message: '<table><thead><tr style="text-align:center;"><th style="width:200px;"> </th> <th style="border: 5px solid #0e2d86; border-right: none; border-left: none;"> </th><th colspan="10" style="text-align: center; border: 5px solid #0e2d86; border-left: none; border-right: none;"><span style="color: blue; font-weight: bold; font-size: 55px; text-align: center; "><img src="'+base_url+'/assets/image/mira.jpg" style="width: 150px; margin-left: -5px;">SOCIETE MIRA S.A</span>  <br> <table cellpadding="0" cellspacing="0"><tr><td colspan="12">Négoce - Import - Export - Matériaux de construction - Représentation - Activités industrielles - Activités maritimes - BTP - Transport</td></tr> </table></th><th style="border: 5px solid #0e2d86; border-left: none; border-right: none;"></th></tr><thead></table>'
            },
            {
            extend: "pdf",
            footer:true,
            text: "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Exporte en pdf</span>",
            className: "btn btn-white btn-primary btn-bold"
            },
            {
            extend: 'excelHtml5',
            autoFilter: true,
            footer:true,
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

function demandeSuppressionDocument(table,identifiant,nom_id){
 $(".table").val();
 $(".identifiant").val();
 $(".nom_id").val();
 $(".table").val(table);
 $(".identifiant").val(identifiant);
 $(".nom_id").val(nom_id);
  // alert("la table est: "+table+" et identifiant: "+identifiant);
}
function selectAllChauffeur(idTable){
	$(".chargementChauffeur1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/getAllChauffeur",
      data:{},
      success: function(data){

        $(".contentChauffeur").empty();
        $(".contentChauffeur").append(data);
        ceerDatatable(idTable)
        $(".chargementChauffeur1").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementChauffeur1").fadeOut();
       }
       });
}
function getSalaireChauffeur(){
	$(".chargementChauffeur1").fadeIn();
	code_camion = $(".camion").val();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/getSalaireChauffeur",
      data:{"code_camion":code_camion},
      success: function(data){
      // alert(data);
        $(".salaire").val("");
        formatMillierPourSelection(data,"salaire");
       
        $(".chargementChauffeur1").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementChauffeur1").fadeOut();
       }
       });
}

function getChauffeurParCodeCamion(){
	getSalaireChauffeur()
	$(".chargementChauffeur1").fadeIn();
	code_camion = $(".camion").val();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/getChauffeurParCodeCamion",
      data:{"code_camion":code_camion},
      success: function(data){
      // alert(data);
        $(".contentChauffeur").empty();
        $(".contentChauffeur").append(data);
        // ceerDatatable(idTable)
        $(".chargementChauffeur1").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementChauffeur1").fadeOut();
       }
       });
}

function getChauffeurParCodeCamion2(){

	$(".chargementChauffeur1").fadeIn();
	code_camion = $(".camion").val();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/getChauffeurParCodeCamion",
      data:{"code_camion":code_camion},
      success: function(data){
      // alert(data);
      data2 =data;
        $(".contentChauffeur").empty();
        $(".contentChauffeur").append(data2);
        // ceerDatatable(idTable)
        getBalanceChauffeur(); 
        $(".chargementChauffeur1").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementChauffeur1").fadeOut();
       }
       });
}
function confirmSuppression(){
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
        selectAllChauffeur('#example1');   
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


function confirmSuppressionChauffeur(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/deleteChauffeur",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        selectAllChauffeur('#example1');   
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
function addChauffeur(status){
	file_chauffeur = $(".file_chauffeur")[0].files[0];
	file_assistant = $(".file_assistant")[0].files[0];
	telephoneChauffeur = $(".telephoneChauffeur").val();
	telephoneAssistant = $(".telephoneAssistant").val();
	nomChauffeur = $(".nomChauffeur").val();
	nomAssistant = $(".nomAssistant").val();
	cniChauffeur = $(".cniChauffeur").val();
	cniAssistant = $(".cniAssistant").val();
	expirationCNIChauffeur = $(".expirationCNIChauffeur").val();
	expirationPermisChauffeur = $(".expirationPermisChauffeur").val();
	id_chauffeur = $(".id_chauffeur").val();
	expirationCNIAssistant = $(".expirationCNIAssistant").val();
	permisChauffeur = $(".permisChauffeur").val();
	ancienTelephone=$(".ancienTelephone").val();
	salaire=$(".salaire").val();
	salaire_ass=$(".salaire_ass").val();
  retenueSalariale = $(".retenueSalariale").val();
  retenueSalarialeAss = $(".retenueSalarialeAss").val();
  date_init = $(".dateInitialisation").val();
  montant_init =$(".montantInitialisation").val();
	if (nomChauffeur == "") {
		$(".nomChauffeur").css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");

	}else if (nomAssistant == "") {
		$(".nomAssistant").css("border","1px solid red");
		    toastr.error("Veuillez remplir tous les Champs");

	}else if (date_init == "") {
    $(".date_init").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (montant_init == "") {
    $(".montant_init").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }
  else if (telephoneChauffeur == "") {
		$(".telephoneChauffeur").css("border","1px solid red");
		    toastr.error("Veuillez remplir tous les Champs");

	}else{
		// alert(expirationCNIAssistant);
    $(".date_init").css("border","1px solid #ced4da");
    $(".montant_init").css("border","1px solid #ced4da");
		$(".telephoneChauffeur").css("border","1px solid #ced4da");
		$(".telephoneAssistant").css("border","1px solid #ced4da");
		$(".nomChauffeur").css("border","1px solid #ced4da");
		$(".nomAssistant").css("border","1px solid #ced4da");
		$(".expirationCNIChauffeur").css("border","1px solid #ced4da");
		$(".expirationPermisChauffeur").css("border","1px solid #ced4da");
		$(".expirationCNIAssistant").css("border","1px solid #ced4da");
		$(".permisChauffeur").css("border","1px solid #ced4da");
		$(".cniAssistant").css("border","1px solid #ced4da");
		$(".cniChauffeur").css("border","1px solid #ced4da");
		$(".chargementChauffeur").fadeIn();
		 let files = new FormData();

  files.append('file_assistant',file_assistant);
  files.append('file_chauffeur',file_chauffeur);
  files.append('id_chauffeur',id_chauffeur);
  files.append('salaire',salaire);
  files.append('salaire_ass',salaire_ass);
  files.append('status',status);
  files.append('telephoneChauffeur',telephoneChauffeur);
  files.append('telephoneAssistant',telephoneAssistant);
  files.append('cniChauffeur',cniChauffeur);
  files.append('cniAssistant',cniAssistant);
  files.append('expirationPermisChauffeur',expirationPermisChauffeur);
  files.append('permisChauffeur',permisChauffeur);
  files.append('expirationCNIChauffeur',expirationCNIChauffeur);
  files.append('expirationCNIAssistant',expirationCNIAssistant);
  files.append('nomAssistant',nomAssistant);
  files.append('nomChauffeur',nomChauffeur);
  files.append('ancienTelephone',ancienTelephone);
  files.append('retenueSalariale',retenueSalariale);
  files.append('retenueSalarialeAss',retenueSalarialeAss);
    files.append('date_init',date_init);
  files.append('montant_init',montant_init);
		  $.ajax({
		      type:"POST",
		      processData: false,
        	  contentType: false,
		      url:base_url+"/admin_chauffeur/addChauffeur",
			  data:files,
		      success: function(data){
		      	if ($.trim(data) == "Insertion parfaite du Chauffeur") {
		      		$(".chargementChauffeur").fadeOut();
		      	 $(document).Toasts('create', {
		        class: 'bg-success', 
		        title: 'Success',
		        subtitle: 'Alert',
		        body: data
		      }) 
	$(".telephoneChauffeur").val("");
	$(".telephoneAssistant").val("");
	$(".nomChauffeur").val("");
	$(".nomAssistant").val("");
	$(".cniChauffeur").val("");
	$(".cniAssistant").val("");
	$(".expirationCNIChauffeur").val("");
	$(".expirationPermisChauffeur").val("");
	$(".expirationCNIAssistant").val("");
		      	 selectAllChauffeur("#exemple1");
		      	}else if ($.trim(data) == "Modification parfaite du Chauffeur") {
		      		$(".chargementChauffeur").fadeOut();
		      	 $(document).Toasts('create', {
		        class: 'bg-success', 
		        title: 'Success',
		        subtitle: 'Alert',
		        body: data
		      }) 
	$(".telephoneChauffeur").val("");
	$(".telephoneAssistant").val("");
	$(".nomChauffeur").val("");
	$(".nomAssistant").val("");
	$(".cniChauffeur").val("");
	$(".cniAssistant").val("");
	$(".expirationCNIChauffeur").val("");
	$(".expirationPermisChauffeur").val("");
	$(".expirationCNIAssistant").val("");
		      	 selectAllChauffeur("#exemple1");
		      	} else{
		      		alert(data);
		      	$(".chargementChauffeur").fadeOut();
		      	  $(document).Toasts('create', {
		        class: 'bg-danger', 
		        title: 'Erreur de connexion',
		        subtitle: 'Alert',
		        body:data
		      })	
		      	}
		      	
		      },
		       error:function(data){
		       	$(".chargementChauffeur").fadeOut();
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

}

function infosChauffeur(id_chauffeur,permisChauffeur,telephoneChauffeur,telephoneAssistant,nomChauffeur,nomAssistant,cniChauffeur,cniAssistant,expirationCNIAssistant,expirationCNIChauffeur,expirationPermisChauffeur,photoChauffeur,photoAssistant,libelle,salaire_ass,date_init,montant_init,retenueSalariale,retenueSalarialeAss){
	
	$(".salaire").val(libelle);
  $(".retenueSalariale").val(retenueSalariale);
   $(".retenueSalarialeAss").val(retenueSalarialeAss);
	$(".salaire_ass").val(salaire_ass);
	$(".telephoneChauffeur").val(telephoneChauffeur);
	$(".ancienTelephone").val(telephoneChauffeur);
	$(".telephoneAssistant").val(telephoneAssistant);
	$(".nomChauffeur").val(nomChauffeur);
	$(".nomAssistant").val(nomAssistant);
	$(".cniChauffeur").val(cniChauffeur);
	$(".cniAssistant").val(cniAssistant);
	$(".expirationCNIChauffeur").val(expirationCNIChauffeur);
	$(".expirationPermisChauffeur").val(expirationPermisChauffeur);
	$(".expirationCNIAssistant").val(expirationCNIAssistant);
	$(".permisChauffeur").val(permisChauffeur);
	$(".id_chauffeur").val(id_chauffeur);
  $(".dateInitialisation").val(date_init);
  $(".montantInitialisation").val(montant_init);
	$(".btnAddChauffeur").fadeOut();
	$(".btnUpdateChauffeur").fadeIn();
	$(".btnAnnuleChauffeur").fadeIn();
	document.getElementById('chauffeur').src = base_url+"/assets/chauffeur/"+telephoneChauffeur+"/"+photoChauffeur;

	document.getElementById('blah').src = base_url+"/assets/chauffeur/"+telephoneChauffeur+"/"+photoAssistant;

}
 function annulerModifChauffeur(){
 	$(".btnAddChauffeur").fadeIn();
	$(".btnUpdateChauffeur").fadeOut();
	$(".btnAnnuleChauffeur").fadeOut();
 }
function updateChauffeur(){
	nomChauffeur = $(".nomChauffeur").val();
	ancienTelephone = $(".ancienTelephone").val();
	nomAssistant = $(".nomAssistant").val();
	cniChauffeur = $(".cniChauffeur").val();
	cniAssistant = $(".cniAssistant").val();
	expirationCNIChauffeur = $(".expirationCNIChauffeur").val();
	expirationPermisChauffeur = $(".expirationPermisChauffeur").val();

	expirationCNIAssistant = $(".expirationCNIAssistant").val();
	expirationPermisAssistant = $(".expirationPermisAssistant").val();

	if (nomChauffeur == "") {
		$(".nomChauffeur").css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");

	}else if (nomAssistant == "") {
		$(".nomAssistant").css("border","1px solid red");
		    toastr.error("Veuillez remplir tous les Champs");

	}else if (expirationCNIAssistant == "") {
		$(".expirationCNIAssistant").css("border","1px solid red");
		    toastr.error("Veuillez remplir tous les Champs");

	}else if (expirationCNIChauffeur == "") {

		$(".expirationCNIChauffeur").css("border","1px solid red");
		    toastr.error("Veuillez remplir tous les Champs");

	}else if (expirationPermisAssistant == "") {

		$(".expirationPermisAssistant").css("border","1px solid red");
		    toastr.error("Veuillez remplir tous les Champs");

	}else if (expirationPermisChauffeur == "") {
		$(".expirationPermisChauffeur").css("border","1px solid red");
		    toastr.error("Veuillez remplir tous les Champs");


	}else if (cniChauffeur == "") {
		$(".cniChauffeur").css("border","1px solid red");
		    toastr.error("Veuillez remplir tous les Champs");

	}else if (cniAssistant == "") {
		$(".cniAssistant").css("border","1px solid red");
		    toastr.error("Veuillez remplir tous les Champs");

	}else{
		// alert(expirationCNIAssistant);
		$(".nomChauffeur").css("border","1px solid #ced4da");
		$(".nomAssistant").css("border","1px solid #ced4da");
		$(".expirationCNIChauffeur").css("border","1px solid #ced4da");
		$(".expirationPermisChauffeur").css("border","1px solid #ced4da");
		$(".expirationCNIAssistant").css("border","1px solid #ced4da");
		$(".expirationPermisAssistant").css("border","1px solid #ced4da");
		$(".cniAssistant").css("border","1px solid #ced4da");
		$(".cniChauffeur").css("border","1px solid #ced4da");
		$(".chargementChauffeur").fadeIn();
		alert(ancienTelephone);
		  $.ajax({
		      type:"POST",
		      url:base_url+"/admin_chauffeur/updateChauffeur1",
		      data:{"ancienTelephone":ancienTelephone,"cniChauffeur":cniChauffeur,"cniAssistant":cniAssistant,"expirationPermisChauffeur":expirationPermisChauffeur,"expirationPermisAssistant":expirationPermisAssistant,"expirationCNIChauffeur":expirationCNIChauffeur,"expirationCNIAssistant":expirationCNIAssistant,"nomAssistant":nomAssistant,"nomChauffeur":nomChauffeur},
		      success: function(data){
		      	$(".chargementChauffeur").fadeOut();
		      	 $(document).Toasts('create', {
		        class: 'bg-success', 
		        title: 'Success',
		        subtitle: 'Alert',
		        body: data
		      }) 
		      	 selectAllChauffeur("#exemple1");
		      },
		       error:function(data){
		       	$(".chargementChauffeur").fadeOut();
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

function getAllImputation(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut !="" && date_fin !="") {
    $('#example1').DataTable().destroy();
  afficheAllImputationSalaire('#example1');
  }
  
}

function getAllImputation1(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut !="" && date_fin !="") {
    $('#example1').DataTable().destroy();
  afficheAllReglementSalaire('#example1');
  }
  
}

function afficheAllImputationSalaire(idTable){
	
	 id_fournisseur1 = $(".id_fournisseur1").val();
	 id_fournisseur2 = $(".id_fournisseur2").val();
	date_debut = $(".date_debut").val();
	date_fin = $(".date_fin").val();
	
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/getAllImputationSalaire",
      data:{"date_fin":date_fin,"date_debut":date_debut,"id_fournisseur2":id_fournisseur2},
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
function afficheAllReglementSalaire(idTable){
	
	id_fournisseur1 = $(".id_fournisseur1").val();
	id_fournisseur2 = $(".id_fournisseur2").val();
	date_debut = $(".date_debut").val();
	date_fin = $(".date_fin").val();
	
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/getAllReglementImputation",
      data:{"date_fin":date_fin,"date_debut":date_debut,"id_fournisseur2":id_fournisseur2},
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

function addImputationChauffeur(status){
  montant = $(".montant").val();
  cible = $(".cible").val();
  
  date = $(".dateImputation").val();
  id_chauffeur = $(".contentChauffeur").val();
  salaire = $(".salaire").val();
  raison = $(".raison").val();
  id_facture = $(".id_prime").val();

  if (montant == "") {
  $(".montant").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
  }else if (date == "") {
  $(".dateImputation").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (raison == "") {
  $(".numero").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else{
  $(".retenurSalariale").css("border","1px solid #ced4da");
  $(".raison").css("border","1px solid #ced4da");
  $(".montant").css("border","1px solid #ced4da");
  $(".dateImputation").css("border","1px solid #ced4da");
  $(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
   $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/addImputationChauffeur",
      data:{"cible":cible,"id_imputation":id_facture,"status":status,"montant":montant,"salaire":salaire,"raison":raison,"id_chauffeur":id_chauffeur,"date":date},
      success: function(data){  

        if ($.trim(data) == "Insertion parfaite de l'imputation") {
        $('#example1').DataTable().destroy();
        afficheAllImputationSalaire('#example1');
          $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
	$(".chargementPrime1").fadeOut();
        }else if ($.trim(data) == "Imputation modifiée") {

        $('#example1').DataTable().destroy();
        afficheAllImputationSalaire('#example1');
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

function infosFacture(id_imputation,raison,date,salaire,montant,contentChauffeur){
 $(".contentChauffeur").empty();
 $(".contentChauffeur").append(contentChauffeur);
 $(".montant").val(montant);
 $(".dateImputation").val(date);
 $(".raison").val(raison);
 $(".salaire").val(salaire);
 $(".id_prime").val(id_imputation);


  $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAdd").fadeOut();
}

function infosImputation(id_imputation,raison,date,salaire,montant,contentChauffeur,cible){
 $(".contentChauffeur").empty();

 $(".contentChauffeur").append(contentChauffeur);
 $(".montant").val(montant);
 $(".dateImputation").val(date);
 $(".cible").val(cible);
 $(".raison").val(raison);
 $(".salaire").val(salaire);
 $(".id_prime").val(id_imputation);


  $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAdd").fadeOut();
}
function afficheAllFactureArticle(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_article/getAllFactureArticle",
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

function addReglementImputation(status){
  montant = $(".montant").val();
  cible = $(".cible").val();
  date = $(".dateImputation").val();
  id_chauffeur = $(".contentChauffeur").val();
  salaire = $(".salaire").val();
  raison = $(".raison").val();
  id_facture = $(".id_prime").val();
  regulation =  $(".regulation").val();

  if (montant == "") {
  $(".montant").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
  }else if (date == "") {
  $(".dateImputation").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (raison == "") {
  $(".numero").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (regulation == "") {
  $(".regulation").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else{
  $(".raison").css("border","1px solid #ced4da");
  $(".regulation").css("border","1px solid #ced4da");
  $(".montant").css("border","1px solid #ced4da");
  $(".dateImputation").css("border","1px solid #ced4da");
  $(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
   $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/addReglementImputation",
      data:{"cible":cible,"regulation":regulation,"id_imputation":id_facture,"status":status,"montant":montant,"salaire":salaire,"raison":raison,"id_chauffeur":id_chauffeur,"date":date},
      success: function(data){  

        if ($.trim(data) == "Insertion parfaite du règlement") {
        $('#example1').DataTable().destroy();
        afficheAllReglementSalaire('#example1');
          $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
	$(".chargementPrime1").fadeOut();
        }else if ($.trim(data) == "règlement modifiée") {

        $('#example1').DataTable().destroy();
        afficheAllReglementSalaire('#example1');
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

function confirmSuppressionFactureArticle(){
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
        afficheAllImputationSalaire('#example1');
        
          
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



function confirmSuppressionImputation(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/deleteImputation",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllImputationSalaire('#example1');
        
          
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
function confirmSuppressionReglementImputation(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/deleteReglementImputation",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllReglementSalaire('#example1');
        
          
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
function annulerSuppressionGazoil(){
	$(".btnAdd").fadeIn();
	$(".btnModif").fadeOut();
	$(".btnAnnuler").fadeOut();
}

function afficheAllReglementPourBalanceArticle(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/getAllReglementPourBalanceArticle",
      data:{"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){

        $(".contentPrime2").empty();
        $(".contentPrime2").append(data);
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


function afficheAllFActurePourBalanceArticle(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/getAllFacturePourBalanceArticle",
      data:{"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){

        $(".contentPrime1").empty();
        $(".contentPrime1").append(data);
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

function selectAllTotalFacturePourBalanceFournisseur(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/selectAllTotalFacturePourBalanceFournisseur",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".totalFacture").val("");
        formatMillierPourSelection(data,'totalFacture');
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

function selectAllTotalReglementPourBalanceFournisseur(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/selectAllTotalReglementPourBalanceFournisseur",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".totalReglement").val("");
        formatMillierPourSelection(data,'totalReglement');
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
function soldeCaisseFournisseur(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/soldeArticleFournisseur",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".solde").val("");
        formatMillierPourSelection(data,'solde');
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
function getMontantInitialParChauffeur(id_fournisseur){
code_camion = $(".camion").val();
  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/getMontantInitialParChauffeur",
      data:{"id_fournisseur":id_fournisseur },
      success: function(data){
        // alert(data);
       formatMillierPourSelection(data,'montant_init');
        // formAddRemorque();
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

function getDateInitialParChauffeur(id_fournisseur){
code_camion = $(".camion").val();
  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/getDateInitialParChauffeur",
      data:{"id_fournisseur":id_fournisseur},
      success: function(data){
        // alert(data);
        $(".date_init").val("");
       $(".date_init").val(data);
        // formAddRemorque();
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
function getBalanceChauffeur(){
	 // getChauffeurParCodeCamion(); 
  id_fournisseur = $(".id_fournisseur").val();
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (id_fournisseur == "" && date_debut == "" && date_fin == "") {

  }else{

  soldeCaisseFournisseur(id_fournisseur,date_debut,date_fin);
  selectAllTotalFacturePourBalanceFournisseur(id_fournisseur,date_debut,date_fin);
  selectAllTotalReglementPourBalanceFournisseur(id_fournisseur,date_debut,date_fin);
    
    $('#example2').DataTable().destroy();
  afficheAllFActurePourBalanceArticle('#example2',id_fournisseur,date_debut,date_fin);

  $('#example1').DataTable().destroy();
  afficheAllReglementPourBalanceArticle('#example1',id_fournisseur,date_debut,date_fin);

  getDateInitialParChauffeur(id_fournisseur);

  getMontantInitialParChauffeur(id_fournisseur);
  }
}


function getPaieChauffeur(){
   // getChauffeurParCodeCamion(); 
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut == "" && date_fin == "") {

  }else{
$(".chargementPrime").fadeIn();
 $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/getPaieChauffeur",
      data:{"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){  
        // alert(data);
        $('#example1').DataTable().destroy();
        $(".contentPrime").empty();
        $(".contentPrime").append(data);
        // ceerDatatable('#example1');

        getTotalPaieChauffeur();

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
}

function getPaieChauffeurType(idTable){
  
   // getChauffeurParCodeCamion(); 
  code_camion = $(".code_camion").val();
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  
  if (date_debut == "" && date_fin == "") {

  }else{
$(".chargementPrime").fadeIn();
 $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/getPaieChauffeurType",
      data:{"code_camion":code_camion,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){  
        // alert(data);
        $('#example1').DataTable().destroy();
        $(".contentPrime").empty();
        $(".contentPrime").append(data);
        // ceerDatatable('#example1');
 
        getTotalPaieChauffeurType();

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
}

function getTotalPaieChauffeur(){
   // getChauffeurParCodeCamion(); 
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut == "" && date_fin == "") {

  }else{
$(".chargementPrime").fadeIn();
 $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/getTotalPaieChauffeur",
      data:{"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){  
        // alert(data);
        // $('#example1').DataTable().destroy();
        $(".footerPaie").empty();
        $(".footerPaie").append(data);
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
       }
       });
  }
}

function getTotalPaieChauffeurType(){
  code_camion = $(".code_camion").val();
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut == "" && date_fin == "") {

  }else{
$(".chargementPrime").fadeIn();
 $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/getTotalPaieChauffeurType",
      data:{"code_camion":code_camion,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){  
        // alert(data);
        // $('#example1').DataTable().destroy();
        $(".footerPaie").empty();
        $(".footerPaie").append(data);
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
       }
       });
  }
}


function getSommeIputation(){
   // getChauffeurParCodeCamion(); 
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut == "" && date_fin == "") {

  }else{
$(".chargementPrime").fadeIn();
 $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/getSommeIputation",
      data:{"date_debut":date_debut,"date_fin":date_fin},
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
       }
       });
  }
}
function afficheAllEtatChauffeur(idTable){
  $(".chargementChauffeur1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/afficheAllEtatChauffeur",
      data:{},
      success: function(data){

        $(".contentChauffeur").empty();
        $(".contentChauffeur").append(data);
        ceerDatatable(idTable)
        $(".chargementChauffeur1").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementChauffeur1").fadeOut();
       }
       });
}

function addEtatSalaireChauffeur(ref,id_chauffeur,type,classe,status){
  compteur= $('.compteur').val();
  if ($('.'+classe).is(':checked') == true) {
    if (type=='salaire') {
      valeur = 1;
    }else if (type == "salaire_gps") {
      valeur = 1;
    }else if (type == "gps") {
      valeur = 1;
    }else if (type == "salaire_ass") {
      valeur = 1;
    }else{
      valeur = 0;
    }
  }else {
    valeur=0;
  }

// alert(classe);
   $.ajax({
      type:"POST",
      url:base_url+"/admin_chauffeur/addEtatSalaireChauffeur",
      data:{"id_chauffeur":id_chauffeur,"type":type,"valeur":valeur,"ref":ref,"status":status},
      success: function(data){  

        if ($.trim(data) == "Opération réussie") {
        $('#example1').DataTable().destroy();
        afficheAllEtatChauffeur('#example1');
          $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
  $(".chargementPrime1").fadeOut();
        }else if ($.trim(data) == "modification réussie") {

        $('#example1').DataTable().destroy();
        afficheAllEtatChauffeur('#example1');
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