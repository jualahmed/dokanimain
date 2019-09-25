<div class="content-wrapper">
    <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Setup</a></li>
        <li class="active">Shop Setup</li>
      </ol>
    </section>
	<section class="content" style="margin:20px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title" style="font-family:Sans Pro">Shop Setup</h3>
					</div>
					<div class="box-body text-danger"><?php echo validation_errors(); ?></div>
					<form action="<?php echo base_url().'shop/shop_setup' ?>" enctype="multipart/form-data" method="POST">
					  <div class="box-body">
						<div class="col-xs-4">
							<input type="text" name="shopName" value="" maxlength="100" class="form-control" id="one" placeholder="Shop Name" autocomplete="off">
						</div>
						<div class="col-xs-4">
							<input type="text" name="shopType" value="" class="form-control" maxlength="8" id="two" placeholder="Shop Type" autocomplete="off">
						</div>
						<div class="col-xs-4">
							<input type="text" name="shopContact" value="" class="form-control" maxlength="15" id="three" placeholder="Shop Contact" autocomplete="off">
						</div>
						<br>
						<br>
						<br>
						<div class="col-xs-4">
							<textarea name="shopAddress" cols="10" rows="1" class="form-control" maxlength="300" id="four" placeholder="Shop Address" autocomplete="off"></textarea>
						</div>
						<div class="col-xs-4">
							<div class="col-md-2">Logo</div>
							<div class="col-md-10">
								<input type="file" placeholder="logo" class="form-control" name="logo">
							</div>
						</div>
						<div class="col-xs-4">
							<div class="col-md-2">Invoice logo</div>
							<div class="col-md-10">
								<input type="file" placeholder="logo" class="form-control" name="invoicelogo">
							</div>
						</div>
					  </div>
					<div class="box-footer">
						<div class="col-sm-1">
								<a href="<?php echo base_url();?>admin" class="btn btn-block btn-danger" style="width:100px;"><i class="fa fa-fw fa-remove"></i> Cancel</a>
						</div>
						<div class="col-sm-1" style="margin:0px 0px 0px 25px;">
							<?php
								echo '<button type="submit" class="btn btn-block btn-success" style="width:100px;"><i class="fa fa-fw fa-save"></i> Create</button>';
								echo form_close();
							?>
						</div>
						<div class="col-sm-1" style="margin:0px 0px 0px 25px;">
							<button type="reset" id="reset_btn" class="btn btn-block btn-warning" style="width:100px;"><i class="fa fa-fw fa-refresh"></i> Reset</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="content">
		<table class="table table-info">
			<tr>
				<th>Logo</th>
				<th>Invoice logo</th>
				<th>Shop Name</th>
				<th>Shop Address</th>
				<th>Shop Contact</th>
				<th>Action</th>
			</tr>
			<?php foreach ($allshop as $key => $var): ?>
				<tr>
					<td>
						<?php if (!$var->logo==''): ?>
							<img src="<?php echo base_url().'assets/img/shop/'.$var->logo ?>" width="100px">
						<?php else: ?>
							<img src="<?php echo base_url().'assets/img/top_logo2.png' ?>" width="100px">
						<?php endif ?>
					</td>
					<td>
						<?php if (!$var->invoicelogo==''): ?>
							<img src="<?php echo base_url().'assets/img/shop/'.$var->invoicelogo ?>" width="100px">
						<?php else: ?>
							<img src="<?php echo base_url().'assets/img/top_logo2.png' ?>" width="100px">
						<?php endif ?>
					</td>
					<td><?php echo $var->shop_name ?></td>
					<td><?php echo $var->shop_address ?></td>
					<td><?php echo $var->shop_contact ?></td>
					<td>
						<a href="" data-toggle="modal" shop_id="<?php echo $var->shop_id ?>" data-target="#EditModel" class="btn btn-success edit">Edit</a>
						<?php if ($var->shop_id==0): ?>
							<?php continue; ?>
						<?php else: ?>
							<a href="<?php echo base_url().'shop/deleteshop/'.$var->shop_id ?>" class="btn btn-danger">Delete</a>
						<?php endif ?>
					</td>
				</tr>
			<?php endforeach ?>
		</table>
	</section>
</div>


<!-- Edit Modal -->
<div class="modal fade" id="EditModel" tabindex="-1" role="dialog" aria-labelledby="EditModelLabel" aria-hidden="true">
    <form id="shopupdate" action="<?php echo base_url();?>shop/shopupdate" enctype="multipart/form-data" method="post" class="form-horizontal">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <div class="row">
	        	<div class="col-md-6">
	        		<h3 class="modal-title" id="EditModelLabel">Edit Shop</h3>
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
				<input type="hidden" name="shop_id" id="shop_id">
 				<div class="form-group">
					<label class="form-control-label">Shop Name <span class="text-danger">*</span></label>
					<input type="text" name="shop_name" value="" class="form-control shop_name" id="shop_name" placeholder="Shop Name" autocomplete="off">
				</div>
				<div class="form-group">
					<label class="form-control-label">Shop contace</label>
					<input type="text" name="shop_contact" value="" class="form-control" id="shop_contact" maxlength="15" id="three" placeholder="Shop Contact" autocomplete="off">
				</div>
				<div class="form-group">
					<label class="form-control-label">Shop Address</label>
					<input type="text" name="shop_address" value="" class="form-control" maxlength="15" id="shop_address" placeholder="Shop Contact" autocomplete="off">
				</div>
				<div class="form-group">
					<label class="form-control-label">Shop Logo</label>
					<input type="file" placeholder="logo" id="logod" class="form-control" name="logo">
				</div>
				<div class="form-group">
					<label>Invoice logo</label>
					<input type="file" placeholder="logo" id="invoicelogo" class="form-control" name="invoicelogo">
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
