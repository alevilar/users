<div class="user-login">	
		<?php echo $this->element('Users.box_oauth_login'); ?>

		<h1><?php echo __('Login') ?></h1>
		<?php
		echo $this->Form->create('User', array('type'=>'post','url'=>array( 'plugin'=>'users','controller'=>'users','action'=>'login'), 'role'=>'form'));

		echo $this->Form->input('email',array('placeholder'=>'Email', 'label'=>false));
		echo $this->Form->input('password', array('type'=>'password','placeholder'=>'Contraseña', 'label'=>false));

	

		echo $this->Html->link('Olvidé la contraseña',
		array('plugin'=>'users', 'controller'=>'users', 'action'=>'reset_password'),
		array(
			'style'=>'margin-bottom: 5px; display: block;',
			'class'=>'small')
		);
		

		
		
		echo $this->Form->button('Entrar', array('type'=>'submit', 'class'=>'btn btn-primary btn-block'));		

		echo $this->Form->end();
		?>
</div>