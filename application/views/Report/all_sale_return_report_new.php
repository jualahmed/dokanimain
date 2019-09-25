<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-12 ">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Sale Return Report</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>Report/all_sale_return_report_find" class="form-horizontal" method="post" autocomplete="off" enctype="multipart/form-data" id="form_6">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Type</label>
								<div class="col-sm-2">
									<select class="form-control select2" name="type" id="type">
										<option value="">Select Type</option>
										<option value="direct">Cash Return</option>
										<option value="indirect">Product Return</option>
									</select>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Product</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" name="product_name" id="lock22" placeholder="Product Name">
									<input type="hidden" name="product_id" id="pro_id">
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Start</label>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "start_date",'class' => "form-control",'id' => "datepickerrr",'value' => $bd_date, 'tabindex' => 3, 'title' => "Start Date" ));?>
								</div>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "end_date",'class' => "form-control",'id' => "datepickerr", 'value' => $bd_date, 'tabindex' => 3, 'title' => "End Date" ));?>
								</div>
							</div>
							<div class="form-group">
								<br>
								<div class="col-md-12 text-right">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
									<button type="reset" id="reset_btn" class="btn btn-warning btn-sm" style="width:100px;"><i class="fa fa-fw fa-refresh"></i> Reset</button>
									<a href="<?php echo base_url();?>Report/download_data_return" id="down" style="display:none;" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Download</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="modal preload" style="display: none">
		<div class="center">
			<img src="<?php echo base_url();?>assets/assets2/spin.gif" id="loaderIcon"/>
		</div>
	</div>
	<input type="hidden" id="barcode">
	<input type="hidden" id="type_id">
	<input type="hidden" id="product">
	<input type="hidden" id="start">
	<input type="hidden" id="end">
	<section class="content" id="infomsg" style="display:none;">
		<div class="row">
			<div class="col-md-12">
				<div class="box">	 
					<div class="box-body">
						<div class="wrap">
							<table class="head">
								<tr>
								  <td>No</td>
								  <td>Date</td>
								  <td>Return ID</td>
								  <td>Product ID</td>
								  <td>Product</td>
								  <td style="text-align:center;">Quantity</td>
								  <td style="text-align:right;">Sale Price</td>
								  <td style="text-align:right;">Total</td>
								  <td style="text-align:center;">Status</td>
								</tr>
							</table>
							<div class="inner_table" id="search_data">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</section>
</div>
