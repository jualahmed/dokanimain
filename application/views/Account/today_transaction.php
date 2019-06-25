<?php $this -> load -> view('include/header_for_new_sale'); ?>
<!--script  src="<?php echo base_url(); ?>assets/js/jquery-2.1.3.min.js"></script-->
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
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
	float: left;
    width: 100%;
	margin:0px 0px 0px 0px;
}
.wrap table {
    width: 100%;
    table-layout: fixed;
}
.wrap-11 {
	float: right;
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
    ~height: 190px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    ~overflow-y: auto !important;
}

.inner_table22 {
	color:#666768;
    height: 280px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    ~overflow-y: auto !important;
}
.inner_table_2 {
	color:#403e3e;
    height: 46px;
	width: 100%;
	font-size:12px;
	font-family:Sans Pro; 
	font-weight:bold;
    ~overflow-y: auto !important;
}
.inner_table::-webkit-scrollbar {
    width: 2px;
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
			<div class="col-md-10 col-md-offset-1">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">All Transactions</h3>
					</div>
					<div class="box-body">
						<form action ="<?php echo base_url();?>account_controller/all_today_transaction" method="post" class="form-horizontal" autocomplete="off" enctype="multipart/form-data" id="form_6">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Start</label>
								<div class="col-sm-3">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "start_date",'class' => "form-control",'id' => "datepickerrr",'value' => $bd_date, 'tabindex' => 3, 'title' => "Start Date" ));?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label">End</label>
								<div class="col-sm-3">
									<?php echo form_input(array('type' => 'text','placeholder' => $bd_date , 'name' => "end_date",'class' => "form-control",'id' => "datepickerr", 'value' => $bd_date, 'tabindex' => 3, 'title' => "End Date" ));?>
								</div>
								<div class="col-sm-4">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" style="width:100px;"><i class="fa fa-fw fa-search"></i> Search</button>
									<button type="reset" id="reset_btn" class="btn btn-warning btn-sm" style="width:100px;"><i class="fa fa-fw fa-refresh"></i> Reset</button>
									<a href="<?php echo base_url();?>account_controller/download_todays_transaction" id="down" style="display:none;width:100px;" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-download"></i> Download</a>
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
		<img src="<?php echo base_url();?>assets/assets2/LoaderIcon.gif" id="loaderIcon"/>
	</div>
</div>
<input type="hidden" id="start">
<input type="hidden" id="end">
<section class="content-3" id="infomsg" style="display:none;">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="box">	 
				<div class="box-body">
					<table class="head">
						<tr>
							<td style="width:4%;">Cash In Hand</td>
							<td style="width:4%;text-align:right"><span id="cash_in_hand"></td>
							<td style="width:4%;">Cash In Bank</td>
							<td style="width:4%;text-align:right"><span id="cash_in_bank"></td>
						</tr>
					</table>
					<br>
					<div class="wrap">
						<div class="box-header with-border" style="background: #0f77ab;"><center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Sale</h3></center></div>
						<table class="head">
							<tr>
							  <td style="width:4%;">SL No</td>
							  <td style="width:4%;">Date</td>
							  <td style="width:4%;">Ledger Name</td>
							  <td style="width:4%;">Particular</td>
							  <td style="width:4%;">Remarks</td>
							  <td style="width: 4%;text-align:right;">Amount</td>
							</tr>
							
						</table>
						<div class="inner_table">
							<table id="output_sale">
							</table>
						</div>
						<table class="head" id="output_sale_sum">
						</table>
					</div>
					<div class="wrap">
						<div class="box-header with-border" style="background: #0f77ab;"><center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Collection</h3></center></div>
						<table class="head">
							<tr>
							  <td style="width:4%;">SL No</td>
							  <td style="width:4%;">Date</td>
							  <td style="width:4%;">Ledger Name</td>
							  <td style="width:4%;">Particular</td>
							  <td style="width:4%;">Remarks</td>
							  <td style="width: 4%;text-align:right;">Amount</td>
							</tr>
							
						</table>
						<div class="inner_table">
							<table id="output_collection">
							</table>
						</div>
						<table class="head" id="output_collection_sum">
						</table>
					</div>
					<div class="wrap">
						<div class="box-header with-border" style="background: #0f77ab;"><center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Credit Collection</h3></center></div>
						<table class="head">
							<tr>
							  <td style="width:4%;">SL No</td>
							  <td style="width:4%;">Date</td>
							  <td style="width:4%;">Ledger Name</td>
							  <td style="width:4%;">Particular</td>
							  <td style="width:4%;">Remarks</td>
							  <td style="width: 4%;text-align:right;">Amount</td>
							</tr>
							
						</table>
						<div class="inner_table">
							<table id="output_credit_collection">
							</table>
						</div>
						<table class="head" id="output_credit_collection_sum">
						</table>
					</div>
					<div class="wrap">
						<div class="box-header with-border" style="background: #0f77ab;"><center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Purchase</h3></center></div>
						<table class="head">
							<tr>
							  <td style="width:4%;">SL No</td>
							  <td style="width:4%;">Date</td>
							  <td style="width:4%;">Ledger Name</td>
							  <td style="width:4%;">Particular</td>
							  <td style="width:4%;">Remarks</td>
							  <td style="width: 4%;text-align:right;">Amount</td>
							</tr>
							
						</table>
						<div class="inner_table">
							<table id="output_purchase">
							</table>
						</div>
						<table class="head" id="output_purchase_sum">
						</table>
					</div>
					<div class="wrap">
						<div class="box-header with-border" style="background: #0f77ab;"><center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Purchase Payment</h3></center></div>
						<table class="head">
							<tr>
							  <td style="width:4%;">SL No</td>
							  <td style="width:4%;">Date</td>
							  <td style="width:4%;">Ledger Name</td>
							  <td style="width:4%;">Particular</td>
							  <td style="width:4%;">Remarks</td>
							  <td style="width: 4%;text-align:right;">Amount</td>
							</tr>
							
						</table>
						<div class="inner_table">
							<table id="output_purchase_payment">
							</table>
						</div>
						<table class="head" id="output_purchase_payment_sum">
						</table>
					</div>
					<div class="wrap">
						<div class="box-header with-border" style="background: #0f77ab;"><center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Expense</h3></center></div>
						<table class="head">
							<tr>
							  <td style="width:4%;">SL No</td>
							  <td style="width:4%;">Date</td>
							  <td style="width:4%;">Ledger Name</td>
							  <td style="width:4%;">Particular</td>
							  <td style="width:4%;">Remarks</td>
							  <td style="width: 4%;text-align:right;">Amount</td>
							</tr>
							
						</table>
						<div class="inner_table">
							<table id="output_expense">
							</table>
						</div>
						<table class="head" id="output_expense_sum">
						</table>
					</div>
					<div class="wrap">
						<div class="box-header with-border" style="background: #0f77ab;"><center><h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Expense Payment</h3></center></div>
						<table class="head">
							<tr>
							  <td style="width:4%;">SL No</td>
							  <td style="width:4%;">Date</td>
							  <td style="width:4%;">Ledger Name</td>
							  <td style="width:4%;">Particular</td>
							  <td style="width:4%;">Remarks</td>
							  <td style="width: 4%;text-align:right;">Amount</td>
							</tr>
							
						</table>
						<div class="inner_table">
							<table id="output_expense_payment">
							</table>
						</div>
						<table class="head" id="output_expense_payment_sum">
						</table>
					</div>
					
				</div>
				
			</div>
		</div>
	</div>	
</section>
<script type="text/javascript">
$(document).ready(function() {
		$("#form_6").submit(function(event) {
		event.preventDefault();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		var output_collection = '';
		var output_collection_sum = '';
		var output_sale = '';
		var output_sale_sum = '';
		var output_credit_collection = '';
		var output_credit_collection_sum = '';
		var output_purchase = '';
		var output_purchase_sum = '';
		var output_purchase_payment = '';
		var output_purchase_payment_sum = '';
		var output_expense = '';
		var output_expense_sum = '';
		var output_expense_payment = '';
		var output_expense_payment_sum = '';

		var total_amount_collection = 0.00;
		var total_amount_sale = 0.00;
		var total_amount_credit_collection = 0.00;
		var total_amount_purchase = 0.00;
		var total_amount_purchase_payment = 0.00;
		var total_amount_expense = 0.00;
		var total_amount_expense_payment = 0.00;
		var i=0;
		var k= 1;
		var kk= 1;
		var kkk= 1;
		var kkkk= 1;
		var kkkkk= 1;
		var kkkkkk= 1;
		var kkkkkkk= 1;
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
				for(i=0; i<result['transaction_sum'].length; i++)
				{	
					var transaction_purposes=result['transaction_sum'][i].transaction_purpose;
					
					if(transaction_purposes=='sale')
					{
						total_amount_sale=0.00;
						for(ii=0; ii<result['transaction2'].length; ii++)
						{	
							var amount1=parseFloat(Math.round(result['transaction2'][ii].amount));
							
							total_amount_sale+=parseFloat(Math.round(result['transaction2'][ii].amount));
							output_sale+='<tr><td style="width: 4%;">'+k+'</td><td style="width: 4%;">'+result['transaction2'][ii].date+'</td><td style="width: 4%;">'+result['transaction2'][ii].customer_name+'</td><td style="width: 4%;">'+result['transaction2'][ii].transaction_purpose+'</td><td style="width: 4%;">'+result['transaction2'][ii].remarks+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;width: 4%;text-align:right;">'+amount1.toFixed(2)+'</td></tr>';
							k++;
						}
					}
					else if(transaction_purposes=='collection')
					{
						total_amount_collection=0.00;
						for(ii=0; ii<result['transaction'].length; ii++)
						{	
							var amount1=parseFloat(Math.round(result['transaction'][ii].amount));
							
							total_amount_collection+=parseFloat(Math.round(result['transaction'][ii].amount));
							output_collection+='<tr><td style="width: 4%;">'+kk+'</td><td style="width: 4%;">'+result['transaction'][ii].date+'</td><td style="width: 4%;">'+result['transaction'][ii].customer_name+'</td><td style="width: 4%;">'+result['transaction'][ii].transaction_purpose+'</td><td style="width: 4%;">'+result['transaction'][ii].remarks+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;width: 4%;text-align:right;">'+amount1.toFixed(2)+'</td></tr>';
							kk++;
						}
					}
					
					else if(transaction_purposes=='credit_collection')
					{
						total_amount_credit_collection=0.00;
						for(ii=0; ii<result['transaction3'].length; ii++)
						{	
							var amount1=parseFloat(Math.round(result['transaction3'][ii].amount));
							
							total_amount_credit_collection+=parseFloat(Math.round(result['transaction3'][ii].amount));
							output_credit_collection+='<tr><td style="width: 4%;">'+kkk+'</td><td style="width: 4%;">'+result['transaction3'][ii].date+'</td><td style="width: 4%;">'+result['transaction3'][ii].customer_name+'</td><td style="width: 4%;">'+result['transaction3'][ii].transaction_purpose+'</td><td style="width: 4%;">'+result['transaction3'][ii].remarks+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;width: 4%;text-align:right;">'+amount1.toFixed(2)+'</td></tr>';
							kkk++;
						}
					}
					else if(transaction_purposes=='purchase')
					{
						total_amount_purchase=0.00;
						for(ii=0; ii<result['transaction4'].length; ii++)
						{	
							var amount1=parseFloat(Math.round(result['transaction4'][ii].amount));
							
							total_amount_purchase+=parseFloat(Math.round(result['transaction4'][ii].amount));
							output_purchase+='<tr><td style="width: 4%;">'+kkkk+'</td><td style="width: 4%;">'+result['transaction4'][ii].date+'</td><td style="width: 4%;">'+result['transaction4'][ii].distributor_name+'</td><td style="width: 4%;">'+result['transaction4'][ii].transaction_purpose+'</td><td style="width: 4%;">'+result['transaction4'][ii].remarks+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;width: 4%;text-align:right;">'+amount1.toFixed(2)+'</td></tr>';
							kkkk++;
						}
					}
					else if(transaction_purposes=='payment')
					{
						total_amount_purchase_payment=0.00;
						for(ii=0; ii<result['transaction5'].length; ii++)
						{	
							var amount1=parseFloat(Math.round(result['transaction5'][ii].amount));
							
							total_amount_purchase_payment+=parseFloat(Math.round(result['transaction5'][ii].amount));
							
							output_purchase_payment+='<tr><td style="width: 4%;">'+kkkkk+'</td><td style="width: 4%;">'+result['transaction5'][ii].date+'</td><td style="width: 4%;">'+result['transaction5'][ii].distributor_name+'</td><td style="width: 4%;">'+result['transaction5'][ii].transaction_purpose+'</td><td style="width: 4%;">'+result['transaction5'][ii].remarks+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;width: 4%;text-align:right;">'+amount1.toFixed(2)+'</td></tr>';
							kkkkk++;
						}
					}
					else if(transaction_purposes=='expense')
					{
						total_amount_expense=0.00;
						for(ii=0; ii<result['transaction6'].length; ii++)
						{	
							var amount1=parseFloat(Math.round(result['transaction6'][ii].amount));
							
							total_amount_expense+=parseFloat(Math.round(result['transaction6'][ii].amount));
							output_expense+='<tr><td style="width: 4%;">'+kkkkkk+'</td><td style="width: 4%;">'+result['transaction6'][ii].date+'</td><td style="width: 4%;">'+result['transaction6'][ii].type_type+'</td><td style="width: 4%;">'+result['transaction6'][ii].expense_details+'</td><td style="width: 4%;">'+result['transaction6'][ii].remarks+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;width: 4%;text-align:right;">'+amount1.toFixed(2)+'</td></tr>';
							kkkkkk++;
						}
					}
					else if(transaction_purposes=='expense_payment')
					{
						
						total_amount_expense_payment=0.00;
						for(ii=0; ii<result['transaction7'].length; ii++)
						{	
							
							var amount1=parseFloat(Math.round(result['transaction7'][ii].amount));
							
							total_amount_expense_payment+=parseFloat(Math.round(result['transaction7'][ii].amount));
							output_expense_payment+='<tr><td style="width: 4%;">'+kkkkkkk+'</td><td style="width: 4%;">'+result['transaction7'][ii].date+'</td><td style="width: 4%;">'+result['transaction7'][ii].type_type+'</td><td style="width: 4%;">'+result['transaction7'][ii].expense_details+'</td><td style="width: 4%;">'+result['transaction7'][ii].remarks+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;width: 4%;text-align:right;">'+amount1.toFixed(2)+'</td></tr>';
							kkkkkkk++;
						}
					}
				}
				output_collection_sum+='<tr><td style="width:4%;"></td><td style="width:4%;"></td><td style="width:4%;"></td><td style="width:4%;"></td><td style="width:4%;">Total</td><td style="width: 4%;text-align:right;">'+total_amount_collection.toFixed(2)+'</td></tr>';
				output_sale_sum+='<tr><td style="width:4%;"></td><td style="width:4%;"></td><td style="width:4%;"></td><td style="width:4%;">Total</td><td style="width: 4%;text-align:right;">'+total_amount_sale.toFixed(2)+'</td></tr>';
				output_credit_collection_sum+='<tr><td style="width:4%;"></td><td style="width:4%;"></td><td style="width:4%;"></td><td style="width:4%;"></td><td style="width:4%;">Total</td><td style="width: 4%;text-align:right;">'+total_amount_credit_collection.toFixed(2)+'</td></tr>';
				output_purchase_sum+='<tr><td style="width:4%;"></td><td style="width:4%;"></td><td style="width:4%;"></td><td style="width:4%;"></td><td style="width:4%;">Total</td><td style="width: 4%;text-align:right;">'+total_amount_purchase.toFixed(2)+'</td></tr>';
				output_purchase_payment_sum+='<tr><td style="width:4%;"></td><td style="width:4%;"></td><td style="width:4%;"></td><td style="width:4%;"></td><td style="width:4%;">Total</td><td style="width: 4%;text-align:right;">'+total_amount_purchase_payment.toFixed(2)+'</td></tr>';
				output_expense_sum+='<tr><td style="width:4%;"></td><td style="width:4%;"></td><td style="width:4%;"></td><td style="width:4%;"></td><td style="width:4%;">Total</td><td style="width: 4%;text-align:right;">'+total_amount_expense.toFixed(2)+'</td></tr>';
				output_expense_payment_sum+='<tr><td style="width:4%;"></td><td style="width:4%;"></td><td style="width:4%;"></td><td style="width:4%;"></td><td style="width:4%;">Total</td><td style="width: 4%;text-align:right;">'+total_amount_expense_payment.toFixed(2)+'</td></tr>';
				if(output_collection != '')
				{
					$('#output_collection').html(output_collection);
					$('#output_collection_sum').html(output_collection_sum);
					
					$('#infomsg').show();
					$('#down').show();
				}
				else
				{
					$('#search_data').html("No Data Available");
					$('#infomsg').show();
					$('#down').show();
				}
				if(output_sale != '')
				{
					$('#output_sale').html(output_sale);
					$('#output_sale_sum').html(output_sale_sum);
					$('#infomsg').show();
					$('#down').show();
				}
				else
				{
					$('#output_sale').html("No Data Available");
					$('#infomsg').show();
					$('#down').show();
				}
				if(output_credit_collection != '')
				{
					$('#output_credit_collection').html(output_credit_collection);
					$('#output_credit_collection_sum').html(output_credit_collection_sum);
					$('#infomsg').show();
					$('#down').show();
				}
				else
				{
					$('#output_credit_collection').html("No Data Available");
					$('#infomsg').show();
					$('#down').show();
				}
				if(output_purchase != '')
				{
					$('#output_purchase').html(output_purchase);
					$('#output_purchase_sum').html(output_purchase_sum);
					$('#infomsg').show();
					$('#down').show();
				}
				else
				{
					$('#output_purchase').html("No Data Available");
					$('#infomsg').show();
					$('#down').show();
				}
				if(output_purchase_payment!= '')
				{
					$('#output_purchase_payment').html(output_purchase_payment);
					$('#output_purchase_payment_sum').html(output_purchase_payment_sum);
					$('#infomsg').show();
					$('#down').show();
				}
				else
				{
					$('#output_purchase_payment').html("No Data Available");
					$('#infomsg').show();
					$('#down').show();
				}
				if(output_expense != '')
				{
					$('#output_expense').html(output_expense);
					$('#output_expense_sum').html(output_expense_sum);
					$('#infomsg').show();
					$('#down').show();
				}
				else
				{
					$('#output_expense').html("No Data Available");
					$('#infomsg').show();
					$('#down').show();
				}
				if(output_expense_payment != '')
				{
					$('#output_expense_payment').html(output_expense_payment);
					$('#output_expense_payment_sum').html(output_expense_payment_sum);
					$('#infomsg').show();
					$('#down').show();
				}
				else
				{
					$('#output_expense_payment').html("No Data Available");
					$('#infomsg').show();
					$('#down').show();
				}
				//alert(result.transaction8);
				$('#cash_in_hand').html(result.transaction8.toFixed(2));
				$('#cash_in_bank').html(result.transaction9.toFixed(2));
				var start1 = $('#datepickerrr').val();
				var end1 = $('#datepickerr').val();
				$('#start').val(start1);
				$('#end').val(end1);
				
				$('.start2').text(start1);
				$('.end2').text(end1);

				//$('#datepickerrr').val('');
				//$('#datepickerr').val('');

			}
		});
	});
	$("#down").click(function(event2) 
	{
		event2.preventDefault();
		submiturl = $(this).attr('href');
		
		var start = $('#start').val();
		var end = $('#end').val();

		if(start == ''){
			start = 'null';
		}
		if(end == ''){
			end = 'null';
		}

		window.open(submiturl+'/'+start+'/'+end,'_blank');
	});
	
});
</script>
<script type="text/javascript">
$(document).ready(function() {
		$("#reset_btn").click(function(event) {
		event.preventDefault();
				$('#lock3').val('');
				$('#lock3').select2();
				$('#lock4').val('');
				$('#lock4').select2();
				$('#lock5').val('');
				$('#lock5').select2();
				$('#lock22').val('');
				$('#datep').val('');
				$('#datep2').val('');
		});
	});
</script>
</div>
<?php $this -> load -> view('include/footer'); ?>