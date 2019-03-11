<?php
		$this->load->library('tank_auth');
		if(!$this->tank_auth->is_logged_in())
		{
			redirect('auth/login');
		}
?>
<!DOCTYPE html PUBLIC"-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>  ::~Dokani~::  </title>
	<link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico"  type="image/x-icon"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>style/style_main_for_sale.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>style/table_style.css" type="text/css"/>
        <link rel="stylesheet" href="<?php echo base_url(); ?>style/select2.css" type="text/css"/>
	
        <link rel="stylesheet" href="<?php echo base_url();?>style/jquery-ui.css">
	<script src="<?php echo base_url();?>js/jquery-1.10.2.js"></script>
	<script src="<?php echo base_url();?>js/jquery-ui.js"></script>
    <script src="<?php echo base_url();?>js/select2.full.js"></script>
	
	<script  src="<?php echo base_url(); ?>script/datetimepicker_css.js"></script>
	<script  src="<?php echo base_url(); ?>script/shortcut.js"></script>
	<script language="JavaScript">
		var version = navigator.appVersion;
		
		function showKeyCode(e) 
		{
			var keycode = (window.event) ? event.keyCode : e.keyCode;
			
			if ((version.indexOf('MSIE') != -1)) 
			{
				if (keycode == 116) 
				{
				event.keyCode = 0;
				event.returnValue = false;
				return false;
				}
			}
			else 
			{
				if (keycode == 116) 
				{
				return false;
				}
			}
		}
	</script>

<script type="text/javascript">	



function stopRKey(evt) {
  var evt = (evt) ? evt : ((event) ? event : null);
  var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
  if ((evt.keyCode == 13) && (node.type=="text"))  {return false;}
}

document.onkeypress = stopRKey;

</script> 


</head>
	 <body onload="JavaScript:document.body.focus(); " onkeydown="return showKeyCode(event)">
		<div id="container">  
			<div id = "main">
				<div id="header">
					<div id="top_left_logo"> 
						<img src="<?php echo base_url(); ?>images/top_logo.png">
					</div>
					
					<div id="shop_tit_box">
						<div id = "shop_titl"> <?php echo $this->tank_auth->get_shopname(); ?> </div>
						<div id = "shop_add"> <?php echo $this->tank_auth->get_shopaddress(); ?> </div>
					</div><!--end of shop_title_box-->
					
					<div id="user_info_box">
							<h1 id="welcome">Welcome!</h1>
							<p class="user_name">User Name : <?php echo $user_name; ?> </p>
							<p class="user_name">User Type : <?php echo ucfirst($user_type); ?> </p>
					</div>
					<div id="date_time_box"> 
					    <div id="day">   	
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
									var datestring=padlength(serverdate.getDate())+" "+montharray[serverdate.getMonth()]+", "+serverdate.getFullYear()+"<br/>";
									
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
					    </div>
						<div id="log_out"> 
							<a href="#"></a>
						</div>
					</div>
				</div> <!--end of header-->
				<div id="main_body">
				
					
<style type="text/css">
	.modal12345
	{
		position: fixed;
		z-index: 999;
		height: 100%;
		width: 100%;
		top: 0;
		left: 0;
		background-color: white;
		filter: alpha(opacity=60);
		opacity: 0.6;
		-moz-opacity: 0.8;
	}
	.center
	{
		z-index: 1000;
		margin: 300px auto;
		width: 350px;
		border-radius: 10px;
		filter: alpha(opacity=100);
		opacity: 1;
		-moz-opacity: 1;
	}
	.center img
	{
		margin:0px 0px 0px 100px;
	}
</style>
<div class="modal12345" style="display: none">
	<div class="center">
		<img src="<?php echo base_url();?>assets2/spin.gif" id="loaderIcon"/>
	</div>
</div>