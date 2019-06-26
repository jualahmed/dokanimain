<<<<<<< HEAD
<?php $this -> load -> view('include/header'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<div class="content-wrapper">
<?php
	$result = $this->uri->segment(3);
	if($result!=''){
		
		if($result=='success'){
			echo '<script>
					$(document).ready(function(){
						swal("Bank Transfer Successfully Done", ":)", "success");
					});
			</script>';
		}
		else if($result=='failed'){
			echo '<script>
					$(document).ready(function(){
						swal("Something wrong with Bank Transfer", ":(", "info");
					}
			</script>';
		}
	}
	?>
<style>

.wrap {
    width: 100%;
	margin:0px 0px 0px 0px;
}
.wrap table {
    width: 100%;
    table-layout: fixed;
}
table .new_data tr td {
    border: 1.5px solid #ffe8e8;
	background: white;
}
table tr td {
    padding: 5px;
    border: 1.5px solid #ffe8e8;
    width: 100px;
    word-wrap: break-word;
	background: white;
}
table.head tr td {
    color:white;
	background: #4d89a7;
	font-size:14px;
	font-family:Sans Pro; 
	font-weight:bold;
}

.new_data_2 tr:nth-child(even) td {
    background-color: #e4f1ff;
}
.new_data_2 tr:nth-child(odd) td {
    background-color: #fff;
}
.inner_table {
	color:#666768;
    height: 90px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    overflow-y: auto !important;
}

.inner_table22 {
	color:#666768;
    height: 280px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    overflow-y: auto !important;
}
.inner_table_2 {
	color:#403e3e;
    height: 33px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    overflow-y: auto !important;
}
.inner_table::-webkit-scrollbar {
    width: 1px;
	background-color: #2d3335;
}

.inner_table::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: white;
}

.inner_table::-webkit-scrollbar-thumb {
   background-color: #448ca6;
   background-image: -webkit-linear-gradient(45deg,rgba(255, 255, 255, .2) 25%,transparent 25%,transparent 50%,rgba(255, 255, 255, .2) 50%,rgba(255, 255, 255, .2) 75%,transparent 75%,transparent)

}
.content2{
	min-height: 130px;
	padding: 4px;
}
</style>
<section class="content" style="margin:0px 0px 0px 0px;min-height:0px;">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="box">
				<div class="box-header with-border" style="background: #0f77ab;">
					<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Bank Transfer</h3>
				</div>
				<form action="<?php echo base_url();?>account_controller/create_transfer" method="post" class="form-horizontal">
					<div class="box-body">	
						<div class="form-group">
							<label class="col-sm-2 control-label">Transfer Type</label>
							<div class="col-sm-4">
								<select class="form-control select22" id="transfer_type" style="width: 100%;"tabindex="-1" aria-hidden="true" name="transfer_type" required="on">
									<option value="">Select Type</option>
									<option value="1">To Bank</option>
									<option value="2">From Bank</option>
								</select>
							</div>
							<label class="col-sm-2 control-label">Bank</label>
							<div class="col-sm-4">
								<?php 
									echo form_dropdown('bank_id', $bank_info,'','style="width:100%;" class="form-control select2 ledger input-sm" id="bank_id" tabindex="-1" aria-hidden="true"');
								?>
							</div>
						</div>
						<div class="form-group" style="display:none;" id="cheque_div">
							<label class="col-sm-2 control-label">Cheque No</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="cheque_no">
							</div>
							<label class="col-sm-2 control-label">Cheque Date</label>
							<div class="col-sm-4">
								<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "cheque_date",'class' => "form-control",'id' => "datepickerrr",'value' => $bd_date, 'tabindex' => 3, 'title' => "Start Date" ));?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Provider</label>
							<div class="col-sm-4">
								<?php 
									echo form_dropdown('service_provider_id', $service_provider_info,'','style="width:100%;" class="form-control select2 ledger input-sm" id="service_provider_id" tabindex="-1" aria-hidden="true"');
								?>
							</div>
							<label class="col-sm-2 control-label">Amount</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="amount">
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
<script>
$(document).ready(function()
{
	$("#transfer_type").on("change",function()
	{
		var transfer_type = $(this).val();
		if(transfer_type == 2) 
		{
			$('#cheque_div').show();
		} 
		else
		{
			$('#cheque_div').hide();
		} 
	});	
	
});
</script>
</div>
=======
<?php $this -> load -> view('include/header'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<div class="content-wrapper">
<?php
	$result = $this->uri->segment(3);
	if($result!=''){
		
		if($result=='success'){
			echo '<script>
					$(document).ready(function(){
						swal("Bank Transfer Successfully Done", ":)", "success");
					});
			</script>';
		}
		else if($result=='failed'){
			echo '<script>
					$(document).ready(function(){
						swal("Something wrong with Bank Transfer", ":(", "info");
					}
			</script>';
		}
	}
	?>
<style>

.wrap {
    width: 100%;
	margin:0px 0px 0px 0px;
}
.wrap table {
    width: 100%;
    table-layout: fixed;
}
table .new_data tr td {
    border: 1.5px solid #ffe8e8;
	background: white;
}
table tr td {
    padding: 5px;
    border: 1.5px solid #ffe8e8;
    width: 100px;
    word-wrap: break-word;
	background: white;
}
table.head tr td {
    color:white;
	background: #4d89a7;
	font-size:14px;
	font-family:Sans Pro; 
	font-weight:bold;
}

.new_data_2 tr:nth-child(even) td {
    background-color: #e4f1ff;
}
.new_data_2 tr:nth-child(odd) td {
    background-color: #fff;
}
.inner_table {
	color:#666768;
    height: 90px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    overflow-y: auto !important;
}

.inner_table22 {
	color:#666768;
    height: 280px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    overflow-y: auto !important;
}
.inner_table_2 {
	color:#403e3e;
    height: 33px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    overflow-y: auto !important;
}
.inner_table::-webkit-scrollbar {
    width: 1px;
	background-color: #2d3335;
}

.inner_table::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: white;
}

.inner_table::-webkit-scrollbar-thumb {
   background-color: #448ca6;
   background-image: -webkit-linear-gradient(45deg,rgba(255, 255, 255, .2) 25%,transparent 25%,transparent 50%,rgba(255, 255, 255, .2) 50%,rgba(255, 255, 255, .2) 75%,transparent 75%,transparent)

}
.content2{
	min-height: 130px;
	padding: 4px;
}
</style>
<section class="content" style="margin:0px 0px 0px 0px;min-height:0px;">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="box">
				<div class="box-header with-border" style="background: #0f77ab;">
					<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Bank Transfer</h3>
				</div>
				<form action="<?php echo base_url();?>account_controller/create_transfer" method="post" class="form-horizontal">
					<div class="box-body">	
						<div class="form-group">
							<label class="col-sm-2 control-label">Transfer Type</label>
							<div class="col-sm-4">
								<select class="form-control select22" id="transfer_type" style="width: 100%;"tabindex="-1" aria-hidden="true" name="transfer_type" required="on">
									<option value="">Select Type</option>
									<option value="1">To Bank</option>
									<option value="2">From Bank</option>
								</select>
							</div>
							<label class="col-sm-2 control-label">Bank</label>
							<div class="col-sm-4">
								<?php 
									echo form_dropdown('bank_id', $bank_info,'','style="width:100%;" class="form-control select2 ledger input-sm" id="bank_id" tabindex="-1" aria-hidden="true"');
								?>
							</div>
						</div>
						<div class="form-group" style="display:none;" id="cheque_div">
							<label class="col-sm-2 control-label">Cheque No</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="cheque_no">
							</div>
							<label class="col-sm-2 control-label">Cheque Date</label>
							<div class="col-sm-4">
								<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "cheque_date",'class' => "form-control",'id' => "datepickerrr",'value' => $bd_date, 'tabindex' => 3, 'title' => "Start Date" ));?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Provider</label>
							<div class="col-sm-4">
								<?php 
									echo form_dropdown('service_provider_id', $service_provider_info,'','style="width:100%;" class="form-control select2 ledger input-sm" id="service_provider_id" tabindex="-1" aria-hidden="true"');
								?>
							</div>
							<label class="col-sm-2 control-label">Amount</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="amount">
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
<script>
$(document).ready(function()
{
	$("#transfer_type").on("change",function()
	{
		var transfer_type = $(this).val();
		if(transfer_type == 2) 
		{
			$('#cheque_div').show();
		} 
		else
		{
			$('#cheque_div').hide();
		} 
	});	
	
});
</script>
</div>
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
<?php $this -> load -> view('include/footer'); ?>