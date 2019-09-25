$(document).ready(function() {
		$("#form_4").submit(function(event) {
		event.preventDefault();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		var output = '';
		var output2 = '';
		var output3 = '';
		var finaloutput = 0.00;
		var amount = 0.00;
		var i=0;
		var k= 1;
		$.ajax({
			url: submiturl,
			type: methods,
			dataType: 'json',
			data: $(this).serialize(),
			beforeSend: function(){
				 $(".modal1234").show();
			},
			success: function(result)
			{	
				$(".modal1234").hide();
				finaloutput =0;
				for(i=0; i<result.length; i++)
				{				
					finaloutput+= parseFloat(result[i].amount);
					amount = parseFloat(Math.round(result[i].amount)).toFixed(2);
					output2+='<table class="new_data_2"><tr><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;text-align:center;" title="'+result[i].date+'">'+result[i].date+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].card_name+'" >'+result[i].card_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;text-align:center;" title="'+result[i].bank_name+'">'+result[i].bank_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;text-align:center;" title="'+result[i].amount+'">'+amount+'</td></tr></table>';
				}
				if(output2 != '' && finaloutput!='')
				{
					$('#finaloutput').html(finaloutput.toFixed(2));
					$('#search_data').html(output2);
					$('#infomsg').show();
					$('#down').show();
				}
				else
				{
					$('#finaloutput').html("0.00");
					$('#search_data').html("No Data Available");
					$('#infomsg').show();
					$('#down').hide();
				}
				var card_id = $('#lock3').val();
				var start_date = $('#datepickerrr').val();
				var end_date = $('#datepickerr').val();
				
				$('#card').val(card_id);
				$('#start').val(start_date);
				$('#end').val(end_date);
				
				$('#lock3').val('');
				$('#lock3').select2();
				$('#datepickerrr').val('');
				$('#datepickerr').val(''); 

			}
		});
	});
	
	$("#down").click(function(event2) {
		event2.preventDefault();
		submiturl = $(this).attr('href');
		
		var card = $('#card').val();
		var start = $('#start').val();
		var end = $('#end').val();
		
		if(card == ''){
			card = 'null';
		}
		if(start == ''){
			start = 'null';
		}
		if(end == ''){
			end = 'null';
		}

		window.open(submiturl+'/'+card+'/'+start+'/'+end,'_blank');
		
	});

});