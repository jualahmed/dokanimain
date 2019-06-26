<<<<<<< HEAD
<?php $this -> load -> view('include/header'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<script src="<?php echo base_url();?>assets/assets2/custom_script_2.js"></script>
<div class="content-wrapper">
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
		<?php 
			if($status != '' )
			{
				if($status == "exists")
				 {
					 echo '<div class="alert alert-warning alert-dismissible" style="background:#f39c12;">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="icon fa fa-check"></i> Already Exist</h4>
						</div>';
				 }
				else if($status == "successful")
				 {
					 echo '<div class="alert alert-success alert-dismissible" style="background:#00a65a;">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="icon fa fa-check"></i> Success</h4>
						</div>';
				 }
				else if($status == "failed")
				 {
					 echo '<div class="alert alert-danger alert-dismissible" style="background:#dd4b39;">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="icon fa fa-check"></i> Failed</h4>
						</div>';
				 }
				else
				 {
					 
					 echo validation_errors();
				 }
			}
		 ?>
	<section class="content" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Card Setup</h3>
					</div>
					<form action="<?php echo base_url();?>setup/create_card" method="post" class="form-horizontal">
						<div class="box-body">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Bank Name</label>
								<div class="col-sm-5">
									<div class="input-group input-group-md">
										<?php 	
											echo form_dropdown('bank_id', $bank, '' ,'class="form-control select22 bank_name" id="one" style="width: 100%;"tabindex="-1" aria-hidden="true" required="required"');
										?>
										
										<span class="input-group-btn">
										  <button type="button" style="margin-bottom: 6px;" class="btn btn-block btn-primary" data-toggle="modal" data-target="#show_bank_add_modal"> <i class="fa fa-plus"></i></button>
										</span>
										 
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Card Name</label>
								<div class="col-sm-5">
									<?php 
										echo form_input('card_name','','class ="form-control"  style="text-transform:uppercase" placeholder="MASTER-VISA-AMERICAN EXPRESS" id="seven" autocomplete="off"');
									?>
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

	<div class="modal fade" id="show_bank_add_modal" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-plus"></i> Add New Bank</h4>
				</div>
				<form id="add_bank_form" action="<?php echo base_url(); ?>account_controller/create_bank_new" method="post" autocomplete="off" enctype="multipart/form-data" role="form">
					<div class="modal-body">
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Bank Name</span>
							<input name="bank_name" type="text" class="form-control bank_name2" placeholder="Bank Name" required="required" />
						</div>
						<div class="separator10"></div>
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Bank Account No</span>
							<input name="bank_account_no" type="text" class="form-control bank_account_no" placeholder="Bank Account No" required="required" />
						</div>
						<div class="separator10"></div>
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Bank Account Name</span>
							<input name="bank_account_name" type="text" class="form-control" placeholder="Bank Account Name" required="required" />
						</div>
						<div class="separator10"></div>
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Bank Description</span>
							<textarea name="bank_description" value="N/A" class="form-control" required="required" class="input-xlarge" id="textarea" rows="2">N/A</textarea>  
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Save Company</button>
						<button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>
	<script>
		$(document).ready(function() {
			$('#add_bank_form').on('submit', function(bank){
				bank.preventDefault();
				var submiturl = $(this).attr('action');
				var methods = $(this).attr('method');
				 $.ajax({
					url: submiturl,
					type: methods,
					data: $(this).serialize(),
					success:function(result){
						if(result == 'success'){
							alert('Your Data Successfully Saved.');
							select_new_entry_with_id('bank_info','bank_id','bank_name','bank_name','');
							$(".select22").select2();
						}
						else if(result == 'exist'){
							 alert('Data Already Exists.');
							select_new_entry_with_id('bank_info','bank_id','bank_name','bank_name','bank_name2');
							$(".select22").select2();
						}
						else if(result == 'error'){
						  alert('Data Not Successfully Saved');
						}
						$('#show_bank_add_modal').modal('hide');
					 },
					error: function (jXHR, textStatus, errorThrown) {html("")}
				});
				
			});
		});
		
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
	
	
</div>
<script type="text/javascript">

</script>
<?php $this -> load -> view('include/footer'); ?>
=======
<?php $this -> load -> view('include/header'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<script src="<?php echo base_url();?>assets/assets2/custom_script_2.js"></script>
<div class="content-wrapper">
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
		<?php 
			if($status != '' )
			{
				if($status == "exists")
				 {
					 echo '<div class="alert alert-warning alert-dismissible" style="background:#f39c12;">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="icon fa fa-check"></i> Already Exist</h4>
						</div>';
				 }
				else if($status == "successful")
				 {
					 echo '<div class="alert alert-success alert-dismissible" style="background:#00a65a;">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="icon fa fa-check"></i> Success</h4>
						</div>';
				 }
				else if($status == "failed")
				 {
					 echo '<div class="alert alert-danger alert-dismissible" style="background:#dd4b39;">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h4><i class="icon fa fa-check"></i> Failed</h4>
						</div>';
				 }
				else
				 {
					 
					 echo validation_errors();
				 }
			}
		 ?>
	<section class="content" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Card Setup</h3>
					</div>
					<form action="<?php echo base_url();?>setup/create_card" method="post" class="form-horizontal">
						<div class="box-body">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Bank Name</label>
								<div class="col-sm-5">
									<div class="input-group input-group-md">
										<?php 	
											echo form_dropdown('bank_id', $bank, '' ,'class="form-control select22 bank_name" id="one" style="width: 100%;"tabindex="-1" aria-hidden="true" required="required"');
										?>
										
										<span class="input-group-btn">
										  <button type="button" style="margin-bottom: 6px;" class="btn btn-block btn-primary" data-toggle="modal" data-target="#show_bank_add_modal"> <i class="fa fa-plus"></i></button>
										</span>
										 
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Card Name</label>
								<div class="col-sm-5">
									<?php 
										echo form_input('card_name','','class ="form-control"  style="text-transform:uppercase" placeholder="MASTER-VISA-AMERICAN EXPRESS" id="seven" autocomplete="off"');
									?>
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

	<div class="modal fade" id="show_bank_add_modal" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-plus"></i> Add New Bank</h4>
				</div>
				<form id="add_bank_form" action="<?php echo base_url(); ?>account_controller/create_bank_new" method="post" autocomplete="off" enctype="multipart/form-data" role="form">
					<div class="modal-body">
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Bank Name</span>
							<input name="bank_name" type="text" class="form-control bank_name2" placeholder="Bank Name" required="required" />
						</div>
						<div class="separator10"></div>
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Bank Account No</span>
							<input name="bank_account_no" type="text" class="form-control bank_account_no" placeholder="Bank Account No" required="required" />
						</div>
						<div class="separator10"></div>
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Bank Account Name</span>
							<input name="bank_account_name" type="text" class="form-control" placeholder="Bank Account Name" required="required" />
						</div>
						<div class="separator10"></div>
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Bank Description</span>
							<textarea name="bank_description" value="N/A" class="form-control" required="required" class="input-xlarge" id="textarea" rows="2">N/A</textarea>  
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Save Company</button>
						<button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>
	<script>
		$(document).ready(function() {
			$('#add_bank_form').on('submit', function(bank){
				bank.preventDefault();
				var submiturl = $(this).attr('action');
				var methods = $(this).attr('method');
				 $.ajax({
					url: submiturl,
					type: methods,
					data: $(this).serialize(),
					success:function(result){
						if(result == 'success'){
							alert('Your Data Successfully Saved.');
							select_new_entry_with_id('bank_info','bank_id','bank_name','bank_name','');
							$(".select22").select2();
						}
						else if(result == 'exist'){
							 alert('Data Already Exists.');
							select_new_entry_with_id('bank_info','bank_id','bank_name','bank_name','bank_name2');
							$(".select22").select2();
						}
						else if(result == 'error'){
						  alert('Data Not Successfully Saved');
						}
						$('#show_bank_add_modal').modal('hide');
					 },
					error: function (jXHR, textStatus, errorThrown) {html("")}
				});
				
			});
		});
		
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
	
	
</div>
<script type="text/javascript">

</script>
<?php $this -> load -> view('include/footer'); ?>
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
