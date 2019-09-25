
<div class="content-wrapper">
	<?php 
		if($status !=''){
			 if($status == "successful")
			 {
				 echo '<div class="box-body">';
				 echo $this->session->flashdata('msg1');
				 echo '</div>';
			 }
			 else if($status = '')
			 {
				 echo '<div class="box-body">';
				 echo 'No New Update';
				 echo '</div>';
			 }
			 else if($status == "failed")
			 {
				 echo '<div class="box-body">';
				 echo $this->session->flashdata('msg2');
				 echo '</div>';
			 }
		 }
	 ?>
	<section class="content">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Card Sale Report</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>Report/all_card_sale_report_find" class="form-horizontal" method="post" autocomplete="off" enctype="multipart/form-data" id="form_4">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Invoice</label>
								<div class="col-sm-2">
									<?php 
										echo form_dropdown('card_id', $card_name, '','class="form-control select2" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" id="lock3" tabindex="-1" aria-hidden="true"');
									?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Start</label>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "start_date",'class' => "form-control",'id' => "datepickerrr", 'tabindex' => 3, 'title' => "Start Date" ));?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">End</label>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "end_date",'class' => "form-control",'id' => "datepickerr", 'tabindex' => 3, 'title' => "End Date" ));?>
								</div>
								<div class="col-sm-3 mt-2">
									<button type="submit" class="btn btn-success btn-sm" name="search_random"><i class="fa fa-fw fa-search"></i> Search</button>
									<button type="reset" id="reset_btn" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-refresh"></i> Reset</button>
									<a href="<?php echo base_url();?>Report/download_data_card_sale" id="down" target="_blank" class="btn btn-primary btn-sm" style="text-decoration:none;display:none;"><i class="fa fa-download"></i> Down</a>
								</div>
							</div>
							
						</form>	
					</div>	
				</div>
			</div>
		</div>
	</section>	
<div class="modal1234 preload" style="display: none">
	<div class="center">
		<img src="<?php echo base_url();?>assets/img/spin.gif" id="loaderIcon2"/>
	</div>
</div>
<input type="hidden" id="card">
<input type="hidden" id="start">
<input type="hidden" id="end">
<section class="content" id="infomsg" style="display:none;">
	<div class="row">
		<div class="col-md-12">
			<div class="box">	 
				<div class="box-body">
					<div class="wrap">
						<table class="table">
							<tr>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;">Date</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;">Card Name</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;">Bank Name</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;">Sale Amount</td>
							</tr>
						</table>
						<div class="inner_table" id="search_data">
						</div>
						<table class="table">
							<tr>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;"></td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;"></td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;"></td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;">Total Sale</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;" id="finaloutput"></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>	
</section>
</div>
