
<div class="content-wrapper" id="vuejsapp">
	<section class="content text-right">
		<!-- Button trigger modal -->
		<div class="text-left">
		<?php if($this->session->flashdata('success')){ ?>
		   <div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success'); ?></div>
		<?php } ?>
		</div>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
		  <i class="fa fa-plus"></i> Create a new employee
		</button>
		<br>
		<br>
		<table class="table table-bordred table-striped" align="left">
			<tr align="left">
				<th>No.</th>
				<th>employee name</th>
				<th>employee type</th>
				<th>employee address</th>
				<th>employee contact no</th>
				<th>int balance</th>
				<th>employee email</th>
				<th align="center">Action</th>
			</tr>
			<tr v-for="(r,index) in result[0]" align="left"> 
				<td>{{ index+1 }}</td>
				<td>{{ r.employee_name }}</td>
				<td>{{ r.employee_type }}</td>
				<td>{{ r.employee_address }}</td>
				<td>{{ r.employee_contact_no }}</td>
				<td>{{ r.int_balance }}</td>
				<td class="text-lowercase">{{ r.employee_email }}</td>
				<td>
					<a data-toggle="modal" :employee_id="r.employee_id" data-target="#EditModel" class="btn edit btn-sm btn-success" ><i class="fa fa-edit"></i> Edit</a>
					<a onclick="return confirm('Are you sure your want to delete?')" :href="base_url+'employee/destroy/'+r.employee_id" class="btn btn-sm btn-danger" >
						<i class="fa fa-trash"></i> Delete
					</a>
				</td>
			</tr>
		</table>
		<div id='pagination' v-html="pagination[0]"></div>
	</section>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <form id="employee" action="<?php echo base_url();?>employee/create" method="post" class="form-horizontal">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <div class="row">
	        	<div class="col-md-6">
	        		<h3 class="modal-title" id="exampleModalLabel">Create a new employee</h3>
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
								<input type="text" name="employee_name" value="" class="form-control employee_name" placeholder="employee Name" autocomplete="off">
							</div>
							<div class="form-group">
							  	<label for="inputEmail3" class="control-label">Number <span class="text-danger">*</span></label>
								<input type="text" name="employee_contact_no" value="" class="form-control employee_contact_no" placeholder="Contact Number" autocomplete="off">
							</div>
							<div class="form-group">
							    <label for="inputEmail3" class="control-label">Email <span class="text-danger">*</span></label>
								<input type="text" name="employee_email" value="" class="text-lowercase form-control employee_email" placeholder="Email Address" autocomplete="off">
							</div>
						</div>
						<div class="col-md-6 right">
							<div class="form-group">
							    <label for="inputEmail3" class="control-label">Address <span class="text-danger">*</span></label>
								<textarea name="employee_address" cols="10" rows="1" class="form-control employee_address" maxlength="300" placeholder="employee Address"></textarea>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="control-label">type <span class="text-danger">*</span></label>
								<textarea name="employee_type" cols="10" rows="1" class="form-control employee_type" maxlength="300" placeholder="employee type"></textarea>
							</div>
							<div class="form-group">
							    <label for="inputEmail3" class="control-label">int balance <span class="text-danger">*</span></label>
								<input type="text" name="int_balance" value="" class="form-control int_balance" placeholder="int_balance" autocomplete="off">
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
    <form id="employeeupdate" action="<?php echo base_url();?>employee/update" method="post" class="form-horizontal">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <div class="row">
	        	<div class="col-md-6">
	        		<h3 class="modal-title" id="EditModelLabel">Edit employee</h3>
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
						<input type="hidden" name="employee_id" id="employee_id">
		 				<div class="form-group">
							<label class="form-control-label">employee Name <span class="text-danger">*</span></label>
							<input type="text" name="employee_name" value="" class="form-control" id="employee_name" placeholder="employee Name" autocomplete="off">
						</div>
						<div class="form-group">
							<label class="form-control-label">employee address <span class="text-danger">*</span></label>
							<textarea name="employee_address" cols="10" rows="2" class="form-control" id="employee_address" maxlength="100" placeholder="employee address"></textarea>
						</div>
						<div class="form-group">
							<label class="form-control-label">employee contact no <span class="text-danger">*</span></label>
							<input type="text" name="employee_contact_no" value="" class="form-control" id="employee_contact_no"placeholder="employee contact no" autocomplete="off">
						</div>
					</div>
					<div class="col-md-6 right">
						<div class="form-group">
							<label class="form-control-label">employee Email <span class="text-danger">*</span></label>
							<input type="text" name="employee_email" value="" class="form-control text-lowercase" id="employee_email" placeholder="employee Email" autocomplete="off">
						</div>
						<div class="form-group">
							<label class="form-control-label">employee type <span class="text-danger">*</span></label>
							<input type="text" name="employee_type" value="" class="form-control" id="employee_type" placeholder="employee type" autocomplete="off">
						</div>
						<div class="form-group">
						    <label for="inputEmail3" class="control-label">int balance <span class="text-danger">*</span></label>
							<input type="text" name="int_balance" value="" class="form-control" id="int_balance" placeholder="int_balance" autocomplete="off">
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


