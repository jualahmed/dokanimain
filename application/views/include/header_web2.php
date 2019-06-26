<<<<<<< HEAD
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="icon" href="img/fav-icon.png" type="image/x-icon" />

		<title>Home</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
		<link rel="icon" type="image/png" href="<?php echo base_url();?>assets/assets5/images/icons/favicon.png"/>
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/fonts/themify/themify-icons.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/fonts/elegant-font/html-css/style.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/vendor/animate/animate.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/vendor/select2/select2.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/vendor/slick/slick.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/vendor/lightbox2/css/lightbox.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/css/util.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/css/main.css">
	<!--===============================================================================================-->
    </head>
    <body class="animsition">

	<?php

		class BanglaConverter 
		{
			public static $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
			public static $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
			
			public static function bn2en($number) {
				return str_replace(self::$bn, self::$en, $number);
			}
			
			public static function en2bn($number) {
				return str_replace(self::$en, self::$bn, $number);
			}
		}
	?>
	<header class="header1">
		<!-- Header desktop -->
		<div class="container-menu-header">
			<!--div class="topbar">
				<div class="topbar-social">
					<a href="#" class="topbar-social-item fa fa-facebook"></a>
					<a href="#" class="topbar-social-item fa fa-instagram"></a>
				</div>

				<div class="topbar-child2">
					<span class="topbar-email">
						fashe@example.com
					</span>
					<!--?php
					$lang = $this->uri->segment(3);
					if($lang=='' || $lang=='bn')
					{
					?>
					<a href="#"><i class="fa fa-phone"></i>জরুরী যোগাযোগ : <span><?php echo BanglaConverter::en2bn('+84 987 654 321');?></span></a>
					<a href="#"><i class="fa fa-envelope"></i> Email: <span>support@yourdomain.com</span></a>
					<!?php
					}
					else if($lang=='en')
					{
					?>
					<a href="#"><i class="fa fa-phone"></i>Call Us: <span><?php echo BanglaConverter::bn2en('+84 987 654 321');?></span></a>
					<a href="#"><i class="fa fa-envelope"></i> Email: <span>support@yourdomain.com</span></a>
					<!?php
					}
					?>
					<div class="topbar-language rs1-select2">
						<select class="selection-1 lang_id">
							<?php
							$lang = $this->uri->segment(3);
							if($lang=='' || $lang=='bn')
							{
							?>
							<option value="bn" selected>BN</option>
							<option value="en">EN</option>
							<?php
							}
							else if($lang=='en')
							{
							?>
							<option value="en" selected>EN</option>
							<option value="bn">BN</option>
							<?php
							}
							?>
                        </select>
					</div>
				</div>
			</div-->

			<div class="wrap_header">
				
				<!-- Logo -->
				<a href="<?php echo base_url();?>" class="logo">
					<img src="<?php echo base_url();?>images/right-logo.png" alt="IMG-LOGO">
				</a>

				<!-- Header Icon -->
				<div class="header-icons">
					<div class="topbar-language rs1-select2">
						<select class="selection-1 lang_id">
							<?php
							$lang = $this->uri->segment(3);
							if($lang=='' || $lang=='bn')
							{
							?>
							<option value="bn" selected>BN</option>
							<option value="en">EN</option>
							<?php
							}
							else if($lang=='en')
							{
							?>
							<option value="en" selected>EN</option>
							<option value="bn">BN</option>
							<?php
							}
							?>
                        </select>
					</div>
					<span class="linedivide1"></span>
					<a href="<?php echo base_url();?>auth/login" class="header-wrapicon1 dis-block">
						<img src="<?php echo base_url();?>assets/assets5/images/icons/icon-header-01.png" class="header-icon1" alt="ICON">
					</a>

					<span class="linedivide1"></span>

					<div class="header-wrapicon2">
						<img src="<?php echo base_url();?>assets/assets5/images/icons/icon-header-02.png" class="header-icon1 js-show-header-dropdown" alt="ICON">
						<?php 
						$i = 0;
						foreach ($this->cart->contents() as $items)
						{
							$i++;
							
						}
						
						?>
						<span class="header-icons-noti"><?php echo $i;?></span>

						<!-- Header cart noti -->
						<div class="header-cart header-dropdown">
							<ul class="header-cart-wrapitem">
								<?php $i = 1; ?>

								<?php foreach ($this->cart->contents() as $items): ?>

								<?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>
								<li class="header-cart-item">
									<a href="<?php echo base_url('web/removeItem/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$items["rowid"]); ?>" onclick="return confirm('Are you sure?')">
										<div class="header-cart-item-img">
											<img src="<?php echo base_url();?>images/cart.png" alt="IMG"></center>
										</div>
									</a>
									<div class="header-cart-item-txt">
										<a class="header-cart-item-name">
											<?php echo $items['name']; ?>
											<?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
														<?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>
														<strong><?php echo $option_name; ?>:</strong> <?php echo $option_value; ?><br />

														<?php endforeach; ?>
											<?php endif; ?>
										</a>

										<span class="header-cart-item-info">
											
											<?php
											$lang = $this->uri->segment(3);
											if($lang=='' || $lang=='bn')
											{
											?>
											&#2547; <?php echo BanglaConverter::en2bn($this->cart->format_number($items['price'])); ?> 
											<input type="number" class="form-control text-center btn-sm" style="padding: 2px 0px 2px 12px;width: 30%;"  value="<?php echo $items["qty"]; ?>" onchange="updateCartItem(this, '<?php echo $items["rowid"]; ?>')"> 
											&#2547; <?php echo BanglaConverter::en2bn($this->cart->format_number($items['subtotal'])); ?>
											<?php
											}
											else if($lang=='en')
											{
											?>
											
											&#2547; <?php echo BanglaConverter::bn2en($this->cart->format_number($items['price'])); ?> 
											<input type="number" class="form-control text-center btn-sm" style="padding: 2px 0px 2px 12px;width: 30%;"  value="<?php echo $items["qty"]; ?>" onchange="updateCartItem(this, '<?php echo $items["rowid"]; ?>')"> 
											&#2547; <?php echo BanglaConverter::bn2en($this->cart->format_number($items['subtotal'])); ?>
											<?php
											}
											?>
										</span>
									</div>
								</li>
								<?php $i++; ?>

								<?php endforeach; ?>
							</ul>

							<div class="header-cart-total">
								<?php
								$lang = $this->uri->segment(3);
								if($lang=='' || $lang=='bn')
								{
								?>
								মোট : &#2547; <?php echo BanglaConverter::en2bn($this->cart->format_number($this->cart->total())); ?>

								<?php
								}
								else if($lang=='en')
								{
								?>
								Total : &#2547; <?php echo BanglaConverter::bn2en($this->cart->format_number($this->cart->total())); ?>
								<?php
								}
								?>
							</div>

							<div class="header-cart-buttons">
								<!--div class="header-cart-wrapbtn">
									<a href="cart.html" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
										View Cart
									</a>
								</div-->

								<div class="header-cart-wrapbtn">
									<!-- Button -->
									<a href="<?php echo base_url(); ?>checkout/index/<?php echo $this->uri->segment(3);?>" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
										Check Out
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Header Mobile -->
		<div class="wrap_header_mobile">
			<!-- Logo moblie -->
			<a href="<?php echo base_url();?>" class="logo-mobile">
				<img src="<?php echo base_url();?>images/right-logo.png" alt="IMG-LOGO">
			</a>

			<!-- Button show menu -->
			<div class="btn-show-menu">
				<!-- Header Icon mobile -->
				<div class="header-icons-mobile">
					<div class="header-wrapicon2">
						<img src="<?php echo base_url();?>assets/assets5/images/icons/icon-header-02.png" class="header-icon1 js-show-header-dropdown" alt="ICON">
						
						<?php 
						$i = 0;
						foreach ($this->cart->contents() as $items)
						{
							$i++;
							
						}
						
						?>
						<span class="header-icons-noti"><?php echo $i;?></span>

						<div class="header-cart header-dropdown">
							<ul class="header-cart-wrapitem">
								<?php $i = 1; ?>

								<?php foreach ($this->cart->contents() as $items): ?>

								<?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>
								<li class="header-cart-item">
									<a href="<?php echo base_url('web/removeItem/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$items["rowid"]); ?>" onclick="return confirm('Are you sure?')">
										<div class="header-cart-item-img">
											<img src="<?php echo base_url();?>images/cart.png" alt="IMG"></center>
										</div>
									</a>

									<div class="header-cart-item-txt">
										<a class="header-cart-item-name">
											<?php echo $items['name']; ?>
											<?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
														<?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>
														<strong><?php echo $option_name; ?>:</strong> <?php echo $option_value; ?><br />

														<?php endforeach; ?>
											<?php endif; ?>
										</a>

										<span class="header-cart-item-info">
											
											<?php
											$lang = $this->uri->segment(3);
											if($lang=='' || $lang=='bn')
											{
											?>
											&#2547; <?php echo BanglaConverter::en2bn($this->cart->format_number($items['price'])); ?> 
											<input type="number" class="form-control text-center btn-sm" style="padding: 2px 0px 2px 12px;width: 30%;"  value="<?php echo $items["qty"]; ?>" onchange="updateCartItem(this, '<?php echo $items["rowid"]; ?>')"> 
											&#2547; <?php echo BanglaConverter::en2bn($this->cart->format_number($items['subtotal'])); ?>
											<?php
											}
											else if($lang=='en')
											{
											?>
											
											&#2547; <?php echo BanglaConverter::bn2en($this->cart->format_number($items['price'])); ?> 
											<input type="number" class="form-control text-center btn-sm" style="padding: 2px 0px 2px 12px;width: 30%;"  value="<?php echo $items["qty"]; ?>" onchange="updateCartItem(this, '<?php echo $items["rowid"]; ?>')"> 
											&#2547; <?php echo BanglaConverter::bn2en($this->cart->format_number($items['subtotal'])); ?>
											<?php
											}
											?>
										</span>
									</div>
								</li>
								<?php $i++; ?>

								<?php endforeach; ?>
							</ul>

							<div class="header-cart-total">
								<?php
								$lang = $this->uri->segment(3);
								if($lang=='' || $lang=='bn')
								{
								?>
								মোট : &#2547; <?php echo BanglaConverter::en2bn($this->cart->format_number($this->cart->total())); ?>

								<?php
								}
								else if($lang=='en')
								{
								?>
								Total : &#2547; <?php echo BanglaConverter::bn2en($this->cart->format_number($this->cart->total())); ?>
								<?php
								}
								?>
							</div>

							<div class="header-cart-buttons">
								<!--div class="header-cart-wrapbtn">
									<a href="cart.html" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
										View Cart
									</a>
								</div-->

								<div class="header-cart-wrapbtn">
									<!-- Button -->
									<a href="<?php echo base_url(); ?>checkout/index/<?php echo $this->uri->segment(3);?>" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
										Check Out
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
					<span class="hamburger-box">
						<span class="hamburger-inner"></span>
					</span>
				</div>
			</div>
		</div>

		<!-- Menu Mobile -->
		<div class="wrap-side-menu" >
			<nav class="side-menu">
				<ul class="main-menu">
					<li class="item-topbar-mobile p-l-20 p-t-8 p-b-8">
						<div class="topbar-child2-mobile">
							<div class="topbar-language rs1-select2">
								<select class="selection-1 lang_id">
									<?php
									$lang = $this->uri->segment(3);
									if($lang=='' || $lang=='bn')
									{
									?>
									<option value="bn" selected>BN</option>
									<option value="en">EN</option>
									<?php
									}
									else if($lang=='en')
									{
									?>
									<option value="en" selected>EN</option>
									<option value="bn">BN</option>
									<?php
									}
									?>
								</select>
							</div>
							<span class="linedivide1"></span>
							<a href="<?php echo base_url();?>auth/login" class="header-wrapicon1 dis-block">
								<img src="<?php echo base_url();?>assets/assets5/images/icons/icon-header-01.png" class="header-icon1" alt="ICON">
							</a>
						</div>
					</li>

					<!--li class="item-topbar-mobile p-l-10">
						<div class="topbar-social-mobile">
							<a href="#" class="topbar-social-item fa fa-facebook"></a>
							<a href="#" class="topbar-social-item fa fa-instagram"></a>
						</div>
					</li-->
				</ul>
			</nav>
		</div>
	</header>
	<style>
	.m-text13
	{
		font-family: Montserrat-Regular;
    font-size: 18px;
    color: #ffffff;
    line-height: 1.8;
    background-color: #2495c0ad;
    padding: 5px 18px;
    border-radius: 6px;
	}
	</style>
	<!-- Title Page -->
	<section class="bg-title-page p-t-50 p-b-40 flex-col-c-m" style="background-image: url(<?php echo base_url();?>assets/assets5/images/banner_1.jpg);">
		<?php
		$lang = $this->uri->segment(3);
		if($lang=='' || $lang=='bn')
		{
		?>
		<p class="m-text13 t-center">
			রাইটসে আপনাকে স্বাগতম
		</p>	
		<?php
		}
		else if($lang=='en')
		{
		?>
		<p class="m-text13 t-center">
			Welcome to Rights
		</p>	
		<?php
		}
		?>
		
=======
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="icon" href="img/fav-icon.png" type="image/x-icon" />

		<title>Home</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
		<link rel="icon" type="image/png" href="<?php echo base_url();?>assets/assets5/images/icons/favicon.png"/>
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/fonts/themify/themify-icons.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/fonts/elegant-font/html-css/style.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/vendor/animate/animate.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/vendor/select2/select2.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/vendor/slick/slick.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/vendor/lightbox2/css/lightbox.min.css">
	<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/css/util.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/assets5/css/main.css">
	<!--===============================================================================================-->
    </head>
    <body class="animsition">

	<?php

		class BanglaConverter 
		{
			public static $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
			public static $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
			
			public static function bn2en($number) {
				return str_replace(self::$bn, self::$en, $number);
			}
			
			public static function en2bn($number) {
				return str_replace(self::$en, self::$bn, $number);
			}
		}
	?>
	<header class="header1">
		<!-- Header desktop -->
		<div class="container-menu-header">
			<div class="topbar">
				<div class="topbar-social">
					<a href="#" class="topbar-social-item fa fa-facebook"></a>
					<a href="#" class="topbar-social-item fa fa-instagram"></a>
				</div>

				<div class="topbar-child2">
					<span class="topbar-email">
						fashe@example.com
					</span>
					<!--?php
					$lang = $this->uri->segment(3);
					if($lang=='' || $lang=='bn')
					{
					?>
					<a href="#"><i class="fa fa-phone"></i>জরুরী যোগাযোগ : <span><?php echo BanglaConverter::en2bn('+84 987 654 321');?></span></a>
					<a href="#"><i class="fa fa-envelope"></i> Email: <span>support@yourdomain.com</span></a>
					<!?php
					}
					else if($lang=='en')
					{
					?>
					<a href="#"><i class="fa fa-phone"></i>Call Us: <span><?php echo BanglaConverter::bn2en('+84 987 654 321');?></span></a>
					<a href="#"><i class="fa fa-envelope"></i> Email: <span>support@yourdomain.com</span></a>
					<!?php
					}
					?-->
					<div class="topbar-language rs1-select2">
						<select class="selection-1 lang_id">
							<?php
							$lang = $this->uri->segment(3);
							if($lang=='' || $lang=='bn')
							{
							?>
							<option value="bn" selected>BN</option>
							<option value="en">EN</option>
							<?php
							}
							else if($lang=='en')
							{
							?>
							<option value="en" selected>EN</option>
							<option value="bn">BN</option>
							<?php
							}
							?>
                        </select>
					</div>
				</div>
			</div>

			<div class="wrap_header">
				<!-- Logo -->
				<a href="index.html" class="logo">
					<img src="<?php echo base_url();?>assets/assets5/images/icons/logo.png" alt="IMG-LOGO">
				</a>

				<!-- Header Icon -->
				<div class="header-icons">
					<a href="<?php echo base_url();?>auth/login" class="header-wrapicon1 dis-block">
						<img src="<?php echo base_url();?>assets/assets5/images/icons/icon-header-01.png" class="header-icon1" alt="ICON">
					</a>

					<span class="linedivide1"></span>

					<div class="header-wrapicon2">
						<img src="<?php echo base_url();?>assets/assets5/images/icons/icon-header-02.png" class="header-icon1 js-show-header-dropdown" alt="ICON">
						<?php 
						$i = 0;
						foreach ($this->cart->contents() as $items)
						{
							$i++;
							
						}
						
						?>
						<span class="header-icons-noti"><?php echo $i;?></span>

						<!-- Header cart noti -->
						<div class="header-cart header-dropdown">
							<ul class="header-cart-wrapitem">
								<?php $i = 1; ?>

								<?php foreach ($this->cart->contents() as $items): ?>

								<?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>
								<li class="header-cart-item">
									<a href="<?php echo base_url('web/removeItem/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$items["rowid"]); ?>" onclick="return confirm('Are you sure?')">
										<div class="header-cart-item-img">
											<img src="<?php echo base_url();?>images/cart.png" alt="IMG"></center>
										</div>
									</a>
									<div class="header-cart-item-txt">
										<a class="header-cart-item-name">
											<?php echo $items['name']; ?>
											<?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
														<?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>
														<strong><?php echo $option_name; ?>:</strong> <?php echo $option_value; ?><br />

														<?php endforeach; ?>
											<?php endif; ?>
										</a>

										<span class="header-cart-item-info">
											
											<?php
											$lang = $this->uri->segment(3);
											if($lang=='' || $lang=='bn')
											{
											?>
											&#2547; <?php echo BanglaConverter::en2bn($this->cart->format_number($items['price'])); ?> 
											<input type="number" class="form-control text-center btn-sm" style="padding: 2px 0px 2px 12px;width: 30%;"  value="<?php echo $items["qty"]; ?>" onchange="updateCartItem(this, '<?php echo $items["rowid"]; ?>')"> 
											&#2547; <?php echo BanglaConverter::en2bn($this->cart->format_number($items['subtotal'])); ?>
											<?php
											}
											else if($lang=='en')
											{
											?>
											
											&#2547; <?php echo BanglaConverter::bn2en($this->cart->format_number($items['price'])); ?> 
											<input type="number" class="form-control text-center btn-sm" style="padding: 2px 0px 2px 12px;width: 30%;"  value="<?php echo $items["qty"]; ?>" onchange="updateCartItem(this, '<?php echo $items["rowid"]; ?>')"> 
											&#2547; <?php echo BanglaConverter::bn2en($this->cart->format_number($items['subtotal'])); ?>
											<?php
											}
											?>
										</span>
									</div>
								</li>
								<?php $i++; ?>

								<?php endforeach; ?>
							</ul>

							<div class="header-cart-total">
								<?php
								$lang = $this->uri->segment(3);
								if($lang=='' || $lang=='bn')
								{
								?>
								মোট : &#2547; <?php echo BanglaConverter::en2bn($this->cart->format_number($this->cart->total())); ?>

								<?php
								}
								else if($lang=='en')
								{
								?>
								Total : &#2547; <?php echo BanglaConverter::bn2en($this->cart->format_number($this->cart->total())); ?>
								<?php
								}
								?>
							</div>

							<div class="header-cart-buttons">
								<!--div class="header-cart-wrapbtn">
									<a href="cart.html" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
										View Cart
									</a>
								</div-->

								<div class="header-cart-wrapbtn">
									<!-- Button -->
									<a href="<?php echo base_url(); ?>checkout/index/<?php echo $this->uri->segment(3);?>" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
										Check Out
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Header Mobile -->
		<div class="wrap_header_mobile">
			<!-- Logo moblie -->
			<a href="index.html" class="logo-mobile">
				<img src="<?php echo base_url();?>images/right-logo.png" alt="IMG-LOGO">
			</a>

			<!-- Button show menu -->
			<div class="btn-show-menu">
				<!-- Header Icon mobile -->
				<div class="header-icons-mobile">
					<a href="#" class="header-wrapicon1 dis-block">
						<img src="<?php echo base_url();?>assets/assets5/images/icons/icon-header-01.png" class="header-icon1" alt="ICON">
					</a>

					<span class="linedivide2"></span>

					<div class="header-wrapicon2">
						<img src="<?php echo base_url();?>assets/assets5/images/icons/icon-header-02.png" class="header-icon1 js-show-header-dropdown" alt="ICON">
						
						<?php 
						$i = 0;
						foreach ($this->cart->contents() as $items)
						{
							$i++;
							
						}
						
						?>
						<span class="header-icons-noti"><?php echo $i;?></span>

						<div class="header-cart header-dropdown">
							<ul class="header-cart-wrapitem">
								<?php $i = 1; ?>

								<?php foreach ($this->cart->contents() as $items): ?>

								<?php echo form_hidden($i.'[rowid]', $items['rowid']); ?>
								<li class="header-cart-item">
									<a href="<?php echo base_url('web/removeItem/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$items["rowid"]); ?>" onclick="return confirm('Are you sure?')">
										<div class="header-cart-item-img">
											<img src="<?php echo base_url();?>images/cart.png" alt="IMG"></center>
										</div>
									</a>

									<div class="header-cart-item-txt">
										<a class="header-cart-item-name">
											<?php echo $items['name']; ?>
											<?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
														<?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>
														<strong><?php echo $option_name; ?>:</strong> <?php echo $option_value; ?><br />

														<?php endforeach; ?>
											<?php endif; ?>
										</a>

										<span class="header-cart-item-info">
											
											<?php
											$lang = $this->uri->segment(3);
											if($lang=='' || $lang=='bn')
											{
											?>
											&#2547; <?php echo BanglaConverter::en2bn($this->cart->format_number($items['price'])); ?> 
											<input type="number" class="form-control text-center btn-sm" style="padding: 2px 0px 2px 12px;width: 30%;"  value="<?php echo $items["qty"]; ?>" onchange="updateCartItem(this, '<?php echo $items["rowid"]; ?>')"> 
											&#2547; <?php echo BanglaConverter::en2bn($this->cart->format_number($items['subtotal'])); ?>
											<?php
											}
											else if($lang=='en')
											{
											?>
											
											&#2547; <?php echo BanglaConverter::bn2en($this->cart->format_number($items['price'])); ?> 
											<input type="number" class="form-control text-center btn-sm" style="padding: 2px 0px 2px 12px;width: 30%;"  value="<?php echo $items["qty"]; ?>" onchange="updateCartItem(this, '<?php echo $items["rowid"]; ?>')"> 
											&#2547; <?php echo BanglaConverter::bn2en($this->cart->format_number($items['subtotal'])); ?>
											<?php
											}
											?>
										</span>
									</div>
								</li>
								<?php $i++; ?>

								<?php endforeach; ?>
							</ul>

							<div class="header-cart-total">
								<?php
								$lang = $this->uri->segment(3);
								if($lang=='' || $lang=='bn')
								{
								?>
								মোট : &#2547; <?php echo BanglaConverter::en2bn($this->cart->format_number($this->cart->total())); ?>

								<?php
								}
								else if($lang=='en')
								{
								?>
								Total : &#2547; <?php echo BanglaConverter::bn2en($this->cart->format_number($this->cart->total())); ?>
								<?php
								}
								?>
							</div>

							<div class="header-cart-buttons">
								<!--div class="header-cart-wrapbtn">
									<a href="cart.html" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
										View Cart
									</a>
								</div-->

								<div class="header-cart-wrapbtn">
									<!-- Button -->
									<a href="<?php echo base_url(); ?>checkout/index/<?php echo $this->uri->segment(3);?>" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text1 trans-0-4">
										Check Out
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
					<span class="hamburger-box">
						<span class="hamburger-inner"></span>
					</span>
				</div>
			</div>
		</div>

		<!-- Menu Mobile -->
		<div class="wrap-side-menu" >
			<nav class="side-menu">
				<ul class="main-menu">
					<li class="item-topbar-mobile p-l-20 p-t-8 p-b-8">
						<div class="topbar-child2-mobile">
							<span class="topbar-email">
								fashe@example.com
							</span>

							<div class="topbar-language rs1-select2">
								<select class="selection-1 lang_id">
									<?php
									$lang = $this->uri->segment(3);
									if($lang=='' || $lang=='bn')
									{
									?>
									<option value="bn" selected>BN</option>
									<option value="en">EN</option>
									<?php
									}
									else if($lang=='en')
									{
									?>
									<option value="en" selected>EN</option>
									<option value="bn">BN</option>
									<?php
									}
									?>
								</select>
							</div>
						</div>
					</li>

					<li class="item-topbar-mobile p-l-10">
						<div class="topbar-social-mobile">
							<a href="#" class="topbar-social-item fa fa-facebook"></a>
							<a href="#" class="topbar-social-item fa fa-instagram"></a>
						</div>
					</li>
				</ul>
			</nav>
		</div>
	</header>

	<!-- Title Page -->
	<section class="bg-title-page p-t-50 p-b-40 flex-col-c-m" style="background-image: url(<?php echo base_url();?>assets/assets5/images/banner_1.jpg);">
		<?php
		$lang = $this->uri->segment(3);
		if($lang=='' || $lang=='bn')
		{
		?>
		<p class="m-text13 t-center">
			রাইটসে আপনাকে স্বাগতম
		</p>	
		<?php
		}
		else if($lang=='en')
		{
		?>
		<p class="m-text13 t-center">
			Welcome to Rights
		</p>	
		<?php
		}
		?>
		
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
	</section>