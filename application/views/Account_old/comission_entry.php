<<<<<<< HEAD
<?php $this -> load -> view('include/header'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="content-wrapper">
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 
	$result = $this->uri->segment(3);
	if($result!=''){
		
		if($result=='success')
		{
			echo '<script>
					$(document).ready(function(){
						swal("Comission Successfully Listed", ":)", "success");
					});
			</script>';
		}
		else if($result=='failed')
		{
			echo '<script>
					$(document).ready(function(){
						swal("Something wrong with Comission", ":)", "info");
					}
			</script>';
		}

	}
?>
	<section class="content" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Comission Entry</h3>
					</div>
					<form action="<?php echo base_url();?>account_controller/create_comission" method="post" id="form_setup" class="form-horizontal">
						<div class="box-body">
							<div class="form-group">
							<?php
									$now=Date("Y");
									$old=$now-100;
									
									
									for($i=$now;$i>=$old;$i--)
									{
										if($i==$now)
											$year['']='Select Year';
											
											
										$year[$now]=$now;
										$now--;
									}
								?>
								<label for="inputEmail3" class="col-sm-3 control-label">Month</label>
								<div class="col-sm-9">
									<select class="select2 form-control" id="com_month" name="com_month" tabindex="-1" style="width:100%;">
										<option value="">Select Month</option>
										<option value="1">January</option>
										<option value="2">February</option>
										<option value="3">March</option>
										<option value="4">April</option>
										<option value="5">May</option>
										<option value="6">June</option>
										<option value="7">July</option>
										<option value="8">August</option>
										<option value="9">September</option>
										<option value="10">October</option>
										<option value="11">Novermber</option>
										<option value="12">December</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Amount </label>
								<div class="col-sm-9">
									<?php 
										echo form_input('com_amount', '','class ="form-control" id="amount" placeholder="In Taka /=" autocomplete="off"');
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
=======
<?php $this -> load -> view('include/header'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="content-wrapper">
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 
	$result = $this->uri->segment(3);
	if($result!=''){
		
		if($result=='success')
		{
			echo '<script>
					$(document).ready(function(){
						swal("Comission Successfully Listed", ":)", "success");
					});
			</script>';
		}
		else if($result=='failed')
		{
			echo '<script>
					$(document).ready(function(){
						swal("Something wrong with Comission", ":)", "info");
					}
			</script>';
		}

	}
?>
	<section class="content" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Comission Entry</h3>
					</div>
					<form action="<?php echo base_url();?>account_controller/create_comission" method="post" id="form_setup" class="form-horizontal">
						<div class="box-body">
							<div class="form-group">
							<?php
									$now=Date("Y");
									$old=$now-100;
									
									
									for($i=$now;$i>=$old;$i--)
									{
										if($i==$now)
											$year['']='Select Year';
											
											
										$year[$now]=$now;
										$now--;
									}
								?>
								<label for="inputEmail3" class="col-sm-3 control-label">Month</label>
								<div class="col-sm-9">
									<select class="select2 form-control" id="com_month" name="com_month" tabindex="-1" style="width:100%;">
										<option value="">Select Month</option>
										<option value="1">January</option>
										<option value="2">February</option>
										<option value="3">March</option>
										<option value="4">April</option>
										<option value="5">May</option>
										<option value="6">June</option>
										<option value="7">July</option>
										<option value="8">August</option>
										<option value="9">September</option>
										<option value="10">October</option>
										<option value="11">Novermber</option>
										<option value="12">December</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Amount </label>
								<div class="col-sm-9">
									<?php 
										echo form_input('com_amount', '','class ="form-control" id="amount" placeholder="In Taka /=" autocomplete="off"');
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
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
<?php $this -> load -> view('include/footer'); ?>