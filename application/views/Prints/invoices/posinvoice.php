<!DOCTYPE HTML>
<html>
<head>
	<title> Dokani : IT Lab Solutions </title>
	<meta lang="en">
	<meta lang="bn">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico"  type="image/x-icon"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/posinvoice.css" type="text/css"/>
	<style>
		.pos_top_header_fourth_left{
			width: 74%;
		}
		.pos_top_header_fourth_right{
			width: 25%;
		}
	</style>
</head>
	<body> 
		<div id= "main_container_body_main">
			<div id= "main_container_body_main2">
				<!-- <input type="hidden" id="confirms_sale_ids" value="<?php echo base_url();?>sale_controller/arun_sale"> -->

		<div id= "main_container_body">
			
			<div style="float:left; background: #fff;text-decoration: none;">
				<!--img src="<?php echo base_url();?>images/medical2.jpg" class="img-circle" style="width:50px; height:50px;" alt="User Image"-->
			</div>
			<div id ="pos_top_header" style="text-align:center;">
				<a href="<?php echo base_url();?>sale_controller/new_sale" autofocus style="text-decoration: none;">
				<div id ="" style=" background: #fff;text-decoration: none;"> 
					<?php
						$shop_id=$this->tank_auth->get_shop_id();
						$this->db->where('shop_id',$shop_id);
						$shop_info=$this->db->get('shop_setup')->row();
					?>
					<?php if (isset($shop_info->invoicelogo)): ?>
						<img style="width: 140px;" src="<?php echo base_url();?>assets/img/shop/<?php echo $shop_info->invoicelogo ?>">
					<?php else: ?>
						<img style="width: 50%;height: 100px" src="<?php echo base_url();?>assets/img/top_logo2.png">
					<?php endif ?> 
			</div> 
				
				</a>
			</div>
		
			<?php $row_data = $sale_info->row(); ?>
			<div style="display: flex;font-size: 13px;justify-content: center;font-weight: 700;margin-left: 6px;">
				<div>
					<p>Invoice : <?php echo $invoice_id; ?></p>
					<p>Creator : <?php echo $row_data->username; ?></p>
					<p>Date : <?php $newDate = date("d-m-Y", strtotime($row_data->invoice_doc));echo $newDate; ?></p>
				</div>
				<div>
					<p>Time : <?php $newDate1 = date("h:i A",strtotime($row_data->date_time));echo $newDate1; ?></p>
					<p>Customer : <?php echo $row_data->customer_name; ?></p>
				</div>
			</div>
		
			<div id ="pos_top_header_thired">
			<?php
				if($sale_info -> num_rows() > 0) 
				{
			?>
				<div class="CSSTableGenerator" style="width:100%;margin:0px auto;float:left">
					<table >	
						<tr>
							<!--<td >ID</td> -->
							<td >Product Name</td>
							<td >Qty </td>
							<td >MRP</td>
							<td >Sale</td>
							<td >Total</td>
						</tr>
						<?php
							$save1 = 0;
							foreach ($sale_info -> result() as $field):
						?>
						<tr>
							<!--<td style="width:2%"> <?php echo $field->product_id;?> </td> -->
							<td style="text-align:left;">
								
								<?php
									
									if($sale_warranty_info != '')
									{
										echo '<p style="min-height:13px;font-size:10px;font-weight:bold;margin:0px;">'.$field -> product_name.'</p>';
										//echo 'SN ';
										foreach($sale_warranty_info -> result() as $filed2)
										{
											if($field->product_id==$filed2->product_id)
											{
												echo $filed2->sl_no .'  '.'  ';
											}
										}
									}
									else
									{
										echo '<p style="min-height:13px;font-size:10px;font-weight:bold;margin:0px;">'.$field -> product_name.'</p>';
									}
								?>
							</td>
							<td style="width:10%;">
								<?php 
									echo $field -> sale_quantity;
								?>
							</td>
							<td style="width:10%;text-align:right;">
								<?php 
									echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> '.round( $field-> unit_sale_price, 2);
								?> 
							</td>
							<td style="width:10%;text-align:right;">
								<?php 
									echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> '.round( $field-> general_sale_price, 2);
									
									$save1 = $save1 + (round($field-> unit_sale_price, 2)*$field ->sale_quantity - 
											round($field-> general_sale_price, 2)*$field ->sale_quantity );
											
								?> 
							</td>
							
							<td style="width:12%;text-align:right;border-right:0px solid black;">
								<?php 
									echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> '.round(( $field -> sale_quantity * $field-> general_sale_price), 2);
								?> 
							</td>
						</tr>
						<?php
							endforeach;
						?>	
						<tr>
							<td colspan="5" style="text-align:left;"> <i><b><?php echo $in_word; ?> Taka Only.</b></i></td>
						</tr>
					</table>	
				</div>
				<?php  
					}
				?>
			</div>
			<div id ="pos_top_header_fourth" style="width: 50%; float: right;">
				<div class ="pos_top_header_fourth_left"> Total Amount </div>
				<div class ="pos_top_header_fourth_right"> <?php if($save1 > 0){echo round(($final_total = $save1+$row_data->total_price),2);}else{ echo $final_total = $row_data->total_price; } ?></div>
				<?php if($row_data->sale_return_amount > 0){ ?>
				<div class ="pos_top_header_fourth_left"> Sale Return</div>
				<div class ="pos_top_header_fourth_right"> <?php  echo $row_data->sale_return_amount;?></div>
				<?php } ?>
				<div class ="pos_top_header_fourth_left"> Product Discount</div>
				<div class ="pos_top_header_fourth_right"> <?php  echo $save1;?></div>
				<div class ="pos_top_header_fourth_left"> Special Discount </div>
				<div class ="pos_top_header_fourth_right"> <?php echo $row_data->discount_amount; ?></div>
				<?php 
					$sale_return = $row_data->sale_return_amount;
					$total_price = $row_data->total_price;
				?>
				<?php 
				if($sale_return > 0)
				{ 
				?>
				<div class ="pos_top_header_fourth_left"> Grand Total</div>
				<div class ="pos_top_header_fourth_right"> <?php  echo $row_data->total_price - $sale_return - $row_data->discount_amount;?></div>
				<div class ="pos_top_header_fourth_left"> Paid </div>
				<?php $total_paid = $row_data->total_price - $sale_return; ?>
				<div class ="pos_top_header_fourth_right"> <?php echo $row_data->total_paid; ?></div>
				<?php 
				} 
				else 
				{
				?>
				<div class ="pos_top_header_fourth_left"> Grand Total </div>
				<div class ="pos_top_header_fourth_right"> <?php echo $row_data->grand_total; ?></div>
				<div class ="pos_top_header_fourth_left"> Paid </div>
				<?php $total_paid = $row_data->total_paid; ?>
				<div class ="pos_top_header_fourth_right"> <?php echo $total_paid; ?></div>
				<?php 
				} 
				?>

				<div class ="pos_top_header_fourth_left"> Return </div>
				<div class ="pos_top_header_fourth_right"> <?php echo $row_data->return_money; ?></div>
				<?php if($row_data->grand_total > $row_data->total_paid){ ?>
				<div class ="pos_top_header_fourth_left"> Due </div>
				<div class ="pos_top_header_fourth_right"> <?php echo $row_data->grand_total - $row_data->total_paid; ?></div>
				<?php } ?>
			</div>
			<div class ="pos_top_header_fotter" style="font-size: 12px;margin-top:5px;"> Thank You For Shopping. </div>
			<div style="border-top: 1px solid gray; width: 100%; height: 1px; float:left;"> </div>
			
			<div class ="pos_top_header_fotter" style="background:;line-height:12px;margin-top:5px;">Software Developed By:<br /> <b>IT Lab Solutions Ltd.</b> Call: +8801842485222</div>
		</div> <!--End of main container body -->
	</div>
		</div> <!--End of main container body -->
	</body>
</html>	
