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