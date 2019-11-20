jQuery(document).ready(function($) {
	$('#search_invoice').keyup(function() 
	{
		var rows = $('#myTable tr');
		var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

		rows.show().filter(function() {
			var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
			return !~text.indexOf(val);
		}).hide();
	});
});

$(document).ready(function() 
{
	$("#form_4").submit(function(event) 
	{
		event.preventDefault();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
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
				 $(".modal1234").show();
			},
			success: function(result) {	
				$(".modal1234").hide();
				for(i=0; i<result.length; i++){	  
					output2+='<table class="table" id="myTable"><tr><td style="text-align:center;">'+k+'</td><td style="text-align:center;">'+result[i].invoice_id+'</td><td style="text-align:center;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+result[i].invoice_doc+'">'+result[i].invoice_doc+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].total_price+'" >'+result[i].total_price+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].user_full_name+'" >'+result[i].user_full_name+'</td><td style="text-align:center;"><a class="btnDelete" style="cursor:pointer;"><i class="fa fa-fw fa-close"></i></a></tr></table>';
					k++;
				}
				if(output2 != '')
				{
					$('#search_data').html(output2);
					$('#infomsg').show();
				}
				else
				{
					$('#search_data').html("No Data Available");
					$('#infomsg').show();
				}
				$('#invoice_id').val('');
				$('#datepickerr').val('');
				$('#datepickerrr').val('');
			}
		});
	});
});
$(document).on("click", ".btnDelete", function() 
{
	if (confirm("Are you sure?")) {
	var par = $(this).parent().parent();
	deleter(par);
	
	}
	return false;
});
			
function deleter(par) 
{
	var td_Id = par.children("td:nth-child(2)");
	var urlx=base_url+'modify/modify_single_invoice';
	var id=td_Id.html();
	 $.ajax({
		url: urlx,
		type: 'POST',
		dataType: 'json',
		data: {'id':id},
		success:function(result)
		{	
			alert("Successfully Delete Invoice.");
		},
		error: function (jXHR, textStatus, errorThrown) {}
	}); 
	
	par.remove();
 
}	