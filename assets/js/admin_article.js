function ceerDatatable(id) {
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
      "sProcessing": "Traitement en cours...",
      "sSearch": "Rechercher&nbsp;:",
      "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
      "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
      "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
      "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
      "sInfoPostFix": "",
      "sLoadingRecords": "Chargement en cours...",
      "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
      "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
      "oPaginate": {
        "sFirst": "Premier",
        "sPrevious": "Pr&eacute;c&eacute;dent",
        "sNext": "Suivant",
        "sLast": "Dernier"
      },
      "oAria": {
        "sSortAscending": ": activer pour trier la colonne par ordre croissant",
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

function ceerDatatableFacture(id) {

  table = $(id).DataTable({

    // "lengthChange": false,

    "searching": true,

    "ordering": false,

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

        title: "",

        message: ' <table class="table table-bordered table-striped" cellpadding="0" cellspacing="0"><thead><tr ><th style="border: 5px solid #0e2d86; border-right: none; border-left: none; text-align:center;"><img src="' + base_url + '/assets/image/mira.jpg" style="height:100px;"><span style="color: blue; font-weight: bold; font-size: 55px; text-align: center; ">SOCIETE MIRA S.A</span> <br><table cellpadding="0" cellspacing="0" style="text-align:center; margin-left:200px;"><tr><td colspan="12">Négoce - Import - Export - Matériaux de construction - Représentation - Activités industrielles - Activités maritimes - BTP - Transport</td> </tr><tr><td colspan="13" style="color: blue; font-weight: bold; font-size: 25px; text-align: center;">RECAPITULATIF DES FACTURES FOURNISSEURS</td> </tr> </table></th><th style="border: 5px solid #0e2d86; border-left: none; border-right: none;"></th></tr><tr><td colspan="12"  style="border: none;"></td> </tr></th></tr></thead></table>'

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

      "sProcessing": "Traitement en cours...",

      "sSearch": "Rechercher&nbsp;:",

      "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",

      "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",

      "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",

      "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",

      "sInfoPostFix": "",

      "sLoadingRecords": "Chargement en cours...",

      "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",

      "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",

      "oPaginate": {

        "sFirst": "Premier",

        "sPrevious": "Pr&eacute;c&eacute;dent",

        "sNext": "Suivant",

        "sLast": "Dernier"

      },

      "oAria": {

        "sSortAscending": ": activer pour trier la colonne par ordre croissant",

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


function getBalanceImprimableClient() {
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

  } else if (date_debut == "" || date_fin == "") {

  }
  else {

    $.ajax({
      type: "POST",
      url: base_url + "/admin_article/verifiDateInitialClient",
      data: { "date_initial": date_debut, "id_client": id_fournisseur },
      success: function (data) {
        if ($.trim(data) == "ok") {
          // facturePourBalanceClient('test');
          $(".date_debut1").empty();
          $(".date_debut1").append(date_debut);

          $(".date_fin1").empty();
          $(".date_fin1").append(date_fin);

          soldeCaisseClient2(id_fournisseur, date_debut, date_fin);
          selectAllTotalAccuseRetraitPourBalanceClient(id_fournisseur, date_debut, date_fin);
          selectAllTotalAccuseReglementPourBalanceClient(id_fournisseur, date_debut, date_fin);

          $('#example1').DataTable().destroy();
          getBalanceImprimableClient2('#example1', id_fournisseur, date_debut, date_fin)

          repportNouveau(id_fournisseur, date_debut, date_fin);
          repportNouveauCredit(id_fournisseur, date_debut, date_fin);
          repportNouveauDebit(id_fournisseur, date_debut, date_fin);
          getDebitPourBalanceImpCLient(id_fournisseur, date_debut, date_fin);
          getCreditPourBalanceImpCLient(id_fournisseur, date_debut, date_fin);
        } else {
          $(document).Toasts('create', {
            class: 'bg-danger',
            title: 'Erreur de connexion',
            subtitle: 'Alert',
            body: data
          })
        }
      },
      error: function (data) {
        $(document).Toasts('create', {
          class: 'bg-danger',
          title: 'Erreur de connexion',
          subtitle: 'Alert',
          body: 'Erreur vérifier votre connexion ou contactez l\'administrateur ' + data.responseText
        })
        $(".chargementClient1").fadeOut();

      }
    });

  }
}

/***
 * SKT Work
 */
function getBalanceOfClientOrVendor() {
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

  } else if (date_debut == "" || date_fin == "") {

  }
  else {

    $.ajax({
      type: "POST",
      url: base_url + "/Odoo_controller/AddPaimentFournisseurInOdoo",
      data: { "id_fournisseur": id_fournisseur, "date_debut": date_debut, "date_fin": date_fin },
      success: function (data) {
        console.log("data:", data);
      },
      error: function (data) {

      }
    });

  }
}

function ceerDatatable2(id) {
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
        customize: function (win) {
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
        title: '',
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
      "sProcessing": "Traitement en cours...",
      "sSearch": "Rechercher&nbsp;:",
      "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
      "sInfo": "Affichage de l'&eacute;l&eacute;ment _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
      "sInfoEmpty": "Affichage de l'&eacute;l&eacute;ment 0 &agrave; 0 sur 0 &eacute;l&eacute;ment",
      "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
      "sInfoPostFix": "",
      "sLoadingRecords": "Chargement en cours...",
      "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
      "sEmptyTable": "Aucune donn&eacute;e disponible dans le tableau",
      "oPaginate": {
        "sFirst": "Premier",
        "sPrevious": "Pr&eacute;c&eacute;dent",
        "sNext": "Suivant",
        "sLast": "Dernier"
      },
      "oAria": {
        "sSortAscending": ": activer pour trier la colonne par ordre croissant",
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


function getDateInitialClient(id_fournisseur) {
  $(".chargementClient1").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/getDateInitialClient",
    data: { "id_client": id_fournisseur },
    success: function (data) {
      // alert(data);
      $(".date_initial").val("");
      $(".date_initial").val(data);

      $(".date_initial1").empty();
      $(".date_initial1").append(data);
      // formAddRemorque();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur ' + data.responseText
      })
      $(".chargementClient1").fadeOut();
    }
  });
}


function getSoldeInitialClient(id_fournisseur) {

  $(".chargementClient1").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/getSoldeInitialClient",
    data: { "id_client": id_fournisseur },
    success: function (data) {
      // alert(data);
      formatMillierPourSelection(data, 'solde_initial');
      nombre = data;
      nombre = nombre.replace(/ /g, '');
      nombre += '';

      var sep = ' ';
      var reg = /(\d+)(\d{3})/;

      while (reg.test(nombre)) {
        nombre = nombre.replace(reg, '$1' + sep + '$2');
      }

      $(".solde_initial1").empty();
      $(".solde_initial1").append(nombre + " FCFA(" + NumberToLetter(data) + " FCFA)");
      // formAddRemorque();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur ' + data.responseText
      })
      $(".chargementClient1").fadeOut();
    }
  });
}


function getNomClient(id_fournisseur) {
  $(".chargementClient1").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/getNomClient",
    data: { "id_client": id_fournisseur },
    success: function (data) {
      // alert(data);
      $(".client").empty();
      $(".client").append(data);

      // formAddRemorque();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur ' + data.responseText
      })
      $(".chargementClient1").fadeOut();
    }
  });
}

function getVilleClient(id_fournisseur) {
  $(".chargementClient1").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_matiere/getVilleClient",
    data: { "id_client": id_fournisseur },
    success: function (data) {
      // alert(data);
      $(".villeClient").empty();
      $(".villeClient").append(data);
      // formAddRemorque();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur ' + data.responseText
      })
      $(".chargementClient1").fadeOut();
    }
  });
}

function getAdresseClient(id_fournisseur) {
  $(".chargementClient1").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/getAdresseClient",
    data: { "id_client": id_fournisseur },
    success: function (data) {
      // alert(data);
      $(".adresseClient").empty();
      $(".adresseClient").append(data);

      // formAddRemorque();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur ' + data.responseText
      })
      $(".chargementClient1").fadeOut();
    }
  });
}


function getTelephoneClient(id_fournisseur) {
  $(".chargementClient1").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/getTelephoneClient",
    data: { "id_client": id_fournisseur },
    success: function (data) {
      // alert(data);
      $(".telephoneClient").empty();
      $(".telephoneClient").append(data);
      // formAddRemorque();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur ' + data.responseText
      })
      $(".chargementClient1").fadeOut();
    }
  });
}

function soldeCaisseClient2(id_fournisseur, date_debut, date_fin) {
  $(".chargementPrime").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/soldeCaisseClient2",
    data: { "id_operation": id_fournisseur, "id_fournisseur": id_fournisseur, "date_debut": date_debut, "date_fin": date_fin },
    success: function (data) {
      // alert(data);
      $(".solde").val("");
      formatMillierPourSelection(data, 'solde');
      nombre = data;
      nombre = nombre.replace(/ /g, '');
      nombre += '';

      var sep = ' ';
      var reg = /(\d+)(\d{3})/;

      while (reg.test(nombre)) {
        nombre = nombre.replace(reg, '$1' + sep + '$2');
      }

      $(".solde1").empty();
      $(".solde1").append(nombre + " FCFA(" + NumberToLetter(data) + " FCFA)");
      $(".chargementPrime").fadeOut();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })
      $(".chargementPrime").fadeOut();
    }
  });
}

function selectAllTotalAccuseRetraitPourBalanceClient(id_fournisseur, date_debut, date_fin) {
  $(".chargementPrime").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/getAllTotalAccuseRetraitPourBalance2",
    data: { "id_operation": id_fournisseur, "id_fournisseur": id_fournisseur, "date_debut": date_debut, "date_fin": date_fin },
    success: function (data) {
      // alert(data);
      $(".totalReglement").val("");
      formatMillierPourSelection(data, 'totalReglement');
      $(".chargementPrime").fadeOut();

      nombre = data;
      nombre = nombre.replace(/ /g, '');
      nombre += '';

      var sep = ' ';
      var reg = /(\d+)(\d{3})/;

      while (reg.test(nombre)) {
        nombre = nombre.replace(reg, '$1' + sep + '$2');
      }

      $(".credit").empty();
      $(".credit").append(nombre + " FCFA(" + NumberToLetter(data) + " FCFA)");
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })

      $(".chargementPrime").fadeOut();
    }
  });
}

function selectAllTotalAccuseReglementPourBalanceClient(id_fournisseur, date_debut, date_fin) {
  $(".chargementPrime").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/getAllTotalAccuseReglementPourBalance2",
    data: { "id_operation": id_fournisseur, "id_fournisseur": id_fournisseur, "date_debut": date_debut, "date_fin": date_fin },
    success: function (data) {
      // alert(data);
      $(".totalRetrait5").val("");
      formatMillierPourSelection(data, 'totalRetrait5');

      nombre = data;
      nombre = nombre.replace(/ /g, '');
      nombre += '';

      var sep = ' ';
      var reg = /(\d+)(\d{3})/;

      while (reg.test(nombre)) {
        nombre = nombre.replace(reg, '$1' + sep + '$2');
      }

      $(".debit").empty();
      $(".debit").append(nombre + " FCFA(" + NumberToLetter(data) + " FCFA)");
      $(".chargementPrime").fadeOut();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })
      $(".chargementPrime").fadeOut();
    }
  });
}

function getBalanceImprimableClient2(idTable, id_fournisseur, date_debut, date_fin) {
  $(".chargementPrime").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/getBalanceImprimableClient",
    data: { "id_client": id_fournisseur, "id_fournisseur": id_fournisseur, "date_debut": date_debut, "date_fin": date_fin },
    success: function (data) {
      // alert(data);
      $(".contentClient").empty();
      $(".contentClient").append(data);
      ceerDatatable2(idTable)
      $(".chargementClient").fadeOut();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })
      $(".chargementPrime").fadeOut();
    }
  });
}

function repportNouveau(id_fournisseur, date_debut, date_fin) {
  $(".chargementPrime").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/repportNouveau",
    data: { "id_client": id_fournisseur, "id_fournisseur": id_fournisseur, "date_debut": date_debut, "date_fin": date_fin },
    success: function (data) {
      // alert(data);
      $(".repportNouveau").val("");
      formatMillierPourSelection(data, 'repportNouveau');
      nombre = data;
      nombre = nombre.replace(/ /g, '');
      nombre += '';

      var sep = ' ';
      var reg = /(\d+)(\d{3})/;

      while (reg.test(nombre)) {
        nombre = nombre.replace(reg, '$1' + sep + '$2');
      }

      $(".repportNouveau1").empty();
      $(".repportNouveau1").append(nombre + " FCFA(" + NumberToLetter(data) + " FCFA)");
      $(".chargementPrime").fadeOut();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })
      $(".chargementPrime").fadeOut();
    }
  });
}

function repportNouveauCredit(id_fournisseur, date_debut, date_fin) {
  $(".chargementPrime").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/repportNouveauCredit",
    data: { "id_client": id_fournisseur, "id_fournisseur": id_fournisseur, "date_debut": date_debut, "date_fin": date_fin },
    success: function (data) {
      // alert(data);
      $(".repportNouveauCredit").val("");
      formatMillierPourSelection(data, 'repportNouveauCredit');
      nombre = data;
      nombre = nombre.replace(/ /g, '');
      nombre += '';

      var sep = ' ';
      var reg = /(\d+)(\d{3})/;

      while (reg.test(nombre)) {
        nombre = nombre.replace(reg, '$1' + sep + '$2');
      }

      $(".repportNouveauCredit1").empty();
      $(".repportNouveauCredit1").append(nombre + " FCFA(" + NumberToLetter(data) + " FCFA)");
      $(".chargementPrime").fadeOut();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })
      $(".chargementPrime").fadeOut();
    }
  });
}

function getCreditPourBalanceImpCLient(id_fournisseur, date_debut, date_fin) {
  $(".chargementPrime").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/getCreditPourBalanceImpCLient",
    data: { "id_operation": id_fournisseur, "id_fournisseur": id_fournisseur, "date_debut": date_debut, "date_fin": date_fin },
    success: function (data) {
      // alert(data);
      $(".dedit").val("");
      formatMillierPourSelection(data, 'dedit');
      $(".chargementPrime").fadeOut();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })
      $(".chargementPrime").fadeOut();
    }
  });
}


function getDebitPourBalanceImpCLient(id_fournisseur, date_debut, date_fin) {
  $(".chargementPrime").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/getDebitPourBalanceImpCLient",
    data: { "id_operation": id_fournisseur, "id_fournisseur": id_fournisseur, "date_debut": date_debut, "date_fin": date_fin },
    success: function (data) {
      // alert(data);
      $(".debit").val("");
      formatMillierPourSelection(data, 'debit');
      $(".chargementPrime").fadeOut();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })
      $(".chargementPrime").fadeOut();
    }
  });
}

function repportNouveauDebit(id_fournisseur, date_debut, date_fin) {
  $(".chargementPrime").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/repportNouveauDebit",
    data: { "id_client": id_fournisseur, "id_fournisseur": id_fournisseur, "date_debut": date_debut, "date_fin": date_fin },
    success: function (data) {
      // alert(data);
      $(".repportNouveauDebit").val("");
      formatMillierPourSelection(data, 'repportNouveauDebit');
      nombre = data;
      nombre = nombre.replace(/ /g, '');
      nombre += '';

      var sep = ' ';
      var reg = /(\d+)(\d{3})/;

      while (reg.test(nombre)) {
        nombre = nombre.replace(reg, '$1' + sep + '$2');
      }

      $(".repportNouveauDebit1").empty();
      $(".repportNouveauDebit1").append(nombre + " FCFA(" + NumberToLetter(data) + " FCFA)");
      $(".chargementPrime").fadeOut();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })
      $(".chargementPrime").fadeOut();
    }
  });
}




function addArticle(status) {
  // reference = $(".reference").val();
  numero = $(".numero").val();
  commentaire = $(".commentaire").val();
  id_fournisseur = $(".id_fournisseur1").val();
  article = $(".article").val();
  codeBarre = $(".codeBarre").val();
  fournisseur = $(".fournisseur").val();
  seuilCommande = $(".seuilCommande").val();
  manufacturier = $(".manufacturier").val();
  categorie = $(".categorie").val();
  PU = $(".PU").val();
  id_BL = $(".id_BL").val();


  if (numero == "") {
    $(".numero").css("border", "red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  } else if (article == "") {
    $(".article").css("border", "red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  } else if (codeBarre == "") {
    $(".codeBarre").css("border", "red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  } else if (fournisseur == "") {
    $(".fournisseur").css("border", "red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  } else if (seuilCommande == "") {
    toastr.error("Veuillez remplir tous les Champs");
    $(".seuilCommande").css("border", "red 2px solid");
  } else if (PU == "") {
    $(".PU").css("border", "red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  } else if (manufacturier == "") {
    $(".manufacturier").css("border", "red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  } else {
    // $(".reference").css("border","1px solid #ced4da");
    $(".numero").css("border", "1px solid #ced4da");
    $(".article").css("border", "1px solid #ced4da");
    $(".codeBarre").css("bo rder", "1px solid #ced4da");
    $(".fournisseur").css("border", "1px solid #ced4da");
    $(".seuilCommande").css("border", "1px solid #ced4da");
    $(".manufacturier").css("border", "1px solid #ced4da");
    $(".PU").css("border", "1px solid #ced4da");
    $(".chargementLivraison1").fadeIn();
    $.ajax({
      type: "POST",
      url: base_url + "/admin_article/addArticle",
      data: { "reference": "", "commentaire": commentaire, "categorie": categorie, "status": status, "id_BL": id_BL, "numero": numero, "article": article, "codeBarre": codeBarre, "fournisseur": fournisseur, "id_fournisseur": id_fournisseur, "manufacturier": manufacturier, "seuilCommande": seuilCommande, "PU": PU },
      success: function (data) {
        if ($.trim(data) == "Création parfaite de l'article") {
          $(document).Toasts('create', {
            class: 'bg-success',
            title: 'Alert',
            subtitle: 'Alert',
            body: data
          })
          $(".chargementLivraison1").fadeOut();
          $('#example1').DataTable().destroy();
          afficheAllArticle('#example1');
        } else if ($.trim(data) == "Modification parfaite de l'article") {

          $(document).Toasts('create', {
            class: 'bg-success',
            title: 'Alert',
            subtitle: 'Alert',
            body: data
          })
          $(".chargementLivraison1").fadeOut();
          $('#example1').DataTable().destroy();
          afficheAllArticle('#example1');
        } else {
          $(".chargementLivraison1").fadeOut();
          $(document).Toasts('create', {
            class: 'bg-danger',
            title: 'Erreur de connexion',
            subtitle: 'Alert',
            body: data
          })

        }

      },
      error: function (data) {
        $(".chargementLivraison1").fadeOut();
        $(document).Toasts('create', {
          class: 'bg-danger',
          title: 'Erreur de connexion',
          subtitle: 'Alert',
          body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
        })

      }
    });
  }
}

function afficheAllArticle(idTable) {
  $(".chargementLivraison").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/getAllArticle",
    data: {},
    success: function (data) {

      $(".contentLivraison").empty();
      $(".contentLivraison").append(data);
      ceerDatatable(idTable)
      $(".chargementLivraison").fadeOut();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })
      $(".chargementLivraison").fadeOut();
    }
  });
}


function selectAllFactureParFournisseur(idTable) {
  $(".chargementPrime").fadeIn();
  $('#example1').DataTable().destroy();
  id_fournisseur = $(".id_fournisseur").val();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/selectAllFactureParFournisseur",
    data: { "id_fournisseur": id_fournisseur },
    success: function (data) {

      $(".contentPrime").empty();
      $(".contentPrime").append(data);
      ceerDatatable(idTable)
      $(".chargementPrime").fadeOut();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })
      $(".chargementPrime").fadeOut();
    }
  });
}

function selectAllReglementParFournisseur(idTable) {
  $(".chargementPrime").fadeIn();
  $('#example1').DataTable().destroy();
  id_fournisseur = $(".id_fournisseur").val();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/selectAllReglementParFournisseur",
    data: { "id_fournisseur": id_fournisseur },
    success: function (data) {

      $(".contentPrime").empty();
      $(".contentPrime").append(data);
      ceerDatatable(idTable)
      $(".chargementPrime").fadeOut();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })
      $(".chargementPrime").fadeOut();
    }
  });
}

function getMontant() {
  $(".chargementPrime1").fadeIn();
  id_bl = $(".id_bl").val();
  id_fournisseur = $(".id_fournisseur").val();
  $.ajax({
    type: "POST",
    url: base_url + "/Admin_article/getMontantBL",
    data: { "id_bl": id_bl, "id_fournisseur": id_fournisseur },
    success: function (data) {
      $(".montant").val(data);
      formatMillierPourSelection(data, 'montant');
      $(".chargementPrime1").fadeOut();
    },
    error: function (data) {
      alert(data.responseText);
      $(".chargementPrime1").fadeOut();
    }
  });

}

function leSelectBLParFournisseur() {
  $(".chargementPrime1").fadeIn();
  $(".id_bl").empty();
  $(".id_bl").append("<option value='0'></option>");
  id_bl = $(".id_fournisseur").val();
  $.ajax({
    type: "POST",
    url: base_url + "/Admin_article/leSelectBLParFournisseur",
    data: { "id_fournisseur": id_bl },
    success: function (data) {
      $(".id_bl").append(data);
      // alert(data);
      $(".chargementPrime1").fadeOut();
    },
    error: function (data) {
      alert(data.responseText);
      $(".chargementPrime1").fadeOut();
    }
  });

}

function confirmSuppressionArticle() {
  table = $(".table").val();
  identifiant = $(".identifiant").val();
  nom_id = $(".nom_id").val();
  // creerDatable("exemple1");
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/deleteArticle",
    data: { "table": table, "identifiant": identifiant, "nom_id": nom_id },
    success: function (data) {

      toastr.success(data);
      $('#example1').DataTable().destroy();
      afficheAllArticle('#example1');


    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })

    }
  });
}

function confirmSuppressionClotureArticle() {
  table = $(".table").val();
  identifiant = $(".identifiant").val();
  nom_id = $(".nom_id").val();
  // creerDatable("exemple1");
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/deleteClotureArticle",
    data: { "table": table, "identifiant": identifiant, "nom_id": nom_id },
    success: function (data) {

      toastr.success(data);
      $('#example1').DataTable().destroy();
      afficheAllArticle('#example1');


    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })

    }
  });
}

function infosLivraison(numero, article, PU, codeBarre, fournisseur, manufacturier, seuilCommande, id_BL, commentaire, reference, id_fournisseur) {
  // $(".reference").val(reference);
  $(".id_BL").val(id_BL);
  $(".commentaire").val(commentaire);
  $(".numero").val(numero);
  $(".article").val(article);
  $(".codeBarre").val(codeBarre);
  $(".fournisseur").val(fournisseur);
  $(".id_fournisseur1").val(id_fournisseur);
  $(".seuilCommande").val(seuilCommande);
  $(".manufacturier").val(manufacturier);
  $(".PU").val(PU);

  $(".btnModif").fadeIn();
  $(".btnAnnuler").fadeIn();
  $(".btnAdd").fadeOut();
}

function annulerModifLivraison() {
  $(".btnModif").fadeOut();
  $(".btnAnnuler").fadeOut();
  $(".btnAdd").fadeIn();
}


// type article


function addTypeArticle(status) {
  id_client = $(".id_client").val();
  nom_type = $(".type").val();
  commentaire = $(".commentaire").val();
  id_type_pneu = $(".id_type_pneu1").val();
  if (nom_type == "") {
    $(".type").css("border", "red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  } else {
    // alert(nom_type);
    $(".type").css("border", "1px solid #ced4da");
    $.ajax({
      type: "POST",
      url: base_url + "/admin_article/addTypeArticle",
      data: { "id_client": id_client, "categorie": nom_type, "commentaire": commentaire, "id_type_pneu": id_type_pneu, "status": status },
      success: function (data) {
        if ($.trim(data) == "Insertion parfaite de la catégorie d'article") {
          $(document).Toasts('create', {
            class: 'bg-success',
            title: 'Success',
            subtitle: 'Alert',
            body: data
          })
          $('#example').DataTable().destroy();
          afficheAllTypeArticle('#example');
          // $('#example1').DataTable().destroy();
          // afficheAllPneu('#example1');
        } else if ($.trim(data) == "Modification parfaite du la catégorie") {
          $(document).Toasts('create', {
            class: 'bg-success',
            title: 'Success',
            subtitle: 'Alert',
            body: data
          })
          $('#example').DataTable().destroy();
          afficheAllTypeArticle('#example');
          // $('#example1').DataTable().destroy();
          // afficheAllPneu('#example1');
        } else {
          $(document).Toasts('create', {
            class: 'bg-danger',
            title: 'Erreur de connexion',
            subtitle: 'Alert',
            body: data
          })
        }


      },
      error: function (data) {
        $(document).Toasts('create', {
          class: 'bg-danger',
          title: 'Erreur de connexion',
          subtitle: 'Alert',
          body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
        })

      }
    });
  }
}

function afficheAllTypeArticle(idTable) {
  $(".chargementTypeArticle").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/getAllTypeArticle",
    data: {},
    success: function (data) {

      $(".contentTypeArticle").empty();
      $(".contentTypeArticle").append(data);
      ceerDatatable(idTable);
      $(".chargementTypeArticle").fadeOut();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })
      $(".chargementTypeArticle").fadeOut();
    }
  });
}

function infosTypeArticle(nom_type, commentaire, id_type_pneu) {
  $(".type").val(nom_type);
  $(".commentaire").val(commentaire);
  $(".id_client").val(id_type_pneu);
  $(".btnAddClient").fadeOut();
  $(".btnAnnulerModif").fadeIn();
  $(".btnModifClient").fadeIn();

}

function annulerTypeArticle() {
  $(".btnAddClient").fadeIn();
  $(".btnAnnulerModif").fadeOut();
  $(".btnModifClient").fadeOut();
}

function confirmSuppressionTypeArticle() {
  table = $(".table").val();
  identifiant = $(".identifiant").val();
  nom_id = $(".nom_id").val();
  // creerDatable("exemple1");
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/deleteTypeArticle",
    data: { "table": table, "identifiant": identifiant, "nom_id": nom_id },
    success: function (data) {

      toastr.success(data);
      $('#example1').DataTable().destroy();
      afficheAllTypeArticle('#example1');


    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })

    }
  });
}

// la partie suivante est dédiée à la gestion du fournissseur


function afficheAllFournisseurArticle(idTable) {
  $(".chargementClient").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/getAllFournisseurArticle",
    data: {},
    success: function (data) {

      $(".contentClient").empty();
      $(".contentClient").append(data);
      ceerDatatable(idTable)
      $(".chargementClient").fadeOut();
      // formAddRemorque();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur ' + data.responseText
      })
      $(".chargementClient").fadeOut();
    }
  });
}

function addFournisseurArticle(status) {
  // alert(status);
  commentaire = $(".commentaire").val();
  nom = $(".nom").val();
  adresse = $(".adresse").val();
  telephone = $(".telephone").val();
  montant_init = $(".montant_init").val();
  date_init = $(".date_init").val();
  id_client = $(".id_client").val();
  if (nom == "") {
    $(".nom").css("border", "red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  } else if (adresse == "") {
    $(".adresse").css("border", "red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  } else if (telephone == "") {
    $(".telephone").css("border", "red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  } else {
    $(".nom").css("border", "1px solid #ced4da");
    $(".adresse").css("border", "1px solid #ced4da");
    $(".telephone").css("border", "1px solid #ced4da");
    $(".montant_init").css("border", "1px solid #ced4da");
    $(".date_init").css("border", "1px solid #ced4da");
    $(".chargementCarteGrise1").fadeIn();
    $.ajax({
      type: "POST",
      url: base_url + "/admin_article/addFournisseurArticle",
      data: { "commentaire": commentaire, "status": status, "id_client": id_client, "nom": nom, "adresse": adresse, "telephone": telephone, "montant_init": montant_init, "date_init": date_init },
      success: function (data) {
        if ($.trim(data) == "Insertion parfaite du fournisseur") {
          $(".nom").val("");
          $(".adresse").val("");
          $(".telephone").val("");
          toastr.info(data);
          $('#example1').DataTable().destroy();
          afficheAllFournisseurArticle('#example1');
          $(".chargementCarteGrise1").fadeOut();
        } else if ($.trim(data) == "Modification parfaite du fournisseur") {
          $(".nom").val("");
          $(".adresse").val("");
          $(".telephone").val("");
          toastr.info(data);
          $('#example1').DataTable().destroy();
          afficheAllFournisseurArticle('#example1');
          $(".chargementCarteGrise1").fadeOut();
        } else {
          $(document).Toasts('create', {
            class: 'bg-danger',
            title: 'Erreur de connexion',
            subtitle: 'Alert',
            body: data
          })
          $(".chargementCarteGrise1").fadeOut();
        }

      },
      error: function (data) {
        $(document).Toasts('create', {
          class: 'bg-danger',
          title: 'Erreur de connexion',
          subtitle: 'Alert',
          body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
        })
        $(".chargementCarteGrise").fadeOut();
        $(".chargementCarteGrise1").fadeOut();
      }
    });
  }
}
function confirmSuppressionClient1() {
  table = $(".table").val();
  identifiant = $(".identifiant").val();
  nom_id = $(".nom_id").val();
  // creerDatable("exemple1");
  $.ajax({
    type: "POST",
    url: base_url + "/admin_document/deleteDocument",
    data: { "table": table, "identifiant": identifiant, "nom_id": nom_id },
    success: function (data) {

      toastr.success(data);
      $('#example1').DataTable().destroy();
      afficheAllFournisseurArticle('#example1');


    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })

    }
  });
}


function confirmSuppressionFournisseurArticle() {
  table = $(".table").val();
  identifiant = $(".identifiant").val();
  nom_id = $(".nom_id").val();
  // creerDatable("exemple1");
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/deleteFournisseurArticle",
    data: { "table": table, "identifiant": identifiant, "nom_id": nom_id },
    success: function (data) {

      toastr.success(data);
      $('#example1').DataTable().destroy();
      afficheAllFournisseurArticle('#example1');


    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })

    }
  });
}

function chiffres(event) {
  if (!event && window.event) {
    event = window.event;
  }
  var code = event.keyCode;
  var which = event.which;
  if ((code < 48 || code > 57) && code != 46 && code != 8 && code != 9 && code != 16 && code != 13) {
    event.returnValue = false;
    event.cancelBubble = true;
  }
  if ((which < 48 || which > 57) && (code < 37 || code > 40) && code != 46 && code != 8 && code != 9 && code != 16 && code != 13 || event.ctrlkey) {
    event.preventDefault();
    event.stopPropagation();
  }
}

function infosClient1(id_client, nom, adresse, telephone, commentaire, montant_init, date_init) {
  $(".commentaire").val(commentaire);
  $(".nom").val(nom);
  $(".adresse").val(adresse);
  $(".telephone").val(telephone);
  $(".montant_init").val(montant_init);
  $(".date_init").val(date_init);
  $(".id_client").val(id_client);
  $(".btnAnnulerModif").fadeIn();
  $(".btnModifClient").fadeIn();
  $(".btnAddClient").fadeOut();
}

function annulerModifClient1() {
  $(".btnAnnulerModif").fadeOut();
  $(".btnModifClient").fadeOut();
  $(".btnAddClient").fadeIn();
}

// nous passons donc à la facture
function infosFacture(id_facture, id_fournisseur, numero, date, montant, echeance, cloturer, remise) {
  $(".montant").val(montant);
  $(".id_fournisseur").val(id_fournisseur);
  // leSelectBLParFournisseur()
  $(".dateFacture").val(date);
  $(".numero").val(numero);
  $(".id_prime").val(id_facture);
  // $(".id_bl").val(id_bl);
  $(".echeance").val(echeance);
  $(".cloturer").val(cloturer);

  $(".remise").val(remise);

  $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAdd").fadeOut();
}

function infosReglement(id_facture, id_fournisseur, numero, date, montant, libelle, cheque, banque, ciment, unitaire, type) {
  $(".montant").val(montant);
  $(".id_fournisseur").val(id_fournisseur);
  // leSelectBLParFournisseur()
  $(".dateFacture").val(date);
  $(".numero").val(numero);
  $(".id_prime").val(id_facture);
  $(".libelle").val(libelle);
  $(".cheque").val(cheque);
  $(".banque").val(banque);

  $(".ciment").val(ciment);
  $(".pu").val(unitaire);
  $(".validite").val(type);

  //$(".remise").val(remise);

  $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAdd").fadeOut();
}

function addFactureArticle(status) {
  montant = $(".montant").val();
  // cloturer = $(".cloturer").val();
  date = $(".dateFacture").val();
  echeance = $(".echeance").val();
  numero = $(".numero").val();
  id_fournisseur = $(".id_fournisseur").val();
  // id_bl = $(".id_bl").val();
  id_facture = $(".id_prime").val();

  remise = $(".remise").val();

  //if ($(".cloturer").is(":checked")) {
  //cloturer = 1;
  //}else{
  //cloturer = 0;
  //}

  if (montant == "") {
    $(".montant").css("border", "red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  } else if (date == "") {
    $(".dateFacture").css("border", "red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  } else if (echeance == "") {
    $(".echeance").css("border", "red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  } else if (numero == "") {
    $(".numero").css("border", "red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  } else {
    //$(".id_bl").css("border","1px solid #ced4da");
    $(".montant").css("border", "1px solid #ced4da");
    $(".dateFacture").css("border", "1px solid #ced4da");
    $(".echeance").css("border", "1px solid #ced4da");
    $(".datePrime").css("border", "1px solid #ced4da");
    $(".chargementPrime1").fadeIn();
    $.ajax({
      type: "POST",
      url: base_url + "/admin_article/addFactureArticle",
      data: { "id_fournisseur": id_fournisseur, "remise": remise, "status": status, "montant": montant, "numero": numero, "date": date, "echeance": echeance },
      success: function (data) {

        if ($.trim(data) == "Insertion parfaite de la facture") {
          $('#example1').DataTable().destroy();
          afficheAllFactureArticle('#example1');
          $(document).Toasts('create', {
            class: 'bg-success',
            title: 'Alert',
            subtitle: 'Alert',
            body: data
          })
          $(".chargementPrime1").fadeOut();
        } else if ($.trim(data) == "Facture modifiée") {

          $('#example1').DataTable().destroy();
          afficheAllFactureArticle('#example1');
          $(document).Toasts('create', {
            class: 'bg-success',
            title: 'Alert',
            subtitle: 'Alert',
            body: data
          })
          $(".chargementPrime1").fadeOut();
        } else {
          $(document).Toasts('create', {
            class: 'bg-danger',
            title: 'Erreur de connexion',
            subtitle: 'Alert',
            body: data
          })
        }
        $(".chargementPrime1").fadeOut();
      },
      error: function (data) {
        $(".chargementGazoil1").fadeOut();
        $(document).Toasts('create', {
          class: 'bg-danger',
          title: 'Erreur de connexion',
          subtitle: 'Alert',
          body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
        })

      }
    });
  }
}

function afficheAllFactureArticle(idTable) {
  $(".chargementPrime").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/getAllFactureArticle",
    data: {},
    success: function (data) {

      $(".contentPrime").empty();
      $(".contentPrime").append(data);
      ceerDatatable(idTable)
      $(".chargementPrime").fadeOut();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })
      $(".chargementPrime").fadeOut();
    }
  });
}

function confirmSuppressionFactureArticle() {
  table = $(".table").val();
  identifiant = $(".identifiant").val();
  nom_id = $(".nom_id").val();
  // creerDatable("exemple1");
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/deleteFactureFournisseurArticle",
    data: { "table": table, "identifiant": identifiant, "nom_id": nom_id },
    success: function (data) {

      toastr.success(data);
      $('#example1').DataTable().destroy();
      afficheAllFactureArticle('#example1');


    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })

    }
  });
}


// Reglement


function addReglementArticle(status) {
  montant = $(".montant").val();
  date = $(".dateFacture").val();
  numero = $(".numero").val();
  cheque = $(".cheque").val();
  id_fournisseur = $(".id_fournisseur").val();
  libelle = $(".libelle").val();
  banque = $(".banque").val();
  ciment = $(".ciment").val();
  unitaire = $(".pu").val();
  validite = $(".validite").val();
  id_regl = $(".id_prime").val();


  if (montant == "") {
    $(".montant").css("border", "red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  } else if (date == "") {
    $(".dateFacture").css("border", "red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  } else if (numero == "") {
    $(".numero").css("border", "red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  } else if (libelle == "") {
    $(".libelle").css("border", "red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  } else if (id_fournisseur == "") {
    $(".id_fournisseur").css("border", "red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }
  else {
    $(".libelle").css("border", "1px solid #ced4da");
    $(".montant").css("border", "1px solid #ced4da");
    $(".id_fournisseur").css("border", "1px solid #ced4da");
    $(".dateFacture").css("border", "1px solid #ced4da");
    $(".numero").css("border", "1px solid #ced4da");
    $(".cheque").css("border", "1px solid #ced4da");
    $(".banque").css("border", "1px solid #ced4da");
    $(".chargementPrime1").fadeIn();
    $.ajax({
      type: "POST",
      url: base_url + "/admin_article/addReglement",
      data: { "id_fournisseur": id_fournisseur, "id_facture": id_regl, "status": status, "montant": montant, "numero": numero, "date": date, "libelle": libelle, "cheque": cheque, "banque": banque, "ciment": ciment, "unitaire": unitaire, "validite": validite },
      success: function (data) {

        if ($.trim(data) == "Règlement de la facture effectué") {

          $('#example1').DataTable().destroy();
          selectAllReglementParFournisseur('#example1');
          $(document).Toasts('create', {
            class: 'bg-success',
            title: 'Alert',
            subtitle: 'Alert',
            body: data
          })
          $(".chargementPrime1").fadeOut();
        } else if ($.trim(data) == "Règlement modifié") {

          $('#example1').DataTable().destroy();
          selectAllReglementParFournisseur('#example1');
          $(document).Toasts('create', {
            class: 'bg-success',
            title: 'Alert',
            subtitle: 'Alert',
            body: data
          })
          $(".chargementPrime1").fadeOut();
        } else {
          $(document).Toasts('create', {
            class: 'bg-danger',
            title: 'Erreur de connexion',
            subtitle: 'Alert',
            body: data
          })
        }
        $(".chargementPrime1").fadeOut();
      },
      error: function (data) {
        $(".chargementGazoil1").fadeOut();
        $(document).Toasts('create', {
          class: 'bg-danger',
          title: 'Erreur de connexion',
          subtitle: 'Alert',
          body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
        })

      }
    });
  }
}

function afficheAllReglementArticle(idTable) {
  $(".chargementPrime").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/getAllReglement",
    data: {},
    success: function (data) {

      $(".contentPrime").empty();
      $(".contentPrime").append(data);
      ceerDatatable(idTable)
      $(".chargementPrime").fadeOut();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })
      $(".chargementPrime").fadeOut();
    }
  });
}

function confirmSuppressionReglementArticle() {
  table = $(".table").val();
  identifiant = $(".identifiant").val();
  nom_id = $(".nom_id").val();
  // creerDatable("exemple1");
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/deleteReglementFournisseurArticle",
    data: { "table": table, "identifiant": identifiant, "nom_id": nom_id },
    success: function (data) {

      toastr.success(data);
      $('#example1').DataTable().destroy();
      selectAllReglementParFournisseur('#example1');


    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })

    }
  });
}

// le code qui suit est celui de la balance


function afficheAllReglementPourBalanceArticle(idTable, id_fournisseur, date_debut, date_fin) {
  $(".chargementPrime").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/getAllReglementPourBalanceArticle",
    data: { "id_fournisseur": id_fournisseur, "date_debut": date_debut, "date_fin": date_fin },
    success: function (data) {

      $(".contentPrime2").empty();
      $(".contentPrime2").append(data);
      ceerDatatable(idTable)
      $(".chargementPrime").fadeOut();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })
      $(".chargementPrime").fadeOut();
    }
  });
}
function afficheAllFActurePourBalanceArticle(idTable, id_fournisseur, date_debut, date_fin) {
  $(".chargementPrime").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/getAllFacturePourBalanceArticle",
    data: { "id_fournisseur": id_fournisseur, "date_debut": date_debut, "date_fin": date_fin },
    success: function (data) {

      $(".contentPrime1").empty();
      $(".contentPrime1").append(data);
      ceerDatatable(idTable)
      $(".chargementPrime").fadeOut();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })
      $(".chargementPrime").fadeOut();
    }
  });

  // totalReglement = $(".totalReglement").val();
  // totalFacture = $(".totalFacture").val();
  // total = parseInt(totalFacture)+parseInt(totalReglement);
  // $(".solde").val(total);

}

function selectAllTotalFacturePourBalanceFournisseur(id_fournisseur, date_debut, date_fin) {
  $(".chargementPrime").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/selectAllTotalFacturePourBalanceFournisseur",
    data: { "id_operation": id_fournisseur, "id_fournisseur": id_fournisseur, "date_debut": date_debut, "date_fin": date_fin },
    success: function (data) {
      // alert(data);
      $(".totalFacture").val("");
      formatMillierPourSelection(data, 'totalFacture');
      $(".chargementPrime").fadeOut();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })
      $(".chargementPrime").fadeOut();
    }
  });
}

function selectAllTotalReglementPourBalanceFournisseur(id_fournisseur, date_debut, date_fin) {
  $(".chargementPrime").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/selectAllTotalReglementPourBalanceFournisseur",
    data: { "id_operation": id_fournisseur, "id_fournisseur": id_fournisseur, "date_debut": date_debut, "date_fin": date_fin },
    success: function (data) {
      // alert(data);
      $(".totalReglement").val("");
      formatMillierPourSelection(data, 'totalReglement');
      $(".chargementPrime").fadeOut();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })
      $(".chargementPrime").fadeOut();
    }
  });
}
function soldeCaisseFournisseur(id_fournisseur, date_debut, date_fin) {
  $(".chargementPrime").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/soldeArticleFournisseur",
    data: { "id_operation": id_fournisseur, "id_fournisseur": id_fournisseur, "date_debut": date_debut, "date_fin": date_fin },
    success: function (data) {
      // alert(data);
      $(".solde").val("");
      formatMillierPourSelection(data, 'solde');
      $(".chargementPrime").fadeOut();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })
      $(".chargementPrime").fadeOut();
    }
  });
}

function getBalanceArticle() {
  id_fournisseur = $(".id_fournisseur").val();
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  if (id_fournisseur == "" && date_debut == "" && date_fin == "") {

  } else {
    soldeCaisseFournisseur(id_fournisseur, date_debut, date_fin);
    selectAllTotalFacturePourBalanceFournisseur(id_fournisseur, date_debut, date_fin);
    selectAllTotalReglementPourBalanceFournisseur(id_fournisseur, date_debut, date_fin);
    $('#example2').DataTable().destroy();
    afficheAllFActurePourBalanceArticle('#example2', id_fournisseur, date_debut, date_fin);

    $('#example1').DataTable().destroy();
    afficheAllReglementPourBalanceArticle('#example1', id_fournisseur, date_debut, date_fin);
  }
}
function formatMillierPourSelection(data, classe) {
  nombre = data;
  nombre = nombre.replace(/ /g, '');
  nombre += '';

  var sep = ' ';
  var reg = /(\d+)(\d{3})/;

  while (reg.test(nombre)) {
    nombre = nombre.replace(reg, '$1' + sep + '$2');
  }
  $("." + classe).val("");
  $("." + classe).val(nombre + " FCFA");
}

function formatMillierPourSelection1(data, classe) {
  nombre = data;
  nombre = nombre.replace(/ /g, '');
  nombre += '';

  var sep = ' ';
  var reg = /(\d+)(\d{3})/;

  while (reg.test(nombre)) {
    nombre = nombre.replace(reg, '$1' + sep + '$2');
  }
  $("." + classe).val("");
  $("." + classe).val(nombre);
}
function formatMillier(classe) {
  nombre = $("." + classe).val();
  nombre = nombre.replace(/ /g, '');
  nombre += '';

  var sep = ' ';
  var reg = /(\d+)(\d{3})/;

  while (reg.test(nombre)) {
    nombre = nombre.replace(reg, '$1' + sep + '$2');
  }
  $("." + classe).val("");
  $("." + classe).val(nombre);
  // alert(nombre)
}

function afficheAllClotureArticle(idTable) {
  $(".chargementLivraison").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/getAllClotureArticle",
    data: {},
    success: function (data) {

      $(".contentLivraison").empty();
      $(".contentLivraison").append(data);
      ceerDatatable(idTable)
      $(".chargementLivraison").fadeOut();
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })
      $(".chargementLivraison").fadeOut();
    }
  });
}
function addClotureArticle(status) {
  date_cloture = $(".date_article").val();
  facture = $(".facture").val();
  reglement = $(".reglement").val();
  solde = $(".solde").val();
  ordonateur = $(".ordonateur").val();
  id_fournisseur = $(".id_fournisseur").val();
  // cloturer = $(".cloturer").val();
  ancienne_date = $(".ancienne_date").val()
  id_BL = $(".id_BL").val();

  if ($(".cloturer").is(":checked")) {
    cloturer = 1;
  } else {
    cloturer = 0;
  }
  if (date_cloture == "") {
    $(".date_cloture").css("border", "red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  } else if (facture == "") {
    $(".facture").css("border", "red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  } else if (reglement == "") {
    $(".reglement").css("border", "red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  } else if (id_fournisseur == "") {
    $(".id_fournisseur").css("border", "red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  } else if (solde == "") {
    $(".solde").css("border", "red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  } else if (ordonateur == "") {
    toastr.error("Veuillez remplir tous les Champs");
    $(".ordonateur").css("border", "red 2px solid");
  } else {
    $(".date_cloture").css("border", "1px solid #ced4da");
    $(".facture").css("border", "1px solid #ced4da");
    $(".reglement").css("bo rder", "1px solid #ced4da");
    $(".id_fournisseur").css("bo rder", "1px solid #ced4da");
    $(".solde").css("border", "1px solid #ced4da");
    $(".ordonateur").css("border", "1px solid #ced4da");
    // alert(date_cloture);
    $(".chargementLivraison1").fadeIn();
    $.ajax({
      type: "POST",
      url: base_url + "/admin_article/addClotureArticle",
      data: { "id_fournisseur": id_fournisseur, "ancienne_date": ancienne_date, "cloturer": cloturer, "date_cloture": date_cloture, "status": status, "id_cloture": id_BL, "facture": facture, "reglement": reglement, "solde": solde, "ordonateur": ordonateur },
      success: function (data) {
        if ($.trim(data) == "Cloture effectuée") {
          $(document).Toasts('create', {
            class: 'bg-success',
            title: 'Alert',
            subtitle: 'Alert',
            body: data
          })
          $(".chargementLivraison1").fadeOut();
          $('#example1').DataTable().destroy();
          afficheAllClotureArticle('#example1');
        } else if ($.trim(data) == "Modification parfaite de la cloture") {

          $(document).Toasts('create', {
            class: 'bg-success',
            title: 'Alert',
            subtitle: 'Alert',
            body: data
          })
          $(".chargementLivraison1").fadeOut();
          $('#example1').DataTable().destroy();
          afficheAllClotureArticle('#example1');
        } else {
          $(".chargementLivraison1").fadeOut();
          $(document).Toasts('create', {
            class: 'bg-danger',
            title: 'Erreur de connexion',
            subtitle: 'Alert',
            body: data
          })

        }

      },
      error: function (data) {
        $(".chargementLivraison1").fadeOut();
        $(document).Toasts('create', {
          class: 'bg-danger',
          title: 'Erreur de connexion',
          subtitle: 'Alert',
          body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
        })

      }
    });
  }
}

function getTotalFacture(date_debut, date_fin, id_fournisseur) {
  $(".chargementPrime").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/getTotalFacture",
    data: { "id_fournisseur": id_fournisseur, "date_article": date_debut, "date_fin": date_fin },
    success: function (data) {
      $(".facture").val("");
      $(".facture").val(data);
      // alert(data);
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })
      $(".chargementPrime").fadeOut();
    }
  });
}
function getSoldeArticle(date_debut, date_fin, id_fournisseur) {
  $(".chargementPrime").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/getSoldeArticle",
    data: { "id_fournisseur": id_fournisseur, "date_article": date_debut, "date_fin": date_fin },
    success: function (data) {
      $(".solde").val("");
      // alert(date_debut);
      $(".solde").val(data);
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })
      $(".chargementPrime").fadeOut();
    }
  });
}
function getTotalReglement(date_debut, date_fin, id_fournisseur) {
  $(".chargementPrime").fadeIn();
  $.ajax({
    type: "POST",
    url: base_url + "/admin_article/getTotalReglement",
    data: { "id_fournisseur": id_fournisseur, "date_article": date_debut, "date_fin": date_fin },
    success: function (data) {

      $(".reglement").val("");
      $(".reglement").val(data);
    },
    error: function (data) {
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur' + data.responseText
      })
      $(".chargementPrime").fadeOut();
    }
  });
}
function totauxPourCloture() {
  id_fournisseur = $(".id_fournisseur").val();
  date_cloture = $(".date_article").val();
  date = "";
  // alert(date_cloture);
  getTotalReglement(date_cloture, date, id_fournisseur);
  getTotalFacture(date_cloture, date, id_fournisseur);
  getSoldeArticle(date_cloture, date, id_fournisseur);
}



function rapportFacture() {



  date_debut = $(".date_debut").val();

  date_fin = $(".date_fin").val();

  id_fournisseur = $(".id_fournisseur").val();

  cloture = $(".cloturer").val();

  if ($(".cloturer").is(":checked")) {
    cloture = 1;
  } else {
    cloture = 0;
  }

  if (date_debut == "" && date_fin == "") {



  } else if (date_fin == "") {

  } else {

    $(".chargementClient").fadeIn();

    $.ajax({

      type: "POST",

      url: base_url + "/admin_article/rapportFacture",

      data: { "date_debut": date_debut, "date_fin": date_fin, "id_fournisseur": id_fournisseur, "cloturer": cloture },

      success: function (data) {

        $('#example1').DataTable().destroy();

        $(".contentClient").empty();

        $(".contentClient").append(data);

        ceerDatatableFacture('#example1');

        $(".chargementClient").fadeOut();

        // formAddRemorque();

        // alert(data);

      },

      error: function (data) {

        $(document).Toasts('create', {

          class: 'bg-danger',

          title: 'Erreur de connexion',

          subtitle: 'Alert',

          body: 'Erreur vérifier votre connexion ou contactez l\'administrateur ' + data.responseText

        })

        $(".chargementClient").fadeOut();

      }

    });

  }

}

function getfournisseur() {


  validite = $(".validite").val();

  cheque = $(".cheque");

  banque = $(".banque");

  ciment = $(".ciment");

  pu = $(".pu");


  if (validite == "Cheque") {

    banque.removeAttr("disabled", "false");

    cheque.removeAttr("disabled", "false");

    ciment.val(0);
    ciment.attr("disabled", "true");

    pu.val(0);
    pu.attr("disabled", "true");



    // num_bordereau.removeAttr("disabled","false");
  } else if (validite == "Ciment") {

    ciment.removeAttr("disabled", "false");
    ciment.val(0);

    pu.removeAttr("disabled", "false");
    pu.val(0);

    banque.val("");

    banque.attr("disabled", "true");

    cheque.val("");

    cheque.attr("disabled", "true");

  } else if (validite == "Espece") {

    ciment.val(0);
    ciment.attr("disabled", "true");
    pu.val(0);
    pu.attr("disabled", "true");
    banque.val("");
    banque.attr("disabled", "true");
    cheque.val("");
    cheque.attr("disabled", "true");

  } else {

    banque.attr("disabled", "true");

    cheque.attr("disabled", "true");

    ciment.attr("disabled", "true");

    pu.attr("disabled", "true");

  }



}


function getMontantTotal() {
  pu = $(".pu").val();
  ciment = $(".ciment").val();
  // var quantite = quantite.replace(".",",");
  if (ciment == 0 || ciment == "") {
    $(".montant").val(0);
  } else if (pu == 0 || pu == "") {
    $(".montant").val(0);
  } else {
    // $(".PT").val(parseInt(pu)*parseInt(quantite)+" FCFA");
    pu = pu.replace(/\s+/g, '');
    ciment = ciment.replace(/\s+/g, '');
    // alert(pu);
    total = parseFloat(pu) * parseFloat(ciment);

    formatMillierPourSelection1('' + total.toFixed(2) + '', 'montant');
  }
}