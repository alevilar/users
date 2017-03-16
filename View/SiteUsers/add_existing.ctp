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

			<legend><?php echo __d('users', 'Añadir usuario en %s', $site['Site']['name']); ?></legend>
			


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


			<?php echo $this->Form->button(__('Añadir usuario existente en mi comercio'), array('class'=>'btn btn-danger')); ?>		

			<?php echo $this->Html->link(__('Cancelar'), array('action'=>'index'), array('class' => 'btn btn-default pull-right')); ?>

	
	<?php echo $this->Form->end(); ?>
</div>
