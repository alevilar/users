<?php 
$this->start("css");
echo $this->Html->css('/risto/css/ristorantino/boxlogin_oauth'); 
$this->end();
?>

<script type="text/javascript">
	var Risto = {
		APPID: '<?php echo Configure::read("ExtAuth.Provider.Facebook.key")?>',
		URLVERIFICARUSUARIO: "<?php echo Router::url(array('plugin' => 'users', 'controller' => 'users', 'action' => 'fb_login', 'ext'=>'json')) ?>"
	};
</script>


<div class="box-oauth-login">

	<div class="p-login-media" role="group">

	    <span class="p-facebook">
	    	<?php 
	    	echo $this->Html->link('<span class="hide">Facebook</span>', 
	    		'#',
	    		 array(
	    		'class'=>'btn btn-default btn-oauth btn-icon fb-login', 
	    		'escape'=>false)); ?>
    	</span>
	    <span class="p-google">
	    	<?php echo $this->Html->link('<span class="hide">Google</span>'
						, array('plugin'=>'users', 'controller'=>'users', 'action'=>'auth_login', 'google'), array('class'=>'btn btn-default btn-oauth btn-icon', 'escape'=>false)); ?>	    	
	    		    	
    	</span>
	</div>

</div>

<?php
echo $this->Html->script('Users.box_oauth_login');
?>