<?php echo $this->Html->css('/risto/css/ristorantino/boxlogin_oauth'); ?>


<div class="box-oauth-login">

	<div class="p-login-media" role="group">
	    <span class="p-facebook">
	    	<?php echo $this->Html->link('<span class="p-hide">Facebook</span>', array('plugin'=>'users', 'controller'=>'users', 'action'=>'auth_login', 'facebook'), array('class'=>'btn btn-default btn-oauth btn-icon', 'escape'=>false)); ?>
    	</span>
	    <span class="p-google">
	    	<?php echo $this->Html->link('<span class="p-hide">Google</span>'
						, array('plugin'=>'users', 'controller'=>'users', 'action'=>'auth_login', 'google'), array('class'=>'btn btn-default btn-oauth btn-icon', 'escape'=>false)); ?>	    	
	    		    	
    	</span>
	</div>

</div>