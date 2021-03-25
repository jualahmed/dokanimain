<!DOCTYPE HTML>
<html>

<head>
	<title> Dokani : IT Lab Solutions </title>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/printstyle.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/posinvoice.css" type="text/css" />
	<script>
		window.print();
	</script>
	<style>
		.CSSTableGenerator td {
			font-size: 14px !important;
		}

		.CSSTableGenerator table tr:first-child {
			border-bottom: 1px solid #ddd;
		}

		.CSSTableGenerator thead th,
		.CSSTableGenerator thead td,
		.CSSTableGenerator tfoot th,
		.CSSTableGenerator tfoot td {
			background: #a6a6a6 !important;
		}

		#pos_top_header_fourth {
			font-size: 13px;
		}

		.table td,
		.table th {
			padding: 5px 8px !important;
			line-height: 1.42857143;
			font-size: 13px !important;
			vertical-align: middle;
		}

		.header {
			position: fixed;
			top: 0;
			left: 50%;
			transform: translateX(-50%);
		}

		.header,
		.header-space {
			height: 170px;
			width: 100%;
		}

		.footer,
		.footer-space {
			height: 75px;
			width: 100%;
		}

		.footer {
			position: fixed;
			bottom: 30px;
			left: 50%;
			transform: translateX(-50%);
		}

		.footer-top {
			display: flex;
			justify-content: space-between;
		}

		.footer-top p {
			margin: 0;
		}

		.bb-dashed {
			border-bottom: 1px dashed;
		}

		@media screen {
			body {
				-webkit-print-color-adjust: exact !important;
			}
		}

		.customer-table th,
		.customer-table td {
			line-height: 1 !important;
		}
	</style>
</head>
</head>
<?php
$this->load->config('custom_config');
$pre_blance_show_invoice = $this->config->item('pre_blance_show_invoice');
?>
<?php $row_data = $sale_info->row(); ?>

<body>
	<div id="main_invoice" style="width: 100%;">
		<div id="invoice">
			<table style="width: 100%;">
				<thead>
					<tr>
						<td class="header-space">

						</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>
							<div id="pos_top_header_thired" style="margin-bottom: 20px;">
								<?php
								if ($sale_info->num_rows() > 0) {
								?>
									<div class="CSSTableGenerator" style="width:100%;margin:0px auto;float:left">
										<table>
											<tr>
												<td>SL</td>
												<td style="text-align: left;">Product Name</td>
												<td>Qty </td>
												<td style="text-align: right;">Price</td>
												<td style="text-align: right;">Total</td>
											</tr>
											<?php
											$save1 = 0;
											$totalMrp = 0;
											$totalUnitSalePrice = 0;
											$totalActualSalePrice = 0;
											$totalQuantity = 0;
											foreach ($sale_info->result() as $key => $field) :
												$general_sale_price = $field->general_sale_price;
												$sale_quantity = $field->sale_quantity;
												$unit_sale_price = $field->unit_sale_price;
												$actual_sale_price = $field->actual_sale_price;

												$totalQuantity += $sale_quantity;
												$totalMrp += ($general_sale_price * $sale_quantity);
												$totalUnitSalePrice += ($unit_sale_price * $sale_quantity);
												$totalActualSalePrice += ($actual_sale_price * $sale_quantity);
											?>
												<tr>
													<td style="width:2%"> #<?php echo $key + 1; ?> </td>
													<td style="text-align:left;">

														<?php

														if ($sale_warranty_info != '') {
															echo '<p style="min-height:13px;font-size:15px;font-weight:bold;margin:0px;">' . $field->product_name . '</p>';
															//echo 'SN ';
															foreach ($sale_warranty_info->result() as $filed2) {
																if ($field->product_id == $filed2->product_id) {
																	echo $filed2->sl_no . '  ' . '  ';
																}
															}
														} else {
															echo '<p style="min-height:13px;font-size:15px;font-weight:bold;margin:0px;">' . $field->product_name . '</p>';
														}
														?>
													</td>
													<td style="width:15%;">
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
											<tfoot>
												<tr>
													<td colspan="2" style="text-align: center;">Total</td>
													<td style="text-align: center;"><?php echo $totalQuantity; ?></td>
													<th></th>
													<td style="text-align: right;"><?php echo number_format($totalUnitSalePrice, 2); ?></td>
												</tr>
											</tfoot>
										</table>
									</div>
								<?php
								}
								?>
							</div>
							<div id="pos_top_header_fourth" style="width: 100%;">
								<?php
								$total_price_amount = $total_price ? $total_price->total_amount_sale : 0;
								$total_collection_amount = $total_collection ? $total_collection->total_amount_sale_collection : 0;
								$total_return_amount = $total_return ? $total_return->total_amount_sale_return : 0;

								$due = $total_price_amount - ($total_collection_amount + $total_return_amount);
								if ($due != 0) { ?>
									<div style="float: left;width: 30%">
										<h2>
											Due:
											<?php
											echo number_format($due, 2);
											?>
										</h2>
									</div>
								<?php }
								?>
								<div style="float: right;width: 70%">
									<?php if ($row_data->sale_return_amount > 0) { ?>
										<div class="pos_top_header_fourth_left"> Sale Return</div>
										<div class="pos_top_header_fourth_right"> <?php echo number_format($row_data->sale_return_amount, 2); ?></div>
									<?php } ?>

									<?php
									if ($row_data->discount_amount > 0) { ?>
										<div class="pos_top_header_fourth_left"> Discount </div>
										<div class="pos_top_header_fourth_right"> <?php echo number_format(($row_data->discount_amount), 2); ?></div>
									<?php }
									?>

									<div class="pos_top_header_fourth_left" style="font-weight: bolder;font-size: 16px;"> Grand Total </div>
									<div class="pos_top_header_fourth_right" style="font-weight: bolder;font-size: 16px;"> <?php echo number_format($row_data->total_price - $row_data->discount_amount, 2); ?></div>

									<?php
									$sale_return = $row_data->sale_return_amount;
									$total_price = $row_data->total_price;
									?>
									<?php
									if ($sale_return > 0) {
									?>
										<div class="pos_top_header_fourth_left"> Paid </div>
										<div class="pos_top_header_fourth_right"> <?php echo number_format($row_data->total_paid, 2); ?></div>
									<?php
									} else {
									?>
										<div class="pos_top_header_fourth_left"> Received </div>
										<div class="pos_top_header_fourth_right"> <?php echo number_format($row_data->total_paid, 2); ?></div>
									<?php
									}
									?>

									<div class="pos_top_header_fourth_left"> Returned </div>
									<div class="pos_top_header_fourth_right"> <?php echo number_format($row_data->return_money, 2); ?></div>
									<?php if ($row_data->total_price - $row_data->sale_return_amount - $row_data->discount_amount > $row_data->total_paid) { ?>
										<div class="pos_top_header_fourth_left"> Due </div>
										<div class="pos_top_header_fourth_right"> <?php echo number_format($row_data->total_price - $row_data->sale_return_amount - $row_data->discount_amount - $row_data->total_paid, 2); ?></div>
									<?php } ?>
								</div>
							</div>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td class="footer-space">

						</td>
					</tr>
				</tfoot>
			</table>




			<header class="header">
				<div class="text-center" style="margin-bottom: 20px;">
					<?php
					$shop_id = $this->tank_auth->get_shop_id();
					$this->db->where('shop_id', $shop_id);
					$shop_info = $this->db->get('shop_setup')->row();
					?>


					<div style="display: flex;justify-content: space-between;align-items: center;">
						<div style="display: flex;justify-content: space-between;">
							<p style="width: 50px;"><img style="width: 100%;" src="<?php echo base_url(); ?>assets/img/shop/<?php echo $shop_info->logo; ?>" alt=""></p>
							<div style="text-align: left;padding-left: 15px;">
								<h4 style="margin: 0;font-weight: bold"><?php echo $shop_info->shop_name; ?></h4>
								<p style="margin: 0;font-size: 12px;"> <?php echo ($shop_info->shop_address) ?> </p>
								<p style="font-size: 12px;font-weight: bold"> <?php echo ($shop_info->shop_contact) ?> </p>
							</div>
						</div>
						<div class="div" style="text-align: right;">
							<h4 style="margin: 0;font-weight: bold;">Invoice No. : <?php echo $invoice_id; ?></h4>
							<p style="margin: 0px;font-size:11px;"><?php $newDate = date("d-m-Y", strtotime($row_data->date_time));
																	echo $newDate; ?> | <?php $newDate1 = date("h:i A", strtotime($row_data->date_time));
																						echo $newDate1; ?> | <?php echo $row_data->user_full_name; ?></p>
						</div>
					</div>


				</div>
				<table class="table customer-table table-bordered" style="margin-bottom: 20px;">
					<tr>
						<td>Customer Name: <?php echo empty($row_data->customer_name) ? 'Walk In' : $row_data->customer_name; ?></td>
						<td>Customer ID: <?php echo $row_data->customer_id; ?></td>
					</tr>
					<tr>

						<td>Address: <?php echo $row_data->customer_address; ?></td>
						<td>Contact: <?php echo $row_data->customer_contact_no; ?></td>
					</tr>
				</table>
			</header>
			<footer class="footer">
				<div class="footer-top">
					<p class="bb-dashed"><strong><?php echo empty($row_data->customer_name) ? 'Walk In' : $row_data->customer_name; ?></strong></p>
					<p class="bb-dashed">On behalf of <strong><?php echo $shop_info->shop_name; ?></strong></p>
				</div>
				<div class="pos_top_header_fotter" style="font-size: 16px;margin-top:5px;">
					<p style="margin: 0;font-size: 12px;text-transform: uppercase;"><i><b><?php echo $in_word; ?> Taka Only.</b></i></p>
					Thank You For Shopping.
				</div>
				<div style="border-top: 1px solid gray; width: 100%; height: 1px; float:left;"> </div>

				<div class="pos_top_header_fotter" style="line-height:16px;margin-top:5px;">
					Software Developed By:<br />
					<b>IT Lab Solutions Ltd.</b> Call: +8801842485222
				</div>
			</footer>
			<!--end of invoice-->
		</div>
	</div>
</body>

</html>