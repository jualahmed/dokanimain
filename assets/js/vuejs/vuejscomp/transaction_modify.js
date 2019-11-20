$('#search_member').keyup(function() 
{
	var rows = $('#myTable tr');
	var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

	rows.show().filter(function() {
		var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
		return !~text.indexOf(val);
	}).hide();
});

$(document).ready(function() 
{
	$("#form_4").submit(function(event) 
	{
		event.preventDefault();
		var purpose_id = $("#purpose_id").val();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		var output = '';
		var output1 = '';
		var output2 = '';
		var output3 = '';
		var output4 = '';
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
				if(purpose_id==1)
				{
					for(i=0; i<result.length; i++)
					{	  
						output+='<table class="table" id="myTable"><tr><td>'+k+'</td><td>'+result[i].transaction_id+'</td><td>'+result[i].transaction_purpose+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+result[i].ledger_name+'">'+result[i].ledger_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:right;" title="'+result[i].amount+'">'+result[i].amount+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].date+'">'+result[i].date+'</td><td style="text-align:center;"><a class="btnDelete" style="cursor:pointer;"><i class="fa fa-fw fa-close"></i></a></td></tr></table>';
						k++;
					}
				}
				if(purpose_id==2)
				{
					for(i=0; i<result.length; i++)
					{	  
						output1+='<table class="table" id="myTable"><tr><td>'+k+'</td><td>'+result[i].transaction_id+'</td><td>'+result[i].transaction_purpose+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+result[i].ledger_name+'">'+result[i].ledger_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:right;" title="'+result[i].amount+'" >'+result[i].amount+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].date+'" >'+result[i].date+'</td><td style="text-align:center;"><a class="btnDelete" style="cursor:pointer;"><i class="fa fa-fw fa-close"></i></a></td></tr></table>';
						k++;
					}
				}
				if(purpose_id==3)
				{
					for(i=0; i<result.length; i++)
					{	  
						output2+='<table class="table" id="myTable"><tr><td>'+k+'</td><td>'+result[i].transaction_id+'</td><td>'+result[i].transaction_purpose+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+result[i].ledger_name+'">'+result[i].ledger_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:right;" title="'+result[i].amount+'" >'+result[i].amount+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].date+'" >'+result[i].date+'</td><td style="text-align:center;"><a class="btnDelete" style="cursor:pointer;"><i class="fa fa-fw fa-close"></i></a></td></tr></table>';
						k++;
					}
				}
				if(purpose_id==4)
				{
					for(i=0; i<result.length; i++)
					{	  
						output3+='<table class="table" id="myTable"><tr><td>'+k+'</td><td>'+result[i].transaction_id+'</td><td>'+result[i].transaction_purpose+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="N/A">N/A</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:right;" title="'+result[i].amount+'" >'+result[i].amount+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].date+'" >'+result[i].date+'</td><td style="text-align:center;"><a class="btnDelete" style="cursor:pointer;"><i class="fa fa-fw fa-close"></i></a></td></tr></table>';
						k++;
					}
				}
				if(purpose_id==5)
				{
					for(i=0; i<result.length; i++)
					{	  
						output4+='<table class="table" id="myTable"><tr><td>'+k+'</td><td>'+result[i].transaction_id+'</td><td>'+result[i].transaction_purpose+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+result[i].ledger_name+'">'+result[i].ledger_name+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:right;" title="'+result[i].amount+'">'+result[i].amount+'</td><td style="overflow: hidden;text-overflow: ellipsis; white-space: nowrap;text-align:center;" title="'+result[i].date+'" >'+result[i].date+'</td><td style="text-align:center;"><a class="btnDelete" style="cursor:pointer;"><i class="fa fa-fw fa-close"></i></a></td></tr></table>';
						k++;
					}
				}
				if(purpose_id==1)
				{
					if(output!='')
					{
						$('#search_data').html(output);
						$('#infomsg').show();
					}
					else
					{
						$('#search_data').html("No Data Available");
						$('#infomsg').show();
					}
				}
				if(purpose_id==2)
				{
					if(output1!='')
					{
						$('#search_data').html(output1);
						$('#infomsg').show();
					}
					else
					{
						$('#search_data').html("No Data Available");
						$('#infomsg').show();
					}
				}
				if(purpose_id==3)
				{
					if(output2!='')
					{
						$('#search_data').html(output2);
						$('#infomsg').show();
					}
					else
					{
						$('#search_data').html("No Data Available");
						$('#infomsg').show();
					}
				}
				if(purpose_id==4)
				{
					if(output3!='')
					{
						$('#search_data').html(output3);
						$('#infomsg').show();
					}
					else
					{
						$('#search_data').html("No Data Available");
						$('#infomsg').show();
					}
				}
				if(purpose_id==5)
				{
					if(output4!='')
					{
						$('#search_data').html(output4);
						$('#infomsg').show();
					}
					else
					{
						$('#search_data').html("No Data Available");
						$('#infomsg').show();
					}
				}
				$('#purpose_id').select('');
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
	var urlx=base_url+'modify/delete_transaction';
	var id=td_Id.html();
	 $.ajax({
		url: urlx,
		type: 'POST',
		dataType: 'json',
		data: {'id':id},
		success:function(result)
		{	
			alert("Successfully Delete Transaction.");
		},
		error: function (jXHR, textStatus, errorThrown) {}
	}); 
	
	par.remove();
 
}	