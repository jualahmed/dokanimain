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
			<div class ="pos_top_header_second"><?php $row_data = $collection_payment_info->row(); ?>
				<div class ="pos_top_header_second_left" style="font-weight: bold; ">Invoice : <?php echo $transaction_id; ?></div>
				<div class ="pos_top_header_second_middle" style="font-weight: bold; width:120px;margin:0px 0px 0px 6px; "> Creator : <?php echo $row_data->username; ?></div>
			</div>
			<div class ="pos_top_header_second">
				<div id ="pos_top_header_second_right" style="font-weight: bold; ">Date : <?php $newDate = date("d-m-Y", strtotime($row_data->date));echo $newDate; ?></div>
				<div id ="pos_top_header_second_right_1" style="font-weight: bold; margin:0px 0px 0px 5px;">Time : <?php $newDate1 = date("h:i A");echo $newDate1; ?></div>
			</div>
			<div class ="pos_top_header_second">
				<?php 
					$receipt_type = $this->uri->segment(4);
					if($receipt_type ==3)
					{
				?>
				<div class ="pos_top_header_second_left_two" style="font-weight: bold; ">Customer : <?php echo $row_data->customer_name; ?></div>
				<div class ="pos_top_header_second_left_two" style="font-weight: bold; ">Contact : <?php echo $row_data->customer_contact_no; ?></div>
				<div class ="pos_top_header_second_left_two" style="font-weight: bold; ">Address : <?php echo $row_data->customer_address;?></div>
				<?php
					}
					else if($receipt_type ==1){
				?>
				<div class ="pos_top_header_second_left_two" style="font-weight: bold; ">Distributor : <?php echo $row_data->distributor_name; ?></div>
				<div class ="pos_top_header_second_left_two" style="font-weight: bold; ">Contact : <?php echo $row_data->distributor_contact_no; ?></div>
				<div class ="pos_top_header_second_left_two" style="font-weight: bold; ">Address : <?php echo $row_data->distributor_address;?></div>
				<?php
					}
					else if($receipt_type ==2){
				?>
				<div class ="pos_top_header_second_left_two" style="font-weight: bold; ">Type : <?php echo $row_data->type_type; ?></div>
				<div class ="pos_top_header_second_left_two" style="font-weight: bold; ">Employee : <?php echo $row_data->employee_name; ?></div>
				<?php
					}
				?>
			<div id ="pos_top_header_thired">
			<?php
				if($collection_payment_info -> num_rows() > 0) 
				{
			?>
				<div class="CSSTableGenerator" style="width:100%;margin:0px auto;float:left">
					<table >	
						<tr>
							<td>Payment Mode</td>
							<td>Amount </td>
						</tr>
						<?php
							foreach ($collection_payment_info -> result() as $field):
						?>
						<tr>
							<td style="text-align:left;">
								<?php 
									echo '<p style="min-height:13px;font-size:10px;font-weight:bold;margin:0px;">'.$field->transaction_mode.'</p>';
								?>
							</td>
							<td style="width:12%;text-align:right;border-right:0px solid black;">
								<?php 
									echo '<big style = "font-size: 11px; font-weight:bold;"> &#2547; </big> '.round(( $field -> amount), 2);
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
			<div id ="pos_top_header_fourth" style="width: 44%;float: left; height:140px;">
				<div style="height:70px;">
					<!--div style="width:50%;"> Payment By </div>
					<div style="width:50%;">CASH</div-->
				</div>
			</div>
			<div id ="pos_top_header_fourth" style="width: 50%; float: right;">
				<div class ="pos_top_header_fourth_left"> Total Amount </div>
				<div class ="pos_top_header_fourth_right"> <?php echo $final_total = $row_data->amount; ?></div>
			</div>
			<div style="border-top: 1px solid gray; width: 100%; height: 1px; float:left;"> </div>
			
			<div class ="pos_top_header_fotter" style="background:;line-height:12px;margin-top:5px;">Software Developed By:<br /> <b>IT Lab Solutions Ltd.</b> Call: +8801842485222</div>
		</div> <!--End of main container body -->
	</div>
		</div> <!--End of main container body -->
	</body>
</html>	
