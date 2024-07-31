
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

function getFactureParDate(){
    date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  id_fournisseur1 = $(".id_fournisseur1").val();
  
  if (date_debut !="" && date_fin !="" && id_fournisseur1 !="") {
    $('#example1').DataTable().destroy();
  afficheAllFacture1('#example1');
  }
  
}

function afficheAllFacture1(idTable){
	
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
 id_fournisseur1 = $(".id_fournisseur1").val();
	
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_gestion_gazoil/getAllFactureGazoil",
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

function addFactureGazoil(status){
	montant = $(".montant").val();
	date = $(".dateFacture").val();
	numero = $(".numero").val();
	type = $(".type").val();

  id_fournisseur = $(".id_fournisseur").val();
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
	}else if (type == "") {
	$(".type").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else{
    // alert(id_gazoil);
    $(".numero_facture").css("border","1px solid #ced4da");

	$(".montant").css("border","1px solid #ced4da");
	$(".dateFacture").css("border","1px solid #ced4da");
	$(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
	 $.ajax({
      type:"POST",
      url:base_url+"/admin_gestion_gazoil/addFactureGazoil",
      data:{"id_fournisseur":id_fournisseur,"id_facture":id_facture,"status":status,"montant":montant,"numero":numero,"date":date,"type":type},
      success: function(data){  

      	if ($.trim(data) == "Insertion parfaite de la facture") {

      	$('#example1').DataTable().destroy();
        afficheAllFacture1('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
      	}else if ($.trim(data) == "Facture modifiée") {

      	$('#example1').DataTable().destroy();
        afficheAllFacture1('#example1');
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

function afficheAllFactureGazoil(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_gestion_gazoil/getAllFacture",
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
      url:base_url+"/admin_gestion_gazoil/deleteFactureFournisseurGasoil",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllFacture1('#example1');
        
          
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

function infoFraisRoute(montant,date,codeCamion,id_operation,id_prime){
	$(".montant").val(montant);
	$(".distance").val(libelle);
	$(".datePrime").val(date);
	$(".camion").val(codeCamion);
	$(".operation").val(id_operation);
	$(".id_prime").val(id_prime);

	$(".btnAdd").fadeOut();
	$(".btnAnnuler").fadeIn();
	$(".btnModif").fadeIn();
}

function getMontant(){
  $(".chargementPrime1").fadeIn();
 id_gazoil = $(".id_gazoil").val();
   $.ajax({
      type:"POST",
      url:base_url+"/Admin_gestion_gazoil/getMontantGazoil",
      data:{"id_gazoil":id_gazoil},
      success: function(data){ 
        $(".montant").val(data);
        formatMillierPourSelection(data,'montant');
        $(".chargementPrime1").fadeOut();
       },
       error: function(data){
        alert(data.responseText);
        $(".chargementPrime1").fadeOut();
       }
    });

}

function leSelectGazoilParFournisseur(){
  $(".chargementPrime1").fadeIn();
  $(".id_gazoil").empty();
  $(".id_gazoil").append("<option value='0'></option>");
 id_gazoil = $(".id_fournisseur").val();
   $.ajax({
      type:"POST",
      url:base_url+"/Admin_gestion_gazoil/leSelectGazoilParFournisseur",
      data:{"id_fournisseur":id_gazoil},
      success: function(data){ 
        $(".id_gazoil").append(data);
        // alert(data);
        $(".chargementPrime1").fadeOut();
       },
       error: function(data){
        alert(data.responseText);
        $(".chargementPrime1").fadeOut();
       }
    });

}

function addReglement(status){
  montant = $(".montant").val();
  date = $(".dateFacture").val();
  numero = $(".numero").val();
  id_gazoil = $(".id_gazoil").val();
  type = $(".type").val();
  id_regl= $(".id_prime").val();

  if (montant == "") {
  $(".montant").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
  }else if (date == "") {
  $(".dateFacture").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (numero == "") {
  $(".numero").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (id_gazoil== "") {
  $(".id_gazoil").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (type== "") {
  $(".type").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }
  else{
  $(".montant").css("border","1px solid #ced4da");
  $(".id_gazoil").css("border","1px solid #ced4da");
  $(".dateFacture").css("border","1px solid #ced4da");
  $(".datePrime").css("border","1px solid #ced4da");
  $(".type").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
   $.ajax({
      type:"POST",
      url:base_url+"/admin_gestion_gazoil/addReglement",
      data:{"id_fournisseur":id_gazoil,"id_facture":id_regl,"status":status,"montant":montant,"numero":numero,"date":date,"type":type},
      success: function(data){  

        if ($.trim(data) == "Règlement de la facture effectué") {

        $('#example1').DataTable().destroy();
        afficheAllReglement('#example1');
          $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
        }else if ($.trim(data) == "Règlement modifié") {

        $('#example1').DataTable().destroy();
        afficheAllReglement('#example1');
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

function afficheAllReglement(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_gestion_gazoil/getAllReglement",
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

function confirmSuppressionReglement(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_gestion_gazoil/deleteReglementFournisseurGasoil",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllReglement('#example1');
        
          
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
function infosFacture(id_facture,fournisseur,numero,date,montant,type){
 $(".montant").val(montant);
 $(".dateFacture").val(date);
 $(".numero").val(numero);
 $(".id_prime").val(id_facture);
 $(".type").val(type);
  $(".id_fournisseur").val(fournisseur);

  $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAdd").fadeOut();
}

function infosReglement(id_facture,fournisseur,numero,date,montant,type){
 $(".montant").val(montant);
 $(".dateFacture").val(date);
 $(".numero").val(numero);
 $(".id_prime").val(id_facture);
  $(".type").val(type);
  $(".id_gazoil").val(fournisseur);

  $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAdd").fadeOut();
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
function afficheAllFActurePourBalance(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_gestion_gazoil/getAllFacturePourBalance",
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
      url:base_url+"/admin_gestion_gazoil/selectAllTotalFacturePourBalanceFournisseur",
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
      url:base_url+"/admin_gestion_gazoil/selectAllTotalReglementPourBalanceFournisseur",
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
      url:base_url+"/admin_gestion_gazoil/soldeGazoilFournisseur",
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

function soldeInitialFournisseur(id_fournisseur){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_gestion_gazoil/soldeInitialFournisseur",
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

function dateInitialFournisseur(id_fournisseur){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_gestion_gazoil/dateInitialFournisseur",
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
function getBalance(){
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  id_fournisseur = $(".id_fournisseur").val();
  soldeInitialFournisseur(id_fournisseur);
  dateInitialFournisseur(id_fournisseur);
  if (id_fournisseur == "" && date_debut == "" && date_fin == "") {

  }else{

    soldeCaisseFournisseur(id_fournisseur,date_debut,date_fin);
  selectAllTotalFacturePourBalanceFournisseur(id_fournisseur,date_debut,date_fin);
selectAllTotalReglementPourBalanceFournisseur(id_fournisseur,date_debut,date_fin);
    $('#example2').DataTable().destroy();
  afficheAllFActurePourBalance('#example2',id_fournisseur,date_debut,date_fin);

  $('#example1').DataTable().destroy();
  afficheAllReglementPourBalance('#example1',id_fournisseur,date_debut,date_fin);
  
  }
}
// le code qui suit est celui de la balance de facture 
function soldeCaisseFacture(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_gestion_gazoil/soldeGazoilFacture",
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
function afficheAllFActurePourBalanceFacture(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_gestion_gazoil/getAllFacturePourBalanceFacture",
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
function selectAllTotalFacturePourBalanceFacture(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_gestion_gazoil/selectAllTotalFacturePourBalanceFacture",
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

  function getBalanceFacture(){
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  id_fournisseur = $(".id_fournisseur").val();
  soldeInitialFournisseur(id_fournisseur);
  dateInitialFournisseur(id_fournisseur);
  if (id_fournisseur == "" && date_debut == "" && date_fin == "") {

  }else{

  soldeCaisseFacture(id_fournisseur,date_debut,date_fin);
  selectAllTotalFacturePourBalanceFacture(id_fournisseur,date_debut,date_fin);
  selectAllTotalReglementPourBalanceFournisseur(id_fournisseur,date_debut,date_fin);
    $('#example2').DataTable().destroy();
  afficheAllFActurePourBalanceFacture('#example2',id_fournisseur,date_debut,date_fin);

  $('#example1').DataTable().destroy();
  afficheAllReglementPourBalance('#example1',id_fournisseur,date_debut,date_fin);
  
  }
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
      url:base_url+"/admin_gestion_gazoil/verifiDateInitialClient",
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


function getDateInitialClient(id_fournisseur){
  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_gestion_gazoil/getDateInitialClient",
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
      url:base_url+"/admin_gestion_gazoil/getSoldeInitialClient",
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
      url:base_url+"/admin_gestion_gazoil/getNomClient",
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
      url:base_url+"/admin_gestion_gazoil/getVilleClient",
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
      url:base_url+"/admin_gestion_gazoil/getAdresseClient",
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
      url:base_url+"/admin_gestion_gazoil/getTelephoneClient",
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
      url:base_url+"/admin_gestion_gazoil/soldeCaisseClient2",
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

function selectAllTotalAccuseRetraitPourBalanceClient(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_gestion_gazoil/getAllTotalAccuseRetraitPourBalance2",
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
      url:base_url+"/admin_gestion_gazoil/getAllTotalAccuseReglementPourBalance2",
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

function getBalanceImprimableClient2(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_gestion_gazoil/getBalanceImprimableClient",
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
      url:base_url+"/admin_gestion_gazoil/repportNouveau",
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
      url:base_url+"/admin_gestion_gazoil/repportNouveauDebit",
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
      url:base_url+"/admin_gestion_gazoil/repportNouveauCredit",
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
      url:base_url+"/admin_gestion_gazoil/getCreditPourBalanceImpCLient",
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
      url:base_url+"/admin_gestion_gazoil/getDebitPourBalanceImpCLient",
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
      url:base_url+"/admin_gestion_gazoil/getAllTotalAccuseRetraitPourBalance2",
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
      url:base_url+"/admin_gestion_gazoil/getAllTotalAccuseReglementPourBalance2",
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





