<<<<<<< HEAD
﻿<?php $this -> load -> view('include/header'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
	<div class="content-wrapper">
		<section class="content">
			<div class="row">
				<div class="col-md-12">
					<div class="box box-primary">
						<div class="box-header">
							<i class="ion ion-clipboard"></i>
							<h3 class="box-title">Overview</h3>
						</div>
						<div class="box-body">
							
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
=======
﻿<?php $this -> load -> view('include/header'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
	<style>
		.info-box{
			min-height:65px;
		}
		.new_padding{
			 padding-right: 2px;
			 padding-left: 2px;
		}
		.new_style{
			 height:55px;
			 line-height: 55px;
			 width: 55px;
		}
		.new_margin_bottom{
			 margin-bottom: 5px;
		}
		.text_color{
			 width: 51%;
			 color: #337ab7;
		}
		.text_width{
			 width: 38%;
			 text-align: right;
		}
		#new_padding_2{
			padding:1.9px;
		}
	</style>
	<div class="content-wrapper">
		<section class="content">
			<div class="row">
				<div class="col-md-4">
					<div class="box box-primary">
						<div class="box-header">
							<i class="ion ion-clipboard"></i>
							<h3 class="box-title">Overview</h3>
						</div>
						<div class="box-body">
							<?php
							if($user_type!='seller')
							{
							?>
							<div class="col-md-12">
								<ul class="todo-list">
									<li id="new_padding_2">
										<span class="text text_color">Today's Sale</span>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text text_width" style="float:right;">
											<?php
												echo sprintf('%0.2f',$todays_sale);
											?>
										</span>
									</li>
									<li id="new_padding_2">
										<span class="text text_color">Delivery Charge</span>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text text_width" style="float:right;">
											<?php
												echo sprintf('%0.2f',$todays_delivery_charge);
											?>
										</span>
									</li>
									<li id="new_padding_2">
										<span class="text text_color">Today's Due</span>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text text_width" style="float:right;">
											<?php
												$todays_due = $todays_grand - $todays_paid + $todays_invoice_return + $todays_delivery_charge;
												echo sprintf('%0.2f',$todays_due);
												
											?>
										</span>
									</li>
									<li id="new_padding_2">
										<span class="text text_color">Today's Purchase</span>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text text_width" style="float:right;">
											<?php
												echo sprintf('%0.2f',$todays_purchase);
											?>
										</span>
									</li>
									<li id="new_padding_2">
										<span class="text text_color">Today's Expense</span>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text text_width" style="float:right;">
											<?php
												echo sprintf('%0.2f',$todays_expense);
											?>
										</span>
									</li>
									<li id="new_padding_2">
										<span class="text text_color">Sale Return(C)</span>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text text_width" style="float:right;">
											<?php
												echo sprintf('%0.2f',$todays_sale_return);
											?>
										</span>
									</li>
									<li id="new_padding_2">
										<span class="text text_color">Credit Collection(C)</span>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text text_width" style="float:right;">
											<?php
												echo sprintf('%0.2f',$todays_credit_collection_cash);
											?>
										</span>
									</li>
									<li id="new_padding_2">
										<span class="text text_color">Purchase Payment(C)</span>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text text_width" style="float:right;">
											<?php
												echo sprintf('%0.2f',$todays_purchase_payment_cash); 
											?>
										</span>
									</li>
									
									<li id="new_padding_2">
										<span class="text text_color">Expense Payment(C)</span>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text text_width" style="float:right;">
											<?php
												echo sprintf('%0.2f',$todays_expense_payment_cash);
											?>
										</span>
									</li>

									
									<li id="new_padding_2">
										<span class="text text_color">Cash in Hand</span>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text text_width" style="float:right;">
											<?php
												$total_collection = $todays_collection_cash;
												echo sprintf('%0.2f',$total_collection);
											?>
										</span>
									</li>
									<li id="new_padding_2">
										<span class="text text_color">Credit Collection(B)</span>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text text_width" style="float:right;">
											<?php
												echo sprintf('%0.2f',$todays_credit_collection_bank);
											?>
										</span>
									</li>
									<li id="new_padding_2">
										<span class="text text_color">Purchase Payment(B)</span>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text text_width" style="float:right;">
											<?php
												echo sprintf('%0.2f',$todays_purchase_payment_bank); 
											?>
										</span>
									</li>
									<li id="new_padding_2">
										<span class="text text_color">Expense Payment(B)</span>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text text_width" style="float:right;">
											<?php
												echo sprintf('%0.2f',$todays_expense_payment_bank); 
											?>
										</span>
									</li>
									
									<li id="new_padding_2">
										<span class="text text_color">Cash Book</span>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text text_width" style="float:right;">
											<?php
												echo sprintf('%0.2f',$todays_cash_book); 
											?>
										</span>
									</li>
									<li id="new_padding_2">
										<span class="text text_color">Bank Book</span>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text text_width" style="float:right;">
											<?php
												echo sprintf('%0.2f',$todays_bank_book); 
											?>
										</span>
									</li>
									
									<!--li id="new_padding_2">
										<span class="text text_color">Total Stock</span>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text text_width" style="float:right;">
											<?php echo sprintf("%.2f",$total_stock_price);?>
										</span>
									</li>

									<li id="new_padding_2">
										<span class="text text_color">Total Stock Quantity</span>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text text_width" style="float:right;">
											<?php echo sprintf("%.2f",$total_stock_quantity);?>
										</span>
									</li>
									<li id="new_padding_2">
										<span class="text text_color">Total Receivable</span>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text text_width total_receivable" style="float:right;">
											<!--?php
												$total_receivable = $total_sale_all- $total_receivable_all;
												echo round($total_receivable, 2);
												if($total_receivable == round($total_receivable, 0))
													echo'.00';
												else if(round($total_receivable, 1) == round($total_receivable, 2))
													echo'.0';
												echo nbs(2);
											?>
										</span>
									</li>
									<li id="new_padding_2">
										<span class="text text_color">Total Payable</span>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text text_width total_payable" style="float:right;">
											<!--?php
												$total_payable = $total_purchase_all- $total_payment_all;
												echo round($total_payable, 2);
												if($total_payable == round($total_payable, 0))
													echo'.00';
												else if(round($total_payable, 1) == round($total_payable, 2))
													echo'.0';
												echo nbs(2);
											?>
										</span>
									</li-->
								</ul>
							</div>
							<?php
							}
							?>
						</div>
					</div>
				</div>
				<div class="col-md-8">
					<div class="box box-primary">
						<div class="box-header">
							<i class="ion ion-clipboard"></i>
							<h3 class="box-title">Quick Links</h3>
						</div>
						<div class="box-body">
						<?php
						if($user_type!='seller')
						{
						?>
							<div class="col-md-3">
								<ul class="todo-list">
									<li style="padding: 2px;">
										<center><span class="text">Link-1</span></center>
									</li>
									<li>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text"><a href="<?php echo base_url();?>setup/product_setup">Product Setup</a></span>
									</li>
									<li>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text"><a href="<?php echo base_url();?>sale_controller/new_sale"><span>Sale</span></a></span>
									</li>
									<li>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text"><a href="<?php echo base_url();?>report_controller/stock_report">Stock Report</a></span>
									</li>
									<li>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text"><a href="<?php echo base_url();?>report_controller/sale_report">Sale Report</a></span>
									</li>
									<li>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text"><a href="<?php echo base_url();?>account_controller/expense_entry">Expense Entry</a></span>
									</li>
									<li>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text"><a href="<?php echo base_url();?>account_controller/ledgers"></i>Ledger</a></span>
									</li>
									<li>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text"><a href="<?php echo base_url();?>setup/damage_setup">Damage Setup</a></span>
									</li>
									<li>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text"><a href="<?php echo base_url();?>modify_controller/product_report">Product Modify</a></span>
									</li>
								</ul>
							</div>
							<div class="col-md-4">
								<ul class="todo-list">
									<li style="padding: 2px;">
										<center><span class="text">Link-2</span></center>
									</li>
									<li>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text"><a href="<?php echo base_url();?>setup/customer_setup">Customer Setup</a></span>
									</li>
									
									<li>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text"><a href="<?php echo base_url();?>sale_controller/return_sale"><span>Cash Sale Return</span></a></span>
									</li>

									<li>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text"><a href="<?php echo base_url();?>report_controller/purchase_report">Purchase Report</a></span>
									</li>

									<li>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text"><a href="<?php echo base_url();?>report_controller/financial_report"></i>Financial Report</a></span>
									</li>
									<li>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text"><a href="<?php echo base_url();?>report_controller/sale_return_report_new">Sale Return Report </a></span>
									</li>
									<li>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text"><a href="<?php echo base_url();?>product_controller/newPurchaseListing">Purchase Listing </a></span>
									</li>
									<li>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text"><a href="<?php echo base_url();?>purchase/purchase_return"><span>Purchase Return</span></a></span>
									</li>
									<li>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text"><a href="<?php echo base_url();?>modify_controller/damage_modify_new">Damage Modify</a></span>
									</li>
								</ul>
							</div>
							
							<div class="col-md-5">
								<ul class="todo-list">
									<li style="padding: 2px;">
										<center><span class="text">Link-3</span></center>
									</li>
									<li>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text"><a href="<?php echo base_url();?>purchase/receipt_setup">Purchase Receipt Entry</a></span>
									</li>
									
									<li>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text"><a href="<?php echo base_url();?>account_controller/credit_collection_receipt">Credit Collection Receipt</a></span>
									</li>
									<li>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text"><a href="<?php echo base_url();?>account_controller/purchase_payment_receipt">Purchase Payment Receipt</a></span>
									</li>
									<li>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text"><a href="<?php echo base_url();?>account_controller/expense_payment_receipt">Expense Payment Receipt</a></span>
									</li>
									<li>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text"><a href="<?php echo base_url();?>account_controller/pay_reci_report">Payable & Receivable</a></span>
									</li>
									<li>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text"><a href="<?php echo base_url();?>report_controller/credit_collection_report_new">Credit Collection Report </a></span>
									</li>
									<li>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text"><a href="<?php echo base_url();?>modify_controller/total_purchase_price_modify">Purchase Receipt Modify</a></span>
									</li>
									<li>
										<span class="handle">
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
										</span>
										<span class="text"><a href="<?php echo base_url();?>modify_controller/expense_modify_new">Expense Modify</a></span>
									</li>
								</ul>
							</div>
							<?php
							}
							?>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
<style>
.inner_table {
	~color:#666768;
    height: 480px;
    overflow-y: auto !important;
}
.inner_table_2 {
	color:#403e3e;
    height: 65px;
	width: 1100px;
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
</style>
<script type="text/javascript">
$(document).ready(function() 
{
	var submiturl = '<?php echo base_url();?>site_controller/all_payable_report_find';
	var methods = 'POST';
	var output = '';
	var output2 = '';
	var output3 = '';
	var all_ledger = '';
	var total_payable=0;
	var payable='payable';
	var i=0;
	var k= 1;
	var mm= 0;
	$.ajax({
		url: submiturl,
		type: methods,
		dataType: 'json',
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
					var payment_delete_amount_all =parseFloat(result['payable'][i]['receipt_payment_delete_total_amount'][m]['total_payment_delet_amount']).toFixed(2);
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
			}
			$('.total_payable').html(total_payable.toFixed(2));
		}
	});
});
$(document).ready(function() 
{
	//alert('ok');
	var submiturl2 = '<?php echo base_url();?>site_controller/all_receive_report_find';
	var methods2 = 'POST';
	var total_receivable=0;
	var receive='receive';
	var i=0;
	var k= 1;
	var mm= 0;
	$.ajax({
		url: submiturl2,
		type: methods2,
		dataType: 'json',
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
				//alert(collection_amount_all);
				var due_amount = (parseFloat(sale_amount_all) +  parseFloat(balance_amount_all) - parseFloat(collection_amount_all) - parseFloat(sale_return_amount_all) + parseFloat(delivery_amount_all))- parseFloat(delivery_amount_all);

				total_receivable+=parseFloat(due_amount);
			}
			//alert(total_receivable);
			$('.total_receivable').html(total_receivable.toFixed(2));
		}
	});
});
</script>
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
<?php $this -> load -> view('include/footer'); ?>