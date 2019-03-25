<?php $this -> load -> view('include/header'); ?>
<script src="<?php echo base_url();?>assets/assets2/custom_script_2.js"></script>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<div class="content-wrapper">
<script>
	 setTimeout(function() {$('.success_new_alert').slideUp("slow");}, 6000);
	 setTimeout(function() {$('.failed_new_alert').slideUp("slow");}, 6000);
	 setTimeout(function() {$('.exist_new_alert').slideUp("slow");}, 6000);
	 setTimeout(function() {$('.error_new_alert').slideUp("slow");}, 6000);
</script>
<?php
$result = $this->uri->segment(3);
if($result!='')
{
	if($result=='success')
	{
		echo '<div class="alert success_new_alert" role="alert" style="text-align:right;width: 235px;float: right;border-color: #ffffff;background-color:#96e6c2;margin-bottom: 0px;">
				  <span style="text-align:center;color: #1e456d;">Product <strong>Successfully</strong> Listed.</span>
				</div>';
	}
	else if($result=='failed')
	{
		echo '<div class="alert failed_new_alert" role="alert" style="text-align:right;width: 300px;float: right;border-color: #ffffff;background-color:#f9b977;margin-bottom: 0px;">
				  <span style="text-align:center;color: #1e456d;"><strong>Something Wrong</strong> with Product Setup.</span>
				</div>';
	}
	else if($result=='exist')
	{
		echo '<div class="alert exist_new_alert" role="alert" style="text-align:right;width: 280px;float: right;border-color: #ffffff;background-color:rgb(42, 211, 203);margin-bottom: 0px;">
				  <span style="text-align:center;color: #1e456d;"><strong>This Product</strong> is already been Exist.</span>
				</div>';
	}
	else if($result=='error')
	{
		echo '<div class="alert error_new_alert" role="alert" style="text-align:right;width: 230px;float: right;border-color: #ffffff;background-color:rgb(255, 132, 132);margin-bottom: 0px;">
				  <span style="text-align:center;color: #1e456d;"><strong>Error found</strong> in Product setup.</span>
				</div>';
	}
}
?>
<style>
 .box2{
	 background: #ffffff none repeat scroll 0 0;
    border-radius: 3px;
    border-top: 3px solid #d2d6de;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    position: relative;
    width: 135%;
	 
	 
 }
 .box2-info{
 border-top-color: #00c0ef;
 }

</style>

	<section class="content" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Product Setup</h3>
					</div>
					<form action="<?php echo base_url();?>setup/create_product" method="post" class="form-horizontal" enctype="multipart/form-data">
						<div class="box-body">	
							<input type="hidden" name="product_specification" value="bulk" />
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Catagory Name</label>
								<div class="col-sm-4">
									<div class="input-group input-group-md">
										<?php 	
											echo form_dropdown('catagory_name', $catagory_name, '' ,'class="form-control select22 catagory_name" id="one" style="width: 100%;"tabindex="-1" aria-hidden="true" required="required"');
										?>
										<span class="input-group-btn">
											<button type="button" style="margin-bottom: 6px;" class="btn btn-block btn-primary add_category"> <i class="fa fa-plus"></i></button>
										</span>
									</div>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label">Product Name(E)</label>
								<div class="col-sm-4">
									<?php 
										echo form_input('customProductName', '','class ="form-control" id="edValue" onKeyPress="edValueKeyPress()" onKeyUp="edValueKeyPress()" onBlur="checkAvailability()" style="text-transform:uppercase" placeholder="Product Name English" autocomplete="off"');
										
									?>
									<span id="user-availability-status1" style="display:none;"></span>
									<span id="user-availability-status2" style="display:none;"></span>
									<p><img src="<?php echo base_url();?>assets/assets2/LoaderIcon.gif" id="loaderIcon" style="display:none" /></p>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Company Name</label>
								<div class="col-sm-4">
									<div class="input-group input-group-md">
										<?php 	
											echo form_dropdown('company_name', $company_name, '' ,'class="form-control select33 company_name" id="three" style="width: 100%;"tabindex="-1" aria-hidden="true" required="required"');
										?>
										
										<span class="input-group-btn">
											<button type="button" style="margin-bottom: 6px;" class="btn btn-block btn-primary add_company"> <i class="fa fa-plus"></i></button>
										</span>
									</div>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label">Unit Name</label>
								<div class="col-sm-4">
									<div class="input-group input-group-md">
										<?php 	
											echo form_dropdown('unit_name', $unit_name, '' ,'class="form-control select44 unit_name" required="required" id="four"');
										?>
										
										<span class="input-group-btn">
											<button type="button" style="margin-bottom: 6px;" class="btn btn-block btn-primary add_unit"> <i class="fa fa-plus"></i></button>
										</span>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Product Model</label>
								<div class="col-sm-4">
									<?php 
										echo form_input('product_model', '','class ="form-control" placeholder="N/A" id="nine" autocomplete="off"');
									?>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label">Alarm Level</label>
								<div class="col-sm-4">
									<?php 	
										echo form_input('alarming_stock', '0', 'class= "form-control" id="six" autocomplete="off"');
									?>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Product Size</label>
								<div class="col-sm-4">
									<?php 
										echo form_input('product_size', '','class ="form-control" placeholder="Product Size" id="seven" autocomplete="off"');
									?>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label">Product Barcode</label>
								<div class="col-sm-4">
									<?php 
										$data = $last_id['product_id'];
										echo form_input('barcode', $data, 'class= "form-control barcode_id"  style="text-transform:uppercase" placeholder="'.$data.'" id="eight" autocomplete="off"');	
										'<!--span id="lblValue" style="text-transform:uppercase"></span-->'
									?>
								</div>
								
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Product Name(B)</label>
								<div class="col-sm-4">
									<?php 
										echo form_input('product_name_bng', '','class ="form-control" placeholder="Product Name Bangla" autocomplete="off"');
										
									?>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label">Product Image</label>
								<div class="col-sm-4">
									<input type="file" name="user_file_3" id="photo" class="form-control">
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
<script type="text/javascript">
$(document).ready(function() {
	$("#reset_btn").click(function(event) {
			event.preventDefault();
			$('#one').val('');
			$('#one').select2();
			$('#three').val('');
			$('#three').select2();
			$('#four').val('');
			$('#four').select2();
			$('#edValue').val('');
			$('#five').val('');
			$('#six').val('');
			$('#seven').val('');
			$('#eight').val('');
			$('#nine').val('');
			//$('#one').val('');
		$('#two').val('');
		//$('#three').val('');
		//$('#four').val('');
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
<script>
 function edValueKeyPress()
    {
        var edValue = document.getElementById("edValue");
        var length=$('#edValue').val();
        if(length.length >=4){
			var s = length.substring(0, 4); 
		}
		else{
			var s = edValue.value;
		}
			

        //var lblValue = document.getElementById("lblValue");
		var br_code = s+<?php echo $data;?>;
        //lblValue.innerText = "The text box contains: "+s+<?php echo $data;?>;
		
		$(".barcode_id").val(br_code); 
		
    }
</script>


<!--div id="frmCheckUsername">
  <label>Check Product:</label>
  <input name="username" type="text" id="username" class="demoInputBox" onBlur="checkAvailability()" autocomplete="off">
  <span id="user-availability-status"></span> 
<p><img src="<?php echo base_url();?>assets/assets2/LoaderIcon.gif" id="loaderIcon" style="display:none" /></p>	  
</div-->

<style>
#user-availability-status1{color:#2FC332;}
#user-availability-status2{color:#D60202;}
</style>

<script>
 $(document).ready(function() {
    $('#edValue').keyup(function(){
     var length=$('#edValue').val().length;
      if(length>1){
		  $('#submit_btn').attr('disabled', true);
	  }
	  if(length==0){
		$('#submit_btn').removeAttr('disabled',false);
		$("#user-availability-status1").hide();
		$("#user-availability-status2").hide()
      }
     });
});
	
function checkAvailability() {
	$("#loaderIcon").show();
	$.ajax({
	url: "<?php echo base_url();?>product_controller/check_product",
	data:'customProductName='+$("#edValue").val(),
	type: "POST",
	success:function(data){
		if(data == 'Product Name Available') 
		{
			$('#submit_btn').removeAttr('disabled',false);
			$("#user-availability-status1").html(data).show();
			$("#user-availability-status2").html(data).hide()
			$("#loaderIcon").hide();
		}
		else if (data == 'Product Name Not Available') 
		{
			$('#submit_btn').attr('disabled', true);
			$("#user-availability-status2").html(data).show();
			$("#user-availability-status1").html(data).hide();
			$("#loaderIcon").hide();
		}
	}
	});
}
</script>	
<div class="modal fade" id="show_rate_typ_modal" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> Add New Category</h4>
      </div>
      <form id="add_category_form" action="<?php echo base_url(); ?>extra_controller/create_catagory" method="post" autocomplete="off" enctype="multipart/form-data" role="form">
      <div class="modal-body">
        <div class="input-group input-group-sm">
          <span class="input-group-addon">Category Name</span>
          <input name="catagory_name" type="text" class="form-control cate_name" style="text-transform:uppercase" placeholder="Category Name" required="required" />
        </div>
		<div class="separator10"></div>
		<div class="input-group input-group-sm">
			<span class="input-group-addon">Category Description</span>
            <div class="control-label">  
				<textarea name="catagory_description" value="N/A" required="required" class="input-xlarge" id="textarea" rows="2">N/A</textarea>  
            </div> 
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save Category</button>
        <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="show_group_modal" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> Add New Group</h4>
      </div>
      <form id="add_group_form" action="<?php echo base_url(); ?>extra_controller/create_group" method="post" autocomplete="off" enctype="multipart/form-data" role="form">
      <div class="modal-body">
        <div class="input-group input-group-sm">
          <span class="input-group-addon">Group Name</span>
          <input name="group_name" type="text" class="form-control grou_name" style="text-transform:uppercase" placeholder="Group Name"  />
        </div>
		<div class="separator10"></div>
		<div class="input-group input-group-sm">
			<span class="input-group-addon">Group Description</span>
            <div class="control-label">  
				<textarea name="group_description" value="N/A"  class="input-xlarge" id="textarea" rows="2">N/A</textarea>  
            </div> 
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save Group</button>
        <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>



<div class="modal fade" id="add_company_modal" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> Add New Company</h4>
      </div>
      <form id="add_company_form" action="<?php echo base_url(); ?>extra_controller/create_company" method="post" autocomplete="off" enctype="multipart/form-data" role="form">
      <div class="modal-body">
        <div class="input-group input-group-sm">
          <span class="input-group-addon">Company Name</span>
          <input name="company_name" type="text" class="form-control comp_name" style="text-transform:uppercase" placeholder="Company Name" required="required" />
        </div>
		<div class="separator10"></div>
        <div class="input-group input-group-sm">
          <span class="input-group-addon">Phone Number</span>
          <input name="company_contact_no" type="text" class="form-control" value="01589632541" placeholder="Phone Number"  />
        </div>
		<div class="separator10"></div>
		<div class="input-group input-group-sm">
          <span class="input-group-addon">Email Address</span>
          <input name="company_email" type="text" value="demo@gmail.com" class="form-control"  />
        </div>
		<div class="separator10"></div>
		<div class="input-group input-group-sm">
          <span class="input-group-addon">Company Address</span>
			<div class="control-label">  
				<textarea name="company_address" class="input-xlarge" value="N/A" id="textarea" rows="2" value="N/A">N/A</textarea>  
            </div> 
        </div>
		<div class="separator10"></div>
		<div class="input-group input-group-sm">
          <span class="input-group-addon">Description</span>
		  <textarea name="company_description" class="input-xlarge" id="textarea" rows="2" value="N/A" >N/A</textarea>  
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save Company</button>
        <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>


<div class="modal fade" id="show_unit_typ_modal" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> Add New Unit</h4>
      </div>
      <form id="add_unit_form" action="<?php echo base_url(); ?>extra_controller/create_unit" method="post" autocomplete="off" enctype="multipart/form-data" role="form">
      <div class="modal-body">
        <div class="input-group input-group-sm">
          <span class="input-group-addon">Unit Name</span>
          <input name="unit_name" type="text" class="form-control uni_name" placeholder="Unit Name" required="required" />
        </div>
		<div class="separator10"></div>
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save Unit</button>
        <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="add_distributor_modal"  role="dialog" style="z-index: 1600;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> Add New Distributor</h4>
      </div>
      <form id="add_distributor_form" action="<?php echo base_url(); ?>extra_controller/create_distributor" method="post" autocomplete="off" enctype="multipart/form-data" role="form">
      <div class="modal-body">
        <div class="input-group input-group-sm">
          <span class="input-group-addon">Distributor Name</span>
          <input name="distributor_name" type="text" class="form-control distr_name" placeholder="Distributor Name" required="required" />
        </div>
		<div class="separator10"></div>
        <div class="input-group input-group-sm">
          <span class="input-group-addon">Phone Number</span>
          <input name="distributor_contact_no" type="text" class="form-control" value="01589632541" placeholder="Phone Number"  />
        </div>
		<div class="separator10"></div>
		<div class="input-group input-group-sm">
          <span class="input-group-addon">Email Address</span>
          <input name="distributor_email" type="text" value="demo@gmail.com" class="form-control"  />
        </div>
		<div class="separator10"></div>
		<div class="input-group input-group-sm">
          <span class="input-group-addon">Distributor Address</span>
			<div class="control-label">  
				<textarea name="distributor_address" class="input-xlarge" value="N/A" id="textarea" rows="2" placeholder="Distributor Address"></textarea>  
            </div> 
        </div>
		<div class="separator10"></div>
		<div class="input-group input-group-sm">
          <span class="input-group-addon">Description</span>
		  <textarea name="distributor_description" class="input-xlarge" id="textarea" rows="2" value="N/A" >N/A</textarea>  
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save Distributor</button>
        <button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>


<script>
	//$('#tot_prrice,#tot_qquantity').keyup(function(){
	$('#tot_prrice').keyup(function(){
		var quant = $('#tot_qquantity').val();
		var tot_price = $('#tot_prrice').val();
		
		var avg_price = tot_price/quant;
		
		$('#byu_price').val(avg_price);
	});
	
	
	
	$('#tot_sale_price').keyup(function(){
		var quant = $('#tot_qquantity').val();
		var tot_price = $('#tot_sale_price').val();
		
		var avg_price = tot_price/quant;
		
		$('#uni_slae_pric').val(avg_price);
	});
</script>
</div>
<?php $this -> load -> view('include/footer'); ?>