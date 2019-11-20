<?php
if ($use_username) 
{
	$username = array(
		'name'	=> 'username',
		'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
		'size'	=> 30,
	);
}
$email = array(
	'name'	=> 'email',
	'maxlength'	=> 80,
	'size'	=> 30,
);
$user_full_name = array(
	'name'	=> 'user_full_name',
	'maxlength'	=> 80,
	'size'	=> 30,
);
$phone_no = array(
	'name'	=> 'phone_no',
	'maxlength'	=> 20,
	'size'	=> 30,
);
$password = array(
	'name'	=> 'password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$user_address = array(
	'name'	=> 'user_address',
	'rows' => 2,
	'maxlength'	=> 100,
	'size'	=> 50,
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);
$user_type = array(
	'name'  => 'user_type',
	'maxlength' => 7,
);
$assigned_shop = array(
	'name'  => 'assigned_shop',
	'maxlength' => 7,
);
?>
				
<div class="content-wrapper">
	<?php
		if($status != '' )
		{	
			 if($status == "successful")
			 {
				 echo '<div class="box-body">';
				 echo '<div class="alert alert-success alert-dismissible" style="background:#00a65a;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-check"></i> Success</h4>
					</div>';
				 echo '</div>';
			 }
			 else
			 {
				 echo '<div class="box-body">';
				 echo '<div class="alert alert-danger alert-dismissible" style="background:#dd4b39;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-check"></i> User Name Already Exists!</h4>
					</div>';
				 echo '</div>';
			 }
		}
	 ?>
	<section class="content" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
					<div class="box-header with-border" style="background:#0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">User Setup</h3>
					</div>
					<div class="box-body">
						<form action="<?php echo base_url();?>auth/register" method="post" class="form-horizontal">
							<div class="box-body">
								<?php
								echo validation_errors();
								if(form_error($username['name']) || form_error($phone_no['name'])  || form_error($user_address['name']) || form_error($user_full_name['name']))
								{
								?>
								<div class="form_field_seperator">
									<div class = "validation_msg">
										<?php									
											echo form_error($username['name']); 
											echo form_error($phone_no['name']); 
											echo form_error($user_address['name']); 											
										?>
									 </div>
							   </div>
								<?php
								}
								?>
								<?php   
								if( form_error($password['name']) || form_error($confirm_password['name']) || form_error($assigned_shop['name'])) 
								{
								?>
								<div class="form_field_seperator">
									<div class = "validation_msg">
										  
												<?php										    	   	
													echo form_error($password['name']); 											
													echo form_error($confirm_password['name']); 											
													echo form_error($assigned_shop['name']); 											
												?>
									 </div>
							   </div>
								<?php
								}
								?>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">User Name</label>
									<div class="col-sm-4">
										<?php 	
											echo form_input($username,'','class="form-control" placeholder="User Name" id="one" autocomplete="off"');
										?>
									</div>
									<label for="inputEmail3" class="col-sm-2 control-label">Full Name</label>
									<div class="col-sm-4">
										<?php 	
											echo form_input($user_full_name,'','class="form-control" placeholder="Full Name" id="two" autocomplete="off"');
										?>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Phone Number</label>
									<div class="col-sm-4">
										<?php 	
											echo form_input($phone_no,'','class="form-control" placeholder="Phone Number" id="three" autocomplete="off"');
										?>
									</div>
									<label for="inputEmail3" class="col-sm-2 control-label">User Type</label>
									<div class="col-sm-4">
										<?php 	
											$user_type = $this -> tank_auth -> get_usertype();
											if($user_type == 'admin')
											{
												$temp = array(
												 'manager' => 'Manager', 
												 'accountent' => 'Accountent',
												 'stockist' => 'Stockist',								
												 'seller' => 'Seller'
												 );
											}
											if($user_type == 'manager')
											{
												$temp = array(
												 'accountent' => 'Accountent',
												 'stockist' => 'Stockist',								
												 'seller' => 'Seller'
												 );
											}
											if($user_type == 'superadmin')
											{
												$temp = array(
												'superadmin' => 'Superadmin',
												'admin'   => 'admin',		
												'manager' => 'Manager', 
												'accountent' => 'Accountent',
												'stockist' => 'Stockist',								
												'seller' => 'Seller'
												 );
											}
											echo form_dropdown('user_type', $temp,'' ,'class="form-control select2" style="width: 100%;" id="four" tabindex="-1" aria-hidden="true"');
										?>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">Shop Name</label>
									<div class="col-sm-10">
										<?php 	
											echo form_dropdown('assigned_shop', $all_shop,'' ,'class="form-control select3" id="five" style="width: 100%;" tabindex="-1" aria-hidden="true"');
										?>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">New</label>
									<div class="col-sm-4">
										<?php 	
									
											echo form_password($password, '', 'class="form-control" id="six" placeholder="New Password"'); 
											echo isset($errors[$password['name']])?$errors[$password['name']]:'';
										?>
									</div>
									<label for="inputEmail3" class="col-sm-2 control-label">Confirm</label>
									<div class="col-sm-4">
										<?php 	
									
											echo form_password($confirm_password, '', 'class="form-control" id="seven" placeholder="Confirm Password"'); 
											echo isset($errors[$confirm_password['name']])?$errors[$confirm_password['name']]:'';
										?>
									</div>
								</div>
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-2 control-label">User Address</label>
									<div class="col-sm-10">
										<?php 	
									
											echo form_textarea($user_address,'','class="form-control" placeholder="User Address" id="eight" autocomplete="off"');
										?>
									</div>
								</div>
							</div>
							<div class="box-footer" style="background: #0f77ab;">
								<center>
									<div class="col-sm-22">
										<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i> Create</button>
										<button type="reset" id="reset_btn" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-refresh"></i> Reset</button>
									</div>
								</center>
							</div>
						</form>
				  </div>
			  </div>
			</div>
		</div>
	</section>
<script type="text/javascript">
$(document).ready(function() {
	$("#reset_btn").click(function(event) {
			event.preventDefault();
			$('#one').val('');
			$('#two').val('');
			$('#three').val('');
			$('#four').val('');
			$('#four').select2();
			$('#five').val('');
			$('#five').select2();
			$('#six').val('');
			$('#seven').val('');
			$('#eight').val('');
		});
	});
</script>
</div>
