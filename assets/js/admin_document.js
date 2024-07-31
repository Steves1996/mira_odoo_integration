base_url = "http://localhost/miratransport/";
$("td").click(function(){
  // $('#example1').DataTable().row($(this).parents('tr')).remove().draw(); 
   $('#example1').DataTable().destroy(); 
   
   table = $("#example1").DataTable({
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
});

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
function annuler(){
  $(".modification").fadeOut();
  $(".insertion").fadeIn();
  $(".annuler").fadeOut();
}
function infoDocument(dateEffetCarteGrise,lieuCarteGrise,numeroCarteGrise,identifiant,table,id_table){
  $(".lieuCarteGrise").val(lieuCarteGrise);
  $(".dateEffetCarteGrise").val(dateEffetCarteGrise);
  // alert(lieuCarteGrise);
  $(".numeroCarteGrise").val(numeroCarteGrise);
  $(".modification").fadeIn();
  $(".insertion").fadeOut();
  $(".annuler").fadeIn();
  $(".identifiant").val(identifiant);
  $(".table").val(table);
  $(".id_table").val(id_table);
  $(".alertSucces").empty();
}
function addCarteGrise(etatRequete){

  lieuCarteGrise = $(".lieuCarteGrise");
  dateEffetCarteGrise = $(".dateEffetCarteGrise");
  numeroCarteGrise = $(".numeroCarteGrise");
   type = $(".type").val();
   table = $(".table").val();
    identifiant = $(".identifiant").val();
    id_table = $(".id_table").val();
  // if (etatRequete == "update") {
  //   table = $(".table").val();
  //   identifiant = $(".identifiant").val();
  //   id_table = $(".id_table").val();
  // }

  if (lieuCarteGrise.val() == "") {
    lieuCarteGrise.css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (dateEffetCarteGrise.val() == "") {
    dateEffetCarteGrise.css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (numeroCarteGrise.val() == "") {
    numeroCarteGrise.css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }
  else{
    // alert(id_table);
    lieuCarteGrise.css("border","1px solid #ced4da");
    dateEffetCarteGrise.css("border","1px solid #ced4da");
    numeroCarteGrise.css("border","1px solid #ced4da");
      $(".chargementCarteGrise1").fadeIn();
      $.ajax({
      type:"POST",
      url:base_url+"/admin_document/addDocument",
      data:{"id_table":id_table,"identifiant":identifiant,"table":table,"etatRequete":etatRequete,"type":type,'lieu':lieuCarteGrise.val(),"dateEffet":dateEffetCarteGrise.val(),"numero":numeroCarteGrise.val()},
      success: function(data){  
        $(".chargementCarteGrise1").fadeOut();
         // alert(data);
         $(".alertSucces").empty();
         if ($.trim(data) =="Insertion parfaite du document") {
           toastr.success(data);
           $(".lieuCarteGrise").val(" ");
        $(".dateEffetCarteGrise").val(" ");
        $(".numeroCarteGrise").val(" ");
        $(".btnUpdate").fadeOut();
        }else if ($.trim(data) == "Modification parfaite du document") {
          // alert(data);
          toastr.success(data);
          $(".lieuCarteGrise").val(" ");
        $(".dateEffetCarteGrise").val(" ");
        $(".numeroCarteGrise").val(" ");
        $(".btnUpdate").fadeOut();
        } else{
       
          var alerte = '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><h5><i class="icon fas fa-ban"></i> Alert!</h5>'+data+'</div>';
        }
         // alert(data);
         $(".alertSucces").append(alerte);
         $('#example1').DataTable().destroy();
        afficheAllCarteGrise('#example1');

        $('#example2').DataTable().destroy();
        afficheAllAssurance('#example2');

        $('#example3').DataTable().destroy();
        afficheCarteBleue('#example3');
        $('#example4').DataTable().destroy();
        afficheVisiteTechnique('#example4');
        $('#example5').DataTable().destroy();
        afficheTaxe('#example5');
        $('#example6').DataTable().destroy();
        afficheAccesPort('#example6');
        $('#example7').DataTable().destroy();
        afficheAttestation('#example7');
        $('#example8').DataTable().destroy();
        afficheLicence('#example8');

      },
            error:function(data){
            $(".chargementCarteGrise1").fadeOut();
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

function demandeSuppressionDocument(table,identifiant,nom_id){
 $(".table").val();
 $(".identifiant").val();
 $(".nom_id").val();
 $(".table").val(table);
 $(".identifiant").val(identifiant);
 $(".nom_id").val(nom_id);

  // alert("la table est: "+table+" et identifiant: "+identifiant);
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
        afficheAllCarteGrise('#example1');
        $('#example2').DataTable().destroy();
        afficheAllAssurance('#example2')
        $('#example3').DataTable().destroy();
        afficheCarteBleue('#example3');
        $('#example4').DataTable().destroy();
        afficheVisiteTechnique('#example4');
        $('#example5').DataTable().destroy();
        afficheTaxe('#example5');
        $('#example6').DataTable().destroy();
        afficheAccesPort('#example6');
        $('#example7').DataTable().destroy();
        afficheAttestation('#example7');
        $('#example8').DataTable().destroy();
        afficheLicence('#example8');
        
          
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

function afficheAllCarteGrise(idTable){
  $(".chargementCarteGrise").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_document/getAllCarteGrise",
      data:{},
      success: function(data){

        $(".contentCarteGrise").empty();
        $(".contentCarteGrise").append(data);
        ceerDatatable(idTable)
        $(".chargementCarteGrise").fadeOut();
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
function afficheAllAssurance(idTable){
  $(".chargementAssurance").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_document/getAllAssurance",
      data:{},
      success: function(data){

        $(".contentAssurance").empty();
        $(".contentAssurance").append(data);
        ceerDatatable(idTable)
        $(".chargementAssurance").fadeOut();
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

function afficheCarteBleue(idTable){
  $(".chargementCarteBleue").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_document/getAllCarteBleue",
      data:{},
      success: function(data){

        $(".contentCarteBleue").empty();
        $(".contentCarteBleue").append(data);
        ceerDatatable(idTable)
        $(".chargementCarteBleue").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementCarteBleue").fadeOut();
       }
       });
}
function afficheVisiteTechnique(idTable){
  $(".chargementVisiteTechnique").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_document/getAllVisiteTechnique",
      data:{},
      success: function(data){

        $(".contentVisiteTechnique").empty();
        $(".contentVisiteTechnique").append(data);
        ceerDatatable(idTable)
        $(".chargementVisiteTechnique").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementVisiteTechnique").fadeOut();
       }
       });
}
function afficheTaxe(idTable){
  $(".chargementTaxe").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_document/getAllTaxe",
      data:{},
      success: function(data){

        $(".contentTaxe").empty();
        $(".contentTaxe").append(data);
        ceerDatatable(idTable)
        $(".chargementTaxe").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementTaxe").fadeOut();
       }
       });
}
function afficheTaxe(idTable){
  $(".chargementTaxe").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_document/getAllTaxe",
      data:{},
      success: function(data){

        $(".contentTaxe").empty();
        $(".contentTaxe").append(data);
        ceerDatatable(idTable)
        $(".chargementTaxe").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementTaxe").fadeOut();
       }
       });
}

function afficheAccesPort(idTable){
  $(".chargementAccesPort").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_document/getAllAccesPort",
      data:{},
      success: function(data){

        $(".contentAccesPort").empty();
        $(".contentAccesPort").append(data);
        ceerDatatable(idTable)
        $(".chargementAccesPort").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementAccesPort").fadeOut();
       }
       });
}
function afficheLicence(idTable){
  $(".chargementLicence").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_document/getAllLicence",
      data:{},
      success: function(data){

        $(".contentLicence").empty();
        $(".contentLicence").append(data);
        ceerDatatable(idTable)
        $(".chargementLicence").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementLicence").fadeOut();
       }
       });
}
function afficheAttestation(idTable){
  $(".chargementAttestation").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_document/getAllAttestation",
      data:{},
      success: function(data){

        $(".contentAttestation").empty();
        $(".contentAttestation").append(data);
        ceerDatatable(idTable)
        $(".chargementAttestation").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementAttestation").fadeOut();
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


function recupDateExpiration(duree,unite,typeDocument,dateEffet){

var newDate = new Date(dateEffet);

if (unite == "an") {
  // alert("annee");
  // alert((newDate.getMonth()+1).toString().length);
  if (newDate.getDate() <10) {
    if ((newDate.getMonth()+1).toString().length > 1) {
    twoDigitMonth = ((newDate.getMonth().length+1)==1)? (newDate.getMonth()+1):(newDate.getMonth()+1);

annees = parseInt(newDate.getFullYear())+duree;
  $(".lieuCarteGrise").val(annees+"-"+twoDigitMonth+"-0"+newDate.getDate());

  }else{
    twoDigitMonth = ((newDate.getMonth().length+1)==1)? (newDate.getMonth()+1):"0"+(newDate.getMonth()+1);

    annees = parseInt(newDate.getFullYear())+duree;

  $(".lieuCarteGrise").val(annees+"-"+twoDigitMonth+"-0"+newDate.getDate());
  }

  }else{
    if ((newDate.getMonth()+1).toString().length > 1) {
    twoDigitMonth = ((newDate.getMonth().length+1)==1)? (newDate.getMonth()+1):(newDate.getMonth()+1);

annees = parseInt(newDate.getFullYear())+duree;
  $(".lieuCarteGrise").val(annees+"-"+twoDigitMonth+"-"+newDate.getDate());

  }else{
    twoDigitMonth = ((newDate.getMonth().length+1)==1)? (newDate.getMonth()+1):"0"+(newDate.getMonth()+1);

    annees = parseInt(newDate.getFullYear())+duree;

  $(".lieuCarteGrise").val(annees+"-"+twoDigitMonth+"-"+newDate.getDate());
  }
  }
  
  
}else{
  mois = parseInt(twoDigitMonth) + duree;
  if (newDate.getDate() <10) {
    if (mois >12) {
      resteMois = mois-12;
      annees = newDate.getFullYear()+1;
      $(".lieuCarteGrise").val(annees+"-0"+resteMois+"-0"+newDate.getDate());
    }else{
      chaineMois = mois;
      // alert(chaineMois.toString().length);
      if (chaineMois.toString().length > 1) {
        // alert("sans le 0");
        annees = newDate.getFullYear();
      $(".lieuCarteGrise").val(annees+"-"+mois+"-0"+newDate.getDate());  
      }else{
        // alert("avec 0");
      annees = newDate.getFullYear();
      $(".lieuCarteGrise").val(annees+"-0"+mois+"-0"+newDate.getDate()); 
      }
      // alert("le mois est:"+mois.length);     
    }
  }else{
    if (mois >12) {
      resteMois = mois-12;
      annees = newDate.getFullYear()+1;
      $(".lieuCarteGrise").val(annees+"-0"+resteMois+"-"+newDate.getDate());
    }else{
      chaineMois = mois;
      // alert(chaineMois.toString().length);
      if (chaineMois.toString().length > 1) {
        // alert("sans le 0");
        annees = newDate.getFullYear();
      $(".lieuCarteGrise").val(annees+"-"+mois+"-"+newDate.getDate());  
      }else{
        // alert("avec 0");
      annees = newDate.getFullYear();
      $(".lieuCarteGrise").val(annees+"-0"+mois+"-"+newDate.getDate()); 
      }
      // alert("le mois est:"+mois.length);     
    }
  }
  
}
}
function getDateExpirationDocument(){
dateEffet = $(".dateEffetCarteGrise").val();
  typeDocument = $(".type").val();

var newDate = new Date(dateEffet);
twoDigitMonth = ((newDate.getMonth().length+1)==1)? (newDate.getMonth()+1):"0"+(newDate.getMonth()+1);
  expiration = newDate.getDate()+"/"+twoDigitMonth+"/"+newDate.getFullYear();
  if (typeDocument == "carte_grise") {
  duree = 10; //duree en années
  unite = "an";
  recupDateExpiration(duree,unite,typeDocument,dateEffet);
  }else if (typeDocument == "assurance") {
    duree = 1; //duree en annees
    unite = "an";
  recupDateExpiration(duree,unite,typeDocument,dateEffet);
  }else if (typeDocument == "carte_bleue") {
    duree = 1; //duree en annees
    unite = "an";
    recupDateExpiration(duree,unite,typeDocument,dateEffet);
  }else if (typeDocument == "visite_technique") {
    duree = 6; //duree en mois
    unite = "mois";
  recupDateExpiration(duree,unite,typeDocument,dateEffet); 

    // alert(mois);
    
  }else if (typeDocument == "taxe_essieu") {
    duree = 6; //duree en mois
    unite = "mois";
  recupDateExpiration(duree,unite,typeDocument,dateEffet);
  }else if (typeDocument == "acces_port") {
     duree = 1; //duree en annees
     unite = "an";
  recupDateExpiration(duree,unite,typeDocument,dateEffet);
  }else if (typeDocument == "licence_transport") {
    duree = 3; //duree en mois
    unite = "mois";
  recupDateExpiration(duree,unite,typeDocument,dateEffet);
  }else if (typeDocument == "attestation_non_redevance") {
    duree = 3; //duree en mois
    unite = "mois";
  recupDateExpiration(duree,unite,typeDocument,dateEffet);
  }else{
    alert("erreur aucun document");
  }
}


// Nous allons procéder à la gestion des alertes
function alertExpirationCarteGrise(){

var newDate = new Date();

 //  twoDigitMonth = ((newDate.getMonth().length+1)==1)? (newDate.getMonth()+1):'0'+(newDate.getMonth()+1);
 //  annees = parseInt(newDate.getFullYear());
 // alert( annees+"-"+twoDigitMonth+"-"+newDate.getDate());
   $.ajax({
      type:"POST",
      url:base_url+"/admin_document/getExpirationCartegrise",
      data:{},
      success: function(data){
        alert(data);
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementAttestation").fadeOut();
       }
       });
}