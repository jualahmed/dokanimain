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
.col-xs-4{
	min-height: 1px;
    padding-left: 150px;
    padding-right: 19px;
    position: relative
}
.col-sm-33{
	width:21.75%;
	float:left;
	min-height: 1px;
    padding-left: 15px;
    padding-right: 15px;
    position: relative;
}
.col-sm-222{
	width:52.8%;
	float:left;
	min-height: 1px;
    padding-left: 15px;
    padding-right: 15px;
    position: relative;
}
.col-sm-122{
	width:11.7%;
	float:left;
	min-height: 1px;
    padding-left: 15px;
    padding-right: 0px;
    position: relative;
}
.col-sm-1{
	width:6.333333%;
	float:left;
}
.content-2{
    margin-left: auto;
    margin-right: auto;
    min-height: 2px;
    padding: 4px;
}
.content-3{
    margin-left: auto;
    margin-right: auto;
    min-height: 2px;
    padding: 4px;
}
.listStyl a{
font-size: 16px;
color: #777;
font-family : arial;
}
#product_show{
	min-width: 382px;
}
#product_show li{
background-color: #f7f7f7;
border: 1px solid #00c0ef;
}
.listStyl a:hover{
    background-color: #00c0ef;
    color:#ffffff;
}
.listStyl a:focus {
    background-color: #00c0ef;
	color: #ffffff;
}

input[type="text"]:disabled {
    background: #dddddd;
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
.wrap-1 {
	margin:0px 0px 0px 0px;
    width: 100%;
}
.wrap-1 table {
    width: 100%;
    table-layout: fixed;
}
table .new_data tr td {
    border: 1.5px solid #e1e1e1;
	background: white;
}
table tr td {
    padding: 5px;
    border: 1.5px solid #e1e1e1;
    width: 100px;
    word-wrap: break-word;
	background: white;
}
table.head tr td {
    color:white;
	background: #4d89a7;
	font-size:14px;
	font-family:Helvetica Neue,Helvetica,Arial,sans-serif,Solaimanlipi; 
	font-weight:bold;
}

.new_data_2 tr:nth-child(even) td {
    background-color: #e4f1ff;
}
.new_data_2 tr:nth-child(odd) td {
    background-color: #fff;
}
.inner_table {
	color:#333;
	max-height: 280px;
	width: 100%;
	font-size:12px;
	font-family:Helvetica Neue,Helvetica,Arial,sans-serif,Solaimanlipi; 
	font-weight:normal;
	overflow-y: auto !important;
}

.inner_table22 {
	color:#333;
	max-height: 280px;
	width: 100%;
	font-size:12px;
	font-family:Helvetica Neue,Helvetica,Arial,sans-serif,Solaimanlipi; 
	font-weight:normal;
	overflow-y: auto !important;
}
.inner_table_2 {
	color:#403e3e;
    height: 33px;
	width: 100%;
	font-size:12px;
	font-family:Helvetica Neue,Helvetica,Arial,sans-serif,Solaimanlipi; 
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
.modal
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
</style>
<section class="content-2" style="margin:0px 0px 0px 0px;">
	<div class="row">
		<div class="col-md-12">
		  <div class="box">
			<div class="box-header with-border" style="background: #0f77ab;">
				<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Stock Report</h3>
				<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"> ( Total Stock Amount: <?php echo sprintf("%.2f",$total_stock_price);?> )</h3>
				<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"> ( Stock Quantity: <?php echo $total_stock_quantity;?> )</h3>
			</div>
				<div class="box-body">
					<form action ="<?php echo base_url();?>report_controller/all_stock_report_find" class="form-horizontal" method="post" id="form_2" autocomplete="off">
						<div class="form-group">
							  <label for="inputEmail3" class="col-sm-1 control-label">Barcode</label>
							  <div class="col-sm-2">
								<?php 
									echo form_input('barcode','','class="form-control one" id="lock" placeholder="Barcode" title="Barcode" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" autocomplete="off" autofocus="on"');
								?>
							  </div>
							  <label for="inputEmail3" class="col-sm-1 control-label">Product</label>
							  <div class="col-sm-2">
									<input type="text" class="form-control" name="product_name" id="lock2122" placeholder="Product Name">
									<input type="hidden" name="product_id" id="pro_id">
							  </div>
							  <label for="inputEmail3" class="col-sm-1 control-label">Catagory</label>
							  <div class="col-sm-2">
									<?php 
										echo form_dropdown('catagory_name', $catagory_name,'','class="form-control three select9" id="lock3" tabindex="-1" aria-hidden="true"');
									?>
							  </div>
							  <label for="inputEmail3" class="col-sm-1 control-label">Company</label>
							  <div class="col-sm-2">
									<?php 
										echo form_dropdown('company_name', $company_name,'','class="form-control company_name select10 four" id="lock4" tabindex="-1" aria-hidden="true"');
									?>
							  </div>
						</div>
						<div class="form-group">
							  <label for="inputEmail3" class="col-sm-1 control-label">Type<span>*</span></label>
							  <div class="col-sm-2">
									<select class="form-control select2" name="type_wise" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" id="type_wise" tabindex="-1" aria-hidden="true" required>
										<option value="">Select Type</option>
										<option value="available">Available Stock</option>
										<option value="not_available">Not Available Stock</option>
										<option value="all">All Stock</option>
									</select>
							  </div>
							  <label for="inputEmail3" class="col-sm-1 control-label">Amount</label>
							  <div class="col-sm-2">
									<?php 
										echo form_input('product_amount','','class ="form-control-2 seven" id="lock77" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;" placeholder="Stock Amount" title="Stock Amount" autocomplete="off"');
									?>
							  </div>
							  <!--label for="inputEmail3" class="col-sm-1 control-label">Start</label>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "start_date",'class' => "form-control",'id' => "datepickerrr", 'tabindex' => 3, 'title' => "Start Date" ));?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">End</label>
								<div class="col-sm-2">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "end_date",'class' => "form-control",'id' => "datepickerr", 'tabindex' => 3, 'title' => "End Date" ));?>
								</div-->
							<div class="col-sm-4">
								<button type="submit" class="btn btn-success btn-sm" name="search_random"><i class="fa fa-fw fa-search"></i> Search</button>
								<button type="reset" id="reset_btn" class="btn btn-warning btn-sm"><i class="fa fa-fw fa-refresh"></i> Reset</button>
								<a href="<?php echo base_url();?>report_controller/download_data_stock" id="down" target="_blank" class="btn btn-primary btn-sm" style="text-decoration:none;display:none;"><i class="fa fa-download"></i> Download</a>
								<!--a href="<?php echo base_url();?>excel/stock_word" id="word" target="_blank" class="btn btn-primary btn-sm" style="text-decoration:none;"><i class="fa fa-download"></i> Download</a-->
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="modal" style="display: none">
	<div class="center">
		<img src="<?php echo base_url();?>assets/assets2/spin.gif" id="loaderIcon"/>
	</div>
</div>
<input type="hidden" id="barcode">
<input type="hidden" id="product">
<input type="hidden" id="product22">
<input type="hidden" id="category">
<input type="hidden" id="company">
<input type="hidden" id="pro_type">
<input type="hidden" id="pro_size">
<input type="hidden" id="pro_amount">
<!--input type="hidden" id="start">
<input type="hidden" id="end"-->
<section class="content-3" id="infomsg" style="display:none;">
	<div class="row">
		<div class="col-md-12">
			<div class="box">	 
				<div class="box-body">
					<div class="wrap">
						<table class="head">
							<tr>
							  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;">No</td>
							  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:25px;text-align:center;">Product ID</td>
							  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;">Product</td>
							  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:25px;text-align:center;">Barcode</td>
							  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:25px;text-align:center;">Company</td>
							  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:25px;text-align:center;">Category</td>
							  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:25px;text-align:center;">Stock</td>
							  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:25px;text-align:center;">BP</td>
							  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:25px;text-align:center;">SP</td>
							  <td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:25px;text-align:center;">EP</td>
							</tr>
						</table>
						<div class="inner_table"><table class="new_data_2" id="search_data"></table></div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</section>
<script src="<?php echo base_url();?>assets/assets2/autocom/jquery-1.12.4.js"></script>
<script src="<?php echo base_url();?>assets/assets2/autocom/jquery-ui.js"></script>
<script>
     $("#lock2122").autocomplete({
      source    : function( request, response ) {
        $.ajax( {
          url       : "<?php echo base_url();?>sale_controller/search_product22",
          dataType  : "json",
          type      : "POST",
          data      : { term: request.term, flag: 1},
          success   : function( result ) { 
                  response( $.map(result, function(item){
                    return{
					id              			: item.id,
					label           			: item.name,
					catagory_name   			: item.catagory_name,
					bulk_unit_buy_price 		: item.bulk_unit_buy_price,
					unit_buy_price 				: item.unit_buy_price,
					bulk_unit_sale_price 		: item.bulk_unit_sale_price,
					general_unit_sale_price 	: item.general_unit_sale_price
                    }
                  }));
                }
              });
          },
          minLength     : 1,
          select        : function (event, ui) 
			{
              $('#pro_id').val(ui.item.id); 
              $("#lock2122").focus();   
            },

          });
</script>
<script>
 $(document).ready(function() {
	$("#lock").keyup(function(e)
	{
		var length=$('#lock').val().length;
		if(length>=1)
		{
			$("#lock2").prop("disabled", true);
			$("#lock33").prop("disabled", true);
			$("#lock3").prop("disabled", true);
			$("#lock4").prop("disabled", true);
			$("#lock5").prop("disabled", true);
			$("#lock66").prop("disabled", true);
			$("#lock77").prop("disabled", true);
			$("#type_wise").prop("disabled", true);
		}
		else
		{
			$("#lock2").prop("disabled", false);
			$("#lock33").prop("disabled", false);
			$("#lock3").prop("disabled", false);
			$("#lock4").prop("disabled", false);
			$("#lock5").prop("disabled", false);
			$("#lock66").prop("disabled", false);
			$("#lock77").prop("disabled", false);
			$("#type_wise").prop("disabled", false);
		}
	});
});

 $(document).ready(function() {
	$("#lock2122").keyup(function(){
		var length=$('#lock2122').val().length;
		 if(length>=1){
			 $("#lock").prop("disabled", true);
			 $("#lock3").prop("disabled", true);
			 $("#lock4").prop("disabled", true);
			 $("#lock5").prop("disabled", true);
			 $("#lock66").prop("disabled", true);
			 $("#lock77").prop("disabled", true);
			 $("#type_wise").prop("disabled", true);
		 }
		  else{
			$("#lock").prop("disabled", false);
			 $("#lock3").prop("disabled", false);
			 $("#lock4").prop("disabled", false);
			 $("#lock5").prop("disabled", false);
			 $("#lock66").prop("disabled", false);
			 $("#lock77").prop("disabled", false);
			 $("#type_wise").prop("disabled", false);
		  }
	});
});
</script>
<script type="text/javascript">
$('#lock').on('keyup', function (efs)
 { 
	efs.defaultPrevented;
	if(efs.keyCode == 13) 
	{
		var barcode = $(this).val();
		var output2 = '';
		var k= 1;
		var profit= 0;
		var profit2= 0;
		var profit_percent= 0;
		var unit_buy_price= 0;
		var unit_sale_price= 0;
		var unit_shop_price= 0;
		var profit_percent2= 0;
		var total_buy= 0;
		var total_sale= 0;
		
		$.ajax({
			url: '<?php echo base_url()?>report_controller/all_stock_report_by_barcode',
			type: "POST",
			dataType: 'json',
			data: {'barcode': barcode},
			success:function(result)
			{
				for(i=0; i<result.length; i++)
				{
					unit_buy_price = parseFloat(result[i].bulk_unit_buy_price).toFixed(2);
					unit_sale_price = parseFloat(result[i].bulk_unit_sale_price).toFixed(2);
					unit_shop_price = parseFloat(result[i].general_unit_sale_price).toFixed(2);
					
					output2+='<tr><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+k+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px; font-size:12px;text-align:center;">'+result[i].product_id+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif; font-size:12px;" title="'+result[i].product_name+'">'+result[i].product_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:12px;width:25px;" title="'+result[i].barcode+'">'+result[i].barcode+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:12px;width:25px;" title="'+result[i].company_name+'">'+result[i].company_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:12px;width:25px;" title="'+result[i].catagory_name+'">'+result[i].catagory_name+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px;text-align:center;font-size:12px;">'+result[i].stock_amount+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px;text-align:center;font-size:12px;">'+unit_buy_price+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px;text-align:center;font-size:12px;">'+unit_sale_price+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px;text-align:center;font-size:12px;">'+unit_shop_price+'</td></tr>';
					k++;
				} 
				if(output2 != '')
				{
					$('#search_data').html(output2);
					$('#infomsg').show();
					$('#down').show();
				}
				else
				{
					$('#search_data').html("No Data Available");
					$('#infomsg').show();
					$('#down').show();
				}
				$('#barcode').val(barcode);
			}  
		});
	} 
});
$(document).ready(function() {	
	$("#form_2").submit(function(event) 
	{
		event.preventDefault();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		var type_wise = $('#type_wise').val();
		var output2 = '';
		var output3 = '';
		var output4 = '';
		var output5 = '';
		var i=0;
		var k= 1;
		var profit= 0;
		var profit2= 0;
		var profit_percent= 0;
		var unit_buy_price= 0;
		var unit_sale_price= 0;
		var unit_shop_price= 0;
		var profit_percent2= 0;
		var total_buy= 0;
		var total_sale= 0;
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
						if(type_wise=='available')
						{
							unit_buy_price = parseFloat(result[i].bulk_unit_buy_price).toFixed(2);
							unit_sale_price = parseFloat(result[i].bulk_unit_sale_price).toFixed(2);
							unit_shop_price = parseFloat(result[i].general_unit_sale_price).toFixed(2);
							
							output2+='<tr><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+k+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px; font-size:12px;">'+result[i].product_id+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif; font-size:12px;" title="'+result[i].product_name+'">'+result[i].product_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:12px;width:25px;" title="'+result[i].barcode+'">'+result[i].barcode+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:12px;width:25px;" title="'+result[i].company_name+'">'+result[i].company_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:12px;width:25px;" title="'+result[i].catagory_name+'">'+result[i].catagory_name+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px;text-align:center;font-size:12px;">'+result[i].stock_amount+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px;text-align:center;font-size:12px;">'+unit_buy_price+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px;text-align:center;font-size:12px;">'+unit_sale_price+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px;text-align:center;font-size:12px;">'+unit_shop_price+'</td></tr>';
							
							k++;

						}
						else if(type_wise=='not_available')
						{
							unit_buy_price = parseFloat(result[i].bulk_unit_buy_price).toFixed(2);
							unit_sale_price = parseFloat(result[i].bulk_unit_sale_price).toFixed(2);
							unit_shop_price = parseFloat(result[i].general_unit_sale_price).toFixed(2);
							output3+='<tr><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+k+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px; font-size:12px;">'+result[i].product_id+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif; font-size:12px;" title="'+result[i].product_name+'">'+result[i].product_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:12px;width:25px;" title="'+result[i].barcode+'">'+result[i].barcode+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:12px;width:25px;" title="'+result[i].company_name+'">'+result[i].company_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:12px;width:25px;" title="'+result[i].catagory_name+'">'+result[i].catagory_name+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px;text-align:center;font-size:12px;">'+result[i].stock_amount+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px;text-align:center;font-size:12px;">'+unit_buy_price+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px;text-align:center;font-size:12px;">'+unit_sale_price+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px;text-align:center;font-size:12px;">'+unit_shop_price+'</td></tr>';
							k++;

						}
						
						else if(type_wise=='all')
						{
							unit_buy_price = parseFloat(result[i].bulk_unit_buy_price).toFixed(2);
							unit_sale_price = parseFloat(result[i].bulk_unit_sale_price).toFixed(2);
							unit_shop_price = parseFloat(result[i].general_unit_sale_price).toFixed(2);
							
							output4+='<tr><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+k+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px; font-size:12px;">'+result[i].product_id+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif; font-size:12px;" title="'+result[i].product_name+'">'+result[i].product_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:12px;width:25px;" title="'+result[i].barcode+'">'+result[i].barcode+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:12px;width:25px;" title="'+result[i].company_name+'">'+result[i].company_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:12px;width:25px;" title="'+result[i].catagory_name+'">'+result[i].catagory_name+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px;text-align:center;font-size:12px;">'+result[i].stock_amount+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px;text-align:center;font-size:12px;">'+unit_buy_price+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px;text-align:center;font-size:12px;">'+unit_sale_price+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px;text-align:center;font-size:12px;">'+unit_shop_price+'</td></tr>';
							k++;

						}
					}
					else
					{
						unit_buy_price = parseFloat(result[i].bulk_unit_buy_price).toFixed(2);
						unit_sale_price = parseFloat(result[i].bulk_unit_sale_price).toFixed(2);
						unit_shop_price = parseFloat(result[i].general_unit_sale_price).toFixed(2);
						
						output5+='<tr><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+k+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px; font-size:12px;">'+result[i].product_id+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif; font-size:12px;" title="'+result[i].product_name+'">'+result[i].product_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:12px;width:25px;" title="'+result[i].barcode+'">'+result[i].barcode+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:12px;width:25px;" title="'+result[i].company_name+'">'+result[i].company_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;font-size:12px;width:25px;" title="'+result[i].catagory_name+'">'+result[i].catagory_name+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:25px;text-align:center;font-size:12px;">'+result[i].stock_amount+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:26px;text-align:center;font-size:12px;">'+unit_buy_price+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:27px;text-align:center;font-size:12px;">'+unit_sale_price+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:27px;text-align:center;font-size:12px;">'+unit_shop_price+'</td></tr>';
						
						k++;

					}
				}
				if(type_wise=='available')
				{
					if(output2 != ''){
					$('#search_data').html(output2);
					$('#infomsg').show();
					$('#down').show();
					}
					else{
						$('#search_data').html("No Data Available");
						$('#infomsg').show();
						$('#down').show();
					}
				}
				else if(type_wise=='not_available')
				{
					if(output3 != ''){
					$('#search_data').html(output3);
					$('#infomsg').show();
					$('#down').show();
					}
					else{
						$('#search_data').html("No Data Available");
						$('#infomsg').show();
						$('#down').show();
					}
				}
				
				else if(type_wise=='all')
				{
					if(output4 != ''){
					$('#search_data').html(output4);
					$('#infomsg').show();
					$('#down').show();
					}
					else{
						$('#search_data').html("No Data Available");
						$('#infomsg').show();
						$('#down').show();
					}
				}
				else
				{
					if(output5 != ''){
					$('#search_data').html(output5);
					$('#infomsg').show();
					$('#down').show();
					}
					else{
						$('#search_data').html("No Data Available");
						$('#infomsg').show();
						$('#down').show();
					}
				}
				
				
				var barcode1 = $('#lock').val();
				var product12 = (unescape($('#lock33').val()));
				var product1 = $('#pro_id').val();
				var catagory1 =(unescape($('#lock3').val()));
				var company1 = (unescape($('#lock4').val()));
				var pro_type1 = (unescape($('#type_wise').val()));
				var pro_size1 = $('#lock6').val();
				var pro_amount1 = $('#lock7').val();
				var start_date = $('#datepickerrr').val();
				var end_date = $('#datepickerr').val();

				$('#barcode').val(barcode1);
				$('#product').val(product1);
				$('#product22').val(product12);
				$('#category').val(catagory1);
				$('#company').val(company1);
				$('#pro_type').val(pro_type1);
				$('#pro_size').val(pro_size1);
				$('#pro_amount').val(pro_amount1);
				$('#start').val(start_date);
				$('#end').val(end_date);
				
				$('.barcode2').text(barcode1);
				$('.product2').text(product1);
				$('.product22').text(product12);
				$('.category2').text(catagory1);
				$('.company2').text(company1);
				$('.pro_type2').text(pro_type1);
				$('.pro_size2').text(pro_size1);
				$('.pro_amount2').text(pro_amount1);
				
				
				$('#lock3').val('');
				$('#lock3').select2();
				$('#lock4').val('');
				$('#lock4').select2();
				$('#lock5').val('');
				$('#lock5').select2();
				
				$('#lock33').val('');
				$('#lock7').val('');
				$('#lock6').val('');

			}
		});
	});
	
	$("#print").click(function(event2) {
		event2.preventDefault();
		submiturl = $(this).attr('href');
		
		var barcode = $('#barcode').val();
		var product = $('#product').val();
		var category = $('#category').val();
		var company = $('#company').val();
		var pro_type = $('#pro_type').val();
		var pro_size = $('#pro_size').val();
		var pro_amount = $('#pro_amount').val();
		
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
		if(pro_type == ''){
			pro_type = 'null';
		}
		
		if(pro_size == ''){
			pro_size = 'null';
		}
		if(pro_amount == ''){
			pro_amount = 'null';
		}

		//window.open(submiturl+'/'+barcode+'/'+product+'/'+category+'/'+company+'/'+pro_type+'/'+pro_size+'/'+pro_amount,'_blank');
		window.open(submiturl+'/'+product+'/'+category+'/'+company+'/'+pro_type+'/'+pro_size+'/'+pro_amount,'_blank');
	});
	
	$("#down").click(function(event2) 
	{
		event2.preventDefault();
		submiturl = $(this).attr('href');
		
		var barcode = $('#barcode').val();
		var product = $('#product').val();
		var category = $('#category').val();
		var company = $('#company').val();
		var pro_type = $('#pro_type').val();
		//var pro_size = $('#pro_size').val();
		var pro_amount = $('#pro_amount').val();
		//var start = $('#start').val();
		//var end = $('#end').val();
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
		if(pro_type == ''){
			pro_type = 'null';
		}
		
		/* if(pro_size == ''){
			pro_size = 'null';
		} */
		if(pro_amount == ''){
			pro_amount = 'null';
		}
		/* if(start == ''){
			start = 'null';
		}
		if(end == ''){
			end = 'null';
		} */

		window.open(submiturl+'/'+barcode+'/'+product+'/'+category+'/'+company+'/'+pro_type+'/'+pro_amount,'_blank');
		//window.open(submiturl+'/'+barcode+'/'+product+'/'+category+'/'+company+'/'+pro_type+'/'+pro_amount+'/'+start+'/'+end,'_blank');
		//window.open(submiturl+'/'+product+'/'+category+'/'+company+'/'+pro_type+'/'+pro_size+'/'+pro_amount,'_blank');
		//window.open(submiturl+'/'+product+'/'+category+'/'+company+'/'+pro_amount,'_blank');
		
	});
	
	$("#csv").click(function(event2) {
		event2.preventDefault();
		submiturl = $(this).attr('href');
		
		var barcode = $('#barcode').val();
		var product = $('#product').val();
		var category = $('#category').val();
		var company = $('#company').val();
		var pro_type = $('#pro_type').val();
		var pro_size = $('#pro_size').val();
		var pro_amount = $('#pro_amount').val();
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
		if(pro_type == ''){
			pro_type = 'null';
		}
		
		if(pro_size == ''){
			pro_size = 'null';
		}
		if(pro_amount == ''){
			pro_amount = 'null';
		}

		//window.open(submiturl+'/'+barcode+'/'+product+'/'+category+'/'+company+'/'+pro_type+'/'+pro_size+'/'+pro_amount,'_blank');
		window.open(submiturl+'/'+product+'/'+category+'/'+company+'/'+pro_type+'/'+pro_size+'/'+pro_amount,'_blank');
		
	});
	
	$("#excel").click(function(event2) 
	{
		event2.preventDefault();
		submiturl = $(this).attr('href');
		
		var barcode = $('#barcode').val();
		var product = $('#product').val();
		var category = $('#category').val();
		var company = $('#company').val();
		var pro_type = $('#pro_type').val();
		var pro_size = $('#pro_size').val();
		var pro_amount = $('#pro_amount').val();
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
		if(pro_type == ''){
			pro_type = 'null';
		}
		
		if(pro_size == ''){
			pro_size = 'null';
		}
		if(pro_amount == ''){
			pro_amount = 'null';
		}

		//window.open(submiturl+'/'+barcode+'/'+product+'/'+category+'/'+company+'/'+pro_type+'/'+pro_size+'/'+pro_amount,'_blank');
		window.open(submiturl+'/'+product+'/'+category+'/'+company+'/'+pro_type+'/'+pro_size+'/'+pro_amount,'_blank');
		
	});
	
	$("#word").click(function(event2) {
		event2.preventDefault();
		submiturl = $(this).attr('href');
		
		var barcode = $('#barcode').val();
		var product = $('#product').val();
		var category = $('#category').val();
		var company = $('#company').val();
		var pro_type = $('#pro_type').val();
		//var pro_size = $('#pro_size').val();
		var pro_amount = $('#pro_amount').val();
		//var start = $('#start').val();
		//var end = $('#end').val();
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
		if(pro_type == ''){
			pro_type = 'null';
		}
		
		/* if(pro_size == ''){
			pro_size = 'null';
		} */
		if(pro_amount == ''){
			pro_amount = 'null';
		}
		/* if(start == ''){
			start = 'null';
		}
		if(end == ''){
			end = 'null';
		} */

		//window.open(submiturl+'/'+barcode+'/'+product+'/'+category+'/'+company+'/'+pro_type+'/'+pro_size+'/'+pro_amount,'_blank');
		window.open(submiturl+'/'+barcode+'/'+product+'/'+category+'/'+company+'/'+pro_type+'/'+pro_amount,'_blank');
		
	});
});
</script>
<!--div class="modal fade" id="add_shop_1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> Update Product</h4>
      </div>
      <div class="modal-body">
		<span id="user-availability-status1" style="display:none;"></span>
        <span id="user-availability-status2" style="display:none;"></span>
		<span id="user-availability-status11" style="display:none;"></span>
        <span id="user-availability-status22" style="display:none;"></span>
		<span id="profile_show_3"></span>
		<img src="<?php echo base_url();?>assets/assets2/LoaderIcon.gif" id="loaderIcon2" style="display:none" />
		<img src="<?php echo base_url();?>assets/assets2/LoaderIcon.gif" id="loaderIcon_2" style="display:none" />
        
      </div>
    </div>
  </div>
</div-->
<script type="text/javascript">

function myFunction(id){
		alert(id);
		
		var outputs22="";
		/* $.ajax({
			url: '<?php echo base_url();?>modify_controller/get_customer_info', 
			dataType:'json',
			method: 'POST',
			data: {'customer_id' : id},
			success: function(result){
			outputs22+='<section class="content"><div class="row"><div class="col-md-12"><div class="box box-info"><form action="<?php echo base_url();?>modify_controller/update_customer_info" method="POST" enctype="multipart/form-data" role="form"><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Customer D. ID</label><div class="col-sm-10"><input type="text" class="form-control" name="customer_define_id" value="'+result.customer_define_id+'"></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Name</label><div class="col-sm-10"><input type="text" class="form-control" name="customer_name" id="customer_name_2" onBlur="checkAvailability1()" value="'+result.customer_name+'"></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Type</label><div class="col-sm-10"><select name="customer_type" class="form-control select5" style="width: 100%;" tabindex="-1" aria-hidden="true"><option selected ="selected" value="'+result.customer_type+'">'+result.customer_type+'</otpion><option value="Individual">Individual</otpion><option value="Corporate">Corporate</otpion></select></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Mode</label><div class="col-sm-10"><select name="customer_mode" class="form-control select6" style="width: 100%;" tabindex="-1" aria-hidden="true"><option selected ="selected" value="'+result.customer_mode+'">'+result.customer_mode+'</otpion><option value="Normal">Normal</otpion><option value="Registered">Registered</otpion></select></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Address</label><div class="col-sm-10"><input type="text" class="form-control" name="customer_address" value="'+result.customer_address+'"></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Contact</label><div class="col-sm-10"><input type="text" class="form-control" name="customer_contact_no" value="'+result.customer_contact_no+'"></div></div><div class="col-md-12" style="margin:10px 0px 0px 0px;"><label type="text" class="col-sm-2 control-label">Email</label><div class="col-sm-10"><input type="text" class="form-control" name="customer_email" value="'+result.customer_email+'"></div><input type="hidden" name="customer_id" value="'+result.customer_id+'"><input type="submit" id="submit_btn_1" class="btn btn-block btn-success col-md-offset-2" style="width:116px; margin:10px 0px 0px 206px;" value="Update"></div></div></div></section>';
	
				$("#profile_show_3").html(outputs22);
			}
		});  */
	};  
</script>
<script type="text/javascript">
$(document).ready(function() 
{
	$("#reset_btn").click(function(event) 
	{
		event.preventDefault();
		$('#lock').val('');
		$('#type_wise').val('');
		$('#type_wise').select2();
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
</div>
<?php $this -> load -> view('include/footer'); ?>