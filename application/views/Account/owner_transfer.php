
<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Owner Transfer</h3>
					</div>
					<form action="<?php echo base_url();?>account/create_owner_transfer" method="post" class="form-horizontal">
						<div class="box-body">	
							<div class="form-group">
								<label class="col-sm-3 control-label">Transfer Type</label>
								<div class="col-sm-7">
									<select class="form-control select22" id="transfer_type" style="width: 100%;"tabindex="-1" aria-hidden="true" name="transfer_type" required="on">
										<option value="">Select Type</option>
										<option value="1">To Owner</option>
										<option value="2">From Owner</option>
									</select>
								</div>
							</div>
							<br>
							<div class="form-group">
								<label class="col-sm-3 control-label">Owner Name</label>
								<div class="col-sm-7">
									<div class="input-group input-group-md">
										<?php 
											echo form_dropdown('owner_id', $owner_info,'','style="width:100%;" class="form-control select2 ledger input-sm owner_name" id="owner_id" tabindex="-1" aria-hidden="true"');
										?>
										<span class="input-group-btn">
											<button type="button" style="margin-bottom: 6px;" class="btn btn-block btn-primary" data-toggle="modal" data-target="#show_owner_modal"> <i class="fa fa-plus"></i></button>
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
							<br>
							<div class="form-group payment_div" style="display:none;">
								<label class="col-sm-3 control-label">Payment Type</label>
								<div class="col-sm-7">
									<select class="form-control select22" id="payment_type" style="width: 100%;"tabindex="-1" aria-hidden="true" name="payment_type">
										<option value="">Payment Type</option>
										<option value="1">Cash</option>
										<option value="2">Cheque</option>
									</select>
								</div>
							</div>
							<div class="form-group cheque_div" style="display:none;">
								<label class="col-sm-3 control-label">Bank Name</label>
								<div class="col-sm-7">
									<select name="bank_id" id="bank_id" class="form-control">
										<option value="">Select bank</option>
										<?php foreach ($bank_info as $var): ?>
											<option value="<?php echo $var->bank_id ?>"><?php echo $var->bank_name ?></option>
										<?php endforeach ?>
									</select>
								</div>
							</div>
							<div class="form-group cheque_div" style="display:none;">
								<label class="col-sm-3 control-label">Cheque No</label>
								<div class="col-sm-7">
									<input type="text" class="form-control" name="cheque_no">
								</div>
							</div>
							<div class="form-group cheque_div" style="display:none;">
								<label class="col-sm-3 control-label">Cheque Date</label>
								<div class="col-sm-7">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "cheque_date",'class' => "form-control",'id' => "datepickerrr",'value' => $bd_date, 'tabindex' => 3, 'title' => "Start Date" ));?>
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
	<div class="modal fade" id="show_owner_modal" >
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Add New Owner</h4>
					</div>
					<form id="add_owner_form" action="<?php echo base_url(); ?>Registration/create_owner" method="post" autocomplete="off" enctype="multipart/form-data" role="form">
						<div class="modal-body">
							<div class="input-group input-group-sm">
								<span class="input-group-addon">Owner Name</span>
								<input name="owner_name" type="text" class="form-control owner_provider" placeholder="Owner Name" required="required" />
							</div>
							<div class="separator10"></div>
							<div class="input-group input-group-sm">
								<span class="input-group-addon">Owner Type</span>
								<input name="owner_type" type="text" class="form-control" placeholder="Owner Type"  />
							</div>
							<div class="separator10"></div>
							<div class="input-group input-group-sm">
								<span class="input-group-addon">Address</span>
								<input name="owner_address" placeholder="Owner Address"  type="text" class="form-control"  />
							</div>
							<div class="separator10"></div>
							<div class="input-group input-group-sm">
								<span class="input-group-addon">Phone Number</span>
								<input name="owner_contact" placeholder="Phone Number" type="text" class="form-control"  />
							</div>
							<div class="separator10"></div>
							<div class="input-group input-group-sm">
								<span class="input-group-addon">Email Address</span>
								<input name="owner_email" type="text" value="demo@gmail.com" class="form-control"  />
							</div>
							<div class="separator10"></div>
							<div class="input-group input-group-sm">
								<span class="input-group-addon">Description</span>
								<textarea name="owner_description" class="form-control input-xlarge" id="textarea" rows="2" value="N/A" >N/A</textarea>  
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Save Owner</button>
							<button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
	</div>
</div>
