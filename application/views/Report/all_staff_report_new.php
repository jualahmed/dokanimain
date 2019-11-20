<div class="content-wrapper">
	<section class="content-3">
		<div class="row">
			<div class="col-md-12">
				<div class="box">	
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Staff List</h3>
						<a href="<?php echo base_url();?>Report/download_staff_list" id="down" style="width:100px;" target="_blank" class="btn btn-primary btn-sm pull-right"><i class="fa fa-download"></i> Download</a>
					</div>
					<div class="box-body">
						<div class="wrap">
							<table class="head">
								<tr>
								  <td>SL No</td>
								  <td>Staff ID</td>
								  <td>Staff Name</td>
								  <td>Address</td>
								  <td>Contact</td>
								  <td>Type</td>
								  <td style="text-align:center;">Action</td>
								</tr>
							</table>
							<div class="inner_table" id="search_data">
							<table class="new_data_2">
							<?php 
							
								$index=1;
								foreach($all_staff->result() as $field)
								{
							?>
								<tr>
								  <td><?php echo $index;?></td>
								  <td><?php echo $field->employee_id;?></td>
								  <td><?php echo $field->employee_name;?></td>
								  <td><?php echo $field->employee_address;?></td>
								  <td><?php echo $field->employee_contact_no;?></td>
								  <td><?php echo $field->employee_type;?></td>
								  <td style="text-align:center;"><a class="btnEdit" style="cursor:pointer;"><i class="fa fa-fw fa-edit"></i></a></td>
								</tr>
								
								<?php
								$index++;
								}
								?>
							</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</section>
</div>
