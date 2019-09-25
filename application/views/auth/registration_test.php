<?php
if ($use_username) {
	$username = array(
		'name'	=> 'username',
		'id'	=> 'username',
		'value' => set_value('username'),
		'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
		'size'	=> 30,
	);
}
$email = array(
	'name'	=> 'email',
	'id'	=> 'email',
	'value'	=> set_value('email'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
$phone_no = array(
	'name'	=> 'phone_no',
	'id'	=> 'phone_no',
	'value'	=> set_value('phone_no'),
	'maxlength'	=> 20,
	'size'	=> 30,
);
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'value' => set_value('password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$confirm_password = array(
	'name'	=> 'confirm_password',
	'id'	=> 'confirm_password',
	'value' => set_value('confirm_password'),
	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
	'size'	=> 30,
);
$user_address = array(
	'name'	=> 'user_address',
	'id'	=> 'user_address',
	'value'	=> set_value('user_address'),
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
	'id'    => 'user_type',
	'value' => set_value('user_type'),
	'maxlength' => 7,
);
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>  ::~Inventory Management~::  </title>
	<link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico"  type="image/x-icon"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>style/style_main.css" type="text/css"/>
</head>
	 <body>
		<div id="container">  
			<div id = "main">
				<div id="header">
					<div id="top_left_logo"> 
						<img src="<?php echo base_url(); ?>images/top_logo.png">
					</div>
					
					<div id="shop_title_box">
						<div id = "shop_title"> IT Lab Solutions</div>
						<div id = "shop_address"> Zindabazar Sylhet.</div>
					</div><!--end of shop_title_box-->
					
					<div id="user_info_box">
							<h1 id="welcome">Welcome!</h1>
							<p class="user_name">User Name : <?php echo $this->tank_auth->get_username();//$user_name; ?> </p>
							<p class="user_name">User Type : <?php echo $this->tank_auth->get_usertype();//$user_type; ?> </p>
					</div>
					<div id="date_time_box"> 
					    <div id="day"> Monday, 19 November 2012. </div>
						<div id="log_out"> 
							<a href="#">Log Out</a>
						</div>
					</div>
				</div> <!--end of header-->
				<div id="main_body"> 
					<div id = "top_menu">
						<?php $this -> load -> view('top_link_view'); ?>
					</div>
					<div id = "left">
								<?php $this -> load -> view('tricker_registration_view'); ?>
					</div>
					<div id = "middle"> 
						<div class="mid_box">
						<div class="mid_box_top">
				    		<p>User registration</p>	
					    </div>
				 <!-- here -->
				 
				 
				 
			
			 <!-- here -->
				<?php
					echo form_open($this->uri->uri_string());
					$js = 'onClick="clearMe(this)"';//onblur="returnMe(this)" onfocus="clearMe(this)"
					?>
					
					<div class="form_field_seperator">
						<p>User Name: </p>
					    <?php 
							echo form_input('username', 'Username');
					    ?>
					</div>
					<div class="form_field_seperator">
						<p>Phone Number: </p>
					    <?php 
				 			echo form_input('phone_no','Phone no');
					    ?>
					</div>
					<div class="form_field_seperator">
						<p>User Type: </p>
					    <?php 
				 			echo form_input('user_type', 'User type');
					    ?>
					</div>
					<div class="form_field_seperator">
						<p>Password: </p>
					    <?php 
				 			echo form_input('password','Password');
					    ?>
					</div>
					<div class="form_field_seperator">
						<p>Confirm Password: </p>
					    <?php 
				 			echo form_input('confirm_password', 'Confirm Password');
					    ?>
					</div>
					<div class="form_field_seperator">
						<p>User Address: </p>
					    <?php 
				 			echo form_textarea('user_address', 'User address');
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
					
					</div>					
								</div>	
				</div> <!--end of main_body-->
			    <div id="footer">
					<p id="shop_copyright"> &#169; IT Lab Solutions, Zindabazar Sylhet.</p>
					
					<p id="dokani_copyright">
					    &reg; <b>DOKANI</b> 
						&copy; <a href="#">IT Lab Solutions</a>+8801842485222
					</p>	
				</div><!--end of footer-->
			</div> <!--end of main-->
		</div><!--end of container-->
     </body><!--end of body-->
</html>		
	