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
<div class="users form">
	<?php echo $this->Form->create($model, array('type'=>'post')); ?>
		<fieldset>

			<legend><?php echo __d('users', 'Add User'); ?></legend>


			<?php
				echo $this->Form->input('id');
				

				echo $this->Form->hidden('active', array('value'=>true));
				echo $this->Form->hidden('tos', array('value'=>true));

			?>
		</fieldset>



			<?php

				echo $this->Form->input('username', array(
					'label' => __d('users', 'Username'),
					 'required' => true,
					 'pattern' => "[a-zA-Z0-9 _-]+",
					 'oninvalid' => "setCustomValidity('Solo se permite: caracteres alfabñeticos, números, espacios y guiones. No ingresar otros símbolos')"
					));
				echo $this->Form->input('email', array(
					'label' => __d('users', 'Email'),
					'type' => 'email',
					));
				if (!empty($roles)) {
					echo $this->Form->input('Rol', array(
						'label' => __d('users', 'Role')
						));
				}

				echo $this->Form->input('password', array(
					'label' => __d('users', 'Password'),
					'type' => 'password'));
				echo $this->Form->input('temppassword', array(
					'label' => __d('users', 'Password (confirm)'),
					'type' => 'password'));

			?>


			<?php echo $this->Form->button(__('Create New User'), array('class'=>'btn btn-success')); ?>	
			<?php echo $this->Html->link(__('Cancel'), array('action'=>'index'), array('class'=>'btn btn-default') ); ?>	
		

	
	<?php echo $this->Form->end(); ?>
</div>
