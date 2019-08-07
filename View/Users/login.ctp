<?php
/**
 * Copyright 2010 - 2014, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010 - 2014, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

<div class="row">
	<div class="col-sm-12 center">
 <?php if(!$this->request->is('mobile')) { ?> 		
		<h2><?php echo __('Ingresá o Registrate Usando Facebook o Google') ?></h2>
		<?php
		// box Login OAUTH
		echo $this->element('Users.box_oauth_login'); 
}
		?>

		<h1><?php echo __('O') ?></h1>
	</div>
</div>


<div class="row">
		


	<div class="login text-center col-md-6 col-sm-12">	
	

		<div class="row">

			<div class="col-md-10 col-md-offset-1">
			<h3 class="blue">Ingresar con cuenta PaxaPos</h3>
				<?php 
				if ( !$this->Session->check('Auth.User')){
					echo $this->element('Users.boxlogin');			
			} else {		
			 ?>
				<h3>&nbsp;</h3>
				<?php echo $this->Html->link(__('Add New Site'), array('plugin'=>'mt_sites', 'controller'=>'sites', 'action'=>'install'), array('class'=>'btn btn-success btn-lg center')); ?>

				<h1>Mis Sitios</h1>
				
				<div class="list-group">
					<?php App::uses('MtSites', 'MtSites.MtSites'); ?>
					<?php if ( $this->Session->check('Auth.User.Site') ): ?>
						<?php foreach ( $this->Session->read('Auth.User.Site') as $s ): ?>
							<?php echo  $this->Html->link( $s['name'] , array( 'tenant' => $s['alias'], 'plugin'=>'risto' ,'controller' => 'pages', 'action' => 'display', 'dashboard' ), array('class'=>'list-group-item' ));?>
						<?php endforeach; ?>
					<?php endif; ?>

				 </div>
			<?php } ?>
			</div>
		</div>
	</div>

	<div class="user-login text-center col-md-6 col-sm-12">	
		<div class="row">

			<div class="col-md-10 col-md-offset-1 bg-red white">
				<div class="users form">
				<h3><?php echo __d('users', 'Abrir nueva cuenta PaxaPos'); ?></h3>
				<fieldset>
					<?php
						echo $this->Form->create($model, array('url'=>array('plugin'=>'users','controller'=>'users', 'action'=>'register')));
						echo $this->Form->input('username', array(
							'label' => __d('users', 'Username')));
						echo $this->Form->input('email', array(
							'label' => __d('users', 'E-mail (used as login)'),
							'error' => array('isValid' => __d('users', 'Must be a valid email address'),
							'isUnique' => __d('users', 'An account with that email already exists'))));
						echo $this->Form->input('password', array(
							'label' => __d('users', 'Password'),
							'type' => 'password'));
						echo $this->Form->input('temppassword', array(
							'label' => __d('users', 'Password (confirm)'),
							'type' => 'password'));
						echo $this->Form->input('paxa_captcha', array(
                            'label' => __d('users', 'Captcha: ¿Cúanto es 7+3?'),
                            'id' => 'PaxaCaptcha',
                            'required' => true,
                            'type' => 'number'));
						$tosLink = $this->Html->link(__d('users', 'Terms of Service'), array('controller' => 'pages', 'action' => 'tos', 'plugin' => null));
						echo $this->Form->input('tos', array(
							'label' => __d('users', 'I have read and agreed to ') . $tosLink));

						echo $this->Form->submit(__d('paxapos', 'Crear cuenta PaxaPos'), array('class'=>'btn btn-primary btn-block'));
						echo $this->Form->end();
					?>
					<br>
				</fieldset>
			</div>
		</div>
	</div>

	</div>
</div>
<?php 
echo $this->append('script');
    echo $this->Html->script('Risto.simple_captcha'); 
echo $this->end();
?>