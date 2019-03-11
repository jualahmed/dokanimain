<?php $this -> load -> view('include/header'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<div class="content-wrapper">
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 
	$result = $this->uri->segment(3);
	if($result!=''){
		
		if($result=='success')
		{
			echo '<script>
					$(document).ready(function(){
						swal("Bank Successfully Listed", ":)", "success");
					});
			</script>';
		}
		else if($result=='failed')
		{
			echo '<script>
					$(document).ready(function(){
						swal("Something wrong with Bank", ":)", "info");
					}
			</script>';
		}
		else if($result=='exist')
		{
			echo '<script>
					$(document).ready(function(){
						swal("Bank is already been Exist.", ":)", "info");
					}
			</script>';
		}
	}
	$bank_description = array(
		'name'	=> 'bank_description',
		'class'	=> 'form-control',
		'rows'  => '2',
		'cols'  => '10',
		'maxlength'	=> 300
	);
?>
	<section class="content" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Bank Entry</h3>
					</div>
					<form action="<?php echo base_url();?>account_controller/create_bank" method="post" id="form_setup" class="form-horizontal">
						<div class="box-body">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Bank Name</label>
								<div class="col-sm-8">
									<?php 	
										echo form_input('bank_name', '', 'class="form-control" id="one" placeholder="Bank Name" autocomplete="off"');
									?>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Bank Account No</label>
								<div class="col-sm-8">
									<?php 	
										echo form_input('bank_account_no', '', 'class="form-control" id="two" placeholder="Bank Account No" autocomplete="off"');
									?>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Bank Account Name</label>
								<div class="col-sm-8">
									<?php 	
										echo form_input('bank_account_name', '', 'class="form-control" id="three" placeholder="Bank Account Name" autocomplete="off"');
									?>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Bank Description</label>
								<div class="col-sm-8">
									<?php 	
										echo form_textarea($bank_description, '', 'class="form-control" id="four" rows="4" placeholder="Bank Description" autocomplete="off"'); 
									?>
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
</div>
<?php $this -> load -> view('include/footer'); ?>