<div class="content-wrapper" id="vuejsapp">
	<br>
	<section class="text-right">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
					<div class="box-header with-border text-left">
						<h3 class="box-title">All Transactions</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>account/all_today_transaction" method="post" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" id="form_6">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Start</label>
								<div class="col-sm-3">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "start_date",'class' => "form-control",'id' => "datepickerrr",'value' => $bd_date, 'tabindex' => 3, 'title' => "Start Date" ));?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">End</label>
								<div class="col-sm-3">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "end_date",'class' => "form-control",'id' => "datepickerr", 'value' => $bd_date, 'tabindex' => 3, 'title' => "End Date" ));?>
								</div>
								<div class="col-sm-4">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
									<a href="<?php echo base_url();?>account/download_todays_transaction" id="down" style="display:none;width:100px;" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Download</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="modal" style="display: none;position: absolute;top: 25%;left: 50%; width: 127px; height: 100px;">
		<div class="center">
			<img src="<?php echo base_url();?>assets/img/LoaderIcon.gif" id="loaderIcon"/>
		</div>
	</div>
	<input type="hidden" id="start">
	<input type="hidden" id="end">
	<section class="content-3" id="infomsg" style="display:none;">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">	 
					<div class="box-body">
						<table class="head">
							<tr>
								<td style="width:4%;">Cash In Hand</td>
								<td style="width:4%;text-align:right"><span id="cash_in_hand"></td>
								<td style="width:4%;">Cash In Bank</td>
								<td style="width:4%;text-align:right"><span id="cash_in_bank"></td>
							</tr>
						</table>
						<br>
						<div class="wrap">
							<div class="box-header with-border" style="background: #0f77ab;"><center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Sale</h3></center></div>
							<table class="head">
								<tr>
								  <td style="width:4%;">SL No</td>
								  <td style="width:4%;">Date</td>
								  <td style="width:4%;">Ledger Name</td>
								  <td style="width:4%;">Particular</td>
								  <td style="width:4%;">Remarks</td>
								  <td style="width: 4%;text-align:right;">Amount</td>
								</tr>
								
							</table>
							<div class="inner_table">
								<table id="output_sale">
								</table>
							</div>
							<table class="head" id="output_sale_sum">
							</table>
						</div>
						<div class="wrap">
							<div class="box-header with-border" style="background: #0f77ab;"><center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Collection</h3></center></div>
							<table class="head">
								<tr>
								  <td style="width:4%;">SL No</td>
								  <td style="width:4%;">Date</td>
								  <td style="width:4%;">Ledger Name</td>
								  <td style="width:4%;">Particular</td>
								  <td style="width:4%;">Remarks</td>
								  <td style="width: 4%;text-align:right;">Amount</td>
								</tr>
								
							</table>
							<div class="inner_table">
								<table id="output_collection">
								</table>
							</div>
							<table class="head" id="output_collection_sum">
							</table>
						</div>
						<div class="wrap">
							<div class="box-header with-border" style="background: #0f77ab;"><center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Credit Collection</h3></center></div>
							<table class="head">
								<tr>
								  <td style="width:4%;">SL No</td>
								  <td style="width:4%;">Date</td>
								  <td style="width:4%;">Ledger Name</td>
								  <td style="width:4%;">Particular</td>
								  <td style="width:4%;">Remarks</td>
								  <td style="width: 4%;text-align:right;">Amount</td>
								</tr>
								
							</table>
							<div class="inner_table">
								<table id="output_credit_collection">
								</table>
							</div>
							<table class="head" id="output_credit_collection_sum">
							</table>
						</div>
						<div class="wrap">
							<div class="box-header with-border" style="background: #0f77ab;"><center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Purchase</h3></center></div>
							<table class="head">
								<tr>
								  <td style="width:4%;">SL No</td>
								  <td style="width:4%;">Date</td>
								  <td style="width:4%;">Ledger Name</td>
								  <td style="width:4%;">Particular</td>
								  <td style="width:4%;">Remarks</td>
								  <td style="width: 4%;text-align:right;">Amount</td>
								</tr>
								
							</table>
							<div class="inner_table">
								<table id="output_purchase">
								</table>
							</div>
							<table class="head" id="output_purchase_sum">
							</table>
						</div>
						<div class="wrap">
							<div class="box-header with-border" style="background: #0f77ab;"><center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Purchase Payment</h3></center></div>
							<table class="head">
								<tr>
								  <td style="width:4%;">SL No</td>
								  <td style="width:4%;">Date</td>
								  <td style="width:4%;">Ledger Name</td>
								  <td style="width:4%;">Particular</td>
								  <td style="width:4%;">Remarks</td>
								  <td style="width: 4%;text-align:right;">Amount</td>
								</tr>
								
							</table>
							<div class="inner_table">
								<table id="output_purchase_payment">
								</table>
							</div>
							<table class="head" id="output_purchase_payment_sum">
							</table>
						</div>
						<div class="wrap">
							<div class="box-header with-border" style="background: #0f77ab;"><center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Expense</h3></center></div>
							<table class="head">
								<tr>
								  <td style="width:4%;">SL No</td>
								  <td style="width:4%;">Date</td>
								  <td style="width:4%;">Ledger Name</td>
								  <td style="width:4%;">Particular</td>
								  <td style="width:4%;">Remarks</td>
								  <td style="width: 4%;text-align:right;">Amount</td>
								</tr>
								
							</table>
							<div class="inner_table">
								<table id="output_expense">
								</table>
							</div>
							<table class="head" id="output_expense_sum">
							</table>
						</div>
						<div class="wrap">
							<div class="box-header with-border" style="background: #0f77ab;"><center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Expense Payment</h3></center></div>
							<table class="head">
								<tr>
								  <td style="width:4%;">SL No</td>
								  <td style="width:4%;">Date</td>
								  <td style="width:4%;">Ledger Name</td>
								  <td style="width:4%;">Particular</td>
								  <td style="width:4%;">Remarks</td>
								  <td style="width: 4%;text-align:right;">Amount</td>
								</tr>
								
							</table>
							<div class="inner_table">
								<table id="output_expense_payment">
								</table>
							</div>
							<table class="head" id="output_expense_payment_sum">
							</table>
						</div>
						
					</div>
					
				</div>
			</div>
		</div>	
	</section>
</div>