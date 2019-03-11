<?php $this -> load -> view('include/header'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<?php
	$shopName = array(
		'name'	=> 'shopName',
		//'id'	=> 'shopName',
		//'value' => set_value('shopName'),
		'maxlength'	=> 100
	);
	$shopType = array(
		'name'	=> 'shopType',
		//'id'	=> 'shopType',
		'class'	=> 'form-control',
		//'value' => set_value('shopType'),
		'maxlength'	=> 8
	);
	$shopAddress = array(
		'name'	=> 'shopAddress',
		//'id'	=> 'shopAddress',
		'class'	=> 'form-control',
		'rows'  => '2',
		'cols'  => '10',
		//'value' => set_value('shopAddress'),
		'maxlength'	=> 300
	);
	$shopContact = array(
		'name'	=> 'shopContact',
		//'id'	=> 'shopContact',
		'class'	=> 'form-control',
		//'value' => set_value('shopContact'),
		'maxlength'	=> 15
	);
?>
<div class="content-wrapper">
    <section class="content-header">
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Setup</a></li>
        <li class="active">Shop Setup</li>
      </ol>
    </section>
	<?php 
		if($status !=''){
			 if($status == "successful")
			 {
				 echo '<div class="box-body">';
				 echo $this->session->flashdata('msg1');
				 echo '</div>';
			 }
			 else if($status = '')
			 {
				 echo '<div class="box-body">';
				 echo 'No New Update';
				 echo '</div>';
			 }
			 else if($status == "failed")
			 {
				 echo '<div class="box-body">';
				 echo $this->session->flashdata('msg2');
				 echo '</div>';
			 }
		 }
	 ?>
	<section class="content" style="margin:20px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-12">
				  <div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title" style="font-family:Sans Pro">Shop Setup</h3>
					</div>
					<?php echo form_open('registration_controller/shop_setup', 'class="form-horizontal" id="form_setup"'); ?>
					  <div class="box-body">
						<?php
							$attributes = array(
									'class' => 'col-sm-2 control-label',
									'style'=>'font-family:Sans Pro'
								);
							echo form_label('Shop Name', '', $attributes);

						?>
						<div class="col-xs-4">
							 <?php 
								echo form_input($shopName, '', 'class="form-control" id="one" placeholder="Shop Name" autocomplete="off"');
								echo form_error($shopName['name'], '<div style="height:27px;width:780px;margin-top:5px;"><p style="text-indent:20px;width:150px;color:red;font-size:12px;margin-top:-1px;font-weight:normal;">','</p></div>'); 
							?> 
						</div>
						<?php
							$attributes = array(
									'class' => 'col-sm-2 control-label',
									'style'=>'font-family:Sans Pro'
								);
							echo form_label('Shop Type', '', $attributes);

						?>
						<div class="col-xs-4">
							 <?php 
								echo form_input($shopType, '', 'class="form-control" id="two" placeholder="Shop Type" autocomplete="off"');
								echo form_error($shopType['name'], '<div style="height:27px;width:780px;margin-top:5px;"><p style="text-indent:20px;width:150px;color:red;font-size:12px;margin-top:-1px;font-weight:normal;">', '</p></div>'); 
							?> 
						</div>
						<br />
						<br />
						<br />
						<?php
							$attributes = array(
									'class' => 'col-sm-2 control-label',
									'style'=>'font-family:Sans Pro'
								);
							echo form_label('Shop Contact', '', $attributes);

						?>
						<div class="col-xs-4">
							 <?php 
								echo form_input($shopContact, '', 'class="form-control" id="three" placeholder="Shop Contact" autocomplete="off"');
								echo form_error($shopContact['name'], '<div style="height:27px;width:780px;margin-top:5px;"> <p style="text-indent:20px;width:150px;color:red;font-size:12px;margin-top:-1px;
								font-weight:normal;">', '</p></div>'); 
							?> 
						</div>
						<?php
							$attributes = array(
									'class' => 'col-sm-2 control-label',
									'style'=>'font-family:Sans Pro'
								);
							echo form_label('Shop Address', '', $attributes);

						?>
						<div class="col-xs-4">
							 <?php 
								echo form_textarea($shopAddress, '', 'class="form-control" id="four" rows="4" placeholder="Shop Address" autocomplete="off"');
								echo form_error($shopAddress['name'], '<div style="height:27px;width:780px;margin-top:5px;"> <p style="text-indent:20px;width:150px;color:red;font-size:12px;margin-top:-1px;
								font-weight:normal;">', '</p></div>'); 
							?> 
						</div>
					  </div>
					  <div class="box-footer">
						<div class="col-sm-1" style="margin:0px 0px 0px 350px;">
								<a href="<?php echo base_url();?>site_controller/main_site" class="btn btn-block btn-danger" style="width:100px;"><i class="fa fa-fw fa-remove"></i> Cancel</a>
						</div>
						<div class="col-sm-1" style="margin:0px 0px 0px 25px;">
							<?php
								//echo form_submit('change', 'Create','class="btn btn-block btn-success col-md-offset-2" id="submit_btn" style="width:135px;"');
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
</div>
<script type="text/javascript">
$(document).ready(function() {
		$("#submit_btn").click(function(event) {
		event.preventDefault();
				alert('ok');
				$('#one').val('');
				$('#two').val('');
				$('#three').val('');
				$('#four').val('');

			}
		});
	});
</script>
<script type="text/javascript">
$(document).ready(function() 
{
	$("#reset_btn").click(function(event) 
	{
		event.preventDefault();
		$('#one').val('');
		$('#two').val('');
		$('#three').val('');
		$('#four').val('');
		$('#lock').val('');
		$('#lock').select2();
		$('#lock3').val('');
		$('#lock3').select2();
		$('#lock4').val('');
		$('#lock4').select2();
		$('#lock5').val('');
		$('#lock5').select2();
		$('#lock55').val('');
		$('#lock55').select2();
		$('#lock66').val('');
		$('#lock6').val('');
		$('#lock6').select2();
		$('#lock').val('');
		$('#lock22').val('');
		$('#lock77').val('');
		$('#lock7').val('');
		$('#lock7').select2();
		$('#datepickerrr').val('');
		$('#datepickerr').val('');
		$('#lock2').val('');
		$('#datep').val('');
		$('#datep2').val('');
		$("#lock2").prop("disabled", false);
		$("#lock22").prop("disabled", false);
		$("#lock").prop("disabled", false);
		$("#lock3").prop("disabled", false);
		$("#lock4").prop("disabled", false);
		$("#lock5").prop("disabled", false);
		$("#lock55").prop("disabled", false);
		$("#lock6").prop("disabled", false);
		$("#lock66").prop("disabled", false);
		$("#lock7").prop("disabled", false);
		$("#lock77").prop("disabled", false);
		$("#datepickerrr").prop("disabled", false);
		$("#datepickerr").prop("disabled", false);	
		$("#datep").prop("disabled", false);	
		$("#datep2").prop("disabled", false);	
	});
});
</script>
<?php $this -> load -> view('include/footer'); ?>