<div class="row">
	<h4>Ingresa con tu cuenta de...</h4>
	<div class="col-md-6"><?php echo $this->Html->link('Google', array('plugin'=>'users', 'controller'=>'users', 'action'=>'auth_login', 'google'), array('escape'=>false, 'class'=>'btn-google')); ?></div>
	<div class="col-md-6"><?php echo $this->Html->link('Facebook', array('plugin'=>'users', 'controller'=>'users', 'action'=>'auth_login', 'facebook'), array('escape'=>false, 'class'=>'btn-facebook')); ?></div>
	<!--
	<div class="col-md-4"><?php echo $this->Html->link('Twitter', array('plugin'=>'users', 'controller'=>'users', 'action'=>'auth_login', 'twitter'), array('escape'=>false, 'class'=>'btn-twitter btn-disabled')); ?></div>
	-->
</div>


<div class="row">
	<div class="users index col-md-12">
		<h2><?php echo __d('users', 'Login'); ?></h2>
		<?php echo $this->Session->flash('auth');?>
		<fieldset>
			<?php
				echo $this->Form->create($model, array(
					'action' => 'login',
					'id' => 'LoginForm'));
				echo $this->Form->input('email', array(
					'label' => __d('users', 'Email')));
				echo $this->Form->input('password',  array(
					'label' => __d('users', 'Password')));

				echo '<p>' . $this->Form->input('remember_me', array('type' => 'checkbox', 'label' =>  __d('users', 'Remember Me'))) . '</p>';
				echo '<p>' . $this->Html->link(__d('users', 'I forgot my password'), array('action' => 'reset_password')) . '</p>';

				echo $this->Form->hidden('User.return_to', array(
					'value' => $return_to));
				echo $this->Form->end(__d('users', 'Submit'));
			?>
		</fieldset>
	</div>
</div>

	


<div class="row">
<br><br>
	<div class="col-md-12">
	<?php echo $this->Html->link(__('Regístrate como nuevo Usuario!'), array('plugin'=>'users', 'controller'=>'users', 'action'=>'add'), array('class'=>'btn btn-success btn-block btn-lg')); ?>
	</div>
</div>