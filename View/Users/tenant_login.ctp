
<h1 class="center"><?php echo Configure::read("Site.name");?></h1>
<div class="contenst-white">
	<div class="row">
			
		<div class="user-login text-center col-sm-4 col-xs-12 col-sm-offset-2">	
			<h3 class="blue">Usuarios</h3>
			<h1 class="center black-5">PIN</h1>
			<?php echo $this->Form->create('GenericUser', array( 'id'=>'pinForm'));?>

						<?php echo $this->Form->password('k1', array(
							'class' => 'form-control input-lg pin',
							'id' => 'pin1',
							'maxlength' => 1
						))?>
						<?php echo $this->Form->password('k2', array(
							'class' => 'form-control input-lg pin',
							'id' => 'pin2',
							'maxlength' => 1
						))?>
						<?php echo $this->Form->password('k3', array(
							'class' => 'form-control input-lg pin',
							'id' => 'pin3',
							'maxlength' => 1
						))?>
						<?php echo $this->Form->password('k4', array(
							'class' => 'form-control input-lg pin pin input-block',
							'id' => 'pin4',
							'maxlength' => 1
						))?>

			<?php echo $this->Form->end();?>
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

	var $p1 = $("#pin1");
	var $p2 = $("#pin2");
	var $p3 = $("#pin3");
	var $p4 = $("#pin4");

		$p1.on('keypress', function() {
			$p2.on('keypress', function() {				
				$p3.on('keypress', function() {
					$p4.on('keyup', function() {
						if ($p1.val() && $p2.val() && $p3.val() && $p4.val() ) {
							$("#pinForm").submit();
						}
					}).focus();
				}).focus();
			}).focus();
		} ).focus();


		$p1.on('keydown', function(e) {
			if (e.keyCode==8) {
		   		$p1.val("");
			}
		 });
		$p2.on('keydown', function(e) {
			if (e.keyCode==8) {
			   $p2.val("");
			   $p1.focus();
		   }
		 });
		$p3.on('keydown', function(e) {
			if (e.keyCode==8) {
			   $p3.val("");
			   $p2.focus();
		   }
		 });
		$p4.on('keydown', function(e) {
			if (e.keyCode==8) {
			   $p4.val("");
			   $p3.focus();
			}
		 });

	function ponerPin() {
		$(".pin").val("");
		$p1.focus();
	};
	ponerPin()();
	$(".pin").on('click', ponerPin );
</script>