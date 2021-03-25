<div class="content-wrapper">
	<br>
	<section>
		<div class="row">
			<div class="col-md-7 col-md-offset-3">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Payable Receivable Report</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>account/all_pay_reci_report_find" class="form-horizontal" method="post" autocomplete="off" enctype="multipart/form-data" id="form_6">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Type</label>
								<div class="col-sm-4">
									<select class="form-control select2" name="type" id="type">
										<option value="">Select Type</option>
										<option value="receive">Receivable Report</option>
										<option value="payable">Payable Report</option>
										<option value="expense_payable">Expense Payable Report</option>
									</select>
								</div>
								<div class="col-sm-4">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
									<a href="<?php echo base_url();?>account/download_data_reci_pay" id="down" target="_blank" class="btn btn-primary btn-sm" style="text-decoration:none;display:none;"><i class="fa fa-download"></i> Download</a>
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
			<img src="<?php echo base_url();?>assets/img/LoaderIcon.gif" id="loaderIcon"/>
		</div>
	</div>
	<input type="hidden" id="type_id">
	<input type="hidden" id="start">
	<input type="hidden" id="end">
	<section class="content" id="infomsg" style="display:none;">
		<div class="row">
			<div class="col-md-12">
				<div class="box">	 
					<div class="box-body">
						<div class="wrap">
							
							<div class="inner_table table-responsive new_data_2" id="search_data">
								
							</div>
							<table class="table table-responsive">
								<tr>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"></td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span class="global_amount_sum" style="color:black;font-weight:bold;"></span></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</section>
</div>
