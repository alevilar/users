
<?php echo $this->Html->css('/risto/css/ristorantino/boxlogin'); ?>
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Tangerine">


<div class="p-login text-center">	
		
		
		<?php

		
		echo $this->Form->create('User', array('type'=>'post','url'=> array( 'full_base' => true,'plugin'=>'users','controller'=>'users','action'=>'login'), 'role'=>'form'));

		echo $this->Form->input('email',array('placeholder'=>'Email', 'label'=>false));
		echo $this->Form->input('password', array('type'=>'password','placeholder'=>'Contraseña', 'label'=>false));

	

		echo $this->Html->link('Olvidé la contraseña',
		array('plugin'=>'users', 'controller'=>'users', 'action'=>'reset_password'),
		array(
			'style'=>'margin-bottom: 5px; display: block;',
			'class'=>'small')
		);
		

		
		
		echo $this->Form->button('Ingresar <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
', array('type'=>'submit', 'class'=>'btn btn-lg btn-primary btn-block btn-ico', "escape"=>false));		

		echo $this->Form->end();
		
?>	
		
</div>

