<div class="btn-group pull-right">
	<?php echo $this->Html->link(__('Crear nuevo %s', __('Usuario')), array('admin'=>true,'plugin'>'users', 'controller'=> 'SiteUsers', 'action'=>'add'), array('class'=>'btn btn-success btn-lg btn-add')); ?>	
	</div>

	<h2><?php echo __d('users', 'Users'); ?></h2>
<br>
	<?php
		if (CakePlugin::loaded('Search')) {
		?>
		<div class="row">               
		<?php echo $this->Form->create($model, array( 'url' => array('action' => 'index') ));?>		
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
			<th><?php echo $this->Paginator->sort('username'); ?></th>
			<th><?php echo $this->Paginator->sort('email'); ?></th>
		<?php if (empty($sinRol)) { ?>	<th><?php echo $this->Paginator->sort('Rol'); ?></th> <?php } ?>
			<th><?php echo $this->Paginator->sort('active'); ?></th>
			<th><?php echo $this->Paginator->sort('last_login'); ?></th>
			<th class="actions"><?php echo __d('users', 'Actions'); ?></th>
		</tr>
			<?php
			$i = 0;
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
				if (empty($sinRol)) {
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
							$this->Time->timeAgoInWords( $user[$model]['last_login'])
							: __d('users','never'); 
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
                    <li class="">
					    	<?php echo $this->Form->postLink(__d('users', 'Delete'), array('action' => 'delete', $user[$model]['id']), null, sprintf(__d('users', '¿Estas seguro que quieres desvincular a %s de tu comercio?'), $user[$model]['username'])); ?>
					</li>
                  </ul>
                </div>
					
					
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
	<?php echo $this->element('Risto.pagination'); ?>