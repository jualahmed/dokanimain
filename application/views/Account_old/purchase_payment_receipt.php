<<<<<<< HEAD
<?php $this -> load -> view('include/header'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<script src="<?php echo base_url();?>assets/assets2/plugins/datepicker/bootstrap-datepicker.js"></script>
<div class="content-wrapper">
<style>

.wrap {
    width: 100%;
	margin:0px 0px 0px 0px;
}
.wrap table {
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
    height: 90px;
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
    width: 1px;
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
.content2{
	min-height: 130px;
	padding: 4px;
}
</style>
<section class="content2" style="margin:0px 0px 0px 0px;min-height:0px;">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header with-border" style="background: #0f77ab;">
					<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Receipt Entry</h3>
				</div>
				<form class="form-horizontal">
					<div class="box-body">	
						<div class="form-group">
							<div class="col-sm-4">
								<div class="input-group">
									<span class="input-group-addon">Receipt Type</span>
									<select class="form-control select22 catagory_name" id="receipt_type" style="width: 100%;"tabindex="-1" aria-hidden="true" required="required">
										<option value="1" selected>Purchase Payment Receipt</option>
									</select>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="input-group">
									<span class="input-group-addon">Payment By</span>
									<select class="form-control select2" name="payment_mode" id="payment_mode" style="width:100%;">
										<option value="">Select Mode</option>
										<option value="1">Cash</option>
										<option value="2">Cheque</option>
										<option value="3">Card</option>
									</select>
								</div>
							</div>
							<div class="col-sm-4" style="display:none;" id="customer_list">
								<div class="input-group">
									<input type="hidden" id="balance_amount_customer">
									<span class="input-group-addon">Customer</span>
									<select class="form-control select2" name="customer_id" id="customer_id" style="width:100%;">
									</select>
								</div>
							</div>
							<div class="col-sm-4" style="display:none;" id="distributor_list">
								<div class="input-group">
									<input type="hidden" id="balance_amount_distributor">
									<span class="input-group-addon">Distributor</span>
									<select class="form-control select2" name="distributor_id" id="distributor_id" style="width:100%;">
									</select>
								</div>
							</div>
							<div class="col-sm-4" style="display:none;" id="service_provider_list">
								<div class="input-group">
									<span class="input-group-addon">Provider</span>
									<select class="form-control select2" name="service_provider_id" id="service_provider_id" style="width:100%;">
									</select>
								</div>
							</div>
						</div>
						<div class="box-footer" style="background: #0f77ab;display:none;" id="card_id_list">
							<div class="col-sm-4">
								<div class="input-group">
									<span class="input-group-addon">Card</span>
									<select class="form-control select2" name="card_id" id="card_id" style="width:100%;">
									</select>
								</div>
							</div>
						</div>
						<div class="box-footer" style="background: #6c8490;padding: 6px;height: 48px;display:none;" id="result_cheque">
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-1 control-label" style="color:white;">My</label>
									<div class="col-sm-2">
										<?php 	
											echo form_dropdown('my_bank', $bank_info, '' ,'class="form-control select22" id="my_bank" style="width: 100%;" tabindex="-1" aria-hidden="true" required="required"');
										?>
									</div>
									<label for="inputEmail3" class="col-sm-1 control-label" style="color:white;">Bank</label>
									<div class="col-sm-2">
										<?php 	
											echo form_dropdown('to_bank', $bank_info, '' ,'class="form-control select22" id="to_bank" style="width: 100%;" tabindex="-1" aria-hidden="true" required="required"');
										?>
									</div>
									<label for="inputEmail3" class="col-sm-1 control-label" style="color:white;">Cheque</label>
									<div class="col-sm-2">
										<input type="text" name="cheque_no" class="form-control" id="cheque_no_id" placeholder="Cheque No" title="Cheque No" autocomplete="off">
									</div>
									<label for="inputEmail3" class="col-sm-1 control-label" style="color:white;">Date</label>
									<div class="col-sm-2">
										<input type="text" class="form-control" name="cheque_date" id="datasep" placeholder="Cheque Date" title="Cheque Date">
									</div>
								</div>
							</div>
					</div> 
				</form>
			</div> 
		</div> 
	</div> 
</section>
<section class="content2 collection_payment" style="display:none;min-height:0px;">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header with-border" style="background: #0f77ab;text-align:center;">
					<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"><span class="panel_name"></span></h3>
				</div>
				<div class="box-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label"><span class="global_name_label"></span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control global_name_input" readonly>
							</div>
							<label for="inputEmail3" class="col-sm-2 control-label"><span class="global_contact_label"></span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control global_contact_input" readonly>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label"><span class="global_address_label"></span></label>
							<div class="col-sm-10">
								<input type="text" id="customer_address" class="form-control global_address_input" readonly>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Remarks</label>
							<div class="col-sm-10">
								<input type="text" class="form-control remarks">
							</div>
						</div>
					</div>
					<form action="<?php echo base_url();?>account_controller/do_collection_payment" class="form-horizontal" method="post" enctype="multipart/form-data">					
						<div class="wrap">
							<table class="head">
								<tr>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;">Total Amount</td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;" id="cheque_return" style="display:none;">Cheque Return</td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;" id="purchase_return" style="display:none;">Purchase Return</td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;" id="expense_cheque_return" style="display:none;">Expense Return</td>
									
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;">Paid Amount</td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;" id="return" style="display:none;">Sale Return</td>
									
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;">Due Amount</td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;">Payment</td>
								</tr>
							</table>
							<div class="inner_table">
								<table class="new_data_2" id="search_data">
									<tr>
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;"><input type="text" class="form-control total_amount" id="total_amount" style="text-align:right;" readonly></td>
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;display:none;" id="cheque_return_amount2"><input type="text" id="cheque_return_amount" class="form-control" style="text-align:right;" readonly></td>
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;display:none;" id="purchase_return_amount2"><input type="text" id="purchase_return_amount" class="form-control" style="text-align:right;" readonly></td>
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;display:none;" id="expense_cheque_return_amount2"><input type="text" id="expense_cheque_return_amount" class="form-control" style="text-align:right;" readonly></td>
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;"><input type="text" id="paid_amount" class="form-control paid_amount" style="text-align:right;" readonly></td>
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;display:none;" id="return_amount2"><input type="text" id="return_amount" class="form-control" style="text-align:right;" readonly></td>
										
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;"><input type="text" id="due_amount" class="form-control due_amount" style="text-align:right;" readonly></td>
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;"><span class="payment_input_result"><input type="text" name="payment_input" class="form-control payment_input" style="text-align:right;" autofocus="on"></span></td>
									</tr>
								</table>
							</div>
						</div>
						<div class="box-footer" style="background: #0f77ab;">
							<center>
								<div class="col-sm-22">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i><span class="button_name"></span></button>
								</div>
							</center>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>	
</section> 
<script>
$(document).ready(function()
{
	$("#distributor_id").on("change",function()
	{
		var distributor_id = $(this).val();
		if(distributor_id != '') 
		{
			$('.collection_payment').fadeIn( "slow", function(){
				var urlx='<?php echo base_url();?>account_controller/get_single_distributor_all_purchase_payment_total';
				var outputs='';
				$.ajax
				({
					url: urlx,
					type: 'POST',
					dataType: 'json',
					data: {'distributor_id':distributor_id},
					success:function(result)
					{	
						for(n=0;n<result.ledger_list['receipt_purchase_total_amount'].length;n++)
						{
							var purchase_amount_all =parseFloat(result.ledger_list['receipt_purchase_total_amount'][n]['total_purchase_amount']).toFixed(2);
							var distributor_name =result.ledger_list['receipt_purchase_total_amount'][n]['distributor_name'];
							var distributor_contact =result.ledger_list['receipt_purchase_total_amount'][n]['distributor_contact_no'];
							var distributor_address =result.ledger_list['receipt_purchase_total_amount'][n]['distributor_address'];
							
							//alert(purchase_amount_all);
						}
						for(m=0;m<result.ledger_list['receipt_payment_total_amount'].length;m++)
						{
							var payment_amount_all =parseFloat(result.ledger_list['receipt_payment_total_amount'][m]['total_payment_amount']).toFixed(2);
						}
						for(m=0;m<result.ledger_list['receipt_purchase_return_total_amount'].length;m++)
						{
							var purchase_return_amount_all =parseFloat(result.ledger_list['receipt_purchase_return_total_amount'][m]['total_purchase_return_amount']).toFixed(2);
						}
						for(m=0;m<result.ledger_list['receipt_payment_delete_total_amount'].length;m++)
						{
							var payment_delete_amount_all =parseFloat(result.ledger_list['receipt_payment_delete_total_amount'][m]['total_payment_delet_amount']).toFixed(2);
						}
						for(j=0;j<result.ledger_list['receipt_balance_total_amount'].length;j++)
						{
							var balance_amount_all =parseFloat(result.ledger_list['receipt_balance_total_amount'][j]['total_balance_amount']).toFixed(2);
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
						
						if(isNaN(purchase_return_amount_all))
						{
							purchase_return_amount_all = '0.00';
						}
						else{
							purchase_return_amount_all = purchase_return_amount_all;
						}
						
						
						
						//alert(payment_amount_all);
						if(isNaN(purchase_amount_all))
						{
							purchase_amount_all = '0.00';
						}
						else
						{
							purchase_amount_all = purchase_amount_all;
							
						}
						var due_amount = (parseFloat(purchase_amount_all) +parseFloat(balance_amount_all) +  parseFloat(payment_delete_amount_all) - parseFloat(payment_amount_all)).toFixed(2);
						//alert('Purchase '+purchase_amount_all);
						//alert('Balance '+balance_amount_all);
						//alert('Delete Amount '+payment_delete_amount_all);
						//alert('Payment '+payment_amount_all);
						if(isNaN(due_amount))
						{
							due_amount = '0.00';
						}
						else{
							due_amount = due_amount;
						}
						$('#return').hide();
						$('#return_amount').hide();
						$('#return_amount2').hide();
						$('#cheque_return').show();
						$('#cheque_return_amount').show();
						$('#cheque_return_amount2').show();
						$('#purchase_return').show();
						$('#purchase_return_amount').show();
						$('#purchase_return_amount2').show();
						$('#expense_cheque_return').hide();
						$('#expense_cheque_return_amount').hide();
						$('#expense_cheque_return_amount2').hide();
						$(".global_name_label").html('Distributor Name'); 
						$(".global_contact_label").html('Distributor Contact'); 
						$(".global_address_label").html('Distributor Address'); 

						$(".global_name_input").val(distributor_name); 
						$(".global_contact_input").val(distributor_contact); 
						$(".global_address_input").val(distributor_address); 
						$(".total_amount").val(parseFloat(purchase_amount_all) +  parseFloat(balance_amount_all)); 
						 
						var paid = payment_amount_all - payment_delete_amount_all;
						//alert(paid);
						//alert(payment_delete_amount_all);
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
						$(".paid_amount").val(paid); 
						$("#cheque_return_amount").val(payment_delete_amount_all); 
						$("#purchase_return_amount").val(purchase_return_amount_all); 
						$(".due_amount").val(due_amount); 
						$(".balance_amount_distributor").val(balance_amount_all); 
					},
					error: function (jXHR, textStatus, errorThrown) {}
				});
			});
		} 
	});	
	
	$("#payment_mode").on("change",function()
	{
		$('#distributor_list').fadeIn( "slow", function(){
			var urlx='<?php echo base_url();?>account_controller/get_all_distributor';
			var output3s='';
			$.ajax
			({
				url: urlx,
				type: 'POST',
				dataType: 'json',
				//data: {'receipt_type':receipt_type},
				success:function(result)
				{	
					output3s+='<option value="">Select Distributor</option>';
					for(var i=0; i<result.length; i++ )
					{
					  output3s+='<option value="'+result[i].distributor_id+'">'+result[i].distributor_name+'</option>';
					}
					$("#distributor_id").html(output3s);
					$(".panel_name").html('Distributor Payment Panel'); 
					$(".button_name").html('Distributor Payment'); 
				},
				error: function (jXHR, textStatus, errorThrown) {}
			});
		});
		
		
		
		
		var output = '';
		var outputs = '';
		var payment_mode_id = $(this).val();
		var receipt_type = $('#receipt_type').val();
		if(payment_mode_id==2) 
		{	
			$("#result_cheque").show(); 		
			$("#card_id_list").hide(); 		
		}
		else if(payment_mode_id==3) 
		{
			var outputs='';
			var urlx='<?php echo base_url();?>account_controller/get_all_card';			
			$.ajax
			({
				url: urlx,
				type: 'POST',
				dataType: 'json',
				data: {'payment_mode_id':payment_mode_id},
				success:function(result)
				{	
					outputs+='<option value="">Select Card</option>';
					for(var i=0; i<result.length; i++ )
					{
					  outputs+='<option value="'+result[i].card_id+'">'+result[i].card_name+'</option>';
					}
					$("#card_id_list").show(); 
					$("#card_id").html(outputs);
					$("#result_cheque").hide();
					if(receipt_type==3)
					{
						$("#customer_list").show();
						$("#distributor_list").hide();
						$("#service_provider_list").hide();
					}
					else if(receipt_type==1)
					{
						$("#distributor_list").show();
						$("#customer_list").hide();
						$("#service_provider_list").hide();
					}
					else if(receipt_type==2)
					{
						$("#service_provider_list").show();
						$("#customer_list").hide();
						$("#distributor_list").hide();
					}
				},
				error: function (jXHR, textStatus, errorThrown) {}
			});
			
		}
		else if(payment_mode_id==1) 
		{

			$("#card_id_list").hide(); 
			$("#result_cheque").hide(); 							

		}
			
		
	});
	$('#submit_btn').on('click', function(e)
	{
		e.preventDefault();
		swal({
		  title               : 'Are You Sure About Transaction?',
		  text                : "You won't be able to revert this!",
		  type                : 'warning',
		  showCancelButton    : true,
		  confirmButtonColor  : '#db8b0b',
		  cancelButtonColor   : '#008d4c',
		  confirmButtonText   : 'Yes',
		  cancelButtonText    : 'No'
		}).then(function() 
		{
			var customer_id     	 = $('#customer_id').val();
			var distributor_id  	 = $('#distributor_id').val();
			var service_provider_id  = $('#service_provider_id').val();
			var payment_mode    	 = $('#payment_mode').val();
			var receipt_type   		 = $('#receipt_type').val();
			var payment_input 		 = $('.payment_input').val();
			var my_bank    			 = $('#my_bank').val();
			var to_bank    			 = $('#to_bank').val();
			var cheque_no_id    	 = $('#cheque_no_id').val();
			var cheque_date     	 = $('#datasep').val();
			var card_id     		 = $('#card_id').val();
			var balance_customer     = $('#balance_amount_customer').val();
			var remarks     		 = $('.remarks').val();
			if(payment_mode != '' && receipt_type != '' && payment_input != '')
			{
				$.ajax({
					url: '<?php echo base_url()?>account_controller/do_collection_payment',
					type: "POST",
					cache: false,
					async: false,
					data: { 
						payment_mode    	 : payment_mode, 
						receipt_type    	 : receipt_type, 
						customer_id     	 : customer_id, 
						distributor_id  	 : distributor_id, 
						service_provider_id  : service_provider_id, 
						payment_amount  	 : payment_input, 
						my_bank    			 : my_bank,
						to_bank    			 : to_bank,
						cheque_no    		 : cheque_no_id,
						cheque_date     	 : cheque_date,
						card_id         	 : card_id,
						remarks         	 : remarks,   						
						balance_customer     : balance_customer         
					},
					success:function(result)
					{
						$('#remarks').val('');
						$('#customer_id').val('');
						$('#customer_id').select2();
						$('#service_provider_id').val('');
						$('#service_provider_id').select2();
						$('#my_bank').val('');
						$('#my_bank').select2();
						$('#to_bank').val('');
						$('#to_bank').select2();
						$('#distributor_id').val('');
						$('#distributor_id').select2();
						$('#payment_mode').val('');
						$('#payment_mode').select2();
						$('#receipt_type').val('');
						$('#receipt_type').select2();
						$('#card_id').val('');
						$('#card_id').select2();
						$('.payment_input').val("");
						$('#bank_name_id').val("");
						$('#cheque_no_id').val("");
						$('#datasep').val("");
						
						swal(
							'Oops...!',
							'Data Insert Successfully!',
							'success'
						  );
						location.reload(); 
						window.open("<?php echo base_url()?>New_invoice_print/collection_payment_invoice/"+result+"/"+receipt_type, '_blank');          
					}  
				});
					
			}
		
			else 
			{
			  swal(
				'Oops...!',
				'Data Missing!',
				'warning'
			  );
			}
		})
	});
});
/* $(document).on('keyup','.payment_input',function (e) 
{	
	var payment_amount = parseFloat($(this).val());
	var due_amount = parseFloat($('#due_amount').val());
	if(payment_amount > due_amount)
	{
		$('#submit_btn').prop('disabled', true);
	}
	else{
		$('#submit_btn').prop('disabled', false);
	}
}); */
</script>
</div>
=======
<?php $this -> load -> view('include/header'); ?>
<script type='text/javascript' charset='utf-8' src='<?php echo base_url();?>js/jquery-1.10.2.js'></script>
<script src="<?php echo base_url();?>assets/assets2/plugins/datepicker/bootstrap-datepicker.js"></script>
<div class="content-wrapper">
<style>

.wrap {
    width: 100%;
	margin:0px 0px 0px 0px;
}
.wrap table {
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
    height: 90px;
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
    width: 1px;
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
.content2{
	min-height: 130px;
	padding: 4px;
}
</style>
<section class="content2" style="margin:0px 0px 0px 0px;min-height:0px;">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header with-border" style="background: #0f77ab;">
					<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;">Receipt Entry</h3>
				</div>
				<form class="form-horizontal">
					<div class="box-body">	
						<div class="form-group">
							<div class="col-sm-4">
								<div class="input-group">
									<span class="input-group-addon">Receipt Type</span>
									<select class="form-control select22 catagory_name" id="receipt_type" style="width: 100%;"tabindex="-1" aria-hidden="true" required="required">
										<option value="1" selected>Purchase Payment Receipt</option>
									</select>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="input-group">
									<span class="input-group-addon">Payment By</span>
									<select class="form-control select2" name="payment_mode" id="payment_mode" style="width:100%;">
										<option value="">Select Mode</option>
										<option value="1">Cash</option>
										<option value="2">Cheque</option>
										<option value="3">Card</option>
									</select>
								</div>
							</div>
							<div class="col-sm-4" style="display:none;" id="customer_list">
								<div class="input-group">
									<input type="hidden" id="balance_amount_customer">
									<span class="input-group-addon">Customer</span>
									<select class="form-control select2" name="customer_id" id="customer_id" style="width:100%;">
									</select>
								</div>
							</div>
							<div class="col-sm-4" style="display:none;" id="distributor_list">
								<div class="input-group">
									<input type="hidden" id="balance_amount_distributor">
									<span class="input-group-addon">Distributor</span>
									<select class="form-control select2" name="distributor_id" id="distributor_id" style="width:100%;">
									</select>
								</div>
							</div>
							<div class="col-sm-4" style="display:none;" id="service_provider_list">
								<div class="input-group">
									<span class="input-group-addon">Provider</span>
									<select class="form-control select2" name="service_provider_id" id="service_provider_id" style="width:100%;">
									</select>
								</div>
							</div>
						</div>
						<div class="box-footer" style="background: #0f77ab;display:none;" id="card_id_list">
							<div class="col-sm-4">
								<div class="input-group">
									<span class="input-group-addon">Card</span>
									<select class="form-control select2" name="card_id" id="card_id" style="width:100%;">
									</select>
								</div>
							</div>
						</div>
						<div class="box-footer" style="background: #6c8490;padding: 6px;height: 48px;display:none;" id="result_cheque">
								<div class="form-group">
									<label for="inputEmail3" class="col-sm-1 control-label" style="color:white;">My</label>
									<div class="col-sm-2">
										<?php 	
											echo form_dropdown('my_bank', $bank_info, '' ,'class="form-control select22" id="my_bank" style="width: 100%;" tabindex="-1" aria-hidden="true" required="required"');
										?>
									</div>
									<label for="inputEmail3" class="col-sm-1 control-label" style="color:white;">Bank</label>
									<div class="col-sm-2">
										<?php 	
											echo form_dropdown('to_bank', $bank_info, '' ,'class="form-control select22" id="to_bank" style="width: 100%;" tabindex="-1" aria-hidden="true" required="required"');
										?>
									</div>
									<label for="inputEmail3" class="col-sm-1 control-label" style="color:white;">Cheque</label>
									<div class="col-sm-2">
										<input type="text" name="cheque_no" class="form-control" id="cheque_no_id" placeholder="Cheque No" title="Cheque No" autocomplete="off">
									</div>
									<label for="inputEmail3" class="col-sm-1 control-label" style="color:white;">Date</label>
									<div class="col-sm-2">
										<input type="text" class="form-control" name="cheque_date" id="datasep" placeholder="Cheque Date" title="Cheque Date">
									</div>
								</div>
							</div>
					</div> 
				</form>
			</div> 
		</div> 
	</div> 
</section>
<section class="content2 collection_payment" style="display:none;min-height:0px;">
	<div class="row">
		<div class="col-md-12">
			<div class="box">
				<div class="box-header with-border" style="background: #0f77ab;text-align:center;">
					<h3 class="box-title" style="color:white;font-family:Helvetica Neue,Helvetica,Arial,sans-serif;"><span class="panel_name"></span></h3>
				</div>
				<div class="box-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label"><span class="global_name_label"></span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control global_name_input" readonly>
							</div>
							<label for="inputEmail3" class="col-sm-2 control-label"><span class="global_contact_label"></span></label>
							<div class="col-sm-4">
								<input type="text" class="form-control global_contact_input" readonly>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label"><span class="global_address_label"></span></label>
							<div class="col-sm-10">
								<input type="text" id="customer_address" class="form-control global_address_input" readonly>
							</div>
						</div>
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Remarks</label>
							<div class="col-sm-10">
								<input type="text" class="form-control remarks">
							</div>
						</div>
					</div>
					<form action="<?php echo base_url();?>account_controller/do_collection_payment" class="form-horizontal" method="post" enctype="multipart/form-data">					
						<div class="wrap">
							<table class="head">
								<tr>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;">Total Amount</td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;" id="cheque_return" style="display:none;">Cheque Return</td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;" id="purchase_return" style="display:none;">Purchase Return</td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;" id="expense_cheque_return" style="display:none;">Expense Return</td>
									
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;">Paid Amount</td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;" id="return" style="display:none;">Sale Return</td>
									
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;">Due Amount</td>
									<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:12px;text-align:center;">Payment</td>
								</tr>
							</table>
							<div class="inner_table">
								<table class="new_data_2" id="search_data">
									<tr>
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;"><input type="text" class="form-control total_amount" id="total_amount" style="text-align:right;" readonly></td>
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;display:none;" id="cheque_return_amount2"><input type="text" id="cheque_return_amount" class="form-control" style="text-align:right;" readonly></td>
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;display:none;" id="purchase_return_amount2"><input type="text" id="purchase_return_amount" class="form-control" style="text-align:right;" readonly></td>
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;display:none;" id="expense_cheque_return_amount2"><input type="text" id="expense_cheque_return_amount" class="form-control" style="text-align:right;" readonly></td>
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;"><input type="text" id="paid_amount" class="form-control paid_amount" style="text-align:right;" readonly></td>
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;display:none;" id="return_amount2"><input type="text" id="return_amount" class="form-control" style="text-align:right;" readonly></td>
										
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;text-align:right;"><input type="text" id="due_amount" class="form-control due_amount" style="text-align:right;" readonly></td>
										<td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif; width:30px;"><span class="payment_input_result"><input type="text" name="payment_input" class="form-control payment_input" style="text-align:right;" autofocus="on"></span></td>
									</tr>
								</table>
							</div>
						</div>
						<div class="box-footer" style="background: #0f77ab;">
							<center>
								<div class="col-sm-22">
									<button type="submit" class="btn btn-success btn-sm" name="search_random" id="submit_btn"><i class="fa fa-fw fa-save"></i><span class="button_name"></span></button>
								</div>
							</center>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>	
</section> 
<script>
$(document).ready(function()
{
	$("#distributor_id").on("change",function()
	{
		var distributor_id = $(this).val();
		if(distributor_id != '') 
		{
			$('.collection_payment').fadeIn( "slow", function(){
				var urlx='<?php echo base_url();?>account_controller/get_single_distributor_all_purchase_payment_total';
				var outputs='';
				$.ajax
				({
					url: urlx,
					type: 'POST',
					dataType: 'json',
					data: {'distributor_id':distributor_id},
					success:function(result)
					{	
						for(n=0;n<result.ledger_list['receipt_purchase_total_amount'].length;n++)
						{
							var purchase_amount_all =parseFloat(result.ledger_list['receipt_purchase_total_amount'][n]['total_purchase_amount']).toFixed(2);
							var distributor_name =result.ledger_list['receipt_purchase_total_amount'][n]['distributor_name'];
							var distributor_contact =result.ledger_list['receipt_purchase_total_amount'][n]['distributor_contact_no'];
							var distributor_address =result.ledger_list['receipt_purchase_total_amount'][n]['distributor_address'];
							
							//alert(purchase_amount_all);
						}
						for(m=0;m<result.ledger_list['receipt_payment_total_amount'].length;m++)
						{
							var payment_amount_all =parseFloat(result.ledger_list['receipt_payment_total_amount'][m]['total_payment_amount']).toFixed(2);
						}
						for(m=0;m<result.ledger_list['receipt_purchase_return_total_amount'].length;m++)
						{
							var purchase_return_amount_all =parseFloat(result.ledger_list['receipt_purchase_return_total_amount'][m]['total_purchase_return_amount']).toFixed(2);
						}
						for(m=0;m<result.ledger_list['receipt_payment_delete_total_amount'].length;m++)
						{
							var payment_delete_amount_all =parseFloat(result.ledger_list['receipt_payment_delete_total_amount'][m]['total_payment_delet_amount']).toFixed(2);
						}
						for(j=0;j<result.ledger_list['receipt_balance_total_amount'].length;j++)
						{
							var balance_amount_all =parseFloat(result.ledger_list['receipt_balance_total_amount'][j]['total_balance_amount']).toFixed(2);
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
						
						if(isNaN(purchase_return_amount_all))
						{
							purchase_return_amount_all = '0.00';
						}
						else{
							purchase_return_amount_all = purchase_return_amount_all;
						}
						
						
						
						//alert(payment_amount_all);
						if(isNaN(purchase_amount_all))
						{
							purchase_amount_all = '0.00';
						}
						else
						{
							purchase_amount_all = purchase_amount_all;
							
						}
						var due_amount = (parseFloat(purchase_amount_all) +parseFloat(balance_amount_all) +  parseFloat(payment_delete_amount_all) - parseFloat(payment_amount_all)).toFixed(2);
						//alert('Purchase '+purchase_amount_all);
						//alert('Balance '+balance_amount_all);
						//alert('Delete Amount '+payment_delete_amount_all);
						//alert('Payment '+payment_amount_all);
						if(isNaN(due_amount))
						{
							due_amount = '0.00';
						}
						else{
							due_amount = due_amount;
						}
						$('#return').hide();
						$('#return_amount').hide();
						$('#return_amount2').hide();
						$('#cheque_return').show();
						$('#cheque_return_amount').show();
						$('#cheque_return_amount2').show();
						$('#purchase_return').show();
						$('#purchase_return_amount').show();
						$('#purchase_return_amount2').show();
						$('#expense_cheque_return').hide();
						$('#expense_cheque_return_amount').hide();
						$('#expense_cheque_return_amount2').hide();
						$(".global_name_label").html('Distributor Name'); 
						$(".global_contact_label").html('Distributor Contact'); 
						$(".global_address_label").html('Distributor Address'); 

						$(".global_name_input").val(distributor_name); 
						$(".global_contact_input").val(distributor_contact); 
						$(".global_address_input").val(distributor_address); 
						$(".total_amount").val(parseFloat(purchase_amount_all) +  parseFloat(balance_amount_all)); 
						 
						var paid = payment_amount_all - payment_delete_amount_all;
						//alert(paid);
						//alert(payment_delete_amount_all);
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
						$(".paid_amount").val(paid); 
						$("#cheque_return_amount").val(payment_delete_amount_all); 
						$("#purchase_return_amount").val(purchase_return_amount_all); 
						$(".due_amount").val(due_amount); 
						$(".balance_amount_distributor").val(balance_amount_all); 
					},
					error: function (jXHR, textStatus, errorThrown) {}
				});
			});
		} 
	});	
	
	$("#payment_mode").on("change",function()
	{
		$('#distributor_list').fadeIn( "slow", function(){
			var urlx='<?php echo base_url();?>account_controller/get_all_distributor';
			var output3s='';
			$.ajax
			({
				url: urlx,
				type: 'POST',
				dataType: 'json',
				//data: {'receipt_type':receipt_type},
				success:function(result)
				{	
					output3s+='<option value="">Select Distributor</option>';
					for(var i=0; i<result.length; i++ )
					{
					  output3s+='<option value="'+result[i].distributor_id+'">'+result[i].distributor_name+'</option>';
					}
					$("#distributor_id").html(output3s);
					$(".panel_name").html('Distributor Payment Panel'); 
					$(".button_name").html('Distributor Payment'); 
				},
				error: function (jXHR, textStatus, errorThrown) {}
			});
		});
		
		
		
		
		var output = '';
		var outputs = '';
		var payment_mode_id = $(this).val();
		var receipt_type = $('#receipt_type').val();
		if(payment_mode_id==2) 
		{	
			$("#result_cheque").show(); 		
			$("#card_id_list").hide(); 		
		}
		else if(payment_mode_id==3) 
		{
			var outputs='';
			var urlx='<?php echo base_url();?>account_controller/get_all_card';			
			$.ajax
			({
				url: urlx,
				type: 'POST',
				dataType: 'json',
				data: {'payment_mode_id':payment_mode_id},
				success:function(result)
				{	
					outputs+='<option value="">Select Card</option>';
					for(var i=0; i<result.length; i++ )
					{
					  outputs+='<option value="'+result[i].card_id+'">'+result[i].card_name+'</option>';
					}
					$("#card_id_list").show(); 
					$("#card_id").html(outputs);
					$("#result_cheque").hide();
					if(receipt_type==3)
					{
						$("#customer_list").show();
						$("#distributor_list").hide();
						$("#service_provider_list").hide();
					}
					else if(receipt_type==1)
					{
						$("#distributor_list").show();
						$("#customer_list").hide();
						$("#service_provider_list").hide();
					}
					else if(receipt_type==2)
					{
						$("#service_provider_list").show();
						$("#customer_list").hide();
						$("#distributor_list").hide();
					}
				},
				error: function (jXHR, textStatus, errorThrown) {}
			});
			
		}
		else if(payment_mode_id==1) 
		{

			$("#card_id_list").hide(); 
			$("#result_cheque").hide(); 							

		}
			
		
	});
	$('#submit_btn').on('click', function(e)
	{
		e.preventDefault();
		swal({
		  title               : 'Are You Sure About Transaction?',
		  text                : "You won't be able to revert this!",
		  type                : 'warning',
		  showCancelButton    : true,
		  confirmButtonColor  : '#db8b0b',
		  cancelButtonColor   : '#008d4c',
		  confirmButtonText   : 'Yes',
		  cancelButtonText    : 'No'
		}).then(function() 
		{
			var customer_id     	 = $('#customer_id').val();
			var distributor_id  	 = $('#distributor_id').val();
			var service_provider_id  = $('#service_provider_id').val();
			var payment_mode    	 = $('#payment_mode').val();
			var receipt_type   		 = $('#receipt_type').val();
			var payment_input 		 = $('.payment_input').val();
			var my_bank    			 = $('#my_bank').val();
			var to_bank    			 = $('#to_bank').val();
			var cheque_no_id    	 = $('#cheque_no_id').val();
			var cheque_date     	 = $('#datasep').val();
			var card_id     		 = $('#card_id').val();
			var balance_customer     = $('#balance_amount_customer').val();
			var remarks     		 = $('.remarks').val();
			if(payment_mode != '' && receipt_type != '' && payment_input != '')
			{
				$.ajax({
					url: '<?php echo base_url()?>account_controller/do_collection_payment',
					type: "POST",
					cache: false,
					async: false,
					data: { 
						payment_mode    	 : payment_mode, 
						receipt_type    	 : receipt_type, 
						customer_id     	 : customer_id, 
						distributor_id  	 : distributor_id, 
						service_provider_id  : service_provider_id, 
						payment_amount  	 : payment_input, 
						my_bank    			 : my_bank,
						to_bank    			 : to_bank,
						cheque_no    		 : cheque_no_id,
						cheque_date     	 : cheque_date,
						card_id         	 : card_id,
						remarks         	 : remarks,   						
						balance_customer     : balance_customer         
					},
					success:function(result)
					{
						$('#remarks').val('');
						$('#customer_id').val('');
						$('#customer_id').select2();
						$('#service_provider_id').val('');
						$('#service_provider_id').select2();
						$('#my_bank').val('');
						$('#my_bank').select2();
						$('#to_bank').val('');
						$('#to_bank').select2();
						$('#distributor_id').val('');
						$('#distributor_id').select2();
						$('#payment_mode').val('');
						$('#payment_mode').select2();
						$('#receipt_type').val('');
						$('#receipt_type').select2();
						$('#card_id').val('');
						$('#card_id').select2();
						$('.payment_input').val("");
						$('#bank_name_id').val("");
						$('#cheque_no_id').val("");
						$('#datasep').val("");
						
						swal(
							'Oops...!',
							'Data Insert Successfully!',
							'success'
						  );
						location.reload(); 
						window.open("<?php echo base_url()?>New_invoice_print/collection_payment_invoice/"+result+"/"+receipt_type, '_blank');          
					}  
				});
					
			}
		
			else 
			{
			  swal(
				'Oops...!',
				'Data Missing!',
				'warning'
			  );
			}
		})
	});
});
/* $(document).on('keyup','.payment_input',function (e) 
{	
	var payment_amount = parseFloat($(this).val());
	var due_amount = parseFloat($('#due_amount').val());
	if(payment_amount > due_amount)
	{
		$('#submit_btn').prop('disabled', true);
	}
	else{
		$('#submit_btn').prop('disabled', false);
	}
}); */
</script>
</div>
>>>>>>> 126491c5b956413b4ebc35a0628acbc4d375a4e7
<?php $this -> load -> view('include/footer'); ?>