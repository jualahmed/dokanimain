<!DOCTYPE html>
<html>

<head>
	<title>Quotation</title>

	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-2.2.3.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/posinvoice.css" type="text/css" />

</head>

<body>
	<?php if ($quotationDetails != FALSE) {
		$total = 0;
		$ind = 1; ?>
		<div id="main_container_body_main">
			<div id="main_container_body_main2">
				<div id="main_container_body">
					<div class="text-center">
						<?php
						$shop_id = $this->tank_auth->get_shop_id();
						$this->db->where('shop_id', $shop_id);
						$shop_info = $this->db->get('shop_setup')->row();
						?>
						<p><img style="width: 50px;" src="<?php echo base_url(); ?>assets/img/shop/<?php echo $shop_info->logo; ?>" alt=""></p>
						<h4 style="margin: 0;font-weight: bold"><?php echo $shop_info->shop_name; ?></h4>
						<p style="margin: 0;font-size: 12px;"> <?php echo ($shop_info->shop_address) ?> </p>
						<p style="font-size: 12px;font-weight: bold"> <?php echo ($shop_info->shop_contact) ?> </p>

						<h4 style="margin: 0;font-weight: bold;">Quotation ID. : <?php echo $quotation->quotation_id; ?></h4>
						<p style="margin: 0px;font-size:11px;">Date: <?php $newDate = date("d-m-Y", strtotime($quotation->created_at));
																		echo $newDate; ?> | <?php $newDate1 = date("h:i A", strtotime($quotation->created_at));
																							echo $newDate1; ?> | <?php echo $quotation->user_full_name; ?></p>
						<p style="margin: 0px;">Customer : <?php echo $quotation->customer_name; ?></p>
					</div>
					<div id="pos_top_header_thired">

						<div class="CSSTableGenerator" style="width:100%;margin:0px auto;float:left">

							<table class="table table-bordered table_2">
								<tr style="background-color: #f0f3f5;/*#00c0ef*/; color: black;/*white/*;">
									<td style="width: 50%;">Name</td>
									<td style="text-align: center;">Quantity</td>
									<td style="text-align: center;">Price</td>
									<td style="text-align: center;">Total</td>
								</tr>
								<?php foreach ($quotationDetails->result() as $tmp) { ?>

									<?php if (1 % 2 == 0) { ?>
										<tr style="background-color: #f0f3f5;">
											<td>
												<?php echo $tmp->product_name ?>
											</td>
											<td style="text-align: center;">
												<?php echo  $tmp->quotation_quantity ?>
											</td>
											<td style="text-align: right;">
												<?php echo  sprintf('%0.2f', $tmp->unit_sale_price) ?>
											</td>
											<td style="text-align: right;">
												<?php
												$total 		+= ($tmp->unit_sale_price * $tmp->quotation_quantity);
												echo  sprintf('%0.2f', $tmp->unit_sale_price * $tmp->quotation_quantity);

												?>
											</td>
										</tr>
									<?php } else { ?>
										<tr>
											<td>
												<?php echo $tmp->product_name ?>
											</td>
											<td style="text-align: center;">
												<?php echo  $tmp->quotation_quantity ?>
											</td>
											<td style="text-align: right;">
												<?php echo  $tmp->unit_sale_price ?>
											</td>
											<td style="text-align: right;">
												<?php
												$total 		+= ($tmp->unit_sale_price * $tmp->quotation_quantity);
												echo  $tmp->unit_sale_price * $tmp->quotation_quantity;

												?>
											</td>
										</tr>
								<?php }
									$ind++;
								}
								$total = $total + $quotation->quotation_delivery_charge - $quotation->quotation_discount_amount + $quotation->quotation_vat;
								?>
							</table>
						</div>
					</div>

					<div id="pos_top_header_fourth" style="width: 100%; float: right;">
						<div class="pos_top_header_fourth_left" style="font-weight: bolder;font-size: 10px;"> Total: </div>
						<div class="pos_top_header_fourth_right" style="font-weight: bolder;font-size: 10px;">
							<?php
							echo number_format($quotation->quotation_total_price, 2);
							?>
						</div>
						<div class="pos_top_header_fourth_left" style="font-size: 10px"> Discount: </div>
						<div class="pos_top_header_fourth_right" style="font-size: 10px">
							<?php
							echo number_format($quotation->quotation_discount_amount, 2);
							?>
						</div>
						<div class="pos_top_header_fourth_left" style="font-size: 10px"> Delivery Charge: </div>
						<div class="pos_top_header_fourth_right" style="font-size: 10px">
							<?php
							echo number_format($quotation->quotation_delivery_charge, 2);
							?>
						</div>
						<div class="pos_top_header_fourth_left" style="font-weight: bolder;font-size: 12px;"> Grand Total: </div>
						<div class="pos_top_header_fourth_right" style="font-weight: bolder;font-size: 12px;">
							<?php
							echo number_format($total, 2);
							?>
						</div>
					</div>

					<div class="pos_top_header_fotter" style="font-size: 12px;margin-top:5px;">
						<p style="margin: 0;font-size: 9px;text-transform: uppercase;"><i><b><?php echo $in_word; ?> Only.</b></i></p>
						Thank You For Shopping.
					</div>
					<div style="border-top: 1px solid gray; width: 100%; height: 1px; float:left;"> </div>

					<div class="pos_top_header_fotter" style="background:;line-height:12px;margin-top:5px;">
						Software Developed By:<br />
						<b>IT Lab Solutions Ltd.</b> Call: +8801842485222
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
</body>

</html>