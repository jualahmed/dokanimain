$(document).ready(function() 
{
	$("#search_random").click(function(event2) 
	{
		event2.preventDefault();
		submiturl = base_url+'Report/purchase_return_report_new';
		var distributor_id = $('#distributor_id').val();
		var start = $('#datepickerrr').val();
		var end = $('#datepickerr').val();

		if(distributor_id == ''){
			distributor_id = 'null';
		}
		if(start == ''){
			start = 'null';
		}
		if(end == ''){
			end = 'null';
		}

		window.open(submiturl+'/'+distributor_id+'/'+start+'/'+end,'_self');
	});
});

$(document).ready(function() {
	$("#reset_btn").click(function(event) {
	event.preventDefault();
		$('#lock22').val('');
		$('#datep').val('');
		$('#datep2').val('');
	});
});