<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Credit Collection Report</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>Report/all_credit_collection_report_find" method="post" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" id="form_6">
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
									<button type="submit" class="btn btn-success btn-sm" name="search_random"><i class="fa fa-fw fa-search"></i> Search</button>
									<button type="reset" id="reset_btn" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-refresh"></i> Reset</button>
									<a href="<?php echo base_url();?>Report/download_credit_collection" id="down" style="display:none;width:100px;" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Download</a>
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
								  <td style="width:1%;">ID</td>
								  <td style="width:1%;">Mode</td>
								  <td style="width:2%;text-align:left;">Customer ID</td>
								  <td style="width:4%;text-align:left;">Customer Name</td>
								  <td style="width:2%;text-align:right;">Amount</td>
								  <td style="width:2%;text-align:center;">Date</td>
								  <td style="width:2%;text-align:left;">Creator</td>
								</tr>
							</table>
							<div class="inner_table" id="search_data">
							</div>
							<table class="head">
								<tr>
								  <td style="width:1%;"></td>
								  <td style="width:1%;"></td>
								  <td style="width:2%;"></td>
								  <td style="width:4%;text-align:right;">Total</td>
								  <td style="width:2%;text-align:right;"><span id="total_amount"></span></td>
								  <td style="width:2%;"></td>
								  <td style="width:2%;"></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</section>
</div>
