<div>
	<?php  
	if($listed_product->num_rows() > 0 )
	{
		foreach($listed_product->result() as $row )
		{
			for( $i=0;$i < $row ->quantity; $i++) 
			{
			?>
				<div id = "inv_details_two" style="float: left; width:3.5cm; height:2.4cm; margin:0px;padding: 0px;"> 
					<center style="margin:0px; padding:0px;">
						<p style="font-size: 12px; font-weight:bold; font-family:arial; line-height: 5px; margin:5px 0px 5px 0px"><?php echo $this->tank_auth->get_shop_name();?></p>
						<img id="image1" src="<?php echo base_url().'barcode/'.$row ->barcode; ?>" style="    width:100%;height: 1cm;margin: 0px 0px 0px 0px;float: left;" />
						<p style="font-size: 9px; margin:0px; font-family:arial;"><?php echo $row ->product_name; ?> </p>
						<p style="font-size: 11px; margin:0px; font-family:arial;"><b>MRP : <?php echo $row ->sale_price; ?> TK.</b></p>
					</center>
				</div>
			<?php  
			}  
			
		}
	}
	?>
</div>