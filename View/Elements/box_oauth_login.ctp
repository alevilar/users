<?php 
$this->start("css");
echo $this->Html->css('/risto/css/ristorantino/boxlogin_oauth'); 
$this->end();
?>
<script>
	window.fbAsyncInit = function() {
	    FB.init({
	      appId      : '<?php echo Configure::read("ExtAuth.Provider.Facebook.key")?>',
	      xfbml      : true,
	      version    : 'v2.10'
	    });
	    //FB.AppEvents.logPageView();

	    urlVerificarUsuario = "<?php echo Router::url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'fb_login', 'ext'=>'json')) ?>";

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
		        	console.info("respuesta del ME %o rta: %o", response, rta);
		        	console.info("2da rta %o", rta);
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
				console.info("primner rta %o de response %o", rta, response);
				if (rta && rta.hasOwnProperty("user") && rta.user ) {
					location.href = "/";
				} else {
					registrarUsuario();
				}
			}
		}


		$('#fb-login').on('click', function(){
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
</script>

<div class="box-oauth-login">

	<div class="p-login-media" role="group">




	    <span class="p-facebook">
	    	<?php 
	    	echo $this->Html->link('<span class="hide">Facebook</span>', 
	    		'#',
	    		 array(
	    		'id' => 'fb-login',
	    		'class'=>'btn btn-default btn-oauth btn-icon', 
	    		'escape'=>false)); ?>
    	</span>
	    <span class="p-google">
	    	<?php echo $this->Html->link('<span class="hide">Google</span>'
						, array('plugin'=>'users', 'controller'=>'users', 'action'=>'auth_login', 'google'), array('class'=>'btn btn-default btn-oauth btn-icon', 'escape'=>false)); ?>	    	
	    		    	
    	</span>
	</div>

</div>

