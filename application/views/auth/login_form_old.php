<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'value' => set_value('login'),
	'maxlength'	=> 80,
	'size'	=> 30,
);
if ($login_by_username AND $login_by_email) {
	$login_label = 'Email or login';
} else if ($login_by_username) {
	$login_label = 'Login';
} else {
	$login_label = 'Email';
}
$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30,
);
$remember = array(
	'name'	=> 'remember',
	'id'	=> 'remember',
	'value'	=> 1,
	'checked'	=> set_value('remember'),
	'style' => 'margin:0;padding:0',
);
$captcha = array(
	'name'	=> 'captcha',
	'id'	=> 'captcha',
	'maxlength'	=> 8,
);
?>

<!DOCTYPE HTML>
<html>
<head>
	<title>  ::~Dokani~::  </title>
	<link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico"  type="image/x-icon"/>
    	<link rel="stylesheet" href="<?php echo base_url(); ?>style/login_css.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>style/style.css" type="text/css"/>
</head>
	 <body>
	 	<div id="login_body"> 
	 		<div class = "login_main_img"> </div>
	 		<h1 class="login_co_name"> <?php echo $shop_name;?> </h1>	 
	 		
	 		<p class="date_time">
				<?php 
					$timezone = "Asia/Dacca"; 
					date_default_timezone_set($timezone); 
					//echo date("l, d F Y.");
					echo date("l, ");
					//echo date("l, d F Y, h:i a",time());
					
				?>
				<span id=clock></span>

				<script type="text/javascript">
					var currenttime = '<?php
						date_default_timezone_set('Asia/Dhaka');
						echo date("F d, Y H:i:s", time())?>' //PHP method of getting server date
						 
					///////////Stop editting here/////////////////////////////////
					var montharray= new Array("January","February","March","April","May","June", "July","August","September","October","November","December");
					//var dayarray= new Array("Sat","Sun","Mon","Tue","Wed","Thu", "Fri");
					
					var serverdate=new Date(currenttime);
					function padlength(what){
						var output=(what.toString().length==1)? "0"+what : what;
						return output;
					}
					function displaytime(){
						serverdate.setSeconds(serverdate.getSeconds()+1);
						var datestring=padlength(serverdate.getDate())+" "+montharray[serverdate.getMonth()]+", "+serverdate.getFullYear();
						
						//var datestring=montharray[serverdate.getMonth()]+" "+padlength(serverdate.getDate())+", "+serverdate.getFullYear()+"<br/>";
						
						var timestring = padlength(serverdate.getHours())+":"+padlength(serverdate.getMinutes())+ ":" + padlength(serverdate.getSeconds());
						document.getElementById("clock").innerHTML = datestring + " " + timestring;
					}
					setInterval("displaytime()", 1000);
				</script>					






				<!--script>
				<!--

				/*By JavaScript Kit
				http://javascriptkit.com
				Credit MUST stay intact for use
				*/

				function show2(){
				if (!document.all&&!document.getElementById)
				return
				thelement=document.getElementById? document.getElementById("tick2"): document.all.tick2
				var Digital=new Date()
				var hours=Digital.getHours()
				var minutes=Digital.getMinutes()
				var seconds=Digital.getSeconds()
				var dn="PM"
				if (hours<12)
				dn="AM"
				if (hours>12)
				hours=hours-12
				if (hours==0)
				hours=12
				if (minutes<=9)
				minutes="0"+minutes
				if (seconds<=9)
				seconds="0"+seconds
				var ctime=hours+":"+minutes+":"+seconds+" "+dn
				thelement.innerHTML=ctime
				setTimeout("show2()",1000)
				}
				window.onload=show2
				//
				</script -->
			</p>
			
			<div class="login_box">
				<h2 class="login_header">User Login:</h2>
				<div class="seperator">
				    <div class="text_controller"> Username or email</div>
					<?php
					    $js = 'onfocus="this.value=\'\'" ';
						echo form_open($this->uri->uri_string());
						echo form_input('login','Username',$js);
					?>
			    </div>
				<div class="seperator">
					<div class="text_controller"> Password</div>
					<?php
						echo form_password('password','Password',$js);
                                                
					?>
				</div>
				  <?php 
                    if($try)
                    {
                  ?>
                        <div class = "wrong_messege_view"> *invalide username or password </div>
				   <?php
                    }
				  ?>
				<div class="seperator">
					
					<?php
						echo form_submit('submit', 'Let me in');
					?>
				</div>
			</div>	 		
	 		<div id="copyright">
				<p>
					&copy;
					<b>Dokani</b>
					is Powered by
					<a target="blank" href="http://www.itlabsolutions.com">IT Lab Solutions.</a>
				</p>
	  		</div> <!-- end of copyright-->		
	 	</div><!--end of login_body-->
	 	
	 </body> <!--end of body-->
</html>
