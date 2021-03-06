<div class="content-wrapper">
	<?php
	if (!defined('BASEPATH')) exit('No direct script access allowed');
	$productId = array(
		'name'	=> 'productId',
		'id'	=> 'productId',
		'value' => set_value('productId'),
		'maxlength'	=> 49,
		'tabindex' => 1
	);
	$productName = array(
		'name'	=> 'productName',
		'id'	=> 'product_id',
		'value' => set_value('product_id'),
		'maxlength'	=> 49,
		'tabindex' => 1
	);
	$Quantity = array(
		'name'	=> 'Quantity',
		'id'	=> 'Quantity',
		'value' => set_value('Quantity'),
		'maxlength'	=> 149,
		'tabindex' => 4
	);
	?>
	<?php
	if ($status != '') {
		if ($status == "exists") {
			echo '<div class="alert alert-warning alert-dismissible" style="background:#f39c12;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-check"></i> Already Exist</h4>
					</div>';
		} else if ($status == "successful") {
			echo '<div class="alert alert-success alert-dismissible" style="background:#00a65a;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-check"></i> Success</h4>
					</div>';
		} else if ($status == "failed") {
			echo '<div class="alert alert-danger alert-dismissible" style="background:#dd4b39;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-check"></i> Failed</h4>
					</div>';
		} else {
			echo validation_errors();
		}
	}
	?>
	<section>
		<br>
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">
							<p>Search Barcode &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; If New Barcode Print, At First Click " <b style="color:#15d1da;">DELETE ALL</b> " Button.</p>
						</h3>
					</div>
					<div class="box-body">
						<form action="<?php echo base_url(); ?>product/search_barcode_barcode" method="post" id="form_22" class="form-horizontal">
							<div class="form-group">
								<label class="col-sm-2 control-label">Receipt</label>
								<div class="col-sm-2">
									<select name="" id="" class="form-control" onchange="document.location.href=this.options[this.selectedIndex].value;">
										<option value="0">Select a Receipt</option>
										<?php foreach ($purchases as $key => $var) : ?>
											<option value="<?php echo base_url() . 'product/searchBarcode/' . $var->receipt_id ?>" <?php echo $var->receipt_id == $receipt_id ? 'selected' : '' ?>><?php echo $var->distributor_name ?>( <?php echo $var->receipt_id ?> )</option>
										<?php endforeach ?>
									</select>
								</div>

								<label for="inputPassword3" class="col-sm-1 control-label">Product</label>
								<div class="col-sm-3">
									<select name="" id="product_id" class="form-control" onchange="document.location.href=this.options[this.selectedIndex].value;">
										<option value="">Select Product</option>
										<?php foreach ($product_info as $key => $var) : ?>
											<option value="<?php echo base_url() . 'product/searchBarcode/' . $receipt_id . '/' . $var->product_id ?>" <?php echo $var->product_id == $product_id ? 'selected' : '' ?>><?php echo $var->product_name ?></option>
										<?php endforeach ?>
									</select>
								</div>

							</div>
						</form>
					</div>
				</div>
			</div>
	</section>

	<section>
		<div class="row">
			<?php
			if (isset($receiptProducts)) { ?>
				<div class="col-md-6 col-md-offset-3">
					<div class="box">
						<div class="box-body">
							<table class="table table-secondary">
								<thead>
									<tr>
										<th>S.N.</th>
										<th>Product</th>
										<th class="text-center">Stock</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach ($receiptProducts as $key => $product) { ?>
										<tr style="background-color: <?php echo $product->product_id == $product_id ? '#fff7bf' : '#fff'; ?>">
											<th><?php echo $key + 1; ?></th>
											<th><?php echo $product->product_name; ?></th>
											<th class="text-center"><?php echo $product->purchase_quantity; ?></th>
											<td>
												<a class="text-primary" href="<?php echo base_url() . 'product/searchBarcode/' . $receipt_id . '/' . $product->product_id ?>"><i class="fa fa-barcode"></i></a>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</section>
	<?php
	if ($this->uri->segment(4) || $product_type == 'bulk' || $product_type == 'individual') {
	?>
		<section>
			<div class="row">
				<div class="col-md-12">
					<div class="box">
						<div class="box-body">
							<?php
							echo form_open($this->uri->uri_string());
							echo form_hidden('product_id', $this->uri->segment(4));
							echo form_hidden('unit_sale_price', $sale_price);
							echo form_hidden('general_sale_price', $general_sale_price);
							echo form_hidden('PRODUCT_NAME', $product_name);
							echo form_hidden('special_for_individual', true);

							?>
							<div class="form-group">
								<label for="inputPassword3" class="col-sm-1 control-label">Quantity</label>
								<div class="col-sm-3">
									<?php
									echo form_input($Quantity, '', ' placeholder="Ex : 5" class ="form-control-2" style="color:gray;"');
									echo form_error($Quantity['name'], '<div style="height:30px;background:red;width:364px;margin-top:5px;margin-left:261px;font-size:0px;">', '</div>');
									?>
								</div>
								<div class="col-sm-22">
									<?php
									echo form_submit('submit', 'Submit', 'style="width:100px;" class="btn btn-success" onclick="return confirm(\'Are you sure want to Add New Details? \')"');
									?>
								</div>
							</div>
							<div class="wrapp">
								<table class="table table-secondary">
									<tr>
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:230%;">Product</td>
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Stock</td>
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">BP</td>
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">SP</td>
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">MRP</td>
									</tr>
									<tr>
										<td style="width:230%;"> <?php echo $product_name ?></td>
										<td> <?php echo $available_stock ?></td>
										<td> <?php echo $buy_price ?></td>
										<td> <?php echo $sale_price ?></td>
										<td> <?php echo $general_sale_price ?></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php
	}
	?>
	<section>
		<div class="row">
			<div class="col-md-12">
				<div class="box" style="margin-bottom:4px;">
					<div class="box-body">
						<table class="table table-secondary">
							<tr>
								<td colspan="1" style="text-align:left;text-indent:5px;font-size:15px;width:35px;color:#444;font-weight:bold;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"> Delete</td>
								<td colspan="2" style="text-align:left;text-indent:5px;font-size:15px;width:35px;color:#444;font-weight:bold;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"><a href="<?php echo base_url(); ?>product/delete_all_barcode_print_product" class="btn-primary" title="Delete All" id="print" style="text-decoration:none;"><i class="fa fa-fw fa-close"></i> Delete All</a></td>
								<td colspan="1" style="text-align:left;text-indent:5px;font-size:15px;width:35px;color:#444;font-weight:bold;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"></td>
								<td colspan="2" style="text-align:left;text-indent:5px;font-size:15px;width:35px;color:#444;font-weight:bold;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">
									<button data-url="<?php echo base_url() . 'product/print_barcode_by_search'; ?>" type="button" id="printBarcode" class="btn-primary btn btn-sm" style="text-decoration:none;">
										<i class="fa fa-print"></i> Print
									</button>
								</td>
							</tr>
							<tr>
								<td>S/N</td>
								<td width="60%">Product Name</td>
								<td>Quantity</td>
								<td>Sale Price</td>
								<td>Action</td>
							</tr>
							<?php
							if ($listed_product->num_rows() > 0) {
								$i = 1;
								foreach ($listed_product->result() as $field) {
							?>
									<tr>
										<td> <?php echo $i; ?></td>
										<td style="width:350%;"> <?php echo $field->product_name; ?></td>
										<td> <?php echo $field->quantity ?></td>
										<td> <?php echo $field->sale_price ?></td>
										<td>
											<a href="<?php echo base_url(); ?>product/delete_barcode_print_product/<?php echo $field->print_id; ?>" class="edit_link" title="delete"><i class="fa fa-fw fa-close"></i></a>
										</td>
									</tr>
								<?php
									$i++;
								}
							} else { ?>
								<tr>
									<td colspan="6">
										<h3 class="text-center"> No Product Availavle for Print</h3>
									</td>
								</tr>
							<?php
							}
							?>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

<!-- Modal -->
<div class="modal fade" id="typeModal" tabindex="-1" role="dialog" aria-labelledby="EditModelLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
				<div class="box-body">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<label>
								<input type="radio" checked name="type" id="typeSingle" value="0">
								<span>Single</span>
							</label>
						</div>
						<div class="col-md-6 col-sm-12">
							<label>
								<input type="radio" name="type" id="typeA4" value="1">
								<span>A4</span>
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success" id="submit_btn"><i class="fa fa-fw fa-save"></i> Print</button>
			</div>
		</div>
	</div>
</div>