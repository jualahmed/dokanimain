<div class="content-wrapper">
	<?php
	$result = $this->uri->segment(7);
	if ($result != '') {
		if ($result == 'success') {
			echo '<script>
						$(document).ready(function(){
							swal("Sale Return Done", ":)", "success")
						});
				</script>';
		}
		if ($result == 'customer') {
			echo '<script>
						$(document).ready(function(){
							swal("Select Valid Customer", ":)", "info")
						});
				</script>';
		}
	}
	?>
	<input type="hidden" id="return_type" value="<?php echo $this->uri->segment(3); ?>">
	<input type="hidden" id="invo_type" value="<?php echo $this->uri->segment(4); ?>">
	<input type="hidden" id="in_id" value="<?php echo $this->uri->segment(5); ?>">
	<input type="hidden" id="pro_id" value="<?php echo $this->uri->segment(6); ?>">
	<section class="content">
		<div class="row">
			<div class="col-md-6">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"> Sale Return</h3>
					</div>
					<!-- /.box-header -->
					<!-- form start -->
					<div class="box-body">
						<div class="col-md-12">
							<?php

							$return_type = $this->uri->segment(3);
							$invoice_type = $this->uri->segment(4);
							$invoice_id = $this->uri->segment(5);

							?>
							<table class="table table-bordered reduce_space">
								<tr>
									<td style="vertical-align: middle;width: 25%;">Cash Return:</td>
									<td><input type="checkbox" <?php echo ($return_type == 'cash') ? 'checked' : '' ?> class="s1" style="width: 100%;"></td>
									<td style="vertical-align: middle;width: 25%;">Return Aginst Sale:</td>
									<td><input type="checkbox" <?php echo ($return_type == 'productsale') ? 'checked' : '' ?> class="s3" style="width: 100%;"></td>
								</tr>
							</table>

							<table class="table table-bordered reduce_space">
								<?php
								if ($invoice_type != '' && $invoice_type != 'null') {
								?>
									<tr>
										<td style="vertical-align: middle;">Invoice:</td>
										<td colspan="3">
											<?php
											if ($invoice_type == 'yes') {
											?>
												<input type="number" name="invoice_id" required id="invoice_id" class="form-control" value="<?php echo $invoice_id; ?>">
											<?php
											} else {
											?>
												<input type="number" class="form-control" disabled>
											<?php
											}
											?>
										</td>
									</tr>
									<tr>
										<td style="vertical-align: middle;">Product:</td>
										<td colspan="3">
											<select class="form-control select2 sel_dist" name="product_id" id="product_id" style="width: 100%;" required>
												<option value="">Select Product</option>
												<?php
												if ($product_info->num_rows() > 0) {
													foreach ($product_info->result() as $field) {
												?>
														<option value="<?php echo $field->product_id; ?>"><?php echo $field->product_name; ?></option>
												<?php
													}
												}
												?>
											</select>
										</td>
									</tr>
								<?php
								}
								?>

							</table>
							<form action="<?php echo base_url(); ?>salereturn/list_cashsalereturn_temp_data" method="post" autocomplete="off">
								<input type="hidden" name="pro_id" value="<?php echo $this->uri->segment(6); ?>">
								<input type="hidden" name="inv_id" value="<?php echo $this->uri->segment(5); ?>">
								<input type="hidden" name="in_type" value="<?php echo $this->uri->segment(4); ?>">
								<input type="hidden" name="ret_type" value="<?php echo $this->uri->segment(3); ?>">
								<?php
								if ($this->uri->segment(6) != '' && $this->uri->segment(6) != 'null') {
									if ($product_info_warranty_details->num_rows() > 0) {
								?>
										<table class="table table-bordered reduce_space">
											<tr>
												<td colspan="4" style="text-align:center;background: #0f77ab;color: white;">Product Details</td>
											</tr>
											<?php
											if ($this->uri->segment(4) == 'yes') {
												foreach ($product_info_details->result() as $tmp) {
											?>
													<tr>
														<td>Product Name</td>
														<td colspan="3"><?php echo $tmp->product_name; ?></td>
													</tr>
													<tr>
														<td>Sale Quantity</td>
														<td><?php echo $tmp->sale_quantity; ?></td>
														<td>Discount Amount</td>
														<td><?php echo sprintf('%0.2f', $tmp->discount); ?></td>
													</tr>
													<tr>
														<td>Product Price</td>
														<td><?php echo sprintf('%0.2f', $tmp->unit_sale_price); ?></td>
														<td>Shop Price</td>
														<td><?php echo sprintf('%0.2f', $tmp->general_sale_price); ?></td>
													</tr>
													<tr>
														<td>Exact Sale Price</td>
														<td colspan="4"><?php echo sprintf('%0.2f', $tmp->exact_sale_price); ?></td>
														<input type="hidden" name="exact_price" value="<?php echo sprintf('%0.2f', $tmp->exact_sale_price); ?>">
													</tr>
												<?php
												}
											} else if ($this->uri->segment(4) == 'no') {
												foreach ($product_info_details->result() as $tmp) {
												?>
													<tr>
														<td>Product Name</td>
														<td colspan="3"><?php echo $tmp->product_name; ?></td>
													</tr>
													<tr>
														<td>Stock Amount</td>
														<td><?php echo $tmp->stock_amount; ?></td>
														<td>Buy Price</td>
														<td><?php echo sprintf('%0.2f', $tmp->bulk_unit_buy_price); ?></td>
													</tr>
													<tr>
														<td>Product Price</td>
														<td><?php echo sprintf('%0.2f', $tmp->bulk_unit_sale_price); ?></td>
														<td>Shop Price</td>
														<td><?php echo sprintf('%0.2f', $tmp->general_unit_sale_price); ?></td>
														<input type="hidden" name="exact_price" value="<?php echo sprintf('%0.2f', $tmp->general_unit_sale_price); ?>">
													</tr>
											<?php
												}
											}
											?>
										</table>
										<table class="table table-bordered reduce_space">
											<tr>
												<td colspan="4" style="text-align:center;background: #0f77ab;color: white;">Warranty Product Details</td>
											</tr>
											<tr>
												<td style="text-align:center;">No</td>
												<td style="text-align:left;">Serial Name</td>
												<td style="text-align:center;">Action</td>
											</tr>
											<?php
											$i = 1;
											foreach ($product_info_warranty_details->result() as $tmp2) {
											?>
												<tr>
													<td style="text-align:center;"><?php echo $tmp2->ip_id; ?></td>
													<td style="text-align:left;"><?php echo $tmp2->sl_no; ?></td>
													<td style="text-align:center;"><input type="checkbox" name="ip_ids[<?php echo $i; ?>]" value="<?php echo $tmp2->ip_id; ?>" id="check_box"></td>
												</tr>
											<?php
												$i++;
											}
											?>
										</table>
									<?php
									} else {
									?>
										<?php
										if ($product_info_details->num_rows() > 0) {
										?>
											<table class="table table-bordered reduce_space">
												<tr>
													<td colspan="4" style="text-align:center;background: #0f77ab;color: white;">Product Details</td>
												</tr>
												<?php
												if ($this->uri->segment(4) == 'yes') {
													foreach ($product_info_details->result() as $tmp) {
												?>
														<tr>
															<td>Product Name</td>
															<td colspan="3"><?php echo $tmp->product_name; ?></td>
														</tr>
														<tr>
															<td>Sale Quantity</td>
															<td><?php echo $tmp->sale_quantity; ?></td>
															<td>Discount Amount</td>
															<td><?php echo sprintf('%0.2f', $tmp->discount); ?></td>
														</tr>
														<tr>
															<td>Product Price</td>
															<td><?php echo sprintf('%0.2f', $tmp->unit_sale_price); ?></td>
															<td>Shop Price</td>
															<td><?php echo sprintf('%0.2f', $tmp->general_sale_price); ?></td>
														</tr>
														<tr>
															<td>Exact Sale Price</td>
															<td colspan="4"><?php echo sprintf('%0.2f', $tmp->exact_sale_price); ?></td>
															<input type="hidden" name="exact_price" value="<?php echo sprintf('%0.2f', $tmp->exact_sale_price); ?>">
														</tr>
														<tr>
															<td>Return Quantity</td>
															<td colspan="4"><input type="text" id="return_amount" name="return_amount" class="form-control"></td>
														</tr>
													<?php
													}
												} else if ($this->uri->segment(4) == 'no') {
													foreach ($product_info_details->result() as $tmp) {
													?>
														<tr>
															<td>Product Name</td>
															<td colspan="3"><?php echo $tmp->product_name; ?></td>
														</tr>
														<tr>
															<td>Stock Amount</td>
															<td><?php echo $tmp->stock_amount; ?></td>
															<td>Buy Price</td>
															<td><?php echo sprintf('%0.2f', $tmp->bulk_unit_buy_price); ?></td>
														</tr>
														<tr>
															<td>Product Price</td>
															<td><?php echo sprintf('%0.2f', $tmp->bulk_unit_sale_price); ?></td>
															<td>Shop Price</td>
															<td><?php echo sprintf('%0.2f', $tmp->general_unit_sale_price); ?></td>
															<input type="hidden" name="exact_price" value="<?php echo sprintf('%0.2f', $tmp->general_unit_sale_price); ?>">
														</tr>
														<tr>
															<td>Return Quantity</td>
															<td colspan="4"><input type="text" id="return_amount" name="return_amount" class="form-control"></td>
														</tr>
												<?php
													}
												}
												?>
											</table>
								<?php
										}
									}
								}
								?>
								<div class="box-footer" style="background: #0f77ab;">
									<center>
										<div class="col-sm-22">
											<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit"><i class="fa fa-fw fa-save"></i> Create</button>
											<a href="<?php echo base_url(); ?>salereturn/cash_salereturn" class="btn btn-danger btn-sm" name="search_random" id="submit"><i class="fa fa-close"></i> Cancel</a>
										</div>
									</center>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<?php
			if ($return_main_product->num_rows() > 0) {
			?>
				<div class="col-md-6">
					<div class="box">
						<div class="box-header with-border" style="background: #0f77ab;">
							<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">
								<?php echo $return_type == "cash" ? "Cash Return" : "Sale Return List" ?>
							</h3>
						</div>
						<!-- /.box-header -->
						<!-- form start -->
						<div class="box-body">
							<div class="col-md-12">
								<?php
								$field = $return_main_product->row();
								?>
								<table class="table table-bordered reduce_space">
									<tr>
										<td style="text-align:center;"><b>Invoice ID:</b> <?php echo $field->inv_id; ?></td>
									</tr>
								</table>
								<table class="table table-bordered reduce_space">
									<tr>
										<td style="text-align:center;">No</td>
										<td style="text-align:center;">Product Name</td>
										<td style="text-align:center;">Quantity</td>
										<td style="text-align:center;">Price</td>
										<td style="text-align:center;">Total</td>
										<td style="text-align:center;"></td>
									</tr>
									<?php
									$i = 1;
									$ii = 1;
									$total_amount = 0;
									foreach ($return_main_product->result() as $tmp) {
									?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><b>Main:</b> <?php echo $tmp->product_name; ?><br>
												<?php

												foreach ($return_warranty_product[$ii]->result() as $new_tmp) {
													echo '<b>Warranty:</b> ' . $new_tmp->sl_no . '<br>';
												}
												?>
											</td>
											<td style="text-align:center;"><?php echo $tmp->return_quantity; ?></td>
											<td style="text-align:center;"><?php echo sprintf('%0.2f', $tmp->exact_price); ?></td>
											<td style="text-align:center;"><?php echo sprintf('%0.2f', $tmp->return_quantity * $tmp->exact_price); ?></td>
											<td style="text-align:center;"><i id="delete<?php echo $tmp->srmp_id; ?>" class="fa fa-fw fa-remove delete_product" style="color: red;cursor:pointer;"></i> </td>
										</tr>
									<?php
										$total_amount += $tmp->return_quantity * $tmp->exact_price;
										$ii++;
										$i++;
									}
									?>
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td>Total Amount</td>
										<td style="text-align:center;" id="total_amount_return"><?php echo sprintf('%0.2f', $total_amount); ?></td>
										<td></td>
									</tr>
									<form action="<?php echo base_url(); ?>salereturn/final_sale_return" method="post">
										<input type="hidden" name="in_id" value="<?php echo $this->uri->segment(5); ?>">
										<input type="hidden" name="in_type" value="<?php echo $this->uri->segment(4); ?>">
										<input type="hidden" name="re_type" value="<?php echo $this->uri->segment(3); ?>">
										<input type="hidden" name="total_amount_return" value="<?php echo $total_amount; ?>">

								</table>
								<div id="all_sa_col">
									<table class="table table-bordered remove_thead_space remove_tbody_space" id="sale_return_tbl">
										<thead>
											<?php
											$balance = $customer['balance'];
											$sale = $customer['sale'];
											$sale_return = $customer['sale_return'];
											$due_amount = $sale['sale_amount'] - $balance['balance_amount'] + $sale_return['sale_retrun_amount'];
											?>
											<tr>
												<th colspan="4" class="text-center"><?php echo $balance['customer_name']; ?></th>
												<input type="hidden" name="customer_id" value="<?php echo $balance['customer_id']; ?>">
											</tr>
											<tr class="bg-aqua color-palette">
												<td style="width: 16%;text-align: right;color:black;color: black;background: lightgray;">Sale</td>
												<td style="width: 14%;text-align: right;color:black;color: black;background: lightgray;">Collection</td>
												<td style="width: 16%;text-align: right;color:black;color: black;background: lightgray;">Sale Return</td>
												<td style="width: 16%;text-align: right;color:black;background: lightgray;">Due</td>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td style="text-align: right;"><span id="ledger_amount_sale"><?php echo number_format($sale['sale_amount'], 2); ?></span></td>
												<td style="text-align: right;"><span id="ledger_amount_collection"><?php echo number_format($balance['balance_amount'], 2); ?></span></td>
												<td style="text-align: right;"><span id="ledger_amount_sale_return"><?php echo number_format($sale_return['sale_retrun_amount'], 2); ?></span></td>
												<td style="text-align: right;"><span id="ledger_amount_balance"><?php echo number_format($due_amount, 2); ?></span></td>
											</tr>
											</thead>
									</table>
								</div>
								<table class="table table-bordered remove_thead_space remove_tbody_space">
									<thead>
										<tr>
											<td style="width: 50%;color:black;">Total Return Adjustment</td>
											<?php
											$return_adjustment_amount = 0;
											if ($total_amount > $due_amount) {
												$return_adjustment_amount = $total_amount - $due_amount;
											}
											?>
											<td style="text-align: center;color:black;">
												<input type="text" class="form-control" value="<?php echo number_format($return_adjustment_amount, 2); ?>" name="return_adjustment_amount" style="width: 100%; border-radius: 0px;" placeholder="Total Return Adjustment" autocomplete="off" readonly>
											</td>
										</tr>
									</thead>
								</table>
								<div class="box-footer" style="background: #0f77ab;">
									<center>
										<div class="col-sm-22">
											<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit"><i class="fa fa-fw fa-save"></i> Final Submit</button>
										</div>
									</center>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
			}
			?>
		</div>
	</section>
</div>