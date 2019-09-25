<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

		<div class="mid_box_top">
			    <p>User registration</p>	
	    </div>
	 

 
	<?php
		echo form_open('Registration/create_user');
		$js = 'onfocus="this.value=\'\'" ';
		?>
		
		<div class="form_field_seperator">
			<p>User Name: </p>
		    <?php 
	 			echo form_input('username', set_value('username', 'User name'));
				//echo form_input('product_size', set_value('product_size','Product Size'),$js);
		    ?>
		</div>
		<div class="form_field_seperator">
			<p>Phone Number: </p>
		    <?php 
	 			echo form_input('phone_no', set_value('phone_no', 'Phone no'),$js);
		    ?>
		</div>
		<div class="form_field_seperator">
			<p>User Type: </p>
		    <?php 
	 			echo form_input('user_type', set_value('user_type', 'User type'),$js);
		    ?>
		</div>
		<div class="form_field_seperator">
			<p>Password: </p>
		    <?php 
	 			echo form_input('password', set_value('password', 'Password'),$js);
		    ?>
		</div>
		<div class="form_field_seperator">
			<p>Confirm Password: </p>
		    <?php 
	 			echo form_input('confirm_password', set_value('confirm_password', 'Confirm Password'),$js);
		    ?>
		</div>
		<div class="form_field_seperator">
			<p>User Address: </p>
		    <?php 
	 			echo form_textarea('user_address', set_value('user_address', 'User address'),$js);
		    ?>
		</div>
		<div class="form_field_seperator">
				<div class="button_controller">
					<?php
					    echo form_submit('submit', 'Submit');
						echo form_reset('reset', 'Reset'); 
					?>
		        </div>
		</div> 
<!--<?php echo validation_errors('<p class="error">');?>-->