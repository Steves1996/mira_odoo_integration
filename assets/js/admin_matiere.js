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


function afficheAllFournisseurMatiere(idTable){
  $(".chargementClient").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getAllFournisseurMatiere",
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

function addFournisseurMatiere(status){
  // alert(status);
  commentaire = $(".commentaire").val();
  nom = $(".nom").val();
  adresse = $(".adresse").val();
  telephone = $(".telephone").val();
  date_initial = $(".date_initial").val();
  solde_initial = $(".solde_initial").val();
  id_client = $(".id_client").val();
  if (nom == "") {
    $(".nom").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (adresse == "") {
    $(".adresse").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (telephone == "") {
    $(".telephone").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else{
    $(".nom").css("border","1px solid #ced4da");
    $(".adresse").css("border","1px solid #ced4da");
    $(".telephone").css("border","1px solid #ced4da");
$(".chargementCarteGrise1").fadeIn();
     $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/addFournisseurMatiere",
      data:{"commentaire":commentaire,"status":status,"id_client":id_client,"nom":nom,"adresse":adresse,"telephone":telephone, "date_initial":date_initial,"solde_initial":solde_initial},
       success: function(data){
   if ($.trim(data) == "Insertion parfaite du fournisseur") {
    $(".nom").val("");
  $(".adresse").val("");
  $(".telephone").val("");
   $(".solde").val("0");
    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllFournisseurMatiere('#example1');
        $(".chargementCarteGrise1").fadeOut();
      }else if ($.trim(data) == "Modification parfaite du fournisseur") {
        $(".nom").val("");
  $(".adresse").val("");
  $(".telephone").val("");
   $(".solde").val("0");
    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllFournisseurMatiere('#example1');
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

function confirmSuppressionFournisseurMatiere(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/deleteFournisseurMatiere",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllFournisseurMatiere('#example1');
        
          
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

function infosClient1(id_client,nom,adresse,telephone,solde_initial,date_initial,commentaire){
  $(".commentaire").val(commentaire);
  $(".nom").val(nom);
  $(".adresse").val(adresse);
  $(".telephone").val(telephone);
  $(".solde_initial").val(solde_initial);
  $(".date_initial").val(date_initial);
  $(".id_client").val(id_client);
  $(".btnAnnulerModif").fadeIn();
  $(".btnModifClient").fadeIn();
  $(".btnAddClient").fadeOut();
}

function annulerModifClient1(){
$(".btnAnnulerModif").fadeOut();
  $(".btnModifClient").fadeOut();
  $(".btnAddClient").fadeIn();
}

function afficheAllClient(idTable){
  $(".chargementClient").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getAllClient",
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
      url:base_url+"/admin_matiere/addClient",
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
      url:base_url+"/admin_matiere/deleteClient",
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


function infosClient(id_client,nom,adresse,telephone,nui,date_init,montant_init){
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

function annulerModifClient(){
$(".btnAnnulerModif").fadeOut();
	$(".btnModifClient").fadeOut();
	$(".btnAddClient").fadeIn();
}


// nous passons donc à la facture

function infosFacture(id_facture,numero,date,libelle,montant,fournisseur){
 $(".montant").val(montant);
 $(".dateFacture").val(date);
 $(".numero").val(numero);
 $(".libelle").val(libelle);
 $(".id_gazoil").val(fournisseur);
 
 $(".id_prime").val(id_facture);
 $(".libelle").val(libelle);

  $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAdd").fadeOut();
}

function getFactureVenteParDate(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut!="" && date_fin!="") {
    $('#example1').DataTable().destroy();
  afficheAllFactureMatiere('#example1');
  }
  
}



function addFactureMatiere(status){
  montant = $(".montant").val();
  dateFacture = $(".dateFacture").val();
  facture = $(".facture").val();
  fournisseur = $(".fournisseur").val();
  libelle = $(".libelle").val();
  id_facture = $(".id_prime").val();
  if (montant == "") {
  $(".montant").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
  }else if (dateFacture == "") {
  $(".dateFacture").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (facture == "") {
  $(".facture").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (libelle == "") {
  $(".libelle").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else{
  $(".libelle").css("border","1px solid #ced4da");
  $(".montant").css("border","1px solid #ced4da");
  $(".dateFacture").css("border","1px solid #ced4da");
  $(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
   $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/addFactureMatiere",
      data:{"fournisseur":fournisseur,"id_facture":id_facture,"status":status,"montant":montant,"facture":facture,"dateFacture":dateFacture,"libelle":libelle},
      success: function(data){  

        if ($.trim(data) == "Insertion parfaite de la facture") {
        $('#example1').DataTable().destroy();
        afficheAllFactureMatiere('#example1');
          $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
        }else if ($.trim(data) == "Facture modifiée") {

        $('#example1').DataTable().destroy();
        afficheAllFactureMatiere('#example1');
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

function afficheAllFactureMatiere(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getAllFactureMatiere",
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

function confirmSuppressionFactureMatiere(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/deleteFactureMatiere",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllFactureMatiere('#example1');
        
          
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


// Reglement


function addReglementMatiere(status){
  montant = $(".montant").val();
  date = $(".dateFacture").val();
  numero = $(".numero").val();
  id_gazoil = $(".id_gazoil").val();
  libelle = $(".libelle").val();
  id_regl = $(".id_prime").val();

  if (montant == "") {
  $(".montant").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
  }else if (date == "") {
  $(".dateFacture").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (numero == "") {
  $(".numero").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (libelle == "") {
  $(".libelle").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (id_gazoil== "") {
  $(".id_gazoil").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }
  else{
  $(".numero").css("border","1px solid #ced4da");
  $(".libelle").css("border","1px solid #ced4da");
  $(".montant").css("border","1px solid #ced4da");
  $(".id_gazoil").css("border","1px solid #ced4da");
  $(".dateFacture").css("border","1px solid #ced4da");
  $(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
   $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/addReglement",
      data:{"id_fournisseur":id_gazoil,"id_facture":id_regl,"status":status,"montant":montant,"numero":numero,"date":date,"libelle":libelle},
      success: function(data){  

        if ($.trim(data) == "Règlement de la facture effectué") {

        $('#example1').DataTable().destroy();
        afficheAllReglementMatiere('#example1');
          $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
        }else if ($.trim(data) == "Règlement modifié") {

        $('#example1').DataTable().destroy();
        afficheAllReglementMatiere('#example1');
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

function addReglementMatiere1(status){
  montant = $(".montant").val();
  date = $(".dateFacture").val();
  numero = $(".numero").val();
  id_gazoil = $(".id_gazoil").val();
  libelle = $(".libelle").val();
  id_regl = $(".id_prime").val();

  if (montant == "") {
  $(".montant").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
  }else if (date == "") {
  $(".dateFacture").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (numero == "") {
  $(".numero").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (libelle == "") {
  $(".libelle").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (id_gazoil== "") {
  $(".id_gazoil").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }
  else{
  $(".numero").css("border","1px solid #ced4da");
  $(".libelle").css("border","1px solid #ced4da");
  $(".montant").css("border","1px solid #ced4da");
  $(".id_gazoil").css("border","1px solid #ced4da");
  $(".dateFacture").css("border","1px solid #ced4da");
  $(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
   $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/addReglement1",
      data:{"id_fournisseur":id_gazoil,"id_facture":id_regl,"status":status,"montant":montant,"numero":numero,"date":date,"libelle":libelle},
      success: function(data){  

        if ($.trim(data) == "Règlement de la facture effectué") {

        $('#example1').DataTable().destroy();
        afficheAllReglementMatiere1('#example1');
          $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
        }else if ($.trim(data) == "Règlement modifié") {

        $('#example1').DataTable().destroy();
        afficheAllReglementMatiere1('#example1');
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

function afficheAllReglementMatiere(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getAllReglement",
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

function afficheAllReglementMatiere1(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getAllReglement1",
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

function confirmSuppressionReglementAchat(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/deleteReglementFournisseurMatiere",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllReglementMatiere('#example1');
        
          
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

function confirmSuppressionReglementVente(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/deleteReglementClientMatiere",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllReglementMatiere1('#example1');
        
          
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

function getBalanceImprimableClient2(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getBalanceImprimableClient",
      data:{"id_client":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
// alert(data);
        $(".contentClient").empty();
        $(".contentClient").append(data);
        ceerDatatable2(idTable)
        $(".chargementClient").fadeOut();
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

function getBalanceImprimableClient2_1(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getBalanceImprimableClient1",
      data:{"id_client":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
// alert(data);
        $(".contentClient").empty();
        $(".contentClient").append(data);
        ceerDatatable2(idTable)
        $(".chargementClient").fadeOut();
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

function ceerDatatable2(id){
  table = $(id).DataTable({
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      // "info": true,
      "autoWidth": false,
      // "responsive": true,
      // "responsive": true,
      // "autoWidth": true,
      "autoPrint": true,
       dom: 'Bfrtip',
        buttons: [
         {
            extend: "print",
            customize: function ( win ) {
                    // $(win.document.body)
                    //     .css( 'color', 'bleu' )
                    //     .prepend(
                    //         '<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />'
                    //     );
 
                }
            ,
            text: "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Imprimer</span>",
            className: "btn btn-white btn-primary btn-bold",
            autoPrint: true,
            message: document.getElementById('zone2').innerHTML,
            title:'',
          },
            {
            extend: "pdf",
            text: "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Exporter en pdf</span>",
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


function repportNouveau(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/repportNouveau",
      data:{"id_client":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".repportNouveau").val("");
        formatMillierPourSelection(data,'repportNouveau');
         nombre = data;
          nombre = nombre.replace(/ /g,'');
       nombre +='';

      var sep = ' ';
      var reg = /(\d+)(\d{3})/;

      while( reg.test( nombre )){
        nombre = nombre.replace(reg,'$1'+sep+'$2');
      } 
  
       $(".repportNouveau1").empty();
       $(".repportNouveau1").append(nombre +" FCFA("+NumberToLetter(data)+" FCFA)");
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

function repportNouveau1(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/repportNouveau1",
      data:{"id_client":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".repportNouveau").val("");
        formatMillierPourSelection(data,'repportNouveau');
         nombre = data;
          nombre = nombre.replace(/ /g,'');
       nombre +='';

      var sep = ' ';
      var reg = /(\d+)(\d{3})/;

      while( reg.test( nombre )){
        nombre = nombre.replace(reg,'$1'+sep+'$2');
      } 
  
       $(".repportNouveau1").empty();
       $(".repportNouveau1").append(nombre +" FCFA("+NumberToLetter(data)+" FCFA)");
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




function repportNouveauDebit(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/repportNouveauDebit",
      data:{"id_client":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".repportNouveauDebit").val("");
        formatMillierPourSelection(data,'repportNouveauDebit');
         nombre = data;
          nombre = nombre.replace(/ /g,'');
       nombre +='';

      var sep = ' ';
      var reg = /(\d+)(\d{3})/;

      while( reg.test( nombre )){
        nombre = nombre.replace(reg,'$1'+sep+'$2');
      } 
  
       $(".repportNouveauDebit1").empty();
       $(".repportNouveauDebit1").append(nombre +" FCFA("+NumberToLetter(data)+" FCFA)");
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

function repportNouveauDebit1(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/repportNouveauDebit1",
      data:{"id_client":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".repportNouveauDebit").val("");
        formatMillierPourSelection(data,'repportNouveauDebit');
         nombre = data;
          nombre = nombre.replace(/ /g,'');
       nombre +='';

      var sep = ' ';
      var reg = /(\d+)(\d{3})/;

      while( reg.test( nombre )){
        nombre = nombre.replace(reg,'$1'+sep+'$2');
      } 
  
       $(".repportNouveauDebit1").empty();
       $(".repportNouveauDebit1").append(nombre +" FCFA("+NumberToLetter(data)+" FCFA)");
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


function repportNouveauCredit(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/repportNouveauCredit",
      data:{"id_client":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".repportNouveauCredit").val("");
        formatMillierPourSelection(data,'repportNouveauCredit');
         nombre = data;
          nombre = nombre.replace(/ /g,'');
       nombre +='';

      var sep = ' ';
      var reg = /(\d+)(\d{3})/;

      while( reg.test( nombre )){
        nombre = nombre.replace(reg,'$1'+sep+'$2');
      } 
  
       $(".repportNouveauCredit1").empty();
       $(".repportNouveauCredit1").append(nombre +" FCFA("+NumberToLetter(data)+" FCFA)");
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

function repportNouveauCredit1(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/repportNouveauCredit1",
      data:{"id_client":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".repportNouveauCredit").val("");
        formatMillierPourSelection(data,'repportNouveauCredit');
         nombre = data;
          nombre = nombre.replace(/ /g,'');
       nombre +='';

      var sep = ' ';
      var reg = /(\d+)(\d{3})/;

      while( reg.test( nombre )){
        nombre = nombre.replace(reg,'$1'+sep+'$2');
      } 
  
       $(".repportNouveauCredit1").empty();
       $(".repportNouveauCredit1").append(nombre +" FCFA("+NumberToLetter(data)+" FCFA)");
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


function getCreditPourBalanceImpCLient(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getCreditPourBalanceImpCLient",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".dedit").val("");
        formatMillierPourSelection(data,'dedit');
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

function getCreditPourBalanceImpCLient1(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getCreditPourBalanceImpCLient1",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".dedit").val("");
        formatMillierPourSelection(data,'dedit');
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


function getDebitPourBalanceImpCLient(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getDebitPourBalanceImpCLient",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".debit").val("");
        formatMillierPourSelection(data,'debit');
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

function getDebitPourBalanceImpCLient1(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getDebitPourBalanceImpCLient1",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".debit").val("");
        formatMillierPourSelection(data,'debit');
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




function getBalanceImprimableClient(){
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  id_fournisseur = $(".id_fournisseur").val();
getDateInitialClient(id_fournisseur);
getSoldeInitialClient(id_fournisseur);
getNomClient(id_fournisseur);
//getVilleClient(id_fournisseur);
getAdresseClient(id_fournisseur);
getTelephoneClient(id_fournisseur);
  if (id_fournisseur == "" && date_debut == "" && date_fin == "") {

  }else if (date_debut == "" || date_fin == "") {

  }
  else{

      $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/verifiDateInitialClient",
      data:{"date_initial":date_debut,"id_client":id_fournisseur},
      success: function(data){
        if ($.trim(data) == "ok") {
          // facturePourBalanceClient('test');
  $(".date_debut1").empty();
  $(".date_debut1").append(date_debut);

  $(".date_fin1").empty();
  $(".date_fin1").append(date_fin);
 
  soldeCaisseClient2(id_fournisseur,date_debut,date_fin);
  selectAllTotalAccuseRetraitPourBalanceClient(id_fournisseur,date_debut,date_fin);
  selectAllTotalAccuseReglementPourBalanceClient(id_fournisseur,date_debut,date_fin);

  $('#example1').DataTable().destroy();
  getBalanceImprimableClient2('#example1',id_fournisseur,date_debut,date_fin)
 
repportNouveau(id_fournisseur,date_debut,date_fin);
repportNouveauCredit(id_fournisseur,date_debut,date_fin);
repportNouveauDebit(id_fournisseur,date_debut,date_fin);
  getDebitPourBalanceImpCLient(id_fournisseur,date_debut,date_fin);
 getCreditPourBalanceImpCLient(id_fournisseur,date_debut,date_fin);
        }else{
    $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body:data
      }) 
  }
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

function getBalanceImprimableClient1(){
	
date_debut = $(".date_debut").val();
date_fin = $(".date_fin").val();
id_fournisseur = $(".id_fournisseur").val();
getDateInitialClient1(id_fournisseur);
getSoldeInitialClient1(id_fournisseur);
getNomClient1(id_fournisseur);
//getVilleClient(id_fournisseur);
getAdresseClient1(id_fournisseur);
getTelephoneClient1(id_fournisseur);
  if (id_fournisseur == "" && date_debut == "" && date_fin == "") {

  }else if (date_debut == "" || date_fin == "") {

  }
  else{

      $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/verifiDateInitialClient1",
      data:{"date_initial":date_debut,"id_client":id_fournisseur},
      success: function(data){
        if ($.trim(data) == "ok") {
          // facturePourBalanceClient('test');
  $(".date_debut1").empty();
  $(".date_debut1").append(date_debut);

  $(".date_fin1").empty();
  $(".date_fin1").append(date_fin);
 
  soldeCaisseClient2_1(id_fournisseur,date_debut,date_fin);
  selectAllTotalAccuseRetraitPourBalanceClient1(id_fournisseur,date_debut,date_fin);
  selectAllTotalAccuseReglementPourBalanceClient1(id_fournisseur,date_debut,date_fin);

  $('#example1').DataTable().destroy();
  getBalanceImprimableClient2_1('#example1',id_fournisseur,date_debut,date_fin)
 
repportNouveau1(id_fournisseur,date_debut,date_fin);
repportNouveauCredit1(id_fournisseur,date_debut,date_fin);
repportNouveauDebit1(id_fournisseur,date_debut,date_fin);
  getDebitPourBalanceImpCLient1(id_fournisseur,date_debut,date_fin);
 getCreditPourBalanceImpCLient1(id_fournisseur,date_debut,date_fin);
        }else{
    $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body:data
      }) 
  }
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



function getDateInitialClient(id_fournisseur){
  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getDateInitialClient",
      data:{"id_client":id_fournisseur},
      success: function(data){
        // alert(data);
        $(".date_initial").val("");
       $(".date_initial").val(data);

       $(".date_initial1").empty();
       $(".date_initial1").append(data);
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

function getDateInitialClient1(id_fournisseur){
  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getDateInitialClient1",
      data:{"id_client":id_fournisseur},
      success: function(data){
        // alert(data);
        $(".date_initial").val("");
       $(".date_initial").val(data);

       $(".date_initial1").empty();
       $(".date_initial1").append(data);
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

function getSoldeInitialClient(id_fournisseur){

  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getSoldeInitialClient",
      data:{"id_client":id_fournisseur },
      success: function(data){
        // alert(data);
       formatMillierPourSelection(data,'solde_initial');
       nombre = data;
          nombre = nombre.replace(/ /g,'');
       nombre +='';

      var sep = ' ';
      var reg = /(\d+)(\d{3})/;

      while( reg.test( nombre )){
        nombre = nombre.replace(reg,'$1'+sep+'$2');
      } 
  
       $(".solde_initial1").empty();
       $(".solde_initial1").append(nombre +" FCFA("+NumberToLetter(data)+" FCFA)");
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

function getSoldeInitialClient1(id_fournisseur){

  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getSoldeInitialClient1",
      data:{"id_client":id_fournisseur },
      success: function(data){
        // alert(data);
       formatMillierPourSelection(data,'solde_initial');
       nombre = data;
          nombre = nombre.replace(/ /g,'');
       nombre +='';

      var sep = ' ';
      var reg = /(\d+)(\d{3})/;

      while( reg.test( nombre )){
        nombre = nombre.replace(reg,'$1'+sep+'$2');
      } 
  
       $(".solde_initial1").empty();
       $(".solde_initial1").append(nombre +" FCFA("+NumberToLetter(data)+" FCFA)");
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


function getNomClient(id_fournisseur){
  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getNomClient",
      data:{"id_client":id_fournisseur},
      success: function(data){
        // alert(data);
        $(".client").empty();
       $(".client").append(data);

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

function getNomClient1(id_fournisseur){
  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getNomClient1",
      data:{"id_client":id_fournisseur},
      success: function(data){
        // alert(data);
        $(".client").empty();
       $(".client").append(data);

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

function getVilleClient(id_fournisseur){
  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getVilleClient",
      data:{"id_client":id_fournisseur},
      success: function(data){
        // alert(data);
        $(".villeClient").empty();
       $(".villeClient").append(data);
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

function getVilleClient1(id_fournisseur){
  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getVilleClient1",
      data:{"id_client":id_fournisseur},
      success: function(data){
        // alert(data);
        $(".villeClient").empty();
       $(".villeClient").append(data);
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
function getAdresseClient(id_fournisseur){
  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getAdresseClient",
      data:{"id_client":id_fournisseur},
      success: function(data){
        // alert(data);
       $(".adresseClient").empty();
       $(".adresseClient").append(data);

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

function getAdresseClient1(id_fournisseur){
  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getAdresseClient1",
      data:{"id_client":id_fournisseur},
      success: function(data){
        // alert(data);
       $(".adresseClient").empty();
       $(".adresseClient").append(data);

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

function getTelephoneClient(id_fournisseur){
  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getTelephoneClient",
      data:{"id_client":id_fournisseur},
      success: function(data){
        // alert(data);
        $(".telephoneClient").empty();
       $(".telephoneClient").append(data);
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

function getTelephoneClient1(id_fournisseur){
  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getTelephoneClient1",
      data:{"id_client":id_fournisseur},
      success: function(data){
        // alert(data);
        $(".telephoneClient").empty();
       $(".telephoneClient").append(data);
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


function soldeCaisseClient2(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/soldeCaisseClient2",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".solde").val("");
        formatMillierPourSelection(data,'solde');
         nombre = data;
          nombre = nombre.replace(/ /g,'');
       nombre +='';

      var sep = ' ';
      var reg = /(\d+)(\d{3})/;

      while( reg.test( nombre )){
        nombre = nombre.replace(reg,'$1'+sep+'$2');
      } 
  
       $(".solde1").empty();
       $(".solde1").append(nombre +" FCFA("+NumberToLetter(data)+" FCFA)");
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

function soldeCaisseClient2_1(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/soldeCaisseClient2_1",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".solde").val("");
        formatMillierPourSelection(data,'solde');
         nombre = data;
          nombre = nombre.replace(/ /g,'');
       nombre +='';

      var sep = ' ';
      var reg = /(\d+)(\d{3})/;

      while( reg.test( nombre )){
        nombre = nombre.replace(reg,'$1'+sep+'$2');
      } 
  
       $(".solde1").empty();
       $(".solde1").append(nombre +" FCFA("+NumberToLetter(data)+" FCFA)");
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





// le code qui suit est celui de la balance


function afficheAllReglementPourBalanceMatiere(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getAllReglementPourBalanceMatiere",
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
function afficheAllFActurePourBalanceMatiere(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getAllFacturePourBalanceMatiere",
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

  // totalReglement = $(".totalReglement").val();
  // totalFacture = $(".totalFacture").val();
  // total = parseInt(totalFacture)+parseInt(totalReglement);
  // $(".solde").val(total);

}
function selectAllTotalFacturePourBalanceFournisseur(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/selectAllTotalFacturePourBalanceFournisseur",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".totalFacture1").val("");
        formatMillierPourSelection(data,'totalFacture1');
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
      url:base_url+"/admin_matiere/selectAllTotalReglementPourBalanceFournisseur",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".totalReglement1").val("");
        formatMillierPourSelection(data,'totalReglement1');
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


function selectAllTotalAccuseRetraitPourBalanceClient(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getAllTotalAccuseRetraitPourBalance2",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".totalReglement").val("");
        formatMillierPourSelection(data,'totalReglement');
        $(".chargementPrime").fadeOut();

         nombre = data;
          nombre = nombre.replace(/ /g,'');
       nombre +='';

      var sep = ' ';
      var reg = /(\d+)(\d{3})/;

      while( reg.test( nombre )){
        nombre = nombre.replace(reg,'$1'+sep+'$2');
      } 
  
       $(".credit").empty();
       $(".credit").append(nombre +" FCFA("+NumberToLetter(data)+" FCFA)");
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

function selectAllTotalAccuseRetraitPourBalanceClient1(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getAllTotalAccuseRetraitPourBalance2_1",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".totalReglement").val("");
        formatMillierPourSelection(data,'totalReglement');
        $(".chargementPrime").fadeOut();

         nombre = data;
          nombre = nombre.replace(/ /g,'');
       nombre +='';

      var sep = ' ';
      var reg = /(\d+)(\d{3})/;

      while( reg.test( nombre )){
        nombre = nombre.replace(reg,'$1'+sep+'$2');
      } 
  
       $(".credit").empty();
       $(".credit").append(nombre +" FCFA("+NumberToLetter(data)+" FCFA)");
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



function selectAllTotalAccuseReglementPourBalanceClient(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getAllTotalAccuseReglementPourBalance2",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".totalRetrait5").val("");
        formatMillierPourSelection(data,'totalRetrait5');

         nombre = data;
          nombre = nombre.replace(/ /g,'');
       nombre +='';

      var sep = ' ';
      var reg = /(\d+)(\d{3})/;

      while( reg.test( nombre )){
        nombre = nombre.replace(reg,'$1'+sep+'$2');
      } 
  
       $(".debit").empty();
       $(".debit").append(nombre +" FCFA("+NumberToLetter(data)+" FCFA)");
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

function selectAllTotalAccuseReglementPourBalanceClient1(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getAllTotalAccuseReglementPourBalance2_1",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".totalRetrait5").val("");
        formatMillierPourSelection(data,'totalRetrait5');

         nombre = data;
          nombre = nombre.replace(/ /g,'');
       nombre +='';

      var sep = ' ';
      var reg = /(\d+)(\d{3})/;

      while( reg.test( nombre )){
        nombre = nombre.replace(reg,'$1'+sep+'$2');
      } 
  
       $(".debit").empty();
       $(".debit").append(nombre +" FCFA("+NumberToLetter(data)+" FCFA)");
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
      url:base_url+"/admin_matiere/soldeMatiereFournisseur",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".solde1").val("");
        formatMillierPourSelection(data,'solde1');
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

function getImmatriculation(){
 immat= $(".immat").val();

 $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getImmatriculation",
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
		      url:base_url+"/admin_matiere/addLivraison",
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
      url:base_url+"/admin_matiere/getAllLivraison",
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
      url:base_url+"/admin_matiere/deleteBonLivraison",
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
      url:base_url+"/admin_matiere/getDestinationParCodeCamion",
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

function getDescriptionOperation(){
 id_operation= $(".operation").val();
getDestinationOperation();
getClientOperation1();
 $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getDescriptionOperation",
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
      url:base_url+"/admin_matiere/getClientOperation",
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

function getDestinationOperation(){
 id_operation= $(".operation").val();


 $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getDestinationOperation",
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

function getAmortissementDestination(){
 id_distance = $(".arrivee option:selected").attr("id_distance");

 // alert(id_distance);

 $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getAmortissementDestination",
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




function getBalanceMatiere(){
  id_fournisseur = $(".id_fournisseur").val();
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (id_fournisseur == "" && date_debut == "" && date_fin == "") {

  }else{
  soldeCaisseFournisseur(id_fournisseur,date_debut,date_fin);
  selectAllTotalFacturePourBalanceFournisseur(id_fournisseur,date_debut,date_fin);
selectAllTotalReglementPourBalanceFournisseur(id_fournisseur,date_debut,date_fin);
    $('#example2').DataTable().destroy();
  afficheAllFActurePourBalanceMatiere('#example2',id_fournisseur,date_debut,date_fin);

  $('#example1').DataTable().destroy();
  afficheAllReglementPourBalanceMatiere('#example1',id_fournisseur,date_debut,date_fin);
  }
}

function getFournisseur(){
	facture = $(".facture").val();
  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getFournisseur",
      data:{"facture":facture},
      success: function(data){
        // alert(data);
        $(".id_fournisseur").val("");
       $(".id_fournisseur").val(data);
 
		getMontant();
     
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

function getMontant(){
	facture = $(".facture").val();
  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/getMontant",
      data:{"facture":facture},
      success: function(data){
        // alert(data);
        $(".montant").val("");
		formatMillierPourSelection1(data,'montant');
      // $(".montant").val(data);

     
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

function formatMillierPourSelection1(data,classe){
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

function confirmSuppressionFactureMatiere(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_matiere/deleteFactureMatiere",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllFactureMatiere('#example1');
        
          
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

function getBonLivraison(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  decharge1 = $(".decharge1").val();
  if (date_debut!="" && date_fin!="" && decharge1!="") {
    $('#example1').DataTable().destroy();
   afficheAllLivraison('#example1');
  }
  
}

