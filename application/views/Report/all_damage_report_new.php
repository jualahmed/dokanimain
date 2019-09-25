<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Damage Report</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>Report/all_damage_report_find" method="post" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" id="form_6">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Product</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" name="product_name" id="lock22" placeholder="Product Name">
									<input type="hidden" name="product_id" id="pro_id">
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Catagory</label>
								<div class="col-sm-3">
									<?php 
										echo form_dropdown('catagory_name', $catagory_name,'','class="form-control three select9" id="lock3" tabindex="-1" aria-hidden="true"');
									?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Company</label>
								<div class="col-sm-3">
									<?php 
										echo form_dropdown('company_name', $company_name,'','class="form-control company_name select10 four" id="lock4" tabindex="-1" aria-hidden="true"');
									?>
								</div>
							</div>
							<br>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Start</label>
								<div class="col-sm-3">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "start_date",'class' => "form-control",'id' => "datepickerrr",'value' => $bd_date, 'tabindex' => 3, 'title' => "Start Date" ));?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">End</label>
								<div class="col-sm-3">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "end_date",'class' => "form-control",'id' => "datepickerr", 'value' => $bd_date, 'tabindex' => 3, 'title' => "End Date" ));?>
								</div>
								<div class="col-sm-4 mt-2">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
									<button type="reset" id="reset_btn" class="btn btn-warning btn-sm" style="width:100px;"><i class="fa fa-fw fa-refresh"></i> Reset</button>
									<a href="<?php echo base_url();?>Report/download_data_damage" id="down" style="display:none;width:100px;" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Download</a>
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
	<input type="hidden" id="product">
	<input type="hidden" id="category">
	<input type="hidden" id="company">
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
								  <td style="width:3%;">No</td>
								  <td style="width:4%;">Date</td>
								  <td style="width:4%;">Product ID</td>
								  <td style="width: 20%;">Product</td>
								  <td>Company</td>
								  <td>Category</td>
								  <td style="text-align:center;">Quantity</td>
								  <td style="text-align:right;">Buy Price</td>
								</tr>
							</table>
							<div class="inner_table" id="search_data"></div>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</section>
</div>
