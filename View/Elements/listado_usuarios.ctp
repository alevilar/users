<div class="btn-group pull-right">
	<?php echo $this->Html->link(__('Crear nuevo %s', __('Usuario')), array('admin'=>true,'plugin'>'users', 'controller'=> 'SiteUsers', 'action'=>'add'), array('class'=>'btn btn-success btn-lg btn-add')); ?>	
	</div>

	<h2><?php echo __d('users', 'Users'); ?></h2>
<br>
	<?php
		if (CakePlugin::loaded('Search')) {
		?>
		<div class="row">               
		<?php
		if(empty($adminPanel)) {
			$controlador = 'SiteUsers';
		} else {
			$controlador = 'users';
		}
		echo $this->Form->create('User', array('url' => array('controller' => $controlador,'action' => 'index')));
		?>		
        <div class="col-xs-6 col-sm-6 col-md-6">                
		<?php echo $this->Form->input('txt_search', array('label' => false, 'placeholder' => 'Escribe aquí datos del usuario buscado para realizar una busqueda.'));?>
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6">               
        <?php echo $this->Form->submit('Buscar', array('class' => 'btn btn-default'));?>
        </div>      
		<?php echo $this->Form->end();?>
		</div>
	<?php
		}
	?>
    <div class="center">
	<?php echo $this->element('Users.paging'); ?>
	</div>
	<table class="table">
		<tr>
			<th><?php echo $this->Paginator->sort('username','Nombre de usuario'); ?></th>
			<th><?php echo $this->Paginator->sort('email', 'E-Mail'); ?></th>
		<?php if (empty($adminPanel)) { ?>	<th><?php echo __('Rol'); ?></th> <?php } ?>
			<th><?php echo $this->Paginator->sort('active','Activo'); ?></th>
			<th><?php echo $this->Paginator->sort('last_login','Ultima vez conectado'); ?></th>
			<th class="actions"><?php echo __d('users', 'Acciones'); ?></th>
		</tr>
			<?php
			$i = 0;
			$userOffset = 0;
			foreach ($users as $user):
				$class = null;
				if ($i++ % 2 == 0) :
					$class = ' class="altrow"';
				endif;
			?>
			<tr<?php echo $class;?>>
				<td>
					<?php echo $user[$model]['username']; ?>
				</td>
				<td>
					<spam class="email-verified"><?php echo $user[$model]['email_verified'] == 1 ? "✓" : "✕"; ?></spam>
					<?php echo $user[$model]['email']; ?>
				</td>

				<?php
				if (empty($adminPanel)) {
				?>
				<td>
				<?php
					$roles = '';
					if (array_key_exists('Rol', $user)) {
						foreach ($user['Rol'] as $rol ) {
							$roles .= ", " .$rol['name'];
						} 
						echo trim($roles, ',');
					}
				?>
				</td>
				<?php
				  }
				?>

				<td>
					<?php echo $user[$model]['active'] == 1 ? __d('users', 'Yes') : __d('users', 'No'); ?>
				</td>
				<td>
					<?php 
					echo $user[$model]['last_login'] ?
							$this->Time->nice( $user[$model]['last_login'])
							: __d('users','Nunca'); 
					?>
				</td>
				<td class="actions">

                <div class="btn-group">
                  <?php echo $this->Html->link(__('Editar'), array('action'=>'edit', $user[$model]['id']), array('class'=>'btn btn-default btn-sm btn-edit')); ?>

                  <button type="button" class="btn btn-default  btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu">
                  <?php

                  if (empty($userPanel)) {
                   	$controlador = 'users';
                   	$accion = 'delete';
                   	$buttonName = 'Borrar Usuario';
                   	$mensaje = '¿Estas seguro que quieres borrar a %s de PaxaPos?';
                   } else {
                   	$controlador = 'SiteUsers';
                   	$accion = 'delete_from_tenant';
                   	$buttonName = 'Quitar del comercio';
                   	$mensaje = '¿Estas seguro que quieres desvincular a %s de tu comercio?';
                   }
                  ?>
                  <li class="">
                  <?php
                  echo $this->Html->Link(__d('users', 'Añadir a otro comercio'), 
                  array('controller' => 'SiteUsers', 'action' => 'assign_other_site', $user[$model]['id']), 
                  array('class' => 'btn-add')); 

                  if (empty($adminPanel)) {
                  $siteOffset = 0;
                  $userOnSite = 0;
                  

                  	while(!empty($users[$userOffset]['Site'][$siteOffset])) { //si el indice no esta vacio...
                  	 if ($users[$userOffset]['Site'][$siteOffset]['alias'] == $site_alias) {
                       $userOnSite = $userOnSite + 1; /*se comprueba que el alias sea igual al alias del tenant actual
                                                      Si es igual, se suma uno.*/
                     }
                     $siteOffset = $siteOffset + 1;
                   }
                   $userOffset = $userOffset + 1;

                   if($userOnSite >= 1) { //Si es igual o mayor a uno, muestra el botón de quitar del comercio.
                    echo $this->Form->postLink(__d('users', $buttonName), 
                  	array('controller' => $controlador, 'action' => $accion, $user[$model]['id']), null, 
                  	sprintf(__d('users', $mensaje), $user[$model]['username']));
                       } else { //Sino, muestra el de agregar.
                  ?>
                   <?php 
                    echo $this->Html->Link(__d('users', 'Añadir al comercio actual'), 
                   	array('controller' => 'SiteUsers', 'action' => 'add_existing', $user[$model]['id']), 
                   	array('class' => 'btn-add')); 
                      }
                  } else { //Si $adminPanel esta vacio, muestra el botón de borrar usuario del sistema.         
                   echo $this->Form->postLink(__d('users', $buttonName), array('controller' => $controlador, 'action' => $accion, $user[$model]['id']), null, sprintf(__d('users', $mensaje), $user[$model]['username']));
                  }
                   ?>
                  </li>
                  </ul>
                </div>
					
					
				</td>
			</tr>
		<?php 
		endforeach; ?>
	</table>
	<?php echo $this->element('Risto.pagination'); ?>