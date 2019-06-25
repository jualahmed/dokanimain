<?php $this -> load -> view('include/header'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<div class="content-wrapper">
<script>
	 setTimeout(function() {$('.success_new_alert').slideUp("slow");}, 6000);
	 setTimeout(function() {$('.failed_new_alert').slideUp("slow");}, 6000);
	 setTimeout(function() {$('.exist_new_alert').slideUp("slow");}, 6000);
	 setTimeout(function() {$('.error_new_alert').slideUp("slow");}, 6000);
</script>
<?php
$result = $this->uri->segment(3);
if($result!='')
{
	if($result=='success')
	{
		echo '<div class="alert success_new_alert" role="alert" style="text-align:right;width: 235px;float: right;border-color: #ffffff;background-color:#96e6c2;margin-bottom: 0px;">
				  <span style="text-align:center;color: #1e456d;">Customer <strong>Successfully</strong> Listed.</span>
				</div>';
	}
	else if($result=='failed')
	{
		echo '<div class="alert failed_new_alert" role="alert" style="text-align:right;width: 300px;float: right;border-color: #ffffff;background-color:#f9b977;margin-bottom: 0px;">
				  <span style="text-align:center;color: #1e456d;"><strong>Something Wrong</strong> with Customer Setup.</span>
				</div>';
	}
	else if($result=='exist')
	{
		echo '<div class="alert exist_new_alert" role="alert" style="text-align:right;width: 280px;float: right;border-color: #ffffff;background-color:rgb(42, 211, 203);margin-bottom: 0px;">
				  <span style="text-align:center;color: #1e456d;"><strong>This Customer</strong> is already been Exist.</span>
				</div>';
	}
	else if($result=='error')
	{
		echo '<div class="alert error_new_alert" role="alert" style="text-align:right;width: 230px;float: right;border-color: #ffffff;background-color:rgb(255, 132, 132);margin-bottom: 0px;">
				  <span style="text-align:center;color: #1e456d;"><strong>Error found</strong> in Customer setup.</span>
				</div>';
	}
}
?>
	<section class="content" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Customer Setup</h3>
					</div>
					<form action="<?php echo base_url();?>setup/create_customer" method="post" class="form-horizontal">
						<div class="box-body">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Name</label>
								<div class="col-sm-10">
									<?php 	
										echo form_input('customer_name', '','class="form-control" id="one" style="text-transform:uppercase" placeholder="Customer Name" autocomplete="off"');	
									?>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Type</label>
								<div class="col-sm-10">
									<?php 	
										echo form_dropdown('customer_type', $customer_info, '','class="form-control select222" style="width: 100%;" id="three" tabindex="-1" aria-hidden="true"');
									?>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Number</label>
								<div class="col-sm-10">
									<?php 	
										echo form_input('customer_contact_no', '','class="form-control" id="four" placeholder="Phone Number" autocomplete="off"');
									?>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Mode</label>
								<div class="col-sm-10">
									<?php 	
										echo form_dropdown('customer_mode', $customer_mode, '','class="form-control select2222" style="width: 100%;" id="five" tabindex="-1" aria-hidden="true"');
									?>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Email</label>
								<div class="col-sm-10">
									<?php 	
										echo form_input('customer_email', '','class="form-control" id="six" placeholder="Email Address"');
									?>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Balance</label>
								<div class="col-sm-10">
									<input type="number" name="initial_balance" class="form-control" placeholder="Initial Balance">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Address</label>
								<div class="col-sm-10">
									<?php 
										$customerAddress = array(
											'name'	=> 'customer_address',
											//'id'	=> 'customer_address',
											'class'	=> 'form-control',
											'rows'  => '2',
											'cols'  => '20',
											'maxlength'	=> 300
										);
									 echo form_textarea($customerAddress, '', 'class="form-control" id="seven" placeholder="Customer Address"'); 
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
</div>
<script type="text/javascript">
$(document).ready(function() {
	$("#reset_btn").click(function(event) {
			event.preventDefault();
			$('#three').val('');
			$('#three').select2();
			$('#five').val('');
			$('#five').select2();
			$('#one').val('');
			$('#two').val('');
			$('#four').val('');
			$('#six').val('');
			$('#seven').val('');
		});
	});
</script>
<?php $this -> load -> view('include/footer'); ?>