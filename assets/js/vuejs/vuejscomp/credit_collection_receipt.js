$(document).ready(function()
	{		
		$("#customer_id").on("change",function()
		{
			var customer_id = $(this).val();
			if(customer_id != '') 
			{
				$('.collection_payment').fadeIn( "slow", function(){
					var urlx=base_url+'account/get_single_customer_all_sale_payment_total';
					var outputs='';
					$.ajax
					({
						url: urlx,
						type: 'POST',
						dataType: 'json',
						data: {'customer_id':customer_id},
						success:function(result)
						{	
							for(n=0;n<result.ledger_list['receipt_sale_total_amount'].length;n++)
							{
								var sale_amount_all =parseFloat(result.ledger_list['receipt_sale_total_amount'][n]['total_sale_amount']).toFixed(2);
								var sale_amount_all2 =parseFloat(result.ledger_list['receipt_sale_total_amount'][n]['total_sale_amount']).toFixed(2);
								var customer_name =result.ledger_list['receipt_sale_total_amount'][n]['customer_name'];
								var customer_contact =result.ledger_list['receipt_sale_total_amount'][n]['customer_contact_no'];
								var customer_address =result.ledger_list['receipt_sale_total_amount'][n]['customer_address'];
							}
							
							for(m=0;m<result.ledger_list['receipt_collection_total_amount'].length;m++)
							{
								var collection_amount_all =parseFloat(result.ledger_list['receipt_collection_total_amount'][m]['total_collection_amount']).toFixed(2);
							}
							for(mm=0;mm<result.ledger_list['receipt_delivery_total_amount'].length;mm++)
							{
								var delivery_amount_all =parseFloat(result.ledger_list['receipt_delivery_total_amount'][mm]['total_delivery_amount']).toFixed(2);
							}
							for(m=0;m<result.ledger_list['receipt_sale_return_total_amount'].length;m++)
							{
								var sale_return_amount_all =parseFloat(result.ledger_list['receipt_sale_return_total_amount'][m]['total_sale_return_amount']).toFixed(2);
							}
							for(im=0;im<result.ledger_list['receipt_cash_return_total_amount'].length;im++)
							{
								var cash_return_amount_all =parseFloat(result.ledger_list['receipt_cash_return_total_amount'][im]['total_cash_return_amount']).toFixed(2);
							}
							for(j=0;j<result.ledger_list['receipt_balance_total_amount'].length;j++)
							{
								var balance_amount_all =parseFloat(result.ledger_list['receipt_balance_total_amount'][j]['total_balance_amount']).toFixed(2);
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
							if(isNaN(cash_return_amount_all))
							{
								cash_return_amount_all = '0.00';
							}
							else
							{
								cash_return_amount_all = cash_return_amount_all;
							}
							
							if(isNaN(sale_amount_all))
							{
								
								sale_amount_all = '0.00';
							}
							else
							{
								sale_amount_all = sale_amount_all;
							}
							var due_amount = parseFloat(sale_amount_all) + parseFloat(cash_return_amount_all) +  parseFloat(balance_amount_all) - parseFloat(collection_amount_all) - parseFloat(sale_return_amount_all) + parseFloat(delivery_amount_all);
							
							if(isNaN(due_amount))
							{
								due_amount = '0.00';
							}
							else
							{
								due_amount = due_amount;
							}
							$('#return').show();
							$('#cashreturn').show();
							$('#cash_return_amount').show();
							$('#cash_return_amount2').show();
							$('#return_amount').show();
							$('#return_amount2').show();
							
							$('#cheque_return').hide();
							$('#cheque_return_amount').hide();
							$('#cheque_return_amount2').hide();
							$('#expense_cheque_return').hide();
							$('#expense_cheque_return_amount').hide();
							$('#expense_cheque_return_amount2').hide();
							$(".global_name_label").html('Customer Name'); 
							$(".global_contact_label").html('Customer Contact'); 
							$(".global_address_label").html('Customer Address'); 
							$(".global_name_input").val(customer_name); 
							$(".global_contact_input").val(customer_contact); 
							$(".global_address_input").val(customer_address); 
							
							$(".total_amount").val(parseFloat(sale_amount_all)+parseFloat(balance_amount_all));
							 
							$(".paid_amount").val(collection_amount_all); 
							$(".delivery_amount").val(delivery_amount_all); 
							$("#cash_return_amount").val(cash_return_amount_all); 
							$("#return_amount").val(sale_return_amount_all); 
							$(".due_amount").val(due_amount); 
							$("#balance_amount_customer").val(balance_amount_all); 
							 
						},
						error: function (jXHR, textStatus, errorThrown) {}
					});
				});
			} 
		});	

		$("#payment_mode").on("change",function()
		{
			
			$('#customer_list').fadeIn( "slow", function(){
				var urlx=base_url+'account/get_all_customer';
				var outputs2='';
				$.ajax
				({
					url: urlx,
					type: 'POST',
					dataType: 'json',
					//data: {'receipt_type':3},
					success:function(result)
					{
						outputs2+='<option value="">Select Customer</option>';
						for(var i=0; i<result.length; i++ )
						{
						  outputs2+='<option value="'+result[i].customer_id+'">'+result[i].customer_name+'</option>';
						}
						$("#customer_id").html(outputs2);
						$(".panel_name").html('Credit Collection Panel'); 
						$(".button_name").html('Credit Collect'); 
					},
					error: function (jXHR, textStatus, errorThrown) {
						
					}
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
				var urlx=base_url+'account/get_all_card';			
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
						url: '<?php echo base_url()?>account/do_collection_payment',
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
							if(result!='cheque')
							{
								window.open("<?php echo base_url()?>New_invoice_print/collection_payment_invoice/"+result+"/"+receipt_type, '_blank');
							}         
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