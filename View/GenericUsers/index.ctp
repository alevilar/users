<?php $this->element("Risto.layout_modal_edit", array('title'=>'Usuario'));?>


<div class="content-white">
	<div class="row">
		<div class="col-xs-8 col-xs-offset-2" style="display: inline-block;">
			<h1 class="center">Usuarios</h1>
		</div>
		<div class="col-xs-2">
			<?php echo $this->Html->link('Crear Usuario', array('plugin' => 'users', 'controller' => 'roles', 'action' => 'add'), array('class' => 'btn btn-primary btn-lg btn-add pull-right')) ?> 
		</div>
	</div>
<div class="row">
	<div class="col-sm-8 col-sm-offset-4">
		
		<table class="table">
			
		
			<?php foreach ( $roles as $user ) { ?>
				<tr>
					<td>
						<?php  if ( empty( $user['GenericUser']['id'] ) ) { ?>
							<?php  echo $user['Rol']['name']?>
						<?php } else { ?>	
							<b><?php  echo $user['Rol']['name']?></b>
						<?php } ?>
					</td>
					<td>
						<div class="btn-group">
						<?php  if ( empty( $user['GenericUser']['id'] ) ) { ?>
							<?php echo $this->Html->link(
								'Habilitar Ingreso', array('action' => 'add',  $user['Rol']['id']), array('class'=>'btn-add btn btn-success')
								);?>
						<?php }  else { ?>
							<?php 
							echo $this->Html->link(
								'Modificar PIN', array('action' => 'edit',  $user['Rol']['id'], $user['GenericUser']['id']), array('class' => 'btn-edit btn btn-default')
								);
							echo $this->Html->link(
								__('Remover Ingreso'), array('action' => 'delete', $user['GenericUser']['id'] ), 
								    array('class' => 'btn btn-warning'), sprintf(__("¿Esta seguro que desea denegar el acceso al usuario generico %s ?", $user['Rol']['name']))
							    );
						 } 
							echo $this->Html->link(
									__('Eliminar Usuario'), array('plugin' => 'users', 'controller' => 'roles', 'action' => 'delete', $user['Rol']['id'] ), 
									    array('class' => 'btn btn-danger'), sprintf(__("¿Esta seguro que desea borrar al usuario generico %s ?", $user['Rol']['name']))
								    );
						?>
						</div>
					</td>
				</tr>
			<?php } ?>
		</table>
	</div>
</div>
</div>