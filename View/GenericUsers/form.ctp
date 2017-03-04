
<?php echo $this->Form->create('GenericUser'); ?>

<h4>Usuario: <?php echo $rolName; ?></h4>

<?php echo $this->Form->input('id'); ?>
<?php echo $this->Form->hidden('rol_id'); ?>

<?php echo $this->Form->input('pin', array(
		'class'=>'form-control input-lg',
		'maxlength' => 4,
		'minlength' => 4,
		)
	); ?>

<?php echo $this->Form->submit('Guardar', array('class' => 'btn btn-success')); ?>
<?php echo $this->Form->end(); ?>