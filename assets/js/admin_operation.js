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

function addOperation(status){
	dateDebut = $(".dateDebut").val();
    destination = $(".destination").val();
   
	dateFin = $(".dateFin").val();
	dateCreation = $(".dateCreation").val();
	nomOperation = $(".nomOperation").val();
	typeOperation = $(".typeOperation").val();
	client = $(".client").val();
	commentaire = $(".commentaire").val();
	produit = $(".produit").val();
	id_operation = $(".id_operation").val();
	num_client = $(".num_client").val();
	filiale = $(".filiale").val();
	if (dateDebut == "") {
		toastr.error("Veuillez remplir tous les Champs");
		$(".dateDebut").css("border","red 2px solid");
	}else if (dateFin == "") {
		toastr.error("Veuillez remplir tous les Champs");
		$(".dateFin").css("border","red 2px solid");
	}else if (dateCreation== "") {
		toastr.error("Veuillez remplir tous les Champs");
		$(".dateCreation").css("border","red 2px solid");
	}else if (dateFin < dateDebut) {
    toastr.error("La date de fin doit être supérieure à la date de debut");
    $(".dateCreation").css("border","red 2px solid");
  }else if (typeOperation== "") {
    toastr.error("Veuillez remplir tous les Champs");
    $(".typeOperation").css("border","red 2px solid");
  }else if (nomOperation == "") {
		toastr.error("Veuillez remplir tous les Champs");
		$(".nomOperation").css("border","red 2px solid");
	}else if (destination == "") {
    toastr.error("Veuillez remplir tous les Champs");
    $(".destination").css("border","red 2px solid");
  }else if (client == "") {
		toastr.error("Veuillez remplir tous les Champs");
		$(".client").css("border","red 2px solid");
	}else if (typeOperation == "") {
		toastr.error("Veuillez remplir tous les Champs");
		$(".typeOperation").css("border","red 2px solid");
	}else if (commentaire == "") {
		toastr.error("Veuillez remplir tous les Champs");
		$(".commentaire").css("border","red 2px solid");
	}else if (produit == "") {
		toastr.error("Veuillez remplir tous les Champs");
		$(".produit").css("border","red 2px solid");
	}else if (filiale == "") {
		toastr.error("Veuillez remplir tous les Champs");
		$(".filiale").css("border","red 2px solid");
	}else{

        $(".destination").css("border","1px solid #ced4da");
		$(".typeOperation").css("border","1px solid #ced4da");
		$(".dateDebut").css("border","1px solid #ced4da");
		$(".dateFin").css("border","1px solid #ced4da");
		$(".dateCreation").css("border","1px solid #ced4da");
		$(".nomOperation").css("border","1px solid #ced4da");
		$(".client").css("border","1px solid #ced4da");
		$(".commentaire").css("border","1px solid #ced4da");
		$(".produit").css("border","1px solid #ced4da");
		
		$(".chargementOperation").fadeIn();
	$.ajax({
      type:"POST",
      url:base_url+"/admin_operation/addOperation",
      data:{"destination":destination,"id_operation":id_operation,"status":status,"dateDebut":dateDebut,"dateCreation":dateCreation,"dateFin":dateFin,"nomOperation":nomOperation,"typeOperation":typeOperation,"id_client":client,"commentaire":commentaire,"produit":produit,"num_client":num_client,"filiale":filiale},
      success: function(data){
      	if ($.trim(data) == "Création de l'opération réussie") {

     $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
        $('#example1').DataTable().destroy();
        afficheAllOperation('#example1');
        $(".chargementOperation1").fadeOut();
        $(".chargementOperation").fadeOut();
      	
      	}else if ($.trim(data) == "Mise à jour de l'opération réussie") {
      $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 


        $('#example1').DataTable().destroy();
        afficheAllOperation('#example1');
        $(".chargementOperation1").fadeOut();
        $(".chargementOperation").fadeOut();

      	}
      	else{
      		 	$(".chargementOperation").fadeOut();
      		 	$(".chargementOperation1").fadeOut();
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      })   
      	}
      	
      },
       error:function(data){
       	$(".chargementOperation").fadeOut();
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementAssurance").fadeOut();
       }
       });
	}
}

function afficheAllOperation(idTable){
  $(".chargementOperation1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/getAllOperation",
      data:{},
      success: function(data){

        $(".contentOperation").empty();
        $(".contentOperation").append(data);
        ceerDatatable(idTable)
        $(".chargementOperation1").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementAssurance").fadeOut();
       }
       });
}
function confirmSuppressionOperation(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/deleteOperation",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllOperation('#example1');
        
          
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

function infoOperation(dateDebut,dateFin,dateCreation,nomOperation,typeOperation,client,commentaire,produit,id_operation,destination,num_op,facture,filiale){
 $(".id_operation").val(id_operation);
 $(".dateDebut").val(dateDebut);
 $(".dateFin").val(dateFin);
 $(".dateCreation").val(dateCreation);
 $(".nomOperation").val(nomOperation);
 $(".typeOperation").val(typeOperation);
 // alert(typeOperation);
 $(".client").val(client);
 $(".commentaire").val(commentaire);
 $(".produit").val(produit);
 $(".destination").val(destination);
 $(".num_op").val(num_op);
 $(".num_client").val(facture);
  $(".filiale").val(filiale);
 // alert(typeOperation);

 $(".btnModifier").fadeIn();
 $(".btnAdd").fadeOut();
 $(".btnAnnuler").fadeIn();

}

function annulerSuppression(){
	$(".btnModifier").fadeOut();
 $(".btnAdd").fadeIn();
 $(".btnAnnuler").fadeOut();
}


function afficheAllReglementPourBalance(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_gestion_gazoil/getAllReglementPourBalance",
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
function afficheAllFActureReglementPourBalanceOperation(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/selectAllFactureOperationPourBalance",
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

function afficheAllFActurePrimePourBalanceOperation(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/selectAllPrimeOperationPourBalance",
      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
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

function selectAllFraisRouteOperationPourBalance(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/selectAllFraisRouteOperationPourBalance",
      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".contentPrime3").empty();
        $(".contentPrime3").append(data);
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


function selectAllFraisDiversOperationPourBalance(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/selectAllFraisDiversOperationPourBalance",
      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".contentPrime5").empty();
        $(".contentPrime5").append(data);
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
function selectAllPieceRechangeOperationPourBalance(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/selectAllPieceRechangeOperationPourBalance",
      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".contentPrime4").empty();
        $(".contentPrime4").append(data);
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
function selectAllVidangeOperationPourBalance(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/selectAllVidangeOperationPourBalance",
      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".contentPrime6").empty();
        $(".contentPrime6").append(data);
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
function selectAllGazoilOperationPourBalance(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/selectAllGazoilOperationPourBalance",
      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".contentPrime7").empty();
        $(".contentPrime7").append(data);
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
function selectAllChargementOperationPourBalance(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/selectAllChargementOperationPourBalance",
      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".contentPrime0").empty();
        $(".contentPrime0").append(data);
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
function selectAllTotalFactureOperationPourBalance(id_fournisseur,date_debut,date_fin){
   $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/selectAllTotalFactureOperationPourBalance",
      data:{"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        $(".totalFacture").val("");
        formatMillierPourSelection(data,'totalFacture');
        // alert(data);
        // $(".totalRecette").val(parseInt(data));

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

function selectTotalRecette(id_fournisseur,date_debut,date_fin){
   $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/selectTotalRecette",
      data:{"id_fournisseur":id_fournisseur,"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        formatMillierPourSelection(data,'totalRecette');

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
function selectAllTotalPrimeOperationPourBalance(id_fournisseur,date_debut,date_fin){
   $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/selectAllTotalPrimeOperationPourBalance",
      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        $(".totalPrime").val("");
        formatMillierPourSelection(data,'totalPrime');
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

function selectAllTotalFraisRouteOperationPourBalance(id_fournisseur,date_debut,date_fin){
   $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/selectAllTotalFraisRouteOperationPourBalance",
      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        $(".totalFraisRoute").val("");
        formatMillierPourSelection(data,'totalFraisRoute');
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

function selectAllTotalFraisDiversOperationPourBalance(id_fournisseur,date_debut,date_fin){
   $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/selectAllTotalFraisDiversOperationPourBalance",
      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        $(".totalFraisDivers").val("");
        formatMillierPourSelection(data,'totalFraisDivers');

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


function selectAllTotalPieceRechangeOperationPourBalance(id_fournisseur,date_debut,date_fin){
   $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/selectAllTotalPieceRechangeOperationPourBalance",
      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        $(".totalPieceRechange").val("");
        formatMillierPourSelection(data,"totalPieceRechange");
       
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
function selectAllTotalVidangeOperationPourBalance(id_fournisseur,date_debut,date_fin){
   $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/selectAllTotalVidangeOperationPourBalance",
      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        $(".totalVidange").val("");
        formatMillierPourSelection(data,"totalVidange");

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
function selectAllTotalGazoilOperationPourBalance(id_fournisseur,date_debut,date_fin){
   $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/selectAllTotalGazoilOperationPourBalance",
      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        $(".totalGazoil").val("");
        formatMillierPourSelection(data,'totalGazoil');

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

function selectAllTotalChargementOperationPourBalance(id_fournisseur,date_debut,date_fin){
   $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/selectAllTotalChargementOperationPourBalance",
      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        $(".totalChargement").val("");
        formatMillierPourSelection(data,'totalChargement');
        // alert(data);
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

function totalDepense(id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/totalDepenseParOperation",
      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".totalReglement ").val("");
        formatMillierPourSelection(data,'totalReglement');
        // $(".solde").val($(".totalFacture").val()-data);
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

function getSolde(id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/getSolde",
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

function selectAllLocationEnginOperationPourBalance(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/selectAllLocationEnginOperationPourBalance",
      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".contentPrime9").empty();
        $(".contentPrime9").append(data);
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
function selectAllTotalLocationEnginOperationPourBalance(id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/selectAllTotalLocationEnginOperationPourBalance",
      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        $(".totalEngin").val();
       formatMillierPourSelection(data,"totalEngin");
        
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

// vente des pieces

function selectAllVentePiecesOperationPourBalance(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/selectAllVentePiecesOperationPourBalance",
      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".contentPrime10").empty();
        $(".contentPrime10").append(data);
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

function selectAllTotalVentePiecesOperationPourBalance(id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/selectAllTotalVentePiecesOperationPourBalance",
      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        $(".totalVente").val();
       formatMillierPourSelection(data,"totalVente");
        
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

function getClientOperation(){
id_operation = $(".id_operation").val();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/getClientOperation",
      data:{"id_operation":id_operation},
      success: function(data){
        $(".client").val("");
        $(".client").val(data);

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
function getDateCreationOperation(){
id_operation = $(".id_operation").val();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/getDateCreationOperation",
      data:{"id_operation":id_operation},
      success: function(data){
        $(".dateCreation").val("");
        $(".dateCreation").val(data);
        
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
function getProduitOperation(){
id_operation = $(".id_operation").val();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/getProduitOperation",
      data:{"id_operation":id_operation},
      success: function(data){
        // alert(data);
        $(".produit").val("");
        $(".produit").val(data);

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

function getBalancePourOperation(){
  id_fournisseur = $(".id_fournisseur").val();
   date_debut ="";
  date_fin = "";

    $('#example1').DataTable().destroy();
  afficheAllFActureReglementPourBalanceOperation('#example1',id_fournisseur,date_debut,date_fin);

  $('#example2').DataTable().destroy();
  afficheAllFActurePrimePourBalanceOperation('#example2',id_fournisseur,date_debut,date_fin);

  $('#example3').DataTable().destroy();
  selectAllFraisRouteOperationPourBalance('#example3',id_fournisseur,date_debut,date_fin);

  $('#example5').DataTable().destroy();
  selectAllFraisDiversOperationPourBalance('#example5',id_fournisseur,date_debut,date_fin);
  
  $('#example4').DataTable().destroy();
  selectAllPieceRechangeOperationPourBalance('#example4',id_fournisseur,date_debut,date_fin);

  $('#example6').DataTable().destroy();
  selectAllVidangeOperationPourBalance('#example6',id_fournisseur,date_debut,date_fin);

  $('#example7').DataTable().destroy();
  selectAllGazoilOperationPourBalance('#example7',id_fournisseur,date_debut,date_fin);

  $('#example8').DataTable().destroy();
  selectAllChargementOperationPourBalance('#example8',id_fournisseur,date_debut,date_fin);

  $('#example9').DataTable().destroy();
  selectAllLocationEnginOperationPourBalance('#example9',id_fournisseur,date_debut,date_fin)

  $('#example10').DataTable().destroy();
  selectAllVentePiecesOperationPourBalance('#example10',id_fournisseur,date_debut,date_fin)

  selectAllTotalFactureOperationPourBalance(id_fournisseur,date_debut,date_fin);

  selectAllTotalLocationEnginOperationPourBalance(id_fournisseur,date_debut,date_fin);

  selectAllTotalVentePiecesOperationPourBalance(id_fournisseur,date_debut,date_fin);

  selectAllTotalPrimeOperationPourBalance(id_fournisseur,date_debut,date_fin);

  selectAllTotalFraisRouteOperationPourBalance(id_fournisseur,date_debut,date_fin);

  selectAllTotalFraisDiversOperationPourBalance(id_fournisseur,date_debut,date_fin);

  selectAllTotalPieceRechangeOperationPourBalance(id_fournisseur,date_debut,date_fin);

  selectAllTotalVidangeOperationPourBalance(id_fournisseur,date_debut,date_fin);

  selectAllTotalGazoilOperationPourBalance(id_fournisseur,date_debut,date_fin);

  totalDepense(id_fournisseur,date_debut,date_fin);

  getSolde(id_fournisseur,date_debut,date_fin);

  selectAllTotalChargementOperationPourBalance(id_fournisseur,date_debut,date_fin);

  selectTotalRecette(id_fournisseur,date_debut,date_fin);

}

function afficheAllChargement(idTable){
  $(".chargementClient").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/getAllChargement",
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


function addChargement(status){
  // alert(status);
  libelle = $(".libelle").val();
  operation = $(".operation").val();
  code_camion = $(".camion").val();
  numero = $(".numero").val();
  date = $(".date_charg").val();
  montant = $(".montant").val();
  id_client = $(".id_client").val();

  // alert(operation+" et "+code_camion);
  if (numero == "") {
    $(".numero").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (montant == "") {
    $(".montant").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (date == "") {
    $(".date_charg").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (libelle == "") {
    $(".libelle").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else{
    $(".numero").css("border","1px solid #ced4da");
    $(".libelle").css("border","1px solid #ced4da");
    $(".montant").css("border","1px solid #ced4da");
    $(".date_charg").css("border","1px solid #ced4da");
$(".chargementCarteGrise1").fadeIn();
     $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/addChargement",
      data:{"libelle":libelle,"status":status,"code_camion":code_camion,"operation":operation,"id_client":id_client,"numero":numero,"date_charg":date,"montant":montant},
       success: function(data){
   if ($.trim(data) == "Insertion parfaite du chargement") {
    $(".numero").val("");
  $(".montant").val("");
  $(".date_charg").val("");
    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllChargement('#example1');
        $(".chargementCarteGrise1").fadeOut();
      }else if ($.trim(data) == "Modification parfaite du chargement") {
        $(".nom").val("");
  $(".adresse").val("");
  $(".telephone").val("");
    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllChargement('#example1');
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
function confirmSuppressionChargementRetour(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/deleteChargementRetour",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllChargement('#example1');
        
          
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

function infosClient1(id_client,nom,adresse,telephone,libelle,id_operation,code_camion){
  $(".numero").val(nom);
  $(".operation").val(id_operation);
  $(".camion").val(code_camion);
  $(".libelle").val(libelle);
  $(".date_charg").val(adresse);
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

function detailOperation(id_op,nom_op,client,date_creation,date_debut,date_fin,type_operation){
  // $(".po2").empty();
  // $(".po2").append(po+'<br/><br/>');
  $(".nom_op").empty();
  $(".nom_op").append(nom_op);
  $(".client").empty();
  $(".client").append(client);
  $(".date_creation").empty();
  $(".date_creation").append(date_creation);
  $(".date_debut").empty();
  $(".date_debut").append(date_debut);
  $(".date_fin").empty();
  $(".date_fin").append(date_fin);
  $(".type_operation").empty();
  $(".type_operation").append(type_operation);
  $(".chargementPrime2").fadeIn();
  window.location = base_url+"/admin/operation#contentDetailCommande2";
  getFactureOperationParLocationEngin(id_op);

  getFactureOperationParChargementRetour(id_op);

  netPayer(id_op);
}

function getFactureOperationParLocationEngin(id_operation){

  $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/getFactureOperationParLocationEngin",
      data:{"id_operation":id_operation},
      success: function(data){
        // alert(data);
        $(".locationEngin").empty();
        $(".locationEngin").append(data);
        // $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="4" style="text-align : right; border:none; font-weight:12px; color:red; border-top:2px solid black;"></td><td colspan="2" style="text-align : right; border:none; font-weight:12px; color:red;border-top:2px solid black;">Total groupe: </td><td colspan="2" style="text-align : left; border:none; font-weight:12px; color:red;border-top:2px solid black;"> '+montant+'</td></tr>');
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

function getFactureOperationParChargementRetour(id_operation){

  $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/getFactureOperationParChargementRetour",
      data:{"id_operation":id_operation},
      success: function(data){
        // alert(data);
        $(".chargementRetour").empty();
        $(".chargementRetour").append(data);
        // $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="4" style="text-align : right; border:none; font-weight:12px; color:red; border-top:2px solid black;"></td><td colspan="2" style="text-align : right; border:none; font-weight:12px; color:red;border-top:2px solid black;">Total groupe: </td><td colspan="2" style="text-align : left; border:none; font-weight:12px; color:red;border-top:2px solid black;"> '+montant+'</td></tr>');
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

function getNom(){
	

 
  id_article = $(".nomOperation").val();
 
  $(".num_client").val(id_article);
   
  
}
	
	
function netPayer(id_operation){

  $.ajax({
      type:"POST",
      url:base_url+"/admin_operation/netPayer",
      data:{"id_operation":id_operation},
      success: function(data){
        // alert(data);
        $(".netPayer").empty();
        $(".netPayer").append(data);
        // $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="4" style="text-align : right; border:none; font-weight:12px; color:red; border-top:2px solid black;"></td><td colspan="2" style="text-align : right; border:none; font-weight:12px; color:red;border-top:2px solid black;">Total groupe: </td><td colspan="2" style="text-align : left; border:none; font-weight:12px; color:red;border-top:2px solid black;"> '+montant+'</td></tr>');
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

function imprimer_bloc(titre, objet) {
// Définition de la zone à imprimer
var zone = document.getElementById(objet).innerHTML;
 

var win = window.open("", "", "height=1300, width=1600,toolbar=0, menubar=0, scrollbars=1, resizable=1,status=0, location=0, left=10, top=10");
win.document.write('<html><head><title>Print it!</title></head><body style="backgroundColor:red;">');
win.document.write(zone );
win.document.write('</body></html>');
win.print();
win.close();
}