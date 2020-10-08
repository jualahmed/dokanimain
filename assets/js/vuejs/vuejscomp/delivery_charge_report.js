$(document).ready(function() {
		$("#form_6").submit(function(event) {
		event.preventDefault();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		var type_id = $('#type').val();
		var output = '';
		var output2 = '';
		var output3 = '';
		var i=0;
		var k= 1;
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
				for(i=0; i<result.length; i++)
				{	
					var amount  =parseFloat(Math.round(result[i].amount)).toFixed(2);
					output2+='<table class="new_data_2"><tr><td>'+k+'</td><td>'+result[i].date+'</td><td>'+result[i].common_id+'</td><td style="text-align:right;">'+amount+'</td></tr></table>';
					k++;
					
				}
				if(output2 != '')
				{
					$('#search_data').html(output2);
					$('#infomsg').show();
					$('#down').show();
				}
				else
				{
					$('#search_data').html("No Data Available");
					$('#infomsg').show();
					$('#down').hide();
				}
				var start1 = $('#datepickerrr').val();
				var end1 = $('#datepickerr').val();
				$('#start').val(start1);
				$('#end').val(end1);
				
				$('.start2').text(start1);
				$('.end2').text(end1);
				
				
				$('#lock111').val('');
				$('#lock22').val('');

			}
		});
	});
	
	$("#down").click(function(event2) {
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
			$('#lock22').val('');
			$('#datep').val('');
			$('#datep2').val('');
		});
	});