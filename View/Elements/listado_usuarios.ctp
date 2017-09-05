<?php
if (empty($modelName)) {
	$modelName = $model;
}

if ( !isset($adminPanel) ) {
	$adminPanel = false;
}

?>


	<div class="center">
	<?php echo $this->element('Users.paging'); ?>
	</div>
	<table class="table">
		<tr>
			<th><?php echo $this->Paginator->sort('username','Nombre de usuario'); ?></th>

			<?php if ( $adminPanel ) { ?>
				<th><?php echo $this->Paginator->sort('email','E-Mail'); ?></th>
			<th>Sitios</th>
			<?php } ?>
			<th>Roles</th>
			<th><?php echo $this->Paginator->sort('active','Activo'); ?></th>
			<th><?php echo $this->Paginator->sort('created','en PaxaPos desde'); ?></th>
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
					<?php echo $user[$modelName]['username']; ?>
				</td>

				<?php if ( $adminPanel ) { ?>
				<td>
					<spam class="email-verified"><?php echo $user[$modelName]['email_verified'] == 1 ? "✓" : "✕"; ?></spam>
					<?php echo $user[$modelName]['email']; ?>
				</td>
				<?php } ?>


				<td>
				<?php
				if ( $adminPanel ) {
					if (array_key_exists('Site', $user)) {
						$sites = '';
						foreach ($user['Site'] as $site ) {
							$sites .= "- ".
							$this->Html->link( $site['name'], array('tenant' => $site['alias'], 'plugin'=>'risto', 'controller' => 'pages', 'action' => 'display','dashboard') ).
							$this->Html->link("<span class='glyphicon glyphicon-remove'></span>", 
								array('plugin' => 'mt_sites', 'controller' => 'SiteUsers', 'action' => 'desvincular_del_site', $user['User']['id'], $site['alias']), array('escape' => false, 'class' => 'btn btn-sm'), sprintf(__('¿Seguro que quieres desvincular a '.$user['User']['username'].' del sitio '.$site['name'].'?')))
							."<br>";
						} 
						echo trim( $sites, "," );
					}
				}
				?>
				</td>

				<td>
				<?php
					$roles = '';
					if (array_key_exists('Rol', $user)) {
						foreach ($user['Rol'] as $rol ) {
							$roles .= ", " .$rol['name'];
						}
						echo trim($roles, ',');
					} else if (array_key_exists('SuperRol', $user)) {
						foreach ($user['SuperRol'] as $rol ) {
							$roles .= ", " .$rol['name'];
						} 
						echo trim($roles, ',');
					}
				?>
				</td>

				<td>
					<?php echo $user[$modelName]['active'] == 1 ? __d('users', 'Yes') : __d('users', 'No'); ?>
				</td>

				<td>
					<?php echo $this->Time->niceShort( $user[$modelName]['created'] ); ?>
				</td>


				<td>
					<?php 
					echo $user[$modelName]['last_login'] ?
							$this->Time->niceShort( $user[$modelName]['last_login'])
							: __d('users','Nunca'); 
					?>
				</td>
				<td class="actions">

				<div class="btn-group">

				<?php if ( $adminPanel ) { ?>
					  <?php echo $this->Html->link(__('Editar'), array('plugin'=>'users', 'action'=>'edit', $user[$modelName]['id']), array('class'=>'btn btn-default btn-sm btn-edit')); ?>

					  <button type="button" class="btn btn-default  btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class="caret"></span>
						<span class="sr-only">Toggle Dropdown</span>
					  </button>
					  <ul class="dropdown-menu">
					  

					  <li class="">
					  <?php
					  echo $this->Html->Link(__d('users', 'Añadir a otro comercio'), 
					  							array('plugin'=>'mt_sites','controller' => 'SiteUsers', 'action' => 'assign_other_site', $user[$modelName]['id']), 
					  							array('class' => 'btn-add')); 

					  echo $this->Html->link(__('Editar Roles'),
					  					array('plugin'=>'users','controller'=>'superRoles', 'action'=>'edit_for_user', $user[$modelName]['id']),
					  					array('class' => 'btn-edit') 
					  	);

					  if ( !$user[$modelName]['deleted'] ) {
					  	echo $this->Form->postLink(__d('users', "Borrar"), array('plugin'=>'users', 'controller' => 'users', 'action' => 'delete' , $user[$modelName]['id']), null, sprintf(__d('users', "Está por eliminar al usuario \"%s\". ¿Seguro desea borrarlo?", $user[$modelName]['username'])));
					  } else {
					  	echo $this->Html->link(__d('users', "Restaurar"), array('plugin'=>'users', 'controller' => 'users', 'action' => 'restaurar', $user[$modelName]['id']));
					  }
					   ?>
					  </li>
					  </ul>
					  <?php } else { ?>

					  	<div class="btn-group">

						  	<?php  echo $this->Html->link(__('Editar Roles'),
						  					array('plugin'=>'users','controller'=>'roles', 'action'=>'edit_for_user', $user[$modelName]['id']),
						  					array('class' => 'btn  btn-sm  btn-primary btn-edit') 
						  	);
						  	?>

						  	<?php  echo $this->Form->postLink(__('Desvincular del Comercio'),
						  					array('plugin'=>'mt_sites','controller'=>'site_users', 'action'=>'delete_from_tenant', $user[$modelName]['id']),
						  					array('class' => 'btn btn-sm btn-success')
						  	);
						  	?>
						</div>
					  <?php } ?>
				</div>
					
					
				</td>
			</tr>
		<?php 
		endforeach; ?>
	</table>
	<?php echo $this->element('Risto.pagination'); ?>