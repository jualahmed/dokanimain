<div class="content-wrapper">
	<section class="content-2">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="box">
					<div class="box-header with-border" style="background:#0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">User Modify</h3>
					</div>
					<div class="box-body">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label">User Name</label>
							<div class="col-sm-9">
							
								<?php
									echo form_dropdown('result', $user_info,'', 'onchange="document.location.href=this.options[this.selectedIndex].value;" class="form-control select2" tabindex="-1" aria-hidden="true"');
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
	$segment_3 = $this -> uri -> segment(3);
	if( $segment_3)
	{
	?>
	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box">		
					<?php
						if($change_mood -> num_rows() > 0)
						{
					?> 
						<div class="box-header with-border" style="background:#0f77ab;">
							<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Select Options For <strong><?php echo str_replace('~', ' ',$this -> uri -> segment(3)); ?></strong></h3>
						</div>
					<?php
						}
						else
						{
					?>
						<div class="box-header with-border" style="background:#0f77ab;">
							<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">You Don't have Permission to Change this User</h3>
						</div>
					 <?php
						}
					?>
					
					<form action="<?php echo base_url();?>admin/update_user" method="POST" class="form-horizontal">
					<?php
					 if($change_mood -> num_rows() > 0)
					 foreach ($change_mood -> result() as $field):
						$temp= $field -> id ;
						 echo form_hidden('ch_id', $temp);
					 endforeach;
					 {
					 ?> 
					<div class="box-body">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">User Name</label>
							<div class="col-sm-4">
								<?php 	
									foreach ($change_mood -> result() as $field):
										$temp= $field -> username ;
									endforeach;
									echo form_input('username', set_value('username', $temp), 'class="form-control"');
								?>
							</div>
							<label for="inputEmail3" class="col-sm-2 control-label">Full Name</label>
							<div class="col-sm-4">
								<?php 	
									foreach ($change_mood -> result() as $field):
										$temp= $field -> user_full_name ;
									endforeach;
									echo form_input('user_full_name', set_value('user_full_name', $temp), 'class="form-control"');
								?>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">User Type</label>
							<div class="col-sm-4">
								<?php 	
									foreach ($change_mood -> result() as $field):
												$temp1= $field -> user_type ;
											endforeach;
											
											if($user_type == 'admin')
											{
												$temp = array(
													 $temp1 => $temp1,
													 'manager' => 'Manager',
													 'seller' => 'Seller',
													 'stockist' => 'Stockist'
												 );
											}
											if($user_type == 'manager')
											{
												$temp = array(
												 $temp1 => $temp1,
												 'seller' => 'Seller',
												 'stockist' => 'Stockist'
												 );
											}
											if($user_type == 'superadmin')
											{
												$temp = array(
												 $temp1 => $temp1,
												 'seller' => 'Seller',
												 'stockist' => 'Stockist',
												 'manager' => 'Manager',
												 'admin'   => 'admin',
												 'accountent' => 'Accountent',
												 'superadmin' => 'Superadmin'
												 );
											}
									echo form_dropdown('new_user_type', $temp,'','class="form-control select2" style="width: 100%;" tabindex="-1" aria-hidden="true"');
								?>
							</div>
							<label for="inputEmail3" class="col-sm-2 control-label">Contact No</label>
							<div class="col-sm-4">
								<?php 	
									foreach ($change_mood -> result() as $field):
										$temp= $field -> email ;
									endforeach;
									echo form_input('email', set_value('email', $temp), 'class="form-control"');
								?>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">New Password</label>
							<div class="col-sm-4">
								<input type="password" class="form-control">
							</div>
							<label for="inputEmail3" class="col-sm-2 control-label">Confirm Password</label>
							<div class="col-sm-4">
								<input type="password" class="form-control" placeholder="Confirm Password">
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">User Address</label>
							<div class="col-sm-10">
								<?php 
									foreach ($change_mood -> result() as $field):
										$temp= $field -> user_address ;
									endforeach;
									$user_address = array(
										'name'	=> 'user_address',
										'id'	=> 'user_address',
										'value'	=> set_value('user_address',$temp),
										'rows' => 2,
										'maxlength'	=> 100,
										'size'	=> 50,
									);
									echo form_textarea($user_address,'','class="form-control" autocomplete="off"');
								?>
							</div>
						</div>
					</div>
					<div class="box-footer" style="background: #0f77ab;">
						<center>
							<div class="col-sm-22">
								<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i> Update</button>
							</div>
						</center>
					</div>
					</form>
				</div>

				
				 <?php
				 }
				 ?>
			</div>
		</div>
	</section>
	<?php  
	   }		
	?>
</div>
