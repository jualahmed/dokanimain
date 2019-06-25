<!DOCTYPE HTML>
<html>
<head>
	<title>  ::~Dokani~::  </title>
	<link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico"  type="image/x-icon"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>style/style_main.css" type="text/css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>style/style_common.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>style/style5.css" />
	
	<?php
	echo link_tag('assets/css/cupertino/jquery-ui.min.css');
	echo link_tag('assets/css/bootstrap.min.css');	
	echo link_tag('assets/css/bootstrap-theme.min.css');
	echo link_tag('assets/css/font-awesome.min.css');
	echo link_tag('assets/css/bootstrap-tagsinput.css');
	echo link_tag('assets/custom_style.css');
	?>
</head>
	 <body>
		<div id="container">  
			<div id = "main">
				<div id="header">
					<div id="top_left_logo"> 
						<img src="<?php echo base_url(); ?>images/top_logo.png">
					</div>
					
					<div id="shop_tit_box">
						<div id = "shop_titl"> <?php echo $this->tank_auth->get_shopname(); ?> <!-- Dey's Pharma --></div>
						<div id = "shop_add"> <?php echo $this->tank_auth->get_shopaddress(); ?> <!--Chouhatta, Sylhet--></div>
					</div><!--end of shop_title_box-->
					
					<div id="user_info_box">
							<h1 id="welcome">Welcome!</h1>
							<p class="user_name">Name : <?php echo $user_name;  ?></p>
							<p class="user_name">Type : <?php echo ucfirst($user_type);  ?></p>
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
					<div id = "top_menu">
						<?php $this -> load -> view('top_link_view'); ?>
					</div>
					
					
					<div id = "middle_sale" >
						<div class="mid_box">
							<div class="mid_box_top">
								<p>Home Page</p>
							</div>
							<div class="mid_box_middle" style="margin-left:6px;">	
								<!--
								<div class = "HomeTitleBox">
									<img src="<?php echo base_url(); ?>images/report_btn.jpg">
									<p> Today's Statement </p>
								</div>
								<div class = "HomeField_Container_Box" >
									<p> Total Sale:</p>
									<h2>
										<?php
											echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> '.round($sale_price_info, 2);
											if($sale_price_info == round($sale_price_info, 0))
												echo'.00';
											else if(round($sale_price_info, 1) == round($sale_price_info, 2))
												echo'.00';
											echo nbs(2); 
										?>
									</h2>
								</div>
								<div class = "HomeField_Container_Box" >
									<p> Total Purchase:</p>
									<h2>
										<?php
											echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> '.round($purchase_info, 2);
											if($purchase_info == round($purchase_info, 0))
												echo'.00';
											else if(round($purchase_info, 1) == round($purchase_info, 2))
												echo'.00';
											echo nbs(2); 
										?>
									</h2>
								</div>
								<div class = "HomeField_Container_Box" >
									<p> Total Expense:</p>
									<h2>
										<?php
											echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> '.round($expense_info, 2);
											if($expense_info == round($expense_info, 0))
												echo'.00';
											else if(round($expense_info, 1) == round($expense_info, 2))
												echo'.00';
											echo nbs(2); 
										?>
									</h2>
								</div>
								<div class = "HomeField_Container_Box" >
									<p> Total Due on Sale:</p>
									<h2>
										<?php
										
										    if(($sale_price_info - $cash_info) < 0)
										    {
												echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> 0.00'.nbs(2);
											}
											else
											{
												echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> '.round(($sale_price_info - $cash_info) , 2);
												if(($sale_price_info - $cash_info) == round(($sale_price_info - $cash_info), 0))
													echo'.00';
												else if(round($sale_price_info - $cash_info, 1) == round($sale_price_info - $cash_info, 2))
													echo'.00';
												echo nbs(2); 
											}
										?>
									</h2>
								</div>
								
								<div class = "HomeField_Container_Box" style="" >
									<p> Cash Received:</p>
									<h2>
										<?php
											echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> '.round($cash_info, 2);
											if($cash_info == round($cash_info, 0))
												echo'.00';
											else if(round($cash_info, 1) == round($cash_info, 2))
												echo'.0';
											echo nbs(2); 
										?>
									</h2>
								</div>
								
								<a href="<?php echo base_url().'index.php/report_controller/specific_date_report_for_financial_statement/'.$bd_date; ?>"> 
									<div class="mid_box_middle_footer" >	
										<img src="<?php echo base_url(); ?>images/report_btn.jpg">
										Details View
									</div>
							    </a>
								-->
							</div> <!--End of mid_box_middle For "Today's Account Statement"-->
							<a href="<?php echo base_url().'index.php/report_controller/financial_report'; ?>"> 
								<div class="mid_box_middle_2"> 
									<div class="view view-fifth bg-img1">
										<img src="<?php echo base_url();?>/images/fs_dokani.jpg"/>
										<div class="mask">
											<h2>Financial Statement</h2>
										</div>
									</div>
								</div>
							</a> 
							<a href="<?php echo base_url().'index.php/modify_controller/sale_modify'; ?>"> 
								<div class="mid_box_middle_2"> 
									<div class="view view-fifth bg-img2">
										<img src="<?php echo base_url();?>/images/sr_dokani.jpg"/>
										<div class="mask">
											<h2>Sale Return</h2>
										</div>
									</div>
								</div>
							</a>  
							<a href="<?php echo base_url().'index.php/report_controller/specific_date_invoice/'.$bd_date; ; ?>"> 
								<div class="mid_box_middle_2"> 
									<div class="view view-fifth bg-img3">
										<img src="<?php echo base_url();?>/images/ti_dokani.jpg"/>
										<div class="mask">
												<h2>Today's Invoices</h2>
										</div>
									</div>
								</div>
							</a> 
							<a href="<?php echo base_url().'index.php/account_controller/transaction_entry'; ?>"> 
								<div class="mid_box_middle_2"> 
									<div class="view view-fifth bg-img4">
										<img src="<?php echo base_url();?>/images/ct_dokani.jpg"/>
										<div class="mask">
											<h2>Create Transaction</h2>
										</div>
									</div>
								</div>
							</a> 
							<a href="<?php echo base_url().'index.php/report_controller/product_statistics'; ?>"> 
								<div class="mid_box_middle_2"> 
									<div class="view view-fifth bg-img5">
										<img src="<?php echo base_url();?>/images/ps_dokani.jpg"/>
										<div class="mask">
											<h2>Product Statistics</h2>
										</div>
									</div>
								</div>
							</a> 
							<a href="<?php echo base_url().'index.php/report_controller/all_credit_transactions'; ?>"> 
								<div class="mid_box_middle_2"> 
									<div class="view view-fifth bg-img6">
										<img src="<?php echo base_url();?>/images/cl_dokani.jpg"/>
										<div class="mask">
											<h2>Credit List</h2>
										</div>
									</div>
								</div>
							</a> 
						</div>					
					</div>	
				</div> <!--end of main_body-->
	<div class="modal fade" id="show_login_modal" >
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title"><i class="fa fa-plus"></i> User Login</h4>
		  </div>
		  <form id="another_login_form" action="<?php echo base_url(); ?>index.php/auth/another_login" method="post" autocomplete="off" enctype="multipart/form-data" role="form">
		  <div class="modal-body">
			<div class="input-group input-group-sm">
			  <span class="input-group-addon">User Name</span>
			  <input name="login" type="text" class="form-control userr_name" placeholder="User Name" required="required" />
			</div>
			<div class="separator10"></div>
			<div class="input-group input-group-sm">
			  <span class="input-group-addon">Password</span>
			  <input name="password" type="password" class="form-control user_pass" placeholder="Password" required="required" />
			</div>
			<div class="separator10" id="mssage_log"></div>
			
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary">Login</button>
			<button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		  </form>
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div>
	
	
		<div style="display: none;">
			<script src="<?php echo base_url(); ?>assets/js/jquery-2.1.3.min.js" type="text/javascript"></script>
			<script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js" type="text/javascript"></script>
			<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js" type="text/javascript"></script>
			<script src="<?php echo base_url(); ?>assets/js/bootbox.min.js" type="text/javascript"></script>
			<script src="<?php echo base_url(); ?>assets/js/bootstrap-tagsinput.min.js" type="text/javascript"></script>
			<script src="<?php echo base_url(); ?>assets/js/bootstrap-tagsinput-angular.min.js" type="text/javascript"></script>
			<script src="<?php echo base_url(); ?>assets/custom_script.js" type="text/javascript"></script>
			<input type="hidden" value="<?php echo base_url();?>extra_controller/retrive_and_select" id="ret_and_sel" >
			<input type="hidden" value="<?php echo base_url();?>extra_controller/retrive_and_select_with_id" id="ret_and_sel_with_id" >
		</div>		
			    <div id="footer">
					<p id="shop_copyright"> &#169; IT Lab Solutions, Zindabazar,Sylhet.</p>
					
					<p id="dokani_copyright">
					    &reg; <b>DOKANI</b> 
						&copy; <a href="#">IT Lab Solutions</a>+8801842485222
					</p>	
				</div><!--end of footer-->
			</div> <!--end of main-->
		</div><!--end of container-->
     </body><!--end of body-->
</html>		
	
