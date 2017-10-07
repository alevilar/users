window.fbAsyncInit = function() {
	    FB.init({
	      appId      : Risto.APPID,
	      xfbml      : true,
	      version    : 'v2.10'
	    });
	    //FB.AppEvents.logPageView();

	    urlVerificarUsuario = Risto.URLVERIFICARUSUARIO;

	    function sendAjax(url, data, fnDone){
	    	$.ajax(urlVerificarUsuario, {
				type:"POST",
				data: data
			})
			.done(fnDone)
			.error(function(rta){
				alert("Ha ocurrido un error, porfavor, intentalo de nuevo o contacta con soporte@paxapos.com");
			});
	    }

	    function registrarUsuario() {
			FB.api('/me?fields=first_name, last_name, picture, email, gender, link', function(response) {

		        sendAjax(urlVerificarUsuario, response, alDone);

		        function alDone(rta){
					location.href = "/";
		        }
	  		});
	  	}

	    function cuandoSeLoguea(response) {
			if (response.status === 'connected') {
				sendAjax(urlVerificarUsuario, response, alDone);
			} else {
				alert("error al loguearse: no has iniciado sesión en Facebook");
			}

			function alDone(rta){
				if (rta && rta.hasOwnProperty("user") && rta.user ) {
					location.href = "/";
				} else {
					registrarUsuario();
				}
			}
		}


		$('.fb-login').on('click', function(){
			FB.login(cuandoSeLoguea,{scope: ['public_profile', 'email']});
		});

	}; // fin fbAsyncInit

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/es_LA/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));