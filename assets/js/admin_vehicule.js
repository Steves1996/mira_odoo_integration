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

function addCamionBenne(status){

  type_camion = $(".type_camion").val();

	id_camion = $(".id_camion").val();

	chauffeur = $(".chauffeur").val();

	code = $(".code").val();

	immatriculation = $(".immatriculation").val();

	chassis = $(".chassis").val();

	kilometrage = $(".kilometrage").val();

	puissance = $(".puissance").val();

	assurance = $(".assurance").val();

	carte_grise = $(".carte_grise").val();

	carte_bleue = $(".carte_bleue").val();

	visite_technique = $(".visite_technique").val();

	taxe = $(".taxe").val();

	acces_port = $(".acces_port").val();

	licence_transport = $(".licence_transport").val();

	attestation = $(".attestation").val();

   nbreRoue = $(".nbreRoue").val();

  nbreRoueSecours =$(".nbreRoueSecours").val();

   date_init = $(".dateInitialisation").val();

  montant_init =$(".montantInitialisation").val();



  gps =$(".gps").val();
  
  delegue =$(".delegue").val();
  
  rj =$(".rj").val();




	if (code == "") {

		$(".code").css("border","red 2px solid");

		toastr.error("Veuillez remplir tous les Champs");

	}else if (immatriculation == "") {

		$(".immatriculation").css("border","red 2px solid");

		toastr.error("Veuillez remplir tous les Champs");

	}else if (gps == "") {

    $(".gps").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (delegue == "") {

    $(".delegue").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (date_init == "") {

    $(".dateInitialisation").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (montant_init == "") {

    $(".montantInitialisation").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (chassis == "") {

		$(".chassis").css("border","red 2px solid");

		toastr.error("Veuillez remplir tous les Champs");

	}else if (kilometrage == "") {

		$(".kilometrage").css("border","red 2px solid");

		toastr.error("Veuillez remplir tous les Champs");

	}else if (puissance == "") {

		$(".puissance").css("border","red 2px solid");

		toastr.error("Veuillez remplir tous les Champs");

	}else if (nbreRoue == "") {

    $(".nbreRoue").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (nbreRoueSecours == "") {

    $(".nbreRoueSecours").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }

	else{

    $(".nbreRoue").css("border","1px solid #ced4da");

    $(".nbreRoueSecours").css("border","1px solid #ced4da");

		$(".puissance").css("border","1px solid #ced4da");

		$(".immatriculation").css("border","1px solid #ced4da");

		$(".chassis").css("border","1px solid #ced4da");

		$(".kilometrage").css("border","1px solid #ced4da");

		$(".code").css("border","1px solid #ced4da");

    $(".dateInitialisation").css("border","1px solid #ced4da");

    $(".montantInitialisation").css("border","1px solid #ced4da");

    $(".gps").css("border","1px solid #ced4da");
	
	 $(".delegue").css("border","1px solid #ced4da");



		  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/addCamionBenne",

      data:{"gps":gps,"delegue":delegue,"date_init":date_init,"montant_init":montant_init,"nbreRoueSecours":nbreRoueSecours,"type_camion":type_camion,"nbreRoue":nbreRoue,"status":status,"id_camion":id_camion,"chauffeur":chauffeur,"code":code,"immatriculation":immatriculation,"chassis":chassis,"kilometrage":kilometrage,"puissance":puissance,"assurance":assurance,"carte_bleue":carte_bleue,"carte_grise":carte_grise,"visite_technique":visite_technique,"taxe":taxe,"acces_port":acces_port,"licence_transport":licence_transport,"attestation":attestation,"rj":rj},

      success: function(data){

      if ($.trim(data) == "Insertion parfaite du camion") {

      			$(document).Toasts('create', {

		        class: 'bg-success', 

		        title: 'Alerte',

		        subtitle: 'Alert',

		        body: data

		      });

      	$('#example1').DataTable().destroy();

        afficheAllCamionBenne('#example1');

      	}else if ($.trim(data) == "Modification parfaite du camion") {

      		

      		$(document).Toasts('create', {

		        class: 'bg-success', 

		        title: 'Alerte',

		        subtitle: 'Alert',

		        body: data

		      });

      	$('#example1').DataTable().destroy();

        afficheAllCamionBenne('#example1');

      	}else{

      		$(document).Toasts('create', {

		        class: 'bg-danger', 

		        title: 'Alerte',

		        subtitle: 'Alert',

		        body: data

		      });

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

       }

       });





	}

}

function afficheAllCamionBenne(idTable){

  $(".chargementCamionBenne").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/getAllCamionBenne",

      data:{},

      success: function(data){



        $(".contentCamionBenne").empty();

        $(".contentCamionBenne").append(data);

        ceerDatatable(idTable)

        $(".chargementCamionBenne").fadeOut();

        formAddCamion();

      },

       error:function(data){

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText

      })   

          $(".chargementCamionBenne").fadeOut();

       }

       });

}



function formAddCamion(){

	// $(".formAddCamion").empty();

	// $(".formAddCamion").append('<div class="overlay dark chargementAddFormCamion" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>')



	$(".chargementAddFormCamion").fadeIn();

	$(".chargementAddFormCamion2").fadeIn();

	$.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/formAddCamion",

      data:{},

      success: function(data){



        $(".formAddCamion").empty();

        $(".formAddCamion").append(data);

        $(".chargementAddFormCamion").fadeOut();

      },

       error:function(data){

       	$(".formAddCamion").empty();

        $(".formAddCamion").append(data);

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText

      })   

          $(".chargementAddFormCamion").fadeOut();

       }

       });



	$.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/formAddCamion2",

      data:{},

      success: function(data){



        $(".formAddCamion2").empty();

        $(".formAddCamion2").append(data);

        $(".chargementAddFormCamion2").fadeOut();

      },

       error:function(data){

       	$(".formAddCamion2").empty();

        $(".formAddCamion2").append(data);

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText

      })   

          $(".chargementAddFormCamion2").fadeOut();

       }

       });

}

function formUpdateCamion(id_camion){

	// $(".formAddCamion").empty();

	// $(".formAddCamion").append('<div class="overlay dark chargementAddFormCamion" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>')

	$(".id_camion").val("");

	$(".id_camion").val(id_camion);



	$(".chargementAddFormCamion").fadeIn();

	$(".chargementAddFormCamion2").fadeIn();

	$.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/afficheFormModifCamionBenne",

      data:{"id_camion":id_camion},

      success: function(data){



        $(".formAddCamion").empty();

        $(".formAddCamion").append(data);

        $(".chargementAddFormCamion").fadeOut();

      },

       error:function(data){

       	$(".formAddCamion").empty();

        $(".formAddCamion").append(data);

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText

      })   

          $(".chargementAddFormCamion").fadeOut();

       }

       });



	$.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/afficheFormModifCamionBenne2",

      data:{"id_camion":id_camion},

      success: function(data){



        $(".formAddCamion2").empty();

        $(".formAddCamion2").append(data);

        $(".chargementAddFormCamion2").fadeOut();

      },

       error:function(data){

       	$(".formAddCamion2").empty();

        $(".formAddCamion2").append(data);

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText

      })   

          $(".chargementAddFormCamion2").fadeOut();

       }

       });

}



function demandeSuppressionCamionBenne(table,identifiant,nom_id){

 $(".table").val();

 $(".identifiant").val();

 $(".nom_id").val();

 $(".table").val(table);

 $(".identifiant").val(identifiant);

 $(".nom_id").val(nom_id);

  // alert("la table est: "+table+" et identifiant: "+identifiant);

}



function confirmSuppressionCamion(){

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

        afficheAllCamionBenne('#example1');

        $('#example9').DataTable().destroy();

        afficheAllEngin('#example9');

        $('#example2').DataTable().destroy();

        afficheAllRemorque('#example2');

        $('#example3').DataTable().destroy();

        afficheAllTracteur('#example3');

      },

            error:function(data){

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'

      })

                

       }

       });

}





function confirmSuppressionCamionBenne(){

 table = $(".table").val();

 identifiant = $(".identifiant").val();

 nom_id = $(".nom_id").val();

 // creerDatable("exemple1");

 $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/deleteCamionBenne",

      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},

      success: function(data){  

        toastr.success(data);

        $('#example1').DataTable().destroy();

        afficheAllCamionBenne('#example1');

      },

            error:function(data){

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'

      })

                

       }

       });

}



function confirmSuppressionEngin(){

 table = $(".table").val();

 identifiant = $(".identifiant").val();

 nom_id = $(".nom_id").val();

 // creerDatable("exemple1");

 $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/deleteEngin",

      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},

      success: function(data){  



        toastr.success(data);



        $('#example9').DataTable().destroy();

        afficheAllEngin('#example9');

      

      },

            error:function(data){

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'

      })

                

       }

       });

}


function confirmSuppressionVraquier(){

 table = $(".table").val();

 identifiant = $(".identifiant").val();

 nom_id = $(".nom_id").val();

 // creerDatable("exemple1");

 $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/deleteVraquier",

      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},

      success: function(data){  


        // alert(table+' '+identifiant+' '+nom_id);

        toastr.success(data);



        $('#example9').DataTable().destroy();

        afficheAllVraquier('#example9');

      

      },

            error:function(data){

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur '+data.responseText

      })

                

       }

       });

}



function confirmSuppressionRemorque(){

 table = $(".table").val();

 identifiant = $(".identifiant").val();

 nom_id = $(".nom_id").val();

 // creerDatable("exemple1");

 $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/deleteRemorque",

      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},

      success: function(data){  



        toastr.success(data);



        $('#example2').DataTable().destroy();

        afficheAllRemorque('#example2');

      

      },

            error:function(data){

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'

      })

                

       }

       });

}



function confirmSuppressionTracteur(){

 table = $(".table").val();

 identifiant = $(".identifiant").val();

 nom_id = $(".nom_id").val();

 // creerDatable("exemple1");

 $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/deleteTracteur",

      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},

      success: function(data){  



        toastr.success(data);



        $('#example3').DataTable().destroy();

        afficheAllTracteur('#example3');

      

      },

            error:function(data){

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'

      })

                

       }

       });

}



function addRemorque(status){

	id_remorque = $(".id_remorque").val();

	immatriculation = $(".immatriculation").val();

	chassis = $(".chassis").val();

	assurance = $(".assurance").val();

	carte_grise = $(".carte_grise").val();

	carte_bleue = $(".carte_bleue").val();

	visite_technique = $(".visite_technique").val();

   nbreRoue = $(".nbreRoue").val();

  nbreRoueSecours =$(".nbreRoueSecours").val();
  
  rj =$(".rj").val();


	if (chassis == "") {

		$(".chassis").css("border","red 2px solid");

		toastr.error("Veuillez remplir tous les Champs");

	}else if (immatriculation == "") {

		$(".immatriculation").css("border","red 2px solid");

		toastr.error("Veuillez remplir tous les Champs");

	}else if (nbreRoue == "") {

    $(".nbreRoue").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (nbreRoueSecours == "") {

    $(".nbreRoueSecours").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }

	else{

     $(".nbreRoue").css("border","1px solid #ced4da");

    $(".nbreRoueSecours").css("border","1px solid #ced4da");

		$(".puissance").css("border","1px solid #ced4da");

		$(".immatriculation").css("border","1px solid #ced4da");

		$(".chassis").css("border","1px solid #ced4da");

		$(".kilometrage").css("border","1px solid #ced4da");

		$(".code").css("border","1px solid #ced4da");



		  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/addRemorque",

      data:{"nbreRoueSecours":nbreRoueSecours,"nbreRoue":nbreRoue,"id_remorque":id_remorque,"status":status,"immatriculation":immatriculation,"chassis":chassis,"assurance":assurance,"carte_bleue":carte_bleue,"carte_grise":carte_grise,"visite_technique":visite_technique,"rj":rj},

      success: function(data){

              if ($.trim(data) == "Insertion parfaite de la remorque") {

      			$(document).Toasts('create', {

		        class: 'bg-success', 

		        title: 'Alerte',

		        subtitle: 'Alert',

		        body: data

		      });

      	$('#example1').DataTable().destroy();

        afficheAllRemorque('#example1');

      	}else if ($.trim(data) == "modification parfaite de la remorque") {

      		$(document).Toasts('create', {

		        class: 'bg-success', 

		        title: 'Alerte',

		        subtitle: 'Alert',

		        body: data

		      });

      		$('#example1').DataTable().destroy();

        afficheAllRemorque('#example1');

      	}

      	else{

      		$(document).Toasts('create', {

		        class: 'bg-danger', 

		        title: 'Alerte',

		        subtitle: 'Alert',

		        body: data

		      });

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

       }

       });





	}

}





function afficheAllRemorque(idTable){

  $(".chargementCamionBenne").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/getAllRemorque",

      data:{},

      success: function(data){



        $(".contentRemorque").empty();

        $(".contentRemorque").append(data);

        ceerDatatable(idTable)

        $(".chargementCamionBenne").fadeOut();

        formAddRemorque();

      },

       error:function(data){

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText

      })   

          $(".chargementCamionBenne").fadeOut();

       }

       });

}



function formAddRemorque(){

	// $(".formAddCamion").empty();

	// $(".formAddCamion").append('<div class="overlay dark chargementAddFormCamion" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>')



	$(".chargementAddFormCamion").fadeIn();

	$(".chargementAddFormCamion2").fadeIn();

	$.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/formAddRemorque",

      data:{},

      success: function(data){



        $(".formAddRemorque").empty();

        $(".formAddRemorque").append(data);

        $(".chargementAddFormCamion").fadeOut();

      },

       error:function(data){

       	$(".formAddRemorque").empty();

        $(".formAddRemorque").append(data);

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur '+data.responseText

      })   

          $(".chargementAddFormCamion").fadeOut();

       }

       });



	$.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/formAddRemorque2",

      data:{},

      success: function(data){



        $(".formAddRemorque2").empty();

        $(".formAddRemorque2").append(data);

        $(".chargementAddFormCamion2").fadeOut();

      },

       error:function(data){

       	$(".formAddCamion2").empty();

        $(".formAddCamion2").append(data);

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur '+data.responseText

      })   

          $(".chargementAddFormCamion2").fadeOut();

       }

       });

}



function formUpdateRemorque(id_remorque){

	$(".id_remorque").val("");

	$(".id_remorque").val(id_remorque);

	$(".chargementAddFormCamion").fadeIn();

	$(".chargementAddFormCamion2").fadeIn();

	$.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/afficheFormModifRemorque",

      data:{"id_remorque":id_remorque},

      success: function(data){



        $(".formAddRemorque").empty();

        $(".formAddRemorque").append(data);

        $(".chargementAddFormCamion").fadeOut();

      },

       error:function(data){

       	$(".formAddRemorque").empty();

        $(".formAddRemorque").append(data);

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur '+data.responseText

      })   

          $(".chargementAddFormCamion").fadeOut();

       }

       });



	$.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/afficheFormModifRemorque2",

      data:{"id_remorque":id_remorque},

      success: function(data){



        $(".formAddRemorque2").empty();

        $(".formAddRemorque2").append(data);

        $(".chargementAddFormCamion2").fadeOut();

      },

       error:function(data){

       	$(".formAddCamion2").empty();

        $(".formAddCamion2").append(data);

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur '+data.responseText

      })   

          $(".chargementAddFormCamion2").fadeOut();

       }

       });

}

function formAddTracteur(){

	// $(".formAddCamion").empty();

	// $(".formAddCamion").append('<div class="overlay dark chargementAddFormCamion" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>')



	$(".chargementAddFormCamion").fadeIn();

	$(".chargementAddFormCamion2").fadeIn();

	$.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/formAddTracteur",

      data:{},

      success: function(data){



        $(".formAddCamion").empty();

        $(".formAddCamion").append(data);

        $(".chargementAddFormCamion").fadeOut();

      },

       error:function(data){

       	$(".formAddCamion").empty();

        $(".formAddCamion").append(data);

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur '+data.responseText

      })   

          $(".chargementAddFormCamion").fadeOut();

       }

       });



	$.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/formAddTracteur2",

      data:{},

      success: function(data){



        $(".formAddCamion2").empty();

        $(".formAddCamion2").append(data);

        $(".chargementAddFormCamion2").fadeOut();

      },

       error:function(data){

       	$(".formAddCamion2").empty();

        $(".formAddCamion2").append(data);

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur '+data.responseText

      })   

          $(".chargementAddFormCamion2").fadeOut();

       }

       });

}



// formulaire pour la modification des tracteurs

function formUpdateTracteur(id_tracteur){

	// $(".formAddCamion").empty();

	// $(".formAddCamion").append('<div class="overlay dark chargementAddFormCamion" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>')

	$(".id_tracteur").val("");

	$(".id_tracteur").val(id_tracteur);

	$(".chargementAddFormCamion").fadeIn();

	$(".chargementAddFormCamion2").fadeIn();

	$.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/afficheFormModifTracteur",

      data:{"id_tracteur":id_tracteur},

      success: function(data){



        $(".formAddCamion").empty();

        $(".formAddCamion").append(data);

        $(".chargementAddFormCamion").fadeOut();

      },

       error:function(data){

       	$(".formAddCamion").empty();

        $(".formAddCamion").append(data);

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur '+data.responseText

      })   

          $(".chargementAddFormCamion").fadeOut();

       }

       });



	$.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/afficheFormModifTracteur2",

      data:{"id_tracteur":id_tracteur},

      success: function(data){



        $(".formAddCamion2").empty();

        $(".formAddCamion2").append(data);

        $(".chargementAddFormCamion2").fadeOut();

      },

       error:function(data){

       	$(".formAddCamion2").empty();

        $(".formAddCamion2").append(data);

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur '+data.responseText

      })   

          $(".chargementAddFormCamion2").fadeOut();

       }

       });

}

function afficheAllTracteur(idTable){

  $(".chargementCamionBenne").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/getAllTracteur",

      data:{},

      success: function(data){



        $(".contentCamionBenne").empty();

        $(".contentCamionBenne").append(data);

        ceerDatatable(idTable)

        $(".chargementCamionBenne").fadeOut();

        formAddTracteur();

      },

       error:function(data){

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText

      })   

          $(".chargementCamionBenne").fadeOut();

       }

       });

}



function addTracteur(status){

  type_camion = $(".type_camion").val();

	id_tracteur = $(".id_tracteur").val();

	chauffeur = $(".chauffeur").val();

	code = $(".code").val();

	immatriculation = $(".immatriculation").val();

	chassis = $(".chassis").val();

	kilometrage = $(".kilometrage").val();

	puissance = $(".puissance").val();

	assurance = $(".assurance").val();

	carte_grise = $(".carte_grise").val();

	carte_bleue = $(".carte_bleue").val();

	visite_technique = $(".visite_technique").val();

	taxe = $(".taxe").val();

	acces_port = $(".acces_port").val();

	licence_transport = $(".licence_transport").val();

	attestation = $(".attestation").val();

	remorque = $(".remorque").val();

	typeTracteur = $(".typeTracteur").val();

  nbreRoue = $(".nbreRoue").val();

  nbreRoueSecours =$(".nbreRoueSecours").val();



     date_init = $(".dateInitialisation").val();

  montant_init =$(".montantInitialisation").val();



  gps =$(".gps").val();
  
   delegue =$(".delegue").val();
   
   rj =$(".rj").val();


	if (code == "") {

		$(".code").css("border","red 2px solid");

		toastr.error("Veuillez remplir tous les Champs");

	}else if (immatriculation == "") {

		$(".immatriculation").css("border","red 2px solid");

		toastr.error("Veuillez remplir tous les Champs");

	}else if (gps == "") {

    $(".gps").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (delegue == "") {

    $(".delegue").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (chassis == "") {

		$(".chassis").css("border","red 2px solid");

		toastr.error("Veuillez remplir tous les Champs");

	}else if (kilometrage == "") {

		$(".kilometrage").css("border","red 2px solid");

		toastr.error("Veuillez remplir tous les Champs");

	}else if (puissance == "") {

		$(".puissance").css("border","red 2px solid");

		toastr.error("Veuillez remplir tous les Champs");

	}else if (nbreRoue == "") {

    $(".nbreRoue").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (date_init == "") {

    $(".date_init").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (montant_init == "") {

    $(".montant_init").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (nbreRoueSecours == "") {

    $(".nbreRoueSecours").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }

	else{

		$(".puissance").css("border","1px solid #ced4da");

		$(".immatriculation").css("border","1px solid #ced4da");

		$(".chassis").css("border","1px solid #ced4da");

		$(".kilometrage").css("border","1px solid #ced4da");

		$(".code").css("border","1px solid #ced4da");

    $(".date_init").css("border","1px solid #ced4da");

    $(".montant_init").css("border","1px solid #ced4da");

    $(".gps").css("border","1px solid #ced4da");
	
	 $(".delegue").css("border","1px solid #ced4da");





		  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/addTracteur",

      data:{"gps":gps,"delegue":delegue,"date_init":date_init,"montant_init":montant_init,"nbreRoueSecours":nbreRoueSecours,"type_camion":type_camion,"nbreRoue":nbreRoue,"typeTracteur":typeTracteur,"id_tracteur":id_tracteur,"status":status,"remorque":remorque,"chauffeur":chauffeur,"code":code,"immatriculation":immatriculation,"chassis":chassis,"kilometrage":kilometrage,"puissance":puissance,"assurance":assurance,"carte_bleue":carte_bleue,"carte_grise":carte_grise,"visite_technique":visite_technique,"taxe":taxe,"acces_port":acces_port,"licence_transport":licence_transport,"attestation":attestation,"rj":rj},

      success: function(data){

      	// toastr.info("Enregistrement véhicule réussie");

      	  if ($.trim(data) == "Insertion parfaite du camion") {

      			$(document).Toasts('create', {

		        class: 'bg-success', 

		        title: 'Alerte',

		        subtitle: 'Alert',

		        body: data

		      });

      	$('#example3').DataTable().destroy();

        afficheAllTracteur('#example3');

      	}else if ($.trim(data) == "Modification parfaite du camion") {

      	$(document).Toasts('create', {

		        class: 'bg-success', 

		        title: 'Alerte',

		        subtitle: 'Alert',

		        body: data

		      });

      	$('#example3').DataTable().destroy();

        afficheAllTracteur('#example3');

      	} else{

      		$(document).Toasts('create', {

		        class: 'bg-danger', 

		        title: 'Alerte',

		        subtitle: 'Alert',

		        body: data

		      });

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

       }

       });





	}

}





// le code qui suis est celui de recettes/depense





function afficheAllFActureReglementPourBalanceOperation(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/selectAllFactureOperationPourBalance",

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

      url:base_url+"/admin_vehicule/selectAllPrimeOperationPourBalance",

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

      url:base_url+"/admin_vehicule/selectAllFraisRouteOperationPourBalance",

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

      url:base_url+"/admin_vehicule/selectAllFraisDiversOperationPourBalance",

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

      url:base_url+"/admin_vehicule/selectAllPieceRechangeOperationPourBalance",

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

      url:base_url+"/admin_vehicule/selectAllVidangeOperationPourBalance",

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

      url:base_url+"/admin_vehicule/selectAllGazoilOperationPourBalance",

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

function selectAllPneuPourBalance(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/selectAllPneuPourBalance",

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

function selectAllTotalPneuPourBalance(id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/selectAllTotalPneuPourBalance",

      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

      success: function(data){

        // alert(data);

         $(".totalPneu").val("");

        formatMillierPourSelection(data,'totalPneu');

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



function selectAllDepenseSalaireChauffeurPourRapport(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/selectAllDepenseSalaireChauffeurPourRapport",

      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

      success: function(data){

        // alert(data);

        $(".contentPrime12").empty();

        $(".contentPrime12").append(data);

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



function selectAllVentePiecesPourRapport(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/selectAllVentePiecesPourRapport",

      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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



function selectAllTotalVentePiecesPourRapport(id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/selectAllTotalVentePiecesPourRapport",

      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

      success: function(data){

        // alert(data);

        $(".totalVente").val("");

        formatMillierPourSelection(data,'totalVente');

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



function selectAllTotalDepenseSalaireChauffeurPourRapport(id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/selectAllTotalDepenseSalaireChauffeurPourRapport",

      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

      success: function(data){

        // alert(data);

        $(".totalChauff").val("");

        formatMillierPourSelection(data,'totalChauff');

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

      url:base_url+"/admin_vehicule/selectAllChargementOperationPourBalance",

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



function selectAllPneuPourBalance(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();



  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/selectAllPneuPourBalance",

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

          alert(data.responseText);

          $(".chargementPrime").fadeOut();

       }

       });





}

function selectAllTotalFactureOperationPourBalance(id_fournisseur,date_debut,date_fin){

   $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/selectAllTotalFactureOperationPourBalance",

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

      url:base_url+"/admin_vehicule/selectTotalRecette",

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

      url:base_url+"/admin_vehicule/selectAllTotalPrimeOperationPourBalance",

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

      url:base_url+"/admin_vehicule/selectAllTotalFraisRouteOperationPourBalance",

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

      url:base_url+"/admin_vehicule/selectAllTotalFraisDiversOperationPourBalance",

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

      url:base_url+"/admin_vehicule/selectAllTotalPieceRechangeOperationPourBalance",

      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

      success: function(data){

        $(".totalPieceRechange").val("");

        formatMillierPourSelection(data,'totalPieceRechange');



       

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

      url:base_url+"/admin_vehicule/selectAllTotalVidangeOperationPourBalance",

      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

      success: function(data){

        $(".totalVidange").val("");

        formatMillierPourSelection(data,'totalVidange');



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

      url:base_url+"/admin_vehicule/selectAllTotalGazoilOperationPourBalance",

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

      url:base_url+"/admin_vehicule/selectAllTotalChargementOperationPourBalance",

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

function selectAllTotalAccidentOperationPourBalance(id_fournisseur,date_debut,date_fin){

   $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/selectAllTotalAccidentOperationPourBalance",

      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

      success: function(data){

        $(".totalaccident").val("");

        formatMillierPourSelection(data,'totalaccident');



       

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

      url:base_url+"/admin_vehicule/totalDepenseParOperation",

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

    formatMillierPourSelection(''+parseInt(pu)*parseFloat(quantite)+'','PT');

  }

}

function selectAllLocationEnginOperationPourBalance(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/selectAllLocationEnginOperationPourBalance",

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


function selectAllAccidentOperationPourBalance(idTable,id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/selectAllAccidentOperationPourBalance",

      data:{"id_operation":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

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


function selectAllTotalLocationEnginOperationPourBalance(id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/selectAllTotalLocationEnginOperationPourBalance",

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

function getSolde(id_fournisseur,date_debut,date_fin){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/getSolde",

      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},

      success: function(data){

        // alert(data);

        $(".solde").val("");

        formatMillierPourSelection(data,'solde')



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

function getChaufeurEtImmariculation(){

  camion = $(".camion").val();



  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/getChauffeur",

      data:{"code_camion":camion},

      success: function(data){

        // alert(data);

        $(".chauffeur").val("");

        $(".chauffeur").val(data);

        

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



  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/getImmatriculation",

      data:{"code_camion":camion},

      success: function(data){

        // alert(data);

        $(".immatriculation").val("");

        $(".immatriculation").val(data);

        

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

  selectAllPneuPourBalance('#example9',id_fournisseur,date_debut,date_fin);

     

     $('#example12').DataTable().destroy();

  selectAllDepenseSalaireChauffeurPourRapport('#example12',id_fournisseur,date_debut,date_fin);



 $('#example13').DataTable().destroy();

  selectAllVentePiecesPourRapport('#example13',id_fournisseur,date_debut,date_fin);



  $('#example10').DataTable().destroy();

  selectAllLocationEnginOperationPourBalance('#example10',id_fournisseur,date_debut,date_fin);
  
  
  $('#example11').DataTable().destroy();

  selectAllAccidentOperationPourBalance('#example11',id_fournisseur,date_debut,date_fin);




  selectAllTotalLocationEnginOperationPourBalance(id_fournisseur,date_debut,date_fin);



  selectAllTotalPneuPourBalance(id_fournisseur,date_debut,date_fin);

  

  selectAllTotalDepenseSalaireChauffeurPourRapport(id_fournisseur,date_debut,date_fin)

  

  selectAllTotalVentePiecesPourRapport(id_fournisseur,date_debut,date_fin)



  selectAllTotalFactureOperationPourBalance(id_fournisseur,date_debut,date_fin);



  selectAllTotalPrimeOperationPourBalance(id_fournisseur,date_debut,date_fin);



  selectAllTotalFraisRouteOperationPourBalance(id_fournisseur,date_debut,date_fin);



  selectAllTotalFraisDiversOperationPourBalance(id_fournisseur,date_debut,date_fin);



  selectAllTotalPieceRechangeOperationPourBalance(id_fournisseur,date_debut,date_fin);



  selectAllTotalVidangeOperationPourBalance(id_fournisseur,date_debut,date_fin);



  selectAllTotalGazoilOperationPourBalance(id_fournisseur,date_debut,date_fin);
  
  
  selectAllTotalAccidentOperationPourBalance(id_fournisseur,date_debut,date_fin);



  totalDepense(id_fournisseur,date_debut,date_fin);



  getSolde(id_fournisseur,date_debut,date_fin);



  selectAllTotalChargementOperationPourBalance(id_fournisseur,date_debut,date_fin);



  selectTotalRecette(id_fournisseur,date_debut,date_fin);

}

  



}



// ceci est la partie reservée aux distances





function addDistance(status){

  // alert(status);

  route = $(".route").val();

  retour = $(".retour").val();

  code_camion = $(".code_camion").val();

  distance = $(".distance").val();

  littrage = $(".littrage").val();
  
  kilometrage = $(".kilometrage").val();

  littrage_unitaire = $(".littrage_unitaire").val();

  id_client = $(".id_client").val();

  // alert(code_camion);

  if (code_camion == "") {

    $(".code_camion").css("border","red 2px solid");

    toastr.error("Veuillez choisir un camion");

  }else if (distance == "") {

    $(".distance").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (retour == "") {

    $(".retour").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (littrage == "") {

    $(".littrage").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (route == "") {

    $(".route").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (littrage_unitaire == "") {

    $(".littrage_unitaire").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (kilometrage == "") {

    $(".kilometrage").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else{

    $(".amortissement").css("border","1px solid #ced4da");

    $(".code_camion").css("border","1px solid #ced4da");

    $(".distance").css("border","1px solid #ced4da");

    $(".littrage").css("border","1px solid #ced4da");

    $(".kilometrage").css("border","1px solid #ced4da");
	
	 $(".littrage_unitaire").css("border","1px solid #ced4da");
	 
	  $(".retour").css("border","1px solid #ced4da");
	
	 $(".route").css("border","1px solid #ced4da");


   
$(".chargementCarteGrise1").fadeIn();

     $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/addDistance",

      data:{"route":route,"retour":retour,"status":status,"id_client":id_client,"code_camion":code_camion,"distance":distance,"littrage":littrage,"kilometrage":kilometrage,"littrage_unitaire":littrage_unitaire},

       success: function(data){

   if ($.trim(data) == "Insertion réussie") {

  //   $(".nom").val("");

  // $(".adresse").val("");

  // $(".telephone").val("");

    toastr.info(data);

        $('#example1').DataTable().destroy();

        afficheAllDistance('#example1');

        $(".chargementCarteGrise1").fadeOut();

      }else if ($.trim(data) == "Modification réussie") {

        $(".distance").val("");

        $(".littrage").val("");

        $(".btnAnnulerModif").fadeOut();

  $(".btnModifClient").fadeOut();

  $(".btnAddClient").fadeIn();

    toastr.info(data);

        $('#example1').DataTable().destroy();

        afficheAllDistance('#example1');

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

function getLitrage(){
	
	
  code_camion = $(".code_camion").val();
  
  littrage_unitaire = $(".littrage_unitaire");
  
 
  
    if (code_camion == "")  {
    
	code_camion.removeAttr("disabled","false");
	
	
   // num_bordereau.removeAttr("disabled","false");
  }else if (littrage_unitaire == "" ) {
 	 
	littrage_unitaire.removeAttr("disabled","false");

  }else {
	  

	
	littrage_unitaire.attr("disabled","true");
	

	}
	

 // getTypeCamion(code_camion);
  $.ajax({
      type:"POST",
      url:base_url+"/admin_vehicule/getLitrage",
     data:{"code_camion":code_camion},
      success: function(data){
         $(".littrage_unitaire").val("");
			 
         $(".littrage_unitaire").val(data);
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


function addDistance1(status){

  // alert(status);

  

  code_camion = $(".code_camion").val();

 

  littrage_unitaire = $(".littrage_unitaire").val();
  
  

  id_client = $(".id_client").val();

  // alert(code_camion);

  if (code_camion == "") {

    $(".code_camion").css("border","red 2px solid");

    toastr.error("Veuillez choisir un camion");

  }else if (littrage_unitaire == "") {

    $(".littrage_unitaire").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else{

  

    $(".code_camion").css("border","1px solid #ced4da");

   
	 $(".littrage_unitaire").css("border","1px solid #ced4da");
	 
	 

   
$(".chargementCarteGrise1").fadeIn();

     $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/addDistance1",

      data:{"status":status,"id_client":id_client,"code_camion":code_camion,"littrage_unitaire":littrage_unitaire},

       success: function(data){

   if ($.trim(data) == "Insertion réussie") {



    toastr.info(data);

        $('#example1').DataTable().destroy();

        afficheAllDistance1('#example1');

        $(".chargementCarteGrise1").fadeOut();

      }else if ($.trim(data) == "Modification réussie") {

        

        $(".littrage_unitaire").val("");

        $(".btnAnnulerModif").fadeOut();

  $(".btnModifClient").fadeOut();

  $(".btnAddClient").fadeIn();

    toastr.info(data);

        $('#example1').DataTable().destroy();

        afficheAllDistance1('#example1');

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



function addLocationEngin(status){

  // alert(status);

  destinationRoute = $(".destinationRoute").val();

  code_camion = $(".code_camion").val();

  duree = $(".duree").val();

  commentaire = $(".commentaire").val();

  unite = $(".unite").val();

  id_operation = $(".operation").val();

  montant = $(".montant").val();

  tva = $(".tva").val();

  date_location = $(".date_location").val();

  id_client = $(".id_client").val(); 



  gps = $(".gps").val(); 

  // alert(code_camion);

  if (code_camion == "") {

    $(".code_camion").css("border","red 2px solid");

    toastr.error("Veuillez choisir un camion");

  }else if (destinationRoute == "") {

  $(".destinationRoute").css("border","red 2px solid");

  toastr.error("Veuillez remplir tous les Champs");

  }else if (gps == "") {

  $(".gps").css("border","red 2px solid");

  toastr.error("Veuillez remplir tous les Champs");

  }else if (duree == "") {

    $(".duree").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (id_operation == "") {

    $(".operation").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (unite == "") {

    $(".unite").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (montant == "") {

    $(".montant").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (date_location == "") {

    $(".date_location").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else{

    $(".destinationRoute").css("border","1px solid #ced4da");

    $(".operation").css("border","1px solid #ced4da");

    $(".unite").css("border","1px solid #ced4da");

    $(".code_camion").css("border","1px solid #ced4da");

    $(".duree").css("border","1px solid #ced4da");

    $(".montant").css("border","1px solid #ced4da");

    $(".date_location").css("border","1px solid #ced4da");

    $(".gps").css("border","1px solid #ced4da");

    $(".chargementCarteGrise1").fadeIn();

     $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/addLocationEngin",

      data:{"gps":gps,"tva":tva,"destination":destinationRoute,"commentaire":commentaire,"id_operation":id_operation,"unite":unite,"status":status,"id_client":id_client,"code_camion":code_camion,"montant":montant,"duree":duree,"date_location":date_location},

       success: function(data){

   if ($.trim(data) == "Insertion réussie") {

  //   $(".nom").val("");

  // $(".adresse").val("");

  // $(".telephone").val("");

    toastr.info(data);

        $('#example1').DataTable().destroy();

        afficheAllLocationEngin('#example1');

        $(".chargementCarteGrise1").fadeOut();

      }else if ($.trim(data) == "Modification réussie") {

        $(".distance").val("");

        $(".littrage").val("");

        $(".btnAnnulerModif").fadeOut();

  $(".btnModifClient").fadeOut();

  $(".btnAddClient").fadeIn();

    toastr.success(data);

        $('#example1').DataTable().destroy();

        afficheAllLocationEngin('#example1');

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



function afficheAllLocationEngin(idTable){

  $(".chargementClient").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/getAllLocationEngin",

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


// location vraquier


function addLocationVraquier(status){

  // alert(status);

  destinationRoute = $(".destinationRoute").val();

  code_camion = $(".code_camion").val();

  duree = $(".duree").val();

  commentaire = $(".commentaire").val();

  unite = $(".unite").val();

  id_operation = $(".operation").val();

  montant = $(".montant").val();

  tva = $(".tva").val();

  date_location = $(".date_location").val();

  id_client = $(".id_client").val(); 



  gps = $(".gps").val(); 

  // alert(code_camion);

  if (code_camion == "") {

    $(".code_camion").css("border","red 2px solid");

    toastr.error("Veuillez choisir un camion");

  }else if (destinationRoute == "") {

  $(".destinationRoute").css("border","red 2px solid");

  toastr.error("Veuillez remplir tous les Champs");

  }else if (gps == "") {

  $(".gps").css("border","red 2px solid");

  toastr.error("Veuillez remplir tous les Champs");

  }else if (duree == "") {

    $(".duree").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (id_operation == "") {

    $(".operation").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (unite == "") {

    $(".unite").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (montant == "") {

    $(".montant").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (date_location == "") {

    $(".date_location").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else{

    $(".destinationRoute").css("border","1px solid #ced4da");

    $(".operation").css("border","1px solid #ced4da");

    $(".unite").css("border","1px solid #ced4da");

    $(".code_camion").css("border","1px solid #ced4da");

    $(".duree").css("border","1px solid #ced4da");

    $(".montant").css("border","1px solid #ced4da");

    $(".date_location").css("border","1px solid #ced4da");

    $(".gps").css("border","1px solid #ced4da");

    $(".chargementCarteGrise1").fadeIn();

     $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/addLocationVraquier",

      data:{"gps":gps,"tva":tva,"destination":destinationRoute,"commentaire":commentaire,"id_operation":id_operation,"unite":unite,"status":status,"id_client":id_client,"code_camion":code_camion,"montant":montant,"duree":duree,"date_location":date_location},

       success: function(data){

   if ($.trim(data) == "Insertion réussie") {

  //   $(".nom").val("");

  // $(".adresse").val("");

  // $(".telephone").val("");

    toastr.info(data);

        $('#example1').DataTable().destroy();

        afficheAllLocationVraquier('#example1');

        $(".chargementCarteGrise1").fadeOut();

      }else if ($.trim(data) == "Modification réussie") {

        $(".distance").val("");

        $(".littrage").val("");

        $(".btnAnnulerModif").fadeOut();

  $(".btnModifClient").fadeOut();

  $(".btnAddClient").fadeIn();

    toastr.success(data);

        $('#example1').DataTable().destroy();

        afficheAllLocationVraquier('#example1');

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

function afficheAllLocationVraquier(idTable){

  $(".chargementClient").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/getAllLocationVraquier",

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


function confirmSuppressionDistance(){

 table = $(".table").val();

 identifiant = $(".identifiant").val();

 nom_id = $(".nom_id").val();

 // creerDatable("exemple1");

 $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/deleteDistance",

      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},

      success: function(data){  



        toastr.success(data);

        $('#example1').DataTable().destroy();

        afficheAllDistance('#example1');





        

          

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



function infosDistance(id_client,id_type,distance,distance1,littrage1,littrage,retour,route,info){

  $(".retour").val(retour);

  $(".route").val(route);

  $(".distance").val(distance);

  $(".littrage").val(littrage);
  
  $(".kilometrage").val(distance1);

  $(".littrage_unitaire").val(littrage1);

  $(".info").val(info);

  $(".id_client").val(id_client);
  
   $(".code_camion").val(id_type);

  $(".btnAnnulerModif").fadeIn();

  $(".btnModifClient").fadeIn();

  $(".btnAddClient").fadeOut();

}



function infosClient(id_client,littrage,distance,info,amort){

  $(".amortissement").val(amort);

  $(".distance").val(distance);

  $(".littrage").val(littrage);

  $(".info").val(info);

  $(".id_client").val(id_client);

  $(".btnAnnulerModif").fadeIn();

  $(".btnModifClient").fadeIn();

  $(".btnAddClient").fadeOut();

}

function infosTypeVehicule(id_client,littrage,distance,montant,distance_min){

  $(".montant").val(montant);

  $(".distance_minimale").val(distance_min);

  $(".commentaire").val(distance);

  $(".nom_type").val(littrage);

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



function getCamionEtRoues(){

    code_camion = $(".code_camion").val();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/getCamionEtRoues",

      data:{"code_camion":code_camion},

      success: function(data){

        // alert(data);

        $(".info").val("");

        $(".info").val(data);

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

function confirmSuppressionTypeVehicule(){

 table = $(".table").val();

 identifiant = $(".identifiant").val();

 nom_id = $(".nom_id").val();

 // creerDatable("exemple1");

 $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/deleteTypeVehicule",

      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},

      success: function(data){  



        toastr.success(data);

        $('#example1').DataTable().destroy();

        afficheAllTypeVehicule('#example1');

        

          

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



function afficheAllDistance(idTable){

  $(".chargementClient").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/getAllDistance",

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

function afficheAllDistance1(idTable){

  $(".chargementClient").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/getAllDistance1",

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



function afficheAllTypeVehicule(idTable){

  $(".chargementClient").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/getAllTypeVehicule",

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







function addTypeVehicule(status){

  // alert(status);

  montant = $(".montant").val();

  distance_min= $(".distance_minimale").val();

  nom_type = $(".nom_type").val();

  commentaire = $(".commentaire").val();

 

  id_client = $(".id_client").val();

  nui = $(".nui").val();

  if (nom_type == "") {

    $(".nom_type").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (commentaire == "") {

    $(".commentaire").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (montant == "") {

    $(".montant").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else{

    $(".montant").css("border","1px solid #ced4da");

    $(".nom_type").css("border","1px solid #ced4da");

    $(".commentaire").css("border","1px solid #ced4da");

$(".chargementCarteGrise1").fadeIn();

     $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/addTypeVehicule",

      data:{"distance_min":distance_min,"montant":montant,"status":status,"id_client":id_client,"nom_type":nom_type,"commentaire":commentaire},

       success: function(data){

   if ($.trim(data) == "Insertion du type de véhicule réussie") {

    $(".nom_type").val("");

  $(".commentaire").val("");

     $(".montant").val("");

    toastr.info(data);

        $('#example1').DataTable().destroy();

        afficheAllTypeVehicule('#example1');

        $(".chargementCarteGrise1").fadeOut();

      }else if ($.trim(data) == "Modification du type de véhicule réussie") {

        $(".nom_type").val("");

  $(".commentaire").val("");

    toastr.info(data);

        $('#example1').DataTable().destroy();

        afficheAllTypeVehicule('#example1');

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



function afficheAllEngin(idTable){

  $(".chargementCamionBenne").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/getAllEngin",

      data:{},

      success: function(data){



        $(".contentCamionBenne").empty();

        $(".contentCamionBenne").append(data);

        ceerDatatable(idTable)

        $(".chargementCamionBenne").fadeOut();

        formAddCamion();

      },

       error:function(data){

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText

      })   

          $(".chargementCamionBenne").fadeOut();

       }

       });

}



function addEngin(status){

  type_camion = $(".type_camion").val();

  id_camion = $(".id_camion").val();

  chauffeur = $(".chauffeur").val();

  // alert(chauffeur);

  code = $(".code").val();

  immatriculation = $(".immatriculation").val();

  chassis = $(".chassis").val();

  kilometrage = $(".kilometrage").val();

  puissance = $(".puissance").val();
  

  assurance = $(".assurance").val();

  carte_grise = $(".carte_grise").val();

 

  visite_technique = $(".visite_technique").val();

  taxe = $(".taxe").val();

  acces_port = $(".acces_port").val();

  licence_transport = $(".licence_transport").val();

  attestation = $(".attestation").val();

   nbreRoue = $(".nbreRoue").val();

  nbreRoueSecours =$(".nbreRoueSecours").val();
  
  date_init = $(".dateInitialisation").val();

  montant_init =$(".montantInitialisation").val();




  gps =$(".gps").val();
  
  rj =$(".rj").val();



  if (code == "") {

    $(".code").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (immatriculation == "") {

    $(".immatriculation").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (gps == "") {

    $(".gps").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (chassis == "") {

    $(".chassis").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (kilometrage == "") {

    $(".kilometrage").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (puissance == "") {

    $(".puissance").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (nbreRoue == "") {

    $(".nbreRoue").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (nbreRoueSecours == "") {

    $(".nbreRoueSecours").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (date_init == "") {

    $(".date_init").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (nbreRoueSecours == "") {

    $(".montant_init").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }

  else{

    $(".nbreRoue").css("border","1px solid #ced4da");

    $(".nbreRoueSecours").css("border","1px solid #ced4da");

    $(".puissance").css("border","1px solid #ced4da");

    $(".immatriculation").css("border","1px solid #ced4da");

    $(".chassis").css("border","1px solid #ced4da");

    $(".kilometrage").css("border","1px solid #ced4da");

    $(".code").css("border","1px solid #ced4da");

    $(".gps").css("border","1px solid #ced4da");
	
	$(".date_init").css("border","1px solid #ced4da");

    $(".montant_init").css("border","1px solid #ced4da");



      $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/addEngin",

      data:{"gps":gps,"rj":rj,"date_init":date_init,"montant_init":montant_init,"nbreRoueSecours":nbreRoueSecours,"type_camion":type_camion,"nbreRoue":nbreRoue,"status":status,"id_camion":id_camion,"chauffeur":chauffeur,"code":code,"immatriculation":immatriculation,"chassis":chassis,"kilometrage":kilometrage,"puissance":puissance,"assurance":assurance,"carte_grise":carte_grise,"visite_technique":visite_technique,"taxe":taxe,"acces_port":acces_port,"licence_transport":licence_transport,"attestation":attestation},

      success: function(data){

      if ($.trim(data) == "Insertion parfaite du camion") {

            $(document).Toasts('create', {

            class: 'bg-success', 

            title: 'Alerte',

            subtitle: 'Alert',

            body: data

          });

        $('#example9').DataTable().destroy();

        afficheAllEngin('#example9');

        }else if ($.trim(data) == "Modification parfaite du camion") {

          

          $(document).Toasts('create', {

            class: 'bg-success', 

            title: 'Alerte',

            subtitle: 'Alert',

            body: data

          });

        $('#example9').DataTable().destroy();

        afficheAllEngin('#example9');

        }else{

          $(document).Toasts('create', {

            class: 'bg-danger', 

            title: 'Alerte',

            subtitle: 'Alert',

            body: data

          });

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

       }

       });





  }

}



function afficheAllEngin(idTable){

  $(".chargementCamionBenne").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/getAllEngin",

      data:{},

      success: function(data){



        $(".contentCamionBenne").empty();

        $(".contentCamionBenne").append(data);

        ceerDatatable(idTable)

        $(".chargementCamionBenne").fadeOut();

        formAddEngin();

      },

       error:function(data){

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText

      })   

          $(".chargementCamionBenne").fadeOut();

       }

       });

}


function addVraquier(status){

  type_camion = $(".type_camion").val();

  id_camion = $(".id_camion").val();

  chauffeur = $(".chauffeur").val();

  // alert(chauffeur);

  code = $(".code").val();

  immatriculation = $(".immatriculation").val();

  chassis = $(".chassis").val();

  kilometrage = $(".kilometrage").val();

  puissance = $(".puissance").val();

  assurance = $(".assurance").val();

  carte_grise = $(".carte_grise").val();

 

  visite_technique = $(".visite_technique").val();

  carte_bleue = $(".carte_bleue").val();

  acces_port = $(".acces_port").val();

  attestation = $(".attestation").val();

   nbreRoue = $(".nbreRoue").val();

  nbreRoueSecours =$(".nbreRoueSecours").val();
  
  date_init = $(".dateInitialisation").val();

  montant_init =$(".montantInitialisation").val();




  gps =$(".gps").val();
  
  rj =$(".rj").val();



  if (code == "") {

    $(".code").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (immatriculation == "") {

    $(".immatriculation").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (gps == "") {

    $(".gps").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (chassis == "") {

    $(".chassis").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (kilometrage == "") {

    $(".kilometrage").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (puissance == "") {

    $(".puissance").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (nbreRoue == "") {

    $(".nbreRoue").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (nbreRoueSecours == "") {

    $(".nbreRoueSecours").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (date_init == "") {

    $(".date_init").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (montant_init == "") {

    $(".montant_init").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }
  

  else{

    $(".nbreRoue").css("border","1px solid #ced4da");

    $(".nbreRoueSecours").css("border","1px solid #ced4da");

    $(".puissance").css("border","1px solid #ced4da");

    $(".immatriculation").css("border","1px solid #ced4da");

    $(".chassis").css("border","1px solid #ced4da");

    $(".kilometrage").css("border","1px solid #ced4da");

    $(".code").css("border","1px solid #ced4da");

    $(".gps").css("border","1px solid #ced4da");
	
	 $(".date_init").css("border","1px solid #ced4da");

    $(".montant_init").css("border","1px solid #ced4da");



      $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/addVraquier",

      data:{"gps":gps,"rj":rj,"date_init":date_init,"montant_init":montant_init,"nbreRoueSecours":nbreRoueSecours,"type_camion":type_camion,"nbreRoue":nbreRoue,"status":status,"id_camion":id_camion,"chauffeur":chauffeur,"code":code,"immatriculation":immatriculation,"chassis":chassis,"kilometrage":kilometrage,"puissance":puissance,"assurance":assurance,"carte_grise":carte_grise,"visite_technique":visite_technique,"carte_bleue":carte_bleue,"acces_port":acces_port,"attestation":attestation},

      success: function(data){

      if ($.trim(data) == "Insertion parfaite du vraquier") {

            $(document).Toasts('create', {

            class: 'bg-success', 

            title: 'Alerte',

            subtitle: 'Alert',

            body: data

          });

        $('#example9').DataTable().destroy();

        afficheAllVraquier('#example9');

        }else if ($.trim(data) == "Modification parfaite du vraquier") {

          

          $(document).Toasts('create', {

            class: 'bg-success', 

            title: 'Alerte',

            subtitle: 'Alert',

            body: data

          });

        $('#example9').DataTable().destroy();

        afficheAllVraquier('#example9');

        }else{

          $(document).Toasts('create', {

            class: 'bg-danger', 

            title: 'Alerte',

            subtitle: 'Alert',

            body: data

          });

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

       }

       });





  }

}


function afficheAllVraquier(idTable){

  $(".chargementCamionBenne").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/getAllVraquier",

      data:{},

      success: function(data){



        $(".contentCamionBenne").empty();

        $(".contentCamionBenne").append(data);

        ceerDatatable(idTable)

        $(".chargementCamionBenne").fadeOut();

        formAddVraquier();

      },

       error:function(data){

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText

      })   

          $(".chargementCamionBenne").fadeOut();

       }

       });

}

function confirmSuppressionLocationEngin(){

 table = $(".table").val();

 identifiant = $(".identifiant").val();

 nom_id = $(".nom_id").val();

 // creerDatable("exemple1");

 $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/deleteLocationEngin",

      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},

      success: function(data){  



        toastr.success(data);

        $('#example1').DataTable().destroy();

        afficheAllLocationEngin('#example1');



        

        

          

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



function confirmSuppressionLocationVraquier(){

 table = $(".table").val();

 identifiant = $(".identifiant").val();

 nom_id = $(".nom_id").val();

 // creerDatable("exemple1");

 $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/deleteLocationVraquier",

      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},

      success: function(data){  



        toastr.success(data);

        $('#example1').DataTable().destroy();

        afficheAllLocationVraquier('#example1');



        

        

          

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


function infosLocationEngin(id_location,code,duree,montant,date_location,commentaire,id_operation,unite,tva){

  $(".commentaire").val(commentaire);

  $(".code_camion").val(code);

  $(".duree").val(duree);

  $(".unite").val(unite);

  $(".tva").val(tva);

  $(".operation").val(id_operation);



  if (tva == "non") {

    $(".montant").val(montant);

    $(".PU1").val(montant);

  }else{

    nouveauPU =Math.round(montant / 1.1925);

    $(".PU1").val( nouveauPU);

    $(".montant").val(montant);

  }

  

  $(".date_location").val(date_location);

  $(".id_client").val(id_location);

  $(".btnAnnulerModif").fadeIn();

  $(".btnModifClient").fadeIn();

  $(".btnAddClient").fadeOut();

}



function formAddEngin(){

  // $(".formAddCamion").empty();

  // $(".formAddCamion").append('<div class="overlay dark chargementAddFormCamion" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>')



  $(".chargementAddFormCamion").fadeIn();

  $(".chargementAddFormCamion2").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/formAddEngin",

      data:{},

      success: function(data){



        $(".formAddCamion").empty();

        $(".formAddCamion").append(data);

        $(".chargementAddFormCamion").fadeOut();

      },

       error:function(data){

        $(".formAddCamion").empty();

        $(".formAddCamion").append(data);

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText

      })   

          $(".chargementAddFormCamion").fadeOut();

       }

       });



  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/formAddEngin2",

      data:{},

      success: function(data){



        $(".formAddCamion2").empty();

        $(".formAddCamion2").append(data);

        $(".chargementAddFormCamion2").fadeOut();

      },

       error:function(data){

        $(".formAddCamion2").empty();

        $(".formAddCamion2").append(data);

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText

      })   

          $(".chargementAddFormCamion2").fadeOut();

       }

       });

}

function formUpdateEngin(id_camion){

  // $(".formAddCamion").empty();

  // $(".formAddCamion").append('<div class="overlay dark chargementAddFormCamion" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>')

  $(".id_c041 amion").val("");

  $(".id_camion").val(id_camion);



  $(".chargementAddFormCamion").fadeIn();

  $(".chargementAddFormCamion2").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/afficheFormModifEngin",

      data:{"id_camion":id_camion},

      success: function(data){



        $(".formAddCamion").empty();

        $(".formAddCamion").append(data);

        $(".chargementAddFormCamion").fadeOut();

      },

       error:function(data){

        $(".formAddCamion").empty();

        $(".formAddCamion").append(data);

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText

      })   

          $(".chargementAddFormCamion").fadeOut();

       }

       });



  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/afficheFormModifEngin2",

      data:{"id_camion":id_camion},

      success: function(data){



        $(".formAddCamion2").empty();

        $(".formAddCamion2").append(data);

        $(".chargementAddFormCamion2").fadeOut();

      },

       error:function(data){

        $(".formAddCamion2").empty();

        $(".formAddCamion2").append(data);

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText

      })   

          $(".chargementAddFormCamion2").fadeOut();

       }

       });

}

// les vraquiers


function formAddVraquier(){

 
  $(".chargementAddFormCamion").fadeIn();

  $(".chargementAddFormCamion2").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/formAddVraquier",

      data:{},

      success: function(data){



        $(".formAddCamion").empty();

        $(".formAddCamion").append(data);

        $(".chargementAddFormCamion").fadeOut();

      },

       error:function(data){

        $(".formAddCamion").empty();

        $(".formAddCamion").append(data);

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText

      })   

          $(".chargementAddFormCamion").fadeOut();

       }

       });



  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/formAddVraquier2",

      data:{},

      success: function(data){



        $(".formAddCamion2").empty();

        $(".formAddCamion2").append(data);

        $(".chargementAddFormCamion2").fadeOut();

      },

       error:function(data){

        $(".formAddCamion2").empty();

        $(".formAddCamion2").append(data);

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText

      })   

          $(".chargementAddFormCamion2").fadeOut();

       }

       });

}



function formUpdateVraquier(id_camion){


  $(".id_c041 amion").val("");

  $(".id_camion").val(id_camion);



  $(".chargementAddFormCamion").fadeIn();

  $(".chargementAddFormCamion2").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/afficheFormModifVraquier",

      data:{"id_camion":id_camion},

      success: function(data){



        $(".formAddCamion").empty();

        $(".formAddCamion").append(data);

        $(".chargementAddFormCamion").fadeOut();

      },

       error:function(data){

        $(".formAddCamion").empty();

        $(".formAddCamion").append(data);

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText

      })   

          $(".chargementAddFormCamion").fadeOut();

       }

       });



  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/afficheFormModifVraquier2",

      data:{"id_camion":id_camion},

      success: function(data){



        $(".formAddCamion2").empty();

        $(".formAddCamion2").append(data);

        $(".chargementAddFormCamion2").fadeOut();

      },

       error:function(data){

        $(".formAddCamion2").empty();

        $(".formAddCamion2").append(data);

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText

      })   

          $(".chargementAddFormCamion2").fadeOut();

       }

       });

}



function demandeSuppressionCamionBenne(table,identifiant,nom_id){

 $(".table").val();

 $(".identifiant").val();

 $(".nom_id").val();

 $(".table").val(table);

 $(".identifiant").val(identifiant);

 $(".nom_id").val(nom_id);

  // alert("la table est: "+table+" et identifiant: "+identifiant);

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



function afficheAllAmortissement(){

code_camion = $(".camion").val();

  $(".chargementClient1").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/getAmortissementParCodeCamion",

      data:{"code_camion":code_camion },

      success: function(data){

        // alert(data);

        $('#example1').DataTable().destroy();

        $(".contentClient").empty();

        $(".contentClient").append(data);

        ceerDatatable("#example1");

        $(".chargementClient1").fadeOut();

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

function cumulAmortissementParCamion(){

code_camion = $(".camion").val();

  $(".chargementClient1").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/cumulAmortissementParCamion",

      data:{"code_camion":code_camion },

      success: function(data){

        // alert(data);

        formatMillierPourSelection(data,'cumul');

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



function getMontantVehiculeParCode(){

code_camion = $(".camion").val();

  $(".chargementClient1").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/getMontantVehiculeParCode",

      data:{"code_camion":code_camion },

      success: function(data){

        // alert(data);

        formatMillierPourSelection(data,'achat');

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



function getImmatriculationParCode(){

code_camion = $(".camion").val();

  $(".chargementClient1").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/getImmatriculationParCode",

      data:{"code_camion":code_camion },

      success: function(data){

        // alert(data);

        $(".matricule").val("");

        $(".matricule").val(data);

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



function getSoldeAmortissement(){

code_camion = $(".camion").val();

  $(".chargementClient1").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/getSoldeAmortissement",

      data:{"code_camion":code_camion },

      success: function(data){

        // alert(data);

       formatMillierPourSelection(data,'solde');

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



function getMontantInitialParCode(){

code_camion = $(".camion").val();

  $(".chargementClient1").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/getMontantInitialParCode",

      data:{"code_camion":code_camion },

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



function getDateInitialParCode(){

code_camion = $(".camion").val();

  $(".chargementClient1").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/getDateInitialParCode",

      data:{"code_camion":code_camion },

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



function amortissement(){

  afficheAllAmortissement();

  cumulAmortissementParCamion();

  getMontantVehiculeParCode();

  getImmatriculationParCode();

  getSoldeAmortissement();

  getMontantInitialParCode();

  getDateInitialParCode();

}

// <divstyle="border:1pxsolid#990 000;padding-left:20px;margin:0 010px0;"><h4>APHPErrorwasencountered</h4><p>Severity:Notice</p><p>Message:Undefinedproperty:stdClass::$amortissement</p><p>Filename:models/Crud_model_livraison.php</p><p>LineNumber:206</p>  <p>Backtrace:</p>                       <pstyle="margin-left:10px">     File:/home/hgdcam/mira/application/models/Crud_model_livraison.php<br/>     Line:206<br/>     Function:_error_handler     </p>                <pstyle="margin-left:10px">     File:/home/hgdcam/mira/application/controllers/Admin_livraison.php<br/>     Line:62<br/>      Function:getAmortissementDestination      </p>                            <pstyle="margin-left:10px">     File:/home/hgdcam/mira/index.php<br/>     Line:315<br/>     Function:require_once     </p>      </div> FCFA

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



function selectAllDistanceParcourue(idTable){

  $(".chargementPrime").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/selectAllDistanceParcourue",

      data:{},

      success: function(data){



        $(".contentClient").empty();

        $(".contentClient").append(data);

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

          $(".chargementPrime").fadeOut();

       }

       });

}

function selectAllDistanceType(idTable){
    
    code_camion = $(".code_camion").val();

  $(".chargementClient").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/selectAllDistanceType",

      data:{"code_camion":code_camion},

      success: function(data){

      $(idTable).DataTable().destroy();
        // alert(data);
        $(".contentClient").empty();

        $(".contentClient").append(data);

        ceerDatatable(idTable);

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


function confirmSuppressionDistanceParcourue(){

 table = $(".table").val();

 identifiant = $(".identifiant").val();

 nom_id = $(".nom_id").val();

 // creerDatable("exemple1");

 $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/deleteDistanceParcourue",

      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},

      success: function(data){  



        toastr.success(data);

        $('#example1').DataTable().destroy();

        selectAllDistanceParcourue('#example1');

        

          

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



function addDistanceParcourue(status){

  // alert(status);

  camion = $(".camion").val();

  kilometrage_debut = $(".kilometrage_debut").val();

  kilometrage_fin = $(".kilometrage_fin").val();

  date_distance = $(".date_distance").val();

  id_client = $(".id_client").val();

  commentaire = $(".commentaire").val();



  if (kilometrage_fin == "") {

    $(".kilometrage_fin").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (kilometrage_debut == "") {

    $(".kilometrage_debut").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (date_distance == "") {

    $(".date_distance").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (kilometrage_debut.replace(/\s/g,'') > kilometrage_fin.replace(/\s/g,'') ) {

   

    toastr.error("Le kilometrage de fin doit être supérieure à celui du debut");

  }else{

    $(".kilometrage_debut").css("border","1px solid #ced4da");

    $(".kilometrage_fin").css("border","1px solid #ced4da");

    $(".date_distance").css("border","1px solid #ced4da");

$(".chargementCarteGrise1").fadeIn();

     $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/addDistanceParcourue",

      data:{"commentaire":commentaire,"status":status,"date_distance":date_distance,"kilometrage_fin":kilometrage_fin,"kilometrage_debut":kilometrage_debut,"id_client":id_client,"code_camion":camion},

       success: function(data){

   if ($.trim(data) == "Insertion parfaite de la distance parcourue") {

  //   $(".nom").val("");

  // $(".adresse").val("");

  // $(".telephone").val("");

    toastr.info(data);

        $('#example1').DataTable().destroy();

        selectAllDistanceParcourue('#example1');

        $(".chargementCarteGrise1").fadeOut();

      }else if ($.trim(data) == "Modification parfaite de la distance parcourue") {

        $(".nom").val("");

  $(".adresse").val("");

  $(".telephone").val("");

    toastr.info(data);

        $('#example1').DataTable().destroy();

        selectAllDistanceParcourue('#example1');

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



  function infosDistanceParcourue(id_distance,code_camion,kilometrage_debut,kilometrage_fin,date_distance,commentaire){

  $(".commentaire").val(commentaire);

  $(".date_distance").val(date_distance);

  $(".kilometrage_fin").val(kilometrage_fin);

  $(".kilometrage_debut").val(kilometrage_debut);

  $(".camion").val(code_camion);

  getChaufeurEtImmariculation();

  $(".id_client").val(id_distance);

  $(".btnAnnulerModif").fadeIn();

  $(".btnModifClient").fadeIn();

  $(".btnAddClient").fadeOut();

 }



 function distanceParcourue(){

  kilometrage_debut = $(".kilometrage_debut").val();

   kilometrage_debut= kilometrage_debut.replace(/\s/g,'');

  kilometrage_fin = $(".kilometrage_fin").val();

  kilometrage_fin= kilometrage_fin.replace(/\s/g,'');



  if (kilometrage_debut == "" || kilometrage_debut == undefined) {

    kilometrage_debut = 0;

  }

    if (kilometrage_fin == "" || kilometrage_fin == undefined) {

    kilometrage_fin = 0;

    kilometrage_debut = 0;

  }

distance = parseFloat(kilometrage_fin)-parseFloat(kilometrage_debut)

  // formatMillierPourSelection(''+distance+'','distance_parcourue');

classe ="distance_parcourue"

distance = Math.round(distance * 100) / 100;

  nombre = ''+distance+'';

          nombre = nombre.replace(/ /g,'');

       nombre +='';



      var sep = ' ';

      var reg = /(\d+)(\d{3})/;



      while( reg.test( nombre )){

        nombre = nombre.replace(reg,'$1'+sep+'$2');

      } 



    $("."+classe).val("");

     $("."+classe).val(nombre+' KM');

}



function addVoitureService(status){

  type_camion = $(".type_camion").val();

  id_camion = $(".id_camion").val();

  chauffeur = $(".chauffeur").val();

  // alert(chauffeur);

  code = $(".code").val();

  immatriculation = $(".immatriculation").val();

  chassis = $(".chassis").val();

  kilometrage = $(".kilometrage").val();

  puissance = $(".puissance").val();

  assurance = $(".assurance").val();

  carte_grise = $(".carte_grise").val();

 

  visite_technique = $(".visite_technique").val();

  taxe = $(".taxe").val();

  acces_port = $(".acces_port").val();

  licence_transport = $(".licence_transport").val();

  attestation = $(".attestation").val();

   nbreRoue = $(".nbreRoue").val();

  nbreRoueSecours =$(".nbreRoueSecours").val();



  gps =$(".gps").val();
  
  rj =$(".rj").val();



  if (code == "") {

    $(".code").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (immatriculation == "") {

    $(".immatriculation").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (gps == "") {

    $(".gps").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (chassis == "") {

    $(".chassis").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (kilometrage == "") {

    $(".kilometrage").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (puissance == "") {

    $(".puissance").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (nbreRoue == "") {

    $(".nbreRoue").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }else if (nbreRoueSecours == "") {

    $(".nbreRoueSecours").css("border","red 2px solid");

    toastr.error("Veuillez remplir tous les Champs");

  }

  else{

    $(".nbreRoue").css("border","1px solid #ced4da");

    $(".nbreRoueSecours").css("border","1px solid #ced4da");

    $(".puissance").css("border","1px solid #ced4da");

    $(".immatriculation").css("border","1px solid #ced4da");

    $(".chassis").css("border","1px solid #ced4da");

    $(".kilometrage").css("border","1px solid #ced4da");

    $(".code").css("border","1px solid #ced4da");

    $(".gps").css("border","1px solid #ced4da");



      $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/addVoitureService",

      data:{"gps":gps,"rj":rj,"nbreRoueSecours":nbreRoueSecours,"type_camion":type_camion,"nbreRoue":nbreRoue,"status":status,"id_camion":id_camion,"chauffeur":chauffeur,"code":code,"immatriculation":immatriculation,"chassis":chassis,"kilometrage":kilometrage,"puissance":puissance,"assurance":assurance,"carte_grise":carte_grise,"visite_technique":visite_technique,"taxe":taxe,"acces_port":acces_port,"licence_transport":licence_transport,"attestation":attestation},

      success: function(data){

      if ($.trim(data) == "Insertion parfaite du camion") {

            $(document).Toasts('create', {

            class: 'bg-success', 

            title: 'Alerte',

            subtitle: 'Alert',

            body: data

          });

        $('#example9').DataTable().destroy();

        afficheAllVoitureService('#example9');

        }else if ($.trim(data) == "Modification parfaite du camion") {

          

          $(document).Toasts('create', {

            class: 'bg-success', 

            title: 'Alerte',

            subtitle: 'Alert',

            body: data

          });

        $('#example9').DataTable().destroy();

        afficheAllVoitureService('#example9');

        }else{

          $(document).Toasts('create', {

            class: 'bg-danger', 

            title: 'Alerte',

            subtitle: 'Alert',

            body: data

          });

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

       }

       });





  }

}



function afficheAllVoitureService(idTable){

  $(".chargementCamionBenne").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/getAllVoitureService",

      data:{},

      success: function(data){



        $(".contentCamionBenne").empty();

        $(".contentCamionBenne").append(data);

        ceerDatatable(idTable)

        $(".chargementCamionBenne").fadeOut();

        formAddVoitureService();

      },

       error:function(data){

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText

      })   

          $(".chargementCamionBenne").fadeOut();

       }

       });

}





function formAddVoitureService(){

  // $(".formAddCamion").empty();

  // $(".formAddCamion").append('<div class="overlay dark chargementAddFormCamion" style="display: none;"><i class="fas fa-3x fa-sync-alt fa-spin"></i><div class="text-bold pt-2">Chargement...</div></div>')



  $(".chargementAddFormCamion").fadeIn();

  $(".chargementAddFormCamion2").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/formAddVoitureService",

      data:{},

      success: function(data){



        $(".formAddCamion").empty();

        $(".formAddCamion").append(data);

        $(".chargementAddFormCamion").fadeOut();

      },

       error:function(data){

        $(".formAddCamion").empty();

        $(".formAddCamion").append(data);

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText

      })   

          $(".chargementAddFormCamion").fadeOut();

       }

       });



  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/formAddVoitureService2",

      data:{},

      success: function(data){



        $(".formAddCamion2").empty();

        $(".formAddCamion2").append(data);

        $(".chargementAddFormCamion2").fadeOut();

      },

       error:function(data){

        $(".formAddCamion2").empty();

        $(".formAddCamion2").append(data);

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText

      })   

          $(".chargementAddFormCamion2").fadeOut();

       }

       });

}

function formUpdateVoitureService(id_camion){

  
  $(".id_c041 amion").val("");

  $(".id_camion").val(id_camion);



  $(".chargementAddFormCamion").fadeIn();

  $(".chargementAddFormCamion2").fadeIn();

  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/afficheFormModifVoitureService",

      data:{"id_camion":id_camion},

      success: function(data){



        $(".formAddCamion").empty();

        $(".formAddCamion").append(data);

        $(".chargementAddFormCamion").fadeOut();

      },

       error:function(data){

        $(".formAddCamion").empty();

        $(".formAddCamion").append(data);

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText

      })   

          $(".chargementAddFormCamion").fadeOut();

       }

       });



  $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/afficheFormModifVoitureService2",

      data:{"id_camion":id_camion},

      success: function(data){



        $(".formAddCamion2").empty();

        $(".formAddCamion2").append(data);

        $(".chargementAddFormCamion2").fadeOut();

      },

       error:function(data){

        $(".formAddCamion2").empty();

        $(".formAddCamion2").append(data);

          $(document).Toasts('create', {

        class: 'bg-danger', 

        title: 'Erreur de connexion',

        subtitle: 'Alert',

        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText

      })   

          $(".chargementAddFormCamion2").fadeOut();

       }

       });

}



function confirmSuppressionVoitureService(){

 table = $(".table").val();

 identifiant = $(".identifiant").val();

 nom_id = $(".nom_id").val();

 // creerDatable("exemple1");

 $.ajax({

      type:"POST",

      url:base_url+"/admin_vehicule/deleteVoitureService",

      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},

      success: function(data){  



        toastr.success(data);



        $('#example9').DataTable().destroy();

        afficheAllVoitureService('#example9');

      

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



function getPrixAvecTVALocationEngin(){



  tva = $(".tva").val();

  pu = $(".PU1").val();

  if (tva == 'oui') {

    

    nouveauPU =Math.round(pu * 1.1925);

    $(".PU").val( nouveauPU);

    // getMontantTotal();

  }else{

    $(".PU").val(pu);

    // getMontantTotal();

  }
  
}

function calculDepense(depensetotal,depense,qtite,montant){
  if (depensetotal == "") {
      depensetotal = depense.replace(/\s+/g, '');
    }else{
      depensetotal = depensetotal.replace(/\s+/g, '');
    }

    total = qtite*montant;

    depensetotal =parseInt(depensetotal)+parseInt(total);

    $('.depensetotal').val(depensetotal);
}

 function addAccident(){
     
    article = $(".article").val();
	qtite = $(".qtite").val();
	operation = $(".operation").val();
    reference = $(".reference").val();
    code_camion = $(".code_camion").val();
    montant = $(".montant").val();
    depense = $(".depense").val();
    lieu = $(".lieu").val();
    date_acc = $(".date_acc").val();
    date_ent= $(".date_ent").val();
    date_sort = $(".date_sort").val();

    depensetotal = $('.depensetotal').val();

    


  	if (qtite == "") {
		$(".qtite").css("border","red 2px solid");
		toastr.error("Veuillez renseigner la quantité");
	}else if (operation == "") {
		$(".operation").css("border","red 2px solid");
		toastr.error("Vous devez entrer le nom de l'operation");
	}else if (article == "") {
		$(".article").css("border","red 2px solid");
		toastr.error("Vous devez entrer le nom de l'article");
	}else if (code_camion == "") {
    $(".bl").css("border","red 2px solid");
    toastr.error("Vous devez entrer le code camion");

  }else if (montant == "") {
    $(".montant").css("border","red 2px solid");
    toastr.error("Vous devez entrer le montant de l'article");

  }else if (lieu == "") {
    $(".lieu").css("border","red 2px solid");
    toastr.error("Vous devez entrer le lieu de l'accident");

  }
  
  else if (depense == "") {
    $(".depense").css("border","red 2px solid");
    toastr.error("Vous devez entrer le montant de la depsense de l'accident");

  }
  else if (date_acc == "") {
		$(".date_acc").css("border","red 2px solid");
		toastr.error("Veuillez renseigner la date de l'accident");

	}
	else if (date_ent == "") {
		$(".date_acc").css("border","red 2px solid");
		toastr.error("Veuillez renseigner la date d'entrée au garage'");

	}	else if (date_sort == "") {
		$(".date_sort").css("border","red 2px solid");
		toastr.error("Veuillez renseigner la date de sortie du garage'");

	}
	else{
		$(".chargementInventaire").fadeIn();
        $(".operation").css("border","1px solid #ced4da");
        $(".code_camion").css("border","1px solid #ced4da");
        $(".lieu").css("border","1px solid #ced4da");
        $(".date_acc").css("border","1px solid #ced4da");
		$(".date_ent").css("border","1px solid #ced4da");
		$(".date_sort").css("border","1px solid #ced4da");
		$(".qtite").css("border","1px solid #ced4da");
		$(".depense").css("border","1px solid #ced4da");
		$(".montant").css("border","1px solid #ced4da");
		$(".article").css("border","1px solid #ced4da");
		$(".reference").css("border","1px solid #ced4da");
		$.ajax({
      type:"POST",
      url:base_url+"/Admin_vehicule/addAccident",
      data:{"article":article,"reference":reference,"qtite":qtite,"operation":operation,
      "code_camion":code_camion,"montant":montant,"depense":depense,"lieu":lieu
      ,"date_acc":date_acc,"date_ent":date_ent,"date_sort":date_sort},
      success: function(data){
      	
      		if ($.trim(data) =="ok") {
      	toastr.success("Insertion Parfaite");
        calculDepense(depensetotal,depense,qtite,montant);
      	$(".contentAddInventaire").append("<tr><td>"+$(".article option:selected").text()+"</td><td>"+$(".reference").val()+"</td><td>"+$(".montant").val()+" FCFA</td><td>"+qtite+"</td></tr>");
      	updateFormaccident();
        
      }else{
      	$(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      })   
          $(".chargementInventaire").fadeOut();
      }
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementInventaire").fadeOut();
       }
       });
	}
}

function selectAllAccident(idTable){
    date_debut = $('.date_debut').val();
    date_fin = $('.date_fin').val();
    code_camion1 = $('.code_camion1').val();
   

 	  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_vehicule/selectAllAccident",
      data:{
        'date_fin':date_fin,
        'date_debut':date_debut,
        'code_camion1':code_camion1
      },
      success: function(data){
        // alert(data);
        $(".contentClient1").empty();
        $(".contentClient1").append(data);
        ceerDatatable(idTable)
        $(".chargementClient1").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementClient1").fadeOut();
       }
       });


 }

function updateFormaccident(){
  $(".chargementInventaire").fadeIn();
  $(".formAddInventaire").remove();
          $.ajax({
          type:"POST",
          url:base_url+"/admin_vehicule/getLeselectArticlePourAccident",
          data:{},
          success: function(dat){
            $(".contentAddInventaire").append(dat);
            
            $('#example10').DataTable().destroy();
            selectAllAccident('#example10');
            $(".chargementInventaire").fadeOut();

            
          },
          error: function(er){

          }
      })
} 

 function confirmSuppressionAccident(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_vehicule/deleteAccident",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
		selectAllAccident('#example1');
        updateFormaccident();
          
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


function getReferenceArticle(){
  id_article = $(".article").val();
 
   $.ajax({
      type:"POST",
      url:base_url+"/admin_vehicule/getReferenceArticle",
      data:{'id_article':id_article},
      success: function(data){
        $(".reference").val("");
        
        $(".reference").val(data);
     
        getReferenceArticle1()
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

function getReferenceArticle1(){
  id_article = $(".article").val();
 
   $.ajax({
      type:"POST",
      url:base_url+"/admin_vehicule/getReferenceArticle1",
      data:{'id_article':id_article},
      success: function(data){
       
        $(".montant").val("");
      
        $(".montant").val(data);
        
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

function getMontantTotal(){
	
  littrage_unitaire = $(".littrage_unitaire").val();
  kilometrage = $(".kilometrage").val();
  // var quantite = quantite.replace(".",",");
  if (littrage_unitaire == 0 || littrage_unitaire == "") {
$(".littrage").val(0);
  }else if (kilometrage == 0 || kilometrage == "") {
    $(".littrage").val(0);
  }else{ 
    // $(".PT").val(parseInt(pu)*parseInt(quantite)+" FCFA");
    kilometrage = kilometrage.replace(/\s+/g, '');
	 littrage_unitaire = littrage_unitaire.replace(/\s+/g, '');
    // alert(pu);
    total = parseFloat(kilometrage)*parseFloat(littrage_unitaire);
    
    formatMillierPourSelection1(''+total.toFixed(2)+'','littrage');
  }
}

