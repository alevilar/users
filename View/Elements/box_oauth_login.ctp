<?php echo $this->Html->css('Paxapos.oauth_login'); ?>

<div class="box-oauth-login">
	<h1><?php echo __('Ingresa Usando') ?></h1>
		<div class="oauth-account google">
			<?php echo $this->Html->link('Google'
						, array('plugin'=>'users', 'controller'=>'users', 'action'=>'auth_login', 'google'), array('class'=>'btn-google')); ?>
		</div>

		<div class="oauth-account facebook">
			<?php echo $this->Html->link('Facebook', array('plugin'=>'users', 'controller'=>'users', 'action'=>'auth_login', 'facebook'), array('class'=>'btn-facebook')); ?>
		</div>

		<!--
		<div class="col-md-4"><?php echo $this->Html->link('Twitter', array('plugin'=>'users', 'controller'=>'users', 'action'=>'auth_login', 'twitter'), array('escape'=>false, 'class'=>'btn-twitter btn-disabled')); ?></div>
		-->
</div>