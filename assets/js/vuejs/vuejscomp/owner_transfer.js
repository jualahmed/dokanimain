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
	$('#add_owner_form').on('submit', function(service){
		service.preventDefault();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		 $.ajax({
			url: submiturl,
			type: methods,
			data: $(this).serialize(),
			success:function(result){
				$('#show_owner_modal').modal('hide');
				if(result == 'success'){
					alert('Data Successfully Saved.');
					select_new_entry_with_id('owner_info','owner_id','owner_name','owner_name','');
					//service_provider_info', 'service_provider_name
				}
				else if(result == 'exist'){
					alert('Data Already Exists.');
					select_new_entry_with_id('owner_info','owner_id','owner_name','owner_name','owner_provider');
				}
				else if(result == 'error'){
					alert('Data Not Successfully Saved.');
				}
			 },
			error: function (jXHR, textStatus, errorThrown) {html("")}
		});
		
	});
});