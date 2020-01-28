<!DOCTYPE HTML>
<html>
<head>
	<title> Dokani : IT Lab Solutions </title>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
</head>
<body> 
	<div class="container text-center">
		<div id= "main_container_body">
			<div id = "invoice" style="text-align: center;">
				<div id = "shop_title_test"> <?php echo $this->tank_auth->get_shopname(); ?>  </div>
				<div id = "shop_address_test">  <?php echo $this->tank_auth->get_shopaddress(); ?></div>	
				<div id = "shop_address_test"> Contact: <?php echo $this->tank_auth->get_shopcontact(); ?> </div>
				<?php
					$shop_id=$this->tank_auth->get_shop_id();
					$this->db->where('shop_id',$shop_id);
					$shop_info=$this->db->get('shop_setup')->row();
				?>
				<?php if ($shop_info->invoicelogo): ?>
					<img style="width: 200px;height: 100px" src="<?php echo base_url();?>assets/img/shop/<?php echo $shop_info->invoicelogo ?>">
				<?php else: ?>
					<img style="width: 200px;height: 100px" src="<?php echo base_url();?>assets/img/top_logo2.png">
				<?php endif ?> 
			</div>
			<div class ="pos_top_header_second"><?php $row_data = $collection_payment_info->row(); ?>
				<div class ="pos_top_header_second_left" style="font-weight: bold;">Invoice : <?php echo $transaction_id; ?></div>
				<div class ="pos_top_header_second_middle" style="font-weight: bold;"> Creator : <?php echo $row_data->username; ?></div>
			</div>
			<div class ="pos_top_header_second">
				<div id ="pos_top_header_second_right" style="font-weight: bold; ">Date : <?php $newDate = date("d-m-Y", strtotime($row_data->date));echo $newDate; ?></div>
				<div id ="pos_top_header_second_right_1" style="font-weight: bold; margin:0px 0px 0px 5px;">Time : <?php $newDate1 = date("h:i A",strtotime($row_data->created_at));echo $newDate1; ?></div>
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
				<div class ="pos_top_header_second_left_two" style="font-weight: bold; ">Service : <?php echo $row_data->service_provider_name; ?></div>
				<div class ="pos_top_header_second_left_two" style="font-weight: bold; ">Contact : <?php echo $row_data->service_provider_contact; ?></div>
				<div class ="pos_top_header_second_left_two" style="font-weight: bold; ">Address : <?php echo $row_data->service_provider_address;?></div>
				<?php
					}
				?>
				<div id ="pos_top_header_thired">
					<?php
						if($collection_payment_info -> num_rows() > 0) 
						{
					?>
					<div class="CSSTableGenerator" style="width:100%;margin:0px auto;float:left">
						<table class="table table-bordered">	
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
				<div class ="pos_top_header_fotter" style="background:;line-height:12px;margin-top:5px;">Software Developed By:<br /> <b>IT Lab Solutions Ltd.</b> Call: +8801842485222</div>
				<div id ="pos_top_header_fourth" style="width: 50%; float: right;">
					<div class ="pos_top_header_fourth_left"> Total Amount </div>
					<div class ="pos_top_header_fourth_right"> <?php echo $final_total = $row_data->amount; ?></div>
				</div>
				<div style="border-top: 1px solid gray; width: 100%; height: 1px; float:left;"> </div>
		
			</div> <!--End of main container body -->
		</div>
	</div>
</body>
</html>	
