$(document).ready(function() {
		$("#form_4").submit(function(event) {
		event.preventDefault();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		var output = '';
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
					output+='<table class="table"><tr><td width="8%">'+k+'</td><td width="8%">'+result[i].expense_id+'</td><td width="15%" title="'+result[i].expense_type+'">'+result[i].type_type+'</td><td width="15%" title="'+result[i].expense_amount+'" >'+result[i].expense_amount+'</td><td width="15%" title="'+result[i].expense_doc+'">'+result[i].expense_doc+'</td><td style="text-align:center;"><a class="btnDelete" style="cursor:pointer;"><i class="fa fa-fw fa-close"></i></a></td></tr></table>';
					k++;
				}
				if(output != '')
				{
					$('#search_data').html(output);
					$('#infomsg').show();
				}
				else
				{
					$('#search_data').html("No Data Available");
					$('#infomsg').show();
				}
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
	var urlx=base_url+'modify/delete_expense_info';
	var id=td_Id.html();
	 $.ajax({
		url: urlx,
		type: 'POST',
		dataType: 'json',
		data: {'id':id},
		success:function(result)
		{	
			alert("Successfully Delete Expense.");
		},
		error: function (jXHR, textStatus, errorThrown) {}
	}); 
	
	par.remove();
 
}