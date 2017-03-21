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
<h3>Usuario: <?php echo $user['User']['username'];?></h3>
<?php 
echo $this->Form->create($model, array('type'=>'post')); 
?>
		<fieldset>

<?php echo $this->Form->select('site', array($sites), 
	  array('class' => 'form-control', 'empty' => 'Seleccione el sitio')); ?>
<br>
<?php echo $this->Form->select('rol', array($roles), 
	  array('class' => 'form-control', 'empty' => 'Seleccione el rol')); ?>
<br>
		</fieldset>
	<?php echo $this->Form->button('Enviar', array('class'=>'btn btn-success')); ?>		
	<?php echo $this->Html->link(__('Cancelar'), array('action'=>'index'), array('class'=>'btn btn-default') ); ?>

	<?php echo $this->Form->end(); ?>
</div>
