
<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Product Exchange Report</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>Report/all_product_exchange_report_find" class="form-horizontal" method="post" autocomplete="off" enctype="multipart/form-data" id="form_6">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Start</label>
								<div class="col-sm-3">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "start_date",'class' => "form-control",'id' => "datepickerrr",'value' => $bd_date, 'tabindex' => 3, 'title' => "Start Date" ));?>
								</div>
								<div class="col-sm-3">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "end_date",'class' => "form-control",'id' => "datepickerr", 'value' => $bd_date, 'tabindex' => 3, 'title' => "End Date" ));?>
								</div>
								<div class="col-sm-4 mt-2">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
									<a href="<?php echo base_url();?>Report/download_product_exchange" id="down" style="display:none;" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Download</a>
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
		<img src="<?php echo base_url();?>assets/img/spin.gif" id="loaderIcon"/>
	</div>
</div>
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
							  <td>Exchange ID</td>
							  <td>Product ID</td>
							  <td>Product</td>
							  <td style="text-align:center;">Quantity</td>
							  <td style="text-align:right;">Sale Price</td>
							  <td style="text-align:right;">Total</td>
							  <td style="text-align:center;">Type</td>
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
