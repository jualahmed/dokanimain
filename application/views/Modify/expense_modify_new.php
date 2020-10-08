<div class="content-wrapper">
	<section class="content">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Expense Modify</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>modify/all_expense_report_find_new" class="form-horizontal" method="post" enctype="multipart/form-data" id="form_4" autocomplete="off">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Expense</label>
								<div class="col-sm-3">
									<?php 
										echo form_dropdown('expense_name', $expense_name, '','class="form-control select3" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" id="lock4" tabindex="-1" aria-hidden="true"');
									?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Start</label>
								<div class="col-sm-2">
									<input type="text" name="start_date" class="form-control" id="datepickerrr" placeholder="Star Date" tabindex="3" title="Start Date">
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">End</label>
								<div class="col-sm-2">
									<input type="text" name="end_date" class="form-control" id="datepickerr" placeholder="End Date" title="End Date">
								</div>
								<div class="col-sm-2">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
								</div>
							</div>
						</form>	
					</div>
				</div>
			</div>
		</div>
	</section>
	<div class="modal1234" style="display: none">
		<div class="center">
			<img src="<?php echo base_url();?>assets/assets2/spin.gif" id="loaderIcon2"/>
		</div>
	</div>
	<input type="hidden" id="receipt">
	<input type="hidden" id="expense">
	<section class="content" id="infomsg" style="display:none;">
		<div class="row">
			<div class="col-md-12">
				<div class="box">	 
					<div class="box-body">
						<div class="wrap">
							<table class="table">
								<tr>
								  <td width="8%">No</td>
								  <td width="8%">Expense ID</td>
								  <td width="15%">Expense</td>
								  <td width="15%">Expense Amount</td>
								  <td width="15%">Date</td>
								  <td>Action</td>
								</tr>
							</table>
							<div class="inner_table" id="search_data">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</section>
</div>
