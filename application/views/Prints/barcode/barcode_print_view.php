<!DOCTYPE HTML>
<html>
<head>
  <title> Dokani : IT Lab Solutions </title>
  <link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico"  type="image/x-icon"/>
  <style>
  @media print {

  }
  *, *::after, *::before {
    padding: 0;
    margin: 0;
    outline: 0;
}
img {
	width: 100%;
	height: 100%;
	max-width: 100%;
	max-height: 100%;
}
@media print {
	.barcode {
		display: block; 
		page-break-before: always;
	}
}
  </style>
</head>
<body class="text-center"> 
<div class="page-header">
  <div>
  	<?php  
    	if($listed_product->num_rows() > 0 )
    	{
    		foreach($listed_product->result() as $row )
    		{
    			for( $i=0;$i < $row ->quantity; $i++) 
    			{
    			?>
    				<div class="barcode"> 
    					<center style="margin:0px; padding:0px;">
    						<p style="font-size: 10pt; font-weight:bold; font-family:arial; line-height: 5px; margin:12px 0px 5px 0px"><?php echo $this->tank_auth->get_shop_name();?></p>
    						<img id="image1" src="<?php echo base_url().'barcode/'.$row ->barcode; ?>" style="    width:100%;height: 1cm;margin: 0px 0px 0px 0px;float: left;" />
    						<p style="font-size: 7pt; margin:0px; font-family:arial;"><?php echo $row ->product_name; ?> </p>
    						<p style="font-size: 9pt; font-family:arial;"><b>MRP : <?php echo $row ->sale_price; ?> TK.</b></p>
    					</center>
    				</div>
    			<?php  
    			}  	
    		}
    	}
  	?>
  </div>
</div>
</body>
</html>