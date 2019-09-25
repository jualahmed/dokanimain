$(document).ready(function() 
{
	$("#form_6").submit(function(event) 
	{
		event.preventDefault();
		var type = $('#type').val();
		if(type=='payable')
		{
			var submiturl = base_url+'account/all_pay_report_find';
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
			var submiturl = base_url+'account/all_pay_report_find';
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
			var submiturl = base_url+'account/all_pay_report_find';
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