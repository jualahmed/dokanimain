<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Transaction Modify</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>modify/get_transaction_modify" class="form-horizontal" autocomplete="off" method="post" enctype="multipart/form-data" id="form_4">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Purpose</label>
								<div class="col-sm-3">
									<select class="form-control select2 ledger input-sm" id="purpose_id" name="purpose_id" tabindex="-1" aria-hidden="true" required="on">
										<option value="">Select Purpose</option>
										<option value="1">Customer Credit Collection</option>
										<option value="2">Expense Payment</option>
										<option value="3">Purchase Payment</option>
										<option value="4">Bank Transfer Payment</option>
										<option value="5">Owner Transfer Payment</option>
									</select>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Start</label>
								<div class="col-sm-2">
									<input type="text" name="start_date" class="form-control" id="datepickerrr" placeholder="Star Date" tabindex="3" title="Start Date">
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">End</label>
								<div class="col-sm-2">
									<input type="text" name="end_date" class="form-control" id="datepickerr" placeholder="End Date" title="End Date">
								</div>
								<div class="col-sm-2 mt-2">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
								</div>
							</div>
						</form>	
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="modal1234" style="display: none">
		<div class="center">
			<img src="<?php echo base_url();?>assets/assets2/spin.gif" id="loaderIcon2"/>
		</div>
	</div>
	<section class="content" id="infomsg" style="display:none;">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-body">
						<div class="input-group input-group-md">
							<span class="input-group-addon">Transaction</span>
							<input type="text" class="form-control" id="search_member" placeholder="Search for Transaction.." title="Type in a name">
						</div>
						<div class="wrap">
							<table class="table">
								<tr>
									<td style="text-align:center;">No</td> 
									<td style="text-align:center;">Transaction</td>
									<td style="text-align:center;">Purpose</td>
									<td style="text-align:center;">Ledger Name</td>
									<td style="text-align:right;">Amount</td>
									<td style="text-align:center;">Date</td>
									<td style="text-align:center;">Action</td>
								</tr>
							</table>
							<div class="inner_table new_data_2" id="search_data"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
