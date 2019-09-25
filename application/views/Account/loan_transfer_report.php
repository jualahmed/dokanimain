
<div class="content-wrapper">
	<br>
	<section>
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Loan Transfer Report</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>account/all_loan_transfer_report_find" method="post" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" id="form_6">
							<div class="form-group">
								<label class="col-sm-2 control-label">Person Name</label>
								<div class="col-sm-7">
									<?php 
										echo form_dropdown('lp_id', $loan_person_info,'','style="width:100%;" class="form-control select2 input-sm" id="lp_id" tabindex="-1" aria-hidden="true"');
									?>
								</div>
								<div class="col-sm-3">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
									<a href="<?php echo base_url();?>account/download_loan_transfer" id="down" style="display:none;width:100px;" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Download</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="modal" style="display: none">
		<div class="center">
			<img src="<?php echo base_url();?>assets2/spin.gif" id="loaderIcon"/>
		</div>
	</div>
	<input type="hidden" id="start">
	<input type="hidden" id="end">
	<section class="content-3" id="infomsg" style="display:none;">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">	 
					<div class="box-body">
						<div class="wrap">
							<div class="box-header with-border" style="background: #0f77ab;width: 98%;">
								<center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Loan Receive</h3></center>
							</div>
							<table class="head">
								<tr>
								  <td style="width:4%;">Date</td>
								  <td style="width:4%;">Person Name</td>
								  <td style="width:4%;">Particular</td>
								  <td style="width: 4%;text-align:right;">Amount</td>
								</tr>
							</table>
							<div class="inner_table" id="search_data">
							</div>
							<table class="head">
								<tr>
								  <td style="width:4%;"></td>
								  <td style="width:4%;"></td>
								  <td style="width:4%;">Total</td>
								  <td style="width: 4%;text-align:right;"><span id="total_debit"></span></td>
								</tr>
							</table>
						</div>
						<div class="wrap-11">
							<div class="box-header with-border" style="background: #0f77ab;width: 100%;">
								<center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Loan Payment</h3></center>
							</div>
							<table class="head">
								<tr>
								  <td style="width:4%;">Date</td>
								  <td style="width:4%;">Person Name</td>
								  <td style="width:4%;">Particular</td>
								  <td style="width: 4%;text-align:right;">Amount</td>
								</tr>
							</table>
							<div class="inner_table" id="search_data2">
							</div>
							<table class="head">
								<tr>
								  <td style="width:4%;"></td>
								  <td style="width:4%;"></td>
								  <td style="width:4%;">Total</td>
								  <td style="width: 4%;text-align:right;"><span id="total_credit"></span></td>
								</tr>
							</table>
						</div>
						
						
					</div>
					<div class="box-header with-border" style="background: #0f77ab;">
							<center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Balance : <span id="balance"></span></h3></center>
						</div>
				</div>
			</div>
		</div>	
	</section>
</div>
