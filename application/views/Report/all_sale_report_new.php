<?php $this -> load -> view('include/header_for_new_sale'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<div class="content-wrapper">
<style>
.form-control-2{
	border-color: #d2d6de;
    border-radius: 0;
    box-shadow: none;
	background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
    color: #555;
    display: block;
    font-size: 14px;
    height: 34px;
    line-height: 1.42857;
    padding: 6px 14px;
    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
    width: 100%;
}

.content-2{
    margin-left: auto;
    margin-right: auto;
    min-height: 2px;
    padding: 4px;
}

.wrap {
    width: 100%;
	margin:0px 0px 0px 0px;
}
.wrap table {
    width: 100%;
    table-layout: fixed;
}
.wrap-11 {
    width: 100%;
	margin:0px 0px 0px 0px;
}
.wrap-11 table {
    width: 100%;
    table-layout: fixed;
}
table .new_data tr td {
    border: 1.5px solid #ffe8e8;
	background: white;
}
table tr td {
    padding: 5px;
    border: 1.5px solid #ffe8e8;
    width: 100px;
    word-wrap: break-word;
	background: white;
}
table.head tr td {
    color:white;
	background: #4d89a7;
	font-size:14px;
	font-family:Sans Pro; 
	font-weight:bold;
}

.new_data_2 tr:nth-child(even) td {
    background-color: #e4f1ff;
}
.new_data_2 tr:nth-child(odd) td {
    background-color: #fff;
}
.inner_table {
	color:#666768;
    height: 250px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    overflow-y: auto !important;
}

.inner_table22 {
	color:#666768;
    height: 280px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    overflow-y: auto !important;
}
.inner_table_2 {
	color:#403e3e;
    height: 33px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
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
.modalads3423
{
	position: fixed;
	z-index: 999;
	height: 100%;
	width: 100%;
	top: 0;
	left: 0;
	background-color: white;
	filter: alpha(opacity=60);
	opacity: 0.6;
	-moz-opacity: 0.8;
}
.center
{
	z-index: 1000;
	margin: 300px auto;
	width: 350px;
	border-radius: 10px;
	filter: alpha(opacity=100);
	opacity: 1;
	-moz-opacity: 1;
}
.center img
{
	margin:0px 0px 0px 100px;
}

.content2{
	min-height: 130px;
	padding: 1px;
}
</style>
	<section class="content-2" style="margin:0px 0px 0px 0px;">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Sale Report</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>report_controller/all_sale_report_find" class="form-horizontal" method="post" enctype="multipart/form-data" id="form_4" autocomplete="off">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Invoice</label>
								<div class="col-sm-2">
									<?php 
										echo form_input('invoice_id','','class ="form-control one" id="lock" placeholder="Inovice ID" title="Inovice ID" autocomplete="off" autofocus="on"');
									?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Product</label>
								<div class="col-sm-5">
									<input type="text" class="form-control" name="product_name" id="lock22" placeholder="Product Name">
									<input type="hidden" name="product_id" id="pro_id">
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Catagory</label>
								<div class="col-sm-2">
									<?php 
										echo form_dropdown('catagory_name', $catagory_name,'','class="form-control three select9" id="lock3" tabindex="-1" aria-hidden="true"');
									?>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Company</label>
								<div class="col-sm-2">
									<?php 
										echo form_dropdown('company_name', $company_name,'','class="form-control company_name select10 four" id="lock4" tabindex="-1" aria-hidden="true"');
									?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Customer</label>
								<div class="col-sm-2">
									<?php 
										echo form_dropdown('customer_id', $customer_name, '','class="form-control select11 company_name five" id="lock55" tabindex="-1" aria-hidden="true"');
									?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Seller</label>
								<div class="col-sm-2">
									<?php 
										echo form_dropdown('id', $seller, '','class="form-control select12 company_name five" id="lock6" tabindex="-1" aria-hidden="true"');
									?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">Sale Type</label>
								<div class="col-sm-2">
									<select name="type_wise" class="form-control company_name select10 four" id="type_wise">
										<option value="">Select Type</option>
										<option value="invoice">Invoice Wise</option>
										<option value="product">Product Wise</option>
										<option value="invoice_product">Invoice & Product Wise</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Start</label>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "start_date",'class' => "form-control",'id' => "datepickerrr", 'tabindex' => 3, 'title' => "Start Date" ));?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">End</label>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "end_date",'class' => "form-control",'id' => "datepickerr", 'tabindex' => 3, 'title' => "End Date" ));?>
								</div>
								<div class="col-sm-4">
									<button type="submit" class="btn btn-success" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
									<button type="reset" id="reset_btn" class="btn btn-warning" style="width:100px;"><i class="fa fa-fw fa-refresh"></i> Reset</button>
									<a href="<?php echo base_url();?>report_controller/download_data_sale" id="down" target="_blank" class="btn btn-primary btn-sm" style="text-decoration:none;display:none;"><i class="fa fa-download"></i> Download</a>
								</div>
							</div>
						</form>	
					</div>
				</div>
			</div>
		</div>
	</section>
<div class="modalads3423" style="display: none">
	<div class="center">
		<img src="<?php echo base_url();?>assets/assets2/spin.gif" id="loaderIcon"/>
	</div>
</div>
<input type="hidden" id="user_type" value="<?php echo $user_type;?>">
<input type="hidden" id="invoice">
<input type="hidden" id="barcode">
<input type="hidden" id="product">
<input type="hidden" id="product2">
<input type="hidden" id="category">
<input type="hidden" id="company">
<input type="hidden" id="customer">
<input type="hidden" id="pro_type">
<input type="hidden" id="seller">
<input type="hidden" id="s_Date">
<input type="hidden" id="e_date">
<section class="content-3" id="infomsg" style="display:none;">
	<div class="row">
		<div class="col-md-12">
			<div class="box">	 
				<div class="box-body">
					<div class="wrap">
						<table class="head">
							<tr id="head_one" style="display:none;">
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:16px;">No</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;">Date</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;">Invoice</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;">Customer</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;">Sale</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;">Discount</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;">Sale return</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;">Delivery</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;">Grand</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;">Paid</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;">Due</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;">Seller</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; text-align:center; width:30px;">Action</td>
							</tr>
							<tr id="head_two" style="display:none;">
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:26px;">No</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:62px;">Date</td>
								<td>Product</td>
								<td>Company</td>
								<td>Catagory</td>
								<td>Customer</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:55px;">Quantity</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;">BP</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;">SP</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:40px;">Seller</td>
							</tr>
							<tr id="head_three" style="display:none;">
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:26px;">No</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:62px;">Date</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:55px;">Invoice</td>
								<td>Product</td>
								<td>Company</td>
								<td>Catagory</td>
								<td>Customer</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:55px;">Quantity</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;">BP</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;">SP</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:40px;">Seller</td>
							</tr>
						</table>
						<div class="inner_table">
							<table class="new_data_2"  id="search_data">
							</table>
						</div>
						<table class="head">
							<tr id="head_one_one" style="display:none;">
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Total Sale</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" id="finalgrand"></td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Total Sale-Return </td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" id="finalreturn"></td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Total Received</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" id="finalreceived"></td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Total Due</td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" id="finaldue"></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>	
</section>
<div class="modal fade" id="add_image_1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">All Sale Details</h4>
			</div>
			<br>
			<div class="modal-body">
				<div class="wrap-11">
					<table class="new_data">
						<tr>
						   <td style="text-align:left;font-size:12px;width:4%; font-family:Sans Pro; color:#444;font-weight:bold;">Invoice ID</td>
						   <td style="width:5%;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;color:black;" id="invoice_idd"></td>
						   <td style="text-align:left;text-indent:5px;font-size:13px;width:4%; font-family:Sans Pro; color:#444;font-weight:bold;">Customer</td>
						   <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;color:black;" id="customer_idd"></td>
						</tr>
					</table>
				</div>
				<br>
				<br>
				<div class="wrap-11">
					<table class="head">
						<tr>
							<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:20px;"><center>Product</center></td>
							<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:14px;"><center>Company</center></td>
							<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:14px;"><center>Catagory</center></td>
							<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:14px;"><center>Quantity</center></td>
							<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:11px;"><center>Buy</center></td>
							<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:11px;"><center>Sale</center></td>
						</tr>
					</table>
					<div class="inner_table22">
						<table class="new_data_2" id="sale_details"></table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo base_url();?>assets/assets2/autocom/jquery-1.12.4.js"></script>
<script src="<?php echo base_url();?>assets/assets2/autocom/jquery-ui.js"></script>
<script>
    $("#lock22").autocomplete({
      source    : function( request, response ) {
        $.ajax( {
          url       : "<?php echo base_url();?>report_controller/search_product",
          dataType  : "json",
          type      : "POST",
          data      : { term: request.term, flag: 1},
          success   : function( result ) { 
                  response( $.map(result, function(item){
                    return{
                      id              : item.id,
                      label           : item.product_name +'----(Company: ' + item.company_name + ')'  +  '----(Catagory: ' + item.catagory_name + ')'  +  '----(Stock:' + item.stock + ')',
                      company_name    : item.company_name,
                      catagory_name   : item.catagory_name,
                      sale_price      : item.sale_price,
                      stock           : item.stock,
                      generic_name    : item.generic_name,
                      temp_pro_data   : item.temp_pro_data
                    }
                  }));
                }
              });
          },
          minLength     : 1,
          select        : function (event, ui) {
            var stock   = ui.item.stock;
           // if(stock == 0){
               // $('#lock22').val("");
               // alert("Stock unavailable");
               // $('#lock22').focus();
            //}
            //else{
              $('#pro_id').val(ui.item.id);
              $('#price').val(ui.item.sale_price);
              $("#pro_name").val(ui.item.label);
              $("#temp_pro_data").val(ui.item.temp_pro_data);
              $("#temp_pro_qty").val(ui.item.stock);
              $("#product_quantity").focus();
           // }
                   
            },

          });
		  /* $( "#lock22" ).autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li style=\"border-bottom: 1px solid gray;\">" )
      .append( "<div><span class=\"label_style\">" + item.label + "</span><br>" + item.generic_name + "    " +item.catagory_name + "    "+ item.stock + "<br>" + item.company_name + "</div>" ).appendTo( ul );
    }; */
</script>
<script>
 $(document).ready(function() {
	$("#lock").keyup(function(){
		var length=$('#lock').val().length;
		 if(length>=1){
			 $("#lock2").prop("disabled", true);
			 $("#lock22").prop("disabled", true);
			 $("#lock3").prop("disabled", true);
			 $("#lock4").prop("disabled", true);
			 $("#lock5").prop("disabled", true);
			 $("#lock55").prop("disabled", true);
			 $("#lock6").prop("disabled", true);
			 $("#lock7").prop("disabled", true);
			// $("#datepickerrr").prop("disabled", true);
			 //$("#datepickerr").prop("disabled", true);
		 }
		  else{
			$("#lock2").prop("disabled", false);
			$("#lock22").prop("disabled", false);
			 $("#lock3").prop("disabled", false);
			 $("#lock4").prop("disabled", false);
			 $("#lock5").prop("disabled", false);
			 $("#lock55").prop("disabled", false);
			 $("#lock6").prop("disabled", false);
			 $("#lock7").prop("disabled", false);
			// $("#datepickerrr").prop("disabled", false);
			// $("#datepickerr").prop("disabled", false);
		  }
	});
});
$(document).ready(function() {
	$("#lock2").keyup(function(){
		var length=$('#lock2').val().length;
		 if(length>=1){
			 $("#lock").prop("disabled", true);
			 $("#lock22").prop("disabled", true);
			 $("#lock3").prop("disabled", true);
			 $("#lock4").prop("disabled", true);
			 $("#lock5").prop("disabled", true);
			 $("#lock55").prop("disabled", true);
			 $("#lock6").prop("disabled", true);
			 $("#lock7").prop("disabled", true);
			 //$("#datepickerrr").prop("disabled", true);
			 //$("#datepickerr").prop("disabled", true);
		 }
		  else{
			$("#lock").prop("disabled", false);
			$("#lock22").prop("disabled", false);
			 $("#lock3").prop("disabled", false);
			 $("#lock4").prop("disabled", false);
			 $("#lock5").prop("disabled", false);
			 $("#lock55").prop("disabled", false);
			 $("#lock6").prop("disabled", false);
			 $("#lock7").prop("disabled", false);
			// $("#datepickerrr").prop("disabled", false);
			// $("#datepickerr").prop("disabled", false);
		  }
	});
});

 $(document).ready(function() {
	$("#lock22").keyup(function(){
		var length=$('#lock22').val().length;
		 if(length>=1){
			 $("#lock2").prop("disabled", true);
			 $("#lock").prop("disabled", true);
			 $("#lock3").prop("disabled", true);
			 $("#lock4").prop("disabled", true);
			 $("#lock5").prop("disabled", true);
			 $("#lock55").prop("disabled", true);
			 $("#lock6").prop("disabled", true);
			 $("#lock7").prop("disabled", true);
			 //$("#datepickerrr").prop("disabled", true);
			// $("#datepickerr").prop("disabled", true);
		 }
		  else{
			$("#lock2").prop("disabled", false);
			$("#lock").prop("disabled", false);
			 $("#lock3").prop("disabled", false);
			 $("#lock4").prop("disabled", false);
			 $("#lock5").prop("disabled", false);
			 $("#lock55").prop("disabled", false);
			 $("#lock6").prop("disabled", false);
			 $("#lock7").prop("disabled", false);
			// $("#datepickerrr").prop("disabled", false);
			// $("#datepickerr").prop("disabled", false);
		  }
	});
});
</script>
<script type="text/javascript">
$(document).ready(function() {
		$("#form_4").submit(function(event) {
		event.preventDefault();
		var type_wise = $('#type_wise').val();
		var user_type = $('#user_type').val();
		//alert(type_wise);
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		var output = '';
		var output2 = '';
		var output22 = '';
		var output3 = '';
		var output33 = '';
		var output4 = '';
		var finalgrand = 0;
		var finalreturn = 0;
		var finalgrand_card = 0;
		var finaldue = 0;
		var finaldue_card = 0;
		var finalreceived = 0;
		var finalreceived_card = 0;
		var i=0;
		var k= 1;
		$.ajax({
			url: submiturl,
			type: methods,
			dataType: 'json',
			data: $(this).serialize(),
			beforeSend: function(){
				 $(".modal").show();
			},
			success: function(result) {	
				$(".modal").hide();
				for(i=0; i<result.length; i++)
				{
					if(type_wise!='')
					{
						if(type_wise=='invoice')
						{
							var total_price1  =parseFloat(Math.round(result[i].total_price)).toFixed(2);  
							var discount_amount1  =parseFloat(Math.round(result[i].discount_amount)).toFixed(2);  
							var delivery_charge1  =parseFloat(Math.round(result[i].delivery_charge)).toFixed(2);  
							//alert(discount_amount1);
							var grand_total1  =parseFloat(Math.round(result[i].grand_total)).toFixed(2);  
							var total_paid1  =parseFloat(Math.round(result[i].total_paid)).toFixed(2);  
							var sale_return_amount1  =parseFloat(Math.round(result[i].sale_return_amount)).toFixed(2);
							
							/* if(sale_return_amount1 !='' && sale_return_amount1!=grand_total1)
							{
								var total_due  = (parseFloat(grand_total1) + parseFloat(sale_return_amount1) - parseFloat(total_paid1)).toFixed(2);
							}
							else  */
							/* if(sale_return_amount1==grand_total1)
							{
								var total_due  = (parseFloat(grand_total1) - parseFloat(total_paid1)).toFixed(2);
							}
							else
							{ */
								var total_due  = parseFloat(Math.round(grand_total1 - total_paid1)).toFixed(2);
							/* } */							
							if(grand_total1=='0.00' && total_paid1=='0.00')
							{
								var total_due  = '0.00';
							}
							else if(total_due < 0)
							{
								var total_due  = '0.00';
							}
							
							finalgrand += parseFloat(grand_total1);						
							finalreturn += parseFloat(sale_return_amount1);						
							finaldue += parseFloat(total_due);						
							finalreceived += parseFloat(grand_total1 - total_due);
							output2+='<tr><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:16px;">'+k+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;">'+result[i].invoice_doc+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;">'+result[i].invoice_id+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;" title="'+result[i].customer_name+'">'+result[i].customer_name+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;">'+total_price1+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;">'+discount_amount1+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;">'+sale_return_amount1+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;">'+delivery_charge1+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;">'+grand_total1+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;">'+total_paid1+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;">'+total_due+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;">'+result[i].username+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;"><a href="#" onclick="myFunction('+result[i].invoice_id+')" data-toggle="modal" data-target="#add_image_1" class="btn btn-primary btn-xs">Details</a> <a href="<?php echo base_url();?>New_invoice_print/index/'+result[i].invoice_id+'" target="_blank" class="btn btn-danger btn-xs">Print</a></td></tr>';
							k++;
						}
						else if(type_wise=='product')
						{
							var unit_buy_price1  =parseFloat(Math.round(result[i].unit_buy_price * result[i].number_of_quantity)).toFixed(2);  
							var unit_sale_price1  =parseFloat(Math.round(result[i].unit_sale_price * result[i].number_of_quantity)).toFixed(2);  
							var avg_price  =parseFloat(Math.round(result[i].tot_sale/result[i].number_of_quantity)).toFixed(2);  	
							output3+='<tr><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:26px;">'+k+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:62px;">'+result[i].invoice_doc+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" title="'+result[i].product_name+'">'+result[i].product_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" title="'+result[i].company_name+'" >'+result[i].company_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+result[i].catagory_name+'">'+result[i].catagory_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" title="'+result[i].customer_name+'">'+result[i].customer_name+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:55px;">'+result[i].number_of_quantity+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;">'+unit_buy_price1+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;">'+unit_sale_price1+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:40px;">'+result[i].username+'</td></tr>';
							k++;
						}
						else if(type_wise=='invoice_product')
						{
							var unit_buy_price1  =parseFloat(Math.round(result[i].unit_buy_price * result[i].sale_quantity)).toFixed(2);  
							var unit_sale_price1  =parseFloat(Math.round(result[i].unit_sale_price * result[i].sale_quantity)).toFixed(2);  
							var avg_price  =parseFloat(Math.round(result[i].exact_sale_price/result[i].sale_quantity)).toFixed(2);  	
							output33+='<tr><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:26px;">'+k+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:62px;">'+result[i].invoice_doc+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:55px;">'+result[i].invoice_id+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" title="'+result[i].product_name+'">'+result[i].product_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" title="'+result[i].company_name+'" >'+result[i].company_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+result[i].catagory_name+'">'+result[i].catagory_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" title="'+result[i].customer_name+'">'+result[i].customer_name+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:55px;">'+result[i].sale_quantity+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;">'+unit_buy_price1+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;">'+unit_sale_price1+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:40px;">'+result[i].username+'</td></tr>';
							k++;
						}
					}
					else
					{
						var unit_buy_price1  =parseFloat(Math.round(result[i].unit_buy_price * result[i].number_of_quantity)).toFixed(2);  
						var unit_sale_price1  =parseFloat(Math.round(result[i].unit_sale_price * result[i].number_of_quantity)).toFixed(2);  
						var avg_price  =parseFloat(Math.round(result[i].tot_sale/result[i].number_of_quantity)).toFixed(2);  	
						output4+='<tr><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:26px;">'+k+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:62px;">'+result[i].invoice_doc+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:55px;">'+result[i].invoice_id+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" title="'+result[i].product_name+'">'+result[i].product_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" title="'+result[i].company_name+'" >'+result[i].company_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+result[i].catagory_name+'">'+result[i].catagory_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" title="'+result[i].customer_name+'">'+result[i].customer_name+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:55px;">'+result[i].number_of_quantity+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;">'+unit_buy_price1+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;">'+unit_sale_price1+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:40px;">'+result[i].username+'</td></tr>';
						k++;
					}
					

				}
				if(type_wise=='invoice')
				{
					if(output2 != '')
					{
						$('#finalgrand').html(finalgrand);
						$('#finalreturn').html(finalreturn);
						$('#finaldue').html(finaldue);
						$('#finalreceived').html(finalreceived);
						$('#search_data').html(output2);
						$('#infomsg').show();
						$('#down').show();
						$('#head_one').show();
						$('#head_one_one').show();
						$('#head_one_one_1').show();
						$('#head_two').hide();
						$('#head_three').hide();
					}
					else
					{
						$('#finalgrand').html("0");
						$('#finalgrand_card').html("0");
						$('#finaldue').html("0");
						$('#finaldue_card').html("0");
						$('#finalreceived').html("0");
						$('#finalreceived_card').html("0");
						$('#search_data').html("No Data Available");
						$('#infomsg').show();
						$('#down').show();
					}
				}
				else if(type_wise=='product')
				{
					if(output3 != '')
					{
						$('#search_data').html(output3);
						$('#infomsg').show();
						$('#down').show();
						$('#head_two').show();
						$('#head_one').hide();
						$('#head_one_one').hide();
						$('#head_one_one_1').hide();
					}
					else
					{
						$('#search_data').html("No Data Available");
						$('#infomsg').show();
						$('#head_one_one').hide();
						$('#head_one_one_1').hide();
					}
				}
				else if(type_wise=='invoice_product')
				{
					if(output33 != '')
					{
						$('#search_data').html(output33);
						$('#infomsg').show();
						$('#down').show();
						$('#head_three').show();
						$('#head_one').hide();
						$('#head_one_one').hide();
						$('#head_one_one_1').hide();
						$('#head_two').hide();
					}
					else
					{
						$('#search_data').html("No Data Available");
						$('#infomsg').show();
						$('#down').show();
						$('#head_one_one').hide();
						$('#head_one_one_1').hide();
					}
				}
				else
				{
					if(output4 != '')
					{
						$('#search_data').html(output4);
						$('#infomsg').show();
						$('#down').show();
						$('#head_three').show();
						$('#head_one').hide();
						$('#head_one_one').hide();
						$('#head_one_one_1').hide();
						$('#head_two').hide();
					}
					else
					{
						$('#search_data').html("No Data Available");
						$('#infomsg').show();
						$('#down').show();
						$('#head_one_one').hide();
						$('#head_one_one_1').hide();
					}
				}
				
				
				var invoice1 = $('#lock').val();
				var barcode1 = $('#lock2').val();
				var product1 = $('#lock22').val();
				var product2 = $('#pro_id').val();
				var catagory1 = (unescape($('#lock3').val()));
				var company1 = (unescape($('#lock4').val()));
				var pro_type1 = $('#type_wise').val();
				var customer1 = $('#lock55').val();
				var seller1 = $('#lock6').val();
				var start_date1 = $('#datepickerrr').val();
				var end_date1 = $('#datepickerr').val();
				
				
				$('#invoice').val(invoice1);
				$('#barcode').val(barcode1);
				$('#product').val(product1);
				$('#product2').val(product2);
				$('#category').val(catagory1);
				$('#company').val(company1);
				$('#customer').val(customer1);
				$('#pro_type').val(pro_type1);
				$('#seller').val(seller1);
				$('#s_Date').val(start_date1);
				$('#e_date').val(end_date1);	
				
				$('.invoice2').text(invoice1);
				$('.barcode2').text(barcode1);
				$('.product22').text(product1);
				$('.category2').text(catagory1);
				$('.company2').text(company1);
				$('.customer2').text(customer1);
				$('.pro_type2').text(pro_type1);
				$('.seller2').text(seller1);
				$('.start_date2').text(start_date1);
				$('.end_date2').text(end_date1);

				$('#lock3').val('');
				$('#lock3').select2();
				$('#lock4').val('');
				$('#lock4').select2();
				$('#lock5').val('');
				$('#lock5').select2();
				$('#lock55').val('');
				$('#lock55').select2();
				$('#lock6').val('');
				$('#lock6').select2();
				$('#type_wise').val('');
				$('#type_wise').select2();
				
				//$('#datepickerrr').val('');
				//$('#datepickerr').val('');

			}
		});
	});
	
	
	
	$("#print").click(function(event2) {
		event2.preventDefault();
		submiturl = $(this).attr('href');
		
		var invoice = $('#invoice').val();
		var barcode = $('#barcode').val();
		var product = $('#product2').val();
		var category = $('#category').val();
		var company = $('#company').val();
		var type_wise = $('#type_wise').val();
		var seller = $('#seller').val();
		var s_Date = $('#s_Date').val();
		var e_date = $('#e_date').val();
		
		if(invoice == ''){
			invoice = 'null';
		}
		if(barcode == ''){
			barcode = 'null';
		}
		if(product == ''){
			product = 'null';
		}
		if(category == ''){
			category = 'null';
		}
		if(company == ''){
			company = 'null';
		}
		if(type_wise == ''){
			type_wise = 'null';
		}
		
		if(seller == ''){
			seller = 'null';
		}
		if(s_Date == ''){
			s_Date = 'null';
		}
		if(e_date == ''){
			e_date = 'null';
		}
		
		
		//window.location(submiturl+'/'+cat);
		//window.location=submiturl+'/'+cat;
		//window.open(submiturl+'/'+cat,'_blank');
		//window.open(submiturl+'/'+invoice+'/'+barcode+'/'+product+'/'+category+'/'+company+'/'+pro_type+'/'+seller+'/'+s_Date+'/'+e_date,'_blank');
		window.open(submiturl+'/'+invoice+'/'+product+'/'+category+'/'+company+'/'+type_wise+'/'+seller+'/'+s_Date+'/'+e_date,'_blank');
	});
	
	$("#down").click(function(event2) {
		event2.preventDefault();
		submiturl = $(this).attr('href');
		
		var invoice = $('#invoice').val();
		var barcode = $('#barcode').val();
		var product = $('#product2').val();
		var category = $('#category').val();
		var company = $('#company').val();
		var customer = $('#customer').val();
		var pro_type = $('#pro_type').val();
		var seller = $('#seller').val();
		var s_Date = $('#s_Date').val();
		var e_date = $('#e_date').val();
		
		if(invoice == ''){
			invoice = 'null';
		}
		if(barcode == ''){
			barcode = 'null';
		}
		if(product == ''){
			product = 'null';
		}
		if(category == ''){
			category = 'null';
		}
		if(company == ''){
			company = 'null';
		}
		if(customer == ''){
			customer = 'null';
		}
		if(pro_type == ''){
			pro_type = 'null';
		}
		
		if(seller == ''){
			seller = 'null';
		}
		if(s_Date == ''){
			s_Date = 'null';
		}
		if(e_date == ''){
			e_date = 'null';
		}
		
		
		//window.location(submiturl+'/'+cat);
		//window.location=submiturl+'/'+cat;
		//window.open(submiturl+'/'+cat,'_blank');
		//window.open(submiturl+'/'+invoice+'/'+barcode+'/'+product+'/'+category+'/'+company+'/'+customer+'/'+pro_type+'/'+seller+'/'+s_Date+'/'+e_date,'_blank');
		window.open(submiturl+'/'+invoice+'/'+product+'/'+category+'/'+company+'/'+customer+'/'+pro_type+'/'+seller+'/'+s_Date+'/'+e_date,'_blank');
	});
	
});

function myFunction(id)
{
	var outputs2="";
	var invoice="";
	var customer="";
	var unit_buy_price="";
	var unit_sale_price="";
	$.ajax({
		url: '<?php echo base_url();?>report_controller/all_individual_sale_report_find', 
		dataType:'json',
		method: 'POST',
		data: {'invoice_id' : id},
		success: function(result)
		{	
			for (i = 0; i < result.length; i++) 
			{
				invoice  = result[i].invoice_id;
				customer = result[i].customer_name;
				unit_buy_price = parseFloat(Math.round(result[i].unit_buy_price)).toFixed(2);
				unit_sale_price = parseFloat(Math.round(result[i].unit_sale_price)).toFixed(2);
				outputs2+='<tr class="even pointer"><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:20px;"><center>'+result[i].product_name+'</center></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:14px;"><center>'+result[i].company_name+'</center></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:14px;"><center>'+result[i].catagory_name+'</center></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:14px;"> <center>'+result[i].sale_quantity+'</center> </td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:11px;"> <center>'+unit_buy_price+'</center> </td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:11px;"> <center>'+unit_sale_price+'</center> </td></tr>';
			}
			$("#sale_details").html(outputs2);
			$("#invoice_idd").html(invoice);
			$("#customer_idd").html(customer);
		}
	});
};
</script>
<script type="text/javascript">
$(document).ready(function() 
{
	$("#reset_btn").click(function(event) 
	{
		event.preventDefault();
		$('#lock3').val('');
		$('#lock3').select2();
		$('#lock4').val('');
		$('#lock4').select2();
		$('#lock5').val('');
		$('#lock5').select2();
		$('#lock55').val('');
		$('#lock55').select2();
		$('#lock6').val('');
		$('#lock6').select2();
		$('#lock').val('');
		$('#lock22').val('');
		$('#lock7').val('');
		$('#datepickerrr').val('');
		$('#datepickerr').val('');
		$("#lock2").prop("disabled", false);
		$("#lock22").prop("disabled", false);
		$("#lock").prop("disabled", false);
		$("#lock3").prop("disabled", false);
		$("#lock4").prop("disabled", false);
		$("#lock5").prop("disabled", false);
		$("#lock55").prop("disabled", false);
		$("#lock6").prop("disabled", false);
		$("#lock7").prop("disabled", false);
		$("#datepickerrr").prop("disabled", false);
		$("#datepickerr").prop("disabled", false);	
	});
});
</script>
</div>
<?php $this -> load -> view('include/footer'); ?>