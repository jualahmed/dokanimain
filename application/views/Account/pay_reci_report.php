<<<<<<< HEAD
<?php $this -> load -> view('include/header_for_new_sale'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<div class="content-wrapper">
<style>
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
	height: 300px;
	width: 100%;
	font-size:12px;
	font-family:Helvetica Neue,Helvetica,Arial,sans-serif,Solaimanlipi; 
	font-weight:normal;
	overflow-y: auto !important;
}

.inner_table22 {
	color:#333;
	height: 280px;
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
			<div class="col-md-7 col-md-offset-3">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Payable Receivable Report</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>account_controller/all_pay_reci_report_find" class="form-horizontal" method="post" autocomplete="off" enctype="multipart/form-data" id="form_6">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Type</label>
								<div class="col-sm-4">
									<select class="form-control select2" name="type" id="type">
										<option value="">Select Type</option>
										<option value="receive">Receivable Report</option>
										<option value="payable">Payable Report</option>
										<option value="expense_payable">Expense Payable Report</option>
									</select>
								</div>
								<div class="col-sm-4">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
									<a href="<?php echo base_url();?>account_controller/download_data_reci_pay" id="down" target="_blank" class="btn btn-primary btn-sm" style="text-decoration:none;display:none;"><i class="fa fa-download"></i> Download</a>
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
		<img src="<?php echo base_url();?>assets2/spin.gif" id="loaderIcon"/>
	</div>
</div>
<input type="hidden" id="type_id">
<input type="hidden" id="start">
<input type="hidden" id="end">
<section class="content-3" id="infomsg" style="display:none;">
	<div class="row">
		<div class="col-md-12">
			<div class="box">	 
				<div class="box-body">
					<div class="wrap">
						<table class="head">
							<tr>
								<td>No</td>
								<td><span class="global_name_label"></span></td>
								<td class="global_contact_label1"><span class="global_contact_label"></span></td>
								<td class="global_address_label1"><span class="global_address_label"></span></td>
								<td style="text-align:right;">Total Amount</td>
								<td style="text-align:right;">Paid Amount</td>
								<td style="text-align:right;">Return</td>
								<td style="text-align:right;">Amount</td>
							</tr>
						</table>
						<div class="inner_table">
							<table class="new_data_2" id="search_data">
							</table>
						</div>
						<table class="head">
							<tr>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"></td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span class="global_amount_sum" style="color:black;font-weight:bold;"></span></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>	
</section>
 
<script type="text/javascript">
$(document).ready(function() 
{
	$("#form_6").submit(function(event) 
	{
		event.preventDefault();
		var type = $('#type').val();
		if(type=='payable')
		{
			var submiturl = '<?php echo base_url();?>account_controller/all_pay_report_find';
			var methods = 'POST';
			var output = '';
			var output2 = '';
			var output3 = '';
			var all_ledger = '';
			var total_payable=0;
			var i=0;
			var k= 1;
			var mm= 0;
			$.ajax({
				url: submiturl,
				type: methods,
				dataType: 'json',
				data: $(this).serialize(),
				beforeSend: function(){
					 $(".modal").show();
				},
				success: function(result) 
				{	
					$(".modal").hide();
					for(i=0; i<result['payable'].length; i++)
					{	
						for(n=0;n<result['payable'][i]['receipt_purchase_total_amount'].length;n++)
						{
							var purchase_amount_all =parseFloat(result['payable'][i]['receipt_purchase_total_amount'][n]['total_purchase_amount']).toFixed(2);
							var distributor_name =result['payable'][i]['receipt_purchase_total_amount'][n]['distributor_name'];
							var distributor_contact =result['payable'][i]['receipt_purchase_total_amount'][n]['distributor_contact_no'];
							var distributor_address =result['payable'][i]['receipt_purchase_total_amount'][n]['distributor_address'];
						}
						for(m=0;m<result['payable'][i]['receipt_payment_total_amount'].length;m++)
						{
							var payment_amount_all =parseFloat(result['payable'][i]['receipt_payment_total_amount'][m]['total_payment_amount']).toFixed(2);
						}
						for(m=0;m<result['payable'][i]['receipt_purchase_return_total_amount'].length;m++)
						{
							var purchase_return_amount_all =parseFloat(result['payable'][i]['receipt_purchase_return_total_amount'][m]['total_purchase_return_amount']).toFixed(2);
						}
						for(m=0;m<result['payable'][i]['receipt_payment_delete_total_amount'].length;m++)
						{
							var payment_delete_amount_all =parseFloat(result['payable'][i]['receipt_payment_delete_total_amount'][m]['total_delete_payment_amount']).toFixed(2);
						}
						for(j=0;j<result['payable'][i]['receipt_balance_total_amount'].length;j++)
						{
							var balance_amount_all =parseFloat(result['payable'][i]['receipt_balance_total_amount'][j]['total_balance_amount']).toFixed(2);
						}
						
						
						if(isNaN(balance_amount_all))
						{
							balance_amount_all = '0.00';
						}
						else
						{
							balance_amount_all = balance_amount_all;
						}
						if(isNaN(payment_delete_amount_all))
						{
							payment_delete_amount_all = '0.00';
						}
						else
						{
							payment_delete_amount_all = payment_delete_amount_all;
						}
						
						if(isNaN(payment_amount_all))
						{
							payment_amount_all = '0.00';
						}
						else{
							payment_amount_all = payment_amount_all;
						}
						if(isNaN(purchase_amount_all))
						{
							purchase_amount_all = '0.00';
						}
						else
						{
							purchase_amount_all = purchase_amount_all;
							
						}
						if(isNaN(purchase_return_amount_all))
						{
							purchase_return_amount_all = '0.00';
						}
						else{
							purchase_return_amount_all = purchase_return_amount_all;
						}
						var due_amount = (parseFloat(purchase_amount_all) +parseFloat(balance_amount_all) +  parseFloat(payment_delete_amount_all) - parseFloat(payment_amount_all)- parseFloat(purchase_return_amount_all)).toFixed(2);

						if(isNaN(due_amount))
						{
							due_amount = '0.00';
						}
						else{
							due_amount = due_amount;
						}
						
						var total_amount=parseFloat(purchase_amount_all) +  parseFloat(balance_amount_all); 

						var paid = payment_amount_all - payment_delete_amount_all;
						
						if(isNaN(paid))
						{
							paid = payment_amount_all;
						}
						else{
							paid = paid;
						}
						
						if(isNaN(payment_delete_amount_all))
						{
							payment_delete_amount_all = '0.00';
						}
						else{
							payment_delete_amount_all = payment_delete_amount_all;
						}
						
						var final_return = parseFloat(purchase_return_amount_all + payment_delete_amount_all);
						
						
						total_payable+=parseFloat(due_amount);
						output2+='<tr><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+k+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+distributor_name+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+distributor_contact+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+distributor_address+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:right;">'+total_amount+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:right;">'+paid+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:right;">'+final_return+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:right;">'+due_amount+'</td></tr>';
						k++;
					}
					if(output2 != '')
					{
						$(".global_name_label").html('Distributor Name'); 
						$(".global_contact_label").html('Distributor Contact'); 
						$(".global_address_label").html('Distributor Address');
						$(".global_contact_label1").show(); 
						$(".global_address_label1").show(); 
						$(".global_amount_sum").html('Total : '+total_payable); 						
						$('#search_data').html(output2);
						$('#infomsg').show();
						$('#down').show();
					}
					else
					{
						$(".global_name_label").html('Distributor Name'); 
						$(".global_contact_label").html('Distributor Contact'); 
						$(".global_address_label").html('Distributor Address');
						$(".global_contact_label1").show(); 
						$(".global_address_label1").show(); 						
						$(".global_amount_sum").html('Total : '+total_payable); 	
						$('#search_data').html("No Data Available");
						$('#infomsg').show();
						$('#down').show();
					}
					
					var type1 = $('#type').val();
					$('#type_id').val(type1);
					$('#cheque_status').val('');
					$('#cheque_status').select2();
				}
			});
		}
		else if(type=='receive')
		{
			var submiturl = '<?php echo base_url();?>account_controller/all_pay_report_find';
			var methods = 'POST';
			var output = '';
			var output2 = '';
			var output3 = '';
			var all_ledger = '';
			var total_receivable=0;
			var i=0;
			var k= 1;
			var mm= 0;
			$.ajax({
				url: submiturl,
				type: methods,
				dataType: 'json',
				data: $(this).serialize(),
				beforeSend: function(){
					 $(".modal").show();
				},
				success: function(result) 
				{	
					$(".modal").hide();
					for(i=0; i<result['receive'].length; i++)
					{	
				
						for(n=0;n<result['receive'][i]['receipt_sale_total_amount'].length;n++)
						{
							var sale_amount_all =parseFloat(result['receive'][i]['receipt_sale_total_amount'][n]['total_sale_amount']).toFixed(2);
							var sale_amount_all2 =parseFloat(result['receive'][i]['receipt_sale_total_amount'][n]['total_sale_amount']).toFixed(2);
							var customer_id =result['receive'][i]['receipt_sale_total_amount'][n]['customer_id'];
							var customer_name =result['receive'][i]['receipt_sale_total_amount'][n]['customer_name'];
							var customer_contact =result['receive'][i]['receipt_sale_total_amount'][n]['customer_contact_no'];
							var customer_address =result['receive'][i]['receipt_sale_total_amount'][n]['customer_address'];
						}
						
						for(m=0;m<result['receive'][i]['receipt_collection_total_amount'].length;m++)
						{
							var collection_amount_all =parseFloat(result['receive'][i]['receipt_collection_total_amount'][m]['total_collection_amount']).toFixed(2);
						}
						for(mm=0;mm<result['receive'][i]['receipt_delivery_total_amount'].length;mm++)
						{
							var delivery_amount_all =parseFloat(result['receive'][i]['receipt_delivery_total_amount'][mm]['total_delivery_amount']).toFixed(2);
						}
						for(m=0;m<result['receive'][i]['receipt_sale_return_total_amount'].length;m++)
						{
							var sale_return_amount_all =parseFloat(result['receive'][i]['receipt_sale_return_total_amount'][m]['total_sale_return_amount']).toFixed(2);
						}
						for(j=0;j<result['receive'][i]['receipt_balance_total_amount'].length;j++)
						{
							var balance_amount_all =parseFloat(result['receive'][i]['receipt_balance_total_amount'][j]['total_balance_amount']).toFixed(2);
						}
						if(isNaN(collection_amount_all))
						{
							collection_amount_all = '0.00';
						}
						else
						{
							collection_amount_all = collection_amount_all;
						}
						if(isNaN(delivery_amount_all))
						{
							delivery_amount_all = '0.00';
						}
						else
						{
							delivery_amount_all = delivery_amount_all;
						}
						if(isNaN(balance_amount_all))
						{
							balance_amount_all = '0.00';
						}
						else
						{
							balance_amount_all = balance_amount_all;
						}
						
						if(isNaN(sale_return_amount_all))
						{
							sale_return_amount_all = '0.00';
						}
						else
						{
							sale_return_amount_all = sale_return_amount_all;
						}
						
						if(isNaN(sale_amount_all))
						{
							
							sale_amount_all = '0.00';
						}
						else
						{
							sale_amount_all = sale_amount_all;
						}
						if(customer_id==1)
						{
							var due_amount = (parseFloat(sale_amount_all) + parseFloat(sale_return_amount_all)+  parseFloat(balance_amount_all) - parseFloat(collection_amount_all) - parseFloat(sale_return_amount_all) + parseFloat(delivery_amount_all))- parseFloat(delivery_amount_all);
						}
						else{
							var due_amount = (parseFloat(sale_amount_all) +  parseFloat(balance_amount_all) - parseFloat(collection_amount_all) - parseFloat(sale_return_amount_all) + parseFloat(delivery_amount_all))- parseFloat(delivery_amount_all);
						}
						if(isNaN(due_amount))
						{
							due_amount = '0.00';
						}
						else
						{
							due_amount = due_amount;
						}
						var total_amount = parseFloat(sale_amount_all)+parseFloat(balance_amount_all); 
						total_receivable+=parseFloat(due_amount);
						output2+='<tr><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+k+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+customer_name+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+customer_contact+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+customer_address+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:right;">'+total_amount+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:right;">'+collection_amount_all+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:right;">'+sale_return_amount_all+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:right;">'+due_amount+'</td></tr>';
						k++;
					}
					if(output2 != '')
					{
						$(".global_name_label").html('Customer Name'); 
						$(".global_contact_label").html('Customer Contact'); 
						$(".global_address_label").html('Customer Address'); 
						$(".global_contact_label1").show(); 
						$(".global_address_label1").show(); 
						$(".global_amount_sum").html('Total : '+total_receivable); 
						$('#search_data').html(output2);
						$('#infomsg').show();
						$('#down').show();
					}
					else
					{
						$(".global_name_label").html('Customer Name'); 
						$(".global_contact_label").html('Customer Contact'); 
						$(".global_address_label").html('Customer Address'); 
						$(".global_contact_label1").show(); 
						$(".global_address_label1").show(); 
						$(".global_amount_sum").html('Total : '+total_receivable); 
						$('#search_data').html("No Data Available");
						$('#infomsg').show();
						$('#down').show();
					}
					
					var type1 = $('#type').val();
					$('#type_id').val(type1);
					$('#cheque_status').val('');
					$('#cheque_status').select2();
				}
			});
		}
		else if(type=='expense_payable')
		{
			var submiturl = '<?php echo base_url();?>account_controller/all_pay_report_find';
			var methods = 'POST';
			var output = '';
			var output2 = '';
			var output3 = '';
			var all_ledger = '';
			var total_expense_payable=0;
			var i=0;
			var k= 1;
			var mm= 0;
			$.ajax({
				url: submiturl,
				type: methods,
				dataType: 'json',
				data: $(this).serialize(),
				beforeSend: function(){
					 $(".modal").show();
				},
				success: function(result) 
				{	
					$(".modal").hide();
					for(i=0; i<result['expense_payable'].length; i++)
					{	
				
						for(n=0;n<result['expense_payable'][i]['receipt_expense_total_amount'].length;n++)
						{
							var expense_amount_all =parseFloat(result['expense_payable'][i]['receipt_expense_total_amount'][n]['total_expense_amount']).toFixed(2);
							var service_provider_name =result['expense_payable'][i]['receipt_expense_total_amount'][n]['type_type'];
						}
						
						for(m=0;m<result['expense_payable'][i]['receipt_expense_payment_total_amount'].length;m++)
						{
							var expense_payment_amount_all =parseFloat(result['expense_payable'][i]['receipt_expense_payment_total_amount'][m]['total_expense_payment_amount']).toFixed(2);
						}
						for(m=0;m<result['expense_payable'][i]['receipt_expense_delete_total_amount'].length;m++)
						{
							var expense_delete_amount_all =parseFloat(result['expense_payable'][i]['receipt_expense_delete_total_amount'][m]['total_delete_expense_amount']).toFixed(2);
						}

						if(expense_amount_all =='NaN')
						{
							expense_amount_all = '0.00';
						}
						else
						{
							expense_amount_all = parseFloat(expense_amount_all).toFixed(2);
						}
						if(expense_payment_amount_all =='NaN')
						{
							expense_payment_amount_all = '0.00';
						}
						else{
							expense_payment_amount_all = expense_payment_amount_all;
						}
						if(expense_delete_amount_all =='NaN')
						{
							expense_delete_amount_all = '0.00';
						}
						else{
							expense_delete_amount_all = expense_delete_amount_all;
						}
						//alert(expense_amount_all);
						//alert(expense_payment_amount_all);
						//alert(expense_delete_amount_all);
						var due_amount = parseFloat(expense_amount_all) - parseFloat(expense_payment_amount_all) + parseFloat(expense_delete_amount_all);
						if(due_amount =='NaN')
						{
							due_amount = '0.00';
						}
						else
						{
							due_amount = due_amount;
							
						}
						total_expense_payable+=parseFloat(due_amount);
						output2+='<tr><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+k+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+service_provider_name+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:right;">'+expense_amount_all+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:right;">'+expense_payment_amount_all+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:right;">'+expense_delete_amount_all+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:right;">'+due_amount+'</td></tr>';
						k++;
					}
					if(output2 != '')
					{
						$(".global_name_label").html('Type Name'); 
						$(".global_contact_label1").hide(); 
						$(".global_address_label1").hide(); 
						$(".global_amount_sum").html('Total : '+total_expense_payable); 
						$('#search_data').html(output2);
						$('#infomsg').show();
						$('#down').show();
					}
					else
					{
						$(".global_name_label").html('Type Name'); 
						$(".global_contact_label1").hide(); 
						$(".global_address_label1").hide(); 
						$(".global_amount_sum").html('Total : '+total_expense_payable); 
						$('#search_data').html("No Data Available");
						$('#infomsg').show();
						$('#down').show();
					}
					
					var type1 = $('#type').val();
					$('#type_id').val(type1);
					$('#cheque_status').val('');
					$('#cheque_status').select2();
				}
			});
		};
	});
	$("#down").click(function(event2) {
		event2.preventDefault();
		submiturl = $(this).attr('href');
		
		var type_id = $('#type_id').val();
		
		if(type_id == ''){
			type_id = 'null';
		}
		
		
		window.open(submiturl+'/'+type_id,'_blank');
	});
	
});
</script>
</div>
=======
<?php $this -> load -> view('include/header_for_new_sale'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<div class="content-wrapper">
<style>
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
	height: 300px;
	width: 100%;
	font-size:12px;
	font-family:Helvetica Neue,Helvetica,Arial,sans-serif,Solaimanlipi; 
	font-weight:normal;
	overflow-y: auto !important;
}

.inner_table22 {
	color:#333;
	height: 280px;
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
			<div class="col-md-7 col-md-offset-3">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Payable Receivable Report</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>account_controller/all_pay_reci_report_find" class="form-horizontal" method="post" autocomplete="off" enctype="multipart/form-data" id="form_6">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Type</label>
								<div class="col-sm-4">
									<select class="form-control select2" name="type" id="type">
										<option value="">Select Type</option>
										<option value="receive">Receivable Report</option>
										<option value="payable">Payable Report</option>
										<option value="expense_payable">Expense Payable Report</option>
									</select>
								</div>
								<div class="col-sm-4">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
									<a href="<?php echo base_url();?>account_controller/download_data_reci_pay" id="down" target="_blank" class="btn btn-primary btn-sm" style="text-decoration:none;display:none;"><i class="fa fa-download"></i> Download</a>
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
		<img src="<?php echo base_url();?>assets2/spin.gif" id="loaderIcon"/>
	</div>
</div>
<input type="hidden" id="type_id">
<input type="hidden" id="start">
<input type="hidden" id="end">
<section class="content-3" id="infomsg" style="display:none;">
	<div class="row">
		<div class="col-md-12">
			<div class="box">	 
				<div class="box-body">
					<div class="wrap">
						<table class="head">
							<tr>
								<td>No</td>
								<td><span class="global_name_label"></span></td>
								<td class="global_contact_label1"><span class="global_contact_label"></span></td>
								<td class="global_address_label1"><span class="global_address_label"></span></td>
								<td style="text-align:right;">Total Amount</td>
								<td style="text-align:right;">Paid Amount</td>
								<td style="text-align:right;">Return</td>
								<td style="text-align:right;">Amount</td>
							</tr>
						</table>
						<div class="inner_table">
							<table class="new_data_2" id="search_data">
							</table>
						</div>
						<table class="head">
							<tr>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"></td>
								<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span class="global_amount_sum" style="color:black;font-weight:bold;"></span></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>	
</section>
 
<script type="text/javascript">
$(document).ready(function() 
{
	$("#form_6").submit(function(event) 
	{
		event.preventDefault();
		var type = $('#type').val();
		if(type=='payable')
		{
			var submiturl = '<?php echo base_url();?>account_controller/all_pay_report_find';
			var methods = 'POST';
			var output = '';
			var output2 = '';
			var output3 = '';
			var all_ledger = '';
			var total_payable=0;
			var i=0;
			var k= 1;
			var mm= 0;
			$.ajax({
				url: submiturl,
				type: methods,
				dataType: 'json',
				data: $(this).serialize(),
				beforeSend: function(){
					 $(".modal").show();
				},
				success: function(result) 
				{	
					$(".modal").hide();
					for(i=0; i<result['payable'].length; i++)
					{	
						for(n=0;n<result['payable'][i]['receipt_purchase_total_amount'].length;n++)
						{
							var purchase_amount_all =parseFloat(result['payable'][i]['receipt_purchase_total_amount'][n]['total_purchase_amount']).toFixed(2);
							var distributor_name =result['payable'][i]['receipt_purchase_total_amount'][n]['distributor_name'];
							var distributor_contact =result['payable'][i]['receipt_purchase_total_amount'][n]['distributor_contact_no'];
							var distributor_address =result['payable'][i]['receipt_purchase_total_amount'][n]['distributor_address'];
						}
						for(m=0;m<result['payable'][i]['receipt_payment_total_amount'].length;m++)
						{
							var payment_amount_all =parseFloat(result['payable'][i]['receipt_payment_total_amount'][m]['total_payment_amount']).toFixed(2);
						}
						for(m=0;m<result['payable'][i]['receipt_payment_delete_total_amount'].length;m++)
						{
							var payment_delete_amount_all =parseFloat(result['payable'][i]['receipt_payment_delete_total_amount'][m]['total_delete_payment_amount']).toFixed(2);
						}
						for(j=0;j<result['payable'][i]['receipt_balance_total_amount'].length;j++)
						{
							var balance_amount_all =parseFloat(result['payable'][i]['receipt_balance_total_amount'][j]['total_balance_amount']).toFixed(2);
						}
						
						
						if(isNaN(balance_amount_all))
						{
							balance_amount_all = '0.00';
						}
						else
						{
							balance_amount_all = balance_amount_all;
						}
						if(isNaN(payment_delete_amount_all))
						{
							payment_delete_amount_all = '0.00';
						}
						else
						{
							payment_delete_amount_all = payment_delete_amount_all;
						}
						
						if(isNaN(payment_amount_all))
						{
							payment_amount_all = '0.00';
						}
						else{
							payment_amount_all = payment_amount_all;
						}
						if(isNaN(purchase_amount_all))
						{
							purchase_amount_all = '0.00';
						}
						else
						{
							purchase_amount_all = purchase_amount_all;
							
						}
						var due_amount = (parseFloat(purchase_amount_all) +parseFloat(balance_amount_all) +  parseFloat(payment_delete_amount_all) - parseFloat(payment_amount_all)).toFixed(2);

						if(isNaN(due_amount))
						{
							due_amount = '0.00';
						}
						else{
							due_amount = due_amount;
						}
						
						var total_amount=parseFloat(purchase_amount_all) +  parseFloat(balance_amount_all); 

						var paid = payment_amount_all - payment_delete_amount_all;
						if(isNaN(paid))
						{
							paid = payment_amount_all;
						}
						else{
							paid = paid;
						}
						
						if(isNaN(payment_delete_amount_all))
						{
							payment_delete_amount_all = '0.00';
						}
						else{
							payment_delete_amount_all = payment_delete_amount_all;
						}
						
						
						
						
						total_payable+=parseFloat(due_amount);
						output2+='<tr><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+k+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+distributor_name+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+distributor_contact+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+distributor_address+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:right;">'+total_amount+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:right;">'+paid+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:right;">'+payment_delete_amount_all+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:right;">'+due_amount+'</td></tr>';
						k++;
					}
					if(output2 != '')
					{
						$(".global_name_label").html('Distributor Name'); 
						$(".global_contact_label").html('Distributor Contact'); 
						$(".global_address_label").html('Distributor Address');
						$(".global_contact_label1").show(); 
						$(".global_address_label1").show(); 
						$(".global_amount_sum").html('Total : '+total_payable); 						
						$('#search_data').html(output2);
						$('#infomsg').show();
						$('#down').show();
					}
					else
					{
						$(".global_name_label").html('Distributor Name'); 
						$(".global_contact_label").html('Distributor Contact'); 
						$(".global_address_label").html('Distributor Address');
						$(".global_contact_label1").show(); 
						$(".global_address_label1").show(); 						
						$(".global_amount_sum").html('Total : '+total_payable); 	
						$('#search_data').html("No Data Available");
						$('#infomsg').show();
						$('#down').show();
					}
					
					var type1 = $('#type').val();
					$('#type_id').val(type1);
					$('#cheque_status').val('');
					$('#cheque_status').select2();
				}
			});
		}
		else if(type=='receive')
		{
			var submiturl = '<?php echo base_url();?>account_controller/all_pay_report_find';
			var methods = 'POST';
			var output = '';
			var output2 = '';
			var output3 = '';
			var all_ledger = '';
			var total_receivable=0;
			var i=0;
			var k= 1;
			var mm= 0;
			$.ajax({
				url: submiturl,
				type: methods,
				dataType: 'json',
				data: $(this).serialize(),
				beforeSend: function(){
					 $(".modal").show();
				},
				success: function(result) 
				{	
					$(".modal").hide();
					for(i=0; i<result['receive'].length; i++)
					{	
				
						for(n=0;n<result['receive'][i]['receipt_sale_total_amount'].length;n++)
						{
							var sale_amount_all =parseFloat(result['receive'][i]['receipt_sale_total_amount'][n]['total_sale_amount']).toFixed(2);
							var sale_amount_all2 =parseFloat(result['receive'][i]['receipt_sale_total_amount'][n]['total_sale_amount']).toFixed(2);
							var customer_name =result['receive'][i]['receipt_sale_total_amount'][n]['customer_name'];
							var customer_contact =result['receive'][i]['receipt_sale_total_amount'][n]['customer_contact_no'];
							var customer_address =result['receive'][i]['receipt_sale_total_amount'][n]['customer_address'];
						}
						
						for(m=0;m<result['receive'][i]['receipt_collection_total_amount'].length;m++)
						{
							var collection_amount_all =parseFloat(result['receive'][i]['receipt_collection_total_amount'][m]['total_collection_amount']).toFixed(2);
						}
						for(mm=0;mm<result['receive'][i]['receipt_delivery_total_amount'].length;mm++)
						{
							var delivery_amount_all =parseFloat(result['receive'][i]['receipt_delivery_total_amount'][mm]['total_delivery_amount']).toFixed(2);
						}
						for(m=0;m<result['receive'][i]['receipt_sale_return_total_amount'].length;m++)
						{
							var sale_return_amount_all =parseFloat(result['receive'][i]['receipt_sale_return_total_amount'][m]['total_sale_return_amount']).toFixed(2);
						}
						for(j=0;j<result['receive'][i]['receipt_balance_total_amount'].length;j++)
						{
							var balance_amount_all =parseFloat(result['receive'][i]['receipt_balance_total_amount'][j]['total_balance_amount']).toFixed(2);
						}
						if(isNaN(collection_amount_all))
						{
							collection_amount_all = '0.00';
						}
						else
						{
							collection_amount_all = collection_amount_all;
						}
						if(isNaN(delivery_amount_all))
						{
							delivery_amount_all = '0.00';
						}
						else
						{
							delivery_amount_all = delivery_amount_all;
						}
						if(isNaN(balance_amount_all))
						{
							balance_amount_all = '0.00';
						}
						else
						{
							balance_amount_all = balance_amount_all;
						}
						
						if(isNaN(sale_return_amount_all))
						{
							sale_return_amount_all = '0.00';
						}
						else
						{
							sale_return_amount_all = sale_return_amount_all;
						}
						
						if(isNaN(sale_amount_all))
						{
							
							sale_amount_all = '0.00';
						}
						else
						{
							sale_amount_all = sale_amount_all;
						}
						var due_amount = (parseFloat(sale_amount_all) +  parseFloat(balance_amount_all) - parseFloat(collection_amount_all) - parseFloat(sale_return_amount_all) + parseFloat(delivery_amount_all))- parseFloat(delivery_amount_all);
						if(isNaN(due_amount))
						{
							due_amount = '0.00';
						}
						else
						{
							due_amount = due_amount;
						}
						var total_amount = parseFloat(sale_amount_all)+parseFloat(balance_amount_all); 
						total_receivable+=parseFloat(due_amount);
						output2+='<tr><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+k+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+customer_name+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+customer_contact+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+customer_address+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:right;">'+total_amount+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:right;">'+collection_amount_all+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:right;">'+sale_return_amount_all+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:right;">'+due_amount+'</td></tr>';
						k++;
					}
					if(output2 != '')
					{
						$(".global_name_label").html('Customer Name'); 
						$(".global_contact_label").html('Customer Contact'); 
						$(".global_address_label").html('Customer Address'); 
						$(".global_contact_label1").show(); 
						$(".global_address_label1").show(); 
						$(".global_amount_sum").html('Total : '+total_receivable); 
						$('#search_data').html(output2);
						$('#infomsg').show();
						$('#down').show();
					}
					else
					{
						$(".global_name_label").html('Customer Name'); 
						$(".global_contact_label").html('Customer Contact'); 
						$(".global_address_label").html('Customer Address'); 
						$(".global_contact_label1").show(); 
						$(".global_address_label1").show(); 
						$(".global_amount_sum").html('Total : '+total_receivable); 
						$('#search_data').html("No Data Available");
						$('#infomsg').show();
						$('#down').show();
					}
					
					var type1 = $('#type').val();
					$('#type_id').val(type1);
					$('#cheque_status').val('');
					$('#cheque_status').select2();
				}
			});
		}
		else if(type=='expense_payable')
		{
			var submiturl = '<?php echo base_url();?>account_controller/all_pay_report_find';
			var methods = 'POST';
			var output = '';
			var output2 = '';
			var output3 = '';
			var all_ledger = '';
			var total_expense_payable=0;
			var i=0;
			var k= 1;
			var mm= 0;
			$.ajax({
				url: submiturl,
				type: methods,
				dataType: 'json',
				data: $(this).serialize(),
				beforeSend: function(){
					 $(".modal").show();
				},
				success: function(result) 
				{	
					$(".modal").hide();
					for(i=0; i<result['expense_payable'].length; i++)
					{	
				
						for(n=0;n<result['expense_payable'][i]['receipt_expense_total_amount'].length;n++)
						{
							var expense_amount_all =parseFloat(result['expense_payable'][i]['receipt_expense_total_amount'][n]['total_expense_amount']).toFixed(2);
							var service_provider_name =result['expense_payable'][i]['receipt_expense_total_amount'][n]['type_type'];
						}
						
						for(m=0;m<result['expense_payable'][i]['receipt_expense_payment_total_amount'].length;m++)
						{
							var expense_payment_amount_all =parseFloat(result['expense_payable'][i]['receipt_expense_payment_total_amount'][m]['total_expense_payment_amount']).toFixed(2);
						}
						for(m=0;m<result['expense_payable'][i]['receipt_expense_delete_total_amount'].length;m++)
						{
							var expense_delete_amount_all =parseFloat(result['expense_payable'][i]['receipt_expense_delete_total_amount'][m]['total_delete_expense_amount']).toFixed(2);
						}

						if(expense_amount_all =='NaN')
						{
							expense_amount_all = '0.00';
						}
						else
						{
							expense_amount_all = parseFloat(expense_amount_all).toFixed(2);
						}
						if(expense_payment_amount_all =='NaN')
						{
							expense_payment_amount_all = '0.00';
						}
						else{
							expense_payment_amount_all = expense_payment_amount_all;
						}
						if(expense_delete_amount_all =='NaN')
						{
							expense_delete_amount_all = '0.00';
						}
						else{
							expense_delete_amount_all = expense_delete_amount_all;
						}
						//alert(expense_amount_all);
						//alert(expense_payment_amount_all);
						//alert(expense_delete_amount_all);
						var due_amount = parseFloat(expense_amount_all) - parseFloat(expense_payment_amount_all) + parseFloat(expense_delete_amount_all);
						if(due_amount =='NaN')
						{
							due_amount = '0.00';
						}
						else
						{
							due_amount = due_amount;
							
						}
						total_expense_payable+=parseFloat(due_amount);
						output2+='<tr><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+k+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+service_provider_name+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:right;">'+expense_amount_all+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:right;">'+expense_payment_amount_all+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:right;">'+expense_delete_amount_all+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:right;">'+due_amount+'</td></tr>';
						k++;
					}
					if(output2 != '')
					{
						$(".global_name_label").html('Type Name'); 
						$(".global_contact_label1").hide(); 
						$(".global_address_label1").hide(); 
						$(".global_amount_sum").html('Total : '+total_expense_payable); 
						$('#search_data').html(output2);
						$('#infomsg').show();
						$('#down').show();
					}
					else
					{
						$(".global_name_label").html('Type Name'); 
						$(".global_contact_label1").hide(); 
						$(".global_address_label1").hide(); 
						$(".global_amount_sum").html('Total : '+total_expense_payable); 
						$('#search_data').html("No Data Available");
						$('#infomsg').show();
						$('#down').show();
					}
					
					var type1 = $('#type').val();
					$('#type_id').val(type1);
					$('#cheque_status').val('');
					$('#cheque_status').select2();
				}
			});
		};
	});
	$("#down").click(function(event2) {
		event2.preventDefault();
		submiturl = $(this).attr('href');
		
		var type_id = $('#type_id').val();
		
		if(type_id == ''){
			type_id = 'null';
		}
		
		
		window.open(submiturl+'/'+type_id,'_blank');
	});
	
});
</script>
</div>
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
<?php $this -> load -> view('include/footer'); ?>