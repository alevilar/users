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


<div class="col-md-4 col-md-offset-4 login">
	<div class="row">

		<div class="col-md-12">
			<?php 
			if ( !$this->Session->check('Auth.User')){
				echo $this->element('Users.boxlogin');			
		} else {		
		 ?>
			<h3>&nbsp;</h3>
			<?php echo $this->Html->link(__('Add New Site'), array('plugin'=>'mt_sites', 'controller'=>'sites', 'action'=>'install'), array('class'=>'btn btn-success btn-lg center')); ?>

			<h1>Mis Sitios</h1>
			
			<div class="list-group">
				<?php App::uses('MtSites', 'MtSites.MtSites'); ?>
				<?php if ( $this->Session->check('Auth.User.Site') ): ?>
					<?php foreach ( $this->Session->read('Auth.User.Site') as $s ): ?>
						<?php echo  $this->Html->link( $s['name'] , array( 'tenant' => $s['alias'], 'plugin'=>'risto' ,'controller' => 'pages', 'action' => 'display', 'dashboard' ), array('class'=>'list-group-item' ));?>
					<?php endforeach; ?>
				<?php endif; ?>

			 </div>
		<?php } ?>
		</div>
	</div>
</div>