$(document).ready(function() {
	$("#form_6").submit(function(event) {
		event.preventDefault();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		var output = '';
		var output2 = '';
		var output3 = '';
		var total_amount1 = 0.00;
		var total_amount2 = 0.00;
		var i=0;
		var k= 0;
		$.ajax({
			url: submiturl,
			type: methods,
			dataType: 'json',
			data: $(this).serialize(),
			beforeSend: function(){
				 $(".modal").show();
			},
			success: function(result) {	
				console.log(result);
				$(".modal").hide();
				total_amount1 = 0.00;
				for(i=0; i<result.length; i++)
				{	
					var amount1=parseFloat(Math.round(result[i].amount));
					total_amount1+=parseFloat(Math.round(result[i].amount));
					output2+='<table><tr><td style="width: 1%;">'+result[i].transaction_id+'</td><td style="width: 1%;">'+result[i].transaction_mode+'</td><td style="width: 2%;">'+result[i].ledger_id+'</td><td style="width: 4%;">'+result[i].customer_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;width: 2%;text-align:right;">'+amount1.toFixed(2)+'</td><td style="width: 2%;text-align:center;">'+result[i].date_time+'</td><td style="width: 2%;">'+result[i].user_full_name+'</td></tr></table>';
					
				}
				if(output2 != '')
				{
					$('#search_data').html(output2);
					$('#total_amount').html(total_amount1.toFixed(2));
					$('#infomsg').show();
					$('#down').show();
				}
				else
				{
					$('#search_data').html("No Data Available");
					$('#infomsg').show();
					$('#down').show();
				}
				
				var start1 = $('#datepickerrr').val();
				var end1 = $('#datepickerr').val();
				$('#start').val(start1);
				$('#end').val(end1);
				
				$('.start2').text(start1);
				$('.end2').text(end1);
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
