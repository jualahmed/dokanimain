<div class="content-wrapper">
	<?php 
		if($status != '' )
		{
			if($status == "exists")
			 {
				 echo '<div class="alert alert-warning alert-dismissible" style="background:#f39c12;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-check"></i> Already Exist</h4>
					</div>';
			 }
			else if($status == "successful")
			 {
				 echo '<div class="alert alert-success alert-dismissible" style="background:#00a65a;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-check"></i> Success</h4>
					</div>';
			 }
			else if($status == "failed")
			 {
				 echo '<div class="alert alert-danger alert-dismissible" style="background:#dd4b39;">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<h4><i class="icon fa fa-check"></i> Failed</h4>
					</div>';
			 }
			else
			 {
				 
				 echo validation_errors();
			 }
		}
		$old_password = array(
			'name'	=> 'old_password',
			'id'	=> 'old_password',
			'value' => set_value('old_password'),
			'size' 	=> 30,
		);
		$new_password = array(
			'name'	=> 'new_password',
			'id'	=> 'new_password',
			'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
			'size'	=> 30,
		);
		$confirm_new_password = array(
			'name'	=> 'confirm_new_password',
			'id'	=> 'confirm_new_password',
			'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
			'size' 	=> 30,
		);
	?>
	<section class="content">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="box">
					<div class="box-header with-border" style="background:#0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Password Change</h3>
					</div>
					<form action="<?php echo base_url();?>auth/change_password" class="form-horizontal" method="post">
						<?php
							if(isset($errors[$old_password['name']])?$errors[$old_password['name']]:'' || form_error($new_password['name']) || form_error($confirm_new_password['name'])) 
							{
						?>
							<div class="form_field_seperator">
								<div class = "validation_msg">
									<?php
									 if(isset($errors[$old_password['name']])?$errors[$old_password['name']]:'')
									 {
									 
										echo '<p>'; echo isset($errors[$old_password['name']])?$errors[$old_password['name']]:''; echo '</p>'; 
									 }
									 echo form_error($new_password['name']); 
									 echo form_error($confirm_new_password['name']); 
									?>	  
								 </div>
							</div>
						<?php
							}
						?>
						<div class="box-body">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Old Password</label>
								<div class="col-sm-9">
									<?php
										echo form_password($old_password, '', 'class="form-control" id="one" placeholder="Old Password"');
									?>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">New Password</label>
								<div class="col-sm-9">
									<?php  
										echo form_password($new_password, '', 'class="form-control" id="two" placeholder="New Password"'); 
										echo isset($errors[$new_password['name']])?$errors[$new_password['name']]:'';
									?>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Confirm Password</label>
								<div class="col-sm-9">
									<?php  
										echo form_password($confirm_new_password, '', 'class="form-control" id="three" placeholder="Confirm Password"'); 
										echo isset($errors[$confirm_new_password['name']])?$errors[$confirm_new_password['name']]:'';
									?>
								</div>
							</div>
							<div class="box-footer" style="background: #0f77ab;">
								<center>
									<div class="col-sm-22">
										<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i> Update</button>
									</div>
								</center>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</div>
