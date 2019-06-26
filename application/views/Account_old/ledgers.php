<<<<<<< HEAD
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
	.wrap table .new_data tr td {
		border: 1.5px solid #ffe8e8;
		background: white;
	}
	.wrap table tr td {
		padding: 5px;
		border: 1.5px solid #ffe8e8;
		width: 100px;
		word-wrap: break-word;
		background: white;
	}
	.wrap table.head tr td {
		color:white;
		background: #4d89a7;
		font-size:14px;
		font-family:Helvetica Neue,Helvetica,Arial,sans-serif,Solaimanlipi; 
		font-weight:normal;
	}

	.new_data_2 tr:nth-child(even) td {
		background-color: #e4f1ff;
	}
	.new_data_2 tr:nth-child(odd) td {
		background-color: #fff;
	}
	.inner_table {
		color:#333;
		height: 280px;
		width: 100%;
		font-size:12px;
		font-family:Helvetica Neue,Helvetica,Arial,sans-serif,Solaimanlipi; 
		font-weight:normal;
		overflow-y: auto !important;
	}

	.inner_table::-webkit-scrollbar {
		width: 6px;
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
	.modal_loader
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
	.right_body_full{
		max-height:350px;
		margin-top: 10px;
		width: 550px;
		float: left;
		overflow-y: auto !important;
		border-top: 1px dashed #dcdcdc;
	}
	.right_body_full::-webkit-scrollbar {
		width: 2px;
		background-color: #2d3335;
	}

	.right_body_full::-webkit-scrollbar-track {
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
		background-color: white;
	}

	.right_body_full::-webkit-scrollbar-thumb {
	   background-color: #448ca6;
	   background-image: -webkit-linear-gradient(45deg,rgba(255, 255, 255, .2) 25%,transparent 25%,transparent 50%,rgba(255, 255, 255, .2) 50%,rgba(255, 255, 255, .2) 75%,transparent 75%,transparent)

	}
	</style>
	<input type="hidden" id="start_date">
	<input type="hidden" id="end_date">
	<input type="hidden" id="distributor">
	<input type="hidden" id="customer">
	<input type="hidden" id="service_provider">
	<input type="hidden" id="type">
	<input type="hidden" id="employee">
	<input type="hidden" id="purpose">
	<input type="hidden" id="transfer">
	<input type="hidden" id="owner_transfer">
	<section class="content-2">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Ledger</h3>
					</div>
					<div class="box-body">
						<input type="hidden" id="action" >
						<form class="form-horizontal" id="form_2" method="post" action="<?php echo base_url();?>account_controller/all_ledger_report_find">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Purpose</label>
								<div class="col-sm-2">
									<select class="form-control select2 ledger input-sm" id="purpose_id" name="purpose_id" tabindex="-1" aria-hidden="true" required="on">
										<option value="">Select Purpose</option>
										<option value="1">Customer Sale</option>
										<option value="2">Expense</option>
										<option value="3">Purchase</option>
										<option value="4">Bank Transfer</option>
										<option value="5">Owner Transfer</option>
									</select>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label" style="display:none;" id="dist_label">Ledger</label>
								<div class="col-sm-2" style="display:none;" id="dist_list">
									<?php 
											echo form_dropdown('distributor_id', $distributor_info,'','style="width:100%;" class="form-control select2 ledger input-sm" id="distributor_id" tabindex="-1" aria-hidden="true"');
										?>
								</div>
								<label for="inputEmail3" style="display:none;" class="col-sm-1 control-label" id="cust_label">Ledger</label>
								<div class="col-sm-2" style="display:none;" id="cust_list">
									<?php 
											echo form_dropdown('customer_id', $customer_info,'','style="width:100%;" class="form-control select2 ledger input-sm" id="customer_id" tabindex="-1" aria-hidden="true"');
										?>
								</div>
								<!--label for="inputEmail3" class="col-sm-1 control-label" style="display:none;" id="ser_label">Ledger</label>
								<div class="col-sm-2" style="display:none;" id="ser_list">
									<?php 
										echo form_dropdown('service_provider_id', $service_provider_info,'','style="width:100%;" class="form-control select2 ledger input-sm" id="service_provider_id" tabindex="-1" aria-hidden="true"');
									?>
								</div-->
								<label for="inputEmail3" class="col-sm-1 control-label" style="display:none;" id="exp_type_label">Type</label>
								<div class="col-sm-2" style="display:none;" id="exp_type_list">
									<?php 
										echo form_dropdown('type_id', $expense_type,'','style="width:100%;" class="form-control select2 ledger input-sm" id="type_id" tabindex="-1" aria-hidden="true"');
									?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label" style="display:none;" id="emp_label">Employee</label>
								<div class="col-sm-2" style="display:none;" id="emp_list">
									<?php 
										echo form_dropdown('employee_id', $employee_info,'','style="width:100%;" class="form-control select2 ledger input-sm" id="employee_id" tabindex="-1" aria-hidden="true"');
									?>
								</div>
								
								<label for="inputEmail3" class="col-sm-1 control-label" style="display:none;" id="type_label">Type</label>
								<div class="col-sm-2" style="display:none;" id="type_list">
									<select style="width:100%;" class="form-control select2 input-sm" id="transfer_type" tabindex="-1" aria-hidden="true">
										<option value="">Select Type</option>
										<option value="to_bank">To Bank</option>
										<option value="from_bank">From Bank</option>
									</select>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label" style="display:none;" id="own_type_label">Type</label>
								<div class="col-sm-2" style="display:none;" id="own_type_list">
									<select style="width:100%;" class="form-control select2 input-sm" id="owner_transfer_type" tabindex="-1" aria-hidden="true">
										<option value="">Select Type</option>
										<option value="to_owner">To Owner</option>
										<option value="from_owner">From Owner</option>
									</select>
								</div>
							<!--/div>
							<div class="form-group"-->
								<label for="inputEmail3" class="col-sm-1 control-label">Date</label>
								<div class="col-sm-2" style="width: 10.666667%;">
									<?php 
										echo form_input('start_date', '','class ="form-control" id="start" placeholder="Start Date" autocomplete="off"');
									?>
								</div>
								<div class="col-sm-2" style="width: 10.666667%;">
									<?php 
										echo form_input('end_date', '','class ="form-control" id="end" placeholder="End Date" autocomplete="off"');
									?>
								</div>
								
							</div>
							<div class="form-group">
								<div class="col-sm-4">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" id="form_submit"><i class="fa fa-fw fa-search"></i> Search</button>
									<a href="<?php echo base_url();?>account_controller/all_ledger_report_print" id="down" style="display:none;" target="_blank" class="btn btn-primary btn-sm down"><i class="fa fa-download"></i> Print</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<div class="modal_loader" style="display: none">
		<div class="center">
			<img src="<?php echo base_url();?>assets/assets2/spin.gif" id="loaderIcon"/>
		</div>
	</div>

	<section class="content-3 infomsg" id="infomsg" style="display:none;">
		<div class="row">
			<div class="col-md-12">
				<div class="box">	 
					<div class="box-body">
						<div class="box-header with-border" style="background: #2fa9a9;">
							<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"><span class="ledger_name" style="color: #394446;text-align:center;"></span></h3>
						</div>
						<div class="wrap">
							<table class="head">
								<tr>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Date</td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;width:25%;"><span class="table_head_name"></span></td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;width:20%;">Details</td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">Total Amount</td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">Paid Amount</td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">Balance</td>
								</tr>
							</table>
							<div class="inner_table">
							<table class="new_data_2 search_data" id="search_data"></table>
							
							</div>
							<table class="head">
								<tr>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;width:25%;"></td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;width:20%;"></td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;"></span></td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;"></span></td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"></span></td>
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
		$("#purpose_id").on("change",function()
		{
			
			var purpose_id = $(this).val();
			if(purpose_id == 3) 
			{
				$('#exp_type_label').hide();
				$('#exp_type_list').hide();
				$('#emp_label').hide();
				$('#emp_list').hide();
				$('#dist_label').show();
				$('#dist_list').show();
				$('#distributor_id').attr('required',true);
				$('#customer_id').attr('required',false);
				$('#service_provider_id').attr('required',false);
				$('#cust_label').hide();
				$('#cust_list').hide();
				$('#ser_label').hide();
				$('#ser_list').hide();
				$('#type_label').hide();
				$('#type_list').hide();
				$('#own_type_label').hide();
				$('#own_type_list').hide();
				$('#customer_id').val('');
				$('#customer_id').select2();
				$('#service_provider_id').val('');
				$('#service_provider_id').select2();
				$('#transfer_type').val('');
				$('#transfer_type').select2();
				$('#owner_transfer_type').val('');
				$('#owner_transfer_type').select2();
			} 
			else if(purpose_id == 1) 
			{
				$('#exp_type_label').hide();
				$('#exp_type_list').hide();
				$('#emp_label').hide();
				$('#emp_list').hide();
				$('#dist_label').hide();
				$('#dist_list').hide();
				$('#distributor_id').attr('required',false);
				$('#customer_id').attr('required',true);
				$('#service_provider_id').attr('required',false);
				$('#cust_label').show();
				$('#cust_list').show();
				$('#ser_label').hide();
				$('#ser_list').hide();
				$('#type_label').hide();
				$('#type_list').hide();
				$('#own_type_label').hide();
				$('#own_type_list').hide();
				$('#distributor_id').val('');
				$('#distributor_id').select2();
				$('#service_provider_id').val('');
				$('#service_provider_id').select2();
				$('#transfer_type').val('');
				$('#transfer_type').select2();
				$('#owner_transfer_type').val('');
				$('#owner_transfer_type').select2();
			} 
			else if(purpose_id == 2) 
			{
				$('#exp_type_label').show();
				$('#exp_type_list').show();
				$('#emp_label').show();
				$('#emp_list').show();
				$('#dist_label').hide();
				$('#dist_list').hide();
				
				$('#cust_label').hide();
				$('#cust_list').hide();
				$('#type_label').hide();
				$('#type_list').hide();
				$('#own_type_label').hide();
				$('#own_type_list').hide();
				$('#ser_label').show();
				$('#ser_list').show();
				$('#distributor_id').attr('required',false);
				$('#customer_id').attr('required',false);
				//$('#service_provider_id').attr('required',true);
				$('#customer_id').val('');
				$('#customer_id').select2();
				$('#distributor_id').val('');
				$('#distributor_id').select2();
				$('#transfer_type').val('');
				$('#transfer_type').select2();
				$('#owner_transfer_type').val('');
				$('#owner_transfer_type').select2();
				
			} 
			else if(purpose_id == 4) 
			{
				$('#exp_type_label').hide();
				$('#exp_type_list').hide();
				$('#emp_label').hide();
				$('#emp_list').hide();
				$('#dist_label').hide();
				$('#dist_list').hide();
				$('#cust_label').hide();
				$('#cust_list').hide();
				$('#ser_label').hide();
				$('#ser_list').hide();
				$('#type_label').show();
				$('#type_list').show();
				$('#distributor_id').attr('required',false);
				$('#customer_id').attr('required',false);
				$('#service_provider_id').attr('required',false);
				$('#own_type_label').hide();
				$('#own_type_list').hide();
				$('#customer_id').val('');
				$('#customer_id').select2();
				$('#distributor_id').val('');
				$('#distributor_id').select2();
				$('#service_provider_id').val('');
				$('#service_provider_id').select2();
				$('#owner_transfer_type').val('');
				$('#owner_transfer_type').select2();
			} 
			
			else if(purpose_id == 5) 
			{
				$('#exp_type_label').hide();
				$('#exp_type_list').hide();
				$('#emp_label').hide();
				$('#emp_list').hide();
				$('#dist_label').hide();
				$('#dist_list').hide();
				$('#cust_label').hide();
				$('#cust_list').hide();
				$('#ser_label').hide();
				$('#ser_list').hide();
				$('#type_label').hide();
				$('#type_list').hide();
				$('#own_type_label').show();
				$('#own_type_list').show();
				$('#distributor_id').attr('required',false);
				$('#customer_id').attr('required',false);
				$('#service_provider_id').attr('required',false);
				$('#customer_id').val('');
				$('#customer_id').select2();
				$('#distributor_id').val('');
				$('#distributor_id').select2();
				$('#service_provider_id').val('');
				$('#service_provider_id').select2();
				$('#transfer_type').val('');
				$('#transfer_type').select2();
			} 
		});
	});
	$(document).ready(function () 
	{
		$('#form_2').submit(function(evv)
		{
			
			evv.preventDefault();
			var submiturl = $(this).attr('action');
			var methods = $(this).attr('method');
			var start_date = $('#start').val();
			var end_date = $('#end').val();
			var distributor_id = $('#distributor_id').val();
			var customer_id = $('#customer_id').val();
			var type_id = $('#type_id').val();
			var employee_id = $('#employee_id').val();
			var purpose_id = $('#purpose_id').val();
			var transfer_type = $('#transfer_type').val();
			var owner_transfer_type = $('#owner_transfer_type').val();
			//alert(type_id);
			$('#start_date').val(start_date);
			$('#end_date').val(end_date);
			$('#distributor').val(distributor_id);
			$('#customer').val(customer_id);
			$('#type').val(type_id);
			$('#employee').val(employee_id);
			$('#purpose').val(purpose_id);
			$('#transfer').val(transfer_type);
			$('#owner_transfer').val(owner_transfer_type);

			search_ledger(submiturl,methods,start_date,end_date,distributor_id,customer_id,type_id,employee_id,purpose_id,transfer_type,owner_transfer_type);
		});
	});
	function search_ledger(submiturl,methods,start_date,end_date,distributor_id,customer_id,type_id,employee_id,purpose_id,transfer_type,owner_transfer_type)
	{
		var date1 = start_date;
		var new_date = date1;
		var date2 = end_date;
		var j =0;
		var output = '';
		var outputs = '';
		var receipt_deta ='';
		$.ajax
		({
			url: submiturl,
			type: methods,
			dataType: 'json',
			data: {'start':start_date,'end':end_date,'distributor_id':distributor_id,'customer_id':customer_id,'type_id':type_id,'employee_id':employee_id,'purpose_id':purpose_id,'transfer_type':transfer_type,'owner_transfer_type':owner_transfer_type},
			beforeSend: function()
			{
				$(".modal_loader").show();
			},
			success: function(result) 
			{	
				$(".modal_loader").hide();
				if((customer_id!='' || purpose_id==1) || (customer_id!='' && purpose_id==1))
				{
					var final_amount_sum = 0;
					var sale_sum = 0;
					var balance_sum = 0;
					var collection_amount_sum = 0;
					var sale_return_amount_sum = 0;
					var paid_amount_sum =0;
					var return_amount_sum =0;
					var final_amount ='';
					
					if(new_date == '')
					{
						new_date = '2016-01-01';
					}
					if(date2 == '')
					{
						var today = new Date();
						date2 = format(today);
					}
					var balance_amount_all ='';
					var sale_amount_all ='';
					var collection_amount_all ='';
					var sale_return_amount_all ='';
					for(var nnnn=0;nnnn<result.ledger_list2['total_balance_amount_customer'].length;nnnn++)
					{
						balance_sum +=parseFloat(Math.round(result.ledger_list2['total_balance_amount_customer'][nnnn]['int_balance']));
						outputs+='<tr><td></td><td style="width:25%;"></td><td style="width:20%;font-weight:bold;font-size:14px;">Balance Total</td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"></td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance_sum.toFixed(2)+'</td></tr>';
					}
					sale_sum = balance_sum;
					for(var nn=0;nn<result.ledger_list2['total_sale_amount'].length;nn++)
					{
						sale_amount_all =parseFloat(result.ledger_list2['total_sale_amount'][nn]['total_amount_sale']).toFixed(2);
						sale_sum +=parseFloat(Math.round(result.ledger_list2['total_sale_amount'][nn]['total_amount_sale']));
						if(sale_amount_all =='NaN')
						{
							sale_amount_all = '0.00';
						}
						else{
							sale_amount_all = sale_amount_all;
						}
						
						outputs+='<tr><td></td><td style="width:25%;"></td><td style="width:20%;font-weight:bold;font-size:14px;">Sale Total</td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+sale_amount_all+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+sale_sum.toFixed(2)+'</td></tr>';
					}
					
					for(var gg=0;gg<result.ledger_list2['total_sale_collection_amount'].length;gg++)
					{
						
						collection_amount_all =parseFloat(result.ledger_list2['total_sale_collection_amount'][gg]['total_amount_sale_collection']).toFixed(2);
						collection_amount_sum +=parseFloat(Math.round(result.ledger_list2['total_sale_collection_amount'][gg]['total_amount_sale_collection']));
						if(collection_amount_all =='NaN')
						{
							collection_amount_all = '0.00';
							var ans = parseFloat(sale_amount_all - 0.00 + balance_sum).toFixed(2);
						}
						else{
							collection_amount_all = collection_amount_all;
							var ans = parseFloat(sale_amount_all - collection_amount_all + balance_sum).toFixed(2);
						}
						outputs+='<tr><td></td><td style="width:25%;"></td><td style="width:20%;font-weight:bold;font-size:14px;">Collection Total</td><td class="total_amount"></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+collection_amount_all+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+ans+'</td></tr>';
					}
					
					
					
					final_amount_sum = sale_sum;
					paid_amount_sum  = collection_amount_sum;
					while(new_date <= date2)
					{
						for(var ii=0;ii<result.ledger_list2[new_date]['total_sale'].length;ii++)
						{
							final_amount_sum +=parseFloat(Math.round(result.ledger_list2[new_date]['total_sale'][ii]['amount']));
							final_amount =parseFloat(result.ledger_list2[new_date]['total_sale'][ii]['amount']).toFixed(2);
							var tran_purpose = result.ledger_list2[new_date]['total_sale'][ii]['transaction_purpose'];
							if(tran_purpose =='sale_collection_deleted')
							{
								tran_purpose = 'Deleted Cheque';
							}
							else if(tran_purpose =='sale')
							{
								tran_purpose = 'Sale';
							}
							var balance=final_amount_sum-paid_amount_sum;
						
							outputs+='<tr><td title="'+result.ledger_list2[new_date]['total_sale'][ii]['date']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+result.ledger_list2[new_date]['total_sale'][ii]['date']+'</td><td style="width:25%;">'+result.ledger_list2[new_date]['total_sale'][ii]['customer_name']+'</td><td title="'+tran_purpose+' '+result.ledger_list2[new_date]['total_sale'][ii]['transaction_mode']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:20%;"><span style="font-weight:bold;font-size:14px;"> '+tran_purpose+'</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list2[new_date]['total_sale'][ii]['transaction_mode']+'</span><br><span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list2[new_date]['total_sale'][ii]['remarks']+'</span></td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+final_amount+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';
						}
						
						for(var mm=0;mm<result.ledger_list2[new_date]['total_collection'].length;mm++)
						{
							paid_amount_sum +=parseFloat(Math.round(result.ledger_list2[new_date]['total_collection'][mm]['amount']));
						
							var transaction_id=result.ledger_list2[new_date]['total_collection'][mm]['transaction_id'];
							var paid_amount=parseFloat(result.ledger_list2[new_date]['total_collection'][mm]['amount']).toFixed(2);
							var date=result.ledger_list2[new_date]['total_collection'][mm]['date'];
							
							var balance=final_amount_sum-paid_amount_sum;
							outputs+='<tr><td title="'+date+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+date+'</td><td style="width:25%;">'+result.ledger_list2[new_date]['total_collection'][mm]['customer_name']+'</td><td title="Collection #'+transaction_id+' '+result.ledger_list2[new_date]['total_collection'][mm]['transaction_mode']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:20%;"><span style="font-weight:bold;font-size:14px;"> <span style="font-weight:bold;font-size:14px;"> Collection</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list2[new_date]['total_collection'][mm]['transaction_purpose']+'</span><br><span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list2[new_date]['total_collection'][mm]['remarks']+'</span></td><td class="total_amount"></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;text-align:right;" title="'+paid_amount+'">'+paid_amount+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';

						}
						
						date1 = new Date(Date.parse(new_date));
						date1 = date1.add(1).day();
						new_date = format(date1);
						j++;
					}

					var final_sum = parseFloat(final_amount_sum).toFixed(2);
					var final_paid = parseFloat(paid_amount_sum).toFixed(2);
					//var final_return = parseFloat(return_amount_sum).toFixed(2);
					var balance_amount_sum =parseFloat(final_sum - final_paid).toFixed(2);
					$('#total_amount_sum').html(final_sum);
					$('#paid_amount_sum').html(final_paid);
					//$('#return_amount_sum').html(final_return);
					$('#balance_amount_sum').html(balance_amount_sum);
					if(outputs != '')
					{
						$('.search_data').html(outputs);
						$('.ledger_name').html('Customer Sale & Collection Ledger');
						$('.table_head_name').html('Customer Name');
						$('#return_td').show();
						$('#return_tot').show();
						$('.infomsg').show();
						$('.down').show();
						
					}
					else
					{
						$('.search_data').html("No Data Available");
						$('.table_head_name').html('Customer Name');
						$('.ledger_name').html('Customer Sale & Collection Ledger');
						$('#return_td').show();
						$('#return_tot').show();
						$('.infomsg').show();
						$('.down').show();
					}
					$('#start').val('');
					$('#end').val(''); 
				}
				else if((distributor_id!='' || purpose_id==3) || (distributor_id!='' && purpose_id ==3))
				{
					var final_amount_sum = 0;
					var purchase_sum = 0;
					var balance_sum = 0;
					var payment_amount_sum = 0;
					var paid_amount_sum =0;
					var delete_amount_sum =0;
					var final_amount ='';
					
					if(new_date == '')
					{
						new_date = '2016-01-01';
					}
					if(date2 == '')
					{
						var today = new Date();
						date2 = format(today);
					}
					var purchase_amount_all ='';
					var payment_amount_all ='';
					
					for(var ng=0;ng<result.ledger_list['total_balance_amount_distributor'].length;ng++)
					{
						balance_sum +=parseFloat(Math.round(result.ledger_list['total_balance_amount_distributor'][ng]['int_balance']));
						output+='<tr><td></td><td style="width:25%;"></td><td style="width:20%;font-weight:bold;font-size:14px;">Balance Total</td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"></td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance_sum.toFixed(2)+'</td></tr>';
					}
					purchase_sum = balance_sum;
					for(var n=0;n<result.ledger_list['total_purchase_amount'].length;n++)
					{
						purchase_amount_all =parseFloat(result.ledger_list['total_purchase_amount'][n]['total_amount_purchase']).toFixed(2);
						purchase_sum +=parseFloat(Math.round(result.ledger_list['total_purchase_amount'][n]['total_amount_purchase']));
						if(purchase_amount_all =='NaN')
						{
							purchase_amount_all = '0.00';
						}
						else{
							purchase_amount_all = purchase_amount_all;
						}
						
						output+='<tr><td></td><td style="width:25%;"></td><td style="width:20%;font-weight:bold;font-size:14px;">Purchase Total</td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+purchase_amount_all+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+purchase_sum.toFixed(2)+'</td></tr>';
					}
					
					for(var g=0;g<result.ledger_list['total_purchase_payment_amount'].length;g++)
					{
						
						payment_amount_all =parseFloat(result.ledger_list['total_purchase_payment_amount'][g]['total_amount_purchase_payment']).toFixed(2);
						payment_amount_sum +=parseFloat(Math.round(result.ledger_list['total_purchase_payment_amount'][g]['total_amount_purchase_payment']));
						
						if(payment_amount_all =='NaN')
						{
							payment_amount_all = '0.00';
							var ans = parseFloat(purchase_amount_all - 0.00 + balance_sum).toFixed(2);
						}
						else{
							payment_amount_all = payment_amount_all;
							var ans = parseFloat(purchase_amount_all - payment_amount_all + balance_sum).toFixed(2);
						}
						output+='<tr><td></td><td style="width:25%;"></td><td style="width:20%;font-weight:bold;font-size:14px;">Payment Total</td><td class="total_amount"></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+payment_amount_all+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+ans+'</td></tr>';
					}
					
					final_amount_sum = purchase_sum;
					paid_amount_sum  = payment_amount_sum;
					while(new_date <= date2)
					{
						for(var i=0;i<result.ledger_list[new_date]['total_purchase'].length;i++)
						{
							final_amount_sum +=parseFloat(Math.round(result.ledger_list[new_date]['total_purchase'][i]['amount']));
							final_amount =parseFloat(result.ledger_list[new_date]['total_purchase'][i]['amount']).toFixed(2);
							var tran_purpose = result.ledger_list[new_date]['total_purchase'][i]['transaction_purpose'];
							if(tran_purpose =='purchase_payment_deleted'){
								tran_purpose = 'Deleted Cheque';
							}
							var balance=final_amount_sum-paid_amount_sum;
						
							output+='<tr><td title="'+result.ledger_list[new_date]['total_purchase'][i]['date']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+result.ledger_list[new_date]['total_purchase'][i]['date']+'</td><td style="width:25%;">'+result.ledger_list[new_date]['total_purchase'][i]['distributor_name']+'</td><td title="Purchase' +result.ledger_list[new_date]['total_purchase'][i]['transaction_mode']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:20%;"><span style="font-weight:bold;font-size:14px;">'+tran_purpose+'</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list[new_date]['total_purchase'][i]['transaction_mode']+'</span><br><span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list[new_date]['total_purchase'][i]['remarks']+'</span></td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+final_amount+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';
						}
						
						for(var m=0;m<result.ledger_list[new_date]['total_payment'].length;m++)
						{
							paid_amount_sum +=parseFloat(Math.round(result.ledger_list[new_date]['total_payment'][m]['amount']));
						
							var transaction_id=result.ledger_list[new_date]['total_payment'][m]['transaction_id'];
							var paid_amount=parseFloat(result.ledger_list[new_date]['total_payment'][m]['amount']).toFixed(2);
							var date=result.ledger_list[new_date]['total_payment'][m]['date'];
							var tran_purpose = result.ledger_list[new_date]['total_payment'][m]['transaction_purpose'];
							if(tran_purpose =='purchase_return'){
								tran_purpose = 'Purchase Return';
							}
							var balance=final_amount_sum-paid_amount_sum;
							var balance2=final_amount_sum-paid_amount_sum;
							output+='<tr><td title="'+date+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+date+'</td><td style="width:25%;">'+result.ledger_list[new_date]['total_payment'][m]['distributor_name']+'</td><td title="Payment '+result.ledger_list[new_date]['total_payment'][m]['transaction_mode']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:20%;"><span style="font-weight:bold;font-size:14px;"> <span style="font-weight:bold;font-size:14px;">'+tran_purpose+'</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list[new_date]['total_payment'][m]['transaction_mode']+'</span><br><span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list[new_date]['total_payment'][m]['remarks']+'</span></td><td class="total_amount"></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;text-align:right;" title="'+paid_amount+'">'+paid_amount+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';
						}
						/* for(var m=0;m<result.ledger_list[new_date]['total_delete_payment'].length;m++)
						{
							delete_amount_sum +=parseFloat(Math.round(result.ledger_list[new_date]['total_delete_payment'][m]['amount']));
						
							var transaction_id=result.ledger_list[new_date]['total_delete_payment'][m]['transaction_id'];
							var delete_amount=parseFloat(result.ledger_list[new_date]['total_delete_payment'][m]['amount']).toFixed(2);
							var date=result.ledger_list[new_date]['total_delete_payment'][m]['date'];
							var balance=delete_amount_sum - balance2;
							output+='<tr><td title="'+date+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+date+'</td><td style="width:25%;">'+result.ledger_list[new_date]['total_delete_payment'][m]['distributor_name']+'</td><td title="Delete Cheque #'+transaction_id+' '+result.ledger_list[new_date]['total_delete_payment'][m]['transaction_mode']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:20%;"><span style="font-weight:bold;font-size:14px;"> <span style="font-weight:bold;font-size:14px;"> Delete Cheque #'+transaction_id+'</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list[new_date]['total_delete_payment'][m]['transaction_mode']+'</span></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;text-align:right;" title="'+delete_amount+'">'+delete_amount+'</td><td class="total_amount"></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';
						} */
						date1 = new Date(Date.parse(new_date));
						date1 = date1.add(1).day();
						new_date = format(date1);
						j++;
					}

					var final_sum = parseFloat(final_amount_sum).toFixed(2);
					var final_paid = parseFloat(paid_amount_sum).toFixed(2);
					var balance_amount_sum =parseFloat(final_sum - final_paid).toFixed(2);
					$('#total_amount_sum').html(final_sum);
					$('#paid_amount_sum').html(final_paid);
					$('#balance_amount_sum').html(balance_amount_sum);
					if(output != '')
					{
						$('.search_data').html(output);
						$('.ledger_name').html('Distributor Purchase & Payment Ledger');
						$('.table_head_name').html('Distributor Name');
						$('.infomsg').show();
						$('#return_td').hide();
						$('#return_tot').hide();
						$('.down').show();
					}
					else
					{
						$('.search_data').html("No Data Available");
						$('.table_head_name').html('Distributor Name');
						$('.ledger_name').html('Distributor Purchase & Payment Ledger');
						$('.infomsg').show();
						$('.down').show();
						$('#return_td').hide();
						$('#return_tot').hide();
					}
					$('#start').val('');
					$('#end').val(''); 
				}
				else if((type_id!='' || purpose_id==2) || (type_id!='' && purpose_id ==2))
				{
					var final_amount_sum = 0;
					var expense_sum = 0;
					var expense_payment_amount_sum = 0;
					var paid_amount_sum =0;
					var final_amount ='';
					
					if(new_date == '')
					{
						new_date = '2016-01-01';
					}
					if(date2 == '')
					{
						var today = new Date();
						date2 = format(today);
					}
					var expense_amount_all ='';
					var expense_payment_amount_all ='';
					
					for(var n=0;n<result.ledger_list3['total_expense_amount'].length;n++)
					{
						expense_amount_all =parseFloat(result.ledger_list3['total_expense_amount'][n]['total_amount_expense']).toFixed(2);
						expense_sum +=parseFloat(Math.round(result.ledger_list3['total_expense_amount'][n]['total_amount_expense']));
						if(expense_amount_all =='NaN')
						{
							expense_amount_all = '0.00';
						}
						else{
							expense_amount_all = expense_amount_all;
						}
						
						output+='<tr><td></td><td style="width:25%;"></td><td style="width:20%;font-weight:bold;font-size:14px;">Expense Total</td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+expense_amount_all+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+expense_sum.toFixed(2)+'</td></tr>';
					}
					
					for(var g=0;g<result.ledger_list3['total_expense_payment_amount'].length;g++)
					{
						
						expense_payment_amount_all =parseFloat(result.ledger_list3['total_expense_payment_amount'][g]['total_amount_expense_payment']).toFixed(2);
						expense_payment_amount_sum +=parseFloat(Math.round(result.ledger_list3['total_expense_payment_amount'][g]['total_amount_expense_payment']));
						
						if(expense_payment_amount_all =='NaN')
						{
							expense_payment_amount_all = '0.00';
							var ans = parseFloat(expense_amount_all - 0.00).toFixed(2);
						}
						else{
							expense_payment_amount_all = expense_payment_amount_all;
							var ans = parseFloat(expense_amount_all - expense_payment_amount_all).toFixed(2);
						}
						output+='<tr><td></td><td style="width:25%;"></td><td style="width:20%;font-weight:bold;font-size:14px;">Payment Total</td><td class="total_amount"></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+expense_payment_amount_all+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+ans+'</td></tr>';
					}
					
					final_amount_sum = expense_sum;
					paid_amount_sum  = expense_payment_amount_sum;
					while(new_date <= date2)
					{

						
						for(var i=0;i<result.ledger_list3[new_date]['total_expense'].length;i++)
						{
							final_amount_sum +=parseFloat(Math.round(result.ledger_list3[new_date]['total_expense'][i]['amount']));
							final_amount =parseFloat(result.ledger_list3[new_date]['total_expense'][i]['amount']).toFixed(2);
							
							var balance=final_amount_sum-paid_amount_sum;
							var tran_purpose = result.ledger_list3[new_date]['total_expense'][i]['transaction_purpose'];
							if(tran_purpose =='expense_payment_deleted')
							{
								tran_purpose = 'Deleted Cheque';
							}
							else if(tran_purpose =='expense')
							{
								tran_purpose = 'Expense';
							}
							//alert(result.ledger_list3[new_date]['total_expense'][i]['remarks']);
							if(result.ledger_list3[new_date]['total_expense'][i]['employee_name']==null)
							{
								output+='<tr><td title="'+result.ledger_list3[new_date]['total_expense'][i]['date']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+result.ledger_list3[new_date]['total_expense'][i]['date']+'</td><td style="width:25%;">'+result.ledger_list3[new_date]['total_expense'][i]['type_type']+'</span></td><td title="'+tran_purpose+' '+result.ledger_list3[new_date]['total_expense'][i]['transaction_mode']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:20%;"><span style="font-weight:bold;font-size:14px;">'+tran_purpose+' </span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list3[new_date]['total_expense'][i]['transaction_mode']+'</span><br><span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list3[new_date]['total_expense'][i]['remarks']+'</span></td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+final_amount+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';
							}
							else{
								output+='<tr><td title="'+result.ledger_list3[new_date]['total_expense'][i]['date']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+result.ledger_list3[new_date]['total_expense'][i]['date']+'</td><td style="width:25%;">'+result.ledger_list3[new_date]['total_expense'][i]['type_type']+'<br>'+'<span>'+result.ledger_list3[new_date]['total_expense'][i]['employee_name']+'</span></td><td title="'+tran_purpose+' '+result.ledger_list3[new_date]['total_expense'][i]['transaction_mode']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:20%;"><span style="font-weight:bold;font-size:14px;">'+tran_purpose+' </span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list3[new_date]['total_expense'][i]['transaction_mode']+'</span><br><span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list3[new_date]['total_expense'][i]['remarks']+'</span></td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+final_amount+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';
							}
						}
						
						for(var m=0;m<result.ledger_list3[new_date]['total_expense_payment'].length;m++)
						{
							paid_amount_sum +=parseFloat(Math.round(result.ledger_list3[new_date]['total_expense_payment'][m]['amount']));
						
							var transaction_id=result.ledger_list3[new_date]['total_expense_payment'][m]['transaction_id'];
							var paid_amount=parseFloat(result.ledger_list3[new_date]['total_expense_payment'][m]['amount']).toFixed(2);
							var date=result.ledger_list3[new_date]['total_expense_payment'][m]['date'];
							var balance=final_amount_sum-paid_amount_sum;
							if(result.ledger_list3[new_date]['total_expense_payment'][m]['employee_name']==null)
							{
								output+='<tr><td title="'+date+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+date+'</td><td style="width:25%;">'+result.ledger_list3[new_date]['total_expense_payment'][m]['type_type']+'</td><td title="Expense Payment #'+transaction_id+' '+result.ledger_list3[new_date]['total_expense_payment'][m]['transaction_mode']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:20%;"><span style="font-weight:bold;font-size:14px;"> <span style="font-weight:bold;font-size:14px;"> Expense Payment</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list3[new_date]['total_expense_payment'][m]['transaction_mode']+'</span><br><span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list3[new_date]['total_expense_payment'][m]['remarks']+'</span></td><td class="total_amount"></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;text-align:right;" title="'+paid_amount+'">'+paid_amount+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';
							}
							else
							{
								output+='<tr><td title="'+date+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+date+'</td><td style="width:25%;">'+result.ledger_list3[new_date]['total_expense_payment'][m]['type_type']+'<br>'+'<span>'+result.ledger_list3[new_date]['total_expense_payment'][m]['employee_name']+'</span></td><td title="Expense Payment #'+transaction_id+' '+result.ledger_list3[new_date]['total_expense_payment'][m]['transaction_mode']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:20%;"><span style="font-weight:bold;font-size:14px;"> <span style="font-weight:bold;font-size:14px;"> Expense Payment</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list3[new_date]['total_expense_payment'][m]['transaction_mode']+'</span><br><span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list3[new_date]['total_expense_payment'][m]['remarks']+'</span></td><td class="total_amount"></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;text-align:right;" title="'+paid_amount+'">'+paid_amount+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';
							}

						}
						date1 = new Date(Date.parse(new_date));
						date1 = date1.add(1).day();
						new_date = format(date1);
						j++;
					}

					var final_sum = parseFloat(final_amount_sum).toFixed(2);
					var final_paid = parseFloat(paid_amount_sum).toFixed(2);
					var balance_amount_sum =parseFloat(final_sum - final_paid).toFixed(2);
					$('#total_amount_sum').html(final_sum);
					$('#paid_amount_sum').html(final_paid);
					$('#balance_amount_sum').html(balance_amount_sum);
					if(output != '')
					{
						$('.search_data').html(output);
						$('.ledger_name').html('Expense & Payment Ledger');
						$('.table_head_name').html('Type / Ledger');
						$('.infomsg').show();
						$('.down').show();
						$('#return_td').hide();
						$('#return_tot').hide();
					}
					else
					{
						$('.search_data').html("No Data Available");
						$('.table_head_name').html('Service Provider Name');
						$('.ledger_name').html('Expense & Payment Ledger');
						$('.infomsg').show();
						$('.down').show();
						$('#return_td').hide();
						$('#return_tot').hide();
					}
					$('#start').val('');
					$('#end').val(''); 
				}
				else if((transfer_type!='' || purpose_id==4) || (transfer_type!='' && purpose_id ==4))
				{
					var final_amount_sum = 0;
					var to_bank_sum = 0;
					var from_bank_amount_sum = 0;
					var paid_amount_sum =0;
					var final_amount ='';
					
					if(new_date == '')
					{
						new_date = '2016-01-01';
					}
					if(date2 == '')
					{
						var today = new Date();
						date2 = format(today);
					}
					var to_bank_amount_all ='';
					var from_bank_amount_all ='';
					
					for(var nnn=0;nnn<result.ledger_list4['total_to_bank_amount'].length;nnn++)
					{
						to_bank_amount_all =parseFloat(result.ledger_list4['total_to_bank_amount'][nnn]['total_amount_to_bank']).toFixed(2);
						to_bank_sum +=parseFloat(Math.round(result.ledger_list4['total_to_bank_amount'][nnn]['total_amount_to_bank']));
						if(to_bank_amount_all =='NaN')
						{
							to_bank_amount_all = '0.00';
						}
						else{
							to_bank_amount_all = to_bank_amount_all;
						}
						
						output+='<tr><td></td><td style="width:25%;"></td><td style="width:20%;font-weight:bold;font-size:14px;">To Bank Total</td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+to_bank_amount_all+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+to_bank_sum.toFixed(2)+'</td></tr>';
					}
					
					for(var ggg=0;ggg<result.ledger_list4['total_from_bank_amount'].length;ggg++)
					{
						
						from_bank_amount_all =parseFloat(result.ledger_list4['total_from_bank_amount'][ggg]['total_amount_from_bank']).toFixed(2);
						from_bank_amount_sum +=parseFloat(Math.round(result.ledger_list4['total_from_bank_amount'][ggg]['total_amount_from_bank']));
						
						if(from_bank_amount_all =='NaN')
						{
							from_bank_amount_all = '0.00';
							var ans = parseFloat(to_bank_amount_all - 0.00).toFixed(2);
						}
						else{
							from_bank_amount_all = from_bank_amount_all;
							var ans = parseFloat(to_bank_amount_all - from_bank_amount_all).toFixed(2);
						}
						output+='<tr><td></td><td style="width:25%;"></td><td style="width:20%;font-weight:bold;font-size:14px;">From Bank Total</td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+from_bank_amount_all+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+ans+'</td></tr>';
					}
					
					final_amount_sum = to_bank_sum;
					paid_amount_sum  = from_bank_amount_sum;
					while(new_date <= date2)
					{

						
						for(var iii=0;iii<result.ledger_list4[new_date]['total_to_bank'].length;iii++)
						{
							final_amount_sum +=parseFloat(Math.round(result.ledger_list4[new_date]['total_to_bank'][iii]['amount']));
							final_amount =parseFloat(result.ledger_list4[new_date]['total_to_bank'][iii]['amount']).toFixed(2);
							
							var balance=final_amount_sum-paid_amount_sum;
						
							output+='<tr><td title="'+result.ledger_list4[new_date]['total_to_bank'][iii]['date']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+result.ledger_list4[new_date]['total_to_bank'][iii]['date']+'</td><td style="width:25%;">'+result.ledger_list4[new_date]['total_to_bank'][iii]['service_provider_name']+'</td><td title="To Bank #'+result.ledger_list4[new_date]['total_to_bank'][iii]['transaction_id']+' '+result.ledger_list4[new_date]['total_to_bank'][iii]['transaction_mode']+' '+result.ledger_list4[new_date]['total_to_bank'][iii]['bank_name']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:20%;"><span style="font-weight:bold;font-size:14px;"> To Bank #'+result.ledger_list4[new_date]['total_to_bank'][iii]['transaction_id']+'</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list4[new_date]['total_to_bank'][iii]['transaction_mode']+'</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list4[new_date]['total_to_bank'][iii]['bank_name']+'</span></td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+final_amount+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';
						}
						
						for(var mmm=0;mmm<result.ledger_list4[new_date]['total_from_bank'].length;mmm++)
						{
							paid_amount_sum +=parseFloat(Math.round(result.ledger_list4[new_date]['total_from_bank'][mmm]['amount']));
						
							var transaction_id=result.ledger_list4[new_date]['total_from_bank'][mmm]['transaction_id'];
							var paid_amount=parseFloat(result.ledger_list4[new_date]['total_from_bank'][mmm]['amount']).toFixed(2);
							var date=result.ledger_list4[new_date]['total_from_bank'][mmm]['date'];
							var balance=final_amount_sum-paid_amount_sum;
							output+='<tr><td title="'+date+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+date+'</td><td style="width:25%;">'+result.ledger_list4[new_date]['total_from_bank'][mmm]['service_provider_name']+'</td><td title="From Bank #'+transaction_id+' '+result.ledger_list4[new_date]['total_from_bank'][mmm]['transaction_mode']+' '+result.ledger_list4[new_date]['total_from_bank'][mmm]['bank_name']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:20%;"><span style="font-weight:bold;font-size:14px;"> <span style="font-weight:bold;font-size:14px;"> From Bank #'+transaction_id+'</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list4[new_date]['total_from_bank'][mmm]['transaction_mode']+'</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list4[new_date]['total_from_bank'][mmm]['bank_name']+'</span></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;text-align:right;" title="'+paid_amount+'">'+paid_amount+'</td><td class="total_amount"></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';

						}
						date1 = new Date(Date.parse(new_date));
						date1 = date1.add(1).day();
						new_date = format(date1);
						j++;
					}

					var final_sum = parseFloat(final_amount_sum).toFixed(2);
					var final_paid = parseFloat(paid_amount_sum).toFixed(2);
					var balance_amount_sum =parseFloat(final_sum - final_paid).toFixed(2);
					$('#total_amount_sum').html(final_sum);
					$('#paid_amount_sum').html(final_paid);
					$('#balance_amount_sum').html(balance_amount_sum);
					if(output != '')
					{
						$('.search_data').html(output);
						$('.ledger_name').html('Bank Transfer Ledger');
						$('.table_head_name').html('Provider Name');
						$('.infomsg').show();
						$('.down').show();
						$('#return_td').hide();
						$('#return_tot').hide();
					}
					else
					{
						$('.search_data').html("No Data Available");
						$('.table_head_name').html('Provider Name');
						$('.ledger_name').html('Bank Transfer Ledger');
						$('.infomsg').show();
						$('.down').show();
						$('#return_td').hide();
						$('#return_tot').hide();
					}
					$('#start').val('');
					$('#end').val(''); 
				}
				
				else if((owner_transfer_type!='' || purpose_id==5) || (owner_transfer_type!='' && purpose_id ==5))
				{
					var final_amount_sum = 0;
					var to_owner_sum = 0;
					var from_owner_amount_sum = 0;
					var paid_amount_sum =0;
					var final_amount ='';
					
					if(new_date == '')
					{
						new_date = '2016-01-01';
					}
					if(date2 == '')
					{
						var today = new Date();
						date2 = format(today);
					}
					var to_owner_amount_all ='';
					var from_owner_amount_all ='';
					
					for(var nnnnn=0;nnnnn<result.ledger_list5['total_to_owner_amount'].length;nnnnn++)
					{
						to_owner_amount_all =parseFloat(result.ledger_list5['total_to_owner_amount'][nnnnn]['total_amount_to_owner']).toFixed(2);
						to_owner_sum +=parseFloat(Math.round(result.ledger_list5['total_to_owner_amount'][nnnnn]['total_amount_to_owner']));
						if(to_owner_amount_all =='NaN')
						{
							to_owner_amount_all = '0.00';
						}
						else{
							to_owner_amount_all = to_owner_amount_all;
						}
						
						output+='<tr><td></td><td style="width:25%;"></td><td style="width:20%;font-weight:bold;font-size:14px;">To Owner Total</td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+to_owner_amount_all+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+to_owner_sum.toFixed(2)+'</td></tr>';
					}
					
					for(var ggggg=0;ggggg<result.ledger_list5['total_from_owner_amount'].length;ggggg++)
					{
						
						from_owner_amount_all =parseFloat(result.ledger_list5['total_from_owner_amount'][ggggg]['total_amount_from_owner']).toFixed(2);
						from_owner_amount_sum +=parseFloat(Math.round(result.ledger_list5['total_from_owner_amount'][ggggg]['total_amount_from_owner']));
						
						if(from_owner_amount_all =='NaN')
						{
							from_owner_amount_all = '0.00';
							var ans = parseFloat(to_owner_amount_all - 0.00).toFixed(2);
						}
						else{
							from_owner_amount_all = from_owner_amount_all;
							var ans = parseFloat(to_owner_amount_all - from_owner_amount_all).toFixed(2);
						}
						output+='<tr><td></td><td style="width:25%;"></td><td style="width:20%;font-weight:bold;font-size:14px;">From Owner Total</td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+from_owner_amount_all+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+ans+'</td></tr>';
					}
					
					final_amount_sum = to_owner_sum;
					paid_amount_sum  = from_owner_amount_sum;
					while(new_date <= date2)
					{

						
						for(var iiiii=0;iiiii<result.ledger_list5[new_date]['total_to_owner'].length;iiiii++)
						{
							final_amount_sum +=parseFloat(Math.round(result.ledger_list5[new_date]['total_to_owner'][iiiii]['amount']));
							final_amount =parseFloat(result.ledger_list5[new_date]['total_to_owner'][iiiii]['amount']).toFixed(2);
							
							var balance=final_amount_sum-paid_amount_sum;
						
							output+='<tr><td title="'+result.ledger_list5[new_date]['total_to_owner'][iiiii]['date']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+result.ledger_list5[new_date]['total_to_owner'][iiiii]['date']+'</td><td style="width:25%;">'+result.ledger_list5[new_date]['total_to_owner'][iiiii]['owner_name']+'</td><td title="To owner #'+result.ledger_list5[new_date]['total_to_owner'][iiiii]['transaction_id']+' '+result.ledger_list5[new_date]['total_to_owner'][iiiii]['transaction_mode']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:20%;"><span style="font-weight:bold;font-size:14px;"> To Owner #'+result.ledger_list5[new_date]['total_to_owner'][iiiii]['transaction_id']+'</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list5[new_date]['total_to_owner'][iiiii]['transaction_mode']+'</span></td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+final_amount+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';
						}
						
						for(var mmmmm=0;mmmmm<result.ledger_list5[new_date]['total_from_owner'].length;mmmmm++)
						{
							paid_amount_sum +=parseFloat(Math.round(result.ledger_list5[new_date]['total_from_owner'][mmmmm]['amount']));
						
							var transaction_id=result.ledger_list5[new_date]['total_from_owner'][mmmmm]['transaction_id'];
							var paid_amount=parseFloat(result.ledger_list5[new_date]['total_from_owner'][mmmmm]['amount']).toFixed(2);
							var date=result.ledger_list5[new_date]['total_from_owner'][mmmmm]['date'];
							var balance=final_amount_sum-paid_amount_sum;
							output+='<tr><td title="'+date+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+date+'</td><td style="width:25%;">'+result.ledger_list5[new_date]['total_from_owner'][mmmmm]['owner_name']+'</td><td title="From Owner #'+transaction_id+' '+result.ledger_list5[new_date]['total_from_owner'][mmmmm]['transaction_mode']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:25%;"><span style="font-weight:bold;font-size:14px;"> <span style="font-weight:bold;font-size:14px;"> From Owner #'+transaction_id+'</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list5[new_date]['total_from_owner'][mmmmm]['transaction_mode']+'</span></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;text-align:right;" title="'+paid_amount+'">'+paid_amount+'</td><td class="total_amount"></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';

						}
						date1 = new Date(Date.parse(new_date));
						date1 = date1.add(1).day();
						new_date = format(date1);
						j++;
					}

					var final_sum = parseFloat(final_amount_sum).toFixed(2);
					var final_paid = parseFloat(paid_amount_sum).toFixed(2);
					var balance_amount_sum =parseFloat(final_sum - final_paid).toFixed(2);
					$('#total_amount_sum').html(final_sum);
					$('#paid_amount_sum').html(final_paid);
					$('#balance_amount_sum').html(balance_amount_sum);
					if(output != '')
					{
						$('.search_data').html(output);
						$('.ledger_name').html('Owner Transfer Ledger');
						$('.table_head_name').html('Owner Name');
						$('.infomsg').show();
						$('.down').show();
						$('#return_td').hide();
						$('#return_tot').hide();
					}
					else
					{
						$('.search_data').html("No Data Available");
						$('.table_head_name').html('Owner Name');
						$('.ledger_name').html('Owner Transfer Ledger');
						$('.infomsg').show();
						$('.down').show();
						$('#return_td').hide();
						$('#return_tot').hide();
					}
					$('#start').val('');
					$('#end').val(''); 
				}
			}
		});
	};
	function format(date) {
	  date = new Date(date);

	  var day = ('0' + date.getDate()).slice(-2);
	  var month = ('0' + (date.getMonth() + 1)).slice(-2);
	  var year = date.getFullYear();

	  return year + '-' + month + '-' + day;
	}
	
	$(document).ready(function()
	{
		$("#down").click(function(event2) 
		{
			event2.preventDefault();
			submiturl = $(this).attr('href');
			var distributor 		= $('#distributor').val();
			var customer 			= $('#customer').val();
			var service_provider 	= $('#service_provider').val();
			var employee 			= $('#employee').val();
			var type 				= $('#type').val();
			var purpose 			= $('#purpose').val();
			var owner_transfer 		= $('#owner_transfer').val();
			var transfer 			= $('#transfer').val();
			var start_date 			= $('#start_date').val();
			var end_date 			= $('#end_date').val();
			
			if(distributor == ''){
				distributor = 'null';
			}
			if(customer == ''){
				customer = 'null';
			}
			if(owner_transfer == ''){
				owner_transfer = 'null';
			}
			if(service_provider == ''){
				service_provider = 'null';
			}
			if(purpose == ''){
				purpose = 'null';
			}
			if(transfer == ''){
				transfer = 'null';
			}
			if(start_date == ''){
				start_date = 'null';
			}
			
			if(end_date == ''){
				end_date = 'null';
			}
			if(employee == ''){
				employee = 'null';
			}
			if(type == ''){
				type = 'null';
			}
			window.open(submiturl+'/'+distributor+'/'+customer+'/'+purpose+'/'+transfer+'/'+start_date+'/'+end_date+'/'+owner_transfer+'/'+type+'/'+employee,'_blank');
		});
	});
</script>
</div>
=======
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
	.wrap table .new_data tr td {
		border: 1.5px solid #ffe8e8;
		background: white;
	}
	.wrap table tr td {
		padding: 5px;
		border: 1.5px solid #ffe8e8;
		width: 100px;
		word-wrap: break-word;
		background: white;
	}
	.wrap table.head tr td {
		color:white;
		background: #4d89a7;
		font-size:14px;
		font-family:Helvetica Neue,Helvetica,Arial,sans-serif,Solaimanlipi; 
		font-weight:normal;
	}

	.new_data_2 tr:nth-child(even) td {
		background-color: #e4f1ff;
	}
	.new_data_2 tr:nth-child(odd) td {
		background-color: #fff;
	}
	.inner_table {
		color:#333;
		height: 280px;
		width: 100%;
		font-size:12px;
		font-family:Helvetica Neue,Helvetica,Arial,sans-serif,Solaimanlipi; 
		font-weight:normal;
		overflow-y: auto !important;
	}

	.inner_table::-webkit-scrollbar {
		width: 6px;
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
	.modal_loader
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
	.right_body_full{
		max-height:350px;
		margin-top: 10px;
		width: 550px;
		float: left;
		overflow-y: auto !important;
		border-top: 1px dashed #dcdcdc;
	}
	.right_body_full::-webkit-scrollbar {
		width: 2px;
		background-color: #2d3335;
	}

	.right_body_full::-webkit-scrollbar-track {
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
		background-color: white;
	}

	.right_body_full::-webkit-scrollbar-thumb {
	   background-color: #448ca6;
	   background-image: -webkit-linear-gradient(45deg,rgba(255, 255, 255, .2) 25%,transparent 25%,transparent 50%,rgba(255, 255, 255, .2) 50%,rgba(255, 255, 255, .2) 75%,transparent 75%,transparent)

	}
	</style>
	<input type="hidden" id="start_date">
	<input type="hidden" id="end_date">
	<input type="hidden" id="distributor">
	<input type="hidden" id="customer">
	<input type="hidden" id="service_provider">
	<input type="hidden" id="type">
	<input type="hidden" id="employee">
	<input type="hidden" id="purpose">
	<input type="hidden" id="transfer">
	<input type="hidden" id="owner_transfer">
	<section class="content-2">
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-header with-border" style="background: #0f77ab;">
						<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Ledger</h3>
					</div>
					<div class="box-body">
						<input type="hidden" id="action" >
						<form class="form-horizontal" id="form_2" method="post" action="<?php echo base_url();?>account_controller/all_ledger_report_find">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-1 control-label">Purpose</label>
								<div class="col-sm-2">
									<select class="form-control select2 ledger input-sm" id="purpose_id" name="purpose_id" tabindex="-1" aria-hidden="true" required="on">
										<option value="">Select Purpose</option>
										<option value="1">Customer Sale</option>
										<option value="2">Expense</option>
										<option value="3">Purchase</option>
										<option value="4">Bank Transfer</option>
										<option value="5">Owner Transfer</option>
									</select>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label" style="display:none;" id="dist_label">Ledger</label>
								<div class="col-sm-2" style="display:none;" id="dist_list">
									<?php 
											echo form_dropdown('distributor_id', $distributor_info,'','style="width:100%;" class="form-control select2 ledger input-sm" id="distributor_id" tabindex="-1" aria-hidden="true"');
										?>
								</div>
								<label for="inputEmail3" style="display:none;" class="col-sm-1 control-label" id="cust_label">Ledger</label>
								<div class="col-sm-2" style="display:none;" id="cust_list">
									<?php 
											echo form_dropdown('customer_id', $customer_info,'','style="width:100%;" class="form-control select2 ledger input-sm" id="customer_id" tabindex="-1" aria-hidden="true"');
										?>
								</div>
								<!--label for="inputEmail3" class="col-sm-1 control-label" style="display:none;" id="ser_label">Ledger</label>
								<div class="col-sm-2" style="display:none;" id="ser_list">
									<?php 
										echo form_dropdown('service_provider_id', $service_provider_info,'','style="width:100%;" class="form-control select2 ledger input-sm" id="service_provider_id" tabindex="-1" aria-hidden="true"');
									?>
								</div-->
								<label for="inputEmail3" class="col-sm-1 control-label" style="display:none;" id="exp_type_label">Type</label>
								<div class="col-sm-2" style="display:none;" id="exp_type_list">
									<?php 
										echo form_dropdown('type_id', $expense_type,'','style="width:100%;" class="form-control select2 ledger input-sm" id="type_id" tabindex="-1" aria-hidden="true"');
									?>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label" style="display:none;" id="emp_label">Employee</label>
								<div class="col-sm-2" style="display:none;" id="emp_list">
									<?php 
										echo form_dropdown('employee_id', $employee_info,'','style="width:100%;" class="form-control select2 ledger input-sm" id="employee_id" tabindex="-1" aria-hidden="true"');
									?>
								</div>
								
								<label for="inputEmail3" class="col-sm-1 control-label" style="display:none;" id="type_label">Type</label>
								<div class="col-sm-2" style="display:none;" id="type_list">
									<select style="width:100%;" class="form-control select2 input-sm" id="transfer_type" tabindex="-1" aria-hidden="true">
										<option value="">Select Type</option>
										<option value="to_bank">To Bank</option>
										<option value="from_bank">From Bank</option>
									</select>
								</div>
								<label for="inputEmail3" class="col-sm-1 control-label" style="display:none;" id="own_type_label">Type</label>
								<div class="col-sm-2" style="display:none;" id="own_type_list">
									<select style="width:100%;" class="form-control select2 input-sm" id="owner_transfer_type" tabindex="-1" aria-hidden="true">
										<option value="">Select Type</option>
										<option value="to_owner">To Owner</option>
										<option value="from_owner">From Owner</option>
									</select>
								</div>
							<!--/div>
							<div class="form-group"-->
								<label for="inputEmail3" class="col-sm-1 control-label">Date</label>
								<div class="col-sm-2" style="width: 10.666667%;">
									<?php 
										echo form_input('start_date', '','class ="form-control" id="start" placeholder="Start Date" autocomplete="off"');
									?>
								</div>
								<div class="col-sm-2" style="width: 10.666667%;">
									<?php 
										echo form_input('end_date', '','class ="form-control" id="end" placeholder="End Date" autocomplete="off"');
									?>
								</div>
								
							</div>
							<div class="form-group">
								<div class="col-sm-4">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" id="form_submit"><i class="fa fa-fw fa-search"></i> Search</button>
									<a href="<?php echo base_url();?>account_controller/all_ledger_report_print" id="down" style="display:none;" target="_blank" class="btn btn-primary btn-sm down"><i class="fa fa-download"></i> Print</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<div class="modal_loader" style="display: none">
		<div class="center">
			<img src="<?php echo base_url();?>assets/assets2/spin.gif" id="loaderIcon"/>
		</div>
	</div>

	<section class="content-3 infomsg" id="infomsg" style="display:none;">
		<div class="row">
			<div class="col-md-12">
				<div class="box">	 
					<div class="box-body">
						<div class="box-header with-border" style="background: #2fa9a9;">
							<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"><span class="ledger_name" style="color: #394446;text-align:center;"></span></h3>
						</div>
						<div class="wrap">
							<table class="head">
								<tr>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;">Date</td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;width:25%;"><span class="table_head_name"></span></td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;width:20%;">Details</td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">Total Amount</td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">Paid Amount</td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">Balance</td>
								</tr>
							</table>
							<div class="inner_table">
							<table class="new_data_2 search_data" id="search_data"></table>
							
							</div>
							<table class="head">
								<tr>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;"></td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;width:25%;"></td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:left;width:20%;"></td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="total_amount_sum" style="color:black;font-weight:bold;"></span></td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="paid_amount_sum" style="color:black;font-weight:bold;"></span></td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"><span id="balance_amount_sum" style="color:black;font-weight:bold;"></span></td>
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
		$("#purpose_id").on("change",function()
		{
			
			var purpose_id = $(this).val();
			if(purpose_id == 3) 
			{
				$('#exp_type_label').hide();
				$('#exp_type_list').hide();
				$('#emp_label').hide();
				$('#emp_list').hide();
				$('#dist_label').show();
				$('#dist_list').show();
				$('#distributor_id').attr('required',true);
				$('#customer_id').attr('required',false);
				$('#service_provider_id').attr('required',false);
				$('#cust_label').hide();
				$('#cust_list').hide();
				$('#ser_label').hide();
				$('#ser_list').hide();
				$('#type_label').hide();
				$('#type_list').hide();
				$('#own_type_label').hide();
				$('#own_type_list').hide();
				$('#customer_id').val('');
				$('#customer_id').select2();
				$('#service_provider_id').val('');
				$('#service_provider_id').select2();
				$('#transfer_type').val('');
				$('#transfer_type').select2();
				$('#owner_transfer_type').val('');
				$('#owner_transfer_type').select2();
			} 
			else if(purpose_id == 1) 
			{
				$('#exp_type_label').hide();
				$('#exp_type_list').hide();
				$('#emp_label').hide();
				$('#emp_list').hide();
				$('#dist_label').hide();
				$('#dist_list').hide();
				$('#distributor_id').attr('required',false);
				$('#customer_id').attr('required',true);
				$('#service_provider_id').attr('required',false);
				$('#cust_label').show();
				$('#cust_list').show();
				$('#ser_label').hide();
				$('#ser_list').hide();
				$('#type_label').hide();
				$('#type_list').hide();
				$('#own_type_label').hide();
				$('#own_type_list').hide();
				$('#distributor_id').val('');
				$('#distributor_id').select2();
				$('#service_provider_id').val('');
				$('#service_provider_id').select2();
				$('#transfer_type').val('');
				$('#transfer_type').select2();
				$('#owner_transfer_type').val('');
				$('#owner_transfer_type').select2();
			} 
			else if(purpose_id == 2) 
			{
				$('#exp_type_label').show();
				$('#exp_type_list').show();
				$('#emp_label').show();
				$('#emp_list').show();
				$('#dist_label').hide();
				$('#dist_list').hide();
				
				$('#cust_label').hide();
				$('#cust_list').hide();
				$('#type_label').hide();
				$('#type_list').hide();
				$('#own_type_label').hide();
				$('#own_type_list').hide();
				$('#ser_label').show();
				$('#ser_list').show();
				$('#distributor_id').attr('required',false);
				$('#customer_id').attr('required',false);
				//$('#service_provider_id').attr('required',true);
				$('#customer_id').val('');
				$('#customer_id').select2();
				$('#distributor_id').val('');
				$('#distributor_id').select2();
				$('#transfer_type').val('');
				$('#transfer_type').select2();
				$('#owner_transfer_type').val('');
				$('#owner_transfer_type').select2();
				
			} 
			else if(purpose_id == 4) 
			{
				$('#exp_type_label').hide();
				$('#exp_type_list').hide();
				$('#emp_label').hide();
				$('#emp_list').hide();
				$('#dist_label').hide();
				$('#dist_list').hide();
				$('#cust_label').hide();
				$('#cust_list').hide();
				$('#ser_label').hide();
				$('#ser_list').hide();
				$('#type_label').show();
				$('#type_list').show();
				$('#distributor_id').attr('required',false);
				$('#customer_id').attr('required',false);
				$('#service_provider_id').attr('required',false);
				$('#own_type_label').hide();
				$('#own_type_list').hide();
				$('#customer_id').val('');
				$('#customer_id').select2();
				$('#distributor_id').val('');
				$('#distributor_id').select2();
				$('#service_provider_id').val('');
				$('#service_provider_id').select2();
				$('#owner_transfer_type').val('');
				$('#owner_transfer_type').select2();
			} 
			
			else if(purpose_id == 5) 
			{
				$('#exp_type_label').hide();
				$('#exp_type_list').hide();
				$('#emp_label').hide();
				$('#emp_list').hide();
				$('#dist_label').hide();
				$('#dist_list').hide();
				$('#cust_label').hide();
				$('#cust_list').hide();
				$('#ser_label').hide();
				$('#ser_list').hide();
				$('#type_label').hide();
				$('#type_list').hide();
				$('#own_type_label').show();
				$('#own_type_list').show();
				$('#distributor_id').attr('required',false);
				$('#customer_id').attr('required',false);
				$('#service_provider_id').attr('required',false);
				$('#customer_id').val('');
				$('#customer_id').select2();
				$('#distributor_id').val('');
				$('#distributor_id').select2();
				$('#service_provider_id').val('');
				$('#service_provider_id').select2();
				$('#transfer_type').val('');
				$('#transfer_type').select2();
			} 
		});
	});
	$(document).ready(function () 
	{
		$('#form_2').submit(function(evv)
		{
			
			evv.preventDefault();
			var submiturl = $(this).attr('action');
			var methods = $(this).attr('method');
			var start_date = $('#start').val();
			var end_date = $('#end').val();
			var distributor_id = $('#distributor_id').val();
			var customer_id = $('#customer_id').val();
			var type_id = $('#type_id').val();
			var employee_id = $('#employee_id').val();
			var purpose_id = $('#purpose_id').val();
			var transfer_type = $('#transfer_type').val();
			var owner_transfer_type = $('#owner_transfer_type').val();
			//alert(type_id);
			$('#start_date').val(start_date);
			$('#end_date').val(end_date);
			$('#distributor').val(distributor_id);
			$('#customer').val(customer_id);
			$('#type').val(type_id);
			$('#employee').val(employee_id);
			$('#purpose').val(purpose_id);
			$('#transfer').val(transfer_type);
			$('#owner_transfer').val(owner_transfer_type);

			search_ledger(submiturl,methods,start_date,end_date,distributor_id,customer_id,type_id,employee_id,purpose_id,transfer_type,owner_transfer_type);
		});
	});
	function search_ledger(submiturl,methods,start_date,end_date,distributor_id,customer_id,type_id,employee_id,purpose_id,transfer_type,owner_transfer_type)
	{
		var date1 = start_date;
		var new_date = date1;
		var date2 = end_date;
		var j =0;
		var output = '';
		var outputs = '';
		var receipt_deta ='';
		$.ajax
		({
			url: submiturl,
			type: methods,
			dataType: 'json',
			data: {'start':start_date,'end':end_date,'distributor_id':distributor_id,'customer_id':customer_id,'type_id':type_id,'employee_id':employee_id,'purpose_id':purpose_id,'transfer_type':transfer_type,'owner_transfer_type':owner_transfer_type},
			beforeSend: function()
			{
				$(".modal_loader").show();
			},
			success: function(result) 
			{	
				$(".modal_loader").hide();
				if((customer_id!='' || purpose_id==1) || (customer_id!='' && purpose_id==1))
				{
					var final_amount_sum = 0;
					var sale_sum = 0;
					var balance_sum = 0;
					var collection_amount_sum = 0;
					var sale_return_amount_sum = 0;
					var paid_amount_sum =0;
					var return_amount_sum =0;
					var final_amount ='';
					
					if(new_date == '')
					{
						new_date = '2016-01-01';
					}
					if(date2 == '')
					{
						var today = new Date();
						date2 = format(today);
					}
					var balance_amount_all ='';
					var sale_amount_all ='';
					var collection_amount_all ='';
					var sale_return_amount_all ='';
					for(var nnnn=0;nnnn<result.ledger_list2['total_balance_amount_customer'].length;nnnn++)
					{
						balance_sum +=parseFloat(Math.round(result.ledger_list2['total_balance_amount_customer'][nnnn]['int_balance']));
						outputs+='<tr><td></td><td style="width:25%;"></td><td style="width:20%;font-weight:bold;font-size:14px;">Balance Total</td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"></td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance_sum.toFixed(2)+'</td></tr>';
					}
					sale_sum = balance_sum;
					for(var nn=0;nn<result.ledger_list2['total_sale_amount'].length;nn++)
					{
						sale_amount_all =parseFloat(result.ledger_list2['total_sale_amount'][nn]['total_amount_sale']).toFixed(2);
						sale_sum +=parseFloat(Math.round(result.ledger_list2['total_sale_amount'][nn]['total_amount_sale']));
						if(sale_amount_all =='NaN')
						{
							sale_amount_all = '0.00';
						}
						else{
							sale_amount_all = sale_amount_all;
						}
						
						outputs+='<tr><td></td><td style="width:25%;"></td><td style="width:20%;font-weight:bold;font-size:14px;">Sale Total</td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+sale_amount_all+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+sale_sum.toFixed(2)+'</td></tr>';
					}
					
					for(var gg=0;gg<result.ledger_list2['total_sale_collection_amount'].length;gg++)
					{
						
						collection_amount_all =parseFloat(result.ledger_list2['total_sale_collection_amount'][gg]['total_amount_sale_collection']).toFixed(2);
						collection_amount_sum +=parseFloat(Math.round(result.ledger_list2['total_sale_collection_amount'][gg]['total_amount_sale_collection']));
						if(collection_amount_all =='NaN')
						{
							collection_amount_all = '0.00';
							var ans = parseFloat(sale_amount_all - 0.00 + balance_sum).toFixed(2);
						}
						else{
							collection_amount_all = collection_amount_all;
							var ans = parseFloat(sale_amount_all - collection_amount_all + balance_sum).toFixed(2);
						}
						outputs+='<tr><td></td><td style="width:25%;"></td><td style="width:20%;font-weight:bold;font-size:14px;">Collection Total</td><td class="total_amount"></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+collection_amount_all+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+ans+'</td></tr>';
					}
					
					
					
					final_amount_sum = sale_sum;
					paid_amount_sum  = collection_amount_sum;
					while(new_date <= date2)
					{
						for(var ii=0;ii<result.ledger_list2[new_date]['total_sale'].length;ii++)
						{
							final_amount_sum +=parseFloat(Math.round(result.ledger_list2[new_date]['total_sale'][ii]['amount']));
							final_amount =parseFloat(result.ledger_list2[new_date]['total_sale'][ii]['amount']).toFixed(2);
							var tran_purpose = result.ledger_list2[new_date]['total_sale'][ii]['transaction_purpose'];
							if(tran_purpose =='sale_collection_deleted')
							{
								tran_purpose = 'Deleted Cheque';
							}
							else if(tran_purpose =='sale')
							{
								tran_purpose = 'Sale';
							}
							var balance=final_amount_sum-paid_amount_sum;
						
							outputs+='<tr><td title="'+result.ledger_list2[new_date]['total_sale'][ii]['date']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+result.ledger_list2[new_date]['total_sale'][ii]['date']+'</td><td style="width:25%;">'+result.ledger_list2[new_date]['total_sale'][ii]['customer_name']+'</td><td title="'+tran_purpose+' '+result.ledger_list2[new_date]['total_sale'][ii]['transaction_mode']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:20%;"><span style="font-weight:bold;font-size:14px;"> '+tran_purpose+'</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list2[new_date]['total_sale'][ii]['transaction_mode']+'</span><br><span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list2[new_date]['total_sale'][ii]['remarks']+'</span></td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+final_amount+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';
						}
						
						for(var mm=0;mm<result.ledger_list2[new_date]['total_collection'].length;mm++)
						{
							paid_amount_sum +=parseFloat(Math.round(result.ledger_list2[new_date]['total_collection'][mm]['amount']));
						
							var transaction_id=result.ledger_list2[new_date]['total_collection'][mm]['transaction_id'];
							var paid_amount=parseFloat(result.ledger_list2[new_date]['total_collection'][mm]['amount']).toFixed(2);
							var date=result.ledger_list2[new_date]['total_collection'][mm]['date'];
							
							var balance=final_amount_sum-paid_amount_sum;
							outputs+='<tr><td title="'+date+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+date+'</td><td style="width:25%;">'+result.ledger_list2[new_date]['total_collection'][mm]['customer_name']+'</td><td title="Collection #'+transaction_id+' '+result.ledger_list2[new_date]['total_collection'][mm]['transaction_mode']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:20%;"><span style="font-weight:bold;font-size:14px;"> <span style="font-weight:bold;font-size:14px;"> Collection</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list2[new_date]['total_collection'][mm]['transaction_purpose']+'</span><br><span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list2[new_date]['total_collection'][mm]['remarks']+'</span></td><td class="total_amount"></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;text-align:right;" title="'+paid_amount+'">'+paid_amount+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';

						}
						
						date1 = new Date(Date.parse(new_date));
						date1 = date1.add(1).day();
						new_date = format(date1);
						j++;
					}

					var final_sum = parseFloat(final_amount_sum).toFixed(2);
					var final_paid = parseFloat(paid_amount_sum).toFixed(2);
					//var final_return = parseFloat(return_amount_sum).toFixed(2);
					var balance_amount_sum =parseFloat(final_sum - final_paid).toFixed(2);
					$('#total_amount_sum').html(final_sum);
					$('#paid_amount_sum').html(final_paid);
					//$('#return_amount_sum').html(final_return);
					$('#balance_amount_sum').html(balance_amount_sum);
					if(outputs != '')
					{
						$('.search_data').html(outputs);
						$('.ledger_name').html('Customer Sale & Collection Ledger');
						$('.table_head_name').html('Customer Name');
						$('#return_td').show();
						$('#return_tot').show();
						$('.infomsg').show();
						$('.down').show();
						
					}
					else
					{
						$('.search_data').html("No Data Available");
						$('.table_head_name').html('Customer Name');
						$('.ledger_name').html('Customer Sale & Collection Ledger');
						$('#return_td').show();
						$('#return_tot').show();
						$('.infomsg').show();
						$('.down').show();
					}
					$('#start').val('');
					$('#end').val(''); 
				}
				else if((distributor_id!='' || purpose_id==3) || (distributor_id!='' && purpose_id ==3))
				{
					var final_amount_sum = 0;
					var purchase_sum = 0;
					var balance_sum = 0;
					var payment_amount_sum = 0;
					var paid_amount_sum =0;
					var delete_amount_sum =0;
					var final_amount ='';
					
					if(new_date == '')
					{
						new_date = '2016-01-01';
					}
					if(date2 == '')
					{
						var today = new Date();
						date2 = format(today);
					}
					var purchase_amount_all ='';
					var payment_amount_all ='';
					
					for(var ng=0;ng<result.ledger_list['total_balance_amount_distributor'].length;ng++)
					{
						balance_sum +=parseFloat(Math.round(result.ledger_list['total_balance_amount_distributor'][ng]['int_balance']));
						output+='<tr><td></td><td style="width:25%;"></td><td style="width:20%;font-weight:bold;font-size:14px;">Balance Total</td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;"></td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance_sum.toFixed(2)+'</td></tr>';
					}
					purchase_sum = balance_sum;
					for(var n=0;n<result.ledger_list['total_purchase_amount'].length;n++)
					{
						purchase_amount_all =parseFloat(result.ledger_list['total_purchase_amount'][n]['total_amount_purchase']).toFixed(2);
						purchase_sum +=parseFloat(Math.round(result.ledger_list['total_purchase_amount'][n]['total_amount_purchase']));
						if(purchase_amount_all =='NaN')
						{
							purchase_amount_all = '0.00';
						}
						else{
							purchase_amount_all = purchase_amount_all;
						}
						
						output+='<tr><td></td><td style="width:25%;"></td><td style="width:20%;font-weight:bold;font-size:14px;">Purchase Total</td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+purchase_amount_all+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+purchase_sum.toFixed(2)+'</td></tr>';
					}
					
					for(var g=0;g<result.ledger_list['total_purchase_payment_amount'].length;g++)
					{
						
						payment_amount_all =parseFloat(result.ledger_list['total_purchase_payment_amount'][g]['total_amount_purchase_payment']).toFixed(2);
						payment_amount_sum +=parseFloat(Math.round(result.ledger_list['total_purchase_payment_amount'][g]['total_amount_purchase_payment']));
						
						if(payment_amount_all =='NaN')
						{
							payment_amount_all = '0.00';
							var ans = parseFloat(purchase_amount_all - 0.00 + balance_sum).toFixed(2);
						}
						else{
							payment_amount_all = payment_amount_all;
							var ans = parseFloat(purchase_amount_all - payment_amount_all + balance_sum).toFixed(2);
						}
						output+='<tr><td></td><td style="width:25%;"></td><td style="width:20%;font-weight:bold;font-size:14px;">Payment Total</td><td class="total_amount"></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+payment_amount_all+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+ans+'</td></tr>';
					}
					
					final_amount_sum = purchase_sum;
					paid_amount_sum  = payment_amount_sum;
					while(new_date <= date2)
					{
						for(var i=0;i<result.ledger_list[new_date]['total_purchase'].length;i++)
						{
							final_amount_sum +=parseFloat(Math.round(result.ledger_list[new_date]['total_purchase'][i]['amount']));
							final_amount =parseFloat(result.ledger_list[new_date]['total_purchase'][i]['amount']).toFixed(2);
							var tran_purpose = result.ledger_list[new_date]['total_purchase'][i]['transaction_purpose'];
							if(tran_purpose =='purchase_payment_deleted'){
								tran_purpose = 'Deleted Cheque';
							}
							var balance=final_amount_sum-paid_amount_sum;
						
							output+='<tr><td title="'+result.ledger_list[new_date]['total_purchase'][i]['date']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+result.ledger_list[new_date]['total_purchase'][i]['date']+'</td><td style="width:25%;">'+result.ledger_list[new_date]['total_purchase'][i]['distributor_name']+'</td><td title="Purchase' +result.ledger_list[new_date]['total_purchase'][i]['transaction_mode']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:20%;"><span style="font-weight:bold;font-size:14px;">'+tran_purpose+'</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list[new_date]['total_purchase'][i]['transaction_mode']+'</span><br><span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list[new_date]['total_purchase'][i]['remarks']+'</span></td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+final_amount+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';
						}
						
						for(var m=0;m<result.ledger_list[new_date]['total_payment'].length;m++)
						{
							paid_amount_sum +=parseFloat(Math.round(result.ledger_list[new_date]['total_payment'][m]['amount']));
						
							var transaction_id=result.ledger_list[new_date]['total_payment'][m]['transaction_id'];
							var paid_amount=parseFloat(result.ledger_list[new_date]['total_payment'][m]['amount']).toFixed(2);
							var date=result.ledger_list[new_date]['total_payment'][m]['date'];
							var tran_purpose = result.ledger_list[new_date]['total_payment'][m]['transaction_purpose'];
							if(tran_purpose =='purchase_return'){
								tran_purpose = 'Purchase Return';
							}
							var balance=final_amount_sum-paid_amount_sum;
							var balance2=final_amount_sum-paid_amount_sum;
							output+='<tr><td title="'+date+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+date+'</td><td style="width:25%;">'+result.ledger_list[new_date]['total_payment'][m]['distributor_name']+'</td><td title="Payment '+result.ledger_list[new_date]['total_payment'][m]['transaction_mode']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:20%;"><span style="font-weight:bold;font-size:14px;"> <span style="font-weight:bold;font-size:14px;">'+tran_purpose+'</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list[new_date]['total_payment'][m]['transaction_mode']+'</span><br><span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list[new_date]['total_payment'][m]['remarks']+'</span></td><td class="total_amount"></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;text-align:right;" title="'+paid_amount+'">'+paid_amount+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';
						}
						/* for(var m=0;m<result.ledger_list[new_date]['total_delete_payment'].length;m++)
						{
							delete_amount_sum +=parseFloat(Math.round(result.ledger_list[new_date]['total_delete_payment'][m]['amount']));
						
							var transaction_id=result.ledger_list[new_date]['total_delete_payment'][m]['transaction_id'];
							var delete_amount=parseFloat(result.ledger_list[new_date]['total_delete_payment'][m]['amount']).toFixed(2);
							var date=result.ledger_list[new_date]['total_delete_payment'][m]['date'];
							var balance=delete_amount_sum - balance2;
							output+='<tr><td title="'+date+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+date+'</td><td style="width:25%;">'+result.ledger_list[new_date]['total_delete_payment'][m]['distributor_name']+'</td><td title="Delete Cheque #'+transaction_id+' '+result.ledger_list[new_date]['total_delete_payment'][m]['transaction_mode']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:20%;"><span style="font-weight:bold;font-size:14px;"> <span style="font-weight:bold;font-size:14px;"> Delete Cheque #'+transaction_id+'</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list[new_date]['total_delete_payment'][m]['transaction_mode']+'</span></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;text-align:right;" title="'+delete_amount+'">'+delete_amount+'</td><td class="total_amount"></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';
						} */
						date1 = new Date(Date.parse(new_date));
						date1 = date1.add(1).day();
						new_date = format(date1);
						j++;
					}

					var final_sum = parseFloat(final_amount_sum).toFixed(2);
					var final_paid = parseFloat(paid_amount_sum).toFixed(2);
					var balance_amount_sum =parseFloat(final_sum - final_paid).toFixed(2);
					$('#total_amount_sum').html(final_sum);
					$('#paid_amount_sum').html(final_paid);
					$('#balance_amount_sum').html(balance_amount_sum);
					if(output != '')
					{
						$('.search_data').html(output);
						$('.ledger_name').html('Distributor Purchase & Payment Ledger');
						$('.table_head_name').html('Distributor Name');
						$('.infomsg').show();
						$('#return_td').hide();
						$('#return_tot').hide();
						$('.down').show();
					}
					else
					{
						$('.search_data').html("No Data Available");
						$('.table_head_name').html('Distributor Name');
						$('.ledger_name').html('Distributor Purchase & Payment Ledger');
						$('.infomsg').show();
						$('.down').show();
						$('#return_td').hide();
						$('#return_tot').hide();
					}
					$('#start').val('');
					$('#end').val(''); 
				}
				else if((type_id!='' || purpose_id==2) || (type_id!='' && purpose_id ==2))
				{
					var final_amount_sum = 0;
					var expense_sum = 0;
					var expense_payment_amount_sum = 0;
					var paid_amount_sum =0;
					var final_amount ='';
					
					if(new_date == '')
					{
						new_date = '2016-01-01';
					}
					if(date2 == '')
					{
						var today = new Date();
						date2 = format(today);
					}
					var expense_amount_all ='';
					var expense_payment_amount_all ='';
					
					for(var n=0;n<result.ledger_list3['total_expense_amount'].length;n++)
					{
						expense_amount_all =parseFloat(result.ledger_list3['total_expense_amount'][n]['total_amount_expense']).toFixed(2);
						expense_sum +=parseFloat(Math.round(result.ledger_list3['total_expense_amount'][n]['total_amount_expense']));
						if(expense_amount_all =='NaN')
						{
							expense_amount_all = '0.00';
						}
						else{
							expense_amount_all = expense_amount_all;
						}
						
						output+='<tr><td></td><td style="width:25%;"></td><td style="width:20%;font-weight:bold;font-size:14px;">Expense Total</td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+expense_amount_all+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+expense_sum.toFixed(2)+'</td></tr>';
					}
					
					for(var g=0;g<result.ledger_list3['total_expense_payment_amount'].length;g++)
					{
						
						expense_payment_amount_all =parseFloat(result.ledger_list3['total_expense_payment_amount'][g]['total_amount_expense_payment']).toFixed(2);
						expense_payment_amount_sum +=parseFloat(Math.round(result.ledger_list3['total_expense_payment_amount'][g]['total_amount_expense_payment']));
						
						if(expense_payment_amount_all =='NaN')
						{
							expense_payment_amount_all = '0.00';
							var ans = parseFloat(expense_amount_all - 0.00).toFixed(2);
						}
						else{
							expense_payment_amount_all = expense_payment_amount_all;
							var ans = parseFloat(expense_amount_all - expense_payment_amount_all).toFixed(2);
						}
						output+='<tr><td></td><td style="width:25%;"></td><td style="width:20%;font-weight:bold;font-size:14px;">Payment Total</td><td class="total_amount"></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+expense_payment_amount_all+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+ans+'</td></tr>';
					}
					
					final_amount_sum = expense_sum;
					paid_amount_sum  = expense_payment_amount_sum;
					while(new_date <= date2)
					{

						
						for(var i=0;i<result.ledger_list3[new_date]['total_expense'].length;i++)
						{
							final_amount_sum +=parseFloat(Math.round(result.ledger_list3[new_date]['total_expense'][i]['amount']));
							final_amount =parseFloat(result.ledger_list3[new_date]['total_expense'][i]['amount']).toFixed(2);
							
							var balance=final_amount_sum-paid_amount_sum;
							var tran_purpose = result.ledger_list3[new_date]['total_expense'][i]['transaction_purpose'];
							if(tran_purpose =='expense_payment_deleted')
							{
								tran_purpose = 'Deleted Cheque';
							}
							else if(tran_purpose =='expense')
							{
								tran_purpose = 'Expense';
							}
							//alert(result.ledger_list3[new_date]['total_expense'][i]['remarks']);
							if(result.ledger_list3[new_date]['total_expense'][i]['employee_name']==null)
							{
								output+='<tr><td title="'+result.ledger_list3[new_date]['total_expense'][i]['date']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+result.ledger_list3[new_date]['total_expense'][i]['date']+'</td><td style="width:25%;">'+result.ledger_list3[new_date]['total_expense'][i]['type_type']+'</span></td><td title="'+tran_purpose+' '+result.ledger_list3[new_date]['total_expense'][i]['transaction_mode']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:20%;"><span style="font-weight:bold;font-size:14px;">'+tran_purpose+' </span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list3[new_date]['total_expense'][i]['transaction_mode']+'</span><br><span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list3[new_date]['total_expense'][i]['remarks']+'</span></td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+final_amount+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';
							}
							else{
								output+='<tr><td title="'+result.ledger_list3[new_date]['total_expense'][i]['date']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+result.ledger_list3[new_date]['total_expense'][i]['date']+'</td><td style="width:25%;">'+result.ledger_list3[new_date]['total_expense'][i]['type_type']+'<br>'+'<span>'+result.ledger_list3[new_date]['total_expense'][i]['employee_name']+'</span></td><td title="'+tran_purpose+' '+result.ledger_list3[new_date]['total_expense'][i]['transaction_mode']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:20%;"><span style="font-weight:bold;font-size:14px;">'+tran_purpose+' </span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list3[new_date]['total_expense'][i]['transaction_mode']+'</span><br><span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list3[new_date]['total_expense'][i]['remarks']+'</span></td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+final_amount+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';
							}
						}
						
						for(var m=0;m<result.ledger_list3[new_date]['total_expense_payment'].length;m++)
						{
							paid_amount_sum +=parseFloat(Math.round(result.ledger_list3[new_date]['total_expense_payment'][m]['amount']));
						
							var transaction_id=result.ledger_list3[new_date]['total_expense_payment'][m]['transaction_id'];
							var paid_amount=parseFloat(result.ledger_list3[new_date]['total_expense_payment'][m]['amount']).toFixed(2);
							var date=result.ledger_list3[new_date]['total_expense_payment'][m]['date'];
							var balance=final_amount_sum-paid_amount_sum;
							if(result.ledger_list3[new_date]['total_expense_payment'][m]['employee_name']==null)
							{
								output+='<tr><td title="'+date+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+date+'</td><td style="width:25%;">'+result.ledger_list3[new_date]['total_expense_payment'][m]['type_type']+'</td><td title="Expense Payment #'+transaction_id+' '+result.ledger_list3[new_date]['total_expense_payment'][m]['transaction_mode']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:20%;"><span style="font-weight:bold;font-size:14px;"> <span style="font-weight:bold;font-size:14px;"> Expense Payment</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list3[new_date]['total_expense_payment'][m]['transaction_mode']+'</span><br><span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list3[new_date]['total_expense_payment'][m]['remarks']+'</span></td><td class="total_amount"></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;text-align:right;" title="'+paid_amount+'">'+paid_amount+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';
							}
							else
							{
								output+='<tr><td title="'+date+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+date+'</td><td style="width:25%;">'+result.ledger_list3[new_date]['total_expense_payment'][m]['type_type']+'<br>'+'<span>'+result.ledger_list3[new_date]['total_expense_payment'][m]['employee_name']+'</span></td><td title="Expense Payment #'+transaction_id+' '+result.ledger_list3[new_date]['total_expense_payment'][m]['transaction_mode']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:20%;"><span style="font-weight:bold;font-size:14px;"> <span style="font-weight:bold;font-size:14px;"> Expense Payment</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list3[new_date]['total_expense_payment'][m]['transaction_mode']+'</span><br><span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list3[new_date]['total_expense_payment'][m]['remarks']+'</span></td><td class="total_amount"></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;text-align:right;" title="'+paid_amount+'">'+paid_amount+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';
							}

						}
						date1 = new Date(Date.parse(new_date));
						date1 = date1.add(1).day();
						new_date = format(date1);
						j++;
					}

					var final_sum = parseFloat(final_amount_sum).toFixed(2);
					var final_paid = parseFloat(paid_amount_sum).toFixed(2);
					var balance_amount_sum =parseFloat(final_sum - final_paid).toFixed(2);
					$('#total_amount_sum').html(final_sum);
					$('#paid_amount_sum').html(final_paid);
					$('#balance_amount_sum').html(balance_amount_sum);
					if(output != '')
					{
						$('.search_data').html(output);
						$('.ledger_name').html('Expense & Payment Ledger');
						$('.table_head_name').html('Type / Ledger');
						$('.infomsg').show();
						$('.down').show();
						$('#return_td').hide();
						$('#return_tot').hide();
					}
					else
					{
						$('.search_data').html("No Data Available");
						$('.table_head_name').html('Service Provider Name');
						$('.ledger_name').html('Expense & Payment Ledger');
						$('.infomsg').show();
						$('.down').show();
						$('#return_td').hide();
						$('#return_tot').hide();
					}
					$('#start').val('');
					$('#end').val(''); 
				}
				else if((transfer_type!='' || purpose_id==4) || (transfer_type!='' && purpose_id ==4))
				{
					var final_amount_sum = 0;
					var to_bank_sum = 0;
					var from_bank_amount_sum = 0;
					var paid_amount_sum =0;
					var final_amount ='';
					
					if(new_date == '')
					{
						new_date = '2016-01-01';
					}
					if(date2 == '')
					{
						var today = new Date();
						date2 = format(today);
					}
					var to_bank_amount_all ='';
					var from_bank_amount_all ='';
					
					for(var nnn=0;nnn<result.ledger_list4['total_to_bank_amount'].length;nnn++)
					{
						to_bank_amount_all =parseFloat(result.ledger_list4['total_to_bank_amount'][nnn]['total_amount_to_bank']).toFixed(2);
						to_bank_sum +=parseFloat(Math.round(result.ledger_list4['total_to_bank_amount'][nnn]['total_amount_to_bank']));
						if(to_bank_amount_all =='NaN')
						{
							to_bank_amount_all = '0.00';
						}
						else{
							to_bank_amount_all = to_bank_amount_all;
						}
						
						output+='<tr><td></td><td style="width:25%;"></td><td style="width:20%;font-weight:bold;font-size:14px;">To Bank Total</td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+to_bank_amount_all+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+to_bank_sum.toFixed(2)+'</td></tr>';
					}
					
					for(var ggg=0;ggg<result.ledger_list4['total_from_bank_amount'].length;ggg++)
					{
						
						from_bank_amount_all =parseFloat(result.ledger_list4['total_from_bank_amount'][ggg]['total_amount_from_bank']).toFixed(2);
						from_bank_amount_sum +=parseFloat(Math.round(result.ledger_list4['total_from_bank_amount'][ggg]['total_amount_from_bank']));
						
						if(from_bank_amount_all =='NaN')
						{
							from_bank_amount_all = '0.00';
							var ans = parseFloat(to_bank_amount_all - 0.00).toFixed(2);
						}
						else{
							from_bank_amount_all = from_bank_amount_all;
							var ans = parseFloat(to_bank_amount_all - from_bank_amount_all).toFixed(2);
						}
						output+='<tr><td></td><td style="width:25%;"></td><td style="width:20%;font-weight:bold;font-size:14px;">From Bank Total</td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+from_bank_amount_all+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+ans+'</td></tr>';
					}
					
					final_amount_sum = to_bank_sum;
					paid_amount_sum  = from_bank_amount_sum;
					while(new_date <= date2)
					{

						
						for(var iii=0;iii<result.ledger_list4[new_date]['total_to_bank'].length;iii++)
						{
							final_amount_sum +=parseFloat(Math.round(result.ledger_list4[new_date]['total_to_bank'][iii]['amount']));
							final_amount =parseFloat(result.ledger_list4[new_date]['total_to_bank'][iii]['amount']).toFixed(2);
							
							var balance=final_amount_sum-paid_amount_sum;
						
							output+='<tr><td title="'+result.ledger_list4[new_date]['total_to_bank'][iii]['date']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+result.ledger_list4[new_date]['total_to_bank'][iii]['date']+'</td><td style="width:25%;">'+result.ledger_list4[new_date]['total_to_bank'][iii]['service_provider_name']+'</td><td title="To Bank #'+result.ledger_list4[new_date]['total_to_bank'][iii]['transaction_id']+' '+result.ledger_list4[new_date]['total_to_bank'][iii]['transaction_mode']+' '+result.ledger_list4[new_date]['total_to_bank'][iii]['bank_name']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:20%;"><span style="font-weight:bold;font-size:14px;"> To Bank #'+result.ledger_list4[new_date]['total_to_bank'][iii]['transaction_id']+'</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list4[new_date]['total_to_bank'][iii]['transaction_mode']+'</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list4[new_date]['total_to_bank'][iii]['bank_name']+'</span></td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+final_amount+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';
						}
						
						for(var mmm=0;mmm<result.ledger_list4[new_date]['total_from_bank'].length;mmm++)
						{
							paid_amount_sum +=parseFloat(Math.round(result.ledger_list4[new_date]['total_from_bank'][mmm]['amount']));
						
							var transaction_id=result.ledger_list4[new_date]['total_from_bank'][mmm]['transaction_id'];
							var paid_amount=parseFloat(result.ledger_list4[new_date]['total_from_bank'][mmm]['amount']).toFixed(2);
							var date=result.ledger_list4[new_date]['total_from_bank'][mmm]['date'];
							var balance=final_amount_sum-paid_amount_sum;
							output+='<tr><td title="'+date+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+date+'</td><td style="width:25%;">'+result.ledger_list4[new_date]['total_from_bank'][mmm]['service_provider_name']+'</td><td title="From Bank #'+transaction_id+' '+result.ledger_list4[new_date]['total_from_bank'][mmm]['transaction_mode']+' '+result.ledger_list4[new_date]['total_from_bank'][mmm]['bank_name']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:20%;"><span style="font-weight:bold;font-size:14px;"> <span style="font-weight:bold;font-size:14px;"> From Bank #'+transaction_id+'</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list4[new_date]['total_from_bank'][mmm]['transaction_mode']+'</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list4[new_date]['total_from_bank'][mmm]['bank_name']+'</span></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;text-align:right;" title="'+paid_amount+'">'+paid_amount+'</td><td class="total_amount"></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';

						}
						date1 = new Date(Date.parse(new_date));
						date1 = date1.add(1).day();
						new_date = format(date1);
						j++;
					}

					var final_sum = parseFloat(final_amount_sum).toFixed(2);
					var final_paid = parseFloat(paid_amount_sum).toFixed(2);
					var balance_amount_sum =parseFloat(final_sum - final_paid).toFixed(2);
					$('#total_amount_sum').html(final_sum);
					$('#paid_amount_sum').html(final_paid);
					$('#balance_amount_sum').html(balance_amount_sum);
					if(output != '')
					{
						$('.search_data').html(output);
						$('.ledger_name').html('Bank Transfer Ledger');
						$('.table_head_name').html('Provider Name');
						$('.infomsg').show();
						$('.down').show();
						$('#return_td').hide();
						$('#return_tot').hide();
					}
					else
					{
						$('.search_data').html("No Data Available");
						$('.table_head_name').html('Provider Name');
						$('.ledger_name').html('Bank Transfer Ledger');
						$('.infomsg').show();
						$('.down').show();
						$('#return_td').hide();
						$('#return_tot').hide();
					}
					$('#start').val('');
					$('#end').val(''); 
				}
				
				else if((owner_transfer_type!='' || purpose_id==5) || (owner_transfer_type!='' && purpose_id ==5))
				{
					var final_amount_sum = 0;
					var to_owner_sum = 0;
					var from_owner_amount_sum = 0;
					var paid_amount_sum =0;
					var final_amount ='';
					
					if(new_date == '')
					{
						new_date = '2016-01-01';
					}
					if(date2 == '')
					{
						var today = new Date();
						date2 = format(today);
					}
					var to_owner_amount_all ='';
					var from_owner_amount_all ='';
					
					for(var nnnnn=0;nnnnn<result.ledger_list5['total_to_owner_amount'].length;nnnnn++)
					{
						to_owner_amount_all =parseFloat(result.ledger_list5['total_to_owner_amount'][nnnnn]['total_amount_to_owner']).toFixed(2);
						to_owner_sum +=parseFloat(Math.round(result.ledger_list5['total_to_owner_amount'][nnnnn]['total_amount_to_owner']));
						if(to_owner_amount_all =='NaN')
						{
							to_owner_amount_all = '0.00';
						}
						else{
							to_owner_amount_all = to_owner_amount_all;
						}
						
						output+='<tr><td></td><td style="width:25%;"></td><td style="width:20%;font-weight:bold;font-size:14px;">To Owner Total</td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+to_owner_amount_all+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+to_owner_sum.toFixed(2)+'</td></tr>';
					}
					
					for(var ggggg=0;ggggg<result.ledger_list5['total_from_owner_amount'].length;ggggg++)
					{
						
						from_owner_amount_all =parseFloat(result.ledger_list5['total_from_owner_amount'][ggggg]['total_amount_from_owner']).toFixed(2);
						from_owner_amount_sum +=parseFloat(Math.round(result.ledger_list5['total_from_owner_amount'][ggggg]['total_amount_from_owner']));
						
						if(from_owner_amount_all =='NaN')
						{
							from_owner_amount_all = '0.00';
							var ans = parseFloat(to_owner_amount_all - 0.00).toFixed(2);
						}
						else{
							from_owner_amount_all = from_owner_amount_all;
							var ans = parseFloat(to_owner_amount_all - from_owner_amount_all).toFixed(2);
						}
						output+='<tr><td></td><td style="width:25%;"></td><td style="width:20%;font-weight:bold;font-size:14px;">From Owner Total</td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+from_owner_amount_all+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+ans+'</td></tr>';
					}
					
					final_amount_sum = to_owner_sum;
					paid_amount_sum  = from_owner_amount_sum;
					while(new_date <= date2)
					{

						
						for(var iiiii=0;iiiii<result.ledger_list5[new_date]['total_to_owner'].length;iiiii++)
						{
							final_amount_sum +=parseFloat(Math.round(result.ledger_list5[new_date]['total_to_owner'][iiiii]['amount']));
							final_amount =parseFloat(result.ledger_list5[new_date]['total_to_owner'][iiiii]['amount']).toFixed(2);
							
							var balance=final_amount_sum-paid_amount_sum;
						
							output+='<tr><td title="'+result.ledger_list5[new_date]['total_to_owner'][iiiii]['date']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+result.ledger_list5[new_date]['total_to_owner'][iiiii]['date']+'</td><td style="width:25%;">'+result.ledger_list5[new_date]['total_to_owner'][iiiii]['owner_name']+'</td><td title="To owner #'+result.ledger_list5[new_date]['total_to_owner'][iiiii]['transaction_id']+' '+result.ledger_list5[new_date]['total_to_owner'][iiiii]['transaction_mode']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:20%;"><span style="font-weight:bold;font-size:14px;"> To Owner #'+result.ledger_list5[new_date]['total_to_owner'][iiiii]['transaction_id']+'</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list5[new_date]['total_to_owner'][iiiii]['transaction_mode']+'</span></td><td class="total_amount" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+final_amount+'</td><td></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';
						}
						
						for(var mmmmm=0;mmmmm<result.ledger_list5[new_date]['total_from_owner'].length;mmmmm++)
						{
							paid_amount_sum +=parseFloat(Math.round(result.ledger_list5[new_date]['total_from_owner'][mmmmm]['amount']));
						
							var transaction_id=result.ledger_list5[new_date]['total_from_owner'][mmmmm]['transaction_id'];
							var paid_amount=parseFloat(result.ledger_list5[new_date]['total_from_owner'][mmmmm]['amount']).toFixed(2);
							var date=result.ledger_list5[new_date]['total_from_owner'][mmmmm]['date'];
							var balance=final_amount_sum-paid_amount_sum;
							output+='<tr><td title="'+date+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;">'+date+'</td><td style="width:25%;">'+result.ledger_list5[new_date]['total_from_owner'][mmmmm]['owner_name']+'</td><td title="From Owner #'+transaction_id+' '+result.ledger_list5[new_date]['total_from_owner'][mmmmm]['transaction_mode']+'" style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:left;width:25%;"><span style="font-weight:bold;font-size:14px;"> <span style="font-weight:bold;font-size:14px;"> From Owner #'+transaction_id+'</span> <span style="font-weight:normal;font-size:12px;color:gray;">'+result.ledger_list5[new_date]['total_from_owner'][mmmmm]['transaction_mode']+'</span></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;text-align:right;" title="'+paid_amount+'">'+paid_amount+'</td><td class="total_amount"></td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:right;">'+balance.toFixed(2)+'</td></tr>';

						}
						date1 = new Date(Date.parse(new_date));
						date1 = date1.add(1).day();
						new_date = format(date1);
						j++;
					}

					var final_sum = parseFloat(final_amount_sum).toFixed(2);
					var final_paid = parseFloat(paid_amount_sum).toFixed(2);
					var balance_amount_sum =parseFloat(final_sum - final_paid).toFixed(2);
					$('#total_amount_sum').html(final_sum);
					$('#paid_amount_sum').html(final_paid);
					$('#balance_amount_sum').html(balance_amount_sum);
					if(output != '')
					{
						$('.search_data').html(output);
						$('.ledger_name').html('Owner Transfer Ledger');
						$('.table_head_name').html('Owner Name');
						$('.infomsg').show();
						$('.down').show();
						$('#return_td').hide();
						$('#return_tot').hide();
					}
					else
					{
						$('.search_data').html("No Data Available");
						$('.table_head_name').html('Owner Name');
						$('.ledger_name').html('Owner Transfer Ledger');
						$('.infomsg').show();
						$('.down').show();
						$('#return_td').hide();
						$('#return_tot').hide();
					}
					$('#start').val('');
					$('#end').val(''); 
				}
			}
		});
	};
	function format(date) {
	  date = new Date(date);

	  var day = ('0' + date.getDate()).slice(-2);
	  var month = ('0' + (date.getMonth() + 1)).slice(-2);
	  var year = date.getFullYear();

	  return year + '-' + month + '-' + day;
	}
	
	$(document).ready(function()
	{
		$("#down").click(function(event2) 
		{
			event2.preventDefault();
			submiturl = $(this).attr('href');
			var distributor 		= $('#distributor').val();
			var customer 			= $('#customer').val();
			var service_provider 	= $('#service_provider').val();
			var employee 			= $('#employee').val();
			var type 				= $('#type').val();
			var purpose 			= $('#purpose').val();
			var owner_transfer 		= $('#owner_transfer').val();
			var transfer 			= $('#transfer').val();
			var start_date 			= $('#start_date').val();
			var end_date 			= $('#end_date').val();
			
			if(distributor == ''){
				distributor = 'null';
			}
			if(customer == ''){
				customer = 'null';
			}
			if(owner_transfer == ''){
				owner_transfer = 'null';
			}
			if(service_provider == ''){
				service_provider = 'null';
			}
			if(purpose == ''){
				purpose = 'null';
			}
			if(transfer == ''){
				transfer = 'null';
			}
			if(start_date == ''){
				start_date = 'null';
			}
			
			if(end_date == ''){
				end_date = 'null';
			}
			if(employee == ''){
				employee = 'null';
			}
			if(type == ''){
				type = 'null';
			}
			window.open(submiturl+'/'+distributor+'/'+customer+'/'+purpose+'/'+transfer+'/'+start_date+'/'+end_date+'/'+owner_transfer+'/'+type+'/'+employee,'_blank');
		});
	});
</script>
</div>
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
<?php $this -> load -> view('include/footer'); ?>