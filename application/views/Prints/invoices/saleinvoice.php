<!DOCTYPE HTML>
<html>
<head>
	<title> Dokani : IT Lab Solutions </title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" type="text/css"/>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/printstyle.css" type="text/css"/>
</head>
</head>
	<?php 

		$this->load->config('custom_config'); 
		$pre_blance_show_invoice = $this->config->item('pre_blance_show_invoice');
	?>
	<body > 
	 	<div id ="main_invoice">
			<div id = "invoice">
				<div class="text-center">			
						<div>  <b><?php echo $this->tank_auth->get_shopname(); ?></b>  </div>
						<div>  <?php echo $this->tank_auth->get_shopaddress(); ?></div>	
						<div> <b>Contact: <?php echo $this->tank_auth->get_shopcontact(); ?></b> </div>
						<?php
							$shop_id=$this->tank_auth->get_shop_id();
							$this->db->where('shop_id',$shop_id);
							$shop_info=$this->db->get('shop_setup')->row();
						?>
						<?php if (isset($shop_info->invoicelogo)): ?>
							<img style="width: 20%;" src="<?php echo base_url();?>assets/img/shop/<?php echo $shop_info->invoicelogo ?>">
						<?php else: ?>
							<img style="width: 50%;height: 100px" src="<?php echo base_url();?>assets/img/top_logo2.png">

						<?php endif ?> 
						<div> Invoice # <?php echo $invoice_id; ?></div>
				</div> <!--end of shop_title_box-->
				<?php $row_data = $sale_info->row(); ?>
				<table class="table table-bordered margin-b-0">	
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
				<?php
					if($sale_info -> num_rows() > 0) 
					{
				?>
					<table class="table table-bordered margin-b-0">	
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
										echo '<p style="font-family:arial;font-size:12px;font-weight:normal;">'.$field->product_name.'<span> (Warranty: '.$field->product_warranty.' Month)<span></p>';
										foreach($sale_warranty_info[$j]  as $filed2)
										{
											echo '<span style="font-family:arial;font-size:12px;font-weight:normal;">'.$filed2->sl_no .'</span>  '.',  ';
										}
										$j++;
									}
									else
									{
										echo '<p style="font-family:arial;font-size:12px;font-weight:normal;">'.$field->product_name.'</p>';
									}
								?>
							</td>
							<td style="width:12%;text-align:center;">
								<?php 
									echo $field->sale_quantity;
								?>
							</td>
							<td style="width:15%;text-align:right;">
								<?php 
									echo sprintf('%0.2f',$field->unit_sale_price);
											
								?> 
							</td>
	                        <td style="width:15%;text-align:right;">
								<?php 
									echo sprintf('%0.2f',$field->actual_sale_price);
									
									$save1 = $save1 + (round($field->unit_sale_price, 2)*$field ->sale_quantity - 
											round($field->actual_sale_price, 2)*$field ->sale_quantity );
											
								?> 
							</td>
							
							<td style="width:15%;text-align:right;border-right:0px solid black;">
								<?php 
									echo sprintf('%0.2f',$field->sale_quantity * $field->actual_sale_price);
								?> 
							</td>
						</tr>
						<?php
							$i++;
							endforeach;
						?>	
						
					</table>	
				<?php  
					}
				?>
				<div id = "transaction_details">
					<div class="rows">
						<div class="text-center w-50">
							<br><br>
							<div> <b>Receiver Signature</b>	</div>
							<hr class="p-0 m-1">
						</div>
						<div class="w-50">
							<div class="mr-0">
								<table class="table table-bordered">
									<tr>
										<td>Total MRP :</td>
										<td><?php if($save1 > 0){echo sprintf('%0.2f',$final_total = $save1+$row_data->total_price);}else{ echo sprintf('%0.2f',$final_total = $row_data->total_price); } ?></td>
									</tr>
									<?php if($row_data->sale_return_amount > 0){ ?>
										<tr>
											<td> Sale Return </td>
											<td> <?php echo sprintf('%0.2f', $row_data->sale_return_amount);?></td>
										</tr>
									<?php } ?>
									<tr>
										<td> Exclusive Discount </td>
										<td class ="pos_top_header_fourth_right"> 
											<?php 
											if($save1 > 0)
											{
												echo sprintf('%0.2f',$save1);
											}
											else{
												echo '0.00';
											}
										?>
										</td>
									</tr>
									<tr>
										<td> Special Discount </td>
										<td> <?php echo sprintf('%0.2f',$row_data->discount_amount); ?></td>
									</tr>
									<tr>
										<td> Delivery Charge </td>
										<td> <?php echo sprintf('%0.2f',$row_data->delivery_charge); ?></td>
									</tr>
									<?php 
										$sale_return = $row_data->sale_return_amount;
										$total_price = $row_data->total_price;
										$delivery_charge = $row_data->delivery_charge;
									?>
									<?php 
									if($sale_return > 0)
									{ 
									?>
									<tr>
										<td> Grand Total </td>
										<td> <?php echo sprintf('%0.2f',$row_data->total_price - $sale_return - $row_data->discount_amount + $delivery_charge);?></td>
									</tr>
									<tr>
										<td> Paid </td>
										<?php $total_paid = $row_data->total_price - $sale_return; ?>
										<td> <?php echo sprintf('%0.2f',$row_data->total_paid); ?></td>
									</tr>
									<?php 
									} 
									else 
									{
									?>
									<tr>
										<td> Grand Total </td>
										<td> <?php echo sprintf('%0.2f',$row_data->grand_total + $delivery_charge); ?></td>
									</tr>
									<tr>
										<td> Paid </td>
										<?php $total_paid = $row_data->total_paid; ?>
										<td> <?php echo sprintf('%0.2f',$total_paid); ?></td>
									</tr>
									<?php 
									} 
									?>
									<tr>
										<td> Return </td>
										<td>
											<?php 
												if($row_data->return_money!=0)
												{
													echo $row_data->return_money - $delivery_charge; 
												}
												else{
													echo $row_data->return_money; 
												}
											?>
										</td>
									</tr>
									<tr>
										<?php if($row_data->grand_total > $row_data->total_paid){ ?>
										<td> Due </td>
										<td> <?php echo sprintf('%0.2f', $row_data->grand_total + $delivery_charge - $row_data->total_paid); ?></td>
										<?php } ?>
									</tr>
								</table>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<p><b><?php echo $in_word; ?> Taka Only.</b></b></p>
							<div> Thank You For Being With Us.</div>
							<hr class="p-0 m-1">
							<div>Software Developed By: <b>IT Lab Solutions Ltd.</b> Call: +8801842485222</div>
						</div>
					</div>
				</div> <!--end of invoice-->
			</div>
		</div>
	</body>
</html>	
