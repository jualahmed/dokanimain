<!DOCTYPE HTML>
<html>
<head>
	<title> Dokani : IT Lab Solutions </title>
	<meta lang="en">
	<meta lang="bn">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico"  type="image/x-icon"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>style/POS_table_style.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>style/POS_invoice_style.css" type="text/css"/>
	<script src="<?php echo base_url();?>js/jquery-1.10.2.js"></script>
	<style>
		.pos_top_header_fourth_left{
			width: 74%;
		}
		.pos_top_header_fourth_right{
			width: 25%;
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
				<!--img src="<?php echo base_url();?>images/medical2.jpg" class="img-circle" style="width:50px; height:50px;" alt="User Image"-->
			</div>
			<div id ="pos_top_header">
				<a href="<?php echo base_url();?>sale_controller/new_sale" autofocus style="text-decoration: none;">
				<div id ="" style=" background: #fff;text-decoration: none;"> 
					<img src="<?php echo base_url();?>images/pos_logo.jpg" class="img-circle" style="height:100px;margin:0px 0px 0px 40px;" alt="User Image">
					<!--h6 style="line-height: 12px;text-align:center;margin: 5px;background: #fff;text-decoration: none;color:#000;margin:-17px 0px 0px 0px;"><?php echo $this->tank_auth->get_shopaddress();?></h6>
					<h6 style="line-height: 12px;text-align:center;margin: 5px;background: #fff;text-decoration: none;color:#000;margin:3px 0px 0px 0px;"><?php echo $this->tank_auth->get_shopcontact();?></h6-->
				</div> 
				
				</a>
				<!-- <div id ="pos_top_header_right"></div> -->
			</div>
			<?php 
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
			?>
			<div class ="pos_top_header_second"><?php $row_data = $sale_info->row(); ?>
				<div class ="pos_top_header_second_left" style="font-weight: bold; ">Invoice : <?php echo $invoice_id; ?></div>
				<div class ="pos_top_header_second_middle" style="font-weight: bold; width:120px;margin:0px 0px 0px 6px; "> Creator : <?php echo $row_data->username; ?></div>
			</div>
			<div id ="pos_top_header_second_right" style="font-weight: bold; width:100%;">Date & Time : <?php echo $row_data->date_time; ?></div>
			<div class ="pos_top_header_second">
				<div class ="pos_top_header_second_left_two" style="font-weight: bold; ">Customer : <?php echo $row_data->customer_name; ?></div>
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
							<td style="text-align:left;">Product Name</td>
							<td >Qty </td>
							<td style="text-align:right;">Buy</td>
							<td style="text-align:right;">MRP</td>
							<td style="text-align:right;">Sale</td>
							<td style="text-align:right;">Total</td>
						</tr>
						<?php
							$save1 = 0;
							foreach ($sale_info->result() as $field):
						?>
						<tr>
							<!--<td style="width:2%"> <?php echo $field->product_id;?> </td> -->
							<td style="text-align:left;">
								<?php 
									echo '<p style="min-height:13px;font-size:10px;font-weight:bold;margin:0px;">'.$field -> product_name.'</p>';
									//if($field -> product_specification == 'individual')
									//echo '<h1 style="height:10px;font-size:9px;font-weight:normal;margin:0px;text-indent:15px;">'.$individual_product_stock_id[ $field -> product_id ].'</h1>';
								?>
							</td>
							<td style="width:10%;">
								<?php 
									echo $field -> sale_quantity;
								?>
							</td>
							<td style="width:20%;text-align:right;">
								<?php 
									echo round( $field->unit_buy_price, 2);
								?> 
							</td>
							<td style="width:10%;text-align:right;">
								<?php 
									echo round( $field-> unit_sale_price, 2);
								?> 
							</td>
							<td style="width:10%;text-align:right;">
								<?php 
									echo round( $field-> general_sale_price, 2);
									
									$save1 = $save1 + (round($field-> unit_sale_price, 2)*$field ->sale_quantity - 
											round($field-> general_sale_price, 2)*$field ->sale_quantity );
											
								?> 
							</td>
							
							<td style="width:12%;text-align:right;border-right:0px solid black;">
								<?php 
									echo round(( $field -> sale_quantity * $field-> general_sale_price), 2);
								?> 
							</td>
						</tr>
						<?php
							endforeach;
						?>	
						
						<tr>
							<td colspan="5" style="text-align:left;"> <i><b><?php echo $in_word; ?> &nbsp; </b></i></td>
						</tr>
					</table>	
				</div>
				<?php  
					}
				?>
			</div>
			<!--div id ="pos_top_header_fourth" style="width: 50%;float: left; height:140px;">
				<div style="height:70px;">
					<div style="width:50%;"> Payment By </div>
					<div style="width:50%;">CASH</div>
				</div>
			</div-->
			<div id ="pos_top_header_fourth" style="width: 50%; float: right;">
				<div class ="pos_top_header_fourth_left"> Total Amount </div>
				<div class ="pos_top_header_fourth_right"> <?php if($save1 > 0){echo round(($save1+$row_data->total_price),2);}else{ echo $row_data->total_price; } ?></div>
				<div class ="pos_top_header_fourth_left"> Product Discount</div>
				<div class ="pos_top_header_fourth_right"> <?php  echo ($save1);?></div>
				<!--?php if($discount > 0){ ?-->
				<div class ="pos_top_header_fourth_left"> Special Discount </div>
				<div class ="pos_top_header_fourth_right"> <?php echo $row_data->discount_amount; ?></div>
				<!--?php } ?-->
				
				<!--?php if($row_data->discount_amount > 0){ ?>
				<div class ="pos_top_header_fourth_left"> Discount </div>
				<div class ="pos_top_header_fourth_right"> 
				<!--?php echo $row_data->discount_amount;if($row_data->discount_type == 2){echo ' ('.$row_data->cash_commision."%)";} ?>
				</div>
				<!--?php } ?>
				<!--?php //if($show_discount > 0){ ?-->
				<!-- <div class ="pos_top_header_fourth_left"> Product Discount </div>
				<div class ="pos_top_header_fourth_right"> <!--?php echo $show_discount;?></div> -->
				<!--?php } ?-->
				
				<div class ="pos_top_header_fourth_left"> Grand Total </div>
				<div class ="pos_top_header_fourth_right"> <?php echo $row_data->grand_total; ?></div>
				<div class ="pos_top_header_fourth_left"> Paid </div>
				<!--?php //$total_paid = $total_paid + $return_money; ?-->
				<div class ="pos_top_header_fourth_right"> <?php echo $row_data->total_paid; ?></div>
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
