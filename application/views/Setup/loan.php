<div class="content-wrapper">
	<section class="content" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-12 text-right">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
				  <i class="fa fa-plus"></i> Create a new loan
				</button>
				<br>
				<br>
				<!-- <table class="table table-hover">
					<tr>
						<th>Customer name</th>
						<th>Amount</th>
						<th>Date</th>
					</tr>
					<?php foreach ($customer as $value) { ?>
						<tr align="left">
							<td><?php echo $value->customer_name ?></td>
							<td><?php echo $value->customer_account_no ?></td>
							<td><?php echo $value->customer_account_name ?></td>
						</tr>
					<?php } ?>
				</table> -->
			</div>
		</div>
	</section>		
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">customer Entry</h3>
			</div>
			<form action="<?php echo base_url();?>loan/create" method="post" id="customer" class="form-horizontal">
				<div class="box-body">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Customer Name <span class="text-danger">*</span></label>
						<div class="col-sm-8">
							<select name="customer_id" id="" class="form-control" required>
								<option value="">Select A Custoemr</option>
								<?php
									foreach ($customer as $key => $var) {
								?>
								<option value="<?php echo $var->customer_id ?>"><?php echo $var->customer_name ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<br>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Amount <span class="text-danger">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="amount" value="" class="form-control"  placeholder="amount" required autocomplete="off">
						</div>
					</div>
					<br>
					<br>
					<div class="box-footer text-right">
						<div class="col-sm-22">
	       					 <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i> Create</button>
							<button type="reset" id="reset_btn" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-refresh"></i> Reset</button>
						</div>
					</div>
				</div>
			</form>
		</div>
</div>
</div>
</div>