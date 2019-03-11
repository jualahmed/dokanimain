<!DOCTYPE HTML>
<html>
<head>
	<title> Dokani : IT Lab Solutions </title>
	<link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico"  type="image/x-icon"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>style/table_style.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>style/invoice_style.css" type="text/css"/>
	<style>
		#invoice{
			min-height:500px;
		}
	</style>
</head>
	<body onload="window.print()"> 
	 	<div id ="main_invoice">
			<div id = "invoice" style="margin:0px;width:800px;">
				<div id="shop_title_box">	

						<div id = "shop_title_test">  </div>
						<div id = "shop_address_test"> </div>			
						<div id = "shop_title_test">  </div>
				</div> <!--end of shop_title_box-->

				<?php  
				if($listed_product->num_rows() > 0 )
				{
				foreach($listed_product->result() as $row ){
					for( $i=0;$i < $row -> purchase_quantity; $i++) 
					{
					?>
						<!--<?php echo $this->session->userdata('product_name'); ?> -->
						<div id = "inv_details_two" style="background:;width: 147px; margin-left:1px;"> 
							<div id = "right_div" style="margin:0px;background:; width: 145px;text-align:center;"> 
								<font size="3">	<?php echo $this->tank_auth->get_shop_name();?></font>
								<div class ="dot2" style=> <br>
										<img id="image1" src="<?php echo base_url().'images/barcode/'.$row ->barcode; ?>  " width="145" height="50" />
										<p style="text-indent: 0px; text-align: center;margin-bottom: 5px; width: 140px; line-height:0px;"  >
										<font size="" style="text-align:center;font-size:11px;line-height:14px;">
											<?php echo $row ->product_name; ?> 
											<br />
											MRP : <span style="font-size:13px;"><?php echo $row ->product_price; ?> tk </span>
										</font></p>
								</div>  
							</div>
						</div><!--end of inv_details_2-->
					<?php  
					}  
					
				}
				}
				else
				{
					/* $selected_barcodes   = $this->session->userdata('selected_barcodes');
					for( $i=0 ;$i <  sizeof($selected_barcodes); $i++) 
					{  
					?>
						<!--<?php echo $this->session->userdata('product_name'); ?> -->

						<div id = "inv_details_two" style="background:;width: 132px; margin-left:3px;"> 
							<div id = "right_div" style="background:; width: 132px;"> 
								<font size="1" style="margin-left:9px;"><?php echo $this->tank_auth->get_shop_name();?></font>
								<div class ="dot2"> <br>
										<img id="image1" src="<?php echo base_url('images/barcode/'.$selected_barcodes[$i]); ?>  " width="130" height="60" />
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
					} */
					
					echo 'No Product Selected';
				}
				?>
				</div> <!--end of invoice_details_header-->
			</div> <!--end of invoice -->
		</div> <!--end of main_invoice -->
	</body>
</html>	
