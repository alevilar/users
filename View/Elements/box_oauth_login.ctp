<?php 
$this->start("css");
echo $this->Html->css('/risto/css/ristorantino/boxlogin_oauth'); 
$this->end();
?>
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1479768915624619',
      xfbml      : true,
      version    : 'v2.10'
    });
    FB.AppEvents.logPageView();

    urlVerificarUsuario = '<?php echo Router::url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'fbLogin')) ?>';

    function cuandoSeLoguea(response) {
	  if (response.status === 'connected') {
	    userID = response.authResponse.userID;
		FB.api('/me?fields=first_name, last_name, picture, email, gender', function(response) {
        user_email = response.email;
        provider = "Facebook"; //Por el momento va a ser facebook, posteriormente se actualizara gmail.
        first_name = response.first_name;
        last_name = response.last_name;
        gender = response.gender;

        
		$.ajax(urlVerificarUsuario, {
							type:"POST",
		    				data:{
		    					oid: userID,
		    					email: user_email,
		    					provider: provider,
		    					given_name: first_name,
		    					family_name: last_name,
		    					gender: gender,
		    				}
		    			}).done(function(rta){
		 					location.href = "/";
		    			})
		    			.error(function(rta){
		    				alert("Ha ocurrido un error, porfavor, intentalo de nuevo o contacta con soporte@paxapos.com");
		    			});
        });

	    


	  } else {
	    alert("error al loguearse: no has iniciado sesión en Facebook");
	  }
	}


	$('#fb-login').on('click', function(){
		FB.login(cuandoSeLoguea,{scope: ['public_profile', 'email']});
	});

  };

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

