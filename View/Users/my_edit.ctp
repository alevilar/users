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
<div class="users form col-sm-4 col-sm-offset-4">
	<?php echo $this->Form->create($model); ?>
	<?php echo $this->Form->input('id') ?>
		<fieldset>
			<legend><?php echo __d('users', 'Edit User'); ?></legend>
			<p>
				<?php echo $this->Html->link(__d('users', 'Change your password'), array('action' => 'change_password')); ?>
			</p>
			<p>
				<?php echo $this->Form->input('username') ?>
			</p>
			<p>
				<?php echo $this->Form->input('email') ?>
			</p>
		</fieldset>
	<?php echo $this->Form->end(__d('users', 'Submit')); ?>



	<?php if ( $socialProfiles ) {?>
		<h3>Redes Sociales Vinculadas</h3>
		<ul>
		<?php
		// variables para ver si hay red social facebook o google
		$fb = $gg = false;
		foreach($socialProfiles as $sp ) {
			$dataRaw = json_decode($sp['SocialProfile']['raw']);
			if (!empty($dataRaw->link)) {
				// miro si es de facebook o google para luego mostrar
				// como DISABLED el link de box_oauth_login
				echo "<li>".$this->Html->link($sp['SocialProfile']['provider'], $dataRaw->link, array('target'=>'_blank'))."</li>";
			} else {
				echo "<li>".$sp['SocialProfile']['provider']."</li>";
			}
			if (  $sp['SocialProfile']['provider'] == 'Facebook' ) {
				$fb = true;
			}
			if ( $sp['SocialProfile']['provider'] == 'Google' ) {
				$gg = true;
			}
		}	
		?>
		</ul>
	<?php } ?>

	<h3>Vincular cuentas Sociales</h3>
	<div class="text-center">
		<?php echo $this->element('Users.box_oauth_login');?>
	</div>
</div>

<?php if ($fb) :?>
	<?php $this->append("script");?>
	<script type="text/javascript">
		$('.p-facebook a').addClass('disabled');
	</script>
	<?php $this->end()?>
<?php endif;?>

<?php if ($gg) :?>
	<?php $this->append("script");?>
	<script type="text/javascript">
		$('.p-google a').addClass('disabled');
	</script>
	<?php $this->end()?>
<?php endif;?>