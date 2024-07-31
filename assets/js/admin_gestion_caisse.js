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
      url:base_url+"/admin_caisse/verifiDateInitialClient",
      data:{"date_initial":date_debut,"id_client":id_fournisseur},
      success: function(data){
        if ($.trim(data) == "ok") {
          // facturePourBalanceClient('test');
  $(".date_debut1").empty();
  $(".date_debut1").append(date_debut);

  $(".date_fin1").empty();
  $(".date_fin1").append(date_fin);
 // totalFacturePourBalanceClient('test');

 // factureArticlePourBalanceClient('idTable');
  //totalFactureArticlePourBalanceClient();
    soldeCaisseClient2(id_fournisseur,date_debut,date_fin);
  selectAllTotalAccuseRetraitPourBalanceClient(id_fournisseur,date_debut,date_fin);
  selectAllTotalAccuseReglementPourBalanceClient(id_fournisseur,date_debut,date_fin);

  //selectAllTotalAccuseRetraitPourBalanceClient2(id_fournisseur,date_debut,date_fin);
//selectAllTotalAccuseReglementPourBalanceClient2(id_fournisseur,date_debut,date_fin);


  $('#example1').DataTable().destroy();
  getBalanceImprimableClient2('#example1',id_fournisseur,date_debut,date_fin)
  // afficheAllAccuseReglementPourBalance('#example1',id_fournisseur,date_debut,date_fin);
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


function getBalanceImprimableCaisse(){
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
   lieu = $(".lieu").val();
 // id_fournisseur = $(".id_fournisseur").val();
//getDateInitialClient(id_fournisseur);
//getSoldeInitialClient(id_fournisseur);
//getNomClient(id_fournisseur);
//getVilleClient(id_fournisseur);
//getAdresseClient(id_fournisseur);
//getTelephoneClient(id_fournisseur);

$(".date_debut1").empty();
  $(".date_debut1").append(date_debut);

  $(".date_fin1").empty();
  $(".date_fin1").append(date_fin);
  
  soldeCaisseCaisse2(date_debut,date_fin,lieu);
  
   $('#example1').DataTable().destroy();
  getBalanceImprimableCaisse2('#example1',date_debut,date_fin,lieu);
  

}

function getBalanceImprimableCaisse2(idTable,date_debut,date_fin,lieu){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getBalanceImprimableCaisse",
      data:{"date_debut":date_debut,"date_fin":date_fin,"lieu":lieu},
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



function getDateInitialClient(id_fournisseur){
  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getDateInitialClient",
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
      url:base_url+"/admin_caisse/getSoldeInitialClient",
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
      url:base_url+"/admin_caisse/getNomClient",
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
      url:base_url+"/admin_caisse/getVilleClient",
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
      url:base_url+"/admin_caisse/getAdresseClient",
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
      url:base_url+"/admin_caisse/getTelephoneClient",
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
      url:base_url+"/admin_caisse/soldeCaisseClient2",
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

function soldeCaisseCaisse2(date_debut,date_fin,lieu){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/soldeCaisseCaisse2",
      data:{"date_debut":date_debut,"date_fin":date_fin, "lieu":lieu},
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


function afficheAllCaisse(idTable){
  $(".chargementClient").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getAllCaisse",
      data:{},
      success: function(data){
// alert(data);
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

function facturePourBalanceClient(idTable){
$('#example3').DataTable().destroy();
  id_fournisseur = $(".id_fournisseur").val();
   date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  articles = $(".articles").val();

if ( articles == undefined) {

}else{
  
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/facturePourBalanceClient",
      data:{"id_fournisseur":articles,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){

        $(".contentCommande").empty();
        $(".contentCommande").append(data);
         // alert(data);
        ceerDatatable('#example3');
        $(".chargementPrime").fadeOut();

        // totalRapportFacture();
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

function totalFacturePourBalanceClient(){
  id_fournisseur = $(".id_fournisseur").val();
   date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  articles = $(".articles").val();

if ( articles == undefined) {

}else{
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/totalFacturePourBalanceClient",
      data:{"id_fournisseur":articles,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){

        $(".totalBoisson").val();
       formatMillierPourSelection(data,'totalBoisson');
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
}

function getBalanceImprimableClient2(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getBalanceImprimableClient",
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
      url:base_url+"/admin_caisse/repportNouveau",
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
      url:base_url+"/admin_caisse/repportNouveauDebit",
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
      url:base_url+"/admin_caisse/repportNouveauCredit",
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
      url:base_url+"/admin_caisse/getCreditPourBalanceImpCLient",
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
      url:base_url+"/admin_caisse/getDebitPourBalanceImpCLient",
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


function selectAllTotalAccuseRetraitPourBalanceClient(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getAllTotalAccuseRetraitPourBalance2",
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
      url:base_url+"/admin_caisse/getAllTotalAccuseReglementPourBalance2",
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


function getCodeCamion(){
	
	
  validite = $(".validite").val();
  
  vehicule = $(".vehicule");
  
  fournisseur = $(".fournisseur");
  
  operation = $(".operation");
  
  arrivee = $(".arrivee");
  
  fournisseur = $(".fournisseur");
  
    if ((validite == "Frais Route" ) || (validite == "Frais Divers" ) || (validite == "Prime" )) {
    
	vehicule.removeAttr("disabled","false");
	
	operation.removeAttr("disabled","false");
	
	arrivee.removeAttr("disabled","false");
	
	fournisseur.attr("disabled","true");
	
   // num_bordereau.removeAttr("disabled","false");
  }else if ((validite == "Reglement Fournisseur Caisse" )|| (validite == "Reglement Fournisseur Article" ) || (validite == "Reglement Fournisseur Gazoil" )|| (validite == "Reglement Fournisseur Matiere Premiere" )) {
    
	fournisseur.removeAttr("disabled","false");
	
	vehicule.attr("disabled","true");
	
	operation.attr("disabled","true");
	
	arrivee.attr("disabled","true");
	
  }else {
	  
	vehicule.attr("disabled","true");
	
	operation.attr("disabled","true");
	
	arrivee.attr("disabled","true");

    fournisseur.attr("disabled","true");
	
	}
	

 
}

function getfournisseur1(){
	
	
  camion = $(".camion").val();
  
 
  
  operation = $(".operation");
  
  arrivee = $(".arrivee");
  
  vehicule = $(".vehicule");
  
   validite = $(".validite");
   
   fournisseur = $(".fournisseur");
   
  
    if (camion == 12 )  {
    

	
	validite.removeAttr("disabled","false");
	


  }else {
	  
	vehicule.attr("disabled","true");
	
	operation.attr("disabled","true");
	
	arrivee.attr("disabled","true");
	
	fournisseur.attr("disabled","true");
	
	validite.attr("disabled","true");
	
	
	
	}
	
}
	
	
function getfournisseur(){
	
	
  validite = $(".validite").val();
  
  fournisseur = $(".fournisseur");
  
  operation = $(".operation");
  
  arrivee = $(".arrivee");
  
  vehicule = $(".vehicule");
  
    if ((validite == "Frais Route") || (validite == "Frais Divers")  || (validite == "Prime") || (validite == "Commission") || (validite == "Depannage") || (validite == "Prevision Navire")) {
    
	vehicule.removeAttr("disabled","false");
	
	operation.removeAttr("disabled","false");
	
	arrivee.removeAttr("disabled","false");
	
	fournisseur.attr("disabled","true");
	
   // num_bordereau.removeAttr("disabled","false");
  }else if ((validite == "Reglement Fournisseur Caisse" ) || (validite == "Reglement Fournisseur Article" ) || (validite == "Reglement Fournisseur Gazoil" )|| (validite == "Reglement Fournisseur MIRA SA" )) {
 	 
	fournisseur.removeAttr("disabled","false");
	
	
	vehicule.attr("disabled","true");
	
	operation.attr("disabled","true");
	
	arrivee.attr("disabled","true");
	
  }else {
	  
	vehicule.attr("disabled","true");
	
	operation.attr("disabled","true");
	
	arrivee.attr("disabled","true");

    fournisseur.attr("disabled","true");
	
	}
	

 // getTypeCamion(code_camion);
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getfournisseur",
     data:{"validite":validite},
      success: function(data){
         $(".fournisseur").empty();
			 
         $(".fournisseur").append(data);
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur '+data.responseText
      })   
          $(".chargementPrime1").fadeOut();
       }
       });
}

function getfournisseurDem(validite,fournisseur,operation,arrivee,vehicule){
	
    if ((validite == "Frais Route") || (validite == "Frais Divers")  || (validite == "Prime") || (validite == "Commission") || (validite == "Depannage") || (validite == "Prevision Navire")) {
    
	$("."+vehicule).removeAttr("disabled","false");
	
	$("."+operation).removeAttr("disabled","false");
	
	$("."+arrivee).removeAttr("disabled","false");
	
	$("."+fournisseur).attr("disabled","true");
	
   
  }else if ((validite == "Reglement Fournisseur Caisse" ) || (validite == "Reglement Fournisseur Article" ) || (validite == "Reglement Fournisseur Gazoil" )|| (validite == "Reglement Fournisseur MIRA SA" ) || (validite == "Retour Fournisseur")) {
 	 
	$("."+fournisseur).removeAttr("disabled","false");
	
	
	$("."+vehicule).attr("disabled","true");
	
	$("."+operation).attr("disabled","true");
	
	$("."+arrivee).attr("disabled","true");
	
  }else {
	  
	$("."+vehicule).attr("disabled","true");
	
	$("."+operation).attr("disabled","true");
	
	$("."+arrivee).attr("disabled","true");

    $("."+fournisseur).attr("disabled","true");
	
	}
	

 // getTypeCamion(code_camion);
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getfournisseurDem",
     data:{"validite":validite},
      success: function(data){
        $("."+fournisseur).empty();
			 
         $("."+fournisseur).append(data);
		 
	//	 getOperationCaisse();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur '+data.responseText
      })   
          $(".chargementPrime1").fadeOut();
       }
       });
	   
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getOperationDem",
     data:{"validite":validite},
      success: function(data){
        $("."+operation).empty();
			 
         $("."+operation).append(data);
		 
	//	 getOperationCaisse();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur '+data.responseText
      })   
          $(".chargementPrime1").fadeOut();
       }
       });
	   
	   
	    $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getDestinationDem",
     data:{"validite":validite},
      success: function(data){
        $("."+arrivee).empty();
			 
         $("."+arrivee).append(data);
		 
	//	 getOperationCaisse();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur '+data.responseText
      })   
          $(".chargementPrime1").fadeOut();
       }
       });
	   
	   
	   	    $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getVehiculeDem",
     data:{"validite":validite},
      success: function(data){
        $("."+vehicule).empty();
			 
         $("."+vehicule).append(data);
		 
	//	 getOperationCaisse();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur '+data.responseText
      })   
          $(".chargementPrime1").fadeOut();
       }
       });
	   
	  
}


 

function addCaisse(status){
	// alert(status);
	nom = $(".nom_type").val();
	adresse = $(".type").val();
	telephone = $(".commentaire").val();
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
      url:base_url+"/admin_caisse/addCaisse",
      data:{"status":status,"id_client":id_client,"nom_type":nom,"type":adresse,"commentaire":telephone},
       success: function(data){
   if ($.trim(data) == "Insertion parfaite du type") {
   	$(".nom").val("");
	$(".adresse").val("");
	$(".telephone").val("");
		toastr.info(data);
      	$('#example1').DataTable().destroy();
        afficheAllCaisse('#example1');
        $(".chargementCarteGrise1").fadeOut();
      }else if ($.trim(data) == "Modification parfaite du type") {
      	$(".nom").val("");
	$(".adresse").val("");
	$(".telephone").val("");
		toastr.info(data);
      	$('#example1').DataTable().destroy();
        afficheAllCaisse('#example1');
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
      url:base_url+"/admin_document/deleteDocument",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllCaisse('#example1');
        
          
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
        afficheAllDemandeCaisse('#example1');
        
          
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


function confirmSuppressionEntreeSortie(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/deleteEntreeSortie",
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

function infosClient(id_client,nom,adresse,telephone){
	$(".nom_type").val(nom);
	$(".commentaire").val(adresse);
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

// nous allons passer aux sorties

function addSortie(status){
	
  montant = $(".montant").val();
  ordonateur = $(".ordonateur").val();
  date = $(".datePrime").val();
  type = $(".camion").val();
  commentaire = $(".commentaire").val();
 
  validite = $(".validite").val();
  vehicule = $(".vehicule").val();
  fournisseur = $(".fournisseur").val();
  numero = $(".numero").val();
  operation = $(".operation").val();
  arrivee = $(".arrivee").val();
  
  id_prime = $(".id_prime").val();

  if (montant == "") {
  $(".montant").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
  }else if (date == "") {
  $(".datePrime").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (ordonateur == "") {
  $(".ordonateur").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (numero == "") {
  $(".numero").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else{
  $(".montant").css("border","1px solid #ced4da");
  $(".numero").css("border","1px solid #ced4da");
  $(".ordonateur").css("border","1px solid #ced4da");
  $(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
   $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/addSortie",
      data:{"id_prime":id_prime,"status":status,"montant":montant,"ordonateur":ordonateur,"date":date,"commentaire":commentaire,"type":type,"validite":validite,"vehicule":vehicule,"fournisseur":fournisseur,"numero":numero,"operation":operation,"arrivee":arrivee},
      success: function(data){  

        if ($.trim(data) == "Enregistrement de la sortie réussie") {

        $('#example1').DataTable().destroy();
        afficheAllSortie1('#example1');
          $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
        $(".chargementPrime1").fadeOut();
        }else if ($.trim(data) == "Modification de la sortie réussie") {

        $('#example1').DataTable().destroy();
        afficheAllSortie1('#example1');
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
                // alert(data.responseText);
       }
       });
  }
}


function addSortie1(status){
	
	
  montant = $(".montant").val();
  ordonateur = $(".ordonateur").val();
  date = $(".datePrime").val();
  type = $(".camion").val();
  commentaire = $(".commentaire").val();
 etat_demande = $(".etat_demande").val();
  validite = $(".validite").val();
  vehicule = $(".vehicule").val();
  fournisseur = $(".fournisseur").val();
  numero = $(".numero").val();
  operation = $(".operation").val();
  arrivee = $(".arrivee").val();
  
  id_prime = $(".id_prime").val();
  
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
	

  if (montant == "") {
  $(".montant").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
  }else if (date == "") {
  $(".datePrime").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (ordonateur == "") {
  $(".ordonateur").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (numero == "") {
  $(".numero").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else{
  $(".montant").css("border","1px solid #ced4da");
  $(".numero").css("border","1px solid #ced4da");
  $(".ordonateur").css("border","1px solid #ced4da");
  $(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
   $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/addSortie1",
      data:{"id_prime":id_prime,"status":status,"montant":montant,"ordonateur":ordonateur,"date":date,"commentaire":commentaire,"type":type,"validite":validite,"vehicule":vehicule,"fournisseur":fournisseur,"numero":numero,"operation":operation,"arrivee":arrivee,"etat_demande":etat_demande,"etat_demande":etat_demande,"rj":rj,"rj1":rj1,},
      success: function(data){  

        if ($.trim(data) == "Enregistrement de la sortie réussie") {

        $('#example1').DataTable().destroy();
        afficheAllSortie1('#example1');
          $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
        }else if ($.trim(data) == "Modification de la sortie réussie") {

        $('#example1').DataTable().destroy();
        afficheAllSortie1('#example1');
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
                // alert(data.responseText);
       }
       });
  }
}

function afficheAllSortie(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getAllSortie",
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


function afficheAllSortie1(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getAllSortie1",
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

function confirmSuppressionPrime(){
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
        afficheAllSortie('#example1');
        
          
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

function confirmSuppressionEntree(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/deleteEntreeCaisse",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllEntree('#example1');
        
          
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

function confirmSuppressionSortie(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/deleteSortieCaisse",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllSortie1('#example1');
        
          
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

function confirmSuppressionClotureCaisse(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/deleteClotureCaisse",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllCloture('#example1');
        
          
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
function infoSortieCaisse(montant,ordonateur,dateSortie,commentaire,id_type,id_prime,numero,type_sortie,vehicule,fournisseur,operation,arrivee){
  $(".montant").val(montant);
  $(".ordonateur").val(ordonateur);
  
  $(".numero").val(numero);
  
  $(".validite").val(type_sortie);
   
  $(".vehicule").val(vehicule);
  
  $(".fournisseur").val(fournisseur);
  
  $(".operation").val(operation);
  
  $(".arrivee").val(arrivee);

  $(".camion").val(id_type);
  
  $(".id_prime").val(id_prime);

  $(".commentaire").val(commentaire);
  $(".datePrime").val(dateSortie);

  $(".btnAdd").fadeOut();
  $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
}

function infoPrime(montant,libelle,date,codeCamion,id_operation,id_prime){
  $(".montant").val(montant);
  $(".libelle").val(libelle);
  $(".datePrime").val(date);
  // $(".camion").val(codeCamion);
  $(".operation").val(id_operation);
  $(".id_prime").val(id_prime);

  $(".operation").val(id_operation);
  $(".id_prime").val(id_prime);

  $(".btnAdd").fadeOut();
  $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
}
function annulerSuppressionGazoil(){
  $(".btnAdd").fadeIn();
  $(".btnModif").fadeOut();
  $(".btnAnnuler").fadeOut();
}





function addEntree(status){
  numero = $(".numero").val();
  montant = $(".montant").val();
  ordonateur = $(".ordonateur").val();
  date = $(".datePrime").val();
  type = $(".camion").val();
  commentaire = $(".commentaire").val();
  
  camion = $(".camion").val();
  
  validite = $(".validite").val();
  vehicule = $(".vehicule").val();
  operation = $(".operation").val();
  arrivee = $(".arrivee").val();
  fournisseur = $(".fournisseur").val();
  
  id_prime = $(".id_prime").val();

  if (montant == "") {
  $(".montant").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
  }else if (validite == "") {
  $(".validite1").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (date == "") {
  $(".datePrime").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (ordonateur == "") {
  $(".ordonateur").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (numero == "") {
  $(".numero").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else{
  $(".montant").css("border","1px solid #ced4da");
  $(".ordonateur").css("border","1px solid #ced4da");
  $(".numero").css("border","1px solid #ced4da");
  $(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
   $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/addEntree",
      data:{"id_prime":id_prime,"status":status,"montant":montant,"ordonateur":ordonateur,"date":date,"commentaire":commentaire,"type":type,"numero":numero,"camion":camion,"validite":validite,"vehicule":vehicule,"operation":operation,"arrivee":arrivee,"fournisseur":fournisseur},
      success: function(data){  

        if ($.trim(data) == "Enregistrement de l'entrée réussie") {

        $('#example1').DataTable().destroy();
        afficheAllEntree('#example1');
          $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
        }else if ($.trim(data) == "Modification de l'entrée réussie") {

        $('#example1').DataTable().destroy();
        afficheAllEntree('#example1');
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
                // alert(data.responseText);
       }
       });
  }
}

function afficheAllEntree(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getAllEntree",
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


// fournisseur de la caisse


function afficheAllFournisseurCaisse(idTable){
  $(".chargementClient").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getAllFournisseurCaisse",
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

function addFournisseurCaisse(status){
  // alert(status);
  nom = $(".nom").val();
  commentaire = $(".commentaire").val();
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
      url:base_url+"/admin_caisse/addFournisseurCaisse",
      data:{"commentaire":commentaire,"status":status,"id_client":id_client,"nom":nom,"adresse":adresse,"telephone":telephone,"date_initial":date_initial,"solde_initial":solde_initial},
       success: function(data){
   if ($.trim(data) == "Insertion parfaite du fournisseur") {
    $(".nom").val("");
  $(".adresse").val("");
  $(".telephone").val("");
  $(".solde").val("0");
  
    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllFournisseurCaisse('#example1');
        $(".chargementCarteGrise1").fadeOut();
      }else if ($.trim(data) == "Modification parfaite du fournisseur") {
        $(".nom").val("");
  $(".adresse").val("");
  $(".telephone").val("");
  $(".solde").val("0");
    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllFournisseurCaisse('#example1');
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

function confirmSuppressionClient1(){
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
        afficheAllFournisseurCaisse('#example1');
        
          
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

function confirmSuppressionFournisseurCaisse(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/deleteFournisseurCaisse",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllFournisseurCaisse('#example1');
        
          
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

// nous passons donc à la facture
function infosFacture(id_facture,numero,id_fournisseur,date,libelle,montant){
 $(".montant").val(montant);
 $(".dateFacture").val(date);
 $(".numero").val(numero);
 $(".id_prime").val(id_facture);
 $(".id_fournisseur").val(id_fournisseur);
 $(".libelle").val(libelle);

  $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAdd").fadeOut();
}

function addFactureCaisse(status){
  montant = $(".montant").val();
  date = $(".dateFacture").val();
  numero = $(".numero").val();
  id_gazoil = $(".id_fournisseur").val();
  libelle = $(".libelle").val();
  id_facture = $(".id_prime").val();

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
  }else{
  $(".libelle").css("border","1px solid #ced4da");
  $(".montant").css("border","1px solid #ced4da");
  $(".dateFacture").css("border","1px solid #ced4da");
  $(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
   $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/addFactureCaisse",
      data:{"id_fournisseur":id_gazoil,"id_facture":id_facture,"status":status,"montant":montant,"numero":numero,"date":date,"libelle":libelle},
      success: function(data){  

        if ($.trim(data) == "Insertion parfaite de la facture") {
        $('#example1').DataTable().destroy();
        afficheAllFactureCaisse('#example1');
          $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
        }else if ($.trim(data) == "Facture modifiée") {

        $('#example1').DataTable().destroy();
        afficheAllFactureCaisse('#example1');
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
      });
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

function afficheAllFactureCaisse(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getAllFactureCaisse",
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

function confirmSuppressionFacture(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/deleteFactureFournisseurCaisse",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllFactureCaisse('#example1');
        
          
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


function addReglementCaisse(status){
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
      url:base_url+"/admin_caisse/addReglement",
      data:{"id_fournisseur":id_gazoil,"id_facture":id_regl,"status":status,"montant":montant,"numero":numero,"date":date,"libelle":libelle},
      success: function(data){  

        if ($.trim(data) == "Règlement de la facture effectué") {

        $('#example1').DataTable().destroy();
        afficheAllReglementCaisse('#example1');
          $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
        }else if ($.trim(data) == "Règlement modifié") {

        $('#example1').DataTable().destroy();
        afficheAllReglementCaisse('#example1');
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

function afficheAllReglementCaisse(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getAllReglement",
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

function confirmSuppressionReglementFournisseurCaisse(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/deleteReglementFournisseurCaisse",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllReglementCaisse('#example1');
        
          
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

// le code qui suit est celui de la balance


function afficheAllReglementPourBalanceCaisse(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getAllReglementPourBalanceCaisse",
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
function afficheAllFActurePourBalanceCaisse(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getAllFacturePourBalanceCaisse",
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
      url:base_url+"/admin_caisse/selectAllTotalFacturePourBalanceFournisseur",
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
      url:base_url+"/admin_caisse/selectAllTotalReglementPourBalanceFournisseur",
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
      url:base_url+"/admin_caisse/soldeCaisseFournisseur",
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
function getBalanceCaisse(){
  id_fournisseur = $(".id_fournisseur").val();
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
    if (id_fournisseur == "" && date_debut == "" && date_fin == "") {

  }else{
  soldeCaisseFournisseur(id_fournisseur,date_debut,date_fin);
  selectAllTotalFacturePourBalanceFournisseur(id_fournisseur,date_debut,date_fin);
selectAllTotalReglementPourBalanceFournisseur(id_fournisseur,date_debut,date_fin);
    $('#example2').DataTable().destroy();
  afficheAllFActurePourBalanceCaisse('#example2',id_fournisseur,date_debut,date_fin);

  $('#example1').DataTable().destroy();
  afficheAllReglementPourBalanceCaisse('#example1',id_fournisseur,date_debut,date_fin);
  }
}



function afficheAllEntreePourBalanceCaisse(idTable,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getAllEntreePourBalanceCaisse",
      data:{"date_debut":date_debut,"date_fin":date_fin},
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


function afficheAllSortiePourBalanceCaisse(idTable,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  // alert("debut "+date_debut+" fin "+date_fin);
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getAllSortiePourBalanceCaisse",
      data:{"date_debut":date_debut,"date_fin":date_fin},
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

function getSoldeCaisse2(date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getSoldeCaisse2",
      data:{"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        $(".solde").val("");
        formatMillierPourSelection(data,'solde');
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

function getTotalEntree2(date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getTotalEntree2",
      data:{"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        $(".totalEntree").val("");
        formatMillierPourSelection(data,'totalEntree');
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

function getTotalSortie2(date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getTotalSortie2",
      data:{"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        $(".totalSortie").val("");
        formatMillierPourSelection(data,'totalSortie');
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
function getBalanceCaisse2(){
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();

  getSoldeCaisse2(date_debut,date_fin);
  getTotalEntree2(date_debut,date_fin);
  getTotalSortie2(date_debut,date_fin);
    $('#example1').DataTable().destroy();
  afficheAllEntreePourBalanceCaisse('#example1',date_debut,date_fin);

  $('#example2').DataTable().destroy();
  afficheAllSortiePourBalanceCaisse('#example2',date_debut,date_fin);
  
}

function getEntreeParDate(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut !="" && date_fin !="") {
    $('#example1').DataTable().destroy();
  afficheAllEntree1('#example1');
  }
  
}

function getSortieParDate(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut !="" && date_fin !="") {
    $('#example1').DataTable().destroy();
  afficheAllSortie1('#example1');
  }
  
}



function getSortieParDate1(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut !="" && date_fin !="") {
    $('#example1').DataTable().destroy();
  afficheAllSortie2('#example1');
  }
  
}

function getFactureParDate(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  id_fournisseur1 = $(".id_fournisseur1").val();
  
  if (date_debut !="" && date_fin !="" && id_fournisseur1 !="") {
    $('#example1').DataTable().destroy();
  afficheAllFacture1('#example1');
  }
  
}

function getReglementParDate(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  id_fournisseur1 = $(".id_fournisseur1").val();
  
  if (date_debut !="" && date_fin !="" && id_fournisseur1 !="") {
    $('#example1').DataTable().destroy();
  afficheAllReglement1('#example1');
  }
  
}

function afficheAllSortie(idTable){
	
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getAllSortie",
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

function afficheAllSortie1(idTable){
	
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  validite1 = $(".validite1").val();
	
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getAllSortie",
      data:{"date_debut":date_debut,"date_fin":date_fin,"validite1":validite1},
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

function afficheAllSortie2(idTable){
	
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  validite1 = $(".validite1").val();
	
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getAllSortie2",
      data:{"date_debut":date_debut,"date_fin":date_fin,"validite1":validite1},
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


function afficheAllEntree1(idTable){
	
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  validite1 = $(".validite1").val();
	
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getAllEntree",
      data:{"date_debut":date_debut,"date_fin":date_fin,"validite1":validite1},
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

function afficheAllFacture1(idTable){
	
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
 id_fournisseur1 = $(".id_fournisseur1").val();
	
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getAllFactureCaisse",
      data:{"date_debut":date_debut,"date_fin":date_fin,"id_fournisseur1":id_fournisseur1},
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

function afficheAllReglement1(idTable){
	
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
 id_fournisseur1 = $(".id_fournisseur1").val();
	
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getAllReglement",
      data:{"date_debut":date_debut,"date_fin":date_fin,"id_fournisseur1":id_fournisseur1},
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

  // alert( formatMillier( 10000000));
function afficheAllCloture(idTable){
  $(".chargementLivraison").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getAllClotureCaisse",
      data:{},
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

function getTotalEntree3(date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getTotalEntree2",
      data:{"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        $(".entree").val("");
        $(".entree").val(data);
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
function getSoldeCaisse2(date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getSoldeCaisse2",
      data:{"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        $(".solde").val("");
        $(".solde").val(data);
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
function getTotalSortie3(date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getTotalSortie2",
      data:{"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        $(".sortie").val("");
        $(".sortie").val(data);
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

function infosClotureCaisse(ancienne_date,date_cloture,total_entree,total_sortie,solde,ordonateur,id_cloture){
  $(".date_cloture").val(date_cloture);
  $(".entree").val(total_entree);
  $(".sortie").val(total_sortie);
  $(".solde").val(solde);
  $(".ordonateur").val(ordonateur);
  $(".ancienne_date").val(ancienne_date);
  $(".id_BL").val(id_cloture);
  $(".btnModif").fadeIn();
  $(".btnAnnuler").fadeIn();
  $(".btnAdd").fadeOut();
}

function annulerModifLivraison(){
  $(".btnModif").fadeOut();
  $(".btnAnnuler").fadeOut();
  $(".btnAdd").fadeIn();
}



// le code qui suit est pour la cloture caisse

function getTotalEntree4(date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getTotalEntree3",
      data:{"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        $(".entree").val("");
        $(".entree").val(data);
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
function getSoldeCaisse4(date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getSoldeCaisse3",
      data:{"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        $(".solde").val("");
        // alert(date_debut);
        $(".solde").val(data);
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
function getTotalSortie4(date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getTotalSortie3",
      data:{"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){

        $(".sortie").val("");
        $(".sortie").val(data);
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
function totauxPourCloture(){
  date_cloture = $(".date_cloture").val();
  date = "";
  getTotalSortie4(date_cloture,date);
  getTotalEntree4(date_cloture,date);
  getSoldeCaisse4(date_cloture,date);
}
  function addClotureCaisse(status){
  date_cloture = $(".date_cloture").val();
  entree = $(".entree").val();
  sortie = $(".sortie").val();
  solde = $(".solde").val();
  ordonateur = $(".ordonateur").val();
  // cloturer = $(".cloturer").val();
  ancienne_date = $(".ancienne_date").val()
  id_BL = $(".id_BL").val();

if ($(".cloturer").is(":checked")) {
  cloturer = 1;
}else{
  cloturer = 0;
}
  if (date_cloture == "") {
    $(".date_cloture").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (entree== "") {
    $(".entree").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (sortie == "") {
    $(".sortie").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (solde == "") {
    $(".solde").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (ordonateur == "") {
    toastr.error("Veuillez remplir tous les Champs");
    $(".ordonateur").css("border","red 2px solid");
  }else{
    $(".date_cloture").css("border","1px solid #ced4da");
    $(".entree").css("border","1px solid #ced4da");
    $(".sortie").css("bo rder","1px solid #ced4da");
    $(".solde").css("border","1px solid #ced4da");
    $(".ordonateur").css("border","1px solid #ced4da");

      $(".chargementLivraison1").fadeIn();
  $.ajax({
          type:"POST",
          url:base_url+"/admin_caisse/addClotureCaisse",
          data:{"ancienne_date":ancienne_date,"cloturer":cloturer,"date_cloture":date_cloture,"status":status,"id_cloture":id_BL,"total_entree":entree,"total_sortie":sortie,"solde":solde,"ordonateur":ordonateur},
          success: function(data){  
            if ($.trim(data) == "Cloture effectuée") {
     $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
                $(".chargementLivraison1").fadeOut();
                $('#example1').DataTable().destroy();
                afficheAllCloture('#example1');
              }else if ($.trim(data) == "Modification parfaite de la cloture") {
                
     $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
     $(".chargementLivraison1").fadeOut();
                $('#example1').DataTable().destroy();
                afficheAllCloture('#example1');
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

function afficheLigneDemande(){
	nbreLigne = $(".nbreLigne").val();
$(".contentLignes").empty();
i=1;
$(".chargementPrime1").fadeIn();
conteneur = "";
 $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getNbreLigne1",
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

function getDetailDemmandePourModification(date_demande,po,etat_demande,lieu,rj, rj1, rj2, ligne){

		
		$('.po').val(po);
		$('.lieu').val(lieu);
		$('.date_demande').val(date_demande);
		$('.etat_demande').val(etat_demande);
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
		
		
 	

window.location = base_url+"/admin/demande_bon#details";
 $(".chargementPrime1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getListeDemmandePourModif",
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


function detailDemande(po,delegue,date_com,etat_exp,montant,montant1,signatureDAF,signatureDGT,compteur,lieu){
	
//	var imagejavascript = document.createElement("img");
//	imagejavascript.src = "https://www.miratransport.net/assets/image/signatureDAF.png";

	$('.po').val(po);
	
	
	$(".po2").empty();
	$(".po2").append(po+'<br/><br/>');
	
	$(".fournisseur").empty();
	$(".fournisseur").append(delegue);
	
	$(".lieu").empty();
	$(".lieu").append(lieu);
	
	$(".date_commande2").empty();
	$(".date_commande2").append(date_com);
	
	$(".etat_expedition2").empty();
	$(".etat_expedition2").append(etat_exp);
	
	$(".etat_expedition3").empty();
	$(".etat_expedition3").append(etat_exp);
	
	
	
	//$(".montant2").empty();
//	$(".montant2").append('<br/><br/><br/>'+montant);
	
	$(".chargementPrime2").fadeIn();
	window.location = base_url+"/admin/demande_bon#contentDetailCommande2";
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getDetailDemande",
      data:{"po":po},
      success: function(data){

        $(".contentDetailCommande2").empty();
        $(".contentDetailCommande2").append(data);
				
     //   $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td style="text-align : center; border:none; font-weight:10px;font-size: 15px; color:red;border-top:1px ;"> '+compteur+'</td></tr>');
   //   
	    $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td style="text-align : center; border:none; font-weight:10px;font-size: 15px; color:red;border-top:1px ;"> '+compteur+'</td><td colspan="4" style="text-align : right; border:none; font-weight:16px;font-size:20px; color:red; ">TOTAL   : </td><td colspan="2" style="text-align : center; border:none; font-weight:16px; font-size:20px;color:red; "> '   +montant1+'</td>'   +signatureDAF+'</tr>');
        
	//	$(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="5" style="text-align : right; border:none; font-weight:16px;font-size:30px; color:red; "></td><td colspan="5" style="text-align : left; border:none; font-weight:16px; font-size:30px;color:red; "></td></tr>');
        
		
	   
      //  $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="3" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;"></td><td style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;"></td><td colspan="3" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;">SIGNATURE :</td>'   +signatureDAF+'</tr>');
   
      $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="3" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;"></td><td style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;"></td><td colspan="3" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;"></td></tr>');
   
   
     //   $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="3" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;">SIGNATURE DAF :</td><td style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;"></td>'+signatureDAF+'<td colspan="3" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;"></td></tr>');
   

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


function detailDemandeRetour(po,delegue,date_com,etat_exp,montant,montant1,signatureDAF,signatureDGT,compteur){

	$('.po').val(po);
	
	
	$(".po2").empty();
	$(".po2").append(po+'<br/><br/>');
	
	$(".fournisseur").empty();
	$(".fournisseur").append(delegue);
	
	$(".date_commande2").empty();
	$(".date_commande2").append(date_com);
	
	$(".etat_expedition2").empty();
	$(".etat_expedition2").append(etat_exp);
	
	$(".etat_expedition3").empty();
	$(".etat_expedition3").append(etat_exp);
	
	
	
	//$(".montant2").empty();
//	$(".montant2").append('<br/><br/><br/>'+montant);
	
	$(".chargementPrime2").fadeIn();
	window.location = base_url+"/admin/demande_bon_retour#contentDetailCommande2";
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getDetailDemandeRetour",
      data:{"po":po},
      success: function(data){

        $(".contentDetailCommande2").empty();
        $(".contentDetailCommande2").append(data);
				
        $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td style="text-align : center; border:none; font-weight:16px;font-size: 30px; color:red;border-top:1px solid black;"> '+compteur+'</td><td colspan="3" style="text-align : right; border:none; font-weight:16px; color:red; border-top:1px solid black;"></td><td style="text-align : right; border:none; font-weight:16px; color:red; border-top:1px solid black;"</td><td style="text-align : right; border:none; font-weight:16px; color:red;border-top:1px solid black;">Total :</td><td style="text-align : center; border:none; font-weight:16px;font-size: 18px; color:red;border-top:1px solid black;">'+montant1+'</td></tr>');
   //   
	    $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="5" style="text-align : right; border:none; font-weight:16px;font-size:30px; color:red; ">TOTAL GENERAL   : </td><td colspan="5" style="text-align : left; border:none; font-weight:16px; font-size:30px;color:red; "> '   +montant1+' </td></tr>');
        
		$(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="5" style="text-align : right; border:none; font-weight:16px;font-size:30px; color:red; "></td><td colspan="5" style="text-align : left; border:none; font-weight:16px; font-size:30px;color:red; "></td></tr>');
        
		
	   
        $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="3" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;"></td><td style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;">SIGNATURE :</td>'   +signatureDAF+'<td colspan="3" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;"></td></tr>');
   
     //   $(".contentDetailCommande2").append('<tr style="text-align : right; border:none;"><td colspan="3" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;">SIGNATURE DAF :</td><td style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;"></td>'+signatureDAF+'<td colspan="3" style="text-align : center; border:none; font-weight:16px; color:red;border-top:none;"></td></tr>');
   

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




function nouveauCode(){
	   $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getNouveauCode",
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

function afficheLigneDemande(){
	nbreLigne = $(".nbreLigne").val();
$(".contentLignes").empty();
i=1;
$(".chargementPrime1").fadeIn();
conteneur = "";
 $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getNbreLigne1",
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


function addDemandeCaisse(status){

	
	date_demande = $(".date_demande").val();
	
	po = $(".po").val();
	
	
	poUP = $(".po").val();
	
	etat_demande = $(".etat_demande").val();
	
	lieu = $(".lieu").val();
	
	ordonateur = $(".ordonateur").val();
	
	nbreLigne = $(".nbreLigne").val();
	
	validite = [];
	camion = [];
	montant = [];
	vehicule = [];
	operation = [];
	fournisseur = [];
	
	arrivee = [];
	commentaire = [];
	
	rjFR = [];
	
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
	
	
	
	i=1;
	
if  (date_demande == ""){
		$('.date_demande').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
			 return;
	}else if (etat_demande == ""){
		$('.etat_demande').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
			 return;
	}else if (ordonateur == ""){
		$('.ordonateur').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
			 return;
	}else if (po == "") {
		$('.po').css("border","red 2px solid");
		    toastr.error("Veuillez remplir tous les Champs");
			 return;
	}else {
		$('.date_demande').css("border","1px solid #ced4da");
		$('.etat_demande').css("border","1px solid #ced4da");
		
		$('.ordonateur').css("border","1px solid #ced4da");
		$('.po').css("border","1px solid #ced4da");
		
}
		do{
			
	if (($('.validite'+i).val() == "Frais Route") || ($('.validite'+i).val() == "Frais Divers")  || ($('.validite'+i).val()  == "Prime") || ($('.validite'+i).val() == "Commission") || ($('.validite'+i).val() == "Depannage") || ($('.validite'+i).val() == "Prevision Navire")) {
    

   
	   if ($('.operation'+i).val() == "") {
		$('.operation'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.fournisseur'+i).val() == "") {
		$('.fournisseur'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.arrivee'+i).val() == "") {
		$('.arrivee'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.camion'+i).val() == "") {
		$('.camion'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
		return;
		}else if ($('.vehicule'+i).val() == "") {
		$('.vehicule'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
		return;
		}else if ($('.montant'+i).val() == "") {
		$('.montant'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
		return;
		}else if ($('.commentaire'+i).val() == "") {
		$('.commentaire'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
		return;
		}else {
		
			
		
		$('.validite'+i).css("border","1px solid #ced4da");
		$('.camion'+i).css("border","1px solid #ced4da");
		$('.montant'+i).css("border","1px solid #ced4da");
		$('.vehicule'+i).css("border","1px solid #ced4da");
		$('.operation'+i).css("border","1px solid #ced4da");
		$('.fournisseur'+i).css("border","1px solid #ced4da");
		$('.arrivee'+i).css("border","1px solid #ced4da");
		$('.commentaire'+i).css("border","1px solid #ced4da");
		
		
		validite[i] = $('.validite'+i).val();
		camion[i] = $('.camion'+i).val();
		montant[i] = $('.montant'+i).val();
		vehicule[i] = $('.vehicule'+i).val();
		operation[i] = $('.operation'+i).val();
		fournisseur[i] = $('.fournisseur'+i).val();
		
		arrivee[i] = $('.arrivee'+i).val();
		commentaire[i] = $('.commentaire'+i).val();
		id_demande[i] = $('.id_demande'+i).val();
		
	
	
	
	if ($('.rjFR'+i).prop('checked')) {

      rjFR[i]='oui';
	  
 montant[i]='0';	 

	
	  
	
    }else{

      rjFR[i] = 'non';

    }
	
	  }
	  
	  
	
	  
	
		
}


	if (($('.validite'+i).val() == "Reglement Fournisseur Caisse" ) || ($('.validite'+i).val() == "Reglement Fournisseur Article" ) || ($('.validite'+i).val() == "Reglement Fournisseur Gazoil" )|| ($('.validite'+i).val() == "Reglement Fournisseur MIRA SA" ) || ($('.validite'+i).val() == "Retour Fournisseur" )) {

   
   
	   if ($('.operation'+i).val() == "") {
		$('.operation'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.fournisseur'+i).val() == "") {
		$('.fournisseur'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.arrivee'+i).val() == "") {
		$('.arrivee'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.camion'+i).val() == "") {
		$('.camion'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
		return;
		}else if ($('.montant'+i).val() == "") {
		$('.montant'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
		return;
		}else if ($('.commentaire'+i).val() == "") {
		$('.commentaire'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
		return;
		}else {
		
			
		
		$('.validite'+i).css("border","1px solid #ced4da");
		$('.camion'+i).css("border","1px solid #ced4da");
		$('.montant'+i).css("border","1px solid #ced4da");
		$('.vehicule'+i).css("border","1px solid #ced4da");
		$('.operation'+i).css("border","1px solid #ced4da");
		$('.fournisseur'+i).css("border","1px solid #ced4da");
		$('.arrivee'+i).css("border","1px solid #ced4da");
		$('.commentaire'+i).css("border","1px solid #ced4da");
		
		
		validite[i] = $('.validite'+i).val();
		camion[i] = $('.camion'+i).val();
		montant[i] = $('.montant'+i).val();
		vehicule[i] = $('.vehicule'+i).val();
		operation[i] = $('.operation'+i).val();
		fournisseur[i] = $('.fournisseur'+i).val();
		
		arrivee[i] = $('.arrivee'+i).val();
		commentaire[i] = $('.commentaire'+i).val();
		id_demande[i] = $('.id_demande'+i).val();
		
	
	
	
	if ($('.rjFR'+i).prop('checked')) {

      rjFR[i]='oui';
	  
	montant[i]='0';
	  
	
    }else{

      rjFR[i] = 'non';

    }
	
	  }
	  
	  
	
	  
	
		
}


if (($('.validite'+i).val() == "Autre" ) || ($('.validite'+i).val() == "Retour En Caisse" ))  {

   
	   if ($('.operation'+i).val() == "") {
		$('.operation'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.fournisseur'+i).val() == "") {
		$('.fournisseur'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.arrivee'+i).val() == "") {
		$('.arrivee'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
				 return;
		}else if ($('.camion'+i).val() == "") {
		$('.camion'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
		return;
		}else if ($('.montant'+i).val() == "") {
		$('.montant'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
		return;
		}else if ($('.commentaire'+i).val() == "") {
		$('.commentaire'+i).css("border","red 2px solid");
			    toastr.error("Veuillez remplir tous les Champs");
		return;
		}else {
		
			
		
		$('.validite'+i).css("border","1px solid #ced4da");
		$('.camion'+i).css("border","1px solid #ced4da");
		$('.montant'+i).css("border","1px solid #ced4da");
		$('.vehicule'+i).css("border","1px solid #ced4da");
		$('.operation'+i).css("border","1px solid #ced4da");
		$('.fournisseur'+i).css("border","1px solid #ced4da");
		$('.arrivee'+i).css("border","1px solid #ced4da");
		$('.commentaire'+i).css("border","1px solid #ced4da");
		
		
		validite[i] = $('.validite'+i).val();
		camion[i] = $('.camion'+i).val();
		montant[i] = $('.montant'+i).val();
		vehicule[i] = $('.vehicule'+i).val();
		operation[i] = $('.operation'+i).val();
		fournisseur[i] = $('.fournisseur'+i).val();
		
		arrivee[i] = $('.arrivee'+i).val();
		commentaire[i] = $('.commentaire'+i).val();
		id_demande[i] = $('.id_demande'+i).val();
		
	
	
	
	if ($('.rjFR'+i).prop('checked')) {

      rjFR[i]='oui';
	  
	 montant[i]='0';
	  
	
    }else{

      rjFR[i] = 'non';

    }
	
	  }
	  
	  
	
	  
	
		
}
	


		i++;
		}while(i<=nbreLigne)
			
		
		
//	if (validite.length >nbreLigne && camion.length>nbreLigne && montant.length>nbreLigne && commentaire.length>nbreLigne) {
$(".chargementPrime1").fadeIn();
// alert(status);
	   $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/addDemandeCaisse",
      data:{"status":status,"etat_demande":etat_demande,"ordonateur":ordonateur,"lieu":lieu,"po":po,"poUP":poUP,"date_demande":date_demande,"nbreLignes":nbreLigne,"rj":rj,"rj1":rj1,'id_demande':JSON.stringify(id_demande),'validite':JSON.stringify(validite),'camion':JSON.stringify(camion),'montant':JSON.stringify(montant),'vehicule':JSON.stringify(vehicule),'operation':JSON.stringify(operation),'fournisseur':JSON.stringify(fournisseur),'arrivee':JSON.stringify(arrivee),'commentaire':JSON.stringify(commentaire),'rjFR':JSON.stringify(rjFR)},
      success: function(data){
      	if ($.trim(data) == "Insertion parfaite de la demande de bon de caisse") {
		      		$(".chargementPrime1").fadeOut();
		      	 $(document).Toasts('create', {
		        class: 'bg-success', 
		        title: 'Success',
		        subtitle: 'Alert',
		        body: data
		      }) 
			  
			  $(".contentLignes").empty();
			 
		      	 
		  //    $(".po").val("");
		      nouveauCode();
			  $(".nbreLigne").val("0");
			  
			 
			  
			     
		      	 $('#example1').DataTable().destroy();
		      	 afficheAllDemandeCaisse("#exemple1");
				 
				 
				 
		      	}else if ($.trim(data) == "Modification parfaite de la demande de bon de caisse") {
		      		$(".chargementPrime1").fadeOut();
		      	 $(document).Toasts('create', {
		        class: 'bg-success', 
		        title: 'Success',
		        subtitle: 'Alert',
		        body: data
		      }) 


				$('#example1').DataTable().destroy();
		      	 afficheAllDemandeCaisse("#exemple1");

			 $(".po").val("");
			  $(".nbreLigne").val("0");
			  
			  $(".contentLignes").empty();
			  
			  nouveauCode();
			  
			  $(".btnAnnulerModif").fadeIn();
			 $(".btnModif").fadeOut();
			 
	 
		      	}else{
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


function getAllDemandeCaisse(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut !="" && date_fin !="") {
    $('#example1').DataTable().destroy();
  afficheAllDemandeCaisse('#example1');
  }
  
}

function getAllDemandeCaisseRetour(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (date_debut !="" && date_fin !="") {
    $('#example1').DataTable().destroy();
  afficheAllDemandeCaisseRetour('#example1');
  }
  
}


function afficheAllDemandeCaisse(idTable){
	 
	 validite1 = $(".validite1").val();
	date_debut = $(".date_debut").val();
	date_fin = $(".date_fin").val();
	
	
	
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getAllDemandeCaisse",
      data:{"date_fin":date_fin,"date_debut":date_debut,"validite1":validite1},
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


function afficheAllDemandeCaisseRetour(idTable){
	 
	 validite1 = $(".validite1").val();
	date_debut = $(".date_debut").val();
	date_fin = $(".date_fin").val();
	
	
	
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getAllDemandeCaisseRetour",
      data:{"date_fin":date_fin,"date_debut":date_debut,"validite1":validite1},
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



function totalCumLigne(){
	
	i=1;
	
	totalLigne1 = 0;
	
	nbreLigne = $(".nbreLigne").val();
	
	
do{
		
		totalLigne1 = totalLigne1 + parseInt($('.montant'+i).val());
	
		i++;
		
}while(i<=nbreLigne)	
		
		$(".totalLigne").val(totalLigne1);

}

function verifMatriculeInTabInput(classe){

    bl = $("."+classe).val();

    nbreLignes = $(".nbreLigne").val();

    tabArt = [];
	
	tabArt2 = [];


	//alert(nbreLignes);
    i=0;

	 while(i<=nbreLignes){
			if ("vehicule"+i!= classe){
			tabArt2[i]= $(".vehicule"+i).val();
			}
				
			
		  i++;

	  }

		i=0;
     while(i<=nbreLignes){



       if(bl == tabArt2[i]){

            toastr.error('Cette Immatriculation a déjà été sélectionné veuillez changer svp');

            $("."+classe).val("");
			
            return;

        }

      i++;

  }



}



function imprimer(divName){
	// alert(divName)
	var printContents = document.getElementById(divName).innerHTML;
	var originalContents = document.body.innerHTML;
	document.body.innerHTML = printContents;
	window.print();
	document.body.innerHTML = originalContents;

}

function imprimer_bloc(titre, objet, numero) {
// Définition de la zone à imprimer
var zone = document.getElementById(objet).innerHTML;

var poData = document.getElementById(numero);

var po = poData.value;


//console.log("po", po);

 
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





$.ajax({
      type:"POST",
      url:base_url+"/admin_caisse/getEtatPrint",
      data:{"po":po},
      success: function(data){

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


win.close();


}
	





