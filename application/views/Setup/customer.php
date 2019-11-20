
<div class="content-wrapper" id="vuejsapp">
	<section class="content text-right">
		<!-- Button trigger modal -->
		<div class="text-left">
		<?php if($this->session->flashdata('success')){ ?>
		   <div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success'); ?></div>
		<?php } ?>
		</div>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
		  <i class="fa fa-plus"></i> Create a new customer
		</button>
		<br>
		<br>
		<table class="table table-bordred table-striped" align="left">
			<tr align="left">
				<th>No.</th>
				<th>customer name</th>
				<th>customer address</th>
				<th>customer contact no</th>
				<th>customer email</th>
				<th align="center">Action</th>
			</tr>
			<tr v-for="(r,index) in result[0]" align="left"> 
				<td>{{ row+index+1 }}</td>
				<td>{{ r.customer_name }}</td>
				<td>{{ r.customer_address }}</td>
				<td>{{ r.customer_contact_no }}</td>
				<td>{{ r.customer_email }}</td>
				<td>
					<a data-toggle="modal" :customer_id="r.customer_id" data-target="#EditModel" class="btn edit btn-sm btn-success" ><i class="fa fa-edit"></i> Edit</a>
					<a onclick="return confirm('Are you sure your want to delete?')" :href="base_url+'customer/destroy/'+r.customer_id" class="btn btn-sm btn-danger" >
						<i class="fa fa-trash"></i> Delete
					</a>
				</td>
			</tr>
			<tr><td colspan="9" style="text-align: left;"><b>{{ rowperpage }}  Out Of {{ total }}</b></td></tr>
		</table>
		<div id='pagination' v-html="pagination[0]"></div>
	</section>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="customer" action="<?php echo base_url();?>customer/create" method="post" class="form-horizontal">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <div class="row">
	        	<div class="col-md-6">
	        		<h3 class="modal-title" id="exampleModalLabel">Create a new customer</h3>
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
				<div class="box-body">
					<div class="row">
						<div class="col-md-6 left">
							<div class="form-group">
							   <label for="inputEmail3" class="control-label">Name <span class="text-danger">*</span></label>
								<input type="text" name="customer_name" value="" class="form-control customer_name" placeholder="Customer Name" autocomplete="off">
							</div>
							<div class="form-group">
							    <label for="inputEmail3" class="control-label">Type <span class="text-danger">*</span></label>
								<input type="text" name="customer_type" value="" class="form-control customer_type" placeholder="Type" autocomplete="off">
							</div>
							<div class="form-group">
							  	<label for="inputEmail3" class="control-label">Number <span class="text-danger">*</span></label>
								<input type="text" name="customer_contact_no" value="" class="form-control customer_contact_no" placeholder="Contact Number" autocomplete="off">
							</div>
							<div class="form-group">
							    <label for="inputEmail3" class="control-label">Mode <span class="text-danger">*</span></label>
								<input type="text" name="customer_mode" value="" class="form-control customer_mode" placeholder="Mode" autocomplete="off">
							</div>
						</div>
						<div class="col-md-6 right">
							<div class="form-group">
							    <label for="inputEmail3" class="control-label">Email <span class="text-danger">*</span></label>
								<input type="text" name="customer_email" value="" class="form-control customer_email text-lowercase" placeholder="Email Address" autocomplete="off">
							</div>
							<div class="form-group">
							    <label for="inputEmail3" class="control-label">Balance <span class="text-danger">*</span></label>
								<input type="text" name="int_balance" value="" class="form-control int_balance" placeholder="Balance" autocomplete="off">
							</div>
							<div class="form-group">
							    <label for="inputEmail3" class="control-label">Address <span class="text-danger">*</span></label>
								<textarea name="customer_address" cols="10" rows="1" class="form-control customer_address" maxlength="300" placeholder="customer Address"></textarea>
							</div>
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

<!-- Edit Modal -->
<div class="modal fade" id="EditModel" tabindex="-1" role="dialog" aria-labelledby="EditModelLabel" aria-hidden="true">
    <form id="customerupdate" action="<?php echo base_url();?>customer/update" method="post" class="form-horizontal">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <div class="row">
	        	<div class="col-md-6">
	        		<h3 class="modal-title" id="EditModelLabel">Edit customer</h3>
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
						<input type="hidden" name="customer_id" id="customer_id">
		 				<div class="form-group">
							<label class="form-control-label">customer Name <span class="text-danger">*</span></label>
							<input type="text" name="customer_name" value="" class="form-control" id="customer_name" placeholder="customer Name" autocomplete="off">
						</div>
						<div class="form-group">
							<label class="form-control-label">customer address <span class="text-danger">*</span></label>
							<textarea name="customer_address" cols="10" rows="2" class="form-control" id="customer_address" maxlength="100" placeholder="customer address"></textarea>
						</div>
						<div class="form-group">
							<label class="form-control-label">customer contact no <span class="text-danger">*</span></label>
							<input type="text" name="customer_contact_no" value="" class="form-control" id="customer_contact_no" placeholder="customer contact no" autocomplete="off">
						</div>
						<div class="form-group">
						   <label for="inputEmail3" class="control-label">Type <span class="text-danger">*</span></label>
							<input type="text" name="customer_type" value="" class="form-control" id="customer_type" placeholder="Type" autocomplete="off">
						</div>
					</div>
					<div class="col-md-6 right">
						<div class="form-group">
						   <label for="inputEmail3" class="control-label">Mode <span class="text-danger">*</span></label>
							<input type="text" name="customer_mode" value="" class="form-control" id="customer_mode" placeholder="Mode" autocomplete="off">
						</div>
						<div class="form-group">
							<label class="form-control-label">customer Email <span class="text-danger">*</span></label>
							<input type="text" name="customer_email" value="" class="form-control text-lowercase" id="customer_email" placeholder="customer Email" autocomplete="off">
						</div>
						<div class="form-group">
						    <label for="inputEmail3" class="control-label">Balance <span class="text-danger">*</span></label>
							<input type="text" name="int_balance" value="" class="form-control" id="int_balance" placeholder="Balance" autocomplete="off">
						</div>
					</div>
				</div>
			</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-success" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i> Update</button>
			<button type="reset" id="reset_btn" class="btn btn-warning"><i class="fa fa-fw fa-refresh"></i> Reset</button>
	      </div>
	    </div>
	  </div>
  </form>
</div>


