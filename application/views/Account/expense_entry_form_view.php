<?php $this -> load -> view('include/header'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<script src="<?php echo base_url();?>assets2/custom_script_2.js"></script>
<div class="content-wrapper">
	<?php
	$result = $this->uri->segment(3);
	if($result!=''){
		
		if($result=='success')
		{
			echo '<script>
					$(document).ready(function(){
						swal("Expense Successfully Listed", ":)", "success");
					});
			</script>';
		}
		else if($result=='failed')
		{
			echo '<script>
					$(document).ready(function(){
						swal("Something wrong with Expense", ":)", "info");
					}
			</script>';
		}
	}
	?>
	<section class="content" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
						<div class="box-header with-border" style="background: #0f77ab;">
							<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Expense Entry</h3>
						</div>
						<form action="<?php echo base_url();?>account_controller/create_expense" method="post" class="form-horizontal">
						<div class="box-body">	
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Expense Type</label>
								<div class="col-sm-4">
									<div class="input-group input-group-md">
										<?php 	
											echo form_dropdown('expense_type', $expense_type, '' ,'class="form-control select22 type_type" id="one" style="width: 100%;"tabindex="-1" aria-hidden="true" required="required"');
										?>
										<span class="input-group-btn">
											 <button type="button" style="margin-bottom: 6px;" class="btn btn-block btn-primary" data-toggle="modal" data-target="#show_expense_typ_modal"> <i class="fa fa-plus"></i></button>
										</span>
									</div>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label">Service Provider</label>
								<div class="col-sm-4">
									<div class="input-group input-group-md">
										<?php 	
											echo form_dropdown('service_provider_id', $service_provider_info, '' ,'class="form-control select22 service_provider_name" id="two" style="width: 100%;"tabindex="-1" aria-hidden="true" required="required"');
										?>
										<span class="input-group-btn">
											<button type="button" style="margin-bottom: 6px;" class="btn btn-block btn-primary" data-toggle="modal" data-target="#show_service_provider_modal"> <i class="fa fa-plus"></i></button>
										</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Employee</label>
								<div class="col-sm-10">
										<?php 	
											echo form_dropdown('employee_id', $employee_info, '' ,'class="form-control select22 type_type" id="one" style="width: 100%;"tabindex="-1" aria-hidden="true"');
										?>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Expense Amount</label>
								<div class="col-sm-4">
									<?php 	
										echo form_input('expense_amount','','class ="form-control"  placeholder="Expense Amount" id="seven" autocomplete="off"');
									?>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label">Paid Amount</label>
								<div class="col-sm-4">
									<?php 	
										echo form_input('total_paid','','class ="form-control"  placeholder="Paid Amount" id="seven2" autocomplete="off"');
									?>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Expense Details</label>
								<div class="col-sm-10">
									<?php 
											$expense_details_full = array(
												'name'	=> 'expense_details',
												'id'	=> 'expense_details',
												'class'	=> 'form-control',
												'rows'  => '2',
												'cols'  => '10',
												'value' => 'N/A',
												'maxlength'	=> 100
											);
										 echo form_textarea($expense_details_full, '', 'class="form-control" rows="4" placeholder="Expense Details"');
									?> 
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Payment Mode</label>
								<div class="col-sm-10">
									<select class="form-control select2" name="payment_mode" id="payment_mode" style="width:100%;">
										<option value="">Select Mode</option>
										<option value="1">Cash</option>
										<option value="2">Cheque</option>
										<option value="3">Card</option>
									</select>
								</div>
							</div>
							<div class="box-footer" style="background: #6c8490;padding: 6px;height: 48px;display:none;" id="result_cheque">
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-1 control-label" style="color:white;">My</label>
									<div class="col-sm-2">
										<?php 	
											echo form_dropdown('my_bank', $bank_info, '' ,'class="form-control select22" id="my_bank" style="width: 100%;" tabindex="-1" aria-hidden="true"');
										?>
									</div>
									<label for="inputEmail3" class="col-sm-1 control-label" style="color:white;">Bank</label>
									<div class="col-sm-2">
										<?php 	
											echo form_dropdown('to_bank', $bank_info, '' ,'class="form-control select22" id="to_bank" style="width: 100%;" tabindex="-1" aria-hidden="true"');
										?>
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
							<div class="form-group" style="display:none;" id="card_id_list">
								<label for="inputEmail3" class="col-sm-2 control-label">Card</label>
								<div class="col-sm-10">
									<select class="form-control select2" name="card_id" id="card_id" style="width:100%;"></select>
								</div>
							</div>
							<div class="box-footer" style="background: #0f77ab;">
								<center>
									<div class="col-sm-22">
										<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i> Create</button>
										<button type="reset" id="reset_btn" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-refresh"></i> Reset</button>
									</div>
								</center>
							</div>
						</div>
					</form>
				</div> 
			</div> 
		</div> 
	</section> 
	<div class="modal fade" id="show_expense_typ_modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Add New Expense Type</h4>
				</div>
				<form id="add_expense_form" action="<?php echo base_url(); ?>account_controller/create_type" method="post" autocomplete="off" enctype="multipart/form-data" role="form">
					<div class="modal-body">
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Expense Type</span>
							<input name="type_type" type="text" class="form-control type_name" placeholder="Expense Type" required="required" />
						</div>
						<div class="separator10"></div>
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Expense Details</span>
							<textarea name="expense_details" value="N/A" class="form-control" required="required" class="input-xlarge" id="textarea" rows="2">N/A</textarea>  
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Save Expense Type</button>
						<button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>
	
	<div class="modal fade" id="show_service_provider_modal" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-plus"></i> Add New Service Provider</h4>
				</div>
				<form id="add_service_provider_form" action="<?php echo base_url(); ?>registration_controller/create_service_provider" method="post" autocomplete="off" enctype="multipart/form-data" role="form">
					<div class="modal-body">
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Provider Name</span>
							<input name="service_provider_name" type="text" class="form-control service_provider" placeholder="Provider Name" required="required" />
						</div>
						<div class="separator10"></div>
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Provider Type</span>
							<input name="service_provider_type" type="text" class="form-control" placeholder="Provider Type"  />
						</div>
						<div class="separator10"></div>
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Provider Address</span>
							<input name="service_provider_address" placeholder="Provider Address"  type="text" class="form-control"  />
						</div>
						<div class="separator10"></div>
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Phone Number</span>
							<input name="service_provider_contact" placeholder="Phone Number" type="text" class="form-control"  />
						</div>
						<div class="separator10"></div>
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Email Address</span>
							<input name="service_provider_email" type="text" value="demo@gmail.com" class="form-control"  />
						</div>
						<div class="separator10"></div>
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Description</span>
							<textarea name="service_provider_description" class="form-control input-xlarge" id="textarea" rows="2" value="N/A" >N/A</textarea>  
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Save Provider</button>
						<button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>
	<script>
		$(document).ready(function() {
			$('#add_expense_form').on('submit', function(expe){
				expe.preventDefault();
				var submiturl = $(this).attr('action');
				var methods = $(this).attr('method');
				 $.ajax({
					url: submiturl,
					type: methods,
					data: $(this).serialize(),
					success:function(result){
						
						$('#show_expense_typ_modal').modal('hide');
						
						if(result == 'success'){
							alert('Data Successfully Saved.');
							select_new_entry('type_info','type_id','type_type','type_type','');
						}
						else if(result == 'exist'){
							alert('Data Already Exists.');
							select_new_entry('type_info','type_id','type_type','type_type','type_name');
						}
						else if(result == 'error'){
							alert('Data Not Successfully Saved.');
						}
					 },
					error: function (jXHR, textStatus, errorThrown) {html("")}
				});
				
			});
		});
		
		$(document).ready(function() {
			$('#add_service_provider_form').on('submit', function(service){
				service.preventDefault();
				var submiturl = $(this).attr('action');
				var methods = $(this).attr('method');
				 $.ajax({
					url: submiturl,
					type: methods,
					data: $(this).serialize(),
					success:function(result){
						$('#show_service_provider_modal').modal('hide');
						if(result == 'success'){
							alert('Data Successfully Saved.');
							select_new_entry_with_id('service_provider_info','service_provider_id','service_provider_name','service_provider_name','');
							//service_provider_info', 'service_provider_name
						}
						else if(result == 'exist'){
							alert('Data Already Exists.');
							select_new_entry_with_id('service_provider_info','service_provider_id','service_provider_name','service_provider_name','service_provider');
						}
						else if(result == 'error'){
							alert('Data Not Successfully Saved.');
						}
					 },
					error: function (jXHR, textStatus, errorThrown) {html("")}
				});
				
			});
		});
		$(document).ready(function() {
		$("#payment_mode").on("change",function()
			{
				var output = '';
				var outputs = '';
				var payment_mode_id = $(this).val();
				var receipt_type = $('#receipt_type').val();
				if(payment_mode_id==2) 
				{	
					$("#result_cheque").show(); 		
					$("#card_id_list").hide(); 		
				}
				else if(payment_mode_id==3) 
				{
					var outputs='';
					var urlx='<?php echo base_url();?>account_controller/get_all_card';			
					$.ajax
					({
						url: urlx,
						type: 'POST',
						dataType: 'json',
						data: {'payment_mode_id':payment_mode_id},
						success:function(result)
						{	
							outputs+='<option value="">Select Card</option>';
							for(var i=0; i<result.length; i++ )
							{
							  outputs+='<option value="'+result[i].card_id+'">'+result[i].card_name+'</option>';
							}
							$("#card_id_list").show(); 
							$("#card_id").html(outputs);
							$("#result_cheque").hide();
						},
						error: function (jXHR, textStatus, errorThrown) {}
					});
					
				}
				else if(payment_mode_id==1) 
				{

					$("#card_id_list").hide(); 
					$("#result_cheque").hide(); 							

				}
			});
		});
	</script>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$("#reset_btn").click(function(event) {
			event.preventDefault();
			$('#one').val('');
			$('#one').select2();
			$('#three').val('');
			$('#three').select2();
			$('#four').val('');
			$('#four').select2();
			$('#edValue').val('');
			$('#five').val('');
			$('#six').val('');
			$('#seven').val('');
			$('#seven2').val('');
			$('#eight').val('');
			$('#nine').val('');
			$('#expense_details').val('');
			//$('#one').val('');
		$('#two').val('');
		$('#two').select2();
		//$('#three').val('');
		//$('#four').val('');
		$('#lock').val('');
		$('#lock').select2();
		$('#lock3').val('');
		$('#lock3').select2();
		$('#lock4').val('');
		$('#lock4').select2();
		$('#lock5').val('');
		$('#lock5').select2();
		$('#lock55').val('');
		$('#lock55').select2();
		$('#lock66').val('');
		$('#lock6').val('');
		$('#lock6').select2();
		$('#lock').val('');
		$('#lock22').val('');
		$('#lock77').val('');
		$('#lock7').val('');
		$('#lock7').select2();
		$('#datepickerrr').val('');
		$('#datepickerr').val('');
		$('#lock2').val('');
		$('#datep').val('');
		$('#datep2').val('');
		$("#lock2").prop("disabled", false);
		$("#lock22").prop("disabled", false);
		$("#lock").prop("disabled", false);
		$("#lock3").prop("disabled", false);
		$("#lock4").prop("disabled", false);
		$("#lock5").prop("disabled", false);
		$("#lock55").prop("disabled", false);
		$("#lock6").prop("disabled", false);
		$("#lock66").prop("disabled", false);
		$("#lock7").prop("disabled", false);
		$("#lock77").prop("disabled", false);
		$("#datepickerrr").prop("disabled", false);
		$("#datepickerr").prop("disabled", false);	
		$("#datep").prop("disabled", false);	
		$("#datep2").prop("disabled", false);	
		});
	});
</script>
<?php $this -> load -> view('include/footer'); ?>
