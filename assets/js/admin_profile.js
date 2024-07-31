
function addPrivilege(table,ajout,suppression,modification,identifiant,password){

    $.ajax({
      type:"POST",
      url:base_url+"/admin_profile/addPrivilege",
      data:{"ajout":ajout,"modification":modification,"suppression":suppression,'modification':modification,'table':table,'identifiant':identifiant,'password':password},
      success: function(data){
       toastr.success(data);
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

function sendPrivilege(identifiant,password,identifiant){

  i = 0;
  do{
    if ($(".gestion"+i).prop('checked') == true) {
      table = $(".gestion"+i).attr('id');
      // alert(table);

      if ($(".ajout"+i).prop('checked') == true){
        ajout = 'true';
        // alert("non");
      }else{
        // alert("non");
        ajout = 'false';
      }

      if ($(".modification"+i).prop('checked') == true){
        modification = 'true';
      }else{
        // alert("non");
        modification = 'false';
      }

      if ($(".suppression"+i).prop('checked') == true){
        suppression = 'true';
      }else{
        // alert("non1");
        suppression = 'false';
      }
      
      addPrivilege(table,ajout,suppression,modification,identifiant,password);
    }
i++;

  }while(i<=19)
   $(".chargementPrime").fadeOut();
}

function addUser(status){
	// alert(status);
	identifiant = $(".identifiant").val();
	type = $(".type").val();
	password= $(".password").val();
  confirmPassword = $(".confirmPassword").val();
  commentaire = $(".commentaire").val();
  id_profil =  $(".id_client").val();


if (status == 'insert') {
    if (type == "") {
    $(".type").css("border","red 2px solid");
    toastr.error("Veuillez remplir le type de compte");
  }else if (identifiant == "") {
    $(".identifiant").css("border","red 2px solid");
    toastr.error("Veuillez entrer l'adresse");
  }else if (password == "") {
    $(".password").css("border","red 2px solid");
    toastr.error("Veuillez entrer un mot de passe");
  }else if (confirmPassword == "") {
    $(".confirmPassword").css("border","red 2px solid");
    toastr.error("Veuillez confirmer le mot de passe");
  }else if (confirmPassword != password) {
    $(".confirmPassword").css("border","red 2px solid");
    toastr.error("Les mot de passe doivent être identiques");
  }else{
    $(".identifiant").css("border","1px solid #ced4da");
    $(".type").css("border","1px solid #ced4da");
    $(".confirmPassword").css("border","1px solid #ced4da");
    $(".password").css("border","1px solid #ced4da");
$(".chargementCarteGrise1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_profile/addUser",
      data:{"identifiant":identifiant,"type":type,"password":password,"status":status,"commentaire":commentaire},
       success: function(data){
      
   if ($.trim(data) == "Insertion parfaite de l'utilisateur") {
    sendPrivilege(identifiant,password,identifiant);
    // toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllProfile('#example1');
        $(".chargementCarteGrise1").fadeOut();
  $(".chargementCarteGrise1").fadeOut();
      }else if ($.trim(data) == "Modification parfaite de l'utilisateur") {

    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllProfile('#example1');
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
       });}
}else if (status == 'update'){
    
$(".chargementCarteGrise1").fadeIn();
  i = 0;
  do{
    if ($(".gestion"+i).prop('checked') == true) {
      table = $(".gestion"+i).attr('id');
      // alert(table);
      if ($(".ajout"+i).prop('checked') == true){
        ajout = 'true';
        // alert("non");
      }else{
        // alert("non");
        ajout = 'false';
      }

      if ($(".modification"+i).prop('checked') == true){
        modification = 'true';
      }else{
        // alert("non");
        modification = 'false';
      }

      if ($(".suppression"+i).prop('checked') == true){
        suppression = 'true';
      }else{
        // alert("non1");
        suppression = 'false';
      }
      
      $.ajax({
      type:"POST",
      url:base_url+"/admin_profile/updatePrivilege",
      data:{"ajout":ajout,"id_profil":id_profil,"modification":modification,"suppression":suppression,'modification':modification,'table':table,'identifiant':identifiant,'password':password},
      success: function(data){
       toastr.success(data);
       $(".chargementCarteGrise").fadeOut();
          $(".chargementCarteGrise1").fadeOut();
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
i++;

  }while(i <=20)
}else{

    if (type == "") {
    $(".type").css("border","red 2px solid");
    toastr.error("Veuillez remplir le type de compte");
  }else if (identifiant == "") {
    $(".identifiant").css("border","red 2px solid");
    toastr.error("Veuillez entrer l'adresse");
  }else if (password == "") {
    $(".password").css("border","red 2px solid");
    toastr.error("Veuillez entrer un mot de passe");
  }else if (confirmPassword == "") {
    $(".confirmPassword").css("border","red 2px solid");
    toastr.error("Veuillez confirmer le mot de passe");
  }else if (confirmPassword != password) {
    $(".confirmPassword").css("border","red 2px solid");
    toastr.error("Les mot de passe doivent être identiques");
  }else{
    $(".identifiant").css("border","1px solid #ced4da");
    $(".type").css("border","1px solid #ced4da");
    $(".confirmPassword").css("border","1px solid #ced4da");
    $(".password").css("border","1px solid #ced4da");
    $.ajax({
      type:"POST",
      url:base_url+"/admin_profile/updateProfile",
      data:{"identifiant":identifiant,"type":type,"password":password,"status":status,"commentaire":commentaire},
      success: function(data){
       toastr.success(data);
       $(".chargementCarteGrise").fadeOut();
          $(".chargementCarteGrise1").fadeOut();
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
}


function confirmSuppressionProfile(){
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
        afficheAllProfile('#example1');
        
          
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

function afficheAllProfile(idTable){
  $(".chargementClient").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_profile/getAllProfile",
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

function infosProfil(id_profil,identifiant,password,type,commentaire){
  $(".chargementCarteGrise1").fadeIn();


   $(".identifiant").val(identifiant);
   $(".type").val(type);
   $(".password").val();
   $(".confirmPassword").val();
   $(".commentaire").val(commentaire);

    $(".btnAnnulerModif").fadeIn();
  $(".btnModifClient").fadeIn();
  $(".btnAddClient").fadeOut();
  $(".id_client").val(id_profil);
  $.ajax({
      type:"POST",
      url:base_url+"/admin_profile/formModifPrivilege",
      data:{"id_profil":id_profil},
      success: function(data){

        $(".contentPrivilege").empty();
        $(".contentPrivilege").append(data);
        $(".chargementCarteGrise1").fadeOut();
        // formAddRemorque();
      },
       error:function(data){
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur '+data.responseText
      })  
          $(".chargementCarteGrise1").fadeOut();
       }
       });
}

function modifProfile(){
  $(".chargementCarteGrise1").fadeIn();
  identifiant = $(".identifiant").val();
  password= $(".password").val();
  confirmPassword = $(".confirmPassword").val();
  id_profil = $(".id_client").val();
  if (identifiant == "") {
    $(".identifiant").css("border","red 2px solid");
    toastr.error("Veuillez entrer l'adresse");
  }else if (confirmPassword != password) {
    $(".confirmPassword").css("border","red 2px solid");
    toastr.error("Les mot de passe doivent être identiques");
  }else if (password == "") {
    $(".password").css("border","red 2px solid");
    toastr.error("Veuillez entrer un mot de passe");
  }else if (confirmPassword == "") {
    $(".confirmPassword").css("border","red 2px solid");
    toastr.error("Veuillez confirmer le mot de passe");
  }else{

     $(".identifiant").css("border","1px solid #ced4da");

    $(".confirmPassword").css("border","1px solid #ced4da");
    $(".password").css("border","1px solid #ced4da");
    $.ajax({
      type:"POST",
      url:base_url+"/admin_profile/modifProfile",
      data:{"id_profil":id_profil,"identifiant":identifiant,"password":password},
      success: function(data){
        if ($.trim(data) == "Mise à jour de vos paramètres réussie") {

    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllProfile('#example1');
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
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur '+data.responseText
      })  
          $(".chargementCarteGrise1").fadeOut();
       }
       });
  }
}


function afficheAllNotification(idTable){
  $('#example1').DataTable().destroy();
  $(".chargementPrime").fadeIn();

  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();

  $.ajax({
      type:"POST",
      url:base_url+"/admin_profile/getAllNotification",
      data:{"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){

        $(".contentCommande").empty();
        $(".contentCommande").append(data);
        ceerDatatable('#example1')
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