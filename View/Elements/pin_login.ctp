
<h1 class="center black-5">PIN</h1>
<?php echo $this->Form->create('GenericUser', array( 'id'=>'pinForm'));?>

			<?php echo $this->Form->password('k1', array(
				'class' => 'form-control input-lg pin',
				'id' => 'pin1',
				'maxlength' => 1
			))?>
			<?php echo $this->Form->password('k2', array(
				'class' => 'form-control input-lg pin',
				'id' => 'pin2',
				'maxlength' => 1
			))?>
			<?php echo $this->Form->password('k3', array(
				'class' => 'form-control input-lg pin',
				'id' => 'pin3',
				'maxlength' => 1
			))?>
			<?php echo $this->Form->password('k4', array(
				'class' => 'form-control input-lg pin pin input-block',
				'id' => 'pin4',
				'maxlength' => 1
			))?>

<?php echo $this->Form->end();?>
<?php echo $this->Html->script("Users.pin_login"); ?>