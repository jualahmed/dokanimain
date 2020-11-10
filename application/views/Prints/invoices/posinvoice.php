<!DOCTYPE HTML>
<html>

<head>
	<title> Dokani : IT Lab Solutions </title>
	<meta lang="en">
	<meta lang="bn">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="icon" href="<?php echo base_url(); ?>images/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/posinvoice.css" type="text/css" />
	<script>
		window.print();
	</script>
</head>

<body>
	<div id="main_container_body_main">
		<div id="main_container_body_main2">
			<div id="main_container_body">
				<div class="text-center">
					<?php
					$shop_id = $this->tank_auth->get_shop_id();
					$this->db->where('shop_id', $shop_id);
					$shop_info = $this->db->get('shop_setup')->row();
					?>

					<?php $row_data = $sale_info->row(); ?>
					<p><img style="width: 50px;" src="<?php echo base_url(); ?>assets/img/shop/<?php echo $shop_info->logo; ?>" alt=""></p>
					<h4 style="margin: 0;font-weight: bold"><?php echo $shop_info->shop_name; ?></h4>
					<p style="margin: 0;font-size: 12px;"> <?php echo ($shop_info->shop_address) ?> </p>
					<p style="font-size: 12px;font-weight: bold"> <?php echo ($shop_info->shop_contact) ?> </p>

					<h4 style="margin: 0;font-weight: bold;">Invoice No. : <?php echo $invoice_id; ?></h4>
					<p style="margin: 0px;font-size:11px;"><?php $newDate = date("d-m-Y", strtotime($row_data->invoice_doc));
															echo $newDate; ?> | <?php $newDate1 = date("h:i A", strtotime($row_data->date_time));
																				echo $newDate1; ?> | <?php echo $row_data->user_full_name; ?></p>
					<p style="margin: 0px;">Customer : <?php echo $row_data->customer_name; ?></p>
				</div>


				<div id="pos_top_header_thired">
					<?php
					if ($sale_info->num_rows() > 0) {
					?>
						<div class="CSSTableGenerator" style="width:100%;margin:0px auto;float:left">
							<table>
								<tr>
									<!--<td >ID</td> -->
									<td>Product Name</td>
									<td>Qty </td>
									<td>Price</td>
									<td>Total</td>
								</tr>
								<?php
								$save1 = 0;
								$totalMrp = 0;
								$totalUnitSalePrice = 0;
								$totalActualSalePrice = 0;
								foreach ($sale_info->result() as $field) :
									$general_sale_price = $field->general_sale_price;
									$sale_quantity = $field->sale_quantity;
									$unit_sale_price = $field->unit_sale_price;
									$actual_sale_price = $field->actual_sale_price;

									$totalMrp += ($general_sale_price * $sale_quantity);
									$totalUnitSalePrice += ($unit_sale_price * $sale_quantity);
									$totalActualSalePrice += ($actual_sale_price * $sale_quantity);
								?>
									<tr>
										<!--<td style="width:2%"> <?php echo $field->product_id; ?> </td> -->
										<td style="text-align:left;">

											<?php

											if ($sale_warranty_info != '') {
												echo '<p style="min-height:13px;font-size:10px;font-weight:bold;margin:0px;">' . $field->product_name . '</p>';
												//echo 'SN ';
												foreach ($sale_warranty_info->result() as $filed2) {
													if ($field->product_id == $filed2->product_id) {
														echo $filed2->sl_no . '  ' . '  ';
													}
												}
											} else {
												echo '<p style="min-height:13px;font-size:10px;font-weight:bold;margin:0px;">' . $field->product_name . '</p>';
											}
											?>
										</td>
										<td style="width:10%;">
											<?php
											echo $sale_quantity;
											?>
										</td>
										<td style="width:10%;text-align:right;">
											<?php
											echo number_format($field->unit_sale_price, 2);
											?>
										</td>

										<td style="width:12%;text-align:right;border-right:0px solid black;">
											<?php
											echo number_format(($field->sale_quantity * $field->unit_sale_price), 2);
											?>
										</td>
									</tr>
								<?php
								endforeach;
								?>
							</table>
						</div>
					<?php
					}
					?>
				</div>
				<div id="pos_top_header_fourth" style="width: 100%; float: right;">
					<div class="pos_top_header_fourth_left"> Total Price </div>
					<div class="pos_top_header_fourth_right">
						<?php
						echo number_format($totalUnitSalePrice, 2);
						?>
					</div>
					<?php if ($row_data->sale_return_amount > 0) { ?>
						<div class="pos_top_header_fourth_left"> Sale Return</div>
						<div class="pos_top_header_fourth_right"> <?php echo number_format($row_data->sale_return_amount, 2); ?></div>
					<?php } ?>
					<!-- <div class ="pos_top_header_fourth_left"> Shop Discount</div>
							<div class ="pos_top_header_fourth_right"> <?php echo number_format($totalMrp - $totalUnitSalePrice, 2); ?></div> -->
					<?php
					if ($row_data->discount_amount > 0) { ?>
						<div class="pos_top_header_fourth_left"> Discount </div>
						<div class="pos_top_header_fourth_right"> <?php echo number_format(($totalUnitSalePrice - $totalActualSalePrice), 2); ?></div>
					<?php }
					?>

					<?php
					$sale_return = $row_data->sale_return_amount;
					$total_price = $row_data->total_price;
					?>
					<?php
					if ($sale_return > 0) {
					?>
						<div class="pos_top_header_fourth_left" style="font-weight: bolder;font-size: 12px;"> Grand Total</div>
						<div class="pos_top_header_fourth_right" style="font-weight: bolder;font-size: 12px;"> <?php echo number_format($row_data->total_price - $sale_return - $row_data->discount_amount, 2); ?></div>
						<div class="pos_top_header_fourth_left"> Paid </div>
						<?php $total_paid = $row_data->total_price - $sale_return; ?>
						<div class="pos_top_header_fourth_right"> <?php echo number_format($row_data->total_paid, 2); ?></div>
					<?php
					} else {
					?>
						<div class="pos_top_header_fourth_left" style="font-weight: bolder;font-size: 12px;"> Grand Total </div>
						<div class="pos_top_header_fourth_right" style="font-weight: bolder;font-size: 12px;"> <?php echo number_format($row_data->grand_total, 2); ?></div>
						<div class="pos_top_header_fourth_left"> Received </div>
						<?php $total_paid = $row_data->total_paid; ?>
						<div class="pos_top_header_fourth_right"> <?php echo number_format($total_paid, 2); ?></div>
					<?php
					}
					?>

					<div class="pos_top_header_fourth_left"> Returned </div>
					<div class="pos_top_header_fourth_right"> <?php echo number_format($row_data->return_money, 2); ?></div>
					<?php if ($row_data->grand_total > $row_data->total_paid) { ?>
						<div class="pos_top_header_fourth_left"> Due </div>
						<div class="pos_top_header_fourth_right"> <?php echo number_format($row_data->grand_total - $row_data->total_paid, 2); ?></div>
					<?php } ?>
				</div>
				<div class="pos_top_header_fotter" style="font-size: 12px;margin-top:5px;">
					<p style="margin: 0;font-size: 9px;text-transform: uppercase;"><i><b><?php echo $in_word; ?> Taka Only.</b></i></p>
					Thank You For Shopping.
				</div>
				<div style="border-top: 1px solid gray; width: 100%; height: 1px; float:left;"> </div>

				<div class="pos_top_header_fotter" style="background:;line-height:12px;margin-top:5px;">
					Software Developed By:<br />
					<b>IT Lab Solutions Ltd.</b> Call: +8801842485222
				</div>
			</div>
			<!--End of main container body -->
		</div>
	</div>
	<!--End of main container body -->
</body>

</html>