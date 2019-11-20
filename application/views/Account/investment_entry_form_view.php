<?php $this -> load -> view('include/header'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<div class="content-wrapper">
	<?php
	$result = $this->uri->segment(3);
	if($result!=''){
		
		if($result=='success'){
			echo '<script>
					$(document).ready(function(){
						swal("Investment Successfully Listed", ":)", "success");
					});
			</script>';
		}
		else if($result=='failed'){
			echo '<script>
					$(document).ready(function(){
						swal("Something wrong with Investment", ":(", "info");
					}
			</script>';
		}
	}
	?>
	<section class="content" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="box box-info">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Investment Setup</h3>
					</div>
					<form action="<?php echo base_url();?>account/create_investment" method="post" class="form-horizontal">
						<div class="box-body">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Investor Name</label>
								<div class="col-sm-9">
									<div class="input-group input-group-md">
										<?php 	
											echo form_dropdown('investor_id', $investor_info, '' ,'class="form-control select22 investor_name" id="one" style="width: 100%;"tabindex="-1" aria-hidden="true" required="required"');
										?>
										<span class="input-group-btn">
											<button type="button" style="margin-bottom: 6px;" class="btn btn-block btn-primary" data-toggle="modal" data-target="#show_investor_modal"> <i class="fa fa-plus"></i></button>
										</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Investment Amount</label>
								<div class="col-sm-9">
									<?php 
										echo form_input('investment_amount','','class ="form-control"  placeholder="Investment Amount" id="seven" autocomplete="off"');
									?>	
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Investment Details</label>
								<div class="col-sm-9">
									<?php 
											$investment_details_full = array(
												'name'	=> 'investment_details',
												'id'	=> 'investment_details',
												'class'	=> 'form-control',
												'rows'  => '2',
												'cols'  => '10',
												'maxlength'	=> 1000
											);
										 echo form_textarea($investment_details_full, '', 'class="form-control" rows="4" placeholder="Investment Details"');
									?>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Payment Mode</label>
								<div class="col-sm-9">
									<select class="form-control select2" name="payment_mode" id="payment_mode" style="width:100%;" required>
										<option value="">Select Mode</option>
										<option value="1">Cash</option>
										<option value="2">Cheque</option>
									</select>
								</div>
							</div>
							<div class="form-group" id="result_cheque" style="display:none;">
								<label for="inputEmail3" class="col-sm-3 control-label">My Bank</label>
								<div class="col-sm-3">
									<select class="form-control select2" name="my_bank" style="width:100%;" id="my_bank">
										<option value="">Select Bank</option>
										<?php 
											foreach($all_bank ->result() as $field)
											{
											
										?>
										<option value="<?php echo $field->bank_id;?>"><?php echo $field->bank_name;?></option>
										<?php
											}
										?>
									</select>
								</div>
								<label for="inputEmail3" class="col-sm-3 control-label">To Bank</label>
								<div class="col-sm-3">
									<select class="form-control select2" name="to_bank" style="width:100%;" id="to_bank">
										<option value="">Select Bank</option>
										<?php 
											foreach($all_bank ->result() as $field)
											{
											
										?>
										<option value="<?php echo $field->bank_id;?>"><?php echo $field->bank_name;?></option>
										<?php
											}
										?>
									</select>
								</div>
							</div>
							<div class="form-group" id="result_cheque2" style="display:none;">
								<label for="inputEmail3" class="col-sm-3 control-label">Cheque No</label>
								<div class="col-sm-3">
									<input type="text" name="cheque_no" class="form-control" id="cheque_no_id" placeholder="Cheque No" title="Cheque No" autocomplete="off"></td>
								</div>
								<label for="inputEmail3" class="col-sm-3 control-label">Cheque Date</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" name="cheque_date" id="datep" placeholder="Cheque Date" title="Cheque Date" autocomplete="off">
								</div>
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
					</form>
				</div> 
			</div> 
		</div> 
	</section> 
<div class="modal fade" id="show_investor_modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-plus"></i> Add New Investor</h4>
			</div>
			<form id="add_investor_form" action="<?php echo base_url(); ?>Registration/create_investor" method="post" autocomplete="off" enctype="multipart/form-data" role="form">
				<div class="modal-body">
					<div class="input-group input-group-sm">
						<span class="input-group-addon">Investor Name</span>
						<input name="investor_name" type="text" class="form-control investor_name" placeholder="Investor Name" required="required" />
					</div>
					<div class="separator10"></div>
					<div class="input-group input-group-sm">
						<span class="input-group-addon">Phone Number</span>
						<input name="investor_contact_no" type="text" class="form-control bank_account_no" placeholder="Phone Number" required="required" />
					</div>
					<div class="separator10"></div>
					<div class="input-group input-group-sm">
						<span class="input-group-addon">Email Address</span>
						<input name="investor_email" type="text" class="form-control" placeholder="Email Address" required="required" />
					</div>
					<div class="separator10"></div>
					<div class="input-group input-group-sm">
						<span class="input-group-addon">Investor Address</span>
						<textarea name="investor_address" value="N/A" class="form-control" required="required" class="input-xlarge" id="textarea" rows="2">N/A</textarea>  
					</div>
					<div class="separator10"></div>
					<div class="input-group input-group-sm">
						<span class="input-group-addon">Description</span>
						<textarea name="investor_description" value="N/A" class="form-control" required="required" class="input-xlarge" id="textarea" rows="2">N/A</textarea>  
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Save Investor</button>
					<button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<script>
		$(document).ready(function() {
			$('#add_investor_form').on('submit', function(expe){
				expe.preventDefault();
				var submiturl = $(this).attr('action');
				var methods = $(this).attr('method');
				 $.ajax({
					url: submiturl,
					type: methods,
					data: $(this).serialize(),
					success:function(result){
						
						$('#show_investor_modal').modal('hide');
						
						if(result == 'success'){
							alert('Data Successfully Saved.');
							select_new_entry_with_id('investor_info','investor_id','investor_name','investor_name','');
							//service_provider_info', 'service_provider_name
							$(".select22").select2();
						}
						else if(result == 'exist'){
							alert('Data Already Exists.');
							select_new_entry_with_id('investor_info','investor_id','investor_name','investor_name','investor_name');
							//service_provider_info', 'service_provider_name
							$(".select22").select2();
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
<script>
	$(document).ready(function() {
		$("#payment_mode").on("change",function()
			{
				var payment_mode_id = $(this).val();
				if(payment_mode_id==2) 
				{	
					$("#result_cheque").show(); 			
					$("#result_cheque2").show(); 			
				}
				else 
				{
					$("#result_cheque").hide(); 							
					$("#result_cheque2").hide(); 							

				}
			});
		});
</script> 

</div>
<?php $this -> load -> view('include/footer'); ?>