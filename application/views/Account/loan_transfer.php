<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Loan Transfer</h3>
					</div>
					<form action="<?php echo base_url();?>account/create_loan_transfer" method="post" class="form-horizontal">
						<div class="box-body">	
							<div class="form-group">
								<label class="col-sm-3 control-label">Transfer Type</label>
								<div class="col-sm-7">
									<select class="form-control select22" id="transfer_type" style="width: 100%;"tabindex="-1" aria-hidden="true" name="transfer_type" required="on">
										<option value="">Select Type</option>
										<option value="1">Loan Receive</option>
										<option value="2">Loan Payment</option>
									</select>
								</div>
							</div>
							<br>
							<div class="form-group">
								<label class="col-sm-3 control-label">Person Name</label>
								<div class="col-sm-7">
									<div class="input-group input-group-md">
										<select class="form-control select22" tabindex="-1" aria-hidden="true" name="lp_id" required="on">
											<option value="">Select Type</option>
											<?php foreach ($loan_person_info as $key => $value): ?>
												<option value="<?php echo $value->customer_id ?>"><?php echo $value->customer_name ?></option>
											<?php endforeach ?>
										</select>
									</div>
								</div>
							</div>
							<br>
							<div class="form-group">
								<label class="col-sm-3 control-label">Amount</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" name="amount">
								</div>
							</div>
							<div class="box-footer text-right">
								<div class="col-sm-22">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i>Create Transfer</button>
								</div>
							</div>
						</div> 
					</form>
				</div> 
			</div> 
		</div> 
	</section> 
</div>
