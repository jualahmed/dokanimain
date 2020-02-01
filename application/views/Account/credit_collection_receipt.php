<div class="content-wrapper">
	<br>
	<section class="content">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Receipt Entry</h3>
					</div>
					<form class="form-horizontal">
						<div class="box-body">	
							<div class="form-group">
								<div class="col-sm-4">
									<div class="input-group">
										<span class="input-group-addon">Receipt Type</span>
										<select class="form-control select22 catagory_name" id="receipt_type" style="width: 100%;"tabindex="-1" aria-hidden="true" required="required">
											<option value="3" selected>Credit Collection Receipt</option>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="input-group">
										<span class="input-group-addon">Payment By</span>
										<select class="form-control select2" name="payment_mode" id="payment_mode" style="width:100%;">
											<option value="">Select Mode</option>
											<option value="1">Cash</option>
											<option value="2">Cheque</option>
											<option value="3">Card</option>
										</select>
									</div>
								</div>
								<div class="col-sm-4" style="display:none;" id="customer_list">
									<div class="input-group">
										<input type="hidden" id="balance_amount_customer">
										<span class="input-group-addon">Customer</span>
										<select class="form-control select2" name="customer_id" id="customer_id" style="width:100%;">
										</select>
									</div>
								</div>
								<div class="col-sm-4" style="display:none;" id="distributor_list">
									<div class="input-group">
										<input type="hidden" id="balance_amount_distributor">
										<span class="input-group-addon">Distributor</span>
										<select class="form-control select2" name="distributor_id" id="distributor_id" style="width:100%;">
										</select>
									</div>
								</div>
								<div class="col-sm-4" style="display:none;" id="service_provider_list">
									<div class="input-group">
										<span class="input-group-addon">Provider</span>
										<select class="form-control select2" name="service_provider_id" id="service_provider_id" style="width:100%;">
										</select>
									</div>
								</div>
							</div>
							<div class="box-footer" style="background: #0f77ab;display:none;" id="card_id_list">
								<div class="col-sm-4">
									<div class="input-group">
										<span class="input-group-addon">Card</span>
										<select class="form-control select2" name="card_id" id="card_id" style="width:100%;">
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
									<label for="inputEmail3" class="col-sm-1 control-label" style="color:white;">My</label>
									<div class="col-sm-2">
										<select name="my_bank" id="my_bank" class="form-control">
											<option value="">Select a bank</option>
											<?php foreach ($bank_info as $key => $value) { ?>
												<option value="<?php echo $value->bank_id ?>"><?php echo $value->bank_account_name ?></option>
											<?php } ?>
										</select>
									</div>
									<label for="inputEmail3" class="col-sm-1 control-label" style="color:white;">Bank</label>
									<div class="col-sm-2">
										<select name="to_bank" id="to_bank" class="form-control">
											<option value="">Select a bank</option>
											<?php foreach ($bank_info as $key => $value) { ?>
												<option value="<?php echo $value->bank_id ?>"><?php echo $value->bank_account_name ?></option>
											<?php } ?>
										</select>
									</div>
									<label for="inputEmail3" class="col-sm-1 control-label" style="color:white;">Cheque</label>
									<div class="col-sm-2">
										<input type="text" name="cheque_no" class="form-control" id="cheque_no_id" placeholder="Cheque No" title="Cheque No" autocomplete="off">
									</div>
									<label for="inputEmail3" class="col-sm-1 control-label" style="color:white;">Date</label>
									<div class="col-sm-2">
										<input type="text" class="form-control" name="cheque_date" id="datasep" placeholder="Cheque Date" title="Cheque Date">
									</div>
								</div>
						</div> 
					</form>
				</div> 
			</div> 
		</div> 
	</section>

	<section class="content collection_payment" style="display:none;min-height:0px;">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;text-align:center;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"><span class="panel_name"></span></h3>
					</div>
					<div class="box-body">
						<div class="form-horizontal">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label"><span class="global_name_label"></span></label>
								<div class="col-sm-4">
									<input type="text" class="form-control global_name_input" readonly>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label"><span class="global_contact_label"></span></label>
								<div class="col-sm-4">
									<input type="text" class="form-control global_contact_input" readonly>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label"><span class="global_address_label"></span></label>
								<div class="col-sm-10">
									<input type="text" id="customer_address" class="form-control global_address_input" readonly>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Remarks</label>
								<div class="col-sm-10">
									<input type="text" class="form-control remarks">
								</div>
							</div>
						</div>
						<form action="<?php echo base_url();?>account/do_collection_payment" class="form-horizontal" method="post" enctype="multipart/form-data">					
							<div class="wrap">
								<table class="table">
									<tr>
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;">Total Amount</td>
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;">Delivery Charge</td>
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;" id="cheque_return" style="display:none;">Cheque Return</td>
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;" id="expense_cheque_return" style="display:none;">Expense Return</td>
										
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;">Paid Amount</td>
										
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;" id="cashreturn" style="display:none;">Cash Return</td>
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;" id="return" style="display:none;">Sale Return</td>
										
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;">Due Amount</td>
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;">Payment</td>
									</tr>
								</table>
								<div class="inner_table">
									<table class="table" id="search_data">
										<tr>
											<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;"><input type="text" class="form-control total_amount" id="total_amount" style="text-align:right;" readonly></td>
											<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;"><input type="text" id="delivery_amount" class="form-control delivery_amount" style="text-align:right;" readonly></td>
											<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;display:none;" id="cheque_return_amount2"><input type="text" id="cheque_return_amount" class="form-control" style="text-align:right;" readonly></td>
											<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;display:none;" id="expense_cheque_return_amount2"><input type="text" id="expense_cheque_return_amount" class="form-control" style="text-align:right;" readonly></td>
											<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;"><input type="text" id="paid_amount" class="form-control paid_amount" style="text-align:right;" readonly></td>
											
											<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;display:none;" id="cash_return_amount2"><input type="text" id="cash_return_amount" class="form-control" style="text-align:right;" readonly></td>
											<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;display:none;" id="return_amount2"><input type="text" id="return_amount" class="form-control" style="text-align:right;" readonly></td>
											
											<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;"><input type="text" id="due_amount" class="form-control due_amount" style="text-align:right;" readonly></td>
											<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;"><span class="payment_input_result"><input type="text" name="payment_input" class="form-control payment_input" style="text-align:right;" autofocus="on"></span></td>
										</tr>
									</table>
								</div>
							</div>
							<div class="box-footer" style="background: #0f77ab;">
								<center>
									<div class="col-sm-22">
										<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i><span class="button_name"></span></button>
									</div>
								</center>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>	
	</section> 
</div>