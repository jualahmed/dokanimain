$(document).ready(function() {
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

		window.open(submiturl,'_blank');
	});
	
});

$(document).on("click", ".btnEdit", function() 
{
	var par = $(this).parent().parent();
	editr(par);
	
});
	
function editr(par) 
{
	var tdserial = par.children("td:nth-child(1)"); 
	var td_Id = par.children("td:nth-child(2)");
	var td_staff_name = par.children("td:nth-child(3)");
	var td_staff_address = par.children("td:nth-child(4)");
	var td_staff_contact = par.children("td:nth-child(5)");
	var td_staff_type = par.children("td:nth-child(6)");
	var tdButtons = par.children("td:nth-child(7)"); 
	var urlx='<?php echo base_url();?>modify/staff_info_edit';
	var id=td_Id.html();
	$.ajax({
		url: urlx,
		type: 'POST',
		dataType: 'json',
		data: {'id':id},
		success:function(result){					
			td_staff_name.html("<input type='text' class='form-control ctd_staff_name' style='float:left;width: 100%;' value='"+td_staff_name.html()+"'/>");						
			td_staff_address.html("<input type='text' class='form-control ctd_staff_address' style='float:left;width:100%;' value='"+td_staff_address.html()+"'/>"); 
			td_staff_contact.html("<input type='text' class='form-control ctd_staff_contact' style='float:left;width:100%;' value='"+td_staff_contact.html()+"'/>"); 
			td_staff_type.html("<input type='text' class='form-control ctd_staff_type' style='float:left;width:100%;' value='"+td_staff_type.html()+"'/>"); 
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
	var tdserial = par.children("td:nth-child(1)"); 
	var td_Id = par.children("td:nth-child(2)");
	var td_staff_name = par.children("td:nth-child(3)");
	var td_staff_address = par.children("td:nth-child(4)");
	var td_staff_contact = par.children("td:nth-child(5)");
	var td_staff_type = par.children("td:nth-child(6)");
	var tdButtons = par.children("td:nth-child(7)"); 
	
	var urlx='<?php echo base_url();?>modify/save_staff_info_edit';
	var hid=td_Id.html();
	var staff_name=td_staff_name.find('.ctd_staff_name').val();
	var staff_address=td_staff_address.find('.ctd_staff_address').val();
	var staff_contact=td_staff_contact.find('.ctd_staff_contact').val();
	var staff_type=td_staff_type.find('.ctd_staff_type').val();

	  $.ajax({
		url: urlx,
		type: 'POST',
		dataType: 'json',
		data: {'hid':hid,'employee_name':staff_name,'employee_address':staff_address,'employee_contact_no':staff_contact,'employee_type':staff_type},
		success:function(result)
		{				
			td_staff_name.html(result.employee_name);
			td_staff_address.html(result.employee_address);
			td_staff_contact.html(result.employee_contact_no);
			td_staff_type.html(result.employee_type);
			tdButtons.html("<a class='btnEdit' style='cursor:pointer;'><i class='fa fa-fw fa-edit'></i></a> | <a class='btnDelete' style='cursor:pointer;'><i class='fa fa-fw fa-close'></i></a>");
		},
		error: function (jXHR, textStatus, errorThrown) {}
	}); 		
}
			
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
	var urlx='<?php echo base_url();?>modify/delete_staff';
	var id=td_Id.html();
	 $.ajax({
		url: urlx,
		type: 'POST',
		dataType: 'json',
		data: {'id':id},
		success:function(result)
		{	
			alert("Successfully Delete Staff.");
		},
		error: function (jXHR, textStatus, errorThrown) {}
	}); 
	
	par.remove();
 
}	