<!DOCTYPE HTML>
<html>
<head>
	<title> Dokani : IT Lab Solutions </title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico"  type="image/x-icon"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>style/POS_table_style.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>style/POS_invoice_style.css" type="text/css"/>
	<style>
		.pos_top_header_fourth_left{
			width: 69%;
		}
		.pos_top_header_fourth_right{
			width: 30%;
		}
		#price_quotation{
			width: 100%;
			height: 40px;
			margin: -20px 0px 0px 0px;
			text-align: center;
			float: right;
		}

	</style>
</head>
	<body onload="window.print()">
	<!-- <body> -->
		<div id= "main_container_body_main">
			<div id= "main_container_body_main2">


		<div id= "main_container_body">
			<div id ="pos_top_header">
				<a href="<?php echo base_url();?>sale_controller/my_sale" autofocus>
				<div id ="pos_top_header_left"> <img style="height:90px;width: 100%;" src="<?php echo base_url();?>images/pos_logo.JPG"/></div>
				
				</a>
				<div id ="price_quotation"><h3>Price Quotation</h3></div>
			</div>
			<div class ="pos_top_header_second">
				<div class ="pos_top_header_second_left">Temp ID : <?php echo $invoice_id; ?></div>
				<div class ="pos_top_header_second_middle"> Creator: <?php echo $invoice_creator; ?></div>
				<div id ="pos_top_header_second_right">Date : <?php $newDate = date("d-m-Y", strtotime($invoice_doc));echo $newDate; ?></div>
			</div>
			<div class ="pos_top_header_second" style="background:;">
			</div>
			<div id ="pos_top_header_thired">
			<?php
			$save = 0;
				if($invoiceSoldProduct -> num_rows() > 0) 
				{
			?>
				<div class="CSSTableGenerator" style="width:100%;margin:0px auto;float:left">
					<table >	
						<tr>
							<!--<td >ID</td> -->
							<td >Product Name</td>
							<td >Qty </td>
							<td >MRP</td>
							<td >HBP</td>
							<td >Total</td>
						</tr>
						<?php
							$save = 0;
							foreach ($invoiceSoldProduct -> result() as $field):
						?>
						<tr>
							<!--<td style="width:2%"> <?php echo $field->product_id;?> </td> -->
							<td style="text-align:left;">
								<?php 
									echo '<h1 style="min-height:13px;font-size:12px;font-weight:normal;margin:0px;">'.$field -> product_name.'</h1>';
									if($field -> product_specification == 'individual')
									echo '<h1 style="height:10px;font-size:9px;font-weight:normal;margin:0px;text-indent:15px;">'.$individual_product_stock_id[ $field -> product_id ].'</h1>';
								?>
							</td>
							<td style="width:10%;">
								<?php 
									echo $field -> sale_quantity_sum.' '.$field -> unit_name;
								?>
							</td>
							<td style="width:10%;text-align:right;">
								<?php 
									echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> '.round( $field-> general_unit_sale_price, 2);
									
									$save = $save + (round($field-> general_unit_sale_price, 2)*$field ->sale_quantity_sum - 
											round($field-> actual_sale_price, 2)*$field ->sale_quantity_sum );
								?> 
							</td>
							<td style="width:10%;text-align:right;">
								<?php 
									echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> '.round( $field-> actual_sale_price, 2);
								?> 
							</td>
							<td style="width:12%;text-align:right;border-right:0px solid black;">
								<?php 
									echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> '.round(( $field -> sale_quantity_sum * $field-> unit_sale_price), 2);
								?> 
							</td>
						</tr>
						<?php
							endforeach;
						?>	
						
						<tr>
							<td colspan="5" style="text-align:left;"> <i><b><?php echo $number_to_text; ?> Taka Only.</b></i></td>
						</tr>
					</table>	
				</div>
				<?php  
					}
				?>
			</div>
			<div id ="pos_top_header_fifth" style="width: 59%; float: left;">
				<div id="savving" style="font-size: 13px; width: 99%; text-align: center;padding-top: 5px;margin-top:5px;">
					<?php if($save > 0){ ?><b> <?php  echo string_replace($save);?><big style = "font-weight:bold;">&#2547; </big> <br /><span style="font-size: 16px;">সাশ্রয় হবে । </span></b> <?php } ?>
				</div>
			</div>
			<div id ="pos_top_header_fourth" style="width: 40%; float: right;">
				<div class ="pos_top_header_fourth_left"> Grand Total </div>
				<div class ="pos_top_header_fourth_right"> <?php echo $grand_total; ?></div>
			</div>
			
			<div class ="pos_top_header_fotter"> Thank You For Shopping With Us.</div>
			<div style="border-top: 1px solid gray; width: 100%; height: 1px; float:left;"> </div>
			
			<div class ="pos_top_header_fotter" style="background:;line-height:10px;">Developed By: <b>IT Lab Solutions</b> Call: 8801842485222</div>
		</div> <!--End of main container body -->
	</div>
		</div> <!--End of main container body -->
	</body>
</html>	
<?php
	
	function string_replace($str)
	{ 
		$from = array(
			"1", "2", "3", "4", "5", "6", "7", "8", "9", "0"
		); 
		$to = array(
			"১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০"
		);
		return    str_replace($from, $to, $str); 
	}
?>