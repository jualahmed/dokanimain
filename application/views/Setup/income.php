
<div class="content-wrapper" id="vuejsapp">
	<section class="content">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
					<div class="box-header with-border">
						<h3 class="box-title">Income Entry</h3>
					</div>
					<form action="<?php echo base_url();?>expense/income_create" id="income" method="post" class="form-horizontal">
						<div class="box-body">	
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">income Type</label>
								<div class="col-sm-4">
									<div class="input-group input-group-md">
										<select name="income_type" id="income_type" class="form-control">
											<option value="">Select a type</option>
											<?php foreach ($expense_type as $var): ?>
												<option value="<?php echo $var->type_id ?>"><?php echo $var->type_name ?></option>
											<?php endforeach ?>
										</select>
										<span class="input-group-btn">
											 <button type="button" style="margin-bottom: 6px;" class="btn btn-block btn-primary" data-toggle="modal" data-target="#show_income_typ_modal"> <i class="fa fa-plus"></i></button>
										</span>
									</div>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label">Service Provider</label>
								<div class="col-sm-4">
									<div class="input-group input-group-md">
										<select name="service_provider_id" id="service_provider_id" class="form-control">
											<option value="">Select Service Provider</option>
											<?php foreach ($service_provider_info as $var): ?>
												<option value="<?php echo $var->service_provider_id ?>"><?php echo $var->service_provider_name ?></option>
											<?php endforeach ?>
										</select>
										<span class="input-group-btn">
											<button type="button" style="margin-bottom: 6px;" class="btn btn-block btn-primary" data-toggle="modal" data-target="#show_service_provider_modal"> <i class="fa fa-plus"></i></button>
										</span>
									</div>
								</div>
							</div>
							<br>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">income Amount</label>
								<div class="col-sm-4">
									<input type="text" name="income_amount" value="" placeholder="income Amount" id="income_amount" autocomplete="off" class="form-control">
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label">Paid Amount</label>
								<div class="col-sm-4">
									<input type="text" name="total_paid" value="" placeholder="Paid Amount" id="total_paid" autocomplete="off" class="form-control">
								</div>
							</div>
							<br>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">income Details</label>
								<div class="col-sm-10">
									<textarea name="income_details" cols="10" rows="2" id="income_details" maxlength="100" placeholder="income Details" class="form-control">N/A</textarea>
								</div>
							</div>
							<br>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Payment Mode</label>
								<div class="col-sm-10">
									<select class="form-control select2" name="payment_mode" id="payment_mode" style="width:100%;">
										<option value="">Select Mode</option>
										<option value="1">Cash</option>
										<option value="2">Cheque</option>
										<option value="3">Card</option>
									</select>
								</div>
							</div>
							<div class="box-footer" style="background: #6c8490;padding: 6px;height: 48px;display:none;" id="result_cheque">
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-1 control-label" style="color:white;">My</label>
									<div class="col-sm-2">
										<select name="my_bank" id="" class="form-control">
											<option value="">Select a bank</option>
											<?php foreach ($bank_info as $var): ?>
												<option value="<?php echo $var->bank_id ?>"><?php echo $var->bank_name ?></option>
											<?php endforeach ?>
										</select>
									</div>
									<label for="inputEmail3" class="col-sm-1 control-label" style="color:white;">Bank</label>
									<div class="col-sm-2">
										<select name="to_bank" id="" class="form-control">
											<option value="">Select a bank</option>
											<?php foreach ($bank_info as $var): ?>
												<option value="<?php echo $var->bank_id ?>"><?php echo $var->bank_name ?></option>
											<?php endforeach ?>
										</select>
									</div>
									<label for="inputEmail3" class="col-sm-1 control-label" style="color:white;">Cheque</label>
									<div class="col-sm-2">
										<input type="text" name="cheque_no" class="form-control" id="cheque_no_id" placeholder="Cheque No" title="Cheque No" autocomplete="off">
									</div>
									<label for="inputEmail3" class="col-sm-1 control-label" style="color:white;">Date</label>
									<div class="col-sm-2">
										<input type="text" class="form-control" name="cheque_date" id="datasep" placeholder="Cheque Date" title="Cheque Date">
									</div>
								</div>
							</div>
							<div class="form-group" style="display:none;" id="card_id_list">
								<label for="inputEmail3" class="col-sm-2 control-label">Card</label>
								<div class="col-sm-10">
									<select class="form-control select2" name="card_id" id="card_id" style="width:100%;"></select>
								</div>
							</div>
							<div class="box-footer">
								<div class="col-sm-22 text-right">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i> Create</button>
									<button type="reset" id="reset_btn" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-refresh"></i> Reset</button>
								</div>
							</div>
						</div>
					</form>
				</div> 
			</div> 
			<div class="col-md-12">
				<br>
				<br>
				<table class="table table-bordred table-striped" align="left">
					<tr align="left">
						<th>No.</th>
						<th>income type</th>
						<th>income service_provider_id</th>
						<th>income amount</th>
						<th>income total_paid</th>
						<th>income details</th>
						<th align="center">Action</th>
					</tr>
					<tr v-for="(r,index) in result[0]" align="left"> 
						<td>{{ index+1 }}</td>
						<td>{{ r.type_name }}</td>
						<td>{{ r.service_provider_name }}</td>
						<td>{{ r.income_amount }}</td>
						<td>{{ r.total_paid }}</td>
						<td>{{ r.income_details }}</td>
						<td>
							<!-- <a data-toggle="modal" :income_id="r.income_id" data-target="#EditModel" class="btn edit btn-sm btn-success" ><i class="fa fa-edit"></i> Edit</a> -->
							<a onclick="return confirm('Are you sure your want to delete?')" :href="base_url+'expense/income_destroy/'+r.income_id" class="btn btn-sm btn-danger" >
								<i class="fa fa-trash"></i> Delete
							</a>
						</td>
					</tr>
				</table>
				<div id='pagination' v-html="pagination[0]"></div>
			</div>
		</div> 
	</section>

	<div class="modal fade" id="show_income_typ_modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><i class="fa fa-plus"></i> Add New income Type</h4>
				</div>
				<form id="typessssssss" action="<?php echo base_url(); ?>expense/create_type" method="post" autocomplete="off" enctype="multipart/form-data" role="form">
					<div class="modal-body">
						<div class="input-group input-group-sm">
							<span class="input-group-addon">income Type</span>
							<input name="type_type" type="text" class="form-control type_name" placeholder="income Type" required="required" />
						</div>
						<div class="separator10"></div>
						<div class="input-group input-group-sm">
							<span class="input-group-addon">income Details</span>
							<textarea name="income_details" value="N/A" class="form-control" required="required" class="input-xlarge" id="textarea" rows="2">N/A</textarea>  
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Save income Type</button>
						<button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>
	
	<div class="modal fade" id="show_service_provider_modal" >
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title"><i class="fa fa-plus"></i> Add New Service Provider</h4>
				</div>
				<form id="add_service_provider_form" action="<?php echo base_url(); ?>expense/create_service_provider" method="post" autocomplete="off" enctype="multipart/form-data" role="form">
					<div class="modal-body">
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Provider Name</span>
							<input name="service_provider_name" type="text" class="form-control service_provider" placeholder="Provider Name" required="required" />
						</div>
						<div class="separator10"></div>
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Provider Type</span>
							<input name="service_provider_type" type="text" class="form-control" placeholder="Provider Type"  />
						</div>
						<div class="separator10"></div>
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Provider Address</span>
							<input name="service_provider_address" placeholder="Provider Address"  type="text" class="form-control"  />
						</div>
						<div class="separator10"></div>
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Phone Number</span>
							<input name="service_provider_contact" placeholder="Phone Number" type="text" class="form-control"  />
						</div>
						<div class="separator10"></div>
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Email Address</span>
							<input name="service_provider_email" type="text" value="demo@gmail.com" class="form-control"  />
						</div>
						<div class="separator10"></div>
						<div class="input-group input-group-sm">
							<span class="input-group-addon">Description</span>
							<textarea name="service_provider_description" class="form-control input-xlarge" id="textarea" rows="2" value="N/A" >N/A</textarea>  
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Save Provider</button>
						<button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>
</div>
