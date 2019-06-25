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
				<a href="<?php echo base_url();?>sale_controller/my_sale" autofocus style="text-decoration: none;">
				<div id ="" style=" background: #fff;text-decoration: none;"> 
					<img src="<?php echo base_url();?>images/medical.jpg" class="img-circle" style="width:80px; height:80px;margin:0px 0px 0px 98px;" alt="User Image">
					<h6 style="line-height: 12px;text-align:center;margin: 5px;background: #fff;text-decoration: none;color:#000;margin:-17px 0px 0px 0px;"><?php echo $this->tank_auth->get_shopaddress();?></h6>
					<h6 style="line-height: 12px;text-align:center;margin: 5px;background: #fff;text-decoration: none;color:#000;margin:3px 0px 0px 0px;"><?php echo $this->tank_auth->get_shopcontact();?></h6>
				</div> 
				
				</a>
				<!-- <div id ="pos_top_header_right"></div> -->
			</div>
			<?php 
				$timezone = "Asia/Dhaka";
				date_default_timezone_set($timezone);
			?>
			<div class ="pos_top_header_second"><?php $row_data = $purchase_return_info->row(); ?>
				<div class ="pos_top_header_second_left" style="font-weight: bold; ">Return Invoice : <?php echo $row_data->purchase_return_id; ?></div>
				<div class ="pos_top_header_second_middle" style="font-weight: bold; width:120px;margin:0px 0px 0px 6px; "> Creator : <?php echo $row_data->username; ?></div>
			</div>
			<div class ="pos_top_header_second">
				<div id ="pos_top_header_second_right" style="font-weight: bold; ">Date : <?php $newDate = date("d-m-Y", strtotime($row_data->purchase_return_doc));echo $newDate; ?></div>
				<div id ="pos_top_header_second_right_1" style="font-weight: bold; margin:0px 0px 0px 5px;">Time : <?php $newDate1 = date("h:i A");echo $newDate1; ?></div>
			</div>
			<div id ="pos_top_header_thired">
			<?php
				if($purchase_return_info -> num_rows() > 0) 
				{
			?>
				<div class="CSSTableGenerator" style="width:100%;margin:0px auto;float:left">
					<table >	
						<tr>
							<td >Product Name</td>
							<td >Qty </td>
							<td >Buy</td>
							<td >Total</td>
						</tr>
						<?php
							$save1 = 0;
							foreach ($purchase_return_info -> result() as $field):
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
									echo $field -> return_quantity;
								?>
							</td>
							<td style="width:10%;text-align:right;">
								<?php 
									echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> '.round( $field-> unit_buy_price, 2);
								?> 
							</td>
							<td style="width:12%;text-align:right;border-right:0px solid black;">
								<?php 
									echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> '.round(( $field -> return_quantity * $field-> unit_buy_price), 2);
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
				<div class ="pos_top_header_fourth_right"> <?php echo $final_total = $row_data->total_return_amount; ?></div>
			</div>
			<div class ="pos_top_header_fotter" style="font-size: 12px;margin-top:5px;"> Thank You For Shopping. </div>
			<div style="border-top: 1px solid gray; width: 100%; height: 1px; float:left;"> </div>
			
			<div class ="pos_top_header_fotter" style="background:;line-height:12px;margin-top:5px;">Software Developed By:<br /> <b>IT Lab Solutions Ltd.</b> Call: +8801842485222</div>
		</div> <!--End of main container body -->
	</div>
		</div> <!--End of main container body -->
	</body>
</html>	
