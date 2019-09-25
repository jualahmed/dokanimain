$(document).ready(function()
{
	$("#distributor_id").on("change",function()
	{
		var distributor_id = $(this).val();
		if(distributor_id != '') 
		{
			$('.collection_payment').fadeIn( "slow", function(){
				var urlx=base_url+'account/get_single_distributor_all_purchase_payment_total';
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
						var due_amount = (parseFloat(purchase_amount_all) +parseFloat(balance_amount_all) +  parseFloat(payment_delete_amount_all) - parseFloat(payment_amount_all)- parseFloat(purchase_return_amount_all)).toFixed(2);
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
			var urlx=base_url+'account/get_all_distributor';
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
