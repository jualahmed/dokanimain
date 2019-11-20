<div class="content-wrapper">
	<section class="content" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-12 text-right">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
				  <i class="fa fa-plus"></i> Create a new Bank
				</button>
				<br>
				<br>
				<table class="table table-hover">
					<tr>
						<th>Bank name</th>
						<th>Account</th>
						<th>Account name</th>
					</tr>
					<?php foreach ($all as $value) { ?>
						<tr align="left">
							<td><?php echo $value->bank_name ?></td>
							<td><?php echo $value->bank_account_no ?></td>
							<td><?php echo $value->bank_account_name ?></td>
						</tr>
					<?php } ?>
				</table>
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
				<h3 class="box-title">Bank Entry</h3>
			</div>
			<form action="<?php echo base_url();?>bankcard/create_bank" method="post" id="bank" class="form-horizontal">
				<div class="box-body">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Bank Name <span class="text-danger">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="bank_name" value="" class="form-control" id="bank_name" placeholder="Bank Name" autocomplete="off">
						</div>
					</div>
					<br>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Bank Account No <span class="text-danger">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="bank_account_no" value="" class="form-control" id="bank_account_no" placeholder="Bank Account No" autocomplete="off">
						</div>
					</div>
					<br>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Bank Account Name <span class="text-danger">*</span></label>
						<div class="col-sm-8">
							<input type="text" name="bank_account_name" value="" class="form-control" id="bank_account_name" placeholder="Bank Account Name" autocomplete="off">
						</div>
					</div>
					<br>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label">Bank Description</label>
						<div class="col-sm-8">
							<textarea name="bank_description" cols="40" rows="10" class="form-control" id="four" placeholder="Bank Description" autocomplete="off"></textarea>
						</div>
					</div>
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