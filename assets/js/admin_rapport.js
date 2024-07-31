function ceerDatatable(id){

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

            title:"",

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


function ceerDatatableRapportAccident(entete,id){

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

            title:"",

            message: ' <table class="table table-bordered table-striped" cellpadding="0" cellspacing="0"><thead><tr ><th style="border: 5px solid #0e2d86; border-right: none; border-left: none; text-align:center;"><img src="'+base_url+'/assets/image/mira.jpg" style="height:100px;"><span style="color: blue; font-weight: bold; font-size: 55px; text-align: center; ">SOCIETE MIRA S.A</span> <br><table cellpadding="0" cellspacing="0" style="text-align:center; margin-left:200px;"><tr><td colspan="12">Négoce - Import - Export - Matériaux de construction - Représentation - Activités industrielles - Activités maritimes - BTP - Transport</td> </tr><tr><td colspan="13" style="color: blue; font-weight: bold; font-size: 25px; text-align: center;">RECAPITULATIF DES ACCIDENTS</td> </tr> </table></th><th style="border: 5px solid #0e2d86; border-left: none; border-right: none;"></th></tr><tr><td colspan="12"  style="border: none;"></td> </tr></th></tr></thead></table><table><tr>'+entete+'</tr></table> <span style="text-align:center; margin-left:200px;"></span>'

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

function ceerDatatableCumule(id){

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

            title:"",

            message: ' <table class="table table-bordered table-striped" cellpadding="0" cellspacing="0"><thead><tr ><th style="border: 5px solid #0e2d86; border-right: none; border-left: none; text-align:center;"><img src="'+base_url+'/assets/image/mira.jpg" style="height:100px;"><span style="color: blue; font-weight: bold; font-size: 55px; text-align: center; ">SOCIETE MIRA S.A</span> <br><table cellpadding="0" cellspacing="0" style="text-align:center; margin-left:200px;"><tr><td colspan="12">Négoce - Import - Export - Matériaux de construction - Représentation - Activités industrielles - Activités maritimes - BTP - Transport</td> </tr><tr><td colspan="13" style="color: blue; font-weight: bold; font-size: 25px; text-align: center;">RECAPITULATIF MENSUEL DES PLATEAUX</td> </tr> </table></th><th style="border: 5px solid #0e2d86; border-left: none; border-right: none;"></th></tr><tr><td colspan="12"  style="border: none;"></td> </tr></th></tr></thead></table>'

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

function ceerDatatableAppro(id){

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

            title:"",

            message: ' <table class="table table-bordered table-striped" cellpadding="0" cellspacing="0"><thead><tr ><th style="border: 5px solid #0e2d86; border-right: none; border-left: none; text-align:center;"><img src="'+base_url+'/assets/image/mira.jpg" style="height:100px;"><span style="color: blue; font-weight: bold; font-size: 55px; text-align: center; ">SOCIETE MIRA S.A</span> <br><table cellpadding="0" cellspacing="0" style="text-align:center; margin-left:200px;"><tr><td colspan="12">Négoce - Import - Export - Matériaux de construction - Représentation - Activités industrielles - Activités maritimes - BTP - Transport</td> </tr><tr><td colspan="13" style="color: blue; font-weight: bold; font-size: 25px; text-align: center;">RECAPITULATIF MENSUEL DES APPROVISIONNEMENTS</td> </tr> </table></th><th style="border: 5px solid #0e2d86; border-left: none; border-right: none;"></th></tr><tr><td colspan="12"  style="border: none;"></td> </tr></th></tr></thead></table> <span style="text-align:center; margin-left:200px;"></span>'

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




function ceerDatatableService(id){

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

            title:"",

            message: ' <table class="table table-bordered table-striped" cellpadding="0" cellspacing="0"><thead><tr ><th style="border: 5px solid #0e2d86; border-right: none; border-left: none; text-align:center;"><img src="'+base_url+'/assets/image/mira.jpg" style="height:100px;"><span style="color: blue; font-weight: bold; font-size: 55px; text-align: center; ">SOCIETE MIRA S.A</span> <br><table cellpadding="0" cellspacing="0" style="text-align:center; margin-left:200px;"><tr><td colspan="12">Négoce - Import - Export - Matériaux de construction - Représentation - Activités industrielles - Activités maritimes - BTP - Transport</td> </tr><tr><td colspan="13" style="color: blue; font-weight: bold; font-size: 25px; text-align: center;">RECAPITULATIF MENSUEL DES VOITURES DE SERVICE</td> </tr> </table></th><th style="border: 5px solid #0e2d86; border-left: none; border-right: none;"></th></tr><tr><td colspan="12"  style="border: none;"></td> </tr></th></tr></thead></table> <span style="text-align:center; margin-left:200px;"></span>'

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

function ceerDatatableEngin(id){

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

            title:"",

            message: ' <table class="table table-bordered table-striped" cellpadding="0" cellspacing="0"><thead><tr ><th style="border: 5px solid #0e2d86; border-right: none; border-left: none; text-align:center;"><img src="'+base_url+'/assets/image/mira.jpg" style="height:100px;"><span style="color: blue; font-weight: bold; font-size: 55px; text-align: center; ">SOCIETE MIRA S.A</span> <br><table cellpadding="0" cellspacing="0" style="text-align:center; margin-left:200px;"><tr><td colspan="12">Négoce - Import - Export - Matériaux de construction - Représentation - Activités industrielles - Activités maritimes - BTP - Transport</td> </tr><tr><td colspan="13" style="color: blue; font-weight: bold; font-size: 25px; text-align: center;">RECAPITULATIF MENSUEL DES ENGINS</td> </tr> </table></th><th style="border: 5px solid #0e2d86; border-left: none; border-right: none;"></th></tr><tr><td colspan="12"  style="border: none;"></td> </tr></th></tr></thead></table><span style="text-align:center; margin-left:200px;"></span>'

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



function ceerDatatableBenne(id){

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

            title:"",

            message: ' <table class="table table-bordered table-striped" cellpadding="0" cellspacing="0"><thead><tr ><th style="border: 5px solid #0e2d86; border-right: none; border-left: none; text-align:center;"><img src="'+base_url+'/assets/image/mira.jpg" style="height:100px;"><span style="color: blue; font-weight: bold; font-size: 55px; text-align: center; ">SOCIETE MIRA S.A</span> <br><table cellpadding="0" cellspacing="0" style="text-align:center; margin-left:200px;"><tr><td colspan="12">Négoce - Import - Export - Matériaux de construction - Représentation - Activités industrielles - Activités maritimes - BTP - Transport</td> </tr><tr><td colspan="13" style="color: blue; font-weight: bold; font-size: 25px; text-align: center;">RECAPITULATIF MENSUEL DES BENNES</td> </tr> </table></th><th style="border: 5px solid #0e2d86; border-left: none; border-right: none;"></th></tr><tr><td colspan="12"  style="border: none;"></td> </tr></th></tr></thead></table><span style="text-align:center; margin-left:200px;"></span>'

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



function afficheAllReglementPourRapport(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/getAllReglementPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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

function afficheAllFActureReglementPourBalanceRapport(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllFactureOperationPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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



function afficheAllFActurePrimePourBalanceRapport(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllPrimeOperationPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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



function selectAllFraisRouteOperationPourRapport(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllFraisRouteOperationPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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





function selectAllFraisDiversOperationPourRapport(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllFraisDiversOperationPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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

function selectAllPieceRechangeOperationPourRapport(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllPieceRechangeOperationPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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


function selectAllAccidentOperationPourRapport(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllAccidentOperationPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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


function selectAllDepensePneuOperationPourRapport(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllDepensePneuOperationPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

      success: function(data){

        // alert(data);

        $(".contentPrime11").empty();

        $(".contentPrime11").append(data);

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



function selectAllVidangeOperationPourRapport(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllVidangeOperationPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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

function selectAllGazoilOperationPourRapport(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllGazoilOperationPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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

function selectAllChargementOperationPourRapport(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllChargementOperationPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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

function selectAllTotalFactureOperationPourRapport(id_fournisseur,date_debut,date_fin){

   $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllTotalFactureOperationPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

      success: function(data){

        // $(".totalFacture").val("");

        formatMillierPourSelection(data,'totalFacture1');

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

      url:base_url+"/admin_rapport/selectTotalRecette",

      data:{"id_type_vehicule":id_fournisseur,"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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

function selectAllTotalPrimeOperationPourRapport(id_fournisseur,date_debut,date_fin){

   $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllTotalPrimeOperationPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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



function selectAllTotalFraisRouteOperationPourRapport(id_fournisseur,date_debut,date_fin){

   $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllTotalFraisRouteOperationPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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



function selectAllTotalFraisDiversOperationPourRapport(id_fournisseur,date_debut,date_fin){

   $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllTotalFraisDiversOperationPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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





function selectAllTotalPieceRechangeOperationPourRapport(id_fournisseur,date_debut,date_fin){

   $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllTotalPieceRechangeOperationPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

      success: function(data){

        $(".totalPieceRechange").val("");

        formatMillierPourSelection(data,"totalPieceRechange");

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


function selectAllTotalAccidentOperationPourRapport(id_fournisseur,date_debut,date_fin){

   $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllTotalAccidentOperationPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

      success: function(data){

        $(".totalaccident").val("");

        formatMillierPourSelection(data,"totalaccident");

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

function selectAllTotalVidangeOperationPourRapport(id_fournisseur,date_debut,date_fin){

   $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllTotalVidangeOperationPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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

function selectAllTotalGazoilOperationPourRapport(id_fournisseur,date_debut,date_fin){

   $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllTotalGazoilOperationPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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



function selectAllTotalChargementOperationPourRapport(id_fournisseur,date_debut,date_fin){

   $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllTotalChargementOperationPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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

      url:base_url+"/admin_rapport/totalDepenseParRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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

      url:base_url+"/admin_rapport/getSolde",

      data:{"id_type_vehicule":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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



function selectAllLocationEnginOperationPourRapport(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllLocationEnginOperationPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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

function selectAllTotalLocationEnginOperationPourRapport(id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllTotalLocationEnginOperationPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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

// ceci c'est pour le rapport mensuel dees vraquiers


function selectAllLocationVraquierOperationPourRapport(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllLocationVraquierOperationPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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

function selectAllTotalLocationVraquierOperationPourRapport(id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllTotalLocationVraquierOperationPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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

function selectAllTotalFraisDiversOperationPourRapport(id_fournisseur,date_debut,date_fin){

   $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllTotalFraisDiversOperationPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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



function selectAllTotalDepensePneuOperationPourRapport(id_fournisseur,date_debut,date_fin){

   $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllTotalDepensePneuOperationPourRapport",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

      success: function(data){

        $(".totalPneu").val("");

        formatMillierPourSelection(data,'totalPneu');

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





// vente des pieces



function selectAllVentePiecesOperationPourBalance(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllVentePiecesOperationPourBalance",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

      success: function(data){

        // alert("fdf");

        $(".contentPrime13").empty();

        $(".contentPrime13").append(data);

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

      url:base_url+"/admin_rapport/selectAllTotalVentePiecesOperationPourBalance",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

      success: function(data){

        // alert(data);

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



function getBalancePourOperation(){

  id_fournisseur = $(".id_fournisseur").val();

  date_debut = $(".date_debut").val();

  date_fin = $(".date_fin").val();

if (date_debut == "" && date_fin == "") {



}else if(date_fin == ""){

}else if(id_fournisseur == "" || id_fournisseur==0 || id_fournisseur == "0"){

}else{

    $('#example1').DataTable().destroy();

  afficheAllFActureReglementPourBalanceRapport('#example1',id_fournisseur,date_debut,date_fin);



  $('#example2').DataTable().destroy();

  afficheAllFActurePrimePourBalanceRapport('#example2',id_fournisseur,date_debut,date_fin);



  $('#example3').DataTable().destroy();

  selectAllFraisRouteOperationPourRapport('#example3',id_fournisseur,date_debut,date_fin);



  $('#example5').DataTable().destroy();

  selectAllFraisDiversOperationPourRapport('#example5',id_fournisseur,date_debut,date_fin);

  

  $('#example4').DataTable().destroy();

  selectAllPieceRechangeOperationPourRapport('#example4',id_fournisseur,date_debut,date_fin);



  $('#example6').DataTable().destroy();

  selectAllVidangeOperationPourRapport('#example6',id_fournisseur,date_debut,date_fin);



  $('#example7').DataTable().destroy();

  selectAllGazoilOperationPourRapport('#example7',id_fournisseur,date_debut,date_fin);



  $('#example8').DataTable().destroy();

  selectAllChargementOperationPourRapport('#example8',id_fournisseur,date_debut,date_fin);




  $('#example9').DataTable().destroy();

  selectAllLocationEnginOperationPourRapport('#example9',id_fournisseur,date_debut,date_fin);
  
  
  $('#example10').DataTable().destroy();

  selectAllAccidentOperationPourRapport('#example10',id_fournisseur,date_debut,date_fin);



  $('#example11').DataTable().destroy();

  selectAllDepensePneuOperationPourRapport('#example11',id_fournisseur,date_debut,date_fin);



  $('#example13').DataTable().destroy();

  selectAllVentePiecesOperationPourBalance('#example13',id_fournisseur,date_debut,date_fin)



  selectAllTotalVentePiecesOperationPourBalance(id_fournisseur,date_debut,date_fin);



  selectAllTotalFactureOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalLocationEnginOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalPrimeOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalFraisRouteOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalFraisDiversOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalPieceRechangeOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalAccidentOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalVidangeOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalGazoilOperationPourRapport(id_fournisseur,date_debut,date_fin);

  

  selectAllTotalDepensePneuOperationPourRapport(id_fournisseur,date_debut,date_fin);





  totalDepense(id_fournisseur,date_debut,date_fin);



  getSolde(id_fournisseur,date_debut,date_fin);



  selectAllTotalChargementOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectTotalRecette(id_fournisseur,date_debut,date_fin);

}

}



// rapport client

function afficheAllFActureReglementPourBalanceRapportClient(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllFactureOperationPourRapportClient",

      data:{"id_client":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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



function afficheAllFActurePrimePourBalanceRapportClient(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllPrimeOperationPourRapportClient",

      data:{"id_client":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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





function selectAllFraisRouteOperationPourRapportClient(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllFraisRouteOperationPourRapportClient",

      data:{"id_client":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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





function selectAllFraisDiversOperationPourRapportClient(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllFraisDiversOperationPourRapportClient",

      data:{"id_client":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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





function selectAllPieceRechangeOperationPourRapportClient(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllPieceRechangeOperationPourRapportClient",

      data:{"id_client":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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







function selectAllVidangeOperationPourRapportClient(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllVidangeOperationPourRapportClient",

      data:{"id_client":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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



function selectAllGazoilOperationPourRapportClient(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllGazoilOperationPourRapportClient",

      data:{"id_client":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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



function selectAllChargementOperationPourRapportClient(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllChargementOperationPourRapportClient",

      data:{"id_client":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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





function selectAllLocationEnginOperationPourRapportClient(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllLocationEnginOperationPourRapportClient",

      data:{"id_client":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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







// function selectAllDepensePneuOperationPourRapportClient(idTable,id_fournisseur,date_debut,date_fin){

//   $(".chargementPrime").fadeIn();

//   $.ajax({

//       type:"POST",

//       url:base_url+"/admin_rapport/selectAllDepensePneuOperationPourRapportClient",

//       data:{"id_client":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

//       success: function(data){

//         alert(data);

//         $(".contentPrime11").empty();

//         $(".contentPrime11").append(data);

//         ceerDatatable(idTable)

//         $(".chargementPrime").fadeOut();

//       },

//        error:function(data){

//           $(document).Toasts('create', {

//         class: 'bg-danger', 

//         title: 'Erreur de connexion',

//         subtitle: 'Alert',

//         body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText

//       })   

//           $(".chargementPrime").fadeOut();

//        }

//        });





// }









function selectAllVentePiecesOperationPourBalanceClient(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllVentePiecesOperationPourBalanceClient",

      data:{"id_client":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

      success: function(data){

        // alert(data);

        $(".contentPrime13").empty();

        $(".contentPrime13").append(data);

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



function selectAllTotalVentePiecesOperationPourBalanceClient(id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllTotalVentePiecesOperationPourBalanceClient",

      data:{"id_client":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

      success: function(data){

        // alert(data);

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







function selectAllTotalFactureOperationPourRapportClient(id_fournisseur,date_debut,date_fin){

   $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllTotalFactureOperationPourRapportClient",

      data:{"id_client":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

      success: function(data){

        // $(".totalFacture").val("");

        formatMillierPourSelection(data,'totalFacture1');

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



function selectAllTotalLocationEnginOperationPourRapportClient(id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllTotalLocationEnginOperationPourRapportClient",

      data:{"id_client":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

      success: function(data){

        // alert(data);

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





function selectAllTotalPrimeOperationPourRapportClient(id_fournisseur,date_debut,date_fin){

   $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllTotalPrimeOperationPourRapportClient",

      data:{"id_client":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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



function selectAllTotalFraisRouteOperationPourRapportClient(id_fournisseur,date_debut,date_fin){

   $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllTotalFraisRouteOperationPourRapportClient",

      data:{"id_client":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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





function selectAllTotalFraisDiversOperationPourRapportClient(id_fournisseur,date_debut,date_fin){

   $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllTotalFraisDiversOperationPourRapportClient",

      data:{"id_client":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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



function selectAllTotalPieceRechangeOperationPourRapportClient(id_fournisseur,date_debut,date_fin){

   $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllTotalPieceRechangeOperationPourRapportClient",

      data:{"id_client":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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



function selectAllTotalVidangeOperationPourRapportClient(id_fournisseur,date_debut,date_fin){

   $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllTotalVidangeOperationPourRapportClient",

      data:{"id_client":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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



function selectAllTotalGazoilOperationPourRapportClient(id_fournisseur,date_debut,date_fin){

   $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllTotalGazoilOperationPourRapportClient",

      data:{"id_client":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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







function totalDepenseClient(id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/totalDepenseParRapportClient",

      data:{"id_client":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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





function getSoldeRapportCLient(id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/getSoldeRapportCLient",

      data:{"id_client":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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







function selectAllTotalChargementOperationPourRapportClient(id_fournisseur,date_debut,date_fin){

   $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectAllTotalChargementOperationPourRapportClient",

      data:{"id_client":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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







function selectTotalRecetteClient(id_fournisseur,date_debut,date_fin){

   $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectTotalRecetteClient",

      data:{"id_client":id_fournisseur,"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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

function getRapportClient(){

  id_fournisseur = $(".id_fournisseur").val();

  date_debut = $(".date_debut").val();

  date_fin = $(".date_fin").val();

if (date_debut == "" && date_fin == "") {



}else if(date_fin == ""){

}else if(id_fournisseur == "" || id_fournisseur==0 || id_fournisseur == "0"){

}else{

    $('#example1').DataTable().destroy();

  afficheAllFActureReglementPourBalanceRapportClient('#example1',id_fournisseur,date_debut,date_fin);



  $('#example2').DataTable().destroy();

  afficheAllFActurePrimePourBalanceRapportClient('#example2',id_fournisseur,date_debut,date_fin);



  $('#example3').DataTable().destroy();

  selectAllFraisRouteOperationPourRapportClient('#example3',id_fournisseur,date_debut,date_fin);



  $('#example5').DataTable().destroy();

  selectAllFraisDiversOperationPourRapportClient('#example5',id_fournisseur,date_debut,date_fin);

  

  $('#example4').DataTable().destroy();

  selectAllPieceRechangeOperationPourRapportClient('#example4',id_fournisseur,date_debut,date_fin);



  $('#example6').DataTable().destroy();

  selectAllVidangeOperationPourRapportClient('#example6',id_fournisseur,date_debut,date_fin);



  $('#example7').DataTable().destroy();

  selectAllGazoilOperationPourRapportClient('#example7',id_fournisseur,date_debut,date_fin);



  $('#example8').DataTable().destroy();

  selectAllChargementOperationPourRapportClient('#example8',id_fournisseur,date_debut,date_fin);



  $('#example9').DataTable().destroy();

  selectAllLocationEnginOperationPourRapportClient('#example9',id_fournisseur,date_debut,date_fin);



  // $('#example11').DataTable().destroy();

  // selectAllDepensePneuOperationPourRapportClient('#example11',id_fournisseur,date_debut,date_fin);



  $('#example13').DataTable().destroy();

  selectAllVentePiecesOperationPourBalanceClient('#example13',id_fournisseur,date_debut,date_fin)



  selectAllTotalVentePiecesOperationPourBalanceClient(id_fournisseur,date_debut,date_fin);



  selectAllTotalFactureOperationPourRapportClient(id_fournisseur,date_debut,date_fin);



  selectAllTotalLocationEnginOperationPourRapportClient(id_fournisseur,date_debut,date_fin);



  selectAllTotalPrimeOperationPourRapportClient(id_fournisseur,date_debut,date_fin);



  selectAllTotalFraisRouteOperationPourRapportClient(id_fournisseur,date_debut,date_fin);



  selectAllTotalFraisDiversOperationPourRapportClient(id_fournisseur,date_debut,date_fin);



  selectAllTotalPieceRechangeOperationPourRapportClient(id_fournisseur,date_debut,date_fin);



  selectAllTotalVidangeOperationPourRapportClient(id_fournisseur,date_debut,date_fin);



  selectAllTotalGazoilOperationPourRapportClient(id_fournisseur,date_debut,date_fin);

  

  // selectAllTotalDepensePneuOperationPourRapport(id_fournisseur,date_debut,date_fin);





  totalDepenseClient(id_fournisseur,date_debut,date_fin);



  getSoldeRapportCLient(id_fournisseur,date_debut,date_fin);



  selectAllTotalChargementOperationPourRapportClient(id_fournisseur,date_debut,date_fin);



  selectTotalRecetteClient(id_fournisseur,date_debut,date_fin);

}

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

// rapport mensuel benne



function totalDepenseBenne(id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/totalDepenseParRapportBenne",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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



function getSoldeBenne(id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/getSoldeBenne",

      data:{"id_type_vehicule":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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





function selectTotalRecetteBenne(id_fournisseur,date_debut,date_fin){

   $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectTotalRecetteBenne",

      data:{"id_type_vehicule":id_fournisseur,"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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

function getBalancePourOperationBenne(){

  id_fournisseur = $(".id_fournisseur").val();

  date_debut = $(".date_debut").val();

  date_fin = $(".date_fin").val();

if (date_debut == "" && date_fin == "") {



}else if(date_fin == ""){

}else if(id_fournisseur == "" || id_fournisseur==0 || id_fournisseur == "0"){

}else{

    $('#example1').DataTable().destroy();

  afficheAllFActureReglementPourBalanceRapport('#example1',id_fournisseur,date_debut,date_fin);



  $('#example2').DataTable().destroy();

  afficheAllFActurePrimePourBalanceRapport('#example2',id_fournisseur,date_debut,date_fin);



  $('#example3').DataTable().destroy();

  selectAllFraisRouteOperationPourRapport('#example3',id_fournisseur,date_debut,date_fin);



  $('#example5').DataTable().destroy();

  selectAllFraisDiversOperationPourRapport('#example5',id_fournisseur,date_debut,date_fin);

  

  $('#example4').DataTable().destroy();

  selectAllPieceRechangeOperationPourRapport('#example4',id_fournisseur,date_debut,date_fin);



$('#example10').DataTable().destroy();

  selectAllAccidentOperationPourRapport('#example10',id_fournisseur,date_debut,date_fin);



  $('#example6').DataTable().destroy();

  selectAllVidangeOperationPourRapport('#example6',id_fournisseur,date_debut,date_fin);



  $('#example7').DataTable().destroy();

  selectAllGazoilOperationPourRapport('#example7',id_fournisseur,date_debut,date_fin);



  // $('#example8').DataTable().destroy();

  // selectAllChargementOperationPourRapport('#example8',id_fournisseur,date_debut,date_fin);



  // $('#example9').DataTable().destroy();

  // selectAllLocationEnginOperationPourRapport('#example9',id_fournisseur,date_debut,date_fin);



  $('#example11').DataTable().destroy();

  selectAllDepensePneuOperationPourRapport('#example11',id_fournisseur,date_debut,date_fin)



  selectAllTotalFactureOperationPourRapport(id_fournisseur,date_debut,date_fin);





  $('#example13').DataTable().destroy();

  selectAllVentePiecesOperationPourBalance('#example13',id_fournisseur,date_debut,date_fin)



  selectAllTotalVentePiecesOperationPourBalance(id_fournisseur,date_debut,date_fin);



  // selectAllTotalLocationEnginOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalPrimeOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalFraisRouteOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalFraisDiversOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalPieceRechangeOperationPourRapport(id_fournisseur,date_debut,date_fin);


 selectAllTotalAccidentOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalVidangeOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalGazoilOperationPourRapport(id_fournisseur,date_debut,date_fin);

  

  selectAllTotalDepensePneuOperationPourRapport(id_fournisseur,date_debut,date_fin);





  totalDepenseBenne(id_fournisseur,date_debut,date_fin);



  getSoldeBenne(id_fournisseur,date_debut,date_fin);



  // selectAllTotalChargementOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectTotalRecetteBenne(id_fournisseur,date_debut,date_fin);

}

}



// rapport mensuel vraquier

function totalDepenseVraquier(id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/totalDepenseParRapportVraquier",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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



function getSoldeVraquier(id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/getSoldeVraquier",

      data:{"id_type_vehicule":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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





function selectTotalRecetteVraquier(id_fournisseur,date_debut,date_fin){

   $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectTotalRecetteVraquier",

      data:{"id_type_vehicule":id_fournisseur,"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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


// rapport mensuel engin

function totalDepenseEngin(id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/totalDepenseParRapportEngin",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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



function getSoldeEngin(id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/getSoldeEngin",

      data:{"id_type_vehicule":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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





function selectTotalRecetteEngin(id_fournisseur,date_debut,date_fin){

   $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/selectTotalRecetteEngin",

      data:{"id_type_vehicule":id_fournisseur,"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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



function getBalancePourOperationEngin(){

  id_fournisseur = $(".id_fournisseur").val();

  date_debut = $(".date_debut").val();

  date_fin = $(".date_fin").val();

if (date_debut == "" && date_fin == "") {



}else if(date_fin == ""){

}else if(id_fournisseur == "" || id_fournisseur==0 || id_fournisseur == "0"){

}else{

    $('#example1').DataTable().destroy();

  afficheAllFActureReglementPourBalanceRapport('#example1',id_fournisseur,date_debut,date_fin);



  $('#example2').DataTable().destroy();

  afficheAllFActurePrimePourBalanceRapport('#example2',id_fournisseur,date_debut,date_fin);



  $('#example5').DataTable().destroy();

  selectAllFraisDiversOperationPourRapport('#example5',id_fournisseur,date_debut,date_fin);

  

  $('#example4').DataTable().destroy();

  selectAllPieceRechangeOperationPourRapport('#example4',id_fournisseur,date_debut,date_fin);



$('#example10').DataTable().destroy();

  selectAllAccidentOperationPourRapport('#example10',id_fournisseur,date_debut,date_fin);



  $('#example6').DataTable().destroy();

  selectAllVidangeOperationPourRapport('#example6',id_fournisseur,date_debut,date_fin);



  $('#example7').DataTable().destroy();

  selectAllGazoilOperationPourRapport('#example7',id_fournisseur,date_debut,date_fin);



  $('#example9').DataTable().destroy();

  selectAllLocationEnginOperationPourRapport('#example9',id_fournisseur,date_debut,date_fin);



  $('#example11').DataTable().destroy();

  selectAllDepensePneuOperationPourRapport('#example11',id_fournisseur,date_debut,date_fin);



    $('#example13').DataTable().destroy();

  selectAllVentePiecesOperationPourBalance('#example13',id_fournisseur,date_debut,date_fin)



  selectAllTotalVentePiecesOperationPourBalance(id_fournisseur,date_debut,date_fin);



  selectAllTotalFactureOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalLocationEnginOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalPrimeOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalFraisDiversOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalPieceRechangeOperationPourRapport(id_fournisseur,date_debut,date_fin);



selectAllTotalAccidentOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalVidangeOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalGazoilOperationPourRapport(id_fournisseur,date_debut,date_fin);

  

  selectAllTotalDepensePneuOperationPourRapport(id_fournisseur,date_debut,date_fin);





  totalDepenseEngin(id_fournisseur,date_debut,date_fin);



  getSoldeEngin(id_fournisseur,date_debut,date_fin);





  selectTotalRecetteEngin(id_fournisseur,date_debut,date_fin);

}

}

// rapport mensuel vraquier

function getBalancePourOperationVraquier(){

  id_fournisseur = $(".id_fournisseur").val();

  date_debut = $(".date_debut").val();

  date_fin = $(".date_fin").val();

if (date_debut == "" && date_fin == "") {



}else if(date_fin == ""){

}else if(id_fournisseur == "" || id_fournisseur==0 || id_fournisseur == "0"){

}else{

    $('#example1').DataTable().destroy();

  afficheAllFActureReglementPourBalanceRapport('#example1',id_fournisseur,date_debut,date_fin);



  $('#example2').DataTable().destroy();

  afficheAllFActurePrimePourBalanceRapport('#example2',id_fournisseur,date_debut,date_fin);



  $('#example5').DataTable().destroy();

  selectAllFraisDiversOperationPourRapport('#example5',id_fournisseur,date_debut,date_fin);

  

  $('#example4').DataTable().destroy();

  selectAllPieceRechangeOperationPourRapport('#example4',id_fournisseur,date_debut,date_fin);


$('#example10').DataTable().destroy();

  selectAllAccidentOperationPourRapport('#example10',id_fournisseur,date_debut,date_fin);



  $('#example6').DataTable().destroy();

  selectAllVidangeOperationPourRapport('#example6',id_fournisseur,date_debut,date_fin);



  $('#example7').DataTable().destroy();

  selectAllGazoilOperationPourRapport('#example7',id_fournisseur,date_debut,date_fin);



  $('#example9').DataTable().destroy();

  selectAllLocationVraquierOperationPourRapport('#example9',id_fournisseur,date_debut,date_fin);



  $('#example11').DataTable().destroy();

  selectAllDepensePneuOperationPourRapport('#example11',id_fournisseur,date_debut,date_fin);



    $('#example13').DataTable().destroy();

  selectAllVentePiecesOperationPourBalance('#example13',id_fournisseur,date_debut,date_fin)



  selectAllTotalVentePiecesOperationPourBalance(id_fournisseur,date_debut,date_fin);



  selectAllTotalFactureOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalLocationVraquierOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalPrimeOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalFraisDiversOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalPieceRechangeOperationPourRapport(id_fournisseur,date_debut,date_fin);
  
  
  
  selectAllTotalAccidentOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalVidangeOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalGazoilOperationPourRapport(id_fournisseur,date_debut,date_fin);

  

  selectAllTotalDepensePneuOperationPourRapport(id_fournisseur,date_debut,date_fin);





  totalDepenseVraquier(id_fournisseur,date_debut,date_fin);



  getSoldeVraquier(id_fournisseur,date_debut,date_fin);





  selectTotalRecetteVraquier(id_fournisseur,date_debut,date_fin);

}

}



// rapport mensuel service



function totalDepenseService(id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/totalDepenseParRapportService",

      data:{"id_type_vehicule":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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



function getBalancePourOperationService(){

  id_fournisseur = $(".id_fournisseur").val();

  date_debut = $(".date_debut").val();

  date_fin = $(".date_fin").val();

if (date_debut == "" && date_fin == "") {



}else if(date_fin == ""){

}else if(id_fournisseur == "" || id_fournisseur==0 || id_fournisseur == "0"){

}else{

    $('#example1').DataTable().destroy();

  afficheAllFActureReglementPourBalanceRapport('#example1',id_fournisseur,date_debut,date_fin);



  $('#example2').DataTable().destroy();

  afficheAllFActurePrimePourBalanceRapport('#example2',id_fournisseur,date_debut,date_fin);



  $('#example3').DataTable().destroy();

  selectAllFraisRouteOperationPourRapport('#example3',id_fournisseur,date_debut,date_fin);



  $('#example5').DataTable().destroy();

  selectAllFraisDiversOperationPourRapport('#example5',id_fournisseur,date_debut,date_fin);

  

  $('#example4').DataTable().destroy();

  selectAllPieceRechangeOperationPourRapport('#example4',id_fournisseur,date_debut,date_fin);


$('#example10').DataTable().destroy();

  selectAllAccidentOperationPourRapport('#example10',id_fournisseur,date_debut,date_fin);


  $('#example6').DataTable().destroy();

  selectAllVidangeOperationPourRapport('#example6',id_fournisseur,date_debut,date_fin);



  $('#example7').DataTable().destroy();

  selectAllGazoilOperationPourRapport('#example7',id_fournisseur,date_debut,date_fin);



  // $('#example8').DataTable().destroy();

  // selectAllChargementOperationPourRapport('#example8',id_fournisseur,date_debut,date_fin);



  // $('#example9').DataTable().destroy();

  // selectAllLocationEnginOperationPourRapport('#example9',id_fournisseur,date_debut,date_fin);



  $('#example11').DataTable().destroy();

  selectAllDepensePneuOperationPourRapport('#example11',id_fournisseur,date_debut,date_fin)





  // $('#example13').DataTable().destroy();

  // selectAllVentePiecesOperationPourBalance('#example13',id_fournisseur,date_debut,date_fin)



  // selectAllTotalVentePiecesOperationPourBalance(id_fournisseur,date_debut,date_fin);



  // selectAllTotalFactureOperationPourRapport(id_fournisseur,date_debut,date_fin);



  // selectAllTotalLocationEnginOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalPrimeOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalFraisRouteOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalFraisDiversOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalPieceRechangeOperationPourRapport(id_fournisseur,date_debut,date_fin);


 selectAllTotalAccidentOperationPourRapport(id_fournisseur,date_debut,date_fin);


  selectAllTotalVidangeOperationPourRapport(id_fournisseur,date_debut,date_fin);



  selectAllTotalGazoilOperationPourRapport(id_fournisseur,date_debut,date_fin);

  

  selectAllTotalDepensePneuOperationPourRapport(id_fournisseur,date_debut,date_fin);





  totalDepenseService(id_fournisseur,date_debut,date_fin);



  // getSolde(id_fournisseur,date_debut,date_fin);



  // selectAllTotalChargementOperationPourRapport(id_fournisseur,date_debut,date_fin);



  // selectTotalRecette(id_fournisseur,date_debut,date_fin);

}

}



function rapportCumuleMensuel(){



  id_fournisseur = $(".id_fournisseur").val();

  date_debut = $(".date_debut").val();

  date_fin = $(".date_fin").val();

if (date_debut == "" && date_fin == "") {



}else if(date_fin == ""){

}else if(id_fournisseur == "" || id_fournisseur==0 || id_fournisseur == "0"){

}else{

  $(".chargementClient").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/rapportCumuleMensuel",

      data:{"date_debut":date_debut,"date_fin":date_fin,"id_type_vehicule":id_fournisseur},

      success: function(data){

        $('#example1').DataTable().destroy();

        $(".contentClient").empty();

        $(".contentClient").append(data);

        ceerDatatableCumule('#example1');

        $(".chargementClient").fadeOut();

        // formAddRemorque();

        // alert(data);

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

}







function rapportCumuleMensuelEN(){



  id_fournisseur = $(".id_fournisseur").val();

  date_debut = $(".date_debut").val();

  date_fin = $(".date_fin").val();

  etat = $(".etat").val();

if (date_debut == "" && date_fin == "") {



}else if(date_fin == ""){

}else if(id_fournisseur == "" || id_fournisseur==0 || id_fournisseur == "0"){

}else{

  $(".chargementClient").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/rapportCumuleMensuelEN",

      data:{"etat":etat,"date_debut":date_debut,"date_fin":date_fin,"id_type_vehicule":id_fournisseur},

      success: function(data){

        $('#example1').DataTable().destroy();

        $(".contentClient").empty();

        $(".contentClient").append(data);

        ceerDatatableCumule('#example1');

        $(".chargementClient").fadeOut();

        // formAddRemorque();

        // alert(data);

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

}









function rapportCumuleAN(){



 

  date_debut = $(".date_debut").val();

  date_fin = $(".date_fin").val();

  etat = $(".etat").val();

if (date_debut == "" && date_fin == "") {



}else{

  $(".chargementClient").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/rapportCumuleAN",

      data:{"etat":etat,"date_debut":date_debut,"date_fin":date_fin},

      success: function(data){

        $('#example1').DataTable().destroy();

        $(".contentClient").empty();

        $(".contentClient").append(data);

        ceerDatatableCumule('#example1');

        $(".chargementClient").fadeOut();

        // formAddRemorque();

        // alert(data);

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

}



function rapportCumuleMensuelService(){



  id_fournisseur = $(".id_fournisseur").val();

  date_debut = $(".date_debut").val();

  date_fin = $(".date_fin").val();

if (date_debut == "" && date_fin == "") {



}else if(date_fin == ""){

}else if(id_fournisseur == "" || id_fournisseur==0 || id_fournisseur == "0"){

}else{

  $(".chargementClient").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/rapportCumuleMensuelService",

      data:{"date_debut":date_debut,"date_fin":date_fin,"id_type_vehicule":id_fournisseur},

      success: function(data){

        $('#example1').DataTable().destroy();

        $(".contentClient").empty();

        $(".contentClient").append(data);

        ceerDatatableService('#example1');

        $(".chargementClient").fadeOut();

        // formAddRemorque();

        // alert(data);

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

}



function EnteteRapportAccident(){


  $(".chargementClient").fadeIn();
  code =$(".code_camion").val();
  date_debut = $(".date_debut").val();

  date_fin = $(".date_fin").val();
  
  // alert(code);
  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/EnteteRapportAccident",

      data:{"date_debut":date_debut,"date_fin":date_fin,"code":code},

      success: function(data){

        $(".contentCamion").empty();

        $(".contentCamion").append(data);

       

        $(".chargementClient").fadeOut();

        // formAddRemorque();

        // alert(data);
        
        rapportCumuleMensuelAccident()

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




function rapportCumuleMensuelAccident(){



  code_camion = $(".code_camion").val();

  date_debut = $(".date_debut").val();

  date_fin = $(".date_fin").val();

// alert($('.contentCamion').html());
entete =  $('.contentCamion').html();

if (date_debut != "" && date_fin != "" && code_camion != "") {

  $(".chargementClient").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/rapportCumuleMensuelAccident",

      data:{"date_debut":date_debut,"date_fin":date_fin,"code_camion":code_camion},

      success: function(data){

        $('#example1').DataTable().destroy();

        $(".contentClient").empty();

        $(".contentClient").append(data);

        ceerDatatableRapportAccident(entete,'#example1');

        $(".chargementClient").fadeOut();

        // formAddRemorque();

        // alert(data);
        
        //EnteteRapportAccident()

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

 }else if (date_fin!="" && date_debut != "" && code_camion =="") {

     $(".chargementClient").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/rapportCumuleMensuelAccident2",

     data:{"date_debut":date_debut,"date_fin":date_fin,"code_camion":code_camion},

      success: function(data){

        $('#example1').DataTable().destroy();

        $(".contentClient").empty();

        $(".contentClient").append(data);

        ceerDatatableRapportAccident(entete,'#example1');

        $(".chargementClient").fadeOut();

        // formAddRemorque();

        // alert(data);

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

}


function rapportCumuleMensuelApprovisionnement(){



  date_debut = $(".date_debut").val();

  date_fin = $(".date_fin").val();

if (date_debut == "" && date_fin == "") {



}else if(date_fin == ""){

}else{

  $(".chargementClient").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/rapportCumuleMensuelApprovisionnement",

      data:{"date_debut":date_debut,"date_fin":date_fin,},

      success: function(data){

        $('#example1').DataTable().destroy();

        $(".contentClient").empty();

        $(".contentClient").append(data);

        ceerDatatableAppro('#example1');

        $(".chargementClient").fadeOut();

        // formAddRemorque();

        // alert(data);

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

}



function rapportGeneral(){

  date_debut = $(".date_debut").val();

  date_fin = $(".date_fin").val();

if (date_debut == "" && date_fin == "") {



}else if(date_fin == ""){

}else{

  $(".chargementClient").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/rapportGeneral",

      data:{"date_debut":date_debut,"date_fin":date_fin,},

      success: function(data){

        $('#example1').DataTable().destroy();

        $(".contentClient").empty();

        $(".contentClient").append(data);

        ceerDatatableAppro('#example1');

        $(".chargementClient").fadeOut();

        // formAddRemorque();

        // alert(data);

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

}


function rapportCumuleMensuelVraquier(){



  id_fournisseur = $(".id_fournisseur").val();

  date_debut = $(".date_debut").val();

  date_fin = $(".date_fin").val();

if (date_debut == "" && date_fin == "") {



}else if(date_fin == ""){

}else if(id_fournisseur == "" || id_fournisseur==0 || id_fournisseur == "0"){

}else{

  $(".chargementClient").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/rapportCumuleMensuelVraquier",

      data:{"date_debut":date_debut,"date_fin":date_fin,"id_type_vehicule":id_fournisseur},

      success: function(data){

        $('#example1').DataTable().destroy();

        $(".contentClient").empty();

        $(".contentClient").append(data);

        ceerDatatableEngin('#example1');

        $(".chargementClient").fadeOut();

        // formAddRemorque();

        // alert(data);

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

}


// rcmvraquier



function rapportCumuleMensuelEngin(){



  id_fournisseur = $(".id_fournisseur").val();

  date_debut = $(".date_debut").val();

  date_fin = $(".date_fin").val();

if (date_debut == "" && date_fin == "") {



}else if(date_fin == ""){

}else if(id_fournisseur == "" || id_fournisseur==0 || id_fournisseur == "0"){

}else{

  $(".chargementClient").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/rapportCumuleMensuelEngin",

      data:{"date_debut":date_debut,"date_fin":date_fin,"id_type_vehicule":id_fournisseur},

      success: function(data){

        $('#example1').DataTable().destroy();

        $(".contentClient").empty();

        $(".contentClient").append(data);

        ceerDatatableEngin('#example1');

        $(".chargementClient").fadeOut();

        // formAddRemorque();

        // alert(data);

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

}





function rapportCumuleMensuelBenne(){



  id_fournisseur = $(".id_fournisseur").val();

  date_debut = $(".date_debut").val();

  date_fin = $(".date_fin").val();

if (date_debut == "" && date_fin == "") {



}else if(date_fin == ""){

}else if(id_fournisseur == "" || id_fournisseur==0 || id_fournisseur == "0"){

}else{

  $(".chargementClient").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_rapport/rapportCumuleMensuelBenne",

      data:{"date_debut":date_debut,"date_fin":date_fin,"id_type_vehicule":id_fournisseur},

      success: function(data){

        // alert(data);

        $('#example1').DataTable().destroy();

        $(".contentClient").empty();

        $(".contentClient").append(data);

        ceerDatatableBenne('#example1');

        $(".chargementClient").fadeOut();

        // formAddRemorque();

        // alert(data);

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



function infosClient1(id_client,nom,adresse,telephone,libelle){

  $(".numero").val(nom);

  $(".libelle").val(libelle);

  $(".date_charg").val(adresse);

  $(".montant").val(telephone);

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



 function imprimer_bloc(titre, objet) {



var zone = document.getElementById(objet).innerHTML;



var win = window.open("", "", "height=1300, width=1600,toolbar=0, menubar=0, scrollbars=1, resizable=1,status=0, location=0, left=10, top=10");

win.document.write('<html><head><title>Print it!</title></head><body style="backgroundColor:red;">');

win.document.write(zone );

win.document.write('</body></html>');

win.print();

win.close();

}