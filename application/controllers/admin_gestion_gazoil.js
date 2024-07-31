
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

function addFactureGazoil(status){
	montant = $(".montant").val();
	date = $(".dateFacture").val();
	numero = $(".numero").val();
	id_gazoil = $(".id_gazoil").val();
  id_fournisseur = $(".id_fournisseur").val();
  id_facture = $(".id_prime").val();
	if (montant == "") {
	$(".montant").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
	}else if (date == "") {
	$(".dateFacture").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else if (id_gazoil == "" || id_gazoil == null) {
  $(".id_gazoil").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (numero == "") {
	$(".numero").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else{
    // alert(id_gazoil);
    $(".numero_facture").css("border","1px solid #ced4da");
  $(".id_gazoil").css("border","1px solid #ced4da");
	$(".montant").css("border","1px solid #ced4da");
	$(".dateFacture").css("border","1px solid #ced4da");
	$(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
	 $.ajax({
      type:"POST",
      url:base_url+"/admin_gestion_gazoil/addFactureGazoil",
      data:{"id_fournisseur1":id_fournisseur,"id_fournisseur":id_gazoil,"id_facture":id_facture,"status":status,"montant":montant,"numero":numero,"date":date},
      success: function(data){  

      	if ($.trim(data) == "Insertion parfaite de la facture") {
leSelectGazoilParFournisseur();
      	$('#example1').DataTable().destroy();
        afficheAllFactureGazoil('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
      	}else if ($.trim(data) == "Facture modifiée") {

      	$('#example1').DataTable().destroy();
        afficheAllFactureGazoil('#example1');
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
      url:base_url+"/admin_document/deleteDocument",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllFactureGazoil('#example1');
        
          
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
  }
  else{
  $(".montant").css("border","1px solid #ced4da");
  $(".id_gazoil").css("border","1px solid #ced4da");
  $(".dateFacture").css("border","1px solid #ced4da");
  $(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
   $.ajax({
      type:"POST",
      url:base_url+"/admin_gestion_gazoil/addReglement",
      data:{"id_fournisseur":id_gazoil,"id_facture":id_regl,"status":status,"montant":montant,"numero":numero,"date":date},
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
      url:base_url+"/admin_document/deleteDocument",
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
function infosFacture(id_facture,numero,date,montant){
 $(".montant").val(montant);
 $(".dateFacture").val(date);
 $(".numero").val(numero);
 $(".id_prime").val(id_facture);
 // $(".libelle").val(libelle);

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
