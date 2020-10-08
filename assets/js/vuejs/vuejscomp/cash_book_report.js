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
				$(".modal").hide();
				total_amount1 = 0.00;
				for(i=0; i<result['credit'].length; i++)
				{	
					var amount1=parseFloat(Math.round(result['credit'][i].amount));
					total_amount1+=parseFloat(Math.round(result['credit'][i].amount));
					//alert(total_amount1);
					output2+='<table><tr><td style="width: 4%;">'+result['credit'][i].date+'</td><td style="width: 4%;">'+result['credit'][i].transaction_purpose+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;width: 4%;text-align:right;">'+amount1.toFixed(2)+'</td></tr></table>';
					
				}
				total_amount2 = 0.00;
				for(k=0; k<result['debit'].length; k++)
				{	
					var amount2  =parseFloat(Math.round(result['debit'][k].amount));
					total_amount2+=parseFloat(Math.round(result['debit'][k].amount));
					//alert(total_amount2);
					if(result['debit'][k].type_type!=null)
					{
					output3+='<table class="new_data_2"><tr><td style="width: 4%;">'+result['debit'][k].date+'</td><td style="width: 4%;">'+result['debit'][k].transaction_purpose+'<br>'+result['debit'][k].type_type+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;width: 4%;text-align:right;">'+amount2.toFixed(2)+'</td></tr></table>';
					}
					else{
						output3+='<table class="new_data_2"><tr><td style="width: 4%;">'+result['debit'][k].date+'</td><td style="width: 4%;">'+result['debit'][k].transaction_purpose+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;width: 4%;text-align:right;">'+amount2.toFixed(2)+'</td></tr></table>';
					}
				}
				var balance=total_amount1-total_amount2;
				$('#balance').html(balance.toFixed(2));
				if(output2 != '')
				{
					$('#search_data').html(output2);
					$('#total_debit').html(total_amount1.toFixed(2));
					$('#infomsg').show();
					$('#down').show();
				}
				else
				{
					$('#search_data').html("No Data Available");
					$('#infomsg').show();
					$('#down').show();
				}
				if(output3 != '')
				{
					$('#search_data2').html(output3);
					$('#total_credit').html(total_amount2.toFixed(2));
					$('#infomsg').show();
					$('#down').show();
				}
				else
				{
					$('#search_data2').html("No Data Available");
					$('#infomsg').show();
					$('#down').show();
				}
				var start1 = $('#datepickerrr').val();
				var end1 = $('#datepickerr').val();
				$('#start').val(start1);
				$('#end').val(end1);
				
				$('.start2').text(start1);
				$('.end2').text(end1);

				//$('#datepickerrr').val('');
				//$('#datepickerr').val('');

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

$(document).ready(function() {
		$("#reset_btn").click(function(event) {
		event.preventDefault();
				$('#lock3').val('');
				$('#lock3').select2();
				$('#lock4').val('');
				$('#lock4').select2();
				$('#lock5').val('');
				$('#lock5').select2();
				$('#lock22').val('');
				$('#datep').val('');
				$('#datep2').val('');
		});
	});