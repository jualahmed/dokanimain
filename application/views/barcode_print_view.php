<!DOCTYPE HTML>
<html>
<head>
	<title> Dokani : IT Lab Solutions </title>
	<link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico"  type="image/x-icon"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>style/table_style.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>style/invoice_style.css" type="text/css"/>
</head>
	<body onload="window.print()"> 
	 	<div id ="main_invoice">
			<div id = "invoice" >
				<div id="shop_title_box">	

						<div id = "shop_title_test">  </div>
						<div id = "shop_address_test"> </div>			
						<div id = "shop_title_test">  </div>
				</div> <!--end of shop_title_box-->

				<?php  
				if($this->session->userdata('pro_specification') == 'bulk')
				{
					//echo 'HEre';
					for( $i=0;$i < $this->session->userdata('purchase_quantity'); $i++) 
					{  
					?>
						<!--<?php echo $this->session->userdata('product_name'); ?> -->
						<div id = "inv_details_two" style="background:;width: 132px; margin-left:3px;"> 
							<div id = "right_div" style="background:; width: 132px;"> 
								<font size="1" style="margin-left:9px;">	IT LAB SOLLUTIOS  </font>
								<div class ="dot2"> <br>
										<img id="image1" src="<?php echo base_url('images/barcode/'.$this->session->userdata('product_id')); ?>  " width="130" height="60" />
										<p style="text-indent: 0px; margin-left: 13px; width: 118px; line-height:13px;"  >
										<font size="1">
											<?php echo $this->session->userdata('product_name'); ?> 
											<br>
											Haat Bazar Price : <?php echo $this->session->userdata('product_price'); ?> tk
											
											<br>
											MRP : <?php echo $this->session->userdata('general_price'); ?> tk
										</font>
								</div>  
							</div>
						</div><!--end of inv_details_2-->
					<?php  
					}  
				}
				else
				{
					//echo $this->session->userdata('pro_specification').'lol ';
					for( $i=$this->session->userdata('stock_start');$i <= $this->session->userdata('stock_end'); $i++) 
					{  
					?>
						<!--<?php echo $this->session->userdata('product_name'); ?> -->
						<div id = "inv_details_two" style="background:;width: 132px; margin-left:3px;"> 
							<div id = "right_div" style="background:; width: 132px;"> 
								<font size="1" style="margin-left:9px;">		IT LAB SOLLUTIOS  </font>
								<div class ="dot2"> <br>
										<img id="image1" src="<?php echo base_url('images/barcode/'.$i); ?>  " width="130" height="60" />
										<p style="text-indent: 0px; margin-left: 13px; width: 118px; line-height:13px;"  >
										<font size="1">
											<?php echo $this->session->userdata('product_name'); ?> 
											<br>
											Price : <?php echo $this->session->userdata('product_price'); ?> tk
										</font>
								</div>  
							</div>
						</div><!--end of inv_details_2-->
					<?php  
					}  
				}
				?>
				</div> <!--end of invoice_details_header-->
			</div> <!--end of invoice -->
		</div> <!--end of main_invoice -->
	</body>
</html>	
