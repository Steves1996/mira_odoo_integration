base_url = "http://localhost/miratransport/";
function requeteReussi(){
    $('.pourcent').fadeIn();
    $('#barres').fadeIn(10);
      var progress = $('#progressions').width();
      var progressLimit = $('#barres').width();
      $('#progressions').css('background-color','#0184ff');
      limite = 101;
      //récupération de la valeur actuelle

      progress = Math.round((progress/$('#barres').width())*100);
      progress=progress+1;
      console.log(progress);
      if(progress < limite){
        $('#progressions').css('width',progress+'%');
        //incrémente la valeur de 1 si elle est strictement inférierue à 100
          setTimeout(requeteReussi,120);
      	  $('.pourcent').text('Chargement ...'+progress+'%');
	           if(progress === 63){
		        	
		        $('#progressions').css('background','linear-gradient(to right, #5e5e5b 20%, #ffffff 42%, #94addc 85%)');
		        }
		       if(progress > 73){
		        	
		        $('#progressions').css('background','linear-gradient(to right, #0184ff 20%, #ffffff 42%, #235169 85%)');
		        }
		        if(progress === 70){
		        	toastr.warning("Chargement de vos paramètres");
		        $('#progressions').css('background','linear-gradient(to right, #5e5e5b 20%, #ffffff 42%, #94addc 85%)');
		        }
		      if(progress > 83){
		        	
		        $('#progressions').css('background','linear-gradient(to right, #5e5e5b 20%, #ffffff 42%, #d8ea12 85%)');
		       
		        }
		        if(progress === 63){
		        	toastr.info("Redirection en cours");
		        $('#progressions').css('background','linear-gradient(to right, #5e5e5b 20%, #ffffff 42%, #94addc 85%)');
		        }
		       if(progress > 94){
		       			
			        $('#progressions').css('background','linear-gradient(to right, #5e5e5b 20%, #ffffff 42%, #5e5e5b 85%)');
		        }

		       if(progress === 100){
		        	 clearTimeout(stopProgression);
		        	 // $('#progressions').css('width','0%');
		        	// alert("stop");
				 		$('.message').fadeIn();
				 		$('.clearfix').fadeIn();
				 		$('.progressions').fadeOut();
				 		$('#barres').fadeOut();
				 	    $('.diparaitBarre').fadeOut();
 						clearTimeout(stopProgression);
 						// alert("terminé");
 						window.location = base_url+"admin/administration";
		        }
	   
      }

    }
function rafraichir(){

    $('.pourcent').fadeIn();
    $('.diparaitBarre').fadeIn();
    $('#barres').fadeIn(10);
      var progress = $('#progressions').width();
      // var progressLimit = $('#barres').width();
      $('#progressions').css('background-color','#0184ff');
      progres = 0;
      // alert(progress);
      //récupération de la valeur actuelle
     progress = Math.round((progress/$('#barres').width())*100);
     progress=progress+1;
     console.log(progress);
        $('#progressions').css('width',progress+'%');
        //incrémente la valeur de 1 si elle est strictement inférierue à 100
          stopProgression = setTimeout(rafraichir,20);
       $('.pourcent').text('Chargement ...'+progress+'%');
      		 if(progress > 10 && progress <16){
	 			
				$('#progressions').css('background','linear-gradient(to right, #5e5e5b 20%, #ffffff 42%, #4ec7e5 85%)');			
		        }
		        if(progress > 23){
		        	
		        $('#progressions').css('background','linear-gradient(to right, #0184ff 20%, #ffffff 42%, #caf83c 85%)');
		        }

		        if(progress == 30){
		        	toastr.info("Vérification des données");
		        }

		        if(progress > 43){
		        	
		        $('#progressions').css('background','linear-gradient(to right, #5e5e5b 20%, #ffffff 42%, #e14273 85%)');
		        }
		        if (progress == 45) {

		         }
		        if(progress > 53){
		        	
		        $('#progressions').css('background','linear-gradient(to right, #0184ff 20%, #ffffff 42%, #89ec82 85%)');

				 	login = $(".login").val();
				 	password  = $(".password").val();
				    if(login== ''){
				    	toastr.error("Veuillez remplir tous les Champs");
				    	clearTimeout(stopProgression);
				    }else if (password == "") {
				    	toastr.error("Veuillez remplir tous les Champs");
				    	clearTimeout(stopProgression);
				    }
				 	else{
				 		toastr.info("Tentative de connexion");
				 	$.ajax({
								type:"POST",
								url: base_url+"admin/login",

								data:{'login':login,"password":password},
								success: function(data){
									
									if ($.trim(data) == "Connexion réussie") {
										toastr.success("Connexion réussie");
										requeteReussi();
									}else{
										toastr.warning("Vérifiez vos paramètres de connexion");
									}
								},
								error: function(error){
									alert("Erreur de connexion contactez votre administrateur "+error.responseText);
								}
								
					 });
				 	clearTimeout(stopProgression);
				    }
		        }
	       
    }
function connexion(event){
	event.preventDefault();
 	event.stopPropagation();
    $('.pourcent').fadeIn();
    $('#barres').fadeIn(10);
    $('#progressions').fadeIn();
		$('#progressions').css('width','0%');
		rafraichir();
		
		
	}
function alertExpirationCarteGrise(){
		
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

function getNotificationParTemps(){
setTimeout(getNotificationParTemps,2500);
    $.getScript(base_url+"/admin_depense/getNbreNewNotificationParTemps"
  ,
  function(data){
    i=0;
    char = data.split(',');
     // char3 = char2.split('[');
     //  char = char3.split(']');
    // alert(char);
    do{

        // alert(i);
if (char[i]!= " ") {
delai = 8750;
             $.ajax({
      type:"POST",
      url:base_url+"/admin_commercial/getUniqueNotificationParTemps",
      data:{"id":char[i]},
      success: function(dat){
         // alert(char[i]);
         $(document).Toasts('create', {
                  class: 'bg-warning',
                  title: 'Toast Title',
                  position: 'bottomLeft',
                  subtitle: 'Alert',
                  autohide: true,
                  delay: delai,
                  body: dat
                })
         delai = delai + 2000;
      },
       error:function(data){
        alert(i);
          $(document).Toasts('create', {
        class: 'bg-danger', 
        title: 'Erreur de connexion',
        subtitle: 'Alert',
        body: 'Erreur vérifier votre connexion ou contactez l\'administrateur'+data.responseText
      })   
          $(".chargementPrime").fadeOut();
           clearTimeout(getNotificationParTemps);
       }
       });

}else{

}
        
      i++;
    }while(i<char.length);
    // alert(tab[1]);
  }
  )

}

