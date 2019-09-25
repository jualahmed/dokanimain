$(document).ready(function() 
{
	$("#form_6").submit(function(event) 
	{
		event.preventDefault();
		var submiturl = $(this).attr('action');
		var methods = $(this).attr('method');
		var output = '';
		var output2 = '';
		var output3 = '';
		var all_ledger = '';
		var i=0;
		var k= 1;
		var mm= 0;
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
				for(i=0; i<result['cheque_status'].length; i++)
				{	
					if(result['cheque_status'][i].status=='inactive')
					{
						var status_name = 'Dishonoured';
					}
					else if(result['cheque_status'][i].status=='active')
					{
						var status_name = 'Honoured';
					}
					else
					{
						var status_name = 'Deleted';
					}
					if(result['cheque_status'][i].ledger_type == 'sale_collection')
					{
						all_ledger = '';
						for(var kkk=0; kkk<result['cheque_status'][i]['sale_ledger_name'].length; kkk++)
						{
							all_ledger+= result['cheque_status'][i]['sale_ledger_name'][kkk]['sale_ledger'];
						}
					}
					
					else if(result['cheque_status'][i].ledger_type =='purchase_payment')
					{
						all_ledger = '';
						for(var kkk=0; kkk<result['cheque_status'][i]['purchase_ledger_name'].length; kkk++)
						{
							all_ledger+= result['cheque_status'][i]['purchase_ledger_name'][kkk]['purchase_ledger'];
						}
					}
					else if(result['cheque_status'][i].ledger_type =='expense_payment')
					{
						all_ledger = '';
						for(var kkk=0; kkk<result['cheque_status'][i]['expense_ledger_name'].length; kkk++)
						{
							all_ledger+= result['cheque_status'][i]['expense_ledger_name'][kkk]['expense_ledger'];
						}
					}

					var amount = parseFloat(Math.round(result['cheque_status'][i].amount)).toFixed(2);
					output2+='<tr><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+k+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+result['cheque_status'][i].bb_id+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;">'+result['cheque_status'][i].cheque_date+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+result['cheque_status'][i].transaction_id+'">'+result['cheque_status'][i].transaction_id+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+all_ledger+'">'+all_ledger+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+result['cheque_status'][i].ledger_type+'">'+result['cheque_status'][i].ledger_type+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+result['cheque_status'][i].bank_name+'">'+result['cheque_status'][i].bank_name+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;overflow: hidden;text-overflow: ellipsis; white-space: nowrap;" title="'+result['cheque_status'][i].cheque_no+'">'+result['cheque_status'][i].cheque_no+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:right;">'+amount+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:center;">'+status_name+'</td><td style="font-family:Helvetica Neue,Helvetica,Arial,sans-serif;width:12px; font-size:12px;text-align:center;"><a class="btnEdit" style="cursor:pointer;"><i class="fa fa-fw fa-edit"></i></a></td></tr>';
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
					$('#down').show();
				}
				

				$('#cheque_status').val('');
				$('#cheque_status').select2();
			}
		});
	});

});

$(document).on("click", ".btnEdit", function() {
	var par = $(this).parent().parent();
	editr(par);
});
			
function editr(par) 
{
	var td_id = par.children("td:nth-child(2)"); 
	var td_transaction = par.children("td:nth-child(4)");
	var td_ledger_type = par.children("td:nth-child(6)");
	var td_amount = par.children("td:nth-child(9)"); 
	var td_status = par.children("td:nth-child(10)"); 
	var tdButtons = par.children("td:nth-child(11)"); 
	var urlx='<?php echo base_url();?>modify/cheque_status_edit';
	var id=td_id.html();
	$.ajax({
		url: urlx,
		type: 'POST',
		dataType: 'json',
		data: {'id':id},
		success:function(result){					
			td_status.html(result['snn']);						
			tdButtons.html("<a class='btnSave' style='cursor:pointer;'><i class='fa fa-fw fa-check'></i></a>");
		 
			},
		error: function (jXHR, textStatus, errorThrown) {}
	});

}
			
$(document).on("click", ".btnSave", function() {
var par = $(this).parent().parent();
saver(par);

});
	
function saver(par) 
{

	var td_id = par.children("td:nth-child(2)"); 
	var td_transaction = par.children("td:nth-child(4)");
	var td_ledger_type = par.children("td:nth-child(6)");
	var td_amount = par.children("td:nth-child(9)"); 
	var td_status = par.children("td:nth-child(10)"); 
	var tdButtons = par.children("td:nth-child(11)"); 
	
	var urlx='<?php echo base_url();?>modify/save_cheque_status_edit';
	var hid=td_id.html();
	var transaction=td_transaction.html();
	var ledger_type=td_ledger_type.html();
	var amount=td_amount.html();
	var status=td_status.find('.ssn').val();
	  $.ajax({
		url: urlx,
		type: 'POST',
		dataType: 'json',
		data: {'hid':hid,'transaction':transaction,'ledger_type':ledger_type,'amount':amount,'status':status},
		success:function(result)
		{	
			if(result.status=='inactive')
			{
				var status_name = 'Dishonoured';
			}
			else if(result.status=='active')
			{
				var status_name = 'Honoured';
			}
			else
			{
				var status_name = 'Deleted';
			}
		 
			td_status.html(status_name);
			tdButtons.html("<a class='btnEdit' style='cursor:pointer;'><i class='fa fa-fw fa-edit'></i></a></a>");
		},
		error: function (jXHR, textStatus, errorThrown) {}
	}); 

}