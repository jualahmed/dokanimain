<?php $this -> load -> view('include/header'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<div class="content-wrapper">
<?php
	$result = $this->uri->segment(3);
	if($result!=''){
		
		if($result=='success'){
			echo '<script>
					$(document).ready(function(){
						swal("Transfer Successfully Done", "", "success");
					});
			</script>';
		}
		else if($result=='failed'){
			echo '<script>
					$(document).ready(function(){
						swal("Something wrong with Transfer", "", "info");
					}
			</script>';
		}
	}
	?>
<section class="content">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="box">
				<div class="box-header with-border" style="background: #0f77ab;">
					<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Owner Transfer</h3>
				</div>
				<form action="<?php echo base_url();?>account_controller/create_owner_transfer" method="post" class="form-horizontal">
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
								<?php 
									echo form_dropdown('bank_id', $bank_info,'','style="width:100%;" class="form-control select2 ledger input-sm" id="bank_id" tabindex="-1" aria-hidden="true"');
								?>
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
						
						<div class="box-footer" style="background: #0f77ab;">
							<center>
								<div class="col-sm-22">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i>Create Transfer</button>
								</div>
							</center>
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
				<form id="add_owner_form" action="<?php echo base_url(); ?>registration_controller/create_owner" method="post" autocomplete="off" enctype="multipart/form-data" role="form">
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
<script>
$(document).ready(function()
{
	$("#transfer_type").on("change",function()
	{
		var transfer_type = $(this).val();
		if(transfer_type == 2 || transfer_type == 1) 
		{
			$('.payment_div').show();
		} 
		else
		{
			$('.payment_div').hide();
		} 
	});	
	
	$("#payment_type").on("change",function()
	{
		var payment_type = $(this).val();
		if(payment_type == 2) 
		{
			$('.cheque_div').show();
		} 
		else
		{
			$('.cheque_div').hide();
		} 
	});	
	
});
$(document).ready(function() {
	$('#add_owner_form').on('submit', function(service){
		service.preventDefault();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		 $.ajax({
			url: submiturl,
			type: methods,
			data: $(this).serialize(),
			success:function(result){
				$('#show_owner_modal').modal('hide');
				if(result == 'success'){
					alert('Data Successfully Saved.');
					select_new_entry_with_id('owner_info','owner_id','owner_name','owner_name','');
					//service_provider_info', 'service_provider_name
				}
				else if(result == 'exist'){
					alert('Data Already Exists.');
					select_new_entry_with_id('owner_info','owner_id','owner_name','owner_name','owner_provider');
				}
				else if(result == 'error'){
					alert('Data Not Successfully Saved.');
				}
			 },
			error: function (jXHR, textStatus, errorThrown) {html("")}
		});
		
	});
});
</script>
</div>
<?php $this -> load -> view('include/footer'); ?>