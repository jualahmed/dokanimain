
<div class="content-wrapper" id="vuejsapp">
	<section class="content text-right">
		<!-- Button trigger modal -->
		<div class="text-left">
		<?php if($this->session->flashdata('success')){ ?>
		   <div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success'); ?></div>
		<?php } ?>
		</div>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
		  <i class="fa fa-plus"></i> Create a new distributor
		</button>
		<br>
		<br>
		<table class="table table-bordred table-striped" align="left">
			<tr align="left">
				<th>No.</th>
				<th>distributor name</th>
				<th>distributor description</th>
				<th>distributor address</th>
				<th>distributor contact no</th>
				<th>int balance</th>
				<th>distributor email</th>
				<th align="center">Action</th>
			</tr>
			<tr v-for="(r,index) in result[0]" align="left"> 
				<td>{{ row+index+1 }}</td>
				<td>{{ r.distributor_name }}</td>
				<td>{{ r.distributor_description }}</td>
				<td>{{ r.distributor_address }}</td>
				<td>{{ r.distributor_contact_no }}</td>
				<td>{{ r.int_balance }}</td>
				<td>{{ r.distributor_email }}</td>
				<td>
					<a data-toggle="modal" :distributor_id="r.distributor_id" data-target="#EditModel" class="btn edit btn-sm btn-success" ><i class="fa fa-edit"></i> Edit</a>
					<a onclick="return confirm('Are you sure your want to delete?')" :href="base_url+'distributor/destroy/'+r.distributor_id" class="btn btn-sm btn-danger" >
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
				<div class="box-body">
					<div class="row">
						<div class="col-md-6 left">
							<div class="form-group">
							   <label for="inputEmail3" class="control-label">Name <span class="text-danger">*</span></label>
							   <input type="text" name="distributor_name" value="" class="form-control distributor_name" placeholder="distributor Name" autocomplete="off">
							</div>
							<div class="form-group">
							  	<label for="inputEmail3" class="control-label">Number <span class="text-danger">*</span></label>
								<input type="text" name="distributor_contact_no" value="" class="form-control distributor_contact_no" placeholder="Contact Number" autocomplete="off">
							</div>
							<div class="form-group">
							    <label for="inputEmail3" class="control-label">Email <span class="text-danger">*</span></label>
								<input type="text" name="distributor_email" value="" class="form-control distributor_email text-lowercase" placeholder="Email Address" autocomplete="off">
							</div>
						</div>
						<div class="col-md-6 right">
							<div class="form-group">
							    <label for="inputEmail3" class="control-label">Address <span class="text-danger">*</span></label>
								<textarea name="distributor_address" cols="10" rows="1" class="form-control distributor_address" maxlength="300" placeholder="distributor Address"></textarea>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="control-label">Description <span class="text-danger">*</span></label>
								<textarea name="distributor_description" cols="10" rows="1" class="form-control distributor_description" maxlength="300" placeholder="distributor Description"></textarea>
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
    <form id="distributorupdate" action="<?php echo base_url();?>distributor/update" method="post" class="form-horizontal">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <div class="row">
	        	<div class="col-md-6">
	        		<h3 class="modal-title" id="EditModelLabel">Edit distributor</h3>
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
						<input type="hidden" name="distributor_id" id="distributor_id">
		 				<div class="form-group">
							<label class="form-control-label">distributor Name <span class="text-danger">*</span></label>
							<input type="text" name="distributor_name" value="" class="form-control" id="distributor_name" placeholder="distributor Name" autocomplete="off">
						</div>
						<div class="form-group">
							<label class="form-control-label">distributor address <span class="text-danger">*</span></label>
							<textarea name="distributor_address" cols="10" rows="2" class="form-control" id="distributor_address" maxlength="100" placeholder="distributor address"></textarea>
						</div>
						<div class="form-group">
							<label class="form-control-label">distributor contact no <span class="text-danger">*</span></label>
							<input type="text" name="distributor_contact_no" value="" class="form-control" id="distributor_contact_no" placeholder="distributor contact no" autocomplete="off">
						</div>
					</div>
					<div class="col-md-6 right">
						<div class="form-group">
							<label class="form-control-label">distributor Email <span class="text-danger">*</span></label>
							<input type="text" name="distributor_email" value="" class="form-control text-lowercase" id="distributor_email" placeholder="distributor Email" autocomplete="off">
						</div>
						<div class="form-group">
							<label class="form-control-label">distributor Description <span class="text-danger">*</span></label>
							<input type="text" name="distributor_description" value="" class="form-control" id="distributor_description" placeholder="distributor Description" autocomplete="off">
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


