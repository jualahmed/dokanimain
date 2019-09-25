function blinker() 
{
	$('.total_click').fadeOut(500);
	$('.total_click').fadeIn(500);
}
setInterval(blinker, 1000);
$(document).ready(function() 
{
	$("input[type='checkbox'].s1").click(function() 
	{
		if ($(this).is(':checked')) 
		{
			$('.s2,.s3').not('.s1').removeAttr('checked');
			var submiturl 	= base_url+'salereturn/cash_salereturn/product';
	
			window.open(submiturl,'_self');
		} 
		else 
		{
			$('.s2,.s3').removeAttr('checked');
		}
	});
	$("input[type='checkbox'].s2").click(function() 
	{
		if ($(this).is(':checked')) 
		{
			$('.s1,.s3').not('.s2').removeAttr('checked');
			var submiturl 	= base_url+'salereturn/cash_salereturn/cash';
	
			window.open(submiturl,'_self');
		} 
		else 
		{
			$('.s1,.s3').removeAttr('checked');
		}
	});
	$("input[type='checkbox'].s3").click(function() 
	{
		if ($(this).is(':checked')) 
		{
			$('.s1,.s2').not('.s3').removeAttr('checked');
			var submiturl 	= base_url+'salereturn/cash_salereturn/productsale';
	
			window.open(submiturl,'_self');
		} 
		else 
		{
			$('.s1,.s2').removeAttr('checked');
		}
	});
	$("input[type='checkbox'].select1").click(function() 
	{
		if ($(this).is(':checked')) 
		{
			$('.selectt222').not('.select1').removeAttr('checked');
			var return_type = $("#return_type").val();
			var submiturl 	= base_url+'salereturn/cash_salereturn/'+return_type+'/yes';
	
			window.open(submiturl,'_self');
		} 
		else 
		{
			$('.selectt222').removeAttr('checked');
		}
	});
	$("input[type='checkbox'].selectt222").click(function() 
	{
		if ($(this).is(':checked')) 
		{
			$('.select1').not('.selectt222').removeAttr('checked');
			var return_type = $("#return_type").val();
			var submiturl 	= base_url+'salereturn/cash_salereturn/'+return_type+'/no';
	
			window.open(submiturl,'_self');
		} 
		else 
		{
			$('.select1').removeAttr('checked');
		}
	});
		
	//$("#submit").prop("disabled", true);
	$("#invoice_id").on('keyup', function(ev)
	{
		ev.preventDefault();

		if(ev.which == 13)
		{
			var invoice_id = $(this).val();
			var return_type = $("#return_type").val();
			var invo_type = $("#invo_type").val();
			var submiturl 	= base_url+'salereturn/cash_salereturn/'+return_type+'/'+invo_type+'/'+invoice_id;
			
			window.open(submiturl,'_self');
		}
	});
	$("#product_id").on("change",function()
	{
		var product_id = $(this).val();
		var return_type = $("#return_type").val();
		var invo_type = $('#invo_type').val();
		var invoice_id = $('#in_id').val();
		if(invoice_id==''){
			invoice_id='null';
		}
		else{
			invoice_id=invoice_id;
		}
		var submiturl 	= base_url+'salereturn/cash_salereturn/'+return_type+'/'+invo_type+'/'+invoice_id+'/'+product_id;
		
		window.open(submiturl,'_self');
	});
	$("#return_amount").keyup(function()
	{
		var length=$("#return_amount").val().length;
		if(length>=1)
		{
			$("#submit").prop("disabled", false);
		}
		else
		{
			$("#submit").prop("disabled", true);
		}
	});
	$('.delete_product').click(function(){
		var edit_id 		= $(this).attr('id');
		var kval 			= edit_id.substring(6,10000000000000000000000000000000);
		swal({
			title               : 'Are you sure?',
			text                : "You won't be able to revert this!",
			type                : 'warning',
			showCancelButton    : true,
			confirmButtonColor  : '#db8b0b',
			cancelButtonColor   : '#419641',
			confirmButtonText   : 'Yes',
			cancelButtonText    : 'No'
		}).then(function () {

			$.ajax({
				url     : base_url+'salereturn/removeProduct',
				type    : "POST",
				cache   : false,
				data    : { srmp_id: kval},
				success : function(result){
					swal(
					  'Deleted!',
					  'Data Delete Successfully..!)',
					  'success'
					);
					//thisTr.remove();	
					location.reload();
				}

			});
		})
	});
	$("#customer_id").on("change",function()
	{
		var urlx=base_url+'salereturn/get_customer_transaction';
		var customer_id=$(this).val();
		var outputs='';
		$.ajax
		({
			url: urlx,
			type: 'POST',
			dataType: 'json',
			data: {'customer_id':customer_id},
			success:function(result)
			{
				
				for(var ii=0; ii<result['balance'].length; ii++)
				{
					var balance_amount = parseFloat(result['balance'][ii].balance_amount);
					var customer_name = result['balance'][ii].customer_name;
					var customer_id = result['balance'][ii].customer_id;
					
				}
				for(var ii=0; ii<result['sale'].length; ii++)
				{
					var sale_amount = parseFloat(result['sale'][ii].sale_amount);
					
				}
				
				for(var ii=0; ii<result['sale_return'].length; ii++)
				{
					var sale_retrun_amount = parseFloat(result['sale_return'][ii].sale_retrun_amount);
					
				}

				if(isNaN(balance_amount))
				{
					balance_amount =0;
				}
				if(isNaN(sale_amount))
				{
					sale_amount =0;
				}
				if(isNaN(sale_retrun_amount))
				{
					sale_retrun_amount =0;
				}

				$('#all_sa_col').show();
				$("#ledger_amount_sale").html(parseFloat(sale_amount).toFixed(2));
				$("#ledger_amount_collection").html(parseFloat(balance_amount).toFixed(2));
				$("#ledger_amount_sale_return").html(parseFloat(sale_retrun_amount).toFixed(2));
				var totbalac = parseFloat(balance_amount) + parseFloat(sale_retrun_amount);

				$("#ledger_amount_balance").html(parseFloat(sale_amount - totbalac).toFixed(2)); 
				var tot_return_price = $('#total_amount_return').html();
				var tot_return_balance_price = $('#ledger_amount_balance').html();
				if(tot_return_price > tot_return_balance_price)
				{
					var return_adjustment_amount = parseFloat(tot_return_price) - parseFloat(tot_return_balance_price);
				}
				else if(tot_return_balance_price >= tot_return_price)
				{
					var return_adjustment_amount = 0;
				}
				
				$('#return_adjustment_amount').val(return_adjustment_amount);
			},
		});	
	});
});