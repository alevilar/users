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
$this->element("Risto.layout_modal_edit", array('title' => 'Vinculación de Usuario con tu Comercio'));


?>
<div class="users index content-white">
<div class="btn-group pull-right">
		<?php echo $this->Html->link(__('Crear nuevo %s', __('Usuario')), array('plugin'=>'mt_sites', 'controller'=> 'site_users', 'action'=>'add'), array('class'=>'btn btn-success btn-lg btn-add')); ?>	
</div>
	
<h2><?php echo $title ?></h2>
<br>


<?php echo $this->element('Users.listado_usuarios'); ?>

</div>
