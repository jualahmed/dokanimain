<style>
	.select2-container {
		width: 100% !important;
	}
	.select2-container .select2-selection--single {
		height: 34px;
	}
</style>
<div class="content-wrapper" id="vuejsapp">
    <section class="content">
        <div class="row">
       		<div class="col-md-10 col-md-offset-1">
	        	<div class="box">
            		<div class="box-header with-border">
              			<h3 class="box-title">Purchase Receipt Entry</h3>
            		</div>
             		<div class="box-body">
                		<div class="col-md-12">
	                		<form action="<?php echo base_url().'purchase/create' ?>" id="purchase">
		              			<table class="table table-bordered reduce_space" >
					              	<tr>
					              		<td style="vertical-align: middle;"><b>Distributor: <span class="text-danger">*</span></b></td>
					              		<td>
										  	<div class="input-group input-group-md">
												<select class="form-control select2 sel_dist distrib" name="distributor_id" id="distributor_id">
													<option value="" selected="selected">Select a distributor</option>
													<?php foreach($distributor_info as $tmp){ ?>
														<option value="<?php echo $tmp->distributor_id; ?>"><?php echo $tmp->distributor_name; ?></option>
													<?php }?>
												</select>
											  	<span class="input-group-btn">
													<button type="button" data-toggle="modal" data-target="#distributorModal" class="btn btn-block btn-primary add_distributor"> <i class="fa fa-plus"></i></button>
												</span>
											</div>
					              		</td>
					              	</tr>
					              	<tr>
					              		<td style="vertical-align: middle;"><b>Purchase Amount: <span class="text-danger">*</span></b></td>
					              		<td>
					              			<input type="text" name="purchase_amount" style="text-align: right;" class="form-control" id="purchase_amount" placeholder="Ex: 1000" autocomplete="off">
					              		</td>
					              	</tr>
					              	<tr>
					              		<td style="vertical-align: middle;"><b>Transport Cost:</b></td>
					              		<td>
					              			<input type="text" name="transport_cost" style="text-align: right;" class="form-control" id="transport_cost" placeholder="Ex: 100" autocomplete="off">
					              		</td>
					              	</tr>
					              	<tr>
					              		<td style="vertical-align: middle;"><b>Discount:</b></td>
					              		<td>
					              			<input type="text" name="gift_on_purchase" style="text-align: right;" class="form-control" id="gift_on_purchase" placeholder="Ex: 5" autocomplete="off">
					              		</td>
					              	</tr>
					              	<tr>
					              		<td style="vertical-align: middle;"><b>Final Amount:</b></td>
					              		<td>
					              			<input type="text" name="final_amount" style="text-align: right;" class="form-control" id="final_amount" placeholder="Ex: 995" readonly>
					              		</td>
					              	</tr>
					              	<tr>
					              		<td style="vertical-align: middle;"><b>Date:</b></td>
					              		<td>
					              			<input id="datepicker" type="text" name="receipt_date" value="<?php echo date('Y-m-d');?>"  class="form-control"  placeholder="Ex: 12-12-16"/>
					              		</td>
					              	</tr>
						            <tr>
					              		<td style="vertical-align: middle;">Payment Mode:</td>
										<td>
											<select class="form-control select2" name="payment_mode" id="payment_mode" style="width:100%;">
												<option value="">Select Mode</option>
												<option value="1">Cash</option>
												<option value="2">Cheque</option>
												<option value="3">Card</option>
											</select>
										</td>
					              	</tr>
									<tr>
					              		<td style="vertical-align: middle;">Payment Amount:</td>
					              		<td>
					              			<input type="text" name="payment_amount" style="text-align: right;" class="form-control" id="payment_amount" placeholder="Ex: 1000" autocomplete="off">
					              		</td>
					              	</tr>
									<tr style="display:none;" id="card_id_list">
					              		<td style="vertical-align: middle;">Card:</td>
										<td>
											<select class="form-control select2" name="card_id" id="card_id" style="width:100%;"></select>
										</td>
					              	</tr>
									<tr class="result_cheque" style="display:none;">
										<td>My</td>
										<td>
											<select class="form-control select2" name="my_bank" style="width:100%;" id="my_bank">
												<option value="">Select Bank</option>
												<?php 
													foreach($all_bank as $field)
													{
													
												?>
												<option value="<?php echo $field->bank_id;?>"><?php echo $field->bank_name;?></option>
												<?php
													}
												?>
											</select>
										</td>
					              	</tr>
									<tr class="result_cheque" style="display:none;">
										<td>To</td>
										<td>
											<select class="form-control select2" name="to_bank" style="width:100%;" id="to_bank">
												<option value="">Select Bank</option>
												<?php 
													foreach($all_bank as $field)
													{
													
												?>
												<option value="<?php echo $field->bank_id;?>"><?php echo $field->bank_name;?></option>
												<?php
													}
												?>
											</select>
										</td>
									</tr>
									<tr class="result_cheque" style="display:none;">
										<td>Cheque</td>
										<td>
											<input type="text" name="cheque_no" class="form-control" id="cheque_no_id" placeholder="Cheque No" title="Cheque No" autocomplete="off"></td>
									</tr>
									<tr class="result_cheque" style="display:none;">
										<td>Date</td>
										<td>
											<input type="text" class="form-control" name="cheque_date" id="datedate" placeholder="Cheque Date" title="Cheque Date" autocomplete="off">
										</td>
									</tr>
	             	 			</table>
								<div class="box-footer text-right">
									<div class="col-sm-22">
										<button type="submit" class="btn btn-success" name="search_random" id="submit"><i class="fa fa-fw fa-save"></i> Create</button>
									</div>
								</div>
							</form>
                		</div>
	            		<!-- /.box-body -->
	            		<input type="hidden" id="status" value="<?php echo $status;?>">
	            		<!-- /.box-footer -->
          			</div>
	        	</div>
      		</div>
      	</div> 
		<br>
		<br>
		<table class="table table-bordred table-striped" align="left">
			<tr align="left">
				<th>No.</th>
				<th>Distributor</th>
				<th>Purchase amount</th>
				<th>Transport cost</th>
				<th>Final_amount</th>
				<th>Total paid</th>
				<th>Receipt status</th>
				<!-- <th align="center">Action</th> -->
			</tr>
			<tr v-for="(r,index) in result[0]" align="left"> 
				<td>{{ index+1 }}</td>
				<th>{{ r.distributor_name }} ( {{r.receipt_id }})</th>
				<td>{{ r.purchase_amount }}</td>
				<td>{{ r.transport_cost }}</td>
				<td>{{ r.final_amount }}</td>
				<td>{{ r.total_paid }}</td>
				<td>{{ r.receipt_status }}</td>
				<td>
					<a data-toggle="modal" :purchase_id="r.receipt_id" data-target="#dis_adder_mdl" class="btn edit btn-sm btn-success" ><i class="fa fa-edit"></i> Edit</a>
					<!-- <a onclick="return confirm('Are you sure your want to delete?')" :href="base_url+'Company/destroy/'+r.company_id" class="btn btn-sm btn-danger" >
						<i class="fa fa-trash"></i> Delete
					</a> -->
				</td>
			</tr>
		</table>
		<div id='pagination' v-html="pagination[0]"></div>
    </section>
</div>


<!-- Modal -->
<div class="modal fade" id="distributorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="distributor" action="<?php echo base_url();?>distributor/create" method="post" class="form-horizontal">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <div class="row">
	        	<div class="col-md-6">
	        		<h3 class="modal-title" id="exampleModalLabel">Create a new distributor</h3>
	        	</div>
	        	<div class="col-md-6">
	        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
	        	</div>
	        </div>
	      </div>
	      <div class="modal-body">
		  	<div class="box-body">
				<div class="row">
					<div class="col-md-6 left">
						<div class="form-group">
							<label for="inputEmail3" class="control-label">Distributor Name <span class="text-danger">*</span></label>
							<input type="text" name="distributor_name" value="" class="form-control distributor_name" placeholder="Distributor Name" autocomplete="off">
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="control-label">Distributor Number <span class="text-danger">*</span></label>
							<input type="text" name="distributor_contact_no" value="" class="form-control distributor_contact_no" placeholder="Contact Number" autocomplete="off">
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="control-label">Distributor Email</label>
							<input type="email" name="distributor_email" value="" class="form-control distributor_email text-lowercase" placeholder="Email Address" autocomplete="off">
						</div>
					</div>
					<div class="col-md-6 right">
						<div class="form-group">
							<label for="inputEmail3" class="control-label">Distributor Address</label>
							<textarea name="distributor_address" cols="10" rows="1" class="form-control distributor_address" maxlength="300" placeholder="Distributor Address"></textarea>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="control-label">Distributor Description</label>
							<textarea name="distributor_description" cols="10" rows="1" class="form-control distributor_description" maxlength="300" placeholder="Distributor Description"></textarea>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="control-label">Initial Balance</label>
							<input type="number" name="int_balance" value="" class="form-control int_balance" placeholder="Initial Balance" autocomplete="off">
						</div>
					</div>
				</div>
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-success" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i> Create</button>
			<button type="reset" id="reset_btn" class="btn btn-warning"><i class="fa fa-fw fa-refresh"></i> Reset</button>
	      </div>
	    </div>
	  </div>
  </form>
</div>


<!-- <?php //echo validation_errors(); ?> -->
<div class="modal"  id="dis_adder_mdl">
	<div class="modal-dialog">
		<div class="modal-content" style="border-radius: 6px;">
			<div class="modal-header">
		    	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		    		<span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title">Add supplier</h4>
		    </div>
		    <form id="purchaseupdate" action="<?php echo base_url().'purchase/updaterecipt' ?>" method="post">
			    <div class="modal-body">
			    
					<table class="table table-bordered">
						<input type="hidden" id="purchase_id" name="purchase_id">
						<input type="hidden" id="supplier_id" name="supplier_id">
		             	<tr>
		             		<td>Purchase Amount:</td>
		             		<td>
		             			<input type="text" name="purchase_amount" class="form-control" id="purchase_amounts" placeholder="purchase_amount" required="on" autocomplete="off">
		             		</td>
		             	</tr>
		             	<tr>
		             		<td>Transport Cost:</td>
		             		<td>
		             			<input type="text" name="transport_cost" disabled class="form-control" id="transport_costs" placeholder="transport_cost" required="on" autocomplete="off">
		             		</td>
		             	</tr>
		             	<tr>
		             		<td>Discount:</td>
		             		<td>
		             			<input type="text" name="discount" disabled class="form-control" id="discounts" placeholder="discount" required="on" autocomplete="off">
		             		</td>
		             	</tr>
						<tr>
		             		<td>Total Paid:</td>
		             		<td>
		             			<input type="number" disabled name="total_paid" class="form-control" id="total_paids" placeholder="total_paid" required="on" autocomplete="off">
		             		</td>
		             	</tr>
		       		</table>

			    </div>
			    <div class="modal-footer">
			    	<button type="button" class="btn" data-dismiss="modal">Close</button>
			    	<input type="submit" name="submit" id="submit_info" class="btn btn-info" value="Save">
			    </div>
			</form>
		</div>
	</div>
</div>
