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
				if (!empty($roles)) {
					echo $this->Form->select('Rol', array($roles), 
						array('class' => 'form-control', 
							  'empty' => 'Seleccionar rol del usuario')
						);
				}
			?>
			<br>

			<?php echo $this->Form->button(__('Añadir usuario existente en mi comercio'), array('class'=>'btn btn-primary')); ?>		

			<?php echo $this->Html->link(__('Cancelar'), array('action'=>'index'), array('class' => 'btn btn-default pull-right')); ?>

	
	<?php echo $this->Form->end(); ?>
</div>
