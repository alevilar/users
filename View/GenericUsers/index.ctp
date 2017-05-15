<?php $this->element("Risto.layout_modal_edit", array('title'=>'Usuario'));?>


<div class="content-white">
<h1 class="center">Usuarios</h1>
<div class="row">
	<div class="col-sm-4 col-sm-offset-4">
		
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
						<?php  if ( empty( $user['GenericUser']['id'] ) ) { ?>
							<?php echo $this->Html->link(
								'Habilitar Ingreso', array('action' => 'add',  $user['Rol']['id']), array('class'=>'btn-add btn btn-success btn-block')
								);?>
						<?php }  else { ?>
						<div class="btn-group">
							<?php 
							echo $this->Html->link(
								'Modificar PIN', array('action' => 'edit',  $user['Rol']['id'], $user['GenericUser']['id']), array('class' => 'btn-edit btn btn-default')
								);
							echo $this->Html->link(
								__('Remover Ingreso'), array('action' => 'delete', $user['GenericUser']['id'] ), 
								    array('class' => 'btn btn-danger'), sprintf(__("¿Esta seguro que desea denegar el acceso al usuario generico %s ?", $user['Rol']['name']))
							    );?>
						<?php } ?>
						</div>
					</td>
				</tr>
			<?php } ?>
		</table>
	</div>
</div>
</div>