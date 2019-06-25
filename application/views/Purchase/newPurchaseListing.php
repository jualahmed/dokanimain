<?php $this->load->view('include/header_for_new_sale'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<style type="text/css">
	table.reduce_space tr td{
		padding 	: 5px;
	}
	.custom_form_control{
		height 			: 30px;
		border-radius 	: 0px;
	}
	.css_for_search_by_name{
      height      	: 250px;
      width       	: 250px; 
      overflow-y  	: auto;
      overflow-x  	: hidden;
      font-size   	: 12px;
      background  	: white;
      padding 		: 0px 1px;
      margin 		: 0px;
    }
    .css_for_search_by_barcode{
      height      : 250px;
      width       : 250px; 
      overflow-y  : auto;
      overflow-x  : hidden;
      font-size   : 12px;
      background  : white;
    }
    .ui-widget-content .ui-state-focus{
      background    : #ff8a00;
      color         : black;
      font-weight   : normal;
    }
    .css_for_cursor{
    	cursor 	: pointer;
    }

    /*-------------*/

    /*-------------*/

.wrap {
    width: 100%;
	margin:0px 0px 0px 0px;
}
.wrap table {
    width: 100%;
    table-layout: fixed;
}
table tr td {
    padding: 5px;
    border: 1.5px solid #ecf0f5;
    width: 100px;
    word-wrap: break-word;
	background: white;
}
table.head tr td {
    color:white;
	background: #0f77ab;
	font-size:11px;
	font-weight:bold;
}

.new_data_2 tr:nth-child(even) td {
    background-color: #e4f1ff;
}
.new_data_2 tr:nth-child(odd) td {
    background-color: #fff;
}
.inner_table {
    height: 410px;
	width: 100%;
	font-size:11px;
    overflow-y: auto !important;
}
.inner_table::-webkit-scrollbar {
    width: 8px;
	background-color: #2d3335;
}

.inner_table::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: white;
}

.inner_table::-webkit-scrollbar-thumb {
   background-color: #448ca6;
   background-image: -webkit-linear-gradient(45deg,rgba(255, 255, 255, .2) 25%,transparent 25%,transparent 50%,rgba(255, 255, 255, .2) 50%,rgba(255, 255, 255, .2) 75%,transparent 75%,transparent)

}
</style>
<?php 

	$this->load->config('custom_config'); 
	$value_added_tax = $this->config->item('VAT');
	$allow_negative_stock = $this->config->item('allow_negative_stock');
	$tp_price_purchase = $this->config->item('tp_price_purchase');
	$tp_price_vat_purchase = $this->config->item('tp_price_vat_purchase');
	//$value_added_tax = 0;

?>
<div class="content-wrapper">
    <section class="content"> 
	    <div class="row">
	      	<div class="col-md-6">
		        <div class="box">
		            <div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Purchase Listing</h3>
					</div>
		            <div class="box-body">
						<table class="table table-bordered reduce_space" >
			            	<tbody>
			            		<tr style="">
			            			<td style="width: 25%;vertical-align:middle;font-weight:bold;background-color:#ecf0f5;">Select Receipt</td>
			            			<td colspan="3">
			            				<select class="form-control select2" id="purchase_receipt_id" style="width:100%;background-color:#ecf0f5;">
											<!--option selected="selected"></option-->
											<?php foreach($purchase_receipt_info as $ind => $tmp){?><option value="<?php echo $ind; ?>"><?php echo $tmp; ?></option><?php }?>
										</select>
			            			</td>
			            		</tr>
			            	</tbody>
			            </table>
						<table class="table table-bordered reduce_space" >
			            	<tbody id="general_info">
								<tr>
			            			<td style="width: 25%;vertical-align:middle;background-color:#ecf0f5;">Distributor Name</td>
			            			<td colspan="3" style="background-color:#ecf0f5;">
			            				
			            			</td>
			            		</tr>
			            		<tr>
			            			<td style="vertical-align:middle;background-color:#ecf0f5;"> Receipt ID </td>
			            			<td style="width: 25%;background-color:#ecf0f5;">
			            				
			            			</td>
			            			<td style="width: 25%;vertical-align:middle;background-color:#ecf0f5;">
			            				Purchase Date 
			            			</td>
			            			<td style="background-color:#ecf0f5;">
			            				
			            			</td>
			            		</tr>
			            		<tr>
			            			<td style="vertical-align:middle;background-color:#ecf0f5;">Purchase Price</td>
			            			<td style="background-color:#ecf0f5;">
			            				
			            			</td>
			            			<td style="vertical-align:middle;background-color:#ecf0f5;">Discount</td>
			            			<td style="background-color:#ecf0f5;">
			            				
			            			</td>
			            		</tr>
			            		<tr>
			            			<td style="vertical-align:middle;background-color:#ecf0f5;">Grand Total</td>
			            			<td style="background-color:#ecf0f5;">
			            				
			            			</td>
			            			<td style="vertical-align:middle;background-color:#ecf0f5;">Transport Cost</td>
			            			<td style="background-color:#ecf0f5;">
			            				
			            			</td>
			            		</tr>
			            	</tbody>
			            </table>
						<br>
						
						<div class="form-group">
							<div class="col-sm-6">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-fw fa-barcode" style="color: #2aabd2;"></i></span>
									<input type="text" class="form-control input-sm" id="search_by_barcode" style="border-radius: 0px;" placeholder="Search By Barcode">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-fw fa-search"></i></span>
									<input type="text" class="form-control input-sm" id="search_by_name" style="border-radius: 0px;" placeholder="Search By Product Name" autofocus="on">
									<span class="input-group-btn">
										<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#show_product_add_modal"> <i class="fa fa-plus"></i></button>
									</span>
								</div>
							</div>
						</div>
						
						<input type="hidden" id="" >
		              	<br>
		              	<form id="product_listing_form">
			              	
			              	<input type="hidden" id="product_name" >
			              	<input type="hidden" id="product_id" >
			              	<input type="hidden" id="pur_rec_id" >
			              	<input type="hidden" id="grand_total" >
			              	<input type="hidden" id="total_purchase_amount" >
			              	<input type="hidden" id="product_specification" >

			              	<table class="table table-bordered reduce_space">
			              		<tbody>
			              			<tr>
			              				<td style="width: 25%; vertical-align: middle;" >
			              					Quantity:
			              				</td>
			              				<td>
			              					<input type="" class="form-control custom_form_control quantity" id="quantity" name="" placeholder="Ex: 10" autocomplete="off" required>
			              				</td>
			              				<td style="width: 25%; vertical-align: middle;">Expire Date:</td>
			              				<td>
			              					<input type="text" id="datepicker" class="form-control custom_form_control" name="" placeholder="Ex: 14-12-2016" autocomplete="off">
			              				</td>
			              			</tr>
									<?php 
										if($tp_price_purchase!=0 && $tp_price_vat_purchase!=0)
										{
									?>
									<tr>
			              				<td style="width: 25%; vertical-align: middle;" >
			              					TP:
			              				</td>
			              				<td>
			              					<input type="" class="form-control custom_form_control tp_total" style="text-align: right;" id="tp_total" name="" placeholder="Ex: 10" autocomplete="off">
			              				</td>
			              				<td style="width: 25%; vertical-align: middle;">VAT:</td>
			              				<td>
			              					<input type="" class="form-control custom_form_control vat_total" style="text-align: right;" id="vat_total" name="" placeholder="Ex: 10" autocomplete="off">
			              				</td>
			              			</tr>
										<?php } ?>
			              			<tr>
			              				<td style="vertical-align: middle;">
			              					Total Buy Price:
			              				</td>
			              				<td>
			              					<input  class="form-control custom_form_control total_buy_price" style="text-align: right;" id="total_buy_price" >
			              				</td >
			              				<td style="vertical-align: middle;">General Sale Price:</td>
			              				<td style="text-align: right;">
			              					<input type="" class="form-control custom_form_control" style="text-align: right;" id="general_sale_price" placeholder="Ex: 15" autocomplete="off" required>
			              				</td>
			              			</tr>

			              			<tr>
			              				<td style="vertical-align: middle;">
			              					Unit Buy Price:
			              				</td>
			              				<td>
			              					<input type="" class="form-control custom_form_control" style="text-align: right;" id="unit_buy_price_purchase" placeholder="Ex: 10" autocomplete="off">
			              				</td>
			              				<td style="width: 20%; vertical-align: middle;">Exclusive Sale Price:</td>
			              				<td>
			              					<input type="" class="form-control custom_form_control" style="text-align: right;" id="exclusive_sale_price" autocomplete="off" placeholder="Ex: 12">
			              				</td>
			              			</tr>
			              		</tbody>
			              	</table>
							<div class="box-footer" style="background: #0f77ab;">
								<center>
									<div class="col-sm-22">
										<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit"><i class="fa fa-fw fa-save"></i> Create</button>
										<button type="reset" id="reset" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-refresh"></i> Reset</button>
										<button type="button" id="delete_purchase_invoice" class="btn btn-danger btn-sm"><i class="fa fa-close"></i> Delete</button>
									
									</div>
								</center>
							</div>
		              	</form>
		            </div>
		        </div>
	      	</div>
	      	<div class="col-md-6">
		        <div class="box">
		            <div class="box-body">
			            <div class="wrap">
							<table class="head">
								<tr style="background-color: #2aabd2; color: white;">
									<td style="width: 4%;">No</td>
									<td style="width: 6%;">Pr. ID</td>
									<td style="text-align: left; width: 35%;">Product Name</td>
									<td style="text-align: center; width: 6%;">Qnt.</td>
									<td style="text-align: center;width: 10%;">U.BP</td>
									<td style="text-align: center; width: 10%;">TP.</td>
									<td style="text-align: center; width: 7%;" ><i class="fa fa-fw fa-wrench"></i></td>
								</tr>
							</table>
							<div class="inner_table">
								<table class="new_data_2" id="purchase_products">
								</table>
							</div>
							<table class="head">
								<tr style="background-color: #2aabd2; color: white;">
										<td style="width: 4%;"></td>
										<td style="width: 6%;"></td>
										<td style="width: 35%;"></td>
										<td style="width: 6%;"></td>
										<td style="text-align: center; width: 10%;"></td>
										<td style="text-align: center;width: 10%;">Total</td>
										<td style="text-align: center;width: 10%;"><span id="total_purchase_price_new_final"></span></td>
										<td style="text-align: center; width: 7%;" ></td>
									</tr>
							</table>
						</div>
		            </div>
		        </div>
	      	</div>

	      	<!-- Start: Modal -->
	      	   <div class="modal" id="edit_modal">
		          <div class="modal-dialog" style="width: 60%;">
		          	<form id="edit_modal_form" class="form-horizontal">
			            <div class="modal-content">
			              <div class="modal-header">
			                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                  <span aria-hidden="true">&times;</span></button>
			                <h4 class="modal-title">
			                	<span class="glyphicon glyphicon-edit" style="color: #db8b0b;"></span>
			                	Edit
			                </h4>
			              </div>
			              <div class="modal-body">
			              	<table class="table table-bordered serial_qnt_price" style="display:none;">
			              		<tr>
			              			<td style="vertical-align: middle;">Quantity: </td>
			              			<td>
			              				<input type="text" class="form-control" id="qty" style="text-align: right;" placeholder="Ex: 100" required="on" autocomplete="off">
			              				<input type="hidden" class="form-control" id="pro_hide" style="text-align: right;" placeholder="Ex: 100" required="on" autocomplete="off">
			              				<input type="hidden" class="form-control" id="pro_hide_buy" style="text-align: right;" placeholder="Ex: 100" required="on" autocomplete="off">
			              			</td>
			              		</tr>
			              		<tr>
			              			<td style="vertical-align: middle;">Unit Buy Price: </td>
			              			<td>
			              				<input type="text" class="form-control" id="u_b_p" style="text-align: right;" placeholder="Ex: 10" required="on" autocomplete="off">
			              			</td>
			              		</tr>
			              	</table>
							<div class="inner_table_2 pro_serial_input_for_edit" style="display:none;">
								<table class="table table-bordered pro_serial_input_for_edit_new" id="pro_serial_input_for_edit">
								</table>
							</div>
			              </div>
			              <div class="modal-footer">
			                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			                <input type="submit" class="btn btn-info" id="save_change" style="display:none;" value="Save">
			              </div>
			            </div>
			            <!-- modal-content -->
		            </form>
		          </div>
		          <!-- modal-dialog -->
		        </div>
	      	<!-- End: Modal -->

	    </div>
    </section>
</div>
<div class="modal fade" id="show_product_add_modal" >
	<div class="modal-dialog" style="width:1000px;">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title"><i class="fa fa-plus"></i> Add New Product</h4>
			</div>
			<form id="add_product_form" action="<?php echo base_url(); ?>setup/create_new_product" method="post" autocomplete="off" enctype="multipart/form-data" role="form" class="form-horizontal">
				<div class="modal-body" style="padding: 0px;">
					<div class="col-md-12">
						<div class="box-body">	
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Catagory Name</label>
								<div class="col-sm-4">
									<?php 	
										echo form_dropdown('catagory_name', $catagory_name, '' ,'class="form-control select2 catagory_name" id="catagory_name" style="width: 100%;"tabindex="-1" aria-hidden="true" required="required"');
									?>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label">Custom Name</label>
								<div class="col-sm-4">
									<?php 
										echo form_input('customProductName', '','class ="form-control" id="edValue" onKeyPress="edValueKeyPress()" onKeyUp="edValueKeyPress()" onBlur="checkAvailability()" style="text-transform:uppercase" placeholder="Product New Name" autocomplete="off"');
										
									?>
									<span id="user-availability-status1" style="display:none;"></span>
									<span id="user-availability-status2" style="display:none;"></span>
									<p><img src="<?php echo base_url();?>assets/assets2/LoaderIcon.gif" id="loaderIcon" style="display:none" /></p>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Company Name</label>
								<div class="col-sm-4">
										<?php 	
											echo form_dropdown('company_name', $company_name, '' ,'class="form-control select2 company_name" id="company_name" style="width: 100%;"tabindex="-1" aria-hidden="true" required="required"');
										?>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label">Unit Name</label>
								<div class="col-sm-4">
									<?php 	
										echo form_dropdown('unit_name', $unit_name, '' ,'class="form-control select2 unit_name" style="width: 100%;"tabindex="-1" aria-hidden="true" required="required" id="unit_name"');
									?>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Alarm Level</label>
								<div class="col-sm-4">
									<?php 	
										echo form_input('alarming_stock', '0', 'class= "form-control" id="alarming_stock" autocomplete="off"');
									?>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label">Product Size</label>
								<div class="col-sm-4">
									<?php 
										echo form_input('product_size', '','class ="form-control" placeholder="Product Size" id="product_size" autocomplete="off"');
									?>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Product Barcode</label>
								<div class="col-sm-4">
									<?php 
										$data = $last_id['product_id'];
										echo form_input('barcode', $data, 'class= "form-control barcode_id"  style="text-transform:uppercase" placeholder="'.$data.'" id="barcode_id" autocomplete="off"');	
									?>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label">Product Model</label>
								<div class="col-sm-4">
									<?php 
										echo form_input('product_model', '','class ="form-control" placeholder="N/A" id="product_model" autocomplete="off"');
									?>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-2 control-label">Genral / Warranty </label>
								<div class="col-sm-4">
									<select class="select2 form-control" name="product_specification" style="width:100%;" required="on" id="prospec">
										<option value="">Select Type</option>
										<option value="1" selected>General</option>
										<option value="2">Warranty</option>
									</select>
								</div>
								<label for="inputEmail3" class="col-sm-2 control-label war_peri">Warranty Period(In Month)</label>
								<div class="col-sm-4 war_peri">
									<input type="number" name="product_warranty" class="form-control" placeholder="N/A" id="nine" autocomplete="off">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Save Product</button>
					<button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<script>
	$(document).on('change','#prospec',function (e) 
	{
		var value = $(this).val();
		if(value==2)
		{
			$(".war_peri").show();
		}
		else
		{
			$(".war_peri").hide();
		}
	});	
</script>
<style>
.inner_table_2 
{
    height: 350px;
	width: 100%;
    overflow-y: auto !important;
}
.inner_table::-webkit-scrollbar {
    width: 4px;
	background-color: #2d3335;
}

.inner_table::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: white;
}

.inner_table::-webkit-scrollbar-thumb {
   background-color: #448ca6;
   background-image: -webkit-linear-gradient(45deg,rgba(255, 255, 255, .2) 25%,transparent 25%,transparent 50%,rgba(255, 255, 255, .2) 50%,rgba(255, 255, 255, .2) 75%,transparent 75%,transparent)

}
</style>
<div class="modal fade" id="show_product_individual_add_modal" >
	<div class="modal-dialog" style="width:600px;">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title"><i class="fa fa-plus"></i> <span id="indi_pro_name"></span></h4>
			</div>
			<form id="add_product_serial_form" action="<?php echo base_url();?>setup/create_new_product_serial" method="post" autocomplete="off" enctype="multipart/form-data" role="form" class="form-horizontal">
				<div class="modal-body" style="padding: 0px;">
					<div class="col-md-12">
						<div class="inner_table_2">
						<div class="box-body">	
							<span id="pro_serial_input"></span>
						</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Save Product</button>
					<button type="reset" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<script>
	$(document).ready(function() 
	{
		$('#add_product_form').on('submit', function(service)
		{
			service.preventDefault();
			var submiturl = $(this).attr('action');
			var methods = $(this).attr('method');
			var product_model = $('#product_model').val();
			var barcode_id = $('#barcode_id').val();
			var product_size = $('#product_size').val();
			var alarming_stock = $('#alarming_stock').val();
			var product_type = $('#product_type').val();
			var unit_name = $('#unit_name').val();
			var company_name = $('#company_name').val();
			var customProductName = $('#edValue').val();
			var catagory_name = $('#catagory_name').val();
			var prospec = $('#prospec').val();
			 $.ajax({
				url: submiturl,
				type: methods,
				dataType: 'JSON',
				data: {'catagory_name':catagory_name,'customProductName':customProductName,'company_name':company_name,'unit_name':unit_name,'product_type':product_type,'alarming_stock':alarming_stock,'product_size':product_size,'barcode':barcode_id,'product_model':product_model,'product_specification':prospec},
				success:function(result)
				{
					
					$('#show_product_add_modal').modal('hide');
					$('#product_model').val('');
					$('#barcode_id').val('');
					$('#product_size').val('');
					$('#alarming_stock').val('');
					$('#product_type').val('');
					$('#unit_name').val('');
					$('#company_name').val('');
					$('#edValue').val('');
					$('#catagory_name').val('');
					$('#prospec').val('');
					
					var unit_buy_price          = parseFloat(result.bulk_unit_buy_price);
					var general_sale_price      = parseFloat(result.bulk_unit_sale_price);
					var exclusive_sale_price    = parseFloat(result.general_unit_sale_price);
					$('#unit_buy_price').val(unit_buy_price.toFixed(2));
					$('#general_sale_price').val(general_sale_price.toFixed(2));
					$('#exclusive_sale_price').val(exclusive_sale_price.toFixed(2));
					
					$('#product_name').val(result.product_name);
					$('#search_by_name').val(result.product_name);
					$('#product_id').val(result.product_id);
					$('.quantity').focus();
					
				},
				error: function (jXHR, textStatus, errorThrown) {html("")}
			});
			
		});
	});
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
<p><img src="<?php echo base_url();?>assets2/LoaderIcon.gif" id="loaderIcon" style="display:none" /></p>	  
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
<script>
$('#vat_total').keyup(function(){
	var avg_price = 0.00;
	var vat_total = $(this).val();
	var tp_total = $('#tp_total').val();
	var quant = $('#quantity').val();

	var avg_price = parseFloat(tp_total) + parseFloat(vat_total);
	//alert(avg_price);
	$('#total_buy_price').val(parseFloat(avg_price));
	$('#unit_buy_price_purchase').val(parseFloat(avg_price/quant).toFixed(2));
});
 $('#total_buy_price').keyup(function(){
	var quant = $('#quantity').val();
	var tot_buy_price = $('#total_buy_price').val();

	var avg_price = tot_buy_price/quant;

	$('#unit_buy_price_purchase').val(avg_price);
});

$('#quantity,#unit_buy_price_purchase').keyup(function(){
	var quant = $('#quantity').val();
	var tot_unit_buy_price = $('#unit_buy_price_purchase').val();

	var avg_price = tot_unit_buy_price * quant;
	$('.total_buy_price').val(avg_price.toFixed(2));
});
$(document).ready(function()
{
	var total_final = 0.00;
	$('.total_purchase_price_final').each(function(){
		total_final += parseFloat($(this).text()); 
	});
	$('#total_purchase_price_new_final').html(total_final);
});
</script>
<?php $this->load->view('include/footer_for_purchase_listing'); ?>