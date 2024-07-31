function addLivraison(status){
 id_client = $(".id_client").val();

 i=0;
champ=[];
valeur =[];
  do{
    champ[i] = $(".index"+i).attr("id");
    valeur[i] = $(".index"+i).val();
    // alert(valeur[i]);
i++;
  }while(i<=5)
tabChamp = JSON.stringify(champ);

tabValeur = JSON.stringify(valeur);

  numero = $(".numero").val();
  commentaire = $(".commentaire").val();
  dateLivraison = $(".dateLivraison").val();
  depart = $(".depart").val();
  unite = $(".unite").val();
  quantite = $(".quantite").val();
  id_client = $(".id_client").val();

  if(numero == "") {
    $(".numero").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (dateLivraison == "") {
    $(".dateLivraison").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (depart == "") {
    $(".depart").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (quantite == "") {
    $(".quantite").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else{

    $(".depart").css("border","1px solid #ced4da");
    $(".numero").css("border","1px solid #ced4da");
    $(".dateLivraison").css("border","1px solid #ced4da");
    $(".quantite").css("border","1px solid #ced4da");

$(".chargementCarteGrise1").fadeIn();
     $.ajax({
      type:"POST",
      url:base_url+"admin_commercial/addBonLivraison",
      data:{"depart":depart,"commentaire":commentaire,"dateLivraison":dateLivraison,"numero":numero,"unite":unite,"quantite":quantite,"tabChamp":tabChamp,"tabValeur":tabValeur,"status":status,"id_client":id_client},
      success: function(data){
   if ($.trim(data) == "Création parfaite du bon de livraison") {
    $(".code").val("");
    $(".transporteur").val("");
    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllBonLivraison('#example1');
        $(".chargementCarteGrise1").fadeOut();
      }else if ($.trim(data) == "Modification parfaite du bon de livraison") {

    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllBonLivraison('#example1');
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


function afficheAllBonLivraison(idTable){
  $(".chargementClient").fadeIn();
  $.ajax({
          type:"POST",
          url:base_url+"/admin_commercial/getAllBonLivraison",
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

function confirmSuppressionBonLivraison(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_pont_bascule/deleteTransporteur",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllBonLivraison('#example1');
        
          
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

function infosLivraison(numero,date_bl,depart,quantite,ref,commentaire,unite,ref_destination,ref_client,ref_transporteur,ref_chauffeur,ref_vehicule){
  $(".unite").val(unite);

  $(".id_client").val(ref);
  $(".commentaire").val(commentaire);
  $(".numero").val(numero);
  $(".dateLivraison").val(date_bl);
  $(".depart").val(depart);
  // $(".arrivee").val(arrivee);
  $(".quantite").val(quantite);

  $("#ref_vehicule").val(ref_vehicule);
  $("#ref_chauffeur").val(ref_chauffeur);
  $("#ref_transporteur").val(ref_transporteur);
  $("#ref_client").val(ref_client);
  $("#ref_destination").val(ref_destination);

  $(".btnModif").fadeIn();
  $(".btnAnnuler").fadeIn();
  $(".btnAdd").fadeOut();
}

function annuleModifLivraison(){
  $(".btnModif").fadeOut();
  $(".btnAnnuler").fadeOut();
  $(".btnAdd").fadeIn();
}

// client
function addClientCommercial(status){
  nom = $(".nom").val();
  code = $(".code").val();
  solde_initial = $(".solde_initial").val();
  date_initial = $(".date_initial").val();
  telephone = $(".telephone").val();
  adresse = $(".adresse").val();
  ville = $(".ville").val();

  id_client = $(".id_client").val();

  if (nom == "") {
    $(".nom").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (code == "") {
    $(".code").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (solde_initial == "") {
    $(".solde_initial").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (date_initial == "") {
    $(".date_initial").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else{

    $(".code").css("border","1px solid #ced4da");
    $(".nom").css("border","1px solid #ced4da");
    $(".solde_initial").css("border","1px solid #ced4da");
    $(".date_initial").css("border","1px solid #ced4da");


$(".chargementCarteGrise1").fadeIn();
     $.ajax({
      type:"POST",
      url:base_url+"admin_commercial/addClient",
      data:{"solde_initial":solde_initial,"date_initial":date_initial,"code":code,"id_client":id_client,"nom":nom,"status":status,"telephone":telephone,"adresse":adresse,"ville":ville},
      success: function(data){
   if ($.trim(data) == "Insertion parfaite du client") {
    $(".code").val("");
    $(".transporteur").val("");
    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllClient('#example1');
        $(".chargementCarteGrise1").fadeOut();
      }else if ($.trim(data) == "Modification parfaite du client") {

    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllClient('#example1');
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

function addCaisse(status){

  solde_initial = $(".solde_initial").val();
  date_initial = $(".date_initial").val();

  id_client = $(".id_client").val();

  if (solde_initial == "") {
    $(".solde_initial").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (date_initial == "") {
    $(".date_initial").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else{

    $(".solde_initial").css("border","1px solid #ced4da");
    $(".date_initial").css("border","1px solid #ced4da");


$(".chargementCarteGrise1").fadeIn();
     $.ajax({
      type:"POST",
      url:base_url+"admin_commercial/addCaisse",
      data:{"solde_initial":solde_initial,"date_initial":date_initial,"id_client":id_client,"status":status},
      success: function(data){
   if ($.trim(data) == "Insertion parfaite") {
    $(".code").val("");
    $(".transporteur").val("");
    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllCaisse('#example1');
        $(".chargementCarteGrise1").fadeOut();
      }else if ($.trim(data) == "Modification parfaite") {

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

function demandeSuppressionCommercial(table,identifiant,nom_id){
 $(".table").val();
 $(".identifiant").val();
 $(".nom_id").val();
 $(".table").val(table);
 $(".identifiant").val(identifiant);
 $(".nom_id").val(nom_id);

  // alert("la table est: "+table+" et identifiant: "+identifiant);
}

function afficheAllClient(idTable){
  $(".chargementClient").fadeIn();
  $.ajax({
          type:"POST",
          url:base_url+"/admin_commercial/getAllClient",
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

function afficheAllCaisse(idTable){
  $(".chargementClient").fadeIn();
  $.ajax({
          type:"POST",
          url:base_url+"/admin_commercial/getAllCaisse",
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

function confirmSuppressionClient(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_pont_bascule/deleteTransporteur",
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

function confirmSuppressionCaisse(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_pont_bascule/deleteTransporteur",
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

function infosClientCommercial(ref,nom,code,telephone,adresse,ville,solde_initial,date_initial){
  $(".solde_initial").val(solde_initial);
  $(".date_initial").val(date_initial);
  $(".code").val(code);
  $(".telephone").val(telephone);
  $(".adresse").val(adresse);
  $(".ville").val(ville);
  $(".id_client").val(ref);
  $(".nom").val(nom);

  $(".btnModif").fadeIn();
  $(".btnAnnuler").fadeIn();
  $(".btnAdd").fadeOut();
}

function infosCaisse(ref,solde_initial,date_initial){
  $(".solde_initial").val(solde_initial);
  $(".date_initial").val(date_initial);

  $(".id_client").val(ref);


  $(".btnModif").fadeIn();
  $(".btnAnnuler").fadeIn();
  $(".btnAdd").fadeOut();
}

// fournisseur

function addFournisseurCommercial(status){
  nom = $(".nom").val();
  code = $(".code").val();

  id_client = $(".id_client").val();

  if (nom == "") {
    $(".nom").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (code == "") {
    $(".code").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else{

    $(".code").css("border","1px solid #ced4da");
    $(".nom").css("border","1px solid #ced4da");


$(".chargementCarteGrise1").fadeIn();
     $.ajax({
      type:"POST",
      url:base_url+"admin_commercial/addFournisseur",
      data:{"code":code,"id_client":id_client,"nom":nom,"status":status},
      success: function(data){
   if ($.trim(data) == "Insertion parfaite du fournisseur") {
    $(".code").val("");
    $(".transporteur").val("");
    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllFournisseur('#example1');
        $(".chargementCarteGrise1").fadeOut();
      }else if ($.trim(data) == "Modification parfaite du fournisseur") {

    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllFournisseur('#example1');
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


function afficheAllFournisseur(idTable){
  $(".chargementClient").fadeIn();
  $.ajax({
          type:"POST",
          url:base_url+"/admin_commercial/getAllFournisseur",
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

function confirmSuppressionFournisseur(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_pont_bascule/deleteTransporteur",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllFournisseur('#example1');
        
          
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


// chauffeur

function addChauffeurCommercial(status){
  nom = $(".nom").val();
  cni = $(".cni").val();
  telephone = $(".telephone").val();

  id_client = $(".id_client").val();

  if (nom == "") {
    $(".nom").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (telephone == "") {
    $(".telephone").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else{

    $(".telephone").css("border","1px solid #ced4da");
    $(".nom").css("border","1px solid #ced4da");
    $(".cni").css("border","1px solid #ced4da");


$(".chargementCarteGrise1").fadeIn();
     $.ajax({
      type:"POST",
      url:base_url+"admin_commercial/addChauffeur",
      data:{"telephone":telephone,"id_client":id_client,"nom":nom,"status":status,"cni":cni},
      success: function(data){
   if ($.trim(data) == "Insertion parfaite du chauffeur") {
    $(".code").val("");
    $(".transporteur").val("");
    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllChauffeur('#example1');
        $(".chargementCarteGrise1").fadeOut();
      }else if ($.trim(data) == "Modification parfaite du chauffeur") {

    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllChauffeur('#example1');
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


function afficheAllChauffeur(idTable){
  $(".chargementClient").fadeIn();
  $.ajax({
          type:"POST",
          url:base_url+"/admin_commercial/getAllChauffeur",
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

function confirmSuppressionChauffeur(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_pont_bascule/deleteTransporteur",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllChauffeur('#example1');
        
          
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

function infosChauffeurCommercial(ref,nom,telephone,cni){
  $(".telephone").val(telephone);

  $(".id_client").val(ref);
  $(".nom").val(nom);

  $(".cni").val(cni);

  $(".btnModif").fadeIn();
  $(".btnAnnuler").fadeIn();
  $(".btnAdd").fadeOut();
}


// transporteur


function addTransporteurCommercial(status){
  nom = $(".nom").val();
  code = $(".code").val();

  id_client = $(".id_client").val();

  if (nom == "") {
    $(".nom").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (code == "") {
    $(".code").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else{

    $(".code").css("border","1px solid #ced4da");
    $(".nom").css("border","1px solid #ced4da");


$(".chargementCarteGrise1").fadeIn();
     $.ajax({
      type:"POST",
      url:base_url+"admin_commercial/addTransporteur",
      data:{"code":code,"id_client":id_client,"nom":nom,"status":status},
      success: function(data){
   if ($.trim(data) == "Insertion parfaite du transporteur") {
    $(".code").val("");
    $(".transporteur").val("");
    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllTransporteur('#example1');
        $(".chargementCarteGrise1").fadeOut();
      }else if ($.trim(data) == "Modification parfaite du transporteur") {

    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllTransporteur('#example1');
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


function afficheAllTransporteur(idTable){
  $(".chargementClient").fadeIn();
  $.ajax({
          type:"POST",
          url:base_url+"/admin_commercial/getAllTransporteur",
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

function confirmSuppressionTransporteur(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_pont_bascule/deleteTransporteur",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllTransporteur('#example1');
        
          
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

// article

function addArticle(status){
  commentaire = $(".commentaire").val();
  article = $(".article").val();
  reference = $(".reference").val();
  
  PU = $(".PU").val();
  id_BL = $(".id_BL").val();


  if (PU == "") {
    $(".PU").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (article == "") {
    $(".article").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (reference == "") {
    $(".reference").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else if (PU == "") {
    $(".PU").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else{
    $(".article").css("border","1px solid #ced4da");
    $(".reference").css("border","1px solid #ced4da");
    $(".reference").css("border","1px solid #ced4da");

    $(".PU").css("border","1px solid #ced4da");
      $(".chargementLivraison1").fadeIn();
  $.ajax({
          type:"POST",
          url:base_url+"/admin_commercial/addArticle",
          data:{"reference":reference,"commentaire":commentaire,"status":status,"id_BL":id_BL,"article":article,"PU":PU},
          success: function(data){  
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
              }else if ($.trim(data) == "Modification parfaite de l'article") {
                
     $(document).Toasts('create', {
        class: 'bg-success', 
        title: 'Alert',
        subtitle: 'Alert',
        body: data
      }) 
     $(".chargementLivraison1").fadeOut();
                $('#example1').DataTable().destroy();
                afficheAllArticle('#example1');
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

function afficheAllArticle(idTable){
  $(".chargementLivraison").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getAllArticle",
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

function confirmSuppressionArticle(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_pont_bascule/deleteTransporteur",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllArticle('#example1');
        
          
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

function infosArticle(article,PU,reference,commentaire,id_BL){
  $(".id_BL").val(id_BL);
  $(".commentaire").val(commentaire);
  $(".article").val(article);
  $(".reference").val(reference);

  $(".PU").val(PU);

  $(".btnModif").fadeIn();
  $(".btnAnnuler").fadeIn();
  $(".btnAdd").fadeOut();
}

function annulerModifArticle(){
  $(".btnModif").fadeOut();
  $(".btnAnnuler").fadeOut();
  $(".btnAdd").fadeIn();
}


function afficheLigneCommande(){
  nbreLigne = $(".nbreLigne").val();
$(".contentLignes").empty();
i=1;
$(".chargementPrime1").fadeIn();
conteneur = "";
 $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getNbreLigne",
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



function addCommande(status){

  id_fournisseur = $(".id_fournisseur").val();
  date_livraison = $(".date_livraison").val();
  date_commande = $(".date_commande").val();
  po = $(".po").val();
  // reference_com = $(".reference_com").val();
  lieu_livraison = $(".lieu_livraison").val();
  nbreLigne = $(".nbreLigne").val();
  compteur = $(".compteur").val();

  if (compteur>0) {
    nbreLigne = compteur;
  }

  article = [];
  quantite = [];
  reference = [];
  conditionnement = [];
  id_commande = [];
  type = [];


  i=1;
if (id_fournisseur == "") {
    $('.id_fournisseur').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (date_livraison == ""){
    $('.date_livraison').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (date_commande == ""){
    $('.date_commande').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (po == "") {
    $('.po').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (lieu_livraison == "") {
    $('.lieu_livraison').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else {
    $('.po').css("border","1px solid #ced4da");
    $('.lieu_livraison').css("border","1px solid #ced4da");
    $('.reference_com').css("border","1px solid #ced4da");
    $('.date_commande').css("border","1px solid #ced4da");
    $('.date_livraison').css("border","1px solid #ced4da");
    $('.id_fournisseur').css("border","1px solid #ced4da");

    do{
    if ($('.article'+i).val() == "") {
    $('.article'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs"); 
    }else if ($('.qtite_com'+i).val() == "") {
    $('.qtite_com'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else if ($('.reference'+i).val() == "") {
    $('.reference'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else if ($('.conditionnement'+i).val() == "") {
    $('.conditionnement'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else{
    
    $('.article'+i).css("border","1px solid #ced4da");
    $('.qtite_com'+i).css("border","1px solid #ced4da");
    $('.reference'+i).css("border","1px solid #ced4da");
    
    $('.conditionnement'+i).css("border","1px solid #ced4da");

    article[i] = $('.article'+i).val();
    quantite[i] = $('.qtite_com'+i).val();
    reference[i] = $('.reference'+i).val();
    conditionnement[i] = $('.conditionnement'+i).val();
    id_commande[i] = $('.id_commande'+i).val();
    }
    i++;
    }while(i<=nbreLigne)
  if (article.length >nbreLigne && quantite.length>nbreLigne && conditionnement.length>nbreLigne && reference.length>nbreLigne) {
$(".chargementPrime1").fadeIn();
// alert(status);
     $.ajax({
      type:"POST",
      url:base_url+"admin_commercial/addCommande",
      data:{"status":status,"lieu_livraison":lieu_livraison,"po":po,"date_commande":date_commande,"date_livraison":date_livraison,"id_fournisseur":id_fournisseur,"nbreLignes":nbreLigne,'id_commande':JSON.stringify(id_commande),'article':JSON.stringify(article),'quantite':JSON.stringify(quantite),'conditionnement':JSON.stringify(conditionnement),'reference':JSON.stringify(reference)},
      success: function(data){
        if ($.trim(data) == "Insertion parfaite de la commande") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 
             
          $(".id_fournisseur").val("");
        $(".date_livraison").val("");
        $(".date_commande").val("");
        $(".po").val("");
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
        nouveauCode();
             $('#example1').DataTable().destroy();
             afficheAllCommande("#exemple1");
            }else if ($.trim(data) == "Modification parfaite de la commande") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 


        $('#example1').DataTable().destroy();
             afficheAllCommande("#exemple1");

          $(".id_fournisseur").val("");
        $(".date_creation").val("");
        $(".date_commande").val("");
        $(".po").val("");
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
        nouveauCode();
            } else{
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
  }else{
    $(".chargementPrime1").fadeOut();
              $(document).Toasts('create', {
            class: 'bg-danger', 
            title: 'Erreur de connexion',
            subtitle: 'Alert',
            body: "Veuillez remplir votre commande"
          })   
  }
  }
}

function nouveauCode(){
     $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getNouveauCode",
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

function afficheAllCommande(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getAllCommande",
      data:{},
      success: function(data){

        $(".contentCommande").empty();
        $(".contentCommande").append(data);
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

function getDetailCommandePourModification(id_fournisseur,date_livraison,date_commande,po,lieu_livraison){
    $('.id_fournisseur').val(id_fournisseur);
    $('.lieu_livraison').val(lieu_livraison);

    $('.po').val(po);
    $('.date_commande').val(date_commande);
    $('.date_livraison').val(date_livraison);

  $(document).Toasts('create', {
        class: 'bg-info', 
        title: 'Alert',
        subtitle: 'Alert',
        body: 'Avant de confirmer toute Modification veuillez vous rassurer le numéro est celui de cette commande'
      })    

window.location = base_url+"/admin/bon_commande#details";
 $(".chargementPrime1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getListeCommandePourModif",
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
    $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAdd").fadeOut();
}

function detailCommande(po,fournisseur,date_com,date_livraison,lieu_livraison,reference_com){
  $(".po2").empty();
  $(".po2").append(po+'<br/><br/>');
  $(".fournisseur").empty();
  $(".fournisseur").append(fournisseur);
  $(".date_com2").empty();
  $(".date_com2").append(date_com);
  $(".date_livraison2").empty();
  $(".date_livraison2").append(date_livraison);
  $(".lieu_livraison2").empty();
  $(".lieu_livraison2").append(lieu_livraison);
  $(".reference_com2").empty();
  $(".reference_com2").append(reference_com);

  $(".chargementPrime2").fadeIn();
  window.location = base_url+"/admin/bon_commande#contentDetailCommande2";
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getDetailCommande",
      data:{"po":po},
      success: function(data){

        $(".contentDetailCommande2").empty();
        $(".contentDetailCommande2").append(data);
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

function confirmSuppressionCommande(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/deleteCommande",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllCommande('#example1');
        
          
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

function confirmSuppressionBL(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/deleteCommande",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllBL('#example1');
        
          
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

function confirmSuppressionBLMira(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/deleteCommande",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllBLmira('#example1');
        
          
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
// Définition de la zone à imprimer
var zone = document.getElementById(objet).innerHTML;
 
var win = window.open("", "", "height=1300, width=1600,toolbar=0, menubar=0, scrollbars=1, resizable=1,status=0, location=0, left=10, top=10");
win.document.write('<html><head><title>Print it!</title>  <meta name="viewport" content="width=device-width, initial-scale=1"><link rel="stylesheet" href="'+base_url+'assets/plugins/fontawesome-free/css/all.min.css"><link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"><link rel="stylesheet" href="'+base_url+'assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css"><link rel="stylesheet" href="'+base_url+'assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css"><link rel="stylesheet" href="'+base_url+'assets/plugins/jqvmap/jqvmap.min.css"><link rel="stylesheet" href="'+base_url+'assets/dist/css/adminlte.min.css"> <link rel="stylesheet" href="'+base_url+'assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css"><link rel="stylesheet" href="'+base_url+'assets/plugins/daterangepicker/daterangepicker.css"><link rel="stylesheet" href="'+base_url+'assets/plugins/toastr/toastr.css"><link rel="stylesheet" href="'+base_url+'assets/plugins/toastr/toastr.min.css"><link rel="stylesheet" href="'+base_url+'assets/plugins/summernote/summernote-bs4.css"><link rel="stylesheet" href="'+base_url+'assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css"><link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"><style type="text/css"> .btn-primary{display:none;}</style></head><body style="backgroundColor:red;">');
win.document.write(zone);
win.document.write('</body></html>');
win.print();
win.close();
}

// bon livraison

function addBL(status){

  id_client = $(".id_client").val();
  id_chauffeur = $(".id_chauffeur").val();
  id_vehicule = $(".id_vehicule").val();
  id_transporteur = $(".id_transporteur").val();
  date_bl = $(".date_bl").val();
  date_chargement = $(".date_chargement").val();
  po = $(".po").val();
  reference_com = $(".reference_com").val();
  lieu_livraison = $(".lieu_livraison").val();
  nbreLigne = $(".nbreLigne").val();
  compteur = $(".compteur").val();

  if (compteur>0) {
    nbreLigne = compteur;
  }

  article = [];
  quantite = [];
  reference = [];
  conditionnement = [];
  id_commande = [];
  type = [];


  i=1;
if (id_client == "") {
    $('.id_client').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (date_bl == ""){
    $('.date_bl').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (date_chargement == ""){
    $('.date_chargement').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (po == "") {
    $('.po').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (id_chauffeur == "") {
    $('.id_chauffeur').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (id_vehicule == "") {
    $('.id_vehicule').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (id_transporteur == "") {
    $('.id_transporteur').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else {
    $('.po').css("border","1px solid #ced4da");
    $('.date_bl').css("border","1px solid #ced4da");
    $('.date_chargement').css("border","1px solid #ced4da");
    $('.id_client').css("border","1px solid #ced4da");
    $('.id_chauffeur').css("border","1px solid #ced4da");
    $('.id_vehicule').css("border","1px solid #ced4da");
    $('.id_transporteur').css("border","1px solid #ced4da");

    do{
    if ($('.article'+i).val() == "") {
    $('.article'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs"); 
    }else if ($('.qtite_com'+i).val() == "") {
    $('.qtite_com'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else if ($('.reference'+i).val() == "") {
    $('.reference'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else if ($('.conditionnement'+i).val() == "") {
    $('.conditionnement'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else{
    
    $('.article'+i).css("border","1px solid #ced4da");
    $('.qtite_com'+i).css("border","1px solid #ced4da");
    $('.reference'+i).css("border","1px solid #ced4da");
    
    $('.conditionnement'+i).css("border","1px solid #ced4da");

    article[i] = $('.article'+i).val();
    quantite[i] = $('.qtite_com'+i).val();
    reference[i] = $('.reference'+i).val();
    conditionnement[i] = $('.conditionnement'+i).val();
    id_commande[i] = $('.id_commande'+i).val();
    }
    i++;
    }while(i<=nbreLigne)
  if (article.length >nbreLigne && quantite.length>nbreLigne && conditionnement.length>nbreLigne && reference.length>nbreLigne) {
$(".chargementPrime1").fadeIn();
// alert(status);
     $.ajax({
      type:"POST",
      url:base_url+"admin_commercial/addBL",
      data:{"status":status,"po":po,"date_chargement":date_chargement,"date_bl":date_bl,"id_client":id_client,"id_chauffeur":id_chauffeur,"id_vehicule":id_vehicule,"id_transporteur":id_transporteur,"nbreLignes":nbreLigne,'id_commande':JSON.stringify(id_commande),'article':JSON.stringify(article),'quantite':JSON.stringify(quantite),'conditionnement':JSON.stringify(conditionnement),'reference':JSON.stringify(reference)},
      success: function(data){
        if ($.trim(data) == "Insertion parfaite du bon de livraison") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 
             
          $(".id_fournisseur").val("");
        $(".date_livraison").val("");
        $(".date_commande").val("");
        $(".po").val("");
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
        nouveauCodeBL();
             $('#example1').DataTable().destroy();
             afficheAllBL("#exemple1");
            }else if ($.trim(data) == "Modification parfaite du bon de livraison") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 


        $('#example1').DataTable().destroy();
             afficheAllBL("#exemple1");

          $(".id_fournisseur").val("");
        $(".date_creation").val("");
        $(".date_commande").val("");
        $(".po").val("");
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
        nouveauCodeBL();
            } else{
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
  }else{
    $(".chargementPrime1").fadeOut();
              $(document).Toasts('create', {
            class: 'bg-danger', 
            title: 'Erreur de connexion',
            subtitle: 'Alert',
            body: "Veuillez remplir votre commande"
          })   
  }
  }
}

function addBLFacture(status){

  id_client = $(".id_client").val();
  id_chauffeur = $(".id_chauffeur").val();
  id_vehicule = $(".id_vehicule").val();
  id_transporteur = $(".id_transporteur").val();
  date_bl = $(".date_bl").val();
  date_chargement = $(".date_chargement").val();
  po = $(".po").val();
  reference_com = $(".reference_com").val();
  lieu_livraison = $(".lieu_livraison").val();
  nbreLigne = $(".nbreLigne").val();
  compteur = $(".compteur").val();

  if (compteur>0) {
    nbreLigne = compteur;
  }

  article = [];
  quantite = [];
  reference = [];
  conditionnement = [];
  id_commande = [];
  type = [];


  i=1;
if (id_client == "") {
    $('.id_client').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (date_bl == ""){
    $('.date_bl').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (date_chargement == ""){
    $('.date_chargement').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (po == "") {
    $('.po').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (id_chauffeur == "") {
    $('.id_chauffeur').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (id_vehicule == "") {
    $('.id_vehicule').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (id_transporteur == "") {
    $('.id_transporteur').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else {
    $('.po').css("border","1px solid #ced4da");
    $('.date_bl').css("border","1px solid #ced4da");
    $('.date_chargement').css("border","1px solid #ced4da");
    $('.id_client').css("border","1px solid #ced4da");
    $('.id_chauffeur').css("border","1px solid #ced4da");
    $('.id_vehicule').css("border","1px solid #ced4da");
    $('.id_transporteur').css("border","1px solid #ced4da");

    do{
    if ($('.article'+i).val() == "") {
    $('.article'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs"); 
    }else if ($('.qtite_com'+i).val() == "") {
    $('.qtite_com'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else if ($('.reference'+i).val() == "") {
    $('.reference'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else if ($('.conditionnement'+i).val() == "") {
    $('.conditionnement'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else{
    
    $('.article'+i).css("border","1px solid #ced4da");
    $('.qtite_com'+i).css("border","1px solid #ced4da");
    $('.reference'+i).css("border","1px solid #ced4da");
    
    $('.conditionnement'+i).css("border","1px solid #ced4da");

    article[i] = $('.article'+i).val();
    quantite[i] = $('.qtite_com'+i).val();
    reference[i] = $('.reference'+i).val();
    conditionnement[i] = "";
    id_commande[i] = $('.id_commande'+i).val();
    }
    i++;
    }while(i<=nbreLigne)
  if (article.length >nbreLigne && quantite.length>nbreLigne && conditionnement.length>nbreLigne && reference.length>nbreLigne) {
$(".chargementPrime1").fadeIn();
// alert(status);
     $.ajax({
      type:"POST",
      url:base_url+"admin_commercial/addBLFacture",
      data:{"status":status,"po":po,"date_chargement":date_chargement,"date_bl":date_bl,"id_client":id_client,"id_chauffeur":id_chauffeur,"id_vehicule":id_vehicule,"id_transporteur":id_transporteur,"nbreLignes":nbreLigne,'id_commande':JSON.stringify(id_commande),'article':JSON.stringify(article),'quantite':JSON.stringify(quantite),'conditionnement':JSON.stringify(conditionnement),'reference':JSON.stringify(reference)},
      success: function(data){
        if ($.trim(data) == "Insertion parfaite du bon de livraison") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 
             
          $(".id_fournisseur").val("");
        $(".date_livraison").val("");
        $(".date_commande").val("");
        $(".po").val("");
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
      
             $('#example1').DataTable().destroy();
             // afficheAllBL("#exemple1");
            }else if ($.trim(data) == "Modification parfaite du bon de livraison") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 


        $('#example1').DataTable().destroy();
             // afficheAllBL("#exemple1");

          $(".id_fournisseur").val("");
        $(".date_creation").val("");
        $(".date_commande").val("");
        $(".po").val("");
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
        // nouveauCodeBL();
            } else{
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
  }else{
    $(".chargementPrime1").fadeOut();
              $(document).Toasts('create', {
            class: 'bg-danger', 
            title: 'Erreur de connexion',
            subtitle: 'Alert',
            body: "Veuillez remplir votre commande"
          })   
  }
  }
}

function addBLFactureArticle(status){

  id_chauffeur = $(".id_chauffeur").val();
  id_vehicule = $(".id_vehicule").val();
  id_transporteur = $(".id_transporteur").val();
  date_bl = $(".date_bl").val();
  date_chargement = $(".date_chargement").val();
  po = $(".po").val();
  reference_com = $(".reference_com").val();
  lieu_livraison = $(".lieu_livraison").val();
  nbreLigne = $(".nbreLigne").val();
  compteur = $(".compteur").val();

  if (compteur>0) {
    nbreLigne = compteur;
  }

  article = [];
  quantite = [];
  reference = [];
  conditionnement = [];
  id_commande = [];
  type = [];


  i=1;
  if (date_bl == ""){
    $('.date_bl').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (date_chargement == ""){
    $('.date_chargement').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (po == "") {
    $('.po').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else {
    $('.po').css("border","1px solid #ced4da");
    $('.date_bl').css("border","1px solid #ced4da");
    $('.date_chargement').css("border","1px solid #ced4da");
    $('.id_client').css("border","1px solid #ced4da");
    $('.id_chauffeur').css("border","1px solid #ced4da");
    $('.id_vehicule').css("border","1px solid #ced4da");
    $('.id_transporteur').css("border","1px solid #ced4da");

    do{
    if ($('.article'+i).val() == "") {
    $('.article'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs"); 
    }else if ($('.qtite_com'+i).val() == "") {
    $('.qtite_com'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else if ($('.reference'+i).val() == "") {
    $('.reference'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else if ($('.conditionnement'+i).val() == "") {
    $('.conditionnement'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else{
    
    $('.article'+i).css("border","1px solid #ced4da");
    $('.qtite_com'+i).css("border","1px solid #ced4da");
    $('.reference'+i).css("border","1px solid #ced4da");
    
    $('.conditionnement'+i).css("border","1px solid #ced4da");

    article[i] = $('.article'+i).val();
    quantite[i] = $('.qtite_com'+i).val();
    reference[i] = $('.reference'+i).val();
    conditionnement[i] = "";
    id_commande[i] = $('.id_commande'+i).val();
    }
    i++;
    }while(i<=nbreLigne)
  if (article.length >nbreLigne && quantite.length>nbreLigne && conditionnement.length>nbreLigne && reference.length>nbreLigne) {
$(".chargementPrime1").fadeIn();
// alert(status);
     $.ajax({
      type:"POST",
      url:base_url+"admin_commercial/addBLFactureArticle",
      data:{"status":status,"po":po,"date_chargement":date_chargement,"date_bl":date_bl,"nbreLignes":nbreLigne,'id_commande':JSON.stringify(id_commande),'article':JSON.stringify(article),'quantite':JSON.stringify(quantite),'conditionnement':JSON.stringify(conditionnement),'reference':JSON.stringify(reference)},
      success: function(data){
        if ($.trim(data) == "Insertion parfaite du bon de livraison") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 
             
          $(".id_fournisseur").val("");
        $(".date_livraison").val("");
        $(".date_commande").val("");
        $(".po").val("");
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
      
             $('#example1').DataTable().destroy();
             // afficheAllBL("#exemple1");
            }else if ($.trim(data) == "Modification parfaite du bon de livraison") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 


        $('#example1').DataTable().destroy();
             // afficheAllBL("#exemple1");

          $(".id_fournisseur").val("");
        $(".date_creation").val("");
        $(".date_commande").val("");
        $(".po").val("");
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
        // nouveauCodeBL();
            } else{
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
  }else{
    $(".chargementPrime1").fadeOut();
              $(document).Toasts('create', {
            class: 'bg-danger', 
            title: 'Erreur de connexion',
            subtitle: 'Alert',
            body: "Veuillez remplir votre commande"
          })   
  }
  }
}


function nouveauCodeBL(){
     $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getNouveauCodeBL",
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

function afficheAllBL(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getAllBL",
      data:{},
      success: function(data){

        $(".contentCommande").empty();
        $(".contentCommande").append(data);
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

function getDetailBLPourModification(id_client,id_chauffeur,id_vehicule,id_transporteur,date_bl,date_chargement,po){
    $('.id_client').val(id_client);
    $('.id_chauffeur').val(id_chauffeur);
    $('.id_vehicule').val(id_vehicule);
    $('.id_transporteur').val(id_transporteur);
    
    $('.po').val(po);
    $('.date_chargement').val(date_chargement);
    $('.date_bl').val(date_bl);

  $(document).Toasts('create', {
        class: 'bg-info', 
        title: 'Alert',
        subtitle: 'Alert',
        body: 'Avant de confirmer toute Modification veuillez vous rassurer le numéro est celui de cette commande'
      })    

window.location = base_url+"admin/bon_livraison#details";
 $(".chargementPrime1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getListeBLPourModif",
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
    $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAdd").fadeOut();
}


function detailBL(po,client,ville,adresse,telephone,chauffeur,vehicule,transporteur,date_bl,date_chargement,total_qtite){
  $(".po2").empty();
  $(".po2").append(po+'<br/><br/>');
  $(".client").empty();
  $(".client").append(client);
  $(".chauffeur").empty();
  $(".chauffeur").append(chauffeur);
  $(".vehicule").empty();
  $(".vehicule").append(vehicule);
  $(".transporteur").empty();
  $(".transporteur").append(transporteur);
  $(".date_bl2").empty();
  $(".date_bl2").append(date_bl);
  $(".date_chargement2").empty();
  $(".date_chargement2").append(date_chargement);
  $(".total_qtite").empty();
  $(".total_qtite").append(total_qtite);
  $(".chargementPrime2").fadeIn();

    $(".villeClient").empty();
  $(".villeClient").append(ville);

    $(".adresseClient").empty();
  $(".adresseClient").append(adresse);

    $(".telephoneClient").empty();
  $(".telephoneClient").append(telephone);
  window.location = base_url+"admin/bon_livraison#contentDetailCommande2";
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getDetailBL",
      data:{"po":po},
      success: function(data){

        $(".contentDetailCommande3").empty();
        $(".contentDetailCommande3").append(data);

        $(".contentDetailCommande2").empty();
        $(".contentDetailCommande2").append(data);
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


function detailBLPourFacture(po,client,ville,adresse,telephone,chauffeur,vehicule,transporteur,date_bl,date_chargement,total_qtite){
  $(".po2").empty();
  $(".po2").append(po+'<br/><br/>');
  $(".client").empty();
  $(".client").append(client);
  $(".chauffeur").empty();
  $(".chauffeur").append(chauffeur);
  $(".vehicule").empty();
  $(".vehicule").append(vehicule);
  $(".transporteur").empty();
  $(".transporteur").append(transporteur);
  $(".date_bl2").empty();
  $(".date_bl2").append(date_bl);
  $(".date_chargement2").empty();
  $(".date_chargement2").append(date_chargement);
  $(".total_qtite3").empty();
  $(".total_qtite3").append(total_qtite);

    $(".villeClient").empty();
  $(".villeClient").append(ville);

    $(".adresseClient").empty();
  $(".adresseClient").append(adresse);

    $(".telephoneClient").empty();
  $(".telephoneClient").append(telephone);

  $(".chargementPrime2").fadeIn();
  // window.location = base_url+"admin/bon_livraison#contentDetailCommande2";
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getDetailBL",
      data:{"po":po},
      success: function(data){

        $(".contentDetailCommande3").empty();
        $(".contentDetailCommande3").append(data);
        // alert(data);
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


function detailBLPourFactureArticle(po,client,ville,adresse,telephone,chauffeur,vehicule,transporteur,date_bl,date_chargement,total_qtite){
  $(".po2").empty();
  $(".po2").append(po+'<br/><br/>');
  $(".client").empty();
  $(".client").append(client);
  $(".chauffeur").empty();
  $(".chauffeur").append(chauffeur);
  $(".vehicule").empty();
  $(".vehicule").append(vehicule);
  $(".transporteur").empty();
  $(".transporteur").append(transporteur);
  $(".date_bl2").empty();
  $(".date_bl2").append(date_bl);
  $(".date_chargement2").empty();
  $(".date_chargement2").append(date_chargement);
  $(".total_qtite4").empty();
  $(".total_qtite4").append(total_qtite);

    $(".villeClient").empty();
  $(".villeClient").append(ville);

    $(".adresseClient").empty();
  $(".adresseClient").append(adresse);

    $(".telephoneClient").empty();
  $(".telephoneClient").append(telephone);

  $(".chargementPrime2").fadeIn();
  // window.location = base_url+"admin/bon_livraison#contentDetailCommande2";
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getDetailBLmira",
      data:{"po":po},
      success: function(data){

        $(".contentDetailCommande4").empty();
        $(".contentDetailCommande4").append(data);
        // alert(data);
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

// function confirmSuppressionBL(){
//  table = $(".table").val();
//  identifiant = $(".identifiant").val();
//  nom_id = $(".nom_id").val();
//  // creerDatable("exemple1");
//  $.ajax({
//       type:"POST",
//       url:base_url+"/admin_pont_bascule/deleteTransporteur",
//       data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
//       success: function(data){  

//         toastr.success(data);
//         $('#example1').DataTable().destroy();
//         afficheAllBL('#example1');
        
          
//       },
//             error:function(data){
//           $(document).Toasts('create', {
//         class: 'bg-danger', 
//         title: 'Erreur de connexion',
//         subtitle: 'Alert',
//         body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
//       })
                
//        }
//        });
// }


// bon de livraison client


function addBLmira(status){

  id_chauffeur = $(".id_chauffeur").val();
  id_vehicule = $(".id_vehicule").val();
  id_transporteur = $(".id_transporteur").val();
  date_bl = $(".date_bl").val();
  po = $(".po").val();
  reference_com = $(".reference_com").val();
  lieu_livraison = $(".lieu_livraison").val();
  nbreLigne = $(".nbreLigne").val();
  compteur = $(".compteur").val();

  if (compteur>0) {
    nbreLigne = compteur;
  }

  article = [];
  quantite = [];
  reference = [];
  conditionnement = [];
  id_commande = [];
  type = [];


  i=1;
  if (date_bl == ""){
    $('.date_bl').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (po == "") {
    $('.po').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (id_chauffeur == "") {
    $('.id_chauffeur').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (id_vehicule == "") {
    $('.id_vehicule').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (id_transporteur == "") {
    $('.id_transporteur').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else {
    $('.po').css("border","1px solid #ced4da");
    $('.date_bl').css("border","1px solid #ced4da");
    $('.id_chauffeur').css("border","1px solid #ced4da");
    $('.id_vehicule').css("border","1px solid #ced4da");
    $('.id_transporteur').css("border","1px solid #ced4da");

    do{
    if ($('.article'+i).val() == "") {
    $('.article'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs"); 
    }else if ($('.qtite_com'+i).val() == "") {
    $('.qtite_com'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else if ($('.reference'+i).val() == "") {
    $('.reference'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else if ($('.conditionnement'+i).val() == "") {
    $('.conditionnement'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else{
    
    $('.article'+i).css("border","1px solid #ced4da");
    $('.qtite_com'+i).css("border","1px solid #ced4da");
    $('.reference'+i).css("border","1px solid #ced4da");
    
    $('.conditionnement'+i).css("border","1px solid #ced4da");

    article[i] = $('.article'+i).val();
    quantite[i] = $('.qtite_com'+i).val();
    reference[i] = $('.reference'+i).val();
    conditionnement[i] = $('.conditionnement'+i).val();
    id_commande[i] = $('.id_commande'+i).val();
    }
    i++;
    }while(i<=nbreLigne)
  if (article.length >nbreLigne && quantite.length>nbreLigne && conditionnement.length>nbreLigne && reference.length>nbreLigne) {
$(".chargementPrime1").fadeIn();
// alert(status);
     $.ajax({
      type:"POST",
      url:base_url+"admin_commercial/addBLmira",
      data:{"status":status,"po":po,"date_bl":date_bl,"id_chauffeur":id_chauffeur,"id_vehicule":id_vehicule,"id_transporteur":id_transporteur,"nbreLignes":nbreLigne,'id_commande':JSON.stringify(id_commande),'article':JSON.stringify(article),'quantite':JSON.stringify(quantite),'conditionnement':JSON.stringify(conditionnement),'reference':JSON.stringify(reference)},
      success: function(data){
        if ($.trim(data) == "Insertion parfaite du bon de livraison") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 
             
          $(".id_fournisseur").val("");
        $(".date_livraison").val("");
        $(".date_commande").val("");
        $(".po").val("");
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
        nouveauCodeBLmira();
             $('#example1').DataTable().destroy();
             afficheAllBLmira("#exemple1");
            }else if ($.trim(data) == "Modification parfaite du bon de livraison") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 


        $('#example1').DataTable().destroy();
             afficheAllBLmira("#exemple1");

          $(".id_fournisseur").val("");
        $(".date_creation").val("");
        $(".date_commande").val("");
        $(".po").val("");
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
        nouveauCodeBLmira();
            } else{
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
  }else{
    $(".chargementPrime1").fadeOut();
              $(document).Toasts('create', {
            class: 'bg-danger', 
            title: 'Erreur de connexion',
            subtitle: 'Alert',
            body: "Veuillez remplir votre commande"
          })   
  }
  }
}

function nouveauCodeBLmira(){
     $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getNouveauCodeBLmira",
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

function afficheAllBLmira(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getAllBLmira",
      data:{},
      success: function(data){

        $(".contentCommande").empty();
        $(".contentCommande").append(data);
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

function getDetailBLmiraPourModification(id_chauffeur,id_vehicule,id_transporteur,date_bl,po){
    // $('.id_client').val(id_client);
    $('.id_chauffeur').val(id_chauffeur);
    $('.id_vehicule').val(id_vehicule);
    $('.id_transporteur').val(id_transporteur);
    
    $('.po').val(po);
    // $('.date_chargement').val(date_chargement);
    $('.date_bl').val(date_bl);

  $(document).Toasts('create', {
        class: 'bg-info', 
        title: 'Alert',
        subtitle: 'Alert',
        body: 'Avant de confirmer toute Modification veuillez vous rassurer le numéro est celui de cette commande'
      })    

window.location = base_url+"admin/bon_livraison_mira#details";
 $(".chargementPrime1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getListeBLmiraPourModif",
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
    $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAdd").fadeOut();
}


function detailBLmira(po,chauffeur,vehicule,transporteur,date_bl,total_qtite){
  $(".po2").empty();
  $(".po2").append(po+'<br/><br/>');
  $(".chauffeur").empty();
  $(".chauffeur").append(chauffeur);
  $(".vehicule").empty();
  $(".vehicule").append(vehicule);
  $(".transporteur").empty();
  $(".transporteur").append(transporteur);
  $(".date_bl2").empty();
  $(".date_bl2").append(date_bl);
  $(".total_qtite").empty();
  $(".total_qtite").append(total_qtite);
  $(".chargementPrime2").fadeIn();
  window.location = base_url+"admin/bon_livraison_mira#contentDetailCommande2";
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getDetailBLmira",
      data:{"po":po},
      success: function(data){

        $(".contentDetailCommande2").empty();
        $(".contentDetailCommande2").append(data);
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


// facture de la partie commercial

function addBLFacture(status){

  id_client = $(".id_client").val();
  id_chauffeur = "";
  id_vehicule = "";
  id_transporteur = "";
  date_bl = $(".date_bl").val();
  date_chargement = $(".date_bl").val();
  po = $(".po").val();
  reference_com = $(".reference_com").val();
  lieu_livraison = $(".lieu_livraison").val();
  nbreLigne = $(".nbreLigne").val();
  compteur = $(".compteur").val();

  if (compteur>0) {
    nbreLigne = compteur;
  }

  article = [];
  quantite = [];
  reference = [];
  conditionnement = [];
  id_commande = [];
  type = [];
// eooooooooooooo

// ttooto
  i=1;
// if (id_client == "") {
//     $('.id_client').css("border","red 2px solid");
//         toastr.error("Veuillez remplir tous les Champs");
//   }else if (date_bl == ""){
//     $('.date_bl').css("border","red 2px solid");
//         toastr.error("Veuillez remplir tous les Champs");
//   }else if (date_chargement == ""){
//     $('.date_chargement').css("border","red 2px solid");
//         toastr.error("Veuillez remplir tous les Champs");
//   }else if (po == "") {
//     $('.po').css("border","red 2px solid");
//         toastr.error("Veuillez remplir tous les Champs");
//   }else if (id_chauffeur == "") {
//     $('.id_chauffeur').css("border","red 2px solid");
//         toastr.error("Veuillez remplir tous les Champs");
//   }else if (id_vehicule == "") {
//     $('.id_vehicule').css("border","red 2px solid");
//         toastr.error("Veuillez remplir tous les Champs");
//   }else if (id_transporteur == "") {
//     $('.id_transporteur').css("border","red 2px solid");
//         toastr.error("Veuillez remplir tous les Champs");
//   }else {
    $('.po').css("border","1px solid #ced4da");
    $('.date_bl').css("border","1px solid #ced4da");
    $('.date_chargement').css("border","1px solid #ced4da");
    $('.id_client').css("border","1px solid #ced4da");
    $('.id_chauffeur').css("border","1px solid #ced4da");
    $('.id_vehicule').css("border","1px solid #ced4da");
    $('.id_transporteur').css("border","1px solid #ced4da");

    do{
    if ($('.article'+i).val() == "") {
    $('.article'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs"); 
    }else if ($('.qtite_com'+i).val() == "") {
    $('.qtite_com'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else if ($('.reference'+i).val() == "") {
    $('.reference'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else if ($('.conditionnement'+i).val() == "") {
    $('.conditionnement'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else{
    
    $('.article'+i).css("border","1px solid #ced4da");
    $('.qtite_com'+i).css("border","1px solid #ced4da");
    $('.reference'+i).css("border","1px solid #ced4da");
    
    $('.conditionnement'+i).css("border","1px solid #ced4da");

    article[i] = $('.article'+i).val();
    quantite[i] = $('.qtite_com'+i).val();
    reference[i] = $('.reference'+i).val();
    conditionnement[i] = "";
    id_commande[i] = $('.id_commande'+i).val();
    }
    i++;
    }while(i<=nbreLigne)
  if (article.length >nbreLigne && quantite.length>nbreLigne && conditionnement.length>nbreLigne && reference.length>nbreLigne) {
$(".chargementPrime1").fadeIn();
// alert(status);
     $.ajax({
      type:"POST",
      url:base_url+"admin_commercial/addBLFacture",
      data:{"status":status,"po":po,"date_chargement":date_chargement,"date_bl":date_bl,"id_client":id_client,"id_chauffeur":id_chauffeur,"id_vehicule":id_vehicule,"id_transporteur":id_transporteur,"nbreLignes":nbreLigne,'id_commande':JSON.stringify(id_commande),'article':JSON.stringify(article),'quantite':JSON.stringify(quantite),'conditionnement':JSON.stringify(conditionnement),'reference':JSON.stringify(reference)},
      success: function(data){
        if ($.trim(data) == "Insertion parfaite du bon de livraison") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 
             
          $(".id_fournisseur").val("");
        $(".date_livraison").val("");
        $(".date_commande").val("");
        $(".po").val("");
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
        // nouveauCodeBL();
             $('#example1').DataTable().destroy();
             // afficheAllBL("#exemple1");
            }else if ($.trim(data) == "Modification parfaite du bon de livraison") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 


        $('#example1').DataTable().destroy();
             // afficheAllBL("#exemple1");

          $(".id_fournisseur").val("");
        $(".date_creation").val("");
        $(".date_commande").val("");
        $(".po").val("");
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
        // nouveauCodeBL();
            } else{
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
  }else{
    $(".chargementPrime1").fadeOut();
              $(document).Toasts('create', {
            class: 'bg-danger', 
            title: 'Erreur de connexion',
            subtitle: 'Alert',
            body: "Veuillez remplir votre commande"
          })   
  }
  // }
}

function addFacture(status){

  id_client = $(".id_client").val();
  prestataire = $(".prestataire").val();

  date_bl = $(".date_bl").val();
  po = $(".po").val();
  reference_com = $(".reference_com").val();
  lieu_livraison = $(".lieu_livraison").val();
  nbreLigne = $(".nbreLigne").val();
  compteur = $(".compteur").val();

  if (compteur>0) {
    nbreLigne = compteur;
  }

  article = [];
  quantite = [];
  pu = [];
  reference = [];
  remise = [];
  id_commande = [];
  type = [];


  i=1;
if (id_client == "") {
    $('.id_client').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (date_bl == ""){
    $('.date_bl').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (prestataire == ""){
    $('.prestataire').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (po == "") {
    $('.po').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else {
    $('.po').css("border","1px solid #ced4da");
    $('.date_bl').css("border","1px solid #ced4da");
    $('.id_client').css("border","1px solid #ced4da");
    

    do{
    if ($('.article'+i).val() == "") {
    $('.article'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs"); 
    }else if ($('.qtite_com'+i).val() == "") {
    $('.qtite_com'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else if ($('.pu'+i).val() == "") {
    $('.pu'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else if ($('.pu'+i).val() == "") {
    $('.pu'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else if ($('.reference'+i).val() == "") {
    $('.reference'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else{
    
    $('.article'+i).css("border","1px solid #ced4da");
    $('.qtite_com'+i).css("border","1px solid #ced4da");
    $('.pu'+i).css("border","1px solid #ced4da");
    $('.remise'+i).css("border","1px solid #ced4da");
    $('.reference'+i).css("border","1px solid #ced4da");
    
    article[i] = $('.article'+i).val();
    quantite[i] = $('.qtite_com'+i).val();
    pu[i] = $('.pu'+i).val();
    reference[i] = $('.reference'+i).val();
    remise[i] = $('.remise'+i).val();
    id_commande[i] = $('.id_commande'+i).val();
    }
    i++;
    }while(i<=nbreLigne)
  if (article.length >nbreLigne && quantite.length>nbreLigne && remise.length>nbreLigne && pu.length>nbreLigne && reference.length>nbreLigne) {
$(".chargementPrime1").fadeIn();
// alert(status);
     $.ajax({
      type:"POST",
      url:base_url+"admin_commercial/addfacture",
      data:{"prestataire":prestataire,"status":status,"po":po,"date_bl":date_bl,"id_client":id_client,"nbreLignes":nbreLigne,'id_commande':JSON.stringify(id_commande),'article':JSON.stringify(article),'quantite':JSON.stringify(quantite),'pu':JSON.stringify(pu),'remise':JSON.stringify(remise),'reference':JSON.stringify(reference)},
      success: function(data){
        if ($.trim(data) == "Insertion parfaite de la facture") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 
             
       
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
        
        addBLFacture('insert');
           $(".id_fournisseur").val("");
        $(".date_livraison").val("");
        $(".date_commande").val("");
        $(".po").val("");
        nouveauCodeFacture();
             $('#example1').DataTable().destroy();
             afficheAllFacture("#exemple1");
            }else if ($.trim(data) == "Modification parfaite de la facture") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 


        $('#example1').DataTable().destroy();
             afficheAllFacture("#exemple1");

        $(".po").val("");
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
        nouveauCodeFacture();
            } else{
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
  }else{
    $(".chargementPrime1").fadeOut();
              $(document).Toasts('create', {
            class: 'bg-danger', 
            title: 'Erreur de connexion',
            subtitle: 'Alert',
            body: "Veuillez remplir votre commande"
          })   
  }
  }
}


function addFactureArticle(status){

   id_client = $(".id_client").val();
  prestataire = $(".prestataire").val();

  date_bl = $(".date_bl").val();
  po = $(".po").val();
  reference_com = $(".reference_com").val();
  lieu_livraison = $(".lieu_livraison").val();
  nbreLigne = $(".nbreLigne").val();
  compteur = $(".compteur").val();

  if (compteur>0) {
    nbreLigne = compteur;
  }

  article = [];
  quantite = [];
  pu = [];
  reference = [];
  remise = [];
  id_commande = [];
  type = [];


  i=1;
if (id_client == "") {
    $('.id_client').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (date_bl == ""){
    $('.date_bl').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (prestataire == ""){
    $('.prestataire').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (po == "") {
    $('.po').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else {
    $('.po').css("border","1px solid #ced4da");
    $('.date_bl').css("border","1px solid #ced4da");
    $('.id_client').css("border","1px solid #ced4da");
    

    do{
    if ($('.article'+i).val() == "") {
    $('.article'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs"); 
    }else if ($('.qtite_com'+i).val() == "") {
    $('.qtite_com'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else if ($('.pu'+i).val() == "") {
    $('.pu'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else if ($('.pu'+i).val() == "") {
    $('.pu'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else if ($('.reference'+i).val() == "") {
    $('.reference'+i).css("border","red 2px solid");
          toastr.error("Veuillez remplir tous les Champs");
    }else{
    
    $('.article'+i).css("border","1px solid #ced4da");
    $('.qtite_com'+i).css("border","1px solid #ced4da");
    $('.pu'+i).css("border","1px solid #ced4da");
    $('.remise'+i).css("border","1px solid #ced4da");
    $('.reference'+i).css("border","1px solid #ced4da");
    
    article[i] = $('.article'+i).val();
    quantite[i] = $('.qtite_com'+i).val();
    pu[i] = $('.pu'+i).val();
    reference[i] = $('.reference'+i).val();
    remise[i] = $('.remise'+i).val();
    id_commande[i] = $('.id_commande'+i).val();
    }
    i++;
    }while(i<=nbreLigne)
  if (article.length >nbreLigne && quantite.length>nbreLigne && remise.length>nbreLigne && pu.length>nbreLigne && reference.length>nbreLigne) {
$(".chargementPrime1").fadeIn();
// alert(status);
     $.ajax({
      type:"POST",
      url:base_url+"admin_commercial/addfactureArticle",
      data:{"prestataire":prestataire,"status":status,"po":po,"date_bl":date_bl,"id_client":id_client,"nbreLignes":nbreLigne,'id_commande':JSON.stringify(id_commande),'article':JSON.stringify(article),'quantite':JSON.stringify(quantite),'pu':JSON.stringify(pu),'remise':JSON.stringify(remise),'reference':JSON.stringify(reference)},
      success: function(data){
        if ($.trim(data) == "Insertion parfaite de la facture") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          })  
             
       
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
        
        addBLFactureArticle('insert');
           $(".id_fournisseur").val("");
        $(".date_livraison").val("");
        $(".date_commande").val("");
        $(".po").val("");
        nouveauCodeFacture();
             $('#example1').DataTable().destroy();
             afficheAllFactureArticle("#exemple1");
            }else if ($.trim(data) == "Modification parfaite de la facture") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 


        $('#example1').DataTable().destroy();
             afficheAllFactureArticle("#exemple1");

        $(".po").val("");
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
        nouveauCodeFacture();
            } else{
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
  }else{
    $(".chargementPrime1").fadeOut();
              $(document).Toasts('create', {
            class: 'bg-danger', 
            title: 'Erreur de connexion',
            subtitle: 'Alert',
            body: "Veuillez remplir votre commande"
          })   
  }
  }
}

function nouveauCodeFacture(){
     $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getNouveauCodeFacture",
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

function afficheAllFacture(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getAllFacture",
      data:{},
      success: function(data){

        $(".contentCommande").empty();
        $(".contentCommande").append(data);
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

function afficheAllFactureArticle(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getAllFactureArticle",
      data:{},
      success: function(data){

        $(".contentCommande").empty();
        $(".contentCommande").append(data);
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

function getDetailFacturePourModification(id_client,date_bl,po,prestataire){
    $('.id_client').val(id_client);
    
    $('.po').val(po);
    $('.date_bl').val(date_bl);
    $('.prestataire').val(prestataire);

  $(document).Toasts('create', {
        class: 'bg-info', 
        title: 'Alert',
        subtitle: 'Alert',
        body: 'Avant de confirmer toute Modification veuillez vous rassurer le numéro est celui de cette commande'
      })    

window.location = base_url+"admin/facture_commercial#details";
 $(".chargementPrime1").fadeIn();
  $.ajax({
      type:"POST", 
      url:base_url+"/admin_commercial/getListeFacturePourModif",
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
    $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAdd").fadeOut();
}

function getDetailFactureArticlePourModification(id_client,date_bl,po,prestataire){
    $('.id_client').val(id_client);
    
    $('.po').val(po);
    $('.date_bl').val(date_bl);
    $('.prestataire').val(prestataire);

  $(document).Toasts('create', {
        class: 'bg-info', 
        title: 'Alert',
        subtitle: 'Alert',
        body: 'Avant de confirmer toute Modification veuillez vous rassurer le numéro est celui de cette commande'
      })    

window.location = base_url+"admin/factureArticle#details";
 $(".chargementPrime1").fadeIn();
  $.ajax({
      type:"POST", 
      url:base_url+"/admin_commercial/getListeFactureArticlePourModif",
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
    $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAdd").fadeOut();
}

function detailFacture(po,client,ville,adresse,telephone,date_bl,total_montant){
  $(".po2").empty();
  $(".po2").append(po+'<br/><br/>');
  $(".client").empty();
  $(".client").append(client);
  $(".date_bl2").empty();
  $(".date_bl2").append(date_bl);
  $(".total_qtite").empty();
  $(".total_qtite").append(total_montant);
  $(".total_qtite2").empty();
  $(".total_qtite2").append(NumberToLetter(total_montant)+" FCFA");

    $(".villeClient").empty();
  $(".villeClient").append(ville);

    $(".adresseClient").empty();
  $(".adresseClient").append(adresse);

    $(".telephoneClient").empty();
  $(".telephoneClient").append(telephone);
  $(".chargementPrime2").fadeIn();
  window.location = base_url+"admin/facture_commercial#contentDetailCommande2";
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getDetailfacture",
      data:{"po":po},
      success: function(data){

        $(".contentDetailCommande2").empty();
        $(".contentDetailCommande2").append(data);
        // alert(data);
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

function detailFactureArticle(po,client,ville,adresse,telephone,date_bl,total_montant){
  $(".po2").empty();
  $(".po2").append(po+'<br/><br/>');
  $(".client").empty();
  $(".client").append(client);
  $(".date_bl2").empty();
  $(".date_bl2").append(date_bl);
  $(".total_qtite").empty();
  $(".total_qtite").append(total_montant);
  $(".total_qtite2").empty();
  $(".total_qtite2").append(NumberToLetter(total_montant)+" FCFA");

    $(".villeClient").empty();
  $(".villeClient").append(ville);

    $(".adresseClient").empty();
  $(".adresseClient").append(adresse);

    $(".telephoneClient").empty();
  $(".telephoneClient").append(telephone);
  $(".chargementPrime2").fadeIn();
  window.location = base_url+"admin/factureArticle#contentDetailCommande2";
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getDetailfactureArticle",
      data:{"po":po},
      success: function(data){

        $(".contentDetailCommande2").empty();
        $(".contentDetailCommande2").append(data);
        // alert(data);
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
function afficheLigneFacture(){
  nbreLigne = $(".nbreLigne").val();
$(".contentLignes").empty();
i=1;
$(".chargementPrime1").fadeIn();
conteneur = "";
 $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getNbreLigneFacture",
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



function getPrixUnitaireArticle(id_article,pu){
    
   $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getPrixUnitaireArticle",
      data:{'id_article':id_article,"origine":""},
      success: function(data){
        // alert(data);
        $("."+pu).val("");
        formatMillierPourSelection(data,pu);
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

function getReferenceArticle(id_article,reference){
    
   $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getReferenceArticle",
      data:{'id_article':id_article,"origine":""},
      success: function(data){
        // alert(reference);
        $("."+reference).val("");
        $("."+reference).val(data);
       
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

// accuse de retrait



function addAccuseRetrait(status){

  id_facture = $(".id_facture").val();

  date_retrait = $(".date_retrait").val();
  date_echeance = $(".date_echeance").val();
  po = $(".po").val();
  reference = $(".reference").val();
  montant = $(".montant").val();
   motif = $(".motif").val();
  id_retrait = $(".id_retrait").val();

  i=1;
if (id_facture == "") {
    $('.id_facture').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (date_retrait == ""){
    $('.date_retrait').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (date_echeance == ""){
    $('.date_echeance').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (po == "") {
    $('.po').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (montant == "") {
    $('.montant').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (reference == "") {
    $('.reference').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (motif == "") {
    $('.motif').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else {
    $('.po').css("border","1px solid #ced4da");
    $('.date_retrait').css("border","1px solid #ced4da");
    $('.date_echeance').css("border","1px solid #ced4da");
    $('.montant').css("border","1px solid #ced4da");
    $('.reference').css("border","1px solid #ced4da");
    $('.motif').css("border","1px solid #ced4da");
    $('.id_facture').css("border","1px solid #ced4da");

   
$(".chargementPrime1").fadeIn();
// alert(status);
     $.ajax({
      type:"POST",
      url:base_url+"admin_commercial/addAccuseRetrait",
      data:{"status":status,"po":po,"date_echeance":date_echeance,"date_retrait":date_retrait,"id_facture":id_facture,"id_retrait":id_retrait,"reference":reference,"motif":motif,"montant":montant},
      success: function(data){
        if ($.trim(data) == "Insertion parfaite de l'accusé de retrait") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 
             
          $(".id_fournisseur").val("");
        $(".date_livraison").val("");
        $(".date_commande").val("");
        $(".po").val("");
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
        nouveauCodeAccuseRetrait();
             $('#example1').DataTable().destroy();
             afficheAllAccuseRetrait("#exemple1");
            }else if ($.trim(data) == "Modification parfaite de l'accusé de retrait") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 


        $('#example1').DataTable().destroy();
             afficheAllAccuseRetrait("#exemple1");

          $(".id_fournisseur").val("");
        $(".date_creation").val("");
        $(".date_commande").val("");
        $(".po").val("");
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
        nouveauCodeAccuseRetrait();
            } else{
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
}

function nouveauCodeAccuseRetrait(){
     $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getNouveauCodeAccuseRetrait",
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

function afficheAllAccuseRetrait(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getAllAccuseRetrait",
      data:{},
      success: function(data){

        $(".contentCommande").empty();
        $(".contentCommande").append(data);
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

function getDetailAccuseRetraitPourModification(id_client,reference,date_retrait,date_echeance,po,montant,motif,ref){
    $('.id_facture').val(id_client);
    $('.id_retrait').val(ref);
    $('.reference').val(reference);
    $('.date_retrait').val(date_retrait);
    $('.date_echeance').val(date_echeance);
    
    $('.po').val(po);
    $('.montant').val(montant);
    $('.motif').val(motif);

window.location = base_url+"admin/accuse_retrait#details";

    $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAdd").fadeOut();
}

function detailAccuseRetrait(facture,client,ville,adresse,telephone,po,reference,date_retrait,date_echeance,montant,motif){
    $(".chargementPrime2").fadeIn();
  $(".po2").empty();
  $(".po2").append(po+'<br/><br/>');
  $(".client").empty();
  $(".client").append(client);
  $(".facture").empty();
  $(".facture").append(facture);
  $(".reference2").empty();
  $(".reference2").append(reference);
  $(".date_retrait2").empty();
  $(".date_retrait2").append(date_retrait);
  $(".date_echeance2").empty();
  $(".date_echeance2").append(date_echeance);
  $(".montant2").empty();
  $(".montant2").append(montant);
   $(".montant3").empty();
  $(".montant3").append(montant+" ("+NumberToLetter(montant)+" ) FCFA");
  $(".motif2").empty();
  $(".motif2").append(motif);

    $(".villeClient").empty();
  $(".villeClient").append(ville);

    $(".adresseClient").empty();
  $(".adresseClient").append(adresse);

    $(".telephoneClient").empty();
  $(".telephoneClient").append(telephone);
  $(".chargementPrime2").fadeOut();
  window.location = base_url+"admin/accuse_retrait#contentDetailCommande2";

}

// Accuse reglement
function getClientParNumeroFacture(){
  num_facture = $(".id_facture").val();

     $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getClientParNumeroFacture",
      data:{"num_facture":num_facture},
      success: function(data){
      $(".client").val("");
      $(".client").val(data);
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


function getNetPayerFacture(){
  num_facture = $(".id_facture").val();

     $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getNetPayerFacture",
      data:{"num_facture":num_facture},
      success: function(data){
      $(".montantFacture").val("");
      formatMillierPourSelection(data,'montantFacture');      },
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
function addAccuseReglement(status){

  id_facture = $(".id_facture").val();

  date_retrait = $(".date_retrait").val();
  date_echeance = $(".date_echeance").val();
  po = $(".po").val();
  reference = $(".reference").val();
  montant = $(".montant").val();
   motif = $(".motif").val();
  id_retrait = $(".id_retrait").val();

  i=1;
if (id_facture == "") {
    $('.id_facture').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (date_retrait == ""){
    $('.date_retrait').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (date_echeance == ""){
    $('.date_echeance').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (po == "") {
    $('.po').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (montant == "") {
    $('.montant').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (reference == "") {
    $('.reference').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (motif == "") {
    $('.motif').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else {
    $('.po').css("border","1px solid #ced4da");
    $('.date_retrait').css("border","1px solid #ced4da");
    $('.date_echeance').css("border","1px solid #ced4da");
    $('.montant').css("border","1px solid #ced4da");
    $('.reference').css("border","1px solid #ced4da");
    $('.motif').css("border","1px solid #ced4da");
    $('.id_facture').css("border","1px solid #ced4da");

   
$(".chargementPrime1").fadeIn();
// alert(status);
     $.ajax({
      type:"POST",
      url:base_url+"admin_commercial/addAccuseReglement",
      data:{"status":status,"po":po,"date_echeance":date_echeance,"date_retrait":date_retrait,"id_facture":id_facture,"id_retrait":id_retrait,"reference":reference,"motif":motif,"montant":montant},
      success: function(data){
        if ($.trim(data) == "Insertion parfaite de l'accusé de règlement") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 
             
          $(".id_fournisseur").val("");
        $(".date_livraison").val("");
        $(".date_commande").val("");
        $(".po").val("");
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
        nouveauCodeAccuseReglement();
             $('#example1').DataTable().destroy();
             afficheAllAccuseReglement("#exemple1");
            }else if ($.trim(data) == "Modification parfaite de l'accusé de règlement") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 


        $('#example1').DataTable().destroy();
             afficheAllAccuseReglement("#exemple1");

          $(".id_fournisseur").val("");
        $(".date_creation").val("");
        $(".date_commande").val("");
        $(".po").val("");
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
        nouveauCodeAccuseReglement();
            } else{
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
}

function nouveauCodeAccuseReglement(){
     $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getNouveauCodeAccuseReglement",
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

function afficheAllAccuseReglement(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getAllAccuseReglement",
      data:{},
      success: function(data){

        $(".contentCommande").empty();
        $(".contentCommande").append(data);
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


function detailAccuseReglement(facture,client,ville,adresse,telephone,po,reference,date_retrait,date_echeance,montant,motif){
    $(".chargementPrime2").fadeIn();
  $(".po2").empty();
  $(".po2").append(po+'<br/><br/>');
  $(".client").empty();
  $(".client").append(client);
  $(".facture").empty();
  $(".facture").append(facture);
  $(".reference2").empty();
  $(".reference2").append(reference);
  $(".date_retrait2").empty();
  $(".date_retrait2").append(date_retrait);
  $(".date_echeance2").empty();
  $(".date_echeance2").append(date_echeance);
  $(".montant2").empty();
  $(".montant2").append(montant);

   $(".montant3").empty();
  $(".montant3").append(montant+" ("+NumberToLetter(montant)+" ) FCFA");
  $(".motif2").empty();
  $(".motif2").append(motif);
  $(".chargementPrime2").fadeOut();

    $(".villeClient").empty();
  $(".villeClient").append(ville);

    $(".adresseClient").empty();
  $(".adresseClient").append(adresse);

    $(".telephoneClient").empty();
  $(".telephoneClient").append(telephone);
  window.location = base_url+"admin/accuse_reglement#contentDetailCommande2";

}

function getDetailAccuseReglementPourModification(id_client,reference,date_retrait,date_echeance,po,montant,motif,ref){
    $('.id_facture').val(id_client);
    $('.id_retrait').val(ref);
    $('.reference').val(reference);
    $('.date_retrait').val(date_retrait);
    $('.date_echeance').val(date_echeance);
    
    $('.po').val(po);
    $('.montant').val(montant);
    $('.motif').val(motif);

window.location = base_url+"admin/accuse_reglement#details";

    $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAdd").fadeOut();
}

function confirmSuppressionAccuseRetrait(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_pont_bascule/deleteTransporteur",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllAccuseRetrait('#example1');
        
          
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

function confirmSuppressionAccuseReglement(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_pont_bascule/deleteTransporteur",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllAccuseReglement('#example1');
        
          
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


// avis de debit

function addAvisDebit(status){

  id_client = $(".id_client").val();

  date_avis = $(".date_avis").val();

  po = $(".po").val();
  montant = $(".montant").val();
   motif = $(".motif").val();
  id_retrait = $(".id_retrait").val();

  i=1;
if (id_client == "") {
    $('.id_client').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (date_avis == ""){
    $('.date_avis').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (po == "") {
    $('.po').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (montant == "") {
    $('.montant').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (motif == "") {
    $('.motif').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else {
    $('.po').css("border","1px solid #ced4da");
    $('.date_avis').css("border","1px solid #ced4da");
    $('.montant').css("border","1px solid #ced4da");
    $('.motif').css("border","1px solid #ced4da");
    $('.id_client').css("border","1px solid #ced4da");

   
$(".chargementPrime1").fadeIn();
// alert(status);
     $.ajax({
      type:"POST",
      url:base_url+"admin_commercial/addAvisDebit",
      data:{"status":status,"po":po,"date_avis":date_avis,"id_client":id_client,"id_retrait":id_retrait,"motif":motif,"montant":montant},
      success: function(data){
        if ($.trim(data) == "Insertion parfaite de l'avis de debit") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 
             
          $(".id_fournisseur").val("");
        $(".date_livraison").val("");
        $(".date_commande").val("");
        $(".po").val("");
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
        nouveauCodeAvisDebit();
             $('#example1').DataTable().destroy();
             afficheAllAvisDebit("#exemple1");
            }else if ($.trim(data) == "Modification parfaite de l'avis de debit") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 


        $('#example1').DataTable().destroy();
             afficheAllAvisDebit("#exemple1");

          $(".id_fournisseur").val("");
        $(".date_creation").val("");
        $(".date_commande").val("");
        $(".po").val("");
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
        nouveauCodeAvisDebit();
            } else{
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
}

function nouveauCodeAvisDebit(){
     $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getNouveauCodeAvisDebit",
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

function afficheAllAvisDebit(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getAllAvisDebit",
      data:{},
      success: function(data){

        $(".contentCommande").empty();
        $(".contentCommande").append(data);
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

function getDetailAvisDebitPourModification(id_client,date_avis,po,montant,motif,ref){
    $('.id_client').val(id_client);
    $('.id_retrait').val(ref);
    $('.date_avis').val(date_avis);
    
    $('.po').val(po);
    $('.montant').val(montant);
    $('.motif').val(motif);
// alert(montant);
window.location = base_url+"admin/avis_debit#details";

    $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAdd").fadeOut();
}

function detailAvisDebit(client,ville,telephone,adresse,po,date_avis,montant,motif){
    $(".chargementPrime2").fadeIn();
  $(".po2").empty();
  $(".po2").append(po+'<br/><br/>');
  $(".client").empty();
  $(".client").append(client);

  $(".date_avis2").empty();
  $(".date_avis2").append(date_avis);

 $(".ville").empty();
  $(".ville").append(ville);

$(".adresse").empty();
  $(".adresse").append(adresse);

 $(".telephone").empty();
  $(".telephone").append(telephone);
// alert(montant);
  // $(".montant2").empty();
  // $(".montant2").append(montant);
   $(".montant2").empty();
  $(".montant2").append(montant+" ("+NumberToLetter(montant)+" ) FCFA");
  $(".motif2").empty();
  $(".motif2").append(motif);
  $(".chargementPrime2").fadeOut();
  window.location = base_url+"admin/avis_debit#contentDetailCommande2";

}


function confirmSuppressionAvisDebit(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_pont_bascule/deleteTransporteur",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllAvisDebit('#example1');
        
          
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

// Avis de credit


function addAvisCredit(status){

  id_client = $(".id_client").val();

  date_avis = $(".date_avis").val();

  po = $(".po").val();
  montant = $(".montant").val();
   motif = $(".motif").val();
  id_retrait = $(".id_retrait").val();

  i=1;
if (id_client == "") {
    $('.id_client').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (date_avis == ""){
    $('.date_avis').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (po == "") {
    $('.po').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (montant == "") {
    $('.montant').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else if (motif == "") {
    $('.motif').css("border","red 2px solid");
        toastr.error("Veuillez remplir tous les Champs");
  }else {
    $('.po').css("border","1px solid #ced4da");
    $('.date_avis').css("border","1px solid #ced4da");
    $('.montant').css("border","1px solid #ced4da");
    $('.motif').css("border","1px solid #ced4da");
    $('.id_client').css("border","1px solid #ced4da");

   
$(".chargementPrime1").fadeIn();
// alert(status);
     $.ajax({
      type:"POST",
      url:base_url+"admin_commercial/addAvisCredit",
      data:{"status":status,"po":po,"date_avis":date_avis,"id_client":id_client,"id_retrait":id_retrait,"motif":motif,"montant":montant},
      success: function(data){
        if ($.trim(data) == "Insertion parfaite de l'avis de credit") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 
             
          $(".id_fournisseur").val("");
        $(".date_livraison").val("");
        $(".date_commande").val("");
        $(".po").val("");
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
        nouveauCodeAvisCredit();
             $('#example1').DataTable().destroy();
             afficheAllAvisCredit("#exemple1");
            }else if ($.trim(data) == "Modification parfaite de l'avis de credit") {
              $(".chargementPrime1").fadeOut();
             $(document).Toasts('create', {
            class: 'bg-success', 
            title: 'Success',
            subtitle: 'Alert',
            body: data
          }) 


        $('#example1').DataTable().destroy();
             afficheAllAvisCredit("#exemple1");

          $(".id_fournisseur").val("");
        $(".date_creation").val("");
        $(".date_commande").val("");
        $(".po").val("");
        // $(".etat_reception").val("");
        // $(".etat_expedition").val("");
        nouveauCodeAvisCredit();
            } else{
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
}

function nouveauCodeAvisDebit(){
     $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getNouveauCodeAvisDebit",
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

function afficheAllAvisCredit(idTable){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getAllAvisCredit",
      data:{},
      success: function(data){

        $(".contentCommande").empty();
        $(".contentCommande").append(data);
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

function getDetailAvisCreditPourModification(id_client,date_avis,po,montant,motif,ref){
    $('.id_client').val(id_client);
    $('.id_retrait').val(ref);
    $('.date_avis').val(date_avis);
    
    $('.po').val(po);
    $('.montant').val(montant);
    $('.motif').val(motif);

window.location = base_url+"/admin/avis_credit#details";

    $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAdd").fadeOut();
}

function detailAvisCredit(client,ville,telephone,adresse,po,date_avis,montant,motif){
    $(".chargementPrime2").fadeIn();
  $(".po2").empty();
  $(".po2").append(po+'<br/><br/>');

  $(".client").empty();
  $(".client").append(client);

  $(".date_avis2").empty();
  $(".date_avis2").append(date_avis);

 $(".ville").empty();
  $(".ville").append(ville);

   $(".adresse").empty();
  $(".adresse").append(adresse);

 $(".telephone").empty();
  $(".telephone").append(telephone);

  // $(".montant2").empty();
  // $(".montant2").append(montant);
   $(".montant2").empty();
  $(".montant2").append(montant+" ("+NumberToLetter(montant)+" ) FCFA");
  $(".motif2").empty();
  $(".motif2").append(motif);
  $(".chargementPrime2").fadeOut();
  window.location = base_url+"/admin/avis_credit#contentDetailCommande2";

}


function confirmSuppressionAvisCredit(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_pont_bascule/deleteTransporteur",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllAvisCredit('#example1');
        
          
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


function nouveauCodeAvisCredit(){
     $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getNouveauCodeAvisCredit",
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

function getDetailAvisCreditPourModification(id_client,date_avis,po,montant,motif,ref){
    $('.id_client').val(id_client);
    $('.id_retrait').val(ref);
    $('.date_avis').val(date_avis);
    
    $('.po').val(po);
    $('.montant').val(montant);
    $('.motif').val(motif);

window.location = base_url+"/admin/avis_credit#details";

    $(".btnAnnuler").fadeIn();
  $(".btnModif").fadeIn();
  $(".btnAdd").fadeOut();
}


function selectAllTotalDebitPourBalanceClient(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getAllTotalDebitPourBalance",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".totalDebit").val("");
        formatMillierPourSelection(data,'totalDebit');
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

function selectAllTotalCreditPourBalanceClient(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getAllTotalCreditPourBalance",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".totalCredit").val("");
        formatMillierPourSelection(data,'totalCredit');
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

function afficheAllDebitPourBalance(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getAllDebitPourBalance",
      data:{"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
// alert(data);
        $(".contentDebit").empty();
        $(".contentDebit").append(data);
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

function afficheAllCreditPourBalance(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getAllCreditPourBalance",
      data:{"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){

        $(".contentCredit").empty();
        $(".contentCredit").append(data);
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

function soldeCaisseClient(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/soldeCaisseClient",
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
// balance client
function getBalance(){
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  id_fournisseur = $(".id_fournisseur").val();

  if (id_fournisseur == "" && date_debut == "" && date_fin == "") {

  }else{

  soldeCaisseClient(id_fournisseur,date_debut,date_fin);
  selectAllTotalDebitPourBalanceClient(id_fournisseur,date_debut,date_fin);
  selectAllTotalCreditPourBalanceClient(id_fournisseur,date_debut,date_fin);
    $('#example2').DataTable().destroy();
  afficheAllDebitPourBalance('#example2',id_fournisseur,date_debut,date_fin);

  $('#example1').DataTable().destroy();
  afficheAllCreditPourBalance('#example1',id_fournisseur,date_debut,date_fin);
  
  }
}

// nouvelle balance client
function selectAllTotalAccuseRetraitPourBalanceClient(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getAllTotalAccuseRetraitPourBalance2",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".totalRetrait5").val("");
        formatMillierPourSelection(data,'totalRetrait5');
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
      url:base_url+"/admin_commercial/getAllTotalAccuseReglementPourBalance2",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".totalReglement").val("");
        formatMillierPourSelection(data,'totalReglement');

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



function selectAllTotalAccuseRetraitPourBalanceClient2(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getAllTotalAccuseRetraitPourBalance",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".totalRetrait3").val("");
        formatMillierPourSelection(data,'totalRetrait3');
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

function selectAllTotalAccuseReglementPourBalanceClient2(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getAllTotalAccuseReglementPourBalance",
      data:{"id_operation":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".totalReglement2").val("");
        formatMillierPourSelection(data,'totalReglement2');
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

function afficheAllAccuseRetraitPourBalance(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getAllAccuseRetraitPourBalance",
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

function afficheAllAccuseReglementPourBalance(idTable,id_fournisseur,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getAllAccuseReglementPourBalance",
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

function soldeCaisseClient2(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/soldeCaisseClient2",
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


function soldeCaisse(date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/soldeCaisse",
      data:{"date_debut":date_debut,"date_fin":date_fin},
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

function selectAllTotalAccuseRetraitPourBalanceCaisse(date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getAllTotalAccuseRetraitPourBalanceCaisse",
      data:{"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".totalRetrait5").val("");
        formatMillierPourSelection(data,'totalRetrait5');
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

function selectAllTotalAccuseReglementPourBalanceCaisse(date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getAllTotalAccuseReglementPourBalanceCaisse",
      data:{"date_debut":date_debut,"date_fin":date_fin},
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


function afficheAllAccuseRetraitPourBalanceCaisse(idTable,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getAllAccuseRetraitPourBalanceCaisse",
      data:{"date_debut":date_debut,"date_fin":date_fin},
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

function afficheAllAccuseReglementPourBalanceCaisse(idTable,date_debut,date_fin){
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getAllAccuseReglementPourBalanceCaisse",
      data:{"date_debut":date_debut,"date_fin":date_fin},
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
function getBalanceCaisse(){
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  id_fournisseur = $(".id_fournisseur").val();

  if (id_fournisseur == "" && date_debut == "" && date_fin == "") {

  }else{

     $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/verifiDateInitialCaisse",
      data:{"date_initial":date_debut,"id_client":id_fournisseur},
      success: function(data){
        if ($.trim(data) == "ok") {
              soldeCaisse(date_debut,date_fin);
  selectAllTotalAccuseRetraitPourBalanceCaisse(date_debut,date_fin);
selectAllTotalAccuseReglementPourBalanceCaisse(date_debut,date_fin);
repportNouveauCaisse(date_debut,date_fin);
    $('#example2').DataTable().destroy();
  afficheAllAccuseRetraitPourBalanceCaisse('#example2',date_debut,date_fin);

  $('#example1').DataTable().destroy();
  afficheAllAccuseReglementPourBalanceCaisse('#example1',date_debut,date_fin);


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

function getSoldeInitialClient(id_fournisseur){

  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getSoldeInitialClient",
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

function getDateInitialClient(id_fournisseur){
  $(".chargementClient1").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getDateInitialClient",
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

function verifiDateInitialClient(date,id_client){
  $(".chargementClient1").fadeIn();
  donne="";
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/verifiDateInitialClient",
      data:{"date_initial":date,"id_client":id_client},
      success: function(data){
        
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
function repportNouveau(id_fournisseur,date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/repportNouveau",
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
function getBalanceClient(){
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  id_fournisseur = $(".id_fournisseur").val();
getDateInitialClient(id_fournisseur);
getSoldeInitialClient(id_fournisseur);

  if (id_fournisseur == "" && date_debut == "" && date_fin == "") {

  }else{

      $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/verifiDateInitialClient",
      data:{"date_initial":date_debut,"id_client":id_fournisseur},
      success: function(data){
        if ($.trim(data) == "ok") {
           facturePourBalanceClient('test');
  
  totalFacturePourBalanceClient('test');

  factureArticlePourBalanceClient('idTable');
  totalFactureArticlePourBalanceClient();
    soldeCaisseClient2(id_fournisseur,date_debut,date_fin);
  selectAllTotalAccuseRetraitPourBalanceClient(id_fournisseur,date_debut,date_fin);
selectAllTotalAccuseReglementPourBalanceClient(id_fournisseur,date_debut,date_fin);

  selectAllTotalAccuseRetraitPourBalanceClient2(id_fournisseur,date_debut,date_fin);
selectAllTotalAccuseReglementPourBalanceClient2(id_fournisseur,date_debut,date_fin);

    $('#example2').DataTable().destroy();
  afficheAllAccuseRetraitPourBalance('#example2',id_fournisseur,date_debut,date_fin);

  $('#example1').DataTable().destroy();
  afficheAllAccuseReglementPourBalance('#example1',id_fournisseur,date_debut,date_fin);


  selectAllTotalDebitPourBalanceClient(id_fournisseur,date_debut,date_fin);
  selectAllTotalCreditPourBalanceClient(id_fournisseur,date_debut,date_fin);
    $('#example5').DataTable().destroy();
  afficheAllDebitPourBalance('#example5',id_fournisseur,date_debut,date_fin);
repportNouveau(id_fournisseur,date_debut,date_fin);
  $('#example6').DataTable().destroy();
  afficheAllCreditPourBalance('#example6',id_fournisseur,date_debut,date_fin);
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
function annuleModifCommande(){
  $(".btnModif").fadeOut();
  $(".btnAnnuler").fadeOut();
  $(".btnAdd").fadeIn();

  nouveauCode();

$(".id_fournisseur").val("");
$(".date_livraison").val("");
$(".date_commande").val("");
$(".reference_com").val("");
$(".lieu_livraison").val("");
}

function confirmSuppressionFacture(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/deleteCommande",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllFacture('#example1');
        
          
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

function confirmSuppressionFactureArticle(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/deleteCommande",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllFactureArticle('#example1');
        
          
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

// conditionnement

function addConditionnement(status){
  nom = $(".nom").val();
 

  id_client = $(".id_client").val();

  if (nom == "") {
    $(".nom").css("border","red 2px solid");
    toastr.error("Veuillez remplir tous les Champs");
  }else{

    $(".code").css("border","1px solid #ced4da");
    $(".nom").css("border","1px solid #ced4da");


$(".chargementCarteGrise1").fadeIn();
     $.ajax({
      type:"POST",
      url:base_url+"admin_commercial/addConditionnement",
      data:{"id_client":id_client,"nom":nom,"status":status},
      success: function(data){
   if ($.trim(data) == "Insertion parfaite du conditionnement") {
    $(".code").val("");
    $(".transporteur").val("");
    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllConditionnement('#example1');
        $(".chargementCarteGrise1").fadeOut();
      }else if ($.trim(data) == "Modification parfaite du conditionnement") {

    toastr.info(data);
        $('#example1').DataTable().destroy();
        afficheAllConditionnement('#example1');
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


function afficheAllConditionnement(idTable){
  $(".chargementClient").fadeIn();
  $.ajax({
          type:"POST",
          url:base_url+"/admin_commercial/getAllConditionnement",
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

function confirmSuppressionConditionnement(){
 table = $(".table").val();
 identifiant = $(".identifiant").val();
 nom_id = $(".nom_id").val();
 // creerDatable("exemple1");
 $.ajax({
      type:"POST",
      url:base_url+"/admin_pont_bascule/deleteTransporteur",
      data:{"table":table,"identifiant":identifiant,"nom_id":nom_id},
      success: function(data){  

        toastr.success(data);
        $('#example1').DataTable().destroy();
        afficheAllConditionnement('#example1');
        
          
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

function infosConditionnement(ref,nom){

  $(".id_client").val(ref);
  $(".nom").val(nom);

  $(".btnModif").fadeIn();
  $(".btnAnnuler").fadeIn();
  $(".btnAdd").fadeOut();
}

// rapport bc
function historiqueBoisson(idTable){
  $('#example1').DataTable().destroy();
  historiqueBoisson1('#example1');
}


function rapportBC(idTable){
$('#example1').DataTable().destroy();
  id_fournisseur = $(".id_fournisseur").val();
   date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  articles = $(".articles").val();

if ( articles == undefined) {

}else{
  
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/rapportBC",
      data:{"id_fournisseur":articles,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){

        $(".contentCommande").empty();
        $(".contentCommande").append(data);
         // alert(data);
        ceerDatatable('#example1');
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
}


function rapportBL(idTable){
$('#example1').DataTable().destroy();
  id_fournisseur = $(".id_fournisseur").val();
   date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  articles = $(".articles").val();

if ( articles == undefined) {

}else{
  
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/rapportBL",
      data:{"id_fournisseur":articles,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){

        $(".contentCommande").empty();
        $(".contentCommande").append(data);
         // alert(data);
        ceerDatatable('#example1');
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
}

function rapportFacture(idTable){
$('#example1').DataTable().destroy();
  id_fournisseur = $(".id_fournisseur").val();
   date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  articles = $(".articles").val();

if ( articles == undefined) {

}else{
  
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/rapportFacture",
      data:{"id_fournisseur":articles,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){

        $(".contentCommande").empty();
        $(".contentCommande").append(data);
         // alert(data);
        ceerDatatable('#example1');
        $(".chargementPrime").fadeOut();

        totalRapportFacture();
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


function totalRapportFacture(){
  id_fournisseur = $(".id_fournisseur").val();
   date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  articles = $(".articles").val();

if ( articles == undefined) {

}else{
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/totalRapportFacture",
      data:{"id_fournisseur":articles,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){

        $(".totalBoisson").val();
        $(".totalBoisson").val(data);
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

function rapportFactureArticle(idTable){
$('#example1').DataTable().destroy();
  id_fournisseur = $(".id_fournisseur").val();
   date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  articles = $(".articles").val();

if ( articles == undefined) {

}else{
  
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/rapportFactureArticle",
      data:{"id_fournisseur":articles,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){

        $(".contentCommande").empty();
        $(".contentCommande").append(data);
         // alert(data);
        ceerDatatable('#example1');
        $(".chargementPrime").fadeOut();

        totalRapportFactureArticle();
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


function totalRapportFactureArticle(){
  id_fournisseur = $(".id_fournisseur").val();
   date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  articles = $(".articles").val();

if ( articles == undefined) {

}else{
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/totalRapportFactureArticle",
      data:{"id_fournisseur":articles,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){

        $(".totalBoisson").val();
        $(".totalBoisson").val(data);
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

function totalFacturePourBalanceClient(){
  id_fournisseur = $(".id_fournisseur").val();
   date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  articles = $(".articles").val();

if ( articles == undefined) {

}else{
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/totalFacturePourBalanceClient",
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
      url:base_url+"/admin_commercial/facturePourBalanceClient",
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


function totalFactureArticlePourBalanceClient(){
  id_fournisseur = $(".id_fournisseur").val();
   date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  articles = $(".articles").val();

if ( articles == undefined) {

}else{
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/totalFactureArticlePourBalanceClient",
      data:{"id_fournisseur":articles,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){

        $(".totalBoisson1").val();
        formatMillierPourSelection(data,'totalBoisson1');
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


function factureArticlePourBalanceClient(idTable){
$('#example4').DataTable().destroy();
  id_fournisseur = $(".id_fournisseur").val();
   date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  articles = $(".articles").val();

if ( articles == undefined) {

}else{
  
  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/factureArticlePourBalanceClient",
      data:{"id_fournisseur":articles,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){

        $(".contentCommande4").empty();
        $(".contentCommande4").append(data);
         // alert(data);
        ceerDatatable('#example4');
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

function rapportBLMira(idTable){
$('#example1').DataTable().destroy();
   date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();



  $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/rapportBLMira",
      data:{"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){

        $(".contentCommande").empty();
        $(".contentCommande").append(data);
         // alert(data);
        ceerDatatable('#example1');
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

function repportNouveauCaisse(date_debut,date_fin){
   $(".chargementPrime").fadeIn();
  $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/repportNouveauCaisse",
      data:{"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
        // alert(data);
        $(".repportNouveau").val("");
        formatMillierPourSelection(data,'repportNouveau');
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
      url:base_url+"/admin_commercial/getBalanceImprimableClient",
      data:{"id_client":id_fournisseur,"id_fournisseur":id_fournisseur,"date_debut":date_debut,"date_fin":date_fin},
      success: function(data){
// alert(data);
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
function getBalanceImprimableClient(){
  date_debut = $(".date_debut").val();
  date_fin = $(".date_fin").val();
  id_fournisseur = $(".id_fournisseur").val();
getDateInitialClient(id_fournisseur);
getSoldeInitialClient(id_fournisseur);

  if (id_fournisseur == "" && date_debut == "" && date_fin == "") {

  }else if (date_debut == "" || date_fin == "") {

  }
  else{

      $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/verifiDateInitialClient",
      data:{"date_initial":date_debut,"id_client":id_fournisseur},
      success: function(data){
        if ($.trim(data) == "ok") {
           facturePourBalanceClient('test');
  $(".date_debut1").empty();
  $(".date_debut1").append(date_debut);

  $(".date_fin1").empty();
  $(".date_fin1").append(date_fin);
  totalFacturePourBalanceClient('test');

  factureArticlePourBalanceClient('idTable');
  totalFactureArticlePourBalanceClient();
    soldeCaisseClient2(id_fournisseur,date_debut,date_fin);
  selectAllTotalAccuseRetraitPourBalanceClient(id_fournisseur,date_debut,date_fin);
selectAllTotalAccuseReglementPourBalanceClient(id_fournisseur,date_debut,date_fin);

  selectAllTotalAccuseRetraitPourBalanceClient2(id_fournisseur,date_debut,date_fin);
selectAllTotalAccuseReglementPourBalanceClient2(id_fournisseur,date_debut,date_fin);


  $('#example1').DataTable().destroy();
  getBalanceImprimableClient2('#example1',id_fournisseur,date_debut,date_fin)
  // afficheAllAccuseReglementPourBalance('#example1',id_fournisseur,date_debut,date_fin);
repportNouveau(id_fournisseur,date_debut,date_fin);

  selectAllTotalDebitPourBalanceClient(id_fournisseur,date_debut,date_fin);
  selectAllTotalCreditPourBalanceClient(id_fournisseur,date_debut,date_fin);
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