<!DOCTYPE HTML>
<html>
<head>
	<title> Dokani : IT Lab Solutions </title>
	<link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico"  type="image/x-icon"/>
	<style>
		#invoice{
			~min-height:500px;
		}
	</style>
</head>
	<body onload="window.print()" style="margin:0px; padding:0px; "> 

				<?php  
				if($listed_product->num_rows() > 0 )
				{
					foreach($listed_product->result() as $row )
					{
						for( $i=0;$i < $row -> purchase_quantity; $i++) 
						{
						?>
							<!--<?php echo $this->session->userdata('product_name'); ?> -->
							<div id = "inv_details_two" style="float: left; width:3.5cm; height:2.4cm; margin:0px;padding: 0px;"> 
									<center style="margin:0px; padding:0px;">
									<p style="font-size: 12px; font-weight:bold; font-family:arial; line-height: 5px; margin:5px 0px 5px 0px"><?php echo $this->tank_auth->get_shop_name();?></p>
									<img id="image1" src="<?php echo base_url().'images/barcode/'.$row ->barcode; ?>" style="    width:100%;height: 1cm;margin: 0px 0px 0px 0px;float: left;" />
									
									<p style="font-size: 9px; margin:0px; font-family:arial;"><?php echo $row ->product_name; ?> </p>
									<!--p style="font-size: 11px; margin:0px; font-family:arial;"><b>MRP : <?php echo $row ->product_price; ?> TK.</b></p-->
									<p style="font-size: 11px; margin:0px; font-family:arial;"><b>MRP : <?php echo $row ->general_price; ?> TK.</b></p>
									</center>
								
							</div><!--end of inv_details_2-->
						<?php  
						}  
						
					}
				}
				?>
	</body>
</html>	
