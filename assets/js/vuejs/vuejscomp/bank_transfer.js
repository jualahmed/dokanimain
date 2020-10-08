
$(document).ready(function()
{
	$("#transfer_type").select2();
	$("#bank_id").select2();
	$("#transfer_type").on("change",function()
	{
		var transfer_type = $(this).val();
		if(transfer_type == 2) 
		{
			$('#cheque_div').show();
		} 
		else
		{
			$('#cheque_div').hide();
		} 
	});	
	
});