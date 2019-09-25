$(document).ready(function()
{	
	$("#expense_type").on("change",function()
	{
		var expense_type = $(this).val();
		if(expense_type == 8) 
		{
			$('#employee_list').fadeIn( "slow", function(){
				var urlx=base_url+'account/get_all_employee';
				var output34s='';
				$.ajax
				({
					url: urlx,
					type: 'POST',
					dataType: 'json',
					data: {'expense_type':expense_type},
					success:function(result)
					{	
						output34s+='<option value="">Select Employee</option>';
						for(var i=0; i<result.length; i++ )
						{
						  output34s+='<option value="'+result[i].employee_id+'">'+result[i].employee_name+'</option>';
						}
						$("#employee_id").html(output34s);
						$(".panel_name").html('Expense Payment Panel'); 
						$(".button_name").html('Expense Payment'); 
					},
					error: function (jXHR, textStatus, errorThrown) {}
				});
			});
		} 
		else 
		{
			$('#employee_list').hide();
			$('.collection_payment').fadeIn( "slow", function(){
				var urlx=base_url+'account/get_single_expense_type_all_expense_payment_total';
				var outputs='';
				$.ajax
				({
					url: urlx,
					type: 'POST',
					dataType: 'json',
					data: {'expense_type':expense_type},
					success:function(result)
					{	
						for(n=0;n<result.ledger_list['receipt_expense_total_amount'].length;n++)
						{
							var expense_amount_all =parseFloat(result.ledger_list['receipt_expense_total_amount'][n]['total_expense_amount']).toFixed(2);
							var service_provider_name =result.ledger_list['receipt_expense_total_amount'][n]['type_type'];
							//var service_provider_contact =result.ledger_list['receipt_expense_total_amount'][n]['service_provider_contact'];
							//var service_provider_address =result.ledger_list['receipt_expense_total_amount'][n]['service_provider_address'];
						}
						for(m=0;m<result.ledger_list['receipt_expense_payment_total_amount'].length;m++)
						{
							var expense_payment_amount_all =parseFloat(result.ledger_list['receipt_expense_payment_total_amount'][m]['total_expense_payment_amount']).toFixed(2);
						}
						//alert(expense_payment_amount_all);
						for(m=0;m<result.ledger_list['receipt_expense_delete_total_amount'].length;m++)
						{
							var expense_delete_amount_all =parseFloat(result.ledger_list['receipt_expense_delete_total_amount'][m]['total_delete_expense_amount']).toFixed(2);
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
						$('#return').hide();
						$('#return_amount').hide();
						$('#return_amount2').hide();
						$('#cheque_return').hide();
						$('#cheque_return_amount').hide();
						$('#cheque_return_amount2').hide();
						
						$('#expense_cheque_return').show();
						$('#expense_cheque_return_amount').show();
						$('#expense_cheque_return_amount2').show();
						$(".global_name_label").html('Type Name'); 
						//$(".global_contact_label").html('Contact'); 
						//$(".global_address_label").html('Address'); 

						$(".global_name_input").val(service_provider_name); 
						//$(".global_contact_input").val(service_provider_contact); 
						//$(".global_address_input").val(service_provider_address); 
						$(".total_amount").val(expense_amount_all); 
						$("#expense_cheque_return_amount").val(expense_delete_amount_all); 
						$(".paid_amount").val(expense_payment_amount_all); 
						$(".due_amount").val(due_amount); 
					},
					error: function (jXHR, textStatus, errorThrown) {}
				});
			});
		} 
	});

	$("#employee_id").on("change",function()
	{
		var employee_id = $(this).val();
		if(employee_id != '') 
		{
			$('.collection_payment').fadeIn( "slow", function(){
				var urlx=base_url+'account/get_single_employee_all_expense_payment_total';
				var outputs='';
				$.ajax
				({
					url: urlx,
					type: 'POST',
					dataType: 'json',
					data: {'employee_id':employee_id},
					success:function(result)
					{	
						for(n=0;n<result.ledger_list['receipt_expense_total_amount'].length;n++)
						{
							var expense_amount_all =parseFloat(result.ledger_list['receipt_expense_total_amount'][n]['total_expense_amount']).toFixed(2);
							var service_provider_name =result.ledger_list['receipt_expense_total_amount'][n]['type_type'];
							var employee_name =result.ledger_list['receipt_expense_total_amount'][n]['employee_name'];
							//var service_provider_contact =result.ledger_list['receipt_expense_total_amount'][n]['service_provider_contact'];
							//var service_provider_address =result.ledger_list['receipt_expense_total_amount'][n]['service_provider_address'];
						}
						for(m=0;m<result.ledger_list['receipt_expense_payment_total_amount'].length;m++)
						{
							var expense_payment_amount_all =parseFloat(result.ledger_list['receipt_expense_payment_total_amount'][m]['total_expense_payment_amount']).toFixed(2);
						}
						//alert(expense_payment_amount_all);
						for(m=0;m<result.ledger_list['receipt_expense_delete_total_amount'].length;m++)
						{
							var expense_delete_amount_all =parseFloat(result.ledger_list['receipt_expense_delete_total_amount'][m]['total_delete_expense_amount']).toFixed(2);
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
						
						var due_amount = parseFloat(expense_amount_all) - parseFloat(expense_payment_amount_all) + parseFloat(expense_delete_amount_all);
						if(due_amount =='NaN')
						{
							due_amount = '0.00';
						}
						else
						{
							due_amount = due_amount;
							
						}
						$('#return').hide();
						$('#return_amount').hide();
						$('#return_amount2').hide();
						$('#cheque_return').hide();
						$('#cheque_return_amount').hide();
						$('#cheque_return_amount2').hide();
						
						$('#expense_cheque_return').show();
						$('#expense_cheque_return_amount').show();
						$('#expense_cheque_return_amount2').show();
						$(".global_name_label").html('Type Name'); 
						$(".global_contact_label").html('Employee Name'); 
						//$(".global_contact_label").html('Contact'); 
						//$(".global_address_label").html('Address'); 

						$(".global_name_input").val(service_provider_name); 
						$(".employee_name").val(employee_name); 
						//$(".global_contact_input").val(service_provider_contact); 
						//$(".global_address_input").val(service_provider_address); 
						$(".total_amount").val(expense_amount_all); 
						$("#expense_cheque_return_amount").val(expense_delete_amount_all); 
						$(".paid_amount").val(expense_payment_amount_all); 
						$(".due_amount").val(due_amount); 
					},
					error: function (jXHR, textStatus, errorThrown) {}
				});
			});
		} 
	});	
	/* $("#service_provider_id").on("change",function()
	{
		var service_provider_id = $(this).val();
		if(service_provider_id != '') 
		{
			$('.collection_payment').fadeIn( "slow", function(){
				var urlx=base_url+'account/get_single_service_provider_all_expense_payment_total';
				var outputs='';
				$.ajax
				({
					url: urlx,
					type: 'POST',
					dataType: 'json',
					data: {'service_provider_id':service_provider_id},
					success:function(result)
					{	
						for(n=0;n<result.ledger_list['receipt_expense_total_amount'].length;n++)
						{
							var expense_amount_all =parseFloat(result.ledger_list['receipt_expense_total_amount'][n]['total_expense_amount']).toFixed(2);
							var service_provider_name =result.ledger_list['receipt_expense_total_amount'][n]['service_provider_name'];
							var service_provider_contact =result.ledger_list['receipt_expense_total_amount'][n]['service_provider_contact'];
							var service_provider_address =result.ledger_list['receipt_expense_total_amount'][n]['service_provider_address'];
						}
						for(m=0;m<result.ledger_list['receipt_expense_payment_total_amount'].length;m++)
						{
							var expense_payment_amount_all =parseFloat(result.ledger_list['receipt_expense_payment_total_amount'][m]['total_expense_payment_amount']).toFixed(2);
						}
						//alert(expense_payment_amount_all);
						for(m=0;m<result.ledger_list['receipt_expense_delete_total_amount'].length;m++)
						{
							var expense_delete_amount_all =parseFloat(result.ledger_list['receipt_expense_delete_total_amount'][m]['total_delete_expense_amount']).toFixed(2);
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
						
						var due_amount = (parseFloat(expense_amount_all) - parseFloat(expense_payment_amount_all));
						if(due_amount =='NaN')
						{
							due_amount = '0.00';
						}
						else
						{
							due_amount = due_amount;
							
						}
						$('#return').hide();
						$('#return_amount').hide();
						$('#return_amount2').hide();
						$('#cheque_return').hide();
						$('#cheque_return_amount').hide();
						$('#cheque_return_amount2').hide();
						
						$('#expense_cheque_return').show();
						$('#expense_cheque_return_amount').show();
						$('#expense_cheque_return_amount2').show();
						$(".global_name_label").html('Service Provider Name'); 
						$(".global_contact_label").html('Contact'); 
						$(".global_address_label").html('Address'); 

						$(".global_name_input").val(service_provider_name); 
						$(".global_contact_input").val(service_provider_contact); 
						$(".global_address_input").val(service_provider_address); 
						$(".total_amount").val(expense_amount_all); 
						$("#expense_cheque_return_amount").val(expense_delete_amount_all); 
						$(".paid_amount").val(expense_payment_amount_all); 
						$(".due_amount").val(due_amount); 
					},
					error: function (jXHR, textStatus, errorThrown) {}
				});
			});
		} 
	});	 */
	
	$("#payment_mode").on("change",function()
	{
		/* $('#service_provider_list').fadeIn( "slow", function(){
			var urlx=base_url+'account/get_all_service_provider';
			var output34s='';
			$.ajax
			({
				url: urlx,
				type: 'POST',
				dataType: 'json',
				data: {'receipt_type':receipt_type},
				success:function(result)
				{	
					output34s+='<option value="">Select Service Provider</option>';
					for(var i=0; i<result.length; i++ )
					{
					  output34s+='<option value="'+result[i].service_provider_id+'">'+result[i].service_provider_name+'</option>';
					}
					$("#service_provider_id").html(output34s);
					$(".panel_name").html('Expense Payment Panel'); 
					$(".button_name").html('Expense Payment'); 
				},
				error: function (jXHR, textStatus, errorThrown) {}
			});
		}); */
		
		$('#expense_type_list').fadeIn( "slow", function(){
			var urlx=base_url+'account/get_all_expense_type';
			var output34s='';
			$.ajax
			({
				url: urlx,
				type: 'POST',
				dataType: 'json',
				data: {'receipt_type':receipt_type},
				success:function(result)
				{	
					output34s+='<option value="">Select Expense Type</option>';
					for(var i=0; i<result.length; i++ )
					{
					  output34s+='<option value="'+result[i].type_id+'">'+result[i].type_type+'</option>';
					}
					$("#expense_type").html(output34s);
					$(".panel_name").html('Expense Payment Panel'); 
					$(".button_name").html('Expense Payment'); 
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
			var expense_type  		 = $('#expense_type').val();
			var employee_id  		 = $('#employee_id').val();
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
						expense_type  		 : expense_type, 
						employee_id  		 : employee_id, 
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
						$('#expense_type').val('');
						$('#expense_type').select2();
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
