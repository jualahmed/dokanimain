<!DOCTYPE HTML>
<html>
<head>
	<title> Dokani : IT Lab Solutions </title>
	<meta lang="en">
	<meta lang="bn">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico"  type="image/x-icon"/>
	<!--link rel="stylesheet" href="<?php echo base_url(); ?>style/POS_table_style.css" type="text/css"/-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>style/POS_invoice_style.css" type="text/css"/>
	<script src="<?php echo base_url();?>js/jquery-1.10.2.js"></script>
	<style>
		.pos_top_header_fourth_left{
			width: 74%;
		}
		.pos_top_header_fourth_right{
			width: 25%;
		}
		table {
			width:100%;
			border-collapse: collapse;
		}

		table, th, td{
			border:1px solid black;
		}
	</style>
<!--	<script language='VBScript'>
	Sub Print()
		   OLECMDID_PRINT = 6
		   OLECMDEXECOPT_DONTPROMPTUSER = 2
		   OLECMDEXECOPT_PROMPTUSER = 1
		   call WB.ExecWB(OLECMDID_PRINT, OLECMDEXECOPT_DONTPROMPTUSER,1)
	End Sub
	document.write "<object ID='WB' WIDTH=0 HEIGHT=0 CLASSID='CLSID:8856F961-340A-11D0-A96B-00C04FD705A2'></object>"
	</script>-->
	
<!--	<script>
		shortcut.add("Enter",function() {
			var submiturl = $("#confirms_sale_ids").val();
			window.location.href =  submiturl;
		});	
	</script>-->
	
<script type="text/javascript">
	$(function(){
		window.onload	= function(){ self.print();}
		window.onfocus	= function(){ window.close();}
		// window.print();
		// window.close();
	});

</script>
</head>
	<body> 
		<div id= "main_container_body_main">
			<div id= "main_container_body_main2">
				<!-- <input type="hidden" id="confirms_sale_ids" value="<?php echo base_url();?>sale_controller/arun_sale"> -->

		<div id= "main_container_body">
			
			<div style="float:left; background: #fff;text-decoration: none;">
				
			</div>
			<div id ="pos_top_header">
				<a href="<?php echo base_url();?>sale_controller/new_sale" autofocus style="text-decoration: none;">
					<a href="<?php echo base_url();?>sale_controller/new_sale" autofocus style="text-decoration: none;">
					<center><img src="<?php echo base_url();?>images/common_logo_invoice.png" class="img-circle" style="width:60%; height:80px;" alt="User Image"></center>
				<div id ="" style="background: #fff;text-decoration: none;"> 
					<h6 style="font-size:14px;line-height: 12px;text-align:center;margin: 5px 5px;background: #fff;text-decoration: none;color:#000;"><?php echo $this->tank_auth->get_shopname();?></h6>
					<h6 style="font-size:12px;line-height: 12px;text-align:center;margin: 0px 5px;background: #fff;text-decoration: none;color:#000;"><?php echo $this->tank_auth->get_shopaddress();?></h6>
					<h6 style="font-size:12px;line-height: 12px;text-align:center;margin: 0px 5px;background: #fff;text-decoration: none;color:#000;">Contact: <?php echo $this->tank_auth->get_shopcontact();?></h6>
				</div> 
				
				</a>
				<!-- <div id ="pos_top_header_right"></div> -->
			</div>
			<?php 
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
			?>
			<div class ="pos_top_header_second"><?php $row_data = $sale_info->row(); ?>
				<div class ="pos_top_header_second_left" style="font-weight: bold; width:100%;text-align:center;    font-size: 16px;">Invoice : <?php echo $invoice_id; ?></div>
			</div>
			<div class ="pos_top_header_second"><?php $row_data = $sale_info->row(); ?>
				
				<div class ="pos_top_header_second_middle" style="font-weight: bold; width:50%;text-align:left; "> Creator : <?php echo $row_data->username; ?></div>
				<div class ="pos_top_header_second_left" style="font-weight: bold; width:50%;text-align:right;"><?php echo $row_data->date_time;?></div>
			</div>
			
			<div class ="pos_top_header_second">
				<div class ="pos_top_header_second_left_two" style="font-weight: bold;width:100%; "><?php echo $row_data->customer_name; ?>, <?php echo $row_data->customer_address; ?></div>
			</div>
			<div class ="pos_top_header_second">
				<div class ="pos_top_header_second_left_two" style="font-weight: bold;width:100%; "><?php echo $row_data->customer_contact_no; ?></div>
			</div>
			<div id ="pos_top_header_thired">
			<?php
				if($sale_info -> num_rows() > 0) 
				{
			?>
				<div style="width:100%;margin:0px auto;float:left;">
					<table>	
						<tr>
							<!--<td >ID</td> -->
							<th style="text-align:left;">Product</th>
							<th>Q</th>
							<th>GP</th>
							<th>NMH</th>
							<th>Tot</th>
						</tr>
						<?php
							$save1 = 0;
							foreach ($sale_info -> result() as $field):
						?>
						
						<tr>
							<td style="text-align:left;font-size: 12px;">
								<?php 
									echo '<p style="min-height:13px;font-size:11px;font-weight:normal;margin:0px;">'.$field -> product_name.'</p>';
									//if($field -> product_specification == 'individual')
									//echo '<h1 style="height:10px;font-size:9px;font-weight:normal;margin:0px;text-indent:15px;">'.$individual_product_stock_id[ $field -> product_id ].'</h1>';
								?>
							</td>
							<td style="width:10%;font-size: 12px;text-align:center;">
								<?php 
									echo $field -> sale_quantity;
								?>
							</td>
							<td style="width:10%;font-size: 12px;text-align:center;">
								<?php 
									echo sprintf('%0.2f',$field-> unit_sale_price);
								?>
							</td>
							<td style="width:10%;text-align:right;font-size: 12px;">
								<?php 
									echo sprintf('%0.2f',$field-> general_sale_price);
									
									$save1 = $save1 + (round($field-> unit_sale_price, 2)*$field ->sale_quantity - 
											round($field-> general_sale_price, 2)*$field ->sale_quantity );
											
								?> 
							</td>
							
							<td style="width:12%;text-align:right;font-size: 12px;">
								<?php 
									echo round(( $field -> sale_quantity * $field-> general_sale_price), 2);
								?> 
							</td>
						</tr>
						<?php
							endforeach;
						?>
						
						<tr>
							<td colspan="5" style="text-align:left;font-weight:normal;font-size: 10px;"> <i><b><?php echo $in_word; ?> Taka Only.</b></i></td>
						</tr>
					</table>	
				</div>
				<?php  
					}
				?>
			</div>
			<div id ="pos_top_header_fifth" style="width: 40%; float: left;">
				<div id="savving" style="font-size: 13px; width: 99%; text-align: center;padding-top: 5px;margin-top:5px;">
					<?php if(($save1+$row_data->discount_amount) > 0){ ?><b> <?php echo $save1+$row_data->discount_amount;?><big styl="font-weight:bold;">&#2547; </big> <br /><span style="font-size: 16px;">সাশ্রয় হল । </span></b> <?php } ?>
				</div>
			</div>
			<div id ="pos_top_header_fourth" style="width: 60%; float: right;">
				<div class ="pos_top_header_fourth_left"> Total Amount </div>
				<div class ="pos_top_header_fourth_right"> <?php if($save1 > 0){echo round(($final_total = $save1+$row_data->total_price),2);}else{ echo $final_total = $row_data->total_price; } ?></div>
				<?php if($row_data->sale_return_amount > 0){ ?>
				<div class ="pos_top_header_fourth_left"> Sale Return</div>
				<div class ="pos_top_header_fourth_right"> <?php  echo $row_data->sale_return_amount;?></div>
				<?php } ?>
				<div class ="pos_top_header_fourth_left"> Product Discount</div>
				<div class ="pos_top_header_fourth_right"> <!-- Calculating the price discount  Start -->
					<?php 
					if($save1 > 0)
					{
						echo $save1;
					}
					else{
						echo '0';
					}
					?>
						<!-- Calculating the price discount  End-->
				</div>
				<div class ="pos_top_header_fourth_left"> Special Discount </div>
				<div class ="pos_top_header_fourth_right"> <?php echo $row_data->discount_amount; ?></div>
				<div class ="pos_top_header_fourth_left"> VAT </div>
				<div class ="pos_top_header_fourth_right"> 0</div>
				<div class ="pos_top_header_fourth_left"> Delivery Charge </div>
				<div class ="pos_top_header_fourth_right"> <?php echo $row_data->delivery_charge; ?></div>
				<?php 
					$sale_return = $row_data->sale_return_amount;
					$total_price = $row_data->total_price;
					$delivery_charge = $row_data->delivery_charge;
				?>
				<?php 
				if($sale_return > 0)
				{ 
				?>
				<div class ="pos_top_header_fourth_left"> Grand Total</div>
				<div class ="pos_top_header_fourth_right"> <?php  echo $row_data->total_price - $sale_return - $row_data->discount_amount + $delivery_charge;?></div>
				<div class ="pos_top_header_fourth_left"> Paid </div>
				<?php $total_paid = $row_data->total_price - $sale_return; ?>
				<div class ="pos_top_header_fourth_right"> <?php echo $row_data->total_paid; ?></div>
				<?php 
				} 
				else 
				{
				?>
				<div class ="pos_top_header_fourth_left"> Grand Total </div>
				<div class ="pos_top_header_fourth_right"> <?php echo $row_data->grand_total + $delivery_charge; ?></div>
				<div class ="pos_top_header_fourth_left"> Paid </div>
				<?php $total_paid = $row_data->total_paid; ?>
				<div class ="pos_top_header_fourth_right"> <?php echo $total_paid; ?></div>
				<?php 
				} 
				?>

				<div class ="pos_top_header_fourth_left"> Return </div>
				<div class ="pos_top_header_fourth_right"> 
				<?php 
					if($row_data->return_money!=0)
					{
						echo $row_data->return_money - $delivery_charge; 
					}
					else{
						echo $row_data->return_money; 
					}
				?>
				</div>
				<?php if($row_data->grand_total > $row_data->total_paid){ ?>
				<div class ="pos_top_header_fourth_left"> Due </div>
				<div class ="pos_top_header_fourth_right"> <?php echo $row_data->grand_total  + $delivery_charge - $row_data->total_paid; ?></div>
				<?php } ?>
			</div>
			<!--div class ="pos_top_header_fotter" style="font-size: 12px;margin-top:5px;"> Goods Sold Are Not Exchangeable. </div-->
			<div class ="pos_top_header_fotter" style="font-size: 12px;margin-top:5px;"> Thank You For Shopping With Us. </div>
			<div style="border-top: 1px solid gray; width: 100%; height: 1px; float:left;"> </div>
			
			<div class ="pos_top_header_fotter" style="background:;line-height:12px;margin-top:5px;">Software Developed By:<br /> <b>IT Lab Solutions Ltd.</b></div>
		</div> <!--End of main container body -->
	</div>
		</div> <!--End of main container body -->
	</body>
</html>	
