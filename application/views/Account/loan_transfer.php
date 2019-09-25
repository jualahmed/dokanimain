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
										<?php 
											echo form_dropdown('lp_id', $loan_person_info,'','style="width:100%;" class="form-control select2 ledger input-sm loan_person_name" id="lp_id" tabindex="-1" aria-hidden="true"');
										?>
										<span class="input-group-btn">
											<button type="button" style="margin-bottom: 6px;" class="btn btn-block btn-primary" data-toggle="modal" data-target="#show_loan_person_modal"> <i class="fa fa-plus"></i></button>
										</span>
									</div>
								</div>
							</div>
							
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
	<div class="modal fade" id="show_loan_person_modal" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Add New Loan Person</h4>
					</div>
					<form id="add_loan_person_form" action="<?php echo base_url(); ?>Registration/create_loan_person" method="post" autocomplete="off" enctype="multipart/form-data" role="form">
						<div class="modal-body">
							<div class="input-group input-group-sm">
								<span class="input-group-addon">Loan Person Name</span>
								<input name="loan_person_name" type="text" class="form-control owner_provider" placeholder="Name" required="required" />
							</div>
							<div class="separator10"></div>
							<div class="input-group input-group-sm">
								<span class="input-group-addon">Loan Person Type</span>
								<input name="loan_person_type" type="text" class="form-control" placeholder="Type"  />
							</div>
							<div class="separator10"></div>
							<div class="input-group input-group-sm">
								<span class="input-group-addon">Address</span>
								<input name="loan_person_address" placeholder="Address"  type="text" class="form-control"  />
							</div>
							<div class="separator10"></div>
							<div class="input-group input-group-sm">
								<span class="input-group-addon">Phone Number</span>
								<input name="loan_person_contact" placeholder="Phone Number" type="text" class="form-control"  />
							</div>
							<div class="separator10"></div>
							<div class="input-group input-group-sm">
								<span class="input-group-addon">Email Address</span>
								<input name="loan_person_email" type="text" value="demo@gmail.com" class="form-control"  />
							</div>
							<div class="separator10"></div>
							<div class="input-group input-group-sm">
								<span class="input-group-addon">Description</span>
								<textarea name="loan_person_description" class="form-control input-xlarge" id="textarea" rows="2" value="N/A" >N/A</textarea>  
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Save Loan Person</button>
							<button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
	</div>
</div>
