
<div class="content-wrapper">
	<section class="content" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Category Setup</h3>
					</div>
					<form action="<?php echo base_url();?>category/create" method="post" class="form-horizontal">
						<div class="box-body">
							<div class="form-group">
								<label for="inputPassword3" class="col-sm-3 control-label">Category Name</label>
								<div class="col-sm-7">
									<?php 
								
										echo form_input('catagory_name', '','class="form-control" id="one" style="text-transform:uppercase" placeholder="Category Name" autocomplete="off"');
									?>
								</div>
							</div>
							<div class="form-group">
								<label for="inputPassword3" class="col-sm-3 control-label">Category Description</label>
								<div class="col-sm-7">
									<?php 
										$catagoryDescription = array(
											'name'	=> 'catagory_description',
											'id'	=> 'catagory_description',
											'class'	=> 'form-control',
											'rows'  => '2',
											'cols'  => '10',
											'maxlength'	=> 100
										);
										 echo form_textarea($catagoryDescription, '', 'class="form-control" rows="4" placeholder="Category Description"');
									?> 
								</div>
							</div>
						</div>
						<div class="box-footer" style="background: #0f77ab;">
							<center>
								<div class="col-sm-22">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i> Create</button>
									<button type="reset" id="reset_btn" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-refresh"></i> Reset</button>
								
								</div>
							</center>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</div>

