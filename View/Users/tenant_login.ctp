
<h1 class="center"><?php echo Configure::read("Site.name");?></h1>
<div class="contenst-white">
	<div class="row">
			
		<div class="user-login text-center col-sm-4 col-xs-12 col-sm-offset-2">	
			<h3 class="blue">Usuarios</h3>
			<?php echo $this->element('Users.pin_login'); ?>
		</div>


		<div class="login text-center col-sm-4 col-xs-12">	
		
		<h3 class="blue">Administradores</h3>
			<div class="row">

				<div class="col-sm-12 center">
					<h4 class="black-5">Ingresar con</h4>
					<?php
					// box Login OAUTH
					echo $this->element('Users.box_oauth_login'); 
					?>
				</div>
				<div class="col-sm-12">
					<br><br>
					<h4 class="black-5">... o con la cuenta PaxaPos</h4>
					<?php echo $this->element('Users.boxlogin');?>
				</div>
			</div>
		</div>


		</div>
	</div>
</div>

<style>
	.pin{
		width: 50px !important;
		display: inline-block;
		padding: 0 !important;
		text-align: center !important;
	}
</style>

<script type="text/javascript">

</script>