<div class="content-wrapper">
	<input type="hidden" id="start_date">
	<input type="hidden" id="end_date">
	<input type="hidden" id="distributor">
	<input type="hidden" id="customer">
	<input type="hidden" id="service_provider">
	<input type="hidden" id="type">
	<input type="hidden" id="employee">
	<input type="hidden" id="purpose">
	<input type="hidden" id="transfer">
	<input type="hidden" id="owner_transfer">
	<br>
	<section>
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Ledger</h3>
					</div>
					<div class="box-body">
						<input type="hidden" id="action" >
						<form class="form-horizontal" id="form_2" method="post" action="<?php echo base_url();?>account/all_ledger_report_find">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Purpose</label>
								<div class="col-sm-2">
									<select class="form-control select2 ledger input-sm" id="purpose_id" name="purpose_id" tabindex="-1" aria-hidden="true" required="on">
										<option value="">Select Purpose</option>
										<option value="1">Customer Sale</option>
										<option value="2">Expense</option>
										<option value="3">Purchase</option>
										<option value="4">Bank Transfer</option>
										<option value="5">Owner Transfer</option>
									</select>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label" style="display:none;" id="dist_label">Ledger</label>
								<div class="col-sm-2" style="display:none;" id="dist_list">
									<?php 
											echo form_dropdown('distributor_id', $distributor_info,'','style="width:100%;" class="form-control select2 ledger input-sm" id="distributor_id" tabindex="-1" aria-hidden="true"');
										?>
								</div>
								<label for="inputEmail3" style="display:none;" class="col-sm-1 control-label" id="cust_label">Ledger</label>
								<div class="col-sm-2" style="display:none;" id="cust_list">
									<?php 
											echo form_dropdown('customer_id', $customer_info,'','style="width:100%;" class="form-control select2 ledger input-sm" id="customer_id" tabindex="-1" aria-hidden="true"');
										?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label" style="display:none;" id="exp_type_label">Type</label>
								<div class="col-sm-2" style="display:none;" id="exp_type_list">
									<?php 
										echo form_dropdown('type_id', $expense_type,'','style="width:100%;" class="form-control select2 ledger input-sm" id="type_id" tabindex="-1" aria-hidden="true"');
									?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label" style="display:none;" id="emp_label">Employee</label>
								<div class="col-sm-2" style="display:none;" id="emp_list">
									<?php 
										echo form_dropdown('employee_id', $employee_info,'','style="width:100%;" class="form-control select2 ledger input-sm" id="employee_id" tabindex="-1" aria-hidden="true"');
									?>
								</div>
								
								<label for="inputEmail3" class="col-sm-1 control-label" style="display:none;" id="type_label">Type</label>
								<div class="col-sm-2" style="display:none;" id="type_list">
									<select style="width:100%;" class="form-control select2 input-sm" id="transfer_type" tabindex="-1" aria-hidden="true">
										<option value="">Select Type</option>
										<option value="to_bank">To Bank</option>
										<option value="from_bank">From Bank</option>
									</select>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label" style="display:none;" id="own_type_label">Type</label>
								<div class="col-sm-2" style="display:none;" id="own_type_list">
									<select style="width:100%;" class="form-control select2 input-sm" id="owner_transfer_type" tabindex="-1" aria-hidden="true">
										<option value="">Select Type</option>
										<option value="to_owner">To Owner</option>
										<option value="from_owner">From Owner</option>
									</select>
								</div>
							<!--/div>
							<div class="form-group"-->
								<label for="inputEmail3" class="col-sm-1 control-label">Date</label>
								<div class="col-sm-2" style="width: 10.666667%;">
									<?php 
										echo form_input('start_date', '','class ="form-control" id="start" placeholder="Start Date" autocomplete="off"');
									?>
								</div>
								<div class="col-sm-2" style="width: 10.666667%;">
									<?php 
										echo form_input('end_date', '','class ="form-control" id="end" placeholder="End Date" autocomplete="off"');
									?>
								</div>
								
							</div>
							<div class="form-group text-right">
								<div class="col-sm-12">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" id="form_submit"><i class="fa fa-fw fa-search"></i> Search</button>
									<a href="<?php echo base_url();?>account/all_ledger_report_print" id="down" style="display:none;" target="_blank" class="btn btn-primary btn-sm down"><i class="fa fa-download"></i> Print</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<div class="modal_loader preload" style="display: none">
		<div class="center">
			<img src="<?php echo base_url();?>assets/img/spin.gif" id="loaderIcon"/>
		</div>
	</div>

	<section class="content infomsg" id="infomsg" style="display:none;">
		<div class="row">
			<div class="col-md-12">
				<div class="box">	 
					<div class="box-body">
						<div class="box-header with-border" style="background: #2fa9a9;">
							<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"><span class="ledger_name" style="color: #394446;text-align:center;"></span></h3>
						</div>
						<div class="wrap">
							<table class="head">
								<tr>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Date</td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;width:25%;"><span class="table_head_name"></span></td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;width:20%;">Details</td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">Total Amount</td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">Paid Amount</td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">Balance</td>
								</tr>
							</table>
							<div class="inner_table">
							<table class="new_data_2 search_data" id="search_data"></table>
							
							</div>
							<table class="head">
								<tr>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;width:25%;"></td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;width:20%;"></td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;"></span></td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;"></span></td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"></span></td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</section>

</div>
