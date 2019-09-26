<!DOCTYPE HTML>
<html>
<head>
	<title> Dokani : IT Lab Solutions </title>
	<link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico"  type="image/x-icon"/>
	<!--link rel="stylesheet" href="<?php echo base_url(); ?>style/table_style.css" type="text/css"/-->
	<link rel="stylesheet" href="<?php echo base_url(); ?>style/invoice_style.css" type="text/css"/>
	<style>
		#t_left{width: 332px;}
		#signature_one{width: 210px;}
		.customer_signature,.customer_signature2 {
			border-top: 1px solid #808080;
			border-bottom: 0px solid #808080;
		}
		
		.customers 
		{
			font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
			border-collapse: collapse;
			width: 100%;
		}

		.customers td, .customers th 
		{
			border: 1px solid #ddd;
			padding: 5px;
		}

		.customers tr:nth-child(even){background-color: #f2f2f2;}

		.customers tr:hover {~background-color: #ddd;}

		.customers th 
		{
			padding-top: 12px;
			padding-bottom: 12px;
			text-align: left;
			~background-color: #4CAF50;
			color: #000000;
			font-weight: normal;
		}

		.tot_paid
		{
			font-size: 50px;
			color: #C7BFBF;
			margin-left: 50px;
			font-weight: normal;
		}
		
	</style>
</head>
</head>
	<?php 

		$this->load->config('custom_config'); 
		$pre_blance_show_invoice = $this->config->item('pre_blance_show_invoice');
	?>
	<body > 
	 	<div id ="main_invoice" style="width: 700px;">
			<div id = "invoice"  style="width: 698px;">
				<div id="shop_title_box"  style="width: 698px;text-align: center;">			
						<div id = "shop_title_test"> <?php echo $this->tank_auth->get_shopname(); ?>  </div>
						<div id = "shop_address_test">  <?php echo $this->tank_auth->get_shopaddress(); ?></div>	
						<div id = "shop_address_test"> Contact: <?php echo $this->tank_auth->get_shopcontact(); ?> </div>
						<?php
							$shop_id=$this->tank_auth->get_shop_id();
							$this->db->where('shop_id',$shop_id);
							$shop_info=$this->db->get('shop_setup')->row();
						?>
						<?php if ($shop_info->invoicelogo): ?>
							<img style="width: 100%;" src="<?php echo base_url();?>assets/img/shop/<?php echo $shop_info->invoicelogo ?>">
						<?php else: ?>
							<img style="width: 50%;height: 100px" src="<?php echo base_url();?>assets/img/top_logo2.png">

						<?php endif ?> 
						<div id = "shop_title_test"> Invoice # <?php echo $invoice_id; ?></div>
				</div> <!--end of shop_title_box-->
				<div id = "invoice_details_header" style="width: 699px;">	
					<?php $row_data = $sale_info->row(); ?>
					<table class="customers" style="width: 100%;">	
						<tr>
							<td >Customer Name: <?php echo $row_data->customer_name; ?></td>
							<td >Customer ID: <?php echo $row_data->customer_id; ?></td>	
						</tr>
						<tr>
							
							<td >Address: <?php echo $row_data->customer_address; ?></td>
							<td >Contact: <?php echo $row_data->customer_contact_no; ?></td>
						</tr>			
						<tr>
							<td >Date: <?php echo $row_data->invoice_doc; ?> </td>
							<td >Creator: <?php echo $row_data->username;?> </td>
						</tr>
					</table>	
				</div> <!--end of invoice_details_header-->
				
				<?php
					if($sale_info -> num_rows() > 0) 
					{
				?>
				<div style="width:100%;margin:0px auto;float:left;border-right: 2px solid #ddd;">
					<table class="customers">	
						<tr>
							<th >SL</th>
							<th >Product Name</th>
							<th style="text-align:center;" >Qty </th>
							<th style="text-align:right;">MRP</th>
                            <th style="text-align:right;">Ex-Price</th>
							<th style="text-align:right;">Total</th>
						</tr>
						<?php
							$i = 1;
							$j = 1;
							$save1 = 0;
							
							foreach ($sale_info -> result() as $field):
						?>
						<tr>
							<td style="width:4%;">
								<?php 
									echo $i;
								?>
							</td>
							<td style="text-align:left;">
								<?php
									
									if(isset($sale_warranty_info[$j]) && $field->product_specification == 2)
									{
										echo '<p style="font-family:arial;font-size:12px;font-weight:normal;">'.$field -> product_name.'<span> (Warranty: '.$field->product_warranty.' Month)<span></p>';
										foreach($sale_warranty_info[$j]  as $filed2)
										{
											echo '<span style="font-family:arial;font-size:12px;font-weight:normal;">'.$filed2->sl_no .'</span>  '.',  ';
										}
										$j++;
									}
									else
									{
										echo '<p style="font-family:arial;font-size:12px;font-weight:normal;">'.$field -> product_name.'</p>';
									}
								?>
							</td>
							<td style="width:12%;text-align:center;">
								<?php 
									echo $field -> sale_quantity;
								?>
							</td>
							<td style="width:15%;text-align:right;">
								<?php 
									echo sprintf('%0.2f',$field-> unit_sale_price);
											
								?> 
							</td>
                            <td style="width:15%;text-align:right;">
								<?php 
									echo sprintf('%0.2f',$field-> actual_sale_price);
									
									$save1 = $save1 + (round($field-> unit_sale_price, 2)*$field ->sale_quantity - 
											round($field-> actual_sale_price, 2)*$field ->sale_quantity );
											
								?> 
							</td>
							
							<td style="width:15%;text-align:right;border-right:0px solid black;">
								<?php 
									echo sprintf('%0.2f',$field -> sale_quantity * $field-> actual_sale_price);
								?> 
							</td>
						</tr>
						<?php
							$i++;
							endforeach;
						?>	
						
					</table>	
				</div>
				<?php  
					}
				?>
				<div id = "transaction_details">
					<?php
					if($pre_blance_show_invoice!=0)
					{
						if($row_data->customer_id!=1)
						{
						?>
						<div id ="t_left" style="width: 40%;float: left;border: 1px solid black;padding:5px;">
							<?php
									$pre_balance =$receipt_sale_total_amount;
							?>
								<div style="width: 50%; float: left;margin:5px 0 0 0;text-align: left;"> Pre Balance </div>
								<div style="width: 50%; float: left;margin:5px 0 0 0;text-align: right;"> <?php echo sprintf('%0.2f',$pre_balance);?></div>
								<div style="width: 50%; float: left;margin:5px 0 0 0;text-align: left;"> Invoice Total </div>
								<div style="width: 50%;text-align: right;margin: 5px 0 0 0;float: right;"> 
									<?php 
										$sale_return = $row_data->sale_return_amount;
										$total_price = $row_data->total_price;
									?>
									<?php 
									$tot_grand = 0;
									$total_paid = 0;
									if($sale_return > 0)
									{ 
									?>
										<?php echo $tot_grand = sprintf('%0.2f',$row_data->total_price - $sale_return - $row_data->discount_amount);?>
									
									<?php 
									} 
									else 
									{
									?>
									<?php echo $tot_grand = sprintf('%0.2f',$row_data->grand_total); ?>
									<?php }?>
								</div>
								<div style="width: 50%; float: left;margin:5px 0 0 0;text-align: left;"> Paid Amount </div>
								<div style="width: 50%;text-align: right;margin: 5px 0 0 0;float: right;"> <?php echo $total_paid = sprintf('%0.2f',$row_data->total_paid - $row_data->return_money);?></div>
								<div style="width: 50%; float: left;margin:5px 0 0 0;text-align: left;font-weight:bold;"> Outstanding </div>
								<div style="width: 50%;text-align: right;margin: 5px 0 0 0;float: right;font-weight:bold;"> <?php echo sprintf('%0.2f',$pre_balance + $tot_grand - $total_paid);?></div>
						</div>
						<?php
						}
					}
					?>
					<div id ="pos_top_header_fourth" style="width: 48%; float: right;">
						<div class ="pos_top_header_fourth_left" style="width: 50%; float: left;margin:5px 0 0 0;"> Total MRP </div>
						<div class ="dot">:</div>
						<div class ="pos_top_header_fourth_right" style="width: 86%; text-align: right;margin:5px 0 0 0;"> <?php if($save1 > 0){echo sprintf('%0.2f',$final_total = $save1+$row_data->total_price);}else{ echo sprintf('%0.2f',$final_total = $row_data->total_price); } ?></div>
						<?php if($row_data->sale_return_amount > 0){ ?>
						<div class ="pos_top_header_fourth_left" style="width: 50%; float: left;margin:5px 0 0 0;"> Sale Return </div>
						<div class ="dot">:</div>
						<div class ="pos_top_header_fourth_right" style="width: 86%; text-align: right;margin:5px 0 0 0;"> <?php echo sprintf('%0.2f', $row_data->sale_return_amount);?></div>
						<?php } ?>
						<div class ="pos_top_header_fourth_left" style="width: 50%; float: left;margin:5px 0 0 0;"> Exclusive Discount </div>
						<div class ="dot">:</div>
						<div class ="pos_top_header_fourth_right" style="width: 86%; text-align: right;margin:5px 0 0 0;"> 
						
						<!-- Calculating the price discount  Start -->
						<?php 
						if($save1 > 0)
						{
							echo sprintf('%0.2f',$save1);
						}
						else{
							echo '0.00';
						}
						?>
						<!-- Calculating the price discount  End -->
						</div>
						<div class ="pos_top_header_fourth_left" style="width: 50%; float: left;margin:5px 0 0 0;"> Special Discount </div>
						<div class ="dot">:</div>
						<div class ="pos_top_header_fourth_right" style="width: 86%; text-align: right;margin:5px 0 0 0;"> <?php echo sprintf('%0.2f',$row_data->discount_amount); ?></div>
						<div class ="pos_top_header_fourth_left"  style="width: 50%; float: left;margin:5px 0 0 0;"> Delivery Charge </div>
						<div class ="dot">:</div>
						<div class ="pos_top_header_fourth_right"  style="width: 86%; text-align: right;margin:5px 0 0 0;"> <?php echo sprintf('%0.2f',$row_data->delivery_charge); ?></div>
						<?php 
							$sale_return = $row_data->sale_return_amount;
							$total_price = $row_data->total_price;
							$delivery_charge = $row_data->delivery_charge;
						?>
						<?php 
						if($sale_return > 0)
						{ 
						?>
						<div class ="pos_top_header_fourth_left" style="width: 50%; float: left;margin:1px 0 0 0;"> Grand Total </div>
						<div class ="dot">:</div>
						<div class ="pos_top_header_fourth_right" style="width: 86%; text-align: right;margin:10px 0 0 0;"> <?php echo sprintf('%0.2f',$row_data->total_price - $sale_return - $row_data->discount_amount + $delivery_charge);?></div>
						<div class ="pos_top_header_fourth_left" style="width: 50%; float: left;margin:5px 0 0 0;"> Paid </div>
						<div class ="dot">:</div>
						<?php $total_paid = $row_data->total_price - $sale_return; ?>
						<div class ="pos_top_header_fourth_right" style="width: 86%; text-align: right;margin:8px 0 0 0;"> <?php echo sprintf('%0.2f',$row_data->total_paid); ?></div>
						<?php 
						} 
						else 
						{
						?>
						
						<div class ="pos_top_header_fourth_left" style="width: 50%; float: left;margin:5px 0 0 0;"> Grand Total </div>
						<div class ="dot">:</div>
						<div class ="pos_top_header_fourth_right" style="width: 86%; text-align: right;margin:10px 0 0 0;font-weight:bold;"> <?php echo sprintf('%0.2f',$row_data->grand_total + $delivery_charge); ?></div>
						<div class ="pos_top_header_fourth_left" style="width: 50%; float: left;margin:5px 0 0 0;"> Paid </div>
						<div class ="dot">:</div>
						<?php $total_paid = $row_data->total_paid; ?>
						<div class ="pos_top_header_fourth_right" style="width: 86%; text-align: right;margin:8px 0 0 0;"> <?php echo sprintf('%0.2f',$total_paid); ?></div>
						
						<?php 
						} 
						?>
						<div class ="pos_top_header_fourth_left" style="width: 50%; float: left;margin:5px 0 0 0;"> Return </div>
						<div class ="dot">:</div>
						<div class ="pos_top_header_fourth_right" style="width: 86%; text-align: right;margin:8px 0 0 0;"> 
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
						<div class ="pos_top_header_fourth_left" style="width: 50%; float: left;margin:5px 0 0 0;"> Due </div>
						<div class ="dot">:</div>
						<div class ="pos_top_header_fourth_right" style="width: 86%; text-align: right;margin:8px 0 0 0;"> <?php echo sprintf('%0.2f', $row_data->grand_total + $delivery_charge - $row_data->total_paid); ?></div>
						
						
						<?php } ?>
					</div>
					<table class="customers" style="margin-top: 40px;margin-bottom: 70px;float: left;width: 94%;">
						<tr>
							<td colspan="5" style="text-align:center;"> <b><?php echo $in_word; ?> Taka Only.</b></td>
						</tr>
					</table>
					<div id = "signature_area" style="width: 698px;">	
						<div id = "signature_one"  style="width:340px;">
							<div class = "customer_signature"> <b>Receiver Signature</b>	</div>
						</div>
						<div id = "signature_one"> 
							<div class = "customer_signature2"> <b>  <?php echo $this->tank_auth->get_shopname(); ?></b> </div>
						</div>
					</div>
					<div class ="pos_top_header_fotter" style="line-height: 16px;width: 100%;float: left;text-align: center;font-size: 12px;"> Thank You For Being With Us.</div>
					<div style="border-top: 1px solid gray; width: 100%; height: 1px; float:left;"> </div>
				
					<div class ="pos_top_header_fotter" style="background:;line-height:14px;float: left;text-align: center;width: 100%;font-size: 12px;">Software Developed By: <b>IT Lab Solutions Ltd.</b> Call: +8801842485222</div>
			
				</div> <!--end of invoice-->
			</div>
		</div>
	</body>
</html>	
