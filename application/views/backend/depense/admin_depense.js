function addGazoil(status){
  commentaire = $(".commentaire").val();
	numero = $(".numero").val();
	dateDepense = $(".dateCreation").val();
	litrage = $(".litrage").val();
	destination = $(".destination").val();
  destination2 = $(".destination2").val();
	prixUnitaire = $(".prixUnitaire").val();
	fournisseur = $(".fournisseur").val();
	codeCamion = $(".camion").val();
	operation = $(".operation").val();
	kilometrage = $(".kilometrage").val();
	id_gazoil = $(".id_gazoil").val();

	if (numero == "") {
$(".numero").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
	}else if (dateDepense == "") {
$(".dateCreation").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
	}else if (litrage == "") {
$(".litrage").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
	}else if (destination == "") {
$(".destination").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
	}else if (destination2 == "") {
$(".destination2").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
  }else if (prixUnitaire == "") {
$(".prixUnitaire").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
	}else if (codeCamion == "") {
$(".camion").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
  }else if (kilometrage == "") {
    $(".kilometrage").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
  }
  else{
$(".camion").css("border","1px solid #ced4da");
$(".numero").css("border","1px solid #ced4da");
$(".dateCreation").css("border","1px solid #ced4da");
$(".litrage").css("border","1px solid #ced4da");
$(".destination").css("border","1px solid #ced4da");
$(".destination2").css("border","1px solid #ced4da");
$(".prixUnitaire").css("border","1px solid #ced4da");
$(".kilometrage").css("border","1px solid #ced4da");
$(".chargementGazoil1").fadeIn();
 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addGazoil",
      data:{"commentaire":commentaire,"id_gazoil":id_gazoil,"status":status,"numero":numero,"dateDepense":dateDepense,"litrage":litrage,"destination":destination,"prixUnitaire":prixUnitaire,"id_fournisseur":fournisseur,"codeCamion":codeCamion,"kilometrage":kilometrage,"id_operation":operation},
      success: function(data){  

      	if ($.trim(data) == "Insertion parfaite de la dépense") {

      	$('#example1').DataTable().destroy();
        afficheAllGazoil('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementGazoil").fadeOut();
      	}else if ($.trim(data) == "Modification parfaite de la dépense") {

      	$('#example1').DataTable().destroy();
        afficheAllGazoil('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementGazoil1").fadeOut();
      	}else{
      	$(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: data
      }) 
      	}
$(".chargementGazoil1").fadeOut();
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

function afficheAllGazoil(idTable){
  $(".chargementGazoil").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllGazoil",
      data:{},
      success: function(data){

        $(".contentGazoil").empty();
        $(".contentGazoil").append(data);
        ceerDatatable(idTable)
        $(".chargementGazoil").fadeOut();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementGazoil").fadeOut();
       }
       });
}

function infoGazoil(numero,dateDepense,litrage,destination,prixUnitaire,kilometrage,id_gazoil,commentaire){
	$(".commentaire").val(commentaire);
  $(".numero").val(numero);
	$(".dateCreation").val(dateDepense);
	$(".litrage").val(litrage);
	$(".destination").val(destination);
	$(".prixUnitaire").val(prixUnitaire);
	$(".kilometrage").val(kilometrage);
	$(".id_gazoil").val(id_gazoil);

	$(".btnAdd").fadeOut();
	$(".btnModif").fadeIn();
	$(".btnAnnuler").fadeIn();
}

function annulerSuppressionGazoil(){
	$(".btnAdd").fadeIn();
	$(".btnModif").fadeOut();
	$(".btnAnnuler").fadeOut();
}

function confirmSuppressionGazoil(){
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
        afficheAllGazoil('#example1');
        
          
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


function addPrime(status){
	montant = $(".montant").val();
	libelle = $(".libelle").val();
	date = $(".datePrime").val();
	codeCamion = $(".camion").val();
	id_operation = $(".operation").val();
	id_prime = $(".id_prime").val();

	if (montant == "") {
	$(".montant").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
	}else if (date == "") {
	$(".datePrime").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else if (libelle == "") {
	$(".libelle").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else{
	$(".montant").css("border","1px solid #ced4da");
	$(".libelle").css("border","1px solid #ced4da");
	$(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
	 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addPrime",
      data:{"id_prime":id_prime,"status":status,"montant":montant,"libelle":libelle,"date":date,"id_operation":id_operation,"codeCamion":codeCamion},
      success: function(data){  

      	if ($.trim(data) == "Enregistrement de la prime réussi") {

      	$('#example1').DataTable().destroy();
        afficheAllPrime('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
      	}else if ($.trim(data) == "Modification de la prime réussi") {

      	$('#example1').DataTable().destroy();
        afficheAllPrime('#example1');
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

function afficheAllPrime(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllPrime",
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
        afficheAllPrime('#example1');
        
          
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

function infoPrime(montant,libelle,date,codeCamion,id_operation,id_prime){
	$(".montant").val(montant);
	$(".libelle").val(libelle);
	$(".datePrime").val(date);
	$(".camion").val(codeCamion);
	$(".operation").val(id_operation);
	$(".id_prime").val(id_prime);

	$(".btnAdd").fadeOut();
	$(".btnAnnuler").fadeIn();
	$(".btnModif").fadeIn();
}



function addFraisRoute(status){
	montant = $(".montant").val();
	distance = $(".distance").val();
	date = $(".datePrime").val();
	codeCamion = $(".camion").val();
	id_operation = $(".operation").val();
	id_frais_route = $(".id_prime").val();

	if (montant == "") {
	$(".montant").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
	}else if (date == "") {
	$(".datePrime").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else if (distance == "") {
	$(".libelle").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else{
	$(".montant").css("border","1px solid #ced4da");
	$(".libelle").css("border","1px solid #ced4da");
	$(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
	 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addFraisRoute",
      data:{"id_frais_route":id_frais_route,"status":status,"montant":montant,"distance":distance,"date":date,"id_operation":id_operation,"codeCamion":codeCamion},
      success: function(data){  

      	if ($.trim(data) == "Frais de route enregistré") {

      	$('#example1').DataTable().destroy();
        afficheAllFraisRoute('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
      	}else if ($.trim(data) == "Frais de route modifié") {

      	$('#example1').DataTable().destroy();
        afficheAllFraisRoute('#example1');
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

function afficheAllFraisRoute(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllFraisRoute",
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

function confirmSuppressionFraisRoute(){
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
        afficheAllFraisRoute('#example1');
        
          
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

function infoFraisRoute(montant,libelle,date,codeCamion,id_operation,id_prime){
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





function addFraisDivers(status){
  commentaire = $(".commentaire").val();
	montant = $(".montant").val();
	distance ="d";
	date = $(".datePrime").val();
	codeCamion = $(".camion").val();
	id_operation = $(".operation").val();
	id_frais_route = $(".id_prime").val();

	if (montant == "") {
	$(".montant").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
	}else if (date == "") {
	$(".datePrime").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else if (distance == "") {
	$(".libelle").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else{
	$(".montant").css("border","1px solid #ced4da");
	$(".libelle").css("border","1px solid #ced4da");
	$(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
	 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addFraisDivers",
      data:{"commentaire":commentaire,"id_frais_divers":id_frais_route,"status":status,"montant":montant,"distance":distance,"date":date,"id_operation":id_operation,"codeCamion":codeCamion},
      success: function(data){  

      	if ($.trim(data) == "Frais divers enregistré") {

      	$('#example1').DataTable().destroy();
        afficheAllFraisDivers('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
      	}else if ($.trim(data) == "Frais divers modifié") {

      	$('#example1').DataTable().destroy();
        afficheAllFraisDivers('#example1');
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

function afficheAllFraisDivers(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllFraisDivers",
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

function confirmSuppressionFraisDivers(){
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
        afficheAllFraisDivers('#example1');
        
          
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








function addFraisRoute(status){
  commentaire = $(".commentaire").val();
	montant = $(".montant").val();
	distance = $(".distance").val();
	date = $(".datePrime").val();
	codeCamion = $(".camion").val();
	id_operation = $(".operation").val();
	id_frais_route = $(".id_prime").val();

	if (montant == "") {
	$(".montant").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
	}else if (date == "") {
	$(".datePrime").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else if (distance == "") {
	$(".libelle").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else{
	$(".montant").css("border","1px solid #ced4da");
	$(".libelle").css("border","1px solid #ced4da");
	$(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
	 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addFraisRoute",
      data:{"commentaire":commentaire,"id_frais_route":id_frais_route,"status":status,"montant":montant,"distance":distance,"date":date,"id_operation":id_operation,"codeCamion":codeCamion},
      success: function(data){  

      	if ($.trim(data) == "Frais de route enregistré") {

      	$('#example1').DataTable().destroy();
        afficheAllFraisRoute('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
      	}else if ($.trim(data) == "Frais de route modifié") {

      	$('#example1').DataTable().destroy();
        afficheAllFraisRoute('#example1');
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

function afficheAllFraisRoute(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllFraisRoute",
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

function confirmSuppressionFraisRoute(){
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
        afficheAllFraisRoute('#example1');
        
          
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

function infoFraisRoute(montant,libelle,date,codeCamion,id_operation,id_prime,commentaire){
  $(".commentaire").val(commentaire);
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





function addVidange(status){
	huile = $(".huile").val();
  qtite = $(".qtite").val();
	commentaire = $(".commentaire").val();
	date = $(".datePrime").val();
	codeCamion = $(".camion").val();
	id_operation = $(".operation").val();
	id_frais_route = $(".id_prime").val();

	if (huile == "") {
	$(".huile").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
	}else if (date == "") {
	$(".datePrime").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else if (commentaire == "") {
	$(".commentaire").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else if (qtite == "") {
  $(".qtite").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else{
	$(".huile").css("border","1px solid #ced4da");
  $(".qtite").css("border","1px solid #ced4da");
	$(".commentaire").css("border","1px solid #ced4da");
	$(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
	 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addVidange",
      data:{"id_frais_divers":id_frais_route,"qtite":qtite,"status":status,"huile":huile,"commentaire":commentaire,"date":date,"id_operation":id_operation,"codeCamion":codeCamion},
      success: function(data){  

      	if ($.trim(data) == "Vidange enregistrée") {

      	$('#example1').DataTable().destroy();
        afficheAllVidange('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
      	}else if ($.trim(data) == "Vidange modifiée") {

      	$('#example1').DataTable().destroy();
        afficheAllVidange('#example1');
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

function afficheAllVidange(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllVidange",
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

function confirmSuppressionVidange(){
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
        afficheAllVidange('#example1');
        
          
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

function infoVidange(montant,libelle,date,codeCamion,id_operation,id_prime){
	// $(".huile").val(montant);
	$(".commentaire").val(libelle);
	$(".datePrime").val(date);
	// $(".camion").val(codeCamion);
	// $(".operation").val(id_operation);
	$(".id_prime").val(id_prime);

	$(".btnAdd").fadeOut();
	$(".btnAnnuler").fadeIn();
	$(".btnModif").fadeIn();
}


// ce qui suit est la code des pieces de rechange

function getPrixTotalPourPieceRechange(){
  PU = $(".PU").val();
  qtite = $(".qtite").val();

  PU = PU.replace(/\s/g,'');

  PU = parseInt(PU);
 pt = PU*parseInt(qtite);
 formatMillierPourSelection(''+pt+'','PT');
}

function addPieceRechange(status){
  origine = $(".origine").val();
  pu = $(".PU").val();
	article = $(".article").val();
	commentaire = $(".commentaire").val();
	date = $(".datePrime").val();
	codeCamion = $(".camion").val();
  qtite = $(".qtite").val();
	id_operation = $(".operation").val();
	id_frais_route = $(".id_prime").val();
  id_fournisseur = $(".id_fournisseur").val();

	if (article == "") {
	$(".article").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
	}else if (date == "") {
	$(".datePrime").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else if (qtite == "") {
  $(".qtite").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (commentaire == "") {
	$(".commentaire").css("border","red 2px solid");
	toastr.error("Veuillez remplir tous les Champs");
	}else if (id_operation == "") {
  $(".operation").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (id_fournisseur == "") {
  $(".id_fournisseur").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (pu== "") {
  $(".PU").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else{
    $(".PU").css("border","1px solid #ced4da");
    $(".id_fournisseur").css("border","1px solid #ced4da");
    $(".operation").css("border","1px solid #ced4da");
    $(".qtite").css("border","1px solid #ced4da");
	$(".article").css("border","1px solid #ced4da");
	$(".commentaire").css("border","1px solid #ced4da");
	$(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
	 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addPieceRechange",
      data:{"origine":origine,"pu":pu,"id_fournisseur":id_fournisseur,"id_frais_divers":id_frais_route,"qtite":qtite,"status":status,"article":article,"commentaire":commentaire,"date":date,"id_operation":id_operation,"codeCamion":codeCamion},
      success: function(data){  

      	if ($.trim(data) == "Pièce de rechange ajoutée") {

      	$('#example1').DataTable().destroy();
        afficheAllPieceRechange('#example1');
      		$(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
      	}else if ($.trim(data) == "Pièce de rechange modifiée") {

      	$('#example1').DataTable().destroy();
        afficheAllPieceRechange('#example1');
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

function afficheAllPieceRechange(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllPieceRechange",
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

function confirmSuppressionPieceRechange(){
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
        afficheAllPieceRechange('#example1');
        
          
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
          
function infoPieceRechange(codeCamion,id_article,origine,qtite,id_operation,date,pu,commentaire,id_rechange){
	formatMillierPourSelection(pu,'PU');
  $(".qtite").val(qtite);

	$(".commentaire").val(commentaire);
	$(".datePrime").val(date);
	// $(".camion").val(codeCamion);
	// $(".operation").val(id_operation);
	$(".id_prime").val(id_rechange);

	$(".btnAdd").fadeOut();
	$(".btnAnnuler").fadeIn();
	$(".btnModif").fadeIn();
}

function getMontantTotalGazoil(){
  pu = $(".prixUnitaire").val();
  quantite = $(".litrage").val();

  if (quantite == 0 || quantite == "") {
$(".PT").val(0);
  }else if (pu == 0 || pu == "") {
    $(".PT").val(0);
  }else{  
    // $(".PT").val(+" FCFA");'
        formatMillierPourSelection(''+parseInt(pu)*parseInt(quantite)+'','PT');
  }
}



function addVidangeHydrolique(status){
  qtite = $(".qtite").val();
  huile = $(".huile").val();
  commentaire = $(".commentaire").val();
  date = $(".datePrime").val();
  codeCamion = $(".camion").val();
  id_operation = $(".operation").val();
  id_frais_route = $(".id_prime").val();

  if (huile == "") {
  $(".huile").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
  }else if (date == "") {
  $(".datePrime").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (commentaire == "") {
  $(".commentaire").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (qtite == "") {
  $(".qtite").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else{
    $(".qtite").css("border","1px solid #ced4da");
  $(".huile").css("border","1px solid #ced4da");
  $(".commentaire").css("border","1px solid #ced4da");
  $(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addVidangeHydrolique",
      data:{"id_frais_divers":id_frais_route,"qtite":qtite,"status":status,"huile":huile,"commentaire":commentaire,"date":date,"id_operation":id_operation,"codeCamion":codeCamion},
      success: function(data){  

        if ($.trim(data) == "Vidange enregistrée") {

        $('#example1').DataTable().destroy();
        afficheAllVidangeHydrolique('#example1');
          $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
        }else if ($.trim(data) == "Vidange modifiée") {

        $('#example1').DataTable().destroy();
        afficheAllVidangeHydrolique('#example1');
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

function afficheAllVidangeHydrolique(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllVidangeHydrolique",
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


function addVidangeBoite(status){
  qtite = $(".qtite").val();
  huile = $(".huile").val();
  commentaire = $(".commentaire").val();
  date = $(".datePrime").val();
  codeCamion = $(".camion").val();
  id_operation = $(".operation").val();
  id_frais_route = $(".id_prime").val();

  if (huile == "") {
  $(".huile").css("border","red 2px solid");
toastr.error("Veuillez remplir tous les Champs");
  }else if (date == "") {
  $(".datePrime").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (commentaire == "") {
  $(".commentaire").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else if (qtite == "") {
  $(".qtite").css("border","red 2px solid");
  toastr.error("Veuillez remplir tous les Champs");
  }else{
    $(".qtite").css("border","1px solid #ced4da");
  $(".huile").css("border","1px solid #ced4da");
  $(".commentaire").css("border","1px solid #ced4da");
  $(".datePrime").css("border","1px solid #ced4da");
$(".chargementPrime1").fadeIn();
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addVidangeBoite",
      data:{"id_frais_divers":id_frais_route,"qtite":qtite,"status":status,"huile":huile,"commentaire":commentaire,"date":date,"id_operation":id_operation,"codeCamion":codeCamion},
      success: function(data){  

        if ($.trim(data) == "Vidange enregistrée") {

        $('#example1').DataTable().destroy();
        afficheAllVidangeBoite('#example1');
          $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
$(".chargementPrime1").fadeOut();
        }else if ($.trim(data) == "Vidange modifiée") {

        $('#example1').DataTable().destroy();
        afficheAllVidangeBoite('#example1');
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

function afficheAllVidangeBoite(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllVidangeBoite",
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
function confirmSuppressionVidangeBoite(){
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
        afficheAllVidangeBoite('#example1');
        
          
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

function confirmSuppressionVidangeHydrolique(){
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
        afficheAllVidangeHydrolique('#example1');
        
          
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


// code du type d'huile

function afficheAllTypeHuile(idTable){
  $(".chargementClient").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllTypeHuile",
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

function addTypeHuile(status){
  // alert(status);
  huile = $(".huile").val();
  PU = $(".PU").val();
  type_huile = $(".type_huile").val();
  id_client = $(".id_client").val();
  if (huile == "") {
    $(".huile").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (PU == "") {
    $(".PU").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else{
    $(".huile").css("border","1px solid #ced4da");
    $(".PU").css("border","1px solid #ced4da");
$(".chargementCarteGrise1").fadeIn();
     $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/addTypeHuile",
      data:{"status":status,"id_client":id_client,"huile":huile,"PU":PU,"type_huile":type_huile},
       success: function(data){
   if ($.trim(data) == "Insertion parfaite de l'huile") {
    $(".huile").val("");
  $(".PU").val("");
    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllTypeHuile('#example1');
        $(".chargementCarteGrise1").fadeOut();
      }else if ($.trim(data) == "Modification parfaite du l'huile") {
        $(".huile").val("");
  $(".PU").val("");
    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllTypeHuile('#example1');
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
function confirmSuppressionTypeHuile(){
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
        afficheAllTypeHuile('#example1');
        
          
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

function infosTypeHuile(id_client,nom,adresse,telephone){
  $(".huile").val(adresse);

  $(".PU").val(telephone);
  $(".id_client").val(id_client);
  $(".btnAnnulerModif").fadeIn();
  $(".btnModifClient").fadeIn();
  $(".btnAddClient").fadeOut();
}

function annulerModifTypeHuile(){
$(".btnAnnulerModif").fadeOut();
  $(".btnModifClient").fadeOut();
  $(".btnAddClient").fadeIn();
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

function getFournisseurMira(id_fournisseur){
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getFournisseurMira",
      data:{'id_fournisseur':id_fournisseur},
      success: function(data){
       $(".id_fournisseur").empty();
       $(".id_fournisseur").append(data);
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
function getAllFournisseurMira(){
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getAllFournisseurMira",
      data:{},
      success: function(data){
       $(".id_fournisseur").empty();
       $(".id_fournisseur").append(data);
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
// getFournisseurMira(22);

function getPrixUnitaireArticle(){
  id_article = $(".article").val();
  origine = $(".origine").val();
  if (origine == "externe") {
    $(".PU").removeAttr("disabled","false");
    $(".PU").val("");
    $(".id_fournisseur").removeAttr("disabled","true");
    getAllFournisseurMira();
  }else{
    id_fournisseur = 22;
    $(".id_fournisseur").attr("disabled","true");
    getFournisseurMira(id_fournisseur)
    $(".PU").attr("disabled","true");
    
   $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getPrixUnitaireArticle",
      data:{'id_article':id_article,"origine":origine},
      success: function(data){
        $(".PU").val("");
        formatMillierPourSelection(data,'PU');
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

function getDistanceParCodeCamion(){
  code_camion = $(".code_camion").val();
 
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getDistanceParCodeCamion",
      data:{"code_camion":code_camion},
      success: function(data){
        $(".destination").empty();
        // alert(data);
        $(".destination").append(data);
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

function getPrixUnitaireParFournisseur(){
  id_fournisseur = $(".fournisseur").val();
 
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getPrixUnitaireParFournisseur",
      data:{"id_fournisseur":id_fournisseur},
      success: function(data){
        $(".prixUnitaire").val("");
        // alert(data);
        classe = 'prixUnitaire';
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
     getMontantTotalGazoil();
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
function getLittrage(){
  destination = $(".destination").val();
 
  $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getLittrage",
      data:{"destination":destination},
      success: function(data){
        $(".litrage").val("");
        // alert(data);
        $(".litrage").val(data);
        getMontantTotalGazoil();
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
        $(".destination3").empty();
        $(".destination3").append($.trim(data));
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
function getPrixUnitaireHuile(){
   id_type= $(".id_type").val();
if (id_type == "" || id_type == " " || id_type == undefined) {
 // alert(id_type);
}else{

 $.ajax({
      type:"POST",
      url:base_url+"/admin_depense/getPrixUnitaireHuile",
      data:{"id_type":id_type},
      success: function(data){  
        $(".PU").val();
        formatMillierPourSelection(data,'PU');
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
}

