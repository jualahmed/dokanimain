<div class="content-wrapper">
	<section class="content" style="margin:0px 0px 0px 0px;min-height:0px;">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Bank Transfer</h3>
					</div>
					<form action="<?php echo base_url();?>account/create_transfer" method="post" class="form-horizontal">
						<div class="box-body">	
							<div class="form-group">
								<label class="col-sm-2 control-label">Transfer Type</label>
								<div class="col-sm-10">
									<select class="form-control select22" id="transfer_type" style="width: 100%;"tabindex="-1" aria-hidden="true" name="transfer_type" required="on">
										<option value="">Select Type</option>
										<option value="1">To Bank</option>
										<option value="2">From Bank</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Bank</label>
								<div class="col-sm-10">
									<select name="bank_id" id="bank_id" class="form-control" required>
										<option value="">Select A Bank</option>
										<?php foreach ($bank as  $value): ?>
											<option value="<?php echo $value->bank_id ?>"><?php echo $value->bank_name ?></option>
										<?php endforeach ?>
									</select>
								</div>
							</div>
							<br>
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
								<br>
								<label class="col-sm-2 control-label">Amount</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="amount" required>
								</div>
							</div>
							<div class="box-footer">
								<div class="col-sm-22 text-right">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i>Create Transfer</button>
								</div>
							</div>
						</div> 
					</form>
				</div> 
			</div> 
		</div> 
	</section> 
</div>
