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
					              			<select class="form-control select2 sel_dist distrib" name="distributor_id" id="distributor_id">
							                    <option value="" selected="selected">Select a distributor</option>
								                <?php foreach($distributor_info as $tmp){ ?>
								                	<option value="<?php echo $tmp->distributor_id; ?>"><?php echo $tmp->distributor_name; ?></option>
								                <?php }?>
					                		</select>
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
									<tr id="result_cheque" style="display:none;">
										<td>My</td>
										<td style="width:25%;">
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
										<td>To</td>
										<td style="width:20%;">
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
										<td>Cheque</td>
										<td>
											<input type="text" name="cheque_no" class="form-control" id="cheque_no_id" placeholder="Cheque No" title="Cheque No" autocomplete="off"></td>
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
			<!-- 	<td>
					<a data-toggle="modal" :company_id="r.company_id" data-target="#EditModel" class="btn edit btn-sm btn-success" ><i class="fa fa-edit"></i> Edit</a>
					<a onclick="return confirm('Are you sure your want to delete?')" :href="base_url+'Company/destroy/'+r.company_id" class="btn btn-sm btn-danger" >
						<i class="fa fa-trash"></i> Delete
					</a>
				</td> -->
			</tr>
		</table>
		<div id='pagination' v-html="pagination[0]"></div>
    </section>
</div>


<!-- <?php //echo validation_errors(); ?> -->
<div class="modal"  id="dis_adder_mdl">
	<div class="modal-dialog">
		<div class="modal-content" style="border-radius: 6px;">
			<div class="modal-header">
		    	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		    		<span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title">Add Distributor</h4>
		    </div>
		    <form id="distributor_info" action="" method="post">
		    <div class="modal-body">
		    
				<table class="table table-bordered">
	             	<tr>
	             		<td>Distributor Name:</td>
	             		<td>
	             			<input type="text" class="form-control distt_name" id="name" placeholder="Distributor Name" required="on" autocomplete="off">
	             		</td>
	             	</tr>
	             	<tr>
	             		<td>Phone:</td>
	             		<td>
	             			<input type="text" class="form-control" id="phn" placeholder="Phone" required="on" autocomplete="off">
	             		</td>
	             	</tr>
	             	<tr>
	             		<td>E-mail:</td>
	             		<td>
	             			<input type="email" class="form-control" id="mail" placeholder="E-mail" required="on" autocomplete="off">
	             		</td>
	             	</tr>
	             	<tr>
	             		<td>Address:</td>
	             		<td>
	             			<input type="text" class="form-control" id="address" placeholder="Address" required="on" autocomplete="off">
	             		</td>
	             	</tr>
					<tr>
	             		<td>Initial Balance:</td>
	             		<td>
	             			<input type="number" class="form-control" id="int_balance" placeholder="Initial Balance" required="on" autocomplete="off">
	             		</td>
	             	</tr>
	             	<tr>
	             		<td>Description:</td>
	             		<td>
	             			<input type="text" class="form-control" id="des" placeholder="Description" required="on" autocomplete="off">
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
