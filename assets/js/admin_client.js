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

function afficheAllClient(idTable){
  $(".chargementClient").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_client/getAllClient",
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
      url:base_url+"/admin_client/addClient",
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
      url:base_url+"/admin_client/deleteClient",
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

function infosReglement(id_regl,numero,date_reg,libelle,montant,client){
  $(".dateFacture").val(date_reg);
  $(".montant").val(montant);
	$(".numero").val(numero);
 
	$(".libelle").val(libelle);
	$(".id_gazoil").val(client);
	$(".id_prime").val(id_regl);
	$(".btnAnnuler").fadeIn();
	$(".btnModif").fadeIn();
	$(".btnAdd").fadeOut();
}

function annulerModifClient(){
$(".btnAnnulerModif").fadeOut();
	$(".btnModifClient").fadeOut();
	$(".btnAddClient").fadeIn();
}

function addReglementClient(status){
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
  $(".libelle").css("border","1px solid #ced4da");
  $(".montant").css("border","1px solid #ced4da");
  $(".id_gazoil").css("border","1px solid #ced4da");
  $(".dateFacture").css("border","1px solid #ced4da");
  $(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
   $.ajax({
      type:"POST",
      url:base_url+"/admin_client/addReglement",
      data:{"id_fournisseur":id_gazoil,"id_facture":id_regl,"status":status,"montant":montant,"numero":numero,"date":date,"libelle":libelle},
      success: function(data){  

        if ($.trim(data) == "Règlement du client effectué") {

        $('#example1').DataTable().destroy();
        afficheAllReglementClient('#example1');
          $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
        }else if ($.trim(data) == "Règlement modifié") {

        $('#example1').DataTable().destroy();
        afficheAllReglementClient('#example1');
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

function afficheAllReglementClient(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_client/getAllReglement",
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

function confirmSuppressionReglementClient(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_client/deleteReglementClient",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllReglementClient('#example1');
        
          
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

function soldeInitialClient(id_fournisseur){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_client/soldeInitialClient",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur},
      success: function(data){
        // alert(data);
        // $(".soldeInitial").val("");
        formatMillierPourSelection(data,'soldeInitial');
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
function dateInitialClient(id_fournisseur){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_client/dateInitialClient",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur},
      success: function(data){
        // alert(data);
        $(".dateInitial").val();
         $(".dateInitial").val(data);
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
function afficheAllFActurePourBalance(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_client/getAllFacturePourBalance",
      data:{"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
// alert(data);
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
function selectAllTotalFacturePourBalanceClient(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_client/getAllTotalFacturePourBalance",
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
function afficheAllReglementPourBalance(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_client/getAllReglementPourBalance",
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

function selectAllTotalReglementPourBalanceClient(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_client/getAllTotalReglementPourBalance",
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
function soldeCaisseClient(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_client/soldeCaisseClient",
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

function getBalance(){
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  id_fournisseur = $(".id_fournisseur").val();
  soldeInitialClient(id_fournisseur);
  dateInitialClient(id_fournisseur);
  if (id_fournisseur == "" && date_debut == "" && date_fin == "") {

  }else{

    soldeCaisseClient(id_fournisseur,date_debut,date_fin);
  selectAllTotalFacturePourBalanceClient(id_fournisseur,date_debut,date_fin);
selectAllTotalReglementPourBalanceClient(id_fournisseur,date_debut,date_fin);
    $('#example2').DataTable().destroy();
  afficheAllFActurePourBalance('#example2',id_fournisseur,date_debut,date_fin);

  $('#example1').DataTable().destroy();
  afficheAllReglementPourBalance('#example1',id_fournisseur,date_debut,date_fin);
  
  }
}



function repportNouveau1(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_client/repportNouveau1",
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





function repportNouveauDebit1(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_client/repportNouveauDebit1",
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



function repportNouveauCredit1(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_client/repportNouveauCredit1",
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



function getCreditPourBalanceImpCLient1(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_client/getCreditPourBalanceImpCLient1",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".credit").val("");
        formatMillierPourSelection(data,'credit');
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
      url:base_url+"/admin_client/getDebitPourBalanceImpCLient1",
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



function getBalanceImprimableClient2_1(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_client/getBalanceImprimableClient1",
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
      url:base_url+"/admin_client/verifiDateInitialClient1",
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





function getDateInitialClient1(id_fournisseur){
  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_client/getDateInitialClient1",
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



function getSoldeInitialClient1(id_fournisseur){

  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_client/getSoldeInitialClient1",
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




function getNomClient1(id_fournisseur){
  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_client/getNomClient1",
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



function getVilleClient1(id_fournisseur){
  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_client/getVilleClient1",
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


function getAdresseClient1(id_fournisseur){
  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_client/getAdresseClient1",
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



function getTelephoneClient1(id_fournisseur){
  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_client/getTelephoneClient1",
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




function soldeCaisseClient2_1(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_client/soldeCaisseClient2_1",
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

function selectAllTotalAccuseRetraitPourBalanceClient1(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_client/getAllTotalAccuseRetraitPourBalance2_1",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".totalRetrait5").val("");
        formatMillierPourSelection(data,'totalRetrait5');
        $(".chargementPrime").fadeOut();

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
      url:base_url+"/admin_client/getAllTotalAccuseReglementPourBalance2_1",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".totalReglement").val("");
        formatMillierPourSelection(data,'totalReglement');

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
      url:base_url+"/admin_client/getImmatriculation",
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
