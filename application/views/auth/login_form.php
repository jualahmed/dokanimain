<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>::~Dokani~:: </title>
  <link rel="icon" href="<?php echo base_url(); ?>images/dokani_small.png"  type="image/x-icon"/>
  <style>
	*, *::after, *::before {
		padding: 0;
		margin: 0;
		outline: 0;
		box-sizing: border-box;
	}
  	.container {
		display: flex;
		align-items: center;
		justify-content: center;
		background-color: #f8f8f8;
		height: 100vh;
	}
	.auth-page {
		display: flex;
		max-width: 300px;
		flex-direction: column;
		align-items: center;
		padding: 10px;
		box-shadow: 0px 4px 25px 0px rgba(0, 0, 0, 0.1);
		background-color: #fff;
		border-radius: 6px;
	}
	.auth-page h2 {
		text-align: center;
		margin-top: 0;
		margin: 10px 0px;
		text-transform: uppercase;
	}
	.auth-page form {
		margin: 0px;
		text-align: center;
	}
	.auth-input {
		width: 100%;
		margin: 7px 0px;
		border: 1px solid #ddd;
		height: 35px;
		border-radius: 4px;
		background-color: #fff;
		padding: 5px 10px;
		font-size: 17px;
		outline: none;
	}
	.login-btn {
		font-size: 18px;
		border: none;
		border-radius: 4px;
		padding: 5px 10px;
		background: #99d141;
		color: #fff;
		margin: 10px 0px;
	}

	.login-error {
		color: black;
		text-align: center;
		font-size: 14px;
		font-weight: bold;
		color: #f36464;
		background-color: #f7d2d2;
		padding: 9px 0px;
		border-radius: 4px;
	}
	.auth-header {
		width: 100%;
		text-align: center;
	}
	.auth-header img {
		max-width: 90px;
	}

	input[type=text]:focus {
		border: 1px solid #ddd;
		outline: none;
	}
	.auth-footer {
		font-size: 14px;
	}
  
  </style>
<div class="main">
	<div class="container">
		<?php 
		$shop_info=$this->db->get('shop_setup')->row(); 
		?>
		<div class="auth-page">
			<div class="auth-header">
				<img src="<?php echo base_url(); ?>assets/img/shop/<?php echo $shop_info->logo; ?>" alt="Dokani Logo">
				<h2><?php echo $shop_info->shop_name; ?></h2>
			</div>
			<div class="auth-body">
				<?php
					$js = 'onfocus="this.value=\'\'" ';
					echo form_open($this->uri->uri_string());
				?>
				<input type="text" autocomplete="off" name="login" class="auth-input" value="Username" onfocus="this.value=''">
				<input type="password" autocomplete="off" name="password" class="auth-input" value="Password" onfocus="this.value=''">
				<div>
					<?php 
						if($try) { ?>
							<div class="login-error"> Invalid Username or Password </div>
					<?php } ?>
				</div>
				<?php echo form_submit('submit', 'Let me in','class="login-btn"');?>
				<?php echo form_close();?>
			</div>
			<div class="auth-footer">
				<p style="color:#373030;">
					<b style="color:black">Dokani</b>
					is Powered by
					<a target="blank" style="color:#0F4A80; text-decoration:none;" href="http://www.itlabsolutions.com">IT Lab Solutions Ltd.</a>
				</p>
			</div>
		</div>
	</div>
</div>