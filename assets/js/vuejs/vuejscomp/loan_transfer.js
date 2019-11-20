$(document).ready(function()
{
	$("#transfer_type").on("change",function()
	{
		var transfer_type = $(this).val();
		if(transfer_type == 2 || transfer_type == 1) 
		{
			$('.payment_div').show();
		} 
		else
		{
			$('.payment_div').hide();
		} 
	});	
	
	$("#payment_type").on("change",function()
	{
		var payment_type = $(this).val();
		if(payment_type == 2) 
		{
			$('.cheque_div').show();
		} 
		else
		{
			$('.cheque_div').hide();
		} 
	});	
	
});
$(document).ready(function() {
	$('#add_loan_person_form').on('submit', function(service){
		service.preventDefault();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		 $.ajax({
			url: submiturl,
			type: methods,
			data: $(this).serialize(),
			success:function(result)
			{
				if(result=='success'){
					location.reload();
				}
			}
		});
		
	});
});