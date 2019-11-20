$(document).ready(function()
	{
		$("#form_3").on("submit",function(event)
		{
			event.preventDefault();
			var submiturl = $(this).attr('action');
			var start = $("#datepickerrr").val();
			var end = $("#datepickerr").val();

			if(start == ''){
				start = 'null';
			}
			if(end == ''){
				end = 'null';
			}

			window.open(submiturl+'/'+start+'/'+end,'_self');
		});
	});