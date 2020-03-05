<div class="roles form content-white">
<?php echo $this->Form->create('Rol');?>
	<fieldset>
		<?php if(!empty($this->request->data['Rol']['id'])) { ?>
			<legend><?php echo __('Editar Usuario Generico'); ?></legend>
		<?php} else { ?>
			<legend><?php echo __('Añadir Usuario Generico'); ?></legend>
		<?php } ?>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name', array('label' => 'Nombre'));
		echo $this->Form->input('machin_name', array('label' => 'Rol', 'type' => 'select', 'options' => $roles_machine_names));
	?>
	</fieldset>
<?php echo $this->Form->end(array('label' => 'Guardar', 'class' => 'btn btn-primary btn-lg btn-block'));?>
</div>