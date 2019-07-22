
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
				'class' => 'form-control input-lg pin input-block',
				'id' => 'pin4',
				'maxlength' => 1
			))?>

<?php echo $this->Form->end();?>

<?php if(!$this->request->is('mobile')) { ?> 
	<div class="simple-keyboard"></div>
	<?php $this->append('css') ?>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simple-keyboard@latest/build/css/index.css">
	<?php $this->end() ?>
	<script src="https://cdn.jsdelivr.net/npm/simple-keyboard@latest/build/index.min.js"></script>
	<?php echo $this->Html->script("Users.pin_keyboard"); ?>
<?php } ?>

<?php echo $this->Html->script("Users.pin_login"); ?>