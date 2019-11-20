
<div class="content-wrapper">
	<br>
	<section>
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Cheque Status Report</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>account/all_cheque_status_report_find" class="form-horizontal" method="post" autocomplete="off" enctype="multipart/form-data" id="form_6">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Cheque Status</label>
								<div class="col-sm-4">
									<select class="form-control select2" name="cheque_status" id="cheque_status">
										<option value="">Select Status</option>
										<option value="active">Hounored</option>
										<option value="inactive">Dishounored</option>
										<option value="deleted">Delete</option>
									</select>
								</div>
								<div class="col-sm-3">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
<div class="modal" style="display: none">
	<div class="center">
		<img src="<?php echo base_url();?>assets2/spin.gif" id="loaderIcon"/>
	</div>
</div>
<input type="hidden" id="investor">
<input type="hidden" id="start">
<input type="hidden" id="end">
<section class="content-3" id="infomsg" style="display:none;">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="box">	 
				<div class="box-body">
					<div class="wrap">
						<table class="table">
							<tr>
							  <td>No</td>
							  <td>Cheque ID</td>
							  <td>Cheque Date</td>
							  <td>Trasaction ID</td>
							  <td>Ledger Name</td>
							  <td>Ledger Type</td>
							  <td>Bank Name</td>
							  <td>Cheque No</td>
							  <td style="text-align:right;"> Amount</td>
							  <td style="text-align:center;">Status</td>
							  <td style="text-align:center;">Action</td>
							</tr>
						</table>
						<div class="inner_table">
							<table class="new_data_2" id="search_data">
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</section>
</div>