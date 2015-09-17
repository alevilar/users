<?php //echo $this->Html->css('Paxapos.oauth_login'); ?>

<div class="box-oauth-login">
	<h3><?php echo __('... o ingresa Usando') ?></h3>


	<div class="p-login-media" role="group">
	    <span class="p-facebook">
	    	<?php echo $this->Html->link('<span class="p-hide">Facebook</span>', array('plugin'=>'users', 'controller'=>'users', 'action'=>'auth_login', 'facebook'), array('class'=>'btn btn-default navbar-btn btn-oauth', 'escape'=>false)); ?>
    	</span>
	    <span class="p-google">
	    	<?php echo $this->Html->link('<span class="p-hide">Google</span>'
						, array('plugin'=>'users', 'controller'=>'users', 'action'=>'auth_login', 'google'), array('class'=>'btn btn-default navbar-btn btn-oauth', 'escape'=>false)); ?>	    	
	    		    	
    	</span>
	</div>

	<div class="text-info">Si ingresas utilizando tu cuenta de Google o Facebook no necesitás registrarte como nuevo usuario. Simplemente usas tus cuentas existentes para ingresar a PaxaPos y disfrutar de todos nuestros servicios gratuitos.</div>

</div>