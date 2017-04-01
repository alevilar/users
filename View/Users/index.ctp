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
$this->element("Risto.layout_modal_edit");
?>
<div class="users index content-white">

	

	<h2><?php echo __d('users', 'Users'); ?></h2>
	<br>

	<?php
		if (CakePlugin::loaded('Search')) {
		?>
		<div class="row">               
		<?php
		
		echo $this->Form->create('User');
		?>		
		<div class="col-xs-6 col-sm-6 col-md-6">                
		<?php echo $this->Form->input('txt_search', array('label' => false, 'placeholder' => 'Escribe aquí datos del usuario buscado para realizar una busqueda.'));?>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6">               
		<?php echo $this->Form->submit('Buscar usuario PaxaPos', array('class' => 'btn btn-default'));?>
		</div>      
		<?php echo $this->Form->end();?>
		</div>
	<?php
		}
	?>

	
	<?php echo $this->element('Users.listado_usuarios', array('adminPanel' => true)); ?>

</div>
