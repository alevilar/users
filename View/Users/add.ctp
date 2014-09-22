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

			<p class="alert alert-info text-info">
				
				Al crear un nuevo usuario desde aqui existen 2 opciones: 
					<br>&nbsp;&nbsp;- <b>Que la combinación del nombre de usuario y contraseña existan previamente</b>. En ese caso se le da permisos al usuario existente para que pueda trabajar en su Sitio
					<br>&nbsp;&nbsp;- <b>Que el nombre de usuario y contraseña NO existan</b>. En ese caso creará un usuario nuevo.
			</p>


			<?php if ( !empty($this->request->data[$model]['is_existing_user'])){ ?>
				<p class="alert alert-warning dismiss">El Usuario ya existe en el Sistema</p>
			<?php } ?>

			<?php
				echo $this->Form->input('id');
				

				if (!empty($sites)) {
					echo $this->Form->input('Site', array(
						'label' => __d('users', 'Site')
						));
				}


				if ( !empty($this->request->data[$model]['is_existing_user'])){
					echo $this->Form->hidden('confirm_add_existing_user', array('value'=>true));
				}
			
				echo $this->Form->hidden('active', array('value'=>true));
				echo $this->Form->hidden('tos', array('value'=>true));

			?>
		</fieldset>

		<?php if ( !empty($this->request->data[$model]['is_existing_user'])){ ?>

			<?php
				echo $this->Form->input('username_fake', array(
					'label' => __d('users', 'Username'),
					'disabled' => true,
					'value' => $this->request->data[$model]['username'],
					));
				echo $this->Form->input('email_fake', array(
					'label' => __d('users', 'Email'),
					'disabled' => true,
					'value' => $this->request->data[$model]['email'],
					));

				echo $this->Form->hidden('username');
				echo $this->Form->hidden('email');
				if (!empty($roles)) {
					echo $this->Form->input('Rol', array(
						'label' => __d('users', 'Role'),
						));
				}

			?>


			<?php echo $this->Form->button(__('Add Existing User into My Site'), array('class'=>'btn btn-danger')); ?>		
			<?php echo $this->Html->link(__('Back and select other username & password'), array('action'=>'add'), array('class'=>'btn btn-default') ); ?>
		<?php } else { ?>

			<?php

				echo $this->Form->input('username', array(
					'label' => __d('users', 'Username')
					));
				echo $this->Form->input('email', array(
					'label' => __d('users', 'Email')));
				if (!empty($roles)) {
					echo $this->Form->input('Rol', array(
						'label' => __d('users', 'Role')
						));
				}

			?>


			<?php echo $this->Form->button(__('Create New User'), array('class'=>'btn btn-success')); ?>	
			<?php echo $this->Html->link(__('Cancel'), array('action'=>'index'), array('class'=>'btn btn-default') ); ?>	
		<?php } ?>

	
	<?php echo $this->Form->end(); ?>
</div>
