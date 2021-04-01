<div class="content-wrapper">
	<style>
		.select2-container {
			width: 100% !important;
		}
	</style>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Ledger</h3>
					</div>
					<div class="box-body">
						<input type="hidden" id="action">
						<form class="form-horizontal" id="form_2" method="post" action="<?php echo base_url(); ?>account/all_ledger_report_find">
							<div class="row">
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-1 control-label">Purpose</label>
									<div class="col-sm-2">
										<select class="form-control select2 ledger input-sm" id="purpose_id" name="purpose_id" tabindex="-1" aria-hidden="true">
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
										<select class="form-control" name="distributor_id" id="distributor_id">
											<option value="">Select a distributor</option>
											<?php foreach ($distributor_info as $key => $var) : ?>
												<option value=" <?php echo $var->distributor_id ?> "><?php echo $var->distributor_name ?></option>
											<?php endforeach ?>
										</select>
									</div>

									<label for="inputEmail3" style="display:none;" class="col-sm-1 control-label" id="cust_label">Ledger</label>
									<div class="col-sm-2" style="display:none;" id="cust_list">
										<select class="form-control" name="customer_id" id="customer_id">
											<option value="">Select a Customer</option>
											<?php foreach ($customer as $key => $var) : ?>
												<option value=" <?php echo $var->customer_id ?> "><?php echo $var->customer_name ?></option>
											<?php endforeach ?>
										</select>
									</div>

									<label for="inputEmail3" class="col-sm-1 control-label" style="display:none;" id="exp_type_label">Type</label>
									<div class="col-sm-2" style="display:none;" id="exp_type_list">
										<select class="form-control select2" name="type_id" id="type_id">
											<option value="">Select Expense Type</option>
											<?php foreach ($expense_type as $key => $var) : ?>
												<option value="<?php echo $var->type_id ?>"><?php echo $var->type_name ?></option>
											<?php endforeach ?>
										</select>
									</div>


									<label for="inputEmail3" class="col-sm-1 control-label" style="display:none;" id="type_label">Type</label>
									<div class="col-sm-2" style="display:none;" id="type_list">
										<select style="width:100%;" class="form-control select2 input-sm" name="transfer_type" id="transfer_type" tabindex="-1" aria-hidden="true">
											<option value="">Select Type</option>
											<option value="to_bank">To Bank</option>
											<option value="from_bank">From Bank</option>
										</select>
									</div>
									<label for="inputEmail3" class="col-sm-1 control-label" style="display:none;" id="own_type_label">Type</label>
									<div class="col-sm-2" style="display:none;" id="own_type_list">
										<select style="width:100%;" class="form-control select2 input-sm" name="owner_transfer_type" id="owner_transfer_type" tabindex="-1" aria-hidden="true">
											<option value="">Select Type</option>
											<option value="to_owner">To Owner</option>
											<option value="from_owner">From Owner</option>
										</select>
									</div>
									<!--/div>
							<div class="form-group"-->
									<label for="inputEmail3" class="col-sm-1 control-label">Date</label>
									<div class="col-sm-2">
										<?php
										echo form_input('start_date', '', 'class ="form-control" id="start" placeholder="Start Date" autocomplete="off"');
										?>
									</div>
									<div class="col-sm-2">
										<?php
										echo form_input('end_date', '', 'class ="form-control" id="end" placeholder="End Date" autocomplete="off"');
										?>
									</div>
									<div class="col-sm-1">
										<button type="submit" class="btn btn-success" name="search_random" id="form_submit"><i class="fa fa-fw fa-search"></i></button>
										<a href="<?php echo base_url(); ?>account/all_ledger_report_print" id="down" style="display:none;" target="_blank" class="btn btn-primary btn-sm down"><i class="fa fa-download"></i> Print</a>
									</div>
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
			<img src="<?php echo base_url(); ?>assets/img/LoaderIcon.gif" id="loaderIcon" />
		</div>
	</div>
	<?php $camount = 0;
	$damount = 0; ?>
	<section class="content infomsg" id="infomsg">
		<div class="row">
			<?php if (isset($ledgerdata)) { ?>
				<div class="col-md-12">
					<div class="box">
						<div class="box-body">
							<div class="box-header with-border">
								<h3 class="box-title">Total
									<?php

									if (isset($purpose_id)) {
										if ($purpose_id == '1') echo 'Customer Sale';
										if ($purpose_id == '2') echo 'Expense';
										if ($purpose_id == '3') echo 'Purchase';
										if ($purpose_id == '4') echo 'Bank Transfer';
										if ($purpose_id == '5') echo 'Owner Transfer';
									}

									?>
								</h3>
							</div>
							<div class="wrap">
								<table class="table">
									<tr>
										<th>SL.</th>
										<th>Date</th>
										<th>Remarks</th>
										<th style="text-align:right">In</th>
										<th style="text-align:right">Out</th>
										<th style="text-align:right">Balance</th>
									</tr>
									<?php $camount = 0;
									foreach ($ledgerdata as $key => $var) : ?>
										<tr>
											<td><?php echo $key + 1 ?></td>
											<td><?php echo $var->date ?></td>
											<td><?php echo $var->remarks ?></td>
											<td align="right"><?php

																if (
																	$var->transaction_purpose == 'sale' ||
																	// $var->transaction_purpose == 'sale_return' ||
																	$var->transaction_purpose == 'collection' ||
																	$var->transaction_purpose == 'credit_collection' ||
																	$var->transaction_purpose == 'purchase' ||
																	$var->transaction_purpose == 'purchase' ||
																	$var->transaction_purpose == 'from_owner' ||
																	$var->transaction_purpose == 'from_bank'
																) {
																	echo sprintf('%0.2f', $var->amount);
																	$camount += $var->amount;
																} ?></td>
											<td align="right"><?php
																if (
																	$var->transaction_purpose == 'payment' ||
																	$var->transaction_purpose == 'sale_return' ||
																	$var->transaction_purpose == 'to_bank' ||
																	$var->transaction_purpose == 'to_owner' ||
																	$var->transaction_purpose == 'expense_payment'
																) {
																	echo sprintf('%0.2f', $var->amount);
																	$damount += $var->amount;
																} ?></td>
											<td align="right"><?php echo sprintf('%0.2f', $camount - $damount) ?></td>
										</tr>
									<?php endforeach ?>

									<tr>
										<th colspan="3">Total</th>
										<td align="right"><?php echo sprintf('%0.2f', $camount) ?></td>
										<td align="right"><?php echo sprintf('%0.2f', $damount) ?></td>
										<td align="right"><?php echo sprintf('%0.2f', $camount - $damount) ?></td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
		<h2 class="text-center">Total Due: <?php echo $camount - $damount ?> BDT</h2>
	</section>

</div>