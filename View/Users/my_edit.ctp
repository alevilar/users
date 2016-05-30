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
</div>
