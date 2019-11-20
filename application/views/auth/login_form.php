<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>::~Dokani~:: </title>
  <link rel="icon" href="<?php echo base_url(); ?>images/dokani_small.png"  type="image/x-icon"/>
<style>
@charset "utf-8";

div.main{
    background:url(<?php echo base_url();?>assets/img/4.jpg) no-repeat fixed;
~background: -moz-radial-gradient(center, ellipse cover,  #0264d6 1%, #1c2b5a 100%); /* FF3.6+ */
~background: -webkit-gradient(radial, center center, 0px, center center, 100%, color-stop(1%,#0264d6), color-stop(100%,#1c2b5a)); /* Chrome,Safari4+ */
~background: -webkit-radial-gradient(center, ellipse cover,  #0264d6 1%,#1c2b5a 100%); /* Chrome10+,Safari5.1+ */
~background: -o-radial-gradient(center, ellipse cover,  #0264d6 1%,#1c2b5a 100%); /* Opera 12+ */
~background: -ms-radial-gradient(center, ellipse cover,  #0264d6 1%,#1c2b5a 100%); /* IE10+ */
~background: radial-gradient(ellipse at center,  #0264d6 1%,#1c2b5a 100%); /* W3C */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0264d6', endColorstr='#1c2b5a',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
height:calc(100vh);
width:100%;
}

[class*="fontawesome-"]:before {
  font-family: 'FontAwesome', sans-serif;
}

/* ---------- GENERAL ---------- */

* {
  box-sizing: border-box;
    margin:0px auto;

  &:before,
  &:after {
    box-sizing: border-box;
  }

}

body {
   
    color: #606468;
  font: 87.5%/1.5em 'Open Sans', sans-serif;
  margin: 0;
}

a {
	color: #eee;
	text-decoration: none;
}

a:hover {
	text-decoration: underline;
}

input {
	border: none;
	font-family: 'Open Sans', Arial, sans-serif;
	font-size: 14px;
	line-height: 1.5em;
	padding: 0;
	-webkit-appearance: none;
}

p {
	line-height: 1.5em;
}

.clearfix {
  *zoom: 1;

  &:before,
  &:after {
    content: ' ';
    display: table;
  }

  &:after {
    clear: both;
  }

}
.container {
  left: 50%;
  position: fixed;
  top: 50%;
  width:1000px;
  height:400px;
  background-image:url(<?php echo base_url();?>assets/img/new-background2.jpg);
  ~opacity:0.3;
  transform: translate(-50%, -50%);
  border-right: 1px dashed #000;
  border-left: 1px dashed #000;
  border-top: 1px dashed #000;
  border-bottom: 1px dashed #000;
}

.clearfixx {
  margin-top:30%;
}

#new_name {
  margin-top:15%;
}

/* ---------- LOGIN ---------- */

#login form{
	width: 250px;
}
#login{
    display:inline-block;
    width:40%;
}
.logo{
    display:inline-block;
    width:52%;
}
#login{
border-right:1px solid #fff;
  padding: 0px 22px;
  width: 59%;
}
.logo{
color:#fff;
font-size:50px;
line-height: 50px;
}

#login form span.fa {
	background-color: #fff;
	border-radius: 3px 0px 0px 3px;
	color: #000;
	display: block;
	float: left;
	height: 50px;
    font-size:24px;
	line-height: 50px;
	text-align: center;
	width: 50px;
}

#login form input {
	height: 50px;
}
fieldset{
    padding:0;
    border:0;
    margin: 0;

}
#login form input[type="text"], input[type="password"] {
	background-color: #fff;
	border-radius: 0px 3px 3px 0px;
	color: #000;
	margin-bottom: 1em;
	padding: 0 16px;
	width: 200px;
}

#login form input[type="submit"] {
  border-radius: 3px;
  -moz-border-radius: 3px;
  -webkit-border-radius: 3px;
  background-color: #000000;
  color: #eee;
  font-weight: bold;
  /* margin-bottom: 2em; */
  ~text-transform: uppercase;
  padding: 5px 10px;
  height: 30px;
}

#login form input[type="submit"]:hover {
	background-color: #d44179;
}

#login > p {
	text-align: center;
}

#login > p span {
	padding-left: 5px;
}
.middle {
  display: flex;
  top: 50%;
  width: 600px;
}
#copyright{
	float: left;
    margin: 60px 0px 0px 180px;
    width: 640px;
    height: auto;
	
}
#copyright p {
    font-size: 12px;
    font-family: arial;
    font-weight: normal;
    text-align: center;
}
.companyLogo2{
	~float:left;
	width:35px;
	margin:5px 0px -11px 0;
}
</style>
<div class="main">
	<div class="container">
		<center>
			<div class="middle">
				<div id="login">
					<fieldset class="clearfixx">
						<?php
							$js = 'onfocus="this.value=\'\'" ';
							echo form_open($this->uri->uri_string());
						?>
						<p><span class="fa"><img style="margin-top:10px;width:32px; height:30px;"src ="<?php echo base_url();?>assets/img/user.jpg"></span><?php echo form_input('login','Username',$js,'class="login-input" Placeholder="Username"');?></p> <!-- JS because of IE support; better: placeholder="Username" -->
						<p><span class="fa"><img style="margin-top:10px;width:32px; height:30px;"src ="<?php echo base_url();?>assets/img/lock.png"></span><?php echo form_password('password','Password',$js,'class="login-input" Placeholder="Password"');?></p> <!-- JS because of IE support; better: placeholder="Password" -->
						<div>
							<?php 
								if($try)
								{
							?>
									<div style="color:black;text-align:center;"> Invalid Username or Password </div>
							<?php
								}
							?>
							<span style="width:50%; text-align:center;  display: inline-block;"><?php echo form_submit('submit', 'Let me in','class="login-btn"');?></span>
							
						</div>
						<?php echo form_close();?>
					</fieldset>
					<div class="clearfix"></div>
				</div>
				<div class="logo" id="new_name" style="color:#FBDC5E;"><?php echo $shop_name;?>
					<div class="clearfix"></div>
				</div>
				
			</div>
		</center>
		<div id="copyright">
			<p style="color:#373030;">
				&copy;
				<b style="color:black"><img src="<?php echo base_url();?>images/dokani_small.png" style="width: 5%;">Dokani</b>
				is Powered by
				<a target="blank" style="color:#0F4A80" href="http://www.itlabsolutions.com">IT Lab Solutions Ltd.</a>
			</p>
		</div>
	</div>
</div>